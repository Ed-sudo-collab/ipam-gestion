<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Lister tous les utilisateurs avec pagination
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Sauvegarder un nouvel utilisateur
     */
    public function store(UserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status ?? 'ACTIVE',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Afficher un utilisateur spécifique (facultatif)
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur existant
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        // Mettre à jour le mot de passe uniquement si fourni
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour.');
    }

    /**
     * Bloquer un utilisateur au lieu de le supprimer
     */
    public function destroy(User $user)
    {
        $user->update(['status' => 'BLOCKED']);
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur bloqué.');
    }

    /**
     * Activer / Désactiver un utilisateur
     */
    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => $user->status === 'ACTIVE' ? 'INACTIVE' : 'ACTIVE'
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Statut modifié.');
    }
}
