@extends('layout.app')
 @section('content')
       <!-- content -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">supervisor_account</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Tổng Số nhân viên</p>
                            <h3 class="card-title">{{ $staff }}</h3>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="rose">
                            <i class="material-icons">sync_alt</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Thử việc</p>
                            <h3 class="card-title">{{ $test }}</h3>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">how_to_reg</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Chính thức</p>
                            <h3 class="card-title">{{ $offical }}</h3>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="red">
                            <i class="material-icons">no_accounts</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Nghỉ việc</p>
                            <h3 class="card-title">{{ $quit }}</h3>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="rose">
                        <i class="material-icons">equalizer</i>
                    </div>
    
                    <div class="card-content" >
                    <h4 class="card-title">Tần suất đi làm muộn</h4>
                    <div class="row">
                      <div id="statistics-profit-chart"></div>
                    </div>
                </div>
                </div>  
            </div>  
            

                <div class="col-md-6">
                    <div class="card">
                    <div class="card-header card-header-icon" data-background-color="rose">
                            <i class="material-icons">article</i>
                    </div>
                    <div class="card-content" >
                        <h4 class="card-title"> Danh sách hợp đồng sắp kết thúc</h4>
                        <div class="row">
                            <table class="table">
                                <thead class="text-primary">
                                    <th>Loại hợp đồng</th>
                                   <th>Tên nhân viên</th>
                                   <th>Ngày kết thúc</th>
                                   <th>Thao tác</th>
                               </thead>
                           </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="card" style="margin-top: -50px;margin-left: 100px;">
                    <div class="card-header card-header-icon" data-background-color="rose">
                        <i class="material-icons">donut_small</i>
                    </div>
                    <div class="card-content" >
                      <h4 class="card-title">Tỉ lệ chức vụ</h4>
                      <div class="row">
                        <div id="pie-profit-chart"></div>
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
                              <input type="text" id="startday" name="startday"z class="form-control datepicker"/>
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
    <!-- end content -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
{{-- <script src="{{ asset('assets') }}/js/chart/chart.js"></script> --}}
    <script src="{{ asset('assets') }}/js/dashboard.js"></script>
 @endsection
          
  