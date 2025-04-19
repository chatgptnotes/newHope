<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html moznomarginboxes mozdisallowselectionprint>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $hospital_details = $this->General->billingHeader($this->Session->read('locationid'));?>
<?php echo $this->Html->charset(); ?>
<title>
	<?php echo __('Hope', true); ?>
</title>
	<?php echo $this->Html->css('internal_style.css');?> 
	<style>
	@media print {
  		#printButton{display:none;}
    }
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
 
</head>
<body style="background:none;width:98%;margin:auto;">
	<table align="center" width="100%">
		<tr>
			<td colspan="3" align="right">
			<div id="printButton">
			  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();')); ?>
			 </div>
		 	</td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td style="text-align: center;">
				<?php echo Configure::read('locationLable');//echo $hospital_details['Location']['name']; ?><br>
				<?php echo $hospital_details['Location']['address1']; ?><br>
				<?php echo $hospital_details['City']['name'].' - '.$hospital_details['Location']['zipcode']; ?><br>
				<?php echo '<u>'.'E-Mail : '.$hospital_details['Location']['email'].'</u>'; ?><br>
			</td>
		</tr>
		<tr>
		  	<td>&nbsp;</td>		  
		  	<td valign="top" colspan="2" style="text-align:center;font-size:18px;">
		  		<strong>
		  			<?php echo ucwords($userName['Account']['name']); ?>
		  		</strong>
		  	</td>
		</tr>
		<tr>	  
		  	<td valign="top" colspan="2" style="letter-spacing: 0.1em;text-align:center;">
		  		<?php
		  				$getFrm=explode(" ",$from);
						$getFrmFinal = str_replace("/", "-",$getFrm[0]);				
						$getFrmFinal=date('jS-M-Y', strtotime($getFrmFinal));					
						$getTo=explode(" ",$to);
						$getToFinal = str_replace("/", "-",$getTo[0]);
						$getToFinal=date('jS-M-Y', strtotime($getToFinal));
					echo $getFrmFinal." To ".$getToFinal;
				?>
			</td>
		</tr>
	<?php 
	if($click==1){?>
	
	<table class="tabularForm" width="100%" align="center" cellspacing="1">
		<tr class="row_gray">
			<th style="width:6%"><?php echo __('Date');?></th>
			<th style="width:36%"><?php echo __('Particulars');?></th>
			<th style="width:10%"><?php echo __('Voucher Type');?></th>
			<th style="width:10%"><?php echo __('Voucher Number');?></th>
			<th style="width:19%; text-align:right;"><?php echo __('Debit');?></th>
			<th style="width:19%; text-align:right;"><?php echo __('Credit');?></th>
		</tr>
	<?php 
	//only shows entry receipt n payment by cash /commented by amit jain
	if($isHide == 0){
		$display = "display:block";
	}else{
		$display = "display:none";
	}
	$toggle=0;$row=0;ksort($ledger);
			foreach($ledger as $key=>$entry){	
					ksort($entry);
					foreach($entry as $key=>$data)
					{
					if($toggle == 0) {
						echo "<tr>";
						$toggle = 1;
					}else{
						echo "<tr class='row_gray'>";
						$toggle = 0;
					}
	
		//for Payment data
	if(isset($data['VoucherPayment'])){?>
		<td valign="top" style="text-align: center;">
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
			<div style="padding-left:35px;padding-top:5px; font-style:italic;<?php echo $display;?>">
				<?php echo __('Narration : ').$data['VoucherPayment']['narration'];?>
			</div>
		</td>
		
		<td><?php echo __('Payment'); ?></td>
		
		<td style="text-align: right;"><?php echo $data['VoucherPayment']['id']; ?></td>
		
	<?php if($data['VoucherPayment']['account_id']==$userid){ ?>
		<td><?php echo " ";?></td>
		<td style="text-align: right;">
			<?php 
			$credit=$credit+$data['VoucherPayment']['paid_amount'];
				echo $this->Number->currency($data['VoucherPayment']['paid_amount']);
			?>
		</td>
			<?php }
			elseif($data['VoucherPayment']['user_id']==$userid){?>
		<td style="text-align: right;">
			<?php 
			$debit=$debit+$data['VoucherPayment']['paid_amount'];
				echo $this->Number->currency($data['VoucherPayment']['paid_amount']);
			?>
		</td>
		<td><?php echo " ";?></td>
		<?php }?>
		<?php
		}
	if(isset($data['AccountReceipt'])){//for Reciept data?>
 		<td valign="top" style="text-align: center;">
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
 			<div style="padding-left:35px;padding-top:5px; font-style:italic;<?php echo $display;?>">
 				<?php echo __('Narration : ').$data['AccountReceipt']['narration'];?>
 			</div>
 		</td>
 		
 			<td><?php echo 'Receipt'; ?></td>
 			<td style="text-align: right;"><?php echo $data['AccountReceipt']['id'];?></td>
 			
 		<?php if($data['AccountReceipt']['user_id']==$userid){ ?>
 			<td><?php echo " ";?></td>
 			<td style="text-align: right;">
 			<?php $credit=$credit+$data['AccountReceipt']['paid_amount'];
 				echo $this->Number->currency($data['AccountReceipt']['paid_amount']);?>
 			</td>
 			<?php } 
 				elseif($data['AccountReceipt']['account_id']==$userid){?>
 			<td style="text-align: right;">
 				<?php $debit=$debit+$data['AccountReceipt']['paid_amount'];
 				echo $this->Number->currency($data['AccountReceipt']['paid_amount']);?>
 			</td>
 			<td><?php echo " ";?></td>
 			<?php }?>
		<?php }

		//for contra data
		if(isset($data['ContraEntry'])){?>
			<td valign="top" style="text-align: center;">
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
				<div style="padding-left:35px;padding-top:5px; font-style:italic;<?php echo $display;?>">
				 	<?php echo __('Narration : ').$data['ContraEntry']['narration'];?>
				 </div>
			</td>
			
			<td><?php echo __('Contra'); ?></td>
			<td style="text-align: right;"><?php echo $data['ContraEntry']['id'];?></td>
			
		<?php if($data['ContraEntry']['user_id']==$userid){ ?>
			<td><?php echo " ";?></td>
			<td style="text-align: right;">
				<?php 
				$credit=$credit+$data['ContraEntry']['debit_amount'];
					echo $this->Number->currency($data['ContraEntry']['debit_amount']);
				?>
			</td>
		<?php }elseif($data['ContraEntry']['account_id']==$userid){?>
			<td style="text-align: right;">
				<?php 
				$debit=$debit+$data['ContraEntry']['debit_amount'];
					echo $this->Number->currency($data['ContraEntry']['debit_amount']);
				?>
			</td>
			<td><?php echo " ";?></td>
			<?php }
			}
				
		if(isset($data['VoucherEntry'])){?>
			<td valign="top" style="text-align: center;">
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
				<div style="padding-left:35px;padding-top:5px; font-style:italic;<?php echo $display;?>">
					<?php echo __('Narration : ').$data['VoucherEntry']['narration'];?>
				</div>
			</td>
			
			<td><?php echo __('Journal'); ?></td>
			<td style="text-align: right;"><?php echo $data['VoucherEntry']['id'];?></td>
	
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
			<?php }
			} 
		}
			 // if no data to display...	
		if(empty($ledger)){?>
			<tr><td colspan="9">&nbsp;</td></tr>
			<tr><td colspan="9"></td></tr>
			<tr><td colspan="9"><?php echo "No Records Found"?></td></tr>
			<tr><td colspan="9">&nbsp;</td></tr>
			<tr><td colspan="9">&nbsp;</td></tr>
			<?php }?>
			
	<tr>
		<td colspan="4" style="text-align: right;">
			<?php echo __('Opening Balance :');?>
		</td>
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
		<td colspan="4" style="text-align: right;">
			<?php echo __('Current Balance :');?>
		</td>
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
		<td colspan="4" style="text-align: right;">
			<?php echo __('Closing Balance :');?>
		</td>
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
			<td style="text-align: right;"><?php echo $this->Number->currency($close).' Dr'?></td>
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
</table>
</body>
</html>