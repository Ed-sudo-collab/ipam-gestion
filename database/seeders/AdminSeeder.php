<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@ipam-bf.com'],
            [
                'name' => 'Admin Principal',
                'nom_utilisateur' => 'admin',
                'password' => Hash::make('password123'),
                'type_utilisateur' => 'INTERNE',
                'statut' => 'ACTIF',
            ]
        );

        // Lui donner le rôle ADMIN
        $admin->assignRole('ADMIN');
    }
}
