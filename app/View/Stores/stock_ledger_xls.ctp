<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Stock Ledger Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Stock Ledger Report" );
ob_clean();
flush();
?>


<style>
.main_wrap{ width:62%;float:left;margin:0px;padding:0px; border:1px solid #000; border-radius:5px;min-height:300px;}
.btns{float:left !important;margin: 0 0 0 15px;}
.tabularForm{float:left; margin:10px 0 0 20px; width:92%!important;}
.inner_title{width:98%!important;}
.report_btn{float:left;padding:15px 0 10px 20px;}
</style>


<div class="">
<div class="inner_title">
<h3 style="text-align: center;">Stock Ledger</h3>
</div>
<div class="first_table">
      
	  <table cellspacing="1" border="1" class="tabularForm" colspan="7">
	     <tr>
		   <th>OpeningStock</th>
		   <th>Item Name</th>
		   <th>Total Purchase Quantity</th>
           <th>Total Issue Quantity</th>
		   <th>Current Stock</th>
		   <th>Cost Price</th>
           <th>ReOrder level</th>
           <th>Total Amount</th>
		 </tr>
		 <?php //debug($result);?>
		 <?php if(!empty($result)) { ?>
		 <?php foreach($result as $product){ ?>
		 <tr>
		   <td><?php echo ($product['Product']['quantity']+$product['StoreRequisitionParticular']['issued_qty']); ?></td>
		   <td><?php echo $product['Product']['name']; ?></td>
		   <td></td>
           <td><?php echo $product['StoreRequisitionParticular']['issued_qty']?></td>
		   <td><?php echo $product['Product']['quantity']; ?></td>
		   <td><?php echo $product['Product']['cost_price']; ?></td>
           <td><?php echo $product['Product']['reorder_level']; ?></td>
           <?php  
                  $currStock=$product['Product']['quantity'];
                  $cp=$product['Product']['cost_price'];
           ?>
           <td><?php echo $currStock*$cp;?></td>
		 </tr>
		  <?php }?>
		  
		  <?php }else echo "<tr><td colspan=8 align=center>No Records found!</td></tr>";
		  		
		  ?>
		  
		
	  </table>
 	
   </div>
</div>

<script>

	$(function() {
		$("#from").datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'dd/mm/yy',			
		});	
			
	 $("#to").datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'dd/mm/yy',			
		});
		
		/*$('#current_stock').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Product","quantity",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#product_id').val(ui.item.id); 
			 
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		        }
	   });*/
	
	  $('#manufacturer').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Product","manufacturer",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#product_id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
		});	
		
		});

	//jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	//jQuery("#reportfrm").validationEngine();
	//});
</script>
