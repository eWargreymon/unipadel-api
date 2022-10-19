<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Integrante;
use App\Models\Jornada;
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
                'torneo:id,nombre',
                'jornada:id,numero'
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
                'torneo:id,nombre',
                'jornada:id,numero'
            )->get();
            return response()->json($partidos);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error', 'error' => $e->getMessage(),], 500);
        }
    }

    public function getJornadasTorneo($torneo)
    {
        $jornadas = Jornada::where('torneo_id', $torneo)->select('id','numero')->get();
        return response()->json($jornadas);
    }

    public function getPartidosTorneo(Request $request)
    {
        if (isset($request->jornada)) {
            $partidos = Partido::where('jornada_id', $request->jornada)->with(
                'horario',
                'horario.cancha:id,nombre',
                'pareja1:id,nombre',
                'pareja2:id,nombre',
                'torneo:id,nombre',
                'jornada:id,numero'
            )->get();
        } else {
            $partidos = Partido::where('torneo_id', $request->torneo)->with(
                'horario',
                'horario.cancha:id,nombre',
                'pareja1:id,nombre',
                'pareja2:id,nombre',
                'torneo:id,nombre',
                'jornada:id,numero'
            )->orderBy('jornada_id', 'asc')->get();
        }
        return response()->json($partidos);
    }

    public function setHorarioPartido(Request $request){
        $new_horario = Horario::find($request->horario);
        if($new_horario->ocupado != 0){
            return response()->json(['message' => 'El nuevo horario no se encuentra disponible'], 400);
        }
        
        $partido = Partido::find($request->partido);
        if($partido->horario_id != null){
            $old_horario = Horario::find($partido->horario_id);
            $old_horario->ocupado = 0;
            $old_horario->save();
        }
        
        $partido->horario_id = $new_horario->id;
        $partido->save();
        $new_horario->ocupado = 1;
        $new_horario->save();

        return response()->json(['message' => 'Horario asignado con éxito'], 200);
    }
}
