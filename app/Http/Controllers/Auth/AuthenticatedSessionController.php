<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->id === 1 || $user->role === 'promoteur') {
            return redirect()->route('profile_promoteur');
        }

        if ($user->role === 'suspendu') {
            Auth::logout();
            return redirect()->route('login');
        }

        if ($user->role === 'comptable') {
            return redirect()->route('profile_comptable');
        }

        if ($user->role === 'enseignant') {
            return redirect()->route('profile_enseignant');
        }


        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function login_enseignant(Request $request)
    {
        $credentials = $request->validate([
            'matricule' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt(
            [
                'matricule' => $credentials['matricule'],
                'password' => $credentials['password'],
            ],
            $remember
        )) {
            return back()
                ->withInput($request->only('matricule'))
                ->withErrors([
                    'matricule' => 'Matricule ou mot de passe incorrect.',
                ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Compte suspendu
        if ($user->role === 'suspendu') {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput($request->only('matricule'))
                ->withErrors([
                    'matricule' => 'Votre compte est suspendu.',
                ]);
        }

        // Mauvais rôle
        if ($user->role !== 'enseignant') {
            Auth::logout();

            return back()
                ->withInput($request->only('matricule'))
                ->withErrors([
                    'matricule' => 'Vous devez utiliser l\'espace correspondant à votre rôle.',
                ]);
        }

        // Profil enseignant inexistant
        if (!$user->enseignant) {
            Auth::logout();

            return back()
                ->withInput($request->only('matricule'))
                ->withErrors([
                    'matricule' => 'Votre profil enseignant n\'est pas configuré.',
                ]);
        }

        return redirect()->route('profile_enseignant');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
