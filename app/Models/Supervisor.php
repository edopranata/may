<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Supervisor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function loan()
    {
        return $this->morphOne(Loan::class, 'modelable');
    }

    public function price()
    {
        return $this->morphOne(Price::class, 'modelable');
    }

    public function scopeFilter($query, $search)
    {
        $query->when($search, function ($query, $value) {
            $query->where('name', 'like', '%'.$value.'%');
            $query->orWhere('address', 'like', '%'.$value.'%');
            $query->orWhere('phone', 'like', '%'.$value.'%');
        });
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'modelable');
    }
}
