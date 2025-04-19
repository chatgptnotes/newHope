<?php 
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
		<td style="padding-bottom: 10px" align="right">
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
			<th  class='select table_cell' style="<?php echo $display;?>"><input type="checkbox" id="selectall"  <?php echo $disabled;?>/></th>
			<?php }?>
			<th class="table_cell"><strong><?php echo __('Date'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount To Pay	'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Description'); ?></strong></th>
			<?php if($patient_details['Patient']['is_discharge']!=1 /*&& empty($labCharge)*/){?>
			<th class="table_cell" ><strong><?php echo __('Action'); ?></strong></th>
			<?php }?>
			<?php if($isNursing!='yes'){?>
			<th class="table_cell" ><strong><?php echo __('Print'); ?></strong></th>
			<?php }?>
		</tr>
		<?php $totalAmt= $nonBillable =0;
		$hospitalType = $this->Session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			$nursingServiceCostType = 'nabh_charges';
		}else{
			$nursingServiceCostType = 'non_nabh_charges';
		} 
		$i=0;
		foreach($labData as $labData){?>
		<tr class="row" id=row_<?php echo $labData['LaboratoryTestOrder']['id']; ?>>
		<?php
		
		if($labData['LaboratoryTestOrder']['id']== $paidLab[$labData['LaboratoryTestOrder']['id']] ){
			$disabled="disabled='disabled'";
			$customDiasbled='';
			$displayStatus='none';
		}else{ 
			$disabled='';
			$customDiasbled="disabled='disabled'";
			$displayStatus='';
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
			<td class='select' style="<?php echo $display;?>"><input class="checkbox1 <?php echo $billable;?>" type="checkbox" id="<?php echo "optCheck_".$i; ?>" name="check[]" value="<?php echo $labData['LaboratoryTestOrder']['id'];?>" tariffId="<?php echo  $labData['LaboratoryTestOrder']['id'];?>" <?php echo $disabled;?>>	
			<?php }?>
			<td valign="middle"> <?php echo $this->DateFormat->formatDate2Local($labData['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),true); ?></td>
			<td valign="middle"> <?php echo $labData['Laboratory']['name']; ?></td>
			<td valign="middle"> <?php echo $labData['ServiceProvider']['name']; ?></td>
			<td valign="middle" style="text-align: right;" id="<?php echo "amountBill_".$i;?>"><?php
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
			if($labData['LaboratoryTestOrder']['id']== $paidLab[$labData['LaboratoryTestOrder']['id']] ){
				$paidAmt=$totalAmount1;
			}else{
				$paidAmt='0.00';
			}
			echo $this->Form->input('partial_paid_amt',array('type'=>'hidden','id'=>'partial_amt_'.$i,'value'=>$paidAmt));?>
			
			<td align="right"><?php 
				echo $this->Form->input("LaboratoryTestOrder.$i.id",array('type'=>'hidden','id'=>'payLabId_'.$labData['LaboratoryTestOrder']['id'],'value'=>$labData['LaboratoryTestOrder']['id'],
					/* 'name'=>'data[ServiceBill][][id]', */'legend'=>false,'label'=>false,'class'=>'labAmountToPay'));
				if($totalAmount1==$labData['LaboratoryTestOrder']['paid_amount']){
					echo ($labData['LaboratoryTestOrder']['paid_amount']);
				}else{
					if(empty($labData['LaboratoryTestOrder']['paid_amount']))$labData['LaboratoryTestOrder']['paid_amount']=$totalAmount1;
					echo $this->Form->input("LaboratoryTestOrder.$i.paid_amount",array('class' => 'validate[required,custom[onlyNumber]] textBoxExpnd paidAmtLab labAmountToPay',
						'type'=>'text','legend'=>false,'label'=>false,'id' => 'labAmountToPay_'.$labData['LaboratoryTestOrder']['id'],'fieldNo'=>1,
						/* 'name'=>'data[ServiceBill][][amount_to_pay]', */'autocomplete'=>'off','value'=>$labData['LaboratoryTestOrder']['paid_amount']));
				}
				 
			 ?></td>
			 
			<td valign="middle"> <?php echo $labData['LaboratoryTestOrder']['description']; ?></td>
			<?php if($patient_details['Patient']['is_discharge']!=1){ ?>
			<td valign="middle" style="text-align: center;"><?php 
			 if(empty($labCharge)){
				 echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteLab','id'=>'deleteLab_'.$labData['LaboratoryTestOrder']['id']),
				 array('escape' => false));
			 }
			 if($isNursing!='yes'){
			 	echo $this->Html->image('icons/edit-icon.png',array('style'=>'display:'.$displayStatus,'title'=>'Edit','alt'=>'Edit','class'=>'editLab','id'=>'editLab_'.$labData['LaboratoryTestOrder']['id']),
					array('escape' => false));
			 }
			?>
			</td>
			<?php }?>
			<?php if($isNursing!='yes'){?>
			<td ><input class="customCheckbox" type="checkbox" id="<?php echo "customCheckbox_".$i;?>" 
						name="customCheckbox[]" <?php echo $customDiasbled;?> value="<?php echo $labData['LaboratoryTestOrder']['id'];?>">	</td>
			<?php }?>
		</tr>
		
		
		<tr class="duplicateRow" style="display:none" id=duplicateRow_<?php echo $labData['LaboratoryTestOrder']['id']; ?>>
			<?php if($patient_details['Patient']['is_packaged']){?>
				<td><?php echo $this->Form->input('',array('name'=>'LaboratoryTestOrder[is_billable][]','class'=>'textBoxExpnd','checked'=>$labData['LaboratoryTestOrder']['is_billable'],
					'escape'=>false,'hiddenField'=>false,'multiple'=>false,'type'=>'checkbox','label'=>false,'div'=>false,'id'=>'isBillableLab_'.$labData['LaboratoryTestOrder']['id'],'autocomplete'=>false));?></td>
					 
			<?php }else{?>
				<td></td>
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
			
			<td><?php echo $this->Form->input('', array('name'=>'LaboratoryTestOrder[amount][]','type'=>'text','label'=>false,'id' => 'labAomunt_'.$labData['LaboratoryTestOrder']['id'],'class'=> 'textBoxExpnd specimentype','div'=>false,'value'=>$labData['LaboratoryTestOrder']['amount']));?></td>
			
			<td align="right"><?php echo $labData['LaboratoryTestOrder']['paid_amount']; ?></td>
				
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
			<td colspan="4">&nbsp;</td>
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
		 	<th >Deposit Amount</th>
            <th >Date/Time</th>
            <th >Mode of Payment</th>
            <th >Action</th>
            <th >Print Receipt</th>
		</tr>
		<?php  $totalpaid=0;
			   $paidtopatient=0;
			   $totalpaidDiscount=0;
		foreach($labCharge as $labCharge){ 
			if($labCharge['Billing']['refund']=='1'){
				//echo $paidtopatient1=$labCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$labCharge['Billing']['paid_to_patient'];
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
			<td><?php 
			echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteLabRec',
					'id'=>'deleteLabRec_'.$labCharge['Billing']['id']),array('escape' => false));

			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
				 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				 $labCharge['Billing']['id']))."', '_blank',
				 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?></td>
			<td height="30px"><?php  
			echo $this->Html->link('Print Receipt','javascript:void(0)',
			 		array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
			 				$patientID,'?'=>array('flag'=>'Lab','recID'=>$labCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
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
		            <td align="right" ><?php //echo $labCharge['Billing']['total_amount']; ?></td>
		            <td align="right" ><?php //echo $totalpaid;?></td>
		            <td align="right" ><?php //echo $pendingAmt=$labCharge['Billing']['total_amount']-$totalpaid;?></td>
		        </tr>
		   </tbody>
		</table>	  			
	</td>
  	</tr> -->
</table>
<?php }?>
<?php //}?>
<script>
			
$('.checkbox1').attr('checked', true);
$('.nonBillable').attr('checked', false); // for private package non billable orders
$("#selectall").attr('checked', true);
var chk1Array=[];var tCount=0;
$(".checkbox1:checked").each(function () {
	  checkId=this.id;
	  if(!$(this).is(':disabled')){
	   val =$("#"+checkId).val();
	   chk1Array.push(val);
	  }
	});
$( '#paymentDetail', parent.document ).trigger('reset');
$( '#totalamount', parent.document ).val('<?php echo $totalAmt;?>');
$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
$( '#totaladvancepaid', parent.document ).val('<?php echo $labPaid=$labPaid/*+$totalpaidDiscount*/;?>');
//$( '#amount', parent.document ).val('<?php //echo $totalAmt+$paidtopatient-$labPaid;?>');commented to allow partial payment..
$( '#totalamountpending', parent.document ).val('<?php echo $totalAmt+$paidtopatient-$labPaid-$totalpaidDiscount;?>');
//$( '#totalamountpending', parent.document ).val('0');
$( '#tariff_list_id', parent.document ).val(chk1Array);//service id
$( '#maintainDiscount', parent.document ).val('<?php echo $totalpaidDiscount;?>');
/*
 * delete lab record
 */
$(".deleteLab").click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];
	patient_id='<?php echo $patientID;?>';
	tariffStandardId='<?php echo $tariffStandardId;?>';
	
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteLabCharges", "admin" => false)); ?>"+"/"+recId+"/"+patient_id+'?Flag=labBill',
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
		 source: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "labChargesAutocomplete","admin" => false,"plugin"=>false)); ?>"+'/'+patient_id,
			 minLength: 1,
			 select: function( event, ui ) { 
				$('#labid_'+ID).val(ui.item.id);
				$('#labAomunt_'+ID).val(ui.item.charges);
				
				//if(ui.item.id != '');
				//$( '#labid_'+ID).trigger("change");
			 },
			 messages: {
			        noResults: '',
			        results: function() {},
			 }
		});
});

