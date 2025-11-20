<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'price', 'period', 'bookmakers_count', 'markets_count', 'leagues_count', 'features', 'is_popular'];
    protected $casts = ['features' => 'array', 'price' => 'decimal:2'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}