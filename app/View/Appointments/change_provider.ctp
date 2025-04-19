<?php echo $this->Form->create('Appointment',array('id'=>'change_doctor','inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
		class="table_format ">
		<tr class="row_title">
	
			<td width="2%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("The Patient has an appointment with <b> Dr. ".$details[0]['User']['full_name']." </b>. Give reason for changing the physician.");?></td>
				</tr>
				<tr>
				<td width="2%" style="text-align: center;" valign="top" class="table_cell"><?php echo $this->Form->input('Appointment.reason_of_change',array('type'=>'textarea','cols'=>'3','rows'=>'5'));?></td>
			</tr>
			<?php echo $this->Form->input('Appointment.id',array('type'=>'hidden','value'=>$apptId,'id'=>'apptId'));
			echo $this->Form->input('Appointment.prev_doctor_id',array('type'=>'hidden','value'=>$details[0][User][id],'id'=>'preDoctorId'));
			echo $this->Form->input('Appointment.doctor_id',array('type'=>'hidden','value'=>$newDoctor,'id'=>'newDoctor'));
			echo $this->Form->input('Appointment.appointment_with',array('type'=>'hidden','value'=>$newDoctor,'id'=>'appointmentWith'));
			echo $this->Form->input('Patient.id',array('type'=>'hidden','value'=>$patient_id,'id'=>'patient_id'));?>
			<tr>
				<td width="2%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo $this->Form->submit('Submit',array('type'=>'button','id'=>'submitDoctor','name'=>'submit','class'=>'Bluebtn'));?></td>
			</tr>
			</table>			
<?php echo $this->Form->end(); ?>
<script>
$('#submitDoctor').click(function (){
	var apptId=$('#apptId').val();var preDoctorId= $('#preDoctorId').val();;var newDoctorId =$('#newDoctor').val();;
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "changeProvider","admin" => false)); ?>";
	   var formData = $('#change_doctor').serialize();
       $.ajax({	
      	type: 'POST',
        url: ajaxUrl+"/"+apptId+"/"+preDoctorId+"/"+newDoctorId,
        data: formData,
        dataType: 'html',
        success: function(data){
            parent.$.fancybox.close();
	     },
		error: function(message){
				alert("Error in Retrieving data");
        }        });
  
  return false; 
});
</script>
