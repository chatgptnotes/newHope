<?php  
	echo $this->Html->css(array('drag_drop_accordian.css','ros_accordian.css'));
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
	echo $this->Html->script(array('jquery.fancybox-1.3.4','pager'));
	echo $this->Html->script(array('jquery.selection.js','jquery.blockUI'));
	echo $this->Html->css(array('tooltipster.css'));
	echo $this->Html->script(array('jquery.tooltipster.min.js'));
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>

<div class="message" id="flashMessage" style="display: none;">
	<!-- flash Message-->
</div>
<style>
	@media screen and (max-width: 1366px) {
	    .tab-content {
		    animation-duration: 0.5s;
		    background: #dbeaf9 none repeat scroll 0 0;
		    border-radius: 0 10px 10px;
		    box-sizing: border-box;
		    display: none;
		    font-size: 20px;
		    left: 0;
		    line-height: 140%;
		    padding: 15px;
		    position: absolute;
		    text-align: left;
		    width: 1037px !important;
		}
		iframe{
			width: 921px !important;

		}

	}
	.tabs input[type=radio] {
	position: absolute;
	top: -9999px;
	left: -9999px;
	}
	.tabs {
	width: 100%;
	float: none;
	list-style: none;
	position: relative;
	padding: 0;
	}

	.tabs label {
	display: block;
	padding: 3px;
	border-radius: 6px 6px 0 0;
	color: #08C;
	font-size: 22px;
	font-weight: normal;
	font-family: 'Lily Script One', helveti;
	background: rgba(255,255,255,0.2);
	cursor: pointer;
	position: relative;
	top: 3px;
	text-align: center;
	-webkit-transition: all 0.2s ease-in-out;
	-moz-transition: all 0.2s ease-in-out;
	-o-transition: all 0.2s ease-in-out;
	transition: all 0.2s ease-in-out;
	}

	.tabs label:hover {
	background: rgba(255,255,255,0.5);
	background-color: #9FC4FF;
	top: 0;
	}

	[id^=tab]:checked + label {
	background: #4279E1;
	color: white !important;
	top: 0;
	}

	[id^=tab]:checked ~ [id^=tab-content] {
		display: block;
	}
	.tab-content{
	display: none;
	text-align: left;
	width: 1037px;
	font-size: 20px;
	line-height: 140%;
	padding-top: 10px;
	background: #DBEAF9;
	padding: 15px;
	position: absolute;
	left: 0;
	border-radius: 0px 10px 10px 10px;
	box-sizing: border-box;
	-webkit-animation-duration: 0.5s;
	-o-animation-duration: 0.5s;
	-moz-animation-duration: 0.5s;
	animation-duration: 0.5s;
	}
	ul.tabs li {
	    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
	    cursor: pointer;
	    display: inline-block;
	    padding: 0px 0px !important;
	}
	label{width: auto !important;}
</style>
<script>

$(document).ready(function(){
	var exp='<?php echo $this->params->query["expand"]?>';
	if(exp=='Objective'){
		$( "#tab2" ).prop( "checked", true );
	}
	if(exp=='Assessment'){
		$( "#tab3" ).prop( "checked", true );
		getproblem();
	}
	if(exp=='Plan'){
		$( "#tab4" ).prop( "checked", true );
		getmedication();
		getRad();
		getLab(); 
		getAllergy();
	}
	if(exp=='Documents'){
		$( "#tab5" ).prop( "checked", true );
	}
	if($.trim(exp)=='epen'){
		$("#tab6").prop("checked",true);
	}
});

	
</script>
<style>

label {
    color: #000 ;
    float: none !important;
    font-size: 13px;
    margin-right: 10px;
    padding-top: 7px;
    text-align: right;
    width: none !important;
    cursor: pointer;
}
 
#msg{
 	 background:light-green;
	 padding:7px 5px;
	 border:1px solid #e8d495;
	 font-size:13px;  
	 color:black;
	 font-weight:bold;
	 text-shadow:1px 1px 1px #ecdca8;
	 margin: 5px 0;
	 display:block;
	 left: 40%;
     margin: 0 auto;
     padding: 5px 10px 5px 18px;
     position: absolute;
     top: 0;
     z-index: 2000;
}


.preLink{
	color:indigo !important;
}

.cursor{
	cursor: pointer;
}


.spNoteTextArea {
	width:100% !important;
	height: 150px;
}

.resize-input {
	height: 18px;
	width: 183px;
}

.scrollBoth {
	scroll: both;
}

.elapsedRed {
	color: red;
}

.elapsedGreen {
	color: Green;
}

.elapsedYellow {
	color: yellow;
}
.pointer {
	cursor: pointer;
}

.ui-widget-content {
	color: #fff;
	font-size: 13px;
}

.top-header .table_format td {
	padding-right: 0 !important;
}

.top-header .table_form,.table_format a {
	float: left;
}

.light:hover {
	background-color: #F7F6D9;
	text-decoration: none;
	color: #000000;
}

.pateintpic {
	border-radius: 25px !important;
}

.light td {
	font-size: 13px;
}

.patientHub .patientInfo .heading {
	float: left;
	width: 121px !important;
}

.system {
	cursor: pointer;
	text-decoration: underline;
}

.gender>span { /*float: right;*/
	font-weight: bold;
	
	/*padding: 0 0 0 2px;*/
}

.dob>span {
	font-weight: bold;
	
}

.pref_lang>span {
	font-weight: bold;
	
}

.vis_typ>span {
	font-weight: bold;
	
}

.clnt_snc>span {
	font-weight: bold;
	
}

.elaps_time>span {
	font-weight: bold;
	
}

.top-icons {
    float: left;
    left: 152px !important;
    position: absolute !important;
    width: 60%;
}
a.blueBtn{
    padding:4px 10px; 
   }
   input.blueBtn{
    padding:3px 10px !important; 
   }