//BOF on key up enter event to add new row
$(document).on('keypress','.test_name', function(event) {
	var keycode = (event.keyCode ? event.keyCode : event.which);
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	ID=splitedVar[2]; 
	selVal = $('#labid_'+ID).val();
	if(keycode == '13' && selVal != '' ){ 
		if(selVal) //addnew row only if selection is done 
		addMoreLabHtml();//insert new row 
	}
	
});
//EOF enter event by pankaj 

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
			description = $('#description_'+recId).val();
			paid_amount = $('#editLabAmountToPay_'+recId).val();
				
	  			$.ajax({
  				  type : "POST",
  				  data: "is_billable="+isBillable+"&date="+date+"&amount="+amount+"&test_name="+test_name+"&labID="+labID+"&servicePrivider="+servicePrivider+"&description="+description+"&paid_amount="+paid_amount,
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
     	$( '#totaladvancepaid', parent.document ).val('<?php echo $labPaid;?>');
     	$( '#amount', parent.document ).val('<?php echo $totalAmt+$paidtopatient-$labPaid-$totalpaidDiscount;?>');
     	//$( '#totalamountpending', parent.document ).val('<?php //echo $totalAmt+$paidtopatient-$labPaid;?>');
     	$( '#totalamountpending', parent.document ).val('0');
     	$( '#tariff_list_id', parent.document ).val(chk1Array);//service id
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
         //$( '#totalamountpending', parent.document ).val('<?php //echo $totalAmt+$paidtopatient-$labPaid;?>');
         $( '#totalamountpending', parent.document ).val('0');
         $( '#tariff_list_id', parent.document ).val('');//service id        
     }
 });

