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
      businessHours :{start: 8, end: 18, limitDisplay: true },
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
        $event.find(".wc-title").attr('title', calEvent.body);
        $event.find(".wc-title").html(calEvent.admissionid);
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
         var visitTypeField = $dialogContent.find("select[name='visit_type']");
         var departmentField = $dialogContent.find("select[name='department']");
         var admissionidField = $dialogContent.find("input[name='admissionid']");
         var bodyField = $dialogContent.find("textarea[name='body']");
                  
         $dialogContent.dialog({
            modal: true,
            title: "New Appointment Schedule",
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
                  calEvent.visit_type = visitTypeField.val();
                  calEvent.department = departmentField.val();
                  calEvent.admissionid = admissionidField.val();
                  calEvent.body = bodyField.val();
                  var consultantid = $('#consultantid').val();
                  $('#busy-indicator').show();
                  var data = 'admissionid=' + admissionidField.val() +'&consultantid=' + consultantid +'&scheduledate=' + scheduledate +'&schedule_starttime=' + schedule_starttime + '&schedule_endtime=' + schedule_endtime + '&visit_type=' + visitTypeField.val() + '&department=' + departmentField.val() + '&purpose=' + bodyField.val();
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "consultant_schedules", "action" => "saveConsultantEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) { $('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "consultant_schedules", "action" => "consultant_event", $consultantData['Consultant']['id'], $showCalendarDay));?>";  } });

                 
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
         var visitTypeField = $dialogContent.find("select[name='visit_type']").val(calEvent.visit_type);
         var departmentField = $dialogContent.find("select[name='department']").val(calEvent.department);
         var admissionidField = $dialogContent.find("input[name='admissionid']").val(calEvent.admissionid);
         var bodyField = $dialogContent.find("textarea[name='body']");
         bodyField.val(calEvent.body);

         $dialogContent.dialog({
            modal: true,
            title: "Edit Appointment Schedule",
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
                  calEvent.visit_type = visitTypeField.val();
                  calEvent.department = departmentField.val();
                  calEvent.admissionid = admissionidField.val();
                  calEvent.body = bodyField.val();
                  var consultantid = $('#consultantid').val();
                  $('#busy-indicator').show();
                  var data = 'id=' + calEvent.id +'&admissionid=' + admissionidField.val() +'&scheduledate=' + scheduledate +'&schedule_starttime=' + schedule_starttime + '&schedule_endtime=' + schedule_endtime + '&visit_type=' + visitTypeField.val() + '&department=' + departmentField.val() + '&purpose=' + bodyField.val();
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "consultant_schedules", "action" => "updateScheduleEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) {  $('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "consultant_schedules", "action" => "consultant_event", $consultantData['Consultant']['id'], $showCalendarDay));?>"; } });
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               "Delete" : function() {
                  var data = 'id=' + calEvent.id;
                  $('#busy-indicator').show();
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "consultant_schedules", "action" => "deleteScheduleEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) {$('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "consultant_schedules", "action" => "consultant_event", $consultantData['Consultant']['id'], $showCalendarDay));?>";} });
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
      $dialogContent.find("select[name='visit_type']").val("");
      $dialogContent.find("input[name='admissionid']").val("");
      $dialogContent.find("select[name='department']").val("");
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
               $expDate = explode("-", $allEventVal["ConsultantSchedule"]["schedule_date"]);
               $expStartTime = explode(":", $allEventVal["ConsultantSchedule"]["start_time"]);
               $expEndTime = explode(":", $allEventVal["ConsultantSchedule"]["end_time"]);
                 $eventcnt++;
           ?>
            {
               "id":<?php echo $allEventVal["ConsultantSchedule"]["id"]; ?>,
               "start": new Date(<?php echo $expDate[0]; ?>, <?php echo $expDate[1]-1; ?>, <?php echo $expDate[2]; ?>, <?php echo $expStartTime[0]; ?>,<?php echo $expStartTime[1]; ?>),
               "end": new Date(<?php echo $expDate[0]; ?>, <?php echo $expDate[1]-1; ?>, <?php echo $expDate[2]; ?>, <?php echo $expEndTime[0]; ?>,<?php echo $expEndTime[1]; ?>),
               "admissionid":"<?php echo $allEventVal["Patient"]["admission_id"]; ?>",
               "Specilty":"<?php echo $allEventVal["ConsultantSchedule"]["department_id"]; ?>",
               "visit_type":"<?php echo $allEventVal["ConsultantSchedule"]["visit_type"]; ?>",
               "body":"<?php echo $allEventVal["ConsultantSchedule"]["purpose"]; ?>"
               <?php if(!($allEventVal["ConsultantSchedule"]["schedule_date"] >= date("Y-m-d"))) { 
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
			<div style="float:left"><?php echo __('Consultant schedules time for ').$consultantData['Consultant']['full_name']; ?></div>			
			
	</h3>
	<div class="clr"></div>
</div>
<div style="text-align:center;margin-top:10px;">
 <?php 
    echo $this->Html->link(__('Daily Appointment'), array('action' => 'consultant_event', $consultantData['Consultant']['id'], 1), array('escape' => false,'class'=>'blueBtn'));
 ?>&nbsp;&nbsp;
 <?php 
    echo $this->Html->link(__('Weekly Appointment'), array('action' => 'consultant_event', $consultantData['Consultant']['id'], 7), array('escape' => false,'class'=>'blueBtn'));
 ?>
</div>
<div align="center" id="busy-indicator" style="display: none;">	
<?php echo $this->Html->image('indicator.gif'); ?>
</div>
<input type="hidden" name="consultantid" id="consultantid" value="<?php echo $consultantData['Consultant']['id']; ?>"/>

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
                                  <?php echo __('MRN'); ?>:
                                  <input type="text" name="admissionid" id="admissionid" />
				</li>
                               <li>
                                  <?php echo __('Specilty'); ?>:
				  <select  name="department">
                                  <?php foreach($departmentList as $departmentListval) { ?>
                                    <option value="<?php echo $departmentListval["Department"]["id"]; ?>"><?php echo $departmentListval["Department"]["name"]; ?></option>
                                  <?php } ?>
                                 </select>
				</li>
				<li>
                                  <?php echo __('Visit Type'); ?>:
				  <select  name="visit_type">
                                   <option value="First_Visit">First Visit</option>
                                   <option value="Emergency">Emergency</option>
                                   <option value="Follow_Up">Follow-Up</option>
                                   <option value="Vaccination">Vaccination</option>
                                  </select>
				</li>
				<li>
					<?php echo __('Purpose'); ?>: </label><textarea name="body"></textarea>
				</li>
			</ul>
		</form>
	</div>
<?php
 
  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');
 
?>
<script>
$(document).ready(function(){
    	 
			// for automatic patient search//
   $("#admissionid").autocomplete("<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "autoSearchAdmissionId", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			
	 	});
  </script>