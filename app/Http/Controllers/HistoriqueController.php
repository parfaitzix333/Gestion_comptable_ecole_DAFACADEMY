<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HistoriqueController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $historiques = Historique::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50); // Pagination pour éviter de charger trop de données

        return view('promoteur.historique', compact('historiques', 'user'));
    }

    public function deleteSelected(Request $request)
    {
        try {
            $ids = $request->input('selected', []);

            if (empty($ids)) {
                return redirect()->back()->with('error', 'Veuillez sélectionner au moins un historique à supprimer.');
            }

            $count = Historique::whereIn('id', $ids)->delete();

            return redirect()->back()->with('success', $count . ' historique(s) supprimé(s) avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression historique : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $historique = Historique::findOrFail($id);
            $historique->delete();

            return redirect()->back()->with('success', 'Historique supprimé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression historique : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function clearAll()
    {
        try {
            $count = Historique::count();
            Historique::truncate();

            return redirect()->back()->with('success', 'Tous les historiques (' . $count . ') ont été supprimés avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression tous les historiques : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
