@extends('layout.app')
@section('content')
	<div class="card">
        <div class="card-header card-header-icon" data-background-color="rose">
             <i class="material-icons">assignment</i>
         </div>
             <div class="card-content">
                 <h4 class="card-title">Danh sách nhân viên</h4>
                  <div class="table-responsive">
                    @if (Session::get('id') == 1)
                    <a class="btn btn-fill btn-rose" onclick="add()">Thêm</a>
                    @endif
	<table class="table">
		 <thead class="text-primary">
             <th>id</th>
            <th>Mã nhân viên</th>
            <th>Tên nhân viên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Ngày sinh</th>
            <th>Thao tác</th>

      <th></th>
		</thead>
	</table>
		</div>
	</div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" id="add_edit" role="dialog">
        <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <div style="" class="card-header card-header-icon" data-background-color="rose">
                    <i class="icons-nhan-vien">
                      <span class="material-icons">
                          
                      </span>
                    </i>
                </div>
              <h5 class="title-nhan-vien">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            
                <form id="frm" enctype="multipart/form-data">
                  {{ csrf_field() }}
                    <div class="media mb-2 col-12" style="margin-left: 40px;">
                      <div class="col-lg-8 d-flex mt-1 px-0">
                          <img id="avatar" src="" alt="users avatar" onerror="this.src='{{ asset('assets') }}/img/placeholder.jpg'" style="height: 100px; width: 100px;margin-right: 30px;border-radius:50%" />
                      </div>
                      <div class="col-lg-3 d-flex mt-1 px-0">
                          <div class="form-group">
                              <label class="d-block mb-1">Giới tính</label>
                              <div
                                  class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="male1" name="gender"
                                      class="custom-control-input" value="1" />
                                  <label class="custom-control-label"
                                      for="male1">Nam</label>
                              </div>
                              <div
                                  class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="female1" name="gender"
                                      class="custom-control-input" value="2" />
                                  <label class="custom-control-label"
                                      for="female1">Nữ</label>
                              </div>
                          </div>
                      </div>
                  </div>
                  <h4>Thông tin cá nhân</h4>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group label-floating">
                        <label class="control-label">Mã nhân viên</label>
                        <input type="text" id="manv" name="manv" class="form-control"/>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group label-floating">
                        <label class="control-label">Tên nhân viên</label>
                        <input type="text" id="name" name="name" class="form-control"/>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group label-floating">
                        <label class="control-label">Ngày sinh</label>
                        <input type="text" id="date" name="date" class="form-control datepicker"/>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group label-floating">
                        <label class="control-label">Số điện thoại</label>
                        <input type="text" id="sdt" name="sdt" class="form-control"/>
                      </div>
                    </div>
                    
                    <div class="col-md-4">
                      <div class="form-group label-floating">
                        <label class="control-label">Email</label>
                        <input type="text" id="email" name="email" class="form-control"/>
                      </div>
                    </div>

                  </div>
                  <h4>Thông tin pháp lý</h4>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group label-floating">
                        <label class="control-label">CMND</label>
                        <input type="text" id="cmnd" name="cmnd" class="form-control"/>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group label-floating">
                        <label class="control-label">Quốc tịch</label>
                        <input type="text" id="quoctich" name="quoctich" class="form-control"/>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group label-floating">
                        <label class="control-label">Quê quán</label>
                        <input type="text" id="quequan" name="quequan" class="form-control"/>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group label-floating">
                        <label class="control-label">Địa chỉ</label>
                        <input type="text" id="diachi" name="diachi" class="form-control"/>
                      </div>
                    </div>
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
<script src="{{ asset('assets') }}/js/nhanvien.js"></script>
<script>
     $.ajaxSetup({
                headers: {
                  'X-CSSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
</script>
@endsection