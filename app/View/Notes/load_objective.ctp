<?php echo $this->Html->script(array('pager')); ?>
<form id="objectData">
<table width="35%" border="0" cellspacing="1" cellpadding="0"
							 style="padding-left: 80px ! important;padding-bottom: 36px;padding-top:10px;  margin-top: 10px;border:1px solid #FFFFFF;" class="tabularForm">
	<tr>
		<td valign="top">		
		 <?php echo $this->Form->input('object',array('type'=>'text','cols'=>'1','rows'=>'1','style'=>'height:27px;'
			 ,'label'=>false,'id'=>'objectDataNew','class'=>'resize-input','div'=>false,'value'=>$putObjData['Note']['object'])); //,'value'=>$getDataFormNote['Note']['subject']?>
		</td>
		<td>
		<td><?php echo $this->Form->input('BmiResult.weight_result',array('style'=>'margin:0 0 0 0;','type'=>'text','id'=>"weight_result1",'value'=>!empty($putPatientData['Patient']['patient_weight'])?$putPatientData['Patient']['patient_weight']:$unserObjWeightData[weight_result],'size'=>"12",'label'=>false,'autocomplete'=>"off",'div'=>false))." "."Kg";?>
		</td>
		<td>
		<?php echo $this->Html->link('Save','javascript:void(0)',array('onclick'=>"updateNote('object')",'class'=>'blueBtn','id'=>'submit'));?>
		</td>
            
		<!-- <h2 style="font-size: 13px; float:left; margin:0px; padding:0px;width: 60px;">Weight:</h2>
		<?php echo $this->Form->input('BmiResult.weight',array('type'=>'text','size'=>"9",'id'=>"weights",'value'=>$unserObjWeightData[weight], 'label'=>false,'div'=>false,'class'=>"bmi htWtDate",'autocomplete'=>"off"));
			?>
			</td>
		<td>
		<?php 				 
		if(empty($unserObjWeightData[weight_volume])){
			echo $this->Form->radio('BmiResult.weight_volume',array('Kg'=>'Kg'),array('default' =>'Kg','class'=>"Weight bmi htWtRadio",'id'=>'type_weight','legend'=>false,'label'=>false ));  ///'Lbs'=>'Lbs',
		}else{
			echo $this->Form->radio('BmiResult.weight_volume',array('Kg'=>'Kg'),array('value'=>$unserObjWeightData[weight_volume],'class'=>"Weight bmi htWtRadio",'id'=>'type_weight','legend'=>false,'label'=>false ));  ///'Lbs'=>'Lbs',
		}?>
		</td>
		<td>		
		<?php echo $this->Form->input('BmiResult.weight_result',array('style'=>'margin:0 0 0 0;','type'=>'text','readonly'=>"readonly",'id'=>"weight_result",'value'=>$unserObjWeightData[weight_result],'size'=>"12",'label'=>false,'class'=>"bmi",'autocomplete'=>"off","tabindex" => "-1"));?>
		</td>
		
	 <td ><?php   echo $this->Html->link($this->Html->image('icons/plus_6.png'),array("controller" => "Notes", "action" => "systemicExamination",$patientId,$noteId),array('escape'=>false,'target'=>'_blank')); 
		//echo $this->Html->image('icons/plus_6.png' , array('onclick'=>'soe()','title'=>'History of presenting illness','style'=>'float:right;padding: 0 0 0 5px;'));?>
		<td>  -->
		 <td id="objectiveDisplay" style="display:<?php echo $displayros; ?>;" valign="top"></td>
		<input type="hidden" name="patientId" value='<?php echo $patientId?>'/>
	                      		<input type="hidden" name="noteId" value='<?php echo $noteId?>'/>
	                      		<input type="hidden" name="appointmentId" value='<?php echo $appointmentId?>'/>
	</tr>
	

	<!-- <tr>
	<td valign="top" colspan="0">	
	</td>
	<td>
	
		<h2 style="font-size: 13px; float:left; margin:0px; padding:0px;width: 60px;">Height:</h2>
		<?php echo $this->Form->input('BmiResult.height',array('type'=>'text','id'=>"height1",'size'=>"9",'value'=>$unserObjWeightData[height], 'autocomplete'=>"off",'label'=>false,'div'=>false,'class'=>"bmi htWtDate"));?>
		</td>
		<td>
		<?php if(empty($unserObjWeightData[height_volume])){
			echo $this->Form->radio('BmiResult.height_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('default'=>'Inches',
				'class'=>"Height bmi htWtRadio",'id'=>'type_height','legend'=>false,'label'=>false,'name'=>'BmiResult[height_volume]'));
		}else{
			echo $this->Form->radio('BmiResult.height_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('value'=>$unserObjWeightData[height_volume],
				'class'=>"Height bmi htWtRadio",'id'=>'type_height','legend'=>false,'label'=>false,'name'=>'BmiResult[height_volume]'));
		}?>
	</td>
		
	<td>
		<?php
		echo $this->Form->input('BmiResult.height_result',array('style'=>'margin:0 0 0 0;','type'=>'text','readonly'=>'readonly','id'=>'height_result','value'=>$unserObjWeightData['height_result'],'size'=>"12",'label'=>false,'class'=>"bmi",'autocomplete'=>"off","tabindex" => "-1"));?>
	</td>
	</tr>
	<tr style="padding-top: 80px ! important;">
	<td>	
	
		<?php //echo __('Your BMI:')?>
		<?php //echo $this->Form->input('BmiResult.bmi',array('type'=>"text",'readonly'=>'readonly','id'=>'bmis', 'value'=>$unserObjWeightData['bmi'],'size'=>"10", 'label'=>false,'div'=>false,'class'=>"bmi","tabindex" => "-1"));?>
	
		<?php //echo __('Kg/m.sq.');?>
		</td>
		<td> -->
	 <!--  For calculating BSA -->
		<?php //echo __('Your BSA:')?>
		<?php //echo $this->Form->input('BmiResult.bsa',array('type'=>"text",'readonly'=>'readonly','id'=>'bsa', 'value'=>$unserObjWeightData['bsa'],'size'=>"10", 'label'=>false,'div'=>false,'class'=>"bmi","tabindex" => "-1"));?>
	
		<?php //echo __('m.sq.');?>
		</td>
	<!-- 	<td> -->
		<?php //echo $this->Form->button('Show BMI',array('type'=>"button",'value'=>"Show BMI",'class'=>"blueBtn",'id'=>'showBmi','label'=>false,'div'=>false ));?>
		
		
	<!--<span id="bmiStatus"></span> -->
		<?php //echo $this->Form->hidden('BmiResult.htWt_date',array('type'=>'text','id'=>"htWtDate",'value'=>$htWt_date,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
		<?php //echo $this->Form->hidden('BmiResult.user_id_hw',array('type'=>'text','id'=>'user_id_hw','value'=>$unserObjWeightData['user_id_hw'],'label'=>false,'style'=>'width:40px'));?>
				
					
		
		
	
		<!-- eof bmi code -->
		<!--bof height code -->
	
