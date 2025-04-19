<?php
     echo $this->Html->script(array('jquery.autocomplete','jquery.autocomplete.js'));   
	 echo $this->Html->script(array('jquery.fancybox-1.3.4'));
	 echo $this->Html->css('jquery.autocomplete.css');
     echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));?>
<style>
select.textBoxExpnd {
    width:66% !important;
	margin-top:5px;
	
}
/*code by dinesh tawade*/
.textBoxExpnd {
   
    width: 85%;
}
select.textBoxExpnd{width:66%!important; margin-top:5px;}
label {
    color: #000 !important;
    float: left;
    font-size: 13px;
    margin-right: 10px;
    padding-top: 3px;
    text-align: right;
    width: 37px;
}
.formFull td {
    width: 0%;
}
</style>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('UID Patient Details', true); ?></h3>
<!-- <span> <?php //echo $this->Html->link(__('Search UID Patient'),array('action' => 'search'), array('escape' => false,'class'=>'blueBtn')); ?></span> -->	
</div>
<?php echo $this->Form->create('Person',array('type' => 'file','name'=>'register','id'=>'personfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); 
	echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));
?>
<?php if($this->data){
			$personID=$this->data['Person']['id']; // debug($personID); 
			$lookupName=$this->data['Person']['full_name']; //debug($lookupName);exit;
			$patientUid=$this->data['Person']['patient_id'];
			$age=$this->data['Person']['age'];
			$sex=strtolower($this->data['Person']['sex']);
		
	}
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
		
	  <div class="inner_left" style="height: auto;padding: 0 20px; width: 72%;"> 
			<?php //BOF new form design ?>
			<!-- form start here -->
					<div class="btns">

					<?php echo __("Type");?><font color="red">*</font>
                     	<?php 
                     	
                     	$website=$this->Session->read("website.instance"); 
               			if($website=='kanpur'){
							echo $this->Form->input('admission_type',array('id'=>'admission_type1','type'=>'select','options'=>Array('IPD'=>'IPD','OPD'=>'OPD','RAD'=>'RADIOLOGY', 'emergency'=>'EMERGENCY','LAB'=>'LABORATORY'),'class'=>'validate[required,custom[mandatory-select]] admission_type'));
						}else{
                         	echo $this->Form->input('admission_type',array('id'=>'admission_type1','type'=>'select','options'=>Array('OPD'=>'OPD','IPD'=>'IPD','RAD'=>'RADIOLOGY', 'emergency'=>'EMERGENCY','LAB'=>'LABORATORY','prospect'=>'PROSPECT'),'class'=>'validate[required,custom[mandatory-select]] admission_type','empty'=>'Please Select'));
                        }  ?>
                       <input type="submit" id="submitandReg" value="Save And Next" class="blueBtn submitandReg" style="text-align:left;"> 
                       <?php if($website == 'lifespring'){?>	 
						   <input class="blueBtn" type="submit" value="Submit" id="submit1">
						   <?php }?> 
						<?php 
							if(isset($redirectTo)){
								echo $this->Html->link(__('Cancel', true),array('controller'=>'nursings','action' => 'search/'), array('escape' => false,'class'=>'blueBtn','pre'=>false));
							} else {
								echo $this->Html->link(__('Cancel', true),array('controller'=>'persons','action' => 'searchPerson'), array('escape' => false,'class'=>'blueBtn','pre'=>false));
							}
						?>
					
                   </div>
                   <div class="clr"></div>
				  
                   <!-- Patient Information start here -->
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5"><?php echo __("UID Patient Information") ; ?></th>
                      </tr>
                      <tr>
							<td width="20%" class="tdLabel" id="boxSpace"><?php echo __('Is Staff');?></td>
							<td width="30%"><?php echo $this->Form->input('Person.is_staff_register', array('label'=>false,'type'=>'checkbox','class' => 'isStaff','id' => 'isStaff'));?></td>
					 </tr> 
					<tr id="staff" style="display:none">
						<td width="20%" class="tdLabel" id="boxSpace"><?php echo __('Staff Name');?></td>
						<td width="27%"><?php echo $this->Form->input('Person.staff_name', array('label'=>false,'type'=>'text','class' => 'staffName','id' => 'staffName'));?></td>
						<td valign="middle" class="tdLabel" id="boxSpace"></td>
						<td valign="middle" class="tdLabel" id="boxSpace"></td>
					</tr> 
                      <tr id="notStaff">
                        <td width="17%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("First Name");?>
                        <font color="red">*</font>
                        </td>
        
                           <td width="27%">
                           <table width="100%" cellpadding="0" cellspacing="0" border="0">
	                          <tr>
	                          
	                          	<td><?php echo $this->Form->input('initial_id', array('empty'=>__('Select'),'options'=>$initials,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'initials','style'=>'width:80px')); ?></td>
	                           <td>                            	 
<?php echo $this->Form->input('first_name', array('class' => 'validate[required,custom[name],custom[onlyLetterSp],custom[noSpace]] textBoxExpnd','id' => 'first_name','autocomplete'=>'off')); ?>

<script>
$.validationEngineLanguage.allRules["noSpace"] = {
    "regex": /^[^\s]*$/,
    "alertText": "Spaces are not allowed."
};

</script>                         
	                          </tr>
	                        </table>
                        </td> 
                        	<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Middle Name');?>
		</td> 
	<td>
    <?php echo $this->Form->input('Person.middle_name', array(
        'label' => false,
        'class' => 'textBoxExpnd',
        'id' => 'middle_name',
        'size' => '40',
        'autocomplete' => 'off',
        'oninput' => "this.value = this.value.replace(/\\s/g, '')"
    )); ?>
