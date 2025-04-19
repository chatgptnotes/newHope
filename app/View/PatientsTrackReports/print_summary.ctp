<?php $apptId = $this->params->query['appt'];
	echo $this->Html->css(array('tooltipster.css','jquery.fancybox-1.3.4.css'));
	echo $this->Html->script(array('jquery.fancybox-1.3.4','jquery.tooltipster.min.js'));
 ?>
<style>
.table_format {
    padding: 0px;
}
.scrolling {
    display: inline-block;
    overflow-x: scroll;
    white-space: nowrap;
    width: 1420px;
}
</style>
<div class="inner_title">
<h3> &nbsp; <?php echo __('Patient Record Details', true); ?></h3>
<span style="margin: -24px 62px !important;">
<?php  if($hideNote=='1'){
			echo $this->Html->link('Edit Signed Document','#',array('onclick'=>'editNotes()','class'=>'blueBtn'));
		}
?>
</span>
<span>
<?php 
if($this->params->query['return']=='power_note'){
echo $this->Html->link(__('Back'),array("controller"=>'PatientForms',"action"=>'power_note',$noteId,$patientId,"?"=>array('appointmentId'=>$this->params->query['appt'])),array('id'=>'labsubmit1','class'=>'blueBtn'));
}else if ($this->params->query['return']=='InitialAssessment'){
	echo $this->Html->link(__('Back'),array("controller"=>'Diagnoses',"action"=>'initialAssessment',$this->params->query['patient_id'],$this->params->query['diagnosesId'],$this->params->query['appt']),array('id'=>'labsubmit1','class'=>'blueBtn'));
}else if ($BackToOPD=='BackToOPD'){
	echo $this->Html->link('Back',array('controller'=>'Appointments','action'=>'appointments_management','?'=>array('from'=>'InitialSoap','pageCount'=>$this->Session->read('opd_dashboard_pageCount'))),array('escape'=>false,'id'=>'backToOpd','title'=>'Back To OPD Dashboard','alt'=>'Back To OPD Dashboard','class'=>'blueBtn'));
}else{
echo $this->Html->link(__('Back'),array("controller"=>'notes',"action"=>'soapNote',$patientId,$noteId),array('id'=>'labsubmit1','class'=>'blueBtn'));	
}
?>

</span>
</div>
<!-- Header Code -->
	<table border="0" class="tabularForm" cellpadding="0" cellspacing="0" width="1200px">
			<tr>
				<th colspan="8">Patient Details</th>
			</tr>
			<tr>
				<td>
					<strong>Patient ID : </strong>
					<?php echo $personData['Person']['patient_uid'];?>
				</td>
				<td >
					<strong>Patient name : </strong>
					<?php echo $personData['Person']['first_name'] .' '.$personData['Person']['middle_name'].' '.$personData['Person']['last_name'];?>
				</td>
				<?php if(!empty($personData['Person']['landmark']))$space=', ';else $space=' '; ?>
				<?php if(!empty($personData['Person']['pin_code']))$space1=', ';else $space1=' '; ?>
				<td >
					<strong>Patient Address : </strong><?php echo $personData['Person']['plot_no'].''.$space.''.$personData['Person']['landmark'].', '.$personData['Person']['city'].', '.$personData['State']['name'].', US'.''.$space1.''.$personData['Person']['pin_code'];
					if(!empty($personData['Person']['zip_four']))
					echo " - ".$personData['Person']['zip_four'];?>
				</td>
				<td >
					<strong>Birth Date : </strong>
					<?php $dob = $this->DateFormat->formatDate2Local($personData['Person']['dob'],Configure::read('date_format_us'),false);
					echo $dob;?>
				</td>
				<td >
					<strong>Gender : </strong>
					<?php echo $personData['Person']['sex'];?>
				</td>	
				<td>
					<strong>Preferred language : </strong>
					<?php echo $language[$personData['Person']['preferred_language']];?>
				</td>
				<td>
				</td>
			</tr>
	</table>
<!-- Header Code  EOd-->
<table  border="0" width="1200px">
	<tbody>
		<tr style="background-color: #DDDDDD;"> 
			<td colspan="8">
				<strong>Encounters Of Patient:</strong> 
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr style="background-color: #DDDDDD;">
					<?php $selectAll  ='<b>Select All</b>';?>
						<td class='tooltip' title="<?php echo $selectAll;?>">
							<?php echo $this->Form->input('',array('type'=>'checkbox','id'=>'selectAll','label'=>false,'div'=>false,'autocomplete'=>'off'))?>
						</td>
						<?php 
						//debug($allIDs);
						foreach($allIDs as $key => $data){?>
				  	 	<td style="text-align: center;">
				  	 	<?php 
				  	 		echo $this->Html->link($this->DateFormat->formatDate2LocalForReport($data['Appointment']['date'],Configure::read('date_format')),'javascript:void(0)',array('onclick'=>'getAllRecord("'.$data['Patient']['id'].'","'.$data['Note']['id'].'","'.$data['Appointment']['id'].'")','class'=>'BlueBtn singleEncLink','label'=>false));?>
				  	 		&nbsp;
						<?php echo $this->Form->input('',array('type'=>'checkbox','id'=>'checkEcounter_'.$data['Patient']['id'],'class'=>'checkEcounter',
								'patientId'=>$data['Patient']['id'],
								'personId'=>$personId,
								'noteId'=>$data['Note']['id'],
								'appointmentId'=>$data['Appointment']['id'],'div'=>false,'autocomplete'=>'off'));?>
						</td>
						 
						<?php }?>
						<?php $multiplePrint  ='<b>Multiple Print</b>';?>
						<td id='chkPrint' class='tooltip' style="display: none;" style="background-color: #DDDDDD;" title='<?php echo $multiplePrint?>'>
							<?php echo $this->Html->link($this->Html->image('icons/printer_summary.png'),'#',
							array('id'=>'chechBoxSubmit','div'=>false,'escape'=>false,'style'=>'margin-left:5px'));"&nbsp"?>
						</td>
					</tr>
				</table>
			</td>
			
			<?php if(!empty($allIDs)){?>
			<?php $printAllEncounter  ='<b>Print All Encounter</b>';?>
		  	 <td id="allEcnLink" class='tooltip' style="background-color: #DDDDDD;" width="100%" title='<?php echo $printAllEncounter;?>'>
		  	 	<?php //echo $this->Html->link('Print Record of all encounter','javascript:void(0)',array('onclick'=>'getAllEncounterRecord("'.$data['Patient']['id'].'")','class'=>'BlueBtn allEncLink','label'=>false));?>
		  	 	<?php echo $this->Html->link($this->Html->image('icons/jet_printer.png'),'#',
		  	 			array('id'=>'printAllEncounter','class'=>'allEncLink','patientId'=>$data['Patient']['id'],'div'=>false,'escape'=>false,'style'=>'margin-left:5px'));?>
			</td>
			<?php }?>
		</tr>
	</tbody>
