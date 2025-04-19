<?php 
echo $this->Form->create('',array('controller'=>'tarrifs','action'=>'tariffAmount','type' => 'file','id'=>'tariffamount','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )));
?>
<div class="inner_title">
	<h3><?php echo __('Assign Tariff'); ?></h3>
</div>
<table width="100%" cellspacing="1" cellpadding="0" border="0" >
<tr>
<td width="100">Select Standard</td>
<td width="100"><?php echo $this->Form->input('TariffStandard.standardName', array('style'=>'width:160px','options'=>$data,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'tariffstandard')); ?></td>
<td >			<input class="blueBtn" type="submit" value="Select" id="save"></td>
</tr>
</table>
<div class="btns">
				
	
				
</div>			 
<?php echo $this->Form->end(); ?>				
				
     