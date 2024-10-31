<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = [
        'skill',
    ];

    public function rTeam()
    {
        return $this->belongsToMany(Team::class, 'skill_details');
    }
}
