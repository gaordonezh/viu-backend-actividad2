<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(Transaction::all(), "Listado de transacciones");
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
            "amount" => "required|decimal:0,2",
            "isDiscount" => "required|boolean",
            "date" => "required|date",
            "journey_id" => "required",
            "account_id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        Transaction::create($request->all());
        return $this->sendResponse("Transacción creada correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($transaction)
    {
        $data = Transaction::find($transaction);

        if (!isset($data)) {
            return $this->sendError("Not found", ["Transacción no encontrada"], 400);
        }

        return $this->sendResponse($data, "Transacción encontrada");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transaction)
    {
        $validator = Validator::make($request->all(), [
            "amount" => "required|decimal:0,2",
            "isDiscount" => "required|boolean",
            "date" => "required|date",
            "journey_id" => "required",
            "account_id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $vehicleFinded = Transaction::find($transaction);

        if (!isset($vehicleFinded)) {
            return $this->sendError("Not found", ["Transacción no encontrado"], 400);
        }

        $vehicleFinded->update($request->all());

        return $this->sendResponse("Transacción actualizada correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($transaction)
    {
        if (!isset($transaction)) {
            return $this->sendError("Not found", ["Transacción no encontrada"], 400);
        }

        $vehicleFinded = Transaction::find($transaction);

        if (!isset($vehicleFinded)) {
            return $this->sendError("Not found", ["Transacción no encontrada"], 400);
        }

        $vehicleFinded->delete();
        return $this->sendResponse(" Transacción eliminada correctamente");
    }
}
