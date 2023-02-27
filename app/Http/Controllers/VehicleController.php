<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends ApiController
{

    private $object_name = 'Vehiculo';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->sendResponse(Vehicle::all(), "Listado de Vehiculos");
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
            "plate" => "required|unique:vehicle,plate",
            "type" => "required",
            "brand" => "required",
            "reference" => "required",
            "model" => "required|max:5",
            "color" => "required|max:20",
            "ability" => "required",
            "user_id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }
        Vehicle::create($request->all());
        return $this->sendResponse($this->object_name ." creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($vehicle)
    {
        $data = Vehicle::find($vehicle);

        if (!isset($data)) {
            return $this->sendError("Not found", ["Vehiculo no encontrado"], 400);
        }

        return $this->sendResponse($data, $this->object_name. " encontrado");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $vehicle)
    {
        $validator = Validator::make($request->all(), [
            "type" => "required",
            "brand" => "required",
            "reference" => "required",
            "model" => "required|max:5",
            "color" => "required|max:20",
            "ability" => "required",
            "user_id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $vehicleFinded = Vehicle::find($vehicle);

        if (!isset($vehicleFinded)) {
            return $this->sendError("Not found", [$this->object_name. " no encontrado"], 400);
        }

        $vehicleFinded->update($request->all());

        return $this->sendResponse($this->object_name. " actualizado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($vehicle)
    {
        if (!isset($vehicle)) {
            return $this->sendError("Not found", [$this->object_name. " no encontrado"], 400);
        }

        $vehicleFinded = Vehicle::find($vehicle);

        if (!isset($vehicleFinded)) {
            return $this->sendError("Not found", [$this->object_name. " no encontrado"], 400);
        }

         $vehicleFinded->delete();
         return $this->sendResponse($this->object_name." eliminado correctamente");
    }
}
