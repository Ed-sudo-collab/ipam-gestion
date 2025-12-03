<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentStatut extends Model
{
    use HasFactory;

    protected $fillable = ['libelle', 'type', 'modifiable'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}

