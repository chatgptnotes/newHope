<style type="text/css">
.title
{
    color: #FFFFFF;
    font-size: 14px;
    margin: 0;
    padding: 0;
    
}
.title1 {
    background: none repeat scroll 0 0 #4C5E64;
}

.date_class {
    float: left;
    padding: 5px 20px 0 0;
}


#header {
	
	min-height: 676px;
	width: 100%;
	 
}
#design {
	
	float: left;
	width: 59%;
	border:1px solid #4C5E64;
	height:729px;
}
#design1 {
	
	float: left;
	width:39%;
	border:1px solid #4C5E64;
	height:727px;
	/*border-left:none;
	padding:1px;*/
}
.ht_ip{width:50px;}
.radio{float:left}{float:left;}
.label

</style>
 
 
<div class="inner_title">
	<h3>
		<?php echo __('Vitals'); ?>
	</h3>
</div>
<?php echo $this->element('patient_information');  ?>
<?php echo $this->Form->create('',array('method'=>'post','type' => 'file','id'=>'vitalFrm','name'=>'vital','inputDefaults' => array('label' => false,'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
 
 echo $this->Form->hidden('BmiResult.id',array());
 
?>
<div class="header" id="header">
  <div class="design" id="design">
  <div style="padding-left:20px;width:97%; margin-bottom:10px;" class="tdLabel"><br/><b>Temperature:</b></div>
  <div style="border-bottom: 1px solid #4C5E64; padding-left:20px">
  
   <table width="100%">
  <tr><td class="tdLabel">
 
  <?php echo __('Enter the degree');?>
  
  <?php echo $this->Form->input('temperature',array('type'=>'text','id'=>"temperature",'class' => 'validate[optional,custom[onlyNumber]]','value'=>$result[BmiResult][temperature],'autocomplete'=>"off",'size'=>"12px",'label'=>false));
  		echo $this->Form->radio('myoption',array('F'=>'Fahrenheit','C'=>'Celsius'),array('value'=>$result[BmiResult][myoption],'class'=>"degree",'id'=>'type_tempreture','legend'=>false,'label'=>false));
	 	echo $this->Form->input('BmiResult.equal_value',array('type'=>'text','id'=>"equal_value",'size'=>"12",'readonly'=>'readonly','value'=>$result[BmiResult][equal_value], 'div'=>false));
	 	?>
   
	 <tr> 
	<td colspan="5" class="tdLabel">
 	<?php echo $this->Form->radio('BmiResult.temp_source', 
 			array('Axillary'=>'Axillary','Central'=>'Central','Oral'=>'Oral','Rectal'=>'Rectal','Tympanic'=>'Tympanic','Temporal'=>'Temporal'),
 			array('value'=>$result[BmiResult][temp_source],'legend'=>false,'label'=>false));?>
 			</td><tr>
  
    </table>
    </div>
    
   	<div style="border-bottom: 1px solid #4C5E64; padding-left:20px" class="tdLabel"><br/>
  	<b>Pulse:</b><br/>
   	<table>
 	<tr><td ><?php echo $this->Form->input('BmiBpResult.pulse_text', 
 			array('name'=>'data[BmiBpResult][0][pulse_text]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','label'=>false,'div'=>false,'id'=>'pulse_supin','autocomplete'=>"off",'value'=>$result[BmiBpResult][0][pulse_text],'size'=>"12"));?></td>
		<td ><?php $supin_options = array(''=>'Please Select','Bigeminy'=>'Bigeminy','Femoral'=>'Femoral','Frequent_premature_beat'=>'Frequent premature beat','Irregular'=>'Irregular','Irregularly_irregular'=>'Irregularly irregular','Occassional_premature_beat'=>'Occassional premature beat','Oral'=>'Oral','Pedal'=>'Pedal','Radial'=>'Radial','Regular'=>'Regular','Trigeminy'=>'Trigeminy');
                                echo $this->Form->input('BmiBpResult.pulse_volume', array('name'=>'data[BmiBpResult][0][pulse_volume]','options'=>$supin_options ,'class' =>'textBoxExpnd','id'=>"pulse_supin_volume",'value'=>$result[BmiBpResult][0][pulse_volume])); ?>
 		</td></tr>
 		
   	<tr><td><?php echo $this->Form->input('BmiBpResult.pulse_text', array('name'=>'data[BmiBpResult][1][pulse_text]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','autocomplete'=>"off",'label'=>false,'div'=>false,'id'=>'pulse_sitting','value'=>$result[BmiBpResult][1][pulse_text],'size'=>"12"));?></td>
		<td><?php $sitting_options = array(''=>'Please Select','Bigeminy'=>'Bigeminy','Femoral'=>'Femoral','Frequent_premature_beat'=>'Frequent premature beat','Irregular'=>'Irregular','Irregularly_irregular'=>'Irregularly irregular','Occassional_premature_beat'=>'Occassional premature beat','Oral'=>'Oral','Pedal'=>'Pedal','Radial'=>'Radial','Regular'=>'Regular','Trigeminy'=>'Trigeminy');
                                echo $this->Form->input('BmiBpResult.pulse_volume', array('name'=>'data[BmiBpResult][1][pulse_volume]','options'=>$sitting_options ,'class' =>'textBoxExpnd','id'=>"pulse_sitting_volume",'value'=>$result[BmiBpResult][1][pulse_volume])); ?>
		</td></tr>
 
  	<tr><td >
    <?php echo $this->Form->input('BmiBpResult.pulse_text',array('name'=>'data[BmiBpResult][2][pulse_text]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','autocomplete'=>"off",'id'=>"pulse_standing",'value'=>$result[BmiBpResult][2][pulse_text], 'label'=>false,'div'=>false,'size'=>"12"));?></td>
 	<td ><?php $standing_options = array(''=>'Please Select','Bigeminy'=>'Bigeminy','Femoral'=>'Femoral','Frequent_premature_beat'=>'Frequent premature beat','Irregular'=>'Irregular','Irregularly_irregular'=>'Irregularly irregular','Occassional_premature_beat'=>'Occassional premature beat','Oral'=>'Oral','Pedal'=>'Pedal','Radial'=>'Radial','Regular'=>'Regular','Trigeminy'=>'Trigeminy');
                                echo $this->Form->input('BmiBpResult.pulse_volume', array('name'=>'data[BmiBpResult][2][pulse_volume]','options'=>$standing_options ,'class' =>'textBoxExpnd','id'=>"pulse_standing_volume",'value'=>$result[BmiBpResult][2][pulse_volume])); ?>
 	</td></tr></table><br/></div>
   
   <div  style="padding-left:20px;border-bottom: 1px solid #4C5E64;" class="tdLabel"><br/>
	<b>Blood Pressure:</b><br/>        
      <table>
      <tr>
      <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][systolic]','class' => 'validate[optional,custom[onlyNumberSp]]','autocomplete'=>"off",'type'=>'text','id'=>"bp_11",'value'=>$result[BmiBpResult][0][systolic],'style'=>"width:40px",'label'=>false, 'div'=>false));?></td>&nbsp;
      <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic]','class' => 'validate[optional,custom[onlyNumberSp]]','autocomplete'=>"off",'type'=>'text','id'=>"bp_12",'value'=>$result[BmiBpResult][0][diastolic],'style'=>"width:40px;",'label'=>false, 'div'=>false));?></td>&nbsp; 
      <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic1]','empty'=>'Please select','options'=>Configure :: read('position'),'value'=>$result[BmiBpResult][0][diastolic1], 'id'=>'position','label'=>false,));?></td>
   	  <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic2]','empty'=>'Please select','options'=>Configure :: read('site1'),'value'=>$result[BmiBpResult][0][diastolic2],'id' => 'site1','label'=>false,));?></td>
	  <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic3]','empty'=>'Please select','options'=>Configure :: read('site2'),'value'=>$result[BmiBpResult][0][diastolic3],'id' => 'site2','label'=>false,));?></td>
      <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][0][diastolic4]','empty'=>'Please select','options'=>Configure :: read('site3'),'style'=>"width:130px;",'value'=>$result[BmiBpResult][0][diastolic4],'id' => 'site2','label'=>false,));?></td>
      </tr>
 
    <tr>
    <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][systolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','autocomplete'=>"off",'id'=>"bp_21",'value'=>$result[BmiBpResult][1][systolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false));?></td>
  	<td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','autocomplete'=>"off",'id'=>"bp_22",'value'=>$result[BmiBpResult][1][diastolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false));?></td>
	 <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic1]','empty'=>'Please select','options'=>Configure :: read('position'),'value'=>$result[BmiBpResult][1][diastolic1],'id'=>'position','selected'=>$strength,'label'=>false,));?></td>
   	 <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic2]','empty'=>'Please select','options'=>Configure :: read('site1'),'value'=>$result[BmiBpResult][1][diastolic2], 'id'=>'site1','label'=>false,));?></td>
	 <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic3]','empty'=>'Please select','options'=>Configure :: read('site2'),'value'=>$result[BmiBpResult][1][diastolic3],'id'=>'site2','label'=>false,));?></td>
    <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][1][diastolic4]','empty'=>'Please select','options'=>Configure :: read('site3'), 'style'=>"width:130px;",'value'=>$result[BmiBpResult][1][diastolic4],'id' => 'site2','label'=>false,));?></td>
    </tr>
    
    
    <tr>
   <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][systolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','autocomplete'=>"off",'id'=>"bp_31",'value'=>$result[BmiBpResult][2][systolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false));?></td>
  	<td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic]','class' => 'validate[optional,custom[onlyNumberSp]]','type'=>'text','autocomplete'=>"off",'id'=>"bp_32",'value'=>$result[BmiBpResult][2][diastolic],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false));?></td>
	 <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic1]','empty'=>'Please select','options'=>Configure :: read('position'),'value'=>$result['BmiBpResult'][2]['diastolic1'],'id'=>'position','selected'=>$strength,'label'=>false,));?></td>
   	 <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic2]','empty'=>'Please select','options'=>Configure :: read('site1'),'value'=>$result[BmiBpResult][2][diastolic2], 'id'=>'site1','label'=>false,));?></td>
	 <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic3]','empty'=>'Please select','options'=>Configure :: read('site2'),'value'=>$result[BmiBpResult][2][diastolic3], 'id'=>'site2','label'=>false,));?></td>
    <td ><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][2][diastolic4]','empty'=>'Please select','options'=>Configure :: read('site3'), 'style'=>"width:130px;",'value'=>$result[BmiBpResult][2][diastolic4],'id' => 'site2','label'=>false,));?></td> 
    </tr>
   
   </table><br/></div>
   <div >
   <table valign="top">
   <tr>
   <td class="tdLabel"><b> <?php echo __('Comment : ',true); ?></b></td>
 	<td><?php  echo $this->Form->input('BmiResult.comment',array('type'=>'text','autocomplete'=>"off",'size'=>"40px",'value'=>$result[BmiResult][comment]));?></td></tr>
   <br />
  <tr><br />
  <td class="tdLabel"><b><?php echo __('Chief Complaint :',true);  ?></b></td>
 <td> <?php  echo $this->Form->input('BmiResult.chief_complaint',array('type'=>'textarea','value'=>$result[BmiResult][chief_complaint], 'size'=>"40px",'rows'=>'5','style'=>"padding-left:12px"));?>