.paraclass{ font-weight:bold; padding:0px; margin:0px; float:left;color: #31859c;}
.color_class{color: #31859c;}

* {
	padding: 0px;
	margin: 0px;
}

.td_add img {
	float: right;
	padding-right: 17px;
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


.dragbox-content span {
	font-size: 13px;
}

.dragbox-content a {
	font-size: 13px;
}


.top-header {
	background: #d2ebf2;
	left: 0;
	right: 0;
	top: 0px;
	margin:116px auto 0 34px;
	position: absolute;
	z-index: 1000;
	width: 97%;
}

.table_format {
	padding: 10px;
}

* {
	padding: 0px;
	margin: 0px;
}
.td_add img {
	float: right;
	padding-right: 17px;
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



.dragbox-content span {
	font-size: 13px;
}

.dragbox-content a {
	font-size: 13px;
}


.top-header {
	background: #d2ebf2;
	left: 0;
	right: 0;
	top: 0px;
	margin:116px auto 0 34px;
	position: absolute;
	z-index: 1000;
	width: 97%;
}

.table_format {
	padding: 10px;
}

/* Style The Dropdown Button */
.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 1px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    right: 0;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
    background-color: #3e8e41;
}
</style>

<div id="mydiv">
	<?php // for billings  
		$tariffStandardID=$patient['Patient']['tariff_standard_id'];
		$isDischarge=$patient['Patient']['is_discharge'];
		$patientDischargeDate=$patient['Patient']['discharge_date'];
		$personID=$patient['Patient']['person_id'];
		$clearanceData = unserialize($patient['Patient']['clearance']);
		$patientID=$patient['Patient']['id'];
		$doctorID=$patient['Patient']['doctor_id'];
		$clearanceDone=$clearanceData[$patientID]['clearance_done'];
	?>
	<div class="inner_title">
		<h3>
			<?php echo __('Add Progress Notes '); ?>
		</h3>
		<span><!-- <div class="dropdown">
				  <button class="dropbtn">Activity logs</button>
				  <div class="dropdown-content">
				  <?php if(!empty($RtoU['Note']['reason_to_unsign'])){
							$dataAct=explode('!@!', $RtoU['Note']['reason_to_unsign']);
							$editsCount=count($dataAct);
							for($i=0;$i<$editsCount;$i++){?>
							 <a href="#">
								<?php echo ucfirst($dataAct[$i]);?>
							 </a>
					<?php } } ?>
				  </div>
				</div> -->
		<?php ?>
				
				<?php 
					echo $this->Html->link('Admission Notes',array('controller'=>'patients','action'=>'admissionNotes',$getElement['Patient']['id'],$noteId),array('escape'=>false,'id'=>'Admission Notes','title'=>'Admission Notes','alt'=>'Admission Notes','class'=>'blueBtn','target'=>'_blank'));
					
					echo $this->Html->link('Progress Notes',array('controller'=>'patients','action'=>'progressNotes',$getElement['Patient']['id']),array('escape'=>false,'id'=>'progressNotes','title'=>'Progress Notes','alt'=>'Progress Notes','class'=>'blueBtn','target'=>'_blank'));
					
					echo $this->Html->link('Back',array('controller'=>'Appointments','action'=>'appointments_management','?'=>array('from'=>'InitialSoap','pageCount'=>$this->Session->read('opd_dashboard_pageCount'))),array('escape'=>false,'id'=>'backToOpd','title'=>'Back To OPD Dashboard','alt'=>'Back To OPD Dashboard','class'=>'blueBtn'));
  				?>
		</span>
	</div>
	
	<?php /// Elaspe time calculation
	/*if()*/ 
	if(!empty($elaspseData['Appointment']['elapsed_time'])){
		$showTime=$elaspseData['Appointment']['elapsed_time'];
		$label='Elapsed Time';
		if($showTime<15){
	 		$elapsedClass='elapsedGreen';
		}else if($showTime>=15 && $showTime<=30){
			$elapsedClass='elapsedYellow';
		}
		else if($showTime>30){
			$elapsedClass='elapsedRed';
		}
	}else{
			$label='Elapsed Time';
			$arr[]=Configure::read('patient_visit_type');
			$start=$getElement['Appointment']['date']." ".$_SESSION['elpeTym'];
			if($start>date('Y-m-d H:i')){
				$elapsed=$this->DateFormat->dateDiff(date('Y-m-d H:i'),date('Y-m-d H:i')) ;
			}else{
				$elapsed=$this->DateFormat->dateDiff($start,date('Y-m-d H:i')) ;
			}
			if(!empty($elaspseData['Appointment']['elapsed_time'])){// after night 12
				$showTime=$elaspseData['Appointment']['elapsed_time'];
				$label='Elapsed Time';
			}else{
				if($elapsed->i!=0){
					$min=$elapsed->i;
				}else{
					$min='00';
				}
				if($elapsed->h!=0){
					if($elapsed->h>=12){
						$hrs=$elapsed->h-12;
					}else{
						$hrs=$elapsed->h;
					}
					$hrs= ($hrs * 60);
					$showTime=$hrs+$min;
					$soap_in=$hrs+$min;
				}else{
					$showTime=$min;
					$soap_in=$min;
				}
				if($showTime<15){
			 		$elapsedClass='elapsedGreen';
				}else if($showTime>=15 && $showTime<=30){
					$elapsedClass='elapsedYellow';
				}
				else if($showTime>30){
					$elapsedClass='elapsedRed';
				}
			}
		}
	?>
<div class="outerDivNew">
<div style="width:100%">
 <div>
	<ul class="tabs">
        <li>
          <input type="radio" checked name="tabs" id="tab1">
          <label for="tab1">History & Complaints</label>
          <div id="tab-content1" class="tab-content animated fadeIn">
    		<form action="'.Router::url("/").'Notes/soapNote" method=post id="subject">
		  		<table  width="100%" class="formFull formFullBorder" id="subjectTable">
		  			<tr>
		  				<td colspan="2"><div id="subjectiveDisplay"></div></td>
		  			</tr>
		  			<tr>
		  				<td style="width:15% !important;">
 							<?php echo $this->Html->link('History of Presenting Illness',
 							 array("controller" => "PatientForms", "action" => "hpiCall",$patientId,$noteId,"?widgetId=tab1"),array('id'=>'hpi','title'=>'HPI','widgetID'=>"tab1"));?>
 							
						</td>
						<td>
						<?php 
						$hpiRosSentence = GeneralHelper::createHpiSentence($hpiMasterData,$hpiResultOther,$rosResultOther);
						$HpiNew = $hpiRosSentence['HpiSentence']; $RosNew = $hpiRosSentence['RosSentence']; 
						if(trim($HpiNew)!=''){?>
						<div style="overflow:Scroll;overflow-x: hidden;height:86px;">
							<?php
							
							echo ucfirst($HpiNew);
							?>
						</div>
						<?php }?>
						</td>
		  			</tr>
					<tr>
		  				<td class="td_add" colspan="2"><textarea name=Note[subject] id="subShow" class="spNoteTextArea"><?php echo $getVitals["Note"]["subject"];?></textarea>
		  				</td>
					</tr>
					<tr  colspan="2">
						<td class="td_add" clospan="4" style="">
		      				<input type=button name=Update value=Update class="blueBtn" onclick="saveSoap('subject')">
		      			</td>
		      		</tr>
		  			<tr>
						<td colspan="2">
							<div id="rosDisplay"></div>
						</td>
					</tr>
					<tr>
		  				<td style="width:10% !important;">
 							<?php echo $this->Html->link('Review of System',
 							 		array("controller" => "Notes", "action" => "reviewOfSystem",$patientId,$noteId,"?widgetId=tab1"),array('id'=>'ros','title'=>'Review of System'));?>
						</td>
						<td>
						<?php if(trim($RosNew)!=''){?>
							<div style="overflow:Scroll;overflow-x: hidden;height:86px;">
								<?php echo ucfirst($RosNew);?>
							</div>
						</td>
						<?php }?>
	        		</tr>
	        		<tr>
		  				<td class="td_add"  colspan="2"><textarea name=Note[ros] id="subShowRos" class="spNoteTextArea"><?php echo strip_tags($getVitals['Note']['ros'])?></textarea>
		  				</td>
		  			</tr>
					<tr>
						<td class="td_add" clospan="4" style="" >
		      				<input type=button name=Update value=Update class="blueBtn" onclick="saveSoap('subject')" >
						</td>
						<input type=hidden name=Note[appt] value=<?php echo $appt;?>>
						<input type=hidden name=Note[patient_id] value=<?php echo $patientId?>>
	        			<input type=hidden  id="subjectNoteId" name=Note[id] value=<?php echo $noteId?>>
						<input type=hidden  id="hidden_subjectNoteId" name=Note[hidden_subjectNoteId] value="">
	        			<input type=hidden  id="soap_outSubjective" name=Note[soap_out] value=<?php echo$showTimeS?>>
				</table>
			</form>
          </div>
        </li>
        <li>
          <input type="radio" name="tabs" id="tab2">
          <label for="tab2">On Examination</label>
          <div id="tab-content2" class="tab-content animated fadeIn">
	            <form action=<?php echo Router::url("/")."Notes/soapNote"?> method="POST" id="objective">
	            	<input type=hidden name=Note[appt] value=<?php echo $appt?>>
					<input type=hidden name=Note[patient_id] value=<?php echo $patientId?>>
					<input type=hidden name=Note[id] id="objectiveNoteId" value=<?php echo $noteId?>>
					<div id="objectiveTable">
						<table  width="100%" class="formFull formFullBorder" id="objectTable" >
							<tr>
							 	<td colspan="4">
							 		<div id="objectiveDisplay"></div>
							 	</td>
							 </tr>
							<tr>
				  				<td colspan="2">
									<a href="#" id="soe1">Physical Examination</a>
								</td>
								<?php 
								$peNewData = GeneralHelper::createPhysicalExamSentence($hpiMasterData,$peResultOther,$pEButtonsOptionValue);
								if(trim($peNewData)!=''){?>
								<td>
								<div style="overflow:Scroll;overflow-x: hidden;height:86px;">
									<?php 
										
										echo $peNewData;
									?>
								</div>
								</td>
								<?php }?>
								<td>
 									<a href="#" class="boldText">
 							 			<?php echo $this->Html->link('Physical Examination',
 							 				array("controller" => "PatientForms", "action" => "systemicExamination",$patientId,$noteId,"?widgetId=tab2"),array('id'=>'Systemic Examination','title'=>'Systemic Examination','widgetID'=>"tab2"));?>
 									</a>
								</td>
				  			</tr> 
							<tr>
								<td class="td_add" colspan="4"><textarea name=Note[object] id="objectShow" class="spNoteTextArea"><?php echo strip_tags($getVitals['Note']['object']);?></textarea>
								</td>
							</tr>
							<tr>
								<td class="td_add">
									<input type=button name=Submit value=Update class="blueBtn" onclick="saveSoap('objective')" >
								</td>
							</tr>
						</table>

						<table  style="width:100%;" class="formFull formFullBorder">
							<tr>
								<td>
									<b>
				     					<?php echo $this->Html->link("Go to vitals dashboard",'javascript:void(0)', array('escape'=>false,'id'=>'vitalLink','widgetID'=>$column['Widget']['id']));?>
				     				</b>
								</td>
							</tr>
						</table>

						<?php
								if(!empty($getVitals1['BmiResult']['temperature']) || !empty($getVitals1['BmiResult']['temperature1']) || !empty($getVitals1['BmiResult']['temperature2']) || 
								!empty($getVitals1["BmiBpResult"]["systolic"]) || !empty($getVitals1["BmiBpResult"]["systolic1"]) || !empty($getVitals1["BmiBpResult"]["systolic2"]) ||
								!empty($getVitals1["BmiBpResult"]["diastolic"]) || !empty($getVitals1["BmiBpResult"]["diastolic1"]) || !empty($getVitals1["BmiBpResult"]["diastolic2"]) ||
								!empty($getVitals1["BmiBpResult"]["pulse_text"]) || !empty($getVitals1["BmiBpResult"]["pulse_text1"]) || !empty($getVitals1["BmiBpResult"]["pulse_text2"]) || !empty($getVitals1["BmiResult"]["respiration"])){
									$showtable='Yes';
								}else{
									$showtable='No';
								}
											
								/* for temp  */
								if($getVitals1['BmiResult']['temperature2']){
									$temperature = $getVitals1['BmiResult']['temperature2'];
									$myoption = $getVitals1['BmiResult']['myoption2'];
								}else if(($getVitals1['BmiResult']['temperature1']) && (!$getVitals1['BmiResult']['temperature2'])){
									$temperature = $getVitals1['BmiResult']['temperature1'];
									$myoption = $getVitals1['BmiResult']['myoption1'];
								}else{
									$temperature = $getVitals1['BmiResult']['temperature'];
									$myoption = $getVitals1['BmiResult']['myoption'];
								}
								/* for bp  */
								if($getVitals1['BmiBpResult']['systolic2']){
									$BpSystolic = $getVitals1['BmiBpResult']['systolic2'];
									$BpDiastolic = $getVitals1['BmiBpResult']['diastolic2'];
										
								}else if(($getVitals1['BmiBpResult']['systolic1']) && (!$getVitals1['BmiBpResult']['systolic2'])){
									$BpSystolic = $getVitals1['BmiBpResult']['systolic1'];
									$BpDiastolic = $getVitals1['BmiBpResult']['diastolic1'];
								}else{
									$BpSystolic = $getVitals1['BmiBpResult']['systolic'];
									$BpDiastolic = $getVitals1['BmiBpResult']['diastolic'];
								}
								/* for Heart Rate */
								if($getVitals1['BmiBpResult']['pulse_text2']){
									$pulse_text = $getVitals1['BmiBpResult']['pulse_text2'];
									$pulse_volume = $getVitals1['BmiBpResult']['pulse_volume2'];
									
								}else if(($getVitals1['BmiBpResult']['pulse_text1']) && (!$getVitals1['BmiBpResult']['pulse_text2'])){
									$pulse_text = $getVitals1['BmiBpResult']['pulse_text1'];
									$pulse_volume = $getVitals1['BmiBpResult']['pulse_volume1'];
								}else{
									$pulse_text = $getVitals1['BmiBpResult']['pulse_text'];
									$pulse_volume = $getVitals1['BmiBpResult']['pulse_volume'];
								}
								/* for respiration volume  */
								if($getVitals1['BmiResult']['respiration_volume']=='1'){
									$respirationVolume = 'Labored';
								}else if($getVitals1['BmiResult']['respiration_volume']=='2'){
									$respirationVolume = 'Unlabored';
								}else{
									$respirationVolume = '';
								}
						?>
						<table width="100%" class="formFull formFullBorder" style="background-color:#F7F6D9;border-radius:25px">
							<?php if($showtable=='Yes'){?>
							<tr class="trShow">
								<td colspan="4" style="text-align:center;font-size:16px;">
									<b>Vitals Details</b>
								</td>
							</tr>
							<tr class="trShow">
								<td style="padding: 5px 0 5px 10px;"><b>Temperature: </b><?php echo $temperature.' '.$myoption;?></td>
								<td style="padding: 5px 0 5px 10px;"><b>Blood Pressure: </b><?php echo $BpSystolic.'/'.$BpDiastolic.' mmHg';?></td>
								<td style="padding: 5px 0 5px 10px;"><b>Heart Rate: </b><?php echo $pulse_text.' '.$pulse_volume;?></td>
								<td style="padding: 5px 0 5px 10px;"><b>Respiratory Rate :</b><?php echo $getVitals1["BmiResult"]["respiration"].' '.$respirationVolume?></td>
							</tr>
							<?php }?>
						</table>
					</div>
				</form>
		   </div>
        </li>
        <li>
          <input type="radio" name="tabs" id="tab3">
          <label for="tab3" id="assessmentTab">Diagnosis</label>
          <div id="tab-content3" class="tab-content animated fadeIn">
            <div id="assessmentTable">
            	<table  width="100%" class="formFull formFullBorder" id="assessmentTable">
            		<tr> 
            			<td>
							<a href="javascript:icdwin('.$widgetId.')" disabled='.$disabled.'>Add Diagnosis</a>
						</td>
					</tr>
				</table>
					<!-- $getDiagnosistR; -->
				<form action="'.Router::url("/").'Notes/soapNote" method=POST id="assessment">
					<div id="assessmentDisplay"></div>
					<table  width="100%" class="formFull formFullBorder">
							<tr>
								<td class="td_add"><textarea name=Note[assis] id="AssesShow" class="spNoteTextArea"><?php echo strip_tags($getVitals["Note"]["assis"])?></textarea>
								</td>
							</tr>
							<tr>
								<td class="td_add" clospan="4" style="align:right">
									<input type=button name=Submit value=Update class="blueBtn" onclick="saveSoap('assessment')"  >
								</td>
								<input type=hidden name=Note[patient_id] value=<?php echo $patientId ?>>
								<input type=hidden name=Note[appt] value=<?php echo $appt?>>
								<input type=hidden name=Note[id] id="assessmentNoteId" value=<?php echo$noteId?>>
								<input type=hidden name=Note[hidden_assessmentNoteId] id="hidden_assessmentNoteId" value="">
								<input type=hidden  id="soap_outAssessment" name=Note[soap_out] value=<?php echo$showTimeA ?>>
							</tr>
							<tr>
								<td id="getAssessment" width="100%"></td>
							</tr>
							<?php 
								if($getDiagnosis>='1'){
									$styleForDeletedDiagnosis = "display:block";
								  }else{
									$styleForDeletedDiagnosis = "display:none";
								 }
							 ?>
							<tr id=viewDeleteDiagnoses style='<?php echo $styleForDeletedDiagnosis?>'>
								<td>
									<a href="#" id="deleteDiaInfo">
										<font color="#000"><b><?php echo "Deleted Diagnosis Info" ?></b></font>
									</a>
								</td>
							</tr>
					</table>
					</div>
				</form>
          </div>
        </li>
        <li>
          <input type="radio" name="tabs" id="tab4">
          <label for="tab4" id='planTab'>Reports</label>
          <div id="tab-content4" class="tab-content animated fadeIn">
            <form action="'.Router::url("/").'Notes/soapNote" method=post id="plan">
				<div id="planTable">
					<table  width="100%" class="formFull formFullBorder" >
						<tr>
							<td>
							<?php 
								$widgetId ="plan";
								$orderlink= $this->Html->image('icons/plus_6.png' , array('class'=>'orders'),array('style'=>'padding:5px !important;'));
								$activityLink =$this->Html->image('icons/plus_6.png' , array('class'=>''));
							?>
								<span>
								<style type="text/css">
								img{
									margin: 5px !important;
								}
								</style>
									<?php echo $this->Html->image('icons/plus_6.png' , array('class'=>'orders'),array('style'=>'padding:5px !important;'));echo $this->Html->link('Order Set',"javascript:orderSet($patientId,$widgetId)",array());?>
								</span>
							</td>
	 						<td>
	 							<a href="javascript:addMedication('<?php echo $patientId ?>','<?php echo $widgetId ?>')")>
	 								<?php echo $orderlink." Medication";?>
	 							</a>
	 						</td>
							<td>
								<a href="javascript:addAllergy('<?php echo $patientId ?>')")>
									<?php echo $orderlink." Allergy";?>
	 							</a>
							</td>
							<td>
								<?php 
									if(!empty($imunizationCount['Immunization']['id'])){
										echo $immunizationLink = $this->Html->link($this->Html->image('icons/plus_6.png'), 
											array("controller" =>"Imunization","action" =>"index",$patientId,'SoapNote',$noteId,$appt,'?'=>array('widgetID'=>$column['Widget']['id'],'appt'=>$appt)), array('escape' => false,'title'=>'Add Immunizations'));
									}else{
										echo $immunizationLink = $this->Html->link($this->Html->image('icons/plus_6.png'), 
											array("controller" =>"Imunization","action" =>"add",$patientId,'null','SoapNote',$noteId,$appt,'?'=>array('widgetID'=>$column['Widget']['id'],'appt'=>$appt,'pageView'=>"ajax")), array('escape' => false,'title'=>'Add Immunizations'));
									}
								?>
							</td> 
						</tr>
						<input type="hidden" id="problemLabRad" value="0">
						<tr>
							<td>
								<a href="javascript:addLabOrder('<?php echo $patientId?>','<?php echo $widgetId?>')")>
									<?php echo $orderlink." Lab Order";?>
	 							</a>
							</td>
							<td>
								<a href="javascript:addRadOrder('<?php echo $patientId?>','<?php echo $widgetId?>')")>
									<?php echo $orderlink." Radiology Order";?>
	 							</a>
							</td>
							<td>
								<a href="javascript:addProcedurePerform('<?php echo $patientId?>','<?php echo $widgetId?>')")>
									<?php echo $orderlink." Procedure Perform";?>
	 							</a>
							</td>
  							<td id="activityLink">
  								<a href="#" class ="activityLink">
  									<?php echo $activityLink." Activity box"?>
  								</a>
  							</td> 
  						</tr> 
  					</table>
					<?php 
						$DiagnosisLabPlan=$getVitals['Note']['plan'];
						$DiagnosisLabPlanexplode=explode('$',$DiagnosisLabPlan);
						$currentExplode=explode(':::',$DiagnosisLabPlanexplode[0]);
						if(count($DiagnosisLabPlanexplode)=='1'){
							$LabDiagnosisFirst['0']=$DiagnosisLabPlanexplode['sample'];
							$cntproblem=0;
							// this loop is just to create the Span and put the content
							foreach($getProblem1 as $dataProblem){
								$cntproblem++;
								$LabDiagnosis=explode(':::',$DiagnosisLabPlanexplode[$cntproblem]);
								if(empty($LabDiagnosis[0])){
									$LabDiagnosisFirst=$LabDiagnosis;
								}else{
									$LabDiagnosisFirst=$LabDiagnosis;
								}
								$planHtml.='<span id="'.$currentExplode['0'].'" class="mainTextboxData"></span>';
								$planHtml.='<span id="'.$LabDiagnosis['0'].'" class="'.$cntproblem.'"></span>';
							}	
						}else{
                       		$cntproblem=0;
                       		foreach($getProblem1 as $key=>$dataProblem){
                        		$cntproblem++;
                        		$LabDiagnosis=explode(':::',$DiagnosisLabPlanexplode[$cntproblem]);
                        		if(empty($LabDiagnosis[0])){
									$LabDiagnosisFirst=$LabDiagnosis;
								}else{
									$LabDiagnosisFirst=$LabDiagnosis;
								}
							}
						}
					?>
					<table  width="100%" class="formFull formFullBorder">
						<tr>
						<td>
							<div id="planDisplay"></div>
						</td>
						</tr>
						<?php
							if($getVitals['Note']['activity_box'] != '' && !empty($getVitals['Note']['activity_box'])&& isset($getVitals['Note']['activity_box'])){
									$display="block";
									$activityBox=$getVitals['Note']['activity_box'];
								}else{
									$display="none";
									$activityBox="";
								}?>
						<tr id="show_activity_box" style="display:<?php echo $display?>">
							<td class="td_add"><textarea name=Note[activity_box] id="activity_box" style="width:1000px" placeholder="Activity Box"><?php echo $activityBox;?></textarea>
							</td>
						</tr>
						<?php 
						$lab_ordered ='';
								
							foreach($testOrdered as $dept =>$testName){    
		                       	foreach($testName as $name){			
		                            $lab_ordered .=  $name['name'].': '.$name['results']."\n\n";
		                        }
				  			}  
						?>
						<tr>
							<td class="td_add"><textarea name=Note[plan] id="planShow" style="width:1000px;height: 200px;"><?php echo strip_tags($lab_ordered)?></textarea>
							</td>
						</tr>
						<input type=hidden name=Note[hidden_activity_box]  id="hidden_activity_box_Id" value="">
						<input type=hidden name=Note[hidden_plan]  id="hidden_planId" value="">
						<?php if(strtolower($getElement['opd']['admission_type'])=='opd'){?>
						<tr>
							<td class="td_add">
								<input type="checkbox" name="Note[refer_to_hospital]" value="1">&nbsp;&nbsp;Patient to be referred to hospital.
							</td>
						</tr>
						<?php }?>
						<tr>
							<td class="td_add" clospan="4" style="align:right">
								<input type=button id="planBtn" name=Submit value=Update class="blueBtn" onclick="saveSoap('plan')">
							</td>
							<input type=hidden name=Note[appt] value=<?php echo $appt?>>
							<input type=hidden name=Note[patient_id] value=<?php echo $patientId?>>
							<input type=hidden name=Note[id]  id="planNoteId" value=<?php echo $noteId?>>
							<input type=hidden name=Note[oneOneDiagosis]  id="oneOneDiagosis" value="">
							<input type=hidden  id="soap_outPlan" name=Note[soap_out] value=<?php echo $showTimeP?>>
						</tr>
					</table>
				</div>
			</form>
				<div id="MedicationData"></div>
				<div id="loadLab"></div>
				<div id="loadRad"></div>
				<div id="loadPcare"></div>
          </div>
        </li>
        <li>
          <input type="radio" name="tabs" id="tab5">
          <label for="tab5">Document</label>
          <div id="tab-content5" class="tab-content animated fadeIn">
          	<div id="loadDocs"></div>
			  
          </div>
        </li>
        <li>
          <input type="radio" name="tabs" id="tab6">
          <label for="tab6">Summarise</label>
          <div id="tab-content6" class="tab-content animated fadeIn">
          	<div id="loadepen"></div>
          	<div ><a href="#" class="cross" id="loadCross" style="display: none;float:right"> <img src="<?php echo $this->webroot?>img/icons/cross.png"></a></div>
          	<div id="loadImg"></div>
			  
          </div>
        </li>
        <?php if($getElement['Patient']['admission_type']=='IPD'){?>
        <li>
          <input type="radio" name="tabs" id="tab8">
          <label for="tab8">Opt.notes </label>
          <div id="tab-content8" class="tab-content animated fadeIn">
          	<div id="optNotes" ></div>
          	<div ><a href="#" class="cross" id="loadCross" style="display: none;float:right"> <img src="<?php echo $this->webroot?>img/icons/cross.png"></a></div>
          	<div id="loadoptNotes"></div>
			  
          </div>
        </li>
        <li>
          <input type="radio" name="tabs" id="tab7">
          <label for="tab7">Ana.notes</label>
          <div id="tab-content7" class="tab-content animated fadeIn">
          	<div id="AnaNotes"></div>
          	<div ><a href="#" class="cross" id="loadCross" style="display: none;float:right"> <img src="<?php echo $this->webroot?>img/icons/cross.png"></a></div>
          	<div id="loadAnaNotes"></div>
			  
          </div>
        </li>
        <!-- <li>
          <input type="radio" name="tabs" id="tab6">
          <label for="tab6">Adm.notes </label>
          <div id="tab-content6" class="tab-content animated fadeIn">
          	<div id="loadepen"></div>
          	<div ><a href="#" class="cross" id="loadCross" style="display: none;float:right"> <img src="<?php echo $this->webroot?>img/icons/cross.png"></a></div>
          	<div id="loadImg"></div>
			  
          </div>
        </li> -->
          <?php }?>
	</ul>
 </div>
 <div style="float:right;background-color:#DADADA;width:25%;border-radius:5px;min-height:200px">
 <div id="search_template" style="padding-top:2px;margin:0px 3px;display:<?php echo $search_template ;?>">
	<table width="100%">
		<tr>
			
		<?php echo $this->Form->create('Notes',array('action'=>'soapSign')); ?>
			<input type=hidden name=Note[sign_note] value='1'>
			<input type=hidden name=Note[patient_id] value='<?php echo $patientId;?>'>
			<input type=hidden name=Note[patient_uid] value='<?php  echo $uid;?>'>
			<input type=hidden name=Note[id] id=uId value='<?php echo $noteId;?>'>
			<input type=hidden name=Note[appt] value='<?php echo $_SESSION['apptDoc'];?>'>
				<!-- <span id='lowerSubmit' style='display: block;'> -->
			<?php if($_SESSION[role]!='Residents'){?>
				<td style="text-align:right;width:70%">
					<input type="submit" value="Sign" class="blueBtn" id="soap_submit1">
				</td>
			<?php }
		echo $this->Form->end();?>
		</tr>
	</table>
	<table>
	<tr>
		
	  </tr>
	 <tr>
	  <td>
		<table>
		<tr id="sHide">
			<td>
				<?php echo $this->Form->input('',array('type'=>'text', 'style'=>'','lable',
				'id'=>'search','placeholder'=>'Search Template'));?>
			</td>
			<td>
				<?php 
					/*echo $this->Html->link('Search','javascript:void(0)',array('escape'=>false,'id'=>'searchBtn',
					'title'=>'Search','alt'=>'Search','class'=>'blueBtn'));
					echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',
						array('escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));*/
					echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',
						array('escape'=>false,'id'=>'searchBtn','title'=>'Search','alt'=>'Search'));
				?>
			</td>
			<td>
			<table border="0" style="display: none" id="wheel">
			<tr>
				<td class="gradient_img" style="padding: 10px;">
				<table border="0">
					<tr>
					<td class="black_white" style="padding: 5px 10px 10px; font-size: 11px;">
						<div class="bloc">
							<?php natcasesort($tName);?>
							<?php echo $this->Form->input('language', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','options'=>$tName,'style'=>'margin:1px 0 0 10px;','multiple'=>'true',
								'id' => 'language','autocomplete'=>'off'));
							?>
						</div>
					</td>
					</tr>
				</table>
				</td>
			</tr>
			</table>
			</td>
			<td>
				<?php 
					echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text',
					'id'=>'add-template','style'=>'padding-left:5px;cursor:pointer'));
				?>
			</td>
		</tr>
	    </table>
		</td>
		<td>
			<table cellspacing="10">
				<tr id="templateTitleContainer"><!-- dynamic td place to show template Title  --></tr>
			</table>
		</td>
	 </tr>
    </table>
  </div>
  <div id="add-template-form" style="display: none; align: left;">
	<?php echo $this->Form->create('NoteTemplate',array('id'=>'doctortemplatefrm','default'=>false,
			'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="29%">
			<tr>
				<td style="text-align: center;"><?php echo __('Add Template Title');?>:</td>
			</tr>
			<tr>
				<td><?php 
				echo $this->Form->hidden('id');
				echo $this->Form->input('template_name',array('type'=>'text','rows'=>'2','cols'=>'2','id'=>'addTitle','style'=>"width: 209px; height: 62px;"));
				?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<div style="float: right;">
						<?php echo $this->Html->link(__('Cancel'),"javascript:void(0)",array('id'=>'close-template-form','class'=>'grayBtn','style'=>'margin: 10px 0 0 !important;')); ?>
						<?php echo $this->Form->input(__('Submit'),array('type'=>'button','id'=>'submitTemplate','class'=>'grayBtn'))?>
					</div>
				</td>
			</tr>
		</table>
	<?php echo $this->Form->end();?>
 </div>
 <table width="100%" class="formFull formFullBorder" style="padding:10px;">
 <tr>
 	<td style="width:20%;vertical-align:top;">
 		<?php
 				if(!empty($getElement['Person']['photo'])){
					echo $this->Html->link($this->Html->image("/uploads/patient_images/thumbnail/".$getElement['Person']['photo'], array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$getElement['Patient']['person_id']), array('escape' => false));$getElement['Patient']['lookup_name'];
				}else{
					echo $this->Html->link($this->Html->image('icons/default_img.png', array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$getElement['Patient']['person_id']), array('escape' => false));
				}
 			?>
 			<br>
 		<span class="color_class">&nbsp;&nbsp;Elapsed Time:</span>
		<span style="margin:1px;" id="<?php echo 'elapsedtym';?>" class="<?php echo "elapsed ".$elapsedClass; ?>"> 
		<b><?php echo $showTime.' Min';?></b>
		</span>
 	</td>
 </tr>
 <tr>
 	<td><b>Name : </b><?php echo $getElement['Patient']['lookup_name'];?></td>
 </tr>
<tr>
 	<td><b>Gender : </b><?php echo ucfirst($getElement['Person']['sex']);?></td>
 </tr>
 <tr>
 	<td><b>Age</b>:<?php echo $getElement['Person']['age']; ?></td>
 </tr>
 <tr>
 	<td><b>Admission ID : </b><?php echo $getElement['Patient']['admission_id'];?></td>
 </tr>
 <tr>
 	<td><b>MRN ID : </b><?php echo $getElement['Person']['patient_uid'];?></td>
 </tr>
 <tr>
 	<td><b>Date Of Birth : </b><?php echo $this->DateFormat->formatDate2Local($getElement['Person']['dob'],Configure::read('date_format'));?></td>
 </tr>
 <tr>
 	<td><b>Preferred Language :</b>
	 	<?php if(empty($getElement['Person']['language'])){
						$language='Denied to Specify';
				  }else{
					$lan=explode(',',$getElement['Person']['preferred_language']);
					for($i=0;$i< count($lan); $i++){
						if($i<count($lan)-1){
							$languageValue.=$language[$lan[$i]].',';
						}
						else{
							$languageValue.=$language[$lan[$i]];
						}
					}
				}
					echo $languageValue;
		?>
	</td>
 </tr>
 <tr>
 	<td><b>Consultant : </b><?php echo $doctors[$getElement['Patient']['doctor_id']]?></td>
 </tr>
 <tr>
 	<td><b>Visit Type : </b>
 		<?php  
	 			if(empty($getElement['Appointment']['visit_type'])){
					 $vTpye='Not Indicated';
					 echo $vTpye;
				}
				else{
					 $vTpye=$vistList[trim($getElement['Appointment']['visit_type'])];
					 echo $vTpye;
				}
			?>
	</td>
 </tr>
 <tr>
 	<td><b>Client Since  : </b>
 		<?php 
 			echo $this->DateFormat->formatDate2LocalForReport($getElement['Person']['create_time'],
 			Configure::read('date_format'));
 		?>
	</td>
 </tr>
 <tr>
 	<td>
 		<?php if($getVitals['Note']['positive_id']=='1'){
					$displayGreen='block';
					$displayRed='none';
				}
				else{
					$displayGreen='none';
					$displayRed='block';
			}
		?>
 		<span id="positiveRed" style="display:<?php echo $displayRed;?>">
			<?php echo $this->Html->image('icons/red.png',array('style'=>'cursor:pointer;','alt'=>'Patient Image','title'=>'Check Positive ID','id'=>'checkPostive'));?>
		</span>
		<span id="positiveGreen" style="display:<?php echo $displayGreen;?>">
			<?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed;','alt'=>'Positive ID Checked','title'=>' Positive ID Checked'));?>
		</span>
	</td>
 </tr>
 <?php if(!empty($dList)){?>
 <tr >
 	<td><b>Diagnosis: </b>
 		<?php $cntD=count($dList);
 			foreach($dList as $data){
 				if($cntD >=1)
 					echo $data.", ";
 				else
 					--$cntD;
 			}
 		?>
	</td>
 </tr>
 <?php }?>
 <?php if(!empty($servicesData)){
 	if($getElement['Patient']['tariff_standard_id']=='25')
 		$namePack="Packages";
 	else
 		$namePack="Gallery Keywords";
 ?>
 <tr >
 	<td><b><?php echo $namePack." :";?></b>
 		<?php $packageName='';
 			foreach($servicesData as $data){
 				$packageName.=$data['TariffList']['name'].", ".$packageName;
 				echo $data['TariffList']['name'].", ";
 			}
 			$_SESSION['packName']=$packageName;
 		?>
	</td>
 </tr>
 <?php }?>
 <tr>
 	<td>
 	 <?php echo $this->Form->create('Note',array('action'=>'soapNote','id'=>'cc_id','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
 		<table border="0" class="" cellpadding="0">
			<tr>
				<td>
					<div style="color: #31859c; float: left;">
						<b><?php echo __("Chief Complaints");?> </b><!-- <font color="red">*</font> --><span id="ccMsg"></span>
					</div>
					<br>
					<div style="float: left;">
						<?php if(!empty($ccdata)){
							$checkccVal=1;
							echo $this->Form->hidden('abc',array('value'=>$checkccVal,'label'=>false,'id'=>'ccCheck'));
						}else{
							$checkccVal=0;
							$ccdata=$DiaCC;
							echo $this->Form->hidden('abc',array('value'=>$checkccVal,'label'=>false,'id'=>'ccCheck'));
						}
						echo $this->Form->input('cc',array('type'=>'text','cols'=>'1','rows'=>'1','style'=>'height:27px;width:300px','value'=>$ccdata,'label'=>false,'id'=>'cc','class'=>'resize-input'));?>
					</div>
							<?php echo $this->Form->hidden('Note.hidden_sure_cc',array('value'=>'','type'=>'text','id'=>'hidden_sure_cc'));?>
							<?php echo $this->Form->hidden('Note.patient_id',array('value'=>$patientId));?>
							<?php echo $this->Form->hidden('Note.id',array('id'=>'ccid','value'=>$noteId));?>
							<?php echo $this->Form->hidden('appt',array('value'=>$appt));?>
							<?php echo $this->Form->hidden('soap_in',array('value'=>$soap_in));?>
							<?php echo $this->Form->hidden('soap_out',array('id'=>'soap_outCC','value'=>$soap_in));?>
							<div width="27%" style="float: left;">
							</div>
				</td>
			</tr>
		</table>
	<?php echo $this->Form->end();?>
 	</td>
 </tr>
 <tr>
	<td>
		<?php echo $this->Form->create('Note',array('action'=>'soapNote','id'=>'familyfrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
				<div style="color: #31859c; float: left;">
					<b><?php echo __("Family Personal Notes");?> </b>
				</div>
				<div style="float: left;">
				<?php if(!empty($family_tit_bit)){
				$checkFamilyVal=1;
				//echo $this->Form->hidden('',array('value'=>$checkFamilyVal,'label'=>false,'id'=>'ccCheck'));
				}else{
					$family_tit_bit=$family_tit_bit1;
				$checkFamilyVal=0;
				//echo $this->Form->hidden('',array('value'=>$checkFamilyVal,'label'=>false,'id'=>'ccCheck'));
				}?>
					<?php echo $this->Form->input('family_tit_bit',
							array('type'=>'text','cols'=>'1','rows'=>'1','class'=>'resize-input', 'style'=>'height:27px;;width:300px', 
								'value'=>$family_tit_bit,'label'=>false,'id'=>'family_tit_bit'));?>
				</div>
				<?php echo $this->Form->hidden('hidden_sure_family_tit_bit',array('value'=>'','id'=>'hidden_sure_family_tit_bit'));?>
				<?php echo $this->Form->hidden('patient_id',array('value'=>$patientId));?>
				<?php echo $this->Form->hidden('id',array('id'=>'familyid','value'=>$noteId));?>
				<?php echo $this->Form->hidden('appt',array('value'=>$appt));?>
				<?php echo $this->Form->hidden('soap_in',array('value'=>$soap_in));?>
				<?php echo $this->Form->hidden('soap_out',array('id'=>'soap_outFamily','value'=>$soap_in));?>
				<div style="float: left;">
					<?php //echo $this->Html->link($this->Html->image('icons/saveSmall.png'),'javascript:void(0)',array('onclick'=>"saveSoap('familyfrm')",'label'=>false,'id'=>'cc1_submit','escape'=>false));?>
				</div>
		<?php echo $this->Form->end();?>
	</td>
</tr>
<tr>
 <td >
  <div style="color: #31859c; width: 143px; float: left; width: 91px;">
   <?php if(empty($flagEvent)){
           $display='none';
         }else{
			$display='block';
			$checked='checked';
			$disabledCheckBox='disabled';
		}
    ?>
    <b>
    <?php echo __("Chart Alert"); 
		  echo ' '.$this->Form->checkbox('',array('id'=>'showFlagEvent','checked'=>$checked,'disabled'=>$disabledCheckBox));
	?>
	</b>
	</div>
	<div >
		<?php if(!empty($flagEvent)){
				$checkFlagVal=1;
			  }else{
				$checkFlagVal=0;
			  }
		?>
		<span style="display:<?php echo $display;?>" id='eventText'>
			<?php echo $this->Form->input('flag_event',array('type'=>'text','cols'=>'1','rows'=>'1','id'=>'flagEventId','class'=>'resize-input','style'=>'height:27px;', 'value'=>$flagEvent,'label'=>false));
			?>
		</span>
	</div>
	<?php echo $this->Form->hidden('hidden_sure_flag_event',array('value'=>'','id'=>'hidden_sure_flag_event'));?>
	<?php echo $this->Form->hidden('patient_id',array('value'=>$patientId));?>
	<?php echo $this->Form->hidden('id',array('id'=>'familyid1','value'=>$noteId));?>
	<div style="float:left; font-size:13px;padding-left: 5px;">
		<span style="display:<?php echo $display;?>" id='eventTextSubmit'></span>
	</div>
 </td>
</tr>
<?php if(strtolower($this->Session->read('role'))=='primary care provider'){?>
<tr style="color: #31859c; width: 143px; float: left; ">
	<td>
		<b>
		<?php echo __("Use Own SmartPhrases");echo " ".$this->Form->checkbox('',array('id'=>'ownSmartPharse','checked'=>$this->Session->read('set')));
		echo $this->Form->input('',array('type'=>'hidden','id'=>'ownSmartPharseDoc','value'=>'0'));?>
		</b>
	</td>
</tr>
<?php }?>
</table>
 </div>
</div>
</div>
</div>


</div> <!-- Main div end -->
<!-- power Note Code EOD -->


<script type="text/javascript">

		$('#soap_submit1').click(function(){
			var disableReconcile=document.getElementById("reconcilecheck").disabled;
			var disableMed=document.getElementById("nomedcheck").disabled;
		var reconForMed=$('#reconcilecheck:checked').length;
		var noForMed=$('#nomedcheck:checked').length;
		if(reconForMed==0 && disableReconcile!=true){
			$('#flashMessage').show();
			$(window).scrollTop($('#flashMessage').offset().top);
			$('#flashMessage').html('Please Reconcile Medication.');
			return false;
		}
		if(noForMed==0 && disableMed!=true){
			$('#flashMessage').show();
			$(window).scrollTop($('#flashMessage').offset().top);
			$('#flashMessage').html('Please Check No known active medication.');
			return false;
		}
		
	$('#noteSign').val('1');
	if(confirm("This will permanently finalize this encounter as a legal document.You will not be able to make edits after signing")){
		return true;
	}else{
		return false;
	}
});
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
			ui.item.css({
				'top':'0','left':'0'}); //Opera fix
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
		var sortorder={
			items: items };
			//Pass sortorder variable to server using ajax to save state
		/*	var ajaxUrl = "<?php //echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "saveWidget","admin" => false)); ?>";
			$.post(ajaxUrl, 'data='+JSON.stringify(sortorder), function(response){
				if(response=="success")
					$("#console").html('<div class="success">Saved</div>').hide().fadeIn(1000);
				setTimeout(function(){
					$('#console').fadeOut(1000);
				}, 2000);
			});
		*/
				//ROS

				/*  function reviewOfSystems(){
				 alert('hi');
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "reviewOfSystem","admin" => false)); ?>";
				$.ajax({
						type: 'POST',
						url: ajaxUrl,
						//data: formData,
						dataType: 'html',
						success: function(data){
			   alert(data);
						},
						});
				 
				return false;
				}*/

				//EOF ROS
	}
	//*******************ROS***********************************
//***************************************SOE******************************
	$('#soe,#soe1').click(function(){
		var widgetIdSoe = $(this).attr('widgetID');
		
		if('<?php echo $noteId?>'==''){	
			var noteID=	$('#subjectNoteId').val();
		}else{
			var noteID=	'<?php echo $noteId?>';
		}
		window.location.href="<?php echo $this->Html->url(array("controller" => "Notes", "action" => "systemicExamination")); ?>"
		+"/"+'<?php echo $patientId?>'+'/'+noteID+'?widgetId=2169';
		});
	//***************************************Vital******************************
	$('#vitalLink').click(function(){
		var widgetId = $(this).attr('widgetID');
		if('<?php echo $noteId?>'==''){	
			var noteID=	$('#subjectNoteId').val();
		}else{
			var noteID=	'<?php echo $noteId?>';
		}
		window.location.href="<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "addVital")); ?>"
		+"/"+'<?php echo $patientId?>'+'/'+'null/'+ '<?php echo $_SESSION["apptDoc"] ?>?form=soap&noteId='+noteID+'&appt=<?php echo $_SESSION['apptDoc']?>'+'&widgetId='+widgetId;
		});
//*******************HPI***********************************
	$('#hpi').click(function(){
		var widgetId = $(this).attr('widgetID');
		if('<?php echo $noteId?>'==''){	
			var noteID=	$.trim($('#subjectNoteId').val());
		}else{
			var noteID=	'<?php echo trim($noteId);?>';
		}
		window.location.href="<?php echo $this->Html->url(array("controller" => "PatientForms", "action" => "hpiCall")); ?>"+'/'+'<?php echo $patientId?>'+'/'+noteID+'?widgetId='+widgetId;
		});

	/*function loading(){
 
		 $(".wrapper").block({
	        message: '<h1><?php //echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please wait...</h1>',
	        css: {
	        	padding: '5px 0px 5px 18px',
	        	border: 'none',
	        	padding: '15px',
	        	backgroundColor: '#000000',
	        	'-webkit-border-radius': '10px',
	        	'-moz-border-radius': '10px',
	        	color: '#fff',
	        	'text-align':'left'
	        },
	        overlayCSS: {
backgroundColor: '#000000' }
	    });
	}*/

	/*function onCompleteRequest(){
		$('.outerDiv').unblock();
		return false ;
	}*/

	</script>
<script type="text/javascript">
	function numericFilter(txb) {
  	   txb.value = txb.value.replace(/[^\0-9]/ig, "");
  	}

  	
	 function icdwin(widgetId) {
		 var patientId='<?php echo $patientId?>';
		 var myNoteId= $('#subjectNoteId').val(); 
		 if('<?php echo $noteId ?>'=='' && myNoteId==''){
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "checkNoteIdForDiagnosis","admin" => false)); ?>";
			  $.ajax({
		        	beforeSend : function() {
		        		//loading();
		        	},
		        	type: 'POST',
		        	url: ajaxUrl+"/"+'<?php echo $patientId?>',
		        	//data: formData,
		        	dataType: 'html',
		        	success: function(data){
			        	var noteid=parseInt($.trim(data));
			        	 $('#familyid').val(data);
						  $('#ccid').val(data); 
						  $('#subjectNoteId').val(data); 
						  $('#assessmentNoteId').val(data); 
						  $('#objectiveNoteId').val(data); 
						  $('#planNoteId').val(data); 
						  $('#signNoteId').val(data);
						  note_id  = "<?php echo $noteId ?>" ;
						 
						  if(note_id!='')
							window.location.href =  "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed"));?>"+'/'+ patientId+'/'+'0'+'/'+note_id+'/'+'?appt=<?php echo $_SESSION['apptDoc']?>'+'&widgetId='+widgetId;
							else
								window.location.href =  "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed",'appt'=>$_SESSION['apptDoc'])); ?>"+'/'+ patientId+'/'+'0'+'/'+noteid+'?widgetId='+widgetId ;
		        },
				});
		 }
		 else{
			 if('<?php echo $noteId ?>'==''){
			 note_id  =$.trim(myNoteId);
			 }else{
				 note_id  = '<?php echo $noteId ?>';
				 note_id=$.trim(note_id);
			 }
					window.location.href =  "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>"+'/'+ patientId+'/'+'0'+'/'+note_id+'/'+'?appt=<?php echo $_SESSION['apptDoc']?>'+'&widgetId='+widgetId;
					
			
		}
	 }
	function orderSet(patientId,widgetId){
		$.fancybox({
				'width' : '50%',
				'height' : '60%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'onClosed':function(){
                   //getPowerNote();
					getmedication();
					getAllergy();
					
				},
				'href' : "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "getPackage")); ?>"+"/"+patientId+'/'+'?controllerFlag=Notes&widgetId='+widgetId,

			});
		 $('html, body').animate({ scrollTop: 0 }, 'slow', function () {
    });

	}
		function addMedication(patientId,widgetId){
			 note_id  = "<?php echo $noteId ?>" ;
			 if(note_id==''){
				 note_id=$('#subjectNoteId').val(); 
			 }	
			
			 if(note_id==""){
				 var ajaxUrl1 = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "checkNoteIdForDiagnosis","admin" => false)); ?>";
				  $.ajax({
			        	beforeSend : function() {
			        		//loading();
			        	},
			        	type: 'POST',
			        	url: ajaxUrl1+"/"+patientId,
			        	dataType: 'html',
			        	success: function(data){
				        	var note_id1=$.trim(data);
				        	window.location.href =  "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addMedication")); ?>"
				        	+'/'+ patientId+'/'+null+'/'+null+'/'+null+'/'+note_id1+'/'+'?appt=<?php echo $_SESSION['apptDoc']?>'+'&widgetId='+widgetId;
				        	},
				  });
			 }else{
				 window.location.href =  "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addMedication")); ?>"
				 +'/'+ patientId+'/'+null+'/'+null+'/'+null+'/'+note_id+'/'+'?appt=<?php echo $_SESSION['apptDoc']?>'+'&widgetId='+widgetId;
			 }

		}
		function addAllergy(patientId,al_id,flag){
			 note_id  = "<?php echo $noteId ?>" ;
			 if(note_id==''){
				 note_id=$('#subjectNoteId').val(); 
			 }	
			
			 if(note_id==""){
				 var ajaxUrl1 = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "checkNoteIdForDiagnosis","admin" => false)); ?>";
				  $.ajax({
			        	type: 'POST',
			        	url: ajaxUrl1+"/"+patientId,
			        	dataType: 'html',
			        	success: function(data){
			        		var noteid=parseInt($.trim(data));
				        	 $('#familyid').val(noteid);
							  $('#ccid').val(noteid); 
							  $('#subjectNoteId').val(noteid); 
							  $('#assessmentNoteId').val(noteid); 
							  $('#objectiveNoteId').val(noteid); 
							  $('#planNoteId').val(noteid); 
							  $('#signNoteId').val(noteid);
				        	},
				  });
			 }
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
                  // getPowerNote();
					getmedication();
					getAllergy();
					
				},
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "allallergies")); ?>"+"/"+patientId
				+ '/' + al_id + '/' + 'null'+'/'+'?personId=<?php echo $getElement['Patient']['person_id']?>&allergyAbsent='+flag+'&controllerFlag=Notes',

			});
			
			//$("html, body").animate({ scrollTop: 0 }, "slow");
			$(document).scrollTop(0);
			
		}
		$(document).ready(function(){
			 var isDocPharse='0';
			 $('#ownSmartPharse').click(function(){
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "docComplete","admin" => false)); ?>";
				if($('#ownSmartPharse').prop('checked') == true){
					 $.ajax({
			        	beforeSend : function() {
			        		$('#busy-indicator').show('fast');
			        	},
			        	type: 'POST',
			        	url: ajaxUrl+'/1',
			        	dataType: 'html',
			        	success: function(data){
			        		$('#busy-indicator').hide('fast');
			        		$('#flashMessage').show();
			        		$('#flashMessage').html('Own SmartPhrases Loaded');
			        	},
					});
   				 }else{
					 $.ajax({
				        	beforeSend : function() {
				        		$('#busy-indicator').show('fast');
				        	},
				        	type: 'POST',
				        	url: ajaxUrl+'/0',
				        	dataType: 'html',
				        	success: function(data){
				        		$('#busy-indicator').hide('fast');
				        		$('#flashMessage').show();
				        		$('#flashMessage').html('Own SmartPhrases Unloaded');	        	
				        	},
						});
				 }
			});
			
			//**********************************************SmartPharse************************************************************
				//$('#subShow').focus(function(){
					$("#subShow1").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" =>"getSmartPhrase","admin" => false,"plugin"=>false)); ?>",{
						width: 250,
						isSmartPhrase:true,
						delay:500,
					onItemSelect:function () {
						var HpiCopyText=$('#subShow').val();	
						$('#overLap').html(HpiCopyText);
					 },
					change: function( event, ui ) {}
					});	
				//});
				
	//$('#objectShow').focus(function(){
	  $("#objectShow1").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>"+"/"+$('#ownSmartPharseDoc').val(), {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			delay:500,
			//autoFill:true,
			onItemSelect:function(e){ 
			var objectShow=$('#objectShow').val();	
			//$('#objectShow').val(objectShow.substring(1));
		}
		});
	//});
