<?php

namespace App\Http\Controllers;

use App\Models\UserDocument;
use Illuminate\Http\Request;
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
        $data = UserDocument::all();
        return $this->sendResponse($data, "Listado de documentos");
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
}