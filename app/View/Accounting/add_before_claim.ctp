<?php echo $this->Html->script(array('ui.datetimepicker.3.js','jquery.autocomplete'));
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->script(array('jquery.autocomplete','jquery.treeview','donetyping','jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.autocomplete.css','jquery.treeview.css','billing.css'));?>

<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }

     ?></td>
	</tr>
</table>
<?php } ?>
<style>
<!--
select {
	width: 350px;
}
-->
</style>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#tariffstandard").validationEngine();
	});
	
</script>

<div class="inner_title">
	<h3>
		<?php echo __('Add Before Claim Submission'); ?>
	</h3>
	<span><?php  echo $this->Html->link('Back',array("controller"=>"tariffs","action"=>"viewStandard"),array('escape'=>false,'class'=>'blueBtn','title'=>'Back')); ?>
	</span>

</div>
<?php echo $this->Form->create('tariffstandard',array('type' => 'file','id'=>'tariffstandard','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	class="formFull" style="padding-top: 10px;" align="center">

	<tr>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Billing Status'); ?><font
			color="red">*</font>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('TariffStandard.billing_status', array('class' => 'validate[required,custom[mandatory-select]] ','empty'=>__('Select'), 'id' => 'billing_status','options'=>Configure::read('billing_status'), 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"></td>
		<td width="25%"></td>
	</tr>


	<tr class="row_title">
		<td width="19%" align="center" colspan="4"
			style="padding-right: 678px;"><strong><?php echo __('HCFA Box 10-Is Patient\'s Conditions Ralated to'); ?>
		</strong>
		</td>
	</tr>


	<tr>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Employment'); ?>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('TariffStandard.employment', array('class' => '','type'=>'text', 'id' => 'employment', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;'));
		?>
		</td>

		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Last Related Visit Date'); ?>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('TariffStandard.last_visit_date', array('type'=>'text', 'id' => 'last_visit_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
		?> <?php echo __('(HCFA Box #19)'); ?></td>
	</tr>

	<tr>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Other Accident'); ?>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('TariffStandard.other_accident', array('type'=>'text','class' => '', 'id' => 'other_accident', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;'));
		?>
		</td>

		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Onset Date'); ?>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('TariffStandard.onset_date', array('type'=>'text', 'id' => 'onset_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
		?> <?php echo __('(HCFA Box #14)'); ?></td>
	</tr>

	<tr>

		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Auto Accident'); ?>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('TariffStandard.auto_accident', array('type'=>'text','class' => '', 'id' => 'auto_accident', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;'));
		?>
		</td>

		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Initial Visit Date'); ?>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('TariffStandard.initial_visit_date', array('type'=>'text', 'id' => 'initial_visit_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
		?>
		</td>
	</tr>
</table>


