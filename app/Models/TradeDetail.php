<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'trade_date' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class)->withTrashed();
    }

    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }

    public function invoice_trade()
    {
        return $this->hasOne(InvoiceTrade::class, 'trade_detail_id', 'id');
    }
}
