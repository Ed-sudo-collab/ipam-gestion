<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'level_program', 'program_id', 'level_id');
    }


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

}
