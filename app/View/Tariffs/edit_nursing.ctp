<?php //pr($this->request->data);exit;
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
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
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#countryfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3><?php echo __('Edit Tariff Standard'); ?></h3>
</div>
<?php echo $this->Form->create('',array('action'=>'editNursing','type' => 'file','id'=>'editNursing','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('Nursing.id', array('value'=>$this->request->data['Nursing']['id']));			
			?>
	<table class="table_format" border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	 
	<tr>
	<td align="right">
	<?php echo __('Service Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Nursing.service_name', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'servicename', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	
	<tr>
	<td align="right">
	<?php echo __('Service Category'); ?><font color="red">*</font>
	</td>
	<td>
        <?php echo $this->Form->input('Nursing.tariff_list_id', array('style'=>'width:160px','options'=>$data,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'selectTariff')); ?>
	</td>
	</tr>
	<!-- 
	 <tr>
	<td>
	<?php echo __('Select Standard'); ?><font color="red">*</font>
	</td>
	<td>
        <?php echo $this->Form->input('Nursing.tariff_standard_id', array('style'=>'width:160px','options'=>$tariffStandard,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'selectStandard')); ?>
	</td>
	</tr>
	 --> 
	<tr>
	<td colspan="2" align="center">
		<?php				    			 
					if(isset($this->params['named']['sendTo']) AND $this->params['named']['sendTo'] == 'nursings') {
							echo $this->Html->link(__('Cancel', true),array('controller'=>'tariffs','action' => 'viewNursing','sendTo'=>'nursings','patientId'=>$this->params['named']['patientId']), array('escape' => false,'class'=>'grayBtn'));
							
						} else {
                          echo $this->Html->link(__('Cancel'),
						 					array('action' => 'viewNursing'),array('escape' => false,'class'=>'grayBtn'));		
						}
						 
					echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));			
	    ?>	
		
	</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>