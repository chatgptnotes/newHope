<style>.row_action img{float:inherit;}</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Surgical Safety Checklist', true); ?>
	</h3>
	<span>  <?php 
	//echo $this->Html->link(__('Add Surgical Safety Checklist', true),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'Add-Surgical-Safety-Checklist'));
	echo $this->Html->link(__('Add Surgical Safety Checklist', true),array('action' => 'add_surgical_safety_checklist', $patient_id,$optId), array('escape' => false,'class'=>'blueBtn'));
	//echo $this->Html->link(__('Back'), array('controller'=>'OptAppointments','action' => 'patient_information',$patient_id), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>
<div class="patient_info">
	<?php //echo $this->element('patient_information');?>
</div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	
	<tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Surgery.name', __('Surgery Name', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('SurgicalSafetyChecklist.signin_confirmed', __('Sign In Confirmed', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('SurgicalSafetyChecklist.create_time', __('Created Time', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $surgicalSafetyChecklist):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format" align="left"><?php echo $surgicalSafetyChecklist['Surgery']['name']; ?>
		</td>
		<td class="row_format" align="left"><?php if($surgicalSafetyChecklist['SurgicalSafetyChecklist']['signin_confirmed'] == 1) echo __('Yes'); else echo __('No'); ?>
		</td>
		<td class="row_format" align="left"><?php echo isset($surgicalSafetyChecklist['SurgicalSafetyChecklist']['create_time'])?$this->DateFormat->formatDate2Local($surgicalSafetyChecklist['SurgicalSafetyChecklist']['create_time'],Configure::read('date_format')):''; ?>
		</td>
		<td class="row_action" align="left"><?php 
		//echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view_surgical_safety_checklist',$patient_id, 'sscid' => $surgicalSafetyChecklist['SurgicalSafetyChecklist']['id']), array('escape' => false,'title' => __('View & Print', true), 'alt'=>__('View & Print', true)));
		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print','alt'=>'Print')),'#',
											     	array('escape' => false ,'onclick'=>"var openWin = window.open('".$this->Html->url(array
											     	('action'=>'print_surgical_safety_checklist',$surgicalSafetyChecklist['SurgicalSafetyChecklist']['id'],$patient_id
											        ))."','_blank',
											        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');
											        return false;"));
   ?> <?php
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'add_surgical_safety_checklist',$patient_id, 'sscid' => $surgicalSafetyChecklist['SurgicalSafetyChecklist']['id'],$optId), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
   ?> <?php
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_surgical_safety_checklist', $patient_id, 'sscid' => $surgicalSafetyChecklist['SurgicalSafetyChecklist']['id'],$optId), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));

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

<script>
	$("#Add-Surgical-Safety-Checklist").click(function(){
		$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'opt_appointments','action' => 'add_surgical_safety_checklist', $patient_id));?>',
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success: function(data){
				$('#busy-indicator').hide();
				$("#render-ajax").html(data);
		     }
		});
	});
</script>
