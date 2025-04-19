<style>
#LabTableId{ padding-bottom:10px;margin-left:10px;}
.fontTypeForHeads{
font-size:15px !important;
}  
</style>
<?php $website  = $this->Session->read('website.instance');?>
<?php if((ucfirst($this->Session->read('role')) == Configure::read('nurseLabel')) || (ucfirst($this->Session->read('role')) == Configure::read('adminLabel'))){?>
<table id="LabTableId">
	<tr>
	<?php if($getLabData){?>
		<td class="fontTypeForHeads"><strong> Lab:</strong></td>
	<?php }?>
	</tr>
<?php 
	$lastGroupByDate = '';
	foreach($getLabData as $showLab){
	$isPrinted = 0;$isFirst = 0;
	list($key,$value) = explode(" ",$showLab['LaboratoryTestOrder']['create_time']);
		if(empty($lastGroupByDate)){
			$lastGroupByDate = $key;
			$isPrinted = 1;
		}else if($lastGroupByDate != $key){
			$lastGroupByDate = $key;
			$isPrinted = 1;
			$isFirst = 1;
		}
?>
<?php 
		if($isPrinted){?>
		<?php if($isFirst){?></table></td></tr> <?php }?>
		<tr>
			<td class="text textdt" id="bydt_<?php echo str_replace('/','_',$lastGroupByDate)?>" style="cursor:pointer;cusror:hand;text-decoration: underline;">
				<?php echo $this->DateFormat->formatDate2LocalForReport($lastGroupByDate,Configure::read('date_format'),true);?>
			</td>
		</tr>
		<tr><td><table class="bydtdata_<?php echo str_replace('/','_',$lastGroupByDate)?>" style="display:none">	
		<tr>
			<td style="padding-left:20px;">
	
			<?php  if($showLab['LaboratoryResult']['is_authenticate']=='1'){?>
		
	 					<span class='link' id= "<?php echo $showLab['LaboratoryTestOrder']['id']?>" style="color: #79D8ED; display: inline-block;"><?php echo $showLab['Laboratory']['name'];?></span>
					<?php }else{
						echo $showLab['Laboratory']['name'];
					}?>
			</td>
		</tr>
		<?php }else{ ?>
		
		<tr>
			<td style="padding-left:20px;">
	
			<?php  if($showLab['LaboratoryResult']['is_authenticate']=='1'){
		
	 					echo $this->Html->link($showLab['Laboratory']['name'],array("controller" => "NewLaboratories", "action" => "printLab",'?'=>array('testOrderId'=>$showLab['LaboratoryTestOrder']['id'])),array('title'=>'View Detail Result','target'=>'_blank'));
					}else{
						echo $showLab['Laboratory']['name'];
					}?>
			</td>
		</tr>
		<?php }
		}?>
		</table></td></tr>
</table>
<?php }?>


<?php // debug($getLabData);
$labTotal=0;
$labPaid=0;
foreach($labCharge as $lab_charge){
	if($lab_charge['Billing']['total_amount']>$labTotal)$labTotal=$lab_charge['Billing']['total_amount'];
	$labPaid=$labPaid+$lab_charge['Billing']['amount'];
	//$labPaid=$labPaid+$lab_charge['Billing']['discount'];
}