</td></tr> </table><br /></div>
  
 </div>
  <table>
  <div class="design1"  id="design1">
  <div style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tdLabel"><br/>
  <b>Respiration:</b>

    <?php echo $this->Form->input('BmiResult.respiration',array('type'=>'text','autocomplete'=>"off",'class' => 'validate[optional,custom[onlyNumber]]','size'=>"10",'value'=>$result[BmiResult][respiration], 'label'=>false,'div'=>false,'id'=>"respiration",'size'=>"12"));?>
    <?php echo $this->Form->input('BmiResult.respiration_volume', array('options'=>array('empty'=>'Please select',"1"=>"Labored","2"=>"Unlabored"), 'value'=>$result[BmiResult][respiration_volume],'label'=>false,'div'=>false),(array('style'=>"width:150px;", 'label'=>false,'div'=>false)));?>
  	
	<br/><br/>
	</div>
	<!-- bof bmi code -->
	
	<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tdLabel">
		<div class="date_class"><b>Date:</b></div>
		<?php $d= date('m/d/y H:i:s');?>
		<?php $bmiDate = $this->DateFormat->formatDate2Local($result['BmiResult']['date'],Configure::read('date_format'),true); ?>
		<?php 
		if($result['BmiResult']['date']==""){
		?>
		<?php echo $this->Form->input('date', array('type'=>'text','id' =>'date','readonly'=>'readonly','class'=>'textBoxExpnd','value'=>$d,'style'=>'width:150px')); ?>
	    <?php 
	    }else{
	    ?>
	    <?php echo $this->Form->input('date', array('type'=>'text','id' =>'date','readonly'=>'readonly','class'=>'textBoxExpnd','value'=>$bmiDate,'style'=>'width:150px')); ?>
	   <?php }?>
	    <br/><br/>
	</div>

	
 	<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tdLabel"><br/><b>Weight:</b><br /><br/>
	<?php echo $this->Form->input('BmiResult.weight',array('type'=>'text','size'=>"9",'id'=>"weight",'class' => 'bmi validate[optional,custom[onlyNumber]] ','value'=>$result[BmiResult][weight],'autocomplete'=>"off", 'label'=>false,'div'=>false));
	echo $this->Form->radio('BmiResult.weight_volume',array('Kg'=>'Kg','Lbs'=>'Lbs'),array('value'=>$result['BmiResult'][weight_volume],'class'=>"Weight bmi",'id'=>'type_weight','legend'=>false,'label'=>false));?> &nbsp; &nbsp;
	 <?php echo $this->Form->input('BmiResult.weight_result',array('type'=>'text','readonly'=>'readonly','id'=>"weight_result",'value'=>$result[BmiResult][weight_result],'size'=>"12",'label'=>false,'class'=>"bmi"));?>
    
	<br/><br/>
	
  	<b>Height:</b><br /><br/>
	<?php echo $this->Form->input('BmiResult.height',array('type'=>'text','id'=>"height",'class' => 'bmi validate[optional,custom[onlyNumber]] ','size'=>"9",'value'=>$result[BmiResult][height], 'autocomplete'=>"off",'label'=>false,'div'=>false));
		 echo $this->Form->radio('BmiResult.height_volume',array('Inches'=>'Inches','Cm'=>'Cm','Feet'=>'Feet'),array('value'=>$result[BmiResult][height_volume],
		 	'class'=>"Height bmi",'id'=>'type_height','legend'=>false,'label'=>false,'name'=>'height_volume'));?>&nbsp; &nbsp;
		 	<?php if($result[BmiResult][height_volume]!='Feet'){
		echo"<span id='feet_inch' style='display:none;'>" ?>
		<?php echo $this->Form->input('BmiResult.feet_result',array('type'=>'text','id'=>"feet_result",'value'=>$result[BmiResult][feet_result],'size'=>"12",'label'=>false,'class'=>"bmi validate[optional,custom[onlyNumber]]"));echo __('Inches');?><?php echo"</span>" ?><br /><br />
		<?php }else{
			echo"<span id='feet_inch' >" ?>
		<?php echo $this->Form->input('BmiResult.feet_result',array('type'=>'text','id'=>"feet_result",'value'=>$result[BmiResult][feet_result],'size'=>"12",'label'=>false,'class'=>"bmi validate[optional,custom[onlyNumber]]"));echo __('Inches');?><?php echo"</span>" ?><br /><br /><?php }
		echo $this->Form->input('BmiResult.height_result',array('type'=>'text','readonly'=>'readonly','id'=>'height_result','class'=>"bmi",'value'=>$result[BmiResult][height_result],'size'=>"12",'label'=>false));?>
    <br /><br />
	
	<?php echo $this->Form->button('Show BMI',array('type'=>"button",'value'=>"Show BMI",'class'=>"blueBtn",'id'=>'showBmi','label'=>false,'div'=>false ));?>
										
   <?php echo $this->Html->link('Reset','#',array(  'class'=>"blueBtn",'id'=>'reset-bmi'  ));
   	?>&nbsp;&nbsp;<?php echo __('Your BMI:')?>	
	<?php echo $this->Form->input('BmiResult.bmi',array('type'=>"text",'id'=>'bmi','readonly'=>'readonly', 'value'=>$bmiResultRec[0][BmiResult][bmi],'class'=>"bmi",'size'=>"10", 'label'=>false,'div'=>false));?>&nbsp; &nbsp;<?php echo __('Kg/m.sq.');?>
	<span id="bmiStatus"></span>		

