<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\pasient_details;
use App\Models\IpdDetails;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function check(){
        return view('admin.check');
    }

    public function fromsubmit(Request $request)
    {
        // dd($request->all());
        $ptime = \Carbon\Carbon::createFromFormat('h:i:s A', $request->time)->format('H:i:s');
        $post = new pasient_details;
        $post->pesientname = $patient_name = $request->patient_name;
        $post->gender = $gender = $request->gender;
        $post->age = $age = $request->age;
        $post->fatherhusband = $father_husband_name = $request->father_husband_name;
        $post->mobileno = $mobile_no = $request->mobile_no;
        $post->address = $address = $request->address;
        $post->area = $area = $request->area;
        $post->caste = $caste = $request->caste;
        $post->desease = $disease = $request->disease;
        $post->mlc_pmlc = $mlc_pmlc = $request->mlc_pmlc;
        $post->charges = $charges = $request->charges;
        $post->chargesamount = $charges = $request->charge_amount;
        $post->sr = $charges = $request->serialnumber;
        $post->opdId = $opd_id = $request->opd_id;
        $post->pdate = $date = $request->date;
        $post->ymd = $date = $request->days;
        $post->ptime = $ptime;
        $result = $post->save();
        if ($result) {
            return response()->json(["msg" => 'Data Submit Successfully', 'status' => 'true']);
        } else {
            return response()->json(["msg" => 'Something Went Worng! Please try again', 'status' => 'true']);
        }
    }

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

    public function getIpdnumber()
    {
        $patients = IpdDetails::all();
        // dd($patients);
        if (!$patients->isEmpty()) {
            // dd($patients);
            $data = [];
            date_default_timezone_set("Asia/Kolkata");
            $serialnumber = '';
            $opdnumber = '';
            $date = date("Y-m-d");
            $time = date("h:i:s A");
            foreach ($patients as $patient) {
                $opdnumber  = $patient->ipdno + 1;
                $serialnumber  = $patient->sr_no + 1;
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

    public function pdfdownloade()
    {
        $lastEntry = pasient_details::latest()->first();
        // return view('admin.pdf', ['lastEntry' => $lastEntry]);
        if (!$lastEntry) {
            return back()->with('error', 'No data available!');
        }
        $pdf = Pdf::loadView('admin.pdf',compact('lastEntry'));
        return $pdf->stream('details.pdf');
    }

    public function ipdformsubmit(Request $request)
    {

        $opd_id = $request->opd_id;
        $pasient_details = pasient_details::where('opdId', $opd_id)->first(); // Use first() to get a single record        
        return response()->json(['status' => true, "data" => $pasient_details]);
        dd($pasient_details);
    }

    public function ipddetailssubmit(Request $request)
    {
        // dd($request->all());
        $ipddetailssave = new IpdDetails();

        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d");
        $time = date("H:i:s");

        // Assign request values to the model attributes
        $ipddetailssave->sr_no = $request->sr_no;
        $ipddetailssave->opdnumber = $request->opd_id;
        $ipddetailssave->refered_dr = $request->refDr;
        $ipddetailssave->wordno = $request->wardnumber;
        $ipddetailssave->wordtype = $request->wardType;
        $ipddetailssave->ipdamount = $request->chaegesAmount;
        $ipddetailssave->ipdno = $request->ipdNumber;
        $ipddetailssave->ipdamount_type = $request->charges;
        $ipddetailssave->ipd_date = $date;
        $ipddetailssave->ipd = $time;

        // Save the data and return response
        if ($ipddetailssave->save()) {
            return response()->json(['status' => true, 'message' => 'IPD details saved successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to save IPD details']);
        }
    }

    public function ipdpdf(Request $request)
    {
        
        $lastEntry = IpdDetails::orderBy('sno', 'desc')->first();
        $opdNumber = $lastEntry->opdnumber;
        
        if (!$lastEntry) {
            return abort(404, 'No IpdDetails entry found.');
        }

       
        $users = pasient_details::join('ipd_details', 'pasient_details.opdId', '=', 'ipd_details.opdnumber')
            ->where('ipd_details.opdnumber',$opdNumber)
            ->orderBy('ipd_details.created_at', 'desc')
            ->select('pasient_details.*', 'ipd_details.*') 
            ->get();
        // dd($users);
        // return view('admin.ipdpdf',compact('users'));
        $pdf = Pdf::loadView('admin.ipdpdf', compact('users'));
        return $pdf->stream('details.pdf');
    }
}
