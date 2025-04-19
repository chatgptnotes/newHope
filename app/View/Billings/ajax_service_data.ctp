<?php $website  = $this->Session->read('website.instance');?>
<?php //debug($tariffStanderdName);
if($servicesData[0]['Patient']['is_discharge']==1){
	$discharge='yes';
}else{
	$discharge='no';
}
 
$serviceTotal=0;
$servicePaid=0;
foreach($serviceCharge as $service_charge){
	if($service_charge['Billing']['total_amount']>$serviceTotal)$serviceTotal=$service_charge['Billing']['total_amount'];
	$servicePaid=$servicePaid+$service_charge['Billing']['amount'];
	//$servicePaid=$servicePaid+$service_charge['Billing']['discount'];
}

$hospitalType = $this->Session->read('hospitaltype');
if($hospitalType == 'NABH'){$nursingServiceCostType = 'nabh_charges';}else{$nursingServiceCostType = 'non_nabh_charges';}
 
if(!empty($servicesData) || ($addmissionType['Patient']['admission_type']=='IPD' && strtolower($isMandatory)==Configure::read('mandatoryservices'))){?>
<table width="100%">
	<tr>
	<?php //if($discharge=='no'){?>
		<td style="padding-bottom: 10px;padding-top: 4px" align="right"><?php 
		/*if(strtolower($isMandatory)==Configure::read('mandatoryservices')){
			echo $this->Html->link('Report','javascript:void(0)',
				array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
				$patientID,'?'=>array('flag'=>'Services','groupID'=>$groupID)))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
		}else*/if($isNursing!='yes' && strtolower($isMandatory)!=Configure::read('mandatoryservices')){
			echo $this->Html->link('Print Report','javascript:void(0)',array('id'=>'serviceReport','class'=>'blueBtn','escape' => false));
		}
		//echo $this->Html->link(__('Report'),array('action' => 'patientSearch'), array('escape' => false,'class'=>'blueBtn'))."&nbsp;";
		//echo $this->Html->link('Save', array('div'=>false,'label'=>false,'error'=>false),array('class'=>'blueBtn', 'id' => 'saveServiceBillsData'));?>
		</td>
		<?php //}?>
	</tr>
 </table> 
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id="">
		<tr>
		<?php if(strtolower($isMandatory)!=Configure::read('mandatoryservices') && $isNursing!='yes'){?>
			 
			<th class="table_cell select" style="<?php echo $display;?>"><input type="checkbox" id="selectall"  <?php echo $disabled;?>/></th>
			<?php }?>
			<th class="table_cell"><?php echo __('Date');?></th>
			<th class="table_cell"><?php echo __('Service');?></th>
			<th class="table_cell"><?php echo __('Unit Price');?></th>
			<th class="table_cell"><?php echo __('Units');?></th>
			<th class="table_cell"><?php echo __('Amount');?></th>
			<th class="table_cell"><?php echo __('Action');?></th>
			<?php if(strtolower($isMandatory)!=Configure::read('mandatoryservices')){?>
			<?php if($isNursing!='yes'){?>
				<th class="table_cell"><?php echo __('Print'); ?></th>
			<?php }}else{?>
				<th class="table_cell" colspan="3">&nbsp;</th>
			<?php }?>
		</tr>
	<?php $totalAmount = $nonBillable = $paid_amount =$allDiscount= 0;
	 $i=0;
	foreach($servicesData as $services){ 
		if($billedServiceId){//for service wise refund  --yashwant
			$billingId=$billedServiceId[$services['ServiceBill']['id']];
		}
		if($services['ServiceBill']['paid_amount']){
			$paid_amount=$paid_amount+$services['ServiceBill']['paid_amount'];
		}
		if($services['ServiceBill']['discount']){
			$allDiscount=$allDiscount+$services['ServiceBill']['discount'];
		}
		json_encode($serviceBillIdArray[]=$services['ServiceBill']['id']); 
		json_encode($serviceNameArray[]=$services['TariffList']['name']);
		$serviceGroup=($services['ServiceCategory']['alias'])?$services['ServiceCategory']['alias']:$services['ServiceCategory']['name'];
		$no_of_time = $services['ServiceBill']['no_of_times']?$services['ServiceBill']['no_of_times']:1; ?>
		<tr class="row" id=row_<?php echo $services['ServiceBill']['id']; ?>>			
			<?php if($servicesData[0]['ServiceCategory']['name']!=Configure::read('mandatoryservices') && $isNursing!='yes'){?>
			<?php 
			// Comparing for already paid services and disabling the chkboxes-- Pooja
			 
			$servicepaidAmt=($services['ServiceBill']['amount']*$no_of_time)-$services['ServiceBill']['paid_amount'];
			$disabled='';
			if($services['ServiceBill']['paid_amount'] > 0  ){
				$disabled="disabled='disabled'";
				$customDiasbled='';
				$displayStatus='none';
				$background='paid_payment';
			}else{ 
				$disabled='';
				$customDiasbled='';
				$displayStatus='';
				$background='pending_payment';
			}?>
			<?php /** for private packaged Patient  -- gaurav */
			$billable = '';
			if($addmissionType['Patient']['is_packaged'] && !$services['ServiceBill']['is_billable']){
				$disabled="disabled='disabled'";
				$customDiasbled="disabled='disabled'";
				$displayStatus='';
				$billable = 'nonBillable';
			}  
			?>
			<td class="select <?php echo $background;?>"  style="<?php echo $display;?>">
			<input class="checkbox1 <?php echo $billable;?>" type="checkbox" id="<?php echo "optCheck_".$i; ?>" name="check[]" value="<?php echo $services['ServiceBill']['id'];?>" 
				amount="<?php echo ($services['ServiceBill']['amount']*$no_of_time);?>" <?php echo $disabled;?> discount="<?php echo round($services['ServiceBill']['discount']);?>"
				paid_amount="<?php echo round($services['ServiceBill']['paid_amount']);?>"
				service_name="<?php echo $services['TariffList']['name'];?>"
				tariffId="<?php echo $services['TariffList']['id'];?>">
			<?php }else{  
				$noOfTime = $services['ServiceBill']['no_of_times']?$services['ServiceBill']['no_of_times']:1;
				$mandpaidAmt=($services['ServiceBill']['amount']*$noOfTime)-$services['ServiceBill']['paid_amount']-$services['ServiceBill']['discount'];
//				if($mandpaidAmt<=0){ 
				if($services['ServiceBill']['paid_amount']>0){
					$background='paid_payment';
				}else{ 
					$background='pending_payment';
				}
			}?>
			<td align="" class="<?php echo $background;?>">
				<?php //echo $services['ServiceBill']['date'];
				if($servicesData[0]['ServiceCategory']['name']==Configure::read('mandatoryservices')){
					if(!empty($services['Patient']['form_received_on']))
						echo $this->DateFormat->formatDate2Local($services['ServiceBill']['date'],Configure::read('date_format'),true);
				}else{
					if(!empty($services['ServiceBill']['date']))
						echo $this->DateFormat->formatDate2Local($services['ServiceBill']['date'],Configure::read('date_format'),true);
				}?>
			</td>
			<!-- <td><?php //echo $services['ServiceCategory']['name'];?></td>
			<?php //if($servicesData[0]['ServiceCategory']['name']!=Configure::read('mandatoryservices')){?>
			<td><?php //echo $services['ServiceSubCategory']['name'];?></td>
			<?php //}?> -->
			<td class="<?php echo $background;?>"><?php echo $services['TariffList']['name'];?></td>
			<td class="<?php echo $background;?>" align="right"><?php echo $services['ServiceBill']['amount'];?></td>
			<td class="<?php echo $background;?>" align=""><?php echo $no_of_time = $services['ServiceBill']['no_of_times']?$services['ServiceBill']['no_of_times']:1;?></td>
			<td class="<?php echo $background;?>" align="right" class="amountBill" id="<?php echo 'amountBill_'.$i ?>"><?php echo ($totalAmount1=$services['ServiceBill']['amount']*$no_of_time);
			//$totalAmount=$totalAmount+$totalAmount1;
			
			if($addmissionType['Patient']['is_packaged'] && $services['ServiceBill']['is_billable']){
				$totalAmount = $totalAmount+$totalAmount1;
			}elseif( $addmissionType['Patient']['is_packaged'] && !$services['ServiceBill']['is_billable'] ){
				$nonBillable = $nonBillable+$totalAmount1;
			}else if(!$addmissionType['Patient']['is_packaged']){
				$totalAmount = $totalAmount+$totalAmount1;
			}
			
			?></td>
			<?php //hidden field to save partially paid amount 
			if($services['ServiceBill']['paid_amount']/*$services['ServiceBill']['id']== $paidService[$services['ServiceBill']['id']]*/ ){
				//$paidAmt=$totalAmount1;
				$paidAmt=$services['ServiceBill']['paid_amount'];
			}else{
				$paidAmt='0.00';
			}
			
			 echo $this->Form->input('partial_paid_amt',array('type'=>'hidden','id'=>'partial_amt_'.$i,'value'=>$paidAmt));?>
			
			<?php if($servicesData[0]['ServiceCategory']['name']!=Configure::read('mandatoryservices')){?>
			<!-- <td  ><?php //echo $services['ServiceBill']['description'];?></td> -->
			<?php //if($discharge=='no'){ ?>
			<td class="<?php echo $background;?>" align="center">
			<?php  
			if($services['ServiceBill']['paid_amount'] <= 0  /*&& $discharge=='no' && strtolower($this->Session->read('role'))=='admin'*/){
				/* echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteService','id'=>'deleteService_'.$services['ServiceBill']['id']),
						array('escape' => false)) ; */
				echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteService','id'=>'deleteService_'.$services['ServiceBill']['id']),
					array('escape' => false)),array('controller'=>'billings','action'=>'deleteServicesCharges'),array('escape' => false,'class'=>'billingServicesAction'));
			}
			
			if($isNursing!='yes' && $services['ServiceBill']['paid_amount'] <= 0 && $discharge=='no'){
				/* echo $this->Html->image('icons/edit-icon.png',array('style'=>'display:'.$displayStatus,'title'=>'Edit','alt'=>'Edit','class'=>'editService','id'=>'editService_'.$services['ServiceBill']['id']),
					array('escape' => false)); */
				echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('style'=>'display:'.$displayStatus,'title'=>'Edit','alt'=>'Edit','class'=>'editService','id'=>'editService_'.$services['ServiceBill']['id']),
					array('escape' => false)),array('controller'=>'billings','action'=>'updateService'),array('escape' => false,'class'=>'billingServicesAction'));
			}else if(strtolower($tariffStanderdName)!='private' && $isNursing!='yes' && $services['ServiceBill']['paid_amount'] <= 0){//for discharge corporate patient
				echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('style'=>'display:'.$displayStatus,'title'=>'Edit','alt'=>'Edit','class'=>'editService','id'=>'editService_'.$services['ServiceBill']['id']),
					array('escape' => false)),array('controller'=>'billings','action'=>'updateService'),array('escape' => false,'class'=>'billingServicesAction'));
			} 
			
			if($website != 'vadodara'){
			if($services['ServiceBill']['paid_amount'] > 0 && $discharge=='no' && $isNursing!='yes'){
			$totalRefundAmount=$services['ServiceBill']['amount']*$no_of_time;?>
			<input class="refundCheck" type="checkbox" title="Refund" id="<?php echo "refundCheck_".$totalRefundAmount."_".$services['ServiceBill']['id']."_".$billingId."_".$services['ServiceBill']['discount'];?>" name="refundCheckbox[]" <?php echo $customDiasbled;?>  value=" ">
			<?php } }?>
			</td>
			<?php if($isNursing!='yes'){?>
			<td class="<?php echo $background;?>" ><input class="customCheckbox" type="checkbox" id="<?php echo "customCheckbox_".$i;?>" 
						name="customCheckbox[]" <?php echo $customDiasbled;?> value="<?php echo $services['ServiceBill']['id'];?>">	</td>
			<?php }}else{?>
			<td colspan="3" class="<?php echo $background;?>">
			<?php if($services['ServiceBill']['paid_amount'] <= 0)echo $this->Form->input('mandatory_field_id',array('type'=>'hidden','id'=>'mandatory_field_id'.$i,'value'=>$services['ServiceBill']['id'],'class'=>'mandatoryFieldIds'));
			if($services['ServiceBill']['paid_amount'] <= 0 /*&& $discharge=='no' /* && strtolower($this->Session->read('role'))=='admin' */){
				/* echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteService','id'=>'deleteService_'.$services['ServiceBill']['id']),
					array('escape' => false)) ; */
				echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteService','id'=>'deleteService_'.$services['ServiceBill']['id']),
					array('escape' => false)),array('controller'=>'billings','action'=>'deleteServicesCharges'),array('escape' => false,'class'=>'billingServicesAction'));

			}?></td>
			<?php }?> 
		</tr>
		
		<tr class="duplicateRow" style="display:none" id=duplicateRow_<?php echo $services['ServiceBill']['id']; ?>>
			<?php if($addmissionType['Patient']['is_packaged']){?>
			<td><?php echo $this->Form->input('',array('name'=>'data[ServiceBill][is_billable]','class'=>'textBoxExpnd','checked'=>$services['ServiceBill']['is_billable'],
				'escape'=>false,'hiddenField'=>false,'multiple'=>false,'type'=>'checkbox','label'=>false,'div'=>false,'id'=>'isBillableSer_'.$services['ServiceBill']['id'],'autocomplete'=>false));?></td>
			<?php }else{?>
			<td>&nbsp;</td>
			<?php }?>
			<td align="center" >
				<input type="hidden" value="1" id="no_of_fields">	
				<?php $todayServiceDate=$this->DateFormat->formatDate2Local($services['ServiceBill']['date'],Configure::read('date_format'),true);
					echo $this->Form->input('', array('type'=>'text','id' => 'ServiceDate_'.$services['ServiceBill']['id'],'label'=>false,'div'=>false,
						'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  editServiceDate','style'=>'width:120px;',
						'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ServiceBill][date]','value'=>$todayServiceDate)); ?>
			</td>
			 
			<td align="center">
				<?php  
				echo $this->Form->input('', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd getServiceID',
				 	 'div' => false,'label' => false  ,'id' => 'service_id_'.$services['ServiceBill']['id'],'style'=>'width:110px;','fieldNo'=>1,
					 'value'=>$services['TariffList']['name']));
				echo $this->Form->hidden('', array('class' => 'onlyServiceId','id' => 'onlyServiceId_'.$services['ServiceBill']['id'],
					 'name'=>'data[ServiceBill][tariff_list_id]','value'=>$services['ServiceBill']['tariff_list_id']));
				?> </td>
			
			<td align="center">
			<?php echo $this->Form->input('amount',array('class' => 'validate[required,custom[onlyNumber]] textBoxExpnd service_amount',
					'legend'=>false,'label'=>false,'id' => 'service_amount_'.$services['ServiceBill']['id'],'style'=>'width:50px;','fieldNo'=>1,
					'name'=>'data[ServiceBill][amount]','autocomplete'=>'off','value'=>$services['ServiceBill']['amount']/*,'readonly'=>'readonly'*/)); ?></td>
			
			<td align="center"><?php echo $this->Form->input('no_of_times',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd no_of_times nofTime',
					'id'=>'no_of_times_'.$services['ServiceBill']['id'],'type'=>'text','style'=>'width:30px;','name'=>'data[ServiceBill][no_of_times]','label'=>false,
					'div'=>false,'value'=>$services['ServiceBill']['no_of_times']));
			echo $this->Form->hidden('discount',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd fix_discount',
					'id'=>'fix_discount_'.$services['ServiceBill']['id'],'type'=>'text','style'=>'width:30px;','name'=>'data[ServiceBill][discount]','label'=>false,
					'div'=>false,'value'=>$services['ServiceBill']['discount']));?></td>
			
			<td id="amount_<?php echo $services['ServiceBill']['id'];?>" class="amount" valign="middle" style="text-align:center;">
			<?php $no_of_time = $services['ServiceBill']['no_of_times']?$services['ServiceBill']['no_of_times']:1;
				echo $services['ServiceBill']['amount']*$no_of_time;?></td>
			
			<td valign="middle" style="text-align:center;">
			<?php 
				echo $this->Html->image('icons/saveSmall.png',array('title'=>'Save','alt'=>'Save','class'=>'saveService','id'=>'saveService_'.$services['ServiceBill']['id']),
					array('escape' => false));
				echo $this->Html->image('icons/cross.png',array('title'=>'Cancel','alt'=>'Cancel','class'=>'cancelService','id'=>'cancelService_'.$services['ServiceBill']['id']),
					array('escape' => false));?>
			</td>
			<td></td>  
		</tr>
	<?php $i++; }?>
	
	<?php  
		if($addmissionType['Patient']['admission_type']=='IPD'  && strtolower($isMandatory)==Configure::read('mandatoryservices') ){
			if($doctorCharges){?>
			<tr class="row">
				<td align="">
				<?php if(!empty($addmissionType['Patient']['form_received_on']))
						echo $this->DateFormat->formatDate2Local($addmissionType['Patient']['form_received_on'],Configure::read('date_format'),true);?></td>
				<td><?php echo ('Doctors Charges');?></td>
				<td align="right"><?php echo $doctorCharges/$totalWardDays;?></td>
				<td align=""><?php echo $totalWardDays;?></td>
				<td align="right" class="amountBill" ><?php echo ($totalAmount1=$doctorCharges);
					if($addmissionType['Patient']['is_packaged']) // for packaged patient mandatory services are always non billable
						$nonBillable = $nonBillable+$totalAmount1;
					else 
						$totalAmount=$totalAmount+$totalAmount1;?></td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<?php }?>
			<?php if($nursingCharges){?>
			<tr class="row">
				<td align="">
				<?php if(!empty($addmissionType['Patient']['form_received_on']))
						echo $this->DateFormat->formatDate2Local($addmissionType['Patient']['form_received_on'],Configure::read('date_format'),true);?></td>
				<td><?php echo ('Nursing Charges');?></td>
				<td align="right"><?php echo $nursingCharges/$totalWardDays;?></td>
				<td align=""><?php echo $totalWardDays;?></td>
				<td align="right" class="amountBill" ><?php echo ($totalAmount1=$nursingCharges);
					if($addmissionType['Patient']['is_packaged']) // for packaged patient mandatory services are always non billable
						$nonBillable = $nonBillable+$totalAmount1;
					else
						$totalAmount=$totalAmount+$totalAmount1;?></td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<?php }?>
		<?php }?>
	 
		<tr>
			<?php if(strtolower($isMandatory)!=Configure::read('mandatoryservices') && $isNursing!='yes'){?>
			<td colspan="5" valign="middle" align="right"><?php echo __('Total Amount');?></td>
			<?php }else{?>
			<td colspan="4" valign="middle" align="right"><?php echo __('Total Amount');?></td>
			<?php }?>
			<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmount + $nonBillable);?></td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<?php if($addmissionType['Patient']['is_packaged']){?>
		<tr>
			<?php if(strtolower($isMandatory)!=Configure::read('mandatoryservices')){?>
			<td colspan="5" valign="middle" align="right"><?php echo __('Non Billable');?></td>
			<?php }else{?>
			<td colspan="4" valign="middle" align="right"><?php echo __('Non Billable');?></td>
			<?php }?>
			<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($nonBillable);?></td>
			<td  valign="middle" align="right"><?php echo __('Billable');?></td>
			<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmount);?></td>
		</tr>
		<?php }?>
	</tr>
