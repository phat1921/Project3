@extends('layout.app')
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
                        <div id="fullCalendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
<script src="{{ asset('assets') }}/js/calendar.js"></script>
@endsection