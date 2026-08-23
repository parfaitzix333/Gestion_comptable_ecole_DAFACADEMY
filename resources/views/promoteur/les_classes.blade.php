@extends('base.base_promoteur')
@section('content')

    @include('promoteur._shared_styles')

    <div class="content-wrapper">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2>
                        <i class="fas fa-chalkboard"></i>
                        Gestion des Classes
                    </h2>
                    <p>Organisez les classes et assignez-les aux sections/années</p>
                </div>
                <div>
                    <button class="btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#createClassModal">
                        <i class="fas fa-plus-circle"></i>
                        Nouvelle Classe
                    </button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-modern alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-modern alert-danger">{{ session('error') }}</div>
        @endif

        <div class="stats-grid">
            <div class="stat-card stat-total">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $les_classes->count() }}</div>
                        <div class="stat-label">Total classes</div>
                    </div>
                    <i class="fas fa-school stat-icon" style="color:#667eea"></i>
                </div>
            </div>
        </div>
        <div class="input-group w-75 mb-3" id="searchInputContainer">
            <input type="search" id="searchInput" class="form-control" placeholder="Rechercher..." autocomplete="off">
            <span class="input-group-text bg-primary text-white">
                <i class="fas fa-search"></i>
            </span>
        </div>

        <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const value = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('#classeTable tbody tr');

                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();

                    if (text.includes(value)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>

        <div class="table-wrapper">
            <table class="table table-striped" id="classeTable">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Désignation</th>
                        <th>Section</th>
                        <th>Enseignants</th>
                        <th>Année</th>
                        <th>Nombre d'élèves</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($les_classes as $classe)
                        <tr>
                            <td class="fw-bold text-primary">#{{ $classe->id }}</td>
                            <td>{{ $classe->designation }}</td>
                            <td><span class="badge bg-info">{{ $classe->section?->designation ?? '—' }}</span></td>
                            <td>{{ $classe->enseignants->nom ?? '--' }}</td>
                            <td>{{ $classe->anneeScolaire?->annee ?? '—' }}</td>
                            <td><span class="badge bg-info">{{ $classe->eleves->count() ?? 0 }}</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editClassModal{{ $classe->id }}"><i
                                            class="fas fa-edit"></i></button>
                                    <form action="{{ route('classes.destroy', $classe->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-delete"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit modal -->
                        <div class="modal fade modal-modern" id="editClassModal{{ $classe->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier la classe</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('classes.update', $classe->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="form-label">Designation</label>
                                                <input name="designation" class="form-control-modern"
                                                    value="{{ $classe->designation }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Section</label>
                                                <select name="section_id" class="form-control-modern">
                                                    <option value="">-- Aucune --</option>
                                                    @foreach (App\Models\Section::all() as $s)
                                                        <option value="{{ $s->id }}"
                                                            {{ $classe->section_id == $s->id ? 'selected' : '' }}>
                                                            {{ $s->designation }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group"><label class="form-label">Année scolaire</label>
                                                <select name="annee_scolaire_id" class="form-control-modern">
                                                    <option value="">--Aucune--</option>
                                                    @foreach ($annees_scolaires as $annee)
                                                        <option value="{{ $annee->id }}"
                                                            {{ $classe->annee_scolaire_id == $annee->id ? 'selected' : '' }}>
                                                            {{ $annee->annee }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn-submit">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-school"></i>
                                    <h4>Aucune classe</h4>
                                    <p>Créez votre première classe</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create modal -->
    <div class="modal fade modal-modern" id="createClassModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle classe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('classes.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Designation</label>
                            <input name="designation" class="form-control-modern" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Section</label>
                            <select name="section_id" class="form-control-modern">
                                <option value="">-- Aucune --</option>
                                @foreach (App\Models\Section::all() as $s)
                                    <option value="{{ $s->id }}">{{ $s->designation }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><label class="form-label">Année scolaire</label>
                            <select name="annee_scolaire_id" class="form-control-modern">
                                <option value="">--Aucune--</option>
                                @foreach ($annees_scolaires as $annee)
                                    <option value="{{ $annee->id }}">
                                        {{ $annee->annee }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn-submit">Créer la classe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="notificationToast" class="toast-notification" style="display:none;"></div>

    <script>
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm('Confirmer la suppression ?')) {
                event.target.submit();
            }
            return false;
        }
    </script>

@endsection
