<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $guardName = 'web'; // Spécifier le guard

        // -----------------------------
        // 1️⃣ Définir les permissions
        // -----------------------------
        $permissions = [
            'create-users',
            'edit-users',
            'delete-users',
            'view-users',
            'manage-roles',
            'manage-permissions',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => $guardName]);
        }

        // -----------------------------
        // 2️⃣ Créer les rôles
        // -----------------------------
        $adminRole = Role::firstOrCreate(
            ['name' => 'ADMIN', 'guard_name' => $guardName]
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'USER', 'guard_name' => $guardName]
        );

        // Attribuer toutes les permissions au rôle ADMIN
        $adminRole->syncPermissions(Permission::all());

        // -----------------------------
        // 3️⃣ Créer les utilisateurs
        // -----------------------------
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('password123'),
                'status' => 'ACTIVE',
            ]
        );
        $admin->assignRole($adminRole);

        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Utilisateur',
                'password' => Hash::make('password123'),
                'status' => 'ACTIVE',
            ]
        );
        $user->assignRole($userRole);

        // -----------------------------
        // 4️⃣ Créer des utilisateurs fictifs
        // -----------------------------
        User::factory(5)->create()->each(function($u) use ($userRole) {
            $u->assignRole($userRole);
        });
    }
}
