<?php  	
	echo $this->Html->css(array('internal_style','jquery.autocomplete'));
	echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete'));
	echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));  
	echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
?>
<?php echo $this->Html->script(array('validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en'));?>
<?php echo $this->Html->css(array('validationEngine.jquery.css'));
?>


<?php 
  if(!empty($errors)) {
?>
<style>.dropdown input{width:59%;}</style>
<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
 <tr>
  <td colspan="2" align="left" class="error">
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
 

<div class="inner_title">
<h3>&nbsp; <?php echo __('Add Recipient', true); ?></h3>

</div>
<form name="faxrecipientfrm" id="faxrecipientfrm" action="<?php echo $this->Html->url(array("controller" => "recipients", "action" => "add",)); ?>" method="post" >
	<table class="table_format" border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td>
	<?php echo __('Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php echo $this->Form->hidden('Recipient.patient_id', array( 'id' => 'patient_id', 'value'=>$patient_id,'label'=> false, 'div' => false, 'error' => false));
        echo $this->Form->input('Recipient.name', array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd', 'id' => 'recipient_name', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	
	<tr>
	<td>
	<?php echo __('Last Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	
	<tr>
	<td>
	<?php echo __('Fax Number'); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Recipient.fax', array( 'id' => 'recipient_fax', 'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd','label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td>
	<?php echo __('Phone Number'); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Recipient.phone', array( 'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd','id' => 'recipient_phone', 'label'=> false, 'div' => false, 'error' => false,'maxlength'=>10));
        ?>
	</td>
	</tr>
	<tr>
	<td>
	<?php echo __('Email'); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Recipient.email', array( 'id' => 'recipient_email', 'label'=> false,'class' =>'textBoxExpnd validate[required,custom[email]]', 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	
	<tr>
	<td ><?php echo __("Specialty");?></td>
			<td class="dropdown"><?php //debug($departments);exit;
			echo $this->Form->input('Recipient.department_id', array('empty'=>__('Please Select'),'options'=>$departments,'class' => 'textBoxExpnd','id' => 'department_id','label'=>false)); ?>
			</td>
	
	</tr>
	<tr>
	<td colspan="2" align="left" class="">
		<?php				    			 
					echo $this->Html->link(__('Cancel'),array('action' => ''),array('id'=>"cancel",'escape' => false,'class'=>'grayBtn'));							 
					echo "&nbsp;&nbsp;".$this->Form->submit('Save',array('class'=>'blueBtn','id'=>"submit",'div'=>false));			
	    ?>	
		
	</td>
	</tr>
	</table>
</form>
<script>
$(document).ready(function(){
jQuery("#faxrecipientfrm").validationEngine({
	validateNonVisibleFields: true,
	updatePromptsPosition:true,
	});
	$("#submit")
	.click(
	function() { 
	//alert("hello");
	var validatePerson = jQuery("#faxrecipientfrm").validationEngine('validate');
	//alert(validatePerson);
	if (validatePerson) {$(this).css('display', 'none');}
	//return false;
	});
});
	
		

	$(document).ready(function(){
		//$("#faxrecipient").validationEngine();
		$('#submit').submit(function() {
			//alert($var);
			parent.document.location.href = '<?php echo $this->Html->url("/recipients/index"); ?>';
			
			parent.$.fancybox.close();
			});
$('#cancel').click(function() {
			
			parent.$.fancybox.close();
		});
	});

	
	
</script>