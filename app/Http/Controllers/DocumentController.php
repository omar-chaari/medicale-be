<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


class DocumentController extends Controller
{
    public function documentStore(Request $request)
    {


        $image_path = $request->file('fichier')->store('fichier', 'public');

        $consultation = $request->consultation;
        $description = $request->description;


        $data = Document::create([
            'fichier' => $image_path,
            'consultation' => $consultation,
            'description' => $description,
        ]);

        return response($data, Response::HTTP_CREATED);
    }
    public function documentDelete(Request $request)
    {
        $id=$request->id;
        // Retrieve the document from the database
        $document = Document::find($id);

        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        // Delete the associated file from storage
        Storage::delete($document->fichier);

        // Remove the document from the database
        $document->delete();

        return response()->json(['message' => 'Document deleted successfully'], 200);
    }
}
