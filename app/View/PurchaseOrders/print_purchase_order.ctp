<html moznomarginboxes mozdisallowselectionprint>

<?php	$website=$this->Session->read('website.instance'); 
	if(strtolower($website) == "vadodara"){ ?>
	<style>
 
 	.lableFont{font-size: 15px; }
  
	.labelf{
		font-size: 14px;
	}
	
	@media print {
	   @page{
	    size: 6.0in 4.0in;
	    size: portrait;
	  }
	  .printBtn{
	  	display: none;
	  }
	}
		body{margin:7px 0 0 0; padding:0;}
		p{margin:0; padding:0;}
		.page-break {
			page-break-before: always;
		}
		.boxBorderBot{border-bottom:1px dashed #3E474A;}
		.boxBorderTop{border-top:1px dashed #3E474A;}
		.boxBorderRight{border-right:1px dashed #3E474A;}
		.boxBorderLeft{border-left:1px dashed #3E474A;}
		.boxBorderBotSolid{border-bottom:1px solid #3E474A;}
		.heading{font-family:Arial, Helvetica, sans-serif; font-size:20px; font-weight:bold; color:#000000; padding:0px 0 0px 0;}
		.headAddress{font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; color:#333333;}
		.dlNo, .vatNo{font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; color:#333333;}
		.prescribeDetail{border:1px solid #666666; border-bottom:0px; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#333333;}
		.billTbl{background-color:#333333;}
		.billTbl th{background-color:#ddecc4; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; color:#333333;}
		.billTbl td{background-color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; color:#333333;}
		.billTotal{background-color:#ddecc4; font-family:Arial, Helvetica, sans-serif; font-size:17px; font-weight:bold; color:#333333;}
		.billSign{font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#333333;}
		.billFooter{font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; color:#333333;}
		.blueBtn {
	    background: none repeat scroll 0 0 #6D8A93;
	    border: 0 none;
	    color: #FFFFFF;
	    cursor: pointer;
	    font-family: Arial,Helvetica,sans-serif;
	    font-size: 13px;
	    font-weight: bold;
	    letter-spacing: 0;
	    margin: 5px 12px;
	    overflow: visible;
	    padding: 5px 12px;
	    text-shadow: 1px 1px #025284;
	    text-transform: none;
		text-decoration:none;
	}
	</style>
	
	<script> window.onload=function(){self.print();}  </script>
	
<div>	 
<table width="800">
		<tr>
			<td><div><?php echo $this->element('vadodara_header');?> </div></td>
		</tr>
</table>
	<hr>
	<table align="center" border="0">
		<tr>
			<td style="color: red;font-size: 18px;text-align: center;"><u>Purchase Order Slip</u></td>  
	    </tr>
	</table>	
</div>

<table width="100%" border="0">
	<tr> 
		<td width="8%">PO No</td>
		<td width="2%">:</td>
		<td><?php echo $PurchaseOrder['PurchaseOrder']['purchase_order_number'];?></td>
		<td style="text-align:right;">Order Date : <?php echo $this->DateFormat->formatDate2Local($PurchaseOrder['PurchaseOrder']['create_time'],Configure::read('date_format'),true); ?></td>
	</tr>
	<tr>
		<td width="8%">Supplier</td>
		<td width="2%">:</td>
		<td><?php echo $PurchaseOrder['InventorySupplier']['name'];?></td>
		<td></td>
	</tr> 
</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px">
	     <tr>
			<td width="2%" class="boxBorderBot boxBorderRight boxBorderLeft boxBorderTop" style="text-align: center;">SR No.</td>
			<td width="18%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center ;">ITEM NAME</td>
			<td width="2%" class="boxBorderBot boxBorderRight  boxBorderTop" style="text-align: center;">PACK</td>
			<td width="10%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">BATCH</td>
			<td width="4%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">RATE</td>
			<td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">QTY</td>
			<td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">AMOUNT</td>
	     </tr>	 	
	    <?php $count = 0; $total=0; foreach($items as $item) { $count++; ?>
			
	  	<tr>
			<td valign="top" class="boxBorderRight boxBorderLeft" style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $count;?>&nbsp;</td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: left; "><?php echo $item['Product']['name']; ?>&nbsp;</td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: center; "><?php echo $item['Product']['pack']; ?>&nbsp;</td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $item['PurchaseOrderItem']['batch_number'];?></td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $purchase_price = $item['PurchaseOrderItem']['purchase_price'];  ?>&nbsp;</td>
			<td valign="top" class="boxBorderRight" style="font-weight: 600;text-align: center; ">
				<?php echo $qty = $item['PurchaseOrderItem']['quantity_order']; $amount = $qty * $purchase_price; $total += $amount;?>
			</td>
			<td  valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600; text-align: right; padding-right:5px;" valign="top"><?php echo number_format(($amount),2); ?>
			</td>
		</tr> 
		<?php } ?>
	</table> 
	  	<tr width="100%" >
		  <td class="boxBorderBot" >
		  <table height= "105px;" width="90%" style="padding-left: 5px">
		  	<tr><td width="100%" class="boxBorderBot" >&nbsp;</td></tr>
		  </table>
		  </td>
		  
		  </tr>
	  	<tr>
		    <td width="100%">
		    <table class="totall" width="100%" border="0" cellspacing="0" cellpadding="0" style="border:0px solid #333333;padding-left: 5px">
		      <tr>
		         <td width="350px">TOTAL PRODUCT : <?php echo $count;?></td>
		         <td style="text-align:right;">TOTAL AMOUNT: <?php ?>
				 <span style="font-size:10"><?php echo $this->Number->currency(round($total));?></span> 
				</td>
		     </tr>
		    </table></td>
		  </tr>  
<?php } else {  ?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo __('Purchase Order'); ?></title>
<style>
body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
</style>
</head> 
<body onload="window.print();>

<table border="0" width="80%" align="center">
	<tr>
		<td align="center">
		<div class="inner_title">
		<h3><?php echo __('Purchase Order Slip', true); ?></h3>
		</div>
		</td>
	</tr>
</table>

<hr width="80%">

<table border="0" width="80%" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<td width="20%"><font style="font-weight: bold;">Purchase Order Number:</font></td>
		<td width="30%"><?php echo $PurchaseOrder['PurchaseOrder']['purchase_order_number'];?></td>
		<td width="50%" colspan="2" align="right"></td>
	</tr>

	<tr>
		<td width="20%"><font style="font-weight: bold;"><font style="font-weight: bold;">Supplier:</font></font></td>
		<td width="30%"><?php echo $PurchaseOrder['InventorySupplier']['name'];?></td>
		<td width="50%" colspan="2" align="right"></td>
	</tr>

	<tr>
		<td width="20%"><font style="font-weight: bold;"><font style="font-weight: bold;">Date of Order::</font></font></td>
		<td width="30%"><?php echo $this->DateFormat->formatDate2Local($PurchaseOrder['PurchaseOrder']['create_time'],Configure::read('date_format'),true); ?></td>
		<td width="50%" colspan="2" align="right"></td>
	</tr>
</table>
<hr width="80%">

<table width="80%" cellpadding="0" cellspacing="0" border="1" align="center">
	<thead>
		<tr>
			<th width="40" align="center" valign="top"	style="text-align: center;">Sr.No.</th>
			<th width="150" align="center" valign="top"	style="text-align: center;">Item Name</th> 
			<th width="60" valign="top" style="text-align: center;">Pack</th>
			<th width="80" align="center" valign="top" style="text-align: center;">Batch Number</th>
			<th width="60" valign="top" style="text-align: center;">Purchase Price</th> 
			<?php if($this->Session->read('website.instance') == 'kanpur'){ ?> 
			<th width="60" valign="top" style="text-align: center;">Vat of Class</th>
			<?php } else if($this->Session->read('website.instance') == 'hope') { ?>
			<th width="60" valign="top" style="text-align: center;">Tax</th>
			<?php }?>
			<th width="60" valign="top" style="text-align: center;">Quantity Ordered</th>
			<th width="60" valign="top" style="text-align: center;">Amount</th>
		</tr>
	</thead>

	<tbody>
	<?php $count = 0; $total=0; foreach($items as $item) { $count++; ?>
		<tr>
			<td align="center" valign="top"	style="text-align: center;"><?php echo $count; ?></td>
			<td align="center" valign="top"	style="text-align: center;"><?php echo $item['Product']['name']; ?></td> 
			<td align="center" valign="top"	style="text-align: center;"><?php echo $item['Product']['pack']; ?></td>
			<td align="center" valign="top"	style="text-align: center;"><?php echo $item['PurchaseOrderItem']['batch_number']; ?></td>
			<td style="text-align: center"><?php echo $purchase_price = $item['PurchaseOrderItem']['purchase_price']; ?></td>  
			<?php if($this->Session->read('website.instance') == 'kanpur'){ ?> 
			<td align="center" valign="top"	style="text-align: center;">
			<?php echo $item['VatClass']['vat_of_class'];
					$qty =  $item['PurchaseOrderItem']['quantity_order'];
					$vat = $item['VatClass']['sat_percent'] + $item['VatClass']['vat_percent'];
					$vatAmt = ($qty * $purchase_price * $vat) /100;
					$totalVat += $vatAmt; ?>
			</td>
			<?php } else if($this->Session->read('website.instance') == 'hope') { ?>
			<td align="center" valign="top"	style="text-align: center;">
			<?php echo $tax = $item['PurchaseOrderItem']['tax'];
					$qty =  $item['PurchaseOrderItem']['quantity_order'];
					$vatAmt = ($qty * $purchase_price * $tax) /100;
					$totalVat += $vatAmt; ?>
			<?php }?></td>
			<td style="text-align: center"><?php echo $item['PurchaseOrderItem']['quantity_order']; ?></td>
			<td style="text-align: right"><?php echo number_format($item['PurchaseOrderItem']['amount'],2); ?></td>
			<?php $total = $total + $item['PurchaseOrderItem']['amount']; ?>
		</tr>
		<?php } ?>
		<?php if($this->Session->read('website.instance') == 'vadodara') $colspan = 6; else $colspan = 7; ?>
		<tr>
		<td colspan="<?php echo $colspan; ?>" valign="middle" align="right">
			<table>
				<tr>
					<td>
						<?php echo __('Total Amount');  ?>
					</td>
				</tr>
				<?php if($this->Session->read('website.instance') != 'vadodara') { ?> 
				<tr>
					<td>
						<?php echo __('Total Tax');?>
					</td>
				</tr>
				
				<tr>
					<td>
						<?php echo __('Net Amount');?>
					</td>					
				</tr>
				<?php } ?>
			</table>
		</td>
		
		<td align="right" style="text-align: right;">
			<table align="right">
				<tr>
					<td align="right" style="text-align: right;" class="total" id="total">
					<?php echo number_format(round($total),2);?>
					</td>
				</tr>
				<?php if($this->Session->read('website.instance') != 'vadodara') { ?> 
				<tr>
					<td align="right"  style="text-align: right;" class="Tvat" id="Tvat">
					<?php echo number_format(round($totalVat),2); ?>
					</td>
				</tr>
				
				<tr>
					<td align="right" style="text-align: right;" class="Tnet" id="Tnet">
					<?php echo number_format(round($total + $totalVat),2);?>
					</td>
				</tr>
				<?php } ?>
			</table>	
		</td>
		</tr>
	</tbody>
</table>
</body>
</html>
<?php } ?>
