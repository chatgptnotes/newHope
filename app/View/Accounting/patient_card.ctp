
<style>

/*----- Tabs -----*/
.tabs {
    width:100%;
    display:inline-block;
}
 
    /*----- Tab Links -----*/
    /* Clearfix */
    .tab-links:after {
        display:block;
        clear:both;
        content:'';
    }
 
    .tab-links li {
        margin:0px 3px;
        float:left;
        list-style:none;
    }
 
        .tab-links a {
            padding:9px 15px;
            display:inline-block;
            border-radius:6px 6px 0px 0px;
            background:#D2EBF2;
            font-size:16px;
            font-weight:600;
            color:#4c4c4c;
            transition:all linear 0.15s;
        }
 
        .tab-links a:hover {
            background:#a7cce5;
            text-decoration:none;
        }
 
    li.active a, li.active a:hover {
        background:#E5E3F1;
        color:#4c4c4c;
    }
    
    li.active a:hover{
    	background:#FFFFA6;
        color:#4c4c4c;
    }
 
    /*----- Content of Tabs -----*/
    .tab-content {
        padding:15px;
        border-radius:3px;
        box-shadow:-1px 1px 1px rgba(0,0,0,0.15);
        background:#fff;
    }
 
        .tab {
            display:none;
        }
 
        .tab.active {
            display:block;
        }
        
        .rowOdd{
       		 background-color: #E5E3F1;
        }
</style>
<?php 
 if(!empty($this->request->data)){
	$this->request->data='';
}?>
<div class="inner_title">
	<h3 style="float: left;">Patient Card </h3>
	<div class="clr"></div>
	<span><?php //echo $this->Html->link(__('Back To Billing'),array('controller'=>'Billings','action'=>'multiplePaymentModeIpd',$patient['0']['Patient']['id']),array('escape'=>false,'class'=>'blueBtn'));?></span>
		
</div>
<div class="clr ht5"></div>
<div style="width:90%;margin:0px 0px 0px 108px; min-height: 500px">
<div  style="float: left; width: 55%; border: 2px solid grey; padding: 10px;">
<table style="width: 100%; align:center" >
<tr>
<td><b><?php 
echo "Patient RegNo:"?></b></td>
<td><?php echo $patient['0']['Patient']['admission_id'];?></td>
<td></td>
<td><b><?php echo "Visit Type:"?></b></td>
<td><?php echo $patient['0']['Patient']['admission_type'];?></td>
</tr>
<tr>
<td><b><?php echo "Patient Name:"?></b></td>
<td><?php echo $patient['0']['Patient']['lookup_name'];?></td>
<td></td>
<td><b><?php echo "Gender:"?></b></td>
<td><?php echo $patient['0']['Person']['sex'];?></td>
</tr>
<tr>
<td><b><?php echo "Patient Type:"?></b></td>
<td><?php echo 'Cash';?></td>
<td></td>
<td><b><?php echo "Mobile No:"?></b></td>
<td><?php echo isset($patient['0']['Person']['mobile'])?$patient['0']['Person']['mobile']:$patient['0']['Patient']['mobile_phone'];?></td>
</tr>
<tr>
<td><b><?php echo "Patient CardNo:"?></b></td>
<td><?php echo $patient['0']['Account']['account_code'];?></td>
<td></td>
<td><b><?php echo "Email:"?></b></td>
<td><?php echo isset($patient['0']['Person']['email'])?$patient['0']['Person']['email']:$patient['0']['Patient']['email'];?></td>
</tr>
<tr>
<td><b><?php echo "Available Amount :"?></b></td>
<td><?php echo $patient['0']['Account']['card_balance'];?></td>
<td></td>
<td><b><?php echo "Address:"?></b></td>
<?php $address=isset($patient['0']['Person']['plot_no'])?$patient['0']['Person']['plot_no']:'';
$address .=isset($patient['0']['Person']['landmark'])?', '.$patient['0']['Person']['landmark']:'';
$address .=isset($patient['0']['Person']['city'])?', '.$patient['0']['Person']['city']:'';
$address .=isset($patient['0']['State']['name'])?', '.$patient['0']['State']['name']:'';
$address .=isset($patient['0']['Person']['pin_code'])?' - '.$patient['0']['Person']['pin_code']:'';?>
<td><?php echo $address;?></td>
</tr>
</table>
<div class="clr ht5"></div>
<?php echo $this->Form->create('Patient_card');?>
<?php 
 
