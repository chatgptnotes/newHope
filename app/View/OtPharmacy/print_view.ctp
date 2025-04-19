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
	<html xmlns="http://www.w3.org/1999/xhtml" moznomarginboxes mozdisallowselectionprint> 
	<table><tr>
	         <td width='30%'>&nbsp;</td>
	         <?php if($section == "OtPharmacySalesReturn"){?>
	         <td width="27%" style="color: red;font-size: 18px;"><u>Ot Sales Return Receipt </u></td>
	         <?php }else{?>
	         <td  width="25%" style="color: red;font-size: 18px;text-align: center;"><u> OT Sales Bill Receipt </u></td>
	         <?php }?>
	         <td width="22%">&nbsp;</td>
	       </tr></table>	
	<table width="90%"  border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px;padding-bottom: 15px"><tr><td height="25px">&nbsp;</td></tr>
	<tr>
	<td width="216px"  style="font-size: 15px;text-align: center;font-weight: bold; " class="boxBorderBotSolid"><div style="float:left"><?php echo  $this->Html->image('icons/MSA.jpg',array('width'=>100,'height'=>100)) ; ?></div></td>
				<td width="466px" style="font-size: 15px;text-align: left;font-weight: bold; "  valign="bottom" class="boxBorderBotSolid" ><div style="float:right"><?php echo  $this->Html->image('icons/KCHRC.jpg',array('width'=>100,'height'=>100)) ; ?></td>  
	</tr>
	</table>
	</div>
	<?php  
		if($section == "OtPharmacySalesBill"){
			$model = "OtPharmacySalesBillDetail";
			$taxSection = 'OtPharmacySalesBill'; 
			$rowCnt  = count($data['OtPharmacySalesBillDetail']) ;
			$saleHeader = $this->render('ot_sales_bill_print');
		
		}else{
			$model = "OtPharmacySalesReturnDetail";
			$taxSection = null;
			$saleHeader = $this->render('ot_sales_return_print');
			$rowCnt  = count($data['OtPharmacySalesReturnDetail']);
			$heading = "OT Sales Return";
		} 
		
		$count = 1; $grandtotal = 0;
		$p= 1  ;
		$cntInit = 9 ;
		
		$pageNoTodisplayDiscount = ceil($rowCnt/$cntInit);
		if($rowCnt < $cntInit){
			$rowCntModSurPlus = $rowCnt+($cntInit-$rowCnt) ;
		}else if($rowCnt%$cntInit!=0) { //if count is not from 10 multiplier
			$rowCntMod = $rowCnt%$cntInit ;
			$rowCntModSurPlus = $rowCnt+($cntInit-$rowCntMod) ;
		}else{
			$rowCntModSurPlus = $rowCnt ;
		}
		
		if($section == "OtPharmacySalesBill")
		{
			$discount  = $data['OtPharmacySalesBill']['discount'];
		}
		$itemObj = Classregistry::init('OtPharmacyItem');
		
		for($i=0;$i<$rowCntModSurPlus;$i++){
			if($section == "OtPharmacySalesBill")
			{
				if(!$data['OtPharmacySalesBillDetail'][$i]) continue ;	 
				$item['OtPharmacySalesBillDetail'] = $data['OtPharmacySalesBillDetail'][$i];
		
				$pharItem = $itemObj->find('first',array('conditions' =>array('OtPharmacyItem.id' => $item['OtPharmacySalesBillDetail']['item_id'])));
				$shelf = $pharItem['OtPharmacyItem']['shelf'];
				$productName = $pharItem['OtPharmacyItem']['name'];
				$pack = $pharItem['OtPharmacyItem']['pack'];
				$batch_number = $item['OtPharmacySalesBillDetail']['batch_number'];
				$packOFproduct = (int)$item['OtPharmacySalesBillDetail']['pack'];	//mg, 's, ml, etc...
				$itemType = $item['OtPharmacySalesBillDetail']['qty_type']; 		//Tab, Pack or unit
				$qty = $item['OtPharmacySalesBillDetail']['qty'];
				
				if(!empty($item['OtPharmacySalesBillDetail']['sale_price'])){
					$newDate = explode("-",$item['OtPharmacySalesBillDetail']['expiry_date']);
					$expiry_date = (!empty($item['OtPharmacySalesBillDetail']['expiry_date'])) ? $newDate[1]."/".$newDate[0] : "";
				}else{
					$newDate = explode("-",$pharItem['OtPharmacyItemRate']['expiry_date']);
					$expiry_date = (!empty($pharItem['OtPharmacyItemRate']['expiry_date'])) ? $newDate[1]."/".$newDate[0] : "";
				}
		
				if(!empty($item['OtPharmacySalesBillDetail']['sale_price'])){
					$price = (float)$item['OtPharmacySalesBillDetail']['sale_price'];
				}
				else
					if(!empty($item['OtPharmacySalesBillDetail']['mrp'])){
					$price = (float)$item['OtPharmacySalesBillDetail']['mrp'];
				}
				else{
					if($pharItem['OtPharmacyItemRate']['sale_price']){
						$price = (float)$pharItem['OtPharmacyItemRate']['sale_price'];
					}else{
						$price = (float)$pharItem['OtPharmacyItemRate']['mrp'];
					}
				}
				$total = $price*$qty;
				if($itemType == "Tab"){
					$total =  ($price/$packOFproduct)*$qty;
				}
			}//section for InventoryPharmacySalesReturn
				else{ 
					if(!$data['OtPharmacySalesReturnDetail'][$i]) continue ;
					$item['OtPharmacySalesReturnDetail'] = $data['OtPharmacySalesReturnDetail'][$i];
					$pharItem = $itemObj->find('first',array('conditions' =>array('OtPharmacyItem.id' => $item['OtPharmacySalesReturnDetail']['item_id'])));
		
					$shelf = $pharItem['OtPharmacyItem']['shelf'];
					$productName = $pharItem['OtPharmacyItem']['name'];
					$pack = $pharItem['OtPharmacyItem']['pack'];
					$batch_number = $item['OtPharmacySalesReturnDetail']['batch_number'];
					$packOFproduct = (int)$item['OtPharmacySalesReturnDetail']['pack'];	//mg, 's, ml, etc...
					$itemType = $item['OtPharmacySalesReturnDetail']['qty_type']; 		//Tab, Pack or unit
		
					$qty = $item['OtPharmacySalesReturnDetail']['qty'];
		
					if(!empty($item['OtPharmacySalesReturnDetail']['sale_price'])){
						$newDate = explode("-",$item['OtPharmacySalesReturnDetail']['expiry_date']);
						$expiry_date = (!empty($item['OtPharmacySalesReturnDetail']['expiry_date'])) ? $newDate[1]."/".$newDate[0] : "";
					}else{
						$newDate = explode("-",$pharItem['OtPharmacyItemRate']['expiry_date']);
						$expiry_date = (!empty($item['OtPharmacySalesReturnDetail']['expiry_date'])) ? $newDate[1]."/".$newDate[0] : "";
					}
		
					if(!empty($item['OtPharmacySalesReturnDetail']['sale_price'])){
						$price = (float)$item['OtPharmacySalesReturnDetail']['sale_price'];
					}
					else
						if(!empty($item['OtPharmacySalesReturnDetail']['mrp'])){
						$price = (float)$item['OtPharmacySalesReturnDetail']['mrp'];
					}
					else{
						if($pharItem['OtPharmacySalesReturnDetail']['sale_price']){
							$price = (float)$pharItem['OtPharmacySalesReturnDetail']['sale_price'];
						}else{
							$price = (float)$pharItem['OtPharmacySalesReturnDetail']['mrp'];
						}
					}
					$total = $price*$qty;
					if($itemType == "Tab"){
						$total =  ($price/$packOFproduct)*$qty;
					}
				 }
					
				//if($i != 0) echo "</table>";
				if($isPageBreak == true){
					echo '<div class="page-break" style="clear: both; height:5px;"></div>';
				}
				?>
			<?php
				
				if($p%($cntInit) ==1 || $p==1)
				{
					if($p>1){	
				?>	
				
				<?php  
					}
					echo $saleHeader;	//header
				?>
		
			<table width="90%" border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px">
					     <tr>
					      <!--  <td width="2%" class="boxBorderBot boxBorderRight boxBorderLeft boxBorderTop" style="text-align: center;padding-left: 10px">S No.</td>-->
					      <td width="18%" class="boxBorderBot boxBorderRight boxBorderTop boxBorderLeft" style="text-align: left ;">DESCRIPTION</td>
					      <td width="2%" class="boxBorderBot boxBorderRight  boxBorderTop" style="text-align: center;padding-left: 10px">QUANTITY</td>
						  <td width="10%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">BATCH</td>
						  <td width="4%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">EXP.</td>
						  <td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">RATE</td>
						  <td width="7%" class="boxBorderBot boxBorderRight boxBorderTop" style="text-align: center;">AMOUNT</td>
								        
					     </tr>	
		 <?php }//EOF counter 10 ?>		
	  
			<tr>
				<!-- <td valign="top" class="boxBorderRight boxBorderLeft " 
					style="font-size: 14px;font-weight: 600;text-align: center;"><?php //echo $p;?>&nbsp;</td>-->
				<td valign="top" class="boxBorderRight boxBorderLeft"
					style="font-size: 14px;font-weight: 600;text-align: left; "><?php echo $productName; ?>&nbsp;</td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;font-weight: 600;text-align: center; "><?php echo $qty; ?>&nbsp;</td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $batch_number;?></td>
				<td valign="top" class="boxBorderRight"
					style="font-size: 14px;font-weight: 600;text-align: center;"><?php echo $expiry_date; ?>&nbsp;</td>
				<td valign="top" class="boxBorderRight" style="font-weight: 600;text-align: right; ">
					<?php $salePrice = $price/$pack ;
					echo number_format($salePrice,2); ?>
				</td>
			
					<?php
						$grandtotal = (!empty($qty)) ? $grandtotal+$total : $grandtotal;
					?>
				<td  valign="top" class="boxBorderRight"
					style="font-size: 14px;font-weight: 600; text-align: right;
					valign="top"><?php echo (!empty($qty))? number_format($total,2):""; unset($qty); ?></td>
			</tr>
			<?php  $p++;
			
		}?>
		</table>
	

	  <?php 
	  $isPageBreak = false;
	//  if((($p%($cntInit)==0) || $rowCntModSurPlus==$p) && ($p!=1 || $rowCntModSurPlus==1)) {
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
					}
				?>
				<?php
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
		       <td width="680px">CREATED TIME : <?php echo $this->DateFormat->formatDate2Local($createdDate,Configure::read('date_format')); ?></td>
		       <td width="250"><?php if($section == "OtPharmacySalesReturn"){ echo __("RETURN AMOUNT :"); } else { echo __("PLEASE PAY :"); }?>
		       <?php
				if(isset($taxSection) && isset($data[$taxSection]['tax'])){
			?>
				<span style="font-size:10">Tax: <?php echo $tax."%"; $totalTax = ($grandtotal*$tax)/100?></span>
			<?php
		    }
				if(isset($tml)){
					
				}
			?>
				<?php
					echo $this->Number->currency(round($grandtotal - $discount + $totalTax));
				?></td>
		     </tr> 
		      
		    </table></td>
		  </tr>
	  	<?php $count = $count+1;
	 // }
	 
	//} eof foreach  ?>

	<script>
	window.onload=function(){self.print();} 
	</script>
				
	