<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        return view('admin.levels.index'); // On va créer ce fichier juste après
    }
}
