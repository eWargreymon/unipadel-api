<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Integrante;
use App\Models\Partido;
use Illuminate\Http\Request;

class PartidosController extends Controller
{

    public function getPartido($id)
    {
        try {
            $parejas = Integrante::where('id_jugador', $id)->select('id_pareja')->get()->pluck('id_pareja');
            $partidos = Partido::where('estado', 0)->whereIn('p1', $parejas)->orWhereIn('p2', $parejas)->with(
                'horario',
                'horario.cancha:id,nombre', 
                'pareja1:id,nombre', 
                'pareja2:id,nombre', 
                'torneo:id,nombre'
            )->first();
            return response()->json($partidos);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage(),], 500);
        }
    }

    public function getPartidos(Request $request)
    {
        try {
            $parejas = Integrante::where('id_jugador', $request->user)->select('id_pareja')->get()->pluck('id_pareja');
            $partidos = Partido::whereIn('p1', $parejas)->orWhereIn('p2', $parejas)->with(
                'horario',
                'horario.cancha:id,nombre', 
                'pareja1:id,nombre', 
                'pareja2:id,nombre', 
                'torneo:id,nombre'
            )->get();
            return response()->json($partidos);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage(),], 500);
        }
    }
}
