<?php echo $this->Html->css(array('jquery.weekcalendar'));?>
<?php echo $this->Html->script(array('jquery1.3.2.min', 'jquery1.7.2-ui.min', 'jquery.weekcalendar')); ?>
<script type='text/javascript'>
   $(document).ready(function() {
   var $calendar = $('#calendar');
   var id = 10;
   $calendar.weekCalendar({
      timeslotsPerHour : 4,
      allowCalEventOverlap : false,
      overlapEventsSeparate: false,
      firstDayOfWeek : <?php if($showCalendarDay == 1)  echo date("w"); else echo "1"; ?>,
      businessHours :{start: 1, end: 24, limitDisplay: true },
      daysToShow : <?php echo $showCalendarDay; ?>,
      <?php if($showCalendarDay == 1) { ?>
      buttonText : {
            today : "Today",
            lastWeek : "Previous Day",
            nextWeek : "Next Day"
            
         },
      <?php } else { ?>
       buttonText : {
            today : "Today",
            lastWeek : "Previous Week",
            nextWeek : "Next Week"
            
         },
      <?php } ?>
      height : function($calendar) {
         return $(window).height() - $("h1").outerHeight() - 1;
      },
      eventRender : function(calEvent, $event) {
          if (calEvent.end.getTime() < new Date().getTime()) {
               $event.css({"backgroundColor": "red"});
	  }
	  if (calEvent.end.getTime() > new Date().getTime()) {
                $event.css({"backgroundColor": "green"});
	  }
	  if (calEvent.end.getDate() == new Date().getDate()) {
                $event.css({"backgroundColor": "yellow", "color": "black"});
	  }
        $event.find(".wc-title").attr('title', calEvent.purpose);
        $event.find(".wc-title").html(calEvent.purpose);
      },
      draggable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
      resizable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
      eventNew : function(calEvent, $event) {
         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var purposeField = $dialogContent.find("textarea[name='purpose']");
                  
         $dialogContent.dialog({
            modal: true,
            title: "Staff Schedule",
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               Save : function() {
                  calEvent.id = id;
                  id++;
                  var scheduledate = new Date(startField.val()).getFullYear()+"-"+eval(new Date(startField.val()).getMonth()+1)+"-"+new Date(startField.val()).getDate();
                  var schedule_starttime = new Date(startField.val()).getHours()+":"+new Date(startField.val()).getMinutes();
                  var schedule_endtime = new Date(endField.val()).getHours()+":"+new Date(endField.val()).getMinutes();
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  //calEvent.purpose = purposeField.val();
                   var regX = /\n/gi ;
                  purposefield = new String(purposeField.val());
                  purposefield = purposefield.replace(regX, "<br />");

                  var userid = $('#userid').val();
                  $('#busy-indicator').show();
                  var data = 'userid=' + userid +'&scheduledate=' + scheduledate +'&starttime=' + schedule_starttime + '&endtime=' + schedule_endtime  + '&purpose=' + purposefield;
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "staff_plans", "action" => "saveStaffEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) { $('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "staff_plans", "action" => "staff_event", $staffData['User']['id'], $showCalendarDay));?>";  } });
                  $('#busy-indicator').show();
                  $calendar.weekCalendar("removeUnsavedEvents");
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               Cancel : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));

      },
      eventDrop : function(calEvent, $event) {
      },
      eventResize : function(calEvent, $event) {
      },
      eventClick : function(calEvent, $event) {

         if (calEvent.readOnly) {
            return;
         }
         
         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var purposeField = $dialogContent.find("textarea[name='purpose']");
         
         var ss = calEvent.purpose;
         purposeField.val(ss.replace(/<br \/>/gi, "\n")); 

         $dialogContent.dialog({
            modal: true,
            title: "Edit Staff Schedule",
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               Save : function() {
                  var scheduledate = new Date(startField.val()).getFullYear()+"-"+eval(new Date(startField.val()).getMonth()+1)+"-"+new Date(startField.val()).getDate();
                  var schedule_starttime = new Date(startField.val()).getHours()+":"+new Date(startField.val()).getMinutes();
                  var schedule_endtime = new Date(endField.val()).getHours()+":"+new Date(endField.val()).getMinutes();
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  var regX = /\n/gi ;
                  purposefield = new String(purposeField.val());
                  purposefield = purposefield.replace(regX, "<br />");

                  var userid = $('#userid').val();
                  $('#busy-indicator').show();
                  var data = 'id=' + calEvent.id +'&userid=' + userid +'&scheduledate=' + scheduledate +'&starttime=' + schedule_starttime + '&endtime=' + schedule_endtime + '&purpose=' + purposefield;
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "staff_plans", "action" => "updateStaffEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) {  $('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "staff_plans", "action" => "staff_event", $staffData['User']['id'], $showCalendarDay));?>"; } });
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               "Delete" : function() {
                  var data = 'id=' + calEvent.id;
                  $('#busy-indicator').show();
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "staff_plans", "action" => "deleteStaffEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) {$('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "staff_plans", "action" => "staff_event", $staffData['User']['id'], $showCalendarDay));?>";} });
                  $calendar.weekCalendar("removeEvent", calEvent.id);
                  $dialogContent.dialog("close");
               },
               Cancel : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));
         $(window).resize().resize(); //fixes a bug in modal overlay size ??

      },
      eventMouseover : function(calEvent, $event) {
      },
      eventMouseout : function(calEvent, $event) {
      },
      noEvents : function() {
         
      },
      data : function(start, end, callback) {
         callback(getEventData());
      }
   });

   function resetForm($dialogContent) {
      $dialogContent.find("input").val("");
      $dialogContent.find("textarea").val("");
   }

   function getEventData() {
      var year = new Date().getFullYear();
      var month = new Date().getMonth();
      var day = new Date().getDate();

      return {
         events : [
           <?php 
             $eventcnt=0;
             foreach($allEvent as $allEventVal) {
               $expDate = explode("-", $allEventVal["StaffPlan"]["schedule_date"]);
               $expStartTime = explode(":", $allEventVal["StaffPlan"]["start_time"]);
               $expEndTime = explode(":", $allEventVal["StaffPlan"]["end_time"]);
                 $eventcnt++;
           ?>
            {
               "id":<?php echo $allEventVal["StaffPlan"]["id"]; ?>,
               "start": new Date(<?php echo $expDate[0]; ?>, <?php echo $expDate[1]-1; ?>, <?php echo $expDate[2]; ?>, <?php echo $expStartTime[0]; ?>,<?php echo $expStartTime[1]; ?>),
               "end": new Date(<?php echo $expDate[0]; ?>, <?php echo $expDate[1]-1; ?>, <?php echo $expDate[2]; ?>, <?php echo $expEndTime[0]; ?>,<?php echo $expEndTime[1]; ?>),
               "purpose":"<?php echo $allEventVal["StaffPlan"]["purpose"]; ?>"
               <?php if(!($allEventVal["StaffPlan"]["schedule_date"] >= date("Y-m-d"))) { 
                         echo ', "readOnly": true';
                     } 
               ?>
            }
            <?php if($eventcnt != count($allEvent)) echo ",";?>
            
           <?php } ?>
         ]
      };
   }


   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {

      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         if (startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
         }
         var endSelected = "";
         if (endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
         }
         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

      }
      $endTimeOptions = $endTimeField.find("option");
      $startTimeField.trigger("change");
   }

   var $endTimeField = $("select[name='end']");
   var $endTimeOptions = $endTimeField.find("option");

   //reduces the end time options to be only after the start time options.
   $("select[name='start']").change(function() {
      var startTime = $(this).find(":selected").val();
      var currentEndTime = $endTimeField.find("option:selected").val();
      $endTimeField.html(
            $endTimeOptions.filter(function() {
               return startTime < $(this).val();
            })
            );

      var endTimeSelected = false;
      $endTimeField.find("option").each(function() {
         if ($(this).val() === currentEndTime) {
            $(this).attr("selected", "selected");
            endTimeSelected = true;
            return false;
         }
      });

      if (!endTimeSelected) {
         //automatically select an end date 2 slots away.
         $endTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });


});

