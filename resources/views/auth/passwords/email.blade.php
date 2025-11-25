@extends('layouts.app')

@section('content')
<style>
    .forgot-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }
    
    .forgot-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-20px, -20px); }
    }
    
    .forgot-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        transition: transform 0.3s ease;
    }
    
    .forgot-card:hover {
        transform: translateY(-5px);
    }
    
    .forgot-header {
        margin-bottom: 2rem;
    }
    
    .forgot-header h4 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .forgot-header p {
        color: #718096;
        font-size: 0.95rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .form-control {
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }
    
    .btn-forgot {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-forgot:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
    
    .btn-forgot:active {
        transform: translateY(0);
    }
    
    .back-link {
        color: #718096;
        font-size: 0.95rem;
    }
    
    .back-link a {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .back-link a:hover {
        color: #764ba2;
        text-decoration: underline;
    }
    
    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .is-invalid {
        border-color: #f56565 !important;
    }
    
    .icon-wrapper {
        width: 70px;
        height: 70px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border: none;
        border-radius: 10px;
        color: white;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .info-box {
        background: #eef2ff;
        border-left: 4px solid #667eea;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        color: #4a5568;
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .forgot-wrapper {
            padding: 1rem;
        }
        
        .forgot-card {
            margin: 1rem 0;
        }
    }
</style>

<div class="forgot-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5 col-md-7">
                <div class="card forgot-card">
                    <div class="card-body p-4 p-sm-5">
                        
                        <div class="forgot-header text-center">
                            <div class="icon-wrapper">
                                🔑
                            </div>
                            <h4>Forgot Password?</h4>
                            <p>No worries! Enter your email and we'll send you a reset link</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                ✓ {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input 
                                    id="email" 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autocomplete="email" 
                                    autofocus
                                    placeholder="Enter your email address">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="info-box">
                                💡 You'll receive an email with a link to reset your password
                            </div>

                            <div class="mb-4">
                                <button class="btn btn-forgot" type="submit">
                                    Send Reset Link
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="back-link">
                        Remember your password? 
                        <a href="{{ route('login') }}">Back to Login</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection