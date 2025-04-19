<style>
.row_action img{
float:inherit;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Patient Document Master', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Add Patient Document Master'), array('action' => 'add_patient_document_master'), array('escape' => false,'class'=>'blueBtn'));
	      echo $this->Html->link(__('Back'), array('controller' => 'users', 'action' => 'menu', '?' => 'type=master', 'admin' => true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
 	</div>
 	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">

		<tr class="row_title">
			<td class="table_cell" align="left">
			<strong><?php echo $this->Paginator->sort('PatientDocumentMaster.document_type', __('Document Type', true));?>
			</strong></td>
	
			
			<td class="table_cell"align="left">
			<strong><?php echo $this->Paginator->sort('PatientDocumentMaster.description', __('Description',true)); ?>
			</strong></td>
			
		
			<td class="table_cell" align="left" >
			<strong><?php echo __('Action', true); ?>
			</strong></td>
		</tr>
		<?php 
		$cnt =0;
		if(count($data) > 0) {
      
     	 foreach($data as $opts):
       	$cnt++;
       	?>
			<tr<?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"align="left"><?php echo $opts['PatientDocumentMaster']['document_type']; ?>
			</td>
			<!--  <td class="row_format" align="left"> <?php
			if(strlen($opts['PatientDocumentMaster']['documenttype']) > 50) {
           	echo substr($opts['PatientDocumentMaster']['documenttype'], 0, 50);
           	} else {
          	echo $opts['PatientDocumentMaster']['documenttype'];
           	}
           ?></td>-->
          	<td class="row_format" align="left"> <?php
		    if(strlen($opts['PatientDocumentMaster']['description']) > 50) {
           	echo substr($opts['PatientDocumentMaster']['description'], 0, 50);
           } else {
          	echo $opts['PatientDocumentMaster']['description'];
           }
           ?></td>
   
		<td class="row_action" align="left">
		<?php echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Patient Document Master', true),'title' => __('View Patient Document Master', true))),array('action' => 'view_patient_document_master', $opts['PatientDocumentMaster']['id']), array('escape' => false));
		?>  
	
		<?php echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Patient Document Master', true),'title' => __('Edit Patient Document Master', true))),array('action' => 'edit_patient_document_master', $opts['PatientDocumentMaster']['id']), array('escape' => false));
		?> 
		
		<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Patient Document Master', true),'title' => __('Delete Patient Document Master', true))), array('action' => 'delete_patient_document_master', $opts['PatientDocumentMaster']['id']), array('escape' => false),__('Are you sure?', true));
		?> 
		</td>
		</tr>
		<?php endforeach;  ?>
		<tr>
			<TD colspan="5" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
			</span>
			</TD>
		</tr>
		<?
         } else {
  		?>
		<tr>
		<TD colspan="5" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
      }
      ?>
	 </table>

