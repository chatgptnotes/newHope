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
	<h3>&nbsp; <?php  echo __('Fax recipient selection', true); ?></h3>
	 <span style="float:right;margin: -24px 0; padding:0">
	
   <?php echo $this->Html->link(__('Preference Card'), array('controller' => 'patients', 'action' => 'patient_action',$patient_id), array('escape' => false,'class'=>'blueBtn'));
    ?>
	<?php 
    //echo $this->Html->link(__('Search OT Appointment'), array('controller' => 'OptAppointments', 'action' => 'search_otevent'), array('escape' => false,'class'=>'blueBtn'));
    ?>
	<?php 
    //echo $this->Html->link(__('OT Item Requisition'), array('controller' => 'opts', 'action' => 'ot_replace_list'), array('escape' => false,'class'=>'blueBtn'));
    ?>
	
  </span>
</div>
<div class="patient_info">
 <?php echo $this->element('patient_information');?>
</div>
<div class="clr">&nbsp;</div>
<style>
	label{
		width:126px;
		padding:0px;
	}
</style>
<?php 


echo $this->Form->create(null, array('url' => array('controller'=>'patients','action'=>'search'),'type'=>'get'));?>	
<table border="0" class=" "  cellpadding="0" cellspacing="0" width="500px" align="center">
	<tbody> 		    			 				    
		<tr class="row_title">				 
			
			<td class=" "><label><?php echo __('Recipient Name') ?> :</label></td>										
			
			<td class=" ">											 
		    	<?php 
		    		 echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>
		 		 
			<td class=" "><label><?php echo __('Recipient ID') ?> :</label></td>
			<td class=" ">											 
		    	<?php 
		    		 echo    $this->Form->input('patient_id', array('type'=>'text','id' => 'patient_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
		    	?>
		  	</td>
		 			 
			<td class=" "><label><?php echo __('MRN') ?> :</label></td>
			<td class=" ">											 
		    	<?php 
		    		 echo    $this->Form->input('admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
		    	?>
		  	</td>
		 		 
			<td class=" " align="right" colspan="2">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
							
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
  <div class="clr inner_title" style="text-align:right;"> </div>
	  		 
	 	
 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
<?php //if(isset($data) && !empty($data)){  ?>
			
				  
				  <tr class="row_title">
				  <td class="table_cell"><strong><?php echo __('Sr. No.'); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Recipient Name');//echo $this->Paginator->sort('Patient.patient_id', __('Patient ID', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php //echo $this->Paginator->sort('Person.first_name', __('Patient Name', true)); ?></strong></td>
                       <td class="table_cell"><strong><?php //echo $this->Paginator->sort('User.first_name', __(Configure::read('doctor'), true)); ?></strong></td>
                       <td class="table_cell"><strong><?php //echo $this->Paginator->sort('Patient.form_received_on', __('Registration Date', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Recipient Contact'); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>
					   
				  </tr>
				  <?php 
				  	  $toggle =0;
				    //  if(count($data) > 0) {
				      		//foreach($data as $patients){
				       
							      // if($toggle == 0) {
								      // 	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							      // }else{
								       	//echo "<tr>";
								       	$toggle = 0;
							     //  }
								  ?><tr>	<td class="row_format"><?php echo "1"; ?> </td>							  
								   <td class="row_format"><?php echo $this->Html->link(__('Steve Buckner'), array('controller' => 'patients', 'action' => 'referral_patient_action',$patient_id), array('escape' => false,'class'=>''));?></td>
								   <?php $patients['Patient']['patient_id']; ?></td>
								   <!--<td class="row_format"><?php echo $patients['Patient']['admission_id']; ?> </td>  -->
								   <td class="row_format"><?php ?> </td>
								   <td class="row_format"><?php  ?> </td>						   
								   <td class="row_format"><?php 
								    echo $this->DateFormat->formatDate2Local($patients['Patient']['form_received_on'],Configure::read('date_format'),true); 
								   ?> </td>	
								   <td align="left"><?php 
								   		echo "1(415)555-8728";
								   ?>
								  </td>   
								   <td align="center"><?php 
								   		echo $this->Html->link($this->Html->image('icons/uerInfo.png',array('style'=>'height:20px;width:18px;')), array('action' => 'referral_patient_action', $patient_id), array('escape' => false));
								   ?>
								  </td>
								  </tr>
					  <?php //} 
					 			//set get variables to pagination url
					  			//$this->Paginator->options(array('url' =>array("?"=>$this->params->query))); 
					   ?>
					   <tr>
					    <TD colspan="8" align="center">
					    <!-- Shows the page numbers -->
					 <?php //echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
					 <!-- Shows the next and previous links -->
					 <?php //echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
					 <?php //echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
					 <!-- prints X of Y, where X is current page and Y is number of pages -->
					 <span class="paginator_links"><?php //echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
					    </TD>
					   </tr>
			<?php //} ?> <?php					  
			     // } else {
			 ?>
			  <tr>
			   <TD colspan="8" align="center"><?php //echo __('No record found', true); ?>.</TD>
			  </tr>
			  <?php
			     // }
			  ?>
		  
		 </table>
		 <div class="inner_title">
<h3><?php echo __('', true); ?></h3>
<span>
<?php
//echo $this->Html->link(__('View Preference Card', true),array('action' => 'view_preference',$patient_id,$getData['Preferencecard']['patient_id']), array('escape' => false,'class'=>'blueBtn'));
 //echo $this->Html->link(__('Add Preference Card', true),array('action' => 'add',$patient_id), array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Add multiple recipients'), array('controller'=>'patients','action' => 'referral',$patient_id), array('escape' => false,'class'=>"blueBtn"));
 echo $this->Html->link(__('Add new recipients'), array('controller'=>'patients','action' => 'referral',$patient_id), array('escape' => false,'class'=>"blueBtn"));
 ?>
</span>
</div>
 	
 
		 
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
    	 
			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","last_name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#dob").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","dob","date", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
	 	});
  </script>
 
				