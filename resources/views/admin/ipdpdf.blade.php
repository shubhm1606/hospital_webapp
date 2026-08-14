<!DOCTYPE html>
<html lang="hi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>IPD Registration</title>
    <style>
       

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: freeserif, DejaVu Sans, Mangal, sans-serif;
            font-size: 11px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
        }

        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .text-left   { text-align: left; }
        .bold        { font-weight: bold; }

        /* ===== HEADER ===== */
        .header-table {
            width: 100%;
            margin-bottom: 2px;
        }

        .header-table img {
            width: 65px;
            height: 65px;
        }

        .header-center {
            text-align: center;
            line-height: 1.25;
        }

        .header-center .title {
            font-size: 13px;
            font-weight: bold;
        }

        .header-center .sub {
            font-size: 11px;
            font-weight: bold;
        }

        /* ===== BLACK TITLE ===== */
        .black-title {
            background: #000;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 4px 0;
            font-size: 13px;
            margin: 4px 0 3px 0;
        }

        /* ===== PATIENT BOX ===== */
        .patient-box {
            border: 1.5px solid #000;
            padding: 5px 7px;
            margin-bottom: 4px;
        }

        .patient-box td {
            font-size: 15px;
            line-height: 1.45;
            padding: 1px 3px;
        }

        .label {
            font-weight: bold;
        }

        /* ===== DIAGNOSIS LINES ===== */
        .diag-section {
            margin: 3px 0 5px 0;
        }

        .diag-row {
            margin: 3px 0;
            font-size: 12px;
            font-weight: bold;
        }

        .diag-line {
            display: inline-block;
            width: 85%;
            height: 14px;
            vertical-align: bottom;
        }

        /* ===== MAIN WRITING AREA ===== */
        .writing-table {
            width: 100%;
            border: 1.5px solid #000;
             height: 960px !important;
            margin-bottom: 4px;
        }

        .writing-left {
            width: 68%;
            border-right: 1.5px solid #000;
            height: 540px;
            padding: 6px 8px;
            position: relative;
        }

        .writing-right {
            width: 32%;
            height: 340px;
            padding: 8px 6px;
            text-align: center;
            position: relative;
        }

        .rx-symbol {
            width: 28px;
            height: 28px;
        }

        .treatment-title {
            font-size: 13px;
            font-weight: bold;
            margin-top: 5px;
        }

        .consent-text {
            position: absolute;
            right: 48px;
            top: 78%;
        }

        /* ===== DASH LINE ===== */
        .dash-line {
            text-align: center;
            font-size: 11px;
            letter-spacing: 1.5px;
            margin: 3px 0;
        }

        /* ===== FOOTER ===== */
        .footer-head {
            background: #000;
            color: #fff;
            text-align: center;
            padding: 4px 2px;
            font-weight: bold;
            font-size: 11px;
        }

        .ward-title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin: 3px 0;
        }

        .footer-box {
            border: 1.5px solid #000;
            border-top: none;
            padding: 5px 7px;
        }

        .footer-box td {
            font-size: 11px;
            line-height: 1.4;
            padding: 1px 3px;
        }

        .footer-note {
            font-size: 10px;
            line-height: 1.35;
        }
    </style>
</head>
<body>

@php
    $user = $users[0] ?? null;

    $formattedTime = '';
    if ($user && !empty($user['ipd'])) {
        try {
            $formattedTime = \Carbon\Carbon::createFromFormat('H:i:s', $user['ipd'])->format('h:i A');
        } catch (\Exception $e) {
            $formattedTime = $user['ipd'] ?? '';
        }
    }

    $logo1 = public_path('img/opd_ipd_logo.jpg');
    $logo2 = public_path('img/second_logo.jpeg');
    $rxImg = public_path('img/aaaa.jpg');

    $logo1_b64 = file_exists($logo1) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logo1)) : '';
    $logo2_b64 = file_exists($logo2) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logo2)) : '';
    $rx_b64    = file_exists($rxImg) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($rxImg)) : '';
@endphp

@if($user)

<!-- ===== HEADER ===== -->
<table class="header-table">
    <tr>
        <td width="14%" class="text-left">
            @if($logo1_b64)
                <img src="{{ $logo1_b64 }}" width="65" height="65">
            @endif
        </td>
        <td width="72%" class="header-center">
            <div class="charges-line" style="font-size: 14px; color:red">(जनरल चार्जेज :- 10 / इमरजेंसी चार्जेज :- 30) (IPD Amount :- 30)</div>
                    <div class="header-title" style="font-size: 18px; font-weight:bold">रोगी कल्याण समिति</div>
                    <div class="header-sub" style="font-size: 18px;">डॉक्टर भीमराव आंबेडकर सिविल हॉस्पिटल</div>
                    <div class="header-sub" style="font-size: 18px;">सिवनी मालवा, जिला -नर्मदापुरम (म.प्र.)</div>
                    <div class="header-sub" style="font-size: 18px;">डॉक्टर भीमराव आंबेडकर सिविल हॉस्पिटल सिवनी मालवा</div>
                    <div class="header-sub" style="font-size: 18px;">जिला -नर्मदापुरम (म.प्र.)</div>
        </td>
        <td width="14%" class="text-right">
            @if($logo2_b64)
                <img src="{{ $logo2_b64 }}" width="65" height="65">
            @endif
        </td>
    </tr>
