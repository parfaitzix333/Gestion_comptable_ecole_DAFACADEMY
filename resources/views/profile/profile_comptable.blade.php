@extends('base.base_comptable')
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1"><i class="fas fa-chart-line text-primary"></i> Tableau de bord</h2>
                <p class="text-muted mb-0">Situation des paiements et effectifs des élèves</p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted">Total élèves</span>
                            <i class="fas fa-user-graduate text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $nb_eleves_total }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted">Élèves primaire</span>
                            <i class="fas fa-school text-info"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $nb_eleves_primaire }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted">Élèves maternelle</span>
                            <i class="fas fa-child text-success"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $nb_eleves_maternelle }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-credit-card"></i> Situation des paiements
            </div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <h6 class="text-uppercase text-muted mb-3">Primaire</h6>
                            <div class="row">
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
                            <div class="row">
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
