@extends('layout.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-sm-8 col-sm-offset-2">
            <!--      Wizard container        -->
            <div class="wizard-container">
                <div class="card wizard-card" data-color="rose" id="wizardProfile">
                    <form action="" method="" enctype="">
                        <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="wizard-header">
                            <h3 class="wizard-title">
                                Profile
                            </h3>
                            {{-- <h5>This information will let us know more about you.</h5> --}}
                        </div>
                        <div class="wizard-navigation">
                            <ul>
                                <li>
                                    <a href="#about" data-toggle="tab">Thông tin chung</a>
                                </li>
                                <li>
                                    <a href="#address" data-toggle="tab">Thông tin các nhân</a>
                                </li>
                                <li>
                                    <a href="#account" data-toggle="tab">Đổi mật khẩu</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            
                            <div class="tab-pane" id="about">
                                <div class="row">
                                    {{-- <h4 class="info-text"> Let's start with the basic information (with validation)</h4> --}}
                                    <div class="col-sm-4 col-sm-offset-1">
                                        <div class="picture-container">
                                            <div class="picture">
                                                <img onerror="this.src='../../assets/img/default-avatar.png'" src="" class="picture-src" id="wizardPicturePreview" title="" />
                                                <form id="upavatar" enctype="multipart/form-data">
                                                     <input type="file" name="avatar" id="wizard-picture">
                                                </form>
                                            </div>
                                            <h6>Avatar</h6>
                                        </div>
                                    </div>
                                    <form id="frm" enctype="multipart/form-data">
                                    <div class="col-sm-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">code</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Mã nhân viên
                                                    </label>
                                                    <input name="manv" id="manv" disabled type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">record_voice_over</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Tên đăng nhập
                                                    </label>
                                                    <input name="username" id="username" disabled type="text" class="form-control">
                                                </div>
                                            </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">phone</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Số điện thoại
                                                </label>
                                                <input name="phonenum" id="phonenum" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-lg-offset-1">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Họ tên
                                                </label>
                                                <input name="name" id="name" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email
                                                </label>
                                                <input name="email" id="email" type="email" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       
                            <div class="tab-pane" id="address">
                                <div class="row">
                                    <div class="col-sm-12">
                                        {{-- <h4 class="info-text"> Are you living in a nice area? </h4> --}}
                                    </div>
                                    {{-- <div class="col-sm-5 col-sm-offset-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Mã nhân viên</label>
                                            <input type="text" id="manv" name="manv" class="form-control">
                                        </div>
                                    </div> --}}
                                    <div class="col-sm-5">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Ngày sinh</label>
                                            <input type="text" id="ngaysinh" name="ngaysinh" class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-sm-5 col-sm-offset-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">CMND</label>
                                            <input type="text" id="cmnd" name="cmnd" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Địa chỉ</label>
                                            <input type="text" id="diachi" name="diachi" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-5 col-sm-offset-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Quốc tịch</label>
                                            <input type="text" id="quoctich" name="quoctich" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Quê quán</label>
                                            <input type="text" id="quequan" name="quequan" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <div class="tab-pane" id="account">
                                {{-- <h4 class="info-text"> What are you doing? (checkboxes) </h4> --}}
                                <div class="row">
                                    <form id="frm2" enctype="multipart/form-data">
                                    <div class="col-lg-10 col-lg-offset-1">
                                        <div class="col-sm-5 col-sm-offset-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Mật khẩu hiện tại</label>
                                                <input type="password" id="password" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Mật khẩu mới</label>
                                                <input type="password" id="newpass" name="newpass" class="form-control datepicker">
                                            </div>
                                        </div>
                                        <div class="col-sm-5 col-sm-offset-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nhập lại mật khẩu mới</label>
                                                <input type="password" id="renewpass" name="renewpass" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-footer">
                            <div class="pull-right">
                                <input type='button' class='btn btn-next btn-fill btn-rose btn-wd' name='next' value='Lưu' id="btn_save"/>
                                <input type='button' class='btn btn-finish btn-fill btn-rose btn-wd' name='finish' onclick="savepass()" value='Đổi mật khẩu' id="btn_save_pass"/>
                            </div>
                            {{-- <div class="pull-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                            </div> --}}
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- wizard container -->
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets') }}/js/profile.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        "use strict";

        let url = '';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        

        Profile.init();
    });
</script>
@endsection