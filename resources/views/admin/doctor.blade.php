@extends('layouts.app')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Doctor List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Doctor</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="d-flex justify-content-end mb-2 mt-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-default">
                Add Doctor
            </button>
        </div>

        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" id="doctor_records">
                    <thead class="table-light">
                        <tr>
                            <th>S.No</th>
                            <th>Doctor Name</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<!-- ==================== ADD DOCTOR MODAL ==================== -->
<div class="modal fade" id="modal-default" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Doctor</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="doctor_add" action="{{ route('doctor_store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Doctor Name (English)</label>
                        <input type="text" class="form-control" id="doctor_name_english" name="doctor_name_english" required>
                    </div>
                    <div class="mb-3">
                        <label>Doctor Name (Hindi) <small class="text-muted">(optional)</small></label>
                        <input type="text" class="form-control" id="doctor_name_hindi" name="doctor_name_hindi">
                    </div>
                    <div class="mb-3">
                        <label>Mobile</label>
                        <input type="text" class="form-control" name="doctor_mobile" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_active" value="1" id="add_is_active" checked>
                            <label class="form-check-label" for="add_is_active">Active</label>
                        </div>
                        <input type="hidden" name="is_active" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Doctor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================== VIEW DOCTOR MODAL ==================== -->
<div class="modal fade" id="doctorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Doctor</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name (English)</label>
                    <input type="text" id="view_name_en" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label>Mobile Number</label>
                    <input type="text" id="view_mobile" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <input type="text" id="view_status" class="form-control" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ==================== EDIT DOCTOR MODAL ==================== -->
<div class="modal fade" id="editdoctorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Doctor</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_doctor_id">

                <div class="mb-3">
                    <label>Name (English)</label>
                    <input type="text" id="edit_name_en" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Mobile Number</label>
                    <input type="text" id="edit_mobile" class="form-control">
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_active_checkbox" value="1">
                        <label class="form-check-label" for="edit_is_active_checkbox">
                            Active 
                        </label>
                    </div>
                    <input type="hidden" id="edit_is_active_hidden" name="is_active" value="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateDoctor()">Update Doctor</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fix pagination display */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem;
        margin: 0 2px;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        background: #fff;
        color: #0d6efd !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #0d6efd;
        color: #fff !important;
        border-color: #0d6efd;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e9ecef;
        border-color: #dee2e6;
        color: #0a58ca !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #0b5ed7;
        color: #fff !important;
    }
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 10px;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 10px;
    }
    .dataTables_wrapper .dataTables_info {
        padding-top: 10px;
    }
    .dataTables_wrapper .dataTables_paginate {
        padding-top: 10px;
    }
    /* Fix button spacing in action column */
    .btn-sm {
        margin: 0 2px;
    }
</style>

<!-- Load DataTables core and extensions -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- Load dependencies for export buttons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- Hindi Transliteration Library -->
<script src="https://cdn.jsdelivr.net/npm/sanscript@0.0.2/sanscript.min.js"></script>

