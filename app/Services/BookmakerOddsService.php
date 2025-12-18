<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\BookmakerBackOdd;
use Carbon\Carbon;

class BookmakerOddsService
{
    private $apiKey;
    private $baseUrl = 'https://api.the-odds-api.com/v4';

    // French bookmakers
    private $bookmakers = [
        'betclic_fr',
        'netbet_fr',
        'parionssport_fr',
        'pmu_fr',
        'unibet_fr',
        'winamax_fr'
    ];

    // Sport mappings - ALL SPORTS
    private $sports = [
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
        
        // Golf
        'golf_pga_championship',
        'golf_masters_tournament',
        'golf_us_open',
        'golf_the_open_championship',
    ];

    public function __construct()
    {
        $this->apiKey = config('services.odds_api.key', "0d6ab7a90ebed53c7cbfaabfb5cb3256");
    }

    /**
     * Fetch odds for a specific sport from all bookmakers
     */
    public function fetchOddsForSport($sport)
    {
        try {
            Log::info("Fetching odds for sport: {$sport}");

            $response = Http::get("{$this->baseUrl}/sports/{$sport}/odds", [
                'apiKey' => $this->apiKey,
                'regions' => 'eu',
                'markets' => 'h2h',
                'oddsFormat' => 'decimal',
                'bookmakers' => implode(',', $this->bookmakers)
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (empty($data)) {
                    Log::info("No matches found for sport: {$sport}");
                    return [];
                }

                $this->storeOdds($data, $sport);
                
                Log::info("Successfully fetched odds for {$sport}", [
                    'matches' => count($data)
                ]);
                
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
     * Store odds from all bookmakers in the database
     */
    private function storeOdds($oddsData, $sport)
    {
        $storedCount = 0;

        foreach ($oddsData as $match) {
            try {
                $eventId = $match['id'];
                $homeTeam = $match['home_team'];
                $awayTeam = $match['away_team'];
                $commenceTime = Carbon::parse($match['commence_time']);

                // Process each bookmaker's odds for this match
                foreach ($match['bookmakers'] ?? [] as $bookmakerData) {
                    $bookmaker = $bookmakerData['key'];

                    // Skip if not in our bookmakers list
                    if (!in_array($bookmaker, $this->bookmakers)) {
                        continue;
                    }

                    // Extract market data
                    $market = collect($bookmakerData['markets'] ?? [])
                        ->firstWhere('key', 'h2h');

                    if (!$market) {
                        continue;
                    }

                    $outcomes = collect($market['outcomes']);

                    // Extract odds for each outcome
                    $homeOdds = $outcomes->firstWhere('name', $homeTeam)['price'] ?? null;
                    $awayOdds = $outcomes->firstWhere('name', $awayTeam)['price'] ?? null;
                    $drawOdds = $outcomes->firstWhere('name', 'Draw')['price'] ?? null;

                    // Store or update in database
                    BookmakerBackOdd::updateOrCreate(
                        [
                            'event_id' => $eventId,
                            'bookmaker' => $bookmaker,
                            'market_key' => 'h2h'
                        ],
                        [
                            'sport_key' => $match['sport_key'],
                            'sport_title' => $match['sport_title'],
                            'commence_time' => $commenceTime,
                            'home_team' => $homeTeam,
                            'away_team' => $awayTeam,
                            'home_back_odds' => $homeOdds,
                            'away_back_odds' => $awayOdds,
                            'draw_back_odds' => $drawOdds,
                            'last_update' => now(),
                            'raw_data' => $match
                        ]
                    );

                    $storedCount++;
                }

            } catch (\Exception $e) {
                Log::error("Error storing odds for match", [
                    'error' => $e->getMessage(),
                    'match' => $match['home_team'] ?? 'Unknown'
                ]);
            }
        }

        Log::info("Stored odds for {$sport}", [
            'records' => $storedCount
        ]);
    }

    /**
     * Fetch odds for multiple sports by category
     */
    public function fetchBySportCategory($category)
    {
        $sports = array_filter($this->sports, function($sport) use ($category) {
            return str_starts_with($sport, $category . '_');
        });

        $results = [];
        
        foreach ($sports as $sport) {
            $results[$sport] = $this->fetchOddsForSport($sport);
            sleep(1); // Rate limiting
        }

        return $results;
    }

    /**
     * Fetch football odds
     */
    public function fetchFootballOdds()
    {
        return $this->fetchBySportCategory('soccer');
    }

    /**
     * Fetch tennis odds
     */
    public function fetchTennisOdds()
    {
        return $this->fetchBySportCategory('tennis');
    }

    /**
     * Fetch basketball odds
     */
    public function fetchBasketballOdds()
    {
        return $this->fetchBySportCategory('basketball');
    }

    /**
     * Fetch handball odds
     */
    public function fetchHandballOdds()
    {
        return $this->fetchBySportCategory('handball');
    }

    /**
     * Fetch ice hockey odds
     */
    public function fetchIceHockeyOdds()
    {
        return $this->fetchBySportCategory('icehockey');
    }

    /**
     * Fetch American football odds
     */
    public function fetchAmericanFootballOdds()
    {
        return $this->fetchBySportCategory('americanfootball');
    }

    /**
     * Fetch rugby union odds
     */
    public function fetchRugbyUnionOdds()
    {
        return $this->fetchBySportCategory('rugbyunion');
    }

    /**
     * Fetch rugby league odds
     */
    public function fetchRugbyLeagueOdds()
    {
        return $this->fetchBySportCategory('rugbyleague');
    }

    /**
     * Fetch MMA odds
     */
    public function fetchMMAOdds()
    {
        return $this->fetchBySportCategory('mma');
    }

    /**
     * Fetch boxing odds
     */
    public function fetchBoxingOdds()
    {
        return $this->fetchBySportCategory('boxing');
    }

    /**
     * Fetch volleyball odds
     */
    public function fetchVolleyballOdds()
    {
        $volleyballSports = array_filter($this->sports, function($sport) {
            return str_starts_with($sport, 'volleyball');
        });

        $results = [];
        foreach ($volleyballSports as $sport) {
            $results[$sport] = $this->fetchOddsForSport($sport);
            sleep(1);
        }

        return $results;
    }

    /**
     * Fetch golf odds
     */
    public function fetchGolfOdds()
    {
        return $this->fetchBySportCategory('golf');
    }

    /**
     * Fetch odds for all sports
     */
    public function fetchAllSports()
    {
        $results = [
            'football' => $this->fetchFootballOdds(),
            'tennis' => $this->fetchTennisOdds(),
            'basketball' => $this->fetchBasketballOdds(),
            'handball' => $this->fetchHandballOdds(),
            'ice_hockey' => $this->fetchIceHockeyOdds(),
            'american_football' => $this->fetchAmericanFootballOdds(),
            'rugby_union' => $this->fetchRugbyUnionOdds(),
            'rugby_league' => $this->fetchRugbyLeagueOdds(),
            'mma' => $this->fetchMMAOdds(),
            'boxing' => $this->fetchBoxingOdds(),
            'volleyball' => $this->fetchVolleyballOdds(),
            'golf' => $this->fetchGolfOdds(),
        ];

        return $results;
    }

    /**
     * Get odds comparison for a specific event
     */
    public function getEventComparison($eventId)
    {
        return BookmakerBackOdd::where('event_id', $eventId)
            ->get()
            ->groupBy('bookmaker')
            ->map(function($odds) {
                $odd = $odds->first();
                return [
                    'bookmaker' => $odd->bookmaker,
                    'home_odds' => $odd->home_back_odds,
                    'away_odds' => $odd->away_back_odds,
                    'draw_odds' => $odd->draw_back_odds,
                    'last_update' => $odd->last_update
                ];
            });
    }

    /**
     * Get best odds across all bookmakers for upcoming matches
     */
    public function getBestOdds($sport = null, $hours = 48)
    {
        $query = BookmakerBackOdd::upcoming()->withinHours($hours);

        if ($sport) {
            $query->bySport($sport);
        }

        return $query->get()
            ->groupBy('event_id')
            ->map(function($eventOdds) {
                $match = $eventOdds->first();
                
                return [
                    'event_id' => $match->event_id,
                    'sport' => $match->sport_title,
                    'home_team' => $match->home_team,
                    'away_team' => $match->away_team,
                    'commence_time' => $match->commence_time,
                    'best_home_odds' => $eventOdds->max('home_back_odds'),
                    'best_home_bookmaker' => $eventOdds->sortByDesc('home_back_odds')->first()->bookmaker,
                    'best_away_odds' => $eventOdds->max('away_back_odds'),
                    'best_away_bookmaker' => $eventOdds->sortByDesc('away_back_odds')->first()->bookmaker,
                    'best_draw_odds' => $eventOdds->max('draw_back_odds'),
                    'best_draw_bookmaker' => $eventOdds->filter(fn($o) => $o->draw_back_odds)->sortByDesc('draw_back_odds')->first()?->bookmaker,
                    'all_bookmakers' => $eventOdds->pluck('bookmaker')->toArray()
                ];
            });
    }

    /**
     * Get statistics about stored odds
     */
    public function getStatistics()
    {
        $stats = [
            'total_matches' => BookmakerBackOdd::select('event_id')->distinct()->count(),
            'total_records' => BookmakerBackOdd::count(),
            'upcoming_matches' => BookmakerBackOdd::upcoming()->select('event_id')->distinct()->count(),
            'bookmakers' => [],
            'sports' => []
        ];

        // Bookmaker stats
        foreach ($this->bookmakers as $bookmaker) {
            $stats['bookmakers'][$bookmaker] = BookmakerBackOdd::byBookmaker($bookmaker)
                ->upcoming()
                ->count();
        }

        // Sport categories stats
        $sportCategories = [
            'football' => 'soccer_%',
            'tennis' => 'tennis_%',
            'basketball' => 'basketball_%',
            'handball' => 'handball_%',
            'ice_hockey' => 'icehockey_%',
            'american_football' => 'americanfootball_%',
            'rugby_union' => 'rugbyunion_%',
            'rugby_league' => 'rugbyleague_%',
            'mma' => 'mma_%',
            'boxing' => 'boxing_%',
            'volleyball' => 'volleyball%',
            'golf' => 'golf_%',
        ];

        foreach ($sportCategories as $category => $pattern) {
            $stats['sports'][$category] = BookmakerBackOdd::upcoming()
                ->where('sport_key', 'like', $pattern)
                ->select('event_id')
                ->distinct()
                ->count();
        }

        $stats['last_update'] = BookmakerBackOdd::max('last_update');

        return $stats;
    }

    /**
     * Get supported bookmakers
     */
    public function getBookmakers()
    {
        return $this->bookmakers;
    }

    /**
     * Get supported sports
     */
    public function getSupportedSports()
    {
        return $this->sports;
    }
    
    /**
     * Get bookmaker name in readable format
     */
    public function getBookmakerName($key)
    {
        $names = [
            'betclic_fr' => 'Betclic',
            'netbet_fr' => 'NetBet',
            'parionssport_fr' => 'Parions Sport',
            'pmu_fr' => 'PMU',
            'unibet_fr' => 'Unibet',
            'winamax_fr' => 'Winamax'
        ];

        return $names[$key] ?? $key;
    }
}