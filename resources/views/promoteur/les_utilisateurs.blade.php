@extends('base.base_promoteur')

@section('content')
    @include('promoteur._shared_styles')

    <style>
        /* Styles additionnels pour la gestion des utilisateurs */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .role-badge.promoteur {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .role-badge.comptable {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
        }

        .role-badge.enseignant {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .role-badge.suspendu {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .role-badge.role-user {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
        }

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

        .table table-striped {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
            margin: 0;
        }

        @media (max-width: 480px) {
            .table table-striped {
                min-width: 500px;
            }
        }

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
        }

        .table table-striped tbody td {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            color: #374151;
            vertical-align: middle;
        }

        .table table-striped tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f3f4f6;
        }

        .table table-striped tbody tr:hover {
            background: #f8fafc;
        }

        .search-match {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.08), rgba(16, 185, 129, 0.04)) !important;
            box-shadow: inset 0 0 0 1px rgba(102, 126, 234, 0.1);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: nowrap;
        }

        .btn-icon {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.5rem;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            flex-shrink: 0;
        }

        .btn-icon:hover {
            transform: translateY(-2px);
        }

        .btn-edit {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .search-container {
            background: white;
            border-radius: 1rem;
            padding: 0.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .search-input-group {
            display: flex;
            align-items: center;
            background: #f9fafb;
            border-radius: 0.75rem;
            padding: 0.25rem;
            transition: all 0.3s ease;
        }

        .search-input-group:focus-within {
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            outline: none;
            min-width: 0;
        }

        .search-icon {
            padding: 0.75rem 1rem;
            color: #9ca3af;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 1rem;
            }

            .page-header {
                padding: 1rem;
                border-radius: 1rem;
            }

            .page-header h2 {
                font-size: 1.25rem;
                flex-wrap: wrap;
            }

            .page-header h2 i {
                font-size: 1.25rem;
            }

            .page-header p {
                font-size: 0.875rem;
            }

            .table-wrapper {
                overflow-x: auto;
                margin: 0 -0.5rem;
                padding: 0 0.5rem;
            }

            .table table-striped {
                min-width: 650px;
            }

            .table table-striped thead th,
            .table table-striped tbody td {
                padding: 0.75rem 1rem;
                font-size: 0.8rem;
            }

            .btn-icon {
                width: 2rem;
                height: 2rem;
                font-size: 0.75rem;
            }

            .role-badge {
                font-size: 0.7rem;
                padding: 0.25rem 0.625rem;
            }

            .search-container {
                padding: 0.375rem;
            }

            .search-input {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .content-wrapper {
                padding: 0.75rem;
            }

            .page-header {
                padding: 0.75rem;
            }

            .page-header h2 {
                font-size: 1.1rem;
            }

            .page-header p {
                font-size: 0.75rem;
            }

            .badge {
                font-size: 0.7rem;
                padding: 0.375rem 0.75rem;
            }

            .table-wrapper {
                margin: 0 -0.25rem;
                padding: 0 0.25rem;
            }

            .table table-striped {
                min-width: 500px;
            }

            .table table-striped thead th,
            .table table-striped tbody td {
                padding: 0.5rem 0.75rem;
                font-size: 0.7rem;
            }

            .btn-icon {
                width: 1.75rem;
                height: 1.75rem;
                font-size: 0.65rem;
            }

            .role-badge {
                font-size: 0.6rem;
                padding: 0.2rem 0.5rem;
                gap: 0.25rem;
            }

            .action-buttons {
                gap: 0.25rem;
            }

            .search-input {
                padding: 0.4rem 0.5rem;
                font-size: 0.75rem;
            }

            .search-icon {
                padding: 0.4rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        .toast-notification {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: white;
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: none;
            align-items: center;
            gap: 0.75rem;
            z-index: 9999;
            animation: slideInLeft 0.3s ease-out;
            max-width: 90%;
            border-left: 4px solid #10b981;
        }

        @media (max-width: 480px) {
            .toast-notification {
                bottom: 1rem;
                right: 1rem;
                left: 1rem;
                max-width: calc(100% - 2rem);
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Correction pour le modal */
        .modal-modern .modal-content {
            border-radius: 1rem;
            overflow: hidden;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .modal-modern .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-modern .modal-body {
            padding: 1.5rem;
            background: #f8fafc;
        }

        .modal-modern .modal-footer {
            border: none;
            padding: 1rem 1.5rem;
            background: white;
            gap: 0.5rem;
        }
    </style>

    <div class="content-wrapper">
        @include('layouts.alerts')

        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2><i class="fas fa-users"></i> Gestion des Utilisateurs</h2>
                    <p>Gérez les comptes utilisateurs et leurs permissions</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-white text-dark rounded-pill px-3 py-2">
                        <i class="fas fa-user me-1"></i>
                        Total: {{ $les_utilisateurs->count() }} utilisateur(s)
                    </span>
                </div>
            </div>
        </div>

        <div class="input-group w-75 mb-3" id="searchInputContainer">
            <input type="search" id="searchInput" class="form-control" placeholder="Rechercher..." autocomplete="off">
            <span class="input-group-text bg-primary text-white">
                <i class="fas fa-search"></i>
            </span>
        </div>

        <div class="table-wrapper">
            <table class="table table-striped" id="userTable">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Année Scolaire</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    @forelse($les_utilisateurs as $u)
                        <tr data-user-id="{{ $u->id }}">
                            <td class="fw-bold text-primary">#{{ $u->id }}</td>
                            <td>
                                <span class="user-matricule">{{ $u->matricule ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 d-none d-sm-inline-flex">
                                        <i class="fas fa-user-circle text-primary"></i>
                                    </div>
                                    <span class="fw-semibold user-name">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-envelope me-1 text-muted d-none d-sm-inline"></i>
                                <span class="user-email">{{ $u->email }}</span>
                            </td>
                            <td>
                                @php
                                    $roleClass = match ($u->role) {
                                        'promoteur' => 'promoteur',
                                        'comptable' => 'comptable',
                                        'enseignant' => 'enseignant',
                                        'suspendu' => 'suspendu',
                                        default => 'role-user',
                                    };
                                    $roleIcon = match ($u->role) {
                                        'promoteur' => 'fa-crown',
                                        'comptable' => 'fa-user-shield',
                                        'enseignant' => 'fa-chalkboard-teacher',
                                        'suspendu' => 'fa-user-times',
                                        default => 'fa-user',
                                    };
                                    $roleLabel = match ($u->role) {
                                        'promoteur' => 'Promoteur',
                                        'comptable' => 'Comptable',
                                        'enseignant' => 'Enseignant',
                                        'suspendu' => 'Suspendu',
                                        default => 'Utilisateur',
                                    };
                                @endphp
                                <span class="role-badge {{ $roleClass }} user-role"
                                    data-role="{{ strtolower($u->role ?? '') }}">
                                    <i class="fas {{ $roleIcon }}"></i>
                                    {{ $roleLabel }}
                                </span>
                            </td>
                            <td>
                                @if ($u->anneeScolaire)
                                    <span class="badge bg-info text-dark">
                                        {{ $u->anneeScolaire->annee ?? 'N/A' }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-edit" data-bs-toggle="modal" data-bs-target="#editUserModal"
                                        data-user-id="{{ $u->id }}" data-user-name="{{ $u->name }}"
                                        data-user-matricule="{{ $u->matricule ?? '' }}"
                                        data-user-email="{{ $u->email }}" data-user-role="{{ $u->role }}"
                                        data-user-annee="{{ $u->annee_scolaire_id ?? '' }}" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('utilisateurs.destroy', $u->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-delete" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    <h4>Aucun utilisateur trouvé</h4>
                                    <p>Commencez par ajouter des utilisateurs à la plateforme</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Edit modal -->
        <div class="modal fade modal-modern" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">
                            <i class="fas fa-user-edit"></i> Modifier l'utilisateur
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <form id="editUserForm" action="#" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-id-card"></i> Matricule</label>
                                <input type="text" name="matricule" id="edit_matricule" class="form-control-modern"
                                    maxlength="255">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-user"></i> Nom complet</label>
                                <input type="text" name="name" id="edit_name" class="form-control-modern" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-envelope"></i> Adresse email</label>
                                <input type="email" name="email" id="edit_email" class="form-control-modern" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-lock"></i> Nouveau mot de passe</label>
                                <input type="password" name="password" class="form-control-modern"
                                    placeholder="Laisser vide pour conserver l'actuel">
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-info-circle"></i> Laissez vide pour ne pas modifier le mot de passe
                                </small>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-tag"></i> Rôle</label>
                                <select name="role" id="edit_role" class="form-control-modern" required>
                                    <option value="">-- Sélectionner un rôle --</option>
                                    <option value="promoteur">Promoteur</option>
                                    <option value="comptable">Comptable</option>
                                    <option value="enseignant">Enseignant</option>
                                    <option value="suspendu">Suspendu</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Annuler
                            </button>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="notificationToast" class="toast-notification" style="display:none;">
            <i class="fas fa-check-circle fa-lg"></i>
            <span id="toastMessage"></span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==== RECHERCHE ====
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('#usersTableBody tr');

            function filterTable() {
                const query = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;
                let hasVisible = false;

                rows.forEach(row => {
                    if (row.querySelector('.empty-state')) {
                        row.style.display = '';
                        return;
                    }

                    const id = row.querySelector('td:first-child')?.textContent?.toLowerCase() || '';
                    const matricule = row.querySelector('.user-matricule')?.textContent?.toLowerCase() ||
                    '';
                    const name = row.querySelector('.user-name')?.textContent?.toLowerCase() || '';
                    const email = row.querySelector('.user-email')?.textContent?.toLowerCase() || '';
                    const role = row.querySelector('.user-role')?.textContent?.toLowerCase() || '';

                    const matches = query === '' ||
                        id.includes(query) ||
                        matricule.includes(query) ||
                        name.includes(query) ||
                        email.includes(query) ||
                        role.includes(query);

                    row.style.display = matches ? '' : 'none';
                    if (matches) {
                        row.classList.add('search-match');
                        visibleCount++;
                        hasVisible = true;
                    } else {
                        row.classList.remove('search-match');
                    }
                });

                // Message "aucun résultat"
                let noResultRow = document.getElementById('noResultRow');
                if (!hasVisible && query !== '' && rows.length > 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement('tr');
                        noResultRow.id = 'noResultRow';
                        noResultRow.innerHTML = `
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-search fa-2x text-muted mb-2 d-block"></i>
                                <p class="text-muted mb-0">Aucun utilisateur ne correspond à votre recherche</p>
                                <small class="text-muted">Essayez avec d'autres termes</small>
                            </td>
                        `;
                        document.getElementById('usersTableBody').appendChild(noResultRow);
                    }
                    noResultRow.style.display = '';
                } else if (noResultRow) {
                    noResultRow.style.display = 'none';
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterTable);
                searchInput.addEventListener('keyup', function(e) {
                    if (e.key === 'Escape') {
                        this.value = '';
                        filterTable();
                        this.blur();
                    }
                });
            }

            // ==== MODAL - Remplissage des champs ====
            const editModal = document.getElementById('editUserModal');
            const editForm = document.getElementById('editUserForm');
            const editMatricule = document.getElementById('edit_matricule');
            const editName = document.getElementById('edit_name');
            const editEmail = document.getElementById('edit_email');
            const editRole = document.getElementById('edit_role');
            const editAnnee = document.getElementById('edit_annee');

            // Écouter l'événement show.bs.modal
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    // Récupérer le bouton qui a déclenché le modal
                    const button = event.relatedTarget;
                    if (!button) return;

                    // Récupérer les données
                    const userId = button.getAttribute('data-user-id');
                    const userMatricule = button.getAttribute('data-user-matricule');
                    const userName = button.getAttribute('data-user-name');
                    const userEmail = button.getAttribute('data-user-email');
                    const userRole = button.getAttribute('data-user-role');
                    const userAnnee = button.getAttribute('data-user-annee');

                    // Remplir le formulaire
                    if (editForm) editForm.action = '/utilisateurs/' + userId;
                    if (editMatricule) editMatricule.value = userMatricule || '';
                    if (editName) editName.value = userName || '';
                    if (editEmail) editEmail.value = userEmail || '';
                    if (editRole) editRole.value = userRole || '';
                    if (editAnnee) editAnnee.value = userAnnee || '';

                    console.log('Modal ouvert pour:', {
                        id: userId,
                        matricule: userMatricule,
                        name: userName,
                        email: userEmail,
                        role: userRole,
                        annee: userAnnee
                    });
                });
            }

            // ==== FALLBACK : Remplir aussi au clic du bouton ====
            document.querySelectorAll('.btn-edit').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    // Les données sont déjà dans les attributs data-*
                    // Mais on les récupère pour être sûr
                    const userId = this.getAttribute('data-user-id');
                    const userMatricule = this.getAttribute('data-user-matricule');
                    const userName = this.getAttribute('data-user-name');
                    const userEmail = this.getAttribute('data-user-email');
                    const userRole = this.getAttribute('data-user-role');
                    const userAnnee = this.getAttribute('data-user-annee');

                    // Remplir directement (au cas où l'événement show.bs.modal échoue)
                    if (editForm) editForm.action = '/utilisateurs/' + userId;
                    if (editMatricule) editMatricule.value = userMatricule || '';
                    if (editName) editName.value = userName || '';
                    if (editEmail) editEmail.value = userEmail || '';
                    if (editRole) editRole.value = userRole || '';
                    if (editAnnee) editAnnee.value = userAnnee || '';
                });
            });

            // ==== ANIMATION DES LIGNES ====
            rows.forEach((row, idx) => {
                if (row.querySelector('.empty-state') || row.id === 'noResultRow') return;
                row.style.opacity = '0';
                row.style.animation = `slideInLeft 0.3s ease-out ${Math.min(idx * 0.05, 0.5)}s forwards`;
            });

            // ==== AUTO-FERMETURE DES ALERTES ====
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });

        // ==== FONCTIONS GLOBALES ====
        function confirmDelete(e) {
            e.preventDefault();
            const form = e.target;
            if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
                showNotification('Utilisateur supprimé avec succès', 'success');
                form.submit();
            }
            return false;
        }

        function showNotification(message, type = 'success') {
            const toast = document.getElementById('notificationToast');
            const toastMessage = document.getElementById('toastMessage');
            const icon = toast?.querySelector('i');

            if (!toast || !toastMessage) return;

            toastMessage.textContent = message;

            if (type === 'success') {
                if (icon) icon.className = 'fas fa-check-circle fa-lg text-success';
                toast.style.borderLeftColor = '#10b981';
            } else {
                if (icon) icon.className = 'fas fa-exclamation-circle fa-lg text-danger';
                toast.style.borderLeftColor = '#ef4444';
            }

            toast.style.display = 'flex';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }
    </script>
@endsection
