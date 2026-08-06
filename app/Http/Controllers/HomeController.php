<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\pasient_details;
use App\Models\IpdDetails;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {

        date_default_timezone_set("Asia/Kolkata");

        $date = date("Y-m-d");
        $time = date("h:i:s A");

        // $startOfDay = Carbon::now($timezone)->startOfDay()->setTimezone('UTC');
        // $endOfDay = Carbon::now($timezone)->endOfDay()->setTimezone('UTC');
        
        $opdpaidCounts = pasient_details::where('charges', 'PAID')
        ->where('pdate', $date)
        ->count();


        $opdfreeCount = pasient_details::where('charges', 'FREE')
        ->where('pdate', $date)
            ->count();

    
        $ipdpaidCount = IpdDetails::where('ipdamount_type', 'PAID')
        ->where('ipd_date', $date)
            ->count();


        $ipdfreeCount = IpdDetails::where('ipdamount_type', 'FREE')
        ->where('ipd_date', $date)
            ->count();

        
        $opdAmounts = pasient_details::where('charges', 'PAID')
        ->where('pdate', $date)
            ->sum('chargesamount');

        
        $ipdAmount = IpdDetails::where('ipdamount_type', 'PAID')
        ->where('ipd_date', $date)
            ->sum('ipdamount');

        
        return view('admin.home', compact(
            'opdpaidCounts',
            'opdfreeCount',
            'ipdpaidCount',
            'ipdfreeCount',
            'opdAmounts',
            'ipdAmount'
        ));
    }

    public function review()
    {
        return view('admin.index');
    }
    public function from()
    {
        return view('admin.from');
    }
    public function ipd()
    {
        return view('admin.ipdForm');
    }

    public function records()
    {
        return view('admin.records');
    }

    public function indexq()
    {
        return view('admin.ipdpdf');
    }
    public function report()
    {
        return view('admin.records');
    }
    public function opdSearch()
    {
        return view('admin.opdsearch');
    }

    public function reportpdf()
    {
        $pdf = PDF::loadView('admin.opd_ipd_report')
            ->setPaper('a4', 'landscape');
        return $pdf->stream('details.pdf');
    }

    public function listpage(){
        return view('admin.list');
    }
}
