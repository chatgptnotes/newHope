
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
			<h2><?php echo __('View Insurance Company Details');?></h2>
		</td>
		<td><a href="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "index", "admin" => true)); ?>"><?php echo __('Back to list');?></a></td>
	</tr>
	
		<tr>
	<td>
<?php echo __('Id'); ?>
	</td>
	<td>
		<?php echo h($insuranceCompany['InsuranceCompany']['id']); ?>
	</td>
	</tr>
	<tr>
	<td>
<?php echo __('Name'); ?>
	</td>
	<td>
		<?php echo h($insuranceCompany['InsuranceCompany']['name']); ?>
	</td>
	</tr>
		<tr>
	<td>
<?php echo __('Address'); ?>
	</td>
	<td>
		<?php echo h($insuranceCompany['InsuranceCompany']['address']); ?>
	</td>
	</tr>
				<tr>
	<td>
<?php echo __('City'); ?>
	</td>
	<td>
		<?php echo $this->Html->link($insuranceCompany['City']['name'], array('controller' => 'cities', 'action' => 'view', $insuranceCompany['City']['id'])); ?>
	</td>
	</tr>	
		<tr><td>		
	 <?php echo __('State'); ?>
	</td>
	<td>
			<?php echo $this->Html->link($insuranceCompany['State']['name'], array('controller' => 'states', 'action' => 'view', $insuranceCompany['State']['id'])); ?>
	</td>
	</tr>	
	
	<tr><td>		
	 <?php echo __('Zip'); ?>
	</td>
	<td>
			<?php echo h($insuranceCompany['InsuranceCompany']['zip']); ?>
	</td>
	</tr>	
	
		<tr><td>		
	 <?php echo __('Phone'); ?>
	</td>
	<td>
			<?php echo h($insuranceCompany['InsuranceCompany']['phone']); ?>
	</td>
	</tr>	
	
		
		<tr><td>		
	 <?php echo __('Fax'); ?>
	</td>
	<td>
			<?php echo h($insuranceCompany['InsuranceCompany']['fax']); ?>
	</td>
	</tr>	
		
		<tr><td>		
	 <?php echo __('Email'); ?>
	</td>
	<td>
			<?php echo h($insuranceCompany['InsuranceCompany']['email']); ?>
	</td>
	</tr>	
		<tr><td>		
	 <?php echo __('Active?'); ?>
	</td>
	<td>
			<?php echo h($insuranceCompany['InsuranceCompany']['is_active']); ?>
	</td>
	</tr>	
	
		<tr><td>		
	 <?php echo __('Created By'); ?>
	</td>
	<td>
			<?php echo h($insuranceCompany['InsuranceCompany']['created_by']); ?>
	</td>
	</tr>	
	
			<tr><td>		
	 <?php echo __('Modified By'); ?>
	</td>
	<td>
			<?php echo h($insuranceCompany['InsuranceCompany']['modified_by']); ?>
	</td>
	</tr>	
	
	 <tr>
	<td colspan="2" align="center">
     <?php echo $this->Html->link($this->Form->button(__('Edit', true), array('type' => 'button','class' => 'blueBtn')), array('action' => 'edit', $insuranceCompany['InsuranceCompany']['id']), array('escape' => false)); ?>
	</td>
	</tr>
	 
	</table>