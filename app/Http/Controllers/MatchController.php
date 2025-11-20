<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function index(Request $request)
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
