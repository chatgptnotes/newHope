<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
//	jQuery("#PharmacyItemInventoryAddItemForm").validationEngine();
	});

</script>
<?php
  echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
  if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center" style="color:red">
 <tr>
  <td colspan="2" align="center">
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
<?php if($_SESSION['roleid'] == '45'){?>
<?php echo $this->element('portal_header');?>
<!--  <div align="right" > <a href="#" id="change_login_date"><?php echo __("Change Login Date");?></a></div>-->
<?php }?>
<div style="margin-bottom: 55px;"></div>
 <div class="inner_title">
<h3> &nbsp; <?php echo __('Payer Management - Add Insurance', true); ?></h3>
	<span style="margin-top:-25px;">

	</span>

</div>

  <div class="clr ht5"></div>
  <?php  echo $this->Form->create('NewInsurance',array('id'=>'newinsurance'));?>
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">

		           	  <tr>
                        <td width="100" valign="middle" class="tdLabel" id="boxSpace">Payer Name<font color="red">*</font></td>
                        <td width="250"><?php echo $this->Form->input('NewInsurance.insurance_type_id', array('label'=>false,'empty'=>__('Select'),'options'=>$getDataInsuranceType
                        		,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'insurance_type_id','selected'=>$getDataForEdit['0']['NewInsurance']['insurance_type_id'])); ?></td>
                        <td width="">&nbsp;</td>
                        <td width="100" class="tdLabel" id="boxSpace">Plan<font color="red">*</font></td>
                        <td width="250">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td width=""><?php echo $this->Form->input('NewInsurance.insurance_company_id', array('label'=>false,'empty'=>__('Select'),'options'=>$getDataInsuranceCompany
                            		,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'insurance_company_id','selected'=>$getDataForEdit['0']['NewInsurance']['insurance_company_id'])); ?></td>

                          </tr>
                        </table></td>
                      </tr>

                      <tr>

                        <td class="tdLabel"  id="boxSpace">Priority<font color="red">*</font></td>
                        <td><?php echo $this->Form->input('NewInsurance.priority', array('label'=>false,'empty'=>__('Select'),'options'=>array('Primary'=>'Primary','Secondary'=>'Secondary','Unknown'=>'Unknown')
                        		,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'priority','selected'=>$getDataForEdit['0']['NewInsurance']['priority'])); ?></td>
						 <td>&nbsp;</td>
                        <td class="tdLabel" id="boxSpace">Insurance ID</td>
                        <td><?php echo $this->Form->input('NewInsurance.insurance_number', array('label'=>false
                        		,'id' => 'insurance_number','value'=>$getDataForEdit['0']['NewInsurance']['insurance_number'])); ?></td>
                      </tr>
                      <tr>
                        <td valign="middle" class="tdLabel" id="boxSpace">Group ID</td>
                        <td><?php echo $this->Form->input('NewInsurance.group_number', array('label'=>false
                        		,'id' => 'group_number','value'=>$getDataForEdit['0']['NewInsurance']['group_number'])); ?></td>
                        <td>&nbsp;</td>
                       <td class="tdLabel" id="boxSpace"> Effective from</td>
                       <td><?php echo $this->Form->input('NewInsurance.effective_date', array('label'=>false,'type'=>'text','value'=>$getDataForEdit['0']['NewInsurance']['effective_date'],'class' => 'textBoxExpnd','id' => 'efdate',"style"=>"width:85px")); ?></td>
                     </tr>
                     <tr>
                      <td class="tdLabel"  id="boxSpace">Copay type<font color="red">*</font></td>
                        <td><?php echo $this->Form->input('NewInsurance.copay_type', array('label'=>false,'empty'=>__("Select"),'options'=>array('Fixed','Percentage'),'class' => 'validate[required,custom[name]] textBoxExpnd'
                        		,'id' => 'copay_type','onchange'=>'javascript:getPercentage()','selected'=>$getDataForEdit['0']['NewInsurance']['copay_type'])); ?></td>
  						<td>&nbsp;</td>
                       <td class="tdLabel" id="boxSpace">Relation to insured</td>
                       <td><table width="100%" cellpadding="0" cellspacing="0" border="0">
                         <tr>
                          
                        <td><?php echo $this->Form->input('NewInsurance.relation', array('label'=>false,'empty'=>__("Select"),'options'=>array('self'=>'Self','spouse'=>'Spouse','child'=>'Child','other'=>'Other')
                        		,'id' => 'relation','selected'=>$getDataForEdit['0']['NewInsurance']['copay_type'])); ?></td>
                      <td>&nbsp;</td>

                         </tr>
                       </table></td>
                     </tr>
                     <tr><?php if(!empty($getDataForEdit['0']['NewInsurance']['fixed_percentage'])){
                     $dataFixPercentage=$getDataForEdit['0']['NewInsurance']['fixed_percentage'];
                     }
                     else{
						$dataFixPercentage="Enter Percentage(ex:30%)";
						}
						if(!empty($getDataForEdit['0']['NewInsurance']['fixed_amt'])){
							$dataFix=$getDataForEdit['0']['NewInsurance']['fixed_amt'];
						}
						else{
							$dataFix="Enter Amount(ex:$300)";
						}
						?>
                       <td valign="middle" class="tdLabel" id="boxSpace"></td>
                        <td><?php echo $this->Form->input('NewInsurance.fixed_percentage', array('label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd','value'=>$dataFixPercentage,'id' => 'fixed_percentage','hidden'=>true,'onclick'=>'javascript:removetext()'));
                        echo $this->Form->input('NewInsurance.fixed_amt', array('label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd','value'=>$dataFix,'id' => 'fixed_amt','hidden'=>true,'onclick'=>'javascript:removetext()')); ?></td>
                      <td>&nbsp;</td>
                      <td class="tdLabel" id="boxSpace"> Active</td>
					<td><?php echo $this->Form->checkbox('NewInsurance.is_active', array('label'=>false,
								'id' => 'is_active','checked'=>'checked')); ?></td>

                      </tr>
					         <tr>

						<?php echo $this->Form->hidden('NewInsurance.location_id', array('label'=>false,
								'value'=>$this->Session->read('locationid'),'id' => 'location_id')); ?>
						
						<?php echo $this->Form->hidden('NewInsurance.patient_uid', array('label'=>false,
								'value'=>$patient_id,'id' => 'patient_uid')); ?>
						


                      </tr>
                     </tr>
                    </table>
                    <div class="inner_title">
