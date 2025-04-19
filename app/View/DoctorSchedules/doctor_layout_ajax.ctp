<?php //debug($this->data);?>
<style>
.wc-title {
	font-size: 10px;
	color: #fff;
}

.wc-time {
	font-size: 10px;
}

.ui-widget-content {
	background: #DDDDDD;
	border: 1px solid #AAAAAA;
}

.ui-widget-header {
	color: #000;
	font-weight: bold;
}

.tick {
	background:
		url("<?php echo $this->webroot ?>theme/Black/img/icons/icon_tick.gif")
		no-repeat center 0px;
	cursor: pointer;
}

.timeCalender {
	border-radius: 25px;
	height: 11px;
	text-align: center;
	width: 50px !important;
}
</style>
<?php 
//echo '<pre>';print_r($allEvent);exit;
$params = '';
foreach($this->request->params['named'] as $key=>$value){
	$params .= 	"/$key:$value";
}
//$visitTypeArray = Configure::read('patient_visit_type');
//echo array_search(2,$doctorListArray);exit;
$backDateAppRestrictDate =  strtotime($year.'-'.$month.'-'.$day);

?>
<script type='text/javascript'>
	
$(document).ready(function() {
   var $calendar = $('#calendar');
   var id = 1;
   var businessStartHour = '<?php echo substr($this->data['DoctorProfile']['starthours'],0,2) ?>';
   var businessEndHour = '<?php echo substr($this->data['DoctorProfile']['endhours'],0,2) ?>';
   $calendar.weekCalendar({
	  date: new Date(<?php echo $year;?>,<?php echo $month-1;?>,<?php echo $day;?>,00,00,00),
      timeslotsPerHour : 4,
      allowCalEventOverlap : true,
      overlapEventsSeparate: true,
      timeslotHeight: 40,
      defaultEventLength: 1,
      displayFreeBusys: true,
      textSize: 10,
      //use24Hour:true,
      <?php if($showCalendarDay == 1){?>
      users: [<?php echo $nameStr;?>],
      <?php } ?>
      showAsSeparateUser: true,
      
      firstDayOfWeek : <?php if($showCalendarDay == 1)  echo date("w"); else echo "1"; ?>,
    		  businessHours :{start: (businessStartHour) ? businessStartHour : <?php echo Configure::read('calendar_start_time')?>, end: (businessEndHour) ? businessEndHour : <?php echo Configure::read('calendar_end_time')?>, limitDisplay: true },
      daysToShow : <?php if($showCalendarDay == 7) echo "7"; else echo "1"; ?>,
      buttons: false,    
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
          //color code setting for past present and future
      /*if (calEvent.end.getTime() < new Date().getTime()) {
               $event.css({"backgroundColor": calEvent.pastcolorcode, "color": "black"});
	  }
	  if (calEvent.end.getTime() > new Date().getTime()) {
                $event.css({"backgroundColor": calEvent.futurecolorcode, "color": "black"});
	  }
	  if (calEvent.end.getDate() == new Date().getDate()) {
                $event.css({"backgroundColor": calEvent.presentcolorcode, "color": "black"});
	  }*/
	  $event.css({"backgroundColor": calEvent.presentcolorcode, "color": "black"});
	// tooltip title
	  $event.attr('id',calEvent.id);
	  $event.find(".wc-time").prop('title', calEvent.doctorName + ' | ' + calEvent.patientname + ' | ' + calEvent.visit_type_name);
	  $event.find(".wc-title").prop('title', calEvent.doctorName + ' | ' + calEvent.patientname + ' | ' + calEvent.visit_type_name);
	  if(calEvent.presentcolorcode === undefined) calEvent.presentcolorcode = '#394545';//default new appt color
	  if(calEvent.presentcolorcode.substr(0,1) == '#'){
	  calEvent.presentcolorcode = hexToRgb(calEvent.presentcolorcode);
	  }
	  var colorCodes = calEvent.presentcolorcode.match(/\d+\.?\d*/g); // extracting R G B no. from rgb('' , '' , '');
	  if(colorCodes !== undefined && colorCodes != null)
	  {var R = parseInt(colorCodes[0]); var G = parseInt(colorCodes[1]); var B = parseInt(colorCodes[2]);}
	  else
    	  var R = '';
	  if(R + G + B > 350){ //382
	  var textColor = 'black';//bright color, use dark font
	  }else{
	  var textColor = 'white';//dark color, use bright font
	  } //c = R+G+B;
	  //alert(c);
		$event.find(".wc-title").html(calEvent.doctorName + ' | ' + calEvent.patientname  + ' | ' + calEvent.visit_type_name).css('color',textColor);
      },
      draggable : function(calEvent, $event) {
          return false;//removed draggable --gaurav
         return calEvent.readOnly != true;
      },
      resizable : function(calEvent, $event) {
    	  return false;//removed resizable --gaurav
         return calEvent.readOnly != true;
      },
      freeBusyRender: function(freeBusy, $freeBusy, calendar) {
          
     	  var calenderDay = <?php echo  $showCalendarDay;?>;
          if (!freeBusy.free /*&& calenderDay != 7*/ ) { //commented to show block on week calender
        	  <?php if( (count($removeFlag) == 1 && $removeFlag[0] != 'select_all') || $showCalendarDay != 7){?>
        	  if(freeBusy.is_blocked)
          			$freeBusy.addClass('free-busy-busy');
          		else
          			$freeBusy.addClass('free-free-busy').text(freeBusy.message);
          	
        		<?php } ?>
        	}
          else {
            $freeBusy.addClass('free-busy-free');
          }
          return $freeBusy;
        },
      eventNew : function(calEvent, $event,FreeBusyManager, calendar) { 
    	  var isFree = true;
			$.each(FreeBusyManager.getFreeBusys(calEvent.start, calEvent.end), function(){
				if(
					this.getStart().getTime() != calEvent.end.getTime()
					&& this.getEnd().getTime() != calEvent.start.getTime()
					&& this.getOption('is_blocked')
				){
					isFree = false; 
					
					return false;
				}
			});
			if(!isFree) {
				alert('looks like you tried to add an event on busy part !');
				$(calendar).weekCalendar('removeEvent',calEvent.id);
				return false;
			}
         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var visitTypeField = $dialogContent.find("select[name='visit_type']");
         var visitTypeField = $("#visit_type").val();
         $('#is_discharge').val(calEvent.is_discharge);
         var apppatientid = $("#apppatientid").val();
         var apppatientname = $("#apppatientname").val();
         var appadmissionid = $("#appadmissionid").val();
         var apppatientuid = $("#apppatientuid").val();
         var apppatientdob = $("#apppatientdob").val();
         var appointment_with = $("#appointment_with").val();
         var applocationid = $("#applocationid").val();
         var isDischarge = $("#is_discharge").val();
         var status = $("#status").val();
         
         if(apppatientid) {
           var admissionidField = $dialogContent.find("input[name='admissionid']").val(appadmissionid);
           var patientuidField = $dialogContent.find("input[name='patientuid']").val(apppatientuid);
           var patientnameField = $dialogContent.find("input[name='patientname']").val(apppatientname);
           var patientdobField = $dialogContent.find("input[name='dateofbirth']").val(apppatientdob);
           var patientlocationField = $dialogContent.find("input[name='location_id']").val(applocationid);
           var patientdashboardurl = "<?php echo $this->Html->url("/patients/patient_information/"); ?>"+apppatientid;
           $dialogContent.find("a[name='urlpatient']").attr('href' , patientdashboardurl);
         } else {
           var admissionidField = $dialogContent.find("input[name='admissionid']");
           var patientuidField = $dialogContent.find("input[name='patientuid']");
           var patientnameField = $dialogContent.find("input[name='patientname']");
           var patientdobField = $dialogContent.find("input[name='dateofbirth']");
           var patientlocationField = $dialogContent.find("input[name='location_id']").val(applocationid);
         }
         var bodyField = $dialogContent.find("textarea[name='body']");
         var mess;         
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
            	   $("span.ui-dialog-title").html(mess);
                  calEvent.id = id;
                  id++;
                  var scheduledate = new Date(startField.val()).getFullYear()+"-"+eval(new Date(startField.val()).getMonth()+1)+"-"+new Date(startField.val()).getDate();
                  //Pankaj 
                  startZero  = new Date(startField.val()).getMinutes() ;
                  startZero  =  (startZero < 10)?'0'+startZero:startZero ;
                   
                  var schedule_starttime = new Date(startField.val()).getHours()+":"+ startZero;
                  
                  endZero  = new Date(endField.val()).getMinutes() ;
                  endZero  =  (endZero < 10)?'0'+endZero:endZero ;                 
                  var schedule_endtime = new Date(endField.val()).getHours()+":"+ endZero;
                  
                  calEvent.start = new Date(startField.val());
                  if(calEvent.start == "Invalid Date") {
                      return false;
                  }
                  calEvent.end = new Date(endField.val());
                 // calEvent.visit_type = visitTypeField.val();
                  calEvent.admissionid = admissionidField.val();
                  calEvent.patientuid = patientuidField.val();
                  //calEvent.isDischarge = isDischarge;
                  calEvent.body = bodyField.val();
                  var regX = /\n/gi ;
                  bodydesc = new String(bodyField.val());
                  bodydesc = bodydesc.replace(regX, "<br />");
                  var doctor_userid = $('#doctor_userid').val();
                  var departmentid = $('#department').val();
                  var isDischarge = $('#is_discharge').val();
                  var status = $('#status').val();
                  var appointment_with = $('#appointment_with').val();
                  var listflag = $('#listflag').val();
                  var currentDoctor = $('#current_doctor').val();
                  var visitTypeField = $("#visit_type").val();
                  var locationId = $("#locationId").val();
                  $('#busy-indicator').show();
                  var data = 'status=' + status +'&is_discharge=' + isDischarge +'&current_doctor=' + currentDoctor +'&admissionid=' + admissionidField.val() +'&doctor_userid=' + doctor_userid +'&scheduledate=' + $("#scheduledate").val() +'&schedule_starttime=' + schedule_starttime + '&schedule_endtime=' + schedule_endtime + '&visit_type=' + visitTypeField + '&department=' + departmentid + '&purpose=' + bodydesc + '&appointment_with='+appointment_with+'&listflag='+listflag+'&location_id='+locationId;
                 //alert(data);
                  $.ajax({
                      url: "<?php echo $this->Html->url(array("controller" => "DoctorSchedules", "action" => "saveDoctorEvent", "admin" => false)); ?>",
                      type: "GET",
                      data: data,
                      success: function (html) {
                      $('#busy-indicator').hide();
                        if($.trim(html) == "save") { 
						      $calendar.weekCalendar("removeUnsavedEvents");
			                  $calendar.weekCalendar("updateEvent", calEvent);
			                  $dialogContent.dialog("close");
			                  window.location = "<?php echo $this->Html->url(array("controller" => "DoctorSchedules", "action" => "doctor_event"));?>";
							//window.location = "<?php //echo $this->Html->url(array("controller" => "Appointments", "action" => "appointments_management", $doctorData['DoctorProfile']['user_id'], $showCalendarDay, 'patientid'=>$patientAppointmentData['Patient']['id']));?>";
						}else{
							var style= 'style="left: 26%;"';
							mess = $("span.ui-dialog-title").html();
							html += '';
							if($.trim(html) == '') { html = 'Please enter patient information';}
							$("span.ui-dialog-title").html('<span class="message" '+style+'>'+html+'</span>'+'<br>'+mess);
						}
            		}
          		});
                  /*$('#busy-indicator').show();
                  $calendar.weekCalendar("removeUnsavedEvents");
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");*/
               },
              Cancel : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show(function(){
             var DocAry  = JSON.parse('<?php echo json_encode($doctorListArray) ?>');
             $("#appointment_with").val(DocAry[calEvent.userId]);
        	 var backDateAppRestrictDate = '<?php echo $backDateAppRestrictDate?>';
        	 var curDate = '<?php echo strtotime(date('Y-m-d')); ?>';
 			//if( /*(backDateAppRestrictDate < curDate) ||*/ (calEvent.start/*.getDate()*/ < (new Date)/*.getDate()*/ ) ){
        	 
        	 var currentTimeInSec = calEvent.start.getTime() / 1000   ; //by pankaj 

        	// alert(calEvent.start.getTimezoneOffset()); 

        	 var currentDateTimeInSec = "<?php echo strtotime("now")  /* date("Y-m-d H:i:s","1410922800") */; ?> " ;

        	// alert(currentTimeInSec+"++++++++++++++"+currentDateTimeInSec);
        	 if(currentTimeInSec  < currentDateTimeInSec ){
                $dialogContent.dialog("close");  
                alert('Past date or time appointment not allowed.');
             }
             });

       	//$dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start)); // text remove and datepicker added -gaurav
       	var calenderDate = new Date('<?php echo $year.','.$month.','.$day; ?>');
       	var getDate = calEvent.start;
       	$dialogContent.find("#scheduledate").val(getDate.format('d/m/Y'));//format function is declared in default.js
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
         <?php if(empty($this->request->query['reScheduleAppt'])){ ?>
         if (calEvent.status != 'Pending') {
        	 var statusString = calEvent.status;
             var alertMsg = "This patient encounter is "+statusString.toLowerCase()+", cannot update appointment.";
             alert(alertMsg);
             return;
         }
         <?php } ?>
         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
           
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var visitTypeField = $dialogContent.find("select[name='visit_type']").val(calEvent.visit_type);
         var locationidField = $dialogContent.find("select[name='location_id']").val(calEvent.location_id);
         var admissionidField = $dialogContent.find("input[name='admissionid']").val(calEvent.admissionid);
         var patientuidField = $dialogContent.find("input[name='patientuid']").val(calEvent.patientuid);
         var patientnameField = $dialogContent.find("input[name='patientname']").val(calEvent.patientnamenoinitial); 
         var appointmentWithField = $dialogContent.find("select[name='appointment_with']").val(calEvent.appointment_with);
         
		 var isDichargeField = $dialogContent.find("select[name='is_discharge']").val(calEvent.is_discharge);
		 $('#is_discharge').val(calEvent.is_discharge);
		 $('#visit_type').val(calEvent.visit_type);
		 $('#locationId').val(calEvent.location_id);
		 $('#treatment_type_txt').val(calEvent.visit_type_name);
		 $('#dateofbirth').val(calEvent.dateofbirth);
		 var statusField = $dialogContent.find("select[name='status']").val(calEvent.status);
         var appointmentConfirmedWithField = $dialogContent.find("select[name='confirmed_by_doctor']").val(calEvent.confirmedWithOther);
         //var appointmentByOtherField = $dialogContent.find("select[name='appointment_with']").val(calEvent.appointment_with);
         //var appointmentWithCalendarDoctorField = $dialogContent.find("select[name='appointment_with']").val(calEvent.appointment_with);
         
         if(calEvent.confirmedWithOther == 'Yes'){
          	var appointmentConfirmedWithField = $('input[name="confirmed_by_doctor"][value="Yes"]').prop('checked', true);
         }
         if(calEvent.confirmedWithOther == 'No'){
           	var appointmentConfirmedWithField = $('input[name="confirmed_by_doctor"][value="No"]').prop('checked', true);
         }
         if(calEvent.confirmedWithOther == 'Awaiting'){
           	var appointmentConfirmedWithField = $('input[name="confirmed_by_doctor"][value="Awaiting"]').prop('checked', true);
         }	
         
         if(calEvent.isScheduledByOther == 1){
             $("#showConfirmAppointment").show();
        	 var isScheduledByOtherField = $dialogContent.find("select[name='scheduled_by_other_doctor']").val(calEvent.isScheduledByOther);
         }else{
             $("#showConfirmAppointment").hide();
        	 var isScheduledByOtherField = $dialogContent.find("select[name='scheduled_by_other_doctor']").val(calEvent.isScheduledByOther);
         }

         $('#appointment_with').val();
         var bodyField = $dialogContent.find("textarea[name='body']");
	 var ss = calEvent.body;
         bodyField.val(ss.replace(/<br \/>/gi, "\n"));  
         
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
               Update : function() {
                  var scheduledate = new Date(startField.val()).getFullYear()+"-"+eval(new Date(startField.val()).getMonth()+1)+"-"+new Date(startField.val()).getDate();
                  
                  startZero  = new Date(startField.val()).getMinutes() ;
                  startZero  =  (startZero < 10)?'0'+startZero:startZero ;
                   
                  var schedule_starttime = new Date(startField.val()).getHours()+":"+ startZero;
                  
                  endZero  = new Date(endField.val()).getMinutes() ;
                  endZero  =  (endZero < 10)?'0'+endZero:endZero ;                 
                  var schedule_endtime = new Date(endField.val()).getHours()+":"+ endZero;
 
                 
                  calEvent.start = new Date(startField.val());
                  if(calEvent.start == "Invalid Date") {
                      return false;
                  }
                  calEvent.end = new Date(endField.val());
                //  calEvent.visit_type = visitTypeField.val();
                  calEvent.admissionid = admissionidField.val();
                  calEvent.patientuid = patientuidField.val();
                  calEvent.body = bodyField.val();
                  calEvent.confirmed_by_doctor = $('input[name=confirmed_by_doctor]:checked').val();

                  var regX = /\n/gi ;
                  bodydesc = new String(bodyField.val());
                  bodydesc = bodydesc.replace(regX, "<br />");
                  var doctor_userid = $('#doctor_userid').val();
                  var departmentid = $('#department').val();
                  var appointment_with = $('#appointment_with').val();
                  var listflag = $('#listflag').val();
                  var is_discharge = $('#is_discharge').val();
                  var status = $('#status').val();
                  var visitTypeField = $("#visit_type").val();
                  var locationId = $('#locationId').val();
                  var currentDoctor = $('#current_doctor').val();
                  var confirmed_by_doctor = $('input[name=confirmed_by_doctor]:checked').val();
                  
                  $('#busy-indicator').show();
                  
                  var data = 'status=' + calEvent.status + '&is_discharge=' + is_discharge + '&confirmed_by_doctor=' + calEvent.confirmed_by_doctor + '&current_doctor=' + currentDoctor +'&id=' + calEvent.id +'&admissionid=' + admissionidField.val() + '&doctor_userid=' + doctor_userid + '&scheduledate=' + $("#scheduledate").val() +'&schedule_starttime=' + schedule_starttime + '&schedule_endtime=' + schedule_endtime + '&visit_type=' + visitTypeField + '&department=' + departmentid + '&purpose=' + bodydesc+'&appointment_with='+appointment_with+'&listflag='+listflag+'&location_id='+locationId;

                  $.ajax({
                      url: "<?php echo $this->Html->url(array("controller" => "DoctorSchedules", "action" => "updateScheduleEvent", "admin" => false)); ?>",
                      type: "GET",
                      data: data,
                      success: function (html) {
                         $('#busy-indicator').hide();
                     	if($.trim(html) == "save") {
                     		window.location = "<?php echo $this->Html->url(array("controller" => "DoctorSchedules", "action" => "doctor_event"));?>"; 
                    	 // window.location = "<?php //echo $this->Html->url(array("controller" => "Appointments", "action" => "appointments_management", $doctorData['DoctorProfile']['user_id'], $showCalendarDay, 'patientid'=>$patientAppointmentData['Patient']['id'], 'listflag' => $this->params['named']['listflag']));?>";
						}else{
							mess = $("span.ui-dialog-title").html();
							html += '';
							$("span.ui-dialog-title").html('<span class="message">'+html+'</span>'+'<br>'+mess);
						}
                      } 
                  });
                 /* $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");*/
               },
               "Delete" : function() {
				  var confbox = confirm("Are you sure?");
				  if (confbox==true)  {
					  var data = 'id=' + calEvent.id;
					  $('#busy-indicator').show();
					  $.ajax({
						  url: "<?php echo $this->Html->url(array("controller" => "DoctorSchedules", "action" => "deleteScheduleEvent", "admin" => false)); ?>",
						  type: "GET",
						  data: data,
						  success: function (html) {
							$('#busy-indicator').hide();
						  	window.location = "<?php echo $this->Html->url(array("controller" => "DoctorSchedules", "action" => "doctor_event"));?>";
						  }
					   });
					  $calendar.weekCalendar("removeEvent", calEvent.id);
					  $dialogContent.dialog("close");
				  } else {
					  return false;
				  }
               },
               Cancel : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         //$dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));// text remove and datepicker added -gaurav
         //$dialogContent.find("#scheduledate").val($calendar.weekCalendar("formatDate", calEvent.start));
          var Editdate = calEvent.start
         $dialogContent.find("#scheduledate").val(Editdate.format('d/m/Y'));
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
                 $allEventVal['DoctorProfile']['appointment_visit_color'] = unserialize($allEventVal['DoctorProfile']['appointment_visit_color']);
                 for($i=1; $i<=count($allEventVal['DoctorProfile']['appointment_visit_color'])-1;$i++){
                 	$allEventVal['DoctorProfile']['appointment_visit_color'][$i] = str_replace("background-color:", "", trim($allEventVal['DoctorProfile']['appointment_visit_color'][$i]));
                 }
             if((!empty($expDate[0]) || !empty($expDate[1]) || !empty($expDate[2])) && (!empty($expStartTime[0]) || !empty($expStartTime[1]) || !empty($expEndTime[0]) || !empty($expEndTime[1]))) { $innereventcnt++;
             
             ?>
            {
               "userId":<?php  $userKey = array_search($allEventVal["Appointment"]["appointment_with"],$doctorListArray);echo $userKey;?>,
               "id":<?php echo $allEventVal["Appointment"]["id"]; ?>,
               "start": new Date(<?php echo $expDate[0]; ?>, <?php echo $expDate[1]-1; ?>, <?php echo $expDate[2]; ?>, <?php echo $expStartTime[0]; ?>,<?php echo $expStartTime[1]; ?>),
               "end": new Date(<?php echo $expDate[0]; ?>, <?php echo $expDate[1]-1; ?>, <?php echo $expDate[2]; ?>, <?php echo $expEndTime[0]; ?>,<?php echo $expEndTime[1]; ?>),
               "admissionid":"<?php echo $allEventVal["Patient"]["admission_id"]; ?>",
               "patientuid":"<?php echo $allEventVal["Patient"]["patient_id"]; ?>",
               "dateofbirth":"<?php echo $this->DateFormat->formatDate2Local($allEventVal['Person']['dob'],Configure::read('date_format'),false); ?>",
               "dashboardurlpatientid":"<?php echo $allEventVal["Patient"]["id"]; ?>",
               "patientname":"<?php echo $allEventVal["Patient"]["lookup_name"]; ?>",
               "patientnamenoinitial":"<?php echo $allEventVal["Patient"]["lookup_name"]; ?>",
               "appointment_with":"<?php echo $allEventVal["Appointment"]["appointment_with"]; ?>",
               "scheduled_by_other_doctor":"<?php echo $allEventVal["Appointment"]["scheduled_by_other_doctor"]; ?>",
               "confirmed_by_doctor":"<?php echo $allEventVal["Appointment"]["confirmed_by_doctor"]; ?>",
               "calendar_doctor_id":"<?php echo $allEventVal["Appointment"]["calendar_doctor_id"]; ?>",
               "visit_type":"<?php echo $allEventVal["Appointment"]["visit_type"]; ?>",
               "visit_type_name":"<?php echo html_entity_decode( $visitTypeArray[$allEventVal["Appointment"]["visit_type"]] ); ?>",
               "location_id":"<?php echo $allEventVal["Appointment"]["location_id"]; ?>",
               "is_discharge":"<?php echo ($allEventVal["Patient"]["is_discharge"])?$allEventVal["Patient"]["is_discharge"]:'0'; ?>",
               "body":"<?php echo html_entity_decode( trim($allEventVal["Appointment"]["purpose"])); ?>",
			   "status":"<?php echo html_entity_decode( $allEventVal["Appointment"]["status"]); ?>",
               "doctorName":"<?php echo html_entity_decode( $allEventVal["DoctorProfile"]["doctor_name"]); ?>",
               "isScheduledByOther":"<?php echo html_entity_decode( $allEventVal['Appointment']['scheduled_by_other_doctor']); ?>",
               "confirmedWithOther":"<?php echo html_entity_decode( $allEventVal['Appointment']['confirmed_by_doctor']); ?>",
               <?php
               	/*if($allEventVal["Appointment"]["scheduled_by_other_doctor"] == 1){
                	$evColor = $allEventVal['Appointment']['doctor_id']; ?>
                    "presentcolorcode":"<?php if($doctorColorList[$evColor]) echo $doctorColorList[$evColor]; else echo "yellow"; ?>",
               <?php }else{ */?>
               		<?php if($allEventVal["DoctorProfile"]["show_color_from"]){ //show visit type color?>
               			"presentcolorcode":"<?php echo $visitColor = ($allEventVal['DoctorProfile']['appointment_visit_color'][$allEventVal["Appointment"]["visit_type"]]) ?  trim($allEventVal['DoctorProfile']['appointment_visit_color'][$allEventVal["Appointment"]["visit_type"]]) : "rgb(255, 255, 0);"; ?>",
               		<?php }else{//show doctor color?>
                   		"presentcolorcode":"<?php echo $visitColor = ($allEventVal["DoctorProfile"]["present_event_color"]) ? trim($allEventVal["DoctorProfile"]["present_event_color"]) : "rgb(255, 255, 0);"; ?>",
               		<?php }?>
               	<?php //} ?>

               "pastcolorcode":"<?php if($allEventVal["DoctorProfile"]["past_event_color"]) echo $allEventVal["DoctorProfile"]["past_event_color"]; else echo "#e6e6e6"; ?>",
               "futurecolorcode":"<?php if($allEventVal["DoctorProfile"]["future_event_color"]) echo $allEventVal["DoctorProfile"]["future_event_color"]; else echo "#e6e6e6"; ?>"
               <?php if(!($this->DateFormat->formatDate2STD($allEventVal['Appointment']['date'],'yyyy-mm-dd') >= date("Y-m-d"))) { 
			   
                         echo ', "readOnly": true';
                     } 
              ?>
            }
            <?php } if($eventcnt != count($allEvent) && $innereventcnt > 0) echo ","; ?>
            
           <?php } ?>
         ],
         freebusys: [
        				<?php echo $freeBusys;?>
        			]
      };
   }


   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {
    	$startTimeField.empty();$endTimeField.empty(); // removing old dropdown values
    	setStartOptions = false;
      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         if (startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
            setStartOptions = true;
         }
         var endSelected = "";
         if (endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
         }
         if(setStartOptions)
         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

      }
      $endTimeOptions = $endTimeField.find("option");
     // if(calEvent.id === undefined)
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
            $(this).prop("selected", "selected");
            endTimeSelected = true;
            return false;
         }
      });

      if (!endTimeSelected) {
         $endTimeField.find("option:eq(0)").prop("selected", true);
         //automatically select an end date 2 slots away.
         //$endTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });


});

