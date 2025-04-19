<?php  
foreach($columns as $key =>$column) {


	if(!empty($lastColumn) && ($lastColumn != trim($column['Widget']['column_id']))){
		
		echo '</div></div>';
		if($column['Widget']['column_id'] == '3')
			$float = 'float:right;';
		else $float = 'float:left;';

		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="column" style="width:32%;'.$float.'">';
		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="">';/*class="columnInternal">  */
	}else if(empty($lastColumn)){

		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="column" style="width:34%">';
		echo '<div id="column'.$column['Widget']['column_id'].'" class="">';/*class="columnInternal">  */
	}

	$boxHtml =  '<div class="dragbox" id="item'.$column['Widget']['id'].'" >';
	$boxHtml .= '<h2><div style="display:inline" >'.$column['Widget']['title'].'</div><span style="padding-left:30px; font-size:10px" id="record">{{recordCount}}</span></h2>';
	if($column['Widget']['collapsed'] == '1'){
		$collapsedDiv = 'style="display:none;"';
	}else{
		$collapsedDiv = 'style="display:block;"';
	}
	$boxHtml .= '<div class="dragbox-content" '.$collapsedDiv.'>';
	 
	switch (strtolower($column['Widget']['title'])) {
		case 'chief complaint':
			echo chiefComplaint($getDiagnosisData,$boxHtml,$patientId,$id,$appointmentID);
			break;
		case 'test results':
			echo significantTestsDone($getDiagnosisData,$boxHtml,$patientId,$id,$labResultData,$appointmentID);
			break;
		case 'current medication':
		//	$currentTreatmentsLink =  $this->Html->image('icons/plus_6.png' , array('id'=>'currentTreatments'));
			$currentTreatmentsLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array("controller" => "Diagnoses", "action" => "currentTreatment",$patientId,$id,$patientUid['Patient']['patient_id'],'null','null',$appointmentID,'?'=>array('patientId'=>$patientId)), array('escape' => false,'title'=>'Add Current Medication'));
			echo currentTreatment($getDiagnosisData,$boxHtml,$currentTreatmentsLink,$patientUid);
			break;
		case 'medication history':
			//$medicationHistoryLink =  $this->Html->image('icons/plus_6.png' , array('id'=>'medicationHistory'));
			$medicationHistoryLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array("controller" => "Diagnoses", "action" => "medicationHistory",$patientId,$id,$patientUid['Patient']['patient_id'],'null','null',$appointmentID,'?'=>array('patientId'=>$patientId)), array('escape' => false,'title'=>'Add Medication History'));
			echo medicationHistory($getDiagnosisData,$boxHtml,$medicationHistoryLink,$patientId,$getPatientPharmacy);
			break;
		case 'other treatment':
			$otherTreatmentsLink =  $this->Html->image('icons/plus_6.png' , array('id'=>'otherTreatments'));
			echo otherTreatment($getDiagnosisData,$boxHtml,$otherTreatmentsLink);
			break;
		case 'history':
		//	$significantHistoryLink =  $this->Html->image('icons/plus_6.png' , array('id'=>'significantHistorys'));
			$significantHistoryLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'Diagnoses','action' => 'significantHistory',$patientId,$getElement['Person']['id']), array('escape' => false,'title'=>'Add Vitals'));
			echo significantHistory($getDiagnosisData,$boxHtml,$significantHistoryLink);
			break;
		case 'vitals':
		//	$vitalsLink =  $this->Html->image('icons/plus_6.png' , array('id'=>'vitals','title'=>'Vitals') );
			$vitalsLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'Diagnoses','action' => 'addVital',$patientId,$appointmentID,$arr_time), array('escape' => false,'title'=>'Add Vitals'));
		//	$interactiveLink= $this->Html->image('icons/green_plusnew.png' , array('id'=>'interactive','title'=>'Interactive View','style'=>'margin:-4px 0 0 0 ;') );
			echo vitals($getDiagnosisData,$boxHtml,$vitalsLink,$interactiveLink);
			break;
		case 'immunizations':
			$immunizationLink = $this->Html->image('icons/plus_6.png', array('id'=>'imunization','title'=>'Add Imunization'));
			echo immunization($getImmunization,$boxHtml,$this->DateFormat,$immunizationLink);
			break;
		case 'allergies':
			$allergiesLink = $this->Html->image('icons/plus_6.png', array('id'=>'allergy','title'=>'Add Allergy'));
			echo allergy($newCropAllergies,$boxHtml,$allergiesLink,$patientId);
			break;

				
		
	}

	$lastColumn = $column['Widget']['column_id'];
	$userId = $column['Widget']['user_id'];
	$screenApplicationName = $column['Widget']['application_screen_name'];
} //end of outerDiv ?>
</div>
</div>
<?php // debug($getDiagnosisDetails);exit;
	 function chiefComplaint($getDiagnosisData,$boxHtml,$patientId,$id,$appointmentID){
	 	
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$chiefComplaintHtml = $boxHtml;
		
		$chiefComplaintHtml.='</form><form onSubmit="event.returnValue = false; return false;" action="'.Router::url("/").'Diagnoses/initialAssessment" method=post id="Chiefcomplaint">';
		$chiefComplaintHtml.='<table  width="100%" class="formFull formFullBorder">
								 		<div id="showCheifComplaints"> </div>
						<tr><td class="td_add"><textarea name=Diagnosis[complaints] id="subShow">'.$getDiagnosisData["Diagnosis"]["complaints"].'</textarea></td></tr>';
		$chiefComplaintHtml .='<tr><td class="td_add" clospan="4" style="align:right"><input type=submit name=Submit value=Update class="blueBtn" ></td>
			<input type=hidden name=Diagnosis[patient_id] value='.$patientId.'><input type=hidden name=Diagnosis[id] value='.$id.'><input type=hidden name=Diagnosis[appointment_id] value='.$appointmentID.'></tr></table></form>';
		
		$chiefComplaintHtml.='</div></div>';
		return $chiefComplaintHtml ;
	}
	function significantTestsDone($getDiagnosisData,$boxHtml,$patientId,$id,$labResultData,$appointmentID){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$significantTestsDoneHtml = $boxHtml;
		$significantTestsDoneHtml.='<form onSubmit="event.returnValue = false; return false;" action="'.Router::url("/").'Diagnoses/initialAssessment" method=post id="significantTestForm">';
		foreach($labResultData as $key => $dataLab){
			$labResult .= ''.$dataLab['Laboratory']['name'].''.$dataLab['LaboratoryHl7Result']['result'].''.$dataLab['LaboratoryHl7Result']['uom']."\r\n";
		} 
	    $significantTestsDoneHtml.='<table  width="100%" class="formFull formFullBorder">
								 		<div id="showSignificantTests"> </div>
						<tr><td class="td_add"><textarea name=Diagnosis[lab_report] id="subShowSig">'.$getDiagnosisData["Diagnosis"]["lab_report"].''.$labResult.'</textarea></td></tr>';
		$significantTestsDoneHtml .='<tr><td class="td_add" clospan="4" style="align:right"><input type=submit name=Submit value=Update class="blueBtn" ></td>
			<input type=hidden name=Diagnosis[patient_id] value='.$patientId.'><input type=hidden name=Diagnosis[id] value='.$id.'><input type=hidden name=Diagnosis[appointment_id] value='.$appointmentID.'></tr></table>';
		
		
		$significantTestsDoneHtml.='</div></div>';
		return $significantTestsDoneHtml ;
	}
	function currentTreatment($data,$boxHtml,$currentTreatmentsLink,$patientUid){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$currentTreatmentHtml.= $boxHtml;
		$currentTreatmentHtml .='<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
        $currentTreatmentHtml .='<table  width="100%" class="formFull formFullBorder">
		<tr>
		<td id="treatmentloader" width="100%"></td>
		</tr>
		<tr>
			<td class="td_add tdLabel" style="background:#8A9C9C">Add Current Medications'.$currentTreatmentsLink.'</td>
		</tr>
		<tr><td id="CT" class="td_add">
		</td></tr></table>';

		$currentTreatmentHtml.='</div></div>';
		return $currentTreatmentHtml ;
	}
	
	function medicationHistory($getDiagnosisData,$boxHtml,$medicationHistoryLink,$patientId,$getPatientPharmacy){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$medicationHistoryHtml.= $boxHtml;
		$medicationHistoryHtml .='<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
		$medicationHistoryHtml .='<table  width="100%" class="formFull formFullBorder">
		<tr>
		<td id="treatmentloader" width="100%"></td>
		</tr>
		<tr>
			<td class="td_add tdLabel" style="background:#8A9C9C">Add Medications History'.$medicationHistoryLink.'</td>
		</tr>
		<tr><td id="MA" class="td_add">
		</td></tr>
		</table></form>';
		$preferredPharmacyHtml='<form id=pharmacyForm  method=post>';
		$preferredPharmacyHtml .='<table  width="100%" class="formFull formFullBorder"> 
		<tr><td valign=top><label style=width:122px> Preferred Pharmacy: </label><input type=text name=Patient[preferred_pharmacy] id=pharmacy_value value='.$getPatientPharmacy[Patient][preferred_pharmacy].'>
	 		<input type=hidden name=Patient[id] id=patient_id value='.$patientId.'>
			<input type=hidden name=Patient[pharmacy_master_id] id=pharmacy_id ><input type=button name=submit value=Update id=pharmacy  class= blueBtn style="margin:-26px 0px -22px 11px"></td>
	 	</tr>
	 		</table>
	 		</form>';
		$medicationHistoryHtml.=$preferredPharmacyHtml.'</div></div>';
		return $medicationHistoryHtml ;
	}

	function otherTreatment($data,$boxHtml,$otherTreatmentsLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$otherTreatmentHtml.= $boxHtml;
		$otherTreatmentHtml .='<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
		$otherTreatmentHtml .='<table  width="100%" class="formFull formFullBorder">
				<tr>
				<td id="treatmentloader" width="100%"></td>
				</tr>
				<tr>
				<td class="td_add tdLabel" style="background:#8A9C9C">Add Other Treatment'.$otherTreatmentsLink.'</td>
	      		</tr>
	      		<tr><td id="ot" class="td_add">
	      		</td></tr></table>';

		$otherTreatmentHtml.='</div></div>';
		return $otherTreatmentHtml ;
	}
	function significantHistory($data,$boxHtml,$significantHistoryLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$significantHistoryHtml .= $boxHtml;
		 
		$significantHistoryHtml .= '<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
		$significantHistoryHtml .='<table  width="100%" class="formFull formFullBorder">
        		<tr>
        		<td id="treatmentloader" width="100%"></td>
        		</tr>
        		<tr>
        		<td class="td_add tdLabel" style="background:#8A9C9C">History'.$significantHistoryLink.'</td>
				</tr>
		<tr><td id="SH" class="td_add">
		</td></tr></table>';

		$significantHistoryHtml.='</div></div>';
		return $significantHistoryHtml ;
	}
	function vitals($data,$boxHtml,$vitalsLink, $interactiveLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$activitiesHtml = $boxHtml;
		$activitiesHtml .='<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
		$activitiesHtml .='<table  width="100%" class="formFull formFullBorder">
		<tr>
		<td id="treatmentloader" width="100%"></td>
		</tr>
		<tr>
			<td class="td_add tdLabel" style="background:#8A9C9C">Add Vitals'.$interactiveLink.' '.$vitalsLink.'</td>
		</tr>
		<tr><td id="vital" class="td_add">
		</td></tr></table>';
		$activitiesHtml.='</div></div>';
		return $activitiesHtml ;
	}
	
