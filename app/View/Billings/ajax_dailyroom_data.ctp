<?php $website  = $this->Session->read('website.instance');
		$isPackaged = ($patient['Patient']['is_packaged']) ? true : false;?>
<?php 
$dailyPaid=0;
foreach($dailyCharge as $daily_charge){
	//if($lab_charge['Billing']['total_amount']>$labTotal)$labTotal=$lab_charge['Billing']['total_amount'];
	$dailyPaid=$dailyPaid+$daily_charge['Billing']['amount'];
	//$dailyPaid=$dailyPaid+$daily_charge['Billing']['discount'];
}?>

<?php if($roomTariff){ ?>
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
		
			foreach($bedCharges as $bedKey=>$bedCost){//debug($bedCost);
					
				$wardNameKey = key($bedCost);
				$bedCost= $bedCost[$wardNameKey];
				$rCost += array_sum($bedCost['bedCost']) ;
				$splitDateIn = explode(" ",$bedCost[0]['in']);
		
				if(count($bedCost)==2 && $bedCost[0]['in']== $bedCost[0]['out']){
					//if(!is_array($bedCharges[$bedKey+1])){
					#$nextDay = date('Y-m-d H:i:s',strtotime($splitDateIn[0].'+1 day 10 hours'));
					$nextDay =   $bedCost[0]['in'];
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
				$inDate= $this->DateFormat->formatDate2Local($bedCost[0]['in'],Configure::read('date_format'),false);
				//	$splitDateOut  = explode(" ",$bedCost[0]['in']);
				$outDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),false);
				echo $inDate." - ".$outDate; // only in date is required
			}else{
				$inDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),false);
				$outDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),false);
				echo $inDate." - ".$outDate; // only in date is required
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
		<?php }?>
		 
	<tr>
		<?php //if(strtolower($isPrivate['TariffStandard']['name'])!=Configure::read('privateTariffName')){?>
		<?php if($tariffData[$patient['Patient']['tariff_standard_id']]==Configure::read('CGHS')){?>
		<td valign="middle" align="right"></td>
		<?php }?>
		<td colspan="4" valign="middle" align="right"><?php echo __('Total Amount');?></td>
		<td valign="middle" style="text-align: right;"><?php echo $this->Number->format($totalAmount);?></td>
	</tr>
</table>
<?php } ?>

<div>&nbsp;</div>
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div style="height: 25px"><?php 
	//echo $this->Html->link('Add Ward Patient Service','javascript:void(0)',array('id'=>'addWardPatientService','class'=>'blueBtn cancelRoomService','escape' => false));
	echo $this->Html->link('Add Ward',array('controller'=>'billings','action'=>'updateService'),array('escape' => false,'id'=>'addWardPatientService',
		'class'=>'blueBtn cancelRoomService billingServicesAction'));
?></div>
<?php }?>
<?php echo $this->Form->create('WardPatientService',array('id'=>'addWardFrm','label'=>false,'div'=>false));?>
<div id="addWardPatientServiceArea" style="height: 75px; display: none;" >
<table width="100%" cellpadding="0" cellspacing="1" border="1" style="clear:both" class="tabularForm" >
	<tr>
		<th>Ward</th>
		<?php if($website=='vadodara'){?>
		<th>Room</th>
		<?php }?>
		<th>Date</th>
		<th>Amount</th>
		<th>Action</th>
	</tr>
	<tr >
		<td>
		<?php echo $this->Form->input('',array('type'=>'select','empty'=>'Please Select','options'=>$allWardList,'id'=>'addWard','label'=>false,'div'=>false,'error'=>false,'class'=>'wardListOther wardList validate[required,custom[mandatory-select]] textBoxExpnd addWard',
				'name'=>"WardPatientService[ward_id][]"));?></td> 
		<?php if($website=='vadodara'){?>		
		<td>
		<?php echo $this->Form->input('',array('type'=>'select','empty'=>'Please Select','id'=>'addRoom','label'=>false,'div'=>false,'error'=>false,'class'=>'roomList validate[required,custom[mandatory-select]] textBoxExpnd addRoom',
				'name'=>"WardPatientService[room_id][]"));?>
		</td>
		<?php }?>
		<td ><?php echo $this->Form->input('', array('type'=>'text','id' => 'addRoomDate','label'=>false,'div'=>false,'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  addRoomDate',
				'style'=>'width:120px;','readonly'=>'readonly','name'=>'WardPatientService[date][]'));  ?></td>
		
		<td><?php echo $this->Form->input('', array('name'=>'WardPatientService[amount][]','type'=>'text','label'=>false,'id' => 'addRoomAomunt','style'=>'text-align:right',
				'class'=> 'validate[required,custom[mandatory-enter]] textBoxExpnd addRoomAomunt','div'=>false,'readonly'=>'readonly'));?></td>
		
		<td><?php 
			echo $this->Html->image('icons/saveSmall.png',array('title'=>'Save','alt'=>'Save','class'=>'saveRoomService','id'=>'addRoomService'),array('escape' => false));
			echo $this->Html->image('icons/cross.png',array('title'=>'Cancel','alt'=>'Cancel','class'=>'cancelAddRoomService','id'=>'cancelAddRoomService'),array('escape' => false));
		?></td>
	</tr>