</script>
<div class="inner_title">
	<h3>
		<div style="float: left">
			<?php echo __('Appointment Scheduling'); ?>
		</div>
	</h3>
	<div class="clr"></div>
</div>
<style>
.highlightColor {
	background-color: #4C5E64;
	padding: 5px;
	cursor: pointer;
	cursor: hand;
	width: 90%;
	border-bottom: solid 1px #ffffff;
	float: left;
	color: #fff !important;
}

#datepickerIcon {
	width: 50px;
	height: 50px;
}
</style>
<!-- <div style="text-align:left;margin-top:10px;">
 <table border="0" cellpadding="0" cellspacing="0">
  <TR>
   <TD><b><?php //echo __('Treating Consultant'); ?></b></TD>
   <TD>&nbsp;&nbsp;:&nbsp;&nbsp;</TD>
   <TD><?php //echo $doctorData['Initial']['name'].' '.$doctorData['DoctorProfile']['doctor_name']; ?></TD>
  </TR>
  <TR>
   <TD><b><?php //echo __('Specilty'); ?></b></TD>
   <TD>&nbsp;&nbsp;:&nbsp;&nbsp;</TD>
   <TD><?php //echo $doctorData['Department']['name']; ?></TD>
  </TR>
 </table>
</div> -->

<div style="text-align: center; margin-top: 10px;">
	<span id="savedApp"></span>
	<?php 
	// listflag is used for future appointment flag //
	echo $this->Html->link(__('Daily Appointment'), array('action' => 'doctor_event', $doctorData['DoctorProfile']['user_id'], 1, 'patientid' => $patientAppointmentData['Patient']['id'], 'listflag' => $this->params['named']['listflag']), array('escape' => false,'class'=>'blueBtn'));
	?>
	&nbsp;&nbsp;
	<?php 
	echo $this->Html->link(__('Weekly Appointment'), array('action' => 'doctor_event', $doctorData['DoctorProfile']['user_id'], 7, 'patientid' => $patientAppointmentData['Patient']['id'], 'listflag' => $this->params['named']['listflag']), array('escape' => false,'class'=>'blueBtn'));
	?>
	&nbsp;&nbsp;
	<?php 
	//echo $this->Html->link(__('Back'), array('controller'=>'Appointments','action' =>'appointments_management'), array('escape' => false,'class'=>'blueBtn'));
	?>