//	$('#AssesShow').focus(function(){
	  $("#AssesShow1").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>"+"/"+$('#ownSmartPharseDoc').val(), {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			delay:500,
			//autoFill:true,
			onItemSelect:function(e){
			var AssesShow=$('#AssesShow').val();	
			//$('#AssesShow').val(AssesShow.substring(1));
			 }
		});
	// });

	//$('#planShow').focus(function(){
	  $("#planShow1").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>"+"/"+$('#ownSmartPharseDoc').val(), {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			delay:500,
			//autoFill:true,
			onItemSelect:function(e){
				var planShow=$('#planShow').val();	
			//	$('#planShow').val(planShow.substring(1));
			 }
		});
	// });
	//$('#subShowRos').focus(function(){
	  $("#subShowRos1").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>"+"/"+$('#ownSmartPharseDoc').val(), {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			delay:500,
			//autoFill:true,
			onItemSelect:function(e){ 
				var subShowRos=$('#subShowRos').val();	
			//$('#subShowRos').val(subShowRos.substring(1));
			}
		});
	// 	});
	  //********************************************************************************************************
			if('<?php echo $noteId?>'=='' || $('#subjectNoteId').val()==''){
				//$('#residentCheck').disabled=true;
				$('#residentCheck').attr('disabled',true);
			}
			var location='<?php echo $getVitals['Note']['location'];?>'
			var pain='<?php echo $getVitals['Note']['pain'];?>'
			$('#locations').val(location);
			$('#pain').val(pain);
		});
		
		function getInactiveProblem() {
			var patientId='<?php echo $patientId?>';
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getInactiveProblem","admin" => false)); ?>";
			 $.ajax({
		        	beforeSend : function() {
		        	//	$("#Assessment").html("<table><tr><td>Loading Assessment Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
		        	},
		        	type: 'POST',
		        	url: ajaxUrl+'/'+patientId,
		        	//data: formData,
		        	dataType: 'html',
		        	success: function(data){
			        	//alert(data);
			     /*   	$.each(data, function(index, name) {
			        		 alert(name)
			        		  });
		        	*/
		        	
		        },
				});
		}

		function proceduresearch(source) {
		    var identify ="";
		    identify = source;
		    $.fancybox({
						'width' : '100%',
						'height' : '100%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "proceduresearch")); ?>" + "/" + identify,
					});
		   }
		   //***************************************hide show add part******************************************************
		   $('#add-template').click(function(){
			   $('#add-template-form').show();
			   });
			   $('#close-template-form').click(function(){
			   $('#add-template-form').hide();
			   $('#sHide').show();
			   });
			   //*****************************************EOF******************************************************************
			   //*********************Add new title in noteTemplate Table*********************************************************
			   $('#submitTemplate').click(function(){
				   $('#addTitle').focus();
				   var checkPatch=$("*:focus").attr('id');
				  if(checkPatch=='addTitle'){
			  		var title=$('#addTitle').val();
			   		if(title==''){
				   		alert('Please enter value to save');
				   		return false;
			   		}
			   		else{
				   		$('#sHide').show();
			   		}
			   		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "addTempleteTitle","admin" => false)); ?>";
			   		$.ajax({
			 			  type: "POST",
			 			  url: ajaxUrl+"/"+title,
			 			  context: document.body,
			 			  beforeSend:function(){
			 			  	// this is where we append a loading image
			 			  	$('#busy-indicator').show('fast');
			 			  	 
			 			  },
			 			  success: function(data){
			 				 $("#language").append( new Option(data , data) );
							  $('#busy-indicator').hide('slow');
							  $('#addTitle').val("");
							  $('#add-template-form').hide();
								$('#flashMessage').show();
								$('#flashMessage').html('Template Title Successfully Added.');
							  	
							  	
						  }
					});
				}
			});
			//*******************************************EOF********************************************************************************
			//*****************************************Search the title present************************************************************
			$("#search").keypress(function(e) {
   				 if(e.which == 13) {
    						searchTemplate();
    					}
				});
			$("#searchBtn").click(function() {	 
   						searchTemplate();

				});	
				function searchTemplate(searchTitle,searchFrom){
				searchFromTemplate = (searchFrom === undefined) ? searchFromTemplate : searchFrom;
				var serachText=$('#search').val();
				var serachText=serachText.split(' (');
				if(serachText==''){
					alert('Please enter data');
					return false;
				}
				searchTitle = (searchTitle === undefined) ? serachText['0'] : searchTitle;
				
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getSoap","admin" => false)); ?>";
				$.ajax({
				 			  type: "POST",
				 			  url: ajaxUrl+"/"+searchTitle+"/"+ searchFromTemplate,
				 			  beforeSend:function(){
				 			  	// this is where we append a loading image
				 			  	$('#busy-indicator').show('fast');
				 			  },
				 			  success: function(data){
					 			  if(searchFromTemplate == 'true'){
					 				 searchFromTemplate = 'false';
				 				 	var displayData=data.split('|~|');
									$('#subjectiveDisplay').html(displayData[0]);
									$('#objectiveDisplay').html(displayData[1]);
									$('#assessmentDisplay').html(displayData[2]);
									$('#planDisplay').html(displayData[3]);
									$('#rosDisplay').html(displayData[4]);
									$('#busy-indicator').hide('slow');
									expandCollapseAll('expand_id');
					 			  }else{
					 				 $('#search').val('');
					 				 var data=jQuery.parseJSON(data);
					 				$('#templateTitleContainer').html('');
					 				 $.each(data,function (key, value){
						 				$('#templateTitleContainer').append($('<td>').attr({onclick:'javascript:searchTemplate("'+value+'","true")'})
						 						.css({ 'font-size' : '13px', 'color' : '#31859c', 'text-decoration' : 'underline', 'cursor' : 'pointer' }).text(value));
								 	});
					 				 
					 				$('#busy-indicator').hide('slow');
					 				expandCollapseAll('expand_id');
					 			  }
							  }
						});
			}
			//********************************************EOF******************************************************************************
			$('#add-template').click(function(){
				$('#addTitle').focus();
				$('#sHide').hide();
				});

			$('#checkPostive').click(function(){
				if('<?php echo $noteId ?>'==''){
									var sunNoteId=$('#subjectNoteId').val();
									if(sunNoteId==''){
													var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "postiveCheck",$patientId,"admin" => false)); ?>";
													$.ajax({
											 			  type: "POST",
											 			  url: ajaxUrl+"/"+'1',
											 			  beforeSend:function(){
											 			  	// this is where we append a loading image
											 			  	$('#busy-indicator').show('fast');
											 			  },
											 			  success: function(data){
															  var nId=$.trim(data);
															 // if($.trim(data)=='save'){
															  $('#positiveGreen').show();
															  $('#positiveRed').hide();
															  $('#familyid').val(nId);
															  $('#ccid').val(nId); 
															  $('#subjectNoteId').val(nId); 
															  $('#assessmentNoteId').val(nId); 
															  $('#objectiveNoteId').val(nId); 
															  $('#planNoteId').val(nId); 
															  $('#signNoteId').val(nId);
															 	
														// }
														 $('#busy-indicator').hide('slow');

														  }
													});
									}
									else{
										var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "postiveCheck",$patientId,"admin" => false)); ?>";
										$.ajax({
								 			  type: "POST",
								 			  url: ajaxUrl+"/"+'1'+'/'+sunNoteId,
								 			  beforeSend:function(){
								 			  	// this is where we append a loading image
								 			  	$('#busy-indicator').show('fast');
								 			  },
								 			  success: function(data){
												  if($.trim(data)=='save'){
												 $('#positiveGreen').show();
												 $('#positiveRed').hide();
												 	
											 }else{
										
											 }
											 $('#busy-indicator').hide('slow');

											  }
										});
									}
				}
				else{
					var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "postiveCheck",$patientId,"admin" => false)); ?>";
					$.ajax({
			 			  type: "POST",
			 			  url: ajaxUrl+"/"+'1'+'/'+'<?php echo $noteId?>',
			 			  beforeSend:function(){
			 			  	// this is where we append a loading image
			 			  	$('#busy-indicator').show('fast');
			 			  },
			 			  success: function(data){
							  if($.trim(data)=='save'){
							 $('#positiveGreen').show();
							 $('#positiveRed').hide();
							 	
						 }else{
					
						 }
						 $('#busy-indicator').hide('slow');

						  }
					});
				}		
				});
				function saveFamily(){
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "soapNote","admin" => false)); ?>";
				var formData = $('#family_id').serialize();
				//
				$.ajax({
		 			  type: "POST",
		 			  url: ajaxUrl,
		 			  data: formData,
		 			  beforeSend:function(){
		 			  	// this is where we append a loading image
		 			  	$('#busy-indicator').show('fast');
		 			  },
		 			  success: function(data){
						  $('#busy-indicator').hide('slow');
						  alert('Saved Successfully');
					  }
				});
				}
			function saveSoap(recive){
					var eTime=$('#elapsedtym').html().split(" ");
					if($('#soap_outCC').val() < eTime['0'])
						$('#soap_outCC').val(eTime['0']);
					$('#soap_outPlan').val(eTime['0']);
					$('#soap_outAssessment').val(eTime['0']);
					$('#soap_outSubjective').val(eTime['0']);
					$('#soap_outOjective').val(eTime['0']);
					$('#soap_outFamily').val(eTime['0']);
					
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "soapNote","admin" => false)); ?>";
				var formData='';
				var saveMsg="";
				if(recive=='familyfrm'){
				 formData = $('#familyfrm').serialize();
				 if($('#family_tit_bit').val()==''){
					 saveMsg="Family Personal Notes Saved.";
					 }
					 else{
						 saveMsg="Family Personal Notes Updated."; 
						 $("#hidden_sure_family_tit_bit").val(0);
					 }
				 
				}
				else if(recive=='cc'){
					formData = $('#cc_id').serialize();
					$("#hidden_sure_cc").val(0);
					
					if($('#cc').val()==''){
						 saveMsg="Chief Complaints Saved.";
						 }
						 else{
							 saveMsg="Chief Complaint Updated.";
						 }
				}
				else if(recive=='subject'){
					 formData = $('#subject').serialize();
					 if($('#subShow').val()==''){
					 saveMsg="Subjective Data Saved.";
					 }
					 else{
						 saveMsg="Subjective Data Updated.";
					 }
					 $('#hpiStrip').addClass('new'); // To bring strip in power note
				}
				else if(recive=='objective'){  
					var formData = $('#objective').serialize();
				if($('#objectShow').val()==''){
					 saveMsg="Objective Data Saved.";
					 }
					 else{
						 saveMsg="Objective Data Updated.";
					 }
				}
				else if(recive=='plan'){

					//diagnosis drop down value chage text code
					var problemSelected=$('#problemLabRad option:selected').val();
					var planShowVal=$('#planShow').val();
					if(problemSelected=="0")
						$('.mainTextboxData').attr('id',planShowVal);
					else
						$('.'+problemSelected).attr('id',planShowVal);
					
					 formData = $('#plan').serialize();
					 if($('#planShow').val()==''){
						 saveMsg="Plan Data Saved.";
						 }
						 else{
							 saveMsg="Plan Data Updated.";
						 }
				}
				else if(recive=='assessment'){
					 formData = $('#assessment').serialize();
					 if($('#AssesShow').val()==''){
						 saveMsg="Assessment Data Saved.";
						 }
						 else{
							 saveMsg="Assessment Data Updated.";
						 }
				}
				//
				if(recive=='cc'){
					recive='add';
				}else if(recive=='familyfrm'){
					recive='add';
				}
				$.ajax({
		 			  type: "POST",
		 			  url: ajaxUrl,
		 			  data: formData,
		 			  beforeSend:function(){
		 			  	 $('#busy-indicator').show('slow');
		 			  },
		 			  success: function(data){

			 			  if(recive == 'subject'){
            			  	$("#hidden_subjectNoteId").val(0);
				 		  }
			 			 if(recive == 'objective'){
	            			  	$("#hidden_objectiveNoteId").val(0);
					 	}
			 			if(recive == 'assessment'){
            			  	$("#hidden_assessmentNoteId").val(0);
				 		}
			 			if(recive == 'plan'){
            			  	$("#hidden_planId").val(0);
            				$("#hidden_activity_box_Id").val(0);
				 		}
		 				var noteid=parseInt(data);
		 				alert(saveMsg);
						 // $('#busy-indicator').hide('slow');
						  $('#busy-indicator').hide('slow');
						  $('#familyid').val(noteid);
						  $('#ccid').val(noteid); 
						  $('#subjectNoteId').val(noteid); 
						  $('#assessmentNoteId').val(noteid); 
						  $('#objectiveNoteId').val(noteid); 
						  $('#planNoteId').val(noteid); 
						  $('#signNoteId').val(noteid);
						  $('#residentCheck').attr('disabled',false);
					  }
				});
				}
				$( "#dateID" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				//yearRange: '1950',
				//yearRange : '-50:+50',
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				maxDate: new Date(),
				onSelect:function(){
					$(this).focus()}
			});
			$("#checkVital").click(function(){
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getInitalData",$patientId,'fromSoap',"admin" => false)); ?>";
				$.ajax({
		 			  type: "POST",
		 			  url: ajaxUrl,
		 			  beforeSend:function(){
		 			  	// this is where we append a loading image
		 			  	$('#busy-indicator').show('fast');
		 			  },
		 			  success: function(data){
						  var data=jQuery.parseJSON(data);
						  if(data.temperature!=null)
						  	$('#temp').val(data.temp);

						  if(data.rr!=null)
						  	$('#rr').val(data.rr);
						  	
						  if(data.pr!=null)
						  	$('#pr').val(data.pr);
						  	
						  if(data.bp!=null)
						  	$('#bp').val(data.bp);
						 	
						 if(data.spo2!=null)
						 	$('#spo').val(data.spo2);
						 	
						 if(data.location!=null)
						 	$('#locations').val(data.location);
						 	
						 if(data.duration!=null)
						 	$('#duration').val(data.duration);
						 	
						 if(data.frequency!=null)
						 	$('#frequency').val(data.frequency);
						 	
						 if(data.pain!=null)
						 	$('#pain option:selected').text(data.pain);
						 	
						 $('#busy-indicator').hide('slow');

					  }
				});

				});
				$("#checkVital1").click(function(){
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getInitalData",$patientId,"admin" => false)); ?>";
				$.ajax({
		 			  type: "POST",
		 			  url: ajaxUrl,
		 			  beforeSend:function(){
		 			  	// this is where we append a loading image
		 			  	$('#busy-indicator').show('fast');
		 			  },
		 			  success: function(data){
						  var data=jQuery.parseJSON(data);
						  //var CData=$('#Cc').val();
						  $('#Cc').val(data.chiefComplaints);

						  	
						  $('#busy-indicator').hide('slow');

					  }
				});
				});

			
			var searchFromTemplate= 'false';
			$("#search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NoteTemplate","template_name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				onItemSelect : function (){
					searchFromTemplate = 'true';
				}
			});
			/*$("#search").autocomplete({
			 source: "<?php echo $this->Html->url(array('controller' => 'app', 'action' => 'autocompleteNew','NoteTemplate','template_name','null','null','null','admin' => false,'plugin'	=>false)); ?>",
				 //minLength: 1,
				 select: function( event, ui ) { 
					searchFromTemplate = 'true';
				 },
				  messages: {
				        noResults: '',
				        results: function() {},
				 }
			});*/
		
			$("#icon_search").click( function(){
				$('#wheel').toggle('slow');
			});
			$("#wheel").click( function(){
				var valWheel=$('#wheel option:selected').text();
				$('#search').val(valWheel);
				searchFromTemplate = 'true';
				$('#search').focus();
			});

			//***********************callDragon***************************************
			function callDragon(notetype){
				$
				.fancybox({
					'width' : '50%',
					'height' : '50%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "dragon")); ?>"+'/'+ notetype
				});
				 
			}
		//****************************************Paycheck***********************************************************************
		// this function is commented becoz billing flow is changes -Aditya
		/*function confirmPayType(patientId,widgetId,typeLocation,insuranceType,noteId) {
			if(insuranceType=='437'){
				var chk=confirm('This Patient is Self Pay. Do you want to continue?');// check self pay
					if(chk==true){
						var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "updatePatientStatus","admin" => false)); ?>";
						$.ajax({
						  type: "POST",
						  url: ajaxUrl+'/'+patientId,
						  beforeSend:function(){
						  	$('#busy-indicator').show('fast');
						  },
						  success: function(data){
						  	$('#busy-indicator').hide('slow');
						  	if(typeLocation=='1'){
						  		addLabOrder(patientId,widgetId);
						  	}else if(typeLocation=='2'){
						  		addRadOrder(patientId,widgetId);
						  	}else if(typeLocation=='3'){
						  		addProcedurePerform(patientId,widgetId);
						  	}
						  	else if(typeLocation=='4'){
						  		orderSet(patientId,widgetId);
						  	}
					  	  }
						});	
					}else{
						var insurance=confirm('Do you want to add insurance?');// Add insurance
							if(insurance==true){
								window.location.href =  "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "insuranceIndex")); ?>"+'/'+ patientId+'/?person_id='+'<?php echo $getElement["Patient"]["person_id"] ?>'+"&backTo="+noteId;
							}else{
								
							}
					}
			}else{
				alert('Please Select Insurance');
				window.location.href =  "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "insuranceIndex")); ?>"+'/'+ patientId+'/?person_id='+'<?php echo $getElement["Patient"]["person_id"]?>'+"&backTo="+noteId;
			}

		}*/
		function addLabOrder(patientId,widgetId){
		var problemLabRad=$('#problemLabRad option:selected').text();
			 note_id  = "<?php echo $noteId ?>" ;
			 appt  = "<?php echo $_SESSION['apptDoc']; ?>" ;
			 if(note_id==''){
				 note_id=$('#subjectNoteId').val(); 
				 if(note_id=='')
				 note_id='null';
			 }	 
			window.location.href =  "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addLab")); ?>"
			+'/'+ patientId+'/'+note_id+'/'+null+'/'+appt+'/'+'?labRad='+problemLabRad+'&widgetId='+widgetId;
		}
		function addRadOrder(patientId,widgetId){

			 note_id  = "<?php echo $noteId ?>" ;
			 appt  = "<?php echo $_SESSION['apptDoc']; ?>" ;
			 if(note_id==''){
				 note_id=$('#subjectNoteId').val(); 
				 if(note_id=='')
				 note_id='null';
			 }	 
			window.location.href =  "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addRad")); ?>"+'/'+ patientId+'/'+note_id+'/'+appt+'?widgetId='+widgetId;
		}
		function addProcedurePerform(patientId,widgetId){
			 note_id  = "<?php echo $noteId ?>" ;
			 appt  = "<?php echo $_SESSION['apptDoc']; ?>" ;
			 if(note_id==''){
				 note_id=$('#subjectNoteId').val(); 
				 if(note_id=='')
				 note_id='null';
			 }	 
			window.location.href =  "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addProcedurePerform")); ?>"+'/'+ patientId+'/'+note_id+'/'+appt+'?widgetId='+widgetId;
		}



		</script>
