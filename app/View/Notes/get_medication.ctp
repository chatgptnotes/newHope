<?php echo $this->Html->script(array('inline_msg.js'));?>
<style>
.trShow {
	background-color: #ccc;
}
</style>
<table width="100%" class="formFull formFullBorder">
	<tr>
		<td style="text-align: left; font-weight: bold; background: #d2ebf2 repeat-x; padding: 5px 0 5px 10px;" colspan="5">Medication Records</td>
	</tr>
	<?php $reconchecked='checked';
	if(empty($data)){
		$reconchecked='';
	}
	foreach($data as $reconData){
		if($reconData['NewCropPrescription']['is_reconcile']=='0'){
			$reconchecked='';
		}
	}?>
	<tr>
		<td style="text-align: left;"><?php 
		if(!empty($data)){$disabled='disabled';
		$disabled1='';
		}else{$disabled='';
$disabled1='disabled';

			if(empty($getcheckmed)){
				if($checkDiagnosis['Diagnosis']['no_med_flag']=='yes'){
					$checked='checked';
				}elseif($checkDiagnosis['Diagnosis']['no_med_flag']=='no'){
					$checked='';
				}
			}else{
				if($getcheckmed['Note']['no_med_flag']=='yes'){
					$checked='checked';
				}elseif($getcheckmed['Note']['no_med_flag']=='no'){
					$checked='';
				}
			}
		}
		echo $this->Form->checkbox('',array('name'=>'nomedcheck','id'=>'nomedcheck','checked'=>$checked,'onclick'=>'javascript:save_checkmed();','disabled'=>$disabled));?> No known active medication &nbsp;&nbsp;&nbsp;
		<?php echo $this->Form->checkbox('',array('name'=>'reconcilecheck','id'=>'reconcilecheck','checked'=>$reconchecked,'onclick'=>'javascript:save_reconcilecheck();','disabled'=>$disabled1));?> Medications Reconciled By Providers</td>
		<td style="text-align: right" colspan='2'><span id='newPrint' style=" height:25px!important; padding:3px;" class="blueBtn"><a href="javascript:newPrint()">Print Prescription</a></span></td>
	</tr>
	<tr class="trShow">
		<td style="padding: 5px 0 5px 10px;">Drug Name</td>
		<td style="padding: 5px 0 5px 33px; text-align:left;" width="16%">Info Button</td>
		<td style="padding: 5px 0 5px 10px;"><?php echo " ";?></td>
	</tr>

	<?php  foreach($data as $key=>$subData){ //debug($subData);?>
	<tr>
		<td width="70%"><?php if(empty($subData['NewCropPrescription']['drug_id'])){
			$pt_id=$subData['NewCropPrescription']['patient_uniqueid'];
			$med_id=$subData['NewCropPrescription']['id'];
			$flag='notPresent';
			echo $this->Html->link($this->Html->image('icons/exlpoint.jpeg',array('title'=>'Drug is not present in our database, so select alternate drug.','alt'=>'Remove')),
				array('controller'=>'Notes','action'=>'addMedication',$subData["NewCropPrescription"]["patient_uniqueid"],$subData['NewCropPrescription']['id'],'null','null',$noteId,'?'=>array('flag'=>$flag)),array('id'=>'','class'=>'alternateMed','escape' => false,'style'=>'float:left;'));
			}?>&nbsp;<?php
		
		if(!empty($subData['VaccineDrug']['MEDID'])){
$vax=" (".Vaccine.")";
}
		echo $this->Html->link(ucfirst($subData['NewCropPrescription']['description'].$vax),array('controller'=>'Notes','action'=>'addMedication',$subData["NewCropPrescription"]["patient_uniqueid"],$subData['NewCropPrescription']['id'],'null','null',$noteId),array('alt'=>'Edit','title'=>'Edit'));

		//echo $this->Html->link($subData['NewCropPrescription']['description'],'javascript:void(0)',
				//array('onClick'=>'editMedication('.$subData["NewCropPrescription"]["patient_uniqueid"].','.$subData["NewCropPrescription"]["id"].')','alt'=>'Edit','title'=>'Edit'));?>
		</td>
		<td width="30%" style="padding-left:50px;"><?php echo $this->Html->link($this->Html->image('icons/infobutton.png',array('class'=>'infomedication','id'=>$subData['NewCropPrescription']['drug_id']."_".$subData['NewCropPrescription']['id'])),"javascript:void(0)",
				array('escape'=>false))?></td>
		<td width="30%"><?php echo $this->Form->checkbox('',array('name'=>'medCheck','id'=>$key,'value'=>$subData['NewCropPrescription']['id'],'class'=>'medCheckClass'));?>
		</td>

	</tr>
	<?php }?>
	<?php if(empty($data)){?>
	<tr>
		<td style="padding: 5px 0 5px 10px;"><?php 
		echo __('No records found');?></td>
	</tr>
	<?php }?>
