<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Police Form', true); ?>
	</h3>
	<span> 
	<?php 
	echo $this->Html->link(__('Add Police Form', true),array('action' => 'add_police_form', $patient_id), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'), array('controller' => 'nursings','action' => 'patient_information',$patient_id), array('escape' => false,'class'=>"blueBtn"));?>
	
	</a>
	</span>

</div>
<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div>
<div
	style="text-align: right;" class="clr inner_title"></div>
<div class="btns">
	<?php
	
	?>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">

	<tr class="row_title">
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('PoliceForm.accident_date', __('Accident Date', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('PoliceForm.accident_Time', __('Accident Time', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('PoliceForm.accident_place', __('Accident Place', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('PoliceForm.brought_person_name', __('Relative Person', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('PoliceForm.police_station', __('Police Station', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $dataval):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format"><?php echo date("d/m/Y", strtotime($dataval['PoliceForm']['accident_date'])); ?>
		</td>
		<td class="row_format"><?php echo $dataval['PoliceForm']['accident_time']; ?>
		</td>
		<td class="row_format"><?php echo $dataval['PoliceForm']['accident_place']; ?>
		</td>
		<td class="row_format"><?php echo $dataval['PoliceForm']['brought_person_name']; ?>
		</td>
		<td class="row_format"><?php echo $dataval['PoliceForm']['police_station']; ?>
		</td>
		<td><?php 
		// echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view_surgery_consent',$patient_id, 'scfid' => $surgeryform['SurgeryConsentForm']['id']), array('escape' => false,'title' => __('View & Print', true), 'alt'=>__('View & Print', true)));
		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print','alt'=>'Print')),'#',
											     	array('escape' => false ,'onclick'=>"var openWin = window.open('".$this->Html->url(array
											     	('action'=>'print_police_form',$patient_id,$dataval['PoliceForm']['id']
											        ))."','_blank',
											        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');
											        return false;"));
   ?> <?php
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'edit_police_form',$patient_id, $dataval['PoliceForm']['id']), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
   ?> <?php
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_police_form', $patient_id, $dataval['PoliceForm']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));

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

