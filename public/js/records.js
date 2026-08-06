
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


document.addEventListener('DOMContentLoaded', function () {
    document.getElementById("exportToExcel").disabled = true;
    document.getElementById("exportToPdf").disabled = true;
    const form = document.getElementById('record_filter');
    const tableBody = document.querySelector('#filter_records tbody');
    const exportButtons = document.getElementById("export-buttons");

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const startingDate = document.getElementById('startingdate').value;
        const endDate = document.getElementById('enddate').value;

        if (!startingDate || !endDate) {
            toastr.error('Please fill in both dates.');
            // alert('Please fill in both dates.');
            return;
        }

        if (new Date(startingDate) > new Date(endDate)) {
            toastr.error('Start date cannot be later than end date.');
            // alert('Start date cannot be later than end date.');
            return;
        }

        const formData = new FormData();
        formData.append('starting_date', startingDate);
        formData.append('end_date', endDate);

        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

        try {
            const response = await fetch('http://localhost/laravel_setup/exceldata', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP Error! Status: ${response.status}`);
            }

            const result = await response.json();

            if (result.data && result.data.length > 0) {
                toastr.success('Form submitted successfully!');
                // alert;
                console.log('Data received:', result.data);

                tableBody.innerHTML = "";

                let totalOpdFree = 0, totalOpdPaid = 0, totalOpdAmount = 0;
                let totalemrOpdFree = 0, totalemrOpdPaid = 0, totalemrOpdAmount = 0;
                let totalIpdFree = 0, totalIpdPaid = 0, totalIpdAmount = 0;
                let grandTotalPatients = 0, grandTotalAmount = 0;

                result.data.forEach(row => {
                    let opdFree = Number(row.opd_free_count);
                    let opdPaid = Number(row.opd_paid_count);
                    let opdAmount = Number(row.opd_total_amount);

                    let emropdFree = Number(row.em_opd_free_count);
                    let emropdPaid = Number(row.em_opd_paid_count);
                    let emropdAmount = Number(row.em_opd_total_amount);

                    let ipdFree = Number(row.ipd_free_count);
                    let ipdPaid = Number(row.ipd_paid_count);
                    let ipdAmount = Number(row.ipd_total_amount);

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
                            <td>${row.date}</td>
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

                const footerRow = `
                    <tr style="font-weight: bold; background: #f2f2f2;">
                        <td>Total</td>
                        <td>${totalOpdFree}</td>
                        <td>${totalOpdPaid}</td>
                        <td>${totalOpdAmount}</td>

                        <td>${totalemrOpdFree}</td>
                        <td>${totalemrOpdPaid}</td>
                        <td>${totalemrOpdAmount}</td>
                        
                        <td>${totalOpdFree + totalOpdPaid  + totalemrOpdPaid + totalemrOpdFree}</td>
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

                document.getElementById("startdate").value = startingDate;
                document.getElementById("endingdate").value = endDate;

                document.getElementById("exportToExcel").disabled = false;
                document.getElementById("exportToPdf").disabled = false;
                exportButtons.style.display = "block";

            } else {
                toastr.error(('No data found for the selected date range.'));
                // alert('No data found for the selected date range.');
                tableBody.innerHTML = "";
                exportButtons.style.display = "none";
            }

        } catch (error) {
            console.error('Error submitting form:', error);
            alert('An error occurred while submitting the form.');
        }
    });
});



function exportToExcel() {
    alert('excel')
}

function exportToPdf() {
    let startData = document.getElementById('startdate').value;
    let endData = document.getElementById('endingdate').value;
    let data = { startData, endData };

    fetch("http://localhost/laravel_setup/exportTopdf", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify(data)
    })
        .then(response => response.blob()) 
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            window.location.href = url; 
        })
        .catch(error => console.error("Error:", error));

}

