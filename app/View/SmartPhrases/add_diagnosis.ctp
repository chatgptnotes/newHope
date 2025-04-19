
<?php 
echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>


<div class="inner_title">
	<h3>
		<?php echo __('Add Diagnosis', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Back'), array('controller'=>'SmartPhrases','action'=>'diagnosis_list'), array('escape' => false,'class'=>'blueBtn back'));

	?>
	</span>

</div>

<div class="clr ht5" style="height: 25px"></div>


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
		<td width="100" valign="middle" class="tdLabel" id="boxSpace"><font color="red">*</font>ICD9 Name</td>
		<td width="250"><?php echo $this->Form->input('SnomedMappingMaster.icd9name',
				array('type'=>'text','id'=>'name', 'class'=>"textBoxExpnd validate[required,custom[mandatory-enter]]",
							 'tabindex'=>1,'div'=>false,'label'=>false));?>
		</td>

		<td width="">&nbsp;</td>

		<td width="100" valign="middle" class="tdLabel" id="boxSpace">ICD9 Code</td>
		<td width="250"><?php echo $this->Form->input('SnomedMappingMaster.icd9code',
				array('type'=>'text','id'=>'icd9code',  'class'=>"textBoxExpnd ",
							 'tabindex'=>2,'div'=>false,'label'=>false));?>
		</td>
	</tr>

	<tr>
		<td class="tdLabel" id="boxSpace">ICD10 Name </td>
		<td><?php echo $this->Form->input('SnomedMappingMaster.icdName',
				array('type'=>'text','id'=>'icdName','class'=>"textBoxExpnd validate[required]",
							 'tabindex'=>3,'div'=>false,'label'=>false));?> </td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">ICD10 Code</td>
		<td><?php echo $this->Form->input('SnomedMappingMaster.mapTarget',
				array('type'=>'text','id'=>'mapTarget','class'=>"textBoxExpnd ",
							 'tabindex'=>4,'div'=>false,'label'=>false));?>
		</td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Sct Name </td>
		<td><?php echo $this->Form->input('SnomedMappingMaster.sctName',
				array('type'=>'text','class'=>"textBoxExpnd validate[required]",'id'=>'sctName','tabindex'=>5,'div'=>false,'label'=>false));?>
        </td>
        <td>&nbsp;</td>
        <td class="tdLabel" id="boxSpace">Sct Code </td>
		<td><?php echo $this->Form->input('SnomedMappingMaster.mapCategoryValueId',
				array('type'=>'text','class'=>"textBoxExpnd validate[required]",'id'=>'mapCategoryValueId','tabindex'=>6,'div'=>false,'label'=>false));?>
        </td>
        </tr>
        <tr>
        <td class="tdLabel" id="boxSpace">Is active </td>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><?php echo $this->Form->input('SnomedMappingMaster.active', array('type' => 'checkbox','class' => '','label' => false,'legend' => false ,'checked'=>'checked' ));
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






$(document).ready(function(){
	$("#save").click(function(){
		var valid=jQuery("#DiagnosisForm").validationEngine('validate');
		if(valid){
			return true;
		}else{
			return false;
		}
		});

});




/*End OF Code*/

</script>
