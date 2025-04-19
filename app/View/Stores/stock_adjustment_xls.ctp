<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Stock Adjustment Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Stock Ledger Report" );
ob_clean();
flush();
?>

<style>
.main_wrap{ width:40%;float:left;margin:0px;padding:0px; border:1px solid #000; border-radius:5px; height:187px;min-height:250px;}
.btns{float:left !important;margin: 0 0 0 15px;}
.tabularForm{float:left; margin:10px 0 0 20px; width:92%!important;}
.inner_title{width:97%!important;}
.rightTopBg{padding-bottom: 20px}
</style>


<div class="" >
   <div class="inner_title" >
      <h3>Stock Adjustment</h3>
	  </div>
   <div class="first_table" style="padding-bottom: 20px;">
     <?php echo $this->Form->create('',array('id'=>'ProductStockAdjustmentForm'));?>
    
	  <table cellspacing="1" border="1" class="tabularForm">
	     <tr>
		   <th>#</th>
		   <th>Item Code</th>
		   <th>Item Description</th>
           <th>Adjusted Date</th>
           <th>Current Stock</th>
           <!-- <th>Report</th> -->
		 </tr>
		 <?php ?>
		 
		 
		
		 <?php if(!empty($result)) { ?>
		 <?php $i=0;
		 foreach($result as $product){ 
                $i++;
?>
		 
		 <tr>
		   <td><?php echo $i;?></td>
		   <td><?php echo $product['Product']['product_code']; ?></td>
		   <td><?php echo $product['Product']['description']; ?></td>
           <td><?php echo $this->DateFormat->formatDate2Local($product['StockAdjustment']['adjusted_date'], Configure::read('date_format'));?></td>
		   <td><?php echo $product['Product']['quantity']; ?></td>
		   <!-- <td></td> -->
		 </tr>
		  <?php }?>
		  
		  <?php }else echo "<tr><td colspan=6 align=center>No Records found!</td></tr>";
		  		
		  ?>
	  </table>
  
<?php echo $this->Form->end(); ?>
   </div>
</div>

<script>

function stockAdjustmentInner(){
	window.location.href = "<?php echo $this->Html->url(array('controller'=>'Store','action'=>'stock_adjustment_inside'))?>";
}


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



 $('#item_code').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Product","product_code",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 var value = ui.item.id;
			 $('#item_code').text(value); 
			 //alert($('#item_code').val());
			 $("#ProductStockAdjustmentForm").submit();
			// $("#ProductStockAdjustmentForm")[0].reset();
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		        }
	   });

 $('#description').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Product","description",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 var value = ui.item.id;
			 $('#description').text(ui.item.id); 
			 //alert($('#description').val());
			 $("#ProductStockAdjustmentForm").submit();
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		        }
	   });


 $ ('#adjusted_date').change(function(){

	 
		  $("#ProductStockAdjustmentForm").submit();		   
	 	  
    
 });


 $("#adjusted_date").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',	
			
	});	

 

 $('#current_stock').blur(function(){
	 $.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "stockAdjustment", "admin" => false)); ?>",
		  context: document.body,
		  data:"current_stock="+current_stock,
		  success: function(data){ 
			  $("#ProductStockAdjustmentForm").submit();		   
		  }		  
		});
		 return true;     
	 });
 
 
});




</script>