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
        $guardName = 'web';

             // -----------------------------
     // 1️⃣ Définir les permissions
     // -----------------------------
     $permissions = [
         // Gestion utilisateurs / rôles
         'gestion.utilisateur',
         'gestion.roles',

         // Gestion académique
         'manage-levels',
         'manage-programs',
         'manage-academic-years',

         // Gestion étudiants & inscriptions
         'manage-students',
         'manage-student-academics',
         'manage-student-professionals',
         'manage-student-documents',
         'manage-enrollments',
     ];

     foreach ($permissions as $perm) {
         Permission::firstOrCreate(['name' => $perm, 'guard_name' => $guardName]);
     }

     // -----------------------------
     // 2️⃣ Créer les rôles
     // -----------------------------
     $adminRole = Role::firstOrCreate(['name' => 'ADMIN', 'guard_name' => $guardName]);
     $etudiantRole = Role::firstOrCreate(['name' => 'ETUDIANT', 'guard_name' => $guardName]);
     $secretaireRole = Role::firstOrCreate(['name' => 'SECRETAIRE', 'guard_name' => $guardName]);
     $comptableRole = Role::firstOrCreate(['name' => 'COMPTABLE', 'guard_name' => $guardName]);

     // Attribuer toutes les permissions au rôle ADMIN
     $adminRole->syncPermissions(Permission::all());

     // Permissions spécifiques au rôle Secrétaire
     $secretaireRole->syncPermissions([
         'manage-students',
         'manage-student-academics',
         'manage-student-professionals',
            'manage-student-documents',
         'manage-enrollments',
     ]);

     // -----------------------------
     // 3️⃣ Créer les utilisateurs
     // -----------------------------
     $admin = User::firstOrCreate(
         ['email' => 'admin@example.com'],
         [
             'name' => 'Administrateur',
             'password' => Hash::make('password123'),
             'status' => 'ACTIVE'
         ]
     );
     $admin->assignRole($adminRole);

     $secretaire = User::firstOrCreate(
         ['email' => 'secretaire@example.com'],
         [
             'name' => 'Secrétaire',
             'password' => Hash::make('password123'),
             'status' => 'ACTIVE',
         ]
     );
     $secretaire->assignRole($secretaireRole);

     // -----------------------------
     // 4️⃣ Créer des utilisateurs fictifs (Comptable)
     // -----------------------------
     User::factory(5)->create()->each(function($u) use ($comptableRole) {
         $u->assignRole($comptableRole);
     });
 }

}
