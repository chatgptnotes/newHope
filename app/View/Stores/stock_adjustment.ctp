<style>
.main_wrap{ width:40%;float:left;margin:0px;padding:0px; border:1px solid #000; border-radius:5px; height:187px;min-height:250px;}
.btns{float:left !important;margin: 0 0 0 15px;}
.tabularForm{float:left; margin:10px 0 0 20px; width:98%!important;}
.inner_title{width:97%!important;}
.rightTopBg{padding-bottom: 20px}
</style>

<?php  echo $this->Html->script(array('jquery.blockUI')); ?>

<div class="" >
   <div class="inner_title" >
   <?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
      <h3>Stock Adjustment</h3>
	  </div>
	<?php echo $this->Form->create('stockAdjustment',array('id'=>'stockAdjustmentForm')); ?>    	
	<table width="100%" style="float:left;margin-top:20px; padding-left:20px;" border="0">
		<tr>
			<td align="left" width="80px">Department : </td>
			<td align="left"><?php echo $this->Form->input('',array('name'=>'department','type'=>'select','options'=>$department,'div'=>false,'label'=>false,'id'=>'department'))?></td>
			<td align="right">
			 <?php
				echo $this->Html->link(__('Back'),array('action'=>'department_store'), array('escape' => false,'class'=>'blueBtn'));
			 ?>
			</td>
		</tr>
	</table>    


	<table cellspacing="1" border="0" class="tabularForm" id="product-table">
		<thead>
			<tr> 
			   <th style="text-align: center"><?php echo __("Item Name");?></th>
			   <th style="text-align: center"><?php echo __("Batch");?></th>
	           <th style="text-align: center"><?php echo __("Current Stock");?></th>
	           <th style="text-align: center"><?php echo __("Add Qty");?></th>
	           <th style="text-align: center"><?php echo __("Substract Qty");?></th>
	           <th style="text-align: center"><?php echo __("Total Stock");?></th>
	           <th style="text-align: center"><?php echo __("Actions");?></th> 
			</tr>
		 </thead>
		 <tbody>
		 	<tr>
		 		<td><?php echo $this->Form->input('',array('type'=>'text','name'=>'product_name','fieldno'=>'1','id'=>'product_name','class'=>'product_id textBoxExpnd','div'=>false,'label'=>false));
		 				  echo $this->Form->hidden('',array('name'=>'product_id','fieldno'=>'1','id'=>'product_id','class'=>'product_id'));
		 				  echo $this->Form->hidden('',array('name'=>'drug_id','fieldno'=>'1','id'=>'drug_id','class'=>'drug_id')); ?>
		 				  </td>
		 		<td><?php echo $this->Form->input('',array('type'=>'select','empty'=>'Select Batch','name'=>'batch_number','id'=>'batch_no','class'=>'batch_no textBoxExpnd','div'=>false,'label'=>false));
		 				  echo $this->Form->hidden('',array('id'=>'batch','name'=>'batch','value'=>''));?></td>
		 		<td style="text-align:center"><span id="current_stock"></span></td>
		 		<td><?php echo $this->Form->input('',array('type'=>'text','name'=>'add_qty','id'=>'add','class'=>'add textBoxExpnd','div'=>false,'label'=>false))?></td>
		 		<td><?php echo $this->Form->input('',array('type'=>'text','name'=>'substract_qty','id'=>'substract','class'=>'substract textBoxExpnd','div'=>false,'label'=>false))?></td>
		 		<td style="text-align:center"><span id="total_stock"></span></td>
		 		<td>
		 			<table align="center">
		 				<tr>
		 					<td><?php echo $this->Html->image('icons/saveSmall.png',array('div'=>false,'label'=>false,'alt'=>'save','title'=>'save','id'=>'save'));?></td>
		 					<td><?php echo $this->Html->image('icons/delete.png',array('div'=>false,'label'=>false,'alt'=>'reset','title'=>'reset','id'=>'reset'));?></td>
		 				</tr>
		 			</table>
		 		</td>
		 	</tr>
		 	<tr id="message" style="display:none;">
		 		<td id="display-message" colspan="7" style="text-align:center"></td>
		 	</tr>
		 </tbody>
	</table>
	<?php echo $this->Form->end();?>	
   </div> 

<script>

function stockAdjustmentInner(){
	window.location.href = "<?php echo $this->Html->url(array('controller'=>'Store','action'=>'stock_adjustment_inside'))?>";
}

$(document).on('focus','#product_name', function() {
	var departmentId = $('#department').val(); 
    $(this).autocomplete({
         source: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "item_search_autocomplete","admin" => false,"plugin"=>false)); ?>"+'/'+departmentId,
             minLength: 1,
             select: function(event, ui ) {
            	//console.log(ui.item);
            	var productId = ui.item.id;
            	var drugId = ui.item.product_id;
            	$("#product_id").val(productId);
            	$("#drug_id").val(drugId);
            	loadData(productId);
             },
             messages: {
                    noResults: '',
                    results: function() {},
             },
           
        });
   
 });


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

