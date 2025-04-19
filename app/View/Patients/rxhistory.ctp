<?php 
echo $this->Html->css(array(/*'internal_style.css',*/'jquery.contextMenu'));
echo $this->Html->script(array(/*'jquery-1.5.1.min',*/'inline_msg','jquery.blockUI','jquery.contextMenu'));
$freq=Configure :: read('frequency');
$route_admin=Configure :: read('route_administration');
$freq_fullform=Configure :: read('frequency_fullform');
?>
<style>
	.green{
		color:green ;
	}
	.black{
		color:black ;
	}
.rightTopBg {
height: auto;
padding: 0 20px;
width: 100%;
}
	
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Prescription List', true); ?>
	</h3>
	<span align="right"> <?php echo $this->Html->link(__('Back', true),array('controller' => 'appointments', 'action' => 'appointments_management'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<p class="ht5"></p>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" style="">
	<tr>
		<td width='80px'></td>
		<td valign='top'></td>
	</tr>
	<tr>
		
		<div style="padding-left: 17px; padding-bottom:10px;" colspan="5"><strong>Current Medications</strong></div>
	</tr>
		
	<tr>
	<td>
	   <div class="inner_content" style="width:600px; float:left; padding-bottom:10px; padding-left:10px;">
		<div class="" id="boxSpace" style="float:left;padding: 0 10px;" width="10%"><?php
			if(($alltookkMedications['NewCropPrescription']['took_medication'])=='1'){			
				$displayGreen='block';
				$displayRed='none';
				$tookMedicationChk = true;
			}else{
				$displayGreen='none';
				$displayRed='block';
				$tookMedicationChk = false;
			}
			echo $this->Html->image('/img/icons/green.png',array('style'=>"display:$displayGreen",'id'=>'green_bullet','class'=>'took_medication_bullet')); 
			echo $this->Html->image('/img/icons/red.png',array('style'=>"display:$displayRed",'id'=>'red_bullet','class'=>'took_medication_bullet'));
			echo $this->Form->input('took_medication',array('style'=>"display:none",'type'=>'checkbox','id'=>'took_medication','label'=>false,'checked'=>$tookMedicationChk));
			echo $this->Form->hidden('NewCropPrescription.patient_uniqueid',array('value'=>$patientId,'id'=>'patient_uniqueid'));?></div>
		<div  class="tdLabel" id="boxSpace" style="" width="70%">Patient is taking Medications as Prescribed</div>	
        </div>
        </td>			
	</tr>
	<tr>
	<td>
	  <div style="width:700px; float:left">
		<div class=""  id="boxSpace"  style="float:left;padding: 0 10px 0 20px; width="10%">
		<?php if(($allHealthMedications['NewCropPrescription']['health_literacy'])=='1'){					
				$displayHealthGreen='block';
				$displayHealthRed='none';
				$checkedHealthChk = true;
			}else{						
				$displayHealthGreen='none';
				$displayHealthRed='block';
				$checkedHealthChk = false;
			}
			echo $this->Html->image('/img/icons/green.png',array('style'=>"display:$displayHealthGreen",'id'=>'green_bullet_literacy','class'=>'health_literacy_bullet')); 
			echo $this->Html->image('/img/icons/red.png',array('style'=>"display:$displayHealthRed",'id'=>'red_bullet_literacy','class'=>'health_literacy_bullet'));
			echo $this->Form->input('health_literacy', array('style'=>"display:none",'type'=>'checkbox','id' => 'health_literacy','label'=>false,'checked'=>$checkedHealthChk));?></div>
			<div class="tdLabel" id="boxSpace" style="" width="70%">Medication Information is Explained to the Patient considering their Health Literacy and Date Stamps</div>
			</div>		
			</td>
	</tr>
	<tr>
		
		<td colspan="2"><?php echo $this->Form->create('rxhistory',array('id'=>'rxhistory','url'=>array('controller'=>'Patients','action'=>'rxhistory',$patientId,$patientUid),
                               'inputDefaults' => array( 'label' => false,'div' => false, 'error'=>false )));?>
			<table border="0" class="table_format" cellpadding="0"
				cellspacing="0" width="100%">
				<tr class="row_title">
					<td class="table_cell"><strong></strong></td>
					<td class="table_cell"><strong><?php echo __('Medication Name', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Prescription Date', true); ?>
					</strong></td>
				 	<td class="table_cell"><strong><?php echo __('Modified Date', true); ?>
					</strong></td> 
					<td class="table_cell"><strong><?php echo __('Status', true); ?> </strong>
					</td>
					<td class="table_cell"><strong><?php echo __('Route', true); ?> </strong>
					</td>
					<td class="table_cell"><strong><?php echo __('Frequency', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('To be administered in clinic now?', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Administered', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Patient refuses medication', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Prescribed By', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Prescribed When', true); ?>
					</strong></td>
				</tr>
				<?php 
				$count=1;
				$toggle =0;
				$cnt_comm = 0;
				$administeredCount =0;
				$medsToAdminister = 0;
				$role = $this->Session->read('role');
				foreach($allMedications as $medications){
				//	if($medications['NewCropPrescription']['patient_uniqueid'] == $patientId){
						$cnt_comm++;
						if($toggle == 0) {
							echo "<tr>";
							$toggle = 1;
						}else{
							echo "<tr>";
							$toggle = 0;
						}
						$id=$medications['NewCropPrescription']['id'];//newcrop id
						$date_prescription=explode("-",$medications['NewCropPrescription']['date_of_prescription']);
						$datePrescription=$date_prescription["1"]."/".substr($date_prescription["2"],0,2)."/".$date_prescription["0"];
						$ModifiedDate=explode(" ",$medications['NewCropPrescription']['modified']);
						$ModifiedDate=explode("-",$ModifiedDate["0"]);
						if($ModifiedDate["1"]!="00")
						  $ModifiedDateFinal=$ModifiedDate["1"]."/".$ModifiedDate["2"]."/".$ModifiedDate["0"];
						else
							$ModifiedDateFinal="";
						//find frequency
						?>
				<td class="row_format" valign="top"><?php echo $count; ?>
				</td>
				<td>	
				<div class="context-menu-three row_format" style="text-decoration:underline;" id="<?php echo $medications['NewCropPrescription']['id']?>">
  				<?php if (!empty($medications['NewCropPrescription']['description'])){
					echo ucwords(stripslashes($medications['NewCropPrescription']['description']));
				}else{
					echo $medications['NewCropPrescription']['drug_name'];
				}
				?>
				</div>
				</td>
				<td class="row_format">&nbsp;<?php if(!empty($medications['NewCropPrescription']['date_of_prescription']))
					echo $datePrescription;
				else
					echo __('Unknown');  ?>
				</td>
		
				 <td class="row_format"><?php echo $ModifiedDateFinal;?></td> 
				<td class="row_format">&nbsp;<?php echo $status = ($medications['NewCropPrescription']['archive'] == 'N') ? 'Active' : 'Dis-continued';  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo ucwords($route_admin[$medications['NewCropPrescription']['route']]);  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $freq_fullform[$medications['NewCropPrescription']['frequency']];  ?>
				</td>
				<?php $isAdminister = $medications['NewCropPrescription']['is_med_administered'];
				$checkedMed = ($isAdminister == '1' or $isAdminister == '2') ? true : false;
				$nurseCheck = ($isAdminister == '2') ? true : false;
				$medsToAdminister = ($checkedMed) ? $medsToAdminister+=1 : $medsToAdminister;
				$administeredCount = ($nurseCheck) ? $administeredCount+=1 : $administeredCount;
				$disableChkMed = ($nurseCheck/* || $role==Configure::read('nurseLabel')*/) ? true : false;
				?>				
				<td class="row_format"><?php 
				if($role==Configure::read('nurseLabel')){											
						$disabledByNurse = ($medications['NewCropPrescription']['is_med_administered']=='1') ? true : false;						
					echo $this->Form->checkbox('NewCropPrescription.is_med_administered',array('id'=>'doctorcheck_'.$id,'style'=>'float:left','checked'=>$checkedMed,'class'=>'administeredByDoctor','disabled'=>$disabledByNurse));
				}else{
					echo $this->Form->checkbox('NewCropPrescription.is_med_administered',array('id'=>'doctorcheck_'.$id,'style'=>'float:left','checked'=>$checkedMed,'class'=>'administeredByDoctor','disabled'=>$disableChkMed));
				}?>
				<?php //if($role==Configure::read('nurseLabel')){		
				 $displayLink=($medications['NewCropPrescription']['is_med_administered']=='1')?'block':'none';
				?>
				<div id="verifyLink_<?php echo $id;?>" style="display:<?php echo $displayLink;?>"><span><?php
				if($role==Configure::read('doctor')){ 				
				if(in_array($medications['NewCropPrescription']['id'],$getVerifyMedicationOrderId)){					
					$getVar=1;				
				if((!empty($getVerifyMedicationOrderId[$count-1]['VerifyMedicationOrder']['newcrop_id']) || ($getVar=='1' AND ($role==Configure::read('doctor')))|| $role==Configure::read('nurseLabel'))){				 
					echo $this->Html->link('Verify Order',array('controller'=>'Patients','action'=>'verifyOrderMedication',$patientId,$appId,$medications['NewCropPrescription']['id'],$getVerifyMedicationOrderId[$count-1]['VerifyMedicationOrder']['id']),array('target'=>'_blank','style'=>"padding-left: 10px; font-style: italic; text-decoration: underline;"));
				}
				}
				}else{
				//if($role==Configure::read('nurseLabel')){
					echo $this->Html->link('Verify Order',array('controller'=>'Patients','action'=>'verifyOrderMedication',$patientId,$appId,$medications['NewCropPrescription']['id'],$getVerifyMedicationOrderId[$count-1]['VerifyMedicationOrder']['id']),array('target'=>'_blank','style'=>"padding-left: 10px; font-style: italic; text-decoration: underline;"));
				//}					
				}?></span></div>
				
				</td>
				<?php $disabled = (($role==Configure::read('doctorLabel')||$role==Configure::read('nurseLabel'))) ? false : true;?>
				<?php $disabled = ($checkedMed && !$disabled) ? false : true;?>
				<td class="row_format"><?php echo $this->Form->checkbox('NewCropPrescription.nurseAdministered',array('id'=>'nurseCheck_'.$id,'style'=>'float:left','checked'=>$nurseCheck,'class'=>'administeredByNurse','disabled'=>$disabled));?>
				</td>
				<td class="row_format"><?php $refusetotakeimmunizationchk = ($medications['NewCropPrescription']['refusetotakeimmunization'] == '1') ? true : false;
				echo $this->Form->checkbox('NewCropPrescription.refusetotakeimmunization',array('id'=>'refusetotakeimmunization_'.$id,'style'=>'float:left','class'=>'refusetotakeimmunization','checked'=>$refusetotakeimmunizationchk));?>
				</td>				
				<td class="row_format"><?php echo $medications['User']['first_name'].' '.$medications['User']['last_name']; ?>			
				</td>
				<td class="row_format"><?php			
				$d_start    = new DateTime($medications['NewCropPrescription']['created']);
				$d_end      = new DateTime(date('Y-m-d H:i:s'));
				$diff = $d_start->diff($d_end);			
				$getH=$diff->h;
				$getI=$diff->i;
				if($getH <= 0 && $getI<=30){
					echo 'Just Now';
				}else{
					echo $this->DateFormat->formatDate2Local($medications['NewCropPrescription']['created'],Configure::read('date_format'),true); ;
				}
				
			?>
				</td>
				<?php $count++;	 
				//	}
				}
				?>
			</table> <?php if($cnt_comm == 0){?>
			<table align="center">
				<tr>
					<td text-align="center" style="color: red"><?php echo "There are no recorded medications for this patient for current encounter." ?>
					</td>
				</tr>
			</table> <?php } ?>
		</td>
	</tr>
	<div>
		
		<td style="padding-left: 17px; font-size:13px;" colspan="5"><strong>Past Medications</strong></td>
	</div>
	<tr>
		
		<div><?php echo $this->Form->create('rxhistory',array('id'=>'rxhistory','url'=>array('controller'=>'Patients','action'=>'rxhistory',$patientId,$patientUid),
                               'inputDefaults' => array( 'label' => false,'div' => false, 'error'=>false )));?>
			<table border="0" class="table_format" cellpadding="0"
				cellspacing="0" width="100%">
				<tr class="row_title">
					<td class="table_cell"><strong></strong></td>
					<td class="table_cell"><strong><?php echo __('Medication name', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Prescription date', true); ?>
					</strong></td>
					<!--<td class="table_cell"><strong><?php echo __('Drug Id', true); ?>
					</strong></td>-->
					<td class="table_cell"><strong><?php echo __('Status', true); ?> </strong>
					</td>
					<td class="table_cell"><strong><?php echo __('Route', true); ?> </strong>
					</td>
					<td class="table_cell"><strong><?php echo __('Frequency', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Last Dose Taken', true); ?>
					</strong></td>
				</tr>
				<?php 
				$count=1;
				$toggle =0;
				$cnt_comm = 0;
				foreach($allPastMedications as $medications){

				//	if($medications['NewCropPrescription']['patient_uniqueid'] == $patientId){
						$cnt_comm++;
						if($toggle == 0) {
							echo "<tr>";
							$toggle = 1;
						}else{
							echo "<tr>";
							$toggle = 0;
						}
						$id=$medications['NewCropPrescription']['id'];//newcrop id
						
						$date_prescription=explode("-",$medications['NewCropPrescription']['date_of_prescription']);
						$datePrescription=$date_prescription["1"]."/".substr($date_prescription["2"],0,2)."/".$date_prescription["0"];
						
						$last_dose=$this->DateFormat->formatDate2Local($medications['NewCropPrescription']['last_dose'],Configure::read('date_format'),false);
						?>
				<td class="row_format" valign="top"><?php echo $count; ?>
				
				<td class="row_format">&nbsp;<?php if (!empty($medications['NewCropPrescription']['description'])){
					echo ucwords(stripslashes($medications['NewCropPrescription']['description']));
				}else{
					echo $medications['NewCropPrescription']['drug_name'];
				}
				?>
				</td>
				<td class="row_format">&nbsp;<?php if(!empty($medications['NewCropPrescription']['date_of_prescription']))
					echo $datePrescription;
				else
					echo __('Unknown');  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $status = ($medications['NewCropPrescription']['archive'] == 'N') ? 'Active' : 'Discontinued';  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo ucwords($route_admin[$medications['NewCropPrescription']['route']]);  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $freq_fullform[$medications['NewCropPrescription']['frequency']];  ?>
				</td>

				<td class="row_format">&nbsp;<?php if(!empty($medications['NewCropPrescription']['last_dose']))
					echo $last_dose;
				else
					echo __('Unknown');   ?>
				</td>
				<?php $count++;	 
					//}
				}
				?>
			</table> </div><?php if($cnt_comm == 0){?>
			<table align="center">
				<tr>
					<td text-align="center" style="color: red"><?php echo "There are no past medication recorded for this patient." ?>
					</td>
				</tr>
			</table> <?php } ?>
		</td>
	</tr>
	<!--<tr>
		<td width='20px'></td>
		<td style="padding-left: 17px"><strong>Previous Medications</strong></td>
	</tr>-->
	<tr>
		<td width='20px'></td>
		<td>
			<table border="0" class="table_format" cellpadding="0"
				cellspacing="0" width="100%" style="display:none">
				<tr class="row_title">
					<td class="table_cell"><strong>Sr. #</strong></td>
					<td class="table_cell"><strong><?php echo __('Medication name', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Prescription date', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Rx Norm', true); ?> </strong>
					</td>
					<td class="table_cell"><strong><?php echo __('Status', true); ?> </strong>
					</td>
					<td class="table_cell"><strong><?php echo __('Route', true); ?> </strong>
					</td>
					<td class="table_cell"><strong><?php echo __('Frequency', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Start date', true); ?>
					</strong></td>
					<td class="table_cell"><strong><?php echo __('Stop date', true); ?>
					</strong></td>
				</tr>
				<?php 
				$count=1;
				$toggle =0;
				$cnt_comm = 0;
				foreach($allMedications as $medications){
					if($medications['NewCropPrescription']['patient_uniqueid'] < $patientId){
						$cnt_comm++;
						if($toggle == 0) {
						echo "<tr>";
						$toggle = 1;
					}else{
						echo "<tr>";
						$toggle = 0;
					}
					
					$date_prescription=explode("-",$medications['NewCropPrescription']['date_of_prescription']);
					$datePrescription=$date_prescription["1"]."/".substr($date_prescription["2"],0,2)."/".$date_prescription["0"];
					?>
				<td class="row_format">&nbsp;<?php echo $count; ?>
				
				<td class="row_format">&nbsp;<?php echo ucwords(stripslashes($medications['NewCropPrescription']['description'])); ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $datePrescription; ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $medications['NewCropPrescription']['rxnorm'];  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $status = ($medications['NewCropPrescription']['archive'] == 'N') ? 'Active' : 'Discontinued';  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo ucwords($medications['NewCropPrescription']['route']);  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $medications['NewCropPrescription']['frequency'];  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $this->DateFormat->formatDate2Local($medications['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $this->DateFormat->formatDate2Local($medications['NewCropPrescription']['stopdose'],Configure::read('date_format'),true);  ?>
				</td>
				</tr>
				<?php $count++;	 
					}
				}
				?>
			</table> <?php if($cnt_comm == 0){?>
			<table align="center" style="display:none">
				<tr>
					<td text-align="center" style="color: red"><?php echo "There are no recorded medications for this patient for previous encounter." ?>
					</td>
				</tr>
			</table> <?php } ?>
		</td>
	</tr>
</table>
<script>
$(document).ready(function(){
	 $("input[type=submit]").attr("disabled","disabled");
	$('#mCheck').click(function(){
		 $("input[type=submit]").removeAttr("disabled");
	});

	var chkCount = (parseInt("<?php echo $administeredCount?>")) ? parseInt("<?php echo $administeredCount?>") : 0;
	$('.administeredByNurse, .administeredByDoctor').click(function (){
		var medsToAdminister = parseInt("<?php echo $medsToAdminister?>");
		var currentId = $(this).attr('id') ;
		var splittedVar = currentId.split("_");	
		var patientId = '<?php echo $patientId; ?>';
		var status;
		if(splittedVar[0] == 'nurseCheck'){
			if(!$('#'+currentId).is(':checked')){
				inlineMsg(currentId,'Medication already administered');				
				return false;
			}else{
				chkCount = chkCount+1;
				$('#doctorcheck_'+splittedVar[1]).attr('disabled','disabled');
				status = 2;
			}
		}else{
			if(!$('#'+currentId).is(':checked')){				
				$('#nurseCheck_'+splittedVar[1]).attr('disabled','disabled');
				inlineMsg(currentId,'Medication already administered');
				medsToAdminister = medsToAdminister-1;
				status = null;									
			}else{				
				$('#nurseCheck_'+splittedVar[1]).attr('disabled',false);
				var getMedicalAssRole="<?php echo $roleMedical;?>"; 
				if(getMedicalAssRole=='Medical Assistant'){
				$('#doctorcheck_'+splittedVar[1]).attr('disabled','disabled');
				}
				status = 1;
				medsToAdminister = medsToAdminister+1;	
				//$('#verifyLink_'+splittedVar[1]).show();	
						
			}
		}
		if(!$('#'+currentId).is(':checked')){		
			$('#verifyLink_'+splittedVar[1]).hide();
		}else{
			$('#verifyLink_'+splittedVar[1]).show();
		}
		 $.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "updateIsMedAdministered", "admin" => false)); ?>"+"/"+patientId+"/"+splittedVar[1],
			  context: document.body,
			  data: "status="+status,
			  success: function(data){ 
				  inlineMsg(currentId,'Medication has been administered');
				  if(chkCount == medsToAdminister && (splittedVar[0] == 'nurseCheck'))
					  window.parent.$('.MEDUNIQUECLASS_'+patientId).removeClass("redBulb greenBulb greyBulb").addClass("greenBulb");
				  if(chkCount == medsToAdminister && (splittedVar[0] == 'doctorcheck'))
					  window.parent.$('.MEDUNIQUECLASS_'+patientId).removeClass("redBulb greenBulb greyBulb").addClass("greenBulb");
				  if(medsToAdminister > chkCount && (splittedVar[0] == 'doctorcheck'))
					  window.parent.$('.MEDUNIQUECLASS_'+patientId).removeClass("redBulb greenBulb greyBulb").addClass("redBulb");
				  if(medsToAdminister == chkCount && (splittedVar[0] == 'doctorcheck'))
					  window.parent.$('.MEDUNIQUECLASS_'+patientId).removeClass("redBulb greenBulb greyBulb").addClass("greyBulb");
			  }
		});	
	});
	$('.refusetotakeimmunization').click(function (){
		var currentId = $(this).attr('id') ; 
		var splittedVar = currentId.split("_");	
		var patientId = '<?php echo $patientId; ?>';
		var status;
		if($( '#refusetotakeimmunization_'+splittedVar[1] ).is(':checked') == true) {
			status=1;
	    }else{	    	
	    	status=0;
	    }
		 $.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "refuseTakeImmunization", "admin" => false)); ?>"+"/"+patientId+"/"+splittedVar[1],
			  context: document.body,
			  data: "refusetotakeimmunization="+status,
			  success: function(data){ 
				  inlineMsg(currentId,'updated successfully');				 
			  }
		});	
	});
	
	
});	

var menuItemArray = <?php echo $checkStatus?>; // rightclick menu item array medication wise
$ (function(){
	
    $.contextMenu({
        selector: '.context-menu-three', 
        callback: function(key, options) { 
        	currentId = key;
        	var splitted = currentId.split("-");
        	var medId = $(this).attr('id');
        	var value;
        	if(menuItemArray[medId][key].className=='green'){
           		menuItemArray[medId][key].className = 'black';
    			value=0;
    		}else{
    			menuItemArray[medId][key].className = 'green';
    			value=1;
    		}
            $.ajax({
			  	type : "POST",
			  	url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "updateMedicationRgtClk", "admin" => false)); ?>",
	  			context: document.body,
	  			data:"id="+medId+"&field="+splitted[0]+"&value="+value,
	  			success: function(data){
	  				onCompleteRequest();
	  			}		  			  
  			});
		 	return true;           
       },
       build: function($trigger, e) {
           // this callback is executed every time the menu is to be shown
           // its results are destroyed every time the menu is hidden
           // e is the original contextmenu event, containing e.pageX and e.pageY (amongst other data)
           var currentElement = $(e.currentTarget).attr('id');
         	return {	                
               items: menuItemArray[currentElement] // assign revised options to contextmenu
           };
       },
       events: {
            show: function(opt) {
                // this is the trigger element
                var $this = this;
                // import states from data store 
                $.contextMenu.setInputValues(opt, $this.data());
               // this basically fills the input commands from an object
           }, 
            hide: function(opt) {
                // this is the trigger element
                var $this = this;
                // export states to data store
                 $.contextMenu.getInputValues(opt, $this.data());
           }
        }
    });
});

