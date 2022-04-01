var nam = '', thang = '';
var events = []

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $calendar = $('#fullCalendar');
    today = new Date();
    // y = today.getFullYear();
    // m = today.getMonth();
    // d = today.getDate();
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
     var calendar = $calendar.fullCalendar({
        // viewRender: function(view, element) {
        //     // We make sure that we activate the perfect scrollbar when the view isn't on Month
        //     if (view.name != 'month') {
        //         $(element).find('.fc-scroller').perfectScrollbar();
        //     }
        // },
        
        events: fetchEvents(),
        header: {
            left: 'title',
            center: 'month,agendaWeek,agendaDay',
            right: 'prev,next,today'
        },
        eventOrder : "id",
        firstDay: 1,
        editable: false,
        dragScroll: true,
        dayMaxEvents: 2,
        eventResizableFromStart: true,
        defaultDate: today,
        selectable: true,
        selectHelper: true,
        views: {
            month: { // name of view
                titleFormat: 'MMMM YYYY'
                // other view-specific options here
            },
            week: {
                titleFormat: " MMMM D YYYY"
            },
            day: {
                titleFormat: 'D MMM, YYYY'
            }
        },
        customButtons: {
            prev: {
                text: 'Prev',
                click: function (e) {
                   var tglCurrent = calendar.fullCalendar('getDate')
                    let oldd = new Date(moment(tglCurrent).format('YYYY-MM-DD'));
                    let oldmonth = '' + (oldd.getMonth() + 1);
                    if (oldmonth.length == 1)
                        oldmonth = "0" + oldmonth;
                    let oldyear = oldd.getFullYear();
                    let olddate = oldyear + "-" + oldmonth;
                    calendar.fullCalendar('prev');
                    var tglpre =  calendar.fullCalendar('getDate');
                    let d = new Date(moment(tglpre).format('YYYY-MM-DD'));
                    thang = '' + (d.getMonth() + 1);
                    if (thang.length == 1)
                        thang = "0" + thang;
                    nam = d.getFullYear();
                    let newdate = nam + "-" + thang;
                
                    if (newdate != olddate)
                    calendar.fullCalendar('refetchEvents');

                }
            },
            next: {
                text: 'Next',
                click: function () {
                    var tglCurrent =  calendar.fullCalendar('getDate')
                    let oldd = new Date(moment(tglCurrent).format('YYYY-MM-DD'));
                    let oldmonth = '' + (oldd.getMonth() + 1);
                    if (oldmonth.length == 1)
                        oldmonth = "0" + oldmonth;
                    let oldyear = oldd.getFullYear();
                    let olddate = oldyear + "-" + oldmonth;
                    calendar.fullCalendar('next');
                    var tglpre =  calendar.fullCalendar('getDate');
                    let d = new Date(moment(tglpre).format('YYYY-MM-DD'));
                    thang = '' + (d.getMonth() + 1);
                    if (thang.length == 1)
                        thang = "0" + thang;
                    nam = d.getFullYear();
                    let newdate = nam + "-" + thang;
                    if (newdate != olddate)
                    calendar.fullCalendar('refetchEvents');
                }
            },
        },

        // select: function(start, end) {

        //     // on select we show the Sweet Alert modal with an input
        //     swal({
        //         title: 'Create an Event',
        //         html: '<div class="form-group">' +
        //             '<input class="form-control" placeholder="Event Title" id="input-field">' +
        //             '</div>',
        //         showCancelButton: true,
        //         confirmButtonClass: 'btn btn-success',
        //         cancelButtonClass: 'btn btn-danger',
        //         buttonsStyling: false
        //     }).then(function(result) {

        //         var eventData;
        //         event_title = $('#input-field').val();

        //         if (event_title) {
        //             eventData = {
        //                 title: event_title,
        //                 start: start,
        //                 end: end
        //             };
        //             $calendar.fullCalendar('renderEvent', eventData, true); // stick? = true
        //         }

        //         $calendar.fullCalendar('unselect');

        //     });
        // },
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        
        
        // color classes: [ event-blue | event-azure | event-green | event-orange | event-red ]
        
    });
    
    function fetchEvents(info, successCallback) {
        console.log(nam, thang);
       var staffId =  $('#idNhanVien').val();
        $.ajax({
            type: "get",
            dataType: "json",
            data: {staffId: staffId, year: nam, month: thang},
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
                 selectedCalendars();
                // We are reading event object from app-calendar-events.js file directly by including that file above app-calendar file.
                // You should make an API call, look into above commented API call for reference
                // selectedEvents = events.filter(function (event) {
                    // console.log(event.extendedProps.calendar.toLowerCase());
                    // return calendars.includes(event.extendedProps.calendar);
                // });
             //   if (selectedEvents.length > 0) {
                    // successCallback(selectedEvents);
            },
            error: function () {
                notify_error('Lỗi truy xuất database');
            }
        });
    
    };
    calendar.render();
    function selectedCalendars() {
        // var selected = [];
        // $('.calendar-events-filter input:checked').each(function () {
        //     selected.push($(this).attr('data-value'));
        // });
        // return selected;
        return [1,2];
    };
    calendar.fullCalendar('render');
   
})

 


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