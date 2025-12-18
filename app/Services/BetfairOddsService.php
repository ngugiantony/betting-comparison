<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\BetfairLayOdd;
use Carbon\Carbon;

class BetfairOddsService
{
    private $apiKey;
    private $baseUrl = 'https://api.the-odds-api.com/v4';

    // Sport mappings for all supported sports
    private $supportedSports = [
        // Football/Soccer
        'soccer_france_ligue_one',
        'soccer_france_ligue_two',
        'soccer_epl',
        'soccer_spain_la_liga',
        'soccer_germany_bundesliga',
        'soccer_italy_serie_a',
        'soccer_uefa_champs_league',
        'soccer_uefa_europa_league',
        
        // Tennis
        'tennis_atp_australian_open',
        'tennis_atp_french_open',
        'tennis_atp_us_open',
        'tennis_atp_wimbledon',
        'tennis_wta_australian_open',
        'tennis_wta_french_open',
        'tennis_wta_us_open',
        'tennis_wta_wimbledon',
        
        // Basketball
        'basketball_nba',
        'basketball_euroleague',
        'basketball_france_lnb',
        
        // Ice Hockey
        'icehockey_nhl',
        'icehockey_sweden_hockey_league',
        
        // Handball
        'handball_france_lnh',
        'handball_germany_bundesliga',
        
        // American Football
        'americanfootball_nfl',
        
        // Rugby Union (XV)
        'rugbyunion_six_nations',
        'rugbyunion_top_14',
        
        // Rugby League (XIII)
        'rugbyleague_nrl',
        
        // MMA
        'mma_mixed_martial_arts',
        
        // Boxing
        'boxing_boxing',
        
        // Volleyball
        'volleyball',
    ];

    public function __construct()
    {
        $this->apiKey = config('services.odds_api.key', "0d6ab7a90ebed53c7cbfaabfb5cb3256");
    }

