<style>
<!--
.textBoxExpnd{
	float: none ;
}
-->
</style>
<div class="inner_title">OPERATION NOTES
	<span>
		<?php 
			echo $this->Html->link('Print','javascript:void(0);',array('class'=>'blueBtn','onclick'=>'printOP();'))
		?>
	</span>
</div>
<table>
	<tr>
		<?php if($this->params->isAjax!='1'){?>
		<td>Patient Name</td><td><?php 
		echo $this->Form->input('patient_name',array('type'=>'text','id'=>'pat_name',
													'div'=>false,'label'=>false));
 		echo $this->Form->hidden('',array('type'=>'text','id'=>'patient_id','name'=>'patient_id',
													'div'=>false,'label'=>false,'value'=>$this->request->params['pass'][0]));?></td>
 		<td> Surgery :</td><td>
		<?php 
		if(isset($returnArray)){
            echo $this->Form->input('surgeryname',array('type'=>'select','id'=>'surgery_name','empty'=>'Please Select','options'=>$returnArray,'div'=>false,'label'=>false));
        }else{
            echo $this->Form->input('surgeryname',array('type'=>'select','id'=>'surgery_name','empty'=>'Please Select',
            'div'=>false,'label'=>false ));
        }
				
		 ?></td>
		<?php }else{
			echo $this->Form->hidden('',array('type'=>'text','id'=>'patient_id','name'=>'patient_id',
													'div'=>false,'label'=>false,'value'=>$patient_id));
		}?>
		<td><?php //echo $this->Html->link('Submit','javascript:void(0);',array('class'=>'blueBtn','id'=>'dSubmit','onclick'=>'submitData();'))?></td>
	</tr>
</table>

<?php 
	echo $this->Form->end();
	echo $this->Form->create('anae',array('id'=>'anae','inputDefaults'=>array('label'=>false,'div'=>false)));
	echo $this->Form->hidden('',array('value'=>$patient['Patient']['id'],'type'=>'hidden','name'=>'patient_id'));
	//echo $this->Form->input('',array('type'=>'hidden','id'=>'surgery_id','name'=>'surgery_id','div'=>false,'label'=>false,'value'=>$this->request->params['pass'][1]));
?>

