<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\FilteredUsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\pasient_details;
use Illuminate\Support\Carbon;     

class ExportUserController extends Controller
{
    public function export(Request $request)
    {
        $from = $request->date;

        return Excel::download(
            new FilteredUsersExport($from),
            'Pasent Details' . $from .'.xlsx'
        );
    }

    public function getOpdListFilter(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',    
        ]);

        $date = Carbon::parse($validated['date'])->toDateString();

        $data = pasient_details::whereDate('pdate', $date)->get()->toArray();
        if($data){
            return response()->json([
                'status' => true,
                'data'   => $data,
                'msg' => "Data found successfully"
            ]);
        }else{
             return response()->json([
                'status' => false,
                'msg'   => 'Data not found this date',
            ]);
        }
    }
}
