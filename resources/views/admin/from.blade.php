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

                        <input type="hidden" class="emergency" id="emergency" />

                        <div class="row opd_id">
                            <div class="form-group col-md-3">
                                <label>Sr.#</label>
                                <input type="text" id="sr_no" name="sr_no" value="{{ $details['sr_no'] ?? '' }}" class="form-control" disabled>
                            </div>

                            <div class="form-group col-md-3">
                                <label>OPD ID:</label>
                                <input type="text" id="opd_id" name="opd_id" value="{{ $details['opd_id'] ?? '' }}" class="form-control" disabled>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Date:</label>
                                <input type="text" id="date" name="date" value="{{ $details['date'] ?? '' }}" class="form-control" disabled>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Time:</label>
                                <input type="text" id="time" name="time" value="{{ $details['time'] ?? '' }}" class="form-control" disabled>
                            </div>
                        </div>

                        <h4>Personal Information</h4>

                        <div class="row">
                            <div class="col-md-12">
                                <label>Patient's Name:</label>
                                <input type="text" id="patient_name" name="patient_name"
                                    value="{{ $details['pesientname'] ?? '' }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Gender:</label>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="">NONE</option>
                                    <option value="Male" {{ ($details['gender'] ?? '')=='Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ ($details['gender'] ?? '')=='Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ ($details['gender'] ?? '')=='Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Age:</label>
                                <input type="number" id="age" name="age" value="{{ $details['age'] ?? '' }}" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label>Days:</label>
                                <select id="days" name="days" class="form-control">
                                    <option value="Year" {{ ($details['ymd'] ?? '')=='Year' ? 'selected' : '' }}>Year</option>
                                    <option value="Month" {{ ($details['ymd'] ?? '')=='Month' ? 'selected' : '' }}>Month</option>
                                    <option value="Day" {{ ($details['ymd'] ?? '')=='Day' ? 'selected' : '' }}>Day</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Father/Husband Name:</label>
                                <input type="text" id="father_husband_name"
                                    value="{{ $details['fatherhusband'] ?? '' }}"
                                    name="father_husband_name" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Mobile No:</label>
                                <input type="text" id="mobile_no" value="{{ $details['mobileno'] ?? '' }}" name="mobile_no" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label>Address:</label>
                                <input type="text" id="address" value="{{ $details['address'] ?? '' }}" name="address" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Area:</label>
                                <select id="area" name="area" class="form-control">
                                    <option value="">NONE</option>
                                    <option value="RURAL" {{ ($details['area'] ?? '')=='RURAL' ? 'selected' : '' }}>Rural</option>
                                    <option value="URBAN" {{ ($details['area'] ?? '')=='URBAN' ? 'selected' : '' }}>Urban</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Caste:</label>
                                <input type="text" id="caste" value="{{ $details['caste'] ?? '' }}" name="caste" class="form-control">
                            </div>
                        </div>

                        <h4>Official Information</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Disease:</label>
                                <select id="disease" name="disease" class="form-control">
                                    <option value="">NONE</option>
                                    <option value="General Medicine" {{ ($details['desease'] ?? '')=='General Medicine' ? 'selected' : '' }}>सामान्य चिकित्सा</option>
                                    <option value="ANC Checkup" {{ ($details['desease'] ?? '')=='ANC Checkup' ? 'selected' : '' }}>एएनसी जांच</option>
                                    <option value="RTA & Accident" {{ ($details['desease'] ?? '')=='RTA & Accident' ? 'selected' : '' }}>आर.टी. एवं दुर्घटना</option>
                                    <option value="Poisoning" {{ ($details['desease'] ?? '')=='Poisoning' ? 'selected' : '' }}>जहर</option>
                                    <option value="Orthopedics" {{ ($details['desease'] ?? '')=='Orthopedics' ? 'selected' : '' }}>आर्थोपेडिक्स</option>
                                    <option value="Anti Rabies" {{ ($details['desease'] ?? '')=='Anti Rabies' ? 'selected' : '' }}>एंटी रेबीज</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>MLC/PMLC:</label>
                                <select id="mlc_pmlc" name="mlc_pmlc" class="form-control">
                                    <option value="NONE">None</option>
                                    <option value="MLC" {{ ($details['mlc_pmlc'] ?? '')=='MLC' ? 'selected' : '' }}>MLC</option>
                                    <option value="PMLC" {{ ($details['mlc_pmlc'] ?? '')=='PMLC' ? 'selected' : '' }}>PMLC</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Charges:</label>
                                <select id="charges" name="charges" class="form-control">
                                    <option value="">NONE</option>
                                    <option value="PAID" {{ ($details['charges'] ?? '')=='PAID' ? 'selected' : '' }}>PAID</option>
                                    <option value="FREE" {{ ($details['charges'] ?? '')=='FREE' ? 'selected' : '' }}>FREE</option>
                                </select>
                            </div>


                            <!-- <div class="col-md-4" id="freeoptionnew">
                                @if(($details['charges'] ?? '') == 'FREE')
                                <select id="free_option" name="free_option" class="form-control">
                                    @php $freeSelected = $details['free_option'] ?? ''; @endphp
                                    <option value="ayushman_card" {{ $freeSelected=='ayushman_card'?'selected':'' }}>AYUSHMAN CARD</option>
                                    <option value="delivery_case" {{ $freeSelected=='delivery_case'?'selected':'' }}>DELIVERY CASE</option>
                                    <option value="staff" {{ $freeSelected=='staff'?'selected':'' }}>STAFF</option>
                                    <option value="108_ambulance" {{ $freeSelected=='108_ambulance'?'selected':'' }}>108 AMBULANCE</option>
                                    <option value="pensionar" {{ $freeSelected=='pensionar'?'selected':'' }}>PENSIONAR</option>
                                    <option value="anc_check-up" {{ $freeSelected=='anc_check-up'?'selected':'' }}>ANC CHECK-UP</option>
                                    <option value="mlc" {{ $freeSelected=='mlc'?'selected':'' }}>MLC</option>
                                    <option value="jsy_delivery_case" {{ $freeSelected=='jsy_delivery_case'?'selected':'' }}>JSY DELIVERY CASE</option>
                                    <option value="ltt_case" {{ $freeSelected=='ltt_case'?'selected':'' }}>LTT CASE</option>
                                    <option value="nrc_child" {{ $freeSelected=='nrc_child'?'selected':'' }}>NRC CHILD</option>
                                    <option value="old_age_home" {{ $freeSelected=='old_age_home'?'selected':'' }}>OLD AGE HOME</option>
                                    <option value="100_dial" {{ $freeSelected=='100_dial'?'selected':'' }}>100 DIAL</option>
                                    <option value="baby_checkup" {{ $freeSelected=='baby_checkup'?'selected':'' }}>BABY CHECKUP</option>
                                    <option value="boys_girls_hostel" {{ $freeSelected=='boys_girls_hostel'?'selected':'' }}>BOYS & GIRLS HOSTEL</option>
                                    <option value="t.b._medicine" {{ $freeSelected=='t.b._medicine'?'selected':'' }}>T.B. MEDICINE</option>
                                    <option value="cardless_caseless" {{ $freeSelected=='cardless_caseless'?'selected':'' }}>CARDLESS / CASELESS</option>
                                </select>
                                @endif
                            </div> -->



                            <div class="col-md-4" id="freeoption">
                                
                                 @if(($details['charges'] ?? '') == 'FREE')
                                 <label>Select Type</label>
                                <select id="free_option" name="free_option" class="form-control">
                                    @php $freeSelected = $details['free_option'] ?? ''; @endphp
                                    <option value="ayushman_card" {{ $freeSelected=='ayushman_card'?'selected':'' }}>AYUSHMAN CARD</option>
                                    <option value="delivery_case" {{ $freeSelected=='delivery_case'?'selected':'' }}>DELIVERY CASE</option>
                                    <option value="staff" {{ $freeSelected=='staff'?'selected':'' }}>STAFF</option>
                                    <option value="108_ambulance" {{ $freeSelected=='108_ambulance'?'selected':'' }}>108 AMBULANCE</option>
                                    <option value="pensionar" {{ $freeSelected=='pensionar'?'selected':'' }}>PENSIONAR</option>
                                    <option value="anc_check-up" {{ $freeSelected=='anc_check-up'?'selected':'' }}>ANC CHECK-UP</option>
                                    <option value="mlc" {{ $freeSelected=='mlc'?'selected':'' }}>MLC</option>
                                    <option value="jsy_delivery_case" {{ $freeSelected=='jsy_delivery_case'?'selected':'' }}>JSY DELIVERY CASE</option>
                                    <option value="ltt_case" {{ $freeSelected=='ltt_case'?'selected':'' }}>LTT CASE</option>
                                    <option value="nrc_child" {{ $freeSelected=='nrc_child'?'selected':'' }}>NRC CHILD</option>
                                    <option value="old_age_home" {{ $freeSelected=='old_age_home'?'selected':'' }}>OLD AGE HOME</option>
                                    <option value="100_dial" {{ $freeSelected=='100_dial'?'selected':'' }}>100 DIAL</option>
                                    <option value="baby_checkup" {{ $freeSelected=='baby_checkup'?'selected':'' }}>BABY CHECKUP</option>
                                    <option value="boys_girls_hostel" {{ $freeSelected=='boys_girls_hostel'?'selected':'' }}>BOYS & GIRLS HOSTEL</option>
                                    <option value="t.b._medicine" {{ $freeSelected=='t.b._medicine'?'selected':'' }}>T.B. MEDICINE</option>
                                    <option value="cardless_caseless" {{ $freeSelected=='cardless_caseless'?'selected':'' }}>CARDLESS / CASELESS</option>
                                </select>
                                @else
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label>Charge Amount:</label>
                                <input type="text" disabled id="charge_amount" value="{{ $details['chargesamount'] ?? '' }}" name="charge_amount" class="form-control">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="button" id="newEntery" class="btn btn-warning">New Patient</button>
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-info" id="pdfButton">Print PDF</button>
                            <iframe id="pdfFrame" style="display: none;"></iframe>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        </div>
        <script src="{{ asset('/public/js/formsubmit.js') }}"></script>
    </section>

</main><!-- End #main -->
@endsection