function loadData(productId){
	var departmentId = $('#department').val(); 
	$("#message").hide();
	$("#total_stock").html('');
	$("#current_stock").html('');
	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "fetch_rate_for_items","admin"=>false,"plugin"=>false)); ?>",
		  data: "department="+departmentId+"&product_id= "+productId,
		  context: document.body,				  		  
		  beforeSend:function(data){
			  loading();
		 },
		 success: function(data)
		  {
			var item = $.parseJSON(data); 
		 	//console.log(item);
		 	var qty = '';
		 	$("#total_stock").html(item.PharmacyItem.total);
		 	batches= item.PharmacyItemRate;
			$("#batch_no option").remove();
			if(batches!=''){
				$.each(batches, function(index, value) { 
				    $("#batch_no").append( "<option value='"+value.id+"'>"+value.batch_number+"</option>" );
					if(index==0){ 
						var pack = parseInt((item.PharmacyItem.pack)!=''?item.PharmacyItem.pack:'1');
						var totalRateStock = parseInt((value.stock * pack) + parseInt(value.loose_stock)); 
					 	$("#current_stock").html(totalRateStock);
		            }					
				});
				var batchh = $("#batch_no").find(":selected").text();
				$("#batch").val(batchh); 
			} else{
				$("#message").show();
				$('#display-message').html("<strong> Sorry no batch is available for this product..!!</strong>");
			}
		 	onCompleteRequest();		    		
		  } 
	});
}

$(document).on('change',".batch_no",function(){ 
	loading();
	var departmentId = $('#department').val(); 
	var batchRateId = $(this).val();
	$.ajax({
		type: "POST",
        url: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "fetch_batch_for_item","plugin"=>false)); ?>",
        data: "department="+departmentId+"&rate_id= "+batchRateId,
        success: function(data){
			var ItemDetail = jQuery.parseJSON(data);
			$("#current_stock").html(ItemDetail.PharmacyItemRate.rate_total);
			var batchh = $("#batch_no").find(":selected").text();
			$("#batch").val(batchh); 
			onCompleteRequest();
		}
	});
});

function loading(){
    $('#product-table').block({
        message: '',
       css: {
            padding: '5px 0px 5px 18px',
            border: 'none',
            padding: '15px',
            backgroundColor: '#000000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            color: '#fff',
            'text-align':'left'
        },
        overlayCSS: { backgroundColor: '#00000' }
    });
}

function onCompleteRequest(){
	 $('#product-table').unblock();
}

$(document).on('keypress','.add',function(){
	$("#substract").val(''); 
});

$(document).on('keypress','.substract',function(){
	$("#add").val(''); 
});

$(document).on('input',"#add, #substract",function(){
  	if (/[^0-9]/g.test(this.value)){  this.value = this.value.replace(/[^0-9]/g,'');  }
  	if (this.value.length > 5) this.value = this.value.slice(0,5);
});

$(document).on('keyup',"#add, #substract",function(e){ 
	 if(e.keyCode==13){		//enter key 
    	$('#save').trigger('click');	//trigger click for 
    } 
});

$("#save").click(function(){
	var form_value = $("#stockAdjustmentForm").serialize(); 
	var curStock = parseInt($("#current_stock").html());
	var subStock = parseInt($("#substract").val());
	if(subStock > curStock){
		alert("You've only "+curStock+" quantity in current stock");
		return false;
	}else{
		$.ajax({
	 		type:'POST',
			url: '<?php echo $this->Html->url(array('controller'=>'Store','action'=>'updateItem','admin'=>false));?>',
			data: form_value,
			beforeSend:function(data){
				loading();
			},
			success:function(data){
				$("#message").show();
				$('#display-message').html(data);
				reset();
				onCompleteRequest();
			}
		});
	}
});

$("#reset").click(function(){
	reset();
});

$("#department").change(function(){
	reset();
});

function reset(){
	$("#product_name").val('');
	$("#product_id").val('');
	$("#drug_id").val('');
	$("#add").val('');
	$("#batch").val('');
	$("#substract").val('');
	$("#batch_no option").remove();
	$("#batch_no").append( "<option value=''>Please Select</option>" );
	$("#current_stock").html('');
	$("#total_stock").html('');
}
</script>