<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Loader extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ['id'];

    public function price()
    {
        return $this->morphOne(Price::class, 'modelable');
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'modelable');
    }

    public function scopeFilter($query, $search)
    {
        $query->when($search, function ($query, $value) {
            $query->where('name', 'like', '%'.$value.'%');
        });
    }

}