</div>
<!--
<div style="text-align:left;margin-bottom:-40px;margin-left:-12px;padding-top:30px;">
 <?php 
    //echo $this->Html->link(__('New Patient'), array('controller'=>'persons','action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
 ?>&nbsp;&nbsp;
 <?php 
    //echo $this->Html->link(__('Existing Patient'), array('controller'=>'patients','action' => 'add', '?type=OPD'), array('escape' => false,'class'=>'blueBtn'));
 ?>
</div>
-->
<div align="center" id="busy-indicator" style="display: none;">
	<?php echo $this->Html->image('indicator.gif'); ?>
</div>
<div class="clr ht5"></div>
<input
	type="hidden" name="listflag" id="listflag"
	value="<?php echo $this->params['named']['listflag']; ?>" />
<input
	type="hidden" name="apppatientid" id="apppatientid"
	value="<?php echo $patientAppointmentData['Patient']['id']; ?>" />
<input
	type="hidden" name="appadmissionid" id="appadmissionid"
	value="<?php echo $patientAppointmentData['Patient']['admission_id']; ?>" />
<input
	type="hidden" name="apppatientuid" id="apppatientuid"
	value="<?php echo $patientAppointmentData['Patient']['patient_id']; ?>" />
<input
	type="hidden" name="apppatientname" id="apppatientname"
	value="<?php echo $patientAppointmentData['Patient']['lookup_name']; ?>" />
