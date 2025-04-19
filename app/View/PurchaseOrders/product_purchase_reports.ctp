<style type="text/css">
.alignLeft {
    text-align: left !important;
} 
.alignRight{
    text-align: right !important;
}
.table_format {
	padding: 0px !important; 
}
</style>
<div class="inner_title">
    <?php
    echo $this->element('navigation_menu', array('pageAction' => 'Store'));
    ?>
    <h3 style="margin-bottom:-6px !important;">
        <?php echo __('Product Purchase Reports', true); ?>
    </h3>
    <span>
        <?php 
        echo $this->Html->link(__('Back'), array('controller' => 'Pharmacy', 'action' => 'department_store'), array('escape' => false, 'class' => 'blueBtn'));
        ?>
    </span>
    <div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('PurchaseReceipt', array('id' => 'PurchaseReceipt','type'=>'GET','url'=>array('controller'=>'PurchaseOrders','action'=>'productPurchaseReports','admin'=>false))); ?>
<table border="0" class="table_format" cellpadding="5" cellspacing="0"
       width="100%">
    <tbody>
        <tr class="row_title">
            <td> &nbsp;</td> 
            <td><?php echo __("From :"); ?></td>
            <td><?php
                echo $this->Form->input("from", array('type' => 'text', 'class' => 'textBoxExpnd', 'id' => 'from_date', 'value'=>!empty($this->request->query['from_date'])?$this->request->query['from_date']:date('d/m/Y'), 'name' => 'from_date', 'label' => false, 'div' => false, 'error' => false));
?>
            </td> 
            <td><?php echo __("To :"); ?></td>
            <td><?php
                echo $this->Form->input("to", array('type' => 'text', 'class' => 'textBoxExpnd', 'id' => 'to_date','value'=>$this->request->query['to_date']?$this->request->query['to_date']:date('d/m/Y'), 'name' => 'to_date', 'label' => false, 'div' => false, 'error' => false));
?>
            </td> 
            <td><?php echo __("Supplier :"); ?></td>
            <td><?php
                echo $this->Form->input("supplier_name", array('type' => 'text', 'class' => 'textBoxExpnd', 'id' => 'supplier_name', 'name' => 'supplier_name', 'label' => false, 'div' => false, 'error' => false, 'value'=>$this->request->query['supplier_name'],'onBlur'=>"$(this).val()==''?$('#supplier_id').val()"));
                echo $this->Form->hidden("supplier_id", array('name' => 'supplier_id', 'value'=>$this->request->query['supplier_id'], 'id' => 'supplier_id'));
?>
            </td> 
            <td><?php echo __("Product :"); ?></td>
            <td><?php
                echo $this->Form->input("product_name", array('type' => 'text', 'class' => 'textBoxExpnd', 'id' => 'product_name', 'name' => 'product_name', 'label' => false, 'div' => false, 'error' => false, 'value'=>$this->request->query['product_name'],'onBlur'=>"$(this).val()==''?$('#product_id').val()"));
                echo $this->Form->hidden("product_id", array('name' => 'product_id', 'value'=>$this->request->query['product_id'], 'id' => 'product_id'));
?>
            </td> 
<!--            <td><?php echo __("Location :"); ?></td>
            <td><?php
                echo $this->Form->input("store_location", array('class' => 'textBoxExpnd', 'type' => 'select', 'empty' => 'All', 'options' => $storeLocation, 'id' => 'store_location', 'name' => 'store_location', 'label' => false, 'value'=>$this->request->query['store_location'], 'div' => false, 'error' => false));
?>
            </td>  -->
            <td align="right">
                <input name="" type="submit" value="Search" class="blueBtn search"/>
            </td> 
            <td><?php
                echo $this->Form->submit(__('Generate Excel'), array('style' => 'padding:0px;', 'name' => 'excel', 'id' => 'ExcelGenerate', 'div' => false, 'label' => false, 'class' => 'blueBtn'));
?>
            </td> 
            <td>
                <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'PurchaseOrders','action'=>'productPurchaseReports'),array('escape'=>false, 'title' => 'refresh'));?>
            </td>
        </tr>
    </tbody>
