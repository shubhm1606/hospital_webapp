// =============================================
// DYNAMIC URL CONFIGURATION
// =============================================
// Change this base URL to match your environment
const BASE_URL = window.location.origin + '/laravel_setup'; // For local development
// For production, you might use: const BASE_URL = 'https://yourdomain.com/api';
// Or detect dynamically: const BASE_URL = window.location.origin + '/your-project-folder';

// API Endpoints
const API_URLS = {
    EXCEL_DATA: BASE_URL + '/exceldata',
    EXPORT_TO_PDF: BASE_URL + '/exportTopdf'
};

// =============================================
// HELPER FUNCTIONS
// =============================================

// Helper function to get CSRF token
function getCsrfToken() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    return csrfToken ? csrfToken.getAttribute('content') : '';
}

// Helper function to get CSRF headers
function getCsrfHeaders() {
    const headers = {};
    const token = getCsrfToken();
    if (token) {
        headers["X-CSRF-TOKEN"] = token;
    }
    return headers;
}

// Helper function to get JSON headers with CSRF
function getJsonCsrfHeaders() {
    const headers = {
        "Content-Type": "application/json"
    };
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
// MAIN CODE - jQuery and Vanilla JS
// =============================================

// jQuery code for modal and datepicker
$(document).on('click', '[data-bs-toggle="modal"]', function () {
    var target = $(this).data('bs-target');
    $(target).modal('show');
});

$(document).ready(function () {
    $('#startingdate').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });
});

