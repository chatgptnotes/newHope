<style>
.main_wrap{ width:45%;float:left;margin:0px;padding:0px; border:1px solid #000; border-radius:5px; height:187px;min-height:250px;}
.btns{float:left !important;margin: 0 0 0 15px;}
.tabularForm{float:left; margin:10px 0 0 26px; width:92%!important;}
.inner_title{width:98%!important;}
.first_table{width:100%;padding:15px;}
.count{float:left; padding-left:0px !important;padding-top:0px !important;}
.report_btn{float:left;padding:15px 0 0px 20px;}
</style>





<div class="">
   <div class="inner_title">
      <h3>Current Stock</h3>
	  </div>
   <div>
      <table  class="first_table">
        <tr>
			<!-- <td width="15%!important;" valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Item Name');?></td>-->
			<td width="41%">
			<?php echo $this->Form->create();?>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<!--  <tr>
						<td><?php echo $this->Form->input('Product.name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'first_name','label'=>false)); ?>
						</td>
					</tr>
				</table>
			</td>
			<td width="13%" class="tdLabel" id="boxSpace"><?php echo __('Batch No')?></td>
			<td width="35%"><?php echo $this->Form->input('Product.batch_number', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false)); ?></td>
		</tr>
        <tr>
            <td width="" class="tdLabel" id="boxSpace"><?php echo __('Generic Drug')?></td>
			<td width=""><?php echo $this->Form->input('Product.generic', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false)); ?></td>-->
           
            <td width="20%" class="tdLabel" id="boxSpace" style="text-align: right; padding-right:20px; "><?php echo __('Supplier')?></td>
			<td width=""><?php echo $this->Form->input('Product.supplier', array('label'=>false,'id' => 'supplier_name','class'=> 'textBoxExpnd','style'=>"width:250px",'div'=>false)); ?>
			<?php echo $this->Form->hidden('Product.supplier_id', array('label'=>false,'id' => 'supplier_id','class'=> 'textBoxExpnd','div'=>false)); ?></td>
        </tr>
         <tr>
	       <!--  <td >
				<div class="btns">
				  <div class="tdLabel count" style="" >
	                   <?php echo $this->Form->checkbox('Product.is_zero', array('label'=>false,'id' => 'is_zero')); ?>
						<?php echo __("Count Stock = 0");?>
	               </div>
				</div>
			</td>-->
			<td style="padding-right: 80px "  colspan="3">
				<div class="save_btn" style="float:right;margin:15px 0 0 15px; ">
				<?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false))?></div>&nbsp;				
				<div class="save_btn" style="float:right;margin:15px 0 0 15px; ">
				<?php echo $this->Form->input('Issue PO',array('type'=>'submit','name'=>'issuePo','class'=>'blueBtn','label'=>false,'div'=>false))?></div>&nbsp;    
  
			</td>
        </tr>
      </table>    
      
	  <table cellspacing="1" border="0" class="tabularForm">
	     <tr>
		   <th>Batch No</th>
		   <th>Product Name</th>
		   <th>Current Stock</th>
           <th>Expire date</th>
		   <th>ReOrder Level</th>
		   <th>Requisition Quantity</th>
		   <th><input type="checkbox" id="selectall"/> Select All</th>
		 </tr>
		 <?php if(!empty($productList)){
      			?>
		 <?php $count=0;
		 foreach($productList as $product){?>
		 <tr <?php if($count%2 == 0) echo "class='row_gray'"; ?>>
		   <td><?php echo $product['Product']['batch_number'];?></td>
		   <td><?php echo $product['Product']['name'];?></td>
		   <td><?php echo $product['Product']['quantity'];?></td>
           <td><?php echo $this->DateFormat->formatDate2Local($product['Product']['expiry_date'],Configure::read('date_format'));?></td>
		   <td><?php echo $product['Product']['reorder_level'];?></td>
		   <td><?php echo $product['0']['req'];?></td>
		   <td><input class="checkbox1" type="checkbox" name="check[]" value="<?php echo $product['Product']['id'];?>"></tr>
		 <?php }?>
		 <?php }else echo "<tr><td colspan=7 align=center>No Records found!</td></tr>";?>
	  </table>
	  <div class="clr ht5"></div>	  
                   <div class="clr ht5"></div>
	  <?php 
	  
	  if(!empty($productList)){?>
	   
	  <table align="center">
   <tr>
    <TD colspan="10" align="center">
     <!-- Shows the page numbers -->
     <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     <!-- Shows the next and previous links -->
     <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
     <!-- prints X of Y, where X is current page and Y is number of pages -->
     <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
     <?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
     
    </TD>
   </tr>
</table>
<?php }?>
 
   <div class="clear"></div>
</div>
<?php echo $this->Form->end();?>

<script>
$(document).ready(function() {
	
	        $('.checkbox1').attr('checked', true);
	        $("#selectall").attr('checked', true);
	           
	$('#supplier_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#supplier_id').val(ui.item.id); 
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
	
    $('#selectall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });

  //If one item deselect then button CheckAll is UnCheck
    $(".checkbox1").click(function () {
        if (!$(this).is(':checked'))
            $("#selectall").attr('checked', false);
    });

    
   
});</script>