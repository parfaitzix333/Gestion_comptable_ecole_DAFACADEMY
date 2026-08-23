<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Historique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
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
        $nos_contacts = Contact::all();

        return view('promoteur.les_contacts', compact('nos_contacts', 'user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'couriel' => 'required|email',
            'tel' => 'nullable|string|max:50',
            'adresse' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {
            Contact::create($data);
            $this->historiqueAction('Ajout d\'un contact : ' . $data['couriel']);
            return redirect()->back()->with('success', 'Contact ajouté');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du contact : ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'couriel' => 'required|email',
            'tel' => 'nullable|string|max:50',
            'adresse' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {
            $contact = Contact::findOrFail($id);
            $contact->update($data);
            $this->historiqueAction('Mise à jour du contact : ' . $data['couriel']);
            return redirect()->back()->with('success', 'Contact mis à jour');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            $this->historiqueAction('Suppression du contact : ' . $contact->couriel);
            return redirect()->back()->with('success', 'Contact supprimé');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