function immunization($getImmunization,$boxHtml,$dateformate,$immunizationLink){
		$countgetImmunization = count($getImmunization);
		$boxHtml = str_replace("{{recordCount}}",''.$countgetImmunizations.'',$boxHtml);
		$immunizationHtml = $boxHtml;
		$immunizationHtml .='<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
		$immunizationHtml .='<table  width="100%" class="formFull formFullBorder">
		<tr>
		<td id="treatmentloader" width="100%"></td>
		</tr>
		<tr>
			<td class="td_add tdLabel" style="background:#8A9C9C">Add Vitals'.$immunizationLink.'</td>
		</tr>
		<tr><td id="imu" class="td_add">
		</td></tr></table>';
		$immunizationHtml.='</div></div>';
		return $immunizationHtml;
	}
	
	
	function allergy($newCropAllergies,$boxHtml,$allergiesLink,$patientId){
		$countnewCropAllergies = count($newCropAllergies);
		
		$boxHtml = str_replace("{{recordCount}}",''.$countnewCropAllergie.'',$boxHtml);
		$allergyHtml = $boxHtml;
		$allergyHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background:#8A9C9C">All Visits'.$allergiesLink.'</td></tr>';
		$allergyHtml.='<tr><td id="allergyData"></td></tr></table>';
		
		$allergyHtml .= "</div></div>" ;
		return $allergyHtml;
	}

