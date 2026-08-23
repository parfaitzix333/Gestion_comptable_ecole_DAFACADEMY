<style>
    .profile-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-2px);
    }

    .profile-header {
        background: linear-gradient(135deg, #011672 0%, #b10202 100%);
        padding: 2rem 2rem 1.5rem;
        color: white;
        position: relative;
    }

    .profile-header h2 {
        margin: 0;
        font-weight: 600;
        font-size: 1.75rem;
        letter-spacing: -0.5px;
    }

    .profile-header .subtitle {
        opacity: 0.9;
        font-size: 0.95rem;
        margin-top: 0.25rem;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin-bottom: 1rem;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }

    .profile-body {
        padding: 2rem;
    }

    .profile-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 576px) {
        .profile-info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }

    .info-item {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        transition: background 0.2s ease;
    }

    .info-item:hover {
        background: #f1f3f5;
    }

    .info-item .label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        font-weight: 600;
        display: block;
        margin-bottom: 0.25rem;
    }

    .info-item .value {
        font-size: 1.1rem;
        font-weight: 500;
        color: #212529;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-item .value .badge-role {
        font-size: 0.7rem;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-weight: 500;
    }

    .badge-role.promoteur {
        background: #e3f7e5;
        color: #1e7e34;
    }

    .badge-role.admin {
        background: #fff3cd;
        color: #856404;
    }

    .badge-role.user {
        background: #d1ecf1;
        color: #0c5460;
    }

    .profile-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        border-top: 1px solid #e9ecef;
        padding-top: 1.5rem;
    }

    .btn-profile {
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.25s ease;
        border: none;
    }

    .btn-profile-primary {
        background: #00146b;
        color: white;
    }

    .btn-profile-primary:hover {
        background: #5a6fd6;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-profile-secondary {
        background: #e9ecef;
        color: #495057;
    }

    .btn-profile-secondary:hover {
        background: #dee2e6;
        color: #212529;
        transform: translateY(-2px);
    }

    /* Modal styles améliorés */
    .modal-content-custom {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #011055 0%, #7a0000 100%);
        color: white;
        padding: 1.5rem 2rem;
        border: none;
    }

    .modal-header-custom h5 {
        font-weight: 600;
        font-size: 1.25rem;
        margin: 0;
    }

    .modal-header-custom .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .modal-header-custom .btn-close:hover {
        opacity: 1;
    }

    .modal-body-custom {
        padding: 2rem;
    }

    .form-group-custom {
        margin-bottom: 1.5rem;
    }

    .form-group-custom label {
        font-weight: 500;
        font-size: 0.9rem;
        color: #495057;
        margin-bottom: 0.4rem;
        display: block;
    }

    .form-group-custom .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 0.65rem 1rem;
        transition: all 0.25s ease;
        font-size: 0.95rem;
    }

    .form-group-custom .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
    }

    .form-group-custom .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-group-custom .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
    }

    .btn-modal-submit {
        padding: 0.65rem 2rem;
        border-radius: 50px;
        font-weight: 500;
        background: linear-gradient(135deg, #000f53 0%, #910101 100%);
        border: none;
        color: white;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-modal-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-modal-cancel {
        padding: 0.65rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        color: #6c757d;
        transition: all 0.25s ease;
    }

    .btn-modal-cancel:hover {
        background: #e9ecef;
        color: #495057;
    }

    .password-hint {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.3rem;
    }

    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1060;
    }

    .alert-custom {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 1rem 1.5rem;
    }
</style>

<div class="profile-container">
    @if (session('success'))
        <div class="alert alert-success alert-custom mb-4">
            <i class="fa fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-custom mb-4">
            <i class="fa fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="profile-card">
        <!-- En-tête du profil -->
        <div class="profile-header">
            <div class="d-flex align-items-center gap-3">
                <div class="profile-avatar">
                    <i class="fa fa-user-circle"></i>
                </div>
                <div>
                    <h2>Mon Profil</h2>
                    <div class="subtitle">
                        <i class="fa fa-clock-o me-1"></i>
                        Membre depuis {{ $user->created_at->format('d/m/Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Corps du profil -->
        <div class="profile-body">
            <div class="profile-info-grid">
                <div class="info-item">
                    <span class="label">
                        <i class="fa fa-user me-1"></i> Nom complet
                    </span>
                    <span class="value">{{ $user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">
                        <i class="fa fa-envelope me-1"></i> Adresse email
                    </span>
                    <span class="value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="label">
                        <i class="fa fa-tag me-1"></i> Rôle
                    </span>
                    <span class="value">
                        @php
                            $roleClass = match ($user->role) {
                                'promoteur' => 'promoteur',
                                'admin' => 'admin',
                                default => 'user',
                            };
                        @endphp
                        <span class="badge-role {{ $roleClass }}">
                            <i class="fa fa-shield me-1"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="label">
                        <i class="fa fa-id-card me-1"></i> ID utilisateur
                    </span>
                    <span class="value">
                        <span class="text-muted" style="font-size: 0.85rem;">#{{ $user->id }}</span>
                    </span>
                </div>
            </div>

            <!-- Actions -->
            <div class="profile-actions">
                <button data-bs-target="#profilModal" data-bs-toggle="modal"
                    class="btn btn-profile btn-profile-primary">
                    <i class="fa fa-pencil"></i>
                    Modifier le profil
                </button>
                <button data-bs-target="#MpassModal" data-bs-toggle="modal"
                    class="btn btn-profile btn-profile-secondary">
                    <i class="fa fa-key"></i>
                    Changer le mot de passe
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Profil -->
<div class="modal fade" tabindex="-1" id="profilModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5><i class="fa fa-pencil me-2"></i>Modifier le profil</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modal-body-custom">
                <form action="{{ route('utilisateurs.update', $user->id) }}" method="post">
                    @csrf
                    @method('put')

                    <div class="form-group-custom">
                        <label for="name">
                            <i class="fa fa-user me-1 text-muted"></i> Nom complet
                        </label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-custom">
                        <label for="email">
                            <i class="fa fa-envelope me-1 text-muted"></i> Adresse email
                        </label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i> Annuler
                        </button>
                        <button type="submit" class="btn-modal-submit">
                            <i class="fa fa-check"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Mot de passe -->
<div class="modal fade" tabindex="-1" id="MpassModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5><i class="fa fa-key me-2"></i>Changer le mot de passe</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modal-body-custom">
                <form action="{{ route('editpass', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group-custom">
                        <label for="current_password">
                            <i class="fa fa-lock me-1 text-muted"></i> Mot de passe actuel
                        </label>
                        <input type="password" name="current_password" id="current_password"
                            class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-custom">
                        <label for="password">
                            <i class="fa fa-key me-1 text-muted"></i> Nouveau mot de passe
                        </label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required minlength="8">
                        <div class="password-hint">
                            <i class="fa fa-info-circle me-1"></i>
                            Minimum 8 caractères
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-custom">
                        <label for="password_confirmation">
                            <i class="fa fa-check-circle me-1 text-muted"></i> Confirmer le mot de passe
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" required minlength="8">
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i> Annuler
                        </button>
                        <button type="submit" class="btn-modal-submit">
                            <i class="fa fa-key"></i> Modifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->has('current_password') || $errors->has('password'))
                var modal = new bootstrap.Modal(document.getElementById('MpassModal'));
                modal.show();
            @else
                var modal = new bootstrap.Modal(document.getElementById('profilModal'));
                modal.show();
            @endif
        });
    </script>
@endif