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
	
	 @page:last{
		@bottom {
	      content: element(footer);
	      
	    }
	 }
	 
	@page:last {
	    @bottom-center {
	        content: "…";
	    }
	}
	 
	 

		body{margin:7px 0 0 0; padding:0;
			font-family:"Courier New", Courier, monospace;
		}
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
	<!--  <div align="right" id="printBtn"><a class="blueBtn" href="#" onclick="this.style.display='none';window.print();">Print</a></div> -->
	<?php 
	//debug($section);?>
	
<?php	  
		
		if($section == "PurchaseReceipt"){
			$model = "InventoryPurchaseItemDetail";
			$saleHeader = $this->render('inventory_purchase_bill_print');
		}else if($section == "PharmacySalesBill"){
			$model = "PharmacySalesBillDetail";
			$taxSection = 'PharmacySalesBill';
			$rowCnt  = count($data['PharmacySalesBillDetail']) ;
			//$saleHeader = $this->render('inventory_sales_bill_print');
			$saleHeader = $this->render('print_without_header_kanpur');
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
			//$saleHeader = $this->render('inventory_sales_bill_print');
			$saleHeader = $this->render('print_without_header_kanpur');
			$rowCnt  = count($data['PharmacyDuplicateSalesBillDetail']) ;
			$heading = "Duplicate Sales Bill";
		}else if($section == "InventoryPharmacyDirectSalesReturnsDetail"){
			$model = "InventoryPharmacySalesReturnsDetail";
			$taxSection = null;
			//$saleHeader = $this->render('inventory_other_sales_return_print');
			$saleHeader = $this->render('print_without_header_kanpur');
			$rowCnt  = count($data['InventoryPharmacySalesReturnsDetail']) ;
			$heading = "Sales Return";
		}else if($section == "InventoryPharmacySalesReturnsDetail"){
			$model = "InventoryPharmacySalesReturnsDetail";
			$taxSection = null;
			$saleHeader = $this->render('print_without_header_kanpur');
			$rowCnt  = count($data['InventoryPharmacySalesReturnsDetail']) ;
			$heading = "Sales Return";
		}else if($section == "DirectSalesReturn"){
			$model = "InventoryPharmacySalesReturnsDetail";
			$taxSection = null;
			$saleHeader = $this->render('print_without_header_kanpur');
			$rowCnt  = count($data['InventoryPharmacySalesReturnsDetail']) ;
			$heading = "Direct Sales Return";
		}else{
			$model = "InventoryPharmacySalesReturnsDetail";
			$taxSection = null;
			$saleHeader = $this->render('inventory_sales_return_bill_print');
			$rowCnt  = count($data['InventoryPharmacySalesReturnsDetail']) ;
			$heading = "Sales Return";
		}
		
		$count = 1; $grandtotal = 0;$grandActTotal=0;
		$p= 1  ; 
		$cntInit = 8 ;
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
				} */
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
				
				$qty = $item['InventoryPharmacySalesReturnsDetail']['qty'];
				
				if(!empty($item['InventoryPharmacySalesReturnsDetail']['sale_price'])){
					$price = (float)$item['InventoryPharmacySalesReturnsDetail']['sale_price'];
				}
				else
				if(!empty($item['InventoryPharmacySalesReturnsDetail']['mrp'])){
					$price = (float)$item['InventoryPharmacySalesReturnsDetail']['mrp'];
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
			
			if($i != 0){ // echo "</table>"; 
			   if($isPageBreak == true){
			   		//echo '<div class="page-break" style="clear: both; height:5px;"></div>';
			   }
			}
			 ?>
			
	<!-- 	<table width="90%" border="0" cellspacing="0" cellpadding="0" align="" > -->
			<?php
				if($p%($cntInit) ==1 || $p==1)
				{
					if($p>1){
				?>	
				</table>
				<?php  
					if($p != $rowCntModSurPlus){ ?>
					<table width="90%" align="center">
						<tr>
							<td align="right"><?php echo __("To be continued..") ;?></td>
						</tr>
					</table>
				<?php }  
						echo '<div class="page-break" style="clear: both; height:5px;"></div>';
					}
				
					echo $saleHeader;	//header
				?>
		 
				<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px">
					     <tr>
					      <td width="1%" class="boxBorderBot boxBorderRight boxBorderLeft boxBorderTop" style="text-align: center;padding-left: 10px">Sr.</td>
					      <td width="20%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: Center ;">DESCRIPTION</td>
					      <td width="2%" class="boxBorderBot boxBorderRight  boxBorderTop" style="text-align: center;">QUANTITY</td>
						  <td width="10%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">BATCH</td>
						  <td width="4%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">EXP.</td>
						  <td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">RATE</td>
						  <?php if(($section == "InventoryPharmacyDirectSalesReturnsDetail" || $section == "DirectSalesReturn")){ ?> 
						 <td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">MRP</td>
						 <?php }?>
						  <td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">AMOUNT</td>
						 
								        
					     </tr>	
		 <?php }//EOF counter 10 ?>		
	  
			<tr>
				<td valign="top" class="boxBorderRight boxBorderLeft " 
					style="font-size: 14px;text-align: center;"><?php echo !empty($qty)?$p:'';?>&nbsp;</td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;text-align: center; "><?php echo $productName; ?>&nbsp;</td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;text-align: center; "><?php echo $qty; ?>&nbsp;</td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;text-align: center;"><?php echo $batch_number;?></td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;text-align: center;"><?php echo $expiry_date; ?>&nbsp;</td>
				<td valign="top" class="boxBorderRight" style="text-align: center; ">
					<?php echo !empty($qty)?number_format($price/$pack,2):''; ?>
				</td>
			
					<?php 
						$grandtotal = (!empty($qty)) ? $grandtotal+$total : $grandtotal;
					?>
					
					<?php 
					 if(($section == "InventoryPharmacyDirectSalesReturnsDetail" || $section == "DirectSalesReturn")){ 	
				     	
						//$actualAmnt=$pharItem['PharmacyItemRate']['sale_price'];  Commented by mrunal
				     	$actualQty=$item['InventoryPharmacySalesReturnsDetail']['qty'];
				     	$actualTotal = $price*$actualQty;
				     	if($itemType == "Tab"){
				     		$actualTotal =  ($price/$packOFproduct)*$actualQty;
				     	}
				     	
				     	$grandActTotal= (!empty($actualQty)) ? $grandActTotal+$actualTotal : $grandActTotal;
					?> 
				<td  valign="top" class="boxBorderRight" style="font-size: 14px; text-align: center;"><?php echo !empty($qty)?number_format($price/$pack,2):''; //echo !empty($actualQty)?number_format($actualTotal,2):'';unset($actualQty); ?></td>
				 <?php }?>
				<td  valign="top" class="boxBorderRight" style="font-size: 14px; text-align: center;">
					<?php echo (!empty($qty))? number_format($total,2):""; unset($qty); ?></td>
					
			</tr>
			
			<?php 
			$isPageBreak = false;
			//if((($p%($cntInit)==0) || $rowCntModSurPlus==$p) && ($p!=1 || $rowCntModSurPlus==1)) {
			if($p%($cntInit)==0){
				//debug("break");
				//$isPageBreak = true; 
			}
			$p++;
		}    ?>
		</table>

		<table width="90%" align="center" class="footer" id="footer" style="padding-top:5px;">
	  	<tr>
		    <td width="90%">
		    <table class="totall" width="100%" border="0" cellspacing="0" cellpadding="0" style="border:0px solid #333333;padding-left: 5px">
		      <tr>
		         <td width="350px">TOTAL PRODUCT : <?php echo $rowCnt?></td>
		         
		         <?php if(($section == "InventoryPharmacyDirectSalesReturnsDetail")){	?>
		         <td style="text-align: right">TOTAL AMOUNT : 
						<?php 
							echo number_format($grandtotal,2);
						?>
				</td>
		         <?php }else if($section == "DirectSalesReturn"){
		         		
		         	?>
		         <td style="text-align: right">TOTAL AMOUNT: 
						<?php 
							echo number_format($grandActTotal,2);
						?>
				</td>
				<?php }else{?>
				<td style="text-align: right">TOTAL : 
						<?php 
							echo number_format($grandtotal,2);
						?>
				</td>
				<?php }?>
				
		     </tr>
		      <tr>
		         <td width="350px">PHARMACIST : <?php echo $userName?></td>
		          <?php if(!empty($discount)){ ?>
		           <td style="text-align: right">DISCOUNT : <?php echo number_format($discount,2);?></td>
		          <?php }else if($section == 'DirectSalesReturn' || $section == "InventoryPharmacySalesReturnsDetail" || $section == "InventoryPharmacyDirectSalesReturnsDetail"){
		          	if($data['InventoryPharmacySalesReturn']['discount_amount']){
						$returnTotalDiscount = $data['InventoryPharmacySalesReturn']['discount_amount'];
					}else{
						$returnDiscPerc = $data['InventoryPharmacySalesReturn']['discount'];
						$returnTotalDiscount = ($grandtotal*$returnDiscPerc)/100;
					}
		          	
		          	
		          	?>
		          <td style="text-align: right">Discount : <?php echo number_format($returnTotalDiscount,2);?></td>
		          <?php }?>
		     </tr>
		     <tr><td height="10px"></td></tr>
		     <tr>
		       <td width="500px">CREATED TIME : <?php echo $this->DateFormat->formatDate2Local($createdDate,Configure::read('date_format'));?></td>
		       
		       <td width="300px" style="text-align: right"><?php    
		       if($section == "InventoryPharmacyDirectSalesReturnsDetail" || $section == "InventoryPharmacySalesReturnsDetail" || $section == "DirectSalesReturn"){ 
		       	echo __("RETURN AMOUNT :");
		        } else if($section == "PharmacySalesBill" && $data['PharmacySalesBill']['paid_amnt']!='') { 
               echo __("PAID AMOUNT  :"); 
                }else{
               echo __("PLEASE PAY :");
                }?>
		       <?php
				if(isset($taxSection) && isset($data[$taxSection]['tax'])){
			?>
				<span style="font-size:10">Tax: <?php echo $tax."%"; $totalTax = ($grandtotal*$tax)/100;?></span>
			<?php
		    }
				if(isset($tml)){
					//echo "<span style='font-size:10'>".$tml.": ".$amt."</span>";
				}
			?>
				<?php
					
				if($section == "DirectSalesReturn" || $section == "InventoryPharmacySalesReturnsDetail" || $section == "InventoryPharmacyDirectSalesReturnsDetail"){
					echo number_format(round($grandtotal - $returnTotalDiscount + $totalTax),2);
				}else{
				    echo number_format(round($grandtotal - $discount + $totalTax),2);
				    }
				?></td>
		     </tr> 
		      
		    </table></td>
		  </tr>
	  	<?php $count = $count+1;   ?>
     </table>
	    <!--  <table  width="90%"  border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px;" >   -->     
	      <table width="90%" align="center" border="0" cellspacing="0" cellpadding="0" id="footerRoman" >      
	        <tr>
	         <td colspan="4" align="right" width="90px" class="boxBorderBotSolid" ></td>
	       </tr>
	       
	     
	       
     <!-- <tr >
	         <td style="text-align: center;font-size: 12px; font-weight: bold;"><ul type="disc" ><li >HERBAL MEDICINES</li></ul></td>
	         <td style="text-align: center;font-size: 12px; font-weight: bold;"><ul type="disc"><li>VACCINES</li></ul></td>
	         <td style="text-align: center;font-size: 12px; font-weight: bold;"><ul type="disc"><li>IMPORTED MEDICINES</li></ul></td>
	         <td style="text-align: center;font-size: 13px; font-weight: bold;">www.romanpharma.com</td>
	       </tr>-->
	  </table>
	  </table>  
 	
	<script>
	window.onload=function(){self.print();} 
	</script>
