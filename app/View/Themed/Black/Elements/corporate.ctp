
        
        <ul class="interIcons">
<li><?php echo $this->Html->link($this->Html->image('/img/icons/corporate.jpg', array('alt' => 'Corporate')),array("controller" => "corporates", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Corporate',true); ?></p></li>
			
<li><?php echo $this->Html->link($this->Html->image('/img/icons/corporate-locations.jpg', array('alt' => 'Corporate Locations')),array("controller" => "corporate_locations", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Corporate Location',true); ?></p></li>						

<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/corporate-sub-locations.jpg', array('alt' => 'Corporate Sub Locations')),array("controller" => "corporate_sublocations", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Corporate Sub Location',true); ?></p></li>

<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/insurance-type.jpg', array('alt' => 'Insurance type')),array("controller" => "insurance_types", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Insurance type',true); ?></p></li>
				
<li><?php echo $this->Html->link($this->Html->image('/img/icons/insurance-companies.jpg', array('alt' => 'Insurance Companies')),array("controller" => "insurance_companies", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Insurance Companies',true); ?></p></li>
			

</ul>	