</table>
</div>

<div>&nbsp;</div>
<?php if(strtolower($this->Session->read('role'))=='admin' || strtolower($this->Session->read('website.instance'))=='hope'){?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id=" ">
		<tr>
			<th>Ward</th>
			<?php if($website=='vadodara'){?>
			<th>Room</th>
			<?php }?>
			<th>Date</th>
			<th>Amount</th>
			<th>Action</th>
		</tr>
	<?php foreach($allRoomService as $allRoomService){ ?>
		<tr class="row" id=row_<?php echo $allRoomService['WardPatientService']['id']; ?>>
			<td><?php echo $allWardList[$allRoomService['WardPatientService']['ward_id']];?></td>
			<?php if($website=='vadodara'){?>
			<td><?php echo $allRoomList[$allRoomService['WardPatientService']['room_id']];?></td>
			<?php }?>
			<td><?php $todayRoomDate=$this->DateFormat->formatDate2Local($allRoomService['WardPatientService']['date'],Configure::read('date_format'),false);
				echo $todayRoomDate;?></td>
			<!-- <td><?php //echo $allRoomService['WardPatientService']['unit'];?></td> -->
			<td align="right"><?php echo $allRoomService['WardPatientService']['amount'];?></td>
			<td><?php 
			/* echo $this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit','class'=>'editRoomService',
				'id'=>'editRoomService_'.$allRoomService['WardPatientService']['id']),array('escape' => false)); */
			
			echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit','class'=>'editRoomService',
				'id'=>'editRoomService_'.$allRoomService['WardPatientService']['id'],'room_id'=>$allRoomService['WardPatientService']['room_id']),
				array('escape' => false)),array('controller'=>'billings','action'=>'updateService'),array('escape' => false,'class'=>'billingServicesAction'));

			/* echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteRoomService',
				'id'=>'deleteRoomService_'.$allRoomService['WardPatientService']['id']),array('escape' => false)) ; */

			if(!$allRoomService['WardPatientService']['paid_amount']){
				echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteRoomService','id'=>'deleteRoomService_'.$allRoomService['WardPatientService']['id']),
					array('escape' => false)),array('controller'=>'billings','action'=>'deleteRoomService'),array('escape' => false,'class'=>'billingServicesAction'));
			}
		?></td>
		</tr>
		
		<tr class="duplicateRow" style="display:none" id=duplicateRow_<?php echo $allRoomService['WardPatientService']['id']; ?>>
		    
			<td>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>$allWardList,'id'=>'ward_'.$allRoomService['WardPatientService']['id'],
					'label'=>false,'div'=>false,'error'=>false,'class'=>'wardListOther wardList textBoxExpnd','name'=>"WardPatientService[ward_id][]",'value'=>$allRoomService['WardPatientService']['ward_id']))?></td>
			<?php if($website=='vadodara'){?>
			<td>
			<?php echo $this->Form->input('',array('type'=>'select','empty'=>'Please Select','id'=>'room_'.$allRoomService['WardPatientService']['id'],'label'=>false,'div'=>false,'error'=>false,
					'class'=>'roomList validate[required,custom[mandatory-select]] textBoxExpnd ','value'=>$allRoomService['WardPatientService']['room_id'],'name'=>"WardPatientService[room_id][]"));?>
			</td>
			<?php }?>
			<td ><?php $todayRoomDate=$this->DateFormat->formatDate2Local($allRoomService['WardPatientService']['date'],Configure::read('date_format'),false);
				echo $todayRoomDate; ?></td>
			
			<td><?php 
                            echo "Half" . $this->Form->input('', array('type' => 'checkbox','class'=>'halfRate', 'id' => 'halfRate_'.$allRoomService['WardPatientService']['id'], 'name' => '', 'label' => false, 'div' => false, 'error' => false, 'hiddenFields' => false)); 
                            echo $this->Form->input('', array('name'=>'WardPatientService[amount][]','type'=>'text','label'=>false,'id' => 'roomAomunt_'.$allRoomService['WardPatientService']['id'],
					'class'=> 'textBoxExpnd roomAomunt','div'=>false,'style'=>'text-align:right;float:none !important;width:80%!important','value'=>$allRoomService['WardPatientService']['amount'],'readonly'=>'readonly'));?></td>
			
			<td><?php 
			echo $this->Html->image('icons/saveSmall.png',array('title'=>'Save','alt'=>'Save','class'=>'saveRoomService','id'=>'saveRoomService_'.$allRoomService['WardPatientService']['id']),
					array('escape' => false));
			echo $this->Html->image('icons/cross.png',array('title'=>'Cancel','alt'=>'Cancel','class'=>'cancelRoomService','id'=>'cancelRoomService_'.$allRoomService['WardPatientService']['id']),
					array('escape' => false));?></td>
		</tr>
	<?php }?>
