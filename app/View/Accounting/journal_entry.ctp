 <?php   
	echo $this->Html->script(array('jquery.fancybox-1.3.4'));
  	echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?> 
<div class="inner_title">
	<h3>
		<?php echo __('Journal Entry'); ?>
	</h3>		
</div> 
<style>
.cost{
	text-align: right;
}
</style>
<?php 
	echo $this->Form->create('VoucherEntry',array('url'=>Array('controller'=>'Accounting','action'=>'journal_entry'),'id'=>'JournalEntryForm',
															'inputDefaults'=>array('div'=>false,'label'=>false,'error'=>false)));
	echo $this->Form->hidden('VoucherEntry.id',array('type'=>'text'));
?>
<table align="right" width="100%">
	<tr>
	<?php if($isPayment == 'isPayment'){?>
	<td width="100%" valign="top">
	<?php }else{?>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
	<?php }?>
<table width="100%">
	<tr>
		<td style="float :left">
		<?php 
		if (!empty($this->data['VoucherEntry']['journal_voucher_no'])){
			$jv_no = $this->data['VoucherEntry']['journal_voucher_no'];
		}
			echo __('Journal No. :'); echo $jv_no;
			echo $this->Form->hidden('VoucherEntry.journal_voucher_no',array('type'=>'text','id'=>'journal_voucher_no','value'=>$jv_no));
			echo $this->Form->hidden('VoucherLog.id',array('value'=>$this->data['VoucherLog']['id']));?>
		</td>
		
		<?php if($type =="editJv"){?>
		<td style="float :right">
		<?php echo $this->Form->input('VoucherEntry.date', array('label'=>false,'type'=>'text','value'=>$this->data['VoucherEntry']['date'],
				'id'=>'date','class'=>'textBoxExpnd')); ?>
		</td>
		<?php }else{?>
		<td style="float :right">
		<?php $date = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
		echo $this->Form->input('VoucherEntry.date', array('label'=>false,'type'=>'text','value'=>$date,'id'=>'date',
				'readonly'=>'readonly','class'=>'textBoxExpnd')); ?>
		</td>
		<?php } ?>
		<td style="float :right"><?php echo __('Date:')?></td>
	</tr>
</table>
<?php echo $this->Form->hidden('debit_field',array('id'=>'debit_field','value'=>'1'));?>
<?php echo $this->Form->hidden('credit_field',array('id'=>'credit_field','value'=>'1'));?>