<table width="100%" border="0" class="table_format" style="padding:0px !important">
	<tr>
		<td width="15%">Name Of Patient</td>
		<td colspan="3"><?php echo $this->Form->input('lookup_name',array('value'=>$patientDetailsForView['Patient']['lookup_name'],'type'=>'text','class'=>'textBoxExpnd'));?></td>
	</tr>
	<td> Surgery :</td>
	<td colspan="3">
		<?php 
		if(isset($returnArray)){
            echo $this->Form->input('surgeryname',array('type'=>'select','id'=>'surgery_name','empty'=>'Please Select','options'=>$returnArray,'div'=>false,'label'=>false,'class'=>'textBoxExpnd'));
        }else{
            //echo $this->Form->input('surgeryname',array('type'=>'select','id'=>'surgery_name','empty'=>'Please Select',
            //'div'=>false,'label'=>false ));
        }
				
		 ?></td>
	<tr>
		<td>Diagnosis</td>
		<td colspan="3">
			<?php 
				$final_diagnosis=isset($MuraliData['Diagnosis']['final_diagnosis'])?$MuraliData['Diagnosis']['final_diagnosis']:"";
				echo $this->Form->input('diagnosis',array('class'=>'textBoxExpnd','value'=>$final_diagnosis));
			?>
		</td>
	</tr>
	<tr>
		<td>Dept./Ward:</td>
		<td><?php   
 			echo $department['Department']['name']." / ".$wardInfo['Ward']['name'];  ?></td>
		<td>Surgeon :</td>
		<td>
			<?php 
				$surgeon=isset($MuraliData['DoctorProfile']['doctor_name'])?$MuraliData['DoctorProfile']['doctor_name']:'';  
				echo $surgeon ;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%">Procedure</td>
		<td width="25%"><?php $procedureName=$_SESSION['packName'];
			echo $this->Form->input('procedure_name',array('class'=>'textBoxExpnd','value'=>$procedureName));
			echo $this->Form->hidden('',array('type'=>'text','id'=>'','name'=>'surgery_id',
													'div'=>false,'label'=>false,'value'=>$MuraliData['TariffList']['id']));
			?></td>
		<td width="25%">Assist Surgeon</td>
		<td width="25%"><?php echo $this->Form->input('assist_surgeon',array('class'=>'textBoxExpnd','value'=>$loadData['OperativeNote']['assist_surgeon']));?></td>
	</tr>
	<tr>
		<td valign="top">Sensitivity</td>
		<td valign="top"><?php 
		echo $this->Form->input('id',array('id'=>'id','type'=>'hidden')) ;
		echo $this->Form->input('sensitivity',array('class'=>'textBoxExpnd','value'=>$sensitivity));?></td>
		<td valign="top">Anaethesiologists</td>
		<td><table width="100%" border="0" >
				<tr>
					<td>(1) <?php 
								 $anaesthesist = 'Dr. '.$otList['AnaeUser']['first_name']." ".$otList['AnaeUser']['last_name'];	
								 if(empty($otList['AnaeUser']['first_name'])){
										$anaesthesist=$this->data['anaesthesia_1'];
									}							
								echo $this->Form->input('anaesthesia_1',array('class'=>'textBoxExpnd','value'=>$anaesthesia_1));
						?></td>
				</tr>
				<tr>
					<td>(2) <?php echo $this->Form->input('anaesthesia_2',array('class'=>'textBoxExpnd','value'=>$anaesthesia_2));?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	</tr>
	<tr>
		<td valign="top">Date</td>
		<td valign="top"><?php 
			$surgeryDate = $this->DateFormat->formatDate2Local($ot_date,Configure::read('date_format'),false) ;			
			$surgeryDate .= " ".$otList['OptAppointment']['start_time'] ; 
			echo $this->Form->input('ot_date',array( 'id'=>'ot_date','type'=>'text','value'=>$surgeryDate,'class'=>'textBoxExpnd'));?></td>
		<td valign="top">Staff Nurse</td>
		<td>
				<?php 
					echo $this->Form->checkbox('scrubbed', array('hiddenField' => false,'id'=>'Scrubbed' )).'Scrubbed';
					echo $this->Form->checkbox('rotating', array('hiddenField' => false,'id'=>'Rotating')).'Rotating'; ?>
			</td>
	</tr> 
