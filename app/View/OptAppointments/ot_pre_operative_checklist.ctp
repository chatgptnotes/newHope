<style>.row_action img{float:inherit;}</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Pre Operative Checklist', true); ?>
	</h3>
	<span>
	<?php
	//echo $this->Html->link(__('Add Pre Operative Checklist', true),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'Add-Pre-Operative-Checklist'));
	echo $this->Html->link(__('Add Pre Operative Checklist', true),array('action' => 'add_ot_pre_operative_checklist', $patient_id,$optId), array('escape' => false,'class'=>'blueBtn'));
	// echo $this->Html->link(__('Back'), array('controller'=>'OptAppointments','action' => 'patient_information',$patient_id), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>
<div class="patient_info">
	<?php //echo $this->element('patient_information');?>
</div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr>
		<td colspan="10" align="right"></td>
	</tr>
	<tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('PreOperativeChecklist.npo_notice_time', __('NPO Notice Time', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('PreOperativeChecklist.npo_midnight', __('NPO Midnight', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('PreOperativeChecklist.identification_band', __('Identification Band', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $pre_operative_checklist):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format" align="left"><?php echo $pre_operative_checklist['PreOperativeChecklist']['npo_notice_time']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $pre_operative_checklist['PreOperativeChecklist']['npo_midnight']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $pre_operative_checklist['PreOperativeChecklist']['identification_band']; ?>
		</td>
		<td class="row_action" align="left"><?php 
		//echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view_ot_pre_operative_checklist',$patient_id, 'otpcid' => $pre_operative_checklist['PreOperativeChecklist']['id']), array('escape' => false,'title' => __('View & Print', true), 'alt'=>__('View & Print', true)));
		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print','alt'=>'Print')),'#',
											     	array('escape' => false ,'onclick'=>"var openWin = window.open('".$this->Html->url(array
											     	('action'=>'print_ot_pre_operative_checklist',$pre_operative_checklist['PreOperativeChecklist']['id']
											        ))."','_blank',
											        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');
											        return false;"));
   ?> <?php
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'add_ot_pre_operative_checklist',$patient_id, 'otpcid' => $pre_operative_checklist['PreOperativeChecklist']['id'],$optId), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
   ?> <?php
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_ot_pre_operative_checklist', $patient_id, 'otpcid' => $pre_operative_checklist['PreOperativeChecklist']['id'],$optId), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));

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
	$("#Add-Pre-Operative-Checklist").click(function(){
		$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'opt_appointments','action' => 'add_ot_pre_operative_checklist', $patient_id));?>',
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
