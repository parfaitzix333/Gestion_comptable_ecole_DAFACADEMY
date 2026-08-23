@extends('base.base_promoteur')

@section('content')
    @include('promoteur._shared_styles')
    <div class="content-wrapper">
        <!-- En-tête -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2>
                        <i class="fas fa-calendar-alt"></i>
                        Gestion des Années Scolaires
                    </h2>
                    <p>Gérez les années scolaires et leurs statuts</p>
                </div>
                <div>
                    <button class="btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#createAnneeModal">
                        <i class="fas fa-plus-circle"></i>
                        Nouvelle Année
                    </button>
                </div>
            </div>
        </div>

        <!-- Affichage des messages -->
        @if (session('success'))
            <div class="alert alert-modern alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-modern alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card stat-total">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $les_annees->count() }}</div>
                        <div class="stat-label">Total années</div>
                    </div>
                    <i class="fas fa-calendar stat-icon" style="color: #667eea;"></i>
                </div>
            </div>
            <div class="stat-card stat-active">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $les_annees->where('statut', 'actif')->count() }}</div>
                        <div class="stat-label">Années actives</div>
                    </div>
                    <i class="fas fa-check-circle stat-icon" style="color: #10b981;"></i>
                </div>
            </div>
            <div class="stat-card stat-inactive">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $les_annees->where('statut', 'inactif')->count() }}</div>
                        <div class="stat-label">Années inactives</div>
                    </div>
                    <i class="fas fa-times-circle stat-icon" style="color: #ef4444;"></i>
                </div>
            </div>
        </div>

        <!-- Tableau -->
        <div class="table-wrapper">




            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Année scolaire</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($les_annees as $annee)
                        <tr>
                            <td data-label="ID" class="fw-bold text-primary">#{{ $annee->id }}</td>
                            <td data-label="Année">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 d-none d-sm-inline-flex">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </div>
                                    <span class="fw-semibold">{{ $annee->annee }}</span>
                                </div>
                            </td>
                            <td data-label="Statut">
                                @php
                                    $statusClass = $annee->statut === 'actif' ? 'status-active' : 'status-inactive';
                                    $statusIcon = $annee->statut === 'actif' ? 'fa-check-circle' : 'fa-times-circle';
                                    $statusLabel = $annee->statut === 'actif' ? 'Actif' : 'Inactif';
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="fas {{ $statusIcon }}"></i>
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <!-- Bouton Éditer -->
                                    <button class="btn-icon btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editAnneeModal{{ $annee->id }}" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Bouton Changer statut -->
                                    <form action="{{ route('annees.update', $annee->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="annee" value="{{ $annee->annee }}">
                                        <input type="hidden" name="statut"
                                            value="{{ $annee->statut === 'actif' ? 'inactif' : 'actif' }}">
                                        <button type="submit" class="btn-icon btn-toggle"
                                            onclick="return confirm('Voulez-vous changer le statut de cette année scolaire ?')"
                                            title="Changer statut">
                                            <i class="fas {{ $annee->statut === 'actif' ? 'fa-pause' : 'fa-play' }}"></i>
                                        </button>
                                    </form>

                                    <!-- Bouton Supprimer -->
                                    <form action="{{ route('annees.destroy', $annee->id) }}" method="POST"
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

                        <!-- Modal d'édition pour chaque année -->
                        <div class="modal fade modal-modern" id="editAnneeModal{{ $annee->id }}" tabindex="-1"
                            aria-labelledby="editAnneeModalLabel{{ $annee->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editAnneeModalLabel{{ $annee->id }}">
                                            <i class="fas fa-edit"></i>
                                            Modifier l'année scolaire
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Fermer"></button>
                                    </div>
                                    <form action="{{ route('annees.update', $annee->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-calendar"></i>Année scolaire
                                                </label>
                                                <input type="text" name="annee" class="form-control-modern"
                                                    value="{{ $annee->annee }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-toggle-on"></i>Statut
                                                </label>
                                                <select name="statut" class="form-control-modern" required>
                                                    <option value="actif"
                                                        {{ $annee->statut === 'actif' ? 'selected' : '' }}>Actif</option>
                                                    <option value="inactif"
                                                        {{ $annee->statut === 'inactif' ? 'selected' : '' }}>Inactif
                                                    </option>
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
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h4>Aucune année scolaire</h4>
                                    <p>Commencez par créer une nouvelle année scolaire</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de création -->
    <div class="modal fade modal-modern" id="createAnneeModal" tabindex="-1" aria-labelledby="createAnneeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAnneeModalLabel">
                        <i class="fas fa-plus-circle"></i>
                        Nouvelle année scolaire
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form action="{{ route('annees.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-calendar"></i>Année scolaire
                            </label>
                            <input type="text" name="annee" class="form-control-modern" placeholder="Ex: 2024-2025"
                                required>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle"></i> Format recommandé: AAAA-AAAA
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Créer l'année
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast de notification -->
    <div id="notificationToast" class="toast-notification" style="display: none;">
        <i class="fas fa-check-circle fa-lg"></i>
        <span id="toastMessage"></span>
    </div>

    <script>
        // Confirmation de suppression
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;

            if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette année scolaire ?\n\nCette action est irréversible.')) {
                showNotification('Année scolaire supprimée avec succès', 'success');
                form.submit();
            }
            return false;
        }

        // Notification toast
        function showNotification(message, type = 'success') {
            const toast = document.getElementById('notificationToast');
            const toastMessage = document.getElementById('toastMessage');
            const icon = toast.querySelector('i');

            toastMessage.textContent = message;

            if (type === 'success') {
                icon.className = 'fas fa-check-circle fa-lg text-success';
                toast.classList.add('toast-success');
                toast.classList.remove('toast-error');
            } else {
                icon.className = 'fas fa-exclamation-circle fa-lg text-danger';
                toast.classList.add('toast-error');
                toast.classList.remove('toast-success');
            }

            toast.style.display = 'flex';

            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        // Auto-fermeture des alertes après 5 secondes
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-modern');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
@endsection
