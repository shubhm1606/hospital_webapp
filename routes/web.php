<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ExportUserController;


Route::get('/', function () {
    return redirect('login');
});

Auth::routes();


// User Dashboard
Route::middleware(['auth', 'user'])->group(function () {});

// Admin Dashboard
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/doctor', [DoctorController::class, 'index'])->name('index.doctor');
    Route::get('/doctorylist', [DoctorController::class, 'doctorylist'])->name('doctorylist');
    Route::post('/doctorcreate', [DoctorController::class, 'store'])->name('doctor_store');

    Route::get('/doctor_view/{id}', [DoctorController::class, 'show'])->name('doctor.show');
    Route::post('/doctor_update/{id}', [DoctorController::class, 'doctor_update'])->name('doctor.update');
    Route::post('/doctor_delete/{id}', [DoctorController::class, 'destroy'])->name('doctor.delete');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/check', [AdminController::class, 'check'])->name('admin.check');
    Route::get('/home', [HomeController::class, 'adminHome'])->name('home');
    Route::get('/review', [HomeController::class, 'review'])->name('review');
    Route::get('/opd', [HomeController::class, 'from'])->name('opd');
    Route::get('/ipd', [HomeController::class, 'ipd'])->name('ipd');
    Route::get('/records', [HomeController::class, 'records'])->name('records');
    Route::get('/indexq', [HomeController::class, 'indexq'])->name('indexq');
    Route::get('/report', [HomeController::class, 'report'])->name('report');
    Route::get('/reportpdf', [HomeController::class, 'reportpdf'])->name('reportpdf');
    Route::get('/Opdnumber', [PasientController::class, 'getOpdnumber'])->name('Opdnumber');
    Route::get('/getIpdnumber', [PasientController::class, 'getIpdnumber'])->name('getIpdnumber');
    Route::get('/pdfdownloade', [PasientController::class, 'pdfdownloade'])->name('pdfdownloade');
    Route::get('/emergency', [PasientController::class, 'emergency'])->name('emergency');
    Route::get('/opdSearch', [HomeController::class, 'opdSearch'])->name('opdSearch');
    Route::get('/print-opd-pdf/{opdId}', [PasientController::class, 'generatePdf']);
    Route::get('/listpage', [HomeController::class, 'listpage'])->name('listpage');

    Route::post('/fromsubmit', [PasientController::class, 'fromsubmit'])->name('fromsubmit');
    Route::post('/ipdformsubmit', [PasientController::class, 'ipdformsubmit'])->name('ipdformsubmit');
    Route::post('/ipddetailssubmit', [PasientController::class, 'ipddetailssubmit'])->name('ipddetailssubmit');
    Route::get('/ipdpdfdownlode', [PasientController::class, 'ipdpdf'])->name('ipdpdfdownlode');
    Route::post('/exceldata', [PasientController::class, 'exceldata'])->name('exceldata');
    Route::post('/exportTopdf', [PasientController::class, 'exportTopdf'])->name('exportTopdf');
    Route::post('/checkemergency', [PasientController::class, 'checkemergency'])->name('checkemergency');
    Route::post('/opdsearchData', [PasientController::class, 'opdsearchData'])->name('opdsearchData');
    Route::get('/export-users', [PasientController::class, 'exportUsers']);

  
    Route::get('/getopdLIst', [PasientController::class, 'getopdLIst'])->name('getopdLIst');
    Route::get('/getopdLIstfilter', [ExportUserController::class, 'getopdLIstfilter'])->name('getopdLIstfilter');
    Route::post('/export-users-datewise', [ExportUserController::class, 'exportUsersDatewise'])
    ->name('export.users.datewise');
    Route::get('/export-users', [PasientController::class, 'exportUsers']);
    Route::get('/reentry/{id}', [PasientController::class, 'reentry'])->name('reentry');


    // Route::post('/getopdLIstfilter', [ExportUserController::class, 'getopdLIstfilter'])->name('getopdLIstfilter');
});

Route::middleware(['auth:agent', 'agent.status'])->group(function () {
    // Agent-specific routes
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/test-font-mpdf2', function() {
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'default_font' => 'freeserif',  // Built-in font
    ]);

    $mpdf->SetFont('freeserif', '', 16);
    
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>Test Hindi Font (FreeSerif)</h1>
        <p><b>Patient:</b> शुभम सूर्यवंशी</p>
        <p><b>Father:</b> ओमप्रकाश सूर्यवंशी</p>
        <p><b>Address:</b> सिवनी मालवा वार्ड नंबर 12</p>
    </body>
    </html>
    ';
    
    $mpdf->WriteHTML($html);
    return $mpdf->Output('test-font2.pdf', 'I');
});

Route::get('/check-font-mpdf', function() {
    $fontPath = public_path('fonts/NotoSansDevanagari-Regular.ttf');
    
    if (file_exists($fontPath)) {
        return "✅ Font exists! Path: " . $fontPath . "<br>Size: " . filesize($fontPath) . " bytes";
    } else {
        return "❌ Font not found! Path: " . $fontPath;
    }
});


Route::get('/testcheck', function() {
    return view('admin.testcheck');
});