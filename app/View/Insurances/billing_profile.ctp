<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Billing Profile', true); ?>
	</h3>
</div>
<?php echo $this->Html->script(array('jquery-1.5.1.min.js','jquery.validationEngine','/js/languages/jquery.validationEngine-en',
		'jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js',
		'permission.js','pager','default.js','jquery.autocomplete'));
echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.fancybox-1.3.4.css'));
echo $this->Html->css('jquery.autocomplete.css');
?>
<?php echo $this->Form->create('BillingProfile',array('type' => 'file','id'=>'BillingProfileFrm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('BillingProfile.patient_id',array('value'=>$patient_id));
echo $this->Form->hidden('BillingProfile.id',array('value'=>$id));
echo $this->Form->hidden('BillingProfile.user_id',array('value'=>$getUserInfo['User']['id']));
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	class="formFull" style="padding-top: 10px;" align="center">
	<tr>
		<td class="tdLabel " id="boxSpace" width="25%"><strong> <?php echo __('Billing Profile Name'); ?><font
				color="red">*</font>
		</strong>
		</td>
		<td width="11%"><?php 
		echo $this->Form->input('BillingProfile.billing_profile_name', array('class' => 'textBoxExpnd validate[required,custom[mandatory-enter]] ','type'=>'text', 'id' => 'billing_profile_name', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;'));
		?>
		</td>
		<td width="56%"></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	class="formFull" align="center">
	<tr>
		<td colspan="2" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%"
				align="center">
		<tr>
		<td valign="top" width="50%">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" valign="top" style="padding-left: 2px; padding-right: 2px;">
		<tr>
			<td width="50%" valign="top">
				<table border="0" cellpadding="0" cellspacing="0" class="formFull" width="100%" valign="top">
				<tr>
				<td width="1%"><div id='icdError'></div></td>
				<td class="tdLabel " id="boxSpace" width="47%"><strong> <?php echo __('ICD-9 Codes'); ?>
				</strong>
				</td>
				<td width="47%"><?php 
				echo $this->Form->input('BillingProfile.icd_codes', array('class' => '','type'=>'text', 'id' => 'icd_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find Diagnosis codes'));
				?>
				</td>
				<td width="5%"><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('escape' => false,'onclick'=>'getIcdDetails()')); ?>
				</td>
				</tr>
				<tr class="row_gray" >
				<td colspan="4">
					<table border="0" cellpadding="0" cellspacing="0"
						width="100%" id='icdTable'>
						<tr>
							<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo __('#'); ?>
							</strong>
							</td>
							<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Code'); ?>
							</strong>
							</td>
							<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Description'); ?>
							</strong>
							</td>
							<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Action'); ?>
							</strong>
							</td>
						</tr>
					</table>
				</td>
				</tr>
				</table>
			</td>
		<!-- </tr>

		<tr> -->
			<td width="50%" valign="top">
				<table border="0" cellpadding="0" cellspacing="0"
					class="formFull" width="100%" valign="top">
					<tr>
					<td width="1%"><div id='ndcError'></div></td>
						<td class="tdLabel " id="boxSpace" width="47%"><strong> <?php echo __('NDC Codes'); ?>
						</strong>
						</td>
						<td width="47%"><?php 
						echo $this->Form->input('BillingProfile.ndc_codes12', array('class' => '','type'=>'text', 'id' => 'ndc_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find NDC codes'));
						?>
						</td>
						<td width="5%"><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('escape' => false,'onclick'=>'getNdcDetails1()')); ?>
						</td>
					</tr>
					<tr class="row_gray">
						<td colspan="4">
							<table border="0" cellpadding="0" cellspacing="0"
								width="100%" id='NdcTable'>
								<tr>
									<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo __('NDC Code'); ?>
									</strong>
									</td>
									<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Descrption'); ?>
									</strong>
									</td>
									<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('MedId'); ?>
									</strong>
									</td>
									<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Action'); ?>
									</strong>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<!-- <tr>
			<td>
				<table border="0" cellpadding="0" cellspacing="0"
					class="formFull" width="100%" valign="top" >
					<tr>
					<td width="1%"><div
							style='text-algin: center; color: red' id='errorDiv'></div></td>
						<td class="tdLabel " id="boxSpace" width="47%"><strong><?php echo __('APC Codes'); ?>
						</strong>
						</td>
						<td width="47%"><span id='apcs1'><?php 
						echo $this->Form->input('BillingProfile.apc_codes1', array('class' => 'apcs1','type'=>'text', 'id' => 'apc_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find APC codes'));
						?></span><span id='apcs2' style='display:none'><?php
						echo $this->Form->input('BillingProfile.apc_codes', array('class' => 'apcs2','type'=>'text', 'id' => 'apc_codes2', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find By Name'));
						?></span> <?php echo $this->Form->input('BillingProfile.check_for_apcs',array('type'=>'checkbox','id'=>'checkForApcs','name'=>'[BillingProfile][chk]'))."Check to search by Name";?>
						</td>
						<td width="5%"><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('escape' => false,'onclick'=>'getAPCSDetails1()')); ?>
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr class="row_gray">
						<td colspan="4">
							<table border="0" cellpadding="0" cellspacing="0"
								width="100%" id='acpcsTable1'>
								<tr>
									<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo __('APC Code'); ?>
									</strong>
									</td>
									<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Name'); ?>
									</strong>
									</td>
									<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Price'); ?>
									</strong>
									</td>
									<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Action'); ?>
									</strong>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr> -->
		
	</table>
</td>


					<!-- comment<td valign="top" width="50%">
						<table border="0" cellpadding="0" cellspacing="0" align="center"
							width="100%" style="padding-right: 5px;">
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" width="100%"
										class="formFull"  >
										<tr>
											<td class="tdLabel " id="boxSpace" width="48%"><strong> <?php echo __('CPT Codes'); ?>
											</strong>
											</td>
											<td width="47%"><?php echo $this->Form->input('BillingProfile.cpt_codes12', array('class' => 'ctpSearch','type'=>'text', 'id' => 'cptSerach', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find CPT Procedure codes'));
											?>
											</td>
											<td width="5%"><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('escape' => false,'onclick'=>'getCptCodeDetials()')); ?>
											</td>
											

										</tr>
										<tr class="row_gray">
											<td colspan="8">
												<table border="0" cellpadding="0" cellspacing="0" width="100%" id='cptTable'>
													<tr>
														<td class="tdLabel" id="boxSpace" width="13%"><strong> <?php echo __('Code'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Description'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Price'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Modifer');?></strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Modifer');?></strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Modifer');?></strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Modifer');?></strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Action');?></strong>
														</td>
													</tr>
												</table>
										
										</tr>

										<!-- <tr>
											<td class="tdLabel" id="boxSpace" width="37%"><strong><font
													color="#6C95AC"><?php //echo __('1'); ?>&nbsp;&nbsp;&nbsp;<?php echo __('99347'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('HOME VISIT EST PATIENT'); ?>
												</font> </strong></td>
											<td width="11%"><?php //echo $this->Form->input('BillingProfile.codes_home1', array('class' => '','type'=>'text', 'id' => 'codes_home', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));?>
												<?php //echo $this->Html->link($this->Html->image('icons/cross.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'addBeforeClaim', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;padding-right:10px;'),__('Are you sure?', true)); ?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('99347 Modifiers:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('BillingProfile.modifiers1', array('class' => '', 'id' => 'modifiers1','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:81px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('BillingProfile.modifiers2', array('class' => '', 'id' => 'modifiers2','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:81px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('BillingProfile.modifiers3', array('class' => '', 'id' => 'modifiers3','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:80px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('BillingProfile.modifiers4', array('class' => '', 'id' => 'modifiers4','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:80px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Quantity/Minutes:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('BillingProfile.quantity1', array('class' => '','type'=>'text', 'id' => 'quantity1', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Diagnosis Pointers:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('BillingProfile.diagnosis_pointers1', array('class' => '','type'=>'text', 'id' => 'diagnosis_pointers1', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><strong><font
													color="#6C95AC"><?php echo __('2'); ?>&nbsp;&nbsp;&nbsp;<?php echo __('99174'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('OCULAR INSTRUMNT SCREEN BILL'); ?>
												</font> </strong></td>
											<td width="11%"><?php echo $this->Form->input('BillingProfile.codes_home2', array('class' => '','type'=>'text', 'id' => 'cpt_codes1', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));?>
												<?php echo $this->Html->link($this->Html->image('icons/cross.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'addBeforeClaim', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;padding-right:10px;'),__('Are you sure?', true)); ?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('99174 Modifiers:'); ?>
											</td>
											<td width="11%"><?php 
											//echo $this->Form->input('BillingProfile.modifiers5', array('class' => '', 'id' => 'modifiers5','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:81px;','placeholder'=>''));
											?> <?php
											//echo $this->Form->input('BillingProfile.modifiers6', array('class' => '', 'id' => 'modifiers6','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:81px;','placeholder'=>''));
											?> <?php
											//echo $this->Form->input('BillingProfile.modifiers7', array('class' => '', 'id' => 'modifiers7','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:80px;','placeholder'=>''));
											?> <?php
											//echo $this->Form->input('BillingProfile.modifiers8', array('class' => '', 'id' => 'modifiers8','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:80px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Quantity/Minutes:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('BillingProfile.quantity2', array('class' => '','type'=>'text', 'id' => 'quantity2', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Diagnosis Pointers:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('BillingProfile.diagnosis_pointers2', array('class' => '','type'=>'text', 'id' => 'diagnosis_pointers2', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr> -->

									<!-- </table>
								</td>
							</tr>

							<tr>
								<td>
									<table border="0" cellpadding="0" cellspacing="0"
										class="formFull" width="100%" >
										<tr>
										<td width="1%"><div	id='errorDiv' style="display: none"></div> 
											</td>
											<td class="tdLabel " id="boxSpace" width="47%"><strong> <?php echo __('HCPCS Codes'); ?>
											</strong>
											</td>
											<td width="47%"><?php 
											echo $this->Form->input('BillingProfile.hcpcs_codes11', array('class' => 'hcpcs','type'=>'text', 'id' => 'hcpcs_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find HCPS Procedure codes'));
											?> <?php echo $this->Form->input('BillingProfile.check_for_name',array('type'=>'checkbox','id'=>'checkForName','name'=>'chk'))."Check to search by Name";?>
											</td>
											<td width="5%"><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('escape' => false,'onclick'=>'getHCPCSDetails()')); ?>
											</td>
											
										</tr>
										<tr class="row_gray">
											<td colspan="4">
												<table border="0" cellpadding="0" cellspacing="0"
													width="100%" id='hcpcsTable'>
													<tr>
														<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo __('Description'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Code'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Price'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Action'); ?>
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
					</td>-->
				</tr>
			</table>
		</td>
	</tr>
</table>
<div class="btns">
<?php

echo $this->Form->input('BillingProfile.apc_codes', array('type'=>'hidden', 'id' => 'apc_codes_dyna', 'label'=> false, 'div' => false, 'error' => false));
echo $this->Form->input('BillingProfile.ndc_codes', array('type'=>'hidden', 'id' => 'ndc_codes_dyna', 'label'=> false, 'div' => false, 'error' => false));
echo $this->Form->input('BillingProfile.hcpcs_codes', array('type'=>'hidden', 'id' => 'hcps_codes_dyna', 'label'=> false, 'div' => false, 'error' => false));
echo $this->Form->input('BillingProfile.icd_codes', array('type'=>'hidden', 'id' => 'icd_codes_dyna', 'label'=> false, 'div' => false, 'error' => false));
echo $this->Form->input('BillingProfile.cpt_codes', array('type'=>'hidden', 'id' => 'cpt_codes_dyna', 'label'=> false, 'div' => false, 'error' => false));

?>	
<?php
	echo "&nbsp;&nbsp;".$this->Form->submit('Save',array('id'=>'billingProfileSubmit','class'=>'blueBtn','div'=>false,'title'=>'Save'));
	?>
</div>
<div id="cptCodes1" style="display:none">
<select style="width:100px" name="data[BillingProfile][modifiers1][]" ><option value="">Select</option>
<?php  foreach ($getModifiers as $data){?>
<option value=<?php echo $data['BillingOtherCode']['code']?>><?php echo $data['BillingOtherCode']['name']?></option>
<?php }?>
</select></div>
<div id="cptCodes2" style="display:none">
<select style="width:100px" name="data[BillingProfile][modifiers2][]" ><option value="">Select</option>
<?php  foreach ($getModifiers as $data){?>
<option value=<?php echo $data['BillingOtherCode']['code']?>><?php echo $data['BillingOtherCode']['name']?></option>
<?php }?>
</select></div>
<div id="cptCodes3" style="display:none">
<select style="width:100px" name="data[BillingProfile][modifiers3][]" ><option value="">Select</option>
<?php  foreach ($getModifiers as $data){?>
<option value=<?php echo $data['BillingOtherCode']['code']?>><?php echo $data['BillingOtherCode']['name']?></option>
<?php }?>
</select></div>
<div id="cptCodes4" style="display:none">
<select style="width:100px" name="data[BillingProfile][modifiers4][]" ><option value="">Select</option>
<?php  foreach ($getModifiers as $data){?>
<option value=<?php echo $data['BillingOtherCode']['code']?>><?php echo $data['BillingOtherCode']['name']?></option>
<?php }?>
</select></div>
<?php echo $this->Form->end(); ?>
<script>
jQuery(document).ready(function(){
// binds form submission and fields to the validation engine
jQuery("#BillingProfileFrm").validationEngine();
});


$(document).ready(function(){
	$('#billing_profile_name').focus();
	
if('<?php echo $setFlash == '1'?>'){
	parent.location.reload();
	//parent.window.location.href = "<?php echo $this->Html->url(array("controller"=>"Insurances", "action" => "addNewEncounter","admin" => false)); ?>"
	parent.$.fancybox.close();
	
}
});
//***************************************For CPT*********************************************************************************************************************
$('#cptSerach').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});
var calling_url_ctp = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "searchCpt","admin" => false)); ?>" ;
function getCptCodeDetials(){
	var codeCtp=$('#cptSerach').val();	
	if(httpRequest) httpRequest.abort();
		var httpRequest = $.ajax({
			  beforeSend: function(){
				  $('#busy-indicator').show('fast');
			  },
		      url: calling_url_ctp+"/"+codeCtp,
		      context: document.body,
		      success: function(data){ 
		    	  $('#busy-indicator').hide('fast');
		    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
		    	  var checkValue=data.code;
		    	  if(checkValue!=null){
		    	 	 addRowWithCptSDetails(data,'');
		    	  }
		    	  else{
		    		  $('#errorDiv').show();
			    	  $('#errorDiv').html('Check code');
		    	  }
			  },
			  error:function(){
					alert('Please try again');
				  }
		});
}
 var cptcnt=1;
 var selectedCPTCodeIndexArr = new Array();
 var selectedCPTCodeArr = new Array(); 
