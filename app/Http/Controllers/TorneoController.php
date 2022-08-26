<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Torneo;

class TorneoController extends Controller
{
    public function getTorneo($id=null){
        if(isset($id)){
            $torneo = Torneo::where('id', $id)->first();
        } else {
            $torneo = Torneo::all();
        }
        return response()->json($torneo);
    }
}
