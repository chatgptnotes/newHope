<?php
     echo $this->Html->script(array('jquery.autocomplete'));   
	 echo $this->Html->script(array('jquery.fancybox-1.3.4'));
	   echo $this->Html->css('jquery.autocomplete.css');
     echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
      $vals = array('Hispanic','Non-Hispanic','Latino','Others');
      
?>

<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('New Patient Details', true); ?>
	</h3>

	<span> <?php echo $this->Html->link(__('Search Patient'),array('action' => 'search_ambi'), array('escape' => false,'class'=>'blueBtn')); ?></span>
	
</div>
<?php

	echo $this->Form->create('Person',array('type' => 'file','name'=>'register','id'=>'personfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); 
	echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));
	?>
<?php 
		  if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center">
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
		<?php /*
							if(isset($redirectTo)){
								echo $this->Html->link(__('Cancel', true),array('controller'=>'nursings','action' => 'search/'), array('escape' => false,'class'=>'grayBtn'));
							} else {
								echo $this->Html->link(__('Cancel', true),array('controller'=>'persons','action' => 'search/'), array('escape' => false,'class'=>'grayBtn'));
							}
						*/ ?>
	<!-- 	<input class="blueBtn" type="submit" value="Submit"> -->
	</div>
	<div class="clr"></div>

	<!-- Patient Information start here -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">
				<?php echo __("Patient Information") ; ?>
			</th>
		</tr>
		
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __("Prefix");?> <font color="red">*</font>
			</td>
			<td width="30%"><table width="100%" cellpadding="0"
					cellspacing="0" border="0">
					<tr>
						<td>
							<?php echo $this->Form->input('initial_id', array('empty'=>__('Select'),'options'=>$initials,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'initials','style'=>'width:80px')); ?>
						</td>
						<td>
						</td>
		</tr></table></td></tr>
						
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __("First Name");?> <font color="red">*</font>
			</td>
			<td width="30%"><table width="100%" cellpadding="0"
					cellspacing="0" border="0">
					<tr>
						
						<td>
							<?php echo $this->Form->input('first_name', array('class' => 'validate[required,custom[name],custom[onlyLetterSp]] textBoxExpnd','id' => 'first_name')); ?>
						</td>

					</tr>
				</table></td>
			<td width="">&nbsp;</td>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Middle Intial');?>
			</td>
			<td>
				<?php echo $this->Form->input('middle_name', array('class' => 'validate[" ",custom[onlyLetterSp]] textBoxExpnd','id' => 'middle_name','size'=>'40')); ?>
			</td>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Last Name');?> <font color="red">*</font>
			</td>
			<td>
				<?php echo $this->Form->input('last_name', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterSp]] textBoxExpnd','id' => 'last_name')); ?>
			</td>
			<td>&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Name Type');?> <font color="red">*</font>
			</td>
			
				<td width="30%">
							<?php echo $this->Form->input('name_type', array('empty'=>'Please Select','options'=>$nametype,'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'name_type')); ?>
						</td>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Mothers Madien Name');?>
			</td>
			<td>
				<?php echo $this->Form->input('mother_name', array('class' => 'textBoxExpnd','id' => 'mother_name')); ?>
			</td>
			<td>&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">
				&nbsp;
			</td>
			
				<td width="30%">
							&nbsp;
						</td>
		</tr>
		<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Suffix');?> 
			</td>
			<td>
				<?php echo $this->Form->input('suffix1', array('options'=>array("empty"=>__('Please Select Type'),"CSJ"=>__('C.S.J. Sisters of St. Joseph'),"DC"=>__('D.C. Doctor of Chiropractic'),"DD"=>__('D.D. Doctor of Divinity'),"DDS"=>__('D.D.S. Doctor of Dental Surgery'),"DMD"=>__('D.M.D. Doctor of Dental Medicine'),"DO"=>__('D.O. Doctor of Osteopathy'),"DVM"=>__('D.V.M. Doctor of Veterinary Medicine'),"EdD"=>__('Ed.D. Doctor of Education'),"II"=>__('II The Second'),"III"=>__('III The Third'),"IV"=>__('IV The Fourth'),"JD"=>__('J.D. Juris Doctor'),"Jr"=>__('Jr. Junior'),"LLD"=>__('LL.D. Doctor of Laws'),"Ltd"=>__('Ltd. Limited'),"MD"=>__('M.D. Doctor of Medicine ')),'class' => 'textBoxExpnd','id' => 'suffix')); ?>
</td>
			<td>&nbsp;</td>
		
		<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Date of Birth');?> <font color="red">*</font>
			</td>
			<td width="30%">
				<?php 
									echo $this->Form->input('dob', array('type'=>'text','style'=>'width:136px','readonly'=>'readonly','size'=>'20','id' => 'dob'));
									//echo "&nbsp;&nbsp;Age&nbsp;&nbsp;";
									//echo '<font color="red">*</font>';
									//echo $this->Form->input('age', array('type'=>'text','style'=>'width:40px','maxLength'=>'3','size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] textBoxExpnd','id' => 'age'));
								?>
			</td>
		</tr>
		<tr>

			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Gender');?> <font color="red">*</font>
			</td>
			<td width="30%">
				<?php  

									 echo $this->Form->input('sex', array('readonly'=>'readonly','style'=>'width:160px','options'=>array(''=>__('Please Select Gender'),'Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')),'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'sex')); ?>

			</td>
			<td>&nbsp;</td>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Marital Status');?>
			</td>
			<td>
				<?php 
                       		$maritail_status = array("A"=>"Separated","B"=>"Unmarried","C"=>"Common law","D"=>"Divorced","E"=>"Legally Separated","G"=>"Living together","I"=>"Interlocutory","M"=>"Married","N"=>"Annulled","O"=>"Other","P"=>"Domestic partner","R"=>"Registered domestic partner","S"=>"Single","T"=>"Unreported","U"=>"Widowed","W"=>"Unknown");
                       		echo $this->Form->input('maritail_status', array('empty'=>__('Please Select'),'options'=>$maritail_status,'class' => 'textBoxExpnd','id' => 'maritail_status')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">Patient's Photo</td>
			<td>
				<?php 
                       			echo $this->Form->input('upload_image', array('type'=>'file','id' => 'patient_photo', 'class'=>"textBoxExpnd",'label'=> false,
					 				'div' => false, 'error' => false));
                       			
								echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera','title'=>'Capture photo from webcam'));
                       ?>
				<canvas width="320" height="240" id="parent_canvas"
					style="display: none;"></canvas>

			</td>
			<td>&nbsp;</td>
			<!-- <td class="tdLabel" id="boxSpace"> <?php echo __('UIDDate'); ?> <font color="red">*</font></td>
                       <td>
                       		<?php
                       			                      			 
                       			echo $this->Form->input('uiddate', array('class' => 'textBoxExpnd','type'=>'text','id' => 'uiddate')); ?>
                       </td>-->
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Blood Group');?>
			</td>
			<td>
				<?php 
                       		$blood_group = array("A+"=>"A+","A-"=>"A-","B+"=>"B+","B-"=>"B-","AB+"=>"AB+","AB-"=>"AB-","O+"=>"O+","O-"=>"O-");
                       		echo $this->Form->input('blood_group', array('empty'=>__('Please Select'),'options'=>$blood_group,'class' => 'textBoxExpnd','id' => 'designation')); ?>
			</td>
			<td>&nbsp;</td>
			<td valign="top" class="tdLabel" id="boxSpace">
				<?php echo __('Allergies');?>
			</td>
			<td>
				<?php echo $this->Form->textarea('allergies', array('class' => 'custom[onlyLetterSp] textBoxExpnd','id' => 'allergies','row'=>'3')); ?>
			</td>
			<!-- <td class="tdLabel" id="boxSpace"> <?php echo __('UIDDate'); ?> <font color="red">*</font></td>
                       <td>
                       		<?php
                       			                      			 
                       			echo $this->Form->input('uiddate', array('class' => 'textBoxExpnd','type'=>'text','id' => 'uiddate')); ?>
                       </td>-->
		</tr>
		<tr>
			<td class="tdLabel " id="boxSpace" valign="top">Referral Doctor</td>
			<td>
				<?php //echo $this->Form->input('known_fam_physician', array('class' => 'textBoxExpnd','id' => 'knownPhysician'));
						 
                              echo $this->Form->input('known_fam_physician', array('empty'=>__('Please Select'), 'id'=>'familyknowndoctor','class'=>'textBoxExpnd', 'options'=>$reffererdoctors,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'getDoctorsList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    						 'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeDoctorsList', 'data' => '{familyknowndoctor:$("#familyknowndoctor").val()}', 'dataExpression' => true, 'div'=>false))));
                          ?>

				<div id="changeDoctorsList"></div>
			</td>
			<td>&nbsp;</td>
			<td valign="middle" class="tdLabel" id="boxSpace">Status</td>
			<td>
				<?php
                                 $Status = array('Active'=>'Active','Inactive'=>'Inactive','Expired'=>'Expired','Rejected'=>'Rejected');

                        	 //$instructions = array('Diabetic'=>'Diabetic','Epileptic'=>'Epileptic','High Blood Pressure'=>'High Blood Pressure','Low Blood Pressure'=>'Low Blood Pressure','Prone to Angina Attacks'=>'Prone to Angina Attacks','Austistic'=>'Austistic');
                        	 echo $this->Form->input('Status', array('empty'=>__('Please Select'),
                        								  'options'=>$Status,'class' => 'textBoxExpnd','id' => 'Status')); ?>
			</td>
		</tr>

		<tr>

			<td valign="middle" class="tdLabel" id="boxSpace"> 
				<?php echo __('SSN');?>
			</td>
			<td>
				<?php echo $this->Form->input('ssn_us', array('id' => 'ssn','MaxLength'=>9)); ?>
			</td>
			<td class="tdLabel" id="boxSpace">&nbsp;</td>
			<td>&nbsp;</td>

		</tr>
		<tr>

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
	<!-- Patient Demographic record start here -->
	<!- Aditya -->

	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">
			
			<!-- Enfd of the check _demo function -->
				<?php echo __('Demographic');?> <?php echo __(' ');?> <?php echo $this->Form->input('ckeckDemo', array('type'=>'checkbox','id' => 'ckeckDemo')); ?><?php echo __('Do not mention Ethnicity, Race and Language')?>
			
			</th>
		</tr>

		<tr>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Ethnicity');?>
			</td>
			<!--Hispanic, Latino, American, African   -->
			<td width="30%">
				<?php echo $this->Form->input('ethnicity', array('empty'=>__('Select'),'options'=>array('Hispanic or Latino'=>'Hispanic or Latino','Not Hispanic or Latino'=>'Not Hispanic or Latino',':American'=>'American',':African'=>'African','Denied to Specific'=>'Denied to Specific'),'id' => 'ethnicity','style'=>'width:150px')); ?>
			</td>
			<td width="30">&nbsp;</td>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace"></td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Hold Ctrl to select multiple values'); ?>
			</td>
		</tr>
		<tr>

			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Preffered Language');?>
			</td>
			<td width="30%">
				<?php echo $this->Form->input('language', array('empty'=>__('Select'),'options'=>$languages,'multiple'=>'true','id' => 'language','style'=>'width:230px')); ?>
				<?php  // echo $this->Form->input('language', array('empty'=>__('Select'),'options'=>$languages,'id' => 'language','style'=>'width:230px')); ?>
			</td>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace"></td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Hold Ctrl to select multiple values'); ?>
			</td>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Race(s)');?>
			</td>
			<td width="30%">
				<?php echo $this->Form->input('race', array('empty'=>__('Select'),'options'=>$race, 'multiple'=>'true','id' =>'race','style'=>'width:330px')); ?>
			</td>
		</tr>


	</table>
	<!-- ------End of the Demograghic code------------------- -->
	<!-- Links to Records end here -->
	<p class="ht5">
	<p class="ht5"></p>
	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	                   	  	<tr>
		                      	<th colspan="5"><?php echo __('Sponsor Information');?></th>
		                    </tr>
		                    <tr>
		                        <td width="19%" class="tdLabel"  id="boxSpace" valign="top"> Sponsor Details <font color="red">*</font></td>
		                        <td  width="30%" align="left">
	                                
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
	                                 -->
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
		<tr id="showwithcardInsurance" style="display: none;">
			<td width="100%" colspan="5" align="left" class="" id=" ">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="19%" class="tdLabel" id="boxSpace">
							<?php echo __('Name of Insurance Holder');?>
						</td>
						<td width="30%" align="left">
							<?php echo $this->Form->input('name_of_ip', array('class' => 'textBoxExpnd','id' => 'name_of_ip')); ?>
						</td>
						<td width="">&nbsp;</td>
						<td valign="middle" class="tdLabel" id="boxSpace" width="19%">
							<?php echo __('Relationship with Insurance Holder');?>
						</td>
						<td align="left" width="30%">
							<?php
														 $relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
														 echo $this->Form->input('relation_to_employee', array('empty'=>__('Please Select'),'options'=>$relation,'class' => 'textBoxExpnd','id' => 'corpo_relation_to_employee')); ?>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" id="boxSpace">
							<?php echo __('Insurance Number');?>
						</td>
						<td align="left">
							<?php echo $this->Form->input('insurance_number', array('class' => 'textBoxExpnd','id' => 'insurance_number')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel" id="boxSpace" align="left">
							<?php echo __('Designation');?>
						</td>
						<td align="left">
							<?php echo $this->Form->input('designation', array('class' => 'textBoxExpnd','id' => 'designation')); ?>
						</td>
					</tr>
					<tr>
						<td width="19%" class="tdLabel" id="boxSpace">
							<?php echo __('Executive Employee ID No.');?>
						</td>
						<td width="30%" align="left">
							<?php echo $this->Form->input('executive_emp_id_no', array('class' => 'textBoxExpnd emp_id','id' => 'corpo_executive_emp_id_no')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel" id="boxSpace">
							<?php echo __('Non Executive Employee ID No.');?>
						</td>
						<td align="left">
							<?php echo $this->Form->input('non_executive_emp_id_no', array('style'=>'width:180px','class' => 'textBoxExpnd emp_id','id' => 'corpo_non_executive_emp_id_no')); ?>
							<?php echo $this->Form->input('suffix', array('style'=>'width:60px','class' => 'textBoxExpnd emp_id','id' => 'corpo_esi_suffix', 'readonly' => 'readonly')); ?>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" id="boxSpace" align="left">
							<?php echo __('Company');?>
						</td>
						<td align="left">
							<?php echo $this->Form->input('sponsor_company', array('class' => 'textBoxExpnd','id' => 'sponsor_company')); ?>
						</td>
						<td class="tdLabel" id="boxSpace" align="left">&nbsp;</td>
						<td align="left">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<p class="ht5"></p>
	<!-- Sponcer Details ends here -->
	<p class="ht5"></p>

	<!-- Links to Records start here -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">Links to Records</th>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace">Case summary Link</td>
			<td width="81%">
				<?php
							if(empty($this->data['Person']['case_summery_link'])){
								$case_summery_link = $recordLink['Location']['case_summery_link'] ;
							}
                        	echo $this->Form->input('case_summery_link', array('value'=>$case_summery_link,'class' => 'textBoxExpnd','id' => 'caseSummeryLink')); ?>
			</td>

		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">Patient File</td>
			<td>
				<?php
                        	if(empty($this->data['Person']['patient_file'])){
								$patient_file = $recordLink['Location']['patient_file'] ;  
							}
                        	 echo $this->Form->input('patient_file', array('class' => 'textBoxExpnd','id' => 'patientFile','value'=>$patient_file)); ?>
			</td>
		</tr>
	</table>
	<!-- Links to Records end here -->
	<p class="ht5"></p>
	
	
	<!-- Address info start here -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">
				<?php echo __('Address Information');?>
			</th>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Address Line 1');?>
			</td>
			<td width="30%">
				<?php echo $this->Form->input('plot_no', array('class' => 'textBoxExpnd','id' => 'plot_no')); ?>
			</td>
			<td width="30">&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo('Address Line 2');?>
			</td>
			<td width="30%">
				<?php echo $this->Form->input('landmark', array('class' => 'textBoxExpnd','id' => 'landmark')); ?>
			</td>
		</tr>
		
		<tr>
			<td class="tdLabel" id="boxSpace" valign="top">
				<?php echo __('Zip');?>
			</td>
			<td valign="top">
				<?php echo $this->Form->input('pin_code', array('class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'pinCode','Maxlength'=>'5')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Zip 4');?>
			</td>
			<td>
				<?php echo $this->Form->input('zip_four', array('class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'zip_four','MaxLength'=>'4')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Phone No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('home_phone', array('class' => 'validate["",custom[phone]] textBoxExpnd','Maxlength'=>'10','id' => 'home_phone')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo('Mobile No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('mobile', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'mobile','Maxlength'=>'10')); ?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Email Address');?>
			</td>
			<td>
				<?php echo $this->Form->input('email', array('class' => 'validate["",custom[email]] textBoxExpnd','id' => 'email')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Fax No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('fax', array('class' => 'validate["",custom[onlyNumber]] textBoxExpnd','id' => 'fax','Maxlength'=>'10')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Work No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('work', array('class' => 'validate["",custom[phone]] textBoxExpnd','Maxlength'=>'10','id' => 'work')); ?>
			</td>
			<td>&nbsp;</td>
			<?php //debug($countries);?>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Country');?>
			</td>
			
			<td>
				 <?php 
          echo $this->Form->input('country', array('options' => $country, 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#customstate', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));
        ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
					<?php echo __('Religion');?>
				</td>
				<td>
				 <?php 
          echo $this->Form->input('religion', array('options' => $religion, 'empty' => 'Select Religion', 'id' => 'religion', 'label'=> false, 'div' => false, 'error' => false));
        ?>
			</td>
				
				<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
			<?php echo __('State',true); ?>
			</td>
			<td id="customstate">
		        <?php $states = '';
		       
		          echo $this->Form->input('state', array('options' => $states, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false));
		        ?>
			</td>
		</tr>
		<tr>
				<td class="tdLabel" id="boxSpace">
					&nbsp;
				</td>
				<td>
					&nbsp;
				</td>
				<td>&nbsp;</td>
				<td class="tdLabel" id="boxSpace">
					<?php echo __('City/Town');?>
				</td>
				<td>
					<?php echo $this->Form->input('city', array('class' => 'textBoxExpnd','id' => 'city')); ?>
				</td>
			</tr>
			<tr>
		<tr>
			
			<td>
				<?php echo $this->Form->checkbox('patient_portal', array('class' => 'textBoxExpnd','id' => 'portal')); ?>
			</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Nationality');?>
			</td>
			<td>
				<?php echo $this->Form->input('nationality', array('class' => 'textBoxExpnd','id' => 'nationality')); ?>
			</td>
		</tr>
	</table>
	<p class="ht5"></p>
	<!-- Patient Guarantor record start here -->
	<!-- Aditya -->

	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">
				<?php echo __('Guarantor');?> <?php echo __(' ');?> 
				 <?php echo $this->Form->input('ckeckGua', array('type'=>'checkbox','id' => 'ckeckGua')); ?>
				<?php echo __('Check to copy Patients deatails');?>
			</th>
		</tr>


		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __("First Name");?> 
			</td>
			<td width="30%"><table width="100%" cellpadding="0"
					cellspacing="0" border="0">
					<tr>
						<td>
							<?php echo $this->Form->input('initial_id', array('empty'=>__('Select'),'options'=>$initials,'id' => 'initials1','style'=>'width:80px')); ?>
						</td>
						<td>
							<?php echo $this->Form->input('gau_first_name', array('id' => 'gau_first_name')); ?>
						</td>

					</tr>
				</table></td>
			<td width="">&nbsp;</td>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Middle Intial');?> 
			</td>
			<td>
				<?php echo $this->Form->input('gau_middle_name', array('id' => 'gau_middle_name','size'=>'40')); ?>
			</td>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Last Name');?>
			</td>
			<td>
				<?php echo $this->Form->input('gau_last_name', array('id' => 'gau_last_name')); ?>
			</td>
			<td>&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Date of Birth');?> 
			</td>
			<td width="30%">
				<?php 
									echo $this->Form->input('dobg', array('type'=>'text','style'=>'width:136px','size'=>'20','id' => 'gau_dob'));
									//echo "&nbsp;&nbsp;Age&nbsp;&nbsp;";
									//echo '<font color="red">*</font>';
									//echo $this->Form->input('age', array('type'=>'text','style'=>'width:40px','maxLength'=>'3','size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] textBoxExpnd','id' => 'gau_age'));
								?>
			</td>
		</tr>
		<tr>

			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Gender');?> 
			</td>
			<td width="30%">
				<?php  
									echo $this->Form->input('gau_sex', array('options'=>array(''=>__('Please Select Gender'),'Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')),'id' => 'gau_sex')); ?>
			</td>
			<td>&nbsp;</td>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('SSN');?>
			</td>
			<td>
				<?php echo $this->Form->input('gau_ssn', array('id' => 'gau_ssn','MaxLength'=>9)); ?>
			</td>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Relationship');?> 
			</td>
			<td>
				<?php echo $this->Form->input('relation', array('id' => 'relation')); ?>
			</td>
		</tr>

		<tr>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Address Line 1');?>
			</td>
			<td width="30%">
				<?php echo $this->Form->input('gau_plot_no', array('class' => 'textBoxExpnd','id' => 'gau_plot_no')); ?>
			</td>
			<td width="30">&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo('Address Line 2');?>
			</td>
			<td width="30%">
				<?php echo $this->Form->input('gau_landmark', array('class' => 'textBoxExpnd','id' => 'gau_landmark')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('City/Location');?>
			</td>
			<td>
				<?php echo $this->Form->input('gau_city', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'gau_city')); ?>
			</td>

			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('State/Region');?>
			</td>
			<td>
				<?php echo $this->Form->input('gau_state', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'gau_state')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace" valign="top">
				<?php echo __('Zip');?>
			</td>
			<td valign="top">
				<?php echo $this->Form->input('gau_zip', array('class' => 'custom[customzipcode] textBoxExpnd','id' => 'gau_pin_Code','MaxLength'=>'6')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Work No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('gau_work', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'gau_work','Maxlength'=>'10')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Phone No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('gau_home_phone', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'gau_home_phone','MaxLength'=>'10')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo('Mobile No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('gau_mobile', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'gau_mobile','MaxLength'=>'10')); ?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Email Address');?>
			</td>
			<td>
				<?php echo $this->Form->input('gau_email', array('class' => 'validate["",custom[email]] textBoxExpnd','id' => 'gau_email')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Fax No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('gau_fax', array('class' => 'validate["",custom[customfax]] textBoxExpnd','id' => 'gau_fax','MaxLength'=>'10')); ?>
			</td>
		</tr>


	</table>
	<p class="ht5"></p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
			<tr>
			<th colspan="5">
				<?php echo __('guardian or Responsible Party');?> <?php echo __(' ');?> 
				 <?php echo $this->Form->input('ckeckguardian', array('type'=>'checkbox','id' => 'ckeckguardian')); ?>
				<?php echo __('Check to copy Patients details');?>
			</th>
		</tr>


		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxSpace">

				<?php echo __("First Name");?>

			</td>
			<td width="30%"><table width="100%" cellpadding="0"
					cellspacing="0" border="0">
					<tr>
						<td>

							<?php echo $this->Form->input('guar_initial_id', array('empty'=>__('Select'),'options'=>$initials,'id' => 'initials1','style'=>'width:80px')); ?>

						</td>
						<td>

							<?php echo $this->Form->input('guar_first_name', array('id' => 'guar_first_name')); ?>

						</td>

					</tr>
				</table></td>
			<td width="">&nbsp;</td>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Middle Intial');?> 
			</td>
			<td>
				<?php echo $this->Form->input('guar_middle_name', array('class' => 'validate["",custom[onlyLetterSp]] textBoxExpnd','id' => 'guar_middle_name','size'=>'40')); ?>
			</td>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Last Name');?>
			</td>
			<td>

				<?php echo $this->Form->input('guar_last_name', array('id' => 'guar_last_name')); ?>

			</td>
			<td>&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Name Type');?> 
			</td>
			<td width="30%">
				<?php echo $this->Form->input('guar_name_type', array('empty'=>'Please Select','options'=>$name_type,'id' => 'guar_name_type')); ?>
			</td>
			<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Sufix');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_suffix', array('options'=>array(""=>__('Please Select Type'),"CSJ"=>__('C.S.J. Sisters of St. Joseph'),"DC"=>__('D.C. Doctor of Chiropractic'),"DD"=>__('D.D. Doctor of Divinity'),"DDS"=>__('D.D.S. Doctor of Dental Surgery'),"DMD"=>__('D.M.D. Doctor of Dental Medicine'),"DO"=>__('D.O. Doctor of Osteopathy'),"DVM"=>__('D.V.M. Doctor of Veterinary Medicine'),"EdD"=>__('Ed.D. Doctor of Education'),"II"=>__('II The Second'),"III"=>__('III The Third'),"IV"=>__('IV The Fourth'),"JD"=>__('J.D. Juris Doctor'),"Jr"=>__('Jr. Junior'),"LLD"=>__('LL.D. Doctor of Laws'),"Ltd"=>__('Ltd. Limited'),"MD"=>__('M.D. Doctor of Medicine ')),'class' => 'textBoxExpnd','id' => 'guar_suffix')); ?>
			</td>
			<td>&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Gender');?> 
			</td>
			<td width="30%">
				<?php  
									echo $this->Form->input('guar_sex', array('options'=>array(""=>__('Please Select Gender'),"Male"=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')),'id' => 'guar_sex')); ?>
			</td>
		</tr>
		
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace">

				<?php echo __('Relationship');?> 

			</td>
			<td>
				<?php echo $this->Form->input('guar_relation', array('empty'=>__('Select'),'options'=>$relation,'id' => 'guar_relation','style'=>'width:230px')); ?>
			</td>
		</tr>

		<tr>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo __('Address Line 1');?>
			</td>
			<td width="30%">
				<?php echo $this->Form->input('guar_address1', array('class' => 'textBoxExpnd','id' => 'guar_add1')); ?>
			</td>
			<td width="30">&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo('Address Line 2');?>
			</td>
			<td width="30%">
				<?php echo $this->Form->input('guar_address2', array('class' => 'textBoxExpnd','id' => 'guar_add2')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('City/Location');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_city', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'guar_city')); ?>
			</td>

			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('State/Region');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_state', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'guar_state')); ?>
			</td>
		</tr>
		<tr>
		<td class="tdLabel" id="boxSpace" valign="top">
				<?php echo __('Country');?>
			</td>
			<td valign="top">
				<?php echo $this->Form->input('guar_country', array('class' => 'custom[customzipcode] textBoxExpnd','id'=>'guar_country')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace" valign="top">
				<?php echo __('Zip');?>
			</td>
			<td valign="top">
				<?php echo $this->Form->input('guar_zip', array('class' => 'custom[customzipcode] textBoxExpnd','id' => 'guar_zip','MaxLength'=>'4')); ?>
			</td>
			
		</tr>
		<tr>
		<td class="tdLabel" id="boxSpace" valign="top">
				<?php echo __('Address type');?>
			</td>
			<td valign="top">
				<?php echo $this->Form->input('guar_address_type', array('empty'=>__('Select'),'options'=>$address_types,'id' => 'guar_address_type','style'=>'width:230px'));  ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Telecoummnication US code.');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_tele_code', array('empty'=>__('Select'),'options'=>$telecommunications,'id' => 'guar_tele_code','style'=>'width:230px'));  ?>
				
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo('Telecoummnication Equipment code.');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_equi_code',  array('empty'=>__('Select'),'options'=>$telecommunication_equipment_types,'id' => 'guar_equi_code','style'=>'width:230px')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Phone No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_phone', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'guar_phone','MaxLength'=>'10')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo('Mobile No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_mobile', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'guar_mobile','MaxLength'=>'10')); ?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Email Address');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_email', array('class' => 'validate["",custom[email]] textBoxExpnd','id' => 'guar_email')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Country Code');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_contry_code', array('class' => 'validate["",custom[customfax]] textBoxExpnd','id' => 'guar_contry_code','MaxLength'=>'10')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Area/City code');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_area_code', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'guar_areacode','MaxLength'=>'10')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo('Local Number');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_localno', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'guar_localno','MaxLength'=>'10')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Extension');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_extension', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'guar_Extension','MaxLength'=>'10')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo('Any Text');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_text1', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'guar_text1','MaxLength'=>'10')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Telecoummnication Use code.');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_tele_code1', array('empty'=>__('Select'),'options'=>$telecommunications,'id' => 'guar_tele_code1','style'=>'width:230px')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo('Telecoummnication Equipment code.');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_equi_code1',  array('empty'=>__('Select'),'options'=>$telecommunication_equipment_types,'id' => 'guar_equi_code1','style'=>'width:230px')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo __('Email');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_email1', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'guar_email1','MaxLength'=>'10')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo('Any Text');?>
			</td>
			<td>
				<?php echo $this->Form->input('guar_text2', array('class' => 'validate["",custom[phone]] textBoxExpnd','id' => 'guar_text2','MaxLength'=>'10')); ?>
			</td>
		</tr>
		


	</table>
	<!-- ------End of the Demograghic code------------------- -->
	<!-- Links to Records end here -->
	<p class="ht5"></p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">
				<?php echo __('Medical Information');?> 
				
			</th>
		</tr>


		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxSpace">
				<?php echo('Visit Type');?>
			</td>
			<td width="30%"><table width="100%" cellpadding="0"
					cellspacing="0" border="0">
					<tr>
						<td>
							<?php echo $this->Form->input('phvs_visit_id', array('empty'=>__('Please Select Visit Type'),'options'=>$phvsVisit,'class' => 'textBoxExpnd','id' => 'phvs_visit_id')); ?>
						</td>
						
					</tr>
				</table></td>
			<td width="">&nbsp;</td>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo('Observation');?> 
			</td>
			<td>
				<?php echo $this->Form->input('observation_identifier_id', array('empty'=>__('Please Select Observation'),'options'=>$obs_id,'class' => 'textBoxExpnd','id' => 'observation_identifier_id')); ?>
			</td>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo('Expected Problem');?>
			</td>
			<td>
				<?php echo $this->Form->input('phvs_icd9cm_id', array('empty'=>__('Please Select Problem'),'options'=>$icdOptions,'class' => 'textBoxExpnd','id' => 'phvs_icd9cm_id')); ?>
			</td>
			<td>&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">
				<?php echo('Visit Purpose');?> 
			</td>
			<td width="30%">
				<?php echo $this->Form->input('visit_purpose', array('type'=>'textarea','rows'=>'1','cols'=>'5','class' => 'textBoxExpnd','id' => 'visit_purpose')); ?>
			</td>
		</tr>
		
	</table>
	
	<!-- ------End of the other code------------------- -->
	<!-- Links to Records end here -->
	<p class="ht5"></p>
	<!-- Patient other record start here -->
	<!--  Aditya -->

	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">
				<?php echo __('Other Information');?>
			</th>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace">
				<?php echo('Next of Kin');?>
			</td>
			<td>
				<?php echo $this->Form->input('patient_owner', array('class' => 'textBoxExpnd','id' => 'patient_owner')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">
				<?php echo('Emergency Contact No.');?>
			</td>
			<td>
				<?php echo $this->Form->input('asst_phone', array('class' => 'textBoxExpnd','id' => 'asst_phone')); ?>
			</td>
		</tr>


	</table>
	<!-- ------End of the other code------------------- -->
	<!-- Links to Records end here -->
	<p class="ht5"></p>

	

	<div style="text-align: left;">
		<?php 
					   		 echo $this->Form->input('admission_type',array('id'=>'admission_type','type'=>'select','options'=>Array('OPD'=>'OPD'),'class'=>'validate[required,custom[mandatory-select]]'));
//echo $this->Form->input('admission_type',array('id'=>'admission_type','type'=>'text','value'=>'OPD','class'=>'validate[required,custom[mandatory-select]]'));
					   ?>
		<input type="submit" id="goforpatientbyotherway"
			value="Submit And Register" class="blueBtn" style="text-align: left;">
	</div>
	<div class="btns" style="margin-top: -52px;">
		<?php 
							if(isset($redirectTo)){
								echo $this->Html->link(__('Cancel', true),array('controller'=>'nursings','action' => 'search/'), array('escape' => false,'class'=>'grayBtn'));
							} else {
								echo $this->Html->link(__('Cancel', true),array('controller'=>'persons','action' => 'search/'), array('escape' => false,'class'=>'grayBtn'));
							}
							echo $this->Form->hidden('ADT.curdate',array('id'=>'curdate'));
							
						?>

	<!-- <input class="blueBtn" type="submit" value="Submit" id="submit1"> -->	
	</div>
	<?php //EOF new form design ?>
</div>
<?php echo $this->Form->end(); ?>

<script>
/*
* 
*Functions for HL7
*/$('#goforpatientbyotherway')
.click(
function (){
	/* code to convert available date
	var now = $('#note_date').val();
	var curdate = Date.parse(now);
	var availdate = new Date(curdate);
		*/
		var curdate = new Date();
	$("#curdate").val(curdate);
	});
/*-------------------------------------------*/
	jQuery(document)
			.ready(
					function() {

						// binds form submission and fields to the validation engine
						jQuery("#personfrm").validationEngine();
						$('#submit,#submit1')
								.click(
										function() {
											jQuery("#admission_type")
													.removeClass(
															'validate[required,custom[mandatory-select]]');
											$("#admission_type")
													.validationEngine(
															"hidePrompt");
											var validatePerson = jQuery(
													"#personfrm")
													.validationEngine(
															'validate');
											if (validatePerson) {
												$(this).css('display', 'none');
											}
										});

						$('#goforpatientbyotherway')
								.click(
										function() {
											jQuery("#admission_type")
													.addClass(
															'validate[required,custom[mandatory-select]]');
											var input = $("<input>")
													.attr("type", "hidden")
													.attr("name",
															"data[Person][submitandregister]")
													.val("1");
											$('#personfrm').append($(input));
											$('#personfrm').submit();

										});

						//BOF web cam script
						$('#camera')
								.click(
										function() {
											$
													.fancybox({
														'autoDimensions' : false,
														'width' : '85%',
														'height' : '90%',
														'autoScale' : true,
														'transitionIn' : 'fade',
														'transitionOut' : 'fade',
														'type' : 'iframe',
														'href' : '<?php echo $this->Html->url(array( "action" => "webcam")); ?>'
													});
										});
						//EOF web cam script

						//on realtion select
						$('#insurance_relation_to_employee').change(function() {
							$('#insurance_esi_suffix').val($(this).val());
							$('#corpo_esi_suffix').val('');
							$('#corpo_relation_to_employee').val('');
						});

						$('#corpo_relation_to_employee').change(function() {
							$('#insurance_esi_suffix').val('');
							$('#corpo_esi_suffix').val($(this).val());
							$('#insurance_relation_to_employee').val('');
						});

						$('#doctor_id')
								.change(
										function() {
											$
													.ajax({
														url : "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"
																+ "/"
																+ $(this).val(),
														context : document.body,
														success : function(data) {
															$('#department_id')
																	.val(data);
														}
													});
										});

						$("#dob")
								.datepicker(
										{
											showOn : "button",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '-73:+0',
											maxDate : new Date(),
											dateFormat:'<?php echo $this->General->GeneralDate();?>',
										});
						$("#gau_dob")
						.datepicker(
								{
									showOn : "button",
									buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly : true,
									changeMonth : true,
									changeYear : true,
									yearRange : '-73:+0',
									maxDate : new Date(),
									dateFormat:'<?php echo $this->General->GeneralDate();?>',
								});
						$("#dob2")
						.datepicker(
								{
									showOn : "button",
									buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly : true,
									changeMonth : true,
									changeYear : true,
									yearRange : '-50:+50',
									maxDate : new Date(),
									dateFormat:'<?php echo $this->General->GeneralDate();?>',
								});
						
						
						
						$("body")
								.click(
										function() {
											var dateofbirth = $("#dob").val();
											if (dateofbirth != "") {
												var currentdate = new Date();
												var splitBirthDate = dateofbirth
														.split("/");
												var caldateofbirth = new Date(
														splitBirthDate[2]
																+ "/"
																+ splitBirthDate[1]
																+ "/"
																+ splitBirthDate[0]
																+ " 00:00:00");
												var caldiff = currentdate
														.getTime()
														- caldateofbirth
																.getTime();
												var calage = Math
														.floor(caldiff
																/ (1000 * 60 * 60 * 24 * 365.25));
												$("#age").val(calage);
											}

										});

						$('#city')
								.autocomplete(
										"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","City","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
										{
											width : 250,
											selectFirst : true
										});
						$('#district')
								.autocomplete(
										"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","District","name",'null',"no","no","admin" => false,"plugin"=>false)); ?>",
										{
											width : 250,
											selectFirst : true
										});
						$('#state')
								.autocomplete(
										"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","State","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
										{
											width : 250,
											selectFirst : true
										});

						$('#goforpatient').click(
								function() {
									var input = $("<input>").attr("type",
											"hidden").attr("name",
											"data[Person][submitandregister]")
											.val("1");
									$('#personfrm').append($(input));
									$('#personfrm').submit();
								});

						$('#goforpatientbyotherway').click(
								function() {
									var input = $("<input>").attr("type",
											"hidden").attr("name",
											"data[Person][submitandregister]")
											.val("1");
									$('#personfrm').append($(input));
									$('#personfrm').submit();
								});
						// disable 5 text boxes when card is selected //
						//to hide and show insurance and corporate block.
						$('#paymentCategoryId')
								.live(
										'change',
										function() {
											if ($('#paymentCategoryId').val() == 1) {
												$('#showwithcardInsurance')
														.hide('fast');
												$('#showwithcard').show('slow');
												$(
														'#showwithcardInsurance :input')
														.attr('disabled', true);
												$('#showwithcard :input').attr(
														'disabled', false);
											} else if ($('#paymentCategoryId')
													.val() == 2) {
												$('#showwithcard').hide('fast');
												$('#showwithcardInsurance')
														.show('slow');
												$(
														'#showwithcardInsurance :input')
														.attr('disabled', false);
												$('#showwithcard :input').attr(
														'disabled', true);
											} else {
												$('#showwithcard').hide();
												$('#showwithcardInsurance')
														.hide();
											}
										});

						$('#paymentType').change(function() {
							if ($('#paymentType').val() == "cash") {
								$('#showwithcard').hide();
								$('#showwithcardInsurance').hide();
							}
						});

						//fnction to disable one option
						$('.emp_id')
								.live(
										'keyup change',
										function() {
											if ($(this).val() != '') {
												$('.emp_id').not(this).attr(
														'disabled', true);
												if ($(this).attr('id') == 'insurance_executive_emp_id_no') {
													$('#insurance_esi_suffix')
															.val('');
												} else if ($(this).attr('id') == 'insurance_non_executive_emp_id_no') {
													$('#insurance_esi_suffix')
															.val(
																	$(
																			'#insurance_relation_to_employee')
																			.val());
												}
												if ($(this).attr('id') == 'corpo_executive_emp_id_no') {
													$('#corpo_esi_suffix').val(
															'');
												} else if ($(this).attr('id') == 'corpo_non_executive_emp_id_no') {
													$('#corpo_esi_suffix')
															.val(
																	$(
																			'#corpo_relation_to_employee')
																			.val());
												}
											} else {
												$('.emp_id').attr('disabled',
														false);
											}
										});
					});

	//FUNCTION TO ADD TEXT BOX ELEMENT
	var intTextBox = 0;
	var intcheckBox = 0;
	var intstatus = 0;
	var intcomments = 0;
	function addElement() {
		intTextBox = intTextBox + 1;
		intcheckBox = intcheckBox + 1;
		intstatus = intstatus + 1;
		intcomments = intcomments + 1;
		var contentID = document.getElementById('content');
		var contentID1 = document.getElementById('content1');
		var contentID2 = document.getElementById('content2');
		var contentID3 = document.getElementById('content3');
		
		
		var newCBDiv = document.createElement('td');
		var newTBDiv = document.createElement('td');
		var newSTATUSDiv = document.createElement('td');
		var newCOMMENTDiv = document.createElement('td');

		newTBDiv.setAttribute('id', 'strText' + intTextBox);
		newCBDiv.setAttribute('id', 'strText' + intcheckBox);
		newSTATUSDiv.setAttribute('id', 'strText' + intstatus);
		newCOMMENTDiv.setAttribute('id', 'strText' + intcomments);

		newTBDiv.innerHTML =
				"<td><select id='" + intTextBox + "' name='" + intTextBox + "'><option>Select</option><option>Mother</option><option>Father</option><option>Borther</option><option>Sister</option></select></td> ";
		newCBDiv.innerHTML = 
				 "<input type='text' id='" + intTextBox + "' name='" + intTextBox + "'/>";
		newSTATUSDiv.innerHTML = 
				"<select id='" + intTextBox + "' name='" + intTextBox + "'><option>Select</option><option>Deceased</option><option>Living</option><option>Negative</option><option>Positive</option><option>Not Present</option></select> ";
		newCOMMENTDiv.innerHTML = 
				"<input type='text' id='" + intTextBox + "' name='" + intTextBox + "'/>";

		contentID.appendChild(newTBDiv);
		contentID1.appendChild(newCBDiv);
		contentID2.appendChild(newSTATUSDiv);
		contentID3.appendChild(newCOMMENTDiv);
	}

	//FUNCTION TO REMOVE TEXT BOX ELEMENT
	function removeElement() {
		if (intTextBox != 0 && intcheckBox != 0 && intstatus != 0) {
			var contentID = document.getElementById('content');
			contentID.removeChild(document.getElementById('strText'
					+ intTextBox));
			contentID.removeChild(document.getElementById('strText'
					+ intcheckBox));
			contentID.removeChild(document
					.getElementById('strText' + intstatus));
			contentID.removeChild(document.getElementById('strText'
					+ intcomments));
			intTextBox = intTextBox - 1;
			intcheckBox = intcheckBox - 1;
			intstatus = intstatus - 1;
			intcomments = intcomments - 1;
		}
	}
	 // check not demographic
	$( "#ckeckDemo" ).click(function(){
		if($( "#ckeckDemo" ).is(':checked') == true) {
					 $( "#language" ).val('173');
                     $( "#ethnicity" ).val('Denied to Specific');
                    $( "#race" ).val('2131-0');
                    document.getElementById("language").disabled=true;
                    document.getElementById("ethnicity").disabled=true;
                    document.getElementById("race").disabled=true;
                     // $("#bed_id").append( "<option value=''>Please Select</option>" );
                    } 
		else{
			 
				 $( "#language" ).val('select');
                 $( "#ethnicity" ).val('select');
                $( "#race" ).val('select');
                document.getElementById("language").disabled=false;
                document.getElementById("ethnicity").disabled=false;
                document.getElementById("race").disabled=false;
                 // $("#bed_id").append( "<option value=''>Please Select</option>" );
                
		}
	}); 
	
	// copy to guarantor
	$( "#ckeckGua" ).click(function(){
		if($( "#ckeckGua" ).is(':checked') == true) {
			
                     // var currentdate = new Date();
                     // var showdate ="hello";
                     var initials=document.getElementById('initials').value;
                     var gau_first_name = document.getElementById('first_name').value;
                    var gau_middle_name = document.getElementById('middle_name').value;
                     var gau_last_name = document.getElementById('last_name').value;
                    var gau_dob= document.getElementById('dob').value;
                    var gau_sex = document.getElementById('sex').value;
                  
                     var gau_ssn = document.getElementById('ssn').value;
                    var gau_plot_no = document.getElementById('plot_no').value;
                     var gau_landmark = document.getElementById('landmark').value;
                   var gau_city = document.getElementById('city').value;
                    var gau_state = document.getElementById('customstate').value;
                    var gau_pin_Code = document.getElementById('pinCode').value;
                  var gau_work = document.getElementById('work').value;
                var gau_home_phone = document.getElementById('home_phone').value;
                   var gau_mobile = document.getElementById('mobile').value;
                   var gau_email = document.getElementById('email').value;
                   var gau_fax = document.getElementById('fax').value;
                     
                     
                     
                     
                   //  alert(gau_first_name);
                     //alert(initials);
                    // $( "#language" ).val('173');
                      $( "#initials1" ).val(initials);
                     $( "#gau_first_name" ).val(gau_first_name);
                      $( "#gau_middle_name" ).val(gau_middle_name);
                     $( "#gau_last_name" ).val(gau_last_name);
                     $( "#gau_dob" ).val(gau_dob);
                     $( "#gau_sex" ).val(gau_sex);
                    $( "#gau_ssn" ).val(gau_ssn);
                     $( "#gau_plot_no" ).val(gau_plot_no);
                     $( "#gau_landmark" ).val(gau_landmark);
                     $( "#gau_city" ).val(gau_city);
                     $( "#gau_state" ).val(gau_state);
                     $( "#gau_pin_Code" ).val(gau_pin_Code);
                      $( "#gau_work" ).val(gau_work);
                      $( "#gau_home_phone" ).val(gau_home_phone);
                   $( "#gau_mobile" ).val(gau_mobile);
                      $( "#gau_email" ).val(gau_email);
                     $( "#gau_fax" ).val(gau_fax);
                      
                      
                    } 
	}); 
	
	$( "#ckeckGuardian" ).click(function(){
		if($( "#ckeckGuardian" ).is(':checked') == true) {
			
                     // var currentdate = new Date();
                     // var showdate ="hello";
                     var initials=document.getElementById('initials').value;
                    
                    var guardian_middle_name = document.getElementById('middle_name').value;
                     var guardian_last_name = document.getElementById('last_name').value;
                    var guardian_dob= document.getElementById('dob').value;
                    var guardian_sex = document.getElementById('sex').value;
                     var guardian_ssn = document.getElementById('ssn').value;
                    var guardian_plot_no = document.getElementById('plot_no').value;
                     var guardian_landmark = document.getElementById('landmark').value;
                   var guardian_city = document.getElementById('city').value;
                    var guardian_state = document.getElementById('customstate').value;
                    var guardian_pin_Code = document.getElementById('pinCode').value;
                  var guardian_work = document.getElementById('work').value;
                var guardian_home_phone = document.getElementById('home_phone').value;
                   var guardian_mobile = document.getElementById('mobile').value;
                   var guardian_email = document.getElementById('email').value;
                   var guardian_fax = document.getElementById('fax').value;
                     
                     
                     
                     
                   //  alert(gau_first_name);
                     //alert(initials);
                    // $( "#language" ).val('173');
                      $( "#initials2" ).val(initials);
                      $( "#guardian_first_name" ).val(guardian_first_name);
                      $( "#guardian_middle_name" ).val(guardian_middle_name);
                     $( "#guardian_last_name" ).val(guardian_last_name);
                     $( "#guardian_dob" ).val(guardian_dob);
                      $( "#guardian_sex" ).val(guardian_sex);
                    $( "#guardian_ssn" ).val(guardian_ssn);
                     $( "#guardian_plot_no" ).val(guardian_plot_no);
                     $( "#guardian_landmark" ).val(guardian_landmark);
                     $( "#guardian_city" ).val(guardian_city);
                     $( "#guardian_state" ).val(guardian_state);
                     $( "#guardian_pin_Code" ).val(guardian_pin_Code);
                      $( "#guardian_work" ).val(guardian_work);
                      $( "#guardian_home_phone" ).val(guardian_home_phone);
                   $( "#guardian_mobile" ).val(guardian_mobile);
                      $( "#guardian_email" ).val(guardian_email);
                     $( "#guardian_fax" ).val(guardian_fax);
                      
                      
                    } 
	}); 
	
	//FUNCTION TO ADD socail history ELEMENT
	/* var intTextBox = 0;
	var intcheckBox = 0;
	var intstatus = 0;
	var intcomments = 0;
	function addElement() {
		intTextBox = intTextBox + 1;
		intcheckBox = intcheckBox + 1;
		intstatus = intstatus + 1;
		intcomments = intcomments + 1;
		var contentID = document.getElementById('content');
		var newCBDiv = document.createElement('td');
		var newTBDiv = document.createElement('td');
		var newSTATUSDiv = document.createElement('td');
		var newCOMMENTDiv = document.createElement('td');

		newTBDiv.setAttribute('id', 'strText' + intTextBox);
		newCBDiv.setAttribute('id', 'strText' + intcheckBox);
		newSTATUSDiv.setAttribute('id', 'strText' + intstatus);
		newCOMMENTDiv.setAttribute('id', 'strText' + intcomments);

		newTBDiv.innerHTML = "Relative"
				+ ":<select id='" + intTextBox + "' name='" + intTextBox + "'><option>Select</option><option>Mother</option><option>Father</option><option>Borther</option><option>Sister</option></select> ";
		newCBDiv.innerHTML = "Problem"
				+ ":<input type='text' id='" + intTextBox + "' name='" + intTextBox + "'/>";
		newSTATUSDiv.innerHTML = "Stauts"
				+ ":<select id='" + intTextBox + "' name='" + intTextBox + "'><option>Select</option><option>Deceased</option><option>Living</option><option>Negative</option><option>Positive</option><option>Not Present</option></select> ";
		newCOMMENTDiv.innerHTML = "Comments"
				+ ":<input type='text' id='" + intTextBox + "' name='" + intTextBox + "'/>";

		contentID.appendChild(newTBDiv);
		contentID.appendChild(newCBDiv);
		contentID.appendChild(newSTATUSDiv);
		contentID.appendChild(newCOMMENTDiv);
	}
*/

	// To call the patient registration page on clicking submit and register.

	function getRedirected() {

	}
</script>
