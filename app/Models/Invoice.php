<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'invoice_number',
        'guardian_id',
        'amount',
        'tax',
        'discount',
        'total_amount',
        'due_date',
        'status',
        'subscription_plan_id'
    ];

    public function guardians(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
