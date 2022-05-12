<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffClass extends Model
{
    use HasFactory;

    const STAFF_ACADEMIC = "Academic Staff";
    const STAFF_NON_ACADEMIC = "Non Academic Staff";

    protected $fillable = [
        'class',
    ];
}
