<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JourneyController extends ApiController
{
    private $object_name = 'Viaje';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $journeys = Journey::query()
            ->join('vehicle', 'vehicle.plate', '=', 'journey.vehicle_plate')
            ->join('user','user.id', '=','vehicle.user_id');

        // Aplicar filtros
        if ($request->filled('ndoc')) {
            $journeys->where('user.ndoc', '=', $request->ndoc);
        }
        if ($request->filled('name_lastname')) {
            $journeys->where('user.first_name', 'LIKE', '%' .$request->name_lastname. '%')
                     ->orWhere('user.last_name', 'LIKE', '%' .$request->name_lastname. '%');
        }
        if ($request->filled('created_at')) {
            $journeys->whereRaw('DATE(journey.created_at) = ?', [$request->created_at]);
        }
        if ($request->filled('status')) {
            $journeys->where('status', '=', $request->status);
        }

        $journeys = $journeys->paginate(10);

        return $this->sendResponse($journeys, "Listado de Viajes");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "origin" => "required",
            "destiny" => "required",
            "datetime_start" => "required",
            "datetime_end" => "required",
            "quotas" => "required",
            "price" => "required",
            "description" => "required",
            "vehicle_plate" => "required"
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }
        Journey::create($request->all());
        return $this->sendResponse($this->object_name ." creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Journey  $journey
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($journey)
    {
        $data = Journey::find($journey);

        if (!isset($data)) {
            return $this->sendError("Not found", [$this->object_name. " no encontrado"], 400);
        }

        return $this->sendResponse($data, $this->object_name. " encontrado");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Journey  $journey
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$journey)
    {
        $validator = Validator::make($request->all(), [
            "origin" => "required",
            "destiny" => "required",
            "datetime_start" => "required",
            "datetime_end" => "required",
            "quotas" => "required",
            "price" => "required",
            "description" => "required",
            "vehicle_plate" => "required"
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $journeyFinded = Journey::find($journey);

        if (!isset($journeyFinded)) {
            return $this->sendError("Not found", [$this->object_name. " no encontrado"], 400);
        }

        $journeyFinded->update($request->all());

        return $this->sendResponse($this->object_name. " actualizado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Journey  $journey
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($journey)
    {
        if (!isset($journey)) {
            return $this->sendError("Not found", [$this->object_name. " no encontrado"], 400);
        }

        $journeyFinded = Journey::find($journey);

        if (!isset($journeyFinded)) {
            return $this->sendError("Not found", [$this->object_name. " no encontrado"], 400);
        }

        $journeyFinded->delete();
        return $this->sendResponse($this->object_name." eliminado correctamente");
    }

    public function transactionSummary(){

        $result['incourse'] = Journey::where('status','=','EN CURSO')
            ->count() ;

        $result['finished'] = Journey::where('status','=','FINALIZADO')
            ->count();

        $result['totalEarnings'] = (Journey::where('status','=','FINALIZADO')
                ->sum('journey.price')) * 0.1;

        $result['todaysEarnings'] = (Journey::where('status','=','FINALIZADO')
            ->whereDate('datetime_end', date('Y-m-d'))->get()
            ->sum('journey.price')) * 0.1;

        return $this->sendResponse($result, "Consulta realizada");
    }
}
