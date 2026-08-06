document.addEventListener("DOMContentLoaded", function () {
    getOpdnumber();
    tuster();
   

    document.getElementById("pdfButton").disabled = true;

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
                    toastr.success("Details submit Successfully");

                    document.getElementById("pdfButton").disabled = false;
                    hideLoader();
                } else {
                    toastr.error("Error: " + data.message);
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });

    document.getElementById('charges').addEventListener('change', function () {
        chagersupdate(this.value);
    });

    document.getElementById('pdfButton').addEventListener('click', function () {
        showLoader();
        var pdfFrame = document.getElementById('pdfFrame');
        pdfFrame.src = "http://localhost/laravel_setup/pdfdownloade";
        pdfFrame.onload = function () {
            pdfFrame.contentWindow.print();
            // setTimeout(function () {
            //     window.location.reload();
            // }, 500);
            toastr.success("Pdf Print Successfully");
            hideLoader();
        };
    });

    document.getElementById("newEntery").addEventListener("click", function() {
        location.reload(); 
    });
});





function getOpdnumber() {
    showLoader();
    fetch("http://localhost/laravel_setup/Opdnumber", {
        method: "GET"
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            document.getElementById('sr_no').value = data.data.serialnumber;
            document.getElementById('opd_id').value = data.data.opdnumber;
            document.getElementById('date').value = data.data.date;
            document.getElementById('time').value = data.data.time;
            hideLoader();
        } else {
            toastr.error("Error: " + data.message);
        }
    })
    .catch(error => console.error("Fetch Error:", error));
}

function chagersupdate(chargeType) {
    if (chargeType === 'PAID') {
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

function tuster(){
    fetch("http://localhost/laravel_setup/emergency", {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
           if(data.emergency == 'no'){
            toastr.info("General Opd Working");
           }else{
            toastr.info("Emergency Opd Working");
           }
        } else {
            toastr.error("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}

function showLoader() {
    document.getElementById('preloader').style.display = 'block';
}

function hideLoader() {
    document.getElementById('preloader').style.display = 'none';
}


