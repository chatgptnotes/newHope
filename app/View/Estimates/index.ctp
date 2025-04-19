<?php 
  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');
?>
<style>
	label{
		width:126px;
		padding:0px;
	}
</style>
 <div class="inner_title">
	<h3> &nbsp; <?php echo __('Estimate', true); ?></h3>
	<span></span>
</div>
<div class="clr">&nbsp;</div>

<?php echo $this->Form->create('EstimatePatient',array('url'=>array('controller'=>'estimates','action'=>'index'),'type'=>'get'));?>
<table border="0" class=""  cellpadding="0" cellspacing="0" width="500px" align="center">
	<tbody>		    			 				    
		<tr class="row_title">				 
			
			<td class="" style="height:40px"><label><?php echo __('First Name') ?> :</label></td>										
			
			<td class="">											 
		    	<?php 
		    		 echo    $this->Form->input('first_name', array('id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>
		  				 
			
		 	<td class=""><label><?php echo __('Last Name') ?></label></td>
			<td class="">											 
		    	<?php 
		    		 echo    $this->Form->input('last_name', array('id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>
		  	<td class="">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>	
		 	
		 			 
			
		 
		 </tr>	
							
	</tbody>	
</table>
<?php echo $this->Form->end();?>
<div style="text-align: right;" class="clr inner_title"></div>	 

<div style="float:right;margin-top:10px;"><?php 
		echo $this->Html->link(__('New Estimate'),array('action' => 'add'), array('escape' => false,'class'=>'blueBtn','id'=>'advancePayment','style'=>'margin-left:0px;'));
		?></div>

 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
<?php if(isset($data) && !empty($data)){  ?>
			
				  
				  <tr class="row_title">
					   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('EstimatePatient.id', __('Patient ID', true)); ?></strong></td>
					   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('EstimatePatient.first_name', __('Patient Name', true)); ?></strong></td>
                       <td class="table_cell" align="left"><strong><?php echo  __('Action'); ?></strong></td>
					   
				  </tr>
				  <?php 
				  	  $toggle =0;
				      if(count($data) > 0) {
				      		foreach($data as $patients){
				       
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
								  ?>								  
								   <td class="row_format" align="left"><?php echo $patients['EstimatePatient']['id']; ?></td>
								   <td class="row_format" align="left"><?php echo $patients['Initial']['name']." ".ucfirst($patients['EstimatePatient']['first_name']).' '.ucfirst($patients['EstimatePatient']['last_name']); ?> </td>
								   						   
								   	   
								   <td valign="bottom" align="center" style="text-align: center;">
								   		<?php 
								   			echo $this->Html->link($this->Html->image('icons/uerInfo.png', array('alt' => __('View', true), 'style'=>'height:20px;width:18px;','title' => __('View', true))), array('action' => 'estimateTypes', $patients['EstimatePatient']['id']), array('escape' => false));
								   			/*if($patients['DischargebyConsultant']['discharge_date']){
								   				echo $this->Html->image('icons/ready-discharge.png', array('alt' => __('Ready For Discharge', true),'title' => __('Ready For Discharge', true),'style'=>'height:20px;width:18px;'));
								   			}*/
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
			   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
			  </tr>
			  <?php
			      }
			  ?>
		  
		 </table>
<script>
$(document).ready(function(){
	 
	$("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","EstimatePatient","first_name", "admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});

	$("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","EstimatePatient","last_name", "admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});

});
</script>		 