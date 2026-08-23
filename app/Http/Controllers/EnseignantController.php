<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Historique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnseignantController extends Controller
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
        $les_enseignants = Enseignant::with('classe', 'user')->orderBy('created_at', 'desc')->get();
        $les_users = User::whereDoesntHave('enseignant')->get();
        return view('promoteur.les_enseignants', compact('les_enseignants', 'user', 'les_users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'matricule' => 'nullable|string|max:100',
            'classe_id' => 'nullable|exists:classes,id',
            'user_id' => 'nullable|exists:users,id',
            'sexe' => 'nullable|in:M,F',
        ]);

        try {
            Enseignant::create($data);
            $this->historiqueAction('Création d\'un enseignant : ' . $data['nom']);
            return redirect()->back()->with('success', 'Enseignant créé');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'matricule' => 'nullable|string|max:100',
            'classe_id' => 'nullable|exists:classes,id',
            'user_id' => 'nullable|exists:users,id',
            'sexe' => 'nullable|in:M,F',
        ]);

        try {
            $ens = Enseignant::findOrFail($id);
            $ens->update($data);
            $this->historiqueAction('Mise à jour de l\'enseignant : ' . $data['nom']);
            return redirect()->back()->with('success', 'Enseignant mis à jour');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ens = Enseignant::findOrFail($id);
            $ens->delete();
            $this->historiqueAction('Suppression de l\'enseignant : ' . $ens->nom);
            return redirect()->back()->with('success', 'Enseignant supprimé');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