function addRowWithCptSDetails(data,pickedId){
	 if(data != '' && data !== undefined){
		$("#cptTable").find('tbody')
	    .append($('<tr>').attr('class', '').attr('id', 'dataCpt'+cptcnt)
	    		 .append($('<td class="tdLabel" id="boxSpace" width=10px colspan=0 >').text(cptcnt))
	    		 .append($('<td class="tdLabel" id="boxSpace" >').text(data.name))
				        .append($('<td class="tdLabel" id="boxSpace">').text(data.code))
				         .append($('<td class="tdLabel" id="boxSpace" >').append($('#cptCodes1').html()))
	    				 .append($('<td class="tdLabel" id="boxSpace">').append($('#cptCodes2').html()))
						 .append($('<td class="tdLabel id="boxSpace"">').append($('#cptCodes3').html()))
						 .append($('<td class="tdLabel id="boxSpace"">').append($('#cptCodes4').html()))
				         .append($('<td style="padding-left:25px">').attr('class','removecpt').attr('id', 'removecpt_'+cptcnt).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>'))
				         .append($('<input>').attr({type:"hidden", name:"data[BillingProfile]["+cptcnt+"][cpt_codes]",value:data.code}))
				       ); 
	
		//addBlankRow();		
	}
	 selectedCPTCodeIndexArr.push(cptcnt);
	 selectedCPTCodeArr.push(data.code);
	 cptcnt++;	 
}
$(".removecpt").live( "click", function() {
    var currentId=$(this).attr('id');
    if(confirm("Do you really want to delete this record?")){
    var trRemove=currentId.split('_');
    $('#dataCpt'+trRemove[1]).remove();
    }else{
    	return false;
    }
    selectedCPTCodeArr.splice( $.inArray(trRemove[1], selectedCPTCodeArr), 1 );
    selectedCPTCodeIndexArr.splice( $.inArray(trRemove[1], selectedCPTCodeArr), 1 );
});

//*******************************************************************************************************************************************************************
//------------------------------FOR HCPCS-----------------------------------------------------------------------------------------------------------------------------
$('#hcpcs_codes').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","hcpcs",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});
var calling_url = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "hcpcsSearch","admin" => false)); ?>" ;
var timeoutReference;
$(function() {
	$('.hcpcs').live('keyup',function() { 
		var _this = $(this); // copy of this object for further usage
	    
	    if (timeoutReference) clearTimeout(timeoutReference);
	    timeoutReference = setTimeout(function() {
	    	//getHCPCSDetails()
	    }, 2000);
	});
	});