if(!empty($labData)){?>
<table width="100%">
	<tr>
	<?php //($patient_details['Patient']['is_discharge']!=1){?>
		<td style="padding-bottom: 10px;padding-top: 4px" align="right">
		 <?php  
		 if($isNursing!='yes')
			echo $this->Html->link('Print Report','javascript:void(0)',array('id'=>'labReport','class'=>'blueBtn','escape' => false));?>
		</td>
	<?php //}?>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id="serviceGridLab">
		<tr class="row_title">
		<?php if($isNursing!='yes'){?>
			<th  class='select table_cell' style="<?php echo $display;?>"><input type="checkbox" id="selectall"  <?php echo $disabled;?>/> </th>
			<?php }?>
			<th class="table_cell"><strong><?php echo __('Date'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount'); ?></strong></th>
 			<?php //if($patient_details['Patient']['is_discharge']!=1 /*&& empty($labCharge)*/){?>
			<th class="table_cell" ><strong><?php echo __('Action'); ?></strong></th>
			<?php //}?>
			<?php if($isNursing!='yes'){?>
			<th class="table_cell" ><strong><?php echo __('Print'); ?></strong></th>
			<?php }?>
		</tr>
		<?php $totalAmt= $nonBillable = $paid_amount = $allDiscount_lab =0;
			$hospitalType = $this->Session->read('hospitaltype');
			if($hospitalType == 'NABH'){
				$nursingServiceCostType = 'nabh_charges';
			}else{
				$nursingServiceCostType = 'non_nabh_charges';
			} 
			$i=0;
		foreach($labData as $labData){

		if($billedLabId){//for lab wise refund  --yashwant
			$billingId=$billedLabId[$labData['LaboratoryTestOrder']['id']];
		}
		if($labData['LaboratoryTestOrder']['paid_amount']){
			$paid_amount=$paid_amount+$labData['LaboratoryTestOrder']['paid_amount'];
		}
		if($labData['LaboratoryTestOrder']['discount']){
			$allDiscount_lab=$allDiscount_lab+$labData['LaboratoryTestOrder']['discount'];
		}?>
		<tr class="row" id=row_<?php echo $labData['LaboratoryTestOrder']['id']; ?>>
		<?php
		$labPaidAmt=($labData['LaboratoryTestOrder']['amount']-$labData['LaboratoryTestOrder']['paid_amount']-$labData['LaboratoryTestOrder']['discount']);
		$disabled='';
		if($labPaidAmt<=0 && $labData['LaboratoryTestOrder']['amount']>0){
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
		if($patient_details['Patient']['is_packaged'] && !$labData['LaboratoryTestOrder']['is_billable']){
			$disabled="disabled='disabled'";
			$customDiasbled="disabled='disabled'";
			$displayStatus='';
			$billable = 'nonBillable';
		}
		?>
		
			<?php if($isNursing!='yes'){?>
			<td class="select <?php echo $background;?>" style="<?php echo $display;?>">
				<input class="checkbox1 <?php echo $billable;?>" type="checkbox" id="<?php echo "optCheck_".$i; ?>" name="check[]" value="<?php echo $labData['LaboratoryTestOrder']['id'];?>" 
				amount="<?php echo ($labData['LaboratoryTestOrder']['amount']);?>" discount="<?php echo round($labData['LaboratoryTestOrder']['discount']);?>"
				paid_amount="<?php echo round($labData['LaboratoryTestOrder']['paid_amount']);?>" tariffId="<?php echo  $labData['LaboratoryTestOrder']['id'];?>" <?php echo $disabled;?>>	
			<?php }?>
			<td class="<?php echo $background;?>" valign="middle"> <?php echo $this->DateFormat->formatDate2Local($labData['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),true); ?></td>
			<td class="<?php echo $background;?>" valign="middle"> <?php echo $labData['Laboratory']['name']; ?></td>
			<td class="<?php echo $background;?>" valign="middle"> <?php echo $labData['ServiceProvider']['name']; ?></td>
			<td class="<?php echo $background;?>" valign="middle" style="text-align: right;" id="<?php echo "amountBill_".$i;?>"><?php
			if(!empty($labData['LaboratoryTestOrder']['amount']) && $labData['LaboratoryTestOrder']['amount']!=0){
				$totalAmount1=$labData['LaboratoryTestOrder']['amount'];
			}else{
				$totalAmount1=$labData['TariffAmount'][$nursingServiceCostType];
			} 
			//echo $totalAmount1=$labData['TariffAmount'][$nursingServiceCostType];
			echo $this->Number->format($totalAmount1,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
			if($patient_details['Patient']['is_packaged'] && $labData['LaboratoryTestOrder']['is_billable']){
				$totalAmt=$totalAmt+$totalAmount1;
			}elseif( $patient_details['Patient']['is_packaged'] && !$labData['LaboratoryTestOrder']['is_billable'] ){
				$nonBillable=$nonBillable+$totalAmount1;
			}else if(!$patient_details['Patient']['is_packaged']){
				$totalAmt=$totalAmt+$totalAmount1;
			}?></td>
			<?php
			if($labData['LaboratoryTestOrder']['paid_amount']/*$labData['LaboratoryTestOrder']['id']== $paidLab[$labData['LaboratoryTestOrder']['id']] */){
				//$paidAmt=$totalAmount1;
				$paidAmt=$labData['LaboratoryTestOrder']['paid_amount'];
			}else{
				$paidAmt='0.00';
			}
			echo $this->Form->input('partial_paid_amt',array('type'=>'hidden','id'=>'partial_amt_'.$i,'value'=>$paidAmt));?>
			 
			<?php //if($patient_details['Patient']['is_discharge']!=1){ ?>
			<td class="<?php echo $background;?>" valign="middle" style="text-align: center;"><?php 
				 if(/*empty($labCharge)*/$labPaidAmt>0 /*&& strtolower($this->Session->read('role'))=='admin'*/){
					 /* echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteLab','id'=>'deleteLab_'.$labData['LaboratoryTestOrder']['id']),
					 array('escape' => false)); */
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteLab','id'=>'deleteLab_'.$labData['LaboratoryTestOrder']['id']),
						array('escape' => false)),array('controller'=>'billings','action'=>'deleteLabCharges'),array('escape' => false,'class'=>'billingServicesAction'));
				 }
				 if($isNursing!='yes'){
				 	if(($patient_details['Patient']['is_discharge']!=1 && strtolower($tariffStanderdName)!='private') || strtolower($tariffStanderdName)!='private'){//edit for non private discharge patients- pooja 18/06/2016
						echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('style'=>'display:'.$displayStatus,'title'=>'Edit','alt'=>'Edit','class'=>'editLab','id'=>'editLab_'.$labData['LaboratoryTestOrder']['id']),
							array('escape' => false)),array('controller'=>'billings','action'=>'updateService'),array('escape' => false,'class'=>'billingServicesAction'));
					}
				if($website != 'vadodara'){
					if($labPaidAmt<=0  && $patient_details['Patient']['is_discharge']!=1){?>
					<input class="refundCheck" type="checkbox" title="Refund" id="<?php echo "refundCheck_".$labData['LaboratoryTestOrder']['amount']."_".$labData['LaboratoryTestOrder']['id']."_".$billingId."_".$labData['LaboratoryTestOrder']['discount'];?>" name="refundCheckbox[]" <?php echo $customDiasbled;?>  value="">
				<?php } }  }?>
			</td>
			<?php //}?>
			<?php if($isNursing!='yes'){?>
				<td class="<?php echo $background;?>"><input class="customCheckbox" type="checkbox" id="<?php echo "customCheckbox_".$i;?>" 
						name="customCheckbox[]" <?php echo $customDiasbled;?> value="<?php echo $labData['LaboratoryTestOrder']['id'];?>">	</td>
			<?php }?>
		</tr>
		
		
		<tr class="duplicateRow" style="display:none" id=duplicateRow_<?php echo $labData['LaboratoryTestOrder']['id']; ?>>
			<?php if($patient_details['Patient']['is_packaged']){?>
				<td><?php echo $this->Form->input('',array('name'=>'LaboratoryTestOrder[is_billable][]','class'=>'textBoxExpnd','checked'=>$labData['LaboratoryTestOrder']['is_billable'],
					'escape'=>false,'hiddenField'=>false,'multiple'=>false,'type'=>'checkbox','label'=>false,'div'=>false,'id'=>'isBillableLab_'.$labData['LaboratoryTestOrder']['id'],'autocomplete'=>false));?></td>
					<?php }else{?>
				<td>&nbsp;</td>
				<?php }?>
			<td width="12%">
				<?php $todayLabDate=$this->DateFormat->formatDate2Local($labData['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),true);
				echo $this->Form->input('', array('type'=>'text','id' => 'laboratoryDate_'.$labData['LaboratoryTestOrder']['id'],'label'=>false,'div'=>false,
				'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  laboratoryDate','style'=>'width:120px;',
				'readonly'=>'readonly','name'=>'LaboratoryTestOrder[start_date][]','value'=>$todayLabDate)); ?>
			</td>
				
			<td ><?php echo $this->Form->input('',array('name'=>'LaboratoryTestOrder[lab_name][]','class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd test_name','escape'=>false,'multiple'=>false,
							'type'=>'text','label'=>false,'div'=>false,'id'=>'test_name_'.$labData['LaboratoryTestOrder']['id'],'autocomplete'=>false,'placeHolder'=>'Lab Search','value'=>$labData['Laboratory']['name']));
				echo $this->Form->hidden('', array('name'=>'LaboratoryTestOrder[laboratory_id][]','type'=>'text','label'=>false,'id' => 'labid_'.$labData['LaboratoryTestOrder']['id'],'class'=> 'textBoxExpnd labid','div'=>false,'value'=>$labData['LaboratoryTestOrder']['laboratory_id']));
			?><!-- <span class="orderText" id="orderText_1" style="float:right; cursor: pointer;" title="Order Detail"><strong>...</strong></span> --> </td>
		
			<td>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>$serviceProviders,'empty'=>__('None'),'id'=>'service_provider_id_'.$labData['LaboratoryTestOrder']['id'],
											'label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd','name'=>"data[LaboratoryTestOrder][service_provider_id][]",'value'=>$labData['ServiceProvider']['id']))?></td>
			
			<td><?php echo $this->Form->input('', array('name'=>'LaboratoryTestOrder[amount][]','type'=>'text','label'=>false,'id' => 'labAomunt_'.$labData['LaboratoryTestOrder']['id'],
					'class'=> 'textBoxExpnd specimentype','div'=>false,'value'=>$labData['LaboratoryTestOrder']['amount']/*,'readonly'=>'readonly'*/));
			echo $this->Form->input('', array('name'=>'LaboratoryTestOrder[fix_discount][]','type'=>'hidden','label'=>false,'id' => 'lfix_discount_'.$labData['LaboratoryTestOrder']['id'],
					'class'=> 'fix_discount','div'=>false,'value'=>$labData['LaboratoryTestOrder']['discount']/*,'readonly'=>'readonly'*/));?></td>
			
			<td><?php echo $this->Form->input('', array('name'=>'LaboratoryTestOrder[description][]','type'=>'text','label'=>false,'id' => 'description_'.$labData['LaboratoryTestOrder']['id'],'class'=> 'textBoxExpnd description','div'=>false,'value'=>$labData['LaboratoryTestOrder']['description']));?></td>
		
			<td><?php 
			echo $this->Html->image('icons/saveSmall.png',array('title'=>'Save','alt'=>'Save','class'=>'saveLab','id'=>'saveLab_'.$labData['LaboratoryTestOrder']['id']),
					array('escape' => false));
			echo $this->Html->image('icons/cross.png',array('title'=>'Cancel','alt'=>'Cancel','class'=>'cancelLab','id'=>'cancelLab_'.$labData['LaboratoryTestOrder']['id']),
					array('escape' => false));?></td>
			<td></td>
		</tr>
		
		<?php $i++;}?>
		<tr>
			<?php if($isNursing!='yes'){?>
				<td colspan="4" valign="middle" align="right"><?php echo __('Total Amount');?></td>
			<?php }else{?>	
				<td colspan="3" valign="middle" align="right"><?php echo __('Total Amount');?></td>
			<?php }?>
			<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmt + $nonBillable);?></td>
			<?php //if($patient_details['Patient']['is_discharge']!=1 /*&& empty($labCharge)*/){?>
			<td colspan="3">&nbsp;</td>
			<?php //}?>
		</tr>
		<?php if($patient_details['Patient']['is_packaged']){?>
			<tr>
			<td colspan="4" valign="middle" align="right"><?php echo __('Non Billable');?></td>
			<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($nonBillable);?></td>
			<td  valign="middle" align="right"><?php echo __('Billable');?></td>
			<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmt);?></td>
			<td>&nbsp;</td>
		</tr>
		<?php }?>
