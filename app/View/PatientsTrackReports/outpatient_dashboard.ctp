<?php
echo $this->Html->css(array('drag_drop_accordian.css'));
echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js'));
?>
<script>
var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
</script>
<style>
* {
	padding: 0px;
	margin: 0px;
}
.td_add img{float:right;padding-right: 2px;}
.light:hover {
background-color: #F7F6D9;
text-decoration:none;
    color: #000000; 
 
}

.header_navigation {
	width: 100%;
	padding: 0px;
	margin: 0px;
	border: px;
	height: 20px;
}

.header_navigation li {
	border: none;
	width: 18%
}

.mainInpatientSummaryWrapper {
	width: 100%;
	padding: 5px;
	border: 1px solid #EEEEEE;
	height: auto;
}

.mainul {
	
}

.mainul li {
	display: inline;
	width: 100%;
	list-style-type: none;
	list-style: none;
	padding-left: 10px;
}

.
.onelineli {
	width: 100%;
}

.onelineli li {
	display: inline;
	list-style-type: none;
	list-style: none;
	line-height: 0px;
	border-bottom: 1px thin #fff;
}

.textalign {
	text-align: left;
}

.td_add {
    font-size: 13px;
}

.light > td {
    font-size: 13px;
}
.dragbox-content span {
    font-size: 13px;
}
.dragbox-content td {
    font-size: 13px;
}
#talltabs-blue {
  /*  border-top: 6px solid #8A9C9C;*/
    clear: left;
    float: left;
    font-family: Georgia,serif;
    overflow: hidden;
    padding: 0;
    width: 100%;
}
#talltabs-blue ul {
   /*  left: 50%; */
    list-style: none outside none;
    margin: 0;
    padding: 0;
    position: relative;
    text-align: center;
}
#talltabs-blue ul li {
    display: block;
    float: left;
    list-style: none outside none;
    margin: 0;
    padding: 0;
    position: relative;
   /* right: 50%;*/
}
#talltabs-blue ul li a {
    background: none repeat scroll 0 0 #8A9C9C;
    color: #FFFFFF;
    display: block;
    float: left;
    margin: 0 1px 0 0;
    padding: 8px 10px 6px;
    text-decoration: none;
}

#talltabs-blue ul li.active a, #talltabs-blue ul li.active a:hover {
    padding: 30px 10px 6px;
}

.rxanchor > a {
    float: right;
    font-size: 13px;
    padding: 10px 0 0;
}
span{ font-size:13px;}

#pres {
    font-size: 13px;
}
</style>
<!-- 
<div style="padding:0px;margin:0px;">

		<ul class="header_navigation">
			<li><a href="#">My List </a></li>
			<li><a href="#">Patient search</a></li>
			<li><a href="#">ICU Summery</a></li>
			<li><a href="#">Meds Review</a></li>
			<li><a href="#">Vital Infusion(24hr)</a></li>
			
		</ul>
	</div>
	<div>
	<h3>Inpatient Summary</h3>
	</div>
	<div class="clear"></div>
	-->
<!-- <div class="mainInpatientSummaryWrapper"> -->
<div class="inner_title">
	<h3>
		<?php echo __('Outpatient Summary'); ?>
	</h3>

</div>
<?php echo $this->Form->hidden('Patientsid',array('id'=>'Patientsid','value'=>$patientId)) ; ?>
<?php echo $this->element('patient_information');  ?>
<div id="talltabs-blue" >
	<ul style="float: right;">
		<li id="expand_id">
		 <a>
		<span style="cursor: pointer; cursor: hand" id="expand_id"  onclick="expandCollapseAll('expand_id')">Expand All</span>&nbsp;&nbsp;
		</a>
		</li>
		<li  id="collapse_id">
		<a>
		<span style="cursor: pointer; cursor: hand"  id="collapse_id" onclick="expandCollapseAll('collapse_id')">Collapse All</span>
		</a>
		</li>
	</ul>
</div>
	<div class="clear" >&nbsp;</div>