<!-- eof bmi code -->
<!--bof height code -->
	<br /><br /></div>

	<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tdLabel">
	<br /><b>Head Circumference:</b><br /><br/>
	<?php echo $this->Form->input('BmiResult.head_circumference',array('type'=>'text','id'=>"head_circumference",'value'=>$result[BmiResult][head_circumference],'size'=>"12",'autocomplete'=>"off",'label'=>false));
	echo $this->Form->radio('BmiResult.head_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('value'=>$result[BmiResult][head_circumference_volume],'class'=>"cercumference",'id'=>'type_head','legend'=>false,'label'=>false));?>&nbsp; &nbsp;<?php
	echo $this->Form->input('BmiResult.head_result',array('type'=>'text','readonly'=>'readonly','id'=>"head_result",'value'=>$result[BmiResult][head_result],'size'=>"12",'label'=>false));?>
    <br /><br /></div>
	
	<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tdLabel">
	<br /><b> Smoking:</b><br /><br/>
	<?php echo $this->Form->input('BmiResult.smoking',array('type'=>'text','readonly'=>'readonly','value'=>$result1['SmokingStatusOncs']['description'],'size'=>"17px",'autocomplete'=>"off",'label'=>false));

	if($result[BmiResult]['smoking_councelling'] == 1){
		echo $this->Form->checkbox('smoking_councelling', array('checked' => 'checked'));
	}else{
		echo $this->Form->checkbox('smoking_councelling');
	}
	
	
	 echo ('Smoking cessation counseling was given.'); ?>
	 
	 <br /><br /></div>

	<div style="border-bottom: 0px solid #4C5E64; padding-left: 20px;padding-bottom:4px;" class="tdLabel">
		<br /><b>Waist Circumference:</b><br /><br/>
		 <?php echo $this->Form->input('BmiResult.waist_circumference',array('type'=>'text','autocomplete'=>"off",'id'=>"waist_circumference",'value'=>$result[BmiResult][waist_circumference],'size'=>"12px",'label'=>false));
		 $options=array('inches'=>'inches','cm'=>'cm');
		 $attributes=array('legend'=>false,'label'=>false);
		 echo $this->Form->radio('BmiResult.waist_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('value'=>$result[BmiResult][waist_circumference_volume],'class'=>"waist",'id'=>'type_waist','legend'=>false,'label'=>false));?>&nbsp; &nbsp;<?php
		 echo $this->Form->input('BmiResult.waist_result',array('type'=>'text','readonly'=>'readonly','id'=>"waist_result",'value'=>$result[BmiResult][waist_result],'size'=>"12",'label'=>false));?>
	    <br /><br />
    </div>
	

</div>
</table>

<table width="100%" >
	<tr>
	<td align="right"><?php echo $this->Form->submit(__('Submit'),array('id'=>'submit','value'=>"Submit",'class'=>'blueBtn','div'=>false));?>
	<?php $cancelBtnUrl =  array('controller'=>'patients','action'=>'patient_information',$patient['Patient']['id']);?>
     <?php  echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false)); ?></td>

	<!--  <td><?php //echo $this->Form->link(__('Help'),(array('type'=>'button','value'=>"Help",'class'=>"blueBtn", 'label'=>false, 'style'=>"width:90px")));?></td></tr>
	 <tr><td>
	
	<?php //echo $this->Form->link(__('Clear'),(array('type'=>'button','value'=>"Clear",'class'=>"blueBtn", 'label'=>false ,'style'=>"width:80px")));?></td>
	
 	<td><?php //echo $this->Form->link(__('Number'),(array('type'=>'button','value'=>"Number",'class'=>"blueBtn", 'label'=>false ,'style'=>"width:80px",'onclick'=>"view_numpad")));?></td>

	 <td><?php //echo $this->Form->link(__('Option'),(array('type'=>'button','value'=>"Option",'class'=>"blueBtn", 'label'=>false ,'style'=>"width:90px")));?></td></tr> -->
		
	</tr>	
