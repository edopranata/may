<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function price()
    {
        return $this->morphOne(Price::class, 'modelable');
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function scopeFilter($query, $search)
    {
        $query->when($search, function ($query, $value) {
            $query->where('name', 'like', '%'.$value.'%');
            $query->orWhere('no_pol', 'like', '%'.$value.'%');
        });
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'modelable');
    }
}