<!--</td> -->
	<!-- 	<td>
		</td>
<td valign="top">
		
		<?php echo $this->Html->link('Reset','javascript:void(0)',array(  'class'=>"blueBtn",'id'=>'reset-bmi'  ));?>
	<td>
</tr> -->
</table>
</form>
<script>


$(document).ready(function(){
	

	if($('.painRemove').length > '0'){
		$('#removeButton').show();
	}else{
		$('#removeButton').hide();
	}
	
	equal_value = $('#equal_value').val();
	equal_value1 = $('#equal_value1').val();
	equal_value2 = $('#equal_value2').val();
	
	
		
	$('#reset-bmi').click(function(){
		
		$('.bmi').each(function(){
			/*if ($(this).attr("type") == "radio") {
				$('input[name="data[BmiResult][weight_volume]"][value="Lbs"]').prop('checked', true);
				$('input[name="data[BmiResult][height_volume]"][value="Inches"]').prop('checked', true);
				//$( "input[name=data[BmiResult][weight_volume]]" ).attr('default','Lbs');
			} else {
				$(this).val('');
			}*/
			
			//$(this).val('');  
			
		});
	 
		
		$("#weights,#weight_result,#height1,#bmis,#height_result,#bsa").val('');
		
		$('input[name="data[BmiResult][weight_volume]"][value="Kg"]').prop('checked', true);
		$('input[name="BmiResult[height_volume]"][value="Inches"]').prop('checked', true);
		
		return false  ;
	}); 
		 
	});  	

