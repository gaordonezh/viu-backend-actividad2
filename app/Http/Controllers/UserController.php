<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    private $text_pattern = "/^([A-Za-z ñáéíóú]+)$/";
    private $phone_pattern = "/^\+[0-9]{8,11}$/";
    private $email_pattern = "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i";
    private $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        return $this->sendResponse($data, "Listado de usuarios");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "ndoc" => "required|unique:user|min:2|max:10",
                "tdoc" => "required|in:DNI,CARNET EXT,RUC,PASAPORTE",
                "first_name" => "required|min:2|max:20|regex:" . $this->text_pattern,
                "last_name" => "required|min:2|max:40|regex:" . $this->text_pattern,
                "phone" => "min:9|max:12|regex:" . $this->phone_pattern,
                "email" => "required|email|unique:user|regex:" . $this->email_pattern,
                'password' => "required|confirmed|regex:" . $this->password_pattern,
                'is_active' => "required|in:0,1",
                'address_id' => "required|exists:address,id",
                'role_id' => "required|exists:role,id",
            ],
            [
                "password.regex" => "Mínimo ocho caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial"
            ]
        );

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $formData = new User();
        $formData->ndoc = $request->get('ndoc');
        $formData->tdoc = $request->get('tdoc');
        $formData->first_name = $request->get('first_name');
        $formData->last_name = $request->get('last_name');
        $formData->phone = $request->get('phone');
        $formData->email = $request->get('email');
        $formData->password = Hash::make($request->get('password'));
        $formData->is_active = $request->get('is_active');
        $formData->address_id = $request->get('address_id');
        $formData->role_id = $request->get('role_id');

        $formData->save();

        return $this->sendResponse("Usuario creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        if (!isset($userId)) {
            return $this->sendError("Not found", ["Identificador de usuario no enviado"], 400);
        }

        $data = User::find($userId);

        if (!isset($data)) {
            return $this->sendError("Not found", ["Usuario no encontrado"], 400);
        }

        return $this->sendResponse($data, "Usuario encontrado");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $addressId)
    {
        $validator = Validator::make($request->all(), [
            "ndoc" => "required|min:2|max:10|unique:user,ndoc,".$addressId,
            "tdoc" => "required|in:DNI,CARNET EXT,RUC,PASAPORTE",
            "first_name" => "required|min:2|max:20|regex:" . $this->text_pattern,
            "last_name" => "required|min:2|max:40|regex:" . $this->text_pattern,
            "phone" => "min:9|max:12|regex:" . $this->phone_pattern,
            "email" => "required|email|regex:" . $this->email_pattern. "|unique:user,email,".$addressId,
            'is_active' => "required|in:0,1",
            'address_id' => "required|exists:address,id",
            'role_id' => "required|exists:role,id",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $userFound = User::find($addressId);

        if (!isset($userFound)) {
            return $this->sendError("Not found", ["Usuario no encontrado"], 400);
        }

        $userFound->ndoc = $request->get('ndoc');
        $userFound->tdoc = $request->get('tdoc');
        $userFound->first_name = $request->get('first_name');
        $userFound->last_name = $request->get('last_name');
        $userFound->phone = $request->get('phone');
        $userFound->email = $request->get('email');
        $userFound->is_active = $request->get('is_active');
        $userFound->address_id = $request->get('address_id');
        $userFound->role_id = $request->get('role_id');

        $userFound->update();

        return $this->sendResponse("Usuario actualizado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($addressId)
    {
        if (!isset($addressId)) {
            return $this->sendError("Not found", ["Identificador de usuario no enviado"], 400);
        }

        $userFound = User::find($addressId);

        if (!isset($userFound)) {
            return $this->sendError("Not found", ["Usuario no encontrado"], 400);
        }

        $userFound->delete();

        return $this->sendResponse("Usuario eliminado correctamente");
    }
}