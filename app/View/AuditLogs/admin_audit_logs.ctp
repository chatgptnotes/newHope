<style>
.auditlog_img img {
    height: 35px;
    width: 40px;
}
.auditlog_img p{ font-size:13px; float:left; text-align:center; float:left; clear:left; width:40px;}
.auditlog_img {
    float: left;
    width: 50px;
}
</style>
<div class="inner_title">
 <h3> &nbsp; <?php echo __('Audit Log', true); ?></h3>
</div>
<table cellpadding="5px" cellspacing="5px" align="left">
  <tr>
 <?php if($this->Session->read('role') == "admin" || $this->Session->read('role') == "Admin" || $this->Session->read('role') == "superadmin" || $this->Session->read('role') == "Superadmin") { ?>
   <td align="center" valign="top" width="50" class="auditlog_img">
     <?php echo $this->Html->link($this->Html->image('/img/icons/AUDIT STATUS INNER - EDITED.png', array('alt' => 'Audit Log Status')),array("controller" => "AuditLogs", "action" => "audit_log_permission", "admin" => true,'plugin' => false), array('escape' => false)); ?>
     <p style="margin:0px; padding:0px;"><?php echo __('Audit Log Status',true); ?></p>
   </td>
<?php } ?>
   <td align="center" valign="top" width="50" class="auditlog_img">
     <?php echo $this->Html->link($this->Html->image('/img/icons/history icon inner.png', array('alt' => 'Audit Log History')),array("controller" => "AuditLogs", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
	  <p style="margin:0px; padding:0px;"><?php echo __('Audit Log History',true); ?></p>
   </td>
  <?php if($this->Session->read('role') == "admin" || $this->Session->read('role') == "Admin" || $this->Session->read('role') == "superadmin" || $this->Session->read('role') == "Superadmin") { ?>
   <td align="center" valign="top" width="50" class="auditlog_img">
    <?php echo $this->Html->link($this->Html->image('/img/icons/ALTERED AUDIT LOG INNER  - EDITED.png',array('alt' => 'Altered Audit Log')),array("controller" => "AuditLogs", "action" => "altered_log_details", "admin" => true,'plugin' => false), array('escape' => false)); ?>
	  <p style="margin:0px; padding:0px;"><?php echo __('Altered Audit Log',true); ?></p>
   </td>
  <?php }?>
  <td align="center" valign="top" width="50" class="auditlog_img">
    <?php echo $this->Html->link($this->Html->image('/img/icons/BREAK GLASS EVENT INNER - EDITED.png',array('alt' => 'Break Glass Event')),array("controller" => "AuditLogs", "action" => "emergency_access", "admin" => true,'plugin' => false), array('escape' => false)); ?>
	  <p style="margin:0px; padding:0px;"><?php echo __('Break Glass Event',true); ?></p>
   </td>
  </tr>
</table>