</table>
<!-- <table  width="100%" border="0px" class="table_format" style="padding:0px !important">
  <tr>
   <th scope="col" align="left">Type Of Anaesthesia</th>
  </tr>
  <tr>
    <td width="100%" valign="top">
    	<table width="100%" border="0px" >
          	<tr>
	            <td>Type Of Anaesthesia</td>
	       		<td><?php  
	       		$general=isset($loadData1['AnaesthesiaNote']['general'])?$loadData1['AnaesthesiaNote']['general']:"";

	       			$induction=isset($loadData1['AnaesthesiaNote']['induction'])?$loadData1['AnaesthesiaNote']['induction']:"";
	       			$type1=isset($loadData1['AnaesthesiaNote']['type1'])?$loadData1['AnaesthesiaNote']['type1']:"";
	       			
	       			$ettno=isset($loadData1['AnaesthesiaNote']['ettno'])?$loadData1['AnaesthesiaNote']['ettno']:"";
	       			$on=isset($loadData1['AnaesthesiaNote']['on'])?$loadData1['AnaesthesiaNote']['on']:"";
	       			
	       			$relaxation=isset($loadData1['AnaesthesiaNote']['relaxation'])?$loadData1['AnaesthesiaNote']['relaxation']:"";
	       			$type=isset($loadData11['AnaesthesiaNote']['type'])?$loadData['AnaesthesiaNote']['type']:"";
	       			
	       			$gases=isset($loadData['AnaesthesiaNote']['gases'])?$loadData['AnaesthesiaNote']['gases']:"";
	       			$reversal=isset($loadData['AnaesthesiaNote']['reversal'])?$loadData['AnaesthesiaNote']['reversal']:"";
	       			
	       			$agent=isset($loadData['AnaesthesiaNote']['agent'])?$loadData['AnaesthesiaNote']['agent']:"";
	       			$extubatoin=isset($loadData['AnaesthesiaNote']['extubatoin'])?$loadData['AnaesthesiaNote']['extubatoin']:"";

	       			echo $this->Form->input(' ',array('name'=>"general",'empty'=>"Please Select",'options'=>array('General','Regional','Narve Blocks','Local / Stand - By'),'id' => "general",'div'=>false,'label'=>false,'value'=>$general)); ?>
	       		</td>
       		</tr>
       		<tr id="GA" style="display:none;">
       			<td colspan="2">
       			<table width="100%" border="0px">
       				<tr>
       					<td colspan="4"><b>General Anaesthesia</b></td>
       				</tr>
       				<tr>
       					<td>Induction</td>
       					<td><?php echo $this->Form->input('induction',array('class'=>'textBoxExpnd','value'=>$induction));?></td>
       					<td>Type</td>
       					<td><?php echo $this->Form->input('type1',array('class'=>'textBoxExpnd','value'=>$type1));?></td>
       				</tr>
       				<tr>
       					<td>ETT No</td>
       					<td><?php echo $this->Form->input('ettno',array('class'=>'textBoxExpnd','value'=>$ettno));?></td>
       					<td>Oral/Nasal</td>
       					<td><?php echo $this->Form->input('on',array('class'=>'textBoxExpnd','value'=>$on));?></td>
       				</tr>
       				<tr>
       					<td>Relaxation</td>
       					<td><?php echo $this->Form->input('relaxation',array('class'=>'textBoxExpnd','value'=>$relaxation));?></td>
       					<td>Ventilation</td>
       					<td><?php echo $this->Form->input('type',array('class'=>'textBoxExpnd','value'=>$type));?></td>
       				</tr>
       				<tr>
       					<td>Gases</td>
       					<td><?php echo $this->Form->input('gases',array('class'=>'textBoxExpnd','value'=>$gases));?></td>
       					<td>Reversal</td>
       					<td><?php echo $this->Form->input('reversal',array('class'=>'textBoxExpnd','value'=>$reversal));?></td>
       				</tr>
       				<tr>
       					<td>Inhalational agent</td>
       					<td><?php echo $this->Form->input('agent',array('class'=>'textBoxExpnd','value'=>$agent));?></td>
       					<td>Extubatoin</td>
       					<td><?php echo $this->Form->input('extubatoin',array('class'=>'textBoxExpnd','value'=>$extubatoin));?></td>
       				</tr>
       			</table>
       		</td>
          	</tr>
          	<tr id="RN" style="display:none;">
          		<td colspan="2">
					<table width="100%" border="0px">
						<?php 
							$anaedata=$loadData;
						?>
					  <tr>
					    <th colspan="5" style="text-align: left;">Regional / Nerve Block</th>
					    
					  </tr>
					   <tr>

					    <td>Type</td>
					     <td><?php echo $this->Form->input('type', array('type'=>'text','name'=>"type",'value'=>$anaedata['AnaesthesiaNote']['type'],'id' => "type")); ?></td>

					  

					    <td width="12%">Onset</td>
					  <td ><?php echo $this->Form->input('onset', array('type'=>'text','name'=>"onset",'value'=>$anaedata['AnaesthesiaNote']['onset'],'id' => "onset")); ?></td>

					  </tr>
					  <tr>

					    <td>Needle </td>
					    <td><?php echo $this->Form->input('needle', array('type'=>'text','name'=>"needle",'value'=>$anaedata['AnaesthesiaNote']['needle'],'id' =>"needle")); ?></td>
					    <td>Level</td>
					   <td><?php echo $this->Form->input('level', array('type'=>'text','name'=>"level",'value'=>$anaedata['AnaesthesiaNote']['level'],'id' => "level")); ?></td>

					  </tr>
					  <tr>

					    <td>Space</td>
					   <td><?php echo $this->Form->input('space', array('type'=>'text','name'=>"space",'value'=>$anaedata['AnaesthesiaNote']['space'],'id' =>"space")); ?></td>
					    <td>Duration </td>
					    <td><?php echo $this->Form->input('duration', array('type'=>'text','name'=>"duration",'value'=>$anaedata['AnaesthesiaNote']['duration'],'id' => "duration")); ?></td>

					  </tr>
					  <tr>

					    <td>Drug</td>
					    <td><?php echo $this->Form->input('regional_drug', array('type'=>'text','name'=>"regional_drug",'value'=>$anaedata['AnaesthesiaNote']['regional_drug'],'id' => "drug")); ?></td>
					    <td>Recovery</td>
					    
					    
					           <td><?php echo $this->Form->input('recovery', array('type'=>'text','name'=>"recovery",'value'=>$anaedata['AnaesthesiaNote']['recovery'],'id' => "recovery ",'div'=>false,'label'=>false)); ?></td>
					    
					  </tr>
					  <tr>

					    <td>Volume</td>
					   <td><?php echo  $this->Form->input('volume', array('type'=>'text','name'=>"volume",'value'=>$anaedata['AnaesthesiaNote']['volume'],'id' => "volume")); ?></td>
					    <td>Top - up</td>
					   <td><?php echo $this->Form->input('top_up', array('type'=>'text','name'=>"top_up",'value'=>$anaedata['AnaesthesiaNote']['top_up'],'id' => "top_up")); ?></td>

					  </tr>
					</table>
          		</td>
          	</tr>
          	<tr id="LS" style="display:none;">
          		<td colspan="2">
					<table width="100%" border="0px">
					  <tr>
					    <th colspan="5" style="text-align: left;">Local / Stand -By</th>
					  </tr>
					  <tr>
					  	<td>Local / Stand -By</td>
					    <td><?php echo $this->Form->input('local', array('type'=>'text','name'=>"local",'value'=>$anaedata['AnaesthesiaNote']['local'],'id' => "type")); ?></td>
					  </tr>
					</table>
				</td>
			</tr>

					  
        </table> 
    </td>
  </tr>