// Vanilla JS for main functionality
document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM fully loaded and parsed");
    console.log("BASE_URL:", BASE_URL);
    console.log("API Endpoints:", API_URLS);
    
    document.getElementById("exportToExcel").disabled = true;
    document.getElementById("exportToPdf").disabled = true;
    
    const form = document.getElementById('record_filter');
    const tableBody = document.querySelector('#filter_records tbody');
    const exportButtons = document.getElementById("export-buttons");

    // =============================================
    // FORM SUBMIT HANDLER
    // =============================================
    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const startingDate = document.getElementById('startingdate').value;
        const endDate = document.getElementById('enddate').value;

        // Validate dates
        if (!startingDate || !endDate) {
            showToast('error', 'Please fill in both dates.');
            return;
        }

        // Convert dd-mm-yyyy to yyyy-mm-dd for comparison
        function parseDate(dateStr) {
            const parts = dateStr.split('-');
            return new Date(parts[2], parts[1] - 1, parts[0]);
        }

        const start = parseDate(startingDate);
        const end = parseDate(endDate);

        if (start > end) {
            showToast('error', 'Start date cannot be later than end date.');
            return;
        }

        // Show loader
        showLoader();

        const formData = new FormData();
        formData.append('starting_date', startingDate);
        formData.append('end_date', endDate);

        try {
            const response = await fetch(API_URLS.EXCEL_DATA, {
                method: 'POST',
                body: formData,
                headers: getCsrfHeaders()
            });

            if (!response.ok) {
                throw new Error(`HTTP Error! Status: ${response.status}`);
            }

            const result = await response.json();

            if (result.data && result.data.length > 0) {
                showToast('success', 'Form submitted successfully!');
                console.log('Data received:', result.data);

                tableBody.innerHTML = "";

                let totalOpdFree = 0, totalOpdPaid = 0, totalOpdAmount = 0;
                let totalemrOpdFree = 0, totalemrOpdPaid = 0, totalemrOpdAmount = 0;
                let totalIpdFree = 0, totalIpdPaid = 0, totalIpdAmount = 0;
                let grandTotalPatients = 0, grandTotalAmount = 0;

                result.data.forEach(row => {
                    let opdFree = Number(row.opd_free_count) || 0;
                    let opdPaid = Number(row.opd_paid_count) || 0;
                    let opdAmount = Number(row.opd_total_amount) || 0;

                    let emropdFree = Number(row.em_opd_free_count) || 0;
                    let emropdPaid = Number(row.em_opd_paid_count) || 0;
                    let emropdAmount = Number(row.em_opd_total_amount) || 0;

                    let ipdFree = Number(row.ipd_free_count) || 0;
                    let ipdPaid = Number(row.ipd_paid_count) || 0;
                    let ipdAmount = Number(row.ipd_total_amount) || 0;

                    let totalPatients = opdFree + opdPaid + ipdFree + ipdPaid + emropdFree + emropdPaid;
                    let totalAmount = opdAmount + ipdAmount + emropdAmount;

                    totalOpdFree += opdFree;
                    totalOpdPaid += opdPaid;
                    totalOpdAmount += opdAmount;

                    totalemrOpdFree += emropdFree;
                    totalemrOpdPaid += emropdPaid;
                    totalemrOpdAmount += emropdAmount;

                    totalIpdFree += ipdFree;
                    totalIpdPaid += ipdPaid;
                    totalIpdAmount += ipdAmount;

                    grandTotalPatients += totalPatients;
                    grandTotalAmount += totalAmount;

                    const newRow = `
                        <tr>
                            <td>${row.date || ''}</td>
                            <td>${opdFree}</td>
                            <td>${opdPaid}</td>
                            <td>${opdAmount}</td>
                            <td>${emropdFree}</td>
                            <td>${emropdPaid}</td>
                            <td>${emropdAmount}</td>
                            <td>${opdFree + opdPaid + emropdFree + emropdPaid}</td>
                            <td>${opdAmount + emropdAmount}</td>
                            <td>${ipdFree}</td>
                            <td>${ipdPaid}</td>
                            <td>${ipdFree + ipdPaid}</td>
                            <td>${ipdAmount}</td>
                            <td>-</td><td>-</td><td>-</td><td>-</td>
                            <td>-</td><td>-</td><td>-</td><td>-</td>
                            <td>${totalPatients}</td>
                            <td>${totalAmount}</td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', newRow);
                });

                // Add footer row with totals
                const footerRow = `
                    <tr style="font-weight: bold; background: #f2f2f2;">
                        <td>Total</td>
                        <td>${totalOpdFree}</td>
                        <td>${totalOpdPaid}</td>
                        <td>${totalOpdAmount}</td>
                        <td>${totalemrOpdFree}</td>
                        <td>${totalemrOpdPaid}</td>
                        <td>${totalemrOpdAmount}</td>
                        <td>${totalOpdFree + totalOpdPaid + totalemrOpdPaid + totalemrOpdFree}</td>
                        <td>${totalOpdAmount + totalemrOpdAmount}</td>
                        <td>${totalIpdFree}</td>
                        <td>${totalIpdPaid}</td>
                        <td>${totalIpdFree + totalIpdPaid}</td>
                        <td>${totalIpdAmount}</td>
                        <td>-</td><td>-</td><td>-</td><td>-</td>
                        <td>-</td><td>-</td><td>-</td><td>-</td>
                        <td>${grandTotalPatients}</td>
                        <td>${grandTotalAmount}</td>
                    </tr>
                `;

                tableBody.insertAdjacentHTML('beforeend', footerRow);

                // Store dates for export
                document.getElementById("startdate").value = startingDate;
                document.getElementById("endingdate").value = endDate;

                // Enable export buttons
                document.getElementById("exportToExcel").disabled = false;
                document.getElementById("exportToPdf").disabled = false;
                exportButtons.style.display = "block";

                hideLoader();

            } else {
                showToast('error', 'No data found for the selected date range.');
                tableBody.innerHTML = "";
                exportButtons.style.display = "none";
                hideLoader();
            }

        } catch (error) {
            console.error('Error submitting form:', error);
            showToast('error', 'An error occurred while submitting the form.');
            hideLoader();
        }
    });
});

// =============================================
// EXPORT FUNCTIONS
// =============================================

function exportToExcel() {
    showToast('info', 'Exporting to Excel...');
    // Add your Excel export logic here
    // You can use the same API endpoint or a different one
    showToast('success', 'Excel export functionality triggered');
}

function exportToPdf() {
    let startData = document.getElementById('startdate').value;
    let endData = document.getElementById('endingdate').value;
    
    if (!startData || !endData) {
        showToast('error', 'Please select dates first.');
        return;
    }
    
    showLoader();
    
    let data = { startData, endData };

    fetch(API_URLS.EXPORT_TO_PDF, {
        method: "POST",
        headers: getJsonCsrfHeaders(),
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP Error! Status: ${response.status}`);
        }
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `report_${startData}_to_${endData}.pdf`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
        showToast('success', 'PDF downloaded successfully!');
        hideLoader();
    })
    .catch(error => {
        console.error("Error:", error);
        showToast('error', 'Failed to download PDF. Please try again.');
        hideLoader();
    });
}

// =============================================
// EXPOSE FUNCTIONS FOR GLOBAL ACCESS
// =============================================
window.exportToExcel = exportToExcel;
window.exportToPdf = exportToPdf;
window.showLoader = showLoader;
window.hideLoader = hideLoader;
window.getCsrfToken = getCsrfToken;
window.getCsrfHeaders = getCsrfHeaders;
window.getJsonCsrfHeaders = getJsonCsrfHeaders;
window.showToast = showToast;
window.BASE_URL = BASE_URL;
window.API_URLS = API_URLS;