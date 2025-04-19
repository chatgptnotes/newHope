<?php echo $this->Html->css(array('jquery.timepicker','jquery.weekcalendar'));?>
<?php echo $this->Html->script(array('jquery-1.6.3.min', 'jquery1.7.2-ui.min', 'jquery.timepicker', 'jquery.weekcalendar')); ?>
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
               $event.css({"backgroundColor": "#e6e6e6", "color": "black"});
	  }
	  if (calEvent.end.getTime() > new Date().getTime()) {
                $event.css({"backgroundColor": "#e6e6e6", "color": "black"});
	  }
	  if (calEvent.end.getDate() == new Date().getDate()) {
                $event.css({"backgroundColor": "yellow", "color": "black"});
	  }
        $event.find(".wc-title").attr('title', 'Surgeon : '+calEvent.surgeon);
        $event.find(".wc-title").html(calEvent.patientlookupname);
        
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
         var admissionidField = $dialogContent.find("input[name='admissionid']");
         var diagnosisField = $dialogContent.find("input[name='diagnosis']");
         var surgery_idField = $dialogContent.find("select[name='surgery_id']");
         var service_groupField = $dialogContent.find("select[name='service_group']");
         var operation_typeField = $dialogContent.find("select[name='operation_type']");
         var doctor_idField = $dialogContent.find("select[name='doctor_id']");
         var department_idField = $dialogContent.find("select[name='department_id']");
         var anaesthesiaField = $dialogContent.find("input[name='anaesthesia']");
         var procedurecompleteField = $dialogContent.find("select[name='procedurecomplete']");
         var otintimeField = $dialogContent.find("input[name='otintime']");
         var incisiontimeField = $dialogContent.find("input[name='incisiontime']");
         var skinclosureField = $dialogContent.find("input[name='skinclosure']");
         var outtimeField = $dialogContent.find("input[name='outtime']");
         var descriptionField = $dialogContent.find("textarea[name='description']");
            
         $dialogContent.dialog({
            modal: true,
            title: "Add OT Schedule",
            width: "590px",
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
                  if(calEvent.start == "Invalid Date") {
                      return false;
                  }
                  calEvent.end = new Date(endField.val());
                  calEvent.admissionid = admissionidField.val();
                  calEvent.diagnosis = diagnosisField.val();
                  calEvent.surgery_id = surgery_idField.val();
                  calEvent.service_group = service_groupField.val();
                  calEvent.operation_type = operation_typeField.val();
                  calEvent.doctor_id = doctor_idField.val();
                  calEvent.department_id = department_idField.val();
                  calEvent.anaesthesia = anaesthesiaField.val();
                  calEvent.procedurecomplete = procedurecompleteField.val();
                  calEvent.otintime = otintimeField.val();
                  calEvent.incisiontime = incisiontimeField.val();
                  calEvent.skinclosure = skinclosureField.val();
                  calEvent.outtime = outtimeField.val();
                  calEvent.description = descriptionField.val();
                  // disable save button if mandatory field left // 
                  if(calEvent.surgery_id == undefined && calEvent.admissionid == "" && calEvent.service_group == "" && calEvent.doctor_id == "") {
                      alert("Please fill all mandatory fields.");
                      return false;
                  }
                  // outtime should be greater than otintime //
                  if(calEvent.otintime != "" && calEvent.outtime !="") {
                  var otintimepm = calEvent.otintime.search(/pm/i);
                  var outtimepm = calEvent.outtime.search(/pm/i);
                  var otintimeam = calEvent.otintime.search(/am/i);
                  var outtimeam = calEvent.outtime.search(/am/i);
			if(otintimepm > 0) {
			 var otintime_extract = calEvent.otintime.replace(/\pm/g,"").split(":");
                         otintime_extract[0] = parseInt(otintime_extract[0])+parseInt(12);
                         var otintimeformat = otintime_extract.join(); 
			}
                        if(outtimepm > 0) {
			 var outtime_extract = calEvent.outtime.replace(/\pm/g,"").split(":");
                         outtime_extract[0] = parseInt(outtime_extract[0])+parseInt(12);
                         var outtimeformat = outtime_extract.join(); 
			}
                        if(otintimeam > 0) {
			 var otintime_extract = calEvent.otintime.replace(/\am/g,"").split(":");
                         var otintimeformat = otintime_extract.join(); 
			}
                        if(outtimeam > 0) {
			 var outtime_extract = calEvent.outtime.replace(/\am/g,"").split(":");
                         var outtimeformat = outtime_extract.join(); 
			}
                        var todaydateintime = new Date();
                        var todaydateouttime = new Date();
                        var stdotintime = todaydateintime.setHours(otintime_extract[0], otintime_extract[1]); 
                        var stdouttime = todaydateouttime.setHours(outtime_extract[0], outtime_extract[1]);
                        
                        if(stdotintime >= stdouttime) {
                          alert("OT Out Time Should be greater than In Time");
                          return false;
                        } 
                        
                  } 
                  // make surgery mandatory //
                  if($('#surgery_id').val() == undefined || $('#surgery_id').val() == "") {
                          alert("Please select service group and then surgery");
                          return false;
                  } 
                  // make surgeon mandatory //
                  if($('#doctor_id').val() == undefined || $('#doctor_id').val() == "") {
                          alert("Please select surgeon");
                          return false;
                  } 
                  var regX = /\n/gi ;
                  bodydesc = new String(descriptionField.val());
                  bodydesc = bodydesc.replace(regX, "<br />");
                  var surgery_id = $('#surgery_id').val();
                  var surgery_subcategory_id = $('#surgery_subcategory_id').val();
                  var opt_id = $('#opt_id').val();
                  var opt_table_id = $('#opt_table_id').val();
                  $('#busy-indicator').show();
                  var data = 'scheduledate=' + scheduledate +'&schedule_starttime=' + schedule_starttime + '&schedule_endtime=' + schedule_endtime + '&admissionid=' + admissionidField.val() + '&diagnosis=' + diagnosisField.val() + '&surgery_id=' + surgery_id + '&service_group=' + service_groupField.val()+ '&surgery_subcategory_id=' + surgery_subcategory_id + '&operation_type=' + operation_typeField.val() + '&doctor_id=' + doctor_idField.val() + '&department_id=' + department_idField.val() + '&anaesthesia=' + anaesthesiaField.val()+ '&procedurecomplete=' + procedurecompleteField.val() + '&otintime=' + otintimeField.val() + '&incisiontime=' + incisiontimeField.val() + '&skinclosure=' + skinclosureField.val() + '&outtime=' + outtimeField.val() + '&description=' + bodydesc + '&opt_id=' + opt_id + '&opt_table_id=' + opt_table_id;
                 
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "saveOptEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) {  $('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "optevent", $optData['Opt']['id'], $optData['OptTable']['id'],$showCalendarDay));?>";  } });

                 
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
         var admissionidField = $dialogContent.find("input[name='admissionid']").val(calEvent.admissionid);
         var diagnosisField = $dialogContent.find("input[name='diagnosis']").val(calEvent.diagnosis);
         var surgery_idField = $dialogContent.find("select[name='surgery_id']");
         var service_groupField = $dialogContent.find("select[name='service_group']").val(calEvent.service_group);
         var operation_typeField = $dialogContent.find("select[name='operation_type']").val(calEvent.operation_type);
         var doctor_idField = $dialogContent.find("select[name='doctor_id']").val(calEvent.doctor_id);
         var department_idField = $dialogContent.find("select[name='department_id']").val(calEvent.department_id);
         var anaesthesiaField = $dialogContent.find("input[name='anaesthesia']").val(calEvent.anaesthesia);
         var procedurecompleteField = $dialogContent.find("select[name='procedurecomplete']").val(calEvent.procedurecomplete);
         var otintimeField = $dialogContent.find("input[name='otintime']").val(calEvent.otintime);
         var incisiontimeField = $dialogContent.find("input[name='incisiontime']").val(calEvent.incisiontime);
         var skinclosureField = $dialogContent.find("input[name='skinclosure']").val(calEvent.skinclosure);
         var outtimeField = $dialogContent.find("input[name='outtime']").val(calEvent.outtime);
         var descriptionField = $dialogContent.find("textarea[name='description']");
         descriptionField.val(calEvent.description);
         var ss = calEvent.description;
         descriptionField.val(ss.replace(/<br \/>/gi, "\n"));
         // only for edit surgery subcategory // 
         
         if(calEvent.surgery_id) { 
          // for surgery //
          var data = 'id=' + calEvent.id + '&service_group=' + calEvent.service_group + '&surgery_id=' + calEvent.surgery_id;
          $.ajax({url: "<?php echo $this->Html->url(array("action" => "getSurgeryCategoryList", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) {  if(html == "norecord"){ $('#changeSurgeryCategoryList').hide();} else {$('#changeSurgeryCategoryList').show(); $('#changeSurgeryCategoryList').html(html);$('#surgery_id').val(calEvent.surgery_id); } $('#busy-indicator').hide(); } });
         // for surgery subcategory //
         $.ajax({url: "<?php echo $this->Html->url(array("action" => "getSurgerySubcategoryList", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { if(html == "norecord"){ $('#changeSurgerySubcategoryList').hide();} else {$('#changeSurgerySubcategoryList').show(); $('#changeSurgerySubcategoryList').html(html);$('#surgery_subcategory_id').val(calEvent.surgery_subcategory_id); } $('#busy-indicator').hide(); } });
         }

         if(calEvent.admissionid) {
          // for existing patient name field //
           $('#patientname').val(calEvent.patientlookupname);
          // for existing diagnosis field //
           $('#diagnosis').val(calEvent.diagnosis);
         }

         if(calEvent.procedurecomplete == 1) {
           $('#allottime').show();
         }
         // end //
         $dialogContent.dialog({
            modal: true,
            title: "Edit OT Appointment Schedule",
            width: "610px",
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
                  if(calEvent.start == "Invalid Date") {
                      return false;
                  }
                  calEvent.end = new Date(endField.val());
                  calEvent.admissionid = admissionidField.val();
                  calEvent.diagnosis = diagnosisField.val();
                  calEvent.surgery_id = surgery_idField.val();
                  calEvent.service_group = service_groupField.val();
                  calEvent.operation_type = operation_typeField.val();
                  calEvent.doctor_id = doctor_idField.val();
                  calEvent.department_id = department_idField.val();
                  calEvent.anaesthesia = anaesthesiaField.val();
                  calEvent.procedurecomplete = procedurecompleteField.val();
                  calEvent.otintime = otintimeField.val();
                  calEvent.incisiontime = incisiontimeField.val();
                  calEvent.skinclosure = skinclosureField.val();
                  calEvent.outtime = outtimeField.val();
                  calEvent.description = descriptionField.val();
                  // disable save button if mandatory field left // 
                  if(calEvent.surgery_id == undefined && calEvent.admissionid == "" && calEvent.service_group == "" && calEvent.doctor_id == "") {
                      alert("Please fill all mandatory fields.");
                      return false;
                  }
                  // outtime should be greater than otintime //
                  if(calEvent.otintime != "" && calEvent.outtime !="") {
                  var otintimepm = calEvent.otintime.search(/pm/i);
                  var outtimepm = calEvent.outtime.search(/pm/i);
                  var otintimeam = calEvent.otintime.search(/am/i);
                  var outtimeam = calEvent.outtime.search(/am/i);
			if(otintimepm > 0) {
			 var otintime_extract = calEvent.otintime.replace(/\pm/g,"").split(":");
                         otintime_extract[0] = parseInt(otintime_extract[0])+parseInt(12);
                         var otintimeformat = otintime_extract.join(); 
			}
                        if(outtimepm > 0) {
			 var outtime_extract = calEvent.outtime.replace(/\pm/g,"").split(":");
                         outtime_extract[0] = parseInt(outtime_extract[0])+parseInt(12);
                         var outtimeformat = outtime_extract.join(); 
			}
                        if(otintimeam > 0) {
			 var otintime_extract = calEvent.otintime.replace(/\am/g,"").split(":");
                         var otintimeformat = otintime_extract.join(); 
			}
                        if(outtimeam > 0) {
			 var outtime_extract = calEvent.outtime.replace(/\am/g,"").split(":");
                         var outtimeformat = outtime_extract.join(); 
			}
                        var todaydateintime = new Date();
                        var todaydateouttime = new Date();
                        var stdotintime = todaydateintime.setHours(otintime_extract[0], otintime_extract[1]); 
                        var stdouttime = todaydateouttime.setHours(outtime_extract[0], outtime_extract[1]);
                        
                        if(stdotintime >= stdouttime) {
                          alert("OT Out Time Should be greater than In Time");
                          return false;
                        } 
                        
                  } 
                  // make surgery mandatory //
                   if($('#surgery_id').val() == undefined || $('#surgery_id').val() == "") {
                          alert("Please select service group and then surgery");
                          return false;
                  }
                  // make surgeon mandatory //
                  if($('#doctor_id').val() == undefined || $('#doctor_id').val() == "") {
                          alert("Please select surgeon");
                          return false;
                  } 
                  var regX = /\n/gi ;
                  bodydesc = new String(descriptionField.val());
                  bodydesc = bodydesc.replace(regX, "<br />");

                  var surgery_id = $('#surgery_id').val();
                  var surgery_subcategory_id = $('#surgery_subcategory_id').val();
                  var opt_id = $('#opt_id').val();
                  var opt_table_id = $('#opt_table_id').val();
                  $('#busy-indicator').show();
                  var data = 'id=' + calEvent.id +'&scheduledate=' + scheduledate +'&schedule_starttime=' + schedule_starttime + '&schedule_endtime=' + schedule_endtime + '&admissionid=' + admissionidField.val() + '&diagnosis=' + diagnosisField.val() + '&surgery_id=' + surgery_id + '&service_group=' + service_groupField.val() + '&surgery_subcategory_id=' + surgery_subcategory_id + '&operation_type=' + operation_typeField.val() + '&doctor_id=' + doctor_idField.val() + '&department_id=' + department_idField.val() + '&anaesthesia=' + anaesthesiaField.val() + '&procedurecomplete=' + procedurecompleteField.val() + '&otintime=' + otintimeField.val() + '&incisiontime=' + incisiontimeField.val() + '&skinclosure=' + skinclosureField.val() + '&outtime=' + outtimeField.val() + '&description=' + bodydesc + '&opt_id=' + opt_id + '&opt_table_id=' + opt_table_id;
                  
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "updateOptScheduleEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) { $('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "optevent", $optData['Opt']['id'], $optData['OptTable']['id'], $showCalendarDay));?>"; } });
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               "Delete" : function() {
                   var data = 'id=' + calEvent.id;
                  $('#busy-indicator').show();
                  $.ajax({url: "<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "deleteOptScheduleEvent", "admin" => false)); ?>",type: "GET",data: data,success: function (html) {$('#busy-indicator').hide(); window.location = "<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "optevent", $optData['Opt']['id'], $optData['OptTable']['id'], $showCalendarDay));?>";} });
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
      $dialogContent.find("select[name='service_group']").val("");
      $('#changeSurgeryCategoryList').hide();
      $('#changeSurgerySubcategoryList').hide();
      $dialogContent.find("select[name='operation_type']").val("");
      $dialogContent.find("select[name='doctor_id']").val("");
      $dialogContent.find("select[name='department_id']").val("");
      $dialogContent.find("span[name='surgersubcat']").remove();
      $dialogContent.find("select[name='procedurecomplete']").val("");
      
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
               $expDate = explode("-", $allEventVal["OptAppointment"]["schedule_date"]);
               $expStartTime = explode(":", $allEventVal["OptAppointment"]["start_time"]);
               $expEndTime = explode(":", $allEventVal["OptAppointment"]["end_time"]);
                 $eventcnt++;
           ?>
            {
               "id":<?php echo $allEventVal["OptAppointment"]["id"]; ?>,
               "start": new Date(<?php echo $expDate[0]; ?>, <?php echo $expDate[1]-1; ?>, <?php echo $expDate[2]; ?>, <?php echo $expStartTime[0]; ?>,<?php echo $expStartTime[1]; ?>),
               "end": new Date(<?php echo $expDate[0]; ?>, <?php echo $expDate[1]-1; ?>, <?php echo $expDate[2]; ?>, <?php echo $expEndTime[0]; ?>,<?php echo $expEndTime[1]; ?>),
               "admissionid":"<?php echo $allEventVal["Patient"]["admission_id"]; ?>",
               "surgeon":"<?php echo $allEventVal["DoctorProfile"]["doctor_name"]; ?>",
               "patientlookupname":"<?php echo $allEventVal["Patient"]["lookup_name"]; ?>",
               "diagnosis":"<?php echo $allEventVal["OptAppointment"]["diagnosis"]; ?>",
               "service_group":"<?php echo $allEventVal["OptAppointment"]["service_group"]; ?>",
               "surgery_id":"<?php echo $allEventVal["OptAppointment"]["surgery_id"]; ?>",
               "surgery_subcategory_id":"<?php echo $allEventVal["OptAppointment"]["surgery_subcategory_id"]; ?>",
               "operation_type":"<?php echo $allEventVal["OptAppointment"]["operation_type"]; ?>",
               "doctor_id":"<?php echo $allEventVal["OptAppointment"]["doctor_id"]; ?>",
               "department_id":"<?php echo $allEventVal["OptAppointment"]["department_id"]; ?>",
               "anaesthesia":"<?php echo $allEventVal["OptAppointment"]["anaesthesia"]; ?>",
               "procedurecomplete":"<?php echo $allEventVal["OptAppointment"]["procedure_complete"]; ?>",
               "otintime":"<?php echo $allEventVal["OptAppointment"]["ot_in_time"]; ?>",
               "incisiontime":"<?php echo $allEventVal["OptAppointment"]["incision_time"]; ?>",
               "skinclosure":"<?php echo $allEventVal["OptAppointment"]["skin_closure"]; ?>",
               "outtime":"<?php echo $allEventVal["OptAppointment"]["out_time"]; ?>",
               "schedule_date":"<?php echo $allEventVal["OptAppointment"]["schedule_date"]; ?>",
               "description":"<?php echo $allEventVal["OptAppointment"]["description"]; ?>"
               
               <?php //if(!($allEventVal["OptAppointment"]["schedule_date"] >= date("Y-m-d"))) { 
                     //  echo ', "readOnly": true';
                     //} 
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
	
        <h3><?php echo __('Set-OT Scheduling'); ?></h3>			
 <span><?php echo $this->Html->link(__('Back'), array('controller' => 'opt_appointments', 'action' => 'index'), array('escape' => false,'class'=>'blueBtn'));?></span>
	<div class="clr"></div>
</div>
<div style="text-align:left;margin-top:10px;">
 <table border="0" cellpadding="0" cellspacing="0">
  <TR>
   <TD><b><?php echo __('OT Room'); ?></b></TD>
   <TD>&nbsp;&nbsp;:&nbsp;&nbsp;</TD>
   <TD><?php echo $optData['Opt']['name']; ?></TD>
  </TR>
  <TR>
   <TD><b><?php echo __('OT Table'); ?></b></TD>
   <TD>&nbsp;&nbsp;:&nbsp;&nbsp;</TD>
   <TD><?php echo $optData['OptTable']['name']; ?></TD>
  </TR>
</table>
 
</div>
<div style="text-align:center;margin-top:10px;">
 <?php 
    echo $this->Html->link(__('Daily OT Scheduling'), array('action' => 'optevent', $optData['Opt']['id'], $optData['OptTable']['id'], 1), array('escape' => false,'class'=>'blueBtn'));
 ?>&nbsp;&nbsp;
 <?php 
    echo $this->Html->link(__('Weekly OT Scheduling'), array('action' => 'optevent', $optData['Opt']['id'], $optData['OptTable']['id'], 7), array('escape' => false,'class'=>'blueBtn'));
 ?>
</div>
<div align="center" id="busy-indicator" style="display: none;">	
<?php echo $this->Html->image('indicator.gif'); ?>
</div>
<input type="hidden" name="opt_id" id="opt_id" value="<?php echo $optData['Opt']['id']; ?>"/>
<input type="hidden" name="opt_table_id" id="opt_table_id" value="<?php echo $optData['OptTable']['id']; ?>"/>
	<div id='calendar'></div>
        <div id="event_edit_container" style="display:none;">
		<form>
			
			<ul>
                           
				<li style="clear:both; width:500px;  border:0px solid #fff; height:inherit;">
					<span><?php echo __('Date'); ?>: </span><span class="date_holder"></span> 
				</li>
				<li>
					<?php echo __('Start Time'); ?>: <select name="start"><option value=""><?php echo __('Select Start Time'); ?></option></select>
				</li>
				<li>
					<?php echo __('End Time'); ?>: <select name="end"><option value=""><?php echo __('Select End Time'); ?></option></select>
				</li>
                                <li>
                                  <?php echo __('MRN'); ?> <font color="red"> *</font>:
                                  <?php echo $this->Form->input(null,array('name' => 'admissionid', 'id'=> 'admissionid', 'label' => false));?>
                                </li>
                               <li id="showpatientname" style="display:block">
                                  <?php echo __('Patient Name'); ?>:
                                  <?php echo $this->Form->input(null,array('name' => 'patientname', 'id'=> 'patientname', 'label' => false));?>
                              </li>
                                <li id="showdiagnosisname" style="display:block">
                                  <?php echo __('Diagnosis'); ?>:
                                  <?php echo $this->Form->input(null,array('name' => 'diagnosis', 'id'=> 'diagnosis', 'label' => false,  'readonly' => 'readonly'));?>
                                </li>
                                <li>
                                  <?php echo __('Service Group'); ?> <font color="red"> *</font>:
                                  <?php echo $this->Form->input(null,array('name' => 'service_group', 'id'=> 'service_group', 'empty'=>__('Select Service Group'),'options'=> array('surgery' => 'Surgery', 'package'=> 'Package'), 'label' => false));	?>
                                </li>
                                <span id="changeSurgeryCategoryList" style="display:none;">
                                  
                                 </span>
                               <span id="changeSurgerySubcategoryList" style="display:none;">
                               </span>
                                <li>
                                  <?php echo __('Major/Minor'); ?>:
				  <select  name="operation_type">
                                   <option value="major">Major</option>
                                   <option value="minor">Minor</option>
                                  </select>
				</li>
                                <li>
                                  <?php echo __('Surgeon'); ?><font color="red"> *</font>:
                                  <?php echo $this->Form->input(null,array('name' => 'doctor_id', 'id'=> 'doctor_id', 'empty'=>__('Select Surgeon'), 'options'=> $doctorlist, 'label' => false));?>
                                </li>
                                <li>
                                  <?php echo __('Anaesthetist'); ?>:
				  <?php echo $this->Form->input(null,array('name' => 'department_id', 'id'=> 'department_id', 'empty'=>__('Select Anaesthetist'),'options'=> $departmentlist, 'label' => false));?>
				</li>
                                <li>
                                  <?php echo __('Anaesthesia'); ?>:
                                  <input type="text" name="anaesthesia" id="anaesthesia" />
                                </li>
                                <li>
                                  <?php echo __('Procedure Complete'); ?>:
                                  <?php echo $this->Form->input(null,array('name' => 'procedurecomplete', 'id'=> 'procedurecomplete', 'options'=> array('0' => 'No', '1' => 'Yes'), 'label' => false));?>
                                  
                                </li>
                                <span id="allottime" style="display:none;">
                                <li>
					<?php echo __('OT In Time'); ?>:<?php echo $this->Form->input(null, array( 'name' => 'otintime', 'id' => 'otintime', 'label'=> false,
			 					  	   'div' => false,'error' => false)); ?>  
				</li>
				<li>
                                       <?php echo __('Incision Time'); ?>:<?php echo $this->Form->input(null, array('name' => 'incisiontime', 'id' => 'incisiontime', 'label'=> false,
			 					  	   'div' => false,'error' => false)); ?>
				</li>
                                <li>
                                      <?php echo __('Skin Closure'); ?>:<?php echo $this->Form->input(null, array('name' => 'skinclosure', 'id' => 'skinclosure', 'label'=> false,
			 					  	   'div' => false,'error' => false)); ?>
				</li>
				<li>
                                     <?php echo __('Out Time'); ?>:<?php echo $this->Form->input(null, array('name' => 'outtime', 'id' => 'outtime', 'label'=> false,
			 					  	   'div' => false,'error' => false)); ?>
				</li>
                                </span>
				<li>
					<?php echo __('Note'); ?>: </label><textarea name="description"></textarea>
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
        // drop down timepicker for OT in time //
        $('#otintime').timepicker({
	            'showDuration': true,
                    'minTime': '8:00am',
                    'maxTime': '7:00pm',
                    'step': 15
        });
        // drop down timepicker for OT in time //
        $('#incisiontime').timepicker({
	            'showDuration': true,
                    'minTime': '8:00am',
                    'maxTime': '7:00pm',
                    'step': 15
        });
        // drop down timepicker for OT in time //
        $('#skinclosure').timepicker({
	            'showDuration': true,
                    'minTime': '8:00am',
                    'maxTime': '7:00pm',
                    'step': 15
        });
        // drop down timepicker for OT in time //
        $('#outtime').timepicker({
	            'showDuration': true,
                    'minTime': '8:00am',
                    'maxTime': '7:00pm',
                    'step': 15
        });
        // drop down timepicker for OT in time //
        $('select[name=procedurecomplete]').change(function(){
                  if($('select[name=procedurecomplete]').val() == 1) {
                     $('#allottime').show();
                  } else {
                     $('#allottime').hide();
                  }
        });
    	// for automatic patient search//
        $("#admissionid").autocomplete("<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "autoSearchAdmissionId", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
        // for automatic patient search//
        $("#patientname").autocomplete("<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "autoSearchPatientName", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
        $("#patientname").focusout(function(){ 
           var patientname = $('#patientname').val();
           var patient_admissionid = patientname.substring(patientname.indexOf("(")-1, patientname.indexOf(")")+1);
            $('#patientname').val(patientname.replace(patient_admissionid,''));
            $('#admissionid').val(patient_admissionid.replace(/[\(\)\s]/g,''));
        });
	
        $("#admissionid, #patientname").focusout(function(){ 
          $('#busy-indicator').show();
          var paid = $('#admissionid').val();
          var data = 'paid=' + paid ; 
          // for patient name field //
          $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetPatientName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#showpatientname').show();$('#busy-indicator').hide();$('#showpatientname').html(html); } });
          // for diagnosis field //
          $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetDiagnosisName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#showdiagnosisname').show();$('#busy-indicator').hide();$('#diagnosis').val(html); } });

         }); 

         $("#service_group").change(function() { 
          $('#busy-indicator').show();
          $('#changeSurgerySubcategoryList').hide();
          var service_group = $('#service_group').val();
          var data = 'service_group=' + service_group ; 
          // for surgery category name field //
          $.ajax({url: "<?php echo $this->Html->url(array("action" => "getSurgeryCategoryList", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { if(html == "norecord"){ $('#changeSurgeryCategoryList').hide();} else {$('#changeSurgeryCategoryList').show(); $('#changeSurgeryCategoryList').html(html); } $('#busy-indicator').hide(); } });
          
         });
         
         		
});
  </script>