<style>.row_action img{float:inherit;}
.searchbtn{float:left;}</style><div class="inner_title">
<h3> &nbsp; <?php echo __('Audit Log Status', true); if($checkStatus['AuditLogStatus']['audit_log_status'] == 1 || !isset($checkStatus['AuditLogStatus']['audit_log_status'])) echo "(". $this->Html->link(__('Enabled'), array('action' => 'audit_log_status', 'admin' => true), array('escape' => false, 'alt' => 'Change Audit Log Status', 'title' => 'Change Audit Log Status')).")"; else echo "(". $this->Html->link(__('Disabled'), array('action' => 'audit_log_status', 'admin' => true), array('escape' => false, 'alt' => 'Change Audit Log Status', 'title' => 'Change Audit Log Status')). ")"; ?></h3>
<span>
<?php echo $this->Html->link(__('Add Specific Audit Log'), array('action' => 'add_audit_log_permission'), array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Back', true),array('action' => 'audit_logs', 'admin' => true), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<form name="usersearchfrm" id="consultantsearchfrm" action="<?php echo $this->Html->url(array("action" => "audit_log_permission")); ?>" method="post"  >
<table border="0" class="table_format"  cellpadding="3" cellspacing="0" width="100%" align="center">
  <tr class="row_title">				 
   <td class=" " align="left" width="6%"><?php echo __('Username') ?> :</td>								
   <td class=" " width="5%">
    <?php 
        echo $this->Form->input('', array('name' => 'first_name', 'id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
    ?>
   </td>
							
  
	<td class="searchbtn ">
   <?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?>
   <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>''),array('escape'=>false, 'title' => 'refresh'));?>
   </td>
  </tr>	
</table>



<div class="btns"> </div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  
 <tr class="row_title">
   <td class="table_cell" ><strong><?php echo __('Sr.No.', true); ?></strong></td>
   <td class="table_cell" ><strong><?php echo $this->Paginator->sort('AuditLogPermission.name', __('Module', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('AuditLogPermission.username', __('Username', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('AuditLogPermission.status', __('Status', true)); ?></strong></td>
   <td class="table_cell" align="center"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $auditlogperm): 
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format" ><?php echo $cnt; ?> </td>
   <td class="row_format" ><?php echo $auditlogperm['AuditLogPermission']['model']; ?> </td>
   <td class="row_format"><?php echo $auditlogperm['User']['username']; ?> </td>
   <td class="row_format" ><?php if($auditlogperm['AuditLogPermission']['status'] == 1) echo __('Enabled'); else echo __('Disabled'); ?> </td>
   <td align="center" class="row_action ">
   <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Audit Log Permission', true),'title' => __('View Audit Log Permission', true))), array('action' => 'view_audit_log_permission',  $auditlogperm['AuditLogPermission']['id']), array('escape' => false));
   ?>
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Audit Log Permission', true),'title' => __('Edit Audit Log Permission', true))),array('action' => 'edit_audit_log_permission', $auditlogperm['AuditLogPermission']['id']), array('escape' => false));
   ?>
   <?php 
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Audit Log Permission', true),'title' => __('Delete Audit Log Permission', true))), array('action' => 'delete_audit_log_permission', $auditlogperm['AuditLogPermission']['id']), array('escape' => false),__('Are you sure?', true));
   ?>
   </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="5" align="center">
     <!-- Shows the page numbers -->
     <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     <!-- Shows the next and previous links -->
     <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
     <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
     <!-- prints X of Y, where X is current page and Y is number of pages -->
     <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
    </TD>
   </tr>
  <?php
         } else {
  ?>
  <tr>
   <TD colspan="5" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
</table>

<script>
	$(function() {
		$("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","AuditLogPermission","user_id",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
		
	});
</script>

