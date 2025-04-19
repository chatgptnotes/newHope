<?php 
echo $this->Form->create('IncorporatedPatient',array('url'=>array('controller'=>'ccda','action'=>'edit_summary_care_date'),
		'id'=>'ccda','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false,'style'=>'')));

?>
<table>
	<tr>
		<td><?php
		echo $this->Form->hidden('patient_id',array('type'=>'text','value'=>$this->data['IncorporatedPatient']['patient_id']));
		echo $this->Form->hidden('id');
			
		echo $this->Form->input('IncorporatedPatient.date_imported_on',
					array('type'=>'text','class'=>'textBoxExpnd','id' => 'import_date' ,'label'=>false));
	?></td>
		<td><?php
		echo $this->Form->input('IncorporatedPatient.summary_provide',
					array('options'=>array('1'=>'Yes','0'=>'No'),'label'=>false,'div'=>false));

		?></td>
		<td><?php 
		echo $this->Form->submit('Submit',
				array( 'class'=>'blueBtn','label'=>false));
		?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>
<script> 
		jQuery(document).ready(function() { 
			$("#import_date")
			.datepicker(
					{
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,  
						dateFormat:'<?php echo $this->General->GeneralDate();?>',
					});
		});
		</script>
