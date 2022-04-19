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
           ajax: "/hop-dong/list",
           processing:true,
           columns: [
            //    {data: "id_hd"},
               {data: "loai_hop_dong"},
               {data: "ten_nv"},
               {data: "trang_thai_hd"},
               {},
           ],
           columnDefs: [
            {
                targets: 2,
                render: function (data, type, full, meta) {
                    var $status = full['trang_thai_hd'];
                       if($status == 1){
                            return "<span style='color:green'>Đang thực hiện</span>";
                       } else if($status == 2){
                            return "<span style='color:red'>Đã kết thúc</span>";
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
                    
                        html += '<button rel="tooltip" class="btn btn-success" title="Chỉnh sửa" onclick="edit(' + full['id_hd'] + ')">';
                        html += '<i class="material-icons">edit</i>';
                        html += '</button>&nbsp';
                    if(user == 1){    
                        html += '<button rel="tooltip" class="btn btn-danger" title="Xóa" id="confirm-text" onclick="del(' + full['id_hd'] + ')">';
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
            // time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        },
    });
   })
   
function add(){
    $('#frm')[0].reset();
    $('#add_edit').modal('show');
    $('.title-hop-dong').html('Thêm hợp đồng mới');
    $('.icons-hop-dong .material-icons').html('add');
    $('#name').val();
    $('#salary').val(); 
    $('#frm')[0].reset();
    url = "/hop-dong/add";

}

function edit(id){
    $('#add_edit').modal('show');
    $('.title-hop-dong').html('Cập nhật hợp đồng');
    $('.icons-hop-dong .material-icons').html('edit');
    $.ajax({
        type: "get",
        url: "/hop-dong/load/"+id,
        dataType: "json",
        data: {id : id},
        success: function (response) {
            console.log(response);
            $('#idNv').val(response.data.id_nv).change();
            $('#idChucVu').val(response.data.id_chuc_vu).change();
            $('#loaiHD').val(response.data.loai_hop_dong);
            $('#phucap').val(Comma(response.data.phu_cap));
            $('#chinhanh').val(response.data.chi_nhanh);
            $('#diachi').val(response.data.dia_diem);
            $('#startday').val(moment(response.data.ngay_bat_dau).format('DD/MM/YYYY'));
            $('#endday').val(moment(response.data.ngay_ket_thuc).format('DD/MM/YYYY'));
            $('#salary').val(Comma(response.data.luong_co_ban));
            $('#trangthai').val(response.data.trang_thai_hd).change();


            url = "/hop-dong/edit/"+id;
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
                }
            }
        });
    }
});
    $('#frm').submit();
}


    // $('#idNv').select2({
    //     // placeholder: "Chọn khách hàng",
    //     // dropdownParent: $("#idNv"),
    //     ajax: {
    //         url: '/hop-dong/staff',
    //         dataType: 'json',
    //         data: function (params) {
    //             data: params.data
    //             // var queryParameters = {
    //             //   search: params.term
    //             // }
    //             // return queryParameters;
    //         }
    //     }
    // });

    $.ajax({
        type: "GET",
        dataType: "json",
        async: false,
        url:"/hop-dong/staff",
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
        url:"/hop-dong/role",
        success: function (data) {
            var html = '';
            data.forEach(function (element, index) {
                // if (element.selected == true)
                //     var select = 'selected';
                html += `<option value="${element.id}">${element.text}</option> `;
                // $('#salary').append(element.luong_co_ban);
            });
            $('#idChucVu').html(html);
        },
    });

    $('#idChucVu').change(function () {
        var chucvuId = $(this).val();
            // $('#task-assigned').attr('disabled', false);
            $.ajax({
                type: "GET",
                dataType: "json",
                data: { chucvuId: chucvuId },
                async: false,
                url:"/hop-dong/salary",
                success: function (data) {
                    console.log(data);
                        $('#salary').val(data.data[0].luong_co_ban);
                },
                
            });
       
    })

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
                url: "/hop-dong/del/"+id,
                data: {id: id
                    // _token: "{{ csrf_token() }}",
                        },
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