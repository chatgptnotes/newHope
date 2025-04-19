<?php ?>
	<?php
	if(!empty($frequentMedicationByDoctor)){?>
					<table  width="50%" class="formFull formFullBorder" align="center">
							<tr style="color:gray"><td style="text-align:left;font-weight:bold; background:#d2ebf2 repeat-x;padding: 5px 0 5px 10px;" colspan="5">Frequently Prescribed Medications.<span style="text-align:right"><?php echo $this->Html->link(__('Close'), 'javascript:void(0)', array('class'=>'blueBtn','style'=>'float:right; width:40px; height:15px !important; text-align:center;','onclick'=>'javascript:closeFormulary()'));?></span></span></td></tr>
					<tr bgcolor="#CCCCCC"><td width=12% style="padding:5px 0 5px 10px;">Drug Name</td>
		</tr>
		<?php foreach($frequentMedicationByDoctor as $data){?>
					<td width=12% style="padding:5px 0 5px 10px;">
					<?php 
		                 echo $this->Html->link(ucfirst($data['NewCropPrescription']['description']),'javascript:void(0)',array('title'=>'Click to change','onclick'=>'changeDrug(0,"'.ucfirst($data['NewCropPrescription']['description']).'","'.$data['NewCropPrescription']['drug_id'].'|")'));?>
					</td>
						</tr>
				<?php 	}?>
					</tr>
			<?php 	}else{?>
				<tr bgcolor="#CCCCCC"><td width=12% style="padding:5px 0 5px 10px;">No records found</td>
		</tr><?php }?>
			</table>
				<script>
							function changeDrug(sequenceno,drugName,drugId) {
								//alert($('#drugText_0').val());
								if($('#drugText_0').val()==''){
									$("#DrugGroup0").remove();
								}
								var newCostDiv = $(document.createElement('tr'))
								     .attr("id", 'DrugGroup' + counter);
							     var str_option_value='<?php echo $str;?>';
								var route_option_value='<?php echo $str_route;?>';
								var dose_option_value='<?php echo $str_dose;?>';
								var dose_option ='<select style="" id="dose_type'+counter+'" class="validate[required,custom[mandatory-select]]" name="NewCropPrescription[dose][]"><option value="">Select</option><option value="1">0.5/half</option><option value="2">1</option><option value="3">1-2</option><option value="4">1-3</option><option value="5">1.5</option><option value="6">2</option><option value="7">3</option><option value="8">4</option><option value="9">5</option><option value="10">10</option><option value="11">15</option><option value="12">20</option><option value="13">30</option><option value="15">2.5</option><option value="16">7.5</option><option value="18">2-3</option><option value="19">6</option><option value="20">7</option><option value="21">8</option><option value="22">9</option><option value="23">11</option><option value="24">12</option><option value="25">0.33/third</option><option value="26">0.5-1</option></select>';
								var dosage_form = '<select style="width:80px;margin: 0 0 0 0px;", id="dosageform_'+counter+'" class="validate[required,custom[mandatory-select]] dosageform" name="NewCropPrescription[DosageForm][]"><option value="">Select</option><option value="12">tablet</option><option value="1">application</option><option value="2">capsule</option><option value="3">drop</option><option value="4">gm</option><option value="19">item</option><option value="5">lozenge</option><option value="17">mcg</option><option value="18">mg</option><option value="6">ml</option><option value="7">patch</option><option value="8">pill</option><option value="9">puff</option><option value="10">squirt</option><option value="11">suppository</option><option value="13">troche</option><option value="14">unit</option><option value="15">syringe</option><option value="16">package</option></select>';
								var route_option = '<select style="width:80px;margin: 0 0 0 0px;" id="route_administration'+counter+'" class="validate[required,custom[mandatory-select]] frequency" name="NewCropPrescription[route][]"><option value="">Select</option><option value="1">as directed</option><option value="2">by mouth</option><option value="4">ears, both</option><option value="32">ear, left</option><option value="33">ear.right</option><option value="5">eyes.both</option><option value="34">eyes.left</option><option value="35">eye.right</option><option value="40">eyelids.applyto</option><option value="42">eye.surgical</option><option value="36">face.apply to</option><option value="37">face, thin layer to</option><option value="38">feeding tube.via</option><option value="11">inhale</option><option value="12">inject. intramuscular</option><option value="23">intravenous</option><option value="30">lip. under the</option><option value="41">nail. apply to</option><option value="6">nostrils, in the</option><option value="14">penis. inject into</option><option value="7">rectum. in the</option><option value="39">scalp.apply to</option><option value="13">skin. inject below</option><option value="15">skin. inject into</option><option value="25">skin. apply on</option><option value="26">teeth. apply to</option><option value="27">tongue . on the</option><option value="31">tongue . under the</option><option value="8">urethra, in the</option><option value="9">vagina, in the</option><option value="3">epidural</option><option value="10">in vitro</option><option value="16">intraarterial</option><option value="17">intraarticular</option><option value="18">intraocular</option><option value="19">intraperitoneal</option><option value="20">intrapleural</option><option value="21">intrathecal</option><option value="22">intrauterine</option><option value="24">intravesical</option><option value="28">perfusion</option><option value="29">rinse</option></select>';
				var frequency_option = '<select  style="width:80px;margin: 0 0 0 0px;", id="frequency'+counter+'" class="validate[required,custom[mandatory-select]] frequency_value " name="NewCropPrescription[frequency][]"><option value="">Select</option><option value="1">As directed</option><option value="2">Daily</option><option value="4">In the morning, before noon</option><option value="5">Twice a day</option><option value="6">Thrice a day</option><option value="7">Four times a day</option><option value="29">Every 2 hours</option><option value="28">Every 3 hours</option><option value="8">Every 4 hours</option><option value="9">Every 6 hours</option><option value="10">Every 8 hours</option><option value="11">Every 12 hours</option><option value="26">Every 48 hours</option><option value="23">Every 72 hours</option><option value="24">Every 4-6 hours</option><option value="13">Every 2 hours with assistance</option><option value="14">Every 1 week</option><option value="15">Every 2 weeks</option><option value="16">Every 3 weeks</option><option value="25">Every 1 hour with assistance</option><option value="12">Every Other Day</option><option value="27">2 Times Weekly</option><option value="20">3 Times Weekly</option><option value="22">Once a Month</option><option value="18">Nightly</option><option value="19">Every night at bedtime</option><option value="35">Fasting</option><option value="31">Stat</option><option value="32">Now</option></select>';
				var strength_option = '<select style="width:80px;" id="strength'+counter+'" class="frequency" name="NewCropPrescription[strength][]"><option value="">Select</option>'+str_option_value;
				var refills_option = '<select style="width:80px;" id="refills_'+counter+'" class="frequency" name="NewCropPrescription[refills][]"><option value="">Select</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
				var prn_option = '<select style="width:57px;" id="prn'+counter+'" class="" name="NewCropPrescription[prn][]"><option value="0">No</option><option value="1">Yes</option></select>';
				var daw_option = '<select style="width:63px;" id="daw'+counter+'" class="" name="NewCropPrescription[daw][]"><option value="1">Yes</option><option value="0">No</option></select>';
				var active_option = '<select style="width:63px;" id="isactive'+counter+'" class="" name="NewCropPrescription[is_active][]"><option value="1">Yes</option><option value="0">No</option></select>';
				
								var is_adv = '<select id="isadv'+counter+'" class="" name="isadv[]"><option value="0">No</option><option value="1">Yes</option></select>';
								//var route_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
								var options = '<option value=""></option>';
					for (var i = 1; i < 25; i++) {
						if (i < 13) {
							str = i + 'am';
						} else {
							str = (i - 12) + 'pm';
						}
						options += '<option value="'+i+'"'+'>'
								+ str + '</option>';
					}

					timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 67px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timer = timerHtml1 + timerHtml2
							+ timerHtml3 + timerHtml4
							+ '</tr></table></td>';
					<?php //echo $this->Form->input('', array('type'=>'text','size'=>16, 'class'=>'my_start_date','name'=> 'start_date[]', 'id' =>"start_date".$i ,'counter'=>$i )); ?>
					var newHTml = '<td valign="top"><input  type="text" style="width:271px!important;" value="'+drugName+'" id="drugText_' + counter + '" class=" drugText validate[required,custom[onlyLetterNumber]]" name="NewCropPrescription[drug_name][] autocomplete="off" counter='+counter+'>'+
										'<input  type="hidden" class="allHiddenId" id="drug_' + counter + '"  value="'+drugId+'" name="NewCropPrescription[drug_id][]" ><span id="drugType_' + counter + '"></span>&nbsp;<span id="formularylinkId_' + counter + '"></span></td><td valign="top">'
							+ dose_option
							+ '</td><td valign="top">'
							+ dosage_form
							+ '</td><td valign="top">'
							+ route_option
							+ '</td>'
							
							+ '<td valign="top">'
							+ frequency_option
							+ '</td>'
							+ '<td valign="top" ><input size="2" type="text" value="" id="day'+counter+'" class="day" name="NewCropPrescription[day][]" style=""></td>'
							+ '<td valign="top"><input size="2" type="text" value="" id="quantity'+counter+'" class="quantity_'+counter+'" name="NewCropPrescription[quantity][]" style=""></td>'
							+ '<td valign="top">'
							+ refills_option
							+ '</td>'
							+ '<td valign="top" align="center">'
							+ prn_option
							+ '</td>'
							+ '<td valign="top" align="center">'
							+ daw_option
							+ '</td>'
							+ '<td valign="top" align="center"><input  type="text" value="" id="start_date' + counter + '"  class="my_start_date1 textBoxExpnd" name="NewCropPrescription[start_date][]"  size="16" counter='+counter+'></td>'
							+ '<td valign="top" align="center"><input  type="text" value="" id="end_date' + counter + '"  class="my_end_date1 textBoxExpnd" name="NewCropPrescription[end_date][]"  size="16" counter='+counter+'></td>'
							+ '<td valign="top" align="center">'
							+ active_option
							+'</td>'
							+'</td><td width="20" style="padding: 5px 0px 0px 20px;" valign="top"><span class="DrugGroup_history" id=pMH'+counter+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></td>';
							

					//newCostDiv.append(newHTml);
					//newCostDiv.appendTo("#DrugGroup");
					//$("#patientnotesfrm").validationEngine('attach'); 			 			 
					newCostDiv.append(newHTml);		 
					newCostDiv.appendTo("#DrugGroup");		
					//$("#patientnotesfrm").validationEngine('attach'); 	
					
					var attrId="drugText_"+counter;
					var doseId = attrId.replace("drugText_",'dosageform_');
					var routeId = attrId.replace("drugText_",'route_administration');
					//find the DrugType
												$.ajax({

														  url: "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getDrugType", "admin" => false)); ?>"+"/"+drugId.slice(0, -1),
														  dataType: 'html',
														  beforeSend:function(){
														    // this is where we append a loading image
														    $('#busy-indicator').show('fast');
															}, 	
															type: "POST",  
														  		  
														  	success: function(data){
														  		finData=data.split("~~~");

														  		var dosageFrm=<?php echo json_encode(Configure::read('selected_dosageform'));?>;
																var routeFrm=<?php echo json_encode(Configure::read('selected_route'));?>;
																											  		
														  		var drugType='<br/><strong>Drug Type :</strong>'+finData[0];
														  		var newcounter=counter-1;
														  		
									                               $("#drugType_"+newcounter).html(drugType);
									                             //select route and dose
															  		
																	if(routeFrm[finData[2]]!='')
																	   $("#"+routeId).val(routeFrm[finData[2]]);
																																				
																	if(dosageFrm[finData[1]]!='')
																		$("#"+doseId).val(dosageFrm[finData[1]]);
																	
																//end
																	$('#busy-indicator').hide('slow');
														  			
														  	}				  			
														});

												var healthPlanId='<?php echo $healthPlanId?>';
												if(healthPlanId!="0")
												{
													
													var patientId='<?php echo $patientId?>';
													
													
													//get formulary status
														$.ajax({

														  url: "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getFormularyCoverage", "admin" => false)); ?>"+"/"+patientId+"/"+drugId.slice(0, -1)+"/"+healthPlanId,
														  dataType: 'html',
														  beforeSend:function(){
														    // this is where we append a loading image
														    $('#busy-indicator').show('fast');
															}, 	
															type: "POST",  
														  		  
														  	success: function(data){
															  	var linkTxt=data.split("~");
															  	if(linkTxt[0]!="")
														  		{
															  	var newcounter=counter-1;
														  		var formularylink='<br/><strong>Formulary Status : </strong><a title="'+linkTxt[1]+'"><span style="cursor: pointer; cursor: hand" id="collapse_id" onclick="selectAlternateDrug('+patientId+','+drugId.slice(0, -1)+','+healthPlanId+','+newcounter+')">'+linkTxt[0]+'</span></a>';
														  		
									                               $("#formularylinkId_"+newcounter).html(formularylink);
																	
														  		}
															  	$('#busy-indicator').hide('slow');
														  			
														  	}				  			
														});
																								
												   
					                              
												}

												$("#start_date"+ counter).datepicker({
													showOn : 'both',
													changeYear : true,
													changeMonth : true,
													yearRange : '1950',
													buttonText: "Calendar",
													buttonImageOnly : true,
													dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
													minDate:new Date(<?php echo $this->General->minDate(date('Y-m-d')); ?>),
													//minDate:new Date(),
													buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
													onSelect : function() {
														var thisId = $(this).attr('id');
														var thisCounter  = thisId.replace("start_date", ""); 
														var selDate = $(this).val();
														spltDate = selDate.split(' ');
														spltDate[0] = spltDate[0].split('/');
														spltDate[0][1]--;
														spltDate = spltDate[0]+','+spltDate[1];
														$('#end_date'+ thisCounter ).datepicker('option', {
												 			minDate: new Date(spltDate)
													    });
														$(this).focus();
														$('#end_date'+ thisCounter ).val('');
													}
												});
												
												$("#end_date"+counter).datepicker({
													changeMonth : true,
													changeYear : true,
													yearRange : '1950',
													dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
													showOn : 'both',
													buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
													buttonImageOnly : true,
													buttonText: "Calendar",
													onSelect : function() {
														var thisId = $(this).attr('id');
														var thisCounter  = thisId.replace("end_date", ""); 
														if($("#start_date"+ thisCounter == '').val() == '') $(this).val('');
													}
												});				 			 
					counter++;
					if (counter > 0)
						$('#removeButton').show('slow');
				}
							$(document).ready(function(){
								var endDate = $("#start_date0").val();
								spltEndDate = endDate.split(' ');
								spltEndDate[0] = spltEndDate[0].split('/');
								spltEndDate[0][1]--;
								spltEndDate = spltEndDate[0]+','+spltEndDate[1];
								 	$("#start_date0").datepicker({
										showOn : 'both',
										changeYear : true,
										changeMonth : true,
										yearRange : '1950',
										buttonText: "Calendar",
										buttonImageOnly : true,
										dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
										minDate:new Date(<?php echo $this->General->minDate(date('Y-m-d')); ?>),
										buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
										onSelect : function() {
											var selDate = $(this).val();
											spltDate = selDate.split(' ');
											spltDate[0] = spltDate[0].split('/');
											spltDate[0][1]--;
											spltDate = spltDate[0]+','+spltDate[1];
											$('#end_date0').datepicker('option', {
									 			minDate: new Date(spltDate)
										    });
											$("#end_date0").val('');
											$(this).focus();
										}
									});
									
									$("#end_date0").datepicker({
										changeMonth : true,
										changeYear : true,
										yearRange : '1950',
										dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
										showOn : 'both',
										buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
										buttonImageOnly : true,
										buttonText: "Calendar",
										minDate: new Date(spltEndDate),
										onSelect : function() {
											if($("#start_date0").val() == '') $(this).val('');
										}
									});
								
							});
				function closeFormulary()
				{
					$("#formularyData").html("");
				}
				</script>