</table> -->
<table width="100%" border="0px" class="table_format" style="padding:0px !important">
	<tr>
		<td width="15%" valign="top">Type Of Anaesthesia</td>
		<td valign="top" colspan="3">
			<?php //echo $this->Form->input('routine_emergency',array('class'=>'textBoxExpnd'));
			echo $this->Form->input(' ',array('name'=>"general",'empty'=>"Please Select",'options'=>array('General','Regional','Narve Blocks','Local / Stand - By'),'id' => "general",'div'=>false,'label'=>false,'value'=>$general)); ?>
		</td> 
	</tr>

	<tr>
		<td width="15%" valign="top">Routine / Emergency</td>
		<td valign="top" colspan="3">
			<?php //echo $this->Form->input('routine_emergency',array('class'=>'textBoxExpnd'));
			echo $this->Form->input('routine_emergency',array('name'=>"routine_emergency",'empty'=>"Please Select",'options'=>array('Routine','Emergency'),'id' => "routine_emergency",'div'=>false,'label'=>false));?>
		</td> 
	</tr>
	<tr>
		<td valign="top">OT :  <?php echo $this->Form->input('ot_room',array('class'=>'','maxlength'=>2,'value'=>$otRoom[$otList['OptAppointment']['opt_id']]));?></td>
		<td valign="top" colspan="3"><table width="100%" border="0">
				<tr>
					<td>Tourniquet Time</td>
					<td><?php echo $this->Form->input('tourniquet_time',array('class'=>'textBoxExpnd'));?></td>
				</tr>
				<tr>
					<td>Blood Loss</td>
					<td><?php echo $this->Form->input('blood_loss',array('class'=>'textBoxExpnd'));?></td>
				</tr>
				<tr>
					<td>BT Given or Not</td>
					<td><?php echo $this->Form->input('bt_given',array('class'=>'textBoxExpnd'));?></td>
				</tr>
			</table></td> 
	</tr>
	<tr>
		<td width="24%" valign="top" colspan="4">
			<div class="section" id="post-opt">
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				class="formFull formFullBorder">
				<tr>
					<td width="27%" align="left" valign="top">Operation Notes:
						<div align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
								<tr>
									<td>
										<?php echo $this->Form->input('operation_notes', array('id' => 'operation_notes', 'class'=>'validate[optional,custom[customnotes]]','value'=>$oprNotes['OperativeNote']['operation_notes'])); ?>
										<br><br>
										<!-- CodeCreatives -->
										<div style="max-width: 515px;">
											<p class="tempHead" style="border: 1px solid #333;border-bottom: 0px;">Frequent templates:</p>
							            	<div style="border: 1px solid #333; background: white; border-top: 0px;" class="tempData" id="template-list-<?php echo $template_type ;?>">
							                    <table width="100%" cellpadding="0" cellspacing="0" border="0"> 
							                        <?php
							                        $cnt =0;
							                        if(count($data) > 0) {
							                        	foreach($data as $doctortemp):
							                        		$cnt++;
							                        		?>
							                        		<tr class="ques" data-question="<?php echo $doctortemp['DoctorTemplate']['template_name']; ?>">
							                        			<td align="left" style="padding: 0 0 0px 10px;">
							                        				<?php
							                        				echo  $this->Html->image('icons/favourite-icon.png', array('title'=> __('Admin Template', true), 'alt'=> __('Doctor Template Edit', true)));
							                        				echo $doctortemp['DoctorTemplate']['template_name'];
															   		
															   		?>
															   </td>
															</tr>
														<?php endforeach;  ?>
														<?php
													} else { ?>
													<tr>
														<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
													</tr>
													<?php }	?>
							                    </table>
							                </div>
							                <textarea class="gpt_input" name="gpt_input" placeholder="Choose from above or type here.." style=" min-width: 499px;border-top: 0px;"></textarea>
											<br>
											<button type="button" class="blueBtn btn btn-default get_gpt_reply">Search</button>

											<button type="button" class="blueBtn btn btn-default fetch_data">Fetch Data</button>
							            </div>
						                <!-- End -->
									</td>
									<td style="display:none;" id='tdsubCat'>
										<?php  echo $this->Form->input('sunCat',array('type'=>'select','id'=>'subCat','empty'=>'Please Select','div'=>false,'label'=>false));?> 
									</td>
									<td style="display:none;" id='tdsubsubCat'>
										<?php  echo $this->Form->input('subsubCat',array('type'=>'select','id'=>'subsubCat','empty'=>'Please Select','div'=>false,'label'=>false));?> 
									</td>
								</tr>
								<tr id="tempLoadMain"></tr>
								<tr id="tempLoadSub"></tr>
								<tr id="tempLoadSubSub"></tr>
							</table>
						</div>
						<!-- <div align="center" id='temp-busy-indicator' style="display: none;">	
							&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
						</div>
						<div id="templateArea-post-opt"></div> -->
					</td>
					<td width="70%" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="20">&nbsp;</td>
								<td valign="top" colspan="4">
	        							 <?php echo $this->Form->textarea('operation_notes', array('id' => 'optText','rows'=>'21','style'=>'width:90%', 'class'=>'validate[optional,custom[customnotes]]','value'=>$oprNotes['OperativeNote']['operation_notes'])); ?>
	        					</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		</td>
	</tr>
	<tr>
		<td valign="top">Date/Time</td>
		<td valign="top"><?php echo $this->Form->input('ot_notes_date',array('class'=>'textBoxExpnd','id'=>'ot_notes_date','type'=>'text','value'=>$ot_notes_date));?></td>
		<td valign="top">Signature of Surgeon</td>
		<td>________________________________</td>
	</tr>
	<tr>
		<td valign="top">&nbsp;</td>
		<td valign="top">&nbsp;</td>
		<td valign="top">Name Of Surgeon</td>
		<td><?php echo $surgeon ;?></td>
	</tr>
