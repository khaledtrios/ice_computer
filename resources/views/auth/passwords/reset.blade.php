@extends('auth.app')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-decorations">
            <div class="auth-circle auth-circle-1"></div>
            <div class="auth-circle auth-circle-2"></div>
            <div class="auth-circle auth-circle-3"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-12 col-md-10 col-lg-5">
                    <div class="auth-card">
                        <!-- Logo -->
                        <div class="d-flex justify-content-center align-items-center mb-4">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="MODEL-ITECH" class="auth-logo">
                            </a>
                        </div>

                        <!-- Titre -->
                        <div class="auth-header text-center mb-4">
                            <h1 class="auth-title">Réinitialiser le mot de passe</h1>
                            <p class="auth-subtitle">Entrez votre nouveau mot de passe</p>
                        </div>

                        <!-- Formulaire -->
                        <form id="resetPasswordForm" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse Email</label>
                                <input type="email" class="form-control auth-input @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="exemple@email.com" required
                                    autocomplete="email" autofocus value="{{ $email ?? old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Nouveau Mot de Passe</label>
                                <input type="password" class="form-control auth-input @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="••••••••" required
                                    autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">Confirmer le Mot de Passe</label>
                                <input type="password" class="form-control auth-input"
                                    id="password-confirm" name="password_confirmation" placeholder="••••••••" required
                                    autocomplete="new-password">
                            </div>

                            <!-- Bouton d'envoi -->
                            <button type="submit" id="resetPasswordSubmitBtn" class="btn auth-btn w-100 mb-3">
                                <span id="resetPasswordBtnText">Réinitialiser le mot de passe</span>
                                <span id="resetPasswordLoader" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>

                            <!-- Lien vers connexion -->
                            <p class="text-center auth-footer-text mb-0">
                                Vous vous souvenez de votre mot de passe ?
                                <a href="{{ route('login') }}" class="auth-link-primary">
                                    Se connecter
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        :root {
            --primary-color: #46D8D5;
            --primary-dark: #309E9B;
            --text-primary: #1a1a1a;
            --text-secondary: #757272;
            --bg-light: #f8f9fa;
            --border-color: #e0e0e0;
        }

        .auth-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
        }

        .auth-decorations {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .auth-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
        }

        .auth-circle-1 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(70, 216, 213, 0.3), transparent);
            top: -100px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
        }

        .auth-circle-2 {
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(48, 158, 155, 0.2), transparent);
            bottom: 10%;
            left: -50px;
            animation: float 8s ease-in-out infinite;
        }

        .auth-circle-3 {
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(70, 216, 213, 0.25), transparent);
            top: 50%;
            left: 10%;
            animation: float 7s ease-in-out infinite;
        }

        @keyframes float {
            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Carte d'authentification */
        .auth-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 1;
            border: 1px solid var(--border-color);
        }

        /* Logo */
        .auth-logo {
            max-height: 60px;
            width: auto;
        }

        /* En-tête */
        .auth-header {
            margin-bottom: 2rem;
        }

        .auth-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-family: math, sans-serif;
        }

        .auth-subtitle {
            font-size: 15px;
            color: var(--text-secondary);
            margin-bottom: 0;
        }

        /* Champs de formulaire */
        .form-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .auth-input {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .auth-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(70, 216, 213, 0.1);
            outline: none;
        }

        .auth-input::placeholder {
            color: #a0a0a0;
        }

        /* Liens */
        .auth-link-primary {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-link-primary:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Bouton principal */
        .auth-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(70, 216, 213, 0.3);
        }

        .auth-btn:active {
            transform: translateY(0);
        }

        .auth-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Texte footer */
        .auth-footer-text {
            color: var(--text-secondary);
            font-size: 14px;
        }

        /* Alert */
        .alert {
            border-radius: 8px;
            border: none;
            padding: 12px 16px;
        }

        .alert-success {
            background-color: rgba(70, 216, 213, 0.1);
            color: var(--primary-dark);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-card {
                padding: 30px 20px;
            }

            .auth-title {
                font-size: 24px;
            }

            .auth-circle-1,
            .auth-circle-2,
            .auth-circle-3 {
                display: none;
            }
        }

        /* Validation errors */
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 4px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('resetPasswordForm');
            const submitBtn = document.getElementById('resetPasswordSubmitBtn');
            const btnText = document.getElementById('resetPasswordBtnText');
            const loader = document.getElementById('resetPasswordLoader');

            form.addEventListener('submit', function (e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    form.classList.add('was-validated');
                    return;
                }

                submitBtn.disabled = true;
                btnText.textContent = 'Réinitialisation en cours...';
                loader.classList.remove('d-none');
            });

            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            if (emailInput) {
                emailInput.addEventListener('input', () => {
                    emailInput.classList.remove('is-invalid');
                });
            }
            if (passwordInput) {
                passwordInput.addEventListener('input', () => {
                    passwordInput.classList.remove('is-invalid');
                });
            }
        });
    </script>
@endsection