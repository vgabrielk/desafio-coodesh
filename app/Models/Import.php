<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'processed_count', 'imported_at'];

    protected $casts = [
        'imported_at' => 'datetime',
    ];

}
