<style>
	.tableformat{ border: 1px solid #4C5E64;
    margin-top: 20px;
    padding: 0;
    width: 394px;}
	</style>
	
	
	
	<div style="float:right;" id="printButton">
		<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
	</div>
	  
	<!-- Right Part Template -->
	<div align="center" class="heading" style="text-decoration:none;">
		<?php echo __('Audit Log Details'); ?> 
	</div> 
	 <div>&nbsp;</div>
	<table border="0" cellpadding="0" cellspacing="0" width="550"

	align="center" class="table_view_format">

	<tr>
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
 <tr >
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
 <tr >
  <td ><strong>
   <?php echo __('Model',true); ?></strong>
  </td>
  <td>
   <?php echo $auditdata['Audit']['model']; ?>
  </td>
 </tr>
<tr >
  <td class="row_format"><strong>
   <?php echo __('Activity Date/Time',true); ?></strong>
  </td>
  <td>
  <?php echo $this->DateFormat->formatDate2Local($auditdata['Audit']['created'],Configure::read('date_format'),true); ?>
  </td>
 </tr>
 <?php //display json encode value 
    $getAllFields = json_decode($auditdata['Audit']['json_object'], true);
    $cnt=0;
    foreach($getAllFields[$auditdata['Audit']['model']] as $key => $getAllFieldsval) {
     $cnt++;
 ?>
	<tr>
	 <td class="row_format"><strong> <?php echo $key; ?></strong></td>
	 <td><?php echo $getAllFieldsval; ?></td>
	</tr>
<?php } ?>
</table>
<div>&nbsp;</div>
<div>&nbsp;</div>
<?php 
foreach($auditdelta as $key=>$auditdelta){
		foreach($auditdelta as $var=>$audit){
		$cnt==0; if($cnt%2 == 0){?>

	<table border="0" cellpadding="0" cellspacing="0"
		align="right" class="tableformat" class="tabledata">
		<?php }else { ?>
		<table border="0" cellpadding="0" cellspacing="0"
			align="left" class="tableformat">
			<?php } foreach($audit as $variab=>$audit){
		?>
			
			
			
			<tr>
				
				<td class="row_format"><strong> <?php echo $variab; ?>
				</strong>
				</td>
				<td><?php echo $audit;?>
				</td>
			</tr>
			<?php 

	} ?>
</table>
		<?php  $cnt++;
}}?></table>
    <div>&nbsp;</div> 
			      
