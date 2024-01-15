<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function modelable()
    {
        return $this->morphTo()->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(LoanDetail::class);
    }
}