<?php
$lastColumn = '';
foreach($columns as $key =>$column) {


	if(!empty($lastColumn) && ($lastColumn != trim($column['Widget']['column_id']))){
			
		echo '</div></div>';
		if($column['Widget']['column_id'] == '3')
			$float = 'float:right;';
		else $float = 'float:left;';
		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="column" style="width:32%;'.$float.'">';
		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="columnInternal">';
	}else if(empty($lastColumn)){

		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="column" style="width:34%">';
		echo '<div id="column'.$column['Widget']['column_id'].'" class="columnInternal">';
	}

	$boxHtml =  '<div class="dragbox" id="item'.$column['Widget']['id'].'" >';
	$boxHtml .= '<h2><div style="display:inline" >'.$column['Widget']['title'].'</div><span style="padding-left:30px; font-size:10px">{{recordCount}}</span></h2>';
	if($column['Widget']['collapsed'] == '1'){
		$collapsedDiv = 'style="display:none;"';
	}else{
		$collapsedDiv = 'style="display:block;"';
	}
	$boxHtml .= '<div class="dragbox-content" '.$collapsedDiv.'>';
	switch (strtolower($column['Widget']['title'])) {
		case 'allergies':
			$allergiesLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array(), array('onclick'=>"getAllergiesAddEdit();return false;",'escape' => false,'title'=>'Add Allergy'));
			echo allergy($newCropAllergies,$boxHtml,$allergiesLink);
			break;

		case 'diagnoses':
			$diagnosesLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array(), array('onclick'=>"javascript:icdwin();return false;",'title'=>'Add Diagnoses','escape' => false));
			echo digno($noteDiagnoses,$boxHtml,$diagnosesLink);
			break;
		case 'medications':
			$medicationLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'patients','action' => 'notesadd',$patientId), array('escape' => false,'title'=>'Add Medication'));
			echo medication($newCropPrescriptions,$boxHtml,$medicationLink);
			break;
		case 'past medical':
			echo past_med_his($getPastMedicals,$boxHtml);
			break;
		case 'procedures':
			echo procedure($diagnosisSurgeries,$trarifName,$optDoctor,$boxHtml,$this->DateFormat);
			break;
		case 'documents':
			echo document($patientDocuments,$trarifName,$optDoctor,$boxHtml,$this->DateFormat);
			break;
		case 'labs':
			$labLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'patients','action' => 'notesadd',$patientId), array('escape' => false ,'title'=>'Add Lab'));
			echo lab($getLabsName,$getLabsResult,$boxHtml,$this->General,$labLink);
			break;
		case 'notes/reminders':
			echo notes_reminder($getNotes,$boxHtml,$this->DateFormat);
			break;
		case 'vitals and measurements':
			echo vitals_measurement($getVitals,$boxHtml,$this->General);
			break;
		case 'patient information':
			echo patient_info($getPatientInfo,$boxHtml);
			break;
		case 'diagnostics':
			echo dianostic($getEkg,$boxHtml);
			break;
		case 'flagged events':
			echo flag_event($getFlaggedEvents,$boxHtml);
			break;
		default:
			echo defaultFunction($getLabsGroupList,$getPastValueWithLaboratory,$boxHtml);
			break;
	}


	
	$lastColumn = $column['Widget']['column_id'];
	$userId = $column['Widget']['user_id'];
	$screenApplicationName = $column['Widget']['application_screen_name'];
}
		function defaultFunction($getLabsGroupList,$getPastValueWithLaboratory,$boxHtml){
			$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
			$nursing_plan_careHtml = $boxHtml;
			$nursing_plan_careHtml.='</div></div>';
			return $nursing_plan_careHtml ;
			 
		}
	function dianostic($getEkg,$boxHtml){
		$countEkg = count($getEkg);
		$boxHtml = str_replace("{{recordCount}}",$countEkg,$boxHtml);
		$dignosticHtml = $boxHtml;
		if(!empty($getEkg) ){
			$boxHtml1 =  '<div class="dragbox_inner" id="ekg" >';
			$boxHtml1 .= '<h2 style="background:#5A6366"><div style="display:inline" >EKG ('.$countEkg.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$dignosticHtml .= $boxHtml1.'';
			$dignosticHtml.= '<table width="100%">';
			foreach ($getEkg as $dataEkg){
				if($dataEkg['EkgResult']['confirm_result']==1){
					$status = 'Result published';
			
				}else{
					$status = 'In progress';
			
				}
				$dignosticHtml.= '<tr class="light">
					<td width="300px">'.$dataEkg['EKG']['history'].'<span style="color:grey;">( '.$dataEkg['EkgResult']['result_publish_date'].' ) </td>
									<td>'.$status.' </td>
									</tr>';
			}
			$dignosticHtml.='</table>';
			}else{
				$dignosticHtml.='<table>
									<tr><td><span style="color:grey;">No Result Found</td></tr>
									</table>';
			}
			$dignosticHtml .= "</div></div>" ;
			return $dignosticHtml;
		}
	
	function patient_info($getPatientInfo,$boxHtml){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$patient_infoHtml = $boxHtml;
		$patient_infoHtml.= '<table width="100%" cellspacing="0" cellpadding="0" >';
		if(!empty($getPatientInfo)){
			if($getPatientInfo['AdvanceDirective']['patient_id'] == ""){
				$advanceDirective = 'No';
			}else{
				$advanceDirective = 'Yes';
			}
			$patient_infoHtml.= '<tr class="light"><td >Chief Complaint :</td>
					<td class="textalign">'.$getPatientInfo['Note']['cc'].'</td>
						</tr>
						<tr class="light"><td >Primary Physician :</td>
						<td class="textalign" >'.$getPatientInfo['0']['full_name'].'</td>
					</tr>
					<tr class="light"><td>Emergency Contact :</td>
					<td class="textalign" >'.$getPatientInfo['Guardian']['guar_first_name'].' '.$getPatientInfo['Guardian']['guar_last_name'].'</td>
						</tr>
						<tr class="light"><td >Emergency :</td>
						<td class="textalign" >'.$getPatientInfo['Person']['person_local_number_second'].'</td>
						</tr>
						<tr class="light"><td >Advance Directive :</td>
		
						<td class="textalign" >'.$advanceDirective.'</td>
						</tr>';
		
			$patient_infoHtml.= '</table>';
		}else{
			$patient_infoHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</td></tr>
						</table>';
		}
		$patient_infoHtml.='</div></div>';
		return $patient_infoHtml;
	}
	function vitals_measurement($getVitals,$boxHtml,$general){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$mHtml =  $boxHtml;
		if(!empty($getVitals)){
		$mHtml.='<table width="100%"> <tr><td>Selected Visits</td></tr></table>';
			
		$mHtml .= '<table width="100%">
							<tr style="background-color:grey;height:10px;">
								<td></td>
								<td align="center">Latest</td>
								<td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
								<td align="center">Previous</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
								<td align="center">Previous</td>
							</tr>';
		foreach($getVitals as $keyMeasure => $dataMeasure){
				
				$mHtml .='<tr class="light">
							<td>'.$keyMeasure.'</td>
							<td align="center">'.$getVitals[$keyMeasure]['0']['values'].' <span style="color:grey;">'.$getVitals[$keyMeasure]['0']['unit'].'</td>
							<td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
							<td align="center">'.$getVitals[$keyMeasure]['1']['values'].' <span style="color:grey;">'.$getVitals[$keyMeasure]['1']['unit'].'</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
							<td align="center">'.$getVitals[$keyMeasure]['2']['values'].' <span style="color:grey;">'.$getVitals[$keyMeasure]['2']['unit'].'</td><td>&nbsp;</td>
				</tr>';
							}
							$mHtml .='</table>';
							}else{
								 $mHtml .='<table>
											 <tr><td><span style="color:grey;">No Result Found</td></tr>
											</table>';
							} 
							$mHtml .= "</div></div>" ;
							return $mHtml ;
	}
	function flag_event($getFlaggedEvents,$boxHtml){
		$countFlag = count($getFlaggedEvents);
		$boxHtml = str_replace("{{recordCount}}",$countFlag,$boxHtml);
		$flag_eventHtml = $boxHtml;
		if(!empty($getFlaggedEvents)){
			$flag_eventHtml.='<table  width="100%"> <tr><td>Last 30 days for the selected visits</td></tr></table>
						<table width="100%">';
			foreach($getFlaggedEvents as $fladData){
				$flagDate=date('m/d/Y', strtotime($fladData['ReviewPatientDetail']['flag_date']));
				$toolTip = 'Name : '.$fladData['ReviewSubCategoriesOption']['name'].'</br>
			Date/Time : '.$flagDate.'</br>
  				Entered : '.$flagDate.'</br>
  				Flagged : '.$flagDate.'</br>
  				Commewnts : '.$fladData['ReviewPatientDetail']['flag_comment'].'</br>';
	
	
				$flag_eventHtml .= '
 		<tr class="tooltip light" title="'.$toolTip.'">
		<td>'.$fladData['ReviewSubCategoriesOption']['name'].'<br> <span style="color:grey;">'.$fladData['ReviewPatientDetail']['flag_comment'].'</td>
		<td>'.$fladData['ReviewPatientDetail']['values'].' <i>'.$fladData['ReviewSubCategoriesOption']['unit'].'</i></td>
		<td>'.$flagDate.'</td>
		</tr>';
			}
			$flag_eventHtml .='</table>';
		}else{
			$flag_eventHtml .='<table>
		<tr><td><span style="color:grey;">No Result Found</td></tr>
		</table>';
		}
	
	
		$flag_eventHtml.='</div></div>';
		return $flag_eventHtml;
	}
	function notes_reminder($getNotes,$boxHtml,$general){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$notes_reminderHtml = $boxHtml;
		$notes_reminderHtml.= '<table width="100%" cellspacing="0" cellpadding="0">';
		if(!empty($getNotes)){
			foreach($getNotes as $getNote){
				if($getNote['Note']['note'] != ""){
				$notes_reminderHtml.= '
							<tr class="light"><td >'.$getNote['User']['first_name'].' '.$getNote['User']['last_name'].' :</td>
							<td ><span style="color:grey;">'.$general->formatDate2Local($getNote['Note']['note_date'],Configure::read('date_format'),false).'</td>
											<td >'.$getNote['Note']['note'].'</td>
											</tr>';
				}
			}
			$notes_reminderHtml.= '</table>';
		}else{
			$notes_reminderHtml.='<table>
			<tr><td><span style="color:grey;">No Result Found</td></tr>
			</table>';
		}
		$notes_reminderHtml.='</div></div>';
		return $notes_reminderHtml;
	}
	function lab($getLabsName,$getLabsResult,$boxHtml,$general,$labLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
	$labHtml = $boxHtml;

		$labHtml.='<table  width="100%"> <tr><td class="td_add" >Selected Visits '.$labLink.'</td></tr></table>';
	if(!empty($getLabsName)){
		$labHtml.= '<table width="100%" cellspacing="0" cellpadding="0">';
		$labHtml.= '<tr style="background-color:grey;height:10px;"><td></td>
							<td align="center">Latest</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center">Previous</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center">Previous</td>
							</tr>';
		foreach($getLabsName as $getLabsListVal) { 
			$labHtml.= '<tr class="light">
				<td>'.$getLabsListVal['Laboratory']['name'].'</td>
				<td align="center">'.$getLabsResult[$getLabsListVal['Laboratory']['test_group_id']][$getLabsListVal['Laboratory']['lonic_code']][0].'</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
				<td align="center">'.$getLabsResult[$getLabsListVal['Laboratory']['test_group_id']][$getLabsListVal['Laboratory']['lonic_code']][1].'</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
				<td align="center">'.$getLabsResult[$getLabsListVal['Laboratory']['test_group_id']][$getLabsListVal['Laboratory']['lonic_code']][2].'</td>
			</tr>';
		}
		$labHtml.= '</table>';
	}else{
		$labHtml.='<table>
							<tr><td><span style="color:grey;">No Result Found</td></tr>
							</table>';
	}
	$labHtml.='</div></div>';
	return $labHtml;
		
	}
