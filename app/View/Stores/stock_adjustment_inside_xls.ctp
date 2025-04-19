
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
.main_wrap{ width:62%;float:left;margin:0px;padding:0px; border:1px solid #000; border-radius:5px;min-height:300px;}
.btns{float:left !important;margin: 0 0 0 15px;}
.tabularForm{float:left; margin:10px 0 0 20px; width:92%!important;}
.inner_title{width:98%!important;}
.report_btn{float:left;padding:15px 0 10px 20px;}
.first_table{width:50%; float:left;}
</style>


<div class="">
<div class="inner_title">
<h3 style="text-align: center;">Stock Adjustment</h3>
</div>
<div class="first_table">
      
	  <table cellspacing="1" border="1" class="tabularForm" colspan="5" align="center">
	 <tr>
		   <!-- <th width="14%">Edit</th> -->
		   <th width="14%">Item Name</th>
		   <th width="14%">Batch No</th>
           <?php if($this->params['pass'][0]) {?>
           <th width="14%">Opening Stock</th>
           <?php }?>
           <th width="14%">Cost</th>
           <th width="14%">Adjusted Quantity</th>
           <th width="14%">Current Stock</th>
           <th width="14%">Type</th>
		 </tr>
		 <?php if(!empty($result)){//debug($result);
		 			foreach($result as $detail){?>
					 <tr>
					   <td ><?php echo $detail['Product']['name'];?>
					  
					   <td><?php echo $detail['Product']['batch_number'];?></td>
			           
			           <?php if($this->params['pass'][0]) {?>
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
                        <?php }?>
					   
					   <td><?php echo $detail['Product']['mrp'];?></td>
					 
					   <td><?php echo $detail['StockAdjustment']['adjusted_qty'];?></td>
			           
			           <td><?php echo $detail['Product']['quantity']?></td>
			          
			           <td><?php if($detail['StockAdjustment']['is_surplus']=='1')
			           	             echo "Surplus";
			           			 else if($detail['StockAdjustment']['is_deficit']=='1')
			           			 	 echo "Deficit";
			           			 else if($detail['StockAdjustment']['is_damaged']=='1')
			           			 	 echo "Damaged";
			           			 else if($detail['StockAdjustment']['is_expired']=='1')
			           			 	 echo "Expired";
			           	
			           	?></td>
			           
			          <!--  <td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true))),array('action'=>'stock_adjustment_inside',$this->params['pass'][0],$detail['StockAdjustment']['id']), array('escape' => false));
			           
			            echo $this->Html->link($this->Html->image('icons/cross.png', array('alt' => __('Delete Item', true),'title' => __('Delete Item', true))),array('action'=>'deleteStockAdj',$detail['StockAdjustment']['id']), array('escape' => false),__('Are you sure?', true));?>
			            </td> -->
					 </tr> 
					 
					 <?php }
				}?>
	  </table>