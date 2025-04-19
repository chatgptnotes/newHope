<?php 
$dailyPaid=0;
foreach($dailyCharge as $daily_charge){
	//if($lab_charge['Billing']['total_amount']>$labTotal)$labTotal=$lab_charge['Billing']['total_amount'];
	$dailyPaid=$dailyPaid+$daily_charge['Billing']['amount'];
	//$dailyPaid=$dailyPaid+$daily_charge['Billing']['discount'];
}

if($roomTariff){ ?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id="serviceGrid">
		<tr class="tbl">
			<th class="table_cell" width="10%" style="border-left:1px solid #3e474a;"><strong><?php echo __('Sr.No.'); ?></strong></th>
			<th class="table_cell" style="border-left:1px solid #3e474a;"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell" style="border-left:1px solid #3e474a;"><strong><?php echo __('Date & Time'); ?></strong></th>
			<?php //if(strtolower($isPrivate['TariffStandard']['name'])!=Configure::read('privateTariffName')){?>
			<?php if($tariffData[$patient['Patient']['tariff_standard_id']]==Configure::read('CGHS')){?>
			<th class="table_cell" style="display:<?php echo $hideCGHSCol ;?>" style="border-left:1px solid #3e474a;border-right:1px solid #3e474a;"><strong><?php echo __('CGHS Code'); ?></strong></th>
			<?php }?>
			<th class="table_cell" align="center" style="border-left:1px solid #3e474a;"><strong><?php echo __('Qty'); ?></strong></th>
			<th class="table_cell" align="right" style="border-left:1px solid #3e474a;border-right:1px solid #3e474a;"><strong><?php echo __('Amount'); ?></strong></th>
		</tr>
		<?php		
			//BOF Room tariff
			$totalAmount=0;
			$r=1;
			$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_rate':'non_nabh_rate' ;
			$rCost = 0 ;
			$g=0;$t=0;
			$packagedMessage = ($isPackaged) ? '</br><i>(excluding package days)</i>' : '';
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
			<td valign="top" class="tdBorderTp" style="border-left:1px solid #3e474a;"><?php echo $r++ ;?></td>
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
		
		 //if($rCost>0){?>
		<!-- <tr>
			<td colspan="6">
			<div class="inner_title" style="border-left:1px solid #3e474a; border-right:1px solid #3e474a;">
	
			<h3 style="float: left;">Sub Total</h3>
			<h3 style="float: right;"><?php 
			//echo $this->Html->image('icons/rupee_symbol.png');
			//echo $this->Number->currency($rCost); ?></h3>
			<div class='clr'></div>
			</div>
			</td>
		</tr> 
		<?php
		//}//EOF Room tariff?>-->
	<tr>
		<?php //if(strtolower($isPrivate['TariffStandard']['name'])!=Configure::read('privateTariffName')){?>
		<?php if($tariffData[$patient['Patient']['tariff_standard_id']]==Configure::read('CGHS')){?>
		<td valign="middle" align="right"></td>
		<?php }?>
		<td colspan="4" valign="middle" align="right"><?php echo __('Total Amount');?></td>
		<td valign="middle" style="text-align: right;"><?php echo $this->Number->format($totalAmount);?></td>
	</tr>
</table>
<?php }?>

