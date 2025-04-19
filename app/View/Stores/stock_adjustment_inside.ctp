<?php //debug($this->request->data);?>
<style>
.main_wrap{ width:100%;float:left;margin:0px;padding:0px;}
.btns{float:left !important;margin: 0 0 0 15px;}
.tabularForm{float:left; margin:10px 0 0 20px; width:92%!important;}
.inner_title{width:97%!important;}
.radio_sec{margin-bottom:50px;border: 1px solid; margin-left:20px; width:100%;}
.table_sec{margin-top:30px; float:left}
label{margin-right:0px!important;width:19px!important;padding-top: 0px!important;}
</style>




<?php $val = $this->params['pass'][0];//debug($this->params['pass'][0])?>
<div class="main_wrap">
   <div class="inner_title">
      <h3>Stock Adjustment</h3>
	  </div>
   <div class="first_table">
   <?php echo $this->Form->create('',array('id'=>'stockadjust'));?>
    <table style="float:left; width:93%;">
        <tr><td>&nbsp;</td></tr>
         		
         <tr>
                        <td>
                         <table width="" class="radio_sec">
                         <tr>
						<td width="15%" valign="top" class="tdLabel"><?php  $options  = array('A'=>'All','S'=>'Surplus','D'=>'Deficit','Dmg'=>'Damage','E'=>'Expired');
		   //$attributes=array('label'=> false, 'div' => false, 'error' => false,'class'=>'typeSelected');
           echo $this->Form->input('StockAdjustment.type',array('type'=>'radio','options'=>$options,'div'=>false,'label'=>false,'legend'=>false,'class'=>'typeSelected','style'=>'margin-left:10%','value'=>$val));
	?></td>
						
                        </tr>
                        </table>
						</td>
					</tr>
					<tr><td>
                  <table>
                  <tr>
			<td width="60%"></td>			
			<td width="10%" class="tdLabel" id=""><?php echo __('From Date')?><font color="red">*</font></td>
			<td width="10%"><?php echo $this->Form->input('StockAdjustment.from', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'from','value'=>$this->request->query['from'],'label'=>false,'style'=>'width:60%')); ?>
									</td>
			
			<td width="10%" class="tdLabel" id=""><?php echo __('To Date')?></td>
			<td width="10%"><?php echo $this->Form->input('StockAdjustment.to', array('label'=>false,'id' => 'to','value'=>$this->request->query['to'],'class'=> 'textBoxExpnd','div'=>false,'style'=>'width:60%')); ?>
				</td>
			<td><div class="save_btn " style="float:left;margin:0 0 0 15px; "><div class="save_btn" style="float:right;margin:15px 0 0 15px; ">
				<?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false))?></div>
			</td>
		</tr>
                  </table>
                  </td></tr>
		<tr><td>&nbsp;</td></tr>
                  
                 
                   <tr>
                     <td width="100%">
                       <table width="100%">
                         <tr>
                         <td width="17%!important;" valign="middle" class="tdLabel"><?php echo __('Item Name');?><br />
                            <?php echo $this->Form->input('Product.name', array('style'=>'width:80% !important;','class' => 'validate[required,custom[name]] textBoxExpnd',
		    		          'id' => 'name','value'=>$this->data[0]['Product']['name'],'label'=>false,'div' => false,'type'=>'text'));
                                 echo $this->Form->hidden('Product.id',array('id'=>'nameId','value'=>$this->data[0]['Product']['id'],'div'=>false,'label'=>false));
                             ?>
									</td>
					   <td width="22%!important;" valign="" class="tdLabel"><?php echo __('Batch');?><br />
                            <?php echo $this->Form->input('batch_number', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'batch_number','value'=>$this->data[0]['Product']['batch_number'],'label'=>false,'div'=>false,'type'=>'text')); ?>
                            </td>
                       <td width="22%!important;" valign="" class="tdLabel"><?php echo __('Opening Stock');?><br />
                            <?php echo $this->Form->input('quantity', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'quantity','value'=>$this->data[0]['Product']['quantity'],'label'=>false,'div'=>false,'type'=>'text')); ?>
                            </td>
                       <td width="22%!important;" valign="" class="tdLabel" id=""><?php echo __('Cost');?><br />
                            <?php echo $this->Form->input('cost', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'cost','value'=>$this->data[0]['Product']['mrp'],'label'=>false,'div'=>false,'type'=>'text')); ?>
                            </td>
                        <td width="22%!important;" valign="" class="tdLabel" id=""><?php echo __('Adjustment');?><br />
                            <?php echo $this->Form->input('StockAdjustment.adjusted_qty', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'adjustment','value'=>$this->data[0]['StockAdjustment']['adjusted_qty'],'label'=>false,'div'=>false,'type'=>'text'));
                            	   ?>
									 
                            </td>
                           <td width="20%!important;"><?php echo $this->Form->input('OK',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false)) ?></td> 
                            <!-- <td>
								<input name="" type="submit" value="OK" class="blueBtn" onclick="addButton()"
									id="" tabindex="6" /></td> -->
                            </tr>
                            </table>
                       </td>
                   </tr>
        </table>
      
	  <table cellspacing="1" border="0" id="newTable" class="tabularForm table_sec" style="">
	     <tr>
		   <!-- <th width="14%">Edit</th> -->
		   <th width="14%">Item Name</th>
		   <th width="14%">Batch No</th>
           <th width="14%">Opening Stock</th>
           <th width="14%">Cost</th>
           <th width="14%">Adjusted Quantity</th>
           <th width="14%">Current Stock</th>
           <th width="14%">Action</th>
		 </tr>
		 <?php if(!empty($result)){//debug($result);
		 			foreach($result as $detail){?>
					 <tr>
					   <td ><?php echo $detail['Product']['name'];?>
					  
					   <td><?php echo $detail['Product']['batch_number'];?></td>
			           
			            <td>
			           <?php $adjustment=$detail['StockAdjustment']['adjusted_qty'];
			           if($this->params['pass'][0]=='S'){
                          $curr_stock=$detail['Product']['quantity']-$adjustment; echo $curr_stock;
                        }else if($this->params['pass'][0]=='D'){
                          $curr_stock=$detail['Product']['quantity']+$adjustment; echo $curr_stock;
                        }else if($this->params['pass'][0]=='Dmg'){
                          $curr_stock=$detail['Product']['quantity']+$adjustment; echo $curr_stock;
                        }else if($this->params['pass'][0]=='E'){
                          $curr_stock=$detail['Product']['quantity']+$adjustment; echo $curr_stock;
                        }
                        ?></td>
                       
					   <td><?php echo $detail['Product']['mrp'];?></td>
					 
					   <td><?php echo $detail['StockAdjustment']['adjusted_qty'];?></td>
			           
			           <td><?php echo $detail['Product']['quantity']?></td>
			          
			           <td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true))),array('action'=>'stock_adjustment_inside',$this->params['pass'][0],$detail['StockAdjustment']['id']), array('escape' => false));
			           
			            echo $this->Html->link($this->Html->image('icons/cross.png', array('alt' => __('Delete Item', true),'title' => __('Delete Item', true))),array('action'=>'deleteStockAdj',$detail['StockAdjustment']['id']), array('escape' => false),__('Are you sure?', true));?>
			            </td>
					 </tr> 
					 
					 <?php }
				}?>
	  </table>
	  
        <table width="100%" class="table_sec">
        <tr>
            <td style="padding-bottom:20px;"><?php echo $this->Html->link('New',array('controller'=>'Store','action'=>'stock_adjustment_inside'),array('class'=>'blueBtn','style'=>'margin-left: 17px;'));
	                  echo $this->Html->link('Report',array('controller'=>'Store','action'=>'stock_adjustment_inside_xls',$this->params['pass'][0]),array('class'=>'blueBtn','style'=>'margin:0px 10px'));
	                  echo $this->Html->link('Back',array('controller'=>'Store','action'=>'stockAdjustment'),array('class'=>'blueBtn'));?>
	                  
            </td>
	        
        </tr>
       </table>
              
       <?php echo $this->Form->end(); ?>
   </div>
