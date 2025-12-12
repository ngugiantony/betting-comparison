@extends('parents.master')
@section('content')
    <div class="container-fluid mt-4 px-3 px-lg-4">
        <div class="row current-plan-banner">
            <div class="col-4">

                <div class="banner-info">
                    <span class="current-plan-label">
                        <i class="fas fa-info-circle"></i>
                        Free Plan
                    </span>
                </div>
            </div>

            <div class="col-md-4">
                <h2 class="banner-title">You're currently on the Free plan</h2>
            </div>

            <div class="col-md-4">
                <div class="banner-action">
                    <a href="{{ route('pricing.index')}}" class="btn-upgrade"> Upgrade Your Plan</a>
                    
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="  shadow-lg">
                    <!-- Professional Header -->
                    {{-- <div class="card-header bg-white border-bottom py-3" style=" background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="header-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="ml-3">
                                    <h5 class="mb-0 font-weight-bold text-dark">Odds Comparison</h5>
                                    <small class="text-muted">Back vs Lay Analysis</small>
                                </div>
                            </div>
                            <div class="d-none d-md-block">
                                <span class="badge badge-outline-primary">Live Data</span>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Filters -->
                    <div class="card-body bg-white border-bottom"
                        style=" background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <form method="GET" action="{{ route('matches.index') }}">
                            <div class="row g-3">
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label text-white fw-medium small mb-2">Sport</label>
                                    <select name="sport" class="form-select form-select-sm">
                                        <option value="">All Sports</option>
                                        @foreach ($sports as $sport)
                                            <option value="{{ $sport }}"
                                                {{ request('sport') == $sport ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $sport)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label text-white fw-medium small mb-2">Bookmaker</label>
                                    <select name="competition" class="form-select form-select-sm">
                                        <option value="">All Bookies</option>
                                        @foreach ($competitions as $comp)
                                            <option value="{{ $comp }}"
                                                {{ request('competition') == $comp ? 'selected' : '' }}>
                                                {{ $comp }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label text-white fw-medium small mb-2">Home Team</label>
                                    <input type="text" name="home_team" class="form-control form-control-sm"
                                        value="{{ request('home_team') }}" placeholder="Search...">
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label text-white fw-medium small mb-2">Away Team</label>
                                    <input type="text" name="away_team" class="form-control form-control-sm"
                                        value="{{ request('away_team') }}" placeholder="Search...">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success btn-sm px-4">
                                        <i class="fas fa-search mr-1"></i> Search
                                    </button>
                                    <a href="{{ route('matches.index') }}" class="btn btn-outline-danger btn-sm px-4 ml-2">
                                        <i class="fas fa-redo mr-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Responsive Table -->
                    <div class="mt-3 mx-2 table-responsive">
                        <table id="datatable-buttons"
                            class="table table-sm table-hover align-middle mb-0 professional-table">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-top-0 text-uppercase small fw-semibold text-muted">Sport</th>
                                    <th class="border-top-0 text-uppercase small fw-semibold text-muted">Match Details</th>
                                    <th class="border-top-0 text-uppercase small fw-semibold text-muted text-center">Type
                                    </th>
                                    <th class="border-top-0 text-uppercase small fw-semibold text-muted text-center">Back
                                    </th>
                                    <th
                                        class="border-top-0 text-uppercase small fw-semibold text-muted text-center d-none d-lg-table-cell">
                                        Bookmaker</th>
                                    <th
                                        class="border-top-0 text-uppercase small fw-semibold text-muted text-center d-none d-lg-table-cell">
                                        Exchange</th>
                                    <th class="border-top-0 text-uppercase small fw-semibold text-muted text-center">Lay
                                    </th>
                                    <th class="border-top-0 text-uppercase small fw-semibold text-muted text-center">Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($backMatches as $match)
                                    <!-- HOME ROW -->
                                    <tr class="match-row">
                                        <td class="align-middle">
                                            <span class="badge badge-soft-primary">
                                                {{ $match->competition_name ?? $match->sport_name }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="match-details">
                                                <div class="fw-semibold text-dark mb-1">
                                                    {{ $match->home_name }} <span class="text-muted">vs</span>
                                                    {{ $match->away_name }}
                                                </div>
                                                <div class="outcome-label text-success">
                                                    <i class="fas fa-circle small"></i> {{ $match->home_name }}
                                                </div>
                                                <small class="text-muted d-block mt-1">
                                                    {{ $match->event_date ? \Carbon\Carbon::parse($match->event_date)->format('d M Y') : 'TBD' }}
                                                    {{$match->event_time}}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="type-badge type-home">HOME</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="odds-display back-odds">
                                                <div class="odds-value">{{ number_format($match->back_home_odds, 2) }}
                                                </div>
                                                <small
                                                    class="odds-source d-none d-md-block">{{ $match->back_bookmaker }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle d-none d-lg-table-cell bookmaker">
                                            <span class="bookmaker-badge">{{ $match->back_bookmaker }}</span>
                                        </td>
                                        <td class="text-center align-middle ">
                                            <span class="badge bg-danger">Orbitxch</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($match->lay_odds)
                                                <div class="odds-display lay-odds">
                                                    <div class="odds-value">
                                                        {{ number_format($match->lay_odds->odds_home_lay, 2) }}</div>
                                                    <small
                                                        class="odds-volume d-none d-md-block">{{ number_format($match->lay_odds->volume_home_lay) }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">0.00</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <button class="btn btn-sm btn-outline-success calc-btn" data-toggle="modal"
                                                data-target="#calculatorModal"
                                                data-back-odds="{{ $match->back_home_odds }}"
                                                data-lay-odds="{{ $match->lay_odds ? $match->lay_odds->odds_home_lay : 0 }}"
                                                data-match="{{ $match->home_name }} vs {{ $match->away_name }}"
                                                data-outcome="{{ $match->home_name }}"
                                                data-bookmaker="{{ $match->back_bookmaker }}">
                                                <i class="fas fa-calculator d-none d-md-inline"></i>
                                                <span class="d-none d-md-inline ml-1">Calc</span>
                                                <i class="fas fa-calculator d-md-none"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- DRAW ROW -->
                                    @if ($match->back_draw_odds != null)
                                        <tr class="match-row">
                                            <td class="align-middle">
                                                <span class="badge badge-soft-primary">
                                                    {{ $match->competition_name ?? $match->sport_name }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="match-details">
                                                    <div class="fw-semibold text-dark mb-1">
                                                        {{ $match->home_name }} <span class="text-muted">vs</span>
                                                        {{ $match->away_name }}
                                                    </div>
                                                    <div class="outcome-label text-info">
                                                        <i class="fas fa-circle small"></i> Draw
                                                    </div>
                                                    <small class="text-muted d-block mt-1">
                                                        {{ $match->event_date ? \Carbon\Carbon::parse($match->event_date)->format('d M Y') : 'TBD' }}
                                                         {{$match->event_time}}
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="type-badge type-draw">DRAW</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="odds-display back-odds">
                                                    <div class="odds-value">{{ number_format($match->back_draw_odds, 2) }}
                                                    </div>
                                                    <small
                                                        class="odds-source d-none d-md-block">{{ $match->back_bookmaker }}</small>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle d-none d-lg-table-cell bookmaker">
                                                <span class="bookmaker-badge">{{ $match->back_bookmaker }}</span>
                                            </td>
                                            <td class="text-center align-middle ">
                                                <span class="badge bg-danger">Orbitxch</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="odds-display lay-odds">
                                                    <div class="odds-value text-muted">
                                                        {{ number_format(optional($match->lay_odds)->odds_draw_lay ?? 0, 2) }}
                                                    </div>
                                                    {{-- <small  class="odds-volume d-none d-md-block">{{ number_format(optional($match->lay_odds)->volume_draw_lay ?? 0) }}</small> --}}
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <button class="btn btn-sm btn-outline-success calc-btn"
                                                    data-toggle="modal" data-target="#calculatorModal"
                                                    data-back-odds="{{ $match->back_draw_odds }}"
                                                    data-lay-odds="{{ optional($match->lay_odds)->odds_draw_lay ?? 0 }}"
                                                    data-match="{{ $match->home_name }} vs {{ $match->away_name }}"
                                                    data-outcome="Draw" data-bookmaker="{{ $match->back_bookmaker }}">
                                                    <i class="fas fa-calculator d-none d-md-inline"></i>
                                                    <span class="d-none d-md-inline ml-1">Calc</span>
                                                    <i class="fas fa-calculator d-md-none"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif

                                    <!-- AWAY ROW -->
                                    <tr class="match-row match-row-last">
                                        <td class="align-middle">
                                            <span class="badge badge-soft-primary">
                                                {{ $match->competition_name ?? $match->sport_name }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="match-details">
                                                <div class="fw-semibold text-dark mb-1">
                                                    {{ $match->home_name }} <span class="text-muted">vs</span>
                                                    {{ $match->away_name }}
                                                </div>
                                                <div class="outcome-label text-danger">
                                                    <i class="fas fa-circle small"></i> {{ $match->away_name }}
                                                </div>
                                                <small class="text-muted d-block mt-1">
                                                    {{ $match->event_date ? \Carbon\Carbon::parse($match->event_date)->format('d M Y') : 'TBD' }}
                                                     {{$match->event_time}}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="type-badge type-away">AWAY</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="odds-display back-odds">
                                                <div class="odds-value">{{ number_format($match->back_away_odds, 2) }}
                                                </div>
                                                <small
                                                    class="odds-source d-none d-md-block">{{ $match->back_bookmaker }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle d-none d-lg-table-cell bookmaker">
                                            <span class="bookmaker-badge">{{ $match->back_bookmaker }}</span>
                                        </td>
                                        <td class="text-center align-middle ">
                                            <span class="badge bg-danger">Orbitxch</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($match->lay_odds)
                                                <div class="odds-display lay-odds">
                                                    <div class="odds-value">
                                                        {{ number_format($match->lay_odds->odds_away_lay, 2) }}</div>
                                                    <small
                                                        class="odds-volume d-none d-md-block">{{ number_format($match->lay_odds->volume_away_lay) }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">0.00</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <button class="btn btn-sm btn-outline-success calc-btn" data-toggle="modal"
                                                data-target="#calculatorModal"
                                                data-back-odds="{{ $match->back_away_odds }}"
                                                data-lay-odds="{{ $match->lay_odds ? $match->lay_odds->odds_away_lay : 0 }}"
                                                data-match="{{ $match->home_name }} vs {{ $match->away_name }}"
                                                data-outcome="{{ $match->away_name }}"
                                                data-bookmaker="{{ $match->back_bookmaker }}">
                                                <i class="fas fa-calculator d-none d-md-inline"></i>
                                                <span class="d-none d-md-inline ml-1">Calc</span>
                                                <i class="fas fa-calculator d-md-none"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-search fa-3x text-muted mb-3 opacity-50"></i>
                                                <h6 class="text-muted mb-1">No matches found</h6>
                                                <small class="text-muted">Try adjusting your search filters</small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->

                </div>
            </div>
        </div>
    </div>

    <!-- Calculator Modal -->
    <div class="modal fade" id="calculatorModal" tabindex="-1" role="dialog" aria-labelledby="calculatorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="calculatorModalLabel">
                        <i class="fas fa-calculator mr-2"></i>Freebet Conversion Calculator
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <!-- Match Info -->
                    <div class="alert alert-light border mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>

                                <div class="mt-1 mb-2">
                                    <span class="badge bg-warning" id="modalBookMaker">modalBookMaker</span>
                                </div>
                                <strong class="text-dark" id="modalMatchName">Match</strong>
                                <div class="mt-1">
                                    <span class="badge bg-success" id="modalOutcome">Outcome</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <small class="text-muted d-block">Back Odds</small>
                                <strong class="text-success" style="font-size: 20px;" id="modalBackOdds">0.00</strong>
                                <small class="text-muted d-block mt-2">Lay Odds</small>
                                <strong class="text-danger" style="font-size: 20px;" id="modalLayOdds">0.00</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Input Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-semibold text-secondary">Freebet Stake (€)</label>
                                <input type="number" class="form-control form-control-lg" id="freebetStake"
                                    value="30" min="0" step="0.01">
                                <small class="text-muted">Enter your freebet amount</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-semibold text-secondary">Orbitx Commission (%)</label>
                                <input type="number" class="form-control form-control-lg" id="commission"
                                    value="3" min="0" max="100" step="0.1">
                                <small class="text-muted">Platform commission rate</small>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary btn-block btn-lg mb-4" onclick="calculateConversion()">
                        <i class="fas fa-calculator mr-2"></i>Calculate
                    </button>

                    <!-- Results Section -->
                    <div id="resultsSection" style="display: none;">
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Back Position -->
                                <div class="calculation-card bg-success-light mb-3">
                                    <h6 class="text-success mb-3">
                                        <i class="fas fa-arrow-up mr-2"></i>BACK Position (Freebet)
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Odds</small>
                                            <strong id="resultBackOdds">0.00</strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Stake</small>
                                            <strong id="resultBackStake">€0.00</strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Gross Winnings</small>
                                            <strong id="resultBackGross">€0.00</strong>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted d-block">Net Winnings (if wins)</small>
                                        <strong class="text-success" style="font-size: 18px;"
                                            id="resultBackNet">€0.00</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Lay Position -->
                                <div class="calculation-card bg-danger-light mb-3">
                                    <h6 class="text-danger mb-3">
                                        <i class="fas fa-arrow-down mr-2"></i>LAY Position
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Lay Odds</small>
                                            <strong id="resultLayOdds">0.00</strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Lay Stake</small>
                                            <strong id="resultLayStake">€0.00</strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Liability</small>
                                            <strong class="text-danger" id="resultLiability">€0.00</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Verification -->
                                <div class="calculation-card bg-info-light mb-3">
                                    <h6 class="text-info mb-3">
                                        <i class="fas fa-check-circle mr-2"></i>Verification
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">If Back Wins</small>
                                            <strong class="text-success" id="resultIfBackWins">€0.00</strong>
                                            <small class="text-muted d-block mt-1" id="calcIfBackWins"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">If Back Loses</small>
                                            <strong class="text-success" id="resultIfBackLoses">€0.00</strong>
                                            <small class="text-muted d-block mt-1" id="calcIfBackLoses"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Final Result -->
                                <div class="calculation-card bg-warning-light">
                                    <div class="text-center">
                                        <h6 class="text-dark mb-2">Conversion Rate</h6>
                                        <div class="conversion-rate" id="conversionRate">0.00%</div>
                                        <small class="text-muted" id="conversionCalc"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Populate modal with match data
        $('#calculatorModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var backOdds = button.data('back-odds');
            // var layOdds = button.data('lay-odds');
            var layOdds = 5;
            var match = button.data('match');
            var outcome = button.data('outcome');
            var bookmaker = button.data('bookmaker');

            $('#modalMatchName').text(match);
            $('#modalOutcome').text(outcome);
            $('#modalBookMaker').text(bookmaker);
            $('#modalBackOdds').text(parseFloat(backOdds).toFixed(2));
            $('#modalLayOdds').text(parseFloat(layOdds).toFixed(2));

            // Store odds in hidden inputs
            $('#calculatorModal').data('back-odds', backOdds);
            $('#calculatorModal').data('lay-odds', layOdds);

            // Hide results on open
            $('#resultsSection').hide();
        });

        function calculateConversion() {
            // Get input values
            const backOdds = parseFloat($('#calculatorModal').data('back-odds'));
            const layOdds = parseFloat($('#calculatorModal').data('lay-odds'));
            const freebetStake = parseFloat($('#freebetStake').val());
            const commissionPercent = parseFloat($('#commission').val());
            const commission = commissionPercent / 100;

            // Validation
            if (!backOdds || !layOdds || !freebetStake || backOdds <= 0 || layOdds <= 0 || freebetStake <= 0) {
                alert('Please enter valid values');
                return;
            }

            // BACK Position calculations
            const backGrossWinnings = freebetStake * backOdds;
            const backNetWinnings = backGrossWinnings - freebetStake;

            // LAY Position calculations
            const layStake = (freebetStake * backOdds) / (layOdds - commission);
            const liability = layStake * (layOdds - 1);

            // Verification
            const ifBackWins = backNetWinnings - liability;
            const ifBackLoses = layStake * (1 - commission);

            // Conversion rate
            const averageProfit = (ifBackWins + ifBackLoses) / 2;
            const conversionRate =  (averageProfit / freebetStake) * 100;
                         // const conversionRate =  ((((backOdds - 1) - (layOdds -1))  * ((backOdds - 1) / (layOdds - commission))) / (backOdds - 1)) * 100


            // Display results
            $('#resultBackOdds').text(backOdds.toFixed(2));
            $('#resultBackStake').text('€' + freebetStake.toFixed(2));
            $('#resultBackGross').text('€' + backGrossWinnings.toFixed(2));
            $('#resultBackNet').text('€' + backNetWinnings.toFixed(2));

            $('#resultLayOdds').text(layOdds.toFixed(2));
            $('#resultLayStake').text('€' + layStake.toFixed(2));
            $('#resultLiability').text('€' + liability.toFixed(2));

            $('#resultIfBackWins').text('€' + ifBackWins.toFixed(2));
            $('#calcIfBackWins').text(`€${backNetWinnings.toFixed(2)} - €${liability.toFixed(2)}`);

            $('#resultIfBackLoses').text('€' + ifBackLoses.toFixed(2));
            $('#calcIfBackLoses').text(`€${layStake.toFixed(2)} × (1 - ${commission.toFixed(2)})`);

            $('#conversionRate').text(conversionRate.toFixed(2) + '%');
            $('#conversionCalc').text(`€${averageProfit.toFixed(2)} / €${freebetStake.toFixed(2)} × 100`);

            // Show results
            $('#resultsSection').slideDown();
        }

        // Allow Enter key to calculate
        $('#freebetStake, #commission').on('keypress', function(e) {
            if (e.which === 13) {
                calculateConversion();
            }
        });
    </script>
    <style>
        .pricing-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            padding: 4rem 0;
        }

        .pricing-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-20px, -20px);
            }
        }

        .pricing-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            z-index: 1;
        }

        .pricing-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1rem;
        }

        .pricing-header p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 600px;
            margin: 0 auto;
        }

        .current-plan-banner {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }

        .current-plan-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .banner-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .banner-info {
            flex: 1;
        }

        .current-plan-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .banner-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .banner-description {
            color: #718096;
            font-size: 1rem;
            margin-bottom: 0;
        }

        .banner-action {
            flex-shrink: 0;
        }

        .btn-upgrade {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .btn-upgrade:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(245, 158, 11, 0.6);
            color: white;
        }

        .btn-upgrade i {
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .banner-content {
                flex-direction: column;
                text-align: center;
            }

            .banner-title {
                font-size: 1.5rem;
            }

            .btn-upgrade {
                width: 100%;
                justify-content: center;
            }
    </style>

    <style>
        /* Professional Design System */
        :root {
            --primary-color: #2563eb;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --info-color: #0ea5e9;
            --warning-color: #f59e0b;
            --muted-color: #6b7280;
            --border-color: #e5e7eb;
            --bg-light: #f9fafb;
        }

        /* Header Styling */
        .header-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .badge-outline-primary {
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Form Controls */
        .form-select,
        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 13px;
            transition: all 0.2s;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Professional Table */
        .professional-table {
            font-size: 13px;
        }

        .professional-table thead th {
            padding: 14px 12px;
            font-size: 11px;
            letter-spacing: 0.5px;
            font-weight: 600;
            background-color: #f9fafb;
        }

        .professional-table tbody td {
            padding: 16px 12px;
            border-top: 1px solid #f3f4f6;
        }

        .match-row {
            transition: background-color 0.15s ease;
        }

        .match-row:hover {
            background-color: #f9fafb;
        }

        .match-row-last {
            border-bottom: 2px solid #e5e7eb;
        }

        /* Match Details */
        .match-details {
            line-height: 1.5;
        }

        .outcome-label {
            font-size: 12px;
            font-weight: 500;
        }

        .outcome-label .fa-circle {
            font-size: 6px;
            margin-right: 4px;
        }

        /* Badges */
        .badge-soft-primary {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        /* Type Badge */
        .type-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .type-home {
            background-color: #d1fae5;
            color: #065f46;
        }

        .type-draw {
            background-color: #dbeafe;
            color: #075985;
        }

        .type-away {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Odds Display */
        .odds-display {
            display: inline-block;
            min-width: 70px;
        }

        .odds-value {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            display: block;
            line-height: 1.2;
        }

        .odds-source,
        .odds-volume {
            font-size: 10px;
            color: var(--muted-color);
            display: block;
            margin-top: 2px;
        }

        .back-odds .odds-value {
            color: var(--success-color);
        }

        .lay-odds .odds-value {
            color: var(--danger-color);
        }

        /* Bookmaker Badge */
        .bookmaker-badge {
            display: inline-block;
            padding: 5px 12px;
            background-color: #fef3c7;
            color: #92400e;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Buttons */
        .calc-btn {
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            transition: all 0.2s;
        }

        .calc-btn:hover {
            background-color: var(--success-color);
            color: white;
            border-color: var(--success-color);
            transform: translateY(-1px);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 6px;
            font-weight: 600;
        }

        .btn-outline-secondary {
            border-radius: 6px;
            font-weight: 600;
        }

        /* Empty State */
        .empty-state {
            padding: 60px 20px;
        }

        /* Card Shadows */
        .card {
            border-radius: 8px;
        }

        .shadow-sm {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .professional-table {
                font-size: 12px;
            }

            .odds-value {
                font-size: 14px;
            }

            .type-badge {
                font-size: 9px;
                padding: 3px 8px;
            }
        }

        @media (max-width: 768px) {
            .professional-table thead th {
                padding: 10px 8px;
            }

            .professional-table tbody td {
                padding: 12px 8px;
            }

            .match-details .fw-semibold {
                font-size: 13px;
            }

            .calc-btn {
                padding: 6px 10px;
            }

            .header-icon {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }
        }

        @media (max-width: 576px) {
            .odds-display {
                min-width: 60px;
            }

            .odds-value {
                font-size: 13px;
            }

            .badge-soft-primary {
                font-size: 10px;
                padding: 3px 8px;
            }
        }

        /* Pagination Styling */
        .pagination-info {
            font-size: 14px;
        }

        .custom-pagination .page-link {
            border: 1px solid #e5e7eb;
            color: #374151;
            padding: 8px 14px;
            margin: 0 2px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s;
        }

        .custom-pagination .page-link:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
            color: #111827;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }

        .custom-pagination .page-item.disabled .page-link {
            background-color: #f9fafb;
            border-color: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .custom-pagination .page-item:first-child .page-link,
        .custom-pagination .page-item:last-child .page-link {
            font-weight: 600;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 12px;
        }

        .modal-header.bg-primary {
            background-color: var(--primary-color) !important;
            border-radius: 12px 12px 0 0;
        }

        .calculation-card {
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .bg-success-light {
            background-color: #f0fdf4;
            border-color: #86efac;
        }

        .bg-danger-light {
            background-color: #fef2f2;
            border-color: #fca5a5;
        }

        .bg-info-light {
            background-color: #eff6ff;
            border-color: #93c5fd;
        }

        .bg-warning-light {
            background-color: #fffbeb;
            border-color: #fcd34d;
        }

        .conversion-rate {
            font-size: 36px;
            font-weight: 700;
            color: #059669;
            margin: 10px 0;
        }

        /* Responsive Pagination */
        .pagination-info {
            font-size: 14px;
        }

        .custom-pagination .page-link {
            border: 1px solid #e5e7eb;
            color: #374151;
            padding: 8px 14px;
            margin: 0 2px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s;
        }

        .custom-pagination .page-link:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
            color: #111827;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }

        .custom-pagination .page-item.disabled .page-link {
            background-color: #f9fafb;
            border-color: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .custom-pagination .page-item:first-child .page-link,
        .custom-pagination .page-item:last-child .page-link {
            font-weight: 600;
        }

        /* Pagination Styling */
        @media (max-width: 576px) {
            .pagination-info {
                font-size: 12px;
                width: 100%;
                text-align: center;
                margin-bottom: 12px;
            }

            .custom-pagination {
                justify-content: center;
            }

            .custom-pagination .page-link {
                padding: 6px 10px;
                font-size: 12px;
                margin: 0 1px;
            }
        }

        /* Print Styles */
        @media print {

            .card-header,
            .card-footer,
            form,
            .calc-btn {
                display: none;
            }
        }
    </style>
@endsection
