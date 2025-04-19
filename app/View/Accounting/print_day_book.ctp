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

		<tr><td>&nbsp;</td>
			<td style="text-align: center;">
				<?php echo $hospital_details['Location']['name']; ?><br>
				<?php echo $hospital_details['Location']['address1']; ?><br>
				<?php echo $hospital_details['City']['name'].' - '.$hospital_details['Location']['zipcode']; ?><br>
				<?php echo '<u>'.'E-Mail : '.$hospital_details['Location']['email'].'</u>'; ?><br>
			</td>
		</tr>
		<tr>
		  	<td>&nbsp;</td>		  
		  	<td valign="top" colspan="2" style="text-align:center;font-size:18px;"><strong><?php echo __("Day Book"); ?></strong></td>
		</tr>
		<tr>	  
		  	<td valign="top" colspan="2" style="letter-spacing: 0.1em;text-align:center;"><?php
		  				$getFrm=explode(" ",$from);
						$getFrmFinal = str_replace("/", "-",$getFrm[0]);				
						$getFrmFinal=date('jS-M-Y', strtotime($getFrmFinal));					
						$getTo=explode(" ",$to);
						$getToFinal = str_replace("/", "-",$getTo[0]);
						$getToFinal=date('jS-M-Y', strtotime($getToFinal));
				echo $getFrmFinal." To ".$getToFinal;?></td>
		</tr>
<table width="100%" cellpadding="0" cellspacing="0" border="1" class="tabularForm" id="container-table">
	<thead>
		<tr> 
		    <th align="center" valign="top" width="15%"><?php echo __('Date');?></th>
			<th align="center" valign="top" width="20%"><?php echo __('Particulars');?></th> 
			<th align="center" valign="top" width="10%"><?php echo __('Voucher Type');?></th>
			<th align="center" valign="top" style="text-align: right;" width="10%"><?php echo __('Voucher Number');?></th> 
			<th align="center" valign="top" style="text-align: right;" width="15%"><?php echo __('Debit');?></th>
			<th align="center" valign="top" style="text-align: right;" width="15%"><?php echo __('Credit');?></th> 
		</tr> 
	</thead>
	<tbody>
<?php foreach($data as $key=> $journalData){ ?>
	<tr>
		<td>
			<?php echo $actualDate = $this->DateFormat->formatDate2Local($journalData['VoucherLog']['date'],Configure::read('date_format'),true);?>
		</td>
	
		<td>
			<?php 
				if($journalData['VoucherLog']['type']=="RefferalCharges"){
					echo "ML Enterprise"; 
				}else if($journalData['VoucherLog']['type'] == "USER"){
					echo ucwords($journalData['AccountAlias']['name']);
				}else{
					echo ucwords($journalData['Account']['name']);
				}
			?>
		</td>
		<td><?php echo $journalData['VoucherLog']['voucher_type'];?></td>
		<td style="text-align: right;"><?php echo $journalData['VoucherLog']['voucher_no'];?></td>
		<?php 
		if($journalData['VoucherLog']['voucher_type']=='Receipt'){ ?>
		<td><?php echo " ";?></td>
		<td style="text-align: right;"><?php echo $this->Number->currency($journalData['VoucherLog']['paid_amount']);?></td>
		<?php }elseif($journalData['VoucherLog']['voucher_type']=='Payment'){?>
		<td style="text-align: right;"><?php echo $this->Number->currency($journalData['VoucherLog']['paid_amount']);?></td>
		<td><?php echo " ";?></td>
		<?php }elseif($journalData['VoucherLog']['voucher_type']=='Journal' && $journalData['VoucherLog']['type']!='FinalDischarge'){?>
		<td style="text-align: right;"><?php echo $this->Number->currency($journalData['VoucherLog']['debit_amount']);?></td>
		<td><?php echo " ";?></td>
		<?php }elseif($journalData['VoucherLog']['voucher_type']=='Contra' || $journalData['VoucherLog']['voucher_type']=='Purchase'){?>
		<td><?php echo " ";?></td>
		<td style="text-align: right;"><?php echo $this->Number->currency($journalData['VoucherLog']['debit_amount']);?></td>
		<?php }elseif($journalData['VoucherLog']['voucher_type']=='Journal' && $journalData['VoucherLog']['type']=='FinalDischarge'){?>
		<td style="text-align: right;"><?php echo $this->Number->currency($journalData['VoucherLog']['debit_amount']);?></td>
		<td><?php echo " ";?></td>
		<?php } }?>
			</tr>
		</tbody>
	</table>
</table>
</body>
</html>