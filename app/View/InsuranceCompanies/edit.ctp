<style>
#busy-indicator {
    display: none;
    left: 50%;
    margin-top: 323px;
    position: absolute;
}
</style>
<div class="inner_title">
 <h3><?php echo __('Edit Insurance Companies', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#InsuranceCompanyEditForm").validationEngine();
	});
	
</script>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<?php echo $this->Form->create('InsuranceCompany');?>
<?php 
      echo $this->Form->input('InsuranceCompany.id', array('type' => 'hidden')); 
      echo $this->Form->input('InsuranceCompany.credit_type_id', array('type' => 'hidden', 'value' => 2));
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center" class="table_format">
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('Insurance Type'); ?><font color="red">*</font>
  </td>
  <td >
   <?php
    echo $this->Form->input('insurance_type_id', array('label' => false,'class' => 'validate[required,custom[mandatory-select]', 'id' => 'insurance_type_id',  'div' => false, 'error' => false, 'empty'=> 'Select Insurance Type', 'options' => $insurancetypes));
   ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('Insurance Company Name'); ?><font color="red">*</font>
  </td>
  <td >
   <?php
	echo $this->Form->input('name', array('label' => false,'class' => 'validate[required,minSize[2]]', 'id' => 'name',  'div' => false, 'error' => false));
   ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('Address'); ?><font color="red">*</font>
  </td>
  <td >
   <?php
    echo $this->Form->input('address', array('label' => false,'class' => 'validate[required,minSize[10]]', 'id' => 'address',  'div' => false, 'error' => false));
   ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('Country'); ?><font color="red">*</font>
  </td>
  <td >
   <?php
		echo $this->Form->input('country_id', array('class' => 'validate[required,custom[customcountry]]', 'options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));

		//echo $this->Form->input('country_id', array('label' => false,'class' => 'validate[required,custom[mandatory-select]', 'id' => 'country_id',  'div' => false, 'error' => false, 'empty'=> 'Select Country', 'options' => $countries));
   ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('State'); ?><font color="red">*</font>
  </td>
  <td id="changeStates">
   <?php 
    echo $this->Form->input('InsuranceCompany.state_id', array('label' => false,'class' => 'validate[required,custom[mandatory-select]', 'id' => 'state_id',  'div' => false, 'error' => false));
   ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('City'); ?><font color="red">*</font>
  </td>
  <td id="changeCities">
   <?php
    echo $this->Form->input('InsuranceCompany.city_id', array('label' => false,'class' => 'validate[required,custom[mandatory-select]', 'id' => 'city_id',  'div' => false, 'error' => false));
   ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('Zip'); ?><font color="red">*</font>
  </td>
  <td >
   <?php
     echo $this->Form->input('zip', array('label' => false,'class' => 'validate[required]', 'id' => 'zip',  'div' => false, 'error' => false));
   ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('Phone'); ?><font color="red">*</font>
  </td>
  <td >
   <?php
    echo $this->Form->input('phone', array('label' => false,'class' => 'validate[required,custom[phone]]', 'id' => 'phone',  'div' => false, 'error' => false));
   ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('Fax'); ?><font color="red">*</font>
  </td>
  <td >
   <?php
    echo $this->Form->input('fax', array('label' => false,'class' => 'validate[required]', 'id' => 'fax',  'div' => false, 'error' => false));
   ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('Email'); ?><font color="red">*</font>
  </td>
  <td >
   <?php
    echo $this->Form->input('email', array('label' => false,'class' => 'validate[required,custom[email]]', 'id' => 'email',  'div' => false, 'error' => false));
   ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables" align="right">
   <?php echo __('Active',true); ?>
  </td>
  <td>
   <?php 
    echo $this->Form->input('is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
   ?>
  </td>
 </tr>
 <tr>
  <td colspan="2" align="center">
  &nbsp;
  </td>
 </tr>
 <tr>
  <td class="form_lables"></td>
  <td>
   <?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn')); ?>
   <input type="submit" value="Submit" class="blueBtn">
  </td>
 </tr>
</table>
<?php echo $this->Form->end();?>