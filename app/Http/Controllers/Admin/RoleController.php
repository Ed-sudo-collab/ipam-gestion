<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Affiche la page de gestion des rôles.
     */
    public function index()
    {
        return view('admin.roles.index');
    }
}
