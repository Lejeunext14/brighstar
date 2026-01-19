<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LessonProgress;
use App\Models\User;

class LessonProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the student user (role = student)
        $student = User::where('role', 'student')->first();
        
        if (!$student) {
            echo "No student found. Please create a student user first.\n";
            return;
        }

        // Create sample Filipino lesson progress
        $lessons = [
            ['slug' => 'ang-alpabetong-filipino', 'name' => 'Ang Alpabetong Filipino'],
            ['slug' => 'ang-titik-aa', 'name' => 'Ang Titik A'],
            ['slug' => 'pag-papakilala-sa-sarili', 'name' => 'Pag-Papakilala sa Sarili'],
            ['slug' => 'mga-pagbati-ng-magalang', 'name' => 'Mga Pagbati ng Magalang'],
            ['slug' => 'ang-aking-pamilya', 'name' => 'Ang Aking Pamilya'],
        ];

        foreach ($lessons as $index => $lesson) {
            LessonProgress::updateOrCreate(
                [
                    'user_id' => $student->id,
                    'lesson_slug' => $lesson['slug'],
                ],
                [
                    'subject' => 'Filipino',
                    'lesson_name' => $lesson['name'],
                    'completed' => $index < 3, // First 3 are completed, rest are not
                    'points' => $index < 3 ? 10 : 0,
                ]
            );
        }

        echo "Created " . count($lessons) . " lesson progress records for student ID: " . $student->id . "\n";
    }
}
