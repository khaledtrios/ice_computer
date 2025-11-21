@extends('auth.app')
@section('meta')
    <title>MODEL‑ITECH – Créer un compte réparateur</title>
    <meta name="description"
        content="Inscrivez‑vous gratuitement sur MODEL‑ITECH et accédez à tous les outils pour gérer vos devis, rendez‑vous, clients et planning de réparation mobile/informatique.">
    <meta name="keywords" content="Plateforme Ice-Computer,devis,RDV,Inscrivez‑vous">
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
            <div class="row justify-content-center align-items-center py-5">
                <div class="col-12 col-md-11 col-lg-8">
                    <div class="auth-card">
                        <!-- Logo -->
                        <div class="d-flex justify-content-center align-items-center mb-4">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Ice-Computer" class="auth-logo">
                            </a>
                        </div>


                        <!-- Titre -->
                        <div class="auth-header text-center mb-4">
                            <h1 class="auth-title">Créer votre compte</h1>
                            <h2 class="auth-subtitle">Configurez votre boutique en quelques clics</h2>
                        </div>

                        <!-- Formulaire -->
                        <form id="registerForm" action="{{ route('register') }}" method="POST">
                            @csrf

                            <!-- Section Informations personnelles -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fa-solid fa-user"></i> Informations personnelles
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">Prénom <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control auth-input @error('first_name') is-invalid @enderror"
                                            id="firstName" name="first_name" placeholder="Votre prénom" required
                                            autocomplete="given-name" autofocus>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">Nom <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control auth-input @error('last_name') is-invalid @enderror"
                                            id="lastName" name="last_name" placeholder="Votre nom" required
                                            autocomplete="family-name">
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="registerEmail" class="form-label">Adresse Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email"
                                            class="form-control auth-input @error('email') is-invalid @enderror"
                                            id="registerEmail" name="email" placeholder="exemple@email.com" required
                                            autocomplete="email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telephone" class="form-label">Téléphone <span
                                                class="text-danger">*</span></label>
                                        <input type="tel"
                                            class="form-control auth-input @error('telephone') is-invalid @enderror"
                                            id="telephone" name="telephone" placeholder="06 12 34 56 78" required
                                            autocomplete="tel">
                                        @error('telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="registerPassword" class="form-label">Mot de passe <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control auth-input @error('password') is-invalid @enderror"
                                                id="registerPassword" name="password" placeholder="********" required>
                                            <button type="button" class="btn btn-outline-secondary toggle-password-btn"
                                                data-target="registerPassword" aria-label="Afficher/Masquer">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="passwordConfirmation" class="form-label">Confirmer le mot de passe <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control auth-input @error('password_confirmation') is-invalid @enderror"
                                                id="passwordConfirmation" name="password_confirmation"
                                                placeholder="********" required>
                                            <button type="button" class="btn btn-outline-secondary toggle-password-btn"
                                                data-target="passwordConfirmation" aria-label="Afficher/Masquer">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section Boutique -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fa-solid fa-store"></i>
                                    Informations de la boutique
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nomBoutique" class="form-label">Nom de la boutique <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control auth-input @error('nom_boutique') is-invalid @enderror"
                                            id="nomBoutique" name="nom_boutique" placeholder="Nom de votre boutique"
                                            required>
                                        @error('nom_boutique')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="company" class="form-label">Nom de l'entreprise</label>
                                        <input type="text"
                                            class="form-control auth-input @error('company') is-invalid @enderror"
                                            id="company" name="company" placeholder="Votre entreprise"
                                            autocomplete="organization">
                                        @error('company')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="adresse" class="form-label">Adresse <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control auth-input @error('adresse') is-invalid @enderror"
                                            id="adresse" name="adresse" placeholder="Numéro et rue" required
                                            autocomplete="street-address">
                                        @error('adresse')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="codePostal" class="form-label">Code postal <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control auth-input @error('code_postal') is-invalid @enderror"
                                            id="codePostal" name="code_postal" placeholder="75001" required
                                            autocomplete="postal-code">
                                        @error('code_postal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="city" class="form-label">Ville <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control auth-input @error('city') is-invalid @enderror" id="city"
                                            name="city" placeholder="Paris" required autocomplete="address-level2">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="siret" class="form-label">SIRET</label>
                                        <input type="text"
                                            class="form-control auth-input @error('siret') is-invalid @enderror" id="siret"
                                            name="siret" placeholder="12345678901234" autocomplete="off">
                                        @error('siret')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Bouton de soumission -->
                            <button type="submit" id="registerSubmitBtn" class="btn auth-btn w-100 mb-3">
                                <span id="registerBtnText">Créer mon compte</span>
                                <span id="registerLoader" class="spinner-border spinner-border-sm d-none"
                                    role="status"></span>
                            </button>

                            <!-- Lien vers connexion -->
                            <p class="text-center auth-footer-text mb-0">
                                Vous avez déjà un compte ?
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

    @section('styles')
        <style>
            /* Variables de couleurs du thème */
            :root {
                --primary-color: #46D8D5;
                --primary-dark: #309E9B;
                --text-primary: #1a1a1a;
                --text-secondary: #757272;
                --bg-light: #f8f9fa;
                --border-color: #e0e0e0;
            }

            /* Wrapper principal */
            .auth-wrapper {
                min-height: 100vh;
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                position: relative;
                overflow: hidden;
            }

            /* Décorations circulaires */
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

            /* Sections du formulaire */
            .form-section {
                margin-bottom: 2rem;
                padding-bottom: 2rem;
                border-bottom: 1px solid var(--border-color);
            }

            .form-section:last-of-type {
                border-bottom: none;
                margin-bottom: 1.5rem;
            }

            .section-title {
                font-size: 18px;
                font-weight: 600;
                color: var(--primary-dark);
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .section-title i {
                font-size: 22px;
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

            /* Champs obligatoires */
            .text-danger {
                color: #dc3545;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .auth-card {
                    padding: 30px 20px;
                }

                .auth-title {
                    font-size: 24px;
                }

                .section-title {
                    font-size: 16px;
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
                // Toggle Password Visibility pour tous les champs
                const togglePasswordButtons = document.querySelectorAll('.toggle-password-btn');

                togglePasswordButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const targetId = button.getAttribute('data-target');
                        const passwordInput = document.getElementById(targetId);
                        const toggleIcon = button.querySelector('i');

                        const isPassword = passwordInput.getAttribute('type') === 'password';
                        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                        toggleIcon.classList.toggle('ti-eye-off', !isPassword);
                        toggleIcon.classList.toggle('ti-eye', isPassword);
                    });
                });

                // Form Submission Handler
                const form = document.getElementById('registerForm');
                const submitBtn = document.getElementById('registerSubmitBtn');
                const btnText = document.getElementById('registerBtnText');
                const loader = document.getElementById('registerLoader');

                form.addEventListener('submit', function (e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        form.classList.add('was-validated');
                        return;
                    }

                    submitBtn.disabled = true;
                    btnText.textContent = 'Création en cours...';
                    loader.classList.remove('d-none');
                });

                // Clear validation errors on input
                const inputIds = [
                    'firstName', 'lastName', 'registerEmail', 'telephone',
                    'registerPassword', 'passwordConfirmation', 'nomBoutique',
                    'company', 'adresse', 'codePostal', 'city', 'siret'
                ];

                inputIds.forEach(id => {
                    const input = document.getElementById(id);
                    if (input) {
                        input.addEventListener('input', () => {
                            input.classList.remove('is-invalid');
                        });
                    }
                });

                // Validation du mot de passe en temps réel
                const password = document.getElementById('registerPassword');
                const passwordConfirm = document.getElementById('passwordConfirmation');

                passwordConfirm.addEventListener('input', () => {
                    if (password.value !== passwordConfirm.value) {
                        passwordConfirm.setCustomValidity('Les mots de passe ne correspondent pas');
                    } else {
                        passwordConfirm.setCustomValidity('');
                    }
                });
            });
        </script>
    @endsection
@endsection