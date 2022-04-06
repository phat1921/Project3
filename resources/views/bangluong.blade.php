@extends('layout.app')
@section('content')
	<div class="card">
        <div class="card-header card-header-icon" data-background-color="rose">
             <i class="material-icons">assignment</i>
         </div>
             <div class="card-content">
                 <h4 class="card-title">Bảng lương</h4>
                  <div class="table-responsive">
   
    <div class="row">
        {{-- <form > --}}
            <div class="col-md-1">
                <select class="selectpicker" id="nam" name="nam" data-size="4" data-style="select-with-transition" title="Chọn năm">
                  
                  <?php
                    $starting_year = 2020;
                    $ending_year = date('Y');
                    for($i = $starting_year; $i <= $ending_year; $i++) {
                        $selected = ($ending_year == $i ? ' selected' : '');
                    echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
                    }     

                 ?>
                </select>
            </div>
            <div class="col-md-1">
                <select class="selectpicker" id="thang" data-size="4" name="thang" data-style="select-with-transition" title="Chọn tháng" selected>
                 
                  @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ date('m', mktime(0, 0, 0, $i+1, 0, 0)) }}" 
                      @if (date('m') == $i)
                        {{ "selected" }}
                      @endif
                      >
                        {{ date('m', mktime(0, 0, 0, $i+1, 0, 0)) }}
                    </option>
                  @endfor
                 
                </select>
            </div>
             <button type="button" class="btn btn-fill btn-rose" onclick="search()">Tìm kiếm</button>&nbsp
             
        {{-- </form> --}}
       <button type="button" class="btn btn-fill btn-rose" onclick="add()">Lập bảng</button>&nbsp
       <button type="button" class="btn btn-fill btn-rose" onclick="checkAll()">Duyệt bảng</button>
    </div>
    
	<table class="table">
		 <thead class="text-primary">
             <th></th>
             <th></th>
             <th>Nhân viên</th>
            <th>Công chuẩn</th>
            <th>Công thực tế</th>
            <th>Lương cơ bản</th>
            <th>Phụ cấp</th>
            <th>Thưởng</th>
            <th>Ứng trước</th>
            <th>Phạt</th>
            <th></th>
            <th></th>
		</thead>
	</table>
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
                <form id="frm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group label-floating">
                        <label class="control-label">Phụ cấp</label>
                        <input type="text" id="phucap" name="phucap" class="form-control"/>
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">Thưởng</label>
                        <input type="text" id="thuong" name="thuong" class="form-control"/>
                    </div>
                    <div class="form-group label-floating">
                      <label class="control-label">Ứng trước</label>
                      <input type="text" id="ungtruoc" name="ungtruoc"  class="form-control"/>
                  </div>
                  <div class="form-group label-floating">
                    <label class="control-label">Số ngày đi muộn</label>
                    <input type="text" id="dimuon" name="dimuon"  class="form-control"/>
                </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" onclick="save()" class="btn btn-rose">cập nhật</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button>
            </div>
          </div>
        </div>
      </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets') }}/js/bangluong.js"></script>
@endsection