function getHCPCSDetails(){	
	var checkName=$('#checkForName:checked').length;
	alert(checkName);
	var codeHCPS=$('#hcpcs_codes').val();
	alert(codeHCPS);
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
		      success: function(data){ alert(data);
		    	  $('#busy-indicator').hide('fast');
		    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
		    	  var checkValue=data.code;alert(checkValue);
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
hcpcsCnt=0;
var selectedHCPCSCodeIndexArr = new Array();
var selectedHCPCSCodeArr = new Array(); 
function addRowWithHCPCSDetails(data,pickedId){
	 if(data != '' && data !== undefined){
	//	$('#hcpcsTable' tr:last').remove();
	$("#hcpcsTable").find('tbody')		
	    .append($('<tr>').attr('class', '').attr('id', 'data'+hcpcsCnt)
	    		 .append($('<td class="tdLabel" id="boxSpace">').text(data.name))
				        .append($('<td class="tdLabel" id="boxSpace">').text(data.code))
				        .append($('<td class="tdLabel" id="boxSpace">').text('$'+data.price)) 
				         .append($('<td style="padding-left:25px" >').attr('class','removeHcpcs').attr('id', 'removehcpcs_'+hcpcsCnt).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>'))
				         .append($('<input>').attr({type:"hidden", name:"data[BillingProfile]["+hcpcsCnt+"][hcpcs_codes]",value:data.code}))); 
		selectedHCPCSCodeIndexArr.push(hcpcsCnt);
		selectedHCPCSCodeArr.push(data.code);
		$('#data'+data.code).remove();
		//addBlankRow();	
	}
}
$(".removeHcpcs").live( "click", function() {
    var currentId=$(this).attr('id');
    if(confirm("Do you really want to delete this record?")){
    var trRemove=currentId.split('_');
    $('#data'+trRemove[1]).remove();
    }else{
    	return false;
    }
    selectedHCPCSCodeArr.splice( $.inArray(trRemove[1], selectedHCPCSCodeArr), 1 );
    selectedHCPCSCodeIndexArr.splice( $.inArray(trRemove[1], selectedHCPCSCodeArr), 1 );
});

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
//*******************************************************FOR APCS*****************************************************************************
$('.apcs1').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","apc",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});
		
$('.apcs2').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});
		$('#checkForApcs').change(function(){
			$('#apcs2').show();
			$('#apcs1').hide();
			$('#apc_codes').val('');
			});

 
var calling_url_apcs = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "apcsSearch","admin" => false)); ?>" ;
var timeoutReferenceApcs;
$(function() {
	$('.apcs1').live('keyup',function() { 
		var _this = $(this); // copy of this object for further usage
	    
	    if (timeoutReferenceApcs) clearTimeout(timeoutReferenceApcs);
	    timeoutReferenceApcs = setTimeout(function() {
	    	//getAPCSDetails1()
	    }, 2000);
	});
	});