<script>
$(function(){
	/*setInterval(function(){	 
		$(".elapsed").each(function() {
		  currentID= this.id ; //elapsed container id
		  currentValue = $(this).html(); 
		  status=$('#'+currentID).val();
		 var maxTime= $.trim(currentValue).split(" ") ; 
		 
		 if(maxTime[0]>=180){
			 return false;
		 }
		  if(currentValue.trim() ==  ''){
			  $(this).html("1 Min");
		  }else{
			  splittedVal= $.trim(currentValue).split(" ") ; //split number and "minutes" text
			  currentMin =  parseInt(splittedVal[0],10)+1 ;
			  if(currentMin<15){
			  $(this).html(currentMin+" Min");
			  }
			  else if(currentMin>15 && currentMin<=30){
				  $("#"+currentID).removeClass("elapsedGreen");
				  $("#"+currentID).addClass("elapsedYellow");
				  $(this).html(currentMin+" Min");
			  }
			  else if(currentMin>30){
				  $("#"+currentID).removeClass("elapsedYellow");
				  $("#"+currentID).addClass("elapsedRed");
				  $(this).html(currentMin+" Min");
			  }
		  } 
		})	;				
	},60000);*/
	
	
});

function sendReferral(){ 
	var noteIDR=	'<?php echo trim($noteId)?>'; 
	if((noteIDR) != ''){
		var noteIDR=   $('#subjectNoteId').val();
	}
	if(noteIDR==""){
		 var ajaxUrl1 = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "checkNoteIdForDiagnosis","admin" => false)); ?>";
		  $.ajax({
	        	beforeSend : function() {
	        		//loading();
	        	},
	        	type: 'POST',
	        	url: ajaxUrl1+"/"+<?php echo $patientId?>,
	        	dataType: 'html',
	        	success: function(data){
	        		var noteIDR=parseInt($.trim(data));
		        	 $('#familyid').val(noteIDR);
					  $('#ccid').val(noteIDR); 
					  $('#subjectNoteId').val(noteIDR); 
					  $('#assessmentNoteId').val(noteIDR); 
					  $('#objectiveNoteId').val(noteIDR); 
					  $('#planNoteId').val(noteIDR); 
					  $('#signNoteId').val(noteIDR);
					  window.location.href = "<?php echo $this->Html->url(array('controller'=>'messages','action'=>'composeCcda',$patientId)); ?>"
							+'/'+'null'+'/'+noteIDR+'/'+'?returnUrl=compose';
		        	},
		  });
	 }
	else{
		 window.location.href = "<?php echo $this->Html->url(array('controller'=>'messages','action'=>'composeCcda',$patientId)); ?>"
				+'/'+'null'+'/'+noteIDR+'/'+'?returnUrl=compose';
	}
	
}


