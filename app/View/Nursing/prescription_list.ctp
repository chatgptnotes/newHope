<div class="inner_title">

	<div style="float: left">
		<h3>
			<?php echo __('Five Right\'s Verification'); ?>
		</h3>
	</div>
	<div style="text-align: right;">&nbsp;</div>
</div>
<?php  echo $this->Form->create('Nursings',array('id'=>'Presc','action'=>'prescription_list',
		'inputDefaults' => array(
											        'label' => false,
											        'div' => false,
											        'error'=>false )));?>
<div class="patient_info" id="addNote">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: left;">
		<tr colspan='2'>
			<td>Patient Information:</td>
			<td>Patient Medication Orders:</td>
			<td>Medication Administered By:</td>

		</tr>
		<tr colspan='2'>
			<td><?php echo $this->Form->input('Presc.patientInfo', array('type'=>'textarea','cols'=>'15','rows'=>'3','style'=>'width:160px','id'=>'patientInfo','label' => false)); ?></td>
			<td><?php echo $this->Form->input('Presc.patientMedicat', array('type'=>'textarea','cols'=>'15','rows'=>'3','style'=>'width:160px','id'=>'patientMedicat','label' => false)); ?></td>
			<td><?php echo $this->Form->input('Presc.AdministerBy', array('type'=>'textarea','cols'=>'15','rows'=>'3','style'=>'width:160px','id'=>'Administer','label' => false)); ?></td>
		</tr>
		<tr>
			<td colspan='4' align='right' valign='bottom'><?php echo $this->Html->link(__('Check'),"javascript:void(0)",array('id'=>'PrescCheck','class'=>'blueBtn','onclick'=>'javascript:check_Presc();')); ?>
			</td>
		</tr>
		<!-- ------------------------------------------------------------------------------------------------------------------------------- -->
		<tr>
		<td class="row_format" colspan=""><strong><?php echo __('Patient Information',true); ?></strong></td>
		</tr>
	<tr>
		
	<tr>
		<td width="100%" valign="top" align="left" colspan="6">
			<table width="100%" border="0" cellspacing="1" cellpadding="0"
				id='DrugGroup' class="tabularForm">
				<tr>
					<td width="29%" height="20" align="left" valign="top"><b>Patient Id</b>
					<?php echo $this->Form->input('Presc.patient_id', array('type'=>'text','style'=>'margin-left:27px','value'=>'','id'=>'patientId','label' => false)); ?>
					
					<span id="tick_patient_id" style="display:none"><?php echo $this->Html->image('icons/tick.png');?></span>
					   <span id="cross_patient_id" style="display:none"><?php echo $this->Html->image('icons/cross.png');?></span></td>
					<td width="33%" align="left" valign="top"><b>Name Of Patient</b>
					<?php echo $this->Form->input('Presc.patient_name', array('style'=>'margin-left:19px','label' => false,'id' => 'patient_name')); ?>
					<span id="tick_patient_name" style="display:none"><?php echo $this->Html->image('icons/tick.png');?></span>
					   <span id="cross_patient_name" style="display:none"><?php echo $this->Html->image('icons/cross.png');?></span></td>
					<td width="33%" align="left" valign="top"><b>Patient's Birth Date</b>
					<?php echo $this->Form->input('Presc.pt_birth_date', array('style'=>'margin-left:2px','label' => false,'id' => 'pt_birth_date')); ?>
					<span id="tick_patient_dob" style="display:none"><?php echo $this->Html->image('icons/tick.png');?></span>
					   <span id="cross_patient_dob" style="display:none"><?php echo $this->Html->image('icons/cross.png');?></span></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row_format" colspan=""><strong> <?php echo __('Prescribed Medicines',true); ?>
		</strong>
		</td>
		</tr>
	<tr>
		<td width="100%" valign="top" align="left" colspan="6">
			<table width="100%" border="0" cellspacing="1" cellpadding="0"
				id='DrugGroup' class="tabularForm">
				<tr>
					<td width="27%" height="20" align="left" valign="top"><b>Name of
							Medication</b></td>
					<td width="7%" align="left" valign="top"><b>Routes</b></td>
					
					<td width="8%" align="left" valign="top"><b>Frequency</b></td>
					<td width="9%" align="left" valign="top"><b>Dose</b></td>
					
				</tr>
				<?php 
				//print_r($medicines);
				 foreach($medicines as $key=>$drugs) {
					$prescdate = date('g,i,s,j,n,Y',strtotime($drugs['NewCropPrescription']['date_of_prescription']));
					//echo $prescdate;
					$current_presc_time=$drugs['NewCropPrescription']['date_of_prescription'];
					$time_min=date("H",strtotime($current_presc_time));
					//echo $time_min+1;
					$pres_start_time = date("Y-m-d",strtotime($current_presc_time))." ".$time_min.":00:00";
					
                                        //echo $pres_start_time."<Br>";
					//echo $next_time."<Br><br><br>";
					

					if($time_min>=30)
					
					$hours = substr($drugs['NewCropPrescription']['date_of_prescription'], 11, 8);
					$hours = str_replace(':',',',$hours);
					//echo $hours;
					$minutes = 0;
					if (strpos($hours, ':') !== false)
					{
						// Split hours and minutes.
						list($hours, $minutes) = explode(':', $hours);
					}
					$min =  $hours * 60 + $minutes;
					//echo $min;
					$length = strlen($drugs['NewCropPrescription']['frequency']);// echo $length;echo "</br>";
					if($length == 3){
						$strnumb = 	substr($drugs['NewCropPrescription']['frequency'], 1, 1);
					}elseif($length == 5){
						$strnumb = substr($drugs['NewCropPrescription']['frequency'], -2, 1);
					}elseif($length == 4){
						$strnumb = substr($drugs['NewCropPrescription']['frequency'], -3, 2);
					} 
					if(is_numeric($strnumb)){ $cnt =0;
					for($i=$strnumb;$i<=24;$i=$i+$strnumb){
						
						$frequency['time'.$key][] = $min + 60*$strnumb;
						$min =  $frequency['time'.$key][$cnt];
						$cnt++;	
					}
					}else{
						$frequency['time0'] = null;
					}
					$next_time=date("Y-m-d H:i:s",strtotime("+".$strnumb." hours",strtotime($pres_start_time)));
					//echo $strnumb;
					if(is_numeric($strnumb))
					{
					  $loopcnt=24/$strnumb;
					
					  $finalloopcnt=$loopcnt-1;
					  }
					  else
					  {
					    if($drugs['NewCropPrescription']['frequency']=='BID')
					    {
					       $loopcnt=24/12;
					       $strnumb=24/2;
					
					         $finalloopcnt=$loopcnt-1;
					    }
					     if($drugs['NewCropPrescription']['frequency']=='TID')
					    {
					       $loopcnt=24/8;
					       $strnumb=24/3;
					
					         $finalloopcnt=$loopcnt-1;
					    }
					    
					  }
				
					

					?>
				<tr>
					<td><span id="med_<?php echo $key?>"><?php echo $drugs['NewCropPrescription']['description']; ?></span>
					<?php echo $this->Form->input('Presc.medication',array('style'=>'margin-left:40px','id'=>'medication'.$key,'type'=>'text','label'=>false )); 
					 ?><span id="tick_<?php echo $key?>" style="display:none"><?php echo $this->Html->image('icons/tick.png',array('id'=>'correct'));?></span>
					   <span id="cross_<?php echo $key?>" style="display:none"><?php echo $this->Html->image('icons/cross.png',array('id'=>'correct'));?></span>
						</td>
					<td><span id="rout_<?php echo $key?>"><?php echo $drugs['NewCropPrescription']['route']; ?></span>
					<?php echo $this->Form->input('Presc.route',array('style'=>'margin-left:40px','id'=>'route'.$key,'type'=>'text','label'=>false )); ?>
					<span id="tick1_<?php echo $key?>" style="display:none"><?php echo $this->Html->image('icons/tick.png',array('id'=>'correct'));?></span>
					<span id="cross1_<?php echo $key?>" style="display:none"><?php echo $this->Html->image('icons/cross.png',array('id'=>'correct'));?></span>
						</td>
					<td><span id="freq_<?php echo $key?>"><?php echo $drugs['NewCropPrescription']['frequency']; ?></span>
					<?php echo $this->Form->input('Presc.frequency',array('style'=>'margin-left:40px','id'=>'frequency'.$key,'type'=>'text','label'=>false )); ?>
					<span id="time_<?php echo $key?>" style="display:none"><?php echo '<font color="red">You are late for this medication</font>'?></span>
					<span id="tick2_<?php echo $key?>" style="display:none"><?php echo $this->Html->image('icons/tick.png',array('id'=>'correct'));?></span>
					<span id="cross2_<?php echo $key?>" style="display:none"><?php echo $this->Html->image('icons/cross.png',array('id'=>'correct'));?></span><span>Medication Schedule</span><br/>1) <?php echo $pres_start_time?> 
					<?php if($finalloopcnt>0)
					{
					$cntt1=1;
					$next_time=date("Y-m-d H:i:s",strtotime("+".$strnumb." hours",strtotime($pres_start_time)));
					for($k=0;$k<$finalloopcnt;$k++)
					{
					 $cntt1++;
					 
					?>
					 <span><?php echo $cntt1?>)<?php echo "&nbsp".$next_time; ?></span>
					 
					<?php
					$next_time=date("Y-m-d H:i:s",strtotime("+".$strnumb." hours",strtotime($next_time)));
					}
					}
					?>
						</td>
					<td><span id="dos_<?php echo $key?>"><?php echo $drugs['NewCropPrescription']['dose']; ?></span>
					<?php echo $this->Form->input('Presc.dose',array('style'=>'margin-left:40px','id'=>'dose'.$key,'type'=>'text','label'=>false )); ?>
					<span id="tick3_<?php echo $key?>" style="display:none"><?php echo $this->Html->image('icons/tick.png',array('id'=>'correct'));?></span>
					<span id="cross3_<?php echo $key?>" style="display:none"><?php echo $this->Html->image('icons/cross.png',array('id'=>'correct'));?></span>
					   </td>
					
				<?php
					 } 
					 
				$cur_hours =date('H:i:s');
				$cur_hours = str_replace(':',',',$cur_hours);
				$cur_minutes = 0;
				if (strpos($cur_hours, ':') !== false)
				{
					// Split hours and minutes.
					list($cur_hours, $cur_minutes) = explode(',', $cur_hours);
				}
				$cur_min =  $cur_hours * 60 + $cur_hours;
  echo '<script type="text/javascript">';
  echo 'var freq_array = '.json_encode($frequency).';';
  echo '</script>'; 
 // echo "<pre>"; print_r($frequency);
 ?>
			</table>
		</td>
	</tr>


	
		<!-- ------------------------------------------------------------------------------------------------------------------------------- -->
		
		
		<tr>
			<td colspan='4' align='right' valign='bottom'><?php echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'Prescsubmit','class'=>'blueBtn','onclick'=>'javascript:save_Presc();')); ?>
			</td>
		</tr>
	</table>
