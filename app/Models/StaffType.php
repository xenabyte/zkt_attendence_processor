<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffType extends Model
{
    use HasFactory;

    const STAFF_SENIOR = "Senior Staff";
    const STAFF_JUNIOR = "Junior Staff";

    protected $fillable = [
        'type',
    ];
}
