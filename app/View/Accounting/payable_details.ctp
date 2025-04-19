<?php 
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>
<div class="inner_title">
	<h3>
		<?php echo __('Ledger Outstandings'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Payable_Details',array('id'=>'payableDetails','url'=>array('controller'=>'Accounting','action'=>'payable_details','admin'=>false),));?>
	<table align="center" style="margin-top: 10px" width="100%">
		<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
	<table align="center" style="margin-top: 10px">
		<tr>
			<td align="center"><strong><?php echo __('Account');?></strong>
			</td>
			<td><?php echo $this->Form->input('VoucherEntry.name',array('id'=>'user','label'=>false,'div'=>false,'type'=>'text','autocomplete'=>'off','class' => 'validate[required,custom[mandatory-enter]]','placeholder'=>'Name'));
			echo $this->Form->hidden('VoucherEntry.user_id',array('id'=>'user_id'));?>
		
			<td><?php echo __('From');?></td>
			<td><?php 
        	echo $this->Form->input('VoucherEntry.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
			</td>
			<td><?php echo __('To');?></td>
			<td><?php 
       		echo $this->Form->input('VoucherEntry.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
			</td>
			<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'search'));
			echo $this->Form->end();?>
			</td>
		</tr>
	</table>
	<?php if(!empty($payable)){?>
	<table cellspacing="0" cellpadding="0" width="80%" align="center"
		style="margin-top: 20px">
		<tr>
			<td><b><?php echo __('Ledger : '); echo $payable[0]['Account']['name'];?>
			</b></td>
			<td align="right"><?php $from1=explode(' ',$from);echo $from1[0];
			echo "  To "; $to1=explode(' ',$to);echo $to1[0];?>
			</td>
		</tr>
	</table>	
	<table class="formFull" width="80%" align="center" cellspacing="0">
		<tr class="row_gray">
			<th class="tdLabel"><?php echo __('Date');?></th>
			<th class="tdLabel"><?php echo __('Ref.No');?></th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th class="tdLabel"><?php echo __('Opening Amount');?></th>
			<th class="tdLabel"><?php echo __('Pending Amount');?></th>
			<th class="tdLabel"><?php echo __('Due On');?></th>
			<th class="tdLabel"><?php echo __('Overdue by days');?></th>
		</tr>
	<?php 
			$toggle=0;$row=0; 
		foreach($payable as $pay){
					if($toggle == 0) {
						echo "<tr>";
						$toggle = 1;
					}else{
						echo "<tr class='row_gray'>";
						$toggle = 0;
					}?>
		<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($pay['VoucherReference']['date'],Configure::read('date_format'),false); ?>
		</td>
		<td class="tdLabel"><?php
			 if(!empty($pay['VoucherReference']['reference_no'])){?>
				<?php echo $pay['VoucherReference']['reference_no'];
				echo " - ";
				echo $pay['VoucherReference']['id'];
			}
			else {
				echo $pay['VoucherReference']['id'];
			}
		?>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td class="tdLabel"><?php echo $this->Number->currency($pay['VoucherReference']['amount']); ?>
		</td>
		<td class="tdLabel">
		<?php
			$hasChild = count($pay['ReferenceChild']);
			if($hasChild > 0){
				$pendingAmt = $pay['ReferenceChild'][$hasChild-1]['pending_amount'] ;
			}else{
				$pendingAmt = $pay['VoucherReference']['amount'];
			}
			echo $this->Number->currency($pendingAmt); ?>
		</td>
		<td class="tdLabel"><?php echo date("d/m/Y",strtotime($pay['VoucherReference']['date']." +". $pay['VoucherReference']['credit_period']." Days")); ?>
		</td>
		<td class="tdLabel">
		<?php 
		$voucherDue=date("Y-m-d",strtotime($pay['VoucherReference']['date']." +". $pay['VoucherReference']['credit_period']." Days"));
		if($voucherDue>date('Y-m-d')){
		$duedate=$this->DateFormat->dateDiff(date('Y-m-d'),$voucherDue);
		echo $duedate->days;
		}
		else echo " ";
		?>
		</td>
	</tr>
		<?php 
			if($row == 0) {
			echo "<tr>";
			$row = 1;
			}
			else{
				echo "<tr class='row_gray'>";
				$row = 0;
			}?>
		<td>&nbsp;</td>
		<td class="tdLabel"><i> <?php 
			echo $this->DateFormat->formatDate2Local($pay['VoucherReference']['date'],Configure::read('date_format'),false); 
			echo " ";
			echo $pay['VoucherReference']['voucher_type'];?>
		</i></td>
		<td><i><?php echo $pay['VoucherReference']['paid_amount']?> </i></td>
		<td colspan="6">&nbsp;</td>
	</tr>
		<?php 
		//foreach for child entries
		if(is_array($pay['ReferenceChild'])){
			foreach($pay['ReferenceChild'] as $key => $child){
 				  echo "<tr>";
 				  ?>
		<td>&nbsp;</td>
		<td class="tdLabel"><i><?php 
						echo $this->DateFormat->formatDate2Local($child['date'],Configure::read('date_format'),false);
						echo " ";
				 	    echo $child['voucher_type'];?>
		</i></td>
		<td class="tdLabel"><i><?php echo $child['paid_amount'];?></i></td>
		<td colspan="6">&nbsp;</td>
	</tr>
		<?php  
				} 
			}
			 $total=$total+$pay['VoucherReference']['amount']; 
		}?>
	<tr>
		<td style="border-top: solid 2px #3E474A;">&nbsp;</td>
		<td class="tdLabel" colspan="7" style="border-top: solid 2px #3E474A;"><b><?php echo __('SubTotal');?></b></td>
	</tr>
	<tr>
		<td class="tdLabel" style="border-top: solid 2px #3E474A;"><?php $to1=explode(' ',$to);echo $to1[0];?></td>
		<td class="tdLabel" colspan="4" style="border-top: solid 2px #3E474A;"><?php echo __('Total');?></td>
		<td class="tdLabel" colspan="3" style="border-top: solid 2px #3E474A;"><?php echo $this->Number->currency($total);?></td>
		</tr>

</table>
<?php }?>
</td>
</tr>
</table>
<script>
$(document).ready(function(){
	$("#user").focus();
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	 
 	$("#to").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	}); 
	 $( "#search" ).click(function(){ 
		 result  = compareDates($( '#from' ).val(),$( '#to' ).val(),'<?php echo $this->General->GeneralDate();?>') //function with dateformat 
		 if(!result){ 
		 	alert("To date should be greater than from date");
		 }
		 return result ;
	});

	 $( "#user" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			$('#user_id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});
	 jQuery("#payableDetails").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});	
});
</script>
