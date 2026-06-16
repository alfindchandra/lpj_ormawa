<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Period;
use App\Models\Kabinet;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================
        // USERS
        // =========================================================

        // Admin
        User::create([
            'name'               => 'Admin Kemahasiswaan',
            'email'              => 'admin@ikippgribojonegoro.ac.id',
            'password'           => Hash::make('password'),
            'role'               => 'admin',
            'email_verified_at'  => now(),
        ]);

        // BEM
        User::create([
            'name'               => 'BEM IKIP PGRI Bojonegoro',
            'email'              => 'bem@ikippgribojonegoro.ac.id',
            'password'           => Hash::make('password'),
            'role'               => 'bem',
            'ormawa_name'        => 'BEM IKIP',
            'email_verified_at'  => now(),
        ]);

        // HMP — Himpunan Mahasiswa Program Studi
        $hmpList = [
            ['name' => 'HMPTI',      'label' => 'HMPTI (Teknik Informatika)'],
            ['name' => 'HMPP',       'label' => 'HMPP (Pendidikan Pancasila)'],
            ['name' => 'HMPPKN',     'label' => 'HMPPKN (PPKn)'],
            ['name' => 'HMPBSI',     'label' => 'HMPBSI (Bahasa & Sastra Indonesia)'],
        ];

        foreach ($hmpList as $hmp) {
            User::create([
                'name'               => 'Ketua ' . $hmp['name'],
                'email'              => strtolower(str_replace(' ', '', $hmp['name'])) . '@ikippgribojonegoro.ac.id',
                'password'           => Hash::make('password'),
                'role'               => 'hmp',
                'ormawa_name'        => $hmp['name'],
                'phone'              => '08123456789',
                'email_verified_at'  => now(),
            ]);
        }

        // UKM — Unit Kegiatan Mahasiswa
        $ukmList = [
            'UKM ALAM',
            'UKM KSR',
            'UKM Taekwondo',
            'UKM Pramuka',
        ];

        foreach ($ukmList as $ukm) {
            User::create([
                'name'               => 'Ketua ' . $ukm,
                'email'              => strtolower(str_replace(' ', '', $ukm)) . '@ikippgribojonegoro.ac.id',
                'password'           => Hash::make('password'),
                'role'               => 'ukm',
                'ormawa_name'        => $ukm,
                'phone'              => '08123456789',
                'email_verified_at'  => now(),
            ]);
        }

        // =========================================================
        // PERIODE
        // =========================================================

        // Periode lama (sudah selesai)
        $period2023 = Period::create([
            'nama_periode'  => 'Periode 2023/2024',
            'tahun_mulai'   => 2023,
            'tahun_selesai' => 2024,
            'is_active'     => false,
        ]);

        // Periode aktif
        $period2024 = Period::create([
            'nama_periode'  => 'Periode 2024/2025',
            'tahun_mulai'   => 2024,
            'tahun_selesai' => 2025,
            'is_active'     => true,
        ]);

        // =========================================================
        // KABINET PENGURUS INTI — Periode 2023/2024 (Riwayat)
        // =========================================================

        Kabinet::create([
            'period_id'        => $period2023->id,
            'ormawa_type'      => 'bem',
            'ormawa_name'      => 'BEM IKIP',
            'nama_kabinet'     => 'Kabinet Bumi Pertiwi',
            'nama_ketua'       => 'Rifqi Andika Pratama',
            'nama_wakil'       => 'Nadia Rahmawati',
            'nama_bendahara'   => 'Siti Mardiyah',
            'nama_sekretaris'  => 'Bagas Prasetyo',
            'tanggal_dilantik' => '2023-09-01',
            'tanggal_selesai'  => '2024-08-31',
            'is_active'        => false,
            'keterangan'       => 'Periode kepengurusan 2023/2024',
        ]);

        Kabinet::create([
            'period_id'        => $period2023->id,
            'ormawa_type'      => 'hmp',
            'ormawa_name'      => 'HMPTI',
            'nama_kabinet'     => 'Kabinet Inovasi',
            'nama_ketua'       => 'Dendi Kurniawan',
            'nama_wakil'       => 'Anggi Setiawan',
            'nama_bendahara'   => 'Yuliana Putri',
            'nama_sekretaris'  => 'Fajar Nugraha',
            'tanggal_dilantik' => '2023-09-15',
            'tanggal_selesai'  => '2024-09-14',
            'is_active'        => false,
            'keterangan'       => 'Kepengurusan HMPTI periode lalu',
        ]);

        Kabinet::create([
            'period_id'        => $period2023->id,
            'ormawa_type'      => 'ukm',
            'ormawa_name'      => 'UKM KSR',
            'nama_kabinet'     => null,
            'nama_ketua'       => 'Wahyu Hidayat',
            'nama_wakil'       => 'Rina Septiani',
            'nama_bendahara'   => 'Eko Prasetyo',
            'nama_sekretaris'  => 'Dewi Lestari',
            'tanggal_dilantik' => '2023-10-01',
            'tanggal_selesai'  => '2024-09-30',
            'is_active'        => false,
            'keterangan'       => '',
        ]);

        // =========================================================
        // KABINET PENGURUS INTI — Periode 2024/2025 (Aktif)
        // =========================================================

        Kabinet::create([
            'period_id'        => $period2024->id,
            'ormawa_type'      => 'bem',
            'ormawa_name'      => 'BEM IKIP',
            'nama_kabinet'     => 'Kabinet Cakrawala',
            'nama_ketua'       => 'Muhammad Fauzan Al-Hafidz',
            'nama_wakil'       => 'Salsabila Nur Azizah',
            'nama_bendahara'   => 'Rizky Aditya Pratama',
            'nama_sekretaris'  => 'Anisa Fitriani',
            'tanggal_dilantik' => '2024-09-01',
            'tanggal_selesai'  => '2025-08-31',
            'is_active'        => true,
            'keterangan'       => 'Kabinet BEM periode aktif 2024/2025',
        ]);

        Kabinet::create([
            'period_id'        => $period2024->id,
            'ormawa_type'      => 'hmp',
            'ormawa_name'      => 'HMPTI',
            'nama_kabinet'     => 'Kabinet Digitech',
            'nama_ketua'       => 'Arif Rahman Hakim',
            'nama_wakil'       => 'Putri Melinda Sari',
            'nama_bendahara'   => 'Budi Santoso',
            'nama_sekretaris'  => 'Eka Setiyaningsih',
            'tanggal_dilantik' => '2024-09-15',
            'tanggal_selesai'  => '2025-09-14',
            'is_active'        => true,
            'keterangan'       => 'HMPTI Teknik Informatika periode aktif',
        ]);

        Kabinet::create([
            'period_id'        => $period2024->id,
            'ormawa_type'      => 'hmp',
            'ormawa_name'      => 'HMPP',
            'nama_kabinet'     => 'Kabinet Pancasila Muda',
            'nama_ketua'       => 'Dani Wahyu Prasetyo',
            'nama_wakil'       => 'Nur Aini Rahmawati',
            'nama_bendahara'   => 'Sigit Prabowo',
            'nama_sekretaris'  => 'Layla Fitriyani',
            'tanggal_dilantik' => '2024-09-20',
            'tanggal_selesai'  => '2025-09-19',
            'is_active'        => true,
            'keterangan'       => '',
        ]);

        Kabinet::create([
            'period_id'        => $period2024->id,
            'ormawa_type'      => 'ukm',
            'ormawa_name'      => 'UKM ALAM',
            'nama_kabinet'     => 'Kabinet Hijau Lestari',
            'nama_ketua'       => 'Yogi Firmansyah',
            'nama_wakil'       => 'Citra Dewi Anggraeni',
            'nama_bendahara'   => 'Hendri Kusuma',
            'nama_sekretaris'  => 'Maya Puspita Sari',
            'tanggal_dilantik' => '2024-10-01',
            'tanggal_selesai'  => '2025-09-30',
            'is_active'        => true,
            'keterangan'       => '',
        ]);

        Kabinet::create([
            'period_id'        => $period2024->id,
            'ormawa_type'      => 'ukm',
            'ormawa_name'      => 'UKM Taekwondo',
            'nama_kabinet'     => null,
            'nama_ketua'       => 'Rendi Setiawan',
            'nama_wakil'       => 'Tika Nurhaliza',
            'nama_bendahara'   => 'Agus Riyanto',
            'nama_sekretaris'  => 'Sinta Permata Dewi',
            'tanggal_dilantik' => '2024-10-05',
            'tanggal_selesai'  => '2025-10-04',
            'is_active'        => true,
            'keterangan'       => '',
        ]);
    }
}