</table>
<?php }?>
<?php if(!empty($labCharge) && $isNursing!='yes'){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both">
	<tr><td >&nbsp;</td></tr>
	<tr>
  		<td style="text-align:center" colspan="5"><strong>Payment Received For Laboratory Services</strong></td>
  	</tr>
  	
  	<tr>
  	<td>
  		<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm">
		<tr >
		 	<th width="10%">Deposit Amount</th>
            <th >Date/Time</th>
            <th width="10%">Mode of Payment</th>
			<?php if($patient_details['Patient']['tariff_standard_id']==$getTariffRgjayId && $patient_details['Patient']['admission_type']=='IPD'){
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
		foreach($labCharge as $labCharge){ 
			if($labCharge['Billing']['refund']=='1'){
				//echo $paidtopatient1=$labCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$labCharge['Billing']['paid_to_patient'];
				$totalpaidDiscount=$totalpaidDiscount+$labCharge['Billing']['discount'];// to maintain discount in payment detail block  --yashwant
				continue;
			}else{
				if(!empty($labCharge['Billing']['discount'])){
					//echo $totalpaid1=$labCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$labCharge['Billing']['discount'];
					$totalpaidDiscount=$totalpaidDiscount+$labCharge['Billing']['discount'];
					if(empty($labCharge['Billing']['amount']))
						continue;
				}
			}?>
		<tr>
			<td align="right"><?php 
			/*if($labCharge['Billing']['refund']=='1'){
				echo $paidtopatient1=$labCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$paidtopatient1;
			}else{*/
				/*if(empty($labCharge['Billing']['amount']) && !empty($labCharge['Billing']['discount'])){
					echo $totalpaid1=$labCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$totalpaid1;
					$totalpaidDiscount=$totalpaidDiscount+$totalpaid1;
				}else*/if(!empty($labCharge['Billing']['amount'])){
					echo $totalpaid1=$labCharge['Billing']['amount']/*+$labCharge['Billing']['discount']*/;
					$totalpaid=$totalpaid+$totalpaid1;
				}
			//}?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($labCharge['Billing']['date'],Configure::read('date_format'),true);?></td>
			<!-- <td><?php echo $labCharge['Billing']['reason_of_payment'];?></td> -->
			<td><?php echo $labCharge['Billing']['mode_of_payment'];?></td>
			<?php 
			if($patient_details['Patient']['tariff_standard_id']==$getTariffRgjayId && $patient_details['Patient']['admission_type']=='IPD'){
			}else{?>
			<td><?php 
			/* comented becoz if payment deleted then calculation got mis match -*DO NOT REMOVE*- --yashwant
			 * if(strtolower($this->Session->read('role'))=='admin'){
				echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteLabRec',
					'id'=>'deleteLabRec_'.$labCharge['Billing']['id']),array('escape' => false));
			} */

			if(strtolower($this->Session->read('website.instance'))=='kanpur'){
				if(strtolower($patient_details['Patient']['admission_type'])!='opd'){
					echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
						array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
						$labCharge['Billing']['id']))."', '_blank',
						'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

					echo $this->Html->link($this->Html->image('icons/printer_mono.png',array('title'=>'Print Receipt without Header')),'#',
						array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
						$labCharge['Billing']['id'],'?'=>'flag=without_header'))."', '_blank',
						 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

				}
			}else{
				echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
					array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
					$labCharge['Billing']['id']))."', '_blank',
					'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

				/* echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt without Header')),'#',
					array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
					$labCharge['Billing']['id'],'?'=>'flag=without_header'))."', '_blank',
					'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
				 */
			} 
			?></td>
			<?php }?>
			<td height="30px"><?php  
			if($website == 'vadodara'){
				echo $this->Html->link('Print Receipt','javascript:void(0)',
			 		array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'getBilledServicePrint',
			 		$labCharge['Billing']['id'],'?'=>array('flag'=>'Lab','recID'=>$labCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			}else{
				echo $this->Html->link('Print Receipt','javascript:void(0)',
					array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
					$patientID,'?'=>array('flag'=>'Lab','recID'=>$labCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			}?></td>
			<?php 
			if($website == 'kanpur')
            {?>
            <td height="30px"><?php 
            	echo $this->Html->link('Print without header','javascript:void(0)',
            			array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
            					$patientID,'?'=>array('flag'=>'Lab','header'=>'without','recID'=>$labCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
				?></td>
           <?php }?> 
			 
		</tr>
		<?php }?> 
		</table>
  	</td>
  	</tr>
  	<tr><td >&nbsp;</td></tr>
</table>
<?php } ?>
<?php //}?>
<script>
		 
$('.nonBillable').attr('checked', false); // for private package non billable orders

var chk1Array=[];var tCount=0;
	
$( '#paymentDetail', parent.document ).trigger('reset');
$( '#amount', parent.document ).attr('readonly',true);//not to allow partial payment
$( '#totalamountpending', parent.document ).val('0');//for partial payment

var tariffStanderdName='<?php echo strtolower($tariffStanderdName);?>';
if(tariffStanderdName!='private'){
	$('.checkbox1').attr('checked', false);
	$("#selectall").attr('checked', false);

	$( '#totalamount', parent.document ).val('0');
	$( '#maintainRefund', parent.document ).val('0');
	$( '#totaladvancepaid', parent.document ).val('0');
	$( '#amount', parent.document ).val('0');
	$( '#tariff_list_id', parent.document ).val('');//service id
	$( '#maintainDiscount', parent.document ).val('0');
	$( '#prevDiscount', parent.document ).html('');//for showing previous discount
	$( '#prevRefund', parent.document ).html('');//for showing previous refund
	
}else{
	$('.checkbox1').attr('checked', true);
	$("#selectall").attr('checked', true);

	$(".checkbox1:checked").each(function () {
	  checkId=this.id;
	  if(!$(this).is(':disabled')){
	   val =$("#"+checkId).val();
	   chk1Array.push(val);
	  }
	});
	
	$( '#totalamount', parent.document ).val('<?php echo $totalAmt;?>');
	$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
	$( '#totaladvancepaid', parent.document ).val('<?php echo $paid_amount;?>');
	$( '#amount', parent.document ).val('<?php echo $totalAmt-$paid_amount-round($allDiscount_lab);?>');
	$( '#tariff_list_id', parent.document ).val(chk1Array);//service id
	$( '#maintainDiscount', parent.document ).val('<?php echo round($allDiscount_lab);?>');
	$( '#prevDiscount', parent.document ).html('<?php echo ($allDiscount_lab)?$allDiscount_lab:0;?>');//for showing previous discount
	$( '#prevRefund', parent.document ).html('<?php echo ($paidtopatient)?$paidtopatient:0;?>');//for showing previous refund
}

/*
 * delete lab record
 */
$(".deleteLab").click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];
	patient_id='<?php echo $patientID;?>';
	tariffStandardId='<?php echo $tariffStandardId;?>';
	isNursing='<?php echo $isNursing;?>';
	
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteLabCharges", "admin" => false)); ?>"+"/"+recId+"/"+patient_id+'?Flag=labBill&isNursing='+isNursing,
			  context: document.body,
			  success: function(data){ 
					  parent.getLabData(patient_id,tariffStandardId);
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
 * datepicker for lab
 */
$(".laboratoryDate").datepicker(
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
		minDate:new Date(<?php echo $this->General->minDate($patient_details['Patient']['form_received_on']); ?>),
		maxDate:new Date(),
		//onSelect:function(){$(this).focus();}
	});
//});

/*
 * autocomplete for labs
 */
$(document).on('focus','.test_name', function() {
	patient_id='<?php echo $patientID;?>';
	currentId=$(this).attr('id');
	splitedId=currentId.split('_');
	ID=splitedId['2'];
	$(this).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "labChargesAutocomplete","admin" => false,"plugin"=>false)); ?>"+'/'+patient_id+"&admission_type="+"<?php echo $patient_details['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $patient_details['Room']['room_type']?>",
			 minLength: 1,
			 select: function( event, ui ) { 
				/*$('#labAomunt_'+ID).val('');
				$('#labid_'+ID).val(ui.item.id);
				$('#labid_'+ID).val(ui.item.id);
				charges=ui.item.charges;
				if(charges !== undefined && charges !== null){
					charges = charges.replace(/,/g, '');
					$('#labAomunt_'+ID).val($.trim(charges));
					//if(ui.item.id != '');
					//$( '#labid_'+ID).trigger("change");
				}*/

				$('#labAomunt_'+ID).val('');
				$('#lfix_discount_'+ID).val('');
				$('#labid_'+ID).val(ui.item.id);
				charges=ui.item.charges;
				valueRes=ui.item.value;
				if(charges == '0'){
					charges ='';
				}
				var websiteInstance='<?php echo $website;?>';
				if(websiteInstance == 'vadodara'){
					if(valueRes=='Lab Charge' || valueRes=='Histo Lab Charge'){//Editable amount field only for lab charges and histo lab charges
						$('#labAomunt_'+ID).attr('readonly',false);
					}else{
						$('#labAomunt_'+ID).attr('readonly',true);
					}
				}
				if(charges !== undefined && charges !== null && charges !== ''){
					charges = charges.replace(/,/g, '');
					$('#labAomunt_'+ID).val($.trim(charges));
					$('#lfix_discount_'+ID).val(ui.item.fix_discount);
					//if(ui.item.id != '');
					$( '.labServiceAmount').trigger("change");
				}else{
					$('#labAomunt_'+ID).val('');
					$('#lfix_discount_'+ID).val('');
					inlineMsg(currentId,errorMsg,10);
				}
				
				/*$('#labid_'+ID).val(ui.item.id);
				$('#labAomunt_'+ID).val(ui.item.charges);*/
				//if(ui.item.id != '');
				//$( '#labid_'+ID).trigger("change");
			 },
			 messages: {
			        noResults: '',
			        results: function() {},
			 }
		});
});