</table>
<?php }?>
<div>&nbsp;</div>
<?php echo $this->Form->end();?>
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
		 	<th width="10%">Deposit Amount</th>
            <th >Date/Time</th>
            <th width="10%">Mode of Payment</th>
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
			/* if(strtolower($this->Session->read('role'))=='admin'){
				echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteRoomRec',
					'id'=>'deleteRoomRec_'.$dailyCharge['Billing']['id']),array('escape' => false));
			} */
			
			if(strtolower($this->Session->read('website.instance'))=='kanpur'){
				if(strtolower($patient['Patient']['admission_type'])!='opd'){
					echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
						array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
						$dailyCharge['Billing']['id']))."', '_blank',
				 		'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

					echo $this->Html->link($this->Html->image('icons/printer_mono.png',array('title'=>'Print Receipt without Header')),'#',
		               array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				       $dailyCharge['Billing']['id'],'?'=>'flag=without_header'))."', '_blank',
						 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

				}
			}else{
				echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
					array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
					$dailyCharge['Billing']['id']))."', '_blank',
				 	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

				/* echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt without Header')),'#',
		            array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				   $dailyCharge['Billing']['id'],'?'=>'flag=without_header'))."', '_blank',
						 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
 				*/
			} 
			?></td>
		</tr>
		<?php }?> 
		</table>
  	</td>
  	</tr>
  	<tr><td >&nbsp;</td></tr>
  	 
</table>
<?php }?>

<?php //}?>
<script>
$("#paymentDetailDiv", parent.document ).hide();//hide payment detail coz payment will done from final only  --yashwant

//$( '#totalamount', parent.document ).val('<?php //echo $rCost;?>');

$( '#paymentDetail', parent.document ).trigger('reset');
$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
$( '#totaladvancepaid', parent.document ).val('<?php echo $dailyPaid=$dailyPaid/*+$totalpaidDiscount*/;?>');
$( '#totalamountpending', parent.document ).val('<?php echo $totalAmount+$paidtopatient-$dailyPaid-$totalpaidDiscount;?>');
$( '#maintainDiscount', parent.document ).val('<?php echo $totalpaidDiscount;?>');
$( '#amount', parent.document ).attr('readonly',false);//to allow partial payment

$( '#prevDiscount', parent.document ).html('<?php echo ($totalpaidDiscount)?$totalpaidDiscount:0;?>');//for showing previous discount
$( '#prevRefund', parent.document ).html('<?php echo ($paidtopatient)?$paidtopatient:0;?>');//for showing previous refund

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


/***for editing service****/
$(".editRoomService, .cancelRoomService").click(function(){
	var currentRecId=$(this).attr('id'); 
	splitedVar=currentRecId.split('_');
	type=splitedVar[0];
	recId=splitedVar[1];
	if(type=='editRoomService'){
		$(".duplicateRow").hide();
		$(".row").show();
		$("#row_"+recId).hide();
		$("#duplicateRow_"+recId).show();
	}else if(type=='cancelRoomService'){
		$("#duplicateRow_"+recId).hide();
		$("#row_"+recId).show();
	}else if(currentRecId=='addWardPatientService'){
		$(".duplicateRow").hide();
		$(".row").show();
	} 
});


