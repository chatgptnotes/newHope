<style>
.billing_table {
	padding-left: 10px;
	margin-left: 10px;
	padding-top: 10px;
	margin-top: 10px;
	padding-right: 10px;
	margin-right: 10px;
	clear: both;
	background: lightgray;
}
body{
	height: 350px;
}
</style>

<?php 
if($isSuccess == 'yes'){?>
<script>
	parent.location.href  = "<?php echo $this->Html->url(array('controller'=>"Billings",'action'=>'multiplePaymentModeIpd',$patientID,'#'=>'serviceOptionDiv')); ?>"; 
	//parent.getbillreceipt('<?php //echo $patientID;?>');
	parent.jQuery.fancybox.close();
</script>
<?php } ?>

<?php 
 
echo $this->Form->create('billings',array('url'=>array('controller'=>'billings','action'=>'spotImplantPayment',$patientID),'id'=>'spotPaymentFrm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
)); 

echo $this->Form->hidden('Patient.patient_id',array('value'=>$patientID));?>
 
<div class="inner_title" style="width: 95%;margin-bottom: 2%">
	<h3>
		&nbsp;
		<?php echo __('Spot Implant Payment', true); ?>
	</h3>
</div>
<div><?php 
$consultantCount= count($consultantNameArr);
 echo "Select Referral Doctor :    ". $this->Form->input('Patient.consultant_id',array('options'=>$consultantNameArr, 'empty'=>'Please Select','id' => 'doctorlisting','label'=>false));
?></div>
<div style="margin-top: 2%"></div>
<table width="97%" cellspacing="0" cellpadding="0" border="0" class="spotPayment" bgcolor="LightGray" style="padding-left: 20px; padding-top: 20px" id="spotTable" >
	<?php //ethnicity_id is a flag used for cleared option for patient -- pooja
		if(!empty($patientData['Patient']['ethnicity_id'])){?>
			<tr><td style="font-weight:bold;font-size:14px;">All balance are cleared for this patient.</td></tr>
	<?php }else{?>
			<tbody>
		<tr>
			<td width="20%" height="35" class="tdLabel2"><?php echo __('Mode Of Payment' );?><font color="red">*</font></td>
			<td width="100"><?php echo $this->Form->input("Patient.account_id",array('class'=>'validate[required,custom[mandatory-select]]',
			'id'=>"cash_id",'type'=>'select','label'=>false,'options'=>array($cashList)));?></td>
			<td width="100"><?php  echo "";?></td>
		</tr>
		<tr>
			<td width="20%" height="35" class="tdLabel2"><?php echo __('S Amount' );?><font color="red">*</font> </td>
			<td width="100"><?php  echo $this->Form->input('Patient.spot_amount',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'spot_amount','class'=>'spot_amount validate[optional,custom[onlyNumber]]','value'=>$patientData['Patient']['spot_amount'])); ?></td>
			<td width="100">
			<?php  echo 'S Date<span align="left" id="mandatorySpotDate" style="display: none;"><font color="red">*</font></span>'.$this->Form->input('Patient.spot_date',array('type'=>'text','legend'=>false,'label'=>false,'readonly'=>'readonly','id'=>'spot_date','class'=>'spot_date textBoxExpnd',
					'value'=>$this->DateFormat->formatDate2Local($patientData['Patient']['spot_date'],Configure::read('date_format'),true))); 
			//echo $this->Form->input('Patient.prev_s_amt',array('id'=>'prev_s_amt','value'=>''));?></td>
		</tr>
		 <?php //if($patientData['Patient']['is_discharge']=='1'){?>
		<tr>
			<td width="20%" height="35" class="tdLabel2"><?php echo __('B Amount' );?><font color="red">*</font> </td>
			<td width="100"><?php  echo $this->Form->input('Patient.b_amount',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'b_amount','class'=>'b_amount validate[optional,custom[onlyNumber]]','value'=>$patientData['Patient']['b_amount'])); ?></td>
			<td width="100">
			<?php  echo 'B Date<span id="mandatoryBDate" style="display: none"><font color="red">*</font></span>'.$this->Form->input('Patient.b_date',array('type'=>'text','legend'=>false,'label'=>false,'readonly'=>'readonly','id'=>'b_date','class'=>'b_date textBoxExpnd',
					'value'=>$this->DateFormat->formatDate2Local($patientData['Patient']['b_date'],Configure::read('date_format'),true))); 
			//echo $this->Form->input('Patient.prev_b_amt',array('id'=>'prev_b_amt','value'=>''));?></td>
		</tr>
		<?php // }?>
		<tr>
			<td width="20%" height="35" class="tdLabel2"><?php echo $this->Form->submit('Save',array('id'=>'submit','class'=>'blueBtn submit','div'=>false,'label'=>false));?> </td>
			<td width="100"></td>
			<td width="100"></td>
		</tr>
	</tbody>			
	<?php }?>	
