<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Une formation a plusieurs niveaux
    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
