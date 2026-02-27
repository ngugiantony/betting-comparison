<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
      public function index(Request $request)
{

$backMatches = DB::table('sports_odds as s')
    ->join('sports_oodds as l', function($join) {
        $join->on('s.sport',   '=', 'l.sport')
             ->on('s.evenement',   '=', 'l.evenement')
            //  ->on('s.market_outcome',  '=', 'l.market_outcome')
             ;
    })
    ->select(
        's.sport',
        's.evenement          as match_details',
        's.market_outcome         as type',
        's.odds      as back',
        's.bookmarker      as bookmaker',
        'l.odds       as lay'
    )
    ->get(); 

     $sports = DB::table('sports_odds')        
        ->distinct()
        ->get()
        ->pluck('sport');
        
    $competitions = DB::table('sports_odds')
        ->distinct()
        ->pluck('bookmarker');


    return view('parents.matches.index', compact(
        'backMatches', 
        'sports', 
        'competitions'
    ));
}
   public function indexmain(Request $request)
{



    // dd($query
    // );
    // Get filters
    $sport = $request->get('sport');
    $bookmaker = $request->get('competition'); // Changed to match form field name
    $homeTeam = $request->get('home_team');
    $awayTeam = $request->get('away_team');
    $hours = $request->get('hours');
    
    // Build optimized back odds query
    $backOddsQuery = DB::table('bookmaker_back_odds')
        ->select(
            'bookmaker_back_odds.id',
            'bookmaker_back_odds.event_id as back_id',
            'bookmaker_back_odds.home_team as home_name',
            'bookmaker_back_odds.away_team as away_name',
            'bookmaker_back_odds.home_back_odds as back_home_odds',
            'bookmaker_back_odds.draw_back_odds as back_draw_odds',
            'bookmaker_back_odds.away_back_odds as back_away_odds',
            'bookmaker_back_odds.commence_time as event_date',
            'bookmaker_back_odds.bookmaker as back_bookmaker',
            'bookmaker_back_odds.sport_title as sport_name',
            'bookmaker_back_odds.sport_key as competition_name'
        )
        ->where('commence_time', '>=', now()); // Only upcoming matches

    // Apply time filter only if specified
    if ($hours) {
        $backOddsQuery->where('commence_time', '<=', now()->addHours($hours));
    }

    // Apply sport filter
    if ($sport) {
        $backOddsQuery->where('sport_title',  $sport);
    }

    // Apply bookmaker filter
    if ($bookmaker) {
        $backOddsQuery->where('bookmaker', $bookmaker);
    }

    // Apply home team filter
    if ($homeTeam) {
        $backOddsQuery->where('home_team', 'LIKE', '%' . $homeTeam . '%');
    }

    // Apply away team filter
    if ($awayTeam) {
        $backOddsQuery->where('away_team', 'LIKE', '%' . $awayTeam . '%');
    }

    // Sort
    $sortBy = $request->get('sort_by', 'commence_time');
    $sortOrder = $request->get('sort_order', 'asc');
    $backOddsQuery->orderBy($sortBy, $sortOrder);

    // Paginate
    $perPage = $request->get('per_page', 5000);
    $backMatches = $backOddsQuery->paginate($perPage);

    // Get lay odds for matching (optimized query)
    $layOddsQuery = DB::table('betfair_lay_odds')
        ->select(
            'event_id as lay_id',
            'home_team',
            'away_team',
            'home_lay_odds as odds_home_lay',
            'away_lay_odds as odds_away_lay',
            'draw_lay_odds as odds_draw_lay',
            'commence_time'
        )
        ->where('commence_time', '>=', now());
    
    // Apply time filter only if specified
    if ($hours) {
        $layOddsQuery->where('commence_time', '<=', now()->addHours($hours));
    }

    $layOdds = $layOddsQuery->get();

    // Create multiple lookup maps for better matching
    $layOddsMap = [];
    
    foreach ($layOdds as $lay) {
        // Normalize team names for matching
        $homeNorm = $this->normalizeTeamName($lay->home_team);
        $awayNorm = $this->normalizeTeamName($lay->away_team);
        
        // Create multiple keys for flexible matching
        $keys = [
            $homeNorm . '_' . $awayNorm,  // Standard key
            $lay->lay_id,                  // Event ID match
        ];
        
        foreach ($keys as $key) {
            $layOddsMap[$key] = $lay;
        }
    }

    // Enrich back matches with lay odds
    foreach ($backMatches as $match) {
        $homeNorm = $this->normalizeTeamName($match->home_name);
        $awayNorm = $this->normalizeTeamName($match->away_name);
        
        // Try multiple matching strategies
        $layMatch = null;
        
        // Strategy 1: Event ID match
        if (isset($layOddsMap[$match->back_id])) {
            $layMatch = $layOddsMap[$match->back_id];
        }
        
        // Strategy 2: Normalized team names
        if (!$layMatch) {
            $key = $homeNorm . '_' . $awayNorm;
            $layMatch = $layOddsMap[$key] ?? null;
        }
        
        // Strategy 3: Fuzzy matching for similar team names
        if (!$layMatch) {
            $layMatch = $this->fuzzyMatchTeams($match, $layOdds);
        }
        
        $match->lay_odds = $layMatch;
    }

    // Get filter options
    $sports = DB::table('bookmaker_back_odds')
        ->select('sport_key', 'sport_title')
        ->distinct()
        ->get()
        ->pluck('sport_title', 'sport_key');
        
    $competitions = DB::table('bookmaker_back_odds')
        ->distinct()
        ->pluck('bookmaker');

    return view('parents.matches.index', compact(
        'backMatches', 
        'sports', 
        'competitions'
    ));
}

