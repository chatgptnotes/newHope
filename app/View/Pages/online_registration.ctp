<?php
     echo $this->Html->script(array('jquery.autocomplete'));   
	 echo $this->Html->script(array('jquery.fancybox-1.3.4'));
	 echo $this->Html->css('jquery.autocomplete.css');
     echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>
     
<style>
select.textBoxExpnd {
    width:66% !important;
	margin-top:5px;
}
select.textBoxExpnd1{width:70%!important; margin-top:5px;}

</style>
<div class="inner_title">
	<h1>&nbsp; <?php echo __('Online Registration', true); ?></h1>
</div>
<?php echo $this->Form->create('Person',array('type' => 'file','name'=>'register','id'=>'personfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); 
	echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));
?>

<?php if(!empty($errors)) { ?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
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
			<?php //BOF new form design ?>
			<!-- form start here -->
                   <div class="clr"></div>
				  
                   <!-- Patient Information start here -->
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5"><?php echo __("UID Patient Information") ; ?></th>
                      </tr>
                      <tr>
                        <td width="17%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("First Name");?><font color="red">*</font></td>
                        <td width="27%"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          	<td><?php echo $this->Form->input('initial_id', array('empty'=>__('Select'),'options'=>$initials,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'initials','style'=>'width:80px')); ?></td>
                            <td>                            	 
                            	<?php echo $this->Form->input('first_name', array('style'=>'width:48%!important;','class' => 'validate[required,custom[name],custom[onlyLetterSp]] textBoxExpnd','id' => 'first_name','autocomplete'=>'off')); ?>
                            </td>                           
                          </tr>
                        </table></td>
                         
						 <td valign="middle" class="tdLabel" id="boxSpace" width="19%"><?php echo __('Last Name');?><font color="red">*</font></td>
                        <td width="26%">
                        	<?php echo $this->Form->input('last_name', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterSp]] textBoxExpnd','id' => 'last_name','autocomplete'=>'off')); ?>
                        </td> 
                      </tr>
                      <tr>                       
							<td class="tdLabel" id="boxSpace"><?php echo __('Date of Birth');?></td>
							<td>
								<?php 
									echo $this->Form->input('dob', array('type'=>'text','style'=>'width:126px','readonly'=>'readonly','size'=>'20','class' => 'textBoxExpnd','id' => 'dob'));
									echo "&nbsp;&nbsp;&nbsp;Age";
									echo '<font color="red">*</font>';
									echo $this->Form->input('age', array('type'=>'text','style'=>'width:45px','maxLength'=>'3','size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] ','id' => 'age'));
								?>
							</td>
							
							<td class="tdLabel" id="boxSpace"><?php echo __('Sex');?><font color="red">*</font></td>
							<td >
								<?php  
									echo $this->Form->input('sex', array('options'=>array(""=>__('Please Select Sex'),"male"=>__('Male'),'female'=>__('Female')),'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'sex')); ?>
							</td> 
                      </tr>            
                     <tr>
                       <td class="tdLabel" id="boxSpace">Patient's Photo</td>
                       <td>
                       		<?php 
                       			echo $this->Form->input('upload_image', array('type'=>'file','id' => 'patient_photo', 'class'=>"",'style'=>'float:left','label'=> false,
					 				'div' => false, 'error' => false));
                       			
								echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera','title'=>'Capture photo from webcam'));
                       ?>
                       <canvas width="320" height="240" id="parent_canvas" style="display:none;"></canvas>
                        
                       </td>
                        <td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Passport No/ID');?></td>
                        <td>
                        	<?php echo $this->Form->input('passport_no', array('class' => 'textBoxExpnd','id' => 'passport_no')); ?>
                        </td>
                       <!-- <td class="tdLabel" id="boxSpace"> <?php echo __('UIDDate'); ?> <font color="red">*</font></td>
                       <td>
                       		<?php
                       			                      			 
                       			echo $this->Form->input('uiddate', array('class' => 'textBoxExpnd','type'=>'text','id' => 'uiddate')); ?>
                       </td>-->
                     </tr>
                      <tr>
                       <td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Blood Group');?></td>
                       <td><?php 
                       		$blood_group = array("A+"=>"A+","A-"=>"A-","B+"=>"B+","B-"=>"B-","AB+"=>"AB+","AB-"=>"AB-","O+"=>"O+","O-"=>"O-");
                       		echo $this->Form->input('blood_group', array('empty'=>__('Please Select'),'options'=>$blood_group,'class' => 'textBoxExpnd','id' => 'designation','style'=>'width:66%!important;')); ?></td>
                      
                       <td valign="top" class="tdLabel" id="boxSpace"><?php echo __('Allergies');?> </td>
                       <td><?php echo $this->Form->textarea('allergies', array('class' => 'textBoxExpnd','id' => 'allergies','row'=>'3')); ?></td>
                       <!-- <td class="tdLabel" id="boxSpace"> <?php echo __('UIDDate'); ?> <font color="red">*</font></td>
                       <td>
                       		<?php
                       			                      			 
                       			echo $this->Form->input('uiddate', array('class' => 'textBoxExpnd','type'=>'text','id' => 'uiddate')); ?>
                       </td>-->
                     </tr>
                  	<tr>
                     	   <!-- <td class="tdLabel " id="boxSpace" valign="top" >Referral Doctor</td>
                        <td>
                         <?php //echo $this->Form->input('known_fam_physician', array('class' => 'textBoxExpnd','id' => 'knownPhysician'));
						 
                              echo $this->Form->input('known_fam_physician', array('empty'=>__('Please Select'), 'id'=>'familyknowndoctor','class'=>'textBoxExpnd','style'=>'width:66%!important;','options'=>$reffererdoctors,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'getDoctorsList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    						 'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeDoctorsList', 'data' => '{familyknowndoctor:$("#familyknowndoctor").val()}', 'dataExpression' => true, 'div'=>false))));
                          ?>

                          <div id="changeDoctorsList">	                        
	                      </div>
                          </td> -->
                   		
                           <td valign="middle" class="tdLabel" id="boxSpace">Family Physician Contact No.</td>
                        <td>
                        	<?php echo $this->Form->input('family_phy_con_no', array('class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'phyContactNo','MaxLength'=>'10')); ?>                        
                        </td>
                        <td valign="middle" class="tdLabel" id="boxSpace">Instructions</td>
                        <td>
                        	<?php
                                 $instructions = array('Diabetic'=>'Diabetic- If found Unconscious give sugar/sweet/chocolate.','Epileptic'=>'Epileptic- In case of attack/fit turn patient to one side & refrain from feeding.','High Blood Pressure'=>'High Blood Pressure- If found unconscious or paralyzed, turn patient to one side & refrain from feeding.','Low Blood Pressure'=>'Low Blood Pressure- In case of vertigo keep head in low position & take plenty of fluids.','Cardiac Problem'=>'Cardiac Problem- In case of symtoms like chest pain or sweating administer Tablet Disprin & sublingual Tablet Sorbitrate.','Asthma'=>'Asthma- In case of acute attack administer 2 puffs of Scroflo inhaler & shift to hospital.');

                        	 //$instructions = array('Diabetic'=>'Diabetic','Epileptic'=>'Epileptic','High Blood Pressure'=>'High Blood Pressure','Low Blood Pressure'=>'Low Blood Pressure','Prone to Angina Attacks'=>'Prone to Angina Attacks','Austistic'=>'Austistic');
                        	 echo $this->Form->input('instruction', array('empty'=>__('Please Select'),
                        								  'options'=>$instructions,'class' => 'textBoxExpnd','style'=>'width:66%!important;','id' => 'instructions')); ?>
                        	</td>  
                     </tr> 
                     <tr>
                        <td class="tdLabel" id="boxSpace">Relatives Name</td>
                       	<td><?php echo $this->Form->input('relative_name', array('class' => 'textBoxExpnd','id' => 'relativeName')); ?></td>
                        
                        <td valign="middle" class="tdLabel" id="boxSpace">Relative Phone No.</td>
                        <td>
                        	<?php echo $this->Form->input('relative_phone', array('class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'mobilePhone','MaxLength'=>'10')); ?>
                        </td> 
                     </tr>
                   
                     <!-- <tr>
                       <td valign="middle" class="tdLabel" id="boxSpace">&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td class="tdLabel" id="boxSpace"> <?php echo  __('Secondary Email') ;?></td>
                       <td><?php echo $this->Form->input('secondary_email', array('class' => 'validate["",custom[email]]  textBoxExpnd','id' => 'secondaryEmail')); ?></td>
                     </tr>-->
                     
                    </table>
                    <!-- Patient Information end here --> 
					<p class="ht5"></p>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	                   	  	<tr>
		                      	<th colspan="5"><?php echo __('Sponsor Information');?></th>
		                    </tr>
		                    <tr>
		                        <td width="7%" class="tdLabel"  id="boxSpace" valign="top">Sponsor Details</td>
		                         <td width="30%" align="left"><?php echo $this->Form->input('payment_category', array('class' => 'textBoxExpnd','style'=>'width:240px!important;','id' => 'paymentType','Value'=>'Self Pay','disabled'=>true)); ?></td>
		                    </tr>
		                       <!-- <td  width="30%" align="left">
	                                
	                                 <?php 
	                       			$paymentCategory = array('cash'=>'Self Pay','card'=>'Card');
	                       			echo $this->Form->input('payment_category', array('empty'=>__('Please Select'),'options'=>$paymentCategory,'autocomplete'=>'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'paymentType','onchange'=> $this->Js->request(array('action' => 'getPaymentType'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
	    								'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{paymentType:$("#paymentType").val()}', 'dataExpression' => true, 'div'=>false)))); 
	                       		?>
	                                 <span id="changeCreditTypeList">
	                                 </span>
	                                </td>
		                        	<td width="">&nbsp;</td>
		                        	<td width="">&nbsp;</td>
		                        	<td width="">&nbsp;</td>
		                        	
	                                <!-- <td valign="top"><?php echo __('Insurance Number');?></td>
	                                <td valign="top"><?php echo $this->Form->input('insurance_number', array('class' => 'textBoxExpnd','id' => 'insurance_number')); ?></td>
	                                
		                     </tr>  
		                     <tr id="showwithcard" style="display:none;">
	                            <td width="100%" colspan="5" align="left" class=""  id=" ">
	                                 <table border="0" cellpadding="0" cellspacing="0" width="100%" >
									    <tr>
											<td  width="19%" class="tdLabel"  id="boxSpace"><?php echo __('Name of the I.P.');?> </td>
											<td width="30%" align="left">
													<?php echo $this->Form->input('name_of_ip', array('class' => 'textBoxExpnd','id' => 'name_of_ip')); ?>
											</td> 
											<td width="">&nbsp;</td>
											<td valign="middle" class="tdLabel" id="boxSpace" width="19%"><?php echo __('Relationship with Employee');?> </td>
											<td align="left" width="30%">
													<?php
														 $relation = array('Self'=>'Self','Father'=>'Father','Mother'=>'Mother','Brother'=>'Brother','Sister'=>'Sister','Wife' => 'Wife','Husband'=>'Husband','Son' => 'Son', 'Daughter' => 'Daughter','OTHER'=>'other');
														 echo $this->Form->input('relation_to_employee', array('empty'=>__('Please Select'),'options'=>$relation,'class' => 'textBoxExpnd','id' => 'insurance_relation_to_employee')); ?>
											</td>
				                      </tr> 
				                      <tr>
				                       
				                       <td  width="19%" class="tdLabel"  id="boxSpace"><?php echo __('Executive Employee ID No.');?> </td>
											<td width="30%" align="left">
													<?php echo $this->Form->input('executive_emp_id_no', array('class' => 'textBoxExpnd emp_id','id' => 'insurance_executive_emp_id_no')); ?>
											</td>
				                        <td>&nbsp;</td>
				                        <td class="tdLabel"  id="boxSpace"><?php echo __('Non Executive Employee ID No.');?> </td>
				                        <td align="left">
				                       			<?php echo $this->Form->input('non_executive_emp_id_no', array('style'=>'width:180px','class' => 'textBoxExpnd emp_id','id' => 'insurance_non_executive_emp_id_no')); ?>
				                       			<?php echo $this->Form->input('suffix', array('style'=>'width:48px','class' => 'textBoxExpnd emp_id','id' => 'insurance_esi_suffix', 'readonly' => 'readonly')); ?>
				                    	</td>
				                      </tr> 
				                      <tr>
				                        <td class="tdLabel"  id="boxSpace" align="left"><?php echo __('Designation');?> </td>
				                        <td align="left">
				                       			<?php echo $this->Form->input('designation', array('class' => 'textBoxExpnd','id' => 'designation')); ?>
				                    	</td>
				                        <td>&nbsp;</td>
				                        <td class="tdLabel"  id="boxSpace" align="left"><?php echo __('Company');?> </td>
					                        <td align="left">
					                       		<?php echo $this->Form->input('sponsor_company', array('class' => 'textBoxExpnd','id' => 'sponsor_company')); ?> 
					                    </td> 
				                      </tr>
				                      
				                       <tr>
				                        <td class="tdLabel"  id="boxSpace" align="left"><?php echo __('Sanction ID No.');?> </td>
				                        <td align="left">
				                       			<?php echo $this->Form->input('sanction_no', array('class' => 'textBoxExpnd','id' => 'sanction_no')); ?>
				                    	</td>
				                        <td>&nbsp;</td>
				                        <td class="tdLabel"  id="boxSpace" align="left"><?php echo __('Main Member UHID No.');?> </td>
					                        <td align="left">
					                       		<?php echo $this->Form->input('member_uhid_no', array('class' => 'textBoxExpnd','id' => 'member_uhid_no')); ?> 
					                    </td> 
				                      </tr>  
				                      
				                      <tr>
				                        <td class="tdLabel"  id="boxSpace" align="left"><?php echo __('Unit Name.');?> </td>
				                        <td align="left">
				                       			<?php echo $this->Form->input('unit_name', array('class' => 'textBoxExpnd','id' => 'unit_name')); ?>
				                    	</td>
				                    	 <td>&nbsp;</td>
				                        <td class="tdLabel"  id="boxSpace" align="left"><?php echo __('ECHS Card No.');?> </td>
					                        <td align="left">
					                       		<?php echo $this->Form->input('echs_card_no', array('class' => 'textBoxExpnd','id' => 'echs_card_no')); ?> 
					                    </td> 
				                        
				                      </tr> 
				                      <tr>
				                        <td class="tdLabel"  id="boxSpace" align="left"><?php echo __('FCI Card No.');?> </td>
				                        <td align="left">
				                       			<?php echo $this->Form->input('fci_card_no', array('class' => 'textBoxExpnd','id' => 'fci_card_no')); ?>
				                    	</td>

				                      </tr>
	                     			</table>
	                     		</td>
	                    	 </tr>
	                    	 <tr id="showwithcardInsurance" style="display:none;">
	                            <td width="100%" colspan="5" align="left" class=""  id=" ">
	                                 <table border="0" cellpadding="0" cellspacing="0" width="100%" >
									    <tr>
											<td  width="19%" class="tdLabel"  id="boxSpace"><?php echo __('Name of Insurance Holder');?> </td>
											<td width="30%" align="left">
													<?php echo $this->Form->input('name_of_ip', array('class' => 'textBoxExpnd','id' => 'name_of_ip')); ?>
											</td> 
											<td width="">&nbsp;</td>
											<td valign="middle" class="tdLabel" id="boxSpace" width="19%"><?php echo __('Relationship with Insurance Holder');?> </td>
											<td align="left" width="30%">
													<?php
														 $relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
														 echo $this->Form->input('relation_to_employee', array('empty'=>__('Please Select'),'options'=>$relation,'class' => 'textBoxExpnd','id' => 'corpo_relation_to_employee')); ?>
											</td>
				                      </tr> 
				                      <tr>
					                        <td class="tdLabel"  id="boxSpace"><?php echo __('Insurance Number');?> </td>
					                        <td align="left">
					                       		<?php echo $this->Form->input('insurance_number', array('class' => 'textBoxExpnd','id' => 'insurance_number')); ?>
					                    	</td> 
				                    	 	<td>&nbsp;</td>
					                        <td class="tdLabel"  id="boxSpace" align="left"><?php echo __('Designation');?> </td>
					                        <td align="left">
					                       			<?php echo $this->Form->input('designation', array('class' => 'textBoxExpnd','id' => 'designation')); ?> 
					                    	</td> 
				                      </tr> 
				                      <tr> 
					                       <td  width="19%" class="tdLabel"  id="boxSpace"><?php echo __('Executive Employee ID No.');?> </td>
												<td width="30%" align="left">
														<?php echo $this->Form->input('executive_emp_id_no', array('class' => 'textBoxExpnd emp_id','id' => 'corpo_executive_emp_id_no')); ?>
												</td>
					                        <td>&nbsp;</td>
					                        <td class="tdLabel"  id="boxSpace"><?php echo __('Non Executive Employee ID No.');?> </td>
					                        <td align="left">
					                       			<?php echo $this->Form->input('non_executive_emp_id_no', array('style'=>'width:180px','class' => 'textBoxExpnd emp_id','id' => 'corpo_non_executive_emp_id_no')); ?>
					                       			<?php echo $this->Form->input('suffix', array('style'=>'width:60px','class' => 'textBoxExpnd emp_id','id' => 'corpo_esi_suffix', 'readonly' => 'readonly')); ?>
					                    	</td>
				                      </tr>   
				                      <tr>
				                      	    <td class="tdLabel"  id="boxSpace" align="left"><?php echo __('Company');?> </td>
					                        <td align="left">
					                       			<?php echo $this->Form->input('sponsor_company', array('class' => 'textBoxExpnd','id' => 'sponsor_company')); ?> 
					                    	</td> 
					                        <td class="tdLabel"  id="boxSpace" align="left">&nbsp;</td>
					                        <td align="left">&nbsp;</td>
					                        <td>&nbsp;</td> 
				                      </tr> 
	                     			</table>
	                     		</td>
	                    	 </tr> -->
	                </table>
	                <p class="ht5"></p>
	                <!-- Sponcer Details ends here -->
	                 <p class="ht5"></p>
                    
                    <!-- Links to Records start here -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">Links to Records</th>
                      </tr>
                      <tr>
                        <td width="19%" class="tdLabel" id="boxSpace">Case summary Link</td>
                        <td width="81%"><?php 
							if(empty($this->data['Person']['case_summery_link'])){
								$case_summery_link = $recordLink['Location']['case_summery_link'] ;
							}
                        	echo $this->Form->input('case_summery_link', array('value'=>$case_summery_link,'class' => 'textBoxExpnd','style'=>'width:240px!important;','id' => 'caseSummeryLink')); ?></td>
                      </tr>
                      <tr>
                        <td class="tdLabel" id="boxSpace">Patient File</td>
                        <td><?php
                        	if(empty($this->data['Person']['patient_file'])){
								$patient_file = $recordLink['Location']['patient_file'] ;  
							}
                        	 echo $this->Form->input('patient_file', array('style'=>'width:240px!important;','class' => 'textBoxExpnd','id' => 'patientFile','value'=>$patient_file)); ?></td>  
                      </tr> 
                    </table>
                    <!-- Links to Records end here -->
                    <p class="ht5"></p> 
                    <!-- Address info start here -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	                   	  <tr>
	                      	<th colspan="5"><?php echo __('Address Information');?></th>
	                      </tr>
	                      <tr>
	                        <td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Quarter No./Plot No.');?></td>
	                        <td width="30%"><?php echo $this->Form->input('plot_no', array('class' => 'textBoxExpnd','id' => 'plot_no')); ?></td>
	                        <td width="30">&nbsp;</td>
                                <td width="19%" class="tdLabel" id="boxSpace"><?php echo('Near Landmark');?></td>
	                        <td width="30%"><?php echo $this->Form->input('landmark', array('class' => 'textBoxExpnd','id' => 'patientFile')); ?></td>
	                     </tr>
                             <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('City/Town');?></td>
	                        <td><?php echo $this->Form->input('city', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'city1')); ?></td>
	                        <td>&nbsp;</td>
                                <td class="tdLabel" id="boxSpace"><?php echo __('Village/Taluka');?></td>
	                        <td><?php echo $this->Form->input('taluka', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'village')); ?></td>
	                      </tr>
                              <tr>
                               <td class="tdLabel" id="boxSpace"><?php echo __('District');?></td>
	                       <td><?php echo $this->Form->input('district', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'district1')); ?></td>
                               <td>&nbsp;</td>
                               <td class="tdLabel" id="boxSpace"><?php echo __('State');?></td>
	                       <td><?php echo $this->Form->input('state', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'state1')); ?></td>
                              </tr>
                              <tr>
	                        <td class="tdLabel" id="boxSpace" valign="top"><?php echo __('Pin Code');?></td>
	                        <td valign="top"><?php echo $this->Form->input('pin_code', array('class' => 'textBoxExpnd','id' => 'pinCode','MaxLength'=>'6')); ?></td>
	                        <td>&nbsp;</td>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Nationality');?></td>
	                        <td><?php echo $this->Form->input('nationality', array('class' => 'textBoxExpnd','id' => 'email','Value'=>'Indian')); ?></td>
	                     </tr>
	                      <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Home Phone No.');?></td>
	                         <td><?php echo $this->Form->input('home_phone', array('class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'home_phone','MaxLength'=>'10')); ?></td>
	                        <td>&nbsp;</td>
	                        <td class="tdLabel" id="boxSpace"><?php echo('Mobile No.');?><font color="red">*</font></td>
	                        <td><?php echo $this->Form->input('mobile', array('class' => 'validate[required,custom[onlyNumber]] textBoxExpnd','id' => 'mobile','MaxLength'=>'10')); ?></td>
	                      </tr>
						  <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo('Emergency Contact Name');?></td>
	                        <td><?php echo $this->Form->input('patient_owner', array('class' => 'textBoxExpnd','id' => 'patient_owner')); ?></td>
	                        <td>&nbsp;</td>
	                        <td class="tdLabel" id="boxSpace"><?php echo('Emergency Contact No.');?></td>
	                        <td><?php echo $this->Form->input('asst_phone', array('class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'asst_phone','MaxLength'=>'10')); ?></td>
	                      </tr>
	                      <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Email');?><font color="red">*</font></td>
	                        <td><?php echo $this->Form->input('email', array('class' => 'validate[required,custom[email]] textBoxExpnd','id' => 'email')); ?></td>
	                        <td>&nbsp;</td>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Fax');?></td>
	                        <td><?php echo $this->Form->input('fax', array('class' => 'textBoxExpnd','id' => 'email')); ?></td>
	                     </tr>              
                    </table>
                    <!-- Links to Records end here -->                    
                    <p class="ht5"></p>                    
                    <!-- Patient clinical record start here -->
                    <!--
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5"><?php echo __('Description Information'); ?> </th>
                      </tr>
                      <tr>
                        <td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;"><?php echo __('UIDPatient Owner');?></td>
                        <td colspan="2"><?php
                        	
                        	 echo $this->Form->input('patient_owner', array('empty'=>__('Please Select'),'options'=>$doctors,'class' => 'textBoxExpnd','id' => 'patient_owner')); ?></td>  
                        <td>&nbsp;&nbsp;</td>                     
                      </tr>
                      <tr>
                        <td valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;"><?php echo __('Asst Phone');?></td>
                        <td colspan="2"><?php echo $this->Form->input('asst_phone', array('class' => 'textBoxExpnd','id' => 'asst_phone')); ?></td>         
                        <td>&nbsp;&nbsp;</td>                     
                      </tr>
                      <tr>
                       	<td   valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;">Description</td>
                        <td colspan="2"><?php echo $this->Form->textarea('description', array('class' => 'textBoxExpnd','id' => 'description','row'=>3)); ?></td>
                        <td>&nbsp;&nbsp;</td>     
                      </tr>
                      <tr>
                       	<td   valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;"><?php echo __('Skype ID');?></td>
                        <td colspan="2"><?php echo $this->Form->input('skype_id', array('type'=>'text','class' => 'textBoxExpnd','id' => 'skypeId')); ?></td>
                        <td>&nbsp;&nbsp;</td>         
                      </tr>                    
                    </table>
                    -->
                    
                   <!-- form end here -->              
                    
                    <div class="btns" style="margin-top:-15px;">
						<?php 
							echo $this->Html->link(__('Cancel', true),array('controller'=>'Users','action' => '/'), array('escape' => false,'class'=>'blueBtn'));
						?>
                       	
						  <input class="blueBtn" type="submit" value="Submit" id="submit1">
                     </div>
			<?php //EOF new form design ?>			 
	  </div>
 <?php echo $this->Form->end(); ?>
 
<script>
		jQuery(document).ready(function(){
			
			// binds form submission and fields to the validation engine
			jQuery("#personfrm").validationEngine();
			$('#submit,#submit1').click(function(){  
				jQuery("#admission_type").removeClass('validate[required,custom[mandatory-select]]');	
			 	$("#admission_type").validationEngine("hidePrompt"); 
			 	var validatePerson = jQuery("#personfrm").validationEngine('validate');
			 	if(validatePerson){
			 		$(this).css('display','none');
				}
			});
			
			$('#goforpatientbyotherway').click(function(){   
				jQuery("#admission_type").addClass('validate[required,custom[mandatory-select]]'); 
				var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][submitandregister]").val("1");
                $('#personfrm').append($(input));
                $('#personfrm').submit();
				 
			});
			 
			
			//BOF web cam script
			 $('#camera').click(function(){
				$.fancybox(
					    {
					    	'autoDimensions':false,
					    	'width'    : '85%',
						    'height'   : '90%',
						    'autoScale': true,
						    'transitionIn': 'fade',
						    'transitionOut': 'fade',						    
						    'type': 'iframe',
						    'href': '<?php echo $this->Html->url(array( "action" => "webcam")); ?>'
				});
			});			
		   //EOF web cam script
		
		
			//on realtion select
			$('#insurance_relation_to_employee').change(function(){
				$('#insurance_esi_suffix').val($(this).val());
				$('#corpo_esi_suffix').val('');
				$('#corpo_relation_to_employee').val('');
			});
	
			$('#corpo_relation_to_employee').change(function(){
				$('#insurance_esi_suffix').val('');
				$('#corpo_esi_suffix').val($(this).val());
				$('#insurance_relation_to_employee').val('');
			});	
			
			$('#doctor_id').change(function(){
			    $.ajax({
			      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+$(this).val(),
			      context: document.body,          
			      success: function(data){ 
			     $('#department_id').val(data); 
			      }
			    });
			   });
			   
			$( "#dob" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '-50:+50',
				maxDate: new Date(),
				dateFormat: 'dd/mm/yy',
			});
                        $( "body" ).click(function() {
                                 var dateofbirth = $( "#dob" ).val();
				 if(dateofbirth !="") {
                     var currentdate = new Date();
                     var splitBirthDate = dateofbirth.split("/");
                     var caldateofbirth = new Date(splitBirthDate[2]+"/"+splitBirthDate[1]+"/"+splitBirthDate[0]+" 00:00:00");
                     var caldiff = currentdate.getTime() - caldateofbirth.getTime();                      
                     var calage =  Math.floor(caldiff / (1000 * 60 * 60 * 24 * 365.25));
                     $("#age" ).val(calage);
                 }
                                
			});

			 $('#city').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","City","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				 selectFirst: true
			});
			$('#district').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","District","name",'null',"no","no","admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				 selectFirst: true
			});
                        $('#state').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","State","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				 selectFirst: true
			});
                       
                       $('#goforpatient').click(function() {
                        var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][submitandregister]").val("1");
                        $('#personfrm').append($(input));
                        $('#personfrm').submit();
                       });
 
                       $('#goforpatientbyotherway').click(function() {
                        var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][submitandregister]").val("1");
                        $('#personfrm').append($(input));
                        $('#personfrm').submit();
                       });
                       //  click on  capture fingerprint it save the person data & redirect to finger_print page,by atul
                       $('#capturefingerprint').click(function() {
                           var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][capturefingerprint]").val("1");
                           $('#personfrm').append($(input));
                           $('#personfrm').submit();
                          });
                       // disable 5 text boxes when card is selected //
                       //to hide and show insurance and corporate block.
		               $('#paymentCategoryId').live('change',function(){
						    if($('#paymentCategoryId').val() == 1) {
	                              $('#showwithcardInsurance').hide('fast');
	                              $('#showwithcard').show('slow');
	                              $('#showwithcardInsurance :input').attr('disabled', true);
	                              $('#showwithcard :input').attr('disabled', false);
			                }else if($('#paymentCategoryId').val() == 2) {
	                			  $('#showwithcard').hide('fast');  
	                              $('#showwithcardInsurance').show('slow'); 
	                              $('#showwithcardInsurance :input').attr('disabled', false);
	                              $('#showwithcard :input').attr('disabled', true);
			                }else{  
	                              $('#showwithcard').hide();
	                              $('#showwithcardInsurance').hide();
			                } 
					});
						

					 $('#paymentType').change(function(){
						    if($('#paymentType').val() == "cash") {
						    	   $('#showwithcard').hide();
		                              $('#showwithcardInsurance').hide();
			                 }
					 });
					
				//fnction to disable one option
				$('.emp_id').live('keyup change',function(){
					if($(this).val() != ''){
						$('.emp_id').not(this).attr('disabled',true);
						if($(this).attr('id')=='insurance_executive_emp_id_no'){
							$('#insurance_esi_suffix').val('');
						}else if($(this).attr('id')=='insurance_non_executive_emp_id_no'){
							$('#insurance_esi_suffix').val($('#insurance_relation_to_employee').val()); 
						}
						if($(this).attr('id')=='corpo_executive_emp_id_no'){
							$('#corpo_esi_suffix').val('');
						}else if($(this).attr('id')=='corpo_non_executive_emp_id_no'){
							$('#corpo_esi_suffix').val($('#corpo_relation_to_employee').val());
						} 
				   }else{
						$('.emp_id').attr('disabled',false);
				   }
				}); 
		});
	 
	// To call the patient registration page on clicking submit and register.

	function getRedirected(){
		
	}

/* 
 To change sex onclick of initials
 
 */
	
	$('#initials').change(function(){
		var getInitial=$("#initials option:selected").val();
		if(getInitial=='2' || getInitial=='3'){
			$("#sex").val('female');
			//var getInitial=$("#sex option:selected").val();
		}else if(getInitial=='1' || getInitial=='5') {
			$("#sex").val('male');
		}else{
			$("#sex").val(''); 
		}
	});


//---------------------------------BOF Atul, for 1st letter uppercase-----------------------------

	$("#first_name,#last_name,#relativeName,#patient_owner").keyup(function() {
		toUpper(this);
		});
		
		 function toUpper(obj) {
		var mystring = obj.value;
		var sp = mystring.split(' ');
		var wl=0;
		var f ,r;
		var word = new Array();
		for (i = 0 ; i < sp.length ; i ++ ) {
		f = sp[i].substring(0,1).toUpperCase();
		r = sp[i].substring(1).toLowerCase();
		word[i] = f+r;
		}
		newstring = word.join(' ');
		obj.value = newstring;
		return true;
		}

// $('#first_name,#last_name').css('textTransform', 'capitalize'); /*this line also for 1st capital letter*/
//------------EOF-------	
	 
</script>
