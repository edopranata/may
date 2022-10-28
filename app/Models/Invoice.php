<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'invoice_date' => 'datetime:d F Y',
        'created_at' => 'datetime:Y-md',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function modelable()
    {
        return $this->morphTo();
    }

    public function trade_details()
    {
        return $this->belongsToMany(TradeDetail::class, 'invoice_trade');
    }

    public function trades()
    {
        return $this->belongsToMany(Trade::class, 'invoice_trade');
    }
}
