<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $tablename = "loans";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_id',
        'loan_term',
        'interest',
        'amount',
        'purpose',
        'status',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'user', 'loan_histories'
    ];

    /**
     * Get all the tags that belong to the car.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loan_histories()
    {
        return $this->hasMany(LoanHistories::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
