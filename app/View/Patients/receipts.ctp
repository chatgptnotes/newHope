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
<?php } ?>
		
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Patient Management', true); ?></h3>
	<span></span>
</div>
<?php echo $this->Form->create('Patient',array('action'=>'receipts','type'=>'get'));?>	
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="500px" >
	<tbody>
					    			 				    
		<tr class="row_title">				 
			
			<td class="row_format" align="right" width="20%"><label><?php echo __('Patient Name') ?> :</label></td>										
			
			<td class="row_format">											 
		    	<?php 
		    		  echo $this->Form->hidden('type',array('value'=>'receipts'));  
		    		 echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>
		 </tr>		 
		 <tr class="row_title">				 
			<td class="row_format" align="right"><label><?php echo __('Patient ID') ?> :</label></td>
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input('patient_id', array('type'=>'text','id' => 'patient_id', 'label'=> false, 'div' => false, 'error' => false));
		    	?>
		  	</td>
		 </tr>	
		 <tr class="row_title">				 
			<td class="row_format" align="right"><label><?php echo __('MRN') ?> :</label></td>
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input('admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false));
		    	?>
		  	</td>
		 </tr>	
		 <tr class="row_title">				 
			<td class="row_format" align="center" colspan="2">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
							
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" align="right" >
 		<tr>
 			<td>
	  			<?php  echo $this->Html->link(__('Add Patient'), array('action' => 'add',"?"=>$this->params->query), array('escape' => false,'class'=>'blueBtn')); ?>
	  		</td>
	  		<td>
	  			<?php	echo $this->Html->link(__('Generate Report'),html_entity_decode($this->Html->url(array("action" => "generateReport","?"=>$this->params->query),true)) , array('escape' => true,'class'=>'blueBtn')); ?>
		   	</td>
		   	<td>
    		<?php 							 
		   		echo $this->Html->link(__('Generate PDF Report'),html_entity_decode($this->Html->url(array('controller'=>'reports',"action" => "viewPdf","?"=>$this->params->query),true)), array('escape' => true,'class'=>'blueBtn'));
		   	?>
		   	</td>		   
		 </tr>
		</table>
		 
 <div class="clr inner_title" style="text-align:right;"></div>
 
 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
<?php if(isset($data) && !empty($data)){  ?>
			
				  
				  <tr class="row_title">
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.patient_id', __('Patient ID', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.admission_id', __('Registration ID', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.full_name', __('Patient Name', true)); ?></strong></td>
                                           <td class="table_cell"><strong><?php echo $this->Paginator->sort('Consultant.name', __(Configure::read('doctor'), true)); ?></strong></td>
                                           <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.create_time', __('Created Time', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>
					   
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
								   <td class="row_format"><?php echo $patients['Patient']['patient_id']; ?></td>
								   <td class="row_format"><?php echo $patients['Patient']['admission_id']; ?> </td>
								   <td class="row_format"><?php echo ucfirst($patients['Patient']['lookup_name']); ?> </td>
								   <td class="row_format"><?php echo $patients[0]['name']; ?> </td>						   
								   <td class="row_format"><?php 
								   		echo $this->DateFormat->formatDate2Local($patients['Patient']['create_time'],Configure::read('date_format'),true);
								   ?> </td>	   
								   <td ><?php 
								   		echo $this->Html->link($this->Html->image('icons/uerInfo.png',array('style'=>'height:20px;width:18px;')), array('action' => 'patient_information', $patients['Patient']['id']), array('escape' => false,'title'=>'Patient Info.'));
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
			/*$("#PatientSearchForm").click(function(){
			  $('input:text').each(function(){
			    alert($(this).text())
			  });
			}); */
			
			
		$('#PatientSearchForm').submit(function(){
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
    	 
			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name","null","null","null","admission_type=OPD", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","last_name","null","null","null","admission_type=OPD" ,"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#dob").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","dob","date","null","null","admission_type=OPD", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id","null","null","null","admission_type=OPD", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id","null","null","null","admission_type=OPD", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
	 	});
  </script>
 
				