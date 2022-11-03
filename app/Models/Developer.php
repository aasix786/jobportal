<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $fillable=
        [
            'name',
            'image',
            'bio',
        ];

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class,'developers_skills')->withTimestamps();
    }
    public function stacks()
    {
        return $this->belongsToMany(Stack::class,'developers_stacks')->withTimestamps();
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class,'developers_projects')->withTimestamps();
    }

}
