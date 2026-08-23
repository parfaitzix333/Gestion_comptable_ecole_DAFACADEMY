<?php

namespace App\Http\Controllers;

use App\Models\Annee_scolaire;
use App\Models\Enseignant;
use App\Models\User;
use App\Models\Historique;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UtilisateurController extends Controller
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
        $les_utilisateurs = User::with('anneeScolaire')->get();
        $les_annees_scolaires = Annee_scolaire::all();
        return view('promoteur.les_utilisateurs', compact('user', 'les_utilisateurs', 'les_annees_scolaires'));
    }

    public function switcher_annee_scolaire(Request $request)
    {
        $data = $request->validate([
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
        ]);
        $user = Auth::user();
        $utilisateur = User::find($user->id);
        $utilisateur->anne_scolaire_id = $data['annee_scolaire_id'];
        try {
            $utilisateur->save();
            return redirect()->back()->with('success', 'Année scolaire changée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du changement d\'année scolaire: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        // Logique pour stocker un nouvel utilisateur
        $users = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'matricule' => 'nullable|string|max:255',
            'role' => 'nullable|string|in:user,promoteur,comptable,enseignant,suspendu',
        ]);
        User::create($users);

        return redirect()->back()->with('success', 'Utilisateur créé avec succès');
        $this->historiqueAction('Création d\'un nouvel utilisateur : ' . $users['name']);
    }


    public function update(Request $request, User $utilisateur)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $utilisateur->id,
            'role' => 'nullable|string|in:user,promoteur,comptable,enseignant,suspendu',
            'password' => 'nullable|string|min:8',
            'matricule' => 'nullable|string|max:255',
        ]);

        try {
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            if (empty($data['matricule'])) {
                unset($data['matricule']);
            }

            if (empty($data['role'])) {
                unset($data['role']);
            }

            $estSuspendu = isset($data['role'])
                && $data['role'] === 'suspendu';

            $utilisateur->update($data);

            if ($estSuspendu) {

                DB::table('sessions')
                    ->where('user_id', $utilisateur->id)
                    ->delete();
            }
            $this->historiqueAction(
                'Mise à jour de l\'utilisateur : ' . $utilisateur->name
            );

            return redirect()
                ->back()
                ->with('success', 'Utilisateur mis à jour avec succès');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withErrors(
                    'Erreur lors de la mise à jour de l\'utilisateur : ' . $e->getMessage()
                );
        }
    }


    public function editpass(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Veuillez saisir votre mot de passe actuel.',
            'password.required' => 'Veuillez saisir un nouveau mot de passe.',
            'password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du nouveau mot de passe ne correspond pas.',
        ]);

        try {
            $user = User::findOrFail(Auth::id());

            // Vérifier le mot de passe actuel
            if (!Hash::check($data['current_password'], $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Le mot de passe actuel est incorrect.',
                ])->withInput();
            }

            // Enregistrer le nouveau mot de passe
            $user->password = Hash::make($data['password']);
            $user->save();

            return back()->with(
                'success',
                'Mot de passe modifié avec succès !'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Erreur lors de la modification du mot de passe.',
            ]);
        }
    }

    public function destroy(User $utilisateur)
    {
        // Logique pour supprimer un utilisateur
        try {
            $utilisateur->delete();
            return redirect()->back()->with('success', 'Utilisateur supprimé avec succès');
            $this->historiqueAction('Suppression de l\'utilisateur : ' . $utilisateur->name);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression de l\'utilisateur: ' . $e->getMessage());
        }
    }

    public function register_enseigannt()
    {
        return view('auth.register_enseignant');
    }
    //un enseignant creer sun compte user en saiaissant son matricule, email et password, si le matricule existe, le user prend le nom de la table enseignant
    public function nouvel_enseignant(Request $request)
    {
        // Validation
        $data = $request->validate([
            'matricule' => [
                'required',
                'string',
                'max:255',
                'exists:enseignants,matricule',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'matricule.required' => 'Le matricule est obligatoire.',
            'matricule.exists' => 'Aucun enseignant ne possède ce matricule.',

            'email.required' => 'L’adresse email est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        try {

            DB::beginTransaction();

            /*
        |--------------------------------------------------------------------------
        | 1. Rechercher l'enseignant
        |--------------------------------------------------------------------------
        */

            $enseignant = Enseignant::where(
                'matricule',
                $data['matricule']
            )->first();

            if (!$enseignant) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'matricule' =>
                        'Aucun enseignant trouvé avec ce matricule.',
                    ]);
            }


            /*
        |--------------------------------------------------------------------------
        | 2. Vérifier si l'enseignant possède déjà un compte
        |--------------------------------------------------------------------------
        */

            if ($enseignant->user_id) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'matricule' =>
                        'Cet enseignant possède déjà un compte utilisateur.',
                    ]);
            }


            /*
        |--------------------------------------------------------------------------
        | 3. Vérifier si le matricule existe déjà dans users
        |--------------------------------------------------------------------------
        */

            $userExisteDeja = User::where(
                'matricule',
                $data['matricule']
            )->exists();

            if ($userExisteDeja) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'matricule' =>
                        'Ce matricule est déjà associé à un compte utilisateur.',
                    ]);
            }


            /*
        |--------------------------------------------------------------------------
        | 4. Déterminer l'année scolaire
        |--------------------------------------------------------------------------
        |
        | Si l'inscription est faite par un utilisateur connecté,
        | on récupère son année scolaire.
        |
        */

            $anneeScolaireId = Auth::check()
                ? Auth::user()->anne_scolaire_id
                : null;


            /*
        |--------------------------------------------------------------------------
        | 5. Création du compte utilisateur
        |--------------------------------------------------------------------------
        |
        | Le modèle User possède :
        |
        | 'password' => 'hashed'
        |
        | Laravel s'occupe donc automatiquement du hash.
        |
        */

            $user = User::create([
                'name' => $enseignant->nom,
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'enseignant',
                'matricule' => $enseignant->matricule,
                'anne_scolaire_id' => $anneeScolaireId,
            ]);


            /*
        |--------------------------------------------------------------------------
        | 6. Associer l'enseignant au compte utilisateur
        |--------------------------------------------------------------------------
        */

            $enseignant->update([
                'user_id' => $user->id,
            ]);


            /*
        |--------------------------------------------------------------------------
        | 7. Valider la transaction
        |--------------------------------------------------------------------------
        */

            DB::commit();


            /*
        |--------------------------------------------------------------------------
        | 8. Redirection vers la connexion enseignant
        |--------------------------------------------------------------------------
        */

            return redirect()
                ->route('form_login_enseignant')
                ->with(
                    'success',
                    'Votre compte enseignant a été créé avec succès. '
                        . 'Vous pouvez maintenant vous connecter.'
                );
        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' =>
                    'Une erreur est survenue lors de la création du compte. '
                        . 'Veuillez réessayer.',
                ]);
        }
    }

    public function form_login_enseignant()
    {
        return view('auth.login_enseignant');
    }
}
