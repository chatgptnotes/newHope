<?php  App::uses('GeneralHelper', 'View/Helper');
?>

<style>
.container {
	/*border: 1px solid #4C5E64;*/
	padding-left: 5px;
	
	padding-bottom:20px;
}

/*.title {
	background: none repeat scroll 0 0 #4C5E64;
}*/
.comman {
	/*margin-top: 10px;*/
	/*margin-left: 10px;*/
	border:1px solid #000; 
	margin: 10px 0 0 8px;
	width: 97%;
	clear:both;
	min-height:120px;
	float:left;
}

li {
	list-style: none;
	margin: 10px 0 0;
	font-size: 13px;
}

* {
	margin: 0px;
	padding: 0px;
}

.cc_ul {
	height: 25px;
}

.cc_ul li {
	float: left;
	list-style: none;
	margin-left: 20px;
}

.cc_l1 {
	background: #363F42;
}

.health_stats { /*margin-left: 20px;*/
	
}

.health_stats ul { /*margin-left: 20px;*/
	border: 1px solid #4C5E64;
	border-right: none;
	margin-bottom: 10px;
	margin-top: 10px;
}

.health_stats ul li {
	margin-bottom: 5px;
	margin-top: 5px;
}

.ros_li1 {
	float: left;
	margin-left: 10px;
	width: 170px;
}

.ros_li {
	float: left;
	margin-left: 10px;
}

.comman>h3 {
	background: none repeat scroll 0 0 #D2EBF2;
	border-bottom: 2px solid #000 !important;
	color: #000 !important;
	text-decoration:none !important;
	font-size: 13px;
	padding: 5px 7px;
	border: 1px solid #000;
}
tdLabel{ padding-left:0px !important;}
.box{ float:left; width:100%; margin:0 auto; padding:0px; border:1px solid #4c5e64; min-height:85px;}
.box h3{ width:99%; float:left; margin:0px; padding:0px;background:#D2EBF2;color: #31859C !important;
font-size: 13px;padding: 5px 7px; border-bottom:1px solid #4c5e64;}
.inner_box{width:100% !important;margin:0px;min-height:85px;}
.inner_box h2{color: #31859c !important; font-size:13px;padding: 10px 0 10px 11px; float:left; cleasr:left;}
.innerbox_txt{width:98%; float:left; border-bottom:1px dashed #000; padding-bottom:10px;}
.innerbox_txt p{margin:0px; padding:0px; float:left; width:100%;padding: 0 0 10px 10px;}
#overLap{
	z-index: 9999;
	background-color:#CCC;
	position:absolute;
	width:48%;
	height:250px;
	border:1px solid #c8c8c8;
}
#overLapHeading{
	z-index: 9999;
	/* background-color:red;*/
	position:absolute;
	background: none repeat scroll 0 0 #D2EBF2;
	border-bottom: 2px solid #000 !important;
	color: #000 !important;
	text-decoration:none !important;
	font-size: 13px;
	padding: 5px 7px;
	border: 1px solid #000;
	width:47%;
}
#overLapHPINew{
	z-index: 9999;
	background-color:#CCC;
	position:absolute;
	width:48%;
	height:250px;
	border:1px solid #c8c8c8;
	}
.new{ float:left; width:100%; clear:both;}
.new ul{ margin:0px; padding:0px; float:left;}
.new ul li{margin:0px; padding:0px; float:left;clear:both; background:url('<?php echo $this->webroot."img/icons/stripbar1.png"; ?>') repeat-y; list-style:none; margin-bottom:5px; word-break:break-all;}
.new1 ul li{margin:0px; padding:0px; float:left;clear:both; background:url('<?php echo $this->webroot."img/icons/solidbarnew.png"; ?>') repeat-y; list-style:none; margin-bottom:5px;}
.text{ float:left; padding:0 15px; margin:0px; clear:both; width:95%;word-break:break-all;}
.curr_med{font-size:15px;color:#31859c;padding: 0 0 0 10px; float:left}
.med_align{ float:left; clear:both;}
.med_align li{ float:left; clear:both;}
.align li{float:left; clear:both;}
.inner_box ul li{word-break:break-all !important;}
</style>
 
<?php //echo $this->element('patient_information');?>

<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#").validationEngine();
	});
 
 </script>
  <div class="clr ht5"></div>
 <div class="clr ht5" style='float:right;margin: 0 14px 0 0;'><?php echo $this->Html->link('Back',array('controller'=>'Appointments','action'=>'appointments_management'),array('name'=>'Back','value'=>'Back', 'class'=>"blueBtn"));?>