</table>
<?php echo $this->Form->end(); //debug($totalValue); ?>
<div class="clr ht5"></div>
<table align="right">
    <tr><td><font style="font-weight:bold;" color="red"><?php echo "Total Value: ".round($totalValue[0]['total'],2); ?></font></td></tr>
</table>    
<div class="clr ht5"></div>
<table border="0" class="table_format" width="100%">
    <thead>
        <tr class="row_title">
            <th><?php echo __("Sr.No"); ?></th>
            <th><?php echo __("Order From"); ?></th> 
            <th><?php echo __("Supplier"); ?></th>
            <th><?php echo __("GRN No"); ?></th>
            <th style="text-align:center;"><?php echo __("Date"); ?></th>
            <th><?php echo __("Product Name"); ?></th>
            <th style="text-align:center;"><?php echo __("Batch No"); ?></th>
            <th class="alignRight"><?php echo __("Quantity"); ?></th>
            <th class="alignRight"><?php echo __("Purchase Price"); ?></th>
            <th class="alignRight"><?php echo __("Value"); ?></th>
        </tr>
    </thead> 
    <tbody>
        <?php if(!empty($results)){
         foreach ($results as $key => $value) { ?>
            <tr>
                <td class="alignLeft"><?php echo ++$key; ?></td>
                <td class="alignLeft"><?php echo $value['StoreLocation']['name']; ?></td>
                <td class="alignLeft"><?php echo $value['InventorySupplier']['name']; ?></td>
                <td class="alignLeft"><?php echo $value['PurchaseOrderItem']['grn_no']; ?></td>
                <td><?php echo $this->DateFormat->formatDate2Local($value['PurchaseOrderItem']['received_date'],Configure::read('date_format'),true); ?></td>
                <td class="alignLeft"><?php echo $value['Product']['name']; ?></td>
                <td><?php echo $value['PurchaseOrderItem']['batch_number']; ?></td>
                <td class="alignRight"><?php echo $qty = $value['PurchaseOrderItem']['quantity_received']; ?></td>
                <td class="alignRight"><?php echo $price = $value['PurchaseOrderItem']['purchase_price']; ?></td>
                <td class="alignRight"><?php echo round(($qty * $price),2); ?></td>
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
    <?php }else {
            echo "<tr><td colspan='10'><b>No Record found!</b></tr>";
        }?>
    </tbody>
</table>
<script> 
    $(document).ready(function(){   
		
        $('#supplier_name').autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete", "InventorySupplier", "name", 'null', 'no', 'no', "admin" => false, "plugin" => false)); ?>",
            minLength: 1,
            select: function( event, ui ) {
                var service_provider_id = ui.item.id;
                $("#supplier_id").val(ui.item.id);
            },
            messages: {
                noResults: '',
                results: function() {}
            }
        }); 
        
        
        $('#product_name').autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "PurchaseOrders", "action" => "autocompleteForPO", "292", "null", '2', "admin" => false, "plugin" => false)); ?>",
            minLength: 1,
            select: function( event, ui ) { 
                $("#product_id").val(ui.item.id);
            },
            messages: {
                noResults: '',
                results: function() {}
            }
        }); 
 

        $(document).on("focus",'#suppliername',function(){
            $(this).autocomplete({
                source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete", "InventorySupplier", "name", 'null', 'no', 'no', "admin" => false, "plugin" => false)); ?>",
                minLength: 1,
                select: function( event, ui ) {
                    var service_provider_id = ui.item.id;
                    $("#supplierid").val(ui.item.id);
                },
                messages: {
                    noResults: '',
                    results: function() {}
                }
            });
        }); 

        $( "#to_date" ).datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1950',			 
            maxDate: new Date(),			 
            dateFormat:'<?php echo $this->General->GeneralDate(""); ?>',	
        });

        $( "#from_date" ).datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1950',
            maxDate: new Date(),
            dateFormat:'<?php echo $this->General->GeneralDate(""); ?>',	
        });
    });
</script>