<!DOCTYPE html>
<html lang="hi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ek+Mukta" rel="stylesheet">
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        body {
            /* font-family: 'Noto Sans Devanagari', sans-serif; */
            font-family: 'Mangal', 'Noto Sans Devanagari', 'Arial Unicode MS', sans-serif;

        }

        .container-fluid {
            position: absolute;
            /* border: 1px solid red; */
            width: 100%;
            top: 0px;
            /* margin: auto; */
        }

        .pdf-header {
            /* border: 1px solid green; */
            text-align: center;
            margin-top: 15px;
        }

        .pdf-header p {
            margin: 3px 0;
            font-size: 12px;
        }

        .registration {
            position: absolute;
            top: 0px;
            right: 90px;
            text-align: right;
            font-weight: bold;
            font-size: 14px;
        }

        .energency_contact {
            position: absolute;
            top: 30px;
            right: 30px;
            text-align: right;
            font-weight: bold;
            font-size: 14px;
        }

        .details_section {
            /* border: 1px solid pink; */
            /* margin-top: 10px; */
            padding: 10px;
            position: relative;
        }

        .details_section1 {
            position: absolute;
            top: 0px;
            background-color: black;
            color: white;
            /* font-weight: bold; */
            text-align: center;
            /* width: 100%;
            padding: 5px; */
        }

        .details {
            margin-top: 18px;
            border: 2px solid black;
            font-size: 13px;
            padding: 5px;
        }

        .details .details_left {
            display: inline-block;
            width: 45%;
        }

        .details .details_right {
            display: inline-block;
            width: 45%;
            vertical-align: top;
        }

        .duble_section {
            /* border: 2px solid pink; */
            position: relative;
            margin-top: -12px;
            height: 560px;
        }

        .details_left p,
        .details_right p {
            margin-bottom:8px;
            /* Adjust the value as needed */
        }

        .first_part {
            width: 18%;
            float: left;
            border: 2px solid black;
            margin-left: 5px;
            height: 560px;
            /* Space between the two parts */
        }

        .first_part ul li {
            margin-top: 5px;
            font-size: 12.2px;
        }

        .second_part {
            width: 79%;
            float: left;
            /* border: 2px solid green; */
            position: absolute;
            font-size: 12px;
        }

        .left {
            width: 35%;
            float: left;
            /* border: 2px solid black; */
            font-size: 12px;
            padding: 5px;
            margin-left: 18px;
            /* border: 1px solid green; */
            /* Space between the two parts */
        }

        .right {
            width: 59%;
            float: left;
            /* border: 1px solid red; */
            /* border: 2px solid green; */
        }

        /* Clearfix to fix layout issues when using floats */
        .duble_section::after {
            content: "";
            clear: both;
            display: table;
        }

        .second_part p {
            margin-left: 5px;

        }

        .footer_line {
            position: absolute;
            top: 96%;
            left: 72px;
        }

        .logo img {
            position: absolute;
            top: 0px;
            left: 35px;
            width: 100px;
            height: 100px;
        }
    </style>

</head>