</div>
<?php if($this->request->params['named']['header']!='show'){
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
	echo $this->Html->script(array('jquery.fancybox-1.3.4'));
	echo $this->element('patient_information');}
	
	/* if($type='master'){
		echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
		echo $this->Html->script(array('jquery.fancybox-1.3.4'));
		echo $this->element('patient_information');} */
	?>
<div class="clr ht5"></div>
<?php echo $this->Form->create('PatientDocument',array('type' => 'file'));?>
<div id="overLapHeading" style="display:none; word-wrap: break-word;"></div>
<div id="overLapHPINew" style="display:none; word-wrap: break-word;"></div>
<div id="overLap" style="display:none; word-wrap: break-word;"></div>
<div class="container" id="maincontainer">
<!-- subjective start -->
<div class="comman">
		<h3>
			<font style=""><?php echo ("Subjective")?>
			</font>
		</h3>
		<ul class="tdLabel">
			<?php if(!empty($note['Note']['subject'])){?>
			<li style="padding-bottom:10px;"></li>
			<?php }else{?>
			<li style="padding-bottom:10px;"></li>
			<?php }?>
		</ul>
		<div class="inner_box">
			<h2>
				<font style="text-decoration: underline"><?php  echo ("Chief Complaint ")?>
				</font>
			</h2>
			<?php  if(!empty($cc['Diagnosis']['complaints'])) { 
					if($note['Note']['sign_note']=='0'){
						$class='new';
						}else{ 
						$class='new1';
			     }}?>
			  <div class="<?php echo $class?>">
				<ul class="tdLabel innerbox_txt" style="padding-right:0px !important;">
	
					<li class="">
					<?php 
					if(!empty($cc['Diagnosis']['complaints'])) {
						$cchief=$cc['Diagnosis']['complaints'];
					}else{
						$cchief="No record found.";
						}?>
				
<li style="padding-bottom:10px;padding-left:20px;" id="powerCC">
  <div class="text">
<?php echo str_ireplace($sreachKey,'<font color="green">' .$sreachKey .'</font>',$cchief); ?>
</div>
					</li>
				</ul>
			</div>
		</div>
		<?php if(!empty($note['Note']['subject']) || !empty($HpiNew)) {
					if($note['Note']['sign_note']=='0'){
						$classHpi='new';
						}else{ 
						$classHpi='new1';
			     }}else{
			//	$NRF="No record found";
				}?>
		<div  id="hpiStrip" class="inner_box <?php  echo $classHpi  ?>">
		<h2>
			<font style="text-decoration: underline"><?php echo ("History of Present Illness ")?>
			</font>
		</h2>
		<ul class="tdLabel innerbox_txt" style="padding-right:0px !important;" >
			<?php //if(trim($note['Note']['subject']) != ''){?>
			<li class="" id="powerHPI" style="padding-bottom:10px;padding-left:20px;">
			 <div class="text" style="word-wrap: break-word;"> <?php echo str_ireplace($sreachKey,'<font color="green">' .$sreachKey .'</font>',$note['Note']['subject']); ?></div></li>
			 <?php //}?>
				<li class="" id=""></li>
							<?php
								/** BOF HPI & ROS sentence */
								$hpiRosSentence = GeneralHelper::createHpiSentence($hpiMasterData,$hpiResultOther,$rosResultOther);
								$HpiNew = $hpiRosSentence['HpiSentence']; 
							/** EOF HPI & ROS sentence */// EOF foreach
						
						//EOF outer if
							//	$HpiNew = (trim($HpiNew) != '') ? $HpiNew : 'No record found';
							?>
			<li class="" id="powerHPI" style="padding-bottom:10px;padding-left:20px;"> <div class="text"><?php echo $NRF.$HpiNew;?></div></li>
			</ul>
			
	</div>
	<?php /** BOF HPI & ROS sentence */	
						//$hpiRosSentence = GeneralHelper::createHpiSentence($hpiMasterData,$hpiResultOther,$rosResultOther);
						$RosNew = trim($hpiRosSentence['RosSentence']); 
	      /** EOF HPI & ROS sentence *///	
				if(!empty($RosNew)) { 
					if($note['Note']['sign_note']=='0'){
						$classRos='new';
						}else{ 
						$classRos='new1';
			     }}?>
		<div class="inner_box <?php echo $classRos?>">
		<h2>
			<font style="text-decoration: underline"><?php echo ("Review Of Systems ")?>
			</font>
		</h2>			  
			<ul class="tdLabel" style="clear:both;">
				<li id="powerROS" style="padding-bottom:10px;padding-left:20px;"><div class="text" style="word-wrap: break-word;"><?php 
				echo str_ireplace($sreachKey,'<font color="green">' .$sreachKey .'</font>',$note['Note']['ros']);?></div></li>
				<li style="padding-bottom:10px;padding-left:20px;"><div class="text"><?php 
 					if(empty($RosNew)) { 
                    // $RosNew="No record found";
                   }echo $RosNew;?></div>
				</li>
			</ul>
			</div>
