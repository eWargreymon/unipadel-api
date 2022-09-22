<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Torneo;
use App\Models\User;
use App\Models\Inscripcion;
use App\Models\Pareja;
use App\Models\Integrante;

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

    public function inscripcion(Request $request)
    {
        try {
            $torneo = Torneo::findOrFail($request->torneo);

            if (Inscripcion::where('pareja_id', $request->pareja)->where('torneo_id', $torneo->id)->first() != null) {
                return response()->json(['message' => 'Ya existe una inscripción de la pareja para este torneo'], 500);
            }

            $num_inscripciones = Inscripcion::where('torneo_id', $torneo->id)->count();

            if ($torneo->max_parejas > $num_inscripciones) {
                $inscripcion = new Inscripcion();
                $inscripcion->pareja_id = $request->pareja;
                $inscripcion->torneo_id = $torneo->id;
                $inscripcion->save();

                return response()->json(['message' => 'Inscripción registrada'], 200);
            } else {

                return response()->json(['message' => 'El torneo se encuentra lleno'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error en la inscripción', 'error' => $e->getMessage(),], 500);
        }
    }

    public function getInscripciones($torneo)
    {
        $inscripciones = Inscripcion::where('torneo_id', $torneo)->get();

        $equipos = [];

        foreach ($inscripciones as $inscripcion) {
            $equipo = Pareja::where('id', $inscripcion->pareja_id)->first();
            $equipoI["id"] = $equipo->id;
            $equipoI["nombre"] = $equipo->nombre;
            $integrantes = Integrante::where('id_pareja', $equipo->id)->get();
            $usuarios = [];
            foreach ($integrantes as $integrante) {
                $user = User::where('id', $integrante->id_jugador)->first(['id', 'name']);
                array_push($usuarios, $user);
            }
            $equipoI["usuarios"] = $usuarios;
            array_push($equipos, $equipoI);
        }

        return response()->json($equipos);
    }

    public function createRecurso(Request $request)
    {
        $turno = $this->getDuracionTurno($request[0]['inicio'], $request[0]['fin'], $request[0]['turnos']);

        $torneo_id = 1;
        $torneo = Torneo::where('id', $torneo_id)->first();
        $fecha_inicio = strtotime($torneo->fecha_inicio);
        $fecha_fin = strtotime($torneo->fecha_fin);

        $hora = $request[0]['inicio'];
        $turnos = $request[0]['turnos'];
        $horarios = [];

        if ($request[0]['lunes']) {
            for ($fecha_inicio; $fecha_inicio <= $fecha_fin; $fecha_inicio = strtotime("+7 day", $fecha_inicio)) {
                $next_monday = strtotime("monday", $fecha_inicio);
                
                if ($next_monday > $fecha_fin) break;

                $inicio = strtotime(date('d-m-Y',$next_monday). ' ' . $hora);

                for ($i = 0; $i < $turnos; $i++) {

                    $horario['inicio'] = date('d-m-Y H:i', $inicio);
                    $inicio += $turno;
                    $horario['fin'] = date('d-m-Y H:i', $inicio);

                    array_push($horarios, $horario);
                }
            }
            dd($horarios);
        }

        // dd($horarios);

        // $hours = date("H", $dif);
        // $duracion = $hours / $request[0]['turnos'];
        // dd($duracion * 60);
        // dd($this->SplitTime($inicio, $fin, '60'));
    }

    public function getDuracionTurno($inicio, $fin, $turnos)
    {
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);
        $dif = $fin - $inicio;
        $interval = $dif / $turnos;
        return $interval;
    }

    // Apuntes
    // Function taken from W3schools: https://www.w3schools.in/php/examples/split-a-time-slot-between-the-start-and-end-time-using-the-time-interval
    // public function SplitTime($StartTime, $EndTime, $Duration = "60")
    // {
    //     $ReturnArray = array(); // Define output
    //     $StartTime    = strtotime($StartTime); //Get Timestamp
    //     $EndTime      = strtotime($EndTime); //Get Timestamp

    //     $AddMins  = $Duration * 60;

    //     while ($StartTime <= $EndTime) //Run loop
    //     {
    //         $ReturnArray[] = date("G:i", $StartTime);
    //         $StartTime += $AddMins; //Endtime check
    //     }
    //     return $ReturnArray;
    // }
}
