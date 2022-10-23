<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Driver extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ['id'];

    public function price()
    {
        return $this->morphOne(Price::class, 'modelable');
    }

    public function loan()
    {
        return $this->morphOne(Loan::class, 'modelable');
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function toSearchableArray()
    {
        return [
            'name'  => $this->name,
            'phone'   => $this->phone,
            'address'       => $this->address,
        ];
    }
}