</td>
					
                      </tr>
                        <tr>
					  	 <td valign="middle" class="tdLabel" id="boxSpace" width="19%"><?php echo __('Last Name');?>
						 <font color="red">*</font></td>
	                        <td width="26%">
	                        	<?php echo $this->Form->input('last_name', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterSp]] textBoxExpnd','id' => 'last_name','autocomplete'=>'off')); ?>
	                        </td> 
	
					  	</tr>
                      <!--code by dinesh tawade-->
                      	<tr>
                    <td class="tdLabel"><?php echo __('Emergency Contact Name')?><font color="red">*</font></td>
                    <td><?php echo $this->Form->input('Person.next_of_kin_name', array('class'=>' validate[required,custom[name],custom[onlyLetterSp]] textBoxExpnd','type'=>'text','label'=>false,'id' => 'next_of_kin_name','autocomplete'=>"off"));?></td>
                    <td width="20%" class="tdLabel" id="boxSpace"><?php echo __('Emergency Contact Mobile');?><font color="red">*</font></td>
                    <td width="30%"><?php echo $this->Form->input('Person.next_of_kin_mobile', array('label'=>false,'type'=>'text','class' => ' validate[required,custom[phone,minSize[10],onlyNumber]] textBoxExpnd','maxlength'=>'10','id' => 'next_of_kin_mobile','autocomplete'=>"off"));?></td>
                </tr>
                
              <tr>
                    <td class="tdLabel"><?php echo __('Second Emergency Contact Name')?></td>
                    <td><?php echo $this->Form->input('Person.second_next_of_kin_name', array(
                        'class' => ' validate[custom[name],custom[onlyLetterSp]] textBoxExpnd', 
                        'type' => 'text', 'label' => false,'id' => 'next_of_kin_name','autocomplete' => "off")); ?></td>
                    <td width="20%" class="tdLabel" id="boxSpace"><?php echo __('Second Emergency Contact Mobile');?></td>
                    <td width="30%"><?php echo $this->Form->input('Person.second_next_of_kin_mobile', array('label' => false,'type' => 'text','class' => ' validate[custom[phone,minSize[10],onlyNumber] textBoxExpnd',
                        'maxlength' => '10','id' => 'next_of_kin_mobile','autocomplete' => "off" )); ?></td>
                </tr>
                
                <!--end by dinesh tawade-->
                      <tr>                       
							<td class="tdLabel" id="boxSpace"><?php echo __('Date of Birth');?><font color="red">*</font></td>
							<td>
								<?php 
									echo $this->Form->input('Person.age_year', array('div'=>false,'type'=>'text','style'=>'width:23px;float:left;','maxLength'=>'3','placeHolder'=>'  Y',
											'size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] ','id' => 'age','label'=>false,'autocomplete'=>"off"));
									echo $this->Form->input('Person.age_month', array('div'=>false,'type'=>'text','style'=>'width:23px;float:left;','maxLength'=>'2','placeHolder'=>'  M',
											'size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] ','id' => 'ageMonth','label'=>false,'autocomplete'=>"off"));
									echo $this->Form->input('Person.age_day', array('div'=>false,'type'=>'text','style'=>'width:23px;float:left;','maxLength'=>'2','placeHolder'=>'  D',
											'size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] ','id' => 'ageDay','label'=>false,'autocomplete'=>"off"));

                                   echo $this->Form->input('dob', array('label'=>'DOB','type'=>'text','style'=>'width:97px;','readonly'=>'readonly','size'=>'20','class' => 'validate[optional,custom[mandatory-select]] textBoxExpnd','id' => 'dob'));
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
                       			echo $this->Form->input('upload_image', array('type'=>'file','id' => 'patient_photo', 'class'=>"",'style'=>'float:left;width: 66%','label'=> false,
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
	                        <td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Quarter No./Plot No.');?></td>
	                        <td width="30%"><?php echo $this->Form->input('plot_no', array('class' => 'textBoxExpnd','id' => 'plot_no')); ?></td>
	                   
                            <td width="19%" class="tdLabel" id="boxSpace"><?php echo('Ward');?></td>
	                        <td width="30%"><?php echo $this->Form->input('landmark', array('class' => 'textBoxExpnd','id' => 'patientFile')); ?></td>
	                  </tr>
                       <tr>
                             <td class="tdLabel" id="boxSpace" valign="top"><?php echo __('Pin Code');?></td>
	                       	 <td valign="top"><?php echo $this->Form->input('pin_code', array('class' => 'validate[optional,custom[onlyNumber,minSize[6]]] textBoxExpnd','id' => 'pinCode','MaxLength'=>'6')); ?></td>
	               
                            <td class="tdLabel" id="boxSpace"><?php echo __('Panchayat');?></td>
	                        <td><?php echo $this->Form->input('taluka', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'taluka')); ?></td>
	                  </tr>
                      <tr>
                             <td class="tdLabel" id="boxSpace"><?php echo __('State');?></td>
	                       	 <td><?php echo $this->Form->input('stateName', array('class' => 'validate[required,custom[mandatory-enter] textBoxExpnd','id' => 'stateName'));
	                       			echo $this->Form->hidden('state',array('id'=>'stateId')) ?></td>
                            <!--added by dinesh tawade-->
                            <td class="tdLabel" id="boxSpace"><?php echo __('Relationship Manager');?></td>
							<td>
								<select class="textBoxExpnd validate[required,custom[mandatory-select]]" name="data[Person][relationship_manager]" id="relationship_manager">
									<option value=""><?php echo __('Please Select'); ?></option>
									<?php foreach ($marketing_teams as $key => $value): ?>
										<option value="<?= h($key); ?>"><?= h($value); ?></option>
									<?php endforeach; ?>
								</select>
							</td>
							<script>
								$(document).ready(function() {
									$('#submit1').click(function(e) {
										if ($('#relationship_manager').val() === '') {
											e.preventDefault();
											alert('Please select a Relationship Manager.');
										}
									});
								});
							</script>
                        </tr>
                           <!--  <td class="tdLabel" id="boxSpace"><?php echo __('District');?></td>
	                        <td><?php echo $this->Form->input('district', array('class' => 'validate[required,custom[mandatory-enter] textBoxExpnd','id' => 'district')); ?></td> -->
                               
                        </tr>
                         <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('City/Town');?></td>
	                         <td><?php echo $this->Form->input('city', array('class' => 'validate[required,custom[mandatory-enter] textBoxExpnd','id' => 'city')); ?></td>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Nationality');?></td>
	                        <td><?php echo $this->Form->input('nationality', array('class' => 'textBoxExpnd','id' => 'email','Value'=>'Indian')); ?></td>
	                   </tr>
	                   <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Home Phone No.');?></td>
	                        <td><?php echo $this->Form->input('home_phone', array('class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'home_phone','MaxLength'=>'10')); ?></td>
	                       
	                        <td class="tdLabel" id="boxSpace"><?php echo('Mobile No.');?><font color="red">*</font></td>
	                        <td><?php echo $this->Form->input('mobile', array('class' => 'validate[required,custom[phone,minSize[10],onlyNumber]]  textBoxExpnd','id' => 'mobile','MaxLength'=>'10')); ?></td>
	                      </tr>
	                      
	                      <tr>
	                       
                                <td class="tdLabel" id="boxSpace">Temporary Registration</td>
                                <td><?php echo $this->Form->input('is_paragon', array('label'=>false,'type'=>'checkbox','class' => 'fake','id' => 'fake'));?>
                                </td>
		                  	<td>&nbsp;</td>
			                <td width="30%"><?php echo $this->Form->input('Person.no_number', array('label'=>false,'type'=>'checkbox','class' => 'no_number','id' => 'no_number'));
			                echo __('Patient does not have a mobile number');?></td>
			               
			                
		                  </tr>
		                  <!--code by dinesh tawade-->
		                   <tr>
						<td class="tdLabel" id="boxSpace">Consultation Own Patient</td>
						<td>
							<?php echo $this->Form->input('Person.own_patient', array('label' => false, 'type' => 'checkbox', 'class' => 'fake', 'id' => 'own_patient', 'value' => '1')); ?>
							<?php echo $this->Form->hidden('Person.own_patient_hidden', array('id' => 'own_patient_hidden', 'value' => '0')); ?>
						</td>
						<script>
							$('#own_patient').change(function() {
								if ($(this).is(':checked')) {
									$('#own_patient_hidden').val('1');
								} else {
									$('#own_patient_hidden').val('0');
								}
							});
						</script>
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
					   <?php  $website=$this->Session->read('website.instance');
                 if(($website!="kanpur") && ($website!="vadodara") &&($website!="hope")){?>
                 <p class="ht5"></p>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	                   	  	<tr>
		                      	<th colspan="5"><?php echo __('Sponsor Information');?></th>
		                    </tr>
		                    <tr>
		                        <td width="19%" class="tdLabel"  id="boxSpace" valign="top">Sponsor Details<font color="red">*</font></td>
		                        <td  width="31%" align="left">
	                                
	                                 <?php 
	                       			//$paymentCategory = array('cash'=>'Self Pay','1'=>'Corporate','1'=>'Insurance company','2'=>'TPA');
	                                 $paymentCategory = array('cash'=>'Self Pay','Corporate'=>'Corporate','Insurance company'=>'Insurance company','TPA'=>'TPA');
	                       			echo $this->Form->input('payment_category', array(/* 'empty'=>__('Please Select'), */'options'=>$paymentCategory,'autocomplete'=>'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'paymentType','onchange'=> $this->Js->request(array('action' => 'getPaymentType'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
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
					                        <td class="tdLabel"  id="boxSpace"><?php echo __('Insurance Number'); ?> </td>
					                        <td align="left">
					                       		<?php echo $this->Form->input('insurance_number', array('class'=>'textBoxExpnd','id' => 'insurance_number')); ?>
					                    	</td> 
				                    	 	<td>&nbsp;</td>
					                        <td class="tdLabel"  id="boxSpace" align="left"><?php echo __('Designation'); ?> </td>
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
	                <?php }?>
	                <p class="ht5"></p>
	                <!-- Sponcer Details ends here -->
	                 <p class="ht5"></p>
                    
                    <!-- Links to Records start here  
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
                      Links to Records end here -->
                    <p class="ht5"></p> 
                    <!-- Address info start here -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	                   	  <tr>
	                      	<th colspan="5"><?php echo __('Other Information');?></th>
	                      </tr>
	                      
	                         <tr>
                       <td style="width: 25%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Blood Group');?></td>
                       <td style="width: 25%"><?php 
                       		$blood_group = array("A+"=>"A+","A-"=>"A-","B+"=>"B+","B-"=>"B-","AB+"=>"AB+","AB-"=>"AB-","O+"=>"O+","O-"=>"O-");
                       		echo $this->Form->input('blood_group', array('empty'=>__('Please Select'),'options'=>$blood_group,'class' => 'textBoxExpnd','id' => 'designation','style'=>'width:66%!important;')); ?></td>
                      
                       <td style="width: 25%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Allergies');?> </td>
                       <td style="width: 25%"><?php echo $this->Form->textarea('allergies', array('class' => 'textBoxExpnd','id' => 'allergies','row'=>'3')); ?></td>
                       <!-- <td class="tdLabel" id="boxSpace"> <?php echo __('UIDDate'); ?> <font color="red">*</font></td>
                       <td>
                       		<?php
                       			echo $this->Form->input('uiddate', array('class' => 'textBoxExpnd','type'=>'text','id' => 'uiddate')); ?>
                       </td>-->
                     </tr>
                  	<!-- <tr>
                     	   <td class="tdLabel " id="boxSpace" valign="top" >Referral Doctor<font color="red">*</font></td>
                        <td>
                         <?php //echo $this->Form->input('known_fam_physician', array('class' => 'textBoxExpnd','id' => 'knownPhysician'));
						 
                              echo $this->Form->input('known_fam_physician', array('empty'=>__('Please Select'), 'id'=>'familyknowndoctor','class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','style'=>'width:66%!important;','options'=>$reffererdoctors,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'getDoctorsList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    						 'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeDoctorsList', 'data' => '{familyknowndoctor:$("#familyknowndoctor").val()}', 'dataExpression' => true, 'div'=>false))));
                          ?>

                          <div id="changeDoctorsList">	                        
	                      </div>
                          </td>
                   		 
                           <td valign="middle" class="tdLabel" id="boxSpace">Family Physician Contact No.</td>
                        <td>
                        	<?php echo $this->Form->input('family_phy_con_no', array('class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'phyContactNo','MaxLength'=>'10')); ?>                        
                        </td>  
                     </tr> 
          -->
                     <tr>
                         <td class="tdLabel father" id="boxSpace" style="display: none;">Father Name </td>
                         <td class="tdLabel sopuse" id="boxSpace">Spouse Name</td> 
                       	<td><?php echo $this->Form->input('relative_name', array('class' => 'textBoxExpnd','id' => 'relativeName','lable'=>false)); ?></td>
                         
                        <td valign="middle" class="tdLabel" id="boxSpace">Relative Phone No.</td>
                        <td>
                        	<?php echo $this->Form->input('relative_phone', array('class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'mobilePhone','MaxLength'=>'10')); ?>
                        </td> 
                     </tr>
                      <tr> 
						<td valign="middle" class="tdLabel" id="boxSpace">Instructions</td>
                        <td>
                        	<?php
                                 $instructions = array('Diabetic'=>'Diabetic- If found Unconscious give sugar/sweet/chocolate.','Epileptic'=>'Epileptic- In case of attack/fit turn patient to one side & refrain from feeding.','High Blood Pressure'=>'High Blood Pressure- If found unconscious or paralyzed, turn patient to one side & refrain from feeding.','Low Blood Pressure'=>'Low Blood Pressure- In case of vertigo keep head in low position & take plenty of fluids.','Cardiac Problem'=>'Cardiac Problem- In case of symtoms like chest pain or sweating administer Tablet Disprin & sublingual Tablet Sorbitrate.','Asthma'=>'Asthma- In case of acute attack administer 2 puffs of Scroflo inhaler & shift to hospital.');

                        	 //$instructions = array('Diabetic'=>'Diabetic','Epileptic'=>'Epileptic','High Blood Pressure'=>'High Blood Pressure','Low Blood Pressure'=>'Low Blood Pressure','Prone to Angina Attacks'=>'Prone to Angina Attacks','Austistic'=>'Austistic');
                        	 echo $this->Form->input('instruction', array('empty'=>__('Please Select'),
                        								  'options'=>$instructions,'class' => 'textBoxExpnd','style'=>'width:66%!important;','id' => 'instructions')); ?>
                        	</td>
                     
                    
                     <!-- For accounting group by amit jain -->
                     	<!--  <td valign="middle" class="tdLabel" id="boxSpace"><?php //echo __('Account Group'); ?><font color="red">*</font></td>
							<td>
							<?php //echo $this->Form->input('accounting_group_id', array('id' => 'group_id','type'=>'select','options'=>$group, 'class' =>'validate[required,custom[mandatory-select]] textBoxExpnd ','label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select'));?>
							</td>-->
                     

                        <td class="tdLabel" id="boxSpace">Identity Type</td>
                        <td><?php echo $this->Form->input('vip_chk', array('class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','empty'=>__('Please Select'),'options'=>array('1'=>'VIP Covid','2'=>'Regular Covid','3'=>'Non Covid'),'error'=>false,'label'=>false,'id'=>'identity_type')); ?></td>

                       	</tr>
    
						  <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo('Emergency Contact Name');?></td>
	                        <td><?php echo $this->Form->input('patient_owner', array('class' => 'validate[optional,custom[onlyLetterSp]] textBoxExpnd ','id' => 'patient_owner')); ?></td>
	              
	                        <td class="tdLabel" id="boxSpace"><?php echo('Emergency Contact No.');?></td>
	                        <td><?php echo $this->Form->input('asst_phone', array('class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'asst_phone','MaxLength'=>'10')); ?></td>
	                      </tr>
	                      <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Email');?></td>
	                        <td><?php echo $this->Form->input('email', array('class' =>'validate["",custom[email]] textBoxExpnd','id' =>'email')); ?></td>
	                        
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Fax');?></td>
	                        <td><?php echo $this->Form->input('fax', array('class' => 'textBoxExpnd','id' => 'email','maxLength'=>'15')); ?></td>
	                     </tr>
	      				 <?php if(Configure::read('Coupon')){?>
						   	<tr class="couponSection" >
								<td class="tdLabel" id="boxSpace"><?php echo __('Privilege Card No.'); ?></td>
								<td ><?php echo $this->Form->input('coupon_name', array('class' =>'coupon_name textBoxExpnd','id' =>'coupon_name','autocomplete' => 'off'));//validate[ajax[ajaxCouponCall]] ?>
					                        <?php echo $this->Form->hidden('coupon_amount', array('class' =>'couponAmount','value'=>'0','label'=>false,
					                                    'id' =>'couponAmount','autocomplete' => 'off'));//couponAmount?></td> 
								<td colspan = "2" class="tdLabel" id="validcoupon" style='display:none; color:green'><?php echo 'Valid Card'; ?>
								<span id="validcouponAmount" style='display:none;color:green'></span></td>
							</tr>
             		   <?php } ?>

             		   	<tr class="couponSection" >
								<td class="tdLabel" id="boxSpace"><?php echo __('Billing Link'); ?></td>
								<td ><?php echo $this->Form->input('billing_link', array('type'=>'text', 'id' => 'billing-link','value'=>$expectedAmount['FinalBilling']['billing_link'],'label'=>false,'div'=>false,'class'=>'textBoxExpnd billPrepareInput'));?></td> 

								<td class="tdLabel" id="boxSpace"><?php echo __('Referal Letter'); ?></td>
								<td >
									<?php echo $this->Form->input('referral_letter', array('type'=>'file','id' => 'referral-letter','label'=>false,'div'=>false,'class'=>'textBoxExpnd billPrepareInput'));
    								
    								?>
								</td>
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
                    <?php  if($website=='lifespring'){
                    	$paddingRight = '136px';
                    	$marginTop = '-42px';
                    }else 
                    {
                    	$paddingRight = '67px';
                    	$marginTop = '-37px';
                    }?>             
                     <div style="text-align:right;padding-right: <?php echo $paddingRight;?>">
                    <!--by amit jain-->
                    
                    
                      <?php echo __("Type");?><font color="red">*</font>
                     	<?php 
                     	
                     	$website=$this->Session->read("website.instance");
                        if($website=='kanpur'){
					   		echo $this->Form->input('admission_type',array('id'=>'admission_type','type'=>'select','options'=>Array('IPD'=>'IPD','OPD'=>'OPD','RAD'=>'RADIOLOGY', 'emergency'=>'EMERGENCY','LAB'=>'LABORATORY'),'class'=>'validate[required,custom[mandatory-select]] admission_type'));
					}else{
                         echo $this->Form->input('admission_type',array('id'=>'admission_type','type'=>'select','options'=>Array('OPD'=>'OPD','IPD'=>'IPD','RAD'=>'RADIOLOGY', 'emergency'=>'EMERGENCY','LAB'=>'LABORATORY','prospect'=>'PROSPECT'),'class'=>'validate[required,custom[mandatory-select]] admission_type','empty'=>'Please Select'));
                        }  ?>
                       <input type="submit" id="goforpatientbyotherway" value="Save And Next" class="blueBtn submitandReg" style="text-align:left;">
                       
                     <!--   <input type="submit" id="submitandschedule" value="Schedule Appointment" class="blueBtn" style="text-align:left;"> -->
                       <?php  /* $patientId=$someData['Person']['patient_uid'];
                       $name=$someData['Person']['full_name']; 
                       debug($patientId);exit */
                       ?>
                       
                       <!-- <input class="blueBtn" type="submit" value="Capture Fingerprint" id="capturefingerprint"> -->
                    </div>
                    <div class="btns" style="margin-top:<?php echo $marginTop;?>;">
                     <?php  if($website=='lifespring'){?>	   	
					  <input class="blueBtn" type="submit" value="Submit" id="submit1">  
					  <?php }?>
						<?php 
							if(isset($redirectTo)){
								echo $this->Html->link(__('Cancel', true),array('controller'=>'nursings','action' => 'search/'), array('escape' => false,'class'=>'blueBtn'));
							} else {
								echo $this->Html->link(__('Cancel', true),array('controller'=>'persons','action' => 'searchPerson'), array('escape' => false,'class'=>'blueBtn'));
							}
						?>
                   
                     </div>
			<?php //EOF new form design ?>			 
	  </div>
 <?php echo $this->Form->end(); ?>
 
<script>
		var website = '<?php echo $this->Session->read('website.instance')?>';	

		/* if($('.admission_type').val()=='prospect'){ 
				$('.couponSection').show();
			 }else{
					$('.couponSection').hide();
					  $('#couponAmount').val('0');
		              $('#coupon_name').val('');
		 } */
		  jQuery(document).ready(function(){
			  
			var systemDateFormat = '<?php echo $this->Session->read('dateformat'); ?>';
			if(systemDateFormat[0] == 'd') var formatSyntax = 'd/m/Y';
			else if(systemDateFormat[0] == 'm') var formatSyntax = 'm/d/Y';
			$('#ageMonth, #age,#ageDay').val('0');
			var today = new Date();
			$('#dob').val(today.format(formatSyntax));
			// binds form submission and fields to the validation engine
	//jQuery("#personfrm").validationEngine();
			$('#submit').click(function(){  
				//jQuery("#admission_type").removeClass('validate[required,custom[mandatory-select]]');	
			 //	$("#admission_type").validationEngine("hidePrompt"); 
			 	var validatePerson = jQuery("#personfrm").validationEngine('validate');
			 	if(parseInt($('#ageMonth').val()) >= 12){
					$('#ageMonth').validationEngine('showPrompt', 'Month should be less than 12.', 'text', 'topRight', true);
					validatePerson = false;
				}
			 	if(parseInt($('#ageDay').val()) > 31){
					$('#ageDay').validationEngine('showPrompt', 'Day should be less than 31.', 'text', 'topRight', true);
					validatePerson = false;
				}
			 	if(parseInt($('#pregnant_week').val()) > 37){
					$('#pregnant_week').validationEngine('showPrompt', 'Day should be less than 31.', 'text', 'topRight', true);
					validatePerson = false;
				}
			 	if(validatePerson){
			 		$(this).css('display','none');
				}
			});
			
     $('#coupon_name').keyup(function(){
                 $('#couponAmount').val('0');
                 if($('#coupon_name').val() ==""){
                     $("#coupon_name").validationEngine("hidePrompt");
                     $('#validcoupon').hide();
                     validatePerson = true ;
                 }else{
                         $('#validcoupon').hide();
                         $('#coupon_name').validationEngine('showPrompt', 'Invalid Card', 'text', 'topRight', true);
                         validatePerson = false;
                 }
                 name = $('#coupon_name').val();
                 if(name.length < 6) return false;
                 $.ajax({   
					type:'POST',
					url : "<?php echo $this->Html->url(array("controller" => 'persons', "action" => "couponValidate","admin" => false));?>"+"/"+name,
					context: document.body,   
					success: function(data){ 
						data= jQuery.parseJSON(data);
					                             if(data[0] == 'Card Available'){
					                                 $('#validcoupon').show();
					                                 $('#validcouponAmount').text('Amount : '+data[1]);
					                                 $('#couponAmount').val(data[1]);
					                                 $("#coupon_name").validationEngine("hideAll");
					                                 validatePerson = true;
					                             }else{
					                                 $('#validcoupon').hide();
					                                 $('#couponAmount').val('0');
					                                 $('#coupon_name').validationEngine('showPrompt', data[0], 'text', 'topRight', true);
					                                 validatePerson = false;
					                             }
					}
					}); 
             });

			$('#submit1').click(function(){  
			/*	jQuery("#admission_type").removeClass('validate[required,custom[mandatory-select]]');	
			    $("#admission_type").validationEngine("hide"); 
			    jQuery("#admission_type1").removeClass('validate[required,custom[mandatory-select]]');	
			    $("#admission_type1").validationEngine("hide"); 
			 	var validatePerson = jQuery("#personfrm").validationEngine('validate');
			 	if(parseInt($('#ageMonth').val()) >= 12){
					$('#ageMonth').validationEngine('showPrompt', 'Month should be less than 12.', 'text', 'topRight', true);
					validatePerson = false;
				}
			 	if(parseInt($('#ageDay').val()) > 31){
					$('#ageDay').validationEngine('showPrompt', 'Day should be less than 31.', 'text', 'topRight', true);
					validatePerson = false;
				}
			 	if(validatePerson){
			 		$(this).css('display','none');
				}*/

			 	validateWeeks = true;   
         	    if(parseInt($('#pregnant_week').val()) > 37){
        				$('#pregnant_week').validationEngine('showPrompt', 'Weeks should be less than 37.', 'text', 'topRight',true);
        				validateWeeks = false;
                  } 
         	    jQuery("#admission_type").removeClass('validate[required,custom[mandatory-select]]');	
			    $("#admission_type").validationEngine("hide"); 
			    jQuery("#admission_type1").removeClass('validate[required,custom[mandatory-select]]');	
			    $("#admission_type1").validationEngine("hide"); 
    				//jQuery(".admission_type").addClass('validate[required,custom[mandatory-select]]'); 
    				 if(jQuery("#personfrm").validationEngine('validate') && validateWeeks){

                 	   var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][submitandregister]").val("1");
                        $('#personfrm').append($(input));
                    }else{
						   
                  	  return false;
                    } 
			});
			
            // added for change both admission type on select of single-Atul
			 $('.admission_type').change(function(){ 
			 	$('.admission_type').val($(this).val());
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

			$("#dob").datepicker({
				showOn : "both",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				buttonText: "Calendar",
				changeMonth : true,
				changeYear : true,
				yearRange: '-100:' + new Date().getFullYear(),
				maxDate : new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					$("#dob").validationEngine("hide");   
					//calculateAge();getYearMonth();getYearMonthDay();CalculateDiff1();
					$.ajax({
						url :  "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'getAgeFromDob')); ?>",
						method : "GET",
						data : "dob="+$('#dob').val(),
						beforeSend : function(){
							//$('#busy-indicator').show();
						},
						success : function(data){
							var age = jQuery.parseJSON(data);
							$('#age').val(age[0]);//.trigger('change');
							setAge();
							$('#ageMonth').val(age[1]);
							$('#ageDay').val(age[2]);
							//$('#busy-indicator').hide();
						}
					});
				}
			});

			$('#ageMonth, #age,#ageDay').keyup(function (){
				$("#ageMonth, #age,#ageDay").validationEngine('hideAll');
				if(parseInt($('#ageMonth').val()) >= 12){
					$('#ageMonth').validationEngine('showPrompt', 'Month should be less than 12.', 'text', 'topRight', true);
					$('#ageMonth').val(0);
					return false;
				}
				
		      if(parseInt($('#ageDay').val()) > 31){ 
					$('#ageDay').validationEngine('showPrompt', 'Day should be less than 31.', 'text', 'topRight', true);
					$('#ageDay').val(0);
					return false;
				}
		      if(isNaN($(this).val()) || $(this).val() == ''){
					$(this).validationEngine('showPrompt', 'Number Only', 'text', 'topRight', true);
					return false;
				}
				var ajaxUrl = "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'getDobFromAge')); ?>";
				var data = "years="+$('#age').val()+"&months="+$('#ageMonth').val()+"&days="+$('#ageDay').val();
				$.ajax({
					url : ajaxUrl,
					method : "GET",
					data : data,
					beforeSend : function(){
						//$('#busy-indicator').show();
					},
					success : function(data){
						$('#dob').val($.trim(data));
						if($('#initials').val() == '')
						setAge()
						//$('#age').trigger('change');
						//$('#busy-indicator').hide();
					}
				});
			});

					
					
					$('#initials').change(function(){
						$(".shows, .father").hide();
						$("#row").show();
					//	$('#first_name,#last_name').val('');
						var getInitial=$("#initials option:selected").val(); //alert(getInitial);
						if(getInitial=='2' || getInitial=='3' || getInitial=='6'){
							$("#sex").val('female');
							$(".sopuse").show();
						}else if(getInitial=='1' || getInitial=='5') {
							$("#sex").val('male');
							$(".sopuse").show();
						}/*else if(getInitial=='1' || getInitial=='5') {
							$("#sex").val('male');
						}*/else if(getInitial=='7') {
							$("#row").hide();
							$(".shows").show();
							$(".father").show();
							$(".sopuse").hide();
							$("#sex").val('');
						}else{
							$(".sopuse").show();
							$("#sex").val('');
						}
					});
					$('#sex').change(function(){
						var getSex=$("#sex option:selected").val();					
						var ageValue=$('#age').val();
						if($("#initials").val() == '7')return false;		
						if(getSex=='female'){
							/*if(ageValue!='' && ageValue<=10){			
								$("#initials").val('6');
							}else if(ageValue=='' || ageValue>=10) {			
								$("#initials").val('2');
							}*/if(ageValue>=10) {			
								$("#initials").val('2');
							}else if(ageValue >=3 && ageValue<=10) {			
								$("#initials").val('6');
							}else{
								$("#initials").val('7');
								}
						}else if(getSex=='male') {	
							/*if(ageValue!='' && ageValue<=10){			
								$("#initials").val('5');
							}else if(ageValue=='' || ageValue>=10) {			
								$("#initials").val('1');
							}*/if(ageValue>=10) {			
								$("#initials").val('1');
							}else if(ageValue >=3 && ageValue<=10) {			
								$("#initials").val('5');
							}else{
								$("#initials").val('7');
								}
									
						}else{
							$("#initials").val('1');
						}
					});
			 $('#city, #taluka,#district').live('focus',function() { 
				 var getStateId=$('#stateId').val();
				 if($(this).attr('id') == 'taluka') {
					 var loadIds = 'taluka,talukaId';
				   } else if($(this).attr('id') == 'district') {
					  var loadIds = 'district,districtId';
					 }else{
                         var loadIds = 'city,cityId';
                         }
				 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","City","id","name")); ?>"+'/'+'state_id='+getStateId,{
				width: 250,
				 selectFirst: true,
				 valueSelected:true,
         		showNoId:true,
         		loadId : loadIds,
			});
			});
			$('#district').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","District","name",'null',"no","no","admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				 selectFirst: true
			});

               $('#stateName').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","State","id","name",'null')); ?>", {
            	   width: 250,
            		selectFirst: true,
            		valueSelected:true,
            		showNoId:true,
				loadId : 'state,stateId',
			});
                       
                       $('#goforpatient').click(function() {
	                        var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][submitandregister]").val("1");
	                        $('#personfrm').append($(input));
	                        $('#personfrm').submit();
                       });
 
          
                     /*  $('#goforpatientbyotherway').click(function(){   
						   
	           				jQuery("#admission_type").addClass('validate[required,custom[mandatory-select]]'); 
	           				 if(jQuery("#personfrm").validationEngine('validate')){
 
	                        	   var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][submitandregister]").val("1");
		                           $('#personfrm').append($(input));
	                           }else{
								   
	                         	  return false;
	                           } 
           				});*/

           				
           					$( "#pregnant_week" ).keypress(function(){
           						var name = $('#pregnant_week').val(); // alert(name);
           						
               				});
                       $('.submitandReg').click(function(){
                    	   validateWeeks = true;   
                    	   if(parseInt($('#pregnant_week').val()) > 37){
		           				$('#pregnant_week').validationEngine('showPrompt', 'Weeks should be less than 37.', 'text', 'topRight',true);
		           				validateWeeks = false;
	                         } 
	           				jQuery(".admission_type").addClass('validate[required,custom[mandatory-select]]'); 
	           				 if(jQuery("#personfrm").validationEngine('validate') && validateWeeks){

	                           var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][submitandregister]").val("1");
		                        $('#personfrm').append($(input));
		                        $(".submitandReg").hide()
	                           }else{
								   
	                         	  return false;
	                         	 $(".submitandReg").show()
	                           } 
	           				 
          				});

                       $('#submitandschedule').click(function() {
                          
                          if(jQuery("#personfrm").validationEngine('validate')){
                        	  var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][submitandschedule]").val("1");
                              $('#personfrm').append($(input)); 
                          }else{
                        	  return false;
                          }
                           
                          });
                       //  click on  capture fingerprint it save the person data & redirect to finger_print page,by atul
                     /*  $('#capturefingerprint').click(function() {
                           var input = $("<input>").attr("type", "hidden").attr("name", "data[Person][capturefingerprint]").val("1");
                           $('#personfrm').append($(input));
                           $('#personfrm').submit();
                          });*/
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
			                 }else if($('#paymentType').val() == ''){
			                	 $('#showwithcard').hide();
	                              $('#showwithcardInsurance').hide();
			                 }else if($('#paymentType').val() == 'Corporate'){
			                	 $('#showwithcard').hide('fast');  
	                              $('#showwithcardInsurance').show('slow'); 
	                              $('#showwithcardInsurance :input').attr('disabled', false);
	                              $('#showwithcard :input').attr('disabled', true);
			                 }
			                 else if($('#paymentType').val() == 'Insurance company'){
			                	 $('#showwithcard').hide('fast');  
	                              $('#showwithcardInsurance').show('slow'); 
	                              $('#showwithcardInsurance :input').attr('disabled', false);
	                              $('#showwithcard :input').attr('disabled', true);
			                 }
			                 else if($('#paymentType').val() == 'TPA'){
			                	 $('#showwithcard').hide('fast');  
	                              $('#showwithcardInsurance').show('slow'); 
	                              $('#showwithcardInsurance :input').attr('disabled', false);
	                              $('#showwithcard :input').attr('disabled', true);
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
	
	/*$('#initials').change(function(){
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
*/
//---------------------------------BOF Atul, for 1st letter uppercase-----------------------------

/*$("#first_name,#last_name").keyup(function() {
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
}*/

$('#first_name,#last_name').css('textTransform', 'capitalize'); /*this line also for 1st capital letter*/
//------------EOF-------	
$("#pinCode").blur(function(){
	var zipData = $(this).val(); //alert(zipData);
	var zipCount =	( $(this).val().length); //alert(zipCount);
	if(zipCount == 6){
		
		$.ajax({
        	url: "<?php echo $this->Html->url(array("controller" => 'Persons', "action" => "getStateCity")); ?>"+"/"+zipData,
        	context: document.body,
        	
			success: function(data){
				if(data !== undefined && data !== null){
					data1 = jQuery.parseJSON(data);
					//console.log(data1.zip);
					
					if(data1.zip['State']['id']){
						$('#stateId').val(data1.zip['State']['id']);
						$('#stateName').val(data1.zip['State']['name']);
						$('#city').val(data1.zip['PinCode']['city_name']);
					}
				 }	
			} 
        });
	} else{
		$('#stateId').val("");
		$('#stateName').val("");
		$('#city').val("");
		}
			
	});

/*$('.no_number').on('change',function(){
	if($('#no_number').prop('checked')){
		//$('#phone_number').removeClass('validate[required]');
		$('#mobile').removeClass('validate[required,custom[phone]');
	}else{
		$('#mobile').addClass('validate[required,custom[phone]');
	}
});
*/

$('#no_number').click(function(){
	if($("#no_number").is(':checked')){
		 $('#mobile').attr('disabled', 'disabled');
	   $('#mobile').removeClass('validate[required,custom[phone,minSize[10],onlyNumber]]');
		 jQuery('#mobile').validationEngine('hide');
	       $( "#mobile" ).val("");
	}else{
		 $('#mobile').addClass('validate[required,custom[phone,minSize[10],onlyNumber]]');
		 $('#mobile').removeAttr('disabled', 'disabled');
	}  
	});


function setAge(){	
	var ageValue=$('#age').val();
	var getSex=$("#sex").val();	
	if(ageValue<=3){
		$(".shows").show();
		$("#initials").val('7');
		$("#sex").val('');
		
		}
	 else if(ageValue>=3 && ageValue<=10){
		if(getSex=='male'){
			$("#initials").val('5');
		}else if(getSex=='female'){
			$("#initials").val('6');
		}
	}else{
		if(getSex=='male'){
			$("#initials").val('1');
		}else if(getSex=='female'){
			$("#initials").val('2');
		}else{
			$("#initials").val('');
			$(".shows").hide();
		}
		
		
	}	
}	

 $('#isStaff').click(function(){			
        if($("#isStaff").is(':checked')){	
            $("#notStaff").hide();
            $("#staff").show();
            $("#staffName").focus();
            $("#initials").val('');
            $("#first_name").val('');
            $("#last_name").val('');
        }else{
            $("#notStaff").show();
            $("#staff").hide();
            $("#staffName").val('');
        }
    });

  
	$('#staffName').autocomplete("<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "staffAutocomplete","admin" => false,"plugin"=>false)); ?>", {
			   width: 250,
				selectFirst: true,
				valueSelected:true,
				showNoId:true,
			    loadId : 'staffName',
		})
</script>
