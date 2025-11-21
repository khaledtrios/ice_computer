@extends('auth.app')
@section('meta')
    <title>MODEL‑ITECH – Connexion utilisateur réparateurs</title>
    <meta name="description"
        content="Connectez‑vous à votre tableau de bord MODEL‑ITECH pour gérer vos devis, rendez‑vous et clients. Accès sécurisé pour réparateurs mobiles et informatiques.">
    <meta name="keywords" content="Connexion,devis,RDV,réparateurs mobiles">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection
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
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Ice-Computer" class="auth-logo">
                            </a>
                        </div>

                        <!-- Titre -->
                        <div class="auth-header text-center mb-4">
                            <h1 class="auth-title">Connexion</h1>
                            <h2 class="auth-subtitle">Connectez-vous à votre espace</h2>
                        </div>

                        <!-- Formulaire -->
                        <form id="loginForm" action="{{ route('login') }}" method="POST">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">Adresse Email</label>
                                <input type="email" class="form-control auth-input @error('email') is-invalid @enderror"
                                    id="loginEmail" name="email" placeholder="exemple@email.com" required
                                    autocomplete="email" autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <input type="password"
                                        class="form-control auth-input @error('password') is-invalid @enderror"
                                        id="loginPassword" name="password" placeholder="********" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-password-btn"
                                        aria-label="Afficher/Masquer le mot de passe">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Se souvenir / Mot de passe oublié -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="auth-link">
                                    Mot de passe oublié ?
                                </a>
                            </div>

                            <!-- Bouton de connexion -->
                            <button type="submit" id="loginSubmitBtn" class="btn auth-btn w-100 mb-3">
                                <span id="loginBtnText">Se connecter</span>
                                <span id="loginLoader" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>

                            <!-- Lien vers inscription -->
                            <p class="text-center auth-footer-text mb-0">
                                Pas encore de compte ?
                                <a href="{{ route('register') }}" class="auth-link-primary">
                                    Créer un compte
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

            /* Bouton toggle password */
            .toggle-password-btn {
                border: 1px solid var(--border-color);
                border-left: none;
                background: #f8f9fa;
                color: var(--text-secondary);
                border-radius: 0 8px 8px 0;
                padding: 12px 16px;
                transition: all 0.3s ease;
            }

            .toggle-password-btn:hover {
                background: #e9ecef;
                color: var(--text-primary);
            }

            .input-group .auth-input {
                border-radius: 8px 0 0 8px;
            }

            /* Checkbox */
            .form-check-input:checked {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            .form-check-label {
                font-size: 14px;
                color: var(--text-secondary);
            }

            /* Liens */
            .auth-link {
                color: var(--primary-dark);
                text-decoration: none;
                font-size: 14px;
                font-weight: 500;
                transition: color 0.3s ease;
            }

            .auth-link:hover {
                color: var(--primary-color);
                text-decoration: underline;
            }

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
                const togglePasswordBtn = document.querySelector('.toggle-password-btn');
                const passwordInput = document.getElementById('loginPassword');
                const toggleIcon = togglePasswordBtn.querySelector('i');

                togglePasswordBtn.addEventListener('click', () => {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    toggleIcon.classList.toggle('ti-eye-off', !isPassword);
                    toggleIcon.classList.toggle('ti-eye', isPassword);
                });

                const form = document.getElementById('loginForm');
                const submitBtn = document.getElementById('loginSubmitBtn');
                const btnText = document.getElementById('loginBtnText');
                const loader = document.getElementById('loginLoader');

                form.addEventListener('submit', function (e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        form.classList.add('was-validated');
                        return;
                    }

                    submitBtn.disabled = true;
                    btnText.textContent = 'Connexion en cours...';
                    loader.classList.remove('d-none');
                });

                ['loginEmail', 'loginPassword'].forEach(id => {
                    const input = document.getElementById(id);
                    if (input) {
                        input.addEventListener('input', () => {
                            input.classList.remove('is-invalid');
                        });
                    }
                });
            });
        </script>
    @endsection
@endsection