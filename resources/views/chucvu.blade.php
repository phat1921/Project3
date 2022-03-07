@extends('layout.app')
@section('content')
	<div class="card">
        <div class="card-header card-header-icon" data-background-color="rose">
             <i class="material-icons">assignment</i>
         </div>
             <div class="card-content">
                 <h4 class="card-title">Danh sách khóa</h4>
                  <div class="table-responsive">
    <a class="btn btn-fill btn-rose" onclick="add()">Thêm Khóa</a>
	<table class="table">
		 <thead class="text-primary">
             <th>id</th>
			<th>Tên chức vụ</th>
			<th>Lương cơ bản</th>
		</thead>
	</table>
		</div>
	</div>
    <div class="modal" tabindex="-1" id="add_edit" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <div style="" class="card-header card-header-icon" data-background-color="rose">
                    <i class="icons-chuc-vu"></i>
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
                        <label class="control-label">Tên</label>
                        <input type="text" id="name" name="name" class="form-control"/>
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">Lương</label>
                        <input type="munber" id="salary" name="salary"  class="form-control"/>
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
<script src="{{ asset('assets') }}/js/chucvu.js"></script>
@endsection