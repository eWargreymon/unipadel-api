<?php

namespace App\Http\Controllers;

use App\Models\Integrante;
use App\Models\Pareja;
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

    public function createPareja(Request $request){
        $pareja = new Pareja();
        $pareja->nombre = $request->nombre;
        $pareja->save();

        foreach($request->jugadores as $jugador){
            $integrante = new Integrante();
            $integrante->id_pareja = $pareja->id;
            $integrante->id_jugador = $jugador;
            $integrante->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Usuario añadido correctamente',
        ]);
    }

    public function getParejas($user){
        $id_user = User::where('email', $user)->first()->id;

        $integrantes = Integrante::where('id_jugador', $id_user)->get();

        $parejas = [];

        foreach($integrantes as $integrante){
            $pareja = Pareja::where('id', $integrante->id_pareja)->first();
            array_push($parejas, $pareja);
        }

        return $parejas;
    }
}