/*
 * edit individual lab record
 */
$(".editLab, .cancelLab").click(function(){
	var currentRecId=$(this).attr('id');
	splitedVar=currentRecId.split('_');
	type=splitedVar[0];
	recId=splitedVar[1];
	if(type=='editLab'){
		$(".duplicateRow").hide();
		$(".row").show();
		$("#row_"+recId).hide();
		$("#duplicateRow_"+recId).show();
	}else if(type=='cancelLab'){
		$("#duplicateRow_"+recId).hide();
		$("#row_"+recId).show();
	}
});

/*
 * update lab record
 */
 $(".saveLab").click(function(){
	  var flag='Laboratory';
	  patient_id='<?php echo $patientID;?>';
 	  var currentRecId=$(this).attr('id');
	  splitedVar=currentRecId.split('_');
	  recId=splitedVar[1];
	  tariffStandardId='<?php echo $tariffStandardId;?>';
	  /*  var validatePerson = jQuery("#editLabServices_"+recId).validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}*/

		if($('#labid_'+recId).val() == ''){
			alert('This lab is not exist, Please enter another lab.');
			isOk=false;
			$('#test_name_'+recId).val('');
			$('#labid_'+recId).val('');
			return false;
		}else{
			isOk=true;
		}

		if(isOk){
			isBillable = ($('#isBillableLab_'+recId).prop('checked') === true ) ? '1' : '0';
			date = $('#laboratoryDate_'+recId).val();
	  		test_name = $('#test_name_'+recId).val();
			labID = $('#labid_'+recId).val();
			servicePrivider = $('#service_provider_id_'+recId).val();
			amount = $('#labAomunt_'+recId).val();
			discount=$('#lfix_discount_'+ID).val();
			description = $('#description_'+recId).val();
				
	  			$.ajax({
  				  type : "POST",
  				  data: "is_billable="+isBillable+"&date="+date+"&amount="+amount+"&test_name="+test_name+"&labID="+labID+"&servicePrivider="+servicePrivider+"&description="+description,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "updateService", "admin" => false)); ?>"+'/'+patient_id+'/'+recId+'?flag='+flag,
  				  context: document.body,
  				  success: function(data){ 
  					parent.getLabData(patient_id,tariffStandardId);
					parent.getbillreceipt(patient_id);	
  					$("#busy-indicator").hide();
  				  },
  				  beforeSend:function(){$("#busy-indicator").show();},		  
	  			});
		}
 });

