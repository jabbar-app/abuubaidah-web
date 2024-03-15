<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Bukayo Saka',
            'email' => 'saka@gmail.com',
            'password' => bcrypt('Test1234!'),
        ]);

        User::factory()->create([
            'role' => 'Super Admin',
            'name' => 'Mhd. Musthafa Kamal P.',
            'email' => 'admin@abuubaidah.com',
            'password' => bcrypt('Test1234!'),
        ]);

        $program = [
            [
              'batch' => '18',
              'title' => 'Tahsin Tilawah Al-Qur\'an',
              'description' => 'Program Tahsin merupakan inisiatif pendidikan yang ditujukan untuk meningkatkan kemampuan peserta dalam aspek bacaan Al-Quran dengan tajwid yang tepat.',
              'option' => '["Kelas Offline (Luring)", ", Kelas Online (Daring)"]',
              'price_normal' => 675000,
              'price_alumni' => 600000,
              'status' => true,
            ],
            [
              'batch' => '8',
              'title' => 'Beasiswa Tahfiz Al-Qur\'an',
              'description' => 'Program "Tahfiz Al-Qur\'an" adalah inisiatif yang dirancang khusus untuk membantu peserta menghafal Al-Qur\'an.',
              'option' => '["Kelas Offline (Luring)"]',
              'price_normal' => 0,
              'price_alumni' => 0,
              'status' => false,
            ],
            [
              'batch' => '1',
              'title' => 'Kursus Intensif Bahasa Arab',
              'description' => 'Kursus Intensif Bahasa Arab',
              'option' => '["Kelas Offline (Luring)"]',
              'price_normal' => 0,
              'price_alumni' => 0,
              'status' => false,
            ],
            [
              'batch' => '1',
              'title' => 'Program Bahasa Arab & Studi Islam',
              'description' => 'Program Bahasa Arab & Studi Islam',
              'option' => '["Kelas Offline (Luring)"]',
              'price_regist' => 275000,
              'price_normal' => 315000,
              'price_alumni' => 0,
              'status' => false,
            ],
            [
              'batch' => '1',
              'title' => 'Integrasi S1 Ma\'had - FAI UMSU',
              'description' => 'Integrasi S1 Ma\'had - FAI UMSU',
              'option' => '["Kelas Offline (Luring)"]',
              'price_normal' => 0,
              'price_alumni' => 0,
              'status' => false,
            ],
            [
              'batch' => '1',
              'title' => 'Integrasi S1 STEBIS AL ULUM Terpadu',
              'description' => 'Integrasi S1 STEBIS AL ULUM Terpadu',
              'option' => '["Kelas Offline (Luring)"]',
              'price_normal' => 0,
              'price_alumni' => 0,
              'status' => false,
            ],
            [
              'batch' => '1',
              'title' => 'BILHAQ',
              'description' => 'Bimbingan Menghafal Al-Qur\'an',
              'option' => '["Kelas Offline (Luring)"]',
              'price_normal' => 0,
              'price_alumni' => 0,
              'status' => true,
            ],
          ];

          foreach ($program as $p) {
            Program::create($p);
          }
    }
}