</table>
<?php echo $this->Form->end(); ?>


	<table class="table_format" width="97%" id="showDetails">
	<thead>
		<tr class="row_title">
			<td class="table_cell" align="center">Amount</td>
			<td class="table_cell" align="center">Date</td>
			<td class="table_cell" align="center">Type</td>
			<td class="table_cell" align="center">Print</td>
			<?php if($this->Session->read('role') == 'Admin' || $this->Session->read('userid')=='128'){ ?>
		     <td class="table_cell" align="center">Delete</td>
			<?php }?>
		</tr>
	</thead>
	<tbody></tbody>
	</table>	
	<?php /*?>
		<?php
     if(!empty($sBAmt)){?>
		<?php $sAdv=0;
		      $bAdv=0;
		foreach($sBAmt as $sAmt){
			$i++;$type='';
			if($toggle == 0) {
				echo "<tr class='rowOdd'>";
				$toggle = 1;
			}else{
				echo "<tr class=''>";
				$toggle = 0;
			}
			echo '<td align="center">'.$sAmt['VoucherPayment']['paid_amount'].'</td>';
			echo '<td align="center">'.$this->DateFormat->formatDate2Local($sAmt['VoucherPayment']['create_time'],Configure::read('date_format'),true).'</td>';
			if($sAmt['SpotApproval']['type']=='S' || strpos($sAmt['VoucherPayment']['narration'],'Spot') !== false){
				$sAdv=$sAdv+$sAmt['VoucherPayment']['paid_amount'];
				$type='S';
			}else if($sAmt['SpotApproval']['type']=='B' || strpos($sAmt['VoucherPayment']['narration'],'Backing') !== false){
				$bAdv=$bAdv+$sAmt['VoucherPayment']['paid_amount'];
				$type='B';
			}
			echo '<td align="center">'.$type.'</td>';
			
			echo '<td align="center">'.$this->Html->link($this->Html->image('icons/print.png'),'#',
					array('style'=>'','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printSpotPaymentVoucher',$sAmt['SpotApproval']['voucher_payment_id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200');  return false;"));
			echo '&nbsp;'.$this->Html->link($this->Html->image('icons/print.png',array('title'=>'ML Enterprise Invoice ')),'#',
					array('style'=>'','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printSpotPaymentVoucher',$sAmt['SpotApproval']['voucher_payment_id'],'?'=>array('mlPrint'=>'true')))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200');  return false;"));
			echo '</td>';
			if($this->Session->read('role') == 'Admin'){     
				echo '<td align="center">';     	
			 	echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'Billings','action'=>'spot_delete', $sAmt['SpotApproval']['voucher_payment_id'],$patientID), array('escape' => false),__('Are you sure?', true)); 
			 	echo '</td>';
			}		
			echo '</tr>';
			$totalPaid=$totalPaid+$sAmt['SpotApproval']['amount'];
			
		}?>

	
	
<?php  }?>
<?php */?>
<?php echo $this->Form->hidden('Patient.spot_adv',array('id'=>'s_adv','value'=>$sAdv));
	  echo $this->Form->hidden('Patient.b_adv',array('id'=>'b_adv','value'=>$bAdv));?>
<div width="50%" style="float:right" id="amountDiv">
	<b>Maximum S Payable : <font id="sLimit"  style="color: red">  <?php //echo $sAmount;?></font><br>
  	   Maximum B Payable : <font id="bLimit"  style="color: red">  <?php //echo !empty($profitBillData)?$profitBillData:'0';?></font><br>
       Paid Amount:       <font id="paidAmt" style="color: green"><?php //echo isset($totalPaid)?$totalPaid:'0';?></font><br>
       ----------------------------------------------------------<br>
       Balance Amount : <font id="balAmt" style="color: green"><?php //echo (($profitBillData+$sAmount)-$totalPaid);?></font></b>
 <?php if(empty($patientData['Patient']['ethnicity_id'])){?>
 <span class="clr" ><?php echo $this->Form->button('Cleared',array('id'=>'cleared','div'=>false,'label'=>false,'class'=>'blueBtn')); ?></span>
 <?php } ?>
 </div>
 
