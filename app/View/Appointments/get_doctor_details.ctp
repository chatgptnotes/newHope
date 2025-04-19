<?php 
echo $this->Html->css(array('jquery.fancybox-1.3.4.css','validationEngine.jquery.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4','jquery.validationEngine.js','languages/jquery.validationEngine-en.js','ui.datepicker.3.js'));

?>
<style>
.doctr_name {
	background: #a1b6bd;
}

.doctr_detail {
	background: #374347;
	color: #fff;
	font-size: 13px;
}

.firstRow {
	font-size: 13px;
	padding-left: 225px;
	/*padding-top: 3px;*/
	text-align: -moz-center;
	width: 24%;
}
</style>
<table width="100%">
	<tr>
		<td class="firstRow"><?php echo __("Primary Care Provider");?>
		</td>
		<td width="89%"><table>
				<tr>
					<td><?php echo $this->Form->input('doctor_id', array('selected'=>$doctorId,'value'=>$doctorId,'onchange'=>"changeDoctor(this.value)",'options'=>$doctorList,'class' => " ",'id' => 'doctor_id','label'=>false,'style'=>'width:250px; margin-left: -5px;')); ?>
					</td>
					<td style=" font-size: 13px;"><?php echo __("Date");?></td>
					<td><?php echo $this->Form->input('date', array('type'=>'text','id' =>'date','class'=>'date textBoxExpnd','value'=>'','style'=>'width:120px','label'=>false)); ?>
					</td>
				</tr>
			</table>
		</td>

	</tr>

	<tr>
		<td colspan="2"><table width="100%">
				<tr>
					<td valign="top"
						style="text-align: right; padding-left: 122px; width: 9%; padding-top:3px;"><?php
						if(file_exists(WWW_ROOT."/uploads/user_images/".$doctorDetails['User']['photo']) && !empty($doctorDetails['User']['photo'])){
				echo $this->Html->image("/uploads/user_images/".$doctorDetails['User']['photo'], array('alt' => $doctorDetails['User']['first_name'].' '.$doctorDetails['User']['last_name'],'title'=>$doctorDetails['User']['first_name'].' '.$doctorDetails['User']['last_name'],'width'=>'200px','height'=>'190px'));
	         }
	         ?>
					</td>

					<td>
						<table width="94%" style="vertical-align: top;" v-align="top">
							<tr>

								<td class="doctr_name" style="padding-left: 15px"><h2>
										<?php echo $doctoProifle['DoctorProfile']['doctor_name'];?>
									</h2>
								</td>
								<td>&nbsp;</td>
							</tr>

							<td class="doctr_detail" style="padding-left: 15px"><h2>
									<?php echo $doctoProifle['DoctorProfile']['profile_description'];?>
								</h2>
							</td>
							<td>&nbsp;</td>
							</tr>
							<tr>

								<td class="doctr_detail" style="padding-left: 15px"><?php echo $doctorDetails['Department']['name'];?>
								</td>
								<td>&nbsp;</td>
							</tr>

							<tr>

								<td class="doctr_detail" style="padding-left: 15px"><?php echo $doctorDetails['User']['address1'];?>
									<?php if(!empty($doctorDetails['User']['address2'])){?> <?php echo "<br>".$doctorDetails['User']['address2'];?>
									<?php }?> <?php if(!empty($doctorDetails['City']['name'])){?> <?php echo "<br>".$doctorDetails['City']['name'];?>
									<?php }?> <?php if(!empty($doctorDetails['State']['name'])){?>
									<?php echo "<br>".$doctorDetails['State']['name'];?> <?php }?>
									<?php if(!empty($doctorDetails['Country']['name'])){?> <?php echo "<br>".$doctorDetails['Country']['name'];?>
									<?php }?>
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr>

								<td class="doctr_detail" style="padding-left: 15px"><?php echo preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $doctorDetails['User']['phone1']);?>
									<?php if(!empty($doctorDetails['User']['phone2'])){?> <?php echo "<br>".preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $doctorDetails['User']['phone2']);?>
									<?php }?> <?php if(!empty($doctorDetails['User']['mobile'])){?>
									<?php echo "<br>".preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $doctorDetails['User']['mobile']);?>
									<?php }?>
								</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>

			</table>
	
	
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>
<div id="loading-indicator" style="display: none; padding-bottom: 15px;">
	<?php echo $this->Html->image('/img/icons/loading-indicator.gif',array('alt'=>'Loading','title'=>'Loading'))?>
</div>

<div
	id="showAppointmentIndicator" align="center"></div>
<div id="showAppointments"
	align="center"></div>

<?php //echo $lastWeekDate;exit;?>
<script>
var lastWeekDate = "<?php echo $lastWeekDate; ?>";
var getAppointmentURL = "<?php echo $this->Html->url(array("controller" => "appointments", "action" => "getAppointmentDetails",$doctorId,$patientId,"admin" => false)); ?>";

$(document).ready(function () {

	getDoctorsAppointment(lastWeekDate);
	
	
    
});
/*jQuery(document)
.ready(


		
		/*function() {
			$('.schedule_appointment')
					.click(
							function() {alert('hello');
								$
										.fancybox({
											'width' : '80%',
											'height' : '90%',
											'autoScale' : true,
											'transitionIn' : 'fade',
											'transitionOut' : 'fade',
											'type' : 'iframe',
											'href' : "<?php // echo $this->Html->url(array("controller" => "appointments", "action" => "schedulePatientAppointment", $patientId)); ?>"
										});

							});
			

		});*/

function showfancyBox(currStartDate,startTime,startDate){
	//startTime = startTime.replace(" ","-");
	startTime = startTime.replace(":","-");
	$.fancybox({
		'width' : '50%',
		'height' : '70%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "appointments", "action" => "schedulePatientAppointment", $patientId,$doctorDetails['Department']['id'])); ?>/"+startTime+"/"+startDate+"/"+"<?php echo $doctorId;?>" + "/" + currStartDate
	});
}
function getDoctorsAppointment(lastWeekDate){
	$.ajax({
	     type: 'POST',
	     url: getAppointmentURL+'/'+lastWeekDate,
	     //data: formData,
	     dataType: 'html',
	     async: true,
	     success: function(data){
	    	//alert(data);
    	    	$("#showAppointments").html(data);
    	    	return false ;
	     },
			error: function(message){
	        // alert(message);
	         return false ;
	        },
	        beforeSend:function(){
	        	$("#showAppointmentIndicator").html("<table><tr><td >Loading Appointment Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
	        },
	        complete:function(){
	        	$("#showAppointmentIndicator").html("");
    	    }        
	  });

	
	  
 }
function changeDoctor(value){
	window.location.href = '<?php echo $this->Html->url('/appointments/getDoctorDetails/'); ?>'+value+'/'+lastWeekDate;

}		


    
    $( "#date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',		
		onSelect: function(date) {
			var dateArray = date.split('/');
			//alert($.format.date(date, 'dd/M/yy'));
			getDoctorsAppointment(dateArray[2].trim() + '-' + dateArray[0].trim() + '-' + dateArray[1].trim());
	     },
		minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']) ?>),
		dateFormat:'<?php echo $this->General->GeneralDate("");?>'
	});





</script>
