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
	
<div>	 
    <table width="800">
		<tr>
			<td><div><?php echo $this->element('vadodara_header');?> </div></td>
		</tr>
    </table>
	<hr>
	<table align="center" border="0">
		<tr>
			<td style="color: red;font-size: 18px;text-align: center;"><u>Good Received Note Slip</u></td>  
	    </tr>
	</table>	
</div>

<table width="100%" border="0">
	<tr> 
		<td width="8%">GRN No</td>
		<td width="2%">:</td>
		<td><?php echo $receipt_items[0]['PurchaseOrderItem']['grn_no'];?></td>
		<td style="text-align:right;">Invoice No. : <?php echo $receipt_items[0]['PurchaseOrderItem']['party_invoice_number']; ?></td>
	</tr>
	<tr>
		<td width="8%">Supplier</td>
		<td width="2%">:</td>
		<td><?php echo $po_details['InventorySupplier']['name']; ?></td>
		<td style="text-align:right;">Received Date : <?php echo $this->DateFormat->formatDate2Local($receipt_items[0]['PurchaseOrderItem']['received_date'],Configure::read('date_format'),false); ?></td>
	</tr> 
</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px">
	     <tr>
			<td width="1%" class="boxBorderBot boxBorderRight boxBorderLeft boxBorderTop" style="text-align: center;">SR No.</td>
			<td width="18%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center ;">ITEM NAME</td>
			<td width="2%" class="boxBorderBot boxBorderRight  boxBorderTop" style="text-align: center;">PACK</td>
			<td width="10%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">BATCH</td>
			<td width="10%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">EXP</td>
			<td width="10%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">MRP</td>
			<td width="10%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">PURC</td>
			<td width="10%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">SALE</td>
			<td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">QTY</td>
			<td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">AMOUNT</td>
	     </tr>	
	      	
	    <?php $count=0; $total = 0; $vatTotal = 0; foreach($receipt_items as $key=>$item) { $count++;?>
	  	<tr>
			<td valign="top" class="boxBorderRight boxBorderLeft" style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $count;?></td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: left; padding-left:2px;"><?php echo $item['Product']['name']; ?></td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: center; "><?php echo $item['Product']['pack']; ?></td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $item['PurchaseOrderItem']['batch_number'];?></td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $this->DateFormat->formatDate2Local($item['PurchaseOrderItem']['expiry_date'],Configure::read('date_format'),false);?></td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $item['PurchaseOrderItem']['mrp'];?></td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $purchase_price = $item['PurchaseOrderItem']['purchase_price'];?></td>
			<td valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $item['PurchaseOrderItem']['selling_price'];  ?></td>
			<td valign="top" class="boxBorderRight" style="font-weight: 600;text-align: center; ">
				<?php echo $qty = ($item['PurchaseOrderItem']['quantity_received']); $amount = $qty * $purchase_price; $total += $amount;?>
			</td>
			<td  valign="top" class="boxBorderRight" style="font-size: 14px;font-weight: 600; text-align: right; padding-right:5px;" valign="top"><?php echo number_format(($amount),2); ?>
			</td>
		</tr> 
		<?php } ?>
		
	</table> 
	  	<tr width="100%" >
		  <td class="boxBorderBot" >
		  <table height= "105px;" width="90%" style="padding-left: 5px">
		  	<tr><td width="90%" class="boxBorderBot" >&nbsp;</td></tr>
		  </table>
		  </td>
		  
		  </tr>
	  	<tr>
		    <td width="100%">
		    <table class="totall" width="100%" border="0" cellspacing="0" cellpadding="0" style="border:0px solid #333333;">
		      <tr>
		         <td width="350px">TOTAL PRODUCT : <?php echo $count;?></td>
		         <td style="text-align:right;">TOTAL AMOUNT: <?php ?>
				 <span style="font-size:10"><?php echo $this->Number->currency(round($total));?></span> 
				</td>
		     </tr>
		    </table></td>
		  </tr>  
