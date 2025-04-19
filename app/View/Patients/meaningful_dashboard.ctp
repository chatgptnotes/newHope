<?php
     echo $this->Html->script(array('jquery.autocomplete'));   
	 echo $this->Html->script(array('jquery.fancybox-1.3.4'));
	   echo $this->Html->css('jquery.autocomplete.css');
     echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
      $vals = array('Hispanic','Non-Hispanic','Latino','Others');
      
?>

<style>
.clear{clear:both;}
.table2{
margin-left: auto;
    margin-right: 298px;
    margin-top: -194px;
    padding: 3px;
    width: 28%;
}
.table3{
margin-left: auto;
    margin-right: 298px;
    margin-top: 9px;
    padding-left: 3px;
    width: 28%;
}
.table4{
font-size: 16px;
    margin-left: auto;
    margin-right: 22px;
    margin-top: -103px;
    width: 58%;

}
.tr1{background: #99CC55;}
.tr11{background:#ff9933;}
.table_format1{
cellpadding:0px; cellspacing:0px;
	width:100%;
	margin-left:0px;
	margin-top:122px;
	text-align: center; background: none repeat scroll 0 0 #3E474A;"

}
.div1{background: none repeat scroll 0 0 #384144;
    height: 124px;
    margin-left: 667px;
    width: 369px;}
.tr2{color:#000; background: #fff;}
.lbl{text-align:left; width:145px;}
.td{text-align:left;}
</style>

<div class="inner_title">
	<!-- Start for search -->
	<div align="right">
		
		<table>
			<tr>
				
				
				<td align="right" width="">
					<?php echo $this->Html->lable(__('MeaningFul Use Dashboard'), array('escape' => false,'class'=>'')); ?>
				</td>
			</tr>
		</table>
		<?php echo $this->Form->end(); ?>
	</div>
	<?php

	echo $this->Form->create('Person',array('type' => 'file','name'=>'register','id'=>'personfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); 
	echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));
	?>
	
	
	</div>

	<div class="inner_left">
		<?php //BOF new form design ?>
		<!-- form start here -->
		<div class="btns">
			<input class="blueBtn" type="submit" value="Print">
			<input class="blueBtn" type="submit" value="Save">
		</div>
		<div class="clr"></div>

		<!-- Patient Information start here -->
		<table width="50%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<th colspan="5">
					<?php echo __("Meaningful Use Dashboard") ; ?>
				</th>
			</tr>
				<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __("Provider");?> <font color="red">*</font>
			</td>
			<td width="30%"><table width="100%" cellpadding="0"
					cellspacing="0" border="0">
					<tr>
						<td>
				<?php echo $this->Form->input('suffix', array('options'=>array(""=>__('Please Select Provider'),"1."=>__('Naushadh Godrej M.D.'),"2."=>__('Francis Toan M.D.')),'class' => 'textBoxExpnd','id' => 'suffix')); ?>
			</td>
						
		</tr></table></td></tr>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __("Year");?> <font color="red">*</font>
			</td>
			<td width="30%"><table width="100%" cellpadding="0"
					cellspacing="0" border="0">
					<tr>
							<td>
							<?php echo $this->Form->input('initial_id', array('empty'=>__('Select'),'options'=>$initials,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'initials','style'=>'width:80px')); ?>
						</td>
					
					</tr>
				</table></td>
			</tr>
			<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Attestation Duration');?>
			</td>
				<td>
				<?php echo $this->Form->input('suffix', array('options'=>array(""=>__('2012-Full Year Attestation'),"2012"=>__('2012-90 days Attestation')),'class' => 'textBoxExpnd','id' => 'suffix')); ?>
			</td>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Start Date');?> <font color="red">*</font>
			</td>
			<td>
				<?php echo $this->Form->input('startdate', array('id' => 'startdate', 'label'=> false,'div' => false, 'error' => false)); ?>
                            </td>
			
			
		</tr>
		<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">
				<?php echo __('Report Last Updated');?> 
			</td>
			<td>
				
			</td>
		</tr>
			</table>
			<table class="clear"></table>
			<div class="div1">
			<table valign="right" width="50%" border="0" cellspacing="0" cellpadding="0"
			class="table2">
			<tr  class="tr1">
				<th colspan="5">
					<?php echo __("You Are Satisfying") ; ?>
				</th>
			</tr>
			<tr class="tr2">
				<th colspan="5">
					<?php echo __("48 Measures") ; ?>
				</th>
			</tr>
			</table>
			<table class="clear"></table>
				<table valign="right" width="50%" border="0" cellspacing="0" cellpadding="0"
			class="table3">
			<tr  class="tr11">
				<th colspan="5">
					<?php echo __("You Are Not Satisfying") ; ?>
				</th>
			</tr>
			<tr class="tr2">
				<th colspan="5">
					<?php echo __("6 Measures") ; ?>
				</th>
			</tr>
			</table>
			<table class="clear"></table>
			<table valign="right" width="50%" border="0" cellspacing="0" cellpadding="0"
			class="table4">
			<tr  class="">
				<th colspan="5">
					<?php echo __("Dashboard calculations are updated each night.Sign your SOAP notesto receive credit") ; ?>
				</th>
			</tr>
			
			</table></div>
		
		
		
		<?php //EOF new form design ?>
		
		
		<table border="0" class="table_format1" >



	<tr class="">

		<td class="td" align="right" width="48%"><label class="lbl">
				<strong><?php echo __('Core Measures') ?></strong>	
		</label></td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('Stage 1 Goal Minimum') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('Numerator/Denominator') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('Patient Gap') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('Learn How') ?>
		</label></td>
		
	</tr>
	
	<tr class="row_gray	">

		<td class="td" align="right" width="48%">
				<?php echo __('1. CPOE For medication orders') ?>
		</td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		
	</tr>
	
	<tr class="row_gray	">

		<td class="td" align="right" width="48%">
				<?php echo __('2. Drug-drug anddrug-allergy interaction checks') ?>
		</td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		
	</tr>
	
	<tr class="row_gray	">

		<td class="td" align="right" width="30%">
				<?php echo __('3. Maintain Problem List') ?>
		</td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		
	</tr>
	
	<tr class="row_gray	">

		<td class="td" align="right" width="30%">
				<?php echo __('4.Send Prescriptions electronicalyy(eRx) ') ?>
		</td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		
	</tr>
	
	<tr class="row_gray	">

		<td class="td" align="right" width="30%">
				<?php echo __('5.Maintain Medication List Maintain Allergy List') ?>
		</td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		
	</tr>
	
	<tr class="row_gray	">

		<td class="td" align="right" width="30%">
				<?php echo __('6. Maintain Allergy List ') ?>
		</td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		
	</tr>
	
	<tr class="row_gray	">

		<td class="td" align="right" width="30%">
				<?php echo __('7.Records Demographics') ?>
		</td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		
	</tr>
	
	<tr class="row_gray	">

		<td class="td" align="right" width="30%">
				<?php echo __('8.Records Vital signs') ?>
		</td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		
	</tr>
	
	<tr class="row_gray	">

		<td class="td" align="right" width="30%">
				<?php echo __('9.Records smoking status') ?>
		</td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		
	</tr>
	
	<tr class="row_gray	">

		<td class="td" align="right" width="30%">
				<?php echo __('10.Report Clinical Quality Measures') ?>
		</td>
		<td class="td" align="right" width="20%" ><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		<td class="td" align="right" width="20%"><label class="lbl">
				<?php echo __('') ?>
		</label></td>
		
	</tr>
	
	
	
	
	
	</table>
	</div>
	
	
	
	<?php echo $this->Form->end(); ?>

	<script>



	$( "#startdate" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
		buttonText:'Date of Incident',
		minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	

	jQuery(document)
			.ready(
					function() {

						// binds form submission and fields to the validation engine
						jQuery("#personfrm").validationEngine();
						$('#submit,#submit1')
								.click(
										function() {
											jQuery("#admission_type")
													.removeClass(
															'validate[required,custom[mandatory-select]]');
											$("#admission_type")
													.validationEngine(
															"hidePrompt");
											var validatePerson = jQuery(
													"#personfrm")
													.validationEngine(
															'validate');
											if (validatePerson) {
												$(this).css('display', 'none');
											}
										});
					

						$('#goforpatientbyotherway')
								.click(
										function() {
											jQuery("#admission_type")
													.addClass(
															'validate[required,custom[mandatory-select]]');
											var input = $("<input>")
													.attr("type", "hidden")
													.attr("name",
															"data[Person][submitandregister]")
													.val("1");
											$('#personfrm').append($(input));
											$('#personfrm').submit();

										});

						

						//on realtion select
						$('#insurance_relation_to_employee').change(function() {
							$('#insurance_esi_suffix').val($(this).val());
							$('#corpo_esi_suffix').val('');
							$('#corpo_relation_to_employee').val('');
						});

						$('#corpo_relation_to_employee').change(function() {
							$('#insurance_esi_suffix').val('');
							$('#corpo_esi_suffix').val($(this).val());
							$('#insurance_relation_to_employee').val('');
						});

						$('#doctor_id')
								.change(
										function() {
											$
													.ajax({
														url : "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"
																+ "/"
																+ $(this).val(),
														context : document.body,
														success : function(data) {
															$('#department_id')
																	.val(data);
														}
													});
										});

						$("#dob")
						.datepicker(
								{
									showOn : "button",
									buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly : true,
									changeMonth : true,
									changeYear : true,
									yearRange : '-50:+50',
								//	maxDate : new Date(),
									dateFormat:'<?php echo $this->General->GeneralDate();?>',
								});
				$("#gau_dob")
				.datepicker(
						{
							showOn : "button",
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							changeMonth : true,
							changeYear : true,
							yearRange : '-50:+50',
							//maxDate : new Date(),
							dateFormat:'<?php echo $this->General->GeneralDate();?>',
						});
						$("#dob2")
						.datepicker(
								{
									showOn : "button",
									buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly : true,
									changeMonth : true,
									changeYear : true,
									yearRange : '-50:+50',
									maxDate : new Date(),
									dateFormat:'<?php echo $this->General->GeneralDate();?>',
								});
						
						
						
						$("body")
								.click(
										function() {
											var dateofbirth = $("#dob").val();
											if (dateofbirth != "") {
												var currentdate = new Date();
												var splitBirthDate = dateofbirth
														.split("/");
												var caldateofbirth = new Date(
														splitBirthDate[2]
																+ "/"
																+ splitBirthDate[1]
																+ "/"
																+ splitBirthDate[0]
																+ " 00:00:00");
												var caldiff = currentdate
														.getTime()
														- caldateofbirth
																.getTime();
												var calage = Math
														.floor(caldiff
																/ (1000 * 60 * 60 * 24 * 365.25));
												$("#age").val(calage);
											}

										});


						
						// disable 5 text boxes when card is selected //
						//to hide and show insurance and corporate block.
						

						

						//fnction to disable one option
						
					});

	//FUNCTION TO ADD TEXT BOX ELEMENT
	var intTextBox = 0;
	var intcheckBox = 0;
	var intstatus = 0;
	var intcomments = 0;
	function addElement() {
		intTextBox = intTextBox + 1;
		intcheckBox = intcheckBox + 1;
		intstatus = intstatus + 1;
		intcomments = intcomments + 1;
		var contentID = document.getElementById('content');
		var contentID1 = document.getElementById('content1');
		var contentID2 = document.getElementById('content2');
		var contentID3 = document.getElementById('content3');
		
		
		var newCBDiv = document.createElement('td');
		var newTBDiv = document.createElement('td');
		var newSTATUSDiv = document.createElement('td');
		var newCOMMENTDiv = document.createElement('td');

		newTBDiv.setAttribute('id', 'strText' + intTextBox);
		newCBDiv.setAttribute('id', 'strText' + intcheckBox);
		newSTATUSDiv.setAttribute('id', 'strText' + intstatus);
		newCOMMENTDiv.setAttribute('id', 'strText' + intcomments);

		newTBDiv.innerHTML =
				"<td><select id='" + intTextBox + "' name='" + intTextBox + "'><option>Select</option><option>Mother</option><option>Father</option><option>Borther</option><option>Sister</option></select></td> ";
		newCBDiv.innerHTML = 
				 "<input type='text' id='" + intTextBox + "' name='" + intTextBox + "'/>";
		newSTATUSDiv.innerHTML = 
				"<select id='" + intTextBox + "' name='" + intTextBox + "'><option>Select</option><option>Deceased</option><option>Living</option><option>Negative</option><option>Positive</option><option>Not Present</option></select> ";
		newCOMMENTDiv.innerHTML = 
				"<input type='text' id='" + intTextBox + "' name='" + intTextBox + "'/>";

		contentID.appendChild(newTBDiv);
		contentID1.appendChild(newCBDiv);
		contentID2.appendChild(newSTATUSDiv);
		contentID3.appendChild(newCOMMENTDiv);
	}

	//FUNCTION TO REMOVE TEXT BOX ELEMENT
	function removeElement() {
		if (intTextBox != 0 && intcheckBox != 0 && intstatus != 0) {
			var contentID = document.getElementById('content');
			contentID.removeChild(document.getElementById('strText'
					+ intTextBox));
			contentID.removeChild(document.getElementById('strText'
					+ intcheckBox));
			contentID.removeChild(document
					.getElementById('strText' + intstatus));
			contentID.removeChild(document.getElementById('strText'
					+ intcomments));
			intTextBox = intTextBox - 1;
			intcheckBox = intcheckBox - 1;
			intstatus = intstatus - 1;
			intcomments = intcomments - 1;
		}
	}
	 // check not demographic
	$( "#ckeckDemo" ).click(function(){
		if($( "#ckeckDemo" ).is(':checked') == true) {
					 $( "#language" ).val('173');
                     $( "#ethnicity" ).val('Denied to Specific');
                    $( "#race" ).val('2131-0');
                    document.getElementById("language").disabled=true;
                    document.getElementById("ethnicity").disabled=true;
                    document.getElementById("race").disabled=true;
                     // $("#bed_id").append( "<option value=''>Please Select</option>" );
                    } 
		else{
			 
				 $( "#language" ).val('select');
                 $( "#ethnicity" ).val('select');
                $( "#race" ).val('select');
                document.getElementById("language").disabled=false;
                document.getElementById("ethnicity").disabled=false;
                document.getElementById("race").disabled=false;
                 // $("#bed_id").append( "<option value=''>Please Select</option>" );
                
		}
	}); 
	
	
	

	// To call the patient registration page on clicking submit and register.

	function getRedirected() {

	}
</script></script>