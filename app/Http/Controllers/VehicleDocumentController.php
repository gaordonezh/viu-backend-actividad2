<?php

namespace App\Http\Controllers;

use App\Models\VehicleDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return $this->sendResponse(VehicleDocument::paginate(10), "Listado de Documentos de vehiculo");
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

    public function usersValidateDocs(){
        $resultUsersQuery = VehicleDocument::select('vehicle.plate','vehicle.user_id',DB::raw("CONCAT(\"user\".first_name, ' ', \"user\".last_name) AS full_name"), DB::raw("COALESCE('Documentos de vehiculo') AS type_doc"),'user.phone')
            ->join('vehicle', 'vehicle_document.vehicle_plate', '=', 'vehicle.plate')
            ->join('user', 'user.id', '=', 'vehicle.user_id')
            ->where('is_valid','=', false)
            ->orderBy('vehicle_document.created_at','asc')->get();
        return $this->sendResponse($resultUsersQuery,"Listado de los usuarios con documentos pendientes de validar.");
    }

    public function docsToValidateByUser($userId,$vehiclePlate){
        $resultVehicleDocs = VehicleDocument::select('vehicle_document.*')
            ->join('vehicle', 'vehicle_document.vehicle_plate', '=', 'vehicle.plate')
            ->where('is_valid','=', false)
            ->where('vehicle_plate','=',$vehiclePlate)
            ->where('vehicle.user_id','=',$userId)->get();

        return $this->sendResponse($resultVehicleDocs,"Listado de Documentos de vehiculo.");
    }
}
