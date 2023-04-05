<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\User;
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

            if ($cmd === "email_verif_professional") {
                $professional = User::find($data["keys"]["id"]);
             
                $this->emailVerifProfessional($professional);
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

        return   $this->processInsert($table, $data);
    }


    private function processInsert(string $table, array $data)
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
            return ['status' => true, 'message' => 'Data modified successfully.'];
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

    public function showRecord(Request $request)
    {
        $table = $request->table;
        $id = $request->id;
        $record = DB::table($table)
            ->where("$table.id", "=", $id)
            ->first();

        return response((array)$record, 200);
    }
}
