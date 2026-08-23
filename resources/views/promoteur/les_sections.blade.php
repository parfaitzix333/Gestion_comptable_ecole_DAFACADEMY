@extends('base.base_promoteur')
@section('content')
    @include('promoteur._shared_styles')

    <div class="content-wrapper">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-layer-group"></i> Gestion des Sections</h2>
                    <p>Ajouter, modifier ou supprimer des sections</p>
                </div>
                <div>
                    <button class="btn-modern btn-primary-modern" data-bs-toggle="modal"
                        data-bs-target="#createSectionModal"><i class="fas fa-plus-circle"></i> Nouvelle Section</button>
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
                const rows = document.querySelectorAll('#sectionTable tbody tr');

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
            <table class="table table-striped" id="sectionTable">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Désignation</th>
                        <th>Nombre de Classes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($les_sections as $s)
                        <tr>
                            <td class="fw-bold text-primary">#{{ $s->id }}</td>
                            <td>{{ $s->designation }}</td>
                            <td>{{ $s->classes->count() ?? 0 }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editSectionModal{{ $s->id }}"><i
                                            class="fas fa-edit"></i></button>
                                    <form action="{{ route('sections.destroy', $s->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)">@csrf @method('DELETE')<button
                                            class="btn-icon btn-delete"><i class="fas fa-trash-alt"></i></button></form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade modal-modern" id="editSectionModal{{ $s->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier Section</h5><button class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('sections.update', $s->id) }}" method="POST">@csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group"><label class="form-label">Désignation</label><input
                                                    name="designation" class="form-control-modern"
                                                    value="{{ $s->designation }}"></div>
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
                            <td colspan="3" class="text-center">
                                <div class="empty-state"><i class="fas fa-layer-group"></i>
                                    <h4>Aucune section</h4>
                                    <p>Ajoutez des sections</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade modal-modern" id="createSectionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle Section</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('sections.store') }}" method="POST">@csrf
                    <div class="modal-body">
                        <div class="form-group"><label class="form-label">Désignation</label>
                            <select name="designation" class="form-control-modern" required>
                                <option value="">Sélectionnez une désignation</option>
                                <option value="Maternelle">Maternelle</option>
                                <option value="Primaire">Primaire</option>
                                <option value="Humanitaire">Humanitaire</option>
                            </select>
                        </div>
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
