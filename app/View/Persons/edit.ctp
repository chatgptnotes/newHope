 <?php // debug($this->data);
 	echo $this->Html->script(array('jquery.autocomplete'));
    echo $this->Html->css('jquery.autocomplete.css'); 
    echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array('jquery.fancybox-1.3.4'));
?>
<style>
select.textBoxExpnd1{ width:66%; margin-top:5px;}
/*select.textBoxExpnd{ width:70%;}*/

label {
    color: #000 !important;
    float: left;
    font-size: 13px;
    margin-right: 10px;
    padding-top: 3px;
    text-align: right;
    width: 37px;
}
</style>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Edit UID Patient Details', true); ?></h3>
<!-- 	<span> <?php // echo $this->Html->link(__('Search UIDpatient'), array('action' => 'search'), array('escape' => false,'class'=>'blueBtn')); ?></span> -->
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
			<?php 
			if($this->params->query['from']=='appointments_management'){ ?>
			      <div class="btns">
                          <input class="blueBtn" type="button" value="Cancel" 
                           	onclick="window.location='<?php echo $this->Html->url(array("controller" => 'Appointments',
                           	"action" => "appointments_management"));?>'">
						  <input class="blueBtn" type="submit" value="Submit" id="submit">
					</div>
			     <?php   }
                   else{?>
                   <div class="btns">
                          <input class="blueBtn" type="button" value="Cancel" 
                           	onclick="window.location='<?php echo $this->Html->url(array("controller" =>'Persons',
                           	"action" => "patient_information",$this->data['Person']['id']));?>'">
						  <input class="blueBtn" type="submit" value="Submit" id="submit">
					</div>
					<?php }	  
						  
                  ?> 
                   <!--<div class="btns" style="float:left;">	
                   		<?php 
					   		//echo $this->Form->input('admission_type',array('type'=>'select','options'=>Array('IPD'=>'IPD','OPD'=>'OPD','EMERGENCY'=>'EMERGENCY')));
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
                          	<td width="2%"><?php  
                          	if($this->Session->read("website.instance")=='lifespring'){
                          		$mrKey = array_search('Mr.', $initials);
                          		unset($initials[$mrKey]);}
                          	echo $this->Form->input('initial_id', array('empty'=>__('Select'),'options'=>$initials,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'initials','style'=>'width:80px')); ?></td>
                            <td>                            	 
                            	<?php echo $this->Form->input('first_name', array('style'=>'width:160px;margin-left:10px;','class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'first_name')); ?>
                            </td>                           
                          </tr>
                        </table></td>
                        
						 <td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Last Name');?><font color="red">*</font></td>
                        <td>
                        	<?php echo $this->Form->input('last_name', array('class' => 'validate[required,custom[patient_last_name]] textBoxExpnd','id' => 'last_name')); ?>
                        </td> 
                      </tr>
                      <tr>                       
							<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Date of Birth');?><font color="red">*</font></td>
							<td>
								<?php 
                                  	echo $this->Form->input('Person.age_year', array('div'=>false,'type'=>'text','style'=>'width:23px;float:left;','maxLength'=>'3','placeHolder'=>'  Y',
											'size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] ','id' => 'age','label'=>false,'autocomplete'=>"off"));
									echo $this->Form->input('Person.age_month', array('div'=>false,'type'=>'text','style'=>'width:23px;float:left;','maxLength'=>'2','placeHolder'=>'  M',
											'size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] ','id' => 'ageMonth','label'=>false,'autocomplete'=>"off"));
									echo $this->Form->input('Person.age_day', array('div'=>false,'type'=>'text','style'=>'width:23px;float:left;','maxLength'=>'2','placeHolder'=>'  D',
											'size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] ','id' => 'ageDay','label'=>false,'autocomplete'=>"off"));
                                    echo $this->Form->input('dob', array('label'=>'DOB','type'=>'text','style'=>'width:126px','readonly'=>'readonly','size'=>'20','class' => 'validate[optional,custom[mandatory-select]] textBoxExpnd','id' => 'dob'));
								?>
							</td>
							
							<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Sex');?> <font color="red">*</font></td>
							<td width="30%">
								<?php
								  $sex=strtolower($this->data['Person']['sex']);  
									echo $this->Form->input('sex', array('options'=>array(""=>__('Please Select Sex'),"male"=>__('Male'),'female'=>__('Female')),'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'sex','value' =>$sex)); ?>
							</td> 
                      </tr>
                                                 
                     <tr>
                       <td class="tdLabel" id="boxSpace" >Patient's Photo</td>
                       <td>
                       	<?php echo $this->Form->input('upload_image', array('type'=>'file','id' => 'patient_photo','class'=>"", 'style'=>'float:left;width: 66%','label'=> false,
					 			'div' => false, 'error' => false ));
                       			 
							  echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera'));
							  
                       ?>
                       <?php if($this->data['Person']['photo']){
								$url = FULL_BASE_URL.Router::url('/')."uploads/patient_images/".$this->data['Person']['photo'];
								$display = 'block';
							}else{
			 					$url = '#';
								 $display = 'none';
							}?> <span id="ppt" style="display:<?php echo $display;?>"><?php echo $this->Html->link('Patient Photo',
										$url,array('id'=>'showPPT' ,'target'=>'_blank' ));?> </span>
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
                     
                      	</tr>
	                      <tr>
	                        <td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Quarter no/Plot no');?></td>
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
                              <td><?php echo $this->Form->input('stateName', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'stateName','value'=>$this->data['State']['name'])); 
                                        echo $this->Form->hidden('state',array('id'=>'stateId'));?></td>
	                         
                            <!--  <td class="tdLabel" id="boxSpace"><?php echo __('District');?></td>
                             <td><?php echo $this->Form->input('district', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'district')); ?></td> -->
                          
                                     </tr>
                            <tr>
                            <td class="tdLabel" id="boxSpace"><?php echo __('City/Town');?></td>
	                        <td><?php echo $this->Form->input('city', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'city')); ?></td>
	                        
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Nationality');?></td>
	                        <td><?php echo $this->Form->input('nationality', array('class' => 'textBoxExpnd','id' => 'email','Value'=>'Indian')); ?></td>
	                     </tr>
	                      <tr>
	                        <td  class="tdLabel" id="boxSpace"><?php echo __('Home Phone No.');?></td>
	                         <td ><?php echo $this->Form->input('home_phone', array('class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'home_phone','MaxLength'=>'10')); ?></td>
	                  
	                        <td class="tdLabel" id="boxSpace"><?php echo('Mobile No.');?><font color="red">*</font></td>
	                        <td><?php echo $this->Form->input('mobile', array('class' =>' validate[required,custom[phone,minSize[10],onlyNumber]] textBoxExpnd','id' => 'mobile','MaxLength'=>'10')); ?></td>
	                       
	                      </tr>
	                      
	                     <tr>
	                       
	                         <td>&nbsp;</td>
	                         <td>&nbsp;</td>
		                  	  <td>&nbsp;</td>
			                <td width="30%"><?php echo $this->Form->input('Person.no_number', array('label'=>false,'type'=>'checkbox','class' => 'no_number','id' => 'no_number'));
			                echo __('Patient does not have a mobile number');?></td>
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
                    <?php $website= $this->Session->read("website.instance");
                   if(($website!="kanpur") && ($website!="vadodara") && ($website!="hope")){?>
					<p class="ht5"></p>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	                   	  	<tr>
		                      	<th colspan="5"><?php echo __('Sponsor Information');?></th>
		                    </tr>
		                   <tr>
		                        <td class="tdLabel" id="boxSpace" valign="top" width="19%"> Sponsor Details <font color="red">*</font></td>
	                             <td width="30%">
			                       		<?php 
			                       			//$paymentCategory = array('cash'=>'Self Pay','card'=>'Insurance','1'=>'Corporate','2'=>'TPA');
			                       		$paymentCategory = array('cash'=>'Self Pay','Corporate'=>'Corporate','Insurance company'=>'Insurance company','TPA'=>'TPA');
			                       			echo $this->Form->input('payment_category', array(/*'empty'=>__('Please Select'),*/'options'=>$paymentCategory,'autocomplete'=>'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'paymentType','onchange'=> $this->Js->request(array('action' => 'getPaymentType'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			    								 'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{paymentType:$("#paymentType").val()}', 'dataExpression' => true, 'div'=>false)))); 
			                       		?>
			                        	<span id="changeCreditTypeList">
				                        	<?php  
				                               if($this->data['Person']['payment_category'] == 'Corporate') { 
				                        	?>
				                         	<span><!-- <font color="red">*</font>&nbsp; -->
					                           <?php 
					          						/* echo $this->Form->input('Person.credit_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false)))); */
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
													 echo "<br />";
					                                echo $this->Form->textarea('corporate_otherdetails', array('class' => 'textBoxExpnd','id' => 'otherdetails','row'=>'3')); 
					                          ?>
			                          		</span>
			                          	 </span>
			                          </span>
			                          
			                          
			                       <?php } if(($this->data['Person']['payment_category'] == 'Insurance company') || ($this->data['Person']['payment_category'] == 'TPA')) { ?>
			                           <span><!-- <font color="red">*</font>&nbsp; -->
			                           <?php 
			          						/* echo $this->Form->input('Person.credit_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false)))); */
			                          ?>
			                           <!-- <span id="changeCorprateLocationList"><font color="red">*</font>&nbsp; -->
			                            <?php 
			          						/* echo $this->Form->input('Person.insurance_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancetypes, 'empty' => __('Select Insurance Type'), 'id' => 'insurancetypeid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getInsuranceCompanyList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeInsuranceCompanyList', 'data' => '{insurancetypeid:$("#insurancetypeid").val()}', 'dataExpression' => true, 'div'=>false)))); */
			                          ?>
			                          <span id="changeInsuranceCompanyList"><font color="red">*</font>&nbsp;
			                           <?php 
			          						echo $this->Form->input('Person.insurance_company_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancecompanies, 'empty' => __('Select Insurance Company'), 'id' => 'ajaxinsurancecompanyid', 'label'=> false, 'div' => false, 'error' => false));
			          						
			          						/* echo $this->Form->input('Person.corporate_location_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporatelocations, 'empty' => __('Select Corporate Location'), 'id' => 'ajaxcorporatelocationid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			          								'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateList', 'data' => '{ajaxcorporatelocationid:$("#ajaxcorporatelocationid").val()}', 'dataExpression' => true, 'div'=>false)))); */
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
				                       			<?php echo $this->Form->input('non_executive_emp_id_no', array('style'=>'width:180px;margin-right:10px;','class' => 'textBoxExpnd emp_id','id' => 'insurance_non_executive_emp_id_no')); ?>
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
						                       			<?php echo $this->Form->input('non_executive_emp_id_no', array('style'=>'width:180px;margin-right:10px;','class' => 'textBoxExpnd emp_id','id' => 'corpo_non_executive_emp_id_no')); ?>
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
                        <td width="81%"><?php echo $this->Form->input('case_summery_link', array('style'=>'width:24.7%;','class' => 'textBoxExpnd','id' => 'caseSummeryLink')); ?></td>
                        
                      </tr>
                      <tr>
                        <td class="tdLabel" id="boxSpace">Patient File</td>
                        <td><?php echo $this->Form->input('patient_file', array('style'=>'width:24.7%;','class' => 'textBoxExpnd','id' => 'patientFile')); ?></td>
                        
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
                       <td style="width: 19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Blood Group');?></td>
                       <td style="width: 31%"><?php 
                       		$blood_group = array("A+"=>"A+","A-"=>"A-","B+"=>"B+","B-"=>"B-","AB+"=>"AB+","AB-"=>"AB-","O+"=>"O+","O-"=>"O-");
                       		echo $this->Form->input('blood_group', array('empty'=>__('Please Select'),'options'=>$blood_group,'class' => 'textBoxExpnd','id' => 'designation')); ?></td>
                      
                       <td style="width: 20%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Allergies');?> </td>
                       <td><?php echo $this->Form->textarea('allergies', array('class' => 'textBoxExpnd','id' => 'allergies','row'=>'3')); ?></td>
                       <!-- <td class="tdLabel" id="boxSpace"> <?php echo __('UIDDate'); ?> <font color="red">*</font></td>
                       <td>
                       		<?php
                       			                      			 
                       			echo $this->Form->input('uiddate', array('class' => 'textBoxExpnd','type'=>'text','id' => 'uiddate')); ?>
                       </td>-->
                     </tr>
                   <!--   <tr>
                     	   <td class="tdLabel " id="boxSpace" valign="top" >Referral Doctor</td>
                        <td>
                         <?php //echo $this->Form->input('known_fam_physician', array('class' => 'textBoxExpnd','id' => 'knownPhysician'));
                       			$referalDisplay = $this->Session->read('rolename') == configure::read('admin') ? 'block' : 'none';
                       			if($referalDisplay == 'none')
						 			echo $reffererdoctors[$this->data['Person']['known_fam_physician']];
                       			
                              		echo $this->Form->input('known_fam_physician', array('empty'=>__('Please Select'), 'id'=>'familyknowndoctor','class'=>'textBoxExpnd', 'options'=>$reffererdoctors,'style'=>"display:$referalDisplay;",'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'getDoctorsList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    							 'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeDoctorsList', 'data' => '{familyknowndoctor:$("#familyknowndoctor").val()}', 'dataExpression' => true, 'div'=>false))));
                          ?>

                          <div id="changeDoctorsList">	
                          	 <?php $consultanData=unserialize($this->data['Person']['consultant_id']);
							
	                          	if($this->data['Person']['known_fam_physician']){
                                         // if consultant id  exist //
                                         if($consultanData){
	                           		 		echo $this->Form->input('Person.consultant_id', array('options' => $doctorlist, 'id' => 'doctorlisting','empty'=>'Please Select','value'=>$consultanData,'multiple' => true,'label'=> false, 'div' => false, 'error' => false,'style'=>"display:$referalDisplay"));
	                           		 		foreach($consultanData as $key =>$value){
	                           		 			$consultants[] = $doctorlist[$value];
	                           		 		}
	                           		 		if($referalDisplay == 'none')
	                           		 			echo '<span style="float: left;">'.implode('<br>',$consultants).'</span>';
										}
                                         // if registrar id exist //
                                         if($this->data['Person']['registrar_id']){
	                           		 		echo $this->Form->input('Person.registrar_id', array('options' => $registrarlist, 'empty' => 'Select Doctor', 'id' => 'doctorlisting','style'=>"display:$referalDisplay;", 'label'=> false, 'div' => false, 'error' => false));
	                           		 		if($referalDisplay == 'none')
	                           		 			echo '<span style="float: left;">'.$registrarlist[$this->data['Person']['registrar_id']].'</span>';
											}
	                          			}
                          	?>                        
	                      </div>
                          </td>
                   		
                           <td valign="middle" class="tdLabel" id="boxSpace">Family Physician Contact No.</td>
                        <td>
                        	<?php echo $this->Form->input('family_phy_con_no', array('class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'phyContactNo','MaxLength'=>'10')); ?>                        
                        </td>  
                     </tr> 
                      -->
                     <?php $label = ($this->Session->read('website.instance') == 'lifespring' && $this->data['Person']['initial_id'] == '7') ? 'Father Name' : 'Spouse Name' ;?>
                     <tr>
                        <td class="tdLabel" id="boxSpace"><?php echo __($label);?></td>
                       	<td><?php echo $this->Form->input('relative_name', array('class' => 'textBoxExpnd','id' => 'relativeName')); ?></td>
                    
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
                        								  'options'=>$instructions,'class' => 'textBoxExpnd','id' => 'instructions')); ?>
                        	</td>
                      
 						<td class="tdLabel" id="boxSpace">Identity Type</td>
                        <td><?php 
                      
                        echo $this->Form->input('vip_chk', array('class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','empty'=>__('Please Select'),'options'=>array('1'=>'VIP Covid','2'=>'Regular Covid','3'=>'Non Covid'),'error'=>false,'label'=>false,'id'=>'identity_type')); ?></td>
                        
                       
                     
                      
						  <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo('Emergency Contact Name');?></td>
	                        <td><?php echo $this->Form->input('patient_owner', array('class' => 'textBoxExpnd','id' => 'patient_owner')); ?></td>
	                     
	                        <td class="tdLabel" id="boxSpace"><?php echo('Emergency Contact No.');?></td>
	                        <td><?php echo $this->Form->input('asst_phone', array('class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'asst_phone','MaxLength'=>'10')); ?></td>
	                      </tr>
	                     <tr>
                                <td class="tdLabel" id="boxSpace"><?php echo __('Email');?></td>
	                        <td><?php echo $this->Form->input('email', array('class' => 'validate["",custom[email]] textBoxExpnd','id' => 'email')); ?></td>
	                      
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Fax');?></td>
	                        <td><?php echo $this->Form->input('fax', array('class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'email','MaxLength'=>'10')); ?></td>
	                     </tr>

	                     <tr>
                              <td class="tdLabel" id="boxSpace"><?php echo __('Billing Link'); ?></td>
										<td ><?php echo $this->Form->input('billing_link', array('type'=>'text', 'id' => 'billing-link','value'=>$expectedAmount['FinalBilling']['billing_link'],'label'=>false,'div'=>false,'class'=>'textBoxExpnd billPrepareInput'));?></td> 

										<td class="tdLabel" id="boxSpace"><?php echo __('Referal Letter'); ?></td>
										<td >
											<?php echo $this->Form->input('referral_letter', array('type'=>'file','id' => 'referral-letter','label'=>false,'div'=>false,'class'=>'textBoxExpnd billPrepareInput'));
		    								
		    								?>
										</td>
	                     </tr>
	                     
	                                         </tr>
		<?php    
			if($website=='lifespring'){  ?>   
                  <tr class="pregnant" style='display:none;'>
					<td class="tdLabel" id="boxSpace"><?php echo __('Is Pregnant');?></td>
						<?php $val = ($this->data['Person']['pregnant_week']) ? '' : 'display : none';?> 
					<td ><?php echo $this->Form->checkbox('is_pregnent', array('legend'=>false,'label'=>false,'class' => 'is_pregnent',
										'id'=>'is_pregnent','checked'=>$this->data['Person']['pregnant_week'], 'style'=>"width: 3%; float: left;")); ?> 
						<span class="hideRow" style="width : 50% ; display : <?php echo $val;?>"><?php echo $this->Form->input('Person.pregnant_week',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'pregnant_week','id' =>'pregnant_week','value'=>$this->data['Person']['pregnant_week']));
						?>Weeks </span></td>
					<td class="tdLabel hideRow" id="boxSpace" style="<?php echo $val;?>"><?php echo __('EDD');?> </td>
					<td class ="hideRow" style="<?php echo $val;?>"> <?php 
						$dates = $this->DateFormat->formatDate2Local($this->data['Person']['expected_date_del'],Configure::read('date_format'));// debug($dates);
						echo $this->Form->input('Person.expected_date_del',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'edd ',
										'id' => 'edd','value'=>$dates,'style'=>"float: left;"));?></td>	
							</tr>	
				<?php } ?>
					
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
                   <!--   <div style="text-align:left;">
                     	<?php 
					   		//echo $this->Form->input('admission_type',array('id'=>'admission_type','type'=>'select','options'=>Array('IPD'=>'IPD','OPD'=>'OPD','emergency'=>'EMERGENCY'),'class'=>'validate[required,custom[mandatory-select]]','empty'=>'Please Select'));
					   ?>
                       <input type="submit" id="goforpatientbyotherway" value="Submit And Register" class="blueBtn" style="text-align:left;">
                    </div>   -->         
                    <?php 
			if($this->params->query['from']=='appointments_management'){ ?>
			      <div class="btns">
                          <input class="blueBtn" type="button" value="Cancel" 
                           	onclick="window.location='<?php echo $this->Html->url(array("controller" => 'Appointments',
                           	"action" => "appointments_management"));?>'">
						  <input class="blueBtn" type="submit" value="Submit" id="submit">
					</div>
			     <?php   }
                   else{?>
                   <div class="btns">
                          <input class="blueBtn" type="button" value="Cancel" 
                           	onclick="window.location='<?php echo $this->Html->url(array("controller" =>'Persons',
                           	"action" => "patient_information",$this->data['Person']['id']));?>'">
						  <input class="blueBtn" type="submit" value="Submit" id="submit">
					</div>
					<?php }	  
						  
                  ?> 
			<?php //EOF new form design ?>			 
	  </div>
 <?php echo $this->Form->end(); ?>
 
<script>
var prevAgeDay = "<?php echo $this->data['Person']['age_day']; ?>";
var prevMonth = "<?php echo $this->data['Person']['age_month']?>";
		jQuery(document).ready(function(){
			
			 if( $("#no_number").is(':checked'))	 {
            	 $('#mobile').removeClass('validate[required,custom[phone,minSize[10],onlyNumber]]');
            	 $('#mobile').attr('disabled', 'disabled');
               }    
			
			 	
			if('<?php echo $this->data['Person']['payment_category']?>' =='cash'){
				$('#tariff').val('7');
		}else if('<?php echo $this->data['Person']['payment_category']?>' =='Corporate'){
				$('#showwithcard').hide('fast');  
	            $('#showwithcardInsurance').show('slow'); 
	            $('#showwithcardInsurance :input').attr('disabled', false);
	            $('#showwithcard :input').attr('disabled', true);
		}else if('<?php echo $this->data['Person']['payment_category']?>' =='Insurance company'){
			 $('#showwithcard').hide('fast');  
	            $('#showwithcardInsurance').show('slow'); 
	            $('#showwithcardInsurance :input').attr('disabled', false);
	            $('#showwithcard :input').attr('disabled', true);
		}
		else if('<?php echo $this->data['Person']['payment_category']?>' =='TPA'){
			 $('#showwithcard').hide('fast');  
	            $('#showwithcardInsurance').show('slow'); 
	            $('#showwithcardInsurance :input').attr('disabled', false);
	            $('#showwithcard :input').attr('disabled', true);
		};
		
		$(".edd").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			minDate: new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate();?>',		
		});	
			
			// binds form submission and fields to the validation engine
			$('#submit,#submit1').click(function(){  
				jQuery("#admission_type").removeClass('validate[required,custom[mandatory-select]]');	
			 	$("#admission_type").validationEngine("hidePrompt");
			 	var validatePerson = jQuery("#personfrm").validationEngine('validate'); 
			 	if(parseInt($('#ageMonth').val()) >= 12){
					$('#ageMonth').validationEngine('showPrompt', 'Month should be less than 12.', 'text', 'topRight', true);
					validatePerson = false;
				}
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

			$('#initials').change(function(){
				var getInitial=$("#initials option:selected").val();
				if(getInitial=='2' || getInitial=='3'|| getInitial=='6'){
					$("#sex").val('female');
					//var getInitial=$("#sex option:selected").val();
				}else if(getInitial=='1' || getInitial=='5') {
					$("#sex").val('male');
				}else{
					$("#sex").val(''); 
				}
			});			
		/*	$( "#dob" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '-50:+50',
				maxDate: new Date(),
				dateFormat: "dd/mm/yy"
			});*/
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
							$('#age').val(age[0]);
							setAge();//.trigger('change');
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
					$('#ageMonth').val(prevMonth);
					return false;
				}
		      if(parseInt($('#ageDay').val()) > 31){
					$('#ageDay').validationEngine('showPrompt', 'Day should be less than 31.', 'text', 'topRight', true);
					$('#ageDay').val(prevAgeDay);
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
                       /* $( "body" ).click(function() {
                                 var dateofbirth = $( "#dob" ).val();
				 if(dateofbirth !="") {
                                  var currentdate = new Date();
                                  var splitBirthDate = dateofbirth.split("/");
                                  var caldateofbirth = new Date(splitBirthDate[2]+"/"+splitBirthDate[1]+"/"+splitBirthDate[0]+" 00:00:00");
                                  var caldiff = currentdate.getTime() - caldateofbirth.getTime();
                                  var calage =  Math.floor(caldiff / (1000 * 60 * 60 * 24 * 365.25));
                                  $( "#age" ).val(calage+ ' Years');
                                }
                                
			 });*/
			/* $("body").click(function() {
							var dateofbirth = $("#dob").val();
							if (dateofbirth != "") {
								var currentdate = new Date();
								var splitBirthDate = dateofbirth
										.split("/");
								var year=$.trim(splitBirthDate['2']);
								var month=$.trim(splitBirthDate['1']);
								var day=$.trim(splitBirthDate['0']);
								var caldateofbirth = new Date(year+"/"+month+"/"+day+" 00:00:00");
								var caldiff = currentdate.getTime()- caldateofbirth.getTime();
								var calage = Math
										.floor(caldiff
												/ (1000 * 60 * 60 * 24 * 365.25));
								$("#age").val(calage);
							}

						});*/
				
						
					$('#sex').change(function(){
						var getSex=$("#sex option:selected").val();					
						var ageValue=$('#age').val();
						if($("#initials").val() == '7')return false;	
						if(getSex=='female'){
							if(ageValue!='' && ageValue<=10){			
								$("#initials").val('6');
							}else if(ageValue=='' || ageValue>=10) {			
								$("#initials").val('2');
							}
						}else if(getSex=='male') {	
							if(ageValue!='' && ageValue<=10){			
								$("#initials").val('5');
							}else if(ageValue=='' || ageValue>=10) {			
								$("#initials").val('1');
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
	            
				}); //EOF document

				$('#no_number').click(function(){
					if($("#no_number").is(':checked')){
						$('#mobile').removeClass('validate[required,custom[phone,minSize[10],onlyNumber]]');
						jQuery('#mobile').validationEngine('hide');
						 $('#mobile').attr('disabled', 'disabled');
					       $( "#mobile" ).val("");
					}else{
						$('#mobile').addClass('validate[required,custom[phone,minSize[10],onlyNumber]]');
						 $('#mobile').removeAttr('disabled', 'disabled');
					}  
					});
				$('#is_pregnent').click(function(){
					$('.hideRow').hide();			
					if($("#is_pregnent").is(':checked')){	
						$('.hideRow').show();
					}else{
						$('.hideRow').hide();
						$('#edd').val("");
						$('#pregnant_week').val("");
					}
				});	
				if(('<?php echo $someData['Person']['pregnant_week']?>')){
					$(".pregnant").show();
					}else{
					$(".pregnant").hide();
				} 

				function setAge(){	
					var ageValue=$('#age').val();
					var getSex=$("#sex").val();	
					if(ageValue<=10){
						if(getSex=='male'){
							$("#initials").val('5');
						}else if(getSex=='female'){
							$("#initials").val('6');
						}else{
							$("#initials").val('5');
						}
					}else{
						if(getSex=='male'){
							$("#initials").val('1');
						}else if(getSex=='female'){
							$("#initials").val('2');
						}else{
							$("#initials").val('');
						}
						
					}	
				}		
</script>
