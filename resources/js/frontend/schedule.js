
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('scheduleCalendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: locale,
        initialView: 'dayGridMonth',
        allDaySlot: false,
        height: 'auto',
        editable: false,
        selectable: true,
        validRange: {
            start: moment().format('YYYY-MM-DD')
        },
        select: function(start, end, jsEvent, view) {
            $(".fc-day-today ").removeClass("fc-day-today ")
           var todayDate = start.startStr;
           classList('', todayDate);
        },
        selectMirror: true,
        nowIndicator: true,
        headerToolbar: {
            left:   'prev',
            center: 'title',
            right:  'next'
        },
        events: availableDates        
    });

    calendar.render();
});


window.classList = function classList(url = '', date = '', calender_type = '') {
    
    var class_type = $("#classType").val();
    if (url == '') {
        url = process.env.MIX_APP_URL + '/classes/schedules/list?calender_type='+calender_type;
    }

    $.ajax({
        url: url,
        data: { date:date, class_type:class_type, tutor:tutor },
        type: "GET",
        success: function (response) {
            $("#classList").html(response.data);
        },
        error: function (data) {
            handleError(data);
        },
    });
};
classList();

// hijiri calender
var calHj = $.calendars.instance('ummalqura', 'ar');
$(function() {
    $('#pickCalHj').calendarsPicker($.extend({
        calendar: calHj,
        inline:true,
        dateFormat: 'dd/mm/yyyy',
        minDate: 0,
        onSelect: function (date) {
            setTimeout(removeClass, 0);
           
            let dates = convertDtFromHijriToGer(date);
            classList('',dates, 'hijri');
        }
    },
        $.calendarsPicker.regionalOptions['ar'])
    );
    		
});


$(document).on('click', '.calendar-event', function() {
    var type = $(this).attr('data-calender-type');
    $('.calendar-event').removeClass('active');
    $(this).addClass('active');
    if(type === "georgian") {
       $("#scheduleCalendar").show(); 
       $("#pickCalHj").hide();

    } else {
        $("#scheduleCalendar").hide(); 
        $("#pickCalHj").show(); 
    }
    classList('', '', type);
});


// For hijri calender
window.activeEvents = function activeEvents( allDate ) {
    $(".block-event").remove();
    var custom_arr1 = [];
    $( allDate ).each( function ( index, value ) {
        var newDate = convertDtFromGerToHijri(value.start);
        custom_arr1.push( newDate );
    } );

    $("#pickCalHj table tbody tr td").each( function ( index, value ) {
        var val = $(this).find('a').text();
        if (val) {
          
            let month = $("#pickCalHj .calendars-month-year").val();
            
            if ( $.inArray(val+'/'+month, custom_arr1 ) > -1 ) {
                $(this).append('<div class="block-event"></div>');
			}
        }
       
    } );
   
}

setInterval(addActiveEvents, 100);
function addActiveEvents() {
    activeEvents(availableDates);
}

function removeClass() {
    $('.calendars-today').removeClass('calendars-today');
}

 