<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    protected $fillable = ['name', 'description', 'level_id'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}

