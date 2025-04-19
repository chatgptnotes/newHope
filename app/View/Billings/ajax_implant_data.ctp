<?php $website  = $this->Session->read('website.instance');?>
<?php 
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
 
if(!empty($servicesData)){?>
<table width="100%">
	<tr>
	<?php //if($discharge=='no'){?>
		<td style="padding-bottom: 10px;padding-top: 4px" align="right"><?php 
			if($isNursing!='yes')
				echo $this->Html->link('Print Report','javascript:void(0)',array('id'=>'serviceReport','class'=>'blueBtn','escape' => false)); ?>
		</td>
		<?php //}?>
	</tr>
 </table> 
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id="serviceGrid">
		<tr>
		<?php if($isNursing!='yes'){?>
			<th class="table_cell select" style="<?php echo $display;?>"><input type="checkbox" id="selectall"  <?php echo $disabled;?>/></th>
			<?php }?>
			<th class="table_cell"><?php echo __('Date');?></th>
			<th class="table_cell"><?php echo __('Supliers');?></th>
			<th class="table_cell"><?php echo __('Service');?></th>
			<th class="table_cell"><?php echo __('Unit Price');?></th>
			<th class="table_cell"><?php echo __('Units');?></th>
			<th class="table_cell"><?php echo __('Amount');?></th>
			<!-- <th class="table_cell"><?php //echo __('Description');?></th> -->
			<?php //if($discharge=='no'){?>
			<th class="table_cell"><?php echo __('Action');?></th>
			<?php if($isNursing!='yes'){?>
			<th class="table_cell"><?php echo __('Print'); ?></th>
			<?php }//}?>
		</tr>
	<?php $totalAmount=$paid_amount_implant=$allDiscount_implant=0;
	 $i=0;
	foreach($servicesData as $services){ 
		if($services['ServiceBill']['paid_amount']){
			$paid_amount_implant=$paid_amount_implant+$services['ServiceBill']['paid_amount'];
		}
		if($services['ServiceBill']['discount']){
			$allDiscount_implant=$allDiscount_implant+$services['ServiceBill']['discount'];
		}
		$serviceGroup=($services['ServiceCategory']['alias'])?$services['ServiceCategory']['alias']:$services['ServiceCategory']['name']; ?>
		<tr class="row" id=row_<?php echo $services['ServiceBill']['id']; ?>>
			<?php if($isNursing!='yes'){ 
				$serviceGroup=($services['ServiceCategory']['alias'])?$services['ServiceCategory']['alias']:$services['ServiceCategory']['name'];
				$no_of_time = $services['ServiceBill']['no_of_times']?$services['ServiceBill']['no_of_times']:1;
				// Comparing for already paid services and disabling the chkboxes-- Pooja
				$servicepaidAmt=($services['ServiceBill']['amount']*$no_of_time)-$services['ServiceBill']['paid_amount'];
				$disabled='';
				if($services['ServiceBill']['paid_amount']>0  && $services['ServiceBill']['amount']>0){
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
				<td class="select <?php echo $background;?>" style="<?php echo $display;?>"><input class="checkbox1" type="checkbox" id="<?php echo "optCheck_".$i; ?>" name="check[]" value="<?php echo $services['ServiceBill']['id'];?>" amount="<?php echo ($services['ServiceBill']['amount']*$no_of_time);?>" <?php echo $disabled;?> tariffId="<?php echo $services['TariffList']['id'];?>">
			<?php }?>
			<td class="<?php echo $background;?>" align="">
				<?php //echo $services['ServiceBill']['date'];
					if(!empty($services['ServiceBill']['date']))echo $this->DateFormat->formatDate2Local($services['ServiceBill']['date'],Configure::read('date_format'),true);
				?>
			</td>
		 
			<td class="<?php echo $background;?>"><?php echo $supliers[$services['ServiceBill']['suplier']];?></td>
		 
			<td class="<?php echo $background;?>"><?php echo $services['TariffList']['name'];?></td>
			<td class="<?php echo $background;?>" align="right"><?php echo $services['ServiceBill']['amount'];?></td>
			<td class="<?php echo $background;?>" align=""><?php echo $no_of_time = $services['ServiceBill']['no_of_times']?$services['ServiceBill']['no_of_times']:1;?></td>
			<td class="<?php echo $background;?>" align="right" class="amountBill" id="<?php echo 'amountBill_'.$i ?>"><?php echo ($totalAmount1=$services['ServiceBill']['amount']*$no_of_time);
			$totalAmount=$totalAmount+$totalAmount1;?></td>
			<?php //hidden field to save partially paid amount 
			if($services['ServiceBill']['id']== $paidService[$services['ServiceBill']['id']] ){
				$paidAmt=$totalAmount1;
			}else{
					$paidAmt='0';
			}
			
			 echo $this->Form->input('partial_paid_amt',array('type'=>'hidden','id'=>'partial_amt_'.$i,'value'=>$paidAmt));?>
			
			<?php if($servicesData[0]['ServiceCategory']['name']!=Configure::read('mandatoryservices')){?>
			<!-- <td  ><?php //echo $services['ServiceBill']['description'];?></td> -->
			<?php //if($discharge=='no'){ ?>
			<td class="<?php echo $background;?>" align="center">
			<?php 
			if($services['ServiceBill']['paid_amount'] <= 0 /*&& $discharge=='no'/*  && strtolower($this->Session->read('role'))=='admin' */){
				/* echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteService','id'=>'deleteService_'.$services['ServiceBill']['id']),
					array('escape' => false)) ; */
				echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteService','id'=>'deleteService_'.$services['ServiceBill']['id']),
					array('escape' => false)),array('controller'=>'billings','action'=>'deleteServicesCharges'),array('escape' => false,'class'=>'billingServicesAction'));
			}
			
			if($isNursing!='yes' && $discharge=='no'){
				/* echo $this->Html->image('icons/edit-icon.png',array('style'=>'display:'.$displayStatus,'title'=>'Edit','alt'=>'Edit','class'=>'editService','id'=>'editService_'.$services['ServiceBill']['id']),
					array('escape' => false)); */
				echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('style'=>'display:'.$displayStatus,'title'=>'Edit','alt'=>'Edit','class'=>'editService','id'=>'editService_'.$services['ServiceBill']['id']),
					array('escape' => false)),array('controller'=>'billings','action'=>'updateService'),array('escape' => false,'class'=>'billingServicesAction'));
			}?>
			</td>
			<?php if($isNursing!='yes'){?>
			<td class="<?php echo $background;?>" ><input class="customCheckbox" type="checkbox" id="<?php echo "customCheckbox_".$i;?>" 
						name="customCheckbox[]" <?php echo $customDiasbled;?> value="<?php echo $services['ServiceBill']['id'];?>">	</td>
			<?php }}//} ?>
		</tr>
		
		<tr class="duplicateRow" style="display:none" id=duplicateRow_<?php echo $services['ServiceBill']['id']; ?>>
			<td></td>
			<td align="center"  >
				<input type="hidden" value="1" id="no_of_fields">	
				<?php $todayServiceDate=$this->DateFormat->formatDate2Local($services['ServiceBill']['date'],Configure::read('date_format'),true);
				echo $this->Form->input('', array('type'=>'text','id' => 'ServiceDate_'.$services['ServiceBill']['id'],'label'=>false,'div'=>false,
				'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  editServiceDate','style'=>'width:120px;',
				'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ServiceBill][date]','value'=>$todayServiceDate)); ?>
			</td>
			 
			<td align="center">
				<?php echo $this->Form->input('suplier',array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd suplier',
					'id'=>'suplier_'.$services['ServiceBill']['id'],'name'=>'data[ServiceBill][suplier]','empty'=>'Please select',
					'options'=>$supliers,'label'=>false,'div'=>false,'style'=>'width:120px;','value'=>$services['ServiceBill']['suplier']));?></td>
						
			<td align="center" >
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
					'div'=>false,'value'=>$services['ServiceBill']['no_of_times']));?></td>
			
			<td id="amount_<?php echo $services['ServiceBill']['id'];?>" class="amount" valign="middle" style="text-align:center;">
			<?php $no_of_time = $services['ServiceBill']['no_of_times']?$services['ServiceBill']['no_of_times']:1;
				echo $services['ServiceBill']['amount']*$no_of_time;?></td>
			
			<!-- <td align="center"><?php echo $this->Form->input('description',array('class'=>' textBoxExpnd description','id'=>'description_'.$services['ServiceBill']['id'],
					'type'=>'text','style'=>'width:150px;','name'=>'data[ServiceBill][description]','label'=>false,'div'=>false,'value'=>$services['ServiceBill']['description']));?></td>
			 -->
			
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
	
		 
	<tr>
		<?php if($isNursing!='yes'){?>
			<td colspan="6" valign="middle" align="right"><?php echo __('Total Amount');?></td>
		<?php }else{?>	
			<td colspan="5" valign="middle" align="right"><?php echo __('Total Amount');?></td>
		<?php }?>
		<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmount);?></td>
		<td colspan="3">&nbsp;</td>
	</tr>
