
<div class="inner_title">
	<h3>
		<?php echo __('Corporate Account Receipt'); ?>
	</h3>
</div>
<style>
.cost{
	text-align: right;
}
</style>
<?php
	echo $this->Form->create('accounting', array('url'=>array('controller'=>'Accounting','action'=>'corporateAccountReceipt'),'id'=>'CorporateReceipt',
	'inputDefaults' => array('label' => false,'div' => false,'error'=>false,'legend'=>false,'O'))) ;
?>
<table width="100%" cellpadding="1" cellspacing="1" border="0">
	<tr>
		<td width="100%" valign="top">
<table width="100%" cellpadding="1" cellspacing="1" border="0">
	<tr>
		<td width="30%">
			<?php echo $this->Form->hidden('AccountReceipt.id',array('type'=>'text','id'=>'id'));
			if ($dataDetail['AccountReceipt']['id']==null){
				$ar_no = $ar_no;
			}else{
				$ar_no = $dataDetail['AccountReceipt']['id'];
			}
			echo __('Receipt No. :'); echo $ar_no;
				echo $this->Form->hidden('AccountReceipt.account_receipt_no',array('type'=>'text','id'=>'account_receipt_no','value'=>$ar_no));
				echo $this->Form->hidden('VoucherLog.id',array('value'=>$dataDetail['VoucherLog']['id']));?>
		</td>
		<td width="30%">
			<?php echo __('Day :'); echo date('l', strtotime($date = date('Y-m-d')));?>
		</td>
		<td width="3%">
			<?php echo __('Date :');?>
		</td>
		<?php if(!empty($id)){?>
		<td width="10%">
			<?php echo $this->Form->input('AccountReceipt.date', array('label'=>false,'type'=>'text','value'=>$this->data['AccountReceipt']['date'],
					'id' => 'date' ,'class'=>'textBoxExpnd')); ?>
		</td>
		<?php }else{?>
		<td width="10%">
			<?php $date = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
			echo $this->Form->input('AccountReceipt.date', array('label'=>false,'type'=>'text','value'=>$date,'id' =>'date',
				'readonly'=>'readonly','class'=>'textBoxExpnd')); ?>
		</td>
	<?php } ?>
	</tr>
</table>
<?php echo $this->Form->hidden('Entry.debit_field',array('id'=>'debit_field','value'=>'1'));
?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="account_form">
	<tr>
		<th width="60%" align="center" valign="top" style="text-align: left; padding: 5px 0 0 50px;"><strong><?php echo __('Particulars')?></strong></th>
		<th width="20%" align="center" valign="top" style="text-align: center;"><strong><?php echo __('Debit');?></strong></th>
		<th width="20%" align="center" valign="top" style="text-align: center;"><strong><?php echo __('Credit');?></strong></th>
	</tr>
