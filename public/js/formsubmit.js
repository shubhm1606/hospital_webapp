// Helper function to safely set error messages
function setErrorMessage(className, message, color = 'red') {
    const elements = document.getElementsByClassName(className);
    if (elements && elements.length > 0) {
        const element = elements[0];
        element.innerHTML = message;
        if (message) {
            element.style.color = color;
        }
    }
}

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

document.addEventListener("DOMContentLoaded", function () {
    // Initialize functions
    getOpdnumber();
    tuster();
   
    // Disable PDF button initially
    const pdfButton = document.getElementById("pdfButton");
    if (pdfButton) {
        pdfButton.disabled = true;
    }

    // Form submission handler
    const submitForm = document.getElementById("submitdata");
    console.log("submitForm:", submitForm);
    if (submitForm) {
        console.log("Form submit event listener added.");
        submitForm.addEventListener("submit", function (e) {
            e.preventDefault();
            
            // Get form values safely
            let name = getElementValue("patient_name");
            let gender = getElementValue("gender");
            let age = getElementValue("age");
            let disease = getElementValue("disease");
            let chargeType = getElementValue("charges");
            let emergency = getElementValue("emergency");
            let checkdetails = true;

            // Validate Name
            if (name === '') {
                checkdetails = false;
                setErrorMessage('nameErr', 'Please Fill This Field');
            } else {
                setErrorMessage('nameErr', '');
            }   

            // Validate Gender
            if (gender === '') {
                checkdetails = false;
                setErrorMessage('genderErr', 'Please Select This Field');
            } else {
                setErrorMessage('genderErr', '');
            }

            // Validate Age
            if (age === '') {
                checkdetails = false;
                setErrorMessage('ageErr', 'Please Select This Field');
            } else {
                setErrorMessage('ageErr', '');
            }

            // Validate Disease
            if (disease === '') {
                checkdetails = false;
                setErrorMessage('diseaseErr', 'Please Select This Field');
            } else {
                setErrorMessage('diseaseErr', '');
            }

            // Validate Charge Type
            if (chargeType === '') {
                checkdetails = false;
                setErrorMessage('chargetypeErr', 'Please Select This Field');
            } else {
                setErrorMessage('chargetypeErr', '');
            }

            // If all validations pass
            if (checkdetails) {
                showLoader();
                let formData = new FormData(this);
                
                // Append all form data safely
                const srNo = document.getElementById("sr_no");
                const opdId = document.getElementById("opd_id");
                const date = document.getElementById("date");
                const time = document.getElementById("time");
                const chargeAmount = document.getElementById("charge_amount");
                
                if (srNo) formData.append("serialnumber", srNo.value);
                if (opdId) formData.append("opd_id", opdId.value);
                if (date) formData.append("date", date.value);
                if (time) formData.append("time", time.value);
                if (chargeAmount) formData.append("charge_amount", chargeAmount.value);
                
                if (emergency == 'yes') {
                    formData.append("tags", 'emergency');
                } else {
                    formData.append("tags", 'general');
                }

                // Get CSRF token safely
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                const headers = {};
                if (csrfToken) {
                    headers["X-CSRF-TOKEN"] = csrfToken.getAttribute("content");
                }

                // Submit form data
                fetch("http://localhost/laravel_setup/fromsubmit", {
                    method: "POST",
                    headers: headers,
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        if (typeof toastr !== 'undefined') {
                            toastr.success("Details submit Successfully");
                        }
                        if (pdfButton) {
                            pdfButton.disabled = false;
                        }
                        hideLoader();
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error("Error: " + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    if (typeof toastr !== 'undefined') {
                        toastr.error("Submission failed. Please try again.");
                    }
                    hideLoader();
                });
            }
        });
    }

    // Charges dropdown change handler
    const chargesSelect = document.getElementById('charges');
    if (chargesSelect) {
        chargesSelect.addEventListener('change', function () {
            chagersupdate(this.value);
        });
    }

    // PDF Button click handler
    const pdfButtonClick = document.getElementById('pdfButton');
    if (pdfButtonClick) {
        pdfButtonClick.addEventListener('click', function () {
            showLoader();
            var pdfFrame = document.getElementById('pdfFrame');
            if (pdfFrame) {
                pdfFrame.src = "http://localhost/laravel_setup/pdfdownloade";
                pdfFrame.onload = function () {
                    pdfFrame.contentWindow.print();
                    if (typeof toastr !== 'undefined') {
                        toastr.success("Pdf Print Successfully");
                    }
                    hideLoader();
                };
                pdfFrame.onerror = function () {
                    if (typeof toastr !== 'undefined') {
                        toastr.error("Failed to load PDF");
                    }
                    hideLoader();
                };
            } else {
                hideLoader();
                if (typeof toastr !== 'undefined') {
                    toastr.error("PDF frame not found");
                }
            }
        });
    }

    // New Entry button handler
    const newEntryBtn = document.getElementById("newEntery");
    if (newEntryBtn) {
        newEntryBtn.addEventListener("click", function() {
            location.reload(); 
        });
    }
});

// Function to get OPD number
function getOpdnumber() {
    showLoader();
    fetch("http://localhost/laravel_setup/Opdnumber", {
        method: "GET"
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            setElementValue('sr_no', data.data.serialnumber);
            setElementValue('opd_id', data.data.opdnumber);
            setElementValue('date', data.data.date);
            setElementValue('time', data.data.time);
            hideLoader();
        } else {
            if (typeof toastr !== 'undefined') {
                toastr.error("Error: " + data.message);
            }
            hideLoader();
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        if (typeof toastr !== 'undefined') {
            toastr.error("Failed to fetch OPD number");
        }
        hideLoader();
    });
}

// Function to update charges
function chagersupdate(chargeType) {
    if (chargeType === 'PAID') {
        let container = document.getElementById("freeoption");
        if (container) {
            container.innerHTML = "";
        }
        emergency().then(emergencyValue => {
            console.log("Emergency Value:", emergencyValue);
            if (emergencyValue == 'yes') {
                setElementValue('charge_amount', '30.00');
            } else {
                setElementValue('charge_amount', '10.00');
            }
        });
    } else if (chargeType === 'FREE') {
        emergency().then(emergencyValue => {
            console.log("Emergency Value:", emergencyValue);
            setElementValue('charge_amount', '0');
        });
        
        let container = document.getElementById("freeoption");
        if (container) {
            container.innerHTML = "";

            let newSelect = document.createElement("select");
            newSelect.name = "free_option";
            newSelect.id = "free_option";
            newSelect.className = "form-control";
            
            let option1 = new Option("Aayushman Card", "ayushman_card");
            let option2 = new Option("Delivery Case", "delivery_case");
            let option3 = new Option("Staff", "staff");
            let option4 = new Option("108 Ambulance", "108_ambulance");
            let option5 = new Option("PENSIONAR", "pensionar");
            let option6 = new Option("ANC Check-up", "anc_check-up");
            let option7 = new Option("MLC", "mlc");
            let option8 = new Option("JSY Delivery Case", "jsy_delivery_case");
            let option9 = new Option("LTT Case", "ltt_case");
            let option10 = new Option("NRC Child", "nrc_child");
            let option11 = new Option("OLD AGE HOME", "old_age_home");
            let option12 = new Option("100 Dial", "100_dial");
            let option13 = new Option("BABY CHECKUP", "baby_checkup");
            let option14 = new Option("BOYS & GIRLS HOSTEL", "boys_girls_hostel");
            let option15 = new Option("T.B. MEDICINE", "t.b._medicine");
            let option16 = new Option("CARDLESS / CASELESS", "cardless_caseless");
            let option17 = new Option("Janani Express", "janani_express");
            let option18 = new Option("Staff", "staff");


            newSelect.appendChild(option1);
            newSelect.appendChild(option2);
            newSelect.appendChild(option3);
            newSelect.appendChild(option4);
            newSelect.appendChild(option5);
            newSelect.appendChild(option6);
            newSelect.appendChild(option7);
            newSelect.appendChild(option8);
            newSelect.appendChild(option9);
            newSelect.appendChild(option10);
            newSelect.appendChild(option11);
            newSelect.appendChild(option12);
            newSelect.appendChild(option13);
            newSelect.appendChild(option14);
            newSelect.appendChild(option15);
            newSelect.appendChild(option16);
            newSelect.appendChild(option17);
            newSelect.appendChild(option18);

            let label = document.createElement("label");
            label.innerText = "Option:";
            
            let div = document.createElement("div");
            div.className = "form-group";
            div.appendChild(label);
            div.appendChild(newSelect);

            container.appendChild(div);
            setElementValue('charge_amount', '0.00');
        }
    } else {
        setElementValue('charge_amount', '');
    }
}

// Function to get emergency status
async function emergency() {
    showLoader();
    try {
        let response = await fetch("http://localhost/laravel_setup/emergency", {
            method: "GET"
        });

        let data = await response.json();

        if (data.status) {
            hideLoader();
            const emergencySelect = document.getElementById('emergency');
            if (emergencySelect) {
                emergencySelect.value = data.emergency;
            }
            return data.emergency;
        } else {
            if (typeof toastr !== 'undefined') {
                toastr.error("Error: " + data.message);
            }
            hideLoader();
            return null;
        }
    } catch (error) {
        console.error("Error fetching emergency data:", error);
        if (typeof toastr !== 'undefined') {
            toastr.error("Failed to fetch emergency status");
        }
        hideLoader();
        return null;
    }
}

// Function to test emergency status
function tuster() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const headers = {};
    if (csrfToken) {
        headers["X-CSRF-TOKEN"] = csrfToken.getAttribute("content");
    }

    fetch("http://localhost/laravel_setup/emergency", {
        method: "GET",
        headers: headers
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            if (typeof toastr !== 'undefined') {
                if (data.emergency == 'no') {
                    toastr.info("General Opd Working");
                } else {
                    toastr.info("Emergency Opd Working");
                }
            }
        } else {
            if (typeof toastr !== 'undefined') {
                toastr.error("Error: " + data.message);
            }
        }
    })
    .catch(error => {
        console.error("Error:", error);
        if (typeof toastr !== 'undefined') {
            toastr.error("Failed to check emergency status");
        }
    });
}

// Loader functions
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