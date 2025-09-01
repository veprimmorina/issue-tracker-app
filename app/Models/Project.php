<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'deadline',
        'user_id',
    ];

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
