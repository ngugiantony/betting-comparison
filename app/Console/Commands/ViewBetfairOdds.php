<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BetfairOddsService;

class ViewBetfairOdds extends Command
{
    protected $signature = 'betfair:view 
                            {sport? : Filter by sport}
                            {--hours=24 : Show matches within X hours}';
    
    protected $description = 'View stored Betfair lay odds';

    public function handle(BetfairOddsService $service)
    {
        $sport = $this->argument('sport');
        $hours = (int) $this->option('hours');

        if ($sport) {
            $matches = $service->getUpcomingMatches($sport, $hours);
            $this->info("Upcoming matches for {$sport} (next {$hours} hours):");
        } else {
            $matches = $service->getAllUpcomingMatches($hours);
            $this->info("All upcoming matches (next {$hours} hours):");
        }

        $this->newLine();

        if ($matches->isEmpty()) {
            $this->warn('No matches found.');
            return;
        }

        foreach ($matches as $match) {
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->line("<fg=cyan>{$match->home_team} vs {$match->away_team}</>");
            $this->line("Sport: {$match->sport_title}");
            $this->line("Time: {$match->commence_time->format('Y-m-d H:i')}");
            $this->newLine();
            
            if ($match->home_lay_odds) {
                $this->line("  Home Lay: {$match->home_lay_odds}");
            }
            if ($match->away_lay_odds) {
                $this->line("  Away Lay: {$match->away_lay_odds}");
            }
            if ($match->draw_lay_odds) {
                $this->line("  Draw Lay: {$match->draw_lay_odds}");
            }
            
            $this->newLine();
        }

        $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("Total matches: " . $matches->count());
    }
}