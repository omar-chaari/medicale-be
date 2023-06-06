<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ConsultationController extends Controller
{
    public function store(Request $request)
    {

        $data = Consultation::create([
            'professional' =>$request->professional,
            'patient'=>$request->patient,
            'date' =>$request->date,
            'motif'=>$request->motif,
            'notes'=>$request->notes
            ]);

        return response($data, Response::HTTP_CREATED);
    }
}
