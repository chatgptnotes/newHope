<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"stock_adjusted_report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: RGJAY Patient's Package & Sales Report" );
ob_clean();
flush();
?> 
<div class="inner_title">
    <h3  align="center"><?php echo __("Stock Adjusted Reports", true); ?></h3>
</div>   
<div class="clr ht5"></div>
<table width="100%" border="1" cellspacing="1" cellpadding="1" class="formFull" align="center"> 
    <thead> 
        <tr>
            <th style="text-align:center"><b>Sr. No.</b></th>
            <th style="text-align:left"><b>Product Name</b></th>
            <th style="text-align:center"><b>Batch No</b></th>
            <th style="text-align:center"><b>Adjusted Add</b></th> 
            <th style="text-align:center"><b>Adjusted Minus</b></th>
            <th style="text-align:right"><b>Adjusted Date</b></th>
            <th style="text-align:right"><b>Adjusted By</b></th> 
        </tr>  
    </thead>  
    <tbody> 
    <?php if(!empty($stockData)){ $cnt = 1; $totalPurchase = 0; $totalSale = 0;  foreach($stockData as $key => $val):   ?>
        <tr>
            <td align="center"><?php echo $cnt++ ; ?></td> 
            <td align="left"><?php echo $val['Product']['name']; ?></td>
            <td align="center"><?php echo $val['StockAdjustment']['batch_number']; ?></td> 
            <td align="center"><?php echo !empty($val['StockAdjustment']['sur_plus'])?$val['StockAdjustment']['sur_plus']:'-'; ?></td> 
            <td align="center"><?php echo !empty($val['StockAdjustment']['sur_minus'])?$val['StockAdjustment']['sur_minus']:'-'; ?></td> 
            <td align="right"><?php echo $this->DateFormat->formatDate2Local($val['StockAdjustment']['created'],Configure::read('date_format'), true); ?></td> 
            <td align="right"><?php echo $val[0]['name']; ?></td> 
        </tr>
   <?php endforeach; } else{?>
        <tr>
            <td colspan="7" style="text-align:center"><b>No Record Found..!!</b></td>
        </tr>
        <?php } ?>
    </tbody>
</table>  
