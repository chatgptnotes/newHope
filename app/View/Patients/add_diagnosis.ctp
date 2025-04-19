<?php
 	 echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
	 echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
 echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));  
echo $this->Html->script(array('/theme/Black/js/jquery.ui.widget.js','/theme/Black/js/jquery.ui.mouse.js','/theme/Black/js/jquery.ui.core.js','/theme/Black/js/ui.datetimepicker.3.js',
									'/theme/Black/js/permission.js','/theme/Black/js/pager.js'));
?>
<?php echo $this->Html->charset(); ?>
<title>
	<?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>

</head>
<body>

	<div class="inner_title">
		<h3>
			&nbsp;
			<?php echo __('Make a diagnosis', true); ?>
		</h3>

	</div>
	<?php 
	  if(!empty($errors)) {
	?>
	
					<?php 
	     foreach($errors as $errorsval){
	         echo $errorsval[0];
	         echo "<br />";
	     }
	   ?>
			
	<?php } ?>
	<?php echo $this->Form->create('make_diagnosis');
		 	echo $this->Form->hidden('id',array('name'=>'id'));
			echo $this->Form->hidden('icd_id',array('value'=> $icd[0][icds][id],'name'=>'icd_id'));
			echo $this->Form->hidden('patient_id',array('value'=> $icd[0][icds][p_id],'name'=>'patient_id'));
			echo $this->Form->hidden('note_id',array('value'=> $icd[0][icds][note_id],'name'=>'note_id')); ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="500px">
		<tr class="row_title">
			<td class="patientHub" width="500px" cellpadding="5px" valign="bottom" colspan='2'><strong>

					<?php echo __('Patient name') ?>
					:</strong>
				 <?php echo $icd[0][icds][p_name]; ?> <span> <?php echo $this->Html->link($this->Html->image('/img/icons/book.jpg', array('alt' => 'Patient education')),
										array("controller" => "laboratories", "action" => "patient_search",'?'=>array('type'=>'OPD'), "admin" => false,'plugin' => false),
											 array('escape' => false)); ?>
			</span></td>
		</tr>

		<tr class="row_title">
			<td class="row_format" colspan=''>
					<?php echo __('Diagnosis :') ?>&nbsp;&nbsp;&nbsp;
				&nbsp;<?php echo $icd[0][icds][icd_code]; ?>&nbsp;&nbsp;&nbsp;<?php echo $icd[0][icds][description]; ?></td>
		</tr>
		<tr class="row_title">
			<td class="row_format" colspan=''>
				<?php echo $this->Form->input(__('Start_date'), array('type'=>'text','id' => 'start_date','name'=>'start_dt','class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:22%;','div'=>false )); ?>
				<?php echo $this->Form->input(__('End_date'),   array('type'=>'text','id' => 'end_date','name'=>'end_dt','class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:22%;','div'=>false )); ?>
			</td>
		</tr>
		<tr class="row_title">
			
			<td class="row_format">
			<?php echo $this->Form->radio(__('disease_status'), array('Chronic'=>'Chronic','terminal'=>'is terminal'),array('value'=>(isset($this->data['NoteDiagnosis']['disease_status'])?$this->data['NoteDiagnosis']['disease_status']:0),'legend'=>false,'name'=>'disease_status','label'=>false,'id' => 'disease_status' ));
 ?></td>
		</tr>
		<tr>
			<td>
				<?php echo $this->Form->input(__('Comment'),array('type'=>'textarea','rows'=>'2','cols'=>'80','name'=>'comment'));?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->Form->input(__('Pervious comment on this diagnosis'),array('type'=>'textarea','rows'=>'2','cols'=>'80','name'=>'prev_comment'));?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->Form->button(__('Back'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'makd' ));?>
				<?php  echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'sel' ));?>
			</td>
		</tr>
	</table>
<?php echo $this->Form->end(); ?>
</body>

<script>
	jQuery(document)
			.ready(
					function() {

						$("#start_date")
								.datepicker(
										{
											showOn : "button",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',

											dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
											onSelect : function() {
												$(this).focus();
											}
										});
						$("#end_date")
								.datepicker(
										{
											showOn : "button",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',

											dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
											onSelect : function() {
												$(this).focus();
											}
										});
					});

	
	
	
	
	jQuery(document).ready(function() {

		$('#makd').click(function() {
			
			parent.$.fancybox.close();

		});
$('#sel').click(function() {
			
			parent.$.fancybox.close();

		});

	});
</script>