</table>
<p>&nbsp;</p> 
<p  style = "float:right;">
	<?php 
		echo $this->Html->link('Cancel',array('controller'=>'NewOptAppointments','action'=>'dashboard_index'),array('class'=>'grayBtn'));
		echo $this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false)); 
	?>
</p>
<?php echo $this->Form->end(); 

 ?> 
<script>

// CodeCreatives
var name         = "<?php echo $patient['Patient']['lookup_name']; ?>";
var sex          = "<?php echo $patient['Patient']['sex']; ?>";
var admission_id = "<?php echo $patient['Patient']['admission_id']; ?>";
var patient_uid  = "<?php echo $patient['Person']['patient_uid']; ?>";
var dob          = "<?php echo $patient['Person']['dob']; ?>";
var diagnosis    = "<?php echo isset($oprNotes['OperativeNote']) && isset($oprNotes['OperativeNote']['diagnosis']) ? $oprNotes['OperativeNote']['diagnosis'] : ''; ?>";
var procedure    = "<?php echo isset($oprNotes['OperativeNote']) && isset($oprNotes['OperativeNote']['procedure_name']) ? $oprNotes['OperativeNote']['procedure_name'] : '' ?>";
// Discharge Summary Data..
var examine       = "<?php echo isset($notesRec['DischargeSummary']) && isset($notesRec['DischargeSummary']['general_examine']) ? preg_replace( "/\r|\n/", "", $notesRec['DischargeSummary']['general_examine']) : '' ?>";
var complaints    = "<?php echo isset($notesRec['DischargeSummary']) && isset($notesRec['DischargeSummary']['complaints']) ? preg_replace( "/\r|\n/", "", $notesRec['DischargeSummary']['complaints']) : '' ?>";
var investigation = "<?php echo isset($notesRec['DischargeSummary']) && isset($notesRec['DischargeSummary']['investigation']) ? preg_replace( "/\r|\n/", "", $notesRec['DischargeSummary']['investigation']) : '' ?>";
// CodeCreatives
$('.fetch_data').click(function() {
	var param = 'Diagnosis: ' + diagnosis + ', ';
	param += 'Procedure: ' + procedure + ',';
	param += 'Presenting Complaints: ' + complaints + ',';
	param += 'Examination: ' + examine + ',';
	param += 'Investigations: ' + investigation;
	$('.gpt_input').val(param);
});