//$('.IV') .change( function (){
	$(document).on('change','.IV', function() { 
	id = $(this).attr('id');
	currentID = id.split("_")[1] ;
		modified_fLACC_emotion =   ($('#modifiedFLACCEmotion_'+currentID).val()!='')?$('#modifiedFLACCEmotion_'+currentID).val():0;
		modified_fLACC_movement = ($('#modifiedFLACCMovement_'+currentID).val()!='')?$('#modifiedFLACCMovement_'+currentID).val():0; 
		modified_fLACC_verbal_cues = ($('#modifiedFLACCVerbalCues_'+currentID).val()!='')?$('#modifiedFLACCVerbalCues_'+currentID).val():0; 
		modified_fLACC_facial_cues = ($('#modifiedFLACCFacialCues_'+currentID).val()!='')?$('#modifiedFLACCFacialCues_'+currentID).val():0; 
		modified_fLACC_position_guarding = ($('#modifiedFLACCPositionGuarding_'+currentID).val()!='')?$('#modifiedFLACCPositionGuarding_'+currentID).val():0; 
 
		var sum =  parseInt(modified_fLACC_emotion) + parseInt(modified_fLACC_movement) +
		parseInt(modified_fLACC_verbal_cues) + parseInt(modified_fLACC_facial_cues) + parseInt(modified_fLACC_position_guarding);


		$('#modifiedFLACCPainScore_'+currentID).val(sum);
		$('#commonPain_'+currentID).val(sum);
		
	});

  $(window).load(function () {
	if ($('#TypeHeightFeet').is(':checked')) {
		$('#feet_result').show();
	}
  });




function showBmi()
		 { //alert($("input:radio.Weight:checked").val());
		 		//var h = $('#height_result').val();
		 		//var height = h.slice(0, h.lastIndexOf(" "));

		 		/*if(height==0){
			 		alert('Please enter proper height');
			 		//$('#height1').val("");
			 		 $('#feet_result').val("");
			 		  $('#height_result').val("");
			 		  $('.Height').attr('checked', false);
			 		  $('#bmis').val("");
			 			return false;
		 		}*/
		 		
		 		/*if(($('#height_result').val())=="")
		 		 {
		 		 alert('Please Enter Height.');
		 		 return;
		 		 }*/
		 		if(/*($('#height_result').val())==""||*/($('#weights').val())==""||($('#weight_result').val())=="")
		 		 {
		 		 alert('Please Enter Weight.');
		 		 $('#height1').val("");
		 		 $('#height_result').val("");
		 		 return;
		 		 }
		 		
		 		if($("input:radio.Height:checked").val()=="Inches"||$("input:radio.Height:checked").val()=="Cm"||$("input:radio.Height:checked").val()=="Feet")
		 		{
		 		
		 		if($("input:radio.Weight:checked").val()=="Kg")
		 		{
		 			var weight = $('#weights').val();
		 		}
		 		if($("input:radio.Weight:checked").val()=='Lbs')
		 		{	
		 			var w = $('#weight_result').val();
		 			var weight = w.slice(0, w.lastIndexOf(" "));
		 		}

		 		
		 		if($("input:radio.Height:checked").val()=="Cm")
		 		{
		 			var height = $('#height1').val();
		 			
		 		}
		 		if($("input:radio.Height:checked").val()=='Inches')
		 		{	
		 			var h = $('#height_result').val();
			 		var height = h.slice(0, h.lastIndexOf(" "));

		 		}
		 		
		 		height = (height / 100);
		 		weight = weight;
		 		height = (height * height);
		 		//height = (height / 100);
		 		var total = weight / height;
		 		var bsaTotal= weight*height;
		 		total=Math.round((total * 100) / 100);
				bsa = Math.sqrt(bsaTotal)/6;
				bsa = bsa.toFixed(2);
				 if(!isNaN(parseInt(total)) && isFinite(total)){
					$('#bmis').val(total);
					$('#bsa').val(bsa);
				 }
		   
		 		}
		 		else
		 		{
		 			//alert('Please Enter Height.');
		 			 return;
		 			}
		 		
		  }; 


$('.cercumference').click(function ()
{//alert($(this).val());
		//alert($('#head_circumference').val());
		$('#head_result').val($('#head_circumference').val());

		 if(isNaN($('#head_circumference').val())==false){ 
				  if($(this).val()=="Inches")
				  {
				    var val=$('#head_circumference').val();
				    var res=(val/0.3937);
				    res= Math.round(res * 100) / 100;
				    //var result=Math.round(res);
				    $('#head_result').val(res+" Cm");
				  }
				  else 
				  {
				    var val=$('#head_circumference').val();
				    var res1=(val*0.3937);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#head_result').val(res1+" Inches");
				  }
		 }
		 else{
			 
			  alert('Please enter valid head cercumference');
			  $('#head_circumference').val("");
			  $('#head_result').val("");
			  $('.cercumference').attr('checked', false);
				return false;
			}
		 
 });  

