@extends('layouts.app')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>OPD</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{('home')}}">Home</a></li>
                <li class="breadcrumb-item active">OPD</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="card">
                <div id="preloader" style="display: none;">
                    <div class="bar-container">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                    <h1 style="text-align: center;">Loading...</h1>
                </div>
                <form id="submitdata" action="" method="POST">
                    <div class="card-body">
                        @csrf
                        <!-- OPD ID -->
                         <input type="hidden" name="" class="emergency" id="emergency"/>
                        <div class="row opd_id">
                            <div class="form-group col-md-3">
                                <label for="Sr_no">Sr.#</label>
                                <input type="integer" id="sr_no" name="sr_no" value="" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="opd_id">OPD ID:</label>
                                <input type="text" id="opd_id" name="opd_id" value="" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="date">Date:</label>
                                <input type="text" id="date" name="date" value="" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="time">Time:</label>
                                <input type="text" id="time" name="time" value="" class="form-control" disabled>
                            </div>
                        </div>
                        <!-- Personal Information -->
                        <div class="mt-6 col-md-12">
                            <h4>Personal Information</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="patient_name">Patient's Name:</label>
                                        <input type="text" id="patient_name" name="patient_name" class="form-control">
                                        <span class="nameErr"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender:</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="">NONE</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <span class="genderErr"></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="age">Age:</label>
                                        <input type="number" id="age" name="age" class="form-control">
                                        <span class="ageErr"></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="days">Days:</label>
                                        <select id="days" name="days" class="form-control">
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_husband_name">Father/Husband Name:</label>
                                        <input type="text" id="father_husband_name" name="father_husband_name" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No:</label>
                                        <input type="text" id="mobile_no" name="mobile_no" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" id="address" name="address" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="area">Area:</label>
                                        <select id="area" name="area" class="form-control">
                                            <option value="">NONE</option>
                                            <option value="RURAL">Rural</option>
                                            <option value="URBAN">Urban</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="caste">Caste:</label>
                                        <input type="text" id="caste" name="caste" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Official Information -->
                        <div class="mt-6 col-md-12">
                            <h4>Official Information</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="disease">Disease:</label>
                                        <select id="disease" name="disease" class="form-control">
                                            <option value="">NONE</option>
                                            <option value="General Medicine">सामान्य चिकित्सा</option>
                                            <option value="ANC Checkup">एएनसी जांच</option>
                                            <option value="RTA & Accident">आर.टी. एवं दुर्घटना</option>
                                            <option value="Poisoning">जहर</option>
                                            <option value="Orthopedics">आर्थोपेडिक्स</option>
                                            <option value="Anti Rabies">एंटी रेबीज</option>
                                        </select>

                                        <span class="diseaseErr"></span>
                                        <!-- <input type="text" id="disease" name="disease" class="form-control"> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mlc_pmlc">MLC/PMLC:</label>
                                        <select id="mlc_pmlc" name="mlc_pmlc" class="form-control">
                                            <option value="NONE">None</option>
                                            <option value="MLC">MLC</option>
                                            <option value="PMLC">PMLC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="charges">Charges:</label>
                                        <select id="charges" name="charges" class="form-control">
                                            <option value="">NONE</option>
                                            <option value="PAID">PAID</option>
                                            <option value="FREE">FREE</option>
                                        </select>
                                        <span class="chargetypeErr"></span>
                                    </div>
                                </div>

                                <div id="freeoption" class="col-md-4">

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="charge_amount">Charge Amount:</label>
                                        <input type="text" id="charge_amount" name="charge_amount" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-4">
                            <button type="button" id="newEntery" class="btn btn-warning">New Pesient</button>
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-info" id="pdfButton">Print PDF</button>
                            <iframe id="pdfFrame" style="display: none;"></iframe>
                        </div>
                </form>
            </div>
        </div>
        </div>
        <script src="http://localhost/laravel_setup/public/js/formsubmit.js"></script>
    </section>

</main><!-- End #main -->
@endsection