/*
 * clear charges after clearing lab name
 */
 $(document).on('focusout','.test_name', function() {
	 patient_id='<?php echo $patientID;?>';
	 currentId=$(this).attr('id');
	 splitedId=currentId.split('_');
	 ID=splitedId['2'];
	 if($(this).val()==''){
		 $('#labid_'+ID).val('');
		 $('#labAomunt_'+ID).val('');
		 $('#lfix_discount_'+ID).val('');
	 }
 });

 $('#selectall').click(function(event) {  //on click
     if(this.checked) { // check select status
        $('.checkbox1').each(function() { //loop through each checkbox
        	 if(!$(this).is(':disabled'))
             this.checked = true;  //select all checkboxes with class "checkbox1"              
        });
        $( '#paymentDetail', parent.document ).trigger('reset');
        $( '#discount', parent.document ).hide();
     	$( '#totalamount', parent.document ).val('<?php echo $totalAmt;?>');
     	$( '#totaladvancepaid', parent.document ).val('<?php echo $paid_amount;?>');
     	//$( '#amount', parent.document ).val('<?php //echo $totalAmt-$paid_amount;?>');
     	 
		$( '#amount', parent.document ).val('<?php echo $totalAmt-$paid_amount-round($allDiscount_lab);?>');
		
     	$( '#totalamountpending', parent.document ).val('0');
     	$( '#tariff_list_id', parent.document ).val(chk1Array);//service id
     	$('.refundCheck').attr('checked',false);//at a time only one i.e. either payment or refund
     	holdAmount();
     	
     }else{
         $('.checkbox1').each(function() { //loop through each checkbox
        	 if(!$(this).is(':disabled'))
             this.checked = false; //deselect all checkboxes with class "checkbox1"                      
         });
         $( '#paymentDetail', parent.document ).trigger('reset');
         $( '#discount', parent.document ).hide();
         $( '#totalamount', parent.document ).val('0');
         $( '#totaladvancepaid', parent.document ).val('0');
         $( '#amount', parent.document ).val('0');
         $( '#totalamountpending', parent.document ).val('0');
         $( '#tariff_list_id', parent.document ).val('');//service id        
     }
     cardPay();//for payment card check box
 });

