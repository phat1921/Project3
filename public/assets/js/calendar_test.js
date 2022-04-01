$(document).ready(function () {
    var events = []
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "GET",
        dataType: "json",
        async: false,
        url: "/tai-khoan/staff",
        success: function (data) {
            var html = '';
            data.forEach(function (element, index) {
                // if (element.selected == true)
                //     var select = 'selected';
                html += `<option value="${element.id}">${element.text}</option> `;
            });
            $('#idNhanVien').html(html);
        },
    });
    var staffId = $('#idNhanVien').val(user).trigger("change");
    
    var calendar = $('#calendar').fullCalendar({
        header:{
            left:'prev,next today',
            center:'title',
            right:'month,agendaWeek,agendaDay'
        },
        events: function(){
            console.log(staffId);
            // var start = $.fullCalendar.formatDate(start, 'Y-MM-DD');
            // var end = $.fullCalendar.formatDate(end, 'Y-MM-DD ');
             $.ajax({
            
            type: "get",
            dataType: "json",
            // data: {staffId: staffId, start: start, end: end},
            url: '/index/list',
            success: function (data) {
                console.log(data);
                events = [];
                if (data) {
                    var i = 0;
                    data.forEach(function (item) {
                       if (item.gio_vao != '00:00:00' ) {
                            arr = {
                                id: item.id,
                                title: "Giờ vào",
                                start: new Date(item.ngay + ' ' + item.gio_vao),
                                end: new Date(item.ngay + ' ' + item.gio_vao),
                                allDay: false,
                                // extendedProps: {
                                //     congid: item.id,
                                //     checkInTime: new Date(item.ngay + ' ' + item.gio_vao),
                                //     checkOutTime: new Date(item.ngay + ' ' + item.gio_ra),
                                //     calendar:1
                                // }
                            };
                            events.push(arr);
                            i++;
                      }
                       if (item.gio_ra != '00:00:00') {
                            arr = {
                                id: item.id,
                                title: "Giờ ra",
                                start: new Date(item.ngay + ' ' + item.gio_ra),
                                end: new Date(item.ngay + ' ' + item.gio_ra),
                                allDay: false,
                                // extendedProps: {
                                //     congid: item.id,
                                //     checkInTime: new Date(item.date + ' ' + item.gio_vao),
                                //     checkOutTime: new Date(item.date + ' ' + item.gio_ra),
                                //     calendar:2
                                // }
                            };
                            events.push(arr);
                            i++;
                       }
                    })
                }
            },
            error: function () {
                notify_error('Lỗi truy xuất database');
            }
        });
    },
        selectable:true,
        selectHelper: true,
        dayMaxEvents: 2,
        eventLimit: true,
        // select:function(start, end, allDay)
        // {
        //     var title = prompt('Event Title:');

        //     if(title)
        //     {
        //         var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');

        //         var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

        //         $.ajax({
        //             url:"/full-calender/action",
        //             type:"POST",
        //             data:{
        //                 title: title,
        //                 start: start,
        //                 end: end,
        //                 type: 'add'
        //             },
        //             success:function(data)
        //             {
        //                 calendar.fullCalendar('refetchEvents');
        //                 alert("Event Created Successfully");
        //             }
        //         })
        //     }
        // },
        editable:true,
        // eventResize: function(event, delta)
        // {
        //     var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
        //     var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
        //     var title = event.title;
        //     var id = event.id;
        //     $.ajax({
        //         url:"/full-calender/action",
        //         type:"POST",
        //         data:{
        //             title: title,
        //             start: start,
        //             end: end,
        //             id: id,
        //             type: 'update'
        //         },
        //         success:function(response)
        //         {
        //             calendar.fullCalendar('refetchEvents');
        //             alert("Event Updated Successfully");
        //         }
        //     })
        // },
        // eventDrop: function(event, delta)
        // {
        //     var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
        //     var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
        //     var title = event.title;
        //     var id = event.id;
        //     $.ajax({
        //         url:"/full-calender/action",
        //         type:"POST",
        //         data:{
        //             title: title,
        //             start: start,
        //             end: end,
        //             id: id,
        //             type: 'update'
        //         },
        //         success:function(response)
        //         {
        //             calendar.fullCalendar('refetchEvents');
        //             alert("Event Updated Successfully");
        //         }
        //     })
        // },

        // eventClick:function(event)
        // {
        //     if(confirm("Are you sure you want to remove it?"))
        //     {
        //         var id = event.id;
        //         $.ajax({
        //             url:"/full-calender/action",
        //             type:"POST",
        //             data:{
        //                 id:id,
        //                 type:"delete"
        //             },
        //             success:function(response)
        //             {
        //                 calendar.fullCalendar('refetchEvents');
        //                 alert("Event Deleted Successfully");
        //             }
        //         })
        //     }
        // }
        
    });
    
    function fetchEvent(){ 
        // var staffId =  $('#idNhanVien').val();
        // var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD');
        // var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD ');
        // console.log(start, end);
        
        $.ajax({
            type: "get",
            dataType: "json",
            // data: {staffId: staffId, start: start, end: end},
            url: '/index/list',
            success: function (data) {
                console.log(data);
                events = [];
                if (data.data) {
                    let i = 0;
                    data.data.forEach(function (item) {
                       if (item.gio_vao != '00:00:00' ) {
                            arr = {
                                id: item.id,
                                title: "Giờ vào",
                                start: new Date(item.ngay + ' ' + item.gio_vao),
                                end: new Date(item.ngay + ' ' + item.gio_vao),
                                allDay: false,
                                // extendedProps: {
                                //     congid: item.id,
                                //     checkInTime: new Date(item.ngay + ' ' + item.gio_vao),
                                //     checkOutTime: new Date(item.ngay + ' ' + item.gio_ra),
                                //     calendar:1
                                // }
                            };
                            events.push(arr);
                            i++;
                      }
                       if (item.gio_ra != '00:00:00') {
                            arr = {
                                id: item.id,
                                title: "Giờ ra",
                                start: new Date(item.ngay + ' ' + item.gio_ra),
                                end: new Date(item.ngay + ' ' + item.gio_ra),
                                allDay: false,
                                // extendedProps: {
                                //     congid: item.id,
                                //     checkInTime: new Date(item.date + ' ' + item.gio_vao),
                                //     checkOutTime: new Date(item.date + ' ' + item.gio_ra),
                                //     calendar:2
                                // }
                            };
                            events.push(arr);
                            i++;
                       }
                    })
                }
            },
            error: function () {
                notify_error('Lỗi truy xuất database');
            }
        });
    }

});



function checkIn(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/index/checkin",
        success: function (response) {
            if (response.code == 200) {
                notify_success(response.msg);
            } else
                notify_error(response.msg);
        },
       
    });
}

function checkOut(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/index/checkout",
        success: function (response) {
            if (response.code == 200) {
                notify_success(response.msg);
            } else
                notify_error(response.msg);
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