</table>
<?php } ?>

<?php if(!empty($serviceCharge) && $isNursing!='yes'){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both">
	<tr><td >&nbsp;</td></tr>
	<tr>
  		<td style="text-align:center" colspan="5"><strong>Payment Received For <?php echo $serviceGroup;?></strong></td>
  	</tr>
  	<tr>
  	<td>
  		<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm">
		<tr >
		 	<th width="10%">Deposit</th>
            <th >Date/Time</th>
            <th width="10%">Mode of Payment</th>
			<?php 
			if($addmissionType['Patient']['tariff_standard_id']==$getTariffRgjayId && $addmissionType['Patient']['admission_type']=='IPD'){
			}else{?>
            <th >Action</th>
			<?php }?>
            <th >Print Receipt</th>
            <?php if($website == 'kanpur')
            {?>
            	<th>Print without header</th>
            <?php }?>
		</tr>
		<?php  $totalpaid=0;
			   $paidtopatient=0;
			   $totalpaidDiscount=0;
		foreach($serviceCharge as $serviceCharge){
			if($serviceCharge['Billing']['refund']=='1'){
				//echo $paidtopatient1=$serviceCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$serviceCharge['Billing']['paid_to_patient'];
				$totalpaidDiscount=$totalpaidDiscount+$serviceCharge['Billing']['discount'];// to maintain discount in payment detail block  --yashwant
				continue;
			}else{
				if(!empty($serviceCharge['Billing']['discount'])){
					//echo $totalpaid1=$serviceCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$serviceCharge['Billing']['discount'];
					$totalpaidDiscount=$totalpaidDiscount+$serviceCharge['Billing']['discount'];
					if(empty($serviceCharge['Billing']['amount']))
						continue;
				}
			} ?>
		<tr>
			<td align="right"><?php 
			/*if($serviceCharge['Billing']['refund']=='1'){
				//echo $paidtopatient1=$serviceCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$serviceCharge['Billing']['paid_to_patient'];
				continue;
			}else{*/
				/*if(empty($serviceCharge['Billing']['amount']) && !empty($serviceCharge['Billing']['discount'])){
					echo $totalpaid1=$serviceCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$totalpaid1;
					$totalpaidDiscount=$totalpaidDiscount+$totalpaid1;
				}else*/if(!empty($serviceCharge['Billing']['amount'])){
					echo $totalpaid1=$serviceCharge['Billing']['amount']/*+$serviceCharge['Billing']['discount']*/;
					$totalpaid=$totalpaid+$totalpaid1;
				}
			//}?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($serviceCharge['Billing']['date'],Configure::read('date_format'),true);?></td>
			<!-- <td><?php echo $serviceCharge['Billing']['reason_of_payment'];?></td> -->
			<td><?php echo $serviceCharge['Billing']['mode_of_payment'];?></td>
			<?php 
			if($addmissionType['Patient']['tariff_standard_id']==$getTariffRgjayId && $addmissionType['Patient']['admission_type']=='IPD'){
			}else{?>
			<td><?php 
			/* comented becoz if payment deleted then calculation got mis match -*DO NOT REMOVE*- --yashwant
			 * if(strtolower($this->Session->read('role'))=='admin'){
				echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteServiceRec',
					'id'=>'deleteServiceRec_'.$serviceCharge['Billing']['id']),array('escape' => false));
			}*/
			 
			if(strtolower($this->Session->read('website.instance'))=='kanpur'){
				if(strtolower($addmissionType['Patient']['admission_type'])!='opd'){
					echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
						 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
						 $serviceCharge['Billing']['id']))."', '_blank',
						 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
					
					echo $this->Html->link($this->Html->image('icons/printer_mono.png',array('title'=>'Print Receipt without Header')),'#',
		                 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				         $serviceCharge['Billing']['id'],'?'=>'flag=without_header'))."', '_blank',
						 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

				}
			}else{
				echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
					array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
						$serviceCharge['Billing']['id']))."', '_blank',
						'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			/* 
				echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt without Header')),'#',
		            array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				        $serviceCharge['Billing']['id'],'?'=>'flag=without_header'))."', '_blank',
						 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
 */
			}
			?></td>
			<?php }?>
			<td height="30px"><?php  
			if($website == 'vadodara'){
				echo $this->Html->link('Print Receipt','javascript:void(0)',
			 		array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'getBilledServicePrint',
			 		$serviceCharge['Billing']['id'],'?'=>array('flag'=>'Services','groupID'=>$groupID,'recID'=>$serviceCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			 }else{
			 	echo $this->Html->link('Print Receipt','javascript:void(0)',
					array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
					$patientID,'?'=>array('flag'=>'Services','groupID'=>$groupID,'recID'=>$serviceCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			 }?></td>
			<?php 
			if($website == 'kanpur')
            {?>
            <td height="30px"><?php 
            	echo $this->Html->link('Print without header','javascript:void(0)',
            			array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
            					$patientID,'?'=>array('flag'=>'Services','groupID'=>$groupID,'header'=>'without','recID'=>$serviceCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
				?></td>
           <?php }?> 
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
websiteInstance='<?php echo $website;?>';
var categoryName='<?php echo $isMandatory;?>';
var mandatoryFlag='<?php echo Configure::read('mandatoryservices');?>';
var admission_type='<?php echo strtolower($addmissionType['Patient']['admission_type']);?>';
var isNurse = "<?php echo $isNursing;?>";
if(isNurse != "yes"){
	var paymentRemark=$( '#receivedRemark', parent.document ).val();//
	var splitRemark=paymentRemark.split('towards');
	var services_name=[];
	var payRemark='';
}
if(categoryName==mandatoryFlag){//hide payment block in mandatory services for IPD patient  --yashwant
	if(admission_type=='ipd'){
		$("#paymentDetailDiv", parent.document ).hide();
	}
}


$('.nonBillable').attr('checked', false); // for private package non billable orders

var chk1Array=[];var tCount=0;
var chk2Array=[];
var chkTempArray=[];
var curIdVal=0;
 
$( '#paymentDetail', parent.document ).trigger('reset');
$( '#amount', parent.document ).attr('readonly',true);//not to allow partial payment
$( '#totalamountpending', parent.document ).val('0');


var tariffStanderdName='<?php echo strtolower($tariffStanderdName);?>';
if(tariffStanderdName!='private'){
	$('.checkbox1').attr('checked', false);
	$("#selectall").attr('checked', false);

	$( '#totalamount', parent.document ).val('0');
	$( '#totaladvancepaid', parent.document ).val('0');
	$( '#maintainRefund', parent.document ).val('0');
	$( '#maintainDiscount', parent.document ).val('0');
	$( '#tariff_list_id', parent.document ).val('');
	$( '#service_amt', parent.document ).val('');

	$( '#amount', parent.document ).val('0');
	$( '#prevDiscount', parent.document ).html('');//for showing previous discount
	$( '#prevRefund', parent.document ).html('');//for showing previous refund

	if(categoryName==mandatoryFlag){
		$( '#amount', parent.document ).val('0');
		$( '#totalamountpending', parent.document ).val('0');//not to allow partial payment..
	}
}else{
	$('.checkbox1').attr('checked', true);
	$("#selectall").attr('checked', true);

	if(categoryName==mandatoryFlag){
		if(websiteInstance=='vadodara'){
			$(".mandatoryFieldIds").each(function () {//to maintain receipt for mandatory services  --yashwant
				curIdVal=$(this).val();
				chk1Array.push(curIdVal);
				serviceName=$(this).attr('service_name');
				   if($.inArray(serviceName, services_name) === -1) 
					   services_name.push(serviceName);				  
			});
		}else{
			var chk1Array = <?php echo json_encode($serviceBillIdArray) ?> ;
			var services_name=<?php echo json_encode($serviceNameArray)?>
		}
	}else{
		$(".checkbox1:checked").each(function () {
		  checkId=this.id;
		  if(!$(this).is(':disabled')){
		   val =$("#"+checkId).val();
		   amount=$("#"+checkId).attr('amount');		   
		   chk1Array.push(val);
		   chk2Array.push(amount);
		   serviceName=$(this).attr('service_name');
		   if($.inArray(serviceName, services_name) === -1) 
			   services_name.push(serviceName);
		  }
		});
	}	
	$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
	$( '#totaladvancepaid', parent.document ).val('<?php echo $paid_amount;?>');
	$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
	$( '#maintainDiscount', parent.document ).val('<?php echo round($allDiscount);?>');
	$( '#tariff_list_id', parent.document ).val(chk1Array);
	$( '#service_amt', parent.document ).val(chk2Array);

	$( '#amount', parent.document ).val('<?php echo $totalAmount-$paid_amount-round($allDiscount);?>');
	$( '#prevDiscount', parent.document ).html('<?php echo ($allDiscount)?round($allDiscount):0;?>');//for showing previous discount
	$( '#prevRefund', parent.document ).html('<?php echo ($paidtopatient)?$paidtopatient:0;?>');//for showing previous refund

	if(isNurse != "yes"){
		payRemark='';
		payRemark=splitRemark[0]+'towards '+services_name+splitRemark[1];
		$('#receivedRemark', parent.document ).val(payRemark);
	}
	if(categoryName==mandatoryFlag){
		$( '#amount', parent.document ).val('<?php echo $totalAmount-$paid_amount-round($allDiscount);?>');
		$( '#totalamountpending', parent.document ).val('<?php echo '0';?>');//not to allow partial payment..
	}
}


$(".deleteService").click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];
	patient_id='<?php echo $patientID;?>';
	groupID='<?php echo $groupID;?>';
	
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteServicesCharges", "admin" => false)); ?>"+"/"+recId+"/"+patient_id+"/"+groupID+'?Flag=opdBill',
			  context: document.body,
			  success: function(data){ 
				  if(categoryName==mandatoryFlag){
					  parent.getServiceData(patient_id,groupID,'mandatoryservices');
				  }else{
				 	  parent.getServiceData(patient_id,groupID);
				  }
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
 * edit individual service record
 */
$(".editService, .cancelService").click(function(){
	var currentRecId=$(this).attr('id');
	splitedVar=currentRecId.split('_');
	type=splitedVar[0];
	recId=splitedVar[1];
	if(type=='editService'){
		$(".duplicateRow").hide();
		$(".row").show();
		$("#row_"+recId).hide();
		$("#duplicateRow_"+recId).show();
	}else if(type=='cancelService'){
		$("#duplicateRow_"+recId).hide();
		$("#row_"+recId).show();
	}
});


/*
 * datepicker for service
 */
$(".editServiceDate").datepicker(
	{
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'dd/mm/yy HH:II:SS',
		minDate:new Date(<?php echo $this->General->minDate($addmissionType['Patient']['form_received_on']); ?>),
		maxDate:new Date(),
		//onSelect:function(){$(this).focus();}
	});
//});

/*
 * autocomplete for service
 */
 
$(document).ready(function(){
	
	 var tariffStanderdId='<?php echo $servicesData[0]['Patient']['tariff_standard_id']?>';
	 var selectedGroup = '<?php echo $groupID;?>';
	 //autocomplete for service sub group 
	 $(document).on('focus','.getServiceSubGroup', function() {
		var currentRecId=$(this).attr('id');
		splitedVar=currentRecId.split('_');
		ID=splitedVar[1];
		 $("#add-service-sub-group_"+ID).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getListOfSubGroup","admin" => false,"plugin"=>false)); ?>/"+selectedGroup,
			 minLength: 1,
			 select: function( event, ui ) {
				$('#service_amount_'+ID).val('');
				$('#amount_'+ID).html('');	
				$('#addServiceSubGroupId_'+ID).val(ui.item.id);
				var sub_group_id = ui.item.id; 
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	 });

	 $(document).on('focus','.getServiceID', function() {
		var currentRecId=$(this).attr('id');
		splitedVar=currentRecId.split('_');
		ID=splitedVar[2]; 
	 	var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
		$("#service_id_"+ID).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+"/"+subGroupID+'?tariff_standard_id='+tariffStanderdId+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $addmissionType['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $addmissionType['Room']['room_type']?>",
			 minLength: 1,
			 select: function( event, ui ) {

				/*$('#onlyServiceId_'+ID).val(ui.item.id);
				var id = ui.item.id; 
				var charges=ui.item.charges;
				if(charges !== undefined && charges !== null){
					charges = charges.replace(/,/g, '');
					$('#service_amount_'+ID).val(charges.trim());
					$('#amount_'+ID).html(charges.trim());
				}
				**/
				$('#service_amount_'+ID).val('');
				$('#fix_discount_'+ID).val('');
				$('#amount_'+ID).html('');				 
				$('#onlyServiceId_'+ID).val(ui.item.id);
				var id = ui.item.id; 
				var charges=ui.item.charges;
				if(charges == '0'){
					charges ='';
				}
				if(charges !== undefined && charges !== null && charges !== ''){
					charges = charges.replace(/,/g, '');
					$('#service_amount_'+ID).val(charges.trim());
					$('#amount_'+ID).html(charges.trim());
					if(ui.item.fix_discount !== undefined && ui.item.fix_discount !== null && ui.item.fix_discount !== ''){
						$('#fix_discount_'+ID).val(ui.item.fix_discount);
					}
					$( '.clinicalServiceAmount').trigger("change");//to maintain clinical service amount  --yashwant
				}else{
					$('#service_amount_'+ID).val('');
					$('#amount_'+ID).html('');
					$('#fix_discount_'+ID).val('');
					inlineMsg(currentID,errorMsg,10);
				}					 
				/*$('#onlyServiceId_'+ID).val(ui.item.id);
				var id = ui.item.id; 
				var charges=ui.item.charges;
				if(charges !== undefined && charges !== null){
					$('#service_amount_'+ID).val(charges.trim());
					$('#amount_'+ID).html(charges.trim());
				}*/
				//serviceSubGroups(this);
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	});
		
 });



 $('.nofTime').on('keyup',function(){
	var currentRecId=$(this).attr('id');
	splitedVar=currentRecId.split('_');
	ID=splitedVar[3];
  	
	serviceAmt=$('#service_amount_'+ID).val(); 
  	valtimes = $(this).val(); 
  	if(isNaN(valtimes)==false){ 
			if(serviceAmt !=''){
		    	totalAmt=serviceAmt*valtimes;
		    	$('#amount_'+ID).html(totalAmt);
			}else{
				alert('Please enter Unit price.');
				$('#service_amount_'+ID).val(''); 
				$(this).val('');
				return false;
			}
  	}else{
  		alert('Please enter valid data.');
			$(this).val('');
			return false;
      }
 });

 $('.service_amount').on('keyup',function(){
	 	var currentRecId=$(this).attr('id');
		splitedVar=currentRecId.split('_');
		ID=splitedVar[2]; 
    	
		noOfTime=$('#no_of_times_'+ID).val(); 
    	valprice = $(this).val(); 
    	if(isNaN(valprice)==false){ 
	  		if(noOfTime !=''){
	  	    	totalAmt=noOfTime*valprice;
	  	    	$('#amount_'+ID).html(totalAmt);
	  		}
    	}else{
  		alert('Please enter valid amount.');
  		$(this).val('');
			return false;
        }
 });

/*
 * update service record
 */
 $(".saveService").click(function(){
	  var flag='Service';
	  patient_id='<?php echo $patientID;?>';
	  groupID='<?php echo $groupID;?>';
	  var currentRecId=$(this).attr('id');
	  splitedVar=currentRecId.split('_');
	  recId=splitedVar[1];
	  /*  var validatePerson = jQuery("#editLabServices_"+recId).validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}*/
		isBillable = ( $('#isBillableSer_'+recId).prop('checked') === true ) ? 1 : 0;
  		date = $('#ServiceDate_'+recId).val();
		subGroupID = $('#addServiceSubGroupId_'+recId).val();
		serviceID = $('#onlyServiceId_'+recId).val();
		amount = $('#service_amount_'+recId).val();
		noOfTimes = $('#no_of_times_'+recId).val();
		description = $('#description_'+recId).val();

		$.ajax({
  				  type : "POST",
  				  data: "is_billable="+isBillable+"&date="+date+"&amount="+amount+"&subGroupID="+subGroupID+"&serviceID="+serviceID+"&noOfTimes="+noOfTimes+"&description="+description,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "updateService", "admin" => false)); ?>"+'/'+patient_id+'/'+recId+'?flag='+flag+'&groupID='+groupID,
  				  context: document.body,
  				  success: function(data){ 
  					  parent.getServiceData(patient_id,groupID);
					  parent.getbillreceipt(patient_id);	
  					$("#busy-indicator").hide();
  				  },
  				  beforeSend:function(){$("#busy-indicator").show();},		  
  			});
 });

 /*
  * clear charges after clearing service name
  */
  	$(document).on('focusout','.getServiceSubGroup', function() {
  		var currentRecId=$(this).attr('id');
		splitedVar=currentRecId.split('_');
		ID=splitedVar[1];
		 if($(this).val()==''){
			 $('#addServiceSubGroupId_'+ID).val('');
		 }
	 });
	
	 $(document).on('focusout','.getServiceID', function() {
		 var currentRecId=$(this).attr('id');
		 splitedVar=currentRecId.split('_');
		 ID=splitedVar[2]; 
		 if($(this).val()==''){
			 $('#onlyServiceId_'+ID).val('');
			 $('#service_amount_'+ID).val('');
			 $('#no_of_times_'+ID).val('1');
			 $('#amount_'+ID).html('');
		 }
	 });

    $('#selectall').click(function(event) {  //on click
        if(this.checked) {  // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
           	 if(!$(this).is(':disabled'))
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
            $( '#paymentDetail', parent.document ).trigger('reset');
            $( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
            $( '#totaladvancepaid', parent.document ).val('<?php echo $paid_amount;?>');
            $( '#tariff_list_id', parent.document ).val(chk1Array);
            $( '#service_amt', parent.document ).val(chk2Array);
            $( '#maintainDiscount', parent.document ).val('<?php echo round($allDiscount);?>');
            $( '#totalamountpending', parent.document ).val('0');
            $('.refundCheck').attr('checked',false);//at a time only one i.e. either payment or refund
           // $( '#amount', parent.document ).val('<?php //echo $totalAmount-$paid_amount;?>');//to show total in amount field
            
			$( '#amount', parent.document ).val('<?php echo $totalAmount-$paid_amount-round($allDiscount);?>');
            holdAmount();
        }else{ 
            $('.checkbox1').each(function() { //loop through each checkbox
           	 if(!$(this).is(':disabled'))
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });
            $( '#paymentDetail', parent.document ).trigger('reset');
            $( '#totalamount', parent.document ).val('0');
            $( '#totaladvancepaid', parent.document ).val('0');
            $( '#amount', parent.document ).val('0');
            $( '#maintainDiscount', parent.document ).val('0');
            $( '#totalamountpending', parent.document ).val('0');
            $( '#tariff_list_id', parent.document ).val('');//service id 
            $( '#service_amt', parent.document ).val('');       
        }
        cardPay();//for payment card check box
    });

   //If one item deselect then button CheckAll is UnCheck
    $(".checkbox1").click(function () {
        if (!$(this).is(':checked'))
            $("#selectall").attr('checked', false);
	     var totalAmount=0;var count=0; var tCount=0;
	     var advPaid=0;var balAmt=0;var balAmtServiceVar=0;
	     var paid_amount_var=0;
	     var chkArray=[];var chkAmtArray=[];var services_name=[];
	     var checkRefund='no';
   		  $(".checkbox1:checked:enabled").each(function () {
   			  count++;
   			  checkId=this.id;
   			  hiddencheck=checkId.split('_');
   			  if(!$(this).is(':disabled')){
	   			  val =$("#"+checkId).val();
	   			  amount=$("#"+checkId).attr('amount');
	   			  discount=$("#"+checkId).attr('discount');//``
	   			  paid_amount=$("#"+checkId).attr('paid_amount');//``
	   			  chkArray.push(val);
	   			  chkAmtArray.push(amount);			  
	   			  totalAmount=totalAmount+parseInt($('#amountBill_'+hiddencheck[1]).html());
	   			  advPaid=advPaid+parseInt($('#partial_amt_'+hiddencheck[1]).val());
	   			  checkRefund='yes';
	   			  serviceName=$(this).attr('service_name');
	 		      if($.inArray(serviceName, services_name) === -1) 
	 			   		services_name.push(serviceName);

	   			/*if(paid_amount=='0' && discount!='0'){//to maintain amount of discounted service --yashwant 
		  			balAmtService=parseInt(amount)-parseInt(discount);
			  	}else{*/
			  		balAmtService=parseInt(amount)-parseInt(paid_amount)-parseInt(discount);
				//}
	   			balAmtServiceVar=parseInt(balAmtServiceVar)+parseInt(balAmtService);//``

	   			if(paid_amount!='0'){
	   				paid_amount_var=parseInt(paid_amount_var) + parseInt(paid_amount);
		   		}
   			  }
   			});

	   		if(checkRefund=='yes'){//at a time only one i.e. either payment or refund
				$('.refundCheck').attr('checked',false);
			}
   			
   		  balAmt=totalAmount-advPaid;
   		  if(advPaid=='' || isNaN(advPaid)){
   			  balAmt=totalAmount
   			  advPaid='0.00';
   		   }
  		   
   		  $('.checkbox1:enabled').each(function() { //loop through each checkbox
   			  tCount++; 
   	 	  });

	   	  if(tCount==count){
   	        	 $("#selectall").prop('checked', true);
   	  		}

		balAmt=balAmtServiceVar;//to maintain amount of discounted service --yashwant 
   	   $( '#paymentDetail', parent.document ).trigger('reset');
	   $( '#discount', parent.document ).hide();
	   $( '#maintainDiscount', parent.document ).val('0');
   	   $( '#totalamount', parent.document ).val(totalAmount);
   	   $( '#tariff_list_id', parent.document ).val(chkArray);//service id
   	   $( '#service_amt', parent.document ).val(chkAmtArray);
   	  // $( '#totaladvancepaid', parent.document ).val(advPaid);
   	   $( '#amount', parent.document ).val(balAmt);
   	  // $('#amount', parent.document).attr('readonly',true);
        //  $( '#totalamountpending', parent.document ).val(balAmt);
          $( '#totalamountpending', parent.document ).val('0');
          holdAmount();
         
       if(chkArray==''){
       	$( '#paymentDetail', parent.document ).trigger('reset');
       	$( '#discount', parent.document ).hide();
        $( '#maintainDiscount', parent.document ).val('0');
       	$( '#totalamount', parent.document ).val('0');
       	$( '#totaladvancepaid', parent.document ).val('0');
       	$( '#amount', parent.document ).val('0');
       	//$( '#totalamountpending', parent.document ).val('<?php //echo $totalAmt+$paidtopatient-$labPaid;?>');
       	$( '#totalamountpending', parent.document ).val('0');
       	$( '#tariff_list_id', parent.document ).val('');//service id
       	$( '#service_amt', parent.document ).val('');
       }
       cardPay();//for payment card check box
    });
    

  //for printing custom service report.
 	var serviceToPrint = new Array();
 	$('.customCheckbox').click(function(){	
 		var currentId= $(this).attr('id');
 		if($(this).prop("checked"))
 			serviceToPrint.push($('#'+currentId).val());
 		else
 			serviceToPrint.remove($('#'+currentId).val());
 		});
 	 
	$('#serviceReport').click(function(){
		if(serviceToPrint!=''){
			var printUrl='<?php echo $this->Html->url(array("controller" => "Billings", "action" => "billReportLab",$patientID)); ?>';
			var printUrl=printUrl +"?flag=Services&groupID="+'<?php echo $groupID;?>';
			var printUrl=printUrl + "&serviceToPrint="+serviceToPrint;
			var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
		}else{
			alert('Select Service from Print Report.');
			return false;
		}
 	});

	//for deleting billing record
	$('.deleteServiceRec').click(function(){
		currentID=$(this).attr('id');
		splitedVar=currentID.split('_');
		recId=splitedVar[1];

		patient_id='<?php echo $patientID;?>';
		groupID='<?php echo $groupID;?>';
		
		if(confirm("Do you really want to delete this record?")){
			$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteBillingEntry", "admin" => false)); ?>"+"/"+recId,
			  context: document.body,
			  success: function(data){ 
				  parent.getServiceData(patient_id,groupID);
				  parent.getbillreceipt(patient_id);	
			  	  $("#busy-indicator").hide();				  
			  },
			  beforeSend:function(){$("#busy-indicator").show();},		  
			});
		}else{
			return false;
		}
	});

	$('.refundCheck').click(function(){//for transfering refund values to parent page on check box chek
		
		var billingIdsArray=[];
		var serviceDiscount=0;
		var refAmount=0;
		var totDisc=0;
		var check='no';
		$(".refundCheck:checked").each(function () {
		  	if(!$(this).is(':disabled')){
		  		var currentId=$(this).attr('id'); 
				var splitedVar=currentId.split('_');
				var  amount=splitedVar[1];
				 serviceId=splitedVar[2];
				 billingId=splitedVar[3];
				 discount=splitedVar[4];
				refAmount=parseInt(refAmount)+parseInt(amount);
				billingIdsArray.push(serviceId);
				totDisc=parseInt(totDisc)+parseInt(discount);
				serviceDiscount=parseInt(refAmount)-parseInt(totDisc);
				check='yes'; 
		  	}
		});

		$( '#refundIds', parent.document ).val(billingIdsArray);
		$( '#refund_amount', parent.document ).val(serviceDiscount);
		$( '#refund_amount', parent.document ).attr('readonly',true);
		
		if(check=='yes'){//at a time only one i.e. either payment or refund
			$('#selectall').attr('checked',false);
			$('.checkbox1').attr('checked',false);
			$( '#is_refund', parent.document ).prop('checked','checked');//to maintain parent page refund check box
			refundFunction();
			showRefundButton();
			$( '#amount', parent.document ).val('');
			$( '#discount_authorize_by_for_refund', parent.document ).val('');
			$("#totalamountpending").val(refAmount);
			$( '#card_pay', parent.document ).attr('disabled',true);
		}else{ 
			$( '#is_refund', parent.document ).prop('checked','');
			refundFunction();
			$("#refund_amount").val('');
			showRefundButton();
			$( '#amount', parent.document ).val('');
			$( '#discount_authorize_by_for_refund', parent.document ).val('');
			$("#totalamountpending").val(refAmount);
			$( '#card_pay', parent.document ).attr('disabled',false);
		}
	});

	$(document).ready(function(){//to reset refunded id array  --yashwant
		$( '#refundIds', parent.document ).val('');
		$( '#refund_amount', parent.document ).val('');
	});
</script>