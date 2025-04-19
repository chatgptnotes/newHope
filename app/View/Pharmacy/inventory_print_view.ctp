
	<style>
 table{
    	/*padding-left:10px;*/
   letter-spacing: 6px;
   width: 99%;
   margin-top: 5px;
   margin-left: 7px;
 }
 	.lableFont{
 	    /*font-size: 12px;*/
 	    position: relative;
        font-size: 15px;
        left: -20px;
        top: -15px;

 	}
  
	.labelf{
		font-size: 14px;
	}
	@media print {
	   @page{
	    size: 6.0in 4.0in;
	     /*size: 21.00cm 10.00cm;*/
	    size: portrait;
	  }
	  .printBtn{
	  	display: none;
	  }
	   body {
    width: 100%;
    margin: 0;
    padding: 0;
  }

  /* Agar kisi aur element ki width ko bhi 100% karna ho */
  .print-container {
    width: 100%;
  }
  td {
      width
  }
	}
		body
		{
		    margin-top:4px 0 0 0;
		/*margin-left:30px;*/
		/*margin-right:30px;*/
		/*margin-bottom:30px;*/
		
		padding:0;
		    
		}
		p{
		    margin:0; padding:0;
		    
		}
		.page-break {
          page-break-before: always;
  position: relative;
  top: -6px !important;
  height: 0px;
  margin-top: -50px;
		}
		.heading{font-family:Arial, Helvetica, sans-serif; font-size:20px; font-weight:bold; color:#000000; padding:0px 0 0px 0;}
		.headAddress{font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; color:#333333;}
		.dlNo, .vatNo{font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; color:#333333;}
		.prescribeDetail{border:1px solid #666666; border-bottom:0px; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#333333;}
		/*.billTbl{background-color:#333333;}*/
		.billTbl th{background-color:#ddecc4; font-family:Arial, Helvetica, sans-serif; font-size:11px;  color:#333333;}
		.billTbl td{background-color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; color:#333333;}
		.billTotal{ font-family:Arial, Helvetica, sans-serif; font-size:17px; color:#333333;  letter-spacing: 5px;}
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
			$saleHeader = $this->render('inventory_duplicate_sales_bill_print');
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
		$cntInit = 5 ;
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
					if($pharItem['InventoryPharmacySalesReturnsDetail']['sale_price']){
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
			
			if($i != 0) echo "</table>"; 
			   if($isPageBreak == true){
			   		echo '<div class="page-break" style="clear: both;"></div>';
			   }
			 ?>
			
		<table width="100%" border="0" cellspacing="0" cellpadding="0" align=""  >
		    
			<?php

				if($p%($cntInit) ==1 || $p==1)
				{
					if($p>1){	
				?>	
				
				<?php  
					}
					echo $saleHeader;	//header
				?>
				 <tr style="height: 30px;">
					<td></td>
				</tr>		
		 <?php }//EOF counter 10 ?>	
		 <?php /** Added by Mrunal 
		 		To show generic name only in print and view	-FOR HOPE
		 		Dt:04-06-2016
-		  		*/
			 /*if (isset($pharItem['PharmacyItem']['generic'])) { 
			 	$productName = $pharItem['PharmacyItem']['generic'];
			 } */
			
		 ?>	
	  <tr>
	    <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="1"
			class="billTbl" style="border: 0px solid #333333;">
		  
			<tr>
				<td valign="top"
					style="text-align:center;"><?php echo $shelf;?>&nbsp;</td>
				<td valign="top" style="font-size: 14px; min-width: 332px; max-width: 332px;"><?php echo $productName; ?>&nbsp;</td>
				<td valign="top"
					style="text-align:center;font-size: 14px; min-width: 30px; max-width: 30px;"><?php echo $pack; ?>&nbsp;</td>
				<td valign="top"
					style="text-align:center;font-size: 14px; min-width: 20px; max-width: 25px;"><?php echo "&nbsp;";//echo $item['PharmacyItem']['manufacturer'];?></td>
				<td valign="top"
					style="text-align:left;font-size: 12px; min-width: 90px; max-width: 90px;"><?php echo $batch_number; ?>&nbsp;</td>
				<td valign="top"
					style="border-right: 0px solid #333333;font-size: 13px; min-width:60px; max-width: 60px; padding-left:20px;">
					<?php echo $expiry_date; ?>
				</td>
				<td align="center" valign="top"
					style="border-right: 0px solid #333333; font-size: 14px; min-width: 50px; max-width: 50px;"><?php echo $qty;?>&nbsp;</td>
					<?php
						$grandtotal = (!empty($qty)) ? $grandtotal+$total : $grandtotal;
					?>
				<td align="right" valign="top"
					style=" min-width: 45px; max-width: 45px;font-size: 14px; position:relative; left:-20px;font-weight:600;"
					valign="top"><?php echo (!empty($qty))? number_format($total,2):""; unset($qty); ?></td>
			</tr>
		</table>
		</td>
	  </tr>
	 
	  <?php 
	  $isPageBreak = false;
	  if((($p%($cntInit)==0) || $rowCntModSurPlus==$p) && ($p!=1 || $rowCntModSurPlus==1)) {
	  	$isPageBreak = true; 
	  	?><tr>
		    <td width="100%">
		    <table class="totall" width="100%" border="0" cellspacing="0" cellpadding="0" style="border:0px solid #333333;     position: relative;
    border-right: 0px solid #333333;
    padding: 0px;
    left: 70px;">
		      <tr>	
		        <td width="80" align="center" valign="bottom" class="billSign" style="border-left:0px solid #333333;"><?php echo "$nbsp"; ?></td>
		        <td width="113" height="40" align="right" class="billTotal" style="border-left:0px solid #333333; padding-right:0px;position: relative;right: 78px;top: 5px;letter-spacing: 5px;">
		 	
	  		<?php if($count == $pageNoTodisplayDiscount && !empty($discount)){ ?>
				<span style="font-size:10">Discount: <?php echo $this->Number->currency($discount);?></span>
			<?php } 
				  if($count == $pageNoTodisplayDiscount && !empty($tax)){ ?>
				<span style="font-size:10">Tax: <?php echo $tax."%"; $totalTax = ($grandtotal*$tax)/100?></span>
			<?php } ?>
			 
				<?php
					echo $this->Number->currency($grandtotal - $discount + $totalTax);
				?>
				</td>
		      </tr>
		       <!--<div class="page-break" style="clear: both;"></div>-->
		    </table></td>
		  </tr>
	  	<?php $count = $count+1;
	  }
	  $p++;
	} //eof foreach  ?>
	
	<script>
	window.onload=function(){self.print();} 
	</script>
