var url = '';
$(document).ready(function () {
    "use strict";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
})
function initMaterialWizard() {
    // Code for the Validator
    var $validator = $('.wizard-card form').validate({
        // rules: {
        //     firstname: {
        //         required: true,
        //         minlength: 3
        //     },
        //     lastname: {
        //         required: true,
        //         minlength: 3
        //     },
        //     email: {
        //         required: true,
        //         minlength: 3,
        //     }
        // },

        errorPlacement: function(error, element) {
            $(element).parent('div').addClass('has-error');
        }
    });
    var idUser = user;
    $.ajax({
        type: "get",
        url: "/profile/list",
        dataType: "json",
        data: {id : idUser},
        success: function (response) {
            console.log(response);
            $('#phonenum').val(response.data[0].sdt_nv);
            $('#username').val(response.data[0].ten_tk);
            $('#name').val(response.data[0].ten_nv);
            $('#email').val(response.data[0].email);
            $('#manv').val(response.data[0].ma_nv);
            $('#ngaysinh').val(response.data[0].ngay_sinh);
            $('#cmnd').val(response.data[0].cmnd);
            $('#diachi').val(response.data[0].dia_chi);
            $('#quoctich').val(response.data[0].quoc_tich);
            $('#quequan').val(response.data[0].que_quan);
            url = "/profile/edit";
        }
    });
    // Wizard Initialization
    $('.wizard-card').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        // 'nextSelector': '.btn-next',
        // 'previousSelector': '.btn-previous',

        onNext: function(tab, navigation, index) {
            var $valid = $('.wizard-card form').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
        },

        onInit: function(tab, navigation, index) {
            //check number of tabs and fill the entire row
            var $total = navigation.find('li').length;
            var $wizard = navigation.closest('.wizard-card');

            $first_li = navigation.find('li:first-child a').html();
            $moving_div = $('<div class="moving-tab">' + $first_li + '</div>');
            $('.wizard-card .wizard-navigation').append($moving_div);

            refreshAnimation($wizard, index);

            $('.moving-tab').css('transition', 'transform 0s');
        },

        onTabClick: function(tab, navigation, index) {
            var $valid = $('.wizard-card form').valid();

            if (!$valid) {
                return false;
            } else {
                return true;
            }
        },

        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;

            var $wizard = navigation.closest('.wizard-card');

            // If it's the last tab then hide the last button and show the finish instead
            if ($current >= $total) {
                $($wizard).find('.btn-next').hide();
                $($wizard).find('.btn-finish').show();
            } else {
                $($wizard).find('.btn-next').show();
                $($wizard).find('.btn-finish').hide();
            }

            button_text = navigation.find('li:nth-child(' + $current + ') a').html();

            setTimeout(function() {
                $('.moving-tab').text(button_text);
            }, 150);

            var checkbox = $('.footer-checkbox');

            if (!index == 0) {
                $(checkbox).css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'position': 'absolute'
                });
            } else {
                $(checkbox).css({
                    'opacity': '1',
                    'visibility': 'visible'
                });
            }

            refreshAnimation($wizard, index);
        }
    });

    // Prepare the preview for profile picture
    $("#wizard-picture").change(function() {
        readURL(this);
    });

    $('[data-toggle="wizard-radio"]').click(function() {
        wizard = $(this).closest('.wizard-card');
        wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
        $(this).addClass('active');
        $(wizard).find('[type="radio"]').removeAttr('checked');
        $(this).find('[type="radio"]').attr('checked', 'true');
    });

    $('[data-toggle="wizard-checkbox"]').click(function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).find('[type="checkbox"]').removeAttr('checked');
        } else {
            $(this).addClass('active');
            $(this).find('[type="checkbox"]').attr('checked', 'true');
        }
    });

    $('.set-full-height').css('height', 'auto');

    //Function to show image before upload

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(window).resize(function() {
        $('.wizard-card').each(function() {
            $wizard = $(this);

            index = $wizard.bootstrapWizard('currentIndex');
            refreshAnimation($wizard, index);

            $('.moving-tab').css({
                'transition': 'transform 0s'
            });
        });
    });

    function refreshAnimation($wizard, index) {
        $total = $wizard.find('.nav li').length;
        $li_width = 100 / $total;

        total_steps = $wizard.find('.nav li').length;
        move_distance = $wizard.width() / total_steps;
        index_temp = index;
        vertical_level = 0;

        mobile_device = $(document).width() < 600 && $total > 3;

        if (mobile_device) {
            move_distance = $wizard.width() / 2;
            index_temp = index % 2;
            $li_width = 50;
        }

        $wizard.find('.nav li').css('width', $li_width + '%');

        step_width = move_distance;
        move_distance = move_distance * index_temp;

        $current = index + 1;

        if ($current == 1 || (mobile_device == true && (index % 2 == 0))) {
            move_distance -= 8;
        } else if ($current == total_steps || (mobile_device == true && (index % 2 == 1))) {
            move_distance += 8;
        }

        if (mobile_device) {
            vertical_level = parseInt(index / 2);
            vertical_level = vertical_level * 38;
        }

        $wizard.find('.moving-tab').css('width', step_width);
        $('.moving-tab').css({
            'transform': 'translate3d(' + move_distance + 'px, ' + vertical_level + 'px, 0)',
            'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'

        });
    }
}

