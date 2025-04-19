

<div class="inner_title">
 <h3>Laundry Manager</h3>
 
   <span style="margin: -23px 7px;">
		<?php 
			echo $this->Html->link(__('Add Item In Laundry'),array('controller'=>'laundries','action' => 'item_index','admin'=>true),array('escape' => false,'class'=>'blueBtn')); 
		?>
		<?php 
			echo $this->Html->link(__('Allot Item to Room'),array('action' => 'index','inventory'=>true),array('escape' => false,'class'=>'blueBtn')); 
		?>
		
		<!-- <?php 
		echo $this->Html->link(__('Laundry'),array('controller'=>'laundries','action' => 'index','inventory'=>true),array('escape' => false,'class'=>'blueBtn')); 
		?> -->
		 <?php 
		   //echo $this->Html->link(__('Get Report'),array('controller'=>'laundries','action' => 'laundry_report','inventory'=>true),array('escape' => false,'class'=>'blueBtn')); 
		  ?>

	
	</span>
 </div>
   <!-- form elements start-->
   
	   <div>&nbsp;</div>
	<form name="itemfrm" id="itemfrm" action="<?php echo $this->Html->url(array("controller" => 'laundries', "action" => "inventory_manager/", )); ?>" method="post" >

	   <table width="" cellpadding="0" cellspacing="0" border="0" align="center" >
	   <tr>
			<td width="100" class="tdLabel"><?php echo __("Room");?><font color="red"> *</font></td>
			<td width="150">
				<?php 
					 echo $this->Form->input('LaundryManager.ward_id', array('class' => 'validate[required,custom[wardselect]]', 'id' => 'ward', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select','options'=>$wards,'onchange'=> $this->Js->request(array('action' => 'manager','inventory'=>true),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{ward_id:$("#ward").val()}', 'dataExpression' => true, 'div'=>false))));?>
			</td>
			<td width="100" class="tdLabel">Type<font color="red"> *</font></td>
			<td width="150">
				<?php 
					 echo $this->Form->input('LaundryManager.type', array('class' => 'validate[required,custom[itemtype]]', 'id' => 'itemtype', 'label'=> false, 'div' => false, 'error' => false,'onfocus'=>'getClear();','empty'=>'Please Select','options'=>array('In Linen'=>'In Linen','Out Linen'=>'Out Linen')));?>
			</td>
			<td width="100"  class="tdLabel">Date</td>
			<td width="190"><?php 
					 echo $this->Form->input('LaundryManager.date', array('label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','value'=>date('d/m/Y h:i A')));?></td>
	   </tr>
	   <tr>
			<td colspan="4" height="10"></td>
	   </tr>                       
	   </table>
	   <p class="ht5"></p>
	   <table  cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center" id = 'changeCreditTypeList' width="100%">
			<tr>
				<th width="10%">Sr. No.</th>
				<th width="38%">Linen</th>
				<th width="15%">Total Stock</th>
				<th width="10%">In Stock</th>
				<!--<th width="8%">Min. Qty.</th>-->
				<th width="1%">Quantity</th>
				
				<th width="47%">Notes / Remarks</th>
			</tr>
		   <?php 
		   // Initialise a veriable for serial number
			 $i = 1;
			 $k = 0;
			 $stock= 0;
		  // Start loop for each entry
		 if(isset($laundries) && $laundries !=''){
			 $count = ClassRegistry::init('InventoryLaundry')->find('count');
			//pr($laundries);exit;
		     foreach($laundries as $key => $laundry){

			 // Calculate in stock 
				$getid = ClassRegistry::init('InstockLaundry')->find('first',array('conditions'=>array('InstockLaundry.item_code'=>$laundry['InventoryLaundry']['ward_id']),'fields'=>'MAX(id) as id'));
			// Fetch the previous entry
				$getStock = ClassRegistry::init('InstockLaundry')->find('first',array('conditions'=>array('InstockLaundry.id'=>$getid[0]['id'], 'InstockLaundry.ward_id'=>$laundry['InventoryLaundry']['ward_id'])));
		   // pr($getStock);
		    if($getStock['InstockLaundry']['in_stock'] !=''){
				$stock = $getStock['InstockLaundry']['in_stock'];
			} else{
				$stock = $laundry['InventoryLaundry']['quantity'];
			} 

			//pr($getStock['InstockLaundry']['in_stock']);
			/*if($getStock['InstockLaundry']['in_stock'] == 0){
				$stock = 0;
			}*/
	
				for($j = 0;$j<=$k;$j++) {?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $laundry['InventoryLaundry']['name'];?></td>
				<td><?php echo $laundry['InventoryLaundry']['quantity'];?></td>				
			    <td><?php echo $stock;?></td>
			    <!--<td><?php echo $laundry['InventoryLaundry']['min_quantity'];?></td>-->
			    <td><?php 
					 echo $this->Form->input('LaundryManager.quantity'.$i, array('label'=> false, 'div' => false, 'error' => false,'onblur'=>'getChecked('.$stock.','.$laundry['InventoryLaundry']['quantity'].',this.id);','onChange'=>'getChecked('.$stock.','.$laundry['InventoryLaundry']['quantity'].',this.id);'));?></td>
				 <td><?php 
					 echo $this->Form->input('LaundryManager.description'.$i, array('label'=> false, 'div' => false, 'error' => false));
					//$item = $laundry['InventoryLaundry']['name'];
				// Set Item Name
					 echo $this->Form->hidden('LaundryManager.item'.$i,array('label'=> false, 'div' => false, 'error' => false,'type'=>'hidden','value'=>$laundry['InventoryLaundry']['name']));
				// Set number of items
					 echo $this->Form->hidden('LaundryManager.list',array('label'=> false, 'div' => false, 'error' => false,'type'=>'hidden','value'=>$i));
				//Set code
					  echo $this->Form->hidden('LaundryManager.code'.$i,array('label'=> false, 'div' => false, 'error' => false,'type'=>'hidden','value'=>$laundry['InventoryLaundry']['item_code']));
				//Set in stock
					  echo $this->Form->hidden('LaundryManager.total_quantity'.$i,array('label'=> false, 'div' => false, 'error' => false,'type'=>'hidden','value'=>$laundry['InventoryLaundry']['quantity']));
				//Set in stock
					  //echo $this->Form->hidden('LaundryManager.min_quantity'.$i,array('label'=> false, 'div' => false, 'error' => false,'type'=>'hidden','value'=>$laundry['InventoryLaundry']['min_quantity']));

				?></td>
			</tr>
		<?php  }  $i++; }  $k = $i-1;
			 } else {?>
			<tr>
				<td colspan="8" align="center">
					No Record Found
				</td>
			</tr>
		<?php } ?>
	   </table>
	   <p class="ht5"></p>
	   <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
		<?php echo $this->Html->link(__('Reset', true),array('action' => 'manager','inventory'=>true), array('escape' => false,'class'=>'grayBtn'));?>
		&nbsp;&nbsp;<input type="submit" value="Save" class="blueBtn" id = "submit" >
		</div>
		
	 </div>
	 
   <!-- form element end-->