$('.took_medication_bullet').click(function (){
	var toggleId = $(this).attr('class');
	var id= $(this).attr('id');
	var patientUniqueid=$("#patient_uniqueid").val();
	var value;
	if(id=='green_bullet'){
		$('#took_medication').attr('checked', false);
		value=0;
    }else if(id=='red_bullet'){
    	$('#took_medication').attr('checked', true);
    	value=1;
    }
	$('.'+toggleId).toggle();
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "updateTookMedMedicationCheck", "admin" => false)); ?>",
		  context: document.body,
		  data:"id="+patientUniqueid+"&value="+value,
		 success: function(data){ 
	     	onCompleteRequest();
		 }		  			  
	});
  	 return true;     
});  
$('.health_literacy_bullet').click(function (){
	var toggleId = $(this).attr('class');
	var id= $(this).attr('id');
	var patientUniqueid=$("#patient_uniqueid").val();
	var value;
	if(id=='green_bullet_literacy'){
		$('#health_literacy').attr('checked', false);
		value=0;
    }else if(id=='red_bullet_literacy'){
    	$('#health_literacy').attr('checked', true);
    	value=1;
    }
  
	$('.'+toggleId).toggle();
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "updateTookHealthLiteracyCheck", "admin" => false)); ?>",
		  context: document.body,
		  data:"id="+patientUniqueid+"&value="+value,
		 success: function(data){ 
			  onCompleteRequest();
			 // obj.attr('src','../theme/Black/img/icons/green.png').attr('title','Medication Administered').removeClass('med');
		  }		  			  
	});
	 return true; 
});  
</script>