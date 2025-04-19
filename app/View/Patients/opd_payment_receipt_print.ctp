<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php //echo __('Hope', true); ?>
		 
	</title>
	<?php echo $this->Html->css('internal_style.css');?> 
	<link rel="stylesheet" type="text/css" href="http://cdn.webrupee.com/font" />
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
	--><table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="padding-top:100px;padding-left:100px;">
		  <tr>
			  <td colspan="3" align="right">
			  <div id="printButton">
			  <?php 
			 		 
			   		echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();'));
			  ?>
			  </div>
		 	 </td>
		  </tr><!--
		  <tr>
		  	<td>&nbsp;</td>
		  	<td align="" valign="top" colspan="1" style="text-decoration:underline;letter-spacing: 0.2em;"><strong>RECEIPT</strong></td>
		  </tr>
		  --><tr><td>&nbsp;</td></tr>
		  
		  <tr>
		  	<td width="200" valign="top">Received with thanks from</td>
		  	<td>: <?php
		   
					$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
		  			echo $data[0]['lookup_name']."(".$data['Patient']['admission_id'].")"; 
		  			
		  			//total 
		  			$total = $consultationCharge['TariffAmount'][$hosType]+$data['TariffAmount'][$hosType];
		  			?></td>	
		  </tr>
		  <tr>
		  	<td valign="top">Age</td>
		  	<td>: <?php echo $data['Patient']['age']; ?></td>
		  </tr>
		  <tr>
		  	<td valign="top">Sex</td>
		  	<td>: <?php echo ucfirst($data['Patient']['sex']); ?></td>
		  </tr>
		  <tr>
		  	<td valign="top">The sum of</td>
		  	<td>: <?php echo $this->RupeesToWords->no_to_words($total); ?></td>
		  </tr>
		  <tr>
		  	<td valign="top">By</td>
		  	<td>: Cash</td>
		  </tr> 
		  <tr>
		  	<td valign="top">Token No</td>
		  	<td>: <?php echo $token['Appointment']['app_token']; ?></td>
		  </tr>
		   <tr>
		  	<td>Date</td>
		  	<td>: <?php echo $this->DateFormat->formatDate2Local($data['Patient']['fee_paid_on'],Configure::read('date_format'),true); ?></td>
		  </tr>
		   <tr>
		  	<td valign="top">Remarks</td>
		  	<td>: <?php echo $data['Patient']['remark']; ?></td>
		  </tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>  
		  <tr>
		  	<td>
		  		<?php 
		  			//echo $this->Html->image('icons/rupee_symbol.png');
		  			echo $this->Number->currency($total)."/-"; ?>
		  </td>
		  	<td>Name & Sign of Patient &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Authorised Signatory</td>
		  </tr>
	</table> 
 
</body>
 </html>                    
  
 