<script>
var balAmt='0';
$(document).ready(function(){
	//$('#cleared').hide();
	$("#amountDiv").hide();
	$("#spotTable").hide();
	$("#showDetails").hide();
	$('#spot_date').val('');
	$('#b_date').val('');
	$('#spot_amount').val('');
	$('#b_amount').val('');
	
	balAmt=$('#balAmt').text();
	if(isNaN(balAmt) || balAmt=='0'){
		$('#spot_date').attr('disabled',true);
		$('#b_date').attr('disabled',true);
		$('#spot_amount').attr('disabled',true);
		$('#b_amount').attr('disabled',true);
			
	}
	/*var sLimit=$('#sLimit').text();
	var bLimit=$('#bLimit').text();
	var sAdv=$('#s_adv').val();
	var bAdv=$('#b_adv').val();
	if(parseInt(sAdv)===parseInt(sLimit)){
		$('#spot_amount').attr('disabled',true);
		$('#spot_date').attr('disabled',true);
	}
	if(parseInt(bAdv)===parseInt(bLimit)){
		$('#b_amount').attr('disabled',true);
		$('#b_date').attr('disabled',true);
	}
*/
});
$('#submit').click(function(){
	var validatePerson = jQuery("#spotPaymentFrm").validationEngine('validate'); 
	if(!validatePerson){
	 	return false;
	}
});

//if(balAmt!='0' ){	
$( "#spot_date,#b_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'dd/mm/yy HH:II:SS',
	onSelect:function(){$(this).focus();}
});
//}

$('#spot_amount').focusout(function(){
	if($(this).val() !=''){
		var currentAmt=$(this).val();
		var advAmt=$('#s_adv').val();
		if(advAmt)
			var total=parseInt(currentAmt)+parseInt(advAmt);
		else
			var total=parseInt(currentAmt);
		sLimit=$('#sLimit').text();
		if(parseInt(sLimit)< parseInt(total)){
			if(!advAmt){
				alert('You cannot enter more than Rs.'+sLimit);
			}else{
				var remainAmt=(parseInt(sLimit)-parseInt(advAmt));
				if(remainAmt<0)
					remainAmt=0;
				alert('You Have already given Rs. '+parseInt(advAmt)+'. You cannot enter more than Rs.'+remainAmt);
			}
			$(this).val('');
			return false;
		}
		$('#mandatorySpotDate').show();
		$('#spot_date').addClass('validate[required,custom[mandatory-select]]'); 
	}else{
		$('#mandatorySpotDate').hide();
		$('#spot_date').removeClass('validate[required,custom[mandatory-select]]'); 
	}
});

$('#b_amount').focusout(function(){
	if($(this).val() !=''){
		var currentAmt=$(this).val();
		var advAmt=$('#b_adv').val();
		if(advAmt)
			var total=parseInt(currentAmt)+parseInt(advAmt);
		else
			var total=parseInt(currentAmt);
		bLimit=$('#bLimit').text();
		if(parseInt(bLimit)< parseInt(total)){
			if(!advAmt){
				alert('You cannot enter more than Rs.'+bLimit);
			}else{
				var remainAmt=(parseInt(bLimit)-parseInt(advAmt));
				if(remainAmt<0)
					remainAmt=0;
				alert('You Have already given Rs. '+parseInt(advAmt)+'. You cannot enter more than Rs.'+remainAmt);
				return false;
			}
		}
		$('#mandatoryBDate').show();
		$('#b_date').addClass('validate[required,custom[mandatory-select]]'); 
	}else{
		$('#mandatoryBDate').hide();
		$('#b_date').removeClass('validate[required,custom[mandatory-select]]'); 
	}
});

