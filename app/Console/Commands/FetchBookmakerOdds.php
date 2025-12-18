<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BookmakerOddsService;

class FetchBookmakerOdds extends Command
{
    protected $signature = 'bookmaker:fetch 
                            {sport? : Specific sport to fetch}
                            {--all : Fetch all supported sports}
                            {--football : Fetch all football/soccer}
                            {--tennis : Fetch all tennis}
                            {--basketball : Fetch all basketball}
                            {--handball : Fetch all handball}
                            {--ice-hockey : Fetch all ice hockey}';

    protected $description = 'Fetch odds from all French bookmakers';

    public function handle(BookmakerOddsService $service)
    {
        $this->info('🎯 Multi-Bookmaker Odds Fetcher');
        $this->info('================================');
        $this->line('Bookmakers: ' . implode(', ', $service->getBookmakers()));
        $this->newLine();

        if ($this->option('all')) {
            $this->info('Fetching odds for ALL sports from ALL bookmakers...');
            $this->withProgressBar($service->getSupportedSports(), function($sport) use ($service) {
                $service->fetchOddsForSport($sport);
                sleep(1);
            });
        } elseif ($this->option('football')) {
            $this->info('Fetching FOOTBALL odds from all bookmakers...');
            $results = $service->fetchFootballOdds();
            $this->displayResults($results);
        } elseif ($this->option('tennis')) {
            $this->info('Fetching TENNIS odds from all bookmakers...');
            $results = $service->fetchTennisOdds();
            $this->displayResults($results);
        } elseif ($this->option('basketball')) {
            $this->info('Fetching BASKETBALL odds from all bookmakers...');
            $results = $service->fetchBasketballOdds();
            $this->displayResults($results);
        } elseif ($this->option('handball')) {
            $this->info('Fetching HANDBALL odds from all bookmakers...');
            $results = $service->fetchHandballOdds();
            $this->displayResults($results);
        } elseif ($this->option('ice-hockey')) {
            $this->info('Fetching ICE HOCKEY odds from all bookmakers...');
            $results = $service->fetchIceHockeyOdds();
            $this->displayResults($results);
        } elseif ($sport = $this->argument('sport')) {
            $this->info("Fetching odds for: {$sport}");
            $result = $service->fetchOddsForSport($sport);
            if ($result !== null) {
                $this->info("✓ Successfully fetched " . count($result) . " matches");
            }
        } else {
            $this->showUsage();
            return;
        }

        $this->newLine(2);
        $this->displayStatistics($service);
    }

    private function displayResults($results)
    {
        foreach ($results as $sport => $data) {
            if ($data !== null) {
                $this->line(" ✓ {$sport}: " . count($data) . " matches");
            } else {
                $this->line(" ✗ {$sport}: Failed");
            }
        }
    }

    private function displayStatistics($service)
    {
        $stats = $service->getStatistics();
        
        $this->info('📊 Database Statistics');
        $this->line(str_repeat('=', 60));
        $this->line("Total unique matches: {$stats['total_matches']}");
        $this->line("Total records (all bookmakers): {$stats['total_records']}");
        $this->newLine();
        
        $this->line('By Sport:');
        foreach ($stats['sports'] as $sport => $count) {
            $this->line("  {$sport}: {$count} matches");
        }
        
        $this->newLine();
        $this->line('By Bookmaker:');
        foreach ($stats['bookmakers'] as $bookmaker => $count) {
            $this->line("  {$bookmaker}: {$count} records");
        }
        
        if ($stats['last_update']) {
            $this->newLine();
            $this->line("Last update: {$stats['last_update']}");
        }
    }

    private function showUsage()
    {
        $this->warn('Please specify a sport or use one of the options:');
        $this->line('  --all           Fetch all sports');
        $this->line('  --football      Fetch all football/soccer');
        $this->line('  --tennis        Fetch all tennis');
        $this->line('  --basketball    Fetch all basketball');
        $this->line('  --handball      Fetch all handball');
        $this->line('  --ice-hockey    Fetch all ice hockey');
        $this->newLine();
        $this->info('Or specify a sport:');
        $this->line('  php artisan bookmaker:fetch soccer_france_ligue_one');
    }
}
