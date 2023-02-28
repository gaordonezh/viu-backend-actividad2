<?php

namespace App\Http\Controllers;

use App\Models\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QualificationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(Qualification::all(), "Listado de calificaciones");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "stars" => "required|numeric:1,5",
            "comment" => "required|max:250",
            "journey_id" => "required",
            "user_id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        Qualification::create($request->all());

        return $this->sendResponse("Calificación creada correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function show($qualification)
    {
        $data = Qualification::find($qualification);

        if (!isset($data)) {
            return $this->sendError("Not found", ["Calificación no encontrada"], 400);
        }

        return $this->sendResponse($data, "Calificación encontrada");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $qualification)
    {
        $validator = Validator::make($request->all(), [
            "stars" => "required|numeric:1,5",
            "comment" => "required|max:250",
            "journey_id" => "required",
            "user_id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $dataFinded = Qualification::find($qualification);

        if (!isset($dataFinded)) {
            return $this->sendError("Not found", ["Calificación no encontrada"], 400);
        }

        $dataFinded->update($request->all());

        return $this->sendResponse("Calificación actualizada correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function destroy($qualification)
    {
        if (!isset($qualification)) {
            return $this->sendError("Not found", ["Calificación no encontrada"], 400);
        }

        $dataFinded = Qualification::find($qualification);

        if (!isset($dataFinded)) {
            return $this->sendError("Not found", ["Calificación no encontrada"], 400);
        }

        $dataFinded->delete();
        return $this->sendResponse(" Calificación eliminada correctamente");
    }
}