</div>
	<!-- subjective End -->
		<!-- Objective  End -->
<div class="comman">
		<h3>
			<font><?php echo ("Objective")?> </font>
		</h3>
		<?php if(!empty($note['Note']['object'])) { 
					if($note['Note']['sign_note']=='0'){
						$classObj='new';
						}else{ 
						$classObj='new1';
			     }}?>
		<div class=" inner_box <?php echo $classObj?> innerbox_txt" style="border-bottom:none !important;">  
			<ul class="tdLabel">
				<li style="padding-bottom:10px;padding-left:20px;" id="powerOBJECT"><div class="text">
					<?php 
					echo str_ireplace($sreachKey,'<font color="green">' .$sreachKey .'</font>',$note['Note']['object']); ?></div>
				</li>
			</ul>
			</div>
			<?php /* if(!empty($note['Note']['object'])) {  */
					if($note['Note']['sign_note']=='0'){
						$classVitals='new';
						}else{ 
						$classVitals='new1';
			     }/* } */?>
		
		
		
				<?php if(!empty($noteVitals['BmiResult']['temperature']) || !empty($noteVitals['BmiResult']['temperature1']) || !empty($noteVitals['BmiResult']['temperature2'])) { 
					?>
					<div class="inner_box <?php echo $classVitals?> " style=" min-height:20px !important;">
                    <h2>
			<font style="text-decoration: underline"><?php  echo ("Vitals ")?>
			</font>
		</h2>
					<ul class="tdLabel innerbox_txt" style="border-bottom:none;">
					<?php /* for temp  */
							if($noteVitals['BmiResult']['temperature2']){
								$temperature = $noteVitals['BmiResult']['temperature2'];
								$myoption = $noteVitals['BmiResult']['myoption2'];
									
							}else if(($noteVitals['BmiResult']['temperature1']) && (!$noteVitals['BmiResult']['temperature2'])){
								$temperature = $noteVitals['BmiResult']['temperature1'];
								$myoption = $noteVitals['BmiResult']['myoption1'];
							}else{
								$temperature = $noteVitals['BmiResult']['temperature'];
								$myoption = $noteVitals['BmiResult']['myoption'];
							}?>
						<?php if(!empty($temperature)){?>
					<li style="padding-bottom:10px;padding-left:20px;"><div class="text"><?php echo "Temperature: ".$temperature; ?><?php echo " ";?><?php echo $myoption;?>
					</div></li><?php }?>
					</ul>
				</div>
				<?php }?>
				<?php if(!empty($noteVitals["BmiBpResult"]["systolic"]) || !empty($noteVitals["BmiBpResult"]["systolic1"]) || !empty($noteVitals["BmiBpResult"]["systolic2"]) ) { ?>
		<div class="inner_box <?php echo $classVitals?>" style=" min-height:20px !important;">
			<ul class="tdLabel innerbox_txt" style="border-bottom:none;">
				<?php 
				/* for bp  */
				if($noteVitals['BmiBpResult']['systolic2']){
					$BpSystolic = $noteVitals['BmiBpResult']['systolic2'];
					$BpDiastolic = $noteVitals['BmiBpResult']['diastolic2'];
						
				}else if(($noteVitals['BmiBpResult']['systolic1']) && (!$noteVitals['BmiBpResult']['systolic2'])){
					$BpSystolic = $noteVitals['BmiBpResult']['systolic1'];
					$BpDiastolic = $noteVitals['BmiBpResult']['diastolic1'];
				}else{
					$BpSystolic = $noteVitals['BmiBpResult']['systolic'];
					$BpDiastolic = $noteVitals['BmiBpResult']['diastolic'];
				}
				
				if(!empty($BpSystolic)){?>
				<li style="padding-bottom:10px;padding-left:20px;"><div class="text"><?php echo "Blood Pressure: ".$BpSystolic.'/'.$BpDiastolic.' mmHg'; ?>
				</div></li><?php }?>
			</ul>
		</div>
		<?php }?>
				<?php if(!empty($noteVitals["BmiBpResult"]["pulse_text"]) || !empty($noteVitals["BmiBpResult"]["pulse_text1"]) || !empty($noteVitals["BmiBpResult"]["pulse_text2"])) { ?>
		<div class="inner_box <?php echo $classVitals?>" style=" min-height:20px !important;">
			<ul class="tdLabel innerbox_txt" style="border-bottom:none;">
				<?php 
				/* for Pulse Rate */
				if($noteVitals['BmiBpResult']['pulse_text2']){
					$pulse_text = $noteVitals['BmiBpResult']['pulse_text2'];
					$pulse_volume = $noteVitals['BmiBpResult']['pulse_volume2'];
				
				}else if(($noteVitals['BmiBpResult']['pulse_text1']) && (!$noteVitals['BmiBpResult']['pulse_text2'])){
					$pulse_text = $noteVitals['BmiBpResult']['pulse_text1'];
					$pulse_volume = $noteVitals['BmiBpResult']['pulse_volume1'];
				}else{
					$pulse_text = $noteVitals['BmiBpResult']['pulse_text'];
					$pulse_volume = $noteVitals['BmiBpResult']['pulse_volume'];
				}
				
				if(!empty($pulse_text)){?>
				<li style="padding-bottom:10px;padding-left:20px;"><div class="text"><?php echo "Pulse Rate: ".$pulse_text.' '.$pulse_volume.''; ?>
				</div></li><?php }?>
			</ul>
		</div>
		<?php }?>
			<?php if((!empty($noteVitals["BmiResult"]["respiration"]))) { ?>
		<div class="inner_box <?php echo $classVitals?>" style=" min-height:20px !important;">
			<ul class="tdLabel innerbox_txt" style="border-bottom:none;">
			<?php 
			/* for respiration volume  */
			if($noteVitals['BmiResult']['respiration_volume']=='1'){
				$respirationVolume = 'Labored';
			}else if($noteVitals['BmiResult']['respiration_volume']=='2'){
				$respirationVolume = 'Unlabored';
			}else{
				$respirationVolume = '';
			}
			if(!empty($noteVitals['BmiResult']['respiration'])){?>
				<li style="padding-bottom:10px;padding-left:20px;"><div class="text"><?php echo "Respiration Rate: ".$noteVitals["BmiResult"]["respiration"].' '.$respirationVolume.''; ?>
				</div></li>
				<?php }?>
				</ul>
				</div>
			<?php }?>
			<!--  	
			<?php if(($noteVitals['0']['BmiResult']['systolic'])) { ?>
				<div class="inner_box <?php echo $classVitals?>" style=" min-height:20px !important;">
					<ul class="tdLabel innerbox_txt" style="border-bottom:none;">
						<?php if(!empty($noteVitals['0']['BmiBpResult']['systolic'])){?>
					<li style="padding-bottom:10px;padding-left:20px;"><div class="text"><?php echo "Blood Presure: ".$noteVitals['0']['BmiBpResult']['systolic']."/".$noteVitals['0']['BmiBpResult']['diastolic']."mmHg"; ?>
					</div></li>
					<?php }?>
					</ul>
				</div>
			<?php }?>
			<?php if(($noteVitals['0']['BmiResult']['spo'])) { ?>
				<div class="inner_box <?php echo $classVitals?>" style=" min-height:20px !important;">
					<ul class="tdLabel innerbox_txt" style="border-bottom:none;">
					<?php if(!empty($noteVitals['0']['BmiResult']['spo'])){?>
				<li style="padding-bottom:10px;padding-left:20px;"><div class="text"><?php echo "SPO2: ".$noteVitals['0']['BmiResult']['spo']." %"; ?>
				</div></li>
				<?php }?>
				</ul>
				</div>
			<?php }?>
			-->
		<?php if(!empty($hpiMasterData)){?>
					<?php if($note['Note']['sign_note']=='0'){
						$classPE='new';
						}else{ 
						$classPE='new1';
			     }?>
		<div class="inner_box <?php echo $classPE?>" style="border-top:1px dashed #000; float:left;">
		<div class="inner_box">
			<h2>
				<font style="text-decoration: underline"><?php echo ("Physical Examination ");?>
				</font>
			</h2>
			<ul class="tdLabel innerbox_txt" style="border-bottom:none;">
				<?php 
				/** BOF Physical Exam Sentence */
				$peNewData = GeneralHelper::createPhysicalExamSentence($hpiMasterData,$peResultOther,$pEButtonsOptionValue);/** function returns Physical Exam sentence */
				/** EOF Physical Exam Sentence */
					
						?>
					<li style="padding-bottom:10px;padding-left:20px;"><div class="text">
					<?php echo $peNewData;?></div></li>
					</ul>
					</div>
			
		</div>
		<?php }?>
      </div>
	<div class="comman">
		<h3>
			<font><?php echo ("Assessment")?>
			</font>
		</h3><?php if(!empty($assesment)) { 
					if($note['Note']['sign_note']=='0'){
						$classAssess='new';
						}else{ 
						$classAssess='new1';
			     }}?>
		<div class="<?php echo $classAssess?>">
		<ul class="tdLabel">
			<li class="" id="powerAssess" style="padding-bottom:10px;padding-left:20px;"><div class="text"><?php 
			echo str_ireplace($sreachKey,'<font color="green">' .$sreachKey .'</font>',$note['Note']['assis']);?></div></li>
			<?php   if(!empty($assesment)) {?>
			<li style="background:none !important;"><span style="padding-bottom: 10px;padding-left: 20px; float: left; color: rgb(83, 133, 156);"> <strong>Diagnosis</strong></span></li>
	<?php foreach($assesment as $assis){?>
		
		<div class="<?php echo $class?>"> 	<li style="padding-bottom:10px;padding-left:20px;" ><div class="text"><?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$assis); ?></div>
			</li></div>
			<?php } 
			}else{ if(empty($note['Note']['assis'])){?>
			<li style="padding-bottom:10px;padding-left:20px;"><?php echo ("No record found") ?></li>
			<?php }}?>
		</ul>
		</div>
		</div>
	<div class="comman">
		<h3>
			<font ><?php echo ("Plan")?> </font>
		</h3><?php if(!empty($note['Note']['plan'])) { 
					if($note['Note']['sign_note']=='0'){
						$classPlan='new';
						}else{ 
						$classPlan='new1';
			     }}?>
		<div class="<?php echo $classPlan?>">  
		<ul class="tdLabel">
			<?php  if(!empty($note['Note']['plan'])) {?>
			<li style="padding-bottom:10px;padding-left:20px;" id="powerPlan"><div class="text"><?php
			$expDateNew=explode('$',$note['Note']['plan']);
			 $expDateNew1=explode(':::',$expDateNew['0']);
			echo str_ireplace($sreachKey,'<font color="green">' .$sreachKey .'</font>',$expDateNew1['0']);  ?></div>
			</li>
			<?php }else{?>
			<li style="padding-bottom:10px;"  id="powerPlan" style="padding-bottom:10px;padding-left:20px;"><?php echo ("No record found") ?></li>
			<?php }?>
		</ul>
		</div>
		</div>
	<div class="comman">
		<h3>
			<font><?php echo ("Referrals")?> </font>
			<font style="float:right; font-size:11px;">
				<?php echo $this->Html->link('Click to view Email Conversation','javascript:void(0)',array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Messages','action'=>'conversation',$patient_id
))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1050,height=670,left=150,top=100'); return false;"));
?>
				 </font>
		</h3>
        <table width="100%" class="formFull formFullBorder tdLabel">
	<tr>
		<th style="padding:5px 0 5px 10px;background:none;">Referred To</th>
		<th style="padding:5px 0 5px 10px;background:none;">Date</th> 
		<th style="padding:5px 0 5px 10px;background:none;">Reason For Referring</th>
		<th style="padding:5px 0 5px 10px;background:none;">Status</th>
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
	</div>
	
	<div class="comman">
		<h3>
			<font ><?php echo ("Documents")?> </font>
		</h3>
        <table width="100%" class="formFull formFullBorder">
	<?php  //if(!empty($getDocuments)){ ?>
	<tr>
		<th style="padding:5px 0 5px 10px;background:none;">Link/Document</th>
		<th style="padding:5px 0 5px 10px;background:none;">Provider</th> 
		<th style="padding:5px 0 5px 10px;background:none;">Date</th>
	</tr>	
	<?php  //}
		foreach($getPatientDocuments as $getDocuments){ ?>
	 <tr> 
		<?php if(!empty($getDocuments['PatientDocument']['link'])){ ?>
				<td><a target='_blank' href='<?php echo $getDocuments['PatientDocument']['link'];?>'><?php echo $getDocuments['PatientDocument']['link']; ?></a></td>
		<?php }else if(!empty($getDocuments['PatientDocument']['filename'])){
			$image=  FULL_BASE_URL.Router::url("/")."uploads/user_images/".$getDocuments['PatientDocument']['filename'];?>
		<td><a  target="_blank" href='<?php echo $image;?>'><?php echo $getDocuments['PatientDocument']['filename']; ?></a></td>
		<?php }else{?>
				<td> </td>
			<?php }	 ?>
		<td style="padding:5px 0 5px 10px;"><?php  echo $getDocuments['User']['first_name']." ".$getDocuments['User']['last_name'];?></td>
		<td style="padding:5px 0 5px 10px;"><?php $getDate=$this->DateFormat->formatDate2Local($getDocuments['PatientDocument']['date'],Configure::read('date_format'),false);
		 echo $getDate; ?></td>
	</tr> 
	<?php }if(empty($getDocuments)){?>
	<tr>
		<td colspan=2 style="padding:5px 0 5px 10px;">
		<?php echo __('No record found');?></td>
	</tr>
	<?php  }?>
	</table>
	</div>
	<div class="comman">
		<h3>
			<font><?php echo ("Lab ")?> </font>
		</h3>
		<ul class="tdLabel">
			<?php	if($lab_data[0]['Laboratory']['name']!='') {?>
			<?php foreach($lab_data as $lab){ ?>

			<li class="" style="padding-bottom:10px;"><?php echo$lab['Laboratory']['name']; ?>
			</li>
			<li class="ros_li"><?php //echo $ros['TemplateTypeContent']['template_subcategory_name'];?>
			</li>
			<?php } 
				}else{?>
			<li class="" style="padding-bottom:10px;"><?php echo('No Record Found');}?></li>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<font><?php echo ("Radiology ")?>
			</font>
		</h3>
		<?php ?>
		<ul class="tdLabel">
			<?php if($rad_data!='') {?>
			<?php foreach($rad_data as $rad){?>
			<li class=""><?php echo$rad['Radiology']['name']; ?>
			</li>
			<li class="ros_li"><?php //echo $ros['TemplateTypeContent']['template_subcategory_name'];?>
			</li>
			<br>
			<?php }?>
			<?php } else{?>
			<li class=""><?php echo('No Record Found');} ?> </li>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<font><?php echo ("Procedure Note")?>
			</font>
		</h3>
		  <table width="100%" class="formFull formFullBorder tdLabel">
		<tr class="tdLabel">
			<th style="padding:5px 0 5px 10px;background:none;"><?php echo 'Procedure Name'; ?></th>
			<th style="padding:5px 0 5px 10px;background:none;"><?php echo 'Procedure Date'; ?></th>
		</tr>
		
		<?php if(!empty($procedure_perform)){
				foreach($procedure_perform as $procedure_performs){?>
				<tr class="tdLabel">
			<td class="tdLabel"><?php echo $procedure_performs['ProcedurePerform']['procedure_name']; ?></td>
			<td class="tdLabel"><?php if(!empty($procedure_performs['ProcedurePerform']['procedure_date'])){
				echo $this->DateFormat->formatDate2Local($procedure_performs['ProcedurePerform']['procedure_date'],Configure::read('date_format'),true);} ?></td>
		<?php  }?>
		</tr>
		
		    <?php }else{?>
		    <tr>
		      	<td class="tdLabel"><?php echo 'No record found'; ?></td>
		      </tr>
		      <?php }?>
		</table>
	</div>
	<div class="comman align">
		<h3>
			<font><?php echo ("Health Status ")?>
			</font>
		</h3>
		<ul class="">
			<li class="tdLabel" style="border-bottom:1px dashed #000; padding:0px !important;width:100%;">
            <strong style="font-size:15px; color:#31859c;padding: 0 0 0 10px;"><?php echo("Allergies:")?></strong>
				<ul style="padding: 0px 0px 10px 10px;" >
					<?php	if($allergies[0]['NewCropAllergies']['name']!='') {?>
					<?php  foreach($allergies as $allergy){?>
					<li class="" id="allsoapShow"><span style="width:460px; float:left;"><?php echo$allergy['NewCropAllergies']['name']; ?>
					</span> : &nbsp <?php echo $allergy['NewCropAllergies']['AllergySeverityName']; ?>
					</li>
					<?php } 
					}else {?>
					<li class=""><?php echo ('No record found');} ?></li>
				</ul>
			</li>
			<li class="tdLabel" style="padding:0px !important;"><strong class="curr_med"><?php echo("Current Medication:")?> </strong>
				<ul style="padding:0 0 10px 10px;" class="med_align">
				
					
					<?php	if($medication[0]['NewCropPrescription']['drug_name']!='') { $str='';?>
					<?php foreach($medication as $medication){
					if(!empty($medication['VaccineDrug']['MEDID'])){
			$vax=" (".Vaccine.")";
		}else{
			$vax="";
		}?>
					<?php if(($medication['NewCropPrescription']['archive']=='N') && ($medication['NewCropPrescription']['is_med_administered']=='0')&& ($medication['NewCropPrescription']['refusetotakeimmunization']!="1")){
						if(empty($medication['VaccineDrug']['MEDID']))
						$str= '(Active)';
						
		}
		else if(($medication['NewCropPrescription']['is_med_administered']=='1') && ($medication['NewCropPrescription']['refusetotakeimmunization']!='1')){
			$str= "(Medication ordered in clinic)";
			}
			else if(($medication['NewCropPrescription']['is_med_administered']=='2')  && ($medication['NewCropPrescription']['refusetotakeimmunization']!='1')){
				$str= "(Medication administered in clinic)";
			}
			else if($medication['NewCropPrescription']['refusetotakeimmunization']=='1'){
				$str= "(Medication Refused By Patient)";
			}
		 ?>
					<li><span style="width:120px; float:left;"><?php echo $medication['NewCropPrescription']['drug_name'].$vax; ?>
					</span> :&nbsp<?php echo ucwords(stripslashes($medication['NewCropPrescription']['description'])).$str; 
$str='';}?>
					</li>
					<?php } else{?>
					<li class=""><?php echo('No Record Found');}?></li>
				</ul>
			</li><?php	 if(!empty($note['Note']['reason_to_unsign'])) { ?>
			<li class="tdLabel" style="border-top:1px dashed #000; width:96%;"><strong style="font-size:15px;color:#31859c;"><?php echo("Notes Log:") ; ?> </strong>
				<?php 
				if($this->request->params['named']['header']!='show'){
					echo $this->Html->link('View Detailed Log',array('controller'=>'auditLogs','action'=>'edit_notes_log',
				$note['Note']['id'],$patient_id,"?"=>array('returnUrl'=>'power_note'),'admin'=>true),array('escape'=>false));
}else{
echo $this->Html->link('View Detailed Log',array('controller'=>'auditLogs','action'=>'edit_notes_log',
		$note['Note']['id'],$patient_id,"?"=>array('returnUrl'=>'soapNote'),'admin'=>true),array('escape'=>false));}?>
				<ul>
					<?php	 if(!empty($note['Note']['reason_to_unsign'])) { 
						$expNote=explode(',',$note['Note']['reason_to_unsign']);
					foreach($expNote as $expNote){?>

					<li><strong style="width:400px; float:left;"><?php echo 'Note:'; ?> </strong> :<?php echo $expNote; 
}?>
					</li>
					<?php } else{?>
					<li class="" style="padding-bottom:10px;"><?php echo('No Record Found');}?></li>
				</ul>
			</li>
			<?php }?>
		</ul>
		</div>
		<div style="text-align: right;padding:10px 37px 0 0; clear:both;">
			<?php  if($this->request->params['named']['header']!='show'){?>
				<?php if($_SESSION['role']==configure::read('doctorLabel')){
					echo $this->Html->link('Edit Signed Document','#',array('onclick'=>'editNotes()','class'=>'Bluebtn'));
				}?>
				<?php //echo $this->Html->link('Add Note',array('controller'=>'notes','action'=>'soapNote',$patient_id),array('escape'=>false,'class'=>'Bluebtn'));?>
			<?php }?>
		</div>
