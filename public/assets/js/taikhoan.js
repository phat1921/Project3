var url ='';
$(document).ready(function () {
    "use strict";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if($('.table').length){
       $('.table').DataTable({
           ajax: "/tai-khoan/getTK",
           processing:true,
        //    scrollX:false,
        //    scrollY:true,
           // serverSide:true,
           // dataType: "json",
           // ordering: false,
           columns: [
               {data: "id"},
               {data: "ten_nv"},
               {data: "ten_tk"},
               {data: "trang_thai"},
               {}
           ],
           columnDefs: [
            {
                targets: 0,
                visible: false,
            },

            {
                targets: 3,
                render: function (data, type, full, meta) {
                   if(full['trang_thai'] == 1){
                        return '<span>Đang sử dụng</span>';
                   }else{
                       return '<span>Đã khóa</span>';
                   }
                    
                },
            },
            
            {
                targets: -1,
                title:'Thao tác',
                class:'td-actions text-right',
                // orderable: false,
                render: function (data, type, full, meta) {
                    var html = '';
                    if(user == 1){
                        html += '<button rel="tooltip" class="btn btn-success" title="Chỉnh sửa" onclick="edit(' + full['id'] + ')">';
                        html += '<i class="material-icons">edit</i>';
                        html += '</button>&nbsp';
                        html += '<button rel="tooltip" class="btn btn-danger" title="Xóa" id="confirm-text" onclick="del(' + full['id'] + ')">';
                        html += '<i class="material-icons">close</i>';
                        html += '</button>';
                    }
                    return html;
                },
                width: 200,
            },
        ],
        order: [[0, 'desc']],
        language: {
            sLengthMenu: "Hiển thị _MENU_ bản ghi",
            search:"Tìm kiếm",
            info: "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
            infoFiltered: "(Lọc từ _MAX_ bản ghi)",
            sInfoEmpty: "Hiển thị 0 đến 0 của 0 bản ghi"
        },
       });
    };
    
    $.ajax({
        type: "GET",
        dataType: "json",
        async: false,
        url:"/tai-khoan/staff",
        success: function (data) {
            var html = '';
            data.forEach(function (element, index) {
                // if (element.selected == true)
                //     var select = 'selected';
                html += `<option value="${element.id}">${element.text}</option> `;
            });
            $('#idNv').html(html);
        },
    });

    $.ajax({
        type: "GET",
        dataType: "json",
        async: false,
        url:"/tai-khoan/ip",
        success: function (data) {
            var html = '';
            data.forEach(function (element, index) {
                // if (element.selected == true)
                //     var select = 'selected';
                html += `<option value="${element.id}">${element.text}</option> `;
            });
            $('#truycap').html(html);
        },
    });
   
   })
function add(){
    $('#frm')[0].reset();
    $('#add_edit').modal('show');
    $('.title-tai-khoan').html('Thêm tài khoản mới');
    $('.icons-tai-khoan .material-icons').html('add');
//    var id =  $('#idNv').val().change();
    $('#tenTk').val();
    $('#password').val();
    url = "/tai-khoan/addTK";

}

function edit(id){
    $('#add_edit').modal('show');
    $('.title-tai-khoan').html('Cập nhật tài khoản');
    $('.icons-tai-khoan .material-icons').html('edit');
    $.ajax({
        type: "get",
        url: "/tai-khoan/loadTK/"+id,
        dataType: "json",
        data: {id : id},
        success: function (response) {
            $('#idNv').val(response.data.id).trigger('change');
            $('#truycap').val(response.data.id_dd_truy_cap).trigger('change');
            $('#tenTk').val(response.data.ten_tk);
            $('#password').val(response.data.mat_khau);

            url = "/tai-khoan/editTK/"+id;
        }
    });
}

function save(){
    $('#frm').validate({
        rules:{
            "tenTk": {
                required: true,
            },
            "password": {
                required: true,
            }
        },
        messages: {
            "tenTk": {
                required: "Bạn chưa nhập tên tài khoản!",
            },
            "password": {
                required: "Bạn chưa nhập mật khẩu!",
            }
            
        },

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
                    $('#add_edit').modal('hide');
                    $('.table').DataTable().ajax.reload(null, false);
                }else{
                    notify_error(response.msg);
                }
            }
        });
    }
});
    $('#frm').submit();
}


function del(id){
    swal({
        title: 'Xóa dữ liệu',
        text: 'Bạn có chắc chắn muốn xóa!!',
        icon: 'Waring',
        showCancelButton:true,
        confirmButtonText:'Đồng ý',
        cancelButtonText:'Bỏ qua',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
    }).then(function (result) {
        if(result){
            $.ajax({
                type: "post",
                url: "/tai-khoan/del/"+id,
                data: {id: id},
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response.code == 200){
                        notify_success(response.msg);
                        $('.table').DataTable().ajax.reload(null, false);
                    }else{
                        notify_error(response.msg);
                    }
                }
            });
        }
    })
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