function document($patientDocuments,$trarifName,$optDoctor,$boxHtml,$dateFormate){
	$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
	$docHtml = $boxHtml;
	if(!empty($patientDocuments)){
		$docHtml.='<table  width="100%"> <tr><td >Selected Visits</td></tr></table>';
		$docHtml.= '<table cellpadding="0" cellspacing="0" width="100%">
					<tr style="background-color:grey;">
					<td style="height:20px;width:33%;">&nbsp;</td>
					<td  style="height:20px;width:50%;">Provider</td>
					<td  style="height:20px;width:33%;">Date</td>
					</tr>';

	foreach($patientDocuments as $proceduer){
			if(!empty($trarifName[trim($proceduer['ProcedureHistory']['procedure'])])){
				$currentProcedure = $trarifName[trim($proceduer['ProcedureHistory']['procedure'])];
			}else{
				$currentProcedure = $proceduer['ProcedureHistory']['procedure_name'];
			}

			if(!empty($optDoctor[trim($proceduer['ProcedureHistory']['provider'])])){
				$currentProvider = $optDoctor[trim($proceduer['ProcedureHistory']['provider'])];
			}else{
				$currentProvider = $proceduer['ProcedureHistory']['provider_name'];
			}

			$toolTip = 'Procedure : '.$currentProcedure.'</br>
			Procedure Date : '.$dateFormate->formatDate2Local($proceduer['ProcedureHistory']['procedure_date'],Configure::read('date_format'),false).'</br>
				Provider : '.$currentProvider.'</br>
				Comment : '.$proceduer['ProcedureHistory']['comment'].'</br>';
				
				
				
			$docHtml .='<tr class="tooltip light" title="'.$toolTip.'">
									<td>'.$currentProcedure.'</td>
									<td>'.$currentProvider.'</td>
									<td align="right">'.$dateFormate->formatDate2Local($proceduer['ProcedureHistory']['procedure_date'],Configure::read('date_format'),false).'</td>
					</tr>';
		}
		$docHtml .='	</table>';
	}else{
		$docHtml .='<table>
						<tr><td><span style="color:grey;">No Result Found</td></tr>
						</table>';
	}
	$docHtml.='</div></div>';
	return $docHtml;
}
function procedure($diagnosisSurgeries,$trarifName,$optDoctor,$boxHtml,$dateFormate){
		$countProcedure=count($diagnosisSurgeries);
		$boxHtml = str_replace("{{recordCount}}",$countProcedure,$boxHtml);
		$procedure_historyHtml =  $boxHtml;
		if(!empty($diagnosisSurgeries)){
			$procedure_historyHtml.='<table width="100%"> <tr><td>All Visits</td></tr></table>';
			$procedure_historyHtml .='<table width="100%">';
			foreach($diagnosisSurgeries as $proceduer){
				if(!empty($trarifName[trim($proceduer['ProcedureHistory']['procedure'])])){
					$currentProcedure = $trarifName[trim($proceduer['ProcedureHistory']['procedure'])];
				}else{
					$currentProcedure = $proceduer['ProcedureHistory']['procedure_name'];
				}
				if(!empty($trarifName[trim($proceduer['ProcedureHistory']['provider'])])){
					$currentProvider = $trarifName[trim($proceduer['ProcedureHistory']['provider'])];
				}else{
					$currentProvider = $proceduer['ProcedureHistory']['provider_name'];
				}
			$toolTip = 'Procedure : '.$currentProcedure.'</br>
						Procedure Date : '.$dateFormate->formatDate2Local($proceduer['ProcedureHistory']['procedure_date'],Configure::read('date_format'),false).'</br>
						Provider : '.$currentProvider.'</br>
						Comment : '.$proceduer['ProcedureHistory']['comment'].'</br>';
			
			
			
			$procedure_historyHtml .='<tr class="tooltip light" title="'.$toolTip.'">
						<td>'.$currentProcedure.'</td>
						<td align="right">'.$dateFormate->formatDate2Local($proceduer['ProcedureHistory']['procedure_date'],Configure::read('date_format'),false).'</td>
					</tr>';
				}
				$procedure_historyHtml .='	</table>';
				}else{
									 $procedure_historyHtml .='<table>
												 <tr><td><span style="color:grey;">No Result Found</td></tr>
												</table>';
								} 
								$procedure_historyHtml .= "</div></div>" ;
			return $procedure_historyHtml;
			}
