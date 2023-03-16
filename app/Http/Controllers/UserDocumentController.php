<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDocument;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserDocumentController extends ApiController
{

    private $allowed_extensions = ['pdf', 'jpg', 'png'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userDocs = UserDocument::select("user_document.*", "user.phone", DB::raw("CONCAT(user.first_name, ' ', user.last_name) AS full_name"), DB::raw("'Documentos personales' AS type"))
            ->join("user", "user.id", "=", "user_document.user_id")
            ->get();

        $vehicleDocs = Vehicle::select("vehicle_document.*", "vehicle.user_id", "user.phone", DB::raw("CONCAT(user.first_name, ' ', user.last_name) AS full_name"), DB::raw("'Documentos de vehículo' AS type"))
            ->join("vehicle_document", "vehicle_document.vehicle_plate", "=", "vehicle.plate")
            ->join("user", "user.id", "=", "vehicle.user_id")
            ->get();

        return $this->sendResponse([...$userDocs, ...$vehicleDocs], "Listado de documentos");
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
            "filename" => "required|min:2|max:255",
            "url" => "required|min:2|max:255|url",
            "extension" => "required|min:2|max:255|in:" . implode(',', $this->allowed_extensions),
            "user_id" => "required|exists:user,id",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $formData = new UserDocument();
        $formData->filename = $request->get('filename');
        $formData->url = $request->get('url');
        $formData->extension = $request->get('extension');
        $formData->user_id = $request->get('user_id');

        $formData->save();

        return $this->sendResponse("Documento creado correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserDocument  $userDocument
     * @return \Illuminate\Http\Response
     */
    public function show($documentId)
    {
        if (!isset($documentId)) {
            return $this->sendError("Not found", ["Identificador de documento no enviado"], 400);
        }

        $data = UserDocument::find($documentId);

        if (!isset($data)) {
            return $this->sendError("Not found", ["Documento no encontrado"], 400);
        }

        return $this->sendResponse($data, "Documento encontrado");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserDocument  $userDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $documentId)
    {
        $validator = Validator::make($request->all(), [
            "filename" => "required|min:2|max:255",
            "url" => "required|min:2|max:255|url",
            "extension" => "required|min:2|max:255|in:" . implode(',', $this->allowed_extensions),
            "user_id" => "required|exists:user,id",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error de validacion", $validator->errors(), 422);
        }

        $documentFound = UserDocument::find($documentId);

        if (!isset($documentFound)) {
            return $this->sendError("Not found", ["Documento no encontrado"], 400);
        }

        $documentFound->filename = $request->get('filename');
        $documentFound->url = $request->get('url');
        $documentFound->extension = $request->get('extension');
        $documentFound->user_id = $request->get('user_id');

        $documentFound->update();

        return $this->sendResponse("Documento actualizado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserDocument  $userDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy($documentId)
    {
        if (!isset($documentId)) {
            return $this->sendError("Not found", ["Identificador de documento no enviado"], 400);
        }

        $documentFound = UserDocument::find($documentId);

        if (!isset($documentFound)) {
            return $this->sendError("Not found", ["Documento no encontrado"], 400);
        }

        $documentFound->delete();

        return $this->sendResponse("Documento eliminado correctamente");
    }

    public function docsByUser($userId)
    {
        $docs = UserDocument::where('user_id', '=', $userId)->get();
        return $this->sendResponse($docs, "Listado de Documentos.");
    }

    public function usersValidateDocs()
    {
        $resultUsersQuery = User::select('user.id', DB::raw("CONCAT(\"user\".first_name, ' ', \"user\".last_name) AS full_name"), DB::raw("COALESCE('Documentos personales') AS type_doc"), 'user.phone')
            ->where('user.is_active', '=', false)
            ->orderBy('user.created_at', 'asc')->get();
        return $this->sendResponse($resultUsersQuery, "Listado de los usuarios con documentos pendientes de validar.");
    }
}
