var url ='';
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    "use strict";
    if($('.table').length){
       $('.table').DataTable({
           ajax: "/chuc-vu/list",
           processing:true,
        //    scrollX:false,
        //    scrollY:true,
           // serverSide:true,
           // dataType: "json",
           // ordering: false,
           columns: [
               {data: "id"},
               {data: "ten_chuc_vu"},
               {data: "luong_co_ban"},
               {},
           ],
           columnDefs: [
            {
                targets: 0,
                visible: false,
            },
            {
                targets: 2,
                render: function (data, type, full, meta) {
                    
                     return (
                         '<div >' + data.toLocaleString('vi', {style : 'currency', currency : 'VND'}) +'</div>'
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
   
   
   })
function add(){
    $('#frm')[0].reset();
    $('#add_edit').modal('show');
    $('.title-chuc-vu').html('Thêm chức vụ mới');
    $('.icons-chuc-vu .material-icons').html('add');
    $('#name').val();
    $('#salary').val();
    url = "/chuc-vu/add";

}

function edit(id){
    $('#add_edit').modal('show');
    $('.title-chuc-vu').html('Cập nhật chức vụ');
    $('.icons-chuc-vu .material-icons').html('edit');
    $.ajax({
        type: "get",
        url: "/chuc-vu/load/"+id,
        dataType: "json",
        data: {id : id},
        success: function (response) {
            console.log(response);
            $('#name').val(response.data.ten_chuc_vu);
            $('#salary').val(Comma(response.data.luong_co_ban));

            url = "/chuc-vu/edit/"+id;
        }
    });
}

function save(){
    $('#frm').validate({
        rules:{
            "name": {
                required: true,
            },
            "salary": {
                required: true,
            }
        },
        messages: {
            "name": {
                required: "Bạn chưa nhập tên phòng ban!",
            },
            "salary": {
                required: "Bạn chưa nhập tên phòng ban!",
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
                    $('#add_edit').modal('hide');
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
                url: "/chuc-vu/del/"+id,
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
