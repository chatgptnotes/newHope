 <table  cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center" id = 'changeCreditTypeList' width="100%">
<tr>
	<th width="10%">Sr. No.</th>
	<th width="38%">Linen</th>
	<th width="15%">Total Stock</th>
	<th width="10%">In Stock</th>
	<!-- <th width="8%">Min. Qty.</th> -->
	<th width="1%">Quantity</th>	
	<th width="47%">Notes / Remarks</th>
</tr>		
	
	<?php //pr($laundries);exit;
		   // Initialise a veriable for serial number
			 $i = 1;
			 $k = 0;
			 $stock= 0;
		  // Start loop for each entry
		 if(!empty($laundries)){
			 $count = ClassRegistry::init('InventoryLaundry')->find('count');
			//pr($laundries);exit;
		     foreach($laundries as $laundry){
				//pr($laundry);exit;
			
			?>
			
			 
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $laundry['InventoryLaundry']['name'];?></td>
				<td><?php echo $laundry['InventoryLaundry']['quantity'];?></td>				
			    <td><?php 
					$getid = ClassRegistry::init('InstockLaundry')->find('first',array('conditions'=>array('InstockLaundry.ward_id'=>$laundry['InventoryLaundry']['ward_id'],'InstockLaundry.item_code'=>$laundry['InventoryLaundry']['item_code']),'fields'=>'MAX(InstockLaundry.id) as id'));
					
					$getStock = ClassRegistry::init('InstockLaundry')->find('first',array('conditions'=>array('InstockLaundry.id'=>$getid[0]['id'], 'InstockLaundry.item_code'=>$laundry['InventoryLaundry']['item_code'])));
			//pr($getStock);
					if($getStock['InstockLaundry']['in_stock'] !='' ){
						$instock = $getStock['InstockLaundry']['in_stock'];
						
					} else {
						$instock = $laundry['InventoryLaundry']['quantity'];	
					}
					echo $instock;
					?></td>
			    <!-- <td><?php echo $laundry['InventoryLaundry']['min_quantity'];?></td> -->
			    <td><?php 
					 echo $this->Form->input('LaundryManager.quantity'.$i, array('label'=> false, 'div' => false, 'error' => false,'onchange'=>'getChecked('.$instock.','.$laundry['InventoryLaundry']['quantity'].',this.id);'));?></td>
				 <td><?php 
					 echo $this->Form->input('LaundryManager.description'.$i, array('label'=> false, 'div' => false, 'error' => false,'style'=>'width:92%;'));
					//$item = $laundry['InventoryLaundry']['name'];
				// Set Item Name
					 echo $this->Form->hidden('LaundryManager.item'.$i,array('label'=> false, 'div' => false, 'error' => false,'type'=>'hidden','value'=>$laundry['InventoryLaundry']['name']));
				// Set number of items
					 echo $this->Form->hidden('LaundryManager.list',array('label'=> false, 'div' => false, 'error' => false,'type'=>'hidden','value'=>$i));
				//Set code
					  echo $this->Form->hidden('LaundryManager.code'.$i,array('label'=> false, 'div' => false, 'error' => false,'type'=>'hidden','value'=>$laundry['InventoryLaundry']['item_code']));
				//Set in stock
					  echo $this->Form->hidden('LaundryManager.total_quantity'.$i,array('label'=> false, 'div' => false, 'error' => false,'type'=>'hidden','value'=>$laundry['InventoryLaundry']['quantity']));
				

				?></td>
			</tr>
		<?php  $i++; } 
			//Set in stock count
					  echo $this->Form->hidden('count',array('id'=>'totalCount','label'=> false, 'div' => false, 'error' => false,'type'=>'hidden','value'=>$count)); ?> 
		<?php  } else {?>
			<tr>
				<td colspan="8" align="center">
					No Record Found
				</td>
			</tr>
		<?php } ?>
	</table>

	<script> 
		var count = $('#totalCount').val();
		
		if(count >=1){
			$('#submit').show();
		} else {
			$('#submit').hide();
		}
	</script>
	