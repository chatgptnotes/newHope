<?php  echo $this->Form->create('',array('id'=>'corporateClaims','default'=>false,  
		'url'=>array('controller'=>'corporates','action'=>'updateCorporatePaymentReceived') ,'inputDefault'=>array('div'=>false,'label'=>false,'error'=>false)));?>
		 
<table  width="100%" class="tabularForm">
	<tr>
		<th width="20%"><?php echo __("Name"); ?></th>
		<th width="8%"><?php echo __("Hospital Invoice"); ?></th>
		<th width="8%"><?php echo __("Advance Received"); ?></th> 
		<th width="8%"><?php echo __("Previous Deduction"); ?></td>
		<th width="13%"><?php echo __("Bill No"); ?></th>
		<th width="10%"><?php echo __("Amount Received"); ?></th>
		<th width="10%"><?php echo __("TDS"); ?></th>
		<th width="10%"><?php echo __("Other Deduction"); ?></th>
		<th width="20%"><?php echo __("Date"); ?></th>
		<th width="20%"><?php echo __("Remark"); ?></th> 
		<th width="20%"><?php echo __("Action"); ?></th>
	</tr>
	<tr>
		<td><?php
			 $totalAmount = $totalAmount-$patientPaidAmt-$discountGiven ;
			 echo $this->Form->hidden('corporate_super_bill_id',array('type'=>'text','id'=>'corporate_super_bill_id','value'=>$result['CorporateSuperBill']['id']));
			 echo $this->Form->hidden('approved_amount',array('type'=>'text','id'=>'approved_amount','value'=>$result['CorporateSuperBill']['approved_amount']));
			 echo $this->Form->hidden('patient_id',array('type'=>'text','id'=>'patient_id','value'=>$patient_id));
			 echo $this->Form->hidden('advance_received',array('type'=>'text','id'=>'advance_received','value'=>$corporatePaidAmt));
			 echo $this->Form->hidden('total_amount',array('type'=>'text','id'=>'total_amount','value'=>$result['CorporateSuperBill']['total_amount'])); 
			 echo $this->Form->hidden('previous_discount',array('type'=>'text','id'=>'previous_discount','value'=>$discountGiven));
		 ?>
			<span id="patient_name"><?php echo $result[0]['lookup_name'];?></span>
		</td>
		
		<td id="hospitalInv"> <?php  echo $this->Number->currency($result['CorporateSuperBill']['total_amount']);  ?> </td> 
		
		<td id="advance_received"><?php echo $this->Number->currency($result['CorporateSuperBill']['total_received']); ?> </td>
		
		<td id="prev_deduct"><?php echo $this->Number->currency($discountGiven); ?></td>
		
		<td><?php echo $this->Form->input('bill_no', array('id'=>'bill_'.$bill_id,'type' => 'text','style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'add_bill_number' ));?></td> 
		
		<td ><?php echo $this->Form->input('received_amount', 
				array('id'=>'received_amount','type' => 'text','style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'formClaim validate[optional,custom[onlyNumber]]','value'=>0 )); ?> </td> 
				
		<td ><?php echo $this->Form->input('tds', array('id'=>'tds','type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'formClaim validate[optional,custom[onlyNumber]]' ,'value'=>0));?></td>
		
		<td><?php echo $this->Form->input('other_deduction', array('id'=>'otherDeductions','type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class' =>'validate[optional,custom[onlyNumber]]'));?></td> 
		 
		<td><?php $d= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
		 	  echo $this->Form->input('bill_uploading_date',array( 'class'=>'bill_uploading_date','label'=>false,'value'=>$d ));  ?> </td> 
		
		<td><?php echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','label'=>false,'rows'=>'1','cols'=>'10','class'=>'add_remark' ));?></td>
		 
		<td><?php echo $this->Html->image('icons/saveSmall.png',array('id'=>'save-corporate-claim','class'=>'corporateClaims')) ; ?></td>
	</tr>
</table> 
<?php 
echo $this->Form->end(); ?>
		
<table cellspacing="1" cellpadding="0" border="0" width="100%" align="center" class="tabularForm" style="margin-top:40px;">
	<thead> 
		<tr>
        	<th width="2%"  style="text-align:center;" align="center" valign="middle">Sr.No</th>
			<th width="10%" style="text-align:center;" align="center" valign="middle">Bill No.</th>
            <th width="10%" style="text-align:center;" align="center" valign="middle">Payment Received</th>
			<th width="10%" style="text-align:center;" align="center" valign="middle" style="">TDS</th>
			<th width="10%" style="text-align:center;" align="center" valign="middle">Other Deduction</th>
        	<th width="10"  style="text-align:center;" align="center" valign="middle">Date</th>
			<th width="20%" style="text-align:center;" align="center" valign="middle">Remark</th>
			<th width="10%" style="text-align:center;" align="center" valign="middle">Action</th>                            
		</tr>
	</thead>
	
	<tbody>
		<?php $srno = 1;  foreach ($result['CorporateSuperBillList'] as $adKey => $adValue){ ?>
		<tr id="<?php echo '' ;?>">
			<td style="text-align:center;" align="center" valign="middle"><?php echo $srno++ ;?></td>
	        <td style="text-align:center;" align="center" valign="middle"><?php echo $adValue['bill_no'];?></td>
	        <td style="text-align:center;" align="center" valign="middle"><?php echo $adValue['received_amount'];?></td>
	        <td style="text-align:center;" align="center" valign="middle"><?php echo $adValue['tds'];
	        $tds=$tds+$adValue['tds'];?></td>
	        <td style="text-align:center;" align="center" valign="middle"><?php echo $adValue['other_deduction'];?></td>
			<td style="text-align:center;" align="center" valign="middle"><?php echo  $this->DateFormat->formatDate2Local($adValue['created_time'],Configure::read('date_format'),true); ?></td>
	        <td style="text-align:center;" align="center" valign="middle"><?php echo $adValue['remark'];?></td>
        	<td style="text-align:center;" align="center" valign="middle">
        		<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'),array('action' => 'corporateReceivedAmountDelete',$adValue['id'],$result['CorporateSuperBill']['id']), 
        					array('escape' => false,'onclick'=>"deleteSuperBillList(".$adValue['id'].",".$result['CorporateSuperBill']['id'].")"));?></td> 
		</tr>
		<?php } ?>
	</tbody>
</table> 
            
<script>
	$(document).on('click',".deleteAdvanceEntry",function(event){ 
	    event.preventDefault();
	});

	$( ".bill_uploading_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		buttonText: "Calendar",
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		maxDate: new Date(),
		maxTime : true,
        showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate($CalenderTime);?>',
	});
	
	$('.corporateClaims').click(function(){ 
			var validatePerson = jQuery("#corporateClaims").validationEngine('validate'); 
	  	 	if(!validatePerson){
	  		 	return false;
	  		}
			postdata = $("#corporateClaims").serialize() ; 
			concat  = "Please confirm your payment amount before proceeding, payment amount is Rs.";
			if($("#amount_received").val() != ''){
				concat += $("#received_amount").val();
			}
			if($("#tds").val() != ''){
				concat += ", TDS is "+$("#tds").val();
			}
			if($("#otherDeduction").val() != '' && $("#otherDeduction").val() != undefined){
				concat += " and  Other deduction is "+$("#otherDeduction").val();
			} 
			
			res = confirm(concat);
			if(res){
				$.ajax({
					url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateCorporatePaymentReceived", "admin" => false));?>"+'/'+$('#corporate_super_bill_id').val(),
					type: 'POST',
					data : $("#corporateClaims").serialize(),  
					beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success: function(data){
						$('#container').html(data);
						$('#busy-indicator').hide();
						parent.$.fancybox.close(); 
						parent.window.location.reload();
					}
				});
			}
			return false ;
		}); 
 
	$('#received_amount').keyup(function(){
		
		var hospitalAmt="<?php echo $result['CorporateSuperBill']['total_amount'];?>";
		var advance="<?php echo $result['CorporateSuperBill']['total_received'];?>";
		var previous_discount="<?php echo isset($discountGiven)?$discountGiven:'0';?>";
		if(isNaN(previous_discount))
			previous_discount=0;
		if(isNaN(advance))
			advance=0;
		var advTds="<?php echo isset($tds)?$tds:'0'?>";
		//var amtRec=$("#amount_received").val();
		/* var tds=$("#tds").val();
		var advance  = $("#advance_received").val(); 
		var previous_discount =parseInt($('#previous_discount').val()); 	// Advance Recieved coming from database 50 
		total = parseInt(amtRec)+parseInt(tds)+parseInt(advance)+parseInt(previous_discount); 
		 
		if(parseInt(total) > parseInt(hospitalAMt)){
			$(this).val('');
			$("#otherDeduction").val('0');
			alert("Addition of amount received and TDS is greater than Hospital invoice");
			return false;
		}*/ 

		var recivedAmt=$(this).val();		
		var totalAmt=0;
		var tds=0;
		if(!isNaN(recivedAmt))
			totalAmt=(parseInt(recivedAmt)*100)/90;
		else
			recivedAmt=0;

		tds=(parseFloat(totalAmt)*10)/100;
		if(!isNaN(tds))
			$('#tds').val(tds);
		else{
			tds=0;
			$('#tds').val(0);
		}
		/*total = parseInt(totalAmt)+parseInt(advance)+parseInt(advTds)+parseInt(previous_discount);
		if(parseInt(total)>parseInt(hospitalAmt)){
			$(this).val('');
			$("#tds").val('');
			alert("Addition of amount received and TDS is greater than Hospital invoice");
			return false;
		}*/
			
	}); 

	function deleteSuperBillList(superBillListID,SuperBillID){
		res = confirm("Are you sure to delete?");
		if(res){
			$.ajax({
				url : "<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "corporateReceivedAmountDelete", "admin" => false));?>"+'/'+superBillListID+'/'+SuperBillID,
				type: 'POST',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide() ;
				} 
			});
		}
	}
	
	 $('.deletesAdvanceEntry').click(function(){
		 var currentID=$(this).attr('id');
		 var splitedVar=currentID.split('_');
		 var recID=splitedVar[1]; 
	 
		 $.ajax({
				url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "corporateAdvanceDelete", "admin" => false));?>"+'/'+recID,
				type: 'POST',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$.fancybox.close();
					window.location.reload();
				}
			});
 

	 });  

	$('.formClaim').keyup(function(){
		    var bill = $(this).attr('id') ;
		    splittedId = bill.split("_");
		    packageId = splittedId[1];
		    var val = $(this).val();
		    var subtract	= parseInt($('#total_amount').val()); 	// Hospital Amount Recieved 192
			var adv_rcd =parseInt($('#advance_received').val()); 	// Advance Recieved coming from database 50 
			var tds = ($('#tds').val() != '') ? parseInt($('#tds').val()) : 0; 		// TDS amount  0
			var amtRec = parseInt($('#amount_received').val()); 	// Amount Recieved from CGHS  
		
			if(isNaN(subtract)){
				subtract=0;
				}
			if(isNaN(amtRec)){
				amtRec=0;
				}
			if(isNaN(adv_rcd)){
				adv_rcd=0;
				}
			if(isNaN(tds)){
				tds=0;
				}
			if(isNaN(val)){
				val=0;
				}
			var totalAmnt = parseInt(subtract) -(parseInt(amtRec)+parseInt(adv_rcd)+parseInt(tds));
			$('#tds').val(tds);
			if(isNaN(totalAmnt)){
				totalAmnt=0;
			}
			$('#otherDeduction').val(totalAmnt); 
	});

	
</script>