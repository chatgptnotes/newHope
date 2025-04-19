<style>
.main_wrap{ width:62%;float:left;margin:0px;padding:0px; border:1px solid #000; border-radius:5px;min-height:300px;}
.btns{float:left !important;margin: 0 0 0 15px;}
.tabularForm{float:left; margin:10px 0 0 20px; width:92%!important;}
.inner_title{width:98%!important;}
.report_btn{float:left;padding:15px 0 10px 20px;}
</style>


<div class="">
   <div class="inner_title">
   <?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
      <h3>Stock Ledger</h3>
	  </div>
   <div class="first_table">
     
     
      <table style="width:94%;padding:15px;">
        <tr>
        <?php echo $this->Form->create();?>
        <td width="9%!important;" valign="middle" class="tdLabel" id=""><?php echo __('From Date');?><font
							color="red">*</font></td>
						<td style="width:20%!important;">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td><?php echo $this->Form->input('StoreRequisition.from', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'from','value'=>$this->request->query['from'],'label'=>false,'style'=>'width:20%'/* ,'default'=>date('d-m-Y') */)); ?>
									</td>
								</tr>
							</table>
						</td>
						<td  style="width:7% !important;" class="tdLabel"><?php echo __('To Date')?>
				</td>
				<td style="width:30%!important;"><?php echo $this->Form->input('StoreRequisition.to', array('label'=>false,'id' => 'to','value'=>$this->request->query['to'],'class'=> 'textBoxExpnd','div'=>false/* ,'default'=>date('d-m-Y') */,'style'=>'width:17%')); ?>
				</td>

					</tr>
                    <tr>
						<td width="" valign="middle" class="tdLabel" id=""><?php echo __('Generic Drug');?><font
							color="red">*</font></td>
						<td width="">
							<table width="55%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td><?php echo $this->Form->input('Product.generic', array('class' => 'validate[required,custom[name]] textBoxExpnd','value'=>$this->request->query['generic'],'id' => 'first_name1','label'=>false,'div'=>false)); ?>
									</td>
								</tr>
							</table>
						</td>
						

					</tr>
                    <tr>
						<td width="" valign="middle" class="tdLabel" id=""><?php echo __('Current Stock');?><font
							color="red">*</font></td>
						<td width="">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td><?php echo $this->Form->input('Product.quantity', array('style'=>'width:16% !important;','class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'current_stock','value'=>$this->request->query['current_stock'],'label'=>false,'div' => false,'type'=>'text')); ?>
                                        <?php
								     echo $this->Form->input('cur_eqtn',array('id'=>'','type'=>'select','options'=>Array('='=>'Equation','<='=>'<=','>='=>'>='),'class'=>'validate[required,custom[mandatory-select]]','label'=>false,'div' => false,'style'=>'margin:0 0 0 6px; height:24px;'));
								      ?>
									</td>
									<td>
								      
        
	                                </td>
								</tr>
							</table>
						</td>
						<td width="" class="tdLabel" id=""><?php echo __('Issue Quantity')?>
				</td>
				<td width=""><?php echo $this->Form->input('StoreRequisitionParticular.issued_qty', array('label'=>false,'id' => 'group_name','style'=>'width:17% !important;','value'=>$this->request->query['issued_qty'],'class'=> 'textBoxExpnd','div'=>false,'type'=>'text')); ?>
                <?php
								     echo $this->Form->input('issue_eqtn',array('id'=>'','type'=>'select','options'=>Array('<='=>'<=','>='=>'>='),'class'=>'validate[required,custom[mandatory-select]]','empty'=>'Equation','label'=>false,'style'=>'margin:0 0 0 6px; height:24px;'));
								      ?></td>
				
					</tr>
                    <tr>
						<td width="" valign="middle" class="tdLabel" id=""><?php echo __('Mfg Company');?><font
							color="red">*</font></td>
						<td width="">
							<table width="55%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td><?php echo $this->Form->input('Product.manufacturer', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'manufacturer','value'=>$this->request->query['manufacturer'],'label'=>false,'div' => false)); ?>
                                    <?php echo $this->Form->hidden('Product.product_id', array('label'=>false,'id' => 'manufacturer','class'=> 'textBoxExpnd','div'=>false)); ?></td>
                                    
									</td>
								</tr>
							</table>
						</td>
						<td width="auto" class="tdLabel" id=""><?php echo __('Category')?>
				</td>
				<td width=""><?php echo $this->Form->input('Product.product_category', array('options'=>$testList,'empty'=>__('Please select'),'class' => 'validate[required,custom[mandatory-enter]]','value'=>$this->request->query['product_category'],'id' => 'first_name2','label'=>false));?>
		
				</td>

					</tr>
                    <tr>
						<td width="" valign="middle" class="tdLabel" id=""><?php echo __('Search Item Name');?><font
							color="red">*</font></td>
						<td width="">
							<table width="55%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td><?php echo $this->Form->input('Product.name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'first_name','label'=>false,'div'=>false)); ?>
						
									</td>
								</tr>
							</table>
						</td>
						<td width="" class="tdLabel" id="">
                        
				</td>
				<td width="">
             
				</td>

			</tr>
			<tr>
			<td colspan="4">
					<!-- <div class="save_btn" style="float:right;margin:5px 85px 0 0; "><a href="#" class="blueBtn">View Result</a></div> -->
					<div class="save_btn" style="float:right;margin:15px 0 0 15px; ">
				<?php echo $this->Form->input('View Result',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false))?></div>
			</td>
			
			</tr>
			
                    
      </table>
      
      
	  <table cellspacing="1" border="0" class="tabularForm" colspan="7">
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
	  
	  
	  
	  
  	<div class="report_btn" style="float:right;margin:5px 100px 0 0; ">
  		
        <a href='stock_ledger_xls?q=<?php echo serialize($this->request->data); ?>' id="generate_report1" class="blueBtn">Report</a>
        <a href='stock_ledger_xls?q=<?php echo serialize($this->request->data); ?>' id="generate_report1" class="blueBtn">Date Wise Report</a>
    </div>
   </div>
</div>
 <?php echo $this->Form->end(); ?>

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
	
	  /* $('#manufacturer').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Product","manufacturer",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#product_id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
		});	*/

	   $('#manufacturer').autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","ManufacturerCompany","name",'null',"no",'no','is_deleted=0',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				 $('#manufacturer_id').val(ui.item.id); 
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});

	  $('#generate_report').click(function (){
		  var formData = $("#ProductStockLedgerForm").serialize();
			var URL  = "<?php echo $this->Html->url(array("controller" => "Store", "action" => "stock_ledger_xls","admin" => false,"plugin"=>false)); ?>"+'?='+formData;
		 // alert(URL);
		 // window.Location.href

		  });
		});

	$('#first_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Product","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#product_id').val(ui.item.id);			  
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
	//jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	//jQuery("#reportfrm").validationEngine();
	//});
</script>
