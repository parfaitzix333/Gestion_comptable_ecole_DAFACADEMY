@extends('base.base_promoteur')

@section('content')
    @include('promoteur._shared_styles')

    <style>
        .table-wrapper {
            position: relative;
        }

        .table-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .table-actions .left-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .table-actions .right-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-clear-all {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 0.5rem 1.25rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-clear-all:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-delete-selected {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 0.5rem 1.25rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            display: none;
        }

        .btn-delete-selected.show {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-delete-selected:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .selection-info {
            font-size: 0.85rem;
            color: #6b7280;
            display: none;
        }

        .selection-info.show {
            display: inline;
        }

        .selection-info strong {
            color: #1f2937;
        }

        /* Checkbox personnalisée */
        .custom-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .custom-checkbox:hover {
            transform: scale(1.1);
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            padding: 1.5rem 0;
        }

        .pagination-container .pagination {
            margin: 0;
        }

        .pagination-container .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
        }

        .pagination-container .page-link {
            color: #667eea;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .pagination-container .page-link:hover {
            background: #f3f4f6;
            border-color: #667eea;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .table-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .table-actions .left-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .table-actions .right-actions {
                justify-content: center;
            }

            .btn-clear-all,
            .btn-delete-selected {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2>
                        <i class="fas fa-history"></i> Historique des actions
                    </h2>
                    <p>Journal des actions réalisées par les utilisateurs</p>
                </div>
                <div>
                    <span class="badge bg-primary text-white rounded-pill px-3 py-2">
                        <i class="fas fa-list me-1"></i>
                        Total: {{ $historiques->total() }} enregistrement(s)
                    </span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-modern alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-modern alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Barre de recherche -->
        <div class="input-group w-75 mb-3" id="searchInputContainer">
            <input type="search" id="searchInput" class="form-control" placeholder="Rechercher par action, utilisateur..."
                autocomplete="off">
            <span class="input-group-text bg-primary text-white">
                <i class="fas fa-search"></i>
            </span>
        </div>

        <!-- Actions du tableau -->
        <div class="table-actions">
            <div class="left-actions">
                <label class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Tout sélectionner</span>
                </label>
                <span class="selection-info" id="selectionInfo">
                    <i class="fas fa-check-circle text-success"></i>
                    <span id="selectedCount">0</span> sélectionné(s)
                </span>
            </div>
            <div class="right-actions">
                <button class="btn-delete-selected" id="deleteSelectedBtn" onclick="deleteSelected()">
                    <i class="fas fa-trash-alt"></i> Supprimer sélectionnés
                </button>
                <button class="btn-clear-all" onclick="clearAll()">
                    <i class="fas fa-trash"></i> Tout supprimer
                </button>
            </div>
        </div>

        <!-- Tableau -->
        <div class="table-wrapper">
            <div class="table-wrapper">
                <form id="deleteForm" action="{{ route('deleteSelected') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <table class="table table-striped" id="historiqueTable">
                        <thead>
                            <tr>
                                <th style="width: 50px;">
                                    <input type="checkbox" id="selectAllCheckbox" class="custom-checkbox"
                                        onchange="toggleAllCheckboxes(this)">
                                </th>
                                <th>#ID</th>
                                <th>Utilisateur</th>
                                <th>Action</th>
                                <th>Date</th>
                                <th style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historiques as $h)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected[]" value="{{ $h->id }}"
                                            class="custom-checkbox row-checkbox" onchange="updateSelectionInfo()">
                                    </td>
                                    <td class="fw-bold text-primary">#{{ $h->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-1">
                                                <i class="fas fa-user-circle text-primary"></i>
                                            </div>
                                            {{ $h->user?->name ?? 'Système' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            <i class="fas fa-info-circle me-1"></i>
                                            {{ $h->action }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="far fa-clock me-1 text-muted"></i>
                                        {{ $h->created_at?->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        <form action="{{ route('historiques.destroy', $h->id) }}" method="POST"
                                            onsubmit="return confirm('Supprimer cet historique ?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-icon btn-delete" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-history"></i>
                                            <h4>Historique vide</h4>
                                            <p>Aucune action enregistrée pour le moment</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>
            </div>

            <!-- Pagination -->
            @if ($historiques->hasPages())
                <div class="pagination-container">
                    {{ $historiques->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==== RECHERCHE ====
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('#historiqueTable tbody tr');

            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const value = this.value.toLowerCase().trim();

                    rows.forEach(row => {
                        if (row.querySelector('.empty-state')) return;
                        const text = row.innerText.toLowerCase();
                        row.style.display = text.includes(value) ? '' : 'none';
                    });
                });
            }

            // ==== SELECTION TOUT ====
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    rowCheckboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateSelectionInfo();
                });
            }

            // ==== MISE À JOUR DES INFOS DE SELECTION ====
            window.updateSelectionInfo = function() {
                const checkboxes = document.querySelectorAll('.row-checkbox:checked');
                const count = checkboxes.length;
                const selectionInfo = document.getElementById('selectionInfo');
                const deleteBtn = document.getElementById('deleteSelectedBtn');
                const selectedCount = document.getElementById('selectedCount');

                if (count > 0) {
                    selectionInfo.classList.add('show');
                    if (selectedCount) selectedCount.textContent = count;
                    deleteBtn.classList.add('show');
                } else {
                    selectionInfo.classList.remove('show');
                    deleteBtn.classList.remove('show');
                }
            };

            // ==== SUPPRESSION SÉLECTIONNÉS ====
            window.deleteSelected = function() {
                const checkboxes = document.querySelectorAll('.row-checkbox:checked');
                if (checkboxes.length === 0) {
                    alert('Veuillez sélectionner au moins un historique à supprimer.');
                    return;
                }

                if (confirm('⚠️ Supprimer les ' + checkboxes.length +
                        ' historiques sélectionnés ? Cette action est irréversible.')) {
                    document.getElementById('deleteForm').submit();
                }
            };

            // ==== TOUT SUPPRIMER ====
            window.clearAll = function() {
                const total = {{ $historiques->total() }};
                if (total === 0) {
                    alert('Aucun historique à supprimer.');
                    return;
                }

                if (confirm('⚠️ Supprimer TOUS les ' + total +
                        ' historiques ? Cette action est irréversible.')) {
                    window.location.href = '{{ route('historiques.clearAll') }}';
                }
            };

            // ==== TOGGLE TOUS LES CHECKBOXES ====
            window.toggleAllCheckboxes = function(checkbox) {
                document.querySelectorAll('.row-checkbox').forEach(cb => {
                    cb.checked = checkbox.checked;
                });
                updateSelectionInfo();
            };

            // ==== AUTO-FERMETURE DES ALERTES ====
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });

            // Initialisation
            updateSelectionInfo();
        });
    </script>
@endsection
