<?php
   echo $this->Html->css(array('jquery.weekcalendar'));
   echo $this->Html->script(array('jquery1.3.2.min', 'jquery1.7.2-ui.min', 'jquery.weekcalendar'));
?>
<script type='text/javascript'>
   $(document).ready(function() {

   var $calendar = $('#calendar');
   var id = 1;

   $calendar.weekCalendar({
      timeslotsPerHour : 2,
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
               $event.css({"backgroundColor": calEvent.pastcolorcode, "color": "black"});
	  }
	  if (calEvent.end.getTime() > new Date().getTime()) {
                $event.css({"backgroundColor": calEvent.futurecolorcode, "color": "black"});
	  }
	  if (calEvent.end.getDate() == new Date().getDate()) {
                $event.css({"backgroundColor": calEvent.presentcolorcode, "color": "black"});
	  }
        // tooltip title
        $event.find(".wc-time").attr('title', 'Patient Name : '+calEvent.patientname);
        $event.find(".wc-title").attr('title', 'Visit Type : '+calEvent.visit_type+',   Purpose : '+calEvent.body);
        $event.find(".wc-title").html(calEvent.patientname);
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
         //var departmentField = $dialogContent.find("select[name='department']");
         var admissionidField = $dialogContent.find("input[name='admissionid']");
         var patientnameField = $dialogContent.find("input[name='patientname']");
         var bodyField = $dialogContent.find("textarea[name='body']");
         if(admissionidField.val() == "") {
               
               $('#calendar').weekCalendar("removeUnsavedEvents");return false;
         }
         var apppatientid = $("#apppatientid").val();
         var apppatientname = $("#apppatientname").val();
         var appadmissionid = $("#appadmissionid").val();
         if(apppatientid) {
           var admissionidField = $dialogContent.find("input[name='admissionid']").val(appadmissionid);
           var patientnameField = $dialogContent.find("input[name='patientname']").val(apppatientname);
           var patientdashboardurl = "<?php echo $this->Html->url("/patients/patient_information/"); ?>"+apppatientid;
           $dialogContent.find("a[name='urlpatient']").attr('href' , patientdashboardurl);
         } else {
           var admissionidField = $dialogContent.find("input[name='admissionid']");
           var patientnameField = $dialogContent.find("input[name='patientname']");
         }
                  
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
                  //calEvent.department = departmentField.val();
                  calEvent.admissionid = admissionidField.val();
                  calEvent.body = bodyField.val();
                  var doctor_userid = $('#doctor_userid').val();
                  var departmentid = $('#department').val();
                  $('#busy-indicator').show();
                  var data = 'admissionid=' + admissionidField.val() +'&doctor_userid=' + doctor_userid +'&scheduledate=' + scheduledate +'&schedule_starttime=' + schedule_starttime + '&schedule_endtime=' + schedule_endtime + '&visit_type=' + visitTypeField.val() + '&department=' + departmentid + '&purpose=' + bodyField.val();
                 
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "saveScheduleEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) { $('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "schedule_event", $showCalendarDay));?>";  } });

                 
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
         var admissionidField = $dialogContent.find("input[name='admissionid']").val(calEvent.admissionid);
         var patientnameField = $dialogContent.find("input[name='patientname']").val(calEvent.patientname);
         var bodyField = $dialogContent.find("textarea[name='body']");
         bodyField.val(calEvent.body);
         var patientdashboardurl = "<?php echo $this->Html->url("/patients/patient_information/"); ?>"+calEvent.dashboardurlpatientid;
         $dialogContent.find("a[name='urlpatient']").attr('href' , patientdashboardurl);

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
                  //calEvent.department = departmentField.val();
                  calEvent.admissionid = admissionidField.val();
                  calEvent.body = bodyField.val();
                  var doctor_userid = $('#doctor_userid').val();
                  var departmentid = $('#department').val();
                  $('#busy-indicator').show();
                  var data = 'id=' + calEvent.id +'&admissionid=' + admissionidField.val() +'&doctor_userid=' + doctor_userid +'&scheduledate=' + scheduledate +'&schedule_starttime=' + schedule_starttime + '&schedule_endtime=' + schedule_endtime + '&visit_type=' + visitTypeField.val() + '&department=' + departmentid + '&purpose=' + bodyField.val();
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "updateScheduleEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) {  $('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "schedule_event", $showCalendarDay));?>"; } });
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               "Delete" : function() {
                  var data = 'id=' + calEvent.id;
                  $('#busy-indicator').show();
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "deleteScheduleEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) {$('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "schedule_event", $showCalendarDay));?>";} });
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
      //$dialogContent.find("select[name='department']").val("");
      $dialogContent.find("a[name='urlpatient']").attr("href", "#");
   }

   function getEventData() {
      var year = new Date().getFullYear();
      var month = new Date().getMonth();
      var day = new Date().getDate();

      return {
         events : [
           <?php 
             $eventcnt=0;
             $innereventcnt=0;
             foreach($allEvent as $allEventVal) {
               $expDate = explode("-", $allEventVal["Appointment"]["date"]);
               $expStartTime = explode(":", $allEventVal["Appointment"]["start_time"]);
               $expEndTime = explode(":", $allEventVal["Appointment"]["end_time"]);
                 $eventcnt++;
               if((!empty($expDate[0]) || !empty($expDate[1]) || !empty($expDate[2])) && (!empty($expStartTime[0]) || !empty($expStartTime[1]) || !empty($expEndTime[0]) || !empty($expEndTime[1]))) { $innereventcnt++;
           ?>
            {
               "id":<?php echo $allEventVal["Appointment"]["id"]; ?>,
               "start": new Date(<?php echo $expDate[0]; ?>, <?php echo $expDate[1]-1; ?>, <?php echo $expDate[2]; ?>, <?php echo $expStartTime[0]; ?>,<?php echo $expStartTime[1]; ?>),
               "end": new Date(<?php echo $expDate[0]; ?>, <?php echo $expDate[1]-1; ?>, <?php echo $expDate[2]; ?>, <?php echo $expEndTime[0]; ?>,<?php echo $expEndTime[1]; ?>),
               "admissionid":"<?php echo $allEventVal["Patient"]["admission_id"]; ?>",
               "dashboardurlpatientid":"<?php echo $allEventVal["Patient"]["id"]; ?>",
               "patientname":"<?php echo $allEventVal["Patient"]["lookup_name"]; ?>",
               "visit_type":"<?php echo $allEventVal["Appointment"]["visit_type"]; ?>",
               "body":"<?php echo $allEventVal["Appointment"]["purpose"]; ?>",
               "presentcolorcode":"<?php if($allEventVal["DoctorProfile"]["present_event_color"]) echo $allEventVal["DoctorProfile"]["present_event_color"]; else echo "yellow"; ?>",
               "pastcolorcode":"<?php if($allEventVal["DoctorProfile"]["past_event_color"]) echo $allEventVal["DoctorProfile"]["past_event_color"]; else echo "#e6e6e6"; ?>",
               "futurecolorcode":"<?php if($allEventVal["DoctorProfile"]["future_event_color"]) echo $allEventVal["DoctorProfile"]["future_event_color"]; else echo "#e6e6e6"; ?>"
               <?php if(!($allEventVal["Appointment"]["date"] >= date("Y-m-d"))) { 
                         echo ', "readOnly": true';
                     } 
               ?>
            }
            <?php } if($eventcnt != count($allEvent) && $innereventcnt > 0) echo ","; ?>
            
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
			<div style="float:left"><?php echo __('Appointment Scheduling'); ?></div>			
			
	</h3>
	<div class="clr"></div>
</div>
<div style="text-align:left;margin-top:10px;">
<table border="0" cellpadding="0" cellspacing="0">
  <TR>
   <TD><b><?php echo __('Primary Care Provider'); ?></b></TD>
   <TD>&nbsp;&nbsp;:&nbsp;&nbsp;</TD>
   <TD><?php echo $doctorData['DoctorProfile']['doctor_name']; ?></TD>
  </TR>
  <TR>
   <TD><b><?php echo __('Specialty'); ?></b></TD>
   <TD>&nbsp;&nbsp;:&nbsp;&nbsp;</TD>
   <TD><?php echo $doctorData['Department']['name']; ?></TD>
  </TR>
 </table>
</div>
<div style="text-align:center;margin-top:10px;">
 <?php 
    echo $this->Html->link(__('Daily Appointment'), array('action' => 'schedule_event', 1, 'patientid' => $patientAppointmentData['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
 ?>&nbsp;&nbsp;
 <?php 
    echo $this->Html->link(__('Weekly Appointment'), array('action' => 'schedule_event', 7, 'patientid' => $patientAppointmentData['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
 ?>
</div>
<div align="center" id="busy-indicator" style="display: none;">	
<?php echo $this->Html->image('indicator.gif'); ?>
</div>
<input type="hidden" name="doctor_userid" id="doctor_userid" value="<?php echo $doctorData['DoctorProfile']['user_id']; ?>"/>
<input type="hidden" name="department" id="department" value="<?php echo $doctorData['DoctorProfile']['department_id']; ?>"/>
<input type="hidden" name="apppatientid" id="apppatientid" value="<?php echo $patientAppointmentData['Patient']['id']; ?>"/>
<input type="hidden" name="appadmissionid" id="appadmissionid" value="<?php echo $patientAppointmentData['Patient']['admission_id']; ?>"/>
<input type="hidden" name="apppatientname" id="apppatientname" value="<?php echo $patientAppointmentData['Patient']['lookup_name']; ?>"/>
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
                                  <?php echo __('Visit Type'); ?>:<br />
                                  <?php 
                                  
                     	   echo $this->Form->input('',array('name'=>'visit_type','id'=>'visit_type','options'=>Configure::read('patient_visit_type'),'div'=>false,'label'=>false,'error'=>false));
                     ?>
				</li>
				<li>
					<?php echo __('Purpose'); ?>: </label><textarea name="body"></textarea>
				</li>
                               <li style="padding-top:30px; width:100%;">
                                  <?php echo __('MRN'); ?>:<br />
                                 <li> <input type="text" name="admissionid" id="admissionid" readonly="readonly" /></li>
                               </li>
                               <li>
                                  <?php echo __('Patient Name'); ?>:
                                  <input type="text" name="patientname" id="patientname"  readonly="readonly" />
                               </li>
                               <li>
                                  <a href="#" name="urlpatient" >View Patient Dashboard</a>
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

               $("#calendar").click(function(){ 
             $('#showpatientname').hide();
            
        }); 
        $("#admissionid").blur(function(){ 
         var paid = $('#admissionid').val();
         var data = 'paid=' + paid ;
         $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetPatientName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#showpatientname').show();$('#busy-indicator').hide();$('#showpatientname').html(html); } });
         }); 
			
	 	});
  </script>