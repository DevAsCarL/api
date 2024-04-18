<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    public const TODO = 1;
    public const IN_PROGRESS = 2;
    public const COMPLETE = 3;

    protected $fillable = [
        'status'
    ];
}
