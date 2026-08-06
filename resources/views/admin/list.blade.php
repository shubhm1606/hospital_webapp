@extends('layouts.app')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>LIST</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                <li class="breadcrumb-item active">LIST</li>
            </ol>
        </nav>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <section class="section dashboard">
        <div class="container">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date"><strong>Date:</strong></label>
                    <input type="date" id="date" class="form-control">
                </div>
                <div class="col-md-6 d-flex align-items-end justify-content-end">
                    <button onclick="exportFunction()" class="btn btn-info">Export</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" id="filter_records">
                    <thead class="table-light">
                        <tr>
                            <th>Sno</th>
                            <th>OPDID</th>
                            <th>Name</th>
                            <th>Father/Husband</th>
                            <th>Mobile</th>
                            <th>Medical</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
                <iframe id="pdfFrame" style="display:none;"></iframe>
            </div>

        </div>
    </section>
</main>

<!-- jQuery must load FIRST -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- PDF / Excel Dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
const BASE_URL = "{{ url('/') }}";

$(document).ready(function () {
    // Initialize DataTable
    window.table = $("#filter_records").DataTable({
        dom: "Bfrtip",
        buttons: [
            { extend: "copy", title: "OPD List" },
            { extend: "csv", title: "OPD List" },
            { extend: "excel", title: "OPD List" },
            { extend: "pdf", title: "OPD List" },
            { extend: "print", title: "OPD List" }
        ],
        data: []
    });

    getOpdList();

    $("#date").on("change", function () {
        filterByDate(this.value);
    });
});

function getOpdList() {
    fetch(BASE_URL + "/getopdLIst")
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                updateTable(data.data);
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(err => console.error("Fetch Error:", err));
}

function filterByDate(selectedDate) {
    fetch(BASE_URL + "/getopdLIstfilter", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ date: selectedDate })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            updateTable(data.data);
        } else {
            alert("No Data Found");
            updateTable([]);
        }
    })
    .catch(err => console.error("Fetch Error:", err));
}

function updateTable(data) {
    let table = $("#filter_records").DataTable();
    table.clear();

    data.forEach((item, index) => {
        table.row.add([
            index + 1,
            item.opdId || "—",
            item.pesientname || "—",
            item.fatherhusband || "—",
            item.mobileno || "—",
            item.desease || "—",
            item.pdate || "—",
            `
                <button class="btn btn-danger btn-sm" onclick="printpdf(${item.sno})">View</button>
                <button class="btn btn-primary btn-sm" onclick="reentry(${item.sno})">Re-Entry</button>
            `
        ]);
    });

    table.draw();
}

function printpdf(id) {
    let pdfFrame = document.getElementById("pdfFrame");
    pdfFrame.src = `{{ url('print-opd-pdf') }}/${id}`;
    pdfFrame.onload = function () {
        pdfFrame.contentWindow.print();
    };
}

function reentry(id) {
    window.location.href = BASE_URL + "/reentry/" + id;
}

function exportFunction() {
    let date = document.getElementById('date').value.trim();

    if (!date) {
        alert("Please select a date");
        return;
    }

    fetch(BASE_URL + "/export-users-datewise", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ date: date })
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `Patients-${date}.xlsx`;
        a.click();
        window.URL.revokeObjectURL(url);
    })
    .catch(err => console.error("Export Error:", err));
}
</script>

@endsection