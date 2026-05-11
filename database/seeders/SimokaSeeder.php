<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SimokaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $admin = User::create([
            'name' => 'Admin SIMOKA',
            'email' => 'admin@simoka.id',
            'phone_number' => '08123456789',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        // Terapis
        $terapis = User::create([
            'name' => 'Rossy Putri Utami',
            'email' => 'rossy@simoka.id',
            'phone_number' => '08122334455',
            'username' => 'rossy',
            'password' => Hash::make('password'),
            'role' => 'terapis',
        ]);

        // Orang Tua
        $parent = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'phone_number' => '0855667788',
            'username' => 'budi',
            'password' => Hash::make('password'),
            'role' => 'orang_tua',
        ]);

        // Pasien (Anak)
        $parent->children()->create([
            'nama_lengkap' => 'Ahmad Rizki',
            'tanggal_lahir' => '2021-05-10',
            'jenis_kelamin' => 'L',
            'therapis_id' => $terapis->id,
            'catatan_medis' => 'Anak memiliki kecenderungan sensory seeking.',
        ]);

        $parent->children()->create([
            'nama_lengkap' => 'Siti Aminah',
            'tanggal_lahir' => '2023-01-15',
            'jenis_kelamin' => 'P',
            'therapis_id' => $terapis->id,
        ]);
    }
}