<input
	type="hidden" name="apppatientdob" id="apppatientdob"
	value="<?php echo $patientAppointmentData['Person']['dob']; ?>" />
<input 
	type="hidden" name="applocationid" id="applocationid"
		value="<?php echo $patientAppointmentData['Patient']['location_id']; ?>" />
<div>
	<?php if(count($doctorDataList) == 1 && $removeFlag['0'] == $this->Session->read('userid')){?>
	<div style="padding-left: 43px; padding-bottom: 5px;">
		<span>Calender Work Hours</span></br> <input type="text"
			id="timepicker_start" class="timeCalender" readonly="readonly"
			name="data[DoctorProfile][starthours]"
			value="<?php echo $this->data['DoctorProfile']['starthours']?>"> <input
			type="text" id="timepicker_end" class="timeCalender"
			readonly="readonly" name="data[DoctorProfile][endhours]"
			value="<?php echo $this->data['DoctorProfile']['endhours']?>">
	</div>
	<?php }?>
	<div style="float: left; width: 15%;">
		<div id="datepicker" style="padding: 0 0 23px 16px;"></div>

		<?php foreach($doctorDataList as $key=>$doctorList){ ?>
		<div class="highlightColor">
			<div class="color-box" style="background-color:<?php echo $doctorColorList[$key];?>;" id="color-box<?php echo $key;?>"
				onclick="callGetAppointments('<?php echo $key;?>','<?php echo $key;//selectedDocFlag?>')"></div>
			<span style="text-align: middle;"
				onclick="callGetAppointments('<?php echo $key;?>','<?php echo $key;//selectedDocFlag?>')">
				<?php echo $doctorList; ?>
			</span> <span style="float: right; width: 20px; height: 20px;"
				class="colorPicker" id="colorPicker_<?php echo $key;?>"
				title="Choose Color">&nbsp;</span>
		</div>
		<?php } ?>
		<?php if(count($doctorDataList) == 1 && $removeFlag['0'] == $this->Session->read('userid')){?>
		<div class="highlightColor" style="text-align: center;" id="visitDiv">
			<span id="visitColor"> <?php echo 'Visit Types'; ?>
			</span>
		</div>
		<div style="display: none;" id="visitTypeDiv">
			<?php foreach($visitTypeArray as $key=>$visitType){ ?>
			<div class="highlightColor">
				<?php $doctorVisitColor[$key] = ($doctorVisitColor[$key]) ? $doctorVisitColor[$key] : '	background-color:'?>
				<div class="color-box visitBox" style="<?php echo $doctorVisitColor[$key];?>"id="visit-box_<?php echo $key;?>"></div>
				<span style="text-align: center; font-size: 11px;"> <?php echo $visitType; ?>
				</span> <span style="float: right; width: 20px; height: 20px;"
					class="colorPickerVisit" id="colorPickerVisit_<?php echo $key;?>"
					title="Choose Color">&nbsp;</span>
			</div>
			<?php } ?>
		</div>
		<?php }?>
		<div style="margin: 0px; padding: 0px">
			<?php 
			$showVisit = $this->data['DoctorProfile']['show_color_from'];
			if((count($removeFlag) == 1 && $removeFlag['0'] != 'select_all')) {
				echo $this->Form->input('',array('value'=>$removeFlag['0'],'type'=>'checkbox','checked'=>$showVisit,'name'=>'show_visit_color','id'=>'show_visit_color','div'=>false,'label'=>false,'error'=>false));?>
			<span style="text-align: middle; font-size: 11px !important;"> <?php echo __('Visit Color'); ?>
			</span>
			<?php }?>
		</div>

		<div style="margin: 0px; padding: 0px">
			<?php 
			$justMe = ($removeFlag[0] == $this->Session->read('userid')) ? '"checked"' : false;
			$selectAll = ($removeFlag[0] == 'select_all')  ? '"checked"' : false;
			if(!$selectAll){
				echo $this->Form->input('',array('type'=>'checkbox','checked'=>$selectAll,'name'=>'select_all','id'=>'select_all','div'=>false,'label'=>false,'error'=>false));?>
			<span style="text-align: middle;"> <?php echo __('Select All'); ?>
			</span>
			<?php }?>
			<?php 
			if($this->Session->read('role') == Configure::read('doctorLabel')) {
				echo $this->Form->input('',array('type'=>'checkbox','checked'=>$justMe,'name'=>'just_me','id'=>'just_me','div'=>false,'label'=>false,'error'=>false));?>
			<span style="text-align: middle;"> <?php echo __('Just me'); ?>
			</span>
			<?php }?>
		</div>
	</div>

	<div id='calendar' style="float: right; width: 85%"></div>