<h3> &nbsp; <?php echo __('Payer Management - Add Employer Information', true); ?></h3>
	<span style="margin-top:-25px;">

	</span>

</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">

		    

                      <tr>

                        <td style="padding-left:10px;width:50px;">Employer</td>
                        <td  style="padding-left:10px;width:50px;"><?php echo $this->Form->input('NewInsurance.employer', array('label'=>false,'div'=>false,'id' => 'employer','width'=>'30px')); ?></td>
						 <td>&nbsp;</td>
						 </tr>
						 <tr>
                        <td style="padding-left:10px;width:50px;">Note</td>
                        <td  style="padding-left:10px;width:500px;"><?php echo $this->Form->input('NewInsurance.note', array('label'=>false,'rows'=>'3','cols'=>'5'
                        		,'id' => 'note')); ?></td>
                      </tr>
       
                    
                    </table>

                   <!-- billing activity form end here -->
                   <div class="btns">
                            <!--  <input name="" type="button" value="Print" class="blueBtn" tabindex="11"/>-->  <?php
   echo $this->Form->submit(__('Submit'), array('escape' => false,'class'=>'blueBtn','id'=>'submit'));
   ?>
							  
                  </div>
        <?php echo $this->Form->end();?>
<p class="ht5"></p>


                    <!-- Right Part Template ends here -->                </td>
            </table>

<script>
$( "#expiry_date" ).datepicker({
			showOn: "button",
			buttonImage: "../../img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
		});
$("#efdate")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}

		});
</script>
<script>
function getPercentage(){
	//alert('hi');
	//copay_type option:selected
	var getData = $("#copay_type option:selected").val();
	//alert(getData);
	if(getData=='1'){
		$("#fixed_percentage").show();
		$("#fixed_amt").hide();
		
	}	
	else if(getData=='0'){
		$("#fixed_amt").show();
		$("#fixed_percentage").hide();
	}
}
 function removetext(){
	 
	 $("#fixed_amt").val(" ");
	 $("#fixed_percentage").val(" ");
 }
	
</script>
<script>
jQuery(document)
.ready(
		
		function() {
					//jQuery("#personfrm").validationEngine();
					 jQuery("#newinsurance").validationEngine({
				            validateNonVisibleFields: true,
				            updatePromptsPosition:true,
				        });

			$('#submit')
					.click(
							function() { 
								
								//jQuery("#sponsor-info").show();
								//jQuery("#uid-info").show();
								jQuery("#admission_type")
										.removeClass(
												'validate[required,custom[mandatory-select]]');
								$("#admission_type")
										.validationEngine(
												"hidePrompt");
								var validatePerson = jQuery(
										"#newinsurance")
										.validationEngine(
												'validate');
								if (validatePerson) {
									$(this).css('display', 'none');
								}
							});

			$('#submit')
			.click(
					function() { 
						var validate = jQuery("#newinsurance").validationEngine('validate');
						if (validate) {$(this).css('display', 'none');}
					});
		});
</script>