</table>
<table width="100%" class="formFull formFullBorder">
	<tr>
		<td style="text-align: left; font-weight: bold; background: #d2ebf2 repeat-x; padding: 5px 0 5px 10px;" colspan="5">Allergy Records</td>
	</tr>
	
	<tr>
		<td style="text-align: left;"><?php 
			if(!empty($dataAllergy)){$disable='disabled';
			}else{$disable='';
	
				if(empty($getcheckmed)){
					if($checkDiagnosis['Diagnosis']['no_allergy_flag']=='yes'){
						$check='checked';
					}elseif($checkDiagnosis['Diagnosis']['no_allergy_flag']=='no'){
						$check='';
					}
				}else{
					if($getcheckmed['Note']['no_allergy_flag']=='yes'){
						$check='checked';
					}elseif($getcheckmed['Note']['no_allergy_flag']=='no'){
						$check='';
					}
				}
			}
			echo $this->Form->checkbox('',array('name'=>'noallergycheck','id'=>'noallergycheck','checked'=>$check,'onclick'=>'save_checkallergy();','disabled'=>$disable));?> No known drug allergies
		</td>
	</tr>

	<tr class="trShow">
		<td style="padding: 5px 0 5px 10px;">Allergic To</td>
		<td style="padding: 5px 0 5px 10px;">Status</td>
		<td style="padding: 5px 0 5px 10px;"><?php echo "";?></td>
		
	</tr>
	<?php  foreach($dataAllergy as $key=>$dataAllergy){ ?>
	<tr>
		<td style="padding: 5px 0 5px 10px;"><?php if($dataAllergy['NewCropAllergies']['CompositeAllergyID']=='' || $dataAllergy['NewCropAllergies']['CompositeAllergyID']=='0' && $dataAllergy['NewCropAllergies']['CompositeAllergyID']==null){
			$pt_id=$dataAllergy['NewCropAllergies']['patient_uniqueid'];
			$al_id=$dataAllergy['NewCropAllergies']['id'];
			$flag='notPresent';
			echo $this->Html->image('icons/exlpoint.jpeg',array('title'=>'Allergy is not present in our database, so select alternate allergy.','alt'=>'Remove','id'=>'compositeAllergy_'.$dataAllergy[NewCropAllergies][id].'_'.$dataAllergy[NewCropAllergies][patient_id],'class'=>'compositeAllergy','escape' => false,'style'=>'float:left;',"onclick"=>"addAllergy('$pt_id','$al_id','$flag')"));
			}?>&nbsp;<?php echo $dataAllergy['NewCropAllergies']['name'];?></td>
		<td style="padding: 5px 0 5px 10px;"><?php if($dataAllergy['NewCropAllergies']['status']=='A')echo __('Active');else echo "Inactive";?></td>
		<td ><?php echo $this->Form->checkbox('',array('id'=>$key.'_all','name'=>'allergyCheck','value'=>$dataAllergy['NewCropAllergies']['id'],'class'=>'allergyCheckClass'));?></td>
		
	</tr>
	<?php }?>
	<?php if(empty($dataAllergy)){?>
	<tr>
		<td colspan=2 style="padding: 5px 0 5px 10px;"><?php 
		echo __('No records found');?></td>
	</tr>
	<?php }?>