<script>
    // Use IIFE to avoid global conflicts
    (function($) {
        'use strict';
        
        $(document).ready(function() {
            console.log('Document ready - Initializing...');
            console.log('jQuery version:', $.fn.jquery);
            console.log('DataTables available:', typeof $.fn.DataTable !== 'undefined');

            // Check if DataTables is loaded
            if (typeof $.fn.DataTable === 'undefined') {
                console.error('DataTables is not loaded! Please check network tab.');
                alert('DataTables failed to load. Please refresh the page.');
                return;
            }

            const BASE_URL = "{{ url('/') }}";
            console.log('BASE_URL:', BASE_URL);
            
            // Store the table instance globally
            window.doctorTable = null;

            // Initialize DataTable with proper configuration
            try {
                window.doctorTable = $("#doctor_records").DataTable({
                    dom: "Bfrtip",
                    buttons: [
                        { extend: "copy", title: "Doctor List" },
                        { extend: "csv", title: "Doctor List" },
                        { extend: "excel", title: "Doctor List" },
                        { extend: "pdf", title: "Doctor List" },
                        { extend: "print", title: "Doctor List" }
                    ],
                    pageLength: 10,
                    responsive: true,
                    processing: true,
                    language: {
                        emptyTable: "No doctors found"
                    }
                });
                console.log('DataTable initialized successfully');
            } catch(e) {
                console.error('Error initializing DataTable:', e);
                alert('Error initializing DataTable. Please check console.');
                return;
            }

            // Load doctor data
            getDoctorList();

            // English to Hindi auto-conversion
            $('#doctor_name_english').on('input', function() {
                let engText = this.value.trim();
                if (engText && typeof Sanscript !== 'undefined') {
                    try {
                        let hindi = Sanscript.t(engText, "itrans", "devanagari");
                        $('#doctor_name_hindi').val(hindi);
                    } catch(e) {
                        console.error('Transliteration error:', e);
                    }
                } else {
                    $('#doctor_name_hindi').val('');
                }
            });

            // Handle form submission for adding doctor
            $('#doctor_add').on('submit', function(e) {
                e.preventDefault();
                console.log('Submitting add doctor form...');
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(res) {
                        console.log('Add doctor response:', res);
                        if (res.status) {
                            alert("Doctor added successfully!");
                            $("#modal-default").modal("hide");
                            $('#doctor_add')[0].reset();
                            getDoctorList();
                        } else {
                            alert("Error: " + (res.message || "Failed to add doctor"));
                        }
                    },
                    error: function(xhr) {
                        console.error("Add doctor error:", xhr);
                        alert("Failed to add doctor. Please try again.");
                    }
                });
            });
        });

        function getDoctorList() {
            const BASE_URL = "{{ url('/') }}";
            console.log('Fetching doctor list from:', `${BASE_URL}/doctorylist`);
            
            $.ajax({
                url: `${BASE_URL}/doctorylist`,
                method: "GET",
                dataType: "json",
                success: function(res) {
                    console.log('Doctor list response:', res);
                    if (res.status) {
                        populateTable(res.data);
                    } else {
                        alert("Error: " + (res.message || "Failed to load doctors"));
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching doctor list:", error);
                    console.error("Status:", status);
                    console.error("Response:", xhr.responseText);
                    alert("Failed to load doctor list. Please check console for details.");
                }
            });
        }

        function populateTable(data) {
            console.log('Populating table with data:', data);
            
            // Use the global table instance
            const table = window.doctorTable;
            
            if (!table) {
                console.error('DataTable not initialized!');
                return;
            }
            
            table.clear();

            if (data && Array.isArray(data) && data.length > 0) {
                console.log('Number of doctors:', data.length);
                data.forEach((item, index) => {
                    const status = item.is_active == 1
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';

                    table.row.add([
                        index + 1,
                        item.name_en || "—",
                        item.mobile || "—",
                        status,
                        `
                        <button class="btn btn-info btn-sm" onclick="viewDoctor(${item.id})">View</button>
                        <button class="btn btn-warning btn-sm" onclick="editDoctor(${item.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteDoctor(${item.id})">Delete</button>
                        `
                    ]);
                });
            } else {
                console.log('No doctors found or invalid data format');
            }

            table.draw();
            console.log('Table populated and drawn');
        }

        // Expose functions to global scope
        window.viewDoctor = function(id) {
            const BASE_URL = "{{ url('/') }}";
            console.log('Viewing doctor ID:', id);
            
            $.ajax({
                url: `${BASE_URL}/doctor_view/${id}`,
                method: "GET",
                dataType: "json",
                success: function(res) {
                    console.log('View doctor response:', res);
                    if (res) {
                        $("#view_name_en").val(res.name_en || '');
                        $("#view_mobile").val(res.mobile || '');
                        $("#view_status").val(res.is_active == 1 ? "Active" : "Inactive");
                        const doctorModal = new bootstrap.Modal(document.getElementById('doctorModal'));
                        doctorModal.show();
                    }
                },
                error: function(xhr) {
                    console.error("Error viewing doctor:", xhr);
                    alert("Failed to load doctor details.");
                }
            });
        };

        window.editDoctor = function(id) {
            const BASE_URL = "{{ url('/') }}";
            console.log('Editing doctor ID:', id);
            
            $.ajax({
                url: `${BASE_URL}/doctor_view/${id}`,
                method: "GET",
                dataType: "json",
                success: function(res) {
                    console.log('Edit doctor response:', res);
                    if (res) {
                        $("#edit_doctor_id").val(res.id);
                        $("#edit_name_en").val(res.name_en || '');
                        $("#edit_mobile").val(res.mobile || '');

                        if (res.is_active == 1) {
                            $("#edit_is_active_checkbox").prop("checked", true);
                            $("#edit_is_active_hidden").val(1);
                        } else {
                            $("#edit_is_active_checkbox").prop("checked", false);
                            $("#edit_is_active_hidden").val(0);
                        }

                        $("#edit_is_active_checkbox").off("change").on("change", function() {
                            $("#edit_is_active_hidden").val(this.checked ? 1 : 0);
                        });

                        const editDoctorModal = new bootstrap.Modal(document.getElementById('editdoctorModal'));
                        editDoctorModal.show();
                    }
                },
                error: function(xhr) {
                    console.error("Error editing doctor:", xhr);
                    alert("Failed to load doctor details for editing.");
                }
            });
        };

        window.updateDoctor = function() {
            const BASE_URL = "{{ url('/') }}";
            const id = $("#edit_doctor_id").val();
            const isActive = $("#edit_is_active_checkbox").is(":checked") ? 1 : 0;
            const nameEn = $("#edit_name_en").val().trim();
            const mobile = $("#edit_mobile").val().trim();

            console.log('Updating doctor:', {id, nameEn, mobile, isActive});

            if (!nameEn || !mobile) {
                alert("Please fill in all required fields.");
                return;
            }

            $.ajax({
                url: `${BASE_URL}/doctor_update/${id}`,
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    doctor_name_english: nameEn,
                    doctor_mobile: mobile,
                    is_active: isActive
                },
                dataType: "json",
                success: function(res) {
                    console.log('Update response:', res);
                    if (res.status) {
                        alert("Doctor updated successfully!");
                        const updateDoctorModal = bootstrap.Modal.getInstance(document.getElementById('editdoctorModal')) || new bootstrap.Modal(document.getElementById('editdoctorModal'));
                        updateDoctorModal.hide();
                        getDoctorList();
                    } else {
                        alert("Error: " + (res.message || "Unknown error"));
                    }
                },
                error: function(xhr) {
                    console.error("Update error:", xhr);
                    alert("Server error! Please check console for details.");
                }
            });
        };

        window.deleteDoctor = function(id) {
            const BASE_URL = "{{ url('/') }}";
            console.log('Deleting doctor ID:', id);
            
            if (confirm("Are you sure you want to delete this doctor?")) {
                $.ajax({
                    url: `${BASE_URL}/doctor_delete/${id}`,
                    method: "POST",
                    data: { 
                        _token: $('meta[name="csrf-token"]').attr('content') 
                    },
                    dataType: "json",
                    success: function(res) {
                        console.log('Delete response:', res);
                        if (res.status) {
                            alert("Doctor deleted successfully!");
                            getDoctorList();
                        } else {
                            alert("Error: " + (res.message || "Unknown error"));
                        }
                    },
                    error: function(xhr) {
                        console.error("Delete error:", xhr);
                        alert("Failed to delete doctor. Please try again.");
                    }
                });
            }
        };

    })(jQuery); // Pass jQuery to the IIFE
</script>

@endsection