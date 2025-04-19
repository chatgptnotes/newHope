<div class="inner_title">
	<h3>
		<?php echo __('Ledger Vouchers', true); ?>
	</h3>
	
	<span>
		<?php
			echo $this->Form->button(__('Export To Excel'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'excel'));
			echo $this->Form->button(__('Print'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'print'));
		?>
	</span>
</div>
<style>
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
}
.tabularForm td {
	 background: none repeat scroll 0 0 #fff !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}	
</style>
<?php 
echo $this->Html->script('topheaderfreeze') ;
?>
<table align="center" style="margin-top: 5px" width="100%">
	<tr>
		<td width="95%" valign="top">
	<?php 
	if($click==1){?>
	<table cellspacing="0" cellpadding="0" width="99%" align="center">
		<tr>
			<td><b><?php echo __('Ledger : '); echo ucwords($userName['Account']['name']);?></b></td>
			<td align="right">
				<?php $from1=explode(' ',$from);echo $from1[0]; echo "  To ";  $to1=explode(' ',$to);echo $to1[0];?>
			</td>
		</tr>
	</table>
	
	<table class="tabularForm" width="99%" align="center" cellspacing="0" >
		<thead>
			<tr class="row_gray">
				<th style="width:9%"><?php echo __('Date');?></th>
				<th style="width:30%"><?php echo __('Particulars');?></th>
				<th style="width:8%"><?php echo __('Voucher Type');?></th>
				<th style="width:9%"><?php echo __('Voucher No.');?></th>
				<th style="width:14%; text-align: center;"><?php echo __('Debit');?></th>
				<th style="width:14%; text-align: center;"><?php echo __('Credit');?></th>
				<th style="width:6%;"><?php echo __('Action');?></th>
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
				<?php echo __('Narration : ').$data['VoucherPayment']['narration'];?>
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
			?>	
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
				<?php echo __('Narration : ').$data['AccountReceipt']['narration'];?>
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
				<?php echo __('Narration : ').$data['ContraEntry']['narration'];?>
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
					<?php echo __('Narration : ').$data['VoucherEntry']['narration'];?>
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
				<?php echo $this->Html->image('print.png',
	   				array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printJournalVoucher',
     				$data['VoucherEntry']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
				?>	
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
			<td  colspan="5" style="text-align: right;" width="66%"><?php echo __('Opening Balance :');?></td>
		<?php if(empty($opening)){?>
			<td  width="14%"><?php echo " ";?></td>		
			<td  width="14%"><?php echo " ";?></td>
			<td  width="6%"><?php echo " ";?></td>
		<?php }else{
				if($type=='Dr'){
						$close=($opening+$debit)-$credit;?>
						<td  width="14%" style="text-align: right;">
							<?php echo $this->Number->currency(round((double)$opening)).' Dr';?>
						</td>
						<td  width="14%"><?php echo " ";?></td>
						<td  width="6%"><?php echo " ";?></td>	
			<?php }elseif($type=='Cr'){
						$close=($opening+$credit)-$debit;?>
						<td  width="14%"><?php echo " ";?></td>
						<td  width="14%" style="text-align: right;">
							<?php echo $this->Number->currency(round((double)$opening)).' Cr';?>
						</td>
						<td  width="6%"><?php echo " ";?></td>					
			<?php }	
   		}?>
		</tr>
		
		<tr class="row_gray">
			<td  colspan="5" style="text-align: right;" width="66%"><?php echo __('Current Balance :');?></td>
			<td  width="14%" style="text-align: right;">
			<?php if(!empty($debit)){
						echo $this->Number->currency(round((double)$debit)).' Dr';
					}else{
						echo " ";
					}
			?>
			</td>
		
			<td  width="14%" style="text-align: right;">
				<?php if(!empty($credit)){
					echo $this->Number->currency(round((double)$credit)).' Cr';
				}else{
					echo " ";
				}?>
			</td>
			<td  width="6%"><?php echo " ";?></td>
		</tr>
		
		<tr>
			<td  colspan="5" style="text-align: right;" width="66%"><?php echo __('Closing Balance :');?></td>
			<?php 
			if(empty($opening)){
				$close=$credit-$debit;
				if(empty($close)){ ?>
					<td  width="14%"><?php echo " ";?></td>
					<td  width="14%"><?php echo " ";?></td>
					<td  width="6%"><?php echo " ";?></td><?php
				}elseif($close<0){ ?>
					<td  width="14%" style="text-align: right;"><?php echo $this->Number->currency(-(round((double)$close))).' Dr'?></td>
					<td  width="14%"><?php echo " ";?></td>
					<td  width="6%"><?php echo " ";?></td><?php 
				}else{ ?>
					<td  width="14%"><?php echo " ";?></td>
					<td  width="14%" style="text-align: right;"><?php echo $this->Number->currency(round((double)$close)).' Cr'?></td>
					<td  width="6%"><?php echo " ";?></td>
				<?php } 
			}//end of if
			elseif($close==$opening){
			if($type=='Dr'){
			?>
				<td  width="14%" style="text-align: right;"><?php echo $this->Number->currency(round((double)$close)).' Dr'?></td>
				<td  width="14%"><?php echo " ";?></td>
				<td  width="6%"><?php echo " ";?></td><?php
			}elseif($type=='Cr'){?>
				<td  width="14%"><?php echo " ";?></td>
				<td  width="14%" style="text-align: right;"><?php echo $this->Number->currency(round((double)$close)).' Cr'?></td>
				<td  width="6%"><?php echo " ";?></td>
			<?php }
			}//end  of else if
			elseif($close>0){
			if($type=='Dr'){
			?>
				<td  width="14%" style="text-align: right;"><?php echo $this->Number->currency(round((double)$close)).' Dr'?></td>
				<td  width="14%"><?php echo " ";?></td>
				<td  width="6%"><?php echo " ";?></td><?php
			}elseif($type=='Cr'){?>
				<td  width="14%"><?php echo " ";?></td>
				<td  width="14%" style="text-align: right;"><?php echo $this->Number->currency(round((double)$close)).' Cr'?></td>
				<td  width="6%"><?php echo " ";?></td>
			<?php }
			}
			elseif($close<0){
			if($type=='Dr'){
			?>
				<td  width="14%"><?php echo " ";?></td>
				<td  width="14%" style="text-align: right;"><?php echo $this->Number->currency(round((double)-($close))).' Cr'?></td>
				<td  width="6%"><?php echo " ";?></td>
			<?php }elseif($type=='Cr'){?>
				<td  width="14%" style="text-align: right;"><?php echo $this->Number->currency(round((double)-($close))).' Dr'?></td>
				<td  width="14%"><?php echo " ";?></td>
				<td  width="6%"><?php echo " ";?></td><?php
			}
			} ?>
		</tr>  
		</tbody>
</table>
<?php } ?>
</td>
</tr>
</table>
<script>
$(document).ready(function(){
	$("#container-table").freezeHeader({ 'height': '450px' });
});
$("#print").click(function() {
	 var isHide = $('#isShowNarration').val();
	 var queryString = "?from="+"<?php echo $from;?>"+"&to="+"<?php echo $to;?>"+"&user_id="+"<?php echo $userid;?>"+"&narration="+"<?php echo $narration;?>"+"&amount="+"<?php echo $amount;?>"+"&isHide="+isHide;
	 var url="<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'print_legder_voucher')); ?>"+ queryString;
	 window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200");
	});
$("#excel").click(function() {
	 var isHide = $('#excel').val();
	 var queryString = "?from="+"<?php echo $from;?>"+"&to="+"<?php echo $to;?>"+"&user_id="+"<?php echo $userid;?>"+"&narration="+"<?php echo $narration;?>"+"&amount="+"<?php echo $amount;?>"+"&isHide="+isHide;
	 var url="<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'legder_voucher','excel')); ?>"+ queryString;
	 window.location.href=url;
	});	
</script>