$('#head_circumference').keyup(function ()
{//alert($('.cercumference').val());
				//alert($('#head_circumference').val());
				$('#head_result').val($('#head_circumference').val());

				 if(isNaN($('#head_circumference').val())==false){ 
				  if($('.cercumference').val()=="Inches")
				  {
				    var val=$('#head_circumference').val();
				    var res=(val/0.3937);
				    res= Math.round(res * 100) / 100;
				    //var result=Math.round(res);
				    $('#head_result').val(res+" Cm");
				  }
				  else 
				  {
				    var val=$('#head_circumference').val();
				    var res1=(val*0.3937);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#head_result').val(res1+" Inches");
				  }
				 }
				 else{
					 
				  alert('Please enter valid head circumference');
				  $('#head_circumference').val("");
				  $('#head_result').val("");
				//  $('.cercumference').attr('checked', false);
				  $('#type_head').attr('checked', true);
					return false;
					}
				 
});

//chest Circumference calculation
$('.chest_cir').click(function ()
		{//alert($(this).val());
				//alert($('#head_circumference').val());
				$('#chest_result').val($('#chest_circumference').val());

				 if(isNaN($('#chest_circumference').val())==false){ 
						  if($(this).val()=="Inches")
						  {
						    var val=$('#chest_circumference').val();
						    var res=(val/0.3937);
						    res= Math.round(res * 100) / 100;
						    //var result=Math.round(res);
						    $('#chest_result').val(res+" Cm");
						  }
						  else 
						  {
						    var val=$('#chest_circumference').val();
						    var res1=(val*0.3937);
						    res1= Math.round(res1 * 100) / 100;
						    //var result1=Math.round(res);
						    $('#chest_result').val(res1+" Inches");
						  }
				 }
				 else{
					 
					  alert('Please enter valid Chest circumference');
					  $('#chest_circumference').val("");
					  $('#chest_result').val("");
					 // $('.chest_cir').attr('checked', false);
					  $('#type_chest').attr('checked', true);
						return false;
					}
				 
		 });  

		$('#chest_circumference').keyup(function ()
		{//alert($('.cercumference').val());
						//alert($('#head_circumference').val());
						$('#chest_result').val($('#chest_circumference').val());

						 if(isNaN($('#chest_circumference').val())==false){ 
						  if($('.chest_cir').val()=="Inches")
						  {
						    var val=$('#chest_circumference').val();
						    var res=(val/0.3937);
						    res= Math.round(res * 100) / 100;
						    //var result=Math.round(res);
						    $('#chest_result').val(res+" Cm");
						  }
						  else 
						  {
						    var val=$('#chest_circumference').val();
						    var res1=(val*0.3937);
						    res1= Math.round(res1 * 100) / 100;
						    //var result1=Math.round(res);
						    $('#chest_result').val(res1+" Inches");
						  }
						 }
						 else{
							 
						  alert('Please enter valid chest circumference');
						  $('#chest_circumference').val("");
						  $('#chest_result').val("");
						  //$('.chest_cir').attr('checked', false);
						  $('#type_chest').attr('checked', true);
							return false;
							}
						 
		});

