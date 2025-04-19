
<?php  	
		/*			echo $this->Html->css(array('internal_style'));
					echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete','jquery.blockUI','ui.datetimepicker.3.js','validationEngine.jquery',
		'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.5.custom.min.js','jquery.selection.js'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css','validationEngine.jquery.css'));  
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));*/
			?>
			<?php echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
		'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min',
		'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0',
		'jquery-ui-1.8.5.custom.min.js','ui.datetimepicker.3.js'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
if($status == "success"){
	?>
<script> 
		//alert("CCDA generated successfully"); 
		jQuery(document).ready(function() { 
			//parent.location.reload(true);
				parent.$.fancybox.close(); 
 
		});
		</script>
<?php   } ?>

<style>
.checkbox{float: left; width:100%}
.checkbox label{float: none;}
.dat img{float:inherit;}</style>


<?php echo $this->Form->create('AlcohalCessationAssesment',array('id'=>'AlcohalCessationAssesment'));//debug($patient_all); ?>
 
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Smoking Cessation Assessment Form1 ', true); ?></h3>
	<span>
		<?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn','div'=>false, 'id' => 'submit_alcohal_cassation_assesment')); ?>
	</span>
</div> 

<table width="100%" align="center" class="table_format">
<tr><td valign="top" style="border-right: solid 1px;" width="50%"><br/>
<?php echo $this->Form->input('patient_id',array('type'=>'hidden','value'=>$pid));
echo $this->Form->hidden('id');
?>
<table width="100%">
<tr>
<td class="dat" style="font-size: 13px;"><?php echo __(" 1. What is your quit date? ");?><font color="red">*</font><?php  echo $this->Form->input('quit_date',array('type'=>'text','id' =>'date_quit','autocomplete'=>"off",'legend'=>false,'div'=>false,'label'=>false,'value'=>$firstdose_datetime,'class' => 'validate[required,custom[mandatory-select]]'));?> </td>
</tr>
<tr>
<td style="font-size: 13px;"><br /><?php echo __("2. How many cigarettes do you usually smoke in a day? ");?><font color="red">*</font><?php echo $this->Form->input('cigarette',array('type'=>'text', 'label'=>false,'div'=>false,'class' => 'validate[required,custom[onlyNumber]]'));?></td>
</tr>
<tr>
<td style="font-size: 13px;"><br /><?php echo __("3. How many years have you smoked? ");?><font color="red">*</font><?php echo $this->Form->input('start_smoking',array('type'=>'text', 'label'=>false,'div'=>false,'class' => 'validate[required,custom[onlyNumber]]'));?></td>
</tr>
<tr>
<td style="font-size: 13px;"><br /><?php echo __("4. If you have tried to quit before, think back to your last attempt. Why did you start smoking again? (check all that apply)");?></td>
</tr>
<tr>
<td style="font-size: 13px;"><?php 
$optioncheck= explode('|',$this->data['AlcohalCessationAssesment']['smoke_again']);
//debug($optioncheck);
		echo $this->Form->input('smoke_again', array('type' => 'select',
                                              'multiple' => 'checkbox','label' => false,
                                              'options' => array(
													'I couldnt deal with the cravings' => "I couldn"."'"."t deal with the cravings.",
                                                    'Stress was too much to handle' => 'Stress was too much to handle.',
                                                    'I was drinking' => 'I was drinking.',
													'I really missed my cigarettes' => 'I really missed my cigarettes.',
                                              		'I was with other smokers and couldnt resist' => "I was with other smokers and couldn"."'"."t resist.",
                                              		'I was gaining weight' => 'I was gaining weight.',
                                              		'I couldnt break the habit of smoking in certain situations' => "I couldn"."'"."t break the habit of smoking in certain situations.",
                                              		'I had trouble using nicotine replacement products' => 'I had trouble using nicotine replacement products.',
                                              		'I have never tried to quit before' => 'I have never tried to quit before.'),'selected'=>$optioncheck)); ?>
</td>
</tr>

<tr>
<td style="font-size: 13px;"><br /><?php echo __("5. Have you tried nicotine replacement products in the past? If yes, which one(s)?"); 
echo $this->Form->input('nicotine_replacement', array('type'=>'radio','id'=>'nicotine',
		'options'=>array('no'=>'No',
		'yes'=>'Yes'), 'label'=>false, 'legend'=>false,'div'=>false));

echo $this->Form->input('nicotine_txt',array('type'=>'text', 'label'=>false,'div'=>false, 'id'=>'nic_txt','style'=>'display:none'));?></td>
</tr>
<tr>
<td style="font-size: 13px;"><br /><?php echo __("6. Do you plan to use a nicotine replacement product or other medication?");?></td>
</tr>
<tr>
<td style="font-size: 13px;"><?php $optioncheck= explode('|',$this->data['AlcohalCessationAssesment']['plan_nicotine_replacement']);
		echo $this->Form->input('plan_nicotine_replacement', array('type' => 'select',
                                              'multiple' => 'checkbox','label' => false,
                                              'options' => array(
													'Yes a patch' => 'Yes, a patch',
                                                    'Yes nasal spray' => 'Yes, nasal spray',
                                                    'Yes oral inhaler' => 'Yes, oral inhaler',
													'Yes zyban' => 'Yes, zyban',
                                              		'no' => 'No',
                                              		'Havent decided' => "Haven"."'"."t decided"),'selected'=>$optioncheck)); ?>
