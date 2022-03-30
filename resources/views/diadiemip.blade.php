@extends('layout.app')
@section('content')
	<div class="card">
        <div class="card-header card-header-icon" data-background-color="rose">
             <i class="material-icons">assignment</i>
         </div>
             <div class="card-content">
                 <h4 class="card-title">Danh sách điểm truy cập</h4>
                  <div class="table-responsive">
    <a class="btn btn-fill btn-rose" onclick="add()">Thêm</a>
	<table class="table">
		 <thead class="text-primary">
             <th>id</th>
            <th>Tên điểm truy cập</th>
            <th>ip</th>
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
                    <i class="icons-dia-diem">
                      <span class="material-icons">
                          
                      </span>
                    </i>
                </div>
              <h5 class="title-dia-diem">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="frm" enctype="multipart/form-data">
                    @csrf
                    <div>
                    <div class="form-group label-floating">
                        <label class="control-label">Tên điểm truy cập</label>
                        <input type="text" id="name" name="name" class="form-control"/>
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">ip</label>
                        <input type="munber" id="ip" name="ip" class="form-control"/>
                    </div>
                    </div>
                    <label style="color: red">Điểm truy cập hiện tại: <?php echo request()->ip() ?></label>
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
<script src="{{ asset('assets') }}/js/diadiemip.js"></script>
@endsection