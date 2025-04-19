<html moznomarginboxes mozdisallowselectionprint>

<!-- <div width="200" style="float:right" class="print-header">
<input type="button" value="Print" class="blueBtn" onclick="return printPage()"/>&nbsp;&nbsp;<input name="Close" type="button" value="Close" class="blueBtn" onclick="window.close();"/>
</div> -->
<?php
		$website  = $this->Session->read('website.instance');
		if($website=='vadodara'){
?>
<table width="800">
		<tr>
			<td><div><?php echo $this->element('vadodara_header');?> </div></td>
		</tr>
</table>
<?php } ?>
	
 <?php 	$slip_detail  = $storeDetails;

				   ?>
 <hr>
 <table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" style="margin-top: 0">
	<tr>
		<td colspan="6" style="text-align: center"><font size="4"><strong><u>STORE REQUISITION </u></strong></font></td>
	</tr>
	<tr>
		<td width="120px"><strong>From Department</strong></td>
		<td width="5px">:</td>
		<td><strong><?php echo $requisition_for;?></strong></td>
		<td align="right"><strong>To Department</strong>
		<td width="5px">:</td>
		<td><strong><?php echo $toRequisLoc['StoreLocation']['name'];?></strong></td>
	</tr>
	<tr>
		<td><strong>Request Date: </strong></td>
		<td width="5px">:</td>
		<td><strong><?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['requisition_date'],Configure::read('date_format'),true);?></strong></td>
		<td align="right"><strong>Indent Number</strong></td>
		<td width="5px">:</td>
		<td><strong><?php echo "IND-".str_pad($StoreRequisition['StoreRequisition']['id'], 3, '0', STR_PAD_LEFT); ?></strong></td>
	</tr> 
	</table>
	
	<!-- 
 <table width="100%" border="0" cellspacing="0" cellpadding="6" align="center" style="padding-top: 0;padding-bottom: 3%">
	<tr>
		<td colspan="4" style="text-align: center"><font size="4"><strong><u>STORE REQUISITION</u></strong></font></td>
	</tr>
	<tr>
		<td > <strong>Indent Number:</strong>
		</td>
		<td> <strong><?php echo $StoreRequisition['StoreRequisition']['id'];?> </strong></td>
		<td > <strong>Request Date: </strong>
		</td>
		<td><strong><?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['requisition_date'],Configure::read('date_format'),true);?></strong></td>
	</tr>
	<tr>
		<td><strong>From Department:</strong></td>
		<td><strong><?php echo $requisition_for;?></strong></td>
		<td> <strong> To Department:</strong></td>
		<td><strong><?php echo $toRequisLoc['StoreLocation']['name'];?></strong></td>
	</tr>
	</table> -->
<hr>

    <table width="100%" border="1" cellspacing="0" cellpadding="5" >
                  <tr>
                    <td width="2%"  style="text-align: center" class=""><strong>Sr. No.</strong></td>
                    <td width="32%" style="text-align: center" class="" style="padding-left:10px;"><strong>Item Name</strong></td>
                    <td width="27%" style="text-align: center" class=""><strong>Batch/Exp.Date/Cost Value</strong></td> 
                    <td width="10%" style="text-align: center" class=""><strong>Current Stock</strong></td>
                    <td width="10%" style="text-align: center" class=""><strong>Requisition Quantity</strong></td>                
                    <td width="7%"  style="text-align: center" class=""><strong>Balance</strong></td>
                    <td width="10%" style="text-align: center" class=""><strong>Cost Price</strong></td>
                  </tr>
					 <?php
						 $i=0;
						foreach($slip_detail as $key=>$value){
							if (isset($value['PharmacyItem'])) {
								$value['Product'] = $value['PharmacyItem'];
							}
						 $i++;
					 ?>
                      <tr >
					    <td align="center" class=""><?php echo $i;?></td>
                        <td align="center" class="" style="padding-left:10px;">&nbsp;<?php echo $value['Product']['name'];?></td>
                        <td align="center" class="">&nbsp;<?php echo $value['PharmacyItemRate']['batch_number']."/". date('d-M-y',strtotime($value['PharmacyItemRate']['expiry_date']))."/".number_format($value['Product']['mrp'],2) ;?></td>
                        <td align="center" class="">&nbsp;<?php $totalStock=$value['PharmacyItem']['stock']*$value['PharmacyItem']['pack'] ;
                                                                $looseStock=$value['PharmacyItem']['loose_stock'];
                                                                $total=$totalStock+$looseStock; 
                                                                echo $total; ?></td>
                        <td align="center" class="">&nbsp;<?php echo $value['StoreRequisitionParticular']['requested_qty']; ?></td>
                        <td align="center" class="">&nbsp;<?php  echo $total-$value['StoreRequisitionParticular']['requested_qty']; ?></td>                        
                        <td align="center" class="">&nbsp;<?php $total_price=($value['PharmacyItemRate']['mrp']/$value['PharmacyItem']['pack'])* $value['StoreRequisitionParticular']['requested_qty'];
                                                           echo number_format(round($total_price),2) ;?></td>
                       
                      </tr>
					   <?php
						}
					 ?>
                   </table>
                          
 <script>
  window.onload = function() { window.print(); }
 </script>
 </html>