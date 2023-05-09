<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class SearchAppointementController extends Controller
{
    //

  

    public function searchAppointement(Request $request)
    {
        $offset = $request->offset ? $request->offset : 0;
        $limit = $request->limit ? $request->limit : 10;
        $order_by = $request->order_by ? $request->order_by : "";
        $patient = $request->patient ? $request->patient : "";
        $sortColumn = $request->sortColumn ? $request->sortColumn : "date_debut";
        $sortOrder = $request->sortOrder ? $request->sortOrder : "desc";

        $result = $this->getTableListAppointement($offset, $limit, $order_by, $patient,$sortColumn, $sortOrder);
        $totalItems = $this->getTotalItemsAppointement($patient);
        $response = array(
            "data" => $result,
            "totalItems" => $totalItems,

        );

        return response($response, 200);
    }
    function getTableListAppointement($offset = 0, $limit = -1, $order_by, $patient , $sortColumn, $sortOrder)
    {



 


        $users = DB::table('appointements')
            ->select(
                'date_debut',
                'motif_consultation',
                'state',
                'users.first_name',
                'users.last_name',
                'users.id'

               
            )

            ->leftJoin('users', 'users.id', '=', 'appointements.professional')



            ->where(function ($q) use ($patient ) {
                $q->where('appointements.patient', '=', $patient);


                    
            })

            ->offset($offset)
            ->limit($limit)
            ->orderBy($sortColumn, $sortOrder)
            ->get();

        return $users;
    }

    function getTotalItemsAppointement($patient)
    {


        $users = DB::table('appointements')
            ->leftJoin('users', 'users.id', '=', 'appointements.professional')
            
            ->where(function ($q) use ( $patient) {
                $q->where('appointements.patient', '=', $patient)
                   
                   ;
            })
            ->get();
        $totalrows = count($users);

        return $totalrows;
    }

}