</table>
<table width="100%" class="formFull formFullBorder">
	<tr>
		<td
			style="text-align: left; font-weight: bold; background: #d2ebf2 repeat-x; padding: 5px 0 5px 10px;"
			colspan="5">Referrals</td>
	</tr>
	<tr><td><?php // echo $this->Html->link('Referral to hospital',array('controller'=>'Ccda','action'=>'referralToHospital',$patientId));?></td></tr>
	<tr><td><?php // echo $this->Html->link('Referral to specialist',array('controller'=>'Ccda','action'=>'referralToSpecialist',$patientId));?></td></tr>
	<tr></tr>
	<tr></tr>
	<tr></tr>
	<tr class="trShow">
		<td style="padding: 5px 0 5px 10px;">Referred To</td>
		<td style="padding: 5px 0 5px 10px;">Date</td>
		<td style="padding: 5px 0 5px 10px;">Reason For Referring</td>
		<td style="padding: 5px 0 5px 10px;">Status</td>
	</tr>
<?php  
	foreach($ccdaData as $dataCcda){ ?>
	<tr>
		<td style="padding:5px 0 5px 10px;"><?php  echo $dataCcda['ReferralToSpecialist']['specialist_name'];?></td>
		<td style="padding:5px 0 5px 10px;"><?php  echo $this->DateFormat->formatDate2LocalForReport($dataCcda['ReferralToSpecialist']['create_time'],Configure::read('date_format'),true); ?></td>
		<td style="padding:5px 0 5px 10px;"><?php  echo ucfirst($dataCcda['ReferralToSpecialist']['reason_of_referral']); ?></td>
		<td style="padding:5px 0 5px 10px;"><?php  if($dataCcda['ReferralToSpecialist']['is_sent']==0){
			echo "Referral Not Sent";
		}else{
			echo "Referral Sent";} ?></td>
	</tr>
	<?php }?>
	<?php if(empty($ccdaData)){?>
	<tr>
		<td colspan=2 style="padding:5px 0 5px 10px;"><?php 
		echo __('No record found');?></td>
	</tr>
	<?php }?>
</table>
<table width="100%" class="formFull formFullBorder">
	<tr>
		<td
			style="text-align: left; font-weight: bold; background: #d2ebf2 repeat-x; padding: 5px 0 5px 10px;"
			colspan="5">Procedure Performed</td>
	</tr>
	<tr><td><?php // echo $this->Html->link('Referral to hospital',array('controller'=>'Ccda','action'=>'referralToHospital',$patientId));?></td></tr>
	<tr><td><?php // echo $this->Html->link('Referral to specialist',array('controller'=>'Ccda','action'=>'referralToSpecialist',$patientId));?></td></tr>
	<tr></tr>
	<tr></tr>
	<tr></tr>
	<tr class="trShow">
		<td style="padding: 5px 0 5px 10px;">Procedure Name</td>
		<td style="padding: 5px 0 5px 10px;">Date</td>
		<td style="padding: 5px 0 5px 10px;">Code Type</td>
		<td style="padding: 5px 0 5px 10px;">Code value</td>
	</tr>
	<?php foreach($procedurePerformResult as $procedurePerformResultData){ ?>
	<tr>
		<td style="padding: 5px 0 5px 10px;"><?php  echo $procedurePerformResultData['ProcedurePerform']['procedure_name'];?>
		</td>
		<td style="padding: 5px 0 5px 10px;"><?php 
			if(!empty($procedurePerformResultData['ProcedurePerform']['procedure_to_date'])){
				echo $this->DateFormat->formatDate2Local($procedurePerformResultData['ProcedurePerform']['procedure_to_date'],Configure::read('date_format'),true); 
			}
			?>
		</td>
		<td style="padding: 5px 0 5px 10px;"><?php  echo $procedurePerformResultData['ProcedurePerform']['code_type']; ?>
		</td>
		<td style="padding: 5px 0 5px 10px;"><?php  echo $procedurePerformResultData['ProcedurePerform']['snowmed_code']; ?>
		</td>
	</tr>
	<?php }?>
	<?php if(empty($procedurePerformResult)){?>
	<tr>
		<td colspan=2 style="padding: 5px 0 5px 10px;"><?php 
		echo __('No records found');?></td>
	</tr>
	<?php }?>
