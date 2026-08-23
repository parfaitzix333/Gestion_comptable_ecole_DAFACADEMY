<?php

namespace App\Http\Controllers;

use App\Models\Frais;
use App\Models\Historique;
use App\Models\Annee_scolaire;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FraisController extends Controller
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
        $les_frais = Frais::where('annee_scolaire_id', $user->anne_scolaire_id)
            ->where('annee_scolaire_id', $user->anne_scolaire_id)
            ->get();
        $annees_scolaires = Annee_scolaire::orderBy('annee', 'desc')->where('statut', 'actif')->get();
        $classes = Classe::where('annee_scolaire_id', $user->anne_scolaire_id)->get();
        return view('promoteur.les_frais', compact('les_frais', 'user', 'annees_scolaires', 'classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'designation' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'classe_id' => 'nullable|exists:classes,id',
            'annee_scolaire_id' => 'nullable|exists:annee_scolaires,id',
            'statut' => 'nullable|string|max:50',
            'devise' => 'nullable|string|max:10',
            'date_limite' => 'nullable|date',
        ]);

        try {
            Frais::create($data);
            $this->historiqueAction('Création d\'un frais : ' . $data['designation']);
            return redirect()->back()->with('success', 'Frais créé');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erreur lors de la création : ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'designation' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'classe_id' => 'nullable|exists:classes,id',
            'annee_scolaire_id' => 'nullable|exists:annee_scolaires,id',
            'statut' => 'nullable|string|max:50',
            'devise' => 'nullable|string|max:10',
            'date_limite' => 'nullable|date',
        ]);

        try {
            $frais = Frais::findOrFail($id);
            $frais->update($data);
            $this->historiqueAction('Mise à jour du frais : ' . $data['designation']);
            return redirect()->back()->with('success', 'Frais mis à jour');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $frais = Frais::findOrFail($id);
            $frais->delete();
            $this->historiqueAction('Suppression du frais : ' . $frais->designation);
            return redirect()->back()->with('success', 'Frais supprimé');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