$('.get_gpt_reply').click(function() {
	/*var input = 'Diagnosis: ' + diagnosis + ', ';
	input += 'Procedure: ' + procedure + ',';
	input += 'Presenting Complaints: ' + complaints + ',';
	input += 'Examination: ' + examine + ',';
	input += 'Investigations: ' + investigation + ',';*/
	var input = $('.gpt_input').val();
	// $('.gpt_input').val(input);

	if (input != '') {
		$.ajax({
        	beforeSend : function() {
        		$("#busy-indicator").show();
        	},
        	complete: function() {
        		$("#busy-indicator").hide();
        	},
        	type: 'POST',
        	url: "/hope/notes/chatGPT",
        	data: {'gpt_input' : input},
        	success: function(response) {
        		var content = $('#optText').text();
	        	content += (content != '') ? '&#13;&#13;' : '';
        		content += `Name: ` + name + `&#13;Gender: ` + sex + ` &#13;Admission ID: ` + admission_id + `&#13;MRN ID: ` + patient_uid + '&#13;Date Of Birth: ' + dob + '&#13;' + response;
        		if (response) {
        			$('#optText').html(content);
        		}
        	},
        });
	}
});

$('.ques').click(function() {
	var question = $(this).attr('data-question');
	var prevVal = $('.gpt_input').val();
	var prevVal = $('.gpt_input').val(prevVal + ', ' + question);
});
// End
$(document).ready(function(){
	$('#dSubmit').hide();
	/*var general ="<?php echo $general?>";
	if(general!=""){
		if(general==0){
			$('#GA').fadeIn();
			$('#RN').fadeOut();
			$('#LS').fadeOut();
		}else if(general==1 || general==2){
			$('#GA').fadeOut();
			$('#RN').fadeIn();
			$('#LS').fadeOut();
		}else if(general==3){
			$('#GA').fadeOut();
			$('#RN').fadeOut();
			$('#LS').fadeIn();
		}else{
			$('#GA').fadeOut();
			$('#RN').fadeOut();
			$('#LS').fadeOut();
		}
	}*/
	$("#ot_date").datepicker({
		showOn : "both",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true,
		dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>', 
	});

	
	$("#ot_notes_date").datepicker({
		showOn : "button",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true,
		dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>', 
	});



	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "add","admin" => false)); ?>";
		$("#post-opt").css('height','auto');	 							 
		$.ajax({  
			  type: "POST",						 		  	  	    		
		  url: ajaxUrl+"/post-opt",
		  data: "updateID=templateArea-post-opt",
		  context: document.body,								   					  		  
		  success: function(data){											 									 					 				 								  		
		   	 	$("#templateArea-post-opt").html(data);								   		
		   	 	$("#templateArea-post-opt").fadeIn();
		  }
		});


	
	$("#pat_name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'IPD',"admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){	
				$( "#patient_id" ).val(ui.item.id);
				$("#surgery_name").focus();
				$("#surgery_name").val('%');
				var patientId=ui.item.id;
				//send ajax request
				  $.ajax({
				      url: "<?php echo $this->Html->url(array("controller" => 'OptAppointments', "action" => "surgeryAutocomplete", "admin" => false)); ?>"+"/"+patientId,
				      context: document.body,          
				      success: function(data){ 
				    	  $('#dSubmit').show();
				    	 $("#surgery_name option").remove(); 
					     data= $.parseJSON(data);
					     $.each(data, function(val, text) {
						    $("#surgery_name").append( "<option value='"+text.id+"'>"+text.value+"</option>" );
						 }); 
			       }
				});
						
			},
			messages: {
		         noResults: '',
		         results: function() {},
		   	},
	
	});
});

