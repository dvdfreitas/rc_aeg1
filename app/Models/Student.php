<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class);
    }

    function schoolClass($year) {
        return $this->belongsToMany(SchoolClass::class)->first();
    }
}
