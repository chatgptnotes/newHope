
<div class="inner_title">
<h3><?php echo __('Edit Accounting', true); ?></h3>
</div>
<?php 
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
<?php }   echo $this->Form->create('Location',array("action" => "edit", "admin" => true,'type' => 'file','id'=>'locationfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); ?>
        <?php echo $this->Form->input('Location.id', array('type' => 'hidden')); ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center">
	
   
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Class',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.name', array('class' => 'validate[required,custom[customname]]', 'id' => 'customname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
        <?php echo __('Status',true); ?>
	<font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Location.address1', array('class' => 'validate[required,custom[customaddress1]]', 'cols' => '35', 'rows' => '10', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Effective',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('Location.address2', array('cols' => '35', 'rows' => '10', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Asset',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.zipcode', array('class' => 'validate[required,custom[customzipcode]]', 'id' => 'customzipcode', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Chargeable',true); ?><font color="red">*</font>
	</td>
	<td>
       <?php 
          	echo $this->Form->input('Location.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Non Chargeable',true); ?><font color="red">*</font>
	</td>
	<td id="changeStates">
        <?php 
          	echo $this->Form->input('Location.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Is Active',true); ?><font color="red">*</font>
	</td>
	<td id="changeCities">
         <?php 
          	echo $this->Form->input('Location.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        
	<!--  Billing Footer Changes Ends -->
	
	 
   
	<tr>
	<td colspan="2" align="center">
        <?php 
    	 
        
   	echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));
        ?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#locationfrm").validationEngine();

		//checkout timign options 
		$('.checkoutOptions').click(function(){  
			if($(this).attr('checked')==true){
					if($(this).attr('id')=='LocationCheckoutTimeOption1'){
						$('#checkout_time').attr('disabled','');
						$("#checkout_time").addClass('validate[required,custom[mandatory-select]]');
					}else{
						$("#checkout_time").removeClass('validate[required,custom[mandatory-select]]');
						$('#checkout_time').attr('disabled','disabled');
					}
						
			}
			
		});
	});
	
</script>