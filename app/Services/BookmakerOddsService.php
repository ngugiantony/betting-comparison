<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\BookmakerBackOdd;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    // Market definitions by sport category
    private $sportMarkets = [
        // Soccer markets
        'soccer' => [
            'h2h',
            'spreads',
            'totals',
            'h2h_lay',
            'btts',                    // Both Teams to Score
            'draw_no_bet',             // Draw No Bet
            'h2h_3_way',               // 3-way moneyline
            'h2h_h1',                  // 1st half moneyline
            'h2h_h2',                  // 2nd half moneyline
            'h2h_3_way_h1',            // 1st half 3-way
            'h2h_3_way_h2',            // 2nd half 3-way
            'double_chance',           // Double Chance
            'alternate_spreads_corners', // Handicap Corners
            'alternate_totals_corners',  // Total Corners
            'alternate_spreads_cards',   // Handicap Cards
            'alternate_totals_cards',    // Total Cards
            // Player props (limited bookmakers)
            'player_goal_scorer_anytime',
            'player_first_goal_scorer',
            'player_last_goal_scorer',
            'player_to_receive_card',
            'player_to_receive_red_card',
            'player_shots_on_target',
            'player_shots',
            'player_assists',
        ],

        // Basketball markets (NBA, NCAAB, Euroleague, etc.)
        'basketball' => [
            'h2h',
            'spreads',
            'totals',
            'h2h_lay',
            'alternate_spreads',
            'alternate_totals',
            'team_totals',
            'alternate_team_totals',
            // Quarter markets
            'h2h_q1', 'h2h_q2', 'h2h_q3', 'h2h_q4',
            'spreads_q1', 'spreads_q2', 'spreads_q3', 'spreads_q4',
            'totals_q1', 'totals_q2', 'totals_q3', 'totals_q4',
            'alternate_spreads_q1', 'alternate_spreads_q2', 'alternate_spreads_q3', 'alternate_spreads_q4',
            'alternate_totals_q1', 'alternate_totals_q2', 'alternate_totals_q3', 'alternate_totals_q4',
            'team_totals_q1', 'team_totals_q2', 'team_totals_q3', 'team_totals_q4',
            'alternate_team_totals_q1', 'alternate_team_totals_q2', 'alternate_team_totals_q3', 'alternate_team_totals_q4',
            // Half markets
            'h2h_h1', 'h2h_h2',
            'spreads_h1', 'spreads_h2',
            'totals_h1', 'totals_h2',
            'alternate_spreads_h1', 'alternate_spreads_h2',
            'alternate_totals_h1', 'alternate_totals_h2',
            'team_totals_h1', 'team_totals_h2',
            'alternate_team_totals_h1', 'alternate_team_totals_h2',
            // Player props (US bookmakers)
            'player_points', 'player_points_q1',
            'player_rebounds', 'player_rebounds_q1',
            'player_assists', 'player_assists_q1',
            'player_threes', 'player_blocks', 'player_steals',
            'player_blocks_steals', 'player_turnovers',
            'player_points_rebounds_assists',
            'player_points_rebounds', 'player_points_assists', 'player_rebounds_assists',
            'player_field_goals', 'player_frees_made', 'player_frees_attempts',
            'player_first_basket', 'player_first_team_basket',
            'player_double_double', 'player_triple_double',
            'player_method_of_first_basket',
            // Alternate player props
            'player_points_alternate', 'player_rebounds_alternate', 'player_assists_alternate',
            'player_blocks_alternate', 'player_steals_alternate', 'player_turnovers_alternate',
            'player_threes_alternate', 'player_points_assists_alternate',
            'player_points_rebounds_alternate', 'player_rebounds_assists_alternate',
            'player_points_rebounds_assists_alternate',
        ],

        // American Football markets (NFL, NCAAF, CFL)
        'americanfootball' => [
            'h2h',
            'spreads',
            'totals',
            'h2h_lay',
            'alternate_spreads',
            'alternate_totals',
            'team_totals',
            'alternate_team_totals',
            // Quarter markets
            'h2h_q1', 'h2h_q2', 'h2h_q3', 'h2h_q4',
            'h2h_3_way_q1', 'h2h_3_way_q2', 'h2h_3_way_q3', 'h2h_3_way_q4',
            'spreads_q1', 'spreads_q2', 'spreads_q3', 'spreads_q4',
            'totals_q1', 'totals_q2', 'totals_q3', 'totals_q4',
            'alternate_spreads_q1', 'alternate_spreads_q2', 'alternate_spreads_q3', 'alternate_spreads_q4',
            'alternate_totals_q1', 'alternate_totals_q2', 'alternate_totals_q3', 'alternate_totals_q4',
            'team_totals_q1', 'team_totals_q2', 'team_totals_q3', 'team_totals_q4',
            'alternate_team_totals_q1', 'alternate_team_totals_q2', 'alternate_team_totals_q3', 'alternate_team_totals_q4',
            // Half markets
            'h2h_h1', 'h2h_h2',
            'h2h_3_way_h1', 'h2h_3_way_h2',
            'spreads_h1', 'spreads_h2',
            'totals_h1', 'totals_h2',
            'alternate_spreads_h1', 'alternate_spreads_h2',
            'alternate_totals_h1', 'alternate_totals_h2',
            'team_totals_h1', 'team_totals_h2',
            'alternate_team_totals_h1', 'alternate_team_totals_h2',
            // Player props
            'player_assists', 'player_defensive_interceptions', 'player_field_goals',
            'player_kicking_points', 'player_pass_attempts', 'player_pass_completions',
            'player_pass_interceptions', 'player_pass_longest_completion',
            'player_pass_rush_yds', 'player_pass_rush_reception_tds', 'player_pass_rush_reception_yds',
            'player_pass_tds', 'player_pass_yds', 'player_pass_yds_q1',
            'player_pats', 'player_receptions', 'player_reception_longest',
            'player_reception_tds', 'player_reception_yds',
            'player_rush_attempts', 'player_rush_longest', 'player_rush_reception_tds',
            'player_rush_reception_yds', 'player_rush_tds', 'player_rush_yds',
            'player_sacks', 'player_solo_tackles', 'player_tackles_assists',
            'player_tds_over', 'player_1st_td', 'player_anytime_td', 'player_last_td',
            // Alternate player props
            'player_assists_alternate', 'player_field_goals_alternate',
            'player_kicking_points_alternate', 'player_pass_attempts_alternate',
            'player_pass_completions_alternate', 'player_pass_interceptions_alternate',
            'player_pass_longest_completion_alternate', 'player_pass_rush_yds_alternate',
            'player_pass_rush_reception_tds_alternate', 'player_pass_rush_reception_yds_alternate',
            'player_pass_tds_alternate', 'player_pass_yds_alternate', 'player_pats_alternate',
            'player_receptions_alternate', 'player_reception_longest_alternate',
            'player_reception_tds_alternate', 'player_reception_yds_alternate',
            'player_rush_attempts_alternate', 'player_rush_longest_alternate',
            'player_rush_reception_tds_alternate', 'player_rush_reception_yds_alternate',
            'player_rush_tds_alternate', 'player_rush_yds_alternate',
            'player_sacks_alternate', 'player_solo_tackles_alternate', 'player_tackles_assists_alternate',
        ],

        // Ice Hockey markets (NHL, SHL, etc.)
        'icehockey' => [
            'h2h',
            'spreads',
            'totals',
            'h2h_lay',
            'alternate_spreads',
            'alternate_totals',
            'team_totals',
            'alternate_team_totals',
            // Period markets
            'h2h_p1', 'h2h_p2', 'h2h_p3',
            'h2h_3_way_p1', 'h2h_3_way_p2', 'h2h_3_way_p3',
            'spreads_p1', 'spreads_p2', 'spreads_p3',
            'totals_p1', 'totals_p2', 'totals_p3',
            'alternate_spreads_p1', 'alternate_spreads_p2', 'alternate_spreads_p3',
            'alternate_totals_p1', 'alternate_totals_p2', 'alternate_totals_p3',
            'team_totals_p1', 'team_totals_p2', 'team_totals_p3',
            'alternate_team_totals_p1', 'alternate_team_totals_p2', 'alternate_team_totals_p3',
            // Player props
            'player_points', 'player_power_play_points', 'player_assists',
            'player_blocked_shots', 'player_shots_on_goal', 'player_goals',
            'player_total_saves', 'player_goal_scorer_first',
            'player_goal_scorer_last', 'player_goal_scorer_anytime',
            // Alternate player props
            'player_points_alternate', 'player_assists_alternate',
            'player_power_play_points_alternate', 'player_goals_alternate',
            'player_shots_on_goal_alternate', 'player_blocked_shots_alternate',
            'player_total_saves_alternate',
        ],

        // Baseball markets (MLB, etc.)
        'baseball' => [
            'h2h',
            'spreads',
            'totals',
            'h2h_lay',
            'alternate_spreads',
            'alternate_totals',
            'team_totals',
            'alternate_team_totals',
            // Inning markets
            'h2h_1st_1_innings', 'h2h_1st_3_innings', 'h2h_1st_5_innings', 'h2h_1st_7_innings',
            'h2h_3_way_1st_1_innings', 'h2h_3_way_1st_3_innings', 'h2h_3_way_1st_5_innings', 'h2h_3_way_1st_7_innings',
            'spreads_1st_1_innings', 'spreads_1st_3_innings', 'spreads_1st_5_innings', 'spreads_1st_7_innings',
            'totals_1st_1_innings', 'totals_1st_3_innings', 'totals_1st_5_innings', 'totals_1st_7_innings',
            'alternate_spreads_1st_1_innings', 'alternate_spreads_1st_3_innings', 
            'alternate_spreads_1st_5_innings', 'alternate_spreads_1st_7_innings',
            'alternate_totals_1st_1_innings', 'alternate_totals_1st_3_innings',
            'alternate_totals_1st_5_innings', 'alternate_totals_1st_7_innings',
            // Player props
            'batter_home_runs', 'batter_first_home_run', 'batter_hits',
            'batter_total_bases', 'batter_rbis', 'batter_runs_scored',
            'batter_hits_runs_rbis', 'batter_singles', 'batter_doubles',
            'batter_triples', 'batter_walks', 'batter_strikeouts', 'batter_stolen_bases',
            'pitcher_strikeouts', 'pitcher_record_a_win', 'pitcher_hits_allowed',
            'pitcher_walks', 'pitcher_earned_runs', 'pitcher_outs',
            // Alternate player props
            'batter_total_bases_alternate', 'batter_home_runs_alternate',
            'batter_hits_alternate', 'batter_rbis_alternate', 'batter_walks_alternate',
            'batter_strikeouts_alternate', 'batter_runs_scored_alternate',
            'batter_singles_alternate', 'batter_doubles_alternate', 'batter_triples_alternate',
            'pitcher_hits_allowed_alternate', 'pitcher_walks_alternate', 'pitcher_strikeouts_alternate',
        ],

        // Handball markets
        'handball' => [
            'h2h',
            'spreads',
            'totals',
            'h2h_lay',
        ],

        // Rugby Union markets
        'rugbyunion' => [
            'h2h',
            'spreads',
            'totals',
            'h2h_lay',
        ],

        // Rugby League markets (NRL, etc.)
        'rugbyleague' => [
            'h2h',
            'spreads',
            'totals',
            'h2h_lay',
            // Player props (AU bookmakers)
            'player_try_scorer_first',
            'player_try_scorer_last',
            'player_try_scorer_anytime',
            'player_try_scorer_over',
        ],

        // Tennis markets
        'tennis' => [
            'h2h',
            'h2h_lay',
            'outrights',
            'outrights_lay',
        ],

        // MMA markets
        'mma' => [
            'h2h',
            'h2h_lay',
        ],

        // Boxing markets
        'boxing' => [
            'h2h',
            'h2h_lay',
        ],

        // Volleyball markets
        'volleyball' => [
            'h2h',
            'spreads',
            'totals',
            'h2h_lay',
        ],

        // Golf markets
        'golf' => [
            'outrights',
            'outrights_lay',
        ],

        // AFL markets (Australian Football)
        'afl' => [
            'h2h',
            'spreads',
            'totals',
            'h2h_lay',
            // Player props (AU bookmakers)
            'player_disposals', 'player_disposals_over',
            'player_goal_scorer_first', 'player_goal_scorer_last',
            'player_goal_scorer_anytime', 'player_goals_scored_over',
            'player_marks_over', 'player_marks_most',
            'player_tackles_over', 'player_tackles_most',
            'player_afl_fantasy_points', 'player_afl_fantasy_points_over',
            'player_afl_fantasy_points_most',
        ],
    ];

    // Sport mappings
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
     * Get available markets for a specific sport
     */
    public function getMarketsForSport($sport)
    {
        // Determine sport category
        $category = $this->getSportCategory($sport);
        
        return $this->sportMarkets[$category] ?? ['h2h', 'h2h_lay'];
    }

    /**
     * Get sport category from sport key
     */
    private function getSportCategory($sport)
    {
        if (str_starts_with($sport, 'soccer_')) return 'soccer';
        if (str_starts_with($sport, 'basketball_')) return 'basketball';
        if (str_starts_with($sport, 'americanfootball_')) return 'americanfootball';
        if (str_starts_with($sport, 'icehockey_')) return 'icehockey';
        if (str_starts_with($sport, 'baseball_')) return 'baseball';
        if (str_starts_with($sport, 'handball_')) return 'handball';
        if (str_starts_with($sport, 'rugbyunion_')) return 'rugbyunion';
        if (str_starts_with($sport, 'rugbyleague_')) return 'rugbyleague';
        if (str_starts_with($sport, 'tennis_')) return 'tennis';
        if (str_starts_with($sport, 'mma_')) return 'mma';
        if (str_starts_with($sport, 'boxing_')) return 'boxing';
        if (str_starts_with($sport, 'volleyball')) return 'volleyball';
        if (str_starts_with($sport, 'golf_')) return 'golf';
        if (str_starts_with($sport, 'aussierules_')) return 'afl';
        
        return 'default';
    }

    /**
     * Fetch odds for a specific sport with markets
     */
    public function fetchOddsForSport($sport, $markets = null)
    {
        try {
            // Get available markets for this sport if not specified
            $marketsToFetch = $markets ?? $this->getMarketsForSport($sport);
            
            // Limit to featured markets for batch requests (to avoid API limits)
            $featuredMarkets = array_intersect($marketsToFetch, ['h2h', 'spreads', 'totals', 'h2h_lay']);
            
            Log::info("Fetching odds for sport: {$sport}", [
                'markets' => $featuredMarkets
            ]);

            $response = Http::get("{$this->baseUrl}/sports/{$sport}/odds", [
                'apiKey' => $this->apiKey,
                'regions' => 'eu',
                'markets' => implode(',', $featuredMarkets),
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
                    'matches' => count($data),
                    'markets' => $featuredMarkets
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
     * Fetch additional markets for a specific event
     * Uses the /events/{eventId}/odds endpoint for detailed markets
     */
    public function fetchEventMarkets($eventId, $sport, $markets = [])
    {
        try {
            Log::info("Fetching event markets", [
                'event_id' => $eventId,
                'sport' => $sport,
                'markets' => $markets
            ]);

            $params = [
                'apiKey' => $this->apiKey,
                'regions' => 'eu',
                'oddsFormat' => 'decimal',
                'bookmakers' => implode(',', $this->bookmakers)
            ];

            if (!empty($markets)) {
                $params['markets'] = implode(',', $markets);
            }

            $response = Http::get("{$this->baseUrl}/sports/{$sport}/events/{$eventId}/odds", $params);

            if ($response->successful()) {
                $data = $response->json();
                
                // Store the event odds
                $this->storeOdds([$data], $sport);
                
                Log::info("Successfully fetched event markets", [
                    'event_id' => $eventId,
                    'markets_found' => count($data['bookmakers'][0]['markets'] ?? [])
                ]);
                
                return $data;
            }

            Log::error("Failed to fetch event markets", [
                'event_id' => $eventId,
                'status' => $response->status()
            ]);
            
            return null;

        } catch (\Exception $e) {
            Log::error("Error fetching event markets: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Store odds from all bookmakers and markets in the database
     */
    private function storeOdds($oddsData, $sport)
    {
        $storedCount = 0;

        foreach ($oddsData as $match) {
            try {
                $eventId = $match['id'];
                $homeTeam = $match['home_team'] ?? null;
                $awayTeam = $match['away_team'] ?? null;
                $commenceTime = Carbon::parse($match['commence_time']);

                foreach ($match['bookmakers'] ?? [] as $bookmakerData) {
                    $bookmaker = $bookmakerData['key'];

                    if (!in_array($bookmaker, $this->bookmakers)) {
                        continue;
                    }

                    foreach ($bookmakerData['markets'] ?? [] as $market) {
                        $marketKey = $market['key'];
                        
                        $marketData = $this->extractMarketData($market, $homeTeam, $awayTeam);
                        
                        BookmakerBackOdd::updateOrCreate(
                            [
                                'event_id' => $eventId,
                                'bookmaker' => $bookmaker,
                                'market_key' => $marketKey
                            ],
                            [
                                'sport_key' => $match['sport_key'],
                                'sport_title' => $match['sport_title'],
                                'commence_time' => $commenceTime,
                                'home_team' => $homeTeam,
                                'away_team' => $awayTeam,
                                'home_back_odds' => $marketData['home_odds'] ?? null,
                                'away_back_odds' => $marketData['away_odds'] ?? null,
                                'draw_back_odds' => $marketData['draw_odds'] ?? null,
                                'market_data' => $marketData,
                                'last_update' => now(),
                                'raw_data' => $match
                            ]
                        );

                        $storedCount++;
                    }
                }

            } catch (\Exception $e) {
                Log::error("Error storing odds for match", [
                    'error' => $e->getMessage(),
                    'event_id' => $match['id'] ?? 'Unknown'
                ]);
            }
        }

        Log::info("Stored odds for {$sport}", [
            'records' => $storedCount
        ]);
    }

    /**
     * Extract market-specific data based on market type
     */
    private function extractMarketData($market, $homeTeam, $awayTeam)
    {
        $marketKey = $market['key'];
        $outcomes = collect($market['outcomes']);
        
        $data = [
            'market_type' => $marketKey,
            'last_update' => $market['last_update'] ?? null,
        ];

        // H2H markets
        if (str_starts_with($marketKey, 'h2h') && !str_contains($marketKey, 'lay')) {
            $data['home_odds'] = $outcomes->firstWhere('name', $homeTeam)['price'] ?? null;
            $data['away_odds'] = $outcomes->firstWhere('name', $awayTeam)['price'] ?? null;
            
            // Check for draw (soccer, hockey 3-way, etc.)
            $drawOutcome = $outcomes->firstWhere('name', 'Draw');
            $data['draw_odds'] = $drawOutcome['price'] ?? null;
        }

        // Spreads markets
        elseif (str_starts_with($marketKey, 'spreads') || str_starts_with($marketKey, 'alternate_spreads')) {
            $data['spreads'] = $outcomes->map(function($outcome) {
                return [
                    'name' => $outcome['name'],
                    'point' => $outcome['point'] ?? null,
                    'price' => $outcome['price']
                ];
            })->toArray();
            
            if ($homeTeam && $awayTeam) {
                $homeSpread = $outcomes->firstWhere('name', $homeTeam);
                $awaySpread = $outcomes->firstWhere('name', $awayTeam);
                
                $data['home_spread_point'] = $homeSpread['point'] ?? null;
                $data['home_spread_odds'] = $homeSpread['price'] ?? null;
                $data['away_spread_point'] = $awaySpread['point'] ?? null;
                $data['away_spread_odds'] = $awaySpread['price'] ?? null;
            }
        }

        // Totals markets
        elseif (str_starts_with($marketKey, 'totals') || str_starts_with($marketKey, 'alternate_totals')) {
            $data['totals'] = $outcomes->map(function($outcome) {
                return [
                    'name' => $outcome['name'],
                    'point' => $outcome['point'] ?? null,
                    'price' => $outcome['price']
                ];
            })->toArray();
            
            $over = $outcomes->firstWhere('name', 'Over');
            $under = $outcomes->firstWhere('name', 'Under');
            
            $data['total_point'] = $over['point'] ?? $under['point'] ?? null;
            $data['over_odds'] = $over['price'] ?? null;
            $data['under_odds'] = $under['price'] ?? null;
        }

        // Team totals
        elseif (str_starts_with($marketKey, 'team_totals') || str_starts_with($marketKey, 'alternate_team_totals')) {
            $data['team_totals'] = $outcomes->map(function($outcome) {
                return [
                    'name' => $outcome['name'],
                    'description' => $outcome['description'] ?? null,
                    'point' => $outcome['point'] ?? null,
                    'price' => $outcome['price']
                ];
            })->toArray();
        }

        // Outrights
        elseif (str_contains($marketKey, 'outright')) {
            $data['outrights'] = $outcomes->map(function($outcome) {
                return [
                    'name' => $outcome['name'],
                    'description' => $outcome['description'] ?? null,
                    'price' => $outcome['price']
                ];
            })->toArray();
        }

        // Player props - store all outcomes
        elseif (str_starts_with($marketKey, 'player_') || str_starts_with($marketKey, 'batter_') || str_starts_with($marketKey, 'pitcher_')) {
            $data['player_props'] = $outcomes->map(function($outcome) {
                return [
                    'name' => $outcome['name'],
                    'description' => $outcome['description'] ?? null,
                    'point' => $outcome['point'] ?? null,
                    'price' => $outcome['price']
                ];
            })->toArray();
        }

        // Other markets (BTTS, Draw No Bet, Double Chance, etc.)
        else {
            $data['outcomes'] = $outcomes->toArray();
        }

        return $data;
    }

    /**
     * Fetch odds for specific markets only
     */
    public function fetchOddsForMarkets($sport, array $markets)
    {
        return $this->fetchOddsForSport($sport, $markets);
    }

    /**
     * Fetch all available markets for a sport using batch + event endpoints
     */
    public function fetchAllMarketsForSport($sport)
    {
        // First fetch basic odds to get event IDs
        $events = $this->fetchOddsForSport($sport);
        
        if (empty($events)) {
            return [];
        }

        // Get all available markets for this sport
        $allMarkets = $this->getMarketsForSport($sport);
        
        // Additional markets that need event endpoint
        $additionalMarkets = array_diff($allMarkets, ['h2h', 'spreads', 'totals', 'h2h_lay']);
        
        if (empty($additionalMarkets)) {
            return $events;
        }

        // Fetch additional markets for each event
        foreach ($events as $event) {
            $this->fetchEventMarkets($event['id'], $sport, $additionalMarkets);
            sleep(1); // Rate limiting
        }

        return $events;
    }

    /**
     * Get odds comparison for a specific event and market
     */
    public function getEventComparison($eventId, $marketKey = 'h2h')
    {
        return BookmakerBackOdd::where('event_id', $eventId)
            ->where('market_key', $marketKey)
            ->get()
            ->map(function($odd) {
                return [
                    'bookmaker' => $odd->bookmaker,
                    'bookmaker_name' => $this->getBookmakerName($odd->bookmaker),
                    'market_key' => $odd->market_key,
                    'market_data' => $odd->market_data,
                    'last_update' => $odd->last_update
                ];
            });
    }

    /**
     * Get best odds for a specific market type
     */
    public function getBestOddsByMarket($sport = null, $marketKey = 'h2h', $hours = 48)
    {
        $query = BookmakerBackOdd::upcoming()
            ->withinHours($hours)
            ->where('market_key', $marketKey);

        if ($sport) {
            $query->bySport($sport);
        }

        return $query->get()
            ->groupBy('event_id')
            ->map(function($eventOdds) use ($marketKey) {
                $match = $eventOdds->first();
                
                $result = [
                    'event_id' => $match->event_id,
                    'sport' => $match->sport_title,
                    'home_team' => $match->home_team,
                    'away_team' => $match->away_team,
                    'commence_time' => $match->commence_time,
                    'market_type' => $marketKey,
                ];

                // Add market-specific best odds
                if (str_starts_with($marketKey, 'h2h')) {
                    $result['best_home_odds'] = $eventOdds->max('home_back_odds');
                    $result['best_home_bookmaker'] = $eventOdds->sortByDesc('home_back_odds')->first()->bookmaker;
                    $result['best_away_odds'] = $eventOdds->max('away_back_odds');
                    $result['best_away_bookmaker'] = $eventOdds->sortByDesc('away_back_odds')->first()->bookmaker;
                    
                    if ($eventOdds->filter(fn($o) => $o->draw_back_odds)->isNotEmpty()) {
                        $result['best_draw_odds'] = $eventOdds->max('draw_back_odds');
                        $result['best_draw_bookmaker'] = $eventOdds->filter(fn($o) => $o->draw_back_odds)
                            ->sortByDesc('draw_back_odds')->first()->bookmaker;
                    }
                } else {
                    // Return all bookmakers' data for comparison
                    $result['bookmakers'] = $eventOdds->map(function($odd) {
                        return [
                            'bookmaker' => $odd->bookmaker,
                            'bookmaker_name' => $this->getBookmakerName($odd->bookmaker),
                            'data' => $odd->market_data
                        ];
                    })->values();
                }

                $result['all_bookmakers'] = $eventOdds->pluck('bookmaker')->toArray();

                return $result;
            });
    }

    /**
     * Get all available markets for an event
     */
    public function getEventMarkets($eventId)
    {
        return BookmakerBackOdd::where('event_id', $eventId)
            ->get()
            ->groupBy('market_key')
            ->map(function($marketOdds, $marketKey) {
                return [
                    'market_key' => $marketKey,
                    'market_name' => $this->getMarketName($marketKey),
                    'bookmakers' => $marketOdds->map(function($odd) {
                        return [
                            'bookmaker' => $odd->bookmaker,
                            'bookmaker_name' => $this->getBookmakerName($odd->bookmaker),
                            'data' => $odd->market_data,
                            'last_update' => $odd->last_update
                        ];
                    })
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
            'markets' => [],
            'bookmakers' => [],
            'sports' => []
        ];

        // Market stats - get actual markets in database
        $marketStats = BookmakerBackOdd::upcoming()
            ->select('market_key', DB::raw('count(*) as count'))
            ->groupBy('market_key')
            ->get();

        foreach ($marketStats as $stat) {
            $stats['markets'][$stat->market_key] = $stat->count;
        }

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
     * Fetch odds for multiple sports by category
     */
    public function fetchBySportCategory($category, $markets = null)
    {
        $sports = array_filter($this->sports, function($sport) use ($category) {
            return str_starts_with($sport, $category . '_');
        });

        $results = [];
        
        foreach ($sports as $sport) {
            $results[$sport] = $this->fetchOddsForSport($sport, $markets);
            sleep(1); // Rate limiting
        }

        return $results;
    }

    // Sport-specific methods
    public function fetchFootballOdds() { return $this->fetchBySportCategory('soccer'); }
    public function fetchTennisOdds() { return $this->fetchBySportCategory('tennis'); }
    public function fetchBasketballOdds() { return $this->fetchBySportCategory('basketball'); }
    public function fetchHandballOdds() { return $this->fetchBySportCategory('handball'); }
    public function fetchIceHockeyOdds() { return $this->fetchBySportCategory('icehockey'); }
    public function fetchAmericanFootballOdds() { return $this->fetchBySportCategory('americanfootball'); }
    public function fetchRugbyUnionOdds() { return $this->fetchBySportCategory('rugbyunion'); }
    public function fetchRugbyLeagueOdds() { return $this->fetchBySportCategory('rugbyleague'); }
    public function fetchMMAOdds() { return $this->fetchBySportCategory('mma'); }
    public function fetchBoxingOdds() { return $this->fetchBySportCategory('boxing'); }
    public function fetchVolleyballOdds() { return $this->fetchOddsForSport('volleyball'); }
    public function fetchGolfOdds() { return $this->fetchBySportCategory('golf'); }

    /**
     * Get market name in readable format
     */
    public function getMarketName($key)
    {
        $names = [
            'h2h' => 'Head to Head',
            'spreads' => 'Point Spreads',
            'totals' => 'Totals (Over/Under)',
            'outrights' => 'Outrights',
            'h2h_lay' => 'Head to Head (Lay)',
            'outrights_lay' => 'Outrights (Lay)',
            'btts' => 'Both Teams to Score',
            'draw_no_bet' => 'Draw No Bet',
            'h2h_3_way' => '3-Way Moneyline',
            'alternate_spreads' => 'Alternate Spreads',
            'alternate_totals' => 'Alternate Totals',
            'team_totals' => 'Team Totals',
            'alternate_team_totals' => 'Alternate Team Totals',
            'double_chance' => 'Double Chance',
        ];

        return $names[$key] ?? ucwords(str_replace('_', ' ', $key));
    }

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

    public function getBookmakers() { return $this->bookmakers; }
    public function getSupportedSports() { return $this->sports; }
    public function getSportMarkets() { return $this->sportMarkets; }
}