//Abdominal Circumference calculation
		$('.abdominal_cir').click(function ()
				{//alert($(this).val());
						//alert($('#head_circumference').val());
						$('#abdominal_result').val($('#abdominal_circumference').val());

						 if(isNaN($('#abdominal_circumference').val())==false){ 
								  if($(this).val()=="Inches")
								  {
								    var val=$('#abdominal_circumference').val();
								    var res=(val/0.3937);
								    res= Math.round(res * 100) / 100;
								    //var result=Math.round(res);
								    $('#abdominal_result').val(res+" Cm");
								  }
								  else 
								  {
								    var val=$('#abdominal_circumference').val();
								    var res1=(val*0.3937);
								    res1= Math.round(res1 * 100) / 100;
								    //var result1=Math.round(res);
								    $('#abdominal_result').val(res1+" Inches");
								  }
						 }
						 else{
							 
							  alert('Please enter valid Abdominal circumference');
							  $('#abdominal_circumference').val("");
							  $('#abdominal_result').val("");
							//  $('.abdominal_cir').attr('checked', false);
							  $('#type_abdominal').attr('checked', true);
								return false;
							}
						 
				 });  

				$('#abdominal_circumference').keyup(function ()
				{//alert($('.cercumference').val());
								//alert($('#head_circumference').val());
								$('#abdominal_result').val($('#abdominal_circumference').val());

								 if(isNaN($('#abdominal_circumference').val())==false){ 
								  if($('.abdominal_cir').val()=="Inches")
								  {
								    var val=$('#abdominal_circumference').val();
								    var res=(val/0.3937);
								    res= Math.round(res * 100) / 100;
								    //var result=Math.round(res);
								    $('#abdominal_result').val(res+" Cm");
								  }
								  else 
								  {
								    var val=$('#abdominal_circumference').val();
								    var res1=(val*0.3937);
								    res1= Math.round(res1 * 100) / 100;
								    //var result1=Math.round(res);
								    $('#abdominal_result').val(res1+" Inches");
								  }
								 }
								 else{
									 
								  alert('Please enter valid Abdominal circumference');
								  $('#abdominal_circumference').val("");
								  $('#abdominal_result').val("");
								//  $('.abdominal_cir').attr('checked', false);
								  $('#type_abdominal').attr('checked', true);
									return false;
									}
								 
				});

$('.waist').click(function ()
	{//alert($(this).val());
			//alert($('#waist_circumference').val());
			$('#waist_result').val($('#waist_circumference').val());
			 if(isNaN($('#waist_circumference').val())==false){  
				  if($(this).val()=="Inches")
				  {
				    var val=$('#waist_circumference').val();
				    var res=(val/0.3937);
				    res= Math.round(res * 100) / 100;
				   // var result=Math.round(res);
				    $('#waist_result').val(res+" Cm");
				  }
				  else 
				  {
				    var val=$('#waist_circumference').val();
				    var res1=(val*0.3937);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#waist_result').val(res1+" Inches");
				  }
			 }
			 else{
				 
				  alert('Please enter valid waist');
				  $('#waist_circumference').val("");
				  $('#waist_result').val("");
				  $('.waist').attr('checked', false);
					return false;
				}
			 
	 });  


$('#waist_circumference').keyup(function ()
{//alert($('.waist').val());
		//alert($('#waist_circumference').val());
		$('#waist_result').val($('#waist_circumference').val());
		 if(isNaN($('#waist_circumference').val())==false){  
			  if($('.waist').val()=="Inches")
			  {
			    var val=$('#waist_circumference').val();
			    var res=(val/0.3937);
			    res= Math.round(res * 100) / 100;
			   // var result=Math.round(res);
			    $('#waist_result').val(res+" Cm");
			  }
			  else 
			  {
			    var val=$('#waist_circumference').val();
			    var res1=(val*0.3937);
			    res1= Math.round(res1 * 100) / 100;
			    //var result1=Math.round(res);
			    $('#waist_result').val(res1+" Inches");
			  }
		 }
		 else{
			 
			  alert('Please enter valid waist');
			  $('#waist_circumference').val("");
			  $('#waist_result').val("");
			  $('.waist').attr('checked', false);
				return false;
			}
 });

