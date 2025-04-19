<?php echo $this->Form->create('Note',array('type' => 'file','id'=>'attestationFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));

echo $this->Form->hidden('patient_id',array('value'=>$patient_id,'id'=>'patient_id'));
echo $this->Form->hidden('id',array('value'=>$note['Note']['id'],'id'=>'note_id'));
 
		?>
<table border="0" cellpadding="0" cellspacing="0"
	style="padding-top: 10px; line-height: 22px;" align="center"
	class="tdLabel">

	<tr>
		<td><?php 
        echo $this->Form->input('attestation_chk', array('type'=>'checkbox', 'id' => 'attestation_chk', 'label'=> false, 'div' => false, 'error' => false));?>
			 
			<?php echo __('I have seen and examined the patient and discussed the case with Dr.');
		 ?> <?php echo $this->Form->input('dr_name', array('type'=>'text', 'id' => 'dr_name', 'label'=> false, 'div' => false, 'error' => false));
		 ?> <?php echo __('and agree with the findings and plan as documented in the resident\'s note.');  ?>
		</td>
	</tr>
	<tr>
		<td><?php 
		echo $this->Form->input('attestation_chk1', array('type'=>'checkbox', 'id' => 'attestation_chk', 'label'=> false, 'div' => false, 'error' => false))."&nbsp;";
		echo __('I have discussed the patient with Dr.'); ?> <?php echo $this->Form->input('Note.claim_type', array('type'=>'text', 'id' => 'claim_type', 'label'=> false, 'div' => false, 'error' => false)); 
		?>
			<?php echo __(' and agree with the findings and plan as documented in the resident\'s note.'); ?>
		</td>
	</tr>
	<tr>
		<td><?php 
		echo $this->Form->input('attestation_chk2', array('type'=>'checkbox', 'id' => 'attestation_chk', 'label'=> false, 'div' => false, 'error' => false))."&nbsp;";
		echo __('I was present for the entire procedure which consisted of'); 
		echo $this->Form->input('dr_name1', array('type'=>'text', 'id' => 'dr_name', 'label'=> false, 'div' => false, 'error' => false));?>
		</td>
	</tr>
	<tr>
		<td><?php 
		echo $this->Form->input('attestation_chk3', array('type'=>'checkbox', 'id' => 'attestation_chk', 'label'=> false, 'div' => false, 'error' => false))."&nbsp;";
		echo __('I personally performed the &nbsp;');
		echo $this->Form->input('dr_name2', array('type'=>'text', 'id' => 'dr_name', 'label'=> false, 'div' => false, 'error' => false));
		?>&nbsp;</td>
	</tr>
	<tr>
		<td><?php 
		echo $this->Form->input('procedure_chk', array('type'=>'checkbox', 'id' => 'procedure_chk', 'label'=> false, 'div' => false, 'error' => false))."&nbsp;";
		echo __(' I was not present during the procedure');?>
		</td>
	</tr>
	<tr>
		<td><?php 
		echo $this->Form->input('attestation_chk', array('type'=>'checkbox', 'id' => 'attestation_chk', 'label'=> false, 'div' => false, 'error' => false));
		echo __(' I have seen and examined the patient and read the history, exam, assessment, and plan of Dr.');
		?>&nbsp;<?php
		echo $this->Form->input('plan_name', array('type'=>'text', 'id' => 'plan_name', 'label'=> false, 'div' => false, 'error' => false));
		?> <?php
		echo __(' and agree.  See above for');
		?>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo $this->Form->input('below_chk1', array('type'=>'checkbox', 'id' => 'below_chk', 'label'=> false, 'div' => false, 'error' => false));?>&nbsp;
			<?php 	echo "Pertinent elements" ; ?>&nbsp;
			<?php echo $this->Form->input('below_chk2', array('type'=>'checkbox', 'id' => 'below_chk', 'label'=> false, 'div' => false, 'error' => false));?>&nbsp;
			<?php 	echo "the following additions <br/>" ;  
			echo $this->Form->textarea('addition', array( 'label'=> false, 'div' => false, 'error' => false));
			?>&nbsp;
			<div class="btns">
				<?php echo "&nbsp;&nbsp;".$this->Html->link('Save',"javascript:void(0)",array('class'=>'blueBtn','div'=>false,'title'=>'Save','id'=>'saveAttestation'));
				?>
			</div>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>

<script type="text/javascript">
$('#saveAttestation').click(function (){
	var patient_id=$("#patient_id").val();
	var note_id=$("#note_id").val();	
	formData = $('#attestationFrm').serialize();
	 
	$.ajax({
		  type : "POST",
		  data: formData,
		  url: "<?php echo $this->Html->url(array("controller" => "patientForms", "action" => "addAttestationData", "admin" => false)); ?>"+'/'+patient_id+ '/'+note_id,
		  context: document.body,
		//  data:"mapTarget="+icd_id+"&diagnoses_name="+diagnoses_name+"&patient_id="+patient_id+"&id="+dia_id+"&patient_info="+patientInfo,
		  success: function(data){ 	
			  $("#busy-indicator").hide();			  
		  },
		  beforeSend:function(){$("#busy-indicator").show();},		  
		});
  	 return true;     
}); 
</script>
		
		
		
	