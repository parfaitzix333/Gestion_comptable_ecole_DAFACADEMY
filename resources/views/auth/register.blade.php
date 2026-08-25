<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>DAF|ACADEMY</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                min-height: 100vh;
                background: linear-gradient(135deg, #d3d3d3 0%, #ebebf0 100%);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .login-container {
                width: 100%;
                max-width: 500px;
            }

            .login-card {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                animation: fadeInUp 0.5s ease-out;
            }

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

            .login-header {
                background: linear-gradient(135deg, #011050 0%, #021b6d 100%);
                padding: 40px 30px;
                text-align: center;
                color: white;
            }

            .login-header h1 {
                font-size: 2rem;
                margin-bottom: 10px;
                font-weight: 600;
            }

            .login-header p {
                opacity: 0.9;
                margin: 0;
                font-size: 0.9rem;
            }

            .login-icon {
                width: 80px;
                height: 80px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px;
            }

            .login-icon i {
                font-size: 40px;
            }

            .login-body {
                padding: 40px 30px;
            }

            .form-group {
                margin-bottom: 25px;
            }

            .form-label {
                font-weight: 500;
                color: #333;
                margin-bottom: 8px;
                display: block;
            }

            .input-group-custom {
                position: relative;
                display: flex;
                align-items: center;
            }

            .input-group-custom .input-icon {
                position: absolute;
                left: 15px;
                color: #aaa;
                z-index: 10;
                pointer-events: none;
            }

            .form-control-custom {
                width: 100%;
                padding: 12px 45px 12px 45px;
                border: 2px solid #e1e5e9;
                border-radius: 12px;
                font-size: 14px;
                transition: all 0.3s ease;
                background: #f8f9fa;
            }

            .form-control-custom:focus {
                outline: none;
                border-color: #667eea;
                background: white;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }

            .toggle-password {
                position: absolute;
                right: 15px;
                cursor: pointer;
                color: #aaa;
                z-index: 10;
                transition: color 0.3s ease;
                background: transparent;
                border: none;
                padding: 5px;
                font-size: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .toggle-password:hover {
                color: #667eea;
            }

            .btn-login {
                width: 100%;
                padding: 12px;
                background: linear-gradient(135deg, #00115e 0%, #09005a 100%);
                border: none;
                border-radius: 12px;
                color: white;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 10px;
            }

            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            }

            .btn-login:active {
                transform: translateY(0);
            }

            .alert {
                border-radius: 12px;
                margin-bottom: 20px;
                padding: 12px 15px;
                border: none;
            }

            .alert-danger {
                background: #fee2e2;
                color: #991b1b;
            }

            .alert-success {
                background: #d1fae5;
                color: #065f46;
            }

            .forgot-password {
                text-align: center;
                margin-top: 20px;
            }

            .forgot-password a {
                color: #667eea;
                text-decoration: none;
                font-size: 14px;
                transition: color 0.3s ease;
            }

            .forgot-password a:hover {
                color: #764ba2;
                text-decoration: underline;
            }

            .footer-text {
                text-align: center;
                margin-top: 20px;
                color: white;
                opacity: 0.8;
                font-size: 13px;
            }

            @media (max-width: 480px) {
                .login-header {
                    padding: 30px 20px;
                }

                .login-body {
                    padding: 30px 20px;
                }

                .login-header h1 {
                    font-size: 1.5rem;
                }

                .login-icon {
                    width: 60px;
                    height: 60px;
                }

                .login-icon i {
                    font-size: 30px;
                }

                .form-control-custom {
                    padding: 10px 40px 10px 40px;
                    font-size: 16px;
                }

                .toggle-password {
                    right: 12px;
                    padding: 8px;
                }

                .input-group-custom .input-icon {
                    left: 12px;
                }
            }
        </style>
    </head>

    <body>
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-icon">
                        <img src="{{ asset('image/logo.jpeg') }}" alt="logo"
                            style="width: 50px; height: 50px; border-radius: 50%;">
                    </div>
                    <h1>DAF ACADEMY</h1>
                    <p>INSCRIPTION</p>
                    <p class="mt-2 small">Créer votre compte</p>
                </div>

                <div class="login-body">
                    @include('layouts.alerts')

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-2"></i>Nom complet
                            </label>
                            <div class="input-group-custom">
                                <i class="fas fa-user input-icon"></i>
                                <input id="name" type="text" class="form-control-custom" name="name"
                                    value="{{ old('name') }}" required autofocus autocomplete="name"
                                    placeholder="Votre nom complet">
                            </div>
                            @error('name')
                                <div class="text-danger mt-2 small">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Adresse email
                            </label>
                            <div class="input-group-custom">
                                <i class="fas fa-envelope input-icon"></i>
                                <input id="email" type="email" class="form-control-custom" name="email"
                                    value="{{ old('email') }}" required autocomplete="username"
                                    placeholder="exemple@isp.edu">
                            </div>
                            @error('email')
                                <div class="text-danger mt-2 small">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Mot de passe
                            </label>
                            <div class="input-group-custom">
                                <i class="fas fa-lock input-icon"></i>
                                <input id="password" type="password" class="form-control-custom" name="password"
                                    required autocomplete="new-password" placeholder="Votre mot de passe">
                                <button type="button" class="toggle-password" id="togglePassword"
                                    aria-label="Afficher/masquer le mot de passe">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger mt-2 small">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-2"></i>Confirmer le mot de passe
                            </label>
                            <div class="input-group-custom">
                                <i class="fas fa-lock input-icon"></i>
                                <input id="password_confirmation" type="password" class="form-control-custom"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirmez votre mot de passe">
                                <button type="button" class="toggle-password" id="togglePasswordConfirm"
                                    aria-label="Afficher/masquer la confirmation du mot de passe">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="text-danger mt-2 small">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-login" id="registerBtn">
                            <i class="fas fa-user-plus me-2"></i>S'inscrire
                        </button>

                        <div class="forgot-password">
                            <a href="{{ route('login') }}">
                                <i class="fas fa-arrow-left me-1"></i>Déjà inscrit ? Se connecter
                            </a>
                        </div>

                        <div class="forgot-password mt-2">
                            <a href="{{ url('/') }}">
                                <i class="fas fa-arrow-left me-1"></i>Retour à l'accueil
                            </a>
                        </div>
                        <i class="fas fa-copyright me-1"></i> {{ date('Y') }} DAF ACADEMY - Tous droits réservés
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    function setupToggle(buttonId, inputId) {
                        $(buttonId).on('click', function(e) {
                            e.preventDefault();
                            const input = $(inputId);
                            const icon = $(this).find('i');

                            if (input.attr('type') === 'password') {
                                input.attr('type', 'text');
                                icon.removeClass('fa-eye').addClass('fa-eye-slash');
                            } else {
                                input.attr('type', 'password');
                                icon.removeClass('fa-eye-slash').addClass('fa-eye');
                            }
                        });
                    }

                    setupToggle('#togglePassword', '#password');
                    setupToggle('#togglePasswordConfirm', '#password_confirmation');

                    $('#registerForm').on('submit', function() {
                        const btn = $('#registerBtn');
                        btn.prop('disabled', true);
                        btn.html('<i class="fas fa-circle-notch fa-spin me-2"></i>Inscription en cours...');
                    });

                    setTimeout(function() {
                        $('.alert').fadeOut('slow');
                    }, 5000);

                    $('.form-control-custom').on('focus', function() {
                        $(this).parent().find('.input-icon').css('color', '#667eea');
                    }).on('blur', function() {
                        $(this).parent().find('.input-icon').css('color', '#aaa');
                    });
                });
            </script>
    </body>

</html>
