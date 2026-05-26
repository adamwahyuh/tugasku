<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])] // untuk mass asignment
class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    // CAST AGAR FORMAT JADI DATETIME 
    // INI ADA DI MODEL TASK
    protected $casts = ['tenggat_waktu' => 'datetime', 'selesai_pada' => 'datetime'];
}
