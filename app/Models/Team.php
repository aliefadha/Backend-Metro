<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'img',
    ];

    public function rSkill()
    {
        return $this->belongsToMany(Skill::class, 'skill_details'); // Pastikan nama tabel benar
    }
}
