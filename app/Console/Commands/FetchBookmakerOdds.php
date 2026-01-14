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
                            {--ice-hockey : Fetch all ice hockey}
                            {--american-football : Fetch all american football}
                            {--rugby-union : Fetch all rugby union}
                            {--rugby-league : Fetch all rugby league}
                            {--mma : Fetch all MMA}
                            {--boxing : Fetch all boxing}
                            {--volleyball : Fetch all volleyball}
                            {--golf : Fetch all golf}';

    protected $description = 'Fetch odds from all French bookmakers (Betclic, NetBet, Parions Sport, PMU, Unibet, Winamax)';

    public function handle(BookmakerOddsService $service)
    {
        $this->info('🎯 Multi-Bookmaker Odds Fetcher');
        $this->info('================================');
        $this->line('Bookmakers: ' . implode(', ', array_map([$service, 'getBookmakerName'], $service->getBookmakers())));
        $this->newLine();

        if ($this->option('all')) {
            $this->info('Fetching odds for ALL sports from ALL bookmakers...');
            $this->newLine();
            
            $sports = $service->getSupportedSports();
            $bar = $this->output->createProgressBar(count($sports));
            $bar->start();
            
            foreach ($sports as $sport) {
                $service->fetchOddsForSport($sport);
                $bar->advance();
                sleep(1);
            }
            
            $bar->finish();
            $this->newLine();
        } 
        elseif ($this->option('football')) {
            $this->fetchCategory($service, 'FOOTBALL', 'fetchFootballOdds');
        }
        elseif ($this->option('tennis')) {
            $this->fetchCategory($service, 'TENNIS', 'fetchTennisOdds');
        }
        elseif ($this->option('basketball')) {
            $this->fetchCategory($service, 'BASKETBALL', 'fetchBasketballOdds');
        }
        elseif ($this->option('handball')) {
            $this->fetchCategory($service, 'HANDBALL', 'fetchHandballOdds');
        }
        elseif ($this->option('ice-hockey')) {
            $this->fetchCategory($service, 'ICE HOCKEY', 'fetchIceHockeyOdds');
        }
        elseif ($this->option('american-football')) {
            $this->fetchCategory($service, 'AMERICAN FOOTBALL', 'fetchAmericanFootballOdds');
        }
        elseif ($this->option('rugby-union')) {
            $this->fetchCategory($service, 'RUGBY UNION', 'fetchRugbyUnionOdds');
        }
        elseif ($this->option('rugby-league')) {
            $this->fetchCategory($service, 'RUGBY LEAGUE', 'fetchRugbyLeagueOdds');
        }
        elseif ($this->option('mma')) {
            $this->fetchCategory($service, 'MMA', 'fetchMMAOdds');
        }
        elseif ($this->option('boxing')) {
            $this->fetchCategory($service, 'BOXING', 'fetchBoxingOdds');
        }
        elseif ($this->option('volleyball')) {
            $this->fetchCategory($service, 'VOLLEYBALL', 'fetchVolleyballOdds');
        }
        elseif ($this->option('golf')) {
            $this->fetchCategory($service, 'GOLF', 'fetchGolfOdds');
        }
        elseif ($sport = $this->argument('sport')) {
            $this->info("Fetching odds for: {$sport}");
            $this->newLine();
            $result = $service->fetchOddsForSport($sport);
            
            if ($result !== null) {
                $this->info("✓ Successfully fetched " . count($result) . " matches");
            } else {
                $this->error("✗ Failed to fetch odds");
            }
        } 
        else {
            $this->showUsage();
            return;
        }

        $this->newLine(2);
        $this->displayStatistics($service);
    }

    private function fetchCategory($service, $categoryName, $method)
    {
        $this->info("Fetching {$categoryName} odds from all bookmakers...");
        $this->newLine();
        $results = $service->$method();
        $this->displayResults($results);
    }

    private function displayResults($results)
    {
        foreach ($results as $sport => $data) {
            if ($data !== null && is_array($data)) {
                $this->line("  ✓ {$sport}: " . count($data) . " matches");
            } elseif ($data !== null) {
                $this->line("  ✓ {$sport}: Success");
            } else {
                $this->line("  ✗ {$sport}: Failed");
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
        $this->line("Upcoming matches: {$stats['upcoming_matches']}");
        $this->newLine();
        
        $this->line('Matches by Sport:');
        foreach ($stats['sports'] as $sport => $count) {
            $icon = $this->getSportIcon($sport);
            $this->line("  {$icon} " . ucfirst(str_replace('_', ' ', $sport)) . ": {$count} matches");
        }
        
        $this->newLine();
        $this->line('Records by Bookmaker:');
        foreach ($stats['bookmakers'] as $bookmaker => $count) {
            $name = $service->getBookmakerName($bookmaker);
            $this->line("  {$name}: {$count} records");
        }
        
        if ($stats['last_update']) {
            $this->newLine();
            $this->line("Last update: {$stats['last_update']}");
        }
    }

    private function getSportIcon($sport)
    {
        $icons = [
            'football' => '⚽',
            'tennis' => '🎾',
            'basketball' => '🏀',
            'handball' => '🤾',
            'ice_hockey' => '🏒',
            'american_football' => '🏈',
            'rugby_union' => '🏉',
            'rugby_league' => '🏉',
            'mma' => '🥊',
            'boxing' => '🥊',
            'volleyball' => '🏐',
            'golf' => '⛳',
        ];

        return $icons[$sport] ?? '🏆';
    }

    private function showUsage()
    {
        $this->warn('Please specify a sport or use one of the options:');
        $this->newLine();
        
        $this->line('Sport Categories:');
        $this->line('  --all                  Fetch all sports');
        $this->line('  --football             Fetch all football/soccer');
        $this->line('  --tennis               Fetch all tennis');
        $this->line('  --basketball           Fetch all basketball');
        $this->line('  --handball             Fetch all handball');
        $this->line('  --ice-hockey           Fetch all ice hockey');
        $this->line('  --american-football    Fetch all american football');
        $this->line('  --rugby-union          Fetch all rugby union');
        $this->line('  --rugby-league         Fetch all rugby league');
        $this->line('  --mma                  Fetch all MMA');
        $this->line('  --boxing               Fetch all boxing');
        $this->line('  --volleyball           Fetch all volleyball');
        $this->line('  --golf                 Fetch all golf');
        
        $this->newLine();
        $this->info('Or specify a specific sport:');
        $this->line('  php artisan bookmaker:fetch soccer_france_ligue_one');
        $this->line('  php artisan bookmaker:fetch tennis_atp_french_open');
        $this->line('  php artisan bookmaker:fetch golf_pga_championship');
        
        $this->newLine();
        $this->info('Examples:');
        $this->line('  php artisan bookmaker:fetch --football');
        $this->line('  php artisan bookmaker:fetch --golf');
        $this->line('  php artisan bookmaker:fetch --all');
    }
}