</table>
  <div id ="totalIds"></div>
  <script>
  $( document ).ready(function () {
	$('.tooltip').tooltipster({
		interactive:true,
		position:"right", 
	});


	$("#selectAll").change(function(){
		if($(this).is(':checked')){
			$('.checkEcounter').each(function() { 	 
	        	this.checked = true;  //select all checkboxes with same class   
	        	$("#chkPrint").show();
				$("#allEcnLink").hide();      
	        });
		}else{
			$('.checkEcounter').each(function() { 	//loop through each checkbox
	        	this.checked = false;  //uncheck all checkboxes with same class     
	        	$("#chkPrint").hide();
				$("#allEcnLink").show();          
	        });
		}
	});

	$("#printAllEncounter").click(function(){
		var patientID = $(this).attr('patientId');
		getAllEncounterRecord(patientID);
	});
 
 });
  function getAllRecord(pateintid,noteId,apptId){
  	if(noteId==''){
  		//alert('Notes are not added for this Encounter');
  	}
  	$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("action" => "getAllRecord", "admin" => false)); ?>"+"/"+pateintid+"/"+'<?php  echo $personId;?>'+"/"+apptId+"/"+noteId,
			  context: document.body,
			  beforeSend:function(){$("#busy-indicator").show();},	
			  success: function(data){ 	
				  $("#busy-indicator").hide();	
				  $('#totalIds').html(data);  
			  },
			  	  
		});
  }
  function getAllEncounterRecord(pateintid){
  	$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("action" => "getAllEncounterRecord", $personId, "admin" => false)); ?>",
			  context: document.body,
			  beforeSend:function(){$("#busy-indicator").show();},	
			  success: function(data){ 	
				  $("#busy-indicator").hide();	
				  $('#totalIds').html(data);  
			  },
			  	  
		});
  }

  
  $(function(){  //enable pay bill if any pay now checkbox get checked
		$(".checkEcounter").click( function() {
			var checked = ''; 
			$(".checkEcounter").each(function(){
				if ($(this).is(":checked")){
					checked = 1;
					return false;
				}
			});
			if(checked == 1){
				$("#chkPrint").show();
				$("#allEcnLink").hide();
			}else{
				$("#chkPrint").hide();
				$("#allEcnLink").show();
			}
		 });
	});
	
	$("#chechBoxSubmit").click(function(){
	 
		var chkeckBoxArray = new Array();
		$(".checkEcounter").each(function(){
			if($(this).is(':checked'))
			{
				 
				var patientId = $(this).attr('patientId');
				var personId = $(this).attr('personId');
				var noteId =  $(this).attr('noteId');
				var appointmentId =  $(this).attr('appointmentId');
				 
				var item = { patientId : patientId, personId: personId , noteId : noteId , appointmentId : appointmentId};
				chkeckBoxArray.push(item);
					
			}
			
		});
		
		AjaxUrl = "<?php echo $this->Html->url(array('action' => 'getAllCheckedEncounters'));?>";
		$.ajax({
			type : "POST",
			data : "chkeckBoxArray=" + JSON.stringify(chkeckBoxArray),
			url  : AjaxUrl,
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success:function(data){
				$('#busy-indicator').hide();
				$('#totalIds').html(data);  
			}	
			});
	 
	});
	$(".singleEncLink,.allEncLink").click(function(){
		$(".checkEcounter").each(function(){
			if($(this).is(':checked'))
			{
				$('input:checkbox').attr('checked',false);
				$("#chkPrint").hide();
				$("#allEcnLink").show();
			}
			  
		});
	});
function editNotes(){
	var apptId='<?php echo $soapApptID?>';
	//soapPatientID  soapNoteID soapApptID
	var BackToOPD ="<?php echo BackToOPD ?>";
	if(apptId==''){
		apptId='<?php echo $_SESSION[apptDoc]?>';
	}
		$.fancybox({

			'width' : '50%',
			'height' : '50%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "editSignNotes",$soapPatientID,$soapNoteID,$soapApptID)); ?>",
			 	
		});

}	

	 
  </script>
 