<?php
     echo $this->Html->script(array('jquery.fancybox-3.2.0.js'));
	 echo $this->Html->css(array('jquery.fancybox-3.2.0.css')); ?>



<style>
progress[value]::-webkit-progress-value::before {
  content: '80%';
  position: absolute;
  right: 0;
  top: -125%;
} 

.htmlContainer{
    left: 50%;
    margin: -100px 0 0 -150px;
    position: absolute;
    top: 25%;
    
}

#htmlContainer{
	min-height:800px;
}


.a{
 color:palevioletred;
text-align: center;

}

</style>
<?php  

//echo $this->Html->css(array('internal_style.css'  ));

//echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js','ui.datetimepicker.3.js','default'));
				
?>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
	<tr>
		<td valign="top" width="5%"><?php //echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
	<?php
	
	if($rolename=="Management")
	{?>
	<table cellspacing="0" cellpadding="0" width="99%" align="center">
		<tr>
			<td><b><?php echo __('Ledger : '); echo ucwords($userName['Account']['name']);?></b></td>
			<td align="right">
				<?php $from1=explode(' ',$from);echo $from1[0]; echo "  To ";  $to1=explode(' ',$to);echo $to1[0];?>
			</td>
		</tr>
	</table>
	
	<table class="tabularForm" width="99%" align="center" cellspacing="1">
		<thead>
			<tr class="row_gray">
				<th style="width:10%"><?php echo __('Date');?></th>
				<th style="width:30%"><?php echo __('Particulars');?></th>
				<th style="width:10%"><?php echo __('Voucher Type');?></th>
				<th style="width:10%"><?php echo __('Voucher No.');?></th>
				<th style="width:15%; text-align: center;"><?php echo __('Debit');?></th>
				<th style="width:15%; text-align: center;"><?php echo __('Credit');?></th>
				<th style="width:10%;"><?php echo __('Action');?></th>
			</tr>
		</thead>
	</table>
	<table class="tabularForm" width="99%" align="center" cellspacing="1" id="container-table">
		<tbody>
		<?php
		ksort($ledger);
			foreach($ledger as $key=>$entry){	
			ksort($entry);
				foreach($entry as $key=>$data){ ?>
		<tr>
		<?php if(isset($data['VoucherPayment'])){?>
			<td style="width: 11%; text-align: center;">
				<?php echo $this->DateFormat->formatDate2Local($data['VoucherPayment']['date'],Configure::read('date_format'),false); ?>
			</td>
			<td style="width: 30%; text-align: left;">
				<div style="padding-left:0px; padding-bottom:3px;">
					<?php 
						if($data['VoucherPayment']['user_id']==$userid){
							echo ucwords($data['AccountAlias']['name']);
						} elseif ($data['VoucherPayment']['account_id']==$userid){
							echo ucwords($data['Account']['name']);
						}
					?>
				</div>
				<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
				<?php if((strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager'))) || (strtolower($this->Session->read('role')) == strtolower(Configure::read('adminLabel')))){?>
					<span id="updateNarration_<?php echo $data['VoucherPayment']['id'];?>" class="updateNarration">
						<?php echo __('Narration : ').$data['VoucherPayment']['narration'];?>
					</span>
					<span class="showEditNarration" id ="showEditNarration_<?php echo $data['VoucherPayment']['id'];?>">
						<?php echo $this->Form->input('',array('id'=>'editNarration_'.$data['VoucherPayment']['id'],'type'=>'textarea','label'=>false,
						'rows'=>'3','cols'=>'1','class'=>'editNarration','value'=>$data['VoucherPayment']['narration']));
						echo $this->Form->hidden('',array('id'=>'voucherType_'.$data['VoucherPayment']['id'],'value'=>"Payment"));
						echo $this->Form->hidden('',array('id'=>'modelName_'.$data['VoucherPayment']['id'],'value'=>"VoucherPayment"));
						?>
					</span>
				<?php }else{
						echo __('Narration : ').$data['VoucherPayment']['narration'];
					}?>
				</div>
			</td>
			<td style="width: 10%; text-align: left;"><?php echo __('Payment'); ?></td>
			<td style="width: 10%; text-align: center;"><?php echo $data['VoucherPayment']['id']; ?></td>
				<?php if($data['VoucherPayment']['account_id']==$userid){ ?>
					<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
					<td style="width: 15%; text-align: right;">
						<?php 
							$credit=$credit+$data['VoucherPayment']['paid_amount'];
							echo $this->Number->currency($data['VoucherPayment']['paid_amount']);
						?>
					</td>
				<?php } elseif($data['VoucherPayment']['user_id']==$userid){?>
					<td style="width: 15%; text-align: right;">
						<?php 
							$debit=$debit+$data['VoucherPayment']['paid_amount'];
							echo $this->Number->currency($data['VoucherPayment']['paid_amount']);
						?>
					</td>
					<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
			<?php }?>
			
			<td style="width: 10%; text-align: center;">
				<?php echo $this->Html->image('print.png',
					array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printPaymentVoucher',
					$data['VoucherPayment']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
						
						if(strtolower($data['AccountAlias']['alias_name'])==Configure::read('SBIAlias') || strtolower($data['Account']['alias_name'])==Configure::read('SBIAlias')){
							echo $this->Html->image('printer_mono.png',
						array('escape' => false,'title'=>'RTGS Remittance Print','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printRtgsRemittance',
						$data['Account']['system_user_id'],$data['Account']['user_type'],$data['VoucherPayment']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,height=500,left=200,top=200');  return false;"));
						}
				?>	
				<?php /* echo $this->Html->image('print.png',
					array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printCheque',
					$data['VoucherPayment']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200');  return false;")); */
				?>
				<?php 
				if($userType == 'Consultant' && $data['VoucherPayment']['type']=='USER'){
					echo $this->Html->link(__('Pick'), 'javascript:void(0);', array('title'=>'Pick','class'=>'blueBtn pick',
						'id'=>'pick_'.$data['VoucherPayment']['id']));
				}?>
				<?php
					if($this->Session->read('role')=='Admin' || (strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager')))){
						echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action'=>'payment_voucher',$data['VoucherPayment']['id']),
							array('escape'=>false,'title'=>'View','alt'=>'View'));
						echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action'=>'voucher_delete',$data['VoucherPayment']['id']),
						array('escape'=>false,'title'=>'Delete','alt'=>'Delete'),__('Are you sure?', true));
					}?>
			</td>
		<?php }
		
		//for Reciept data
		if(isset($data['AccountReceipt'])){ ?>
			<td style="width: 11%; text-align: center;">
				<?php echo $this->DateFormat->formatDate2Local($data['AccountReceipt']['date'],Configure::read('date_format'),false); ?>
			</td>
			<td style="width: 30%; text-align: left;">
				<div style="padding-left:0px; padding-bottom:3px;">
					<?php 
						if($data['AccountReceipt']['user_id']==$userid){
							echo ucwords($data['AccountAlias']['name']);
						}elseif($data['AccountReceipt']['account_id']==$userid){
							echo ucwords($data['Account']['name']);
						}
					?>
				</div>
				
				<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
				<?php if((strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager'))) || (strtolower($this->Session->read('role')) == strtolower(Configure::read('adminLabel')))){?>
					<span id="updateNarration_<?php echo $data['AccountReceipt']['id'];?>" class="updateNarration">
						<?php echo __('Narration : ').$data['AccountReceipt']['narration'];?>
					</span>
					<span class="showEditNarration" id ="showEditNarration_<?php echo $data['AccountReceipt']['id'];?>">
						<?php 
							echo $this->Form->input('',array('id'=>'editNarration_'.$data['AccountReceipt']['id'],'type'=>'textarea','label'=>false,
							'rows'=>'3','cols'=>'1','class'=>'editNarration','value'=>$data['AccountReceipt']['narration']));
							echo $this->Form->hidden('',array('id'=>'voucherType_'.$data['AccountReceipt']['id'],'value'=>"Receipt"));
							echo $this->Form->hidden('',array('id'=>'modelName_'.$data['AccountReceipt']['id'],'value'=>"AccountReceipt"));
						?>
					</span>
					<?php }else{
						echo __('Narration : ').$data['AccountReceipt']['narration'];
					}?>
				</div>
			</td>
			<td style="width: 10%; text-align: left;"><?php echo __('Receipt'); ?></td>
			<td style="width: 10%; text-align: center;"><?php echo $data['AccountReceipt']['id'];?></td>
			<?php if($data['AccountReceipt']['user_id']==$userid){ ?>
				<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
				<td style="width: 15%; text-align: right;">
					<?php $credit=$credit+$data['AccountReceipt']['paid_amount'];
						echo $this->Number->currency($data['AccountReceipt']['paid_amount']);?>
				</td>
			<?php } elseif($data['AccountReceipt']['account_id']==$userid){?>
				<td style="width: 15%; text-align: right;">
					<?php 
					if(isset($data['AccountReceipt']['paid_amount'])){
						$debit=$debit+$data['AccountReceipt']['paid_amount'];
						echo $this->Number->currency($data['AccountReceipt']['paid_amount']);
					}else{
						$debit=$debit+$data['0']['paid_amount'];
						echo $this->Number->currency($data['0']['paid_amount']);
					}?>
				</td>
				<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
			<?php }?>
				
			<td style="width: 10%; text-align: center;">
				<?php echo $this->Html->image('print.png',
							array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printReceiptVoucher',
							$data['AccountReceipt']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
							?>	
				<?php if($this->Session->read('role')=='Admin' || (strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager')))){
					echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action'=>'account_receipt',$data['AccountReceipt']['id']),
						array('escape'=>false,'title'=>'View','alt'=>'View'));
					echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action'=>'receipt_delete',$data['AccountReceipt']['id']),
						array('escape'=>false,'title'=>'Delete','alt'=>'Delete'),__('Are you sure?', true));
				}?>
			</td>
		<?php }
		
			//for contra data
			if(isset($data['ContraEntry'])){?>
			<td style="width: 11%; text-align: center;">
				<?php echo $this->DateFormat->formatDate2Local($data['ContraEntry']['date'],Configure::read('date_format'),false); ?>
			</td>
			<td style="width: 30%; text-align: left;">
				<div style="padding-left:0px;padding-bottom:3px;">
					<?php
						if($data['ContraEntry']['user_id']==$userid){
							echo ucwords($data['AccountAlias']['name']);
						}elseif($data['ContraEntry']['account_id']==$userid){
							echo ucwords($data['Account']['name']);
						}
					?>
				</div>
				<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
				<?php if((strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager'))) || (strtolower($this->Session->read('role')) == strtolower(Configure::read('adminLabel')))){?>
					<span id="updateNarration_<?php echo $data['ContraEntry']['id'];?>" class="updateNarration">
						<?php echo __('Narration : ').$data['ContraEntry']['narration'];?>
					</span>
					<span class="showEditNarration" id ="showEditNarration_<?php echo $data['ContraEntry']['id'];?>">
						<?php 
							echo $this->Form->input('',array('id'=>'editNarration_'.$data['ContraEntry']['id'],'type'=>'textarea','label'=>false,
							'rows'=>'3','cols'=>'1','class'=>'editNarration','value'=>$data['ContraEntry']['narration']));
							echo $this->Form->hidden('',array('id'=>'voucherType_'.$data['ContraEntry']['id'],'value'=>"Contra"));
							echo $this->Form->hidden('',array('id'=>'modelName_'.$data['ContraEntry']['id'],'value'=>"ContraEntry"));
						?>
					</span>
					<?php }else{
						echo __('Narration : ').$data['ContraEntry']['narration'];
					}?>
				</div>
			</td>
			<td style="width: 10%; text-align: left;"><?php echo __('Contra'); ?></td>
			<td style="width: 10%; text-align: center;">
				<?php echo $data['ContraEntry']['id']; ?>
			</td>
				<?php if($data['ContraEntry']['user_id']==$userid){ ?>
					<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
					<td style="width: 15%; text-align: right;">
						<?php 
							$credit=$credit+$data['ContraEntry']['debit_amount'];
							echo $this->Number->currency($data['ContraEntry']['debit_amount']);
						?>
					</td>
				<?php } elseif($data['ContraEntry']['account_id']==$userid){?>
					<td style="width: 15%; text-align: right;">
						<?php 
							$debit=$debit+$data['ContraEntry']['debit_amount'];
							echo $this->Number->currency($data['ContraEntry']['debit_amount']);
						?>
					</td>
					<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
				<?php }?>
			<td style="width: 10%; text-align: center;">
				<?php echo $this->Html->image('print.png',
						array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printContraVoucher',
						$data['ContraEntry']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
				?>	
				<?php if($this->Session->read('role')=='Admin' || (strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager')))){
					echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action'=>'contra_entry',$data['ContraEntry']['id']),
						array('escape'=>false,'title'=>'View','alt'=>'View'));
					echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action'=>'contra_delete',$data['ContraEntry']['id']),
						array('escape'=>false,'title'=>'Delete','alt'=>'Delete'),__('Are you sure?', true));
				}?>
			</td>
		<?php }
		
		//for journal entry
		if(isset($data['VoucherEntry'])){?>
			<td style="width: 11%; text-align: center;">
				<?php echo $this->DateFormat->formatDate2Local($data['VoucherEntry']['date'],Configure::read('date_format'),false); ?></td>
			<td style="width: 30%; text-align: left;">
				<div style="padding-left:0px;padding-bottom:3px;">
					<?php 
						if($data['VoucherEntry']['user_id']==$userid){
							echo ucwords($data['AccountAlias']['name']);
						}elseif($data['VoucherEntry']['account_id']==$userid){
							echo ucwords($data['Account']['name']);
						}
					?>
				</div>
				<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
				<span id="updateNarration_<?php echo $data['VoucherEntry']['id'];?>" class="updateNarration">
					<?php echo __('Narration : ').$data['VoucherEntry']['narration'];?>
				</span>
				<span class="showEditNarration" id ="showEditNarration_<?php echo $data['VoucherEntry']['id'];?>">
					<?php 
						echo $this->Form->input('',array('id'=>'editNarration_'.$data['VoucherEntry']['id'],'type'=>'textarea','label'=>false,
						'rows'=>'3','cols'=>'1','class'=>'editNarration','value'=>$data['VoucherEntry']['narration']));
						echo $this->Form->hidden('',array('id'=>'voucherType_'.$data['VoucherEntry']['id'],'value'=>"Journal"));
						echo $this->Form->hidden('',array('id'=>'modelName_'.$data['VoucherEntry']['id'],'value'=>"VoucherEntry"));
					?>
				</span>
			</div>
			</td>
			<td style="width: 10%; text-align: left;"><?php echo 'Journal'; ?></td>
			<td style="width: 10%; text-align: center;"><?php echo $data['VoucherEntry']['id'];?></td>

			<!-- for owners capital account in cashier excess amount in credit side n cash amount debit side by amit jain -->
			<?php if($data['AccountAlias']['name'] == Configure::read('owners_capital_account')){?>
				<?php if($data['VoucherEntry']['account_id']==$userid){ ?>
						<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
						<td style="width: 15%; text-align: right;">
							<?php 
								$credit=$credit+$data['VoucherEntry']['debit_amount'];
								echo $this->Number->currency(round($data['VoucherEntry']['debit_amount']));
							?>
						</td>
				<?php } elseif($data['VoucherEntry']['user_id']==$userid){?>
						<td style="width: 15%; text-align: right;">
							<?php 
								$debit=$debit+$data['VoucherEntry']['debit_amount'];
								echo $this->Number->currency(round($data['VoucherEntry']['debit_amount']));
							?>
						</td>
						<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
				<?php }
				}else{
					if($data['VoucherEntry']['user_id']==$userid){ ?>
						<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
						<td style="width: 15%; text-align: right;">
						<?php
							if(!isset($data['0']['total'])){
								$credit=$credit+$data['VoucherEntry']['debit_amount'];
								echo $this->Number->currency(round($data['VoucherEntry']['debit_amount']));
							}else{
								$credit=$credit+$data['0']['total'];
								echo $this->Number->currency(round($data['0']['total']));
							}
						?>
						</td>
				<?php } elseif($data['VoucherEntry']['account_id']==$userid){?>
						<td style="width: 15%; text-align: right;">
							<?php
							if(!isset($data['0']['total'])){
								$debit=$debit+$data['VoucherEntry']['debit_amount'];
								echo $this->Number->currency(round($data['VoucherEntry']['debit_amount']));
							}else{
								$debit=$debit+$data['0']['total'];
								echo $this->Number->currency(round($data['0']['total']));
							}
							?>
						</td>
						<td style="width: 15%; text-align: right;"><?php echo " ";?></td>
				 <?php }
					}?>
				<td style="width: 10%; text-align: center;">
				
				<?php 
				if($data['VoucherEntry']['type']!='Discount' && $data['VoucherEntry']['type']!='Tds' && $data['VoucherEntry']['type']!='PurchaseOrder'){
					echo $this->Html->image('print.png',
	   				array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printJournalVoucher',
     				$data['VoucherEntry']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
				}
					
				?>	
				<?php 
						 if($data['VoucherEntry']['type']!='Discount' && !empty($data['VoucherEntry']['patient_id'])){
							echo $url = $this->Html->link($this->Html->image('icons/view-icon.png'),
										array('action' =>'journal_entry_new',$data['VoucherEntry']['patient_id']),
										array('escape'=>false,'title'=>'View','alt'=>'View'));
						}else{
					 		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' =>'journal_entry',$data['VoucherEntry']['id']), 
								array('escape'=>false,'title'=>'View','alt'=>'View')); 
						} 
					 if($this->Session->read('role')=='Admin' || (strtolower($this->Session->read('role')) == strtolower(Configure::read('account_manager')))){
							if(!empty($data['VoucherEntry']['batch_identifier'])){
									if($data['VoucherEntry']['type']=='PurchaseOrder'){
										echo $url = $this->Html->link($this->Html->image('icons/view-icon.png'),
												array('action' =>'purchase_entry',$data['VoucherEntry']['user_id'],$data['VoucherEntry']['batch_identifier'],$data['VoucherEntry']['type']),
												array('escape'=>false,'title'=>'View','alt'=>'View'));
									}else{
										echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action'=>'editJournalEntry',$data['VoucherEntry']['batch_identifier']),
												array('escape'=>false,'title'=>'View','alt'=>'View'));
									}
							}
					   		echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action'=>'journal_delete',$data['VoucherEntry']['id']),
					   		 	array('escape'=>false,'title'=>'Delete','alt'=>'Delete'),__('Are you sure?', true));
					}else{
						if($data['VoucherEntry']['type']=='PurchaseOrder'){
							echo $url = $this->Html->link($this->Html->image('icons/view-icon.png'),
								array('action' =>'purchase_entry',$data['VoucherEntry']['user_id'],$data['VoucherEntry']['batch_identifier'],$data['VoucherEntry']['type']),
								array('escape'=>false,'title'=>'View','alt'=>'View'));
						}
					}?>
		   		</td>
			<?php }
			} 
		}
			 // if no data to display...	
		if(empty($ledger)){?>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7"><?php echo "No Records Found"?></td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
		<?php } ?>
	</table>

	<table class="tabularForm" width="99%" align="center" cellspacing="1">
		<tr>
			<td colspan="4" style="text-align: right; width: 60%;"><?php echo __('Opening Balance :');?></td>
		<?php if(empty($opening)){?>
			<td width="15%"><?php echo " ";?></td>		
			<td width="15%"><?php echo " ";?></td>
			<td width="10%"><?php echo " ";?></td>
		<?php }else{
			if($type=='Dr'){
				$close=($opening+$debit)-$credit;?>
				<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$opening).' Dr';?></td>
				<td width="15%"><?php echo " ";?></td>
				<td width="10%"><?php echo " ";?></td>		
			<?php }elseif($type=='Cr'){
				$close=($opening+$credit)-$debit;?>
				<td width="15%"><?php echo " ";?></td>
				<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$opening).' Cr';?></td>
				<td width="10%"><?php echo " ";?></td>				
			<?php }	
			}?>
		</tr>
		<tr class="row_gray">
			<td colspan="4" style="text-align: right; width: 60%;"><?php echo __('Current Balance :');?></td>
			<td width="15%" style="text-align: right;">
				<?php 
					if(!empty($debit)){
						echo $this->Number->currency((double)$debit).' Dr';
					}else{
						echo " ";
					}
				?>
			</td>
			
			<td width="15%" style="text-align: right;">
				<?php 
					if(!empty($credit)){
						echo $this->Number->currency((double)$credit).' Cr';
					}else{
						echo " ";
					}
				?>
			</td>
			<td width="10%"><?php echo " ";?></td>
		</tr>
		
		<tr>
		<td colspan="4" style="text-align: right; width: 60%;"><?php echo __('Closing Balance :');?></td>
		<?php 
			if(empty($opening)){
				$close=$credit-$debit;
				if(empty($close)){?>
					<td width="15%"><?php echo " ";?></td>
					<td width="15%"><?php echo " ";?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }elseif($close<0){ ?>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency(-((double)$close)).' Dr'?></td>
					<td width="15%"><?php echo " ";?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }else{ ?>
					<td width="15%"><?php echo " ";?></td>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$close).' Cr'?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php } 
				}elseif($close==$opening){
				if($type=='Dr'){?>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$close).' Dr'?></td>
					<td width="15%"><?php echo " ";?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }elseif($type=='Cr'){?>
					<td width="15%"><?php echo " ";?></td>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$close).' Cr'?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }
				}elseif($close>0){
				if($type=='Dr'){?>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$close).' Dr'?></td>
					<td width="15%"><?php echo " ";?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }elseif($type=='Cr'){?>
					<td width="15%"><?php echo " ";?></td>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)$close).' Cr'?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }
				}elseif($close<0){
				if($type=='Dr'){?>
					<td width="15%"><?php echo " ";?></td>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)-($close)).' Cr'?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }elseif($type=='Cr'){?>
					<td width="15%" style="text-align: right;"><?php echo $this->Number->currency((double)-($close)).' Dr'?></td>
					<td width="15%"><?php echo " ";?></td>
					<td width="10%"><?php echo " ";?></td>
				<?php }
			} ?>
		</tr> 
		</tbody> 
	</table>
	<?php } ?>
