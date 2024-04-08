<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'domain',
        'price',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class); // Define the relationship
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function isEnrolledBy($user)
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }
}
