<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Image;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class DocumentController extends Controller
{
    public function documentStore(Request $request)
    {
        
       
        $image_path = $request->file('fichier')->store('fichier', 'public');

        $patient=$request->patient;
        $description=$request->description;


        $data = Document::create([
            'fichier' => $image_path,
            'patient' => $patient,
            'description' => $description,
        ]);

        return response($data, Response::HTTP_CREATED);
    }
}
