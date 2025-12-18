<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BookmakerOddsService;
use App\Models\BookmakerBackOdd;

class ViewBookmakerOdds extends Command
{
    protected $signature = 'bookmaker:view 
                            {event? : Specific event ID to view}
                            {--sport= : Filter by sport}
                            {--bookmaker= : Filter by bookmaker}
                            {--hours=48 : Show matches within X hours}
                            {--best : Show best odds across bookmakers}';

    protected $description = 'View stored odds from all bookmakers';

    public function handle(BookmakerOddsService $service)
    {
        if ($eventId = $this->argument('event')) {
            $this->viewEventComparison($eventId, $service);
            return;
        }

        if ($this->option('best')) {
            $this->viewBestOdds($service);
            return;
        }

        $this->viewAllOdds($service);
    }

    private function viewEventComparison($eventId, $service)
    {
        $comparison = $service->getEventComparison($eventId);

        if ($comparison->isEmpty()) {
            $this->error("No odds found for event: {$eventId}");
            return;
        }

        $firstOdd = BookmakerBackOdd::where('event_id', $eventId)->first();
        
        $this->info("📊 Odds Comparison for Event");
        $this->line(str_repeat('=', 70));
        $this->line("{$firstOdd->home_team} vs {$firstOdd->away_team}");
        $this->line("Sport: {$firstOdd->sport_title}");
        $this->line("Time: {$firstOdd->commence_time->format('Y-m-d H:i')}");
        $this->newLine();

        $headers = ['Bookmaker', 'Home', 'Draw', 'Away', 'Last Update'];
        $rows = [];

        foreach ($comparison as $odd) {
            $rows[] = [
                $odd['bookmaker'],
                $odd['home_odds'] ?? 'N/A',
                $odd['draw_odds'] ?? 'N/A',
                $odd['away_odds'] ?? 'N/A',
                $odd['last_update']->format('H:i')
            ];
        }

        $this->table($headers, $rows);

        // Show best odds
        $bestHome = $comparison->sortByDesc('home_odds')->first();
        $bestAway = $comparison->sortByDesc('away_odds')->first();
        $bestDraw = $comparison->filter(fn($o) => $o['draw_odds'])->sortByDesc('draw_odds')->first();

        $this->newLine();
        $this->info('🏆 Best Odds:');
        $this->line("  Home: {$bestHome['home_odds']} ({$bestHome['bookmaker']})");
        if ($bestDraw) {
            $this->line("  Draw: {$bestDraw['draw_odds']} ({$bestDraw['bookmaker']})");
        }
        $this->line("  Away: {$bestAway['away_odds']} ({$bestAway['bookmaker']})");
    }

    private function viewBestOdds($service)
    {
        $sport = $this->option('sport');
        $hours = (int) $this->option('hours');

        $bestOdds = $service->getBestOdds($sport, $hours);

        $this->info("🏆 Best Odds Across All Bookmakers");
        $this->line(str_repeat('=', 70));
        $this->newLine();

        foreach ($bestOdds as $match) {
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->line("{$match['home_team']} vs {$match['away_team']}");
            $this->line("Sport: {$match['sport']} | Time: {$match['commence_time']->format('Y-m-d H:i')}");
            $this->newLine();
            $this->line("Best Odds:");
            $this->line("  Home: {$match['best_home_odds']} ({$match['best_home_bookmaker']})");
            if ($match['best_draw_odds']) {
                $this->line("  Draw: {$match['best_draw_odds']} ({$match['best_draw_bookmaker']})");
            }
            $this->line("  Away: {$match['best_away_odds']} ({$match['best_away_bookmaker']})");
            $this->line("Bookmakers: " . implode(', ', $match['all_bookmakers']));
            $this->newLine();
        }
    }

    private function viewAllOdds($service)
    {
        $sport = $this->option('sport');
        $bookmaker = $this->option('bookmaker');
        $hours = (int) $this->option('hours');

        $query = BookmakerBackOdd::upcoming()->withinHours($hours);

        if ($sport) {
            $query->bySport($sport);
        }

        if ($bookmaker) {
            $query->byBookmaker($bookmaker);
        }

        $odds = $query->orderBy('commence_time')->get();

        $this->info("Stored Odds (next {$hours} hours)");
        if ($sport) $this->line("Sport: {$sport}");
        if ($bookmaker) $this->line("Bookmaker: {$bookmaker}");
        $this->newLine();

        if ($odds->isEmpty()) {
            $this->warn('No matches found.');
            return;
        }

        foreach ($odds as $odd) {
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->line("{$odd->home_team} vs {$odd->away_team}");
            $this->line("Bookmaker: {$odd->bookmaker} | Sport: {$odd->sport_title}");
            $this->line("Time: {$odd->commence_time->format('Y-m-d H:i')}");
            $this->line("Odds: Home={$odd->home_back_odds} | Draw={$odd->draw_back_odds} | Away={$odd->away_back_odds}");
            $this->newLine();
        }

        $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("Total: {$odds->count()} records");
    }
}