// =============================================
// DYNAMIC URL CONFIGURATION
// =============================================
// Change this base URL to match your environment
const BASE_URL = window.location.origin + '/laravel_setup'; // For local development
// For production, you might use: const BASE_URL = 'https://yourdomain.com/api';
// Or detect dynamically: const BASE_URL = window.location.origin + '/your-project-folder';

// API Endpoints
const API_URLS = {
    IPD_FORM_SUBMIT: BASE_URL + '/ipdformsubmit',
    IPD_DETAILS_SUBMIT: BASE_URL + '/ipddetailssubmit',
    GET_IPD_NUMBER: BASE_URL + '/getIpdnumber',
    IPD_PDF_DOWNLOAD: BASE_URL + '/ipdpdfdownlode'
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
    return csrfToken ? csrfToken.getAttribute("content") : '';
}

// Helper function to get CSRF headers
function getCsrfHeaders() {
    const headers = {
        "Content-Type": "application/json"
    };
    const token = getCsrfToken();
    if (token) {
        headers["X-CSRF-TOKEN"] = token;
    }
    return headers;
}

// Helper function to get FormData CSRF headers
function getFormDataCsrfHeaders() {
    const headers = {};
    const token = getCsrfToken();
    if (token) {
        headers["X-CSRF-TOKEN"] = token;
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

function getIpdnumber() {
    showLoader();
    fetch(API_URLS.GET_IPD_NUMBER, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": getCsrfToken()
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            document.getElementById('sr_no').value = data.data.serialnumber;
            document.getElementById('ipd').value = data.data.opdnumber;
            // document.getElementById('date').value = data.data.date;
            // document.getElementById('time').value = data.data.time;
            hideLoader();
        } else {
            showToast('error', "Error: " + data.message);
            hideLoader();
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        showToast('error', "Failed to fetch IPD number");
        hideLoader();
    });
}

// =============================================
// MAIN DOCUMENT READY HANDLER
// =============================================

document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM fully loaded and parsed");
    console.log("BASE_URL:", BASE_URL);
    console.log("API Endpoints:", API_URLS);
    
    let savedEntryReadyForPrint = false;
    let formHasChanges = false;
    getIpdnumber();
    
    // Search OPD ID and Populate Fields
    document.getElementById("pdfprint").disabled = true;
    document.getElementById("submitBtn").disabled = true;

    window.addEventListener('beforeunload', function (event) {
        if (savedEntryReadyForPrint || formHasChanges) {
            event.preventDefault();
            event.returnValue = '';
        }
    });

    document.getElementById('ipdFromsubmit').addEventListener('input', function () {
        formHasChanges = true;
    });

    // =============================================
    // OPD ID CHANGE HANDLER - FETCH PATIENT DETAILS
    // =============================================
    document.getElementById('opd_id').addEventListener("change", function (e) {
        e.preventDefault();
        let id = document.getElementById("opd_id").value;

        if (!id) {
            showToast('warning', "Please enter a valid OPD ID.");
            return;
        }

        showLoader();

        fetch(API_URLS.IPD_FORM_SUBMIT, {
            method: "POST",
            headers: getCsrfHeaders(),
            body: JSON.stringify({ opd_id: id }) // Send OPD ID as JSON
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                document.getElementById("submitBtn").disabled = false;
                // console.log('Data received:', data.data);

                // Populate form fields with received data
                document.getElementById('patient_name').value = data.data.pesientname || '';
                document.getElementById('gender').value = data.data.gender || '';
                document.getElementById('age').value = data.data.age || '';
                document.getElementById('days').value = data.data.ymd || '';
                document.getElementById('father_husband_name').value = data.data.fatherhusband || '';
                document.getElementById('date').value = data.data.pdate || '';
                document.getElementById('address').value = data.data.address || '';
                document.getElementById('mlc_pmlc').value = data.data.mlc_pmlc || '';
                // document.getElementById('charges').value = data.data.charges || '';
                // document.getElementById('charge_amount').value = data.data.charge_amount || 30;
                document.getElementById('opdamount').value = data.data.chargesamount || '';
                document.getElementById('opd_id').value = data.data.opdId || '';

                showToast('success', "Details Fetch Successfully");
                hideLoader();
            } else {
                showToast('error', "Error: " + data.message);
                hideLoader();
            }
        })
        .catch(error => {
            console.error("Error fetching data:", error);
            showToast('error', "Failed to fetch patient details");
            hideLoader();
        });

        // console.log("OPD ID Submitted:", id);
    });

    // =============================================
    // SUBMIT BUTTON HANDLER
    // =============================================
    document.getElementById("submitBtn").addEventListener("click", function (e) {
        e.preventDefault(); // Prevent default form submission

        let selectedDoctor = document.getElementById("refDr").value;
        let wardnumber = document.getElementById("wardnumber").value;
        let wardType = document.getElementById("wardType").value;
        let charges = document.getElementById("charges").value;
        let checkemptyfrom = true;

        // Validate Refer Doctor
        if (selectedDoctor === '') {
            checkemptyfrom = false;
            let doctorErr = document.getElementsByClassName('doctorErr')[0];
            if (doctorErr) {
                doctorErr.innerHTML = 'Select Refer Doctor';
                doctorErr.style.color = 'red';
            }
        } else {
            let doctorErr = document.getElementsByClassName('doctorErr')[0];
            if (doctorErr) {
                doctorErr.innerHTML = '';
            }
        }

        // Validate Ward Number
        if (wardnumber === '') {
            checkemptyfrom = false;
            let wordnumberErr = document.getElementsByClassName('wordnumberErr')[0];
            if (wordnumberErr) {
                wordnumberErr.innerHTML = 'Enter a word number';
                wordnumberErr.style.color = 'red';
            }
        } else {
            let wordnumberErr = document.getElementsByClassName('wordnumberErr')[0];
            if (wordnumberErr) {
                wordnumberErr.innerHTML = '';
            }
        }

        // Validate Ward Type
        if (wardType === '') {
            checkemptyfrom = false;
            let wordtypeErr = document.getElementsByClassName('wordtypeErr')[0];
            if (wordtypeErr) {
                wordtypeErr.innerHTML = 'Select Word type';
                wordtypeErr.style.color = 'red';
            }
        } else {
            let wordtypeErr = document.getElementsByClassName('wordtypeErr')[0];
            if (wordtypeErr) {
                wordtypeErr.innerHTML = '';
            }
        }

        // Validate Charges
        if (charges === '') {
            checkemptyfrom = false;
            let chanrgetypeErr = document.getElementsByClassName('chanrgetypeErr')[0];
            if (chanrgetypeErr) {
                chanrgetypeErr.innerHTML = 'Select Charges type';
                chanrgetypeErr.style.color = 'red';
            }
        } else {
            let chanrgetypeErr = document.getElementsByClassName('chanrgetypeErr')[0];
            if (chanrgetypeErr) {
                chanrgetypeErr.innerHTML = '';
            }
        }

        if (checkemptyfrom) {
            let form = document.getElementById("ipdFromsubmit");
            let formData = new FormData(form);
            formData.append("sr_no", document.getElementById("sr_no").value);
            formData.append("ipdNumber", document.getElementById("ipd").value);
            formData.append("chaegesAmount", document.getElementById("charge_amount").value);
            formData.append("opdAmount", document.getElementById("opdamount").value);
            // console.log('FromData', formData);
            showLoader();

            fetch(API_URLS.IPD_DETAILS_SUBMIT, {
                method: "POST",
                headers: getFormDataCsrfHeaders(),
                body: formData // Send entire form data
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showToast('success', "Details Submit Successfully");
                    // console.log('Response:', data);
                    document.getElementById("pdfprint").disabled = false;
                    formHasChanges = false;
                    savedEntryReadyForPrint = true;
                    document.getElementById("ipdFromsubmit").reset();
                    document.querySelectorAll('.doctorErr, .wordnumberErr, .wordtypeErr, .chanrgetypeErr')
                        .forEach(error => error.textContent = '');
                    getIpdnumber();
                } else {
                    showToast('error', "Submission failed: " + data.message);
                }
                hideLoader();
            })
            .catch(error => {
                console.error("Error submitting form:", error);
                showToast('error', "Failed to submit details");
                hideLoader();
            });
        }
    });

    // =============================================
    // PDF PRINT BUTTON HANDLER
    // =============================================
    document.getElementById("pdfprint").addEventListener("click", function (e) {
        e.preventDefault(); // Prevent default form submission
        showLoader();
        
        var pdfFrame = document.getElementById('pdfFrame');
        if (pdfFrame) {
            pdfFrame.src = API_URLS.IPD_PDF_DOWNLOAD;
            pdfFrame.onload = function () {
                pdfFrame.contentWindow.onafterprint = function () {
                    formHasChanges = false;
                    savedEntryReadyForPrint = false;
                    window.location.reload();
                };
                pdfFrame.contentWindow.print();
                // setTimeout(function () {
                //     window.location.reload();
                // }, 500);
                showToast('success', "Pdf Print Successfully");
                hideLoader();
            };
            pdfFrame.onerror = function () {
                showToast('error', "Failed to load PDF");
                hideLoader();
            };
        } else {
            showToast('error', "PDF frame not found");
            hideLoader();
        }
    });

    // =============================================
    // CHARGES DROPDOWN CHANGE HANDLER
    // =============================================
    document.getElementById("charges").addEventListener("change", function (e) {
        let $value = document.getElementById("charges").value;
        if ($value == '') {
            // Do nothing
        } else if ($value == 'PAID') {
            document.getElementById('charge_amount').value = 30 || 30;
        } else if ($value == 'FREE') {
            document.getElementById('charge_amount').value = 0 || 0;
        }
    });

});

// =============================================
// EXPOSE FUNCTIONS FOR GLOBAL ACCESS (if needed)
// =============================================
window.getElementValue = getElementValue;
window.setElementValue = setElementValue;
window.getIpdnumber = getIpdnumber;
window.showLoader = showLoader;
window.hideLoader = hideLoader;
window.getCsrfToken = getCsrfToken;
window.getCsrfHeaders = getCsrfHeaders;
window.getFormDataCsrfHeaders = getFormDataCsrfHeaders;
window.showToast = showToast;
window.BASE_URL = BASE_URL;
window.API_URLS = API_URLS;