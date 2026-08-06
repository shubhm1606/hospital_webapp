document.addEventListener("DOMContentLoaded", function () {
    getIpdnumber();
    // Search OPD ID and Populate Fields
    document.getElementById("pdfprint").disabled = true;
    document.getElementById("submitBtn").disabled = true;

    document.getElementById('opd_id').addEventListener("change", function (e) {
        e.preventDefault();
        let id = document.getElementById("opd_id").value;

        if (!id) {
            alert("Please enter a valid OPD ID.");
            return;
        }

        showLoader();

        fetch("http://localhost/laravel_setup/ipdformsubmit", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Content-Type": "application/json"
            },
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

                    toastr.success("Details Fetch Successfully");

                    hideLoader();
                } else {
                    toastr.error("Error: " + data.message);
                    hideLoader();
                }
            })
            .catch(error => {
                console.error("Error fetching data:", error);
                hideLoader();
            });

        // console.log("OPD ID Submitted:", id);
    });

    document.getElementById("submitBtn").addEventListener("click", function (e) {
        e.preventDefault(); // Prevent default form submission

        let selectedDoctor = document.getElementById("refDr").value;
        let wardnumber = document.getElementById("wardnumber").value;
        let wardType = document.getElementById("wardType").value;
        let charges = document.getElementById("charges").value;
        let checkemptyfrom = true;

        if (selectedDoctor === '') {
            checkemptyfrom = false;
            let doctorErr = document.getElementsByClassName('doctorErr')[0];
            doctorErr.innerHTML = 'Select Refer Doctor';
            doctorErr.style.color = 'red';
        } else {
            let doctorErr = document.getElementsByClassName('doctorErr')[0];
            doctorErr.innerHTML = '';
        }

        if (wardnumber === '') {
            checkemptyfrom = false;
            let wordnumberErr = document.getElementsByClassName('wordnumberErr')[0];
            wordnumberErr.innerHTML = 'Enter a word number';
            wordnumberErr.style.color = 'red';
        } else {
            let wordnumberErr = document.getElementsByClassName('wordnumberErr')[0];
            wordnumberErr.innerHTML = '';
        }

        if (wardType === '') {
            checkemptyfrom = false;
            let wordtypeErr = document.getElementsByClassName('wordtypeErr')[0];
            wordtypeErr.innerHTML = 'Select Word type';
            wordtypeErr.style.color = 'red';
        } else {
            let wordtypeErr = document.getElementsByClassName('wordtypeErr')[0];
            wordtypeErr.innerHTML = '';
        }

        if (charges === '') {
            checkemptyfrom = false;
            let chanrgetypeErr = document.getElementsByClassName('chanrgetypeErr')[0];
            chanrgetypeErr.innerHTML = 'Select Charges type';
            chanrgetypeErr.style.color = 'red';
        } else {
            let chanrgetypeErr = document.getElementsByClassName('chanrgetypeErr')[0];
            chanrgetypeErr.innerHTML = '';
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

            fetch("http://localhost/laravel_setup/ipddetailssubmit", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: formData // Send entire form data
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        toastr.success("Details Submit Successfully");
                        // console.log('Response:', data);
                        document.getElementById("pdfprint").disabled = false;
                    } else {
                        toastr.error("Submission failed: " + data.message);
                    }
                    hideLoader();
                })
                .catch(error => {
                    console.error("Error submitting form:", error);
                    hideLoader();
                });
        }
    });


    document.getElementById("pdfprint").addEventListener("click", function (e) {

        e.preventDefault(); // Prevent default form submission
        var pdfFrame = document.getElementById('pdfFrame');
        pdfFrame.src = "http://localhost/laravel_setup/ipdpdfdownlode";
        pdfFrame.onload = function () {
            pdfFrame.contentWindow.print();
            // setTimeout(function () {
            //     window.location.reload();
            // }, 500);
            toastr.success("Pdf Print Successfully");
            hideLoader();
        };
    });

    document.getElementById("charges").addEventListener("change", function (e) {
        $value = document.getElementById("charges").value;
        if ($value == '') {
        } else if ($value == 'PAID') {
            document.getElementById('charge_amount').value = 30 || 30;
        } else if ($value == 'FREE') {
            document.getElementById('charge_amount').value = 0 || 0;
        }
    });

});

function getIpdnumber() {
    showLoader();
    fetch("http://localhost/laravel_setup/getIpdnumber", {
        method: "GET"
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
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error("Fetch Error:", error));
}

// Show and Hide Loader Functions
function showLoader() {
    document.getElementById('preloader').style.display = 'block';
}

function hideLoader() {
    document.getElementById('preloader').style.display = 'none';
}
