<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Torneo;
use App\Models\User;

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
        $torneo->max_jugadores = $request->max_jugadores;
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
}