</table>

<!-- ===== BLACK TITLE ===== -->
<div class="black-title">Inpatient Registration</div>

<!-- ===== PATIENT DETAILS ===== -->
<div class="patient-box">
    <table>
        <tr>
            <td width="52%">
                <div><span class="label">Patient Name</span> : {{ $user['pesientname'] ?? 'N/A' }}</div>
                <div><span class="label">Age</span> : {{ $user['age'] ?? 'N/A' }} {{ $user['ymd'] ?? '' }}</div>
                <div><span class="label">Address</span> : {{ $user['address'] ?? 'N/A' }}</div>
                <div><span class="label">Disease</span> : {{ $user['desease'] ?? 'N/A' }}</div>
                <div><span class="label">MLC/PMLC</span> : {{ $user['mlc_pmlc'] ?? 'N/A' }}</div>
                <div><span class="label">Ref Dr</span> : {{ $user['refered_dr'] ?? 'N/A' }}</div>
            </td>
            <td width="48%">
                <div><span class="label">Ipd No</span> : {{ $user['ipdno'] ?? 'N/A' }} &nbsp;|&nbsp; <span class="label">Opd No</span> : {{ $user['opdnumber'] ?? 'N/A' }}</div>
                <div><span class="label">Father/Husband Name</span> : {{ $user['fatherhusband'] ?? 'N/A' }}</div>
                <div><span class="label">Gender</span> : {{ $user['gender'] ?? 'N/A' }}</div>
                <div><span class="label">Contact No</span> : {{ $user['mobileno'] ?? 'N/A' }}</div>
                <div><span class="label">Registration date</span> : {{ $user['ipd_date'] ?? 'N/A' }} {{ $formattedTime }}</div>
                <div><span class="label">Fee / Free</span> : {{ $user['ipdamount'] ?? 'N/A' }}</div>
                <div><span class="label">{{ $user['ipdamount_type'] ?? 'PAID' }}</span></div>
            </td>
        </tr>
    </table>
</div>

<!-- ===== DIAGNOSIS / COMPLAINT / HISTORY ===== -->
<div class="diag-section">
    <div class="diag-row">
        Diagnosis <span class="diag-line">_______________________________________________________________________________________________________________</span>
    </div>
    <div class="diag-row">
        Complaint of <span class="diag-line">____________________________________________________________________________________________________________</span>
    </div>
    <div class="diag-row">
        History of <span class="diag-line">_______________________________________________________________________________________________________________</span>
    </div>
</div>

<!-- ===== MAIN WRITING AREA ===== -->
<table class="writing-table">
    <tr>
        <!-- Left: Rx writing space -->
        <td class="writing-left">
            @if($rx_b64)
                <img src="{{ $rx_b64 }}" class="rx-symbol">
            @else
                <div style="font-size:22px; font-weight:bold;">Rx</div>
            @endif
        </td>

        <!-- Right: Treatment Given + Consent -->
        <td class="writing-right">
            <div class="treatment-title">Treatment Given</div>

            <div class="consent-text">
               मैं स्वयं/अपने मरीज को अस्पताल में भर्ती कराने <br> तथा उपचार प्राप्त करने के लिए सहमत हूँ।.
                <br><br>
                <strong>रोगी / परिजन का नाम एवं हस्ताक्षर</strong>
            </div>
        </td>
    </tr>
</table>

<!-- ===== DASH LINE ===== -->
<div class="dash-line">
    - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
</div>

<!-- ===== FOOTER HEAD ===== -->
<div class="footer-head">
    डॉ. भीमराव अंबेडकर सामुदायिक स्वास्थ्य केंद्र, सिवनी मालवा, जिला–नर्मदापुरम (म.प्र.)
</div>

<div class="ward-title">वार्ड प्रवेश द्वार पासs</div>

<!-- ===== FOOTER BOX ===== -->
<div class="footer-box">
    <table>
        <tr>
            <td width="42%">
                <div><span class="label">Registration date</span> : {{ $user['ipd_date'] ?? 'N/A' }} {{ $formattedTime }}</div>
                <div><span class="label">Patient Name</span> : {{ $user['pesientname'] ?? 'N/A' }}</div>
                <div><span class="label">Father/Husband Name</span> : {{ $user['fatherhusband'] ?? 'N/A' }}</div>
            </td>
            <td width="58%" class="footer-note">
               वार्ड में मरीज के साथ केवल एक परिचारक ही उपस्थित रह सकेगा। मरीज से मिलने का समय प्रातः 7:00 बजे से 8:00 बजे तक तथा शाम 6:00 बजे से 8:00 बजे तक रहेगा। बिना कार्ड के प्रवेश करने पर कानूनी कार्रवाई की जाएगी।
            </td>
        </tr>
    </table>
</div>

@else
    <p style="text-align:center; margin-top:40px; font-size:14px;">No patient data found.</p>
@endif

</body>
</html>