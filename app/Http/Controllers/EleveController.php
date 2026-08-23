<?php

namespace App\Http\Controllers;

use App\Models\Annee_scolaire;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Historique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EleveController extends Controller
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
        $anneeActive = Annee_scolaire::where('statut', 'actif')->first();
        $annees_scolaires = Annee_scolaire::orderBy('annee', 'desc')->where('statut', 'actif')->get();
        $les_classes = Classe::where('annee_scolaire_id', $anneeActive?->id)->get();
        $les_eleves = Eleve::with('classe')->where('annee_scolaire_id', $user->anne_scolaire_id)->orderBy('created_at', 'desc')->get();
        return view('promoteur.les_eleves', compact('les_eleves', 'user', 'annees_scolaires', 'les_classes', 'anneeActive'));
    }

    public function les_eleve_comptable()
    {
        $user = Auth::user();
        $anneeActive = Annee_scolaire::where('statut', 'actif')->first();
        $annees_scolaires = Annee_scolaire::orderBy('annee', 'desc')->where('statut', 'actif')->get();
        $les_classes = Classe::where('annee_scolaire_id', $anneeActive?->id)->get();
        $les_eleves = Eleve::with('classe')->where('annee_scolaire_id', $user->anne_scolaire_id)->orderBy('created_at', 'desc')->get();
        return view('comptable.les_eleves', compact('les_eleves', 'user', 'annees_scolaires', 'les_classes', 'anneeActive'));
    }

    public function les_eleve_enseignant()
    {
        $user = Auth::user();
        $enseignant = Enseignant::where('user_id', $user->id)->first();

        if ($enseignant->classe_id ?? '') {
            $les_eleves = Eleve::with('classe')->where('annee_scolaire_id', $user->anne_scolaire_id)->where('classe_id', $enseignant->classe_id)->orderBy('created_at', 'desc')->get();

            return view('enseignant.les_eleves', compact('les_eleves', 'user', 'enseignant'));
        }

        $les_eleves = collect();
        return view('enseignant.les_eleves', compact('les_eleves', 'user', 'enseignant'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'date_n' => 'required|date',
            'lieu_n' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'tel_responsable' => 'required|string|max:50',
            'adresse' => 'nullable|string|max:500',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'ecole_provenance' => 'nullable|string|max:255',
            'photo' => 'nullable|file|image|max:2048',
            'sexe' => 'required|in:M,F',
        ]);

        $le_derniere_eleve = Eleve::orderBy('id', 'desc')->first();
        $classe = Classe::find($data['classe_id']);

        if ($classe->section->designation === 'Maternelle') {
            $data['matricule'] = 'SM' . '-' . now()->format('Y') . str_pad(
                $le_derniere_eleve ? $le_derniere_eleve->id + 1 : 1,
                4,
                '0',
                STR_PAD_LEFT
            );
        }
        if ($classe->section->designation === 'Primaire') {
            $data['matricule'] = 'SP' . '-' . now()->format('Y') . str_pad(
                $le_derniere_eleve ? $le_derniere_eleve->id + 1 : 1,
                4,
                '0',
                STR_PAD_LEFT
            );
        }
        if ($classe->section->designation === 'Humanitaire') {
            $data['matricule'] = 'SH' . '-' . now()->format('Y') . str_pad(
                $le_derniere_eleve ? $le_derniere_eleve->id + 1 : 1,
                4,
                '0',
                STR_PAD_LEFT
            );
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/photos'), $filename);
            $data['photo'] = 'uploads/photos/' . $filename;
        }

        try {
            Eleve::create($data);
            $this->historiqueAction('Création d\'un élève : ' . $data['nom']);
            return redirect()->back()->with('success', 'Élève créé avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'matricule' => 'nullable|string|max:100',
            'nom' => 'required|string|max:255',
            'date_n' => 'required|date',
            'lieu_n' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'tel_responsable' => 'required|string|max:50',
            'adresse' => 'nullable|string|max:500',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'ecole_provenance' => 'nullable|string|max:255',
            'photo' => 'nullable|file|image|max:2048',
            'sexe' => 'required|in:M,F',
        ]);

        try {
            $eleve = Eleve::findOrFail($id);
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/photos'), $filename);
                $data['photo'] = 'uploads/photos/' . $filename;
            }
            $eleve->update($data);
            $this->historiqueAction('Mise à jour de l\'élève : ' . $data['nom']);
            return redirect()->back()->with('success', 'Élève mis à jour');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $eleve = Eleve::findOrFail($id);
            $eleve->delete();
            $this->historiqueAction('Suppression de l\'élève : ' . $eleve->nom);
            return redirect()->back()->with('success', 'Élève supprimé');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
