<?php

namespace Database\Seeders;

use App\Models\DoctorSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DoctorSchedule::updateOrCreate([
            'doctor_name' => 'dr. Andi Pratama',
            'schedule_date' => '2026-06-25',
            'start_time' => '09:00',
        ], [
            'specialization' => 'Penyakit Dalam',
            'end_time' => '11:00',
            'status' => 'available',
        ]);

        DoctorSchedule::updateOrCreate([
            'doctor_name' => 'dr. Siti Rahma',
            'schedule_date' => '2026-06-25',
            'start_time' => '13:00',
        ], [
            'specialization' => 'Anak',
            'end_time' => '15:00',
            'status' => 'available',
        ]);
    }
}
