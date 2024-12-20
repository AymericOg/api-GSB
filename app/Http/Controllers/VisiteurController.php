<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visiteur;
use Exception;
use Illuminate\Support\Facades\Auth;

class VisiteurController extends Controller
{
    public function initPasswords(request $request){
        try{
            $hash = bcrypt($request->json('pwd_visiteur'));
            Visiteur::query()->update(['pwd_visiteur' => $hash]);
            return response()->json(['status_message' => 'mot de passes rénitialisés']);
        }catch(Exception $e){
            return response()->json(['status_message' => $e->getMessage()],500);
        }
    }
    public function login(Request $request)
    {
        if($request->isJson()){
            //Validation  des données reçues, il faut un login et un password
           $request->validate([
               'login' => 'required',
               'password' => 'required'
           ]) ;
           //authentification login password
            $login = $request->json('login');
            $pwd = $request->json('password');
            $credentials=['login_visiteur' => $login, 'password' => $pwd];
            if(!Auth::attempt($credentials)){
                return response()->json(['status_message' => 'The provided credentials are incorrect.'], 401);
            }
            //on crée un token pour le visiteur authentifié
            $visiteur = $request->user();
            $token = $visiteur->createToken('auth_token')->plainTextToken;
            //On retourne au JSON
            return response()->json([
                'visiteur' =>[
                    'id_visiteur' => $visiteur->id_visiteur,
                    'nom_visiteur' => $visiteur->nom_visiteur,
                    'prenom_visiteur' => $visiteur->prenom_visiteur,
                    'type_visiteur' => $visiteur->type_visiteur,
                ],
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
        return response()->json(['error' => 'Request must be JSON'], 415);
    }
    public function logout(Request $request)  {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function unauthorized(){
        return response()->json(['error' => 'Unauthorized access']);
    }
}
