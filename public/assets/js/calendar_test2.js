'use-strict';
var date = new Date();
var nextDay = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
// prettier-ignore
var nextMonth = date.getMonth() === 11 ? new Date(date.getFullYear() + 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() + 1, 1);
// prettier-ignore
var prevMonth = date.getMonth() === 11 ? new Date(date.getFullYear() - 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() - 1, 1);

var nam = '', thang = '';

var events = [];
document.addEventListener('DOMContentLoaded', function() {
$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
    var calendarEl = document.getElementById('calendar');
    calendarsColor = {
        0: '',
        1: 'success',
        2: 'warning',
    },
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

    $('#idNhanVien').val(user).trigger("change");

    

    function selectedCalendars() {
        // var selected = [];
        // $('.calendar-events-filter input:checked').each(function () {
        //     selected.push($(this).attr('data-value'));
        // });
        // return selected;
        return [1,2];
    }

    function fetchEvents(info, successCallback) {
    var staffId =  $('#idNhanVien').val();
        $.ajax({
            type: "get",
            dataType: "json",
            data: {staffId: staffId, month: thang, year: nam},
            url: '/index/list',
            success: function (data) {
                console.log(data);
                // return;
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
                    var calendars = selectedCalendars();
                    // We are reading event object from app-calendar-events.js file directly by including that file above app-calendar file.
                    // You should make an API call, look into above commented API call for reference
                    selectedEvents = events.filter(function (event) {
                        // console.log(event.extendedProps.calendar.toLowerCase());
                        return calendars.includes(event.calendar);
                    });
                 //   if (selectedEvents.length > 0) {
                        successCallback(selectedEvents);
            },
            
            error: function () {
                notify_error('Lỗi truy xuất database');
            }
        });
    
    };

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'vi',
        events: fetchEvents,
        eventOrder : "id",
        eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        },
        //hiddenDays: [ 0 ],
        firstDay: 1,
        editable: false,
        dragScroll: true,
        dayMaxEvents: 2,
        initialDate: new Date(),
        eventResizableFromStart: true,
        customButtons: {
            sidebarToggle: {
                text: 'Sidebar'
            }
        },
        customButtons: {
            prev: {
                text: 'Prev',
                click: function (e) {
                    let oldd = new Date(calendar.getDate());
                    let oldmonth = '' + (oldd.getMonth() + 1);
                    if (oldmonth.length == 1)
                        oldmonth = "0" + oldmonth;
                    let oldyear = oldd.getFullYear();
                    let olddate = oldyear + "-" + oldmonth;
                    calendar.prev();
                    let d = new Date(calendar.getDate());
                    thang = '' + (d.getMonth() + 1);
                    if (thang.length == 1)
                        thang = "0" + thang;
                    nam = d.getFullYear();
                    let newdate = nam + "-" + thang;
                    if (newdate != olddate)
                        calendar.refetchEvents();

                }
            },
            next: {
                text: 'Next',
                click: function () {
                    let oldd = new Date(calendar.getDate());
                    let oldmonth = '' + (oldd.getMonth() + 1);
                    if (oldmonth.length == 1)
                        oldmonth = "0" + oldmonth;
                    let oldyear = oldd.getFullYear();
                    let olddate = oldyear + "-" + oldmonth;
                    calendar.next();
                    let d = new Date(calendar.getDate());
                    thang = '' + (d.getMonth() + 1);
                    if (thang.length == 1)
                        thang = "0" + thang;
                    nam = d.getFullYear();
                    let newdate = nam + "-" + thang;
                    if (newdate != olddate)
                        calendar.refetchEvents();
                }
            },
        },
        eventClassNames: function ({event: calendarEvent}) {
            const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
            if(calendarEvent._def.extendedProps.calendar>0) {
                if (colorName) {
                    if (colorName == 'dark') {
                        return [
                            // Background Color
                            'bg-light-' + colorName,
                            'text-white',
                        ];
                    } else if (colorName != '') {
                        return [
                            // Background Color
                            'bg-light-' + colorName
                        ];
                    }
                } else {
                    return [
                        // Background Color
                        'bg-light-primary',
                        'text-white',
                    ];
                }
            }
        },
        headerToolbar: {
            start: 'sidebarToggle, prev,next, title',
            // end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            end: 'dayGridMonth,listMonth'
        },
        buttonText: {
            month: "Tháng",
            list: "Danh sách"
          },
          noEventsText: "Không có bản ghi nào",
    });
    calendar.render();
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