var toogle=0;
$('#showFlagEvent').click(function(){
if($('#showFlagEvent:checked').length > 0){
	$('#eventText').show();
	$('#eventTextSubmit').show();
}
else{
	$('#eventText').hide();
	$('#eventTextSubmit').hide();
}
	
});
	var checkValChartAlert='<?php echo $checkFlagVal ?>';
		$('#flagEventId').change(function(){
			checkValChartAlert=2;
 });
function updateEventFlag(){
	if($('#flagEventId').val()=='' || checkValChartAlert==1 || checkValChartAlert==0){
		return false;
	}else{
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "updateEventFlag",$patientId,$_SESSION['apptDoc'],"admin" => false)); ?>";
			  var formData =$('#flagEventId').val();
			$.ajax({
					  type: "POST",
					  url: ajaxUrl,
					  data:{"expression" : formData},
					  beforeSend:function(){
					  	// this is where we append a loading image
					  //	$('#busy-indicator').show('fast');
					  	 loading('addTable','id'); 
					  },
					  success: function(data){
					//  $('#busy-indicator').hide('slow');
					$("#hidden_sure_flag_event").val(0);
					if($('#flagEventId').val()==''){
						$('#flashMessage').show();
						$('#flashMessage').html('Chart Alert Saved');
					}
					else{
						$('#flashMessage').show();
						$('#flashMessage').html('Chart Alert Updated');
					}
					  	onCompleteRequest('addTable','id');
					  
		
				  }
			});
	}
	}
	 function callDoc(id,appt){
		 var noteIDCall=	'<?php echo trim($noteId)?>'; 
			if((noteIDCall) == ''){
				var noteIDCall=   $('#subjectNoteId').val();
			}

		window.location.href = "<?php echo $this->Html->url(array('controller'=>'PatientDocuments','action'=>'add',$patientId)); ?>"
			+'/'+'null'+'/'+'soap'+'/'+noteIDCall+'?appt='+appt
	}


	 function edit_radorder(id){
			$.fancybox({
				'width' : '70%',
				'height' : '70%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "editRad")); ?>"
				+'/'+id,

			});
	}
		
	 		var checkValFamily='<?php echo $checkFamilyVal ?>';
	 		$('#family_tit_bit').change(function(){
		 	checkValFamily=2;
		 });
			 
		
		
		$('#family_tit_bit').blur(function(){
			if($('#family_tit_bit').val()=='' || checkValFamily==1 || checkValFamily==0){
				return false;
			}else{
				checkValFamily="";
				saveSoap('familyfrm');
			}
			
			});
		$('#flagEventId').blur(function(){
			updateEventFlag();
			});
		function previewPowerNote(){
			
			 var noteIDPreview=	'<?php echo trim($noteId)?>'; 
				if((noteIDPreview) == ''){
					var noteIDPreview=$('#subjectNoteId').val();
				}
				if(noteIDPreview==''){
				alert('Please fill Subjective to proceed');
				return false;
				}
				window.location.href = "<?php echo $this->Html->url(array('controller'=>'PatientForms','action'=>'power_note'))?>"
					+'/'+noteIDPreview+'/'+'<?php echo $patientId?>'+'/'+'?Preview=preview';
		}
		$('#residentCheck').click(function(){
			
			if('<?php echo $noteId?>'==''){	
				var noteID=	$('#subjectNoteId').val();
			}else{
				var noteID=	'<?php echo $noteId?>';
			}
			var chk=confirm('Are you sure that note is completed?');
			if(chk==true){ 	
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "UpdateResident","admin" => false)); ?>";
				$.ajax({
						  type: "POST",
						  url: ajaxUrl+'/'+'<?php echo $patientId ?>'+'/'+noteID,
						  //data:{"expression" : formData},
						  beforeSend:function(){
						  	// this is where we append a loading image
						  	$('#busy-indicator').show('fast');
						  },
						  success: function(data){
						  $('#busy-indicator').hide('slow');

					  }
				});		
						
			}else{ 
				return false;
			} 
			});
			$('#problemLabRad').change(function(){
				var currentId =$.trim($('#problemLabRad').val());
			//	alert(currentId);
				if(currentId=="0")
				{
					
					var mainTextboxData= $('.mainTextboxData').attr('id');	
					$('#planBtn').val('Update');
					 $('#planShow').val(mainTextboxData);
					 $('#oneOneDiagosis').val(currentId);
					 return false;
				}
				else
				{
				   var showData=$('.'+currentId).attr('id');
				 
				   $('#planBtn').val('Save for this Diagnosis');
				   $('#planShow').val(showData);
				   $('#oneOneDiagosis').val(currentId);
				}
				});


				$('#send').click(function(){				
					$
					.fancybox({
						'width' : '80%',
						'height' : '80%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Ccda", "action" => "referral_note")); ?>"+'/'+<?php echo $patientId?>
						

					});
					 $(document).scrollTop(0);
				});
					$('#smartphrases').click(function(){
					 var noteIDPreview=	'<?php echo trim($noteId)?>'; 
						if((noteIDPreview) == ''){
							var noteIDPreview=$('#subjectNoteId').val();
						}
						window.location.href = "<?php echo $this->Html->url(array('controller'=>'SmartPhrases','action'=>'admin_index','admin'=>true))?>"
							+'/'+'?patientId=<?php echo $patientId?>&noteId='+noteIDPreview;
				});