echo $this->Form->hidden('person_id',array('id'=>'person_id','div'=>false,'label'=>false,'value'=>$patient['0']['Person']['id']));?>
<table id="patient_card" width="100%">

<tr>
<td style="text-align: left;"><b><?php echo "Transaction Mode"?></b></td>
<td>
<?php $options  = array('deposit'=>'<b>Deposit to card</b>','refund'=>'<b>Refund from card</b>');
		   echo $this->Form->input('type',array('type'=>'radio','options'=>$options,'div'=>false,'value'=>'deposit',
					'label'=>false,'legend'=>false,'class'=>'typeSelected','style'=>'margin-left:3%'));
	
?>
</td>
</tr>
</table>
<div class="clr ht5"></div>
    
<!--  Tabs For Payment -->
<div class="tabs" style="border: solid 1px black; width: 70%;">
	<ul class="tab-links">
		<li class="active"><a href="#tab1" id="cash">Cash</a></li>
		<li><a href="#tab2" id="credit">Credit</a></li>
		<li><a href="#tab3" id="cheque">Cheque</a></li>
	</ul>
	<!-- Tabs inner div -->
	<div class="tab-content">
		<div id="tab1" class="tab active">
		<?php echo '<b>Pay Amount :  </b>'.$this->Form->input('pay_amt',array('type'=>'text','div'=>false,'label'=>false,'id'=>'pay_amt','autocomplete'=>'off' ,'class'=>'validate[required,custom[onlyNumber]]'));
		echo '&nbsp; &nbsp; <br><b>Balance Amount :  </b>'.$patient['0']['Account']['card_balance'];?>
		</div>
		
		<div id="tab2" class="tab" >
		<?php echo '<div style="float:left; padding:0 0 0 40px"><b>Amount :  </b>'.$this->Form->input('pay.bank_amt',array('type'=>'text','div'=>false,'label'=>false,'id'=>'credit_amt','autocomplete'=>'off')).'</div><br><br>';
		echo '<div style="float:left; padding:0 0 0 55px"><b>Bank :  </b>'.$this->Form->input('pay.bank',array('options'=>$bankData,'div'=>false,'label'=>false,'id'=>'credit_bank','empty'=>'Please Select')).'</div>';
		echo '<br><br><div  style="float:left; padding:0 0 0 16px"><b>Account No :  </b>'.$this->Form->input('pay.bank_acct_no',array('type'=>'text','div'=>false,'label'=>false,'id'=>'credit_acct','autocomplete'=>'off')).'</div>';
		echo '<br><br><div  style="float:left;"><b>Credit Card No:  </b>'.$this->Form->input('pay.bank_card_no',array('type'=>'text','div'=>false,'label'=>false,'id'=>'card_no','autocomplete'=>'off')).'</div><br><br>';?>
		</div>
		
		<div id="tab3" class="tab ">
		<?php echo '<div style="float:left; padding:0 0 0 23px"><b>Amount :  </b>'.$this->Form->input('pay.cheque_amt',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cheque_amt')).'</div><br><br>';
		echo '<div style="float:left; padding:0 0 0 40px"><b>Bank :  </b>'.$this->Form->input('pay.cheque_bank',array('options'=>$bankData,'div'=>false,'label'=>false,'id'=>'cheque_bank','empty'=>'Please Select')).'</div>';
		echo '<br><br><div  style="float:left;"><b>Account No :  </b>'.$this->Form->input('pay.cheque_acct_no',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cheque_acct','autocomplete'=>'off')).'</div>';
		echo '<br><br><div  style="float:left; padding:0 0 0 6px"><b>Cheque No:  </b>'.$this->Form->input('pay.cheque_no',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cheque_no','autocomplete'=>'off')).'</div><br><br>';?>
		</div>
	</div>
	<!-- Tabs inner div -->
	
</div>
<!--  EOF Tabs For Payment -->
<div class="clr ht5"></div>
<?php 
if(strtolower($patient['0']['TariffStandard']['name'])!='private')
echo '<div style="padding: 0px 0px 10px;"> Corporate Advance '.$this->Form->input('corporate_adv',array('type'=>'checkbox','div'=>false,'label'=>false)).'</div>';
echo '<div style="float:left; padding: 0px 10px 10px 0px;">'.$this->Form->submit('Make Payment',array('id'=>'submit','class'=>'blueBtn','div'=>false)).'</div>';
echo '&nbsp; <div style="float:left; padding: 4px;">'.$this->Html->link(__('Clear'),'javascript:void(0);',array('class'=>'blueBtn','id'=>'clear')).'</div>';?>
</div>

<div style="width: 41%; float:right ;  max-height: 500px; overflow: scroll;" >
	<b>Transaction Details</b>
	<table width="100%" class="table_format" style="padding: 5px">
	<tr class="row_title">
		<td class="table_cell"><b>Transaction Date</b></td>
		<td class="table_cell"><b>Transaction Mode</b></td>
		<td class="table_cell"><b>Transaction Amount</b></td>
		<td class="table_cell"><b>Print Voucher</b></td>
	</tr>
	<?php $i=0;
	foreach($dataAcc as $key=>$trsData){
		foreach($trsData as $rowData){
			$i++;
			if($toggle == 0) {
				echo "<tr class='rowOdd'>";
				$toggle = 1;
			}else{
				echo "<tr class=''>";
				$toggle = 0;
			}
			echo '<td align="center">'.$this->DateFormat->formatDate2Local($rowData['create_time'],Configure::read('date_format'),true).'</td>';
			echo '<td align="center">'.ucfirst($rowData['type']).'</td>';
			echo '<td align="center">'.$rowData['amount'].'</td>';
			if(ucfirst($rowData['type'])=='Payment' || ucfirst($rowData['type'])=='Refund'){
				$action='printPaymentVoucher';
			}elseif(ucfirst($rowData['type'])=='Deposit'){
				$action='printReceiptVoucher';
			}
			echo '<td align="center">'.$this->Html->link($this->Html->image('icons/print.png'),'#',
					array('style'=>'','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'patient_card_print',$rowData['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200');  return false;")).'</td>';
			echo '</tr>';
		}
	}
	?>
	
	</table>
</div>
</div>
<?php 
echo $this->Form->end();?>


<script>
var selVal='';
jQuery(document).ready(function() {
    jQuery('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
 
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });

    selVal=$('.typeSelected').val();
    
});

$(document).ready(function(){
	jQuery("#Patient_cardPatientCardForm").validationEngine();
	$('#pay_amt').val('');
	$( '#cardHead', parent.document ).text('<?php echo $patient['0']['Account']['card_balance'];?>');

	var print="<?php echo isset($this->params->query['print'])?$this->params->query['print']:'' ?>";
	 
	if(print){
	         var url="<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'patient_card_print',$this->params->query['print'])); ?>";
	         window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200");	
	         }
	
});
$('#cash').click(function(){
	$('#pay_amt').addClass('validate[required,custom[onlyNumber]]');
	$('#cash_div').show();
	$('#credit_div').hide();
	$('#cheque_div').hide();
	$('#credit_bank').val('');
	$('#credit_amt').val('');
	$('#credit_acct').val('');
	$('#card_no').val('');
	$('#cheque_bank').val('');
	$('#cheque_acct').val('');
	$('#cheque_no').val('');
	$('#cheque_amt').val('');
	$('#credit_amt').removeClass('validate[required,custom[onlyNumber]]');
	$('#credit_bank').removeClass('validate[required,custom[mandatory-enter]]');	
	$('#credit_acct').removeClass('validate[required,custom[onlyNumber]]');
	$('#card_no').removeClass('validate[required,custom[onlyNumber]]');
	$('#cheque_bank').removeClass('validate[required,custom[mandatory-enter]]');	
	$('#cheque_acct').removeClass('validate[required,custom[onlyNumber]]');
	$('#cheque_no').removeClass('validate[required,custom[onlyNumber]]');
	$('#cheque_amt').removeClass('validate[required,custom[onlyNumber]]');
	
});

$('#credit').click(function(){
	$('#credit_div').show();
	$('#cash_div').hide();
	$('#cheque_div').hide();
	$('#pay_amt').val('');
	$('#cheque_bank').val('');
	$('#cheque_acct').val('');
	$('#cheque_amt').val('');
	$('#cheque_no').val('');
	$('#pay_amt').removeClass('validate[required,custom[onlyNumber]]');
	$('#cheque_bank').removeClass('validate[required,custom[mandatory-enter]]');	
	$('#cheque_acct').removeClass('validate[required,custom[onlyNumber]]');
	$('#cheque_no').removeClass('validate[required,custom[onlyNumber]]');
	$('#cheque_amt').removeClass('validate[required,custom[onlyNumber]]');
	$('#credit_amt').addClass('validate[required,custom[onlyNumber]]');
	$('#credit_bank').addClass('validate[required,custom[mandatory-enter]]');	
	$('#credit_acct').addClass('validate[required,custom[onlyNumber]]');
	$('#card_no').addClass('validate[required,custom[onlyNumber]]');
});

$('#cheque').click(function(){
	$('#credit_div').hide();
	$('#cash_div').hide();
	$('#cheque_div').show();
	$('#pay_amt').val('');
	$('#credit_bank').val('');
	$('#credit_amt').val('');
	$('#credit_acct').val('');
	$('#card_no').val('');
	$('#pay_amt').removeClass('validate[required,custom[onlyNumber]]');
	$('#credit_amt').removeClass('validate[required,custom[onlyNumber]]');
	$('#credit_bank').removeClass('validate[required,custom[mandatory-enter]]');	
	$('#credit_acct').removeClass('validate[required,custom[onlyNumber]]');
	$('#card_no').removeClass('validate[required,custom[onlyNumber]]');
	$('#cheque_bank').addClass('validate[required,custom[mandatory-enter]]');	
	$('#cheque_acct').addClass('validate[required,custom[onlyNumber]]');
	$('#cheque_no').addClass('validate[required,custom[onlyNumber]]');
	$('#cheque_amt').addClass('validate[required,custom[onlyNumber]]');
});



$('#clear').click(function(){
	$('#pay_amt').val('');
	$('#credit_bank').val('');
	$('#credit_amt').val('');
	$('#credit_acct').val('');
	$('#card_no').val('');
	$('#cheque_bank').val('');
	$('#cheque_acct').val('');
	$('#cheque_no').val('');
	$('#cheque_amt').val('');
	
});

$('.typeSelected').click(function(){
	selVal=$(this).val();
	$('#clear').trigger('click');
});

$('#pay_amt, #credit_amt, #cheque_amt').keyup(function(){
	if(selVal=='refund'){
		 var limitAmt='<?php echo $patient['0']['Account']['card_balance']; ?>';
		 var cashAmt=$('#pay_amt').val();
		 var creditAmt=$('#credit_amt').val();
		 var chequeAmt=$('#cheque_amt').val();
		 if(!isNaN(parseInt(cashAmt))){
			 if(parseInt(cashAmt)>parseInt(limitAmt)){
					alert('Refund amount is greater than card balance amount');
					$('#pay_amt').val('');
			 }	 
		 }else if(!isNaN(parseInt(creditAmt))){
			 if(parseInt(creditAmt)>parseInt(limitAmt)){
					alert('Refund amount is greater than card balance amount');
					$('#credit_amt').val('');
			 }
		 }else if(!isNaN(parseInt(chequeAmt))){
			 if(parseInt(chequeAmt)>parseInt(limitAmt)){
					alert('Refund amount is greater than card balance amount');
					$('#cheque_amt').val('');
			 }
		 }
	}
	
});


$("#submit").click(function(){
	var validatePerson = jQuery("#Patient_cardPatientCardForm").validationEngine('validate'); 
 	if(!validatePerson){
	 	return false;
	}else{
		$('#submit').hide();
	}
});

</script>