<?php 
//debug($getPanelSubLab);
if($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 2){
//echo 'Please wait we are fixing Histopathology issue';
//dpr($getPanelSubLab);exit;
//exit;
?>
 
<style>

/* body{
	overflow:hidden;
	
} */

</style>

<?php
}
?>
<?php
	//echo $this->Html->script ( 'jquery.autocomplete' );
	//echo $this->Html->css ( 'jquery.autocomplete.css' );
	?>
<?php
echo $this->Html->script ( array (
				'jquery.fancybox-1.3.4',
				'jquery.tooltipster.min.js',
				 
				) );
				echo $this->Html->css ( array (
				'jquery.fancybox-1.3.4.css',
				'tooltipster.css' 
				) );

				?>
				<?php

				$orderId = $this->params->query ['testOrderId'];
				// debug($orderId);exit;
				?>
				<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
			 
				
<style>
				
.red {
	color: red !important;
}

.orange {
	color: orange !important;
}

.green {
	color: green !important;
}

/*----- Tabs -----*/
.tabs {
	width: 100%;
	display: inline-block;
	
}

/*----- Tab Links -----*/ /* Clearfix */
.tab-links:after {
	display: block;
	clear: both;
	content: '';
}

.tab-links li {
	margin: 0px 1px;
	float: left;
	list-style: none;
}

.tab-links a {
	padding: 6px 5px;
	display: inline-block;
	border-radius: 3px 3px 0px 0px;
	background: #7FB5DA;
	font-size: 11px;
	font-weight: 600;
	color: #4c4c4c;
	transition: all linear 0.15s;
}

.tab-links a:hover {
	background: #a7cce5;
	text-decoration: none;
}

li.active a,li.active a:hover {
	background: #fff;
	color: #4c4c4c;
}

/*----- Content of Tabs -----*/
.tab-content {
	padding: 15px;
	border-radius: 3px;
	box-shadow: -1px 1px 1px rgba(0, 0, 0, 0.15);
	background: #fff;
}

.tab {
	display: none;
}

.tab.active {
	display: block;
}

.tdLabellableCustom {
	color: #000;
	font-size: 14px;
}

.errorAbnormal {
	border: 1px solid red;
}

.Tbody {
	height: 500px;
	overflow: auto;
}
.ui-widget-content{
	color:#222222 !important;
	font-size:12px;
}
 <?php if ($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 1){?>
body{
	height:370px !important;
	overflow:hidden !important;
} 
<?php }
?>
.topHeadTabs td{
	font-size:13px !important;
	border-right:1px solid #31859c;
	padding-left:5px;

}
.entryTabScroll thead>tr{
position:relative;
display:block;
}
.entryTabScroll tbody{
display:block;

overflow:auto;
}
.tab-links{
	margin-left:0px;
	padding-left:0px;

}
</style>



				<?php

				echo $this->Form->create ( 'LaboratoryResult', array (
		'type' => 'file',
		'id' => 'labfrm',
		'inputDefaults' => array (
				'label' => false,
				'legend' => false,
				'fieldset' => false 
				)
				) );

				?>
				<?php if ($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 2) {
					$borderBottom = ' border-bottom: 1px solid;';
				}else{
					$borderBottom = '';
				} 	?>
<div
	style="width: 90%; margin: auto; margin-right: auto; margin-top:20px;">
<table class="topHeadTabs" width="100%" border="0" cellspacing="0" cellpadding="0"
	style="border-right: 1px solid; border-top: 1px solid; border-left: 1px solid;<?php echo $borderBottom?>; margin-left: auto; margin-right: auto;">
	<tr>
		<!--<td align="" valign="middle" class="tdLabellableCustom " id="boxspace"><b><?php echo __("Patient Name :");?></b></td> -->
		<td align="" valign="middle" class="lableCustom" id="boxspace"
			style="text-align: left;"><?php echo $patientData['Patient']['lookup_name'];?>
		</td>
		<!--<td align="" valign="middle" class="tdLabellableCustom " id="boxspace"><b><?php echo __("Patient ID :");?></b></td> -->
		<td align="" valign="middle" class="lableCustom" id="boxspace"
			style="text-align: left;"><?php echo $patientData['Patient']['patient_id'];?>
		</td>
		<!--<td align="" valign="middle" class="tdLabellableCustom " id="boxspace"><b><?php echo __("Request No. :");?></b></td> -->
		<td align="" valign="middle" class="lableCustom" id="boxspace"
			style="text-align: left;"><?php echo $patientData['LaboratoryTestOrder']['req_no'];?>
		</td>
		<!--<td align="" valign="middle" class="tdLabellableCustom " id="boxspace"><b><?php echo __("Age/Sex :");?></b></td> -->
		<td align="" valign="middle" class="lableCustom" id="boxspace"
			style="text-align: left;"><?php echo $patientData['Patient']['age'].' / '.ucfirst($patientData['Patient']['sex']);?>
		</td>
		<!--<td align="" valign="middle" class="tdLabellableCustom " id="boxspace"><b><?php echo __("Type :");?></b></td> -->
		<td align="" valign="middle" class="lableCustom" id="boxspace"
			style="text-align: left;"><?php echo $patientData['Patient']['admission_type'].' / '.strtoupper($patientData['TariffStandard']['name']);?>
		</td>
		<!--<td align="" valign="middle" class="tdLabellableCustom " id="boxspace"><b><?php echo __("Ref By :");?></b></td> -->
		<?php 
		if($getPanelSubLab['0']['UserVertual']['first_name'] ){
			$RefBy = $getPanelSubLab['0']['UserVertual']['first_name'] . ' ' .$getPanelSubLab['0']['UserVertual']['last_name'] ;
		}else{
			$RefBy = $getPanelSubLab['0']['User']['first_name']. ' ' .$getPanelSubLab['0']['User']['last_name'] ;
		}
		?>
		<td align="" valign="middle" class="lableCustom" id="boxspace"
			style="text-align: left;"><?php echo ucwords($RefBy);?>
		</td>
	</tr>

</table>
<?php if ($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 1){
		$isClinicalhistoEntryMode = "display:inline-block;overflow-y: scroll;height:435px;";
	}
?>
				<?php
				//debug($getPanelSubLab);
				if ($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 1) { 	
				
				?> <!-- Non Histopathology Test starts -->
				<table width="100%" border="0" cellspacing="0" cellpadding="0"

	class="formFull" id="">

<tr>

		<th colspan="10"><?php

		

		$i = 0;

		echo __ ( "Lab Results" );

		if (! empty ( $authUser )) { // $authUser = all uathenticated usesr



			$login_user = $this->Session->read ( 'userid' ); // logined user

			if (in_array ( $login_user, $authUser )) {

				$disabled = false;

			} else {

				$disabled = true;

			}

		}else{

			$disabled = true;

		}

		 

		$unserializeAuth = unserialize($getPanelSubLab[0]['LaboratoryResult']['authenticated_by']);

		 

			if(in_array($this->Session->read ( 'userid' ), $unserializeAuth)){  

				$chkedAuth = 'checked';

			}else{ 

				$chkedAuth = '';

			}

 

		echo $this->Form->input ( '', array (

			'name' => "LaboratoryResult[$i][is_authenticate]",

			'type' => 'checkbox',

			'div' => false,

			'label' => false,

			'style' => "margin-left:50px;",

			'disabled' => $disabled,

			'id' => 'isAuthenticateChecked',

			'class' => 'isAuthenticate forSignature',

			//'checked'=>$getPanelSubLab[0]['LaboratoryResult']['is_authenticate']

			'checked'=>$chkedAuth

			) );

			?> Authenticated Result</th>

		
	</tr> 
	</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull " id=""  style="<?php echo $isClinicalEntryMode;?>" >
	
	<tbody class="Tbody">

	<?php
	// if(!empty($getPanelSubLab[0]['LaboratoryResult']['id'])||isset($getPanelSubLab[0]['LaboratoryResult']['id'])){
	// $this->Form->hidden('',array('id'=>'forChk','val'=>'1'));
	foreach ( $getPanelSubLab as $key => $subData ) {
	$j = 0;
	// if($subData['Laboratory']['name']){ //laboratory name

	// /}
	//exit;

	if (strtoupper ( trim($subData ['TestGroup'] ['name']) ) == 'SEROLOGY') {
	?>
	<tr>
			<td width="30%" valign="middle" class="tdLabel" id=""><b><?php echo __("INVESTIGATION");?></b>
			</td>
			<td width="20%" valign="middle" class="tdLabel" id="" align="center"><b><?php echo __("OBSERVED VALUE");?></b>
			</td>
			<td width="20%" valign="middle" class="tdLabel" id=""><b><?php echo __("UNITS");?></b>
			</td>
			<td width="30%" valign="middle" class="tdLabel" id=""><b><?php echo __("NORMAL RANGE");?></b>
			</td>
		</tr>
	<?php if(count($subData ['LaboratoryParameter']) > 1){?>
	<tr>
		<td width="" valign="middle" class="tdLabel" id=""><?php echo $subData['Laboratory']['name'];?>
		</td>
		</tr>
		<?php } ?>
		<?php
			
		////$prArray = $subData ['LaboratoryParameter'];
		//usort ( $prArray, create_function ( '$a, $b', 'if ($a["id"] == $b["id"]) return 0; return ($a["id"] < $b["id"]) ? -1 : 1;' ) );
		//$subData ['LaboratoryParameter'] = $prArray;
		foreach ( $subData ['LaboratoryParameter'] as $paraKey => $value ) {
			//to show parameter result
			$resultToDisplay = '';
			foreach ( $subData ['LaboratoryHl7Result'] as $paraKeyResult => $valueResult ) {
				if($valueResult['laboratory_parameter_id']==$value['id']){ 
					$resultToDisplay = $valueResult['result'] ; 
				}
			} 

		?>
 		<tr>
			<td width="" valign="middle" class="tdLabel" id=""><span
				style="padding-left: 10px;"><?php echo $value['name'];?></span></td>
			<td width="" valign="middle" class="tdLabel" id=""><b><?php

			echo $this->Form->hidden ( '', array (
					'name' => "LaboratoryResult[$i][is_authenticate]",
					'value' => $subData ['LaboratoryResult'] ['is_authenticate'],'type' => 'text',
					'class'=>'hiddenAuthenticate'
					) );


					echo $this->Form->hidden ( '', array (
							'name' => "LaboratoryResult[$i][authenticated_by]",'type' => 'text',
							//'value' => $subData ['LaboratoryResult'] ['authenticated_by'],
							'class'=>'authenticated_by'
					) );

					echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][laboratory_id]",
						'value' => $subData ['Laboratory'] ['id'] 
					) );
					echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][lab_type]",
								'value' => $subData ['Laboratory'] ['lab_type'],
								'type' => 'text') );
					echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][patient_id]",
						'value' => $subData ['LaboratoryTestOrder'] ['patient_id'] 
					) );
					echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][laboratory_test_order_id]",
						'value' => $subData ['LaboratoryTestOrder'] ['id'] 
					) );
					echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][user_id]",
						'value' => $doctorData ['User'] ['id'] 
					) );
					echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][create_time]",
						'value' => date ( "Y-m-d H:i:s" ) 
					) );
					echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][id]",
						'value' => $subData ['LaboratoryResult'] ['id']/* $subData['LaboratoryHl7Result'][$paraKey]['laboratory_result_id'] */) );
					// echo $this->Form->hidden('', array('name'=>"LaboratoryResult[$i][is_authenticate]",'value'=>'','id'=>'isAuthenticate','class'=>'isAuthenticate'));
					echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][op_name]",
						'value' => $doctorData ['User'] ['first_name'] . $doctorData ['User'] ['last_name'] 
					) );

