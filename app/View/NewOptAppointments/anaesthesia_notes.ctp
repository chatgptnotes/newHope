<style>.row_action img{float:inherit;}</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Anaesthesia Note', true); ?>
	</h3>
	<span><?php 
		//echo $this->Html->link(__('Add Anaesthesia Note', true),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'Add-Anaesthesia-Note'));	
	echo $this->Html->link(__('Add Anaesthesia Note', true),array('action' => 'add_anaesthesia_notes', $patient_id), array('escape' => false,'class'=>'blueBtn'));
		// echo $this->Html->link(__('Back'), array('controller'=>'OptAppointments','action' => 'patient_information',$patient_id), array('escape' => false,'class'=>"blueBtn")); ?>
	</a>
	</span>
</div>
<div class="patient_info">
	<?php //echo $this->element('patient_information');?>
</div>


<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	
	<tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Surgery.name', __('Surgery', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('User.first_name', __('Consultant', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Doctor.first_name', __('Registrar', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Note.note_date', __('Created Time', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $anaesthesia):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format" align="left"><?php echo $anaesthesia['Surgery']['name']; ?>
		</td>
		<td class="row_format" align="left"> <?php echo $anaesthesia['Initial']['name']." ".$anaesthesia[0]['doctor_name']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $anaesthesia['PatientInitial']['name']." ".$anaesthesia[0]['registrar']; ?>
		</td>
		<td class="row_format" align="left"><?php if($anaesthesia['Note']['note_date'] && $anaesthesia['Note']['note_date'] !="0000-00-00 00:00:00") echo $this->DateFormat->formatDate2Local($anaesthesia['Note']['note_date'],Configure::read('date_format'), true); ?>
		</td>
		<td class="row_action" align="left"><?php 
		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view_anaesthesia_notes',$patient_id, 'anid' => $anaesthesia['Note']['id']), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'add_anaesthesia_notes',$patient_id, 'anid' => $anaesthesia['Note']['id']), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_ot_post_operative_checklist', $patient_id, 'anid' => $anaesthesia['Note']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
			
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
	$("#Add-Anaesthesia-Note").click(function(){
		$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'opt_appointments','action' => 'add_anaesthesia_notes', $patient_id));?>',
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
