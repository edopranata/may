<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTrade extends Model
{
    use HasFactory;
    protected $table = 'invoice_trade';

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
