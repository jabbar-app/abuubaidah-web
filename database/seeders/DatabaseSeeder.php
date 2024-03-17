<?php

namespace Database\Seeders;

use App\Models\Bilhaq;
use App\Models\Fai;
use App\Models\Kiba;
use App\Models\Lughoh;
use App\Models\Program;
use App\Models\Sesi;
use App\Models\Stebis;
use App\Models\Tahfiz;
use App\Models\Tahsin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $role = [
            ['name' => 'Super Admin'],
            ['name' => 'Accountant'],
            ['name' => 'Admin Tahsin'],
            ['name' => 'Admin Tahfiz'],
            ['name' => 'Admin Bilhaq'],
            ['name' => 'Admin KIBA'],
            ['name' => 'Admin Lughoh'],
            ['name' => 'Admin Stebis'],
            ['name' => 'Admin FAI'],
        ];

        foreach ($role as $p) {
            Role::create($p);
        }

        // Example of defining a permission
        Permission::create(['name' => 'edit_kelas']);

        $users = [
            [
                'name' => 'Mhd. Musthafa Kamal P.',
                'nik' => '1',
                'email' => 'admin@abuubaidah.com',
                'phone' => '1',
                'password' => bcrypt('Test1234!')
            ],
            [
                'name' => 'Ust. Accountant',
                'nik' => '2',
                'email' => 'accountant@abuubaidah.com',
                'phone' => '2',
                'password' => bcrypt('Test1234!')
            ],
            [
                'name' => 'Admin Tahsin',
                'nik' => '3',
                'email' => 'tahsin@abuubaidah.com',
                'phone' => '3',
                'password' => bcrypt('Test1234!')
            ],
            [
                'name' => 'Admin Tahfiz',
                'nik' => '4',
                'email' => 'tahfiz@abuubaidah.com',
                'phone' => '4',
                'password' => bcrypt('Test1234!')
            ],
            [
                'name' => 'Admin Bilhaq',
                'nik' => '5',
                'email' => 'bilhaq@abuubaidah.com',
                'phone' => '5',
                'password' => bcrypt('Test1234!')
            ],
            [
                'name' => 'Admin KIBA',
                'nik' => '6',
                'email' => 'kiba@abuubaidah.com',
                'phone' => '6',
                'password' => bcrypt('Test1234!')
            ],
            [
                'name' => 'Admin Lughoh',
                'nik' => '7',
                'email' => 'lughoh@abuubaidah.com',
                'phone' => '7',
                'password' => bcrypt('Test1234!')
            ],
            [
                'name' => 'Admin Stebis',
                'nik' => '8',
                'email' => 'stebis@abuubaidah.com',
                'phone' => '8',
                'password' => bcrypt('Test1234!')
            ],
            [
                'name' => 'Admin FAI',
                'nik' => '9',
                'email' => 'fai@abuubaidah.com',
                'phone' => '9',
                'password' => bcrypt('Test1234!')
            ],
            [
                'name' => 'Bukayo Saka',
                'nik' => '12051703031993002',
                'email' => 'saka@gmail.com',
                'phone' => '6289620791751',
                'password' => bcrypt('Test1234!'),
            ],
            // [
            //     'name' => 'Martin Odeegard',
            //     'nik' => '12051703031993003',
            //     'email' => 'odeegard@gmail.com',
            //     'phone' => '6289620791752',
            //     'password' => bcrypt('Test1234!'),
            // ],
        ];

        foreach ($users as $p) {
            User::create($p);
        }

        $user = User::find(1);
        $user->assignRole('Super Admin');
        $user = User::find(2);
        $user->assignRole('Accountant');
        $user = User::find(3);
        $user->assignRole('Admin Tahsin');
        $user = User::find(4);
        $user->assignRole('Admin Tahfiz');
        $user = User::find(5);
        $user->assignRole('Admin Bilhaq');
        $user = User::find(6);
        $user->assignRole('Admin KIBA');
        $user = User::find(7);
        $user->assignRole('Admin Lughoh');
        $user = User::find(8);
        $user->assignRole('Admin Stebis');
        $user = User::find(9);
        $user->assignRole('Admin FAI');

        $originalData = ['jadwal' => '["Sabtu 1 (08.00-10.00 WIB)","Sabtu 2 (10.15-12.15 WIB)","Sabtu 3 (13.00-15.00 WIB)","Sabtu 4 (16.00-18.00 WIB)","Ahad 1 (08.00-10.00 WIB)","Ahad 2 (10.15-12.15 WIB)","Ahad 3 (13.00-15.00 WIB)","Ahad 4 (16.00-18.00 WIB)"]'];

        $jadwalArray = json_decode($originalData['jadwal'], true);

        foreach ($jadwalArray as $jadwalItem) {
            Sesi::create(['jadwal' => $jadwalItem]);
        }


        $tahsins = [
            [
                'batch' => '18',
                'title' => 'Tahsin Tilawah Al-Qur\'an',
                'option' => '["Kelas Offline (Luring)", "Kelas Online (Daring)"]',
                'description' => 'Program Tahsin merupakan inisiatif pendidikan yang ditujukan untuk meningkatkan kemampuan peserta dalam aspek bacaan Al-Quran dengan tajwid yang tepat.',
                'price_normal' => '700000',
                'price_alumni' => '625000',
                'session' => '["Sabtu 1 (08.00-10.00 WIB)","Sabtu 2 (10.15-12.15 WIB)","Sabtu 3 (13.00-15.00 WIB)","Sabtu 4 (16.00-18.00 WIB)","Ahad 1 (08.00-10.00 WIB)","Ahad 2 (10.15-12.15 WIB)","Ahad 3 (13.00-15.00 WIB)","Ahad 4 (16.00-18.00 WIB)"]',
                'status' => true
            ],
            // [
            //     'batch' => '1',
            //     'title' => 'Tahsin Tilawah Al-Qur\'an Kids',
            //     'option' => '["Kelas Offline (Luring)", "Kelas Online (Daring)"]',
            //     'description' => 'Program Tahsin merupakan inisiatif pendidikan yang ditujukan untuk meningkatkan kemampuan peserta dalam aspek bacaan Al-Quran dengan tajwid yang tepat.',
            //     'price_normal' => '700000',
            //     'price_alumni' => '625000',
            //     'session' => '["Sabtu 1 (08.00-10.00 WIB)","Sabtu 2 (10.15-12.15 WIB)","Sabtu 3 (13.00-15.00 WIB)","Sabtu 4 (16.00-18.00 WIB)","Ahad 1 (08.00-10.00 WIB)","Ahad 2 (10.15-12.15 WIB)","Ahad 3 (13.00-15.00 WIB)","Ahad 4 (16.00-18.00 WIB)"]',
            //     'status' => true
            // ],
        ];

        foreach ($tahsins as $tahsin) {
            Tahsin::create($tahsin);
        }

        Bilhaq::create([
            'batch' => '1',
            'title' => 'Bimbingan Menghafal Al-Qur\'an',
            'option' => '["Kelas Offline (Luring)"]',
            'description' => 'Bimbingan Menghafal Al-Qur\'an',
            'status' => true,
        ]);

        Tahfiz::create([
            'batch' => '8',
            'title' => 'Beasiswa Tahfiz Al-Qur\'an',
            'option' => '["Kelas Offline (Luring)"]',
            'description' => 'Program "Tahfiz Al-Qur\'an" adalah inisiatif yang dirancang khusus untuk membantu peserta menghafal Al-Qur\'an.',
            'status' => true,
        ]);

        Kiba::create([
            'batch' => '8',
            'title' => 'Kursus Intensif Bahasa Arab',
            'option' => '["Kelas Offline (Luring)"]',
            'description' => 'Kursus Intensif Bahasa Arab',
            'status' => true,
        ]);

        Lughoh::create([
            'batch' => '8',
            'title' => 'Program Bahasa Arab & Studi Islam',
            'option' => '["Kelas Offline (Luring)"]',
            'description' => 'Program Bahasa Arab & Studi Islam',
            'status' => true,
        ]);

        Fai::create([
            'batch' => '8',
            'title' => 'Integrasi S1 Ma\'had - FAI UMSU',
            'option' => '["Kelas Offline (Luring)"]',
            'description' => 'Integrasi S1 Ma\'had - FAI UMSU.',
            'status' => true,
        ]);

        Stebis::create([
            'batch' => '8',
            'title' => 'Integrasi S1 STEBIS AL ULUM Terpadu',
            'option' => '["Kelas Offline (Luring)"]',
            'description' => 'Integrasi S1 STEBIS AL ULUM Terpadu.',
            'status' => true,
        ]);

        // $program = [
        //   [
        //     'template_id' => '18',
        //     'batch' => '18',
        //     'title' => 'Tahsin Tilawah Al-Qur\'an',
        //     'description' => 'Program Tahsin merupakan inisiatif pendidikan yang ditujukan untuk meningkatkan kemampuan peserta dalam aspek bacaan Al-Quran dengan tajwid yang tepat.',
        //     'option' => '["Kelas Offline (Luring)", "Kelas Online (Daring)"]',
        //     'price_normal' => 675000,
        //     'price_alumni' => 600000,
        //     'deadline' => date('2024-12-12'),
        //     'status' => true,
        //   ],
        //   [
        //     'template_id' => '8',
        //     'batch' => '8',
        //     'title' => 'Beasiswa Tahfiz Al-Qur\'an',
        //     'description' => 'Program "Tahfiz Al-Qur\'an" adalah inisiatif yang dirancang khusus untuk membantu peserta menghafal Al-Qur\'an.',
        //     'option' => '["Kelas Offline (Luring)"]',
        //     'price_normal' => 0,
        //     'price_alumni' => 0,
        //     'deadline' => date('2024-12-12'),
        //     'status' => true,
        //   ],
        //   [
        //     'template_id' => '1',
        //     'batch' => '1',
        //     'title' => 'Kursus Intensif Bahasa Arab',
        //     'description' => 'Kursus Intensif Bahasa Arab',
        //     'option' => '["Kelas Offline (Luring)"]',
        //     'price_normal' => 0,
        //     'price_alumni' => 0,
        //     'deadline' => date('2024-12-12'),
        //     'status' => true,
        //   ],
        //   [
        //     'template_id' => '1',
        //     'batch' => '1',
        //     'title' => 'Program Bahasa Arab & Studi Islam',
        //     'description' => 'Program Bahasa Arab & Studi Islam',
        //     'option' => '["Kelas Offline (Luring)"]',
        //     'price_regist' => 275000,
        //     'price_normal' => 315000,
        //     'price_alumni' => 0,
        //     'deadline' => date('2024-12-12'),
        //     'status' => true,
        //   ],
        //   [
        //     'template_id' => '1',
        //     'batch' => '1',
        //     'title' => 'Integrasi S1 Ma\'had - FAI UMSU',
        //     'description' => 'Integrasi S1 Ma\'had - FAI UMSU',
        //     'option' => '["Kelas Offline (Luring)"]',
        //     'price_normal' => 0,
        //     'price_alumni' => 0,
        //     'deadline' => date('2024-12-12'),
        //     'status' => true,
        //   ],
        //   [
        //     'template_id' => '1',
        //     'batch' => '1',
        //     'title' => 'Integrasi S1 STEBIS AL ULUM Terpadu',
        //     'description' => 'Integrasi S1 STEBIS AL ULUM Terpadu',
        //     'option' => '["Kelas Offline (Luring)"]',
        //     'price_normal' => 0,
        //     'price_alumni' => 0,
        //     'deadline' => date('2024-12-12'),
        //     'status' => true,
        //   ],
        //   [
        //     'template_id' => '1',
        //     'batch' => '1',
        //     'title' => 'BILHAQ',
        //     'description' => 'Bimbingan Menghafal Al-Qur\'an',
        //     'option' => '["Kelas Offline (Luring)"]',
        //     'price_normal' => 1000,
        //     'price_alumni' => 1000,
        //     'deadline' => date('2024-12-12'),
        //     'status' => true,
        //   ],
        // ];

        // foreach ($program as $p) {
        //   Program::create($p);
        // }
    }
}
