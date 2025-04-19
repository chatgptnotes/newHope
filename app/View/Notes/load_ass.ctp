<?php echo $this->Html->script(array('pager')); ?>
<form id="assData">
<table>
	<tr>
		<td valign="top">
		 <?php echo $this->Form->input('assis',array('type'=>'text','cols'=>'1','rows'=>'1','style'=>'height:27px;','value'=>$getDataFormNote['Note']['subject']
			 ,'label'=>false,'id'=>'AssData','class'=>'resize-input','div'=>false,'placeholder'=>'Assessment','value'=>$putAssisData['Note']['assis']));?>
		</td>
		<td valign="top">
		<?php echo $this->Html->link('Save','javascript:void(0)',array('onclick'=>"updateNote('assis')",'class'=>'blueBtn'));?>
		<td>
			<td id="assessmentDisplay" style="display:<?php echo $displayros; ?>;"></td>
		<input type="hidden" name="patientId" value='<?php echo $patientId?>'/>
	                      		<input type="hidden" name="noteId" value='<?php echo $noteId?>'/>
	                      		<input type="hidden" name="appointmentId" value='<?php echo $appointmentId?>'/>
	</tr>
</table>
</form>
<script>
///--------------------------------------Update Complaints --------------------------------------------//
function updateNote(fields){
	var formData = $('#assData').serialize();
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "loadAssis",$patientId,$noteId,$appointmentId,"admin" => false)); ?>";
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
			 $('#alertMsg').html('Assessment Saved Successfully.');
			 $('#alertMsg').fadeOut(5000);
			
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