/*~~~~~~~~~~~~  */
$isMultiple = false;$defaultResultParamRes= '';
//if (empty ( $defaultResultParam )) {
if ($value ['type'] == 'text') {
	if ($value ['is_multiple_options']) {
		$isMultiple = true;
		$defaultRange = '';
		$splitString = explode ( ",", $value ['parameter_text'] );
		$opArr = array ();
		foreach ( $splitString as $key => $val ) {
			$opArr [str_replace ( '"', "'", $val )] = str_replace ( '"', "'", $val );
		}
		$defaultResultParamRes = $value ['parameter_text'];
	} else {
		$defaultResultParamRes = $value ['parameter_text'];
	}
	// print_r($opArr);exit;
}else{

 

/*  */
if ($value ['by_gender_age'] == 'gender') {
	if($patientData['Patient']['age'] <= Configure::read('PatienntAge')){
		$defaultRange = $value ['by_gender_child_lower_limit'] . " - " . $value ['by_gender_child_upper_limit'];
		$newDefaultRange = $value ['by_gender_child_default_result'];

	}elseif (strtolower($patientData['Person']['sex']) == 'male') { // if male
		$defaultRange = $value ['by_gender_male_lower_limit'] . " - " . $value ['by_gender_male_upper_limit'];
		$defaultResultParam = $value ['by_gender_male_default_result'];
		$newDefaultRange = $value ['by_gender_male_default_result'];
	} elseif (strtolower($patientData['Person']['sex']) == 'female'){ // female pArt
		$defaultRange = $value ['by_gender_female_lower_limit'] . " - " . $value ['by_gender_female_upper_limit'];
		$newDefaultRange = $value ['by_gender_female_default_result'];
	}
}

/*  */
} 
	if ($value ['type'] == 'text') { 
		if ($isMultiple) {  
				$requiredClass = '';
				echo $this->Form->input ( 'result', array (
									'options' => $opArr,
									'empty' => 'Please Select',
									'div' => false,
									'name' => "LaboratoryHl7Result[$i][$j][result]",
									//'value' => ($subData ['LaboratoryHl7Result'] [$paraKey] ['result']) ? $subData ['LaboratoryHl7Result'] [$paraKey] ['result'] : $newDefaultRange,
									'value' => ($resultToDisplay) ? $resultToDisplay : $newDefaultRange,
									'class' => 'multiplyBy formulaId_' . $value ["id"] . ' getBlurId getVal ' . $classNames . ' ' . $requiredClass,
									'type' => 'select',
									'label' => false,
									'id' => "result-" . $i . _ . $j,
									'autocomplete' => 'off',
									'style="100%"' 
									) );
									echo $this->Form->hidden ( 'formulaCalc', array (
									'id' => "formulaCalc_" . $value ["id"],
									'name' => "LaboratoryHl7Result[$i][$j][formulaCalc]",
									'value' => $value ['formula'] 
									) );
												 
				}else{ 
	/*~~~~~~~~~~~  */
	
					if($value['is_descriptive']){
						$typeTxt = 'textarea';
					}else{
						$typeTxt = 'text';
					}
					
					
					//'value' => ($subData ['LaboratoryHl7Result'] [$paraKey] ['result']) ? $subData ['LaboratoryHl7Result'] [$paraKey] ['result'] : $value ['parameter_text'],
					echo $this->Form->input ( '', array (
						'div' => false,
						'name' => "LaboratoryHl7Result[$i][$j][result]",
						'value' => ($resultToDisplay) ? $resultToDisplay : $value ['parameter_text'],
						'class' => 'formulaId_' . $value ["id"] . ' getBlurId getVal validate[required,custom[mandatory-enter]] textBoxExpnd' . $classNames,
						'type' => $typeTxt,
						'label' => false, 
						'style' => 'width:200px;',
						'id' => "result-" . $i . _ . $j,
						'autocomplete' => 'off' 
						) )/*  . ' ' . $unitData */;
				}
		}else{ 
				echo $this->Form->input ( 'result', array (
				'div' => false,
				'name' => "LaboratoryHl7Result[$i][$j][result]",
				//'value' => ($subData ['LaboratoryHl7Result'] [$paraKey] ['result']) ? $subData ['LaboratoryHl7Result'] [$paraKey] ['result'] : $newDefaultRange,
				'value'=> ($resultToDisplay) ? $resultToDisplay : $newDefaultRange,
				'class' => 'multiplyBy formulaId_' . $value ["id"] . ' getBlurId getVal textBoxExpnd' . $classNames . ' ' . $requiredClass,
				'type' => $typeTxt,
				'label' => false,
				'style' => 'width:200px;',
				'id' => "result-" . $i . _ . $j,
				'autocomplete' => 'off'
		) );
		
	}						
						echo $this->Form->hidden ( '', array (
								'id' => "formulaCalcDec_" . $value ["id"],
								'name' => "LaboratoryHl7Result[$i][$j][decimal]",
								'value' => $value ['decimal'],
								'disabled'=>'disabled'
						) );
						echo $this->Form->hidden ( '', array (
						'id' => "formulaCalc_" . $value ["id"],
						'name' => "LaboratoryHl7Result[$i][$j][formulaCalc]",
						'value' => $value ['formula'] 
						) );
						echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryHl7Result[$i][$j][laboratory_parameter_id]",
						'value' => $value ['id'] 
						) );
						echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryHl7Result[$i][$j][laboratory_test_order_id]",
						'value' => $subData ['LaboratoryTestOrder'] ['id'] 
						) );
						echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryHl7Result[$i][$j][laboratory_id]",
						'value' => $value ['laboratory_id'] 
						) );
						echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryHl7Result[$i][$j][id]",
						'value' => $subData ['LaboratoryHl7Result'] [$paraKey] ['id'] 
						) );
						$unitData = '';
						?></b> 
						 
						<?php
						$prevResultsString = implode ( " </br> ", $prevResultArray [$value ['id']] );
						$prevResultsString = trim ( trim ( $prevResultsString ), "|" );

						
						
						if ($prevResultsString) {
						$prevResultsString = '<b>' . $prevResultsString . '</br>';
						?> <?php
						echo $this->Html->image ( 'icons/laboratory_result_icon.png', array (
							'width' => '16',
							'height' => '16',
							'class' => 'tooltip',
							'title' => $prevResultsString 
						) );
						?> <?php
						}
						$prevResultsString = '';
						?></td>
						
						
						<?php $unitData = ($optUcums [$value ['unit']]) ? $optUcums [$value ['unit']] : $value ['unit_txt'];?>
						<td style=" <?php echo $isPrintedFirstTimeStyle;?>" class="tdLabel" valign="middle"  >
				<?php echo $isPrintedFirstTime;?> <?php echo $unitData?></td>
				
				
						<td width="" valign="middle" class="tdLabel" id="" style="<?php echo $isPrintedFirstTimeStyle;?>">
				<?php echo $isPrintedFirstTime;?> <?php
				echo trim($defaultRange,"")?></td>
		</tr>
		<?php
		$j ++;
		}
		
			
		// if($subData['Laboratory']['notes_display_text']){

		if ($subData ['LaboratoryResult'] ['text']) {
			$isOpinion = 'checked';
			$isOpinionDisplay = 'display:block';
		} else {
			if($subData ['Laboratory'] ['notes']){
				$isOpinion = 'checked';
				$isOpinionDisplay = 'display:block';
			}else{
				$isOpinion = '';
				$isOpinionDisplay = 'display:none';
			}
		}
		?>

		<tr>
			<!--<td colspan="4"><table width="100%">
			<tr>-->
			<td width="20%" valign="middle" class="tdLabel" id=""><b> <?php

			echo ($subData ['Laboratory'] ['notes_display_text']) ? $subData ['Laboratory'] ['notes_display_text'] : __ ( 'Comment' );
			echo $this->Form->input ( '', array (
					'checked' => $isOpinion,
					'name' => "LaboratoryResult[$i][is_opinion]",
					'value' => $subData ['Laboratory'] ['opinion'],
					'type' => 'checkbox',
					'div' => false,
					'label' => false,'width'=>'150%',
					'style' => "margin-left:14px;",
					'id' => 'isOpinion_' . $subData ['Laboratory'] ['id'],
					'class' => 'isOpinion' 
					) );

					?></b></td>
			<td width="80%" valign="middle" class="tdLabel" id="" colspan="3"><?php
			$widthVar='width:90% !important';
			echo $this->Form->input ( '', array (
					'style' => $isOpinionDisplay.';'.$widthVar,
					'rows' > '4',
					'columns' => '4',
					'name' => "LaboratoryResult[$i][text]",
					'value' => ($subData ['LaboratoryResult'] ['text']) ? $subData ['LaboratoryResult'] ['text'] : $subData ['Laboratory'] ['notes'],
					'type' => 'textarea',
					'div' => false,
					'label' => false,
					'id' => 'opinion_' . $subData ['Laboratory'] ['id'],
					'class' => 'opinion' 
					) );
					?></td>
			<!--</tr>
			<table>
			</td>-->
		</tr>

		<?php  $i ++;//}?>
		<?php
	} else {  ?> 
		<tr>
			<td width="30%" valign="middle" class="tdLabel" id=""><b><?php echo __("INVESTIGATION");?></b>
			</td>
			<td width="20%" valign="middle" class="tdLabel" id="" align="center"><b><?php echo __("OBSERVED VALUE");?></b>
			</td>
			<td width="20%" valign="middle" class="tdLabel" id=""><b><?php echo __("UNITS");?></b>
			</td>
			<td width="30%" valign="middle" class="tdLabel" id=""><b><?php echo __("NORMAL RANGE");?></b>
			</td>
		</tr>
		
		<?php
			$laboratoryName = $subData ['Laboratory'] ['name'];
		?>

			<tr>
				<td width="" valign="middle" class="tdLabel" id=""
					style="width: 37%; font-size: 16px;" colspan="0"><b> <?php echo $subData['Laboratory']['name'];?>
				</b></td>
			</tr>
			<?php
			foreach ( $subData ['LaboratoryCategory'] as $labCatKey => $labCatValue ) {
			$isPrinted = 1;
			
			
			?>


			<?php
			//$prArray = $subData ['LaboratoryParameter'];
			//usort ( $prArray, create_function ( '$a, $b', 'if ($a["id"] == $b["id"]) return 0; return ($a["id"] < $b["id"]) ? -1 : 1;' ) );
			//$subData ['LaboratoryParameter'] = $prArray;
			 //debug($subData ['LaboratoryParameter']);exit;
			foreach ( $subData ['LaboratoryParameter'] as $paraKey => $value ) {
			
			$defaultRange = '';
			$newDefaultRange = '';
			$resultToDisplay = '';
			
			foreach ( $subData ['LaboratoryHl7Result'] as $paraKeyResult => $valueResult ) {
				if($valueResult['laboratory_parameter_id']==$value['id']){
					$resultToDisplay = $valueResult['result'] ;
				}
			}
			/*
			echo $this->Form->hidden ( '', array (
							'name' => "LaboratoryHl7Result[$i][$j][laboratory_parameter_id]",
							'value' => $value ['id'] 
			) );
			echo $this->Form->hidden ( '', array (
							'name' => "LaboratoryHl7Result[$i][$j][laboratory_test_order_id]",
							'value' => $subData ['LaboratoryTestOrder'] ['id'] 
			) );
			echo $this->Form->hidden ( '', array (
							'name' => "LaboratoryHl7Result[$i][$j][laboratory_id]",
							'value' => $value ['laboratory_id'] 
			) );
			echo $this->Form->hidden ( '', array (
							'name' => "LaboratoryHl7Result[$i][$j][id]",
							'value' => $subData ['LaboratoryHl7Result'] [$paraKey] ['id'] 
			) );
			*/
			$defaultRange = '';$defaultResultParam ='';

			if ($value ['laboratory_categories_id'] == $labCatValue ['id']) {
			// echo $paraKey;

			if ($value ['type'] == 'text') {
				if ($subData ['Laboratory'] ['lab_type'] == 1 ) {
					$newDefaultRange =  $value ['parameter_text']  ;
				} else { 
					$newDefaultRange = $value ['parameter_text_histo'];
				}
			} else {
			if ($value ['by_gender_age'] == 'gender') {
			if($patientData['Patient']['age'] <= Configure::read('PatienntAge')){
			$defaultRange = $value ['by_gender_child_lower_limit'] . " - " . $value ['by_gender_child_upper_limit'];
			$newDefaultRange = $value ['by_gender_child_default_result'];

			}elseif (strtolower($patientData['Person']['sex']) == 'male') { // if male
			$defaultRange = $value ['by_gender_male_lower_limit'] . " - " . $value ['by_gender_male_upper_limit'];
			$defaultResultParam = $value ['by_gender_male_default_result'];
			$newDefaultRange = $value ['by_gender_male_default_result'];
			} elseif (strtolower($patientData['Person']['sex']) == 'female'){ // female pArt
			$defaultRange = $value ['by_gender_female_lower_limit'] . " - " . $value ['by_gender_female_upper_limit'];
			$newDefaultRange = $value ['by_gender_female_default_result'];
			}
			}else
			if ($value ['by_gender_age'] == 'age') { // by Age
			//@TODO
			//$patientData ['Person'] ['dob'] = "2014-01-24";
			$calAge = $this->General->convertYearsMonthsToDays($this->DateFormat->formatDate2STDForReport($patientData ['Person'] ['dob'],Configure::read('date_format')) ,'dob','days');

			//echo $calAge;
			//echo $this->General->convertYearsMonthsToDays($value ['by_age_num_more_years'],strtolower(preg_replace("/[()]/","",$value ['by_age_days_more'])),'days');exit;
			//echo ;
			if(strtolower($patientData['Person']['sex']) == 'male'){
			if (($value ['by_age_num_less_years']) && ($value ['by_age_less_years'] == 1) && ($calAge < $this->General->convertYearsMonthsToDays($value ['by_age_num_less_years'],strtolower(preg_replace("/[()]/","",$value ['by_age_days_less'])),'days'))) {
			$defaultRange = $value ['by_age_num_less_years_lower_limit'] . " - " . $value ['by_age_num_less_years_upper_limit'];
			$defaultResultParam = $value ['by_age_num_less_years_default_result'];
			$newDefaultRange = $value ['by_age_num_less_years_default_result'];

			}
			if (($value ['by_age_days_more']) && ($value ['by_age_more_years'] == 1) && (($calAge > $value ['by_age_num_more_years']) || (strtolower(preg_replace("/[()]/","",$value ['by_age_days_more'])) == 'days') && (($calAge > $this->General->convertYearsMonthsToDays($value ['by_age_num_more_years'],strtolower(preg_replace("/[()]/","",$value ['by_age_days_more_female'])),'days'))))) {
			$defaultRange = $value ['by_age_num_gret_years_lower_limit'] . "  -" . $value ['by_age_num_gret_years_upper_limit'];
			$defaultResultParam = $value ['by_age_num_gret_years_default_result'];
			$newDefaultRange = $value ['by_age_num_gret_years_default_result'];
			}
			}else{
			if (($value ['by_age_num_less_years_female']) && ($value ['by_age_less_years_female'] == 1) && ($calAge < $this->General->convertYearsMonthsToDays($value ['by_age_num_less_years_female'],strtolower(preg_replace("/[()]/","",$value ['by_age_days_less_female'])),'days'))) {
			$defaultRange = $value ['by_age_num_less_years_lower_limit_female'] . " - " . $value ['by_age_num_less_years_upper_limit_female'];
			$defaultResultParam = $value ['by_age_num_less_years_default_result_female'];
			$newDefaultRange = $value ['by_age_num_less_years_default_result_female'];

			}
			if (($value ['by_age_num_more_years_female']) && ($value ['by_age_more_years_female'] == 1) && (($calAge > $value ['by_age_num_more_years_female']) || (strtolower(preg_replace("/[()]/","",$value ['by_age_days_more_female'])) == 'days') && (($calAge > $this->General->convertYearsMonthsToDays($value ['by_age_num_more_years_female'],strtolower(preg_replace("/[()]/","",$value ['by_age_days_more_female'])),'days'))))) {
			$defaultRange = $value ['by_age_num_gret_years_lower_limit_female'] . "  -" . $value ['by_age_num_gret_years_upper_limit_female'];
			$defaultResultParam = $value ['by_age_num_gret_years_default_result_female'];
			$newDefaultRange = $value ['by_age_num_gret_years_default_result_female'];
			}

			}
			{
			/* $defaultRange = $value ['by_age_between_years_lower_limit'] . " - " . $value ['by_age_between_years_upper_limit'];
			 $defaultResultParam = $value ['by_age_between_years_default_result']; */
			$unSzLower = array_values(unserialize($value ['by_age_between_num_less_years']));
			$unSzUpper = array_values(unserialize($value['by_age_between_num_gret_years']));
			$unSzLowerFemale = array_values(unserialize($value ['by_age_less_years_female']));
			$unSzUpperFemale = array_values(unserialize($value['by_age_more_years_female']));
			$daysYearsMonths = array_values(unserialize(unserialize($value['by_age_days_between'])));
			$unSzLowerAge = array_values(unserialize($value['by_age_between_years_lower_limit']));
			$unSzUpperAge = array_values(unserialize($value['by_age_between_years_upper_limit']));
			$unSzresultDefault= array_values(unserialize($value['by_age_between_years_default_result']));
			$unSzByAgeSex= array_values(unserialize($value['by_age_sex']));

			if($unSzLower){
			for($ageCount=0;$ageCount<count($unSzLower);){
			if(strtolower($unSzByAgeSex[$ageCount]) == strtolower($patientData['Person']['sex'])){
			//echo strtolower(preg_replace("/[()]/","",$daysYearsMonths[$ageCount])).'hello'.$this->General->convertYearsMonthsToDays($unSzLower[$ageCount],strtolower(preg_replace("/[()]/","",$daysYearsMonths[$ageCount])),'days');
			if(($this->General->convertYearsMonthsToDays($unSzLower[$ageCount],strtolower(preg_replace("/[()]/","",$daysYearsMonths[$ageCount])),'days') < $calAge) && ($this->General->convertYearsMonthsToDays($unSzUpper[$ageCount],strtolower(preg_replace("/[()]/","",$daysYearsMonths[$ageCount])),'days') > $calAge)){
			$defaultRange = $unSzLowerAge[$ageCount]. " - " .$unSzUpperAge[$ageCount];
			$newDefaultRange = $unSzresultDefault[$ageCount];
			}
			}

			$ageCount++;
			}

			}
			//$defaultRange = $value ['by_age_between_years_lower_limit'] . " - " . $value ['by_age_between_years_upper_limit'];

			}
			$defaultResultParam = rtrim ( trim ( $defaultResultParam ), "-" );
			}
			else
				if ($value ['by_gender_age'] == 'range') {

				if (($value ['by_range_less_than'] == 1)) {
					$defaultRange.= '< ' . $value ['by_range_less_than_limit'].' '. $value ['by_range_less_than_interpretation']."<br>";
				} 
				

				if(($value ['by_range_between'] == 1)) {
					$unSzLowerRange= array_values(unserialize($value ['by_range_between_lower_limit']));
					$unSzUpperRange= array_values(unserialize($value ['by_range_between_upper_limit']));
					$unSzInterRange= array_values(unserialize($value['by_range_between_interpretation']));
					$implodeRangeArray = '';
					if($unSzLowerRange){
						for($rangeCount=0;$rangeCount<count($unSzLowerRange);){
							$implodeRangeArray .= $unSzLowerRange[$rangeCount].'-'.$unSzUpperRange[$rangeCount].' '.$unSzInterRange[$rangeCount].'</br>';
							$rangeCount++;
						}
					}
					//$implodeRangeArray = implode(" ", $rangeArray);
					$defaultRange.= $implodeRangeArray;
				}
				
				if (($value ['by_range_greater_than'] == 1)) {
					$defaultRange.= '> ' . $value ['by_range_greater_than_limit'].' '.$value ['by_range_greater_than_interpretation']."<br>";
				}
			}
			$defaultRangeBck = trim ( $defaultRange );
			$defaultRange = rtrim ( trim ( $defaultRange ), "-" );
			}
			?>

			<tr>

				<td width="" valign="middle" class="tdLabel" id="">
				<div><?php
				if ($isPrinted) {
				echo "<i><b>" . $labCatValue ['category_name'] . "</b></i>";
				$isPrinted = 0;
				if ($labCatValue ['is_category']) {
				$isPrintedFirstTime = '<div style="padding-top:8px;">&nbsp;</div>';
				$isPrintedFirstTimeStyle = "padding-top:6px";
				}
				}
				?></div>
				<div style="padding-left:20px;<?php echo $isPrintedFirstTimeStyle;?>">

				<?php
				// if($laboratoryName){ //laboratory name

								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][is_authenticate]",
								'value' => $subData ['LaboratoryResult'] ['is_authenticate'],
								'class'=>'hiddenAuthenticate'
								) );
								echo $this->Form->hidden ( '', array (
										'name' => "LaboratoryResult[$i][authenticated_by]",
										//'value' => $subData ['LaboratoryResult'] ['authenticated_by'],
										'class'=>'authenticated_by'
								) );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][laboratory_id]",
								'value' => $subData ['Laboratory'] ['id'],
								'type' => 'text' 
								) );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][patient_id]",
								'value' => $subData ['LaboratoryTestOrder'] ['patient_id'],
								'type' => 'text' 
								) );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][laboratory_test_order_id]",
								'value' => $subData ['LaboratoryTestOrder'] ['id'],
								'type' => 'text' 
								) );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][user_id]",
								'value' => $doctorData ['User'] ['id'],
								'type' => 'text' 
								) );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][create_time]",
								'value' => date ( "Y-m-d H:i:s" ),
								'type' => 'text' 
								) );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][id]",
								'value' => $subData ['LaboratoryResult'] ['id'],
								'type' => 'text') );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][op_name]",
								'value' => $doctorData ['User'] ['first_name'] . $doctorData ['User'] ['last_name'],
								'type' => 'text' 
								) );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][lab_type]",
								'value' => $subData ['Laboratory'] ['lab_type'],
								'type' => 'text') );

								// }

								if ($labCatValue ['is_category']) {
								echo $value ['name']; // attribute name
								}
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryHl7Result[$i][$j][laboratory_parameter_id]",
								'value' => $value ['id'],
								'type' => 'text' 
								) );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryHl7Result[$i][$j][laboratory_test_order_id]",
								'value' => $subData ['LaboratoryTestOrder'] ['id'],
								'type' => 'text' 
								) );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryHl7Result[$i][$j][laboratory_id]",
								'value' => $value ['laboratory_id'],
								'type' => 'text' 
								) );
								echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryHl7Result[$i][$j][id]",
								'value' => $subData ['LaboratoryHl7Result'] [$paraKey] ['id'],
								'type' => 'text' 
								) )?></div>
				</td>

				<td width="" valign="middle" class="tdLabel" id="">
				<div style="padding-left:26px;display: block;<?php echo $isPrintedFirstTimeStyle;?>" id="">
				<?php echo $isPrintedFirstTime;?> <?php
				$unitData = ($optUcums [$value ['unit']]) ? $optUcums [$value ['unit']] : $value ['unit_txt'];
				// echo $this->Form->hidden('',array('id'=>'attrName-'.$i._.$j,'class'=>'attrName','value'=>$value['name']));
				$className = $str = str_replace ( ' ', '_', $value ['name'] );
				$classNames = $str = str_replace ( '.', '_', $className );
				if ($value ['is_mandatory'] == '1') {
				$requiredClass = "validate[required,custom[mandatory-enter]]";
				} else {
				$requiredClass = "";
				}
				$isMultiple = false;$defaultResultParamRes= '';
				//if (empty ( $defaultResultParam )) {
				if ($value ['type'] == 'text') {
					if ($value ['is_multiple_options']) {
						$isMultiple = true;
						$defaultRange = '';
						$splitString = explode ( ",", $value ['parameter_text'] );
						$opArr = array ();
						foreach ( $splitString as $key => $val ) {
							$opArr [str_replace ( '"', "'", $val )] = str_replace ( '"', "'", $val );
						}
						$defaultResultParamRes = $value ['parameter_text'];
					} else {
						$defaultResultParamRes = $value ['parameter_text'];
					}
				// print_r($opArr);exit;
				}
				//}
				// pr($subData['LaboratoryHl7Result']);exit;

				if ($isMultiple) { 
				echo $this->Form->input ( 'result', array (
									'options' => $opArr,
									'empty' => 'Please Select',
									'div' => false,
									'name' => "LaboratoryHl7Result[$i][$j][result]",
									//'value' => ($subData ['LaboratoryHl7Result'] [$paraKey] ['result']) ? $subData ['LaboratoryHl7Result'] [$paraKey] ['result'] : $newDefaultRange,
									'value'=> ($resultToDisplay) ? $resultToDisplay : $newDefaultRange,
									'class' => 'multiplyBy formulaId_' . $value ["id"] . ' getBlurId getVal ' . $classNames . ' ' . $requiredClass,
									'type' => 'select',
									'label' => false,
									'id' => "result-" . $i . _ . $j,
									'autocomplete' => 'off',
									'style="100%"' 
									) );
									echo $this->Form->hidden ( 'formulaCalc', array (
									'id' => "formulaCalc_" . $value ["id"],
									'name' => "LaboratoryHl7Result[$i][$j][formulaCalc]",
									'value' => $value ['formula'] 
									) );
												 
				} else {
					if($value['is_descriptive']){
						$typeTxt = 'textarea';
					}else{
						$typeTxt = 'text';
					}
				$defaultRangeBck = explode ( " - ", $defaultRangeBck );
				if (($subData ['LaboratoryHl7Result'] [$paraKey] ['result'] < $defaultRangeBck [0]) || ($subData ['LaboratoryHl7Result'] [$paraKey] ['result'] > $defaultRangeBck [1]))
				$classNames .= ' errorAbnormal';
					
				echo $this->Form->input ( 'result', array (
									'div' => false,
									'name' => "LaboratoryHl7Result[$i][$j][result]",
									//'value' => ($subData ['LaboratoryHl7Result'] [$paraKey] ['result']) ? $subData ['LaboratoryHl7Result'] [$paraKey] ['result'] : $newDefaultRange,
									'value'=> ($resultToDisplay) ? $resultToDisplay : $newDefaultRange,
									'class' => 'multiplyBy formulaId_' . $value ["id"] . ' getBlurId getVal textBoxExpnd' . $classNames . ' ' . $requiredClass,
									'type' => $typeTxt,
									'label' => false,
									'style' => 'width:200px;',
									'id' => "result-" . $i . _ . $j,
									'autocomplete' => 'off' 
									) ) /* . ' ' . $unitData */;
									echo $this->Form->hidden ( 'formulaCalc', array (
									'id' => "formulaCalc_" . $value ["id"],
									'name' => "LaboratoryHl7Result[$i][$j][formulaCalc]",
									'value' => $value ['formula'] 
									) );
									//if($value['name'] == "Absolute Neutrophilic count") {dpr($value ['decimal']);exit;}
									echo $this->Form->hidden ( '', array (
											'id' => "formulaCalcDec_" . $value ["id"],
											'name' => "LaboratoryHl7Result[$i][$j][decimal]",
											'value' => $value ['decimal'],
											'disabled'=>'disabled'
									) );


				}

				?> <!-- <?php
						//~~~Gulshan
				/* foreach($prevResultArray as $key=>$value){
					$prevResultsString .= "<tr><td>$key</td><td>$value</td></tr>";
				}
				if($prevResultsString){
					$prevResultsString = "<table><tr><th>Date</th><th>Result</th>".$prevResultsString.$prevResultsString; */
						//~~~Gulshan
				?> --> <?php
				$prevResultsString = implode ( " </br> ", $prevResultArray [$value ['id']] );
				$prevResultsString = trim ( trim ( $prevResultsString ), "|" );
				if ($prevResultsString) {
				$prevResultsString = '<b>' . $prevResultsString . '</br>';
				?> <span style="float: left;padding-right:10px; "> <?php
				echo $this->Html->image ( 'icons/laboratory_result_icon.png', array (
									'width' => '16',
									'height' => '16',
									'class' => 'tooltip',
									'title' => $prevResultsString 
				) );
				?> </span> <?php
				}
				$prevResultsString = '';
				?></div>
				</td>

				<td style=" <?php echo $isPrintedFirstTimeStyle;?>" class="tdLabel" valign="middle"  >
				<?php echo $isPrintedFirstTime;?> <?php echo $unitData?></td>


				<td width="" valign="middle" class="tdLabel" id="" style="<?php echo $isPrintedFirstTimeStyle;?>">
				<?php echo $isPrintedFirstTime;?> <?php
				echo trim($defaultRange,"")/*  . ' ' . $unitData */;
				echo $this->Form->hidden ( 'Laboratory.calcRange', array (
								'label' => false,
								'div' => false,
								'id' => 'calcRange-' . $i . _ . $j,
								'value' => $defaultRange 
				) );
				echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryHl7Result[$i][$j][range]",
								'label' => false,
								'id' => 'range-' . $i . _ . $j,
								'value' => $defaultRange,
								'readonly' => 'readonly' 
								) );
								if ($value ['type'] != 'text')
								echo $this->Form->hidden ( 'abnormal_flagDisplay', array (
									'name' => "LaboratoryHl7Result[$i][$j][abnormal_flagDisplay]",
									'class' => '',
									'style' => 'width:150px; float:left;',
									'id' => 'abnormal_flagDisplay-' . $i . _ . $j,
									'autocomplete' => 'off' 
									) );
									echo $this->Form->hidden ( 'abnormal_flag', array (
								'name' => "LaboratoryHl7Result[$i][$j][abnormal_flag]",
								'id' => 'abnormal_flag-' . $i . _ . $j,
								'class' => 'abnormal_flag',
								'value' => $subData ['LaboratoryHl7Result'] [$paraKey] ['abnormal_flag'] 
									) );
									?> <?php echo $this->Form->hidden('',array('name'=>"LaboratoryHl7Result[$i][$j][is_authenticate]",'type'=>'text','label'=>false,'id'=>'is_authenticate-'.$i._.$j,'class'=>'is_authenticate_class','value'=>$subData['LaboratoryHl7Result'][$paraKey]['is_authenticate']))?>

				</td>
				

			</tr>
			<?php

			$laboratoryName = '';
			$isPrintedFirstTime = '';
			$defaultRange = '';
			$unitData = '';
			$j ++;
			unset ( $value ['id'] );
			} // End of Laboratory Parameter
			} // End of if
			?>

			<?php
			}
			// if($subData['Laboratory']['notes_display_text']){
			 
			if ($subData ['LaboratoryResult'] ['text']) {
				$isOpinion = 'checked';
				$isOpinionDisplay = 'display:block';
				$isDisabledDisplay = '';
				
			} else {
				if($subData ['Laboratory'] ['notes']){
					$isOpinion = 'checked';
					$isOpinionDisplay = 'display:block';
					$isDisabledDisplay = '';
				}else{
					$isOpinion = '';
					$isOpinionDisplay = 'display:none';
					$isDisabledDisplay = 'disabled';
				}
			}
			?>

			<tr>
				<td colspan="4">
				<table width="100%" cellspacing="0" cellpadding="0" border="0" id="" class=" ">
				<tr>
				<td width="20%" valign="middle" class="tdLabel" id=""><b> <?php

				echo ($subData ['Laboratory'] ['notes_display_text']) ? $subData ['Laboratory'] ['notes_display_text'] : __ ( 'Comment' );
				echo $this->Form->input ( '', array (
					'checked' => $isOpinion,
					'name' => "LaboratoryResult[$i][is_opinion]",
					'value' => $subData ['Laboratory'] ['opinion'],
					'type' => 'checkbox',
					'div' => false,
					'label' => false,
					'style' => "margin-left:14px;",'width'=>'150%',
					'id' => 'isOpinion_' . $subData ['Laboratory'] ['id'],
					'class' => 'isOpinion' 
					) );

					?></b></td>
				<td width="80%" valign="middle" class="tdLabel" id="" colspan="2"><?php
				$widthVar='width:90%';
				echo $this->Form->input ( '', array (
					'disabled' => $isDisabledDisplay,
					'style' => $isOpinionDisplay.'; '.$widthVar, 
					'rows' > '4',
					'columns' => '4',
					'name' => "LaboratoryResult[$i][text]",
					'value' => ($subData ['LaboratoryResult'] ['text']) ? $subData ['LaboratoryResult'] ['text'] : $subData ['Laboratory'] ['notes'],
					'type' => 'textarea',
					'div' => false,
					'label' => false,
					'id' => 'opinion_' . $subData ['Laboratory'] ['id'],
					'class' => 'opinion' 
					) );
					?></td>
				</tr>
				</table>
				
				</td>
			</tr>
			<?php //}?>
			<?php

			$i ++;
	} // end of serology departent check
	?>
			<tr>
				<td
					style="border-bottom: 1px solid; line-height: 5px; padding-top: 10px"
					colspan="4">&nbsp;</td>
			</tr>
			<?php
	
	}// End of Laboratory Main Loop
	// }else{	?>
			
			<?php
			// }
			?>
                        
			<!-- Browse buton 1-->
			<tr>
				<td><?php
				foreach ( $dataLabImg as $temData ) {
				if ($temData ['PatientDocument'] ['filename']) {
				$id = $temData ['PatientDocument'] ['id'];
				echo "<p id=" . "icd_" . $id . " style='padding:0px 10px;'>";
				$replacedText = $temData ['PatientDocument'] ['filename'];
				echo $this->Html->link ( $replacedText, '/uploads/laboratory/' . $temData ['PatientDocument'] ['filename'], array (
					'escape' => false,
					'target' => '__blank',
					'style' => 'text-decoration:underline;' 
					) );
					echo $this->Html->link ( $this->Html->image ( '/img/icons/cross.png' ), array (
					'action' => 'delete_report',
					$temData ['PatientDocument'] ['patient_id'],
					$id,
					$orderId 
					), array (
					'escape' => false,
					"align" => "right",
					"id" => "$id",
					"title" => "Remove",
					"style" => "cursor: pointer;",
					"alt" => "Remove",
					"class" => "radio_eraser" 
					), 'Are you sure ?' );
					echo "</p>";
				}
				}
				?></td>
			</tr>
			<?php //if($getPanelSubLab[0]['LaboratoryResult']['is_authenticate']){?>
			<tr>
				<td>
				<table id='addTr'>
					<tr>
						<td><?php 

						echo $this->Form->input('',array('name'=>'data[PatientDocument][file_name][]','type'=>'file','class' => 'browse','id'=>'browse_1' ));?>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td><?php echo $this->Html->image('icons/plus_6.png',array('id'=>'addButton'))?></td>
			</tr> 
			<?php //}?>
		 
