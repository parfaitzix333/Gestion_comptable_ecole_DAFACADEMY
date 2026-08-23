@extends('base.base_promoteur')
@section('content')
    @include('promoteur._shared_styles')

    <div class="content-wrapper">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-info-circle"></i> Informations du Système</h2>
                    <p>Gérez les propriétés et informations affichées</p>
                </div>
                <div>
                    <button class="btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#createPropModal"><i
                            class="fas fa-plus-circle"></i> Nouvelle Propriété</button>
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
                const rows = document.querySelectorAll('#proprioTable tbody tr');

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
            <table class="table table-striped" id="proprioTable">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Titre</th>
                        <th>Information</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nos_info as $p)
                        <tr>
                            <td class="fw-bold text-primary">#{{ $p->id }}</td>
                            <td>{{ $p->titre }}</td>
                            <td>{{ Str::limit($p->information, 80) }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editPropModal{{ $p->id }}"><i
                                            class="fas fa-edit"></i></button>
                                    <form action="{{ route('proprietes.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)">@csrf @method('DELETE')<button
                                            class="btn-icon btn-delete"><i class="fas fa-trash-alt"></i></button></form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade modal-modern" id="editPropModal{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier Propriété</h5><button class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('proprietes.update', $p->id) }}" method="POST">@csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group"><label class="form-label">Titre</label><input
                                                    name="titre" class="form-control-modern" value="{{ $p->titre }}"
                                                    required></div>
                                            <div class="form-group"><label class="form-label">Information</label>
                                                <textarea name="information" class="form-control-modern">{{ $p->information }}</textarea>
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
                            <td colspan="4" class="text-center">
                                <div class="empty-state"><i class="fas fa-info-circle"></i>
                                    <h4>Aucune propriété</h4>
                                    <p>Ajoutez des informations pour le site</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade modal-modern" id="createPropModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle Propriété</h5><button class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('proprietes.store') }}" method="POST">@csrf
                    <div class="modal-body">
                        <div class="form-group"><label class="form-label">Titre</label><input name="titre"
                                class="form-control-modern" required></div>
                        <div class="form-group"><label class="form-label">Information</label>
                            <textarea name="information" class="form-control-modern"></textarea>
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
