<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SportOdd extends Model
{
    protected $table = 'sports_odds';

    protected $fillable = [
        'sport',
        'ligue',
        'categorie',
        'evenement',
        'date',
        'marche',
        'market_outcome',
        'odds',
        'bookmarker'
    ];

    
}