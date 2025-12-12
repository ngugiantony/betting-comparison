<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function indexx(Request $request)
    {
        $query = DB::table('matches')
            ->join('sports', 'matches.sport_id', '=', 'sports.id')
            ->leftJoin('competitions', 'matches.competition_id', '=', 'competitions.id')
            ->select('matches.*', 'sports.name as sport_name', 'competitions.name as competition_name');

        // Filter by sport
        if ($request->filled('sport')) {
            $query->where('sports.name', $request->sport);
        }

        // Filter by competition
        if ($request->filled('competition')) {
            $query->where('matches.bookmaker', 'like', '%' . $request->competition . '%');
        }

        // Filter by home team
        if ($request->filled('home_team')) {
            $query->where('matches.home_name', 'like', '%' . $request->home_team . '%');
        }

        // Filter by away team
        if ($request->filled('away_team')) {
            $query->where('matches.away_name', 'like', '%' . $request->away_team . '%');
        }

        // Filter by odds range
        if ($request->filled('min_odds')) {
            $query->where('matches.odds_home', '>=', $request->min_odds);
        }

        if ($request->filled('max_odds')) {
            $query->where('matches.odds_home', '<=', $request->max_odds);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'scraped_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $matches = $query->paginate(20);

        // Get unique sports and competitions for filters
        $sports = DB::table('sports')->pluck('name')->unique();
        $competitions = DB::table('matches')->pluck('bookmaker')->unique();

        return view('parents.matches.index', compact('matches', 'sports', 'competitions'));
    }
    public function index(Request $request)
{
    // Get back odds from matches table (Bwin, NetBet, ParionsSport, etc.)
    $backOddsQuery = DB::table('matches')
        ->join('sports', 'matches.sport_id', '=', 'sports.id')
        ->leftJoin('competitions', 'matches.competition_id', '=', 'competitions.id')
        ->select(
            'matches.id as back_id',
            'matches.home_name',
            'matches.away_name',
            'matches.odds_home as back_home_odds',
            'matches.odds_draw as back_draw_odds',
            'matches.odds_away as back_away_odds',
            'matches.event_date',
            'matches.event_time',
            'matches.match_time',
            'matches.bookmaker as back_bookmaker',
            'sports.name as sport_name',
            'competitions.name as competition_name'
        );

    // Get lay odds from orbitxch_odds table (your actual structure)
    $layOddsQuery = DB::table('orbitxch_odds')
        ->select(
            'id as lay_id',
            'home_name',
            'away_name',
            'odds_home_lay',
            'volume_home_lay',
            'odds_draw_lay',
            'volume_draw_lay',
            'odds_away_lay',
            'volume_away_lay',
            'event_date as lay_event_date',
            'event_time as lay_event_time',
            'bookmaker as lay_bookmaker'
        );

    // Apply filters
  

    // Filter by sport
        if ($request->filled('sport')) {
            $backOddsQuery->where('sports.name', $request->sport);
        }

        // Filter by competition
        if ($request->filled('competition')) {
            $backOddsQuery->where('matches.bookmaker', 'like', '%' . $request->competition . '%');
        }

        // Filter by home team
        if ($request->filled('home_team')) {
            $backOddsQuery->where('matches.home_name', 'like', '%' . $request->home_team . '%');
        }

        // Filter by away team
        if ($request->filled('away_team')) {
            $backOddsQuery->where('matches.away_name', 'like', '%' . $request->away_team . '%');
        }

        // Filter by odds range
        if ($request->filled('min_odds')) {
            $backOddsQuery->where('matches.odds_home', '>=', $request->min_odds);
        }

        if ($request->filled('max_odds')) {
            $backOddsQuery->where('matches.odds_home', '<=', $request->max_odds);
        }

    // Sort and paginate back odds
    $sortBy = $request->get('sort_by', 'matches.event_time');
    $sortOrder = $request->get('sort_order', 'asc');
    $backOddsQuery->orderBy($sortBy, $sortOrder);

    $backMatches = $backOddsQuery->paginate(20000);

    // Get all lay odds
    $layOdds = $layOddsQuery->get();

    // Create a keyed collection for fast lookup
    $layOddsMap = $layOdds->mapWithKeys(function($match) {
        $key = strtolower(trim($match->home_name) . '_' . trim($match->away_name));
        return [$key => $match];
    });

    // Enrich back matches with lay odds and calculate arbitrage
    foreach ($backMatches as $match) {
        $key = strtolower(trim($match->home_name) . '_' . trim($match->away_name));
        $match->lay_odds = $layOddsMap->get($key);
        
        // Calculate arbitrage percentage for each outcome
        if ($match->lay_odds) {
            // Arbitrage formula: (1/back_odds + 1/lay_odds - 1) * 100
            // Negative % = Profitable arbitrage (we win regardless)
            // Positive % = Losing arbitrage (not recommended)
            
            $match->arb_home = round(
                (1 / $match->back_home_odds + 1 / $match->lay_odds->odds_home_lay - 1) * 100, 
                2
            );
            
            $match->arb_draw = ($match->back_draw_odds && $match->lay_odds->odds_draw_lay) 
                ? round(
                    (1 / $match->back_draw_odds + 1 / $match->lay_odds->odds_draw_lay - 1) * 100, 
                    2
                ) 
                : null;
            
            $match->arb_away = round(
                (1 / $match->back_away_odds + 1 / $match->lay_odds->odds_away_lay - 1) * 100, 
                2
            );
            
            // Average arbitrage (excluding null values)
            $arbs = array_filter([$match->arb_home, $match->arb_draw, $match->arb_away], 'is_numeric');
            $match->avg_arb = !empty($arbs) ? round(array_sum($arbs) / count($arbs), 2) : null;
        }
    }

    // Get unique filters
    $sports = DB::table('sports')->pluck('name')->unique();
    // $competitions = DB::table('competitions')->pluck('name')->unique();

    $competitions = DB::table('matches')->pluck('bookmaker')->unique();

    return view('parents.matches.index', compact('backMatches', 'sports', 'competitions'));
}

    public function show($id)
    {
        $match = DB::table('matches')
            ->join('sports', 'matches.sport_id', '=', 'sports.id')
            ->leftJoin('competitions', 'matches.competition_id', '=', 'competitions.id')
            ->select('matches.*', 'sports.name as sport_name', 'competitions.name as competition_name')
            ->where('matches.id', $id)
            ->first();

        return view('parents.matches.show', compact('match'));
    }

    public function orbitech()
    {

        // dd(DB::table('orbitxch_odds')->first());

        $matches = DB::table('orbitxch_odds')->first();
        dd($matches);


        return view('parents.matches.orbitech', compact('matches'));
    }

  

public function orbitechm()
{
    $result = DB::select("
        SELECT 
            m.sports AS Sport,
            m.bookmaker AS Bookmaker,
            m.home_name AS Home_Team,
            m.away_name AS Away_Team,
            m.match_time AS Time,
            m.odds_home AS Bookie_Home,
            m.odds_draw AS Bookie_Draw,
            m.odds_away AS Bookie_Away,
            o.odds_home_lay AS Orbit_LAY_Home,
            o.odds_draw_lay AS Orbit_LAY_Draw,
            o.odds_away_lay AS Orbit_LAY_Away,
            o.volume_home_lay AS Vol_Home,
            o.volume_draw_lay AS Vol_Draw,
            o.volume_away_lay AS Vol_Away,
            ROUND(m.odds_home - o.odds_home_lay, 2) AS Margin_Home,
            ROUND(m.odds_draw - o.odds_draw_lay, 2) AS Margin_Draw,
            ROUND(m.odds_away - o.odds_away_lay, 2) AS Margin_Away
        FROM matches m
        INNER JOIN orbitxch_odds o 
            ON LOWER(TRIM(m.home_name)) = LOWER(TRIM(o.home_name))
            AND LOWER(TRIM(m.away_name)) = LOWER(TRIM(o.away_name))
            AND LOWER(m.sports) = LOWER(o.sport)
        WHERE 
            o.odds_home_lay IS NOT NULL
            -- AND o.odds_draw_lay IS NOT NULL
            AND o.odds_away_lay IS NOT NULL
            AND m.odds_home IS NOT NULL
        ORDER BY m.sports, m.home_name
    ");

    return view('parents.matches.orbitech', compact('result'));
}

}
