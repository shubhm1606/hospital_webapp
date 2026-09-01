// =============================================
// DYNAMIC URL CONFIGURATION
// =============================================
// Change this base URL to match your environment
const BASE_URL = window.location.origin + '/laravel_setup'; // For local development
// For production, you might use: const BASE_URL = 'https://yourdomain.com/api';
// Or detect dynamically: const BASE_URL = window.location.origin + '/your-project-folder';

// API Endpoints
const API_URLS = {
    SUBMIT: BASE_URL + '/fromsubmit',
    OPD_NUMBER: BASE_URL + '/Opdnumber',
    EMERGENCY: BASE_URL + '/emergency',
    PDF_DOWNLOAD: BASE_URL + '/pdfdownloade'
};

// =============================================
// HELPER FUNCTIONS
// =============================================

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

// Helper function to get CSRF token
function getCsrfToken() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const headers = {};
    if (csrfToken) {
        headers["X-CSRF-TOKEN"] = csrfToken.getAttribute("content");
    }
    return headers;
}

// Helper function to handle API responses
async function handleApiResponse(response) {
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    return await response.json();
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
// MAIN API FUNCTIONS
// =============================================

// Function to get OPD number
async function getOpdnumber() {
    showLoader();
    try {
        const response = await fetch(API_URLS.OPD_NUMBER, {
            method: "GET",
            headers: getCsrfToken()
        });

        const data = await handleApiResponse(response);

        if (data.status) {
            setElementValue('sr_no', data.data.serialnumber);
            setElementValue('opd_id', data.data.opdnumber);
            setElementValue('date', data.data.date);
            setElementValue('time', data.data.time);
            hideLoader();
        } else {
            showToast('error', "Error: " + data.message);
            hideLoader();
        }
    } catch (error) {
        console.error("Fetch Error:", error);
        showToast('error', "Failed to fetch OPD number");
        hideLoader();
    }
}

// Function to get emergency status
async function emergency() {
    showLoader();
    try {
        const response = await fetch(API_URLS.EMERGENCY, {
            method: "GET",
            headers: getCsrfToken()
        });

        const data = await handleApiResponse(response);

        if (data.status) {
            hideLoader();
            const emergencySelect = document.getElementById('emergency');
            if (emergencySelect) {
                emergencySelect.value = data.emergency;
            }
            return data.emergency;
        } else {
            showToast('error', "Error: " + data.message);
            hideLoader();
            return null;
        }
    } catch (error) {
        console.error("Error fetching emergency data:", error);
        showToast('error', "Failed to fetch emergency status");
        hideLoader();
        return null;
    }
}

// Function to test emergency status
function tuster() {
    fetch(API_URLS.EMERGENCY, {
        method: "GET",
        headers: getCsrfToken()
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            if (data.emergency == 'no') {
                showToast('info', "General Opd Working");
            } else {
                showToast('info', "Emergency Opd Working");
            }
        } else {
            showToast('error', "Error: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showToast('error', "Failed to check emergency status");
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
            
            // Create options more efficiently
            const freeOptions = [
                { value: "ayushman_card", label: "Aayushman Card" },
                { value: "delivery_case", label: "Delivery Case" },
                { value: "staff", label: "Staff" },
                { value: "108_ambulance", label: "108 Ambulance" },
                { value: "pensionar", label: "PENSIONAR" },
                { value: "anc_check-up", label: "ANC Check-up" },
                { value: "mlc", label: "MLC" },
                { value: "jsy_delivery_case", label: "JSY Delivery Case" },
                { value: "ltt_case", label: "LTT Case" },
                { value: "nrc_child", label: "NRC Child" },
                { value: "old_age_home", label: "OLD AGE HOME" },
                { value: "100_dial", label: "100 Dial" },
                { value: "baby_checkup", label: "BABY CHECKUP" },
                { value: "boys_girls_hostel", label: "BOYS & GIRLS HOSTEL" },
                { value: "t.b._medicine", label: "T.B. MEDICINE" },
                { value: "cardless_caseless", label: "CARDLESS / CASELESS" },
                { value: "janani_express", label: "Janani Express" }
            ];

            freeOptions.forEach(option => {
                newSelect.appendChild(new Option(option.label, option.value));
            });

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

// =============================================
// MAIN DOCUMENT READY HANDLER
// =============================================

document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM fully loaded and parsed");
    console.log("BASE_URL:", BASE_URL);
    console.log("API Endpoints:", API_URLS);
    
    // Initialize functions
    getOpdnumber();
    tuster();
   
    // Disable PDF button initially
    const pdfButton = document.getElementById("pdfButton");
    const submitForm = document.getElementById("submitdata");
    let savedEntryReadyForPrint = false;
    let formHasChanges = false;
    if (pdfButton) {
        pdfButton.disabled = true;
    }

    window.addEventListener('beforeunload', function (event) {
        if (savedEntryReadyForPrint || formHasChanges) {
            event.preventDefault();
            event.returnValue = '';
        }
    });

    if (submitForm) {
        submitForm.addEventListener('input', function () {
            formHasChanges = true;
        });
    }

    // =============================================
    // FORM SUBMISSION HANDLER
    // =============================================
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
                    formData.append("tags", "emergency");
                } else {
                    formData.append("tags", "general");
                }

                // Submit form data using dynamic URL
                fetch(API_URLS.SUBMIT, {
                    method: "POST",
                    headers: getCsrfToken(),
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        showToast('success', "Details submit Successfully");
                        submitForm.reset();
                        document.querySelectorAll('.text-danger').forEach(error => error.textContent = '');
                        if (pdfButton) {
                            pdfButton.disabled = false;
                        }
                        formHasChanges = false;
                        savedEntryReadyForPrint = true;
                        getOpdnumber();
                        hideLoader();
                    } else {
                        showToast('error', "Error: " + data.message);
                        hideLoader();
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    showToast('error', "Submission failed. Please try again.");
                    hideLoader();
                });
            }
        });
    }

    // =============================================
    // CHARGES DROPDOWN CHANGE HANDLER
    // =============================================
    const chargesSelect = document.getElementById('charges');
    if (chargesSelect) {
        chargesSelect.addEventListener('change', function () {
            chagersupdate(this.value);
        });
    }

    // =============================================
    // PDF BUTTON CLICK HANDLER
    // =============================================
    const pdfButtonClick = document.getElementById('pdfButton');
    if (pdfButtonClick) {
        pdfButtonClick.addEventListener('click', function () {
            showLoader();
            var pdfFrame = document.getElementById('pdfFrame');
            if (pdfFrame) {
                // Use dynamic URL for PDF download
                pdfFrame.src = API_URLS.PDF_DOWNLOAD;
                pdfFrame.onload = function () {
                    pdfFrame.contentWindow.onafterprint = function () {
                        formHasChanges = false;
                        savedEntryReadyForPrint = false;
                        
                    };
                    pdfFrame.contentWindow.print();
                    showToast('success', "Pdf Print Successfully");
                    hideLoader();
                };
                pdfFrame.onerror = function () {
                    showToast('error', "Failed to load PDF");
                    hideLoader();
                };
            } else {
                hideLoader();
                showToast('error', "PDF frame not found");
            }
        });
    }

    // =============================================
    // NEW ENTRY BUTTON HANDLER
    // =============================================
    const newEntryBtn = document.getElementById("newEntery");
    if (newEntryBtn) {
        newEntryBtn.addEventListener("click", function() {
            location.reload(); 
        });
    }
});

// =============================================
// EXPOSE FUNCTIONS FOR GLOBAL ACCESS (if needed)
// =============================================
window.setErrorMessage = setErrorMessage;
window.getElementValue = getElementValue;
window.setElementValue = setElementValue;
window.getOpdnumber = getOpdnumber;
window.chagersupdate = chagersupdate;
window.emergency = emergency;
window.tuster = tuster;
window.showLoader = showLoader;
window.hideLoader = hideLoader;
window.BASE_URL = BASE_URL;
window.API_URLS = API_URLS;