<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    private $text_pattern = "/^([A-Za-z ñáéíóú]+)$/";
    private $phone_pattern = "/(?=[+]{1}+[0-9]{8,11})$/i";
    private $email_pattern = "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i";
    private $dni_pattern = "/(?=[0-9]{8}+[A-Za-z]{1}){9}/";
    private $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    private $iban_pattern = "/(?=[A-Z]{2}+[0-9]{22}){24}/";

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|regex:" . $this->email_pattern,
            'password' => "required|regex:" . $this->password_pattern
        ]);

        if ($validator->fails()) {
            return $this->sendError("Auth error", ["Usuario y / o contraseña incorrecto."], 400);
        }

        // IS PASSED
        $user = User::where("email", "=", $request->get('email'))->first();

        if (!isset($user)) {
            return $this->sendError("Auth error", ["Usuario y / o contraseña incorrecto."], 400);
        }

        if (!Hash::check($request->get('password'), $user->password)) {
            return $this->sendError("Auth error", ["Usuario y / o contraseña incorrecto."], 400);
        }

        $token = $user->createToken("auth_token")->plainTextToken;
        $user->access_token = $token;

        return $this->sendResponse($user, "Login exitoso");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                "first_name" => "required|min:2|max:20|regex:" . $this->text_pattern,
                "last_name" => "required|min:2|max:40|regex:" . $this->text_pattern,
                "dni" => "required|min:9|max:9|regex:" . $this->dni_pattern,
                "email" => "required|email|unique:user|regex:" . $this->email_pattern,
                'password' => "required|confirmed|regex:" . $this->password_pattern,
                "phone" => "min:9|max:12|regex:" . $this->phone_pattern,
                "country" => "regex:" . $this->text_pattern,
                "iban" => "required|regex:" . $this->iban_pattern,
                "about" => "min:20|max:250"
            ],
            [
                "password.regex" => "Mínimo ocho caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial"
            ]
        );

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $formData = new User();
        $formData->first_name = $request->get('first_name');
        $formData->last_name = $request->get('last_name');
        $formData->dni = $request->get('dni');
        $formData->email = $request->get('email');
        $formData->password = Hash::make($request->get('password'));
        $formData->phone = $request->get('phone');
        $formData->country = $request->get('country');
        $formData->iban = $request->get('iban');
        $formData->about = $request->get('about');
        $formData->save();

        return $this->sendResponse("Usuario creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