/**
 * Normalize team name for matching
 */
private function normalizeTeamName($name)
{
    $name = strtolower(trim($name));
    
    // Remove common variations
    $replacements = [
        'fc' => '',
        'afc' => '',
        'bfc' => '',
        'cfc' => '',
        'united' => 'utd',
        'athletic' => 'ath',
        'association' => 'assoc',
        '.' => '',
        '-' => ' ',
        '  ' => ' ',
    ];
    
    $name = str_replace(array_keys($replacements), array_values($replacements), $name);
    
    return trim($name);
}

/**
 * Fuzzy match teams based on similarity
 */
private function fuzzyMatchTeams($backMatch, $layOdds)
{
    $backHome = $this->normalizeTeamName($backMatch->home_name);
    $backAway = $this->normalizeTeamName($backMatch->away_name);
    
    foreach ($layOdds as $lay) {
        $layHome = $this->normalizeTeamName($lay->home_team);
        $layAway = $this->normalizeTeamName($lay->away_team);
        
        // Calculate similarity percentage
        $homeSimilarity = $this->calculateSimilarity($backHome, $layHome);
        $awaySimilarity = $this->calculateSimilarity($backAway, $layAway);
        
        // If both teams are 80%+ similar, consider it a match
        if ($homeSimilarity >= 80 && $awaySimilarity >= 80) {
            return $lay;
        }
    }
    
    return null;
}

/**
 * Calculate string similarity percentage
 */
private function calculateSimilarity($str1, $str2)
{
    similar_text($str1, $str2, $percent);
    return $percent;
}
public function sportodds()
{
    $query = DB::table('sport_odds as s')
    ->join('sports_oodds as l', function($join) {
        $join->on('s.sport',   '=', 'l.sport')
             ->on('s.event',   '=', 'l.event')
             ->on('s.market',  '=', 'l.market');
    })
    ->select(
        's.sport',
        's.event          as match_details',
        's.market         as type',
        's.back_odds      as back',
        's.bookmaker      as bookmaker',
        'l.odds       as lay'
    )
    ->orderBy('s.sport')
    ->orderBy('s.event')
    ->get();        


    return view('parents.matches.show', compact('match', 'layOdds'));

}
}