</div>



<script>

	                  
$(function() {

	$('#name').on('focus',function()
			{
		
		if($('input[type=radio]:checked').size() <= 0)
	  	{
			alert("Please Select Type First.");
			setTimeout(function() { $(".typeSelected").focus(); }, 50);
			return false;
		}

		var t = $(this);
		$(this).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","Product","id&name&batch_number&quantity&mrp",'null',"no","no","admin" => false,"plugin"=>false)); ?>"+'/'+'is_deleted=0&',
			 minLength: 1,
			 select: function( event, ui ) {
			 //alert('compoId->'+ui.item.id+',name->'+ui.item.value+',batch_number->'+ui.item.batch_number+',quantity->'+ui.item.quantity+',mrp->'+ui.item.mrp);
				 $('#nameId').val(ui.item.id); //alert(ui.item.id);//nameIdStock
				 $('#nameIdStock').val(ui.item.id);
				 $('#name').val(ui.item.value); 
				 $('#batch_number').val(ui.item.batch_number); 
				 $('#quantity').val(ui.item.quantity); 
				 $('#cost').val(ui.item.mrp); 

				
				//console.log(ui);first_name
			 },
			 messages: {noResults: '',results: function() {}
			 }
		});
		});

	
	
});
function editStock(stockId){
	newCntr = stockId;
	 $('#name').val($.trim($('#name_'+stockId).text()));
	 $('#nameId').val($.trim($('#productId_'+stockId).text()));
	 $('#nameIdStock').val($.trim($('#productId_'+stockId).text()));
	 $('#batch_number').val($.trim($('#batch_number_'+stockId).text()));
	 $('#quantity').val($.trim($('#quantity_'+stockId).text()));
	 $('#cost').val($.trim($('#cost_'+stockId).text())); 
	 $('#adjustment').val($.trim($('#adjustment_'+stockId).text()));

	 $('#StockAdjustmentId').val($.trim($('#stockAdjId_'+stockId).text()));
	// alert($('#StockAdjustmentId').val($('#stockAdjId_'+stockId).text()));
		 
}


$('.typeSelected').click(function(){
	var selectedVal=$(this).val();
	window.location.href="<?php  echo $this->Html->url(array("controller" => 'Store', "action" => "stock_adjustment_inside", "admin" => false));?>"+"/"+selectedVal;
	
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
});
  </script>
