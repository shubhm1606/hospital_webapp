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
                <div class="col-md-4">
                    <label for="date"><strong>Date Filter:</strong></label>
                    <input type="date" id="date" class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button id="filterBtn" class="btn btn-primary me-2">Filter</button>
                    <button id="resetBtn" class="btn btn-secondary">Reset</button>
                </div>
                <div class="col-md-4 d-flex align-items-end justify-content-end">
                    <button onclick="exportFunction()" class="btn btn-info">Export</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" id="filter_records">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
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

<!-- Meta CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

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

// Global functions
function printpdf(id) {
    let pdfFrame = document.getElementById("pdfFrame");
    pdfFrame.src = `{{ url('print-opd-pdf') }}/${id}`;
    pdfFrame.onload = function () {
        pdfFrame.contentWindow.print();
    };
}

function reentry(id) {
    if (id) {
        window.location.href = BASE_URL + "/reentry/" + id;
    } else {
        alert("Invalid ID");
    }
}

function exportFunction() {
    let date = document.getElementById('date').value.trim();

    if (!date) {
        alert("Please select a date");
        return;
    }

    // Show loading state
    const exportBtn = document.querySelector('[onclick="exportFunction()"]');
    const originalText = exportBtn.innerHTML;
    exportBtn.disabled = true;
    exportBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Exporting...';

    fetch(BASE_URL + "/export-users-datewise", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ date: date })
    })
    .then(response => {
        // Check if response is OK
        if (!response.ok) {
            // Try to parse error from response
            return response.text().then(text => {
                try {
                    const json = JSON.parse(text);
                    throw new Error(json.error || 'Export failed');
                } catch (e) {
                    throw new Error('Server error: ' + text.substring(0, 100));
                }
            });
        }
        
        // Check content type
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(data => {
                throw new Error(data.error || 'Export failed');
            });
        }
        
        return response.blob();
    })
    .then(blob => {
        // Create download link
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `Patients-${date}.csv`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        // Reset button
        exportBtn.disabled = false;
        exportBtn.innerHTML = originalText;
    })
    .catch(err => {
        console.error("Export Error:", err);
        alert(err.message || "Error exporting data. Please try again.");
        exportBtn.disabled = false;
        exportBtn.innerHTML = originalText;
    });
}
$(document).ready(function () {
    // Initialize DataTable with Server-Side Processing
    var table = $("#filter_records").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: BASE_URL + "/getopdLIst",
            type: "GET",
            data: function (d) {
                // Add custom parameters
                d.date = $('#date').val();
                return d;
            },
            dataSrc: function (json) {
                // If you want to modify response
                if (!json.status) {
                    alert(json.message || 'Error fetching data');
                }
                return json.data || [];
            },
            error: function(xhr, error, thrown) {
                console.error('DataTable Error:', error);
                alert('Error loading data. Please check console.');
            }
        },
        columns: [
            { data: 'sno', name: 'sno' },
            { data: 'opdId', name: 'opdId' },
            { data: 'pesientname', name: 'pesientname' },
            { data: 'fatherhusband', name: 'fatherhusband' },
            { data: 'mobileno', name: 'mobileno' },
            { data: 'desease', name: 'desease' },
            { data: 'pdate', name: 'pdate' },
            { 
                data: 'action', 
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        order: [[1, 'desc']], // Default sort by OPDID
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        dom: "Bfrtip",
        buttons: [
            { extend: "copy", title: "OPD List" },
            { extend: "csv", title: "OPD List" },
            { extend: "excel", title: "OPD List" },
            { extend: "pdf", title: "OPD List" },
            { extend: "print", title: "OPD List" }
        ],
        language: {
            processing: "Loading data...",
            emptyTable: "No records found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            lengthMenu: "Show _MENU_ entries",
            search: "Search:",
            zeroRecords: "No matching records found"
        },
        // Disable sorting on Action column
        columnDefs: [
            { orderable: false, targets: [0, 7] },
            { searchable: false, targets: [0, 7] }
        ],
        // For better performance with large datasets
        deferRender: true,
        scrollX: true,
        scrollCollapse: true
    });

    // Filter button click
    $("#filterBtn").on("click", function() {
        var date = $('#date').val();
        if (!date) {
            alert('Please select a date');
            return;
        }
        
        // Update AJAX URL with date filter
        table.ajax.url(BASE_URL + "/getopdLIstfilter?date=" + date).load();
    });

    // Reset button click
    $("#resetBtn").on("click", function() {
        $('#date').val('');
        table.ajax.url(BASE_URL + "/getopdLIst").load();
    });

    // Date field Enter key support
    $("#date").on("keypress", function(e) {
        if (e.which === 13) {
            $('#filterBtn').click();
        }
    });

    // Reload table on specific events
    // Auto-refresh every 5 minutes (optional)
    // setInterval(function() {
    //     table.ajax.reload(null, false);
    // }, 300000);
});

// Alternative: If you want to use the separate filter endpoint
function filterByDate(selectedDate) {
    var table = $("#filter_records").DataTable();
    if (!selectedDate) {
        table.ajax.url(BASE_URL + "/getopdLIst").load();
        return;
    }
    table.ajax.url(BASE_URL + "/getopdLIstfilter?date=" + selectedDate).load();
}
</script>

@endsection