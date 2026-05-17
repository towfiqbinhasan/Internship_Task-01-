<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
     use HasFactory;
protected $hidden = ['name'];
protected $fillable = [
    
        'name',
        'age',
        'email',
        'date_of_birth',
        'gender',
        'score',
    ];
    //protected $fillable = ['name', 'email', 'age', 'date_of_birth', 'gender', 'score'];

}