<table border="0" cellpadding="0" cellspacing="0" width="100%"
	class="formFull" style="padding-top: 10px;" align="center">
	<tr class="row_title">
		<td width="19%" align="center" colspan="4"
			style="padding-right: 855px;"><strong><?php echo __('Hospitalization Info'); ?>
		</strong>
		</td>
	</tr>

	<tr>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Admission Date'); ?><font
			color="red">*</font>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('TariffStandard.admission_date', array('type'=>'text', 'id' => 'admission_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd validate[required,custom[mandatory-date]] '));
		?>
		</td>

		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Discharge Date'); ?>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('TariffStandard.discharge_date', array('type'=>'text', 'id' => 'discharge_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
		?>
		</td>
	</tr>

	<tr>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Start Care Date'); ?>
		</td>
		<td width="25%"><?php echo $this->Form->input('TariffStandard.start_care_date', array('type'=>'text', 'id' => 'start_care_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
		?>
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('End Care Date'); ?>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('TariffStandard.end_care_date', array('type'=>'text', 'id' => 'end_care_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
		?>
		</td>
	</tr>
</table>


<table border="0" cellpadding="0" cellspacing="0" width="100%"
	class="formFull" style="padding-top: 10px;" align="center">
	<tr>
		<td colspan="2" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="98%"
				align="center" style="padding-top: 10px;" class="formFull">
				<tr>
					<td valign="top">
						<table border="0" cellpadding="0" cellspacing="0" width="100%"
							valign="top" style="padding-left: 5px; padding-right: 5px;">
							<tr>
								<td>
									<table border="0" cellpadding="0" cellspacing="0"
										class="formFull" width="100%" valign="top">
										<tr>
											<td class="tdLabel " id="boxSpace" width="55%"><strong> <?php echo __('ICD-9 Codes'); ?>
											</strong>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.icd_codes', array('class' => '','type'=>'text', 'id' => 'icd_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find Diagnosis codes'));
											?>
											</td>
										</tr>

										<tr class="row_gray">
											<td class="tdLabel" id="boxSpace"><strong> <?php echo __('#'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Code'); ?>
											</strong>
											</td>
											<td width="11%"><strong><?php echo __('Description'); ?> </strong>
											</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr>
								<td>
									<table border="0" cellpadding="0" cellspacing="0"
										class="formFull" width="100%" valign="top">
										<tr>
											<td class="tdLabel " id="boxSpace" width="55%"><strong> <?php echo __('NDC Codes'); ?>
											</strong>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.ndc_codes', array('class' => '','type'=>'text', 'id' => 'ndc_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find NDC codes'));
											?>
											</td>
										</tr>
										<tr class="row_gray">
											<td class="tdLabel" id="boxSpace"><strong><?php echo __('NDC Code'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<?php echo __('Quantity'); ?> </strong></td>
											<td><strong> <?php echo __('Units'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Line Item'); ?>
											</strong>
											</td>
										</tr>

										</strong>
										</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr>
								<td>
									<table border="0" cellpadding="0" cellspacing="0"
										class="formFull" width="100%" valign="top" id='acpcsTable'>
										<tr>
											<td class="tdLabel " id="boxSpace" width="55%"><strong> <?php echo __('APC Codes'); ?>
											</strong>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.apc_codes', array('class' => 'apcs','type'=>'text', 'id' => 'apc_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find APC codes'));
											?> <?php echo $this->Form->input('',array('type'=>'checkbox','id'=>'checkForApcs','name'=>'chk'))."Check to search by Name";?>
											</td>
										</tr>
										<tr class="row_gray">
											<td class="tdLabel" id="boxSpace"><strong><?php echo __('APC Code'); ?>
											</strong></td>
											<td class="tdLabel" id="boxSpace"><?php echo __('Name'); ?>
												</strong></td>
											<td class="tdLabel" id="boxSpace"><strong> <?php echo __('Price'); ?>
											</strong></td>
										</tr>

										</strong>
										</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table border="0" cellpadding="0" cellspacing="0"
										class="formFull" width="100%">
										<tr>
											<td class="tdLabel " id="boxSpace" width="55%"><strong> <?php echo __('Custom Codes'); ?>
											</strong>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.custom_codes', array('class' => '','type'=>'text', 'id' => 'custom_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find Custom Procedure codes'));
											?>
											</td>
										</tr>
										<tr class="row_gray">
											<td class="tdLabel" id="boxSpace"><strong><?php echo __('Code'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Description'); ?>
											</strong>
											</td>
											<td><strong> <?php echo __('Price'); ?>
											</strong>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>


					<td valign="top">
						<table border="0" cellpadding="0" cellspacing="0" align="center"
							width="100%" style="padding-right: 5px;">
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" width="100%"
										class="formFull">
										<tr>
											<td class="tdLabel " id="boxSpace" width="37%"><strong> <?php echo __('CPT Codes'); ?>
											</strong>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.cpt_codes', array('class' => '','type'=>'text', 'id' => 'cpt_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find CPT Procedure codes'));
											?>
											</td>
										</tr>
										<tr class="row_gray">
											<td class="tdLabel" id="boxSpace"><strong><?php echo __('Code'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Description'); ?>
											</strong></td>
											<td><strong><?php echo __('Price'); ?> </strong>
											</td>
										</tr>

										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><strong><font
													color="#6C95AC"><?php echo __('1'); ?>&nbsp;&nbsp;&nbsp;<?php echo __('99347'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('HOME VISIT EST PATIENT'); ?>
												</font> </strong></td>
											<td width="11%"><?php echo $this->Form->input('TariffStandard.codes_home', array('class' => '','type'=>'text', 'id' => 'codes_home', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));?>
												<?php echo $this->Html->link($this->Html->image('icons/cross.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'addBeforeClaim', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;padding-right:10px;'),__('Are you sure?', true)); ?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('99347 Modifiers:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.modifiers1', array('class' => '', 'id' => 'modifiers1','empty'=>__('Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:85px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('TariffStandard.modifiers2', array('class' => '', 'id' => 'modifiers2','empty'=>__('Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:85px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('TariffStandard.modifiers3', array('class' => '', 'id' => 'modifiers3','empty'=>__('Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:85px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('TariffStandard.modifiers4', array('class' => '', 'id' => 'modifiers4','empty'=>__('Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:85px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Quantity/Minutes:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.quantity1', array('class' => '','type'=>'text', 'id' => 'quantity1', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Diagnosis Pointers:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.diagnosis_pointers1', array('class' => '','type'=>'text', 'id' => 'diagnosis_pointers1', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><strong><font
													color="#6C95AC"><?php echo __('2'); ?>&nbsp;&nbsp;&nbsp;<?php echo __('99174'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('OCULAR INSTRUMNT SCREEN BILL'); ?>
												</font> </strong></td>
											<td width="11%"><?php echo $this->Form->input('TariffStandard.cpt_codes', array('class' => '','type'=>'text', 'id' => 'cpt_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));?>
												<?php echo $this->Html->link($this->Html->image('icons/cross.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'addBeforeClaim', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;padding-right:10px;'),__('Are you sure?', true)); ?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('99174 Modifiers:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.modifiers5', array('class' => '', 'id' => 'modifiers5','empty'=>__('Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:85px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('TariffStandard.modifiers6', array('class' => '', 'id' => 'modifiers6','empty'=>__('Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:85px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('TariffStandard.modifiers7', array('class' => '', 'id' => 'modifiers7','empty'=>__('Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:85px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('TariffStandard.modifiers8', array('class' => '', 'id' => 'modifiers8','empty'=>__('Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:85px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Quantity/Minutes:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.quantity2', array('class' => '','type'=>'text', 'id' => 'quantity2', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Diagnosis Pointers:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.diagnosis_pointers2', array('class' => '','type'=>'text', 'id' => 'diagnosis_pointers2', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr>

									</table>
								</td>
							</tr>

							<tr>
								<td>
									<table border="0" cellpadding="0" cellspacing="0"
										class="formFull" width="100%" id='hcpcsTable'>
										<tr>
											<td class="tdLabel " id="boxSpace" width="37%"><div
													id='errorDiv' style="display: none"></div> </strong>
											</td>
										</tr>
										<tr>
											<td class="tdLabel " id="boxSpace" width="37%"><strong> <?php echo __('HCPCS Codes'); ?>
											</strong>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('TariffStandard.hcpcs_codes', array('class' => 'hcpcs','type'=>'text', 'id' => 'hcpcs_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find HCPS Procedure codes'));
											?> <?php echo $this->Form->input('',array('type'=>'checkbox','id'=>'checkForName','name'=>'chk'))."Check to search by Name";?>
											</td>
										</tr>
										<tr class="row_gray">
											<td class="tdLabel" id="boxSpace"><strong><?php echo __('Description'); ?>
											</strong>
											</td>
											<td><strong> <?php echo __('Code'); ?>
											</strong>
											</td>
											<td><strong> <?php echo __('Price'); ?>
											</strong>
											</td>
										</tr>

									</table>
								</td>
							</tr>
						</table>

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td class="tdLabel" id="boxSpace" width="19%"><?php echo $this->Form->input('TariffStandard.note_clck', array('type'=>'checkbox','id' => 'note_clck','label'=>false,'title'=>'')); ?>
			<?php echo __('Include note in EDI Billing:'); ?>
		</td>
		<td width="45%"><?php 
		echo $this->Form->input('TariffStandard.note_edi_billing', array('class' => '', 'id' => 'note_edi_billing', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:890px;','placeholder'=>'Custom NTE EDI Billing Note(a.k.a.HCFA/CMS-1500 Line 19)'));
		?>
		</td>
	</tr>
</table>
<div class="btns">
	<?php
	//echo "&nbsp;&nbsp;".$this->Form->submit('Save & Close',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Save & Close'));
	echo "&nbsp;&nbsp;".$this->Form->submit('Save',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Save'));
	//echo "&nbsp;&nbsp;".$this->Form->submit('Delete',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Delete'));
	echo $this->Html->link(__('Cancel'),array('action' => 'addBeforeClaim'),array('escape' => false,'class'=>'grayBtn','title'=>'Cancel'));
	?>
</div>
<?php echo $this->Form->end(); ?>
<script>

$(document).ready(function(){
	$('#billing_status').focus();
	
	$("#onset_date,#last_visit_date,#initial_visit_date,#admission_date,#discharge_date,#start_care_date,#end_care_date")
	.datepicker(
			{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
			$(this).focus();
			}

		});		
	 });
//------------------------------FOR HCPCS-----------------------------------------------------------------------------------------------------------------------------
var calling_url = "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "hcpcsSearch","admin" => false)); ?>" ;
var timeoutReference;
$(function() {
	$('.hcpcs').live('keyup',function() { 
		var _this = $(this); // copy of this object for further usage
	    
	    if (timeoutReference) clearTimeout(timeoutReference);
	    timeoutReference = setTimeout(function() {
	    	getHCPCSDetails()
	    }, 2000);
	});
	});

function getHCPCSDetails(){
	var checkName=$('#checkForName:checked').length;
	var codeHCPS=$('#hcpcs_codes').val();
	if(checkName==1){
		var nameHCPS=checkName;
	}else{
		var nameHCPS='';
	}
	//var cdmCode = $('#hcpcs_codes').html().replace("&nbsp;","");
	if(httpRequest) httpRequest.abort();
	//if(lastCDMCode != cdmCode){
		var httpRequest = $.ajax({
			  beforeSend: function(){
				  $('#busy-indicator').show('fast');
			  },
		      url: calling_url+"/"+codeHCPS+"/"+nameHCPS,
		      context: document.body,
		      success: function(data){ 
		    	  $('#busy-indicator').hide('fast');
		    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
		    	  var checkValue=data.code;
		    	  $('#checkForName').val('0');
		    	  $('#hcpcs_codes').val('');
		    	  if(checkValue!=null){
			    	 
		    	 	 addRowWithHCPCSDetails(data,'');
		    	  }
		    	  else{
			    	 
		    		  $('#errorDiv').show();
			    	  $('#errorDiv').html('Check code');
		    	  }
		    	  
		    	  //onCompleteRequest(); //remove loading sreen
		    	  //$("#excelArea").html(data).fadeIn('slow');
			  },
			  error:function(){
					alert('Please try again');
					//onCompleteRequest(); //remove loading sreen
				  }
		});
	///}
}

function addRowWithHCPCSDetails(data,pickedId){
	 if(data != '' && data !== undefined){
	//	$('#hcpcsTable' tr:last').remove();
		$("#hcpcsTable").find('tbody')
	    .append($('<tr>').attr('class', '').attr('id', 'data'+data.code)
	    		 .append($('<td style="padding-left:20px">').text(data.name))
				        .append($('<td>').text(data.code))
				        .append($('<td>').text('$'+data.price)) 
				        );
		addBlankRow();
		
	}
}
function addBlankRow(){
	$("#hcpcsTable").find('tbody')
    .append($('<tr>')
    		 .append($('<td contenteditable>').attr('class', 'searchCDM').attr('id', 'data').append('&nbsp;'))
			        .append($('<td>').text(''))
			        .append($('<td>').text(''))
			        .append($('<td>').text())
			       
    );
	
}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------FOR APCS-----------------------------------------------------------------------------------------------------------------------------
var calling_url_apcs = "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "apcsSearch","admin" => false)); ?>" ;
var timeoutReferenceApcs;
$(function() {
	$('.apcs').live('keyup',function() { 
		var _this = $(this); // copy of this object for further usage
	    
	    if (timeoutReferenceApcs) clearTimeout(timeoutReferenceApcs);
	    timeoutReferenceApcs = setTimeout(function() {
	    	getAPCSDetails()
	    }, 2000);
	});
	});

function getAPCSDetails(){
	var checkName=$('#checkForApcs:checked').length;
	var codeApcs=$('#apc_codes').val();
	if(checkName==1){
		var nameAcps=checkName;
	}else{
		var nameAcps='';
	}
	//var cdmCode = $('#hcpcs_codes').html().replace("&nbsp;","");
	if(httpRequest) httpRequest.abort();
	//if(lastCDMCode != cdmCode){
		var httpRequest = $.ajax({
			  beforeSend: function(){
				  $('#busy-indicator').show('fast');
			  },
		      url: calling_url_apcs+"/"+codeApcs+"/"+nameAcps,
		      context: document.body,
		      success: function(data){ 
		    	  $('#busy-indicator').hide('fast');
		    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
		    	  //var checkValue=data.code;
		    	  $('#checkForApcs').val('0');
		    	  $('#apc_codes').val('');
		    	 	 addRowWithACPCSDetails(data,'');
					  //onCompleteRequest(); //remove loading sreen
		    	  //$("#excelArea").html(data).fadeIn('slow');
			  },
			  error:function(){
					alert('Please try again');
					//onCompleteRequest(); //remove loading sreen
				  }
		});
	///}
}

function addRowWithACPCSDetails(data,pickedId){
	 if(data != '' && data !== undefined){
	//	$('#hcpcsTable' tr:last').remove();
		$("#acpcsTable").find('tbody')
	    .append($('<tr>').attr('class', '').attr('id', 'data'+data.code)
	    		 .append($('<td style="padding-left:20px">').text(data.name))
				        .append($('<td>').text(data.code))
				         .append($('<td>').text("$00.0"))
				        );
		addBlankRow1();
		
	}
}
function addBlankRow1(){
	$("#acpcsTable").find('tbody')
    .append($('<tr>')
    		 .append($('<td contenteditable>').attr('class', 'searchCDM2').attr('id', 'data').append('&nbsp;'))
			        .append($('<td>').text(''))
			        .append($('<td>').text(''))
			        .append($('<td>').text())
			       
    );
	
}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
</script>
