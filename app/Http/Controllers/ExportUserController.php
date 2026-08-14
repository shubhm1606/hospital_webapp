<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\FilteredUsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\pasient_details;
use Illuminate\Support\Carbon; 
use DB;    

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

     public function getopdLIstfilter(Request $request)
    {
        try {
            $date = $request->input('date');
            $draw = $request->input('draw', 0);
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search.value', '');
            
            // Build query with date filter
            $query = DB::table('pasient_details')->whereDate('pdate', $date);
            
            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('opdId', 'LIKE', "%{$searchValue}%")
                      ->orWhere('pesientname', 'LIKE', "%{$searchValue}%")
                      ->orWhere('fatherhusband', 'LIKE', "%{$searchValue}%")
                      ->orWhere('mobileno', 'LIKE', "%{$searchValue}%")
                      ->orWhere('desease', 'LIKE', "%{$searchValue}%");
                });
            }
            
            // Get counts
            $totalRecords = DB::table('pasient_details')->whereDate('pdate', $date)->count();
            $filteredRecords = $query->count();
            
            // Get paginated data
            $data = $query->orderBy('sno', 'desc')
                         ->skip($start)
                         ->take($length)
                         ->get();
            
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
                'message' => 'Filtered data fetched successfully'
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


    public function exportUsersDatewise(Request $request)
    {
        try {
            $date = $request->input('date');
            
            // Validate date
            if (!$date) {
                return response()->json([
                    'error' => 'Date is required'
                ], 400);
            }
            
            // Fetch data
            $data = DB::table('pasient_details')
                     ->whereDate('pdate', $date)
                     ->get();
            
            // Check if data exists
            if ($data->isEmpty()) {
                return response()->json([
                    'error' => 'No data found for this date'
                ], 404);
            }
            
            // Create CSV
            $filename = "Patients-{$date}.csv";
            
            // Open output stream
            $handle = fopen('php://temp', 'w+');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            fputcsv($handle, ['OPDID', 'Name', 'Father/Husband', 'Mobile', 'Medical', 'Date']);
            
            // Add data rows
            foreach ($data as $row) {
                fputcsv($handle, [
                    $row->opdId ?? '—',
                    $row->pesientname ?? '—',
                    $row->fatherhusband ?? '—',
                    $row->mobileno ?? '—',
                    $row->desease ?? '—',
                    $row->pdate ?? '—'
                ]);
            }
            
            // Get CSV content
            rewind($handle);
            $csvContent = stream_get_contents($handle);
            fclose($handle);
            
            // Return CSV response
            return response($csvContent, 200, [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ]);
            
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Export Error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
