<div class="inner_title">
	<h3>
		<?php echo __('Contra Entry'); ?>
	</h3>		
</div> 
<style>
.cost{
	text-align: right;
}
</style>
<?php 
	echo $this->Form->create('ContraEntry',array('url'=>Array('controller'=>'Accounting','action'=>'contra_entry'),'id'=>'ContraEntryForm',
															'inputDefaults'=>array('div'=>false,'label'=>false,'error'=>false)));
	echo $this->Form->hidden('ContraEntry.id',array('type'=>'text'));
?>
<table align="right"  width="100%" style="padding-top:10px">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
<table width="100%">
	<tr>
		<td>
		<?php if ($dataDetail['ContraEntry']['id']==null){
			echo __('Contra Voucher No. :'); echo $cv_no;
		}else{
			echo __('Contra Voucher No. :'); echo $dataDetail['ContraEntry']['id'];
		}
			echo $this->Form->hidden('ContraEntry.contra_voucher_no',array('type'=>'text','id'=>'contra_voucher_no','value'=>$cv_no));
			echo $this->Form->hidden('VoucherLog.id',array('value'=>$dataDetail['VoucherLog']['id']));?>
		</td>
		
		<?php if(!empty($id)){?>
			<td style="float: right;">
				<?php echo $this->Form->input('ContraEntry.date', array('label'=>false,'type'=>'text','value'=>$this->data['ContraEntry']['date'],
					'id' => 'date' ,'class'=>'textBoxExpnd')); ?>
			</td>
		<?php }else{?>
			<td style="float: right;">
				<?php $date = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
				echo $this->Form->input('ContraEntry.date', array('label'=>false,'type'=>'text','value'=>$date,'id' => 'date',
						'readonly'=>'readonly','class'=>'textBoxExpnd')); ?>
			</td>
		<?php } ?>
			<td style="float: right;"><?php echo __('Date:')?></td>
	</tr>
