<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>DAF ACADEMY | Institution Scolaire Bilingue</title>

        <link rel="icon" href="{{ asset('image/logo.jpeg') }}" type="image/jpeg">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

        <style>
            :root {
                --primary: #0d6efd;
                --secondary: #00a8ff;
                --success: #198754;
                --dark: #07111f;
                --glass: rgba(255, 255, 255, 0.12);
                --glass-border: rgba(255, 255, 255, 0.20);
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;

                background-image:
                    linear-gradient(135deg,
                        rgba(3, 18, 38, 0.88),
                        rgba(5, 58, 90, 0.65),
                        rgba(0, 0, 0, 0.75)),
                    url("{{ asset('image/globe1.jpg') }}");

                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                background-repeat: no-repeat;

                color: #fff;
            }

            /* =========================
           CONTENEUR PRINCIPAL
        ========================= */

            .page-wrapper {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .main-container {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;

                padding: 40px 15px;
            }

            /* =========================
           CARTE PRINCIPALE
        ========================= */

            .academy-card {
                width: 100%;
                max-width: 1000px;

                padding: 45px;

                background: rgba(255, 255, 255, 0.10);
                border: 1px solid var(--glass-border);

                border-radius: 28px;

                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);

                box-shadow:
                    0 25px 60px rgba(0, 0, 0, 0.45);

                animation: fadeIn 0.9s ease;
            }

            /* =========================
           LOGO
        ========================= */

            .academy-logo {
                width: 115px;
                height: 115px;

                object-fit: cover;

                border-radius: 50%;

                border: 4px solid rgba(255, 255, 255, 0.9);

                box-shadow:
                    0 8px 30px rgba(0, 0, 0, 0.45);

                margin-bottom: 20px;
            }

            /* =========================
           TITRES
        ========================= */

            .academy-title {
                font-size: clamp(2.2rem, 5vw, 4rem);

                font-weight: 800;

                letter-spacing: 2px;

                margin-bottom: 8px;

                text-shadow:
                    0 5px 20px rgba(0, 0, 0, 0.5);
            }

            .academy-subtitle {
                font-size: clamp(1rem, 2vw, 1.35rem);

                color: rgba(255, 255, 255, 0.88);

                font-weight: 400;

                margin-bottom: 10px;
            }

            .academy-description {
                max-width: 700px;

                margin: 0 auto 30px;

                color: rgba(255, 255, 255, 0.72);

                font-size: 1rem;

                line-height: 1.7;
            }

            .title-line {
                width: 80px;
                height: 4px;

                margin: 18px auto 25px;

                border-radius: 10px;

                background: linear-gradient(90deg,
                        var(--secondary),
                        #ffffff,
                        var(--primary));
            }

            /* =========================
           CONTACTS
        ========================= */

            .contact-title {
                font-size: 1.1rem;

                font-weight: 600;

                margin-bottom: 15px;

                color: #fff;
            }

            .contact-links {
                display: flex;

                justify-content: center;

                flex-wrap: wrap;

                gap: 12px;

                margin-bottom: 35px;
            }

            .contact-links a {
                display: inline-flex;

                align-items: center;

                gap: 9px;

                padding: 11px 18px;

                color: #fff;

                text-decoration: none;

                background: rgba(0, 0, 0, 0.30);

                border: 1px solid rgba(255, 255, 255, 0.16);

                border-radius: 50px;

                transition:
                    transform 0.25s ease,
                    background 0.25s ease,
                    box-shadow 0.25s ease;
            }

            .contact-links a:hover {
                transform: translateY(-4px);

                background: rgba(255, 255, 255, 0.15);

                color: #fff;

                box-shadow:
                    0 10px 25px rgba(0, 0, 0, 0.25);
            }

            .contact-links i {
                font-size: 1.05rem;
            }

            .phone-icon {
                color: #25d366;
            }

            .whatsapp-icon {
                color: #25d366;
            }

            .email-icon {
                color: #ffca28;
            }

            .location-icon {
                color: #ff5252;
            }

            /* =========================
           BOUTONS
        ========================= */

            .login-section {
                margin-top: 20px;
            }

            .login-title {
                font-size: 1.15rem;

                font-weight: 600;

                margin-bottom: 18px;
            }

            .login-buttons {
                display: flex;

                justify-content: center;

                flex-wrap: wrap;

                gap: 15px;
            }

            .btn-academy {
                min-width: 190px;

                padding: 12px 22px;

                border-radius: 50px;

                font-weight: 600;

                border: none;

                transition:
                    transform 0.25s ease,
                    box-shadow 0.25s ease;
            }

            .btn-academy:hover {
                transform: translateY(-4px);

                box-shadow:
                    0 10px 25px rgba(0, 0, 0, 0.30);
            }

            .btn-login {
                background: linear-gradient(135deg,
                        #0d6efd,
                        #0056d6);

                color: #fff;
            }

            .btn-login:hover {
                color: #fff;
            }

            .btn-enseignant {
                background: linear-gradient(135deg,
                        #00a8ff,
                        #0077b6);

                color: #fff;
            }

            .btn-enseignant:hover {
                color: #fff;
            }

            .btn-register {
                background: linear-gradient(135deg,
                        #198754,
                        #116b43);

                color: #fff;
            }

            .btn-register:hover {
                color: #fff;
            }

            .btn-register-teacher {
                background: linear-gradient(135deg,
                        #6f42c1,
                        #4b2884);

                color: #fff;
            }

            .btn-register-teacher:hover {
                color: #fff;
            }

            /* =========================
           MESSAGE CONTACT
        ========================= */

            .no-contact {
                background: rgba(220, 53, 69, 0.15);

                border: 1px solid rgba(220, 53, 69, 0.30);

                padding: 12px 20px;

                border-radius: 10px;

                color: #ffb3b8;

                margin-bottom: 30px;
            }

            /* =========================
           FOOTER
        ========================= */

            footer {
                padding: 18px 15px;

                background: rgba(0, 0, 0, 0.35);

                border-top: 1px solid rgba(255, 255, 255, 0.10);

                text-align: center;

                color: rgba(255, 255, 255, 0.65);

                font-size: 0.9rem;
            }

            footer strong {
                color: #fff;
            }

            /* =========================
           ANIMATION
        ========================= */

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(25px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* =========================
           RESPONSIVE
        ========================= */

            @media (max-width: 768px) {

                .main-container {
                    padding: 25px 12px;
                }

                .academy-card {
                    padding: 30px 20px;

                    border-radius: 20px;
                }

                .academy-logo {
                    width: 90px;
                    height: 90px;
                }

                .contact-links {
                    flex-direction: column;

                    align-items: stretch;
                }

                .contact-links a {
                    justify-content: center;
                }

                .login-buttons {
                    flex-direction: column;
                }

                .btn-academy {
                    width: 100%;
                }
            }
        </style>
    </head>

    <body>

        <div class="page-wrapper">

            <main class="main-container">

                <div class="academy-card text-center">

                    <!-- LOGO -->
                    <img src="{{ asset('image/logo.jpeg') }}" alt="Logo DAF ACADEMY" class="academy-logo">

                    <!-- TITRE -->
                    <h1 class="academy-title">
                        DAF ACADEMY
                    </h1>

                    <div class="title-line"></div>

                    <h2 class="academy-subtitle">
                        INSTITUTION SCOLAIRE BILINGUE
                    </h2>

                    <p class="academy-description">
                        Une institution dédiée à l'excellence académique,
                        à l'éducation et à la formation des jeunes générations.
                        <br>
                        <strong>Français &nbsp;•&nbsp; Anglais</strong>
                    </p>


                    <!-- =========================
                 CONTACT
            ========================== -->

                    <div class="contact-section">

                        <div class="contact-title">
                            <i class="fas fa-address-card me-2"></i>
                            Nous contacter
                        </div>

                        @if ($les_contacts)

                            <div class="contact-links">

                                {{-- Téléphone --}}
                                @if ($les_contacts->tel)
                                    <a href="tel:{{ $les_contacts->tel }}">

                                        <i class="fas fa-phone phone-icon"></i>

                                        <span>
                                            {{ $les_contacts->tel }}
                                        </span>

                                    </a>
                                @endif


                                {{-- WhatsApp --}}
                                @if ($les_contacts->tel)
                                    @php
                                        /*
                                         * WhatsApp exige généralement le numéro
                                         * au format international sans +,
                                         * espaces ou caractères spéciaux.
                                         */
                                        $numeroWhatsapp = preg_replace('/[^0-9]/', '', $les_contacts->tel);
                                    @endphp

                                    <a href="https://wa.me/{{ $numeroWhatsapp }}" target="_blank"
                                        rel="noopener noreferrer">

                                        <i class="fab fa-whatsapp whatsapp-icon"></i>

                                        <span>
                                            WhatsApp
                                        </span>

                                    </a>
                                @endif


                                {{-- Email --}}
                                @if ($les_contacts->couriel)
                                    <a href="mailto:{{ $les_contacts->couriel }}">

                                        <i class="fas fa-envelope email-icon"></i>

                                        <span>
                                            {{ $les_contacts->couriel }}
                                        </span>

                                    </a>
                                @endif


                                {{-- Adresse --}}
                                @if ($les_contacts->adresse)
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($les_contacts->adresse) }}"
                                        target="_blank" rel="noopener noreferrer">

                                        <i class="fas fa-location-dot location-icon"></i>

                                        <span>
                                            {{ $les_contacts->adresse }}
                                        </span>

                                    </a>
                                @endif

                            </div>
                        @else
                            <div class="no-contact">

                                <i class="fas fa-triangle-exclamation me-2"></i>

                                Les informations de contact ne sont pas encore disponibles.

                            </div>

                        @endif

                    </div>


                    <!-- =========================
                 AUTHENTIFICATION
            ========================== -->

                    @if (Route::has('login'))

                        <div class="login-section">

                            <div class="login-title">

                                <i class="fas fa-right-to-bracket me-2"></i>

                                Accéder à votre espace

                            </div>


                            <div class="login-buttons">

                                @auth

                                    {{-- Dashboard --}}
                                    <a href="{{ url('/dashboard') }}" class="btn btn-academy btn-login">

                                        <i class="fas fa-gauge-high me-2"></i>

                                        Mon tableau de bord

                                    </a>
                                @else
                                    {{-- Connexion administrateur / utilisateur --}}
                                    <a href="{{ route('login') }}" class="btn btn-academy btn-login">

                                        <i class="fas fa-user-lock me-2"></i>

                                        Se connecter

                                    </a>


                                    {{-- Connexion enseignant --}}
                                    @if (Route::has('form_login_enseignant'))
                                        <a href="{{ route('form_login_enseignant') }}"
                                            class="btn btn-academy btn-enseignant">

                                            <i class="fas fa-chalkboard-teacher me-2"></i>

                                            Espace enseignant

                                        </a>
                                    @endif


                                    {{-- Inscription utilisateur --}}
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-academy btn-register">

                                            <i class="fas fa-user-plus me-2"></i>

                                            Créer un compte

                                        </a>
                                    @endif


                                    {{-- Inscription enseignant --}}
                                    @if (Route::has('register_enseigannt'))
                                        <a href="{{ route('register_enseigannt') }}"
                                            class="btn btn-academy btn-register-teacher">

                                            <i class="fas fa-person-chalkboard me-2"></i>

                                            Inscription enseignant

                                        </a>
                                    @endif

                                @endauth

                            </div>

                        </div>

                    @endif

                </div>

            </main>


            <!-- =========================
         FOOTER
    ========================== -->

            <footer>

                <div>

                    &copy; {{ date('Y') }}

                    <strong>DAF ACADEMY</strong>

                    — Tous droits réservés.

                </div>

                <small>

                    Institution Scolaire Bilingue
                    <span class="mx-2">•</span>
                    Français - Anglais

                </small>

            </footer>

        </div>


        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
