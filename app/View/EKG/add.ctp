<?php 
echo $this->Form->hidden('EKG.id') ;
echo $this->Form->hidden('EKG.patient_id') ;
?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: left;">
		<div><h5>Cardiac</h5></div>		
	<tr>
		<td><?php echo __('History:')?></td>
		<td><?php echo $this->Form->input('EKG.history',array('type' => 'text','id'=>'history','div'=>false,'label'=>false))?></td>
		
		<td><?php echo __('Cardiac Medications, If Any:')?>
		<td><?php echo $this->Form->textarea('EKG.cardiac_medication', array('id' => 'cardiac_medication','row'=>'3')); ?></td>
	</tr>
	<tr></tr>
	<tr>	
		<td><?php echo  __('Does Patient Have a Pacemaker? :')?></td>
		<td><?php echo $this->Form->radio('EKG.pacemaker', array('yes'=>'Yes','no'=>'No','unknown'=>'Unknown'),array('legend'=>false,'label'=>false ));?></td>
	</tr>
	<tr>	
		<td><?php echo  __('PLEASE CHECK ONE :')?></td>
		<td colspan="4"> 
			<?php	$radValue = array('12 Lead EKG With Rhythm Strip'=>'12 Lead EKG With Rhythm Strip','Pacemaker Test'=>'Pacemaker Test','Holter Monitor'=>'Holter Monitor') ;
			echo $this->Form->input('EKG.check_one', array('empty'=>__('Please Select'),'readonly'=>'readonly','options'=>$radValue,'legend'=>false,'label'=>false ));?></td>
	</tr>
	<tr><td colspan="4"><h6>
						NOTICE TO OFFICIALS: A Portable EKG is being ordered since this patient would find it physically and/or psychologically
						 taxing, because of advanced age and/or physical limitations to receive EKG outside this home.<td></tr>
	<tr>	
		<td><?php echo  __('Assignment Accepted :')?></td>
		<td><?php echo $this->Form->radio('EKG.assignment_accepted', array('yes'=>'Yes','no'=>'No'),array('legend'=>false,'label'=>false ));?></td>
	</tr>
	
	<tr>
		<td colspan='4' align='right' valign='bottom'><?php echo $this->Js->submit(__('Submit'),array(
				'url'=>array('controller'=>'EKG','action'=>'add',$patient_id),'success'=>"alert(data);ekg_success();",'id'=>'ekgsubmit','class'=>'blueBtn')); ?>
		</td>
	</tr>
	</table>	 
	<?php echo $this->Js->writeBuffer();?>