?>


<script>

$(document).ready(function(){  
	getMedicationHistory();
	getmedication();
	getTreatment();
	getvital();
	getSignificantHistory();
	getAllergy();
	getImunization();
	getAllergyTop();
	
	$('.dragbox').each(function(){  
	    $(this).hover(function(){  
	        $(this).find('h2').addClass('collapse');  
	    }, function(){  
	    $(this).find('h2').removeClass('collapse');  
	    })  
	    .find('h2').hover(function(){  
	        $(this).find('.configure').css('visibility', 'visible');  
	    }, function(){  
	        $(this).find('.configure').css('visibility', 'hidden');  
	    })  
	    .click(function(){  
	        $(this).siblings('.dragbox-content').toggle();  
	        //Save state on change of collapse state of panel  
	        updateWidgetData();  
	    })  
	    .end()  
	    .find('.configure').css('visibility', 'hidden');  
	});  
	
	$('.dragbox_inner')  
	.each(function(){  
	    $(this).hover(function(){  
	        $(this).find('h2').addClass('collapse');  
	    }, function(){  
	    $(this).find('h2').removeClass('collapse');  
	    })  
	    .find('h2').hover(function(){  
	        $(this).find('.configure').css('visibility', 'visible');  
	    }, function(){  
	        $(this).find('.configure').css('visibility', 'hidden');  
	    })  
	    .click(function(){  
	        $(this).siblings('.dragbox-content_inner').toggle();  
	        //Save state on change of collapse state of panel  
	        updateWidgetData();  
	    })  
	    .end()  
	    .find('.configure').css('visibility', 'hidden');  
	});  
	
	
	
	
	
	
	  
	$('.columnInternal').sortable({  
	    connectWith: '.columnInternal',  
	    handle: 'h2',  
	    cursor: 'move',  
	    placeholder: 'placeholder',  
	    forcePlaceholderSize: true,  
	    opacity: 0.4,  
	    start: function(event, ui){  
	        //Firefox, Safari/Chrome fire click event after drag is complete, fix for that  
	        //if($.browser.mozilla || $.browser.safari)   
	            $(ui.item).find('.dragbox-content').toggle();  
	    },  
	    stop: function(event, ui){  
	        ui.item.css({'top':'0','left':'0'}); //Opera fix  
	        //if(!$.browser.mozilla && !$.browser.safari)  
	            updateWidgetData();  
	    }  
	})  
	.disableSelection();  

	//ajax submission for 2nd chief complaints
    $("#Chiefcomplaint , #significantTestForm").submit(function(){
    	$.ajax({
			  type : "POST",
			  url: $(this).attr('action'), 
			  data:$(this).serialize(),
			  beforeSend:function(){
				  loading('outerDiv','class');
			  }, 	  		  
			  success: function(data){
	 			 onCompleteRequest('outerDiv','class')();
			  }
		});
    });
	});  
	
	function updateWidgetData(){  
	var items=[];  
	$('.columnInternal').each(function(){  
	    var columnId=$(this).attr('id');  
	    $('.dragbox', this).each(function(i){  
	        var collapsed=0;  
	        if($(this).find('.dragbox-content').css('display')=="none")  
	            collapsed=1;  
	        //Create Item object for current panel  
	        var item={  
	            id: $(this).attr('id'),  
	            collapsed: collapsed,  
	            order : i,  
	            column: columnId,
	            title: $('h2 div',this).html(), 
	            user_id:$('#user_id').val(), 
	            application_screen_name:$('#screen_application_name').val(),
	            section:"<?php echo $section ;?>"
	        };  
	        //Push item object into items array  
	        items.push(item);  
	    });  
	});  
	//Assign items array to sortorder JSON variable  
	var sortorder={ items: items };  
	//Pass sortorder variable to server using ajax to save state  
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "saveWidget","admin" => false)); ?>";
	$.post(ajaxUrl, 'data='+JSON.stringify(sortorder), function(response){  
	    if(response=="success")  
	        $("#console").html('<div class="success">Saved</div>').hide().fadeIn(1000);  
	    setTimeout(function(){  
	        $('#console').fadeOut(1000);  
	    }, 2000);  
	});  
} 

	//=== For current Medication ===
	/*
	$('#currentTreatments').click(function(){
		$.fancybox({
			
			'width' : '100%',
			'height' : '50%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'showCloseButton':true,
			'onClosed':function(){
				getmedication();
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "currentTreatment",$patientId,'null',$patientUid['Patient']['patient_id'])); ?>",
			
		});
	});*/
	function getmedication() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getMedication",$patientId,$patientUid['Patient']['patient_id'],$getElement['Person']['id'],$appointmentID,"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
	        	if(data!=''){
	       			 $('#CT').html(data);
	       			 medCount = $("#noMeddisable").val() ;
	      			 if(medCount > 0){ 
						 $("#medcheck").attr('disabled',true);
					 }else{
						 $("#medcheck").attr('disabled',false);
				 
		       			 if($("#noMedCheck").val()== 'yes'){ 
							 $("#medcheck").attr('checked',true);
						 }else if($("#noMedCheck").val()== 'no'){
							 $("#medcheck").attr('checked',false); 
						 } 
					 } 
	        	}
	        },
			});
	}
	//=== EOF current Medication ===
	//=== For Medication History ===
		 
