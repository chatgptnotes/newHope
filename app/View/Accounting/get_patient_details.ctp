<div class="inner_title">
	<h3>
		<?php echo __('Patient Ledger Vouchers'); ?>
	</h3>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Patient_voucher',array('id'=>'patientVoucher','url'=>array('controller'=>'Accounting','action'=>'get_patient_details',
		'admin'=>false),));?>
<table border="0" cellpadding="2" cellspacing="0" align="center">
	<tbody>
		<tr class="row_title">
			<td align="center"><strong><?php echo __('Patient Name / ID');?> </strong><font color='red'>*</font></td>
			<td>
				<?php echo $this->Form->input('Voucher.name',array('id'=>'user','label'=>false,'div'=>false,'type'=>'text','autocomplete'=>'off',
					'class' => 'validate[required,custom[mandatory-enter]]','style'=>"width:230px"));
					echo $this->Form->hidden('Voucher.user_id',array('id'=>'user_id'));?>
			<td>
				<?php echo $this->Form->input('Voucher.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false,
						'div' => false, 'error' => false,'placeholder'=>'From','readonly'=>'readonly'));?>
			</td>
			<td>
				<?php echo $this->Form->input('Voucher.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 
						'div' => false, 'error' => false,'placeholder'=>'To','readonly'=>'readonly'));?>
			</td>
			<td>
				<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'search'));?>
				<?php if(!empty($userid)){?>
				<td>
					<?php echo $this->Html->link('Print','javascript:void(0)',array('escape' => false,'class'=>'blueBtn printButton',
							'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting',
							'action'=>'print_patient_ledger','?'=>array('user_id'=>$userid,'from'=>$from,'to'=>$to)))."',
						'_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));?>
				</td>
				<?php }?>
		</tr>
	</tbody>
</table>
<?php  echo $this->Form->end();?>
<div class="clr inner_title" style="text-align: right;"></div>

