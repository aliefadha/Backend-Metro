<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'service_id',
    ];

    public function rProject()
    {
        return $this->belongsTo(Project::class);
    }

    public function rService()
    {
        return $this->belongsTo(Service::class);
    }
}
