  <!-- sidebar -->
  <div class="sidebar" data-active-color="rose" data-background-color="black" data-image="{{ asset('assets') }}/img/sidebar-1.jpg">
     
    <div class="logo">
        <a href="#" class="simple-text logo-mini" style="width: 45px;">
        PRJ3
        </a>
        <a href="#" class="simple-text logo-normal">
            BKD02K11
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img onerror="this.src='../../assets/img/default-avatar.png'" src="{{ Session::get('anh') }}" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                        @if (Session::exists('name'))
                        {{ Session::get('name') }}
                    @endif 
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="clearfix"></div>
                {{-- <div class="collapse" id="collapseExample"> --}}
                    {{-- <ul class="nav">
                        <li>
                            <a href="#">
                                <span class="sidebar-mini"> MP </span>
                                <span class="sidebar-normal"> My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="sidebar-mini"> EP </span>
                                <span class="sidebar-normal"> Edit Profile </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="sidebar-mini"> S </span>
                                <span class="sidebar-normal"> Settings </span>
                            </a>
                        </li>
                    </ul> --}}
                {{-- </div> --}}
            </div>
        </div>
        <ul class="nav">
            <li class="active">
                <a href="{{ route('calendar') }}">
                    <i class="material-icons"><span class="material-icons">
                        insert_invitation
                        </span></i>
                    <p> Calendar </p>
                </a>
            </li>
            @if (Session::get('id') == 1)
            <li>
                <a data-toggle="collapse" href="#pagesExamples">
                    <i class="material-icons">settings</i>
                    <p> Cài đặt
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="pagesExamples">
                    <ul class="nav" style="margin-left: 30px">
                        <li>
                            <a href="{{ route('chucvu') }}">
                                <span class="sidebar-mini">
                                    <span class="material-icons">
                                    admin_panel_settings
                                    </span>
                                </span>
                                <span class="sidebar-normal"> Chức vụ </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('truycap') }}">
                                <span class="sidebar-mini">
                                    <span class="material-icons">
                                    wifi
                                    </span>
                                </span>
                                <span class="sidebar-normal"> Điểm truy cập </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('taikhoan') }}">
                                <span class="sidebar-mini">
                                    <span class="material-icons">
                                        account_circle
                                    </span>
                                </span>
                                <span class="sidebar-normal"> Tài khoản </span>
                            </a>
                        </li>
                     
                    </ul>
                </div>
            </li> 
            @endif
            
            <li>
                <a href="{{ route('nhanvien') }}">
                    <i class="material-icons">
                        <span class="material-icons">
                        accessibility_new
                        </span></i>
                    <p> Nhân sự </p>
                </a>
            </li>
            <li>
                <a href="{{ route('hopdong') }}">
                    <i class="material-icons">
                        <span class="material-icons">
                        description
                        </span></i>
                    <p> Hợp động lao động </p>
                </a>
            </li>
            <li>
                <a href="{{ route('bangluong') }}">
                    <i class="material-icons">date_range</i>
                    <p> Bảng lương </p>
                </a>
            </li>
        </ul>
    </div>
</div>

{{-- <script src="{{ asset('assets') }}/js/profile.js"></script> --}}
<!-- end sidebar -->