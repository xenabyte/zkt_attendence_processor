<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'class',
    ];
}
