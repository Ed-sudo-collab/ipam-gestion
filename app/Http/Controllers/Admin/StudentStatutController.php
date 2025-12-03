<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentStatutController extends Controller
{
    public function index()
    {
        return view('admin.studentStatut.index');
    }

}
