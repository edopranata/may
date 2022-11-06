<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:Y-md',
        'updated_at' => 'datetime:Y-m-d',
    ];
}
