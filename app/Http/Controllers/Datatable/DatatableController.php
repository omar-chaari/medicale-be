<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use DB;

class DatatableController extends Controller
{
    //

    public function update(Request $request)
    {
        $table = $request->table;
        $data = (array) $request->data;

        return   $this->processUpdate($table, $data);
    }


    private function processUpdate(string $table, array $data)
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

            return ['status' => true, 'message' => 'Data modified successfully.'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = "An error with message {$e->getMessage()} occurred on line {$e->getLine()} and file {$e->getFile()}";
            //Log::error($message);
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
