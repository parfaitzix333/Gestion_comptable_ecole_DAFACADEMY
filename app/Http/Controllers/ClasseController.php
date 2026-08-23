<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Historique;
use App\Models\Annee_scolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClasseController extends Controller
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
        $annees_scolaires = Annee_scolaire::orderBy('annee', 'desc')->where('statut', 'actif')->get();
        $les_classes = Classe::with(['enseignants', 'eleves', 'frais', 'paiements'])
            ->where('annee_scolaire_id', $user->anne_scolaire_id)
            ->get();

        return view('promoteur.les_classes', compact('les_classes', 'user', 'annees_scolaires'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'designation' => 'required|string|max:255',
            'section_id' => 'nullable|exists:sections,id',
            'annee_scolaire_id' => 'nullable|exists:annee_scolaires,id',
        ]);

        try {
            Classe::create($data);
            $this->historiqueAction('Création d\'une classe : ' . $data['designation']);
            return redirect()->back()->with('success', 'Classe créée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'designation' => 'required|string|max:255',
            'section_id' => 'nullable|exists:sections,id',
            'annee_scolaire_id' => 'nullable|exists:annee_scolaires,id',
        ]);

        try {
            $classe = Classe::findOrFail($id);
            $classe->update($data);
            $this->historiqueAction('Mise à jour de la classe : ' . $data['designation']);
            return redirect()->back()->with('success', 'Classe mise à jour');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $classe = Classe::findOrFail($id);
            $classe->delete();
            $this->historiqueAction('Suppression de la classe : ' . $classe->designation);
            return redirect()->back()->with('success', 'Classe supprimée');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