<?php } else {  ?>


<style>
	@media print {
	   @page{
	    size: 6.0in 4.0in;
	    size: portrait;
	  }
	  .printBtn{
	  	display: none;
	  }
	}
	
	.sapcing{
		font-weight:bold;
		padding-top: 10px;
	}
</style>

<?php if(!empty($po_details)) { ?>
<html moznomarginboxes mozdisallowselectionprint>
<div style="float: left;">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><font style="font-weight:bold;">PurchaseOrder No: </font> </td>
		<td class="tdLabel2">
			<?php  
				echo $po_details['PurchaseOrder']['purchase_order_number'];
			?>
		</td>
		<td><font style="font-weight:bold;">GRN No: </font> </td>
		<td class="tdLabel2">
			<?php  
				echo $receipt_items[0]['PurchaseOrderItem']['grn_no'];
			?>
		</td>
		<td><font style="font-weight:bold;">PartyInvoice No: </font></td>
		<td class="tdLabel2"> 
			<?php  
				echo $receipt_items[0]['PurchaseOrderItem']['party_invoice_number'];
			?>
		</td>
	</tr>
	<tr>
		<td><font style="font-weight:bold;">Supplier: </font> </td>
		<td class="tdLabel2">
			<?php echo $po_details['InventorySupplier']['name']; ?>
		</td>
		<td><font style="font-weight:bold;">Ordered Date: </font> </td>
		<td class="tdLabel2">
			<?php echo $this->DateFormat->formatDate2Local($po_details['PurchaseOrder']['create_time'],Configure::read('date_format'),false); ?>
		</td>
			<?php if(!empty($po_details['PurchaseOrder']['create_time'])) { ?>
		<td><font style="font-weight:bold;">Received Date: </font></td>
		<td class="tdLabel2"> 
			<?php echo $this->DateFormat->formatDate2Local($receipt_items[0]['PurchaseOrderItem']['received_date'],Configure::read('date_format'),false); ?>
		</td>
		<?php } ?>
	</tr>
	
</table>
<?php }  ?>

<div class="clr ht5"></div>

<?php echo $this->Form->create('',array('id'=>'Purchase-receipt'));?>
<table  width="100%" cellpadding="2" cellspacing="2" border="0" class="tabularForm" id="item-row">
	<thead>
		<tr>
			<th width="40" align="center" valign="top" style="text-align: center;">Sr.</th>
			<th width="100" align="center" valign="top" style="text-align: center;">ProductName</th>
			<th width="100" align="center" valign="top" style="text-align: center;">Manufacturer</th>
			<th width="60" valign="top" style="text-align: center;">Pack</th>
			<th width="80" align="center" valign="top" style="text-align: center;">Batch</th>
			<th width="60" valign="top" style="text-align: center;">Expiry Date</th>
			<th width="60" valign="top" style="text-align: center;">MRP</th>
			<th width="60" valign="top" style="text-align: center;">Pur. Price</th>
			<th width="60" valign="top" style="text-align: center;">Selling Price</th>
			<th width="60" valign="top" style="text-align: center;">SGST</th>
			<th width="20" valign="top" style="text-align: center;">CGST</th>
			<th width="60" valign="top" style="text-align: center;">Qty Ordered</th>
			<th width="60" valign="top" style="text-align: center;">Qty Received</th>
			<th width="60" valign="top" style="text-align: center;">Free</th>
			<th width="80" valign="top" style="text-align: center;">Amount</th>
		</tr>
	</thead>
	

		<?php $count=0; $total = 0; $vatTotal = 0; foreach($receipt_items as $key=>$item) { $count++; ?>
		<tr>
			<td align="center" valign="middle" class="sr_number"><?php echo $count;?></td>
			
			<td valign="middle">
				<?php
					echo $item['Product']['name'];
				?>
			</td>
			
			<td valign="middle">
				<?php
					echo $item['ManufacturerCompany']['name'];
				?>
			</td>
			
			<td align="center" valign="middle">
				<?php
					echo $item['Product']['pack'];
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo $item['PurchaseOrderItem']['batch_number'];
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					if($item['PurchaseOrderItem']['expiry_date'] != '0000-00-00')
					{
						 echo $this->DateFormat->formatDate2Local($item['PurchaseOrderItem']['expiry_date'],Configure::read('date_format'),false);
					}
					else 
					{
						echo $this->DateFormat->formatDate2Local($item['Product']['expiry_date'],Configure::read('date_format'),false);
					}
				?>
			</td>
			
			<td valign="middle" style="text-align: center;" id="mrp_<?php echo $key;?>">
				<?php
					if(!empty($item['PurchaseOrderItem']['mrp']))
						echo $item['PurchaseOrderItem']['mrp'];
					else 
						echo $item['Product']['mrp'];
				?>	
			</td>
			
			<td valign="middle" style="text-align: center;" id="mrp_<?php echo $key;?>">
				<?php
					$purchase_price = $item['PurchaseOrderItem']['purchase_price'];
					if(!empty($item['PurchaseOrder']['contract_id']) && $item['PurchaseOrderItem']['is_contract']==1)
					{
						$purchase_price = $item['PurchaseOrderItem']['purchase_price'];
					} 
					echo $purchase_price;
				?>
			</td>
			
			<td valign="middle" style="text-align: center;" id="mrp_<?php echo $key;?>">
				<?php 
					if(!empty($item['PurchaseOrderItem']['selling_price']))
						echo $item['PurchaseOrderItem']['selling_price'];
					else 
						echo $item['Product']['sale_price'];
				?>
			</td>
			<?php 
				if(!empty($item['PurchaseOrderItem']['tax'])){
					$tax = $item['PurchaseOrderItem']['tax'];
				}else{
					$tax = $item['Product']['tax'];
					
				}

				$divideGst = $tax / 2  ; 
			?>
			<td valign="middle" style="text-align: center;">
				<?php echo $divideGst ; ?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php echo $divideGst ; ?>
			</td>
	
			<td valign="middle" style="text-align: center;">
				<?php
					echo ($item['PurchaseOrderItem']['quantity_order']);
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo ($item['PurchaseOrderItem']['quantity_received']);
				?>
			</td> 
			<td valign="middle" style="text-align: center;">
				<?php
					echo ($item['PurchaseOrderItem']['free']);
				?>
			</td> 
			<td valign="middle" style="text-align: center;">
				<?php 
				if(!empty($item['PurchaseOrderItem']['quantity_received'])){
					echo $amount = $item['PurchaseOrderItem']['amount'];
				}
				?>
			</td>
			</tr>
		<?php $total = $total + $amount; } //foreach ends here ?>
		<?php if(count($returnItem)>0){?>
		<tr id = "rowCheck">
			<td colspan = "14" style="font-weight: bold;">
				<?php echo __("RETURN") ?>
			</td>
		</tr>
		<tr id = "rowReturn">
			<th width="10" align="center" valign="top" style="text-align: center;">#</th>
			<th width="100" align="center" valign="top" style="text-align: center;">Product Name</th>
			<th width="100" align="center" valign="top" style="text-align: center;">Manufacturer</th>
			<th width="20" valign="top" style="text-align: center;">Pack</th>
			<th width="40" align="center" valign="top" style="text-align: center;">Batch No.<font color="red">*</font></th>
			<th width="100" valign="top" style="text-align: center;" colspan="1">Expiry Date<font color="red">*</font></th>
			<th width="40" valign="top" style="text-align: center;">MRP<font color="red">*</font></th>
			<th width="40" valign="top" style="text-align: center;">Pur. Price<font color="red">*</font></th>
			<th width="40" valign="top" style="text-align: center;">Sale Price<font color="red">*</font></th>
			<th width="10" valign="top" style="text-align: center;">Return Qty</th>
			<th width="30" valign="top" style="text-align: center;" colspan="3">Remark</th>
			<th width="60" valign="top" style="text-align: center;">Amount</th>
		</tr>
		<?php $tcount = $count; foreach($returnItem as $key=>$item) { $cnt = 1;  $tcount++;?>
		<tr class="row" id = "row<?php echo $cnt;?>">
			<td align="center" valign="middle" class="sr_number" ><?php echo $tcount;?></td>
			<td valign="middle"><?php echo $item['Product']['name'];?></td>
			<td valign="middle"><?php echo $item['ManufacturerCompany']['name'];?></td>
			<td align="center" valign="middle"><?php echo $item['PurchaseReturn']['pack'];?></td>
			<td valign="middle" style="text-align: center;"><?php echo $item['PurchaseReturn']['batch_number'];?></td>
			<td valign="middle" style="text-align: center;" colspan="1" ><?php echo $date = $this->DateFormat->formatDate2local($item['PurchaseReturn']['expiry_date'],Configure::read('date_format'));?></td>
			<td valign="middle" style="text-align: center;"><?php echo $mrp = $item['Product']['mrp'];?></td>
			<td valign="middle" style="text-align: center;" ><?php echo $purchase_price = $item['PurchaseOrderItem']['purchase_price'];?></td>
			<td valign="middle" style="text-align: center;" ><?php echo $selling_price = $item['Product']['sale_price'];?></td>
			<td valign="middle" style="text-align: center;"><?php echo $returnQty = $item['PurchaseReturn']['return_quantity'];?></td>
			<td valign="middle" style="text-align: center;" colspan="3"><?php echo $remark = $item['PurchaseReturn']['remark'];?></td>
			<td valign="middle" style="text-align: center;"><?php echo $returnAmount = $purchase_price * $returnQty; ?></td>
			<?php echo $returnVat = $item['PurchaseReturn']['vat'];?>
		</tr>
		
		<?php  $totalRetAmnt = $totalRetAmnt + $returnAmount; 
				$totaReturnVat = $totaReturnVat + $returnVat;
				}
		 $absolutAmnt = $total - $totalRetAmnt; 
		?>
		<?php }?>
		
		<tr align="right" >
		
			<td colspan="14" class="sapcing">
				<br>
				Sub Total:<br>
				SGST Payable:<br>
				CGST Payable:<br>
				Discount:<br>
			
				
				<?php if($totaReturnVat !=0 || $totaReturnVat!=''){?>
				Total Return Vat:<br>
				<?php }?>
				Net Amount:		
				<br>
				Round Off:		
			</td>
			<td align="right" class="sapcing">	
				<br>
				<?php 
					$totalAmount = $po_details['PurchaseOrder']['total'];
					echo number_format($totalAmount,2);
				?>
				<br>
				<?php 
					$totalSgst = $po_details['PurchaseOrder']['total_sgst'];
					echo number_format($totalSgst,2);
				?>
				<br>
				<?php 
					$totalCgst = $po_details['PurchaseOrder']['total_cgst'];
					echo number_format($totalCgst,2);
				?>
				<br>
				<?php 
					$discount = $po_details['PurchaseOrder']['discount'];
					echo number_format($discount,2);
				?>
				
				<?php 
				if($totaReturnVat!=0 || $totaReturnVat!=''){
					echo $totaReturnVat;
				}
				?>
				<?php 
				
				
				$withoutRound = $totalAmount - $discount +$totalSgst + $totalCgst -$totaReturnVat;
				$rounAmnt = round($withoutRound);
				echo number_format(round($rounAmnt?$rounAmnt:0),2); ?>
				<br>
				<?php echo number_format($withoutRound-$rounAmnt,2);?>
			</td>
			
			</tr>
	
</table>
</div>
</html>
<?php } ?>
<script>
	window.onload=function(){self.print();} 
</script>