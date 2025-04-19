<style>
.tableformat{
border: 1px solid #4C5E64;
    margin-top: 20px;
    padding: 0;
    width: 515px
    }
    </style>
<div class="inner_title">
	<h3>
		<div style="float: left"> 
			<?php echo __('View Logs Details'); ?>
		</div>
		<div style="float: right;">
			<?php
			echo $this->Html->link(__('Print List'),'#',array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printview',$id))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));

		 
			if($this->params->query['return']=='notes_edit'){ 
				echo $this->Html->link(__('Back to List'), array('action' => 'edit_notes_log','admin'=>true), array('escape' => false,'class'=>'blueBtn'));
			}else{
				echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			} 
			?>
		</div>
	</h3>
	<div class="clr"></div>
</div>

	<?php 
	foreach($auditdelta as $key=>$auditdelta){
		foreach($auditdelta as $var=>$audit){
		$cnt==0; if($cnt%2 == 0){?>
	<table border="0" cellpadding="0" cellspacing="0"
		align="right" class="tableformat">
		<?php }else { ?>
		<table border="0" cellpadding="0" cellspacing="0"
			align="left" class="tableformat">
			<?php } foreach($audit as $variab=>$audit){
				
				if($variab=='id' || $variab=='audit_id') continue; 
		if($cnt%2 == 0){?>
			<tr class="row_gray">
				<?php }else { ?>
			
			
			<tr>
				<?php }?>
				<td class="row_format"><strong> <?php echo $variab; ?>
				</strong>
				</td>
				<td <?php if($variab == 'new_value') echo 'style="color:blue;"'; ?>><?php echo $audit;?>
				</td>
			</tr>
			<?php 
	} ?>
		</table>
		<?php  $cnt++;
}}?>
 
<table border="0" cellpadding="0" cellspacing="0" width="500" align="center" class="tableformat">
	

	<!-- <tr class="first">
  <td class="row_format"><strong>
   <?php echo __('Id',true); ?></strong>
  </td>
  <td>
   <?php echo $auditdata['Audit']['id']; ?>
  </td>
 </tr>  -->
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
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Name',true); ?></strong>
  </td>
  <td>
   <?php 
   		if($auditdata['Audit']['model']=='LaboratoryToken'){
   			echo $labName['Laboratory']['name'];
   		}else if ($auditdata['Audit']['model']=='RadiologyTestOrder'){
			echo $radName['Radiology']['name'];
		}
    ?>
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
  <?php echo $this->DateFormat->formatDate2LocalForReport($auditdata['Audit']['created'],Configure::read('date_format'),true); ?>
  </td>
 </tr>
 
 <?php //display json encode value 
    $getAllFields = json_decode($auditdata['Audit']['json_object'], true);
    $cnt=0;
    foreach($getAllFields[$auditdata['Audit']['model']] as $key => $getAllFieldsval) {
     $cnt++;
 ?>
	<tr <?php if($cnt%2 == 1) echo 'class="row_gray"'; ?> >
	 <td class="row_format"><strong> <?php echo $key; ?></strong></td>
	 <td><?php echo $getAllFieldsval; ?></td>
	</tr>
<?php } ?>
 
</table>