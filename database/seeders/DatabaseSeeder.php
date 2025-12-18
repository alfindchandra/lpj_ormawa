<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Period;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Kemahasiswaan',
            'email' => 'admin@ikippgribojonegoro.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // BEM
        User::create([
            'name' => 'BEM IKIP PGRI Bojonegoro',
            'email' => 'bem@ikippgribojonegoro.ac.id',
            'password' => Hash::make('password'),
            'role' => 'bem',
            'ormawa_name' => 'BEM IKIP',
            'email_verified_at' => now(),
        ]);

        // Sample Ormawa
        $ormawaList = [
            'HMPTI',
            'UKM ALAM',
            'UKM KSR',
            'UKM Taekwondo',
         
        ];

        foreach ($ormawaList as $ormawa) {
            User::create([
                'name' => 'Ketua ' . $ormawa,
                'email' => strtolower(str_replace(' ', '', $ormawa)) . '@ikippgribojonegoro.ac.id',
                'password' => Hash::make('password'),
                'role' => 'ormawa',
                'ormawa_name' => $ormawa,
                'phone' => '08123456789',
                'email_verified_at' => now(),
            ]);
        }

        // Create Period
        Period::create([
            'nama_periode' => 'Periode 2024/2025',
            'tahun_mulai' => 2024,
            'tahun_selesai' => 2025,
            'is_active' => true,
        ]);
    }
}