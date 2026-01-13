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
        $guard = 'web';

        // -----------------------------
        // 1️⃣ Permissions
        // -----------------------------
        $permissions = [
            // Utilisateurs & rôles
            'gestion.utilisateur',
            'gestion.roles',

            // Académique
            'manage-levels',
            'manage-programs',
            'manage-academic-years',

            // Étudiants & inscriptions
            'manage-students',
            'manage-enrollments',

            // Finance
            'manage-fees',
            'manage-payments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guard
            ]);
        }

        // -----------------------------
        // 2️⃣ Rôles
        // -----------------------------
        $adminRole      = Role::firstOrCreate(['name' => 'ADMIN', 'guard_name' => $guard]);
        $secretaireRole = Role::firstOrCreate(['name' => 'SECRETAIRE', 'guard_name' => $guard]);
        $comptableRole  = Role::firstOrCreate(['name' => 'COMPTABLE', 'guard_name' => $guard]);

        // ADMIN → toutes les permissions
        $adminRole->syncPermissions(Permission::all());

        // SECRETAIRE → étudiants + inscriptions
        $secretaireRole->syncPermissions([
            'manage-students',
            'manage-enrollments',
        ]);

        // COMPTABLE → finance
        $comptableRole->syncPermissions([
            'manage-fees',
            'manage-payments',
        ]);

        // -----------------------------
        // 3️⃣ Comptes utilisateurs
        // -----------------------------
        $usersData = [
            [
                'name' => 'Compte Admin',
                'email' => 'admin@example.com',
                'role' => $adminRole,
            ],
            [
                'name' => 'Compte Secrétaire',
                'email' => 'secretaire@example.com',
                'role' => $secretaireRole,
            ],
            [
                'name' => 'Compte Comptable',
                'email' => 'comptable@example.com',
                'role' => $comptableRole,
            ],
        ];

        foreach ($usersData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password123'),
                    'status' => 'ACTIVE',
                    'role_id' => $data['role']->id, // <-- Remplit la colonne role_id
                ]
            );

            // Synchroniser le rôle Spatie
            $user->syncRoles([$data['role']->name]);
        }
    }
}
