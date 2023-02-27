<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends ApiController
{

    private $double_pattern = "/^\d+(\.\d{1,2})?$/";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Account::all();
        return $this->sendResponse($data, "Listado de cuentas");
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
            "account" => "required|unique:account|min:2|max:255",
            "amount" => "required|numeric|regex:" . $this->double_pattern,
            "user_id" => "required|unique:account|exists:user,id",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $formData = new Account();
        $formData->account = $request->get('account');
        $formData->amount = $request->get('amount');
        $formData->user_id = $request->get('user_id');

        $formData->save();

        return $this->sendResponse("Cuenta creada correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show($accountId)
    {
        if (!isset($accountId)) {
            return $this->sendError("Not found", ["Identificador de cuenta no enviado"], 400);
        }

        $data = Account::find($accountId);

        if (!isset($data)) {
            return $this->sendError("Not found", ["Cuenta no encontrada"], 400);
        }

        return $this->sendResponse($data, "Cuenta encontrada");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $accountId)
    {
        $validator = Validator::make($request->all(), [
            "account" => "required|min:2|max:255|unique:account,account," . $accountId,
            "amount" => "required|numeric|regex:" . $this->double_pattern,
            "user_id" => "required|exists:user,id|unique:account,user_id," . $accountId,
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $accountFound = Account::find($accountId);

        if (!isset($accountFound)) {
            return $this->sendError("Not found", ["Cuenta no encontrada"], 400);
        }

        $accountFound->account = $request->get('account');
        $accountFound->amount = $request->get('amount');
        $accountFound->user_id = $request->get('user_id');

        $accountFound->update();

        return $this->sendResponse("Cuenta actualizada correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($accountId)
    {
        if (!isset($accountId)) {
            return $this->sendError("Not found", ["Identificador de cuenta no enviado"], 400);
        }

        $accountFound = Account::find($accountId);

        if (!isset($accountFound)) {
            return $this->sendError("Not found", ["Cuenta no encontrada"], 400);
        }

        $accountFound->delete();

        return $this->sendResponse("Cuenta eliminada correctamente");
    }
}