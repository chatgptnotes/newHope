<?php
  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
        	<h3><?php echo __('Investigation')?></h3>
</div>
 
<!-- form elements start-->
<?php
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
<?php } 

	if(isset($this->request->query)){
		$getData =  $this->request->query ; 
		$fromDate = isset($getData['from'])?$getData['from']:''; 
		$toDate = isset($getData['to'])?$getData['to']:'';
		$lookupName = isset($getData['from'])?$getData['lookup_name']:'';
		$patientId = isset($getData['patient_id'])?$getData['patient_id']:'';
		$admissionId = isset($getData['admission_id'])?$getData['admission_id']:'';
		$labTestName = isset($getData['lab_test_name'])?$getData['lab_test_name']:'';
		$radiologyTestName = isset($getData['radiology_test_name'])?$getData['radiology_test_name']:'';
		$histologyTestName = isset($getData['histology_test_name'])?$getData['histology_test_name']:'';
		
	}
?>
<div id="search-filter">
	<?php echo $this->Form->create('Radiology',array('id'=>'patient-search','action'=>'radiology_manager','type'=>'get','inputDefaults'=>array('label'=> false, 'div' => false, 'error' => false)));?>
	<table border="0" class=" " cellpadding="0" cellspacing="0"
		width="500px" align="center">
		<tbody>
			<tr class="row_title">
			<td class=" " align="right"><label><?php echo __('DOB') ?> :</label></td>
			<td class=" " >											 
		    	<?php 
		    		 echo    $this->Form->input('Person.dob', array('type'=>'text','class' =>'textBoxExpnd','id' => 'dob_search', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:130px','readonly'=>'readonly'));
		    	?>
		  	</td>	
			<td class=" " align="right"><label><?php echo __('SSN') ?> :</label></td>
			<td class=" " >											 
		    	<?php 
		    		 echo    $this->Form->input('Person.ssn_us', array('type'=>'text','class' =>'textBoxExpnd','id' => 'ssn_us_search', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:130px'));
		    	?>
		  	</td>	
				<td class=" " align="right" width="20%"><label><?php echo __('Patient Name') ?>
						:</label></td>
				<td class=" "><?php 
				echo    $this->Form->input('lookup_name', array('value'=>$lookupName,'id' => 'lookup_name', 'label'=> false ,'autocomplete'=>false));
				?>
				</td>
				<td class=" " align="right"><label><?php echo __('Patient ID') ?> :</label>
				</td>
				<td class=" "><?php 
				echo    $this->Form->input('patient_id', array('value'=>$patientId,'type'=>'text','id' => 'patient_id' ));
				?>
				</td>
				<td class=" " align="right"><label><?php echo __('MRN') ?>
						:</label></td>
				<td class=" "><?php 
				echo    $this->Form->input('admission_id', array('value'=>$admissionId,'type'=>'text','id' => 'admission_id' ));
				?>
				
				<td class=" " align="center"><?php
				echo $this->Form->submit(__('Search'),array('class'=>'blueBtn' ,'label'=>false,'div'=>false,'error'=>false));
					
				?></td>
		
		</tbody>
	</table>



	<!--  <table border="0" class=""  cellpadding="0" cellspacing="0" width="100%" >
		<tbody>
			<tr>
				<td width="50%" valign="top"> 
					<table border="0" class=" "  cellpadding="0" cellspacing="0" width="100%" >
						<tr class="row_title"> 
							<td class="row_format"><label><?php echo __('From') ?> :</label></td> 
							<td class="row_format">											 
						    	<?php 
						    		 echo    $this->Form->input('from', array('value'=>$fromDate,'id' => 'from-date', 'autocomplete'=>false));
						    	?>
						  	</td>
						 </tr>
						<tr class="row_title"> 
							<td class="row_format"><label><?php echo __('Patient Name') ?> :</label></td> 
							<td class="row_format">											 
						    	<?php 
						    		 echo    $this->Form->input('lookup_name', array('value'=>$lookupName,'id' => 'lookup_name', 'label'=> false ,'autocomplete'=>false));
						    	?>
						  	</td>
						 </tr> 
						 <tr class="row_title">				 
							<td class="row_format"><label><?php echo __('MRN') ?> :</label></td>
							<td class="row_format">											 
						    	<?php 
						    		 echo    $this->Form->input('admission_id', array('value'=>$admissionId,'type'=>'text','id' => 'admission_id' ));
						    	?>
						  	</td>
						 </tr>	
						  
					</table>
				</td>
				<td width="50%" valign="top">
					<table border="0" class=" "  cellpadding="0" cellspacing="0" width="100%" >
						<tr class="row_title"> 
							<td class="row_format"><label><?php echo __('To') ?> :</label></td> 
							<td class="row_format">											 
						    	<?php 
						    		 echo    $this->Form->input('to', array('value'=>$toDate,'id' => 'to-date' ,'autocomplete'=>false));
						    	?>
						  	</td>
						 </tr>	
						 						 	 
						 <tr class="row_title">				 
							<td class="row_format"><label><?php echo __('Radiology Test Name') ?> :</label></td>
							<td class="row_format">											 
						    	<?php 
						    		 echo    $this->Form->input('radiology_test_name', array('value'=>$radiologyTestName,'type'=>'text','id' => 'radiology_test_name' , 'error' => false));
						    	?>
						  	</td>
						 </tr>	
						  <tr class="row_title">				 
							<td class="row_format"><label><?php echo __('Patient ID') ?> :</label></td>
							<td class="row_format">											 
						    	<?php 
						    		 echo    $this->Form->input('patient_id', array('value'=>$patientId,'type'=>'text','id' => 'patient_id' ));
						    	?>
						  	</td>
						 </tr>	
						 <tr class="row_title">				 
							<td class="row_format" align="right" colspan="2">
								<?php
									echo $this->Form->submit(__('Search'),array('class'=>'blueBtn' ,'label'=>false,'div'=>false,'error'=>false));
									echo $this->Form->button(__('Reset'),array('type'=>'button','class'=>'blueBtn','id'=>'reset-form'));
									echo $this->Html->link(__('Back'),array('action'=>'index'),array('escape'=>false,'class'=>'blueBtn','id'=>'reset-form'));	
								?>
							</td> 
						 </tr>
						 
					</table>
				</td>
			</tr>					
		</tbody>	
	</table>-->
	<?php echo $this->Form->end();?>
</div>
 <div align="center" id = 'temp-busy-indicator' style="display:none;">	
		&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
 </div>
 <div id="test-order" ></div>
 <div style="text-align: right;" class="clr inner_title"></div>	 
 	      
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
<?php 
	 
if(isset($data) && !empty($data)){  ?>
			
				  
				  <tr class="row_title">
				   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Person.discharge_date', __('DOB', true)); ?></strong></td>
				   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Person.ssn_us', __('SSN', true)); ?></strong></td>
				  <td class="table_cell"></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.full_name', __('Patient Name', true)); ?></strong></td>
				  
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.patient_id', __('Patient ID', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.admission_id', __('Registration ID', true)); ?></strong></td><!--
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTestOrder.order_id', __('Order ID', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Radiology.name', __('Test', true)); ?></strong></td>
					   -->
					                          <td class="table_cell"><strong><?php echo $this->Paginator->sort('Consultant.name', __(Configure::read('doctor'), true)); ?></strong></td>
					                          <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.patient_id', __('Department', true)); ?></strong></td>
                       <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTestOrder.create_time', __('Ordered On', true)); ?></strong></td><!--
					   <td class="table_cell"><strong><?php echo  __('Test Done'); ?></strong></td>
					   --><td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>
					   
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
								  <td class="row_format"><?php echo substr($this->DateFormat->formatDate2Local($patients['Person']['dob'],Configure::read('date_format'),true),0,10); ?> </td>
									<td class="row_format"><?php echo $patients['Person']['ssn_us']; ?></td>	
									 <td class="row_format" align="left"><?php if(strtolower($patients['Patient']['sex'])=='male'){
																				echo $this->Html->image('/img/icons/male.png');
																				}else if(strtolower($patients['Patient']['sex'])=='female'){
																			echo $this->Html->image('/img/icons/female.png');
																		}  	?>
																	</td>
								   
								   
								   <td class="row_format"><?php echo $patients['PatientInitial']['name'].' '.$patients['Patient']['lookup_name']; ?> </td>
												  
								   <td class="row_format"><?php echo $patients['Patient']['patient_id']; ?></td>
								   <td class="row_format"><?php echo $patients['Patient']['admission_id']; ?> </td><!--
								   <td class="row_format"><?php echo $patients['RadiologyTestOrder']['order_id']; ?></td>
								   <td class="row_format"><?php echo $patients['Radiology']['name']; ?> </td>
								   -->
								  								   <td class="row_format"><?php echo $patients['Initial']['name']." ".$patients[0]['name']; ?> </td>
								  								   <td class="row_format"><?php echo $patients['Department']['name']; ?> </td>							   
								   <td class="row_format"><?php    
								   	echo $this->DateFormat->formatDate2Local($patients['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true);
								   ?> </td><!--
								   <td class="row_format">
								   		<?php  
								   			if($patients['RadiologyTestOrder']['test_done']=='true'){
								   				$checked = 'checked';
								   			}else{
								   				$checked = '';
								   			}
								   			echo $this->Form->input('test_done',array('id'=>'test_done','checked'=>$checked,'type'=>'checkbox','onclick'=>'redirectTo('.$patients['RadiologyTestOrder']['id'].')'));
								   		?>
								   </td>	   
								   --><td><?php 
								   		//echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'patient_information', $patients['Patient']['id']), array('escape' => false));
								   ?>
								   <?php	 
								   		echo $this->Html->link($this->Html->image('icons/view-icon.png'),array('action'=>'radiology_test_list',$patients['Patient']['id'],'?'=>array('return'=>'radiologies')),array('escape'=>false));
									 ?>
								  </td>
								  </tr>
					  <?php } 
					  			echo $this->Js->writeBuffer();
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

	function redirectTo(id){
		if(id!=''){ 
			window.location.href = '<?php echo $this->Html->url(array('action'=>'radiology_test_done'));?>'+"/"+id+"/"+$('#test_done').is(':checked') ;
		}
	}
	
	$(document).ready(function(){
  	 
			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			}); 
					 		
			$( "#lookup_name" ).bind( "autocompleteselect", function(event, ui) {
				  alert('sm here');
				});
			$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			 


			
			/*$('#lookup_name,#patient_id,#admission_id').keyup(function(){
				$("#lab_test_name,#radiology_test_name,#histology_test_name").attr('disabled','disabled');
			}); 
			$('#lab_test_name,#radiology_test_name,#histology_test_name').keyup(function(){
				$("#lookup_name,#patient_id,#admission_id").attr('disabled','disabled');
			});*/
			 	
			$("#lab_test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Laboratory","name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});			 			 
			$("#radiology_test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Radiology","name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#histology_test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Histology","name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});

			$('#reset-form').click(function(){
				$('#patient-search')[0].reset(); 
				document.getElementById('patient-search').reset();
				//$("#lab_test_name,#radiology_test_name,#histology_test_name,#lookup_name,#patient_id,#admission_id").attr('disabled','disabled');
			});

			$('#view-order-form').click(function(){
					$('#search-filter').fadeOut('slow');
					$('#flashMessage').remove();
			});
				
			
	 	});
	
	//script to include datepicker
		$(function() {	
			$( "#to-date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate();?>'
			});
			$( "#from-date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate();?>'
			});
		});       
		$(function() {
			$("#dob_search").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>', 
		});
		});                

</script>	    
                       