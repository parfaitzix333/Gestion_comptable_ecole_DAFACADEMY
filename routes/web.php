<?php

use App\Http\Controllers\AnneeScolaireController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\FraisController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProprieteController;
use App\Http\Controllers\RetourController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UtilisateurController;
use App\Models\Contact;
use App\Models\Eleve;
use App\Models\Propriete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $les_contacts = Contact::first(); // Récupère le premier contact
    $a_propos_de_nous=Propriete::first();
    return view('welcome', compact('les_contacts', 'a_propos_de_nous'));
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->id === 1 || $user->role === 'promoteur') {
        return redirect()->route('profile_promoteur');
    }

    if ($user->role === 'comptable') {
        return redirect()->route('profile_comptable');
    }

    if ($user->role === 'enseignant') {
        return redirect()->route('profile_enseignant');
    }

    $les_contacts = Contact::first();
    return view('dashboard', compact('les_contacts', 'user'));
})->middleware(['auth', 'verified'])->name('dashboard');

route::get('/register_enseigannt', [UtilisateurController::class, 'register_enseigannt'])->name('register_enseigannt');
route::get('/form_login_enseignant', [UtilisateurController::class, 'form_login_enseignant'])->name('form_login_enseignant');
route::post('/nouvel_enseignant', [UtilisateurController::class, 'nouvel_enseignant'])->name('nouvel_enseignant');

route::post('/login_enseignant', [AuthenticatedSessionController::class, 'login_enseignant'])->name('login_enseignant');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile_promoteur', [ProfileController::class, 'profile_promoteur'])->name('profile_promoteur');
    Route::get('/profile_comptable', [ProfileController::class, 'profile_comptable'])->name('profile_comptable');
    Route::get('/profile_enseignant', [ProfileController::class, 'profile_enseignant'])->name('profile_enseignant');


    //les editions profiles
    Route::get('/edit_profile_compt', [ProfileController::class, 'edit_profile_compt'])->name('edit_profile_compt');
    Route::get('/edit_profile_prom', [ProfileController::class, 'edit_profile_prom'])->name('edit_profile_prom');
    Route::get('/edit_profile_ens', [ProfileController::class, 'edit_profile_ens'])->name('edit_profile_ens');


    //les routes resources
    Route::resource('utilisateurs', UtilisateurController::class);
    Route::resource('proprietes', ProprieteController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('annees', AnneeScolaireController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('classes', ClasseController::class);
    Route::resource('frais', FraisController::class);
    Route::resource('historiques', HistoriqueController::class);
    Route::resource('eleves', EleveController::class);
    Route::resource('enseignants', EnseignantController::class);
    Route::resource('paiements', PaiementController::class);
    Route::resource('retours', RetourController::class);

    //les modifications tierses
    Route::put('/switcher_annee_scolaire', [UtilisateurController::class, 'switcher_annee_scolaire'])->name('switcher_annee_scolaire');
    Route::put('/editpass/{id}', [UtilisateurController::class, 'editpass'])->name('editpass');

    //les suppression
    Route::delete('/deleteSelected', [HistoriqueController::class, 'deleteSelected'])->name('deleteSelected');
    Route::delete('/historiques/clear-all', [HistoriqueController::class, 'clearAll'])->name('historiques.clearAll');

    ///les affichages tiers
    Route::get('/les_eleve_comptable', [EleveController::class, 'les_eleve_comptable'])->name('les_eleve_comptable');
    Route::get('/eleves_par_classe', [PaiementController::class, 'eleves_par_classe'])->name('eleves_par_classe');
    Route::get('/eleves_par_classe_comptable', [PaiementController::class, 'eleves_par_classe_comptable'])->name('eleves_par_classe_comptable');
    Route::get('/les_paiements_comptable', [PaiementController::class, 'les_paiements_comptable'])->name('les_paiements_comptable');
    Route::get('/les_eleve_enseignant', [EleveController::class, 'les_eleve_enseignant'])->name('les_eleve_enseignant');
    Route::get('/les_paiements_enseignant', [PaiementController::class, 'les_paiements_enseignant'])->name('les_paiements_enseignant');
    Route::get('/enseignant/rechercher-paiements', [PaiementController::class, 'rechercher_les_paiements_enseignant'])->name('enseignant.paiements.search');
});

require __DIR__ . '/auth.php';
