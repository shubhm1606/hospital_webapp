@extends('layouts.app')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
    <h1>OPD SEARCH</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{('home')}}">Home</a></li>
            <li class="breadcrumb-item active">OPD SEARCH</li>
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
                            <input type="integer" id="sr_no" name="sr_no" value="" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="opd_id">OPD ID:</label>
                            <input type="text" id="opd_id" name="opd_id" value="" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="date">Date:</label>
                            <input type="text" id="date" name="date" value="" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="time">Time:</label>
                            <input type="text" id="time" name="time" value="" class="form-control">
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
                                <label>Option</label>
                                <select name="free_option" id="free_option" class="form-control" fdprocessedid="nimphi"><option value="aayushmaan">Aayushman Card</option><option value="100_dial">100 Dial</option><option value="janani_express">Janani Express</option><option value="staff">Staff</option></select>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="charge_amount">Charge Amount:</label>
                                    <input type="text" id="charge_amount" name="charge_amount" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-4">
                        <!-- <button type="button" id="newEntery" class="btn btn-warning">New Pesient</button> -->
                        <button type="submit" class="btn btn-success" id="update">Update</button>
                        <button type="button" class="btn btn-info" id="pdfButton">Print PDF</button>
                        <iframe id="pdfFrame" style="display: none;"></iframe>
                    </div>
            </form>
        </div>
    </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("pdfButton").disabled = true;
        document.getElementById("update").disabled = true;
        // document.getElementById("freeoption").style.display = "none";

        function showAlert(event) {
            event.preventDefault(); 
            showLoader();
            document.getElementById("pdfButton").disabled = true;
            document.getElementById("update").disabled = true;
            let opd_id = document.getElementById('opd_id').value;
            // let pname = document.getElementById('patient_name').value;

            if (opd_id) { 

                let formData = new FormData();
                formData.append("opd_id", opd_id);
                // formData.append("pname", pname);

                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

                fetch("http://localhost/laravel_setup/opdsearchData", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                   
                    if (data.status == true) {
                        hideLoader();
                        let time24 = data.data.ptime ?? '';
                        let time12 = '';
                        if (time24) {
                            let [hours, minutes, seconds] = time24.split(':');
                            hours = parseInt(hours);
                            const ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12 || 12; // Convert '0' to '12'
                            time12 = `${hours}:${minutes}:${seconds} ${ampm}`;
                        }

                        document.getElementById('sr_no').value = data.data.sno ?? '';
                        document.getElementById('opd_id').value = data.data.opdId ?? '';
                        document.getElementById('date').value = data.data.pdate ?? '';
                        document.getElementById('time').value = time12;
                        document.getElementById('patient_name').value = data.data.pesientname ?? '';
                        document.getElementById('gender').value = data.data.gender ?? '';
                        document.getElementById('age').value = data.data.age ?? '';
                        document.getElementById('days').value = data.data.ymd ?? '';
                        document.getElementById('father_husband_name').value = data.data.fatherhusband ?? '';
                        document.getElementById('mobile_no').value = data.data.mobileno ?? '';
                        document.getElementById('address').value = data.data.address ?? '';
                        document.getElementById('area').value = data.data.area ?? '';
                        document.getElementById('caste').value = data.data.caste ?? '';
                        document.getElementById('disease').value = data.data.desease ?? '';
                        document.getElementById('mlc_pmlc').value = data.data.mlc_pmlc ?? '';
                        document.getElementById('charges').value = data.data.charges ?? '';
                        document.getElementById('charges').addEventListener('change', function () {
                            chagersupdate(this.value);
                        });
                        if (data.data.charges === 'PAID') {
                            // document.getElementById("freeoption").style.display = "none";
                        } else {
                            document.getElementById("freeoption").style.display = "block";
                        }

                        document.getElementById('free_option').value = data.data.free_option ?? '';
                        document.getElementById('charge_amount').value = data.data.chargesamount ?? '';
                        document.getElementById("pdfButton").disabled = false;
                        document.getElementById("update").disabled = false;
                        toastr.success("Fetch Record Successfully!");

                    } else {
                        hideLoader();
                        document.getElementById('sr_no').value = '';
                        document.getElementById('opd_id').value = '';
                        document.getElementById('date').value = '';
                        document.getElementById('time').value = '';
                        document.getElementById('patient_name').value = '';
                        document.getElementById('gender').value = '';
                        document.getElementById('age').value =  '';
                        document.getElementById('days').value =  '';
                        document.getElementById('father_husband_name').value =  '';
                        document.getElementById('mobile_no').value =  '';
                        document.getElementById('address').value =  '';
                        document.getElementById('area').value = '';
                        document.getElementById('caste').value = '';
                        document.getElementById('disease').value =  '';
                        document.getElementById('mlc_pmlc').value =  '';
                        document.getElementById('charges').value =  '';
                        document.getElementById('charge_amount').value =  '';

                        toastr.error("No Record Found!");
                    }
                })
                .catch(error => console.error('Error:', error));
                hideLoader();
            }
        }
        document.getElementById("opd_id").addEventListener("change", showAlert);
        // document.getElementById("patient_name").addEventListener("change", showAlert);


        document.getElementById("submitdata").addEventListener("submit", function (e) {
        e.preventDefault();
        let name = document.getElementById("patient_name").value;
        let gender = document.getElementById("gender").value;
        let age = document.getElementById("age").value;
        let disease = document.getElementById("disease").value;
        let chargeType = document.getElementById("charges").value;
        let chargesAmount = document.getElementById("charge_amount").value;
        let emergency = document.getElementById("emergency").value;
        let checkdetails = true;

        if (name === '') {
            checkdetails = false;
            let nameErr = document.getElementsByClassName('nameErr')[0];
            nameErr.innerHTML = 'Please Fill This Field';
            nameErr.style.color = 'red';
        }else{
            let nameErr = document.getElementsByClassName('nameErr')[0];
            nameErr.innerHTML = '';
        }   

        if (gender === '') {
            checkdetails = false;
            let genderErr = document.getElementsByClassName('genderErr')[0];
            genderErr.innerHTML = 'Please Select This Field';
            genderErr.style.color = 'red';
        }else{
            let genderErr = document.getElementsByClassName('genderErr')[0];
            genderErr.innerHTML = '';
        }

        if (age === '') {
            checkdetails = false;
            let ageErr = document.getElementsByClassName('ageErr')[0];
            ageErr.innerHTML = 'Please Select This Field';
            ageErr.style.color = 'red';
        }else{
            let ageErr = document.getElementsByClassName('ageErr')[0];
            ageErr.innerHTML = '';
        }

        if (disease === '') {
            checkdetails = false;
            let diseaseErr = document.getElementsByClassName('diseaseErr')[0];
            diseaseErr.innerHTML = 'Please Select This Field';
            diseaseErr.style.color = 'red';
        }else{
            let diseaseErr = document.getElementsByClassName('diseaseErr')[0];
            diseaseErr.innerHTML = '';
        }

        if (chargeType === '') {
            checkdetails = false;
            let chargeErr = document.getElementsByClassName('chargetypeErr')[0];
            chargeErr.innerHTML = 'Please Select This Field';
            chargeErr.style.color = 'red';
        }else{
            let chargeErr = document.getElementsByClassName('chargetypeErr')[0];
            chargeErr.innerHTML = '';
        }

        if (checkdetails) {
            showLoader();
            let formData = new FormData(this);
            formData.append("serialnumber", document.getElementById("sr_no").value);
            formData.append("opd_id", document.getElementById("opd_id").value);
            formData.append("date", document.getElementById("date").value);
            formData.append("time", document.getElementById("time").value);
            if(emergency == 'yes'){
                formData.append("tags",'emergency');
            }else{
                formData.append("tags",'general');
            }

            formData.append("charge_amount", document.getElementById("charge_amount").value);
            // console.log('from',formData);return;
            fetch("http://localhost/laravel_setup/fromsubmit", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    toastr.success("Details Update Successfully");

                    document.getElementById("pdfButton").disabled = false;
                    hideLoader();
                } else {
                    toastr.error("Error: " + data.message);
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });

        document.getElementById("pdfButton").addEventListener("click", function () {
            let opdId = document.getElementById("opd_id").value;
            if (!opdId) {
                toastr.error("Please enter OPD ID first!");
                return;
            }
            showLoader();
            let pdfFrame = document.getElementById("pdfFrame");
            let pdfUrl = `{{ url('print-opd-pdf') }}/${opdId}`;

            pdfFrame.onload = function () {
                pdfFrame.contentWindow.focus();
                pdfFrame.contentWindow.print();
                hideLoader();
                toastr.success("PDF printed successfully!");
            };
            pdfFrame.src = pdfUrl;
            hideLoader();
        });

    });



    function chagersupdate(chargeType) {
        if (chargeType === 'PAID') {
            document.getElementById("freeoption").style.display = "block";
            let container = document.getElementById("freeoption");
            container.innerHTML = "";
            emergency().then(emergencyValue => {
                console.log("Emergency Value:", emergencyValue);
                if(emergencyValue == 'yes'){
                    document.getElementById('charge_amount').value = 30.00;
                }else{
                    document.getElementById('charge_amount').value = 10.00;
                }
            });
        } else if (chargeType === 'FREE') {
            emergency().then(emergencyValue => {
                console.log("Emergency Value:", emergencyValue);
                if(emergencyValue == 'no'){
                    document.getElementById('charge_amount').value = 0;
                }else{
                    document.getElementById('charge_amount').value = 0;
                }
            });
            let container = document.getElementById("freeoption");
            container.innerHTML = "";

            let newSelect = document.createElement("select");
            newSelect.name = "free_option";
            newSelect.id = "free_option";
            newSelect.className = "form-control";
            
            let option1 = new Option("Aayushman Card","aayushmaan");
            let option2 = new Option("100 Dial","100_dial");
            let option3 = new Option("Janani Express","janani_express");
            let option4 = new Option("Staff","staff");
            
            newSelect.appendChild(option1);
            newSelect.appendChild(option2);
            newSelect.appendChild(option3);
            newSelect.appendChild(option4);

            let label = document.createElement("label");
            label.innerText = "Option:";
            
            let div = document.createElement("div");
            div.className = "form-group";
            div.appendChild(label);
            div.appendChild(newSelect);

            container.appendChild(div);
            document.getElementById('charge_amount').value = 0.00;
        } else {
        document.getElementById('charge_amount').value = '';
        }
    }


    async function emergency() {
        showLoader();
        try {
            let response = await fetch("http://localhost/laravel_setup/emergency", {
                method: "GET"
            });

            let data = await response.json();

            if (data.status) {
                hideLoader();
                document.getElementById('emergency').value = data.emergency;
                return data.emergency; // Return the emergency value
            } else {
                toastr.error("Error: " + data.message);
                return null; // Return null in case of an error
            }
        } catch (error) {
            console.error("Error fetching emergency data:", error);
            return null; // Return null if fetch fails
        }
    }

    function showLoader() {
        document.getElementById('preloader').style.display = 'block';
    }

    function hideLoader() {
        document.getElementById('preloader').style.display = 'none';
    }
    </script>
</section>

</main><!-- End #main -->
@endsection