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
            /* border: 2px solid black; */
            position: relative;
            margin-top: -12px;
        }

        .first_part {
            width: 18%;
            float: left;
            border: 2px solid black;
            margin-left: 5px;
            /* Space between the two parts */
        }

        .second_part {
            width: 79%;
            float: left;
            /* border: 2px solid green; */
            position: absolute;
            font-size: 12px;
        }

        .left {
            width: 38%;
            float: left;
            /* border: 2px solid black; */
            font-size: 12px;
            padding: 5px;
            margin-left: 25px;
            /* Space between the two parts */
        }

        .right {
            width: 50%;
            float: left;
            padding: 5px;
            margin-right: 25px;
            font-size: 12px;
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
            top: 45%;
            left: 72px;
        }

        .logo img {
            position: absolute;
            top: 0px;
            left: 35px;
            width: 100px;
            height: 100px;
        }

        .details_left p,
        .details_right p {
            margin-bottom: 5px;
            /* Adjust this value for desired spacing */
        }
    </style>

</head>

<body>

    @php

    // Format time from 24-hour to 12-hour format
    $time = $users[0]['ipd'] ?? '';
    $formattedTime = \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
    @endphp

    <div class="container-fluid">
        <div class="pdf-header" style="margin-top: 20px;">
            <div class="logo">
                <img src="{{ public_path('img/opd_ipd_logo.jpg') }}" alt="Logo" style="margin-top: 12px;" />
            </div>
            <!-- <p>रोगी कल्याण समिति</p> -->
            <p>Patient Welfare Committee</p>
            <!-- <p>डॉ.भीमराव अम्बेडकर सामु.स्वा. केन्द्र</p> -->
            <p>Dr. Bhimrao Ambedkar Samu.Sw. center</p>
            <!-- <p>सिवनी मालवा, जिला-नर्मदापुरम (म.प्र.)</p> -->
            <p>Seoni Malwa, District-Narmadapuram (M.P.)</p>
            <p>Dr. Bheemrao Ambedkar Community Health Center - Seoni Malwa,</p>
            <p>Distt-Narmadapuram (M.P.)</p>

            <div class="energency_contact">
                <p>Emergency Call No : 108/100</p>
            </div>
        </div>



        <div class="details_section">
            <!-- <p class="details_section1">बाह्य रोगी पंजीयन</p> -->
            <p class="details_section1">Inpatient Registration</p>
            <div class="details" style="padding: 10 6px;">

                <div class="details_left">
                    <p>Patient Name : {{$users[0]['pesientname']}}</p>
                    <p>Age : {{$users[0]['age']}} {{$users[0]['ymd']}}</p>
                    <p>Address : {{$users[0]['address']}}</p>
                    <p>Disease : {{$users[0]['desease']}}</p>
                    <p>MLC/PMLC : {{$users[0]['mlc_pmlc']}}</p>
                    <p>Ref Dr : {{$users[0]['refered_dr']}}</p>
                </div>
                <div class="details_right">
                    <p>Ipd No: {{$users[0]['ipdno']}} | Opd No : {{$users[0]['opdnumber']}}</p>
                    <p>Father/Husband Name : {{$users[0]['fatherhusband']}}</p>
                    <p>Gender : {{$users[0]['gender']}}</p>
                    <p>Contact No : {{$users[0]['mobileno']}}</p>
                    <p>Registration date : {{$users[0]['ipd_date']}} {{$formattedTime}}</p>
                    <p>Fee / Free : {{$users[0]['ipdamount']}}</p>
                    <p>{{$users[0]['ipdamount_type']}}</p>
                </div>

            </div>
        </div>

        <div class="main_title" style="padding: 0;"> <!-- Removed unnecessary padding -->
            <div class="duble_section" style="margin: 0; padding: 0;">
                <h4 style="margin: 0; padding: 5px 10px;">Diagnosis______________________________________________________________________________</h4>
                <h4 style="margin: 0; padding: 5px 9px;">Complaint of____________________________________________________________________________</h4>
                <h4 style="margin: 0; padding: 5px 9px;">History of______________________________________________________________________________</h4>
            </div>
        </div>


        <div class="writingplace" style="border:1px solid black;width:100%;height:530px;">
            <div class="leftsidewriteing" style="border-right:2px solid black; width:70%; height:500px;">
                <img src="{{ public_path('img/aaaa.jpg') }}" style="width:30px; height:30px; margin-top:10px;margin-left:15px;" />

            </div>
            <p style="position: absolute; right: 43px; top: 38%; white-space: nowrap; font-size:15px;">
                Treatment Given
            </p>

        </div>

        <div style="position: fixed; top: 76%;left:58.2%; width: 50%; padding: 10px; text-align: center; font-size:10px;">
            <p style="line-height: 1.5;">I agree to get myself / my patient admitted</p>
            <p style="line-height: 1.5;">to the hospital and receive treatment.</p>
            <p style="line-height: 1.5; margin-top: 18px;">Name and Signature of the Patient / Relative</p>
        </div>



        <div class="dash-line" style="margin-top:-5px;">
            <p>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</p>
        </div>
        <div class="pdfFooter" style="">
            <p class="pdffooter_line" style="text-align: center; font-size:14px;background-color:black;color:white;">Dr. Bhimrao Ambedkar Samu.Sw. Center Seoni Malwa, District-Narmadapuram (M.P.)</p>
            <p style="text-align:center">Ward Entry Gate Pass</p>
            <div class="medicin" style="">

                <div class="left">
                    <p>Registration date : {{$users[0]['ipd_date']}} {{$formattedTime}}</p>
                    <p>Patient Name : {{$users[0]['pesientname']}}</p>
                    <p>Father/Husband Name : {{$users[0]['fatherhusband']}}</p>
                </div>
                <div class="right">
                    <p>Only one attendant will be present with the patient in the ward. The time to visit the patient is from 7 am to 8 am and from 6 pm to 8 pm. Legal action will be taken if entry is made without the card.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>