$("#operation_notes").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "sentenceComplete","admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){	
				var id_cat=ui.item.id;
				//send ajax request
				  $.ajax({
				      url: "<?php echo $this->Html->url(array("controller" => 'OptAppointments', "action" => "getPackAndSentence", "admin" => false)); ?>"+"/"+id_cat,
				      context: document.body,          
				      success: function(data){ 
				      	 data= $.parseJSON(data);
				      	 var cntHider=0;
				      	 if(data!=''){
				      	 	$('#tdsubCat').show();
				      	 	$.each(data['1'], function(val, text) {
				      	 		if(text!=''){
				      	 			$("#subCat").append( "<option value='"+val+"'>"+text+"</option>" );
				      	 		}else{
				      	 			cntHider++;
				      	 		}
						 	});

						 	var tdConst;
						 	$.each(data['2'], function(val, text) {
				      	 		tdConst="<td colspan=2 class='copytext' id='copytext_main_"+val+"'>"+text+"</td>"+tdConst;
						 	});
						 	$('#tempLoadMain').html(tdConst);
				      	 }
				      	  
				    	  
			       }
				});
						
			},
			messages: {
		         noResults: '',
		         results: function() {},
		   	},
	
	});
	$("#subCat").change(function(){
		var currentId=$(this).val();
		$.ajax({
	      url: "<?php echo $this->Html->url(array("controller" => 'OptAppointments', "action" => "getSentenceData", "admin" => false)); ?>"+"/"+currentId,
	      	context: document.body,          
		    success: function(dataSub){
		    	dataSub= $.parseJSON(dataSub);
		    	var cntHider=0;
		      	 if(dataSub!=''){
		      	 	$('#tdsubsubCat').show();
		      	 	$.each(dataSub['1'], function(val, text) {
		      	 		if(text!=''){
		      	 			$("#subsubCat").append( "<option value='"+val+"'>"+text+"</option>" );
		      	 		}else{
		      	 			cntHider++;
		      	 		}
				 	});

				 	var tdConstSub;
				 	$.each(dataSub['2'], function(val, text) {console.log(text);
		      	 		tdConstSub="<td colspan=2 class='copytext' id='copytext_sub_"+val+"'>"+text+"</td>"+tdConstSub;
				 	});
				 	$('#tempLoadSub').html(tdConstSub);
		      	 }
		    }
		});
	});
	$("#subsubCat").change(function(){
		var currentId=$(this).val();
		$.ajax({
	      url: "<?php echo $this->Html->url(array("controller" => 'OptAppointments', "action" => "getSentenceDataSubSub", "admin" => false)); ?>"+"/"+currentId,
	      	context: document.body,          
		    success: function(dataSubSub){
		    	dataSubSub= $.parseJSON(dataSubSub);
		    	var cntHider=0;
		      	 if(dataSubSub!=''){
		      	 	var tdConstSubSub;
		      	 	$.each(dataSubSub, function(val, text) {
		      	 		tdConstSubSub="<td colspan=2 class='copytext' id='copytext_subsub_"+val+"'>"+text+"</td>"+tdConstSubSub;
				 	});
				 	$('#tempLoadSubSub').html(tdConstSubSub);
		      	 }
		    }
		});
	});

function printOP(){
	if($('#surgery_name').val()==''){
		alert('Please Select Surgery.');
		return false;
	}else{
	 var url="<?php echo $this->Html->url(array('controller' => 'OptAppointments', 'action' => 'operative_notes_print')); ?>"+"/"+$('#patient_id').val()+"/"+$('#surgery_name').val()+"?flag=header";
	}
	 
   window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready
	
}