<table align="center" style="margin-top: 10px" width="100%">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
<?php if($click==1){?>
<table cellspacing="0" cellpadding="0" width="99%" align="center">
		<tr>
			<td><b><?php echo __('Ledger : '); echo ucwords($userName['Patient']['lookup_name']);?></b></td>
			<td align="right"><?php $from1=explode(' ',$from); echo $from1[0];
				echo "  To ";  $to1=explode(' ',$to); echo $to1[0];?>
			</td>
		</tr>
	</table>
	<table class="formFull" width="99%" align="center" cellspacing="0">
		<tr class="row_gray">
			<th class="tdLabel"><?php echo __('Date');?></th>
			<th class="tdLabel"><?php echo __('Particulars');?></th>
			<th class="tdLabel"><?php echo __('Voucher Type');?></th>
			<th class="tdLabel"><?php echo __('Voucher Number');?></th>
			<th class="tdLabel"><?php echo __('Debit');?></th>
			<th class="tdLabel"><?php echo __('Credit');?></th>
			<th class="tdLabel"><?php echo __('Print');?></th>
		</tr>

	<?php 
	$toggle=0;$row=0;
	foreach($data as $data){
		if($toggle == 0) {
			echo "<tr>";
			$toggle = 1;
		}else{
			echo "<tr class='row_gray'>";
			$toggle = 0;
		}?>
		<?php if($data['VoucherLog']['type'] == "FinalDischarge"){?>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['VoucherLog']['create_time'],Configure::read('date_format'),false); ?></td>
			<td class="tdLabel"><?php echo $userName['Patient']['lookup_name'];?></td>
			<td class="tdLabel"><?php echo 'Journal'; ?></td>
			<td class="tdLabel"><?php echo $data['VoucherLog']['billing_id'];?>
			<?php $debit=$debit+$data['VoucherLog']['debit_amount'];?>
			<td class="tdLabel"><?php echo $this->Number->currency($data['VoucherLog']['debit_amount']) ; ?></td>
			<td><?php  echo " ";?></td>	
			<td align="center">
			<?php echo $this->Html->image('print.png',array('escape' => false,
					'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting',
					'action'=>'printPatientJournalVoucher','?'=>array('from'=>$from,'to'=>$to,'user_id'=>$data['VoucherLog']['patient_id'])))."',
					'_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?>	
			<?php echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' =>'patient_journal_voucher',
					$data['VoucherLog']['patient_id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));?>
		   <?php //echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'patientLedger_delete',
			//$data['Billing']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));?>
			</td> 
		<?php }
 		if($data['AccountReceipt']){ ?>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['AccountReceipt']['date'],Configure::read('date_format'),false); ?></td>
			<td class="tdLabel"><?php echo $data['Account']['name'];?></td>
			<td class="tdLabel"><?php echo 'Receipt'; ?></td>
			<td class="tdLabel"><?php echo $data['AccountReceipt']['id'];?>
			<td><?php  echo " ";?></td>	
			<?php $credit=$credit+$data['AccountReceipt']['paid_amount'];?>
			<td class="tdLabel"><?php echo $this->Number->currency($data['AccountReceipt']['paid_amount']) ; ?></td>
			<td align="center">
			<?php echo $this->Html->image('print.png',array('escape' => false,
					'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting',
					'action'=>'printReceiptVoucher',$data['AccountReceipt']['id']))."',
					'_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?>	
			<?php //echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' =>'account_receipt',$data['AccountReceipt']['id']),
			//array('escape' => false,'title' => 'View', 'alt'=>'View'));
			//if($data['AccountReceipt']['billing_id'] != null){
		    //echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'receipt_delete',
			//$data['AccountReceipt']['id'],$data['AccountReceipt']['paid_amount'],$data['AccountReceipt']['billing_id']),
			//array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));?>
			<?php //}?>
			</td>
		<?php } 
			if($data['VoucherPayment']){ ?>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['VoucherPayment']['date'],Configure::read('date_format'),false); ?></td>
			<td class="tdLabel"><?php echo $data['Account']['name'];?></td>
			<td class="tdLabel"><?php echo 'Payment'; ?></td>
			<td class="tdLabel"><?php echo $data['VoucherPayment']['id'];?>
			<?php $debit=$debit+$data['VoucherPayment']['paid_amount'];?>
			<td class="tdLabel"><?php echo $this->Number->currency($data['VoucherPayment']['paid_amount']) ; ?></td>
			<td><?php  echo " ";?></td>	
			<td align="center">
			<?php echo $this->Html->image('print.png',array('escape' => false,
			'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting',
			'action'=>'printPaymentVoucher',$data['VoucherPayment']['id']))."',
			'_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?>	
			<?php //echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' =>'payment_voucher',
			//$data['VoucherPayment']['id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));
			//if($data['AccountReceipt']['billing_id'] != null){
		   	//echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'receipt_delete',
			//$data['VoucherPayment']['id'],$data['AccountReceipt']['billing_id']), array('escape' => false,'title' => 'Delete',
			//'alt'=>'Delete'),__('Are you sure?', true));
			//}?>
			</td>
		<?php }
			if($data['VoucherEntry']['type']=='Discount' || $data['VoucherEntry']['type']=='Tds'){ ?>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['VoucherEntry']['date'],Configure::read('date_format'),false); ?></td>
			<td class="tdLabel"><?php echo $data['Account']['name'];?></td>
			<td class="tdLabel"><?php echo 'Journal'; ?></td>
			<td class="tdLabel"><?php echo $data['VoucherEntry']['id'];?>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel">
				<?php $credit=$credit+$data['VoucherEntry']['debit_amount'];
					echo $this->Number->currency($data['VoucherEntry']['debit_amount']);
				?>
			</td>
			<td class="tdLabel"><?php //echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' =>'journal_entry',
				//$data['VoucherEntry']['id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));
		   		//echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'journal_delete', $data['VoucherEntry']['id']),
				//array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true)); ?>
		   </td>
			<?php  } ?>
	<?php }//EOF forecah
	if(empty($data)){ ?>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7"><?php echo "No Records Found"?></td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<?php }?> 
			<tr><td colspan="7" style="border-top: solid 2px #3E474A;margin-bottom:-1px">&nbsp;</td></tr>			
			<tr>
				<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Opening Balance :');?></td>
				<?php if(empty($opening)){?>
				<td class="tdLabel"><?php echo " ";?></td>		
				<td class="tdLabel"><?php echo " ";?></td>
				<?php }else{
					if($type=='Dr'){
						$close=($opening+$debit)-$credit;?>
						<td class="tdLabel">
						<?php echo $this->Number->currency($opening).' Dr';?></td>
						<td class="tdLabel" ><?php echo " ";?></td>
					<?php }elseif($type=='Cr'){
						$close=($opening+$credit)-$debit;	?>
						<td class="tdLabel" ><?php echo " ";?></td>
						<td class="tdLabel" >
						<?php echo $this->Number->currency($opening).' Cr';?></td>					
					<?php }	
   					}?>
			</tr>
			<tr class="row_gray">
				<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Current Balance :');?></td>
				<td class="tdLabel">
				<?php if(!empty($debit)){
						echo $this->Number->currency($debit).' Dr';
					}else{
						echo " ";
					}?>
				</td>
				<td class="tdLabel">
				<?php if(!empty($credit)){
						echo $this->Number->currency($credit).' Cr';
					}else{
						echo " ";
					}?>
				</td>
				<td colspan="3" >&nbsp; </td>
			</tr>
			<tr>
				<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Closing Balance :');?></td>
		<?php 
		if(empty($opening)){
			$close=$credit-$debit;
			if(empty($close)){ ?>
				<td class="tdLabel"><?php echo " ";?></td>
				<td class="tdLabel"><?php echo " ";?></td><?php
			}elseif($close<0){ ?>
				<td class="tdLabel"><?php echo $this->Number->currency(-($close)).' Dr'?></td>
				<td class="tdLabel"><?php echo " ";?></td><?php 
			}else{ ?>
				<td class="tdLabel"><?php echo " ";?></td>
				<td class="tdLabel"><?php echo $this->Number->currency($close).' Cr'?></td>
			<?php } 
		}//end of if
		elseif($close==$opening){
		if($type=='Dr'){
		?>
			<td class="tdLabel"><?php echo $this->Number->currency($close).' Dr'?></td>
			<td class="tdLabel"><?php echo " ";?></td><?php
		}elseif($type=='Cr'){?>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel"><?php echo $this->Number->currency($close).' Cr'?></td>
		<?php }
		}//end  of else if
		elseif($close>0){
		if($type=='Dr'){
		?>
			<td class="tdLabel"><?php echo $this->Number->currency($close).' Dr'?></td>
			<td class="tdLabel"><?php echo " ";?></td><?php
		}elseif($type=='Cr'){?>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel"><?php echo $this->Number->currency($close).' Cr'?></td>
		<?php }
		}
		elseif($close<0){
		if($type=='Dr'){
		?>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel"><?php echo $this->Number->currency(-($close)).' Cr'?></td>
		<?php }elseif($type=='Cr'){?>
			<td class="tdLabel"><?php echo $this->Number->currency(-($close)).' Dr'?></td>
			<td class="tdLabel"><?php echo " ";?></td><?php
		}
		} ?>
		</tr>  
</table>
<?php } ?>
	</td>
</tr>
</table>
	
<script>
$(document).ready(function(){
	$("#user").focus();
	$("#from").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		//maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	 
 	$("#to").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		//maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});
	
	$( "#search" ).click(function(){ 
		 result  = compareDates($( '#from' ).val(),$( '#to' ).val(),'<?php echo $this->General->GeneralDate();?>') //function with dateformat 
		 if(!result){ 
		 	alert("To date should be greater than from date");
		 }
		 return result ;
	});

	$("#user").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","admission_id",'1',"inventory" => true,"plugin"=>false)); ?>",
		 minLength: 1, 
		 select: function( event, ui ) {
			$('#user_id').val(ui.item.id);
		},
			messages: {
		        noResults: '',
		        results: function() {}
		 }	
	});

	 jQuery("#patientVoucher").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});	
});
</script>
