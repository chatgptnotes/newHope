<style>
#boxspace {border-right: 0.3px solid #384144;
    padding-right: 5px;}

</style>
<center>
	<h1>Result
</center>
<div id="message_error"
	align="center">
	</div>
	<div class="mailbox_div">
	<?php echo $this->element('mailbox_index');?>
</div>
<div class="mailbox_div">
	<?php echo $this->element('hl7_list');?>
</div><div class="inner_title">
<h3><?php echo __('Outbox') ?></h3>
<!-- <span><?php  echo $this->Html->link('Back',array("controller"=>"Messages","action"=>"index"),array('escape'=>false,'class'=>'blueBtn')); ?></span> -->
</div>
<?php
$resSepArr = array();
$resSpeRej = array();
$resSpeRej1 = array();
$specialCase = array();
function formatDate($timeHours){
	$temp = explode("-",$timeHours);
	
	return gmdate("D M d H:i:s \G\M\T-$temp[1] Y", strtotime($temp[0]));
}

$result_hl7[]=explode("\n",$get_Result[0]['Hl7Result']['message']);
//echo "<pre>";print_r($result_hl7);exit;
$arrId = 0;
$obxArr = array();
foreach ($result_hl7[0] as $resultKey=>$resultValue){
	$Dexp = 	explode('|',$resultValue);
	
	if($Dexp[0] == 'ORC'){
		$obxArr[$arrId]['ORC']=$Dexp;
		$arrId++;
	}
	
	if($Dexp[0] == 'OBR'){
		$obxArr[$arrId-1]['OBR'][]=$Dexp;
		
	}
	
	if($Dexp[0] == 'OBX'){
		$obxArr[$arrId-1]['OBX'][]=$Dexp;
		
	}
	
	if($Dexp[0] == 'NTE'){
		if($lastNode == 'OBX'){
			$obxArr[$arrId-1]['NTEX'][]=$Dexp;
		}
		if($lastNode == 'OBR'){
			$obxArr[$arrId-1]['NTER'][]=$Dexp;
		}
	
	}
	
	if($Dexp[0] == 'SPM'){
		$obxArr[$arrId-1]['SPM'][]=$Dexp;
	
	}
	
	if($Dexp[0] == 'TQ1'){
		$obxArr[$arrId-1]['TQ1'][]=$Dexp;
	
	}
	$lastNode = $Dexp[0];
}
//echo "<pre>";print_r($obxArr);

for($i=0;$i<count($result_hl7);$i++){
	for($x=0;$x<count($result_hl7[$i]);$x++){
	
/*$result_MSH[]=explode('|',$result_hl7[$i]['0']);
$result_PID[]=explode('|',$result_hl7[$i]['1']);
$result_ORC[]=explode('|',$result_hl7[$i]['2']);
$result_OBR[]=explode('|',$result_hl7[$i]['3']);
$result_NTE[]=explode('|',$result_hl7[$i]['4']);
$result_TQ1[]=explode('|',$result_hl7[$i]['5']);
$result_OBX[]=explode('|',$result_hl7[$i]['6']);
//if(in_array('MSH|^',$result_hl7[$i]))
//$result_SPM[]=explode('|',$result_hl7[$i]['7']);
*/

	$dataExplode = 	explode('|',$result_hl7[$i][$x]);

//debug($dataExplode); exit;
switch ($dataExplode[$i])
{
	case 'MSH':
		$result['MSH'][] = explode('|',$result_hl7[$i][$x]) ;
		break;
	case 'PID':
		$result['PID'][] = explode('|',$result_hl7[$i][$x]);
		break;
	case 'ORC':
		$result['ORC'][] = explode('|',$result_hl7[$i][$x]) ;
		break;
	case 'OBR':
		$result['OBR'][] = explode('|',$result_hl7[$i][$x]);
		break;
	case 'NTE':
		$result['NTE'][] = explode('|',$result_hl7[$i][$x]);
		break;
	case 'TQ1':
		$result['TQ1'][] = explode('|',$result_hl7[$i][$x]);
		break;
	case 'OBX':
		$result['OBX'][] = explode('|',$result_hl7[$i][$x]);
		break;
	case 'SPM':
		$result['SPM'][] = explode('|',$result_hl7[$i][$x]);
		break;
	default:
		
}


	}
}//echo "<pre>";print_r($result);exit;
//debug($result['PID']); 

