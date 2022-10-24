<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function modelable()
    {
        return $this->morphTo();
    }

    public function trades()
    {
        return $this->belongsToMany(Trade::class, 'invoice_trade');
    }
}