</div>

<script>

// On submit get validate the inputs	
	$(document).ready(function(){
	
	 $("#ward").change(function() {
		$('#flashMessage').hide();
	 });

	})

								// Function created to check and validate the user inputs.//


	function getChecked(stock,totalStock,id){
	//alert(stock);
	// collect the element values
		var quantity = document.getElementById(id);
		var type = document.getElementById('itemtype');
		var typeSelected = type.options[type.selectedIndex].value;
		//alert(typeSelected);
	// removing spaces from entered value  
	
	  if(quantity.value != 'null'){
        quantity.value = quantity.value.replace(/^\s+|\s+$/g, '');
	  } else {
		quantity = 0;
	  }

	//Flag to check input as number. If number returns true else false
		number = /^\s*\d+\s*$/.test(quantity.value);

	// Get the crossing quantity	
		 var limit = totalStock - stock;
		//var limit = 
		
	// If type of entry is not selected	
		if(typeSelected == ''){
			alert('Select type!');
			document.getElementById(id).value = '';
			return false;

	// Check wheather input is number or not
		} else if(!number && quantity.value !=''){
			alert('Only Numbers are allowed!');
			document.getElementById(id).value = '';
			return false;
			
   // IF quantity is greater than stock present for out linen
		
		} else if(quantity.value > stock && typeSelected == 'Out Linen'){
			alert('This much stock is not available!');
			document.getElementById(id).value = '';
			return false;
			type.selectedIndex = '';

   // IF the quantity is greater than Actual stock
	
		} else if(quantity.value > stock && typeSelected == 'Out Linen'){
			alert('Invalid Entry! Crossing actual stock!');
			document.getElementById(id).value = '';
			//type.selectedIndex = '';
			return false;

   // IF quantity is greater than stock present for In linen
		
		} else if(quantity.value > limit && typeSelected == 'In Linen'){
			//alert(limit);
			alert('Invalid Entry! Crossing actual stock. In Linen is not possible.');
			document.getElementById(id).value = '';
			//type.selectedIndex = '';
			return false;
	// If current stock and total stock are same then restrict in linen
		} else if(stock == totalStock && typeSelected == 'In Linen'){
			alert('STOCK IS COMPLETED!'+ '\n' + 'In Linen is not allowed.');
			document.getElementById(id).value = '';
			quantity.focus();			
			type.selectedIndex = '';
			return false;
	// Check the minimum stok. If reached to minimu stock. Alert the user about it
		/*} else if(stock <= minStock && quantity.value >= minStock && typeSelected == 'Out Linen'){
			alert('Minimum stock is available.');*/
		} else {
			return true;
		}

	}

	function getFlushed(){
		
		$("#itemtype option:selected").val();

	}

	function getClear(){
		var ward = $("#ward option:selected").val();
	 // Variable count is coming form ajax form
	   // Clear all the inputs
	   if(ward == ''){
		 alert('Please Select Room First!');
		 $("#itemtype option:selected").val('');
		 
	   } else {
		for(i=1;i<=count;i++){
			$('#LaundryManagerQuantity'+i).val('');
		}
	   }
	   
	}

	
</script>
<script>
	$(function(){
	// binds form submission and fields to the validation engine
		jQuery("#itemfrm").validationEngine();
	});
 // For date picker in expiry and date of creation of item
	$(function() {
		date_obj = new Date();
		date_obj_hours = date_obj.getHours();
		date_obj_mins = date_obj.getMinutes();

		if (date_obj_mins < 10) { date_obj_mins = "0" + date_obj_mins; }

		if (date_obj_hours > 11) {
			date_obj_hours = date_obj_hours - 12;
			date_obj_am_pm = " PM";
		} else {
			date_obj_am_pm = " AM";
		}

		date_obj_time = "'"+date_obj_hours+":"+date_obj_mins+date_obj_am_pm+"'"; 
		

		$("#entryDate").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			minDate: new Date(),
			//beforeShowDay: unavailable,
			// do not change date format
			dateFormat:<?php echo $this->General->GeneralDate();?>+'   '+date_obj_time,			
		});		
	});	
</script>
