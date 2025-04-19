 <div style="padding:10px">
 <?php
 if(isset($data['InventoryPurchaseDetail'])){
 ?>
  <div class="inner_title">
<h3> &nbsp; <?php echo __('Purchase Return Detail Vr . No - '.$data['InventoryPurchaseDetail']['vr_no'], true); ?></h3>
	<span style="margin-top:-25px;">

	</span>

</div>
<?php } ?>
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
                          <th width="80" align="center" valign="top"  style="text-align:center;">Product Code</th>
                          <th width="100" align="center" valign="top"  style="text-align:center;">Product Name</th>
                          <th width="100" align="center" valign="top"  style="text-align:center;">Manufacturer</th>
                          <th width="51" align="center" valign="top"  style="text-align:center;">Pack</th>
                          <th width="60" valign="top" style="text-align:center;">Batch No.</th>
						    <th width="60" valign="top" style="text-align:center;">Expiry Date</th>
                          <th width="60" valign="top" style="text-align:center;">Mrp</th>
						  <th width="60" valign="top" style="text-align:center;">Tax</th>
                          <th width="60" valign="top" style="text-align:center;">Rate</th>
                          <th width="50" valign="top" style="text-align:center;">Qty</th>
                          <th width="80" valign="top" style="text-align:center;">Value</th>
                     	</tr>

				<?php
				$count = 1;
				$grand_total=0;
				$itemObj = Classregistry::init('PharmacyItem');
				foreach($data['InventoryPurchaseReturnItem'] as $key => $value){
				$item = $itemObj->find('first',array('conditions' =>array('PharmacyItem.id' => $value['item_id'])));

				?>
				<tr id="row'+number_of_field+'">
				 <td align="center" valign="middle" class="sr_number"><?php echo $count; ?></td>
		         <td align="center" valign="middle"><?php echo $item['PharmacyItem']['item_code']; ?></td>
			     <td align="center" valign="middle"><?php echo $item['PharmacyItem']['name']; ?></td>
                 <td align="center" valign="middle"><?php echo $item['PharmacyItem']['manufacturer']; ?></td>
				 <td align="center" valign="middle"><?php echo $item['PharmacyItem']['pack']; ?></td>
                 <td align="center" valign="middle"><?php echo $value['batch_no']; ?></td>
				 <td align="center" valign="middle"><?php echo $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format')); ?></td>
				 <td align="center" valign="middle"><?php echo $item['PharmacyItemRate']['mrp']; ?></td>
				 <td align="center" valign="middle"><?php echo $value['tax']; ?></td>
				 <td align="center" valign="middle"><?php echo $item['PharmacyItemRate']['purchase_price']; ?></td>
				 <td align="center" valign="middle"><?php echo $value['qty']; ?></td>
				 <?php
				 $count = $count+1;
				 	$total = ((double)$value['qty']*(double)$item['PharmacyItemRate']['purchase_price'])+(((double)$value['qty']*(double)$item['PharmacyItemRate']['purchase_price'])*$value['tax']/100)
				 ?>
			     <td align="center" valign="middle"><?php echo round($total); ?></td>
           		 </tr>
				<?php
				$grand_total = $grand_total+$total ;
				}
				?>

                   </table>
				  <table><tr><td width="300">&nbsp;</td><td width="300">&nbsp;</td><td width="200">&nbsp;</td><td colspane="4">Total: </td><td><?php echo $this->Number->currency(ceil($grand_total) );?></td></tr>	</table>
		      <div class="clr ht5"></div>
	<div align="right">
	  <div align="right"><?php
				   	$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'InventoryPurchaseReturn',$data['InventoryPurchaseReturn']['id'],'inventory'=>true));
				 ?>

				       <input name="print" type="button" value="Print" class="blueBtn" tabindex="36" onclick="window.open('<?php echo $url;?>','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );"/>
	     <?php
   echo $this->Html->link(__('Back'), array('action' => 'get_pharmacy_details','purchase_return'), array('escape' => false,'class'=>'blueBtn'));
   ?>
	</div>
<?php
	}
?>
</div>