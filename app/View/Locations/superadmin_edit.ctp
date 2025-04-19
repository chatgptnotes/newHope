<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#locationfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('Edit Facility', true); ?></h3>
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
<?php } ?>
<form name="locationfrm" id="locationfrm" action="<?php echo $this->Html->url(array("controller" => "locations", "action" => "add", "superadmin" => true)); ?>" method="post" onSubmit="return Validate(this);" >
        <?php echo $this->Form->input('Location.id', array('type' => 'hidden')); ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	
    
	<tr>
	<td class="form_lables">
	<?php echo __('Facility Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.name', array('class' => 'validate[required,custom[customname]]', 'id' => 'customname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
        <?php echo __('Address1',true); ?>
	<font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Location.address1', array('class' => 'validate[required,custom[customaddress1]]', 'cols' => '35', 'rows' => '10', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Address2',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('Location.address2', array('cols' => '35', 'rows' => '10', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Zipcode',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.zipcode', array('class' => 'validate[required,custom[customzipcode]]', 'id' => 'customzipcode', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Country',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Location.country_id', array('class' => 'validate[required,custom[customcountry]]', 'options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('State',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Location.state_id', array('class' => 'validate[required,custom[customstate]]', 'options' => $states, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('City',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Location.city_id', array('class' => 'validate[required,custom[customcity]]', 'options' => $cities,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false,
));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Email',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.email', array('class' => 'validate[required,custom[customemail]]', 'id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Phone1',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.phone1', array('class' => 'validate[required,custom[customphone1]]', 'id' => 'customphone1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Phone2',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.phone2', array('id' => 'customphone2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Mobile',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.mobile', array('class' => 'validate[required,custom[custommobile]]', 'id' => 'custommobile', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Fax',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.fax', array('class' => 'validate[required,custom[customfax]]', 'id' => 'customfax', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Contact Person',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Location.contactperson', array('class' => 'validate[required,custom[customcontactperson]]', 'id' => 'customcontactperson', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Active',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Location.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td colspan="2" align="center">
        &nbsp;
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center">
        <?php 
   	echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));
        ?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>