<table style="margin-top: 5px;">
	<tr>
	<td>Select Tariff:</td>
	
	<td>
		<?php  //$tariffData=array('bhel'=>'BHEL','bsnl'=>'BSNL','cghs'=>'CGHS','echs'=>'ECHS','mahindra'=>'Mahindra & Mahindra','fci'=>'FCI','raymond'=>'Raymond','wcl'=>'WCL','mpkay'=>'MPKAY','OTHER'=>'OTHER');
		echo $this->Form->input('tariff_standard_id', array(  'empty'=>__('Please Select') , 'options'=>$tariffData,'class' => ' textBoxExpnd','id'=>'tariff',
				'label'=>false,'value'=>$tariffStandardID)); ?>
	</td>
	</tr>
</table>



<script type="text/javascript">


	$("#tariff").change(function(){
		var corporate = $(this).val();
		window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "selectCorporate", "admin" => false)); ?>"+"/"+corporate;
	
/*if(corporate.toLowerCase()=='bsnl'){

	 window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "bsnl_report", "admin" => true)); ?>"
}else if(corporate.toLowerCase()=='cghs'){
	window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "cghs_report", "admin" => true)); ?>"
}else if(corporate.toLowerCase()=='echs'){
	window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "echs_report", "admin" => true)); ?>"
}else if(corporate.toLowerCase()=='mahindra'){
	window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "mahindra_report", "admin" => true)); ?>"
}else if(corporate.toLowerCase()=='fci'){
	window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "fci_report", "admin" => true)); ?>"
}else if(corporate.toLowerCase()=='raymond'){
    window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "raymond_report", "admin" => true)); ?>"
}else if(corporate.toLowerCase()=='wcl'){
    window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "wcl_report", "admin" => true)); ?>"	
}else if(corporate.toLowerCase()=='mpkay'){
	window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "mpkay_report", "admin" => true)); ?>"
}else if(corporate.toLowerCase()=='bhel'){
	window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "bhel_outstanding_report", "admin" => true)); ?>"
}else{
	window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "other_outstanding_report", "admin" => true)); ?>"+"/"+corporate;	
}*/
	});

</script>	

	



