@extends('layouts.app')

@section('content')
<style>
    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        padding: 2rem 0;
    }
    
    .register-wrapper::before {
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
    
    .register-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        transition: transform 0.3s ease;
        overflow: hidden;
    }
    
    .register-card:hover {
        transform: translateY(-5px);
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        text-align: center;
        border: none;
    }
    
    .card-header-custom img {
        max-height: 50px;
        filter: brightness(0) invert(1);
    }
    
    .register-header {
        margin-bottom: 2rem;
    }
    
    .register-header h4 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .register-header p {
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
    
    .input-group-text {
        background: #f7fafc;
        border: 2px solid #e2e8f0;
        border-right: none;
        color: #667eea;
        font-weight: 600;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }
    
    .input-group .form-control {
        border-left: none;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    .input-group:focus-within .input-group-text {
        border-color: #667eea;
        background: #eef2ff;
    }
    
    .input-group {
        position: relative;
        display: flex;
        flex-wrap: nowrap;
        align-items: stretch;
        width: 100%;
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
    
    .btn-register {
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
    
    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
    
    .btn-register:active {
        transform: translateY(0);
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .form-check-label {
        color: #4a5568;
        font-size: 0.9rem;
    }
    
    .form-check-label a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }
    
    .form-check-label a:hover {
        color: #764ba2;
        text-decoration: underline;
    }
    
    .login-link {
        color: #718096;
        font-size: 0.95rem;
    }
    
    .login-link a {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .login-link a:hover {
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
    
    @media (max-width: 768px) {
        .register-wrapper {
            padding: 1rem;
        }
        
        .register-card {
            margin: 1rem 0;
        }
        
        .card-header-custom {
            padding: 1.5rem;
        }
    }
</style>

<div class="register-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-5 col-lg-6 col-md-8">
                <div class="card register-card">
                 
                  

                    <div class="card-body p-4 p-sm-5">
                        
                        <div class="register-header text-center">
                            <h4>Create Your Account</h4>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input 
                                    id="name"
                                    type="text"
                                    placeholder="Enter your full name" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    required 
                                    autocomplete="name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input 
                                    id="phone_number" 
                                    type="tel"
                                    placeholder="Enter your phone number"  
                                    minlength="10" 
                                    maxlength="10" 
                                    class="form-control @error('phone_number') is-invalid @enderror" 
                                    name="phone_number" 
                                    value="{{ old('phone_number') }}" 
                                    required 
                                    autocomplete="phone_number">
                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input 
                                    id="email" 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autocomplete="email" 
                                    placeholder="Enter your email address">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">PIN</label>
                                <div class="position-relative">
                                    <input 
                                        id="password"  
                                        type="password" 
                                        pattern="\d*" 
                                        inputmode="numeric" 
                                        minlength="4" 
                                        maxlength="4" 
                                        placeholder="Enter 4-digit PIN" 
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
                                        <strong>4 digit PIN required</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">Confirm PIN</label>
                                <div class="position-relative">
                                    <input 
                                        id="password-confirm" 
                                        type="password" 
                                        pattern="\d*" 
                                        inputmode="numeric" 
                                        minlength="4" 
                                        maxlength="4" 
                                        placeholder="Confirm 4-digit PIN" 
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
                                <div class="form-check">
                                    <input 
                                        type="checkbox" 
                                        class="form-check-input" 
                                        id="checkbox-signup"
                                        required>
                                    <label class="form-check-label" for="checkbox-signup">
                                        I accept <a href="#">Terms and Conditions</a>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <button class="btn btn-register" type="submit">
                                    Sign Up
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="login-link">
                        Already have an account? 
                        <a href="{{ route('login') }}">Log In</a>
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