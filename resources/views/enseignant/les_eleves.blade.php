@extends('base.base_enseignant')
@section('content')
    @include('promoteur._shared_styles')

    <div class="content-wrapper">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2><i class="fas fa-user-graduate"></i> Liste des Élèves</h2>
                    <h2><b>
                            @if ($enseignant->classe_id ?? '')
                                Classe: <i>
                                    <h3>{{ $enseignant->classe->designation ?? '' }}</h3>
                                </i>
                            @else
                            @endif
                        </b></h2>
                    <p>
                    <h2 class="text-primary">{{ $user->anneeScolaire->annee ?? '' }}</h2>
                    </p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-modern alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-modern alert-danger">{{ session('error') }}</div>
        @endif
        <div class="d-flex gap-2 align-items-center mb-3" id="searchInputContainer">
            <div class="input-group">
                <input type="search" id="searchInput" class="form-control" placeholder="Rechercher..." autocomplete="off">
                <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
            </div>
        </div>

        <script>
            (function() {
                const searchInput = document.getElementById('searchInput');
                const classFilter = document.getElementById('classFilter');

                function filterRows() {
                    const q = (searchInput?.value || '').toLowerCase().trim();
                    const classId = classFilter?.value || '';
                    const rows = document.querySelectorAll('#eleveTable tbody tr');

                    rows.forEach(row => {
                        // skip empty-state rows
                        if (row.querySelector('.empty-state')) return;
                        const text = row.innerText.toLowerCase();
                        const rowClass = row.getAttribute('data-classe-id') || '';

                        const matchesQuery = q === '' || text.includes(q);
                        const matchesClass = classId === '' || rowClass === classId;

                        row.style.display = (matchesQuery && matchesClass) ? '' : 'none';
                    });
                }

                if (searchInput) searchInput.addEventListener('input', filterRows);
                if (classFilter) classFilter.addEventListener('change', filterRows);
            })();
        </script>

        <div class="table-wrapper">
            <table class="table table-striped" id="eleveTable">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Photo</th>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Classe</th>
                        <th>Année</th>
                        <th>Date N.</th>
                        <th>Sexe</th>
                        <th>Responsable</th>
                        <th>Tél. Resp.</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($les_eleves as $eleve)
                        <tr data-classe-id="{{ $eleve->classe_id ?? '' }}">
                            <td class="fw-bold text-primary">#{{ $eleve->id }}</td>
                            <td>
                                @if ($eleve->photo)
                                    <img src="/{{ $eleve->photo }}" alt="photo"
                                        style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                @else
                                    <div
                                        style="width:48px;height:48px;background:#f3f4f6;border-radius:6px;display:inline-block;">
                                    </div>
                                @endif
                            </td>
                            <td>{{ $eleve->matricule ?? '—' }}</td>
                            <td>{{ $eleve->nom }}</td>
                            <td>{{ $eleve->classe?->designation ?? '—' }}</td>
                            <td>{{ $eleve->anneeScolaire?->annee ?? '—' }}</td>
                            <td>{{ $eleve->date_n?->format('d/m/Y') ?? '—' }}</td>
                            <td>{{ $eleve->sexe == 'M' ? 'M' : ($eleve->sexe == 'F' ? 'F' : '—') }}</td>
                            <td>{{ $eleve->responsable }}</td>
                            <td>{{ $eleve->tel_responsable ?? '—' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#viewEleveModal{{ $eleve->id }}"><i
                                            class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Détails de l'Élève -->
                        <div class="modal fade modal-modern" id="viewEleveModal{{ $eleve->id }}" tabindex="-1"
                            aria-labelledby="viewEleveModalLabel{{ $eleve->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <!-- En-tête -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewEleveModalLabel{{ $eleve->id }}">
                                            <i class="fas fa-user-graduate text-primary me-2"></i>
                                            Détails de l'Élève
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Fermer"></button>
                                    </div>

                                    <!-- Corps -->
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Colonne gauche : Photo -->
                                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                                <div class="student-photo-container">
                                                    @if ($eleve->photo)
                                                        <img src="/{{ $eleve->photo }}" alt="Photo de {{ $eleve->nom }}"
                                                            class="student-photo img-fluid rounded-circle border border-3 border-primary"
                                                            style="width:150px;height:150px;object-fit:cover;">
                                                    @else
                                                        <div class="student-avatar bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                                            style="width:150px;height:150px;">
                                                            <i class="fas fa-user-graduate fa-5x text-primary"></i>
                                                        </div>
                                                    @endif
                                                    <p class="mt-2 mb-0 text-muted small">
                                                        <i class="fas fa-id-card me-1"></i>
                                                        Matricule: <strong>{{ $eleve->matricule ?? '—' }}</strong>
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Colonne droite : Informations -->
                                            <div class="col-md-8">
                                                <div class="student-info">
                                                    <!-- En-tête des infos -->
                                                    <div class="student-name-header mb-3">
                                                        <h4 class="mb-0 text-primary">
                                                            <i class="fas fa-user me-2"></i>
                                                            {{ $eleve->nom }}
                                                        </h4>
                                                        <span
                                                            class="badge {{ $eleve->sexe == 'M' ? 'bg-info' : 'bg-pink' }}">
                                                            {{ $eleve->sexe == 'M' ? 'Masculin' : ($eleve->sexe == 'F' ? 'Féminin' : '—') }}
                                                        </span>
                                                    </div>

                                                    <!-- Grille d'informations -->
                                                    <div class="row g-2">
                                                        <!-- Classe -->
                                                        <div class="col-12 col-sm-6">
                                                            <div class="info-item">
                                                                <span class="info-icon"><i class="fas fa-school"></i></span>
                                                                <div>
                                                                    <span class="info-label">Classe</span>
                                                                    <span
                                                                        class="info-value">{{ $eleve->classe?->designation ?? 'Non affecté' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Année scolaire -->
                                                        <div class="col-12 col-sm-6">
                                                            <div class="info-item">
                                                                <span class="info-icon"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                                <div>
                                                                    <span class="info-label">Année scolaire</span>
                                                                    <span
                                                                        class="info-value">{{ $eleve->anneeScolaire?->annee ?? 'Non définie' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Date de naissance -->
                                                        <div class="col-12 col-sm-6">
                                                            <div class="info-item">
                                                                <span class="info-icon"><i
                                                                        class="fas fa-calendar"></i></span>
                                                                <div>
                                                                    <span class="info-label">Date de naissance</span>
                                                                    <span
                                                                        class="info-value">{{ $eleve->date_n?->format('d/m/Y') ?? '—' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Lieu de naissance -->
                                                        <div class="col-12 col-sm-6">
                                                            <div class="info-item">
                                                                <span class="info-icon"><i
                                                                        class="fas fa-map-marker-alt"></i></span>
                                                                <div>
                                                                    <span class="info-label">Lieu de naissance</span>
                                                                    <span
                                                                        class="info-value">{{ $eleve->lieu_n ?? '—' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Responsable -->
                                                        <div class="col-12 col-sm-6">
                                                            <div class="info-item">
                                                                <span class="info-icon"><i
                                                                        class="fas fa-user-tie"></i></span>
                                                                <div>
                                                                    <span class="info-label">Responsable</span>
                                                                    <span
                                                                        class="info-value">{{ $eleve->responsable ?? '—' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Téléphone responsable -->
                                                        <div class="col-12 col-sm-6">
                                                            <div class="info-item">
                                                                <span class="info-icon"><i class="fas fa-phone"></i></span>
                                                                <div>
                                                                    <span class="info-label">Téléphone responsable</span>
                                                                    <span
                                                                        class="info-value">{{ $eleve->tel_responsable ?? '—' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Adresse -->
                                                        <div class="col-12">
                                                            <div class="info-item">
                                                                <span class="info-icon"><i class="fas fa-home"></i></span>
                                                                <div>
                                                                    <span class="info-label">Adresse</span>
                                                                    <span
                                                                        class="info-value">{{ $eleve->adresse ?? '—' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- École de provenance -->
                                                        <div class="col-12">
                                                            <div class="info-item">
                                                                <span class="info-icon"><i
                                                                        class="fas fa-school"></i></span>
                                                                <div>
                                                                    <span class="info-label">École de provenance</span>
                                                                    <span
                                                                        class="info-value">{{ $eleve->ecole_provenance ?? '—' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pied -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i> Fermer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            /* Styles pour le modal de détails */
                            .modal-modern .modal-content {
                                border-radius: 1rem;
                                overflow: hidden;
                                border: none;
                                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
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

                            .student-photo-container {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                            }

                            .student-photo {
                                border: 4px solid white;
                                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                                transition: transform 0.3s ease;
                            }

                            .student-photo:hover {
                                transform: scale(1.05);
                            }

                            .student-avatar {
                                background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
                                border: 3px solid #e5e7eb;
                            }

                            .student-name-header {
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                flex-wrap: wrap;
                                gap: 0.5rem;
                                padding-bottom: 0.75rem;
                                border-bottom: 2px solid #e5e7eb;
                            }

                            .student-name-header h4 {
                                font-weight: 700;
                            }

                            .badge.bg-pink {
                                background: linear-gradient(135deg, #ec4899, #db2777);
                                color: white;
                                padding: 0.35rem 1rem;
                                font-size: 0.75rem;
                            }

                            .badge.bg-info {
                                padding: 0.35rem 1rem;
                                font-size: 0.75rem;
                            }

                            .info-item {
                                display: flex;
                                align-items: flex-start;
                                gap: 0.75rem;
                                padding: 0.6rem 0.75rem;
                                background: white;
                                border-radius: 0.5rem;
                                border: 1px solid #f1f3f5;
                                transition: all 0.2s ease;
                                height: 100%;
                            }

                            .info-item:hover {
                                border-color: #667eea;
                                box-shadow: 0 2px 8px rgba(102, 126, 234, 0.08);
                            }

                            .info-icon {
                                width: 32px;
                                height: 32px;
                                min-width: 32px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
                                border-radius: 50%;
                                color: #667eea;
                                font-size: 0.85rem;
                                margin-top: 1px;
                            }

                            .info-label {
                                display: block;
                                font-size: 0.65rem;
                                text-transform: uppercase;
                                letter-spacing: 0.05em;
                                color: #9ca3af;
                                font-weight: 600;
                                margin-bottom: 0.1rem;
                            }

                            .info-value {
                                display: block;
                                font-size: 0.875rem;
                                font-weight: 500;
                                color: #1f2937;
                                word-break: break-word;
                            }

                            /* Responsive */
                            @media (max-width: 768px) {
                                .modal-dialog {
                                    margin: 0.5rem;
                                }

                                .modal-modern .modal-body {
                                    padding: 1rem;
                                }

                                .student-name-header {
                                    flex-direction: column;
                                    align-items: flex-start;
                                }

                                .student-photo,
                                .student-avatar {
                                    width: 120px !important;
                                    height: 120px !important;
                                }

                                .info-item {
                                    padding: 0.5rem 0.6rem;
                                }

                                .info-value {
                                    font-size: 0.8rem;
                                }

                                .modal-modern .modal-footer {
                                    flex-direction: column;
                                }

                                .modal-modern .modal-footer .btn {
                                    width: 100%;
                                }
                            }

                            @media (max-width: 480px) {

                                .student-photo,
                                .student-avatar {
                                    width: 100px !important;
                                    height: 100px !important;
                                }

                                .student-photo-container i {
                                    font-size: 3.5rem !important;
                                }

                                .info-item {
                                    padding: 0.4rem 0.5rem;
                                    border-radius: 0.4rem;
                                }

                                .info-icon {
                                    width: 26px;
                                    height: 26px;
                                    min-width: 26px;
                                    font-size: 0.7rem;
                                }

                                .info-label {
                                    font-size: 0.55rem;
                                }

                                .info-value {
                                    font-size: 0.75rem;
                                }
                            }
                        </style>


                    @empty
                        <tr>
                            <td colspan="11" class="text-center">
                                <div class="empty-state"><i class="fas fa-user-slash"></i>
                                    <h4>Aucun élève</h4>
                                    <p>Ajoutez des élèves pour commencer</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>




    <script>
        function previewFile(event, targetSelector) {
            const input = event.target;
            const file = input.files && input.files[0];
            const img = document.querySelector(targetSelector);
            if (!img) return;
            if (!file) {
                img.style.display = 'none';
                img.src = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // ensure create preview binding exists (in case input added later)
            const createImg = document.querySelector('#createElevePhotoPreview');
            const createInput = document.querySelector('#createEleveModal input[name="photo"]');
            if (createImg && createInput) {
                createInput.addEventListener('change', function(e) {
                    previewFile(e, '#createElevePhotoPreview');
                });
            }
        });
    </script>
@endsection
