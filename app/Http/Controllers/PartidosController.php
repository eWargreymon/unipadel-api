<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Inscripcion;
use App\Models\Integrante;
use App\Models\Jornada;
use App\Models\Partido;
use Illuminate\Http\Request;

class PartidosController extends Controller
{

    public function getPartido($id, $torneo = null)
    {
        try {
            $parejas = Integrante::where('id_jugador', $id)->select('id_pareja')->get()->pluck('id_pareja');
            $query = Partido::where('estado', 0);
            $query->when(isset($torneo), function ($q) use ($torneo) {
                return $q->where('torneo_id', $torneo);
            });
            $partido = $query
                ->whereIn('p1', $parejas)
                ->orWhereIn('p2', $parejas)
                ->with(
                    'horario',
                    'horario.cancha:id,nombre',
                    'pareja1:id,nombre',
                    'pareja2:id,nombre',
                    'torneo:id,nombre',
                    'jornada:id,numero'
                )->first();
            return response()->json($partido);
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
        $jornadas = Jornada::where('torneo_id', $torneo)->select('id', 'numero')->get();
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

    public function getPartidosTorneoPlayer(Request $request)
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

        $parejas = Integrante::where('id_jugador', $request->jugador)->select('id_pareja')->get()->pluck('id_pareja')->toArray();
        foreach ($partidos as $partido){
            if(in_array($partido->p1, $parejas) || (in_array($partido->p2, $parejas))){
                $partido->propio = true;
            } else {
                $partido->propio = false;
            }
        }
        return response()->json($partidos);
    }

    public function setHorarioPartido(Request $request)
    {
        $new_horario = Horario::find($request->horario);
        if ($new_horario->ocupado != 0) {
            return response()->json(['message' => 'El nuevo horario no se encuentra disponible'], 400);
        }

        $partido = Partido::find($request->partido);
        if ($partido->horario_id != null) {
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
    
    public function proponerHorarioPartido(Request $request){
        $new_horario = Horario::find($request->horario);
        if ($new_horario->ocupado != 0) {
            return response()->json(['message' => 'El nuevo horario no se encuentra disponible'], 400);
        } else {
            $new_horario->ocupado = 1;
            $new_horario->save();
        }
        
        $partido = Partido::find($request->partido);

        $parejas = Integrante::where('id_jugador', $request->user)->select('id_pareja')->get()->pluck('id_pareja')->toArray();
        $pareja_torneo = Inscripcion::whereIn('pareja_id', $parejas)->where('torneo_id', $partido->torneo_id)->first();
        
        $partido->propuesta = $pareja_torneo->id;
        $partido->horario_propuesto = $request->horario;
        $partido->save();

        return response()->json(['message' => 'Horario propuesto con éxito'], 200);
    }
}