$('#medicationHistory').click(function(){

//	window.location.href = "<?php // echo $this->Html->url(array("controller" => "Diagnoses", "action" => "medicationHistory",$patientId,'null',$patientUid['Patient']['patient_id'],$appointmentID)); ?>" ;
window.location.href = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "medicationHistory",$patientId,'null',$patientUid['Patient']['patient_id'],'null','null',$appointmentID)); ?>" ;
	/*$.fancybox({
		
		'width' : '100%',
		'height' : '50%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			getMedicationHistory();
		},
		'href' : "<?php //echo $this->Html->url(array("controller" => "Diagnoses", "action" => "medicationHistory",$patientId,'null',$patientUid['Patient']['patient_id'])); ?>",
				 //+ '/' + patient_id + '/' + noteId, 
		
	});*/
});
 
	function getMedicationHistory() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getMedicationHistory",$patientId,$patientUid['Patient']['patient_id'],$getElement['Person']['id'],$appointmentID,"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
	        	if(data!=''){
	       			 $('#MA').html(data);
	        	}
	        },
			});
	}
	//=== EOF Medication History ===
	

	//=== Other Treatment ===
	$('#otherTreatments').click(function(){
		$.fancybox({
			
			'width' : '100%',
			'height' : '60%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'showCloseButton':true,
			'onClosed':function(){
				getTreatment();
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "otherTreatment",$patientId)); ?>",
					
			
		});
	});

	function getTreatment() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getTreatment",$patientId,"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
	        	if(data!=''){
	       			 $('#ot').html(data);
	        	}
	        },
			});
	}
	


	//=== EOF Other Treatment ===
	/*
	$('#imunization').click(function(){

	 	$.fancybox({
			
			'width' : '60%',
			'height' : '70%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'showCloseButton':true,
			'onClosed':function(){
				getImunization();
			},
			'href' : "<?php echo $this->Html->url(array("controller" =>"Imunization","action" =>"index",$patientId,'InitialAssessment',"admin"=>false)); ?>",
					
			
		});
	});*/
 	function getImunization() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getImunization",$patientId,"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
	        	if(data!=''){
	       			 $('#imu').html(data);
	        	}
	        },
			});
	}
	//=== significant Historys ===
	/*
	$('#significantHistorys').click(function(){
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
				getSignificantHistory();
			},
			'href' : "<?php // echo $this->Html->url(array("controller" => "Diagnoses", "action" => "significantHistory",$patientId."")); ?>",
					
			
		});
	});
	*/

	function getSignificantHistory() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getSignificantHistory",$patientId,$getElement['Person']['id'],"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
		        if(data!=''){
	       			 $('#SH').html(data);
	        	}
	        },
			});
	}
	


	//=== EOF significant Historys ===