//debug($dataExplode); exit;
$i=$count;
/*
echo "<pre>";debug($result_MSH[$i]);
echo "<pre>";debug($result_PID[$i]);
echo "<pre>";debug($result_ORC[$i]);
echo "<pre>";debug($result_OBR[$i]);
echo "<pre>";debug($result_NTE[$i]);
echo "<pre>";debug($result_TQ1[$i]);
echo "<pre>";debug($result_OBX[$i]);
echo "<pre>";debug($result_SPM[$i]); */

//debug($result['PID']);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Patient Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Patient Name");?>
		</td>
		<?php // $name=explode('^',$dataExplode[0]['PID']) ;?>
		<?php $name=explode('^',$result[PID][0][5]) ;
		//debug($name); exit;
		//echo str_replace("|"," ",$name[4])." ";
		//echo $name[5];
		?>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $name[1]." ".$name[2]." ".$name[0]." ".$name[3]?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date/Time of Birth");?>
		</td>
		<?php $doby=substr($result[PID][0][7],0,4) ; 
				   $dobd=substr($result[PID][0][7],6) ; 
 				   $dobm1=substr($result[PID][0][7],4) ; 
				   $dobm=substr($dobm1,0,2) ; 
?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $dobm."/".$dobd."/".$doby;?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Administrative Sex");?>
		</td>
		<?php if($result[PID][0][8]==M) $sex="Male";
				else
					{
						$sex= Female;
					}
			?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($sex);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Race");?>
		</td>
		<?php $race=explode('^',$result[PID][0][10]) ;?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($race[1]);?>
		</td>
	</tr>
	 <tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Race");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($race[4]);?>
		</td> 
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Ordering Provider") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Name");?>
		</td>
		<?php $name=explode('^',$result[OBR][0][16]) ; //debug($name); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $name[5]." ".$name[2]." ".$name[3]." ".$name[1]." ".$name[4]; ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Identifier Number");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($name[0]);?>
		</td>
	</tr>

	
</table>






