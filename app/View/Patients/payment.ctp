
<style>.row_action img{float:inherit;}</style><?php 
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
		<style>
	label{
		width:126px;
		padding:0px;
	}
</style>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('OPD Payment', true); ?></h3>
	<span></span>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Patient',array('action'=>'payment','type'=>'get'));?>	
<table border="0" class=" "  cellpadding="0" cellspacing="0" width="500px" align="center">
	<tbody>
					    			 				    
		<tr class="row_title">				 
			
			<td class=" " align="right" width="20%"><label><?php echo __('Patient Name') ?> :</label></td>										
			
			<td class=" ">											 
		    	<?php 
		    		 
		    		 echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>
		 			 
			<td class=" " align="right"><label><?php echo __('Patient ID') ?> :</label></td>
			<td class=" ">											 
		    	<?php 
		    		 echo    $this->Form->input('patient_id', array('type'=>'text','id' => 'patient_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
		    	?>
		  	</td>
		 			 
			<td class=" " align="right"><label><?php echo __('MRN') ?> :</label></td>
			<td class=" ">											 
		    	<?php 
		    		 echo    $this->Form->input('admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
		    	?>
		  	</td>
		 		 
			<td class=" " align="center" colspan="2">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
							
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
 <div class="clr inner_title" style="text-align:right;"></div>
 <?php 
 		//to generate receipt popup just after payment done by the patient.
		 
		if(isset($_GET['payment']) && !empty($_GET['id'])){
						
			echo "<script>var win = window.open('".$this->Html->url(array('action'=>'opd_payment_receipt_print',$_GET['id']))."', '_blank',
			           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); </script>"  ;
			
			?>
			<script>
			// this is sample code so replace
			// wurl = the url you want opened
			// wname = name given to the window so you can reference it again programmically
			// wfeatures = optionally you can give it scroll bars, make it resizeable, etc.
			//var win = window.open(wurl, wname, wfeatures);
			 
			/*if(win == null || typeof(win) == "undefined") {
			   alert("Please enabled popups for this site to continue.");  
			}else{
				//window.location='payment?type=OPD' ;
			}*/
			if (!win)
			    alert("Please enabled popups for this site to continue.");
			else {
				win.onload = function() {
			        setTimeout(function() {
			            if (win.screenX === 0) {
			                alert("Please enabled popups for this site to continue.");
			            } else {
			                // close the test window if popups are allowed.
			            	window.location='payment?type=OPD' ;  
			            }
			        }, 0);
			    };
			} 
			</script>
			<?php 
			
		}
 ?>
  
 
 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
<?php if(isset($data) && !empty($data)){  ?>
			
				  
				  <tr class="row_title">
					   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Patient.patient_id', __('Patient ID', true)); ?></strong></td>
					   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Patient.admission_id', __('Registration ID', true)); ?></strong></td>
					   <td class="table_cell" align="left"></td>
					   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Patient.full_name', __('Patient Name', true)); ?></strong></td>
                                           <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Consultant.name', __(Configure::read('doctor'), true)); ?></strong></td>
                                           <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Patient.create_time', __('Registration Date', true)); ?></strong></td>
                                           <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Patient.is_discharged', __('Status', true)); ?></strong></td>
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
								   <td class="row_format" align="left"><?php echo $patients['Patient']['patient_id']; //DEBUG($patients);EXIT; ?></td>
								   <td class="row_format" align="left"><?php echo $patients['Patient']['admission_id']; ?> </td>
								   <td class="row_format" align="left"><?php if(strtolower($patients['Patient']['sex'])=='male'){
																				echo $this->Html->image('/img/icons/male.png');
																				}else if(strtolower($patients['Patient']['sex'])=='female'){
																			echo $this->Html->image('/img/icons/female.png');
																		}  	?>
																	</td>
								   <td class="row_format" align="left"><?php echo $patients[0]['lookup_name']; ?> </td>
								   <td class="row_format" align="left"><?php echo $patients[0]['name']; ?> </td>						   
								   <td class="row_format" align="left"><?php
											echo $this->DateFormat->formatDate2Local($patients['Patient']['form_received_on'],Configure::read('date_format'),true);
								   			 ?> </td>
								   <td class="row_format"  align="left"><?php
								   echo ($patients['Patient']['is_discharge']==0)?'OP In-Progress':'OP Process Completed';
								   ?>	   
								   <td class="row_action" align="left"><?php 
								   		if($patients['Patient']['fee_status']=='paid'){
								   			echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'opd_payment_receipt_print',$patients['Patient']['id']))."', '_blank',
			           							'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print Receipt'));
								   		}else{
								   			if($patients['Patient']['is_discharge']==0){
								   				echo $this->Html->link($this->Html->image('icons/view-icon.png',array('style'=>'height:20px;width:18px;')), array('action' => 'opd_payment', $patients['Patient']['id']), array('escape' => false,'title'=>'View Payment Info'));
								   			}else{
								   				echo $this->Html->image('icons/view-icon.png',array('style'=>'height:20px;width:18px;padding:6px 5px;cursor:not-allowed;','disabled'=>'disabled'));
								   			}
								   		}
								   		//check for discharge 
								   		if($patients['Patient']['is_discharge']==0){
								   			echo $this->Html->link($this->Html->image('icons/red-bullet.png',array()), array('action' => 'opd_done', $patients['Patient']['id']), array('escape' => false,'title'=>'In-Progress'),__('Do you really want to complete OP Process'));
								   		}else{
								   			echo $this->Html->image('icons/green-bullet.png',array('title'=>__('Process Completed'),'style'=>'padding: 6px 5px;cursor:not-allowed;'));
								   		} 
								   		
								   		echo $this->Html->link($this->Html->image('icons/infobutton.png'),
								   				'#',
								   				array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>"billings",'action'=>'detail_payment',$patients['Patient']['id']))."', '_blank',
		          								 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=250,top=150,height=700');  return false;"));
								   		
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
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
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
    	 
			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name","null","null","null","admission_type=OPD", "admin" => false,"plugin"=>false)); ?>",{
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
 
				