</div>
<?php $this->Form->end();?>
<?php //echo $medication;exit;?>
<script>

var wrongPatient ='';
var wrongMedication ='';
function convert(str)
{
  str = str.replace(/&amp;/g, "&");
  str = str.replace(/&gt;/g, ">");
  str = str.replace(/&lt;/g, "<");
  str = str.replace(/&quot;/g, '"');
  str = str.replace(/&#039;/g, "'");
  return str;
}
function check_Presc(){ 
	wrongMedication = 0;
	wrongPatient=0;
	current_minutes="<?php echo $cur_min  ?>";
	patientid="<?php echo $patientid ?>";
		var ajaxUrl = "<?php echo $this->Html->url(array("controller"=>"nursings","action" => "prescription_list","admin" => false)); ?>"+ "/"+ patientid;
	   var formData = $('#Presc').serialize();
	   
           $.ajax({
            type: 'POST',
           url: ajaxUrl,
            data: formData,
            dataType: 'html',
            success: function(data){ 
            	data = JSON && JSON.parse(data) || $.parseJSON(data);
           		$('#patientId').val(data.patientInfo[0]);
            	$('#patient_name').val(data.patientInfo[1]);
            	$('#pt_birth_date').val(data.patientInfo[2]);
					incre=0;
            	$.each(data.patientdb, function(index) {
            		$.each(data.patientdb[index], function(key, value) {
            			 
						if(key == 'patient_id'){
							if($('#patientId').val() == value){
								$("#cross_patient_id").hide();
								$("#tick_patient_id").show();
							}else{ 
								wrongPatient++;
								$("#tick_patient_id").hide();
								$("#cross_patient_id").show();
							}
						}

						if(key == 'lookup_name'){
							if($('#patient_name').val() == value){
								$("#cross_patient_name").hide();
								$("#tick_patient_name").show();
							}else{
								wrongPatient++;
								$("#tick_patient_name").hide();
								$("#cross_patient_name").show();
							}
						}

						if(key == 'dob'){
							if($('#pt_birth_date').val() == value){
								$("#cross_patient_dob").hide();
								$("#tick_patient_dob").show();
							}else{
								wrongPatient++;
								$("#tick_patient_dob").hide();
								$("#cross_patient_dob").show();
							}
						}
						
						incre++;
                		});
                		
                	});
            	
            	var cnt=0;
            	
            	$.each(data.patientMedicat, function(index) {
                	
            		$.each(data.patientMedicat[index], function(key, value) {

            			if(key==0){
            			$("#medication"+cnt).val(value);
            				if(convert($.trim($("#med_"+cnt).html())) == convert($.trim($("#medication"+cnt).val()))){
            					$("#cross_"+cnt).hide();
            					$("#tick_"+cnt).show();
            				}else{
            					wrongMedication++;
            					$("#tick_"+cnt).hide();
            					$("#cross_"+cnt).show();
            					
            				}
            			}
            			if(key==1){
                			$("#route"+cnt).val(value);
                			if(convert($("#rout_"+cnt).html()) == convert($("#route"+cnt).val())){
                				$("#cross1_"+cnt).hide();
            					$("#tick1_"+cnt).show();
        				}else{
        					wrongMedication++;
        					$("#tick1_"+cnt).hide();
        					$("#cross1_"+cnt).show();
        				}
            			}
            			if(key==2){
                			$("#frequency"+cnt).val(value);
                			
                			if(convert($("#freq_"+cnt).html()) == convert($("#frequency"+cnt).val())){
                				$("#cross2_"+cnt).hide();
            					$("#tick2_"+cnt).show();
            				}else{
            					wrongMedication++;
            					$("#tick2_"+cnt).hide();
            					$("#cross2_"+cnt).show();
            				}
                		}
            			if(key==3){
                			$("#dose"+cnt).val(value);
                			if($("#dos_"+cnt).html() == $("#dose"+cnt).val()){
                				$("#cross3_"+cnt).hide();
            					$("#tick3_"+cnt).show();
            				}else{
            					wrongMedication++;
            					$("#tick3_"+cnt).hide();
            					$("#cross3_"+cnt).show();
            			}
            			}

						var myIndex = 'time'+key;
            					


            			if(freq_array !== null){ 
				
							if(freq_array[myIndex] !== undefined && freq_array[myIndex] !== null){
							$.each(freq_array[myIndex], function(root, number) {
									if (number+30 <= current_minutes ) {
										$("#time_"+key).show();
										}
									});
							}
						}
            			

            		});
            		cnt++;
           
            	});
            },
			error: function(message){
                alert("Internal Error Occured. Unable To Check data.");
            }        });
      
      return false;
}

function save_Presc() 
{ 
	
	
	if(wrongMedication >= 1 && wrongPatient >= 1){
		alert("Please take right patient and medication.");
		wrongMedication = 'No';
		wrongPatient = 'No';
		return false;
	}
	if(wrongMedication >= 1){
		alert("Please take right medication.");
		wrongMedication = 'No';
		wrongPatient = 'No';
		return false;
	}
	if(wrongPatient >= 1){
		alert("Please select right patient.");
		wrongMedication = 'No';
		wrongPatient = 'No';
		return false;
	}
	if(wrongMedication == 'No' || wrongPatient == 'No')
		return false;
	
 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "nursings", "action" => "prescription_record","admin" => false)); ?>";
  var formData = $('#Presc').serialize();
 
   $.ajax({
       type: 'POST',
      url: ajaxUrl,
       data: formData,
       dataType: 'html',
       success: function(data){ 
    	   window.location.href = '<?php echo $this->Html->url('/nursings/patient_information/'); ?>'+"<?php echo $patientid ?>";
       },
		error: function(message){
		 alert("Internal Error Occured. Unable To Save Data.");
       },       
       });
 
 return false;
	
}

jQuery(document).ready(function(){
	$('#Administer').val('<?php echo $this->Session->read('username')?>');
	
});

</script>