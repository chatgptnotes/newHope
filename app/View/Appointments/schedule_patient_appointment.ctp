<?php echo $this->Html->css(array('internal_style.css','validationEngine.jquery.css'));
echo $this->Html->script(array('jquery-1.5.1.min.js','jquery.validationEngine.js','languages/jquery.validationEngine-en.js'));

?>
<style>
*{
font-size: 12px;
}

.msg{
	text-align: center;
	font-weight: bold; 
	font-size: 17;
	color: #FA3B3B

}

</style>

<?php 
echo $this->Form->create('Appointment',array('id'=>'appointmentform','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
),'default'=>false
));
?>
<table width="500" style="margin: 15px 0px 0px 15px">
 <!--  <tr>
     <td width="145px">&nbsp;</td>
      <td class="msg">
      <?php /* if($msg)
	{ 
		echo $msg;
	}else{ */  ?>  
      </td>
  </tr> -->
  
  <tr>
    <td><?php echo __("Date")?></td>
    <td><?php  echo $this->DateFormat->formatDate2Local($startDate,Configure::read('date_format'));
    		echo $this->Form->hidden('date', array('value'=>$startDate));
    		echo $this->Form->hidden('department_id', array('value'=>$departmentId));
    		echo $this->Form->hidden('person_id', array('value'=>$patientId));
    ?></td>
  </tr>
  <tr>
    <td><?php echo __("Start Time")?><font
			color="red">*</font></td>
    <td><?php echo $startTime; //$this->Form->input('start_time', array('value'=>$startTime,'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','readonly'=>'readonly','id' => 'start','label'=>false,)); 
    echo $this->Form->hidden('start_time', array('value'=>$startTime,'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','readonly'=>'readonly','id' => 'start','label'=>false,));
    ?></td>
  </tr>
  <tr>
    <td><?php echo __("Visit Type")?><font
			color="red">*</font></td>
    <td><?php echo $this->Form->input('visit_type', array('empty'=>__('Please Select'),'options'=>$visitTypeArray,'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'visit_type','label'=>false,'style'=>'width:250px;')); ?></td>
  </tr>
  <tr>
    <td><?php echo __("Provider")?><font
			color="red">*</font></td>
    <td><?php echo $this->Form->input('appointment_with', array('selected'=>$doctorId,'value'=>$doctorId,'options'=>$doctorList,'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'appointment_with','label'=>false,'style'=>'width:250px;')); ?></td>
  </tr>
  <tr>
    <td><?php echo __("Chief Complaints")?><font
			color="red">*</font></td>
    <td><textarea name="Appointment.purpose" id="purpose" class='validate[required,custom[mandatory-select]] textBoxExpnd'></textarea></td>
  </tr>
  <tr>
    <td><?php echo __("EMPI")?></td>
    <td><?php echo $patientDetails['Person']['patient_uid'];//$this->Form->input('admissionid', array('value'=>$patientDetails['Person']['patient_uid'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','readonly'=>'readonly','id' => 'admissionid','label'=>false,));
    echo $this->Form->hidden('admissionid', array('value'=>$patientDetails['Person']['patient_uid'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','readonly'=>'readonly','id' => 'admissionid','label'=>false,));
    ?></td>
  </tr>
  <tr>
    <td><?php echo __("Patient Name")?></td>
    <td><?php $getName=$patientDetails['Person']['first_name']." ".$patientDetails['Person']['last_name'];
      echo $getName;//$this->Form->input('patientname', array('value'=>$patientDetails['Person']['first_name']." ".$patientDetails['Patient']['Person'],'class' => " ",'id' => 'patientname','readonly'=>'readonly','label'=>false,)); 
   echo  $this->Form->hidden('patientname', array('value'=>$patientDetails['Person']['first_name']." ".$patientDetails['Person']['last_name'],'class' => " ",'id' => 'patientname','readonly'=>'readonly','label'=>false,));
    ?></td>
  </tr>
  <tr>
  	<td><?php echo __('Additional Information');?></td>
  	<td>
  		<?php 
		echo $this->Form->checkbox('to_tast_fast', array('id' => 'to_tast_fast'));echo __('I am diabetic');
		?> 
  	</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  	<td><div id="fasting_instruction" style="display:none">
  		<?php 
		echo  __('Please come fasting for fasting blood sugar test');
		?> </div>
  	</td>
  </tr>
  <tr>
    <td > 
    <div id="loading-indicator" style="display:none"><?php echo $this->Html->image('/img/icons/loading-indicator.gif',array('alt'=>'Loading','title'=>'Loading'))?>&nbsp;&nbsp;&nbsp;<?php echo __("Please Wait....");?></div>			
     
	         <!--<input class="grayBtn" type="button" value="Cancel" 
                           	onclick="window.location='<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "child_birth_list",$patient_id));?>'">--></td>
    <td align="right"><?php echo $this->Js->submit('Submit', array('class'=>'blueBtn','id' => 'patientname11','label'=>false,'beforeSend'=>'checkValidation(XMLHttpRequest);','success'=>'closeFancyBox();')); 
    
    ?></td>
  </tr>
</table>
 <?php echo $this->Form->end(); 
 echo $this->Js->writeBuffer();
 
 ?>
 <?php //}?>
</div>
<script type='text/javascript'>
function checkValidation(XMLHttpRequest){
	if(!$('#appointmentform').validationEngine('validate'))
		XMLHttpRequest.abort();	
	var date = '<?php echo $this->DateFormat->formatDate2Local($startDate,Configure::read('date_format'));?>';
	var max ='<?php echo $appCount[0][0]['count'];?>';
    var max_appointments= '<?php echo Configure::read('max_appointments')?>';
   
	  if (max == max_appointments)
		   {
           alert(Configure::read('max_appointments')+' appointments for today are already scheduled.');
		  //alert('Appointment cannot be scheduled for '+ date);
		  	} 
	
}
 
 var lastWeekDate = "<?php echo $startDate; ?>";
 var currStartDate = "<?php echo $currStartDate; ?>";
 var getAppointmentURL = "<?php echo $this->Html->url(array("controller" => "appointments", "action" => "getAppointmentDetails",$doctorId,$patientId,"admin" => false)); ?>";
 function closeFancyBox(){
	//getDoctorsAppointment(currStartDate);
	parent.location.href = '<?php echo $this->Html->url('/Landings/'); ?>';
}
 $( "#to_tast_fast" ).click(function() {
		
	 if($("#to_tast_fast").is(":checked")){
		$("#fasting_instruction").show();
	 }else{
		 $("#fasting_instruction").hide();
	 }
		
	});
 
 
/* This function is not called as we are redirecting to landing page */
 function getDoctorsAppointment(currStartDate){
 
	 	 if ( $('#appointmentform').validationEngine('validate') ) {
			$.ajax({
			     type: 'POST',
			     url: getAppointmentURL+'/'+currStartDate,
			     //data: formData,
			     dataType: 'html',
			     async: true,
			     success: function(data){
			    	
		    	    	$("#loading-indicator").hide();
		    	    	parent.document.getElementById('showAppointments').innerHTML= data	;	
		    	    	 parent.$.fancybox.close();
		    	    	return false ;
			     },
					error: function(message){
			        // alert(message);
			         return false ;
			        },
			        beforeSend:function(){
			        	 $("#loading-indicator").show();
			        	$("#showAppointmentIndicator").html("<table><tr><td>Loading Appointment Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
			        },
			        complete:function(){
			        	$("#showAppointmentIndicator").html("");
		    	    }        
			  });
	 	}
	 }

 
 </script>
 