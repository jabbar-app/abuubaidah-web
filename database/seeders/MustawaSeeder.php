<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MustawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tamhidies = [
            ['kode_mk' => 'TLI101', 'mk' => 'Al – Lughoh Al Arabiyah - Tadribat wal Imlak', 'sks' => '8', 'umsu_semester' => '1', 'umsu_kode' => 'APIA120012', 'umsu_mk' => 'Bahasa Arab', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'LHA102', 'mk' => 'Al – Lughoh Al Arabiyah - Hiwar Aswath', 'sks' => '8', 'stebis_semester' => '1', 'stebis_kode' => 'STKK 1107', 'stebis_mk' => 'Bahasa Arab Ekonomi', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'TTQ103', 'mk' => 'Tilawah, Tahsin, Al Qur’an', 'sks' => '5', 'umsu_semester' => '2', 'umsu_kode' => 'APIA220042', 'umsu_mk' => 'Tahsin Al-Qur’an', 'stebis_semester' => '2', 'stebis_kode' => 'STKK 2102', 'stebis_mk' => 'Ulumul Quran'],
            ['kode_mk' => 'HAD104', 'mk' => 'Al Hadits', 'sks' => '3', 'stebis_semester' => '2', 'stebis_kode' => 'ESKK 2114', 'stebis_mk' => 'Pengantar Ekonomi Islam', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'KMH105', 'mk' => 'Kemuhammadiyahan', 'sks' => '1', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
        ];
        DB::table('mustawa_tamhidies')->insert($tamhidies);

        $awwals = [
            ['kode_mk' => 'FMQ201', 'mk' => 'Fahmul Maqru’ (qiroah)', 'sks' => '8', 'stebis_semester' => '7', 'stebis_kode' => 'ESPB 7115', 'stebis_mk' => 'Manajemen Pemasaran Syariah', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'TDL202', 'mk' => 'Tadribat Lughawiyah', 'sks' => '4', 'stebis_semester' => '3', 'stebis_kode' => 'STPK 3104', 'stebis_mk' => 'Akhlak dan Etika Bisnis', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'TBS203', 'mk' => 'Ta’bir Syafahiy', 'sks' => '4', 'umsu_semester' => '2', 'umsu_kode' => 'APIA230042', 'umsu_mk' => 'Insya’ Muhadatsah', 'stebis_semester' => '4', 'stebis_kode' => 'ESKK 4116', 'stebis_mk' => 'Ekonomi Mikro Islam'],
            ['kode_mk' => 'IMK204', 'mk' => 'Al Imla wal Khat', 'sks' => '1', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'AQT205', 'mk' => 'Al Qur’an (Tafsir & Tilawah)', 'sks' => '3', 'umsu_semester' => '2', 'umsu_kode' => 'APIA230053', 'umsu_mk' => 'Ulumul Qur’an', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'TBT206', 'mk' => 'Ta’bir Tahriry', 'sks' => '2', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'ASW207', 'mk' => 'Al Ashwat', 'sks' => '3', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
        ];
        DB::table('mustawa_awwals')->insert($awwals);

        $tsanis = [
            ['kode_mk' => 'TDR301', 'mk' => 'Tadribat', 'sks' => '6', 'stebis_semester' => '4', 'stebis_kode' => 'ESKB 4106', 'stebis_mk' => 'Ekonomi Pembangunan Syariah', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'HDS302', 'mk' => 'Al Hadits', 'sks' => '2', 'umsu_semester' => '2', 'umsu_kode' => 'APIA230063', 'umsu_mk' => 'Ulumul Hadits', 'stebis_semester' => '3', 'stebis_kode' => 'STKK 3103', 'stebis_mk' => 'Ulumul Hadis'],
            ['kode_mk' => 'TBT303', 'mk' => 'Ta’bir Tahriri', 'sks' => '2', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'TBS304', 'mk' => 'Ta’bir Syafahiy', 'sks' => '4', 'stebis_semester' => '5', 'stebis_kode' => 'ESKK 5118', 'stebis_mk' => 'Ekonomi Makro Islam', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'FMQ305', 'mk' => 'Fahmul Maqru’', 'sks' => '6', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'AQT306', 'mk' => 'Al Qur’an (Tafsir & Tilawah)', 'sks' => '3', 'umsu_semester' => '3', 'umsu_kode' => 'APIA330083', 'umsu_mk' => 'Tafsir Tarbawi', 'stebis_semester' => '3', 'stebis_kode' => 'STKK 3105', 'stebis_mk' => 'Tafsir Ayat Ekonomi'],
            ['kode_mk' => 'IMK307', 'mk' => 'Al Imla wal Khat', 'sks' => '2', 'umsu_semester' => '3', 'umsu_kode' => 'IMK307', 'umsu_mk' => 'Mata Kuliah Pilihan* Khot Arab Melayu', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
        ];
        DB::table('mustawa_tsanis')->insert($tsanis);

        $tsalits = [
            ['kode_mk' => 'AQD401', 'mk' => 'Al-Qawaid', 'sks' => '4', 'stebis_semester' => '3', 'stebis_kode' => 'STKB 3101', 'stebis_mk' => 'Qawa’id Fiqhiyah', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'ADB402', 'mk' => 'Al-adab', 'sks' => '3', 'umsu_semester' => '4', 'umsu_kode' => 'ADB402', 'umsu_mk' => 'Mata Kuliah Pilihan Ilmu Mantiq', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'FMQ403', 'mk' => 'Fahmul Maqru’', 'sks' => '3', 'stebis_semester' => '7', 'stebis_kode' => 'ESPB 7117', 'stebis_mk' => 'Seminar Ekonomi Bisnis Islam', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'TBS404', 'mk' => 'Ta’bir Syafahi', 'sks' => '3', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'IML405', 'mk' => 'Al-Imla’', 'sks' => '1', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'AQT406', 'mk' => 'Al Qur’an (Tafsir & Tilawah)', 'sks' => '2', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'TSK407', 'mk' => 'At-Tsaqofah', 'sks' => '1', 'umsu_semester' => '2', 'umsu_kode' => 'APIA220032', 'umsu_mk' => 'Filsafat Ilmu', 'stebis_semester' => '4', 'stebis_kode' => 'ESPB 6109', 'stebis_mk' => 'Sistem Keuangan Islam'],
            ['kode_mk' => 'TRK408', 'mk' => 'At-Tarikh Al-Islamiy', 'sks' => '1', 'umsu_semester' => '5', 'umsu_kode' => 'APIA650012', 'umsu_mk' => 'Sejarah Peradaban Islam', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'TWD409', 'mk' => 'Tauhid', 'sks' => '1', 'stebis_semester' => '1', 'stebis_kode' => 'STPK 1101', 'stebis_mk' => 'Tauhid (Teologi Ekonomi)', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'TBT410', 'mk' => 'Ta’bir Tahriri', 'sks' => '3', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'HDS411', 'mk' => 'Al Hadits', 'sks' => '2', 'umsu_semester' => '3', 'umsu_kode' => 'APIA330093', 'umsu_mk' => 'Hadits Tarbawi', 'stebis_semester' => '4', 'stebis_kode' => 'STKK 4106', 'stebis_mk' => 'Hadis Ekonomi'],
            ['kode_mk' => 'FQH412', 'mk' => 'Fiqih', 'sks' => '1', 'stebis_semester' => '2', 'stebis_kode' => 'STKB 2102', 'stebis_mk' => 'Fiqh Mu’amalah I', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
        ];
        DB::table('mustawa_tsalits')->insert($tsalits);

        $robi = [
            ['kode_mk' => 'FQH501', 'mk' => 'Fiqih', 'sks' => '1', 'umsu_semester' => '7', 'umsu_kode' => 'APIA750023', 'umsu_mk' => 'Fiqih Kontemporer', 'stebis_semester' => '2', 'stebis_kode' => 'STKK 2104', 'stebis_mk' => 'Fiqh'],
            ['kode_mk' => 'AQD502', 'mk' => 'Al-Qawaid', 'sks' => '3', 'stebis_semester' => '7', 'stebis_kode' => 'ESPB 7112', 'stebis_mk' => 'Seminar Ekonomi Moneter dan Keuangan Islam', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'TBS503', 'mk' => 'Ta’bir Syafahiy', 'sks' => '3', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'TBT504', 'mk' => 'Ta’bir Tahriri', 'sks' => '3', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'IML505', 'mk' => 'Imla’', 'sks' => '1', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'AQT506', 'mk' => 'Al Qur’an (Tafsir & Tilawah)', 'sks' => '2', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'HDS507', 'mk' => 'Al Hadits', 'sks' => '2', 'stebis_semester' => '4', 'stebis_kode' => 'STKB 4103', 'stebis_mk' => 'Fiqh Mu’amalah II', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'ADB508', 'mk' => 'Al-Adab', 'sks' => '2', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'TRK509', 'mk' => 'At-tarikh al-Islamy', 'sks' => '1', 'stebis_semester' => '6', 'stebis_kode' => 'STKB 6104', 'stebis_mk' => 'Sejarah Pemikiran Ekonomi Islam', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => ''],
            ['kode_mk' => 'BLG510', 'mk' => 'Al – Balagoh', 'sks' => '2', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'TWD511', 'mk' => 'At-Tauhid', 'sks' => '1', 'umsu_semester' => '7', 'umsu_kode' => 'APIA720012', 'umsu_mk' => 'Tasawuf Kontemporer', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'FMQ512', 'mk' => 'Fahmul Maqru’', 'sks' => '2', 'umsu_semester' => '', 'umsu_kode' => '', 'umsu_mk' => '', 'stebis_semester' => '', 'stebis_kode' => '', 'stebis_mk' => ''],
            ['kode_mk' => 'USF513', 'mk' => 'Ushul fiqih', 'sks' => '1', 'umsu_semester' => '7', 'umsu_kode' => 'APIA750013', 'umsu_mk' => 'Usul Fiqh', 'stebis_semester' => '4', 'stebis_kode' => 'STKK 3101', 'stebis_mk' => 'Ushul Fiqh'],
            ['kode_mk' => 'TSK514', 'mk' => 'At-Tsaqofah', 'sks' => '1', 'umsu_semester' => '6', 'umsu_kode' => 'APIA650062', 'umsu_mk' => 'Kapita Selekta Pendidikan', 'stebis_semester' => '6', 'stebis_kode' => 'ESPB 6109', 'stebis_mk' => 'Sistem Keuangan Islam'],
        ];

        DB::table('mustawa_robis')->insert($robi);
    }
}
