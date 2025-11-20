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
   

    

   

    <!-- Matches Table -->
    <div class="card shadow-sm">
        <div class="table-responsive">
           <table class="table table-hover table-striped mb-0">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Sport ID</th>
            <th>Bookmaker</th>
            <th>Match</th>
            <th colspan="2" style="text-align:center;">Home</th>
            <th colspan="2" style="text-align:center;">Draw</th>
            <th colspan="2" style="text-align:center;">Away</th>
            <th>Match Time</th>
            <th style="text-align:center;">Actions</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align:center;">Back</th>
            <th style="text-align:center;">Lay</th>
            <th style="text-align:center;">Back</th>
            <th style="text-align:center;">Lay</th>
            <th style="text-align:center;">Back</th>
            <th style="text-align:center;">Lay</th>
            <th></th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @forelse($matches as $match)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><span class="badge badge-primary">{{ $match->sport }}</span></td>
                <td><small class="text-muted">{{ ucfirst($match->bookmaker) }}</small></td>

                <td>
                    <strong>{{ $match->home_name }}</strong><br>
                    <span class="text-muted">vs</span><br>
                    <strong>{{ $match->away_name }}</strong>
                </td>

                {{-- HOME --}}
                <td style="text-align:center;">
                    <span class="badge badge-success">
                        {{ number_format($match->odds_home_back, 2) }}
                    </span><br>
                    <small class="text-muted">Vol: {{ $match->volume_home_back }}</small>
                </td>
                <td style="text-align:center;">
                    <span class="badge badge-danger">
                        {{ number_format($match->odds_home_lay, 2) }}
                    </span><br>
                    <small class="text-muted">Vol: {{ $match->volume_home_lay }}</small>
                </td>

                {{-- DRAW --}}
                <td style="text-align:center;">
                    <span class="badge badge-success">
                        {{ number_format($match->odds_draw_back, 2) }}
                    </span><br>
                    <small class="text-muted">Vol: {{ $match->volume_draw_back }}</small>
                </td>
                <td style="text-align:center;">
                    <span class="badge badge-danger">
                        {{ number_format($match->odds_draw_lay, 2) }}
                    </span><br>
                    <small class="text-muted">Vol: {{ $match->volume_draw_lay }}</small>
                </td>

                {{-- AWAY --}}
                <td style="text-align:center;">
                    <span class="badge badge-success">
                        {{ number_format($match->odds_away_back, 2) }}
                    </span><br>
                    <small class="text-muted">Vol: {{ $match->volume_away_back }}</small>
                </td>
                <td style="text-align:center;">
                    <span class="badge badge-danger">
                        {{ number_format($match->odds_away_lay, 2) }}
                    </span><br>
                    <small class="text-muted">Vol: {{ $match->volume_away_lay }}</small>
                </td>

                <td><small>{{ $match->match_time ?? '—' }}</small></td>

                <td style="text-align:center;">
                    <a href="{{ route('matches.show', $match->id) }}" class="btn btn-sm btn-info" title="View Details">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="text-center py-4 text-muted">
                    <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 10px;"></i>
                    <p>No matches found. Try adjusting your filters.</p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

        </div>
    </div>

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