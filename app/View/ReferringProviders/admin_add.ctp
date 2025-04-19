

<div class="inner_title">
<h3><img src="images/appointment_icon.png" /> &nbsp; <?php echo __('Add Referring Provider', true); ?></h3>
<span><input name="" type="text" class="textBoxFade"  value="Search" onfocus="javascript:if(this.value=='Search'){this.value=''; this.className='textBox';}" onblur="javascript:if(this.value==''){this.value='Search'; this.className='textBoxFade'};"/> <a href="#"><img src="images/search_icon.png" style="vertical-align:middle;" /></a></span>
</div>


<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#ReferringProviderAdminAddForm").validationEngine();
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
<div class="ReferringProvider form">
<?php echo $this->Form->create('ReferringProvider');?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td colspan="2" align="center">
	<br>
	</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Ref. Provider Name'); ?><font color="red">*</font>
		</td>
		<td >
	<?php
		echo $this->Form->input('ref_provider_name', array('label' => false,'class' => 'validate[required,minSize[2]]', 'id' => 'name',  'div' => false, 'error' => false));
	
	?>
	</td>
	</tr>
	
	<tr>
		<td class="form_lables">
		<?php echo __('Active'); ?><font color="red">*</font>
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
                    "alertText": "Referring Provider name is requred.",
                    "alertTextCheckboxMultiple": "* Please select an option",
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

