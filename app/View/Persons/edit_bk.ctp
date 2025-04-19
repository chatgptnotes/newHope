<?php
	echo $this->Html->script(array('jquery.autocomplete'));
    echo $this->Html->css('jquery.autocomplete.css'); 
    echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array('jquery.fancybox-1.3.4'));
?>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Edit UID Patient Details', true); ?></h3>
	<span> <?php echo $this->Html->link(__('Search UIDpatient'), array('action' => 'search'), array('escape' => false,'class'=>'blueBtn')); ?></span>
</div>
<?php echo $this->Form->create('Person',array('name'=>'Person','type' => 'file','url' => array('controller' => 'persons', 'action' => 'edit'),'id'=>'personfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )
			));	 
			
			echo $this->Form->hidden('id',array());
			echo $this->Form->hidden('patient_uid',array());
			echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));
			?>
		<?php 
		  if(!empty($errors)) {
		?>
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
                   <div class="btns">
                          <input class="grayBtn" type="button" value="Cancel" 
                           	onclick="window.location='<?php echo $this->Html->url(array("controller" => $this->params['controller'],
                           	"action" => "patient_information",$this->data['Person']['id']));?>'">
						  <input class="blueBtn" type="submit" value="Submit" id="submit">
                   </div>
                   <!--<div class="btns" style="float:left;">	
                   		<?php 
					   		echo $this->Form->input('admission_type',array('type'=>'select','options'=>Array('IPD'=>'IPD','OPD'=>'OPD','EMERGENCY'=>'EMERGENCY')));
					    ?>					 
						<input class="blueBtn" type="button" value="Submit And Register" id="goforpatient" >
                   </div>
                   --><div class="clr"></div>
                   <!-- Patient Information start here -->
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5"><?php echo __("UIDPatient Information") ; ?></th>
                      </tr> 
                      <tr>
                        <td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("First Name");?><font color="red">*</font></td>
                        <td width="30%"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          	<td><?php echo $this->Form->input('initial_id', array('empty'=>__('Select'),'options'=>$initials,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'initials','style'=>'width:80px')); ?></td>
                            <td>                            	 
                            	<?php echo $this->Form->input('first_name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'first_name')); ?>
                            </td>                           
                          </tr>
                        </table></td>
                        <td width="">&nbsp;</td>
						 <td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Last Name');?><font color="red">*</font></td>
                        <td>
                        	<?php echo $this->Form->input('last_name', array('class' => 'validate[required,custom[patient_last_name]] textBoxExpnd','id' => 'last_name')); ?>
                        </td> 
                      </tr>
                      <tr> 
							<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Sex');?> <font color="red">*</font></td>
							<td width="30%">
								<?php  
									echo $this->Form->input('sex', array('options'=>array(""=>__('Please Select Sex'),"male"=>__('Male'),'female'=>__('Female')),'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'sex')); ?>
							</td> 
                      </tr>
                                                 
                     <tr>
                       <td class="tdLabel" id="boxSpace">Patient's Photo</td>
                       <td>
                       	<?php echo $this->Form->input('upload_image', array('type'=>'file','id' => 'patient_photo','class'=>"textBoxExpnd", 'label'=> false,
					 			'div' => false, 'error' => false ));
                       			 
							  echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera'));
                       ?>
                       
                       <canvas width="320" height="240" id="parent_canvas" style="display:none;"></canvas>
                       
                       </td>
                       <td>&nbsp;</td> <td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Passport No/ID');?></td>
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
                       		echo $this->Form->input('blood_group', array('empty'=>__('Please Select'),'options'=>$blood_group,'class' => 'textBoxExpnd','id' => 'designation')); ?></td>
                       <td>&nbsp;</td>
                       <td valign="top" class="tdLabel" id="boxSpace"><?php echo __('Allergies');?> </td>
                       <td><?php echo $this->Form->textarea('allergies', array('class' => 'textBoxExpnd','id' => 'allergies','row'=>'3')); ?></td>
                       <!-- <td class="tdLabel" id="boxSpace"> <?php echo __('UIDDate'); ?> <font color="red">*</font></td>
                       <td>
                       		<?php
                       			                      			 
                       			echo $this->Form->input('uiddate', array('class' => 'textBoxExpnd','type'=>'text','id' => 'uiddate')); ?>
                       </td>-->
                     </tr>
                     <tr>
                     	   <td class="tdLabel " id="boxSpace" valign="top" >Referral Doctor</td>
                        <td>
                         <?php //echo $this->Form->input('known_fam_physician', array('class' => 'textBoxExpnd','id' => 'knownPhysician'));
						 
                              echo $this->Form->input('known_fam_physician', array('empty'=>__('Please Select'), 'id'=>'familyknowndoctor','class'=>'textBoxExpnd', 'options'=>$reffererdoctors,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'getDoctorsList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    						 'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeDoctorsList', 'data' => '{familyknowndoctor:$("#familyknowndoctor").val()}', 'dataExpression' => true, 'div'=>false))));
                          ?>

                          <div id="changeDoctorsList">	
                          	 <?php 
	                          	if($this->data['Person']['known_fam_physician']){
                                         // if consultant id  exist //
                                         if($this->data['Person']['consultant_id']){
	                           		 echo $this->Form->input('Person.consultant_id', array('options' => $doctorlist, 'empty' => 'Select Doctor', 'id' => 'doctorlisting', 'label'=> false, 'div' => false, 'error' => false));
                                         }
                                         // if registrar id exist //
                                         if($this->data['Person']['registrar_id']){
	                           		 echo $this->Form->input('Person.registrar_id', array('options' => $registrarlist, 'empty' => 'Select Doctor', 'id' => 'doctorlisting', 'label'=> false, 'div' => false, 'error' => false));
                                         }
	                          	}
                          	?>                        
	                      </div>
                          </td>
                   		<td>&nbsp;</td>
                           <td valign="middle" class="tdLabel" id="boxSpace">Family Physician Contact No.</td>
                        <td>
                        	<?php echo $this->Form->input('family_phy_con_no', array('class' => 'textBoxExpnd','id' => 'phyContactNo')); ?>                        
                        </td>  
                     </tr> 
                     <tr>
                        <td class="tdLabel" id="boxSpace">Relatives Name</td>
                       	<td><?php echo $this->Form->input('relative_name', array('class' => 'textBoxExpnd','id' => 'relativeName')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="middle" class="tdLabel" id="boxSpace">Relative Phone No.</td>
                        <td>
                        	<?php echo $this->Form->input('relative_phone', array('class' => ' textBoxExpnd','id' => 'mobilePhone')); ?>
                        </td>
                     </tr>
                      <tr> 
						<td valign="middle" class="tdLabel" id="boxSpace">Instructions</td>
                        <td>
                        	<?php
                                 $instructions = array('Diabetic'=>'Diabetic- If found Unconscious give sugar/sweet/chocolate.','Epileptic'=>'Epileptic- In case of attack/fit turn patient to one side & refrain from feeding.','High Blood Pressure'=>'High Blood Pressure- If found unconscious or paralyzed, turn patient to one side & refrain from feeding.','Low Blood Pressure'=>'Low Blood Pressure- In case of vertigo keep head in low position & take plenty of fluids.','Cardiac Problem'=>'Cardiac Problem- In case of symtoms like chest pain or sweating administer Tablet Disprin & sublingual Tablet Sorbitrate.','Asthma'=>'Asthma- In case of acute attack administer 2 puffs of Scroflo inhaler & shift to hospital.');
                        	 //$instructions = array('Diabetic'=>'Diabetic','Epileptic'=>'Epileptic','High Blood Pressure'=>'High Blood Pressure','Low Blood Pressure'=>'Low Blood Pressure','Prone to Angina Attacks'=>'Prone to Angina Attacks','Austistic'=>'Austistic');
                        	 echo $this->Form->input('instruction', array('empty'=>__('Please Select'),
                        								  'options'=>$instructions,'class' => 'textBoxExpnd','id' => 'instructions')); ?>
                        	</td>
                        <td>&nbsp;</td>
                        <td class="tdLabel" id="boxSpace">&nbsp;</td>
                        <td>&nbsp;</td>
                     
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
		                        <td class="tdLabel" id="boxSpace" valign="top" width="19%"> Sponsor Details <font color="red">*</font></td>
	                             <td width="30%">
			                       		<?php 
			                       			$paymentCategory = array('cash'=>'Self Pay','card'=>'Card');
			                       			echo $this->Form->input('payment_category', array('empty'=>__('Please Select'),'options'=>$paymentCategory,'autocomplete'=>'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'paymentType','onchange'=> $this->Js->request(array('action' => 'getPaymentType'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			    								 'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{paymentType:$("#paymentType").val()}', 'dataExpression' => true, 'div'=>false)))); 
			                       		?>
			                        	<span id="changeCreditTypeList">
				                        	<?php  
				                               if($this->data['Person']['credit_type_id'] == 1) { 
				                        	?>
				                         	<span><font color="red">*</font>&nbsp;
					                           <?php 
					          						echo $this->Form->input('Person.credit_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false))));
					                          ?>
					                          <span id="changeCorprateLocationList"><font color="red">*</font>&nbsp;
					                           <?php 
					          						echo $this->Form->input('Person.corporate_location_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporatelocations, 'empty' => __('Select Corporate Location'), 'id' => 'ajaxcorporatelocationid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateList', 'data' => '{ajaxcorporatelocationid:$("#ajaxcorporatelocationid").val()}', 'dataExpression' => true, 'div'=>false))));
					                          ?>
					                          <span id="changeCorporateList"><font color="red">*</font>&nbsp;
					                          <?php 
					          						echo $this->Form->input('Person.corporate_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporates, 'empty' => __('Select Corporate'), 'id' => 'ajaxcorporateid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateSublocList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateSublocList', 'data' => '{ajaxcorporateid:$("#ajaxcorporateid").val()}', 'dataExpression' => true, 'div'=>false))));
					                          ?>
					                          <span id="changeCorporateSublocList">
					                            <?php 
					          						echo $this->Form->input('Person.corporate_sublocation_id', array('class'=>'textBoxExpnd1','options' => $corporatesublocations, 'empty' => __('Select Corporate Sublocation'), 'id' => 'ajaxcorporatesublocationid', 'label'=> false, 'div' => false, 'error' => false));
					                                echo "<br />";
					                                echo __('Other Details :'); 
					                                echo $this->Form->textarea('corporate_otherdetails', array('class' => 'textBoxExpnd','id' => 'otherdetails','row'=>'3')); 
					                          ?>
			                          		</span>
			                          	 </span>
			                          </span>
			                          
			                          
			                       <?php } if($this->data['Person']['credit_type_id'] == 2) { ?>
			                           <span><font color="red">*</font>&nbsp;
			                           <?php 
			          						echo $this->Form->input('Person.credit_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false))));
			                          ?>
			                           <span id="changeCorprateLocationList"><font color="red">*</font>&nbsp;
			                            <?php 
			          						echo $this->Form->input('Person.insurance_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancetypes, 'empty' => __('Select Insurance Type'), 'id' => 'insurancetypeid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getInsuranceCompanyList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeInsuranceCompanyList', 'data' => '{insurancetypeid:$("#insurancetypeid").val()}', 'dataExpression' => true, 'div'=>false))));
			                          ?>
			                          <span id="changeInsuranceCompanyList"><font color="red">*</font>&nbsp;
			                           <?php 
			          						echo $this->Form->input('Person.insurance_company_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancecompanies, 'empty' => __('Select Insurance Company'), 'id' => 'ajaxinsurancecompanyid', 'label'=> false, 'div' => false, 'error' => false));
			                          ?>
			                         </span>
			                        </span>
			                        </span>
			                       <?php 
			                             }  
			                       ?>
			                       </span>
	                       
	                       	</td>
		                    <td>&nbsp;</td>
		                    <td width="19%">&nbsp;</td>
		                    <td width="30%">&nbsp;</td>
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
														 $relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
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
				                       			<?php echo $this->Form->input('suffix', array('style'=>'width:60px','class' => 'textBoxExpnd emp_id','id' => 'insurance_esi_suffix', 'readonly' => 'readonly')); ?>
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
	                    	 </tr> 
	                </table>
	                <p class="ht5"></p>
	                <!-- Sponcer Details ends here -->
	                <!-- Edit Diagnosis Start -->
	                <!-- End Of Diagnosis -->
                   <p class="ht5"></p>
                    
                    <!-- Links to Records start here -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">Links to Records</th>
                      </tr>
                      <tr>
                        <td width="19%" class="tdLabel" id="boxSpace">Case summary Link</td>
                        <td width="81%"><?php echo $this->Form->input('case_summery_link', array('class' => 'textBoxExpnd','id' => 'caseSummeryLink')); ?></td>
                        
                      </tr>
                      <tr>
                        <td class="tdLabel" id="boxSpace">Patient File</td>
                        <td><?php echo $this->Form->input('patient_file', array('class' => 'textBoxExpnd','id' => 'patientFile')); ?></td>
                        
                      </tr> 
                    </table>
                    <!-- Links to Records end here --> 
                     <p class="ht5"></p> 
                     <!- Aditya -->
                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	                   	  <tr>
	                      	<th colspan="5"><?php echo __('Demographic');?></th>
	                      </tr>
	                      <tr>
	                      <td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Date of Birth');?></td>
							<td width="30%">
								<?php 
									echo $this->Form->input('dob', array('type'=>'text','style'=>'width:136px','readonly'=>'readonly','size'=>'20','class' => 'textBoxExpnd','id' => 'dob'));
									echo "&nbsp;&nbsp;Age&nbsp;&nbsp;";
									echo '<font color="red">*</font>';
									echo $this->Form->input('age', array('type'=>'text','style'=>'width:40px','maxLength'=>'3','size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] textBoxExpnd','id' => 'age'));
								?>
							</td>
	                      </tr>
	                      <tr>
	                        <td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Ethnicity');?></td>
	                        <td width="30%"><?php echo $this->Form->input('ethnicity', array('empty'=>__('Denied to Specific'),'options'=>array('Hispanic  or Latino'=>'Hispanic  or Latino','Non-Hispanic or Latino'=>'Non-Hispanic or Latino','Others'=>'Others'),'id' => 'ethnicity','style'=>'width:150px')); ?></td>
	                        <td width="30">&nbsp;</td>
	                     </tr>
	                     <tr>
	                     <td  width="19%" class="tdLabel" id="boxSpace"></td>
	                     <td  width="19%" class="tdLabel" id="boxSpace"><?php echo __('Hold Ctrl to select multiple values'); ?></td>
	                     </tr>
	                     <tr>
	                      <?php $selected_language = explode(",", $getrace["0"]["Person"]["language"]); 
	                       //pr($selected_language); ?>
	                        <td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Preffered Language');?></td>
	                        <td width="30%"><?php echo $this->Form->input('language', array('empty'=>__('Denied to Specific'),'selected'=>$selected_language,'multiple'=>'true','options'=>$languages,'id' => 'language','style'=>'width:230px')); ?></td>
	                     </tr>
	                     <tr>
	                     <td  width="19%" class="tdLabel" id="boxSpace"></td>
	                     <td  width="19%" class="tdLabel" id="boxSpace"><?php echo __('Hold Ctrl to select multiple values'); ?></td>
	                     </tr>
	                     <tr>
	                      <?php $selected = explode(",", $getrace["0"]["Person"]["race"]); 
	                      // pr($selected); ?>
	                        <td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Race(s)');?></td>
	                        <td width="30%"><?php echo $this->Form->input('race', array('empty'=>__('Denied to Specific'),'selected'=>$selected,'multiple'=>'true','options'=>$race,'id' => 'race','style'=>'width:330px')); ?></td>
	                     
	                     </tr>
	                     </table>
                                   
                    <!-- Address info start here -->
                     <p class="ht5"></p> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	                   	  <tr>
	                      	<th colspan="5"><?php echo __('Address Information');?></th>
	                      </tr>
	                      <tr>
	                        <td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Quarter no/Plot no');?></td>
	                        <td width="30%"><?php echo $this->Form->input('plot_no', array('class' => 'textBoxExpnd','id' => 'plot_no')); ?></td>
	                        <td width="30">&nbsp;</td>
                                <td width="19%" class="tdLabel" id="boxSpace"><?php echo('Near Landmark');?></td>
	                        <td width="30%"><?php echo $this->Form->input('landmark', array('class' => 'textBoxExpnd','id' => 'patientFile')); ?></td>
	                      </tr>
                             <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('City/Town');?></td>
	                        <td><?php echo $this->Form->input('city', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'city')); ?></td>
	                        <td>&nbsp;</td>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Village/Taluka');?></td>
	                        <td><?php echo $this->Form->input('taluka', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'city')); ?></td>
	                     </tr>
                            <tr>
                             <td class="tdLabel" id="boxSpace"><?php echo __('District');?></td>
                             <td><?php echo $this->Form->input('district', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'district')); ?></td>
                             <td>&nbsp;</td>
                             <td class="tdLabel" id="boxSpace"><?php echo __('State');?></td>
                             <td><?php echo $this->Form->input('state', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'state')); ?></td>
                            </tr>
                            <tr>
	                        <td class="tdLabel" id="boxSpace" valign="top"><?php echo __('Pin Code');?></td>
	                        <td valign="top"><?php echo $this->Form->input('pin_code', array('class' => 'textBoxExpnd','id' => 'pinCode')); ?></td>
	                        <td>&nbsp;</td>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Nationality');?></td>
	                        <td><?php echo $this->Form->input('nationality', array('class' => 'textBoxExpnd','id' => 'email')); ?></td>
	                     </tr>
	                      <tr>
	                        <td  class="tdLabel" id="boxSpace"><?php echo __('Home Phone No.');?></td>
	                         <td ><?php echo $this->Form->input('home_phone', array('class' => 'textBoxExpnd','id' => 'home_phone')); ?></td>
	                        <td>&nbsp;</td>
	                        <td class="tdLabel" id="boxSpace"><?php echo('Mobile Phone No.');?></td>
	                        <td><?php echo $this->Form->input('mobile', array('class' => 'textBoxExpnd','id' => 'mobile')); ?></td>
	                      </tr>
						  <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo('Emergency Contact Name');?></td>
	                        <td><?php echo $this->Form->input('patient_owner', array('class' => 'textBoxExpnd','id' => 'patient_owner')); ?></td>
	                        <td>&nbsp;</td>
	                        <td class="tdLabel" id="boxSpace"><?php echo('Emergency Contact No.');?></td>
	                        <td><?php echo $this->Form->input('asst_phone', array('class' => 'textBoxExpnd','id' => 'asst_phone')); ?></td>
	                      </tr>
	                     <tr>
                                <td class="tdLabel" id="boxSpace"><?php echo __('Email');?></td>
	                        <td><?php echo $this->Form->input('email', array('class' => 'validate["",custom[email]] textBoxExpnd','id' => 'email')); ?></td>
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
                     <div style="text-align:left;">
                     	<?php 
					   		echo $this->Form->input('admission_type',array('id'=>'admission_type','type'=>'select','options'=>Array('IPD'=>'IPD','OPD'=>'OPD','emergency'=>'EMERGENCY'),'class'=>'validate[required,custom[mandatory-select]]','empty'=>'Please Select'));
					   ?>
                       <input type="submit" id="goforpatientbyotherway" value="Submit And Register" class="blueBtn" style="text-align:left;">
                    </div>           
                     <div class="btns" style="margin-top:-52px;">
                           <input class="grayBtn" type="button" value="Cancel" 
                           	onclick="window.location='<?php echo $this->Html->url(array("controller" => $this->params['controller'],
                           	"action" => "patient_information",$this->data['Person']['id']));?>'">
						  <input  class="blueBtn" type="submit" value="Submit" id="submit1">
                     </div>
			<?php //EOF new form design ?>			 
	  </div>
 <?php echo $this->Form->end(); ?>
 
<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
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
			jQuery("#personfrm").validationEngine(); 
			
			//BOF web cam script
			 $('#camera').click(function(){
				$.fancybox(
					    {
				            'width'    : '90%',
				            'height'   : '90%',
						    'autoScale': true,
						    'transitionIn': 'fade',
						    'transitionOut': 'fade',
						    'type': 'iframe',
						    'href': '<?php echo $this->Html->url(array( "action" => "webcam")); ?>'
				});
			});			
		   //EOF web cam script
		   	
			$('#doctor_id').change(function(){
			    $.ajax({
			      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+$(this).val(),
			      context: document.body,          
			      success: function(data){ 
			     $('#department_id').val(data); 
			      }
			    });
			   });
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
			$( "#dob" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '-50:+50',
				maxDate: new Date(),
				dateFormat: "dd/mm/yy"
			});
                        $( "body" ).click(function() {
                                 var dateofbirth = $( "#dob" ).val();
				 if(dateofbirth !="") {
                                  var currentdate = new Date();
                                  var splitBirthDate = dateofbirth.split("/");
                                  var caldateofbirth = new Date(splitBirthDate[2]+"/"+splitBirthDate[1]+"/"+splitBirthDate[0]+" 00:00:00");
                                  var caldiff = currentdate.getTime() - caldateofbirth.getTime();
                                  var calage =  Math.floor(caldiff / (1000 * 60 * 60 * 24 * 365.25));
                                  $( "#age" ).val(calage);
                                }
                                
			 });
				 $('#city').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","City","name",'null',"no","no", "admin" => false,"plugin"=>false)); ?>", {
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
 
                     $('#paymentType').change(function(){
						    if($('#paymentType').val() == "cash") {
						    	   $('#showwithcard').hide();
		                              $('#showwithcardInsurance').hide();
			                 }
					 });
				       
				       //onload decide
	                   if($('#insurance_non_executive_emp_id_no').val() != ''){
		     				  $('#insurance_executive_emp_id_no').attr('disabled',true);
		     		   }
	                   if($('#insurance_executive_emp_id_no').val() != ''){
		     				  $('#insurance_non_executive_emp_id_no').attr('disabled',true);
		     		   }
	                   if($('#corpo_executive_emp_id_no').val() != ''){
		     				  $('#corpo_non_executive_emp_id_no').attr('disabled',true);
		     		   }
		     		   
		     		   if($('#corpo_non_executive_emp_id_no').val() != ''){
		     				  $('#non_executive_emp_id_no').attr('disabled',true);
		     		   }
		     		   
	                   if($('#paymentCategoryId').val() == "1") { 
	         		      $('#showwithcard').show();
	         		      $('#showwithcardInsurance :input').attr('disabled', true);
	         		      $('#showwithcardInsurance :input').val(''); 
	                   }else if($('#paymentCategoryId').val() == "2") {
	                       $('#showwithcardInsurance').show(); 
	                       $('#showwithcard :input').attr('disabled', true);
	                       $('#showwithcard :input').val('');
	                   }
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
		
				}); //EOF document
 
</script>