<?php 
$miCount =0;
foreach($obxArr as $uniqueMessage)
{	//echo $miCount.'<pre>';print_r($uniqueMessage);//exit;
	?>

<!-- Observation Details Starts -->

<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Observation Details") ; ?></th>
	</tr>
	<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace" colspan="2"><strong><?php echo __("Observation General Information ") ; ?></strong></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Order Number");?>
		</td>
		<?php
					if(empty($uniqueMessage[ORC][0][2])){ 
												$order=explode('^',$uniqueMessage[OBR][0][2]);
}
else{
$order=explode('^',$uniqueMessage[ORC][2]);
}
if($miCount == 0){
	$FillerNo1 = explode('^',$uniqueMessage[ORC][3]);
	$FillerNo1= $FillerNo1[0];
	
	$TestName1 = explode('^',$uniqueMessage[OBR][0][4]);
	$TestName1= $TestName1[1];
}
if($miCount == 1){
	$FillerNo2 = explode('^',$uniqueMessage[ORC][3]);
	$FillerNo2= $FillerNo2[0];
	
	$TestName2 = explode('^',$uniqueMessage[OBR][0][4]);
	$TestName2= $TestName2[1];
}
if($miCount == 2){
	$FillerNo3 = explode('^',$uniqueMessage[ORC][3]);
	$FillerNo3= $FillerNo3[0];
}
if($miCount == 3){
	$FillerNo4 = explode('^',$uniqueMessage[ORC][3]);
	$FillerNo4= $FillerNo4[0];
}
$miCount++;
?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($order[0]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Filler Order Number");?>
		</td>
		<?php
					if(empty($uniqueMessage[ORC][3])){ 
												$ordern=explode('^',$uniqueMessage[OBR][0][3]);
}
else{
$ordern=explode('^',$uniqueMessage[ORC][3]);
}
?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($ordern[0]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Group Number");?>
		</td>
		<?php 	$groupNo=explode('^',$uniqueMessage[ORC][4]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($groupNo[0]);?>
		</td>
	</tr>
	
	<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace" colspan="2"><strong><?php echo __("Parent Universal Service Identifier ") ; ?></strong></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Identifier");?>
		</td>
		<?php 	$usi=explode('^',$uniqueMessage[OBR][0][4]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php  //echo __($usi[1]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Text");?>
		</td>
		<?php 	$date=explode('^',$uniqueMessage[OBR][0][7]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __($result_OBR[0][7]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Identifier");?>
		</td>
		<?php 	$date=explode('^',$uniqueMessage[OBR][0][7]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __($result_OBR[0][7]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Text");?>
		</td>
		<?php 	$date=explode('^',$uniqueMessage[OBR][0][7]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __($result_OBR[0][7]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Original Text");?>
		</td>
		<?php 	$date=explode('^',$uniqueMessage[OBR][0][7]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __($result_OBR[0][7]);?>
		</td>
	</tr>
	
	
	
	
	
	
	<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace" colspan="2"><strong><?php echo __("Observation details ") ; ?></strong></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Universal Service Identifier");?>
		</td>
		<?php 	$usi=explode('^',$uniqueMessage[OBR][0][4]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($usi[1]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation Date/Time");?>
		</td>
		<?php 	//$date=explode('^',$result[OBR][0][7]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __(formatDate($uniqueMessage[OBR][0][7]));?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  End Date/Time");?>
		</td>
		<?php 	//$date=explode('^',$result[OBR][0][7]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __($result[OBR][0][7]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Action Code");?>
		</td>
		<?php 	//$date=explode('^',$result[OBR][0][11]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($uniqueMessage[OBR][0][11]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information");?>
		</td>
		<?php 	$date=explode('^',$uniqueMessage[OBR][0][13]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($date[1]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Relevant Clinical Information");?>
		</td>
		<?php 	$date=explode('^',$uniqueMessage[OBR][0][13]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($date[4]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information Original Text");?>
		</td>
		<?php 	$date=explode('^',$uniqueMessage[OBR][0][13]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($date[8]);?>
		</td>
	</tr>

	<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace" colspan="2"><strong><?php echo __("Observation Results Information ") ; ?></strong></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result Status");?>
		</td>
		
		<?php// 	$date=explode('^',$result[OBR][0][25]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($uniqueMessage[OBR][0][25]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Results Report/Status change-Date/Time");?>
		</td>
		<?php //	$date=explode('^',$result[OBR][0][22]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __(formatDate($uniqueMessage[OBR][0][22]));?>
		</td>
	</tr>
	
	
	<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace" colspan="2"><strong><?php echo __("Results copy To") ; ?></strong></th>
	</tr>
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Name");?>
		</td>
		<?php $name=explode('^',$uniqueMessage[OBR][0][28]) ;?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $name[5]." ".$name[2]." ".$name[3]." ".$name[1]." ".$name[4];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Identifier number");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($name[0]);?>
		</td>
	</tr>
	
	
	
	

	<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace" colspan="2"><strong><?php echo __("Results Handling") ; ?></strong></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Standard");?>
		</td>
		<?php 	$ResultHand=explode('^',$uniqueMessage[OBR][0][49]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($ResultHand[1]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Local");?>
		</td>
		<?php 	$ResultHand=explode('^',$uniqueMessage[OBR][0][49]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($ResultHand[4]);?>
		</td>
	</tr>
	<?php if($uniqueMessage[NTEX][0][3] != ''){?>
	<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace" colspan="2"><strong><?php echo __("Observation Notes") ; ?></strong></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes and Comments");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($uniqueMessage[NTER][0][3]);?>
		</td>
	</tr>
<?php }?>
</table>


<!-- Observation Details Ends -->



<?php if(!empty($uniqueMessage[TQ1][0][8]) || !empty($uniqueMessage[TQ1][0][7])){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Timing/Quantity Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Start Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php 
		if(!empty($uniqueMessage[TQ1][0][7]))
		echo __(formatDate($uniqueMessage[TQ1][0][7]));?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("End Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php 
		if(!empty($uniqueMessage[TQ1][0][8]))
		echo __(formatDate($uniqueMessage[TQ1][0][8]));?>
		</td>
	</tr>
</table>
<?php }?>
<!-- OBX Starts -->
<?php 
if($resultPerformingLab !=true){
foreach($uniqueMessage['OBX'] as $uniqueObx){
$resultPerformingLab = true;
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Results Performing Laboratory") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Laboratory Name");?>
		</td>
		<?php 	$ResulLab=explode('^',$uniqueObx[23]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($ResulLab[0]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Organization Identifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($ResulLab[9]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Address");?>
		</td>
		<?php 	$ResulLab1=explode('^',$uniqueObx[24]);?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($ResulLab1[0]." ".$ResulLab1[2]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Director Name");?>
		</td>
		<?php 	$ResulLab2=explode('^',$uniqueObx[25]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($ResulLab2[5]." ".$ResulLab2[2]." ".$ResulLab2[3]." ".$ResulLab2[1]." ".$ResulLab2[4]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Director identifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($ResulLab2[0]);?>
		</td>
	</tr>
</table>
<?php 
break;
}
}?>
<!-- OBX ENDS -->


<?php if($specimenDisplayTrue != true){
$specimenDisplayTrue=true;
	?>	
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Specimen Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Type");?>
		</td><?php //echo "<pre>"; print_r($result[SPM][0][4]); exit;?>
	
		<?php 	$Specimen=explode('^',$uniqueMessage[SPM][0][4]); ?>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($Specimen[1]);?>
		</td>
	</tr>
	  	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Specimen Type ");?>
		</td>
		<?php $Specimen=explode('^',$uniqueMessage[SPM][0][4]); ?>
		<?php 	//$Specimen=explode('^',$result_SPM[0][4]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($Specimen[4]);?>
		</td>
	</tr> 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Original Text");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($Specimen[8]);?>
		</td>
	</tr>
	 <tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Start date/time");?>
		</td>
		<?php 	$Specimen=explode('^',$uniqueMessage[SPM][0][17]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php 
		if(!empty($Specimen[0]))
		echo __(formatDate($Specimen[0]));?>
		</td>
	</tr> 
	<tr>
	
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Reject Reason");?>
		</td>
		<?php //echo "<pre>"; print_r($result_SPM[0][21]); exit;?>
		<?php 	$Specimen=explode('^',$uniqueMessage[SPM][0][21]); 
		$SpecimenRejectedStatus = $Specimen[1];
		$SpecimenRejectedStatus1 = $Specimen[4];
		?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($Specimen[1]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Specimen Reject Reason");?>
		</td>
		<?php 	$Specimen=explode('^',$uniqueMessage[SPM][0][21]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php  echo __($Specimen[4]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Reject Reason Original Text");?>
		</td>
		<?php $Specimen=explode('^',$uniqueMessage[SPM][0][21]);?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($Specimen[8]);?>
		</td>
	</tr>
	
	 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Condition ");?>
		</td>
		<?php $Specimen=explode('^',$uniqueMessage[SPM][0][24]); ?>
		<?php 	//$Specimen=explode('^',$result_SPM[0][24]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($Specimen[1]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Specimen Condition ");?>
		</td>
		
		<?php 	 $Specimen=explode('^',$uniqueMessage[SPM][0][24]); ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($Specimen[4]);?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Condition Original Text ");?>
		</td>
		<?php 	$Specimen=explode('^',$uniqueMessage[SPM][0][24]) ?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($Specimen[8]);?>
		</td>
	</tr>
</table>
<?php }?>
<?php 
//$resSepArr = array();
$resSpeRej[] = $SpecimenRejectedStatus;
$resSepArr[] = $uniqueMessage['OBX'] ;
$resSpeRej1[] = $SpecimenRejectedStatus1;
?>


	<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace" colspan="2"><strong><?php echo __("Observation Notes") ; ?></strong></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes and Comments");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($uniqueMessage[NTEX][0][3]);?>
		</td>
	</tr>
</table>
<?php }
	?>
	
	
	<?php 
	$myCnt=0;
	foreach($resSepArr[$myCnt] as $uniqueObxLabs){?>
			
			<?php   
			
			$lab=explode('^',$uniqueObxLabs[3]);
			if($lab[1] == 'Bacteria identified in Stool by Culture'){
				//$TestName1 = $lab[1];
				$specialCaseTrue = true;
				break;
			}
			}
	?>
	
	<?php $myCnt=0; 
	foreach($resSpeRej as $sepRej){
	$SpecimenRejectedStatus = $sepRej;
	$SpecimenRejectedStatus1 = $resSpeRej1[$myCnt];//echo '<pre>';print_r($resSepArr);exit;
	
	?>
	<?php if($SpecimenRejectedStatus == '' && $SpecimenRejectedStatus1 == ''){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<?php if($specialCaseTrue == true && $myCnt != 0){?>
	<tr>
		<th colspan="10"><?php echo __("Lab Results") ; ?></th>
	</tr>
	<?php }else{?>
	<tr>
		<th colspan="8"><?php echo __("Lab Results") ; ?></th>
	</tr>
	<?php }?>
	
	<tr>
	<?php if( ($specialCaseTrue == true && $myCnt != 0) || ($specialCaseTrue != true)){?>
	<?php if($specialCaseTrue == true){?>
	<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Filler Number");?>
		</td>
		<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Test Name");?>
		</td>
	<?php }?>
		<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation");?>
		</td>
		<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result");?>
		</td>
		<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("UOM");?>
		</td>
		<td  valign="middle" class="tdLabel" id="boxspace"><?php echo __("Range");?>
		</td>
		<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Abnormal Flag");?>
		</td>
		<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Status");?>
		</td>
		<td  valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date/Time of note");?>
		</td>
		<td  valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes");?>
		</td>
	</tr>
	<?php if($specialCaseTrue == true){?>
			<tr><td colspan="10"><hr></td></tr>
			<?php }else{?>
			<tr><td colspan="8"><hr></td></tr>
			<?php }?>
	<?php }?>
<?php  //echo '<pre>';print_r($resSepArr);exit;

$firstcheck = false ;
$intCounter=0;
foreach($resSepArr[$myCnt] as $uniqueObxLabs){//echo '<pre>';print_r($uniqueObxLabs);exit;?>
		
		<?php   
		
		$lab=explode('^',$uniqueObxLabs[3]);
		if($lab[1] == 'Bacteria identified in Stool by Culture'){
			$specialCase[] = $uniqueObxLabs;
			$specialCaseTrue = true;
			continue;
		}
		if($myCnt != 0 && $firstcheck == false && $specialCaseTrue == true){
			$uniqueObxLabsTemp1 = $specialCase[$myCnt-1] ;
			$labTemp=explode('^',$uniqueObxLabsTemp1[3]);
			if($uniqueObxLabsTemp1[2] == 'CWE'){
				$resExp = explode('^',$uniqueObxLabsTemp1[5]);
				if(!empty($resExp[1])){
					$lbRes = $resExp[1];
				}else{
					$lbRes = $resExp[8];
				}
				}else if($uniqueObxLabsTemp1[2] == 'SN'){//echo '????';exit;
					$lbRes = str_replace("^", "", $uniqueObxLabsTemp1[5]);
				
				}else{//echo '<pre>';print_r($uniqueObxLabsTemp1);exit;
					$lbRes = $uniqueObxLabsTemp1[5];
				}
			?>
			<tr>
				<?php if($specialCaseTrue == true){?>
				<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($FillerNo1);?>
					</td>
					<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($TestName1);?>
					</td>
				<?php }?>
				<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($labTemp[1]);?>
				</td>
				<?php $resExp = explode('^',$uniqueObxLabsTemp1[5]);?>
				<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($lbRes);?>
				</td>
				<?php 	$lab1=explode('^',$uniqueObxLabsTemp1[6]); //echo "<pre>";print_r($lab1);exit;?>
				<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($lab1[0]);?>
				</td>
				<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($uniqueObxLabsTemp1[7]);?>
				</td>
				<td  valign="middle" class="tdLabel" id="boxspace"><?php echo __($uniqueObxLabsTemp1[8]);?>
				</td>
				<td  valign="middle" class="tdLabel" id="boxspace"><?php echo __($uniqueObxLabsTemp1[11]);?>
				</td>
				<td  valign="middle" class="tdLabel" id="boxspace"><?php echo __(formatDate($uniqueObxLabsTemp1[14]));?>
				</td>
				<td  valign="middle" class="tdLabel" id="boxspace"><?php //echo __($uniqueObxLabsTemp1[14]);?>
				</td>
			</tr>
			<?php if($specialCaseTrue == true){?>
			<tr><td colspan="10"><hr></td></tr>
			<?php }else{?>
			<tr><td colspan="8"><hr></td></tr>
			<?php }?>
			<?php
			$resSepArr[$myCnt] = $specialCase[0];
			$firstcheck = true ;
		}
		 
		
		
			if($uniqueObxLabs[2] == 'CWE'){
			$resExp = explode('^',$uniqueObxLabs[5]);
			if(!empty($resExp[1])){
				$lbRes = $resExp[1];
			}else{
				$lbRes = $resExp[8];
			}
			}else if($uniqueObxLabs[2] == 'SN'){//echo '????';exit;
				$lbRes = str_replace("^", "", $uniqueObxLabs[5]);
			
			}else{//echo '<pre>';print_r($uniqueObxLabs);exit;
				$lbRes = $uniqueObxLabs[5];
			}
		
		?>
		<?php 	
		?>
		
	<tr>
		<?php if($specialCaseTrue == true){?>
				<td valign="middle" class="tdLabel" id="boxspace"><?php 
				if($myCnt == 1)
				echo __($FillerNo2);
				if($myCnt == 2)
					echo __($FillerNo3);
				if($myCnt == 3)
					echo __($FillerNo4);
				
				?>
					</td>
					<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($TestName2);?>
					</td>
				<?php }?>
		<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($lab[1]);?>
		</td>
		<?php $resExp = explode('^',$uniqueObxLabs[5]);?>
		<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($lbRes);?>
		</td>
		<?php 	$lab1=explode('^',$uniqueObxLabs[6]); //echo "<pre>";print_r($lab1);exit;?>
		<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($lab1[0]);?>
		</td>
		<td valign="middle" class="tdLabel" id="boxspace"><?php echo __($uniqueObxLabs[7]);?>
		</td>
		<td  valign="middle" class="tdLabel" id="boxspace"><?php echo __($uniqueObxLabs[8]);?>
		</td>
		<td  valign="middle" class="tdLabel" id="boxspace"><?php echo __($uniqueObxLabs[11]);?>
		</td>
		<td  valign="middle" class="tdLabel" id="boxspace"><?php echo __(formatDate($uniqueObxLabs[14]));?>
		</td>
		<td  valign="middle" class="tdLabel" id="boxspace"><?php //echo __($uniqueObxLabs[14]);?>
		</td>
	</tr>
	<?php if($specialCaseTrue == true){?>
			<tr><td colspan="10"><hr></td></tr>
			<?php }else{?>
			<tr><td colspan="8"><hr></td></tr>
			<?php }?>
	<?php 
	$intCounter++;
}?></table>
	
	<?php }?>
	<?php 
	$myCnt++;
}?>
<?php //echo '<pre>';print_r($specialCase);exit;?>