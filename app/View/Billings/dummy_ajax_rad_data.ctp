<?php 
$radTotal=0;
$radPaid=0;
foreach($radCharge as $rad_charge){
	if($rad_charge['Billing']['total_amount']>$radTotal)$radTotal=$rad_charge['Billing']['total_amount'];
	$radPaid=$radPaid+$rad_charge['Billing']['amount'];
	//$radPaid=$radPaid+$rad_charge['Billing']['discount'];
}

if(!empty($radData)){?>
<table width="100%">
	<tr>
	<?php //if($patient_details['Patient']['is_discharge']!=1){?>
		<td style="padding-bottom: 10px" align="right">
		<?php   if($isNursing!='yes')
					echo $this->Html->link('Print Report','javascript:void(0)',array('id'=>'radReport','class'=>'blueBtn','escape' => false));?>
		</td>
	<?php //}?>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id="serviceGrid">
		<tr class="row_title">
			<?php if($isNursing!='yes'){?>
			<th  class='select table_cell' style="<?php echo $display;?>"><input type="checkbox" id="selectall"  <?php echo $disabled;?>/></th>
			<?php }?>
			<th class="table_cell"><strong><?php echo __('Date'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount To Pay'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Description'); ?></strong></th>
			<?php if($patient_details['Patient']['is_discharge']!=1 /*&& empty($radCharge)*/){?>
			<th class="table_cell" width="80"><strong><?php echo __('Action'); ?></strong></th>
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
		foreach($radData as $radData){ ?>
		<tr class="row" id=row_<?php echo $radData['RadiologyTestOrder']['id']; ?>>
		<?php 
		if($radData['RadiologyTestOrder']['id']==$paidRad[$radData['RadiologyTestOrder']['id']] ){
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
		if($patient_details['Patient']['is_packaged'] && !$radData['RadiologyTestOrder']['is_billable']){
			$disabled="disabled='disabled'";
			$customDiasbled="disabled='disabled'";
			$displayStatus='';
			$billable = 'nonBillable';
		}
		?>
			<?php if($isNursing!='yes'){?>
			<td class='select' style="<?php echo $display;?>"><input class="checkbox1 <?php echo $billable;?>" type="checkbox" id="<?php echo "optCheck_".$i; ?>" name="check[]" value="<?php echo $radData['RadiologyTestOrder']['id'];?>" tariffId="<?php echo  $radData['RadiologyTestOrder']['id'];?>" <?php echo $disabled;?>>	
			<?php }?>
			<td valign="middle"> <?php echo $this->DateFormat->formatDate2LocalForReport($radData['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true); ?></td>
			<td valign="middle"> <?php echo $radData['Radiology']['name']; ?></td>
			<td valign="middle"> <?php echo $radData['ServiceProvider']['name']; ?></td>
			<td valign="middle" style="text-align: right;" id="<?php echo "amountBill_".$i;?>">
			<?php //echo $totalAmount1=$radData['TariffAmount'][$nursingServiceCostType];
			if(!empty($radData['RadiologyTestOrder']['amount']) && $radData['RadiologyTestOrder']['amount']!=0){
				$totalAmount1=$radData['RadiologyTestOrder']['amount'];
			}else{
				$totalAmount1=$radData['TariffAmount'][$nursingServiceCostType];
			}			
			echo $this->Number->format($totalAmount1,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
			if($patient_details['Patient']['is_packaged'] && $radData['RadiologyTestOrder']['is_billable']){
				$totalAmt=$totalAmt+$totalAmount1;
			}elseif( $patient_details['Patient']['is_packaged'] && !$radData['RadiologyTestOrder']['is_billable'] ){
				$nonBillable=$nonBillable+$totalAmount1;
			}else if(!$patient_details['Patient']['is_packaged']){
				$totalAmt=$totalAmt+$totalAmount1;
			}
			?></td>
			<?php
			if($radData['RadiologyTestOrder']['id']== $paidRad[$radData['RadiologyTestOrder']['id']] ){
				$paidAmt=$totalAmount1;
			}else{
				$paidAmt='0.00';
			}
			echo $this->Form->input('partial_paid_amt',array('type'=>'hidden','id'=>'partial_amt_'.$i,'value'=>$paidAmt));?>
			
			<td align="right"><?php 
				echo $this->Form->input("RadiologyTestOrder.$i.id",array('type'=>'hidden','id'=>'payRadId_'.$radData['RadiologyTestOrder']['id'],'value'=>$radData['RadiologyTestOrder']['id'],
					 'legend'=>false,'label'=>false,'class'=>'radAmountToPay'));
				if($totalAmount1==$radData['RadiologyTestOrder']['paid_amount']){
					echo ($radData['RadiologyTestOrder']['paid_amount']);
				}else{
					if(empty($radData['RadiologyTestOrder']['paid_amount']))$radData['RadiologyTestOrder']['paid_amount']=$totalAmount1;
					echo $this->Form->input("RadiologyTestOrder.$i.paid_amount",array('class' => 'validate[required,custom[onlyNumber]] textBoxExpnd paidAmtRad radAmountToPay',
						'type'=>'text','legend'=>false,'label'=>false,'id' => 'radAmountToPay_'.$radData['RadiologyTestOrder']['id'],'fieldNo'=>1,
						 'autocomplete'=>'off','value'=>$radData['RadiologyTestOrder']['paid_amount']));
				}
				 
			 ?></td>
			
			<td valign="middle"> <?php echo $radData['RadiologyTestOrder']['description']; ?></td>
			<?php if($patient_details['Patient']['is_discharge']!=1){?>
			<td valign="middle" style="text-align: center;">
			<?php 
			if(empty($radCharge)){
			echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteRad','id'=>'deleteRad_'.$radData['RadiologyTestOrder']['id']),
			 array('escape' => false));
			}
			if($isNursing!='yes'){
				echo $this->Html->image('icons/edit-icon.png',array('style'=>'display:'.$displayStatus,'title'=>'Edit','alt'=>'Edit','class'=>'editRad','id'=>'editRad_'.$radData['RadiologyTestOrder']['id']),
					array('escape' => false));
			}?>
			</td>
			<?php }?>
			<?php if($isNursing!='yes'){?>
				<td ><input class="customCheckbox" type="checkbox" id="<?php echo "customCheckbox_".$i;?>" 
						name="customCheckbox[]" <?php echo $customDiasbled;?> value="<?php echo $radData['RadiologyTestOrder']['id'];?>"></td>
			<?php }?>
		</tr>
		
		<tr class="duplicateRow" style="display:none" id=duplicateRow_<?php echo $radData['RadiologyTestOrder']['id']; ?>>
			<?php if($patient_details['Patient']['is_packaged']){?>
				<td><?php echo $this->Form->input('',array('name'=>'data[RadiologyTestOrder][is_billable][]','class'=>'textBoxExpnd','checked'=>$radData['RadiologyTestOrder']['is_billable'],
					'escape'=>false,'hiddenField'=>false,'multiple'=>false,'type'=>'checkbox','label'=>false,'div'=>false,'id'=>'isBillableRad_'.$radData['RadiologyTestOrder']['id'],'autocomplete'=>false));?></td>
				<?php }else{?>
				<td></td>
			<?php }?>
			<td width="12%">
				<?php $todayRadDate=$this->DateFormat->formatDate2Local($radData['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);
				echo $this->Form->input('', array('type'=>'text','id' => 'radiologyDate_'.$radData['RadiologyTestOrder']['id'],'label'=>false,'div'=>false,
				'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  radiologyDate','style'=>'width:120px;',
				'readonly'=>'readonly','name'=>'data[RadiologyTestOrder][radiology_order_date][]','value'=>$todayRadDate)); ?>
			</td>
			<td ><?php echo $this->Form->input('', array('id' => 'radiologyname_'.$radData['RadiologyTestOrder']['id'],'type'=>'text', 'label'=> false, 'div' => false,'value'=>$radData['Radiology']['name'],
					 'error' => false,'autocomplete'=>false,'class'=>'validate[required,custom[mandatory-enter]] radiology_name textBoxExpnd','name'=>'data[RadiologyTestOrder][rad_name][]'));
			echo $this->Form->hidden('', array('type'=>'text','name'=>'data[RadiologyTestOrder][radiology_id][]','id'=>'radiologytest_'.$radData['RadiologyTestOrder']['id'],'class'=>'radiology_test','value'=>$radData['RadiologyTestOrder']['radiology_id']));
			?> </td>
			<td>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>$radServiceProviders,'empty'=>__('None'),'id'=>'service_provider_id_'.$radData['RadiologyTestOrder']['id'],
					'label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd','name'=>"data[RadiologyTestOrder][service_provider_id][]",'value'=>$radData['ServiceProvider']['id']))?></td>
			<td><?php echo $this->Form->input('', array('style'=>'text-align:right','name'=>'data[RadiologyTestOrder][amount][]','type'=>'text',
					'value'=>$radData['RadiologyTestOrder']['amount'],'label'=>false,'id' => 'radAomunt_'.$radData['RadiologyTestOrder']['id'],'class'=> 'textBoxExpnd radAomunt','div'=>false));?></td>
			
			<td align="right"><?php echo $radData['RadiologyTestOrder']['paid_amount']; ?></td>
			
			<td><?php echo $this->Form->input('', array('name'=>'data[RadiologyTestOrder][description][]','type'=>'text','label'=>false,
					'value'=>$radData['RadiologyTestOrder']['description'],'id' => 'description_'.$radData['RadiologyTestOrder']['id'],'class'=> 'textBoxExpnd description','div'=>false));?></td>
			<td><?php 
			echo $this->Html->image('icons/saveSmall.png',array('title'=>'Save','alt'=>'Save','class'=>'saveRad','id'=>'saveRad_'.$radData['RadiologyTestOrder']['id']),
					array('escape' => false));
			echo $this->Html->image('icons/cross.png',array('title'=>'Cancel','alt'=>'Cancel','class'=>'cancelRad','id'=>'cancelRad_'.$radData['RadiologyTestOrder']['id']),
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
<?php if(!empty($radCharge) && $isNursing!='yes'){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both">
	<tr><td >&nbsp;</td></tr>
	<tr>
  		<td style="text-align:center" colspan="5"><strong>Payment Received For Radiology Services</strong></td>
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
		foreach($radCharge as $radCharge){

			if($radCharge['Billing']['refund']=='1'){
				//echo $paidtopatient1=$radCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$radCharge['Billing']['paid_to_patient'];
				continue;
			}else{
				if(!empty($radCharge['Billing']['discount'])){
					//echo $totalpaid1=$radCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$radCharge['Billing']['discount'];
					$totalpaidDiscount=$totalpaidDiscount+$radCharge['Billing']['discount'];
					if(empty($radCharge['Billing']['amount']))
						continue;
				} 
			} ?>
		<tr>
			<td align="right"><?php 
			/*if($radCharge['Billing']['refund']=='1'){
				echo $paidtopatient1=$radCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$paidtopatient1;
			}else{*/
				/*if(empty($radCharge['Billing']['amount']) && !empty($radCharge['Billing']['discount'])){
					echo $totalpaid1=$radCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$totalpaid1;
					$totalpaidDiscount=$totalpaidDiscount+$totalpaid1;
				}else*/if(!empty($radCharge['Billing']['amount'])){
					echo $totalpaid1=$radCharge['Billing']['amount'];//+$radCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$totalpaid1;
				}
			//}?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($radCharge['Billing']['date'],Configure::read('date_format'),true);?></td>
			<!-- <td><?php echo $radCharge['Billing']['reason_of_payment'];?></td> -->
			<td><?php echo $radCharge['Billing']['mode_of_payment'];?></td>
			<td><?php 
			
			echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteRadRec',
					'id'=>'deleteRadRec_'.$radCharge['Billing']['id']),array('escape' => false));

			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
				 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				 $radCharge['Billing']['id']))."', '_blank',
				 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?></td>
			<td height="30px"><?php  echo $this->Html->link('Print Receipt','javascript:void(0)',
			 		array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
			 				$patientID,'?'=>array('flag'=>'Radiology','recID'=>$radCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
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
		            <td align="right" ><?php //echo $radCharge['Billing']['total_amount']; ?></td>
		            <td align="right" ><?php // echo $totalpaid;?></td>
		            <td align="right" ><?php //echo $pendingAmt=$radCharge['Billing']['total_amount']-$totalpaid;?></td>
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
$( '#totaladvancepaid', parent.document ).val('<?php echo $radPaid=$radPaid/*+$totalpaidDiscount*/;?>');
//$( '#amount', parent.document ).val('<?php //echo $totalAmt+$paidtopatient-$radPaid;?>');commented to allow partial payment..
$( '#totalamountpending', parent.document ).val('<?php echo $totalAmt+$paidtopatient-$radPaid-$totalpaidDiscount;?>');
//$( '#totalamountpending', parent.document ).val('0');
$( '#tariff_list_id', parent.document ).val(chk1Array);//service id
$( '#maintainDiscount', parent.document ).val('<?php echo $totalpaidDiscount;?>');

$(".deleteRad").click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];
	patient_id='<?php echo $patientID;?>';
	tariffStandardId='<?php echo $tariffStandardId;?>';

	if(confirm("Do you really want to delete this record?")){
		$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteRadCharges", "admin" => false)); ?>"+"/"+recId+"/"+patient_id+'?Flag=radBill',
			  context: document.body,
			  success: function(data){ 
					  parent.getRadData(patient_id,tariffStandardId);
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
 * datepicker for rad
 */
$(".radiologyDate").datepicker(
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
 * autocomplete for rad
 */
 $(document).on('focus','.radiology_name', function() {
	var currentRecId=$(this).attr('id');
	splitedVar=currentRecId.split('_');
	ID=splitedVar[1];
 
	$(this).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "radChargesAutocomplete","admin" => false,"plugin"=>false)); ?>"+'/'+patientID,
			 minLength: 1,
			 select: function( event, ui ) { 
				$('#radiologytest_'+ID).val(ui.item.id);
				$('#radAomunt_'+ID).val(ui.item.charges);
			 },
			 messages: {
			        noResults: '',
			        results: function() {},
			 }
		});
 });


//BOF on key up enter event to add new row
$(document).on('keypress','.radiology_name', function(event) {
	var keycode = (event.keyCode ? event.keyCode : event.which);
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	ID=splitedVar[1]; 
	selVal = $('#radiologytest_'+ID).val();
	if(keycode == '13' && selVal != '' ){ 
		if(selVal) //addnew row only if selection is done 
		addMoreRadHtml();//insert new row 
	}
	
});
//EOF enter event by pankaj 


/*
 * edit individual rad record
 */
$(".editRad, .cancelRad").click(function(){
	var currentRecId=$(this).attr('id');
	splitedVar=currentRecId.split('_');
	type=splitedVar[0];
	recId=splitedVar[1];
	if(type=='editRad'){
		$(".duplicateRow").hide();
		$(".row").show();
		$("#row_"+recId).hide();
		$("#duplicateRow_"+recId).show();
	}else if(type=='cancelRad'){
		$("#duplicateRow_"+recId).hide();
		$("#row_"+recId).show();
	}
});

/*
 * update rad record
 */
$(".saveRad").click(function(){
	  var flag='Radiology';
	  patient_id='<?php echo $patientID;?>';
 	  var currentRecId=$(this).attr('id');
	  splitedVar=currentRecId.split('_');
	  recId=splitedVar[1];
	  tariffStandardId='<?php echo $tariffStandardId;?>';
	  /*  var validatePerson = jQuery("#editLabServices_"+recId).validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}*/

		if($('#radiologytest_'+recId).val() == ''){
			alert('This radiology is not exist, Please enter another radiology.');
			isOk=false;
			$('#radiologyname_'+recId).val('');
			$('#radiologytest_'+recId).val('');
			return false;
		}else{
			isOk=true;
		}

		if(isOk){
			isBillable = ($('#isBillableRad_'+recId).prop('checked') === true ) ? '1' : '0';
	  		date = $('#radiologyDate_'+recId).val();
			test_name = $('#radiologyname_'+recId).val();
			radID = $('#radiologytest_'+recId).val();
			servicePrivider = $('#service_provider_id_'+recId).val();
			amount = $('#radAomunt_'+recId).val();
			description = $('#description_'+recId).val();
	
			$.ajax({
	  		  type : "POST",
  			  data: "is_billable="+isBillable+"&date="+date+"&amount="+amount+"&test_name="+test_name+"&radID="+radID+"&servicePrivider="+servicePrivider+"&description="+description,
  			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "updateService", "admin" => false)); ?>"+'/'+patient_id+'/'+recId+'?flag='+flag,
  			  context: document.body,
  			  success: function(data){ 
	  			  parent.getRadData(patient_id,tariffStandardId);
				  parent.getbillreceipt(patient_id);	
	  			  $("#busy-indicator").hide();
  			  },
  			  beforeSend:function(){$("#busy-indicator").show();},		  
	  		});
		}
});

 /*
  * clear charges after clearing rad name
  */
  $(document).on('focusout','.radiology_name', function() {
	 var currentRecId=$(this).attr('id');
	 splitedVar=currentRecId.split('_');
	 ID=splitedVar[1]; 
	 if($(this).val()==''){
		 $('#radiologytest_'+ID).val('');
		 $('#radAomunt_'+ID).val('');
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
	         $( '#totaladvancepaid', parent.document ).val('<?php echo $radPaid;?>');
	         $( '#amount', parent.document ).val('<?php echo $totalAmt+$paidtopatient-$radPaid-$totalpaidDiscount;?>');
	         //$( '#totalamountpending', parent.document ).val('<?php //echo $totalAmt+$paidtopatient-$radPaid;?>');
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
		   $( '#maintainDiscount', parent.document ).val('0');
		   $( '#totalamount', parent.document ).val(totalAmount);
		   $( '#tariff_list_id', parent.document ).val(chkArray);//service id
		   //$( '#totaladvancepaid', parent.document ).val(advPaid);
		   $( '#amount', parent.document ).val(balAmt);
		   //$('#amount', parent.document).attr('readonly',true);
	       $( '#totalamountpending', parent.document ).val('0');

	    if(chkArray==''){
	    	$( '#paymentDetail', parent.document ).trigger('reset');
	    	 $( '#maintainDiscount', parent.document ).val('0');
	    	$( '#totalamount', parent.document ).val('<?php echo $totalAmt;?>');
	    //$( '#totaladvancepaid', parent.document ).val('<?php //echo $radPaid;?>');
	    	$( '#amount', parent.document ).val('<?php echo $totalAmt+$paidtopatient-$radPaid;?>');
	    	//$( '#totalamountpending', parent.document ).val('<?php //echo $totalAmt+$paidtopatient-$radPaid;?>');
	    	$( '#totalamountpending', parent.document ).val('0');
	    	$( '#tariff_list_id', parent.document ).val(chk1Array);//service id
	    }
	 });

	//for printing custom rad report.
	 var radToPrint = new Array();
	 	$('.customCheckbox').click(function(){	
	 		var currentId= $(this).attr('id');
	 		if($(this).prop("checked"))
	 			radToPrint.push($('#'+currentId).val());
	 		else
	 			radToPrint.remove($('#'+currentId).val());
	 		});
	 	 
		$('#radReport').click(function(){
			if(radToPrint!=''){
				var printUrl='<?php echo $this->Html->url(array("controller" => "Billings", "action" => "billReportLab",$patientID,'?'=>array('flag'=>'Radiology','recID'=>null))); ?>';
				var printUrl=printUrl + "&radToPrint="+radToPrint;
				var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
			}else{
				alert('Select Radiology from Print Report.');
				return false;
			}
	 });
		 

	//for deleting billing record
	$('.deleteRadRec').click(function(){
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
				  parent.getRadData(patient_id,tariffStandardId);
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