<!-- Debit fields -->
	<tr>
		<td colspan="3">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
				<tr>
					<td class="searchdiv" style="width:60%;"><?php echo __('Dr :')?><font color="red">*</font>
						<?php echo $this->Form->input('AccountReceipt.account_name', array('class'=>'validate[required,custom[mandatory-enter]]',
							'id'=>'account_name','placeholder'=>'Party to be debited','value'=>$this->data['AccountAlias']['name'],'readonly'=>'readonly')); ?>
						<?php echo $this->Form->hidden('AccountReceipt.account_id', array('type'=>'text','id'=>'account_id')); ?>
					</td>
					<td style="text-align: center; width:20%;">
						<?php echo $this->Form->input('AccountReceipt.paid_amount', array('class'=>'validate[required,custom[mandatory-enter]] inputBox cost',
								'id'=>'debit_amount','type'=>'text','placeholder'=>'Debit Amount','readonly'=>'readonly','autocomplete'=>'off','value'=>$this->data['AccountReceipt']['paid_amount'])); ?>
					</td>
					<td style="text-align: right; width:20%;">
						<?php echo " "; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" style="text-align: left; padding-left:60px;padding-top:5px; font-style:italic;"> 
					<?php echo __('Current Balance :');
					 if(!$this->data['AccountAlias']['balance']){?>
						<b><span id="account_current_balance"></span></b>
						<?php }else{?>
						<b><span id="account_current_balance"><?php echo $this->data['AccountAlias']['balance'];?></span></b>
					<?php }?>
					</td>
					<td rowspan="1" colspan="2"></td>
				</tr>
			</table>
		</td>
	</tr>
	<?php if(!empty($this->data['VoucherEntry']['debit_amount'])){?>
	<tr>
		<td colspan="3">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
				<tr>
					<td class="searchdiv" style="width:60%;"><?php echo __('Dr :')?><font color="red">*</font>
						<?php echo $this->Form->input('', array('name'=>"data[AccountAliasTwo][name]",'type'=>'text','class'=>'validate[required,custom[mandatory-enter]]',
							'id'=>'tdsname','placeholder'=>'Party to be debited','value'=>$this->data['AccountAliasTwo']['name'],'readonly'=>'readonly')); ?>
						<?php echo $this->Form->hidden('', array('name'=>"data[VoucherEntry][account_id]",'type'=>'text','id'=>'tds_account_id')); ?>
					</td>
					<td style="text-align: center; width:20%;">
						<?php echo $this->Form->input('', array('name'=>"data[VoucherEntry][debit_amount]" ,'class'=>'cost',
								'id'=>'tds_amount','type'=>'text','placeholder'=>'Debit Amount','readonly'=>'readonly','autocomplete'=>'off','value'=>$this->data['VoucherEntry']['debit_amount'])); ?>
					</td>
					<td style="text-align: right; width:20%;">
						<?php echo " "; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" style="text-align: left; padding-left:60px;padding-top:5px; font-style:italic;"> 
					<?php echo __('Current Balance :');
					 if(!$this->data['AccountAliasTwo']['balance']){?>
						<b><span id="account_current_balance_tds"></span></b>
						<?php }else{?>
						<b><span id="account_current_balance_tds"><?php echo $this->data['AccountAliasTwo']['balance'];?></span></b>
					<?php }?>
					</td>
					<td rowspan="1" colspan="2"></td>
				</tr>
			</table>
		</td>
	</tr>
	<?php }?>
