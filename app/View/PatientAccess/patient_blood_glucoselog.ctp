<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.1.27/jquery.form-validator.min.js"></script>
<script> $.validate(); </script>
<?php echo $this->Html->script(array('patient_access_js1.js','patient_access_js2.js') );
   echo $this->Html->css(array('patient_access.css',));?>
</head>
<body>
	<div style="border: 0.5px #fff">
		<h1>
			<?php echo __('Blood Glucose Log') ?>
		</h1>
		<p>
			If your concerned about the values on the blood sugar log that you are
			sending us today please call our office at <b>000-111-222</b> to
			speak with clinical staff members immediately. If you not heard from
			our office within 24 hours of sending us yours log and you have
			logged high blood sugar values, please call our office and press the
			prompts to speak your doctors, nurse or medical assistant.
		
		</p>
		<p>
			<b>You will be called ONLY if a change to your treatment plan is needed.</b>
		</p>

		<p>Test Blood sugars before breakfast and one hour after every meal.</p>


		<?php  echo $this->Form->create("", array("action" => "","id" => "searchForm"));?>
		<table border="0" class=" " cellpadding="0" cellspacing="0"
			width="500px" align="left">
			<tbody>
				<tr class="">
					<td class=" "><?php echo __('Endocrinologist :') ?></td>
					<td class=" "><?php echo $this->Form->input("keyword", array("label" => "",'class' => 'drugText ',"type" => "search",'autocomplete'=>false));?>
					</td>
					<td class=" " align="right" colspan="2"><?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	?>
					</td>
				</tr>
			</tbody>
		</table>

		<form name="blood_glucose_logfrm" id="blood_glucose_logfrm"
			action="<?php echo $this->Html->url(array("controller" => "", "action" => "",)); ?>"
			method="post">
			<table class="table_format" border="0" cellpadding="0"
				cellspacing="0" width="60%" align="left">
				<tr>
					<td><h2>
							<?php echo __('Day Report One'); ?>
						</h2>
					</td>
				</tr>

				<tr>
					<td><?php echo __('Date'); ?><font color="red">*</font></td>

					<td><?php echo $this->Form->hidden('Recipient.patient_id', array( 'id' => 'patient_id', 'value'=>$patient_id,'label'=> false, 'div' => false, 'error' => false));
       				 echo $this->Form->input('Recipient.date', array('class' => 'validate[required,custom[date]] textBoxExpnd', 'id' => 'date', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
				</tr>
			</table>

			<table class="table_format" border="0" cellpadding="0"
				cellspacing="0" width="100%" align="left">
				<tr>
					<td></td>
					<td><?php echo __('Breakfast'); ?>
					</td>
					<td><?php echo __('Lunch'); ?>
					</td>
					<td><?php echo __('Dinner'); ?>
					</td>
					<td><?php echo __('Bedtime'); ?>
					</td>
				</tr>

				<tr>
					<td><?php echo __('Before Meal(<90>)'); ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false));; ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
				</tr>

				<tr>
					<td><?php echo __('Meds Action Taken'); ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false));; ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
				</tr>


				<tr>
					<td><?php echo __('After Meal()<120'); ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false));; ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
				</tr>
			</table>

			<table class="table_format" border="0" cellpadding="0"
				cellspacing="0" width="100%" align="left">
				<tr>
					<td width="50%"><?php echo __('Please fill in the Gestational Age, Ketones and Obestetrician if you'); ?>
					</td>
					<td width="25%"></td>
					<td></td>
					<td></td>
				</tr>
			</table>

			<table class="table_format" border="0" cellpadding="0"
				cellspacing="0" width="50%" align="left">
				<tr>
					<td width=""><?php echo __('Gestational Age'); ?>
					</td>
					<td><?php echo $this->Form->input('Recipient.last_name', array('class' => 'validate[required,custom[name]] textBoxExpnd', 'id' => 'recipient_lastname', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
				</tr>

				<tr>
					<td><?php echo __('Ketones'); ?></td>

					<td><?php      echo $this->Form->input('Recipient.fax', array( 'id' => 'recipient_fax', 'class' =>'textBoxExpnd','label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
				</tr>

				<tr>
					<td><?php echo __('Obstetrician'); ?></td>
					<td><?php      echo $this->Form->input('Recipient.phone', array( 'class' => 'validate[required,custom[number]] textBoxExpnd','id' => 'recipient_phone', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
				</tr>
			</table>

			<table class="table_format" border="0" cellpadding="0"
				cellspacing="0" width="100%" align="left">

				<tr>
					<td><b><?php echo __('If you have 3 consecutive blood sugars less than 70 or more 120 after a meal, Call 000-11-222 and ask to speak to your provider nurse'); ?></b>
					</td>
				</tr>
			</table>

			<table class="table_format" border="0" cellpadding="0"
				cellspacing="0" width="100%" align="left">
				<tr>
					<td width="30%"><?php echo __('Blood Glucose Meter'); ?></td>
					<td width="30%"><?php    echo $this->Form->input('Recipient.email', array( 'id' => 'recipient_email', 'label'=> false,'class' =>'textBoxExpnd', 'div' => false, 'error' => false)); ?>
					</td>
					<td width="30%"></td>
				</tr>
				<tr>
					<td><?php echo __('Date Of Initial Diabeted Education'); ?></td>
					<td><?php  echo $this->Form->input('Recipient.email', array( 'id' => 'ide_date', 'label'=> false,'class' =>'textBoxExpnd', 'div' => false, 'error' => false));  ?>
					</td>
				</tr>

				<tr>
					<td><?php echo __('Home Number:'); ?> <?php  echo $this->Form->input('Recipient.email', array( 'id' => 'recipient_email', 'label'=> false,'class' =>'textBoxExpnd', 'div' => false, 'error' => false));?>
					</td>
					<td><?php echo __('Cell Phone:'); ?> <?php    echo $this->Form->input('Recipient.email', array( 'id' => 'recipient_email', 'label'=> false,'class' =>'textBoxExpnd', 'div' => false, 'error' => false));?>
					</td>
					<td><?php echo __('Work Phone:'); ?> <?php  echo $this->Form->input('Recipient.email', array( 'id' => 'recipient_email', 'label'=> false,'class' =>'textBoxExpnd', 'div' => false, 'error' => false));  ?>
					</td>
				</tr>

				<tr>
					<td><?php echo __('May we have a message:'); ?> <?php echo $this->Form->input('Recipient.department_id', array('empty'=>__('Please Select'),'options'=>$departments,'class' => 'textBoxExpnd','id' => 'department_id','label'=>false)); ?>

					</td>
					<td><?php echo __('May we have a message:'); ?> <?php echo $this->Form->input('Recipient.department_id', array('empty'=>__('Please Select'),'options'=>$departments,'class' => 'textBoxExpnd','id' => 'department_id','label'=>false)); ?>

					</td>
					<td><?php echo __('May we have a message:'); ?> <?php echo $this->Form->input('Recipient.department_id', array('empty'=>__('Please Select'),'options'=>$departments,'class' => 'textBoxExpnd','id' => 'department_id','label'=>false)); ?>
				
				</tr>

				<tr>
					<td colspan="2" align="left" class=""><?php echo "&nbsp;&nbsp;".$this->Form->submit('Save',array('class'=>'blueBtn','id'=>"submit",'div'=>false));	 
					echo $this->Html->link(__('Add'),array('action' => ''),array('id'=>"cancel",'escape' => false,'class'=>'grayBtn'));
					echo $this->Html->link(__('Next'),array('action' => ''),array('id'=>"cancel",'escape' => false,'class'=>'grayBtn'));
					echo $this->Html->link(__('Cancel'),array('action' => ''),array('id'=>"cancel",'escape' => false,'class'=>'grayBtn'));
						
	    ?></td>
				</tr>
			</table>
		</form>
	</div>
	<script>
	
 $("#date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				date_format_us : 'mm/dd/yy ',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});
 $("#ide_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				date_format_us : 'mm/dd/yy ',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});
	</script>

</body>
</html>
