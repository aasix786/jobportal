<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable =
        ['name', 'description','status','budget'];

    public function projectFiles()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function stacks()
    {
        return $this->belongsToMany(Stack::class, 'projects_stacks')->withTimestamps();
    }
    public function developers()
    {
        return $this->belongsToMany(Developer::class,'developers_projects')->withTimestamps();
    }

}