//***********************************To save Chief Complaints***************************************************************************************************************
			 		var Pos="";
			 		$('#cc').keyup(function (){
				 		var CcCopyText=$('#cc').val();
			 			$('#powerCC').html(CcCopyText);
				 		});
			 		$('#subShow').keyup(function (){ // overLap
			 			var intElemOffsetHeight = $('#mainProgressNoteId').position();
			 			var distanceHPI = $('#overLapHeading').position();
			 			var topDisplay=(intElemOffsetHeight.top);
			 			var distance=topDisplay-30;
			 			var distanceHPI1=topDisplay-60;
			 			//$('#maincontainer').hide();
			 			$('#maincontainer').css({"opacity":"0.2","background":"#666666"});	
			 			//$('#maincontainer').css({"background":"#666666"});	
				 		var HpiCopyText=$('#subShow').val();
				 		$('#overLap').show();	
				 		$('#overLapHeading').show();
				 		$('#overLapHPINew').show();

				 		$('#overLapHeading').css({"margin-top":distanceHPI1});	
				 		$('#overLapHeading').html('Subjective');

				 		$('#overLapHPINew').css({"margin-top":distance});
						$('#overLapHPINew').html('<b>History of Presenting Illness</b>');

				 		$('#overLap').css({"margin-top":topDisplay});
				 		$('#overLap').html(HpiCopyText);

			 			$('#powerHPI').html(HpiCopyText);
				 		});
			 		 $('#subShow').blur(function (){
			 			$('#maincontainer').css({"opacity":"8.0","background":""});	
			 			$('#overLapHeading').hide();
			 			$('#overLap').hide();
			 			$('#overLapHPINew').hide();
				 		});
			 		//****************************************************************************************************
			 		$('#subShowRos').mousemove(function (e){
//Pos=(e.pageY)-400;
				 		//alert(Pos);
			 		});
						$('#subShowRos').keyup(function (e){
			 			var intElemOffsetHeight = $('#mainProgressNoteId').offset().top;
			 			var topDisplay=(intElemOffsetHeight.top)-200;
			 			var distance=Pos-30;
			 			var distanceROS1=Pos-60;
			 			$('#maincontainer').css({"opacity":"0.2","background":"#666666"});	
			 			var RosCopyText=$('#subShowRos').val();
			 			$('#overLap').css({"margin-top":Pos});	
			 			$('#overLap').show();	
			 			$('#overLapHeading').show();
			 			$('#overLapHPINew').show();
			 			
			 			$('#overLapHPINew').css({"margin-top":distance});
						$('#overLapHPINew').html('<b>Review Of System</b>');
				 		$('#overLapHeading').css({"margin-top":distanceROS1});	
				 		$('#overLapHeading').html('Subjective');
				 		$('#overLap').css({"margin-top":topDisplay});
				 		$('#overLap').html(RosCopyText);
			 			$('#powerROS').html(RosCopyText);
				 		});
						$('#subShowRos').blur(function (){
				 			$('#maincontainer').css({"opacity":"8.0","background":""});	
				 			$('#overLapHeading').hide();
				 			$('#overLap').hide();
				 			$('#overLapHPINew').hide();
					 		});
				 	//**********************************************************************************************************************************************
				$('#objectShow').mousemove(function (e){
				 		// Pos=(e.pageY)-400;
				 		//alert(Pos);
			 		});
			 		$('#objectShow').keyup(function (){
			 			var distance=Pos-30;
			 			var distanceROS1=Pos-60;
			 			$('#overLapHPINew').show();
			 			$('#maincontainer').css({"opacity":"0.2","background":"#666666"});	
				 		var ObjectCopyText=$('#objectShow').val();
				 		$('#overLap').css({"margin-top":Pos});	
			 			$('#overLap').show();	
			 			$('#overLapHeading').show();
				 		$('#overLapHeading').css({"margin-top":distanceROS1});	
				 		$('#overLapHeading').html('Objective');
				 		$('#overLap').css({"margin-top":Pos});
				 		$('#overLap').html(ObjectCopyText);
				 		$('#overLapHPINew').css({"margin-top":distance});
						$('#overLapHPINew').html('<b>Physical Examination</b>');
			 			$('#powerOBJECT').html(ObjectCopyText);
				 	});
			 		$('#objectShow').blur(function (){
			 			$('#maincontainer').css({"opacity":"8.0","background":""});	
			 			$('#overLapHeading').hide();
			 			$('#overLap').hide();
			 			$('#overLapHPINew').hide();
				 		});
				 	//****************************************************************************************************************************************************
			 			$('#AssesShow').mousemove(function (e){
//Pos=(e.pageY)-400;
				 		//alert(Pos);
			 		});
			 		$('#AssesShow').keyup(function (){
			 			var distance=Pos-30;
			 			$('#maincontainer').css({"opacity":"0.2","background":"#666666"});
				 		var AssessCopyText=$('#AssesShow').val();
				 		$('#overLap').css({"margin-top":Pos});	
			 			$('#overLap').show();	
			 			$('#overLapHeading').show();
				 		$('#overLapHeading').css({"margin-top":distance});	
				 		$('#overLapHeading').html('Assessment');
				 		$('#overLap').css({"margin-top":Pos});
				 		$('#overLap').html(AssessCopyText)
			 			$('#powerAssess').html(AssessCopyText);
				 	});
			 		$('#AssesShow').blur(function (){
			 			$('#maincontainer').css({"opacity":"8.0","background":""});	
			 			$('#overLapHeading').hide();
			 			$('#overLap').hide();
				 		});
			 		//*********************************************************************************************************************************************************
			 		$('#planShow').mousemove(function (e){
				 		// Pos=(e.pageY)-400;
				 		//alert(Pos);
			 		});
			 		$('#planShow').keyup(function (){
				 			if($('#problemLabRad').val()=='0'){
					 			
				 			var distance=Pos-30;
			 				$('#maincontainer').css({"opacity":"0.2","background":"#666666"});
					 		var PlanCopyText=$('#planShow').val();
					 		$('#overLap').css({"margin-top":Pos});	
				 			$('#overLap').show();	
				 			$('#overLapHeading').show();
					 		$('#overLapHeading').css({"margin-top":distance});	
					 		$('#overLapHeading').html('Plan');
					 		$('#overLap').css({"margin-top":Pos});
				 			$('#overLap').html(PlanCopyText)
			 				$('#powerPlan').html(PlanCopyText);
				 		}
				 	});
			 		$('#planShow').blur(function (){
			 			$('#maincontainer').css({"opacity":"8.0","background":""});	
			 			$('#overLapHeading').hide();
			 			$('#overLap').hide();
				 		});
			 		//*************************************************************************************************************************************************************
			 		 
			 		var checkValCC='<?php echo $checkccVal ?>';
			 		$('#cc').change(function(){
				 		checkValCC=2;
					});

					$('#cc').blur(function(){
						if($('#cc').val()=='' || checkValCC==1 || checkValCC==0 ){
							return false;
						}else{
							checkValCC='';
							saveSoap('cc');
						}
					});
					 function saveSoapChiefComplaints(){
						 var checksaveUpadte='<?php echo $checkccVal ?>';
						 if(checksaveUpadte=='0'){
							 var msg='Chief Complaints saved successfully';
						 }
						 else{
							 var msg='Chief Complaints updated successfully';
						 }
								var formData = $('#cc_id').serialize();
								var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "saveSoapChiefComplaints","admin" => false)); ?>";
								$.ajax({
						 			  type: "POST",
						 			  url: ajaxUrl,
						 			  data: formData,
						 			  beforeSend:function(){
						 			   loading('wrapper','class'); 
						 			  },
						 			  success: function(data){
						 				var noteid=parseInt(data);
										
										 // $('#busy-indicator').hide('slow');
										  onCompleteRequest('wrapper','class');  
										  $('#familyid').val(noteid);
										  $('#ccid').val(noteid); 
										  $('#subjectNoteId').val(noteid); 
										  $('#assessmentNoteId').val(noteid); 
										  $('#objectiveNoteId').val(noteid); 
										  $('#planNoteId').val(noteid); 
										  $('#signNoteId').val(noteid);
										  $('#flashMessage').html(msg);
										  $('#flashMessage').show();
										  $('#residentCheck').attr('disabled',false);
										  //getPowerNote(noteid);
									  }
								});
					 }

					 $("#right-arrow").click(function(){
						 $('#mainProgressNoteId').show();
						 var $obj     = $('#mainProgressNoteId'),
						 ani_dist = 500;  
						 $("#showPowerNote").show();
						 $("#hidePowerNote").hide();
						 //animate first easing
						 $obj.stop().animate({ width : "95%" }, 500, 'easeOutCirc', function () {
							 $("#powerNote").css("width",0);
							 $("#powerNote").hide();
						 });
					});

					 $("#left-arrow").click(function(){
						 $('#powerNote').show();
						/* $('#mainProgressNoteId').show();
						 $("#mainProgressNoteId").css({"width":"50%"});	
						 $("#powerNote").css({"width":"50%"});
						 $("#hidePowerNote").show();	
						 $("#showPowerNote").hide();*/
						 var $obj     = $('#powerNote'),
						 ani_dist = 500; 
						 $("#showPowerNote").hide();
						 $("#hidePowerNote").show();
						//animate first easing
						 $obj.stop().animate({ width : "50%" }, 500, 'easeOutCirc', function () {
							 $("#mainProgressNoteId").css({"width":"50%"});	
										      
						 });
					});
					 function previewOrderSet(){
						 var noteIDPreview=	'<?php echo trim($noteId)?>'; 
							if((noteIDPreview) == ''){
								var noteIDPreview=$('#subjectNoteId').val();
							}
							if(noteIDPreview==''){
							alert('Please fill Subjective to proceed');
							return false;
							}
							window.location.href = "<?php echo $this->Html->url(array('controller'=>'MultipleOrderSets','action'=>'orders'))?>"
								+'/'+'<?php echo $patientId?>'+'/'+'<?php echo $patientId?>'+'/'+'?Preview=preview';
					}
					 
	function cdsCall(){ 
		$
		.fancybox({
			'width' : '50%',
			'height' : '50%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "cdsCall")); ?>"+'/'+ <?php echo $patientId;?>+'/'+<?php echo $noteId;?>
		});
}
	function ScreeningTool(){
		$
		.fancybox({
			'width' : '50%',
			'height' : '50%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Screenings", "action" => "index")); ?>"+'/'+ <?php echo $patientId;?>
		});
	}
					 
				 

