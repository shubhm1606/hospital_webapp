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
            <form id="doctor_add">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Doctor Name (English)</label>
                        <input type="text" class="form-control" id="doctor_name_english" name="doctor_name_english" required>
                        <span class="text-danger" id="name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label>Doctor Name (Hindi) <small class="text-muted">(optional)</small></label>
                        <input type="text" class="form-control" id="doctor_name_hindi" name="doctor_name_hindi">
                    </div>
                    <div class="mb-3">
                        <label>Mobile</label>
                        <input type="text" class="form-control" name="doctor_mobile" id="doctor_mobile" required>
                        <span class="text-danger" id="mobile_error"></span>
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
                    <button type="submit" class="btn btn-primary" id="saveDoctorBtn">Save Doctor</button>
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
                    <label>Name (Hindi)</label>
                    <input type="text" id="view_name_hi" class="form-control" readonly>
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
                    <span class="text-danger" id="edit_name_error"></span>
                </div>
                <div class="mb-3">
                    <label>Name (Hindi)</label>
                    <input type="text" id="edit_name_hi" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Mobile Number</label>
                    <input type="text" id="edit_mobile" class="form-control">
                    <span class="text-danger" id="edit_mobile_error"></span>
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
    .btn-sm {
        margin: 0 2px;
    }
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .modal-header {
        background: #f8f9fa;
        border-radius: 12px 12px 0 0;
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
    const DOCTOR_LIST_URL = "{{ route('doctorylist') }}";
    const DOCTOR_SHOW_URL = "{{ route('doctor.show', ['id' => '__DOCTOR_ID__']) }}";
    const DOCTOR_UPDATE_URL = "{{ route('doctor.update', ['id' => '__DOCTOR_ID__']) }}";
    const DOCTOR_DELETE_URL = "{{ route('doctor.delete', ['id' => '__DOCTOR_ID__']) }}";

    $(document).ready(function() {
        'use strict';
        
        console.log('Document ready - Initializing...');
        
        // CSRF Token setup for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Check if DataTables is loaded
        if (typeof $.fn.DataTable === 'undefined') {
            console.error('DataTables is not loaded!');
            alert('DataTables failed to load. Please refresh the page.');
            return;
        }

        console.log('Doctor list URL:', DOCTOR_LIST_URL);
        
        // Store the table instance globally
        window.doctorTable = null;

        // Initialize DataTable
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

        // English to Hindi auto-conversion for Add modal
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

        // English to Hindi auto-conversion for Edit modal
        $('#edit_name_en').on('input', function() {
            let engText = this.value.trim();
            if (engText && typeof Sanscript !== 'undefined') {
                try {
                    let hindi = Sanscript.t(engText, "itrans", "devanagari");
                    $('#edit_name_hi').val(hindi);
                } catch(e) {
                    console.error('Transliteration error:', e);
                }
            } else {
                $('#edit_name_hi').val('');
            }
        });

        // Handle form submission for adding doctor
        $('#doctor_add').on('submit', function(e) {
            e.preventDefault();
            console.log('Submitting add doctor form...');
            
            // Clear previous errors
            $('#name_error').text('');
            $('#mobile_error').text('');
            
            var formData = $(this).serialize();
            console.log('Form data:', formData);
            
            $.ajax({
                url: "{{ route('doctor_store') }}",
                method: "POST",
                data: formData,
                headers: { Accept: "application/json" },
                dataType: "json",
                success: function(res) {
                    console.log('Add doctor response:', res);
                    if (res.status) {
                        alert(res.message || "Doctor added successfully!");
                        $("#modal-default").modal("hide");
                        $('#doctor_add')[0].reset();
                        $('#doctor_name_hindi').val('');
                        getDoctorList();
                    } else {
                        // Handle validation errors
                        if (res.errors) {
                            if (res.errors.doctor_name_english) {
                                $('#name_error').text(res.errors.doctor_name_english[0]);
                            }
                            if (res.errors.doctor_mobile) {
                                $('#mobile_error').text(res.errors.doctor_mobile[0]);
                            }
                        }
                        alert("Error: " + (res.message || "Failed to add doctor"));
                    }
                },
                error: function(xhr) {
                    console.error("Add doctor error:", xhr);
                    console.log('Status:', xhr.status);
                    console.log('Response:', xhr.responseText);
                    
                    let errorMsg = "Failed to add doctor. ";
                    if (xhr.status === 422) {
                        errorMsg += "Please check your input.";
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.errors) {
                                var errors = Object.values(response.errors).flat();
                                errorMsg += "\n" + errors.join('\n');
                            }
                        } catch(e) {}
                    } else if (xhr.status === 409) {
                        errorMsg += "Doctor with this mobile number already exists.";
                    } else if (xhr.status === 0) {
                        errorMsg += "Network error. Please check your connection.";
                    } else {
                        errorMsg += "Server error: " + xhr.status;
                    }
                    alert(errorMsg);
                }
            });
        });

        // Reset form when modal is closed
        $('#modal-default').on('hidden.bs.modal', function () {
            $('#doctor_add')[0].reset();
            $('#doctor_name_hindi').val('');
            $('#name_error').text('');
            $('#mobile_error').text('');
        });
    });

    // Function to get doctor list
    function getDoctorList() {
        console.log('Fetching doctor list from:', DOCTOR_LIST_URL);
        
        $.ajax({
            url: DOCTOR_LIST_URL,
            method: "GET",
            headers: { Accept: "application/json" },
            dataType: "json",
            success: function(res) {
                console.log('Doctor list response:', res);
                if (res.status) {
                    populateTable(res.data);
                } else {
                    alert("Error: " + (res.message || "Failed to load doctors"));
                }
            },
            error: function(xhr) {
                console.error("Error fetching doctor list:", xhr);
                alert("Failed to load doctor list. Please refresh the page.");
            }
        });
    }

    // Function to populate table
    function populateTable(data) {
        console.log('Populating table with data:', data);
        
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
            console.log('No doctors found');
        }

        table.draw();
        console.log('Table populated and drawn');
    }

    // View Doctor
    window.viewDoctor = function(id) {
        console.log('Viewing doctor ID:', id);
        
        $.ajax({
            url: DOCTOR_SHOW_URL.replace('__DOCTOR_ID__', id),
            method: "GET",
            headers: { Accept: "application/json" },
            dataType: "json",
            success: function(res) {
                console.log('View doctor response:', res);
                if (res) {
                    $("#view_name_en").val(res.name_en || '');
                    $("#view_name_hi").val(res.name_hi || '');
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

    // Edit Doctor
    window.editDoctor = function(id) {
        console.log('Editing doctor ID:', id);
        
        // Clear previous errors
        $('#edit_name_error').text('');
        $('#edit_mobile_error').text('');
        
        $.ajax({
            url: DOCTOR_SHOW_URL.replace('__DOCTOR_ID__', id),
            method: "GET",
            headers: { Accept: "application/json" },
            dataType: "json",
            success: function(res) {
                console.log('Edit doctor response:', res);
                if (res) {
                    $("#edit_doctor_id").val(res.id);
                    $("#edit_name_en").val(res.name_en || '');
                    $("#edit_name_hi").val(res.name_hi || '');
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

    // Update Doctor
    window.updateDoctor = function() {
        const id = $("#edit_doctor_id").val();
        const isActive = $("#edit_is_active_checkbox").is(":checked") ? 1 : 0;
        const nameEn = $("#edit_name_en").val().trim();
        const nameHi = $("#edit_name_hi").val().trim();
        const mobile = $("#edit_mobile").val().trim();

        console.log('Updating doctor:', {id, nameEn, nameHi, mobile, isActive});

        // Clear previous errors
        $('#edit_name_error').text('');
        $('#edit_mobile_error').text('');

        if (!nameEn) {
            $('#edit_name_error').text('Doctor name is required');
            return;
        }
        if (!mobile) {
            $('#edit_mobile_error').text('Mobile number is required');
            return;
        }
        if (!/^\d{10}$/.test(mobile)) {
            $('#edit_mobile_error').text('Please enter a valid 10-digit mobile number');
            return;
        }

        $.ajax({
            url: DOCTOR_UPDATE_URL.replace('__DOCTOR_ID__', id),
            method: "POST",
            headers: { Accept: "application/json" },
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                doctor_name_english: nameEn,
                doctor_name_hindi: nameHi,
                doctor_mobile: mobile,
                is_active: isActive
            },
            dataType: "json",
            success: function(res) {
                console.log('Update response:', res);
                if (res.status) {
                    alert(res.message || "Doctor updated successfully!");
                    const editModal = bootstrap.Modal.getInstance(document.getElementById('editdoctorModal'));
                    if (editModal) {
                        editModal.hide();
                    }
                    getDoctorList();
                } else {
                    if (res.errors) {
                        if (res.errors.doctor_name_english) {
                            $('#edit_name_error').text(res.errors.doctor_name_english[0]);
                        }
                        if (res.errors.doctor_mobile) {
                            $('#edit_mobile_error').text(res.errors.doctor_mobile[0]);
                        }
                    }
                    alert("Error: " + (res.message || "Failed to update doctor"));
                }
            },
            error: function(xhr) {
                console.error("Update error:", xhr);
                let errorMsg = "Failed to update doctor. ";
                if (xhr.status === 422) {
                    errorMsg += "Please check your input.";
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            var errors = Object.values(response.errors).flat();
                            errorMsg += "\n" + errors.join('\n');
                        }
                    } catch(e) {}
                } else if (xhr.status === 409) {
                    errorMsg += "Doctor with this mobile number already exists.";
                } else {
                    errorMsg += "Server error: " + xhr.status;
                }
                alert(errorMsg);
            }
        });
    };

    // Delete Doctor
    window.deleteDoctor = function(id) {
        console.log('Deleting doctor ID:', id);
        
        if (confirm("Are you sure you want to delete this doctor?")) {
            $.ajax({
                url: DOCTOR_DELETE_URL.replace('__DOCTOR_ID__', id),
                method: "POST",
                headers: { Accept: "application/json" },
                data: { 
                    _token: $('meta[name="csrf-token"]').attr('content') 
                },
                dataType: "json",
                success: function(res) {
                    console.log('Delete response:', res);
                    if (res.status) {
                        alert(res.message || "Doctor deleted successfully!");
                        getDoctorList();
                    } else {
                        alert("Error: " + (res.message || "Failed to delete doctor"));
                    }
                },
                error: function(xhr) {
                    console.error("Delete error:", xhr);
                    alert("Failed to delete doctor. Please try again.");
                }
            });
        }
    };
</script>

@endsection