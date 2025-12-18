<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetfairLayOdd extends Model
{
    protected $fillable = [
        'event_id',
        'sport_key',
        'sport_title',
        'commence_time',
        'home_team',
        'away_team',
        'home_lay_odds',
        'away_lay_odds',
        'draw_lay_odds',
        'market_key',
        'last_update',
        'raw_data'
    ];

    protected $casts = [
        'commence_time' => 'datetime',
        'last_update' => 'datetime',
        'raw_data' => 'array',
        'home_lay_odds' => 'decimal:2',
        'away_lay_odds' => 'decimal:2',
        'draw_lay_odds' => 'decimal:2',
    ];

    // Scope to get upcoming matches
    public function scopeUpcoming($query)
    {
        return $query->where('commence_time', '>=', now());
    }

    // Scope to filter by sport
    public function scopeBySport($query, $sport)
    {
        return $query->where('sport_key', $sport);
    }

    // Scope to get matches within next X hours
    public function scopeWithinHours($query, $hours = 24)
    {
        return $query->where('commence_time', '>=', now())
                    ->where('commence_time', '<=', now()->addHours($hours));
    }
}