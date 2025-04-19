
<?php 
echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>


<div class="inner_title">
	<h3>
		<?php echo __('Edit Diagnosis', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Back'), array('controller'=>'SmartPhrases','action'=>'diagnosis_list'), array('escape' => false,'class'=>'blueBtn back'));
	?>
	</span>

</div>

<div class="clr ht5"></div>


<?php //echo $this->Form->create('Diagnosis',array('id'=>'DiagnosisForm'));?>
<?php  echo $this->Form->create('',array('type' => 'file','id'=>'DiagnosisForm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));?>

<table width="60%" border="0"
	cellspacing="0" cellpadding="0" class="formFull" align="center">
     
    <tr><td height="15px"></td></tr>
    
	<tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">ICD9 Name</td>
		<td width="250"><?php echo $this->Form->input('SnomedMappingMaster.icd9name',
				array('type'=>'text','id'=>'name', 'class'=>"textBoxExpnd validate[required]",
							 'tabindex'=>3,'div'=>false,'label'=>false));?>
		</td>

		<td width="">&nbsp;</td>

		<td width="100" class="tdLabel" id="boxSpace">ICD9 Code</td>
		<td width="250">
			<?php echo $this->Form->input('SnomedMappingMaster.icd9code',
				array('type'=>'text','id'=>'name', 'class'=>"textBoxExpnd validate[required]",
							 'tabindex'=>3,'div'=>false,'label'=>false));?>
		</td>
	</tr>

	<tr>
		<td class="tdLabel" id="boxSpace">ICD10 Name </td>
		<td><?php echo $this->Form->input('SnomedMappingMaster.icdName',
				array('type'=>'text','id'=>'pack','class'=>"textBoxExpnd validate[required]",
							 'tabindex'=>3,'div'=>false,'label'=>false));?> </td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">ICD10 Code</td>
		<td><?php echo $this->Form->input('SnomedMappingMaster.mapTarget',
				array('type'=>'text','id'=>'minimum','class'=>"textBoxExpnd ",
							 'tabindex'=>3,'div'=>false,'label'=>false));?>
		</td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Sct Name </td>
		<td><?php echo $this->Form->input('SnomedMappingMaster.sctName',
				array('type'=>'text','class'=>"textBoxExpnd validate[required]",'id'=>'item_code','tabindex'=>7,'div'=>false,'label'=>false));?>
        </td>
        <td>&nbsp;</td>
        <td class="tdLabel" id="boxSpace">Sct Code </td>
		<td><?php echo $this->Form->input('SnomedMappingMaster.mapCategoryValueId',
				array('type'=>'text','class'=>"textBoxExpnd validate[required]",'id'=>'mapCategoryValueId','tabindex'=>7,'div'=>false,'label'=>false));?>
        </td>
        </tr>
        <tr>
        <td class="tdLabel" id="boxSpace">Is active </td>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><?php echo $this->Form->input('SnomedMappingMaster.active', array('type' => 'checkbox','class' => '','label' => false,'legend' => false/* ,'checked'=>'checked' */));
		?></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
		<td>&nbsp;</td>
		
	</tr>
	
</table>

<div style="text-align:center;padding-top: 10px">	<?php
                                		 
                                		echo $this->Form->submit(__('Save'), array('id'=>'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                		
                                //		echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('escape' => false,'class' => 'grayBtn'));
                                	?></div>
<?php echo $this->Form->end();?>

<script>

$(".submit").click(function(){
	var valid=jQuery("#ProductForm").validationEngine('validate');
	if(valid){
		return true;
	}else{
		return false;
	}
	});




$(document).ready(function(){
	

});


$('.cancel, .back').click(function(){
	window.location.href="<?php echo $this->Html->url(array("controller"=>'Store','action'=>'index'));?>"
});
		
(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"Required.",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Minimum ",
                    "alertText2": " characters allowed"
                },
             "email": {
                    // Simplified, was not working in the Iphone browser
                    "regex": /^([A-Za-z0-9_\-\.\'])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/,
                    "alertText": "* Invalid email address"
                },
				 "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Invalid phone number"
                },
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Numbers Only"
                }
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);


/*End OF Code*/

</script>
