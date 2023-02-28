<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    private $email_pattern = "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i";
    private $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

    public function auth(Request $request)
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





    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->sendResponse("Logout exitoso");
    }
}
