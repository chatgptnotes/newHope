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
		body{margin:-125px 0 0 0; padding:0;}
		p{margin:0; padding:0;}
		.page-break {
			page-break-before: always;
		}
		.boxBorderBot{border-bottom:1px dashed #3E474A;}
		.boxBorderTop{border-top:1px dashed #3E474A;}
		.boxBorderRight{border-right:1px dashed #3E474A;}
		.boxBorderLeft{border-left:1px dashed #3E474A;}
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
	<!--  <div align="right" id="printBtn"><a class="blueBtn" href="#" onclick="this.style.display='none';window.print();">Print</a></div> -->
	
      <table>
		   <tr>
		       <td height="260px" width="7%" style="color: red;font-size: 20px;text-align: center;"><u>Sales Bill Receipt </u></td>
		   </tr>
		  
	</table>
	<?php	  
		if($section == "PurchaseReceipt"){
			$model = "InventoryPurchaseItemDetail";
			$saleHeader = $this->render('inventory_purchase_bill_print');
		}else if($section == "PharmacySalesBill"){
			$model = "PharmacySalesBillDetail";
			$taxSection = 'PharmacySalesBill';
			$rowCnt  = count($data['PharmacySalesBillDetail']) ;
			$saleHeader = $this->render('inventory_sales_bill_print');
			$heading = "Sales Bill";
		}else if($section == "InventoryPurchaseReturn"){
			$model = "InventoryPurchaseReturnItem";
			$taxSection = 'InventoryPurchaseDetail';
			$rowCnt  = count($data['PharmacySalesBillDetail']) ;
			$saleHeader =  $this->render('inventory_purchase_bill_print');
			$heading = "Purchase Return";
		}else if($section == "PharmacyDuplicateSalesBill"){
			$model = "PharmacyDuplicateSalesBillDetail";
			$taxSection = 'PharmacyDuplicateSalesBill';
			$saleHeader = $this->render('inventory_sales_bill_print');
			$rowCnt  = count($data['PharmacyDuplicateSalesBillDetail']) ;
			$heading = "Duplicate Sales Bill";
		}else{
			$model = "InventoryPharmacySalesReturnsDetail";
			$taxSection = null;
			$saleHeader = $this->render('inventory_sales_return_bill_print');
			$rowCnt  = count($data['InventoryPharmacySalesReturnsDetail']) ;
			$heading = "Sales Return";
		}
		
		$count = 1; $grandtotal = 0;
		$p= 1  ; 
		$cntInit = 0 ;
		//foreach($data as $key => $item) {
		
		$pageNoTodisplayDiscount = ceil($rowCnt/$cntInit);
		if($rowCnt < $cntInit){			 
			$rowCntModSurPlus = $rowCnt+($cntInit-$rowCnt) ;
		}else if($rowCnt%$cntInit!=0) { //if count is not from 10 multiplier
			$rowCntMod = $rowCnt%$cntInit ;
			$rowCntModSurPlus = $rowCnt+($cntInit-$rowCntMod) ;
		}else{
			$rowCntModSurPlus = $rowCnt ;
		}

		if($section == "PharmacySalesBill") 
		{
			$discount  = $data['PharmacySalesBill']['discount'];
			$tax = $data['PharmacySalesBill']['tax'];
		}
		$itemObj = Classregistry::init('PharmacyItem');

		//$saleBillHeader = $this->render('inventory_sales_bill_print') ;
		for($i=0;$i<$rowCntModSurPlus;$i++){
			 
			//$item = $data[$i] ;
			if($section == "PharmacySalesBill")
			{
				$item['PharmacySalesBillDetail'] = $data['PharmacySalesBillDetail'][$i];
				
				$pharItem = $itemObj->find('first',array('conditions' =>array('PharmacyItem.id' => $item['PharmacySalesBillDetail']['item_id']))); 
				//debug($pharItem);
				$shelf = $pharItem['PharmacyItem']['shelf'];
				$productName = $pharItem['PharmacyItem']['name'];
				$pack = $pharItem['PharmacyItem']['pack'];
				$batch_number = $item['PharmacySalesBillDetail']['batch_number'];
				$packOFproduct = (int)$item['PharmacySalesBillDetail']['pack'];	//mg, 's, ml, etc...
				$itemType = $item['PharmacySalesBillDetail']['qty_type']; 		//Tab, Pack or unit
				$qty = $item['PharmacySalesBillDetail']['qty'];
				
				if(!empty($item['PharmacySalesBillDetail']['sale_price'])){
					$newDate = explode("-",$item['PharmacySalesBillDetail']['expiry_date']); 
					$expiry_date = (!empty($item['PharmacySalesBillDetail']['expiry_date'])) ? $newDate[1]."/".$newDate[0] : "";	
				}else{
					$newDate = explode("-",$pharItem['PharmacyItemRate']['expiry_date']); 
					$expiry_date = (!empty($pharItem['PharmacyItemRate']['expiry_date'])) ? $newDate[1]."/".$newDate[0] : "";
				}
				
				if(!empty($item['PharmacySalesBillDetail']['sale_price'])){
					$price = (float)$item['PharmacySalesBillDetail']['sale_price'];
				}
				else
				if(!empty($item['PharmacySalesBillDetail']['mrp'])){
					$price = (float)$item['PharmacySalesBillDetail']['mrp'];
				}
				else{
					if($pharItem['PharmacyItemRate']['sale_price']){
						$price = (float)$pharItem['PharmacyItemRate']['sale_price'];
					}else{
						$price = (float)$pharItem['PharmacyItemRate']['mrp'];
					}
				}
				$total = $price*$qty;
				if($itemType == "Tab"){
					$total =  ($price/$packOFproduct)*$qty;
				}
				
				/* if(!empty($pharItem['PharmacyItemRate']['vat_sat_sum']))
				{
					$vat_amt = ($total * $pharItem['PharmacyItemRate']['vat_sat_sum'])/100;
					$total = $total + $vat_amt;
				}  */
			}else 
			if($section == "PharmacyDuplicateSalesBill")
			{
				$item['PharmacyDuplicateSalesBillDetail'] = $data['PharmacyDuplicateSalesBillDetail'][$i];
				$pharItem = $itemObj->find('first',array('conditions' =>array('PharmacyItem.id' => $item['PharmacyDuplicateSalesBillDetail']['item_id']))); 
				
				$shelf = $pharItem['PharmacyItem']['shelf'];
				$productName = $pharItem['PharmacyItem']['name'];
				$pack = $pharItem['PharmacyItem']['pack'];
				$batch_number = $item['PharmacyDuplicateSalesBillDetail']['batch_number'];
				$packOFproduct = (int)$item['PharmacyDuplicateSalesBillDetail']['pack'];	//mg, 's, ml, etc...
				$itemType = $item['PharmacyDuplicateSalesBillDetail']['qty_type']; 		//Tab, Pack or unit
				$qty = $item['PharmacyDuplicateSalesBillDetail']['qty'];
				
				if(!empty($item['PharmacyDuplicateSalesBillDetail']['sale_price'])){
					$newDate = explode("-",$item['PharmacyDuplicateSalesBillDetail']['expiry_date']); 
					$expiry_date = (!empty($item['PharmacyDuplicateSalesBillDetail']['expiry_date'])) ? $newDate[1]."/".$newDate[0] : "";	
				}else{
					$newDate = explode("-",$pharItem['PharmacyItemRate']['expiry_date']); 
					$expiry_date = (!empty($item['PharmacyDuplicateSalesBillDetail']['expiry_date'])) ? $newDate[1]."/".$newDate[0] : "";
				}
				
				if(!empty($item['PharmacyDuplicateSalesBillDetail']['sale_price'])){
					$price = (float)$item['PharmacyDuplicateSalesBillDetail']['sale_price'];
				}
				else
				if(!empty($item['PharmacyDuplicateSalesBillDetail']['mrp'])){
					$price = (float)$item['PharmacyDuplicateSalesBillDetail']['mrp'];
				}
				else{
					if($pharItem['PharmacyItemRate']['sale_price']){
						$price = (float)$pharItem['PharmacyItemRate']['sale_price'];
					}else{
						$price = (float)$pharItem['PharmacyItemRate']['mrp'];
					}
				}
				$total = $price*$qty;
				if($itemType == "Tab"){
					$total =  ($price/$packOFproduct)*$qty;
				} 
			}
			//section for InventoryPharmacySalesReturn
			else{
				$item['InventoryPharmacySalesReturnsDetail'] = $data['InventoryPharmacySalesReturnsDetail'][$i]; 
				
				$pharItem = $itemObj->find('first',array('conditions' =>array('PharmacyItem.id' => $item['InventoryPharmacySalesReturnsDetail']['item_id'])));
				//debug($pharItem);
				$shelf = $pharItem['PharmacyItem']['shelf'];
				$productName = $pharItem['PharmacyItem']['name']; 
				$pack = $pharItem['PharmacyItem']['pack']; 
				$batch_number = $item['InventoryPharmacySalesReturnsDetail']['batch_no'];
				$packOFproduct = (int)$item['InventoryPharmacySalesReturnsDetail']['pack'];	//mg, 's, ml, etc...
				$itemType = $item['InventoryPharmacySalesReturnsDetail']['qty_type']; 		//Tab, Pack or unit
				
				$qty = $item['InventoryPharmacySalesReturnsDetail']['qty'];
				
				if(!empty($item['InventoryPharmacySalesReturnsDetail']['sale_price'])){
					$newDate = explode("-",$item['InventoryPharmacySalesReturnsDetail']['expiry_date']);
					$expiry_date = (!empty($item['InventoryPharmacySalesReturnsDetail']['expiry_date'])) ? $newDate[1]."/".$newDate[0] : "";
				}else{
					$newDate = explode("-",$pharItem['PharmacyItemRate']['expiry_date']);
					$expiry_date = (!empty($item['InventoryPharmacySalesReturnsDetail']['expiry_date'])) ? $newDate[1]."/".$newDate[0] : "";
				}
				
				if(!empty($item['InventoryPharmacySalesReturnsDetail']['sale_price'])){
					$price = (float)$item['InventoryPharmacySalesReturnsDetail']['sale_price'];
				}
				else
					if(!empty($item['InventoryPharmacySalesReturnsDetail']['mrp'])){
					$price = (float)$item['InventoryPharmacySalesReturnsDetail']['mrp'];
				}
				else{
					if($pharItem['InventoryPharmacySalesReturn']['sale_price']){
						$price = (float)$pharItem['InventoryPharmacySalesReturnsDetail']['sale_price'];
					}else{
						$price = (float)$pharItem['InventoryPharmacySalesReturnsDetail']['mrp'];
					}
				}
			
				$total = $price*$qty;
				if($itemType == "Tab"){
					$total =  ($price/$packOFproduct)*$qty; 
				}
	   }
			
			if($i != 0) /* echo "</table>"; 
			   if($isPageBreak == true){
			   		echo '<div class="page-break" style="clear: both; height:5px;"></div>';
			   }*/
			 ?>
			
	<!-- 	<table width="90%" border="0" cellspacing="0" cellpadding="0" align="" > -->
			<?php

				if($p%($cntInit) ==1 || $p==1)
				{
					if($p>1){	
				?>	
				
				<?php  
					}
					echo $saleHeader;	//header
				?>
		<!-- 		 <tr style="height: 30px;">
					<td></td>
				</tr>
				
				<tr><td width="100%"> -->
				<table width="90%" border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px">
					     <tr>
					      <td width="2%" class="boxBorderBot boxBorderRight boxBorderLeft boxBorderTop" style="text-align: center;padding-left: 10px">S No.</td>
					      <td width="18%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: left ;">DESCRIPTION</td>
					      <td width="2%" class="boxBorderBot boxBorderRight  boxBorderTop" style="text-align: center;padding-left: 10px">QUANTITY</td>
						  <td width="10%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">BATCH</td>
						  <td width="4%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">EXP.</td>
						  <td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">RATE</td>
						  <td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">AMOUNT</td>
								        
					     </tr>	
		 <?php }//EOF counter 10 ?>		
	  
			<tr>
				<td valign="top" class="boxBorderRight boxBorderLeft " 
					style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $p;?>&nbsp;</td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;font-weight: 600;text-align: left; "><?php echo $productName; ?>&nbsp;</td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;font-weight: 600;text-align: center; "><?php echo $qty; ?>&nbsp;</td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $batch_number;?></td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $expiry_date; ?>&nbsp;</td>
				<td valign="top" class="boxBorderRight"
					style="font-weight: 600;text-align: right; ">
					<?php 
					echo number_format($price/$packOFproduct,2); 
					?>
				</td>
			
					<?php
						$grandtotal = (!empty($qty)) ? $grandtotal+$total : $grandtotal;
					?>
				<td  valign="top" class="boxBorderRight"
					style="font-size: 14px;font-weight: 600; text-align: right;
					valign="top"><?php echo (!empty($qty))? number_format($total,2):"";  ?></td>
			</tr>
			<?php  $p++;
			
		}?>
		</table>
	
	 
	  <?php 
	  $isPageBreak = false;
	  if((($p%($cntInit)==0) || $rowCntModSurPlus==$p) && ($p!=1 || $rowCntModSurPlus==1)) {
	  	$isPageBreak = true; 
	  	?>
	  	<tr width="90%" >
		  <td class="boxBorderBot" >
		  <table height= "105px;" width="90%" style="padding-left: 5px">
		  	<tr><td width="90%" class="boxBorderBot" >&nbsp;</td></tr>
		  </table>
		  </td>
		  
		  </tr>
	  	<tr>
		    <td width="90%">
		    <table class="totall" width="90%" border="0" cellspacing="0" cellpadding="0" style="border:0px solid #333333;padding-left: 5px">
		      <tr>
		         <td width="350px">TOTAL PRODUCT : <?php echo $p-1?></td>
		         <td>TOTAL : <?php
				if(isset($taxSection) && isset($data[$taxSection]['tax'])){
			?>
				<span style="font-size:10">Tax: <?php echo $tax;?>%</span>
			<?php
		    }
				if(isset($tml)){
					//echo "<span style='font-size:10'>".$tml.": ".$amt."</span>";
				}
			?>
		
				<?php
					//echo $this->Number->currency(($item['PharmacySalesBill']['total']));
					echo $this->Number->currency($grandtotal);
				?>
				</td>
		     </tr>
		      <tr>
		         <td width="350px">PHARMACIST : <?php echo $userName?></td>
		         <?php if(!empty($discount)){ ?>
		         <td>DISCOUNT : <?php echo $this->Number->currency($discount);?></td>
		         <?php } ?>
		     </tr>
		     <tr><td height="10px"></td></tr>
		     <tr>
		       <td width="680px">CREATED TIME: <?php echo $this->DateFormat->formatDate2Local($createdDate,Configure::read('date_format'));?></td>
		       <td width="250">PLEASE PAY :<?php
				if(isset($taxSection) && isset($data[$taxSection]['tax'])){
			?>
				<span style="font-size:10">Tax: <?php echo $tax."%"; $totalTax = ($grandtotal*$tax)/100?></span>
			<?php
		    }
				if(isset($tml)){
					//echo "<span style='font-size:10'>".$tml.": ".$amt."</span>";
				}
			?>
				<?php
					//echo $this->Number->currency(($item['PharmacySalesBill']['total']));
					//echo $this->Number->currency($grandtotal);
				
				  echo $this->Number->currency($grandtotal - $discount + $totalTax);
			
				?></td>
		     </tr> 
		      
		    </table></td>
		  </tr>
	  	<?php $count = $count+1;
	  }
	 
	//} eof foreach  ?>
	
	<script>
	window.onload=function(){self.print();} 
	</script>
	
