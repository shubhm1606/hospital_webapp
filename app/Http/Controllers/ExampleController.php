<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pasient_details;

class ExampleController extends Controller
{
    public function getOpdnumber()
    {
        $patients = pasient_details::all();
        if (!$patients->isEmpty()) {
            // dd($patients);
            $data = [];
            date_default_timezone_set("Asia/Kolkata");
            $serialnumber = '';
            $opdnumber = '';
            $date = date("Y-m-d");
            $time = date("h:i:s A");
            foreach ($patients as $patient) {
                $opdnumber  = $patient->opdId + 1;
                $serialnumber  = $patient->sr + 1;
            }
            $data = [
                'serialnumber' => $serialnumber,
                'opdnumber' => $opdnumber,
                'date' => $date,
                'time' => $time
            ];
            return response()->json(["data" => $data, 'status' => 'true']);
        } else {
            $data = [];
            date_default_timezone_set("Asia/Kolkata");
            $serialnumber = 1;
            $opdnumber = 1;
            $date = date("Y-m-d");
            $time = date("h:i:s A");
            $data = [
                'serialnumber' => $serialnumber,
                'opdnumber' => $opdnumber,
                'date' => $date,
                'time' => $time
            ];
            return response()->json(["data" => $data, 'status' => 'true']);
        }
    }
}
