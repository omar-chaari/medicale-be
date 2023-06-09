<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


class ConsultationController extends Controller
{
    public function store(Request $request)
    {

        $data = Consultation::create([
            'professional' => $request->professional,
            'patient' => $request->patient,
            'date' => $request->date,
            'motif' => $request->motif,
            'notes' => $request->notes
        ]);

        return response($data, Response::HTTP_CREATED);
    }

    public function delete(Request $request)
    {
        // Find the consultation


        $id=$request->id;
        
        $consultation = Consultation::findOrFail($id);

        Log::info("id: $id");

        // Delete the associated documents
        $documents = $consultation->documents;
        if ($documents!=null)
        foreach ($documents as $document) {
            // Delete the document file
            Storage::disk('public')->delete($document->fichier);

            // Delete the document record from the database
            $document->delete();
        }

        // Delete the consultation
        $consultation->delete();

        return response()->json(['message' => 'Consultation deleted successfully']);
    }
}
