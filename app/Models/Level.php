<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'program_id'];

    // Un niveau appartient à une formation
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
