<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pegawai;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Roles
        $roles = [
            'Super Admin' => ['super_admin' => true, 'deskripsi' => 'Full Access'],
            'Registrasi' => ['registrasi' => true, 'deskripsi' => 'Handle Pendaftaran Jamaah'],
            'Kasir' => ['kasir' => true, 'deskripsi' => 'Handle Pembayaran'],
            'Keuangan' => ['keuangan' => true, 'deskripsi' => 'Manage Finances'],
            'Tour Leader' => ['tour_leader' => true, 'deskripsi' => 'Manage Embarkasi'],
            'Agen Marketing' => ['agen_marketing' => true, 'deskripsi' => 'Input Jamaah'],
            'Purchase' => ['purchase' => true, 'deskripsi' => 'Manage Stock & Purchase'],
        ];

        foreach ($roles as $name => $data) {
            Role::firstOrCreate(['nama_role' => $name], $data);
        }

        // 2. Create Super Admin
        $admin = Pegawai::firstOrCreate(
            ['username' => 'admin'],
            [
                'nama_pegawai' => 'Administrator',
                'password' => Hash::make('password'),
                'jabatan' => 'Super Admin',
                'status' => 'AKTIF',
            ]
        );

        // Assign Role
        $adminRole = Role::where('nama_role', 'Super Admin')->first();
        if (!$admin->roles()->where('roles.id_role', $adminRole->id_role)->exists()) {
            $admin->roles()->attach($adminRole->id_role);
        }

        // 3. Create Demo Pegawai (Marketing)
        $marketing = Pegawai::firstOrCreate(
            ['username' => 'marketing'],
            [
                'nama_pegawai' => 'Budi Marketing',
                'password' => Hash::make('password'),
                'jabatan' => 'Agen Marketing',
                'status' => 'AKTIF',
            ]
        );
        $marketingRole = Role::where('nama_role', 'Agen Marketing')->first();
        if (!$marketing->roles()->where('roles.id_role', $marketingRole->id_role)->exists()) {
            $marketing->roles()->attach($marketingRole->id_role);
        }

        // 4. Call other seeders
        $this->call([
            KodeAkuntansiSeeder::class,
            PurchasingSeeder::class,
        ]);
    }
}
