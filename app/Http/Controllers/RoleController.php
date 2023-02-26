<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Role::all();
        return $this->sendResponse($data, "Listado de roles");
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
            "level" => "required|min:2|max:20",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $formData = new Role();
        $formData->level = $request->get('level');
        $formData->save();

        return $this->sendResponse("Rol creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($roleId)
    {
        if (!isset($roleId)) {
            return $this->sendError("Not found", ["Rol no encontrado"], 400);
        }

        $data = Role::find($roleId);

        if (!isset($data)) {
            return $this->sendError("Not found", ["Rol no encontrado"], 400);
        }

        return $this->sendResponse($data, "Rol encontrado");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role)
    {
        $validator = Validator::make($request->all(), [
            "level" => "required|min:2|max:20",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $roleFinded = Role::find($role);

        if (!isset($roleFinded)) {
            return $this->sendError("Not found", ["Rol no encontrado"], 400);
        }

        $roleFinded->level = $request->get('level');
        $roleFinded->update();

        return $this->sendResponse("Rol actualizado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($roleId)
    {
        if (!isset($roleId)) {
            return $this->sendError("Not found", ["Rol no encontrado"], 400);
        }

        $roleFinded = Role::find($roleId);

        if (!isset($roleFinded)) {
            return $this->sendError("Not found", ["Rol no encontrado"], 400);
        }

        $roleFinded->delete();

        return $this->sendResponse("Rol eliminado correctamente");        
    }
}
