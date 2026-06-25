<?php

namespace Tests\Feature;

use App\Models\DoctorSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleContractTest extends TestCase
{
    use RefreshDatabase;

    private array $headers = ['X-IAE-KEY' => '102022400220'];

    public function test_api_key_is_required(): void
    {
        $this->getJson('/api/v1/schedules')
            ->assertStatus(401)
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized (Invalid API Key)',
                'errors' => null,
            ]);
    }

    public function test_can_list_available_schedules(): void
    {
        DoctorSchedule::create([
            'doctor_name' => 'dr. Andi Pratama',
            'specialization' => 'Penyakit Dalam',
            'schedule_date' => '2026-06-25',
            'start_time' => '09:00',
            'end_time' => '11:00',
            'status' => 'available',
        ]);

        $this->getJson('/api/v1/schedules', $this->headers)
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('meta.service_name', 'JadwalDokter-Service')
            ->assertJsonCount(1, 'data');
    }

    public function test_missing_schedule_returns_404_wrapper(): void
    {
        $this->getJson('/api/v1/schedules/999', $this->headers)
            ->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Data not found',
                'errors' => null,
            ]);
    }

    public function test_can_book_a_schedule(): void
    {
        $schedule = DoctorSchedule::create([
            'doctor_name' => 'dr. Siti Rahma',
            'specialization' => 'Anak',
            'schedule_date' => '2026-06-25',
            'start_time' => '13:00',
            'end_time' => '15:00',
            'status' => 'available',
        ]);

        $this->postJson('/api/v1/schedules', ['schedule_id' => $schedule->id], $this->headers)
            ->assertCreated()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.status', 'booked');
    }

    public function test_graphql_introspection_and_swagger_are_available(): void
    {
        $this->postJson('/graphql', [
            'query' => '{ __schema { queryType { name } } }',
        ])->assertOk()
            ->assertJsonPath('data.__schema.queryType.name', 'Query');

        $this->get('/api/documentation')->assertOk();
    }
}
