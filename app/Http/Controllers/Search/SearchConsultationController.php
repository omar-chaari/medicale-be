<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class SearchConsultationController extends Controller
{
    //



    public function searchConsultation(Request $request)
    {
        $offset = $request->offset ? $request->offset : 0;
        $limit = $request->limit ? $request->limit : 10;
        $order_by = $request->order_by ? $request->order_by : "";
        $patient = $request->patient ? $request->patient : "";
        $sortColumn = $request->sortColumn ? $request->sortColumn : "date";
        $sortOrder = $request->sortOrder ? $request->sortOrder : "desc";


        $result = $this->getTableListConsultation($offset, $limit, $order_by, $patient,  $sortColumn, $sortOrder);
        $totalItems = $this->getTotalItemsConsultation($patient);
        $response = array(
            "data" => $result,
            "totalItems" => $totalItems,

        );

        return response($response, 200);
    }

    function getTableListConsultation($offset = 0, $limit = -1, $order_by, $patient, $sortColumn, $sortOrder)
    {
        $consultations = DB::table('consultations')
            ->select(
                'consultations.id as consultation_id',
                'consultations.date',
                'motif',
                'notes',
                'users.first_name',
                'users.last_name',
                'users.id as professional_id',
                'documents.id as document_id',
                'documents.fichier as fichier',
                'documents.description',
            )
            ->leftJoin('users', 'users.id', '=', 'consultations.professional')
            ->leftJoin('documents', 'documents.consultation', '=', 'consultations.id')
            ->where('consultations.patient', '=', $patient)
            ->offset($offset)
            ->limit($limit)
            ->orderBy($sortColumn, $sortOrder)
            ->get();

        // Group the consultations by their IDs and collect the documents
        $consultationData = collect($consultations)->groupBy('consultation_id')->map(function ($groupedConsultations) {
            $consultation = $groupedConsultations->first();


            // Extract the document information for each consultation
            $documents = $groupedConsultations->map(function ($item) {
                            return $item->document_id !== null;

                return [
                    'document_id' => $item->document_id,
                    'fichier' => $item->fichier,
                    'description' => $item->description,
                ];
            })->all();

            $consultation->documents = $documents;
            return $consultation;
        });

        return $consultationData;
    }


    function getTotalItemsConsultation($patient)
    {


        $users = DB::table('consultations')
            ->leftJoin('users', 'users.id', '=', 'consultations.professional')

            ->where(function ($q) use ($patient) {
                $q->where('consultations.patient', '=', $patient);
            })
            ->get();
        $totalrows = count($users);

        return $totalrows;
    }
}
