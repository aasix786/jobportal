<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectHour extends Model
{
    use HasFactory;
    protected $table='project_hours';
    protected $fillable
    =
        [
            'start','break_start','break_end','checkout','project_id','developer_id'
        ];
    protected $casts=
        [
            'time'=>'timestamp',
        ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function developer()
    {
        {
            return $this->belongsTo(Developer::class);
        }
    }
}
