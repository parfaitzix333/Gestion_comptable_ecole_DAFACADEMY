<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>DAF ACADEMY - Institution Scolaire Bilingue</title>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <!-- Google Fonts -->
        <link
            href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap"
            rel="stylesheet">
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <style>
            /* ===== RESET & GLOBAL ===== */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Poppins', sans-serif;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
                padding: 20px;
                position: relative;
            }

            /* Overlay sur l'image de fond */
            body::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: url("{{ asset('image/logo.jpeg') }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                opacity: 0.25;
                z-index: 0;
            }

            /* ===== CARTE PRINCIPALE ===== */
            .main-card {
                position: relative;
                z-index: 1;
                background: rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-radius: 40px;
                padding: 50px 45px 35px;
                max-width: 900px;
                width: 100%;
                border: 1px solid rgba(255, 255, 255, 0.12);
                box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
                transition: all 0.4s ease;
            }

            .main-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 40px 80px rgba(0, 0, 0, 0.8);
            }

            /* ===== LOGO ===== */
            .logo-wrapper {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 18px;
            }

            .school-logo {
                width: 100px;
                height: 100px;
                object-fit: cover;
                border-radius: 50%;
                border: 4px solid rgba(247, 201, 72, 0.85);
                box-shadow: 0 0 40px rgba(247, 201, 72, 0.15), 0 8px 25px rgba(0, 0, 0, 0.4);
                transition: all 0.4s ease;
                background: rgba(255, 255, 255, 0.05);
            }

            .school-logo:hover {
                transform: scale(1.04);
                box-shadow: 0 0 60px rgba(247, 201, 72, 0.25);
                border-color: #f7c948;
            }

            /* ===== EN-TÊTE ===== */
            .header-title {
                text-align: center;
                margin-bottom: 20px;
            }

            .header-title h1 {
                font-family: 'Playfair Display', serif;
                font-size: 3.2rem;
                font-weight: 700;
                color: #fff;
                text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
                letter-spacing: 2px;
            }

            .header-title h1 span {
                color: #f7c948;
            }

            .header-title .subtitle {
                font-size: 1.1rem;
                font-weight: 300;
                color: rgba(255, 255, 255, 0.85);
                letter-spacing: 4px;
                text-transform: uppercase;
                margin-top: 5px;
                border-top: 2px solid rgba(247, 201, 72, 0.3);
                border-bottom: 2px solid rgba(247, 201, 72, 0.3);
                display: inline-block;
                padding: 8px 25px;
            }

            /* ===== SÉPARATEUR DÉCORATIF ===== */
            .divider {
                width: 80px;
                height: 3px;
                background: linear-gradient(90deg, #f7c948, #f5a623);
                margin: 15px auto 25px;
                border-radius: 10px;
            }

            /* ===== BADGE D'ÉTAT ===== */
            .status-badge {
                display: inline-block;
                background: rgba(37, 211, 102, 0.2);
                border: 1px solid rgba(37, 211, 102, 0.3);
                color: #7ae9a5;
                padding: 4px 18px;
                border-radius: 50px;
                font-size: 0.75rem;
                font-weight: 400;
                letter-spacing: 1px;
                margin-bottom: 10px;
            }

            /* ===== CONTACT LINKS ===== */
            .contact-links {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 12px;
                margin: 20px 0 30px;
            }

            .contact-links a {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                padding: 12px 24px;
                border-radius: 50px;
                font-size: 0.95rem;
                font-weight: 500;
                color: #fff;
                text-decoration: none;
                background: rgba(255, 255, 255, 0.10);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.15);
                transition: all 0.3s ease;
                letter-spacing: 0.5px;
            }

            .contact-links a i {
                font-size: 1.2rem;
                width: 24px;
                text-align: center;
            }

            /* Couleurs au survol */
            .contact-links a.phone:hover {
                background: #25D366;
                border-color: #25D366;
                transform: translateY(-3px) scale(1.03);
                box-shadow: 0 10px 30px rgba(37, 211, 102, 0.3);
            }

            .contact-links a.whatsapp:hover {
                background: #25D366;
                border-color: #25D366;
                transform: translateY(-3px) scale(1.03);
                box-shadow: 0 10px 30px rgba(37, 211, 102, 0.3);
            }

            .contact-links a.email:hover {
                background: #EA4335;
                border-color: #EA4335;
                transform: translateY(-3px) scale(1.03);
                box-shadow: 0 10px 30px rgba(234, 67, 53, 0.3);
            }

            .contact-links a.location:hover {
                background: #4285F4;
                border-color: #4285F4;
                transform: translateY(-3px) scale(1.03);
                box-shadow: 0 10px 30px rgba(66, 133, 244, 0.3);
            }

            /* ===== INFORMATIONS DE L'ÉCOLE ===== */
            .school-information {
                margin: 25px 0;
                padding: 22px 24px;
                text-align: center;
                color: rgba(255, 255, 255, 0.9);
                background: rgba(255, 255, 255, 0.08);
                border: 1px solid rgba(255, 255, 255, 0.12);
                border-radius: 18px;
            }

            .school-information h2 {
                margin-bottom: 8px;
                color: #f7c948;
                font-family: 'Playfair Display', serif;
                font-size: 1.45rem;
            }

            .school-information p {
                margin: 0;
                line-height: 1.7;
                font-size: 0.92rem;
            }

            /* ===== NAVIGATION ===== */
            .nav-buttons {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
                margin-top: 25px;
                padding-top: 25px;
                border-top: 1px solid rgba(255, 255, 255, 0.08);
            }

            .nav-buttons .btn {
                border-radius: 50px;
                padding: 10px 28px;
                font-weight: 500;
                font-size: 0.9rem;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
                border: 1px solid transparent;
            }

            .nav-buttons .btn-primary {
                background: linear-gradient(135deg, #f7c948, #f5a623);
                border-color: #f7c948;
                color: #1a1a2e;
            }

            .nav-buttons .btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 30px rgba(247, 201, 72, 0.3);
            }

            .nav-buttons .btn-outline-light {
                border-color: rgba(255, 255, 255, 0.3);
                color: rgba(255, 255, 255, 0.9);
            }

            .nav-buttons .btn-outline-light:hover {
                background: rgba(255, 255, 255, 0.15);
                transform: translateY(-3px);
                border-color: #fff;
            }

            .nav-buttons .btn-info {
                background: rgba(13, 202, 240, 0.15);
                border-color: rgba(13, 202, 240, 0.3);
                color: #8dd9f5;
            }

            .nav-buttons .btn-info:hover {
                background: rgba(13, 202, 240, 0.3);
                transform: translateY(-3px);
            }

            /* ===== FOOTER ===== */
            .site-footer {
                margin-top: 30px;
                padding-top: 22px;
                text-align: center;
                color: rgba(255, 255, 255, 0.7);
                border-top: 1px solid rgba(255, 255, 255, 0.12);
            }

            .site-footer .footer-contact {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px 20px;
                margin-bottom: 14px;
                font-size: 0.8rem;
            }

            .site-footer .footer-contact span {
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .site-footer .copyright {
                margin: 0;
                font-size: 0.7rem;
                letter-spacing: 1px;
            }

            /* ===== RESPONSIVE ===== */
            @media (max-width: 768px) {
                .main-card {
                    padding: 30px 20px 25px;
                    border-radius: 28px;
                }

                .school-logo {
                    width: 80px;
                    height: 80px;
                }

                .header-title h1 {
                    font-size: 2.2rem;
                }

                .header-title .subtitle {
                    font-size: 0.85rem;
                    letter-spacing: 2px;
                    padding: 6px 15px;
                }

                .contact-links a {
                    font-size: 0.85rem;
                    padding: 10px 18px;
                }

                .nav-buttons .btn {
                    font-size: 0.8rem;
                    padding: 8px 18px;
                }
            }

            @media (max-width: 480px) {
                .main-card {
                    padding: 20px 15px;
                }

                .school-logo {
                    width: 65px;
                    height: 65px;
                    border-width: 3px;
                }

                .header-title h1 {
                    font-size: 1.7rem;
                }

                .contact-links {
                    gap: 8px;
                }

                .contact-links a {
                    font-size: 0.75rem;
                    padding: 8px 14px;
                }

                .contact-links a i {
                    font-size: 1rem;
                    width: 18px;
                }
            }
        </style>
    </head>

    <body>

        <div class="main-card">

            <!-- ===== LOGO ===== -->
            <div class="logo-wrapper">
                <img src="{{ asset('image/logo.jpeg') }}" alt="Logo DAF ACADEMY" class="school-logo">
            </div>

            <!-- ===== EN-TÊTE ===== -->
            <div class="header-title">
                <div class="status-badge">
                    <i class="fas fa-graduation-cap"></i> Établissement d'Excellence
                </div>
                <h1>DAF <span>ACADEMY</span></h1>
                <div class="divider"></div>
                <div class="subtitle">
                    <i class="fas fa-globe-africa me-2"></i> Institution Scolaire Bilingue
                </div>
            </div>

            <!-- ===== INFORMATIONS DE L'ÉCOLE ===== -->
            @if ($a_propos_de_nous)
                <section class="school-information" aria-labelledby="school-information-title">
                    <h2 id="school-information-title">
                        <i class="fas fa-school me-2"></i>{{ $a_propos_de_nous->titre ?? 'Notre établissement' }}
                    </h2>
                    @if ($a_propos_de_nous->information)
                        <p>{{ $a_propos_de_nous->information }}</p>
                    @endif
                </section>
            @endif

            <!-- ===== CONTACT ===== -->
            @if ($les_contacts)
                <div class="contact-links">
                    <!-- Téléphone -->
                    <a href="tel:{{ $les_contacts->tel }}" class="phone">
                        <i class="fas fa-phone"></i> {{ $les_contacts->tel }}
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $les_contacts->tel) }}" class="whatsapp"
                        target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>

                    <!-- Email -->
                    <a href="mailto:{{ $les_contacts->couriel }}" class="email">
                        <i class="fas fa-envelope"></i> {{ $les_contacts->couriel }}
                    </a>

                    <!-- Adresse -->
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $les_contacts->latitude }},{{ $les_contacts->longitude }}"
                        target="_blank" class="location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ Str::limit($les_contacts->adresse, 30) }}
                    </a>
                </div>
            @else
                <div class="text-center text-light opacity-50 py-3">
                    <i class="fas fa-info-circle me-2"></i> Aucun contact disponible
                </div>
            @endif

            <!-- ===== NAVIGATION ===== -->
            @if (Route::has('login'))
                <div class="nav-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-chart-pie me-2"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light">
                            <i class="fas fa-sign-in-alt me-2"></i> Connexion
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-light">
                                <i class="fas fa-user-plus me-2"></i> Inscription
                            </a>
                        @endif

                        <a href="{{ route('form_login_enseignant') }}" class="btn btn-info">
                            <i class="fas fa-chalkboard-teacher me-2"></i> Enseignant
                        </a>

                        @if (Route::has('register_enseigannt'))
                            <a href="{{ route('register_enseigannt') }}" class="btn btn-info">
                                <i class="fas fa-user-graduate me-2"></i> Rejoindre
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- ===== PIED DE PAGE ===== -->
            <footer class="site-footer">
                @if ($les_contacts)
                    <div class="footer-contact">
                        @if ($les_contacts->tel)
                            <span><i class="fas fa-phone"></i>{{ $les_contacts->tel }}</span>
                        @endif
                        @if ($les_contacts->couriel)
                            <span><i class="fas fa-envelope"></i>{{ $les_contacts->couriel }}</span>
                        @endif
                        @if ($les_contacts->adresse)
                            <span><i class="fas fa-map-marker-alt"></i>{{ $les_contacts->adresse }}</span>
                        @endif
                    </div>
                @endif
                <p class="copyright">
                    <i class="far fa-copyright me-1"></i>{{ date('Y') }} DAF ACADEMY - Tous droits réservés
                </p>
            </footer>

        </div>

    </body>

</html>
