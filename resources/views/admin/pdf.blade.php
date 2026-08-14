<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OPD Slip</title>
    <style>
        body {
            font-family: freeserif, DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            border: 1.5px solid #000;
            padding: 5px 7px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 1px 2px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 1.5px solid #000;
            margin-bottom: 3px;
        }

        .header-table img {
            width: 55px;
            height: 55px;
        }

        .charges-line {
            font-size: 15px;
            color: #c62828;
            font-weight: bold;
        }

        .header-title {
            font-size: 18px;
            font-weight: bold;
        }

        .header-sub {
            font-size: 15px;
            font-weight: bold;
            line-height: 1.25;
        }

        .reg-no {
            font-size: 11px;
            font-weight: bold;
            text-align: right;
            margin: 2px 0;
        }

        /* Black Title */
        .black-title {
            background: #fff;
            color: #000;
            text-align: center;
            font-weight: bold;
            padding: 3px 0;
            font-size: 12px;
            margin: 3px 0;
        }

        /* Patient Box */
        .patient-box {
            border: 1.5px solid #000;
            padding: 4px 6px;
            margin-bottom: 4px;
        }

        .patient-box td {
            font-size: 14px;
            line-height: 1.4;
            padding: 1px 3px;
        }

        .label {
            font-weight: bold;
            min-width: 95px;
            display: inline-block;
        }

        .fee-tag {
            background: #eee;
            padding: 1px 4px;
            font-weight: bold;
            font-size: 10px;
        }

        /* Main 2 Column */
        .main-table {
            width: 100%;
            border: 1.5px solid #000;
            margin-bottom: 4px;
            /* pehle 330px tha, hata diya */
        }

        .test-box {
            width: 23%;
            border-right: 1.5px solid #000;
            padding: 4px 5px;
            font-size: 2px;
        }

        .inv-title {
            font-weight: bold;
            font-size: 15px;
            border-bottom: 1px solid #000;
            margin-bottom: 30px;
            padding-bottom: 20px;
        }

        .inv-item {
            font-size: 16.6px;
            margin-top: 12px;
            padding: 2px 2px;
        }

        .rx-box {
            width: 73%;
            padding: 4px 8px 15px 8px;
            height: 560px;
            /* ← Height yahan se control hogi */
        }

        .field-label {
            font-weight: bold;
            font-size: 10.5px;
            margin-top: 5px;
            margin-bottom: 2px;
        }

        .treatment-title {
            font-weight: bold;
            font-size: 13px;
            margin: 8px 0 5px 0;
        }

        .treatment-title img {
            width: 24px;
            height: 24px;
            vertical-align: middle;
            margin-right: 5px;
        }

        .valid-note {
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            margin-top: 100px;
            padding-top: 5px;

        }

        /* Timing */
        .timing-bar {
            text-align: center;
            font-size: 9.5px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 3px 0;
            margin: 3px 0;
            font-weight: 600;
        }

        /* Footer */
        .footer-head {
            background: #fff;
            color: #000;
            text-align: center;
            padding: 4px 2px;
            font-weight: bold;
            font-size: 10px;
            line-height: 1.35;
        }

        .footer-box {
            border: 1.5px solid #000;
            border-top: none;
        }

        .footer-box td {
            font-size: 17px;
            line-height: 1.4;
            padding: 2px 4px;
        }

        .f-label {
            font-weight: bold;
            min-width: 105px;
            display: inline-block;

        }

        .footer-right {
            border-left: 1.5px solid #000;
            padding-left: 8px;
        }

        .med-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .med-title img {
            width: 22px;
            height: 22px;
            vertical-align: middle;
            margin-right: 4px;
        }

        .doctor-sig {
            text-align: right;
            margin-top: 8px;
            font-size: 9.5px;
            font-weight: bold;
        }

        .sig-line {
            display: inline-block;
            width: 120px;
            margin-right: 5px;
        }
    </style>
</head>