/*
		$('#vitals').click(function(){
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
					getvital();
				},
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "addVital",$patientId,)); ?>",
			});
		});
*/
	$('#interactive').click(function(){
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
				getvital();
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Nursings", "action" => "interactive_view",$patientId,)); ?>",
		});
	});

	 	function getvital() {
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getvital",$patientId,$id,$appointmentID,"admin" => false)); ?>";
		        $.ajax({
		        	beforeSend : function() {
		          	},
		        type: 'POST',
		        url: ajaxUrl,
		        //data: formData,
		        dataType: 'html',
		        success: function(data){
		        	if(data!=''){
		       			 $('#vital').html(data);
		        	}
		        },
				});
		}

	 	$('#allergy').click(function(){
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
					getAllergy();
					getAllergyTop();
				},
				'href' : "<?php echo $this->Html->url(array("controller" =>"Diagnoses","action" =>"allallergies",$patientId,$getElement['Person']['id'],"admin"=>false)); ?>",
						
				
			});
		});

	 	function getAllergy() {
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getAllergy",$patientId,$getElement['Person']['id'],"admin" => false)); ?>";
		        $.ajax({
		        	beforeSend : function() {
		          	},
		        type: 'POST',
		        url: ajaxUrl,
		        //data: formData,
		        dataType: 'html',
		        success: function(data){
		        	if(data!=''){
		       			 $('#allergyData').html(data);
		       			 $('#record').html()+1; 
		       			 allergyCount = $("#allergyCnt").val() ;
		       			 if(allergyCount > 0){ 
		       				$("#allergycheck").attr('checked',false);
							 $("#allergycheck").attr('disabled',true);
						 }else{
							 $("#allergycheck").attr('disabled',false);

							 if($("#noallergycheck").val()=='yes'){
					       			$("#allergycheck").attr('checked',true);
							 }else if($("#noallergycheck").val()=='no'){
									$("#allergycheck").attr('checked',false); 
							 } 
						 }
		        	}
		        },
				});
		}
	 	
	 	$('#pharmacy').click(function(){
		 	$.ajax({
	 			  type : "POST",
	 			  url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "updatePharmacy", "admin" => false)); ?>",
	 			  context: document.body,
	 			  data:$('#pharmacyForm').serialize(),
	 			  beforeSend:function(){
	 				  loading('outerDiv','class');
	 			  }, 	  		  
	 			  success: function(data){
		 			 onCompleteRequest('outerDiv','class')();
	 			  }
	 		});
	 	});

	 	$("#pharmacy_value").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","PharmacyMaster",'id',"Pharmacy_StoreName","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'pharmacy_value,pharmacy_id',
			onItemSelect:function () {
				if($( "#pharmacy_id" ).val() != '');
				$( "#pharmacy_id" ).trigger( "change" );
			}
		});
		
	
</script>