</div>


<div id="event_edit_container" style="display: none;">
	<form>

		<ul>
			<?php if($this->Session->read('website.instance')=='vadodara'){ ?>
			<li><?php echo __('Patient Location'); ?>:<br /> <?php 
				echo $this->Form->input('', array('name'=>'location_id','value'=>$this->Session->read('locationid'),'options'=>$locations,'id'=>'locationId',
						'label'=>false,'error'=>false,'onChange'=>'getLocationDoctor($(this).val())'));?>
				</li>
		<?php }?>
			<li><span><?php echo __('Date'); ?>: </span><span class="date_holder"><input
					type="text" name="scheduledate" readonly="readonly"
					id="scheduledate" style="width: 86%;" /> </span>
			</li>
			<li><?php echo __('Start Time'); ?>: <select name="start"><option
						value="">
						<?php echo __('Select Start Time'); ?>
					</option>
			</select>
			</li>
			<li><?php echo __('End Time'); ?>: <select name="end"><option
						value="">
						<?php echo __('Select End Time'); ?>
					</option>
			</select>
			</li>
			<li><?php echo __('Primary Care Provider')?>:<br /> <?php 
			echo $this->Form->hidden('is_discharge',array('value'=>'','id'=>'is_discharge'));
			echo $this->Form->hidden('status',array('value'=>'','id'=>'status'));
			if($this->Session->read('role') == Configure::read('doctorLabel')) {//old variable at default and value =>$currentDoctor
                           	echo $this->Form->input('',array('name'=>'appointment_with','id'=>'appointment_with',/*'empty'=>'Please Select',*/'options'=>$doctors, 'default'=> $this->request->params['named']['doctorid'] , 'div'=>false,'label'=>false,'error'=>false));
                           	echo $this->Form->hidden('current_doctor',array('value'=>$currentDoctor,'id'=>'current_doctor'));
                           } else {
                     	    echo $this->Form->input('',array('name'=>'appointment_with','id'=>'appointment_with',/*'empty'=>'Please Select',*/'default'=> $this->request->params['named']['doctorid'],'options'=>$doctors,'div'=>false,'label'=>false,'error'=>false));
                     	    //echo $this->Form->hidden('current_doctor',array('value'=>$currentDoctor,'id'=>'current_doctor'));
                           }
                           ?>
			</li>
			<li><?php echo __('Visit Type'); ?>:<br /> <?php 
			//echo $this->Form->input('',array('name'=>'treatment_type_txt','id'=>'treatment_type_txt','div'=>false,'label'=>false,'error'=>false));
			echo $this->Form->input('', array('name'=>'visit_type','empty'=>'Please Select','options'=>$visitTypeArray,'id'=>'visit_type','label'=>false,'error'=>false));
				echo $this->Form->hidden('', array('name'=>'admissionid','type'=>'text','id'=>'admissionid'));?>
			</li>
			<li><?php echo __('Patient Name');//gaurav ?>: <input type="text"
				name="patientname" id="patientname" />
			</li>
			<li><?php echo __('UID'); ?>:<br /> <input type="text"
				name="patientuid" id="patientuid" />
			</li>
			<li><?php echo __('DOB'); ?>: <input type="text" name="dateofbirth"
				readonly="readonly" id="dateofbirth" />
			</li>
			<li><?php echo __('Reason of Visit'); ?>: </label> <textarea
					name="body"></textarea>
			</li>
			<li id="showConfirmAppointment" style="display: none"><?php echo __('Confirm Appointment'); ?>:

				<table width="100px">
					<tr>
						<td width="50px"><?php echo __('Awaiting');?></td>
						<td><input type="radio" value="Awaiting"
							name="confirmed_by_doctor" id="confirmed_by_doctor"></td>
						<td width="50px"><?php echo __('Yes');?></td>
						<td><input type="radio" value="Yes" name="confirmed_by_doctor"
							id="confirmed_by_doctor"></td>
						<td width="50px"><?php echo __('No');?></td>
						<td><input type="radio" value="No" name="confirmed_by_doctor"
							id="confirmed_by_doctor"></td>
					</tr>
				</table>
			</li>
			<!-- not in use gaurav -->
			<!-- <li><a href="#" name="urlpatient" style="color: white;">View Patient
						Dashboard</a></br>
						<a href="<?php echo $this->Html->url("/Persons/quickReg"); ?>" name="urlQuichReg" style="color: white;">Quick Registration</a>
				</li> -->
		</ul>
	</form>