function getAPCSDetails1(){
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
		    	 	 addRowWithACPCSDetails1(data);
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
var cnt=0;
var selectedAPCCodeIndexArr = new Array();
var selectedAPCCodeArr = new Array(); 
function addRowWithACPCSDetails1(data){
	 if(data != '' && data !== undefined){//alert(data);
		 if(data.code==null){
				$('#errorDiv').show();
				$('#errorDiv').html('No Records Found.');
				return false;
		 }
		$("#acpcsTable1").find('tbody')
			  	.append($('<tr>').attr('class', '').attr('id', 'data'+cnt)	  	
			  	.append(($('<td class="tdLabel" id="boxSpace">').append($('<input>').attr({type:"hidden", name:"data[BillingProfile]["+cnt+"][apc_codes]",value:data.code})).text(data.code)))
			  	.append($('<td class="tdLabel" id="boxSpace">').text(data.name))
				.append($('<td class="tdLabel" id="boxSpace">').text(data.price))
				.append($('<td style="padding-left:25px">').attr('class','removeAPC').attr('id', 'remove_'+cnt).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>')
		));
		selectedAPCCodeIndexArr.push(cnt);
		selectedAPCCodeArr.push(data.code);
	cnt++;
  }
}

$(".removeAPC").live( "click", function(){
    var currentId=$(this).attr('id');
    if(confirm("Do you really want to delete this record?")){
    var trRemove=currentId.split('_');
    $('#data'+trRemove[1]).remove();
    }else{
    	return false;
    }
    selectedAPCCodeArr.splice( $.inArray(trRemove[1], selectedAPCCodeArr), 1 );
    selectedAPCCodeIndexArr.splice( $.inArray(trRemove[1], selectedAPCCodeArr), 1 );
});

$("#billingProfileSubmit").click(function(){
	var selAPCCodes = selectedAPCCodeArr.toString();
	$("#apc_codes_dyna").val(selAPCCodes);
	var selNDCCodes = selectedNDCCodeArr.toString();
	$("#ndc_codes_dyna").val(selNDCCodes);
	var selHCPSCodes = selectedHCPCSCodeArr.toString();
	$("#hcps_codes_dyna").val(selHCPSCodes);
	var selCPTCodes = selectedCPTCodeArr.toString();
	$("#cpt_codes_dyna").val(selCPTCodes);
	var selicdCodes = selectedicdCodeArr.toString();
	$("#icd_codes_dyna").val(selicdCodes);
});

    
function addBlankRow11(){
	$("#acpcsTable1").find('tbody')
    .append($('<tr>')
    		 .append($('<td contenteditable>').attr('class', 'searchCDM2').attr('id', 'data').append('&nbsp;'))
			        .append($('<td>').text(''))
			        .append($('<td>').text(''))
			        .append($('<td>').text())
			       
    );
	
}
//******************************************************************************NDC code*********************************************************************************************
$('#ndc_codes').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NdcMaster","NDC",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});

//var checkName=$('#checkForApcs:checked').length;
function getNdcDetails1(){
var calling_url_apcs = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "ndcSearch","admin" => false)); ?>" ;
var ncdcodes=$('#ndc_codes').val();
if(httpRequest) httpRequest.abort();
	var httpRequest = $.ajax({
		  beforeSend: function(){
			  $('#busy-indicator').show('fast');
		  },
	      url: calling_url_apcs+"/"+ncdcodes,
	      context: document.body,
	      success: function(data){ 
	    	  $('#busy-indicator').hide('fast');
	    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
	    	 	 addRowWithNdcSDetails(data);
		  },
		  error:function(){
				alert('Please try again');
				//onCompleteRequest(); //remove loading sreen
			  }
	});