function past_med_his($getPastMedicals,$boxHtml){
	$countPastMedicals = count($getPastMedicals);
	$boxHtml = str_replace("{{recordCount}}",$countPastMedicals,$boxHtml);
	$pastMedHtml = $boxHtml;

	if(!empty($getPastMedicals)){
		$pastMedHtml.='<table  width="100%"> <tr><td>All Visits</td></tr></table>';
		$pastMedHtml .= '<table width="100%">';
		foreach($getPastMedicals as $pastMedical){
			$toolTip = 'Example</br>';
			$pastMedHtml .= '
		<tr class="tooltip light" title="'.$toolTip.'">
			<td>'.
			$pastMedical['PastMedicalHistory']['illness']
			.' <span style="color:grey;">'.$pastMedical['SnomedMappingMaster']['referencedComponentId'].'</td>
			</tr>';
		}
		$pastMedHtml .='</table>';
	}else{
		$pastMedHtml .='<table>
			<tr><td><span style="color:grey;">No Result Found</td></tr>
			</table>';
	}

	$pastMedHtml .=    '</div></div>'  ;
	return $pastMedHtml;
}
	
	function medication($newCropPrescriptions,$boxHtml,$medicationLink){
	$countmedication = count($newCropPrescriptions);
	$boxHtml = str_replace("{{recordCount}}",$countmedication,$boxHtml);
	$medicationHtml = $boxHtml;
	$medicationHtml .='<table  width="100%"> <tr><td class="td_add">'; 
	$medicationHtml .= $medicationLink;
	$medicationHtml .='</td></tr></table>';
	if(!empty($newCropPrescriptions)){
		$medicationHtml.= '<table width="100%">';
		foreach($newCropPrescriptions as $newCropPrescription){
			$medicationHtml.= '<tr class="light">
				<td>'.$newCropPrescription['NewCropPrescription']['description']
				.' <span style="color:grey;">'.$newCropPrescription['NewCropPrescription']['dose'].' tab(s),'
						.' '.$newCropPrescription['NewCropPrescription']['route'].', '
							.' '.$newCropPrescription['NewCropPrescription']['frequency'].'</td></tr>';
		}
		$medicationHtml.= '<tr><td align="right" class="rxanchor"><a href="#" id="pres" onclick="getRxHistory()">View Rx History</a></td></tr></table>';
	}else{
		$medicationHtml.='<table>
								<tr><td><span style="color:grey;">No Result Found</td></tr>
								</table>';
	}
	$medicationHtml.='</div></div>';
	return $medicationHtml;
	}
