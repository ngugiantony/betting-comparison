@extends('parents.master')

@section('content')
<!-- In your head section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- In your footer -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<div class="container-fluid py-4">
   

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-filter"></i> Filters
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('matches.index') }}" class="form-inline">
                <div class="form-group mr-2 mb-2 flex-grow-1">
                    <label class="mr-2">Sport:</label>
                    <select name="sport" class="form-control form-control-sm">
                        <option value="">All Sports</option>
                        @foreach($sports as $sport)
                            <option value="{{ $sport }}" {{ request('sport') == $sport ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $sport)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mr-2 mb-2 flex-grow-1">
                    <label class="mr-2">Bookies:</label>
                    <select name="competition" class="form-control form-control-sm">
                        <option value="">All Bookies</option>
                        @foreach($competitions as $comp)
                            <option value="{{ $comp }}" {{ request('competition') == $comp ? 'selected' : '' }}>
                                {{ $comp }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mr-2 mb-2 flex-grow-1">
                    <label class="mr-2">Home Team:</label>
                    <input type="text" name="home_team" class="form-control form-control-sm" 
                        value="{{ request('home_team') }}" placeholder="Search...">
                </div>

                <div class="form-group mr-2 mb-2 flex-grow-1">
                    <label class="mr-2">Away Team:</label>
                    <input type="text" name="away_team" class="form-control form-control-sm" 
                        value="{{ request('away_team') }}" placeholder="Search...">
                </div>

                <div class="form-group mr-2 mb-2">
                    <label class="mr-2">Min Odds:</label>
                    <input type="number" name="min_odds" class="form-control form-control-sm" 
                        value="{{ request('min_odds') }}" step="0.01" placeholder="1.50">
                </div>

                <div class="form-group mr-2 mb-2">
                    <label class="mr-2">Max Odds:</label>
                    <input type="number" name="max_odds" class="form-control form-control-sm" 
                        value="{{ request('max_odds') }}" step="0.01" placeholder="5.00">
                </div>

                <div class="form-group mr-2 mb-2">
                    <label class="mr-2">Sort:</label>
                    <select name="sort_by" class="form-control form-control-sm">
                        <option value="scraped_at" {{ request('sort_by') == 'scraped_at' ? 'selected' : '' }}>Latest</option>
                        <option value="odds_home" {{ request('sort_by') == 'odds_home' ? 'selected' : '' }}>Home Odds</option>
                        <option value="odds_away" {{ request('sort_by') == 'odds_away' ? 'selected' : '' }}>Away Odds</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-sm mr-2 mb-2">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="{{ route('matches.index') }}" class="btn btn-secondary btn-sm mb-2">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Results Info -->
    <div class="alert alert-info mb-3" role="alert">
        <i class="fas fa-info-circle"></i>
        Showing <strong>{{ $matches->count() }}</strong> of <strong>{{ $matches->total() }}</strong> matches
    </div>

    <!-- Matches Table -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th style="width: 10%;">Sport</th>
                        <th style="width: 15%;">Bookies</th>
                        <th style="width: 30%;">Match</th>
                        <th style="width: 8%; text-align: center;">Home Odds</th>
                        <th style="width: 8%; text-align: center;">Draw</th>
                        <th style="width: 8%; text-align: center;">Away Odds</th>
                        <th style="width: 12%;">Time</th>
                        <th style="width: 9%; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matches as $match)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ ucfirst(str_replace('_', ' ', $match->sport_name)) }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $match->bookmaker ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <strong>{{ $match->home_name }}</strong>
                                <br>
                                <span class="text-muted">vs</span>
                                <br>
                                <strong>{{ $match->away_name }}</strong>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge badge-success" style="font-size: 14px; padding: 8px 12px;">
                                    {{ number_format($match->odds_home, 2) }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                @if($match->odds_draw)
                                    <span class="badge badge-warning" style="font-size: 14px; padding: 8px 12px;">
                                        {{ number_format($match->odds_draw, 2) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <span class="badge badge-danger" style="font-size: 14px; padding: 8px 12px;">
                                    {{ number_format($match->odds_away, 2) }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $match->match_time ?? '—' }}</small>
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('matches.show', $match->id) }}" class="btn btn-sm btn-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 10px;"></i>
                                <p>No matches found. Try adjusting your filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            {{ $matches->appends(request()->query())->links() }}
        </ul>
    </nav>
</div>

<style>
    .badge {
        font-size: 12px;
        font-weight: 600;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
    
    .card {
        border: 0;
        border-top: 3px solid #007bff;
    }
    
    .display-4 {
        font-weight: 300;
        color: #333;
        margin-bottom: 10px;
    }
    
    .form-control-sm {
        height: calc(1.5em + .5rem + 2px);
        font-size: .875rem;
    }
    
    .text-muted {
        color: #6c757d !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-inline {
            flex-direction: column;
        }
        
        .form-inline .form-group {
            width: 100% !important;
            margin-right: 0 !important;
        }
        
        .table {
            font-size: 12px;
        }
        
        th, td {
            padding: 0.75rem 0.5rem !important;
        }
    }
</style>
@endsection