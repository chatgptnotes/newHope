<style>.row_action img{float:inherit;}</style>
<div class="inner_title">
  <h3><?php echo __('Physiotherapy Assessment Form List'); ?></h3>
  <span> 
  	<?php 
   echo $this->Html->link(__('Add'),array('action'=>'physiotherapy_assessment',$patient_id),array('escape' => false,'class'=>'blueBtn')) ;
   echo $this->Html->link(__('Back'),array('action'=>'patient_information',$patient_id),array('escape' => false,'class'=>'blueBtn')) ; 
    ?>
  </span>
</div>
<?php echo $this->element('patient_information');?>
<p class="ht5"></p>  

   <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
<?php if(isset($data) && !empty($data)){  ?>			
				 
				  <tr class="row_title"> 
					   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('PhysiotherapyAssessment.Physiotherapist', __('Physiotherapist')); ?></strong></td>
					   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('PhysiotherapyAssessment.submit_date', __('Date', true)); ?></strong></td>					   
					   <td class="table_cell" align="left"><strong><?php echo  __('Action'); ?></strong></td>				   
				  </tr>
				  <?php 
				  	  $toggle =0;
				      if(count($data) > 0) {
				      		foreach($data as $physioList){
				       
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       } 
								  ?> 
								  <td class="row_format"  align="left"><?php echo $physioList['PhysiotherapyAssessment']['physiotherapist_incharge']; ?> </td>
								  <td class="row_format" align="left"><?php 
								  	echo $this->DateFormat->formatDate2Local($physioList['PhysiotherapyAssessment']['submit_date'],Configure::read('date_format'),true) ;
								  	  ?> </td>
								  <td class="row_action" align="left">
								   	   <?php 
											 echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit')),array('action'=>'physiotherapy_assessment',$patient_id,$physioList['PhysiotherapyAssessment']['id']),
										     array('escape' => false));
										   
										     echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print')),'#',
										     array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_physiotherapy_assessment',$physioList['PhysiotherapyAssessment']['id']))."', '_blank',
										           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
										     echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_physiotherapy_assessment', $physioList['PhysiotherapyAssessment']['id']), 
				 							 array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
	   			  						?>                 
					 			     </td>          							    
								  </tr>
					  <?php }  ?>
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
			   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
			  </tr>
			  <?php
			      }
			  ?>
		  
		 </table>