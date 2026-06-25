<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DoctorSchedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today()->format('Y-m-d');

        DoctorSchedule::create([
            'doctor_id' => 1,
            'schedule_date' => $today,
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 12,
            'interval_minutes' => 15,
        ]);

        DoctorSchedule::create([
            'doctor_id' => 2,
            'schedule_date' => $today,
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'quota' => 10,
            'interval_minutes' => 15,
        ]);

        DoctorSchedule::create([
            'doctor_id' => 3,
            'schedule_date' => $today,
            'start_time' => '13:00:00',
            'end_time' => '16:00:00',
            'quota' => 12,
            'interval_minutes' => 15,
        ]);
    }
}
