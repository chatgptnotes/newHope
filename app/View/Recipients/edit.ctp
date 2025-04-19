<?php  	
echo $this->Html->css(array('internal_style','jquery.autocomplete'));
echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete','validationEngine.jquery','jquery.validationEngine',
		'/js/languages/jquery.validationEngine-en','jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js',
		'jquery.fancybox-1.3.4'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));  
echo $this->Html->css(array('validationEngine.jquery.css'));
	 //echo $this->Html->script(array( ));
			?>

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
 

	

<div class="inner_title">
<h3>&nbsp; <?php echo __('Edit Recipient', true); ?></h3>

</div>
<form name="instrumentfrm" id="faxrecipientedit" action="<?php echo $this->Html->url(array("controller" => "recipients", "action" => "edit")); ?>" method="post" >
        <?php echo $this->Form->input('Recipient.id', array( 'id' => 'instrumentid', 'label'=> false, 'div' => false, 'error' => false)); ?>
	<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="85%"  align="center">
	<tr>
	<td width="27%" style="float:left;">
	<?php echo __('Name'); ?><font color="red">*</font>
	</td>
	<td width="27%" >
        <?php 
           echo $this->Form->input('Recipient.name', array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd', 'id' => 'instrumentname', 'style'=>"width:303px", 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	<tr>
	<td width="10%" >
	<?php echo __('Last Name'); ?><font color="red">*</font>
	</td>
	<td width="27%" >
        <?php 
        echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd', 'id' => 'recipient_lastname', 'style'=>"width:303px", 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	
	<tr>
	<td width="19%" >
	<?php echo __('Fax Number'); ?>
	</td>
	<td width="27%" >
        <?php 
        echo $this->Form->input('Recipient.fax', array( 'id' => 'recipient_fax', 'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd', 'style'=>"width:303px",'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td width="23%" >
	<?php echo __('Phone Number'); ?>
	</td>
	<td width="27%" >
        <?php 
        echo $this->Form->input('Recipient.phone', array( 'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd','id' => 'recipient_phone', 'style'=>"width:304px", 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td width="19%" >
	<?php echo __('Email'); ?>
	</td>
	<td >
        <?php 
        echo $this->Form->input('Recipient.email', array( 'id' => 'recipient_email', 'label'=> false,'class' =>'textBoxExpnd validate[required,custom[email]] textBoxExpnd', 'style'=>"width:304px", 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	
	<tr>
	<td width="19%" ><?php echo __("Specialty");?></td>
			<td width="24%"  class="dropdown"><?php echo $this->Form->input('Recipient.department_id', array('empty'=>__('Please Select'),'options'=>$departments,'class' => 'textBoxExpnd',
 'id' => 'department_id','label'=>false,'div'=>false)); ?>
			</td>
	
	</tr>
	<tr>
	<td width="19%" colspan="2" align="right" class="">
		<?php				    			 
					echo $this->Html->link(__('Cancel'),
						 					array('action' => ''),array('id'=>"cancel",'escape' => false,'class'=>'grayBtn'));							 
					echo "&nbsp;&nbsp;".$this->Form->submit('Save',array('class'=>'blueBtn','id'=>"submit",'div'=>false));			
	    ?>	
		
	</td>
	</tr>
	</table>
</form>
<script>
$(document).ready(function(){
	jQuery("#faxrecipientedit").validationEngine({
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
		$("#submit")
		.click(
		function() { 
		//alert("hello");
		var validatePerson = jQuery("#faxrecipientedit").validationEngine('validate');
		//alert(validatePerson);
		if (validatePerson) {$(this).css('display', 'none');}
		//return false;
		});
	});

	$(document).ready(function(){
		//$("#faxrecipient").validationEngine();
		$('#submit').submit(function() {
			
			parent.document.location.href = '<?php echo $this->Html->url("/recipients/index"); ?>';
			parent.$.fancybox.close();
		});
		$('#cancel').click(function() {
			parent.$.fancybox.close();
		});
	});
	
</script>