function digno($noteDiagnoses,$boxHtml,$diagnosesLink){
	$boxHtml = str_replace("{{recordCount}}",'',$boxHtml);
	$digno = $boxHtml;
		$digno	.='<table class="td_add"  width="100%"> <tr><td>Selected Visits'.$diagnosesLink.'</td></tr></table>';
	if(!empty($noteDiagnoses)){
		
		$digno.= '<table width="100%">';
		foreach($noteDiagnoses as $noteDiagnos){
			$digno.= '<tr>
			<td>'.$noteDiagnos['NoteDiagnosis']['diagnoses_name'].' <span style="color:grey;">('.$noteDiagnos['NoteDiagnosis']['icd_id'].')</td>
				</tr>';
		}
		$digno.='</table>';
	}else{
		$digno.='<table>
				<tr><td><span style="color:grey;">No Result Found</td></tr>
				</table>';
	}
	$digno .= "</div></div>" ;
	return $digno;

}
	function allergy($newCropAllergies,$boxHtml,$allergiesLink){
	$countnewCropAllergies = count($newCropAllergies);
	$boxHtml = str_replace("{{recordCount}}",$countnewCropAllergies,$boxHtml);
	$allergyHtml = $boxHtml;
	$allergyHtml.='<table  width="100%"> <tr><td class="td_add">All Visits'.$allergiesLink.'</td></tr></table>';
	if(!empty($newCropAllergies)){
	$allergyHtml.= '<table width="100%">';
	foreach($newCropAllergies as $newCropAllergy){
		$allergyHtml.= '
				<tr class="light">
				<td>'.$newCropAllergy['NewCropAllergies']['name'].'</td>
					<td>'.$newCropAllergy['NewCropAllergies']['reaction'].'</td>
				</tr>';
	}$allergyHtml.='</table>';
}else{
	$allergyHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</td></tr>
					</table>';
}
$allergyHtml .= "</div></div>" ;
return $allergyHtml;
	}
