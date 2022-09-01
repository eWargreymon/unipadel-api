<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Torneo;
use App\Models\User;
use App\Models\Inscripcion;

class TorneoController extends Controller
{
    public function getTorneo($id = null)
    {
        if (isset($id)) {
            $torneo = Torneo::where('id', $id)->first();
        } else {
            $torneo = Torneo::all();
        }
        return response()->json($torneo);
    }

    public function getTorneosOrganizador($organizador)
    {
        $organizador_id = User::where('email', $organizador)->first()->id;
        $torneos = Torneo::where('organizador_id', $organizador_id)->get();
        return response()->json($torneos);
    }

    public function store(Request $request)
    {
        $organizador_id = User::where('email', $request->organizador)->first()->id;
        
        $torneo = new Torneo();
        $torneo->nombre = $request->nombre;
        $torneo->fecha_inicio = date('Y-m-d', strtotime($request->fecha_inicio));
        $torneo->fecha_fin = date('Y-m-d', strtotime($request->fecha_fin));
        $torneo->fecha_limite = date('Y-m-d', strtotime($request->fecha_limite));
        $torneo->formato = $request->formato;
        $torneo->ciudad = $request->ciudad;
        $torneo->club = $request->club;
        $torneo->max_parejas = $request->max_jugadores;
        $torneo->precio = $request->precio;
        $torneo->descripcion = $request->descripcion;
        $torneo->activo = $request->activo;
        $torneo->organizador_id = $organizador_id;

        if ($torneo->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'Torneo creado correctamente',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'No se ha podido crear el torneo',
            ]);
        }
    }

    public function inscripcion(Request $request){
        try{

            $user = User::where('email',$request->user)->first()->id;
            $torneo = Torneo::findOrFail($request->torneo);

            if(Inscripcion::where('jugador_id', $user)->where('torneo_id', $torneo->id)->first() != null){
                return response()->json(['message' => 'Ya existe una inscripción del usuario para este torneo'], 500);
            }

            $num_inscripciones = Inscripcion::where('torneo_id', $torneo->id)->count();

            if($torneo->max_jugadores*2 - $num_inscripciones > 1){
                $inscripcion = new Inscripcion();
                $inscripcion->jugador_id = $user;
                $inscripcion->torneo_id = $torneo->id;
                $inscripcion->save();
                
                return response()->json(['message' => 'Inscripción registrada'], 200);
            } else {
                
                return response()->json(['message' => 'El torneo se encuentra lleno'], 500);
            }
    
        } catch(\Exception $e){
            return response()->json(['message' => 'Error en la inscripción', 'error' => $e->getMessage(),], 500);
        }
        
    }
}