$('#surgery_name').change(function(){
	submitData();
});

function submitData(){
	var patientId=$( "#patient_id" ).val();
	var optApptId=$( "#surgery_name" ).val();	
	var url="<?php echo $this->Html->url(array('controller' => 'OptAppointments',  'action' => 'operative_notes_ajax')); ?>/"+patientId+"/"+optApptId;
    $.ajax({
      type: 'POST',
      url: url,
      dataType: 'html',
      beforeSend : function() {
              $('#busy-indicator').show('fast');
          },
      success: function(data){
      	data= $.parseJSON(data);
      	if(data['1']!='' && data['1']!=null){
      		$('#id').val(data['1']['id']);
      		$('#anaeDiagnosis').val(data['1']['diagnosis']);
      		$('#anaeSensitivity').val(data['1']['sensitivity']);
      		$('#anaeAnaesthesia1').val(data['1']['anaesthesia_1']);
      		$('#anaeAnaesthesia2').val(data['1']['anaesthesia_2']);			
      		$('#anaeBloodLoss').val(data['1']['blood_loss']);
      		$('#anaeBtGiven').val(data['1']['bt_given']);
      		$('#optText').val(data['1']['operation_notes']);
      		$('#ot_date').val(data['1']['ot_date']);
      		$('#ot_notes_date').val(data['1']['ot_notes_date']);
      		$('#anaeRotating').val(data['1']['rotating']);
      		$('#anaescrubbed').val(data['1']['scrubbed']);
      		$('#anaeTourniquetTime').val(data['1']['tourniquet_time']);
      		$('#routine_emergency').val($.trim(data['1']['routine_emergency']));
      		$('#anaeAssistSurgeon').val(data['1']['assist_surgeon']);
      		$('#anaeOtRoom').val(data['1']['ot_room']);
      	
      		if(data['1']['rotating'] == 1){
      				$('#Rotating').prop('checked', true );

      				//$('#anaeRotating').attr('checked'); // "checked"
      		}
      		if(data['1']['scrubbed'] == '1'){
      			$('#Scrubbed').prop('checked', true );
      				
      		}
      	
      		
      		
      		//$('#optNotes').html(data);
          }else{
          	$('#id').val('');
          	$('#anaeSensitivity').val('');;
      		$('#anaeAnaesthesia1').val('');;
      		$('#anaeAnaesthesia2').val('');			
      		$('#anaeBloodLoss').val('');
      		$('#anaeBtGiven').val('');
      		$('#optText').val('');
      		$('#ot_date').val('');
      		$('#ot_notes_date').val('');
      		$('#anaeRotating').val('');
      		$('#anaescrubbed').val('');
      		$('#anaeTourniquetTime').val('');
          }
          if(data['2']!='' && data['2']!=null){
          	if(data['2']['general']==0)
          		$('#general').val('0');
          	else if(data['2']['general']==1)
          		$('#general').val('1');
          	else if(data['2']['general']==2)
          		$('#general').val('2');
          	else if(data['2']['general']==3)
          		$('#general').val('3');
      		//$('#optNotes').html(data);
          }
          $('#busy-indicator').hide('fast');
      },
      error: function(message){
      },
    });
}

$('#surgery_name').change(function(){
  $('#dSubmit').show();

});
/*$('#general').change(function(){
	var showOpt=$('#general').val();
	if(showOpt==0){
		$('#GA').fadeIn();
		$('#RN').fadeOut();
		$('#LS').fadeOut();
	}else if(showOpt==1 || showOpt==2){
		$('#GA').fadeOut();
		$('#RN').fadeIn();
		$('#LS').fadeOut();
	}else if(showOpt==3){
		$('#GA').fadeOut();
		$('#RN').fadeOut();
		$('#LS').fadeIn();
	}else{
		$('#GA').fadeOut();
		$('#RN').fadeOut();
		$('#LS').fadeOut();
	}

});*/
$(document).on('click', '.copytext', function(){
	var currentID=$(this).attr('id');
	var currentText = $('#optText').val();
	$('#optText').val(currentText+" "+ $('#'+currentID).html());
  });

</script>