$('.temp_source').click(function(){
	$('#user_id').val("<?php echo $this->Session->read('userid');?>");
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#temperature_date').val(NullDate);
});
$('.temp_source1').click(function(){
	$('#user_id1').val("<?php echo $this->Session->read('userid');?>");
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#temperature_date1').val(NullDate);
});
$('.temp_source2').click(function(){
	$('#user_id2').val("<?php echo $this->Session->read('userid');?>");
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#temperature_date2').val(NullDate);
});
$('.heartRateDate').blur(function(){
	
	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#heart_rate_date').val(NullDate);
		$('#user_id_hr').val("<?php echo $this->Session->read('userid');?>");
	}
});
$('.heartRateDate1').blur(function(){
	
	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#heart_rate_date1').val(NullDate);
		$('#user_id_hr1').val("<?php echo $this->Session->read('userid');?>");
	}
});
$('.heartRateDate2').blur(function(){
	
	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#heart_rate_date2').val(NullDate);
		$('#user_id_hr2').val("<?php echo $this->Session->read('userid');?>");
		
	}
});
$('.heartRateDateOption').change(function(){
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#heart_rate_date').val(NullDate);
	$('#user_id_hr').val("<?php echo $this->Session->read('userid');?>");
});
$('.heartRateDateOption1').change(function(){
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#heart_rate_date1').val(NullDate);
	$('#user_id_hr1').val("<?php echo $this->Session->read('userid');?>");
});
$('.heartRateDateOption2').change(function(){
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#heart_rate_date2').val(NullDate);
	$('#user_id_hr2').val("<?php echo $this->Session->read('userid');?>");
});
$('.bpDateTextBox').blur(function(){
	
	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#bp_date').val(NullDate);
	$('#user_id_bp').val("<?php echo $this->Session->read('userid');?>");
	}
});
$('.bpDateTextBox1').blur(function(){
	
	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#bp_date1').val(NullDate);
	$('#user_id_bp1').val("<?php echo $this->Session->read('userid');?>");
	}
});
$('.bpDateTextBox2').blur(function(){
	
	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#bp_date2').val(NullDate);
	$('#user_id_bp2').val("<?php echo $this->Session->read('userid');?>");
	}
});
$('.respiration_volume').change(function(){
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#rr_date').val(NullDate);
	$('#user_id_res').val("<?php echo $this->Session->read('userid');?>");
});
$('.respiration').blur(function(){
	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#rr_date').val(NullDate);
		$('#user_id_res').val("<?php echo $this->Session->read('userid');?>");
	}
});
$('.bpDateOption').change(function(){
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#bp_date').val(NullDate);
	$('#user_id_bp').val("<?php echo $this->Session->read('userid');?>");
});
$('.bpDateOption1').change(function(){
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#bp_date1').val(NullDate);
	$('#user_id_bp1').val("<?php echo $this->Session->read('userid');?>");
});
$('.bpDateOption2').change(function(){
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#bp_date2').val(NullDate);
	$('#user_id_bp2').val("<?php echo $this->Session->read('userid');?>");
});
$('.htWtDate').blur(function(){
	$('#user_id_hw').val("<?php echo $this->Session->read('userid');?>");
	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#htWtDate').val(NullDate);
	}
});
$('.htWtRadio').click(function(){
	$('#user_id_hw').val("<?php echo $this->Session->read('userid');?>");
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#htWtDate').val(NullDate);
});
$('.circumferenceTextBox').blur(function(){
	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#circumference_date').val(NullDate);
		$('#user_id_cir').val("<?php echo $this->Session->read('userid');?>");
	}
});
$('.circumferenceRadio').click(function(){
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#circumference_date').val(NullDate);
	$('#user_id_cir').val("<?php echo $this->Session->read('userid');?>");
});
$('.spoTextBox').blur(function(){
	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#spo_date').val(NullDate);
		$('#user_id_spo').val("<?php echo $this->Session->read('userid');?>");
	}
});
//	$('.num').change(function(){
	$(document).on('change','.num', function() { 
		id = $(this).attr('id');
		currentID = id.split("_")[1] ;
	isPain=$('#spoId_'+currentID+' option:selected').text();
	$('#commonPain_'+currentID).val(isPain);
});
$('.spoOption').change(function(){
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#spo_date').val(NullDate);
	$('#user_id_spo').val("<?php echo $this->Session->read('userid');?>");
});
$('.painPresentRadio').click(function(){
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#pain_date').val(NullDate);
	$('#user_id_pain').val("<?php echo $this->Session->read('userid');?>");
});
$('.painPresentOption').click(function(){
	/*var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	$('#pain_date').val(NullDate);
	$('#user_id_pain').val("<?php // echo $this->Session->read('userid');?>");*/
	if($(this).val() != ""){
		id = $(this).attr('id');
		currentID = id.split("_")[1] ;
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#pain_date_'+currentID).val(NullDate);
		$('#user_id_pain_'+currentID).val("<?php echo $this->Session->read('userid');?>");
	}
});
$('.painPresentTextBox').blur(function(){
	/*if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#pain_date').val(NullDate);
		$('#user_id_pain').val("<?php // echo $this->Session->read('userid');?>");
	}*/
	if($(this).val() != ""){
		id = $(this).attr('id');
		currentID = id.split("_")[1] ;
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#pain_date_'+currentID).val(NullDate);
		$('#user_id_pain_'+currentID).val("<?php echo $this->Session->read('userid');?>");
	}
});



