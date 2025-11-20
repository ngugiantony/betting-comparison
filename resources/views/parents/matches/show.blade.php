@extends('parents.master')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('matches.index') }}" class="btn btn-secondary btn-sm mb-3">
                <i class="fas fa-arrow-left"></i> Back to Matches
            </a>
            <h4>Match Details</h4>
        </div>
    </div>

    <div class="row">
        <!-- Main Match Info -->
        <div class="col-lg-8">
            <!-- Match Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-futbol-o"></i> Match Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-5 text-center">
                            <h3 class="mb-2">{{ $match->home_name }}</h3>
                            <div class="badge badge-success" style="font-size: 24px; padding: 12px 16px;">
                                {{ number_format($match->odds_home, 2) }}
                            </div>
                            <p class="text-muted mt-2">Home Odds</p>
                        </div>

                        <div class="col-md-2 text-center d-flex align-items-center justify-content-center" style="min-height: 120px;">
                            <div>
                                <h4 class="text-muted">VS</h4>
                            </div>
                        </div>

                        <div class="col-md-5 text-center">
                            <h3 class="mb-2">{{ $match->away_name }}</h3>
                            <div class="badge badge-danger" style="font-size: 24px; padding: 12px 16px;">
                                {{ number_format($match->odds_away, 2) }}
                            </div>
                            <p class="text-muted mt-2">Away Odds</p>
                        </div>
                    </div>

                    @if($match->odds_draw)
                    <div class="text-center mb-4 pb-3 border-top">
                        <h5 class="text-muted mb-2">Draw</h5>
                        <div class="badge badge-warning" style="font-size: 20px; padding: 10px 14px;">
                            {{ number_format($match->odds_draw, 2) }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Details Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Additional Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Bookmaker</label>
                            <p class="h6">{{ ucfirst($match->bookmaker) }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Sport</label>
                            <p class="h6">
                                <span class="badge badge-primary">
                                    {{ ucfirst(str_replace('_', ' ', $match->sport_name)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Competition/League</label>
                            <p class="h6">{{ $match->competition_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Match Time</label>
                            <p class="h6">{{ $match->match_time ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small">Scraped At</label>
                            <p class="h6">{{ $match->scraped_at }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Match ID</label>
                            <p class="h6 font-monospace text-muted">#{{ $match->id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Stats Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar"></i> Odds Analysis
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Home Win Probability</label>
                        <div class="progress">
                            @php
                                $total_odds = $match->odds_home + ($match->odds_draw ?? 0) + $match->odds_away;
                                $home_prob = round((1 / $match->odds_home) * 100, 1);
                                $away_prob = round((1 / $match->odds_away) * 100, 1);
                                $draw_prob = $match->odds_draw ? round((1 / $match->odds_draw) * 100, 1) : 0;
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" 
                                style="width: {{ $home_prob }}%;" 
                                aria-valuenow="{{ $home_prob }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                                {{ $home_prob }}%
                            </div>
                        </div>
                    </div>

                    @if($match->odds_draw)
                    <div class="mb-3">
                        <label class="text-muted small">Draw Probability</label>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" 
                                style="width: {{ $draw_prob }}%;" 
                                aria-valuenow="{{ $draw_prob }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                                {{ $draw_prob }}%
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="text-muted small">Away Win Probability</label>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" 
                                style="width: {{ $away_prob }}%;" 
                                aria-valuenow="{{ $away_prob }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                                {{ $away_prob }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-actions"></i> Actions
                    </h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary btn-block mb-2" data-toggle="modal" data-target="#placeBetModal">
                        <i class="fas fa-plus-circle"></i> Place Bet
                    </button>
                    <a href="#" class="btn btn-secondary btn-block mb-2">
                        <i class="fas fa-share-alt"></i> Share
                    </a>
                    <button class="btn btn-outline-dark btn-block">
                        <i class="fas fa-bookmark"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Place Bet Modal -->
<div class="modal fade" id="placeBetModal" tabindex="-1" role="dialog" aria-labelledby="placeBetModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="placeBetModalLabel">Place Your Bet</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Match</label>
                        <input type="text" class="form-control" value="{{ $match->home_name }} vs {{ $match->away_name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Select Outcome</label>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" class="custom-control-input" id="homeWin" name="outcome" value="home" checked>
                            <label class="custom-control-label" for="homeWin">
                                {{ $match->home_name }} ({{ number_format($match->odds_home, 2) }})
                            </label>
                        </div>
                        @if($match->odds_draw)
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" class="custom-control-input" id="draw" name="outcome" value="draw">
                            <label class="custom-control-label" for="draw">
                                Draw ({{ number_format($match->odds_draw, 2) }})
                            </label>
                        </div>
                        @endif
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="awayWin" name="outcome" value="away">
                            <label class="custom-control-label" for="awayWin">
                                {{ $match->away_name }} ({{ number_format($match->odds_away, 2) }})
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="betAmount">Bet Amount</label>
                        <input type="number" class="form-control" id="betAmount" placeholder="Enter amount" step="0.01" min="0">
                    </div>

                    <div class="alert alert-info">
                        <small>Potential winnings will be calculated automatically</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-check"></i> Place Bet
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .display-4 {
        font-weight: 300;
        color: #333;
    }

    .badge {
        font-size: 12px;
        font-weight: 600;
    }

    .card {
        border: 0;
        border-top: 3px solid #007bff;
    }

    .card-header.bg-primary,
    .card-header.bg-info,
    .card-header.bg-success,
    .card-header.bg-warning {
        border-top: 3px solid #007bff;
    }

    .font-monospace {
        font-family: 'Courier New', monospace;
    }

    .text-muted small {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .progress {
        height: 24px;
    }

    .progress-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        color: white;
    }

    .h6 {
        margin-bottom: 0;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .col-md-5 {
            margin-bottom: 20px;
        }
    }
</style>
@endsection