function save(){
    $('#frm').validate({
        // rules:{
        //     "name": {
        //         required: true,
        //     },
        //     "manv": {
        //         required: true,
        //     },
        //     "date": {
        //         required: true,
        //     },
        //     "sdt": {
        //         required: true,
        //     },
        //     "email": {
        //         required: true,
        //         email: true,
        //     },
        
        // },
        // messages: {
        //     "name": {
        //         required: "Bạn chưa nhập tên nhân viên!",
        //     },
        //     "manv": {
        //         required: "Bạn chưa nhập mã nhân viên!",
        //     },
        //     "date": {
        //         required: "Bạn chưa nhập ngày sinh nhân viên!",
        //     },
        //     "sdt": {
        //         required: "Bạn chưa nhập số điện thoại nhân viên!",
        //     },
        //     "email": {
        //         required: "Bạn chưa nhập email nhân viên!",
        //         email: "Bạn chưa nhập đúng định dạng email!",
        //     },
            
        // },

    submitHandler: function (form){
        var formdata = new FormData(form);
        $.ajax({
            type: "post",
            url: url,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            data: formdata,
            enctype: 'multipart/form-data',
            dataType: "json",
            success: function (response) {
                if(response.code == 200){
                    notify_success(response.msg);
                }else{
                    notify_error(response.msg);
                }
            }
        });
    }
});
    $('#frm').submit();
}

function savepass(){
    $('#frm2').validate({
        rules:{
            "password": {
                required: true,
            },
            "newpass": {
                required: true,
            },
            "renewpass": {
                required: true,
            },
        },
        messages: {
            "password": {
                required: "Bạn chưa nhập mật khẩu hiện tại!",
            },
            "newpass": {
                required: "Bạn chưa nhập mật khẩu mới!",
            },
            "renewpass": {
                required: "Bạn chưa nhập lại mật khẩu mới!",
            },
            
        },
       

    submitHandler: function (form){
        var formdata = new FormData(form);
        $.ajax({
            type: "post",
            url: '/profile/changepass',
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            data: formdata,
            enctype: 'multipart/form-data',
            dataType: "json",
            success: function (data) {
                if(data.code == 200){
                    console.log(data);
                    notify_success(data.msg);
                }else{
                    notify_error(data.msg);
                }
            }
        });
    }
});
    $('#frm2').submit();
}

function upAvatar(){
    var myform = new FormData($('#upavatar')[0]);
    $.ajax({
        url: "/profile/upavatar",
        type: 'post',
        data: myform,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                console.log(data);
                notyfi_success(data.msg);
            }
            else
                notify_error(data.msg);
        },
    });
}

function notify_success(msg){
    $.notify({
        icon: "notifications",
        message: msg

    }, {
        type: 'success',
        timer: 2000,
        placement: {
            from: 'top',
            align: 'right',
        }
    });
}

function notify_error(msg){
    $.notify({
        icon: "notifications",
        message: msg

    }, {
        type: 'danger',
        timer: 2000,
        placement: {
            from: 'top',
            align: 'right',
        }
    });
}