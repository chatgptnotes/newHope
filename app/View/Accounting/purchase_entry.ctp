<div class="inner_title">
	<h3>
		<?php echo __('Purchase Entry'); ?>
	</h3>		
</div> 
<?php 
	echo $this->Form->create('VoucherEntry',array('url'=>Array('controller'=>'Accounting','action'=>'purchase_entry'),'id'=>'JournalEntryForm',
															'inputDefaults'=>array('div'=>false,'label'=>false,'error'=>false)));
?>
<table align="right" width="100%" style="padding-top:10px">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
<table width="100%">
	<tr>
		<td style="float :left">
		<?php
			echo __('Purchase No. :'); echo $dataDetail['VoucherEntry']['id'];
			echo $this->Form->hidden('Entry.journal_voucher_no',array('type'=>'text','id'=>'journal_voucher_no','value'=>$jv_no));
		?>
		</td>
		
		<?php if(!empty($creditData)){?>
		<td style="float :right">
		<?php echo $this->Form->input('Entry.date', array('label'=>false,'type'=>'text','value'=>$this->DateFormat->formatDate2Local($creditData['VoucherEntry']['date'],Configure::read('date_format'),true),
				'id' => 'date' ,'class'=>'textBoxExpnd')); ?>
		</td>
		<?php }else{?>
		<td style="float :right">
		<?php $date = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
		echo $this->Form->input('Entry.date', array('label'=>false,'type'=>'text','value'=>$date,'id'=>'date',
				'readonly'=>'readonly','class'=>'textBoxExpnd')); ?>
		</td>
		<?php } ?>
	</tr>
	<tr>
		<td style="float :left"><?php echo __("Ref. :");?></td>
		<td style="float :left">
		<?php echo $this->Form->input('Entry.refference_no', array('autocomplete'=>'off','type'=>'text','label'=>false,'id'=>'ref_no')); ?>
		</td>
		<td style="float :right">
			<?php echo date('l', strtotime($date = date('Y-m-d')));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->hidden('Entry.debit_field',array('id'=>'debit_field','value'=>'1'));?>
<table class="tabularForm" id="account_form" cellpadding="0" cellspacing="1" width="100%" cols="3">
	<tbody>
		<tr>
			<th width="60%" valign="top" align="center" style="text-align: left; padding: 5px 0 0 50px;"><?php echo __("Particulars");?></th>
			<th width="20%" valign="top" align="center" style="text-align: center;"><?php echo __("Debit");?></th>
			<th width="20%" valign="top" align="center" style="text-align: center;"><?php echo __("Credit");?></th>
		</tr>
<!-- Credit fields -->
		<tr>
			<td colspan="3">	
				<table cellspacing="1" cellpadding="0" border="0" width="100%" class="tabularForm">	
					<tr>
						<td style="width:60%;"><?php echo __('Cr :')?><font color="red">* </font>
						<?php echo $this->Form->input('Entry.credit_account',array('id'=>'credit_account','placeholder'=>'Party to be credited',
							'class' => 'validate[required,custom[name]]','type'=>'text','autocomplete'=>'off',
							'value'=>$creditData['Account']['name']));
							echo $this->Form->hidden('Entry.user_id',array('id'=>'credit_account_id',
							'value'=>$creditData['VoucherEntry']['user_id']));?>
						</td>
						<td style="width:20%;">&nbsp;</td>
						<td style="width:20%; padding-left: 75px;">
						<?php echo $this->Form->input('Entry.credit_amount',array('placeholder'=>'Credit Amount','type'=>'text',
							'id'=>'credit_amount','class'=>'validate[optional,custom[onlyNumber]] inputBox','value'=>round($creditData['VoucherEntry']['credit_amount'])));?>
						</td>
					</tr>
					<tr>
						<td valign="top" style="text-align: left;"><?php echo __('Current Balance :')?>
						<?php if(empty($creditData['Account']['balance'])){?>
						<b><span id="by_current_balance" ></span>
						<?php }else{?>
						<b><span id="by_current_balance" ><?php echo $creditData['Account']['balance'];?></span></b>
						<?php }?>
						</td>
						<td rowspan="2" colspan="2"></td>
					</tr>
				</table>							
			</td>
		</tr>
<!-- Credit fields -->
		
