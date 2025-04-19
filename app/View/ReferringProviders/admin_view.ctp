
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="center">
   <?php 
        if(!empty($errors)) {
         echo implode($errors,"<br />");
        }
   ?>
  </td>
 </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
		<td colspan="2" align="center">
			<h2><?php echo __('View Referring Provider Details');?></h2>
		</td>
		<td><a href="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "index", "admin" => true)); ?>"><?php echo __('Back to list');?></a></td>
	</tr>
	
		<tr>
	<td>
	<?php echo __('Id')?> 
	</td>
	<td>
		<?php echo h($referringProvider['ReferringProvider']['id']); ?>
	</td>
	</tr>
	
	
		<tr>
	<td>
	<?php echo __('Ref Provider Name');?> 
	</td>
	<td>
		<?php echo h($referringProvider['ReferringProvider']['ref_provider_name']); ?>
	</td>
	</tr>
		<tr>
	<td>
	<?php echo __('Active'); ?>
	</td>
	<td>
		<?php echo h($referringProvider['ReferringProvider']['is_active']); ?>
	</td>
	</tr>
			<tr>
	<td>
	<?php echo __('Is Deleted'); ?>
	</td>
	<td>
		<?php echo h($referringProvider['ReferringProvider']['is_deleted']); ?>
	</td>
	</tr>
				<tr>
	<td>
	<?php echo __('Created By'); ?>
	</td>
	<td>
		<?php echo h($referringProvider['ReferringProvider']['created_by']); ?>
	</td>
	</tr>
	
				<tr>
	<td>
	<?php echo __('Modified By'); ?>
	</td>
	<td>
		<?php echo h($referringProvider['ReferringProvider']['modified_by']); ?>
	</td>
	</tr>
		 <tr>
	<td colspan="2" align="center">
        &nbsp;
	</td>
	</tr>
	 <tr>
	<td colspan="2" align="center">
     <?php echo $this->Html->link($this->Form->button(__('Edit', true), array('type' => 'button','class' => 'blueBtn')), array('action' => 'edit', $referringProvider['ReferringProvider']['id']), array('escape' => false)); ?>
	</td>
	</tr>
	 
	</table>