//*****************************************************EOD******************************************************************************************
//Function to generate CCDaA and then redirect to view ccda
$('#viewCCDA').click(function(){
						 	$.ajax({
					 			  type : "POST",
					 			 url: "<?php  echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "generateCcda",$patientId,$getElement['Patient']['patient_id'],'soapNote','appt'=>$_SESSION['apptDoc'], "admin" => false)); ?>",
					 			  context: document.body,
					 			
					 			  beforeSend:function(){
					 				 loading('wrapper','class');					 				 
					 			  }, 	  		  
					 			  success: function(data){
						 			 onCompleteRequest('rightTopBg','class');
						 				window.location.href="<?php echo $this->Html->url(array("controller" => "ccda", "action" => "view_consolidate",$patientId));?>";
									
					 			  }
					 		});
					 	});
 //***********************************************Search PrgBtn *************************************************************************************************//
 $('#PrgBtn').click(function(){
var sreachKey=$('#ProgressNoteContain').val();
	if(sreachKey!=''){
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "PatientForms", "action" => "power_note",'header'=>'show',"admin" => false)); ?>";
		 $.ajax({
	       	beforeSend : function() {
	       		 loading('powerNote','id');
	       	},
	       	type: 'POST',
	       	url: ajaxUrl+'/'+<?php echo $noteId?>+'/'+<?php echo $patientId?>+'/'+'?sreachKey='+sreachKey,
	       	//data: formData,
	       	dataType: 'html',
	       	success: function(data){
	       		onCompleteRequest('powerNote','id'); 
	       	if(data!=''){
	       		$("#powerNote").html(data);
	       	}
	       },
	
		 });
	}
});
 //**********************************************************************************************************************************************

		$('#deleteDiaInfo').click(function(){
			var patientId='<?php echo $patientID?>';
			$.fancybox({
				'width' : '60%',
				'height' : '60%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "deleteDiaInfo")); ?>"+'/'+'<?php echo $patientId?>',

			});
		});

		function editDoc(patientID,noteID,docID,widgetId){
			window.location.href = "<?php echo $this->Html->url(array('controller'=>'PatientDocuments','action'=>'add')); ?>"
			+'/'+patientID+"/"+'null'+'/'+'soap'+'/'+noteID+'?widgetId='+widgetId+"&docID="+docID;
		}
		function deleteDoc(docID){
			var r =confirm('Are you sure you want to Delete this record ?');
			if(r==true){
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "PatientDocuments", "action" => "deleteDocument",'header'=>'show',"admin" => false)); ?>";
				 $.ajax({
			       	beforeSend : function() {
			       		$('#busy-indicator').show('fast');
			       	},
			       	type: 'POST',
			       	url: ajaxUrl+'/'+docID,
			       	//data: formData,
			       	dataType: 'html',
			       	success: function(data){
			       		if($.trim(data)=='save'){
			       			$('#'+docID+"_tr").remove();
			       			$('#busy-indicator').hide('fast');
			       		}else{
			       			$('#busy-indicator').hide('fast');
			       		}
			       		
			       },
			
				 });
			}else{
				return false;
			}
		}

		/* for Are U sure to leave the page*/
		var unsaved = false;

		$("#cc").keyup(function(){ //trigers change in all input fields including text type
		    $("#hidden_sure_cc").val('1');
		});
		$("#family_tit_bit").keyup(function(){ //trigers change in all input fields including text type
		    $("#hidden_sure_family_tit_bit").val('1');
		});
		$("#flagEventId").keyup(function(){ //trigers change in all input fields including text type
		    $("#hidden_sure_flag_event").val('1');
		});


		

