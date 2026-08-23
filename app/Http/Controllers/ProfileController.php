<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Annee_scolaire;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Frais;
use App\Models\Historique;
use App\Models\Paiement;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function historiqueAction($action)
    {
        Historique::create([
            'action' => $action,
            'user_id' => Auth::id(),
        ]);
    }

    private function autorise_promoteur()
    {
        if (Auth::user()?->id !== 1 && Auth::user()?->role !== 'promoteur') {
            abort(403, 'Accès non autorisé.');
        }
    }

    //mes profiles
    public function profile_promoteur()
    {
        $this->autorise_promoteur();

        $user = Auth::user();

        /*
    |--------------------------------------------------------------------------
    | Année scolaire de l'utilisateur
    |--------------------------------------------------------------------------
    */

        $anneeId = $user->anne_scolaire_id;

        /*
    |--------------------------------------------------------------------------
    | Sections
    |--------------------------------------------------------------------------
    */

        $primaire = Section::where('designation', 'like', '%primaire%')
            ->first();

        $maternelle = Section::where('designation', 'like', '%maternelle%')
            ->first();

        /*
    |--------------------------------------------------------------------------
    | Classes de chaque section
    |--------------------------------------------------------------------------
    */

        $classesPrimaire = $primaire
            ? $primaire->classes()
            ->where('annee_scolaire_id', $anneeId)
            ->get()
            : collect();

        $classesMaternelle = $maternelle
            ? $maternelle->classes()
            ->where('annee_scolaire_id', $anneeId)
            ->get()
            : collect();

        /*
    |--------------------------------------------------------------------------
    | IDs des classes
    |--------------------------------------------------------------------------
    */

        $classeIdsPrimaire = $classesPrimaire->pluck('id');

        $classeIdsMaternelle = $classesMaternelle->pluck('id');

        /*
    |--------------------------------------------------------------------------
    | Élèves
    |--------------------------------------------------------------------------
    */

        $nb_elevees = Eleve::where('annee_scolaire_id', $anneeId)
            ->count();

        $nb_eleves_primaire = Eleve::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->count();

        $nb_eleves_maternelle = Eleve::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->count();

        /*
    |--------------------------------------------------------------------------
    | Classes
    |--------------------------------------------------------------------------
    */

        $nb_classes = Classe::where('annee_scolaire_id', $anneeId)
            ->count();

        $nb_classes_primaire = $classesPrimaire->count();

        $nb_classes_maternelle = $classesMaternelle->count();

        /*
    |--------------------------------------------------------------------------
    | Frais
    |--------------------------------------------------------------------------
    */

        $nb_frais = Frais::where('annee_scolaire_id', $anneeId)
            ->count();

        $nb_frais_primaire = Frais::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->count();

        $nb_frais_maternelle = Frais::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->count();

        /*
    |--------------------------------------------------------------------------
    | Montant total des frais
    |--------------------------------------------------------------------------
    */

        $mnt_total = Frais::where('annee_scolaire_id', $anneeId)
            ->sum('montant');

        $mnt_totale_primaire = Frais::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->sum('montant');

        $mnt_totale_maternelle = Frais::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->sum('montant');

        /*
    |--------------------------------------------------------------------------
    | Enseignants / utilisateurs
    |--------------------------------------------------------------------------
    */

        $nb_enseignants = Enseignant::count();

        $nb_utilisateurs = User::count();

        /*
    |--------------------------------------------------------------------------
    | Paiements
    |--------------------------------------------------------------------------
    */

        $nb_paiements_acompte = Paiement::where('annee_scolaire_id', $anneeId)
            ->where('statut', 'acompte')
            ->count();

        $nb_paiements_payes = Paiement::where('annee_scolaire_id', $anneeId)
            ->where('statut', 'payé')
            ->count();

        $nb_paiements_total = Paiement::where(
            'annee_scolaire_id',
            $anneeId
        )->count();

        $nb_paiements_acompte_primaire = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->where('statut', 'acompte')
            ->count();

        $nb_paiements_payes_primaire = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->where('statut', 'payé')
            ->count();

        $nb_paiements_total_primaire = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->count();

        $nb_paiements_acompte_maternelle = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->where('statut', 'acompte')
            ->count();

        $nb_paiements_payes_maternelle = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->where('statut', 'payé')
            ->count();

        $nb_paiements_total_maternelle = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->count();

        /*
    |--------------------------------------------------------------------------
    | Élèves réguliers / irréguliers - Maternelle
    |--------------------------------------------------------------------------
    */

        $nb_eleves_reguliers_paiement_maternelle = Eleve::where(
            'annee_scolaire_id',
            $anneeId
        )
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->whereHas('paiements', function ($query) use ($anneeId) {
                $query->where('annee_scolaire_id', $anneeId)
                    ->where('statut', 'payé');
            })
            ->count();

        $nb_eleves_irreguliers_paiement_maternelle =
            $nb_eleves_maternelle -
            $nb_eleves_reguliers_paiement_maternelle;

        /*
    |--------------------------------------------------------------------------
    | Élèves réguliers / irréguliers - Primaire
    |--------------------------------------------------------------------------
    */

        $nb_eleves_reguliers_paiement_primaire = Eleve::where(
            'annee_scolaire_id',
            $anneeId
        )
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->whereHas('paiements', function ($query) use ($anneeId) {
                $query->where('annee_scolaire_id', $anneeId)
                    ->where('statut', 'payé');
            })
            ->count();

        $nb_eleves_irreguliers_paiement_primaire =
            $nb_eleves_primaire -
            $nb_eleves_reguliers_paiement_primaire;

        /*
    |--------------------------------------------------------------------------
    | Montant réellement payé
    |--------------------------------------------------------------------------
    */

        $montant_paye = Paiement::where('annee_scolaire_id', $anneeId)
            ->sum('montant');

        $histogramme_paiements = Annee_scolaire::orderBy('annee', 'asc')
            ->get()
            ->map(function ($annee) {
                $du = (float) Frais::where('annee_scolaire_id', $annee->id)->sum('montant');
                $percu = (float) Paiement::where('annee_scolaire_id', $annee->id)->sum('montant');

                return [
                    'annee' => $annee->annee,
                    'du' => $du,
                    'percu' => $percu,
                ];
            });

        /*
    |--------------------------------------------------------------------------
    | Montant des acomptes
    |--------------------------------------------------------------------------
    */

        $montant_acompte = Paiement::where('annee_scolaire_id', $anneeId)
            ->where('statut', 'acompte')
            ->sum('montant');

        /*
    |--------------------------------------------------------------------------
    | Retour vers le dashboard
    |--------------------------------------------------------------------------
    */

        return view(
            'profile.profile_promoteur',
            compact(
                'user',

                // Élèves
                'nb_elevees',
                'nb_eleves_primaire',
                'nb_eleves_maternelle',

                // Classes
                'nb_classes',
                'nb_classes_primaire',
                'nb_classes_maternelle',

                // Frais
                'nb_frais',
                'nb_frais_primaire',
                'nb_frais_maternelle',

                // Montants
                'mnt_total',
                'mnt_totale_primaire',
                'mnt_totale_maternelle',
                'montant_paye',
                'montant_acompte',
                'histogramme_paiements',

                // Utilisateurs
                'nb_enseignants',
                'nb_utilisateurs',

                // Paiements
                'nb_paiements_total',
                'nb_paiements_acompte',
                'nb_paiements_payes',
                'nb_paiements_total_primaire',
                'nb_paiements_acompte_primaire',
                'nb_paiements_payes_primaire',
                'nb_paiements_total_maternelle',
                'nb_paiements_acompte_maternelle',
                'nb_paiements_payes_maternelle',

                // Régularité
                'nb_eleves_reguliers_paiement_primaire',
                'nb_eleves_irreguliers_paiement_primaire',
                'nb_eleves_reguliers_paiement_maternelle',
                'nb_eleves_irreguliers_paiement_maternelle',

                // Sections
                'primaire',
                'maternelle'
            )
        );
    }

    public function profile_comptable()
    {
        $user = Auth::user();
        $anneeId = $user->anne_scolaire_id;

        $primaire = Section::where('designation', 'like', '%primaire%')->first();
        $maternelle = Section::where('designation', 'like', '%maternelle%')->first();

        $classesPrimaire = $primaire
            ? $primaire->classes()->where('annee_scolaire_id', $anneeId)->get()
            : collect();

        $classesMaternelle = $maternelle
            ? $maternelle->classes()->where('annee_scolaire_id', $anneeId)->get()
            : collect();

        $classeIdsPrimaire = $classesPrimaire->pluck('id');
        $classeIdsMaternelle = $classesMaternelle->pluck('id');

        $nb_eleves_total = Eleve::where('annee_scolaire_id', $anneeId)->count();
        $nb_eleves_primaire = Eleve::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->count();
        $nb_eleves_maternelle = Eleve::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->count();

        $nb_paiements_total = Paiement::where('annee_scolaire_id', $anneeId)->count();
        $nb_paiements_payes = Paiement::where('annee_scolaire_id', $anneeId)
            ->where('statut', 'payé')
            ->count();
        $nb_paiements_acompte = Paiement::where('annee_scolaire_id', $anneeId)
            ->where('statut', 'acompte')
            ->count();

        $nb_paiements_total_primaire = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->count();
        $nb_paiements_payes_primaire = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->where('statut', 'payé')
            ->count();
        $nb_paiements_acompte_primaire = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsPrimaire)
            ->where('statut', 'acompte')
            ->count();

        $nb_paiements_total_maternelle = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->count();
        $nb_paiements_payes_maternelle = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->where('statut', 'payé')
            ->count();
        $nb_paiements_acompte_maternelle = Paiement::where('annee_scolaire_id', $anneeId)
            ->whereIn('classe_id', $classeIdsMaternelle)
            ->where('statut', 'acompte')
            ->count();

        return view('profile.profile_comptable', compact(
            'user',
            'nb_eleves_total',
            'nb_eleves_primaire',
            'nb_eleves_maternelle',
            'nb_paiements_total',
            'nb_paiements_payes',
            'nb_paiements_acompte',
            'nb_paiements_total_primaire',
            'nb_paiements_payes_primaire',
            'nb_paiements_acompte_primaire',
            'nb_paiements_total_maternelle',
            'nb_paiements_payes_maternelle',
            'nb_paiements_acompte_maternelle'
        ));
    }
    public function profile_enseignant()
    {
        $user = Auth::user();
        return view('profile.profile_enseignant', compact('user'));
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function edit_profile_compt()
    {
        $user = Auth::user();
        return view('comptable.mon_profile', compact('user'));
    }

    public function edit_profile_prom()
    {
        $user = Auth::user();
        return view('promoteur.mon_profile', compact('user'));
    }
    public function edit_profile_ens()
    {
        $user = Auth::user();
        return view('enseignant.mon_profile', compact('user'));
    }
}