<body>

    <div class="container-fluid">
        <div class="pdf-header">
            <div class="logo">
                <img src="{{ public_path('img/opd_ipd_logo.jpg') }}" style="margin-top:10px;"/>
            </div>
            <!-- <p>रोगी कल्याण समिति</p> -->
            <p>Patient Welfare Committee</p>
            <!-- <p>डॉ.भीमराव अम्बेडकर सामु.स्वा. केन्द्र</p> -->
            <p>Dr. Bhimrao Ambedkar Samu.Sw. center</p>
            <!-- <p>सिवनी मालवा, जिला-नर्मदापुरम (म.प्र.)</p> -->
            <p>Seoni Malwa, District-Narmadapuram (M.P.)</p>
            <p>Dr. Bheemrao Ambedkar Community Health Center - Seoni Malwa,</p>
            <p>Distt-Narmadapuram (M.P.)</p>
            <div class="registration"style="margin-top:10px;">
                @if($lastEntry)
                <p>Registration No: {{$lastEntry->opdId}}</p>
                @else
                <p>Registration No: 12345</p>
                @endif
            </div>
            <div class="energency_contact" style="margin-top:13px;">
                <p>Emergency Call No : 108/100</p>
            </div>
        </div>

        @if($lastEntry)
    @php
        // Format time from 24-hour to 12-hour format
        $time = $lastEntry->ptime ?? '';
        $formattedTime = $time ? \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('h:i A') : '';

        // Assign the correct label for free_option
        $free_option = $lastEntry->free_option ?? '';

        switch ($free_option) {
            case 'aayushmaan':
                $res = 'AayushMaan';
                break;
            case '100_dial':
                $res = '100 Dial';
                break;
            case 'janani_express':
                $res = 'Janani Express';
                break;
            case 'staff':
                $res = 'STAFF';
                break;
            default:
                $res = $free_option; // If no match, show original value
        }
    @endphp



        <div class="details_section">
            <!-- <p class="details_section1">बाह्य रोगी पंजीयन</p> -->
            <p class="details_section1">Patient registration</p>
            <div class="details" style="">
                <div class="details_left"style="margin-top:15px !important;">
                    <p>Patient Name : {{ $lastEntry->pesientname ?? '' }}</p>
                    <p>Age : {{ $lastEntry->age ?? '' }} {{ $lastEntry->ymd ?? '' }}</p>
                    <p>Address : {{ $lastEntry->address ?? '' }}</p>
                    <p>Disease : {{ $lastEntry->desease ?? '' }}</p>
                    <p>MLC/PMLC : {{ $lastEntry->mlc_pmlc ?? '' }}</p>
                </div>
                <div class="details_right">
                    <p>Father/Husband Name : {{ $lastEntry->fatherhusband ?? '' }}</p>
                    <p>Gender : {{ $lastEntry->gender ?? '' }}</p>
                    <p>Contact No : {{ $lastEntry->mobileno ?? '' }}</p>
                    <p>Registration date : {{ $lastEntry->pdate ?? '' }},{{ $formattedTime }}</p>
                    <p>Fee / Free : {{ $lastEntry->chargesamount ?? '' }} rs {{ $res }}</p>
                    <p>{{ $lastEntry->charges ?? '' }}</p>
                </div>
            </div>
        </div>
        @else
        <p>No last entries found.</p>
        @endif



        <div class="duble_section">
            <div class="first_part">
                <ul style="margin-left:10px;list-style:none;font-size:11px">
                    <li>[ ] ECG</li>
                    <li>[ ] USG </li>
                    <li>[ ] BMP </li>
                    <li>[ ] X-BAY </li>
                    <li>[ ] Acid-fast bacilus(AFB) </li>
                    <li>[ ] CBC </li>
                    <li>[ ] Hb </li>
                    <li>[ ] T and D </li>
                    <li>[ ] T and D </li>
                    <li>[ ] Pallets Count </li>
                    <li>[ ] Pallets Count </li>
                    <li>[ ] Blood Presure(BP) </li>
                    <li>[ ] Blood group-Rh Factor </li>
                    <li>[ ] BTCT </li>
                    <li>[ ] Blood Sugar Fasting </li>
                    <li>[ ] Blood Sugar P.P. </li>
                    <li>[ ] Blood Sugar R. </li>
                    <li>[ ] Serum Creatinine </li>
                    <li>[ ] Blood Urea </li>
                    <li>[ ] Serum Bilrubin </li>
                    <li>[ ] Uric Acid </li>
                    <li>[ ] WIDAL </li>
                    <li>[ ] Aust. Antigen(HbSag) </li>
                    <li>[ ] Urin Pregnancy Test </li>
                    <li>[ ] Urine Test R and M </li>
                    <li>[ ] ESR </li>
                </ul>
            </div>

            <div class="second_part">
                <p class="p1">Brief Histoey :</p>
                <p class="p2">G/F :</p>
                <p class="p3"> Presumptive/Definite Diagnosis :</p>
                <p class="footer_line">This slip is valid for 7 days. After 7 days, a second slip is mandatory</p>
                <img src="{{ public_path('img/aaaa.jpg') }}" style="width:30px; height:30px; margin-top:10px;margin-left:15px;" />
                <p style="margin-left:65px; margin-top:-30px;text-align:center">Treatment Advised</p>
            </div>
        </div>
        <hr style="width: 100%; color:black" />
        <div class="timetable" style="font-size:13px;">
            <p style="text-align:center">OPD timings are from 9.00 am to 2.00 pm and from 5.00 pm to 6.00 pm.</p>
        </div>
        <div class="dash-line" style="margin-top:-5px;">
            <p>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</p>
        </div>
        <div class="pdfFooter" style="">
            <p class="pdffooter_line" style="text-align: center; font-size:14px;background-color:black;color:white;">Dr. Bhimrao Ambedkar Samu.Sw. Center Seoni Malwa, District-Narmadapuram (M.P.) - Free Medicine Distribution Center</p>
            <div class="medicin" style="">
                @if($lastEntry)
                @php
                // Format time from 24-hour to 12-hour format
                $time = $lastEntry->ptime ?? '';
                $formattedTime = \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
                @endphp
                <div class="left" style="font-family: Arial, sans-serif; font-size: 12px; line-height: 1.5;">
                    <p>External Registration Co :- {{ $lastEntry->opdId ?? '' }}</p>
                    <p>Registration date :- {{ $lastEntry->pdate ?? '' }}, {{ $formattedTime }}</p>
                    <p>Patient Name :- {{ $lastEntry->pesientname ?? '' }}</p>
                    <p>Father/Husband Name :- {{ $lastEntry->fatherhusband ?? '' }}</p>
                    <p>Mobile Number :- {{ $lastEntry->mobileno ?? '' }}</p>
                    <p>Age/Gender :- {{ $lastEntry->age ?? '' }} {{ $lastEntry->gender ?? '' }} {{ $lastEntry->ymd ?? '' }}</p>
                    <p>Address :- {{ $lastEntry->address ?? '' }}</p>
                    <p>Disease :- {{ $lastEntry->desease ?? '' }}</p>
                </div>

                @else
                <div class="left">
                    <p>External Registration Co : </p>
                    <p>Registration date : </p>
                    <p>Patient Name : </p>
                    <p>Father/Husband Name : </p>
                    <p>Mobile Number : </p>
                    <p>Age/Gender : </p>
                    <p>Address : </p>
                    <p>Disease : </p>
                </div>
                @endif

                <div class="right">
                    <img src="{{ public_path('img/aaaa.jpg') }}" style="width:25px; height:25px; margin-top:10px;margin-left:15px;" />
                    <div class="footerdashline">
                        <p style="margin-left:55px; margin-top:-15px">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </p>
                        <p>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </p>
                        <p>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </p>
                        <p>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </p>
                        <p>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </p>
                        <p>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </p>
                        <p>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>