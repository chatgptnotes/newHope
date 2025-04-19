<?php
echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('/theme/Black/js/jquery.ui.widget.js','/theme/Black/js/jquery.ui.mouse.js','/theme/Black/js/jquery.ui.core.js','/theme/Black/js/ui.datetimepicker.3.js',
		'/theme/Black/js/permission.js','/theme/Black/js/pager.js'));
?>
<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>

</head>
<body>

	<div class="inner_title">
		<h3>
			&nbsp;
			<?php echo __('Make Diagnosis', true);
						?>
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
	<?php
	echo $this->Form->create('make_diagnosis_patient',array('id'=>'make_daignosis_patient'));
	echo $this->Form->hidden('id',array('name'=>'id'));

	echo $this->Form->hidden('icd_id',array('value'=> $icd[0][icds][icd_snomed],'name'=>'icd_id'));
	echo $this->Form->hidden('patient_id',array('value'=> $icd[0][icds][p_id],'name'=>'patient_id'));
	echo $this->Form->hidden('note_id',array('value'=> $icd[0][icds][note_id],'name'=>'note_id'));
	
	
	/*if (!empty($icd[0]["icds"]["icd_snomed"]) && $icd[0]["icds"]["icd_snomed"] != "undefined") {
		 
		$host = "sandbox.e-imo.com";
		$port = "42011";
		$timeout = 15;  //timeout in seconds
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
		or die("Unable to create socket\n");
		//socket_set_nonblock($socket)
		// or die("Unable to set nonblock on socket\n");
	
		$result=socket_connect($socket, $host, $port);
		if ($result === false) {
			echo "socket_connect() failed.\nReason: ($result) " .
			socket_strerror(socket_last_error($socket)) . "\n";
		} else {
			//echo "OK.\n";
		}
	
		$msg_search = "detail^".$icd[0][icds][icd_snomed]."^1^e0695fe74f6466d0^" . "\r\n";
	
	
		if (!socket_write($socket, $msg_search, strlen($msg_search))) {
			echo socket_last_error($socket);
		}
		else
		{
			//echo "write";
		}
	
		while ($bytes=socket_read($socket, 100000)) {
                                if ($bytes === false) {
                                                echo
                                                socket_last_error($socket);
                                                break;
                                }
                                if (strpos($bytes, "\r\n") != false) break;
	                }

                socket_close($socket);
                 
                $xmlString="<items>".$bytes."</items>";
                $xmldata = simplexml_load_string($xmlString);
              //echo "<pre>";print_r($xmldata);
                $snomed=$xmldata->ICD9_SNOMEDCT_IMO->RECORD->SCT_CONCEPT_ID;
                 
                //echo"SCT_CONCEPT_ID:::"; echo $xmldata->ICD9_SNOMEDCT_IMO->RECORD->SCT_CONCEPT_ID ."<br/>";
                $snomed_name=$xmldata->ICD9_SNOMEDCT_IMO->RECORD->FULLYSPECIFIEDNAME;
                $ICD9cm=$xmldata->ICD9_IMO->RECORD->ICD9_BASE_TEXT_CODE."^".$xmldata->ICD9_IMO->RECORD->BASE_TEXT;
                 
                $edu = $xmldata->ICD9_DEFINITIONS_IMO->RECORD->DEFINITION_TEXT;
 
	
		} */
                 
                // echo"SNOMEDID:::";  echo $xmldata->ICD9_DEFINITIONS_IMO->RECORD->DEFINITION_TEXT;

	//echo "<pre>";print_r($icd); 
                ?>
                
                
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="500px">
		<tr class="row_title">
			<td class="patientHub" width="500px" cellpadding="5px"
				valign="bottom" colspan='2'><strong> <?php echo __('Patient name') ?>
					:
			</strong> <?php echo $icd[0][icds][p_name]; ?> <!--<span> <?php //echo $this->Html->link($this->Html->image('/img/icons/book.jpg', array('alt' => 'Patient education')),
					//array("controller" => "patients", "action" => "patient_education",$edu, "admin" => false,'plugin' => false),
											// array('escape' => false )); ?>
			</span>  --></td>
		</tr>

		<tr class="row_title">
			<td class="row_format" colspan=''><?php echo __('Diagnosis :') ?>&nbsp;&nbsp;&nbsp;
				&nbsp;<?php echo $icd[0][icds][icd_snomedid]; ?>&nbsp;&nbsp;&nbsp;<?php echo $icd[0][icds][icd_description];//echo ($snomed_name=="")?$customSnow['diagnosisHistory']['name']:$snomed_name; ?>
				<label id="db_icd_code"></label>
				<?php echo $this->Form->hidden('name',array('type'=>'text', 'value'=>$icd[0][icds][icd_description]));?>
				<?php  echo $this->Form->hidden('snowmedid',array('type'=>'text', 'value'=>$icd[0][icds][icd_snomedid]));?>
			</td>
		</tr>
		<tr class="row_title">
			<td class="row_format" colspan=''><?php echo $this->Form->input(__('Start_date'), array('type'=>'text','id' => 'start_date','name'=>'start_dt','class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:22%;','div'=>false,'value'=>$edit_makediagnosis['0']['NoteDiagnosis']['start_dt'] )); ?>
				<?php echo $this->Form->input(__('End_date'),   array('type'=>'text','id' => 'end_date','name'=>'end_dt','class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:22%;','div'=>false,'value'=>$edit_makediagnosis['0']['NoteDiagnosis']['end_dt'] )); ?>
			</td>
		</tr>
		<tr class="row_title">

			<td class="row_format"><?php echo $this->Form->radio(__('disease_status'), array('chronic'=>'Chronic','terminal'=>'is terminal','resolve'=>'is resolve'),array('value'=>(isset($edit_makediagnosis["0"]["NoteDiagnosis"]["disease_status"])?$edit_makediagnosis["0"]["NoteDiagnosis"]["disease_status"]:""),'legend'=>false,'name'=>'disease_status','label'=>false,'id' => 'disease_status' ));
			?>
			</td>
		</tr>
		<tr>
			<td><?php echo $this->Form->input(__('Comment'),array('type'=>'textarea','rows'=>'2','cols'=>'80','name'=>'comment','value'=>$edit_makediagnosis['0']['NoteDiagnosis']['comment']));?>
			</td>
		</tr>
		
		<tr>
			<td><?php echo $this->Form->input(__('Pervious comment on this diagnosis'),array('type'=>'textarea','rows'=>'2','cols'=>'80','name'=>'prev_comment','value'=>$edit_makediagnosis['0']['NoteDiagnosis']['prev_comment']));?>
			</td>
		</tr>
		<tr>
			<td><?php
			echo $this->Form->hidden(__('preffered_icd9cm'),array('type'=>'text','id' => 'preffered_icd9cm','name'=>'preffered_icd9cm','value'=>$ICD9cm));
			echo $this->Form->hidden(__('u_id'),array('type'=>'text','id' => 'u_id','name'=>'u_id','value'=>$u_id));
				 echo $this->Form->button(__('Back'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'makd' ));?>
				<?php  echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn'));?>
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

											dateFormat:'<?php echo $this->General->GeneralDate();?>',
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

											dateFormat:'<?php echo $this->General->GeneralDate();?>',
											onSelect : function() {
												$(this).focus();
											}
										});
					});

	
	
	
	
	jQuery(document).ready(function() {

		$('#makd').click(function() {
			
			parent.$.fancybox.close();

		});


	});
	$('#make_daignosis').submit(function(){
		
		var validationRes = jQuery("#make_daignosis").validationEngine('validate');
		var received			 	= new Date($('#start_date').val()); 
	 
		var completed 			 	= new Date($('#end_date').val());

		
		var error = '';
		if (received.getTime() > completed.getTime())
		{
			alert("End Date Should Be Greater then Start Date");
		}
		
		
		else{
			alert("Diagnosis Saved");
			parent.$.fancybox.close();
		}
		
	});

	$('#make_daignosis_patient').submit(function(){
			
			var validationRes = jQuery("#make_daignosis_patient").validationEngine('validate');
			var received			 	= new Date($('#start_date').val()); 
		 
			var completed 			 	= new Date($('#end_date').val());
	
			
			var error = '';
			if (received.getTime() > completed.getTime())
			{
				alert("End Date Should Be Greater then Start Date");
			}
			
			
			else{
				alert("Diagnosis by patient Saved");
				parent.$.fancybox.close();
			}
			
		});
	
</script>
