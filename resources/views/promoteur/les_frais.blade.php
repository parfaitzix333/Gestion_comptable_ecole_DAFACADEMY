@extends('base.base_promoteur')
@section('content')
    @include('promoteur._shared_styles')

    <div class="content-wrapper">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2><i class="fas fa-receipt"></i> Gestion des Frais</h2>
                    <p>Créez et gérez les frais par classe/année</p>
                </div>
                <div>
                    <button class="btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#createFraisModal"><i
                            class="fas fa-plus-circle"></i> Nouveau Frais</button>
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
            <div>
                <select id="classFilter" class="form-select">
                    <option value="">Toutes les classes</option>
                    @foreach ($classes as $c)
                        <option value="{{ $c->id }}">{{ $c->designation }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <script>
            (function() {
                const searchInput = document.getElementById('searchInput');
                const classFilter = document.getElementById('classFilter');

                function filterFrais() {
                    const q = (searchInput?.value || '').toLowerCase().trim();
                    const classId = classFilter?.value || '';
                    const rows = document.querySelectorAll('#fraisTable tbody tr');

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

                if (searchInput) {
                    searchInput.addEventListener('input', filterFrais);
                }
                if (classFilter) {
                    classFilter.addEventListener('change', filterFrais);
                }
            })();
        </script>

        <div class="table-wrapper">
            <table class="table table-striped" id="fraisTable">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Désignation</th>
                        <th>Montant</th>
                        <th>Echéance</th>
                        <th>Classe</th>
                        <th>Année scolaire</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($les_frais as $f)
                        @php
                            $isOverdue = $f->date_limite && $f->date_limite->lessThanOrEqualTo(\Carbon\Carbon::today());
                        @endphp
                        <tr data-classe-id="{{ $f->classe_id ?? '' }}">
                            <td class="fw-bold text-primary">#{{ $f->id }}</td>
                            <td>{{ $f->designation }}</td>
                            <td>{{ number_format($f->montant, 2) }} {{ $f->devise }}</td>
                            <td class="date-limite {{ $isOverdue ? 'text-danger fw-bold' : '' }}">
                                {{ $f->date_limite ? $f->date_limite->format('d/m/Y') : 'Non défini' }}</td>
                            <td>{{ $f->classe?->designation ?? '—' }}</td>
                            <td>{{ $f->anneeScolaire?->annee ?? '—' }}</td>
                            <td>
                                @php
                                    $isActive = in_array(
                                        $f->statut,
                                        ['actif', 'active', '1', 1, true, 'true', 'yes', 'oui', 'on'],
                                        true,
                                    );
                                    $statusClass = $isActive ? 'status-active' : 'status-inactive';
                                    $statusLabel = $isActive ? 'Actif' : 'Inactif';
                                    $statusIcon = $isActive ? 'fa-check-circle' : 'fa-times-circle';
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="fas {{ $statusIcon }}"></i>
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editFraisModal{{ $f->id }}"><i
                                            class="fas fa-edit"></i></button>
                                    <form action="{{ route('frais.destroy', $f->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)">@csrf @method('DELETE')<button
                                            class="btn-icon btn-delete"><i class="fas fa-trash-alt"></i></button></form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade modal-modern" id="editFraisModal{{ $f->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier Frais</h5><button class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('frais.update', $f->id) }}" method="POST">@csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group"><label class="form-label">Désignation</label><input
                                                    name="designation" class="form-control-modern"
                                                    value="{{ $f->designation }}" required></div>
                                            <div class="form-group"><label class="form-label">Montant</label><input
                                                    name="montant" class="form-control-modern" value="{{ $f->montant }}"
                                                    required></div>
                                            <div class="form-group"><label class="form-label">Devise</label><input
                                                    name="devise" class="form-control-modern" value="{{ $f->devise }}">
                                            </div>
                                            <div class="form-group"><label class="form-label">Année scolaire</label>
                                                <select name="annee_scolaire_id" class="form-control-modern">
                                                    <option value="">--Aucune--</option>
                                                    @foreach ($annees_scolaires as $annee)
                                                        <option value="{{ $annee->id }}"
                                                            {{ $f->annee_scolaire_id == $annee->id ? 'selected' : '' }}>
                                                            {{ $annee->annee }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group"><label class="form-label">Date limite</label><input
                                                    type="date" name="date_limite" class="form-control-modern"
                                                    value="{{ $f->date_limite?->format('Y-m-d') }}"></div>

                                            <div class="form-group"><label class="form-label">Statut</label>
                                                <select name="statut" class="form-control-modern">
                                                    <option value="actif"
                                                        {{ in_array($f->statut, ['actif', 'active', '1', 'yes', 'oui', 'on']) ? 'selected' : '' }}>
                                                        Actif</option>
                                                    <option value="inactif"
                                                        {{ !in_array($f->statut, ['actif', 'active', '1', 'yes', 'oui', 'on']) ? 'selected' : '' }}>
                                                        Inactif</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button><button
                                                class="btn-submit">Enregistrer</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="empty-state"><i class="fas fa-receipt"></i>
                                    <h4>Aucun frais</h4>
                                    <p>Ajoutez des frais pour vos classes</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade modal-modern" id="createFraisModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouveau Frais</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('frais.store') }}" method="POST">@csrf
                    <div class="modal-body">
                        <div class="form-group"><label class="form-label">Désignation</label><input name="designation"
                                class="form-control-modern" required></div>
                        <div class="form-group"><label class="form-label">Montant</label><input name="montant"
                                class="form-control-modern" required></div>

                        <div class="form-group"><label class="form-label">Année scolaire</label>
                            <select name="annee_scolaire_id" class="form-control-modern">
                                <option value="">--Aucune--</option>
                                @foreach ($annees_scolaires as $annee)
                                    <option value="{{ $annee->id }}">{{ $annee->annee }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><label class="form-label">Classe</label><select name="classe_id"
                                class="form-control-modern">
                                <option value="">--Aucune--</option>
                                @foreach (App\Models\Classe::all() as $c)
                                    <option value="{{ $c->id }}">{{ $c->designation }}</option>
                                @endforeach
                            </select></div>
                        <div class="form-group"><label class="form-label">Date limite</label><input type="date"
                                name="date_limite" class="form-control-modern"></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Annuler</button><button class="btn-submit">Créer</button></div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(e) {
            e.preventDefault();
            if (confirm('Confirmer la suppression ?')) e.target.submit();
            return false;
        }
    </script>
@endsection
