<html moznomarginboxes mozdisallowselectionprint>

<style>

@page   
{  
size: auto;   
margin: 5mm;  
}  
body  
{  
background-color:#FFFFFF;   
margin: 0px;  
}

</style>
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
	
 <?php 	$slip_detail  = $storeDetails;   ?> 
 <hr>
 <!-- billing activity form start here -->
 <table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" style="margin-top: 0">
	<tr>
		<td colspan="6" style="text-align: center"><font size="4"><strong><u>STORE REQUISITION &amp; ISSUE SLIP</u></strong></font></td>
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
		<td align="right"><strong>Aproved Date</strong></td>
		<td width="5px">:</td>
		<td><strong><?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['issue_date'],Configure::read('date_format'),false); ?></strong></td>
	</tr>
	<tr>
		<td><strong>Requisition By: </strong></td>
		<td width="5px">:</td>
		<td><strong><?php echo $req_by_name;?></strong></td>
		<td align="right"><strong>Authenticated User </strong></td>
		<td width="5px">:</td>
		<td><strong><?php echo $issue_by_name; ?></strong></td>
	</tr>
	 
	</table>
	<hr>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="margin-top: 2%">
                  <tr>
                    <td width="2%"  style="text-align: center" class=""><strong>Sr. No.</strong></td>
                    <!--<td width="10%" style="text-align: center" class=""><strong>Request Date</strong></td>
                    <td width="10%" style="text-align: center" class=""><strong>From Department</strong></td>
                    <td width="10%" style="text-align: center" class=""><strong>To Department</strong></td>
                    <td width="10%" style="text-align: center" class=""><strong>Requisition By</strong></td> -->
                    <td width="25%" style="text-align: center" class=""><strong>Item Name</strong></td>
                    <td width="10%" style="text-align: center" class=""><strong>Requisition Quantity</strong></td>    
                    <td width="10%" style="text-align: center" class=""><strong>Current Stock</strong></td>
                    <td width="10%" style="text-align: center" class=""><strong>Approved Quantity</strong></td>    
                    <td width="10%" style="text-align: center" class=""><strong>Status</strong></td>          
                    <!--<td width="7%"  style="text-align: center" class=""><strong>Authenticated User</strong></td>
                    <td width="10%" style="text-align: center" class=""><strong>Approved Date</strong></td> -->
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
                        <!--<td align="center" class=""><?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['requisition_date'],Configure::read('date_format'),true);?></td>
                        <td align="center" class=""><?php echo $requisition_for;?></td>
                        <td align="center" class=""><?php echo $toRequisLoc['StoreLocation']['name']; ?></td>
                        <td align="center" class=""><?php echo $req_by_name; ?></td>-->
                        <td align="center" class=""><?php echo $value['Product']['name'];  ?></td>                        
                        <td align="center" class=""><?php echo $value['StoreRequisitionParticular']['requested_qty']; ?></td>
                        <td align="center" class=""><?php $totalStock=$value['Product']['quantity']*$value['Product']['pack'] ;
                                                          $looseStock=$value['Product']['loose_stock'];
                                                          $total=$totalStock+$looseStock; 
                                                          echo $total;
                        ?></td>                        
                        <td align="center" class=""><?php echo $value['StoreRequisitionParticular']['issued_qty']; ?></td>
                        <td align="center" class=""><?php echo $StoreRequisition['StoreRequisition']['status'] ?></td>                        
                        <!--<td align="center" class=""><?php echo $issue_by_name; ?></td>
                        <td align="center" class=""><?php echo $this->DateFormat->formatDate2local($StoreRequisition['StoreRequisition']['issue_date'],Configure::read('date_format'),false); ?></td>                        
                        -->
                                                           
                       
                      </tr>
					   <?php
						}
					 ?>
                   </table>
                          
 <script>
  window.onload = function() { window.print(); }
 </script>
 </html>