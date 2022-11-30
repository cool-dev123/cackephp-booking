/*
 * webroot/js/ready.js
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */

// JavaScript Document
jQuery(document).ready(function($) {
    cal = ics();
    // page is now ready, initialize the calendar...
    $('#calendar').fullCalendar({
        header: {
                left: 'prev,next today',
                center: 'title',
                right: ''
                //right: 'month,agendaWeek,agendaDay'
            },
        defaultView: 'month',
        firstDay: 1,
        fixedWeekCount: false,
        scrollTime: "08:00:00",
        eventLimit: true, // for all non-agenda views
        aspectRatio: 2,
        editable: false,
        events: 'events/feed.json',
        eventRender: function(event, element) {
            cal.addEvent(event.title, event.details, '', event.start, event.start);
            /*element.qtip({
                prerender: true,
                content: {
                    text: event.details,
                    button: true
                },
                position: {
                    my: 'bottom center',
                    at: 'top center',
                    target: 'mouse',
                    adjust: {
                        mouse: false,
                        scroll: false
                    },
                    viewport: $(window)
                },
                 style: {
                     name: 'light',
                     tooltip: 'top left'
                 }
                show: 'click',
                hide: false,
                style: 'qtip-light'
            });*/

            element.click(function() {
                element.attr('href', 'javascript:void(0);');
                $("#event_details").html(event.details);
				$("#myModalLabel").html(event.title);
				$('#eventContent').modal('show');

            });

        },
        eventDragStart: function(event) {
            $(this).qtip("destroy");
        },
        eventDrop: function(event, delta, revertFunc) {
            var newDate = [];
            var startdate = new Date(event.start);
            var startyear = startdate.getFullYear();
            var startday = startdate.getDate();
            var startmonth = startdate.getMonth() + 1;
            var starthour = startdate.getHours();
            var startminute = startdate.getMinutes();
            var enddate = new Date(event.end);
            var endyear = enddate.getFullYear();
            var endday = enddate.getDate();
            var endmonth = enddate.getMonth() + 1;
            var endhour = enddate.getHours();
            var endminute = enddate.getMinutes();
            if (event.allDay == true) {
                var allday = 1;
            } else {
                var allday = 0;
            }
            var newDate = {};
            newDate['start'] = startyear + "-" + startmonth + "-" + startday + " " + starthour + ":" + startminute + ":00";
            newDate['end'] = endyear + "-" + endmonth + "-" + endday + " " + endhour + ":" + endminute + ":00";
            newDate['allday'] = allday;
            var url = "events/update/" + event.id;
            $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: JSON.stringify(newDate),
                    contentType: "application/json; charset=utf-8"
                })
                .done(function(data) {
                    console.log(data);
                })
                .fail(function(data) {
                    console.log(data);
                });
            //$.post(url, function (data){});
        },
        eventResizeStart: function(event) {
            $(this).qtip("destroy");
        },
        eventResize: function(event) {
            var startdate = new Date(event.start);
            var startyear = startdate.getFullYear();
            var startday = startdate.getDate();
            var startmonth = startdate.getMonth() + 1;
            var starthour = startdate.getHours();
            var startminute = startdate.getMinutes();
            var enddate = new Date(event.end);
            var endyear = enddate.getFullYear();
            var endday = enddate.getDate();
            var endmonth = enddate.getMonth() + 1;
            var endhour = enddate.getHours();
            var endminute = enddate.getMinutes();
            var url = "events/update?id=" + event.id + "&start=" + startyear + "-" + startmonth + "-" + startday + " " + starthour + ":" + startminute + ":00&end=" + endyear + "-" + endmonth + "-" + endday + " " + endhour + ":" + endminute + ":00";
            $.post(url, function(data) {});
        }
    })

    //Call a function to implement read more
    //read_more();
    /*setTimeout(function(){
        read_more();
    }, 3000);*/

});


function read_more()
{
    alert('called');
    // Configure/customize these variables.
    var showChar = 100;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more >";
    var lesstext = "Show less";


    $('.more').each(function() {
        var content = $(this).html();
        alert("Length = "+content.length);
        if(content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
}
