<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class VoiceOverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $musicPath = public_path('music');
        
        // Define lesson subjects and their directory mappings
        $subjects = [
            'bahagi_ng_katawan' => [
                'subject' => 'Bahagi ng Katawan',
                'lessons' => [
                    'bibig' => 'Bibig (Mouth)',
                    'binti' => 'Binti (Leg)',
                    'ilong' => 'Ilong (Nose)',
                    'kamay' => 'Kamay (Hand)',
                    'mata' => 'Mata (Eyes)',
                    'paa' => 'Paa (Feet)',
                    'ulo' => 'Ulo (Head)',
                ]
            ],
            'kulay' => [
                'subject' => 'Kulay',
                'lessons' => [
                    'asul' => 'Asul (Blue)',
                    'dilaw' => 'Dilaw (Yellow)',
                    'itim' => 'Itim (Black)',
                    'luntian' => 'Luntian (Green)',
                    'pula' => 'Pula (Red)',
                    'puti' => 'Puti (White)',
                ]
            ],
            'mga_hugis' => [
                'subject' => 'Mga Hugis',
                'lessons' => [
                    'bilog' => 'Bilog (Circle)',
                    'hexaguno' => 'Hexaguno (Hexagon)',
                    'pentagon' => 'Pentagon (Pentagon)',
                    'rektangulo' => 'Rektangulo (Rectangle)',
                    'tatsulok' => 'Tatsulok (Triangle)',
                ]
            ],
            'ang_aking_pamilya' => [
                'subject' => 'Ang Aking Pamilya',
                'lessons' => [
                    'ang-aking-pamilya' => 'Ang Aking Pamilya (My Family)',
                ]
            ],
        ];

        $synced = 0;
        $notFound = [];

        // Get or create first student
        $student = User::where('role', 'student')->first();
        
        if (!$student) {
            echo "No student found. Creating one for voice over testing...\n";
            $student = User::create([
                'name' => 'Student',
                'email' => 'student@example.com',
                'password' => bcrypt('password'),
                'role' => 'student',
            ]);
        }

        foreach ($subjects as $directory => $subjectInfo) {
            $subjectPath = $musicPath . DIRECTORY_SEPARATOR . $directory;
            
            if (!File::isDirectory($subjectPath)) {
                echo "Directory not found: {$directory}\n";
                continue;
            }

            foreach ($subjectInfo['lessons'] as $lessonKey => $lessonName) {
                // Create slug from lesson key
                $slug = Str::slug($lessonKey);
                
                // Look for voice over file
                $files = File::files($subjectPath);
                $voiceFile = null;

                foreach ($files as $file) {
                    $filename = strtolower($file->getFilename());
                    // Special matching for ang-aking-pamilya: look for 'pamilya' in filename
                    $searchKey = ($lessonKey === 'ang-aking-pamilya') ? 'pamilya' : $lessonKey;
                    // Match files containing the lesson key or search key
                    if (stripos($filename, $searchKey) !== false) {
                        $voiceFile = 'music/' . $directory . '/' . $file->getFilename();
                        break;
                    }
                }

                if (!$voiceFile) {
                    $notFound[] = "$directory - $lessonName";
                    continue;
                }

                // Create or update lesson progress with voice over
                LessonProgress::updateOrCreate(
                    [
                        'user_id' => $student->id,
                        'lesson_slug' => $slug,
                    ],
                    [
                        'subject' => $subjectInfo['subject'],
                        'lesson_name' => $lessonName,
                        'voice_over_path' => $voiceFile,
                        'completed' => false,
                        'points' => 0,
                    ]
                );

                $synced++;
                echo "✓ Synced: {$lessonName} -> {$voiceFile}\n";
            }
        }

        echo "\n=== Voice Over Sync Complete ===\n";
        echo "Synced: {$synced} voice overs\n";
        
        if (!empty($notFound)) {
            echo "Not found: " . count($notFound) . "\n";
            foreach ($notFound as $item) {
                echo "  - {$item}\n";
            }
        }
    }
}
