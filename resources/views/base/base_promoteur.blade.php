<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DAF-ACADEMY</title>
        <link rel="icon" href="{{ asset('image/logo.jpeg') }}" type="image/jpeg">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

        <style>
            /* ============================================
               STYLES GÉNÉRAUX
               ============================================ */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f4f6f9;
                overflow-x: auto;
            }

            body.sidebar-open {
                overflow: hidden;
            }

            /* ============================================
               STYLES DES TABLEAUX - CORRECTION
               ============================================ */

            /* Conteneur du tableau avec overflow-x auto */
            .table-wrapper {
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                margin-bottom: 1rem;
                position: relative;
            }

            /* Scrollbar personnalisée */
            .table-wrapper::-webkit-scrollbar {
                height: 8px;
            }

            .table-wrapper::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }

            .table-wrapper::-webkit-scrollbar-thumb {
                background: #c1c7cd;
                border-radius: 4px;
            }

            .table-wrapper::-webkit-scrollbar-thumb:hover {
                background: #a0a7ae;
            }

            /* Tableau - garde toujours sa structure */
            .table table-striped {
                width: 100%;
                border-collapse: collapse;
                margin: 0;
                table-layout: fixed;
                /* Fixe la largeur des colonnes */
            }

            /* Pour les tableaux avec beaucoup de colonnes */
            .table table-striped.wide {
                min-width: 900px;
            }

            .table table-striped.medium {
                min-width: 700px;
            }

            /* Style des cellules */
            .table table-striped thead th {
                padding: 1rem 1.5rem;
                color: white;
                font-weight: 600;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border: none;
                white-space: nowrap;
                background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .table table-striped tbody td {
                padding: 1rem 1.5rem;
                font-size: 0.875rem;
                color: #374151;
                vertical-align: middle;
                word-wrap: break-word;
            }

            .table table-striped tbody tr {
                transition: all 0.2s ease;
                border-bottom: 1px solid #f3f4f6;
            }

            .table table-striped tbody tr:hover {
                background: #f8fafc;
            }

            /* ============================================
               EN-TÊTE
               ============================================ */
            .header {
                background: linear-gradient(135deg, #032e5a 0%, #0a4b7a 100%);
                padding: 10px 20px;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
                display: flex;
                align-items: center;
                justify-content: space-between;
                height: 80px;
                gap: 10px;
            }

            .header-left {
                display: flex;
                align-items: center;
                gap: 12px;
                flex-shrink: 0;
            }

            .header-center {
                display: flex;
                align-items: center;
                justify-content: center;
                flex: 1;
                min-width: 0;
                padding: 0 10px;
            }

            .header-right {
                display: flex;
                align-items: center;
                gap: 15px;
                flex-shrink: 0;
            }

            .header-right .user-info {
                color: white;
                font-size: 0.85rem;
                white-space: nowrap;
                text-align: right;
                line-height: 1.3;
            }

            .header-right .user-info i {
                margin-right: 6px;
            }

            .header-right .user-info .role-badge {
                font-size: 0.65rem;
                padding: 2px 10px;
                border-radius: 20px;
                background: rgba(255, 255, 255, 0.15);
                color: #ffc107;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .logo-image {
                width: 55px;
                height: 55px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid white;
                transition: transform 0.3s ease;
                flex-shrink: 0;
            }

            .logo-image:hover {
                transform: scale(1.05);
            }

            .header-title {
                color: white;
                line-height: 1.2;
                min-width: 0;
            }

            .header-title h1 {
                font-size: 1.3rem;
                font-weight: 700;
                margin: 0;
                letter-spacing: 1px;
                white-space: nowrap;
            }

            .header-title h2 {
                font-size: 0.75rem;
                font-weight: 300;
                margin: 0;
                opacity: 0.8;
                letter-spacing: 0.5px;
                white-space: nowrap;
            }

            /* ============================================
               SÉLECTEUR ANNÉE SCOLAIRE
               ============================================ */
            .annee-selector {
                display: flex;
                align-items: center;
                gap: 8px;
                background: rgba(255, 255, 255, 0.1);
                padding: 4px 12px 4px 16px;
                border-radius: 30px;
                border: 1px solid rgba(255, 255, 255, 0.15);
                transition: all 0.3s ease;
                max-width: 280px;
                min-width: 160px;
            }

            .annee-selector:hover {
                background: rgba(255, 255, 255, 0.18);
                border-color: rgba(255, 255, 255, 0.25);
            }

            .annee-selector .annee-label {
                color: rgba(255, 255, 255, 0.7);
                font-size: 0.7rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                white-space: nowrap;
            }

            .annee-selector .annee-label i {
                margin-right: 4px;
            }

            .annee-selector select {
                background: transparent;
                border: none;
                color: white;
                font-size: 0.85rem;
                font-weight: 500;
                padding: 6px 4px;
                cursor: pointer;
                outline: none;
                min-width: 110px;
                max-width: 180px;
            }

            .annee-selector select option {
                background: #032e5a;
                color: white;
                padding: 8px;
            }

            .annee-selector select:focus {
                box-shadow: none;
            }

            .annee-selector .select-arrow {
                color: rgba(255, 255, 255, 0.5);
                font-size: 0.7rem;
                pointer-events: none;
            }

            /* ============================================
               BOUTON TOGGLE
               ============================================ */
            .toggle-btn {
                background: rgba(255, 255, 255, 0.15);
                border: 2px solid rgba(255, 255, 255, 0.25);
                color: white;
                padding: 6px 14px;
                border-radius: 8px;
                cursor: pointer;
                font-size: 1.2rem;
                transition: all 0.3s ease;
                display: none;
                flex-shrink: 0;
                margin-left: 5px;
            }

            .toggle-btn:hover {
                background: rgba(255, 255, 255, 0.25);
                transform: scale(1.05);
            }

            /* ============================================
               SIDEBAR
               ============================================ */
            .sidebar {
                position: fixed;
                top: 80px;
                left: 0;
                bottom: 0;
                width: 250px;
                background: linear-gradient(180deg, #032e5a 0%, #062a4a 100%);
                padding: 20px 0;
                overflow-y: auto;
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 999;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
            }

            .sidebar::-webkit-scrollbar {
                width: 5px;
            }

            .sidebar::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.05);
            }

            .sidebar::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.2);
                border-radius: 10px;
            }

            .sidebar::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.3);
            }

            .sidebar .nav-item {
                display: block;
                padding: 12px 25px;
                color: rgba(255, 255, 255, 0.7);
                text-decoration: none;
                transition: all 0.3s ease;
                border-left: 3px solid transparent;
                font-size: 0.95rem;
                font-weight: 500;
                position: relative;
            }

            .sidebar .nav-item:hover {
                background: rgba(255, 255, 255, 0.08);
                color: white;
                border-left-color: #ffc107;
                padding-left: 30px;
            }

            .sidebar .nav-item.active {
                background: rgba(172, 2, 2, 0.575);
                color: white;
                border-left-color: #ffc107;
            }

            .sidebar .nav-item i {
                width: 25px;
                margin-right: 10px;
                font-size: 1.1rem;
                text-align: center;
            }

            .sidebar .nav-item .badge {
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
            }

            .sidebar .nav-divider {
                height: 1px;
                background: rgba(255, 255, 255, 0.1);
                margin: 10px 20px;
            }

            .sidebar .logout-btn {
                margin: 15px 20px;
                width: calc(100% - 40px);
                padding: 10px;
                border-radius: 8px;
                border: none;
                background: linear-gradient(135deg, #dc3545, #b02a37);
                color: white;
                font-weight: 600;
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .sidebar .logout-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
            }

            .sidebar .logout-btn i {
                margin-right: 8px;
            }

            /* ============================================
               CONTENU PRINCIPAL
               ============================================ */
            .main-content {
                margin-left: 250px;
                margin-top: 80px;
                padding: 25px 30px;
                min-height: calc(100vh - 80px);
                transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                background: #f4f6f9;
            }

            /* ============================================
               OVERLAY
               ============================================ */
            .sidebar-overlay {
                position: fixed;
                top: 80px;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 998;
                display: none;
                animation: fadeIn 0.3s ease;
            }

            .sidebar-overlay.active {
                display: block;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            /* ============================================
               RESPONSIVE - CORRECTION DES TABLEAUX
               ============================================ */

            @media (max-width: 992px) {
                .toggle-btn {
                    display: block;
                }

                .sidebar {
                    transform: translateX(-100%);
                }

                .sidebar.open {
                    transform: translateX(0);
                }

                .main-content {
                    margin-left: 0;
                    padding: 20px;
                }

                .header-title h1 {
                    font-size: 1.1rem;
                }

                .header-title h2 {
                    font-size: 0.65rem;
                }

                .logo-image {
                    width: 45px;
                    height: 45px;
                }

                .header-right .user-info {
                    font-size: 0.75rem;
                }

                .annee-selector {
                    padding: 3px 10px 3px 14px;
                    min-width: 130px;
                    max-width: 200px;
                }

                .annee-selector select {
                    font-size: 0.75rem;
                    min-width: 90px;
                    max-width: 140px;
                }

                .annee-selector .annee-label {
                    font-size: 0.6rem;
                }

                /* Tableaux restent en mode tableau avec scroll */
                .table-wrapper {
                    margin: 0 -0.5rem;
                    padding: 0 0.5rem;
                }

                .table table-striped {
                    min-width: 700px;
                    table-layout: fixed;
                }

                .table table-striped.wide {
                    min-width: 900px;
                }

                .table table-striped.medium {
                    min-width: 700px;
                }

                .table table-striped thead th,
                .table table-striped tbody td {
                    padding: 0.75rem 1rem;
                    font-size: 0.8rem;
                }
            }

            @media (max-width: 768px) {
                .header {
                    height: 70px;
                    padding: 8px 12px;
                    gap: 5px;
                }

                .label_profil {
                    display: none;
                }

                .header-center {
                    padding: 0 5px;
                }

                .annee-selector {
                    padding: 2px 8px 2px 12px;
                    min-width: 100px;
                    max-width: 160px;
                    border-radius: 20px;
                }

                .annee-selector .annee-label {
                    display: none;
                }

                .annee-selector select {
                    font-size: 0.7rem;
                    min-width: 80px;
                    max-width: 120px;
                    padding: 4px 2px;
                }

                .annee-selector .select-arrow {
                    font-size: 0.6rem;
                }

                .logo-image {
                    width: 38px;
                    height: 38px;
                }

                .header-title h1 {
                    font-size: 0.9rem;
                }

                .header-title h2 {
                    display: none;
                }

                .header-right .user-info {
                    font-size: 0.65rem;
                }

                .header-right .user-info .role-badge {
                    font-size: 0.55rem;
                    padding: 1px 8px;
                }

                .sidebar {
                    top: 70px;
                    width: 280px;
                }

                .sidebar-overlay {
                    top: 70px;
                }

                .main-content {
                    margin-top: 70px;
                    padding: 15px;
                    padding-bottom: 80px;
                }

                .toggle-btn {
                    padding: 5px 10px;
                    font-size: 1rem;
                }

                /* Tableaux restent en mode tableau avec scroll */
                .table-wrapper {
                    margin: 0 -0.5rem;
                    padding: 0 0.5rem;
                }

                .table table-striped {
                    min-width: 650px;
                    table-layout: fixed;
                }

                .table table-striped.wide {
                    min-width: 850px;
                }

                .table table-striped.medium {
                    min-width: 650px;
                }

                .table table-striped thead th,
                .table table-striped tbody td {
                    padding: 0.6rem 0.8rem;
                    font-size: 0.75rem;
                }
            }

            @media (max-width: 480px) {
                .header {
                    height: 60px;
                    padding: 6px 8px;
                }

                .label_profil {
                    display: none;
                }

                .header-title h1 {
                    font-size: 0.75rem;
                }

                .logo-image {
                    width: 32px;
                    height: 32px;
                }

                .header-right .user-info {
                    font-size: 0.6rem;
                }

                .header-right .user-info .role-badge {
                    font-size: 0.5rem;
                    padding: 1px 6px;
                }

                .header-right .user-info span:not(.role-badge) {
                    display: none;
                }

                .header-center {
                    padding: 0 3px;
                }

                .annee-selector {
                    padding: 2px 6px 2px 8px;
                    min-width: 80px;
                    max-width: 120px;
                    border-radius: 15px;
                    border-width: 1px;
                }

                .annee-selector select {
                    font-size: 0.6rem;
                    min-width: 60px;
                    max-width: 90px;
                    padding: 3px 2px;
                }

                .annee-selector .select-arrow {
                    display: none;
                }

                .sidebar {
                    top: 60px;
                    width: 280px;
                }

                .sidebar-overlay {
                    top: 60px;
                }

                .main-content {
                    margin-top: 60px;
                    padding: 10px;
                    padding-bottom: 70px;
                }

                .toggle-btn {
                    padding: 4px 8px;
                    font-size: 0.85rem;
                }

                /* Tableaux restent en mode tableau avec scroll */
                .table-wrapper {
                    margin: 0 -0.25rem;
                    padding: 0 0.25rem;
                }

                .table table-striped {
                    min-width: 500px;
                    table-layout: fixed;
                }

                .table table-striped.wide {
                    min-width: 700px;
                }

                .table table-striped.medium {
                    min-width: 500px;
                }

                .table table-striped thead th,
                .table table-striped tbody td {
                    padding: 0.4rem 0.6rem;
                    font-size: 0.7rem;
                    overflow: auto;
                }

                /* Réduire la taille des badges dans les tableaux */
                .table table-striped .badge,
                .table table-striped .status-badge,
                .table table-striped .role-badge {
                    font-size: 0.6rem !important;
                    padding: 0.15rem 0.4rem !important;
                }
            }

            @media (max-width: 380px) {
                .header-title h1 {
                    font-size: 0.65rem;
                }

                .label_profil {
                    display: none;
                }

                .logo-image {
                    width: 28px;
                    height: 28px;
                }

                .annee-selector {
                    min-width: 65px;
                    max-width: 90px;
                    padding: 2px 4px 2px 6px;
                }

                .annee-selector select {
                    font-size: 0.55rem;
                    min-width: 50px;
                    max-width: 70px;
                    padding: 2px 1px;
                }

                .table table-striped {
                    min-width: 400px;
                    table-layout: fixed;
                }

                .table table-striped thead th,
                .table table-striped tbody td {
                    padding: 0.3rem 0.4rem;
                    font-size: 0.65rem;
                }
            }
        </style>
    </head>

    <body>

        <!-- ============================================
    EN-TÊTE
    ============================================ -->
        <header class="header">
            <!-- Gauche : Logo + Titre -->
            <div class="header-left">
                <img src="{{ asset('image/logo.jpeg') }}" alt="Logo DAF ACADEMY" class="logo-image">
                <div class="header-title">
                    <h1>DAF ACADEMY</h1>
                    <h2>INSTITUTION SCOLAIRE BILINGUE</h2>
                </div>
            </div>
            @include('layouts.alerts')

            <!-- Centre : Sélecteur Année Scolaire -->
            <div class="header-center">
                @php
                    $les_annees_scolaires = \App\Models\Annee_scolaire::orderBy('annee', 'desc')->get();
                    $currentUser = Auth::user();
                    $selectedAnneeId = $currentUser ? $currentUser->annee_scolaire_id : null;
                @endphp

                @if ($les_annees_scolaires->count() > 0)
                    <form action="{{ route('switcher_annee_scolaire') }}" method="POST" class="annee-selector">
                        @csrf
                        @method('PUT')
                        <span class="annee-label">
                            <i class="fas fa-calendar-alt"></i> Année
                        </span>
                        <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select form-select-sm"
                            onchange="this.form.submit()" style="min-width:160px;max-width:320px;">
                            <option value="">Sélectionnez</option>
                            @foreach ($les_annees_scolaires as $annee)
                                <option value="{{ $annee->id }}"
                                    {{ $currentUser && $currentUser->anne_scolaire_id == $annee->id ? 'selected' : '' }}>
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

            <!-- Droite : Utilisateur + Toggle -->
            <div class="header-right">
                <span class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ Auth::user()->name ?? 'Invité' }}</span>
                    <br>
                    <span class="role-badge">{{ Auth::user()->role ?? '—' }}</span>
                </span>
                <a href="{{ route('edit_profile_prom') }}" class="btn btn-outline-light btn-sm">
                    <i class="fa fa-edit"></i>
                    <small class="label_profil">Mon
                        Profil</small></a>

                <button class="toggle-btn" id="sidebarToggle" aria-label="Basculer la navigation">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </header>

        <!-- ============================================
    OVERLAY
    ============================================ -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <!-- ==========================
    SIDEBAR
    ============================================ -->
        <nav class="sidebar" id="sidebar">
            <a href="{{ route('profile_promoteur') }}"
                class="nav-item {{ request()->routeIs('profile_promoteur') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Accueil
            </a>
            <a href="{{ route('paiements.index') }}"
                class="nav-item {{ request()->routeIs('paiements.*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> Paiements
            </a>
            <a href="{{ route('eleves.index') }}"
                class="nav-item {{ request()->routeIs('eleves.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i> Élèves
                <span class="badge bg-danger">{{ App\Models\Eleve::count() }}</span>
            </a>
            <a href="{{ route('enseignants.index') }}"
                class="nav-item {{ request()->routeIs('enseignants.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i> Enseignants
                <span class="badge bg-danger">{{ App\Models\Enseignant::count() }}</span>
            </a>
            <a href="{{ route('utilisateurs.index') }}"
                class="nav-item {{ request()->routeIs('utilisateurs.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Utilisateurs
                @php
                    try {
                        $userCount = App\Models\User::count();
                    } catch (\Exception $e) {
                        $userCount = 0;
                    }
                @endphp
                <span class="badge bg-danger">{{ $userCount }}</span>
            </a>

            <div class="nav-divider"></div>

            <a href="{{ route('frais.index') }}" class="nav-item {{ request()->routeIs('frais.*') ? 'active' : '' }}">
                <i class="fas fa-coins"></i> Frais
            </a>
            <a href="{{ route('classes.index') }}"
                class="nav-item {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                <i class="fas fa-school"></i> Classes
                <span class="badge bg-danger">{{ App\Models\Classe::count() }}</span>
            </a>
            <a href="{{ route('sections.index') }}"
                class="nav-item {{ request()->routeIs('sections.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Sections
                <span class="badge bg-danger">{{ App\Models\Section::count() }}</span>
            </a>
            <a href="{{ route('contacts.index') }}"
                class="nav-item {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Contacts
            </a>

            <div class="nav-divider"></div>

            <a href="{{ route('historiques.index') }}"
                class="nav-item {{ request()->routeIs('historiques.*') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Historiques
            </a>
            <a href="{{ route('proprietes.index') }}"
                class="nav-item {{ request()->routeIs('proprietes.*') ? 'active' : '' }}">
                <i class="fas fa-info-circle"></i> À propos
            </a>
            <a href="{{ route('annees.index') }}"
                class="nav-item {{ request()->routeIs('annees.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Années scolaires
            </a>

            <div class="nav-divider"></div>

            <!-- Déconnexion -->
            <form method="POST" action="{{ route('logout') }}"
                onsubmit="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </nav>

        <!-- ============================================
    CONTENU PRINCIPAL
    ============================================ -->
        <main class="main-content" id="mainContent">
            @yield('content')
        </main>
        <!-- ============================================
    SCRIPTS
    ============================================ -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ==== Sidebar ====
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const toggleBtn = document.getElementById('sidebarToggle');

                function toggleSidebar() {
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('active');
                    toggleBtn.classList.toggle('active');
                    document.body.classList.toggle('sidebar-open');
                }

                function closeSidebar() {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                    toggleBtn.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                }

                if (toggleBtn) {
                    toggleBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        toggleSidebar();
                    });
                }

                if (overlay) {
                    overlay.addEventListener('click', function() {
                        closeSidebar();
                    });
                }

                document.querySelectorAll('.nav-item').forEach(function(item) {
                    item.addEventListener('click', function() {
                        if (window.innerWidth <= 992) {
                            closeSidebar();
                        }
                        document.querySelectorAll('.nav-item').forEach(function(el) {
                            el.classList.remove('active');
                        });
                        this.classList.add('active');
                    });
                });

                let resizeTimer;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {
                        if (window.innerWidth > 992) {
                            closeSidebar();
                        }
                    }, 250);
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeSidebar();
                    }
                });

                if (window.innerWidth <= 992) {
                    closeSidebar();
                }

                console.log('✅ Sidebar prêt !');
            });
        </script>

        @stack('scripts')

    </body>

</html>
