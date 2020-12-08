/*=========================================================================================
    File Name: fullcalendar.js
    Description: Fullcalendar
    --------------------------------------------------------------------------------------
    Item name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

document.addEventListener('DOMContentLoaded', function () {

  // color object for different event types
  var colors = {
    primary: "#7367f0",
    success: "#28c76f",
    danger: "#ea5455",
    warning: "#ff9f43"
  };

  // chip text object for different event types
  var categoryText = {
    primary: "Others",
    success: "Business",
    danger: "Personal",
    warning: "Work"
  };
  var categoryBullets = $(".cal-category-bullets").html(),
    evtColor = "",
    eventColor = "";

  // calendar init
  var calendarEl = document.getElementById('fc-default');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: ["dayGrid", "timeGrid", "interaction"],
    header: {
      center: "dayGridMonth,timeGridWeek,timeGridDay",
      right: "prev,title,next"
    },
    displayEventTime: false,
    navLinks: true,
    editable: true,
    allDay: true,
    navLinkDayClick: function (date) {
      const day = date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear()
      getChecksByDay(day)
      $(".modal-calendar").modal("show");
    },
    dateClick: function (info) {
      $(".modal-calendar #cal-start-date").val(info.dateStr).attr("disabled", true);
      $(".modal-calendar #cal-end-date").val(info.dateStr);
      const day = info.date.getDate()+"/"+(info.date.getMonth()+1)+"/"+info.date.getFullYear()
      getChecksByDay(day)
    },
  });

  // render calendar
  $.ajax({
    dataType: 'json',
    url: location.origin+"/checks/calendar",
    success: function (res) {
      res.data.forEach((check, index, array) => {
        calendar.addEvent({
          id: index,
          title: check.user,
          start: check.start,
          end: check.end,
          description: check.user.name+" chegou ás "+check.start+" e saiu às "+check.end,
          color: colors.primary,
          dataEventColor: "blue"
        });
      })
    },
    error: function (res) {
      console.log(res.message)
    }
  })

  calendar.render();

  // appends bullets to left class of header
  $("#basic-examples .fc-right").append(categoryBullets);

  // Close modal on submit button
  $(".modal-calendar .cal-submit-event").on("click", function () {
    $(".modal-calendar").modal("hide");
  });

  // Remove Event
  $(".remove-event").on("click", function () {
    var removeEvent = calendar.getEventById('newEvent');
    removeEvent.remove();
  });


  // reset input element's value for new event
  if ($("td:not(.fc-event-container)").length > 0) {
    $(".modal-calendar").on('hidden.bs.modal', function (e) {
      $('.modal-calendar .form-control').val('');
    })
  }

  // remove disabled attr from button after entering info
  $(".modal-calendar .form-control").on("keyup", function () {
    if ($(".modal-calendar #cal-event-title").val().length >= 1) {
      $(".modal-calendar .modal-footer .btn").removeAttr("disabled");
    }
    else {
      $(".modal-calendar .modal-footer .btn").attr("disabled", true);
    }
  });

  // open add event modal on click of day
  $(document).on("click", ".fc-day", function () {
    $(".modal-calendar").modal("show");
    $(".calendar-dropdown .dropdown-menu").find(".selected").removeClass("selected");
    $(".modal-calendar .cal-submit-event").addClass("d-none");
    $(".modal-calendar .remove-event").addClass("d-none");
    $(".modal-calendar .cal-add-event").removeClass("d-none");
    $(".modal-calendar .cancel-event").removeClass("d-none");
    $(".modal-calendar .add-category .chip").remove();
    $(".modal-calendar .modal-footer .btn").attr("disabled", true);
    evtColor = colors.primary;
    eventColor = "primary";
  });

  // change chip's and event's color according to event type
  $(".calendar-dropdown .dropdown-menu .dropdown-item").on("click", function () {
    var selectedColor = $(this).data("color");
    evtColor = colors[selectedColor];
    eventTag = categoryText[selectedColor];
    eventColor = selectedColor;

    // changes event color after selecting category
    $(".cal-add-event").on("click", function () {
      calendar.addEvent({
        color: evtColor,
        dataEventColor: eventColor,
        className: eventColor
      });
    })

    $(".calendar-dropdown .dropdown-menu").find(".selected").removeClass("selected");
    $(this).addClass("selected");

    // add chip according to category
    $(".modal-calendar .chip-wrapper .chip").remove();
    $(".modal-calendar .chip-wrapper").append($("<div class='chip chip-" + selectedColor + "'>" +
      "<div class='chip-body'>" +
      "<span class='chip-text'> " + eventTag + " </span>" +
      "</div>" +
      "</div>"));
  });

  // calendar add event
  $(".cal-add-event").on("click", function () {
    $(".modal-calendar").modal("hide");
    var eventTitle = $("#cal-event-title").val(),
      startDate = $("#cal-start-date").val(),
      endDate = $("#cal-end-date").val(),
      eventDescription = $("#cal-description").val(),
      correctEndDate = new Date(endDate);
    calendar.addEvent({
      id: "newEvent",
      title: eventTitle,
      start: startDate,
      end: correctEndDate,
      description: eventDescription,
      color: evtColor,
      dataEventColor: eventColor,
      allDay: true
    });
  });

  // date picker
  $(".pickadate").pickadate({
    format: 'yyyy-mm-dd'
  });
});

function getChecksByDay(day){
  $("#cal-modal").text("Eventos do dia "+day)
  $.ajax({
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: location.origin+"/checks/everyone?at="+day,
    success: function (res) {
      $(".modal-body").html("")
      if (res.data.data.length > 0) {
        res.data.data.forEach(check => {
          $(".modal-body").append("<p><strong>"+check.user.name+"</strong> chegou às <strong>"+check.start+"</strong> e saiu às <strong>"+check.end+"</strong></p>")
        })
      } else {
        $(".modal-body").append("<p><strong>Nenhum</strong> evento aconteceu hoje</p>")
      }
    },
    error: function (res) {
      toastr.error(res.message)
    }
  })
}