$('.Weight').click(function ()
	{//alert($('.Weight').val());
			 //alert($('#weights').val());
		
			$('#weight_result').val($('#weights').val());

			if(($('#weights').val())=="")
			{
			 alert('Please Enter Weight.');
			 $('#TypeWeightKg').attr('checked', true);
			 return;
			}	
			
			if(isNaN($('#weights').val())==false){
				  if($(this).val()=="Kg")
				  {
				    var val=$('#weights').val();
				    var res=(val*2.2);
				    res= Math.round(res * 100) / 100;
				   // var result=Math.round(res);
				    $('#weight_result').val(res+" Pounds");
				  }
				  else 
				  {
				    var val=$('#weights').val();
				    var res1=(val/2.2);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#weight_result').val(res1+" Kg");
				  }
			}
			else{
				 
				alert('Please enter valid weight');
				  $('#weights').val("");
				  $('#weight_result').val("");
				  $('.Weight').attr('checked', false);
					return false;
			}
			showBmi();
		
	 });  

$('#weights').keyup(function ()
	{//alert($('.Weight').val());
			 //alert($('#weights').val());
		
			$('#weight_result').val($('#weights').val());

			if(($('#weights').val())=="")
			{
			 alert('Please Enter Weight.');
			 //$('.Weight').attr('checked', false);
			 return;
			}	
			
			if(isNaN($('#weights').val())==false){
				  if($('.Weight').val()=="Kg")
				  {
				    var val=$('#weights').val();
				    var res=(val*2.2);
				    res= Math.round(res * 100) / 100;
				   // var result=Math.round(res);
				    $('#weight_result').val(res+" Pounds");
				  }
				  else 
				  {
				    var val=$('#weights').val();
				    var res1=(val/2.2);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#weight_result').val(res1+" Kg");
				  }
			}
			else{
				 
				alert('Please enter valid weight');
				  $('#weights').val("");
				  $('#weight_result').val("");
				 // $('.Weight').attr('checked', false);
					return false;
			}

			showBmi();
	 });

$('#height1').keyup(function ()
{     
	  $('.Height').each(function(){	 
		  if($(this).attr('checked')==true || $(this).attr('checked')=='checked'){   
		    calHeight($(this).attr('id')) ;
	   	  }
	  });
	  showBmi();
});


$("#feet_result").keyup(function ()		{  
	 checkedRadiod  = $(".Height input[type='radio']:checked").val();
	  $('.Height').each(function(){		  
		  if($(this).attr('checked')==true || $(this).attr('checked')=='checked'){ 
		    calHeight($(this).attr('id')) ;
	   	  }
	  }); 
	  showBmi(); 	
});

$('.Height').click(function ()
{  
	 calHeight($(this).attr('id'));
	 showBmi();
}); 

$('#height1').blur(function ()
{  
	 //calHeight($(this).attr('id'));
		    	
});




function calHeight(idStr){	
	if(($('#height1').val())=="")
	{
	 alert('Please Enter Height.');
	 $('#TypeHeightInches').attr('checked', true);
	 $('#height_result').val("");
	 $('#feet_result').val("");
	 $('#bmis').val("");
	 $('#bsa').val("");
	 return;
	}	 
	if(isNaN($('#height1').val())==false){
			
		 $('#height_result').val($('#height1').val());
		  id = "#"+idStr ;
	}
	else{	 
	  alert('Please enter valid height');
	  $('#height1').val("");
	  $('#feet_result').val("");
	  $('#height_result').val("");
	  //$('.Height').attr('checked', false);
	  $('#bmi').val("");
		return false;
	}
	 
	  if($(id).val()=="Inches")
	  {		   
		  $('#feet_inch').hide();
	      var val=$('#height1').val();
	      var res=(val*2.54);
	      res= Math.round(res * 100) / 100;
	      $('#height_result').val(res+" Cm");
	      return res ;
	  }
	 if($(id).val()=="Cm")
	  {  
		$('#feet_inch').hide();
	    var val=$('#height1').val();
	    // var res1=val;
	    var res1=(val*0.3937);
		res1= Math.round(res1 * 100) / 100;
	    //var res1=(val/0.3937);
	   // res1= Math.round(res1 * 100) / 100;
	    //var result1=Math.round(res);
	    $('#height_result').val(res1+" Inches");
	    return res1 ;

	  }
	 if($(id).val()=="Feet")
	  {
		$('#feet_result')//calculate inches
		
		$('#feet_inch').show();
	    var val=$('#height1').val();
	    var res2=(val/0.032808);
	    res2= Math.round(res2 * 100) / 100;
	    var feetInches = $('#feet_result').val();
	    feetInches= Math.round(feetInches * 100) / 100;
        var feetInchesCalc=(feetInches*2.54);
        feetInchesCalc= Math.round(feetInchesCalc * 100) / 100;
	    //var result1=Math.round(res);
	    $('#height_result').val(+(res2+feetInchesCalc).toFixed(2)+" Cm");
	    return res2 ;
	  }

	  if(idStr=='height'){
		   
		 // checkedRadiod  = $('input[name=data[BmiResult][height]]:checked', '#design1').val() ;
		  checkedRadiod  = $(".Height input[type='radio']:checked").val();
		  $('.Height').each(function(){
			  //var id=$('.Height').attr('id');
			  //calHeight(id);
			  if($(this).attr('checked')==true){
			    calHeight($(this).attr('id')) ;
		   	  }
		  }); 
	  }else if(idStr=='feet_result'){ 
		  feetID = $('input[name=height_volume]:checked', '#addVitalFrm').attr('id') ; //checked radio button 
		  $("input[name=height_volume]:radio").each(function () {
				if(this.checked) feetID=this.id;
		  });
		  feetCalc= calHeight(feetID);  
		  feetCalc= Math.round(feetCalc * 100) / 100;
	      var feetInches = $('#feet_result').val();
	      var feetInchesCalc=(feetInches*2.54); 
	      feetInchesCalc= Math.round(feetInchesCalc * 100) / 100; 
	      var total = Math.round(feetCalc+feetInchesCalc) ; 
	      $('#height_result').val(total+" Cm"); 
	  }
}
//eof temp conversion function

