	<?php 
	echo $this->Html->script(array('expand.js'));
	echo $this->Html->css(array('drag_drop_accordian.css'));
	echo $this->Html->script(array(/* 'jquery-1.9.1.js','jquery-ui-1.10.2.js', */'inline_msg.js'));
	
	?>
	<!-- <script
		src="http://code.jquery.com/ui/1.8.16/jquery-ui.js"></script>
		-->
	<?php //echo $this->Html->css(array('patient_access.css',));?>
	<style>
	.trShow{
background-color:#ccc;

}
	.pointer{
		cursor: pointer;
	}
	.info_button2{
		float: right;
	/*	padding-right: 35px*/
	}
	.ui-widget-content {
		color: #fff;
		font-size:13px;
	}
	 .light:hover {
	background-color: #F7F6D9;
	text-decoration:none;
	    color: #000000; 
	}
	.light td{ font-size:13px;}
	.patientHub .patientInfo .heading {
	float: left;
	width: 121px !important;
	}
	
	.dragbox-content td {
	    font-size: 13px;
	}
	</style>
	<script>
	var currTab = "<?php echo $this->request->params['pass']['1']; ?>" ;
	var sbarURL =  "<?php echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "sbar",$patientId,"admin" => false)); ?>" ;
	  $(document).ready(function () {
			$(".drmhope-tab").click(function(){  
		        	var tabClicked = $("#"+this.id).html();
			         $(location).attr('href',sbarURL+'/'+tabClicked);
			});
			
			$("#tabs li").removeClass("ui-tabs-active");
	        $("#tabs li").removeClass("ui-state-active");
	        $("#"+currTab).addClass("ui-tabs-active");
	        $("#"+currTab).addClass("ui-state-active");
	        
		  $( "#tabs" ).tabs({
		    beforeLoad: function( event, ui ) {
		     // alert("sdgsgdsgd");
		      //event.preventDefault();
		      if(ui.jqXHR){
		    	  ui.jqXHR.abort();
		      }
		      //return;
		    }
		  });
		});
	  </script>
	
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
	.td_add img{float:right;padding-right: 15px;}
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
	
	#talltabs-blue {
		border-top: 6px solid #8A9C9C;
		clear: left;
		float: left;
		font-family: Georgia, serif;
		overflow: hidden;
		padding: 0;
		width: 100%;
	}
	
	#talltabs-blue ul { /*  left: 50%; */
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
		color: #FFFFFF !important;
		display: block;
		float: left;
		margin: 0 1px 0 0;
		padding: 8px 10px 6px;
		text-decoration: none;
	}
	
	#talltabs-blue ul li a:hover {
	    background:#DDDDDD;
		color:#31859C !important;
	}
	.dragbox-content span {
	    font-size: 13px;
	}
	.dragbox-content a {
	    font-size: 13px;
	}
	#talltabs-blue ul li.active a,#talltabs-blue ul li.active a:hover {
		/*padding: 30px 10px 6px;*/
		background:#DDDDDD;
		color:#31859C !important;
	}
	</style>
	
	<?php 
	echo $this->Html->css(array('tooltipster.css'));
	echo $this->Html->script(array('jquery.tooltipster.min.js'));
	
	?>
	<div class="inner_title">
		<h3>
			<?php echo __('Summary'); ?>
		</h3>
	<span><?php // echo $this->Html->link(__('Print'),array('controller'=>'PatientsTrackReports','action'=>'printSummary',$patient['Patient']['person_id']),array('class'=>'blueBtn','div'=>false));?></span>
	</div>
	<?php echo $this->element('patient_information');  ?>
	
	
	<div id="talltabs-blue">
		<?php   if($section=='Assessment'){
			$assessmentClass = 'class="active"';
		}else if($section=='Recommendation'){
				$recommendationClass = 'class="active"';
			}else if($section=='Situation'){
				$situationClass = 'class="active"';
			}else if($section=='Summary'){
				$summaryClass = 'class="active"';
			}
	
			?>
	
		<ul>
		<li id='Summary1' <?php echo $summaryClass ;?>><?php echo $this->Html->link('Summary',array('action' => 'sbar',$patientId,'Summary' ),array('escape' => false));  ?>
			</li>
			<li id='Situation1' <?php echo $situationClass ;?>><?php echo $this->Html->link('Situation',array('action' => 'sbar',$patientId,'Situation' ),array('escape' => false));  ?>
			</li>
			<li id='Assessment1' <?php echo $assessmentClass ;?>><?php echo $this->Html->link('Assessment',array('action' => 'sbar',$patientId,'Assessment' ),array('escape' => false,'class'=>$assessmentClass));  ?>
			</li>
			<li id='Recommendation1' <?php echo $recommendationClass ;?>><?php echo $this->Html->link('Recommendation',array('action' => 'sbar',$patientId,'Recommendation' ),array('escape' => false,'class'=>$recommendationClass)); ?>
			</li>
		</ul>
	
		<ul style="float: right;">
			<li id="expand_id"><a> <span style="cursor: pointer; cursor: hand"
					id="expand_id" onclick="expandCollapseAll('expand_id')">Expand All</span>&nbsp;&nbsp;
			</a>
			</li>
			<li id="collapse_id"><a> <span style="cursor: pointer; cursor: hand"
					id="collapse_id" onclick="expandCollapseAll('collapse_id')">Collapse
						All</span>
			</a>
			</li>
		</ul>
	</div>
	<div class="clear">&nbsp;</div>
	
	<?php $flag='sbar';$note_id='0';
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
			case 'plan':
				 $linkToHospital =  $this->Html->link('Referral to Hospital',array('controller'=>'Ccda','action'=>'referralToHospital',$patientId));
				 $linkToSpecialist = $this->Html->link('Referral to Specialist',array('controller'=>'Ccda','action'=>'referralToSpecialist',$patientId));
				 echo getPlan($getHospital,$getSpecialist,$linkToHospital,$linkToSpecialist,$boxHtml,$this->DateFormat);
				break;
			case 'measurements and weights':
				echo measurement_weights($getMeasurementWeight,$boxHtml);
				break;
			case 'intake and output':
				echo getIntakeOutput($getIntakeOutput,$getIntakeInner,$getOutInner,$boxHtml);
				break;
			case 'immunizations':
			//	$immunizationLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'imunization','action' => 'index',$patientId), array('escape' => false,'title'=>'Add Immunization'));
				echo immunization($getImmunization,$boxHtml,$this->DateFormat,$immunizationLink);
				break;
	
			case 'orders':
				echo order($getLabOrders,$getRadOrders,$boxHtml,$this->DateFormat);
				break;
	
			case 'patient background':
				echo patient_background($getAdvanceDirective,$getFallRiskScore,$getPainScore,$getResuscitationStatus,$getActivity,$getDiet,$boxHtml,$this->DateFormat);
				break;
	
			case 'microbiology':
				echo microbiologi($getMicrobiology,$boxHtml);
				break;
	
			case 'pathology':
				echo pathologies($getPathology,$boxHtml);
				break;
	
			case 'diagnosis':
				//$diagnosesLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'diagnoses','action' =>'add',$patientId,$flag), array('escape' => false,'title'=>'Add Diagnoses'));
				//$diagnosesLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'Notes','action'=>"soapNote",$patientId), array('escape' => false,'title'=>'Add Diagnoses'));
				echo digno($noteDiagnoses,$boxHtml,$diagnosesLink,$this->Html);
				break;
	
			case 'social':
				echo socials($getSocial,$smokingList,$boxHtml);
				break;
	
			case 'problems':
				echo problems($getProblems,$boxHtml);
				break;
			case 'medications':
				if($patient['Patient']['admission_type']=='IPD'){
				//	$medicationLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'MultipleOrderSets','action' => 'orders',$patientId), array('escape' => false,'title'=>'Add Medication'));
				}else{
				//	$medicationLink = $this->Html->link($this->Html->image('icons/plus_6.png'),'javascript:void(0)', array('onclick'=>"getAllergiesAddEdit();return false;",'title'=>'Add Medication','escape' => false));
				//	$medicationLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'Patients','action' => 'rx',$patientId,'?'=>array('pageView'=>"ajax")), array('escape' => false,'title'=>'Add Medication','target'=>'_blank'));
				}
				 if(count($newCropPrescriptions) >0){
				//		$printPrescription = $this->Html->link("Print Prescription","javascript:newPrint()");
				 }
				
				echo medication($newCropPrescriptions,$boxHtml,$medicationLink,$this->DateFormat,$this->General,$this->Html,$printPrescription,$this->Form);
				break;
			case 'medications':
				if($patient['Patient']['admission_type']=='IPD'){
					$medicationLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'MultipleOrderSets','action' => 'orders',$patientId), array('escape' => false,'title'=>'Add Medication'));
				}else{
					$medicationLink = $this->Html->link($this->Html->image('icons/plus_6.png'),'javascript:void(0)', array('onclick'=>"getAllergiesAddEdit();return false;",'title'=>'Add Medication','escape' => false));
				}
				echo medications($getScheduled,$getContinuous,$getPrnUnscheduled,$boxHtml,$medicationLink,$this->Html);
				break;
	
				/*case 'past medical history':
				 $initialLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'diagnoses','action' => 'add',$patientId,$flag), array('escape' => false ,'title'=>'past medical history'));
				echo past_med_his($getPastMedicals,$boxHtml,$initialLink);
				break;*/
	
			case 'diagnostics':
			//	$dianosticLink =  $this->Html->image('icons/plus_6.png' , array('id'=>'DiagnosticsLink','title'=>'Add Rad. Order'));
				echo dianostic($boxHtml,$dianosticLink);
				break;
	
			case 'documents':
				$documentLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'PatientDocuments','action' => 'add',$patientId,'null',$flag), array('escape' => false,'title'=>'Add Document'));
				
				$cmsForm1500=$this->Html->link($this->Html->image("icons/download.png",array('id'=>'show_'.$cnt,'alt'=>'Download CMS 1500 Form','title'=>'Download CMS 1500 Form')),
						array('controller'=>'Insurances','action'=>'downloadCMSForm1500'),array('escape'=>false));
				echo document($getPatientDocuments,$trarifName,$optDoctor,$boxHtml,$this->DateFormat,$documentLink,$diagnosisSurgeries,$cmsForm1500);
				break;
	
			case 'labs':
				if($patient['Patient']['admission_type']=='IPD'){
			//		$labLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'MultipleOrderSets','action' => 'orders',$patientId), array('escape' => false ,'title'=>'Add Lab'));
				}else{
			//		$labLink = $this->Html->image('icons/plus_6.png' , array('id'=>'Labink','title'=>'Add Lab. Order'));
				}
				echo lab($getLabsName,$getLabsResult,$boxHtml,$this->General,$labLink,$this->Html);
				break;
	
			case 'progress notes':
				$unlock = $this->Html->image('icons/unlock.png', array('title' => 'Sign Note', 'alt'=> 'Sign Note'));
				$lock = $this->Html->image('icons/lock.png', array('title' => 'Sign Note', 'alt'=> 'Sign Note'));
				echo note_reminder($getNotes,$boxHtml,$this->DateFormat,$unlock,$lock);
				break;
				/*  case 'vitals and measurements':
				 echo vitals_mesure($getVitals,$boxHtml);
				break;  */
			case 'information':
				echo info($patient,$boxHtml);
				break;
	
			case 'procedure history':
			//	$procedureLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'Notes','action'=>"soapNote",$patientId), array('escape' => false ,'title'=>'procedure history'));
				echo procedure_history($diagnosisSurgeries,$trarifName,$optDoctor,$boxHtml,$this->DateFormat,$procedureLink);
				break;
			/* case 'flagged events':
			//	$flaggedLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'nursings','action' => 'interactive_view',$patientId), array('escape' => false ,'title'=>'Flagged Events'));
				echo flag_event($getFlaggedEvents,$boxHtml,$flaggedLink);
				break; */
			case 'oxygenation and ventilation':
				echo oxygenation($getQxygenationVantilation,$getLastBloodGases,$getPreviousBloodGases,$boxHtml);
				break;
			case 'vital signs':
				echo vital_signs($getVitals,$boxHtml,$this->General);
				break;
			case 'nursing plans of care':
				if($patient['Patient']['admission_type']=='IPD'){
					echo nursing_plan($getNursingPlansCare,$boxHtml);
				}
				break;
			case 'quality measures':
				echo quality_measures($getQualityMeasure,$boxHtml);
				break;
			case 'overdue tasks':
				echo overdue_tasks($getOverdueTask,$getOverdueTaskLab,$boxHtml);
				break;
			case 'patient/family education':
				echo patient_family_education($getPatientFamilyEducation,$boxHtml,$this->DateFormat,$this->General,$this->Html,$getLabsName,$noteDiagnoses);
				break;
			case 'discharge plan':
				echo discharge_plan($getDischargePlan,$boxHtml);
				break;
	
			case 'follow up':
				echo follow_up($getFollowUp,$boxHtml,$this->DateFormat);
				break;
			case 'activities':
				$activitiesLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'nursings','action' => 'physiotherapy_assessment',$patientId,'null',$flag), array('escape' => false,'title'=>'Add Activities'));
				echo activities($getActivities,$boxHtml,$activitiesLink,$this->DateFormat);
				break;
	
			case 'lines, tubes and drains':
				echo line_tube_drain($getLinesTubeDrains,$boxHtml);
				break;
			case 'patient assessment':
				echo patient_assessment($getPatientAssessmentPain,$getPatientAssessmentNeuro,$getPatientAssessmentRespratory,
				$getPatientAssessmentCardiovascular,$getPatientAssessmentGI,$getPatientAssessmentGU,$getPatientAssessmentIntegumentary,
				$getPatientMentalStatus,$getSwallowScreen,$getPupilAssessment,$getMusculoskeletalAssessment,$getMechanicalVentilation,$getEdemaAssessment,$getUrinaryCatheter,$getBradenAssessment,$getFallRiskScaleMorse,$boxHtml);
				break;
			/* case 'allergies':
				$allergiesLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array(), array('onclick'=>"getAllergiesAddEdit();return false;",'escape' => false,'title'=>'Add Allergy'));
				echo allergy($newCropAllergies,$boxHtml,$allergiesLink);
				break; */
					
			case 'allergies':
			//	$allergiesLink = $this->Html->image('icons/plus_6.png', array('id'=>'allergy','title'=>'Add Allergy'));
				echo allergy($newCropAllergies,$boxHtml,$allergiesLink);
				break;
	
				/* case 'diagnosis':
					$diagnosesLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array(), array('onclick'=>"javascript:icdwin();return false;",'title'=>'Add Diagnoses','escape' => false));
				echo digno($noteDiagnoses,$boxHtml,$diagnosesLink);
				break; */
	
			case 'past medical history':
			//	$initialLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'diagnoses','action' => 'initialAssessment',$patientId), array('escape' => false ,'title'=>'past medical history'));
				echo past_med_his($getPastMedicals,$boxHtml,$initialLink);	
				break;
			case 'procedures':
			//	$procedureLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'Diagnoses','action'=>"initialAssessment",$patientId), array('escape' => false ,'title'=>'past medical history'));
				echo procedure($diagnosisSurgeries,$trarifName,$optDoctor,$boxHtml,$this->DateFormat,$procedureLink,$proceduresNote);
				break;
				/* case 'documents':
					echo document($patientDocuments,$trarifName,$optDoctor,$boxHtml,$this->DateFormat);
				break; */
		/*	case 'labs':
				if($patient['Patient']['admission_type']=='IPD'){
					$labLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'MultipleOrderSets','action' => 'orders',$patientId), array('escape' => false ,'title'=>'Add Lab'));
					echo lab($getLabsName,$getLabsResult,$boxHtml,$this->General,$labLink);
					break;
				}else{
						$labLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'patients','action' => 'patient_notes',$patientId), array('escape' => false ,'title'=>'Add Lab'));
						echo lab($getLabsName,$getLabsResult,$boxHtml,$this->General,$labLink);
						break;
					}*/
			/* case 'notes/reminders':
				echo notes_reminder($getNotes,$boxHtml,$this->DateFormat);
				break; */
			case 'vitals and measurements':
			//	$vitalLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'nursings','action' => 'interactive_view',$patientId), array('escape' => false ,'title'=>'vitals and measurements'));
				echo vitals_measurement($getVitals,$boxHtml,$this->General,$vitalLink);
				break;
			case 'patient information':
			//	$ptInfoLink = $this->Html->link($this->Html->image('icons/plus_6.png' ), array('controller'=>'patients','action' => 'edit',$patientId), array('escape' => false));
				echo patient_info($getPatientInfo,$boxHtml,$ptInfoLink);
				break;
				/* case 'diagnostics':
					echo dianostic($getEkg,$boxHtml);
				break; */
			/* case 'flagged events':
				echo flag_event($getFlaggedEvents,$boxHtml);
				break; */
			case 'permission to patient portal':
				$clinicalLightBoxLink =  $this->Html->image('icons/plus_6.png' , array('id'=>'clinical-summary') );
				$clinicalLightBoxLink1 =  $this->Html->image('icons/plus_6.png' , array('id'=>'patient_permissions') );
				echo share_with_patient($clinical_summary,$home_page_section,$boxHtml,$clinicalLightBoxLink,$clinicalLightBoxLink1); //checklist of shareable items with patient on home page and in CCDA
				break;
				/* default:
					echo defaultFunction($getLabsGroupList,$getPastValueWithLaboratory,$boxHtml);
				break; */
				/* default:
				 echo defaultFunction($getLabsGroupList,$getPastValueWithLaboratory,$boxHtml);
				break; */
			case 'initial assessment':
				echo initialAssessment($getInitialAssess,$boxHtml,$this->DateFormat);
				break;
		}
	
		$lastColumn = $column['Widget']['column_id'];
		$userId = $column['Widget']['user_id'];
		$screenApplicationName = $column['Widget']['application_screen_name'];
	}?>
	</div>
	<?php 
	
	//Pawan ***************************
	
	
	/* function defaultFunction($getLabsGroupList,$getPastValueWithLaboratory,$boxHtml){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$nursing_plan_careHtml = $boxHtml;
		$nursing_plan_careHtml.='</div></div>';
		return $nursing_plan_careHtml ;
	
	} */
	/*function dianostic($getEkg,$boxHtml){
		$countEkg = count($getEkg);
		$boxHtml = str_replace("{{recordCount}}",$countEkg,$boxHtml);
		$dignosticHtml = $boxHtml;
		if(!empty($getEkg) ){
			$boxHtml1 =  '<div class="dragbox_inner" id="ekg" >';
			$boxHtml1 .= '<h2 style="background:#D2EBF2"><div style="display:inline" >EKG ('.$countEkg.')</div></h2>';
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
						<td width="300px">'.$dataEkg['EKG']['history'].'<span style="color:grey; font-size:13px;">( '.$dataEkg['EkgResult']['result_publish_date'].' ) </span></td>
										<td>'.$status.' </td>
										</tr>';
			}
			$dignosticHtml.='</table>';
		}else{
			$dignosticHtml.='<table>
										<tr><td><span style="color:grey; font-size:13px;">No Result Found</span></td></tr>
										</table>';
		}
		$dignosticHtml .= "</div></div>" ;
		return $dignosticHtml;
	}*/
	
	function patient_info($getPatientInfo,$boxHtml,$ptInfoLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$patient_infoHtml = $boxHtml;
		$patient_infoHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$ptInfoLink.'</td></tr></table>';
		$patient_infoHtml.= '<table width="100%" cellspacing="0" cellpadding="0" >';
		if(!empty($getPatientInfo)){
			if($getPatientInfo['Person']['adv_directive'] == ""){
				$advanceDirective = 'No';
			}elseif($getPatientInfo['Person']['adv_directive'] == "Unknown"){
				$advanceDirective = 'Unknown';
			}else{
				$advanceDirective = $getPatientInfo['Person']['adv_directive'];
			}
			if(!empty($getPatientInfo['Note']['cc'])){
				$chiefComplaint = $getPatientInfo['Note']['cc'];
			}else{
				$chiefComplaint = $getPatientInfo['Diagnosis']['complaints'];
			}
			$patient_infoHtml.= '<tr class="light"><td >Chief Complaint :</td>
						<td class="textalign">'.ucwords($chiefComplaint).'</td>
							</tr>
							<tr class="light"><td >Primary Physician :</td>
							<td class="textalign" >'.$getPatientInfo['0']['full_name'].'</td>
						</tr>
						<tr class="light"><td>Emergency Contact :</td>
						<td class="textalign" >'.$getPatientInfo['Guardian']['guar_first_name'].' '.$getPatientInfo['Guardian']['guar_last_name'].'</td>
							</tr>
							<tr class="light"><td >Emergency :</td>
							<td class="textalign" >'.$getPatientInfo['Guardian']['guar_localno'].'</td>
							</tr>
							<tr class="light"><td >Advance Directive :</td>
			
							<td class="textalign" >'.$advanceDirective.'</td>
							</tr>';
	
			$patient_infoHtml.= '</table>';
		}else{
			$patient_infoHtml.='<table>
							<tr><td><span style="color:grey; font-size:13px;">No Result Found</span></td></tr>
							</table>';
		}
		$patient_infoHtml.='</div></div>';
		return $patient_infoHtml;
	}
	function vitals_measurement($getVitals,$boxHtml,$general,$vitalLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$mHtml =  $boxHtml;
		$mHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$vitalLink.'</td></tr></table>';
		if(!empty($getVitals)){
				
			$mHtml .= '<table width="100%">
							<tr style="background-color:#ccc;height:10px;"><td></td>
							<td align="center">Latest</td><td align="center">Previous</td><td align="center">Previous</td>
							</tr>';
		foreach($getVitals as $keyMeasure => $dataMeasure){
			//if(!empty($getVitals[$keyMeasure]['0']['values']) || !empty($getVitals[$keyMeasure]['1']['values'])|| !empty($getVitals[$keyMeasure]['2']['values'])){
			$mHtml .='<tr class="light">';
					if($keyMeasure=='Bmi'){
						$mHtml .='<td>BMI</td>';
					}else{
						$mHtml .='<td>'.$keyMeasure.'</td>';
					}
					if(!empty($getVitals[$keyMeasure]['0']['values'])){
						$mHtml .='<td align="left">'.$getVitals[$keyMeasure]['0']['values'].' <span style="color:grey;">'.$getVitals[$keyMeasure]['0']['unit'].'</span></td>';
					}else{
						$mHtml .='<td align="left"></td>';
					}
					if(!empty($getVitals[$keyMeasure]['1']['values'])){
						$mHtml .='<td align="left">'.$getVitals[$keyMeasure]['1']['values'].' <span style="color:grey;">'.$getVitals[$keyMeasure]['1']['unit'].'</span></td>';
					}else{
						$mHtml .='<td align="left"></td>';
					}
					if(!empty($getVitals[$keyMeasure]['2']['values'])){
						$mHtml .='<td align="left">'.$getVitals[$keyMeasure]['2']['values'].' <span style="color:grey;">'.$getVitals[$keyMeasure]['2']['unit'].'</span></td>';
					}else{
						$mHtml .='<td align="left"></td>';
					}
					
			$mHtml .='</tr>'; 
			//}
		}
			$mHtml .='</table>';
		}else{
			$mHtml .='<table>
												 <tr><td><span style="color:grey;">No Result Found</span></td></tr>
												</table>';
		}
		$mHtml .= "</div></div>" ;
		return $mHtml ;
	}
	/*function flag_event($getFlaggedEvents,$boxHtml){
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
			<td>'.$fladData['ReviewSubCategoriesOption']['name'].'<br> <span style="color:grey;">'.$fladData['ReviewPatientDetail']['flag_comment'].'</span></td>
			<td>'.$fladData['ReviewPatientDetail']['values'].' <i>'.$fladData['ReviewSubCategoriesOption']['unit'].'</i></td>
			<td>'.$flagDate.'</td>
			</tr>';
			}
			$flag_eventHtml .='</table>';
		}else{
			$flag_eventHtml .='<table>
			<tr><td><span style="color:grey;">No Result Found</span></td></tr>
			</table>';
		}
	
	
		$flag_eventHtml.='</div></div>';
		return $flag_eventHtml;
	}*/
	function notes_reminder($getNotes,$boxHtml,$general){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$notes_reminderHtml = $boxHtml;
		$notes_reminderHtml.= '<table width="100%" cellspacing="0" cellpadding="0">';
		if(!empty($getNotes)){
			foreach($getNotes as $getNote){
				if($getNote['Note']['note'] != ""){
					$notes_reminderHtml.= '
								<tr class="light">
									<td >'.$getNote['User']['first_name'].' '.$getNote['User']['last_name'].' :</td>
									<td ><span style="color:grey;">'.$general->formatDate2Local($getNote['Note']['note_date'],Configure::read('date_format'),false).'</span></td>
									<td >'.$getNote['Note']['note'].'</td>
								</tr>';
				}
			}
			$notes_reminderHtml.= '</table>';
		}else{
			$notes_reminderHtml.='<table>
				<tr><td><span style="color:grey;">No Result Found</span></td></tr>
				</table>';
		}
		$notes_reminderHtml.='</div></div>';
		return $notes_reminderHtml;
	}
	/*function lab($getLabsName,$getLabsResult,$boxHtml,$general,$labLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$labHtml = $boxHtml;
	
		$labHtml.='<table  width="100%"> <tr><td class="td_add">Selected Visits '.$labLink.'</td></tr></table>';
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
								<tr><td><span style="color:grey;">No Result Found</span></td></tr>
								</table>';
		}
		$labHtml.='</div></div>';
		return $labHtml;
	
	}*/
	/*function document($patientDocuments,$trarifName,$optDoctor,$boxHtml,$dateFormate){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$docHtml = $boxHtml;
		if(!empty($patientDocuments)){
			$docHtml.='<table  width="100%"> <tr><td>Selected Visits</td></tr></table>';
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
							<tr><td><span style="color:grey;">No Result Found</span></td></tr>
							</table>';
		}
		$docHtml.='</div></div>';
		return $docHtml;
	}*/
	function procedure($diagnosisSurgeries,$trarifName,$optDoctor,$boxHtml,$dateFormate,$procedureLink,$proceduresNote){
		$countProcedure=count($diagnosisSurgeries);
		$countProceduresNote=count($proceduresNote);
		$countpro = $countProcedure + $countProceduresNote;
		$boxHtml = str_replace("{{recordCount}}",'('.$countpro.')',$boxHtml);
		$procedure_historyHtml =  $boxHtml;
		$procedure_historyHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$procedureLink.'</td></tr></table>';
		if(!empty($diagnosisSurgeries) || !empty($proceduresNote)){
			
			$procedure_historyHtml .='<table width="100%">';
			if(!empty($diagnosisSurgeries)){
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
				$toolTip = '<b>Procedure:</b> '.wordwrap($currentProcedure,80,"<br>\n").'</br>
							<b>Procedure Date:</b> '.$dateFormate->formatDate2Local($proceduer['ProcedureHistory']['procedure_date'],Configure::read('date_format'),false).'</br>
							<b>Provider:</b> '.$currentProvider.'</br>
							<b>Comment:</b> '.$proceduer['ProcedureHistory']['comment'].'</br>';
					
					
					
				$procedure_historyHtml .='<tr class="tooltip light" title="'.$toolTip.'">
							<td>'.$currentProcedure.'</td>
							<td align="right">'.$dateFormate->formatDate2Local($proceduer['ProcedureHistory']['procedure_date'],Configure::read('date_format'),false).'</td>
						</tr>';
				}
			}
			if(!empty($proceduresNote)){
			foreach($proceduresNote as $procedureValue){
				$date = $dateFormate->formatDate2Local($procedureValue['ProcedurePerform']['procedure_date'],Configure::read('date_format'),false);
				$toolTip1 = '<b>Procedure Name:</b> '.wordwrap($procedureValue['ProcedurePerform']['procedure_name'],80,"<br>\n").' </br>
							<b>Procedure Note:</b> '.$procedureValue['ProcedurePerform']['procedure_note'].'</br>
							<b>Procedure Date:</b> '.$date.'</br>';
				$procedure_historyHtml .='<tr class="light" title="">
							<td>'.$procedureValue['ProcedurePerform']['procedure_name'].'</td>
							<td align="right">'.$date.'</td>
						</tr>';
				}
			}
			$procedure_historyHtml .='</table>';
		}else{
			$procedure_historyHtml .='<table>
													 <tr><td><span style="color:grey;">No Result Found</span></td></tr>
													</table>';
		}
		$procedure_historyHtml .= "</div></div>" ;
		return $procedure_historyHtml;
	}
	/*function past_med_his($getPastMedicals,$boxHtml){
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
				.' <span style="color:grey;">'.$pastMedical['SnomedMappingMaster']['referencedComponentId'].'</span></td>
				</tr>';
			}
			$pastMedHtml .='</table>';
		}else{
			$pastMedHtml .='<table>
				<tr><td><span style="color:grey;">No Result Found</span></td></tr>
				</table>';
		}
	
		$pastMedHtml .=    '</div></div>'  ;
		return $pastMedHtml;
	}*/
	function medication($newCropPrescriptions,$boxHtml,$medicationLink,$dateFormate,$general,$html,$printPrescription,$form){
		$countmedication = count($newCropPrescriptions);
		$boxHtml = str_replace("{{recordCount}}",'('.$countmedication.')',$boxHtml);
		$medicationHtml = $boxHtml;
		$route_admin=Configure :: read('route_administration');
		$freq=Configure :: read('frequency');
		$dose=Configure :: read('dose_type');
		$doseFrom=Configure :: read('strength');
		$freq_fullform=Configure :: read('frequency_fullform');
		$medicationHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$medicationLink.'</td></tr></table>';
		
		if(!empty($newCropPrescriptions)){
			$medicationHtml.= '<table width="100%">';
			foreach($newCropPrescriptions as $key=>$newCropPrescription){
				if($newCropPrescription['NewCropPrescription']['PrintLeaflet']=='T')
				{
					$indicatoricon="small_green.png";
					$indicatortext="Medication information is printed and given to Patient/Familieis/CareGiver";
				}else{
					$indicatoricon="small_red.png";
					$indicatortext="Medication information is not printed and not given to Patient/Familieis/CareGiver";
				}
				//$startDate=$dateFormate->formatDate2Local($newCropPrescription['NewCropPrescription']['date_of_prescription'],Configure::read('date_format'),false);
				$date_prescription=explode("-",$newCropPrescription['NewCropPrescription']['date_of_prescription']);
				$startDate=$date_prescription["1"]."/".substr($date_prescription["2"],0,2)."/".$date_prescription["0"];
				$drug_id=$newCropPrescription['NewCropPrescription']['drug_id'];
				$newcrop_id=$newCropPrescription['NewCropPrescription']['id'];
				$patientId=$newCropPrescription['NewCropPrescription']['patient_uniqueid'];
				$medication_name=$newCropPrescription['NewCropPrescription']['description'];
				$dose_val=$dose[$newCropPrescription['NewCropPrescription']['dose']];
				$freq_val=$freq_fullform[$newCropPrescription['NewCropPrescription']['frequency']];
				$dose_from = $doseFrom[$newCropPrescription['NewCropPrescription']['DosageForm']];
				$toolTip = '<b>Description:</b> '.ucwords(stripslashes($newCropPrescription['NewCropPrescription']['description'])).'</br>
							<b>Dose:</b> '.$dose_val.' '.$dose_from.'</br>
							<b>Route:</b> '.ucwords($route_admin[$newCropPrescription['NewCropPrescription']['route']]).' </br>
							<b>Frequency:</b> '.$freq_val.'</br>
							<b>Date of prescription:</b> '.$startDate.'</br>
							<b>Patient Info:</b> '.wordwrap($indicatortext,80,"<br>\n").'</br>';
				
				
			$toolTips = addslashes(htmlspecialchars($toolTip, ENT_QUOTES));
			if(!empty($newCropPrescription['VaccineDrug']['MEDID'])){
				$vax=" (".Vaccine.")";
			}
				$medicationHtml.= "<tr class='tooltip light' title='".$toolTips."'>";
				$medicationHtml.='<td width="60%">'.ucwords(stripslashes($newCropPrescription['NewCropPrescription']['description']).$vax)
				.' <span style="color:grey;">'.$dose_val.' '.$dose_from.','
				.' '.ucwords($route_admin[$newCropPrescription['NewCropPrescription']['route']]).', '
				.' '.$freq_val.', '
	
				.' '.$startDate.'</span></td>	
			<td width="10%" align="right" drug_id="'.$drug_id.'" newcrop_id="'.$newcrop_id.'" id="'.$general->clean($medication_name).'" name ="'.$medication_name.'"  class="info_button info_button2 infomedication" alt="Info Button" title="Info Button"></td>';
			$medicationHtml.="<td width='10%' align='right' onclick=\"javascript:infobutton('$drug_id','$patientId','$newcrop_id')\" class='info_button_orange' alt='Info Button' title='Info Button' valign='middle'></td>";
		//	$medicationHtml.='<td width="10%" align="center">'.$form->checkbox("",array("name"=>"medCheck","id"=>$key,"value"=>$newCropPrescription["NewCropPrescription"]["id"],"class"=>"medCheckClass")).'</td>';
			$medicationHtml.='<td width="10%" align="center" valign="top" id="indicatorid'.$newcrop_id.'">'.$html->link($html->image("/img/icons/$indicatoricon",
					array("id"=>"showGreen".$newcrop_id,"class"=>"classShowGreen")), "javascript:void(0)", array("escape"=>false,"alt"=>$indicatortext,"title"=>$indicatortext,"valign"=>"top",'height'=>'22px','width'=>'22px')) .'</td>
			</tr>';		
			}
		//	$medicationHtml.= '<tr><td align="right"><a href="#" id="pres" onclick="getRxHistory()" style="text-align:right">View Rx History</a></td></tr>';
		//	$medicationHtml.= '<tr><td align="right">'.$printPrescription.' </td></tr>';
		$medicationHtml.= '</table>';
		}else{
			$medicationHtml.='<table align="center">
							
									<tr><td align="center"><span style="color:grey;">No Result Found</span></td></tr>';
								//	$medicationHtml.='<tr><td align="right"><a href="#" id="pres" onclick="getRxHistory()" style="text-align:right">View Rx History</a></td></tr>';
									$medicationHtml.='</table>';
		}
		$medicationHtml.='</div></div>';
		return $medicationHtml;
	}
	/*
	function digno($noteDiagnoses,$boxHtml,$diagnosesLink){
		$boxHtml = str_replace("{{recordCount}}",'',$boxHtml);
		$digno = $boxHtml;
		$digno	.='<table class="td_add"  width="100%"> <tr><td>Selected Visits'.$diagnosesLink.'</td></tr></table>';
		if(!empty($noteDiagnoses)){
	
			$digno.= '<table width="100%">';
			foreach($noteDiagnoses as $noteDiagnos){
				$digno.= '<tr>
				<td>'.$noteDiagnos['NoteDiagnosis']['diagnoses_name'].' <span style="color:grey;">('.$noteDiagnos['NoteDiagnosis']['icd_id'].')</span></td>
					</tr>';
			}
			$digno.='</table>';
		}else{
			$digno.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
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
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
		}
		$allergyHtml .= "</div></div>" ;
		return $allergyHtml;
	}
	
	
	
	*/
	
	
	
	
	
	
	// Pawan ******************************
	
	function info($patient,$boxHtml){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$info = $boxHtml;
		if(!empty($patient)){
			$info.= '<table width="100%" cellspacing="0" cellpadding="0" >';
			if(!empty($patient['AdvanceDirective']['id'])){
				$advanceDirective = 'Yes';
			}else{
				$advanceDirective = 'No';
			}
			$info.= '
	
			<tr><td style="width:50%;color:grey;">Chief Complaint :</td>
			<td class="textalign" style="width:50%">'.$patient['Diagnosis']['final_diagnosis'].'</td>
			</tr>
			<tr><td style="width:50%;color:grey;">Primary Physician :</td>
			<td class="textalign" style="width:50%">'.$patient['User']['first_name'].' '.$patient['User']['last_name'].'</td>
	  		</tr>
	  		<tr><td style="width:50%;color:grey;">Emergency Contact :</td>
	  		<td class="textalign" style="width:50%">'.$patient['Guardian']['guar_first_name'].' '.$patient['Guardian']['guar_last_name'].'</td>
					</tr>
					<tr><td style="width:50%;color:grey;">Emergency # :</td>
					<td class="textalign" style="width:50%">'.$patient['Patient']['emergency_contact'].'</td>
	        		</tr>
	        		<tr><td style="width:50%;color:grey;">Advance Directive :</td>
	
	        		<td class="textalign" style="width:50%">'.$advanceDirective.'</td>
		    	  		</tr>';
	
			$info.= '</table>';
		}else{
			$info.='<table>
	  		<tr><td><span style="color:grey;">No Result Found</span></td></tr>
	  		</table>';
		}
		return $info;
	}
	/* function vitals_mesure($getVitals,$boxHtml){
	 $boxHtml = str_replace("{{recordCount}}","",$boxHtml);
	$vitalsHtml = $boxHtml;
	$toggle = 0;
	if(!empty($getVitals)){
	$vitalsHtml.= '<table width="100%" cellspacing="0" cellpadding="0">
	<tr style="background-color:grey;height:10px;"><td width="40%">&nbsp;</td><td width="19%">Latest</td><td width="2%">&nbsp;</td><td width="19%">Previous</td><td width="19%">Previous</td></tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr><td valign="top">
	
	<table class="table_format" valign="top" style="padding:0px;">';
	foreach($getVitals['reviewSubdata'][0]['ReviewSubCategoriesOption'] as $reviewSubCategoriesOption){
	if($toggle == 0){
	//$class = "row_gray";
	$toggle = 1;
	}else{
	$class = "";
	$toggle = 1;
	}
	$vitalsHtml.= '<tr class="'.$class.'"><td><div>'.$reviewSubCategoriesOption['name'].' :</div><div>&nbsp;</div></td>
	</tr>';
	}
	$vitalsHtml.= '</table></td>';
	foreach($getVitals['reviewPatientData'] as $key=>$reviewPatientData){
	if($key == 1){
	$style = 'style="border-left:1px solid #fff;"';
	$vitalsHtml.= '<td valign="top" '.$style.'><table valign="top">';
	$vitalsHtml.= '<tr class="'.$class.'"><td>'.$valuesArray[$i].'</td>
	</tr>';
	$vitalsHtml.= '</table></td>';
	}else{
	$style = '';
	}
	
	$vitalsHtml.= '<td valign="top" ><table valign="top">';
	$valuesArray = explode("|",$reviewPatientData['ReviewPatientDetail']['values']);
	//if($key == 2){pr($valuesArray);}
	$toggle = 0;
	for($i=0; $i< (count($valuesArray) - 1); $i++){
	if($toggle == 0){
	//$class = "row_gray";
	$toggle = 1;
	}else{
	$class = "";
	$toggle = 1;
	}
	if(!empty($valuesArray[$i])){
	$vitalsHtml.= '<tr class="'.$class.'"><td><div style="text-align:center;">'.$valuesArray[$i].'</div><div style="color:grey;text-align:center;">'.
	$this->General->diff($reviewPatientData['ReviewPatientDetail']['date'],date('Y-m-d')).'</div></td>
	</tr>';
	}
	}
	$vitalsHtml.= '</table></td>';
	if($key == 2) break;
	}
	$vitalsHtml.= '</tr></table>';
	}else{
	$vitalsHtml.='<table>
	<tr><td><span style="color:grey;">No Result Found</span></td></tr>
	</table>';
	}
	
	return $vitalsHtml;
	} */
	function note_reminder($getNotes,$boxHtml,$dateFormate,$unlock,$lock){	
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$noteHtml = $boxHtml;
		$noteHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">Progress Notes </td></tr></table>';
		if(!empty($getNotes)){
			$noteHtml.= '<table width="100%" cellspacing="0" cellpadding="0" class="tdLabel">';
			foreach($getNotes as $getNote){
				
			
				if($getNote['Note']['sign_note']=='0'){
					$noteHtml.= '
					<tr id="'.$getNote['Note']['patient_id']."_".$getNote['Note']['id'].'" class="soap-link pointer light">';
				}
				else{
					$noteHtml.= '
					<tr id="'.$getNote['Note']['patient_id']."_".$getNote['Note']['id'].'" class="power_note-link pointer">';
					
				}
					$noteHtml.= '<td >'.$getNote['User']['first_name'].' '.$getNote['User']['last_name'].' :</td>
								 <td >'.$dateFormate->formatDate2Local($getNote['Note']['create_time'],Configure::read('date_format'),true).'</td>';
					if($getNote['Note']['sign_note']=='0'){
						$noteHtml.= '<td >'.$unlock.' </td>';
					}else{
						$noteHtml.= '<td >'.$lock.' </td>';
					}
				$noteHtml.= '	</tr>';
			}
			$noteHtml.= '</table>';
		}else{
			$noteHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
		}
		$noteHtml.='</div></div>';
		return $noteHtml;
	}
	
	function lab($getLabsName,$getLabsResult,$boxHtml,$general,$labLink,$html){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$labHtml = $boxHtml;
		$labHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$labLink.'</td></tr></table>';
		if(!empty($getLabsName)){
			
			$labHtml.= '<table width="100%" cellspacing="0" cellpadding="0">';
			$labHtml.= '<tr style="background-color:grey;height:10px;"><td></td>
					<td align="center">Latest</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center">Previous</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center" style="width:1%;border-right:1px solid #fff;">Previous</td>
					</tr>';
			//<td align="center" colspan="2">Information</td>
			foreach($getLabsName as $getLabsListVal) {
				$lab_id=$getLabsListVal['Laboratory']['lonic_code'];
				$labs_name=$getLabsListVal['Laboratory']['name'];
				$labHtml.= '<tr class="light">
							<td>'.$getLabsListVal['Laboratory']['name'].'</td>
							<td align="center">'.$getLabsResult[$getLabsListVal['Laboratory']['test_group_id']][$getLabsListVal['Laboratory']['lonic_code']][0].'</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
							<td align="center">'.$getLabsResult[$getLabsListVal['Laboratory']['test_group_id']][$getLabsListVal['Laboratory']['lonic_code']][1].'</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
							<td align="center">'.$getLabsResult[$getLabsListVal['Laboratory']['test_group_id']][$getLabsListVal['Laboratory']['lonic_code']][2].'</td>';
						//	<td align="right" id="'.$general->clean($lab_id).'" name ="'.$lab_id.'"  class="info_button infolab " alt="Info Button" title="Info Button"></td>
				//	<td align='center'>".$html->link($html->image('/img/icons/Leaflet_1.png'), 'http://online.lexi.com/lco/action/pcm', array('target' => '_blank','escape'=>false,'alt'=>'leaflet','title'=>'leaflet','valign'=>'top')) ."</td>
				$labHtml.="	</tr>";
			}
			$labHtml.= '</table>';
		}else{
			$labHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
		}
		$labHtml.='</div></div>';
		return $labHtml;
	}
	function document($getPatientDocuments,$trarifName,$optDoctor,$boxHtml,$dateFormate,$documentLink,$diagnosisSurgeries,$cmsForm1500){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$docHtml = $boxHtml;
		
		$docHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits	'.$cmsForm1500.''.$documentLink.'</td></tr></table>';
		
			/*
			if(!empty($diagnosisSurgeries)){
			$docHtml.='<table  width="100%"> <tr><td style="background-color:#ccc">Procedure History</td></tr></table>';
			$docHtml.= '<table cellpadding="0" cellspacing="0" width="100%">
				<tr style="background-color:grey;">
				
				<td  style="height:20px;width:70%;">Provider1</td>
				<td  style="height:20px;width:33%;" align="right">Date</td>
				</tr>';
	
			foreach($diagnosisSurgeries as $proceduer){
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
						<td>'.$currentProcedure.' <span style="color:grey;">(Dr.'.$currentProvider.')</span></td>
						<td align="right">'.$dateFormate->formatDate2Local($proceduer['ProcedureHistory']['procedure_date'],Configure::read('date_format'),false).'</td>
						</tr>';
			}
			$docHtml .='	</table>';
		}*/
		//===========****
		if(!empty($getPatientDocuments)){
			$docHtml.= '<table cellpadding="0" cellspacing="0" width="100%">
				<tr style="background-color:grey;">
				<td style="height:20px;width:33%;">Link / Document</td>
				<td  style="height:20px;width:50%;">Provider</td>
				<td   align="center" style="height:20px;width:33%;">Date</td>
				</tr>';
		
			foreach($getPatientDocuments as $getDocuments){
				
				$toolTip = '<b>Document Type:</b> '.wordwrap($getDocuments['PatientDocumentType']['name'],80,"<br>\n").'</br>
							<b>Procedure Date:</b> '.$dateFormate->formatDate2Local($getDocuments['PatientDocument']['date'],Configure::read('date_format'),false).'</br>
							<b>Provider:</b> '.$getDocuments['User']['first_name'].' '.$getDocuments['User']['last_name'].'</br>
							<b>Comment:</b> '.$getDocuments['PatientDocument']['comment'].'</br>';
		
		
				$docHtml .='<tr class="tooltip light" title="'.$toolTip.'">';
				if(!empty($getDocuments['PatientDocument']['link'])){
					$docHtml .='<td><a target="_blank" href="'.$getDocuments['PatientDocument']['link'].'">'.$getDocuments['PatientDocument']['link'].'</a></td>';
				}
				else if(!empty($getDocuments['PatientDocument']['filename'])){
					$image=  FULL_BASE_URL.Router::url("/")."uploads/user_images/".$getDocuments['PatientDocument']['filename'];
					$docHtml .='<td><a  target="_blank" href="'.$image.'">'.$getDocuments['PatientDocument']['filename'].'</a></td>';
				}
				else{
					$docHtml .='<td> &nbps; </td>';
				}				
						
				$docHtml .='<td>'.$getDocuments['User']['first_name'].' '.$getDocuments['User']['last_name'].'</td>
						<td align="right">'.$dateFormate->formatDate2Local($getDocuments['PatientDocument']['date'],Configure::read('date_format'),false).'</td>
						</tr>';
			}
			$docHtml .='	</table>';
		}
		
		
		//=========***
		
		$docHtml.='</div></div>';
		return $docHtml;
	}
	function dianostic($boxHtml,$dianosticLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$dignosticHtml = $boxHtml;
		$dignosticHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$dianosticLink.'</td></tr></table>';
			$dignosticHtml.= '<table width="100%" cellspacing="0" cellpadding="0">';
			$dignosticHtml.= '
							  <tr>
								<td id="loadRad"></td>
							  </tr>';
		
		$dignosticHtml.= '	</table>';
		$dignosticHtml.='</div></div>';
		return $dignosticHtml;
	}
	function flag_event($getFlaggedEvents,$boxHtml,$flaggedLink){
		$countFlag = count($getFlaggedEvents);
		$boxHtml = str_replace("{{recordCount}}",'('.$countFlag.')',$boxHtml);
		$flag_eventHtml = $boxHtml;
		$flag_eventHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$flaggedLink.'</td></tr></table>';
		
		if(!empty($getFlaggedEvents)){
			$flag_eventHtml.='<table  width="100%"> <tr><td style="background-color:#ccc">Last 30 days for the selected visits</td></tr></table>
							<table width="100%">';
			foreach($getFlaggedEvents as $fladData){
				$flagDate=date('m/d/Y', strtotime($fladData['ReviewPatientDetail']['flag_date']));
				$toolTip = '<b>Name:</b> '.wordwrap($fladData['ReviewSubCategoriesOption']['name'],80,"<br>\n").'</br>
					 		<b>Date/Time:</b> '.$flagDate.'</br>
			  				<b>Entered:</b> '.$flagDate.'</br>
			  				<b>Flagged:</b> '.$flagDate.'</br>
			  				<b>Commewnts:</b> '.$fladData['ReviewPatientDetail']['flag_comment'].'</br>';
					
					
				$flag_eventHtml .= '
	 		<tr class="tooltip light" title="'.$toolTip.'">
			<td>'.$fladData['ReviewSubCategoriesOption']['name'].'<br> <span style="color:grey;">'.$fladData['ReviewPatientDetail']['flag_comment'].'</span></td>
			<td>'.$fladData['ReviewPatientDetail']['values'].' <i>'.$fladData['ReviewSubCategoriesOption']['unit'].'</i></td>
			<td>'.$flagDate.'</td>
			</tr>';
			}
			$flag_eventHtml .='</table>';
		}else{
			$flag_eventHtml .='<table>
			<tr><td><span style="color:grey;">No Result Found</span></td></tr>
			</table>';
		}
	
	
		$flag_eventHtml.='</div></div>';
		return $flag_eventHtml;
	}
	function past_med_his($getPastMedicals,$boxHtml,$initialLink){ 
		$countPastMedicals = count($getPastMedicals);
		$boxHtml = str_replace("{{recordCount}}",'',$boxHtml);
		$pastMedHtml = $boxHtml;
		
		$pastMedHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$initialLink.'</td></tr></table>';
		if(!empty($getPastMedicals)){
			$pastMedHtml .= '<table width="100%">';
			foreach($getPastMedicals as $pastMedical){
				$toolTip = '<b>Problem:</b> '.wordwrap($pastMedical['PastMedicalHistory']['illness'],80,"<br>\n").' </br>
							<b>Status:</b> '.$pastMedical['PastMedicalHistory']['status'].'</br>
							<b>Comments:</b> '.$pastMedical['PastMedicalHistory']['comment'].' </br>';
				$pastMedHtml .= '
			<tr class="tooltip light" title="'.$toolTip.'">
			<td>'.
			$pastMedical['PastMedicalHistory']['illness']
			.' <span style="color:grey;">'.$pastMedical['SnomedMappingMaster']['referencedComponentId'].'</span></td>
			</tr>';
			}
			$pastMedHtml .='</table>';
		}else{
			$pastMedHtml .='<table>
			<tr><td><span style="color:grey;">No Result Found</span></td></tr>
			</table>';
		}
	
		$pastMedHtml .=    '</div></div>'  ;
		return $pastMedHtml;
	}
	function medications($getScheduled,$getContinuous,$getPrnUnscheduled,$boxHtml,$medicationLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$medHtml = $boxHtml;
		$countSch=count($getScheduled);
		$medHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$medicationLink.'</td></tr></table>';
		if(!empty($getScheduled) || !empty($getContinuous) || !empty($getPrnUnscheduled)){
			$medHtml.='<table  width="100%"> <tr><td class="td_add" style="background-color:#ccc">Selected Visits</td></tr></table>';
			$boxHtml1 =  '<div class="dragbox_inner" id="scheduled" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Scheduled('.$countSch.')</div></h2>';//Next 12 hours   edit
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$medHtml .= $boxHtml1.'';
			if(!empty($getScheduled)){
				$medHtml .= '<table width="100%">';
				foreach($getScheduled as $dataScheduled){
						
					$toolTip = '<b>Medication:</b> '.wordwrap($dataScheduled['NewCropPrescription']['drug_name'],80,"<br>\n").'</br>
								<b>Order Details:</b> '.$dataScheduled['PatientOrder']['sentence'].'</br>
								<b>Order Comments:</b> '.$dataScheduled['NewCropPrescription']['special_instruction'].' </br>
								<b>Requested Start:</b> '.$dataScheduled['NewCropPrescription']['firstdose'].'</br>
								<b>Original Order Date/Time:</b> '.$dataScheduled['NewCropPrescription']['firstdose'].' </br>
								<b>Last Doses:</b> '.$dataScheduled['NewCropPrescription']['stopdose'].' </br>
								<b>Stop Date/Time:</b> '.$dataScheduled['NewCropPrescription']['end_date'].' </br>
								<b>Order Entered By:</b> '.$dataScheduled['0']['full_name'].'</br>
								<b>Status:</b> '.$dataScheduled['PatientOrder']['status'].'</br>
								<b>Details:</b> '.$dataScheduled['PatientOrder']['sentence'].'</br>';
						
					$medHtml .= '<tr class="tooltip light" title="'.$toolTip.'"><td>'.$dataScheduled['NewCropPrescription']['drug_name'].'<span style="color:grey;">  '.$dataScheduled['PatientOrder']['sentence'].'</span></td>
					</tr>';
				}
				$medHtml.='</table>';
			}else{
				$medHtml.='<table>
									<tr><td><span style="color:grey;">No Result Found</span></td></tr>
									</table>';
			}
			$medHtml .= "</div></div>";
			$countConti=count($getContinuous);
			$boxHtml1 =  '<div class="dragbox_inner" id="Continuous" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Continuous('.$countConti.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
	
			$medHtml .= $boxHtml1.'';
			if(!empty($getContinuous)){
				$medHtml .='<table width="100%">';
				foreach ($getContinuous as $dataConti){
					$toolTip = '<b>Medication:</b> '.wordwrap($dataConti['NewCropPrescription']['drug_name'],80,"<br>\n").'</br>
								<b>Order Details:</b> '.$dataConti['PatientOrder']['sentence'].'</br>
								<b>Order Comments:</b>'.$dataConti['NewCropPrescription']['special_instruction'].' </br>
								<b>Requested Start:</b></b> '.$dataConti['NewCropPrescription']['firstdose'].'</br>
								<b>Original Order Date/Time:</b> '.$dataConti['NewCropPrescription']['firstdose'].' </br>
								<b>Last Doses:</b> '.$dataConti['NewCropPrescription']['stopdose'].' </br>
								<b>Stop Date/Time:</b> '.$dataConti['NewCropPrescription']['end_date'].' </br>
								<b>Order Entered By:</b> '.$dataConti['0']['full_name'].'</br>
								<b>Status:</b> '.$dataConti['PatientOrder']['status'].'</br>
								<b>Details:</b> '.$dataConti['PatientOrder']['sentence'].'</br>';
					$medHtml.='<tr class="tooltip light" title="'.$toolTip.'">
					<td>'.$dataConti['NewCropPrescription']['drug_name'].'<span style="color:grey;">  '.$dataConti['PatientOrder']['sentence'].'</span></td>
							</tr>';
				}
				$medHtml.='</table>';
			}else{
				$medHtml.='<table>
							<tr><td><span style="color:grey;">No Result Found</span></td></tr>
							</table>';
			}
			$medHtml .= "</div></div>";
			$countPrn=count($getPrnUnscheduled);
			$boxHtml1 =  '<div class="dragbox_inner" id="prn" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >PRN/Unscheduled ('.$countPrn.') Administered last 48 hours</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
	
			$medHtml .= $boxHtml1.'';
			if(!empty($getPrnUnscheduled)){
					
				$medHtml .='<table width="100%">';
				foreach ($getPrnUnscheduled as $dataPrn){
					$toolTip = '<b>Medication:</b> '.wordwrap($dataPrn['NewCropPrescription']['drug_name'],80,"<br>\n").'</br>
								<b>Order Details:</b> '.$dataPrn['PatientOrder']['sentence'].'</br>
								<b>Order Comments:</b> '.$dataPrn['NewCropPrescription']['special_instruction'].' </br>
								<b>Requested Start:</b> '.$dataPrn['NewCropPrescription']['drm_date'].'</br>
								<b>Original Order Date/Time:</b> '.$dataPrn['NewCropPrescription']['firstdose'].' </br>
								<b>Last Doses:</b> '.$dataPrn['NewCropPrescription']['stopdose'].' </br>
								<b>Stop Date/Time:</b> '.$dataPrn['NewCropPrescription']['end_date'].' </br>
								<b>Order Entered By:</b> '.$dataPrn['0']['full_name'].'</br>
								<b>Status:</b> '.$dataPrn['PatientOrder']['status'].'</br>
								<b>Details:</b> '.$dataPrn['PatientOrder']['sentence'].'</br>';
					$medHtml.='<tr class="tooltip light" title="'.$toolTip.'">
				<td>'.$dataPrn['NewCropPrescription']['drug_name'].'<span style="color:grey;">  '.$dataPrn['PatientOrder']['sentence'].'</span></td>
				</tr>';
				}
				$medHtml.='</table>';
			}else{
				$medHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
			}
			$medHtml .= "</div></div>";
			$boxHtml1 =  '<div class="dragbox_inner" id="cardio" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >PRN/Unscheduled Available(count)</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$medHtml .= $boxHtml1.'';
			if(!empty($getScheduledd)){
				$medHtml .= '<table width="100%">';
				foreach($getScheduled as $dataScheduled){
					$medHtml .= '<tr class="light"><td>'.$dataScheduled['NewCropPrescription']['drug_name'].'</td>
						<td>'.$dataScheduled['PatientOrder']['sentence'].'</td>
							</tr>';
				}
				$medHtml.='</table>';
			}else{
				$medHtml.='<table>
								<tr><td><span style="color:grey;">No Result Found</span></td></tr>
								</table>';
			}
			$medHtml .= "</div></div>";
	
		}else{
			$medHtml.='<table>
								<tr><td><span style="color:grey;">No Result Found</span></td></tr>
								</table>';
		}
			
		$medHtml .= "</div></div>" ;
		return $medHtml;
	}
	function problems($getProblems,$boxHtml){
		$boxHtml = str_replace("{{recordCount}}",'',$boxHtml);
		$probHtml = $boxHtml;
		if(!empty($getProblems)){
			$probHtml.='<table  width="100%"> <tr><td style="background-color:#ccc">All Visits</td></tr></table>';
			$probHtml .= '<table width="100%">';
			foreach($getProblems as $getProblems){
				$probHtml .= '
					<tr class="light">
					<td>'.$getProblems['NoteDiagnosis']['diagnoses_name'].'<span style="color:grey;">('.$getProblems['NoteDiagnosis']['icd_id'].')</span></td>
								</tr>
								';
			}$probHtml .='</table>';
		}else{
			$probHtml .='<table>
							<tr><td><span style="color:grey;">No Result Found</span></td></tr>
							</table>';
		}
	
		$probHtml .= "</div></div>" ;
		return $probHtml;
	}
	function socials($getSocial,$smokingList,$boxHtml){
		//	$countgetSocials = count($getSocial);
		$boxHtml = str_replace("{{recordCount}}",'',$boxHtml);
		$socialHtml = $boxHtml;
		if(!empty($getSocial)){
			$socialHtml.= '<table  width="100%"> <tr><td class="tdLabel" style="background-color:#ccc">Selected Visits</td></tr></table>
					<table width="100%">';
			//foreach($getSocial as $getSocials){
			if($getSocial['PatientSmoking']['current_smoking_fre'] == ''){$smoking_fre = 'No';}else{$smoking_fre = $smokingList[trim($getSocial['PatientSmoking']['current_smoking_fre'])];}
			if($getSocial['PatientPersonalHistory']['alcohol_fre'] == ''){$alcohol_fre = 'No';}else{$alcohol_fre = $getSocial['PatientPersonalHistory']['alcohol_fre'];}
			if($getSocial['PatientPersonalHistory']['drugs_fre'] == ''){$drugs = 'No';}else{$drugs = $getSocial['PatientPersonalHistory']['drugs_fre'];}
			if($getSocial['PatientPersonalHistory']['tobacco_fre'] == ''){$tobacco = 'No';}else{$tobacco = $getSocial['PatientPersonalHistory']['tobacco_fre'];}
			if($getSocial['PatientPersonalHistory']['diet'] == '1'){$diet = 'Non-Veg ';}else if($getSocial['PatientPersonalHistory']['diet'] == '0'){$diet = 'Veg';}else{$diet ='Unknown';}
			if($getSocial['PatientPersonalHistory']['diet_exp'] == ''){$diet_exp = 'Unknown';}else{$diet_exp =$getSocial['PatientPersonalHistory']['diet_exp'];}
			if($getSocial['PatientPersonalHistory']['other_diet'] == ''){$other_diet = 'Unknown';}else{$other_diet =$getSocial['PatientPersonalHistory']['other_diet'];}
			if($getSocial['PatientPersonalHistory']['work'] =='0'){$work = 'Chemical';}else if($getSocial['PatientPersonalHistory']['work'] =='1'){$work = 'Sound';}else if($getSocial['PatientPersonalHistory']['work'] =='2'){$work = 'Injuries';}else if($getSocial['PatientPersonalHistory']['work'] =='3'){$work = 'Stress';}else{$work = 'Unknown';}
			if($getSocial['PatientPersonalHistory']['military_services'] =='0'){$military_services = 'No';}else if($getSocial['PatientPersonalHistory']['military_services'] =='1'){$military_services = 'Yes';}else{$military_services = 'Unknown';}
			if($getSocial['PatientPersonalHistory']['suicidal_thoughts'] =='0'){$suicidal_thoughts = 'No';}else if($getSocial['PatientPersonalHistory']['suicidal_thoughts'] =='1'){$suicidal_thoughts = 'Yes';}else{$suicidal_thoughts = 'Unknown';}
			if($getSocial['PatientPersonalHistory']['suicidal_plan'] =='0'){$suicidal_plan = 'No';}else if($getSocial['PatientPersonalHistory']['suicidal_plan'] =='1'){$suicidal_plan = 'Yes';}else{$suicidal_plan = 'Unknown';}
			
			
			$socialHtml.= '<tr class="light"><td>Smoking / Tobaco:</td><td>'.$smoking_fre.'</td><td><span style="color:grey;">'.$getSocial['PatientPersonalHistory']['smoking_desc'].'</span></td></tr>
						<tr class="light"><td>Alcohol:</td><td>'.$alcohol_fre.'</td><td><span style="color:grey;">'.$getSocial['PatientPersonalHistory']['alcohol_desc'].'</span></td></tr>
						<tr class="light"><td>Drugs:</td><td>'.$drugs.'</td><td><span style="color:grey;">'.$getSocial['PatientPersonalHistory']['drugs_desc'].'</span></td></tr>
						<tr class="light"><td>Retired:</td><td>'.$getSocial['PatientPersonalHistory']['retired'].'</td><td></td></tr>
						<tr class="light"><td>Caffeine Usage:</td><td>'.$tobacco.'</td><td><span style="color:grey;">'.$getSocial['PatientPersonalHistory']['tobacco_desc'].'</span></td></tr>
						<tr class="light"><td>Diet/Nutrition:</td><td>'.$diet.'</td><td></td></tr>
						<tr class="light"><td>Recent weight loss/gain :</td><td>'.$diet_exp.'</td><td></td></tr>
						<tr class="light"><td>Other Dietary/Nutrition :</td><td>'.ucwords($other_diet).'</td><td></td></tr>
						<tr class="light"><td>Work :</td><td>'.$work.'</td><td></td></tr>
						<tr class="light"><td>Military Services :</td><td>'.$military_services.'</td><td>'.$getSocial['PatientPersonalHistory']['militaryservices_yes'].'</td></tr>
						<tr class="light"><td>Suicidal Thoughts :</td><td>'.$suicidal_thoughts.'</td><td></td></tr>
						<tr class="light"><td>Suicide Plan :</td><td>'.$suicidal_plan.'</td><td></td></tr>';
			
			//	}
			$socialHtml.='</table>';
		}else{
			$socialHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
		}
		$socialHtml .= '</div></div>'	 ;
		return $socialHtml;
	}
	function digno($noteDiagnoses,$boxHtml,$diagnosesLink,$html){
		$countnoteDiagnoses = count($noteDiagnoses);
		$boxHtml = str_replace("{{recordCount}}",'('.$countnoteDiagnoses.')',$boxHtml);
		$digno = $boxHtml;
		$digno.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">Selected Visits'.$diagnosesLink.'</td></tr></table>';
		if(!empty($noteDiagnoses)){
			$digno.= '<table width="100%">';
			foreach($noteDiagnoses as $noteDiagnos){
				$icd_id=$noteDiagnos['NoteDiagnosis']['snowmedid'];
				$diagnosis_name=$noteDiagnos['NoteDiagnosis']['diagnoses_name'];
				$id=$noteDiagnos['NoteDiagnosis']['patient_id'];
				$primaryID=$noteDiagnos['NoteDiagnosis']['id'];
				$toolTip = '<b>Diagnosis:</b> '.wordwrap($noteDiagnos['NoteDiagnosis']['diagnoses_name'],80,"<br>\n").'</br>';
			//	<tr id="'.$noteDiagnos['NoteDiagnosis']['patient_id']."_".$noteDiagnos['Note']['id'].'" class="pointer tooltip light" title="'.$toolTip.'">
				$digno.= '<tr class="tooltip light" title="'.$toolTip.'"> 
							<td class="diagnosis-link">'.$noteDiagnos['NoteDiagnosis']['diagnoses_name'].' <span style="color:grey;">('.$noteDiagnos['NoteDiagnosis']['icd_id'].')</span></td>';
				$digno.="<td align='right' onclick=\"javascript:icdwin('$icd_id','$diagnosis_name','$id','$primaryID')\" class='info_button' alt='Info Button' title='Info Button' valign='middle'></td>		
							<td align='center'>".$html->link($html->image('/img/icons/Leaflet_1.png'), 'http://online.lexi.com/lco/action/pcm', array('target' => '_blank','escape'=>false,'alt'=>'leaflet','title'=>'leaflet','valign'=>'top')) ."</td>
					</tr>";
				}
			$digno.='</table>';
		}else{
			$digno.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
		}
		$digno .= "</div></div>" ;
		return $digno;
	
	}
	function allergy($newCropAllergies,$boxHtml,$allergiesLink){
		$countnewCropAllergies = count($newCropAllergies);
		$boxHtml = str_replace("{{recordCount}}",'('.$countnewCropAllergies.')',$boxHtml);
		$allergyHtml = $boxHtml;
		$allergyHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$allergiesLink.'</td></tr></table>';
		if(!empty($newCropAllergies)){
			$allergyHtml.= '<table width="100%">
								<tr style="background-color:#ccc">
									<td width="30%">Name</td>
									<td width="20%">Severity Level</td>
									<td width="30%">Reaction</td>
									<td width="20%">Status</td>
								</tr>
							</table>';
			$allergyHtml.= '<table width="100%">';
			foreach($newCropAllergies as $newCropAllergy){
					if($newCropAllergy['NewCropAllergies']['status'] == 'A'){
						$statusDisplay = 'Active';
					}else{
						$statusDisplay = 'Inactive ';
					}
				$allergyHtml.= '<tr class="light">
									<td width="30%">'.$newCropAllergy['NewCropAllergies']['name'].'</td>
									<td width="20%">'.$newCropAllergy['NewCropAllergies']['AllergySeverityName'].'</td>
									<td width="30%">'.$newCropAllergy['NewCropAllergies']['reaction'].'</td>
									<td width="20%">'.$statusDisplay.'</td>
								</tr>';
							}
						$allergyHtml.= '</table>';
		//	$allergyHtml.='<table width="100%"><tr><td align="right" ><a href="javascript:void(0)" id="pres" onclick="getAllergies()">View Details</a></td></tr></table>';
		}else{
			$allergyHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
		}
		$allergyHtml .= "</div></div>" ;
		return $allergyHtml;
	}
	function pathologies($getPathology,$boxHtml){
		$countgetPathology = count($getPathology);
		$boxHtml = str_replace("{{recordCount}}",'('.$countgetPathology.')',$boxHtml);
		$patho = $boxHtml;
		if(!empty($getPathology)){
			$patho.='<table  width="100%"> <tr><td style="background-color:#ccc">Last 10 Days For All Visits</td></tr></table>';
			$patho.= '<table width="100%">';
			foreach($getPathology as $getPathologies){
				$patho.= '<tr class="light">
			<td>'.$getPathologies['Laboratory']['name'].'<span style="color:grey;"> '.$getPathologies['ServiceCategory']['name'].','.$getPathologies['LaboratoryCategory']['category_name'].'</span></td>
				</tr>';
			}$patho.='</table>';
		}else{
			$patho.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
		}
		$patho .= "</div></div>" ;
		return $patho;
	}
	function microbiologi($getMicrobiology,$boxHtml){
		$countgetMicrobiology = count($getMicrobiology);
		$boxHtml = str_replace("{{recordCount}}",'('.$countgetMicrobiology.')',$boxHtml);
		$microHtml = $boxHtml;
		if(!empty($getMicrobiology)){
			$microHtml.='<table  width="100%"> <tr><td style="background-color:#ccc">Last 3 Weeks For All Visits</td></tr></table>';
			$microHtml.='<table width="100%">';
			foreach($getMicrobiology as $getMicrobiologies){
				$microHtml.= '<tr class="light">
								<td>'.$getMicrobiologies['Laboratory']['name'].'<span style="color:grey;"> '.$getMicrobiologies['ServiceCategory']['name'].','.$getMicrobiologies['LaboratoryCategory']['category_name'].'</span></td>
										</tr>';
			}$microHtml.='</table>';
		}else{
			$microHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
		}
	
		$microHtml .= "</div></div>" ;
		return $microHtml;
	
	}
	function patient_background($getAdvanceDirective,$getFallRiskScore,$getPainScore,$getResuscitationStatus,$getActivity,$getDiet,$boxHtml,$dateFormate){
		$boxHtml = str_replace("{{recordCount}}",'',$boxHtml);
		$pt_background = $boxHtml;
		$pt_background.='<table  width="100%"> <tr><td style="background-color:#ccc">Selected Visits</td></tr></table>';
		$pt_background.= '<table width="100%">';
		if($getAdvanceDirective['PatientPersonalHistory']['diet']){
			$dataAdvance="Diet/Nutrition :";
		}else{
			$dataAdvance="";
		}
		if(!empty($getAdvanceDirective)){
		$toolTip = '<b>Diet/Nutrition :</b> '.wordwrap($getAdvanceDirective['PatientPersonalHistory']['diet'],80,"<br>\n").'</br>
					<b>Recent weight loss/gain :</b> '.$getAdvanceDirective['PatientPersonalHistory']['diet_exp'].'</br>';
		}
		if(!empty($getAdvanceDirective)){
			$pt_background.= '<tr class="tooltip light" title="'.$toolTip.'">
											<td  width="25%">'.$dataAdvance.'</td>
											<td align="">'.$getAdvanceDirective['PatientPersonalHistory']['diet'].' </td><td><span style="color:grey;"> '.$getAdvanceDirective['PatientPersonalHistory']['diet_exp'].'</span></td>
					</tr>';
		}
			
		if(!empty($getFallRiskScore)){
			$pt_background.= '<tr class="light">
					<td width="25%">'.$getFallRiskScore['ReviewSubCategoriesOption']['name'].'</td>
					<td align=""><font color="red">'.$getFallRiskScore['ReviewPatientDetail']['values'].'</font></td>
					</tr>';
		}
		if(!empty($getPainScore)){
	
			$pt_background.= '<tr class="light">
					<td width="25%">Pain Score</td>
					<td>(';
			$firstValCnt =0;
			foreach($getPainScore as $key => $painScore ){
				
				$pt_background.=''.$painScore['ReviewPatientDetail']['values'];
				$pt_background.= ($firstValCnt == 0) ? ')' : '';
				$pt_background.= ', ';
				$firstValCnt++;
			}
			$pt_background = rtrim($pt_background, ", ");
			$pt_background.= '</td>
									</tr>';
	
		}
		//comment discuss with sheetal (to hide  Admit to: and Resuscitation Status:)
		/* if(!empty($getResuscitationStatus)){
			foreach($getResuscitationStatus as $getResuscitation){
				$pt_background.= '<tr class="light">
					<td width="25%">'.$getResuscitation['PatientOrder']['name'].'</td>
						<td align="">'.$dateFormate->formatDate2Local($getResuscitation['MultipleOrderContaint']['start_date'],Configure::read('date_format'),true).', '.$getResuscitation['MultipleOrderContaint']['resuscitation_status'].'</td>
							</tr>';
			}
		} */
		if(!empty($getActivity)){
			foreach($getActivity as $getActiviti){
				if($getActiviti['MultipleOrderContaint']['constant_order'] == '1'){
					$displayData='Constant Order';
				}else{
					$displayData='';
				}
				$pt_background.= '<tr class="light">
							<td width="25%">'.$getActiviti['PatientOrder']['name'].'</td>
							<td align="">'.$dateFormate->formatDate2Local($getActiviti['MultipleOrderContaint']['start_date'],Configure::read('date_format'),true).', '.$displayData.', '.$getActiviti['MultipleOrderContaint']['special_instruction'].'</td>
					</tr>';
			}
		}
		if(!empty($getDiet)){
			foreach($getDiet as $getDiets){
				$pt_background.= '<tr class="light">
					<td width="25%">'.$getDiets['PatientOrder']['name'].'</td>
					<td align="">'.$dateFormate->formatDate2Local($getDiets['MultipleOrderContaint']['start_date'],Configure::read('date_format'),true).', '.$getDiets['MultipleOrderContaint']['special_instruction'].'</td>
					</tr>';
			}
		}
		$pt_background.='</table>';
	
		$pt_background .=    '</div></div>'  ;
	
		return $pt_background;
	}
	function immunization($getImmunization,$boxHtml,$dateformate,$immunizationLink){
		$countgetImmunization = count($getImmunization);
		$boxHtml = str_replace("{{recordCount}}",'('.$countgetImmunization.')',$boxHtml);
		$immunizationHtml = $boxHtml;
		$immunizationHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$immunizationLink.'</td></tr></table>';
		
		if(!empty($getImmunization)){
			
			$immunizationHtml.='<table width="100%">
								<tr style="background-color:#ccc">
									<td>Immunization</td>
									<td>Administration Date</td>
									<td>Manufacturer Name</td>
								</tr>';
			
			foreach($getImmunization as $getImmuData){
				$toolTip = '<b>Immunization:</b> '.wordwrap($getImmuData['Imunization']['cpt_description'],80,"<br>\n").'</br>';
				if(!empty($getImmuData['Immunization']['amount'])){
				$toolTip.= '<b>Administered Amount:</b> '.$getImmuData['Immunization']['amount'].' '.$getImmuData['PhvsMeasureOfUnit']['value_code'].' </br>';
				}
				$toolTip.= '<b>Lot Number:</b> '.$getImmuData['Immunization']['lot_number'].'</br>
							<b>Manufacturer Name:</b> '.$getImmuData['PhvsVaccinesMvx']['description'].'</br>
							<b>Administration Date:</b> '.$dateformate->formatDate2Local($getImmuData['Immunization']['date'],Configure::read('date_format'),false).'</br>
							<b>Vaccine Expiration Date:</b> '.$dateformate->formatDate2Local($getImmuData['Immunization']['expiry_date'],Configure::read('date_format'),false).'</br>'; 
				 
				$immunizationHtml.='<tr class="tooltip light" title="'.$toolTip.'">
							<td >'.$getImmuData['Imunization']['cpt_description'].'</td>
							<td><span style="color:grey;">'.$dateformate->formatDate2Local($getImmuData['Immunization']['date'],Configure::read('date_format'),false).'</span></td>
							<td>'.$getImmuData['PhvsVaccinesMvx']['description'].'</td>
						</tr>';
	
			}
			$immunizationHtml.='</table>';
		}else{
			$immunizationHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
		}
	
		$immunizationHtml .= "</div></div>" ;
		return $immunizationHtml;
	}
	/*
	function order($getOrders,$boxHtml,$dateFormate){
		$countgetOrders = count($getOrders);
		$boxHtml = str_replace("{{recordCount}}",'('.$countgetOrders.')',$boxHtml);
		$orderHtml= $boxHtml;
		if(!empty($getOrders)){
			$orderHtml.='<table  width="100%"> <tr><td style="background-color:#ccc">Selected Visits</td></tr></table>';
			$orderHtml.= '<table width="100%">';
			$orderHtml.= '<tr><td></td><td><span style="color:grey;">Status</span></td><td><span style="color:grey;">Ordered</span></td></tr>';
			foreach($getOrders as $getOrder){
				$toolTip = 'Order : '.$getOrder['PatientOrder']['name'].'</br>
							Order Details :'.$getOrder['PatientOrder']['sentence'].'</br>
								Order Date/Time : '.$dateFormate->formatDate2Local($getOrder['PatientOrder']['create_time'],Configure::read('date_format'),false).'</br>
										Start Date/Time :'.$dateFormate->formatDate2Local($getOrder['PatientOrder']['create_time'],Configure::read('date_format'),false).' </br>
										Status : '.$getOrder['PatientOrder']['status'].'</br>
										Ordered By :'.$getOrder[0]['full_name'].'</br>';
				$orderHtml.= '
				
			<tr class="tooltip light" title="'.$toolTip.'">
				<td>'.$getOrder['PatientOrder']['name'].'</td><td>'.$getOrder['PatientOrder']['status'].'</td><td><span style="color:grey;">('.$dateFormate->formatDate2Local($getOrder['PatientOrder']['create_time'],Configure::read('date_format'),false).')</span></td>
					</tr>';
			}
			$orderHtml.='</table>';
		}else{
			$orderHtml.='<table>
							<tr><td><span style="color:grey;">No Result Found</span></td></tr>
							</table>';
		}
	
		$orderHtml .= '</div></div>' ;
		return $orderHtml;
	}
	*/
	function order($getLabOrders,$getRadOrders,$boxHtml,$dateFormate){
		
		$countgetOrders = (count($getLabOrders) + count($getRadOrders));
		$boxHtml = str_replace("{{recordCount}}",'('.$countgetOrders.')',$boxHtml);
		$orderHtml= $boxHtml;
		if(!empty($getLabOrders) || !empty($getRadOrders)){
			$orderHtml.='<table  width="100%"> <tr><td style="background-color:#ccc">Selected Visits</td></tr></table>';
			
			$orderHtml.= '<table width="100%">';
			$orderHtml.= '<tr style="background-color:#ccc"><td>Lab Name</td><td>Status</td><td>Result</td></tr>';
			foreach($getLabOrders as $data){
				if($data["LaboratoryHl7Result"]["abnormal_flag"]=='HH' || $data["LaboratoryHl7Result"]["abnormal_flag"]=='H'){
					$satus="Higer than Normal Range";
				}else if($data["LaboratoryHl7Result"]["abnormal_flag"]=='LL' || $data["LaboratoryHl7Result"]["abnormal_flag"]=='L'){
					$satus="Lower than Normal Range";
				}
				else if($data["LaboratoryHl7Result"]["abnormal_flag"]=='N'){
					$satus="Normal";
				}
				else{
					$satus='';
				}
				 if(!empty($satus))
					 $satus;
				else
					$satus = "...";
				if(empty($data["LaboratoryHl7Result"]["result"]))
					$result='Result Not Published';
				else
					$result=$data["LaboratoryHl7Result"]["result"];
				$toolTip = '<b>Name:</b> '.wordwrap($data["Laboratory"]["name"],80,"<br>\n").'</br>
							<b>Status:</b> '.$satus.'</br>
							<b>Result:</b> '.$result.'</br>';
				$orderHtml.= '
			
				<tr class="tooltip light" title="'.$toolTip.'">
				<td>'.$data["Laboratory"]["name"].'</td><td>'.$satus.'</td><td>'.$result.'</td>
				</tr>';
			}
			$orderHtml.= '</table><table width="100%">';
			if(!empty($getRadOrders)){
				$orderHtml.= '<tr style="background-color:#ccc" ><td>Radiology Test Name</span></td><td>Result</td></tr>';
				foreach($getRadOrders as $dataRad){
						if($dataRad["RadiologyResult"]["img_impression"]!='Negative' &&($dataRad["RadiologyResult"]["img_impression"])){
							$result='Normal';
						 }else if(empty($dataRad["RadiologyResult"]["img_impression"])){
							$result='Not Published';
						}else{
								$result='Abnormal';
										}
					$toolTip = '<b>Radiology Test Name:</b> '.wordwrap($dataRad["Radiology"]["name"],80,"<br>\n").'</br>
								<b>Result:</b> '.$result.'</br>';
					$orderHtml.= '<tr class="tooltip light" title="'.$toolTip.'">
									<td>'.$dataRad["Radiology"]["name"].'</td><td>'.$result.'</td>
								</tr>';
				}
			}
			
			$orderHtml.='</table>';
			
		}else{
			$orderHtml.='<table>
							<tr><td><span style="color:grey;">No Result Found</span></td></tr>
							</table>';
		} 
		
		$orderHtml .= '</div></div>' ;
		return $orderHtml;
	}
	function oxygenation($getQxygenationVantilation,$getLastBloodGases,$getPreviousBloodGases,$boxHtml){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$oxygenationHtml = $boxHtml;
	
		if(!empty($getQxygenationVantilation)){
			$oxygenationHtml.='<table width="100%"> <tr><td style="background-color:#ccc">Selected Visits</td></tr></table>';
			$boxHtml1 =  '<div class="dragbox_inner" id="vanti_info" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Ventilator Information</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$oxygenationHtml .= $boxHtml1.'';
			if(!empty($getQxygenationVantilation)){
				$oxygenationHtml .='<table width="100%">';
				foreach($getQxygenationVantilation as $getQxygen){
					$oxyDate=date('m/d/y', strtotime($getQxygen['ReviewPatientDetail']['date']));
					$oxygenationHtml.='<tr class="light"><td>'.$getQxygen['ReviewSubCategoriesOption']['name'].'</td> <td>'.$getQxygen['ReviewPatientDetail']['values'].'</td> <td><span style="color:grey;">'.$oxyDate.' '.$getQxygen['ReviewPatientDetail']['hourSlot'].':00</span></td></tr>';
				}
				$oxygenationHtml.='</table>';
			}else{
				$oxygenationHtml.='<table>
									<tr><td><span style="color:grey;">No Result Found</span></td></tr>
									</table>';
			}
			$oxygenationHtml .= "</div></div>";
				
			$boxHtml1 =  '<div class="dragbox_inner" id="last_blood_gass" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Last Blood Gas Arterial Results</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$oxygenationHtml .= $boxHtml1.'';
			if(!empty($getLastBloodGases)){
				$oxygenationHtml .='<table width="100%">';
				foreach($getLastBloodGases as $getlast){
					$oxygenationHtml.='<tr class="light"><td>'.$getlast['Laboratory']['name'].'</td> <td><span style="color:grey;">'.$getlast['LaboratoryHl7Result']['result'].'</span></td> </tr>';
				}
				$oxygenationHtml.='</table>';
			}else{
				$oxygenationHtml.='<table>
				<tr><td><span style="color:grey;">No Result Found</span></td></tr>
				</table>';
			}
			$oxygenationHtml .= "</div></div>";
			$boxHtml1 =  '<div class="dragbox_inner" id="intake" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Previous Blood Gas Arterial Results</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$oxygenationHtml .= $boxHtml1.'';
			if(!empty($getPreviousBloodGases)){
				$oxygenationHtml .='<table width="100%">';
				foreach($getPreviousBloodGases as $getPreviousBloodGasesa){
						
					$oxygenationHtml.='<tr class="light"><td>'.$getPreviousBloodGasesa['Laboratory']['name'].'</td> <td><span style="color:grey;">'.$getPreviousBloodGasesa['LaboratoryHl7Result']['result'].'</span></td> </tr>';
				}
				$oxygenationHtml.='</table>';
			}else{
				$oxygenationHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
			}
			$oxygenationHtml .= "</div></div>";
	
		}else{
			$oxygenationHtml .='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
		}
		$oxygenationHtml .= "</div></div>" ;
		return $oxygenationHtml;
	} 
	function overdue_tasks($getOverdueTask,$getOverdueTaskLab,$boxHtml){//debug($getOverdueTaskLab);//gaurav
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$overdue_tasksHtml = $boxHtml;
		$overdue_tasksHtml.='<table  width="100%"> <tr><td style="background-color:#ccc">Last 1 day for the selected Visits</td></tr></table>';
		if(!empty($getOverdueTask) || !empty($getOverdueTaskLab) ){
			$overdue_tasksHtml.= '<table width="100%">';
			foreach($getOverdueTask as $over){
				$overdue_tasksHtml.= '
					<tr class="light">
					<td  width="65%" >'.$over['NewCropPrescription']['drug_name'].'</td><td><span style="color:grey;">('.$over['MedicationAdministeringRecord']['performed_datetime'].')</span></td>
					</tr>';
			}
			$overdue_tasksHtml.='</table>';
			//----lab----
			$overdue_tasksHtml.='<table  width="100%"> <tr><td style="background-color:#ccc">Lab Overdue</td></tr></table>';
			$overdue_tasksHtml.= '<table width="100%">';
			foreach($getOverdueTaskLab[0] as $overLab){
				$overdue_tasksHtml.= '
					<tr class="light">
					<td>'.$overLab['Laboratory']['name'].'</td><td><span style="color:grey;">('.$overLab['LaboratoryTestOrder']['start_date'].')</span></td>
				</tr>';
			}
			$overdue_tasksHtml.='</table>';
			//----Rad--------
			$overdue_tasksHtml.='<table  width="100%"> <tr><td style="background-color:#ccc">Rad Overdue</td></tr></table>';
			$overdue_tasksHtml.= '<table width="100%">';
			foreach($getOverdueTaskLab[1] as $overRad){
				$overdue_tasksHtml.= '
					<tr class="light">
					<td>'.$overRad['Radiology']['name'].'</td><td><span style="color:grey;">('.$overRad['RadiologyTestOrder']['radiology_order_date'].')</span></td>
				</tr>';
			}
			$overdue_tasksHtml.='</table>';
		}else{
			$overdue_tasksHtml.='<table>
			<tr><td><span style="color:grey;">No Result Found</span></td></tr>
			</table>';
		}
	
		$overdue_tasksHtml .= '</div></div>' ;
		return $overdue_tasksHtml ;
	}
	
	/* function defaultFunction($getLabsGroupList,$getPastValueWithLaboratory,$boxHtml){
	 $boxHtml = str_replace("{{recordCount}}","",$boxHtml);
	$nursing_plan_careHtml = $boxHtml;
	$nursing_plan_careHtml.='</div></div>';
	return $nursing_plan_careHtml ;
	 
	} */
	function initialAssessment($getInitialAssess,$boxHtml,$dateFormate){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$initialAsseHtml = $boxHtml;
		$initialAsseHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">Initial Assessment</td></tr></table>';
		if(!empty($getInitialAssess)){
			$initialAsseHtml.= '<table width="100%" cellspacing="0" cellpadding="0" class="tdLabel">';
			foreach($getInitialAssess as $getInAss){
				if(!empty($getInAss['Diagnosis']['id']) ){
				$initialAsseHtml.= ' 
						<tr class="light inni-link pointer" id="'.$getInAss['Diagnosis']['patient_id']."_".$getInAss['Diagnosis']['id'].'"> 
							<td>'.$getInAss['0']['dr_full_name'].':</td>';
					if(!empty($getInAss['Diagnosis']['modify_time']) && ($getInAss['Diagnosis']['modify_time'] !='0000-00-00 00:00:00')){
						$timeStamp = $dateFormate->formatDate2Local($getInAss['Diagnosis']['modify_time'],Configure::read('date_format'),true);
					}else{
						$timeStamp = $dateFormate->formatDate2Local($getInAss['Diagnosis']['create_time'],Configure::read('date_format'),true);
					}
					$initialAsseHtml.= '<td >'.$timeStamp.'</td>
						</tr>';
				}
			}
			$initialAsseHtml.= '</table>';
		}else{
			$initialAsseHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
		}
		$initialAsseHtml.='</div></div>';
		return $initialAsseHtml;
	}
	function nursing_plan($getNursingPlansCare,$boxHtml){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$nursing_plan_careHtml = $boxHtml;
		$nursing_plan_careHtml.='</div></div>';
		return $nursing_plan_careHtml ;
	}
	function quality_measures($getQualityMeasure,$boxHtml){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$quality_measuresHtml = $boxHtml;
		$quality_measuresHtml.='</div></div>';
		return $quality_measuresHtml ;
	}
	
	function patient_family_education($getPatientFamilyEducation,$boxHtml,$dateFormate,$general,$html,$getLabsName,$noteDiagnoses){
		$countDiagnoses = count($noteDiagnoses);
		$countMedication = count($getPatientFamilyEducation);
		$countLabs = count($getLabsName);
		$countOfRecord=($countDiagnoses + $countMedication + $countLabs);
		$boxHtml = str_replace("{{recordCount}}",'('.$countOfRecord.')',$boxHtml);
		$patient_family_educationHtml = $boxHtml;
		
		$patient_family_educationHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits</td></tr></table>';
		if(!empty($noteDiagnoses) || !empty($getPatientFamilyEducation) || !empty($getLabsName) ){
			$boxHtml1=  '<div class="dragbox_inner" id="diagnoses" >';
			$boxHtml1.= '<h2 style="background:#d2ebf2"><div style="display:inline" >Diagnoses ('.$countDiagnoses.')</div></h2>';
			$boxHtml1.= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_family_educationHtml.= $boxHtml1.'';
		
			$patient_family_educationHtml.= '<table width="100%">
								<tr style="background-color:grey;height:10px;">
								<td align="center" style="border-right:1px solid #fff;">Diagnoses</td><td align="center" style="border-right:1px solid #fff;">Start Date</td><td align="center" colspan="2">Information</td>
								</tr>';
			
			foreach($noteDiagnoses as $noteDiagnoses){
			$startDate=$dateFormate->formatDate2Local($noteDiagnoses['NoteDiagnosis']['start_dt'],Configure::read('date_format'),false);
				$icd_id=$noteDiagnoses['NoteDiagnosis']['snowmedid']; 
				$diagnoses_name=$noteDiagnoses['NoteDiagnosis']['diagnoses_name'];
				$id=$noteDiagnoses['NoteDiagnosis']['patient_id'];
				$primaryID=$noteDiagnoses['NoteDiagnosis']['id'];
				$toolTip1 = '<b>Diagnoses Name:</b> '.wordwrap($noteDiagnoses['NoteDiagnosis']['diagnoses_name'],80,"<br>\n").'</br>
						 	 <b>ICD_ID:</b> '.$noteDiagnoses['NoteDiagnosis']['icd_id'].'</br>
							 <b>Diagnoses Status:</b> '.$noteDiagnoses['NoteDiagnosis']['disease_status'].'</br>';				
					$patient_family_educationHtml.='<tr class="light">
								<td class="tooltip light" title="'.$toolTip1.'" align="left" style="border-right:1px solid #fff;">'.$noteDiagnoses['NoteDiagnosis']['diagnoses_name'].'</td>
								<td align="center" style="border-right:1px solid #fff;">'.$startDate.'</td>';
					$patient_family_educationHtml.="<!--<td align='right' onclick=\"javascript:icdwin('$diagnoses_name','$id')\" class='info_button' alt='Info Button' title='Info Button' valign='middle'></td>-->		
								<td  align='right' onclick=\"javascript:icdwin('$icd_id','$diagnoses_name','$id','$primaryID')\" class='info_button' alt='Info Button' title='Info Button' valign='middle'></td>		
								<!--<td align='center'>".$html->link($html->image('/img/icons/Leaflet_1.png'), 'http://online.lexi.com/lco/action/pcm', array('target' => '_blank','escape'=>false,'alt'=>'leaflet','title'=>'leaflet','valign'=>'top')) ."</td>-->
					</tr>";
				
			}
			$patient_family_educationHtml.='</table>';
			$patient_family_educationHtml.='</div></div>';
			
			
			$boxHtml1=  '<div class="dragbox_inner" id="medication" >';
			$boxHtml1.= '<h2 style="background:#d2ebf2"><div style="display:inline" >Medications ('.$countMedication.')</div></h2>';
			$boxHtml1.= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_family_educationHtml.= $boxHtml1.'';
			
			$patient_family_educationHtml.= '<table width="100%">
								<tr style="background-color:grey;height:10px;">
								<td align="center" style="border-right:1px solid #fff;">Medications/Investigations</td><td align="center" style="border-right:1px solid #fff;">Date</td><td align="center" colspan="2">Information</td>
								</tr>';
			$dose = Configure :: read('dose_type');
			$route = Configure :: read('route_administration');
			$freq = Configure :: read('frequency');
			foreach($getPatientFamilyEducation as $getPatientFamilyEducation){ 
				//$startDate=$dateFormate->formatDate2Local($getPatientFamilyEducation['NewCropPrescription']['date_of_prescription'],Configure::read('date_format'),false);
				$date_prescription=explode("-",$getPatientFamilyEducation['NewCropPrescription']['date_of_prescription']);
				$startDate=$date_prescription["1"]."/".substr($date_prescription["2"],0,2)."/".$date_prescription["0"];
				$drug_id=$getPatientFamilyEducation['NewCropPrescription']['drug_id'];
				$patientId=$getPatientFamilyEducation['NewCropPrescription']['patient_uniqueid'];
				$newcrop_id=$getPatientFamilyEducation['NewCropPrescription']['id'];
				$medication_name=stripslashes($getPatientFamilyEducation['NewCropPrescription']['description']);
				$toolTip2 = '<b>Description:</b> '.stripslashes($getPatientFamilyEducation['NewCropPrescription']['description']).'</br>
							 <b>Dose:</b> '.$dose[$getPatientFamilyEducation['NewCropPrescription']['dose']].'</br>
							 <b>Route:</b> '.$route[$getPatientFamilyEducation['NewCropPrescription']['route']].' </br>
							 <b>Frequency:</b> '.$freq[$getPatientFamilyEducation['NewCropPrescription']['frequency']].'</br>
							 <b>Data of prescription:</b> '.$startDate.'</br>';
				$toolTips = addslashes(htmlspecialchars($toolTip2, ENT_QUOTES));
					$patient_family_educationHtml.='<tr class="light tooltip" title="'.$toolTips.'">';
					$patient_family_educationHtml.='<td align="left" style="border-right:1px solid #fff;">'.stripslashes($getPatientFamilyEducation['NewCropPrescription']['description']).'</td>
								<td align="center" style="border-right:1px solid #fff;">'.$startDate.'</td>';
					$patient_family_educationHtml.='<td width="10%" align="right" onclick=\'javascript:infobutton("'.$drug_id.'","'.$patientId.'","'.$newcrop_id.'")\' class="info_button_orange" alt="Info Button" title="Info Button" valign="middle"></td>';
					$patient_family_educationHtml.='<td align="right" drug_id="'.$drug_id.'" newcrop_id="'.$newcrop_id.'" id="'.$general->clean(stripslashes($getPatientFamilyEducation['NewCropPrescription']['description'])).'" name ="'.stripslashes($getPatientFamilyEducation['NewCropPrescription']['description']).'"  class="info_button info_button2 infomedication" alt="Info Button" title="Info Button"></td>
					</tr>';
				
			}
			$patient_family_educationHtml.='</table>';
			$patient_family_educationHtml.='</div></div>';
		
			
			$boxHtml1=  '<div class="dragbox_inner" id="labs" >';
			$boxHtml1.= '<h2 style="background:#d2ebf2"><div style="display:inline" >Labs ('.$countLabs.')</div></h2>';
			$boxHtml1.= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_family_educationHtml.= $boxHtml1.'';
			
			$patient_family_educationHtml.= '<table width="100%">
								<tr style="background-color:grey;height:10px;">
								<td align="center" style="border-right:1px solid #fff;">Labs</td><td align="center" style="border-right:1px solid #fff;">Date</td>
								</tr>';
						//<td align="center" colspan="2">Information</td>
			
			foreach ($getLabsName as $getLabsName){
				$startDate=$dateFormate->formatDate2LocalForReport($getLabsName['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),false);
				$lab_id=$getLabsName['Laboratory']['lonic_code'];
				$labs_name=$getLabsName['Laboratory']['name'];
				$toolTip3 = '<b>Lab Name:</b> '.wordwrap($getLabsName['Laboratory']['name'],80,"<br>\n").'</br>';
				
					$patient_family_educationHtml.='<tr class="light">
								<td class="tooltip light" title="'.$toolTip3.'" align="left" style="border-right:1px solid #fff;">'.$getLabsName['Laboratory']['name'].'</td>
								<td align="center" style="border-right:1px solid #fff;">'.$startDate.'</td>';
							//	<td align="right" id="'.$general->clean($lab_id).'" name ="'.$lab_id.'"  class="info_button infolab " alt="Info Button" title="Info Button"></td>';
				//	<td align='center'>".$html->link($html->image('/img/icons/Leaflet_1.png'), 'http://online.lexi.com/lco/action/pcm', array('target' => '_blank','escape'=>false,'alt'=>'leaflet','title'=>'leaflet','valign'=>'top')) ."</td>
				$patient_family_educationHtml.="	</tr>";
				
			}
			$patient_family_educationHtml.='</table>';
			$patient_family_educationHtml.='</div></div>';
		}else{
				$patient_family_educationHtml.='<table><tr><td><span style="color:grey;">No Result Found</span></td></tr></table>';
		}
		$patient_family_educationHtml.= "</div></div>" ;
		return $patient_family_educationHtml;
		
		
	}
	function getPlan($getHospital,$getSpecialist,$linkToHospital,$linkToSpecialist,$boxHtml,$dateFormat){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$discharge_planHtml = $boxHtml;
		$discharge_planHtml.='<table><tr><td><span style="background:#d2ebf2;">'.$linkToHospital.'</span></td></tr></table>';
		$discharge_planHtml.= '<table width="100%" cellspacing="0" cellpadding="0" class="">';
		$discharge_planHtml.= '<tr class=trShow>
									<td>Transitioned to</td>
									<td>Name of Hospital/ER</td>
									<td>Location of Hospital/ER</td>
								</tr>';
						foreach($getHospital as $data){
				$toolTip = '<b>Ordering Provider:</b> '.wordwrap($data['ReferralToHospital']['provider'],80,"<br>\n").'</br>
							<b>Transitioned to:</b> '.wordwrap($data['ReferralToHospital']['transitioned_to'],80,"<br>\n").'</br>
							<b>Name of Hospital/ER:</b> '.wordwrap($data['ReferralToHospital']['name_of_er'],80,"<br>\n").'</br>
							<b>Location of Hospital/ER:</b> '.wordwrap($data['ReferralToHospital']['location_of_er'],80,"<br>\n").'</br>
							<b>Department in Hospital/ER:</b> '.wordwrap($data['ReferralToHospital']['department_of_er'],80,"<br>\n").'</br>
							<b>Date transitioned to:</b> '.$dateFormat->formatDate2Local($data['ReferralToHospital']['transitioned_date'],Configure::read('date_format'),false).'</br>
							<b>Date summary of care provided:</b> '.$dateFormat->formatDate2Local($data['ReferralToHospital']['summary_of_care_provided_date'],Configure::read('date_format'),false).'</br>
							<b>If summary of care not provided, Reason:</b> '.wordwrap($data['ReferralToHospital']['reason'],80,"<br>\n").'</br>
							<b>Date of follow up with Hospital:</b> '.$dateFormat->formatDate2Local($data['ReferralToHospital']['follow_up_date'],Configure::read('date_format'),false).'</br>
							<b>Log of follow up call:</b> '.wordwrap($data['ReferralToHospital']['log'],80,"<br>\n").'</br>
							<b>Date hospital discharge summary obtained:</b> '.$dateFormat->formatDate2Local($data['ReferralToHospital']['discharge_date'],Configure::read('date_format'),false).'</br>
							<b>Follow up appointment:</b> '.wordwrap($data['ReferralToHospital']['follow_up_appointment'],80,"<br>\n").'</br>
							<b>Written transition care plan:</b> '.wordwrap($data['ReferralToHospital']['care_plan'],80,"<br>\n").'</br>
							<b>Status:</b> '.$data['ReferralToHospital']['status'].'</br>';
							
		  $discharge_planHtml.='<tr class="light tooltip" title="'.$toolTip.'">
									<td>'.$data['ReferralToHospital']['transitioned_to'].'</td>
									<td>'.$data['ReferralToHospital']['name_of_er'].'</td>
									<td>'.$data['ReferralToHospital']['location_of_er'].'</td>
								</tr>';
						}
		 $discharge_planHtml.='</table>';
		 $discharge_planHtml.='<table><tr><td><span style="background:#d2ebf2;">'.$linkToSpecialist.'</span></td></tr></table>';
		 $discharge_planHtml.= '<table width="100%" cellspacing="0" cellpadding="0" class="">';
		 $discharge_planHtml.= '<tr class=trShow>
									<td>Test or appointment Ordered</td>
									<td>Referred to</td>
									<td>Name of Specialist</td>
								</tr>';
		 foreach($getSpecialist as $dataSpecialist){
		 	$toolTip = '<b>Ordering Provider:</b> '.wordwrap($dataSpecialist['ReferralToSpecialist']['provider'],80,"<br>\n").'</br>
							<b>Test or appointment Ordered:</b> '.wordwrap($dataSpecialist['ReferralToSpecialist']['appt_order'],80,"<br>\n").'</br>
							<b>Referred to:</b> '.wordwrap($dataSpecialist['ReferralToSpecialist']['referred_to'],80,"<br>\n").'</br>
							<b>Name of Specialist:</b> '.wordwrap($dataSpecialist['ReferralToSpecialist']['specialist_name'],80,"<br>\n").'</br>
							<b>Location of Specialist :</b> '.wordwrap($dataSpecialist['ReferralToSpecialist']['location_specialist'],80,"<br>\n").'</br>
							<b>Speciality of Specialist :</b> '.$dataSpecialist['ReferralToSpecialist']['speciality_specialist'].'</br>
							<b>Referral initiated date:</b> '.$dateFormat->formatDate2Local($dataSpecialist['ReferralToSpecialist']['referral_initiated_date'],Configure::read('date_format'),false).'</br>
							<b>Date summary of care provided:</b> '.$dateFormat->formatDate2Local($dataSpecialist['ReferralToSpecialist']['date_summary'],Configure::read('date_format'),false).'</br>
							<b>If summary of care not provided, Reason :</b> '.$dataSpecialist['ReferralToSpecialist']['reason'].'</br>
							<b>Appointment date and time with specialist:</b> '.$dateFormat->formatDate2Local($dataSpecialist['ReferralToSpecialist']['appointment_date'],Configure::read('date_format'),false).'</br>
							<b>Expected date of receiving report:</b> '.$dateFormat->formatDate2Local($dataSpecialist['ReferralToSpecialist']['expected_date'],Configure::read('date_format'),false).'</br>
							<b>Log of effort to retrieve the report :</b> '.wordwrap($dataSpecialist['ReferralToSpecialist']['log'],80,"<br>\n").'</br>
							<b>Date report obtained:</b> '.wordwrap($dataSpecialist['ReferralToSpecialist']['report_date'],80,"<br>\n").'</br>
							<b>Status:</b> '.$dataSpecialist['ReferralToSpecialist']['status'].'</br>';
		 		
		 	$discharge_planHtml.='<tr class="light tooltip " title="'.$toolTip.'">
									<td>'.$dataSpecialist['ReferralToSpecialist']['appt_order'].'</td>
									<td>'.$dataSpecialist['ReferralToSpecialist']['referred_to'].'</td>
									<td>'.$dataSpecialist['ReferralToSpecialist']['specialist_name'].'</td>
								</tr>';
		 }
		$discharge_planHtml.='</div></div>';
		return $discharge_planHtml ;
	}
	function blank($getPlan,$boxHtml){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$discharge_planHtml = $boxHtml;
		$discharge_planHtml.='</div></div>';
		return $discharge_planHtml ;
	}
	function follow_up($getFollowUp,$boxHtml,$dateFormat){
		
		$countGetFollowUp = count($getFollowUp);
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$follow_upHtml = $boxHtml;
		$follow_upHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits</td></tr></table>';
		if(!empty($getFollowUp)){
			$follow_upHtml.= '<table width="100%" cellspacing="0" cellpadding="0" class="tdLabel">';
			foreach($getFollowUp as $getFollow){
					if($dateFormat->formatDate2Local($getFollow['Note']['create_time'],Configure::read('date_format'),false) == ''){
						$date = $dateFormat->formatDate2Local($getFollow['Note']['modify_time'],Configure::read('date_format'),false);
					}else{
						$date = $dateFormat->formatDate2Local($getFollow['Note']['create_time'],Configure::read('date_format'),false);
					}
					$plan = explode(':',$getFollow['Note']['plan']);
					if(!empty($plan[0])){
				$follow_upHtml.= '
					<tr class="light">
						<td>'.$plan[0].'<span style="color:grey;">&nbsp;('.$date.')</span></td>
					</tr>';
					}
			}
			$follow_upHtml.= '</table>';
		}else{
			$follow_upHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
		}
		$follow_upHtml.='</div></div>';
		return $follow_upHtml ;
	}
	function activities($getActivities,$boxHtml,$activitiesLink,$dateFormat){
		$boxHtml = str_replace("{{recordCount}}",'('.count($getActivities).')',$boxHtml);
		$activitiesHtml = $boxHtml;
		$activitiesHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">Selected Visits '.$activitiesLink.'</td></tr></table>';
		if(!empty($getActivities)){
			 $activitiesHtml.= '<table width="100%" cellspacing="0" cellpadding="0" class="tdLabel">';
			foreach($getActivities as $getActivity){
				$date = $dateFormat->formatDate2Local($getActivity['PhysiotherapyAssessment']['submit_date'],Configure::read('date_format'),false);
				$toolTip = '<b>Physiotherapist:</b> '.wordwrap($getActivity['PhysiotherapyAssessment']['physiotherapist_incharge'],80,"<br>\n").'</br>
							<b>Chief Complaints:</b> '.wordwrap($getActivity['PhysiotherapyAssessment']['chief_complaints'],80,"<br>\n").'</br>
							<b>Observation:</b> '.wordwrap($getActivity['PhysiotherapyAssessment']['observation'],80,"<br>\n").'</br>
							<b>Sensory:</b> '.wordwrap($getActivity['PhysiotherapyAssessment']['sensory'],80,"<br>\n").'</br>
							<b>Reflexes:</b> '.wordwrap($getActivity['PhysiotherapyAssessment']['reflexes'],80,"<br>\n").'</br>
							<b>Motor:</b> '.wordwrap($getActivity['PhysiotherapyAssessment']['motor'],80,"<br>\n").'</br>
							<b>Notes:</b> '.wordwrap($getActivity['PhysiotherapyAssessment']['notes'],80,"<br>\n").'</br>
							<b>Chest PT:</b> '.$getActivity['PhysiotherapyAssessment']['chest_pt'].'</br>
							<b>Limb PT:</b> '.$getActivity['PhysiotherapyAssessment']['limb_pt'].'</br>
							<b>Date:</b> '.$date.'</br>';
				
				$activitiesHtml.= '
					<tr class="light tooltip" title="'.$toolTip.'">
						<td>'.$getActivity['PhysiotherapyAssessment']['physiotherapist_incharge'].'</td>
						<td>'.$date.'</td>
					</tr>';
			}
			$activitiesHtml.= '</table>'; 
		}else{
			$activitiesHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
		}
		$activitiesHtml.='</div></div>';
		return $activitiesHtml ;
	}
	function line_tube_drain($getLinesTubeDrains,$boxHtml){
		$countData=count($getLinesTubeDrains);
		$boxHtml = str_replace("{{recordCount}}","$countData",$boxHtml);
		$line_tube_drainHtml = $boxHtml;
		if(!empty($getLinesTubeDrains)){
			$countData=count($getLinesTubeDrains);
			$line_tube_drainHtml.='<table width="100%"> <tr><td style="background-color:#ccc">Selected Visits</td></tr></table>';
			$line_tube_drainHtml.='<table width="100%"> <tr><td align="right"><span style="color:grey;">Last Documented</span></td></tr></table>';
			$boxHtml1 =  '<div class="dragbox_inner" id="tubes" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Lines('.$countData.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$line_tube_drainHtml .= $boxHtml1.'';
			$line_tube_drainHtml.='<table width="100%">';
			foreach($getLinesTubeDrains as $getline){
				$toolTip = 'Central IV Care : Cap(s) changed</br>
							Central IV Dressing : Dry,Intact,Reinforced,Transparent</br>
							Central IV Patency Proximal Port : No Complication</br>
							Central IV Patency Medical Port : No Complication</br>
							Central IV Patency Distal Port : No Complication</br>
							Central IV Site Condition : No Complication</br>
							Central IV Drainage Description : Serosanguineous</br>
							Internal Documented Date/Time : 06/04/2012 14:16</br>';
				$lineDate=date('m/d/y', strtotime($getline['ReviewPatientDetail']['date']));
				$line_tube_drainHtml.='<tr class="tooltip light" title="'.$toolTip.'">
							<td>'.$getline['ReviewSubCategoriesOption']['name'].'</td>  <td align="right"><span style="color:grey;">'.$lineDate.' '.$getline['ReviewPatientDetail']['hourSlot'].':00</span></td></tr>';
			}
	
			$line_tube_drainHtml.='	</table>
				</div></div>';
			$boxHtml1 =  '<div class="dragbox_inner" id="Drains" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Tubes/Drains(count)</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
	
			$line_tube_drainHtml .= $boxHtml1.'
					<table>
	
					<tr>
					<td>Inner part</td>
					</tr>
					</table>
					</div></div>';
		}else{
			$line_tube_drainHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
		}
	
		$line_tube_drainHtml .= "</div></div>" ;
		return $line_tube_drainHtml;
	}
	
	function patient_assessment($getPatientAssessmentPain,$getPatientAssessmentNeuro,$getPatientAssessmentRespratory,
			$getPatientAssessmentCardiovascular,$getPatientAssessmentGI,$getPatientAssessmentGU,$getPatientAssessmentIntegumentary,$getPatientMentalStatus,$getSwallowScreen,$getPupilAssessment,$getMusculoskeletalAssessment,$getMechanicalVentilation,$getEdemaAssessment,$getUrinaryCatheter,$getBradenAssessment,$getFallRiskScaleMorse,$boxHtml){
	
		$countData=count($getPatientAssessmentPain) + count($getPatientAssessmentNeuro) + count($getPatientAssessmentRespratory)+
		count($getPatientAssessmentCardiovascular) + count($getPatientAssessmentGI) + count($getPatientAssessmentGU) + count($getPatientAssessmentIntegumentary) +
		count($getPatientMentalStatus) + count($getSwallowScreen) + count($getPupilAssessment) + count($getMusculoskeletalAssessment) + count($getMechanicalVentilation) +
		count($getEdemaAssessment) + count($getUrinaryCatheter) + count($getBradenAssessment) + count($getFallRiskScaleMorse) ;
		$boxHtml = str_replace("{{recordCount}}",'('.$countData.')',$boxHtml);
		$patient_assessmentHtml = $boxHtml;
		//	if(!empty($getPatientAssessment)){
		$countPain=count($getPatientAssessmentPain);
		$patient_assessmentHtml.='<table width="100%"> <tr><td style="background-color:#ccc">Selected Visits</td></tr></table>';
		if(!empty($getPatientAssessmentPain)){
			$boxHtml1 =  '<div class="dragbox_inner" id="pain" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Pain('.$countPain.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getPatientAssessmentPain)){
				$patient_assessmentHtml .='<table width="100%">';
				foreach ($getPatientAssessmentPain as $datapain){
					$patient_assessmentHtml.='<tr class="light">
					<td>'.$datapain['ReviewSubCategoriesOption']['name'].'</td>
									<td width="25%">'.$datapain['ReviewPatientDetail']['values'].'</td>
				<td width="25%"><span style="color:grey;">'.$datapain['ReviewPatientDetail']['date'].' '.$datapain['ReviewPatientDetail']['actualTime'].' </span></td>
				</tr>';
				}
				$patient_assessmentHtml.='</table>';
			}else{
				$patient_assessmentHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
			$countNeuro=count($getPatientAssessmentNeuro);
			$boxHtml1 =  '<div class="dragbox_inner" id="neuro" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Neuro('.$countNeuro.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
	
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getPatientAssessmentNeuro)){
				$patient_assessmentHtml .='<table width="100%">';
				foreach ($getPatientAssessmentNeuro as $dataNeuro){
					$patient_assessmentHtml.='<tr class="light">
							<td>'.$dataNeuro['ReviewSubCategoriesOption']['name'].'</td>
							<td width="25%">'.$dataNeuro['ReviewPatientDetail']['values'].'</td>
							<td width="25%"><span style="color:grey;">'.$dataNeuro['ReviewPatientDetail']['date'].' '.$dataNeuro['ReviewPatientDetail']['actualTime'].' </span></td>
						</tr>';
				}
				$patient_assessmentHtml.='</table>';
			}else{
				$patient_assessmentHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//------------
		$countRespratory=count($getPatientAssessmentRespratory);
		if(!empty($getPatientAssessmentRespratory)){
			$boxHtml1 =  '<div class="dragbox_inner" id="respratory" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Respiratory('.$countRespratory.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getPatientAssessmentRespratory)){
				$patient_assessmentHtml .='<table width="100%">';
				foreach ($getPatientAssessmentRespratory as $dataResp){
					$patient_assessmentHtml.='<tr class="light">
						<td>'.$dataResp['ReviewSubCategoriesOption']['name'].'</td>
					<td width="25%">'.$dataResp['ReviewPatientDetail']['values'].'</td>
					<td width="25%"><span style="color:grey;">'.$dataResp['ReviewPatientDetail']['date'].' '.$dataResp['ReviewPatientDetail']['actualTime'].'</span> </td>
					</tr>';
				}
					
				$patient_assessmentHtml.='</table>';
			}else{
				$patient_assessmentHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//-------------
		$countCardiovascular=count($getPatientAssessmentCardiovascular);
		if(!empty($getPatientAssessmentCardiovascular)){
			$boxHtml1 =  '<div class="dragbox_inner" id="cardio" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Cardiovascular('.$countCardiovascular.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getPatientAssessmentCardiovascular)){
				$patient_assessmentHtml .= '<table width="100%">';
				foreach ($getPatientAssessmentCardiovascular as $dataCar){
					$patient_assessmentHtml.='<tr class="light">
				<td>'.$dataCar['ReviewSubCategoriesOption']['name'].'</td>
				<td width="25%">'.$dataCar['ReviewPatientDetail']['values'].'</td>
				<td width="25%"><span style="color:grey;">'.$dataCar['ReviewPatientDetail']['date'].' '.$dataCar['ReviewPatientDetail']['actualTime'].'</span> </td>
					</tr>';
				}
				$patient_assessmentHtml.='</table>';
			}else{
				$patient_assessmentHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//-------------
		$countGI=count($getPatientAssessmentGI);
		if(!empty($getPatientAssessmentGI)){
			$boxHtml1 =  '<div class="dragbox_inner" id="gi" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >GI('.$countGI.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			$patient_assessmentHtml .='<table width="100%">';
			if(!empty($getPatientAssessmentGI)){
				foreach ($getPatientAssessmentGI as $dataGI){
					$patient_assessmentHtml.='<tr class="light">
			<td>'.$dataGI['ReviewSubCategoriesOption']['name'].'</td>
				<td width="25%">'.$dataGI['ReviewPatientDetail']['values'].'</td>
			<td width="25%"><span style="color:grey;">'.$dataGI['ReviewPatientDetail']['date'].' '.$dataGI['ReviewPatientDetail']['actualTime'].'</span> </td>
			</tr>';
				}
				$patient_assessmentHtml.='</table>';
			}else{
				$patient_assessmentHtml.='<table>
			<tr><td><span style="color:grey;">No Result Found</span></td></tr>
			</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//------------
		$countGU=count($getPatientAssessmentGU);
		if(!empty($getPatientAssessmentGU)){
			$boxHtml1 =  '<div class="dragbox_inner" id="gu" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >GU('.$countGU.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getPatientAssessmentGU)){
				$patient_assessmentHtml.='<table width="100%">';
				foreach ($getPatientAssessmentGU as $dataGU){
					$patient_assessmentHtml.='<tr class="light">
			<td>'.$dataGU['ReviewSubCategoriesOption']['name'].'</td>
				<td width="25%">'.$dataGU['ReviewPatientDetail']['values'].'</td>
				<td width="25%"><span style="color:grey;">'.$dataGU['ReviewPatientDetail']['date'].' '.$dataGU['ReviewPatientDetail']['actualTime'].'</span> </td>
				</tr>';
				}
				$patient_assessmentHtml.='</table>';
			}else{
				$patient_assessmentHtml.='<table>
				<tr><td><span style="color:grey;">No Result Found</span></td></tr>
				</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//--------
		$countIntegumentary=count($getPatientAssessmentIntegumentary);
		if(!empty($getPatientAssessmentIntegumentary)){
			$boxHtml1 =  '<div class="dragbox_inner" id="integumentary" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Integumentary('.$countIntegumentary.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getPatientAssessmentIntegumentary)){
				$patient_assessmentHtml.='	<table width="100%">';
				foreach ($getPatientAssessmentIntegumentary as $dataInt){
					$patient_assessmentHtml.='<tr class="light">
					<td>'.$dataInt['ReviewSubCategoriesOption']['name'].'</td>
					<td width="25%">'.$dataInt['ReviewPatientDetail']['values'].'</td>
					<td width="25%"><span style="color:grey;">'.$dataInt['ReviewPatientDetail']['date'].' '.$dataInt['ReviewPatientDetail']['actualTime'].'</span> </td>
					</tr>';
				}
				$patient_assessmentHtml.='</table>';
					
			}else{
				$patient_assessmentHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//-------
		$countMentalStatus=count($getPatientMentalStatus);
		if(!empty($getPatientMentalStatus)){
			$boxHtml1 =  '<div class="dragbox_inner" id="integumentary" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Mental Status('.$countMentalStatus.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getPatientMentalStatus)){
				$patient_assessmentHtml.='	<table width="100%">';
				foreach ($getPatientMentalStatus as $dataInt){
					$patient_assessmentHtml.='<tr class="light">
									<td>'.$dataInt['ReviewSubCategoriesOption']['name'].'</td>
					<td width="25%">'.$dataInt['ReviewPatientDetail']['values'].'</td>
					<td width="25%"><span style="color:grey;">'.$dataInt['ReviewPatientDetail']['date'].' '.$dataInt['ReviewPatientDetail']['actualTime'].'</span> </td>
					</tr>';
				}
				$patient_assessmentHtml.='</table>';
					
			}else{
				$patient_assessmentHtml.='<table>
			<tr><td><span style="color:grey;">No Result Found</span></td></tr>
			</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//--------
		$countSwallowScreen=count($getSwallowScreen);
		if(!empty($getSwallowScreen)){
			$boxHtml1 =  '<div class="dragbox_inner" id="integumentary" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Swallow Screen('.$countSwallowScreen.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getSwallowScreen)){
				$patient_assessmentHtml.='	<table width="100%">';
				foreach ($getSwallowScreen as $dataInt){
					$patient_assessmentHtml.='<tr class="light">
					<td>'.$dataInt['ReviewSubCategoriesOption']['name'].'</td>
				<td width="25%">'.$dataInt['ReviewPatientDetail']['values'].'</td>
				<td width="25%"><span style="color:grey;">'.$dataInt['ReviewPatientDetail']['date'].' '.$dataInt['ReviewPatientDetail']['actualTime'].'</span> </td>
				</tr>';
				}
				$patient_assessmentHtml.='</table>';
					
			}else{
				$patient_assessmentHtml.='<table>
				<tr><td><span style="color:grey;">No Result Found</span></td></tr>
				</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//----
		$countPupilAssessment=count($getPupilAssessment);
		if(!empty($getSwallowScreen)){
			$boxHtml1 =  '<div class="dragbox_inner" id="integumentary" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Pupil Assessment ('.$countPupilAssessment.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getPupilAssessment)){
				$patient_assessmentHtml.='	<table width="100%">';
				foreach ($getPupilAssessment as $dataInt){
					$patient_assessmentHtml.='<tr class="light">
					<td>'.$dataInt['ReviewSubCategoriesOption']['name'].'</td>
					<td  width="25%">'.$dataInt['ReviewPatientDetail']['values'].'</td>
					<td width="25%"><span style="color:grey;">'.$dataInt['ReviewPatientDetail']['date'].' '.$dataInt['ReviewPatientDetail']['actualTime'].'</span> </td>
							</tr>';
				}
				$patient_assessmentHtml.='</table>';
					
			}else{
				$patient_assessmentHtml.='<table>
											<tr><td><span style="color:grey;">No Result Found</span></td></tr>
											</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//----
		$countMusculoskeletalAssessment=count($getMusculoskeletalAssessment);
		if(!empty($getMusculoskeletalAssessment)){
			$boxHtml1 =  '<div class="dragbox_inner" id="integumentary" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Musculoskeletal Assessment ('.$countMusculoskeletalAssessment.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getMusculoskeletalAssessment)){
				$patient_assessmentHtml.='	<table width="100%">';
				foreach ($getMusculoskeletalAssessment as $dataInt){
					$patient_assessmentHtml.='<tr class="light">
					<td>'.$dataInt['ReviewSubCategoriesOption']['name'].'</td>
						<td width="25%">'.$dataInt['ReviewPatientDetail']['values'].'</td>
							<td width="25%"><span style="color:grey;">'.$dataInt['ReviewPatientDetail']['date'].' '.$dataInt['ReviewPatientDetail']['actualTime'].' </span></td>
									</tr>';
				}
				$patient_assessmentHtml.='</table>';
					
			}else{
				$patient_assessmentHtml.='<table>
									<tr><td><span style="color:grey;">No Result Found</span></td></tr>
									</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//----
		$countMechanicalVentilation=count($getMechanicalVentilation);
		if(!empty($getMechanicalVentilation)){
			$boxHtml1 =  '<div class="dragbox_inner" id="integumentary" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Mechanical Ventilation ('.$countMechanicalVentilation.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getMechanicalVentilation)){
				$patient_assessmentHtml.='	<table width="100%">';
				foreach ($getMechanicalVentilation as $dataInt){
					$patient_assessmentHtml.='<tr class="light">
						<td>'.$dataInt['ReviewSubCategoriesOption']['name'].'</td>
						<td width="25%">'.$dataInt['ReviewPatientDetail']['values'].'</td>
							<td width="25%"><span style="color:grey;">'.$dataInt['ReviewPatientDetail']['date'].' '.$dataInt['ReviewPatientDetail']['actualTime'].'</span> </td>
							</tr>';
				}
				$patient_assessmentHtml.='</table>';
					
			}else{
				$patient_assessmentHtml.='<table>
							<tr><td><span style="color:grey;">No Result Found</span></td></tr>
							</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//----
		$countEdemaAssessment=count($getEdemaAssessment);
		if(!empty($getEdemaAssessment)){
			$boxHtml1 =  '<div class="dragbox_inner" id="integumentary" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Edema Assessment ('.$countEdemaAssessment.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getEdemaAssessment)){
				$patient_assessmentHtml.='	<table width="100%">';
				foreach ($getEdemaAssessment as $dataInt){
					$patient_assessmentHtml.='<tr class="light">
					<td>'.$dataInt['ReviewSubCategoriesOption']['name'].'</td>
						<td width="25%">'.$dataInt['ReviewPatientDetail']['values'].'</td>
						<td width="25%"><span style="color:grey;">'.$dataInt['ReviewPatientDetail']['date'].' '.$dataInt['ReviewPatientDetail']['actualTime'].'</span> </td>
						</tr>';
				}
				$patient_assessmentHtml.='</table>';
					
			}else{
				$patient_assessmentHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//----
		$countUrinaryCatheter=count($getUrinaryCatheter);
		if(!empty($getUrinaryCatheter)){
			$boxHtml1 =  '<div class="dragbox_inner" id="integumentary" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Urinary Catheter ('.$countUrinaryCatheter.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getUrinaryCatheter)){
				$patient_assessmentHtml.='	<table width="100%">';
				foreach ($getUrinaryCatheter as $dataInt){
					$patient_assessmentHtml.='<tr class="light">
					<td>'.$dataInt['ReviewSubCategoriesOption']['name'].'</td>
					<td width="25%">'.$dataInt['ReviewPatientDetail']['values'].'</td>
							<td width="25%"><span style="color:grey;">'.$dataInt['ReviewPatientDetail']['date'].' '.$dataInt['ReviewPatientDetail']['actualTime'].'</span> </td>
						</tr>';
				}
				$patient_assessmentHtml.='</table>';
					
			}else{
				$patient_assessmentHtml.='<table>
					<tr><td><span style="color:grey;">No Result Found</span></td></tr>
					</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//----
		$countBradenAssessment=count($getBradenAssessment);
		if(!empty($getBradenAssessment)){
			$boxHtml1 =  '<div class="dragbox_inner" id="integumentary" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Braden Assessment ('.$countBradenAssessment.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getBradenAssessment)){
				$patient_assessmentHtml.='	<table width="100%">';
				foreach ($getBradenAssessment as $dataInt){
					$patient_assessmentHtml.='<tr class="light">
						<td>'.$dataInt['ReviewSubCategoriesOption']['name'].'</td>
						<td width="25%">'.$dataInt['ReviewPatientDetail']['values'].'</td>
					<td width="25%"><span style="color:grey;">'.$dataInt['ReviewPatientDetail']['date'].' '.$dataInt['ReviewPatientDetail']['actualTime'].' </span></td>
						</tr>';
				}
				$patient_assessmentHtml.='</table>';
					
			}else{
				$patient_assessmentHtml.='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
		//----
		$countFallRiskScaleMorse=count($getFallRiskScaleMorse);
		if(!empty($getFallRiskScaleMorse)){
			$boxHtml1 =  '<div class="dragbox_inner" id="integumentary" >';
			$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Fall Risk Scale Morse('.$countFallRiskScaleMorse.')</div></h2>';
			$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
			$patient_assessmentHtml .= $boxHtml1.'';
			if(!empty($getFallRiskScaleMorse)){
	
				$patient_assessmentHtml.='	<table width="100%">';
	
				foreach ($getFallRiskScaleMorse as $dataInt){
					$patient_assessmentHtml.='<tr class="light">
						<td>'.$dataInt['ReviewSubCategoriesOption']['name'].'</td>
						<td width="25%">'.$dataInt['ReviewPatientDetail']['values'].'</td>
							<td width="25%"><span style="color:grey;">'.$dataInt['ReviewPatientDetail']['date'].' '.$dataInt['ReviewPatientDetail']['actualTime'].'</span> </td>
							</tr>';
				}
				$patient_assessmentHtml.='</table>';
					
			}else{
				$patient_assessmentHtml.='<table>
							<tr><td><span style="color:grey;">No Result Found</span></td></tr>
							</table>';
			}
			$patient_assessmentHtml .= "</div></div>";
		}
	
		//----
	
	
		$patient_assessmentHtml .= "</div></div>" ;
		return $patient_assessmentHtml;
	}
	
	
	function vital_signs($getVitals,$boxHtml){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$mHtml =  $boxHtml;
		if(!empty($getVitals)){
				$mHtml.='<table width="100%"> <tr><td style="background-color:#ccc">Selected Visits</td></tr></table>';
	
				$mHtml .= '<table width="100%">
					<tr style="background-color:grey;height:10px;"><td></td>
					<td align="center">Latest</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center">Previous</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center">Previous</td>
					</tr>';
				foreach($getVitals as $keyMeasure => $dataMeasure){
					$unit0 = ($condition == $getVitals[$keyMeasure]['0']['values']) ? "" : $getVitals[$keyMeasure]['0']['unit']  ;
					$unit1 = ($condition == $getVitals[$keyMeasure]['1']['values']) ? "" : $getVitals[$keyMeasure]['1']['unit']  ;
					$unit2 = ($condition == $getVitals[$keyMeasure]['2']['values']) ? "" : $getVitals[$keyMeasure]['2']['unit']  ;
						
					$mHtml .='<tr class="light">
					<td>'.$keyMeasure.'</td>
					<td align="center">'.$getVitals[$keyMeasure]['0']['values'].' <span style="color:grey;">'.$unit0.'</span></td>
				<td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
				<td align="center">'.$getVitals[$keyMeasure]['1']['values'].' <span style="color:grey;">'.$unit1.'</span></td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
					<td align="center">'.$getVitals[$keyMeasure]['2']['values'].' <span style="color:grey;">'.$unit2.'</span></td>
					</tr>';
									}
									$mHtml .='</table>';
									}else{
										 $mHtml .='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
									}
									$mHtml .= "</div></div>" ;
									return $mHtml ;
			}
	
	
			function getIntakeOutput($getIntakeOutput,$getIntakeInner,$getOutInner,$boxHtml){
			$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
			$inputOutputHtml =  $boxHtml;
			$currentDate=date('m/d/y', strtotime(date('Y-m-d')));
			$yesterday=date('m/d/y', time() - 60 * 60 * 24);
			$dayBefoerYesterday=date('m/d/y', time() - 172800);
			if(!empty($getIntakeOutput)){
				$inputOutputHtml.='<table width="100%"> <tr><td style="background-color:#ccc">Selected Visits(24 hour periods starting at 06:00)</td></tr></table>';
				$boxHtml1 =  '<div class="dragbox_inner" id="intake" >';
				$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Total Summary</div></h2>';
				$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
				$inputOutputHtml .= $boxHtml1.'
	
					<table width="100%">
					<tr>
					<td>
					<table>
					<tr>
					<td></td>
					</tr>
					<tr>
					<td>Total Summary</td>
					</tr>
					<tr>
					<td>Intake<span style="color:grey;"> ml</span></td>
					</tr>
					<tr>
					<td>Output <span style="color:grey;">ml</span></td>
					</tr>
					<tr>
					<td><span style="color:grey;">Fluid Balance</span></td>
					</tr>
					</table>
					</td>
					<td>
					<table width="100%">
					<tr class="light">
					<td align="center"><span style="color:grey;">'.$currentDate.'*</span></td> <td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
							<td align="center"><span style="color:grey;">'.$yesterday.'</span></td> <td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
						<td align="center"><span style="color:grey;">'.$dayBefoerYesterday.'</span></td>
					</tr>
					<tr><td></td><td></td><td></td></tr>
					<tr class="light">
					<td  align="center">'.$getIntakeOutput['Intake'][date('Y-m-d')].'</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td  align="center">'.$getIntakeOutput['Intake'][date('Y-m-d',time() - 60 * 60 * 24)].' </td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center">'.$getIntakeOutput['Intake'][date('Y-m-d',time() - 172800)].' </td>
					</tr>
					<tr class="light">
					<td  align="center">'.$getIntakeOutput['Output'][date('Y-m-d')].' </td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center">'.$getIntakeOutput['Output'][date('Y-m-d',time() - 60 * 60 * 24)].' </td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center">'.$getIntakeOutput['Output'][date('Y-m-d',time() - 172800)].' </td>
									</tr>';
				$currentDiff=($getIntakeOutput['Intake'][date('Y-m-d')]-$getIntakeOutput['Output'][date('Y-m-d')]);
				$yesterDayDiff=($getIntakeOutput['Intake'][date('Y-m-d',time() - 60 * 60 * 24)]-$getIntakeOutput['Output'][date('Y-m-d',time() - 60 * 60 * 24)]);
				$dayBeforeYsterDayDiff=($getIntakeOutput['Intake'][date('Y-m-d',time() - 172800)]-$getIntakeOutput['Output'][date('Y-m-d',time() - 172800)]);
				$inputOutputHtml.='<tr class="light">
				<td align="center">'.$currentDiff.'</td><td></td>
				<td  align="center">'.$yesterDayDiff.'</td><td></td>
					<td  align="center">'.$dayBeforeYsterDayDiff.'</td><td></td>
					</tr>
					<tr></tr>
					</table>
					</td>
					</tr>
					</table>
					</div></div>';
	
				$countInnerIntake=count($getIntakeInner);
				$boxHtml1 =  '<div class="dragbox_inner" id="intake" >';
				$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Intake('.$countInnerIntake.')</div></h2>';
				$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
	
				$inputOutputHtml .= $boxHtml1.'
								<table width="100%">';
				foreach($getIntakeInner as $key=>$innerData){
							$inputOutputHtml.='<tr class="light">
									<td>'.$innerData['ReviewSubCategoriesOption']['name'].'</td><td><span style="color:grey;">'.$innerData['ReviewPatientDetail']['values'].'</span></td>
									</tr>';
							}
							$inputOutputHtml.='</table>
						</div></div>';
							$countInnerOutput=count($getOutInner);
							$boxHtml1 =  '<div class="dragbox_inner" id="intake" >';
							$boxHtml1 .= '<h2 style="background:#d2ebf2"><div style="display:inline" >Output('.$countInnerOutput.')</div></h2>';
							$boxHtml1 .= '<div class="dragbox-content_inner" style="display:none;">';
							$inputOutputHtml .= $boxHtml1.'
					<table width="100%">';
							foreach($getOutInner as $key=>$outerData){
							$inputOutputHtml.='<tr class="light">
					<td>'.$outerData['ReviewSubCategoriesOption']['name'].'</td><td><span style="color:grey;">'.$outerData['ReviewPatientDetail']['values'].'</span></td>
					</tr>';
							}
							$inputOutputHtml.='</table>
						</div></div>';
	
			}else{
				$inputOutputHtml .='<table>
							<tr><td><span style="color:grey;">No Result Found</span></td></tr>
							</table>';
			}
			$inputOutputHtml .= "</div></div>" ;
			return $inputOutputHtml ;
		}
	
		function measurement_weights($getMeasurementWeight,$boxHtml){
	
				$countMeasurementWeight = count($getMeasurementWeight);
				$boxHtml = str_replace("{{recordCount}}",'('.$countMeasurementWeight.')',$boxHtml);
				$mHtml =  $boxHtml;
				//	if(!empty($getMeasurementWeight['Height/Length measurement']['1'])){
				$mHtml.='<table width="100%"> <tr><td style="background-color:#ccc">Selected Visits</td></tr></table>';
	
				$mHtml .= '<table width="100%">
				<tr style="background-color:grey;height:10px;"><td></td>
				<td align="center">Latest</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center">Previous</td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td><td align="center">Changes</td>
				</tr>';
				foreach($getMeasurementWeight as $keyMeasure => $dataMeasure){
						$diff=($getMeasurementWeight[$keyMeasure]['0']['values'] - $getMeasurementWeight[$keyMeasure]['1']['values']);
						$mHtml .='<tr class="light">
						<td>'.$keyMeasure.'</td>
							<td align="center">'.$getMeasurementWeight[$keyMeasure]['0']['values'].' <span style="color:grey;">'.$getMeasurementWeight[$keyMeasure]['0']['unit'].'</span></td>
									<td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
									<td align="center">'.$getMeasurementWeight[$keyMeasure]['1']['values'].' <span style="color:grey;">'.$getMeasurementWeight[$keyMeasure]['1']['unit'].'</span></td><td style="width:1%;border-right:1px solid #fff;">&nbsp;</td>
						<td align="center">'.$diff.' <span style="color:grey;">'.$getMeasurementWeight[$keyMeasure]['1']['unit'].'</span></td>
				</tr>';
									}
									$mHtml .='</table>';
									/* 		}else{
									 $mHtml .='<table>
													 <tr><td><span style="color:grey;">No Result Found</span></td></tr>
													</table>';
									}  */
									$mHtml .= "</div></div>" ;
									return $mHtml ;
			}
	
			function procedure_history($diagnosisSurgeries,$trarifName,$optDoctor,$boxHtml,$dateFormate,$procedureLink){
			$countProcedure=count($diagnosisSurgeries);
			$boxHtml = str_replace("{{recordCount}}",'('.$countProcedure.')',$boxHtml);
			$procedure_historyHtml =  $boxHtml;
			$procedure_historyHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">All Visits'.$procedureLink.'</td></tr></table>';
			if(!empty($diagnosisSurgeries)){
				
				$procedure_historyHtml .='<table width="100%">';
				foreach($diagnosisSurgeries as $proceduer){
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
					$toolTip = '<b>Procedure:</b> '.wordwrap($currentProcedure,80,"<br>\n").'</br>
								<b>Procedure Date:</b> '.$dateFormate->formatDate2Local($proceduer['ProcedureHistory']['procedure_date'],Configure::read('date_format'),false).'</br>
								<b>Provider:</b> '.$currentProvider.'</br>
								<b>Comment:</b> '.wordwrap($proceduer['ProcedureHistory']['comment'],80,"<br>\n").'</br>';
						
						
						
					$procedure_historyHtml .='<tr class="tooltip light" title="'.$toolTip.'">
							<td>'.$currentProcedure.'</td>
								<td align="right">'.$dateFormate->formatDate2Local($proceduer['ProcedureHistory']['procedure_date'],Configure::read('date_format'),false).'</td>
									</tr>';
					}
					$procedure_historyHtml .='	</table>';
					}else{
										 $procedure_historyHtml .='<table>
						<tr><td><span style="color:grey;">No Result Found</span></td></tr>
						</table>';
									}
									$procedure_historyHtml .= "</div></div>" ;
									return $procedure_historyHtml;
				}
	
				//funtion to display list of given permissions 
				//By pankaj 
				function share_with_patient($clinical_summary,$home_sections,$boxHtml,$clinicalLightBoxLink,$clinicalLightBoxLink1){
						 
						$products=array('0'=>'Common MU Data set','1'=>'Provider\'s name and office contact information','2'=>'Date and location of visit',
						'3'=>'Reason for visit','4'=>'Immunizations and/or medications administered during the visit','5'=>'Diagnostic tests pending',
						'6'=>'Clinical Instructions','7'=>'Future appointments','8'=>'Referrals to other providers',
						'9'=>'Future scheduled tests','10'=>'Recommended patient decision aids');
						
						$homeSectionsArray = Configure::read('patient_permission_array') ;
						$permissionArray = explode("|",$clinical_summary['XmlNote']['patient_permission']);
						$homeSectionsPermission = explode("|",$home_sections['Patient']['permissions']);
						
						foreach($permissionArray as $arrIndex){
							$allowSections[] = $products[$arrIndex] ;
						}
						
						foreach($homeSectionsPermission as $arrIndex){
							$allowHomeSections[] = $homeSectionsArray[$arrIndex] ;
						}
						
						$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
						$clinical_summary_html .= $boxHtml;
						$clinical_summary_html .=  '<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">Permission to detailed data'.$clinicalLightBoxLink.'</td></tr>
								<tr><td>'.implode(',',$allowSections).'</td></tr></table>' ;
						$clinical_summary_html .=  '<table  width="100%"> <tr><td class="td_add tdLabel" style="background-color:#ccc">Permission to categories'.$clinicalLightBoxLink1.'</td></tr>
								<tr><td>'.implode(',',$allowHomeSections).'<td><tr></table>' ;
						$clinical_summary_html.='</div></div>';
						return $clinical_summary_html ;
				}
				//EOF pankaj 
				?>
	
	
	<div class="clear"></div>
	<!-- </div> -->
	<div class="clear"></div>
	<div>
		<input type="hidden" name="user_id" id="user_id"
			value="<?php echo $this->Session->read('userid'); ?>"> <input
			type="hidden" name="screen_application_name"
			id="screen_application_name"
			value="<?php echo $screenApplicationName; ?>">
	</div>
	<script type="text/javascript">
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
	    var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "saveWidget","admin" => false)); ?>";
	    $.post(ajaxUrl, 'data='+JSON.stringify(sortorder), function(response){  
	        if(response=="success")  
	            $("#console").html('<div class="success">Saved</div>').hide().fadeIn(1000);  
	        setTimeout(function(){  
	            $('#console').fadeOut(1000);  
	        }, 2000);  
	    });  
	}
	</script>
	<script type="text/javascript">
	
		 $(document).ready(function() {
			getRad();
						 
		 	$('.tooltip').tooltipster({
		 		interactive:true,
		 		position:"right",
		 	});
	
		 	//link on soap note TR
		 	$(".soap-link").click(function(){ 
			 	var temp='<?php echo $flag; ?>';
			 	splitted_var =  $(this).attr('id').split("_") ;
			 	patient_id = splitted_var[0];
			 	note_id = splitted_var[1];
			 	window.location.href = "<?php echo $this->Html->url(array('controller'=>'Notes','action'=>"soapNote")) ?>"+"/"+patient_id+"/"+note_id+"/" ;
		 	});
		 	$(".power_note-link").click(function(){ 
			 	var temp='<?php echo $flag; ?>';
			 	splitted_var =  $(this).attr('id').split("_") ;
			 	patient_id = splitted_var[0];
			 	note_id = splitted_var[1];
			 	window.location.href = "<?php echo $this->Html->url(array('controller'=>'PatientForms','action'=>"power_note")) ?>"+"/"+note_id+"/"+patient_id+"/" ;
		 	});
		 	$(".inni-link").click(function(){ 
			 	var temp='<?php echo $flag; ?>';
			 	splitted_var =  $(this).attr('id').split("_") ;
			 	patient_id = splitted_var[0];
			 	note_id = splitted_var[1];
			 	window.location.href = "<?php echo $this->Html->url(array('controller'=>'Diagnoses','action'=>"powerNote")) ?>"+"/"+patient_id+"?patientId=<?php echo $patientId ?>" ;
		 	});
		 	
		 	$(".diagnosis-link").click(function(){ 
	 
			 	var temp='<?php echo $flag; ?>';
			 	splitted_var =  $(this).attr('id').split("_") ;
			 	patient_id = splitted_var[0];
			 	note_id = splitted_var[1];
			 	window.location.href = "<?php echo $this->Html->url(array('controller'=>'Notes','action'=>"soapNote")) ?>"+"/"+patient_id+"/"+note_id ;
		 	});
	
	
		 	$("#clinical-summary").click(function(){
				$ .fancybox({
					'width' : '60%',
					'height' : '70%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "clinical_summary", $patient['Patient']['id'],$patient['Prson']['patient_uid'])); ?>"
				});
			}) ;
	
			$('#patient_permissions').click(function(){
				$ .fancybox({
					'width' : '60%',
					'height' : '70%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "patient_permissions", $patient['Patient']['id'])); ?>"
				});
			})
	
	
			
		 });
		 function getAllergiesAddEdit(){
				$.fancybox({
					'width'        : '70%',
					'height'       : '50%',
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
					'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "rx",$patientId,'?'=>array('pageView'=>"ajax"))); ?>"
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
	
		 function getAllergies(){
				$.fancybox({
					'width' : '100%',
					'height' : '80%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'onClosed':function() {   
					     parent.location.reload(true); 
				     },
					'onComplete' : function() {
						$("#allergies").css({
							'top' : '20px',
	
							'bottom' : 'auto',	
							
		});
					},
					
					'href' : "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "getAllergies",$patient['Patient']['id'],$patient['Patient']['person_id'])); ?>"
	
				});
			}
	
		 $('.infomedication').on('click',function(){ 
				id = $(this).attr('id') ;
				drug_id = $(this).attr('drug_id') ;
				newcrop_id = $(this).attr('newcrop_id') ;
				//alert(id);alert(drug_id);
				var medication_name=$(this).attr('name');
				//alert(medication_name);
				var name_med=medication_name.replace("/","~");
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "infomedication")); ?>"; 
	         
			    $.ajax({
				     type: 'POST',
				     url:  ajaxUrl  + '/' + drug_id +'/'+ newcrop_id,
				     dataType: 'html',
				     beforeSend:function(){ 
				    	// $('#'+id).html($("#loading-indicator").html(),5); 
				    	 inlineMsg(id,"loading",10); 
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
				     },
					 error: function(message){
						  inlineMsg(id,$('#loading-text').html(),5); 	     
						   
				     }        
				});
			});
	
	
		   function icdwin(icd_id,name,id,primaryId) {
			   
			/*	var patient_id = $('#Patientsid').val();
				if (patient_id == '') {
					alert("Please select patient");
					return false;
				}*/
				$.fancybox({
	
							'width' : '50%',
							'height' : '100%',
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe',
							'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "infobutton")); ?>"
							 + '/' + icd_id + '/'+ '/' + name + '/'+id+"/"+null+"/"+primaryId
									
				});
			}
		   var bulbgreen=false;
		   function infobutton(drug_id,patient_id,newcropId) {	
			  	/*var patient_id = $('#Patientsid').val();
				if (patient_id == '') {
					alert("Please select patient");
					return false;
				}*/
				$.fancybox({
							'width' : '50%',
							'height' : '95%',
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe',
							'href' : "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "infobutton")); ?>"
							  + '/'+drug_id+"/"+patient_id+'/'+newcropId,
							  'onClosed' : function(){	
								 if(bulbgreen){									
								id= $('.classShowGreen').attr('id') ;
								var newId='showGreen'+newcropId;										
								  document.getElementById(newId).src="<?php echo $this->Html->url("/theme/Black/img/icons/green.png"); ?>";	
								 }			
							  }							
				});
			}
		   
	
			$('.infolab').on('click',function(){ 
			 	 
			 	id= $(this).attr('id') ;
			 	name = $(this).attr('id') ;
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "infolab")); ?>"; 
				
			    $.ajax({
				     type: 'POST',
				     url:  ajaxUrl  + '/' + name ,
				     dataType: 'html',
				     beforeSend:function(){ 
				    	 inlineMsg(id,"loading",10); 
		    	     },
				     success: function(data){	
				    	  data = data.trim();		    	 
				    	  if(data != ''){
				    		  inlineMsg(id,'');
				    		  var win=window.open(data, '_blank');
				    		  win.focus();
					      }else{ 
					    	  inlineMsg(id,$('#loading-text').html(),10); 	
					      }
				     },
					 error: function(message){
						  inlineMsg(id,$('#loading-text').html(),5); 
				     }        
				});
	
			});
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
					'onClosed':function() {   
					     parent.location.reload(true); 
				     },
					'href' : "<?php echo $this->Html->url(array("controller" =>"Diagnoses","action" =>"allallergies",$patientId,'null','null',$personId,"admin"=>false)); ?>",
							
					
				});
			});
	
			/*function userDocument(id) {
	
				$.fancybox({
										'width' : '45%',
										'height' : '45%',
										'autoScale' : true,
										'transitionIn' : 'fade',
										'transitionOut' : 'fade',
										'type' : 'iframe',
										'href' : "<?php echo $this->Html->url(array("action" => "userDocument", )); ?>"+ '/' + id
									});
	
						};*/
	
						$('#Labink').click(function(){
							$.fancybox({
								'width' : '90%',
								'height' : '70%',
								'autoScale' : true,
								'transitionIn' : 'fade',
								'transitionOut' : 'fade',
								'type' : 'iframe',
								'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addLab",$patientId,'null','sbar',$_SESSION['apptDoc'])); ?>",
								'onClosed':function(){
									//getRad();
									},
							});
						});
						$('#DiagnosticsLink').click(function(){
							$.fancybox({
								'width' : '90%',
								'height' : '70%',
								'autoScale' : true,
								'transitionIn' : 'fade',
								'transitionOut' : 'fade',
								'type' : 'iframe',
								'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addRad",$patientId,'null',$_SESSION['apptDoc'],'sbar')); ?>",
								'onClosed':function(){
									//getRad();
									},
							});
						});
	
						//To print selected medication and allergy
						var medToPrint = new Array(); 
						$('.medCheckClass').click(function(){	
							var currentId= $(this).attr('id');
							if($(this).prop('checked')){
								medToPrint.push($(this).val());
							}else{
								medToPrint.remove($(this).val());
							}
						});
	
						function newPrint(patientId){
							var printUrl='<?php echo $this->Html->url(array("controller" => "notes", "action" => "prescription_detail_print",$id)); ?>';
							var printUrl=printUrl + "?medToPrint="+medToPrint;
	
							var openWin =window.open(printUrl, '_blank',
							'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');
						}
	
						jQuery(document).ready(function() {
							$('.medCheckClass').attr('checked',true);
							$(".medCheckClass").each(function(){
								medToPrint.push($(this).val());
							  });
						});		
	
						function getRad() {
							 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "getRad",$patientId,"admin" => false)); ?>";
							 $.ajax({
						        	beforeSend : function() {
						        	},
						        	type: 'POST',
						        	url: ajaxUrl,
						        	//data: formData,
						        	dataType: 'html',
						        	success: function(data){
						        	if(data!=''){
						       			 $('#loadRad').html(data);
						        	}
						        },
								});
						}
	</script>
