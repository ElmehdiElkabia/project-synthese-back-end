<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'course_id',
        'questions',
        'answers',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function userTests()
    {
        return $this->hasMany(UserTest::class);
    }
}