/*$('#is_pain').change(function (){
	isPain=$(this).val();
	if(isPain=='yes'){
		$('.faces').show();
		$('.faceScore1').hide();
	}
	
});*/




function test(id){
	option = $('#'+id).val();
	currentID = id.split("_")[1] ;
	if(option==""){
		$('#tools_'+currentID).hide();
		$('.IIV_'+currentID).hide();
		$('#numScore_'+currentID).hide();
		$('.faces_'+currentID).hide();
	}else{
		if(option=='0'){
			$('#tools_'+currentID).show();
		}else if(option=='1'){
			$('#tools_'+currentID).hide();
			$('.IIV_'+currentID).hide();
			$('#numScore_'+currentID).hide();
			$('.faces_'+currentID).hide();
			
		}
	}
}

//test();


//$('.smile').click(function(){
	$(document).on('click','.smile', function() { 
	currentID = $(this).attr('counter');
	score=$(this).attr('id') ; 
	splittedID=score.split('_');
	//alert(splittedID);
	$('#faceScore_'+currentID).val('');
	$('#faceScore2_'+currentID).val(splittedID[1]);
	$('#commonPain_'+currentID).val(splittedID[1]);
	$('#faceScore1_'+currentID).val(splittedID[1]);
	$('#faceScore_'+currentID).val(splittedID[1]);

	if($(this).val() != ""){
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		$('#pain_date_'+currentID).val(NullDate);
		$('#user_id_pain_'+currentID).val("<?php echo $this->Session->read('userid');?>");
	}
	
});


///--------------------------------------Update Complaints --------------------------------------------//
function updateNote(fields){
	var formData = $('#objectData').serialize();
	var weightResult=$('#weight_result1').val();
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "loadObjective",$patientId,$noteId,$appointmentId,"admin" => false)); ?>";
	$.ajax({
		beforeSend : function() {
			$('#busy-indicator').show('fast');
		},
		type: 'POST',
		url: ajaxUrl+'/?type='+fields+'&weightResult='+weightResult,
		data:formData,//"id="+complaints+"&id2="+patientId,
		dataType: 'html',
		success: function(data){
			getSubData();
			$('#busy-indicator').hide('fast');
			 $('#alertMsg').show();
			 $('#alertMsg').html('Physical Examination Saved Successfully.');
			if(weightResult!=''){
			 $('#ShowWeight1').show().html("<b>"+weightResult+" "+"Kg"+"</b>");
			 $('#HideWeight1').hide();
			}
			 $('#alertMsg').fadeOut(5000);
			
	},
	});
 }

function soe(){
	window.location.href="<?php echo $this->Html->url(array("controller" => "Notes", "action" => "systemicExamination",$patientId,$noteId),array('target'=>'_blank')); ?>";
	}
	
	</script>