<?php echo $this->Form->end();?>
<?php  if($this->params->query['Preview']!='preview'){?>
<div class="comman" style="margin-bottom:10px;">
		<h3>
			<font><?php echo ("Add Attestation ")?>
			</font>
		</h3>
		<ul>
			<li style="padding-bottom:10px;">
			<?php echo $this->element('add_attestation');?></li>
		</ul>
</div>
<?php }?>
<?php /* if($this->Session->read('role')=='Primary Care Provider'){?>		
	<div class="comman">
		<h3>
			<font style="text-decoration: underline"><?php echo ("Resident Notes")?>
			</font>
		</h3>
		<ul>
			<li style="padding-bottom:10px;">
			<?php echo $this->element('add_resident_note');?>
			</li>
		</ul>
	</div>
<?php }?>
<?php  if($this->Session->read('role') == Configure::read('residentLabel')){?>		
	<div class="comman">
		<h3>
			<font style="text-decoration: underline"><?php echo ("Estimate")?>
			</font>
		</h3>
		<ul>
			<li style="padding-bottom:10px;">
			<?php echo $this->element('add_resident_note');?>
			</li>
		</ul>
	</div>
<?php }*/?>
<div class="clr ht5"></div>
<script>
function editNotes(){
	var apptId='<?php echo $appointmentId?>';
	if(apptId==''){
		apptId='<?php echo $_SESSION[apptDoc]?>';
	}
		$
		.fancybox({

			'width' : '50%',
			'height' : '20%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "editSignNotes")); ?>" +"/"+
			'<?php echo $patient_id ?>'+"/"+'<?php echo $notesId?>'+"/"+apptId
			 	
		});

}



		</script>


