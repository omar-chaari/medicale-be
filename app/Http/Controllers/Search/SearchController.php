<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use DB;

class SearchController extends Controller
{
    //

    public function search(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $results_per_page = $request->results_per_page ? $request->results_per_page : -1;
        $tableID = $request->tableID;
        $where = $request->where ? $request->where : "";
        $fields = $request->fields;
        $order_by = $request->order_by ? $request->order_by : "";
        $search = $request->search ? $request->search : "";
        $tableMaxLimit = $results_per_page;

        $result = $this->getTableList($tableID, $where, $tableMaxLimit, $page, $fields, $order_by, $search);
        $totalItems = $this->getTotalItems($tableID, $where, $fields, $search);

        $response = array(
            "data" => $result,
            "totalItems" => $totalItems,

        );

        return response($response, 200);
    }

    function getTableList($tableID, $where = '', $limit = -1, $page = 1, $fields = "", $order_by = "", $search = "")
    {



        if ($fields != '')
            $query = "SELECT $fields  FROM $tableID ";
        else $query = "SELECT SQL_CALC_FOUND_ROWS * FROM $tableID ";
        $search_where = "";
        $fields_array = explode(",", $fields);

        if ($search != "") {
            foreach ($fields_array as $field) {
                if ($search_where == "")  $search_where = " and ";
                $search_where .= "$field LIKE '%$search%' OR ";
            }
            $search_where = substr($search_where, 0, strlen($search_where) - 4);
        }

        // if there is a where clause ... append it
        if ($where != '')
            $query .= " WHERE $where $search_where";

        else if ($search_where != '') {
            $search_where = substr($search_where, 5);
            $query .= " WHERE $where $search_where";
        }
        //---


        // if the page-size is set ...
        $results_per_page = $limit;
        $page_first_result = ($page - 1) * $results_per_page;

        if ($order_by != "")
            $query .= " ORDER BY  $order_by ";


        if ($limit > 0)
            $query .= 'LIMIT ' . $page_first_result . ',' . $results_per_page;
        //$query .= " LIMIT $limit";
        $query .= ';';

        // get the list of entities
        $tableList = (array)DB::select($query);


        return $tableList;
    }
    function getTotalItems($tableID, $where = '', $fields = "", $search = "")
    {

        // build the base query for customer and group ...
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM $tableID ";



        //---Build query

        $search_where = "";
        $fields_array = explode(",", $fields);

        if ($search != "") {
            foreach ($fields_array as $field) {
                if ($search_where == "")  $search_where = " and ";
                $search_where .= "$field LIKE '%$search%' OR ";
            }
            $search_where = substr($search_where, 0, strlen($search_where) - 4);
        }

        // if there is a where clause ... append it
        if ($where != '')
            $query .= " WHERE $where $search_where";

        else if ($search_where != '') {
            $search_where = substr($search_where, 5);
            $query .= " WHERE $where $search_where";
        }
        //---


        // if the page-size is set ...
        //$query .= " LIMIT $limit";
        $query .= ';';

        // get the list of entities
        $tableList = (array)DB::select($query);


        // get the actual number of rows that matched the criteria
        $totalrows = count($tableList);

        return $totalrows;
    }

    public function searchMedecin(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $results_per_page = $request->results_per_page ? $request->results_per_page : 10;
        $order_by = $request->order_by ? $request->order_by : "";
        $gouvernorat = $request->gouvernorat ? $request->gouvernorat : "";
        $speciality = $request->speciality ? $request->speciality : "";
        $name = $request->name ? $request->name : "";

        $result = $this->getTableListMedecin($page, $results_per_page, $order_by, $gouvernorat, $speciality, $name);
        $totalItems = $this->getTotalItemsMedecin($gouvernorat, $speciality, $name);
        $response = array(
            "data" => $result,
            "totalItems" => $totalItems,

        );

        return response($response, 200);
    }
    function getTableListMedecin($page = 1, $limit = -1, $order_by, $gouvernorat, $speciality, $name)
    {


        $limit=10;
        $results_per_page = $limit;
        $page_first_result = ($page - 1) * $results_per_page;

        $users = DB::table('users')
            ->leftJoin('governorate', 'users.governorate', '=', 'governorate.id')
            ->leftJoin('speciality', 'users.speciality', '=', 'speciality.id')



            ->where(function ($q) use ($gouvernorat, $speciality, $name) {
                $q->where('governorate.governorate', 'LIKE', "%$gouvernorat%")
                    ->where('speciality.speciality', 'LIKE', "%$speciality%")
                    ->where('speciality.speciality', 'LIKE', "%$speciality%")
                    ->where(function ($query) use ($name) {
                        $query->where('users.first_name', 'LIKE', "%$name%")
                            ->orWhere('users.first_name', 'LIKE', "%$name%");
                    });
            })

            ->offset($page_first_result)
            ->limit($results_per_page)
            ->get();
        return $users;
    }

    function getTotalItemsMedecin($gouvernorat, $speciality, $name)
    {


        $users = DB::table('users')
            ->leftJoin('governorate', 'users.governorate', '=', 'governorate.id')
            ->leftJoin('speciality', 'users.speciality', '=', 'speciality.id')

            ->get();
        $totalrows = count($users);

        return $totalrows;
    }
}
