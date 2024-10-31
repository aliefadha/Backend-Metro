<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'img',
        'description',
    ];

    public function rProject()
    {
        return $this->belongsToMany(Project::class, 'project_details');
    }
}
