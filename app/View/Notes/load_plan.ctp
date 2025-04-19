<?php echo $this->Html->script(array('pager')); ?>
<form id="planData">
<table>
	<tr>
		<td valign="top">
		 <?php echo $this->Form->input('plan',array('type'=>'text','cols'=>'1','rows'=>'1','style'=>'height:27px;','value'=>$getDataFormNote['Note']['subject']
			 ,'label'=>false,'id'=>'PlanData','class'=>'resize-input','div'=>false,'placeholder'=>'Plan','value'=>$putPlanData['Note']['plan']));?>
		</td>
		<td valign="top">
		<?php echo $this->Html->link('Save','javascript:void(0)',array('onclick'=>"updateNote('plan')",'class'=>'blueBtn'));?>
		<td>
		<td id="planDisplay" style="display:<?php echo $displayros; ?>;"></td>
		<input type="hidden" name="patientId" value='<?php echo $patientId?>'/>
	                      		<input type="hidden" name="noteId" value='<?php echo $noteId?>'/>
	                      		<input type="hidden" name="appointmentId" value='<?php echo $appointmentId?>'/>
	</tr>
</table>
</form>
<script>
///--------------------------------------Update Complaints --------------------------------------------//
function updateNote(fields){
	var formData = $('#planData').serialize();
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "loadPlan",$patientId,$noteId,$appointmentId,"admin" => false)); ?>";
	$.ajax({
		beforeSend : function() {
			$('#busy-indicator').show('fast');
		},
		type: 'POST',
		url: ajaxUrl+'/?type='+fields,
		data:formData,//"id="+complaints+"&id2="+patientId,
		dataType: 'html',
		success: function(data){
			getSubData();
			$('#busy-indicator').hide('fast');
			$('#alertMsg').show();
			 $('#alertMsg').html('Plan Saved Successfully.');
			
	},
	});
 }
function hpi(){
	window.location.href="<?php echo $this->Html->url(array("controller" => "PatientForms", "action" => "hpiCall",$patientId,$noteId)); ?>";
	}
function ros(){
	window.location.href="<?php echo $this->Html->url(array("controller" => "Notes", "action" => "reviewOfSystem",$patientId,$noteId)); ?>";
	}
	</script>