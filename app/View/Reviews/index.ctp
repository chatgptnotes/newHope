
<div class="inner_title">
	<h3>Review</h3>
</div>
<ul class="interIcons">

	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/register.jpg', array('alt' => 'Document List')),array("controller" => "Reviews", "action" => "document_list",'plugin' => false), array('escape' => false,'label'=>'Document List')); ?></li>
					
						
	<li> <?php echo $this->Html->link($this->Html->image('/img/icons/in-patient-assessment.jpg', array('alt' => 'Patient XML')),array("controller" => "Reviews", "action" => "patient_xml", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Patient XML')); ?></li>				
					
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/Investigation-Request.jpg', array('alt' => 'CCD/CCR')),array("controller" => "Reviews", "action" => "ccd_ccr", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'CCD/CCR')); ?></li>				
								
	
								

</ul>