///}
} 
var ncdcode=0;
var selectedNDCCodeIndexArr = new Array();
var selectedNDCCodeArr = new Array();
function addRowWithNdcSDetails(data){
 if(data != '' && data !== undefined){//alert(data);
	 if(data.code==null){
			$('#ndcError').show();
			$('#ndcError').html('No Records Found.');
			return false;
	 }
	$("#NdcTable").find('tbody')
		  	.append($('<tr>').attr('class', '').attr('id', 'data'+ncdcode)	 
		  	.append(($('<td class="tdLabel" id="boxSpace">').text(data.code)))
		  	.append($('<td class="tdLabel" id="boxSpace">').text(data.medid))
		  	.append($('<td class="tdLabel" id="boxSpace">').text(data.name))			
			.append($('<td style="padding-left:25px">').attr('class','removeNDC').attr('id', 'remove_'+ncdcode).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>'))
			.append($('<input>').attr({type:"hidden", name:"data[BillingProfile]["+ncdcode+"][ndc_codes]",value:data.code}))); 
	selectedNDCCodeIndexArr.push(ncdcode);
	selectedNDCCodeArr.push(data.code);
ncdcode++;
}
}

$(".removeNDC").live( "click", function() {
var currentId=$(this).attr('id');
if(confirm("Do you really want to delete this record?")){
var trRemove=currentId.split('_');
$('#data'+trRemove[1]).remove();
}else{
	return false;
}
selectedNDCCodeArr.splice( $.inArray(trRemove[1], selectedNDCCodeArr), 1 );
selectedNDCCodeIndexArr.splice( $.inArray(trRemove[1], selectedNDCCodeArr), 1 );
});
	
//**********************************************************IDC9 search*************************************************************************************************************************

$('#icd_codes').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","SnomedMappingMaster","icd9code",'null',"no",'no',"icd9code !=".'',"icd9code","admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});

