<?php  
echo $this->Html->script(array('bootstrap.min','bootstrap-dialog','jquery.blockUI'));
echo $this->Html->css(array('bootstrap.min.css'));
?>
<style>
.table_cell {
	width: 40%;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Batch Header Maintenance', true); ?>
	</h3>
</div>

<?php echo $this->Form->create('billings',array('action'=>'fileDailyCash','id'=>'fileDailyCash',
		'inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)));
?>

<?php if($this->Session->read('role')=='Account Manager'){?>
<div id="agentChildContentArea">
	<table style="margin: 10px; width: 90%; align: center">
		<tr>
			<td class="table_cell"><strong><?php echo __('For Break',true); ?></strong></td>
			<td class="table_cell"><?php echo $this->Form->checkbox('CashierBatch.isBreak',array('id'=>'isBreakAgent','class'=>'isBreak'));?></td>
			<?php echo $this->Form->hidden('',array('id'=>'cashier_batch_id','value'=>$cashierBatchAgentId)); ?>
		</tr>
	</table>
</div>
<div id="agentReasonContentArea">
	<table style="margin: 10px; width: 90%; align: center">
		<tr>
			<td class="table_cell"><strong><?php echo __('Reason For Break :',true); ?></strong><font color='red'>*</font></td> 
			<td><?php echo $this->Form->input('CashierBatch.remark', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'remark','type'=>'textarea','placeholder'=>'Please Enter Reason.'));?></td>
		</tr>
		<tr>
			<td class="table_cell" style="float: right"><?php echo $this->Form->button('Save',array('label'=>false,'type'=>'button','id'=>'saveReason','class' => 'blueBtn'));?>
		</tr>
	</table>
</div>
<div id="agentMainContentArea">
	<table style="margin: 10px; width: 90%; align: center">
		<tr>
			<td class="table_cell"><?php echo __('Opening Balance');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.opening_balance',array('value'=>(float)$agentOpeningBalance ?$agentOpeningBalance :0,'label'=>false,'type'=>'text','readonly'=>'readonly'));?></td>
			<?php echo $this->Form->hidden('CashierBatch.type',array('type'=>'text','id'=>'','value'=>'Agent'));?>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Transaction');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.trans_posted',array('value' => (float)$getAgentAmount[0] ?$getAgentAmount[0] :0,'label'=>false,'type'=>'text','id'=>'trans_posted','readonly'=>'readonly'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Cash Collected');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.total_received',array('value'=>(float)$getAgentAmount[1] ?$getAgentAmount[1] :0,'label'=>false,'type'=>'text','readonly'=>'readonly'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Total Expenses');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.total_refund',array('value'=>(float)$getAgentAmount[2] ?$getAgentAmount[2] :0,'label'=>false,'type'=>'text','readonly'=>'readonly'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Total Cash');?></td>
			<?php $totalAgentCash = (float)$agentOpeningBalance + ((float)$getAgentAmount[1]-(float)$getAgentAmount[2]);?>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.total_cash',array('value'=>(float)$totalAgentCash,'label'=>false,'type'=>'text','readonly'=>'readonly','id'=>'totalCash'));?></td>
		</tr>
		<tr>
			<td class="table_cell">&nbsp;</td>
			<td class="table_cell"><?php echo $this->Form->button('Save',array('label'=>false,'type'=>'button','id'=>'allSaveAgent','class' => 'blueBtn'));?>
				<?php echo $this->Form->button('Cancel',array('label'=>false,'type'=>'button','id'=>'Cancel','class' => 'blueBtn'));?>
			</td>
		</tr>
	</table>
</div>
<?php }else{?>
<div id="childContentArea">
	<table style="margin: 10px; width: 90%; align: center">
		<tr>
			<td class="table_cell"><strong><?php echo __('For Break',true); ?></strong></td>
			<td class="table_cell"><?php echo $this->Form->checkbox('CashierBatch.isBreak',array('id'=>'isBreak','class'=>'isBreak'));?></td>
			<?php echo $this->Form->hidden('',array('id'=>'cashier_batch_id','value'=>$cashierBatchId)); ?>
		</tr>
	</table>
</div>
<div id="reasonContentArea">
	<table style="margin: 10px; width: 90%; align: center">
		<tr>
			<td class="table_cell"><strong><?php echo __('Reason For Break :',true); ?></strong><font color='red'>*</font></td> 
			<td><?php echo $this->Form->input('CashierBatch.remark', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'remark','type'=>'textarea','placeholder'=>'Please Enter Reason.'));?></td>
		</tr>
		<tr>
			<td class="table_cell" style="float: right"><?php echo $this->Form->button('Save',array('label'=>false,'type'=>'button','id'=>'saveReason','class' => 'blueBtn'));?>
		</tr>
	</table>
</div>
<div id="mainContentArea">
	<table style="margin: 10px; width: 90%; align: center">
		<?php echo $this->Form->hidden('CashierBatch.total_amount',array('type'=>'text','id'=>'totalAmount','value'=>$collectionAmount));?>
		<tr>
			<td class="table_cell"><?php echo __('Posting Organization');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.posting_organization',array('value'=>$locations,'class' => 'validate[required,custom[mandatory-select]]','label'=>false,'id'=>'posting_organization','readonly'=>'readonly'));?></td>
			<?php echo $this->Form->hidden('',array('id'=>'locationId','value'=>$this->Session->read('locationid'))); ?>
			<?php echo $this->Form->hidden('CashierBatch.date',array('value' => $currentDate,'label'=>false,'id'=>'date'));?>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Batch ID');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.batch_number',array('value' => $batchId,'label'=>false,'type'=>'text','id'=>'batch_number','readonly'=>'readonly'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Transaction');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.trans_posted',array('value' => $noOfTransactions,'label'=>false,'type'=>'text','id'=>'trans_posted','readonly'=>'readonly'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Default Svc. Date');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.default_svc_date',array('value' => $currentDate,'label'=>false,'type'=>'text','id'=>'default_svc_date','readonly'=>'readonly'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Opening Balance');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.opening_balance',array('value'=>$openingBalance,'label'=>false,'type'=>'text','readonly'=>'readonly'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Cash Collected');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.total_received',array('value'=>$totalAmountReceived,'label'=>false,'type'=>'text','readonly'=>'readonly'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Total Refund');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.total_refund',array('value'=>$totalAmountRefund,'label'=>false,'type'=>'text','readonly'=>'readonly'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Account Room Payment (Current Shift)');?></td>
			<td class="table_cell"><?php 
			echo $this->Form->input('CashierBatch.collected_agent_amount',array('value'=>$agentAmount,'label'=>false,'type'=>'text','readonly'=>'readonly','id'=>'collectedAgentAmount'));
			echo $this->Form->input('CashierBatch.collected_agent_amount_D',array('value'=>$agentAmount,'type'=>'hidden','label'=>false,'id'=>'collected_agent_amount_D'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Total Cash');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.total_cash',array('value'=>$totalCash,'label'=>false,'type'=>'text','readonly'=>'readonly','id'=>'totalCash'));?></td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Cash Handover To Account Room');?></td>
			<td class="table_cell">
				<?php echo $this->Form->input('CashierBatch.cash_handover',array('label'=>false,'type'=>'text','id'=>'cashHandover'));?>
				<?php echo $this->Form->input('CashierBatch.agent_id',array('type'=>'select','empty'=>'Select Collection Agent','options'=>$agentName,'class' => 'validate[required,custom[mandatory-enter]]','label'=>false,'id'=>'agentId'));?>
				<?php echo $this->Form->button('Save',array('label'=>false,'type'=>'button','id'=>'saveAgent','class'=>'blueBtn'))?><span id="showprinticon"></span>
			</td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Balance Cash Handover To Next Shift');?><font color='red'>*</font></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.handover_shift_cash',array('class' => 'validate[required,custom[onlyNumber]]','label'=>false,'type'=>'text','id'=>'cashHandoverShift'));?>
				<?php echo $this->Form->input('CashierBatch.cashier_id',array('type'=>'select','empty'=>'Select Cashier','options'=>$userName,'class' => 'validate[required,custom[mandatory-enter]]','label'=>false));?>
			</td>
		</tr>
		<tr>
			<td class="table_cell"><?php echo __('Short/Excess Amount');?></td>
			<td class="table_cell"><?php echo $this->Form->input('CashierBatch.balance_amount',array('label'=>false,'type'=>'text','id'=>'balanceAmount','readonly'=>'readonly'));?></td>
		</tr>
		<tr>
			<td class="table_cell">&nbsp;</td>
			<td class="table_cell"><?php echo $this->Form->button('Close',array('label'=>false,'type'=>'button','id'=>'allSave','class' => 'blueBtn'));?>
				<?php echo $this->Form->button('Cancel',array('label'=>false,'type'=>'button','id'=>'Cancel','class' => 'blueBtn'));?>
			</td>
		</tr>
	</table>
</div>
<?php }?>
<?php echo $this->element('alert'); ?>
<?php echo $this->Form->end(); ?>
<script>
 var httpRequestFileCashBookSet = '';
 var nothingToUpdate  = "<?php echo $nothingToUpdate;?>";
 var autologout = "<?php echo $autologout;?>"; 
 var fileDailyCashURL = "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "fileDailyCash",$autologout,"admin" => false)); ?>" ;
 
$(document).ready(function(){
	$("#saveAgent").hide();
	$("#reasonContentArea").hide();
	$("#agentReasonContentArea").hide();
	$("#isBreak").click(function(){
		  if($(this).is(":checked",true)){
				$("#reasonContentArea").show();
				$("#mainContentArea").hide();
			}else{
				$("#reasonContentArea").hide();
				$("#mainContentArea").show();
			}
	});
	$("#isBreakAgent").click(function(){
		  if($(this).is(":checked",true)){
				$("#agentReasonContentArea").show();
				$("#agentMainContentArea").hide();
			}else{
				$("#agentReasonContentArea").hide();
				$("#agentMainContentArea").show();
			}
	});
	
});
$( "#Cancel" ).click(function(){
	parent.$.fancybox.close();		
});
$( "#allSave" ).click(function(){
	
	var cashHandover = $( "#cashHandover").val();
	cashHandover = cashHandover.trim();
	if(cashHandover == ''){
		$("#agentId").removeClass("validate[required,custom[mandatory-enter]]");
	}else{
		$("#agentId").addClass("validate[required,custom[mandatory-enter]]");
	}
	var validatePerson = jQuery("#fileDailyCash").validationEngine('validate');
	if(validatePerson == true){
		saveDetails();
	}
	return validatePerson;
});

function saveDetails(){
	if(httpRequestFileCashBookSet) httpRequestFileCashBookSet.abort();
	var formData = $("#fileDailyCash").serialize();
	var httpRequestFileCashBookSet = $.ajax({
		  beforeSend: function(){
			  //loading(); // loading screen
		  },
	      url: fileDailyCashURL,
	      context: document.body,
	      data : formData, 
	      type: "POST",
	      success: function(data){ 
		      if(data == 1){ 
			      if(autologout == 'true'){			    	  
			     	parent.location.href = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'logout','true'));  ?>" ;
			      }else{
		      		parent.location.reload(true);
			      }
		      		parent.$.fancybox.close();
		       }else{
		    	  alert('Please try again');
		       }
 		  },
		  error:function(){
			alert('Please try again');
		}
	});
}

function loading(){
	 $('#mainContentArea').block({ 
       message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Initializing...</h1>', 
       css: {            
           padding: '5px 0px 5px 18px',
           border: 'none', 
           padding: '15px', 
           backgroundColor: '#ffffff', 
           '-webkit-border-radius': '10px', 
           '-moz-border-radius': '10px',               
           color: '#00000',
           'text-align':'left' 
       },
       overlayCSS: { backgroundColor: '#cccccc' } 
   }); 
}

function onCompleteRequest(){
	$('#mainContentArea').unblock(); 
}

$( document ).ajaxStart(function() {
	loading();
});
$( document ).ajaxStop(function() {
	onCompleteRequest();
});

$("#cashHandover").keyup(function(){
	if($(this).val()>0){
		$("#saveAgent").show();
	}else{
		$("#saveAgent").hide();
	}
	if (/[^0-9\.]/g.test(this.value))
   	{
     this.value = this.value.replace(/[^0-9\.]/g,'');
    }
	calculateBal();
});

$("#cashHandoverShift").keyup(function(){
	if (/[^0-9\.]/g.test(this.value))
   	{
     this.value = this.value.replace(/[^0-9\.]/g,'');
    }
	calculateBal();
});

function calculateBal(){
	var cashHandover = parseInt($("#cashHandover").val()!='' ? $("#cashHandover").val() : 0);
	var cashHandoverShift = parseInt($("#cashHandoverShift").val()!='' ? $("#cashHandoverShift").val() : 0);
	var totalCash = $("#totalCash").val();
	var balanceAmount = totalCash - cashHandover - cashHandoverShift;
	$("#balanceAmount").val(balanceAmount);
}

$("#saveAgent").click(function()
		{
			var agentId = $('#agentId').val(); 
			var amountAgent = $('#cashHandover').val();
			$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'getAgentPV'));?>',
			data: {agentId : agentId,amountAgent : amountAgent},
			type: "POST",
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success:function(data){
			var data=data.split("~~");
		
				$('#msg').html(data[0]);
				$('#msg').fadeOut( 5000 );
				$('#busy-indicator').hide();
				if (data[0]) {
					var totalCash = $("#totalCash").val();
					var totalRemainingAmount = parseInt(totalCash - data[0]);
					$("#totalCash").val(totalRemainingAmount);
					$("#cashHandover").val('');
					var totalAgentCash = $("#collectedAgentAmount").val();
					var totalAmountAgent = parseInt(data[0] + totalAgentCash);
					$("#collectedAgentAmount").val(totalAmountAgent);
					$("#collected_agent_amount_D").val(totalAmountAgent);
					$("#agentId").val('');
					var lastvoucherid=data[1];
					var printlink="/hope/accounting/printPaymentVoucher/"+lastvoucherid;
					
			   window.open(printlink, "_blank", "toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200");
					   
				
		           // return false;
		        }
				//$('#msg').show();
			}
			});
		});

$("#saveReason").click(function()
		{
			var id = $('#cashier_batch_id').val(); 
			var remark = $('#remark').val();
			if(remark == ''){
				alert("Please Enter Reason");
				return false;
			}
			$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'updateReason'));?>',
			data: {id : id,remark : remark},
			type: "POST",
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success:function(data){
				$('#msg').html(data);
				$('#msg').fadeOut( 5000 );
				$('#busy-indicator').hide();
				if (data == 1) { 
					 parent.location.reload();
		        }
			}
			});
		});

$( "#allSaveAgent" ).click(function(){
	saveAgentDetails();
});

function saveAgentDetails(){
	var fileDailyCashURL = "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "fileDailyCash",$autologout,"admin" => false)); ?>" ;
	var formData = $("#fileDailyCash").serialize();
	var httpRequestFileCashBookSet = $.ajax({
		  beforeSend: function(){
			  //loading(); // loading screen
		  },
	      url: fileDailyCashURL,
	      context: document.body,
	      data : formData, 
	      type: "POST",
	      success: function(data){ 
		      if(data == 1){ 
			      if(autologout == 'true'){			    	  
			    	 parent.location.href = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'logout','true'));  ?>" ;
			      }else{
		      		parent.location.reload(true);
			      }
		      	  parent.$.fancybox.close();
		       }else{
		    	  alert('Please try again');
		       }
 		  },
	});
}
</script>
