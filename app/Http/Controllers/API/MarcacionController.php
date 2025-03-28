<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Marcacion;
use Illuminate\Http\Request;

class MarcacionController extends Controller
{

    public function registrarMarcacion(Request $request)
    {


        /*
         *'ingreso','salida','almuerzo_inicio','almuerzo_fin'
         * Un empleado no puede marcar dos veces seguidas el mismo tipo de marcación
        sin haber realizado la siguiente correspondiente (ejemplo: no puede registrar
        dos ingresos seguidos sin una salida).
         Si una marcación de almuerzo se registra, debe haber una correspondiente de
        regreso.
         *
         * */


        $empleado_id = $request->empleado_id;
        $tipo_marcacion = $request->tipo_marcacion;
        $hoy = date('Y-m-d');


        $ultimaMarcacion = Marcacion::where('empleado_id', $empleado_id)
            ->whereDate('created_at', $hoy)
            ->latest()
            ->first();


        if ($ultimaMarcacion) {
            if ($ultimaMarcacion->tipo_marcacion === $tipo_marcacion) {
                return response()->json(['error' => 'No puedes registrar dos veces seguidas el mismo tipo de marcación.'], 400);
            }

            if ($ultimaMarcacion->tipo_marcacion === 'almuerzo_inicio' && $tipo_marcacion !== 'almuerzo_fin') {
                return response()->json(['error' => 'Después de almuerzo_inicio, debes marcar almuerzo_fin.'], 400);
            }
        }




        $datos = Marcacion::updateOrCreate(
            ['id' => $request->id], // Condición para buscar si existe
            [
                'empleado_id' => $request->empleado_id,
                'tipo_marcacion' => $request->tipo_marcacion,
            ]
        );

        return response()->json($datos);



    }


    public function obtenerMarcacion($id)
    {

        $datos = Marcacion::where('empleado_id','=',$id)
            ->get()
            ->map(function($query){
               return  [
                 'id'=> $query->id,
                   'empleado_id'=> $query->id,
                   'empleado'=> $query->empleado->nombre ?? '',
                   'tipo_marcacion' => $query->tipo_marcacion ?? '',
                   'tiempo' => $query->created_at ?? '',
               ];
            });

        return response()->json($datos);
    }

}
