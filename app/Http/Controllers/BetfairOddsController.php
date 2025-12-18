<?php

namespace App\Http\Controllers;

use App\Services\BetfairOddsService;
use App\Models\BetfairLayOdd;
use Illuminate\Http\Request;

class BetfairOddsController extends Controller
{
    private $service;

    public function __construct(BetfairOddsService $service)
    {
        $this->service = $service;
    }

    /**
     * Fetch odds from API
     */
    public function fetch(Request $request)
    {
        $request->validate([
            'sport' => 'nullable|string',
            'type' => 'nullable|in:all,soccer,tennis,handball'
        ]);

        $sport = $request->input('sport');
        $type = $request->input('type', 'all');

        $result = null;

        if ($sport) {
            $result = $this->service->fetchBetfairLayOdds($sport);
        } elseif ($type === 'soccer') {
            $result = $this->service->fetchAllSoccerOdds();
        } elseif ($type === 'tennis') {
            $result = $this->service->fetchAllTennisOdds();
        } elseif ($type === 'handball') {
            $result = $this->service->fetchAllHandballOdds();
        } else {
            $result = $this->service->fetchAllSports();
        }

        return response()->json([
            'success' => $result !== null,
            'data' => $result
        ]);
    }

    /**
     * Get stored odds
     */
    public function index(Request $request)
    {
        $sport = $request->input('sport');
        $hours = $request->input('hours', 48);

        if ($sport) {
            $odds = $this->service->getUpcomingMatches($sport, $hours);
        } else {
            $odds = BetfairLayOdd::upcoming()
                ->withinHours($hours)
                ->orderBy('commence_time')
                ->get();
        }

        return response()->json($odds);
    }

    /**
     * Get odds by sport type
     */
    public function bySportType(Request $request, $type)
    {
        $hours = $request->input('hours', 48);

        $odds = BetfairLayOdd::upcoming()
            ->withinHours($hours)
            ->where('sport_key', 'like', "{$type}_%")
            ->orderBy('commence_time')
            ->get();

        return response()->json($odds);
    }

    /**
     * Get statistics
     */
    public function statistics()
    {
        $stats = $this->service->getStatistics();
        return response()->json($stats);
    }

    /**
     * Get available sports
     */
    public function sports()
    {
        $sports = $this->service->getAvailableSports();
        return response()->json($sports);
    }
}