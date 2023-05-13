<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class SearchAppointementProController extends Controller
{
    //



    public function searchAppointement(Request $request)
    {
        $offset = $request->offset ? $request->offset : 0;
        $limit = $request->limit ? $request->limit : 10;
        $order_by = $request->order_by ? $request->order_by : "";
        $pro = $request->pro ? $request->pro : "";
        $sortColumn = $request->sortColumn ? $request->sortColumn : "date_debut";
        $sortOrder = $request->sortOrder ? $request->sortOrder : "desc";
        $date_debut = $request->date_debut ? $request->date_debut : "";
        $date_fin = $request->date_fin ? $request->date_fin : "";


        $result = $this->getTableListAppointement($offset, $limit, $order_by, $pro, $date_debut,$date_fin, $sortColumn, $sortOrder);
        $totalItems = $this->getTotalItemsAppointement($pro, $date_debut,$date_fin);
        $response = array(
            "data" => $result,
            "totalItems" => $totalItems,

        );

        return response($response, 200);
    }
    function getTableListAppointement($offset = 0, $limit = -1, $order_by, $pro, $date_debut,$date_fin, $sortColumn, $sortOrder)
    {






        $users = DB::table('appointements')
            ->select(
                'date_debut',
                'motif_consultation',
                'state',
                'users.first_name',
                'users.last_name',
                'users.id as professional_id',
                'appointements.id as appointement_id',

            )

            ->leftJoin('users', 'users.id', '=', 'appointements.professional')



            ->where(function ($q) use ($pro, $date_debut,$date_fin) {
                $q->where('appointements.patient', '=', $pro)
                    ->where('appointements.date_debut', '>=', $date_debut);

                   if($date_fin>"")
                   $q->where('appointements.date_fin', '>=', $date_fin);
                    
            })

            ->offset($offset)
            ->limit($limit)
            ->orderBy($sortColumn, $sortOrder)
            ->get();

        return $users;
    }

    function getTotalItemsAppointement($pro, $date_debut,$date_fin)
    {


        $users = DB::table('appointements')
            ->leftJoin('users', 'users.id', '=', 'appointements.professional')

            ->where(function ($q) use ($pro, $date_debut,$date_fin) {
                $q->where('appointements.patient', '=', $pro)
                    ->where('appointements.date_debut', '>=', $date_debut);

                   if($date_fin>"")
                   $q->where('appointements.date_fin', '>=', $date_fin);
                    
            })
            ->get();
        $totalrows = count($users);

        return $totalrows;
    }
}
