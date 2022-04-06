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
            <button class="btn btn-success" id="checkInBtn">CheckIn</button>
            <button class="btn btn-warning" id="checkOutBtn">CheckOut</button>
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
    <div class="modal" tabindex="-1" id="add_edit" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <div style="" class="card-header card-header-icon" data-background-color="rose">
                    <i class="icons-chuc-vu">
                      <span class="material-icons">
                          
                      </span>
                    </i>
                </div>
              <h5 class="title-chuc-vu">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="frmCong" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group label-floating">
                        <label class="control-label">Ngày</label>
                        <input type="text" id="ngay" name="ngay" class="form-control datepicker"/>
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">Giờ vào</label>
                        <input type="text" id="giovao" name="giovao" class="form-control timepicker"/>
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">Giờ ra</label>
                        <input type="text" id="giora" name="giora" class="form-control timepicker"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="submit" id="updateEvent" class="btn btn-rose">cập nhật</button>
              <button type="button" id="cancel" class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button>
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
<script src="{{ asset('assets') }}/js/lichcong.js"></script>
@endsection