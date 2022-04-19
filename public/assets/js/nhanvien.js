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
           ajax: "/nhan-vien/list",
           processing:true,
        //    scrollX:false,
        //    scrollY:true,
           // serverSide:true,
           // dataType: "json",
           // ordering: false,
           columns: [
               {data: "id"},
               {data: "ma_nv"},
               {data: "ten_nv"},
               {data: "email"},
               {data: "sdt_nv"},
               {data: "ngay_sinh"},
               {},
           ],
           columnDefs: [
            {
                targets: 0,
                visible: false,
            },

            {
                targets: 5,
                render: function (data, type, full, meta) {
                    
                    return (
                        '<div >' + moment(data).format('DD/MM/YYYY')+'</div>'
                    );

                }
            },
            
            {
                
                targets: -1,
                title:'Thao tác',
                class:'td-actions text-right',
                // orderable: false,
                render: function (data, type, full, meta) {
                    var html = '';
                    if(user == 1 ){
                        html += '<button rel="tooltip" class="btn btn-success " title="Chỉnh sửa" onclick="edit(' + full['id'] + ')">';
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
   
    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
    });
   
   })
function add(){
    $('#frm')[0].reset();
    $('#add_edit').modal('show');
    $('.title-nhan-vien').html('Thêm thông tin nhân sự');
    $('.icons-nhan-vien .material-icons').html('add');
    $('#name').val();
    $('#salary').val();
    url = "/nhan-vien/add";

}

function edit(id){
    $('#add_edit').modal('show');
    $('.title-nhan-vien').html('Cập nhật thông tin nhân sự');
    $('.icons-nhan-vien .material-icons').html('edit');
    $('#manv').prop('readonly', true);
    $.ajax({
        type: "get",
        url: "/nhan-vien/load/"+id,
        dataType: "json",
        data: {id : id},
        success: function (response) {
            console.log(response.data);
            if(response.data.gioi_tinh == 1 ){
                $('#male1').prop("checked", true);
            }else{
                $('#female1').prop("checked", true);
            }
            $('#manv').val(response.data.ma_nv);
            $('#avatar').prop('src', response.data.anh);
            $('#date').val(moment(response.data.ngay_sinh).format('DD/MM/YYYY'));
            $('#sdt').val(response.data.sdt_nv);
            $('#email').val(response.data.email);
            $('#cmnd').val(response.data.cmnd);
            $('#quoctich').val(response.data.quoc_tich);
            $('#quequan').val(response.data.que_quan);
            $('#diachi').val(response.data.dia_chi);
            $('#name').val(response.data.ten_nv);
           
            url = "/nhan-vien/edit/"+id;
        }
    });
}

function save(){
    $('#frm').validate({
        rules:{
            "name": {
                required: true,
            },
            "manv": {
                required: true,
            },
            "date": {
                required: true,
            },
            "sdt": {
                required: true,
            },
            "email": {
                required: true,
                email: true,
            },
        
        },
        messages: {
            "name": {
                required: "Bạn chưa nhập tên nhân viên!",
            },
            "manv": {
                required: "Bạn chưa nhập mã nhân viên!",
            },
            "date": {
                required: "Bạn chưa nhập ngày sinh nhân viên!",
            },
            "sdt": {
                required: "Bạn chưa nhập số điện thoại nhân viên!",
            },
            "email": {
                required: "Bạn chưa nhập email nhân viên!",
                email: "Bạn chưa nhập đúng định dạng email!",
            },
            
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
                url: "/nhan-vien/del/"+id,
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