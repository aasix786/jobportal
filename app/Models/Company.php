<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Company extends  Authenticatable
{
    use HasFactory,HasApiTokens;

    protected $fillable=
        [
            'first_name',
            'last_name',
            'type',
            'phone',
            'ein',
            'state',
            'zip_code',
            'address'
        ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