//If one item deselect then button CheckAll is UnCheck
 $(".checkbox1").click(function () {
     if (!$(this).is(':checked'))
         $("#selectall").attr('checked', false);
  var totalAmount=0;var count=0; var tCount=0;
  var advPaid=0;var balAmt=0;
  var balAmtServiceVar=0; var paid_amount_var=0;
  var chkArray=[];
  var checkRefund='no';
		  $(".checkbox1:checked:enabled").each(function () {
			  count++;
			  checkId=this.id;
			  hiddencheck=checkId.split('_');
			  if(!$(this).is(':disabled')){
			  val =$("#"+checkId).val();

			  amount=$("#"+checkId).attr('amount');//``
   			  discount=$("#"+checkId).attr('discount');//``
   			  paid_amount=$("#"+checkId).attr('paid_amount');//``
   			  
			   chkArray.push(val);			  
			   totalAmount=totalAmount+parseInt($('#amountBill_'+hiddencheck[1]).html());
			   advPaid=advPaid+parseInt($('#partial_amt_'+hiddencheck[1]).val());
			   checkRefund='yes';

			  /* if(paid_amount=='0' && discount!='0'){//to maintain amount of discounted lab --yashwant 
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
       balAmt=balAmtServiceVar;//to maintain amount of discounted lab --yashwant    			
	   $( '#paymentDetail', parent.document ).trigger('reset');
	   $( '#totalamount', parent.document ).val(totalAmount);
	   $( '#maintainDiscount', parent.document ).val('0');
	   $( '#tariff_list_id', parent.document ).val(chkArray);//service id
	   $( '#totaladvancepaid', parent.document ).val(paid_amount_var);
	   $( '#amount', parent.document ).val(balAmt);
       $( '#totalamountpending', parent.document ).val('0');
       holdAmount();
      
    if(chkArray==''){
    	$( '#paymentDetail', parent.document ).trigger('reset');
    	$( '#maintainDiscount', parent.document ).val('0');
    	$( '#totalamount', parent.document ).val('0');
    	$( '#totaladvancepaid', parent.document ).val('0');
    	$( '#amount', parent.document ).val('0');
    	$( '#totalamountpending', parent.document ).val('0');
    	$( '#tariff_list_id', parent.document ).val('');//service id
    }
    cardPay();//for payment card check box
 });

//for printing custom lab report.
 	var labToPrint = new Array();
 	$('.customCheckbox').click(function(){	
 		var currentId= $(this).attr('id');
 		if($(this).prop("checked"))
 			labToPrint.push($('#'+currentId).val());
 		else
 			labToPrint.remove($('#'+currentId).val());
 		});
 	 
	$('#labReport').click(function(){
		if(labToPrint!=''){
			var printUrl='<?php echo $this->Html->url(array("controller" => "Billings", "action" => "billReportLab",$patientID,'?'=>array('flag'=>'Lab','recID'=>null))); ?>';
			var printUrl=printUrl + "&labToPrint="+labToPrint;
			var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
		}else{
			alert('Select Lab from Print Report.');
			return false;
		}
 	});



//for deleting billing record
$('.deleteLabRec').click(function(){
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
			  parent.getLabData(patient_id,tariffStandardId);
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
			var amount=splitedVar[1];
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
	
	$(".link").click(function(){
		var currentId=$(this).attr('id'); 
		var printUrl='<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'printLab'));?>';
		var printUrl=printUrl +"?testOrderId="+currentId;
		var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
	});
		
});
$('.textdt').click(function(){
	$(this).parent('tr').next('tr').find("td:first").find("table:first").toggle();
});


</script>