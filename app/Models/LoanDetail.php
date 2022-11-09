<?php

namespace App\Models;

use App\Observers\LoanObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'invoice_date'  => 'datetime:d F Y',
        'created_at'    => 'datetime:Y-md',
        'updated_at'    => 'datetime:Y-m-d',
    ];

    public static function booted() {
        parent::boot();
        parent::observe(new LoanObserver);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
