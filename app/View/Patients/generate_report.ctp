
<div class="inner_title">
	<h3><?php echo __('Patient Report', true); ?></h3>
	<span> <?php 
	echo $this->Html->link(__('Back'),array('action' => 'search'), array('escape' => false,'class'=>'blueBtn')); 
	echo $this->Html->link('Print','#',
			 array('class'=>'grayBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".html_entity_decode($this->Html->url(array('admin' => false, 'action'=>'printReport',"?"=>$this->params->query),true))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400,width:800,height:800');  return false;"));
   			
	
	?></span>
</div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">

 <tr class="row_title">
  	   <td class="table_cell"><strong><?php echo __('Patient Name', true); ?></strong></td>
	   <td class="table_cell"><strong><?php echo __('MRN', true); ?></strong></td>					  
	   <td class="table_cell"><strong><?php echo __('Patient ID', true); ?></strong></td>
	   <td class="table_cell"><strong><?php echo __('Registration Type', true); ?></strong></td>					   
	   <td class="table_cell"><strong><?php echo  __('Sex'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('Age'); ?></strong></td>				   
  </tr>
	<?php
	$toggle =0;
	foreach($pdfData as $patients){
		if($toggle == 0) {
			echo "<tr class='row_gray'>";
			$toggle = 1;
		}else{
			echo "<tr>";
			$toggle = 0;
		}
	?>
	<td class="row_format"><?php echo $patients['Patient']['lookup_name']; ?> </td>
	<td class="row_format"><?php echo $patients['Patient']['admission_id']; ?> </td>
	<td class="row_format"><?php echo $patients['Patient']['patient_id']; ?> </td>
	<td class="row_format"><?php echo $patients['Patient']['admission_type']; ?> </td>
	<td class="row_format"><?php echo ucfirst($patients['Person']['sex']); ?> </td>
	<td class="row_format"><?php echo $patients['Person']['age']; ?> </td>
								   
	
 <?php	} ?>
 	
 
 </table>