</div>
<style>
#confirmed_by_doctor {
	float: left;
	width: auto;
}
</style>
<script>
//$(document).ready(function(){
    	// for automatic patient search//
        //$("#admissionid").autocomplete("<?php //echo $this->Html->url(array("controller" => "DoctorSchedules", "action" => "autoSearchAdmissionId", "admin" => false,"plugin"=>false)); ?>", {
				//width: 250,
				//selectFirst: true
	//}); 

        //$("#calendar").click(function(){ 
        //     $('#showpatientname').hide();
            
        //}); 
        // get patient name from admission id //
        //$("#admissionid").blur(function(){ 
        // var paid = $('#admissionid').val();
        // var data = 'paid=' + paid ;
        // $.ajax({url: "<?php //echo $this->Html->url(array("controller" => "DoctorSchedules", "action" => "ajaxGetPatientName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#showpatientname').show();$('#busy-indicator').hide();$('#showpatientname').html(html); } });
        // }); 
			
//	 	});

 
$( "#just_me" ).click(function() {
	//getAppointments(0,'just_me');
	 if($('#just_me').is(':checked')) {
		 getAppointments(0,'just_me','');
	 }else{
		 getAppointments(0,'select_all','');
	 }
	
});
$( "#select_all" ).click(function() {
	if($('#select_all').is(':checked')) {
		 getAppointments(0,'select_all','');
	 }else{
		 getAppointments(0,'just_me','');
	 }
});
$( "#show_visit_color" ).click(function() {
	var userId = $(this).val();
	if($('#show_visit_color').is(':checked')) {
		getChangeCalColor(1,userId);
	 }else{
	 	getChangeCalColor(0,userId);
	 }
	
});
var httpRequestchangeColor = '';
var httpRequestchangeColorURL = "<?php echo $this->Html->url(array("controller" => 'DoctorSchedules', "action" => "getChangeCalColor","admin" => false)); ?>" ;
function getChangeCalColor(changeColor,userId){
	if(httpRequestchangeColor) httpRequestchangeColor.abort();
	
	var httpRequestchangeColor = $.ajax({
	  url: httpRequestchangeColorURL + '/' + changeColor + '/' + userId,
      context: document.body,
      type: "POST",
      success: function(data){ 
    	  getAppointments(0,userId,'');
	 },
      error:function(){
			alert('Please try again');
		}
	});
}

