<div class="inner_title">
 <h3>	
  	<div style="float:left"><?php echo __('View Patient Document Master'); ?></div>			
  	<div style="float:right;">
   	<?php echo $this->Html->link(__('Back'), array('action' => 'patient_document_master'), array('escape' => false,'class'=>'blueBtn'));
   	?>
  	</div>
 </h3>
	<div class="clr"></div>
	</div>
	<table border="0" cellpadding="0" cellspacing="0" align="center" class="table_view_format">
 		<tr class="first">
  			<td class="row_format">
  		<strong>
   		<?php echo __('Document Type',true);?>
  		</strong>
  		</td>
  		<td>
   		<?php echo $opt['PatientDocumentMaster']['document_type']; ?>
  		</td>
 		</tr>
 	
  	
  		<tr>
  		<td class="row_format">
   		<strong>
   		<?php echo __('Description',true); ?>
   		</strong>
  		</td>
  		<td>
   		<?php echo $opt['PatientDocumentMaster']['description']; ?>
  		</td>
  		</tr>
  	
 	</table>
