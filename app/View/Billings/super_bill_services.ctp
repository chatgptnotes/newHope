<style>

#ui-datepicker-div{
  position: absolute;
  top: 387.5px;
  left: 1313px !important;

}
</style>

<?php 
echo $this->Html->script('topheaderfreeze') ;
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php  echo 'Super Bill Settlement - <font color="#1A35D5">' .$patientData[0]['Patient']['lookup_name'].' '.$patient[0]['Patient']['patient_id'].'</font>'; ?>
	</h3>
	<span style="float: right"> <?php echo $this->Html->link('Back',array('controller'=>'Corporates','action'=>'corporate_super_bill_list'),
				array('class'=> 'blueBtn','id'=>'backToIpd','escape' => false,'label'=>false,'div'=>false));?>

	</span>
	
</div>
<div class="clr ht5"></div>

<?php echo $this->Form->create('billings',array('url'=>array('controller'=>'billings','action'=>'superBillServices',$superbillData['CorporateSuperBill']['id']),
		'inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)));?>
<div width="100%">
<div style="float: left; width: 70%">
<table class="tabularForm" id="container-table" width="100%">
	<thead>
		<tr>
			<th width="2%">&nbsp;</th>
			<th width="35%">Patient Name</th>
			<th width="15%">Amount</th>
			<th width="3%">&nbsp;</th>
			<th width="15%">Discount</th>
			<!-- <th width="15%">Paid Amount</th> -->
			<th width="15%">Balance Amount</th>
		</tr>
	</thead>
	<tbody>
<?php
//Calculating total bill amount of all encounters
foreach ($patientArray as $total){
	$totalBillAmount=$totalBillAmount+$total['totalAmount'];
}
//$totalBillAmount=round($totalBillAmount); 
//Setting total bill value and recieved amount in hidden variables
echo $this->Form->input('Billing.encounterTotalBill',array('type'=>'hidden','readonly'=>'readonly','label'=>false,'value'=>round($totalBillAmount)));
echo $this->Form->input('Billing.encounterRecievedAmount',array('type'=>'hidden','id'=>'received_amt','label'=>false,'value'=>''));

//Calculating the percentage of recived amount from total bill amount for sharing equal % amount to each encounter bill
$recievedAmount=$superbillData['CorporateSuperBill']['received_amount'];
$percentAmount=($recievedAmount/round($totalBillAmount))*100;

echo $this->Form->input('Billing.percent',array('type'=>'hidden','readonly'=>'readonly','id'=>'percent','label'=>false,'value'=>''));
//Calculating amount of each encounter according to sharing percent
/*$count=0;
foreach ($patientArray as $percentDiv){
	$shareAmount=($percentDiv['totalAmount']*$percentAmount)/100;
	$patientArray[$percentDiv['patient_id']]['percentShare']=$shareAmount;
	$checkAmt=$checkAmt+$shareAmount;
	$shareAmount=0;
	$count++;
}*/

//Caculation for excess distribution or less distribution of recived amount and accordingly subtract extra share or add extra share to individual encounter
/*if($checkAmt!=$recievedAmount){
	if($checkAmt > $recievedAmount){//If distributed amt is greater than recived amount then deduct equally from each encounter
		$amtDeduct=$checkAmt-$recievedAmount;
		$deductEach=$amtDeduct/$count;
		foreach ($patientArray as $dedAmt){
			$patientArray[$dedAmt['patient_id']]['percentShare']=$patientArray[$dedAmt['patient_id']]['percentShare']-$deductEach;			
		}
				
	}else if($checkAmt < $recievedAmount){//If distributed amt is less than recived amount then add equally to each encounter
		$amtextra=$recievedAmount-$checkAmt;
		$extraEach=$amtDeduct/$count;
		foreach ($patientArray as $exAmt){
			$patientArray[$exAmt['patient_id']]['percentShare']=$patientArray[$exAmt['patient_id']]['percentShare']+$extraEach;
		}
	}
}*/

/****************************************************************************************************************/
$i=1;
foreach($patientData as $patient){
	echo $this->Form->input('Billing.encounter.'.$patient['Patient']['id'].'.totalAmount',array('type'=>'hidden','readonly'=>'readonly','class'=>'shareAmt','id'=>'encTotal_'.$patient['Patient']['id'],'patientId'=>$patient['Patient']['id'],'value'=>round($patientArray[$patient['Patient']['id']]['totalAmount'])));
	echo $this->Form->input('Billing.encounter.'.$patient['Patient']['id'].'.shareAmount',array('type'=>'hidden','readonly'=>'readonly','id'=>'share_'.$patient['Patient']['id'],'value'=>round($patientArray[$patient['Patient']['id']]['percentShare'])));
	$rowid="patient_".$patient['Patient']['id'];
	$containerid="container-table_".$i;
	echo "<tr id=$containerid><td class=parentClass id=$rowid>+</td>";
	echo '<td>'.$patient['Patient']['lookup_name'].' ('.$this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),false).')</td>';
	if($patientArray[$patient['Patient']['id']]['totalAmount'] <=0){
		$patientArray[$patient['Patient']['id']]['totalAmount']=0;
	}
	echo '<td>'.$this->Number->format(round($patientArray[$patient['Patient']['id']]['totalAmount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
	echo '<td>&nbsp;</td>';
	echo '<td>&nbsp;</td>';
	//echo '<th>&nbsp;</th>';
	echo '<td>&nbsp;</td>';
	echo '</tr>';
	$rowChild="child_".$patient['Patient']['id'];
	echo "<tr id=$rowChild style='display: none'><td colspan=7>";
	echo '<table width=100% class=table_format>';
		if($consultantArray[$patient['Patient']['id']]){
			echo consultantHtml($patient['Patient']['id'],$consultantArray,$this->Form,$this->Number,$serviceCategory,$serviceCategoryName);
		}
		if($serviceArray[$patient['Patient']['id']]){
			echo serviceHtml($patient['Patient']['id'],$serviceArray,$serviceCatData,$this->Form,$this->Number,$serviceCategory,$serviceCategoryName);
		}
		if($labArray[$patient['Patient']['id']]){
			echo labHtml($patient['Patient']['id'],$labArray,$this->Form,$this->Number,$serviceCategory,$serviceCategoryName);
		}
		if($radArray[$patient['Patient']['id']]){
			echo radHtml($patient['Patient']['id'],$radArray,$this->Form,$this->Number,$serviceCategory,$serviceCategoryName);
		}
		if($wardArray[$patient['Patient']['id']]){
			echo wardHtml($patient['Patient']['id'],$wardArray,$this->Form,$this->Number,$serviceCategory,$serviceCategoryName);
		}
		if($surgeryArray[$patient['Patient']['id']]){
			echo surHtml($patient['Patient']['id'],$surgeryArray,$this->Form,$this->Number,$serviceCategory,$serviceCategoryName);
		}
		if($pharArray[$patient['Patient']['id']]){
			echo pharHtml($patient['Patient']['id'],$pharArray,$this->Form,$this->Number,$serviceCategory,$serviceCategoryName);
		}
		if($otpharArray[$patient['Patient']['id']]){
			echo otPharHtml($patient['Patient']['id'],$otpharArray,$this->Form,$this->Number,$serviceCategory,$serviceCategoryName);
		}
	echo '</table>';
    echo '</td></tr>';  
    $i++;
}
?>

</tbody>
</table>
</div>
<div width="20%" style="float: right">
	<table width="100%" cellspacing='0' cellpadding='0'>
		<tr class="row_gray">
			<td style="padding: 0px 0px 0px 2px; height: 30px; " id="totBill" ><b>Total Bill</b></td>
			<td style="text-align:right;font-weight: bold; font-size: 18px;color: #CB681E"><?php echo round($totalBillAmount);?></td>
		</tr>
		<tr>
			<td style="padding: 0px 0px 0px 2px; height: 30px" ><b>Card Balance:</b></td>
			<td id=card style="text-align:right; font-weight: bold; font-size: 18px;"><?php echo isset($patientCard['Account']['card_balance'])?$patientCard['Account']['card_balance']:'0';?></td>
			<?php echo $this->Form->hidden('Billing.card_balance',array('id'=>'card_balance','value'=>$patientCard['Account']['card_balance']));?>
		</tr>
		<tr class="row_gray">
			<td style="padding: 0px 0px 0px 2px; height: 30px" ><b>Amount Received From Company : </b></td>
			<?php if($advanceAmount){
						$remainAdv=$advanceAmount[0]['advance']-$advanceAmount[0]['paidAdvance'];
					}else $remainAdv=0; ?>
			<td id=remainAdv style="text-align:right; font-weight: bold; font-size: 18px;">					
			<?php echo $remainAdv;?>		
			</td>
		</tr>
		<tr>
			<td style="padding: 0px 0px 0px 2px; height: 30px" ><b>Total Received Amount</b></td>
			<?php $remainAdv=$remainAdv+$patientCard['Account']['card_balance'];?>
			<td class='totalReceived' style="text-align:right; font-weight: bold; font-size: 18px;"> <?php echo $remainAdv;?></td>
			<?php echo $this->Form->input('Billing.totalRec',array('type'=>'hidden','readonly'=>'readonly','class'=>'totalReceived','value'=>$remainAdv))?>
		</tr>
		<tr class="row_gray">
			<td style="padding: 0px 0px 0px 2px; height: 30px" ><b>Discount Amount :</b></td>
			<?php if($remainAdv < $totalBillAmount)
				$discount=$totalBillAmount-$remainAdv/*-$patientCard['Account']['card_balance']*/;
			else $discount=0;?>
			<td id=discountAmt style="text-align:right; font-weight: bold; font-size: 18px;"><?php echo $discount;?></td>
		</tr>
		<tr>
			<td style="padding: 0px 0px 0px 2px; height: 30px" ><b>Settled Amount :</b></td>
			<?php $settleAmt=$totalBillAmount-$discount; ?>
			<?php echo $this->Form->hidden('Billing.settledAmt',array('class'=>'settleAmt','value'=>round($settleAmt)));?>		
			<td class=settleAmt style="text-align:right; font-weight: bold; font-size: 18px;">					
			<?php echo $settleAmt;?>
			</td>
		</tr>
		<tr>
			<td style="padding: 0px 0px 0px 2px; height: 30px" ><b>Round Off Amount :</b></td>
			<td class=roundAmt style="text-align:right; font-weight: bold; font-size: 18px;">					
			<?php echo round($settleAmt);?>
			</td>
		</tr>
		<tr class="row_gray">
			<td style="padding: 0px 0px 0px 2px; height: 30px" ><b>Mode Of Payment : </b></td>
			<td style="text-align:right; font-weight: bold; font-size: 18px;">
			<?php echo 'CORPORATE';
			echo $this->Form->input('Billing.payment_mode',array('type'=>'hidden','readonly'=>'readonly','id'=>'payment_mode','value'=>'Corporate'))?>
			</td>
		</tr>
		<tr>
			<td style="padding: 0px 0px 0px 2px; height: 30px" ><b>Settlement Date : </b></td>
			<td style="text-align:right; font-weight: bold; font-size: 18px;">
			<?php echo $this->Form->input('Billing.date',array('type'=>'text','id'=>'date','value'=>date('d/m/Y H:i:s'),'style'=>'float: left'));?>					
			</td>
		</tr>		
		<tr><td colspan="2"><?php echo $this->Form->button('Submit',array('type'=>'Submit','id'=>'submit','class'=>'blueBtn'))?></td></tr>
<?php
echo $this->Form->hidden('Billing.advance_used',array('id'=>'advance_balance'));
echo $this->Form->hidden('Billing.advance_not_used',array('id'=>'advance_not_used_balance'));
?>
</table>
</div>
</div>
<?php echo $this->Form->end();?>
<?php 
	function consultantHtml($patientId,$consultantArray,$formInput,$numberFormat,$serviceCategory,$serviceCategoryName){
		foreach($serviceCategory as $serviceKey=>$category){
			if($category==Configure::read('Consultant')){
				$consultantHtml.= '<tr><td colspan=7><b>'.$serviceCategoryName[$serviceKey].'</b>';
				$consultantHtml.= '</td></tr>';
				foreach($consultantArray[$patientId] as $consultant){
					$consultantHtml.='<tr>';
					$consultant_id=$consultant['table_id'];
					$balanceAmount=$consultant['amount']-$consultant['paid_amount']-$consultant['discount'];
					if($balanceAmount<=0)
						$balanceAmount=0.00;
					$consultantHtml.='<td width="2%">'.$formInput->input("Billing.".$patientId.".$category.".$consultant_id.".valChk",
											array('type'=>'hidden','class'=>'chk_service','id'=>"service_$category_$consultant_id",'checked'=>'checked','label'=>false,'value'=>$balanceAmount)).'</td>';
					$consultantHtml.='<td width="35%">'.$consultant['name'].'</td>';
					$consultantHtml.='<td width="15%">'.$numberFormat->format($consultant['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$consultantHtml.=$formInput->input("Billing.".$patientId.".$category.".$consultant_id.".amount",
							array('type'=>'hidden','label'=>false,'value'=>$consultant['amount']));
					$consultantHtml.='<td width="3%">1</td>';
					$consultantHtml.='<td width="15%">'.$numberFormat->format($consultant['discount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$consultantHtml.=$formInput->input("Billing.".$patientId.".$category.".$consultant_id.".discount",
							array('type'=>'hidden','label'=>false,'value'=>$consultant['discount']));
					/*$consultantHtml.='<td width="15%">'.$numberFormat->format($consultant['paid_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$consultantHtml.=$formInput->input("Billing.".$patientId.".$category.".$consultant_id.".paid_amount",
							array('type'=>'hidden','label'=>false,'value'=>$consultant['paid_amount']));*/
					$consultantHtml.='<td width="15%">'.$numberFormat->format($balanceAmount,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$consultantHtml.=$formInput->input("Billing.".$patientId.".$category.".$consultant_id.".balAmt",
							array('type'=>'hidden','label'=>false,'value'=>$balanceAmount));
					$consultantHtml.'</tr>';			
				}
				
			}		
		}
		
		return $consultantHtml;
		
	}
	
	function serviceHtml($patientId,$serviceArray,$catDrawData,$formInput,$numberFormat,$serviceCategory,$serviceCategoryName){
		foreach($serviceCategory as $serviceKey=>$category){
			if(/*$category!=Configure::read('mandatoryservices') &&*/ $category!=Configure::read('radiologyservices') &&
			   $category!=Configure::read('laboratoryservices') && $category!=Configure::read('RoomTariff') &&
			   $category!=Configure::read('Pharmacy') && $category!=Configure::read('OtPharmacy') &&
			   $category!=Configure::read('Consultant') && $category!=Configure::read('surgeryservices')){
				if($catDrawData[$patientId][$serviceKey]){
					$serviceHtml.= '<tr><td colspan=7><b>'.$serviceCategoryName[$serviceKey].'</b>';
				   	$serviceHtml.= '</td></tr>';
							foreach($serviceArray[$patientId] as $service){
								if($serviceKey==$service['service_id']){
								$serviceHtml.='<tr>';
								$service_bill_id=$service['table_id'];
								$balanceAmount=($service['amount']*$service['no_of_times'])-$service['paid_amount']-$service['discount'];
								if($balanceAmount<=0)
									$balanceAmount=0.00;
								$serviceHtml.='<td width="2%">'.$formInput->input("Billing.".$patientId.".$category.".$service_bill_id.".valChk",
										array('type'=>'hidden','class'=>'chk_service','id'=>"service_$category_$service_bill_id",'checked'=>'checked','label'=>false,'value'=>$balanceAmount)).'</td>';
								$serviceHtml.='<td width="35%">'.$service['name'].'</td>';
								$serviceHtml.='<td width="15%">'.$numberFormat->format($service['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
								$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$service_bill_id.".amount",
										array('type'=>'hidden','label'=>false,'value'=>$service['amount']));
								$serviceHtml.='<td width="3%">'.$service['no_of_times'].'</td>';
								$serviceHtml.='<td width="15%">'.$numberFormat->format($service['discount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
								$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$service_bill_id.".discount",
										array('type'=>'hidden','label'=>false,'value'=>$service['discount']));
								/*$serviceHtml.='<td width="15%">'.$numberFormat->format($service['paid_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
								$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$service_bill_id.".paid_amount",
										array('type'=>'hidden','label'=>false,'value'=>$service['paid_amount']));*/
								$serviceHtml.='<td width="15%">'.$numberFormat->format($balanceAmount,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
								$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$service_bill_id.".balAmt",
										array('type'=>'hidden','label'=>false,'value'=>$balanceAmount));
								$serviceHtml.'</tr >';
								}
							}						
						}
			 }
		}
		return $serviceHtml;
	}
	
	function labHtml($patientId,$labArray,$formInput,$numberFormat,$serviceCategory,$serviceCategoryName){
		foreach($serviceCategory as $serviceKey=>$category){
			if($category==Configure::read('laboratoryservices')){
				$serviceHtml.= '<tr><td colspan=7><b>'.$serviceCategoryName[$serviceKey].'</b>';
				$serviceHtml.= '</td></tr>';
				foreach($labArray[$patientId] as $service){
					$serviceHtml.='<tr>';
					$labTestOrder_id=$service['table_id'];
					$balanceAmount=($service['amount'])-$service['paid_amount']-$service['discount'];
					if($balanceAmount<=0)
						$balanceAmount=0.00;
					$serviceHtml.='<td width="2%">'.$formInput->input("Billing.".$patientId.".$category.".$labTestOrder_id.".valChk",
							array('type'=>'hidden','class'=>'chk_service','id'=>"service_$category_$labTestOrder_id",'checked'=>'checked','label'=>false,'value'=>$balanceAmount)).'</td>';
					$serviceHtml.='<td width="35%">'.$service['name'].'</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$labTestOrder_id.".amount",
							array('type'=>'hidden','label'=>false,'value'=>$service['amount']));
					$serviceHtml.='<td width="3%">1</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['discount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$labTestOrder_id.".discount",
							array('type'=>'hidden','label'=>false,'value'=>$service['discount']));
					/*$serviceHtml.='<td width="15%">'.$numberFormat->format($service['paid_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$labTestOrder_id.".paid_amount",
							array('type'=>'hidden','label'=>false,'value'=>$service['paid_amount']));*/
					$serviceHtml.='<td width="15%">'.$numberFormat->format($balanceAmount,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$labTestOrder_id.".balAmt",
							array('type'=>'hidden','label'=>false,'value'=>$balanceAmount));
					$serviceHtml.'</tr >';
				}
			}
		}
		return $serviceHtml;
		
	}
	
	function radHtml($patientId,$radArray,$formInput,$numberFormat,$serviceCategory,$serviceCategoryName){
		foreach($serviceCategory as $serviceKey=>$category){
			if($category==Configure::read('radiologyservices')){
				$serviceHtml.= '<tr><td colspan=7><b>'.$serviceCategoryName[$serviceKey].'</b>';
				$serviceHtml.= '</td></tr>';
				foreach($radArray[$patientId] as $service){
					$serviceHtml.='<tr>';
					$radTestOrder_id=$service['table_id'];
					$balanceAmount=($service['amount'])-$service['paid_amount']-$service['discount'];
					if($balanceAmount<=0)
						$balanceAmount=0.00;
					$serviceHtml.='<td width="2%">'.$formInput->input("Billing.".$patientId.".$category.".$radTestOrder_id.".valChk",
							array('type'=>'hidden','class'=>'chk_service','id'=>"service_$category_$radTestOrder_id",'checked'=>'checked','label'=>false,'value'=>$balanceAmount)).'</td>';
					$serviceHtml.='<td width="35%">'.$service['name'].'</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$radTestOrder_id.".amount",
							array('type'=>'hidden','label'=>false,'value'=>$service['amount']));
					$serviceHtml.='<td width="3%">1</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['discount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$radTestOrder_id.".discount",
							array('type'=>'hidden','label'=>false,'value'=>$service['discount']));
					/*$serviceHtml.='<td width="15%">'.$numberFormat->format($service['paid_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$radTestOrder_id.".paid_amount",
							array('type'=>'hidden','label'=>false,'value'=>$service['paid_amount']));*/
					$serviceHtml.='<td width="15%">'.$numberFormat->format($balanceAmount,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$radTestOrder_id.".balAmt",
							array('type'=>'hidden','label'=>false,'value'=>$balanceAmount));
					$serviceHtml.'</tr >';
				}
			}
		}
		return $serviceHtml;
	}
	
	function wardHtml($patientId,$wardArray,$formInput,$numberFormat,$serviceCategory,$serviceCategoryName){
		foreach($serviceCategory as $serviceKey=>$category){
			if($category == Configure::read('RoomTariff')){
				$serviceHtml.= '<tr><td colspan=7><b>'.$serviceCategoryName[$serviceKey].'</b>';
				$serviceHtml.= '</td></tr>';
				$i=0;
				foreach($wardArray[$patientId] as $service){
					$serviceHtml.='<tr>';
					$balanceAmount=($service['amount'])-$service['paid_amount']-$service['discount'];
					if($balanceAmount<=0)
						$balanceAmount=0.00;
					$serviceHtml.='<td width="2%">'.$formInput->input("Billing.".$patientId.".$category.".$i.".valChk",
							array('type'=>'hidden','class'=>'chk_service','id'=>"service_$category_ward",'checked'=>'checked','label'=>false,'value'=>$balanceAmount)).'</td>';
					$serviceHtml.='<td width="35%">'.$service['name'].'</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".serviceAmt",
							array('type'=>'hidden','label'=>false,'value'=>$service['amount']));
					$serviceHtml.='<td width="3%">1</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['discount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".discount",
							array('type'=>'hidden','label'=>false,'value'=>$service['discount']));
					/*$serviceHtml.='<td width="15%">'.$numberFormat->format($service['paid_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".paid_amount",
							array('type'=>'hidden','label'=>false,'value'=>$service['paid_amount']));*/
					$serviceHtml.='<td width="15%">'.$numberFormat->format($balanceAmount,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".balAmt",
							array('type'=>'hidden','label'=>false,'value'=>$balanceAmount));
					$serviceHtml.'</tr >';
				}
				
			}
		}
		return $serviceHtml;
	}
	
	
	function pharHtml($patientId,$pharArray,$formInput,$numberFormat,$serviceCategory,$serviceCategoryName){
		foreach($serviceCategory as $serviceKey=>$category){
			if($category == Configure::read('Pharmacy')){
				$serviceHtml.= '<tr><td colspan=7><b>'.$serviceCategoryName[$serviceKey].'</b>';
				$serviceHtml.= '</td></tr>';
				$i=0;
				foreach($pharArray[$patientId] as $service){
					$serviceHtml.='<tr>';
					$balanceAmount=($service['amount'])-$service['paid_amount']-$service['discount'];
					if($balanceAmount<=0)
						$balanceAmount=0.00;
					$serviceHtml.='<td width="2%">'.$formInput->input("Billing.".$patientId.".$category.".$i.".valChk",
							array('type'=>'hidden','class'=>'chk_service','id'=>"service_$category_phar",'checked'=>'checked','label'=>false,'value'=>$balanceAmount)).'</td>';
					$serviceHtml.='<td width="35%">'.$service['name'].'</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".serviceAmt",
							array('type'=>'hidden','label'=>false,'value'=>$service['amount']));
					$serviceHtml.='<td width="3%">1</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['discount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".discount",
							array('type'=>'hidden','label'=>false,'value'=>$service['discount']));
					/*$serviceHtml.='<td width="15%">'.$numberFormat->format($service['paid_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".paid_amount",
							array('type'=>'hidden','label'=>false,'value'=>$service['paid_amount']));*/
					$serviceHtml.='<td width="15%">'.$numberFormat->format($balanceAmount,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".balAmt",
							array('type'=>'hidden','label'=>false,'value'=>$balanceAmount));
					$serviceHtml.'</tr >';
				}
	
			}
		}
		return $serviceHtml;
	}
	
	function otPharHtml($patientId,$otpharArray,$formInput,$numberFormat,$serviceCategory,$serviceCategoryName){
		foreach($serviceCategory as $serviceKey=>$category){
			if($category == Configure::read('OtPharmacy')){
				$serviceHtml.= '<tr><td colspan=7><b>'.$serviceCategoryName[$serviceKey].'</b>';
				$serviceHtml.= '</td></tr>';
				$i=0;
				foreach($otpharArray[$patientId] as $service){
					$serviceHtml.='<tr>';
					$balanceAmount=($service['amount'])-$service['paid_amount']-$service['discount'];
					if($balanceAmount<=0)
						$balanceAmount=0.00;
					$serviceHtml.='<td width="2%">'.$formInput->input("Billing.".$patientId.".$category.".$i.".valChk",
							array('type'=>'hidden','class'=>'chk_service','id'=>"service_$category_otPhar",'checked'=>'checked','label'=>false,'value'=>$balanceAmount)).'</td>';
					$serviceHtml.='<td width="35%">'.$service['name'].'</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".serviceAmt",
							array('type'=>'hidden','label'=>false,'value'=>$service['amount']));
					$serviceHtml.='<td width="3%">1</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['discount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".discount",
							array('type'=>'hidden','label'=>false,'value'=>$service['discount']));
					/*$serviceHtml.='<td width="15%">'.$numberFormat->format($service['paid_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".paid_amount",
							array('type'=>'hidden','label'=>false,'value'=>$service['paid_amount']));*/
					$serviceHtml.='<td width="15%">'.$numberFormat->format($balanceAmount,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$i.".balAmt",
							array('type'=>'hidden','label'=>false,'value'=>$balanceAmount));
					$serviceHtml.'</tr >';
				}
	
			}
		}
		return $serviceHtml;
	}
	
	function surHtml($patientId,$surArray,$formInput,$numberFormat,$serviceCategory,$serviceCategoryName){
		foreach($serviceCategory as $serviceKey=>$category){
			if($category==Configure::read('surgeryservices')){
				$serviceHtml.= '<tr><td colspan=7><b>'.$serviceCategoryName[$serviceKey].'</b>';
				$serviceHtml.= '</td></tr>';
				foreach($surArray[$patientId] as $service){
					$serviceHtml.='<tr>';
					$optApp_id=$service['table_id'];
					$balanceAmount=($service['amount'])-$service['paid_amount']-$service['discount'];
					if($balanceAmount<=0)
						$balanceAmount=0.00;
					$serviceHtml.='<td width="2%">'.$formInput->input("Billing.".$patientId.".$category.".$optApp_id.".valChk",
							array('type'=>'hidden','class'=>'chk_service','id'=>"service_$category_$optApp_id",'checked'=>'checked','label'=>false,'value'=>$balanceAmount)).'</td>';
					$serviceHtml.='<td width="35%">'.$service['name'].'</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$optApp_id.".amount",
							array('type'=>'hidden','label'=>false,'value'=>$service['amount']));
					$serviceHtml.='<td width="3%">1</td>';
					$serviceHtml.='<td width="15%">'.$numberFormat->format($service['discount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$optApp_id.".discount",
							array('type'=>'hidden','label'=>false,'value'=>$service['discount']));
					/*$serviceHtml.='<td width="15%">'.$numberFormat->format($service['paid_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
						$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$labTestOrder_id.".paid_amount",
								array('type'=>'hidden','label'=>false,'value'=>$service['paid_amount']));*/
					$serviceHtml.='<td width="15%">'.$numberFormat->format($balanceAmount,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)).'</td>';
					$serviceHtml.=$formInput->input("Billing.".$patientId.".$category.".$optApp_id.".balAmt",
							array('type'=>'hidden','label'=>false,'value'=>$balanceAmount));
					$serviceHtml.'</tr >';
				}
			}
		}
		return $serviceHtml;
	
	}