var timeoutReference = '';
var test = 0;
var newFlag = [];

function callGetAppointments(doctorId, flag) {
	test++;
	newFlag.push( flag );
	$('#color-box'+flag).addClass('tick');
	clearTimeout(timeoutReference);
	timeoutReference = setTimeout( function(){
		if(test > 0){
	    	test = 0;
			getAppointments(doctorId,newFlag);
	    }
		    }, 3000);
}
var httpRequestgetAppointments = '';
var namedParams = "<?php echo $params;?>";
var getAppointmentsURL = "<?php echo $this->Html->url(array("controller" => 'DoctorSchedules', "action" => "doctor_event",$showCalendarDay,"admin" => false)); ?>" ;
function getAppointments(doctorId,flag,date){
	if(httpRequestgetAppointments) httpRequestgetAppointments.abort();
	if(date == '') date = 'null';
	var httpRequestgetAppointments = $.ajax({
		  beforeSend: function(){
			  loading(); // loading screen
		  },
		  url: getAppointmentsURL + '/' + doctorId + '/' +flag+ '/' + date + '/' + 'Calendar' + '/' + namedParams,
		  context: document.body,
	      type: "POST",
	      success: function(data){ 
		     $("#calContent").html(data);
		     onCompleteRequest();
 		  },
		  error:function(){
				alert('Please try again');
				
			  }
	});
}


var httpRequestSaveColor = '';
var httpRequestSaveColorURL = "<?php echo $this->Html->url(array("controller" => 'DoctorSchedules', "action" => "saveDoctorColor",$showCalendarDay,"admin" => false)); ?>" ;
function saveDoctorColor(doctorId,color){
	if(httpRequestSaveColor) httpRequestSaveColor.abort();
	
	var httpRequestSaveColor = $.ajax({
	  url: httpRequestSaveColorURL,
      context: document.body,
      type: "POST",
      data: {doctorId:doctorId,color:color},
      success:function(){
    	  var removeFlag = "<?php echo  $this->request->params['pass']['2'];?>";
    	  removeFlag = (removeFlag != '') ? removeFlag : 'select_all';
    	  getAppointments(0,removeFlag,'');
      },
      error:function(){
			alert('Please try again');
		}
	});
}

var httpRequestVisitColorURL = "<?php echo $this->Html->url(array("controller" => 'DoctorSchedules', "action" => "saveVisitColor",$showCalendarDay,"admin" => false)); ?>" ;
function saveVisitColor(){
	var colors = [];
	var colorsIn = [];
	$(".visitBox").map(function(){
		var lastId = $(this).attr('id').split("_");
		var visitId = lastId[1]; 
		if(visitId !== undefined && $(this).attr('style') !== undefined){
			colors.push(visitId);
			colorsIn.push($(this).attr('style'));
		}
			
	});
	if(httpRequestSaveColor) httpRequestSaveColor.abort();
	var httpRequestSaveColor = $.ajax({
		  url: httpRequestVisitColorURL,
	      context: document.body,
	      type: "POST",
	      data: {color:colors,colors:colorsIn},
	      success:function(){
	    	  getAppointments(0,'just_me','');
	      },
	      error:function(){
				alert('Please try again');
			}
	});
}

$('.colorPicker').colpick({
	layout:'rgbhex',
	color:'ff8800',
	onSubmit:function(hsb,hex,rgb,el) {
		var lastId = el.id;
		lastId = lastId.split("_");
		$("#color-box"+lastId[1]).css('background-color', '#'+hex);
		$(el).colpickHide();
		saveDoctorColor(lastId[1],'#'+hex);
	}
	
});

$('.colorPickerVisit').colpick({
	layout:'rgbhex',
	color:'ff8800',
	onSubmit:function(hsb,hex,rgb,el) {
		var lastId = el.id;
		lastId = lastId.split("_");
		$("#visit-box_"+lastId[1]).css('background-color', '#'+hex);
		$(el).colpickHide();
		saveVisitColor();
	}
	
});

function loading(){
	 $('#main-grid').block({ 
      message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Initializing...</h1>', 
      css: {            
          padding: '5px 0px 5px 18px',
          border: 'none', 
          padding: '15px', 
          backgroundColor: '#000', 
          '-webkit-border-radius': '10px', 
          '-moz-border-radius': '10px',               
          color: '#fff',
          'text-align':'left' 
      },
      overlayCSS: { backgroundColor: '#cccccc' } 
  }); 
}

function onCompleteRequest(){
	$('#main-grid').unblock(); 
}
//$('#picker').colpick();

