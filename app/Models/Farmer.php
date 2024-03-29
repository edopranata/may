<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Farmer extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    protected $guarded = ['id'];

    public function loan()
    {
        return $this->morphOne(Loan::class, 'modelable');
    }

    public function trades()
    {
        return $this->hasMany(TradeDetail::class);
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'modelable');
    }

    public function scopeFilter($query, $search)
    {
        $query->when($search, function ($query, $value) {
            $query->where('name', 'like', '%'.$value.'%')
                ->orWhere('address', 'like', '%'.$value.'%')
                ->orWhere('phone', 'like', '%'.$value.'%');
        });
    }

    public function toSearchableArray()
    {
        return [
            'name'  => $this->name,
            'phone'   => $this->phone,
            'address'       => $this->address,
            'distance'      => $this->distance
        ];
    }
}
