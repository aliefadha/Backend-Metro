<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'img',
        'description',
        'link',
    ];

    public function rService()
    {
        return $this->belongsToMany(Service::class, 'project_details');
    }
}
