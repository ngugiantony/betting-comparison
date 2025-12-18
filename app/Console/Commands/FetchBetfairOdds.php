<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BetfairOddsService;

class FetchBetfairOdds extends Command
{
    protected $signature = 'betfair:fetch 
                            {sport? : Specific sport to fetch}
                            {--all : Fetch all supported sports}
                            {--soccer : Fetch all soccer}
                            {--tennis : Fetch all tennis}
                            {--basketball : Fetch all basketball}
                            {--handball : Fetch all handball}
                            {--ice-hockey : Fetch all ice hockey}
                            {--american-football : Fetch all american football}
                            {--rugby-union : Fetch all rugby union}
                            {--rugby-league : Fetch all rugby league}
                            {--mma : Fetch all MMA}
                            {--boxing : Fetch all boxing}
                            {--golf : Fetch all golf}
                            {--volleyball : Fetch all volleyball}';

    protected $description = 'Fetch Betfair lay odds for all supported sports';

    public function handle(BetfairOddsService $service)
    {
        $this->info('🎾 Betfair Lay Odds Fetcher');
        $this->info('================================');
        $this->newLine();

        if ($this->option('all')) {
            $this->info('Fetching odds for ALL sports...');
            $this->newLine();
            $results = $service->fetchAllSports();
            $this->displayResults($results);
        } elseif ($this->option('soccer')) {
            $this->fetchCategory($service, 'Soccer', 'fetchAllSoccerOdds');
        } elseif ($this->option('tennis')) {
            $this->fetchCategory($service, 'Tennis', 'fetchAllTennisOdds');
        } elseif ($this->option('basketball')) {
            $this->fetchCategory($service, 'Basketball', 'fetchAllBasketballOdds');
        } elseif ($this->option('handball')) {
            $this->fetchCategory($service, 'Handball', 'fetchAllHandballOdds');
        } elseif ($this->option('ice-hockey')) {
            $this->fetchCategory($service, 'Ice Hockey', 'fetchAllIceHockeyOdds');
        } elseif ($this->option('american-football')) {
            $this->fetchCategory($service, 'American Football', 'fetchAllAmericanFootballOdds');
        } elseif ($this->option('rugby-union')) {
            $this->fetchCategory($service, 'Rugby Union', 'fetchAllRugbyUnionOdds');
        } elseif ($this->option('rugby-league')) {
            $this->fetchCategory($service, 'Rugby League', 'fetchAllRugbyLeagueOdds');
        } elseif ($this->option('mma')) {
            $this->fetchCategory($service, 'MMA', 'fetchAllMMAOdds');
        } elseif ($this->option('boxing')) {
            $this->fetchCategory($service, 'Boxing', 'fetchAllBoxingOdds');
        } elseif ($this->option('volleyball')) {
            $this->fetchCategory($service, 'Volleyball', 'fetchAllVolleyballOdds');
        } elseif ($this->option('golf')) {
            $this->fetchCategory($service, 'Golf', 'fetchAllGolfOdds');
        } elseif ($sport = $this->argument('sport')) {
            $this->info("Fetching odds for: {$sport}");
            $this->newLine();
            $result = $service->fetchBetfairLayOdds($sport);

            if ($result !== null) {
                $this->info("✓ Successfully fetched " . count($result) . " matches");
            } else {
                $this->error("✗ Failed to fetch odds");
            }
        } else {
            $this->showHelp();
            return;
        }

        $this->newLine();
        $this->displayStatistics($service);
    }

    private function fetchCategory($service, $categoryName, $method)
    {
        $this->info("Fetching odds for {$categoryName}...");
        $this->newLine();
        $results = $service->$method();
        $this->displaySportResults($results, $categoryName);
    }

    private function showHelp()
    {
        $this->warn('Please specify a sport or use one of the options:');
        $this->line('  --all                Fetch all sports');
        $this->line('  --soccer             Fetch all soccer');
        $this->line('  --tennis             Fetch all tennis');
        $this->line('  --basketball         Fetch all basketball');
        $this->line('  --handball           Fetch all handball');
        $this->line('  --ice-hockey         Fetch all ice hockey');
        $this->line('  --american-football  Fetch all american football');
        $this->line('  --rugby-union        Fetch all rugby union');
        $this->line('  --rugby-league       Fetch all rugby league');
        $this->line('  --mma                Fetch all MMA');
        $this->line('  --boxing             Fetch all boxing');
        $this->line('  --volleyball         Fetch all volleyball');
        $this->line('  --golf               Fetch all golf');
        $this->newLine();
        $this->info('Or specify a specific sport:');
        $this->line('  php artisan betfair:fetch soccer_france_ligue_one');
        $this->line('  php artisan betfair:fetch golf_pga_championship');
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
        $this->line("  🏀 Basketball: {$stats['basketball_matches']}");
        $this->line("  🤾 Handball: {$stats['handball_matches']}");
        $this->line("  🏒 Ice Hockey: {$stats['ice_hockey_matches']}");
        $this->line("  🏈 American Football: {$stats['american_football_matches']}");
        $this->line("  🏉 Rugby Union: {$stats['rugby_union_matches']}");
        $this->line("  🏉 Rugby League: {$stats['rugby_league_matches']}");
        $this->line("  🥊 MMA: {$stats['mma_matches']}");
        $this->line("  🥊 Boxing: {$stats['boxing_matches']}");
        $this->line("  🏐 Volleyball: {$stats['volleyball_matches']}");
        $this->line("  ⛳ Golf: {$stats['golf_matches']}");

        if ($stats['last_update']) {
            $this->line("Last update: {$stats['last_update']}");
        }
    }
}
