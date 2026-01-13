<?php

namespace App\Console\Commands;

use App\Services\BookmakerOddsService;
use Illuminate\Console\Command;

class FetchBookmakerOdds extends Command
{
    protected $signature = 'odds:fetch 
                            {--sport= : Specific sport to fetch}
                            {--markets= : Comma-separated list of markets}
                            {--all-markets : Fetch all available markets for the sport}
                            {--all-sports : Fetch all sports}
                            {--event= : Fetch specific event ID}
                            {--show-markets : Show available markets for a sport}';

    protected $description = 'Fetch odds from The Odds API with sport-specific markets';

    public function handle(BookmakerOddsService $oddsService)
    {
        // Show available markets for a sport
        if ($this->option('show-markets') && $this->option('sport')) {
            $sport = $this->option('sport');
            $markets = $oddsService->getMarketsForSport($sport);
            
            $this->info("Available markets for {$sport}:");
            $this->table(
                ['Market Key', 'Market Name'],
                collect($markets)->map(fn($m) => [$m, $oddsService->getMarketName($m)])
            );
            return 0;
        }

        // Fetch specific event with all markets
        if ($this->option('event') && $this->option('sport')) {
            $eventId = $this->option('event');
            $sport = $this->option('sport');
            $markets = $this->option('markets') ? explode(',', $this->option('markets')) : [];
            
            $this->info("Fetching event {$eventId} markets...");
            $oddsService->fetchEventMarkets($eventId, $sport, $markets);
            $this->info("✓ Event markets fetched!");
            return 0;
        }

        // Fetch all available markets for a sport
        if ($this->option('all-markets') && $this->option('sport')) {
            $sport = $this->option('sport');
            $this->info("Fetching ALL available markets for {$sport}...");
            $this->warn("This will make multiple API calls!");
            
            $oddsService->fetchAllMarketsForSport($sport);
            $this->info("✓ All markets fetched!");
        }
        
        // Fetch specific markets for a sport
        elseif ($this->option('markets') && $this->option('sport')) {
            $sport = $this->option('sport');
            $markets = explode(',', $this->option('markets'));
            
            $this->info("Fetching markets for {$sport}:");
            foreach ($markets as $market) {
                $this->line("  - {$market}");
            }
            
            $oddsService->fetchOddsForMarkets($sport, $markets);
            $this->info("✓ Markets fetched!");
        }
        
        // Fetch featured markets (h2h, spreads, totals) for a sport
        elseif ($this->option('sport')) {
            $sport = $this->option('sport');
            $this->info("Fetching featured markets for {$sport}...");
            $oddsService->fetchOddsForSport($sport);
            $this->info("✓ Featured markets fetched!");
        }
        
        // Fetch all sports
        elseif ($this->option('all-sports')) {
            $this->info("Fetching featured markets for all sports...");
            foreach ($oddsService->getSupportedSports() as $sport) {
                $this->info("Processing: {$sport}");
                $oddsService->fetchOddsForSport($sport);
                sleep(1); // Rate limiting
            }
            $this->info("✓ All sports fetched!");
        }
        
        else {
            $this->error('Please specify options. Examples:');
            $this->line('');
            $this->line('Show available markets:');
            $this->line('  php artisan odds:fetch --sport=soccer_epl --show-markets');
            $this->line('');
            $this->line('Fetch featured markets (h2h, spreads, totals):');
            $this->line('  php artisan odds:fetch --sport=basketball_nba');
            $this->line('');
            $this->line('Fetch specific markets:');
            $this->line('  php artisan odds:fetch --sport=soccer_epl --markets=h2h,btts,draw_no_bet');
            $this->line('  php artisan odds:fetch --sport=basketball_nba --markets=h2h,spreads,totals,player_points');
            $this->line('');
            $this->line('Fetch ALL available markets for a sport (uses multiple API calls):');
            $this->line('  php artisan odds:fetch --sport=americanfootball_nfl --all-markets');
            $this->line('');
            $this->line('Fetch specific event markets:');
            $this->line('  php artisan odds:fetch --sport=soccer_epl --event=abc123 --markets=player_shots,player_assists');
            return 1;
        }

        // Show statistics
        $stats = $oddsService->getStatistics();
        $this->newLine();
        $this->info("Statistics:");
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Matches', $stats['total_matches']],
                ['Total Records', $stats['total_records']],
                ['Upcoming Matches', $stats['upcoming_matches']],
            ]
        );

        if (!empty($stats['markets'])) {
            $this->newLine();
            $this->info("Market Distribution:");
            foreach ($stats['markets'] as $market => $count) {
                $marketName = $oddsService->getMarketName($market);
                $this->line("  {$marketName} ({$market}): {$count} records");
            }
        }

        return 0;
    }
}
