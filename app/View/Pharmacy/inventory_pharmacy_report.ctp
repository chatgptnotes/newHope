<div class="inner_title">
    <h3> &nbsp; <?php echo __('Pharmacy Report', true); ?></h3>
    <span><?php
echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false, 'class' => 'blueBtn'));
?></span>
</div>
<br />
<table border="1" id="managerial" width="50%">
    <tr>
        <td width="10%" height="30px"><b>Sr. No.</b></td>
        <td><b>Name Of Report</b></td>
    </tr>
    <?php if ($this->Session->read('website.instance') == 'hope') { ?>
        <tr>
            <td valign="top">&nbsp;1</td>
            <td>&nbsp;<?php echo $this->Html->link('Pharmacy Sales Collection Report', array('controller' => 'reports', 'action' => 'salesCollectionReport', 'admin' => false)); ?>
            </td>
        </tr>

    <?php } else { ?>
        <tr>
            <td valign="top">&nbsp;1</td>
            <td>&nbsp;<?php echo $this->Html->link('Pharmacy Sales/Return Report', array('controller' => 'reports', 'action' => 'sales_report', 'admin' => true)); ?>
            </td>
        </tr>
    <?php }if ($this->Session->read('website.instance') == 'hope') { ?>
        <tr>
            <td valign="top">&nbsp;2</td>
            <td>&nbsp;<?php echo $this->Html->link('Monthly Summary Of Sale Vouchers Report', array('controller' => 'reports', 'action' => 'pharmacySaleVoucherCollectionReport', 'admin' => false)); ?>
            </td>
        </tr>
    <?php } else { ?> 
        <tr>
            <td valign="top">&nbsp;2</td>
            <td>&nbsp;<?php echo $this->Html->link('Monthly Summary Of Sale Vouchers Report', array('controller' => 'reports', 'action' => 'pharmacySaleVoucherReport', 'admin' => false)); ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td valign="top">&nbsp;3</td>
        <td>&nbsp;<?php echo $this->Html->link('Pharmacy Purchase Report', array('controller' => 'reports', 'action' => 'purchaseReport', 'admin' => false)); ?>
        </td>
    </tr>	
    <tr>
        <td valign="top">&nbsp;4</td>
        <td>&nbsp;<?php echo $this->Html->link('Monthly Summary Of Purchase Vouchers Report', array('controller' => 'reports', 'action' => 'pharmacyPurchaseVoucherReport', 'admin' => false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">&nbsp;5</td>
        <td>&nbsp;<?php echo $this->Html->link('Pharmacy Expiry Report', array('controller' => 'reports', 'action' => 'pharmacyExpiryReport', 'admin' => false)); ?>
        </td>
    </tr> 
    <tr>
        <td valign="top">&nbsp;6</td>
        <td>&nbsp;<?php echo $this->Html->link('Pharmacy Current Stock Status Report', array('controller' => 'reports', 'action' => 'pharmacyCurrentStockReport', 'admin' => false)); ?>
        </td>
    </tr> 
    <tr>
        <td valign="top">&nbsp;7</td>
        <td>&nbsp;<?php echo $this->Html->link('Pharmacy Gross Profit Report', array('controller' => 'reports', 'action' => 'pharmacyGrossProfitReport', 'admin' => false)); ?>
        </td>
    </tr> 
    <?php if ($this->Session->read('website.instance') == 'hope') { ?>
        <tr>
            <td valign="top">&nbsp;8</td>
            <td>&nbsp;<?php echo $this->Html->link('Stock Register Report', array('controller' => 'Reports', 'action' => 'stock_register', 'admin' => false)); ?>
            </td>
        </tr> 
    <?php } else { ?>
        <tr>
            <td valign="top">&nbsp;8</td>
            <td>&nbsp;<?php echo $this->Html->link('Pharmacy Stock & Sales Analysis Report', array('controller' => 'reports', 'action' => 'pharmacyStockSalesAnalysisReport', 'admin' => false)); ?>
            </td>
        </tr> 
    <?php } ?>
    <tr>
        <td valign="top">&nbsp;9</td>
        <td>&nbsp;<?php echo $this->Html->link('Party wise Purchase Report', array('controller' => 'reports', 'action' => 'party_wise_purchase_report', 'admin' => true)); ?>
        </td>
    </tr> 
    <tr>
        <td valign="top">&nbsp;10</td>
        <td>&nbsp;<?php echo $this->Html->link('Sales VAT and SAT Report', array('controller' => 'reports', 'action' => 'sale_sat_vat_report', 'admin' => false)); ?>
        </td>
    </tr> 
    <!--<tr>
            <td valign="top">&nbsp;10</td>
            <td>&nbsp;<?php echo $this->Html->link('Vat Liability Report', array('controller' => 'pharmacy', 'action' => 'vat_liability_report', 'inventory' => true)); ?>
            </td>
    </tr>
    
     <tr>
            <td valign="top">&nbsp;5</td>
            <td>&nbsp;<?php echo $this->Html->link('Party wise Purchase Report', array('controller' => 'reports', 'action' => 'party_wise_purchase_report', 'admin' => true)); ?>
            </td>
    </tr>  -->

<!--  	<tr>
<td valign="top">&nbsp;4</td>
<td><?php echo $this->Html->link('Patient wise Sale Report', array('controller' => 'reports', 'action' => 'patient_wise_sale', 'admin' => true)); ?>
</td>
</tr>
<tr>
<td valign="top">&nbsp;5</td>
<td><?php echo $this->Html->link('Product wise Sale Report', array('controller' => 'reports', 'action' => 'product_wise_sale', 'admin' => true)); ?>
</td>
</tr>-->
    <tr>
        <td valign="top">&nbsp;11</td>
        <td>&nbsp;<?php echo $this->Html->link('Pharmacy Current Stock', array('controller' => 'pharmacy', 'action' => 'pharmacy_current_stock_reports', 'admin' => true)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">&nbsp;12</td>
        <td>&nbsp;<?php echo $this->Html->link('Pharmacy Formulary', array('controller' => 'reports', 'action' => 'pharmacy_formulary', 'admin' => true)); ?>
        </td>
    </tr>

    <tr>
        <td valign="top">&nbsp;13</td>
        <td>&nbsp;<?php echo $this->Html->link('Pharmacy Patients Sales', array('controller' => 'reports', 'action' => 'productWiseSales', 'admin' => false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">&nbsp;14</td>
        <td>&nbsp;<?php echo $this->Html->link('RGJAY Package & Pharmacy Sales', array('controller' => 'reports', 'action' => 'getRgjayPackageAndPharmacyAmount', 'admin' => false)); ?>
        </td>
    </tr>
    <!-- <tr>
        <td valign="top">&nbsp;15</td>
        <td>&nbsp;<?php echo $this->Html->link('Stock Adjusted Report', array('controller' => 'reports', 'action' => 'stockAdjustedReport', 'admin' => false)); ?>
        </td>
    </tr>  -->
     <tr>
        <td valign="top">&nbsp;15</td>
        <td>&nbsp;<?php echo $this->Html->link('Complete Stock Register Report', array('controller' => 'Reports', 'action' => 'all_stock_report', 'admin' => false)); ?>
        </td>
    </tr> 
</table>
</div>