/**
 * for delete room service  --yashwant 
 */
 $(".deleteRoomService").click(function(){
		currentID=$(this).attr('id');
		splitedVar=currentID.split('_');
		recId=splitedVar[1];
		patient_id='<?php echo $patientID;?>';
		tariffStandardId= '<?php echo $tariffStandardId;?>';
		 
		if(confirm("Do you really want to delete this record?")){
			$.ajax({
				  type : "POST",
				  //data: formData,
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteRoomService", "admin" => false)); ?>"+"/"+recId+"/"+patient_id,
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


 /*
  * datepicker for room service
  */
 $(".roomDate, .addRoomDate").datepicker(
 	{
 		showOn: "both",
 		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
 		buttonImageOnly: true,
 		changeMonth: true,
 		changeYear: true,
 		changeTime:true,
 		showTime: true,  		
 		yearRange: '1950',			 
 		dateFormat:'dd/mm/yy',
		minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
 		maxDate:new Date(),
 		//onSelect:function(){$(this).focus();}
 	});
  

/*
 * edit individual room service record
 */
$(".editRoomService, .cancelRoomService").click(function(){
	var currentRecId=$(this).attr('id');
	splitedVar=currentRecId.split('_');
	type=splitedVar[0];
	recId=splitedVar[1];
	if(type=='editRoomService'){
		$(".duplicateRow").hide();
		$(".row").show();
		$("#row_"+recId).hide();
		$("#duplicateRow_"+recId).show();
	}else if(type=='cancelRoomService'){
		$("#duplicateRow_"+recId).hide();
		$("#row_"+recId).show();
	}
});

/**
 * for updating ward_patient_service
 */
$(".saveRoomService").click(function(){
	 var validatePerson = jQuery("#addWardFrm").validationEngine('validate'); 
 	 if(!validatePerson){
	 	return false;
	 }
	 patient_id='<?php echo $patientID;?>';
	 tariffStandardId= '<?php echo $tariffStandardId;?>';
	 groupID='<?php echo $groupId;?>';
	 var currentRecId=$(this).attr('id');
	 splitedVar=currentRecId.split('_');
	 recId=splitedVar[1];
	 var flag='wardPatientService';
	 
	 if(currentRecId=='addRoomService'){
		recId='';
 		ward_id = $('#addWard').val();
 		room_id = $('#addRoom').val();
		date = $('#addRoomDate').val();
		unit = $('#addUnit').val();
		amount = $('#addRoomAomunt').val();
	 }else{
 		ward_id = $('#ward_'+recId).val();
 		room_id = $('#room_'+recId).val();
		date = '';
		unit = '';
		amount = $('#roomAomunt_'+recId).val();
	 }
		$.ajax({
			  type : "POST",
			  data: "ward_id="+ward_id+"&amount="+amount+"&date="+date+"&unit="+unit+"&room_id="+room_id+"&groupID="+groupID,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "updateService", "admin" => false)); ?>"+'/'+patient_id+'/'+recId+'?flag='+flag,
			  context: document.body,
			  success: function(data){ 
				  parent.getDailyRoomData(patient_id,tariffStandardId,groupID);
				  parent.getbillreceipt(patient_id);	
				  $("#busy-indicator").hide();
			  },
			  beforeSend:function(){$("#busy-indicator").show();},		  
		}); 
	 
}); 

/**
 * hide and show add blick of ward service
 */
$('#addWardPatientService').click(function(){
	$('#addWardPatientServiceArea').show();
});
 
$('#cancelAddRoomService, .editRoomService').click(function(){
	$('#addWardPatientServiceArea').hide();
	clearFields();
});
//EOF hide/show

/**
 * for getting ward charges  --yashwant
 */
	$('.roomList').change(function(){
 		var roomId=$(this).val();
		var patient_id='<?php echo $patientID;?>';
 	 	var currentID=$(this).attr('id');
		
		$.ajax({
		  type : "POST",
		  //data: formData,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "getWardCharges", "admin" => false)); ?>"+"/"+roomId+'/'+patient_id,
		  context: document.body,
		  success: function(data){ 
				  if(currentID=='addRoom'){ 
						$('#addRoomAomunt').val($.trim(data));	
				  }else{ 
					splitedVar=currentID.split('_');
					editRecId=splitedVar[1];
					$('#roomAomunt_'+editRecId).val($.trim(data));	
				  }
			  $("#busy-indicator").hide();			  
		  },
		  beforeSend:function(){$("#busy-indicator").show();},		  
		});
 });

  //for room maped with ward
  $('.wardList').change(function(){
	  var website='<?php echo $website;?>';
	  if(website=='vadodara'){
 		var wardId=$(this).val();
 		var currentID=$(this).attr('id');
		$.ajax({
		  type : "POST",
		  //data: formData,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "getRoomMapedWithWard", "admin" => false)); ?>"+"/"+wardId,
		  context: document.body,
		  success: function(data){  
				  if(currentID=='addWard'){
					$('#addRoom').empty();
				  	roomData= $.parseJSON(data);
				  	$('#addRoom').append( "<option value=''>Please Select</option>" );
				  	$.each(roomData, function(val, text) {
					    $('#addRoom').append(new Option( text , val) );
					})
				  }else{
					splitedVar=currentID.split('_');
					editRecId=splitedVar[1];
					$('#room_'+editRecId).empty();
				  	roomData= $.parseJSON(data);
				  	$('#room_'+editRecId).append( "<option value=''>Please Select</option>" );
				  	$.each(roomData, function(val, text) {
				  		$('#room_'+editRecId).append(new Option( text , val) );
					})	
				  } 
			  $("#busy-indicator").hide();			  
		  },
		  beforeSend:function(){$("#busy-indicator").show();},		  
		});

	  }
 });


  $('.editRoomService').click(function(){
		
		var currentID=$(this).attr('id');
		var splitedVar=currentID.split('_');
		ID=splitedVar['1'];
		var wardId=$("#ward_"+ID).val();
		var currentRoomId=$(this).attr('room_id');
		$.ajax({
		  type : "POST",
		  //data: formData,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "getRoomMapedWithWard", "admin" => false)); ?>"+"/"+wardId,
		  context: document.body,
		  success: function(data){  
			$('#room_'+ID).empty();
		  	roomData= $.parseJSON(data);
		  	$('#room_'+ID).append( "<option value=''>Please Select</option>" );
		  	$.each(roomData, function(val, text) {
		  		$('#room_'+ID).append(new Option( text , val) );
			})	
		    $('#room_'+ID).val(currentRoomId);
			$("#busy-indicator").hide();			  
		  },
		  beforeSend:function(){$("#busy-indicator").show();},		  
		});
  });
  
  //for clearing fields
  function clearFields(){
	$("#addWard").val('');
	$("#addRoom").val('');
	$("#addRoomDate").val('');
	$("#addRoomAomunt").val('');
  }
  
  /**
   * for getting ward charges for other than vadodara  --yashwant
   */
   $('.wardListOther').change(function(){
	   var website='<?php echo $website;?>';
	   if(website!='vadodara'){
		    var wardId=$(this).val();
			var patient_id='<?php echo $patientID;?>';
			var currentID=$(this).attr('id');
			
			$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "getWardChargesExceptRoom", "admin" => false)); ?>"+"/"+wardId+'/'+patient_id,
			  context: document.body,
			  success: function(data){  
					  if(currentID=='addWard'){
							$('#addRoomAomunt').val($.trim(data));	
					  }else{
						splitedVar=currentID.split('_');
						editRecId=splitedVar[1];
						$('#roomAomunt_'+editRecId).val($.trim(data));	
					  }
					  //parent.getDailyRoomData(patient_id,tariffStandardId);
					  //parent.getbillreceipt(patient_id);		
				  $("#busy-indicator").hide();			  
			  },
			  beforeSend:function(){$("#busy-indicator").show();},		  
			});
	   }
   });
   
   // if checkbox checked open add combo textarea
    $('.halfRate').click(function(){	
        var id = $(this).attr('id').split('_')[1];
        roomAmount = $("#roomAomunt_"+id).val();
        if($("#halfRate_"+id).is(':checked')){	
            halfRate =  roomAmount/2;
            roundedAmt =  Math.round(halfRate);
            $("#roomAomunt_"+id).val(roundedAmt);
        }else{
            fullRate =  roomAmount*2;
            roundedAmt =  Math.round(fullRate);
            $("#roomAomunt_"+id).val(roundedAmt);
        }
    });

</script>