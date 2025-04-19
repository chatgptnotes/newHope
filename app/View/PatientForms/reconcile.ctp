<?php 
echo $this->Html->script(array('inline_msg','jquery.blockUI' ));
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __("Reconciliation", true);
		?>

	</h3>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<td width=13% style="padding-left: 10px"><?php echo __("Documented Medications") ; ?>
		</td>
		<?php echo $this->Form->hidden('patient_id',array('value'=>$patient_id,'id'=>'patient_id'));?>
		<?php $opt=array('Reconciliation'=>'Reconciliation','Admission'=>'Admission','Transfer'=>'Transfer','Discharge'=>'Discharge');?>
		<td><?php echo $this->Form->input('', array('options' => $opt, 'id' => 'ajaxreconcilation', 'label'=> false, 'div' => false, 'error' => false, 
				'onchange' => $this->Js->request(array('action' => 'AdmissionReconciliation'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    	'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#admissionReconciliation', 'data' => '{patient_id:$("#patient_id").val()}', 'dataExpression' => true, 'div'=>false))));?>
		</td>
		<td width=80% style="text-align: right; padding-right: 450px"><?php echo __("Status") ; ?>
		</td>
	</tr>
	<tr>

		<td colspan=2><?php echo __("") ; ?></td>
		<td style="text-align: right;"><table width="100%" border="0"
				cellspacing="0" cellpadding="0" class="">
				<tr>
					<td style="text-align: right" id='meds'
						title='Date n time last edited meds'><?php echo $this->Html->image('/img/icons/icon_tick.gif',array('title'=>'Meds','alt'=>'Meds' ,'style'=>'float:right'))?>Meds
						History</td>
					<td width=15% style="text-align: right;" id='adm_meds'
						title='Date n time last edited adm_meds'><?php echo $this->Html->image('/img/icons/inactive.jpg',array('title'=>'Meds','alt'=>'Meds' ,'style'=>'float:right'))?>Adm.
						Meds History</td>
					<td width=20% style="text-align: right; padding-right: 40px"
						id='discharge' title='Date n time last edited discharge'><?php echo $this->Html->image('/img/icons/inactive.jpg',array('title'=>'Meds','alt'=>'Meds' ,'style'=>'float:right'))?>Discharge
						Meds History</td>
				</tr>
			</table></td>
	</tr>
</table>
<div id='admissionReconciliation'>

</div>

<script>
		$('#reconciliation').change(function(){
			var currentSelections=$('#reconciliation').val();
			if(currentSelections=='Admission')
				$('#adminssion').show();
			else
				$('#adminssion').hide();
			
			
			
			
			});


		</script>
