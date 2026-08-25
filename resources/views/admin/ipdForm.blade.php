@extends('layouts.app')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>IPD Entry</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">IPD Entry</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
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
                <form id="ipdFromsubmit" action="" method="POST">
                    <div class="card-body">
                        @csrf
                        <!-- OPD ID -->
                        <div class="row opd_id">
                            <div class="form-group col-md-4">
                                <label for="Sr_no">Sr.#</label>
                                <input type="integer" id="sr_no" name="sr_no" value="12345" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="opd_id">Search OPD ID:</label>
                                <input type="text" id="opd_id" name="opd_id" value="" class="form-control text-center">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="date">IPD:</label>
                                <input type="text" id="ipd" name="ipd" value="54321" class="form-control" disabled>
                            </div>
                        </div>
                        <!-- Personal Information -->
                        <div class="mt-6 col-md-12">
                            <h4>Personal Information</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="patient_name">Patient's Name:</label>
                                        <input type="text" id="patient_name" name="patient_name" class="form-control" disabled>
                                        <span class="nameErr"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender:</label>
                                        <select id="gender" name="gender" class="form-control" disabled>
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
                                        <input type="number" id="age" name="age" class="form-control" disabled>
                                        <span class="ageErr"></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="days">Days:</label>
                                        <select id="days" name="days" class="form-control" disabled>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_husband_name">Father/Husband Name:</label>
                                        <input type="text" id="father_husband_name" name="father_husband_name" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date:</label>
                                        <input type="text" id="date" name="date" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" id="address" name="address" class="form-control" disabled>
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
                                        <label for="disease">Rerferd BY Dr:</label>
                                        <select class="form-control" name="refDr" id="refDr">
                                            <option value="">NONE</option>
                                            @foreach($doctors as $doctor)
                                            <option value="{{$doctor->name_en}}">{{$doctor->name_hi}}</option>
                                            @endforeach
                                            <!-- <option value="Dr. Kanti Batham">डॉ. कांति बाथम</option> -->
                                            <!-- <option value="Dr. Shekhar Raghuvanshi">डॉ. शेखर रघुवंशी</option> -->
                                            <!-- <option value="Dr. Rishi Chaubey">डॉ. ऋषि चौबे</option> -->
                                            <!-- <option value="Dr. Brajesh Rajput">डॉ. ब्रजेश राजपूत</option> -->
                                            <!-- <option value="Dr. Kamakshi Gehlot">डॉ. कामाक्षी गहलोत</option> -->
                                            <!-- <option value="Dr. Rishi Sahu">डॉ. ऋषि साहू</option> -->
                                            <!-- <option value="Dr. Virendra Singh Raag">डॉ. वीरेंद्र सिंह</option> -->
                                            <!-- <option value="Dr. Ayushi Agrawal">डॉ. आयुषी अग्रवाल</option> -->
                                            <!-- <option value="Dr. Shweta Raghuvan">डॉ. श्वेता रघुवान</option> -->
                                            <!-- <option value="Dr. Poonam Gaur">डॉ. पूनम गौर</option> -->
                                            <!-- <option value="Dr. Jai Singh Kushwaha">डॉ. जय सिंह कुशवाह</option> -->
                                            <!-- <option value="Dr. Shubham Mahto">डॉ. शुभम महतो</option> -->
                                            <!-- <option value="Dr. Shailendra YADUVANSHI">डॉ. शैलेन्द्र यदुवंशी</option> -->
                                            <!-- <option value="Dr. Vishakha Rajput">डॉ. विशाखा राजपूत</option> -->
                                            <!-- <option value="Dr. Aashi Chaure">डॉ. आशी चौरे</option> -->
                                            <!-- <option value="Dr. ANKITA POGHAT">डॉ. अंकिता फोगाट</option> -->
                                            <!-- <option value="Dr. Neha Dwevadi">डॉ. नेहा द्विवेदी</option> -->
                                            <!-- <option value="Dr. Ankit Tiwari">डॉ.अंकित तिवारी</option> -->
                                            <!-- <option value="Dr. Dhara Negi">डॉ.धरा नेगी</option> -->
                                            <option value="Dr. ">डॉ. </option>
                                        </select>
                                        <span class="doctorErr"></span>


                                        <span class="diseaseErr"></span>
                                        <!-- <input type="text" id="disease" name="disease" class="form-control"> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mlc_pmlc">MLC/PMLC:</label>
                                        <select id="mlc_pmlc" name="mlc_pmlc" class="form-control" disabled>
                                            <option value="NONE">None</option>
                                            <option value="MLC">MLC</option>
                                            <option value="PMLC">PMLC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mlc_pmlc">Ward Number:</label>
                                        <input type="number" class="form-control" id="wardnumber" name="wardnumber">
                                        <span class="wordnumberErr"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mlc_pmlc">Ward Type:</label>
                                        <select id="wardType" name="wardType" class="form-control">
                                            <option value="">None</option>
                                            <option value="MALE WARD">MALE WARD</option>
                                            <option value="FMALE WARD">FMALE WARD</option>
                                            <option value="MCH WARD">MCH WARD</option>
                                        </select>
                                        <span class="wordtypeErr"></span>
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
                                        <span class="chanrgetypeErr"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="charge_amount">Charge Amount:</label>
                                        <input type="text" id="charge_amount" name="charge_amount" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="charge_amount">OPD Amount:</label>
                                        <input type="text" id="opdamount" name="charge_amount" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-4">
                            <!-- <button type="button" id="newEntery" class="btn btn-warning">New Pesient</button> -->
                            <button type="button" id="submitBtn" class="btn btn-info">Save</button>
                            <button type="button" id="pdfprint" class="btn btn-warning" disabled>Print PDF</button>
                            <!-- <button type="button" class="btn btn-info" id="pdfButton">Print PDF</button> -->
                            <iframe id="pdfFrame" style="display: none;"></iframe>
                        </div>
                </form>
            </div>
        </div>
        </div>
        <script src="{{asset('public/js/ipdfrom.js')}}"></script>

    </section>

</main><!-- End #main -->
@endsection