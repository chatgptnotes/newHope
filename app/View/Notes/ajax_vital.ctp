<form id="vitalFrm">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="" id="tabularForm">
                    <!--    <tr>
                      		<th align="center" >Temperature</th>
                            <th align="center" >Heart Rate</th>
                            <th  align="center" >Blood Pressure</th>
                            <th  align="center" >Respiration Rate</th>
                     </tr> -->
                      <tr>
                      		<td width="5%">Temperature:<input value="<?php echo $getHold['BmiResult']['temperature'];?>" style="width: 32%;"type="text" name="BmiResult[temperature]">&nbsp;<sup>0</sup>F</td>
                      		<td width="6%">Heart Rate:<input value="<?php echo $getHold['BmiBpResult']['pulse_text'];?>" style="width: 24%; type="text" name="BmiBpResult[pulse_text]">&nbsp;bmp</td>
                      		<td width="6%">Blood Pressure:<input value="<?php echo $getHold['BmiBpResult']['systolic'];?>" style="width: 18%; type="text" name="BmiBpResult[systolic]">/<input value="<?php echo $getHold['BmiBpResult']['diastolic'];?>" style="width: 18%; type="text" name="BmiBpResult[diastolic]">&nbsp;mmHg</td>
                      		<td width="6%">Respiration Rate:<input  value="<?php echo $getHold['BmiResult']['respiration'];?>" style="width: 18%; type="text" name="BmiResult[respiration]">&nbsp;bpm</td>
                      		<td width="10%"><input type="button" value="Save" id="saveVital" class="blueBtn"></td>
                     </tr>
                     
                     <input type="hidden" name="BmiResult[patient_id]" value=<?php echo $patientId;?>>
                      <input type="hidden" name="BmiResult[note_id]" value=<?php echo $noteId;?>>
                       <input type="hidden" name="BmiResult[appointment_id]" value=<?php echo $appointmentId;?>>
 </table>
 </form>
 <script>
 $('#saveVital').click(function (){
	var formData = $('#vitalFrm').serialize();
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "ajax_vital",$patientId,$noteId,$appointmentId,"admin" => false)); ?>";
	$.ajax({
		beforeSend : function() {
			$('#busy-indicator').show('fast');
		},
		type: 'POST',
		url: ajaxUrl,
		data:formData,//"id="+complaints+"&id2="+patientId,
		dataType: 'html',
		success: function(data){
			getSubData();
			$('#busy-indicator').hide('fast');
			 $('#alertMsg').show();
			 $('#alertMsg').html('Vitals Saved Successfully.');
			 $('#alertMsg').fadeOut(5000);
			
	},
	});
 });
 </script>