?>

<script>
$(function() {
$("#date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});
});	
var count="<?php echo $i; ?>";
$("#container-table").freezeHeader({ 'height': '500px' });
for(var i=1;i<=count;i++){
	$("#container-table_"+i).freezeHeader({ 'height': '150px' });
}

$(document).ready(function(){	
	defaultCal();
});
function defaultCal(){
	var totalBill=<?php echo $totalBillAmount;?>;
	var prevAdv=$('#remainAdv').text();
	var cardAmt=$('#card').text();
	if(cardAmt)
		total=parseFloat(prevAdv)+parseFloat(cardAmt);
	else
		total=parseFloat(prevAdv);
	if(parseFloat(total) < parseFloat(totalBill))
		discount=parseFloat(totalBill)- parseFloat(total);
	else
		discount=0;	
	$('#discountAmt').text(Math.round(parseFloat(discount)));
	if(parseFloat(total)>parseFloat(totalBill))
		percent=100;
	else
		percent=parseFloat((total/totalBill)*100);
	$('#percent').val(parseFloat(percent));
	shareAmt();
	checkAdvance();
}
/*$('#amt_recieved').keyup(function(){
	var totalBill=<?php echo $totalBillAmount;?>;
	var value=$(this).val();	
	var prevAdv=$('#remainAdv').text();
	var cardAmt=$('#card').text();
	var discount=0;
	if(!value){
		value=0;
	}
	if(!cardAmt)
		cardAmt=0;
	total=parseFloat(value)+parseFloat(prevAdv)+parseFloat(cardAmt);	
	if(parseFloat(total)>parseFloat(totalBill)){
		alert("Amount Received Is Greater Than Total Super Bill Amount");
		total=parseFloat(prevAdv)+parseFloat(cardAmt);
		$('#totalReceived').val(total);
		$('#amt_recieved').val('0');
		//total=0;
	}else{		
			$('#totalReceived').val(parseFloat(total));		
	}
	if(total==0){
		total=parseFloat(prevAdv)+parseFloat(cardAmt);
	}
	if(parseFloat(total) < parseFloat(totalBill))
		discount=parseFloat(totalBill)- parseFloat(total);
	else
		discount=0;
			
	$('#discountAmt').text(parseFloat(discount));
	var percent=parseFloat((total/totalBill)*100);
	$('#percent').val(parseFloat(percent));
	settleAmt=parseFloat(totalBill)-parseFloat(discount);
	$('.settleAmt').val(settleAmt);
	$('.settleAmt').text(settleAmt);
	shareAmt();
	checkAdvance();
	//$('.totalReceived').val(parseFloat(total));
});*/

function shareAmt(){
	$('.shareAmt').each(function(){
		var patientId=$(this).attr('patientId');
		var encTotal=$('#encTotal_'+patientId).val();
		var percent = $('#percent').val();
		var shareAmt=parseFloat(encTotal*percent/100);
		var discount=parseFloat(encTotal-shareAmt);
		$('#share_'+patientId).val(shareAmt);
		
	});
}
//Advance calculations
function checkAdvance(){
	var notUsedAdvance='0';		
	var paidAdvance="<?php echo $advanceAmount[0]['paidAdvance'];?>"
		var advance="<?php echo $advanceAmount[0]['advance'];?>";
		var diffAdvance='0';
		if(parseFloat(paidAdvance) < parseFloat(advance)){
			diffAdvance=parseFloat(advance)-parseFloat(paidAdvance);
		}
		var totalBill=<?php echo $totalBillAmount;?>;
		selectedValue=totalBill;//$('#totalReceived').val();
		if(parseFloat(selectedValue)!='0'){
		if(parseFloat(selectedValue)< parseFloat(diffAdvance)){
			notUsedAdvance=parseFloat(diffAdvance)-parseFloat(selectedValue);
			diffAdvance=parseFloat(selectedValue);
			
		}else{
			subAmt=parseFloat(selectedValue)-parseFloat(diffAdvance);
		}
		diffAdvance=Math.round(diffAdvance)
		$('#advance_balance').val(diffAdvance);
		notUsedAdvance=Math.round(notUsedAdvance);
		$('#advance_not_used_balance').val(notUsedAdvance);
	}
};

$('.parentClass').click(function(event){
var id=$(this).attr('id');
var splitId=id.split('_');
var patientId=splitId[1];
$('#child_'+patientId).toggle();
});
</script>