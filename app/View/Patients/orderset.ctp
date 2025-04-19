<?php echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','ui.datetimepicker.3.js','jquery.selection.js'));
?>



<style>
#navc,#navc ul {
	padding: 0 0 5px 0;
	margin: 0;
	list-style: none;
	font: 15px verdana, sans-serif;
	border-color: #000;
	border-width: 1px 2px 2px 1px;
	background: #374043;
	position: relative;
	z-index: 200;
}

#navc {
	height: 35px;
	padding: 0;
	width: 350px;
	margin-left: -7px;
	margin-top: 70px;
}

#navc li {
	float: left;
}

#navc li li {
	float: none;
	background: #fff;
}

* html #navc li li {
	float: left;
}

#navc li a {
	display: block;
	float: left;
	color: #fff;
	margin: 0 25px 0 10px;
	height: 35px;
	line-height: 12px;
	text-decoration: none;
	white-space: nowrap;
	font-size: 14px;
}

#navc li li a {
	height: 20px;
	line-height: 20px;
	float: none;
}

#navc ul {
	position: absolute;
	left: -9999px;
	top: -9999px;
}

* html #navc ul {
	width: 1px;
}

#navc li:hover li:hover>ul {
	left: -15px;
	margin-left: 100%;
	top: -1px;
}

#navc li:hover>ul ul {
	position: absolute;
	left: -9999px;
	top: -9999px;
	width: auto;
}

#navc li:hover>a {
	color: #fff;
}

.inter {
	display: block;
	height: 120px;
	overflow: visible;
	padding-bottom: 10px;
	padding-top: 10px;
}
</style>
<?php 
echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js','stuHover.js'));

echo $this->Html->css(array('jquery.autocomplete.css','skeleton.css'));
echo $this->Form->hidden('Patientsid',array('id'=>'Patientsid','value'=>$p_id,'autocomplete'=>"off"));


echo $code=$this->Form->hidden('icdcode',array('id'=>'icdcode','value'=>'','autocomplete'=>"off")); ?>

<div class="inner_title">
	<h3>
		<?php echo __('Quick Note'); ?>
	</h3>
