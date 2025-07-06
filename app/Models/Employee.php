<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'description',
        'is_active',
        'gender',
        'profile_picture',
        'preferences',
        'status',
        'user_id',
    ];

    protected $casts = [
        'preferences' => 'array', // Cast JSON to array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
