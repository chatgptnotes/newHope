<TABLE  width="100%">

<tr>
	<td valign="top" width="50%">
		<table border="1">

		<TR>
	<TD>name</TD>
	<TD>ward name</TD>
	<td>date</td>
	<TD>regular ward units</TD>
	<TD>regular billing cost</TD>
	 
</TR>
<?php

foreach($collectAllPatientData as $dataKey =>$dataValue){

			$roomTariff=  $dataValue ; 
			//BOF Room tariff
			$totalAmount=0;
			$r=1;
			$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_rate':'non_nabh_rate' ;
			$rCost = 0 ;
			$g=0;$t=0;
			$packagedMessage = ($isPackaged) ? '</br><i>(excluding package days)</i>' : '';
			$bedCharges = array();
			 
			foreach($roomTariff['day'] as $roomKey=>$roomCost){
				$bedCharges[$g][$roomCost['ward']]['bedCost'][] = $roomCost['cost'] ;
				$bedCharges[$g][$roomCost['ward']][] = array('out'=>$roomCost['out'],'in'=>$roomCost['in'],'moa_sr_no'=>$roomCost['moa_sr_no'],'cghs_code'=>$roomCost['cghs_code']);
				if($roomTariff['day'][$roomKey+1]['ward']!=$roomCost['ward']){
					$g++;
				}
			}
		
			foreach($bedCharges as $bedKey=>$bedCost){
					
				$wardNameKey = key($bedCost);
				$bedCost= $bedCost[$wardNameKey];
				$rCost += array_sum($bedCost['bedCost']) ;
				$splitDateIn = explode(" ",$bedCost[0]['in']);
		
				if(count($bedCost)==2 && $bedCost[0]['in']== $bedCost[0]['out']){
					//if(!is_array($bedCharges[$bedKey+1])){
					$nextDay = date('Y-m-d H:i:s',strtotime($splitDateIn[0].'+1 day 10 hours'));
					$lastKey = array('out'=>$nextDay) ;
					/*}else{
					 $nextElement = $bedCharges[$bedKey+1] ;
					 $nextElementKey = key($nextElement);
					 $lastKey  = $nextElement[$nextElementKey][0] ;
					 }*/
				}else{
					$lastKey  = end($bedCost) ;
				}
				$splitDateOut = explode(" ",$lastKey['out']);
				//if($t==0){$t++;
				?>
			<tr>
			<td valign="top" class="tdBorderTp" style="border-left:1px solid #3e474a;"><?php echo $roomTariff['Patient']['name'] ;?></td>
			<td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php echo $wardNameKey;?></td>
			<td class="tdBorderRt tdBorderTp">&nbsp;&nbsp;<?php 
				
			if(!empty($bedCost[0]['in'])){
				$inDate= $this->DateFormat->formatDate2Local($bedCost[0]['in'],Configure::read('date_format'),true);
				//	$splitDateOut  = explode(" ",$bedCost[0]['in']);
				$outDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),true);
				echo $inDate." - ".$outDate;
			}else{
				$inDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),true);
				$outDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),true);
				echo $inDate." - ".$outDate;
			}
			?><?php echo $packagedMessage;?></td>
			<?php //if(strtolower($isPrivate['TariffStandard']['name'])!=Configure::read('privateTariffName')){?>
			<?php if($tariffData[$patient['Patient']['tariff_standard_id']]==Configure::read('CGHS')){?>
			<td align="center" valign="top" class="tdBorderRt tdBorderTp" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $bedCost[0]['cghs_code'];?></td>
			<?php }?>
			<!-- <td align="center" valign="top" class="tdBorderRt tdBorderTp" ><?php echo $bedCost[0]['moa_sr_no'];?></td>
			             -->
			<td align="center" valign="top" class="tdBorderRt tdBorderTp"><?php echo count($bedCost['bedCost'])?></td>
			<td align="right" valign="top" class="tdBorderTp"><?php $totalAmount=$totalAmount+array_sum($bedCost['bedCost']);
			echo $this->Number->format(array_sum($bedCost['bedCost']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
		</tr>

		<?php } 
} ?>
</table>
</td>
<td valign="top" width="50%">
<table border="1">

		<TR>
	<TD>name</TD>
	<TD>ward name</TD>
	<td>date</td>
	<TD>new units</TD>
	<TD>new cost</TD>
	 
</TR>
<?php
$resetWardPatientServiceArray = array();
 
foreach($patientWardUnits as $dummyUnits =>$dummyUnitsVal){
	$resetWardPatientServiceArray[$dummyUnitsVal['Patient']['id']][$dummyUnitsVal['WardPatientService']['tariff_list_id']][] = array(
						'name'	=>$dummyUnitsVal['Patient']['lookup_name'],
						'ward'=>$dummyUnitsVal['TariffList']['name'],
						'cost'=>$dummyUnitsVal['WardPatientService']['amount'],
						'unit'=>$dummyUnitsVal['WardPatientService']['unit'],
						'in'=>$dummyUnitsVal['WardPatientService']['date']) ;
}
 
# pr($resetWardPatientServiceArray);
foreach($resetWardPatientServiceArray as $resetKey => $resetValue){
	foreach($resetValue as $tariffArrayKey => $tariffArrayVal){
		$firstEle = current($tariffArrayVal) ; 

		 
		$lastEle = end($tariffArrayVal); 
		$wardDaysStr = $firstEle['in']."-".$lastEle['in'] ; 
		$wardUnit = '';
		$wardCost = '';
		$name = $firstEle['name'];
		$wardName = $firstEle['ward'];
		foreach($tariffArrayVal as $wardUnitKey => $wardUnitVal){
			$wardUnit += $wardUnitVal['unit'] ;
			$wardCost += $wardUnitVal['cost'] ; 
		}
	
?> 
	<tr>
		<td><?php echo $name; ?></td>
		<td><?php echo $wardName;?></td>
		<td><?php echo $wardDaysStr ;?></td> 
		<td><?php echo $wardUnit;?></td> 
		<td><?php echo $wardCost;?></td>
	</tr>
<?php
	
	}
	}

?> 
</TABLE>