</div>
<?php 
echo $this->Form->create('Note',array('id'=>'patientnotesfrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));
echo $this->Form->hidden('Note.id');
$note_type  = $this->data['Note']['note_type'] ;
$toBeBilled = 'none' ;
if($note_type=='general'){
		 		$toBeBilled ='block';
		 	} ?>

<!-- BOF new HTML -->


<?php
$options = array();
$cnt=0;

foreach($record as $d) {
$cnt++; $options[$d['Note']['id']] = 'Dated: '.$d['Note']['create_time'];
} $this->set(compact('options')); ?>


<table class="table_format" id="schedule_form">
	<tr>
		<td><?php $agecheck='0';

		$age= $data['0']['Patient']['age'];// PAtient Age

		$d_age=$CDS_Data['0']['ClinicalSupport']['age'];// doctor select age

		$sign=$CDS_Data['0']['ClinicalSupport']['com_h'];// range seleted by doctor

		if(($CDS_Data['0']['ClinicalSupport']['Hyptension']=='1')){
//debug($sign);
			if($sign=='>'){


if(($age >=$d_age && $geticds == 'ok') && (($role=="Primary Care Provider") ||($role=="Admin"))){ ?>
			<ul id="navc">
				<li><a href="" id="cr">Hypertension Reminder </a>
					<ul id="navc">
						<li><?php echo $this->Html->link(__("Hypertension"),array("controller"=>"Patients","action"=>"showhypertension"),array("style"=>"color:black"));?>
						</li>
					</ul></li>
			</ul> <?php }
}?> <?php $agecheck='0';
if($sign=='<'){
if(($age <=$d_age && $geticds == 'ok') && (($role=="Primary Care Provider") ||($role=="Admin"))){ ?>
			<ul id="navc">
				<li><a href="" id="cr">Clinical Reminder 0/1 </a>
					<ul id="navc">
						<li><?php echo $this->Html->link(__("Hypertension"),array("controller"=>"Patients","action"=>"showhypertension"),array("style"=>"color:black"));?>
						</li>
					</ul></li>
			</ul> <?php }
}?> <?php $agecheck='0';
//echo $sign;
if($sign=='=='){
if(($age == $d_age && $geticds == 'ok') && (($role=="Primary Care Provider") ||($role=="Admin"))){ ?>
			<ul id="navc">
				<li><a href="" id="cr">Clinical Reminder 0/1 </a>
					<ul id="navc">
						<li><?php echo $this->Html->link(__("Hypertension"),array("controller"=>"Patients","action"=>"showhypertension"),array("style"=>"color:black"));?>
						</li>
					</ul></li>
			</ul> <?php }
}
}?>
		</td>
	</tr>
</table>
<?php
// set variable for edit form
if(isset($this->data['Note']['note_type'])){
		 	 	 $note_type  = $this->data['Note']['note_type'] ;
		 	 	 $gen_display  = 'none';
		 	 	 $pre_display  = 'none';
		 	 	 $other_display ='none';
		 	 	 $ot_display  = 'none';
		 	 	 $post_display  = 'none';

		 	 	 if($note_type=='general'){
		 	 	 	$gen_display  = 'block';
		 	 	 }else if($note_type=='pre-operative'){
		 	 	 	$pre_display  = 'block';
		 	 	 }else if($note_type=='post-operative'){
		 	 	 	$post_display  = 'block';
		 	 	 }else if($note_type=='OT'){
		 	 	 	$ot_display  = 'block';
		 	 	 }else{
		 	 	 	$other_display ='block';
		 	 	 }
		 	 }else{
		 	 		$gen_display  = 'none';
		 	 		$pre_display  = 'none';
		 	 		$other_display ='none';
		 	 		$ot_display  = 'none';
		 	 		$post_display  = 'none';
		 	 }
		 	 ?>
		 	 <div><?php echo __('Select Diagnosis Type'); ?>:<?php echo $this->Form->input('OrderSet.diagnosisid', array('options' => $specialitycat, 'id' => 'specilaity_id', 'label'=> false, 'div' => false, 'error' => false,'class' => '','onChange'=>'javascript:display_orderset(this.value,'.$this->Session->read("departmentid").')'));?></div>
<div
	id="accordionCust" class="accordionCust">
	<!-- BOF General Note type option -->

	<h3 style="display: &amp;amp;" id="order-set">
		<a href="#">Order Set</a>
	</h3>
	<div class="section">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" border="0"
						class="formFull formFullBorder" id="orderset_mainid">
						<tr>
							<td width="25%" valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td><b> <?php echo ('Lab')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetLab);$i++){
											$labData[]=$dataOrderSetLab[$i]['OrderSetLab']['name'];
									}


									foreach($dataOrderSetLab as $lab_datas){
											if(in_array($lab_datas['OrderSetLab']['name'],$selectedLab)){
															$checkedLab= "checked";
																	}
																	else {
														$checkedLab= "checked";
														}
														//echo $this->Form->input("test", array("type" => "checkbox"));echo $lab_datas['OrderSetLab']['name'];
														echo $this->Form->input("Laboratory.name", array("type" => "checkbox","checked"=>$checkedLab,'hiddenField'=>false,'name'=>'data[Laboratory][name][]',
									'class'=>given_medi,'value'=>$lab_datas['Laboratory']['name']));echo $lab_datas['Laboratory']['name']."<br/>";
                                        echo $this->Form->input("Laboratory.loinc_code", array("type" => "hidden","value"=>$lab_datas['Laboratory']['lonic_code'],'name'=>'data[Laboratory][loinc_code][]'));
                                        echo $this->Form->input("Laboratory.cpt_code", array("type" => "hidden","value"=>$lab_datas['Laboratory']['cpt_code'],'name'=>'data[Laboratory][cpt_code][]'));
									}
									$checkedLab= " ";
									?></td>
									</tr>

									<tr>
										<td></td>
										<td><?php // echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'proceduresubmit','class'=>'blueBtn','onclick'=>"javascript:save_order_set_lab('$p_id')")); 
													?>

										</td>
									</tr>

								</table>
							</td>
							<td width="25%" valign="top"><table width="100%" cellpadding="0"
									cellspacing="0" border="0">
									<tr>
										<td><b> <?php echo ('Medication')."<br/>";?>
										</b></td>
									</tr>
									<?php 
									for($i=0;$i<count($dataOrderSetMed);$i++){
											$medData[]=$dataOrderSetMed[$i]['OrderSetMed']['name'];
									}


									?>

									<?php 

									foreach($dataOrderSetMed as $phar_datas){


											if(in_array($phar_datas['OrderSetMed']['name'],$selectedMed)){
	//debug(array_intersect($medData,$selectedMed));
												$checkedMed= "checked";
											}
											else {
													$checkedMed= "checked";
											}
											echo "<tr><td>".$this->Form->input("NewCropPrescription.description", array("type" => "checkbox","checked"=>$checkedMed,'hiddenField'=>false,'name'=>'data[NewCropPrescription][description][]','class'=>given_medi,'value'=>$phar_datas['OrderSetMed']['name']));echo $phar_datas['OrderSetMed']['name']."</td></tr>";
											echo $this->Form->input("NewCropPrescription.rxnorm_code", array("type" => "hidden","value"=>$phar_datas['OrderSetMed']['rxnorm_code'],'name'=>'data[NewCropPrescription][rxnorm_code][]'));
											
											
											$checkedMed= "";
									}
									?>

									<tr>
										<td></td>
										<td><?php // echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'setmedication','class'=>'blueBtn','onclick'=>"javascript:save_order_set_medication()")); ?>
									
									</tr>
								</table></td>
							<td width="25%" valign="top"><table width="100%" cellpadding="0"
									cellspacing="0" border="0">
									<tr>
										<td id="lowback"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									//debug($dataOrderSetRad);
									//debug($selectedDataRad);
									//exit;
									foreach($dataOrderSetRad as $rad_datas){
													if(in_array($rad_datas['OrderSetRad']['name'],$selectedDataRad)){
															//debug(in_array($rad_datas['OrderSetRad']['name'],$selectedRad));
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													
													echo $this->Form->input("Radiology.name", array("type" => "checkbox","checked"=>$checkedRad,'hiddenField'=>false,'name'=>'data[Radiology][name][]','class'=>given_medi,'value'=>$rad_datas['Radiology']['name']));echo $rad_datas['Radiology']['name']."<br/>";
													echo $this->Form->input("Radiology.loinc_code", array("type" => "hidden","value"=>$rad_datas['Radiology']['loinc_code'],'name'=>'data[Radiology][loinc_code][]'));
                                                    echo $this->Form->input("Radiology.cpt_code", array("type" => "hidden","value"=>$rad_datas['Radiology']['cpt_code'],'name'=>'data[Radiology][cpt_code][]'));
                                                    echo $this->Form->input("Radiology.id", array("type" => "hidden","value"=>$rad_datas['Radiology']['id'],'name'=>'data[Radiology][id][]'));
													

									}
									$checkedRad= "";
									?>
										</td>

										<td id="kneepain" style="display:none"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									//debug($dataOrderSetRad);
									//debug($selectedDataRad);
									//exit;
									foreach($dataOrderSetRad_knee as $rad_datas_knee){
													if(in_array($rad_datas_knee['OrderSetRad']['name'],$selectedDataRad_knee)){
															
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													echo $this->Form->input("Radiology.name_knee", array("type" => "checkbox","checked"=>$checkedRad,'hiddenField'=>false,'name'=>'data[Radiology][name_knee][]','class'=>given_medi,'value'=>$rad_datas_knee['OrderSetRad']['name']));echo $rad_datas_knee['OrderSetRad']['name']."<br/>";
													

									}
									$checkedRad= "";
									?>
										</td>

										<td id="neckpain" style="display:none"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									//debug($dataOrderSetRad);
									//debug($selectedDataRad);
									//exit;
									foreach($dataOrderSetRad_neck as $rad_datas_neck){
													if(in_array($rad_datas['OrderSetRad']['name'],$selectedDataRad)){
															//debug(in_array($rad_datas['OrderSetRad']['name'],$selectedRad));
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													echo $this->Form->input("Radiology.name_neck", array("type" => "checkbox","checked"=>$checkedRad,'hiddenField'=>false,'name'=>'data[Radiology][name_neck][]','class'=>given_medi,'value'=>$rad_datas_neck['OrderSetRad']['name']));echo $rad_datas_neck['OrderSetRad']['name']."<br/>";
													

									}
									$checkedRad= "";
									?>
										</td>

										<td id="upper" style="display:none"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									//debug($dataOrderSetRad);
									//debug($selectedDataRad);
									//exit;
									foreach($dataOrderSetRad_upper as $rad_datas_upper){
													if(in_array($rad_datas['OrderSetRad']['name'],$selectedDataRad)){
															
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													echo $this->Form->input("Radiology.name_upper", array("type" => "checkbox","checked"=>$checkedRad,'hiddenField'=>false,'name'=>'data[Radiology][name_upper][]','class'=>given_medi,'value'=>$rad_datas_upper['OrderSetRad']['name']));echo $rad_datas_upper['OrderSetRad']['name']."<br/>";
													

									}
									$checkedRad= "";
									?>
										</td>

										<td id="lower" style="display:none"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									//debug($dataOrderSetRad);
									//debug($selectedDataRad);
									//exit;
									foreach($dataOrderSetRad_lower as $rad_datas_lower){
													if(in_array($rad_datas['OrderSetRad']['name'],$selectedDataRad)){
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													echo $this->Form->input("Radiology.name_lower", array("type" => "checkbox","checked"=>$checkedRad,'hiddenField'=>false,'name'=>'data[Radiology][name_lower][]','class'=>given_medi,'value'=>$rad_datas_lower['OrderSetRad']['name']));echo $rad_datas_lower['OrderSetRad']['name']."<br/>";
													

									}
									$checkedRad= "";
									?>
										</td>
										
										


									</tr>
									<tr>
										<td></td>
										<td><?php  //echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'proceduresubmit','class'=>'blueBtn','onclick'=>"javascript:save_order_set_rad()")); ?>
									
									</tr>
								</table></td>
								
								<td width="25%" valign="top"><table width="100%" cellpadding="0"
									cellspacing="0" border="0">
									<tr>
										<td><b> <?php echo ('EKG')."<br/>";?>
										</b></td>
									</tr>
									<?php 
									for($i=0;$i<count($dataOrderSetEkg);$i++){
											$ekgData[]=$dataOrderSetEkg[$i]['OrderSetEkg']['name'];
									}


									?>

									<?php 

									foreach($dataOrderSetEkg as $ekg_datas){


											if(in_array($ekg_datas['OrderSetEkg']['name'],$selectedMed)){
	//debug(array_intersect($medData,$selectedMed));
												$checkedEkg= "checked";
											}
											else {
													$checkedEkg= "checked";
											}
											echo "<tr><td>".$this->Form->input("Ekg.name", array("type" => "checkbox","checked"=>$checkedEkg,'hiddenField'=>false,'name'=>'data[Ekg][name][]','class'=>given_medi,'value'=>$ekg_datas['OrderSetEkg']['name']));echo $ekg_datas['OrderSetEkg']['name']."</td></tr>";
											echo $this->Form->input("Ekg.code", array("type" => "hidden","value"=>$ekg_datas['OrderSetEkg']['code'],'name'=>'data[Ekg][code][]'));
                         
											$checkedEkg= "";
									}
									?>

									<tr>
										<td></td>
										<td><?php // echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'setmedication','class'=>'blueBtn','onclick'=>"javascript:save_order_set_medication()")); ?>
									
									</tr>
								</table></td>
							
						</tr>
					</table>

				</td>
			</tr>
		</table>
		</div>
	
	<h3 style="display: &amp;amp;" id="subjective-link">
		<a href="#">Subjective</a>
	</h3>
	<div class="section" id="subjectiveorderset">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-subjective'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-subjectiveorderset"></div>
				</td>
				<td width="70%" align="left" valign="top">

					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('subject', array('id' => 'subjectiveorderset_desc'  ,'rows'=>'18','style'=>'width:90%')); ?><br />
								<a href="javascript:void(0);" onclick="callDragon('S')"
								style="text-align: left;"><font color="white">Use speech
										recognition</font> </a>
							</td>


						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<h3 style="display: &amp;amp;" id="objective-link">
		<a href="#">Objective</a>
	</h3>
	<div class="section" id="objectiveorderset">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-objective'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-objectiveorderset"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('object', array('id' => 'objectiveeorderset_desc' , 'class'=>"tdInput" ,'data-nusa-concept-name'=>"findings"  ,'rows'=>'18','style'=>'width:90%')); ?><br />
								<a href="javascript:void(0);" onclick="callDragon('O')"
								style="text-align: left;"><font color="white">Use speech
										recognition</font> </a>
							</td>

						</tr>

					</table>
				</td>
			</tr>
		</table>
		
	</div>

 		

	<!-- EOF devices -->
	<h3 style="display:none" id="finalization-link">
		<a href="#">Finalization</a>
	</h3>
	<div class="section" id="finalization" style="display:none">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-finalization'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
				</td>
			</tr>
			<tr>
				<td><strong>Enter the following quality reporting items below :</strong>
				</td>
			</tr>
			<tr>
				<td>
					<div class="section">
						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="formFull formFullBorder">
							<tr>
								<td>Visit Type(s):</td>
								<?php   ?>
							</tr>
							<tr>
								<?php $count=0;
								foreach($visittype as $visit){
					 			foreach($visit as $uniqueslot){
								$count++;
								?>
								<td width='2px'><?php if(in_array($uniqueslot[id],$selected)){
									$checked= "checked";
								} else { $checked= "";
								}
								echo $this->Form->input('Note.visitid', array('type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][visitid][]','checked'=>$checked,'value'=>$uniqueslot[id]));
								?></td>
								<td valign="top"><?php echo $uniqueslot[description];  ?>
								</td>
								<?php  if($count % 3 ==0){ 
									echo "</tr><tr>";
								}
								 }
								} ?>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="section">
						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="formFull formFullBorder">
							<tr>
								<td>Weight Screening:</td>
								<td valign="top">Height&nbsp;&nbsp;<?php	
								echo $this->Form->input('Note.ht',array('legend'=>false,'label'=>false,'class' => 'validate[optional,custom[onlyNumber]]', 'style' => 'width:30px','id' => 'height'));
								?> (Inch.)
								</td>
								<td valign="top">Weight&nbsp;&nbsp;<?php	
								echo $this->Form->input('Note.wt',array('legend'=>false,'label'=>false,'class' => 'validate[optional,custom[onlyNumber]]', 'style' => 'width:30px', 'id' => 'weight'));
								?> (Lbs.)
								</td>

								<td valign="top">B.M.I.&nbsp;&nbsp;<?php	
								echo $this->Form->input('Note.bmi',array('legend'=>false,'label'=>false, 'style' => 'width:50px', 'id' => 'bmi', 'readonly' => 'readonly'));
								?> <span id="bmiStatus"></span>
								</td>

								<td>Date:</td>
								<td valign="top">&nbsp;&nbsp;<?php	
								if($this->request->data['Note']['finalization_date']) {
								echo $this->Form->input('finalization_date', array('type' => 'text','class'=>'textBoxExpnd','style'=>'width:120px', 'id' => 'finalization_date', 'label'=> false,'div' => false, 'error' => false,'value' => date("m/d/Y", strtotime($this->request->data['Note']['finalization_date']))));
								}else {
									echo $this->Form->input('finalization_date', array('type' => 'text','class'=>'textBoxExpnd','style'=>'width:120px', 'id' => 'finalization_date', 'label'=> false,'div' => false, 'error' => false, ));
								}?> <span id="bmiStatus"></span>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td valign="top"><?php if(in_array("Nutritional counseling",$selectfinal)){ 
									$nc="checked";
								}
								echo $this->Form->input('Note.final', array('checked'=> $nc,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][final][]','value'=>'Nutritional counseling')); ?>&nbsp;Nutritional
									counseling</td>
							</tr>
							<tr>
								<td><?php  if(in_array("Physical activity counseling",$selectfinal)){ 
									$pac="checked";
								}
								echo $this->Form->input('Note.final', array('checked'=> $pac,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][final][]','value'=>'Physical activity counseling')); ?>&nbsp;Physical
									activity counseling</td>
							</tr>
							<tr>
								<td><?php   if(in_array("B.M.I - NOT DONE (Medical Reason)",$selectfinal)){ 
									$mr="checked";
								}
								echo $this->Form->input('Note.final', array('checked'=>$mr,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][final][]','value'=>'B.M.I - NOT DONE (Medical Reason)')); ?>&nbsp;B.M.I
									- NOT DONE (Medical Reason)</td>
							</tr>
							<tr>
								<td><?php   if(in_array("B.M.I - NOT DONE (System Reason)",$selectfinal)){ 
									$sr="checked";
								}
								echo $this->Form->input('Note.final', array('checked'=>$sr,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][final][]','value'=>'B.M.I - NOT DONE (System Reason)')); ?>&nbsp;B.M.I
									- NOT DONE (System Reason)</td>
							</tr>
							<tr>
								<td><?php   if(in_array("B.M.I - NOT DONE (Patient Reason)",$selectfinal)){ 
									$pr="checked";
								}
								echo $this->Form->input('Note.final', array('checked'=>$pr,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][final][]','value'=>'B.M.I - NOT DONE (Patient Reason)')); ?>&nbsp;B.M.I
									- NOT DONE (Patient Reason)</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="section">
						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="formFull formFullBorder">

							<tr>
								<td><label style="float: inherit"><?php echo __('Patient Characterstic:') ?>
								</label></td>
								<td><?php  echo $this->Form->input('patient_character_snomed', array('style'=>'width:250px; float:left;','empty'=>__('Select'),'options'=>array("13798002"=>"Gestation Period 38 weeks(finding)",'441924001'=>'Gestational age unknown'), 'id'=>'patient_character_snomed',
										'class' => 'textBoxExpnd')); ?>
								</td>





								<?php //echo $this->Form->input('patient_character',array('empty'=>__('Select'),'options'=>$patient_char,'escape'=>false,'multiple'=>false,'value'=>'',
								//'style'=>'width:400px;','id'=>'patient_character','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:patient_char_onchange()'));
								?>
								<?php// echo// __('Patient Characterstic:') ?>
								<td class="row_format"><?php //echo $this->Form->select('patient_character',array($patient_char),array("empty"=>__('Please Select'),
								//'label'=>false,'div'=>false,'id' => 'patient_character','onChange'=>'javascript:patient_char_onchange()')); 	?>
									<?php ///echo $this->Form->hidden('patient_char_sno',array('id'=>'patient_char_sno','type'=>'text'));?>

								</td>




								<td><?php echo __('Characterstic Date :');?></td>
								<td><?php if($this->request->data['Note']['patient_char_date']) {
									echo $this->Form->input('patient_char_date', array('type' => 'text','class'=>'textBoxExpnd','style'=>'width:120px', 'id' => 'patient_char_date', 'label'=> false,'div' => false, 'error' => false,'value' => date("m/d/Y", strtotime($this->request->data['Note']['patient_char_date']))));
								}else {
									echo $this->Form->input('patient_char_date', array('type' => 'text','class'=>'textBoxExpnd','style'=>'width:120px', 'id' => 'patient_char_date', 'label'=> false,'div' => false, 'error' => false, ));
								}
								?> <?php
								//echo $this->Form->input('Note.patient_char_date',array('type'=>'text','id'=>'patient_char_date','value' => date("m/d/Y", strtotime($this->request->data['Note']['patient_char_date']))));
								?>
								</td>

							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<!-- EOF section div -->

	<!-- EOF section div -->

	<!-- EOF section div -->

	<!-- EOF General Note type option -->
	<!-- BOF pre-operative Note type option -->

	<!-- EOF section div -->



	<!-- BOF Other -->

	<h3 style="display:none" id="aids-link">
		<a href="#">Other</a>
	</h3>
	<div class="section" id="other">
		<div align="center" id='temp-busy-indicator-other'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0">
			<tr>
				<td><label style="float: inherit"><strong><?php echo __('Medication') ?><strong>
				
				</label></td>
			</tr>
			<tr style="border: 0.5px solid">
				<td><label style="float: inherit"><?php echo __('Number of written medication orders :') ?>
				</label> <?php echo $this->Form->input('medication_order', array('id' => 'medication_order'  )); ?>
				</td>

				<td><label style="float: inherit"><?php echo __('Date of prescription :') ?>
				</label></td>
				<td><?php	
				if($this->request->data['Note']['medication_order_date']) {
						echo $this->Form->input('medication_order_date', array('class'=>'textBoxExpnd','style'=>'width:120px','type' => 'text', 'id' => 'medication_order_date', 'label'=> false,'div' => false, 'error' => false,'value' => date("m/d/Y", strtotime($this->request->data['Note']['medication_order_date']))));
								}
								else {
						echo $this->Form->input('medication_order_date', array('class'=>'textBoxExpnd','style'=>'width:120px','type' => 'text', 'id' => 'medication_order_date', 'label'=> false,'div' => false, 'error' => false, ));
							}?> <?php //echo $this->Form->input('medication_order_date', array('id' => 'medication_order_date','type'=>'text'  )); ?>
				</td>
			</tr>
		</table>


	</div>

	<!-- EOF section div -->
	<h3 style="display: none" id="event-note-link">
		<a href="#">Event Note</a>
	</h3>
	<div class="section" id="event-note">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-event-note'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-event-note"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('event_note', array('id' => 'event_note_desc'  ,'rows'=>'18','style'=>'width:90%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!-- EOF section div -->


	<!-- BOF Other Note type option -->
	<h3 style="display:none" id="notes-link">
		<a href="#">Note</a>
	</h3>
	<div class="section" id="notes">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-notes'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-notes"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('note', array('id' => 'notes_desc' ,'rows'=>'18','style'=>'width:90%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>



	<!-- BOF  Functional-Status Accordian -->




	<!-- BOF Recommended Decision aids -->

	<h3 style="display:none" id="aids-link">
		<a href="#">Recommended Decision aids</a>
	</h3>
	<div class="section" id="aids">
		<div align="center" id='temp-busy-indicator-aids'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>

		<table border="0" class="table_format" cellpadding="0" cellspacing="0">
			<tr class="row_title">
				<td class="row_format"><label style="float: inherit"><?php echo __('Recommended Decision aids:') ?>
				</label></td>
				<td class="row_format"><?php echo $this->Form->textarea('decision_aids', array('id' => 'decision_aids'  ,'rows'=>'15','style'=>'width:600px')); ?>
					<?php //echo $this->Form->select('icd9cm_inter',array($icdOptions),array("empty"=>__('Please Select'),
								//'label'=>false,'div'=>false,'id' => 'icd9cm_inter','onChange'=>'javascript:changeTest_inter()')); 	?>
				</td>
			</tr>
		</table>


	</div>
	<!-- EOF Recommended Decision aids -->


<h3 style="display: &amp;amp;" id="medication-order">
		<a href="#">Medication Order</a>
	</h3>
	<div class="section">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" border="0"
						class="formFull formFullBorder" id="orderset_mainid">
						<tr>
							<td width="100%" valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr><tr><td style="padding-left:33px;"><strong>ibuprofen 100 mg chewable tablet</strong></td></tr>
									<tr><td>&nbsp;</td></tr>
									<tr><td width="19%" style="padding-left:33px; margin: 15px 0 0 10px;">
										<?php echo __('Drug Name ',true);
									echo $this->Form->input('NewCropPrescription.drug_name', array('type'=>'text','id' => 'drug_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:470px;'));?>
										</td>
										
										
										
																
										</tr>
									
						
									<tr>
										<td>
										<table border="0" width="100%" >
										<tr>
										<td width="19%" style="padding-left:33px;">
										<?php echo __('Dose',true); ?>
										</td>
										<td width="19%">
										<?php echo $this->Form->input('NewCropPrescription.dose_type', array('empty'=>'Please select','options'=> Configure :: read('dose_type'), 'id' => 'dose_type','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd' ));?>
										</td>
										<td width="19%" style="padding-left:33px;">
										<?php echo __('Strength',true); ?>
										</td>
										<td width="21%">
										<?php echo $this->Form->input('NewCropPrescription.strength', array('options'=> Configure :: read('strength'), 'id' => 'strength','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd' ));?>
										</td>								
										</tr>
										<tr>
										<td width="19%" style="padding-left:33px;">
										<?php echo __('Route of administration',true); ?>
										</td>
										<td width="19%">
										<?php echo $this->Form->input('NewCropPrescription.route_administration', array('empty'=>'Please select','options'=> Configure :: read('route_administration'), 'id' => 'route_administration','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd' ));?>
										</td>
										<td width="19%" style="padding-left:33px;" >
										<?php echo __('Frequency',true); ?>
										</td>
										<td>
										<?php echo $this->Form->input('NewCropPrescription.frequency', array('empty'=>'Please select','options'=> Configure :: read('frequency'), 'id' => 'frequency','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd' ));?>
										</td>								
										</tr>
										
										<tr>
										<td width="19%" style="padding-left:33px;">
										<?php echo __('Duration',true); ?>
										</td>
										<td width="20%">
										<?php echo $this->Form->input('NewCropPrescription.duration', array('empty'=>'Please select','options'=> Configure :: read('daysupply'), 'id' => 'duration', 'class'=> 'textBoxExpnd'));?>
										</td>
										<td width="19%" style="padding-left:33px;">
										<?php echo __('Refills',true); ?>
										</td>
										<td width="20%">
										<?php echo $this->Form->input('NewCropPrescription.refills', array('options'=> Configure :: read('refills'), 'id' => 'refills','width'=> '100%','class'=>'textBoxExpnd' ));?>
										</td>								
										</tr>
										
										<tr>
										<td width="19%" style="padding-left:33px;" >
										<?php echo __('PRN',true); ?>
										</td>
										<td>
										<?php echo $this->Form->checkbox('NewCropPrescription.prn', array('class'=>'servicesClick','id' => 'prn'));?>
										</td>
										<td width="19%" style="padding-left:33px;">
										<?php echo __('DAW / DNS',true); ?>
										</td>
										<td>
										<?php echo $this->Form->checkbox('NewCropPrescription.daw', array('class'=>'servicesClick','id' => 'daw'));?>
										</td>								
										</tr>
										
										<tr>
										<td width="19%" style="padding-left:33px;">
										<?php echo __('First Dose Date/Time',true); ?>
										</td>
										<td width="20%">
										<?php echo $this->Form->input('NewCropPrescription.firstdose_datetime',array('legend'=>false,'label'=>false,'class' => 'validate[required] textBoxExpnd','id' => 'firstdose_datetime','value'=>$drugallergy_data["0"]["DrugAllergy"]["from1"],'autocomplete'=>"off",'readonly'=>'readonly'));?>
										</td>
										<td width="19%" style="padding-left:33px;">
										<?php echo __('Stop Date/Time',true); ?>
										</td>
										<td width="20%">
										<?php echo $this->Form->input('NewCropPrescription.stopdose_datetime',array('legend'=>false,'label'=>false,'class' => 'validate[required] textBoxExpnd','id' => 'stopdose_datetime','value'=>$drugallergy_data["0"]["DrugAllergy"]["from1"],'autocomplete'=>"off",'readonly'=>'readonly'));?>
										</td>								
										</tr>
										
										<tr>	
										<td width="19%" style="padding-left:33px;"valign="top">
										<?php echo __('Special Instruction',true); ?>
										</td>
										<td width="20%" valign="top">
										<?php echo $this->Form->textarea('NewCropPrescription.special_instruction', array('id' => 'special_instruction','rows'=>'5','class'=> 'textBoxExpnd'));?>
										</td>								
										</tr>	
										</table>
										</td>
										
									</tr>

								</table>
							</td>
							
									</tr>
									<tr>
										<td></td>
										<td><?php  //echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'proceduresubmit','class'=>'blueBtn','onclick'=>"javascript:save_order_set_rad()")); ?>
									
									</tr>
								</table></td>
							
						</tr>
					</table>

				</td>
			</tr>
		</table>
		</div>



	<!-- Bof Symptoms -->



	<!-- Eof Symptoms -->


	<!-- Bof Diagnostic study accordian -->



	<!-- EOF new HTML -->
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div class="btns">
				<?php  echo $this->Js->link(__('Cancel'), array('controller'=>'patients','action' => 'patient_notes', $patientid), array('escape' => false,'update'=>'#list_content','method'=>'post','class'=>'blueBtn'));
				echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
				echo $this->Js->writeBuffer();
				?>
			</div>
		</td>
	</tr>
</table>

<?php echo $this->Form->end(); ?>
<?php $splitDate = explode(' ',$admissionDate);?>
<script>


	var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
	var explode = admissionDate.split('-');
	$(document).ready(function(){
   	 
		$("#subjective_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});
		$("#objective_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});
		$("#assessment_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});
		$("#pre-opt_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});
		$("#surgery_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});
		$("#post-opt_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});

		$("#drug_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Rxnatomarchive","STR", "admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	   });
		
 	});
 	
	$(function() {
		$('input')
				.filter('.my_start_date')
				.datepicker(
						{
							changeMonth : true,
							changeYear : true,
							yearRange : '1950',
							minDate : new Date(explode[0], explode[1] - 1,
									explode[2]),
							dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
							showOn : 'button',
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							onSelect : function() {
								$(this).focus();
							}
						});
	});
	
	//----------------------------------------------------------------------------
		//----------GAURAV------------

	$("#eraser").click(function() {

		$('#icdSlc').html('');
		$('#icd_ids').val('');
		$("#eraser").hide();
	});
	
	$("#eraser").hide();

	function remove_icd(val) {
		 
		
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "deleteNoteDiagnosis","admin" => false)); ?>";
			$.ajax({
				type : "POST",
				url : ajaxUrl +"/"+val, 
				context : document.body,
				success : function(data) {
					if(data == 1 ){
						
						var ids = $('#icd_ids').val();
						tt = ids.replace(val + '|', '');
						 
						$('#icd_ids').val(tt);
						$('#icd_' + val).remove();
						var	ht = $.trim($('#icdSlc').html());
						if(ht == ''){
							$('#chkbox').attr('checked','checked');
							//$("#chkbox").attr("disabled", true);
						}
					
					}else{  
						alert("Please try again");
					} 
				}
			});
		 
	
	}

	$("#assessment-link").click(function() {
	var	ht = $.trim($('#icdSlc').html());
		
		if(ht == ''){
			$('#chkbox').attr('checked','checked');
			//$("#chkbox").attr("disabled", true);
		}else{
			$('#chkbox').attr('checked',false);
			$("#chkbox").attr("disabled", true);
		}
	});

	$("#eraser").click(function() {

		$('#icdSlc').html('');
		$('#icd_ids').val('');
		$("#eraser").hide();
	});

	function remove_icdr(val) {
		 
		 
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "deleteNoteDiagnosis","admin" => false)); ?>";
		$.ajax({
			type : "POST",
			url : ajaxUrl +"/"+val, 
			context : document.body,
			success : function(data) {
				if(data == 1 ){
					//alert(data);
					var ids = $('#icd_idsr').val();
					tt = ids.replace(val + '|', '');
					 
					$('#icd_idsr').val(tt);
					$('#icdr_' + val).remove();
				}else{  
					alert("Please try again");
				} 
			}
		});
	 

}

	$("#eraser").click(function() {

		$('#icdSlc').html('');
		$('#icd_ids').val('');
		$("#eraser").hide();
	});

	$("#eraser").hide();
	function remove_icdi(val) {
		 
		 
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "deleteNoteDiagnosis","admin" => false)); ?>";
		$.ajax({
			type : "POST",
			url : ajaxUrl +"/"+val, 
			context : document.body,
			success : function(data) {
				if(data == 1 ){
					alert(data);
					var ids = $('#icd_idsi').val();
					tt = ids.replace(val + '|', '');
					 
					$('#icd_idsi').val(tt);
					$('#icdi_' + val).remove();
				}else{  
					alert("Please try again");
				} 
			}
		});
	 

}

	$("#eraser").click(function() {

		$('#icdSlc').html('');
		$('#icd_ids').val('');
		$("#eraser").hide();
	});

	$("#eraser").hide();
	function remove_icdi(val) {
		 
		 
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "deleteNoteDiagnosis","admin" => false)); ?>";
		$.ajax({
			type : "POST",
			url : ajaxUrl +"/"+val, 
			context : document.body,
			success : function(data) {
				if(data == 1 ){
					alert(data);
					var ids = $('#icd_idsr').val();
					tt = ids.replace(val + '|', '');
					 
					$('#icd_idsr').val(tt);
					$('#icdi_' + val).remove();
				}else{  
					alert("Please try again");
				} 
			}
		});
	 

}


	//----------------------------------------------------------------------------
	//-----------
	var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
	var explode = admissionDate.split('-');
	$(function() {
		$('input')
				.filter('.my_end_date')
				.datepicker(
						{
							changeMonth : true,
							changeYear : true,
							yearRange : '1950',
							minDate : new Date(explode[0], explode[1] - 1,
									explode[2]),

							dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
                    	    showOn : 'button',
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							onSelect : function() {
								$(this).focus();
							}
						});
	});
	
//----------------------------------------------------------------------------
	// To sate min date not more than the admission date 

	jQuery(document)
			.ready(
					function() {

						/*$('#diagicd').click(function(){
							alert("hello");
						    var patient_id = '933';
							if(patient_id==''){
								alert("Please select patient");
								return false ;
							} 
							$.fancybox({
								
						        'width'    : '90%',
							    'height'   : '90%',
							    'autoScale': true,
							    'transitionIn': 'fade',
							    'transitionOut': 'fade',
							    'type': 'iframe',
							    'href': "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "icd")); ?>"+'/'+patient_id 
						    });
							
						});*/

						$("#note_date")
								.datepicker(
										{
											showOn : "button",
											style : "margin-left:50px",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',
											
											dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
											onSelect : function() {
												$(this).focus();
											}
										});
						$("#start_date")
								.datepicker(
										{
											showOn : "button",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',
											minDate : new Date(explode[0],
													explode[1] - 1, explode[2]),
											dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
											onSelect : function() {
												$(this).focus();
											}
										});

						$("#end_date")
								.datepicker(
										{
											showOn : "button",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',
											minDate : new Date(explode[0],
													explode[1] - 1, explode[2]),
											dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
											onSelect : function() {
												$(this).focus();
											}
										});

						$("#note_type").change(function() {

							if ($("#note_type").val() == 'general') {
								//alert('here'+$("#note_type").val());
								$("#to_be_billed_section").show()
							} else {
								$("#to_be_billed_section").hide();
							}
						});

						$('.drugText')
								.live(
										'focus',
										function() {
											var counter = $(this).attr(
													"counter");
											if ($(this).val() == "") {
												$("#Pack" + counter).val("");
											}
											$(this)
													.autocomplete(
															"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>",
															{
																width : 250,
																selectFirst : false,

															});

										});//EOF autocomplete

						$('.drugPack')
								.live(
										'focus',
										function() {
											var counter = $(this).attr(
													"counter");
											$(this)
													.autocomplete(
															"<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "getPack","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>",
															{
																width : 250,
																selectFirst : false,
																extraParams : {
																	drug : $(
																			"#drug"
																					+ counter)
																			.val()
																},
															});

										});//EOF autocomplete	  
						//add n remove drud inputs
						var counter = <?php echo $count?>;

						$("#addButton")
								.click(
										function() {
											/*if(counter>10){
											        alert("Only 10 textboxes allow");
											        return false;
											}  */
											//$("#patientnotesfrm").validationEngine('detach'); 
											var newCostDiv = $(
													document
															.createElement('tr'))
													.attr(
															"id",
															'DrugGroup'
																	+ counter);

											//var start= '<select style="width:80px;" id="start_date'+counter+'" class="" name="start_date[]"><input type="tex">';
											var route_option = '<select style="width:80px;" id="route'+counter+'" class="" name="route[]"><option value="">Select</option><option value="IV">IV</option><option value="IM">IM</option><option value="S/C">S/C</option><option value="P.O">P.O</option><option value="P.R">P.R</option><option value="P/V">P/V</option><option value="R.T">R.T</option><option value="LA">LA</option></select>';
											var fre_option = '<select style="width:80px;" id="frequency_'+counter+'" class="frequency" name="frequency[]"><option value="">Select</option><option value="SOS">SOS</option><option value="OD">OD</option><option value="BD">BD</option><option value="TDS">TDS</option><option value="QID">QID</option><option value="HS">HS</option><option value="Twice a week">Twice a week</option><option value="Once a week">Once a week</option><option value="Once fort nightly">Once fort nightly</option><option value="Once a month">Once a month</option><option value="A/D">A/D</option></select>';
											var quality_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
											var options = '<option value=""></option>';
											for (var i = 1; i < 25; i++) {
												if (i < 13) {
													str = i + 'am';
												} else {
													str = (i - 12) + 'pm';
												}
												options += '<option value="'+i+'"'+'>'
														+ str + '</option>';
											}

											timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
													+ options
													+ '</select></td> ';
											timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 80px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
													+ options
													+ '</select></td> ';
											timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
													+ options
													+ '</select></td> ';
											timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
													+ options
													+ '</select></td> ';
											timer = timerHtml1 + timerHtml2
													+ timerHtml3 + timerHtml4
													+ '</tr></table></td>';
											<?php //echo $this->Form->input('', array('type'=>'text','size'=>16, 'class'=>'my_start_date','name'=> 'start_date[]', 'id' =>"start_date".$i ,'counter'=>$i )); ?>
											var newHTml = '<td><input  type="text" value="" id="drug' + counter + '"  class=" drugText validate[optional,custom[onlyLetterNumber]] ac_input" name="drug[]" autocomplete="off" counter='+counter+'></td><td><input  type="text" value="" id="Pack' + counter + '"  class=" drugPack validate[optional,custom[onlyLetterNumber]] ac_input" name="Pack[]" autocomplete="off" size="16" counter='+counter+'></td><td><input  type="text" value="" id="start_date' + counter + '"  class=" my_start_date1" name="start_date[]"  size="16" counter='+counter+'></td><td><input  type="text" value="" id="end_date' + counter + '"  class="my_end_date1" name="end_date[]" autocomplete="off" size="16" counter='+counter+'></td><td>'
													+ route_option
													+ '</td><td>'
													+ fre_option
													+ '</td>'
													+ quality_opt
													+ '<td><input size="2" type="text" value="" id="dose'+counter+'" class="" name="dose[]"></td>'
													+ timer;

											newCostDiv.append(newHTml);
											newCostDiv.appendTo("#DrugGroup");
											//$("#patientnotesfrm").validationEngine('attach'); 			 			 
											counter++;
											if (counter > 0)
												$('#removeButton').show('slow');
										});

						$("#removeButton").click(function() {
							/*if(counter==3){
							  alert("No more textbox to remove");
							  return false;
							}  */
							counter--;

							$("#DrugGroup" + counter).remove();
							if (counter == 0)
								$('#removeButton').hide('slow');
						});

						/*	$(".my_start_date").livequery({
									alert('here');
							}); */

						/*$(".my_start_date").live({
							click: function() {
							$(this).after("<p>Another paragraph!</p>");
							});*/
						//EOF add n remove drug inputs

						

						//EOF add/remove medicine textboxes

						$('#note_type').change(function(data) {
							var selOpt = $(this).val();//current type selection
							
							if (selOpt == 'general') {
								$('#notes-link').hide('fast');
								$('#surgery-link').hide('fast');//display one by one 
								$('#implants-link').hide('fast');
								$('#event-note-link').hide('fast');
								$('#post-opt-link').hide('fast');
								$('#pre-opt-link').hide('fast');
								$('#notes').hide('fast');
								$('#surgery').hide('fast');//display one by one 
								$('#implants').hide('fast');
								$('#event-note').hide('fast');
								$('#post-opt').hide('fast');
								$('#pre-opt').hide('fast');
								$('#investigation-link').fadeIn('fast');
								$('#investigation1').fadeIn('fast');
								$('#treatment-link').fadeIn('slow');
								$('#present-cond-link').fadeIn('slow');
								$('#chief-link').fadeIn('slow');
								$('#subjective-link').fadeIn('slow');
								$('#objective-link').fadeIn('slow');
								$('#assessment-link').fadeIn('slow');
								$('#plan-link').fadeIn('slow');
								$('#finalization-link').fadeIn('slow');
								$('#intervention-link').fadeIn('slow');
								$('#rca-link').fadeIn('slow');
								$('#diagnostic-study').hide('fast');
								$('#risk_category_assessment').fadeIn('slow');
								
							} else if (selOpt == 'OT') {
								$('#investigation-link').hide('fast');
								$('#investigation1').hide('fast');
								$('#treatment-link').hide('fast');
								$('#notes-link').hide('slow');
								$('#investigation').hide('fast');
								$('#investigation2').hide('fast');
								$('#treatment').hide('fast');
								$('#notes').hide('fast');
								$('#present-cond-link').hide('fast');
								$('#chief-link').hide('slow');
								$('#subjective-link').hide('slow');
								$('#objective-link').hide('slow');
								$('#assessment-link').hide('slow');
								$('#plan-link').hide('slow');
								$('#finalization-link').hide('slow');
								$('#present-cond').hide('fast');
								$('#chief').hide('fast');
								$('#subjective').hide('fast');
								$('#objective').hide('fast');
								$('#assessment').hide('fast');
								$('#intervention-link').hide('fast');
								$('#rca-link').hide('fast');
								
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#post-opt-link').hide('fast');
								$('#post-opt').hide('fast');
								$('#pre-opt').hide('fast');
								$('#implants').hide('fast');
								$('#pre-opt-link').hide('fast');
								$('#surgery-link').fadeIn('500');//display one by one 
								$('#implants-link').fadeIn('1000');
								$('#event-note-link').fadeIn('1500');
								$('#risk_category_assessment').hide('fast');
								$('#category_assessment').hide('fast');
								
							} else if (selOpt == 'pre-operative') {
								$('#investigation-link').hide('fast');
								$('#investigation1').hide('fast');
								$('#treatment-link').hide('fast');
								$('#notes-link').hide('slow');
								$('#investigation').hide('fast');
								$('#investigation2').hide('fast');
								$('#treatment').hide('fast');
								$('#notes').hide('fast');
								$('#present-cond-link').hide('fast');
								$('#chief-link').hide('slow');
								$('#subjective-link').hide('slow');
								$('#objective-link').hide('slow');
								$('#assessment-link').hide('slow');
								$('#plan-link').hide('slow');
								$('#finalization-link').hide('slow');
								$('#present-cond').hide('fast');
								$('#chief').hide('fast');
								$('#subjective').hide('fast');
								$('#objective').hide('fast');
								$('#assessment').hide('fast');
								$('#intervention-link').hide('fast');
								$('#rca-link').hide('fast');
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#surgery').hide('500');//display one by one
								$('#surgery-link').hide('500');//display one by one 
								$('#implants').hide('1000');
								$('#implants-link').hide('1000');
								$('#event-note').hide('fast');
								$('#event-note-link').hide('1500');
								$('#post-opt-link').hide('1500');
								$('#post-opt').hide('1500');
								$('#pre-opt-link').fadeIn('2000');
								$('#risk_category_assessment').hide('fast');
								$('#category_assessment').hide('fast');
								
							} else if (selOpt == 'post-operative') {
								$('#investigation-link').hide('fast');
								$('#investigation1').hide('fast');
								$('#treatment-link').hide('fast');
								$('#notes-link').hide('slow');
								$('#investigation').hide('fast');
								$('#investigation2').hide('fast');
								$('#treatment').hide('fast');
								$('#notes').hide('fast');
								$('#present-cond-link').hide('fast');
								$('#chief-link').hide('slow');
								$('#subjective-link').hide('slow');
								$('#objective-link').hide('slow');
								$('#assessment-link').hide('slow');
								$('#plan-link').hide('slow');
								$('#finalization-link').hide('slow');
								$('#present-cond').hide('fast');
								$('#chief').hide('fast');
								$('#subjective').hide('fast');
								$('#objective').hide('fast');
								$('#assessment').hide('fast');
								$('#intervention-link').hide('slow');
								$('#rca-link').hide('slow');
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#surgery').hide('500');//display one by one
								$('#surgery-link').hide('500');//display one by one 
								$('#implants-link').hide('1000');
								$('#implants').hide('1000');
								$('#event-note-link').hide('1500');
								$('#event-note').hide('1500');
								$('#pre-opt-link').hide('fast');
								$('#pre-opt').hide('fast');
								$('#post-opt-link').fadeIn('2000');
								$('#risk_category_assessment').hide('fast');
								$('#category_assessment').hide('fast');

							} else {
								$('#surgery-link').hide('fast');//display one by one 
								$('#implants-link').hide('fast');
								$('#event-note-link').hide('fast');
								$('#post-opt-link').hide('fast');
								$('#pre-opt-link').hide('fast');
								$('#pre-opt').hide('fast');
								$('#investigation-link').hide('fast');
								$('#investigation1').hide('fast');
								$('#treatment-link').hide('fast');
								$('#present-cond-link').hide('fast');
								$('#chief-link').hide('slow');
								$('#subjective-link').hide('slow');
								$('#objective-link').hide('slow');
								$('#assessment-link').hide('slow');
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#present-cond').hide('fast');
								$('#chief').hide('slow');
								$('#subjective').hide('slow');
								$('#objective').hide('slow');
								$('#assessment').hide('slow');
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#surgery').hide('fast');//display one by one 
								$('#implants').hide('fast');
								$('#event-note').hide('fast');
								$('#post-opt').hide('fast');
								$('#investigation').hide('fast');
								$('#investigation2').hide('fast');
								$('#treatment').hide('fast');
								$('#pre-opt-link').hide('fast');
								$('#notes-link').fadeIn('slow');
								$('#intervention-link').hide('slow');
								$('#rca-link').hide('slow');
								$('#risk_category_assessment').hide('fast');
								$('#category_assessment').hide('fast');
							}
						});
						//BOF accordion
						$("#accordionCust")
								.accordion(
										{
											autoHeight: false,
											active : false,
											collapsible : true,
											//autoHeight : true,
											navigation : true,
											//fillSpace: true,
											change : function(event, ui) {

												//BOF template call
												var currentEleID = $(
														ui.newContent).attr(
														"id"); 
												var replacedID = "templateArea-"
														+ currentEleID;
												if(currentEleID != 'CPOE'){
								
												if (currentEleID == 'implants'
														|| currentEleID == 'event-note'
														|| currentEleID == 'treatment'
														|| currentEleID == 'notes'
														|| currentEleID == 'post-opt'
														|| currentEleID == 'surgery'
														|| currentEleID == 'investigation'
														|| currentEleID == 'investigation2'
														|| currentEleID == 'present-cond'
														|| currentEleID == 'chief'
														|| currentEleID == 'subjectiveorderset'
														|| currentEleID == 'objectiveorderset'
														|| currentEleID == 'assessment'
														|| currentEleID == 'plan'
														|| currentEleID == 'finalization'
														|| currentEleID == 'pre-opt'
														|| currentEleID == 'diagnostic-study'
														|| currentEleID == 'functional-result'
														|| currentEleID == 'intervention'
														|| currentEleID == 'category_assessment'
														|| currentEleID == 'cognitive'
														|| currentEleID == 'functional'
														|| currentEleID == 'aids'
														|| currentEleID == 'other'
														|| currentEleID == 'procedure_performed'
														|| currentEleID == 'device_used'
														|| currentEleID == 'symptoms'
														|| currentEleID == 'diagno_study'
															) {
													$("#" + replacedID).html($('#temp-busy-indicator').html());

													$("#templateArea-implants").html('');
													$("#templateArea-event-note").html('');
													$("#templateArea-treatment").html('');
													$("#templateArea-notes").html('');
													$("#templateArea-post-opt").html('');
													$("#templateArea-pre-opt").html('');
													$("#templateArea-investigation").html('');
													$("#templateArea-surgery").html('');
													$("#templateArea-present-cond").html('');
													$("#templateArea-chief").html('');
													$("#templateArea-subjectiveorderset").html('');
													$("#templateArea-objectiveorderset").html('');
													$("#templateArea-assessment").html('');
													$("#templateArea-plan").html('');
													$("#templateArea-finalization").html('');
													$("#templateArea-diagnostic-study").html('');
													$("#templateArea-functional-result").html('');
													$("#templateArea-intervention").html('');
													$("#templateArea-category_assessment").html('');
													$("#templateArea-cognitive").html('');
													$("#templateArea-functional").html('');
													$("#templateArea-aids").html('');
													$("#templateArea-other").html('');
													$("#templateArea-procedure_performed").html('');
													$("#templateArea-device_used").html('');
													$("#templateArea-symptoms").html('');
													$("#templateArea-diagno_study").html('');
													var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "add","admin" => false)); ?>";
													$("#" + currentEleID).css('height', 'auto'); 
													$
															.ajax({
																type : "POST",
																url : ajaxUrl
																		+ "/"
																		+ currentEleID,
																data : "updateID="
																		+ replacedID,
																context : document.body,
																beforeSend: function() {

														           	$("#temp-busy-indicator-"+currentEleID).show();
																	},
																	complete: function() {
																		$("#temp-busy-indicator-"+currentEleID).hide();
																	}, 
																success : function(data) {
																	alert("test");
																	$("#"+ replacedID).html(data);
																	$("#"+ replacedID).fadeIn();
																}
															});
												} else {    ////if closed
													$("#templateArea-implants")
															.html('');
													$(
															"#templateArea-event-note")
															.html('');
													$("#templateArea-treatment")
															.html('');
													$("#templateArea-notes")
															.html('');
													$("#templateArea-post-opt")
															.html('');
													$("#templateArea-pre-opt")
															.html('');
													$(
															"#templateArea-investigation")
															.html('');
													$("#templateArea-surgery")
															.html('');
													$(
															"#templateArea-present-cond")
															.html('');
													$("#templateArea-chief")
															.html('');
													$(
															"#templateArea-subjectiveorderset")
															.html('');
													$("#templateArea-objectiveorderset")
															.html('');
													$(
															"#templateArea-assessment")
															.html('');
													$("#templateArea-plan")
															.html('');
													$(
															"#templateArea-finalization")
															.html('');
													$(
													"#templateArea-finalization")
													.html('');

													$(
													"#templateArea-diagnostic-study")
													.html('');
													$(
													"#templateArea-functional-result")
													.html('');
													$(
													"#templateArea-intervention")
													.html('');
													$(
													"#templateArea-category_assessment")
													.html('');

													$(
													"#templateArea-cognitive")
													.html('');
													$(
													"#templateArea-functional")
													.html('');
													$(
													"#templateArea-aids")
													.html('');
													$(
													"#templateArea-other")
													.html('');
													$(
													"#templateArea-procedure_performed")
													.html('');

													$(
													"#templateArea-device_used")
													.html('');
													$(
													"#templateArea-symptoms")
													.html('');
													$(
													"#templateArea-diagno_study")
													.html('');
													
													
												}  

												}else{
												//	$("#"+replacedID).html($('#temp-busy-indicator').html());
													
												$("#templateArea-implants").html('');
												$("#templateArea-event-note").html('');
												$("#templateArea-treatment").html('');
												$("#templateArea-notes").html('');
												$("#templateArea-post-opt").html('');
												$("#templateArea-pre-opt").html('');
												$("#templateArea-investigation").html('');
												$("#templateArea-surgery").html('');
												$("#templateArea-present-cond").html('');
												$("#templateArea-chief").html('');
												$("#templateArea-subjective").html('');
												$("#templateArea-objective").html('');
												$("#templateArea-assessment").html('');
												$("#templateArea-plan").html('');
												$("#templateArea-finalization").html('');
												$("#templateArea-finalization").html('');
												$("#templateArea-diagnostic-study").html('');
												$("#templateArea-functional-result").html('');
												$("#templateArea-intervention").html('');
												$("#templateArea-category_assessment").html('');
												$("#templateArea-cognitive").html('');
												$("#templateArea-functional").html('');
												$("#templateArea-aids").html('');
												$("#templateArea-other").html('');
												$("#templateArea-procedure_performed").html('');
												$("#templateArea-device_used").html('');
												$("#templateArea-symptoms").html('');
												$("#templateArea-diagno_study").html('');
												
												var patient_id = $('#Patientsid').val();
											 	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'diagnoses', "action" => "investigation","admin" => false)); ?>"+"/"+patient_id;
												
											 	
													$.ajax({  
											 			  type: "POST",						 		  	  	    		
														  url: ajaxUrl,
														  beforeSend: function() {

													           	$("#temp-busy-indicator1").show();
																},
																complete: function() {
																	$("#temp-busy-indicator1").hide();
																},
														  success: function(data){	
															  $("#CPOE").html(data);
															 $("#CPOE").css("height","auto");								   		
														  }
														});
												} ////else close
												//EOF template call
											}

										});
						function resizeElementHeight(element) {
							  var height = 0;
							  var body = window.document.body;
							  if (window.innerHeight) {
							      height = window.innerHeight;
							  } else if (body.parentElement.clientHeight) {
							      height = body.parentElement.clientHeight;
							  } else if (body && body.clientHeight) {
							      height = body.clientHeight;
							  }
							  element.style.height = ((height - element.offsetTop) + "px");
							}
													
						//EOF accordion
						//binds form submission and fields to the validation engine
						$(".drugText").addClass(
								"validate[optional,custom[onlyLetterNumber]]");
						jQuery("#patientnotesfrm").validationEngine();

						jQuery("#patientnotesfrm").submit(
								function() {

									var returnVal = jQuery("#patientnotesfrm")
											.validationEngine('validate');
									//	var singleCheck = jQuery('#drug0')..validationEngine('validate');	

									if (returnVal) {
										ajaxPost('patientnotesfrm',
												'list_content');
									}
								});

						function ajaxPost(formname, updateId) {
							var patient_id = $('#Patientsid').val();
							

							$
									.ajax({
										data : $("#" + formname)
												.closest("form").serialize(),
										dataType : "html",
										beforeSend : function() {
											// this is where we append a loading image
											$('#busy-indicator').show('fast');
										},
										success : function(data, textStatus) {
											
											$('#busy-indicator').hide('slow');
											$("#" + updateId).html(data);

										},
										type : "post",
										url : "<?php echo $this->Html->url((array('controller'=>'patients','action' => 'orderset')));?>"+"/"+patient_id
									});
						}

						//BOF timer
						$('.frequency').live(
								'change',
								function() {

									id = $(this).attr('id');
									currentCount = id.split("_");
									currentFrequency = $(this).val();
									$('#first_' + currentCount[1]).val('');
									$('#second_' + currentCount[1]).val('');
									$('#third_' + currentCount[1]).val('');
									$('#forth_' + currentCount[1]).val('');
									//set timer
									switch (currentFrequency) {
									case "BD":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1])
												.removeAttr('disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "TDS":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1])
												.removeAttr('disabled');
										$('#third_' + currentCount[1])
												.removeAttr('disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "QID":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1])
												.removeAttr('disabled');
										$('#third_' + currentCount[1])
												.removeAttr('disabled');
										$('#forth_' + currentCount[1])
												.removeAttr('disabled');
										break;
									case "OD":
									case "HS":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "Once fort nightly":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "Twice a week":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "Once a week":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "Once a month":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "A/D":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									}

								});

						$('.first').live(
								'change',
								function() {
									currentValue = Number($(this).val());
									id = $(this).attr('id');
									currentCount = id.split("_");
									currentFrequency = $(
											'#frequency_' + currentCount[1])
											.val();
									hourDiff = 0;
									//set timer
									switch (currentFrequency) {
									case "BD":
										hourDiff = 12;
										break;
									case "TDS":
										hourDiff = 6;
										break;
									case "QID":
										hourDiff = 4;
										break;
									}

									switch (hourDiff) {
									case 12:
										$('#second_' + currentCount[1]).val(
												currentValue + 12);
										break;
									case 6:
										$('#second_' + currentCount[1]).val(
												currentValue + 6);
										$('#third_' + currentCount[1]).val(
												currentValue + 12);
										break;
									case 4:

										$('#second_' + currentCount[1]).val(
												currentValue + 4);
										$('#third_' + currentCount[1]).val(
												currentValue + 8);
										$('#forth_' + currentCount[1]).val(
												currentValue + 12);
										break;
									}
								});
						//EOF timer 
					});
	//----open fancyBox from icd icon----
	
		function icdwin() { 
			var patient_id = $('#Patientsid').val();
			//alert(patient_id);
			if (patient_id == '') {
				alert("Please select patient");
				return false;
			}
			$
					.fancybox({

						'width' : '70%',
						'height' : '120%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>" + '/' + patient_id
								
					});

		}

		


		function icdwin_intervention() {
			var patient_id = $('#Patientsid').val();
			//alert(patient_id);
			if (patient_id == '') {
				alert("Please select patient");
				return false;
			}
			$
					.fancybox({

						'width' : '70%',
						'height' : '120%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed_intervention")); ?>" + '/' + patient_id
								
					});

		}


		function icdwin_risk() {
			var patient_id = $('#Patientsid').val();
			//alert(patient_id);
			if (patient_id == '') {
				alert("Please select patient");
				return false;
			}
			$
					.fancybox({

						'width' : '70%',
						'height' : '120%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed_risk")); ?>" + '/' + patient_id
								
					});

		}


		
	function openbox(icd,note_id) {
		///---split for sending via url
		icd = icd.split("::");
		var patient_id = $('#Patientsid').val();
		 
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$
				.fancybox({

					'width' : '40%',
					'height' : '80%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
							 + '/' + patient_id + '/' + icd  + '/'+note_id 
				});

	}


	function openbox_intervention(icd,note_id) {

		var patient_id = $('#Patientsid').val();
		 
		/*$("a").click(function(event) {
			randomID = event.target.html ;
			alert(randomID);
	        $("#place_holder_smowmat").val(randomID);
	    });*/
		//custom_snow_id =  $("#place_holder_smowmat").val(); 
	     
		
		
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$
				.fancybox({

					'width' : '40%',
					'height' : '80%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis_intervention")); ?>"
							 + '/' + patient_id + '/' + icd + '/'+note_id 
				});

	}

	
	




	function changecolor() {
		//alert("hello");
		var getchange = "Hypertension Recorded";
		document.getElementById("cr").innerHTML = getchange;
		document.getElementById("cr").style.color = "green";
	}
	//--------------------------------------------- -to use live() in datepicker---------------------------------


	var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
		var explode = admissionDate.split('-');
		$(".my_start_date1").live("click",function() {
			
					$(this).datepicker({
								changeMonth : true,
								changeYear : true,
								yearRange : '1950',
								minDate : new Date(explode[0], explode[1] - 1,
										explode[2]),
								dateFormat: '<?php echo $this->General->GeneralDate(false);?>',
								showOn : 'button',
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
								buttonImageOnly : true,
								onSelect : function() {
									$(this).focus();
								}
							});
		});

		$('#encounter').change(function(){
		    $.ajax({
		      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getNoteDetail", "admin" => false)); ?>"+"/"+$(this).val(),
		      context: document.body,          
		      success: function(data){ 			      
			      var data1 = eval(data);			 	  
			      var TEMP=data1[0].Note.temp;
			      var PR=data1[0].Note.pr;
			      var RR=data1[0].Note.rr;
			      var BP=data1[0].Note.bp;
			      var spo2=data1[0].Note.spo2;
			      var cc=data1[0].Note.cc; 
			      var subject=data1[0].Note.subject;
			      var object=data1[0].Note.object;
			      var assis=data1[0].Note.assis;
			      var plan=data1[0].Note.plan;
			      var ht=data1[0].Note.ht;
			      var wt=data1[0].Note.wt;
			      var bmi=data1[0].Note.bmi;
			      var post_opt=data1[0].Note.post_opt;
			      var event_note=data1[0].Note.event_note;
			      var pre_opt=data1[0].Note.pre_opt;
			      var note=data1[0].Note.note;
			      var implants=data1[0].Note.implants;
			      var surgery=data1[0].Note.surgery;
			      var investigation=data1[0].Note.investigation;
			      var final1=data1[0].Note.final;
				      //alert(final1);
				  
			      document.getElementById('TEMP').value = TEMP;
			      document.getElementById('PR').value = PR;
			      document.getElementById('RR').value = RR;
			      document.getElementById('BP').value = BP; 
			      document.getElementById('spo2').value = spo2;
			      document.getElementById('cc').value = cc;
			      document.getElementById('subject_desc').value = subject;
			      document.getElementById('objective_desc').value = object;
			      document.getElementById('assessment_desc').value = assis;
			      document.getElementById('plan_desc').value = plan;
			      document.getElementById('height').value = ht;
			      document.getElementById('weight').value = wt;
			      document.getElementById('bmi').value = bmi;
			      document.getElementById('event_note_desc').value = event_note;
			      document.getElementById('post-opt_desc').value = post_opt;
			      document.getElementById('pre-opt_desc').value = pre_opt;
			      document.getElementById('notes_desc').value = note;
			      document.getElementById('implants_desc').value = implants;
			      document.getElementById('surgery_desc').value = surgery;
			      document.getElementById('investigation_desc').value = investigation;
			    //  document.getElementById('final1').value= '1';
			    document.getElementById('Nutritional counseling').checked = false;
			    document.getElementById('Physical activity counseling').checked = false;
			    document.getElementById('B.M.I - NOT DONE (Medical Reason)').checked = false;
			    document.getElementById('B.M.I - NOT DONE (System Reason)').checked = false;
			    document.getElementById('B.M.I - NOT DONE (Patient Reason)').checked = false;
			    
			      document.getElementById(final1).checked = true;
			      
			     // document.example.test.checked=true
		     $('#id').val(data);
		     
		    
		   
		      }
		    });
		   });
		
		var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
		var explode = admissionDate.split('-');
		$(".my_end_date1").live("click",function() {
			
					$(this).datepicker({
								changeMonth : true,
								changeYear : true,
								yearRange : '1950',
								minDate : new Date(explode[0], explode[1] - 1,
										explode[2]),
								dateFormat: '<?php echo $this->General->GeneralDate(false);?>',
								showOn : 'button',
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											onSelect : function() {
												$(this).focus();
											}
										});
					});
	//---------------------------------------------end of the datepicker------------------------------------------------
</script>
<script type="text/javascript">

	
	

	jQuery(document).ready(function() {

		var height, /*height_in_meter,*/weight, bmi, message;
		jQuery.fn.checkBMI = function() {
			// on load set bmi
			height = jQuery("#height").val();
			weight = jQuery("#weight").val();

			bmi = weight / (height * height) * 703;
			if(height== ''){
				jQuery("#bmi").val("");
			}else{
				if(isNaN(height) || isNaN(weight))
					 jQuery("#bmi").val("");
					else
					 jQuery("#bmi").val(bmi);	
			}
			if (bmi < 18.5) {
				message = "Underweight";
			} else if (bmi > 18.5 && bmi <= 23) {
				message = "Normal";
			} else if (bmi >= 23.1 && bmi <= 30) {
				message = "Overweight";
			} else if (bmi >= 30) {
				message = "Obese";
			}
			jQuery("#bmiStatus").html(message);
		};
		jQuery("#bmi").checkBMI();

		jQuery('#height, #weight').change(function() {
			jQuery("#bmi").checkBMI();
		});

	});



//function setvalue() {
		//name= $("#description").text() ;
      	//alert('name');
       // $("#inter_snow").html(name);		
//}

function changeTest_inter() {
		

      	var name = $("#icd9cm_inter option:selected").text() ;
      	//alert(name);
      	var code = $("#icd9cm_inter").val();
	splitted= code.split("|");
	
		$("#inter_snow").val(name);
		
}


	
// Cognitive funtion releted js code

	function createTitle(data){
		 var options = '';
		  $.each(data, function(index, name) {
		  options += '<option value=' + index + '>' + name + '</option>';
		 });
		 return options;
		 }
	 
	function snomed_LabRAd_test() 
	{ 
		var searchtest = $('#search_cog').val();
		//alert(searchtest);
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "billings", "action" => "snowmed",$patientid,"admin" => false)); ?>";
		
		  //var formData = $('#diagnosisfrm').serialize();
		   $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+searchtest,
	            //data: formData,
	            dataType: 'html',
	            success: function(data){
		             
		            // return ;
	            data = JSON && JSON.parse(data) || $.parseJSON(data);
	            	
	            	titleData = createTitle(data.testTitle);
	            	
	            	codeIndex = data.testCode;
	            	SctCode = data.SctCode;
	            	LonicCode = data.LonicCode;//alert(data.LonicCode);
	            	//alert(SctCode+"sctcocde");

	            	$('#SelectLeft').html(titleData);
	            },
				error: function(message){
	                alert("Internal Error Occured. Unable To Save Data.");
	            },       
	            });
	      
	      return false;
		
	}
	function changeTest() 
	{
		var e = document.getElementById("SelectLeft");
	    var strUser = e.options[e.selectedIndex].text; 
		testnameIndex = e.selectedIndex;
		document.getElementById("cog_snomed_code").value = SctCode[testnameIndex];
		$('#cog_name').val(strUser);
	}
	

	$("#func_name").change(function(){
		if($(this).val() == ''){
			$("#SelectLeft").attr('disabled','');
		}else{
			$("#cog_snomed_code").val($(this).val());
			$("#SelectLeft").attr('disabled','disabled');
			$('#cog_name').val($("#func_name option:selected").text());
		}
	});

	$("#stopdose_datetime")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});

	 $("#firstdose_datetime")
     .datepicker(
                     {
                             showOn : "button",
                             buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                             buttonImageOnly : true,
                             changeMonth : true,

                             changeYear : true,

                             dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
                             'float' : 'right',        
                             onSelect : function() {
                                     $(this).focus();
                                     //foramtEnddate(); //is not defined hence commented
                             }
                             
                     });	

	


