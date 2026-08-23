<?php

namespace App\Http\Controllers;

use App\Models\Annee_scolaire;
use App\Models\Historique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnneeScolaireController extends Controller
{
    public function historiqueAction($action)
    {
        Historique::create([
            'action' => $action,
            'user_id' => Auth::id(),
        ]);
    }

    public function index()
    {
        $user = Auth::user();
        $les_annees = Annee_scolaire::all();
        return view('promoteur.les_annees_scolaires', compact('les_annees', 'user'));
    }

    public function store(Request $request)
    {
        // CORRECTION : n'accepter que 'actif' et 'inactif'
        $data = $request->validate([
            'annee' => 'required|string|max:50',
            'statut' => 'nullable|in:actif,inactif'
        ]);

        try {
            // S'assurer que le statut a une valeur par défaut
            if (!isset($data['statut']) || empty($data['statut'])) {
                $data['statut'] = 'inactif';
            }

            Annee_scolaire::create($data);
            $this->historiqueAction('Création d\'une année scolaire : ' . $data['annee']);
            return redirect()->back()->with('success', 'Année scolaire créée avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur création année scolaire : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // CORRECTION : n'accepter que 'actif' et 'inactif'
        $data = $request->validate([
            'annee' => 'required|string|max:50',
            'statut' => 'required|in:actif,inactif'
        ]);

        try {
            $annee = Annee_scolaire::findOrFail($id);
            $anneeActive = Annee_scolaire::where('statut', 'actif')->first();

            if ($anneeActive && $data['statut'] === 'actif' && $anneeActive->id !== $annee->id) {
                return redirect()->back()->with('error', 'Il y a déjà une année scolaire active. Veuillez désactiver l\'année scolaire actuelle avant d\'activer une nouvelle.');
            }
            // Mise à jour explicite
            $annee->annee = $data['annee'];
            $annee->statut = $data['statut'];
            $annee->save();

            $this->historiqueAction('Mise à jour de l\'année scolaire : ' . $data['annee']);
            return redirect()->back()->with('success', 'Année scolaire mise à jour avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour année scolaire : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $annee = Annee_scolaire::findOrFail($id);
            $annee->delete();
            $this->historiqueAction('Suppression de l\'année scolaire : ' . $annee->annee);
            return redirect()->back()->with('success', 'Année scolaire supprimée avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur suppression année scolaire : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
