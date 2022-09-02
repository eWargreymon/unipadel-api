<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->tipo = $request->tipo;
        $user->password = "";

        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Usuario añadido correctamente',
        ]);
    }

    public function getUser($email = null)
    {
        isset($email) ?
            $user = User::where('email', $email)->first()
            :
            $user = null;

        if ($user) {
            return response()->json([
                'status' => 200,
                'data' => $user,
            ]);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Usuario no encontrado',
            ]);
        }
    }

    public function getJugadores($nombre = null){
        if(isset($nombre)){
            $jugadores = User::where('tipo', 0)->where('name','LIKE','%'.$nombre.'%')->get();
            return $jugadores;
        }else{   
            $jugadores = User::where('tipo', 0)->get();
            return $jugadores;
        }
    }
}