$("#subShow").keyup(function(){ //trigers change in all input fields including text type
    $("#hidden_subjectNoteId").val('1');
});

$("#subShowRos").keyup(function(){ //trigers change in all input fields including text type
    $("#hidden_subjectNoteId").val('1');
});

$("#objectShow").keyup(function(){ //trigers change in all input fields including text type
    $("#hidden_objectiveNoteId").val('1');
});

$("#AssesShow").keyup(function(){ //trigers change in all input fields including text type
    $("#hidden_assessmentNoteId").val('1');
});

$("#planShow").keyup(function(){ //trigers change in all input fields including text type
    $("#hidden_planId").val('1');
});

$("#activity_box").keyup(function(){ //trigers change in all input fields including text type
    $("#hidden_activity_box_Id").val('1');
});


function unloadPage(){ 

	if($("#hidden_sure_cc").val() == 1 ){
        return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
    }
	
	if($("#hidden_sure_family_tit_bit").val() == 1 ){
        return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
    }
	if($("#hidden_sure_flag_event").val() == 1 ){
        return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
    }
    
	 
    if($("#hidden_subjectNoteId").val() == 1 ){
        return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
    }
    if($("#hidden_objectiveNoteId").val() == 1){
    	 return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
    }
     if($("#hidden_assessmentNoteId").val() == 1){
    	 return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
    }
     if($("#hidden_planId").val() == 1){
    	 return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
    }
     if($("#hidden_activity_box_Id").val() == 1){
    	 return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
    }
    
}

window.onbeforeunload = unloadPage;

$('.newCropSync').click(function(){
var currentPersonID=$(this).attr('id');
var currentPatientID=$(this).attr('patientId');
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "newCropSync", "admin" => false)); ?>"+'/'+currentPersonID+'/'+currentPatientID,
		  context: document.body,
		  success: function(data){ 
			$("#busy-indicator").hide();
			alert('Sync successfully');
			//inlineMsg('#syncMsg','Sync successfully',10);
		  },
		  beforeSend:function(){
				$("#busy-indicator").show();
			  },		  
	});
});

//For activity Box
$(document).ready(function(){
    $('.activityLink').on('click', function(event) {        
         $('#show_activity_box').toggle('show');
    });
});
function addDiagnosisDetails(){
}	
$('#assessmentTab').click(function(){
	getproblem();

});
$('#tab5').click(function(){
	var patientId='<?php echo $patientId?>';
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Radiologies", "action" => "ajax_uploadDocument","admin" => false)); ?>";
	 $.ajax({
        	type: 'POST',
        	url: ajaxUrl+'/'+patientId,
        	dataType: 'html',
        	beforeSend : function() {
				        $('#busy-indicator').show('fast');
				    },
        	success: function(data){
	        	if(data!=''){
	       			 $('#loadDocs').html(data);
	       			$('#busy-indicator').hide('fast');
	        	}
        	},
        	error: function(message){
	     	},
		});
});

$('#tab6').click(function(){
	var patientId='<?php echo $patientId?>';
	var noteID='<?php echo $noteId?>';
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "epen","admin" => false)); ?>";
	 $.ajax({
        	type: 'POST',
        	url: ajaxUrl+'/'+patientId+'/'+noteID,
        	dataType: 'html',
        	beforeSend : function() {
				        $('#busy-indicator').show('fast');
				    },
        	success: function(data){
	        	if(data!=''){
	       			 $('#loadepen').html(data);
	       			$('#busy-indicator').hide('fast');
	        	}
        	},
        	error: function(message){
	     	},
		});
});

$('#tab7').click(function(){
	var patientId='<?php echo $patientId?>';
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Anesthesias", "action" => "anae","admin" => false)); ?>";
	$.ajax({
    	type: 'POST',
    	url: ajaxUrl+'/'+patientId,
    	dataType: 'html',
    	beforeSend : function() {
			        $('#busy-indicator').show('fast');
			    },
    	success: function(data){
        	if(data!=''){
       			 $('#AnaNotes').html(data);
       			$('#busy-indicator').hide('fast');
        	}
    	},
    	error: function(message){
     	},
	});
});
$('#tab8').click(function(){
	var patientId='<?php echo $patientId?>';
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "OptAppointments", "action" => "operative_notes","admin" => false)); ?>";
	$.ajax({
    	type: 'POST',
    	url: ajaxUrl+'/'+patientId,
    	dataType: 'html',
    	beforeSend : function() {
			        $('#busy-indicator').show('fast');
			    },
    	success: function(data){
        	if(data!=''){
       			$('#optNotes').html(data);
       			$('#busy-indicator').hide('fast');
        	}
    	},
    	error: function(message){
     	},
	});
});

$('#planTab').click(function(){
	getmedication();
	getRad();
	getLab();
	getAllergy();
});
function getproblem() {
	var patientId='<?php echo $patientId?>';
	var personID='<?php echo $getElement['Patient']['person_id']?>';
	var noteId='<?php echo $noteId?>';
		if(noteId==''){
			noteId= $('#subjectNoteId').val(); 
		}
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getDiagnosis","admin" => false)); ?>";
	 $.ajax({
        	beforeSend : function() {
        		$("#Assessment").html("<table><tr><td>Loading Assessment Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
        	},
        	type: 'POST',
        	url: ajaxUrl+'/'+patientId+'/'+noteId+'/'+'?personId=<?php echo $getElement['Patient']['person_id']?>',
        	dataType: 'html',
        	beforeSend : function() {
				        //$('#busy-indicator').show('fast');
				    },
        	success: function(data){
		        	$("#Assessment").html('Assessment');
	        	if(data!=''){
	       			 $('#getAssessment').html(data);
	       			// $('#busy-indicator').hide('fast');
	        	}
        	},
        	error: function(message){
	     	},
		});
}
function getRad() {
 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getRad",$patientId,$this->params->named['appt'],"admin" => false)); ?>";
 $.ajax({
    	type: 'POST',
    	url: ajaxUrl,
    	dataType: 'html',
    	success: function(data){
        	if(data!=''){
       			 $('#loadRad').html(data);
        	}
    	},
    	error: function(message){	
     	},
    
	});
}

function getLab() {
	var noteId='<?php echo $noteId?>';
	if(noteId==''){
		noteId= $('#subjectNoteId').val(); 
	}
	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getLab",$patientId,"admin" => false)); ?>"+'/'+noteId+'?apptId=<?php echo $this->params->named["appt"]?>';
	 $.ajax({
        	type: 'POST',
        	url: ajaxUrl,
        	dataType: 'html',
        	success: function(data){
	        	if(data!=''){
	       			 $('#loadLab').html(data);
	        	}
        	},
        	error:function(){
        	}
		});
}

function getmedication() {
	var noteId='<?php echo $noteId?>';
	if(noteId==''){
		noteId= $('#subjectNoteId').val(); 
	}
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "ajaxTreatmentSheet",$patientId,"admin" => false)); ?>";
	$.ajax({
	beforeSend : function() {

	},
	type: 'POST',
	url: ajaxUrl,
	dataType: 'html',
	success: function(data){
		$("#TreatmentAdvised").html('TreatmentAdvised');
		if(data!=''){
			$('#MedicationData').html(data);
		}
	},
	error:function(data){},
	});
}

function getAllergy() {
	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getAllergy",$patientId,"admin" => false)); ?>"+'?personId=<?php echo $getElement['Patient']['person_id']?>';;
	 $.ajax({
        	type: 'POST',
        	url: ajaxUrl,
        	dataType: 'html',
        	success: function(data){
	        	if(data!=''){
	       			 $('#showAllergy').html(data);
	       		}
        	},
        	error:function(){}
		});
}
function getPatientCare() {
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getPatientCare",
	 	$patientId,$noteId,$_SESSION['apptDoc'])); ?>";
	 $.ajax({
        	beforeSend : function() {
        		
        	},
        	type: 'POST',
        	url: ajaxUrl,
        	//data: formData,
        	dataType: 'html',
        	success: function(data){
        	if(data!=''){
       			 $('#loadPcare').html(data);
        	}
                        
        	
        },
		});
}
			$(document).ready(function(){
                  //script for open generic search by Swapnil G.Sharma
                  $(".showGeneric").click(function(){
                      var fieldNo = $(this).attr("fieldNo");
                  });		
              });

              function showGeneric(fieldNo){
               var genericName = $("#genericName"+fieldNo).val();
                  	var ajaxUrl = '<?php echo $this->Html->url(array("controller"=>"Pharmacy","action" => "generic_search_new", 'inventory' => true)); ?>'+"/"+fieldNo+"/"+genericName;
		            $.ajax({
		                beforeSend : function() {},
		                type: 'POST',
		                url: ajaxUrl,
		                dataType: 'html',
		                success: function(data){
		                    $("#TreatmentAdvised").html('TreatmentAdvised');
		                    if(data!=''){
		                        $('#genericCode').html(data);
		                    }
		                },
		                error:function(data){},
		            });
              }
              /*Template serach and load functions*/

              $(document).on('click',".deleteDoc",function(){
				currentID=$(this).attr('id');
				var msg = confirm("Do you really want to delete this record?") ;
				
				if(msg){
					$.ajax({
						  type : "POST",
						  //data: formData,
						  url: "<?php echo $this->Html->url(array("controller" => "Radiologies", "action" => "deleteDocument", "admin" => false)); ?>"+"/"+currentID,
						  context: document.body,
						  success: function(data){ 	
							  $("#busy-indicator").hide();	
							  $('#ImgId_'+currentID).hide();
							  load_document_page();		  
						  },
						  beforeSend:function(){
						  	$("#busy-indicator").show();
						  },		  
					});
				}else{
					return false;
				}
			});

              function load_document_page(){
					var patientId = "<?php echo $this->params->pass['0']?>";
					var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Radiologies", "action" => "ajax_uploadDocument","admin" => false)); ?>";
					 $.ajax({
				        	type: 'POST',
				        	url: ajaxUrl+'/'+patientId,
				        	dataType: 'html',
				        	beforeSend : function() {
								        $('#busy-indicator').show('fast');
								    },
				        	success: function(data){
					        	if(data!=''){
					       			 $('#loadDocs').html(data);
					       			$('#busy-indicator').hide('fast');
					        	}
				        	},
				        	error: function(message){
					     	},
						});
				}

	
</script>



