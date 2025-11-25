@extends('layouts.app')

@section('content')
<style>
    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }
    
    .login-wrapper::before {
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
    
    .login-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        transition: transform 0.3s ease;
    }
    
    .login-card:hover {
        transform: translateY(-5px);
    }
    
    .login-header {
        margin-bottom: 2rem;
    }
    
    .login-header h4 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .login-header p {
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
    }
    
    .password-toggle:hover {
        color: #667eea;
    }
    
    .btn-login {
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
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
    
    .btn-login:active {
        transform: translateY(0);
    }
    
    .forgot-link {
        color: #667eea;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .forgot-link:hover {
        color: #764ba2;
        text-decoration: underline;
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .form-check-label {
        color: #4a5568;
        font-size: 0.9rem;
    }
    
    .signup-link {
        color: #718096;
        font-size: 0.95rem;
    }
    
    .signup-link a {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .signup-link a:hover {
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
        .login-wrapper {
            padding: 1rem;
        }
        
        .login-card {
            margin: 1rem 0;
        }
    }
</style>

<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5 col-md-7">
                <div class="card login-card">
                    <div class="card-body p-4 p-sm-5">
                        
                        <div class="login-header text-center">
                            <h4>Welcome Back</h4>
                            <p>Enter your credentials to access your account</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf


                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="centy_plus_id" class="form-label mb-0">Email</label>
                                  
                                </div>
                                <div class="position-relative">
                                    <input 
                                        id="centy_plus_id" 
                                        type="text" 
                                        class=" form-control @error('centy_plus_id') is-invalid @enderror" 
                                        name="centy_plus_id" 
                                        value="{{ old('centy_plus_id') }}" 
                                        required 
                                        autocomplete="centy_plus_id" 
                                        autofocus
                                        placeholder="Enter your email">
                                   
                                    @error('centy_plus_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="password" class="form-label mb-0">PIN</label>
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot PIN?</a>
                                    @endif
                                </div>
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
                                        autocomplete="current-password"
                                        style="padding-right: 3rem;">
                                    <button class="password-toggle" type="button" onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                        <i class="eye-icon">👁️</i>
                                    </button>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="remember" 
                                        id="remember" 
                                        {{ old('remember') ? 'checked' : '' }} 
                                        checked>
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <button class="btn btn-login" type="submit">
                                    Log In
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="signup-link">
                        Don't have an account? 
                        <a href="{{ route('register') }}">Sign Up</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.querySelector('.eye-icon');
    
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