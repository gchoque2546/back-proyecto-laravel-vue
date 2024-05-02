<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function funLogin(Request $request) {
        // Validar
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        // Verificar
        if(!Auth::attempt($credenciales)){
            return response()->json(["message" => "No Autenticado"], 401);

        }
        // Generar Token
        $usuario = Auth::user();
        $token = $usuario->createToken("token personal")->plainTextToken;

        // Responder
        return response()->json([
            "access_token"=> $token,
            "type_token"=>"Bearer",
            "usuario" => $usuario
        ]);

    }
    function funRegistro(Request $request) {

        //Validar Datos
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "c_password" => "required|same:password"
        ]);

        // Guardar Usuario
        $usuario = new User;
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        //$usuario->password = Hash::make($request->password); Otra forma de cifrar Contraseña 
        $usuario->save();

        return response()->json(["message" => "Usuario Registrado"], 201);
    }
    function funPerfil() {
        return Auth::user();
    }
    function funSalir() {
        Auth::user()->tokens()->delete();
        return response()->json(["message" => "SALIO"]);
    }
}
