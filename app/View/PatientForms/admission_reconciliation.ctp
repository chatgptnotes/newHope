<div id="adminssion" style='display:<?php echo $display?>'>
	<?php echo $this->Form->create('AdmissionReconciliation',array('url' =>array('controller'=>'PatientForms','action'=>'AdmissionReconciliation') ,'file','id'=>'AdmissionReconciliationfrm','inputDefaults' => array(
			'label' => false,
			'div' => false,
			'error' => false,
			'legend'=>false,
			'fieldset'=>false
	)
));?>
	<div class="inner_title">
		<h3>
			&nbsp;
			<?php echo __("Admission Reconciliation ", true);
			?>

		</h3>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr class='row_title'>
			<td></td>
			<td><?php echo $this->Html->image('/img/3.png',array('title'=>'Ordered','alt'=>'Ordered' ))?></td>
			<td><?php echo $this->Html->image('/img/8.png',array('title'=>'Documented','alt'=>'Documented' ))?></td>
			<td style="width:20%">Order Name</td>
			<td>Details</td>
			<td>Status</td>
			<td><table><tr><td><?php echo $this->Html->image('/img/5.png',array('title'=>'Continue','alt'=>'Continue' ));?><td></tr><tr><td>Continue<td></tr></table></td>
			<td><table><tr><td><?php echo $this->Html->image('/img/6.png',array('title'=>'Do not Continue','alt'=>'Do not Continue' ));?><td></tr><tr><td>Do not Continue<td></tr></table></td>
			<td style="width:20%">Order Name</td>
		</tr>
		<?php $toggle =0;
				      if(count($admission) > 0) {
				      		foreach($admission as $key=>$admissions){
				       
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }?>
		<?php $orderSentence='';
			if(!empty($admissions['NewCropPrescription']['dose']))
			$orderSentence.='Dose :'.$admissions['NewCropPrescription']['dose'].' '.$admissions['NewCropPrescription']['strength']." ";
			else $orderSentence.=$orderSentence;
			if(!empty($admissions['NewCropPrescription']['route']))
				$orderSentence.='Route :'.$admissions['NewCropPrescription']['route']." ";
			else $orderSentence.=$orderSentence;
				?>
	
			<td></td>
			<?php if(empty($admissions['NewCropPrescription']['is_assessment'])){?>
			<td><?php echo $this->Html->image('/img/3.png',array('title'=>'Ordered','alt'=>'Ordered' ));?></td>
			<?php }else{?>	
				<td><?php echo __(" ");?></td>
	<?php }?>
	<?php if(!empty($admissions['NewCropPrescription']['is_assessment'])){?>
			<td><?php echo $this->Html->image('/img/8.png',array('title'=>'Documented','alt'=>'Documented' ));?></td>
			<?php }else{?>	
				<td><?php echo __(" ");?></td>
	<?php }?>
	<?php if(!empty($admissions['NewCropPrescription']['is_assessment'])){?>
			
			<td><?php echo $this->Html->image('/img/2.png',array('id'=>"reconcile".$key."0",'title'=>$orderSentence." ".'To be reconcile','alt'=>'To be reconcile' ));?><span id='drugName<?php echo $key;?>0'><?php echo $admissions['NewCropPrescription']['drug_name'] ?></span></td>
			<?php }else{?>
			<td><?php echo $admissions['NewCropPrescription']['drug_name'] ?></td>
			<?php }?>
			<td><?php echo $orderSentence; ?></td>
			<?php if($admissions['NewCropPrescription']['is_assessment']=='1')
				$status='Documented';
			else 
				$status='Ordered'?>
			<td><?php echo $status;?></td>
			<td><?php echo $this->Form->input(" ", array('type' => 'radio','class'=>'radio','id' =>'radio'.$key ,'name' =>"radio",'options' =>array('')));?></td>
			<td><?php echo $this->Form->input(" ", array('type' => 'radio','class'=>'radio','id' =>'radio'.$key,'name' => "radio",'options' =>array('')));?></td>
			<?php if(empty($admissions['NewCropPrescription']['is_assessment'])){?>
			<td><?php echo $admissions['NewCropPrescription']['drug_name']; ?></td>
			<?php }else{?>
			<td id='putname<?php echo $key?>0'><?php echo __(""); ?></td><?php }?>
		</tr>
		<?php }}?>
		<tr>
		<td colspan=10 > </td>
		<tr>
		<td colspan=10 style="text-align: right;padding-right: 80px""><?php echo $this->Form->submit('Submit and Asign',array('value'=>'submit','class'=>'blueBtn'));?></td>
		</tr>
	</table>
	<?php echo $this->Form->hidden('patient_id',array('value'=>$patient_id));?>
	<?php echo $this->Form->end(); ?>
</div>
<script>
			$(".radio").click(function(){
				var currentId=$(this).attr('id');
				var imgId=currentId.split('o');
				var selectedDrug=$('#drugName'+imgId[1]).html();
				$('#reconcile'+imgId[1]).hide();
				$('#putname'+imgId[1]).html(selectedDrug);
				});
			</script>