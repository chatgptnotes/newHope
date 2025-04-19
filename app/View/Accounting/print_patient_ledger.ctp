<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html moznomarginboxes mozdisallowselectionprint>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $hospital_details = $this->General->billingHeader($this->Session->read('locationid'));?>
<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?></title>
	<?php echo $this->Html->css('internal_style.css');?> 
	<style>
	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;}
	.heading{font-weight:bold; padding-bottom:10px; font-size:19px; text-decoration:underline;}
	.headBorder{border:1px solid #ccc; padding:3px 0 15px 3px;}
	.title{font-size:14px; text-decoration:underline; font-weight:bold; padding-bottom:10px;color:#000;}
	input, textarea{border:1px solid #999999; padding:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.tbl .totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	..tabularForm td{background:none;}
	@media print {
  		#printButton{display:none;}
    }
</style> 
 
</head>
<body style="background:none;width:98%;margin:auto;">
 
<!--
set padding to 50px to adjust print page with default header coming on page
	--><table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" padding-left:30px;" align="center" >
		  <tr>
			  <td colspan="4" align="right">
			  <div id="printButton">
			  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
			  ?>
			  </div>
		 	 </td>
		  </tr>
		  
		  <tr><td>&nbsp;</td>
			<td style="text-align: center;">
				<?php echo Configure::read('locationLable');//echo $hospital_details['Location']['name']; ?><br>
				<?php echo $hospital_details['Location']['address1']; ?><br>
				<?php echo $hospital_details['City']['name'].' - '.$hospital_details['Location']['zipcode']; ?><br>
				<?php echo '<u>'.'E-Mail : '.$hospital_details['Location']['email'].'</u>'; ?><br>
			</td>
		</tr>
		<tr>
		  	<td>&nbsp;</td>		  
		  	<td align="" valign="top" colspan="2" style="text-align:center;font-size:18px;"><strong><?php echo ucwords($userName['Patient']['lookup_name']);?></strong></td>
		    </tr>
		   
		    <tr>
		  	<td>&nbsp;</td>		  
		  	<td align="" valign="top" colspan="2" style="letter-spacing: 0.1em;text-align:center;"><?php
		  				$getFrm=explode(" ",$from);
						$getFrmFinal = str_replace("/", "-",$getFrm[0]);				
						$getFrmFinal=date('jS-M-Y', strtotime($getFrmFinal));					
						$getTo=explode(" ",$to);
						$getToFinal = str_replace("/", "-",$getTo[0]);
						$getToFinal=date('jS-M-Y', strtotime($getToFinal));
				echo $getFrmFinal." To ".$getToFinal;?></td>
		    </tr>
	</table>


<?php echo $this->Form->create('Patient_voucher',array('id'=>'patientVoucher','url'=>array('controller'=>'Accounting','action'=>'get_patient_details','admin'=>false),));?>
<table align="center" width="100%">
	<tr>
	<td width="95%" valign="top">
	
<?php if($click==1){?>
<table cellspacing="0" cellpadding="0" width="100%" align="center">
		<tr>
			<td><b><?php 
			echo __('Ledger : '); echo ucwords($userName['Patient']['lookup_name']);?>
			</b></td>
			<td align="right"><?php $from1=explode(' ',$from); echo $from1[0];
			echo "  To ";  $to1=explode(' ',$to); echo $to1[0];?>
			</td>
		</tr>
	</table>
	<table class="formFull" width="100%" align="center" cellspacing="0">
		<tr class="row_gray">
			<th class="tdLabel"><?php echo __('Date');?></th>
			<th class="tdLabel"><?php echo __('Particulars');?></th>
			<th class="tdLabel"><?php echo __('Voucher Type');?></th>
			<th class="tdLabel"><?php echo __('Voucher Number');?></th>
			<th class="tdLabel"><?php echo __('Debit');?></th>
			<th class="tdLabel"><?php echo __('Credit');?></th>
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
		<?php } ?>
 		<?php if($data['AccountReceipt']){ ?>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['AccountReceipt']['date'],Configure::read('date_format'),false); ?></td>
			<td class="tdLabel"><?php echo $data['Account']['name'];?></td>
			<td class="tdLabel"><?php echo 'Receipt'; ?></td>
			<td class="tdLabel"><?php echo $data['AccountReceipt']['id'];?>
			<td><?php  echo " ";?></td>	
			<?php $credit=$credit+$data['AccountReceipt']['paid_amount'];?>
			<td class="tdLabel"><?php echo $this->Number->currency($data['AccountReceipt']['paid_amount']) ; ?></td>
		<?php } ?>
		<?php if($data['VoucherPayment']){ ?>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['VoucherPayment']['date'],Configure::read('date_format'),false); ?></td>
			<td class="tdLabel"><?php echo $data['Account']['name'];?></td>
			<td class="tdLabel"><?php echo 'Payment'; ?></td>
			<td class="tdLabel"><?php echo $data['VoucherPayment']['id'];?>
			<?php $debit=$debit+$data['VoucherPayment']['paid_amount'];?>
			<td class="tdLabel"><?php echo $this->Number->currency($data['VoucherPayment']['paid_amount']) ; ?></td>
			<td><?php  echo " ";?></td>	
		<?php } ?>
			
		<?php if($data['VoucherEntry']['type']=='Discount'){ ?>
		<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['VoucherEntry']['date'],Configure::read('date_format'),false); ?></td>
		<td class="tdLabel"><?php echo $data['Account']['name'];?></td>
		<td class="tdLabel"><?php echo 'Journal'; ?></td>
		<td class="tdLabel"><?php echo $data['VoucherEntry']['id'];?>
		<td class="tdLabel"><?php echo " ";?></td>
		<td class="tdLabel"><?php 
		$credit=$credit+$data['VoucherEntry']['debit_amount'];
			echo $this->Number->currency($data['VoucherEntry']['debit_amount']);
		?>
		</td>
			<?php  } ?>
			<?php
				}//EOF forecah
			if(empty($data)){
			?>
			<tr><td colspan="8">&nbsp;</td></tr>
			<tr><td colspan="8">&nbsp;</td></tr>
			<tr><td colspan="8"><?php echo "No Records Found"?></td></tr>
			<tr><td colspan="8">&nbsp;</td></tr>
			<tr><td colspan="8">&nbsp;</td></tr><?php    }?> 
			<tr><td colspan="7" style="border-top: solid 2px #3E474A;margin-bottom:-1px"></td></tr>			
			<tr>
				<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Opening Balance :');?></td>
				<?php if(empty($opening)){?>
				<td class="tdLabel"><?php echo " ";?></td>		
				<td class="tdLabel"><?php echo " ";?></td>
				<?php }else{
					if($type=='Dr'){?>
							<td class="tdLabel"><?php echo $this->Number->currency($opening);?></td>
							<td class="tdLabel"><?php echo " ";?></td>
					<?php }elseif($type=='Cr'){ ?>
							<td class="tdLabel"><?php echo " ";?></td>
							<td class="tdLabel"><?php echo $this->Number->currency($opening);?></td>					
					<?php }	}?>
			</tr>
			
			<tr class="row_gray">
				<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Current Balance :');?></td>
				<td class="tdLabel">
				<?php if(!empty($debit)){
					echo $currency.' '.$debit.' Dr';
					}else echo " ";?></td>
		
				<td class="tdLabel">
				<?php if(!empty($credit)){
					echo $currency.' '.$credit.' Cr';
					}else echo " ";?></td>
				<td></td>
			</tr>
			
			<tr>
				<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Closing Balance :');?></td>
				<?php if(!empty($credit) || !empty($debit)){
				if($type=='Cr'){
					$close=($opening+$credit)-$debit;
						if($close<0){?>
						<td class="tdLabel"><?php echo $currency.' '.-($close).' Dr';?></td>
						<td>&nbsp;</td>
						<?php }	else {?>
						<td>&nbsp;</td>
						<td class="tdLabel"><?php echo $currency.' '.$close.' Cr';?></td>
						<?php }}elseif($type=='Dr'){
					$close=($opening+$debit)-$credit;
						if($close<0){?>
						<td>&nbsp;</td>
						<td class="tdLabel"><?php echo $currency.' '.$close.' Cr';?></td>
						<?php }else{?>
						<td class="tdLabel" ><?php echo $currency.' '.-($close).' Dr';?></td>
						<td>&nbsp;</td>
						<?php }
					}
				}elseif(empty($credit)&& empty($debit)){
				if($type=='Dr'){
					$close=$opening; ?>
					<td class="tdLabel"><?php echo $currency.' '.$close;?></td>
					<td>&nbsp;</td>
				<?php } if($type=='Cr'){?>
					<td>&nbsp;</td>
					<td class="tdLabel"><?php echo $currency.' '.$close;?></td>
				<?php }
				if(empty($opening)){?>
				<td class="tdLabel"><?php echo " ";?></td>
				<td>&nbsp;</td>
				<?php }
				}?>
			</tr> 
		</table>
	<?php }?>
	</td>
</tr>
</table>
</table>
 </html>