<!-- Debit fields -->
<!-- Credit fields -->
	<tr id="cRow1">
		<td colspan="3">
			<table width="100%" cellspacing="1" cellpadding="0" border="0" class="tabularForm">
				<tr>
					<td style="width:60%;"><?php echo __('Cr :')?><font color="red">*</font>
						<?php  echo $this->Form->input('', array('name'=>"data[Corporate][1][username]",'type'=>'text','class'=>'validate[required,custom[mandatory-enter]]','id' => 'username',
							'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'placeholder'=>'Party to be credited','value'=>$this->data['Account']['name'])); 
							echo $this->Form->hidden('', array('name'=>"data[Corporate][1][user_id]",'id' =>'credit_user_id-1'));
						?>
					</td>
					<td style="text-align: right; width:20%;">
						<?php echo " "; ?>
					</td>
					<td style="text-align: center; width:20%;">
						<?php  
						$tdsAddAmount = $this->data['AccountReceipt']['paid_amount']+$this->data['VoucherEntry']['debit_amount'];
						echo $this->Form->input('', array('name'=>"data[Corporate][1][credit_amount]",'type'=>'text','class' => 'validate[required,custom[mandatory-enter]] inputBox credit_amount cost',
								'id' =>'credit_amount','type'=>'text','placeholder'=>'Credit Amount','value'=>$tdsAddAmount,'autocomplete' =>'off')); ?>
					</td>
				</tr>
				<tr>
					<td valign="top" style="text-align: left; padding-left:60px;padding-top:5px; font-style:italic;"> 
						<?php echo __('Current Balance :')?>
						<?php if(!$this->data['Account']['balance']){?>
							<b><span id="user_current_balance-1"></span></b>
						<?php }else{?>
							<b><span id="user_current_balance-1"><?php echo $this->data['Account']['balance'];?></span></b>
						<?php }?>
					</td>
					<td rowspan="1" colspan="2"></td>
				</tr>
			</table>
		</td>
	</tr>
<!-- Credit fields -->
</table>

<table width="100%" class="tabularForm" cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td valign="middle"  style="width:60%;"><?php echo __('Narration :')?> 
		 <?php echo $this->Form->input('AccountReceipt.narration', array('class'=>'inputBox','id'=>'narration','type'=>'textarea'));?>
		</td>
		<td style="width:20%; padding-left: 40px;" id="debit_total"><?php echo __("Debit Total:");?><?php echo $tdsAddAmount;?></td>
		<td style="width:20%; padding-left: 40px;" id="credit_total"><?php echo __("Credit Total:");?><?php echo $tdsAddAmount;?></td>
	</tr>
	<tr>
		<td colspan="3" align="center" style="padding: 20px 0 20px 0">
		<?php echo $this->Form->submit('Save',array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;','id'=>'save','div' => false,'name'=>'print')) ; ?>
		<?php echo $this->Html->link(__('Cancel'), array('controller' => 'Accounting', 'action' => 'account_receipt'), array('title'=>'Cancel','class'=>'blueBtn'));?>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
<?php  echo $this->Form->end(); ?>
<script>

$(document).ready(function(){
	
	$("#save").click(function(){
		var validateForm = jQuery("#CorporateReceipt").validationEngine('validate');
		if(validateForm == true){
			window.parent.childSubmitted = true;
	        parent.$.fancybox.close();
			$("#save").hide();
		}else{
			return false;
		}
	});
		
	$("#account_name" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'CashBankOnly',"admin" => false,"plugin"=>false)); ?>" ,
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#account_id').val(ui.item.id);
			 var id = ui.item.id;
				var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "accounting", "action" => "get_account_current_balance","admin" => false)); ?>";
				$.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+id,
			          data: '',
			          dataType: 'html',
			          success: function(data){
			        	  if(data != ''){
			        	  	data = jQuery.parseJSON(data);
					          if(data.acountType == 'Cr'){ 
					        	$("#account_current_balance").html('<font color="red">'+data.credit+'</font>');
					          }else{
				        		$("#account_current_balance").html(data.credit); 
					          } 
			        	  }
			        	  $("#paid_amount").focus();   
			        },
						error: function(message){
			              alert("Internal Error Occured. Unable to set data.");
			          }        });
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
});	
			
	// for users..
	$(document).ready(function(){
			$( "#username" ).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'NotCashBank',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				$('#credit_user_id-1').val(ui.item.id);
				var id = ui.item.id;
				var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Accounting", "action" => "get_account_current_balance","admin" => false)); ?>";
				$.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+id,
			          data: '',
			          dataType: 'html',
			          success: function(data){
			        	  data = jQuery.parseJSON(data);
				        
			        	  if(data.acountType == 'Cr'){
				        	$("#user_current_balance-1").html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#user_current_balance-1").html(data.credit); 
				          }
				          $("#credit_amount").focus();
			        	},
						error: function(message){
			              alert("Internal Error Occured. Unable to set data.");
			          }
			      });
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
			//BOF cross cheeck	
			$("#account_name").focus().attr('placeHolder','Party to be debited');
			$("#username").attr('placeHolder','Party to be credited');
	});
	
	
$("#date").datepicker({
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
	}
});


$(document).on('keyup','.credit_amount',function() {
	creditAmount=0;
	$(".credit_amount").each(function( index ) {
		if(!isNaN($(this).val())){
			creditAmount += parseInt($(this).val()); 
		}
	});
	var tdsAmount = $("#tds_amount").val();
	var debitAmount = $("#debit_amount").val();
	var totalAmountDebit = parseInt(tdsAmount)+parseInt(debitAmount);
	if(creditAmount != totalAmountDebit){
		$("#save").hide();
	}else{
		$("#save").show();
	}
	$('#credit_total').html('Credit Total :'+creditAmount);
});

