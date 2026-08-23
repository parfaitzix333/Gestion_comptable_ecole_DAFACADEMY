@extends('base.base_promoteur')

@section('content')
    <div class="container-fluid py-4">

        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-chart-line text-success"></i>
                    Tableau de bord
                </h2>

                <p class="text-muted mb-0">
                    Bienvenue {{ $user->name }}
                </p>
            </div>

            <div>
                <span class="badge bg-success fs-6">
                    {{ $user->anneeScolaire->annee ?? 'Année non définie' }}
                </span>
            </div>

        </div>


        {{-- STATISTIQUES GÉNÉRALES --}}
        <div class="row g-4 mb-4">

            {{-- Élèves --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>
                                <h6 class="text-muted">
                                    Élèves
                                </h6>

                                <h2 class="fw-bold">
                                    {{ $nb_elevees }}
                                </h2>
                            </div>

                            <div class="text-primary fs-1">
                                <i class="fas fa-user-graduate"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Classes --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h6 class="text-muted">
                                    Classes
                                </h6>

                                <h2 class="fw-bold">
                                    {{ $nb_classes }}
                                </h2>

                            </div>

                            <div class="text-success fs-1">
                                <i class="fas fa-school"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Enseignants --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h6 class="text-muted">
                                    Enseignants
                                </h6>

                                <h2 class="fw-bold">
                                    {{ $nb_enseignants }}
                                </h2>

                            </div>

                            <div class="text-warning fs-1">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Utilisateurs --}}
            <div class="col-md-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h6 class="text-muted">
                                    Utilisateurs
                                </h6>

                                <h2 class="fw-bold">
                                    {{ $nb_utilisateurs }}
                                </h2>

                            </div>

                            <div class="text-danger fs-1">
                                <i class="fas fa-users"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ÉLÈVES PAR SECTION --}}
        <div class="row g-4 mb-4">

            <div class="col-lg-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white fw-bold">
                        <i class="fas fa-child text-info"></i>
                        Maternelle
                    </div>

                    <div class="card-body">

                        <div class="row text-center">

                            <div class="col-6">
                                <h3 class="text-success">
                                    {{ $nb_eleves_reguliers_paiement_maternelle }}
                                </h3>

                                <small class="text-muted">
                                    Élèves réguliers
                                </small>
                            </div>

                            <div class="col-6">
                                <h3 class="text-danger">
                                    {{ $nb_eleves_irreguliers_paiement_maternelle }}
                                </h3>

                                <small class="text-muted">
                                    Élèves irréguliers
                                </small>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-lg-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white fw-bold">
                        <i class="fas fa-book text-primary"></i>
                        Primaire
                    </div>

                    <div class="card-body">

                        <div class="row text-center">

                            <div class="col-6">

                                <h3 class="text-success">
                                    {{ $nb_eleves_reguliers_paiement_primaire }}
                                </h3>

                                <small class="text-muted">
                                    Élèves réguliers
                                </small>

                            </div>

                            <div class="col-6">

                                <h3 class="text-danger">
                                    {{ $nb_eleves_irreguliers_paiement_primaire }}
                                </h3>

                                <small class="text-muted">
                                    Élèves irréguliers
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- FINANCES --}}
        <div class="row g-4">

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h6 class="text-muted">
                            Total frais scolaires
                        </h6>

                        <h3 class="fw-bold text-primary">
                            {{ number_format($mnt_total, 0, ',', ' ') }}
                        </h3>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h6 class="text-muted">
                            Montant encaissé
                        </h6>

                        <h3 class="fw-bold text-success">
                            {{ number_format($montant_paye, 0, ',', ' ') }}
                        </h3>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h6 class="text-muted">
                            Acomptes
                        </h6>

                        <h3 class="fw-bold text-warning">
                            {{ number_format($montant_acompte, 0, ',', ' ') }}
                        </h3>

                    </div>

                </div>

            </div>

        </div>


        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-chart-bar text-primary"></i>
                Évolution des montants perçus vs dus par année scolaire
            </div>

            <div class="card-body">
                @php
                    $maxMontant = 1;
                    if ($histogramme_paiements->isNotEmpty()) {
                        $maxMontant = max($histogramme_paiements->max('du'), $histogramme_paiements->max('percu'), 1);
                    }
                @endphp

                @if ($histogramme_paiements->isNotEmpty())
                    <div class="d-flex align-items-end gap-3" style="height: 260px;">
                        @foreach ($histogramme_paiements as $item)
                            @php
                                $hauteurDu = $maxMontant > 0 ? ($item['du'] / $maxMontant) * 100 : 0;
                                $hauteurPercu = $maxMontant > 0 ? ($item['percu'] / $maxMontant) * 100 : 0;
                            @endphp
                            <div class="flex-fill text-center">
                                <div class="d-flex align-items-end justify-content-center gap-1" style="height: 200px;">
                                    <div class="bg-primary rounded-top"
                                        title="Montant dû : {{ number_format($item['du'], 0, ',', ' ') }} F"
                                        style="width: 28%; height: {{ max(10, $hauteurDu) }}%; min-height: 10px;"></div>
                                    <div class="bg-success rounded-top"
                                        title="Montant perçu : {{ number_format($item['percu'], 0, ',', ' ') }} F"
                                        style="width: 28%; height: {{ max(10, $hauteurPercu) }}%; min-height: 10px;"></div>
                                </div>
                                <div class="mt-2 small text-muted fw-bold">{{ $item['annee'] }}</div>
                                <div class="small">
                                    <span class="text-primary">{{ number_format($item['du'], 0, ',', ' ') }}</span>
                                    <br>
                                    <span class="text-success">{{ number_format($item['percu'], 0, ',', ' ') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center gap-4 mt-3 small">
                        <span><span class="badge bg-primary rounded-pill">&nbsp;</span> Montant dû</span>
                        <span><span class="badge bg-success rounded-pill">&nbsp;</span> Montant perçu</span>
                    </div>
                @else
                    <div class="text-muted text-center py-4">Aucune donnée disponible pour le moment.</div>
                @endif
            </div>
        </div>

        {{-- PAIEMENTS --}}
        <div class="card border-0 shadow-sm mt-4">

            <div class="card-header bg-white fw-bold">
                <i class="fas fa-credit-card"></i>
                Situation des paiements
            </div>

            <div class="card-body">

                <div class="row g-3 text-center">

                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <h6 class="text-uppercase text-muted mb-3">Primaire</h6>

                            <div class="row text-center">
                                <div class="col-4">
                                    <h4 class="text-success mb-1">{{ $nb_paiements_payes_primaire }}</h4>
                                    <small class="text-muted">Complets</small>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-warning mb-1">{{ $nb_paiements_acompte_primaire }}</h4>
                                    <small class="text-muted">Acomptes</small>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-primary mb-1">{{ $nb_paiements_total_primaire }}</h4>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <h6 class="text-uppercase text-muted mb-3">Maternelle</h6>

                            <div class="row text-center">
                                <div class="col-4">
                                    <h4 class="text-success mb-1">{{ $nb_paiements_payes_maternelle }}</h4>
                                    <small class="text-muted">Complets</small>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-warning mb-1">{{ $nb_paiements_acompte_maternelle }}</h4>
                                    <small class="text-muted">Acomptes</small>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-primary mb-1">{{ $nb_paiements_total_maternelle }}</h4>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-4 border-top pt-3">
                    <div class="row text-center">

                        <div class="col-md-4">
                            <h3 class="text-success">{{ $nb_paiements_payes }}</h3>
                            <span class="text-muted">Paiements complets</span>
                        </div>

                        <div class="col-md-4">
                            <h3 class="text-warning">{{ $nb_paiements_acompte }}</h3>
                            <span class="text-muted">Acomptes</span>
                        </div>

                        <div class="col-md-4">
                            <h3 class="text-primary">{{ $nb_paiements_total }}</h3>
                            <span class="text-muted">Total paiements</span>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
