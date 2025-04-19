<style>
.roomRelatesService{
	display: none;
}</style>
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

<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#tarifflist").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3>
		<?php echo __('Add Service'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Tariff',array('type' => 'file','id'=>'tarifflist','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table class="table_format" border="0" cellpadding="0"
	cellspacing="0" width="60%" align="center">

	<!-- <tr>
	<td align="right"><?php echo __('Code Type'); ?><font color="red">*</font></td>
	<td><?php $code_option = array(''=>'Please select','CPT'=>'CPT','Custom Code'=>'Custom Code','HCPCS'=>'HCPCS','ICD9'=>'ICD9','ICD10PCS'=>'ICD10PCS','NDC'=>'NDC');
	echo $this->Form->input('TariffList.code_type', array('class' => 'validate[required,custom[mandatory-select]] codeType','options' => $code_option, 'id' => 'code_type', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 215px'));?>
	</td>
	</tr>
	 
	<tr id='cpt' style="display: none;">
	<td align="right"><?php echo __('CPT Code'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.cbt', array('class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'cbt', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr>
	
	<tr id='custom_code' style="display: none;">
	<td align="right"><?php echo __('Custom Code'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.custom_code', array('class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'CustomCode', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr>
	
	<tr id='hcpcs' style="display: none;">
	<td align="right"><?php echo __('HCPCS Code'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.hcpcs', array('class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'hcpcs', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr>
	
	<tr id='icd9' style="display: none;">
	<td align="right"><?php echo __('ICD 9 Code'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.icd_9', array('class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'icd_9', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr>
	
	<tr id='icd10' style="display: none;">
	<td align="right"><?php echo __('ICD 10 Code'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.icd_10', array('class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'icd_10', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr>
	
	<tr id='ndc' style="display: none;">
	<td align="right"><?php echo __('NDC Code'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.ndc_code', array('class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'icd_10', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr> -->

	<tr>
		<td align="right"><?php echo __('Name'); ?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('TariffList.name', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'tariffname', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);'));?>
		</td>
	</tr>

	<tr>
		<td align="right"><?php echo __('Code Name'); ?></td>
		<td><?php echo $this->Form->input('TariffList.code_name', array(
			 'id' =>'codeName', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
			<i>(For configuration purpose only)</i>
		</td>
	</tr>

	<tr>
		<td align="right"><?php echo __('Visit Type',true); ?><font
			color="red"></font>
		</td>
		<td><?php
		echo $this->Form->input('TariffList.check_status',array('id'=>'check_status','type'=>'checkBox','class'=>''));
		?>
		</td>
	</tr>
	<!-- leena -->
	<tr>
		<td align="right"><?php echo __('Type',true); ?><font color="red">*</font>
		</td>
		<td><?php
		echo $this->Form->input('TariffList.service_type',array('id'=>'service_type','type'=>'select','options'=>Array('IPD'=>'IPD','OPD'=>'OPD','BOTH'=>'BOTH'),'class'=>'validate[required,custom[mandatory-select]]','default'=>'BOTH'));
		?>
		</td>
	</tr>
	<?php if($this->Session->read('website.instance')=='vadodara'){?>
	<tr>
		<td align="right"><?php echo __('Service Location',true); ?>
		</td>
		<td><?php
		
		echo $this->Form->input('TariffList.service_location',array('id'=>'service_location','type'=>'select','options'=>array('All'=>'All', $location)));
		?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<td align="right"><?php echo __('CPT'); ?></td>
		<td><?php echo $this->Form->input('TariffList.cbt', array('id' => 'cbt', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);','style'=>'width: 200px'));?>
		</td>
	</tr>

	<!-- <tr>
	<td align="right"><?php echo __('CDM'); ?></td>
	<td><?php echo $this->Form->input('TariffList.cdm', array('value'=>ucfirst($this->request->data['TariffList']['cdm']), 'id' => 'cdm', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);','style'=>'width: 200px'));?>
	</td>
	</tr>-->


	<tr>
		<td align="right"><?php echo __('CGHS Code'); ?></td>
		<td><?php echo $this->Form->input('TariffList.cghs_code', array('id' => 'cghs_code', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);','style'=>'width: 200px'));?>
		</td>
	</tr>
	<!-- field added by- Pooja -->
	<tr>
		<td align="right"><?php echo __('CGHS Service Alias Name'); ?></td>
		<td><?php echo $this->Form->input('TariffList.cghs_alias_name', array('id' => 'cghs_name', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);','style'=>'width: 200px'));?>
		</td>
	</tr>

	<!-- <tr  id='ndc_quality' style="display: none;">
	<td align="right"><?php echo __('NDC Quality'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.NdcQuality', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'NDC_QUALITY', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr>
	
	<tr id='ndc_units' style="display: none;">
	<td align="right"><?php echo __('NDC Units'); ?><font color="red">*</font></td>
	<td><?php echo $this->Form->input('TariffList.NdcUnit', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'NDC_UNITS', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));?>
	</td>
	</tr>  -->

	<!-- 
	<tr>
	<td align="right">
	<?php echo __('NABH Code'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('TariffList.cghs_nabh', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'cghs_nabh', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);','style'=>'width: 200px'));
        ?>
	</td>
	</tr>
	
	<tr>
	<td align="right">
	<?php echo __('Non NABH Code'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('TariffList.cghs_non_nabh', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'cghs_non_nabh', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);'));
        ?>
	</td>
	</tr>
	 -->
	<tr>
		<td align="right"><?php echo __('Apply in a Day'); ?><font color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.apply_in_a_day', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'apply_in_a_day', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<!-- 	<tr>
	<td align="right">
	<?php echo __('Accounts',true); ?>
	</td>
	<td>
        <?php 
		// Dont change this options. They are fixed and used and service groups
         
        echo $this->Form->input('TariffList.account_id', array('options' => $accountList, 'empty' => 'Select Account', 'id' => 'account_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 215px'));
        ?>
	</td>
	</tr> -->
	<tr>
		<td align="right"><?php echo __('Service Group',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		// Dont change this options. They are fixed and used and service groups
			
		echo $this->Form->input('TariffList.service_category_id', array('onchange'=>'getListOfSubGroup(this.value)','class' => 'validate[required,custom[mandatory-select]]', 'options' => $service_group_category, 'empty' => 'Select Service Group', 'id' => 'service_group_category', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 215px'));
		?></td>
	</tr>
	<?php if($this->Session->read('website.instance')=='vadodara'){
				$class= 'validate[required,custom[mandatory-select]]';
				$fontColor='<font color="red">*</font>';
	     	}else{
				$class='';
				$fontColor='';
	  		}
	?>
	<tr>
		<td align="right"><?php echo __('Service Sub Group',true); ?><?php echo $fontColor?>
		</td>
		<td valign="middle" style="text-align: left;"><?php
		echo $this->Form->input('TariffList.service_sub_category_id', array('options' => array(''), 'empty' => '','class' => $class, 'id' => 'service_sub_category_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 215px'));
		?>
		</td>

	</tr>


	<tr class='roomRelatesService'>
		<td align="right"><?php echo __('i-Assist'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.i_assist', array('type'=>'text','class' => 'validate[custom[onlyNumber]]', 'id' => 'iAssist', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<tr class='roomRelatesService'>
		<td align="right"><?php echo __('PSI'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.psi', array('type'=>'text','class' => 'validate[custom[onlyNumber]]', 'id' => 'psi', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Hospital costs for private patient'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.price_for_private', array('type'=>'text','class' => 'validate[custom[onlyNumber]]', 'id' => 'price_for_private', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Hospital costs for CGHS patients'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.price_for_cghs', array('type'=>'text','class' => 'validate[custom[onlyNumber]]', 'id' => 'price_for_cghs', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Hospital costs for company patients'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffList.price_for_other', array('type'=>'text','class' => 'validate[custom[onlyNumber]]', 'id' => 'price_for_other', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width: 200px'));
		?>
		</td>
	</tr>
	</tr>
	<tr>
		<td align="right"><?php echo __('Short Form'); ?>
		</td>
		<td><?php 
		echo $this->Form->textarea('TariffList.short_form', array('type'=>'text','class' => ' ',
        	'id' => 'short_form', 'label'=> false, 'div' => false, 'error' => false));
        ?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Enable For Nurse Billing Activity'); ?>
		</td>
		<td><?php echo $this->Form->input('TariffList.enable_for_billing_activity',array('id'=>'enableForNurse','type'=>'checkBox','class'=>''));?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Pre-Investigation'); ?>
		</td>
		<td><?php 
		echo $this->Form->textarea('TariffList.pre_investigation', array('type'=>'text','class' => ' ',
        	'id' => 'pre_investigation', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        <i>(For Package Only)</i>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Post-Investigation'); ?>
		</td>
		<td><?php 
		echo $this->Form->textarea('TariffList.post_investigation', array('type'=>'text','class' => ' ',
        	'id' => 'post_investigation', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        <i>(For Package Only)</i>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><?php				    			 
		echo $this->Html->link(__('Cancel'),
						 					array('action' => 'viewTariff'),array('escape' => false,'class'=>'grayBtn'));
					echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));
	    ?>

		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>

<script>

$('.codeType').change(function ()
{	//alert($('#code_type').val());
	if($('#code_type').val()=='NDC')
	{
		$("#ndc").show();
		$("#ndc_quality").show();
		$("#ndc_units").show();
	}else{
		$("#ndc").hide();
		$("#ndc_quality").hide();
		$("#ndc_units").hide();
	}

	if($('#code_type').val()=='CPT')
	{
		$("#cpt").show();
	}else{
		$("#cpt").hide();
	}

	if($('#code_type').val()=='Custom Code')
	{
		$("#custom_code").show();
	}else{
		$("#custom_code").hide();
	}

	if($('#code_type').val()=='HCPCS')
	{
		$("#hcpcs").show();
	}else{
		$("#hcpcs").hide();
	}

	if($('#code_type').val()=='ICD9')
	{
		$("#icd9").show();
	}else{
		$("#icd9").hide();
	}

	if($('#code_type').val()=='ICD10PCS')
	{
		$("#icd10").show();
	}else{
		$("#icd10").hide();
	}
});


	    
// TO avoide spaces in name
	function ltrim(str) { 
		for(var k = 0; k < str.length && isWhitespace(str.charAt(k)); k++);
			
		return str.substring(k, str.length);
	}
	// FOr right spaces
	function rtrim(str) {
		for(var j=str.length-1; j>=0 && isWhitespace(str.charAt(j)) ; j--) ;

		return str.substring(0,j+1);
	}
	// To check both spaces
	function isWhitespace(charToCheck) {
		var whitespaceChars = " \t\n\r\f";
		return (whitespaceChars.indexOf(charToCheck) != -1);
	}

	// To remove spaces
	function removeSpacesLeft(id){
		var str = document.getElementById('tariffname').value;
		
		//var trimmed = str.replace(/[\s\n\r]+/g, '') ;
		$('#tariffname').val(ltrim(str));	
		
	}

	function removeSpacesRight(id){
		var str = document.getElementById('tariffname').value;
		
		//var trimmed = str.replace(/[\s\n\r]+/g, '') ;
		$('#tariffname').val(rtrim(str));	
		
	}
	function getListOfSubGroup(obj){
		if($("#service_group_category option:selected").text() == 'Room Tariff'){
			$('.roomRelatesService').show('slow');
		}else{
			$('.roomRelatesService').hide('slow');
		}
 	 $.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getListOfSubGroup", "admin" => false)); ?>"+"/"+obj,
			  context: document.body,				  		  
			  success: function(data){//alert(data);
			  	data= $.parseJSON(data);
			  	$("#service_sub_category_id option").remove();
			  	$("#service_sub_category_id").append( "<option value=''>Please Select</option>" );
				$.each(data, function(val, text) {
				    $("#service_sub_category_id").append( "<option value='"+text.id+"'>"+text.value+"</option>" );
				});
		 			  			
			    		
			  }
		});
 
 }
</script>
