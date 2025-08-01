<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Database\Factories\UserFactory;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Permissions (tetap sama)
        Permission::firstOrCreate(['name' => 'view dashboard']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'create user']);
        Permission::firstOrCreate(['name' => 'edit user']);
        Permission::firstOrCreate(['name' => 'delete user']);
        Permission::firstOrCreate(['name' => 'manage students']);
        Permission::firstOrCreate(['name' => 'manage teachers']);
        Permission::firstOrCreate(['name' => 'manage classes']);
        Permission::firstOrCreate(['name' => 'manage subjects']);
        Permission::firstOrCreate(['name' => 'manage teaching assignments']);
        Permission::firstOrCreate(['name' => 'input grades']);
        Permission::firstOrCreate(['name' => 'view grades']);
        Permission::firstOrCreate(['name' => 'record attendance']);
        Permission::firstOrCreate(['name' => 'view attendance']);
        Permission::firstOrCreate(['name' => 'send announcements']);
        Permission::firstOrCreate(['name' => 'view announcements']);
        Permission::firstOrCreate(['name' => 'manage schedules']);
        Permission::firstOrCreate(['name' => 'view schedules']);

        // 2. Buat Roles dan Beri Permissions (tetap sama)
        $adminRole = Role::firstOrCreate(['name' => 'admin_sekolah']);
        $guruRole = Role::firstOrCreate(['name' => 'guru']);
        $siswaRole = Role::firstOrCreate(['name' => 'siswa']);
        $orangTuaRole = Role::firstOrCreate(['name' => 'orang_tua']);

        $adminRole->givePermissionTo(Permission::all());

        $guruRole->givePermissionTo([
            'view dashboard',
            'record attendance',
            'view attendance',
            'input grades',
            'view grades',
            'manage teaching assignments',
            'manage subjects',
            'send announcements',
            'manage schedules',
        ]);

        $siswaRole->givePermissionTo([
            'view dashboard',
            'view grades',
            'view attendance',
            'view announcements',
            'view schedules',
        ]);

        $orangTuaRole->givePermissionTo([
            'view dashboard',
            'view grades',
            'view attendance',
            'view announcements',
            'view schedules',
        ]);

        // 3. Buat User Admin Awal
        User::firstOrCreate(
            ['email' => 'admin@akademika.com'],
            ['name' => 'Admin Utama Akademika', 'password' => bcrypt('password'), 'email_verified_at' => now()]
        )->assignRole('admin_sekolah');

        // Buat User Guru dengan Email Tetap
        $fixedGuruCount = 3;
        // Ambil objek user guru yang spesifik
        $guruSatu = User::firstOrCreate(
            ['email' => 'guru@akademika.com'],
            ['name' => 'Guru Satu', 'password' => bcrypt('password'), 'email_verified_at' => now()]
        );
        $guruSatu->assignRole('guru');

        User::firstOrCreate(
            ['email' => 'guru2@akademika.com'],
            ['name' => 'Guru Dua', 'password' => bcrypt('password'), 'email_verified_at' => now()]
        )->assignRole('guru');
        User::firstOrCreate(
            ['email' => 'guru3@akademika.com'],
            ['name' => 'Guru Tiga', 'password' => bcrypt('password'), 'email_verified_at' => now()]
        )->assignRole('guru');

        // Buat User Guru Tambahan (acak)
        $totalGuruDesired = 10;
        if ($totalGuruDesired > $fixedGuruCount) {
            User::factory()->count($totalGuruDesired - $fixedGuruCount)->create()->each(function (User $user) {
                $user->assignRole('guru');
            });
        }

        // Buat User Siswa dengan Email Tetap
        $fixedSiswaCount = 3;
        $siswaSatu = User::firstOrCreate(
            ['email' => 'siswa@akademika.com'],
            ['name' => 'Siswa Satu', 'password' => bcrypt('password'), 'email_verified_at' => now()]
        );
        $siswaSatu->assignRole('siswa');
        User::firstOrCreate(
            ['email' => 'siswa2@akademika.com'],
            ['name' => 'Siswa Dua', 'password' => bcrypt('password'), 'email_verified_at' => now()]
        )->assignRole('siswa');
        User::firstOrCreate(
            ['email' => 'siswa3@akademika.com'],
            ['name' => 'Siswa Tiga', 'password' => bcrypt('password'), 'email_verified_at' => now()]
        )->assignRole('siswa');

        // Buat User Siswa Tambahan (acak)
        $totalSiswaDesired = 50;
        if ($totalSiswaDesired > $fixedSiswaCount) {
            User::factory()->count($totalSiswaDesired - $fixedSiswaCount)->create()->each(function (User $user) {
                $user->assignRole('siswa');
            });
        }

        // Buat User Orang Tua dengan Email Tetap
        $fixedOrtuCount = 3;
        User::firstOrCreate(
            ['email' => 'ortu@akademika.com'],
            ['name' => 'Orang Tua Satu', 'password' => bcrypt('password'), 'email_verified_at' => now()]
        )->assignRole('orang_tua');
        User::firstOrCreate(
            ['email' => 'ortu2@akademika.com'],
            ['name' => 'Orang Tua Dua', 'password' => bcrypt('password'), 'email_verified_at' => now()]
        )->assignRole('orang_tua');
        User::firstOrCreate(
            ['email' => 'ortu3@akademika.com'],
            ['name' => 'Orang Tua Tiga', 'password' => bcrypt('password'), 'email_verified_at' => now()]
        )->assignRole('orang_tua');

        // Buat User Orang Tua Tambahan (acak)
        $totalOrtuDesired = 20;
        if ($totalOrtuDesired > $fixedOrtuCount) {
            User::factory()->count($totalOrtuDesired - $fixedOrtuCount)->create()->each(function (User $user) {
                $user->assignRole('orang_tua');
            });
        }

        $this->command->info('Roles and permissions, and initial users seeded.');
    }
}
