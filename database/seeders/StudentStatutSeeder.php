<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentStatut;

class StudentStatutSeeder extends Seeder
{
    public function run()
    {
        $fixedStatuts = [
            'Préinscrit',
            'En attente de validation',
            'Inscrit',
            'Réinscrit',
            'Suspendu',
            'Abandonné / Désisté',
            'Exclu',
        ];

        foreach ($fixedStatuts as $libelle) {
            StudentStatut::firstOrCreate(
                ['libelle' => $libelle],
                ['type' => 'système', 'modifiable' => false]
            );
        }
    }
}