?>


<div class="clear"></div>
<!-- </div> -->
<div class="clear"></div>
<div>
	<input type="hidden" name="user_id" id="user_id"
		value="<?php echo $userId; ?>"> <input type="hidden"
		name="screen_application_name" id="screen_application_name"
		value="<?php echo $screenApplicationName; ?>">
</div>
<script type="text/javascript">
var diagnosisSelectedArray = new Array();

function addDiagnosisDetails(){
	var selectedPatientId = parent.$('#Patientsid').val();
	
	if(selectedPatientId != ''){
		
		var currEle = diagnosisSelectedArray.pop();
		if((currEle !='') && (currEle !== undefined)){
			parent.openbox(currEle,selectedPatientId,parent.global_note_id);
		}
	}
	
}

function openbox(icd,note_id,linkId) { 
	var sample;
	 
	icd = icd.split("::");
	var patient_id = $('#Patientsid').val();
	if (patient_id == '') {
		alert("Please select patient");
		return false;
	}
	
	$.fancybox({
				'width' : '40%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':false,
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
						 + '/' + patient_id + '/' + icd , 
				
			}); 

}

function icdwin() {  
	 
	patient_id = parent.$('#Patientsid').val();  
	if (patient_id == '') {
		alert("Something went wrong");
		return false;
	} 
	$("#Patientsid").val(patient_id);
	$.fancybox({ 
				'width' : '70%',
				'height' : '120%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe', 
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>" + '/' + patient_id,
	});

}