$('#doctorlisting').change(function(){
	var patientId='<?php echo $patientID;?>';
	var consultantId=$(this).val();
	if(consultantId !=''){
	$.ajax({
      url: "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "spotImplantPayment", "admin" => false)); ?>"+"/"+patientId+"/"+consultantId,
      type:'POST',
      context: document.body, 
	  beforeSend:function(){
			  $("#amountDiv").hide();
			  $("#spotTable").hide();
			  $("#showDetails").hide();
			  $('#busy-indicator').show('slow');
		  }, 	  		  
		  success: function(data){
			  var obj=$.parseJSON(data);
			  $("#showDetails").show();
			  $("#showDetails > tbody").html("");
			  totalPaidAmount=0;
			  sAdvanceAmt=0;
			  bAdvanceAmount=0;
			  $.each(obj.sBAmt, function(key, val) {

				  // for date conversion to local format
				  var date = val.VoucherPayment.create_time;
				  date = date.substr(0, 10).split("-");
				  date = date[2] + "-" + date[1] + "-" + date[0];
				
			      $("#showDetails").find('tbody')
				    .append($('<tr>')
					.append($('<td class="tdLabel ">').attr({'style':'text-align:center'}).text(val.VoucherPayment.paid_amount))
					.append($('<td class="tdLabel ">').attr({'style':'text-align:center'}).text(date))
					.append($('<td class="tdLabel ">').attr({'style':'text-align:center'}).text(val.SpotApproval.type))
					.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/icons/print.png")
    						       .attr({'style':'text-align:center;padding-left:30%','class':'printMlInterprise','id':'voucherId_'+val.SpotApproval.voucher_payment_id,'title':'ML Enterprise Invoice','onclick':"print("+val.SpotApproval.voucher_payment_id+")"}))
    						      .append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/icons/print.png")
    	    						.attr({'style':'text-align:center;padding-left:5%','class':'printMlInterprise','id':'voucherId_'+val.SpotApproval.voucher_payment_id,'title':'','onclick':"print("+val.SpotApproval.voucher_payment_id+",true)"})))
    						
					     <?php if($this->Session->read('role')=="Admin" || $this->Session->read('userid')=='128'){?>               
				     .append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/icons/delete-icon.png")
    				 .attr({'style':'text-align:center;padding-left:40%','class':'deleteRow','id':'delete_'+val.SpotApproval.voucher_payment_id+'_'+val.Patient.id,'title':'Remove current row'})))
					     <?php }?>
					)	 
						
				   totalPaidAmount+=parseInt(val.SpotApproval.amount);
				 
				});
			  $("#s_adv").val(obj.advanceAmntSb.Patient.spot_amount);
			  $("#b_adv").val(obj.advanceAmntSb.Patient.b_amount);
			  
			  var spotPaid=obj.advanceAmntSb.Patient.spot_amount;// total spot amount paid to consultant
			  var backingPaid=obj.advanceAmntSb.Patient.b_amount;// total backing amount paid to consultant
			  
			  if(obj.consultantCount>1){
		    	  $('#sLimit').html('5000');
		    	  $('#bLimit').html(obj.profitBillData);
			  }else{
				  $('#sLimit').html(obj.sAmount);
				  $('#bLimit').html(obj.profitBillData);
			  }
			  $("#paidAmt").html(totalPaidAmount);
			  var spotAmt= parseInt(($('#sLimit').text())?$('#sLimit').text():0);
			  var backingAmt= parseInt(($('#bLimit').text()!='')?$('#bLimit').text():0);
			  var paid_amount=  parseInt(($("#paidAmt").text())?$("#paidAmt").text():0);
			 // var balanceAmount= parseInt((spotAmt+backingAmt)-paid_amount);

				$("#balAmt").html((spotAmt+backingAmt)-(parseInt(spotPaid)+parseInt(backingPaid)));
				
				var sLimit=$('#sLimit').text();
				var bLimit=$('#bLimit').text();
				var sAdv=$('#s_adv').val();
				var bAdv=$('#b_adv').val();
			
				if(parseInt(sAdv)===parseInt(sLimit)){
					$('#spot_amount').attr('disabled',true);
					$('#spot_date').attr('disabled',true);
				}
				if(parseInt(bAdv)===parseInt(bLimit)){
					$('#b_amount').attr('disabled',true);
					$('#b_date').attr('disabled',true);
				}
       	  	  $('#busy-indicator').hide('slow');
       	      $("#submit").show();
       	      $("#amountDiv").show();
       	      $("#spotTable").show();
		  }         
    });
	}else{
		  $("#amountDiv").hide();
		  $("#spotTable").hide();
		  $("#showDetails").hide();
	}
});

$(document).on('click','.deleteRow',function(){
	var currentid=$(this).attr('id');
	splitedVoucherId=currentid.split("_")[1];
	splitedPatientId=currentid.split("_")[2];
	 if(confirm('Are you sure?')){
	 }else{
		 return false;
	 }
	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "spot_delete","admin" => false)); ?>";
	$.ajax({
		beforeSend : function() {
    		$('#busy-indicator').show('fast');
    	},
   	type: 'POST',
    url: ajaxUrl+'/'+splitedVoucherId+'/'+splitedPatientId,
  	dataType: 'html',
	  	success: function(data){
			$('#busy-indicator').hide('fast');
		
	 	},
	});
	});

function print(id,flag){ 
	status = '';
	if(flag!='' && flag != undefined){ 
		status = "?mlPrint=true";
	}
	var url="<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'printSpotPaymentVoucher')); ?>"+"/"+id+""+status;
    window.open(url, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200'); 
}

$('#cleared').click(function(e){
	e.preventDefault();
	$.ajax({
		type:'POST',
		data:'flag=1',
		url: "<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'markClear',$patientID));?>",
		beforeSend: function(){
			$('#busy-indicator').show('fast');
		},
		success: function(data){
			$('#busy-indicator').hide('fast');
			$('#spotTable').html('All Balance Is Cleared!');
	 	},
	});
});
</script>
