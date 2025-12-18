<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BetfairOddsService;

class FetchBetfairOdds extends Command
{
    protected $signature = 'betfair:fetch 
                            {sport? : Specific sport to fetch}
                            {--all : Fetch all supported sports}
                            {--soccer : Fetch all soccer leagues}
                            {--tennis : Fetch all tennis tournaments}
                            {--handball : Fetch all handball leagues}
                            {--preview : Preview matches without saving}';
    
    protected $description = 'Fetch Betfair lay odds for soccer, tennis, and handball';

    public function handle(BetfairOddsService $service)
    {
        $this->info('🎾 Betfair Lay Odds Fetcher');
        $this->info('================================');
        $this->newLine();

        if ($this->option('all')) {
            $this->info('Fetching odds for ALL sports (Soccer, Tennis, Handball)...');
            $this->newLine();
            $results = $service->fetchAllSports();
            $this->displayResults($results);
        } 
        elseif ($this->option('soccer')) {
            $this->info('Fetching odds for all SOCCER leagues...');
            $this->newLine();
            $results = $service->fetchAllSoccerOdds();
            $this->displaySportResults($results, 'Soccer');
        }
        elseif ($this->option('tennis')) {
            $this->info('Fetching odds for all TENNIS tournaments...');
            $this->newLine();
            $results = $service->fetchAllTennisOdds();
            $this->displaySportResults($results, 'Tennis');
        }
        elseif ($this->option('handball')) {
            $this->info('Fetching odds for all HANDBALL leagues...');
            $this->newLine();
            $results = $service->fetchAllHandballOdds();
            $this->displaySportResults($results, 'Handball');
        }
        elseif ($sport = $this->argument('sport')) {
            $this->info("Fetching odds for: {$sport}");
            $this->newLine();
            $result = $service->fetchBetfairLayOdds($sport);
            
            if ($result !== null) {
                $this->info("✓ Successfully fetched " . count($result) . " matches");
            } else {
                $this->error("✗ Failed to fetch odds");
            }
        }
        elseif ($sport = $this->argument('sport')) {
    $this->info("Fetching odds for: {$sport}");
    $this->newLine();
    
    if ($this->option('preview')) {
        // Preview mode - don't save
        $result = $this->previewOdds($service, $sport);
    } else {
        // Normal mode - fetch and save
        $result = $service->fetchBetfairLayOdds($sport);
        
        if ($result !== null) {
            $this->info("✓ Successfully fetched " . count($result) . " matches");
        } else {
            $this->error("✗ Failed to fetch odds");
        }
    }
}
        else {
            $this->warn('Please specify a sport or use one of the options:');
            $this->line('  --all        Fetch all sports');
            $this->line('  --soccer     Fetch all soccer leagues');
            $this->line('  --tennis     Fetch all tennis tournaments');
            $this->line('  --handball   Fetch all handball leagues');
            $this->newLine();
            $this->info('Or specify a specific sport:');
            $this->line('  php artisan betfair:fetch soccer_france_ligue_one');
            return;
        }

        $this->newLine();
        $this->displayStatistics($service);
    }

    private function displayResults($results)
    {
        foreach ($results as $sportType => $leagues) {
            $this->info(strtoupper($sportType));
            $this->line(str_repeat('-', 50));
            
            foreach ($leagues as $league => $data) {
                if ($data !== null) {
                    $count = count($data);
                    $this->line("  ✓ {$league}: {$count} matches");
                } else {
                    $this->line("  ✗ {$league}: Failed");
                }
            }
            $this->newLine();
        }
    }

    private function displaySportResults($results, $sportName)
    {
        foreach ($results as $league => $data) {
            if ($data !== null) {
                $count = count($data);
                $this->line("  ✓ {$league}: {$count} matches");
            } else {
                $this->line("  ✗ {$league}: Failed");
            }
        }
    }

    private function displayStatistics($service)
    {
        $stats = $service->getStatistics();
        
        $this->info('📊 Database Statistics');
        $this->line(str_repeat('=', 50));
        $this->line("Total upcoming matches: {$stats['total_matches']}");
        $this->line("  ⚽ Soccer: {$stats['soccer_matches']}");
        $this->line("  🎾 Tennis: {$stats['tennis_matches']}");
        $this->line("  🤾 Handball: {$stats['handball_matches']}");
        
        if ($stats['last_update']) {
            $this->line("Last update: {$stats['last_update']}");
        }
    }

    private function previewOdds($service, $sport)
{
    try {
        // Fetch without saving
        $response = \Illuminate\Support\Facades\Http::get("https://api.the-odds-api.com/v4/sports/{$sport}/odds", [
            'apiKey' => config('services.odds_api.key'),
            'regions' => 'eu',
            'markets' => 'h2h',
            'oddsFormat' => 'decimal',
            'bookmakers' => 'betfair_ex_eu'
        ]);

        if (!$response->successful()) {
            $this->error("Failed to fetch odds");
            return;
        }

        $data = $response->json();
        
        if (empty($data)) {
            $this->warn("No matches found");
            return;
        }

        $this->info("Found " . count($data) . " matches");
        $this->newLine();

        foreach ($data as $index => $match) {
            $betfairData = collect($match['bookmakers'] ?? [])
                ->firstWhere('key', 'betfair_ex_eu');

            if (!$betfairData) {
                continue;
            }

            $market = $betfairData['markets'][0] ?? null;
            if (!$market || $market['key'] !== 'h2h') {
                continue;
            }

            $outcomes = collect($market['outcomes']);
            $homeTeam = $match['home_team'];
            $awayTeam = $match['away_team'];

            $homeOdds = $outcomes->firstWhere('name', $homeTeam)['price'] ?? 'N/A';
            $awayOdds = $outcomes->firstWhere('name', $awayTeam)['price'] ?? 'N/A';
            $drawOdds = $outcomes->firstWhere('name', 'Draw')['price'] ?? null;

            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->line("<fg=yellow>Match " . ($index + 1) . "</>");
            $this->line("<fg=cyan>{$homeTeam} vs {$awayTeam}</>");
            $this->line("Sport: {$match['sport_title']}");
            $this->line("Event ID: {$match['id']}");
            $this->line("Time: " . \Carbon\Carbon::parse($match['commence_time'])->format('Y-m-d H:i'));
            $this->newLine();
            
            $this->line("<fg=green>Betfair Lay Odds:</>");
            $this->line("  Home: {$homeOdds}");
            $this->line("  Away: {$awayOdds}");
            if ($drawOdds) {
                $this->line("  Draw: {$drawOdds}");
            }
            $this->newLine();
        }

        $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("Total matches: " . count($data));
        $this->newLine();
        $this->warn("Preview mode - matches NOT saved to database");
        $this->info("Run without --preview flag to save these matches");

    } catch (\Exception $e) {
        $this->error("Error: " . $e->getMessage());
    }
}

    
}