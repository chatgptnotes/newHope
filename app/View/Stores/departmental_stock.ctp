<?php echo $this->Html->script(array('inline_msg'));?>
<style>
.main_wrap{ width:45%;float:left;margin:0px;padding:0px; border:1px solid #000; border-radius:5px; height:187px;min-height:250px;}
.btns{float:left !important;margin: 0 0 0 15px;}
.tabularForm{float:left; margin:10px 0 0 26px; width:92%!important;}
.inner_title{width:98%!important;}
.first_table{width:100%;padding:15px;}
.count{float:left; padding-left:0px !important;padding-top:0px !important;}
.report_btn{float:left;padding:15px 0 0px 20px;}
.requisition_option {
	display: none;
}
</style>





<div class="">
   <div class="inner_title">
   <?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
      <h3>Department Stock List</h3>
      <span> <?php 
	echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'department_store','admin'=>false,'?'=>array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
	if($this->request->data['StoreLocation']){
	echo $this->Html->link(__('Stock Requisition Form'),array('controller'=>'InventoryCategories','action'=>'storeRequisition','?'=>array('deliverTo')), array('escape' => false,'class'=>'blueBtn'));
	}
	?>
	</span>
	  </div>
   <div>
   <?php echo $this->Form->create();?>
   <table  class="first_table">
   		<tr>
   			<td width="1%">Department Location:</td>
   			<td width="12%"><?php echo $this->Form->input('department',array('options'=>$department,'empty'=>'Please Select','class'=>'department','label'=>false,'div'=>false));?></td>
   			</tr>
   			 			
   			<tr class='requisition_tr' style="display: none;">
						<td><?php echo __('Store Sub Location');?><font
								color="red">*</font></td>
							<td><?php 
							
							echo $this->Form->input('StoreLocation.ward',
                                		array('id' => 'ward', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Select ward',
                                		'options'=>$wards,'div'=>false,'class'=>'requisition_option validate[required]'));
				               			?> <?php
				               			echo $this->Form->input('StoreLocation.ot',
				                                array('id' => 'ot', 'label'=> false,'div' => false, 'error' => false,'empty'=>'Select OT',
				                                'options'=>$ot,'div'=>false,'class'=>'requisition_option  validate[required]'));
				               			?> <?php
				               			echo $this->Form->input('StoreLocation.chamber',
				                          array( 'id' =>'chamber', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Select chamber',
				                           'options'=>$chambers,'div'=>false,'class'=>'requisition_option  validate[required]'));
				               			?> <?php
				               			echo $this->Form->input('StoreLocation.other',
				                            array('id' => 'other', 'label'=> false,'div' => false, 'error' => false,'empty'=>'Select Other Location',
				                              'options'=>$department,'div'=>false,'class'=>'requisition_option  validate[required]'));
				               ?>
							</td>
						</tr>
						
   			<tr><td><?php echo $this->Form->input('Submit',array('type'=>'submit','label'=>false,'div'=>false,'class'=>'blueBtn'));?>
   		</tr>
   </table>
   <?php echo $this->Form->end();?>
   <?php if($results){?>
   <table cellspacing="1" border="0" class="tabularForm">
   <tr><th colspan="5">List of Department</th></tr>
	     <tr>
		   <th><?php echo $this->Paginator->sort('Product.name', __('Item Name', true));?></th>
		   <th>Manufacturer</th>
		   <th>Current Stock</th>
           <!--<th>Expiry date</th>-->
		<!-- <th>ReOrder Level Quantity</th>
		       <th class='select' style="<?php echo $display;?>"><input type="checkbox" id="selectall" <?php echo $disabled ;?>/> Select All</th>
		-->
		 </tr>
		 <?php if(!empty($results)){
      			?>
		 <?php $count=0;
		 foreach($results as $product){?>
		 <tr <?php if($count%2 == 0) echo "class='row_gray'"; ?>>
		   <td><?php echo $product['Product']['name'];?></td>
		   <td><?php echo $product['ManufacturerCompany']['name'];?></td>
		   <td><?php echo $product['StockMaintenanceDetail']['stock_qty'];?></td>
           <!--<td><?php echo $this->DateFormat->formatDate2Local($product['StockMaintenanceDetail']['product_expiry'],Configure::read('date_format'));?></td>-->
		   <!--<td><?php echo $this->Form->input('StockMaintenanceDetail.reorder_level',array('type'=>'text','label'=>false,'div'=>false,'class'=>'reorder','value'=>$product['StockMaintenanceDetail']['reorder_level'],'style'=>'width:50px','id'=>'reorder_'.$product['StockMaintenanceDetail']['id']))?></td>
		        <td class='select' style="<?php echo $display;?>"><input class="checkbox1" type="checkbox" name="check[]" value="<?php echo $product['Product']['id'];?>" <?php echo $disabled; ?>>
		   -->
		   </tr>
		 <?php }?>
		 <?php }else echo "<tr><td colspan=6 align=center>No Records found!</td></tr>";?>
	  </table>
   <?php }?>
   
   
   
   
   <script>
   $(document).ready(function(){
	   $select=$(".department").val();
	   if($select!=''){
		   $(".department").trigger('change');	  
	   }
   });
   $(".department").change(function(){
	   
	    $(".requisition_option").css("display","none").val('');
	    var position = $(this).position();
	    var txt=$('.department option:selected').text()	    
	    switch($('.department option:selected').text())
	        {
	            case 'Ward':
		          $('.requisition_tr').show();
	              $("#ward").css("display","block");
	              $("#ward").val(<?php echo $this->data['StoreLocation']['ward'];?>);  
	            break;
	            case 'OT':
	             $('.requisition_tr').show();
	             $("#ot").css("display","block");
	             $("#ot").val(<?php echo $this->data['StoreLocation']['ot'];?>);  
	            break;
	            case 'Chamber':
	            	$('.requisition_tr').show();
	                $("#chamber").css("display","block");
	                $("#chamber").val(<?php echo $this->data['StoreLocation']['chamber'];?>);  
	             
	            break;
	            case 'Other':
	            	 $('.requisition_tr').show();
	             
	            break;
	            default:
	            	$('.requisition_tr').hide();
	            break;

	        }

	});
  $('.reorder').change(function(){
		currentId=this.id;
		var value=$(this).val();
		splitID=currentId.split("_");
		statusId=splitID[0]+'_'+splitID[1];		
		$.ajax({
			type : "POST",
			url: "<?php echo $this->Html->url(array("controller" => 'Store', "action" => "saveReorder","admin" => false)); ?>"+"/"+splitID[1],
			data:'id='+splitID[1]+'&reorder_level='+value,
		  context: document.body,	   
		  beforeSend:function(){
		    // this is where we append a loading image
		     inlineMsg(currentId,'Updating Reorder Level..',false);
		  }, 	  		  
		  success: function(data){
			  inlineMsg(currentId,'Reorder Level Updated',false);
			  
			  
		  }
	});
		
	});</script>