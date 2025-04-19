<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Ledger_Voucher_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
<style>
body{
font-size:13px;
}
</style>
	<table align="center" style="margin-top: 10px" width="100%" border="1">
		<tr>
			<td width="95%" valign="top">
			<?php 
			if($click==1){?>
			<table cellspacing="0" cellpadding="0" width="80%" align="center" style="margin-top: 20px" border="1">
				<tr>
					<td>
						<b>
							<?php echo __('Ledger : '); echo ucwords($userName['Account']['name']);?>
						</b>
					</td>
					<td align="right" colspan="5">
						<?php  
							$from1=explode(' ',$from);
							echo $from1[0];
							echo "  To ";  $to1=explode(' ',$to);
							echo $to1[0];
						?>
					</td>
				</tr>
			</table>
			
			<table class="formFull" width="100%" align="center" cellspacing="0" border="1">
				<tr class="row_gray">
					<th style="width:9%"><?php echo __('Date');?></th>
					<th style="width:39%"><?php echo __('Particulars');?></th>
					<th style="width:7%"><?php echo __('Voucher Type');?></th>
					<th style="width:9%"><?php echo __('Voucher Number');?></th>
					<th style="width:14%"><?php echo __('Debit');?></th>
					<th style="width:14%"><?php echo __('Credit');?></th>
				</tr>
			<?php
			$toggle=0;$row=0;ksort($ledger);
			foreach($ledger as $key=>$entry){	
					ksort($entry);
				foreach($entry as $key=>$data){
					if($toggle == 0) {
						echo "<tr>";
						$toggle = 1;
					}else{
						echo "<tr class='row_gray'>";
						$toggle = 0;
					}
			
			//for Payment data
			if(isset($data['VoucherPayment'])){?>
				<td style= "text-align: center;">
					<?php echo $this->DateFormat->formatDate2Local($data['VoucherPayment']['date'],Configure::read('date_format'),false); ?>
				</td>
				<td>
					<div style="padding-left:0px; padding-bottom:3px;">
					<?php 
						if($data['VoucherPayment']['user_id']==$userid){
							echo ucwords($data['AccountAlias']['name']);
						} elseif ($data['VoucherPayment']['account_id']==$userid){
							echo ucwords($data['Account']['name']);
						}
					?>
					</div>
					<?php if($isHide == 0){?>
					<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
						<?php echo __('Narration : ').$data['VoucherPayment']['narration'];?>
					</div>
					<?php }?>
				</td>
				<td style= "text-align: left;"><?php echo 'Payment'; ?></td>
				<td style= "text-align: right;"><?php echo $data['VoucherPayment']['id']; ?></td>
				
					<?php if($data['VoucherPayment']['account_id']==$userid){ ?>
				<td><?php echo " ";?></td>
				<td style= "text-align: right;">
					<?php 
					$credit=$credit+$data['VoucherPayment']['paid_amount'];
						echo $this->Number->currency($data['VoucherPayment']['paid_amount']);
					?>
				</td>
					<?php } elseif($data['VoucherPayment']['user_id']==$userid){?>
				<td style= "text-align: right;">
					<?php 
					$debit=$debit+$data['VoucherPayment']['paid_amount'];
						echo $this->Number->currency($data['VoucherPayment']['paid_amount']);
					?>
				</td>
				<td><?php echo " ";?></td>
				<?php }?>
			<?php }
				
			//for Reciept data
			if(isset($data['AccountReceipt'])){ ?>
		 		<td style= "text-align: center;">
		 			<?php echo $this->DateFormat->formatDate2Local($data['AccountReceipt']['date'],Configure::read('date_format'),false); ?>
		 		</td>
		 		<td>
		 			<div style="padding-left:0px; padding-bottom:3px;">
			 			<?php 
			 				if($data['AccountReceipt']['user_id']==$userid){
			 					echo ucwords($data['AccountAlias']['name']);
			 				}elseif($data['AccountReceipt']['account_id']==$userid){
			 					echo ucwords($data['Account']['name']);
			 				}
			 			?>
 					</div>
 				<?php if($isHide == 0){?>
		 			<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
		 				<?php echo __('Narration : ').$data['AccountReceipt']['narration'];?>
		 			</div>
		 		<?php }?>
		 		</td>
		 		<td style= "text-align: left;"><?php echo __('Receipt'); ?></td>
		 		<td style= "text-align: right;"><?php echo $data['AccountReceipt']['id'];?></td>
		 	<?php if($data['AccountReceipt']['user_id']==$userid){ ?>
		 		<td><?php echo " ";?></td>
		 		<td style= "text-align: right;">
		 			<?php $credit=$credit+$data['AccountReceipt']['paid_amount'];
		 				echo $this->Number->currency($data['AccountReceipt']['paid_amount']);?>
		 		</td>
		 	<?php } elseif($data['AccountReceipt']['account_id']==$userid){?>
		 		<td style= "text-align: right;">
		 			<?php $debit=$debit+$data['AccountReceipt']['paid_amount'];
		 			echo $this->Number->currency($data['AccountReceipt']['paid_amount']);?>
		 		</td>
		 		<td><?php echo " ";?></td>
		 	<?php }?>
			<?php }
			
				//for contra data
				if(isset($data['ContraEntry'])){?>
				<td style= "text-align: center;">
					<?php echo $this->DateFormat->formatDate2Local($data['ContraEntry']['date'],Configure::read('date_format'),false); ?>
				</td>
				<td>
					<div style="padding-left:0px;padding-bottom:3px;">
						<?php
							if($data['ContraEntry']['user_id']==$userid){
								echo ucwords($data['AccountAlias']['name']);
							}elseif($data['ContraEntry']['account_id']==$userid){
						 		echo ucwords($data['Account']['name']);
							}
						?>
					</div>
				<?php if($isHide == 0){?>
					<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
					 	<?php echo __('Narration : ').$data['ContraEntry']['narration'];?>
					 </div>
				<?php }?>
				</td>
				<td style= "text-align: left;"><?php echo __('Contra'); ?></td>
				<td style= "text-align: right;">
					<?php echo $data['ContraEntry']['id']; ?>
				</td>
					<?php if($data['ContraEntry']['user_id']==$userid){ ?>
				<td><?php echo " ";?></td>
				<td style= "text-align: right;">
					<?php 
					$credit=$credit+$data['ContraEntry']['debit_amount'];
						echo $this->Number->currency($data['ContraEntry']['debit_amount']);
					?>
				</td><?php } 
				elseif($data['ContraEntry']['account_id']==$userid){?>
				<td style= "text-align: right;">
					<?php 
					$debit=$debit+$data['ContraEntry']['debit_amount'];
						echo $this->Number->currency($data['ContraEntry']['debit_amount']);
					?>
				</td>
				<td><?php echo " ";?></td>
					<?php }?>
			<?php }
			
			//for journal entry
			if(isset($data['VoucherEntry'])){?>
					<td style= "text-align: center;">
						<?php echo $this->DateFormat->formatDate2Local($data['VoucherEntry']['date'],Configure::read('date_format'),false); ?>
					</td>
					<td>
						<div style="padding-left:0px;padding-bottom:3px;">
							<?php 
								if($data['VoucherEntry']['user_id']==$userid){
									echo ucwords($data['AccountAlias']['name']);
								}elseif($data['VoucherEntry']['account_id']==$userid){
									echo ucwords($data['Account']['name']);
								}
							?>
						</div>
					<?php if($isHide == 0){?>
						<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
							<?php echo __('Narration : ').$data['VoucherEntry']['narration'];?>
						</div>
					<?php }?>
					</td>
					<td style= "text-align: right;"><?php echo __('Journal'); ?></td>
					<td style= "text-align: right;"><?php echo $data['VoucherEntry']['id'];?></td>
		
					<!-- for owners capital account in cashier excess amount in credit side n cash amount debit side by amit jain -->
					<?php if($data['AccountAlias']['name'] == Configure::read('owners_capital_account')){?>
					<?php if($data['VoucherEntry']['account_id']==$userid){ ?>
					<td style= "text-align: center;"><?php echo " ";?></td>
					<td style= "text-align: right;">
						<?php 
						$credit=$credit+$data['VoucherEntry']['debit_amount'];
							echo $this->Number->currency($data['VoucherEntry']['debit_amount']);
						?>
					</td>
						<?php } elseif($data['VoucherEntry']['user_id']==$userid){?>
					<td style= "text-align: right;">
						<?php 
						$debit=$debit+$data['VoucherEntry']['debit_amount'];
							echo $this->Number->currency($data['VoucherEntry']['debit_amount']);
						?>
					</td>
					<td style= "text-align: center;"><?php echo " ";?></td>
						<?php } }else{?>
					
						<?php if($data['VoucherEntry']['user_id']==$userid){ ?>
					<td><?php echo " ";?></td>
					<td style= "text-align: right;">
						<?php 
						$credit=$credit+$data['VoucherEntry']['debit_amount'];
							echo $this->Number->currency($data['VoucherEntry']['debit_amount']);
						?>
					</td>
						<?php } elseif($data['VoucherEntry']['account_id']==$userid){?>
					<td style= "text-align: right;">
						<?php 
						$debit=$debit+$data['VoucherEntry']['debit_amount'];
							echo $this->Number->currency($data['VoucherEntry']['debit_amount']);
						?>
					</td>
					<td style= "text-align: center;"><?php echo " ";?></td>
						 <?php } }?>
					<?php }
					} 
				}
					 // if no data to display...	
				if(empty($ledger)){?>
					<tr><td colspan="6">&nbsp;</td></tr>
					<tr><td colspan="6">&nbsp;</td></tr>
					<tr><td colspan="6"><?php echo "No Records Found"?></td></tr>
					<tr><td colspan="6">&nbsp;</td></tr>
					<tr><td colspan="6">&nbsp;</td></tr>
				<?php }?>
			<tr>
				<td colspan="4" style="text-align: right;"><?php echo __('Opening Balance :');?></td>
				<?php if(empty($opening)){?>
				<td><?php echo " ";?></td>		
				<td><?php echo " ";?></td>
				<?php }else{
				if($type=='Dr'){
					$close=($opening+$debit)-$credit;?>
				<td style="text-align: right;"><?php echo $this->Number->currency($opening).' Dr';?></td>
				<td><?php echo " ";?></td>
				<?php }elseif($type=='Cr'){
					$close=($opening+$credit)-$debit;?>
				<td><?php echo " ";?></td>
				<td style="text-align: right;"><?php echo $this->Number->currency($opening).' Cr';?></td>					
				<?php }	
		   		}?>
			</tr>
				
			<tr class="row_gray">
				<td colspan="4" style="text-align: right;"><?php echo __('Current Balance :');?></td>
				<td style="text-align: right;">
					<?php 
						if(!empty($debit)){
							echo $this->Number->currency($debit).' Dr';
						}else{
							echo " ";
						}
					?>
				</td>
				
				<td style="text-align: right;">
					<?php 
						if(!empty($credit)){
							echo $this->Number->currency($credit).' Cr';
						}else{
							echo " ";
						}
					?>
				</td>
			</tr>
			
			<tr>
				<td colspan="4" style="text-align: right;"><?php echo __('Closing Balance :');?></td>
				<?php 
				if(empty($opening)){
					$close=$credit-$debit;
					if(empty($close)){ ?>
						<td><?php echo " ";?></td>
						<td><?php echo " ";?></td><?php
					}elseif($close<0){ ?>
						<td style="text-align: right;"><?php echo $this->Number->currency(-($close)).' Dr'?></td>
						<td><?php echo " ";?></td><?php 
					}else{ ?>
						<td><?php echo " ";?></td>
						<td style="text-align: right;"><?php echo $this->Number->currency($close).' Cr'?></td>
					<?php } 
				}//end of if
				elseif($close==$opening){
				if($type=='Dr'){
				?>
					<td style="text-align: right;"><?php echo $this->Number->currency($close * (-1)).' Dr'?></td>
					<td><?php echo " ";?></td><?php
				}elseif($type=='Cr'){?>
					<td><?php echo " ";?></td>
					<td style="text-align: right;"><?php echo $this->Number->currency($close).' Cr'?></td>
				<?php }
				}//end  of else if
				elseif($close>0){
				if($type=='Dr'){
				?>
					<td style="text-align: right;"><?php echo $this->Number->currency($close).' Dr'?></td>
					<td><?php echo " ";?></td><?php
				}elseif($type=='Cr'){?>
					<td><?php echo " ";?></td>
					<td style="text-align: right;"><?php echo $this->Number->currency($close).' Cr'?></td>
				<?php }
				}
				elseif($close<0){
				if($type=='Dr'){
				?>
					<td><?php echo " ";?></td>
					<td style="text-align: right;"><?php echo $this->Number->currency(-($close)).' Cr'?></td>
				<?php }elseif($type=='Cr'){?>
					<td style="text-align: right;"><?php echo $this->Number->currency(-($close)).' Dr'?></td>
					<td><?php echo " ";?></td><?php
				}
				} ?>
				</tr>  
		</table>
		<?php } ?>
		</td>
	</tr>
</table>