
<style> 
	.tabularForm {
	    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
	    background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 5px 10px;
	}
        
        .tabularForm td {
            border: 1px black;
         }
</style>
<div class="inner_title">
<h3>&nbsp; <?php echo __("RGJAY Patient's Package & Sales Report", true); ?></h3>
<span><?php 
   echo $this->Html->link(__('Generate Excel Report'),array('controller'=>'reports','action' => 'getRgjayPackageAndPharmacyAmount','generate_excel','admin'=>false), array('escape' => false,'class'=>'blueBtn'));
   echo $this->Html->link(__('Back to Report'), array('controller'=>'pharmacy','action' => 'pharmacy_report','purchase','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
               ?></span>
</div>
<br/> 
<?php //echo $this->Form->create('',array('type'=>'get')); ?> 
<!--<table align="left"> 
    <tr>
	 <td align="right">Search Patient : </td>
	 <td align="left"><?php
		echo $this->Form->input('PharmacySale.lookup_name', array('id' => 'lookup_name','class'=>'textBoxExpnd','value'=>$this->params->query['lookup_name'], 'label'=> false, 'div' => false));
                echo $this->Form->hidden('PharmacySale.patient_id',array('id'=>'person_id','value'=>$this->params->query['patient_id']));  
	 ?></td>
         <td>
            <input type="submit" value="Get Report" class="blueBtn" id="submit" onclick = "return getValidate();">
            &nbsp;&nbsp;
             <a  class="grayBtn" href="javascript:history.back();">Cancel</a>            
              </td>
        <td><?php echo $this->Form->input('Generate Excel Report',array('class'=>'blueBtn','name'=>'generate_excel','type'=>'submit','value'=>'Generate Excel','div'=>false,'label'=>false)); 
               ?></td>
    </tr>
</table>  -->
<?php //echo $this->Form->end(); ?>
<div class="clr ht5"></div>
<table width="100%" border="0" cellspacing="" cellpadding="5" class="tabularForm" align="center">
    <thead>
        <tr>
            <th width="" style="text-align:center"><b>Sr. No.</b></th>
            <th width="" style="text-align:left"><b>Patient Name</b></th>
            <th width="" style="text-align:right"><b>Package Amount</b></th>
            <th width="" style="text-align:right"><b>Pharmacy Sales<br/>(MRP)</b></th> 
            <th width="" style="text-align:right"><b>Pharmacy Sales<br/>(Purchase Price)</b></th> 
            <th width="" style="text-align:right"><b>Pharmacy Paid<br/>(Purchase Price)</b></th> 
            <th width="" style="text-align:right"><b>1/3<sup>rd</sup> of package amount<br/>(Purchase Price)</b></th> 
        </tr>  
    </thead>
    <tbody>
    <?php if(!empty($patientSales)){ $cnt = 1; $totalPurchase = 0; $totalPackage = 0; $totalMRP = 0; $totalPaid = 0; foreach($patientSales as $key => $val): 
    ?>
        <tr>
            <td align="center"><?php echo $cnt++ ; ?></td>
            <td width=""><?php echo $val['name']; ?></td>
            <td width="" align="right"><?php $totalPackage += $val['package_amount']; echo number_format($package = $val['package_amount']); ?></td>
            <td width="" align="right"><?php $totalMRP += $val['pharmacy_sales_mrp']; echo number_format($val['pharmacy_sales_mrp'],2); ?></td>   
            <td width="" align="right"><?php $totalPurchase += $val['pharmacy_sales_purchase_price']; echo number_format($val['pharmacy_sales_purchase_price'],2); ?></td>   
            <td width="" align="right"><?php $totalPaid += $val['pharmacy_sales_paid']; echo number_format($val['pharmacy_sales_paid'],2); ?></td>   
            <td width="" align="right"><?php $oneThird = $package/3; $totalOneThird += $oneThird; echo number_format($oneThird,2); ?></td>   
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
            <td colspan="6" style="text-align:center"><b>No Record Found..!!</b></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<font style="color: red"><i>(Note: The Pharmacy sales amount is the sum of purchase amount, and non-discharge patients)</i></font>
