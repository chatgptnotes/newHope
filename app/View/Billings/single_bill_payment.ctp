<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'singleBillPayment','id'=>'singleBillPaymentFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('Billing.patient_id',array('value'=>$patientID));
echo $this->Form->hidden('Billing.payment_category',array('value'=>'All'));
?>

<table width="95%" cellspacing="0" cellpadding="0" border="0" style="padding-top: 10px;padding-left: 10px;margin-left:20px;margin-top:20px;" align="center" bgcolor="LightGray" >
    <tbody>
    	<tr>
            <td width="80%" valign="top">
               <table width="100%" cellspacing="3" cellpadding="0" border="0" align="center">
      			<tbody>
      				<tr>
                      <td width="30%"  class="tdLabel2"><?php echo __('Total Amount' );?></td>
                      <td width="30%"><?php   
		                echo $this->Form->input('Billing.total_amount',array('readonly'=>'readonly','value' => $total_amount,'legend'=>false,'label'=>false,'id' => 'totalamount','style'=>'text-align:right;'));
 						?></td>
                    </tr>
                     <tr>
                       <td class="tdLabel2">Advance Amount</td>
                       <td><?php  echo $this->Form->input('Billing.amount_paid',array('readonly'=>'readonly','value' => $totalpaid,'legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'text-align:right;'));
					      ?></td>
                    </tr>
                    
                    <tr>
				    <td class="tdLabel2">Amount Paid</td>
				    <td><?php echo $this->Form->input('Billing.amount',array('class' => 'validate[optional,custom[onlyNumber]] ','autocomplete'=>'off','type'=>'text','value'=>'','legend'=>false,'label'=>false,'id' => 'amount','style'=>'text-align:right;'));?>
				    </td>
				    <td><span style="float:left;"><font color="red">&nbsp;&nbsp;*&nbsp;</font></span>
					    <?php echo $this->Form->input('Billing.date',array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:150px;'));?>
					</td>
				    </tr> 
                    
                   <tr>
                      <td class="tdLabel2"><strong>Balance</strong></td>
                       <td> <?php echo $this->Form->input('Billing.amount_pending',array('readonly'=>'readonly','value' => ($total_amount-$totalpaid),'legend'=>false,'label'=>false,'id' => 'totalamountpending','style'=>'text-align:right;'));
						  ?></td>
					</tr>
					 
					<tr>
					    <td height="35" class="tdLabel2"><strong>Mode Of Payment<font color="red">*</font></strong></td>
					    <td><?php  echo $this->Form->input('Billing.mode_of_payment', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:141px;',
					   								'div' => false,'label' => false,'empty'=>__('Please select'),'autocomplete'=>'off',
					   								'options'=>array('Cash'=>'Cash','Cheque'=>'Cheque','Credit Card'=>'Credit Card','Credit'=>'Credit','NEFT'=>'NEFT'),'id' => 'mode_of_payment')); ?>
					   	</td>
					 </tr> 
   					<tr id="creditDaysInfo" style="display:none">
					  	<td height="35" class="tdLabel2"> 
					  		Credit Period<font color="red">*</font><br /> (in days)</td>
					    <td><?php echo $this->Form->input('Billing.credit_period',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'credit_period','class'=> 'validate[required,custom[mandatory-enter-only]]'));?></td>
				   </tr> 
		   <tr id="paymentInfo" style="display:none">
			  	<td height="35" colspan="2" class="tdLabel2"> 
				  	<table width="100%" > 
					    <tr>
						    <td class="tdLabel2">Bank Name</td>
						    <td><?php echo $this->Form->input('Billing.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_paymentInfo'));?></td>
						</tr>
						    <tr>
						    <td class="tdLabel2">Account No.</td>
						    <td><?php echo $this->Form->input('Billing.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfo'));?></td>
						</tr>
						    <tr>
						    <td class="tdLabel2">Cheque/Credit Card No.</td>
						    <td><?php echo $this->Form->input('Billing.check_credit_card_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?></td>
					    </tr>
				    </table>
			    </td>
		   </tr>
   <tr id="neft-area" style="display:none;">
	  	<td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%"> 
			    <tr>
				    <td class="tdLabel2" width="47%">Bank Name</td>
				    <td><?php echo $this->Form->input('Billing.bank_name_neft',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_neftArea'));?></td>
				</tr>
				    <tr>
				    <td class="tdLabel2">Account No.</td>
				    <td><?php echo $this->Form->input('Billing.account_number_neft',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_neftArea'));?></td>
				</tr> 
			    <tr>
				    <td class="tdLabel2">NEFT No.</td>
				    <td><?php echo $this->Form->input('Billing.neft_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number'));?></td>
				</tr>
				    <tr>
				    <td class="tdLabel2">NEFT Date</td>
				    <td><?php echo $this->Form->input('Billing.neft_date',array('type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd','id' => 'neft_date'));?></td>
				</tr>
		    </table>
	    </td>
  </tr> 
           
    </tbody>
	</table>
	</td>         
    </tr>
   <tr>
     <td valign="top" align="right" style="padding-top: 15px;" colspan="2"> <input class="blueBtn" type="submit" value="Save" id="submit"> </td> 
     <td valign="top" align="right" style="padding-top: 15px;">&nbsp;</td>
   </tr>
     <tr><td>&nbsp;</td></tr>
    </tbody>
   </table>
  <?php echo $this->Form->end(); ?>
  
<script>

$(document).ready(function(){
	if('<?php echo $saveFlag;?>'=='yes'){ 
		parent.jQuery.fancybox.close();
	}
});
$("#submit").click(function(){ 
	var validatePerson = jQuery("#singleBillPaymentFrm").validationEngine('validate'); 
	if(!validatePerson){
	 	return false;
	}
});
	
if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
	 $("#paymentInfo").show();
	 $("#creditDaysInfo").hide();
	 $('#neft-area').hide();
} else if($("#mode_of_payment").val() == 'Credit') {
 	$("#creditDaysInfo").show();
 	$("#paymentInfo").hide();
 	$('#neft-area').hide();
} else if($('#mode_of_payment').val()=='NEFT') {
    $("#creditDaysInfo").hide();
	$("#paymentInfo").hide();
	$('#neft-area').show();
}

$("#mode_of_payment").change(function(){
	//alert('here');
	if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
		 $("#paymentInfo").show();
		 $("#creditDaysInfo").hide();
		 $('#neft-area').hide();
	} else if($("#mode_of_payment").val() == 'Credit') {
	 	$("#creditDaysInfo").show();
	 	$("#paymentInfo").hide();
	 	$('#neft-area').hide();
	} else if($('#mode_of_payment').val()=='NEFT') {
	    $("#creditDaysInfo").hide();
		$("#paymentInfo").hide();
		$('#neft-area').show();
	}else{
		 $("#creditDaysInfo").hide();
		 $("#paymentInfo").hide();
		 $('#neft-area').hide();
	}
});
			   		
$( "#discharge_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'dd/mm/yy HH:II:SS',
	//minDate:new Date(<?php echo $this->General->minDate($wardInDate) ?>),
	onSelect:function(){$(this).focus();}
});

$( "#neft_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'dd/mm/yy HH:II:SS',
	//minDate:new Date(<?php echo $this->General->minDate($wardInDate) ?>),
	onSelect:function(){$(this).focus();}
});

$("#amount").keyup(function(){
 	total_amount=parseInt($('#totalamount').val()); 
 	total_advance=parseInt($('#totaladvancepaid').val()); 
 	amount_paid=parseInt($(this).val());
 	amount_paid=total_advance + amount_paid; 
	balance=total_amount - amount_paid;	 
	if(isNaN(balance)==false){
		$('#totalamountpending').val(balance);
	}else{
		$('#totalamountpending').val('');
		}
 });
</script>