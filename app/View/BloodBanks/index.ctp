<style>
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>

 <div class="inner_title">
	<h3>&nbsp; <?php  echo __('Blood Requisition List', true); ?></h3>
	<span><?php 
	 
         echo $this->Html->link('Back',array('controller'=>'patients','action'=>'patient_information',$patient_id),array('escape'=>false,'class'=>'blueBtn'));
                      
		echo $this->Html->link(__('Blood Requisition'), array('action' => 'blood_requisition',$patient_id), array('escape' => false,'class'=>'blueBtn')); 
			
	?></span>
</div>
<?php echo $this->element('patient_information');?> 
 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">

<?php if(isset($data) && !empty($data)){  ?> 
				  <tr class="row_title">
					    
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('BloodOrder.type_of_request', __('Type of Request', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('BloodOrder.order_date', __('Order Date', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td> 
				  </tr>
				  <?php 
				  	  $toggle =0;
				      if(count($data) > 0) {
				      		$c=0;
				      		foreach($data as $BloodOrder){
				       			   $c=1 ;	
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
								  ?>		 
								   <td class="row_format"><?php echo ucfirst($BloodOrder['BloodOrder']['type_of_request']) ;?> </td>
								   <td class="row_format"><?php echo ucfirst($this->DateFormat->formatDate2Local($BloodOrder['BloodOrder']['order_date'],Configure::read('date_format'),true)); ?> </td> 
								   <td>
								   		<?php 
								   				echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'blood_requisition',$BloodOrder
								   				['BloodOrder']['patient_id'] ,$BloodOrder['BloodOrder']['id'] ), array('escape' => false,'title'=>'Edit'));
								   				
										   		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print','alt'=>'Print')),'#',
											     	array('escape' => false ,'onclick'=>"var openWin = window.open('".$this->Html->url(array
											     	('action'=>'blood_requisition_print',$BloodOrder['BloodOrder']['patient_id'],$BloodOrder['BloodOrder']
											     	['id']))."','_blank',
											        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');  
											        return false;"));
											     	
											   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'blood_requisition_delete',$BloodOrder['BloodOrder']['id'] ), array('escape' => false,'title'=>'Delete'),__('Are you sure?'));
								   		?>
								  </td>
								  </tr>
					  <?php } 
					 			//set get variables to pagination url
					  			$this->Paginator->options(array('url' =>array("?"=>$this->params->query))); 
					   ?>
					   <tr>
					    <TD colspan="8" align="center">
					    <!-- Shows the page numbers -->
					 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
					 <!-- Shows the next and previous links -->
					 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
					 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
					 <!-- prints X of Y, where X is current page and Y is number of pages -->
					 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
					    </TD>
					   </tr>
			<?php } ?> <?php					  
			      } else {
			 ?>
			  <tr>
			   <TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
			  </tr>
			  <?php
			      }
			  ?> 
		 </table> 
<script> 
  $(document).ready(function(){ 
	  });
  </script>
 
				