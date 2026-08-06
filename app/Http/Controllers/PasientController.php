<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\pasient_details;
use App\Models\IpdDetails;
use App\Models\Emergency;
use Barryvdh\DomPDF\Facade\Pdf;


class PasientController extends Controller
{

    public function fromsubmit(Request $request)
    {
        // dd($request->all());
        $ptime = \Carbon\Carbon::createFromFormat('h:i:s A', $request->time)->format('H:i:s');
        $post = pasient_details::updateOrCreate(
            ['opdId' => $request->opd_id],
            [
                'pesientname' => $request->patient_name,
                'gender' => $request->gender,
                'age' =>  $request->age,
                'fatherhusband' => $request->father_husband_name,
                'mobileno' =>  $request->mobile_no,
                'address' =>  $request->address,
                'area' =>  $request->area,
                'caste' =>  $request->caste,
                'desease' =>  $request->disease,
                'mlc_pmlc' =>  $request->mlc_pmlc,
                'charges' =>  $request->charges,
                'chargesamount' =>  $request->charge_amount,
                'sr' => $request->serialnumber,
                'opdId' => $request->opd_id,
                'pdate' => $request->date,
                'ymd' => $request->days,
                'free_option' => $request->free_option,
                'ptime' => $ptime,
                'tags' => $request->tags,
            ]
        );


        if ($post) {
            return response()->json(["msg" => 'Data Submit Successfully', 'status' => 'true']);
        } else {
            return response()->json(["msg" => 'Something Went Worng! Please try again', 'status' => 'true']);
        }
    }

    public function getOpdnumber()
    {

        $patients = pasient_details::all();

        $emergencies = Emergency::all()->pluck('emergency');

        $emergency_type = $emergencies->first() ?? '';

        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d");
        $time = date("h:i:s A");

        if (!$patients->isEmpty()) {

            $lastPatient = $patients->last();
            $opdnumber = $lastPatient->opdId + 1;
            $serialnumber = $lastPatient->sr + 1;
        } else {

            $opdnumber = 1;
            $serialnumber = 1;
        }

        $data = [
            'serialnumber' => $serialnumber,
            'opdnumber' => $opdnumber,
            'date' => $date,
            'time' => $time,
            'emergency_type' => $emergency_type
        ];
        // dd($data);
        return response()->json(["data" => $data, 'status' => 'true']);
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
        if (!$lastEntry) {
            return back()->with('error', 'No data available!');
        }
        $pdf = Pdf::loadView('admin.pdf', compact('lastEntry'));
        return $pdf->stream('details.pdf');
    }

    public function ipdformsubmit(Request $request)
    {

        $opd_id = $request->opd_id;
        $pasient_details = pasient_details::where('opdId', $opd_id)->first(); // Use first() to get a single record        
        return response()->json(['status' => true, "data" => $pasient_details]);
        // dd($pasient_details);
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
            ->where('ipd_details.opdnumber', $opdNumber)
            ->orderBy('ipd_details.created_at', 'desc')
            ->select('pasient_details.*', 'ipd_details.*')
            ->get();
        // dd($users);
        // return view('admin.ipdpdf',compact('users'));
        $pdf = Pdf::loadView('admin.ipdpdf', compact('users'));
        return $pdf->stream('details.pdf');
    }

