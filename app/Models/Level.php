<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    protected $fillable = ['name'];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}

