<?php 	if($action=='print' && !empty($lastInsertID)){
  		echo "<script>var openWin = window.open('".$this->Html->url(array("controller" => "Accounting",'action'=>'printPaymentVoucher',$lastInsertID))."', '_blank',
                       'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
                  window.location='".$this->Html->url(array('action'=>'hrPayment'))."'  </script>"  ;
  	}
 ?>
<style>
.cost{
	text-align: right;
}
.textBoxExpnd{
	width: 25% !important;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('HR Payment'); ?>
	</h3>
</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
	<tr>
		<td colspan="2" align="left">
			<div class="alert">
				<?php 
				foreach($errors as $errorsval){
			         echo $errorsval[0];
			         echo "<br />";
			     }
			     ?>
			</div>
		</td>
	</tr>
</table>
<?php }  
	echo $this->Form->create('accounting', array('id'=>'Complaintfrm','inputDefaults' => array('label' => false,'div' => false,'error'=>false,'legend'=>false,'O'))) ;
?>
<table  align="center" width="65%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="table" style="margin-top: 2%">
	<tbody>
	<tr>
		<th colspan="4"><strong><?php echo __('HR Payment Details');?></strong></th>
	</tr>
    <tr>
		<td width="20%" ><?php echo __('Pay To Mr/Dr :')?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('VoucherPayment.pay_user_name',array('class'=>' textBoxExpnd  validate[required,custom[mandatory-enter]]',
				'id' => 'payUserName','placeholder'=>'Select Ledger Name','value'=>'')); 
			echo $this->Form->hidden('VoucherPayment.pay_user_id',array('id'=>'payUserId'));
		?></td>
	</tr>
	<tr>
		<td ><?php echo __('Against Mr/Dr :')?><font color="red">*</font></td>
		<td><?php echo $this->Form->input('VoucherPayment.debit_user_name',array('class'=>'textBoxExpnd  validate[required,custom[mandatory-enter]]',
				'id' => 'debitUserName','placeholder'=>'Select Ledger Name','value'=>'')); 
			 echo $this->Form->hidden('VoucherPayment.debit_user_id',array('id'=>'debitUserId'));
			 echo $this->Form->hidden('VoucherPayment.debit_amount',array('id'=>'debitAmount'));
			 ?></td>
	</tr>
	<tr>
		<td>
			<?php echo __("Amount."); ?><font color="red">*</font>
		</td>
		<td >
			<?php echo $this->Form->input('VoucherPayment.paid_amount',array('class'=>' validate[required,custom[onlyNumber]] inputBox cost',
			'id' =>'paid_amt','type'=>'text','autocomplete'=>'off')); ?>
			
			<span id="debitAgainst" colspan="2">
		</span>
		</td>
	</tr>
	<tr>
		<td ><?php echo __('Cr/To :')?><font color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('VoucherPayment.account_name',array('class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]','id' => 'accountName','placeholder'=>'Select Account Name','value'=>'')); 
				  echo $this->Form->hidden('VoucherPayment.account_id',array('id'=>'accId'));
			?>
		</td>
	</tr>
	<tr>
		<td >
			<?php echo __("Date:"); ?>
		</td>
	     <td>
			<?php echo $this->Form->input('VoucherPayment.date', array('label'=>false,'type'=>'text','value'=>date('d/m/Y H:i:s'),
				'id' => 'date' ,'class'=>'textBoxExpnd','readonly'=>true)); ?>
		</td>
	</tr>
	<tr>
		<td><?php echo __('Narration :');?> </td>
		<td valign="top"  >
		 <?php echo $this->Form->input('VoucherPayment.narration', array('class' => 'inputBox','id' => 'narration','type'=>'textarea','rows'=>'3','cols'=>'6'));?>
		</td>
	</tr>
</tbody>
</table>
<table align="center" width="65%">
<tr>
		<td colspan="2" align="right" style="padding: 20px 0 20px 0">
		<?php echo $this->Form->submit('Save',array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;','id'=>'save','div' => false)) ; ?>
		<a class="blueBtn" href="javascript:history.back();">Cancel</a>
		</td>
	</tr>
</table>
<?php  echo $this->Form->end(); ?>
<script>
// for account
$(document).ready(function(){
	
$("#save").click(function(){
	var validateForm = jQuery("#Complaintfrm").validationEngine('validate');

	if(validateForm == true){
		
	}else{
		return false;
	}

});

$("#payUserName").autocomplete({
	 source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'Patient',"admin" => false,"plugin"=>false)); ?>",
	 minLength: 1,
	 placeHolder:false,
	 select: function( event, ui ) {
		$('#payUserId').val(ui.item.id);
	 },
	 messages: {
	        noResults: '',
	        results: function() {},
	 }
});

$("#debitUserName").autocomplete({
	 source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'Patient',"admin" => false,"plugin"=>false)); ?>",
	 minLength: 1,
	 placeHolder:false,
	 select: function( event, ui ) {
		$('#debitUserId').val(ui.item.id);
	 },
	 messages: {
	        noResults: '',
	        results: function() {},
	 }
});

$("#accountName").autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'CashBankOnly',"admin" => false,"plugin"=>false)); ?>" ,
	 minLength: 1,
	 placeHolder:false,
	 select: function( event, ui ) {
		$('#accId').val(ui.item.id);
	 },
	 messages: {
	        noResults: '',
	        results: function() {},
	 }
});

$("#date").datepicker(
		{
			showOn : "both",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}
		});
		
});	
	
$('#paid_amt').keyup( function() {
	if (/[^0-9\.]/g.test(this.value)){
     	this.value = this.value.replace(/[^0-9\.]/g,'');
    } 
	var amount=$('#paid_amt').val();
	var payUsrName=$("#payUserName").val();
	var debitUsrName=$("#debitUserName").val();
	$('#narration').html('Credit Rs.'+amount+' '+'to '+payUsrName +' against of '+debitUsrName);
	$('#debitAmount').val(amount);
});

</script>
