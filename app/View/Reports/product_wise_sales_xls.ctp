<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"product_wise_sale_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Product Wise sale Report" );
ob_clean();
flush();
?>
<div class="inner_title">
    <h3  align="center"><?php echo $patient_name; ?></h3>
</div>               
<table width="100%" border="1" cellspacing="1" cellpadding="1" class="formFull" align="center"> 
    <thead> 
        <tr>
            <th width="10%" style="text-align:center"><b>Sr. No.</b></th>
            <th width="30%" style="text-align:left"><b>Product</b></th>
            <th width="20%" style="text-align:center"><b>Quantity</b></th>
            <th width="15%" style="text-align:right"><b>Purchase Amount</b></th>
            <th width="15%" style="text-align:right"><b>Sale Amount</b></th> 
        </tr>  
    </thead> 
    <tbody>
        <?php if(!empty($salesData)){ $cnt = 1; $totalPurchase = 0; $totalSale = 0;  foreach($salesData as $key => $val): 
        ?>
            <tr>
                <td align="center"><?php echo $cnt++ ; ?></td>
                <td width="30%"><?php echo $val['name']; ?></td>
                <td width="20%" align="center"><?php echo $val['qty']; ?></td>
                <td width="15%" align="right"><?php $totalPurchase += $val['purchase_price']; echo number_format($val['purchase_price'],2); ?></td>
                <td width="15%" align="right"><?php $totalSale += $val['sale_price']; echo number_format($val['sale_price'],2); ?></td> 
            </tr>
       <?php endforeach; ?>
            <tr>
                <td colspan="3" align="right"><?php echo "Total:"; ?></td>
                <td align="right"><?php echo $this->Number->currency($totalPurchase); ?></td>
                <td align="right"><?php echo $this->Number->currency($totalSale); ?></td> 
            </tr>
       <?php }else{?>
            <tr>
                <td colspan="5" style="text-align:center"><b>No Record Found..!!</b></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>