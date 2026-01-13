<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 🔄 Nettoyer le cache des permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */
        $permissions = [
            // Utilisateurs & rôles
            'gestion.utilisateur',
            'gestion.roles',

            // Académique
            'manage-programs',
            'manage-levels',
            'manage-academic-years',

            // Étudiants & inscriptions
            'manage-students',
            'manage-enrollments',

            // Finances
            'manage-fees',
            'manage-payments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /*
        |--------------------------------------------------------------------------
        | Rôles
        |--------------------------------------------------------------------------
        */
        $admin       = Role::firstOrCreate(['name' => 'ADMIN']);
        $secretaire  = Role::firstOrCreate(['name' => 'SECRETAIRE']);
        $comptable   = Role::firstOrCreate(['name' => 'COMPTABLE']);

        /*
        |--------------------------------------------------------------------------
        | Attribution des permissions
        |--------------------------------------------------------------------------
        */

        // 🔑 ADMIN → toutes les permissions
        $admin->syncPermissions($permissions);

        // 🧾 SECRETAIRE
        $secretaire->syncPermissions([
            'manage-students',
            'manage-enrollments',
        ]);

        // 💰 COMPTABLE
        $comptable->syncPermissions([
            'manage-fees',
            'manage-payments',
        ]);
    }
}