</tbody>
</table>

<!-- Non Histopathology Test ends --> <?php
				}
				if ($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 2) {
				?> <!--  Histopathology Test start --> <?php
//debug($getPanelSubLab[0]['LaboratoryResult']['authenticated_by']);exit;
				foreach ( $getPanelSubLab as $keyHisto => $histoData ) {
//debug($histoData);exit;

				$labType = $histoData ['Laboratory'] ['lab_type']?>
<div class="inner_title">
<h3><?php //echo __('Service Request Search', true); 
$histoGroupsArr = Configure::read('lab_histo_template_sub_groups');//$subData ['Laboratory'] ['name']
echo ucwords($histoGroupsArr[$getPanelSubLab[0]['Laboratory']['histo_sub_categories']]).' - '.$getPanelSubLab[0]['Laboratory']['name'];
?></h3>
</div>

<div class="tabs"><!-- Navigation header -->
<ul class="tab-links">
<?php 

$count = 1;
foreach ( $histoData ['LaboratoryParameter'] as $keyParas => $tab ) {
	 $login_user = $this->Session->read ( 'userid' );
	if($login_user != Configure::read('YogeshMistryId') && $login_user != Configure::read('AjayJunnarkarId')){ //only for Yogesh Mistry And Ajay JunnarkarIduser 
		if($histoData['LaboratoryResult']['authenticated_by']){
	
			if($tab['name'] == "Lab Notes"){
				$count = (count($histoData ['LaboratoryParameter']));
				$class = "active";
				$tabDisable = '';
				$templateDisable = "disabled";
				$browseDisable = "disabled";
				
			}else{
				$class = "inactive";
				$tabDisable = 'disabled';
				$templateDisable ="";
				$browseDisable = "";
				
			}
		}else{
			if ($count == 1) {
				$class = "active";
			} else {
				$class = "";
			}
		}
	}else{
		if ($count == 1) {
			$class = "active";
		} else {
			$class = "";
		}
	} 
	
	/*  if ($count == 1) {
		$class = "active";
	} else {
		$class = "";
	} */ 
	
?>
<?php //foreach ($result['LaboratoryParameter'] as $keyParas => $tab){?>
	<li fieldno="<?php echo $count; ?>" class="<?php echo $class; ?>  tabingClassByTabLI labNote" id="tabName_<?php echo $count?>" ><a fieldno="<?php echo $count; ?>" class="tabingClassByTab" href="#tab<?php echo $count;?>" disabled="<?php echo $tabDisable?>"> <?php echo $tab['name']; //for displaying the tab or attribute?>
	</a></li>
	<?php //}?>
	<?php

	$count = $count + 1;
}
?>
</ul>
<!-- Navigation header End --> <?php
// echo $this->Form->create('',array('id'=>'Save-Form'));
echo $this->Form->create ( 'LaboratoryResult', array (
				'type' => 'file',
				'id' => 'labfrmH',
				'inputDefaults' => array (
						'label' => false,
						'legend' => false,
						'fieldset' => false 
)
) );
?> <?php

	if (! empty ( $authUser )) { // $authUser = all uathenticated usesr
		$login_user = $this->Session->read ( 'userid' ); // logined user
		if (in_array ( $login_user, $authUser )) {
			$disabled = false;
		} else {
			$disabled = true;
		}
	}
	$unserializeAuthHisto = unserialize($histoData['LaboratoryResult']['authenticated_by']);
	//debug($getPanelSubLab);
	/* if(in_array($this->Session->read ( 'userid' ), $unserializeAuthHisto)){
		$chkedAuthHisto = 'checked';
	}else{
		$chkedAuthHisto = '';
	} */

	  
	if($disabled == false){ 
		if($histoData['LaboratoryResult']['is_authenticate']){
			$disabled = true;
		}else{
			$disabled = false;
		}	
	}

	
	?> <?php echo $this->Form->input('LaboratoryResult.is_authenticate',array(
			'type'=>'checkbox',
			'div'=>false,
			'label'=>false,
			'style'=>"margin-left:50px;", 
			'checked'=>true, 
			'id'=>'histo_is_authenticate',
			'class'=>'forSignature'));?>
	Authenticated Result
	<?php echo $this->Form->hidden('LaboratoryResult.authenticated_by',array('type'=>'text','div'=>false,'label'=>false,'style'=>"margin-left:50px;",'class'=>'authenticated_by'/* ,'value'=>$histoData['LaboratoryResult']['authenticated_by'] */));?>
		 
				<?php 
				 
				 $reportDate  =($histoData['LaboratoryResult']['report_date'])?$histoData['LaboratoryResult']['report_date']:date('Y-m-d H:i:s')  ;	
				 $reportDate  = $this->DateFormat->formatDate2Local($reportDate,Configure::read('date_format'),true);
				echo $this->Form->input('from', array(
															'id' => 'report_date', 
															'name' => "LaboratoryResult[report_date]",
															'label'=> false, 
															'value' =>$reportDate ,
															'div' => false, 
															'error' => false,
															'autocomplete'=>false,
															'class'=>'textBoxExpnd',
															'readonly'=>'readonly', 
															'div' => false,
															'type'=>'text',
															'title'=>'From'),false);
				?>
			 
	<?php 
		if($histoData['LaboratoryResult']['is_authenticate'] == '1'){
			echo $this->Form->hidden('LaboratoryResult.is_authenticate_alter',array('type'=>'text','div'=>false,'label'=>false,'style'=>"margin-left:50px;",'class'=>'is_authenticate_alter','value'=>$histoData['LaboratoryResult']['is_authenticate']));
			
		}?>

<table  >
	<tr>

<?php 	
	foreach($previousHisto as $keyPreHisto => $preHisto){

			if($perviousLaboratoryTestOrder){
				$perviousLaboratoryTestOrderID = $perviousLaboratoryTestOrder;
			}else{
				$perviousLaboratoryTestOrderID = $this->params->query['testOrderId'];
			}
			if($preHisto['LaboratoryTestOrder']['id'] == $perviousLaboratoryTestOrder){
				$color = 'color: red';
				$title = 'Current';
			}else{
				$color = 'color: blue';
				$title = 'Previous';
			}
			
			?>
		 <td style=" border-style: solid; border-width: 1px; <?php echo $color;?>" title="<?php echo $title;?> "><b><?php  echo $this->Html->link($preHisto['LaboratoryTestOrder']['req_no'],array('controller'=>'NewLaboratories','action'=>'histoEntryMode','?'=>array('testOrderId'=>$preHisto['LaboratoryTestOrder']['id'],'perviousLaboratoryTestOrder'=>$perviousLaboratoryTestOrderID)));?></b></td>
	<?php }?>
	</tr>
</table>

<div>
<table style="margin-left: 10px;">
	<tr>
		<td><?php echo __("Template");?></td>
		<td><?php 
		//echo $this->Form->input('LaboratoryResult.result_publish_date',array('id'=>'printDate','type'=>'text','div'=>false,'label'=>false));
		echo $this->Form->input('DoctorTemplate.template',array('id'=>'searchForTemplate','class'=>'searchForTemplate','type'=>'text','div'=>false,'label'=>false,'style'=>'width:400px;height:20px;','disabled'=>$templateDisable));
		echo $this->Form->hidden('DoctorTemplate.department_id',array('id'=>'department_id','class'=>'department_id','type'=>'text','div'=>false,'label'=>false,'style'=>'width:400px;height:20px;','value'=>$getPanelSubLab['0']['Laboratory']['histo_sub_categories']));
		echo $this->Form->hidden('DoctorTemplate.template_name',array('id'=>'searchForTemplateAlt','class'=>'searchForTemplateAlt','type'=>'text','div'=>false,'label'=>false,'style'=>'width:400px;height:20px;' ));
		echo $this->Form->hidden('DoctorTemplate.doctor_template_id',array('id'=>'searchForTemplateId','class'=>'searchForTemplateId','type'=>'text','div'=>false,'label'=>false,'style'=>'width:400px;height:20px;'));
		?></td>
                <td><?php echo $this->Html->image('icons/save_histo_template.png',array('id'=>'save_histo_template','type'=>'save_histo_template','title'=>'Save Template'));?></td>
                <td id="showFlashMessage" style="color: #0066FF"></td>
        </tr>
</table>
</div>
<div class="tab-content"><?php
						

					$count = 1;
					$hisParamNames = Configure::read('histopathology_data_drm');
	 
					foreach ( $histoData ['LaboratoryParameter'] as $keyParas => $tab ) {
						if($histoData['LaboratoryResult']['authenticated_by']){
							if($this->Session->read ( 'userid' ) != Configure::read('YogeshMistryId') && $this->Session->read ( 'userid' ) != Configure::read('AjayJunnarkarId')){
								$labNoteCounter = count($histoData ['LaboratoryParameter'])-1;
							}else{
								$labNoteCounter = 0;
							}
						}else{
							$labNoteCounter = 0;
						}
					/* if($this->Session->read ( 'userid' ) != Configure::read('YogeshMistryId')){
						$labNoteCounter = count($histoData ['LaboratoryParameter'])-1;
					}else{
						$labNoteCounter = 0;
					} */
 
					$histoResult = $histoData ['LaboratoryHl7Result'] [$keyParas];
					// debug($histoResult);
					?> <?php if($keyParas==$labNoteCounter) { $class = "active"; } else { $class = "";} ?>
					<?php //if($keyParas==0) { $class = "active"; } else { $class = "";} ?>
					<?php $id = $tab['id'];?>
					<div id="tab<?php echo $count;?>" class="tab <?php echo $class; ?>"><?php
					
					echo $this->Form->hidden ( 'lab_type', array (
										'id' => 'lab_type',
										'type' => 'text',
										'value' => $labType 
					) );
					echo $this->Form->hidden ( 'laboratory_id', array (
										'id' => 'laboratory_id',
										'type' => 'text',
										'value' => $tab ['laboratory_id'] 
					) );
					echo $this->Form->hidden ( 'laboratory_test_order_id', array (
										'id' => 'laboratory_test_order_id',
										'type' => 'text',
										'value' => $histoData ['LaboratoryTestOrder'] ['patient_id'] 
					) );
					echo $this->Form->hidden ( 'patient_id', array (
										'id' => 'patient_id',
										'type' => 'text',
										'value' => $histoData ['LaboratoryTestOrder'] ['patient_id'] 
					) );
					
					echo $this->Form->hidden ( 'LaboratoryResult.id', array (
										'id' => 'id',
										'type' => 'text',
										'value' => $histoData ['LaboratoryResult'] ['id'] 
					) );
					
					echo $this->Form->hidden ( 'laboratory_test_order_id', array (
										'id' => 'laboratory_test_order_id',
										'type' => 'text',
										'value' => $this->params->query ['testOrderId'] 
					) );
					echo $this->Form->hidden ( '', array (
										'name' => "data[LaboratoryHl7Result][$id]",'type'=>'text',
										'value' => $histoData ['LaboratoryHl7Result'][$keyParas]['id']
					) );
					echo $this->Form->hidden ( '', array ('type'=>'text',
						'name' => "hisAppearanceOrderId_".$keyParas,
						'id' => "hisAppearanceOrderId_".array_search($tab ['name'], $hisParamNames),
						'value' => $keyParas,'lable'=>'gul'
					) );
					echo $this->Form->hidden('LaboratoryParameter1.doctor_templateText_id',array(
							'name'=>"data[DoctorTemplateText][$keyParas]",'id'=>'DoctorTemplateText_'.$keyParas,'class'=>'',
							'type'=>'text','div'=>false,'label'=>false,'style'=>'width:400px;height:20px;',
					));
/*
				echo $this->Form->hidden ( '', array (
						'name' => "hisAppearanceOrderId_".$keyParas,
						'id' => "hisAppearanceOrderId_".array_search($tab['name'], $hisParamNames),
						'value' => $keyParas
				) );
				*/
				//if((($getPanelSubLab[0]['Laboratory']['name'] == (Configure::read('IHC') || Configure::read('Her-2'))) && ($tab['name']==Configure::read('Immunohistochemistry')))){
				if((($getPanelSubLab[0]['Laboratory']['name'] == Configure::read('IHC') || $getPanelSubLab[0]['Laboratory']['name'] == Configure::read('Her-2'))) && ($tab['name']==Configure::read('Immunohistochemistry'))){
					 
					echo $this->element('immunohistochemistry',array('id' => $id,'observation'=>$histoResult ['observations'])); 
				
				}else{ 
					if(count($histoData ['LaboratoryHl7Result']) == 0){
						$defHisText = str_replace("\n","<br>",$tab ['parameter_text']);
					}
					
					

					echo $this->Form->textarea ( '', array (
										'value' => ($histoResult ['observations']) ? $histoResult ['observations'] : $defHisText,
										'name' => "data[LaboratoryParameter][$id]",
										'class' => 'ckeditor ckEditor_histo_data' ,
					                    'id'=>'ckEditor_histo_'.$keyParas,
										//'drmAttrGroup'=> array_search($histoResult['name'], $hisParamNames)
										) );
				}
					?></div>
					<?php $count = $count+1; } ?>
</div>

					</div>

					<?php
				}?> <!--// end of foreach
				
				
				  /* BROWSE HISTO  */-->
				 <table>
				 <?php if(count($dataLabImg) > 0 ){?>
				<tr>
				<?php foreach ( $dataLabImg as $temData ) {?>
				<td><?php
				
				if ($temData ['PatientDocument'] ['filename']) {
				$id = $temData ['PatientDocument'] ['id'];
										echo "<p id=" . "icd_" . $id . " style='padding:0px 10px;'>";
				$replacedText = $temData ['PatientDocument'] ['filename'];
				echo $this->Html->link ( $replacedText, '/uploads/laboratory/' . $temData ['PatientDocument'] ['filename'], array (
										'escape' => false,
										'target' => '__blank',
					'style' => 'text-decoration:underline;'
					) );
					echo $this->Html->link ( $this->Html->image ( '/img/icons/cross.png' ), array (
											'action' => 'delete_report',
					$temData ['PatientDocument'] ['patient_id'],
					$id,
											$orderId
									), array (
											'escape' => false,
											"align" => "right",
											"id" => "$id",
											"title" => "Remove",
											"style" => "cursor: pointer;",
											"alt" => "Remove",
											"class" => "radio_eraser"
									), 'Are you sure ?' );
				echo "</p>";
				}
				
				?></td>
				<?php }?>
							</tr>
							 <?php } ?>
							<tr>
								<td>
								<table id='addTr'>
									<tr>
										<td><?php 
				
										echo $this->Form->input('',array('name'=>'data[PatientDocument][file_name][]','type'=>'file','class' => 'browse','id'=>'browse_1','disabled'=>$browseDisable));?>
										</td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td>
									<?php  if($browseDisable == "disabled"){ }else{ echo $this->Html->image('icons/plus_6.png',array('id'=>'addButton')); }?>
								</td>
							</tr> 
							 
							</table>
				<?php echo $this->Form->end();?>
			<!--  	/*EOF BROESW HISTO  */-->
				<?php }?>
				<!--//culture
				/*For culture & sennsitivity */-->
				
				<?php if ($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 3) {  // dpr($getPanelSubLab);exit;
				$laboratory_test_order_id = $getPanelSubLab[0]['LaboratoryResult']['laboratory_test_order_id']?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull" id="" style="border-bottom:none">
						
						<tr>
							<td align="center" colspan="2"><?php echo __('MICROBIOLOGY DEPARTMENT')?></td>
						</tr>
						<?php if(count($getPanelSubLab) > 1){
							$CultureSensitivityGroup = Configure::read ( 'CultureSensitivityGroup' );
							  
						?> 
						<tr>
							<td>
								<table>
								 
									<tr>
									<?php foreach($allMicroList as $resultIdKey => $groupID){
										 
										if($resultIdKey==$laboratoryResultIdMicro ){
											$color = 'color: blue';
											$title = 'SELECTED';
										}else{
											$color = 'color: red';
											$title = 'NON-SELECTED';
										}	
										
										
									if($this->params->query ['hiddenAddMore']=='1'){?>
									<td style=" border-style: solid; border-width: 1px; <?php echo $color?>" title="<?php echo $title;?> "><b><?php echo $CultureSensitivityGroup[$groupID];?></b></td>
									<?php }else{?>
									<td style=" border-style: solid; border-width: 1px; <?php echo $color?>" title="<?php echo $title;?> "><b><?php echo $this->Html->link($CultureSensitivityGroup[$groupID],array('controller'=>'NewLaboratories','action'=>'histoEntryMode','?'=>array('testOrderId'=>$laboratory_test_order_id,'laboratoryResultId'=>$resultIdKey)));?></b></td>
									<?php } }?>
									</tr>
								</table>
							</td>
							
						</tr>
						 
						<?php }?>
						<?php  $i = 0;  
						if (! empty ( $authUser )) { // $authUser = all uathenticated usesr
							$login_user = $this->Session->read ( 'userid' ); // logined user
							 
							if (in_array ( $login_user, $authUser )) {
								$disabled = false;
							} else {
								$disabled = true;
							}
						}
					 
						/* $unserializeAuth = unserialize($getPanelSubLab[0]['LaboratoryResult']['authenticated_by']);
						 
						if(in_array($this->Session->read ( 'userid' ), $unserializeAuth)){
							$cultureAuthChecked = $chked = 'checked';
						}else{
							$chked = '';
						} */
						 
						 if($laboratoryResultIdMicro){ 
							 foreach($getPanelSubLab as $keymicro => $microval){
								if($microval['LaboratoryResult']['id']==$laboratoryResultIdMicro){
									if(($microval['LaboratoryResult']['is_authenticate']=='1')){
										$chked = 'checked';
									}else{
										$chked = '';
									}
								}else{
									continue;
								}
							 }
						}else{ 
							 
							if(($getPanelSubLab[0]['LaboratoryResult']['is_authenticate']=='1')){  
								$chked = 'checked';
							}else{ 
								$chked = '';
							}
							
						}
						?>
						 <tr>
						 	<td>
						 		<?php echo $this->Form->input ( '', array (
									'name' => "LaboratoryResult[is_authenticate]",
									'type' => 'checkbox',
									'div' => false,
									'label' => false,
									'disabled' => $disabled,
									'checked'=>$chked,
						 			'id'=>'culture_id',
						 			'class'=>'forSignature'
									) );
									?> Authenticated Result
									<?php echo $this->Form->hidden('LaboratoryResult.authenticated_by',array('type'=>'text','div'=>false,'label'=>false,'style'=>"margin-left:50px;",'class'=>'authenticated_by','name' => "LaboratoryResult[authenticated_by]"/* ,'value'=>$getPanelSubLab[0]['LaboratoryResult']['authenticated_by'] */));?>
									<?php echo $this->Form->hidden('LaboratoryResult.hiddenAddMore',array('type'=>'text','div'=>false,'label'=>false, 'id'=>'hiddenAddMore','name' => "LaboratoryResult[hiddenAddMore]"));?>
									<?php echo $this->Form->hidden ('LaboratoryResult.lab_type', array ( 'name' => "LaboratoryResult[lab_type]", 'value' => $getPanelSubLab ['0'] ['Laboratory'] ['lab_type'], 'type' => 'text') );?>
									<?php echo $this->Form->hidden ('LaboratoryResult.orderId', array ( 'id'=>'orderId','name' => "LaboratoryResult[orderId]", 'value' => $orderId, 'type' => 'text') );?>
						 	</td>
						 	
						 	
								
						 </tr>
						 <tr>
						 	<td style="padding-left:14px;"><b><u><?php echo $getPanelSubLab[0] ['Laboratory'] ['name'];?></u></b></td>
						 </tr>
						
						<tr>
							<td width="28%" valign="middle" class="tdLabel" id=""><b><?php echo __("Test");?></b> </td>
							<td width="32%" valign="middle" class="tdLabel" id=""><b><?php echo __("Observation");?></b> </td>
						</tr>
						<?php //debug($getPanelSubLab);exit;?>
						<?php if($getPanelSubLab[0] ['Laboratory'] ['name'] == "Blood Bank QC Report"){?> <!-- *****IF***** -->
						 	<tr>
								<td style="padding-left:14px;"><?php echo __('Report Header')?></td>
								<td>  
								<?php 
								echo $this->Form->hidden ('LaboratoryResult.id', array ( 'id'=>'id','name' => "LaboratoryResult[id]", 'value' => $getPanelSubLab[0]['LaboratoryResult']['id'], 'type' => 'text') );
								echo $this->Form->hidden ('LaboratoryResult.patient_id', array ( 'id'=>'patient_id','name' => "LaboratoryResult[patient_id]", 'value' => $getPanelSubLab[0]['LaboratoryTestOrder']['patient_id'], 'type' => 'text') );
								echo $this->Form->hidden ('LaboratoryResult.laboratory_id', array ( 'id'=>'laboratory_id','name' => "LaboratoryResult[laboratory_id]", 'value' => $getPanelSubLab[0]['Laboratory']['id'], 'type' => 'text') );?>
								<?php echo $this->Form->input ( '', array (
										'empty' => __ ( 'Please Select' ),
										'type' => 'select',
										'name'=>"LaboratoryResult[rct_name]",
										'class' => ' textBoxExpnd',
										'options' => Configure::read ( 'CultureReportHeader' ),
										'value'=>$getPanelSubLab[0]['LaboratoryResult']['rct_name'],
										'id'=>'rct_name',
										  
								) );?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Service Name');?></td>
								<td> 
								 <?php echo $this->Form->input ( '', array (
										 
										'type' => 'text',
										'name'=>"LaboratoryResult[service_name]",
										'class' => ' textBoxExpnd',
										'value'=>$getPanelSubLab[0]['LaboratoryResult']['service_name'],
										'id'=>'service_name',
										  
								) );?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Group');?></td>
								<td> 
								 <?php echo $this->Form->input ( '', array (
										 
										'type' => 'text',
										'name'=>"LaboratoryResult[si_specimen_col_method]",
										'class' => ' textBoxExpnd',
										'value'=>$getPanelSubLab[0]['LaboratoryResult']['si_specimen_col_method'],
										'id'=>'si_specimen_col_method',
										  
								) );?>
								</td>
							</tr>
						 	 <tr id="">
								<td style="padding-left:14px;"><?php echo __('Specimen')?></td>
								<td> 
								<?php echo $this->Form->input ( '', array (
										 
										'type' => 'text',
										'name'=>"LaboratoryResult[si_specimen_source]",
										'class' => ' textBoxExpnd',
										'value'=>$getPanelSubLab[0]['LaboratoryResult']['si_specimen_source'],
										'id'=>'si_specimen_source',
										  
								) );?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Unit No')?></td>
								<td> 
								 
								<?php echo $this->Form->input ( '', array (
										 
										'type' => 'text',
										'name'=>"LaboratoryResult[unit_no]",
										'class' => ' textBoxExpnd',
										'value'=>$getPanelSubLab[0]['LaboratoryResult']['unit_no'],
										'id'=>'unit_no',
										  
								) );?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Segment No')?></td>
								<td> 
								 
								<?php echo $this->Form->input ( '', array (
										 
										'type' => 'text',
										'name'=>"LaboratoryResult[segment_no]",
										'class' => ' textBoxExpnd',
										'value'=>$getPanelSubLab[0]['LaboratoryResult']['segment_no'],
										'id'=>'segment_no',
										  
								) );?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Name of Company')?></td>
								<td> 
								 
								<?php echo $this->Form->input ( '', array (
										 
										'type' => 'text',
										'name'=>"LaboratoryResult[company_name]",
										'class' => ' textBoxExpnd',
										'value'=>$getPanelSubLab[0]['LaboratoryResult']['company_name'],
										'id'=>'company_name',
										  
								) );?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Lot No')?></td>
								<td> 
								 
								<?php echo $this->Form->input ( '', array (
										 
										'type' => 'text',
										'name'=>"LaboratoryResult[lot_no]",
										'class' => ' textBoxExpnd',
										'value'=>$getPanelSubLab[0]['LaboratoryResult']['lot_no'],
										'id'=>'lot_no',
										  
								) );?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Manufactureing Date')?></td>
								<td> 
								<?php  
								$manufactureing_date = $this->DateFormat->formatDate2Local($getPanelSubLab[0]['LaboratoryResult'] ['manufactureing_date'],Configure::read('date_format'),false);
									echo $this->Form->input('LaboratoryResult.manufactureing_date', array('type'=>'text','class' =>' textBoxExpnd','id' => 'manufactureing_date', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:130px','readonly'=>'readonly','value'=>$manufactureing_date));
								?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Expiry Date')?></td>
								<td> 
								<?php  
								$expiry_date = $this->DateFormat->formatDate2Local($getPanelSubLab[0]['LaboratoryResult'] ['expiry_date'],Configure::read('date_format'),false);
									echo $this->Form->input('LaboratoryResult.expiry_date', array('type'=>'text','class' =>' textBoxExpnd','id' => 'expiry_date', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:130px','readonly'=>'readonly','value'=>$expiry_date));
								?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Gram Stain')?></td>
								<td> 
								 
								<?php echo $this->Form->input ( '', array (
										 
										'type' => 'textarea',
										'name'=>"LaboratoryResult[gram_stain]",
										'class' => ' textBoxExpnd',
										'value'=>$getPanelSubLab[0]['LaboratoryResult']['gram_stain'],
										'id'=>'gram_stain',
										  
								) );?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Culture Media Used')?></td>
								<td> 
								 
								<?php echo $this->Form->input ( '', array (
										 
										'type' => 'textarea',
										'name'=>"LaboratoryResult[culture_media_used]",
										'class' => 'textBoxExpnd',
										 'value'=>$getPanelSubLab[0]['LaboratoryResult']['culture_media_used'],
										'id'=>'culture_media_used',
										  
								) );?>
								</td>
							</tr>
							<tr id="">
								<td style="padding-left:14px;"><?php echo __('Isolated Organism')?></td>
								<td> 
								 
								<?php echo $this->Form->input ( '', array (
										 
										'type' => 'textarea',
										'name'=>"LaboratoryResult[isolated_organism]",
										'class' => 'textBoxExpnd',
										'value'=>$getPanelSubLab[0]['LaboratoryResult']['isolated_organism'],
										'id'=>'isolated_organism',
										  
								) );?>
								</td>
							</tr>
						 <?php }else{?><!--********else******  -->
						<?php  //debug(count($getPanelSubLab));exit;  debug($getPanelSubLab);exit;
									
							$xCount =0 	;		
						?>
						<?php foreach ( $getPanelSubLab as $key => $subData ) {//debug($subData);exit; ?>
						
						<?php
							 if(!$laboratoryResultIdMicro){
							 	if($xCount == '1')
									break;
						 	}else if($laboratoryResultIdMicro != $subData['LaboratoryResult']['id']){ 
						 		
						 		continue;
						 	}
						 
						/* if($this->params->query ['hiddenAddMore'] == '1'){
							unset($data ['LaboratoryResult']);
						} */
						
						?>
						
						<tr>
								<td style="padding-left:14px;"><?php echo __('Report Header')?></td>
								<td> 
								<?php echo $this->Form->input ( '', array (
										'empty' => __ ( 'Please Select' ),
										'type' => 'select',
										'name'=>"LaboratoryResult[rct_name]",
										'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
										'options' => Configure::read ( 'CultureReportHeader' ),
										'value'=>$subData['LaboratoryResult']['rct_name'],
										'id'=>'rct_name',
										  
								) );?>
								</td>
							</tr>
							<?php if($subData['LaboratoryResult']['si_specimen_col_method']){
								$disabled='disabled';
							}else{
								$disabled='';
							}?>
							<tr id="groupHead">
								<td style="padding-left:14px;"><?php echo __('Group');?></td>
								<td> 
								<?php   if( $this->params->query ['hiddenAddMore']){
									$hiddenAddMore = $this->params->query ['hiddenAddMore'];
								}  ?>
								<?php echo $this->Form->input ( '', array (
										'empty' => __ ( 'Please Select' ),
										'type' => 'select',
										'name'=>"LaboratoryResult[si_specimen_col_method]",
										'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
										'id' => 'Culture-Sensitivity-Group',
										'laboratoryTestOrderID' => $subData['LaboratoryTestOrder']['id'],
										'laboratoryID' => $subData['Laboratory']['id'],
										'laboratoryResultID' => $subData['LaboratoryResult']['id'],
										'userID' => $doctorData ['User'] ['id'],
										'disabled'=>$disabled,
										'value'=>$subData['LaboratoryResult']['si_specimen_col_method'],
										'patientId' => $subData['LaboratoryTestOrder']['patient_id'], 
										'selected'=>$subData['LaboratoryResult']['si_specimen_col_method'],
										'options' => Configure::read ( 'CultureSensitivityGroup' ),
										'autocomplete'=>'off',
										'hiddenAddMore' => $hiddenAddMore,
										'laboratoryResultIdMicro'=>$laboratoryResultIdMicro,
										 
										  
								) );?>
								</td>
							</tr>
							<tr id="groupHead">
								<td style="padding-left:14px;"><?php echo __('Specimen')?></td>
								<td> 
								<?php /* echo $this->Form->input ( '', array (
										'empty' => __ ( 'Please Select' ),
										'type' => 'select',
										'name'=>"LaboratoryResult[si_specimen_source]",
										'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
										'options' => $specimentTypes,
										'value'=>$subData['LaboratoryResult']['si_specimen_source'],
										'id'=>'si_specimen_source',
										  
								) ); */?>
								<?php echo $this->Form->input ( '', array (
										 
										'type' => 'text',
										'name'=>"LaboratoryResult[si_specimen_source]",
										'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
										'value'=>$subData['LaboratoryResult']['si_specimen_source'],
										'id'=>'si_specimen_source',
										  
								) );?>
								</td>
							</tr>

		<table id="tabMed" width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull" style="display:none;border-bottom:none;border-right:none;border-left:none;border-top:none;">
											 
							<tr><td  id="medication"></td>
							</tr>
						</table>
						
		<?php if($cultureAuthChecked == 1){?>				 
          <table id="tabFileMed" width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull" id=""  style="display:none">
           <!-- Browse buton  3-->
			<tr>
				<td><?php  
				foreach ( $dataLabImg as $temData ) {
				if ($temData ['PatientDocument'] ['filename']) {
				$id = $temData ['PatientDocument'] ['id'];
				echo "<p id=" . "icd_" . $id . " style='padding:0px 10px;'>";
				$replacedText = $temData ['PatientDocument'] ['filename'];
				echo $this->Html->link ( $replacedText, '/uploads/laboratory/' . $temData ['PatientDocument'] ['filename'], array (
					'escape' => false,
					'target' => '__blank',
					'style' => 'text-decoration:underline;' 
					) );
					echo $this->Html->link ( $this->Html->image ( '/img/icons/cross.png' ), array (
					'action' => 'delete_report',
					$temData ['PatientDocument'] ['patient_id'],
					$id,
					$orderId
					), array (
					'escape' => false,
					"align" => "right",
					"id" => "$id",
					"title" => "Remove",
					"style" => "cursor: pointer;",
					"alt" => "Remove",
					"class" => "radio_eraser" 
					), 'Are you sure ?' );
					echo "</p>";
				}
				}
				?></td>
			</tr>
			<?php if($getPanelSubLab[0]['LaboratoryResult']['is_authenticate']){?>
			<tr>
				<td>
				<table id='addTr'>
					<tr>
						<td><?php 
						
						echo $this->Form->input('',array('name'=>'data[PatientDocument][file_name][]','type'=>'file','class' => 'browse','id'=>'browse_1' ));?>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			
			<tr>
				
					<td><?php echo $this->Html->image('icons/plus_6.png',array('id'=>'addButton'))?></td>
			</tr> 
                   <?php }?>                 
                                </table>
                                <?php }?>
                               <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull" >
                                
                                <tr>
						<td width="" valign="middle" class="tdLabel" id=""><b> <?php
						if ($subData ['LaboratoryResult'] ['text']) {
							$isOpinion = 'checked';
							$isOpinionDisplay = 'display:block';
						} else {
							if($subData ['Laboratory'] ['notes']){
								$isOpinion = 'checked';
								$isOpinionDisplay = 'display:block';
							}else{
								$isOpinion = '';
								$isOpinionDisplay = 'display:none';
							}
						}

						echo ($subData ['Laboratory'] ['notes_display_text']) ? $subData ['Laboratory'] ['notes_display_text'] : __ ( 'Comment' );
						echo $this->Form->input ( '', array (
								'checked' => $isOpinion,
								'name' => "LaboratoryResult[is_opinion]",
								'value' => $subData ['Laboratory'] ['opinion'],
								'type' => 'checkbox',
								'div' => false,
								'label' => false,
								'style' => "margin-left:14px;",'width'=>'150%',
								'id' => 'isOpinion_' . $subData ['Laboratory'] ['id'],
								'class' => 'isOpinion' 
								) );
			
								?></b></td>
								<td width="" valign="middle" class="tdLabel" id="" colspan="2"><?php
								$widthVar='width:90%';
								echo $this->Form->input ( '', array (
										'style' => $isOpinionDisplay .';'.$widthVar,
										'rows' > '4',
										'columns' => '4',
										'name' => "LaboratoryResult[text]",
										'value' => ($subData ['LaboratoryResult'] ['text']) ? $subData ['LaboratoryResult'] ['text'] : $subData ['Laboratory'] ['notes'],
										'type' => 'textarea',
										'div' => false,
										'label' => false,
										'id' => 'opinion_' . $subData ['Laboratory'] ['id'],
										'class' => 'opinion' 
										) );
										?></td>
									</tr>
                                </table>
					</table>
					 
					
				<?php $i++; $xCount++;}
				
										}

					}?>
				

<div class="clr ht5"></div>

<table align="center">
	<tr>
		<td><?php
// 		if($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == '2'){
// 			$tabInd = "tabIndex='-1'";
// 		}
		$tabInd = "tabIndex='-1'";
		echo $this->Form->submit ( __ ( 'Save' ), array (
					'id' => 'save',
					'escape' => false,
					'class' => 'blueBtn',
					'label' => false,
					'div' => false,
					'error' => false ,
					$tabInd
					
		) ) . "&nbsp";
		// echo $this->Html->link('Preview',array('controller'=>'new_laboratories','action'=>'printLab','?'=>array('testOrderId'=> $orderId,'from'=>'Preview')), array('escape' => false,'class'=>'blueBtn','id'=>'Preview'))
		// ."&nbsp";
		echo $this->Html->link ( 'Back', array (
					'controller' => 'NewLaboratories',
					'action' => 'index',
					$tabInd
		//'1'
		), array (
					'class' => 'blueBtn',
					'id'=>'backButton',
					'div' => false,
					'label' => false,
					$tabInd
		) ) . "&nbsp";

		echo $this->Html->link (__ ( 'Preview & Print' ), 'javascript:void(0)', array (
					'id' => 'print',
					'escape' => false,
					'class' => 'blueBtn' ,
					$tabInd
					) ) . "&nbsp";
		if(($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 3)&& ($getPanelSubLab[0] ['Laboratory'] ['name'] != "Blood Bank QC Report")){ 
		echo $this->Form->submit ( __ ( 'Save And Add More' ), array (
				'id' => 'saveAddMore',
				'escape' => false,
				'class' => 'blueBtn add-more',
				'label' => false,
				'div' => false,
				'isAddmore'=>'isAddmore',
				'error' => false ,
				$tabInd
					
		) ) . "&nbsp";
		}
		if($dataLabImg){
					echo $this->Html->link ( 'Download Files', array (
					'controller' => 'new_laboratories',
					'action' => 'download',
					'id'=>'download',
					$getPanelSubLab ['0'] ['LaboratoryTestOrder'] ['patient_id']
					), array (
					'class' => 'blueBtn',
					'div' => false,
					'label' => false ,
					$tabInd
					) );
		}
					?></td>
	</tr>
</table>

<div class="clr ht5"></div>
</div>

<!--  Histopathology Test ends -->


<!--  <input class="blueBtn" type=submit value="Submit" name="Submit" style="float:right; margin-top:10px;">-->
					<?php //echo $this->Html->link('Back',array('controller'=>'new_laboratories','action'=>'index'),array('class'=>'blueBtn','div'=>false,'label'=>false,'style'=>'float:right',))."&nbsp";?>


<script>
	var formElementIds = new Array();
	var lastSelectedHistoTab = '1';
	var immunohistochemistryLabel = "<?php echo Configure::read('Immunohistochemistry');?>";
	jQuery(document).ready(function() {
			if($("#culture_id").val() == 1){
				//$("#print").removeClass("grayBtn");
			   // $("#print").addClass("blueBtn");
			}else{
				//$("#print").removeClass("blueBtn");
				//$("#print").addClass("grayBtn");
			}
		 $( ".getBlurId" ).each(function( index ) {
		    	calculateResult($(this).attr('id'));

		    	var id = $(this).attr("id");
				id = id.split("-");
		    	var ranges = $("#calcRange-"+id[1]).val();
		    	if(ranges !== undefined){
					ranges = ranges.replace("</br>","");
					ranges = ranges.trim();
		    	}
		    	if(ranges != '' && ranges !== undefined){
					ranges = ranges.replace(/\s/g,"");
		    		ranges = ranges.split("-");
					
			    	var value = $(this).val();
					if(ranges[0] !== undefined && ranges[1] !== undefined){
			    	var lowerRange = ranges[0].trim();
			    	var upperRange = ranges[1].trim();
			    	if((lowerRange !== undefined && lowerRange != '') && (upperRange !== undefined && upperRange != '')){ 
			    		value = Number(value); 
			    		if(value < lowerRange || value >  upperRange){
							$(this).addClass("errorAbnormal");
						}else{
							$(this).removeClass("errorAbnormal");
						}
			    	} else{
							$(this).removeClass("errorAbnormal");
						}
					}else{
							$(this).removeClass("errorAbnormal");
						}
			    	
		    	}else{
							$(this).removeClass("errorAbnormal");
						}
			});
		
		if( '<?php echo $getPanelSubLab ["0"] ["Laboratory"] ["lab_type"];?>' == 2 ){
			if('<?php echo $histoData['LaboratoryResult']['is_authenticate'] !=0;?>'){
		    //	$("#print").removeClass("grayBtn");
			 //   $("#print").addClass("blueBtn");
			 }else{
			//	 $("#print").removeClass("blueBtn");
			//	 $("#print").addClass("grayBtn");
			}
		}else{
		//	 $("#print").removeClass("blueBtn");
		//	 $("#print").addClass("grayBtn");
		}
		$('.tooltip').tooltipster({
	 		interactive:true,
	 		position:"right", 
	 	});
		jQuery("#labfrm").validationEngine();
	    jQuery('.tabs .tab-links a').on('click', function(e)  { 

	    	if('<?php echo $getPanelSubLab[0]['LaboratoryResult']['authenticated_by']?>'){  
				var sessionUserId = "<?php echo $this->Session->read ( 'userid' );?>";
				var yogeshId = "<?php echo Configure::read('YogeshMistryId');?>";
				var ajayId = "<?php echo Configure::read('AjayJunnarkarId');?>";
	    	}else{
	    		var sessionUserId = "<?php //echo $this->Session->read ( 'userid' );?>";
				var yogeshId = "<?php //echo Configure::read('YogeshMistryId');?>";
		    }
			if(sessionUserId != yogeshId && sessionUserId != ajayId){
		    	if($(this).attr('disabled') == 'disabled'){//for LabNte
					return false;
				}
			}
		
			lastHisCatsFHIS = (jQuery(this).attr('fieldno')); //by swapnil to set the current tab value
		//console.log(lastHisCatsFHIS);
			var foscusEdit = lastHisCatsFHIS - 1;
		//console.log(foscusEdit);
	        var currentAttrValue = jQuery(this).attr('href');
	    //console.log(currentAttrValue);
	        lastSelectedHistoTab = currentAttrValue.replace("#tab", "")
	    //console.log(lastSelectedHistoTab);
	        // Show/Hide Tabs
	        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
	        var editor = CKEDITOR.instances["ckEditor_histo_"+foscusEdit];
			if(editor !== undefined)
				editor.focus();
	        // Change/remove current tab to active
	        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
	        e.preventDefault();
	    });
	    
	    $("form :input").each(function(){
		    if($( "#"+$(this).attr('id') ).hasClass( "getVal" )){
	    		formElementIds.push($(this).attr('id'));
		    }
	    });
	});

	$("#save,#saveAddMore").click(function(){
		res = jQuery("#labfrm").validationEngine('validate');
		if(res){
			$("#backButton").hide();
			$("#saveAddMore").hide();
			$("#save").hide();
			$("#print").hide();
			$("#download").hide();
			$("#labfrm").submit();
		}		 
	});

	 
</script>
<!-- /*change*/ -->
<script>
		var globalTrigger = '';  
		var tabIndex = 1;
		/*$('.getBlurId').change(function(){
			if(globalTrigger){
				var getId = globalTrigger;
			}else{
				var getId = $(this).attr('id');
			}
			
			$( "#"+getId+"" ).on('change',function() {
				//alert('gulshan');
					var idValue = getId.split("-"); 
				    var getResult=$("#"+getId+"").val();
					if(getResult==''){
						$("#abnormal_flag-"+idValue[1]).val("");
						 $("#abnormal_flagDisplay-"+idValue[1]).val("");
					}else{
					    var rangeValue=$('#range-'+idValue[1]+'').val();
					     rangeValue=rangeValue.split("-"); 
					    var lowerLimtRange=rangeValue['0'];
					    var upperLimtRange=rangeValue['1'];
					    $("#abnormal_flagDisplay-"+idValue[1]).removeClass();
					  		if(parseInt(getResult) < parseInt(lowerLimtRange)){
								var tenPerBelow= Math.round((100-(getResult/lowerLimtRange)*100));
						 		if((tenPerBelow<=10) &&(tenPerBelow>=1)){
									// $("#abnormal_flagDisplay-"+idValue[1]).css("color", "#2F72FF");
			
									 $("#abnormal_flagDisplay-"+idValue[1]).addClass('orange');
									 // alert("#abnormal_flagDisplay_"+idValue[2]);
									 $("#abnormal_flagDisplay-"+idValue[1]).val("Below low normal");
							 		 $("#abnormal_flag-"+idValue[1]).val("L");
								 } 
								 if((tenPerBelow<=20) && (tenPerBelow >10)){
									// $("#abnormal_flagDisplay-"+idValue[1]).css("color", "#2F72FF");
									 $("#abnormal_flagDisplay-"+idValue[1]).addClass('orange');
									 $("#abnormal_flagDisplay-"+idValue[1]).val('Below lower panic limits');
									 $("#abnormal_flag-"+idValue[1]).val("LL");
						 		}
						 		if(tenPerBelow >=30){
									 //$("#abnormal_flagDisplay-"+idValue[1]).css("color", "#2F72FF");
									 $("#abnormal_flagDisplay-"+idValue[1]).addClass('orange');
									 $("#abnormal_flagDisplay-"+idValue[1]).val('Below absolute low-off instrument scale');
							 		 $("#abnormal_flag-"+idValue[1]).val("<");
								 }
						 		tenPerBelow='';
					 	 }
					  if(parseInt(getResult) > parseInt(upperLimtRange)){
						  var tenPerAbove= Math.round((100-(upperLimtRange/getResult)*100));
							 if((tenPerAbove<=10) &&(tenPerAbove>=1)){
								 //$("#abnormal_flagDisplay-"+idValue[1]).css("color", "#FF803E");	
								 $("#abnormal_flagDisplay-"+idValue[1]).addClass('red');
								 $("#abnormal_flagDisplay-"+idValue[1]).val('Above high normal');
								 $("#abnormal_flag-"+idValue[1]).val("H");
							 } 
							 if((tenPerAbove<=20) && (tenPerAbove >10)){
								 //$("#abnormal_flagDisplay-"+idValue[1]).css("color", "#F90223");
								 $("#abnormal_flagDisplay-"+idValue[1]).addClass('red');
								 $("#abnormal_flagDisplay-"+idValue[1]).val('Above upper panic limits');
								 $("#abnormal_flag-"+idValue[1]).val("HH");
							 }
							 if(tenPerAbove >=30){
								// $("#abnormal_flagDisplay-"+idValue[1]).css("color", "#F90223");
								$("#abnormal_flagDisplay-"+idValue[1]).addClass('red');
								$("#abnormal_flagDisplay-"+idValue[1]).val('Above absolute high-off instrument scale');
								 $("#abnormal_flag-"+idValue[1]).val(">");
							 }
							 tenPerBelow='';
					  }
					  if((parseInt(getResult) >= parseInt(lowerLimtRange)) && (parseInt(getResult) <= parseInt(upperLimtRange)) ){
						  $("#abnormal_flagDisplay-"+idValue[1]).addClass('green');
						  $("#abnormal_flagDisplay-"+idValue[1]).val('Normal');
						  
							 $("#abnormal_flag-"+idValue[1]).val("N");
					  }
					  tenPerBelow='';
					}
				 });
			globalTrigger="";
		});*/

		
		$("#isAuthenticateChecked").change(function(){	//if Authenticate result checked is true, set hidden value of is_authenticate to 1

			var validatePerson = jQuery("#labfrm").validationEngine('validate'); 
		    if(!validatePerson){
		    	if($(this).is(':checked',true)){
					
					$(".isAuthenticate").val(1);
					$(".is_authenticate_class").val(1);
					$(".hiddenAuthenticate").val(1);
				//	$("#print").removeClass("grayBtn");
			    //	$("#print").addClass("blueBtn");
				}else{
					$(".isAuthenticate").val('');
					$(".is_authenticate_class").val('');
					$(".hiddenAuthenticate").val('');
				//	$("#print").removeClass("blueBtn");
			    //	$("#print").addClass("grayBtn");
				}
		        return false;
		   }else{
		    
			if($(this).is(':checked',true)){
				
				$(".isAuthenticate").val(1);
				$(".is_authenticate_class").val(1);
				$(".hiddenAuthenticate").val(1);
				//$("#print").removeClass("grayBtn");
		    	//$("#print").addClass("blueBtn");
			}else{
				$(".isAuthenticate").val('');
				$(".is_authenticate_class").val('');
				$(".hiddenAuthenticate").val('');
			//	$("#print").removeClass("blueBtn");
		    //	$("#print").addClass("grayBtn");
			}
		   }
			
		});
		$("#histo_is_authenticate").change(function(){

			if($(this).is(':checked',true)){
			//	$("#print").removeClass("grayBtn");
		    //	$("#print").addClass("blueBtn");
			}else{
			//	$("#print").removeClass("blueBtn");
		    //	$("#print").addClass("grayBtn");
			}

			
		});
$(".isOpinion").change(function(){	
	var currId = $(this).attr('id');
	currId = currId.split("_");
	if($(this).is(':checked',true)){
		$("#opinion_"+currId[1]).attr('disabled',false);
		$("#opinion_"+currId[1]).delay(400).fadeIn(400);
		
	}else{
		$("#opinion_"+currId[1]).attr('disabled',true);
		$("#opinion_"+currId[1]).delay(400).fadeOut(400);	
		}
});

$(document).ready(function(){
	$(".getBlurId").trigger('blur');
$(document).keydown(function(e) {
        if ((e.keyCode == 66 || e.keyCode == 98) && e.ctrlKey) {
            e.preventDefault();
			location.href = "<?php echo $this->Html->url(array("controller" => "NewLaboratories", "action" => "index"));?>";
		}
		
    });
	
	$(window).bind('keydown keypress', 'ctrl+s', function(){//console.log('sssss???fff');
  //$("#save").trigger('click');
  ///return false;
});

for(k in CKEDITOR.instances){
    var instance = CKEDITOR.instances[k];
    CKEDITOR.replace( 'instance',
	{
		toolbar : 'HistoToolbar',
	});
	//instance.setKeystroke( CKEDITOR.CTRL + 115, false ); 
	
 }
 
	var editor = CKEDITOR.instances["ckEditor_histo_0"];
	if(editor !== undefined){
		editor.focus();
	}
		if ( CKEDITOR.status == 'loaded' ) {
		 setTimeout(function(){ 
			var editor = CKEDITOR.instances["ckEditor_histo_0"];
	if(editor !== undefined){
		editor.focus();
	} }, 1000);
    
}	
	 var culture_group_id = $("#Culture-Sensitivity-Group").val();
	 
	 var patientID = $("#Culture-Sensitivity-Group").attr('patientId');
	// var counter = $("#Culture-Sensitivity-Group").attr('counter');
	 var laboratoryTestOrderID = $("#Culture-Sensitivity-Group").attr('laboratoryTestOrderID');
	 var laboratoryID = $("#Culture-Sensitivity-Group").attr('laboratoryID');
	 var laboratoryResultID = $("#Culture-Sensitivity-Group").attr('laboratoryResultID');
	 var userID = $("#Culture-Sensitivity-Group").attr('userID');
	 var hiddenAddMore = $("#Culture-Sensitivity-Group").attr('hiddenAddMore');
	 //var laboratoryResultIdMicro = $("#Culture-Sensitivity-Group").attr(' laboratoryResultIdMicro');
	 var laboratoryResultIdMicro = '<?php echo $laboratoryResultIdMicro;?>';
	 
	 if('<?php echo $getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 3?>'){
			ajaxMedication(userID,culture_group_id,patientID,laboratoryTestOrderID,laboratoryID,laboratoryResultID,hiddenAddMore,laboratoryResultIdMicro);
	 }
	var idd = '';
	
	 $('.abnormal_flag').each(function() {
		 idd = $(this).attr('id');
		 new_id = idd.split("-");
		 $("#abnormal_flagDisplay-"+new_id[1]).val(getAbnormalField(this.value));	//DISLPLAY TEXT
		 $("#abnormal_flagDisplay-"+new_id[1]).addClass(getColor(this.value));		//ADD FONT COLOR
	 });
	 var valData = '';
	 $('.is_authenticate_class').each(function(){
			val = $(this).val();
			if(val){
				valData = 1;
				return false;
			}
	 });
	 if(valData){
			//$("#isAuthenticateChecked").attr('checked', true);
		//	$("#print").removeClass("grayBtn");
		//    $("#print").addClass("blueBtn");
		}else{
			$("#isAuthenticateChecked").attr('checked', false);
		}
});

function getAbnormalField(symbol)
{
	var msg = '';
	switch(symbol)
	{
		case "L": 	msg = "Below low normal";	break;
		case "LL": 	msg = "Below lower panic limits"; break;
		case "<":	msg = "Below absolute low-off instrument scale"; break;
		case "H":	msg = "Above high normal"; break;
		case "HH": 	msg = "Above upper panic limits"; break;
		case ">":	msg = "Above absolute high-off instrument scale"; break;
		case "N": 	msg = "Normal"; break;		 
	}
	return msg;
}

function getColor(symbol)
{
	var color = '';
	switch(symbol)
	{
		case "L": case "LL": case "<":	
			color = "orange"; break;
		case "H": case "HH": case ">":	
			color = "red"; break;
		case "N": 
			color = "green"; break;		 
	}
	return color;
}
	
	var PCV = '', RCC = '', HB = '';
	refund_amount = ($('#refund_amount').val() != '') ? parseInt($("#refund_amount").val()) : 0;
	
	/*$(".getVal").blur(function(){

		clas = $(this).attr('class');
		var new_class  = clas.split(' ');	//splitt by space
		//alert(new_class[3]);
		if(new_class[2] == "Red_Cell_Count"){
			
			RCC = $(this).val();
			//RCC = parseFloat(RCC);
			//RCC= RCC.toFixed(2);
			$(".Mean_Cell_Volume").val("");
			$(".Mean_Cell_Hemoglobin ").val("");
		}
		if(new_class[2] == "Packed_Cell_Volume"){
			PCV = $(this).val();
			//PCV = parseFloat(PCV);
			//PCV= PCV.toFixed(2);
			$(".Mean_Cell_Volume").val("");
			$(".Mean_Cell_He_Concentration").val("");
		}
		if(new_class[2] == "Haemoglobin"){
			HB = $(this).val();
			//HB = parseFloat(HB);
			//HB= HB.toFixed(2);
			$(".Mean_Cell_Haemoglobin").val("");
			$(".Mean_Cell_He_Concentration").val("");
		}
	// calling
		if(PCV!='' && RCC!=''){
			getMCV(PCV,RCC);
		}
		if(RCC!='' && HB!=''){
			getMCH(RCC,HB);
		}
		if(HB!='' && PCV!=''){
			getMCHP(PCV,HB);
		}
	});*/

	function getMCV(PCV,RCC){
		MCV = (PCV/RCC)*10;
		if(MCV){
			$(".Mean_Cell_Volume").val("");

			var getId=$(".Mean_Cell_Volume").attr('id');
			globalTrigger = getId;
			MCV = parseFloat(MCV);
			MCV= MCV.toFixed(2);
			$(".Mean_Cell_Volume").val(MCV);
			$(".getBlurId").trigger('change');
		}
	}

	function getMCH(RCC,HB){
		MCH = (HB*10)/RCC;
		if(MCH){
			$(".Mean_Cell_Haemoglobin").val("");

			var getId=$(".Mean_Cell_Haemoglobin").attr('id');
			globalTrigger = getId;
			MCH = parseFloat(MCH);
			MCH= MCH.toFixed(2);
			$(".Mean_Cell_Haemoglobin").val(MCH);
			$(".getBlurId").trigger('change');
		}
	}
	function getMCHP(PCV,HB){
		MCHP = (HB/PCV)*100;
		if(MCHP){
			$(".Mean_Cell_He_Concentration").val("");

			var getId=$(".Mean_Cell_He_Concentration").attr('id');
			globalTrigger = getId;
			MCHP = parseFloat(MCHP);
			MCHP= MCHP.toFixed(2);
			$(".Mean_Cell_He_Concentration").val(MCHP);
			$(".getBlurId").trigger('change');
		}
	}
	 
	$('#print').click(function(){
		 if('<?php echo $getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 3?>'){
			if('<?php echo $laboratoryResultIdMicro?>'){
				var laboratoryResultIdMicro = '<?php echo $laboratoryResultIdMicro?>';
			}else{
				var laboratoryResultIdMicro = '<?php echo $getPanelSubLab[0]['LaboratoryResult']['id']?>';	
			}
			var labType = '<?php echo $getPanelSubLab ['0'] ['Laboratory'] ['lab_type'];?>'
		}
		//alert(laboratoryResultIdMicro);return false;
		//$("#printDate").val('<?php echo date ( "Y-m-d H:i:s" ) ?>');
		var culture_group_id = $("#Culture-Sensitivity-Group").val();
		if($("#isAuthenticateChecked").is(':checked',true) || $("#histo_is_authenticate").is(':checked',true) || $("#culture_id").is(':checked',true)){
        var validatePerson = jQuery("#labfrm").validationEngine('validate'); 
         if(!validatePerson){
             return false;
        }
		// if('<?php echo $getPanelSubLab[0]['LaboratoryResult']['is_authenticate']?>'){
         var printUrl="<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'printLab','?'=>array('testOrderId'=>$orderId)));?>"+'&group_id='+culture_group_id+'&laboratoryResultIdMicro='+laboratoryResultIdMicro+'&labType='+labType;
        var entryUrl='<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'histoEntryMode','?'=>array('testOrderId'=>$orderId)));?>';
        //var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
        //var openWin =window.open(printUrl, '_blank',"toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width='+ screen.width +',height='+ screen.height +'");
       //if(openWin == null || typeof(openWin) == "undefined") {
           // alert("Please enabled popups for this site to continue.");  
         //}else{
          $("#backButton").hide();
		  $("#saveAddMore").hide();
		  $("#save").hide();
		  $("#print").hide();
         
              data = $('#labfrm').serialize();
                AjaxUrl = "<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'histoEntryMode'));?>";
                $.ajax({
                    type : "POST",
                    data : data,
                    url  : AjaxUrl,
                    beforeSend:function(data){
                        $('#busy-indicator').show();
                    },
                    success:function(data){
                        $('#busy-indicator').hide();
                        var printUrl="<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'printLab','?'=>array('testOrderId'=>$orderId)));?>"+'&group_id='+culture_group_id+'&laboratoryResultIdMicro='+laboratoryResultIdMicro+'&labType='+labType;
                        var entryUrl='<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'histoEntryMode','?'=>array('testOrderId'=>$orderId)));?>';
                        //var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
                        var openWin =window.open(printUrl, '_blank',"toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width='+ screen.width +',height='+ screen.height +'");
                        window.location.href =entryUrl;
                         
                }    
                }); 
         //}
	}else{
		return false;
	}
    });
	$('#Preview').click(function(){
		$.fancybox({
			
			'width' : '100%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'showCloseButton':true,
			
			'href' : "<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'printLab','?'=>array('testOrderId'=>$orderId,'from'=>'Preview','laboratoryResultIdMicro'=>$laboratoryResultIdMicro)));?>",
					
			
		});
	});
	var counter = 2;
	$('#addButton').click(function(){
		$("#addTr")
		.append($('<tr>').attr({'id':'newBrowseRow_'+counter,'class':'newBrowseRow'})
    		.append($('<td>').append($('<input>').attr({'id':'browse_'+counter,'class':'browse','type':'file','name':'data[PatientDocument][file_name][]'})))
    		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
					.attr({'class':'removeButton','id':'removeButton_'+counter,'title':'Remove current row'}).css('float','right')))
			)	
			counter++;
		
	});
	$(document).on('click','.removeButton', function() {
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#newBrowseRow_"+ID).remove();
		 
 });
	$(".getBlurId").keydown(
		    function(e)
		    {    
			    var currEleId = $(this).attr('id');
			    var key = formElementIds.getKey(currEleId);
		        if (e.keyCode == 40) {
		        	key++;
		        	if($("#"+formElementIds[key]) !== undefined)
		        		$("#"+formElementIds[key]).focus();
		        		/* $(".getBlurId").trigger("focus"); */
		   		}
		        if (e.keyCode == 38) {   
		        	key--;   
		        	if($("#"+formElementIds[key]) !== undefined)
		        		$("#"+formElementIds[key]).focus();
		        		/* $(".getBlurId").trigger("focus"); */
		   		}
		    }
		);

	
	/* $(".getBlurId")
    	.focus(function () { $(this).select(); } ); */
    	
	function calculateResult(id){
    		var className = $("#"+id).attr('class');    
    		className = className.split(" ");
    		id = className[1];
    		id = id.split("_");
    		var isNotBlank = true;
    		var formula = $("#formulaCalc_"+id[1]).val();
			if(formula !="" && formula !== undefined){
    			var formulaText = formula.split(" ");
    			var newFormula = '';
    			jQuery.each( formulaText, function( i, val ) {
    				var numRegex = "{{[0-9]";
    				var formulaRegex = "{{.formulaId";
    				var operatorRegex = "{{[()+*/.-]}}";
    				var re = new RegExp(numRegex, 'g');
    				var isPowerIncluded =  val.indexOf("raiseToPower") ;
    				val = val.trim();
    				if(val.match(re)){
    					val = val.replace(new RegExp("{{", 'g'), "Number(");
    					val = val.replace(new RegExp("}}", 'g'), ")");
    				}

    				var re = new RegExp(operatorRegex, 'g');
    				if(val.match(re) || isPowerIncluded > 0){
    					val = val.replace(new RegExp("{{", 'g'), "");
    					val = val.replace(new RegExp("}}", 'g'), "");
    				}
    				
    				var re = new RegExp(formulaRegex, 'g');
    				if(val.match(re)){
    					if(isPowerIncluded>0){
    						val = val.replace(new RegExp("{{", 'g'), "$('");
        					val = val.replace(new RegExp("}}", 'g'), "').val()");
        				}else{
        					val = val.replace(new RegExp("{{", 'g'), "Number($('");
        					val = val.replace(new RegExp("}}", 'g'), "').val())");
        				}    					
    					var valNew = val.replace(new RegExp("Number", 'g'), "");
    					if(eval(valNew) == '' || eval(valNew) === undefined){
    						val = val.replace(new RegExp("Number"+valNew, 'g'), valNew);
    						isNotBlank = false;
    					}
    					
    				} 
    				newFormula += val;
    			});

    			if(isNotBlank){
        			//by pankaj for power formulae
        			hasPower = newFormula.indexOf("raiseToPower");
        			 
        			if(hasPower > 0){//has the power in formulae
        				firstVal= eval(newFormula.split('raiseToPower')[0]);
        				secVal= eval(newFormula.split('raiseToPower')[1]); 
        				var calc=Math.pow(firstVal,secVal);
        				       			
            		}else{
        			//eof power formulae
        				var calc = eval(newFormula);
            		}
					if(isNaN(calc)) return;
        			var dec = $("#formulaCalcDec_"+id[1]).val();
        			if(dec == '') dec = '0';
						$(".formulaId_"+id[1]).val(calc.toFixed(parseInt(dec)));
    			}else{
    				$(".formulaId_"+id[1]).val("");
    			}
    			
    		}
    }
	/* $(".getBlurId").blur(function(e){
		calculateResult($(this).attr('id'));
	}); */

    $(".getBlurId").blur(function(e){//console.log('Done');
	    $( ".getBlurId" ).each(function( index ) {
	    	calculateResult($(this).attr('id'));
			var id = $(this).attr("id");
			id = id.split("-");
		    if((isNaN(calculateResult)==false) ) {
				// Fixed Point
				var className = $("#"+$(this).attr('id')).attr('class');    
	    		className = className.split(" ");
	    		fid = className[1];
	    		fid = fid.split("_");
				var dec = $("#formulaCalcDec_"+fid[1]).val();
				var calcResToFixed = $(".formulaId_"+fid[1]).val();
				if(dec == '') dec = '0';
				if(calcResToFixed != null && calcResToFixed != '' && calcResToFixed !== undefined){
					calcResToFixed = Number(calcResToFixed);
					$(".formulaId_"+fid[1]).val(calcResToFixed.toFixed(parseInt(dec)));
				}
				//Fixed Point
		    }
			
			
	    	var ranges = $("#calcRange-"+id[1]).val();
	    	if(ranges !== undefined){
				ranges = ranges.replace("</br>","");
				ranges = ranges.trim();
	    	}
	    	if(ranges != '' && ranges !== undefined){
				ranges = ranges.replace(/\s/g,"");
	    		ranges = ranges.split("-");
				
		    	var value = $(this).val();
				if(ranges[0] !== undefined && ranges[1] !== undefined){
		    	var lowerRange = ranges[0].trim();
		    	var upperRange = ranges[1].trim();
		    	if((lowerRange !== undefined && lowerRange != '') && (upperRange !== undefined && upperRange != '')){ 
		    		value = Number(value);
		    		if(value < lowerRange || value >  upperRange){
						$(this).addClass("errorAbnormal");
					}else{
						$(this).removeClass("errorAbnormal");
					}
		    	} else{
						$(this).removeClass("errorAbnormal");
					}
				}else{
						$(this).removeClass("errorAbnormal");
					}
		    	
	    	}else{
						$(this).removeClass("errorAbnormal");
					}
		});
    });		
	 //$(this).attr('tabindex', n++);
	 var globalAutoHistoData =  new Array();//lastSelectedeTemplateId = 
	 
	 /*$(document).on("keydown","#LaboratoryResultTemplate",function() {
   var doctorTemplateURL = "<?php //echo $this->Html->url(array("controller" => "AutoCompletes", "action" => "autocompleteForHistoTemplates",$getPanelSubLab['0']['Laboratory']['histo_sub_categories'],"admin" => false,"plugin"=>false)); ?>";	
   var obj=lastSelectedHistoTab;
   lastSelectedHistoTabURL = "&sub_template_id="+lastSelectedHistoTab;
   doctorTemplateURL = doctorTemplateURL.replace("%7B%7B%7D%7D", lastSelectedHistoTabURL); 
   

    $(this).autocomplete("search");
});*/
	 var doctorTemplateURL = "<?php echo $this->Html->url(array("controller" => "AutoCompletes", "action" => "autocompleteForHistoTemplates",$getPanelSubLab['0']['Laboratory']['histo_sub_categories'],"admin" => false,"plugin"=>false)); ?>";	
	   if('<?php echo $getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 2?>'){
	   $(":input,a").attr("tabindex", "-1");
	   $(".tabingClassByTabLI a").attr("tabindex", "0");
	   var tindex = 1;
	   jQuery('.tabIndActive').each(function(currentElement, index) {
			$(this).attr("tabIndex",tindex);
			tindex++;
		});
	   
	   var currLabType = "<?php echo $getPanelSubLab ['0'] ['Laboratory'] ['lab_type'];?>";
	 	$("#searchForTemplate").autocomplete({
		 
		 source: doctorTemplateURL,
		 minLength: 1,
		 select: function( event, ui ) {
			  
			 $( ui.item.DoctorTemplateText ).each(function( index , value ) {
				  
				 var id = parseInt(value.section_id);
				 id = $("#hisAppearanceOrderId_"+id).val();
				
				 $('#DoctorTemplateText_'+id).val(value.id);
				  
				 id = 'ckEditor_histo_' +id;
				  
				 CKEDITOR.instances[id].setData(value.template_text)
			 });
			 $("#searchForTemplate").val(ui.item.DoctorTemplate.template_name);
			 $("#searchForTemplateAlt").val(ui.item.DoctorTemplate.template_name);
			 	 if(ui.item.DoctorTemplate.id){
					$("#searchForTemplateId").val(ui.item.DoctorTemplate.id);
				 } 
			 	event.preventDefault();
			 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	}).data("uiAutocomplete")._renderItem = function (ul, item) {
			 
			var id = item.DoctorTemplate.id;
	 	globalAutoHistoData = {
	 			id:item
	 	}
	 	return jQuery("<li></li>")
        .data('item.id', item.DoctorTemplate.id)
        .append('<a>' + item.DoctorTemplate.template_name + '</a>')
        .appendTo(ul);
    };
	   }
    $("#searchForTemplate").keyup(function(){
    	$("#searchForTemplateId").val('');
		$("#searchForTemplateAlt").val($(this).val());
    });

	 	 

    $("#save_histo_template").click(function(e){//ckEditor_histo_data  var selectedCategoriesId = new Array(); labfrmH
    	var ckEditorHistoData = new Array();
    	 var histo_department_id = "<?php echo $getPanelSubLab['0']['Laboratory']['histo_sub_categories'];?>";
        var cnt = lastSelectedHistoTab - 1;
        var searchForTemplateId = $("#searchForTemplateId").val();
       var histo_template_name =  $( "#LaboratoryResultTemplate" ).val();
       $('.ckEditor_histo_data').each(function() { 	
    		var thisId = $(this).attr('id');
    		var splittedArr = thisId.split("_");
    	 	$("#ckEditor_histo_"+splittedArr[2]).val(CKEDITOR.instances["ckEditor_histo_"+splittedArr[2]].getData());
			//var editor = CKEDITOR.instances["ckEditor_histo_"+splittedArr[2]];
			
    	});
       var data = $("#labfrm").serialize();
       //var ckEditorHistoData = ckEditorHistoData;
        var AjaxTemplateUrl = "<?php echo $this->Html->url(array('controller' => 'newLaboratories', 'action' => 'saveHistoTemplates'));?>";
                    $.ajax({
                        type : "POST",
                        data : data ,
                        url  : AjaxTemplateUrl,
                        beforeSend:function(data){
        					$('#busy-indicator').show();
        				},
                        success:function(data){
                        	$('#busy-indicator').hide();
                           $("#showFlashMessage").html(data);
                           setTimeout(function(){ $("#showFlashMessage").html(''); }, 10000);
                           
                    }    
        }); 
        
    });
    
	var siblingcount = 0;
		$(".tabingClassByTabLI").each(function(){

			
			if($(this).attr('fieldno') != 'undefined' || $(this).attr('fieldno') != ''){
				siblingcount++;	//count no of siblings
			}
		});
		
		
	var lastHisCatsFHIS = 1;var lastTIndexIs = 0;
	var currHisTest = "<?php echo $getPanelSubLab[0]['Laboratory']['name'];?>";
	$(document).keyup(function(event) {
			//'IHC (ER, PR) ';'IHC (ER, PR, Her-2)'
			if((immunohistochemistryLabel == $("#tabName_"+lastHisCatsFHIS+" a").text().trim()) && (currHisTest == 'IHC (ER, PR, Her-2)' ||  currHisTest == 'IHC (ER, PR)')){
			/*if(currHisTest == 'IHC (ER, PR, Her-2)' ||  currHisTest == 'IHC (ER, PR)'){
					
			}*/
			if(event.which != 9){
				return;
			}
				if(lastTIndexIs == 0){
					++lastTIndexIs;
					$('[tabindex=' + lastTIndexIs + ']').focus();
					return;
				}else if(lastTIndexIs < 12){
					++lastTIndexIs;
					$('[tabindex=' + lastTIndexIs + ']').focus();
					return;
				}else{
					lastTIndexIs = 0;
					//lastHisCatsFHIS++;
				}
				
			 }
			jQuery(".tab-links").parent('li').addClass('active').siblings().removeClass('active');	
			$('.tabingClassByTabLI').removeClass('active');
		    if (event.which == 9) {
		   	
			if('<?php echo $getPanelSubLab[0]['LaboratoryResult']['authenticated_by']?>'){  
		    	var sessionUserId = "<?php echo $this->Session->read ( 'userid' );?>";
		    	var yogeshId = "<?php echo Configure::read('YogeshMistryId');?>";
		    	var ajayId = "<?php echo Configure::read('AjayJunnarkarId');?>";
			}else{
				var sessionUserId = "<?php //echo $this->Session->read ( 'userid' );?>";
		    	var yogeshId = "<?php //echo Configure::read('YogeshMistryId');?>";
			}
	    	if(sessionUserId != yogeshId && sessionUserId != ajayId){
	 	    	if( $('.tabs .tab-links a').attr('disabled') == 'disabled'){ //for LabNte
	 				return false;
	 			}	
	    	}

		    	
			 
				if(siblingcount > lastHisCatsFHIS){ 
					jQuery("#tabName_"+lastHisCatsFHIS).removeClass('active');
					lastHisCatsFHIS++; 
					
				}
			
				jQuery('.tabs #tab'+lastHisCatsFHIS).show().siblings().hide();
				
		        // Change/remove current tab to active
		        jQuery('.tabs #tab'+lastHisCatsFHIS).parent('li').addClass('active').siblings().removeClass('active');
				jQuery("#tabName_"+lastHisCatsFHIS).addClass('active');
				
				var foscusEdit = lastHisCatsFHIS - 1;
				var editor = CKEDITOR.instances["ckEditor_histo_"+foscusEdit];
				if(editor !== undefined)
					editor.focus();
				
				event.preventDefault();		 
				if(siblingcount == lastHisCatsFHIS){
					lastHisCatsFHIS = 0;
				}
			
			
			}
			 
			
	});

	 


		var countMed = ('<?php echo $countMed;?>' == '') ? 0 : '<?php echo $countMed?>';
		
		$('#addMoreSensitivity').click(function(){
			$("#sennsitivity-table")
			.append($('<tr>').attr({'id':'newSensitivityRow_'+countMed,'class':'newSensivitityRow'})
					.append($('<td>').append($('<input>').attr({'type':'text','name':'data[LaboratoryResult][0][medication]['+countMed+'][name]','id':'medName_'+countMed}).css({'width':'240px'})))
		    		.append($('<td>').append($('<select>').attr({'name':'data[LaboratoryResult][0][medication]['+countMed+'][sensitivity_flag]','id':'sensitivity_'+countMed,'class':'textBoxExpnd '})))
		    		.append($('<td>').append($('<img>').attr({'src':"<?php echo $this->webroot ?>theme/Black/img/icons/close-icon.png",'class':'removeMicroBiologyMeds',
		        				'id':'removeMicroBiologyMeds_'+countMed,'title':'Remove'}))
				))	
				

			$('#medName_'+countMed).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","PharmacyItem",'id',"name",'null',"admin" => false,"plugin"=>false)); ?>",{
				width: 250,
				selectFirst: true,
				valueSelected:true,
				loadId : 'medName'+countMed
			});

			$.each(selectSensitivity, function(key, value) {
	 	 	 	$('#sensitivity_'+countMed).append(new Option(value , value) );
	 		});
			countMed++;
		});
		$(document).on('click','.removeMicroBiologyMeds', function() {
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$("#newSensitivityRow_"+ID).remove();
			 
		});
		var selectSensitivity = $.parseJSON('<?php echo json_encode(Configure::read('sensitivity') )?>'); 

		$(document).on('click','.cross', function() {
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$("#tr_"+ID).remove();
			 
		});


		 
		
		$('#Culture-Sensitivity-Group').change(function(){
			 var culture_group_id = $(this).val();
			 var patientID = $(this).attr('patientId');
			 //var counter = $(this).attr('counter');
			 var laboratoryTestOrderID = $(this).attr('laboratoryTestOrderID');
			 var laboratoryID = $(this).attr('laboratoryID');
			 var laboratoryResultID = $(this).attr('laboratoryResultID');
			 var userID = $(this).attr('userID');
			 var hiddenAddMore =  $(this).attr('hiddenAddMore'); 
			 var laboratoryResultIdMicro =  '<?php echo $laboratoryResultIdMicro?>'; 
			 
			ajaxMedication(userID,culture_group_id,patientID,laboratoryTestOrderID,laboratoryID,laboratoryResultID,hiddenAddMore,laboratoryResultIdMicro);
		});
		function ajaxMedication(userID,culture_group_id,patientID,laboratoryTestOrderID,laboratoryID,laboratoryResultID,hiddenAddMore,laboratoryResultIdMicro ) {
			
	 		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "NewLaboratories", "action" => "ajaxMedication"));?>"+'/'+userID+'/'+culture_group_id+'/'+patientID+'/'+laboratoryTestOrderID+'/'+laboratoryID+'/'+laboratoryResultID+'/'+hiddenAddMore+'/'+laboratoryResultIdMicro
	 		 $.ajax({
		        	beforeSend : function() {
		        		$('#busy-indicator').show();
		          	},
		        type: 'POST',
		        url: ajaxUrl,
		        dataType: 'html',
		        success: function(data){
			        $("#tabMed").show();
		        	$('#busy-indicator').hide();
			        if(data!=''){
		       			 $('#medication').html(data);
		       		}
			        
		        },
				});
	 	}

	 	$(".forSignature").change(function(){	
			if($(this).is(':checked',true)){
				var UserID = '<?php echo $this->Session->read ( 'userid' );?>'
				$(".authenticated_by").val(UserID);
			}else{
				$(".authenticated_by").val('');
			}
		});
		
	 	
	 	 
	 	$("#positive_er,#intensity_er").keyup(function () {
				if((isNaN($('#positive_er').val())==false)&&((isNaN($('#intensity_er').val())==false))){ 
					$('#output_er').val($('#positive_er').val() * $('#intensity_er').val());
				}
				 
			});
		$("#positive_pr,#intensity_pr").keyup(function () {
				if((isNaN($('#positive_pr').val())==false)&&((isNaN($('#intensity_pr').val())==false))){ 
					$('#output_pr').val($('#positive_pr').val() * $('#intensity_pr').val());
				}
				 
			});

		$(".add-more").click(function(){

			$("#hiddenAddMore").val('1');
			$("#orderId").val('<?php echo $orderId;?>')

		});

		

		$(function() {
			$("#manufactureing_date").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				dateFormat:'<?php echo $this->General->GeneralDate();?>', 
			});
		});

	$(function() {
		$("#expiry_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>', 
		});

		 $("#report_date").datepicker({
	            showOn: "button",
	            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	            buttonImageOnly: true,
	            changeMonth: true,
	            changeYear: true,
	            changeTime: true,
	            showTime: true,
	            yearRange: '1950',
	            dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS');?>'
	        });
	});
        
	 	</script>
	  