    public function exceldata(Request $request)
    {
        $startDate = $request->input('starting_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // Retrieve OPD (General) Data
        $opdData = pasient_details::selectRaw("
            DATE(pdate) as date,
            SUM(CASE WHEN charges = 'PAID' AND tags = 'general' THEN 1 ELSE 0 END) as opd_paid_count,
            SUM(CASE WHEN charges = 'FREE' AND tags = 'general' THEN 1 ELSE 0 END) as opd_free_count,
            SUM(CASE WHEN charges = 'PAID' AND tags = 'general' THEN chargesamount ELSE 0 END) as opd_total_amount
        ")
            ->whereBetween('pdate', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // Retrieve Emergency OPD Data
        $emeryopdData = pasient_details::selectRaw("
            DATE(pdate) as date,
            SUM(CASE WHEN charges = 'PAID' AND tags = 'emergency' THEN 1 ELSE 0 END) as em_opd_paid_count,
            SUM(CASE WHEN charges = 'FREE' AND tags = 'emergency' THEN 1 ELSE 0 END) as em_opd_free_count,
            SUM(CASE WHEN charges = 'PAID' AND tags = 'emergency' THEN chargesamount ELSE 0 END) as em_opd_total_amount
        ")
            ->whereBetween('pdate', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // Retrieve IPD Data
        $ipdData = IpdDetails::selectRaw("
            DATE(ipd_date) as date,
            SUM(CASE WHEN ipdamount_type = 'PAID' THEN 1 ELSE 0 END) as ipd_paid_count,
            SUM(CASE WHEN ipdamount_type = 'FREE' THEN 1 ELSE 0 END) as ipd_free_count,
            SUM(CASE WHEN ipdamount_type = 'PAID' THEN ipdamount ELSE 0 END) as ipd_total_amount
        ")
            ->whereBetween('ipd_date', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // Combine all data
        $dates = $opdData->keys()
            ->merge($emeryopdData->keys())
            ->merge($ipdData->keys())
            ->unique()
            ->sort();

        $records = collect();

        foreach ($dates as $date) {
            $records[$date] = [
                'date' => $date,
                'opd_paid_count' => $opdData[$date]->opd_paid_count ?? 0,
                'opd_free_count' => $opdData[$date]->opd_free_count ?? 0,
                'opd_total_amount' => $opdData[$date]->opd_total_amount ?? 0,
                'em_opd_paid_count' => $emeryopdData[$date]->em_opd_paid_count ?? 0,
                'em_opd_free_count' => $emeryopdData[$date]->em_opd_free_count ?? 0,
                'em_opd_total_amount' => $emeryopdData[$date]->em_opd_total_amount ?? 0,
                'ipd_paid_count' => $ipdData[$date]->ipd_paid_count ?? 0,
                'ipd_free_count' => $ipdData[$date]->ipd_free_count ?? 0,
                'ipd_total_amount' => $ipdData[$date]->ipd_total_amount ?? 0,
            ];
        }

        // Convert collection to array and sort
        $records = $records->values();
        // dd($records);
        return response()->json([
            'status' => true,
            'msg' => 'Data Found Successfully',
            'data' => $records
        ]);
    }



    public function exportToPdf(Request $request)
    {
        // dd($request->all());
        $startDate = $request->startData ?? now()->startOfMonth()->toDateString();
        $endDate = $request->endData ?? now()->endOfMonth()->toDateString();

        // Retrieve OPD Data
        $opdData = pasient_details::selectRaw("
            DATE(pdate) as date,
            SUM(CASE WHEN charges = 'PAID' AND tags = 'general' THEN 1 ELSE 0 END) as opd_paid_count,
            SUM(CASE WHEN charges = 'FREE' AND tags = 'general' THEN 1 ELSE 0 END) as opd_free_count,
            SUM(CASE WHEN charges = 'PAID' AND tags = 'general' THEN chargesamount ELSE 0 END) as opd_total_amount
        ")
            ->whereBetween('pdate', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // Retrieve Emergency OPD Data
        $emeryopdData = pasient_details::selectRaw("
            DATE(pdate) as date,
            SUM(CASE WHEN charges = 'PAID' AND tags = 'emergency' THEN 1 ELSE 0 END) as em_opd_paid_count,
            SUM(CASE WHEN charges = 'FREE' AND tags = 'emergency' THEN 1 ELSE 0 END) as em_opd_free_count,
            SUM(CASE WHEN charges = 'PAID' AND tags = 'emergency' THEN chargesamount ELSE 0 END) as em_opd_total_amount
        ")
            ->whereBetween('pdate', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // Retrieve IPD Data
        $ipdData = IpdDetails::selectRaw("
            DATE(ipd_date) as date,
            SUM(CASE WHEN ipdamount_type = 'PAID' THEN 1 ELSE 0 END) as ipd_paid_count,
            SUM(CASE WHEN ipdamount_type = 'FREE' THEN 1 ELSE 0 END) as ipd_free_count,
            SUM(CASE WHEN ipdamount_type = 'PAID' THEN ipdamount ELSE 0 END) as ipd_total_amount
        ")
            ->whereBetween('ipd_date', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // Combine all data
        $dates = $opdData->keys()
            ->merge($emeryopdData->keys())
            ->merge($ipdData->keys())
            ->unique()
            ->sort();

        $records = collect();

        foreach ($dates as $date) {
            $records[$date] = [
                'date' => $date,
                'opd_paid_count' => $opdData[$date]->opd_paid_count ?? 0,
                'opd_free_count' => $opdData[$date]->opd_free_count ?? 0,
                'opd_total_amount' => $opdData[$date]->opd_total_amount ?? 0,
                'em_opd_paid_count' => $emeryopdData[$date]->em_opd_paid_count ?? 0,
                'em_opd_free_count' => $emeryopdData[$date]->em_opd_free_count ?? 0,
                'em_opd_total_amount' => $emeryopdData[$date]->em_opd_total_amount ?? 0,
                'ipd_paid_count' => $ipdData[$date]->ipd_paid_count ?? 0,
                'ipd_free_count' => $ipdData[$date]->ipd_free_count ?? 0,
                'ipd_total_amount' => $ipdData[$date]->ipd_total_amount ?? 0,
            ];
        }

        // Convert collection to array and sort
        $records = $records->values();
        // dd($records);
        if ($records->isEmpty()) {
            return back()->with('error', 'No data available for the selected date range.');
        }

        // Load the Blade view and generate PDF
        $pdf = Pdf::loadView('admin.opd_ipd_report', compact('records'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('details.pdf');
        return $pdf->download('details.pdf');
    }


    public function checkemergency(Request $request)
    {
        $request->validate([
            'emergency' => 'required|in:yes,no',
        ]);

        $emergency = Emergency::first();

        if ($emergency) {
            $emergency->update(['emergency' => $request->input('emergency')]);
        } else {
            $emergency = Emergency::create(['emergency' => $request->input('emergency')]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Emergency status updated successfully',
            'data' => $emergency
        ]);
    }

    public function emergency()
    {
        $data = Emergency::first();
        $emerydata = '';
        if ($data) {
            $emerydata = $data->emergency;
        } else {
            $emerydata = null;
        }

        return response()->json([
            "data" => $data,
            "emergency" => $emerydata,
            "status" => true
        ]);
    }

    public function opdsearchData(Request $request)
    {
        $id = $request->input('opd_id');
        // $patient_name = $request->input('patient_name');

        $opdDatafetch = pasient_details::where('opdId', $id)
            ->first();
        if (!empty($opdDatafetch)) {
            return response()->json(['status' => true, 'data' => $opdDatafetch]);
        } else {
            return response()->json(['status' => false, 'msg' => 'Data not found']);
        }
    }

    public function generatePdf($opdId)
    {
        $lastEntry = pasient_details::where('opdId', $opdId)->first();

        if (!$lastEntry) {
            abort(404, 'Patient not found.');
        }

        $pdf = Pdf::loadView('admin.pdf', compact('lastEntry'));
        return $pdf->stream('details.pdf');
    }


    public function getopdLIst(Request $request)
    {
        $opdDatafetch = pasient_details::orderBy('sno', 'desc')->get();
        return response()->json([
            'status' => true,
            'message' => 'OPD data fetched successfully',
            'data' => $opdDatafetch
        ]);
    }

    public function reentry($id)
    {
        // Example: ID से details fetch
        $details = pasient_details::where('opdId', $id)->first();

        return view('admin.from', compact('details'));
    }
    
}
