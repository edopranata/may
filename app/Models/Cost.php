<?php

namespace App\Models;

use App\Observers\CostObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'invoice_date'  => 'datetime:Y-m-d',
        'created_at'    => 'datetime:Y-m-d',
        'updated_at'    => 'datetime:Y-m-d',
    ];

    protected $guarded = ['id'];

    public static function booted() {
        parent::boot();
        parent::observe(new CostObserver);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