<body>

    @php
    // Safe variables
    $formattedTime = '';
    $res = '';

    if ($lastEntry) {
    $time = $lastEntry->ptime ?? '';
    if ($time) {
    try {
    $formattedTime = \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
    } catch (\Exception $e) {
    $formattedTime = $time;
    }
    }

    $free_option = $lastEntry->free_option ?? '';
    switch ($free_option) {
    case 'aayushmaan': $res = 'AayushMaan'; break;
    case '100_dial': $res = '100 Dial'; break;
    case 'janani_express': $res = 'Janani Express'; break;
    case 'staff': $res = 'STAFF'; break;
    default: $res = $free_option;
    }
    }

    // Images as base64 (most reliable for mPDF)
    $logo1 = public_path('img/opd_ipd_logo.jpg');
    $logo2 = public_path('img/second_logo.jpeg');
    $rxImg = public_path('img/aaaa.jpg');

    $logo1_b64 = file_exists($logo1) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logo1)) : '';
    $logo2_b64 = file_exists($logo2) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logo2)) : '';
    $rx_b64 = file_exists($rxImg) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($rxImg)) : '';
    @endphp

    <div class="container">

        <!-- HEADER -->
        <table class="header-table">
            <tr>
                <td width="12%" class="text-left">
                    @if($logo1_b64)
                    <img src="{{ $logo1_b64 }}" width="85" height="85">
                    @endif
                </td>
                <td width="76%" class="text-center">
                    <div class="charges-line">(जनरल चार्जेज :- 10 / इमरजेंसी चार्जेज :- 30) (IPD Amount :- 30)</div>
                    <div class="header-title">रोगी कल्याण समिति</div>
                    <div class="header-sub">डॉक्टर भीमराव आंबेडकर सिविल हॉस्पिटल</div>
                    <div class="header-sub">सिवनी मालवा, जिला -नर्मदापुरम (म.प्र.)</div>
                    <div class="header-sub">डॉक्टर भीमराव आंबेडकर सिविल हॉस्पिटल सिवनी मालवा</div>
                    <div class="header-sub">जिला -नर्मदापुरम (म.प्र.)</div>
                </td>
                <td width="12%" class="text-right">
                    @if($logo2_b64)
                    <img src="{{ $logo2_b64 }}" width="85" height="85">
                    @endif
                </td>
            </tr>
        </table>

        <!-- Registration No -->
        <div class="reg-no">
            Registration No : <strong>{{ $lastEntry->opdId ?? 'N/A' }}/228390</strong>
        </div>

        <!-- Title -->
        <div class="black-title">PATIENT REGISTRATION</div>

        <!-- Patient Details -->
        <div class="patient-box">
            <table>
                <tr>
                    <td width="50%">
                        <div><span class="label">Patient Name</span> : {{ $lastEntry->pesientname ?? 'N/A' }}</div>
                        <div><span class="label">Age</span> : {{ $lastEntry->age ?? 'N/A' }} {{ $lastEntry->ymd ?? '' }}</div>
                        <div><span class="label">Address</span> : {{ $lastEntry->address ?? 'N/A' }}</div>
                        <div><span class="label">Disease</span> : {{ $lastEntry->desease ?? 'N/A' }}</div>
                        <div><span class="label">MLC / PMLC</span> : {{ $lastEntry->mlc_pmlc ?? 'N/A' }}</div>
                    </td>
                    <td width="50%">
                        <div><span class="label">Father/Husband</span> : {{ $lastEntry->fatherhusband ?? 'N/A' }}</div>
                        <div><span class="label">Gender</span> : {{ $lastEntry->gender ?? 'N/A' }}</div>
                        <div><span class="label">Contact No</span> : {{ $lastEntry->mobileno ?? 'N/A' }}</div>
                        <div><span class="label">Registration Date</span> : {{ $lastEntry->pdate ?? 'N/A' }} {{ $formattedTime }}</div>
                        <div>
                            <span class="label">Fee / Free</span> :
                            ₹{{ $lastEntry->chargesamount ?? '0' }}
                            @if(($lastEntry->chargesamount ?? 0) == 10) (GENERAL) @else (EMERGENCY) @endif
                            @if($res) <span class="fee-tag">{{ $res }}</span> @endif
                        </div>
                        <div><span class="label">Charges</span> : {{ $lastEntry->charges ?? '' }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Investigation + Rx -->
        <table class="main-table">
            <tr>
                <td class="test-box">
                    <div class="inv-title">Investigation</div>
                    <div class="inv-item">[ ] ECG</div>
                    <div class="inv-item">[ ] USG</div>
                    <div class="inv-item">[ ] BMP</div>
                    <div class="inv-item">[ ] X-RAY</div>
                    <div class="inv-item">[ ] Acid-fast Bacillus (AFB)</div>
                    <div class="inv-item">[ ] CBC</div>
                    <div class="inv-item">[ ] Hb</div>
                    <div class="inv-item">[ ] T &amp; D</div>
                    <div class="inv-item">[ ] Platelets Count</div>
                    <div class="inv-item">[ ] Blood Pressure (BP)</div>
                    <div class="inv-item">[ ] Blood Group / Rh Factor</div>
                    <div class="inv-item">[ ] BT / CT</div>
                    <div class="inv-item">[ ] Blood Sugar Fasting</div>
                    <div class="inv-item">[ ] Blood Sugar PP</div>
                    <div class="inv-item">[ ] Blood Sugar Random</div>
                    <div class="inv-item">[ ] Serum Creatinine</div>
                    <div class="inv-item">[ ] Blood Urea</div>
                    <div class="inv-item">[ ] Serum Bilirubin</div>
                    <div class="inv-item">[ ] Uric Acid</div>
                    <div class="inv-item">[ ] WIDAL</div>
                    <div class="inv-item">[ ] HBsAg</div>
                    <div class="inv-item">[ ] Urine Pregnancy Test</div>
                    <div class="inv-item">[ ] Urine R/M</div>
                    <div class="inv-item">[ ] ESR</div>
                </td>

                <td class="rx-box">
                    <div class="field-label">Brief History :</div>
                    <div class="write-line"></div>
                    <div class="write-line"></div>

                    <div class="field-label">G / E :</div>
                    <div class="write-line"></div>

                    <div class="field-label">Presumptive / Definite Diagnosis :</div>
                    <div class="write-line"></div>
                    <div class="write-line"></div>

                    <div class="treatment-title">
                        @if($rx_b64)
                        <img src="{{ $rx_b64 }}" width="24" height="24">
                        @endif

                    </div>

                    <div class="write-line"></div>
                    <div class="write-line"></div>
                    <div class="write-line"></div>
                    <div class="write-line"></div>
                    <div class="write-line"></div>
                    <div class="write-line"></div>
                    <div class="write-line"></div>
                    <div class="write-line"></div>
                    <div class="write-line"></div>
                    <div class="write-line"></div>

                    <div class="valid-note" style="margin-top: 20px;">
                    </div>
                </td>
            </tr>
        </table>

        <!-- Timing -->
        <div class="timing-bar">
            This slip is valid for 7 days. After 7 days, second slip is mandatory. ||
            OPD Timings : 09:00 AM to 02:00 PM &nbsp;&nbsp;|&nbsp;&nbsp; Evening : 05:00 PM to 06:00 PM
        </div>

        <!-- Footer Head -->
        <div class="footer-head">
            डॉक्टर भीमराव आंबेडकर सिविल हॉस्पिटल - सिवनी मालवा, जिला-नर्मदापुरम (म.प्र.)
            <br>निःशुल्क औषधि वितरण केंद्र
        </div>

        <!-- Footer Box -->
        <div class="footer-box">
            <table>
                <tr>
                    <td width="42%">
                        <div><span class="f-label">Registration No</span> : {{ $lastEntry->opdId ?? 'N/A' }}</div>
                        <div><span class="f-label">Registration Date</span> : {{ $lastEntry->pdate ?? 'N/A' }} {{ $formattedTime }}</div>
                        <div><span class="f-label">Patient Name</span> : {{ $lastEntry->pesientname ?? 'N/A' }}</div>
                        <div><span class="f-label">Father / Husband</span> : {{ $lastEntry->fatherhusband ?? 'N/A' }}</div>
                        <div><span class="f-label">Mobile</span> : {{ $lastEntry->mobileno ?? 'N/A' }}</div>
                        <div><span class="f-label">Age / Gender</span> : {{ $lastEntry->age ?? 'N/A' }} {{ $lastEntry->ymd ?? '' }} / {{ $lastEntry->gender ?? 'N/A' }}</div>
                        <div><span class="f-label">Address</span> : {{ $lastEntry->address ?? 'N/A' }}</div>
                        <div><span class="f-label">Disease</span> : {{ $lastEntry->desease ?? 'N/A' }}</div>
                    </td>
                    <td width="58%" class="footer-right">
                        <div class="med-title">
                            @if($rx_b64)
                            <img src="{{ $rx_b64 }}" width="22" height="22">
                            @endif

                        </div>
                        <div class="write-line">_______________________________________________________________________________________</div>
                        <div class="write-line">_______________________________________________________________________________________</div>
                        <div class="write-line">_______________________________________________________________________________________</div>
                        <div class="write-line">_______________________________________________________________________________________</div>
                        <div class="write-line">_______________________________________________________________________________________</div>
                        <div class="write-line">_______________________________________________________________________________________</div>
                        <div class="write-line">_______________________________________________________________________________________</div>

                        <div class="doctor-sig">
                            <span class="sig-line">__________________________________________________________________________________________________________________________________________</span> Doctor Signature
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>

</html>