<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\Retour;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetourController extends Controller
{
    //public function historiqueAction($action)
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
        $les_retours = Retour::all();
        return view('retour.index', compact('les_retours', 'user'));
    }

    public function store(Request $request)
    {
        $ip = $request->ip();
        $request->validate([
            'ip' => 'required|ip',
            'couriel' => 'required|email',
            'avis' => 'required|string|max:255',
        ]);
        try {
            Retour::create([
                'ip' => $ip,
                'couriel' => $request->couriel,
                'avis' => $request->avis,
            ]);
            $this->historiqueAction('Création d\'un retour');
            return redirect()
                ->back()
                ->with('success', 'Retour créé avec succès.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Erreur lors de la création du retour : ' . $e->getMessage()
                );
        }
    }

    public function update(Request $request, Retour $retour)
    {
        $request->validate([
            'ip' => 'required|ip',
            'couriel' => 'required|email',
            'avis' => 'required|string|max:255',
        ]);
        try {
            $retour->update([
                'ip' => $request->ip,
                'couriel' => $request->couriel,
                'avis' => $request->avis,
            ]);
            $this->historiqueAction('Mise à jour d\'un retour');
            return redirect()
                ->route('retour.index')
                ->with('success', 'Retour mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Erreur lors de la mise à jour du retour : ' . $e->getMessage()
                );
        }
    }

    public function destroy(Retour $retour)
    {
        try {
            $retour->delete();
            $this->historiqueAction('Suppression d\'un retour');
            return redirect()
                ->back()
                ->with('success', 'Retour supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Erreur lors de la suppression du retour : ' . $e->getMessage()
                );
        }
    }


    public function destroyAll()
    {
        try {
            Retour::truncate();
            $this->historiqueAction('Suppression de tous les retours');
            return redirect()
                ->back()
                ->with('success', 'Tous les retours ont été supprimés avec succès.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Erreur lors de la suppression de tous les retours : ' . $e->getMessage()
                );
        }
    }
}
