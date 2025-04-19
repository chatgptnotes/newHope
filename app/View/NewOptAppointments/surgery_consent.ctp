<style>.row_action img{float:inherit;}</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Consent Form', true); ?>
	</h3>
	<span><?php
	echo $this->Html->link(__('Add Consent Form', true),array('action' => 'add_surgery_consent', $patient_id), array('escape' => false,'class'=>'blueBtn'));
	 echo $this->Html->link(__('Back'), array('controller'=>'OptAppointments','action' => 'patient_information',$patient_id), array('escape' => false,'class'=>"blueBtn"));?>	
	</span>
</div>
<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div>


<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	
	<tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Surgery.name', __('Surgery', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('SurgeryConsentForm.surgery_body_part', __('Surgery Part', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('SurgeryConsentForm.relative_name', __('Relative Name', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $surgeryform):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format" align="left"><?php echo $surgeryform['Surgery']['name']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $surgeryform['SurgeryConsentForm']['surgery_body_part']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $surgeryform['SurgeryConsentForm']['relative_name']; ?>
		</td>
		<td class="row_action" align="left"><?php 
		// echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view_surgery_consent',$patient_id, 'scfid' => $surgeryform['SurgeryConsentForm']['id']), array('escape' => false,'title' => __('View & Print', true), 'alt'=>__('View & Print', true)));
		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print','alt'=>'Print')),'#',
											     	array('escape' => false ,'onclick'=>"var openWin = window.open('".$this->Html->url(array
											     	('action'=>'print_surgery_consent',$surgeryform['SurgeryConsentForm']['id']
											        ))."','_blank',
											        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');
											        return false;"));
   ?> <?php
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'add_surgery_consent',$patient_id, 'scfid' => $surgeryform['SurgeryConsentForm']['id']), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
   ?> <?php
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_surgery_consent', $patient_id, 'scfid' => $surgeryform['SurgeryConsentForm']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));

   ?></td>
	</tr>
	<?php endforeach;  ?>
	<?php
         } else {
  ?>
	<tr>
		<TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>
</table>

