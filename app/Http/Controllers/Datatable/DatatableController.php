<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointement;

use Illuminate\Http\Request;


use DB;
use Illuminate\Support\Facades\Mail;

class DatatableController extends Controller
{
    //

    public function update(Request $request)
    {
        $table = $request->table;
        $data = (array) $request->data;

        $cmd = $request->cmd ? $request->cmd : "";

        return   $this->processUpdate($table, $data, $cmd);
    }


    private function processUpdate(string $table, array $data, string $cmd)
    {
        try {


            DB::beginTransaction();


            $dataKeys = array_keys($data["keys"]);


            $key_where = [];
            $whereCombined = [];

            foreach ($data["keys"] as $key => $value) {
                $key_where[] = "$key= '$value'";
                array_push($whereCombined, [$key, '=', $value]);
            }

            $where = implode(" AND ", $key_where);



            $sql = "";
            foreach ($data["form_data"] as $key => $value) {
                if ($sql != "")
                    $sql .= ",";

                if ($value === null)
                    // use null for the value ...
                    $sql .= "`$key`=null";
                else
                    // otherwise use the value ...
                    $sql .= "`$key`='$value'";
            }

            if ($sql != "") {

                $update_query = "update `$table` set $sql where $where ;";

                try {
                    DB::update($update_query);
                } catch (\Exception $e) {
                    $message = "An error with message {$e->getMessage()} occurred on line {$e->getLine()}";
                    //Log::error($message);
                    return ['status' => false, 'message' => $e->getMessage()];
                }
            } else {
                return ['status' => false, 'message' => "invalid form_data"];
            }





            //commit transaction
            DB::commit();

            //
            if ($cmd === "email_verif_professional") {
                $professional = User::find($data["keys"]["id"]);

                $this->emailVerifProfessional($professional);
            } else if ($cmd === "email_verif_patient") {
                $professional = Patient::find($data["keys"]["id"]);

                $this->emailVerifPatient($professional);
            } else if ($cmd === "email_confirm_rdv" || $cmd === "email_report_rdv") {

                ////////////////////


                $appointement_record = Appointement::find($data["keys"]["id"]);
                $appointement = [];
                $appointement["date"] = date("d-m-Y", strtotime($appointement_record->date_debut));
                $appointement["heure"] = date("H:s", strtotime($appointement_record->date_debut));
                $patient = Patient::find($appointement_record->patient);
                $professional = User::find($appointement_record->professional);
                $appointement["pro_name"] = $professional->first_name . " " . $professional->last_name;
                $appointement["patient_name"] = $patient->first_name . " " . $patient->last_name;
                $appointement["email_patient"] = $patient->email;


                if ($cmd === "email_confirm_rdv")
                    $this->emailConfirmRdv($appointement);
                else if ($cmd === "email_report_rdv")
                    $this->emailReportRdv($appointement);
            }


            return ['status' => true, 'message' => 'Data modified successfully.'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = "An error with message {$e->getMessage()} occurred on line {$e->getLine()} and file {$e->getFile()}";
            //Log::error($message);
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete(Request $request)
    {


        $table = $request->table;
        $where = $request->where ? $this->multipleConditionQuery($request->where) : "";

        if ($where == "")
            return response(array(
                "message" => "invalid where parametre",
            ), 400);

        DB::delete("delete from $table where $where");

        $return = array(
            "message" => "Record Removed Successfully.",

        );
        return response($return, 200);
    }

    private function multipleConditionQuery($where)
    {
        //$where = str_replace("'", '"', $where);
        $string_where = "";

        $array_where_multiple = $where;
        $array_where_condition_multiple = [];



        if (is_array($array_where_multiple))
            foreach ($array_where_multiple as $object_where_simple) {
                $array_where_condition_simple = [];
                if (is_array($object_where_simple))
                    foreach ($object_where_simple as $key => $value) {
                        $array_where_condition_simple[] = $key . "='$value'";
                    }
                $array_where_condition_multiple[] = "(" . implode(" AND ", $array_where_condition_simple) . ")";
            }
        $string_where_multiple = implode(" OR ", $array_where_condition_multiple);
        return $string_where_multiple;
    }
    public function insert(Request $request)
    {
        $table = $request->table;
        $data = (array) $request->data;
        $cmd = $request->cmd ? $request->cmd : "";

        return   $this->processInsert($table, $data, $cmd);
    }


    private function processInsert(string $table, array $data, string $cmd)
    {


        $sql = "";
        foreach ($data["form_data"] as $key => $value) {
            if ($sql != "")
                $sql .= ",";

            $sql .= "`$key`='$value'";
        }



        try {
            $query = "INSERT INTO $table SET $sql;";
            DB::insert($query);


            if ($cmd === "email_rdv_patient") {

                $appointement = [];
                $appointement["date"] = date("d-m-Y H:s", strtotime($data["form_data"]["date_debut"]));
                $appointement["motif_consultation"] = $data["form_data"]["motif_consultation"];


                $patient = Patient::find($data["form_data"]["patient"]);
                $professional = User::find($data["form_data"]["professional"]);
                $appointement["professional"] = $professional->first_name . " " . $professional->last_name;
                $appointement["patient"] = $patient->first_name . " " . $patient->last_name;
                $appointement["email_professional"] = $professional->email;
                $appointement["patient_tel"] = $patient->phone;

                $this->emailRdvPatient($appointement);
            } else if ($cmd === "email_nouveau_rdv") {

                $appointement = [];
                $appointement["date"] = date("d-m-Y H:s", strtotime($data["form_data"]["date_debut"]));


                $patient = Patient::find($data["form_data"]["patient"]);
                $professional = User::find($data["form_data"]["professional"]);
                $appointement["pro_name"] = $professional->first_name . " " . $professional->last_name;
                $appointement["patient_name"] = $patient->first_name . " " . $patient->last_name;
                $appointement["pro_adresse"] = $professional->address;
                $appointement["patient_email"] = $patient->email;

                $appointement["pro_spec"] = $professional->specialitylist->speciality;
                $this->emailNouvauRdv($appointement);
            }


            return ['status' => true, 'message' => 'Data inserted successfully.'];
        } catch (\Illuminate\Database\QueryException $ex) {
            $error_message = $ex->getMessage();
            $pos = strpos($error_message, "Duplicate entry");
            if ($pos > 0)
                return ['status' => false, 'message' => 'Duplicate entry'];
            return ['status' => false, 'message' => $error_message];
        }
    }


    public function emailVerifProfessional($data)
    {

        $details = [
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,

            'email' => $data->email,
            'speciality' => $data->specialitylist->speciality,
            'governorate' => $data->governoratelist->governorate,
            'phone' => $data->phone,

        ];

        Mail::to($data->email)->send(new \App\Notifications\Contact($details));
    }




    public function emailVerifPatient($data)
    {

        $details = [
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,

            'email' => $data->email,
            'phone' => $data->phone,

        ];

        Mail::to($data->email)->send(new \App\Notifications\ContactPatient($details));
    }
    public function emailRdvPatient($data)
    {

        $details = [

            'professional' => $data["professional"],
            'patient' => $data["patient"],
            'date' => $data["date"],
            'motif_consultation' => $data["motif_consultation"],
            'patient_tel' => $data["patient_tel"],


        ];

        Mail::to($data["email_professional"])->send(new \App\Notifications\RdvPatient($details));
    }



    public function emailNouvauRdv($data)
    {

        $details = [

            'pro_name' => $data["pro_name"],
            'patient_name' => $data["patient_name"],
            'date' => $data["date"],
            'pro_adresse' => $data["pro_adresse"],
            'pro_spec' => $data["pro_spec"],
        ];

        Mail::to($data["patient_email"])->send(new \App\Notifications\NouveauRdv($details));
    }

    public function emailConfirmRdv($data)
    {


        $details = [

            'patient_name' => $data["patient_name"],
            'pro_name' => $data["pro_name"],
            'date' => $data["date"],
            'heure' => $data["heure"]

        ];

        Mail::to($data["email_patient"])->send(new \App\Notifications\ConfirmRdv($details));
    }

    public function emailReportRdv($data)
    {

        $details = [

            'patient_name' => $data["patient_name"],
            'pro_name' => $data["pro_name"],
            'date' => $data["date"],
            'heure' => $data["heure"]

        ];
        Mail::to($data["email_patient"])->send(new \App\Notifications\ReportRdv($details));
    }




    public function showRecord(Request $request)
    {
        $table = $request->table;
        $id = $request->id;
        $record = DB::table($table)
            ->where("$table.id", "=", $id)
            ->first();

        return response((array)$record, 200);
    }



    public function tabledata(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $results_per_page = $request->results_per_page ? $request->results_per_page : 10;
        $tableID = $request->tableID;
        $where = $request->where ? $request->where : "";
        $fields = $request->fields;
        $order_by = $request->order_by ? $request->order_by : "";
        $useFieldsInQuery = $request->useFieldsInQuery ? $request->useFieldsInQuery : 0;
        $result_table_list = $this->getTableList($tableID, $where, $results_per_page, $page, $fields, $order_by,  $useFieldsInQuery);
        $totalItems = $this->getTotalItems($tableID, $where, $fields);



        $response = array(
            "data" => $result_table_list,
            "totalItems" => $totalItems
        );
        return response($response, 200);
    }
    function getTableList($tableID, $where = '', $limit = -1, $page = 1, $fields = "", $order_by = "", $UseFieldsInQuery = 0)
    {


        if ($UseFieldsInQuery)
            $query = "SELECT $fields FROM $tableID ";

        else $query = "SELECT SQL_CALC_FOUND_ROWS * FROM $tableID ";

        //---



        // if there is a where clause ... append it
        if ($where != '')
            $query .= " WHERE $where ";

        //---


        // if the page-size is set ...
        $results_per_page = $limit;
        $page_first_result = ($page - 1) * $results_per_page;

        if ($order_by != "")
            $query .= " ORDER BY  $order_by ";


        if ($limit > 0)
            $query .= 'LIMIT ' . $page_first_result . ',' . $results_per_page;
        $query .= ';';

        try {
            $tableList = (array)DB::select($query);
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
            $tableList = [];
        }


        return $tableList;
    }

    function getTotalItems($tableID, $where = '', $fields = "")
    {

        // build the base query for customer and group ...
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM $tableID ";

        // if there is a where clause ... append it
        if ($where != '')
            $query .= " WHERE $where ";

        // if the page-size is set ...
        $query .= ';';

        // get the list of entities

        try {
            $tableList = (array)DB::select($query);
        } catch (\Illuminate\Database\QueryException $ex) {
            //dd($ex->getMessage());
            // Note any method of class PDOException can be called on $ex.
            $tableList = [];
        }

        // get the actual number of rows that matched the criteria
        $totalrows = count($tableList);

        return $totalrows;
    }
  
}
