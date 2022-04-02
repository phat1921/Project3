@extends('layout.app')
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
<link href="{{ asset('assets') }}/calendars/fullcalendar.min.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/css/app-calendar.css" rel="stylesheet" />
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="header text-center">
            <h3 class="title">Lịch chấm công</h3>
        </div>
        <div class="row" style="margin-left: 200px;">
            @if(session()->get('id') != 1)
            <button class="btn btn-success" onclick="checkIn()">CheckIn</button>
            <button class="btn btn-warning" onclick="checkOut()">CheckOut</button>
            @elseif (session()->get('id') == 1)
            <div class="col-md-3">
                <select class="selectpicker" id="idNhanVien" name="idNhanVien" data-style="select-with-transition" title="Chọn nhân viên">
                </select>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="card card-calendar">
                    <div class="card-content" class="ps-child">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{ asset('assets') }}/calendars/moment.js"></script>
<script src="{{ asset('assets') }}/calendars/main.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
<script src="{{ asset('assets') }}/js/calendar_test2.js"></script>
@endsection