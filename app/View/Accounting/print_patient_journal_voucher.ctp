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
	--><table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="padding-left:30px;" align="center" >
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
		  	<td align="" valign="top" colspan="2" style="text-align:center;font-size:18px;"><strong>Patient Journal</strong></td>
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
	<table cellspacing="0" cellpadding="0" width="100%" align="center">
		<tr>
			<td><b><?php echo __('Journal : '); echo ucwords($userName['Patient']['lookup_name']);?></b></td>
			<td style="padding-left: 170px"><?php echo __('Journal Voucher No. :')?> 
					<?php
					foreach($voucherLog as $key=>$data){ ?>
					<b> <?php echo $data['voucher_no']; ?> </b>	
					<?php } ?>
			</td>
			<td align="right"><?php  $from1=explode(' ',$from);echo $from1[0];echo "  To ";  $to1=explode(' ',$to);echo $to1[0];?></td>
		</tr>
	</table>
		<table class="formFull" width="100%" align="center" cellspacing="0" >
		<tr class="row_gray">
			<th class="tdLabel"><?php echo __('Date');?></th>
			<th class="tdLabel"><?php echo __('Particulars');?></th>
			<th class="tdLabel"><?php echo __('Debit');?></th>
			<th class="tdLabel"><?php echo __('Credit');?></th>
		</tr>
	<?php 
$toggle=0;$row=0;
foreach($voucherLog as $key=>$data){
				if($toggle == 0) {
					echo "<tr>";
					$toggle = 1;
				}else{
					echo "<tr class='row_gray'>";
					$toggle = 0;
				}
		if(!empty($data['debit_amount'])){ ?>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['create_time'],Configure::read('date_format'),false); ?></td>
			<td class="tdLabel">
			<b> <?php echo $userName['Patient']['lookup_name'];?></b>
			</td>
			<td class="tdLabel"><?php 
			$debit=round($debit+$data['debit_amount']);
				echo $this->Number->currency(round($data['debit_amount']));
			?>
			</td>
			<td class="tdLabel"><?php echo " ";?></td>
			<?php } }?>
<?php
	$toggle=0;$row=0;
			foreach($ledger as $key=>$data){
					if($toggle == 0) {
						echo "<tr>";
						$toggle = 1;
					}else{
						echo "<tr>";
						$toggle = 0;
					}	
		if($data['VoucherEntry']['type']!='Discount'){ ?>
		<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['VoucherEntry']['date'],Configure::read('date_format'),false); ?></td>
		<td class="tdLabel">
						<b><?php echo $data['Account']['name'];?></b>
						<br><i><?php echo __('Narration : ').$data['VoucherEntry']['narration'];?></i>
		</td>
		<td class="tdLabel"><?php echo " ";?></td>
		<td class="tdLabel"><?php 
		$credit=round($credit+$data['VoucherEntry']['debit_amount']);
			echo $this->Number->currency(round($data['VoucherEntry']['debit_amount']));
		?>
		</td>
			<?php  }
		}
			 // if no data to display...	
			 if(empty($ledger)){?>
			<tr><td colspan="6">&nbsp;</td></tr>
			<tr >&nbsp;<td colspan="6"></td></tr>
			<tr><td colspan="6" align="center"><?php echo "No Records Found"?></td></tr>
			<tr><td colspan="6">&nbsp;</td></tr>
			<tr><td colspan="6">&nbsp;</td></tr><?php    }
			//?>
			<tr><td colspan="6" style="border-top: solid 2px #3E474A;margin-bottom:-1px"></td></tr>
	
	<tr >
		<td class="tdLabel" colspan="2" style="text-align: right;"><?php echo __('Opening Balance :');?>
		</td>
		<?php if(empty($opening)){?>
		<td class="tdLabel"><?php echo " ";?></td>		
		<td class="tdLabel"><?php echo " ";?></td>
		<?php }
		else{
				if($type=='Dr'){
						$close=($opening+$debit)-$credit;	?>
						<td class="tdLabel">
						<?php echo $this->Number->currency($opening).' Dr';?></td>
						<td class="tdLabel" ><?php echo " ";?></td>
						
			<?php }
			elseif($type=='Cr'){
						$close=($opening+$credit)-$debit;	?>
						<td class="tdLabel" ><?php echo " ";?></td>
						<td class="tdLabel" >
						<?php echo $this->Number->currency($opening).' Cr';?></td>					
			<?php }	
   		}?>
		</tr>
		<tr class="row_gray">
		<td class="tdLabel" colspan="2" style="text-align: right;"><?php echo __('Current Balance :');?>
		</td>
		<td class="tdLabel"><?php if(!empty($debit))
		{
		echo $this->Number->currency(round($debit)).' Dr';
			}
			else echo " ";
				?></td>
		
		<td class="tdLabel"><?php if(!empty($credit))
		{
		echo $this->Number->currency(round($credit)).' Cr';
			}
			else echo " ";?></td>
		</tr>
		<tr>
		<td class="tdLabel" colspan="2" style="text-align: right;"><?php echo __('Closing Balance :');?>
		</td>
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
 </html>