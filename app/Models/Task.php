<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    protected $table = "task";

    protected $fillable = [
        'title',
        'description',
        'finish',
        'limit_date',

    ];

    protected function casts(): array
    {
        return [
            'finish' => 'integer',
            'limite_date' => 'datetime',
        ];
    }
}