</table>
<script>
/*$('.compositeAllergy').click(function(){
	
		currentId = $(this).attr('id') ;
    	splittedVar = currentId.split("_");		 
  		allergyId = splittedVar[1];
  		pt_id=splittedVar[2];
  		addAllergy(pt_id,allergyId);
});*/
  		
/*	function addAllergy(pt_id,al_id){
  			var flag='notPresent';
		$.fancybox({
			'width' : '100%',
			'height' : '80%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'showCloseButton':true,
			'onClosed':function(){
				getmedication();
				getAllergy();
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "allallergies")); ?>" + '/' + pt_id+'/'+al_id+'/'+null+'/'+<?php echo $dataAllergy['NewCropAllergies']['patient_uniqueid']?>+'/'+flag,
	
		});
	}*/
  		//);
/* function editMedication(patientId,id){
	$.fancybox({
		'width' : '100%',
		'height' : '40%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			getmedication();
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addMedication")); ?>"+"/"+patientId+"/"+id,
				 //+ '/' + patient_id + '/' + noteId, 
		
	});
}*/
$('.infomedication').on('click',function(){ 
	id = $(this).attr('id') ;
	var spDate=id.split('_');
	drug_id = spDate['0'] ;
	newcrop_id = spDate['1'] ;
	if(newcrop_id==''){
		  inlineMsg(id,'No Data to Display');
		  return false;
	}
	
	
	//alert(id);alert(drug_id);
//	var medication_name=$(this).attr('name');
	//alert(medication_name);
//	var name_med=medication_name.replace("/","~");
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "infomedication")); ?>"; 
 
    $.ajax({
	     type: 'POST',
	     url:  ajaxUrl  + '/' + drug_id +'/'+ newcrop_id,
	     dataType: 'html',
	     beforeSend:function(){ 
	    	 $('#busy-indicator').show('fast');; 
	     },
	     success: function(data){		
	    	  data = data.trim();	
	    	  	 
	    	  if(data != ''){
	    		  //inlineMsg(id,'');
	    		  
	    		  $("#indicatorid"+newcrop_id).html("<img src='<?php echo $this->webroot ?>theme/Black/img/icons/green.png'>");
	    		  var win=window.open(data, '_blank');
	    		  win.focus();
		      }else{
		    	  inlineMsg(id,$('#loading-text').html(),10); 
		    	 
		      }
	    	  $('#busy-indicator').hide('fast');; 
	     },
		 error: function(message){
			  inlineMsg(id,$('#loading-text').html(),5); 	     
			   
	     }        
	});
});
var medToPrint = new Array();
var allergyToPrint = new Array();
jQuery(document).ready(function() {
	$('.medCheckClass').attr('checked',true);
	$(".medCheckClass").each(function(){
		medToPrint.push($(this).val());
	  });
	$('.allergyCheckClass').attr('checked',true);
	$(".allergyCheckClass").each(function(){
		allergyToPrint.push($(this).val());
	  });
});	
//To print selected medication and allergy

