@extends('layouts.app')

@section('content')
<style>
    .reset-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }
    
    .reset-wrapper::before {
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
    
    .reset-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        transition: transform 0.3s ease;
    }
    
    .reset-card:hover {
        transform: translateY(-5px);
    }
    
    .reset-header {
        margin-bottom: 2rem;
    }
    
    .reset-header h4 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .reset-header p {
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
    
    .password-toggle {
        background: transparent;
        border: none;
        color: #718096;
        cursor: pointer;
        padding: 0 1rem;
        transition: color 0.3s ease;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
    }
    
    .password-toggle:hover {
        color: #667eea;
    }
    
    .btn-reset {
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
    
    .btn-reset:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
    
    .btn-reset:active {
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
    
    @media (max-width: 768px) {
        .reset-wrapper {
            padding: 1rem;
        }
        
        .reset-card {
            margin: 1rem 0;
        }
    }
</style>

<div class="reset-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5 col-md-7">
                <div class="card reset-card">
                    <div class="card-body p-4 p-sm-5">
                        
                        <div class="reset-header text-center">
                            <div class="icon-wrapper">
                                🔐
                            </div>
                            <h4>Reset Password</h4>
                            <p>Enter your email and new PIN to reset your password</p>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input 
                                    id="email" 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" 
                                    value="{{ $email ?? old('email') }}" 
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

                            <div class="mb-4">
                                <label for="password" class="form-label">New PIN</label>
                                <div class="position-relative">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        pattern="\d*" 
                                        inputmode="numeric" 
                                        minlength="4" 
                                        maxlength="4" 
                                        placeholder="Enter new 4-digit PIN" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        name="password" 
                                        required 
                                        autocomplete="new-password"
                                        style="padding-right: 3rem;">
                                    <button class="password-toggle" type="button" onclick="togglePassword('password')">
                                        <i class="eye-icon-1">👁️</i>
                                    </button>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label">Confirm PIN</label>
                                <div class="position-relative">
                                    <input 
                                        id="password-confirm" 
                                        type="password" 
                                        pattern="\d*" 
                                        inputmode="numeric" 
                                        minlength="4" 
                                        maxlength="4" 
                                        placeholder="Confirm new 4-digit PIN" 
                                        class="form-control" 
                                        name="password_confirmation" 
                                        required 
                                        autocomplete="new-password"
                                        style="padding-right: 3rem;">
                                    <button class="password-toggle" type="button" onclick="togglePassword('password-confirm')">
                                        <i class="eye-icon-2">👁️</i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <button class="btn btn-reset" type="submit">
                                    Reset Password
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

<script>
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const eyeIcon = fieldId === 'password' ? document.querySelector('.eye-icon-1') : document.querySelector('.eye-icon-2');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.textContent = '🙈';
    } else {
        passwordInput.type = 'password';
        eyeIcon.textContent = '👁️';
    }
}
</script>

@endsection