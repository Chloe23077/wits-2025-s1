<?php

namespace Tests\Feature\Api\Timetable\V1;

use App\Models\Package;
use App\Models\User;
use App\Models\Course;
use App\Models\Cluster;
use App\Models\Timetable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimetableEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_updating_timetable()
    {
        $package = Package::create([
            'national_code' => 'ABC123',
            'title' => 'Test Package',
            'tga_status' => 'Current',
        ]);

        $user = User::create([
            'given_name' => 'Luis',
            'family_name' => 'Alvarez',
            'email' => 'luis.alvarez@example.org',
            'password' => bcrypt('password'),
        ]);

        $course = Course::create([
            'national_code' => 'A123',
            'aqf_level' => '5',
            'title' => 'Course Title',
            'state_code' => 'AZN5',
            'nominal_hours' => 665,
            'type' => 'Qualification',
            'package_id' => $package->id,
        ]);

        $cluster = Cluster::create([
            'code' => 'ADVPROG',
            'title' => 'Advanced Programming',
            'qualification' => 'ICT50220',
            'state_code' => 'AC21',
        ]);

        $timetable = Timetable::create([
            'course_id' => $course->id,
            'cluster_id' => $cluster->id,
            'start_date' => '2025-05-12',
            'start_time' => '09:00',
            'session_duration' => 90,
            'lecturer_id' => $user->id,
        ]);

        $updatedData = [
            'start_time' => '10:30',
            'session_duration' => 120,
        ];

        $response = $this->actingAs($user, 'sanctum')->put("/api/v1/timetables/{$timetable->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Timetable updated successfully.']);
        $this->assertDatabaseHas('timetables', [
            'id' => $timetable->id,
            'start_time' => '10:30',
        ]);
    }
}

