@extends('layout.app')
@section('content')
	<div class="card">
        <div class="card-header card-header-icon" data-background-color="rose">
             <i class="material-icons">assignment</i>
         </div>
             <div class="card-content">
                 <h4 class="card-title">Danh sách hợp đồng</h4>
                  <div class="table-responsive">
                    @if (Session::get('id') == 1)
                    <a class="btn btn-fill btn-rose" onclick="add()">Thêm</a>
                    @endif
	<table class="table">
		 <thead class="text-primary">
             <th>Loại hợp đồng</th>
            <th>Tên nhân viên</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
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
                    <i class="icons-hop-dong">
                      <span class="material-icons">
                          
                      </span>
                    </i>
                </div>
              <h5 class="title-hop-dong">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="frm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <select class="selectpicker" id="idNv" name="idNv" data-style="select-with-transition" title="Chọn nhân viên">
                             
                            </select>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group label-floating">
                            <label class="control-label">loại hợp đồng</label>
                            <input type="text" id="loaiHD" name="loaiHD" class="form-control"/>
                          </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                          <select class="selectpicker" id="idChucVu" name="idChucVu" data-style="select-with-transition" title="Chọn chức vụ">
                          </select>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group label-floating">
                          <label class="control-label">Lương cơ bản</label>
                          <input type="text" id="salary" name="salary" class="form-control"/>
                      </div>
                      </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group label-floating">
                        <label class="control-label">Phụ cấp</label>
                        <input type="text" id="phucap" name="phucap" class="form-control"/>
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group label-floating">
                        <label class="control-label">Chi nhánh</label>
                        <input type="text" id="chinhanh" name="chinhanh" class="form-control"/>
                    </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group label-floating">
                      <label class="control-label">Địa chỉ</label>
                      <input type="text" id="diachi" name="diachi" class="form-control"/>
                  </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group label-floating">
                      <label class="control-label">Ngày bắt đầu</label>
                      <input type="text" id="startday" name="startday" class="form-control datepicker"/>
                  </div>
                  </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Ngày kết thúc</label>
                    <input type="text" id="endday" name="endday" class="form-control datepicker"/>
                </div>
                </div>
                <div class="col-md-6">
                  <select class="selectpicker" id="trangthai" name="trangthai" data-style="select-with-transition" title="Chọn trạng thái">
                    <option value="1">Đang thực hiện</option>
                    <option value="2">Đã kết thúc</option>
                  </select>
                </div>
            </div>
                </form>
            </div>
            <div class="modal-footer">
              <?php 
                if(Session::get('id') == 1){
                ?>
              <button type="button" onclick="save()" class="btn btn-rose">cập nhật</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button>
              <?php 
                }
                ?>
            </div>
          </div>
        </div>
      </div>
   
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets') }}/js/hopdong.js"></script>
{{-- <script src="{{ asset('assets') }}/js/lib.js"></script> --}}

<script>
   var CSRF_TOKEN =  $('meta[name="csrf_token"]').attr('content');
   $(document).ready(function () {
      $('#idNv').select2({
          $.ajax({
            url: "{{ route('getStaff') }}",
            type:'post'
            dataType: "json",
            data: function(params){
              return{
                _token: CSRF_TOKEN,
                
              }
            },
       
          });
      }); 
   });
</script>
@endsection