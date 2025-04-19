<?php 
  	echo $this->Html->script('jquery.autocomplete');
  	echo $this->Html->css('jquery.autocomplete.css');
   
  if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		<tr>
	  		<td colspan="2" align="left" class="error">
		   		<?php 
		     		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		   		?>
	  		</td>
	 </tr>
	</table>
<?php 
	
}  ?>
<style>
	label{
		width:126px;
		padding:0px;
	}
</style>		
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Patient ID Enquiry', true); ?></h3>
	<span><?php 
		//echo $this->Html->link(__('Add New Patients'), array('action' => 'add_ambi'), array('escape' => false,'class'=>'blueBtn'));
	?></span>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('',array('action'=>'search','type'=>'get'));?>	
<table border="0" class=""  cellpadding="0" cellspacing="0" width="500px" align="center">
	<tbody>				    			 				    
		<tr class="row_title">				 		
			<td class=""><label><?php echo __('Patient Name') ?> :</label></td>		
			<td class="">											 
		    	<?php 
		    		 echo    $this->Form->input('first_name', array('id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td> 
		 	 
			<td class=""><label><?php echo __('Patient ID') ?> :</label></td>
			<td class="">											 
		    	<?php 
		    		 echo    $this->Form->input('patient_uid', array('type'=>'text','id' => 'Person_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
		    	?>
		  	</td><!--
		  	<td class=""><label><?php echo __('Employee ID No') ?> :</label></td>
			<td class="">											 
		    	<?php 
		    	 
		    		 echo    $this->Form->input('non_executive_emp_id_no', array('type'=>'text','id' => 'non_executive_emp_id_no', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
		    	?>
		  	</td> 
		 
			--><td class="" align="right" colspan="3" style="">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
							
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>
	<div style="text-align: right;" class="clr inner_title"></div>	 
 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  
<?php if(isset($data) && !empty($data)){  ?>
			
				 
				  <tr class="row_title">
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Person.patient_uid', __('Patient ID', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Person.patient_uid', __('Employee ID No.', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Person.uiddate', __('UID Allocation Date', true)); ?></strong></td>					   
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Person.first_name', __(' Name', true)); ?></strong></td>					   
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Person.sex', __('Sex', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>
					   
				  </tr>
				  <?php 
				  	  $toggle =0;
				      if(count($data) > 0) {
				      		foreach($data as $Persons){
				       
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
								  ?>								  
								   <td class="row_format"><?php echo $Persons['Person']['patient_uid']; ?></td>
								   <td class="row_format"><?php
								   	 	if($Persons['Person']['non_executive_emp_id_no'])
								   			echo $Persons['Person']['non_executive_emp_id_no'].$Persons['Person']['relation_to_employee']; 
								   		else
								   			echo $Persons['Person']['executive_emp_id_no'];
								   		?>
								   		
								   </td>
								   <td class="row_format"><?php echo $this->DateFormat->formatDate2Local($Persons['Person']['create_time'],Configure::read('date_format'),true); ?> </td>
								   <td class="row_format"><?php echo $Persons['Person']['full_name']; ?> </td>
								   <td class="row_format"><?php echo ucfirst($Persons['Person']['sex']); ?> </td>						   
									   
								   <td>
								   <?php 
								   		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'patient_information', $Persons['Person']['id']), array('escape' => false,'title'=>'View'));
								   
								 	 echo $this->Html->link($this->Html->image('icons/delete-icon.png'), 
								   				 array('action' => 'delete', $Persons['Person']['id'],$Persons['Person']['patient_uid']),
								   				 array('escape' => false,'title'=>'Delete'),"Are you sure you wish to delete this UIDPatient?"); ?>
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
	//script to include datepicker
		$(function() {
			$("#dob").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>', 
		});
		});
			/*$("#PersonSearchForm").click(function(){
			  $('input:text').each(function(){
			    alert($(this).text())
			  });
			}); */
			
			
		$('#PersonSearchForm').submit(function(){
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
		
		 
   
  $(document).ready(function(){
    	 
			$("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "persons", "action" => "uid_autocomplete","admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				select: function(e){ alert(e);}
			});
			 
			$("#Person_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","Patient_uid","admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			/*$("#non_executive_emp_id_no").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","non_executive_emp_id_no","null","null","null","null","non_executive_emp_id_no", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});*/
	 	});
  </script>
 
				