</table>
<table class="tabularForm" id="account_form" cellpadding="0" cellspacing="1" width="100%" cols="3">
	<tbody>
		<tr>
			<th width="60%" valign="top" align="center" style="text-align: left; padding: 5px 0 0 50px;"><strong><?php echo __("Particulars");?></strong></th>
			<th width="20%" valign="top" align="center" style="text-align: center;"><strong><?php echo __("Debit");?></strong></th>
			<th width="20%" valign="top" align="center" style="text-align: center;"><strong><?php echo __("Credit");?></strong></th>
		</tr>
		<tr>
			<td><?php echo __('Dr :');?><font color="red">* </font>
			<?php echo $this->Form->input('debit_by',array('id'=>'by','placeholder'=>'Party to be debited',
					'class'=>'validate[required,custom[name]] ','type'=>'text','autocomplete'=>'off','value'=>$this->data['AccountAlias']['name']));
				echo $this->Form->hidden('account_id',array('id'=>'debit_account'));?>
			</td>
			<td>
				<?php echo $this->Form->input('debit_amount',array('placeholder'=>'Debit Amount','type'=>'text','id'=>'debit',
					'class'=>'validate[required,custom[mandatory-enter]] inputBox cost','autocomplete'=>'off'));
				echo $this->Form->hidden('previous_paid_amount', array('type'=>'text','id'=>'previousPaidAmount',
					'value'=>$this->data['ContraEntry']['debit_amount']));?>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" style="text-align: left; padding-left:60px;padding-top:5px; font-style:italic;">
			<?php echo __('Current Balance :');
			if(!$this->data['AccountAlias']['balance']){?>
			<b><span id="by_current_balance"></span></b>
			<?php }else{?>
			<b><span id="by_current_balance"><?php echo $this->data['AccountAlias']['balance'];?></span></b>
			<?php }?>
			</td>
			<td rowspan="1" colspan="2"></td>
		</tr>
		<tr>
			<td><?php echo __('To :')?><font color="red">* </font>
			<?php 
			echo $this->Form->input('credit_to',array('id'=>'to','placeholder'=>'Party to be credited','class' => 'validate[required,custom[name]]',
										'type'=>'text','autocomplete'=>'off','value'=>$this->data['Account']['name']));
			echo $this->Form->hidden('user_id',array('id'=>'credit_account'));
			?> 
			<?php 
			if(empty($this->data['VoucherReference'][0]['id'])){
				$style = "display: none;";
			}else{
				$style = "display: block;";
			}?>
			<input type="button" value="Add Row" class="blueBtn" id="add-new-row" style="<?php echo $style?>"/>
			<?php 
				if(empty($this->data['VoucherReference'][0]['id'])){
					$style = "display: none;";
				}else{
					$style = "display: block;";
				}?>
			<table cellpadding="0" cellspacing="0" width="100%" border="0" id="ref-area" style="<?php echo $style?>">
				<?php
					$cnt=0;
					if(count($this->data['VoucherReference']) > 0){
					foreach($this->data['VoucherReference'] as $value){		  
			   ?>
				<tr>
					<td>
					<?php echo $this->Form->input("VoucherReference.$cnt.reference_type_id",array('id'=>"reference_.$cnt.",'type'=>'select',
							'class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('2'=>'New Reference','3'=>'Against Reference'),
							'empty'=>'Please Select'));?>
					<?php echo $this->Form->hidden("VoucherReference.$cnt.voucher_reference_id",array('id'=>"voucher_reference_id_.$cnt.",'type'=>'text',
							'placeHolder'=>''));?>
					<?php echo $this->Form->hidden("VoucherReference.$cnt.id",array('id'=>"id_.$cnt",'type'=>'text'));?>
					</td>
					<td><?php echo $this->Form->input("VoucherReference.$cnt.reference_no",array('id'=>"reference_no_.$cnt.",'type'=>'input',
							'class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','placeHolder'=>'Refrence No.','autocomplete'=>'off'));?>
					</td>
					<td><?php echo $this->Form->input("VoucherReference.$cnt.credit_period",array('id'=>"credit_period_.$cnt.",'type'=>'input',
							'class'=>'validate[required,custom[onlyNumber]]','type'=>'text','placeHolder'=>'Credit Period','autocomplete'=>'off'));?>
					</td>
					<td><?php echo $this->Form->input("VoucherReference.$cnt.amount",array('id'=>"reference_amount_.$cnt.",'type'=>'input',
							'class'=>'validate[required,custom[onlyNumber]] ref_amt','type'=>'text','placeHolder'=>'Amount','autocomplete'=>'off'));?>
					</td>
					<td><?php echo $this->Form->input("VoucherReference.$cnt.payment_type",array('id'=>"payment_type_.$cnt.",'type'=>'select',
							'class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('Dr'=>'Dr','Cr'=>"Cr")));?>
					</td>
				</tr>
				<?php $cnt++; }
				}else{?>
				<tr>
					<td>
						<?php echo $this->Form->input("VoucherReference.$cnt.reference_type_id",array('id'=>"reference_$cnt",'type'=>'select',
							'class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('2'=>'New Reference','3'=>'Against Reference'),
							'empty'=>'Please Select'));?>
						<?php echo $this->Form->hidden("VoucherReference.$cnt.voucher_reference_id",array('id'=>"voucher_reference_id_$cnt",'type'=>'text',
							'placeHolder'=>''));?>
						<?php echo $this->Form->hidden("VoucherReference.$cnt.id",array('id'=>"id_'$cnt'",'type'=>'text'));?>
					</td>
					<td>
						<?php echo  $this->Form->input("VoucherReference.$cnt.reference_no",array('id'=>"reference_no_$cnt",'type'=>'input',
							'class' =>'validate[required,custom[mandatory-enter]]','type'=>'text','placeHolder'=>'Refrence No.','autocomplete'=>'off')); ?>
					</td>
					<td>
						<?php echo  $this->Form->input("VoucherReference.$cnt.credit_period",array('id'=>"credit_period_$cnt",'type'=>'input',
							'class' =>'validate[required,custom[onlyNumber]] ','type'=>'text','placeHolder'=>'Credit Period','autocomplete'=>'off')); ?>
					</td>
					<td>
						<?php echo  $this->Form->input("VoucherReference.$cnt.amount",array('id'=>"reference_amount_$cnt",'type'=>'input',
							'class' =>'validate[required,custom[onlyNumber]] ref_amt','type'=>'text','placeHolder'=>'Amount','autocomplete'=>'off')); ?>
					</td>
					<td>
						<?php echo $this->Form->input("VoucherReference.$cnt.payment_type",array('id'=>"payment_type_$cnt",'type'=>'select',
								'class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('Dr'=>'Dr','Cr'=>"Cr")));?>
					</td>
				</tr>
				<?php }?>
			</table>
			</td>
			<td>&nbsp;</td>
			<td>
				<?php echo $this->Form->input('credit_amount',array('placeholder'=>'Credit Amount','type'=>'text','id'=>'credit',
						'readonly'=>'readonly','class'=>'validate[required,custom[mandatory-enter]] inputBox cost','value'=>$this->data['ContraEntry']['debit_amount']));
				?>
			</td>
		</tr>
		<tr>
			<td valign="top" style="text-align: left; padding-left:60px;padding-top:5px; font-style:italic;">
				<?php echo __('Current Balance :');
				if(!$this->data['Account']['balance']){?>
				<b><span id="to_current_balance" ></span></b>
				<?php }else{?>
				<b><span id="to_current_balance" ><?php echo $this->data['Account']['balance'];?></span></b>
				<?php }?>
			</td>
			<td rowspan="1" colspan="2"></td>
		</tr>
		<tr>
			<td colspan="1">
				<table cellpadding="0" cellspacing="0" width="453px" align="left">
					<tr>
						<td><label><?php echo __("Narration");?></label></td>
						<td><?php echo $this->Form->input('narration', array('type' => 'textarea','class'=>'inputBox','id'=>'narration'));?></td>
					</tr>
				</table>
			</td>
			<td id="debit_total"><?php echo __("Debit Total:"); echo $this->data['JournalEntry']['debit'];?></td>
			<td id="credit_total"><?php echo __("Credit Total:"); echo $this->data['JournalEntry']['credit'];?></td>
		</tr>
		<tr>
			<td colspan="3" align="center" style="padding: 20px 0 20px 0"><?php echo $this->Form->submit('Save',array('class'=>'blueBtn','id'=>'save',
					'style'=>'display:none;','div' => false))?>
			<a class="blueBtn" href="javascript:history.back();">Cancel</a>
			</td>
		</tr>
	</tbody>
</table>
</td>
</tr>
</table>
<?php  echo $this->Form->end(); ?>
<script>
var number_of_field=1; 
var againstReference=[];
$(document).ready(function(){
	$("#save").show();
	$(document).on('keyup','.ref_amt',function(){
		refCount = 0;
		$(".ref_amt").each(function( index ) {				 
			refCount += parseInt($(this).val()); 
		});
		daebi_amount =$("#debit").val();
		if(daebi_amount==refCount) {
		    $("#save").show();
		}
		else
		{
			$("#save").hide();
		}
	});
	
	$(document).on('change','.ref-opt', function() {
		reference_id = $(this).val();
		credit_id =$("#credit_account").val();
		currentId = $(this).attr('id'); 
		splittedCurrentId = currentId.split('_'); 
		if(reference_id==3 && credit_id ) { //against reference
			$.fancybox({
				'autoDimensions' : false,
				'width' : '50%',
				'height' : '50%',
				'autoScale' : true,
				'transitionIn' : 'elastic',
				'transitionOut' : 'elastic', 
				'type': 'iframe',
				'href': "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "getJournalEntryPayment")); ?>"+"/"+credit_id+"/"+splittedCurrentId[1],
			});
		}else if(reference_id==2){ //new refence
			$("#reference_no").fadeIn('slow');
		}else{
			//no case for advance
		} 

		if(credit_id == ''){
			alert('Please select credit account');
			$(this).val(''); //reset reference dropdown
			$("#to").focus();
		}
	});
		
	$( "#by" ).autocomplete({
		// source: autoCompleteUrlBy,
		source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'CashBankOnly',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#debit_account').val(ui.item.id); 
			 
			 var id = ui.item.id;
				var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "accounting", "action" => "get_account_current_balance","admin" => false)); ?>";
				$.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+id,
			          data: '',
			          dataType: 'html',
			          success: function(data){
			        	  data = jQuery.parseJSON(data);
				          $('#reference').prop('disabled', false);
				          if(data.acountType == 'Cr')
				          { 
				        	$("#by_current_balance").html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#by_current_balance").html(data.credit); 
				          } 

				          $('#by').keydown(function(){
								$("#debit").val('');
								$("#credit").val('');
							});
				          $("#debit").focus(); 
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

	$( "#to" ).autocomplete({
		// source: autoCompleteUrlTo,
		source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'CashBankOnly',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#credit_account').val(ui.item.id); 
			 var id = ui.item.id;
				var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "accounting", "action" => "get_account_current_balance","admin" => false)); ?>";
				$.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+id,
			          data: '',
			          dataType: 'html',
			          success: function(data){  
			        	  data = jQuery.parseJSON(data);
			        	  if(data.acountType == 'Cr')
				          { 
				        	$("#to_current_balance").html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#to_current_balance").html(data.credit); 
				          } 
			        	//BOF by amit jain
				          if(data.referenceNo == '0')
					          { 
				        	  	$("#add-new-row").hide();
					        	 $("#ref-area").hide();
					        	 $("#save").show();
					          }else{
					        	  $("#add-new-row").show();
					        	  $("#ref-area").show();
						          $("#save").show();
						      }
					      //EOF
				         $("#narration").focus(); 
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
		
	$('#debit').keyup( function() {
		if (/[^0-9\.]/g.test(this.value)){
	     	this.value = this.value.replace(/[^0-9\.]/g,'');
	    }  
		var credit=$('#debit').val();
		$('#credit').val(credit);
		$('#credit_total').html('Credit Total :'+credit);
		$('#debit_total').html('Debit Total :'+credit);
		
	});
	$('#ContraEntryForm').submit( function() {
		reference_id = $('#reference').val();
		var pay_id=$('#voucher_payment_id').val();
		if(pay_id==''&& reference_id==3)
		{
			alert('Please select Reference against Number');
			$('#reference').val('');
			return false;
		}
	});
	$("#save").click(function(){
		var validateForm = jQuery("#ContraEntryForm").validationEngine('validate');
		if(validateForm == true){
			$("#save").hide();
		}else{
			return false;
		}
	});
		//BOF reference HTML
		$("#add-new-row").click(function(){
			var field = ''; 
           	field +='<tr  id="row'+number_of_field+'"><td><select class="validate[required,custom[mandatory-enter]] ref-opt" id="reference_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][reference_type_id]"><option value="">Please Select</option><option value="2">New Reference</option><option value="3">Against Reference</option></select>';
           	field += '<input type="hidden" class="validate[required,custom[mandatory-enter]]" id="voucher_reference_id_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][voucher_reference_id]" >'	
           	field += '<input type="hidden" class="validate[required,custom[mandatory-enter]]" id="id_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][id]" ></td>';						
			field +='<td><input type="text" class="validate[required,custom[mandatory-enter]]" id="reference_no_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][reference_no]" placeHolder="Refrence No." "autocomplete=off"></td>';
			field +='<td><input type="text" class="validate[optional,custom[onlyNumber]] " id="credit_period_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][credit_period]" placeHolder="Credit Period" "autocomplete=off"></td>';
			field +='<td><input type="text" class="validate[required,custom[mandatory-enter]] ref_amt cost" id="reference_amount_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][amount]" placeHolder="Amount" "autocomplete=off"></td>'; 
			field +='<td><select class="validate[required,custom[mandatory-select]] ref-opt" id="payment_type'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][payment_type]"><option value="Dr">Dr</option><option value="Cr">Cr</option></select>';
			field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image('/img/cross.png');?></a></td>';
	      	field += '</tr>' ;
	      	$("#ref-area").append(field);
	      	number_of_field++;
		});
		//EOF reference HTML
		$("#by").focus().attr('placeHolder','Party to be debited.');
		$("#to").attr('placeHolder','Party to be credited.');
	});	

function deletRow(id){
	 if(number_of_field == 1){
		 $("#submitForm").hide() ;
	 }	 
	$("#row"+id).remove();
   number_of_field--;
}
	
$("#date").datepicker({
	showOn : "both",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange: '-100:' + new Date().getFullYear(),
	//maxDate : new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
	onSelect : function() {
		$(this).focus();
		//foramtEnddate(); //is not defined hence commented
	}
});

$(document).ready(function(){
	$('.inputBox').keypress('',function(e) {
		var id = $(this).attr('id');
	    if(e.keyCode==13){//key enter
	    	if(id === "debit"){
	    		$("#to").focus();
	    		e.preventDefault();
	    	}else if(id === "narration"){
	    		$("#save").focus();
	    	    e.preventDefault();
	    	}
	    }
	});
});
</script>