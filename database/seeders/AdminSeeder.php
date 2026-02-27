<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Rollarni yaratib olamiz
        // firstOrCreate - agar bu rol bazada bo'lsa tegmaydi, bo'lmasa yaratadi
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'teacher']);
        Role::firstOrCreate(['name' => 'tester']);

        // 2. Asosiy adminni yaratish (agar yo'q bo'lsa)
        $admin = User::updateOrCreate(
            ['email' => 'admin@ultra.uz'],
            [
                'name' => 'Asosiy Admin',
                'password' => Hash::make('02192004'),
                'expires_at' => null, // Asosiy admin muddati cheksiz
            ]
        );

        // 3. Adminga "admin" rolini biriktiramiz
        $admin->assignRole('admin');
    }
}