function AddParticular(){
	var count = parseInt($("#debit_field").val())+1;
	var fields = '';
		fields += '<tr id="cRow'+count+'">';
		fields += 	'<td colspan="3">';
		fields += 		'<table cellspacing="1" cellpadding="0" border="0" width="100%" class="tabularForm">';
		fields += 			'<tr>';
		fields += 				'<td style="width:60%;"><?php echo __('Cr :')?><font color="red">*</font> <input type="text" name="data[Corporate]['+count+'][username]" class="validate[required,custom[mandatory-enter]] credit_account" id="username-'+count+'" autocomplete="false" placeholder="Party to be credited"/> <input type="hidden" name="data[Corporate]['+count+'][user_id]" id="credit_user_id-'+count+'" />';		
		fields +=				'<td style="width: 20%;">&nbsp; </td>'; 
		fields +=				'<td style="width:20%; text-align: center;"><input id="credit_amount-'+count+'" type="text" placeholder="Credit Amount" class="validate[required,custom[mandatory-enter]] credit_amount inputBoxAdd cost" name="data[Corporate]['+count+'][credit_amount]" autocomplete = "off"></td>';
		fields += 			'</tr>';
	    fields += 			'<tr>';
		fields +=				'<td valign="top" style="text-align: left; padding-left:60px;padding-top:5px; font-style:italic;"><?php echo __('Current Balance :')?><b><span id="user_current_balance-'+count+'" >0.00 Dr</span></td>';
		fields +=				'<td colspan="2" rowspan="2"><input type="hidden" value="0" class="blueBtn " id="no_of_field-'+count+'"/></td>';
		fields += 			'</tr>';
		fields += 		'</table>';
		fields += 	'</td>';
		fields += '</tr>';
		
		$("#debit_field").val(count);
		$("#account_form").append(fields);
		$('#username-'+count).focus();
		
		$('#username-'+count).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'NotCashBank',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				 $('#credit_user_id-'+count).val(ui.item.id); 
				 var id = ui.item.id;
					var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Accounting", "action" => "get_account_current_balance","admin" => false)); ?>";
					$.ajax({
				          type: 'POST',
				          url: ajaxUrl+"/"+id,
				          data: '',
				          dataType: 'html',
				          success: function(data){
				        	  data = jQuery.parseJSON(data);
				        	  if(data.acountType == 'Cr'){ 
					        	$("#user_current_balance-"+count).html('<font color="red">'+data.credit+'</font>');
					          }else{
				        		$("#user_current_balance-"+count).html(data.credit); 
					          }
						      $("#credit_amount-"+count).focus();
				        	  
				        },
							error: function(message){
				              alert("Internal Error Occured. Unable to set data.");
				          }});
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
		$('.inputBoxAdd').keypress('',function(e) {
			creditAmount = 0;
			var id = $(this).attr('id');
			var idName = id.split('-');
		    if(e.keyCode==13){//key enter
		    	if(idName[0] === "credit_amount"){
			    	var debitAmount = $("#debit_amount").val();
			    	var tdsAmount = $("#tds_amount").val();
			    	var totalAmount = parseInt(debitAmount)+parseInt(tdsAmount);
		        	$(".credit_amount").each(function( index ) {				 
		        		creditAmount += parseInt($(this).val()); 
		 			});
		 			if(totalAmount != creditAmount){
		    			AddParticular();
		 			}else{
			 			$("#narration").focus();
		 			}
		    	    e.preventDefault();
		    	} 
		    }
		});	
	}
$(document).ready(function(){
	$('.inputBox').keypress('',function(e) {
		creditAmount = 0;
		var id = $(this).attr('id');
	    if(e.keyCode==13){//key enter
	    	 if(id === "credit_amount"){
		    	var debitAmount = $("#debit_amount").val();
		    	var tdsAmount = $("#tds_amount").val();
		    	var totalAmount = parseInt(debitAmount)+parseInt(tdsAmount);
	        	$(".credit_amount").each(function( index ) {				 
	        		creditAmount += parseInt($(this).val()); 
	 			});
	 			if(totalAmount != creditAmount){
	    			AddParticular();
	 			}
	    	    e.preventDefault();
	    	}else if(id === "narration"){
		    	$("#save").focus();
	    	}
	    }
	});
});
</script>