//var checkName=$('#checkForApcs:checked').length;
function getIcdDetails(){
var calling_url_icd = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "icdSearch","admin" => false)); ?>" ;
var icdcodes=$('#icd_codes').val();
if(httpRequest) httpRequest.abort();
	var httpRequest = $.ajax({
		  beforeSend: function(){
			  $('#busy-indicator').show('fast');
		  },
	      url: calling_url_icd+"/"+icdcodes,
	      context: document.body,
	      success: function(data){ 
	    	  $('#busy-indicator').hide('fast');
	    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
	    	 	 addRowWithICDDetails(data);
		  },
		  error:function(){
				alert('Please try again');
				//onCompleteRequest(); //remove loading sreen
			  }
	});
///}
} 
icdcode=0;
var selectedicdCodeIndexArr = new Array();
var selectedicdCodeArr = new Array();
function addRowWithICDDetails(data){

 if(data != '' && data !== undefined){
	 if(data.code==null){
			$('#icdError').show();
			$('#icdError').html('No Records Found.');
			return false;
	 }

		$("#icdTable").find('tbody')
	  	.append($('<tr>').attr('class', '').attr('id', 'data'+icdcode)	  	
	  	.append(($('<td class="tdLabel" id="boxSpace">').append($('<input>')
			  	.attr({type:"hidden", name:"data[BillingProfile]["+icdcode+"][icd_codes]",value:data.code})).text(icdcode+1)))
		.append($('<td class="tdLabel" id="boxSpace">').text(data.code))
	  	.append($('<td class="tdLabel" id="boxSpace">').text(data.name))		
		.append($('<td style="padding-left:25px">').attr('class','removeIcd')
				.attr('id', 'remove_'+icdcode).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>')
));
	selectedicdCodeIndexArr.push(icdcode);
	selectedicdCodeArr.push(data.code);
icdcode++;
}
}

$(".removeIcd").live( "click", function() {
var currentId=$(this).attr('id');
if(confirm("Do you really want to delete this record?")){
var trRemove=currentId.split('_');
$('#data'+trRemove[1]).remove();
}else{
	return false;
}
selectedicdCodeArr.splice( $.inArray(trRemove[1], selectedicdCodeArr), 1 );
selectedicdCodeIndexArr.splice( $.inArray(trRemove[1], selectedicdCodeArr), 1 );
});

</script>