</table>

</div> 
<?php echo $this->Form->end(); ?>

<script>
$("#date").datepicker({
	showOn : "button",
	style : "margin-left:50px",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange : '1950',
	dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
	});


$(document).ready(function(){
	 
	
	jQuery("#vitalFrm").validationEngine();

	$('#reset-bmi').click(function(){
		$('.bmi').each(function(){
			if ($(this).attr("type") == "radio") {
				$(this).attr('checked',false);
			} else {
				$(this).val('');
			}
		});
		return false  ;
	});
});

	

 $(window).load(function () {
if ($('#TypeHeightFeet').is(':checked')) {
	$('#feet_result').show();
}});




$('#showBmi').click(function ()
{ //alert($("input:radio.Weight:checked").val());
		var h = $('#height_result').val();
		var height = h.slice(0, h.lastIndexOf(" "));

		if(height==0){
	 		alert('Please enter proper height');
	 		//$('#height').val("");
	 		 $('#feet_result').val("");
	 		  $('#height_result').val("");
	 		  $('.Height').attr('checked', false);
	 		  $('#bmis').val("");
	 			return false;
 		}
		
		if(($('#height_result').val())=="")
		 {
		 alert('Please Enter Height.');
		 return;
		 }
		if(($('#height_result').val())==""||($('#weight').val())==""||($('#weight_result').val())=="")
		 {
		 alert('Please Enter Weight.');
		 return;
		 }
		
		if($("input:radio.Height:checked").val()=="Inches"||$("input:radio.Height:checked").val()=="Cm"||$("input:radio.Height:checked").val()=="Feet")
		{
		//alert($('#weight').val());
		if($("input:radio.Weight:checked").val()=="Kg")
		{
			var weight = $('#weight').val();
		}
		if($("input:radio.Weight:checked").val()=='Lbs')
		{	
			var w = $('#weight_result').val();
			var weight = w.slice(0, w.lastIndexOf(" "));
		}
		
		height = (height / 100);
		weight = weight;
		height = (height * height);
		//height = (height / 100);
		var total = weight / height;

		total=Math.round((total * 100) / 100);
  	$('#bmi').val(total);
		}
		else
		{
			alert('Please Enter Height.');
			 return;
			}
		
 }); 


