
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
			<h2><?php echo __('View Collaborate Company Details');?></h2>
		</td>
		<td><a href="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "index", "admin" => true)); ?>"><?php echo __('Back to list');?></a></td>
	</tr>
	
		<tr>
	<td>
	<?php echo __('Id'); ?>
	</td>
	<td>
		<?php echo h($collaborateCompany['CollaborateCompany']['id']); ?>
	</td>
	</tr>

				<tr>
	<td>
	<?php echo __('Employer Name'); ?>
	</td>
	<td>
	<?php echo h($collaborateCompany['CollaborateCompany']['employer_name']); ?>
	</td>
	</tr>
	
				<tr>
	<td>
	<?php echo __('Active'); ?>
	</td>
	<td>
	<?php echo h($collaborateCompany['CollaborateCompany']['is_active']); ?>
	</td>
	</tr>
	<tr>
	<td>
	<?php echo __('Created By'); ?>
	</td>
	<td>
	<?php echo h($collaborateCompany['CollaborateCompany']['created_by']); ?>
	</td>
	</tr>
	
				<tr>
	<td>
	<?php echo __('Modified By'); ?>
	</td>
	<td>
		<?php echo h($collaborateCompany['CollaborateCompany']['modified_by']); ?>
	</td>
	</tr>
		 <tr>
	<td colspan="2" align="center">
        &nbsp;
	</td>
	</tr>
	 <tr>
	<td colspan="2" align="center">
     <?php echo $this->Html->link($this->Form->button(__('Edit', true), array('type' => 'button','class' => 'blueBtn')), array('action' => 'edit', $collaborateCompany['CollaborateCompany']['id']), array('escape' => false)); ?>
	</td>
	</tr>
	 
	</table>