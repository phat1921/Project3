/**
 * App Calendar
 */

/**
 * ! If both start and end dates are same Full calendar will nullify the end date value.
 * ! Full calendar will end the event on a day before at 12:00:00AM thus, event won't extend to the end date.
 * ! We are getting events from a separate file named app-calendar-events.js. You can add or remove events from there.
 **/

 'use-strict';
 var date = new Date(), staffId = 0;
 var nextDay = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
 // prettier-ignore
 var nextMonth = date.getMonth() === 11 ? new Date(date.getFullYear() + 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() + 1, 1);
 // prettier-ignore
 var prevMonth = date.getMonth() === 11 ? new Date(date.getFullYear() - 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() - 1, 1);
 
 var nam = '', thang = '';
 
 var events = []
 var congid = 0;
 // RTL Support
 
 $(document).on('click', '.fc-sidebarToggle-button', function (e) {
     $('.app-calendar-sidebar, .body-content-overlay').addClass('show');
 });
 
 $(document).on('click', '.body-content-overlay', function (e) {
     $('.app-calendar-sidebar, .body-content-overlay').removeClass('show');
 });
 
 document.addEventListener('DOMContentLoaded', function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
     var calendarEl = document.getElementById('calendar'),
         eventToUpdate,
         sidebar = $('#add_edit'),
         calendarsColor = {
             0: '',
             1: 'success',
             2: 'warning',
         },
         frmCong = $('#frmCong'),
         cancelBtn = $('#cancel'),
         updateEventBtn = $('#updateEvent'),
         toggleSidebarBtn = $('.btn-toggle-sidebar'),
         // selectCong = $('#select-label'),
        //  selectStaff = $('#selectStaff'),
         date = $('#ngay'),
         checkInTime = $('#giovao'),
         checkOutTime = $('#giora'),
         // eventUrl = $('#event-url'),
         // eventGuests = $('#event-guests'),
         // eventLocation = $('#event-location'),
         // allDaySwitch = $('.allDay-switch'),
         selectAll = $('.select-all'),
         calEventFilter = $('.calendar-events-filter'),
         filterInput = $('.input-filter'),
        //  btnDeleteEvent = $('.btn-delete-event'),
         calendarEditor = $('#event-description-editor');
 
     // --------------------------------------------
     // On add new item, clear sidebar-right field fields
     // --------------------------------------------
     $('.add-event button').on('click', function (e) {
         // $('.event-sidebar').addClass('show');
         // $('.sidebar-left').removeClass('show');
         // $('.app-calendar .body-content-overlay').addClass('show');
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

    $('#idNhanVien').val(user).trigger("change");
 
     $("body").tooltip({
         selector: '[data-toggle="tooltip"]',
         container: "body",
     });
    
 
     // Event click function
    //  function eventClick(info) {
    //      eventToUpdate = info.event;
    //      if (eventToUpdate.url) {
    //          info.jsEvent.preventDefault();
    //          window.open(eventToUpdate.url, '_blank');
    //      }
    //      sidebar.modal('show');
    //      date.setDate(eventToUpdate.start, true, 'Y-m-d');
    //      congid = eventToUpdate.extendedProps.congid;
    //      checkInTime.setDate(eventToUpdate.extendedProps.checkInTime, true, 'Y-m-d');
    //      checkOutTime.setDate(eventToUpdate.extendedProps.checkOutTime, true, 'Y-m-d');
    //  }
 
     // Modify sidebar toggler
     function modifyToggler() {
        //  $('.fc-sidebarToggle-button')
        //      .empty()
        //      .append(feather.icons['menu'].toSvg({class: 'ficon'}));
     }
 
     // Selected Checkboxes
     function selectedCalendars() {
         // var selected = [];
         // $('.calendar-events-filter input:checked').each(function () {
         //     selected.push($(this).attr('data-value'));
         // });
         // return selected;
         return [1,2];
     }
 
     // --------------------------------------------------------------------------------------------------
     // AXIOS: fetchEvents
     // * This will be called by fullCalendar to fetch events. Also this can be used to refetch events.
     // --------------------------------------------------------------------------------------------------
   
     function fetchEvents(info, successCallback) {
         // Fetch Events from API endpoint reference
         /* $.ajax(
           {
             url: '../../../app-assets/data/app-calendar-events.js',
             type: 'GET',
             success: function (result) {
               // Get requested calendars as Array
               var calendars = selectedCalendars();
 
               return [result.events.filter(event => calendars.includes(event.extendedProps.calendar))];
             },
             error: function (error) {
               console.log(error);
             }
           }
         ); */
         var staffId =  $('#idNhanVien').val();
         $.ajax({
            type: "get",
            dataType: "json",
            data: {staffId: staffId, month: thang, year: nam},
            url: '/index/list',
             success: function (data) {
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
                                extendedProps: {
                                    congid: item.id,
                                    checkInTime: new Date(item.ngay + ' ' + item.gio_vao),
                                    checkOutTime: new Date(item.ngay + ' ' + item.gio_ra),
                                    calendar:1
                                }
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
                                extendedProps: {
                                    congid: item.id,
                                    checkInTime: new Date(item.date + ' ' + item.gio_vao),
                                    checkOutTime: new Date(item.date + ' ' + item.gio_ra),
                                    calendar:2
                                }
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
                     return calendars.includes(event.extendedProps.calendar);
                 });
              //   if (selectedEvents.length > 0) {
                     successCallback(selectedEvents);
                // }
             },
             error: function () {
                 notify_error('Lỗi truy xuất database');
             }
         });
 
     }
 
     // Calendar plugins
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
         eventResizableFromStart: true,
         customButtons: {
             sidebarToggle: {
                 text: 'Sidebar'
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
        //  direction: direction,
         initialDate: new Date(),
         navLinks: true, // can click day/week names to navigate views
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
        //  eventClassNames: function ({event: calendarEvent}) {
        //      const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
        //      if(calendarEvent._def.extendedProps.calendar>0) {
        //          if (colorName) {
        //              if (colorName == 'dark') {
        //                  return [
        //                      // Background Color
        //                      'bg-light-' + colorName,
        //                      'text-white',
        //                  ];
        //              } else if (colorName != '') {
        //                  return [
        //                      // Background Color
        //                      'bg-light-' + colorName
        //                  ];
        //              }
        //          } else {
        //              return [
        //                  // Background Color
        //                  'bg-light-primary',
        //                  'text-white',
        //              ];
        //          }
        //      }
        //  },
         dateClick: function (info) {

            // updateEventBtn.removeClass('d-none');
            // if(funAdd == 0) {
            //  updateEventBtn.addClass('d-none');
            // }
            $('#frmCong')[0].reset();
            if (user == 1)
             {
                 // if(baseUser==11 || user_nhan_vien==1 || user_nhan_vien==27)
                    //  eventClick(info);
                 // alert(JSON.stringify(info));
                 congid = 0;
                 var dateKeeping = moment(info.date).format('DD/MM/YYYY');
              //   if(moment(dateKeeping).unix()<=moment(date).unix()) {
                     $.ajax({
                         type: "POST",
                         dataType: "json",
                         data: {date: dateKeeping, staffId: $('#idNhanVien').val()},
                         url: '/index/checkdate',
                         success: function (data) {
                             if (data.code == '200') {
                                 // resetValues();
                                 sidebar.modal('show');
                                 // checkoutBtn.removeClass('d-none');
                                 // updateEventBtn.addClass('d-none');
                                 // btnDeleteEvent.addClass('d-none');
                                //  date.setDate(dateKeeping);

                                date.val(dateKeeping);
                                 // eventClick(info);
                             }
                         },
                         error: function () {
                             notify_error('Lỗi truy xuất database');
                         }
                     });
               //  }
             }
         },
         eventClick: function (info) {
            //  updateEventBtn.removeClass('d-none');
            //      if(funEdit == 0) {
            //      updateEventBtn.addClass('d-none');
            //      }
            $('#frmCong')[0].reset();
             if (user == 1){
                eventToUpdate = info.event;
                if (eventToUpdate.url) {
                    info.jsEvent.preventDefault();
                    window.open(eventToUpdate.url, '_blank');
                }
                sidebar.modal('show');
                date.val(eventToUpdate.start, true, 'Y-m-d');
                congid = eventToUpdate.extendedProps.congid;
                checkInTime.val(eventToUpdate.extendedProps.checkInTime, true, 'Y-m-d');
                checkOutTime.val(eventToUpdate.extendedProps.checkOutTime, true, 'Y-m-d');
             }
             
         },
         datesSet: function () {
             modifyToggler();
         },
         viewDidMount: function () {
             modifyToggler();
         }
     });
 
     // Render calendar
     calendar.render();
     // Modify sidebar toggler
     modifyToggler();
     // updateEventClass();
 
     $('#idNhanVien').on('change', function (e) {
         //calendar.removeAllEvents();
         calendar.refetchEvents();
     });
 
     // Validate add new and update form
     if (frmCong.length) {
         frmCong.validate({
             submitHandler: function (form, event) {
                 event.preventDefault();
                 if (frmCong.valid()) {
                     sidebar.modal('hide');
                 }
             },
             rules: {
                 'ngay': {required: true},
             },
             messages: {
                 'giovao': {required: 'Chọn ngày chấm công'}
             }
 
         });
     }
 
     // Sidebar Toggle Btn
        if (toggleSidebarBtn.length) {
            toggleSidebarBtn.on('click', function () {
                cancelBtn.removeClass('d-none');
            });
        }
 
     // ------------------------------------------------
     // addEvent
     // ------------------------------------------------
     function addEvent(eventData) {
         calendar.addEvent(eventData);
         calendar.refetchEvents();
     }
 
     // ------------------------------------------------
     // updateEvent
     // ------------------------------------------------
     function updateEvent(eventData) {
         var propsToUpdate = ['id', 'title', 'url'];
         var extendedPropsToUpdate = ['calendar', 'guests', 'location', 'description'];
 
         updateEventInCalendar(eventData, propsToUpdate, extendedPropsToUpdate);
     }
 
     // ------------------------------------------------
     // removeEvent
     // ------------------------------------------------
     function removeEvent(eventId) {
         removeEventInCalendar(eventId);
     }
 
     // ------------------------------------------------
     // (UI) updateEventInCalendar
     // ------------------------------------------------
     const updateEventInCalendar = (updatedEventData, propsToUpdate, extendedPropsToUpdate) => {
         const existingEvent = calendar.getEventById(updatedEventData.id);
 
         // --- Set event properties except date related ----- //
         // ? Docs: https://fullcalendar.io/docs/Event-setProp
         // dateRelatedProps => ['start', 'end', 'allDay']
         // eslint-disable-next-line no-plusplus
         for (var index = 0; index < propsToUpdate.length; index++) {
             var propName = propsToUpdate[index];
             existingEvent.setProp(propName, updatedEventData[propName]);
         }
 
         // --- Set date related props ----- //
         // ? Docs: https://fullcalendar.io/docs/Event-setDates
         existingEvent.setDates(updatedEventData.start, updatedEventData.end, {allDay: updatedEventData.allDay});
 
         // --- Set event's extendedProps ----- //
         // ? Docs: https://fullcalendar.io/docs/Event-setExtendedProp
         // eslint-disable-next-line no-plusplus
         for (var index = 0; index < extendedPropsToUpdate.length; index++) {
             var propName = extendedPropsToUpdate[index];
             existingEvent.setExtendedProp(propName, updatedEventData.extendedProps[propName]);
         }
     };
 
     // ------------------------------------------------
     // (UI) removeEventInCalendar
     // ------------------------------------------------
     function removeEventInCalendar(eventId) {
         calendar.getEventById(eventId).remove();
     }
 
     // Add new event
     $('#checkInBtn').on('click', function () {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/index/checkin",
            success: function (response) {
                if (response.code == 200) {
                    notyfi_success(response.msg);
                    calendar.refetchEvents();
                } else
                    notify_error(response.msg);
            },
           
        });
     });

     $('#checkOutBtn').on('click', function () {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/index/checkout",
            success: function (response) {
                if (response.code == 200) {
                    notyfi_success(response.msg);
                    calendar.refetchEvents();
                } else
                    notify_error(response.msg);
            },
           
        });
     });

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

    $('.timepicker').datetimepicker({
        //          format: 'H:mm',    // use this format if you want the 24hours timepicker
        format: 'H:mm ',
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

 
 
     // Update công
     updateEventBtn.on('click', function () {
         if (frmCong.valid()) {
             var datacong = {
                 id: congid,
                 staffId: $('#idNhanVien').val(),
                 date: $('#ngay').val(),
                 checkInTime: $('#giovao').val(),
                 checkOutTime: $('#giora').val()
             };
             $.ajax({
                 type: "POST",
                 dataType: "json",
                 data: datacong,
                 url:'/index/manualTimekeeping',
                 success: function (data) {
                     if (data.code == '200') {
                         calendar.refetchEvents();
                         sidebar.modal('hide');
                         notyfi_success(data.msg);
                     } else {
                         notify_error(data.msg);
                     }
 
                 },
                 error: function () {
                     notify_error('Lỗi truy xuất database');
                 }
             });
         }
         return false;
     });
 
     // Reset sidebar input values
     function resetValues() {
         checkInTime.setDate();
         checkOutTime.setDate();
         date.setDate();
        //  selectCongSang.val('').trigger('change');
        //  selectCongChieu.val('').trigger('change');
         calendarEditor.val('');
     }
 
     // When modal hides reset input values
     sidebar.on('hidden.bs.modal', function () {
         resetValues();
     });
 
     // Hide left sidebar if the right sidebar is open
     // $('.btn-toggle-sidebar').on('click', function () {
     //     btnDeleteEvent.addClass('d-none');
     //     updateEventBtn.addClass('d-none');
     //     checkoutBtn.removeClass('d-none');
     //     $('.app-calendar-sidebar, .body-content-overlay').removeClass('show');
     // });
 
     // Select all & filter functionality
     if (selectAll.length) {
         selectAll.on('change', function () {
             var $this = $(this);
 
             if ($this.prop('checked')) {
                 calEventFilter.find('input').prop('checked', true);
             } else {
                 calEventFilter.find('input').prop('checked', false);
             }
             calendar.refetchEvents();
         });
     }
 
     if (filterInput.length) {
         filterInput.on('change', function () {
             $('.input-filter:checked').length < calEventFilter.find('input').length
                 ? selectAll.prop('checked', false)
                 : selectAll.prop('checked', true);
             calendar.refetchEvents();
         });
     }
 });

function notyfi_success(msg){
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
 