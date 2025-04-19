<div class="inner_title">
<h3><img src="images/appointment_icon.png" /> &nbsp; <?php echo __('Edit Ethnicity', true); ?></h3>
<span><input name="" type="text" class="textBoxFade"  value="Search" onfocus="javascript:if(this.value=='Search'){this.value=''; this.className='textBox';}" onblur="javascript:if(this.value==''){this.value='Search'; this.className='textBoxFade'};"/> <a href="#"><img src="images/search_icon.png" style="vertical-align:middle;" /></a></span>
</div>
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
<div>
  <?php
$this->Session->flash();
   ?>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#EthnicitySuperadminEditForm").validationEngine();
	});
	
</script>
<div class="Ethnicity form">
<?php echo $this->Form->create('Ethnicity');?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td colspan="2" align="center">
	<br>
	</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Ethnicity Name'); ?><font color="red">*</font>
		</td>
		<td >
	<?php
		echo $this->Form->input('name', array('label' => false,'class' => 'validate[required,minSize[2]]', 'id' => 'name',  'div' => false, 'error' => false));
	
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
                    "alertText": "* Ethnicity name is requred.",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Minimum ",
                    "alertText2": " characters allowed"
                }
           
            };
            
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);</script>