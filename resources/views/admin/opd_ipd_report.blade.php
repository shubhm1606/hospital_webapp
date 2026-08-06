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
            font-family: 'Mangal', 'Noto Sans Devanagari', 'Arial Unicode MS', sans-serif;
        }

        .container-fluid {
            position: absolute;
            width: 100%;
            top: 0px;
        }

        .pdf-header {
            text-align: center;
        }

        .pdf-header p {
            margin: 3px 0;
            font-size: 12px;
        }

        .logo img {
            position: absolute;
            top: 0px;
            left: 35px;
            width: 100px;
            height: 100px;
        }

        #filter_records th,
        #filter_records td {
            border: 1px solid black;
            padding: 8px;
        }

        .container-fluid {
            padding: 12px;
            /* Adds padding on left and right */
        }

        .table-container {
            width: 97%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            table-layout: fixed;
            /* Ensures uniform column width */
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            /* text-align: center; */
            /* word-wrap: break-word; */
        }

        th:first-child,
        td:first-child {
            padding: 20px;
            width: 1200px;
            white-space: nowrap;
        }
    </style>

</head>

<body>
    
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

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th rowspan="3">Date</th>
                            <th colspan="8">OPD Patients (Number of Patients and Income)</th>
                            <th colspan="4">IPD Patients (Number of Patients and Income)</th>
                            <th colspan="8">Income Received Through Receipts</th>
                            <th colspan="2">Grand Total</th>
                        </tr>
                        <tr>
                            <th colspan="3">General OPD (Rs.10.00)</th>
                            <th colspan="3">Special OPD (Rs.30.00)</th>
                            <th colspan="2">Total</th>
                            <th colspan="2">IPD (Rs.30.00)</th>
                            <th colspan="2">Total</th>
                            <th colspan="2">Private Ward</th>
                            <th colspan="2">X-Ray</th>
                            <th colspan="2">Anti Rabies</th>
                            <th colspan="2">Total</th>
                            <th colspan="2"> </th>
                        </tr>
                        <tr>
                            <th>Free</th>
                            <th>Paid</th>
                            <th>Income</th>
                            <th>Free</th>
                            <th>Paid</th>
                            <th>Income</th>
                            <th>Number</th>
                            <th>Income</th>
                            <th>Free</th>
                            <th>Paid</th>
                            <th>Number</th>
                            <th>Income</th>
                            <th>Number</th>
                            <th>Income</th>
                            <th>Number</th>
                            <th>Income</th>
                            <th>Number</th>
                            <th>Income</th>
                            <th>Number</th>
                            <th>Income</th>
                            <th>Number</th>
                            <th>Income</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Initialize the total variables before using them --}}
                        @php
                            $totalOpdFree = 0;
                            $totalOpdPaid = 0;
                            $totalOpdAmount = 0;
                            $totalemrOpdFree = 0;
                            $totalemrOpdPaid = 0;
                            $totalemrOpdAmount = 0;
                            $totalIpdFree = 0;
                            $totalIpdPaid = 0;
                            $totalIpdAmount = 0;
                            $grandTotalPatients = 0;
                            $grandTotalAmount = 0;
                            
                        @endphp

                        @foreach($records as $data)
                            @php
                                $totalOpdFree += $data['opd_free_count'];
                                $totalOpdPaid += $data['opd_paid_count'];
                                $totalOpdAmount += $data['opd_total_amount'];

                                $totalemrOpdFree += $data['em_opd_free_count'];
                                $totalemrOpdPaid += $data['em_opd_paid_count'];
                                $totalemrOpdAmount += $data['em_opd_total_amount'];

                                $totalIpdFree += $data['ipd_free_count'];
                                $totalIpdPaid += $data['ipd_paid_count'];
                                $totalIpdAmount += $data['ipd_total_amount'];

                                $grandTotalPatients += $data['opd_free_count'] + $data['opd_paid_count'] + $data['ipd_free_count'] + $data['ipd_paid_count'] + $data['em_opd_free_count'] + $data['em_opd_paid_count'];
                                $grandTotalAmount += $data['opd_total_amount'] + $data['ipd_total_amount'] + $data['em_opd_total_amount'];
                            @endphp
                            <tr>
                                <td style="width:50px;font-size:9px;text-align:center;">{{$data['date']}}</td>
                                <td style="width:50px;font-size:14px;">{{$data['opd_free_count']}}</td>
                                <td style="width:50px;font-size:14px;">{{$data['opd_paid_count']}}</td>
                                <td style="width:50px;font-size:14px;">{{$data['opd_total_amount']}}</td>

                                <td style="width:50px;font-size:14px;">{{$data['em_opd_free_count']}}</td>
                                <td style="width:50px;font-size:14px;">{{$data['em_opd_paid_count']}}</td>
                                <td style="width:50px;font-size:14px;">{{$data['em_opd_total_amount']}}</td>

                                <td style="width:50px;font-size:14px;">{{$data['opd_free_count'] + $data['opd_paid_count'] + $data['em_opd_free_count']  +$data['em_opd_paid_count']}}</td>
                                <td style="width:50px;font-size:14px;">{{$data['opd_total_amount'] + $data['em_opd_total_amount']}}</td>
                                <td style="width:50px;font-size:14px;">{{$data['ipd_free_count']}}</td>
                                <td style="width:50px;font-size:14px;">{{$data['ipd_paid_count']}}</td>
                                <td style="width:50px;font-size:14px;">{{$data['ipd_free_count'] + $data['ipd_paid_count']}}</td>
                                <td style="width:50px;font-size:14px;">{{$data['ipd_total_amount']}}</td>
                                <td style="width:50px;font-size:14px;">-</td>
                                <td style="width:50px;font-size:14px;">-</td>
                                <td style="width:50px;font-size:14px;">-</td>
                                <td style="width:50px;font-size:14px;">-</td>
                                <td style="width:50px;font-size:14px;">-</td>
                                <td style="width:50px;font-size:14px;">-</td>
                                <td style="width:50px;font-size:14px;">-</td>
                                <td style="width:50px;font-size:14px;">-</td>
                                <td style="width:50px;font-size:14px;">{{ $data['opd_free_count'] + $data['opd_paid_count'] + $data['ipd_free_count'] + $data['ipd_paid_count'] + $data['em_opd_free_count'] + $data['em_opd_paid_count'] }}</td>
                                <td style="width:50px;font-size:14px;">{{$data['opd_total_amount'] + $data['ipd_total_amount'] + $data['em_opd_total_amount']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="font-weight:bold;">Total</td>
                            <td style="font-weight:bold;">{{$totalOpdFree}}</td>
                            <td style="font-weight:bold;">{{$totalOpdPaid}}</td>
                            <td style="font-weight:bold;">{{$totalOpdAmount}}</td>

                            <td style="font-weight:bold;">{{$totalemrOpdFree}}</td>
                            <td style="font-weight:bold;">{{$totalemrOpdPaid}}</td>
                            <td style="font-weight:bold;">{{$totalemrOpdAmount}}</td>

                            <td style="font-weight:bold;">{{$totalOpdFree + $totalOpdPaid + $totalemrOpdFree + $totalemrOpdPaid}}</td> 
                            <td style="font-weight:bold;">{{$totalOpdAmount + $totalemrOpdAmount}}</td>
                            <td style="font-weight:bold;">{{$totalIpdFree}}</td>
                            <td style="font-weight:bold;">{{$totalIpdPaid}}</td>
                            <td style="font-weight:bold;">{{$totalIpdFree + $totalIpdPaid}}</td>
                            <td style="font-weight:bold;">{{$totalIpdAmount}}</td>
                            <td style="font-weight:bold;">-</td>
                            <td style="font-weight:bold;">-</td>
                            <td style="font-weight:bold;">-</td>
                            <td style="font-weight:bold;">-</td>
                            <td style="font-weight:bold;">-</td>
                            <td style="font-weight:bold;">-</td>
                            <td style="font-weight:bold;">-</td>
                            <td style="font-weight:bold;">-</td>
                            <td style="font-weight:bold;">{{$grandTotalPatients}}</td>
                            <td style="font-weight:bold;">{{$grandTotalAmount}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</body>

</html>