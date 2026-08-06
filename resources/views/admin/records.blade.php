@extends('layouts.app')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Report</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Report</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-end mb-2 mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-default">
                        Filter
                    </button>
                </div>

                <div id="export-buttons" class="d-flex justify-content-end gap-2 mb-2 mt-3" style="display: none;">
                    <button type="button" id="exportToExcel" class="btn btn-warning" onclick="exportToExcel()">Excel</button>
                    <button type="button" id="exportToPdf" class="btn btn-success" onclick="exportToPdf()">Pdf</button>
                </div>

                <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="modal-default-label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Default Modal</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form id="record_filter">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="startingdate">Start Date:</label>
                                        <input type="date" class="form-control" id="startingdate">
                                    </div>
                                    <div class="form-group">
                                        <label for="enddate">End Date:</label>
                                        <input type="date" class="form-control" id="enddate">
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive" style="margin-top:21px">
                    <input type="hidden" id="startdate" name="startdate" />
                    <input type="hidden" id="endingdate" name="endingdate" />
                    <table class="table table-bordered text-center" id="filter_records">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="3">तारीख</th>
                                <th colspan="8">ओपीडी मरीजों (रोगियों की संख्या एवं आय)</th>
                                <th colspan="4">आईपीडी मरीजों (रोगियों की संख्या एवं आय)</th>
                                <th colspan="8">रसीद द्वारा प्राप्त आय</th>
                                <th colspan="2">महायोग</th>
                            </tr>
                            <tr>
                                <th colspan="3">जनरल ओपीडी (Rs.10.00)</th>
                                <th colspan="3">स्पेशल ओपीडी (Rs.30.00)</th>
                                <th colspan="2">योग</th>
                                <th colspan="2">आईपीडी (Rs.30.00)</th>
                                <th colspan="2">योग</th>
                                <th colspan="2">प्राइवेट वार्ड</th>
                                <th colspan="2">एक्स-रे</th>
                                <th colspan="2">एंटी रेबीज</th>
                                <th colspan="2">योग</th>
                            </tr>
                            <tr>
                                <th>फ्री</th>
                                <th>पेड</th>
                                <th>आय</th><!--------opd----------->

                                <th>फ्री</th>
                                <th>पेड</th>
                                <th>आय</th><!---------Emer opd---------->

                                <th>संख्या</th>
                                <th>आय</th><!---------Totaol opd $ emer-opd ---------->

                                <th>फ्री</th>
                                <th>पेड</th><!---------ipd---------->


                                <th>संख्या</th>
                                <th>आय</th> <!------------total ipd------------>

                                <th>संख्या</th>
                                <th>आय</th><!--------प्राइवेट वार्ड---------->

                                <th>संख्या</th>
                                <th>आय</th><!-------एक्स-रे---------->

                                <th>संख्या</th>
                                <th>आय</th><!---------एंटी रेबीज------------>

                                <th>संख्या</th>
                                <th>आय</th><!---------योग------------>

                                <th>संख्या</th>
                                <th>आय</th><!----------महायोग------------->
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </section>

</main><!-- End #main -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{asset('public/js/records.js')}}"></script>
@endsection