<input type="hidden" value="1" class="blueBtn " id="no_of_field-1"/>
<input type="hidden" value="1" class="blueBtn " id="d_no_of_field-1"/>
<table class="tabularForm" id="account_form" cellpadding="0" cellspacing="1" width="100%" cols="3">
	<tbody>
		<tr>
			<th width="60%" valign="top" align="center" style="text-align: left; padding: 5px 0 0 50px;"><?php echo __("Particulars");?></th>
			<th width="20%" valign="top" align="center" style="text-align: center;"><?php echo __("Debit");?></th>
			<th width="20%" valign="top" align="center" style="text-align: center;"><?php echo __("Credit");?></th>
		</tr>
		
		<tr>
			<td colspan="3">
				<table id="debitTable" width="100%">
					<tr id="dRow1">
						<td>	
							<table cellspacing="1" cellpadding="0" border="0" width="100%" class="tabularForm">	
								<tr>
									<td style="width:60%;"><?php echo __('Dr :')?><font color="red">* </font>
									<?php echo $this->Form->input('VoucherEntry.debit.1.debit_by',array('id'=>'by-1','placeholder'=>'Party to be debited',
										'class' => 'validate[required,custom[name]] debitor','type'=>'text','autocomplete'=>'off',
										'value'=>$this->data['AccountAlias']['name']));
										echo $this->Form->hidden('VoucherEntry.debit.1.account_id',array('id'=>'debit_account-1',
										'value'=>$this->data['VoucherEntry']['account_id']));?>
									</td>
									<td style="width:20%; padding-left: 75px;">
									<?php echo $this->Form->input('VoucherEntry.debit.1.debit_amount',array('placeholder'=>'Debit Amount','type'=>'text',
												'id'=>'debit-1','class'=>'validate[required,custom[mandatory-enter]] debitAmt inputBox cost',
											'value'=>$this->data['VoucherEntry']['debit_amount'],'autocomplete'=>'off'));
										/* echo $this->Form->hidden('VoucherEntry.previous_paid_amount',
											array('type'=>'text','id' =>'previousPaidAmount','value'=>$this->data['VoucherEntry']['debit_amount'])); */?>
									</td>
									<td style="width:20%;">&nbsp;</td>
								</tr>
								<tr>
									<td valign="top" style="text-align: left;"><?php echo __('Current Balance :')?>
									<?php if(!$this->data['AccountAlias']['balance']){?>
									<b><span id="by_current_balance-1"></span></b>
									<?php }else{?>
									<b><span id="by_current_balance-1"><?php echo $this->data['AccountAlias']['balance'];?></span></b>
									<?php }?>
									</td>
									<td rowspan="2" colspan="2"></td>
								</tr>
							</table>							
						</td>
					</tr>			
				</table>
				<?php if($type !="editJv"){ ?>
				<table>
					<tr>
						<td>
							<?php echo $this->Html->link(__('Add More'), 'javascript:void(0);', array('title'=>'Add','class'=>'blueBtn addDebitParticular','onclick'=>'AddDebitParticular()','id'=>'addDebitParticular'));?>
							<input type="button" value="Remove" id="remove-btn_debit" class="blueBtn" onclick="removeRowDebit()" style="display: none ;float:right;  margin: -4px 0 0 3px;" />
						</td>
					</tr>
				</table>
				<?php }?>
			</td>
		</tr><!--  Debit fields -->
		
		<tr id="cRow1">
			<td colspan="3">
				<table  cellspacing="1" cellpadding="0" border="0" width="100%" class="tabularForm">
			<?php 
			if($type=="editJv"){
				$countJv=1;
				foreach ($dataDetail as $key=>$data){?>
				<tr>
					<td style="width:60%;"><?php echo __('Cr :')?><font color="red">* </font>
					<?php 
					echo $this->Form->input("VoucherEntry.credit.$countJv.credit_account",array('id'=>'to-'.$countJv,'placeholder'=>'Party to be credited',
						'class' => 'validate[required,custom[name]] creditorEdit','type'=>'text','autocomplete'=>'off','value'=>$data['AccountAlias']['name']));
					echo $this->Form->hidden("VoucherEntry.credit.$countJv.user_id",array('id'=>'credit_account-'.$countJv,'value'=>$data['VoucherEntry']['user_id']));
					?> 
					</td>
					<td style="width:20%;"><?php echo __("");?></td>
					<td style="width:20%; padding-left: 75px;">
					<?php echo $this->Form->input("VoucherEntry.credit.$countJv.credit_amount",array('placeholder'=>'Credit Amount','type'=>'text',
									'id'=>'debit_amount','value'=>$data['VoucherEntry']['debit_amount'],'class'=>'creditAmt inputBox cost')); 
							?>
					</td>
				</tr>
				
				<tr>
					<td valign="top" style="text-align: left;"><?php echo __('Current Balance :')?>
						<b><span id='to_current_balance-<?php echo $countJv;?>'><font color="red"><?php echo $data['AccountAlias']['balance'];?></font></span></b>
					</td>
					<td colspan="2" ><?php echo __("");?></td>
				</tr>
			<?php $countJv++; } ?>
			<?php  echo $this->Form->hidden('credit_field',array('id'=>'credit_field','value'=>count($dataDetail))); 
			echo $this->Form->hidden('VoucherEntry.batch_identifier',array('id'=>'batch_identifier','value'=>$this->data['VoucherEntry']['user_id']));
			}else{?>
				<tr>
					<td style="width:60%;"><?php echo __('Cr :')?><font color="red">* </font> 
					<?php 
						echo $this->Form->input('VoucherEntry.credit.1.credit_to',array('id'=>'to-1','placeholder'=>'Party to be credited',
							'class'=>'validate[required,custom[name]] creditor','type'=>'text','autocomplete'=>'off','value'=>$this->data['Account']['name']));
						echo $this->Form->hidden('VoucherEntry.credit.1.user_id',array('id'=>'credit_account-1','value'=>$this->data['VoucherEntry']['user_id']));
					?> 
					<?php 
							if(empty($this->data['VoucherReference'][0]['id'])){
								$style = "display: none;";
							}else{
								$style = "display: block;";
							}?>
							<input id="add-new-row_1" class="blueBtn add-row_user" type="button" style="<?php echo $style?>" value="Add Row">
						<?php 
							if(empty($this->data['VoucherReference'][0]['id'])){
								$style = "display: none;";
							}else{
								$style = "display: block;";
							}?>
						<table cellpadding="0" cellspacing="0" width="100%" border="0" id="ref-area_1" style="<?php echo $style?>">
							<?php
								$cnt=1;
								if(count($this->data['VoucherReference']) > 0){
								foreach($this->data['VoucherReference'] as $value){	  
						   ?>
							<tr>
								<td>
								<?php echo $this->Form->input("VoucherReference.1.$cnt.reference_type_id",array('id'=>"reference_1-".$cnt,'type'=>'select',
										'class' =>'validate[required,custom[mandatory-select]] ref-opt','value'=>$value['reference_type_id'],
										'options'=>array('2'=>'New Reference','3'=>'Against Reference'),
										'empty'=>'Please Select'));?>
								<?php echo $this->Form->hidden("VoucherReference.1.$cnt.voucher_reference_id",array('id'=>"voucher_reference_id_1-".$cnt,
										'value'=>$value['voucher_id'],
										'type'=>'text','placeHolder'=>''));?>
								<?php echo $this->Form->hidden("VoucherReference.1.$cnt.id",array('id'=>"id_1-".$cnt,
										'value'=>$value['id'],
										'type'=>'text'));?>
								</td>
								<td><?php echo  $this->Form->input("VoucherReference.1.$cnt.reference_no",array('id'=>"reference_no_1-".$cnt,
										'type'=>'input','class' =>'validate[required,custom[mandatory-enter]]','value'=>$value['reference_no'],
										'type'=>'text','placeHolder'=>'Refrence No.','autocomplete'=>'off')); ?>
		
								</td>
								<td><?php echo  $this->Form->input("VoucherReference.1.$cnt.credit_period",array('id'=>"credit_period_1-".$cnt,
										'type'=>'input','class' =>'validate[required,custom[onlyNumber]] ','type'=>'text','value'=>$value['credit_period'],
										'placeHolder'=>'Credit Period','autocomplete'=>'off')); ?>
		
								</td>
								<td><?php echo  $this->Form->input("VoucherReference.1.$cnt.amount",array('id'=>"reference_amount_1-".$cnt,
										'type'=>'input','class' =>'validate[required,custom[onlyNumber]] ref_amt','type'=>'text','value'=>$value['amount'],
										'placeHolder'=>'Amount','autocomplete'=>'off')); ?>
								</td>
								<td>
									<?php 
										echo $this->Form->input("VoucherReference.1.$cnt.payment_type",array('id'=>"payment_type_1-".$cnt,
										'type'=>'select','class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('Dr'=>'Dr','Cr'=>"Cr")));
									?>
								</td>
							</tr>
							<?php $cnt++; }
							}else{?>
							<tr>
								<td>
									<?php echo $this->Form->input("VoucherReference.1.$cnt.reference_type_id",array('id'=>"reference_1-$cnt",'type'=>'select',
											'class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('2'=>'New Reference',
											'3'=>'Against Reference'),'empty'=>'Please Select'));
										echo $this->Form->hidden("VoucherReference.1.$cnt.voucher_reference_id",array('id'=>"voucher_reference_id_1-$cnt",
											'type'=>'text','placeHolder'=>''));
										echo $this->Form->hidden("VoucherReference.1.$cnt.id",array('id'=>"id_1-'$cnt'",'type'=>'text'));?>
								</td>
								<td>
									<?php echo $this->Form->input("VoucherReference.1.$cnt.reference_no",array('id'=>"reference_no_1-$cnt",'type'=>'input',
											'class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','placeHolder'=>'Refrence No.',
											'autocomplete'=>'off')); ?>
								</td>
								<td>
									<?php echo $this->Form->input("VoucherReference.1.$cnt.credit_period",array('id'=>"credit_period_1-$cnt",'type'=>'input',
											'class'=>'validate[required,custom[onlyNumber]]','type'=>'text','placeHolder'=>'Credit Period','autocomplete'=>'off'));?>
								</td>
								<td>
									<?php echo $this->Form->input("VoucherReference.1.$cnt.amount",array('id'=>"reference_amount_1-$cnt",'type'=>'input',
											'class'=>'validate[required,custom[onlyNumber]] ref_amt','type'=>'text','placeHolder'=>'Amount','autocomplete'=>'off'));?>
								</td>
								<td>
									<?php echo $this->Form->input("VoucherReference.1.$cnt.payment_type",array('id'=>"payment_type_1-$cnt",'type'=>'select',
										'class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('Dr'=>'Dr','Cr'=>"Cr")));?>
								</td>
							</tr>
							<?php }?>
						</table>
					</td>
					<td style="width:20%;">&nbsp;</td>
					<td style="width:20%; padding-left: 75px;">
						<?php 
							if(!empty($this->data['VoucherEntry']['debit_amount'])){ 
								 echo $this->Form->input('VoucherEntry.credit.1.credit_amount',array('placeholder'=>'Credit Amount','type'=>'text',
										'id'=>'credit-1','value'=>$this->data['VoucherEntry']['debit_amount'],'class'=>'creditAmt cost','autocomplete'=>'off')); 
							}else{
								 echo $this->Form->input('VoucherEntry.credit.1.credit_amount',array('placeholder'=>'Credit Amount','type'=>'text',
										'id'=>'credit-1','class'=>'validate[required,custom[mandatory-enter]] creditAmt inputBox cost','autocomplete'=>'off'));
							}?>
					</td>
				</tr>
				<tr>
					<td valign="top" style="text-align: left;"><?php echo __('Current Balance :')?>
						<?php 
						if(!$this->data['Account']['balance']){?>
							<b><span id="to_current_balance-1" ></span></b>
						<?php }else{?>
							<b><span id="to_current_balance-1" ><?php echo $this->data['Account']['balance'];?></span></b>
						<?php }?>
					</td>
					<td rowspan="2" colspan="2"></td>
				</tr>
				<?php }?>
				</table><!-- Parent credit table -->
			</td>		
		</tr><!-- Parent tr -->
		</table>
		<?php if($type !="editJv"){ ?>
		<table>
			<tr>
				<td>
					<?php echo $this->Html->link(__('Add More'), 'javascript:void(0);', array('title'=>'Add','class'=>'blueBtn addParticular',
							'onclick'=>'AddParticular()','id'=>'addParticular','style'=>"margin: 0 0 0 8px;"));?>
					<input type="button" value="Remove" id="remove-btn_credit" class="blueBtn" onclick="removeRowCredit()" style="display: none;float:right;margin: -4px 0 0 3px;" />
				</td>
			</tr>
		</table>
		<?php }?>
		<table width="100%" class="tabularForm" cellpadding="0" cellspacing="1" border="0">
		<tr>
			<td style="width:60%;">
				<table cellpadding="0" cellspacing="0" width="453px" align="left">
					<tr>
						<td><label><?php echo __("Narration");?></label></td>
						<td><?php echo $this->Form->input('narration', array('type'=>'textarea','id'=>'VoucherEntryNarration','class'=>'inputBox','value'=>$this->data['VoucherEntry']['narration']));?></td>
					</tr>
				</table>
			</td>
			<td style="width:20%; padding-left: 40px;" id="debit_total">
				<?php echo __("Debit Total:"); echo $this->data['VoucherEntry']['debit_amount'];?>
			</td>
			<td style="width:20%; padding-left: 40px;" id="credit_total">
				<?php echo __("Credit Total:"); echo $this->data['VoucherEntry']['debit_amount'];?>
			</td>
		</tr>
		<tr><?php if(empty($id) || $this->Session->read('role')=='Admin' || $this->Session->read('role')=='Account Manager'){?>
			<td align="right">
				<?php echo $this->Form->submit('Save',array('class'=>'blueBtn','id'=>'save','div' => false))?>
			</td>
			<?php } else {?>
			<td align="right">
				<?php echo " "?>
			</td>
			<?php }?>
			<?php if(!isset($isPayment)){?>
			<td colspan="2">
				<a class="blueBtn" href="javascript:history.back();">Cancel</a>
			</td>
		<?php }?>
		</tr>
	</tbody>
</table>
</td>
</tr>
</table>
<?php  echo $this->Form->end(); ?>
<script>
var paymentVoucherValue = true;
var number_of_field=1; 
var againstReference=[];
$(document).ready(function(){
	$(document).on('keyup','.ref_amt',function(){
		refCount = 0;
		$(".ref_amt").each(function( index ) {				 
			refCount += parseInt($(this).val()); 
		});
		daebi_amount =$(".debitAmt").val();
		if(daebi_amount==refCount) {
		   // $("#save").show();
		}else{
			//$("#save").hide();
		}
	});
		
	$(document).on('change','.ref-opt', function() {
		var field = $("#credit_field").val();
		reference_id = $(this).val();
		credit_id =$("#credit_account-"+field).val();
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
		
	$( ".debitor" ).autocomplete({
		// source: autoCompleteUrlBy,
		source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'NotCashBank',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#debit_account-1').val(ui.item.id); 
			 
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
				          if(data.acountType == 'Cr'){ 
				        	$("#by_current_balance-1").html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#by_current_balance-1").html(data.credit); 
				          } 

				          $('#by-1').keydown(function(){
								$("#debit-1").val('');
								$("#credit-1").val('');
							}); 
						$(".debitAmt").focus();
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

	$( ".creditorEdit" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller"=>"accounting","action"=>"advance_autocomplete","Account","name",'null',"null",'no','type'=>'NotCashBank',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 var rowId=$(this).attr('id').split('-')[1];
			 $('#credit_account-'+rowId).val(ui.item.id);
			 var id = ui.item.id; 
				var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "accounting", "action" => "get_account_current_balance","admin" => false)); ?>";
				$.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+id,
			          data: '',
			          dataType: 'html',
			          success: function(data){  
			        	  data = jQuery.parseJSON(data);
			        	  if(data.acountType == 'Dr'){ 
				        	$("#to_current_balance-"+rowId).html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#to_current_balance-"+rowId).html(data.credit); 
				          }
			        	  $("#cr_narration-"+rowId).html(data.narrationVoucherEntry); 
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
	
	$( ".creditor" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'NotCashBank',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#credit_account-1').val(ui.item.id); 
			 var id = ui.item.id;
				var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "accounting", "action" => "get_account_current_balance","admin" => false)); ?>";
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
					    
			        	  $("#VoucherEntryNarration").html(data.narrationVoucherEntry);
			        	 if(data.referenceNo == '0'){	        	 
			        	 	 $("#add-new-row_1").hide();
				        	 $("#ref-area_1").hide();
				          }else{
					          $("#add-new-row_1").show();
				        	  $("#ref-area_1").show();
					      }  
					     $(".creditAmt").focus();
			        	  
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

	$('.addParticular').on('click',function(){ 
		var field = $("#credit_field").val();	
		$('.addDebitParticular').hide();
		 $("#remove-btn_credit").css("display","block");		
			$( ".creditor" ).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'NotCashBank',"admin" => false,"plugin"=>false)); ?>",
				 minLength: 1,
				 select: function( event, ui ) {
					 var rowCreditId=$(this).attr('id').split('-')[1];
					 $('#credit_account-'+rowCreditId).val(ui.item.id);
					 var idc =$(this).attr('id');
					 var rowId=idc.split('-')[1];
					 var id = ui.item.id;
						var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "accounting", "action" => "get_account_current_balance","admin" => false)); ?>";
						$.ajax({
					          type: 'POST',
					          url: ajaxUrl+"/"+id,
					          data: '',
					          dataType: 'html',
					          success: function(data){  
					        	  data = jQuery.parseJSON(data);
					        	  if(data.acountType == 'Dr'){ 
						        	$("#to_current_balance-"+rowId).html('<font color="red">'+data.credit+'</font>');
						          }else{
					        		$("#to_current_balance-"+rowId).html(data.credit); 
						          }
					        	  $("#cr_narration-"+rowId).html(data.narrationVoucherEntry); 
					        	 if(data.referenceNo == '0'){				        	 
					        	 	 $("#add-new-row_"+field).hide();
						        	 $("#ref-area_"+field).hide();
						          }else{
							          $("#add-new-row_"+field).show();
						        	  $("#ref-area_"+field).show();
							      }   
					        	  
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
			$(".creditor ").attr('placeHolder','Party to be credited');
	});

		
	$('#to-1').focus( function() {
		var temp=$('#voucher_type_debit').val();
		if(temp=='')
		alert('Please select Voucher Type');
	});	

	$(document).on('keyup','.debitAmt',function(){
		debitAmt=0; creditAmt=0;
		if (/[^0-9\.]/g.test(this.value)){
	     	this.value = this.value.replace(/[^0-9\.]/g,'');
	    }
        $(".debitAmt").each(function( index ) {
            if($(this).val()!='' && $(this).val()!=undefined){
            	debitAmt += parseFloat($(this).val());
            }
 		});
			
		$(".creditAmt").each(function( index ) {
			if($(this).val()!='' && $(this).val()!=undefined){
				creditAmt += parseFloat($(this).val());
            }
		});

		$('#credit_total').html('Credit Total :'+creditAmt);
		$('#debit_total').html('Debit Total :'+debitAmt);
	});
	
	$(document).on('keyup','.creditAmt',function(){
		debitAmt=0; creditAmt=0;
		if (/[^0-9\.]/g.test(this.value)){
	     	this.value = this.value.replace(/[^0-9\.]/g,'');
	    }
	    $(".debitAmt").each(function( index ) {	
	    	if($(this).val()!='' && $(this).val()!=undefined){
	        	debitAmt += parseFloat($(this).val()); 
	    	}
	 	});
		
		$(".creditAmt").each(function( index ) {
			if($(this).val()!='' && $(this).val()!=undefined){
				creditAmt += parseFloat($(this).val()); 
			}
		});
		$('#credit_total').html('Credit Total :'+creditAmt);
		$('#debit_total').html('Debit Total :'+debitAmt);
	});
		
	$('#JournalEntryForm').submit( function() {
		reference_id = $('#reference').val();
		var pay_id=$('#voucher_payment_id').val();
		if(pay_id==''&& reference_id==3){
			alert('Please select Reference against Number');
			$('#reference').val('');
			return false;
		}
	});
	
	$("#save").click(function(){
		debitAmt=0; creditAmt=0;
		var validateForm = jQuery("#JournalEntryForm").validationEngine('validate');
		$(".debitAmt").each(function( index ) {
    		if(!isNaN($(this).val()))
    			debitAmt += parseInt($(this).val());
			});
		
		$(".creditAmt").each(function( index ) {
			if(!isNaN($(this).val()))
			creditAmt += parseInt($(this).val()); 
		});
		if(!isNaN(debitAmt) && !isNaN(creditAmt)){
			if(debitAmt==creditAmt){
				validateForm = true;
			}else{
				$('#debit-1').validationEngine('showPrompt', 'Debit & Credit Amount Not Equal', 'text', 'topLeft', true);
				validateForm = false;
			}
		}
		if(validateForm == true){
			window.parent.childSubmitted = true;
	        parent.$.fancybox.close();
	        return true;
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
		/*field +='<td><select class="validate[required,custom[mandatory-select]] ref-opt" id="payment_type'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][payment_type]"><option value="Dr">Dr</option><option value="Cr">Cr</option></select>';*/
		field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image('/img/cross.png');?></a></td>';
      	field += '</tr>' ;
      	$("#ref-area_1").append(field);	
      	number_of_field++;	
	});
	//EOF reference HTML
	
	//BOF cross check	
		$("#by-1").focus().attr('placeHolder','Party to be debited');
		$("#to-1").attr('placeHolder','Party to be credited');
		
		//if user hasn't select options from autocomplete then removed entered text
		$('#by').blur(function(){
			if($("#debit_account").val()=='')  $('#by').val('');
			$(this).focus();
		});
		$('#to').blur(function(){
			if($("#credit_account").val()=='')  $('#to').val('');
			$(this).focus();
		}); 
	//EOF autocomplete
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

function AddParticular(){
	var count = parseInt($("#credit_field").val())+1;
	var fields = '';
		fields += '<tr id="cRow'+count+'">';
		fields += 	'<td colspan="3">';
		fields += 		'<table cellspacing="1" cellpadding="0" border="0" width="100%" class="tabularForm">';
		fields += 			'<tr>';
		fields += 				'<td style="width:60%;"><?php echo __('Cr :')?><font color="red">*</font> <input type="text" name="data[VoucherEntry][credit]['+count+'][credit_to]" class="validate[required,custom[name]] creditor" id="to-'+count+'" autocomplete="false" placeholder="Party to be credited"/> <input type="hidden" name="data[VoucherEntry][credit]['+count+'][user_id]" id="credit_account-'+count+'" />';
		fields +=				'<input id="add-new-row_'+count+'" class="blueBtn add-row_user" type="button" value="Add Row"></td>';			
		fields +=				'<td style="width: 20%;">&nbsp; </td>'; 
		fields +=				'<td style="width:20%; padding-left: 75px;"><input id="credit-'+count+'" type="text"  placeholder="Credit Amount" class="validate[required,custom[mandatory-enter]] creditAmt cost" name="data[VoucherEntry][credit]['+count+'][credit_amount]" autocomplete="off"></td>';
		fields += 			'</tr>';
		fields += 			'<tr>';
		fields +=				'<td style="text-align: left;">';
		fields +=					'<table id="ref-area_'+count+'">';
		fields +=					'</table>';
		fields +=				'</td>';
		fields +=				'<td rowspan="1" colspan="2"></td>';
	    fields += 			'<tr>';
		fields +=				'<td valign="top" style="text-align: left;"><?php echo __('Current Balance :')?><b><span id="to_current_balance-'+count+'" >	0.00 Dr</span></td>';
		fields +=				'<td colspan="2" rowspan="2"><input type="hidden" value="0" class="blueBtn " id="no_of_field-'+count+'"/></td>';
		fields += 			'</tr>';
		fields += 		'</table>';
		fields += 	'</td>';
		fields += '</tr>';
		
		$("#credit_field").val(count);
		$("#account_form").append(fields);	
}

	$(document).on('click','.add-row_user',(function(){
		currIDCnt = $(this).attr('id').split("_")[1];
		childAddMoreCnt = $("#no_of_field-"+currIDCnt).val();
		number_of_field = parseInt(childAddMoreCnt)+1 ;
		var field = '';  
       	field +='<tr  id="row_'+currIDCnt+"-"+number_of_field+'"><td><select class="validate[required,custom[mandatory-enter]] ref-opt" id="reference_'+currIDCnt+'-'+number_of_field+'" name="data[VoucherReference]['+currIDCnt+']['+number_of_field+'][reference_type_id]"><option value="">Please Select</option><option value="2">New Reference</option><option value="3">Against Reference</option></select>';
       	field += '<input type="hidden" class="validate[required,custom[mandatory-enter]]" id="voucher_reference_id_'+currIDCnt+'-'+number_of_field+'" name="data[VoucherReference]['+currIDCnt+']['+number_of_field+'][voucher_reference_id]" >'	
       	field += '<input type="hidden" class="validate[required,custom[mandatory-enter]]" id="id_'+currIDCnt+'-'+number_of_field+'" name="data[VoucherReference]['+currIDCnt+']['+number_of_field+'][id]" ></td>';						
		field +='<td><input type="text" class="validate[required,custom[mandatory-enter]]" id="reference_no_'+currIDCnt+'-'+number_of_field+'" name="data[VoucherReference]['+currIDCnt+']['+number_of_field+'][reference_no]" placeHolder="Refrence No." "autocomplete=off"></td>';
		field +='<td><input type="text" class="validate[optional,custom[onlyNumber]] " id="credit_period_'+currIDCnt+'-'+number_of_field+'" name="data[VoucherReference]['+currIDCnt+']['+number_of_field+'][credit_period]" placeHolder="Credit Period" "autocomplete=off"></td>';
		field +='<td><input type="text" class="validate[required,custom[onlyNumber]] ref_amt cost" id="reference_amount_'+currIDCnt+'-'+number_of_field+'" name="data[VoucherReference]['+currIDCnt+']['+number_of_field+'][amount]" placeHolder="Amount" "autocomplete=off"></td>'; 
		field +='<td><select class="validate[required,custom[mandatory-select]] ref-opt" id="payment_type_'+currIDCnt+'-'+number_of_field+'" name="data[VoucherReference]['+currIDCnt+']['+number_of_field+'][payment_type]"><option value="Dr">Dr</option><option value="Cr">Cr</option></select>';
		field +='<td valign="middle" style="text-align:center;"> <a class="deleteRow" href="javascript:void(0);" id="deleteRow_'+currIDCnt+"-"+number_of_field+'"   ><?php echo $this->Html->image('/img/cross.png');?></a></td>';
      	field += '</tr>' ;
      	$("#ref-area_"+currIDCnt).append(field);
      	childAddMoreCnt = $("#no_of_field-"+currIDCnt).val(number_of_field);       	
	}));

$(document).on('click','.deleteRow',function(){
	currID = $(this).attr('id').split("_")[1];
	$("#row_"+currID).remove();
});
		
$('#username').focus( function() {
	var temp=$('#voucher_type_user').val();
	if(temp=='')
	alert('Please select Voucher Type');
	
});

function AddDebitParticular(){
	var countd = parseInt($("#debit_field").val())+1;
	var fields = '';
		fields += '<tr id="dRow'+countd+'">';
		fields += 	'<td>';
		fields += 		'<table cellspacing="1" cellpadding="0" border="0" width="100%" class="tabularForm">';
		fields += 			'<tr>';
		fields += 				'<td style="width:60%;"><?php echo __('Dr :')?><font color="red">*</font> <input type="text" name="data[VoucherEntry][debit]['+countd+'][debit_by]" class="validate[required,custom[name]] debitor" id="by-'+countd+'" autocomplete="false" placeholder="Party to be debited"/> <input type="hidden" name="data[VoucherEntry][debit]['+countd+'][account_id]" id="debit_account-'+countd+'" />';
		fields +=				'<td style="width:20%; padding-left: 75px;"><input id="debit-'+countd+'" type="text"  placeholder="Debit Amount" class="validate[required,custom[mandatory-enter]] debitAmt cost" name="data[VoucherEntry][debit]['+countd+'][debit_amount]" autocomplete="off"></td>';
		fields +=				'<td style="width:20%;">&nbsp; </td>'; 
		fields += 			'</tr>';
		fields += 			'<tr>';
		fields +=				'<td valign="top" style="text-align: left;"><?php echo __('Current Balance :')?><b><span id="by_current_balance-'+countd+'" >	0.00 Dr</span></td>';
		fields +=				'<td colspan="2" rowspan="2"><input type="hidden" value="0" class="blueBtn " id="d_no_of_field-'+countd+'"/></td>';
		fields += 			'</tr>';
		fields += 		'</table>';
		fields += 	'</td>';
		fields += '</tr>';
		
		$("#debit_field").val(countd);
		$("#debitTable").append(fields);	
}


$('.addDebitParticular').on('click',function(){ 
	var field = $("#debit_field").val();
	$("#remove-btn_debit").css("display","block");
	$('.addParticular').hide();
		$( ".debitor" ).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'NotCashBank',"admin" => false,"plugin"=>false)); ?>",
	 minLength: 1,
	 select: function( event, ui ) {
		 var idc =$(this).attr('id');
		 var rowId=idc.split('-')[1];	
		 $('#debit_account-'+rowId).val(ui.item.id); 			 
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
			          if(data.acountType == 'Dr')
			          { 
			        	$("#by_current_balance-"+rowId).html('<font color="red">'+data.credit+'</font>');
			          }else{
		        		$("#by_current_balance-"+rowId).html(data.credit); 
			          } 

			          $('#by-'+field).keydown(function(){
							$("#debit_account").val('');	 
							$("#debit").val('');
							$("#credit-"+field).val('');
						}); 
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
		$(".debitor").focus().attr('placeHolder','Party to be debited');
});

function removeRowDebit(){
	$(".formError").remove();
	 	var number_of_field = parseInt($("#debit_field").val());
	    $("#debit_field").val(number_of_field-1);
	   	$("#dRow"+number_of_field).remove();
		if (parseInt($("#debit_field").val()) == 1){
			$('.addParticular').show();
		 $("#remove-btn_debit").css("display","none");
	}
}

function removeRowCredit(){
	$(".formError").remove();
	 	var number_of_field = parseInt($("#credit_field").val());
	    $("#credit_field").val(number_of_field-1);
	   	$("#cRow"+number_of_field).remove();
		if (parseInt($("#credit_field").val()) == 1){
			$('.addDebitParticular').show();
		 $("#remove-btn_credit").css("display","none");		 
	}
}

$(document).ready(function(){
	$('.inputBox').keypress('',function(e) {
		var id = $(this).attr('id');
	    if(e.keyCode==13){//key enter
	    	if(id === "debit-1"){
	    		$("#to-1").focus();
	    		e.preventDefault();
	    	}else if(id === "credit-1"){
	    		$("#VoucherEntryNarration").focus();
	    		e.preventDefault();
		    }else if(id === "VoucherEntryNarration"){
	    		$("#save").focus();
	    	    e.preventDefault();
	    	}
	    }
	});
});
</script>