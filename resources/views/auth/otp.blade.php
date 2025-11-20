@extends('layouts.app')

@section('content')

    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Verify OTP</h4>
                                <p class="text-muted mb-4">Enter OTP received on you registered phone number</p>
                            </div>

                            <form method="POST" action="{{ route('otp.validate') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="centy_plus_otp" class="form-label">Centy OTP</label>
                                    <div class="input-group">
                                        <span class="input-group-text">CNT-</span>
                                        <input id="centy_plus_otp" type="text" class="form-control @error('centy_plus_otp') is-invalid @enderror" name="centy_plus_otp" value="{{ old('centy_plus_otp') }}" required autocomplete="centy_plus_otp" autofocus>
                                        @isset($error)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $error }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit">Validate</button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
