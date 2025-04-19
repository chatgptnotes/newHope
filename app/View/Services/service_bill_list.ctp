 <?php
 
 	echo $this->Html->script('jquery.autocomplete');
 	echo $this->Html->css('jquery.autocomplete.css');
 ?>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Service Billing Management', true); ?></h3>

</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>

<?php } ?>
<?php echo $this->Form->create('',array('action'=>'service_bill_list'));?>	
<table border="0"   cellpadding="0" cellspacing="0" width="500px" >
	<tbody>
					    			 				    
		<tr >				 
			
			<td ><label><?php echo __('Patient Name') ?> :</label></td>										
			<td>												 
		    	<?php 
		    		 echo    $this->Form->input('ServiceBill.lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>	
		  	
		 </tr>		 
		 <tr >				 
			<td ><label><?php echo __('MRN') ?> :</label></td>
			<td >											 
		    	<?php 
		    		 echo    $this->Form->input('ServiceBill.admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false));
		    	?>
		  	</td>
		 </tr>	
		 <tr >				 
			<td ><label><?php echo __('Billing Date') ?> :</label></td>
			<td >											 
		    	<?php 
		    		 echo    $this->Form->input('ServiceBill.date', array('type'=>'text','id' => 'billDate', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly'));
		    	?>
		  	</td>
		  	 
		 </tr>	
		 <tr class="row_title">				 
			<td class="row_format" align="right" colspan="2">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
							
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr>
  <td colspan="8" align="right">
  <?php 
   #echo $this->Html->link(__('Add Service'), array('action' => 'add_service_bill'), array('escape' => false,'class'=>'blueBtn'));
   echo $this->Html->link(__('Add Service'), array('action' => 'selectCorporate'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </tr>
  <tr class="row_title">   
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.lookup_name', __('Patient Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.admission_id', __('Admisssion ID', true)); ?></strong></td> 
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('ServiceBill.date', __('Date', true)); ?></strong></td>   
   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
  	  $toggle =0;
      if(count($service) > 0) {      
      
       foreach($service as $services): 
	       if($toggle == 0) {
	       	echo "<tr class='row_gray'>";
	       	$toggle = 1;
	       }else{
	       	echo "<tr>";
	       	$toggle = 0;
	       }
  ?>  
    
   <td class="row_format"><?php echo ucfirst($services['Patient']['lookup_name']); ?> </td>
   <td class="row_format"><?php echo ucfirst($services['Patient']['admission_id']); ?> </td>
   <td class="row_format">
   		<?php
   			//echo date('d F Y',strtotime($services['ServiceBill']['date']));
   			echo $this->DateFormat->formatDate2Local($services['ServiceBill']['date'],Configure::read('date_format'));   			
   	 	//	echo $this->DateFormat->formatDate2Local($services['ServiceBill']['date'],Configure::read('date_format'));
   	 	?> 
   </td>   
   <td><?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View', true), 'title' => __('View', true))), array('action' => 'view_service_bill', $services['ServiceBill']['patient_id'],$services['ServiceBill']['date']), array('escape' => false));
    
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit', true), 'title' => __('Edit', true))), array('action' => 'edit_service_bill', $services['ServiceBill']['patient_id'],$services['ServiceBill']['date']), array('escape' => false));
   
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete', true), 'title' => __('Delete', true))), array('action' => 'delete_service_bill', $services['ServiceBill']['patient_id'],$services['ServiceBill']['date']), array('escape' => false),__('Are you sure?', true));
   
   ?></td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 	<span class="paginator_links">
 		<?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
 		</span>
    </TD>
   </tr>
  <?php
  
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
    	 
			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});			 
			$("#service").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Service","name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
		 
	 	});
	 	
	 			
		$('#SubServiceServiceBillListForm').submit(function(){
			var msg = false ; 
			$("form input:text").each(function(){
			       //access to form element via $(this)
			       
			       if($(this).val() !=''){
			       		msg = true  ;
			       }
			    }
			);
			if(!msg){
				alert("Please fill atleast one field .");
				return false ;
			}		
		});
		
		$(function() {
			$("#billDate").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',				 
				dateFormat:'<?php echo $this->General->GeneralDate();?>',		
				onSelect: function ()
			    {			        // The "this" keyword refers to the input (in this case: #someinput)
			        this.focus();
			    }	
			}); 
		});
</script>