//If one item deselect then button CheckAll is UnCheck
 $(".checkbox1").click(function () {
     if (!$(this).is(':checked'))
         $("#selectall").attr('checked', false);
  var totalAmount=0;var count=0; var tCount=0;
  var advPaid=0;var balAmt=0;
  var chkArray=[];
		  $(".checkbox1:checked:enabled").each(function () {
			  count++;
			  checkId=this.id;
			  hiddencheck=checkId.split('_');
			  if(!$(this).is(':disabled')){
			  val =$("#"+checkId).val();
			   chkArray.push(val);			  
			   totalAmount=totalAmount+parseInt($('#amountBill_'+hiddencheck[1]).html());
			   advPaid=advPaid+parseInt($('#partial_amt_'+hiddencheck[1]).val());
			  }
			});
			
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
		   			
	   $( '#paymentDetail', parent.document ).trigger('reset');
	   $( '#totalamount', parent.document ).val(totalAmount);
	   $( '#maintainDiscount', parent.document ).val('0');
	   $( '#tariff_list_id', parent.document ).val(chkArray);//service id
	  // $( '#totaladvancepaid', parent.document ).val(advPaid);
	   $( '#amount', parent.document ).val(balAmt);
	  // $('#amount', parent.document).attr('readonly',true);
       $( '#totalamountpending', parent.document ).val('0');

    if(chkArray==''){
    	$( '#paymentDetail', parent.document ).trigger('reset');
    	 $( '#maintainDiscount', parent.document ).val('0');
    	$( '#totalamount', parent.document ).val('0');
    	$( '#totaladvancepaid', parent.document ).val('0');
    	$( '#amount', parent.document ).val('0');
    	//$( '#totalamountpending', parent.document ).val('<?php //echo $totalAmt+$paidtopatient-$labPaid;?>');
    	$( '#totalamountpending', parent.document ).val('0');
    	$( '#tariff_list_id', parent.document ).val('');//service id
    }
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
</script>