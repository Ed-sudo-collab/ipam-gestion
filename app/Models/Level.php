<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

   public function programs()
    {
        return $this->belongsToMany(Program::class, 'level_program', 'level_id', 'program_id');
    }

}