// Js code for functional status

	function createTitle(data){
		 var options = '';
		  $.each(data, function(index, name) {
		  options += '<option value=' + index + '>' + name + '</option>';
		 });
		 return options;
		 }
	 


   function change_diag_type(diagtype)
   {
   if(diagtype=="1")
   {
     $("#lowback").show();
     $("#neckpain").hide();
     $("#upper").hide();
     $("#lower").hide();
     $("#kneepain").hide();
   }
   if(diagtype=="2")
   {
     
     $("#lowback").hide();
     $("#neckpain").show();
     $("#upper").hide();
     $("#lower").hide();
     $("#kneepain").hide();
   }
   if(diagtype=="3")
   {
     
     $("#lowback").hide();
     $("#neckpain").hide();
     $("#upper").show();
     $("#lower").hide();
     $("#kneepain").hide();
   }
   if(diagtype=="4")
   {
    
     $("#lowback").hide();
     $("#neckpain").hide();
     $("#upper").hide();
     $("#lower").show();
     $("#kneepain").hide();
   }
   if(diagtype=="31")
   {
     
     $("#lowback").hide();
     $("#neckpain").hide();
     $("#upper").hide();
     $("#lower").hide();
     $("#kneepain").show();
   }

  
    
   }

//------------------------
	function callDragon(notetype){
		

		$
		.fancybox({
			'width' : '50%',
			'height' : '50%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "dragon")); ?>"+'/'+ notetype
		});
		 
	}

	function display_orderset(diagnosis_type_id,department_id){
		
		
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "displayorderset","admin" => false)); ?>";
		   var formData = $('#patientnotesfrm').serialize();
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+diagnosis_type_id+"/"+department_id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
		           
		         				
		        $("#orderset_mainid").html(data);
		        
		        
	            },
				error: function(message){
					alert("Error in Retrieving data");
	            }        });
	      
	      return false; 
	}
</script>
