<?php

namespace App\Models;

use App\Observers\TradeObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'trade_status'  => 'datetime:Y-m-d',
        'trade_date'    => 'datetime:Y-m-d',
        'created_at'    => 'datetime:Y-m-d',
        'updated_at'    => 'datetime:Y-m-d',
    ];

    public static function booted() {
        parent::boot();
        parent::observe(new TradeObserver);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function details()
    {
        return $this->hasMany(TradeDetail::class);
    }
}