$(function(){
	var caleDate = new Date('<?php echo $year.','.$month.','.$day; ?>');
	$('#datepicker').datePicker({inline:true,startDate:new Date('01/01/1975')}).dpSetSelected(caleDate.format('j/m/Y'))
	.bind('dateSelected',function(e, selectedDate, $td){
		var formattedDate = selectedDate.format('Y-m-d');
		var removeFlag = "<?php echo  $this->request->params['pass']['2'];?>";
		removeFlag = (removeFlag != '') ? removeFlag : 'select_all';
		getAppointments('0', removeFlag, formattedDate);
	});
		
	
	Date.format  = "<?php echo trim($this->General->GeneralDateForJS());?>";
	$('#scheduledate').datePicker({inline:false,clickInput:true});
});
//back-color-box
$( ".color-box" ).click(function() {
	$("#"+this.id).addClass("back-color-box");
	var doctorId = this.id;
	doctorId = doctorId.split("color-box");
	doctorId = doctorId[1]; 
	//getAppointments(doctorId,null,'');
});
$('#visitDiv').click(function (e) {
    e.preventDefault();
    $('#visitTypeDiv').slideToggle( "slow" );
    //$('#about').slideDown();
});
function hexToRgb(hex) {
	   var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	   return result = "rgb("+parseInt(result[1], 16)+" ,"+parseInt(result[2], 16)+" ,"+parseInt(result[3], 16)+" );";
	  /* return result ? {
	       r: parseInt(result[1], 16),
	       g: parseInt(result[2], 16),
	       b: parseInt(result[3], 16)
	   } : null;*/
}
var globalPatientIDLookUp = '';
$(document).ready(function(){
	$( "#patientname" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "autocompleteForPatientNameAndDob",0,"Patient.admission_type=OPD","admin" => false,"plugin"=>false)); ?>",
		minLength: 1,
		select: function( event, ui ) {
			var name = ui.item.value;
			name = name.split(" - ");
			ui.item.value = name[0];
			$("#patientname").val(ui.item.value);
			globalPatientIDLookUp = ui.item.id;
			getPatientDetails('patientname');
		},
		messages: {
		  noResults: '',
		  results: function() {}
		}
	});

	$( "#admissionid" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","admission_id",'null','null','null','admission_type=OPD', "admin" => false,"plugin"=>false)); ?>",
		minLength: 1,
		select: function( event, ui ) {
			$("#admissionid").val(ui.item.value);
			getPatientDetails('admissionid');
		},
		messages: {
		  noResults: '',
		  results: function() {}
		}
	});
	$( "#patientuid" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","patient_id",'null','null','null','admission_type=OPD', "admin" => false,"plugin"=>false)); ?>",
		minLength: 1,
		select: function( event, ui ) {
			$("#patientuid").val(ui.item.value);
			getPatientDetails('patientuid');
		},
		messages: {
		  noResults: '',
		  results: function() {}
		}
	});
	$( "#treatment_type_txt" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","TariffList","name","no","null","no","check_status=1","admin" => false,"plugin"=>false)); ?>",
		minLength: 1,
		select: function( event, ui ) {
			$('#visit_type').val(ui.item.id);
		},
		messages: {
		  noResults: '',
		  results: function() {}
		}
	});
	$('#treatment_type_txt').click(function(){
		 $('#treatment_type_txt').val('');
		 $('#visit_type').val('');
	}); 

	function getPatientDetails(caller){
		var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "DoctorSchedules", "action" => "getPatientDetails","admin" => false)); ?>";
		var patientuid = (caller == 'patientuid') ? $("#patientuid").val() : 'null';
		var lookupName = (caller == 'patientname') ? globalPatientIDLookUp : 'null';
		
        $.ajax({
          type: 'POST',
          url: ajaxUrl+"/"+lookupName+"/"+patientuid,
          data: '',
          dataType: 'html',
          beforeSend: function(){
        	  loadingLabel(); // loading screen
		  },
          success: function(data){ 
        	  data = jQuery.parseJSON(data);
        	$("#patientname").val(data[0].Patient.lookup_name);
	        $("#admissionid").val(data[0].Patient.admission_id);
	        $("#patientuid").val(data[0].Patient.patient_id);
	       // $("#appointment_with").val(data[0].Patient.doctor_id);
	        $("#doctor_userid").val(data[0].Patient.doctor_id);
	        $("#dateofbirth").val(data[0].Person.dob);
	        if(data[1])
	        $("#department").val(data[1].User.department_id);
	      //doctor_userid appointment_with current_doctor department
	        onCompleteRequest();
          }

	     });
		}


	$('#timepicker_start').timepicker({
	    showLeadingZero: true,
	    onSelect: tpStartSelect,
	    //onClose: updateDoctorTime,
	    minTime: {
	        hour: <?php echo Configure::read('calendar_start_time') ?>, minute: 0
	    },
	    maxTime: {
	    	hour: parseInt('<?php echo substr($this->data['DoctorProfile']['endhours'],0 , 2) ?>')-1, minute: 0
	    }
	});
	$('#timepicker_end').timepicker({
	    showLeadingZero: true,
	    onSelect: tpEndSelect,
	    //onClose: updateDoctorTime,
	    minTime: {
	    	hour: parseInt('<?php echo substr($this->data['DoctorProfile']['starthours'],0 , 2) ?>')+1, minute: 0
	    },
		maxTime: {
        	hour: <?php echo Configure::read('calendar_end_time') ?>, minute: 0
    }
	});
	
	});
	
	//when start time change, update minimum for end timepicker
	function tpStartSelect( time, endTimePickerInst ) {
	$('#timepicker_end').timepicker('option', {
	    minTime: {
	        hour: endTimePickerInst.hours+1,
	        minute: endTimePickerInst.minutes
	    }
	});
	updateDoctorTime();
	}
	
	//when end time change, update maximum for start timepicker
	function tpEndSelect( time, startTimePickerInst ) {
	$('#timepicker_start').timepicker('option', {
	    maxTime: {
	        hour: startTimePickerInst.hours-1,
	        minute: startTimePickerInst.minutes
	    }
	});
	updateDoctorTime();
	}

	var httpRequestUpdateTime = '';
	var httpRequestUpdateTimeURL = "<?php echo $this->Html->url(array("controller" => 'DoctorSchedules', "action" => "updateDoctorTime","admin" => false)); ?>" ;
	function updateDoctorTime(){
		if(httpRequestUpdateTime) httpRequestUpdateTime.abort();
		if($('#timepicker_start').val() != '' && $('#timepicker_end').val() != '')
		var httpRequestUpdateTime = $.ajax({
		  url: httpRequestUpdateTimeURL,
		  context: document.body,
		  type: "POST",
		  data: {starthours:$('#timepicker_start').val(),endhours:$('#timepicker_end').val()},
		  success: function(data){ 
	    	  getAppointments(0,'just_me','');
		 },
		  error:function(){
				alert('Please try again');
			}
		});
	}
	
	function getLocationDoctor(locationId){
		var AjaxUrl = '<?php echo $this->Html->url(array('controller'=>'DoctorSchedules','action'=>'getLocationDoctor')); ?>';
		$.ajax({
	        type: 'POST',
	        url: AjaxUrl+"/"+locationId,
	        data: '',
	        dataType: 'html',
	        beforeSend: function(){
	        	loadingLabel(); // loading screen
			},
	        success: function(data){
		        data = jQuery.parseJSON(data);
		        $("#appointment_with").empty();
		        $.each(data, function (key, value) {
		 			$("#appointment_with").append( new Option(value , key) );
	 			});
		    	onCompleteRequest();
	        }
		});
	}
  </script>
<!-- <button id="picker">Show Color Picker</button> -->
