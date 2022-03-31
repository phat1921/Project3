@extends('layout.app')
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/app-calendar.css">
<style>
    .fc .fc-more-popover .fc-popover-body {
        max-height: 340px;
        overflow: auto
    }

    .fc .fc-daygrid-day.fc-day-today {
        min-height: 190px;
    }

    .fc-todayButton-button {
        border-radius: 0.358rem !important;
        margin-right: 0.25rem !important;
    }
</style>
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
                        <div id="calendar" class="fc fc-media-screen fc-direction-ltr fc-theme-standard">
                            <div class="fc-header-toolbar fc-toolbar ">
                                <div class="fc-toolbar-chunk">
                                    <div class="fc-button-group">
                                        <button class="fc-sidebarToggle-button fc-button fc-button-primary"
                                                type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round" class="feather feather-menu ficon">
                                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                                <line x1="3" y1="18" x2="21" y2="18"></line>
                                            </svg>
                                        </button>
                                        <button class="fc--button fc-button fc-button-primary"
                                                type="button"></button>
                                    </div>
                                    <div class="fc-button-group">
                                        <button class="fc-prev-button fc-button fc-button-primary"
                                                type="button" aria-label="prev"><span
                                                    class="fc-icon fc-icon-chevron-left"></span></button>
                                        <button class="fc-next-button fc-button fc-button-primary"
                                                type="button" aria-label="next"><span
                                                    class="fc-icon fc-icon-chevron-right"></span></button>
                                        <button class="fc--button fc-button fc-button-primary"
                                                type="button"></button>
                                    </div>
                                    <h2 class="fc-toolbar-title">November 2021</h2></div>
                                <div class="fc-toolbar-chunk"></div>
                                <div class="fc-toolbar-chunk">
                                    <div class="fc-button-group">
                                        <button class="fc-dayGridMonth-button fc-button fc-button-primary fc-button-active"
                                                type="button">month
                                        </button>
                                        <button class="fc-timeGridWeek-button fc-button fc-button-primary"
                                                type="button">week
                                        </button>
                                        <button class="fc-timeGridDay-button fc-button fc-button-primary"
                                                type="button">day
                                        </button>
                                        <button class="fc-listMonth-button fc-button fc-button-primary"
                                                type="button">list
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stack('custom_scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{-- <script src="{{ asset('assets') }}/js/calendar/jquery.validate.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
<script src="{{ asset('assets') }}/js/calendar/moment.min.js"></script>
<script src="{{ asset('assets') }}/js/calendar/fullcalendar.min.js"></script>
{{-- <script src="{{ asset('assets') }}/js/calendar/fullcalendar.min.2.js"></script> --}}
<script src="{{ asset('assets') }}/js/chamcong.js"></script>
@endsection