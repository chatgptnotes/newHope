<?php
     echo $this->Html->script(array('jquery.autocomplete'));   
	 echo $this->Html->script(array('jquery.fancybox-1.3.4'));
	   echo $this->Html->css('jquery.autocomplete.css');
     echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
?>

<div class="inner_title">
	<h3>&nbsp; <?php echo __('Patient Details', true); ?></h3>
	<span> <?php echo $this->Html->link(__('Search UID Patient'),array('action' => 'search'), array('escape' => false,'class'=>'blueBtn')); ?></span>
</div>
<?php

	echo $this->Form->create('Person',array('type' => 'file','name'=>'register','id'=>'personfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); 
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
						<?php 
							/*if(isset($redirectTo)){
								echo $this->Html->link(__('Cancel', true),array('controller'=>'nursings','action' => 'search/'), array('escape' => false,'class'=>'grayBtn'));
							} else {
								echo $this->Html->link(__('Cancel', true),array('controller'=>'persons','action' => 'search/'), array('escape' => false,'class'=>'grayBtn'));
							}*/
							echo $this->Html->link(__('Cancel'),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
						?>
						  <input class="blueBtn" type="submit" value="Submit">
                   </div>
                   <div class="clr"></div>
				  
                   <!-- Patient Information start here -->
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5"><?php echo __("Patient Information") ; ?></th>
                      </tr>
                      <tr>
                        <td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("First Name");?><font color="red">*</font></td>
                        <td width="30%"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                          	<td><?php echo $this->Form->input('initial_id', array('empty'=>__('Select'),'options'=>$initials,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'initials','style'=>'width:80px')); ?></td>
                            <td>                            	 
                            	<?php echo $this->Form->input('first_name', array('class' => 'validate[required,custom[name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'first_name')); ?>
                            </td>                           
                          </tr>
                        </table></td>
                        <td width="">&nbsp;</td>
						 <td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Last Name');?><font color="red">*</font></td>
                        <td>
                        	<?php echo $this->Form->input('last_name', array('class' => 'validate[required,custom[patient_last_name],custom[onlyLetterNumber]] textBoxExpnd','id' => 'last_name')); ?>
                        </td> 
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
							<td>&nbsp;</td>
							<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Sex');?> <font color="red">*</font></td>
							<td width="30%">
								<?php  
									echo $this->Form->input('sex', array('options'=>array(""=>__('Please Select Sex'),"male"=>__('Male'),'female'=>__('Female')),'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'sex')); ?>
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
                        <td class="tdLabel" id="boxSpace">Tariff<font color="red">*</font></td>
                       	<td><?php echo $this->Form->input('tariff_standard_id', array('empty'=>__('Please Select'),'options'=>$tariffStandard,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="middle" class="tdLabel" id="boxSpace">&nbsp;</td>
                        <td>
                        	&nbsp;
                        </td>
                     </tr>
                      
                    </table>
                    <!-- Patient Information end here -->
                    
					<p class="ht5"></p>
                    
                    <!-- Links to Records start here -->
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
	                        <td><?php echo $this->Form->input('city', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'city')); ?></td>
	                        <td>&nbsp;</td>
                                <td class="tdLabel" id="boxSpace"><?php echo __('Village/Taluka');?></td>
	                        <td><?php echo $this->Form->input('taluka', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'village')); ?></td>
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
	                        <td><?php echo $this->Form->input('nationality', array('class' => 'textBoxExpnd','id' => 'email','Value'=>'Indian')); ?></td>
	                     </tr>
	                      <tr>
	                        <td  class="tdLabel" id="boxSpace"><?php echo __('Home Phone No.');?></td>
	                         <td><?php echo $this->Form->input('home_phone', array('class' => 'textBoxExpnd','id' => 'home_phone')); ?></td>
	                        <td>&nbsp;</td>
	                        <td class="tdLabel" id="boxSpace"><?php echo('Mobile Phone No.');?></td>
	                        <td><?php echo $this->Form->input('mobile', array('class' => 'textBoxExpnd','id' => 'mobile')); ?></td>
	                      </tr>
						  
	                      <tr>
	                        <td class="tdLabel" id="boxSpace"><?php echo __('Email');?></td>
	                        <td><?php echo $this->Form->input('email', array('class' => 'validate["",custom[email]] textBoxExpnd','id' => 'email')); ?></td>
	                        <td>&nbsp;</td>
	                        <td class="tdLabel" id="boxSpace">&nbsp;</td>
	                        <td>&nbsp;</td>
	                     </tr>
	                                        
                    </table>
                    <!-- EOF address infto and BOF diagnosis -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	                   	  <tr>
	                      	<th colspan="5"><?php echo __('Diagnosis');?></th>
	                      </tr>
	                      <tr>
	                        <td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Diagnosis');?></td>
	                        <td width="79%"><?php echo $this->Form->textarea('diagnosis', array('class' => 'textBoxExpnd','id' => 'diagnosis','style'=>'width:95%','rows'=>14)); ?></td> 
	                     </tr>
	                 </table>
                    <!-- EOF diagnosis -->
                     
                    <div class="btns" style="margin-top:0px;">
						<?php 
							/*if(isset($redirectTo)){
								echo $this->Html->link(__('Cancel', true),array('controller'=>'nursings','action' => 'search/'), array('escape' => false,'class'=>'grayBtn'));
							} else {
								echo $this->Html->link(__('Cancel', true),array('controller'=>'persons','action' => 'search/'), array('escape' => false,'class'=>'grayBtn'));
							}*/
						?>
                       	<?php
						echo $this->Html->link(__('Cancel'),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
						?>
						  <input class="blueBtn" type="submit" value="Submit" id="submit1">
                     </div>
			<?php //EOF new form design ?>			 
	  </div>
 <?php echo $this->Form->end(); ?>
 
<script>
		jQuery(document).ready(function(){
			jQuery("#personfrm").validationEngine();	
			
			$( "#dob" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '-50:+50',
				maxDate: new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
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
                       
                     
		});
	 
	</script>