$('.medCheckClass').click(function(){	
var currentId= $(this).attr('id');


if($(this).prop("checked"))
   medToPrint.push($('#'+currentId).val());
else
	medToPrint.remove($('#'+currentId).val());
	
$('#newPrint').show();
$('#oldPrint').hide();

});

 
$('.allergyCheckClass').click(function(){	
	var currentIdAllergy= $(this).attr('id');
	
	if($(this).prop("checked"))
	    allergyToPrint.push($('#'+currentIdAllergy).val());
	else
		allergyToPrint.remove($('#'+currentIdAllergy).val());
	$('#newPrint').show();
	$('#oldPrint').hide();
	});
//EOF
function newPrint(patientId){
	var printUrl='<?php echo $this->Html->url(array("controller" => "notes", "action" => "prescription_detail_print",$id)); ?>';
	var printUrl=printUrl + "?medToPrint="+medToPrint+"&allergyToPrint="+allergyToPrint;

	var openWin =window.open(printUrl, '_blank',
	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');
	}

function openRx(patientId,noteId)
{
	var rxUrl='<?php echo $this->Html->url(array("controller" => "patients", "action" => "rx")); ?>';
	if(noteId==''){
		var rxUrl=rxUrl + '/' + patientId;
	}else{
		var rxUrl=rxUrl + '/' + patientId+'/'+noteId;
	}
	
	if(confirm("Do you want to add more medications? \n This is not a primary means to enter medication. Use this to e-prescribe only. To enter medication go to plan section of progress note!"))
	{
		window.location.href=rxUrl;
	}
	else
		return false;
}


/***BOF No Active Medication***/	
function save_checkmed(){
	if($('#nomedcheck').prop('checked')) 
	{	var checkmed=1;
	}else{
	  	var checkmed=0;
    }
patientid="<?php echo $id?>";
patient_uid="<?php echo $personid['Patient']['person_id']?>";
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "setNoActiveMed","admin" => false)); ?>";
    $.ajax({
     type: 'POST',
     url: ajaxUrl+"/"+patientid+"/"+checkmed+"/"+patient_uid,
     //data: formData,
     dataType: 'html',
     success: function(data){
    	 //alert(hello);
     },
	 error: function(message){
        alert(message);
     }        
   });
}
/***EOF No Active Medication***/

/***BOF No Active Allergy***/	
	function save_checkallergy(){
		if($('#noallergycheck').prop('checked')) 
		{	var checkall=1;
		 	//$('#addAllergy').hide();
		}else{
		  	var checkall=0;
		  	//$('#addAllergy').show();
	    }
	patientid="<?php echo $id?>";
	patient_uid="<?php echo $personid['Patient']['person_id']?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "setNoActiveAllergy","admin" => false)); ?>";
	    $.ajax({
	     type: 'POST',
	     url: ajaxUrl+"/"+patientid+"/"+checkall+"/"+patient_uid,
	     //data: formData,
	     dataType: 'html',
	     success: function(data){
	    	 //alert(hello);
	     },
		 error: function(message){
	        alert(message);
	     }        
	   });
	}
/***EOF No Active Allergy***/

/***BOF Reconcile Check***/	
function save_reconcilecheck(){
	if($('#reconcilecheck').prop('checked')) 
	{	var checkreconcile=1;
	}else{
	  	var checkreconcile=0;
    }
patientid="<?php echo $id?>";
person_id="<?php echo $personId?>";
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "setReconcile","admin" => false)); ?>";
    $.ajax({
     type: 'POST',
     url: ajaxUrl+"/"+patientid+"/"+checkreconcile+"/"+person_id,
     //data: formData,
     dataType: 'html',
     success: function(data){
    	 //alert(hello);
     },
	 error: function(message){
        alert(message);
     }        
   });
}
$('#inactiveRx').click(function(){
	$('#rxMsg').show();
	$('#rxMsg').html(' As this is the previous encounter of the patient, so ePrescribing is disabled. For ePrescribing go to current encounter of the patient.');
	return false;
	
});
/***EOF Reconcile Check***/	


</script>