</td>
</tr>
</table>
<div id="htmlContainer" class="htmlContainer"> 
<?php //echo $this->Html->image('icons/loading-bar.gif',array('')); 

$permissions = $this->Session->read('hasPermissions'); 
?>


<script>
 	<?php
	//$permissions = $this->Session->read('hasPermissions'); 
 	if($permissions === 'yes'){ ?>
 
		/* $.ajax({
			 xhr: function()
			 {
				   var xhr = new window.XMLHttpRequest();
				   //Upload progress
				   xhr.upload.addEventListener("progress", function(evt){
					 if (evt.lengthComputable) {
					   var percentComplete = evt.loaded / evt.total;
					   //Do something with upload progress  
				       $("#dvProgressPrcent").html(percentComplete + "%"); 
					}
				  }, false);
				  //Download progress
				xhr.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
					  var percentComplete = evt.loaded / evt.total;
					  //Do something with download progress  
				       $("#dvProgressPrcent").html(percentComplete + "%"); 
					}
				  }, false);
				  return xhr;
			},
			type: 'POST',
			url: "<?php // echo $this->Html->url(array('controller'=>'Landings','action'=>'loadPermissions')); ?>", 
			data: {},
		    success: function(data){
			  //Do something success-is
			  $("#htmlContainer").html(data).fadeOut('slow');	  
			}
		  });*/

		  /*$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'Landings', "action" => "loadPermissions", "admin" => false)); ?>" ,
			  async:true,
			  success: function(data){
				  $("#htmlContainer").removeClass('htmlContainer');
				  $("#htmlContainer").html(data);		 
			  }
		});		*/
			
	  <?php   } ?>

	  
	 

	  $( document ).ready(function() {
		 
		 <?php if(!empty($today)){?>
		  var date = "<?php echo date('Y-m-d');?>";
		 	/*$.fancybox({
		                   'autoDimensions': false, 
		                   'minHeight': 'auto',
		                   'minWidth':  '500px',
		                   'transitionIn' : 'fade',
		                   'transitionOut' : 'fade',
		                   'type' : 'ajax',
		                   'hideOnOverlayClick':false,
		                   'showCloseButton':true,
		                   'scrollOutside': false,
		                   'href' : "<?php echo $this->Html->url(array("controller" => "Messages", "action" => "getTodaysMessage")); ?>"+'/'+date,
		                   'onClosed':function(){
		                   	
		                   } 
			}); */

			 urlString = "<?php echo $this->Html->url(array("controller" => "Messages", "action" => "getTodaysMessage")); ?>"+'/'+date
			open_fancybox(urlString);		
		     <?php }?>
		  	

	  	function open_fancybox(urlstring){ 
			$.fancybox.open({
				src  : urlstring,
				type : 'iframe',
			}) ;
		 
		}
	   });
			
</script>
</div>

