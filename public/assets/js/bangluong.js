var url ='';
var index = 0;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    "use strict";

    if($('.table').length){
       $('.table').DataTable({
           ajax: "/bang-luong/list",
           processing:true,
        //    scrollX:false,
        //    scrollY:true,
           // serverSide:true,
           // dataType: "json",
           // ordering: false,
           columns: [
               {},
               {data: "id_bl"},
               {data: "ten_nv"},
               {data: "cong_chuan"},
               {data: "cong_thuc_te"},
               {data: "luong_co_ban"},
               {data: "phu_cap"},
               {data: "thuong"},
               {data: "ung_truoc"},
               {data: "phat_muon"},
               {data: "thuc_linh"},
               {data: "tinh_trang"}
               
           ],
           columnDefs: [
            {
                targets: 0,
                title:'Thao tác',
                class:'td-actions text-left',
                // orderable: false,
                render: function (data, type, full, meta) {
                    var html = '';
                    if(user == 1 && full['tinh_trang'] == 1){
                        html += '<button rel="tooltip" class="btn btn-info" title="Chỉnh sửa" onclick="edit(' + full['id_bl'] + ')">';
                        html += '<i class="material-icons">edit</i>';
                        html += '</button>&nbsp';
                        html += '<button rel="tooltip" class="btn btn-success" title="Duyệt" id="confirm-text" onclick="checkById(' + full['id_bl'] + ')">';
                        html += '<i class="material-icons">done</i>';
                        html += '</button>';
                    }else if(user == 1 && full['tinh_trang'] == 2){
                        html += '<button rel="tooltip" class="btn btn-danger" title="Hoàn duyệt" onclick="unCheck(' + full['id_bl'] + ')">';
                        html += '<i class="material-icons">replay</i>';
                        html += '</button>';
                    }
                    
                    return html;
                },
                width: 100,
            },
            {
                targets: 1,
                visible:false,
            },
            {
                targets: -1,
                visible:false,
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

   function search() {
    var thang = $("#thang").val();
    var nam = $("#nam").val();
    $.ajax({
                url:"/bang-luong/search",
                type: 'get',
                dataType: "json",
                data: {thang: thang, nam: nam},
                success: function (data) {
                        $('.table').DataTable().ajax.url("/bang-luong/search?thang="+thang+"&nam="+nam).load();
                        $('.table').DataTable().draw();
                },
            });
}

function add(){
    var thang = $("#thang").val();
    var nam = $("#nam").val();
        $.ajax({
            type: "post",
            url: '/bang-luong/add?thang='+thang+"&nam="+nam,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            data: {thang: thang, nam: nam},
            enctype: 'multipart/form-data',
            dataType: "json",
            success: function (response) {
                if(response.code == 200){
                    notify_success(response.msg);
                    // $('#add_edit').modal('hide');
                    $('.table').DataTable().ajax.reload(null, false);
                }else{
                    notify_error(response.msg);
                    $('#add_edit').modal('hide');
                }
            }
        });
}

function edit(id){
    // var thang = $("#thang").val();
    // var nam = $("#nam").val();
    $('#add_edit').modal('show');
    $('.title-chuc-vu').html('Cập nhật bảng lương');
    $('.icons-chuc-vu .material-icons').html('edit');
    $.ajax({
        type: "get",
        url: "/bang-luong/load/"+id,
        dataType: "json",
        data: {id : id},
        success: function (response) {
            console.log(response);
            $('#phucap').val(response.data.phu_cap);
            $('#thuong').val(response.data.thuong);
            $('#ungtruoc').val(response.data.ung_truoc);
            $('#dimuon').val(response.data.phat_muon);


            url = "/bang-luong/edit/"+id;
        }
    });
}

function save(){
    $('#frm').validate({
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

function checkAll(){
    var thang = $('#thang').val();
    var nam = $('#nam').val();
    swal({
        title: 'Duyệt bảng lương',
        text: 'Bạn có chắc chắn muốn duyệt toàn bộ bảng lương tháng ' + thang + '/' + nam+'?',
        icon: 'warning',
        showCancelButton:true,
        confirmButtonText:'Đồng ý',
        cancelButtonText:'Bỏ qua',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
    }).then(function (result) {
        if (result) {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {thang: thang, nam: nam},
                url:'/bang-luong/checkall?thang='+thang+'&nam='+nam,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.code == 200) {
                        notify_success(data.msg);
                        // index = 0;
                        $(".table").DataTable().ajax.reload(null, false);
                    } else
                        notify_error(data.msg);
                },
                // error: function () {
                //     notify_error('Cập nhật không thành công');
                // }
            });
        }
    });
}
function unCheck(id){
    swal({
                title: 'Hoàn duyệt',
                text: 'Bạn có chắc chắn muốn hoàn duyệt!!',
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
                        url: "/bang-luong/uncheck/"+id,
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


function checkById(id){
    swal({
        title: 'Duyệt lương',
        text: 'Bạn có chắc chắn muốn duyệt!!',
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
                url: "/bang-luong/checkbyid/"+id,
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
