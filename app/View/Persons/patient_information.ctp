<?php // debug($patient_details);
?>
 <style>
.row_action img{float:inherit;}
</style>
<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
									'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); ?>
<div class="inner_title" style="padding-bottom:20px;">
	<?php #pr($data);exit;
	
			$complete_name  = ucfirst($patient_details['Initial']['name'])." ".ucfirst($patient_details['Person']['first_name'])." ".ucfirst($patient_details['Person']['last_name']) ;
			//echo __('Set Appoinment For-')." ".$complete_name;
	?> 
	<h3>&nbsp; <?php echo __('Patient Registration Information -')." ".$complete_name ?></h3>
	<span > <?php echo $this->Html->link(__('Search Patient'),array('action' => 'searchPatient'), array('escape' => false,'class'=>'blueBtn')); ?>
	<?php //echo $this->Html->link(__('Back'),array(), array('escape' => false,'class'=>'blueBtn back')); ?>
	<input type="button" name="Back" value="Back" class="blueBtn goBack">
	</span>
	

</div> 
		 
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
	<?php } ?>
	<div class="inner_left">
    	 
	 		<div class="patient_info">
	    		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="patientHub">
	    			<tr>
		    			<td valign="top">
				    		<table width="100%" cellpadding="0" cellspacing="0" border="0"> 
				    		<?php if(!empty($patient_details['Person']['photo'])){ ?>
						    					<tr>
						    					
							    					<td width="100px" valign="top" align="center" rowspan="6" class="row_action">
							    						<?php echo $this->Html->image("/uploads/patient_images/thumbnail/".$patient_details['Person']['photo'], array('alt' => $complete_name,'title'=>$complete_name,'width'=>'100','height'=>'100')); ?>
							    					</td>
							 					</tr>
						 					<?php }else{ ?>
							 					<tr> 
							    					<td width="100px" valign="top" align="center" rowspan="6" class="row_action">
							    						<?php echo $this->Html->image("icons/male-thumb.gif", array('style'=>'border-radius:58px','alt' => $complete_name,'title'=>$complete_name)); ?>
							    					</td>
							 					</tr>
						 					<?php } ?> 
				    		</table>
		    			</td>
    					<td valign="top">
	    					<table width="100%" cellpadding="0" cellspacing="0" border="1" class="patientInfo">
			 					<tr>
									<td valign="top" align="right"><strong>Name :</strong></td><td valign="top" align="left"><?php echo $complete_name ;?></td>
									<td td valign="top" align="right" width="150">
								 		<strong><?php echo __('Sponsor Details :');?></strong>
								 	</td>
								 	<td valign="top" align="left">
								 	<?php echo $corpoName['Corporate']['name']." (".$patient_details['Person']['payment_category'].")";?>
								 	</td>
								</tr>
								<tr>
									<td valign="top" align="right"><strong>Sex/Age :</strong></td><td valign="top" align="left"><?php echo $patient_details['Person']['sex'].' '.$patient_details['Person']['age'];?></td>
									<td td valign="top" align="right" width="150">
								 		<strong><?php echo __('Referral Doctor :');?></strong>
								 	</td>
								 	<td valign="top" align="left">
								 	<?php foreach($consultantName as $cid=>$cname){?>
								 	<?php echo $cname['Consultant']['first_name']." ".$cname['Consultant']['last_name'].", ";?>	
								 	<?php }?>
								 	</td>
								</tr>	
								<tr>
									<td valign="top" align="right"><strong>Patient ID :</strong></td><td valign="top" align="left"><?php echo $patient_details['Person']['patient_uid'] ;?></td>
									<td td valign="top" align="right" width="150">
								 		<strong><?php echo __('Mobile Number :');?></strong>
								 	</td>
								 	<td valign="top" align="left">
								 	<?php echo $patient_details['Person']['mobile'];?>
								 	</td>
								</tr>				    
								<tr>				 
									<td valign="top" align="right" width="150">
										<strong>Address :</strong>
									</td>
									<td valign="top" align="left">
										<?php echo $formatted_address ;?>
								  	</td>
								  	<td valign="top" align="right" width="150">
										<strong>Admission ID :</strong>
									</td>
									<td valign="top" align="left">
										<?php foreach($data as $d){
											echo $d['Patient']['admission_id']." ";
										}?>
								  	</td>
								 </tr> 
							</table>
						</td>
	    				<td valign="top">
	    					<table width="100%" cellpadding="0" cellspacing="0" border="0">
	    						<?php if(file_exists(WWW_ROOT."uploads/qrcodes/".$patient_details['Person']['patient_uid'].".png")){ ?>
			    				<tr> 
			    					<td width="100" height="100" valign="top" align="center" rowspan="6" class="row_action">
			    						<?php echo $this->Html->image("/uploads/qrcodes/".$patient_details['Person']['patient_uid'].".png", array('alt' => $complete_name,'title'=>$complete_name,'style'=>'width:100px; border-radius:0px')); ?>
			    					</td>
			 					</tr>
			 					<?php  } ?>
			 				</table>
	    				</td>
	    			</tr>
	    		</table> 
			</div> 
			<div class="clr"></div>
			<div id="fun_btns">
				<table>	
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>
							<?php
								echo $this->Html->link(__('Edit Patient Registration Info.'),array("action"=>"edit","?"=>array('from'=>"patient_information") ,$id ),
								  
								    array('escape' => false,'class'=>'blueBtn'));
							?>
						</td> 
						<td>
							<?php
								echo $this->Html->link(__('Print Card'),
								     '#',
								     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'qr_card',$id))."', '_blank',
								           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
   							?>
						</td>					 
					</tr>
				</table>
			</div>
		</div>
		<div class="clr">
	</div>
	<div class="inner_left">
		<div class="inner_title"><BR>
			<h3>
				<span style="float:left;">
				<?php echo __('Previous Visit Details');?>
				
				</span>
				<span style="float:right;">
				<?php		
                                    //           echo $this->Html->link(__('New Encounter'), array('controller' => 'patients', 'action' => 'add', $id, 'submitandregister' => 1), array('escape' => false,'class'=>'blueBtn'));				 
					       //echo $this->Html->link(__('New Encounter') ,"/patients/add/".$id, 'submitandregister' => 1,array('class'=>'blueBtn','escape' => false)); 				
				
				?>
				<!--  <a href="#" id="pres" >Show BMI Growth Chart </a>-->
								
				<?php
				 
				/* if($patient_details['Person']['sex']=='Female')
				{
					
						echo $this->Html->link(__(''),'#',array('escape'=>false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'bmi_chart_temp',$id))."', '_blank',
											           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=800,left=200,top=200');  return false;"));
				}
				else 
				{
					echo $this->Html->link(__(''),'#',array('escape'=>false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'bmi_chart_temp1',$id))."', '_blank',
											           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=800,left=200,top=200');  return false;"));
				} */
				   		echo $this->Html->link(__('New Patient Registration'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
				?>
				</span> 
			</h3><div class="clr"></div>
		</div>		 
		<div class="UIDpatient_info">
			<div id="no_app" >
				<?php
					/* if(empty($data)){
						echo "<span class='error'>";
						echo __('No Record.');
						echo "</span>";
					} */
				?>		 	
			</div>		
			<?php if(!empty($data)){ ?>
				<table border="0" cellpadding="0" cellspacing="2" width="100%" style="text-align:center; margin-top:20px;">
				  
				  <tr class="row_title row_gray_dark">
				  		<?php if($this->Session->read('website.instance') == 'lifespring'){	?>
				       <td class="table_cell" align="left" style="p"><strong><?php echo  __('EDD', true); ?></strong></td>
				       <?php }?>
					   <td class="table_cell" align="left" style="p"><strong><?php echo /* $this->Paginator->sort('Patient.lookup_name', */ __('Patient Name', true)/* ) */; ?></strong></td>					
					   <td class="table_cell" align="left"><strong><?php echo  __('MRN number', true); ?></strong></td>
					   <td class="table_cell" align="left"><strong><?php echo  __('Phone', true); ?></strong></td>
					   <td class="table_cell" align="left"><strong><?php echo  __('Visit Date', true); ?></strong></td>
					   <td class="table_cell" align="left"><strong><?php echo  __(Configure::read('doctor')); ?></strong></td>		
					   <td class="table_cell" align="left"><strong><?php echo  __('Actions'); ?></strong></td>			   
				  </tr>
				  <?php 
				  	  $toggle =0;
				      $eddKey = $i = 0 ;	
				      if($this->Session->read('website.instance') == 'lifespring'){	
					      foreach($data as $key => $patientData){
								if($patientData['Patient']['expected_date_del'] == $data[$key-1]['Patient']['expected_date_del'] or $i == 0){
									$data[$eddKey]['EDDCount'] = (int) $data[$eddKey]['EDDCount'] + 1;
									$i++;
								}else{
									$eddKey = $key;
									$data[$eddKey]['EDDCount'] = (int) $data[$eddKey]['EDDCount'] + 1;
								}
							}
						}
				      		foreach($data as $key=>$patientData){
				         
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr class='row_gray_dark'>";
								       	$toggle = 0;
							       }
								  ?>
								  <?php if($patientData['EDDCount']){?>
								    <td align="left" class="tdLabel" id="boxSpace" rowspan="<?php echo $patientData['EDDCount'];?>">
								    <?php echo $this->DateFormat->formatDate2Local($patientData['Patient']['expected_date_del'],Configure::read('date_format'),true);?></td>										  
								  <?php }?>
								   <td width="200px">
								   		<table width="100%" cellspacing='2' cellpadding="0">
								   			<tr>
								   			 	<td align="left" style="padding: 0 0 0 3px;" class="tdLabel" id="boxSpace">
											   		<?php
											   		    echo ucwords($patientData['Patient']['lookup_name']); 
											   		?> 
											   	</td>
											 </tr>									 
																						 
								   		</table>
								   </td>		
								    <td align="left" class="tdLabel" id="boxSpace"><?php echo $patientData['Patient']['admission_id'];?></td>						  
								   <td align="left" class="tdLabel" id="boxSpace">
								   		<?php 
											echo $patient_details['Person']['mobile'];
											/* if(!empty($patient_details['Person']['person_local_number']) && !empty($patient_details['Person']['person_local_number_second']))
											echo ",";
											
											
												if(!empty($patient_details['Person']['person_country_code'])){
												  $phoneString = $patient_details['Person']['person_country_code'];
												}
												if(!empty($patient_details['Person']['person_city_code'])){
													if(!empty($phoneString))
												  		$phoneString .= '-'.$patient_details['Person']['person_city_code'];
													else
														$phoneString .= $patient_details['Person']['person_city_code'];
												}
												if(!empty($patient_details['Person']['person_local_number'])){
												  if(!empty($phoneString))
												  		$phoneString .= '-'.$patient_details['Person']['person_local_number'];
													else
														$phoneString .= $patient_details['Person']['person_local_number'];
												  
												}
												if(!empty($patient_details['Person']['person_extension'])){
												  if(!empty($phoneString))
												  		$phoneString .= '-'.$patient_details['Person']['person_extension'];
													else
														$phoneString .= $patient_details['Person']['person_extension'];
													
												}
										 		echo  $phoneString; */
																				 			 
										?>
								   </td>
								   <td align="left" style="padding: 0 0 0 3px;" class="tdLabel" id="boxSpace">
								 		<?php  
											echo $this->DateFormat->formatDate2Local($patientData['Patient']['form_received_on'],Configure::read('date_format'),true);
								 		?> 
								   </td>									   	   						   
								   <td align="left" style="padding: 0 0 0 3px;" class="tdLabel" id="boxSpace">
								 		<?php   echo $patientData[0]['name']; ?> 
								   </td>
											    
								   <td style="style="padding: 0 0 0 3px;"" class="inherit" width="10%">
								   <?php 
								   if($this->request->query['flag']=='1')
								   {
								   	 echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('alt'=>__('Edit'),'title'=>__('Edit'))), 
								   		 array('controller'=>'patients','action' => 'edit', $patientData['Patient']['id'], '?' =>"flag=1"), array('escape' => false,'title'=>'Edit'));
								   		
								   }else{
								   $countId=count($patientIDS);
								   if($countId==1){
								       $flag="UID";
								      }
								   echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('alt'=>__('Edit'),'title'=>__('Edit'))), 
								   		 array('controller'=>'patients','action' => 'edit', $patientData['Patient']['id'], '?' =>array('from'=>$flag)), array('escape' => false,'title'=>'Edit'));
								   		}?>		
								   		<?php 
								   		/* 	echo $this->Html->link($this->Html->image('icons/view-icon.png',array('alt'=>__('View'),'title'=>__('View'))), 
								   				 array('controller'=>'patients','action' => 'patient_information', $patientData['Patient']['id']), 
												array('escape' => false,'title'=>'View')); */


											/*echo $this->Html->link($this->Html->image('icons/view-icon.png',array('alt'=>__('View'),'title'=>__('View'))),
													array('controller'=>'PatientsTrackReports','action' => 'sbar', $patientData['Patient']['id']),
													array('escape' => false,'title'=>'View'));*/
 
								   		?>	
								   		<?php 
								   		//	echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('alt'=>__('Edit'),'title'=>__('Edit'))), 
								   		//		 array('controller'=>'patients','action' => 'edit', $patient_details['Patient']['id']), array('escape' => false,'title'=>'Edit'));
								   		?>								  
								   		<?php 								   			
								   			 echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('alt'=>__('Delete'),'title'=>__('Delete'))), 
								   			 	 array('controller'=>'patients','action' => 'delete', $patientData['Patient']['id'],$patient_details['Person']['id']), array('escape' => false,'title'=>'Delete'),"Are you sure you wish to delete this patient?");
								   		?>
								   		<?php
								   		if($this->Session->read('website.instance')=="vadodara"){
								   		if($patientData['Patient']['admission_type']=='IPD'){ 
									           echo $this->Html->link(__('Print Sheet'), '#',array('escape' => false,'class'=>'blueBtn','title'=>'Print Sheet',
                                                'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'patients','action'=>'opd_patient_detail_print',
                                                $patientData['Patient']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');  return false;"));
                                            }else{
									         echo $this->Html->link(__('Print Sheet'), '#',array('escape' => false,'class'=>'blueBtn','title'=>'Print Sheet',
											'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'patients','action'=>'opd_print_sheet',
													$patientData['Patient']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');  return false;"));
                                            	
                                            }
                                            }else{
									      	echo $this->Html->link(__('Print Sheet'), '#',array('escape' => false,'class'=>'blueBtn','title'=>'Print Sheet',
												'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'patients','action'=>'opd_patient_detail_print',
														$patientData['Patient']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');  return false;"));
										                                            	
                                            }
				   							?>
								   		
								  </td>
								  </tr>
					  <?php 		}  ?>
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
				 </table>
			<?php } ?>
		</div>
	</div>
	<script>
	var flag = "<?php echo $this->request->query['flag']=='1' ?>";
	$('#pres')
			.click(
					function() {
						//	var patient_id = $('#selectedPatient').val();
						
						$
								.fancybox({
									'width' : '70%',
									'height' : '90%',
									'autoScale' : true,
									'transitionIn' : 'fade',
									'transitionOut' : 'fade',
									'type' : 'iframe',
									'onComplete' : function() {
										$("#allergies").css({
											top : '20px',
											bottom : auto,
											position : absolute
										});
									},
									<?php if($patient_details['Person']['sex']=='Female' || $patient_details['Person']['sex']=='female')
									{?>
									'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_chart_female",$id)); ?>"
									<?php }
									else 
									{?>
									'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_chart_male",$id)); ?>"
									<?php }?>
								});

					});
	
	$(document).ready(function(){     
		$('.goBack').click(function(){ 

			if(flag == 1){
			window.location.href='<?php  echo $this->Html->url(array("controller" => 'Users', "action" => "doctor_dashboard", "admin" => false));?>';
			}else{  
			window.location.href='<?php  echo $this->Html->url(array("controller" => 'Persons', "action" => "searchPerson", "admin" => false));?>';
	       // parent.history.back();
	       //return false;  
	        }     
		       }); 
		});
	</script>
	