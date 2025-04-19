<style>
.row_action img{float:inherit;}
.alignRight {
	text-align: right !important;
}
.alignLeft {
	text-align: left !important;
}
.table_format {
	padding: 0px !important; 
}
</style>

<div class="inner_title">
    <?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>

    <div style="border:1">
    	<div style="float:left;">
		<h3 style=" margin-top:15px;">
	        &nbsp;
	        <?php echo __('Store Inventory Tracking', true); ?>
		</h3> 
		</div>
		<div align="right">
		<table>
			<tr> 
				<td><?php  
				echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'department_store'), array('escape' => false,'class'=>'blueBtn'));
			?></td>
			</tr>
		</table> 
		</div>
	</div>
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('',array('url' => array('action' => 'inventoryTracking'),'id'=>'content-form','type'=>'GET'));?>
    <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr class="row_title">  
                <td><?php echo __('Item :'); ?></td>
                <td><?php echo $this->Form->input( "product_name", array('placeholder'=>'Type To Search','type'=>'text','id' => 'product_name', 'class'=>'textBoxExpnd','label'=> false, 'value'=>$this->request->query['product_name'] ,'div' => false, 'error' => false,'autocomplete'=>false));
                echo $this->Form->hidden('product_id',array('id'=>'product_id','value'=>$this->request->query['product_id']));
                ?>
                </td>
                
                <td><?php echo __('From :'); ?></td> 
                <td><?php
                        echo  $this->Form->input("from", array('placeholder'=>'From date','type'=>'text','id' => 'from', 'class'=>'textBoxExpnd', 'value'=>$this->params->data['from'],'label'=> false, 'div' => false, 'error' => false));
                ?>
                </td> 
                
                <td><?php echo __('To :'); ?></td> 
                <td><?php
                        echo  $this->Form->input("to", array('placeholder'=>'To date','type'=>'text','id' => 'to', 'class'=>'textBoxExpnd', 'value'=>$this->params->data['to'],'label'=> false, 'div' => false, 'error' => false));
                ?>
                </td>

                <td><?php echo __('Supplier :'); ?></td>  
                <td><?php
                        echo  $this->Form->input("supplier_name", array('type'=>'text','id' => 'supplier_name', 'class'=>'textBoxExpnd','name'=>'supplier_name', 'value'=>$this->request->query['supplier_name'],'label'=> false, 'div' => false, 'error' => false));
                        echo $this->Form->hidden('supplier_id',array('id'=>'supplier_id','value'=>$this->request->query['supplier_id']));
                ?>
                </td> 

                <td align="right"><?php
                        echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));
                ?>
                </td>
                <td align="right"><?php
                        echo $this->Form->input(__('Generate Excel'),array('type'=>'submit','name'=>'generate_excel','class'=>'blueBtn','div'=>false,'label'=>false));
                ?>
                </td>
                <td>
                    <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Store','action'=>'inventoryTracking'),array('escape'=>false, 'title' => 'refresh'));?>
                </td>
            </tr>
        </tbody>
    </table>
<?php echo $this->Form->end();?>
<div class="clr ht5"></div> 

<table border="0" class="table_format" cellpadding="0" cellspacing="1"
	width="100%" style="text-align: center;"> 

        <tr class="row_title">
            <td rowspan="2"><strong><?php echo  __('Sr.no') ;  ?></strong></td>
            <td rowspan="2"><strong><?php echo  __('Item Name') ;  ?></strong></td>  
            <td colspan="4"><strong><?php echo  __('Previous');?> </strong></td>
            <td colspan="4"><strong><?php echo  __('Current');?> </strong></td>
        </tr>
        <tr class="row_title"> 
            <td class="table_cell alignRight" width="5%"><strong><?php echo  __('Qty');?> </strong></td> 
            <td class="table_cell alignRight" width="5%"><strong><?php echo  __('Price') ;  ?> </strong></td> 
            <td class="table_cell alignRight" width="15%"><strong><?php echo  __('Supplier');?> </strong></td> 
            <td class="table_cell alignRight" width="15%"><strong><?php echo  __('Date');?> </strong></td> 
            <td class="table_cell alignRight" width="5%"><strong><?php echo  __('Qty');?> </strong></td> 
            <td class="table_cell alignRight" width="5%"><strong><?php echo  __('Price') ;  ?> </strong></td> 
            <td class="table_cell alignRight" width="15%"><strong><?php echo  __('Supplier');?> </strong></td> 
            <td class="table_cell alignRight" width="15%"><strong><?php echo  __('Date');?> </strong></td>  
        </tr> 
	<?php 
		if(!empty($results)){
		$srno=$this->params->paging['InventoryTracking']['limit']*($this->params->paging['InventoryTracking']['page']-1);
		$count = 0;
		foreach($results as $result)
		{	$srno++;
			$count++;  ?>
		<tr <?php if($count%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format alignLeft"> <?php echo $srno;?></td>
			<td class="row_format alignLeft"> <?php echo ucfirst($result['Product']['name']);?> </td> 
                        <td class="row_format alignRight"> <?php echo $result['PurchaseOrderItemAlias']['quantity_received'];?> </td>  
			<td class="row_format alignRight"> <?php echo $result['PurchaseOrderItemAlias']['purchase_price'];?> </td>  
			<td class="row_format alignRight"> <?php echo $result['InventorySupplierAlias']['name'];?> </td>  
                         <td class="row_format alignRight">
                            <?php echo $this->DateFormat->formatDate2Local($result['PurchaseOrderItemAlias']['received_date'],Configure::read('date_format'),true); ?>
			</td>  
			<td class="row_format alignRight"> <?php echo $result['PurchaseOrderItem']['quantity_received'];?> </td> 
                        <td class="row_format alignRight"> <?php echo $result['PurchaseOrderItem']['purchase_price'];?> </td> 
                        <td class="row_format alignRight"> <?php echo $result['InventorySupplier']['name'];?> </td>  
                        <td class="row_format alignRight">
                            <?php echo $this->DateFormat->formatDate2Local($result['PurchaseOrderItem']['received_date'],Configure::read('date_format'),true); ?>
			</td> 
		</tr>
		<?php } ?>

                <tr>
                <td colspan="10" align="center">
                    <?php
                        $queryStr = $this->General->removePaginatorSortArg($this->params->query);   
                        $this->Paginator->options(array('url' => array("?" => $queryStr)));
                    ?>
                    <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
                    <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
                    <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
                    <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
                </td>
            </tr>  

            <?php }else { ?> 
            <tr>
                <td colspan="10">
                        <b>No Record Found!</b>
                </td>
            </tr>
            <?php } ?>
	</table> 

<script>
    $(document).ready(function(){  
        $("#product_name").focus(function(){
            $(this).val('');
            $('#product_id').val('');
            $(this).autocomplete({
                source: "<?php echo $this->Html->url(array("controller" => "PurchaseOrders", "action" => "autocompleteForPO", "admin" => false, "plugin" => false)); ?>"+"/null/null/"+"<?php echo $pharmacyId; ?>"+"/1",
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
        
        $('#supplier_name').autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete", "InventorySupplier", "name", 'null', 'no', 'null', "admin" => false, "plugin" => false)); ?>",
            minLength: 1,
            select: function( event, ui ) {
                var supplier_id = ui.item.id;
                $('#supplier_id').val(ui.item.id); 
            },
            messages: {
                noResults: '',
                results: function() {}
            }
        }); 
        
        $( "#from, #to" ).datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1950',			 
            dateFormat:'<?php echo $this->General->GeneralDate(""); ?>'	
        });
    });   
</script>