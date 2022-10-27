<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function price()
    {
        return $this->morphOne(Price::class, 'modelable');
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }
}
