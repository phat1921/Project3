var url ='';
$(document).ready(function () {
    "use strict";
    if($('.table').length){
       $('.table').DataTable({
           ajax: "/chuc-vu/list",
           processing:true,
           // serverSide:true,
           // dataType: "json",
           // ordering: false,
           columns: [
               {data: "id"},
               {data: "ten_chuc_vu"},
               {data: "luong_co_ban"},
           ],
           columnDefs: [
            {
                targets: 0,
                visible: false,
            },
            {
                targets: 1,
              
            },
            {
                targets: 2,
            
            },
            
            {
                targets: -1,
                title:'Thao tác',
                // orderable: false,
                render: function (data, type, full, meta) {
                    var html = '';
                        html += '<button type="button" rel="tooltip" class="btn btn-success" title="Chỉnh sửa" onclick="edit(' + full['id'] + ')">';
                        html += '<i class="material-icons">edit</i>';
                        html += '</button> &nbsp;';
                        html += '<button type="button"rel="tooltip" class="btn btn-danger" title="Xóa" id="confirm-text" onclick="xoa(' + full['id'] + ')">';
                        html += '<i class="material-icons">close</i>';
                        html += '</button>';
                    return html;
                },
                width: 50,
            },
        ],
       });
    };
   
   
   })
function add(){
    $('#add_edit').modal('show');
    $('.title-chuc-vu').html('Thêm chức vụ mới');
    $('.icons-chuc-vu').html('add');
    $('#name').val();
    $('#salary').val();

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
            url: "/chuc-vu/add",
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            data: formdata,
            enctype: 'multipart/form-data',
            dataType: "json",
            success: function (response) {
                if(response.code == 200){
                    $('#add_edit').modal('hide');
                    $('.table').DataTable().ajax.reload(null, false);
                }
            }
        });
    }
});
    $('#frm').submit();
}