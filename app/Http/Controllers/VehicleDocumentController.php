<?php

namespace App\Http\Controllers;

use App\Models\VehicleDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleDocumentController extends ApiController
{
     private $object_name = 'Documento de vehiculo';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->sendResponse(VehicleDocument::all(), "Listado de Documentos de vehiculo");
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
            "name" => "required",
            "url" => "required",
            "extension" => "required",
            "vehicle_plate" => "required"
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }
        VehicleDocument::create($request->all());
        return $this->sendResponse($this->object_name ." creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleDocument  $vehicleDocument
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($vehicleDocument)
    {
        $data = VehicleDocument::find($vehicleDocument);

        if (!isset($data)) {
            return $this->sendError("Not found", ["Documento de vehiculo no encontrado"], 400);
        }

        return $this->sendResponse($data, $this->object_name ." encontrado");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleDocument  $vehicleDocument
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $vehicleDocument)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "url" => "required",
            "extension" => "required",
            "vehicle_plate" => "required"
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $vehicleDocumentFinded = VehicleDocument::find($vehicleDocument);

        if (!isset($vehicleDocumentFinded)) {
            return $this->sendError("Not found", [$this->object_name ." no encontrado"], 400);
        }

        $vehicleDocumentFinded->update($request->all());

        return $this->sendResponse($this->object_name ." actualizado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleDocument  $vehicleDocument
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($vehicleDocument)
    {
        if (!isset($vehicleDocument)) {
            return $this->sendError("Not found", [$this->object_name ." no encontrado"], 400);
        }

        $vehicleDocumentFinded = VehicleDocument::find($vehicleDocument);

        if (!isset($vehicleDocumentFinded)) {
            return $this->sendError("Not found", [$this->object_name ." no encontrado"], 400);
        }

        $vehicleDocumentFinded->delete();
        return $this->sendResponse($this->object_name ." eliminado correctamente");
    }
}
