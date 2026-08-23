<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
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
        $les_sections = Section::all();
        return view('promoteur.les_sections', compact('user', 'les_sections'));
    }

    public function store(Request $request)
    {
        // Logique pour stocker une nouvelle section
        $data = $request->validate([
            'designation' => 'nullable|string',
        ]);

        try {
            Section::create($data);
            $this->historiqueAction('Création d\'une nouvelle section : ' . $data['designation']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création de la section: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Section créée avec succès');
    }
    public function update(Request $request, Section $section)
    {
        // Logique pour mettre à jour une section existante
        $data = $request->validate([
            'designation' => 'nullable|string',
        ]);

        try {
            $section->update($data);
            $this->historiqueAction('Mise à jour de la section : ' . $data['designation']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la section: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Section mise à jour avec succès');
    }

    public function destroy(Section $section)
    {
        // Logique pour supprimer une section
        try {
            $section->delete();
            $this->historiqueAction('Suppression de la section : ' . $section->designation);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression de la section: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Section supprimée avec succès');
    }
}
