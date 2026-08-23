<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>DAF-ACADEMY | Comptabilité</title>

        <link rel="icon" href="{{ asset('image/logo.jpeg') }}" type="image/jpeg">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

        <style>
            /* =========================================================
           RESET / BASE
        ========================================================= */

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            html,
            body {
                min-height: 100%;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: #f4f6f9;
                color: #1f2937;
                overflow-x: hidden;
            }


            /* =========================================================
           HEADER
        ========================================================= */

            .header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;

                height: 80px;

                z-index: 1000;

                display: flex;
                align-items: center;

                padding: 10px 20px;

                background: linear-gradient(135deg,
                        #032e5a 0%,
                        #0a4b7a 100%);

                color: white;

                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);

                gap: 20px;
            }


            /* =========================================================
           HEADER LEFT
        ========================================================= */

            .header-left {
                display: flex;
                align-items: center;
                gap: 12px;

                flex-shrink: 0;
            }

            .logo-image {
                width: 55px;
                height: 55px;

                object-fit: cover;

                border: 2px solid white;
                border-radius: 50%;

                flex-shrink: 0;

                transition: transform 0.3s ease;
            }

            .logo-image:hover {
                transform: scale(1.05);
            }

            .header-title {
                line-height: 1.15;
            }

            .header-title h1 {
                margin: 0;

                font-size: 1.25rem;
                font-weight: 700;

                letter-spacing: 1px;

                white-space: nowrap;
            }

            .header-title h2 {
                margin: 3px 0 0;

                font-size: 0.7rem;
                font-weight: 300;

                opacity: 0.8;

                white-space: nowrap;
            }

            .department {
                display: inline-flex;
                align-items: center;

                margin-left: 8px;
                padding: 5px 10px;

                border-left: 1px solid rgba(255, 255, 255, 0.3);

                color: #ffc107;

                font-size: 0.8rem;
                font-weight: 700;

                white-space: nowrap;
            }

            .department i {
                margin-right: 5px;
            }


            /* =========================================================
           HEADER CENTER
        ========================================================= */

            .header-center {
                flex: 1;

                display: flex;
                justify-content: center;
                align-items: center;

                min-width: 0;
            }

            .annee-selector {
                display: flex;
                align-items: center;
                gap: 8px;

                padding: 4px 12px 4px 15px;

                min-width: 180px;
                max-width: 300px;

                background: rgba(255, 255, 255, 0.1);

                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 30px;

                transition: all 0.3s ease;
            }

            .annee-selector:hover {
                background: rgba(255, 255, 255, 0.16);
            }

            .annee-label {
                color: rgba(255, 255, 255, 0.75);

                font-size: 0.7rem;
                font-weight: 600;

                white-space: nowrap;

                text-transform: uppercase;
            }

            .annee-label i {
                margin-right: 4px;
            }

            .annee-selector select {
                min-width: 110px;

                background: transparent !important;
                border: none !important;

                color: white !important;

                font-size: 0.85rem;
                font-weight: 500;

                outline: none;

                box-shadow: none !important;
            }

            .annee-selector select option {
                background: #032e5a;
                color: white;
            }

            .select-arrow {
                color: rgba(255, 255, 255, 0.5);
                font-size: 0.7rem;
            }


            /* =========================================================
           HEADER RIGHT
        ========================================================= */

            .header-right {
                display: flex;
                align-items: center;
                gap: 12px;

                flex-shrink: 0;
            }

            .user-info {
                color: white;

                text-align: right;

                font-size: 0.8rem;
                line-height: 1.3;

                white-space: nowrap;
            }

            .user-info i {
                margin-right: 4px;
            }

            .role-badge {
                display: inline-block;

                margin-top: 2px;
                padding: 2px 9px;

                background: rgba(255, 255, 255, 0.15);

                border-radius: 20px;

                color: #ffc107;

                font-size: 0.6rem;
                font-weight: 700;

                text-transform: uppercase;
            }


            /* =========================================================
           NAVIGATION
        ========================================================= */

            .main-nav {
                position: fixed;

                top: 80px;
                left: 0;
                right: 0;

                z-index: 999;

                display: flex;
                align-items: center;
                justify-content: center;

                gap: 5px;

                min-height: 52px;

                padding: 5px 15px;

                background: #dfbdc0;

                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            }

            .main-nav .nav-item {
                position: relative;

                display: inline-flex;
                align-items: center;
                gap: 7px;

                padding: 9px 15px;

                color: rgba(255, 255, 255, 0.75);

                text-decoration: none;

                font-size: 0.85rem;
                font-weight: 500;

                border-radius: 7px;

                transition: all 0.25s ease;
                background: #01086d;
            }

            .main-nav .nav-item i {
                font-size: 0.9rem;
            }

            .main-nav .nav-item:hover {
                background: rgba(58, 61, 219, 0.973);
                color: white;
            }

            .main-nav .nav-item.active {
                background: #ac0202;
                color: white;
            }

            .main-nav .badge {
                position: absolute;

                top: 2px;
                right: 2px;

                font-size: 0.55rem;
            }


            /* =========================================================
           CONTENU PRINCIPAL
        ========================================================= */

            .main-content {
                min-height: calc(100vh - 132px);

                margin-top: 132px;

                padding: 25px 30px;

                background: #f4f6f9;
            }


            /* =========================================================
           FOOTER
        ========================================================= */

            .main-footer {
                padding: 18px 15px;

                background: #062a4a;

                color: rgba(255, 255, 255, 0.8);

                text-align: center;

                font-size: 0.8rem;
            }

            .main-footer strong {
                color: white;
            }

            .main-footer .developers {
                margin-top: 5px;

                color: rgba(255, 255, 255, 0.55);

                font-size: 0.7rem;
            }

            .main-footer .developers i {
                color: #ffc107;
            }


            /* =========================================================
           TABLEAUX RESPONSIVE
        ========================================================= */

            .table-wrapper {
                width: 100%;
                max-width: 100%;

                overflow-x: auto;
                overflow-y: hidden;

                -webkit-overflow-scrolling: touch;
            }

            .table-wrapper table {
                min-width: 700px;
            }


            /* =========================================================
           RESPONSIVE TABLETTE
        ========================================================= */

            @media (max-width: 992px) {

                .header {
                    height: 75px;
                    padding: 8px 15px;
                }

                .header-title h1 {
                    font-size: 1rem;
                }

                .header-title h2 {
                    font-size: 0.6rem;
                }

                .department {
                    font-size: 0.7rem;
                }

                .main-nav {
                    top: 75px;

                    justify-content: flex-start;

                    overflow-x: auto;

                    white-space: nowrap;

                    scrollbar-width: none;
                }

                .main-nav::-webkit-scrollbar {
                    display: none;
                }

                .main-content {
                    margin-top: 127px;
                    padding: 20px;
                }

                .annee-label {
                    display: none;
                }

                .annee-selector {
                    min-width: 140px;
                }
            }


            /* =========================================================
           RESPONSIVE MOBILE
        ========================================================= */

            @media (max-width: 768px) {

                .header {
                    height: 65px;

                    padding: 6px 10px;

                    gap: 8px;
                }

                .logo-image {
                    width: 42px;
                    height: 42px;
                }

                .header-title h1 {
                    font-size: 0.85rem;
                }

                .header-title h2 {
                    display: none;
                }

                .department {
                    display: none;
                }

                .header-center {
                    justify-content: flex-end;
                }

                .annee-selector {
                    min-width: 100px;
                    max-width: 130px;

                    padding: 2px 7px;
                }

                .annee-selector select {
                    min-width: 70px;

                    font-size: 0.65rem;
                }

                .user-info {
                    display: none;
                }

                .main-nav {
                    top: 65px;

                    min-height: 48px;

                    justify-content: flex-start;

                    padding: 4px 8px;
                }

                .main-nav .nav-item {
                    padding: 8px 11px;

                    font-size: 0.72rem;
                }

                .main-content {
                    margin-top: 113px;

                    padding: 15px 10px;
                }

                .main-footer {
                    font-size: 0.7rem;
                }
            }


            /* =========================================================
           PETITS TÉLÉPHONES
        ========================================================= */

            @media (max-width: 480px) {

                .header {
                    height: 60px;
                }

                .logo-image {
                    width: 35px;
                    height: 35px;
                }

                .header-title h1 {
                    font-size: 0.72rem;
                }

                .annee-selector {
                    min-width: 80px;
                    max-width: 100px;
                }

                .annee-selector select {
                    min-width: 55px;
                    font-size: 0.58rem;
                }

                .select-arrow {
                    display: none;
                }

                .main-nav {
                    top: 60px;
                }

                .main-content {
                    margin-top: 108px;
                    padding: 10px;
                }

                .main-nav .nav-item {
                    padding: 7px 9px;

                    font-size: 0.65rem;
                }
            }
        </style>
    </head>


    <body>
        @include('layouts.alerts')

        <!-- =========================================================
         HEADER
    ========================================================== -->

        <header class="header">

            <!-- Logo + identité -->
            <div class="header-left">

                <img src="{{ asset('image/logo.jpeg') }}" alt="Logo DAF ACADEMY" class="logo-image">

                <div class="header-title">
                    <h1>DAF ACADEMY</h1>
                    <h2>INSTITUTION SCOLAIRE BILINGUE</h2>
                </div>

                <div class="department">
                    <i class="fas fa-calculator"></i>
                    Enseignement
                </div>

            </div>


            <!-- Sélecteur année scolaire -->
            <div class="header-center">

                @php
                    $les_annees_scolaires = \App\Models\Annee_scolaire::orderBy('annee', 'desc')->get();

                    $currentUser = Auth::user();

                    $selectedAnneeId = $currentUser ? $currentUser->anne_scolaire_id : null;
                @endphp

                @if ($les_annees_scolaires->count() > 0)

                    <form action="{{ route('switcher_annee_scolaire') }}" method="POST" class="annee-selector p-0">

                        @csrf
                        @method('PUT')

                        <span class="annee-label">
                            <i class="fas fa-calendar-alt"></i>
                            Année
                        </span>

                        <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select form-select-sm"
                            onchange="this.form.submit()">

                            <option value="">
                                Sélectionnez
                            </option>

                            @foreach ($les_annees_scolaires as $annee)
                                <option value="{{ $annee->id }}"
                                    {{ $selectedAnneeId == $annee->id ? 'selected' : '' }}>

                                    {{ $annee->annee }}

                                </option>
                            @endforeach

                        </select>

                        <span class="select-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </span>

                    </form>
                @else
                    <span class="text-white-50 small">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Aucune année scolaire
                    </span>

                @endif

            </div>


            <!-- Utilisateur -->
            <div class="header-right">

                <div class="user-info">

                    <div>
                        <i class="fas fa-user-circle"></i>

                        {{ Auth::user()->name ?? 'Invité' }}
                    </div>

                    <span class="role-badge">
                        {{ Auth::user()->role ?? '—' }}
                    </span>

                </div>

            </div>

        </header>

        <!-- =========================================================
         NAVIGATION
    ========================================================== -->

        <nav class="main-nav">

            <a href="{{ route('profile_enseignant') }}"
                class="nav-item {{ request()->routeIs('profile_enseignant') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </a>


            <a href="{{ route('les_paiements_enseignant') }}"
                class="nav-item {{ request()->routeIs('les_paiements_enseignant') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                <span>Paiements</span>
            </a>

            <a href="{{ route('les_eleve_enseignant') }}"
                class="nav-item {{ request()->routeIs('les_eleve_enseignant') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i>
                <span>Mes Élèves</span>
            </a>

            <a href="{{ route('edit_profile_ens') }}"
                class="nav-item {{ request()->routeIs('edit_profile_ens') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i>
                <span>Mon Profile</span>
            </a>
            <form method="POST" action="{{ route('logout') }}"
                onsubmit="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>

        </nav>


        <!-- =========================================================
         CONTENU
    ========================================================== -->

        <main class="main-content" id="mainContent">

            @yield('content')

        </main>

        <footer class="main-footer">

            <div>
                &copy; {{ date('Y') }}
                <strong>DAF ACADEMY</strong>.
                Tous droits réservés.
            </div>

            <div class="developers">
                <i>
                    Équipe de développement :
                    Patrick Lufungula &amp; Guelord Numbi
                </i>
            </div>

        </footer>


        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        @stack('scripts')

    </body>

</html>
