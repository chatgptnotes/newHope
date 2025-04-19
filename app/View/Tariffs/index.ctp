<div class="inner_title">
<h3>&nbsp; <?php echo __('Payer', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Import Data', true),array('controller' => 'tariffs', 'action' => 'import_data', 'admin' => true), array('escape' => false,'class'=>'blueBtn',"style"=>"margin:70px;"));
?>
</span>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<ul class="interIcons">
<li><?php echo $this->Html->link($this->Html->image('/img/icons/category.jpg', array('alt' => 'Service Group')),array("controller" => "tariffs", "action" => "service_category_list", "admin" => false, 'plugin' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Service Group',true); ?></li>
			
<li><?php echo $this->Html->link($this->Html->image('/img/icons/sub-category.jpg', array('alt' => 'Service Sub Group')),array("controller" => "tariffs", "action" => "service_sub_category_list", "admin" => false, 'plugin' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Service Sub Group',true); ?></li>						

<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/tariff-service.jpg', array('alt' => 'Services')),array("controller" => "tariffs", "action" => "viewTariff", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Services',true); ?></li>

<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/tariff-standard.jpg', array('alt' => 'Payer')),array("controller" => "tariffs", "action" => "viewStandard", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Payer',true); ?></li>
				
<li><?php echo $this->Html->link($this->Html->image('/img/icons/item-rate.gif', array('alt' => 'Payer amount')),array("controller" => "tariffs", "action" => "viewTariffAmount", "admin" => false, 'plugin' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Payer amount',true); ?></li>
			

</ul>	



<?php //echo $this->Html->link(__('Add Tariff List'),array('action' => 'addTariff'), array('escape' => false,'class'=>'grayBtn'));?>
<?php //echo $this->Html->link(__('Add Standards'),array('action' => 'addStandard'), array('escape' => false,'class'=>'grayBtn'));?>
<?php //echo $this->Html->link(__('Services'),array('action' => 'viewTariff'), array('escape' => false,'class'=>'grayBtn'));?>
<?php //echo $this->Html->link(__('Tariff Standards'),array('action' => 'viewStandard'), array('escape' => false,'class'=>'grayBtn'));?>
<?php //echo $this->Html->link(__('Assign Tariff'),array('action' => 'selectTariffStandard'), array('escape' => false,'class'=>'grayBtn'));?>
<?php //echo $this->Html->link(__('Tariff Amounts'),array('action' => 'viewTariffAmount'), array('escape' => false,'class'=>'grayBtn'));?>
<?php //echo $this->Html->link(__('Add Nursing Tariff'),array('action' => 'addNursing'), array('escape' => false,'class'=>'grayBtn'));?>
<?php //echo $this->Html->link(__('Nursing Tariff'),array('action' => 'viewNursing'), array('escape' => false,'class'=>'grayBtn'));?>
<?php //echo $this->Html->link(__('Edit Nursing Tariff'),array('action' => 'editNursing'), array('escape' => false,'class'=>'grayBtn'));?>