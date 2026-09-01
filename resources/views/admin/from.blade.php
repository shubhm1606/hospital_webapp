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
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                <label>Patient's Name: <span class="text-danger">*</span></label>
                                <div class="input-group transliterate-wrapper">
                                    <input type="text" id="patient_name" name="patient_name"
                                        value="{{ old('patient_name', $details['pesientname'] ?? '') }}"
                                        class="form-control transliterate"
                                        placeholder="Type in English e.g. Shubham"
                                        required>
                                    <button type="button" class="btn btn-outline-secondary transliterate-btn" data-target="patient_name">🔤 Convert to Hindi</button>
                                </div>
                                <div id="patient_name_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>

                            <div class="col-md-6">
                                <label>Gender: <span class="text-danger">*</span></label>
                                <select id="gender" name="gender" class="form-control" required>
                                    
                                    <option value="Male" {{ (old('gender', $details['gender'] ?? ''))=='Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ (old('gender', $details['gender'] ?? ''))=='Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ (old('gender', $details['gender'] ?? ''))=='Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <div id="gender_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>

                            <div class="col-md-3">
                                <label>Age: <span class="text-danger">*</span></label>
                                <input type="number" id="age" name="age"
                                    value="{{ old('age', $details['age'] ?? '') }}"
                                    class="form-control"
                                    min="0" max="150"
                                    required>
                                <div id="age_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>

                            <div class="col-md-3">
                                <label>Days: <span class="text-danger">*</span></label>
                                <select id="days" name="days" class="form-control" required>
                                    <option value="Year" {{ (old('days', $details['ymd'] ?? ''))=='Year' ? 'selected' : '' }}>Year</option>
                                    <option value="Month" {{ (old('days', $details['ymd'] ?? ''))=='Month' ? 'selected' : '' }}>Month</option>
                                    <option value="Day" {{ (old('days', $details['ymd'] ?? ''))=='Day' ? 'selected' : '' }}>Day</option>
                                </select>
                                <div id="days_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>


                            <div class="col-md-2">
                                <label>Relation: <span class="text-danger">*</span></label>
                                <select id="relation" name="relation" class="form-control" required>
                                  
                                    <option value="S/O" {{ (old('relation', $details['relation'] ?? ''))=='S/O' ? 'selected' : '' }}>S/O (Son of)</option>
                                    <option value="W/O" {{ (old('relation', $details['relation'] ?? ''))=='W/O' ? 'selected' : '' }}>W/O (Wife of)</option>
                                    <option value="D/O" {{ (old('relation', $details['relation'] ?? ''))=='D/O' ? 'selected' : '' }}>D/O (Daughter of)</option>
                                </select>
                                <div id="relation_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>

                            <div class="col-md-6">
                                <label>Father/Husband Name: <span class="text-danger">*</span></label>
                                <div class="input-group transliterate-wrapper">
                                    <input type="text" id="father_husband_name"
                                        value="{{ old('father_husband_name', $details['fatherhusband'] ?? '') }}"
                                        name="father_husband_name"
                                        class="form-control transliterate"
                                        placeholder="Type in English e.g. Bhimrao"
                                        required>
                                    <button type="button" class="btn btn-outline-secondary transliterate-btn" data-target="father_husband_name">🔤 Convert to Hindi</button>
                                </div>
                                <div id="father_husband_name_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>



                            <div class="col-md-4">
                                <label>Mobile No: <span class="text-danger">*</span></label>
                                <input type="text" id="mobile_no"
                                    value="{{ old('mobile_no', $details['mobileno'] ?? '') }}"
                                    name="mobile_no"
                                    class="form-control"
                                    placeholder="Enter 10 digit mobile number"
                                    >
                                <div id="mobile_no_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>

                            <div class="col-md-12">
                                <label>Address: <span class="text-danger">*</span></label>
                                <div class="input-group transliterate-wrapper">
                                    <input type="text" id="address"
                                        value="{{ old('address', $details['address'] ?? '') }}"
                                        name="address"
                                        class="form-control transliterate"
                                        placeholder="Type address in English"
                                        required>
                                    <button type="button" class="btn btn-outline-secondary transliterate-btn" data-target="address">🔤 Convert to Hindi</button>
                                </div>
                                <div id="address_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>

                            <div class="col-md-6" style="display:none">
                                <label>Area: <span class="text-danger"></span></label>
                                <select id="area" name="area" class="form-control" >
                                    <option value="">Select Area</option>
                                    <option value="RURAL" {{ (old('area', $details['area'] ?? ''))=='RURAL' ? 'selected' : '' }}>Rural</option>
                                    <option value="URBAN" {{ (old('area', $details['area'] ?? ''))=='URBAN' ? 'selected' : '' }}>Urban</option>
                                </select>
                                <div id="area_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>

                            <div class="col-md-6" style="display:none">
                                <label>Caste:</label>
                                <input type="text" id="caste"
                                    value="{{ old('caste', $details['caste'] ?? '') }}"
                                    name="caste"
                                    class="form-control">
                                <div id="caste_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>
                        </div>

                        <h4>Official Information</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Disease: <span class="text-danger">*</span></label>
                                <select id="disease" name="disease" class="form-control" required>
                                 
                                    <option value="General Medicine" {{ (old('disease', $details['desease'] ?? ''))=='General Medicine' ? 'selected' : '' }}>सामान्य चिकित्सा</option>
                                    <option value="ANC Checkup" {{ (old('disease', $details['desease'] ?? ''))=='ANC Checkup' ? 'selected' : '' }}>एएनसी जांच</option>
                                    <option value="RTA & Accident" {{ (old('disease', $details['desease'] ?? ''))=='RTA & Accident' ? 'selected' : '' }}>आर.टी. एवं दुर्घटना</option>
                                    <option value="Poisoning" {{ (old('disease', $details['desease'] ?? ''))=='Poisoning' ? 'selected' : '' }}>जहर</option>
                                    <option value="Orthopedics" {{ (old('disease', $details['desease'] ?? ''))=='Orthopedics' ? 'selected' : '' }}>आर्थोपेडिक्स</option>
                                    <option value="Anti Rabies" {{ (old('disease', $details['desease'] ?? ''))=='Anti Rabies' ? 'selected' : '' }}>एंटी रेबीज</option>
                                    <option value="बुखार" {{ (old('disease', $details['desease'] ?? ''))=='बुखार' ? 'selected' : '' }}>बुखार </option>
                                    <option value="पेट एवं उलटी दस्त " {{ (old('disease', $details['desease'] ?? ''))=='पेट एवं उलटी दस्त ' ? 'selected' : '' }}>पेट एवं उलटी दस्त  </option>
                                    <option value="टी वी" {{ (old('disease', $details['desease'] ?? ''))=='टी वी' ? 'selected' : '' }}>टी वी </option>
                                    <option value="सर्दी खासी " {{ (old('disease', $details['desease'] ?? ''))=='सर्दी खासी ' ? 'selected' : '' }}>सर्दी खासी  </option>
                                </select>
                                <div id="disease_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>

                            <div class="col-md-6">
                                <label>MLC/PMLC:</label>
                                <select id="mlc_pmlc" name="mlc_pmlc" class="form-control">
                                    <option value="NONE">None</option>
                                    <option value="MLC" {{ (old('mlc_pmlc', $details['mlc_pmlc'] ?? ''))=='MLC' ? 'selected' : '' }}>MLC</option>
                                   
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Charges: <span class="text-danger">*</span></label>
                                <select id="charges" name="charges" class="form-control" required>
                                    <option value="">Select Charges</option>
                                    <option value="PAID" {{ (old('charges', $details['charges'] ?? ''))=='PAID' ? 'selected' : '' }}>PAID</option>
                                    <option value="FREE" {{ (old('charges', $details['charges'] ?? ''))=='FREE' ? 'selected' : '' }}>FREE</option>
                                </select>
                                <div id="charges_error" class="text-danger" style="font-size: 12px;"></div>
                            </div>

                            <div class="col-md-4" id="freeoption">
                                @if((old('charges', $details['charges'] ?? '')) == 'FREE')
                                <label>Select Type: <span class="text-danger">*</span></label>
                                <select id="free_option" name="free_option" class="form-control" required>
                                    @php $freeSelected = old('free_option', $details['free_option'] ?? ''); @endphp
                                    <option value="">Select Type</option>
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
                                <div id="free_option_error" class="text-danger" style="font-size: 12px;"></div>
                                @else
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label>Charge Amount:</label>
                                <input type="text" disabled id="charge_amount"
                                    value="{{ old('charge_amount', $details['chargesamount'] ?? '') }}"
                                    name="charge_amount"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                           <a href="{{ url('opd') }}" type="button" class="btn btn-warning">New Patient</a>
                            <button type="submit" class="btn btn-success" id="submitBtn">Save</button>
                            <button type="button" class="btn btn-info" id="pdfButton" disabled>Print PDF</button>
                            <iframe id="pdfFrame" style="display: none;"></iframe>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        </div>

        {{-- SANSCRIPT LIBRARY (CDN) --}}
        <!-- <script src="https://cdn.jsdelivr.net/npm/sanscript@0.2.2/dist/sanscript.min.js"></script> -->
        <script src="{{ asset('/public/js/sanscript.js') }}"></script>
        <script src="{{ asset('/public/js/formsubmit.js') }}"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                // Function to transliterate text using Google API
                async function getTransliteration(word) {
                    try {
                        const url = "https://inputtools.google.com/request" +
                            "?text=" + encodeURIComponent(word) +
                            "&itc=hi-t-i0-und" +
                            "&num=5" +
                            "&cp=0" +
                            "&cs=1" +
                            "&ie=utf-8" +
                            "&oe=utf-8";

                        const response = await fetch(url);

                        if (!response.ok) {
                            throw new Error("Online transliteration failed");
                        }

                        const data = await response.json();

                        if (data && data[0] === "SUCCESS" && data[1] && data[1][0] && data[1][0][1] && data[1][0][1].length > 0) {
                            return data[1][0][1][0];
                        } else {
                            throw new Error("Invalid response");
                        }

                    } catch (error) {
                        console.warn("Online transliteration failed. Using offline Sanscript.", error);

                        try {
                            if (typeof Sanscript !== 'undefined') {
                                return Sanscript.t(word, "itrans", "devanagari");
                            } else {
                                console.error("Sanscript library not loaded");
                                return word;
                            }
                        } catch (offlineError) {
                            console.error("Offline transliteration error:", offlineError);
                            return word;
                        }
                    }
                }

                // Function to transliterate a full text
                async function transliterateFullText(text) {
                    try {
                        // Split by spaces to process each word
                        const words = text.split(/\s+/);
                        const processedWords = [];

                        for (const word of words) {
                            if (/^[a-zA-Z]+$/.test(word) && word.length >= 1) {
                                try {
                                    const hindi = await getTransliteration(word);
                                    processedWords.push(hindi);
                                } catch (e) {
                                    processedWords.push(word);
                                }
                            } else if (/^[\u0900-\u097F]+$/.test(word)) {
                                // Already in Hindi
                                processedWords.push(word);
                            } else {
                                // Keep other text as is (numbers, punctuation, etc.)
                                processedWords.push(word);
                            }
                        }

                        return processedWords.join(' ');
                    } catch (error) {
                        console.error("Transliteration error:", error);
                        return text;
                    }
                }

                // Handle transliteration buttons
                const transliterateBtns = document.querySelectorAll('.transliterate-btn');
                
                transliterateBtns.forEach(function(btn) {
                    btn.addEventListener('click', async function() {
                        const targetId = this.getAttribute('data-target');
                        const inputField = document.getElementById(targetId);
                        
                        if (!inputField) {
                            console.error('Input field not found:', targetId);
                            return;
                        }

                        const text = inputField.value.trim();
                        
                        if (text.length === 0) {
                            alert('Please enter some text first');
                            return;
                        }

                        // Check if text contains English characters
                        const hasEnglish = /[a-zA-Z]/.test(text);
                        
                        if (!hasEnglish) {
                            alert('Text already appears to be in Hindi/Devanagari script');
                            return;
                        }

                        // Show loading state
                        const originalText = this.innerHTML;
                        this.innerHTML = '⏳ Converting...';
                        this.disabled = true;

                        try {
                            // Transliterate the text
                            const transliterated = await transliterateFullText(text);
                            
                            // Update input field
                            inputField.value = transliterated;
                            
                            // Trigger change event
                            const event = new Event('change', { bubbles: true });
                            inputField.dispatchEvent(event);
                            
                            // Show success feedback
                            inputField.style.borderColor = '#28a745';
                            inputField.style.backgroundColor = '#f0fff0';
                            
                            // Show success message
                            showStatusMessage(inputField, '');
                            
                            setTimeout(() => {
                                inputField.style.borderColor = '';
                                inputField.style.backgroundColor = '';
                            }, 2000);

                        } catch (error) {
                            console.error('Transliteration failed:', error);
                            showStatusMessage(inputField, '❌ Transliteration failed. Please try again.');
                        } finally {
                            // Reset button
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }
                    });
                });

                // Function to show status message
                function showStatusMessage(inputElement, message) {
                    // Remove existing status
                    const parent = inputElement.parentElement;
                    let existingStatus = parent.querySelector('.transliterate-status');
                    if (existingStatus) {
                        existingStatus.remove();
                    }
                    
                    const status = document.createElement('div');
                    status.className = 'transliterate-status';
                    status.style.fontSize = '12px';
                    status.style.marginTop = '4px';
                    status.style.color = message.includes('✅') ? '#28a745' : '#dc3545';
                    status.innerHTML = message;
                    
                    parent.appendChild(status);
                    
                    // Auto-remove after 4 seconds
                    setTimeout(() => {
                        if (status.parentNode) {
                            status.remove();
                        }
                    }, 4000);
                }

                // Keyboard shortcut: Ctrl+Enter to transliterate current field
                document.addEventListener('keydown', function(e) {
                    if (e.ctrlKey && e.key === 'Enter') {
                        const activeElement = document.activeElement;
                        if (activeElement && activeElement.classList.contains('transliterate')) {
                            // Find the corresponding transliterate button
                            const wrapper = activeElement.closest('.transliterate-wrapper');
                            if (wrapper) {
                                const btn = wrapper.querySelector('.transliterate-btn');
                                if (btn) {
                                    e.preventDefault();
                                    btn.click();
                                }
                            }
                        }
                    }
                });

                // Add hint when typing English
                document.addEventListener('input', function(e) {
                    if (e.target.classList.contains('transliterate')) {
                        const value = e.target.value;
                        const hasEnglish = /[a-zA-Z]/.test(value);
                        const hasHindi = /[\u0900-\u097F]/.test(value);
                        
                        const parent = e.target.parentElement;
                        let hint = parent.querySelector('.transliterate-hint');
                        
                        if (hasEnglish && !hasHindi && value.length > 1) {
                            if (!hint) {
                                hint = document.createElement('div');
                                hint.className = 'transliterate-hint';
                                hint.style.fontSize = '11px';
                                hint.style.color = '#17a2b8';
                                hint.style.marginTop = '2px';
                                hint.innerHTML = '';
                                parent.appendChild(hint);
                            }
                        } else {
                            if (hint) {
                                hint.remove();
                            }
                        }
                    }
                });

                // Optional: Add a global function to transliterate all fields
                window.transliterateAllFields = async function() {
                    const fields = document.querySelectorAll('.transliterate');
                    for (const field of fields) {
                        const wrapper = field.closest('.transliterate-wrapper');
                        if (wrapper) {
                            const btn = wrapper.querySelector('.transliterate-btn');
                            if (btn) {
                                await btn.click();
                                // Small delay between each conversion
                                await new Promise(resolve => setTimeout(resolve, 300));
                            }
                        }
                    }
                };

                console.log('Transliteration system loaded. Use Ctrl+Enter on any field to convert to Hindi.');
            });
        </script>

        <style>
            .text-danger {
                font-size: 12px;
                margin-top: 4px;
            }

            .form-control:focus {
                border-color: #80bdff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
            }

            .form-control.is-invalid {
                border-color: #dc3545;
            }

            .form-control.is-valid {
                border-color: #28a745;
            }

            /* Transliterate wrapper styles */
            .transliterate-wrapper {
                display: flex;
                gap: 5px;
                align-items: stretch;
                margin-bottom: 0;
            }

            .transliterate-wrapper .transliterate {
                flex: 1;
                border-radius: 4px 0 0 4px;
            }

            .transliterate-wrapper .transliterate-btn {
                border-radius: 0 4px 4px 0;
                white-space: nowrap;
                background-color: #f8f9fa;
                border: 1px solid #ced4da;
                border-left: none;
                font-size: 13px;
                padding: 0 12px;
                height: 38px;
                display: flex;
                align-items: center;
            }

            .transliterate-wrapper .transliterate-btn:hover {
                background-color: #e9ecef;
            }

            .transliterate-wrapper .transliterate-btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            .transliterate-status {
                font-size: 12px;
                margin-top: 4px;
            }

            .transliterate-hint {
                font-size: 11px;
                color: #17a2b8;
                margin-top: 2px;
            }

            /* Responsive */
            @media (max-width: 576px) {
                .transliterate-wrapper {
                    flex-wrap: wrap;
                }
                .transliterate-wrapper .transliterate {
                    flex: 1 1 100%;
                    border-radius: 4px;
                }
                .transliterate-wrapper .transliterate-btn {
                    border-radius: 4px;
                    border-left: 1px solid #ced4da;
                    width: 100%;
                    justify-content: center;
                    margin-top: 3px;
                }
            }
        </style>

    </section>

</main><!-- End #main -->
@endsection     