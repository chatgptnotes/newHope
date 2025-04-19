<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"rgjay_patient_pharmacy_package".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: RGJAY Patient's Package & Sales Report" );
ob_clean();
flush();
?> 
<div class="inner_title">
    <h3  align="center">RGJAY Patient's Package & Sales Report</h3>
</div>               
<table width="100%" border="1" cellspacing="1" cellpadding="1" class="formFull" align="center"> 
    <thead> 
        <tr>
            <th width="10%" style="text-align:center"><b>Sr. No.</b></th>
            <th width="30%" style="text-align:left"><b>Patient Name</b></th>
            <th width="20%" style="text-align:right"><b>Package Amount</b></th>
            <th width="20%" style="text-align:right"><b>Pharmacy Sales<br/>(MRP)</b></th> 
            <th width="15%" style="text-align:right"><b>Pharmacy Sales<br/>(Purchase Price)</b></th> 
            <th width="25%" style="text-align:right"><b>Pharmacy Paid<br/>(Purchase Price)</b></th> 
            <th width="15%" style="text-align:right"><b>1/3<sup>rd</sup> of package amount<br/>(Purchase Price)</b></th> 
        </tr>  
    </thead> 
    <tbody>
        <?php if(!empty($patientSales)){ $cnt = 1; $totalPurchase = 0; $totalSale = 0;  foreach($patientSales as $key => $val): 
        ?>
            <tr>
                <td align="center"><?php echo $cnt++ ; ?></td>
                <td width="30%"><?php echo $val['name']; ?></td>
                <td width="20%" align="right"><?php $totalPackage += $val['package_amount']; echo number_format($package = $val['package_amount']); ?></td>
                <td width="15%" align="right"><?php $totalMRP += $val['pharmacy_sales_mrp']; echo number_format($val['pharmacy_sales_mrp'],2); ?></td> 
                <td width="15%" align="right"><?php $totalPurchase += $val['pharmacy_sales_purchase_price']; echo number_format($val['pharmacy_sales_purchase_price'],2); ?></td> 
                <td width="15%" align="right"><?php $totalPaid += $val['pharmacy_sales_paid']; echo number_format($val['pharmacy_sales_paid'],2); ?></td> 
                <td width="15%" align="right"><?php $oneThird = $package/3; $totalOneThird += $oneThird; echo number_format($oneThird,2); ?></td> 
            </tr>
       <?php endforeach; ?>
            <tr>
                <td colspan="2" align="right"><?php echo "Total:"; ?></td>
                <td align="right"><?php echo $this->Number->currency($totalPackage); ?></td>
                <td align="right"><?php echo $this->Number->currency($totalMRP); ?></td> 
                <td align="right"><?php echo $this->Number->currency($totalPurchase); ?></td>
                <td align="right"><?php echo $this->Number->currency($totalPaid); ?></td>
                <td align="right"><?php echo $this->Number->currency($totalOneThird); ?></td>
            </tr>
       <?php }else{?>
            <tr>
                <td colspan="4" style="text-align:center"><b>No Record Found..!!</b></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
