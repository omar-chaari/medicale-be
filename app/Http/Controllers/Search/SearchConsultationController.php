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
    function getTableListConsultation($offset = 0, $limit = -1, $order_by, $patient,  $sortColumn, $sortOrder)
    {

     
        $users = DB::table('consultations')
            ->select(
                'date',
                'motif',
                'notes',
                'users.first_name',
                'users.last_name',
                'users.id as professional_id',
                'consultations.id as consultation_id',
            )

            ->leftJoin('users', 'users.id', '=', 'consultations.professional')
            


            ->where(function ($q) use ($patient) {
                $q->where('consultations.patient', '=', $patient) ;
            })

            ->offset($offset)
            ->limit($limit)
            ->orderBy($sortColumn, $sortOrder)
            ->get();

        return $users;
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
