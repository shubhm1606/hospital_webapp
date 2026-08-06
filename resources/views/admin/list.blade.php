@extends('layouts.app')

@section('content')

<main id="main" class="main">
<div class="pagetitle">
        <h1>LIST</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{('home')}}">Home</a></li>
                <li class="breadcrumb-item active">LIST</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="container">
            <div class="table-responsive" style="margin-top:21px">
                <table class="table table-bordered text-center" id="filter_records">
                    <thead class="table-light">
                        <tr>
                            <td>Sno</td>
                            <td>Name</td>
                            <td>Father/Husband</td>
                            <td>Mobile</td>
                            <td>Medical</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </sesion>
</main>

@endsection