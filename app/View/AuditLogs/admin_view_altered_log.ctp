<div class="inner_title">
	<h3>
		<div style="float: left">
			<?php echo __('View Altered Logs Details');?>
		</div>
		<div style="float: right;">
			<?php
			echo $this->Html->link(__('Back to List'), array('action' => 'altered_log_details'), array('escape' => false,'class'=>'blueBtn'));
			?>
		</div>
	</h3>
	<div class="clr"></div>
</div>

<table border="0" cellpadding="0" cellspacing="0" width="550"
	align="center" class="table_view_format">

	<tr class="first">
  <td class="row_format"><strong>
   <?php echo __('Id',true); ?></strong>
  </td>
  <td>
   <?php echo $auditdata['Audit']['id']; ?>
  </td>
 </tr>
 <tr >
  <td class="row_format"><strong>
   <?php echo __('Username',true); ?></strong>
  </td>
  <td>
   <?php echo $auditdata['User']['username']; ?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Patient ID',true); ?></strong>
  </td>
  <td>
   <?php echo $auditdata['Audit']['patient_id']; ?>
  </td>
 </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Event',true); ?></strong>
  </td>
  <td>
   <?php echo $auditdata['Audit']['event']; ?>
  </td>
 </tr>
 <tr class="row_gray">
  <td ><strong>
   <?php echo __('Model',true); ?></strong>
  </td>
  <td>
   <?php echo $auditdata['Audit']['model']; ?>
  </td>
 </tr>
<tr class="row_format">
  <td class="row_format"><strong>
   <?php echo __('Activity Date/Time',true); ?></strong>
  </td>
  <td>
  <?php echo $this->DateFormat->formatDate2Local($auditdata['Audit']['created'],Configure::read('date_format'),true); ?>
  </td>
 </tr>
 
</table>

<div>
	<?php 
	foreach($auditdelta as $key=>$auditdelta){
		foreach($auditdelta as $var=>$audit){
		$cnt==0; if($cnt%2 == 0){?>
	<table border="0" cellpadding="0" cellspacing="0"
		align="left" class="table_view_format">
		<?php }else { ?>
		<table border="0" cellpadding="0" cellspacing="0"
			align="right" class="table_view_format">
			<?php } foreach($audit as $variab=>$audit){
		if($cnt%2 == 0){?>
			<tr class="row_gray">
				<?php }else { ?>
			
			
			<tr>
				<?php }?>
				<td class="row_format"><strong> <?php echo $variab; ?>
				</strong>
				</td>
				<td>
				 <?php 
				      if($variab == "create_time" || $variab == "modify_time") {
				      echo $this->DateFormat->formatDate2Local($audit,Configure::read('date_format'),true);
				      } else {
				       echo $audit;
				      }
				 ?>
				</td>
			</tr>
			<?php 
	} ?>
		</table>
		<?php  $cnt++;
}}?>

</div>
