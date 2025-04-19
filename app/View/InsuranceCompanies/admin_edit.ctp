
<div class="inner_title">
<h3><img src="images/appointment_icon.png" /> &nbsp; <?php echo __('Edit Insurance Companies', true); ?></h3>
<span><input name="" type="text" class="textBoxFade"  value="Search" onfocus="javascript:if(this.value=='Search'){this.value=''; this.className='textBox';}" onblur="javascript:if(this.value==''){this.value='Search'; this.className='textBoxFade'};"/> <a href="#"><img src="images/search_icon.png" style="vertical-align:middle;" /></a></span>
</div>


<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#InsuranceCompanyAdminAddForm").validationEngine();
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
  <?php
 $this->Session->flash();
   ?>
   
<div class="insuranceCompanies form">
<?php echo $this->Form->create('InsuranceCompany');?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
		<td colspan="2" align="center">
		<br>
		</td>
	</tr>
	
	<tr>
		<td class="form_lables">
		<?php echo __('Insurance Company Name'); ?><font color="red">*</font>
		</td>
		<td >
	<?php
		echo $this->Form->input('name', array('label' => false,'class' => 'validate[required,minSize[2]]', 'id' => 'name',  'div' => false, 'error' => false));
	
	?>
	</td>
	</tr>
		
	<tr>
		<td class="form_lables">
		<?php echo __('Address'); ?><font color="red">*</font>
		</td>
		<td >
	<?php
		echo $this->Form->input('address', array('label' => false,'class' => 'validate[required,minSize[10]]', 'id' => 'address',  'div' => false, 'error' => false));
	
	?>
	</td>
	</tr>
	
		<tr>
		<td class="form_lables">
		<?php echo __('City'); ?><font color="red">*</font>
		</td>
		<td >
	<?php
		echo $this->Form->input('city_id', array('label' => false,'class' => 'validate[required]', 'id' => 'city_id',  'div' => false, 'error' => false));
	
	?>
	</td>
	</tr>
	
	
		<tr>
		<td class="form_lables">
		<?php echo __('State'); ?><font color="red">*</font>
		</td>
		<td >
	<?php
		echo $this->Form->input('state_id', array('label' => false,'class' => 'validate[required]', 'id' => 'state_id',  'div' => false, 'error' => false));
	
	?>
	</td>
	</tr>
	
	
	
		<tr>
		<td class="form_lables">
		<?php echo __('Zip'); ?><font color="red">*</font>
		</td>
		<td >
	<?php
		echo $this->Form->input('zip', array('label' => false,'class' => 'validate[required]', 'id' => 'zip',  'div' => false, 'error' => false));
	
	?>
	</td>
	</tr>
	
	
	
		<tr>
		<td class="form_lables">
		<?php echo __('Phone'); ?><font color="red">*</font>
		</td>
		<td >
	<?php
		echo $this->Form->input('phone', array('label' => false,'class' => 'validate[required,custom[phone]]', 'id' => 'phone',  'div' => false, 'error' => false));
	
	?>
	</td>
	</tr>
		
		<tr>
		<td class="form_lables">
		<?php echo __('Fax'); ?><font color="red">*</font>
		</td>
		<td >
	<?php
		echo $this->Form->input('fax', array('label' => false,'class' => 'validate[required]', 'id' => 'fax',  'div' => false, 'error' => false));
	
	?>
	</td>
	</tr>
	
		<tr>
		<td class="form_lables">
		<?php echo __('Email'); ?><font color="red">*</font>
		</td>
		<td >
	<?php
		echo $this->Form->input('email', array('label' => false,'class' => 'validate[required,custom[email]]', 'id' => 'email',  'div' => false, 'error' => false));
	
	?>
	</td>
	</tr>
			<tr>
		<td class="form_lables">
		<?php echo __('Active?'); ?>
		</td>
		<td >
	<?php
		echo $this->Form->input('is_active', array('label' => false, 'id' => 'is_active',  'div' => false, 'error' => false));
	
	?>
	</td>
	</tr>
	</tr>
	<tr>
	<td colspan="2" align="center">
	<br>
	</td>
	</tr>
	<tr>
	<td class="form_lables"></td>
	<td>
	<?php echo $this->Html->link($this->Form->button(__('Cancel', true), array('type' => 'button','class' => 'grayBtn')), array('action' => 'index'), array('escape' => false));
	?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
</table>
<?php echo $this->Form->end();?>

</div>

<script>

(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"required.",
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
            };
            
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);</script>
