 <?php
 if(!isset($data['Patient']['id'])){ 
	$customer_name = $data['InventoryPharmacySalesReturn']['customer_name']; 
 }else{
	$customer_name  = $data['Patient']['lookup_name'].' ('.$data['Patient']['patient_id'].')';
}
 ?>
 <div style="padding:10px">
  <div class="inner_title">
<h3> &nbsp; <?php echo __('Sale Return Detail for - '.$customer_name, true); ?></h3>
	<span style="margin-top:-25px;">
	
	</span>	
	
</div>
<div>
	<?php echo $this->Session->flash(); ?>
</div>

<?php

echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
	if(count($data)>0){?>
		 <table width="100%" cellpadding="0" cellspacing="0" border="0">
                  
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="billDetailTable">
                  	<tr>
               	  	  	  <th width="40" align="center" valign="top"  style="text-align:center;">Sr. No.</th>
                          <th width="100" align="center" valign="top"  style="text-align:center;">Product Code</th>
                          <th width="" align="center" valign="top"  style="text-align:center;">Product Name</th>
                          <th width="60" align="center" valign="top"  style="text-align:center;">Pack</th>
                          <th width="60" valign="top" style="text-align:center;">Batch No.</th>
						    <th width="60" valign="top" style="text-align:center;">Expiry Date</th>
                          <th width="60" valign="top" style="text-align:center;">Mrp</th>
						  <th width="60" valign="top" style="text-align:center;">Tax</th>
                          <th width="60" valign="top" style="text-align:center;">Rate</th>
                          <th width="50" valign="top" style="text-align:center;">Qty</th>
                          <th width="80" valign="top" style="text-align:center;">Amount</th>
                     	</tr>
                        
				<?php
				$count = 1;
				$itemObj = Classregistry::init('PharmacyItem');
				foreach($data['InventoryPharmacySalesReturnsDetail'] as $key => $value){
				$item = $itemObj->find('first',array('conditions' =>array('PharmacyItem.id' => $value['item_id'])));
		
				?>		
				<tr id="row1">
				 <td align="center" valign="middle" class="sr_number"><?php echo $count; ?></td>
		         <td align="center" valign="middle"><?php echo $item['PharmacyItem']['item_code']; ?></td>
			    <td align="center" valign="middle"><?php echo $item['PharmacyItem']['name']; ?></td>
				 <td align="center" valign="middle"><?php echo $item['PharmacyItem']['pack']; ?></td>
				 <td align="center" valign="middle"><?php echo $value['batch_no']; ?></td>
				 <td align="center" valign="middle"><?php echo $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format')); ?></td>
				 <td align="center" valign="middle"><?php echo $item['PharmacyItemRate']['mrp']; ?></td>
				 <td align="center" valign="middle"><?php echo $value['tax']; ?></td>
				 <td align="center" valign="middle"><?php echo $item['PharmacyItemRate']['sale_price']; ?></td>				
				 <td align="center" valign="middle"><?php echo $value['qty']; ?></td>
				 <?php
				 $count = $count+1;
				 	$total = ((double)$value['qty']*(double)$item['PharmacyItemRate']['sale_price'])+(((double)$value['qty']*(double)$item['PharmacyItemRate']['sale_price'])*$value['tax']/100)
				 ?>
			     <td align="center" valign="middle"><?php echo number_format($total, 2); ?></td>
           		 </tr> 
				<?php
				}
				?>		
                   </table>	
	     <div class="clr ht5"></div>
		      <div class="clr ht5"></div>			   
	<div align="right">
	<?php
				   	$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'InventoryPharmacySalesReturn',$data['InventoryPharmacySalesReturn']['id'],'inventory'=>true));
				 ?>
				   
				       <input name="print" type="button" value="Print" class="blueBtn" tabindex="36" onclick="window.open('<?php echo $url;?>','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );"/> 
					     <?php 
   echo $this->Html->link(__('Back'), array('action' => 'get_pharmacy_details','sales_return'), array('escape' => false,'class'=>'blueBtn'));
   ?>
	</div>
<?php	
	}
?>
</div>