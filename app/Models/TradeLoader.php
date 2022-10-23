<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeLoader extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    public function loader()
    {
        return $this->hasOne(Loader::class);
    }

    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }
}
