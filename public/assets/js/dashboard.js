var url ='';
$(window).on('load', function () {
    'use strict';
    window.colors = {
        solid: {
          primary: '#7367F0',
          secondary: '#82868b',
          success: '#28C76F',
          info: '#00cfe8',
          warning: '#FF9F43',
          danger: '#EA5455',
          dark: '#4b4b4b',
          black: '#000',
          white: '#fff',
          body: '#f8f8f8'
        },
        light: {
          primary: '#7367F01a',
          secondary: '#82868b1a',
          success: '#28C76F1a',
          info: '#00cfe81a',
          warning: '#FF9F431a',
          danger: '#EA54551a',
          dark: '#4b4b4b1a'
        }
      };
    var $statisticsProfitChart = document.querySelector('#statistics-profit-chart');
    var statisticsProfitChartOptions;
    var statisticsProfitChart;
    var $trackBgColor = '#EBEBEB';
    var arrMonth = [];

    statisticsProfitChartOptions = {
        chart: {
            height: 90,
            type: 'line',
            toolbar: {
              show: false
            },
            zoom: {
              enabled: false
            }
          },
          grid: {
            borderColor: $trackBgColor,
            strokeDashArray: 5,
            xaxis: {
              lines: {
                show: true
              }
            },
            yaxis: {
              lines: {
                show: false
              }
            },
            padding: {
              top: -10,
              bottom: -5
            }
          },
          stroke: {
            width: 3
          },
          colors: [window.colors.solid.info],
          series: [
            {
              name: "Số khách hàng mới",
              data: [1, 3, 2, 0, 5, 9, 10, 7, 1],
            }
          ],
          markers: {
            colors: window.colors.solid.info,
            strokeColors: window.colors.solid.info,
            strokeWidth: 2,
            strokeOpacity: 1,
            strokeDashArray: 0,
            fillOpacity: 1,
            discrete: [
              {
                seriesIndex: 0,
                dataPointIndex: 5,
                fillColor: '#ffffff',
                strokeColor: window.colors.solid.info,
                size: 5
              }
            ],
            shape: 'circle',
            radius: 2,
            hover: {
              size: 3
            }
          },
          xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            labels: {
              show: true,
              style: {
                fontSize: '0px'
              }
            },
            axisBorder: {
              show: false
            },
            axisTicks: {
              show: false
            }
          },
          yaxis: {
            show: false
          },
          tooltip: {
            x: {
              show: false
            }
          }
      };
      statisticsProfitChart = new ApexCharts($statisticsProfitChart, statisticsProfitChartOptions);
      statisticsProfitChart.render();
});    
$(document).ready(function () {
    "use strict";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if($('.table').length){
       $('.table').DataTable({
           ajax: "/dashboard/list",
           processing:true,
           columns: [
               {data: "loai_hop_dong"},
               {data: "ten_nv"},
               {data: "ngay_ket_thuc"},
               {},
           ],
           columnDefs: [
            
            {
                targets: -1,
                title:'Thao tác',
                class:'td-actions text-center',
                // orderable: false,
                render: function (data, type, full, meta) {
                   
                    var html = ''; 
                    
                        html += '<button rel="tooltip" class="btn btn-success" title="Chỉnh sửa" onclick="edit(' + full['id_hd'] + ')">';
                        html += '<i class="material-icons">edit</i>';
                        html += '</button>&nbsp';
                    return html;
                
                },
                width: 100,
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
        format: 'YYYY-MM-DD',
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
   
// function add(){
//     $('#frm')[0].reset();
//     $('#add_edit').modal('show');
//     $('.title-hop-dong').html('Thêm hợp đồng mới');
//     $('.icons-hop-dong .material-icons').html('add');
//     $('#name').val();
//     $('#salary').val(); 
//     $('#frm')[0].reset();
//     url = "/hop-dong/add";

// }

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
            $('#startday').val(response.data.ngay_bat_dau);
            $('#endday').val(response.data.ngay_ket_thuc);
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