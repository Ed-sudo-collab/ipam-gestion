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

        // ✅ Créer des rôles
        $adminRole = Role::firstOrCreate(
            ['name' => 'ADMIN', 'guard_name' => $guardName]
        );
        $userRole = Role::firstOrCreate(
            ['name' => 'USER', 'guard_name' => $guardName]
        );

        // ✅ Créer des permissions (exemple)
        $permissions = [
            'users.create',
            'users.edit',
            'users.delete',
            'roles.manage',
            'permissions.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => $guardName]);
        }

        // Attribuer toutes les permissions au rôle ADMIN
        $adminRole->syncPermissions(Permission::all());

        // ✅ Créer des utilisateurs
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

        // Créer d'autres utilisateurs fictifs
        User::factory(5)->create()->each(function($u) use ($userRole) {
            $u->assignRole($userRole);
        });
    }
}
