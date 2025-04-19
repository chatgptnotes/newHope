<div class="inner_title">
<h3>&nbsp; <?php echo __('Edit Items of Room', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#itemfrm").validationEngine();
	});

 // For date picker in expiry and date of creation of item
	/*$(function() {
		   
			
		$("#entryDate").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			minDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',			
		});		
	});	*/
</script>

<form name="itemfrm" id="itemfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "inventory_edit/",$this->data["InventoryLaundry"]["id"] )); ?>" method="post" >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Room");?><font color="red">*</font></td>
		<td>
	        <?php 
	        echo $this->Form->input('InventoryLaundry.ward_id', array('options'=>$wards,'empty'=>__('Please select'),'class' => 'validate[required,custom[wardselect]]', 'id' => 'wardselect', 'label'=> false, 'div' => false, 'error' => false));
	        ?>
		</td>
		<td width="100" class="tdLabel" id="boxSpace">Date <font color="red">*</font></td>
		<td width="250"><?php 
				$changeDate  = $this->DateFormat->formatDate2Local($this->data["InventoryLaundry"]["create_time"],Configure::read('date_format'),true);
        		echo $this->Form->input('InventoryLaundry.date', array('id'=>'entryDate','label'=> false, 'div' => false, 'error' => false,'type'=>'text','readonly'=>'readonly','value'=>$changeDate));?></td>
		
		
	  </tr>
	  <tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Item Name<font color="red">*</font></td>
		<td width="250"><?php 
        echo $this->Form->input('InventoryLaundry.name', array('options'=>$items,'empty'=>__('Please select'),'class' => 'validate[required,custom[name]]', 'id' => 'item_name', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('action' => 'add','inventory'=>true),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{item_id:$("#item_name").val()}', 'dataExpression' => true, 'div'=>false))));
		
		echo $this->Form->hidden('InventoryLaundry.id', array('label'=> false, 'div' => false, 'error' =>	false,'type'=>'text','readonly'=>'readonly','value'=>$this->data["InventoryLaundry"]["id"]));

		echo $this->Form->hidden('InventoryLaundry.ward_id', array('label'=> false, 'div' => false, 'error' => false,'type'=>'text','readonly'=>'readonly','value'=>$this->data["InventoryLaundry"]["ward_id"]));
		?></td>

	    <td width="100" valign="middle" class="tdLabel" id="boxSpace">Item Code<font color="red">*</font></td>
		<td width="250" id="changeCreditTypeList"><?php 
        echo $this->Form->input('InventoryLaundry.item_code', array('class' => 'validate[required,custom[itemcode]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly')  );?></td>
		
	  </tr>
	
	  
	  <tr>
	
		<td valign="middle" class="tdLabel" id="boxSpace">Total Quantity<font color="red">*</font></td>
		<td><?php 
        echo $this->Form->input('InventoryLaundry.quantity', array('class' => 'validate[required,custom[quantity]]', 'id' => 'total_quantity', 'label'=> false, 'div' => false, 'error' => false,'onchange'=>'getTotalQuantity();')  );?>
		</td>

		<td valign="middle" class="tdLabel" id="boxSpace">Supplier</td>
		<td><?php 
        echo $this->Form->input('InventoryLaundry.supplier', array('label'=> false, 'div' => false, 'error' => false)  );?></td>

		 <!-- <td class="tdLabel" id="boxSpace">Minimum Quantity <font color="red">*</font></td>
		<td><?php 
        echo $this->Form->input('InventoryLaundry.min_quantity', array('class' => 'validate[required,custom[quantity]]', 'id' => 'min_quantity','label'=> false, 'div' => false, 'error' => false,'onchange'=>'getMinQuantity($("#total_quantity").val());')  );?></td> -->
		
	 </tr>
	  <tr>
	   	<td valign="top" class="tdLabel" id="boxSpace">Manufacturer</td>
		<td valign="top"><?php 
        echo $this->Form->input('InventoryLaundry.manufacturer', array('label'=> false, 'div' => false, 'error' => false)  );?>
		</td>

		<td class="tdLabel" id="boxSpace" valign="top">Description</td>
		<td><?php 
        echo $this->Form->input('InventoryLaundry.description', array('label'=> false, 'div' => false, 'error' => false)  );?></td>
	 </tr>
	 <tr>
		<!--<td class="tdLabel"  id="boxSpace">Pack</td>
		<td><?php 
        echo $this->Form->input('InventoryLaundry.pack', array('class' => 'validate[required,custom[name]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false)  );?></td>-->
		<!-- <td class="tdLabel" id="boxSpace" valign="top">Description</td>
		<td><?php 
        echo $this->Form->input('InventoryLaundry.description', array('label'=> false, 'div' => false, 'error' => false)  );?></td> -->
	 </tr>
	
	</table>
	<!-- billing activity form end here -->
   <div class="btns">
	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
  </div>
</form>

<script>
// To validate totoal quantity
	function getTotalQuantity(){
		var total_quantity = $("#total_quantity").val();
		//var min_quantity = $("#min_quantity").val();

	// Remove space
		total_quantity = total_quantity.replace(/^\s+|\s+$/g, '');

	//Flag to check input as number. If number returns true else false
		number = /^\s*\d+\s*$/.test(total_quantity);
	
		/*if(!number){
			alert('Only numbers are allowed!');
			$("#total_quantity").focus();
			document.getElementById('total_quantity').value = '';

		}else*/ if(total_quantity == 0 || total_quantity == ''){
			alert('ZERO or EMPTY not allowed!');
			$("#total_quantity").focus();
			document.getElementById('total_quantity').value = '';
		
		} /*else if(min_quantity != '' && total_quantity < min_quantity){
			alert('Invalid Entry! Total quantity should not be less than minimum quantity.');
			$("#total_quantity").focus();
			document.getElementById('total_quantity').value = '';			
		} */
	} 
	
// To validate minimum quantity

</script>


 