</td>
</tr>
</table>
</td>

<td valign="top" width="50%" valign="top"><br/>
<table width="100%">
<tr>
<td style="font-size: 13px;"><br /><?php echo __("7. Why do you want to quit now? (check all that apply)");?></td>
</tr>
<tr>
<td style="font-size: 13px;"><?php $optioncheck= explode('|',$this->data['AlcohalCessationAssesment']['quit_now']);
		echo $this->Form->input('quit_now', array('type' => 'select',
                                              'multiple' => 'checkbox','id'=>'check','label' => false,
                                              'options' => array(
													'health' => 'Health',
                                                    'family pressure' => 'Family pressure',
                                                    'I was drink' => 'I was drinking',
													'cost' => 'Cost',
                                              		'social pressure' => 'Social pressure',
                                              		'other' => 'Other'),'selected'=>$optioncheck));

echo $this->Form->input('quit_now_other',array('type'=>'text', 'id'=>'check_txt','style'=>'display:none','label'=>false,'div'=>false));
 ?>
</td>
</tr>

<tr>
<td style="font-size: 13px;"><br /><?php echo __("8. What are your main concerns about quitting?");?></td>
</tr>
<tr>
<td style="font-size: 13px;"><?php $optioncheck= explode('|',$this->data['AlcohalCessationAssesment']['main_concern_quitting']);
		echo $this->Form->input('main_concern_quitting', array('type' => 'select',
                                              'multiple' => 'checkbox','label' => false,
                                              'options' => array(
													'dealing with stress' => 'Dealing with stress',
                                                    'Weight gain' => 'Weight gain',
                                                    'fear of failure' => 'Fear of failure',
													'withdrawal' => 'Withdrawal',
                                              		'habit' => 'Habit'),'selected'=>$optioncheck)); ?>
</td>
</tr>

<tr>
<td style="font-size: 13px;"><br /><?php echo __("9. Which of the following situations would be most likely to tempt you to smoke?");?></td>
</tr>
<tr>
<td style="font-size: 13px;"><?php $optioncheck= explode('|',$this->data['AlcohalCessationAssesment']['situation_smoke']);
		echo $this->Form->input('situation_smoke', array('type' => 'select',
                                              'multiple' => 'checkbox','label' => false, 'id'=>'check_tempt',
                                              'options' => array(
													'drinking/socializing' => 'drinking/socializing',
                                                    'seeing people smoking around me' => 'seeing people smoking around me',
                                                    'utomatically lighting up a cigarette' => 'automatically lighting up a cigarette',
													'other' => 'Other'),'selected'=>$optioncheck));
echo $this->Form->input('situation_smoke_other',array('type'=>'text', 'id'=>'check_tempt_txt','style'=>'display:none','label'=>false,'div'=>false)); ?>
</td>
</tr>

</table>

</td></tr>

<tr><td align="center" colspan="2"><br /><br />
<?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn','div'=>false, 'id' => 'submit_alcohal_cassation_assesment')); ?>
</td>
</tr>
</table>
<?php echo $this->Form->end(); ?>



<script>
$(document).ready(function(){




$("#date_quit1")
.datepicker(
		{
		showOn : "button",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,

		changeYear : true,

		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
		onSelect : function() {
		$(this).focus();
		//foramtEnddate(); //is not defined hence commented
		}

	});
$("#date_quit")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}

		});

});
//bof check function

 if($('#checkOther').attr('checked')) {
	$("#check_txt").show();
	} 
	else {
	$("#check_txt").hide();
	}
	
 if($('#check_temptOther').attr('checked')) {
	 $("#check_tempt_txt").show();
	 } 
 	else {
	 $("#check_tempt_txt").hide();
	 }

 if($('#NicotineYes').attr('checked')) {
	 $("#nic_txt").show();
	 } 
 	else {
	 $("#nic_txt").hide();
	 }

 $("#checkOther").click(function() {
	
    	var rates = $(this).val();
    	
    	if($(this).is(":checked"))
       	{
       		 $("#check_txt").show();
       	}
       	else
       	{
       		$("#check_txt").hide('fast');
       	}});

 $("#check_temptOther").click(function() {
		
 	var rates = $(this).val();
 	
 	if($(this).is(":checked"))
    	{
    		 $("#check_tempt_txt").show();
    	}
    	else
    	{
    		$("#check_tempt_txt").hide('fast');
    	}});

 $("#NicotineYes").click(function() {
		
	 	var rates = $(this).val();
	 	
	 	if($(this).is(":checked"))
	    	{
	    		 $("#nic_txt").show();
	    	}
	    	else
	    	{
	    		$("#nic_txt").hide('fast');
	    	}});

 $("#NicotineNo").click(function() {
		
	 	var rates = $(this).val();
	 	
	 	if($(this).is(":checked"))
	    	{
	    		 $("#nic_txt").hide('fast');
	    	}
	    	});
	
//eof check function

</script>
<script>
$(document).ready(function(){

jQuery("#AlcohalCessationAssesment").validationEngine({
validateNonVisibleFields: true,
updatePromptsPosition:true,
});
$('#submit_alcohal_cassation_assesment')
.click(
function() { 
//alert("hello");
var validatePerson = jQuery("#AlcohalCessationAssesment").validationEngine('validate');
//alert(validatePerson);
if (validatePerson) {$(this).css('display', 'none');}
//return false;
});


});
</script>