<!-- Debit fields -->
		<tr id="cRow1">
			<td colspan="3">
				<table cellspacing="1" cellpadding="0" border="0" width="100%" class="tabularForm">
				<?php foreach ($dataDetail as $key=>$data){ //debug($key);?>
				<tr>
					<td style="width:60%;"><?php echo __('Dr :')?><font color="red">* </font>
					<?php 
					echo $this->Form->hidden("VoucherEntry.$key.id",array('value'=>$data['VoucherEntry']['id']));
					echo $this->Form->input("VoucherEntry.$key.debit_account",array('id'=>'debit_account','placeholder'=>'Party to be debited',
						'class' => 'validate[required,custom[name]] debit_account','type'=>'text','autocomplete'=>'off','value'=>$data['AccountAlias']['name']));
					echo $this->Form->hidden("VoucherEntry.$key.account_id",array('id'=>'debit_account_id-1','value'=>$data['VoucherEntry']['account_id']));
					?> 
					</td>
					<td style="width:20%; padding-left: 75px;">
					<?php if(!empty($data['VoucherEntry']['debit_amount'])){ 
								 echo $this->Form->input("VoucherEntry.$key.debit_amount",array('placeholder'=>'Debit Amount','type'=>'text',
									'id'=>'debit_amount','value'=>round($data['VoucherEntry']['debit_amount']),'class'=>'debit_amount inputBox')); 
							}else{
								 echo $this->Form->input("VoucherEntry.$key.debit_amount",array('placeholder'=>'Debit Amount','type'=>'text',
									'id'=>'debit_amount' ,'class'=>'debit_amount inputBox'));
							}?>
					</td>
					<td style="width:20%;"><?php echo __("");?></td>
				</tr>
				
				<tr>
					<td valign="top" style="text-align: left;"><?php echo __('Current Balance :')?>
					<?php if($data['AccountAlias']['balance'] < '0'){
								$amount = -($data['AccountAlias']['balance']);
							}else{
								$amount = $data['AccountAlias']['balance'];
							}?>
						<b><span id="to_current_balance-1" ><font color="red"><?php echo round($amount);?></font></span></b>
					</td>
					<td colspan="2" ><?php echo __("");?></td>
				</tr>
				<?php }?>
				</table>
			</td>
		</tr>
<!-- Debit fields -->
	</tbody>
</table>

<table width="100%" class="tabularForm" cellpadding="0" cellspacing="1" border="0">
		<tr>
			<td style="width:60%;">
				<table cellpadding="0" cellspacing="0" width="453px" align="left">
					<tr>
						<td><label><?php echo __("Narration");?></label></td>
						<td><?php echo $this->Form->input('Entry.narration', array('type'=>'textarea','id'=>'narration','class'=>'inputBox','value'=>$dataDetail[0]['VoucherEntry']['narration']));?></td>
					</tr>
				</table>
			</td>
			<td style="width:20%;" align="center" id="debit_total"><?php echo $this->Number->currency(round($creditData['VoucherEntry']['credit_amount']));?></td>
			<td style="width:20%;" align="center" id="credit_total"><?php echo $this->Number->currency(round($creditData['VoucherEntry']['credit_amount']));?></td>
		</tr>
		<tr>
			<td align="right">
				<?php echo $this->Form->submit('Save',array('class'=>'blueBtn','id'=>'save','div' => false))?>
			</td>
			<td colspan="2">
				<?php echo $this->Html->link(__('Cancel'), array('controller' => 'Accounting', 'action' => 'legder_voucher'),
						array('title'=>'Cancel','class'=>'blueBtn'));?>
			</td>
		</tr>
