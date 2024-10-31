<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'skill_id',
    ];

    public function rSkill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function rTeam()
    {
        return $this->belongsTo(Team::class);
    }
}