    /**
     * Get all available sports from the API
     */
    public function getAvailableSports()
    {
        try {
            $response = Http::get("{$this->baseUrl}/sports", [
                'apiKey' => $this->apiKey
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch sports list', ['response' => $response->body()]);
            return [];
        } catch (\Exception $e) {
            Log::error('Error fetching sports: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch Betfair lay odds for a specific sport
     * 
     * @param string $sport - Sport key (e.g., 'soccer_france_ligue_one', 'tennis_atp_french_open')
     * @return array|null
     */
    public function fetchBetfairLayOdds($sport)
    {
        try {
            Log::info("Fetching Betfair lay odds for: {$sport}");

            $response = Http::get("{$this->baseUrl}/sports/{$sport}/odds", [
                'apiKey' => $this->apiKey,
                'regions' => 'eu',
                'markets' => 'h2h_lay',
                'oddsFormat' => 'decimal',
                'bookmakers' => 'betfair_ex_eu'
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Log the response for debugging
                Log::info("Betfair API Response for {$sport}", [
                    'matches_count' => count($data)
                ]);

                if (empty($data)) {
                    Log::info("No matches found for: {$sport}");
                    return [];
                }

                $this->storeBetfairLayOdds($data, $sport);
                
                Log::info("Successfully fetched {$sport}", ['matches' => count($data)]);
                return $data;
            }

            Log::error("Failed to fetch odds for {$sport}", [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            
            return null;
        } catch (\Exception $e) {
            Log::error("Error fetching odds for {$sport}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch odds for all soccer leagues
     */
    public function fetchAllSoccerOdds()
    {
        $soccerLeagues = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'soccer_');
        });

        $results = [];
        foreach ($soccerLeagues as $league) {
            $results[$league] = $this->fetchBetfairLayOdds($league);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for all tennis tournaments
     */
    public function fetchAllTennisOdds()
    {
        $tennisTournaments = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'tennis_');
        });

        $results = [];
        foreach ($tennisTournaments as $tournament) {
            $results[$tournament] = $this->fetchBetfairLayOdds($tournament);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for all basketball
     */
    public function fetchAllBasketballOdds()
    {
        $basketballLeagues = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'basketball_');
        });

        $results = [];
        foreach ($basketballLeagues as $league) {
            $results[$league] = $this->fetchBetfairLayOdds($league);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for all handball leagues
     */
    public function fetchAllHandballOdds()
    {
        $handballLeagues = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'handball_');
        });

        $results = [];
        foreach ($handballLeagues as $league) {
            $results[$league] = $this->fetchBetfairLayOdds($league);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for all ice hockey
     */
    public function fetchAllIceHockeyOdds()
    {
        $iceHockeyLeagues = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'icehockey_');
        });

        $results = [];
        foreach ($iceHockeyLeagues as $league) {
            $results[$league] = $this->fetchBetfairLayOdds($league);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for American football
     */
    public function fetchAllAmericanFootballOdds()
    {
        $americanFootballLeagues = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'americanfootball_');
        });

        $results = [];
        foreach ($americanFootballLeagues as $league) {
            $results[$league] = $this->fetchBetfairLayOdds($league);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for Rugby Union
     */
    public function fetchAllRugbyUnionOdds()
    {
        $rugbyUnionLeagues = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'rugbyunion_');
        });

        $results = [];
        foreach ($rugbyUnionLeagues as $league) {
            $results[$league] = $this->fetchBetfairLayOdds($league);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for Rugby League
     */
    public function fetchAllRugbyLeagueOdds()
    {
        $rugbyLeagueLeagues = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'rugbyleague_');
        });

        $results = [];
        foreach ($rugbyLeagueLeagues as $league) {
            $results[$league] = $this->fetchBetfairLayOdds($league);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for MMA
     */
    public function fetchAllMMAOdds()
    {
        $mmaLeagues = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'mma_');
        });

        $results = [];
        foreach ($mmaLeagues as $league) {
            $results[$league] = $this->fetchBetfairLayOdds($league);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for Boxing
     */
    public function fetchAllBoxingOdds()
    {
        $boxingLeagues = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'boxing_');
        });

