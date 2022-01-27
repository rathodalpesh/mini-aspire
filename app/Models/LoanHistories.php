<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class LoanHistories extends Model
{
    protected $tablename = "loan_histories";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'loan_id',
        'loan_term',
        'amount_paid',
        'paid_date',
        'pay_date',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'paid_date',
        'pay_date',
        'created_at',
        'updated_at',
    ];


    public function loan()
    {
        return $this->belongsTo(loan::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
