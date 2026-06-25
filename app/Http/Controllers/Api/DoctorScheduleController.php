<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Doctor Schedule",
    description: "API Jadwal Dokter"
)]
class DoctorScheduleController extends Controller
{
    private function meta(): array
    {
        return [
            "service_name" => "JadwalDokter-Service",
            "api_version" => "v1"
        ];
    }

    #[OA\Get(
        path: "/api/v1/schedules",
        summary: "Ambil semua slot jadwal dokter yang tersedia",
        tags: ["Doctor Schedule"],
        security: [["ApiKeyAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "Success")
        ]
    )]
    public function index()
    {
        return response()->json([
            "status" => "success",
            "message" => "Data retrieved successfully",
            "data" => DoctorSchedule::where("status", "available")->get(),
            "meta" => $this->meta()
        ]);
    }

    #[OA\Get(
        path: "/api/v1/schedules/{id}",
        summary: "Ambil detail jadwal dokter",
        tags: ["Doctor Schedule"],
        security: [["ApiKeyAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Success"),
            new OA\Response(response: 404, description: "Not Found")
        ]
    )]
    public function show($id)
    {
        $data = DoctorSchedule::find($id);

        if (!$data) {
            return response()->json([
                "status" => "error",
                "message" => "Data not found",
                "errors" => null
            ], 404);
        }

        return response()->json([
            "status" => "success",
            "message" => "Data retrieved successfully",
            "data" => $data,
            "meta" => $this->meta()
        ]);
    }

    #[OA\Post(
        path: "/api/v1/schedules",
        summary: "Konfirmasi booking slot jadwal dokter",
        tags: ["Doctor Schedule"],
        security: [["ApiKeyAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "schedule_id", type: "integer"),
                    new OA\Property(property: "doctor_name", type: "string"),
                    new OA\Property(property: "specialization", type: "string"),
                    new OA\Property(property: "schedule_date", type: "string"),
                    new OA\Property(property: "start_time", type: "string"),
                    new OA\Property(property: "end_time", type: "string")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Created")
        ]
    )]
    public function store(Request $request)
    {
        if ($request->filled("schedule_id") || $request->filled("id")) {
            $validated = $request->validate([
                "schedule_id" => ["sometimes", "integer"],
                "id" => ["sometimes", "integer"],
            ]);

            $scheduleId = $validated["schedule_id"] ?? $validated["id"];
            $schedule = DoctorSchedule::find($scheduleId);

            if (!$schedule) {
                return response()->json([
                    "status" => "error",
                    "message" => "Data not found",
                    "errors" => null
                ], 404);
            }

            if ($schedule->status === "booked") {
                return response()->json([
                    "status" => "error",
                    "message" => "Schedule already booked",
                    "errors" => null
                ], 409);
            }

            $schedule->update(["status" => "booked"]);

            return response()->json([
                "status" => "success",
                "message" => "Schedule booked successfully",
                "data" => $schedule->fresh(),
                "meta" => $this->meta()
            ], 201);
        }

        $validated = $request->validate([
            "doctor_name" => ["required", "string", "max:255"],
            "specialization" => ["required", "string", "max:255"],
            "schedule_date" => ["required", "date"],
            "start_time" => ["required", "date_format:H:i"],
            "end_time" => ["required", "date_format:H:i", "after:start_time"],
            "status" => ["sometimes", Rule::in(["available", "booked"])],
        ]);

        $data = DoctorSchedule::create([
            ...$validated,
            "status" => $validated["status"] ?? "booked",
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Schedule booked successfully",
            "data" => $data,
            "meta" => $this->meta()
        ], 201);
    }
}
