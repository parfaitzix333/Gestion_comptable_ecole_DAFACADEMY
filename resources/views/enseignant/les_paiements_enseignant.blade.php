@extends('base.base_enseignant')

@section('content')
    @include('promoteur._shared_styles')

    <div class="container py-4">
        <h4 class="mb-4">Gestion des paiements</h4>

        <!-- Formulaire de sélection du frais -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('enseignant.paiements.search') }}" method="get" onchange="this.form.submit()">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label for="le_frais_id" class="form-label fw-bold">Sélectionner un frais</label>
                            <select class="form-select" name="le_frais_id" id="le_frais_id">
                                <option value="">-- Sélectionner --</option>
                                @forelse ($les_frais_classe as $frais)
                                    <option value="{{ $frais->id }}" @if (isset($fraisSelectionne) && $fraisSelectionne->id == $frais->id) selected @endif>
                                        {{ $frais->designation }} - {{ number_format($frais->montant, 2, ',', ' ') }}
                                        {{ $frais->devise ?? 'FCFA' }}
                                    </option>
                                @empty
                                    <option value="" disabled>Aucun frais disponible</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary mt-3 mt-md-0">
                                <i class="fa fa-search"></i> Rechercher
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Affichage des résultats -->
        @if (isset($fraisSelectionne) && $fraisSelectionne)
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> Affichage des paiements pour :
                <strong>{{ $fraisSelectionne->designation }}</strong>
                (Montant total : {{ number_format($fraisSelectionne->montant, 2, ',', ' ') }}
                {{ $fraisSelectionne->devise ?? 'FCFA' }})
            </div>

            <div class="row">
                <!-- Tableau des élèves en ordre -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fa fa-check-circle"></i> Élèves en ordre ({{ $les_payements_eleves->count() }})
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if ($les_payements_eleves->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Matricule</th>
                                                <th>Nom</th>
                                                <th>Statut</th>
                                                <th>Classe</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($les_payements_eleves as $paiement)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $paiement->eleve->matricule ?? 'N/A' }}</td>
                                                    <td>{{ $paiement->eleve->nom ?? 'N/A' }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $paiement->statut == 'payé' ? 'success' : 'warning' }}">
                                                            {{ $paiement->statut == 'payé' ? 'Payé' : 'Acompte' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $paiement->classe->designation ?? '--' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center p-4 text-muted">
                                    <i class="fa fa-info-circle"></i> Aucun paiement enregistré pour ce frais
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tableau des élèves litigieux -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="fa fa-exclamation-triangle"></i> Élèves non payeurs
                                ({{ $les_eleves_irreguliers->count() }})
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if ($les_eleves_irreguliers->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Matricule</th>
                                                <th>Nom</th>
                                                <th>Statut</th>
                                                <th>Classe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($les_eleves_irreguliers as $eleve)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $eleve->matricule }}</td>
                                                    <td>{{ $eleve->nom }}</td>
                                                    <td>
                                                        <span class="badge bg-danger">Non payé</span>
                                                    </td>
                                                    <td>{{ $eleve->classe->designation ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center p-4 text-success">
                                    <i class="fa fa-check-circle"></i> Tous les élèves ont payé ce frais !
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Résumé -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-around">
                                <div>
                                    <span class="fw-bold">Total élèves :</span>
                                    {{ $les_payements_eleves->count() + $les_eleves_irreguliers->count() }}
                                </div>
                                <div>
                                    <span class="fw-bold text-success">En ordre :</span>
                                    {{ $les_payements_eleves->count() }}
                                </div>
                                <div>
                                    <span class="fw-bold text-danger">Litigieux :</span>
                                    {{ $les_eleves_irreguliers->count() }}
                                </div>
                                <div>
                                    <span class="fw-bold">Taux de paiement :</span>
                                    @php
                                        $total = $les_payements_eleves->count() + $les_eleves_irreguliers->count();
                                        $taux =
                                            $total > 0 ? round(($les_payements_eleves->count() / $total) * 100, 2) : 0;
                                    @endphp
                                    {{ $taux }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-secondary text-center py-5">
                <i class="fa fa-hand-pointer fa-3x d-block mb-3"></i>
                <h5>Aucun frais sélectionné</h5>
                <p class="text-muted">Veuillez sélectionner un frais dans la liste déroulante ci-dessus pour voir les
                    paiements.</p>
            </div>
        @endif
    </div>
@endsection