        $results = [];
        foreach ($boxingLeagues as $league) {
            $results[$league] = $this->fetchBetfairLayOdds($league);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for Volleyball
     */
    public function fetchAllVolleyballOdds()
    {
        $volleyballLeagues = array_filter($this->supportedSports, function($sport) {
            return str_starts_with($sport, 'volleyball');
        });

        $results = [];
        foreach ($volleyballLeagues as $league) {
            $results[$league] = $this->fetchBetfairLayOdds($league);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch odds for all supported sports
     */
    public function fetchAllSports()
    {
        $results = [
            'soccer' => $this->fetchAllSoccerOdds(),
            'tennis' => $this->fetchAllTennisOdds(),
            'basketball' => $this->fetchAllBasketballOdds(),
            'handball' => $this->fetchAllHandballOdds(),
            'ice_hockey' => $this->fetchAllIceHockeyOdds(),
            'american_football' => $this->fetchAllAmericanFootballOdds(),
            'rugby_union' => $this->fetchAllRugbyUnionOdds(),
            'rugby_league' => $this->fetchAllRugbyLeagueOdds(),
            'mma' => $this->fetchAllMMAOdds(),
            'boxing' => $this->fetchAllBoxingOdds(),
            'volleyball' => $this->fetchAllVolleyballOdds(),
        ];

        return $results;
    }

    /**
     * Store Betfair lay odds in database
     */
    private function storeBetfairLayOdds($oddsData, $sport)
    {
        $storedCount = 0;

        foreach ($oddsData as $match) {
            try {
                // Find Betfair Exchange bookmaker
                $betfairData = collect($match['bookmakers'] ?? [])
                    ->firstWhere('key', 'betfair_ex_eu');

                if (!$betfairData) {
                    Log::warning("No Betfair data found for match", [
                        'match' => $match['home_team'] . ' vs ' . $match['away_team']
                    ]);
                    continue;
                }

                // Extract market data
                $market = $betfairData['markets'][0] ?? null;
                
                if (!$market || $market['key'] !== 'h2h_lay') {
                    continue;
                }

                $outcomes = collect($market['outcomes']);
                
                $homeTeam = $match['home_team'];
                $awayTeam = $match['away_team'];

                // Extract lay odds for each outcome
                $homeOdds = $outcomes->firstWhere('name', $homeTeam)['price'] ?? null;
                $awayOdds = $outcomes->firstWhere('name', $awayTeam)['price'] ?? null;
                $drawOdds = $outcomes->firstWhere('name', 'Draw')['price'] ?? null;

                // Create unique event ID
                $eventId = $match['id'];

                // Store or update in database
                BetfairLayOdd::updateOrCreate(
                    ['event_id' => $eventId],
                    [
                        'sport_key' => $match['sport_key'],
                        'sport_title' => $match['sport_title'],
                        'commence_time' => Carbon::parse($match['commence_time']),
                        'home_team' => $homeTeam,
                        'away_team' => $awayTeam,
                        'home_lay_odds' => $homeOdds,
                        'away_lay_odds' => $awayOdds,
                        'draw_lay_odds' => $drawOdds,
                        'market_key' => 'h2h_lay',
                        'last_update' => now(),
                        'raw_data' => $match
                    ]
                );

                $storedCount++;
            } catch (\Exception $e) {
                Log::error("Error storing match odds", [
                    'error' => $e->getMessage(),
                    'match' => $match['home_team'] ?? 'Unknown'
                ]);
            }
        }

        Log::info("Stored Betfair lay odds for {$sport}", ['count' => $storedCount]);
    }

    /**
     * Get upcoming matches for a specific sport
     */
    public function getUpcomingMatches($sport, $hours = 48)
    {
        return BetfairLayOdd::bySport($sport)
            ->upcoming()
            ->withinHours($hours)
            ->orderBy('commence_time')
            ->get();
    }

    /**
     * Get all upcoming matches grouped by sport
     */
    public function getAllUpcomingMatches($hours = 48)
    {
        $matches = BetfairLayOdd::upcoming()
            ->withinHours($hours)
            ->orderBy('sport_key')
            ->orderBy('commence_time')
            ->get()
            ->groupBy('sport_key');

        return $matches;
    }

    /**
     * Get statistics about stored odds
     */
    public function getStatistics()
    {
        return [
            'total_matches' => BetfairLayOdd::upcoming()->count(),
            'soccer_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'soccer_%')
                ->count(),
            'tennis_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'tennis_%')
                ->count(),
            'basketball_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'basketball_%')
                ->count(),
            'handball_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'handball_%')
                ->count(),
            'ice_hockey_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'icehockey_%')
                ->count(),
            'american_football_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'americanfootball_%')
                ->count(),
            'rugby_union_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'rugbyunion_%')
                ->count(),
            'rugby_league_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'rugbyleague_%')
                ->count(),
            'mma_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'mma_%')
                ->count(),
            'boxing_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'boxing_%')
                ->count(),
            'volleyball_matches' => BetfairLayOdd::upcoming()
                ->where('sport_key', 'like', 'volleyball%')
                ->count(),
            'last_update' => BetfairLayOdd::max('last_update'),
            'oldest_match' => BetfairLayOdd::upcoming()->min('commence_time'),
            'latest_match' => BetfairLayOdd::upcoming()->max('commence_time'),
        ];
    }

    /**
     * Clean old matches from database
     */
    public function cleanOldMatches($daysOld = 1)
    {
        $deleted = BetfairLayOdd::where('commence_time', '<', now()->subDays($daysOld))
            ->delete();

        Log::info("Cleaned old matches", ['deleted' => $deleted]);
        return $deleted;
    }
    
    /**
     * Get supported sports list
     */
    public function getSupportedSports()
    {
        return $this->supportedSports;
    }
}