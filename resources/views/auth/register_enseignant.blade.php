<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>DAF|ACADEMY</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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

            .form-control-custom {
                width: 100%;
                padding: 12px 16px;
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
        </style>
    </head>

    <body>
        @include('layouts.alerts')
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-icon">
                        <img src="{{ asset('image/logo.jpeg') }}" alt="logo"
                            style="width: 50px; height: 50px; border-radius: 50%;">
                    </div>
                    <h1>Créer un compte</h1>
                    <p>Inscription enseignant</p>
                </div>

                <div class="login-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('nouvel_enseignant') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="matricule" class="form-label">Matricule</label>
                            <input type="text" class="form-control-custom" id="matricule" name="matricule" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control-custom" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control-custom" id="password" name="password" required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control-custom" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn-login">S'inscrire</button>

                        <div class="mt-3 text-center">
                            <a href="{{ url('/') }}"
                                style="color: #667eea; text-decoration: none; font-size: 14px;">
                                <i class="fas fa-arrow-left me-1"></i>Retour à l'accueil
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

</html>