</script>
 
<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('Duty Plan of ').$staffData['User']['full_name']; ?></div>			
			
	</h3>
	<div class="clr"></div>
</div>
<div style="text-align:center;margin-top:10px;">
 <?php 
    echo $this->Html->link(__('Daily Plan'), array('action' => 'staff_event', $staffData['User']['id'], 1), array('escape' => false,'class'=>'blueBtn'));
 ?>&nbsp;&nbsp;
 <?php 
    echo $this->Html->link(__('Weekly Plan'), array('action' => 'staff_event', $staffData['User']['id'], 7), array('escape' => false,'class'=>'blueBtn'));
 ?>
</div>
<div align="center" id="busy-indicator" style="display: none;">	
<?php echo $this->Html->image('indicator.gif'); ?>
</div>
<input type="hidden" name="userid" id="userid" value="<?php echo $staffData['User']['id']; ?>"/>

	<div id='calendar'></div>
        <div id="event_edit_container" style="display:none;">
		<form>
			
			<ul>
				<li>
					<span><?php echo __('Date'); ?>: </span><span class="date_holder"></span> 
				</li>
				<li>
					<?php echo __('Start Time'); ?>: <select name="start"><option value=""><?php echo __('Select Start Time'); ?></option></select>
				</li>
				<li>
					<?php echo __('End Time'); ?>: <select name="end"><option value=""><?php echo __('Select End Time'); ?></option></select>
				</li>
                                <li>
					<?php echo __('Purpose'); ?>: </label><textarea name="purpose"></textarea>
				</li>
			</ul>
		</form>
	</div>