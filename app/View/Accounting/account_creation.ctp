
<div class="inner_title">
	<h3>
		<?php echo __('Ledger Creation', true); ?>
	</h3>
</div>
<div class="clr">&nbsp;</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
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
	echo $this->Form->create('accounting', array('url'=>array('controller'=>'accounting','action'=>'account_creation'),
		'id'=>'Acc_details','inputDefaults' => array('label' => false,'div' => false,'error'=>false,'legend'=>false,'O'))) ;
	echo $this->Form->hidden('Account.id',array());
	echo $this->Form->hidden('Account.account_creation_type',array('value'=>'other'));
	echo $this->Form->hidden('Account.balance',array());
	if(!empty($id)){
		$readOnly = 'readonly';
	}else {
		$readOnly = '';
	}
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
		<?php  if (in_array(AuthComponent::user()['id'], [1, 644])): ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
				<tr>
					<td width="50%">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" id="boxSpace" class="tdLabel"><?php echo __("Name :");?><font color='red'>*</font></td>
								<td width="30%" valign="top" class="tdLabel">
								<?php echo $this->Form->input('Account.name', array('type'=>'text','class'=>'validate[required,custom[name]] textBoxExpnd',
										'id'=>'name','label'=>false,'div'=>false,'error'=>false,'style'=>'width:230px','autocomplete'=>'off'));?>
								</td>
							</tr>
							<?php if(!empty($id)){?>
							<tr>
								<td width="20%" id="boxSpace" class="tdLabel"><?php echo __("Employee Id :");?></td>
								<td width="30%" valign="top" class="tdLabel">
								<?php echo $this->Form->input('Account.emp_id', array('type'=>'text','id'=>'emp_id','label'=>false,'div'=>false,'readOnly'=>'readOnly',
										'class'=>'textBoxExpnd','error'=>false,'style'=>'width:230px','autocomplete'=>'off'));?>
								</td>
							</tr>
							<?php }?>
							<tr>
								<td width="20%" valign="top" class="tdLabel" id="boxSpace"><?php echo __("Group :");?><font color='red'>*</font></td>
								<td width="30%" valign="top" class="tdLabel">
								<?php echo $this->Form->input('Account.accounting_group_id', array('options'=>$result,'empty'=>'Please Select Group',
										'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'under','style'=>'width:230px;',
										'autocomplete'=>'off')); ?>
								</td>
							</tr>
							<tr>
								<td width="20%" class="tdLabel" id="boxSpace"><?php echo __("Description :");?></td>
								<td width="30%" valign="top" class="tdLabel">
								<?php echo $this->Form->input('Account.description', array('class' => 'textBoxExpnd','type'=>'textarea','rows'=>'3',
										'id'=>'description','style'=>'width:230px;','autocomplete'=>'off','placeHolder'=>'Enter Description')); ?>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="top" class="tdLabel" id="boxSpace"><?php echo __("Ask For Reference No. :");?></td>
								<td width="30%" valign="top" class="tdLabel"><?php echo $this->Form->input('Account.is_reference',array('type'=>"checkbox"));?></td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="tdLabel" id="boxSpace" width="20%"><?php echo __("Alias :");?></td>
								<td width="30%" valign="top" class="tdLabel">
								<?php echo $this->Form->input('Account.alias_name', array('readonly'=>$readOnly,'type'=>'text','class'=>'textBoxExpnd','id' => 'alias_name',
										'label'=>false,'div'=>false,'error'=>false,'style'=>'width:230px','autocomplete'=>'off','placeHolder'=>'Enter Alias Name'));?>
								</td>
							</tr>
							<tr>
								<td class="tdLabel" id="boxSpace" width="20%"><?php echo __("Account ID :");?></td>
								<td class="tdLabel" id="boxSpace" width="30%">
								<?php if($id){
									echo $this->data['Account']['account_code'];
									echo $this->Form->hidden('Account.account_code', array('type'=>'text', 'value'=>$this->data['Account']['account_code'] ));
								}else{
					 				echo $autoId ;
					 				echo $this->Form->hidden('Account.account_code', array('type'=>'text', 'value'=>$autoId ));
								}?>
								</td>
							</tr>
							<tr>
								<td class="tdLabel" id="boxSpace" width="20%"><?php echo __("Status :");?></td>
								<td class="tdLabel" id="boxSpace" width="30%">
								<?php echo $this->Form->input('Account.status', array('options'=>Configure :: read('status'),'readonly'=>'readonly',
										'style'=>'width:230px','class' => 'textBoxExpnd','id' => 'status' )); ?>
								</td>
							</tr>
							<tr>
								<td class="tdLabel" id="boxSpace" width="20%"><?php echo __("GL Code :");?></td>
								<td class="tdLabel" id="boxSpace" width="30%">
								<?php echo $this->Form->input('Account.gl_code', array('type'=>'text','class' =>'textBoxExpnd','id' =>'gl_code','label'=>false,
										'div'=>false,'error'=>false,'style'=>'width:230px','placeHolder'=>'Enter GL Code'));?>
								</td>
							</tr>
							<tr>
								<td class="tdLabel" id="boxSpace" width="20%"><?php echo __("GL Format :");?></td>
								<td class="tdLabel" id="boxSpace" width="30%">
								<?php echo $this->Form->input('Account.gl_format', array('options'=>Configure :: read('gl_format'),'empty'=>'Please Select',
										'readonly'=>'readonly','style'=>'width:230px','class'=>'textBoxExpnd','id'=>'gl_format','placeHolder'=>'Enter GL Format')); ?>
								</td>
							</tr>
							<tr>
								<td class="tdLabel" id="boxSpace" width="20%"><?php echo __("Opening Balance :");?></td>
								<?php 
								if($this->Session->read('userid')=='1'){
									$readOnly = '';
									$disabled = '';
								}else {
									$readOnly = 'readonly';
									$disabled = 'disabled';
								}?>
								
								<td class="tdLabel" id="boxSpace" width="30%">
									<?php echo $this->Form->input('Account.opening_balance',
										array('readonly'=>$readOnly,'type'=>'text','class'=>'validate[optional,custom[onlyNumber]] textBoxExpnd bal',
										'id'=>'balance','label'=>false,'div'=>false,'error'=>false,'style'=>'width:230px','autocomplete'=>'off','placeHolder'=>'Enter Opening Balance'));?>
									<?php echo $this->Form->input('Account.payment_type',array('disabled'=>$disabled,'id'=>'type_payment','type'=>'select',
										'class' =>'validate[required,custom[mandatory-select]] type_payment','options'=>array('Cr'=>"Cr",'Dr'=>'Dr'),
										'empty'=>'Please Select'));?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="refArea">
					<td>
						<table cellpadding="0" cellspacing="0" width="100%" border="0" id="ref-area" style="margin-left: 48%">
						<?php
						$cnt=0;
						if(count($dataDetail) > 0){
						foreach($dataDetail as $cnt=>$value){
				   		?>
						<tr>
							<td>
								<?php echo $this->Form->input("VoucherReference.$cnt.reference_type_id",array('value'=>$value['VoucherReference']['reference_type_id'],'id'=>"reference_.$cnt.",'type'=>'select','class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('2'=>'New Reference'),'empty'=>'Please Select'));?>
								<?php echo $this->Form->hidden("VoucherReference.$cnt.voucher_reference_id",array('id'=>"voucher_reference_id_.$cnt.",'type'=>'text','placeHolder'=>''));?>
								<?php echo $this->Form->hidden("VoucherReference.$cnt.id",array('id'=>"id_.$cnt",'type'=>'text'));?>
							</td>
							<td><?php echo  $this->Form->input("VoucherReference.$cnt.reference_no",array('value'=>$value['VoucherReference']['reference_no'],'id'=>"reference_no_.$cnt.",'type'=>'input','class' =>'validate[required,custom[mandatory-enter]]','type'=>'text','placeHolder'=>'Refrence No.','autocomplete'=>'off')); ?></td>
							<td><?php echo  $this->Form->input("VoucherReference.$cnt.credit_period",array('value'=>$value['VoucherReference']['credit_period'],'id'=>"credit_period_.$cnt.",'type'=>'input','class' =>'validate[required,custom[onlyNumber]] ','type'=>'text','placeHolder'=>'Credit Period','autocomplete'=>'off')); ?></td>
							<td><?php echo  $this->Form->input("VoucherReference.$cnt.amount",array('value'=>$value['VoucherReference']['amount'],'id'=>"reference_amount_.$cnt.",'type'=>'input','class' =>'validate[required,custom[onlyNumber]] ref_amt','type'=>'text','placeHolder'=>'Amount','autocomplete'=>'off')); ?></td>
							<td><?php echo $this->Form->input("VoucherReference.$cnt.payment_type",array('value'=>$value['VoucherReference']['payment_type'],'id'=>"payment_type_.$cnt.",'type'=>'select','class' =>'validate[required,custom[mandatory-select]] ref-optt','options'=>array('Dr'=>'Dr','Cr'=>"Cr")));?></td>
						</tr>
					<?php $cnt++; 
						}
					}else{?>
						<tr>
							<td>
								<?php echo $this->Form->input("VoucherReference.$cnt.reference_type_id",array('id'=>"reference_$cnt",'type'=>'select','class' =>'validate[required,custom[mandatory-select]] ref-opt','options'=>array('2'=>'New Reference'),'empty'=>'Please Select'));?>
								<?php echo $this->Form->hidden("VoucherReference.$cnt.voucher_reference_id",array('id'=>"voucher_reference_id_$cnt",'type'=>'text','placeHolder'=>''));?>
								<?php echo $this->Form->hidden("VoucherReference.$cnt.id",array('id'=>"id_'$cnt'",'type'=>'text'));?>
							</td>
							<td><?php echo  $this->Form->input("VoucherReference.$cnt.reference_no",array('id'=>"reference_no_$cnt",'type'=>'input','class' =>'validate[required,custom[mandatory-enter]]','type'=>'text','placeHolder'=>'Refrence No.','autocomplete'=>'off')); ?></td>
							<td><?php echo  $this->Form->input("VoucherReference.$cnt.credit_period",array('id'=>"credit_period_$cnt",'type'=>'input','class' =>'validate[required,custom[onlyNumber]] ','type'=>'text','placeHolder'=>'Credit Period','autocomplete'=>'off')); ?></td>
							<td><?php echo  $this->Form->input("VoucherReference.$cnt.amount",array('id'=>"reference_amount_$cnt",'type'=>'input','class' =>'validate[required,custom[onlyNumber]]  ref_amt','type'=>'text','placeHolder'=>'Amount','autocomplete'=>'off')); ?></td>
							<td><?php echo $this->Form->input("VoucherReference.$cnt.payment_type",array('id'=>"payment_type_$cnt",'type'=>'select','class' =>'validate[required,custom[mandatory-select]] ref-optt','options'=>array('Dr'=>'Dr','Cr'=>"Cr")));?></td>
						</tr>
						<?php }?>
					</table>
					</td>
				</tr>
				<tr>
					<td align="center"><input type="button" value="Add Row" class="blueBtn" id="add-new-row" /></td>
				</tr>
			</table>

			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
				<tr>
					<th align="left" colspan="4">Bank account details<?php echo $this->Form->hidden('HrDetail.id',array('id'=>'HrDetailId','value'=>$hrDetails['HrDetail']['id']));?></th>
				</tr>
				<tr>
					<td width="50%" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="20%" id="boxSpace" class="tdLabel">Bank name</td>
								<td width="30%" valign="top" class="tdLabel">
									<?php echo $this->Form->input('HrDetail.bank_name', array('label'=>false,'div'=>false,'id' => 'bank_name','class'=> 'textBoxExpnd',
										'value'=>$hrDetails['HrDetail']['bank_name'])); ?>
								</td>
							</tr>
							<tr>
								<td width="20%" id="boxSpace" class="tdLabel">Account number</td>
								<td width="30%" valign="top" class="tdLabel">
									<?php echo $this->Form->input('HrDetail.account_no', array('type'=>'text','label'=>false,'id' => 'account_no',
											'class'=>'textBoxExpnd validate["",custom[onlyNumber]]','value'=>$hrDetails['HrDetail']['account_no'])); ?>
								</td>
							</tr>
							<tr>
								<td width="20%" id="boxSpace" class="tdLabel">Bank pass book copy obtained :</td>
								<td width="30%" valign="top" class="tdLabel">
									<?php echo $this->Form->checkbox('HrDetail.pass_book_copy', array('style'=>'float:left','legend'=>false,'label'=>false,
											'class' => 'neft_authorized_received','checked'=>$hrDetails['HrDetail']['pass_book_copy'])); ?>
								</td>
							</tr>
							<tr>
								<td width="20%" id="boxSpace" class="tdLabel">PAN</td>
								<td width="30%" valign="top" class="tdLabel">
									<?php echo $this->Form->input('HrDetail.pan', array( 'id' => 'pan','type'=>'text', 'selected'=>'84', 'label'=> false,
											'div' => false, 'error' => false,'class' => 'textBoxExpnd','value'=>$hrDetails['HrDetail']['pan']));?>
								</td>
							</tr>	
						</table>
					</td>
					<td width="50%" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="20%" id="boxSpace" class="tdLabel">Bank Branch</td>
								<td width="30%" valign="top" class="tdLabel">
									<?php echo $this->Form->input('HrDetail.branch_name', array('label'=>false,'id' =>'branch_name','class'=>'textBoxExpnd',
										'value'=>$hrDetails['HrDetail']['branch_name'])); ?>
								</td>			
							</tr>
							<tr>
								<td width="20%" id="boxSpace" class="tdLabel">IFSC Code</td>
								<td width="30%" valign="top" class="tdLabel"><?php echo $this->Form->input('HrDetail.ifsc_code', array('type'=>'text','label'=>false,'id' => 'ifsc_code','class'=>'textBoxExpnd','maxlength'=>'11','value'=>$hrDetails['HrDetail']['ifsc_code'])); ?></td>
							</tr>
							<tr>
								<td width="20%" id="boxSpace" class="tdLabel">NEFT authorization received :</td>
								<td width="30%" valign="top" class="tdLabel">
									<?php echo $this->Form->checkbox('HrDetail.neft_authorized_received', array('style'=>'float:left','legend'=>false,'label'=>false,
											'class' => 'neft_authorized_received','checked'=>$hrDetails['HrDetail']['neft_authorized_received'])); ?>
								</td>
							</tr>  	
						</table>
					</td>
				</tr>
			</table>
			<div class="btns">
				<?php echo $this->Form->submit(__('Save'), array('class'=>'blueBtn','div'=>false,'id'=>'submit'));
					echo $this->Html->link(__('Cancel'),array('controller'=>'Accounting','action'=>'index'),array('class'=>'blueBtn','div'=>false)); ?>
			</div>
			<?php else:  ?>
			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
				<tr> 
					<td>
						<h3 style='text-align:center'> You're not authorized!  </h3>
					</td>
				</tr>

			</table>
			<?php endif;  ?>
		</td>
		
			
	</tr>
</table>
<?php echo $this->Form->end();?>
<script>
$(document).ready(function(){
	$("#name").focus().attr('placeHolder','Enter Name');
	var numbers = $("#balance").val();
	if($("#AccountIsReference").is(":checked",true) && numbers >0){
		$("#ref-area").show();
		$("#add-new-row").show();
	}else{
		$(".refArea").hide();
		$("#add-new-row").hide();
	}
	$("#submit").show();
	$(".type_payment").hide();
	
	$(document).on('keyup','.ref_amt',function(){
		refCount = 0;
		$( ".ref_amt" ).each(function( index ) {				 
			refCount += parseInt($(this).val()); 
		});
		daebi_amount =$("#balance").val();
		if(daebi_amount==refCount) {
		    $("#submit").show();
		    $("#add-new-row").hide();
		}else
		{
			$("#submit").hide();
			$("#add-new-row").show();
		}
	});
});	

$("#submit").click(function(){
	var validateForm = jQuery("#Acc_details").validationEngine('validate');
	if(validateForm == true){
		$("#submit").hide();
	}else{
		return false;
	}
});

number_of_field = 1 ; 
$("#add-new-row").click(function(){
	var field = ''; 
	 
   	field +='<tr  id="row'+number_of_field+'"><td><select class="validate[required,custom[mandatory-enter]] ref-opt" id="reference_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][reference_type_id]"><option value="">Please Select</option><option value="2">New Reference</option></select>';
   	field += '<input type="hidden" class="validate[required,custom[mandatory-enter]]" id="voucher_reference_id_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][voucher_reference_id]" >'	
   	field += '<input type="hidden" class="validate[required,custom[mandatory-enter]]" id="id_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][id]" ></td>';						
	field +='<td><input type="text" class="validate[required,custom[mandatory-enter]]" id="reference_no_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][reference_no]" placeHolder="Refrence No." "autocomplete=off"></td>';
	field +='<td><input type="text" class="validate[optional,custom[onlyNumber]] " id="credit_period_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][credit_period]" placeHolder="Credit Period" "autocomplete=off"></td>';
	field +='<td><input type="text" class="validate[required,custom[onlyNumber]]  ref_amt" id="reference_amount_'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][amount]" placeHolder="Amount" "autocomplete=off"></td>'; 
	field +='<td><select class="validate[required,custom[mandatory-select]] ref-optt" id="payment_type'+number_of_field+'" name="data[VoucherReference]['+number_of_field+'][payment_type]"><option value="Dr">Dr</option><option value="Cr">Cr</option></select>';
	field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image('/img/cross.png');?></a></td>';
  	field += '</tr>' ;
  	$("#ref-area").append(field);
  	
  	number_of_field++;
  	
});

function deletRow(id){
	refCount = 0;
	$( ".ref_amt" ).each(function( index ) {				 
		refCount -= parseInt($(this).val()); 
	});
	
	daebi_amount =$("#balance").val();
	if(daebi_amount==refCount) {
	    $("#submit").show();
	    $("#add-new-row").hide();
	}else{
		$("#submit").hide();
		$("#add-new-row").show();
	}
	
	 if(number_of_field == 1){
		 $("#submitForm").hide() ;
	 }	 
	 
	$("#row"+id).remove();
	  
  number_of_field--;
}
function toUpper(obj) {
    var mystring = obj.value;
    var sp = mystring.split(' ');
    var wl=0;
    var f ,r;
    var word = new Array();
    for (i = 0 ; i < sp.length ; i ++ ) {
        f = sp[i].substring(0,1).toUpperCase();
        r = sp[i].substring(1).toLowerCase();
        word[i] = f+r;
    }
    newstring = word.join(' ');
    obj.value = newstring;
    return true;  
}

jQuery("#Acc_details").validationEngine();

	$("#AccountIsReference").click(function(){
		  var numbers = $("#balance").val();
		  
		if($(this).is(':checked',true) && numbers > 0){
			$(".refArea").show();
			$("#add-new-row").show();
		}
		else{
			$(".refArea").hide();
			$("#add-new-row").hide();
		}
	});

	$("#balance").keyup(function(){
		 var numbers = $("#balance").val();
		if(numbers >0){	
			$(".type_payment").show();
		}else{
			$(".type_payment").hide();
		}

		if($("#AccountIsReference").is(':checked',true) && numbers >0){
			$(".refArea").show();
			$("#add-new-row").show();
		}else{
			$(".refArea").hide();
			$("#add-new-row").hide();
		}
	});

	$("#type_payment").change(function(){
		var myVal = $(this).val();
		$(".ref-optt").val(myVal);
		});
	
	$(".ref-optt").change(function(){
		var myVal = $(this).val();
		$("#type_payment").val(myVal);
		});
	
	$("#emp_id").keyup(function(){
		if (/[^0-9\.]/g.test(this.value)){
	     this.value = this.value.replace(/[^0-9\.]/g,'');
	    }
	});
</script>