function expandCollapseAll(id){
	if(id=='collapse_id'){//dragbox-content
		$(".dragbox-content").css('display','none'); 
		$('#expand_id').removeClass('active');
		$('#collapse_id').addClass('active');
	}else{
		$(".dragbox-content").css('display','block');
		$('#expand_id').addClass('active');
		$('#collapse_id').removeClass('active');
	}
	
}
$(function(){  
    $('.dragbox')  
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
            $(this).siblings('.dragbox-content').toggle();  
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
                application_screen_name:$('#screen_application_name').val()
            };  
            //Push item object into items array  
            items.push(item);  
        });  
    });  
    //Assign items array to sortorder JSON variable  
    var sortorder={ items: items };  
              
    //Pass sortorder variable to server using ajax to save state  
    var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "saveWidget","admin" => false)); ?>";
    $.post(ajaxUrl, 'data='+JSON.stringify(sortorder), function(response){  
        if(response=="success")  
            $("#console").html('<div class="success">Saved</div>').hide().fadeIn(1000);  
        setTimeout(function(){  
            $('#console').fadeOut(1000);  
        }, 2000);  
    });  
}
function getAllergiesAddEdit(){
	$.fancybox({
		'width'        : '70%',
		'height'       : '100%',
		'autoScale'    : true,
		'transitionIn' : 'fade',
		'transitionOut': 'fade',
		'type'         : 'iframe',
		'onComplete'   : function() {
							$("#allergies").css({
				 'top' : '20px',
			  'bottom' : 'auto',	
				});
			},
		     'onClosed': function() {   
							     parent.location.reload(true); 
							     },
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "allallergies",$patientId)); ?>"
	});
}

function getRxHistory(){
	$.fancybox({
		'width' : '70%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			$("#allergies").css({
				'top' : '20px',
				'bottom' : 'auto',
				
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "rxhistory",$patientId,$patientUId)); ?>"

	});
}


</script>
