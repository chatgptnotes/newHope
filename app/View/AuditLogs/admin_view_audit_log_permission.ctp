<div class="inner_title">
 <h3>	
  <div style="float:left"><?php echo __('View Audit Log Permission'); ?></div>			
  <div style="float:right;">
   <?php
	echo $this->Html->link(__('Back to List'), array('action' => 'audit_log_permission'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </div>
 </h3>
<div class="clr"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" align="center" class="table_view_format">
 <tr class="first">
  <td class="row_format">
   <strong>
    <?php echo __('Module',true); ?>
   </strong>
  </td>
  <td>
   <?php echo $auditlogperm['AuditLogPermission']['model']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
   <strong>
    <?php echo __('Username',true); ?>
   </strong>
  </td>
  <td>
   <?php echo $auditlogperm['User']['username']; ?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Status',true); ?>
  </td>
  <td class="row_format">
   <?php if($auditlogperm['AuditLogPermission']['status'] == 1) echo __('Enabled'); else echo __('Disabled'); ?>
  </td>
 </tr>
 </table>
