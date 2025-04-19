<?php  
	echo $this->Html->script(array('jquery.fancybox-1.3.4'));
  	echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
  	if($action=='print' && !empty($lastInsertID)){
  		echo "<script>var openWin = window.open('".$this->Html->url(array("controller" => "Accounting",'action'=>'printReceiptVoucher',$lastInsertID))."', '_blank',
                       'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
                  window.location='".$this->Html->url(array('action'=>'account_receipt'))."'  </script>"  ;
  	}
?>
<div class="inner_title">
	<h3>
		<?php echo __('Account Receipt'); ?>
	</h3>
</div>
<style>
.cost{
	text-align: right;
}
</style>
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
	echo $this->Form->create('accounting', array('url'=>array('controller'=>'Accounting','action'=>'account_receipt'),'id'=>'Complaintfrm',
	'inputDefaults' => array('label' => false,'div' => false,'error'=>false,'legend'=>false,'O'))) ;
?>
<table width="100%" cellpadding="1" cellspacing="1" border="0">
	<tr>
		<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
<table width="100%" cellpadding="1" cellspacing="1" border="0">
	<tr>
		<td width="30%">
			<?php echo $this->Form->hidden('AccountReceipt.id',array('type'=>'text','id'=>'id'));
			if ($dataDetail['AccountReceipt']['id']==null){
				echo __('Receipt No. :'); echo $ar_no;
			}else{
				echo __('Receipt No. :'); echo $dataDetail['AccountReceipt']['id'];
			}
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

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	<tr>
		<th width="60%" align="center" valign="top" style="text-align: left; padding: 5px 0 0 50px;"><strong><?php echo __('Particulars')?></strong></th>
		<th width="20%" align="center" valign="top" style="text-align: center;"><strong><?php echo __('Debit');?></strong></th>
		<th width="20%" align="center" valign="top" style="text-align: center;"><strong><?php echo __('Credit');?></strong></th>
	</tr>
	<tr>
		<td colspan="3">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
			<tr>
				<td class="searchdiv" style="width:60%;"><?php echo __('Dr :')?><font color="red">*</font>
				<?php echo $this->Form->input('AccountReceipt.account_name', array('class'=>'validate[required,custom[mandatory-enter]]',
						'id' => 'account_name','placeholder'=>'Party to be debited','value'=>$this->data['AccountAlias']['name'])); ?>
				<?php echo $this->Form->input('AccountReceipt.account_name', array('type'=>'hidden','class' => '','id' => 'account_name'));
					echo $this->Form->hidden('AccountReceipt.account_id', array('type'=>'text','id' => 'account_id')); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				<?php echo __('Name on Receipt :');?>
				<?php echo $this->Form->input('AccountReceipt.name_on_receipt', array('id' => 'name_on_receipt','type'=>'text','placeholder'=>'Name on Receipt')); ?>
				</td>
				<td style="text-align: Left; width:20%; padding-left: 75px;">
					<?php echo $this->Form->input('AccountReceipt.paid_amount', array('class' => 'validate[required,custom[mandatory-enter]] inputBox cost',
							'id' => 'paid_amount','type'=>'text','placeholder'=>'Debit Amount','autocomplete'=>'off'));
					echo $this->Form->hidden('AccountReceipt.previous_paid_amount', array('type'=>'text','id'=>'previousPaidAmount','value'=>$this->data['AccountReceipt']['paid_amount']));?>
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
			<tr>
				<td style="width:60%;"><?php echo __('Cr :')?><font color="red">*</font>
					<?php  echo $this->Form->input('AccountReceipt.username', array('class'=>'validate[required,custom[mandatory-enter]]','id' => 'username', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'placeholder'=>'Party to be credited','value'=>$this->data['Account']['name'])); 
					echo $this->Form->hidden('AccountReceipt.user_id', array('type'=>'text','id' => 'user_hidden'));
					?>
				</td>
				<td style="text-align: right; width:20%;">
					<?php echo " "; ?>
				</td>
				<td style="text-align: center; width:20%;">
					<?php  echo $this->Form->input('AccountReceipt.credit_amount', array('class' => 'validate[required,custom[mandatory-enter]] inputBox cost',
							'id' => 'credit_amount','type'=>'text','placeholder'=>'Credit Amount','value'=>$this->data['AccountReceipt']['paid_amount'],'autocomplete'=>'off')); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" style="text-align: left; padding-left:60px;padding-top:5px; font-style:italic;"> 
				<?php echo __('Current Balance :')?>
				<?php if(!$this->data['Account']['balance']){?>
					<b><span id="user_current_balance" ></span></b>
					<?php }else{?>
					<b><span id="user_current_balance" ><?php echo $this->data['Account']['balance'];?></span></b>
				<?php }?>
				</td>
				<td rowspan="1" colspan="1"></td>
				<?php 
				if(empty($this->data['VoucherReference'][0]['id'])){
					$style = "display: none;";
				}else{
					$style = "display: block;";
				}?>
				<td><input type="button" value="Add Row" class="blueBtn"  id="add-new-row" style="<?php echo $style?>"/></td>
			</tr>
			
			<tr>
				<td> 	
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
						<?php echo $this->Form->input("VoucherReference.$cnt.reference_type_id",array('id'=>"reference_$cnt",'type'=>'select','class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('2'=>'New Reference','3'=>'Against Reference'),'empty'=>'Please Select'));?>
						<?php echo $this->Form->hidden("VoucherReference.$cnt.voucher_reference_id",array('id'=>"voucher_reference_id_$cnt",'type'=>'text','placeHolder'=>''));?>
						<?php echo $this->Form->hidden("VoucherReference.$cnt.id",array('id'=>"id_.$cnt",'type'=>'text'));?>
						</td>
						<td><?php echo  $this->Form->input("VoucherReference.$cnt.reference_no",array('id'=>"reference_no_$cnt",'type'=>'input','class' =>'validate[required,custom[mandatory-enter]]','type'=>'text','placeHolder'=>'Refrence No.','autocomplete'=>'off')); ?></td>
						<td><?php echo  $this->Form->input("VoucherReference.$cnt.credit_period",array('id'=>"credit_period_$cnt",'type'=>'input','class' =>'validate[required,custom[onlyNumber]] ','type'=>'text','placeHolder'=>'Credit Period','autocomplete'=>'off')); ?></td>
						<td><?php echo  $this->Form->input("VoucherReference.$cnt.amount",array('id'=>"reference_amount_$cnt",'type'=>'input','class' =>'validate[required,custom[mandatory-enter]] ref_amt cost','type'=>'text','placeHolder'=>'Amount','autocomplete'=>'off')); ?></td>
						<td><?php echo $this->Form->input("VoucherReference.$cnt.payment_type",array('id'=>"payment_type_$cnt",'type'=>'select','class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('Dr'=>'Dr','Cr'=>"Cr")));?></td>
					</tr>
					<?php $cnt++; }
					}else{?>
				<tr>
						<td>
						<?php echo $this->Form->input("VoucherReference.$cnt.reference_type_id",array('id'=>"reference_$cnt",'type'=>'select','class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('2'=>'New Reference','3'=>'Against Reference'),'empty'=>'Please Select'));?>
						<?php echo $this->Form->hidden("VoucherReference.$cnt.voucher_reference_id",array('id'=>"voucher_reference_id_$cnt",'type'=>'text','placeHolder'=>''));?>
						<?php echo $this->Form->hidden("VoucherReference.$cnt.id",array('id'=>"id_'$cnt'",'type'=>'text'));?>
						</td>
						<td><?php echo  $this->Form->input("VoucherReference.$cnt.reference_no",array('id'=>"reference_no_$cnt",'type'=>'input','class' =>'validate[required,custom[mandatory-enter]]','type'=>'text','placeHolder'=>'Refrence No.','autocomplete'=>'off')); ?></td>
						<td><?php echo  $this->Form->input("VoucherReference.$cnt.credit_period",array('id'=>"credit_period_$cnt",'type'=>'input','class' =>'validate[required,custom[onlyNumber]] ','type'=>'text','placeHolder'=>'Credit Period','autocomplete'=>'off')); ?></td>
						<td><?php echo  $this->Form->input("VoucherReference.$cnt.amount",array('id'=>"reference_amount_$cnt",'type'=>'input','class' =>'validate[required,custom[mandatory-enter]] ref_amt cost','type'=>'text','placeHolder'=>'Amount','autocomplete'=>'off')); ?></td>
						<td><?php echo $this->Form->input("VoucherReference.$cnt.payment_type",array('id'=>"payment_type_$cnt",'type'=>'select','class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('Dr'=>'Dr','Cr'=>"Cr")));?></td>
					</tr>
					<?php }?>
				</table>
				</td>
				<td rowspan="1" colspan="2"></td>		
			</tr>
			</table>
		</td>
	</tr>
</table>

</br>
<table width="100%" class="tabularForm" cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td valign="middle"  style="width:60%;"><?php echo __('Narration :')?> 
		 <?php echo $this->Form->input('AccountReceipt.narration', array('class' => 'inputBox','id' => 'narration','type'=>'textarea'));?>
		</td>
		<td style="width:20%; padding-left: 40px;" id="debit_total"><?php echo __("Debit Total:");?><?php echo $this->data['JournalEntry']['debit'];?></td>
		<td style="width:20%; padding-left: 40px;" id="credit_total"><?php echo __("Credit Total:");?><?php echo $this->data['JournalEntry']['credit'];?></td>
	</tr>
	<tr>
		<td colspan="3" align="center" style="padding: 20px 0 20px 0">
		<?php if(!empty($id)){
			echo $this->Html->link('Print','javascript:void(0)',
	   		array('escape' => false,'class'=>'blueBtn printButton','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printReceiptVoucher',
     		$id))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,height=570,left=200,top=200');  return false;"));
		}?>	
		<?php if(!empty($id)){ 
			$style = '';
		}else{
			$style = 'display:none';
		}?>
		<?php echo $this->Form->submit('Save',array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;','id'=>'save','style'=>$style,'div' => false,'name'=>'print')) ; ?>
		<a class="blueBtn" href="javascript:history.back();">Cancel</a>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
<?php  echo $this->Form->end(); ?>
<script>
	// for account
$(document).ready(function(){
	$(document).on('keyup','.ref_amt',function(){
		refCount = 0;
		daebi_amount =0;
		credit_amount = 0;
		$( ".ref_amt" ).each(function( index ) {				 
			refCount += parseInt($(this).val()); 
		});
		if(!isNaN(refCount)){
			$("#paid_amount").val(refCount);
		}else{
			$("#paid_amount").val('');
		}
		daebi_amount =$("#paid_amount").val();
		if(!isNaN(refCount)){
			$("#credit_amount").val(refCount);
		}else{
			$("#credit_amount").val('');
		}
		credit_amount =$("#credit_amount").val();
		if(daebi_amount==refCount) {
		    $("#save").show();
		}else
		{
			$("#save").hide();
		}
	});

$("#save").click(function(){
	var validateForm = jQuery("#Complaintfrm").validationEngine('validate');
	if(validateForm == true){
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
				          $('#reference').prop('disabled', false);
				          if(data.acountType == 'Cr')
				          { 
				        	$("#account_current_balance").html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#account_current_balance").html(data.credit); 
				          } 

				          $('#account_name').keydown(function(){
								//$("#account_id").val('');	 
								//$("#save").hide();
								$("#paid_amount").val('');
							});
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
	var number_of_field=1; 
	var againstReference=[];
	$(document).ready(function(){
			$( "#username" ).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'Patient',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				$('#user_hidden').val(ui.item.id);
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
				        	$("#user_current_balance").html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#user_current_balance").html(data.credit); 
				          }
			        	  $("#narration").html(data.narrationReceipt);
			        	  
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

				$(document).on('change','.ref-opt', function() {
				reference_id = $(this).val();
				credit_id =$("#user_hidden").val();
				currentId = $(this).attr('id'); 
				receivable_type = 1;
			//	alert(currentId);
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
						'href': "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "getJournalEntryPaymentReceivable")); ?>"+"/"+credit_id+"/"+splittedCurrentId[1]+"/"+receivable_type,
					});
				}else if(reference_id==2){ //new refence
					$("#reference_no").fadeIn('slow');
				}else{
					//no case for advance
				} 

				if(credit_id == ''){
					alert('Please select credit account');
					$(this).val(''); //reset reference dropdown
					$("#username").focus();
				}
			});
				$("#add-new-row").click(function(){
					var field = ''; 
					 
		           	field +='<tr  id="row'+number_of_field+'"><td><select class="validate[required,custom[mandatory-enter]] ref-opt" id="reference_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][reference_type_id]"><option value="">Please Select</option><option value="2">New Reference</option><option value="3">Against Reference</option></select>';
		           	field += '<input type="hidden" class="" id="voucher_reference_id_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][voucher_reference_id]" >'	
		           	field += '<input type="hidden" class="" id="id_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][id]" ></td>';						
					field +='<td><input type="text" class="validate[required,custom[mandatory-enter]]" id="reference_no_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][reference_no]" placeHolder="Refrence No." "autocomplete=off"></td>';
					field +='<td><input type="text" class="validate[optional,custom[onlyNumber]] " id="credit_period_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][credit_period]" placeHolder="Credit Period" "autocomplete=off"></td>';
					field +='<td><input type="text" class="validate[required,custom[mandatory-enter]] ref_amt cost" id="reference_amount_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][amount]" placeHolder="Amount" "autocomplete=off"></td>'; 
					field +='<td><select class="validate[required,custom[mandatory-select]] ref-opt" id="payment_type'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][payment_type]"><option value="Dr">Dr</option><option value="Cr">Cr</option></select>';
					field +='<td valign="middle" style="text-align:center;"> <a href="javascript:void(0);" id="delete row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image('/img/cross.png');?></a></td>';
			      	field += '</tr>' ;
			      	$("#ref-area").append(field);
			      	
			      	number_of_field++;
			      	
				});
			//BOF cross cheeck	
			$("#account_name").focus().attr('placeHolder','Party to be debited.');
			$("#username").attr('placeHolder','Party to be credited.');
	});
	
function deletRow(id){
	amount = 0;
	 if(number_of_field == 1){
		 $("#submitForm").hide() ;
	 }	  
	$("#row"+id).remove();
	
	$( ".ref_amt" ).each(function( index ) {			 
		amount += parseInt($(this).val()); 
	});
	if(!isNaN(amount)){
		$("#paid_amount").val(amount);
	}
	if(!isNaN(amount)){
		$("#credit_amount").val(amount);
	}
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

$('#print').click(function(){
	window.print();	
});

$('#paid_amount').keyup( function() {
	if (/[^0-9\.]/g.test(this.value)){
     	this.value = this.value.replace(/[^0-9\.]/g,'');
    } 
	var amount=$('#paid_amount').val();
	$('#credit_amount').val(amount);
	$('#credit_total').html('Credit Total :'+amount);
	$('#debit_total').html('Debit Total :'+amount);
});
$('#credit_amount').keyup( function() {
	if (/[^0-9\.]/g.test(this.value)){
     	this.value = this.value.replace(/[^0-9\.]/g,'');
    } 
	var amount=$('#credit_amount').val();
	$('#paid_amount').val(amount);
	$('#credit_total').html('Credit Total :'+amount);
	$('#debit_total').html('Debit Total :'+amount);
	
});
	
$(document).ready(function(){
	$('.inputBox').keypress('',function(e) {
		var id = $(this).attr('id');
	    if(e.keyCode==13){//key enter
	    	if(id === "paid_amount"){
	    		$("#username").focus();
	    		e.preventDefault();
	    	}else if(id === "narration"){
	    		$("#save").focus();
	    	    e.preventDefault();
	    	}
	    }
	});
});
</script>

