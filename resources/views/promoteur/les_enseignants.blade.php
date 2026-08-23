@extends('base.base_promoteur')
@section('content')

    @include('promoteur._shared_styles')

    <div class="content-wrapper">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2><i class="fas fa-chalkboard-teacher"></i> Gestion des Enseignants</h2>
                    <p>Liste des enseignants et affectations</p>
                </div>
                <div>
                    <button class="btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#createEnsModal"><i
                            class="fas fa-plus-circle"></i> Nouvel Enseignant</button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-modern alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-modern alert-danger">{{ session('error') }}</div>
        @endif
        <div class="input-group w-75 mb-3" id="searchInputContainer">
            <input type="search" id="searchInput" class="form-control" placeholder="Rechercher..." autocomplete="off">
            <span class="input-group-text bg-primary text-white">
                <i class="fas fa-search"></i>
            </span>
        </div>

        <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const value = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('#enseignantTable tbody tr');

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
            <table class="table table-striped" id="enseignantTable">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Nom</th>
                        <th>Matricule</th>
                        <th>Classe</th>
                        <th>Associé(Utilisateur)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($les_enseignants as $ens)
                        <tr>
                            <td class="fw-bold text-primary">#{{ $ens->id }}</td>
                            <td>{{ $ens->nom }}</td>
                            <td>{{ $ens->matricule }}</td>
                            <td>{{ $ens->classe?->designation ?? '—' }}</td>
                            <td>{{ $ens->user?->name ?? '—' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editEnsModal{{ $ens->id }}"><i
                                            class="fas fa-edit"></i></button>
                                    <form action="{{ route('enseignants.destroy', $ens->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)">@csrf @method('DELETE')<button
                                            class="btn-icon btn-delete"><i class="fas fa-trash-alt"></i></button></form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade modal-modern" id="editEnsModal{{ $ens->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier Enseignant</h5><button class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('enseignants.update', $ens->id) }}" method="POST">@csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group"><label class="form-label">Nom</label><input
                                                    name="nom" class="form-control-modern" value="{{ $ens->nom }}"
                                                    required></div>
                                            <div class="form-group"><label class="form-label">Matricule</label><input
                                                    name="matricule" class="form-control-modern"
                                                    value="{{ $ens->matricule }}"></div>
                                            <div class="form-group"><label class="form-label">Classe</label><select
                                                    name="classe_id" class="form-control-modern">
                                                    <option value="">--Aucune--</option>
                                                    @foreach (App\Models\Classe::all() as $c)
                                                        <option value="{{ $c->id }}"
                                                            {{ $ens->classe_id == $c->id ? 'selected' : '' }}>
                                                            {{ $c->designation }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Utilisateur associé</label>
                                                <select name="user_id" class="form-control-modern">
                                                    <option value="">--Aucun--</option>
                                                    @if ($ens->user)
                                                        <option value="{{ $ens->user->id }}" selected>
                                                            {{ $ens->user->name }} (actuel)</option>
                                                    @endif
                                                    @foreach ($les_users as $u)
                                                        <option value="{{ $u->id }}">{{ $u->name }}
                                                            &lt;{{ $u->email }}&gt;</option>
                                                    @endforeach
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
                            <td colspan="5" class="text-center">
                                <div class="empty-state"><i class="fas fa-user-tie"></i>
                                    <h4>Aucun enseignant</h4>
                                    <p>Ajoutez des enseignants</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade modal-modern" id="createEnsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvel Enseignant</h5><button class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('enseignants.store') }}" method="POST">@csrf
                    <div class="modal-body">
                        <div class="form-group"><label class="form-label">Nom</label><input name="nom"
                                class="form-control-modern" required></div>
                        <div class="form-group"><label class="form-label">Matricule</label><input name="matricule"
                                class="form-control-modern"></div>
                        <div class="form-group"><label class="form-label">Classe</label><select name="classe_id"
                                class="form-control-modern">
                                <option value="">--Aucune--</option>
                                @foreach (App\Models\Classe::all() as $c)
                                    <option value="{{ $c->id }}">{{ $c->designation }}</option>
                                @endforeach
                            </select></div>
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
