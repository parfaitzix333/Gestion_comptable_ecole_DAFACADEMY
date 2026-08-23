<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\Propriete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProprieteController extends Controller
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
        $nos_info = Propriete::all();
        return view('promoteur.les_proprietes', compact('nos_info', 'user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'information' => 'nullable|string',
        ]);

        try {
            Propriete::create($data);
            $this->historiqueAction('Ajout d\'une propriété : ' . $data['titre']);
            return redirect()->back()->with('success', 'Propriété ajoutée');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout : ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'information' => 'nullable|string',
        ]);

        try {
            $p = Propriete::findOrFail($id);
            $p->update($data);
            $this->historiqueAction('Mise à jour d\'une propriété : ' . $data['titre']);
            return redirect()->back()->with('success', 'Propriété mise à jour');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $p = Propriete::findOrFail($id);
            $p->delete();
            $this->historiqueAction('Suppression d\'une propriété : ' . $p->titre);
            return redirect()->back()->with('success', 'Propriété supprimée');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
