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
                        <input type="hidden" name="" class="emergency" id="emergency" />
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
                                    <select name="free_option" id="free_option" class="form-control" fdprocessedid="nimphi">
                                        <option value="aayushmaan">Aayushman Card</option>
                                        <option value="100_dial">100 Dial</option>
                                        <option value="janani_express">Janani Express</option>
                                        <option value="staff">Staff</option>
                                    </select>
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
            // =============================================
            // DYNAMIC URL CONFIGURATION
            // =============================================
            // Change this base URL to match your environment
            const BASE_URL = window.location.origin + '/laravel_setup'; // For local development
            // For production, you might use: const BASE_URL = 'https://yourdomain.com/api';
            // Or detect dynamically: const BASE_URL = window.location.origin + '/your-project-folder';

            // API Endpoints
            const API_URLS = {
                OPD_SEARCH: BASE_URL + '/opdsearchData',
                FORM_SUBMIT: BASE_URL + '/fromsubmit',
                EMERGENCY: BASE_URL + '/emergency',
                PRINT_OPD_PDF: BASE_URL + '/print-opd-pdf'
            };

            // =============================================
            // HELPER FUNCTIONS
            // =============================================

            // Helper function to safely get element value
            function getElementValue(elementId) {
                const element = document.getElementById(elementId);
                return element ? element.value : '';
            }

            // Helper function to safely set element value
            function setElementValue(elementId, value) {
                const element = document.getElementById(elementId);
                if (element) {
                    element.value = value;
                }
            }

            // Helper function to get CSRF token
            function getCsrfToken() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                return csrfToken ? csrfToken.getAttribute('content') : '';
            }

            // Helper function to get CSRF headers for FormData
            function getCsrfHeaders() {
                const headers = {};
                const token = getCsrfToken();
                if (token) {
                    headers["X-CSRF-TOKEN"] = token;
                }
                return headers;
            }

            // Helper function to show toast messages
            function showToast(type, message) {
                if (typeof toastr !== 'undefined') {
                    const toastMethods = {
                        success: toastr.success,
                        error: toastr.error,
                        info: toastr.info,
                        warning: toastr.warning
                    };
                    const method = toastMethods[type] || toastr.info;
                    method(message);
                } else {
                    console.log(`[${type.toUpperCase()}] ${message}`);
                    alert(message);
                }
            }

            // =============================================
            // LOADER FUNCTIONS
            // =============================================

            function showLoader() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.display = 'block';
                }
            }

            function hideLoader() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.display = 'none';
                }
            }

            // =============================================
            // MAIN CODE
            // =============================================

            document.addEventListener("DOMContentLoaded", function() {
                console.log("DOM fully loaded and parsed");
                console.log("BASE_URL:", BASE_URL);
                console.log("API Endpoints:", API_URLS);

                // Disable buttons initially
                document.getElementById("pdfButton").disabled = true;
                document.getElementById("update").disabled = true;
                // document.getElementById("freeoption").style.display = "none";

                // =============================================
                // SHOW ALERT FUNCTION - Fetch OPD Data
                // =============================================
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

                        fetch(API_URLS.OPD_SEARCH, {
                                method: "POST",
                                headers: getCsrfHeaders(),
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

                                    // Set all form fields with data
                                    setElementValue('sr_no', data.data.sno ?? '');
                                    setElementValue('opd_id', data.data.opdId ?? '');
                                    setElementValue('date', data.data.pdate ?? '');
                                    setElementValue('time', time12);
                                    setElementValue('patient_name', data.data.pesientname ?? '');
                                    setElementValue('gender', data.data.gender ?? '');
                                    setElementValue('age', data.data.age ?? '');
                                    setElementValue('days', data.data.ymd ?? '');
                                    setElementValue('father_husband_name', data.data.fatherhusband ?? '');
                                    setElementValue('mobile_no', data.data.mobileno ?? '');
                                    setElementValue('address', data.data.address ?? '');
                                    setElementValue('area', data.data.area ?? '');
                                    setElementValue('caste', data.data.caste ?? '');
                                    setElementValue('disease', data.data.desease ?? '');
                                    setElementValue('mlc_pmlc', data.data.mlc_pmlc ?? '');
                                    setElementValue('charges', data.data.charges ?? '');

                                    // Add change event listener to charges dropdown
                                    const chargesSelect = document.getElementById('charges');
                                    if (chargesSelect) {
                                        chargesSelect.addEventListener('change', function() {
                                            chagersupdate(this.value);
                                        });
                                    }

                                    // Show/hide free option based on charges
                                    const freeOption = document.getElementById("freeoption");
                                    if (freeOption) {
                                        if (data.data.charges === 'PAID') {
                                            // freeOption.style.display = "none";
                                        } else {
                                            freeOption.style.display = "block";
                                        }
                                    }

                                    setElementValue('free_option', data.data.free_option ?? '');
                                    setElementValue('charge_amount', data.data.chargesamount ?? '');

                                    document.getElementById("pdfButton").disabled = false;
                                    document.getElementById("update").disabled = false;

                                    showToast('success', "Fetch Record Successfully!");
                                } else {
                                    hideLoader();
                                    // Clear all form fields
                                    const fields = [
                                        'sr_no', 'opd_id', 'date', 'time', 'patient_name',
                                        'gender', 'age', 'days', 'father_husband_name',
                                        'mobile_no', 'address', 'area', 'caste', 'disease',
                                        'mlc_pmlc', 'charges', 'charge_amount'
                                    ];
                                    fields.forEach(field => setElementValue(field, ''));

                                    showToast('error', "No Record Found!");
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showToast('error', 'An error occurred while fetching data');
                                hideLoader();
                            });
                    } else {
                        hideLoader();
                        showToast('warning', 'Please enter an OPD ID');
                    }
                }

                // =============================================
                // EVENT LISTENERS
                // =============================================
                document.getElementById("opd_id").addEventListener("change", showAlert);
                // document.getElementById("patient_name").addEventListener("change", showAlert);

                // =============================================
                // FORM SUBMIT HANDLER - Update Data
                // =============================================
                document.getElementById("submitdata").addEventListener("submit", function(e) {
                    e.preventDefault();

                    let name = document.getElementById("patient_name").value;
                    let gender = document.getElementById("gender").value;
                    let age = document.getElementById("age").value;
                    let disease = document.getElementById("disease").value;
                    let chargeType = document.getElementById("charges").value;
                    let chargesAmount = document.getElementById("charge_amount").value;
                    let emergency = document.getElementById("emergency").value;
                    let checkdetails = true;

                    // Validate Name
                    if (name === '') {
                        checkdetails = false;
                        let nameErr = document.getElementsByClassName('nameErr')[0];
                        if (nameErr) {
                            nameErr.innerHTML = 'Please Fill This Field';
                            nameErr.style.color = 'red';
                        }
                    } else {
                        let nameErr = document.getElementsByClassName('nameErr')[0];
                        if (nameErr) {
                            nameErr.innerHTML = '';
                        }
                    }

                    // Validate Gender
                    if (gender === '') {
                        checkdetails = false;
                        let genderErr = document.getElementsByClassName('genderErr')[0];
                        if (genderErr) {
                            genderErr.innerHTML = 'Please Select This Field';
                            genderErr.style.color = 'red';
                        }
                    } else {
                        let genderErr = document.getElementsByClassName('genderErr')[0];
                        if (genderErr) {
                            genderErr.innerHTML = '';
                        }
                    }

                    // Validate Age
                    if (age === '') {
                        checkdetails = false;
                        let ageErr = document.getElementsByClassName('ageErr')[0];
                        if (ageErr) {
                            ageErr.innerHTML = 'Please Select This Field';
                            ageErr.style.color = 'red';
                        }
                    } else {
                        let ageErr = document.getElementsByClassName('ageErr')[0];
                        if (ageErr) {
                            ageErr.innerHTML = '';
                        }
                    }

                    // Validate Disease
                    if (disease === '') {
                        checkdetails = false;
                        let diseaseErr = document.getElementsByClassName('diseaseErr')[0];
                        if (diseaseErr) {
                            diseaseErr.innerHTML = 'Please Select This Field';
                            diseaseErr.style.color = 'red';
                        }
                    } else {
                        let diseaseErr = document.getElementsByClassName('diseaseErr')[0];
                        if (diseaseErr) {
                            diseaseErr.innerHTML = '';
                        }
                    }

                    // Validate Charge Type
                    if (chargeType === '') {
                        checkdetails = false;
                        let chargeErr = document.getElementsByClassName('chargetypeErr')[0];
                        if (chargeErr) {
                            chargeErr.innerHTML = 'Please Select This Field';
                            chargeErr.style.color = 'red';
                        }
                    } else {
                        let chargeErr = document.getElementsByClassName('chargetypeErr')[0];
                        if (chargeErr) {
                            chargeErr.innerHTML = '';
                        }
                    }

                    if (checkdetails) {
                        showLoader();
                        let formData = new FormData(this);
                        formData.append("serialnumber", document.getElementById("sr_no").value);
                        formData.append("opd_id", document.getElementById("opd_id").value);
                        formData.append("date", document.getElementById("date").value);
                        formData.append("time", document.getElementById("time").value);

                        if (emergency == 'yes') {
                            formData.append("tags", 'emergency');
                        } else {
                            formData.append("tags", 'general');
                        }

                        formData.append("charge_amount", document.getElementById("charge_amount").value);
                        // console.log('from',formData);return;

                        fetch(API_URLS.FORM_SUBMIT, {
                                method: "POST",
                                headers: getCsrfHeaders(),
                                body: formData,
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status) {
                                    showToast('success', "Details Update Successfully");
                                    document.getElementById("pdfButton").disabled = false;
                                    hideLoader();
                                } else {
                                    showToast('error', "Error: " + data.message);
                                    hideLoader();
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                showToast('error', 'Failed to update details');
                                hideLoader();
                            });
                    }
                });

                // =============================================
                // PDF BUTTON CLICK HANDLER
                // =============================================
                document.getElementById("pdfButton").addEventListener("click", function() {
                    let opdId = document.getElementById("opd_id").value;
                    if (!opdId) {
                        showToast('error', "Please enter OPD ID first!");
                        return;
                    }

                    showLoader();
                    let pdfFrame = document.getElementById("pdfFrame");
                    // Use dynamic URL for PDF
                    let pdfUrl = `${API_URLS.PRINT_OPD_PDF}/${opdId}`;

                    if (pdfFrame) {
                        pdfFrame.onload = function() {
                            pdfFrame.contentWindow.focus();
                            pdfFrame.contentWindow.print();
                            hideLoader();
                            showToast('success', "PDF printed successfully!");
                        };
                        pdfFrame.onerror = function() {
                            hideLoader();
                            showToast('error', "Failed to load PDF");
                        };
                        pdfFrame.src = pdfUrl;
                    } else {
                        hideLoader();
                        showToast('error', "PDF frame not found");
                    }
                });
            });

            // =============================================
            // CHARGES UPDATE FUNCTION
            // =============================================
            function chagersupdate(chargeType) {
                if (chargeType === 'PAID') {
                    const freeOption = document.getElementById("freeoption");
                    if (freeOption) {
                        freeOption.style.display = "block";
                        freeOption.innerHTML = "";
                    }

                    emergency().then(emergencyValue => {
                        console.log("Emergency Value:", emergencyValue);
                        const chargeAmount = document.getElementById('charge_amount');
                        if (chargeAmount) {
                            if (emergencyValue == 'yes') {
                                chargeAmount.value = '30.00';
                            } else {
                                chargeAmount.value = '10.00';
                            }
                        }
                    });
                } else if (chargeType === 'FREE') {
                    emergency().then(emergencyValue => {
                        console.log("Emergency Value:", emergencyValue);
                        const chargeAmount = document.getElementById('charge_amount');
                        if (chargeAmount) {
                            chargeAmount.value = '0';
                        }
                    });

                    let container = document.getElementById("freeoption");
                    if (container) {
                        container.innerHTML = "";

                        let newSelect = document.createElement("select");
                        newSelect.name = "free_option";
                        newSelect.id = "free_option";
                        newSelect.className = "form-control";

                        // Create options
                        let option1 = new Option("Aayushman Card", "aayushmaan");
                        let option2 = new Option("100 Dial", "100_dial");
                        let option3 = new Option("Janani Express", "janani_express");
                        let option4 = new Option("Staff", "staff");

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

                        const chargeAmount = document.getElementById('charge_amount');
                        if (chargeAmount) {
                            chargeAmount.value = '0.00';
                        }
                    }
                } else {
                    const chargeAmount = document.getElementById('charge_amount');
                    if (chargeAmount) {
                        chargeAmount.value = '';
                    }
                }
            }

            // =============================================
            // EMERGENCY FUNCTION
            // =============================================
            async function emergency() {
                showLoader();
                try {
                    let response = await fetch(API_URLS.EMERGENCY, {
                        method: "GET",
                        headers: getCsrfHeaders()
                    });

                    let data = await response.json();

                    if (data.status) {
                        hideLoader();
                        const emergencySelect = document.getElementById('emergency');
                        if (emergencySelect) {
                            emergencySelect.value = data.emergency;
                        }
                        return data.emergency; // Return the emergency value
                    } else {
                        showToast('error', "Error: " + data.message);
                        hideLoader();
                        return null; // Return null in case of an error
                    }
                } catch (error) {
                    console.error("Error fetching emergency data:", error);
                    showToast('error', 'Failed to fetch emergency status');
                    hideLoader();
                    return null; // Return null if fetch fails
                }
            }

            // =============================================
            // EXPOSE FUNCTIONS FOR GLOBAL ACCESS
            // =============================================
            window.showLoader = showLoader;
            window.hideLoader = hideLoader;
            window.chagersupdate = chagersupdate;
            window.emergency = emergency;
            window.getCsrfToken = getCsrfToken;
            window.getCsrfHeaders = getCsrfHeaders;
            window.showToast = showToast;
            window.getElementValue = getElementValue;
            window.setElementValue = setElementValue;
            window.BASE_URL = BASE_URL;
            window.API_URLS = API_URLS;
        </script>
    </section>

</main><!-- End #main -->
@endsection