$('.cercumference').click(function ()
{//alert($(this).val());
		//alert($('#head_circumference').val());
		$('#head_result').val($('#head_circumference').val());
		
		if(isNaN($('#head_circumference').val())==false){
				  if($(this).val()=="Inches")
				  {
				    var val=$('#head_circumference').val();
				    var res=(val*2.54);
				    res= Math.round(res * 100) / 100;
				    //var result=Math.round(res);
				    $('#head_result').val(res+" Cm");
				  }
				  else 
				  {
				    var val=$('#head_circumference').val();
				    var res1=(val*0.39);
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


$('.waist').click(function ()
	{//alert($(this).val());
			//alert($('#waist_circumference').val());
			$('#waist_result').val($('#waist_circumference').val());

			if(isNaN($('#waist_circumference').val())==false){
					  if($(this).val()=="Inches")
					  {
					    var val=$('#waist_circumference').val();
					    var res=(val*2.54);
					    res= Math.round(res * 100) / 100;
					   // var result=Math.round(res);
					    $('#waist_result').val(res+" Cm");
					  }
					  else 
					  {
					    var val=$('#waist_circumference').val();
					    var res1=(val*0.39);
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



$('.degree').click(function ()
	{
		$('#equal_value').val($('#temperature').val());

		if(($('#temperature').val())=="")
		 {
		 alert('Please Enter Tempreture in Degrees.');
		 $('.degree').attr('checked', false);
		 return;
		 }
		
		if(isNaN($('#temperature').val())==false){
			
			if($(this).val()=="F")
			  {
				  var val=$('#temperature').val();
				    var tf=(val);
				    var tc=(5/9)*(tf-32);
				    var res=(tc*Math.pow(10,2))/Math.pow(10,2);
				    res= Math.round(res * 100) / 100;
			    	$('#equal_value').val(res+" C");
			  }
			  else 
			  {
				  var val=$('#temperature').val();
				    var tc=(val);
				    var tf=((9/5)*tc)+32;
				    var res1=(tf*Math.pow(10,2))/Math.pow(10,2);
				    res1= Math.round(res1 * 100) / 100;
				    $('#equal_value').val(res1+" F");
			  }
		}
		else{
		 
		  alert('Please enter valid height');
		  $('#temperature').val("");
		  $('#equal_value').val("");
		  $('.degree').attr('checked', false);
			return false;
		}
});  


$('.Weight').click(function ()
	{//alert($('.Weight').val());
			//alert($('#weight').val());
			$('#weight_result').val($('#weight').val());
			
			if(($('#weight').val())=="")
				 {
				 alert('Please Enter Weight.');
				 $('.Weight').attr('checked', false);
				 return;
			}

			if(isNaN($('#weight').val())==false){
				
				if($(this).val()=="Kg")
				  {
				    var val=$('#weight').val();
				    var res=(val*2.2);
				    res= Math.round(res * 100) / 100;
				   // var result=Math.round(res);
				    $('#weight_result').val(res+" Pounds");
				  }
				  else 
				  {
				    var val=$('#weight').val();
				    var res1=(val/2.2);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#weight_result').val(res1+" Kg");
				  }
			}
			else{
			 
				alert('Please enter valid weight');
				  $('#weight').val("");
				  $('#weight_result').val("");
				  $('.Weight').attr('checked', false);
					return false;
			}
});  


$('.Height').click(function ()
	{  
		 calHeight($(this).attr('id'));
	    	
}); 

$('#height').blur(function ()
{  
			 calHeight($(this).attr('id'));
		    	
});

$("#feet_result").blur(function ()		{  
	 calHeight($(this).attr('id'));   	
});



function calHeight(idStr){


	
	
	if(($('#height').val())=="")
	{
	 alert('Please Enter Height.');
	 $('.Height').attr('checked', false);
	 $('#height_result').val("");
	 return;
	}
	 
	if(isNaN($('#height').val())==false){
			
		 $('#height_result').val($('#height').val());
		  id = "#"+idStr ;
	}
	else{
	 
	  alert('Please enter valid height');
	  $('#height').val("");
	  $('#feet_result').val("");
	  $('#height_result').val("");
	  $('.Height').attr('checked', false);
	  $('#bmi').val("");
		return false;
	}
	 
	  if($(id).val()=="Inches")
	  {
		   
		  $('#feet_inch').hide();
	      var val=$('#height').val();
	      var res=(val*2.54);
	      res= Math.round(res * 100) / 100;
	      $('#height_result').val(res+" Cm");
	      return res ;
	  }
	 if($(id).val()=="Cm")
	  {  
		$('#feet_inch').hide();
	    var val=$('#height').val();
	    var res1=val;
	    res1= Math.round(res1 * 100) / 100;
	    //var result1=Math.round(res);
	    $('#height_result').val(res1+" Cm");
	    return res1 ;
	  }
	 if($(id).val()=="Feet")
	  {
		   
		$('#feet_result')//calculate inches
		
		 
		$('#feet_inch').show();
	    var val=$('#height').val();
	    var res2=(val/0.032808);
	    res2= Math.round(res2 * 100) / 100;
	    var feetInches = $('#feet_result').val();
	    feetInches= Math.round(feetInches * 100) / 100;
	      var feetInchesCalc=(feetInches*2.54);
	      feetInchesCalc= Math.round(feetInchesCalc * 100) / 100;
	    //var result1=Math.round(res);
	     $('#height_result').val(res2+feetInchesCalc+" Cm");
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

		  feetID = $('input[name=height_volume]:checked', '#vitalFrm').attr('id') ; //checked radio button 
		  feetCalc= calHeight(feetID); 
		   
		  feetCalc= Math.round(feetCalc * 100) / 100;
	      var feetInches = $('#feet_result').val();
	      var feetInchesCalc=(feetInches*2.54); 
	      feetInchesCalc= Math.round(feetInchesCalc * 100) / 100;

	      var total = Math.round(feetCalc+feetInchesCalc) ; 
	      $('#height_result').val(total+" Cm"); 
	  }
}

/*function reset_form(){

	//document.getElementById("vitalFrm").reset();
	$("#vitalFrm :input").each(function(){//alert(this.id);
	if(this.id=='weight'||this.id=='weight_result'||this.id=='height'||this.id=='feet_result'||this.id=='height_result'||this.id=='bmi'){
	$(this).val('');
	$('.Weight').attr('checked', false);
	$('.Height').attr('checked', false);
	}
	});
}*/
//eof temp conversion function
 			 
  </script>
  
