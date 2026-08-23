@extends('base.base_promoteur')

@section('content')
    @include('promoteur._shared_styles')

    <style>
        /* Styles pour le formulaire de filtre */
        #filterForm .form-control-modern {
            width: 100%;
            max-width: 350px;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            outline: none;
            background: white;
        }

        #filterForm .form-control-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        #filterForm label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
        }

        #filterForm label i {
            margin-right: 0.5rem;
            color: #667eea;
        }

        .table-header {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-radius: 1rem 1rem 0 0;
            border-bottom: 2px solid #e5e7eb;
        }

        .table-header h5 {
            font-weight: 700;
            color: #1f2937;
        }

        .btn-toggle {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
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

        .btn-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .frais-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            margin: 0.2rem;
            border-radius: 2rem;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .frais-badge.paye {
            background: #d1fae5;
            color: #065f46;
        }

        .frais-badge.non-paye {
            background: #fee2e2;
            color: #991b1b;
        }

        .frais-badge.partiel {
            background: #fef3c7;
            color: #92400e;
        }

        /* Styles pour le modal de paiement */
        .modal-paiement .modal-body {
            padding: 1.5rem;
        }

        .modal-paiement .eleve-info {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #667eea;
        }

        .modal-paiement .eleve-info strong {
            color: #1f2937;
        }

        @media (max-width: 768px) {
            #filterForm .form-control-modern {
                max-width: 100%;
            }

            .table-header {
                flex-direction: row;
                align-items: flex-start !important;
                gap: 0.5rem;
            }

            .frais-badge {
                display: block;
                margin: 0.25rem 0;
            }

            tr {
                width: 100%;
            }

            tr * {
                flex-direction: row;
            }
        }

        .frais-container {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            gap: 6px;
            width: max-content;
        }

        .frais-badge {
            flex: 0 0 auto;
            white-space: nowrap;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2><i class="fas fa-credit-card"></i> Gestion des Paiements</h2>
                    <p>Historique et création de paiements</p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-modern alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-modern alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Section Élèves par classe -->
        <div>
            <!-- Formulaire de sélection de classe -->
            <form action="{{ route('eleves_par_classe') }}" method="GET" id="filterForm">
                @csrf
                <div class="form-group">
                    <label for="classe_id" class="form-label">
                        <i class="fas fa-filter"></i> Filtrer par classe
                    </label>
                    <select name="classe_id" id="classe_id" class="form-control-modern" onchange="this.form.submit()">
                        <option value="">Toutes les classes</option>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                {{ $classe->designation }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            <!-- Affichage des résultats -->
            @isset($les_eleves_par_classe)
                @if ($les_eleves_par_classe->count() > 0)
                    <div class="table-container mt-3">
                        <div class="table-header d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">
                                <i class="fas fa-user-graduate text-primary"></i>
                                Liste des élèves
                                <span class="badge bg-primary ms-2">{{ $les_eleves_par_classe->count() }}</span>
                            </h5>
                            @if (request('classe_id'))
                                <span class="text-muted small">
                                    <i class="fas fa-filter me-1"></i>
                                    Classe:
                                    <strong>{{ $classes->find(request('classe_id'))?->designation ?? 'Toutes' }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="table-wrapper">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Matricule</th>
                                        <th>Nom Complet</th>
                                        <th>Classe</th>
                                        <th>Frais</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($les_eleves_par_classe as $eleve)
                                        @php
                                            $fraisEleve = App\Models\Frais::where('classe_id', $eleve->classe_id)
                                                ->with([
                                                    'paiements' => function ($query) use ($eleve) {
                                                        $query->where('eleve_id', $eleve->id);
                                                    },
                                                ])
                                                ->get();
                                        @endphp
                                        <tr>
                                            <td class="fw-bold text-primary">#{{ $eleve->id }}</td>
                                            <td>
                                                <span class="badge bg-info text-dark">{{ $eleve->matricule ?? '—' }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div
                                                        class="rounded-circle bg-primary bg-opacity-10 p-2 d-none d-sm-inline-flex">
                                                        <i class="fas fa-user-circle text-primary"></i>
                                                    </div>
                                                    <span class="fw-semibold">{{ $eleve->nom }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $eleve->classe->designation ?? 'Non défini' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="frais-container">
                                                    @forelse ($fraisEleve as $frais)
                                                        @php
                                                            $paiementExiste = $frais->paiements
                                                                ->where('eleve_id', $eleve->id)
                                                                ->first();

                                                            $estPaye =
                                                                $paiementExiste && $paiementExiste->statut === 'payé';
                                                            $estAcompte =
                                                                $paiementExiste &&
                                                                $paiementExiste->statut === 'acompte';
                                                            $montantPaye = $paiementExiste
                                                                ? $paiementExiste->montant
                                                                : 0;
                                                        @endphp

                                                        <span
                                                            class="frais-badge {{ $estPaye ? 'paye' : ($estAcompte ? 'partiel' : 'non-paye') }}">
                                                            {{ $frais->designation }}
                                                            [{{ number_format($frais->montant, 0) }} {{ $frais->devise }}]

                                                            @if ($estPaye)
                                                                <i class="fas fa-check-circle text-success"></i>
                                                            @elseif ($estAcompte)
                                                                <i class="fas fa-clock text-warning"></i>
                                                                ({{ number_format($montantPaye, 0) }})
                                                            @else
                                                                <i class="fas fa-times-circle text-danger"></i>
                                                            @endif
                                                        </span>

                                                    @empty
                                                        <span class="text-muted small">Aucun frais</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-icon btn-toggle" data-bs-toggle="modal"
                                                        data-bs-target="#createPaiementModal{{ $eleve->id }}"
                                                        title="Effectuer un paiement">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal de paiement par élève -->
                                        <div class="modal fade modal-modern modal-paiement"
                                            id="createPaiementModal{{ $eleve->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-plus-circle text-success"></i>
                                                            Nouveau Paiement
                                                        </h5>
                                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('paiements.store') }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <!-- Informations de l'élève -->
                                                            <div class="eleve-info">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <strong><i class="fas fa-user"></i> Élève :</strong>
                                                                        <span class="ms-2">{{ $eleve->nom }}</span>
                                                                    </div>
                                                                    <span class="badge bg-info text-dark">
                                                                        {{ $eleve->matricule ?? 'N/A' }}
                                                                    </span>
                                                                </div>
                                                                <div class="mt-1">
                                                                    <strong><i class="fas fa-school"></i> Classe :</strong>
                                                                    <span
                                                                        class="ms-2">{{ $eleve->classe->designation ?? 'Non définie' }}</span>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" name="eleve_id" value="{{ $eleve->id }}">

                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    <i class="fas fa-file-invoice"></i> Frais
                                                                </label>
                                                                <select name="frais_id" class="form-control-modern" required>
                                                                    <option value="">-- Sélectionner un frais --</option>
                                                                    @foreach (App\Models\Frais::where('classe_id', $eleve->classe_id)->orderBy('designation')->get() as $f)
                                                                        <option value="{{ $f->id }}">
                                                                            {{ $f->designation }}
                                                                            - {{ number_format($f->montant, 2) }}
                                                                            {{ $f->devise }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    <i class="fas fa-money-bill"></i> Montant
                                                                </label>
                                                                <input type="number" step="0.01" name="montant"
                                                                    class="form-control-modern"
                                                                    placeholder="Laisser vide pour le montant total">
                                                                <small class="text-muted mt-1 d-block">
                                                                    <i class="fas fa-info-circle"></i> Laissez vide pour payer
                                                                    le montant total du frais
                                                                </small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    <i class="fas fa-hand-holding-usd"></i> Mode de paiement
                                                                </label>
                                                                <select name="mode_paiement" id="mode_paiement"
                                                                    class="form-select" required>
                                                                    <option value="">--Selectionner mode de paiement--
                                                                    </option>
                                                                    @foreach (['Espèce', 'Mobile Money', 'Virement'] as $mode)
                                                                        <option value="{{ $mode }}">
                                                                            {{ $mode }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if (method_exists($les_eleves_par_classe, 'links'))
                            <div class="mt-3">
                                {{ $les_eleves_par_classe->links() }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="empty-state mt-3">
                        <i class="fas fa-user-slash"></i>
                        <h4>Aucun élève trouvé</h4>
                        <p class="text-muted">
                            @if (request('classe_id'))
                                Aucun élève n'est inscrit dans cette classe.
                            @else
                                Aucun élève n'est enregistré dans le système.
                            @endif
                        </p>
                    </div>
                @endif
            @endisset
        </div>

        <!-- Section Historique des paiements -->
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3><i class="fas fa-history text-primary"></i> Historique des paiements</h3>
                <span class="badge bg-secondary">{{ $les_paiements->count() }} paiement(s)</span>
            </div>

            <div class="input-group w-75 mb-3" id="searchInputContainer">
                <input type="search" id="searchInput" class="form-control"
                    placeholder="Rechercher par élève, frais ou statut..." autocomplete="off">
                <span class="input-group-text bg-primary text-white">
                    <i class="fas fa-search"></i>
                </span>
            </div>

            <div class="d-flex gap-2 align-items-end mb-3">
                <div style="min-width:140px;">
                    <label class="form-label small mb-1">Statut</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">Tous</option>
                        <option value="payé">Payé</option>
                        <option value="acompte">Acompte</option>
                        <option value="non payé">Non payé</option>
                    </select>
                </div>

                <div style="min-width:180px;">
                    <label class="form-label small mb-1">Classe</label>
                    <select id="classeFilter" class="form-select">
                        <option value="">Toutes les classes</option>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->designation }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="min-width:220px;">
                    <label class="form-label small mb-1">Frais</label>
                    <select id="fraisFilter" class="form-select">
                        <option value="">Tous les frais</option>
                        @php
                            $fraisList = $les_paiements->pluck('frais')->filter()->unique('id');
                        @endphp
                        @foreach ($fraisList as $f)
                            <option value="{{ $f->id }}">{{ $f->designation }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="ms-auto text-end d-flex flex-column align-items-end">
                    <label class="form-label small mb-1">Résultats</label>
                    <div class="d-flex gap-2 align-items-center">
                        <span id="visibleCount" class="badge bg-primary">0</span>
                        <button id="resetFilters" type="button"
                            class="btn btn-sm btn-outline-secondary no-print">Réinitialiser</button>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="table-wrapper">
                    <table class="table table-striped" id="payTable">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Élève</th>
                                <th>Classe</th>
                                <th>Frais</th>
                                <th>Échéance</th>
                                <th>Montant</th>
                                <th>Montant En Lettres</th>
                                <th>Statut</th>
                                <th>Mode de Pay</th>
                                <th>Date paiement</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($les_paiements as $p)
                                <tr data-statut="{{ $p->statut ?? '' }}" data-frais-id="{{ $p->frais?->id ?? '' }}"
                                    data-classe-id="{{ $p->eleve?->classe_id ?? '' }}">
                                    <td class="fw-bold text-primary">#{{ $p->id }}</td>
                                    <td>{{ $p->eleve?->nom ?? '—' }}</td>
                                    <td>{{ $p->eleve->classe?->designation ?? '—' }}</td>
                                    <td>{{ $p->frais?->designation ?? '—' }}</td>
                                    <td>
                                        @php
                                            $isOverdue = false;
                                            $dateLimite = $p->frais?->date_limite;
                                            if ($dateLimite) {
                                                $isOverdue = \Carbon\Carbon::parse($dateLimite)->lessThanOrEqualTo(
                                                    \Carbon\Carbon::today(),
                                                );
                                            }
                                        @endphp
                                        @if ($dateLimite)
                                            <span
                                                class="{{ $isOverdue ? 'text-danger fw-bold' : '' }}">{{ \Carbon\Carbon::parse($dateLimite)->format('d/m/Y') }}</span>
                                        @else
                                            <span class="text-muted">Non défini</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ number_format($p->montant, 2) }}
                                            {{ $p->devise }}</span>
                                    </td>
                                    <td><small class="text-muted">{{ $p->montant_en_lettre }}</small></td>
                                    <td>
                                        <span
                                            class="status-badge {{ $p->statut == 'payé' ? 'status-active' : 'status-inactive' }}">
                                            <i
                                                class="fas {{ $p->statut == 'payé' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                            {{ ucfirst($p->statut) }}
                                        </span>
                                    </td>
                                    <td>{{ $p->mode_paiement }}</td>
                                    <td>
                                        <i class="far fa-calendar-alt me-1 text-muted"></i>
                                        {{ $p->created_at?->format('d/m/Y H:i') ?? '—' }}
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon btn-edit" data-bs-toggle="modal"
                                                data-bs-target="#editPaiementModal{{ $p->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('paiements.destroy', $p->id) }}" method="POST"
                                                onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-icon btn-delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            <button data-bs-target="#zinePrint{{ $p->id }}" data-bs-toggle="modal"
                                                class="btn btn-secondary"><small>Facture</small>
                                            </button>
                                        </div>



                                        <!-- Edit Modal -->
                                        <div class="modal fade modal-modern" id="editPaiementModal{{ $p->id }}"
                                            tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-edit"></i> Modifier le
                                                            paiement #{{ $p->id }}
                                                        </h5>
                                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('paiements.update', $p->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    <i class="fas fa-money-bill"></i>
                                                                    Montant
                                                                </label>
                                                                <input type="number" step="0.01" name="montant"
                                                                    class="form-control-modern"
                                                                    value="{{ $p->montant }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    <i class="fas fa-hand-holding-usd"></i>
                                                                    Mode de paiement
                                                                </label>
                                                                <select name="mode_paiement" id="mode_paiement"
                                                                    class="form-select">
                                                                    <option value="">--Selectionner
                                                                        mode de paiement--</option>
                                                                    @foreach (['Espèce', 'Mobile Money', 'Virement'] as $mode)
                                                                        <option value="{{ $mode }}"
                                                                            {{ $p->mode_paiement == $mode ? 'selected' : '' }}>
                                                                            {{ $mode }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    <i class="fas fa-tag"></i> Statut
                                                                </label>
                                                                <select name="statut" class="form-control-modern"
                                                                    required>
                                                                    <option value="payé"
                                                                        {{ $p->statut == 'payé' ? 'selected' : '' }}>
                                                                        Payé
                                                                    </option>
                                                                    <option value="acompte"
                                                                        {{ $p->statut == 'acompte' ? 'selected' : '' }}>
                                                                        Acompte
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
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











                                        <!--modal pour impression-->
                                        <div class="modal fade" id="zinePrint{{ $p->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <button class="btn btn-primary text-light  no-print"
                                                            onclick="window.print()">Imprimer</button>



                                                        <!-- Zone à imprimer -->
                                                        <div class="zoneAimprimer" id="zoneAimprimer{{ $p->id }}"
                                                            class="px-4">

                                                            <div id="EnteteFacture" class="d-flex items-justify-content">

                                                                <img src="{{ asset('image/logo.jpeg') }}"
                                                                    alt="factureLogo" width="70px" height="70px"
                                                                    class="rounded-5 border border-2 border-primary ms-2 mt-2">

                                                                <div class="d-block text-center">

                                                                    <h1 class="text-danger fw-bold">
                                                                        DAF ACADEMY
                                                                    </h1>

                                                                    <h4>
                                                                        <b>INSTITUTION SCOLAIRE BILINGUE</b>
                                                                    </h4>

                                                                    <h4>
                                                                        (Français-Anglais)
                                                                    </h4>

                                                                    <h5>
                                                                        SECTION:
                                                                        {{ $p->eleve->classe->section->designation ?? '--' }}
                                                                    </h5>

                                                                    <h2>
                                                                        Année scolaire :
                                                                        {{ $p->anneeScolaire->annee ?? '--' }}
                                                                    </h2>
                                                                    <div class="text-danger border border-2 border-danger">
                                                                    </div>
                                                                </div>
                                                                <div class="border border-1 border-primary ms-4 p-3"
                                                                    id="num_recu">
                                                                    <h2 class=""><strong class="text-dark">RECU N°:
                                                                            <br>
                                                                        </strong><strong>#{{ $p->id }}</strong>
                                                                    </h2>
                                                                    <hr>
                                                                    <i class="text-dark">Le
                                                                        {{ date('d/m/Y', strtotime($p->created_at)) }}</i>
                                                                </div>
                                                            </div>
                                                            <div class="border border-1 border-primary mt-2">
                                                                <table class="table table-striped">
                                                                    <tr>
                                                                        <td class="bg-dark text-light">Nom de l'élève </td>
                                                                        <td colspan="3">{{ $p->eleve->nom ?? '--' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="bg-dark text-light">Classe</td>
                                                                        <td colspan="2">
                                                                            {{ $p->classe->designation ?? '--' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="bg-dark text-white">Motif</td>
                                                                        <td>{{ $p->frais->designation ?? '--' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="bg-dark text-light">Matricule</td>
                                                                        <td class="bg-dark text-light">Montant</td>
                                                                        <td class="bg-dark text-light" colspan="2">
                                                                            Montant en lettre
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{ $p->eleve->matricule ?? '--' }}</td>
                                                                        <td>{{ $p->devise }}
                                                                            {{ number_format($p->montant, 2) }}</td>
                                                                        <td colspan="2">
                                                                            <i>{{ $p->montant_en_lettre ?? '--' }}</i>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3"
                                                                            class="bg-dark text-light text-center">MODE DE
                                                                            PAIEMENT</td>
                                                                        <td><strong>Etat de Paiement</strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Espèce

                                                                            @if ($p->mode_paiement == 'Espèce')
                                                                                <i
                                                                                    class="fa fa-check-square text-success"></i>
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            Mobile Money

                                                                            @if ($p->mode_paiement == 'Mobile Money')
                                                                                <i
                                                                                    class="fa fa-check-square text-success"></i>
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            Banque

                                                                            @if ($p->mode_paiement == 'Banque' || $p->mode_paiement == 'Banque')
                                                                                <i
                                                                                    class="fa fa-check-square text-success"></i>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <div style="border: solid 1px black; border-radius: 40px;"
                                                                                class="text-center">
                                                                                {{ $p->statut ?? '--' }}</div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <div class="row p-2 pt-4" style="height: 300px">
                                                                    <div class="col">
                                                                        <b>Authentification</b>
                                                                        <p>De la comptabilité</p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b>Signature et nom</b>
                                                                        <p>Du(de la) Caissier(ère)</p>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b>Sceau</b>
                                                                        <p>Sceau scolaire</p>
                                                                    </div>
                                                                </div>

                                                                <div class="ms-3">
                                                                    Nous Contacter:
                                                                    <hr>
                                                                    <strong>Tél: {{ $contacts->tel ?? '--' }}</strong> <br>
                                                                    <strong>Email:
                                                                        {{ $contacts->couriel ?? '--' }}</strong> <br>
                                                                    <strong>Adresse:
                                                                        {{ $contacts->adresse ?? '--' }}</strong>
                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>







                                        <style>
                                            .zoneAimprimer {
                                                display: none;
                                            }

                                            @page {
                                                size: A4 portrait;
                                                margin: 10mm;
                                            }

                                            @media print {

                                                /* Cacher toute la page */
                                                body * {
                                                    visibility: hidden !important;
                                                }

                                                /* Afficher uniquement la facture */
                                                .zoneAimprimer,
                                                .zoneAimprimer * {
                                                    visibility: visible !important;
                                                }

                                                .no-print {
                                                    display: none !important;
                                                }

                                                /* =========================================
                                                                                                                                                                                           FACTURE A4 CENTRÉE
                                                                                                                                                                                           ========================================= */
                                                .zoneAimprimer {
                                                    display: block !important;

                                                    position: absolute;

                                                    top: 0;
                                                    left: 50%;

                                                    /*
                                                                                                                                                                                             * 190mm = largeur A4 (210mm)
                                                                                                                                                                                             * moins 10mm de marge à gauche
                                                                                                                                                                                             * moins 10mm de marge à droite
                                                                                                                                                                                             */
                                                    width: 190mm;

                                                    min-height: 277mm;

                                                    /*
                                                                                                                                                                                             * Centre horizontalement
                                                                                                                                                                                             */
                                                    transform: translateX(-50%);

                                                    padding: 0;

                                                    margin: 0;

                                                    background: #fff !important;
                                                    color: #000 !important;

                                                    box-sizing: border-box;

                                                    border: 2px solid blue;
                                                }

                                                /* =========================================
                                                                                                                                                                                           ENTÊTE FACTURE
                                                                                                                                                                                           ========================================= */
                                                #EnteteFacture {
                                                    width: 100%;
                                                    display: flex !important;
                                                    align-items: flex-start;
                                                    justify-content: space-between !important;
                                                    gap: 15px;
                                                }

                                                #EnteteFacture>div:nth-child(2) {
                                                    flex: 1;
                                                    text-align: center;
                                                }

                                                #num_recu {
                                                    flex-shrink: 0;
                                                    background-color: #bdbfd4fb !important;
                                                    color: #991b1b !important;
                                                    min-width: 120px;
                                                }

                                                /* =========================================
                                                                                                                                                                                           TABLEAU DE LA FACTURE
                                                                                                                                                                                           ========================================= */
                                                .zoneAimprimer table {
                                                    width: 100% !important;
                                                    table-layout: fixed;
                                                    border-collapse: collapse;
                                                }

                                                .zoneAimprimer table td,
                                                .zoneAimprimer table th {
                                                    box-sizing: border-box;
                                                }

                                                /* Éviter que le contenu force les cellules */
                                                .zoneAimprimer table td {
                                                    word-break: normal;
                                                    overflow-wrap: break-word;
                                                }

                                                /* =========================================
                                                                                                                                                                                           SIGNATURES
                                                                                                                                                                                           ========================================= */
                                                .zoneAimprimer .row {
                                                    width: 100%;
                                                    margin-left: 0;
                                                    margin-right: 0;
                                                }
                                            }
                                        </style>










                                    @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-credit-card"></i>
                                            <h4>Aucun paiement</h4>
                                            <p>Créez des paiements manuellement ou via la page des frais</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal Global -->
    <div class="modal fade modal-modern modal-paiement" id="createPaiementGlobalModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle text-success"></i>
                        Nouveau Paiement
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('paiements.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user-graduate"></i> Élève
                            </label>
                            <select name="eleve_id" id="eleve_id" class="form-control-modern" required>
                                <option value="">-- Sélectionner un élève --</option>
                                @foreach (App\Models\Eleve::orderBy('nom')->get() as $e)
                                    <option value="{{ $e->id }}">
                                        {{ $e->nom }} ({{ $e->matricule ?? 'N/A' }})
                                        - {{ $e->classe?->designation ?? 'Sans classe' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-file-invoice"></i> Frais
                            </label>
                            <select name="frais_id" class="form-control-modern" required>
                                <option value="">-- Sélectionner un frais --</option>
                                @foreach (App\Models\Frais::with('classe')->orderBy('designation')->get() as $f)
                                    <option value="{{ $f->id }}">
                                        {{ $f->designation }}
                                        - {{ number_format($f->montant, 2) }} {{ $f->devise }}
                                        @if ($f->classe)
                                            ({{ $f->classe->designation }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-money-bill"></i> Montant
                            </label>
                            <input type="number" step="0.01" name="montant" class="form-control-modern"
                                placeholder="Laisser vide pour le montant total">
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle"></i> Laissez vide pour payer le montant total du frais
                            </small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-hand-holding-usd"></i> Mode de paiement
                            </label>
                            <input type="text" name="mode_paiement" class="form-control-modern"
                                placeholder="Ex: Espèce, Mobile Money, Virement...">
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

    <script>
        function confirmDelete(e) {
            e.preventDefault();
            if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce paiement ? Cette action est irréversible.')) {
                e.target.submit();
            }
            return false;
        }

        function imprimerFacture(paiementId) {
            const facture = document.getElementById('factureAimprimer' + paiementId);

            if (!facture) {
                alert('La facture est introuvable.');
                return;
            }

            window.print();
        }

        // Recherche + filtres combinés dans l'historique
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const classeFilter = document.getElementById('classeFilter');
            const fraisFilter = document.getElementById('fraisFilter');
            const visibleCount = document.getElementById('visibleCount');

            function filterPayments() {
                const q = (searchInput?.value || '').toLowerCase().trim();
                const status = (statusFilter?.value || '').toLowerCase();
                const classeId = (classeFilter?.value || '').toString();
                const fraisId = (fraisFilter?.value || '').toString();
                const rows = document.querySelectorAll('#payTable tbody tr');
                let count = 0;

                rows.forEach(row => {
                    // skip empty-state rows
                    if (row.querySelector('.empty-state')) return;
                    const text = row.innerText.toLowerCase();
                    const rowStatus = (row.getAttribute('data-statut') || '').toLowerCase();
                    const rowClasse = (row.getAttribute('data-classe-id') || '').toString();
                    const rowFrais = (row.getAttribute('data-frais-id') || '').toString();

                    const matchesQuery = q === '' || text.includes(q);
                    const matchesStatus = status === '' || rowStatus === status;
                    const matchesClasse = classeId === '' || rowClasse === classeId;
                    const matchesFrais = fraisId === '' || rowFrais === fraisId;

                    const show = matchesQuery && matchesStatus && matchesClasse && matchesFrais;
                    row.style.display = show ? '' : 'none';
                    if (show) count++;
                });

                if (visibleCount) visibleCount.innerText = count;
            }

            if (searchInput) searchInput.addEventListener('input', filterPayments);
            if (statusFilter) statusFilter.addEventListener('change', filterPayments);
            if (classeFilter) classeFilter.addEventListener('change', filterPayments);
            if (fraisFilter) fraisFilter.addEventListener('change', filterPayments);

            // Auto-fermeture des alertes
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });

            // Reset button handler
            const resetBtn = document.getElementById('resetFilters');
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    if (searchInput) searchInput.value = '';
                    if (statusFilter) statusFilter.value = '';
                    if (classeFilter) classeFilter.value = '';
                    if (fraisFilter) fraisFilter.value = '';
                    filterPayments();
                    if (searchInput) searchInput.focus();
                });
            }

            // Initial filter to set count
            filterPayments();
        });
    </script>

    <style>

    </style>
@endsection