</table>
<?php } ?>

<?php if(!empty($serviceCharge) && $isNursing!='yes'){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both">
	<tr><td >&nbsp;</td></tr>
	<tr>
  		<td style="text-align:center" colspan="5"><strong>Payment Received For Implant</strong></td>
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
			} */
			
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

				/* echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt without Header')),'#',
	            	array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				   $serviceCharge['Billing']['id'],'?'=>'flag=without_header'))."', '_blank',
						 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

 */
			} 
			?></td>
			<?php }?>
			<td height="30px"><?php  
			if(!empty($serviceCharge['Billing']['tariff_list_id'])){
			 if($website == 'vadodara'){
				echo $this->Html->link('Print Receipt','javascript:void(0)',
			 		array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'getBilledServicePrint',
			 		$serviceCharge['Billing']['id'],'?'=>array('flag'=>'Services','groupID'=>$groupID,'recID'=>$serviceCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			 }else{
			 	echo $this->Html->link('Print Receipt','javascript:void(0)',
					array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
					$patientID,'?'=>array('flag'=>'Services','groupID'=>$groupID,'recID'=>$serviceCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			 }
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
var categoryName='<?php echo $servicesData[0]['ServiceCategory']['name'];?>';
var mandatoryFlag='<?php echo Configure::read('mandatoryservices');?>';

var chk1Array=[];var tCount=0;
var chk2Array=[];


$( '#paymentDetail', parent.document ).trigger('reset');//$allDiscount_implant
$( '#totalamountpending', parent.document ).val('0');
$( '#totalamountpending', parent.document ).val('<?php echo '0';?>');//  to allow partial payment..
$( '#amount', parent.document ).attr('readonly',true);//not to allow partial payment

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
	
}else{
	$('.checkbox1').attr('checked', true);
	$("#selectall").attr('checked', true);

	$(".checkbox1:checked").each(function () {
	  checkId=this.id;
	  if(!$(this).is(':disabled')){
	   val =$("#"+checkId).val();
	   amount=$("#"+checkId).attr('amount');
	   chk1Array.push(val);
	   chk2Array.push(amount);
	  }
	});

	$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
	$( '#totaladvancepaid', parent.document ).val('<?php echo $paid_amount_implant;?>');
	$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
	$( '#maintainDiscount', parent.document ).val('<?php echo round($allDiscount_implant);?>');
	$( '#tariff_list_id', parent.document ).val(chk1Array);
	$( '#service_amt', parent.document ).val(chk2Array);
	$( '#amount', parent.document ).val('<?php echo $totalAmount-$paid_amount_implant-round($allDiscount_implant);?>');
	$( '#prevDiscount', parent.document ).html('<?php echo ($allDiscount_implant)?round($allDiscount_implant):0;?>');//for showing previous discount
	$( '#prevRefund', parent.document ).html('<?php echo ($paidtopatient)?$paidtopatient:0;?>');//for showing previous refund
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
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteServicesCharges", "admin" => false)); ?>"+"/"+recId+"/"+patient_id+'?Flag=opdBill',
			  context: document.body,
			  success: function(data){ 
					  parent.getImplantData(patient_id,groupID);
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
				/*$('#implantAmount_'+ID).val('');
				$('#implantTotalAmount_'+ID).html('');	
				$('#onlyServiceId_'+ID).val(ui.item.id);
				var id = ui.item.id; 
				var charges=ui.item.charges;
				if(charges !== undefined && charges !== null){
					charges = charges.replace(/,/g, '');
					$('#service_amount_'+ID).val(charges.trim());
					$('#amount_'+ID).html(charges.trim());
				}*/

				$('#implantAmount_'+ID).val('');
				$('#implantTotalAmount_'+ID).html('');					 
				$('#onlyImplantId_'+ID).val(ui.item.id);
				var id = ui.item.id; 
				var charges=ui.item.charges;
				if(charges == '0'){
					charges ='';
				}
				if(charges !== undefined && charges !== null && charges !== ''){
					charges = charges.replace(/,/g, '');
					$('#implantAmount_'+ID).val(charges.trim());
					$('#implantTotalAmount_'+ID).html(charges.trim());
				}else{
					$('#implantAmount_'+ID).val('');
					$('#implantTotalAmount_'+ID).html('');
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
	   
  		date = $('#ServiceDate_'+recId).val();
		subGroupID = $('#addServiceSubGroupId_'+recId).val();
		serviceID = $('#onlyServiceId_'+recId).val();
		amount = $('#service_amount_'+recId).val();
		noOfTimes = $('#no_of_times_'+recId).val();
		description = $('#description_'+recId).val();
		suplier = $('#suplier_'+recId).val();

		$.ajax({
  			type : "POST",
  			data: "date="+date+"&amount="+amount+"&subGroupID="+subGroupID+"&serviceID="+serviceID+"&noOfTimes="+noOfTimes+"&description="+description+"&suplier="+suplier,
  			url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "updateService", "admin" => false)); ?>"+'/'+patient_id+'/'+recId+'?flag='+flag+'&groupID='+groupID,
  			context: document.body,
  			success: function(data){ 
  				parent.getImplantData(patient_id,groupID);
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
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
           	 if(!$(this).is(':disabled'))
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
            $( '#paymentDetail', parent.document ).trigger('reset');
            $( '#discount', parent.document ).hide();
            $( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
            $( '#totaladvancepaid', parent.document ).val('<?php echo $paid_amount_implant;?>');
            $( '#tariff_list_id', parent.document ).val(chk1Array);
            $( '#service_amt', parent.document ).val(chk2Array);
            $( '#totalamountpending', parent.document ).val('0');
            //$( '#amount', parent.document ).val('<?php //echo $totalAmount-$paid_amount_implant;?>');//to show total in amount field.

            $( '#amount', parent.document ).val('<?php echo $totalAmount-$paid_amount_implant-round($allDiscount_implant);?>');
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
            $( '#service_amt', parent.document ).val('');            
        }
    });

   //If one item deselect then button CheckAll is UnCheck
    $(".checkbox1").click(function () {
        if (!$(this).is(':checked'))
            $("#selectall").attr('checked', false);
     var totalAmount=0;var count=0; var tCount=0;
     var advPaid=0;var balAmt=0;
     var chkArray=[];
     var chkAmtArray=[];
   		  $(".checkbox1:checked").each(function () {
   			  count++;
   			  checkId=this.id;
   			  hiddencheck=checkId.split('_');
   			  if(!$(this).is(':disabled')){
   			  val =$("#"+checkId).val();
   			   chkArray.push(val);
   			   chkAmtArray.push(amount);			  
   			   totalAmount=totalAmount+parseInt($('#amountBill_'+hiddencheck[1]).html());
   			   advPaid=advPaid+parseInt($('#partial_amt_'+hiddencheck[1]).val());
   			  }
   			});
   			
   		  balAmt=totalAmount-advPaid;
   		  if(advPaid=='' || isNaN(advPaid)){
   			  balAmt=totalAmount
   			  advPaid='0.00';
   		   }
   		  $('.checkbox1').each(function() { //loop through each checkbox
   			  tCount++; 
   				              
   	         });
   	         if(tCount==count){
   	        	 $("#selectall").prop('checked', true);
   	         }
   		   			
   	   $( '#paymentDetail', parent.document ).trigger('reset');
   	   $( '#totalamount', parent.document ).val(totalAmount);
   		$( '#maintainDiscount', parent.document ).val('0');
   	   $( '#tariff_list_id', parent.document ).val(chkArray);//service id
   	   $( '#service_amt', parent.document ).val(chkAmtArray);
   	   $( '#amount', parent.document ).val(balAmt);
          $( '#totalamountpending', parent.document ).val('0');
          holdAmount();
       if(chkArray==''){
       	$( '#paymentDetail', parent.document ).trigger('reset');
       	$( '#totalamount', parent.document ).val('0');
       	$( '#maintainDiscount', parent.document ).val('0');
       	$( '#totaladvancepaid', parent.document ).val('0');
       	$( '#amount', parent.document ).val('0');
       	$( '#totalamountpending', parent.document ).val('0');
       	$( '#tariff_list_id', parent.document ).val('');//service id
    	$( '#service_amt', parent.document ).val('');
       }
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
				  parent.getImplantData(patient_id,groupID);
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