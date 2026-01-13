<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookmakerBackOdd extends Model
{
    protected $fillable = [
        'event_id',
        'bookmaker',
        'sport_key',
        'sport_title',
        'commence_time',
        'home_team',
        'away_team',
        'home_back_odds',
        'away_back_odds',
        'draw_back_odds',
        'market_key',
        'last_update',
        'raw_data',
        'market_data',
    ];

    protected $casts = [
        'commence_time' => 'datetime',
        'last_update' => 'datetime',
        'raw_data' => 'array',
        'home_back_odds' => 'decimal:2',
        'away_back_odds' => 'decimal:2',
        'draw_back_odds' => 'decimal:2',
        'market_data' => 'array',
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

    // Scope to filter by bookmaker
    public function scopeByBookmaker($query, $bookmaker)
    {
        return $query->where('bookmaker', $bookmaker);
    }

    // Scope to get matches within next hours
    public function scopeWithinHours($query, $hours = 24)
    {
        return $query->where('commence_time', '>=', now())
                     ->where('commence_time', '<=', now()->addHours($hours));
    }

    // Get all odds for a specific event across all bookmakers
    public static function getEventOddsComparison($eventId)
    {
        return self::where('event_id', $eventId)
                   ->get()
                   ->keyBy('bookmaker');
    }
}
