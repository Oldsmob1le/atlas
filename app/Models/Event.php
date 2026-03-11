<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    /**
     * Поля, которые разрешено массово заполнять через формы.
     */
    protected $fillable = [
        'title',
        'category',
        'starts_at',
        'user_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
    ];
}
