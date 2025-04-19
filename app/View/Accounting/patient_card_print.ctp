<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $hospital_details = $this->General->billingHeader($this->Session->read('locationid'));?>
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true);
			$paddingLeft="0px";
		?>
		 
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
	.tabularForm td{background:none;}
	@media print {

  		#printButton{display:none;}
    }
    
</style> 
 
</head>
<body style="background:none;width:98%;margin:auto;">

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="800px;" style="padding-top:0px;padding-left:30px;" align="center">
		<tr>
			<td align="right">
				<div id="printButton"><?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();')); ?></div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table> 
 	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="800px;" style="padding-top:50px;padding-left:30px;" align="center">
		
		<tr><td>&nbsp;</td></tr>
		<tr>	  
		  	<td valign="top" style="text-align:center;font-size:15px;" colspan="3"><strong><u>PATIENT CARD DETAIL</u></strong></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td width="50%">Receipt No. : <b> <?php echo 'PATCARD'.$printDetail['PatientCard']['id'];?></b></td>
			<td >Dated:  <b><?php echo $this->DateFormat->formatDate2Local($printDetail['PatientCard']['create_time'],Configure::read('date_format'),false); ?></b></td>
		</tr>
		<tr><td>&nbsp;</td></tr>  
		
		<?php if(strtolower($printDetail['PatientCard']['type'])=='deposit'){
				$to= $printDetail['UserAccount']['name'];
				$from=$printDetail['Account']['name'];
				$narration='Cash Deposited to Patient Card';
			  }else if(strtolower($printDetail['PatientCard']['type'])=='refund'){
				$to= $printDetail['Account']['name'];
				$from=$printDetail['UserAccount']['name'];
				$narration='Cash Refunded From Patient Card';
			   }else if(strtolower($printDetail['PatientCard']['type'])=='discount'){
				$to= $printDetail['UserAccount']['name'];
				$from=$printDetail['Account']['name'];
				$narration='Discount Given To Patient Card';
			   }else if(strtolower($printDetail['PatientCard']['type'])=='payment'){
				$to= $printDetail['UserAccount']['name'];
				$from=$printDetail['Account']['name'];
				$narration='Payment Made From Patient Card'; /*against Bill  :. $printDetail['Billing']['id'];*/
			   }else{
					$to= $printDetail['Account']['name'];
					$from=$printDetail['UserAccount']['name'];				
			   }
		?>
		<tr>
			<td style="" >
				<?php if(strtolower($printDetail['PatientCard']['type'])=='deposit' || strtolower($printDetail['PatientCard']['type'])=='discount'
						|| strtolower($printDetail['PatientCard']['type'])=='payment'){
					echo "Received with thanks from :";
				}else if(strtolower($printDetail['PatientCard']['type'])=='refund'){
					echo "Refund To:";
				}	?>
			</td>
			<td><?php echo $printDetail['UserAccount']['name'];?></td>
		</tr>
		<tr>
			<td >The sum of :</td>
		    <td style="" ><?php echo $this->RupeesToWords->no_to_words($printDetail['PatientCard']['amount']); ?></td>
		</tr>
		<tr>
			<td >By :</td>
		    <td style="" ><?php echo $printDetail['Account']['name'] ?></td>
		</tr>
		<tr>
			<td >Remarks :</td>
		    <td style="" ><?php if(strtolower($printDetail['PatientCard']['type'])=='deposit' || strtolower($printDetail['PatientCard']['type'])=='discount'|| strtolower($printDetail['PatientCard']['type'])=='payment'){
					echo $printDetail['PatientCard']['mode_type']." received towards from ".$printDetail['UserAccount']['name']." against R. No.:";
				}else if(strtolower($printDetail['PatientCard']['type'])=='refund'){
					echo $printDetail['PatientCard']['mode_type']." refunded to ".$printDetail['UserAccount']['name']." against R. No.:";
				}	
			?></td>
		</tr>
		<tr>
			<td>Date :</td>
			<td><?php echo $this->DateFormat->formatDate2Local($printDetail['PatientCard']['create_time'],Configure::read('date_format'),false); ?></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		  	<td><?php echo "By ". $printDetail['PatientCard']['mode_type']." :";?></td><td>
		  	<?php echo $this->Html->image('icons/rupee_symbol.png',array('style'=>'float:none; vertical-align:top;'));?>&nbsp;<?php 
		  		echo $printDetail['PatientCard']['amount']."/-"; 
				?>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		  	<td> Receiver's Signature:</td>
		  	<td align="right"> Authorised Signatory</td>
		</tr>
	</table> 
 
</body>
 </html>