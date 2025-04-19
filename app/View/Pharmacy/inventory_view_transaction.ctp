<?php
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>
<style>
th {
    background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
    border-bottom: 1px solid #3E474A;
    color: #FFFFFF;
    font-size: 12px;
    padding: 5px 8px;
    text-align: left;
}
.row_gray {
    background-color: #252C2F;
    border-top: 1px solid #000000;
    margin: 0;
    padding: 7px 3px;
	color:#fff !important;
}
.table_cell{ color:#fff !important;}
</style>
<div style="margin-left:15px">
 <div class="inner_title">
                    	<h3>Transaction Detail of <?php  echo $supplier['InventorySupplier']['name']; ?></h3>
                  </div>
</div>
<div align="right" style="margin-top:10px">
  <?php
 echo $this->Html->link(__('Back'), array('action' => 'fetch_transaction'), array('escape' => false,'class'=>'blueBtn'));
?>
</div>

<br>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr class="row_title" >

   <th class="table_cell" style="text-align:center"><strong><?php echo  __('Vr. No.', true) ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?></th>
   <th class="table_cell" style="text-align:center"><strong><?php echo __('Vr. Date', true); //echo $this->Paginator->sort('is_active', __('Pack', true)); ?></th>
    <th class="table_cell" style="text-align:center"><strong><?php echo __('Bill No.', true); //echo $this->Paginator->sort('is_active', __('Pack', true)); ?></th>

 <th class="table_cell" style="text-align:center"><strong><?php echo __('CST', true); //echo $this->Paginator->sort('is_active', __('Pack', true)); ?></th>

 <th class="table_cell" style="text-align:center"><strong><?php echo __('Payment Mode', true);   ?></th>
<th class="table_cell" style="text-align:center"> <strong><?php echo __('Total Amount', true);  ?></th>
<th class="table_cell" style="text-align:center"><strong><?php echo __('Credit Amount', true);  ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</th>
<th class="table_cell" style="text-align:center"><strong><?php echo __('Discount/ Add Amount', true);   ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</th>
<th class="table_cell" style="text-align:center"><strong><?php echo __('Grand Total', true);   ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</th>
  </tr>
  <?php
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $supplier):
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

   <td class="row_format"><?php echo $supplier['InventoryPurchaseDetail']['vr_no']; ?> </td>
  <td class="row_format"><?php echo $supplier['InventoryPurchaseDetail']['vr_date']; ?> </td>
    <td class="row_format"><?php echo $supplier['InventoryPurchaseDetail']['bill_no']; ?> </td>
	 <td class="row_format"><?php echo $supplier['InventoryPurchaseDetail']['cst']; ?> </td>
	  <td class="row_format"><?php echo $supplier['InventoryPurchaseDetail']['payment_mode']; ?> </td>
	    <td class="row_format"><?php echo $supplier['InventoryPurchaseDetail']['total_amount']; ?> </td>
		<td class="row_format"><?php echo $supplier['InventoryPurchaseDetail']['credit_amount']; ?> </td>
	<td class="row_format">

	<?php
	 	if($supplier['InventoryPurchaseDetail']['payment_mode'] == "credit"){
	 	if($supplier['InventoryPurchaseDetail']['extra_amount_type']==0)
	 		{
				$extra_amount = $supplier['InventoryPurchaseDetail']['extra_amount'];
				$total = $supplier['InventoryPurchaseDetail']['total_amount'];
				echo "(+)".$extra_amount;
			}
			else{
				$extra_amount = $supplier['InventoryPurchaseDetail']['extra_amount'];
				$total = $supplier['InventoryPurchaseDetail']['total_amount'];
				$amt = ($supplier['InventoryPurchaseDetail']['extra_amount']*$supplier['InventoryPurchaseDetail']['total_amount'])/100;
				echo "(+)".$amt;
			}
		}else{
		if($supplier['InventoryPurchaseDetail']['extra_amount_type']==0)
	 		{
				$extra_amount = $supplier['InventoryPurchaseDetail']['extra_amount'];
				$total = $supplier['InventoryPurchaseDetail']['total_amount'];
				echo "(-)".$extra_amount;
			}
			else{
				$extra_amount = $supplier['InventoryPurchaseDetail']['extra_amount'];
				$total = $supplier['InventoryPurchaseDetail']['total_amount'];
				$amt = ($supplier['InventoryPurchaseDetail']['extra_amount']*$supplier['InventoryPurchaseDetail']['total_amount'])/100;
				echo "(-)".$amt;
			}


		}
	  ?>


	 </td>
	 <td class="row_format"><?php
	 	if($supplier['InventoryPurchaseDetail']['payment_mode'] == "credit"){
	 	if($supplier['InventoryPurchaseDetail']['extra_amount_type']==0)
	 		{
				$extra_amount = $supplier['InventoryPurchaseDetail']['extra_amount'];
				$total = $supplier['InventoryPurchaseDetail']['total_amount'];
				echo $extra_amount+$total;
			}
			else{
				$extra_amount = $supplier['InventoryPurchaseDetail']['extra_amount'];
				$total = $supplier['InventoryPurchaseDetail']['total_amount'];
				$amt = ($supplier['InventoryPurchaseDetail']['extra_amount']*$supplier['InventoryPurchaseDetail']['total_amount'])/100;
				echo $total+$amt;
			}
		}else{
		if($supplier['InventoryPurchaseDetail']['extra_amount_type']==0)
	 		{
				$extra_amount = $supplier['InventoryPurchaseDetail']['extra_amount'];
				$total = $supplier['InventoryPurchaseDetail']['total_amount'];
				echo $total-$extra_amount;
			}
			else{
				$extra_amount = $supplier['InventoryPurchaseDetail']['extra_amount'];
				$total = $supplier['InventoryPurchaseDetail']['total_amount'];
				$amt = ($supplier['InventoryPurchaseDetail']['extra_amount']*$supplier['InventoryPurchaseDetail']['total_amount'])/100;
				echo $total-$amt;
			}


		}
	  ?> </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="10" align="center">
     <!-- Shows the page numbers -->
     <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     <!-- Shows the next and previous links -->
     <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
     <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
     <!-- prints X of Y, where X is current page and Y is number of pages -->
     <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
    </TD>
   </tr>
  <?php
         } else {
  ?>
  <tr>
   <TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>


 </table>

