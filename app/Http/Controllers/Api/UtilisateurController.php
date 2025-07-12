<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Utilisateur;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UtilisateurController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'numeroDeTelephone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $utilisateur = Utilisateur::create([
            'user_id' => $user->id,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'numeroDeTelephone' => $request->numeroDeTelephone,
            'photoProfil' => $request->photoProfil ?? 'default.jpg',
        ]);

        $token = $user->createToken('CovoiturageApp')->plainTextToken;

        return response()->json([
            'message' => 'Utilisateur créé avec succès!',
            'token' => $token,
            'profil' => $utilisateur,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('CovoiturageApp')->plainTextToken;

            return response()->json([
                'message' => 'Connexion réussie!',
                'token' => $token,
                'profil' => $user->utilisateur,
            ], 200);
        }

        return response()->json(['message' => 'Identifiants invalides!'], 401);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $utilisateur = $user->utilisateur;
        $user->update($request->only('email', 'password'));
        $utilisateur->update($request->only('nom', 'prenom', 'numeroDeTelephone', 'photoProfil'));

        return response()->json(['message' => 'Profil mis à jour avec succès!'], 200);
    }

public function deleteAccount()
{
    $utilisateur = Auth::user();
    $utilisateur->tokens->each(function ($token) {
        $token->delete();
    });
    $utilisateur->utilisateur->delete();
    $utilisateur->delete();

    return response()->json(['message' => 'Compte supprimé avec succès!'], 200);
}


    public function showProfile()
    {
        $utilisateur = Auth::user()->utilisateur;
        return response()->json($utilisateur, 200);
    }
}