<?php if(!empty($dailyCharge)){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both">
	<tr><td >&nbsp;</td></tr>
	<tr>
  		<td style="text-align:center" colspan="5"><strong>Payment Received For Daily Room Charges</strong></td>
  	</tr>
  	
  	<tr>
  	<td>
  		<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm">
		<tr >
		 	<th >Deposit Amount</th>
            <th >Date/Time</th>
            <th >Mode of Payment</th>
            <th >Action</th>
		</tr>
		<?php  $totalpaid=0;
			   $paidtopatient=0;
			   $totalpaidDiscount=0;
		foreach($dailyCharge as $dailyCharge){
			if($dailyCharge['Billing']['refund']=='1'){
				//echo $paidtopatient1=$dailyCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$dailyCharge['Billing']['paid_to_patient'];
				continue;
			}else{
				if(!empty($dailyCharge['Billing']['discount'])){
					//echo $totalpaid1=$dailyCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$dailyCharge['Billing']['discount'];
					$totalpaidDiscount=$totalpaidDiscount+$dailyCharge['Billing']['discount'];
					if(empty($dailyCharge['Billing']['amount']))
						continue;
				} 
			} ?>
		<tr>
			<td align="right"><?php 
			/*if($dailyCharge['Billing']['refund']=='1'){
				echo $paidtopatient1=$dailyCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$paidtopatient1;
			}else{
				if(empty($dailyCharge['Billing']['amount']) && !empty($dailyCharge['Billing']['discount'])){
					echo $totalpaid1=$dailyCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$totalpaid1;
					$totalpaidDiscount=$totalpaidDiscount+$totalpaid1;
				}else*/if(!empty($dailyCharge['Billing']['amount'])){
					echo $totalpaid1=$dailyCharge['Billing']['amount']/*+$dailyCharge['Billing']['discount']*/;
					$totalpaid=$totalpaid+$totalpaid1;
				}
			//}?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($dailyCharge['Billing']['date'],Configure::read('date_format'),true);?></td>
			<!-- <td><?php echo $dailyCharge['Billing']['reason_of_payment'];?></td> -->
			<td><?php echo $dailyCharge['Billing']['mode_of_payment'];?></td>
			<td><?php 
			
			echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteRoomRec',
					'id'=>'deleteRoomRec_'.$dailyCharge['Billing']['id']),array('escape' => false));
			
			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
				 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				 $dailyCharge['Billing']['id']))."', '_blank',
				 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?></td>
		</tr>
		<?php }?> 
		</table>
  	</td>
  	</tr>
  	<tr><td >&nbsp;</td></tr>
  	<!-- <tr>
	<td>
		<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm">
		   <tbody>
				<tr>
					<td align="right" height="35" class="tdLabel2"><strong><?php echo __('Total Amount');?></strong></td>
					<td align="right" height="35" class="tdLabel2"><strong><?php echo __('Total Amount Received');?></strong></td>
					<td align="right" height="35" class="tdLabel2"><strong><?php echo __('Balance Amount');?></strong></td>
		        </tr>
		        <tr>
		            <td align="right" ><?php //echo $dailyCharge['Billing']['total_amount']; ?></td>
		            <td align="right" ><?php //echo $totalpaid;?></td>
		            <td align="right" ><?php //echo $pendingAmt=$dailyCharge['Billing']['total_amount']-$totalpaid;?></td>
		        </tr>
		   </tbody>
		</table>	  			
	</td>
  	</tr> -->
</table>
<?php }?>

<?php //}?>
<script>
//$( '#totalamount', parent.document ).val('<?php //echo $rCost;?>');

$( '#paymentDetail', parent.document ).trigger('reset');
$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
$( '#totaladvancepaid', parent.document ).val('<?php echo $dailyPaid=$dailyPaid/*+$totalpaidDiscount*/;?>');
$( '#totalamountpending', parent.document ).val('<?php echo $totalAmount+$paidtopatient-$dailyPaid-$totalpaidDiscount;?>');
$( '#maintainDiscount', parent.document ).val('<?php echo $totalpaidDiscount;?>');


$('.deleteRoomRec').click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];

	patient_id='<?php echo $patientID;?>';
	tariffStandardId='<?php echo $tariffStandardId;?>';
	 
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
		  type : "POST",
		  //data: formData,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteBillingEntry", "admin" => false)); ?>"+"/"+recId,
		  context: document.body,
		  success: function(data){ 
				  parent.getDailyRoomData(patient_id,tariffStandardId);
				  parent.getbillreceipt(patient_id);		
			  $("#busy-indicator").hide();			  
		  },
		  beforeSend:function(){$("#busy-indicator").show();},		  
		});
	}else{
		return false;
	}
});
</script>