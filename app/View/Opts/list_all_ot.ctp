<div class="inner_title">
<h3> &nbsp; <?php echo __('OT Management', true); ?></h3>
<div align="right">
 <?php
 echo $this->Html->link(__('Import Data', true),array('controller' => 'opts', 'action' => 'import_data', 'admin' => false), array('escape' => false,'class'=>'blueBtn' ));
?>

<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>

</div>

</div>
<table cellpadding="5px" cellspacing="5px" align="left">
        <tr>
		                <td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/ot.jpg', array('alt' => 'OR')),array("controller" => "opts", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('OR',true); ?></p>
				</td>
                                <td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/ot-tables.jpg', array('alt' => 'OR Tables')),array("controller" => "opt_tables", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('OR Tables',true); ?></p>
				</td>
                                <td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/surgeries.jpg', array('alt' => 'Surgeries')),array("controller" => "surgeries", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Surgeries',true); ?></p>
				</td>
				<td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/surgery-category.jpg', array('alt' => 'Surgery Category')),array("controller" => "surgery_categories", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Category',true); ?></p>
				</td>
                                <td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/surgery-subcategory.jpg', array('alt' => 'Surgery Subcategory')),array("controller" => "surgery_subcategories", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Subcategory',true); ?></p>
				</td>
				<td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/ot-item.jpg', array('alt' => 'OR Items')),array("controller" => "ot_items", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				
				<p style="margin:0px; padding:0px;"><?php echo __('OR Items',true); ?></p>
				</td>
	<?php /* ?>			<td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/ot-medical-replacement-slip.jpg', array('alt' => 'OT Rule')),array("controller" => "opts", "action" => "optRuleMaster", "admin" => false,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('OT Rule',true); ?></p>
				</td>
<?php */ ?>
             <td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/anesthesia.png', array('alt' => 'Anesthesias')),array("controller" => "Anesthesias", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Anesthesias',true); ?></p>
				</td>
			
				<td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/surgery-category.jpg', array('alt' => 'Anesthesia Category')),array("controller" => "anesthesia_categories", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Anesthesia',true); ?></p><p style="margin:0px; padding:0px;"><?php echo __('Category',true); ?>
				</td>
				
				<td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/surgery-category.jpg', array('alt' => 'Anesthesia Subcategory')),array("controller" => "AnesthesiaSubcategories", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Anesthesia',true); ?></p><p style="margin:0px; padding:0px;"><?php echo __('Subcategory',true); ?></p>
				</td>
		 </tr>
</table>