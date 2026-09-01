<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\pasient_details;
use App\Models\IpdDetails;
use App\Models\Emergency;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PasientController extends Controller
{

    public function fromsubmit(Request $request)
    {
        $opdId = trim((string) $request->input('opd_id', ''));
        $timeValue = $request->input('time');
        $ptime = $this->normalizeTimeValue($timeValue);
        $currentTag = $request->input('tags', Emergency::value('emergency') === 'yes' ? 'emergency' : 'general');

        $patientData = [
            'pesientname' => $request->patient_name,
            'gender' => $request->gender,
            'age' => $request->age,
            'fatherhusband' => $request->relation ? ($request->relation . ' ' . $request->father_husband_name) : $request->father_husband_name,
            'mobileno' => $request->mobile_no,
            'address' => $request->address,
            'area' => $request->area,
            'caste' => $request->caste,
            'desease' => $request->disease,
            'mlc_pmlc' => $request->mlc_pmlc,
            'charges' => $request->input('charges', null),
            'chargesamount' => $request->input('charge_amount', null),
            'pdate' => $request->date,
            'ymd' => $request->days,
            'free_option' => $request->input('free_option', null),
            'ptime' => $ptime,
            'tags' => $currentTag,
        ];

        $post = DB::transaction(function () use ($request, $opdId, $patientData) {
            $existingPatient = $opdId !== '' ? pasient_details::where('opdId', $opdId)->first() : null;

            if ($existingPatient) {
                $patientData['sr'] = $request->input('serialnumber', $existingPatient->sr);
                $patientData['opdId'] = $opdId;
                $patientData['charges'] = $request->input('charges', $existingPatient->charges);
                $patientData['chargesamount'] = $request->input('charge_amount', $existingPatient->chargesamount);
                $patientData['free_option'] = $request->input('free_option', $existingPatient->free_option);
                $patientData['tags'] = $request->input('tags', $existingPatient->tags ?? 'general');

                $existingPatient->fill($patientData);
                $existingPatient->save();

                return $existingPatient;
            }

            $newOpdId = $this->nextDocumentNumber('opd');
            $serialNumber = $this->nextDocumentNumber('opd_serial');
            $patientData['sr'] = $serialNumber;
            $patientData['opdId'] = $newOpdId;

            return pasient_details::create($patientData);
        });

        if ($post) {
            return response()->json([
                'msg' => $opdId !== '' ? 'Data Update Successfully' : 'Data Submit Successfully',
                'status' => true,
                'data' => [
                    'serialnumber' => $post->sr,
                    'opdnumber' => $post->opdId,
                    'date' => $post->pdate,
                    'time' => $post->ptime,
                ],
            ]);
        }

        return response()->json(["msg" => 'Something Went Worng! Please try again', 'status' => 'true']);
    }

    private function normalizeTimeValue(?string $timeValue): ?string
    {
        if (empty($timeValue)) {
            return null;
        }

        $timeValue = trim($timeValue);

        foreach (['H:i:s', 'h:i:s A', 'H:i', 'h:i A'] as $format) {
            try {
                return \Carbon\Carbon::createFromFormat($format, $timeValue)->format('H:i:s');
            } catch (\Exception $e) {
                // keep trying supported formats
            }
        }

        return $timeValue;
    }

    private function nextDocumentNumber(string $name): int
    {
        $counter = DB::table('document_counters')->where('name', $name)->lockForUpdate()->first();

        if (!$counter) {
            DB::table('document_counters')->insert([
                'name' => $name,
                'current_value' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $counter = DB::table('document_counters')->where('name', $name)->lockForUpdate()->first();
        }

        $nextValue = $counter->current_value + 1;
        DB::table('document_counters')->where('name', $name)->update([
            'current_value' => $nextValue,
            'updated_at' => now(),
        ]);

        return $nextValue;
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

    // public function pdfdownloade()
    // {
    //     $lastEntry = pasient_details::latest()->first();
    //     if (!$lastEntry) {
    //         return back()->with('error', 'No data available!');
    //     }
    //     $pdf = Pdf::loadView('admin.pdf', compact('lastEntry'));
    //     return $pdf->stream('details.pdf');
    // }

    // public function pdfdownloade()
    // {
    //     $lastEntry = pasient_details::latest()->first();

    //     if (!$lastEntry) {
    //         return back()->with('error', 'No data available!');
    //     }

    //     // return view('admin.pdf', compact('lastEntry'));

    //     $mpdf = new \Mpdf\Mpdf([
    //         'mode' => 'utf-8',
    //         'format' => 'A4',
    //         'default_font' => 'freeserif',
    //         'autoScriptToLang' => true,
    //         'autoLangToFont' => true,
    //     ]);

    //     $mpdf->SetFont('freeserif', '', 16);

    //     // Blade view ko HTML mein convert karein
    //     $html = view('admin.pdf', compact('lastEntry'));


    //     $mpdf->WriteHTML($html);

    //     return $mpdf->Output('details.pdf', 'I');
    // }


    public function pdfdownloade()
    {
        $lastEntry = pasient_details::latest()->first();

        if (!$lastEntry) {
            return back()->with('error', 'No data available!');
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode'              => 'utf-8',
            'format'            => 'A4',
            'default_font'      => 'freeserif',
            'autoScriptToLang'  => true,
            'autoLangToFont'    => true,
            'margin_left'       => 6,
            'margin_right'      => 6,
            'margin_top'        => 5,
            'margin_bottom'     => 5,
        ]);

        // Very important → convert View to HTML string
        $html = view('admin.pdf', compact('lastEntry'))->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('details.pdf', 'I');
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
        $ipddetailssave = DB::transaction(function () use ($request) {
            $ipdNumber = $this->nextDocumentNumber('ipd');
            $serialNumber = $this->nextDocumentNumber('ipd_serial');

            date_default_timezone_set("Asia/Kolkata");
            $date = date("Y-m-d");
            $time = date("H:i:s");

            return IpdDetails::create([
                'sr_no' => $serialNumber,
                'opdnumber' => $request->opd_id,
                'refered_dr' => $request->refDr,
                'wordno' => $request->wardnumber,
                'wordtype' => $request->wardType,
                'ipdamount' => $request->chaegesAmount,
                'ipdno' => $ipdNumber,
                'ipdamount_type' => $request->charges,
                'ipd_date' => $date,
                'ipd' => $time,
            ]);
        });

        // Save the data and return response
        if ($ipddetailssave) {
            return response()->json([
                'status' => true,
                'message' => 'IPD details saved successfully',
                'data' => [
                    'serialnumber' => $ipddetailssave->sr_no,
                    'ipdnumber' => $ipddetailssave->ipdno,
                ],
            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to save IPD details']);
        }
    }

    // public function ipdpdf(Request $request)
    // {

    //     $lastEntry = IpdDetails::orderBy('sno', 'desc')->first();
    //     $opdNumber = $lastEntry->opdnumber;

    //     if (!$lastEntry) {
    //         return abort(404, 'No IpdDetails entry found.');
    //     }


    //     $users = pasient_details::join('ipd_details', 'pasient_details.opdId', '=', 'ipd_details.opdnumber')
    //         ->where('ipd_details.opdnumber', $opdNumber)
    //         ->orderBy('ipd_details.created_at', 'desc')
    //         ->select('pasient_details.*', 'ipd_details.*')
    //         ->get();
    //     // dd($users);
    //     // return view('admin.ipdpdf',compact('users'));
    //     $pdf = Pdf::loadView('admin.ipdpdf', compact('users'));
    //     return $pdf->stream('details.pdf');
    // }

    public function ipdpdf(Request $request)
    {
        // Latest IPD entry
        $lastEntry = IpdDetails::orderBy('sno', 'desc')->first();

        if (!$lastEntry) {
            return abort(404, 'No IPD Details entry found.');
        }

        $opdNumber = $lastEntry->opdnumber;

        // Join se data
        $users = pasient_details::join('ipd_details', 'pasient_details.opdId', '=', 'ipd_details.opdnumber')
            ->where('ipd_details.opdnumber', $opdNumber)
            ->orderBy('ipd_details.created_at', 'desc')
            ->select('pasient_details.*', 'ipd_details.*')
            ->get();

        if ($users->isEmpty()) {
            return abort(404, 'No patient data found for this IPD.');
        }

        // ========== mPDF Setup ==========
        $mpdf = new \Mpdf\Mpdf([
            'mode'              => 'utf-8',
            'format'            => 'A4',
            'default_font'      => 'freeserif',
            'autoScriptToLang'  => true,
            'autoLangToFont'    => true,
            'margin_left'       => 8,
            'margin_right'      => 8,
            'margin_top'        => 7,
            'margin_bottom'     => 7,
        ]);

        // Blade ko HTML string me convert karo (important)
        $html = view('admin.ipdpdf', compact('users'))->render();

        $mpdf->WriteHTML($html);

        // PDF browser me open karega
        return $mpdf->Output('IPD_Registration.pdf', 'I');
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
        try {
            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search.value', '');
            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderDirection = $request->input('order.0.dir', 'asc');
            
            // Define sortable columns
            $columns = ['id', 'opdId', 'pesientname', 'fatherhusband', 'mobileno', 'desease', 'pdate'];
            $orderBy = $columns[$orderColumnIndex] ?? 'id';
            
            // Build query
            $query = DB::table('pasient_details');
            
            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('opdId', 'LIKE', "%{$searchValue}%")
                      ->orWhere('pesientname', 'LIKE', "%{$searchValue}%")
                      ->orWhere('fatherhusband', 'LIKE', "%{$searchValue}%")
                      ->orWhere('mobileno', 'LIKE', "%{$searchValue}%")
                      ->orWhere('desease', 'LIKE', "%{$searchValue}%")
                      ->orWhere('pdate', 'LIKE', "%{$searchValue}%");
                });
            }
            
            // Get total count (without filter)
            $totalRecords = DB::table('pasient_details')->count();
            
            // Get filtered count
            $filteredRecords = $query->count();
            
            // Apply sorting and pagination
            $data = $query->orderBy($orderBy, $orderDirection)
                         ->skip($start)
                         ->take($length)
                         ->get();
            
            // Format data for DataTables
            $formattedData = [];
            foreach ($data as $index => $item) {
                $formattedData[] = [
                    'sno' => $start + $index + 1,
                    'opdId' => $item->opdId ?? '—',
                    'pesientname' => $item->pesientname ?? '—',
                    'fatherhusband' => $item->fatherhusband ?? '—',
                    'mobileno' => $item->mobileno ?? '—',
                    'desease' => $item->desease ?? '—',
                    'pdate' => $item->pdate ?? '—',
                    'action' => '<button class="btn btn-primary btn-sm" onclick="reentry(' . ($item->opdId ?? 0) . ')">Re-Entry</button>'
                ];
            }
            
            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $formattedData,
                'status' => true,
                'message' => 'OPD data fetched successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'draw' => intval($request->input('draw', 0)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    

    public function reentry($id)
    {
        // Example: ID से details fetch
        $details = pasient_details::where('opdId', $id)->first();
        // dd( $details);
        return view('admin.from', compact('details'));
    }
}
