<?php
echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('/theme/Black/js/jquery.ui.widget.js','/theme/Black/js/jquery.ui.mouse.js','/theme/Black/js/jquery.ui.core.js','/theme/Black/js/ui.datetimepicker.3.js',
		'/theme/Black/js/permission.js','/theme/Black/js/pager.js'));
 echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>

</head>
<body>

	<div class="inner_title">
		<h3>
			&nbsp;
			<?php echo __('Edit a diagnosis', true); ?>
		</h3>

	</div>

	<?php 

	//-----------------------------to connect the socket--------------------------------------------------
	/*$host = "sandbox.e-imo.com";
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
	//--------------------------------------------------------------------------------------------------------------------------

	$msg_search = "detail^".$icds1."^1^e0695fe74f6466d0^" . "\r\n";


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



	$xmlString="<items>".$bytes."</items>";
	$xmldata = simplexml_load_string($xmlString);
	//print_r($xmldata);
	//print_r($xmldata->ICD9_LEXICALS_TEXT_IMO->RECORD->ICD9_LEXICALS_TEXT_IMO_CODE);

	$snomed_code= $xmldata->ICD9_SNOMEDCT_IMO->RECORD->SCT_CONCEPT_ID;
	$snomed_name=$xmldata->ICD9_SNOMEDCT_IMO->RECORD->FULLYSPECIFIEDNAME;
	// echo"SNOMEDID:::";  echo $xmldata->ICD9_SNOMEDCT_IMO->RECORD->SNOMEDID;
	$patient_edu=$xmldata->ICD9_DEFINITIONS_IMO->RECORD->DEFINITION_TEXT;
	*/

	echo $this->Form->create('NoteDiagnosis',array('id'=>'dxfrm','name'=>'NoteDiagnosis'));
	/* echo $this->Form->hidden('icd_id',array('value'=> $icd[0][icds][icd_id],'name'=>'icd_id'));
	echo $this->Form->hidden('patient_id',array('value'=> $icd[0][icds][p_id],'name'=>'patient_id')); */
	echo $this->Form->hidden('id');

	//====================================================================================================================================================
  
	?>


	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="500px">
		<tr class="row_title">
			<td class="patientHub" width="500px" cellpadding="5px"
				valign="bottom" colspan='2'><strong> <?php echo __('Patient name') ?>
					:
			</strong> <?php echo $patient['Patient']['lookup_name']; ?> <span> <?php /* echo $this->Html->link($this->Html->image('/img/icons/PATIENT EDUCATION ICON.png', array('alt' => 'Patient education','title'=>'Patient education')),
					array("controller" => "Patients", "action" => "patient_education",$patient_edu,$icd[0][icds][diagnoses_name]),
											 array('escape' => false)); */?>
			</span></td>
		</tr>

		<tr class="row_title">
			<td class="row_format" colspan=''><?php echo __('Diagnosis :') ?>&nbsp;&nbsp;&nbsp;
				&nbsp;<?php

				echo $this->data['NoteDiagnosis']['snowmedid']; ?>&nbsp;&nbsp;&nbsp;<?php echo  $this->data['NoteDiagnosis']['diagnoses_name'];  ?>
			</td>

		</tr>
		<tr class="row_title">
			<td class="row_format" colspan=''><label >Start Date</label><?php echo $this->Form->input('start_dt', array('type'=>'text','id' => 'start_date',
					'class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:22%;','div'=>false,'label'=>false )); ?>
					<label >End Date</label>
				<?php echo $this->Form->input('end_dt',   array('type'=>'text','id' => 'end_date',
						'class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:22%;','div'=>false ,'label'=>false)); ?>
			</td>
		</tr>
		<tr class="row_title">

			<td class="row_format">
			 
			<?php if($this->data['NoteDiagnosis']['disease_status'] == 'Chronic'){
				$disp = "Chronic";
			}else if($this->data['NoteDiagnosis']['disease_status'] == 'terminal'){
							$disp = "terminal";
				}
				else{
				$disp = "resolved";
				}
				?> <?php echo $this->Form->radio('disease_status', array('chronic'=>'Chronic','terminal'=>'is terminal','resolved'=>'is Resolved'),
						array( 'legend'=>false,'label'=>false,'id' => 'disease_status' ));
				?>
			</td>
		</tr>

		<tr>
			<td><label >Comment</label><?php  echo $this->Form->input('comment',array('type'=>'textarea','rows'=>'2','value'=>'','cols'=>'80','label'=>false));?>
			</td>
		</tr>
		<tr>
			<td><label >Pervious Comment On This Diagnosis</label><?php  echo $this->Form->input('prev_comment',array('value'=>$this->request->data['NoteDiagnosis']['comment'],'type'=>'textarea','rows'=>'2','cols'=>'80','label'=>false));?>
			</td>
		</tr>

		<tr>
			<td><?php  echo $this->Form->button(__('Back'), array('type'=>'button','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'makd' ));?>
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
		//alert('k');

		$('#makd').click(function() {
			
			parent.$.fancybox.close();

		});


	});
	$('#dxfrm').submit(function(){
		//validate[required,custom[mandatory-date]] textBoxExpnd hasDatepicker
		var diesesStatus = $("#dxfrm input[type='radio']:checked").val();
		
		if(diesesStatus == 'resolved'){
			$('#end_date').addClass("validate[required,custom[mandatory-date]] textBoxExpnd");
		}else{
			$('#end_date').removeClass("validate[required,custom[mandatory-date]] textBoxExpnd");
		}
		var validationRes = jQuery("#dxfrm").validationEngine('validate');
		if(!validationRes) return false ;
		var received			 	= new Date($('#start_date').val()); 
	 
		var completed 			 	= new Date($('#end_date').val());

		
		var error = '';
		if (received.getTime() > completed.getTime())
		{
		  	alert("End Date Should Be Greater then Start Date");
		}
		
		
		else{
			alert("Diagnosis edited successfully");
			parent.$.fancybox.close();
			
		}
		
	});
</script>
