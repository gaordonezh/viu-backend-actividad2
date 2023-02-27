<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Address::all();
        return $this->sendResponse($data, "Listado de direcciones");
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
            "region" => "required|min:2|max:255",
            "province" => "required|min:2|max:255",
            "district" => "required|min:2|max:255",
            "address" => "required|min:2|max:255",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $formData = new Address();
        $formData->region = $request->get('region');
        $formData->province = $request->get('province');
        $formData->district = $request->get('district');
        $formData->address = $request->get('address');

        $formData->save();

        return $this->sendResponse("Direccion creada correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show($addressId)
    {
        if (!isset($addressId)) {
            return $this->sendError("Not found", ["Identificador de direccion no enviado"], 400);
        }

        $data = Address::find($addressId);

        if (!isset($data)) {
            return $this->sendError("Not found", ["Direccion no encontrada"], 400);
        }

        return $this->sendResponse($data, "Direccion encontrada");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $addressId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $addressId)
    {
        $validator = Validator::make($request->all(), [
            "region" => "required|min:2|max:255",
            "province" => "required|min:2|max:255",
            "district" => "required|min:2|max:255",
            "address" => "required|min:2|max:255",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $addressFound = Address::find($addressId);

        if (!isset($addressFound)) {
            return $this->sendError("Not found", ["Direccion no encontrada"], 400);
        }

        $addressFound->region = $request->get('region');
        $addressFound->province = $request->get('province');
        $addressFound->district = $request->get('district');
        $addressFound->address = $request->get('address');

        $addressFound->update();

        return $this->sendResponse("Direccion actualizada correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy($addressId)
    {
        if (!isset($addressId)) {
            return $this->sendError("Not found", ["Identificador de direccion no enviado"], 400);
        }

        $addressFound = Address::find($addressId);

        if (!isset($addressFound)) {
            return $this->sendError("Not found", ["Direccion no encontrada"], 400);
        }

        $addressFound->delete();

        return $this->sendResponse("Direccion eliminada correctamente");
    }
}