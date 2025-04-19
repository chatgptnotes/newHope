<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html moznomarginboxes mozdisallowselectionprint>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo $this->Html->charset(); ?>
		<?php echo $this->Html->css('internal_style.css');?> 
		<style>
			body{padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;}
			@media print {
		  		#printButton{display:none;}
		    }
	
		    .table_format td {
		    font-size: 16px;
		    padding-bottom: 3px;
		    padding-right: 10px;
			}
		</style> 
	</head>
	<body style="background:none;width:98%;margin:auto;">
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="800px;" style="padding-top:5px;padding-left:0px;" align="center">
			<tr>
				<td colspan="3" align="right">
				<div id="printButton">
				  <?php echo $this->Html->link(__('Print', true),'#',array('escape'=>false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
				 </div>
			 	</td>
			</tr>
			 
			<tr>	  
			  	<td valign="top" style="text-align:left; font-size:15px;">
			  		<strong>
			  			<?php echo __("A/C Payee")?>
			  		</strong>
			  	</td>
			  	<td align="center" style="font-size:15px;">
			  		<strong>
			  			<?php $myDate = $this->DateFormat->formatDate2Local($voucherPaymentData['VoucherPayment']['date'],Configure::read('date_format'),false); 
			  						echo implode(' ',str_split(str_replace("/", "", $myDate)));?>
			  		</strong>
			  	</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td style="padding-left:20px; font-size:15px;">
					<strong>
						<?php echo $voucherPaymentData['Account']['name']; ?>
					</strong>
				</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
			  	<td style="padding-left:50px; font-size:15px;">
			  		<strong>
			  			<?php echo $this->RupeesToWords->no_to_words($voucherPaymentData['VoucherPayment']['paid_amount']); ?>
			  		</strong>
			  	</td>
			</tr>
			  
			<tr>
				<td>&nbsp;</td>
			  	<td style="text-align:center; font-size:15px;">
			  		<strong>
			  			<?php
			  				$amount = number_format($voucherPaymentData['VoucherPayment']['paid_amount'],2);
			  				$newStr = str_replace(' ', '', $amount);
			  				echo "**$newStr";
			  			?>
			  		</strong>
			  	</td>
			</tr>
		</table> 
	</body>
</html>