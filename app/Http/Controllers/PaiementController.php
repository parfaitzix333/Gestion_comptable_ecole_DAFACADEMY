<?php

namespace App\Http\Controllers;

use App\Models\Annee_scolaire;
use App\Models\Classe;
use App\Models\Contact;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Historique;
use App\Models\Paiement;
use App\Models\Frais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaiementController extends Controller
{
    public function historiqueAction($action)
    {
        Historique::create([
            'action' => $action,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Convertir un nombre en lettres en français (fallback)
     * Méthode utilisée si NumberFormatter n'est pas disponible
     */
    private function numberToWordsFr($number)
    {
        if (!is_numeric($number)) {
            return '';
        }

        $number = intval($number);

        $units = [
            '',
            'un',
            'deux',
            'trois',
            'quatre',
            'cinq',
            'six',
            'sept',
            'huit',
            'neuf',
            'dix',
            'onze',
            'douze',
            'treize',
            'quatorze',
            'quinze',
            'seize',
            'dix-sept',
            'dix-huit',
            'dix-neuf'
        ];
        $tens = ['', '', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt', 'quatre-vingt-dix'];

        if ($number < 20) {
            return $units[$number];
        } elseif ($number < 100) {
            $unit = $number % 10;
            $ten = intval($number / 10);
            if ($unit == 0) {
                return $tens[$ten];
            } elseif ($ten == 7 || $ten == 9) {
                return $tens[$ten] . '-' . ($unit == 1 ? 'et-un' : $units[$unit]);
            } else {
                return $tens[$ten] . '-' . $units[$unit];
            }
        } elseif ($number < 1000) {
            $hundred = intval($number / 100);
            $remainder = $number % 100;
            if ($hundred == 1) {
                $result = 'cent';
            } else {
                $result = $units[$hundred] . ' cent' . ($remainder == 0 ? '' : 's');
            }
            if ($remainder > 0) {
                $result .= ' ' . $this->numberToWordsFr($remainder);
            }
            return $result;
        } elseif ($number < 1000000) {
            $thousand = intval($number / 1000);
            $remainder = $number % 1000;
            if ($thousand == 1) {
                $result = 'mille';
            } else {
                $result = $this->numberToWordsFr($thousand) . ' mille';
            }
            if ($remainder > 0) {
                $result .= ' ' . $this->numberToWordsFr($remainder);
            }
            return $result;
        } elseif ($number < 1000000000) {
            $million = intval($number / 1000000);
            $remainder = $number % 1000000;
            if ($million == 1) {
                $result = 'un million';
            } else {
                $result = $this->numberToWordsFr($million) . ' millions';
            }
            if ($remainder > 0) {
                $result .= ' ' . $this->numberToWordsFr($remainder);
            }
            return $result;
        } else {
            return (string) $number;
        }
    }

    /**
     * Convertir un montant en lettres avec la devise
     * Utilise NumberFormatter si disponible, sinon la méthode de fallback
     */
    private function convertirMontantEnLettres($montant, $devise = '')
    {
        if (!is_numeric($montant)) {
            return '';
        }

        $partieEntiere = intval($montant);
        $partieDecimale = round(($montant - $partieEntiere) * 100);

        $lettres = '';

        // Convertir la partie entière
        if (class_exists('NumberFormatter')) {
            try {
                $fmt = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
                $lettres = $fmt->format($partieEntiere);
            } catch (\Throwable $e) {
                Log::warning('NumberFormatter failed: ' . $e->getMessage());
                $lettres = $this->numberToWordsFr($partieEntiere);
            }
        } else {
            $lettres = $this->numberToWordsFr($partieEntiere);
        }

        // Ajouter la devise
        if (!empty($devise)) {
            $lettres .= ' ' . $devise;
        }

        // Ajouter la partie décimale si présente
        if ($partieDecimale > 0) {
            $lettres .= ' et ';
            if (class_exists('NumberFormatter')) {
                try {
                    $fmt = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
                    $lettres .= $fmt->format($partieDecimale) . ' centimes';
                } catch (\Throwable $e) {
                    $lettres .= $this->numberToWordsFr($partieDecimale) . ' centimes';
                }
            } else {
                $lettres .= $this->numberToWordsFr($partieDecimale) . ' centimes';
            }
        }

        return ucfirst($lettres);
    }

    public function index()
    {
        $user = Auth::user();
        $les_paiements = Paiement::with(['eleve', 'frais', 'classe'])
            ->where('annee_scolaire_id', $user->anne_scolaire_id)
            ->orderBy('created_at', 'desc')->get();
        $anneeActive = Annee_scolaire::where('statut', 'actif')->first();
        $contacts = Contact::first();

        if ($anneeActive) {
            $classes = Classe::where('annee_scolaire_id', $anneeActive->id)->get();
        } else {
            $classes = Classe::all();
        }

        $les_eleves_par_classe = collect();

        return view('promoteur.les_paiements', compact('les_paiements', 'user', 'classes', 'les_eleves_par_classe', 'contacts'));
    }

    public function les_paiements_comptable()
    {
        $user = Auth::user();
        $les_paiements = Paiement::with(['eleve', 'frais', 'classe'])->where('annee_scolaire_id', $user->anne_scolaire_id)->orderBy('created_at', 'desc')->get();
        $anneeActive = Annee_scolaire::where('statut', 'actif')->first();
        $contacts = Contact::first();

        if ($anneeActive) {
            $classes = Classe::where('annee_scolaire_id', $anneeActive->id)->get();
        } else {
            $classes = Classe::all();
        }
        $les_eleves_par_classe = collect();

        return view('comptable.les_paiements', compact('les_paiements', 'user', 'classes', 'les_eleves_par_classe', 'contacts'));
    }

    public function les_paiements_enseignant()
    {
        $user = Auth::user();
        $enseignant = Enseignant::where('user_id', $user->id)->first();

        $les_payements_eleves = collect();
        $les_frais_classe = collect();
        $les_eleves_irreguliers = collect();

        // Récupérer les frais de la classe de l'enseignant si disponible
        if ($enseignant && $enseignant->classe_id) {
            $les_frais_classe = Frais::where('classe_id', $enseignant->classe_id)
                ->where('annee_scolaire_id', $user->anne_scolaire_id ?? $this->getCurrentYearId())
                ->actif() // Utiliser le scope actif du modèle Frais
                ->get();
        }

        return view('enseignant.les_paiements_enseignant', compact(
            'les_payements_eleves',
            'user',
            'enseignant',
            'les_frais_classe',
            'les_eleves_irreguliers'
        ));
    }

    public function rechercher_les_paiements_enseignant(Request $request)
    {
        $request->validate([
            'le_frais_id' => 'nullable|integer|exists:frais,id',
        ]);

        $fraisId = $request->input('le_frais_id');
        $user = Auth::user();
        $enseignant = Enseignant::where('user_id', $user->id)->first();

        // Initialisation des variables
        $les_payements_eleves = collect();
        $les_frais_classe = collect();
        $les_eleves_irreguliers = collect();
        $fraisSelectionne = null;

        // Vérifier que l'enseignant existe et a une classe
        if ($enseignant && $enseignant->classe_id) {
            // Récupérer tous les frais de la classe
            $les_frais_classe = Frais::where('classe_id', $enseignant->classe_id)
                ->where('annee_scolaire_id', $user->anne_scolaire_id ?? $this->getCurrentYearId())
                ->actif()
                ->get();

            // Si un frais est sélectionné
            if ($fraisId) {
                // Vérifier que le frais appartient bien à la classe de l'enseignant
                $fraisSelectionne = Frais::where('id', $fraisId)
                    ->where('classe_id', $enseignant->classe_id)
                    ->first();

                if ($fraisSelectionne) {
                    // Récupérer les paiements pour ce frais
                    $les_payements_eleves = Paiement::where('frais_id', $fraisId)
                        ->where('classe_id', $enseignant->classe_id)
                        ->where('annee_scolaire_id', $user->anne_scolaire_id ?? $this->getCurrentYearId())
                        ->with(['eleve']) // Charger la relation élève
                        ->get();

                    // Récupérer les élèves irréguliers (sans paiement pour ce frais)
                    $les_eleves_irreguliers = Eleve::where('annee_scolaire_id', $user->anne_scolaire_id ?? $this->getCurrentYearId())
                        ->where('classe_id', $enseignant->classe_id)
                        ->whereDoesntHave('paiements', function ($query) use ($fraisId) {
                            $query->where('frais_id', $fraisId);
                        })
                        ->get();
                }
            }
        }

        return view('enseignant.les_paiements_enseignant', compact(
            'les_payements_eleves',
            'user',
            'enseignant',
            'les_frais_classe',
            'les_eleves_irreguliers',
            'fraisSelectionne'
        ));
    }

    /**
     * Récupère l'ID de l'année scolaire active
     */
    private function getCurrentYearId()
    {
        $activeYear = Annee_scolaire::where('statut', 'actif')->first();
        return $activeYear ? $activeYear->id : null;
    }

    public function eleves_par_classe(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'classe_id' => 'nullable|integer|exists:classes,id',
        ]);

        // Récupérer les élèves par classe ou tous si aucune classe sélectionnée
        if (!empty($data['classe_id'])) {
            $les_eleves_par_classe = Eleve::with(['classe', 'paiements'])
                ->where('classe_id', $data['classe_id'])
                ->where('annee_scolaire_id', $user->anne_scolaire_id)
                ->orderBy('nom')
                ->get();
        } else {
            $les_eleves_par_classe = Eleve::with(['classe', 'paiements'])
                ->orderBy('nom')
                ->get();
        }

        $user = Auth::user();
        $les_paiements = Paiement::with(['eleve', 'frais'])->orderBy('created_at', 'desc')->get();
        $anneeActive = Annee_scolaire::where('statut', 'actif')->first();

        if ($anneeActive) {
            $classes = Classe::where('annee_scolaire_id', $anneeActive->id)->get();
        } else {
            $classes = Classe::all();
        }
        $contacts = Contact::first();

        return view('promoteur.les_paiements', compact('classes', 'les_eleves_par_classe', 'user', 'les_paiements', 'contacts'));
    }

    public function eleves_par_classe_comptable(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'classe_id' => 'nullable|integer|exists:classes,id',
        ]);

        // Récupérer les élèves par classe ou tous si aucune classe sélectionnée
        if (!empty($data['classe_id'])) {
            $les_eleves_par_classe = Eleve::with(['classe', 'paiements'])
                ->where('classe_id', $data['classe_id'])
                ->where('annee_scolaire_id', $user->anne_scolaire_id)
                ->orderBy('nom')
                ->get();
        } else {
            $les_eleves_par_classe = Eleve::with(['classe', 'paiements'])
                ->orderBy('nom')
                ->get();
        }

        $user = Auth::user();
        $les_paiements = Paiement::with(['eleve', 'frais'])->orderBy('created_at', 'desc')->get();
        $anneeActive = Annee_scolaire::where('statut', 'actif')->first();

        if ($anneeActive) {
            $classes = Classe::where('annee_scolaire_id', $anneeActive->id)->get();
        } else {
            $classes = Classe::all();
        }
        $contacts = Contact::first();

        return view('comptable.les_paiements', compact('classes', 'les_eleves_par_classe', 'user', 'les_paiements', 'contacts'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'eleve_id' => 'required|exists:eleves,id',
                'frais_id' => 'required|exists:frais,id',
                'montant' => 'nullable|numeric|min:0',
                'mode_paiement' => 'nullable|string|max:100',
            ]);

            $eleve = Eleve::findOrFail($data['eleve_id']);
            $frais = Frais::findOrFail($data['frais_id']);

            // Définir le montant
            $montant = $data['montant'] ?? $frais->montant;

            // Vérifier que le montant ne dépasse pas le montant du frais
            if ($montant > $frais->montant) {
                return redirect()->back()->with('error', 'Le montant ne peut pas dépasser le montant du frais (' . number_format($frais->montant, 2) . ' ' . $frais->devise . ')');
            }

            // Préparer les données
            $paiementData = [
                'eleve_id' => $eleve->id,
                'frais_id' => $frais->id,
                'montant' => $montant,
                'classe_id' => $eleve->classe_id,
                'annee_scolaire_id' => $frais->annee_scolaire_id,
                'date_limite' => $frais->date_limite,
                'devise' => $frais->devise,
                'mode_paiement' => $data['mode_paiement'] ?? null,
            ];

            // Convertir le montant en lettres
            $paiementData['montant_en_lettre'] = $this->convertirMontantEnLettres($montant, $frais->devise ?? '');

            // Créer le paiement (le statut sera défini automatiquement par le boot)
            $paiement = Paiement::create($paiementData);

            $this->historiqueAction('Création d\'un paiement pour l\'élève : ' . $eleve->nom . ' - Montant : ' . $montant);

            return redirect()->back()->with('success', 'Paiement enregistré avec succès');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'Erreur de validation : ' . implode(', ', array_merge(...array_values($e->errors()))));
        } catch (\Exception $e) {
            Log::error('Erreur création paiement : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la création du paiement : ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'montant' => 'nullable|numeric|min:0',
                'mode_paiement' => 'nullable|string|max:100',
                'statut' => 'nullable|string|in:payé,acompte',
            ]);

            $paiement = Paiement::findOrFail($id);

            if (isset($data['montant'])) {
                $paiement->montant = $data['montant'];
                $paiement->montant_en_lettre = $this->convertirMontantEnLettres($data['montant'], $paiement->devise ?? '');
            }

            if (isset($data['mode_paiement'])) {
                $paiement->mode_paiement = $data['mode_paiement'];
            }

            if (isset($data['statut'])) {
                $paiement->statut = $data['statut'];
            }

            $paiement->save();

            $this->historiqueAction('Mise à jour du paiement ID: ' . $paiement->id);

            return redirect()->back()->with('success', 'Paiement mis à jour avec succès');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'Erreur de validation : ' . implode(', ', array_merge(...array_values($e->errors()))));
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour paiement : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du paiement : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $paiement = Paiement::findOrFail($id);
            $paiement->delete();

            $this->historiqueAction('Suppression du paiement ID: ' . $id);

            return redirect()->back()->with('success', 'Paiement supprimé avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur suppression paiement : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression du paiement : ' . $e->getMessage());
        }
    }
}
