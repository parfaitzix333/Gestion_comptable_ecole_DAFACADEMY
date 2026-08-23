<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description"
            content="Plateforme de l'Institut Supérieur Professionnel - Gestion des notes et résultats">
        <meta name="author" content="ISP">
        <title>ISP - Institut Supérieur Professionnel</title>

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Google Fonts -->
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
            rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            :root {
                --primary-color: #091c72;
                --primary-dark: #200364;
                --secondary-color: #071c63;
                --success-color: #06c270;
                --danger-color: #ff3b3b;
                --warning-color: #ffb700;
                --dark: #1a1a2e;
                --light: #f8f9fa;
                --gray: #6c757d;
                --gradient-primary: linear-gradient(135deg, #05124d 0%, #040250 100%);
                --gradient-danger: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            /* Container principal */
            .access-container {
                max-width: 500px;
                width: 100%;
                margin: 0 auto;
            }

            /* Carte principale */
            .access-card {
                background: white;
                border-radius: 30px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                transform: translateY(0);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .access-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
            }

            /* En-tête */
            .card-header-custom {
                background: var(--gradient-primary);
                padding: 30px;
                text-align: center;
                position: relative;
            }

            .logo-wrapper {
                display: inline-block;
                margin-bottom: 15px;
            }

            .logo {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 20px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
                transition: transform 0.3s ease;
            }

            .logo:hover {
                transform: scale(1.05);
            }

            .institution-name {
                color: white;
                font-size: 2rem;
                font-weight: 800;
                margin: 0;
                letter-spacing: -0.5px;
            }

            .institution-subtitle {
                color: rgba(255, 255, 255, 0.9);
                font-size: 0.9rem;
                margin: 5px 0 0;
                font-weight: 500;
            }

            /* Bouton déconnexion */
            .logout-btn {
                position: absolute;
                top: 20px;
                right: 20px;
                background: rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(10px);
                border: none;
                color: white;
                padding: 10px 20px;
                border-radius: 50px;
                font-weight: 600;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .logout-btn:hover {
                background: var(--gradient-danger);
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
            }

            /* Corps de la carte */
            .card-body-custom {
                padding: 40px 30px;
                text-align: center;
            }

            .welcome-icon {
                width: 70px;
                height: 70px;
                background: linear-gradient(135deg, #011053 0%, #03014d 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px;
            }

            .welcome-icon i {
                font-size: 2rem;
                color: white;
            }

            .welcome-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--dark);
                margin-bottom: 15px;
            }

            .welcome-message {
                color: var(--gray);
                line-height: 1.6;
                margin-bottom: 25px;
            }

            /* Message d'alerte */
            .alert-message {
                background: #fff3cd;
                border-left: 4px solid var(--warning-color);
                padding: 15px 20px;
                border-radius: 12px;
                text-align: left;
                margin-top: 20px;
            }

            .alert-message i {
                color: var(--warning-color);
                margin-right: 10px;
            }

            .alert-message p {
                margin: 0;
                font-size: 0.9rem;
                color: #856404;
            }

            /* Footer */
            .card-footer {
                background: var(--light);
                padding: 20px;
                text-align: center;
                border-top: 1px solid #e9ecef;
            }

            .footer-text {
                font-size: 0.8rem;
                color: var(--gray);
                margin: 0;
            }

            .footer-text a {
                color: var(--primary-color);
                text-decoration: none;
            }

            .footer-text a:hover {
                text-decoration: underline;
            }

            /* Animations */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .access-card {
                animation: fadeInUp 0.6s ease-out;
            }

            /* Responsive */
            @media (max-width: 576px) {
                .card-header-custom {
                    padding: 20px;
                }

                .logo {
                    width: 60px;
                    height: 60px;
                }

                .institution-name {
                    font-size: 1.5rem;
                }

                .card-body-custom {
                    padding: 30px 20px;
                }

                .logout-btn {
                    padding: 6px 12px;
                    font-size: 0.8rem;
                }

                .logout-btn span {
                    display: none;
                }

                .logout-btn i {
                    margin: 0;
                }
            }
        </style>
    </head>

    <body>
        <div class="access-container">
            <div class="access-card">
                <!-- En-tête -->
                <div class="card-header-custom">
                    <form action="{{ route('logout') }}" method="post" id="logoutForm">
                        @csrf
                        <button type="submit" class="logout-btn" onclick="return confirmLogout(event)">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>

                    <div class="logo-wrapper">
                        <img src="{{ asset('image/logo.jpeg') }}" alt="Logo DAF ACADEMY" class="logo">
                    </div>
                    <h1 class="institution-name">DAF ACADEMY</h1>
                    <p class="institution-subtitle">Institut Scolaire bilingue</p>
                </div>

                <!-- Corps -->
                <div class="card-body-custom">
                    <div class="welcome-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>

                    <h2 class="welcome-title">
                        <i class="fas fa-hand-peace me-2"></i>Bienvenue
                    </h2>

                    <p class="welcome-message">
                        Sur la plateforme de DAF ACADEMY, vous pouvez gérer vos notes et résultats académiques de manière efficace et sécurisée.
                    </p>

                    <!-- Message d'information -->
                    <div class="alert-message">
                        <i class="fas fa-info-circle"></i>
                        <strong>Information importante :</strong>
                        <p class="mt-2 mb-0">
                            Déconnectez-vous et reconnectez-vous pour accéder à votre profil.
                            Si vous retombez sur cette page, veuillez contacter votre administrateur
                            pour résoudre le problème.
                        </p>
                    </div>

                    <!-- Conseils supplémentaires -->
                    <div class="row mt-4 g-2">
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3">
                                <i class="fas fa-envelope text-primary me-1"></i>
                                <small>support@isp.edu</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3">
                                <i class="fas fa-phone-alt text-primary me-1"></i>
                                <small></small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer">
                    <p class="footer-text">
                        &copy; {{ date('Y') }} DAF ACADEMY - Tous droits réservés
                    </p>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- SweetAlert pour une meilleure confirmation -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Confirmation de déconnexion avec SweetAlert
            function confirmLogout(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Déconnexion',
                    text: 'Voulez-vous vraiment vous déconnecter ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Oui, me déconnecter',
                    cancelButtonText: 'Annuler',
                    backdrop: true,
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Afficher un message de chargement
                        Swal.fire({
                            title: 'Déconnexion en cours...',
                            text: 'Veuillez patienter',
                            icon: 'info',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Soumettre le formulaire
                        document.getElementById('logoutForm').submit();
                    }
                });

                return false;
            }

            // Animation supplémentaire au chargement
            document.addEventListener('DOMContentLoaded', function() {
                // Ajouter une classe d'animation aux éléments
                const elements = document.querySelectorAll(
                    '.welcome-icon, .welcome-title, .welcome-message, .alert-message');
                elements.forEach((el, index) => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        el.style.transition = 'all 0.5s ease';
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    }, 100 + (index * 100));
                });
            });
        </script>
    </body>

</html>