</table>
</td>
</tr>
</table>
<?php  echo $this->Form->end(); ?>
<script>
$(document).ready(function(){ 
	$("#date").datepicker({
		showOn : "both",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true,
		yearRange: '-100:' + new Date().getFullYear(),
		dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		onSelect : function() {
			$(this).focus();
		}
	});
	$('.debit_amount').keyup( function() {
		debitAmount=0;
        	$(".debit_amount").each(function( index ) {	
        		if(!isNaN($(this).val())){			 
        			debitAmount += parseFloat($(this).val()); 
        		}
 			});
			
        	var creditAmount = $("#credit_amount").val();
        	
			if(!isNaN(debitAmount) && !isNaN(creditAmount)){
				if(debitAmount==creditAmount){
					$("#save").show();
				}else{
					$("#save").hide();
				}
			}

			if(isNaN(creditAmount)){
				creditAmount='00';
			}
			if(isNaN(debitAmount)){
				debitAmount='00';
			}
			$('#credit_total').html('Rs '+creditAmount);
			$('#debit_total').html('Rs '+debitAmount);
		});
	$('#credit_amount').keyup( function() {
		debitAmount=0;
        	$(".debit_amount").each(function( index ) {	
        		if(!isNaN($(this).val())){			 
        			debitAmount += parseFloat($(this).val()); 
        		}
 			});
			
        	var creditAmount = $("#credit_amount").val();
        	
			if(!isNaN(debitAmount) && !isNaN(creditAmount)){
				if(debitAmount==creditAmount){
					$("#save").show();
				}else{
					$("#save").hide();
				}
			}

			if(isNaN(creditAmount)){
				creditAmount='00';
			}
			if(isNaN(debitAmount)){
				debitAmount='00';
			}
			$('#credit_total').html('Rs '+creditAmount);
			$('#debit_total').html('Rs '+debitAmount);
		});
	$("#credit_account").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'NotCashBank',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#credit_account_id').val(ui.item.id); 
	
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
				        	$("#by_current_balance").html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#by_current_balance").html(data.credit); 
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

	$(".debit_account").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'NotCashBank',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#debit_account_id-1').val(ui.item.id); 
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
				        	$("#to_current_balance-1").html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#to_current_balance-1").html(data.credit); 
				          }
			        	  $("#narration").html(data.narrationVoucherEntry);
					      $(".debit_amount").focus();
			        	  
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
});
function AddParticular(){
	var count = parseInt($("#debit_field").val())+1;
	var fields = '';
		fields += '<tr id="cRow'+count+'">';
		fields += 	'<td colspan="3">';
		fields += 		'<table cellspacing="1" cellpadding="0" border="0" width="100%" class="tabularForm">';
		fields += 			'<tr>';
		fields += 				'<td style="width:60%;"><?php echo __('Dr :')?><font color="red">*</font> <input type="text" name="data[VoucherEntry][debit_account]['+count+'][debit_account]" class="validate[required,custom[mandatory-enter]] debit_account" id="debit_account-'+count+'" autocomplete="false" placeholder="Party to be debited"/> <input type="hidden" name="data[VoucherEntry][debit_account_id]['+count+'][user_id]" id="debit_account_id-'+count+'" />';		
		fields +=				'<td style="width:20%; padding-left: 75px;"><input id="debit_amount-'+count+'" type="text" placeholder="debit Amount" class="debit_amount inputBoxAdd" name="data[VoucherEntry][debit_amount]['+count+'][debit_amount]"></td>';
		fields +=				'<td style="width: 20%;">&nbsp; </td>'; 
		fields += 			'</tr>';
	    fields += 			'<tr>';
		fields +=				'<td valign="top" style="text-align: left;"><?php echo __('Current Balance :')?><b><span id="to_current_balance-'+count+'" >0.00 Dr</span></td>';
		fields +=				'<td colspan="2" rowspan="2"><input type="hidden" value="0" class="blueBtn " id="no_of_field-'+count+'"/></td>';
		fields += 			'</tr>';
		fields += 		'</table>';
		fields += 	'</td>';
		fields += '</tr>';
		
		$("#debit_field").val(count);
		$("#account_form").append(fields);
		$('#debit_account-'+count).focus();
		
		$('#debit_account-'+count).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'NotCashBank',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				 $('#debit_account_id-'+count).val(ui.item.id); 
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
					        	$("#to_current_balance-1").html('<font color="red">'+data.credit+'</font>');
					          }else{
				        		$("#to_current_balance-1").html(data.credit); 
					          }
				        	  $("#narration").html(data.narrationVoucherEntry);
						      $("#debit_amount-"+count).focus();
				        	  
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
			var id = $(this).attr('id');
			var idName = id.split('-');
		    if(e.keyCode==13){//key enter
		    	if(idName[0] === "debit_amount"){
			    	var creditAmount = $("#credit_amount").val();
			    	debitAmount=0;
		        	$(".debit_amount").each(function( index ) {				 
		        		debitAmount += parseInt($(this).val()); 
		 			});
		 			if(creditAmount != debitAmount){
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
		var id = $(this).attr('id');
	    if(e.keyCode==13){//key enter
	    	if(id === "credit_amount"){
	    		$(".debit_account").focus();
	    		e.preventDefault();
	    	}else if(id === "debit_amount"){
		    	var creditAmount = $("#credit_amount").val();
		    	debitAmount=0;
	        	$(".debit_amount").each(function( index ) {				 
	        		debitAmount += parseInt($(this).val()); 
	 			});
	 			if(creditAmount != debitAmount){
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