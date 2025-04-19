<div class="inner_title">
<h3><?php echo __('View Complaint', true); ?></h3>
<span><?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));?></span>
</div>  
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
		<td colspan="2" align="center">
		<br>
		</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Patient Name'); ?><font color="red">*</font>
		</td>
		<td >
	        <?php  echo  ucfirst($this->data['Complaint']['patient_name']) ;?>
		</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Date'); ?><font color="red">*</font>
		</td>
		<td >
	        <?php echo $this->DateFormat->formatDate2Local($this->data['Complaint']['date'],Configure::read('date_format'),true); ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Complaint'); ?><font color="red">*</font>
		</td>
		<td>
	        <?php echo  nl2br($this->data['Complaint']['complaint']) ;?>
		</td>
	</tr>	
	<tr>
		<td class="form_lables">
		<?php echo __('Action Taken'); ?>
		</td>
		<td>
			 <?php echo  nl2br($this->data['Complaint']['action_taken']) ;?>
	    </td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Time of Resolution'); ?>
		</td>
		<td>
			<?php echo  $this->DateFormat->formatDate2Local($this->data['Complaint']['time_of_resolution'],Configure::read('date_format'),true);?>	        
		</td>
	</tr>
	<?php if(!empty($this->data['Complaint']['resolution_time_taken'])){?>
	<tr>
		<td class="form_lables">
		<?php echo __('Resolution Time Taken'); ?>
		</td>
		<td>
			<?php echo  $this->DateFormat->getTimeStringFormSec($this->data['Complaint']['resolution_time_taken']) ;?>	       
		</td>
	</tr> 
	<?php }?>
	<tr>
		<td class="form_lables">
		<?php echo __('Resolved'); ?>
		</td>
		<td class="form_lables">	          
	     	<?php echo  (!isset($this->data['Complaints']['resolved']))?'No':'Yes' ;?>
		</td>
	</tr> 
	 
	</table> 