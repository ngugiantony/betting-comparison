<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasUuids, HasFactory;
    protected $fillable = [
        'name',
        'validity_unit',
        'validity',
        'price',
        'description'
    ];

    public function studentPlans(): HasMany
    {
        return $this->hasMany(StudentSubscriptionPlan::class);
    }

}
