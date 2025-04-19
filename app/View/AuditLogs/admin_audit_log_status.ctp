<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left" class="error">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?>
  </td>
 </tr>
</table>
<?php } ?>
 
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#auditlogstatusfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Audit Log Status', true); ?></h3>
</div>
<form name="auditlogstatusfrm" id="auditlogstatusfrm" action="<?php echo $this->Html->url(array("action" => "audit_log_status", "admin" => true, $id['AuditLogStatus']['id'])); ?>" method="post" >
	<table class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
			 
			<tr>
			<td class="form_lables" align="center">
			<?php echo __('Audit Log Status'); ?>
			</td>
			<td>
		        <?php 
		       	 	echo $this->Form->input('AuditLogStatus.audit_log_status', array('options' => array('1' => 'Yes', '0' => 'No') , 'default' => $id['AuditLogStatus']['audit_log_status'], 'id'=>'audit_log_status','label'=> false, 'div' => false, 'error' => false));
		        ?>
			</td>
			</tr>
	 
	 
	<tr>
		<td>
			 &nbsp;
		</td>
		<td>
			<?php				    			 
						echo $this->Html->link(__('Cancel', true), array('action' => 'audit_log_permission'), array('class' => 'grayBtn','escape' => false));
					 
						echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));			
		    ?>	
			
		</td>
	</tr>
	</table>
</form>