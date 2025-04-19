<?php 
	echo $this->Html->css(array('tooltipster.css'));
	echo $this->Html->script(array('jquery.tooltipster.min.js'));
	
	?>
<?php echo $this->Html->script(array('default')); ?>
<style type="text/css">
.title
{
    color: #FFFFFF;
    font-size: 14px;
    margin: 0;
    padding: 0;
    
}
 .light:hover {
	background-color: #F7F6D9;
	text-decoration:none;
	    color: #000000; 
	}
.title1 {
    background: none repeat scroll 0 0 #4C5E64;
}
.pain_sec{float:left;}
.pain_sec select {
    width:175px;
	float:left;
	margin-bottom:10px;

}
.date_class {
    float: left;
    padding: 5px 20px 0 0;
}


#header {
	
	min-height: 630px;
	width: 1400px;
	/*width:98%;*/
	margin:0 auto;
	padding:0 0 0 12px;
	
	 
}
.faces {
    float: left;
	clear:left;
    
}
#design {
	
	float: left;
	width: 49%;
	border:1px solid #4C5E64;
	min-height:630px;
}
#design1 {
	
	float: left;
	width:50%;
	border:1px solid #4C5E64;
	min-height:836px;
	/*border-left:none;
	padding:1px;*/
}
.ht_ip{width:50px;}
.radio{float:left}{float:left;}
.inner_title span {
    float: right;
    margin: -26px 6px !important;
    padding: 0;
}
.pain_score{float:left; width:92%; margin-left:15px;}
</style>
<?php  echo $this->element('patient_information');  ?>
 <?php echo $this->Form->create('',array('method'=>'post','type' => 'file','id'=>'addVitalFrm','name'=>'addVital','inputDefaults' => array('label' => false,'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));?>
<div class="inner_title" >
	<h3 style="font-size:13px; margin-left:22px;">
		<?php  echo __('Vitals'); ?>
	</h3>
	<span><?php $cancelBtnUrl =  array('controller'=>'Diagnoses','action'=>'initialAssessment',$patient_id,$diagnoses_id,$appointmentID);?>
	
     <?php if($soapFlag=='soap'){
     	if(empty($noteIdFlag)){
     	echo $this->Html->link(__('Back'),
		array('controller'=>'Notes','action'=>'soapNote',$patient_id),
		array('class'=>'blueBtn','div'=>false));}
     else{
     	echo $this->Html->link(__('Back'),
		array('controller'=>'Notes','action'=>'soapNote',$patient_id,$noteIdFlag,'appt'=>$appointmentID),
		array('class'=>'blueBtn','div'=>false));
     }
     }else if($returnUrl=='verifyOrderMedication'){
echo $this->Html->link(__('Back'),
		array('controller'=>'Patients','action'=>'verifyOrderMedication',$params1,$params2,$params3,$params4),
		array('class'=>'blueBtn','div'=>false));
}
     	else{
			echo $this->Html->link(__('Back'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false));
		} ?>
		
     <?php 	 echo $this->Form->submit(__('Submit'),array('id'=>'submit','value'=>"Submit",'class'=>'blueBtn','div'=>false,'style'=>'margin-right: 23px;'));?></span>
</div>
  
<p class="ht5"></p>

<?php 
	//	echo $this->element('patient_information');
	 
?>

<?php 
echo $this->Form->hidden('BmiResult.id',array('id'=>'id','value'=>$result1['BmiResult']['id']));
echo $this->Form->hidden('fromSoap',array('id'=>'id','value'=>$soapFlag));
echo $this->Form->hidden('returnUrl',array('id'=>'id','value'=>$returnUrl));
echo $this->Form->hidden('params1',array('id'=>'id','value'=>$params1));
echo $this->Form->hidden('params2',array('id'=>'params2','value'=>$params2));
echo $this->Form->hidden('params3',array('id'=>'params3','value'=>$params3));
echo $this->Form->hidden('params4',array('id'=>'params4','value'=>$params4));
echo $this->Form->hidden('arived_time',array('id'=>'arr_time','value'=>$arr_time));
echo $this->Form->hidden('BmiResult.appointment_id',array('id'=>'id','value'=>$appointmentID));
echo $this->Form->hidden('BmiResult.patientId',array('id'=>'id','value'=>$patient_id));
echo $this->Form->hidden('BmiResult.noteId',array('id'=>'id','value'=>$noteIdFlag));
?>
<div class="header" id="header">
  <div class="design" id="design">
  <div style="padding-left:20px;width:97%; margin-bottom:10px;" class="tdLabel"><br/><b>Temperature:</b>
  <?php echo $this->Html->link(__('Temp Chart'),'#',array('escape'=>false,'id'=>'pres_temp','class'=>'blueBtn','onClick'=>"pres_temp($patient_id)"));
		 	?></br></div>
  <div style="border-bottom: 1px solid #4C5E64;">
  
		<table width="100%">
		<!-- 1 -->
		<?php $tempDate = $this->DateFormat->formatDate2Local($result1['BmiResult']['temperature_date'],Configure::read('date_format'),true);?>
		
		<?php $tempToolTip1 = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id']].'</br><b>Date: </b>'.$tempDate.'</br>'; ?>
		<?php if(!empty($result1['BmiResult']['user_id'])){?>
			<tr class="tooltip light" title="<?php echo $tempToolTip1?>">
		<?php }else{?>
			<tr class="light"">
		<?php }?>
		  		<td class="tdLabel" colspan="3"><?php echo __('Enter the degree: ');
					echo $this->Form->input('BmiResult.temperature',array('type'=>'text','id'=>"temperature",'class' => 'validate[optional,custom[onlyNumber]]','value'=>$result1['BmiResult'][temperature],'size'=>"12px",'label'=>false,'autocomplete'=>"off"));
					if(empty($result1['BmiResult']['myoption'])){
						echo $this->Form->radio('BmiResult.myoption',array('F'=>'Fahrenheit','C'=>'Celsius'),array('default' =>'F','class'=>"degree",'id'=>'type_tempreture','legend'=>false,'label'=>false));
					}else{
						echo $this->Form->radio('BmiResult.myoption',array('F'=>'Fahrenheit','C'=>'Celsius'),array('value'=>$result1['BmiResult']['myoption'],'class'=>"degree",'id'=>'type_tempreture','legend'=>false,'label'=>false));
					}
					?>&nbsp; &nbsp;<?php echo $this->Form->input('BmiResult.equal_value',array('type'=>'text','id'=>"equal_value",'size'=>"12",'readonly'=>'readonly','value'=>$result1['BmiResult'][equal_value], 'div'=>false,'autocomplete'=>"off"));?>
				</td>
				
				<?php echo $this->Form->hidden('BmiResult.temperature_date',array('type'=>'text','id'=>"temperature_date",'value'=>$tempDate,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly'));?>
			</tr>
			<?php if(!empty($result1['BmiResult']['user_id'])){?>
				<tr class="tooltip light" title="<?php echo $tempToolTip1?>">
			<?php }else{?>
				<tr class="light"">
			<?php }?>
				<td colspan="3" class="tdLabel" style="padding-bottom:10px;">
		 			<?php echo $this->Form->radio('BmiResult.temp_source', 
						array('axillary'=>'Axillary','central'=>'Central','oral'=>'Oral','rectal'=>'Rectal','tympanic'=>'Tympanic','temporal'=>'Temporal'),
						array('value'=>$result1['BmiResult']['temp_source'],'legend'=>false,'label'=>false,'class'=>"temp_source"));?>
                        &nbsp; &nbsp;<?php //echo $this->Html->link(__('Temp Chart'),'#',array('escape'=>false,'id'=>'pres_temp','class'=>'blueBtn','onClick'=>"pres_temp($patient_id)"));
		 	?>
		 		<?php echo $this->Form->hidden('BmiResult.user_id',array('type'=>'text','id'=>'user_id','value'=>$result1['BmiResult']['user_id'],'label'=>false,'style'=>'width:40px'));?>
		 		
		 		</td>
		 	</tr>
		 	<!--<tr><td style="padding: 10px;"><?php echo $this->Html->link(__('Temp Chart'),'#',array('escape'=>false,'id'=>'pres_temp','class'=>'blueBtn','onClick'=>"pres_temp($patient_id)"));
		 	?></td></tr>-->
		 	<!-- 2 -->
		 	<?php $tempDate1 = $this->DateFormat->formatDate2Local($result1['BmiResult']['temperature_date1'],Configure::read('date_format'),true);?>
		 	<?php $tempToolTip2 = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id1']].'</br><b>Date: </b>'.$tempDate1.'</br>'; ?>
							
			<?php if(!empty($result1['BmiResult']['user_id1'])){?>
				<tr class="tooltip light" title="<?php echo $tempToolTip2?>">
			<?php }else{?>
				<tr class="light"">
			<?php }?>
		  		<td class="tdLabel" colspan="3"><?php echo __('Enter the degree: ');
					echo $this->Form->input('BmiResult.temperature1',array('type'=>'text','id'=>"temperature1",'class' => 'validate[optional,custom[onlyNumber]]','value'=>$result1['BmiResult']['temperature1'],'size'=>"12px",'label'=>false,'autocomplete'=>"off"));
					if(empty($result1['BmiResult']['myoption1'])){
						echo $this->Form->radio('BmiResult.myoption1',array('F'=>'Fahrenheit','C'=>'Celsius'),array('default' =>'F','class'=>"degree1",'id'=>'type_tempreture1','legend'=>false,'label'=>false));
					}else{
						echo $this->Form->radio('BmiResult.myoption1',array('F'=>'Fahrenheit','C'=>'Celsius'),array('value'=>$result1['BmiResult']['myoption1'],'class'=>"degree1",'id'=>'type_tempreture1','legend'=>false,'label'=>false));
					}
					?>&nbsp; &nbsp;<?php echo $this->Form->input('BmiResult.equal_value1',array('type'=>'text','id'=>"equal_value1",'size'=>"12",'readonly'=>'readonly','value'=>$result1['BmiResult']['equal_value1'], 'div'=>false,'autocomplete'=>"off"));?>
				</td>
				
				<?php echo $this->Form->hidden('BmiResult.temperature_date1',array('type'=>'text','id'=>"temperature_date1",'value'=>$tempDate1,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly'));?>
				
				
			</tr>
			<?php if(!empty($result1['BmiResult']['user_id1'])){?>
				<tr class="tooltip light" title="<?php echo $tempToolTip2?>">
			<?php }else{?>
				<tr class="light"">
			<?php }?>
				<td colspan="3" class="tdLabel" style="padding-bottom:10px;">
		 			<?php echo $this->Form->radio('BmiResult.temp_source1', 
						array('axillary'=>'Axillary','central'=>'Central','oral'=>'Oral','rectal'=>'Rectal','tympanic'=>'Tympanic','temporal'=>'Temporal'),
						array('value'=>$result1['BmiResult']['temp_source1'],'legend'=>false,'label'=>false,'class'=>"temp_source1"));?>
                        &nbsp; &nbsp;<?php //echo $this->Html->link(__('Temp Chart'),'#',array('escape'=>false,'id'=>'pres_temp','class'=>'blueBtn','onClick'=>"pres_temp($patient_id)"));
		 			?>
		 		
		 			<?php echo $this->Form->hidden('BmiResult.user_id1',array('type'=>'text','id'=>'user_id1','value'=>$result1['BmiResult']['user_id1'],'label'=>false,'style'=>'width:40px'));
		 			 ?>
		 		</td>
		 	</tr>
		 	<!-- 3 -->
		 	<?php $tempDate2 = $this->DateFormat->formatDate2Local($result1['BmiResult']['temperature_date2'],Configure::read('date_format'),true);?>
		 	<?php $tempToolTip3 = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id2']].'</br><b>Date: </b>'.$tempDate2.'</br>'; ?>
							
			<?php if(!empty($result1['BmiResult']['user_id2'])){?>
				<tr class="tooltip light" title="<?php echo $tempToolTip3?>">
			<?php }else{?>
				<tr class="light"">
			<?php }?>
		  		<td class="tdLabel" colspan="3"><?php echo __('Enter the degree: ');
					echo $this->Form->input('BmiResult.temperature2',array('type'=>'text','id'=>"temperature2",'class' => 'validate[optional,custom[onlyNumber]]','value'=>$result1['BmiResult']['temperature2'],'size'=>"12px",'label'=>false,'autocomplete'=>"off"));
					if(empty($result1['BmiResult']['myoption2'])){
						echo $this->Form->radio('BmiResult.myoption2',array('F'=>'Fahrenheit','C'=>'Celsius'),array('default' =>'F','class'=>"degree2",'id'=>'type_tempreture2','legend'=>false,'label'=>false));
					}else{
						echo $this->Form->radio('BmiResult.myoption2',array('F'=>'Fahrenheit','C'=>'Celsius'),array('value'=>$result1['BmiResult']['myoption2'],'class'=>"degree2",'id'=>'type_tempreture2','legend'=>false,'label'=>false));
					}
					?>&nbsp; &nbsp;<?php echo $this->Form->input('BmiResult.equal_value2',array('type'=>'text','id'=>"equal_value2",'size'=>"12",'readonly'=>'readonly','value'=>$result1['BmiResult']['equal_value2'], 'div'=>false,'autocomplete'=>"off"));?>
				</td>
				
				<?php echo $this->Form->hidden('BmiResult.temperature_date2',array('type'=>'text','id'=>"temperature_date2",'value'=>$tempDate2,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly'));?>
			
				
			</tr>
			<?php if(!empty($result1['BmiResult']['user_id2'])){?>
				<tr class="tooltip light" title="<?php echo $tempToolTip3?>">
			<?php }else{?>
				<tr class="light"">
			<?php }?>
				<td colspan="3" class="tdLabel" style="padding-bottom:10px;">
		 			<?php echo $this->Form->radio('BmiResult.temp_source2', 
						array('axillary'=>'Axillary','central'=>'Central','oral'=>'Oral','rectal'=>'Rectal','tympanic'=>'Tympanic','temporal'=>'Temporal'),
						array('value'=>$result1['BmiResult']['temp_source2'],'legend'=>false,'label'=>false,'class'=>"temp_source2"));?>
                        &nbsp; &nbsp;
		 		
		 			<?php echo $this->Form->hidden('BmiResult.user_id2',array('type'=>'text','id'=>'user_id2','value'=>$result1['BmiResult']['user_id2'],'label'=>false,'style'=>'width:40px'));?>
		 		</td>
		 	</tr>
		 	
	    </table>
    </div>
    
   	<div style="border-bottom: 1px solid #4C5E64; padding-left:20px; width:96%; padding-bottom:15px; float:left;" class="tdLabel"><br/>
  	<b>Heart Rate:</b> <?php echo $this->Html->link(__('Heart Rate Chart'),'#',array('escape'=>false,'id'=>'pres_pr','class'=>'blueBtn','onClick'=>"pres_pr($patient_id)"));
		 	?><br/>
  	
   	<table>
   	<tr>
	   		<?php $heart_rate_date = $this->DateFormat->formatDate2Local($result1['BmiResult']['heart_rate_date'],Configure::read('date_format'),true);?>
		 	<?php $hrToolTip = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id_hr']].'</br><b>Date: </b>'.$heart_rate_date.'</br>'; ?>
								
				<?php if(!empty($result1['BmiResult']['user_id_hr']) && !empty($result1['BmiBpResult']['pulse_text'])){?>
					<div class="tooltip light" title="<?php echo $hrToolTip?>" style="float:left; width:100%;padding: 15px 0 4px;">
				<?php }else{?>
					<div class="light" style="float:left; width:100%;padding: 15px 0 4px;">
				<?php }?>
        	<div style="float: left;"><?php echo $this->Form->input('BmiBpResult.pulse_text', 
					array('name'=>'data[BmiBpResult][pulse_text]','type'=>'text','class' => 'validate[optional,custom[onlyNumberSp]] heartRateDate','label'=>false,'div'=>false,'id'=>'pulse_supin','value'=>$result1['BmiBpResult']['pulse_text'],'size'=>"12",'autocomplete'=>"off"));?>
                    
                   </div>
			<div style="float: left; margin: 0px 0px 0px 6px; width:167px;"><?php 
			//$supin_options = array('Radial'=>'Radial','Bigeminy'=>'Bigeminy','Femoral'=>'Femoral','Frequent_premature_beat'=>'Frequent premature beat','Irregular'=>'Irregular','Irregularly_irregular'=>'Irregularly irregular','Occassional_premature_beat'=>'Occassional premature beat','Pedal'=>'Pedal','Regular'=>'Regular','Trigeminy'=>'Trigeminy');
			$supin_options=array('Finger tip'=>'Finger tip','Radial'=>'Radial','Carotid'=>'Carotid','Femoral'=>'Femoral','Pedal'=>'Pedal');
							echo $this->Form->input('BmiBpResult.pulse_volume', array('name'=>'data[BmiBpResult][pulse_volume]','options'=>$supin_options ,'class' =>'textBoxExpnd heartRateDateOption','id'=>"pulse_supin_volume",'value'=>$result1['BmiBpResult']['pulse_volume'])); ?>
	 		</div>
	 		<div style="font-size: 13px;float: left; margin: 0px 0px 0px -32px;"><?php echo __('beats per minute')?></div>
            
				<div class="tdLabel" style="padding:0 0 0 20px!important; float:left;"><?php echo $this->Form->hidden('BmiResult.heart_rate_date',array('type'=>'text','id'=>"heart_rate_date",'value'=>$heart_rate_date,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
				</div>&nbsp;&nbsp;
				<!-- provider name  -->
				<?php echo $this->Form->hidden('BmiResult.user_id_hr',array('type'=>'text','id'=>'user_id_hr','value'=>$result1['BmiResult']['user_id_hr'],'label'=>false,'style'=>'width:40px'));
		 			 ?>
                <?php // echo $this->Html->link(__('Pulse Rate Chart'),'#',array('escape'=>false,'id'=>'pres_pr','class'=>'blueBtn','onClick'=>"pres_pr($patient_id)"));
		 	?>
	 		
            
	 	</tr>
 		
   		<tr>
         <?php $heart_rate_date1 = $this->DateFormat->formatDate2Local($result1['BmiResult']['heart_rate_date1'],Configure::read('date_format'),true);?>
		 	<?php $hrToolTip1 = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id_hr1']].'</br><b>Date: </b>'.$heart_rate_date1.'</br>'; ?>
								
				<?php if(!empty($result1['BmiResult']['user_id_hr1']) && !empty($result1['BmiBpResult']['pulse_text1'])){?>
					<div class="tooltip light" title="<?php echo $hrToolTip1?>" style="float:left; width:100%;">
				<?php }else{?>
					<div class="light" style="float:left; width:100%;">
				<?php }?>
        <div style="float: left;"><?php echo $this->Form->input('BmiBpResult.pulse_text1', array('name'=>'data[BmiBpResult][pulse_text1]','type'=>'text','class' => 'validate[optional,custom[onlyNumberSp]] heartRateDate1','label'=>false,'div'=>false,'id'=>'pulse_sitting','value'=>$result1['BmiBpResult']['pulse_text1'],'size'=>"12",'autocomplete'=>"off"));?></div>
			<div style="float: left; margin: 0px 0px 5px 6px; width:167px;"><?php 
			//$sitting_options = array('Radial'=>'Radial','Bigeminy'=>'Bigeminy','Femoral'=>'Femoral','Frequent_premature_beat'=>'Frequent premature beat','Irregular'=>'Irregular','Irregularly_irregular'=>'Irregularly irregular','Occassional_premature_beat'=>'Occassional premature beat','Pedal'=>'Pedal','Regular'=>'Regular','Trigeminy'=>'Trigeminy');
			$sitting_options =array('Finger tip'=>'Finger tip','Radial'=>'Radial','Carotid'=>'Carotid','Femoral'=>'Femoral','Pedal'=>'Pedal');
							echo $this->Form->input('BmiBpResult.pulse_volume1', array('name'=>'data[BmiBpResult][pulse_volume1]','options'=>$sitting_options ,'class' =>'textBoxExpnd heartRateDateOption1','id'=>"pulse_sitting_volume",'value'=>$result1['BmiBpResult']['pulse_volume1'])); ?>
			</div>
			<div style="font-size: 13px;float: left; margin: 0px 0px 0px -32px;"><?php echo __('beats per minute')?></div>
			
				<div class="tdLabel" style="padding:0 0 0 20px!important; float:left;"><?php echo $this->Form->hidden('BmiResult.heart_rate_date1',array('type'=>'text','id'=>"heart_rate_date1",'value'=>$heart_rate_date1,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
				</div>&nbsp;&nbsp;
				<!-- provider name  -->
				<?php echo $this->Form->hidden('BmiResult.user_id_hr1',array('type'=>'text','id'=>'user_id_hr1','value'=>$result1['BmiResult']['user_id_hr1'],'label'=>false,'style'=>'width:40px'));
		 			 ?>
                <?php //echo $this->Html->link(__('Pulse Rate Chart'),'#',array('escape'=>false,'id'=>'pres_pr','class'=>'blueBtn','onClick'=>"pres_pr($patient_id)"));
		 	?>
     
		</tr>
 
  		<tr>
        <?php $heart_rate_date2 = $this->DateFormat->formatDate2Local($result1['BmiResult']['heart_rate_date2'],Configure::read('date_format'),true);?>
		 	<?php $hrToolTip2 = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id_hr2']].'</br><b>Date: </b>'.$heart_rate_date2.'</br>'; ?>
								
				<?php if(!empty($result1['BmiResult']['user_id_hr2']) && !empty($result1['BmiBpResult']['pulse_text2'])){?>
					<div class="tooltip light" title="<?php echo $hrToolTip2?>" style="float:left; width:100%;">
				<?php }else{?>
					<div class="light" style="float:left; width:100%;">
				<?php }?>
        <div style="float: left;"><?php echo $this->Form->input('BmiBpResult.pulse_text2',array('name'=>'data[BmiBpResult][pulse_text2]','type'=>'text','class' => 'validate[optional,custom[onlyNumberSp]] heartRateDate2','id'=>"pulse_standing",'value'=>$result1['BmiBpResult']['pulse_text2'], 'label'=>false,'div'=>false,'size'=>"12",'autocomplete'=>"off"));?></div>
 			<div style="float: left; margin: 0px 0px 0px 6px; width: 167px;"><?php 
 			// $standing_options =array('Radial'=>'Radial','Bigeminy'=>'Bigeminy','Femoral'=>'Femoral','Frequent_premature_beat'=>'Frequent premature beat','Irregular'=>'Irregular','Irregularly_irregular'=>'Irregularly irregular','Occassional_premature_beat'=>'Occassional premature beat','Pedal'=>'Pedal','Regular'=>'Regular','Trigeminy'=>'Trigeminy');
			$standing_options =array('Finger tip'=>'Finger tip','Radial'=>'Radial','Carotid'=>'Carotid','Femoral'=>'Femoral','Pedal'=>'Pedal');	
				echo $this->Form->input('BmiBpResult.pulse_volume2', array('name'=>'data[BmiBpResult][pulse_volume2]','options'=>$standing_options ,'class' =>'textBoxExpnd heartRateDateOption2','id'=>"pulse_standing_volume",'value'=>$result1['BmiBpResult']['pulse_volume2'])); ?>
 			</div>
 			<div style="font-size: 13px;float: left; margin: 0px 0px 0px -32px;"><?php echo __('beats per minute')?></div>
 			<?php $heart_rate_date2 = $this->DateFormat->formatDate2Local($result1['BmiResult']['heart_rate_date2'],Configure::read('date_format'),true);?>
				<div class="tdLabel" style="padding:0 0 0 20px!important; float:left;"><?php echo $this->Form->hidden('BmiResult.heart_rate_date2',array('type'=>'text','id'=>"heart_rate_date2",'value'=>$heart_rate_date2,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
				</div>&nbsp;&nbsp;
				<!-- provider name  -->
				<?php echo $this->Form->hidden('BmiResult.user_id_hr2',array('type'=>'text','id'=>'user_id_hr2','value'=>$result1['BmiResult']['user_id_hr2'],'label'=>false,'style'=>'width:40px'));
		 			 ?>
               
            </div>
            </div>
 		</tr>
        <!--<tr><td style="padding: 10px;"><?php echo $this->Html->link(__('Pulse Rate Chart'),'#',array('escape'=>false,'id'=>'pres_pr','class'=>'blueBtn','onClick'=>"pres_pr($patient_id)"));
		 	?></td></tr>-->
   		
 	</table>
 
   
   <div style="padding-left:20px;border-bottom: 1px solid #4C5E64; width:96%; float:left;" class="blood_presure tdLabel"><br/>
		<b><font color="red">*</font>Blood Pressure:</b>
		<?php echo $this->Html->link(__('BP Chart'),'#',array('escape'=>false,'id'=>'pres_bp','class'=>'blueBtn','onClick'=>"pres_bp($patient_id)"));?>
		<br/>
		<br/>
		
		<table width="100%">

			<?php $bp_date = $this->DateFormat->formatDate2Local($result1['BmiResult']['bp_date'],Configure::read('date_format'),true);?>
		 	<?php $bpToolTip = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id_bp']].'</br><b>Date: </b>'.$bp_date.'</br>'; ?>
							
			<?php if(!empty($result1['BmiResult']['user_id_bp']) && !empty($result1['BmiBpResult']['systolic']) && !empty($result1['BmiBpResult']['diastolic'])){?>
				<tr class="tooltip light" title="<?php echo $bpToolTip?>">
			<?php }else{?>
				<tr class="light"">
			<?php }?>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][systolic]','class' => 'validate[required,custom[onlyNumberSp]] bpDateTextBox bp_11','type'=>'text','id'=>"bp_11",'value'=>$result1['BmiBpResult']['systolic'],'style'=>"width:40px",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][diastolic]','class' => 'validate[required,custom[onlyNumberSp]] bpDateTextBox bp_12','type'=>'text','id'=>"bp_12",'value'=>$result1['BmiBpResult']['diastolic'],'style'=>"width:40px;",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][position]','options'=>Configure :: read('position'),'value'=>$result1['BmiBpResult']['position'], 'id'=>'position','label'=>false,'class'=>'bpDateOption'));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][side]','options'=>Configure :: read('site1'),'value'=>$result1['BmiBpResult']['side'],'id' => 'site1','label'=>false,'class'=>'bpDateOption'));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][up_down]','options'=>Configure :: read('site2'),'value'=>$result1['BmiBpResult']['up_down'],'id' => 'site2','label'=>false,'class'=>'bpDateOption'));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][cuff]','options'=>Configure :: read('site3'),'style'=>"width:130px;",'value'=>$result1['BmiBpResult']['cuff'],'id' => 'site2','label'=>false,'class'=>'bpDateOption'));?>
				</td>
				<td style="font-size: 11px"><?php echo __('mmHg')?></td>
			<?php echo $this->Form->hidden('BmiResult.bp_date',array('type'=>'text','id'=>"bp_date",'value'=>$bp_date,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
			<?php echo $this->Form->hidden('BmiResult.user_id_bp',array('type'=>'text','id'=>'user_id_bp','value'=>$result1['BmiResult']['user_id_bp'],'label'=>false,'style'=>'width:40px'));?>
			</tr>
               
                
			<?php $bp_date1 = $this->DateFormat->formatDate2Local($result1['BmiResult']['bp_date1'],Configure::read('date_format'),true);?>
		 	<?php $bpToolTip1 = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id_bp1']].'</br><b>Date: </b>'.$bp_date1.'</br>'; ?>
							
			<?php if(!empty($result1['BmiResult']['user_id_bp1']) && !empty($result1['BmiBpResult']['systolic1']) && !empty($result1['BmiBpResult']['diastolic1'])){?>
				<tr class="tooltip light" title="<?php echo $bpToolTip1?>">
			<?php }else{?>
				<tr class="light"">
			<?php }?>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][systolic1]','class' => 'validate[optional,custom[onlyNumberSp]] bpDateTextBox1 bp_11','type'=>'text','id'=>"bp_21",'value'=>$result1['BmiBpResult']['systolic1'],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][diastolic1]','class' => 'validate[optional,custom[onlyNumberSp]] bpDateTextBox1 bp_12','type'=>'text','id'=>"bp_22",'value'=>$result1['BmiBpResult']['diastolic1'],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][position1]','options'=>Configure :: read('position'),'value'=>$result1['BmiBpResult']['position1'],'id'=>'position','selected'=>$strength,'label'=>false,'class'=>'bpDateOption1'));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][side1]','options'=>Configure :: read('site1'),'value'=>$result1['BmiBpResult']['side1'], 'id'=>'site1','label'=>false,'class'=>'bpDateOption1'));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][up_down1]','options'=>Configure :: read('site2'),'value'=>$result1['BmiBpResult']['up_down1'],'id'=>'site2','label'=>false,'class'=>'bpDateOption1'));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][cuff]','options'=>Configure :: read('site3'), 'style'=>"width:130px;",'value'=>$result1['BmiBpResult']['cuff1'],'id' => 'site2','label'=>false,'class'=>'bpDateOption1'));?>
				</td>
				<td style="font-size: 11px"><?php echo __('mmHg')?></td>
			<?php echo $this->Form->hidden('BmiResult.bp_date1',array('type'=>'text','id'=>"bp_date1",'value'=>$bp_date1,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
			<?php echo $this->Form->hidden('BmiResult.user_id_bp1',array('type'=>'text','id'=>'user_id_bp1','value'=>$result1['BmiResult']['user_id_bp1'],'label'=>false,'style'=>'width:40px'));
		 			 ?>
			</tr>
	
			<?php $bp_date2 = $this->DateFormat->formatDate2Local($result1['BmiResult']['bp_date2'],Configure::read('date_format'),true);?>
		 	<?php $bpToolTip2 = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id_bp2']].'</br><b>Date: </b>'.$bp_date2.'</br>'; ?>
							
			<?php if(!empty($result1['BmiResult']['user_id_bp2']) && !empty($result1['BmiBpResult']['systolic2']) && !empty($result1['BmiBpResult']['diastolic2'])){?>
				<tr class="tooltip light" title="<?php echo $bpToolTip2?>">
			<?php }else{?>
				<tr class="light">
			<?php }?>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][systolic2]','class' => 'validate[optional,custom[onlyNumberSp]] bpDateTextBox2 bp_11','type'=>'text','id'=>"bp_31",'value'=>$result1['BmiBpResult']['systolic2'],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][diastolic2]','class' => 'validate[optional,custom[onlyNumberSp]] bpDateTextBox2 bp_12','type'=>'text','id'=>"bp_32",'value'=>$result1['BmiBpResult']['diastolic2'],'style'=>"width:40px",'size'=>"12",'label'=>false, 'div'=>false,'autocomplete'=>"off"));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][position2]','options'=>Configure :: read('position'),'value'=>$result1['BmiBpResult']['position2'],'id'=>'position','selected'=>$strength,'label'=>false,'class'=>'bpDateOption2'));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][side2]','options'=>Configure :: read('site1'),'value'=>$result1['BmiBpResult']['side2'], 'id'=>'site1','label'=>false,'class'=>'bpDateOption2'));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][up_down2]','options'=>Configure :: read('site2'),'value'=>$result1['BmiBpResult']['up_down2'], 'id'=>'site2','label'=>false,'class'=>'bpDateOption2'));?>
				</td>
				<td><?php echo $this->Form->input('',array('name'=>'data[BmiBpResult][cuff2]','options'=>Configure :: read('site3'), 'style'=>"width:130px;",'value'=>$result1['BmiBpResult']['cuff2'],'id' => 'site2','label'=>false,'class'=>'bpDateOption2'));?>
				</td>
				<td style="font-size: 11px"><?php echo __('mmHg')?></td>
			</tr>
			<?php echo $this->Form->hidden('BmiResult.bp_date2',array('type'=>'text','id'=>"bp_date2",'value'=>$bp_date2,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
				
				<?php echo $this->Form->hidden('BmiResult.user_id_bp2',array('type'=>'text','id'=>'user_id_bp2','value'=>$result1['BmiResult']['user_id_bp2'],'label'=>false,'style'=>'width:40px'));
		 			 ?>
	
		</table><br/>
	</div>
	
			<?php $htWt_date = $this->DateFormat->formatDate2Local($result1['BmiResult']['htWt_date'],Configure::read('date_format'),true);?>
		 	<?php $hwToolTip = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id_hw']].'</br><b>Date: </b>'.$htWt_date.'</br>'; ?>
					
					<?php //debug($patient);//----Pooja
		if($year >=0 && $year<3)
		{ ?>
		<span style="padding:20px 10px 10px 17px; float:left;"><?php 
			if(strToLower($patient['Person']['sex'])=='female'){
				echo $this->Html->link(__('Length for Age'),'#',array('id'=>'lengthForAgeFemale','escape' => false,'class'=>'blueBtn'));
			}else{
				echo $this->Html->link(__('Length for Age Chart'),'#',array('id'=>'lengthForAgeMale','escape' => false,'class'=>'blueBtn'));
	   		}
	   		?> </span> <span style="padding:20px 10px 10px 0; float:left;"><?php
	   		if(strToLower($patient['Person']['sex'])=='female'){
	   			echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiInfantsWeightForAge','escape' => false,'class'=>'blueBtn'));
	   		}else {
				echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiInfantsWeightForageMale','escape' => false,'class'=>'blueBtn'));
   			}
   			?> </span> <span style="padding:20px 0 10 0; float:left;"><?php
   			if(strToLower($patient['Person']['sex'])=='female'){
   				echo $this->Html->link(__('Weight for Length'),'#',array('id'=>'bmiInfantsWeightForLengthFemale','escape' => false,'class'=>'blueBtn'));
   			} else {
				echo $this->Html->link(__('Weight for Length'),'#',array('id'=>'bmiInfantsWeightForLengthMale','escape' => false,'class'=>'blueBtn'));
   			}?> </span>
		<?php	}
		elseif($year >=2 && $year<=20){ ?>
		<!--  GULLU*********************NEW-->
		<span style="padding:20px 10px 10px 17px; float:left;"><?php 
			if(strToLower($patient['Person']['sex'])=='female')
			{
				//echo $this->Html->link(__('BMI Chart'),array('controller'=>'Persons','action'=>'bmi_chart_female',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
				echo $this->Html->link(__('BMI Chart'),'#',array('id'=>'bmiChartFemale','escape' => false,'class'=>'blueBtn'));
			}else{
				//echo $this->Html->link(__('BMI chart'),array('controller'=>'Persons','action'=>'bmi_chart_male',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
				echo $this->Html->link(__('BMI Chart'),'#',array('id'=>'bmiChartMale','escape' => false,'class'=>'blueBtn'));
			}
			?> </span> 
            <span style="padding:20px 10px 10px 0; float:left;"><?php  if(strToLower($patient['Person']['sex'])=='female')
			{
				//echo $this->Html->link(__('Stature for Age'),array('controller'=>'Persons','action'=>'bmi_statureforage_female',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
				echo $this->Html->link(__('Stature for Age'),'#',array('id'=>'bmiStatureforageFemale','escape' => false,'class'=>'blueBtn'));
			}
			else{
				//echo $this->Html->link(__('Stature for Age'),array('controller'=>'Persons','action'=>'bmi_statureforage_male',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
				echo $this->Html->link(__('Stature for Age'),'#',array('id'=>'bmiStatureforageMale','escape' => false,'class'=>'blueBtn'));
			}
			?> </span>
             <span style="padding:20px 0 10 0; float:left;"><?php
			if(strToLower($patient['Person']['sex'])=='female')
			{
				//echo $this->Html->link(__('Weight for Age'),array('controller'=>'Persons','action'=>'bmi_weightforage_female',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
				echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiWeightforageFemale','escape' => false,'class'=>'blueBtn'));
			}
			else {
					//echo $this->Html->link(__('Weight for Age'),array('controller'=>'Persons','action'=>'bmi_weightforage_male',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
					echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiWeightforageMale','escape' => false,'class'=>'blueBtn'));
			}
			?> </span>
	
		<!--  GULLU*********************NEW-->
		<?php }?>		
			<?php if(!empty($result1['BmiResult']['user_id_hw'])){?>
				<div class="tooltip tdLabel light" title="<?php echo $hwToolTip?>" style="width: 96%; padding-left: 20px; float: left;">
			<?php }else{?>
				<div class="tdLabel light" style="width: 96%; padding-left: 20px; float: left;">
                
			<?php }?>
            
		<h2 style="font-size: 13px; float:left; margin:0px; padding:0px;width: 60px;"><font color="red">*</font>Weight:</h2>
		<?php echo $this->Form->input('BmiResult.weight',array('type'=>'text','size'=>"9",'id'=>"weights",'value'=>$result1['BmiResult'][weight], 'label'=>false,'div'=>false,'class'=>"bmi validate[required,custom[onlyNumber]] htWtDate",'autocomplete'=>"off"));
			
						 
		if(empty($result1['BmiResult'][weight_volume])){
			echo $this->Form->radio('BmiResult.weight_volume',array('Lbs'=>'Lbs','Kg'=>'Kg'),array('default' =>'Lbs','class'=>"Weight bmi htWtRadio",'id'=>'type_weight','legend'=>false,'label'=>false ));
		}else{
			echo $this->Form->radio('BmiResult.weight_volume',array('Lbs'=>'Lbs','Kg'=>'Kg'),array('value'=>$result1['BmiResult'][weight_volume],'class'=>"Weight bmi htWtRadio",'id'=>'type_weight','legend'=>false,'label'=>false ));
		}?>
		&nbsp; &nbsp;
		<?php echo $this->Form->input('BmiResult.weight_result',array('style'=>'margin:0 0 0 46px;','type'=>'text','readonly'=>"readonly",'id'=>"weight_result",'value'=>$result1['BmiResult'][weight_result],'size'=>"12",'label'=>false,'class'=>"bmi",'autocomplete'=>"off","tabindex" => "-1"));?>
	
		<br /> <br /> <h2 style="font-size: 13px; float:left; margin:0px; padding:0px;width: 60px;"><font color="red">*</font>Height:</h2>
		<?php echo $this->Form->input('BmiResult.height',array('type'=>'text','id'=>"height1",'size'=>"9",'value'=>$result1['BmiResult'][height], 'autocomplete'=>"off",'label'=>false,'div'=>false,'class'=>"bmi validate[required,custom[onlyNumber]] htWtDate"));
		if(empty($result1['BmiResult'][height_volume])){
			echo $this->Form->radio('BmiResult.height_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('default'=>'Inches',
				'class'=>"Height bmi htWtRadio",'id'=>'type_height','legend'=>false,'label'=>false,'name'=>'BmiResult[height_volume]'));
		}else{
			echo $this->Form->radio('BmiResult.height_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('value'=>$result1['BmiResult'][height_volume],
				'class'=>"Height bmi htWtRadio",'id'=>'type_height','legend'=>false,'label'=>false,'name'=>'BmiResult[height_volume]'));
		}?>
	
		&nbsp; &nbsp;
		
		<?php /** Feet section is commented as per requirment, Do not remove comment  **/
		/*if($result1['BmiResult']['height_volume'] == 'Feet' || $result1['BmiResult']['height_volume']==''){
			$feetResultDisplay = "" ;
		}else{
			$feetResultDisplay = "display:none" ;
		}
		echo "<span id='feet_inch'  style = ".$feetResultDisplay.">";
		echo $this->Form->input('BmiResult.feet_result',array('type'=>'text','id'=>"feet_result",
				'value'=>$result1['BmiResult'][feet_result],'size'=>"12",'label'=>false,
				'class'=>"bmi validate[optional,custom[onlyNumber]]",'autocomplete'=>"off"));*/?>
		<?php //echo __('inches');?>
		<?php // echo"</span>"?>
		&nbsp;&nbsp;
		<?php
		echo $this->Form->input('BmiResult.height_result',array('style'=>'margin:0 0 0 13px;','type'=>'text','readonly'=>'readonly','id'=>'height_result','value'=>$result1['BmiResult']['height_result'],'size'=>"12",'label'=>false,'class'=>"bmi",'autocomplete'=>"off","tabindex" => "-1"));?>
		<br /> <br />
	
		<?php echo __('Your BMI:')?>
		<?php echo $this->Form->input('BmiResult.bmi',array('type'=>"text",'readonly'=>'readonly','id'=>'bmis', 'value'=>$result1['BmiResult']['bmi'],'size'=>"10", 'label'=>false,'div'=>false,'class'=>"bmi","tabindex" => "-1"));?>
	
		<?php echo __('Kg/m.sq.');?>
		&nbsp;&nbsp; <!--  For calculating BSA -->
		<?php echo __('Your BSA:')?>
		<?php echo $this->Form->input('BmiResult.bsa',array('type'=>"text",'readonly'=>'readonly','id'=>'bsa', 'value'=>$result1['BmiResult']['bsa'],'size'=>"10", 'label'=>false,'div'=>false,'class'=>"bmi","tabindex" => "-1"));?>
	
		<?php echo __('m.sq.');?>&nbsp;&nbsp;
		<?php //echo $this->Form->button('Show BMI',array('type'=>"button",'value'=>"Show BMI",'class'=>"blueBtn",'id'=>'showBmi','label'=>false,'div'=>false ));?>
		<?php echo $this->Html->link('Reset','#',array(  'class'=>"blueBtn",'id'=>'reset-bmi'  ));?>
	
		<br /> <br /> <span id="bmiStatus"></span>
		<?php echo $this->Form->hidden('BmiResult.htWt_date',array('type'=>'text','id'=>"htWtDate",'value'=>$htWt_date,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
		<?php echo $this->Form->hidden('BmiResult.user_id_hw',array('type'=>'text','id'=>'user_id_hw','value'=>$result1['BmiResult']['user_id_hw'],'label'=>false,'style'=>'width:40px'));?>
				
				
		
		<!--<?php //debug($patient);//----Pooja
		/*if($year >=0 && $year<3)
		{ ?>
		<span><?php 
			if(strToLower($patient['Person']['sex'])=='female'){
				echo $this->Html->link(__('Length for Age'),'#',array('id'=>'lengthForAgeFemale','escape' => false,'class'=>'blueBtn'));
			}else{
				echo $this->Html->link(__('Length for Age Chart'),'#',array('id'=>'lengthForAgeMale','escape' => false,'class'=>'blueBtn'));
	   		}
	   		?> </span> <span><?php
	   		if(strToLower($patient['Person']['sex'])=='female'){
	   			echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiInfantsWeightForAge','escape' => false,'class'=>'blueBtn'));
	   		}else {
				echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiInfantsWeightForageMale','escape' => false,'class'=>'blueBtn'));
   			}
   			?> </span> <span><?php
   			if(strToLower($patient['Person']['sex'])=='female'){
   				echo $this->Html->link(__('Weight for Length'),'#',array('id'=>'bmiInfantsWeightForLengthFemale','escape' => false,'class'=>'blueBtn'));
   			} else {
				echo $this->Html->link(__('Weight for Length'),'#',array('id'=>'bmiInfantsWeightForLengthMale','escape' => false,'class'=>'blueBtn'));
   			}?> </span>
		<?php	}
		elseif($year >=2 && $year<=20){ ?>-->
		<!--  GULLU*********************NEW-->
		<!--<span><?php 
			if(strToLower($patient['Person']['sex'])=='female')
			{
				//echo $this->Html->link(__('BMI Chart'),array('controller'=>'Persons','action'=>'bmi_chart_female',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
				echo $this->Html->link(__('BMI Chart'),'#',array('id'=>'bmiChartFemale','escape' => false,'class'=>'blueBtn'));
			}else{
				//echo $this->Html->link(__('BMI chart'),array('controller'=>'Persons','action'=>'bmi_chart_male',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
				echo $this->Html->link(__('BMI Chart'),'#',array('id'=>'bmiChartMale','escape' => false,'class'=>'blueBtn'));
			}
			?> </span> <span><?php  if(strToLower($patient['Person']['sex'])=='female')
			{
				//echo $this->Html->link(__('Stature for Age'),array('controller'=>'Persons','action'=>'bmi_statureforage_female',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
				echo $this->Html->link(__('Stature for Age'),'#',array('id'=>'bmiStatureforageFemale','escape' => false,'class'=>'blueBtn'));
			}
			else{
				//echo $this->Html->link(__('Stature for Age'),array('controller'=>'Persons','action'=>'bmi_statureforage_male',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
				echo $this->Html->link(__('Stature for Age'),'#',array('id'=>'bmiStatureforageMale','escape' => false,'class'=>'blueBtn'));
			}
			?> </span> <span><?php
			if(strToLower($patient['Person']['sex'])=='female')
			{
				//echo $this->Html->link(__('Weight for Age'),array('controller'=>'Persons','action'=>'bmi_weightforage_female',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
				echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiWeightforageFemale','escape' => false,'class'=>'blueBtn'));
			}
			else {
					//echo $this->Html->link(__('Weight for Age'),array('controller'=>'Persons','action'=>'bmi_weightforage_male',$patient['Patient']['person_id']),array('escape' => false,'class'=>'blueBtn'));
					echo $this->Html->link(__('Weight for Age'),'#',array('id'=>'bmiWeightforageMale','escape' => false,'class'=>'blueBtn'));
			}
			?> </span>
            <?php }-->*/ ?>

		<!--  GULLU*********************NEW-->
		
		<br /> <br />
	
		<!-- eof bmi code -->
		<!--bof height code -->
	</div>
</div>
</div>
  <table>
  
 
  <div class="design1"  id="design1">
 			<?php $respirationRateDate = $this->DateFormat->formatDate2Local($result1['BmiResult']['rr_date'],Configure::read('date_format'),true);?>
		 	<?php $rrToolTip = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id_res']].'</br><b>Date: </b>'.$respirationRateDate.'</br>'; ?>
							
			<?php if(!empty($result1['BmiResult']['user_id_res'])){?>
				<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px; padding-bottom:10px;" class="tooltip tdLabel light" title="<?php echo $rrToolTip?>"><br/>
			<?php }else{?>
				<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px; padding-bottom:10px;" class="tdLabel light">
			<?php }?>
  <div style="padding: 10px 0px 20px !important;"><?php echo $this->Html->link(__('Respiration Rate Chart'),'#',array('escape'=>false,'id'=>'pres_pr','class'=>'blueBtn','onClick'=>"pres_rr($patient_id)"));
		 	?></div>
  <b>Respiration Rate:</b>

    <?php echo $this->Form->input('BmiResult.respiration',array('type'=>'text','autocomplete'=>"off",'class' => 'validate[optional,custom[onlyNumber]] respiration','size'=>"10",'value'=>$result1['BmiResult']['respiration'], 'label'=>false,'div'=>false,'id'=>"respiration",'size'=>"12"));?>
    <?php echo $this->Form->input('BmiResult.respiration_volume', array('options'=>array("1"=>"Labored","2"=>"Unlabored"), 'value'=>$result1['BmiResult']['respiration_volume'],'label'=>false,'div'=>false,'class'=>'respiration_volume'),(array('style'=>"width:150px;", 'label'=>false,'div'=>false)));?>
  	breaths per minute &nbsp;&nbsp;
				<!-- provider  -->
	<?php echo $this->Form->hidden('BmiResult.rr_date',array('type'=>'text','id'=>"rr_date",'value'=>$respirationRateDate,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
	<?php echo $this->Form->hidden('BmiResult.user_id_res',array('type'=>'text','id'=>'user_id_res','value'=>$result1['BmiResult']['user_id_res'],'label'=>false,'style'=>'width:40px'));?>
		 			 
				<!--<div style="padding: 10px 0px !important;"><?php echo $this->Html->link(__('Respiration Rate Chart'),'#',array('escape'=>false,'id'=>'pres_pr','class'=>'blueBtn','onClick'=>"pres_rr($patient_id)"));
		 	?></div>-->
	</div>
	<!-- bof bmi code -->
	<!-- 
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
 -->
	<!-- 
 	<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tdLabel"><br/><b>Comment:</b>
	
	<?php  echo $this->Form->input('BmiResult.comment',array('type'=>'text','size'=>"36px",'value'=>$result1['BmiResult'][comment],'autocomplete'=>"off"));?>
  	<br/><br /><b>Chief Complaint:</b><br/>
	
	<?php  echo $this->Form->input('BmiResult.chief_complaint',array('type'=>'textarea','value'=>$result1['BmiResult'][chief_complaint], 'size'=>"41px",'rows'=>'5','style'=>"padding-left:10px; width:271px; margin-top:10px;"));?>
	<br /><br /></div>
	 -->

			<?php $headCircumferenceDate = $this->DateFormat->formatDate2Local($result1['BmiResult']['circumference_date'],Configure::read('date_format'),true);?>
		 	<?php $hcToolTip = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id_cir']].'</br><b>Date: </b>'.$headCircumferenceDate.'</br>'; ?>
							
			<?php if(!empty($result1['BmiResult']['user_id_cir'])){?>
				<div height="20px" style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tooltip tdLabel light" title="<?php echo $hcToolTip?>">
			<?php }else{?>
				<div height="20px" style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tdLabel light">
			<?php }?>
	     <?php 
						if($year >=0 && $year<=3) { ?>
						<span style="float:left; width:97%; margin:10px 0;"><?php 
						if(strToLower($patient['Person']['sex'])=='female')
						{
							echo $this->Html->link(__('Head Circumference Chart'),'#',array('id'=>'bmiInfantsHeadcircumFerenceFemale','escape' => false,'class'=>'blueBtn'));
						}
						else{
		   									echo $this->Html->link(__('Head Circumference Chart'),'#',array('id'=>'bmiInfantsHeadcircumFerenceMale','escape' => false,'class'=>'blueBtn'));
		   								}
		   								?> </span>
						<?php }?>
                       
	<b>Head Circumference:</b>&nbsp;&nbsp;
						<?php echo $this->Form->input('BmiResult.head_circumference',array('type'=>'text','id'=>"head_circumference",'value'=>$result1['BmiResult']['head_circumference'],'size'=>"12",'label'=>false,'class'=>"validate[optional,custom[onlyNumber]] circumferenceTextBox",'autocomplete'=>"off",'style'=>'margin:0 0 3px 38px;'));
						if(empty($result1['BmiResult'][head_circumference_volume])){
								echo $this->Form->radio('BmiResult.head_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('default' =>'Inches','class'=>"cercumference circumferenceRadio",'id'=>'type_head','legend'=>false,'label'=>false));
							}else{
								echo $this->Form->radio('BmiResult.head_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('value'=>$result1['BmiResult']['head_circumference_volume'],'class'=>"cercumference circumferenceRadio",'id'=>'type_head','legend'=>false,'label'=>false));
							}?>
						&nbsp; &nbsp;
						<?php echo $this->Form->input('BmiResult.head_result',array('type'=>'text','readonly'=>'readonly','id'=>"head_result",'value'=>$result1['BmiResult']['head_result'],'size'=>"12",'label'=>false,'autocomplete'=>"off"));?>
						
						<br>
						<b>Chest Circumference:</b>
						&nbsp;&nbsp;
						<?php echo $this->Form->input('BmiResult.chest_circumference',array('type'=>'text','id'=>"chest_circumference",'value'=>$result1['BmiResult']['chest_circumference'],'size'=>"12",'label'=>false,'class'=>"validate[optional,custom[onlyNumber]] circumferenceTextBox",'autocomplete'=>"off",'style'=>'margin:0 0 3px 33px;'));
						if(empty($result1['BmiResult']['chest_circumference_volume'])){
								echo $this->Form->radio('BmiResult.chest_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('default' =>'Inches','class'=>"chest_cir circumferenceRadio",'id'=>'type_chest','legend'=>false,'label'=>false));
							}else{
								echo $this->Form->radio('BmiResult.chest_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('value'=>$result1['BmiResult']['chest_circumference_volume'],'class'=>"chest_cir circumferenceRadio",'id'=>'type_chest','legend'=>false,'label'=>false));
							}?>
						&nbsp; &nbsp;
						<?php echo $this->Form->input('BmiResult.chest_result',array('type'=>'text','readonly'=>'readonly','id'=>"chest_result",'value'=>$result1['BmiResult']['chest_result'],'size'=>"12",'label'=>false,'autocomplete'=>"off"));?>
						
						<br>
						<b>Abdominal Circumference:</b>
						&nbsp;&nbsp;
						<?php echo $this->Form->input('BmiResult.abdominal_circumference',array('type'=>'text','id'=>"abdominal_circumference",'value'=>$result1['BmiResult']['abdominal_circumference'],'size'=>"12",'label'=>false,'class'=>"validate[optional,custom[onlyNumber]] circumferenceTextBox",'autocomplete'=>"off"));
						if(empty($result1['BmiResult']['abdominal_circumference_volume'])){
								echo $this->Form->radio('BmiResult.abdominal_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('default' =>'Inches','class'=>"abdominal_cir circumferenceRadio",'id'=>'type_abdominal','legend'=>false,'label'=>false));
							}else{
								echo $this->Form->radio('BmiResult.abdominal_circumference_volume',array('Inches'=>'Inches','Cm'=>'Cm'),array('value'=>$result1['BmiResult']['abdominal_circumference_volume'],'class'=>"chest_cir circumferenceRadio",'id'=>'type_abdominal','legend'=>false,'label'=>false));
							}?>
						&nbsp; &nbsp;
						<?php echo $this->Form->input('BmiResult.abdominal_result',array('type'=>'text','readonly'=>'readonly','id'=>"abdominal_result",'value'=>$result1['BmiResult']['abdominal_result'],'size'=>"12",'label'=>false,'autocomplete'=>"off"));?>
						<br><br>

						<!--<?php 
						if($year >=0 && $year<=3) { ?>
						<span><?php 
						if(strToLower($patient['Person']['sex'])=='female')
						{
							echo $this->Html->link(__('Head Circumference Chart'),'#',array('id'=>'bmiInfantsHeadcircumFerenceFemale','escape' => false,'class'=>'blueBtn'));
						}
						else{
		   									echo $this->Html->link(__('Head Circumference Chart'),'#',array('id'=>'bmiInfantsHeadcircumFerenceMale','escape' => false,'class'=>'blueBtn'));
		   								}
		   								?> </span>
						<?php }?>-->
    						
				<?php echo $this->Form->hidden('BmiResult.circumference_date',array('type'=>'text','id'=>"circumference_date",'value'=>$headCircumferenceDate,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
				<!-- provider  -->
				<?php echo $this->Form->hidden('BmiResult.user_id_cir',array('type'=>'text','id'=>'user_id_cir','value'=>$result1['BmiResult']['user_id_cir'],'label'=>false,'style'=>'width:40px'));
		 			 ?>
 
    
    </div>
    

	
			<?php $spoDate = $this->DateFormat->formatDate2Local($result1['BmiResult']['spo_date'],Configure::read('date_format'),true);?>
		 	<?php $spoToolTip = '<b>Taken By: </b>'.$userName[$result1['BmiResult']['user_id_spo']].'</br><b>Date: </b>'.$spoDate.'</br>'; ?>
							
			<?php if(!empty($result1['BmiResult']['user_id_spo'])){?>
				<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tooltip tdLabel light" title="<?php echo $spoToolTip?>">
			<?php }else{?>
				<div style="border-bottom: 1px solid #4C5E64; padding-left: 20px" class="tdLabel light">
			<?php }?>
	
			<!-- <br /><b> Smoking:</b><br /><br/>
			<?php echo $this->Form->input('BmiResult.smoking',array('type'=>'text','readonly'=>'readonly','value'=>$result1['SmokingStatusOncs']['description'],'size'=>"17px",'autocomplete'=>"off",'label'=>false));
			if($result[BmiResult]['smoking_councelling'] == 1){
				echo $this->Form->checkbox('smoking_councelling', array('checked' => 'checked'));
			}else{
				echo $this->Form->checkbox('smoking_councelling');
			}
			 echo ('Smoking cessation counseling was given.'); ?>
			 <br /><br /> -->
			
			<div style="padding: 10px 0px 20px 0!important ;" colspan="4"><?php echo $this->Html->link(__('SpO2 Chart'),'#',array('escape'=>false,'id'=>'pres_spo','class'=>'blueBtn','onClick'=>"pres_spo($patient_id)"));?></div>
			 <b>SpO</b><sub>2</sub>:

							<?php echo $this->Form->input('BmiResult.spo',array('type'=>'text','size'=>"10",'value'=>$result1['BmiResult'][spo],'class' => 'spoTextbox', 'label'=>false,'div'=>false,'id'=>"spo",'size'=>"12",'autocomplete'=>"off"));?>
							<?php $optionSPO=array(
									'Room air'=>'Room air',
									'1.0 L/Min Oxygen'=>'1.0 L/Min Oxygen',
									'2.0 L/Min Oxygen'=>'2.0 L/Min Oxygen',
									'3.0 L/Min Oxygen'=>'3.0 L/Min Oxygen',
									'4.0 L/Min Oxygen'=>'4.0 L/Min Oxygen',
									'5.0 L/Min Oxygen'=>'5.0 L/Min Oxygen',
									'6.0 L/Min Oxygen'=>'6.0 L/Min Oxygen',
									'7.0 L/Min Oxygen'=>'7.0 L/Min Oxygen',
									'8.0 L/Min Oxygen'=>'8.0 L/Min Oxygen',
									'9.0 L/Min Oxygen'=>'9.0 L/Min Oxygen',
									'10.0 L/Min Oxygen'=>'10.0 L/Min Oxygen',
									'11.0 L/Min Oxygen'=>'11.0 L/Min Oxygen',
									'12.0 L/Min Oxygen'=>'12.0 L/Min Oxygen',
									'13.0 L/Min Oxygen'=>'13.0 L/Min Oxygen',
									'14.0 L/Min Oxygen'=>'14.0 L/Min Oxygen',
									'15.0 L/Min Oxygen'=>'15.0 L/Min Oxygen',
									
									
						)?>

							<?php echo $this->Form->input('BmiResult.sposelect',array('empty'=>__('Please Select'),'options'=>$optionSPO,'label'=>false ,'id' => 'spo2','value'=>$result1['BmiResult']['sposelect'],'class'=>'spoOption')); ?> %
							
							
					<!-- provider  -->
					<?php echo $this->Form->hidden('BmiResult.spo_date',array('type'=>'text','id'=>"spo_date",'value'=>$spoDate,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
					<?php echo $this->Form->hidden('BmiResult.user_id_spo',array('type'=>'text','id'=>'user_id_spo','value'=>$result1['BmiResult']['user_id_spo'],'label'=>false,'style'=>'width:40px'));?>
			<!--<div style="padding: 10px 0px!important ;" colspan="4"><?php echo $this->Html->link(__('SpO2 Chart'),'#',array('escape'=>false,'id'=>'pres_spo','class'=>'blueBtn','onClick'=>"pres_spo($patient_id)"));?></div>-->
							
	 
	 </div>
	 		
			
					<?php //echo $this->Form->hidden('BmiResult.pain_date',array('type'=>'text','id'=>"pain_date",'value'=>$painPresentDate,'size'=>"20px",'label'=>false,'autocomplete'=>"off",'readonly'=>'readonly','width'=>'20px'));?>
					<?php //echo $this->Form->hidden('BmiResult.user_id_pain',array('type'=>'text','id'=>'user_id_pain','value'=>unserialize($result1['BmiResult']['user_id_pain']),'label'=>false,'style'=>'width:40px'));?>
		 		
					<div style="margin-top:10px;">
					<b class="pain_score">Pain Score:</b>	
                			
					<?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addMore','title'=>'Add'));?>&nbsp;&nbsp;
					<?php echo $this->Html->image('cross.png', array('id'=>'removeButton','title'=>'Remove','style'=>'display:none'));?>
                    
                    </div>	
						
			<?php 
			$painPresent = unserialize($result1['BmiResult']['pain_present']);
			
			$unserializePainDate = explode("&",$result1['BmiResult']['pain_date']);
			$unserializePainUserId = unserialize($result1['BmiResult']['user_id_pain']);
			$unserializePainPresent = unserialize($result1['BmiResult']['pain_present']);
			$unserializeLocation = unserialize($result1['BmiResult']['location']);
			$unserializeLocationOne = unserialize($result1['BmiResult']['location1']);
			$unserializeDuration = unserialize($result1['BmiResult']['duration']);
			$unserializeFrequency = unserialize($result1['BmiResult']['frequency']);
			$unserializePreferred_pain_tool = unserialize($result1['BmiResult']['preferred_pain_tool']);
			$unserializeModified_flacc_emotion = unserialize($result1['BmiResult']['modified_flacc_emotion']);
			$unserializeModified_flacc_movement = unserialize($result1['BmiResult']['modified_flacc_movement']);
			$unserializeModified_flacc_verbal_cues = unserialize($result1['BmiResult']['modified_flacc_verbal_cues']);
			$unserializeModified_flacc_facial_cues = unserialize($result1['BmiResult']['modified_flacc_facial_cues']);
			$unserializeModified_flacc_position_guarding = unserialize($result1['BmiResult']['modified_flacc_position_guarding']);
			$unserializeModified_flacc_pain_score = unserialize($result1['BmiResult']['modified_flacc_pain_score']);
			
			$unserializePain = unserialize($result1['BmiResult']['pain']);
			$unserializeFace_score = unserialize($result1['BmiResult']['face_score']);
			$unserializeCommonPain = unserialize($result1['BmiResult']['common_pain']);
			
			 			
			$cnt  =  (int)count($painPresent) ;
			$scriptCount = $cnt+1;
			echo "<script>  painCounter=".$scriptCount."</script>" ; 
			for($i=1;$i<=$cnt;$i++){
			$x=$i-1;
			//$painPresentDate = $this->DateFormat->formatDate2Local($result1['BmiResult']['pain_date'],Configure::read('date_format'),true);
			$painToolTip = '<b>Taken By: </b>'.$userName[$unserializePainUserId[$x]].'</br><b>Date: </b>'.$unserializePainDate[$x].'</br>';
				
			if(!empty($unserializePainUserId[$x])){?>
			  	<div style="border-bottom: 0px solid #4C5E64; padding-left: 20px;padding-bottom:4px;" class="tooltip tdLabel pain_sec light"  title="<?php echo $painToolTip?>" id="painAdd" >
			<?php }else{?>
			  	<div style="border-bottom: 0px solid #4C5E64; padding-left: 20px;padding-bottom:4px;" class="tdLabel pain_sec light " id="painAdd" >
			<?php }?>
										  
		    <br />
		    <!--Intractive View  -->
            <div class="" style="width:450px; float:left;">
		    <div style="float:left;width: 236px;"><h2 style="font-size: 13px; margin: 0px; padding: 0px; float: left; width: 223px;">Pain Present</h2><span style="float: left;"> : </span></div>
            <div style="float:left;"><?php $painPresent=array('0'=>'Pain Present','1'=>'No Pain'/* ,'2'=>'Yes actual or suspected pain' */);
				echo $this->Form->input('BmiResult.pain_present',array('name'=>'data[BmiResult][pain_present][]','options'=>$painPresent,'empty'=>'Please Select','value'=>$unserializePainPresent[$x],'label'=>false,'id'=>"painPresent_$i",'autocomplete'=>"off",'class'=>'painPresentOption painPresent' ));?></div>
              </div> 
              <br /> <br />
               
					<?php  echo $this->Form->hidden('BmiResult.pain_date',array('name'=>'data[BmiResult][pain_date][]','value'=>$unserializePainDate[$x],'label'=>false,'id'=>"pain_date_$i",'autocomplete'=>"off",'class'=>'' ));?>
					<?php echo $this->Form->hidden('BmiResult.user_id_pain',array('type'=>'text','name'=>'data[BmiResult][user_id_pain][]','value'=>$unserializePainUserId[$x],'label'=>false,'id'=>"user_id_pain_$i",'autocomplete'=>"off",'class'=>'' ));?>
		 			 
	
		    <!-- Location -->
		    <div style="float:left; clear:both">
				 <b style="float:left; width:222px;">Location</b><span style="float: left;margin:0 8px 0 0;"> : </span>
				<?php echo $this->Form->input('BmiResult.location',array('name'=>'data[BmiResult][location][]','options'=>Configure::read('location'),'style'=>"width:175px;",'value'=>$unserializeLocation[$x],'id' => "location_$i",'label'=>false,'class'=>'painPresentOption'));?>
				<?php echo $this->Form->input('BmiResult.location1',array('name'=>'data[BmiResult][location1][]','type'=>'text','size'=>"10",'value'=>$unserializeLocationOne[$x],'class' => 'painPresentTextBox','style'=>'width:173px;margin: 0 0 0 10px;', 'label'=>false,'div'=>false,'id'=>"location1_$i",'size'=>"12",'autocomplete'=>"off"));?>
				<br />
			</div>
			<div style="float:left; clear:both">
				 <b style="float:left; width:222px;">Duration</b><span style="float: left;margin:0 8px 0 0;"> : </span>
		 
				<?php echo $this->Form->input('BmiResult.duration',array('name'=>'data[BmiResult][duration][]','type'=>'text','size'=>"10",'value'=>$unserializeDuration[$x],'class' => 'painPresentTextBox','style'=>'width:173px;', 'label'=>false,'div'=>false,'id'=>"spo_$i",'size'=>"12",'autocomplete'=>"off"));?>
		
				<br />
			</div>
			<div style="float: left; clear:both ">
				<br /> <b style="float:left; width:222px;">Frequency</b><span style="float: left;margin:0 8px 0 0;"> : </span>
		
				<?php echo $this->Form->input('BmiResult.frequency',array('name'=>'data[BmiResult][frequency][]','type'=>'text','size'=>"10",'value'=>$unserializeFrequency[$x],'class' => 'painPresentTextBox','style'=>'width:173px;', 'label'=>false,'div'=>false,'id'=>"frequency_$i",'size'=>"12",'autocomplete'=>"off"));?>
		
				<br /> <br />
			</div><br /> <br />
		    <!--Eof Location  -->
		   
		     <?php if($unserializePainPresent[$x] == '0'){
            		$displayTool='blank';
           		  }else{
					$displayTool='none';
				  }
			?>
		     <div class='tools' id="tools_<?php echo $i ?>" style="width:600px; float:left; display:<?php echo $displayTool ?>;">
		     <div style="float:left;width: 236px;clear:both;" class="clear"><h2 style="font-size: 13px; margin: 0px; padding: 10px 0px 15px 0px; float: left; width: 223px; ">Preferred Pain Tool</h2>
             <span style="float: left;"> : </span></div>
             <div class="" style="float:left;" > <?php $preferredPainTool=array('0'=>'Modified FLACC emotion','1'=>'Score by Number','2'=>'Score by Faces');
				echo $this->Form->input('BmiResult.preferred_pain_tool',array('name'=>'data[BmiResult][preferred_pain_tool][]','options'=>$preferredPainTool,'empty'=>'Please Select','value'=>$unserializePreferred_pain_tool[$x],'label'=>false,'id'=>"preferredPainTool_$i",'autocomplete'=>"off",'class'=>'painPresentOption preferredPainTool'));?></div></div>

           
            <?php if($unserializePreferred_pain_tool[$x] == '0'){
            		$displayFLACC='blank';
           		  }else{
					$displayFLACC='none';
				  }
			?>
            <div class="IIV_<?php echo $i?> clear" style="float:left; width:650px; display:<?php echo $displayFLACC ?>;">
		    <div style="width:600px; float:left" class='IIV_<?php echo $i?>' >
		    <div style="float:left;width: 236px;"><h2 style="font-size: 13px; margin: 0px;padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Emotion</h2><span style="float: left;"> : </span></div>
            <div style="float:left;"> <?php $modifiedFLACCEmotion=array('0'=>'Smiling or Calm','1'=>'Anxious/Irritable','2'=>'Almost in tears or crying');
				echo $this->Form->input('BmiResult.modified_flacc_emotion',array('name'=>'data[BmiResult][modified_flacc_emotion][]','options'=>$modifiedFLACCEmotion,'empty'=>'Please Select','value'=>$unserializeModified_flacc_emotion[$x],'label'=>false,'id'=>"modifiedFLACCEmotion_$i",'autocomplete'=>"off",'class'=>'IV painPresentOption'));?></div></div>
		  
            
            
            <div style="width:600px; float:left" class='IIV_<?php echo $i?>'>
		    <div class="" style="float:left;width: 236px;"><h2 style="font-size: 13px; margin: 0px;padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Movement</h2> <span style="float: left;"> : </span> </div>
			<div style="float:left;"><?php $modifiedFLACCMovement=array('0'=>'Lying quietly or normal position, Moves easily','1'=>'Restless or slow decreased movement','2'=>'immobile, afraid to move or increased agitation');
				echo $this->Form->input('BmiResult.modified_flacc_movement',array('name'=>'data[BmiResult][modified_flacc_movement][]','options'=>$modifiedFLACCMovement,'empty'=>'Please Select','value'=>$unserializeModified_flacc_movement[$x],'label'=>false,'id'=>"modifiedFLACCMovement_$i",'autocomplete'=>"off",'class'=>'IV painPresentOption'));?></div></div>
		   
            
            <div style="width:600px; float:left" class='IIV_<?php echo $i?>'>
		    <div class="" style="float:left;width: 236px;"><h2 style="font-size: 13px; margin: 0px; padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Verbal Cues</h2><span style="float: left;"> : </span> </div>
			<div style="float:left;"><?php $modifiedFLACCVerbalCues=array('0'=>'Quiet','1'=>'Noisy Breathing, Whining or Whimpering','2'=>'Screaming, Crying Out');
				echo $this->Form->input('BmiResult.modified_flacc_verbal_cues',array('name'=>'data[BmiResult][modified_flacc_verbal_cues][]','options'=>$modifiedFLACCVerbalCues,'empty'=>'Please Select','value'=>$unserializeModified_flacc_verbal_cues[$x],'label'=>false,'id'=>"modifiedFLACCVerbalCues_$i",'autocomplete'=>"off",'class'=>'IV painPresentOption'));?></div></div>
		 
            
            <div style="width:600px; float:left" class='IIV_<?php echo $i?>'>
		    <div class="" style="float:left;width: 236px;"><h2 style="font-size: 13px; margin: 0px; padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Facial Cues</h2><span style="float: left;"> : </span> </div>
			<div style="float:left;"><?php $modifiedFLACCFacialCues=array('0'=>'Relaxed, Calm Expression','1'=>'Drawn around mouth and eyes','2'=>'Facial frowning, Wincing');
				echo $this->Form->input('BmiResult.modified_flacc_facial_cues',array('name'=>'data[BmiResult][modified_flacc_facial_cues][]','options'=>$modifiedFLACCFacialCues,'empty'=>'Please Select','value'=>$unserializeModified_flacc_facial_cues[$x],'label'=>false,'id'=>"modifiedFLACCFacialCues_$i",'autocomplete'=>"off",'class'=>'IV painPresentOption'));?></div></div>
		   
            
             <div style="width:600px; float:left" class='IIV_<?php echo $i?>'>
		   <div class="" style="float:left;width: 236px;"><h2 style="font-size: 13px; margin: 0px;padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Position/Guarding</h2><span style="float: left;"> : </span> </div>
		   <div style="float:left;"><?php $modifiedFLACCPositionGuarding=array('0'=>'Relaxed Body','1'=>'Guarding, Tense','2'=>'Fetal Position, Jumps When Touched');
				echo $this->Form->input('BmiResult.modified_flacc_position_guarding',array('name'=>'data[BmiResult][modified_flacc_position_guarding][]','options'=>$modifiedFLACCPositionGuarding,'empty'=>'Please Select','value'=>$unserializeModified_flacc_position_guarding[$x],'label'=>false,'id'=>"modifiedFLACCPositionGuarding_$i",'autocomplete'=>"off",'class'=>'IV painPresentOption'));?></div></div>
	
            
            
            <div style="width:600px; float:left" class='IIV_<?php echo $i?>'>
		    <div class="" style="float:left;width: 236px;"><h2 style="font-size: 13px; margin: 0px; padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Pain Score</h2><span style="float: left;"> : </span> </div>
		    <div style="float:left;"><?php echo $this->Form->input('BmiResult.modified_flacc_pain_score',array('name'=>'data[BmiResult][modified_flacc_pain_score][]','type'=>'text','size'=>"10",'readonly'=>'readonly','class' => '','value'=>$unserializeModified_flacc_pain_score[$x],'label'=>false,'div'=>false,'id'=>"modifiedFLACCPainScore_$i",'size'=>"12",'autocomplete'=>"off"));?></div></div>
		 
		    </div>
		    
		    <!--EOF Intractive View  -->
		   
			<?php if($unserializePreferred_pain_tool[$x] == '1'){
            		$displayPain='blank';
           		  }else{
					$displayPain='none';
				  }
			?>
			  
		     
		    <div id="numScore_<?php echo $i?>" style="display:<?php echo $displayPain ?>;" class='clear'>
		    <b style="float:left; clear:left; width:230px;">Pain :</b>
		    <div style="float:left;width: 236px; clear: both; margin:2px"><h2 style="font-size: 13px; margin: 0px; padding: 0px; float: left; width: 223px;">Select Pain Score</h2><span style="float: left;"> : </span></div>		    
		    
							<?php $optPain=array('0'=>'Not recorded','1'=>'0-No Pain','2'=>'1','3'=>'2','4'=>'3','5'=>'4','6'=>'5','7'=>'6','8'=>'7','9'=>'8','10'=>'9','11'=>'10')?>
							<?php echo $this->Form->input('BmiResult.pain',array('name'=>'data[BmiResult][pain][]','options'=>$optPain,'empty'=>'Please Select','value'=>$unserializePain[$x],'class' => 'painPresentOption num', 'label'=>false,'id'=>"spoId_$i",'autocomplete'=>"off"));?>

							</div>
							
					<?php if($unserializePreferred_pain_tool[$x] == '2'){
								$displayFaces='blank';
						  }else{
								$displayFaces='none';
					 	  }
					  ?>

				<div class="faces_<?php echo $i?> clear" style="display:<?php echo $displayFaces ?>;" >
		    <b style="padding-bottom: 10px; clear: left; float: left;"> Pain Faces:</b>
		    <div class="" id="<?php echo $i?>" style="float: left; clear: left; padding-bottom: 10px;">
		    <?php echo $this->Html->link($this->Html->image('icons/smile_0-1.png',array('id'=>'smile_0-1','counter'=>$i,'class'=>'smile painPresentRadio','title'=>'No Pain (0-1)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp; 
		    <?php echo $this->Html->link($this->Html->image('icons/smile_2-3.png',array('id'=>'smile_2-3','counter'=>$i,'class'=>'smile painPresentRadio','title'=>'Mild Pain (2-3)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp; 
		    <?php echo $this->Html->link($this->Html->image('icons/smile_4-5.png',array('id'=>'smile_4-5','counter'=>$i,'class'=>'smile painPresentRadio','title'=>'Moderate Pain (4-5)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp; 
		    <?php echo $this->Html->link($this->Html->image('icons/smile_6-7.png',array('id'=>'smile_6-7','counter'=>$i,'class'=>'smile painPresentRadio','title'=>'Severe Pain (6-7)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp; 
		    <?php echo $this->Html->link($this->Html->image('icons/smile_8-9.png',array('id'=>'smile_8-9','counter'=>$i,'class'=>'smile painPresentRadio','title'=>'More Than Severe Pain (8-9)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp;
		    <?php echo $this->Html->link($this->Html->image('icons/smile_10-11.png',array('id'=>'smile_10','counter'=>$i,'class'=>'smile painPresentRadio','title'=>'Worst Pain (10)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp; 
		     </div><br><br><br>
		     <b> Your Score</b> : &nbsp; &nbsp;<?php //echo $this->Form->input('BmiResult.face_score',array('type'=>'hidden','id'=>'faceScore','value'=>'','label'=>false,'style'=>'width:40px'));
		     echo $this->Form->input('BmiResult.face_score',array('name'=>'data[BmiResult][face_score][]','type'=>'text','id'=>"faceScore2_$i",'value'=>$unserializeFace_score[$x],'label'=>false,'style'=>'width:40px; margin:17px 0px 0px 6px; float:left;'));?>
		   	  </div>
    </div>
    		<?php  echo $this->Form->hidden('BmiResult.common_pain',array('name'=>'data[BmiResult][common_pain][]','type'=>'text','counter'=>$i,'id'=>"commonPain_$i",'value'=>$unserializeCommonPain[$x],'label'=>false,'style'=>'width:40px'));?>
   <?php }?>
    		
	
</div>
</div>
</table>

<table width="100%" >
	<tr>
	<td align="right">
	<?php $cancelBtnUrl =  array('controller'=>'Diagnoses','action'=>'initialAssessment',$patient_id,$diagnoses_id,$appointmentID);?>
     <?php // if($soapFlag!='soap')echo $this->Html->link(__('Back'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false)); ?>
     <?php if($soapFlag=='soap'){
     	if(empty($noteIdFlag)){
     	echo $this->Html->link(__('Back'),
		array('controller'=>'Notes','action'=>'soapNote',$patient_id),
		array('class'=>'blueBtn','div'=>false));}
     else{
     	echo $this->Html->link(__('Back'),
		array('controller'=>'Notes','action'=>'soapNote',$patient_id,$noteIdFlag),
		array('class'=>'blueBtn','div'=>false));
     }
     }else if($returnUrl=='verifyOrderMedication'){
echo $this->Html->link(__('Back'),
		array('controller'=>'Patients','action'=>'verifyOrderMedication',$params1,$params2,$params3,$params4),
		array('class'=>'blueBtn','div'=>false));
}
     	else{
			echo $this->Html->link(__('Back'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false));
		}?>
     <?php echo $this->Form->submit(__('Submit'),array('id'=>'submit','value'=>"Submit",'class'=>'blueBtn','div'=>false,'style'=>'margin-right: 23px;'));?></td>

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
$("#date_vital").datepicker({
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

	if($('.painRemove').length > '0'){
		$('#removeButton').show();
	}else{
		$('#removeButton').hide();
	}
	
	$('.tooltip').tooltipster({
 		interactive:true,
 		position:"right",
 	});
	equal_value = $('#equal_value').val();
	equal_value1 = $('#equal_value1').val();
	equal_value2 = $('#equal_value2').val();
	
	$("#addVitalFrm").validationEngine();
	var status='<?php echo $close?>';
	if(status=='1'){
		parent.$.fancybox.close();
	}
	$('#submit').click(function() { 
		var validatePerson = jQuery("#addVitalFrm").validationEngine('validate');
		if (validatePerson) {$(this).css('display', 'none');
		return true;}
		else{
		return false;
		}
		});
		
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
		
		$('input[name="data[BmiResult][weight_volume]"][value="Lbs"]').prop('checked', true);
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

	$('.bp_11').blur(function(){
		var systolic = $(this).val(); 
		if(systolic > 400){
			alert('Systolic can not be higher than 400');
			$(this).val("");
		}
		//diastolic1();
	})
	
	$('.bp_12').blur(function(){
			currentId = parseInt($(this).attr('id').split('_')[1]) ;
			secID = "bp_"+(currentId-1) ; 
			 
			var systolic =   parseInt($('#'+secID).val());
			var diastolic  = parseInt($(this).val()); 
			 
			if(diastolic > 350 ){
				alert('Diastolic can not be higher than 350');
				$(this).val("");
			}
			if(diastolic > systolic ){
				alert('Diastolic can not be higher than systolic');
				$(this).val("");
			}
			
		});
	
	$('#temperature').blur(function ()
	{
		$('#user_id').val("<?php echo $this->Session->read('userid');?>");
	}); 
	$('#temperature1').blur(function ()
			{
				$('#user_id1').val("<?php echo $this->Session->read('userid');?>");
			}); 
	$('#temperature2').blur(function ()
			{
				$('#user_id2').val("<?php echo $this->Session->read('userid');?>");
			}); 
		
$('.degree').click(function ()
{	
	
	$('#user_id').val("<?php echo $this->Session->read('userid');?>");
	$('#equal_value').val($('#temperature').val());
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	
	if(($('#equal_value').val())!= equal_value){
		$('#temperature_date').val(NullDate);
	}
		 if(($('#temperature').val())=="")
			 {
			 alert('Please Enter Temperature in Degrees.');
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
			  alert('Please enter valid temprature');
			  $('#temperature').val("");
			  $('#equal_value').val("");
			//  $('.degree').attr('checked', false);
			  $('#type_tempreture').attr('checked', true);
				return false;
			}
});  
// 2

$('.degree1').click(function ()
{	
	$('#user_id1').val("<?php echo $this->Session->read('userid');?>");
	$('#equal_value1').val($('#temperature1').val());
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	
	if(($('#equal_value1').val())!= equal_value1){
		$('#temperature_date1').val(NullDate);
	}
		 if(($('#temperature1').val())=="")
			 {
			 alert('Please Enter Temperature in Degrees.');
			 return;
			 }
		 if(isNaN($('#temperature1').val())==false){
				
		  if($(this).val()=="F")
		  {
			  var val=$('#temperature1').val();
			    var tf=(val);
			    var tc=(5/9)*(tf-32);
			    var res=(tc*Math.pow(10,2))/Math.pow(10,2);
			    res= Math.round(res * 100) / 100;
		    	$('#equal_value1').val(res+" C");
		  }
		  else 
		  {
			  var val=$('#temperature1').val();
			    var tc=(val);
			    var tf=((9/5)*tc)+32;
			    var res1=(tf*Math.pow(10,2))/Math.pow(10,2);
			    res1= Math.round(res1 * 100) / 100;
			    $('#equal_value1').val(res1+" F");
		  }
		 }
		 else{
			  alert('Please enter valid temprature');
			  $('#temperature1').val("");
			  $('#equal_value1').val("");
			 // $('.degree1').attr('checked', false);
			  $('#type_tempreture1').attr('checked', true);
				return false;
			}
});   
//3

$('.degree2').click(function ()
{	
	$('#user_id2').val("<?php echo $this->Session->read('userid');?>");
	$('#equal_value2').val($('#temperature2').val());
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	
	if(($('#equal_value2').val())!= equal_value2){
		$('#temperature_date2').val(NullDate);
	}
		 if(($('#temperature2').val())=="")
			 {
			 alert('Please Enter Temperature in Degrees.');
			 return;
			 }
		 if(isNaN($('#temperature2').val())==false){
				
		  if($(this).val()=="F")
		  {
			  var val=$('#temperature2').val();
			    var tf=(val);
			    var tc=(5/9)*(tf-32);
			    var res=(tc*Math.pow(10,2))/Math.pow(10,2);
			    res= Math.round(res * 100) / 100;
		    	$('#equal_value2').val(res+" C");
		  }
		  else 
		  {
			  var val=$('#temperature2').val();
			    var tc=(val);
			    var tf=((9/5)*tc)+32;
			    var res1=(tf*Math.pow(10,2))/Math.pow(10,2);
			    res1= Math.round(res1 * 100) / 100;
			    $('#equal_value2').val(res1+" F");
		  }
		 }
		 else{
			  alert('Please enter valid temprature');
			  $('#temperature2').val("");
			  $('#equal_value2').val("");
			//  $('.degree2').attr('checked', false);
			  $('#type_tempreture2').attr('checked', true);
				return false;
			}
});   


$('#temperature').keyup(function ()
	{

	$('#equal_value').val($('#temperature').val());
	var fullDate = new Date();
	var NullDate =(fullDate.format('d/m/Y H:i:s'));
	
	if(($('#equal_value').val())!= equal_value){
		$('#temperature_date').val(NullDate);
	}
		$('#equal_value').val($('#temperature').val());
	 if(($('#temperature').val())=="")
		 {
		 alert('Please Enter Temperature in Degrees.');
		 return;
		 }
	 if(isNaN($('#temperature').val())==false){
			
	  if($('.degree').val()=="F")
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
		 
		  alert('Please enter valid temprature');
		  $('#temperature').val("");
		  $('#equal_value').val("");
		 // $('.degree').attr('checked', false);
		 $('#type_tempreture').attr('checked', true);
			return false;
		}
		  
});
$('#temperature1').keyup(function ()
		{

		$('#equal_value1').val($('#temperature1').val());
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		
		if(($('#equal_value1').val())!= equal_value){
			$('#temperature_date1').val(NullDate);
		}
			$('#equal_value1').val($('#temperature1').val());
		 if(($('#temperature1').val())=="")
			 {
			 alert('Please Enter Temperature in Degrees.');
			 return;
			 }
		 if(isNaN($('#temperature1').val())==false){
				
		  if($('.degree1').val()=="F")
		  {
			  var val=$('#temperature1').val();
			    var tf=(val);
			    var tc=(5/9)*(tf-32);
			    var res=(tc*Math.pow(10,2))/Math.pow(10,2);
			    res= Math.round(res * 100) / 100;
		    	$('#equal_value1').val(res+" C");
		  }
		  else 
		  {
			  var val=$('#temperature1').val();
			    var tc=(val);
			    var tf=((9/5)*tc)+32;
			    var res1=(tf*Math.pow(10,2))/Math.pow(10,2);
			    res1= Math.round(res1 * 100) / 100;
			    $('#equal_value1').val(res1+" F");
		  }
		 }
		 else{
			 
			  alert('Please enter valid temprature');
			  $('#temperature1').val("");
			  $('#equal_value1').val("");
			 // $('.degree1').attr('checked', false);
			 $('#type_tempreture1').attr('checked', true);
				return false;
			}
			  
	});


$('#temperature2').keyup(function ()
		{

		$('#equal_value2').val($('#temperature2').val());
		var fullDate = new Date();
		var NullDate =(fullDate.format('d/m/Y H:i:s'));
		
		if(($('#equal_value2').val())!= equal_value){
			$('#temperature_date2').val(NullDate);
		}
			$('#equal_value2').val($('#temperature2').val());
		 if(($('#temperature2').val())=="")
			 {
			 alert('Please Enter Temperature in Degrees.');
			 return;
			 }
		 if(isNaN($('#temperature2').val())==false){
				
		  if($('.degree2').val()=="F")
		  {
			  var val=$('#temperature2').val();
			    var tf=(val);
			    var tc=(5/9)*(tf-32);
			    var res=(tc*Math.pow(10,2))/Math.pow(10,2);
			    res= Math.round(res * 100) / 100;
		    	$('#equal_value2').val(res+" C");
		  }
		  else 
		  {
			  var val=$('#temperature2').val();
			    var tc=(val);
			    var tf=((9/5)*tc)+32;
			    var res1=(tf*Math.pow(10,2))/Math.pow(10,2);
			    res1= Math.round(res1 * 100) / 100;
			    $('#equal_value2').val(res1+" F");
		  }
		 }
		 else{
			 
			  alert('Please enter valid temprature');
			  $('#temperature2').val("");
			  $('#equal_value2').val("");
			//  $('.degree2').attr('checked', false);
			$('#type_tempreture2').attr('checked', true);
				return false;
			}
			  
	});

$('.Weight').click(function ()
	{//alert($('.Weight').val());
			 //alert($('#weights').val());
		
			$('#weight_result').val($('#weights').val());

			if(($('#weights').val())=="")
			{
			 alert('Please Enter Weight.');
			 $('#TypeWeightLbs').attr('checked', true);
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


//$('#painPresent').change(function(){
	$(document).on('change','.painPresent', function() { 
		test($(this).attr('id'));
		isPain=$(this).val();
		if(isPain == '1'){
			$('#commonPain_'+currentID).val(""); 
			$('#preferredPainTool_'+currentID).val("");
			$("#spoId_"+currentID).val("");
			$('.IV').val("");
			$("#modifiedFLACCPainScore_"+currentID).val("");
			$("#faceScore2_"+currentID).val("");
		}
		if($(this).val() != ""){
			var fullDate = new Date();
			var NullDate =(fullDate.format('d/m/Y H:i:s'));
			$('#pain_date_'+currentID).val(NullDate);
			$('#user_id_pain_'+currentID).val("<?php echo $this->Session->read('userid');?>");
		}
	});

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

//$('#preferredPainTool').change(function (){
	$(document).on('change','.preferredPainTool', function() {
		id = $(this).attr('id');
		currentID = id.split("_")[1] ;

		if($(this).val() != ""){
			var fullDate = new Date();
			var NullDate =(fullDate.format('d/m/Y H:i:s'));
			$('#pain_date_'+currentID).val(NullDate);
			$('#user_id_pain_'+currentID).val("<?php echo $this->Session->read('userid');?>");
		}
		
	painScore=$(this).val();
	if(painScore==""){
		$('.IIV_'+currentID).hide();
		$('#numScore_'+currentID).hide();
		$('.faces_'+currentID).hide();
	
	}else{
		if(painScore=='0'){
			$('.IIV_'+currentID).show();
			$('#numScore_'+currentID).hide();
			$('.faces_'+currentID).hide();
			$('.faceScore1_'+currentID).hide();
			$("#spoId_"+currentID).val("");
			$("#faceScore2_"+currentID).val("");
		}else if(painScore=='1'){
			$('.IIV_'+currentID).hide();
			$('#numScore_'+currentID).show();
			$('.faces_'+currentID).hide();
			$('.faceScore1_'+currentID).hide();
			$("#modifiedFLACCPainScore_"+currentID).val("");
			$("#faceScore2_"+currentID).val("");
		}
		else if(painScore=='2'){
			$('.IIV_'+currentID).hide();
			$('.faces_'+currentID).show();
			$('#numScore_'+currentID).hide();
			$('.faceScore1_'+currentID).hide();
			$("#modifiedFLACCPainScore_"+currentID).val("");
			$("#spoId_"+currentID).val("");
		}
	}
	
});
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
$('#lengthForAgeFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Person", "action" => "bmi_infants_lenghtforage_female",$patient['Patient']['person_id'])); ?>",
	});
});	 
$('#lengthForAgeMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_lengthforage_male",$patient['Patient']['person_id'])); ?>",
	});
});	 
$('#bmiInfantsWeightForAge').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_weightforage",$patient['Patient']['person_id'])); ?>",
	});
});	
$('#bmiInfantsWeightForageMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_weightforage_male",$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiInfantsWeightForLengthFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_weightforlength_female",$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiInfantsWeightForLengthMale').click(function(){
	$.fancybox({
	
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_weightforlength_male",$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiInfantsHeadcircumFerenceFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_headcircumference_female",$id)); ?>",
	});
});
$('#bmiInfantsHeadcircumFerenceMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "bmi_infants_headcircumference_male",$id)); ?>",
	});
});
//GULLU*********************NEW
$('#bmiChartFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_chart_female',$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiChartMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_chart_male',$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiStatureforageFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_statureforage_female',$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiStatureforageMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_statureforage_male',$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiWeightforageFemale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_weightforage_female',$patient['Patient']['person_id'])); ?>",
	});
});
$('#bmiWeightforageMale').click(function(){
	$.fancybox({
	'width' : '100%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'hideOnOverlayClick':false,
	'showCloseButton':true,
	'onClosed':function(){
	},
	'href' : "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'bmi_weightforage_male',$patient['Patient']['person_id'])); ?>",
	});
});
//GULLU****************************************EOF NEW

function pres_temp(patientid){//alert(patientid);
	$
	.fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			/*$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});*/
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "temp_chart",$patient_id)); ?>"

	});
		 
	}


function pres_pr(patientid){//alert(patientid);
	$
	.fancybox({
		'width' : '70%',
		'height' : '80%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "pr_chart",$patient_id)); ?>"

	});
		 
	}

function pres_bp(patientid){//alert(patientid);
	$
	.fancybox({
		'width' : '70%',
		'height' : '80%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "bp_chart",$patient_id)); ?>"

	});
		 
	}

function pres_rr(patientid){//alert(patientid);
	$
	.fancybox({
		'width' : '70%',
		'height' : '80%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "rr_chart",$patient_id)); ?>"

	});
		 
	}


function pres_spo(patientid){//alert(patientid);
	$.fancybox({
		'width' : '70%',
		'height' : '80%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "spo2_chart",$patient_id)); ?>"

	});
		 
	}
//painHtml=  $("#painAdd").clone();

$('#addMore').click(function(){
	ajaxUrl = "<?php echo $this->Html->url(array('controller'=>"diagnoses",'action'=>"painHtml")); ?>"+"/"+painCounter ;
	$.ajax({
	     type: 'POST',
	     url:  ajaxUrl  ,
	     dataType: 'html',
	     beforeSend:function(){ 
	    	 $("#busy-indicator").show();
	     },
	     success: function(data){		
	    	 $("#design1").append('<div class="tdLabel pain_sec light painRemove" id="painAdd_'+painCounter+'">'+data+'</div>');
	    	 $("#busy-indicator").hide(); 
	     },
		 error: function(message){    
			   
	     }        
	});
    
	
	$("painAdd_"+painCounter).find('input').prop('value','');
	$("painAdd_"+painCounter).find('select').prop('selectedIndex','');
	painCounter++ ;

	if($('.painRemove').length >='0'){
		$('#removeButton').show();
	}else{
		$('#removeButton').hide();
	}
});

$(document).on('click','#removeButton', function() {
	
	$('.painRemove').last().remove();
	
	if($('.painRemove').length >'0'){
		$('#removeButton').show();
	}else{
		$('#removeButton').hide();
	}
	
 });
</script>
  
 