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
            'gestion.utilisateur',

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

        $etudiantRole = Role::firstOrCreate(
            ['name' => 'ETUDIANT', 'guard_name' => $guardName]
        );

        $secretaireRole = Role::firstOrCreate(
            ['name' => 'SECRETAIRE', 'guard_name' => $guardName]
        );

        $comptableRole = Role::firstOrCreate(
            ['name' => 'COMPTABLE', 'guard_name' => $guardName]
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
                'role_id'=> '1'
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
        $user->assignRole($secretaireRole);

        // -----------------------------
        // 4️⃣ Créer des utilisateurs fictifs
        // -----------------------------
        User::factory(5)->create()->each(function($u) use ($comptableRole) {
            $u->assignRole($comptableRole);
        });
    }
}
