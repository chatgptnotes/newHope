 <?php
/*
 *  for all menus
 *  Swapnil
 *  04.12.2015
 */
?>
<style>

    .liHeader{
        color: #31859c !important;
        font-size: 13px;
        line-height: 28px; 
        padding: 0 17px;
    }

    #nav {
        height: 22px;
        margin-left:-7px !important;
        padding: 0;
        /*width: 743px;*/
    }
    #nav, #nav ul {
        /*background: url('<?php echo $this->webroot . "img/icons/new_white.png" ?>');*/
         
        background-color: #4d90fe !important;
        background-image: -moz-linear-gradient(center top , #4d90fe, #4787ed) !important;
        border: 1px solid #3079ed !important;
        color: white !important;

        /*border-color:#c1c1c1;*/
        border-style: solid;
        border-width: 1px 2px 2px 1px;
        font: 15px verdana,sans-serif;
        list-style: none outside none;
        margin: 0;
        padding: 0 0 5px;
        position: relative;
        z-index: 200;
    }

    #nav li {
        float: left;
        border-right: 1px solid #c1c1c1;
        
        color: white !important;
        font-size:11px !important;
        font-weight:bold !important;
    }



    #nav li a {
        color: #000;
        display: block;
        float: left;
        font-size:13px;
        /* height: 25px;*/
        line-height:30px;
        height:30px;
        margin: 0px;
        padding:0px 17px;
        text-decoration: none;
        white-space: nowrap;
    }
    #nav li a:hover{
        background:#63b0c7;color:white !important;
    }
    #nav ul {
        /*left: -9999px;*/
        position: absolute;
        top: -9999px;
    }

    #nav li li {
        background-color: #4d90fe !important;
        background-image: -moz-linear-gradient(center top , #4d90fe, #4787ed) !important;
        border: 1px solid #3079ed !important;  
        
        /*background:url('<?php echo $this->webroot . "img/icons/new_white.png" ?>');*/
        float: none;
        /*border-right:none!important;*/
    }
    #nav li li a {
        color: white !important;
        font-size:11px !important;
        font-weight:bold !important;
        
        float: none;
        height:25px;
        line-height:30px;
    }

    #nav ul {
        padding: 0 !important;
    }

    #nav li:hover {

        position: relative;
        z-index: 300;

    }

    #nav li:hover ul {left:0; top:28px;}
    /* another hack for IE5.5 and IE6 */
    * html #nav li:hover ul {left:10px;}
    /* it could have been this simple if all browsers understood */
    /* show next level */
    #nav li:hover li:hover > ul {left:-15px; margin-left:100%; top:-1px; }
    /* keep further levels hidden */
    #nav li:hover > ul ul {position:absolute; left:-9999px; top:-9999px; width:auto;}
    /* show path followed */
    #nav li:hover > a { color:#fff ;}
    /* but IE5.x and IE6 need this lot to style the flyouts and path followed */
    /* show next level */
    #nav li:hover li:hover ul,
    #nav li:hover li:hover li:hover ul,
    #nav li:hover li:hover li:hover li:hover ul,
    #nav li:hover li:hover li:hover li:hover li:hover ul
    {left:-15px; margin-left:100%; top:-1px; }


</style>
<?php 

    $links = array( 
    
    //for pharmacy icons
     'Pharmacy' => array(
         'Items'=>array(
            array('label' => 'Add Item', 'url' => array('controller' => 'Pharmacy', 'action' => 'add_item', 'inventory' => true, 'admin' => false)),
             array('label' => 'Item List', 'url' => array('controller' => 'Pharmacy', 'action' => 'item_list', 'inventory' => true, 'admin' => false)),
                array('label' => 'Current Stock', 'url' => array('controller' => 'Store', 'action' => 'currentStock', 'admin' => false)), 
         ),
         'Item Batches'=>array(     
             array('label' => 'Add Item Batches', 'url' => array('controller' => 'Pharmacy', 'action' => 'item_rate_master', 'inventory' => true, 'admin' => false)),
             array('label' => 'Item Batch List', 'url' => array('controller' => 'Pharmacy', 'action' => 'view_item_rate', 'inventory' => false, 'admin' => false))
         ),
         'Requisition'=>array(
             array('label' => 'Store Requisition', 'url' => array('controller' => 'InventoryCategories', 'action' => 'store_requisition_list', 'inventory' => false, 'admin' => false)),
             array('label' => 'Add Requisition', 'url' => array('controller' => 'InventoryCategories', 'action' => 'store_requisition', 'inventory' => false, 'admin' => false)),
             array('label' => 'Received Requisition', 'url' => array('controller' => 'InventoryCategories', 'action' => 'store_inbox_requistion_list', 'inventory' => false, 'admin' => false)),
             array('label' => 'Stock Transfer', 'url' => array('controller' => 'InventoryCategories', 'action' => 'stock_transfer', 'inventory' => false, 'admin' => false))
         ),
         'Sales'=>array( 
             array('label' => 'Patients List', 'url' => array('controller' => 'Patients', 'action' => 'get_patient_prescription', 'inventory' => false, 'admin' => false)),
             array('label' => 'Sales Bill', 'url' => array('controller' => 'Pharmacy', 'action' => 'sales_bill', 'inventory' => true, 'admin' => false)),
             array('label' => 'View Sales', 'url' => array('controller' => 'Pharmacy', 'action' => 'pharmacy_details','sales', 'inventory' => true, 'admin' => false)),
             array('label' => 'Sales Return', 'url' => array('controller' => 'Pharmacy', 'action' => 'sales_return', 'inventory' => true, 'admin' => false)),
             array('label' => 'Direct Sales', 'url' => array('controller' => 'Pharmacy', 'action' => 'other_sales_bill', 'inventory' => true, 'admin' => false)),
             array('label' => 'Direct View Sales', 'url' => array('controller' => 'Pharmacy', 'action' => 'get_other_pharmacy_details','sales', 'inventory' => true, 'admin' => false)),
             array('label' => 'Direct Sales Return', 'url' => array('controller' => 'Pharmacy', 'action' => 'direct_sales_return', 'inventory' => true, 'admin' => false)),
             array('label' => 'Direct View Return', 'url' => array('controller' => 'Pharmacy', 'action' => 'pharmacy_details','direct_return', 'inventory' => true, 'admin' => false))
         ),
         'Nurse Procurements'=>array( 
            array('label' => 'Nurse Prescriptions', 'url' => array('controller' => 'Nursings', 'action' => 'add_prescription', 'inventory' => false, 'admin' => false)),
            array('label' => 'Treatment Sheet', 'url' => array('controller' => 'Pharmacy', 'action' => 'treatmentSheet', 'inventory' => false, 'admin' => false))
         ),
         'Duplicate Sales'=>array( 
            array('label' => 'Duplicate Sales Bill', 'url' => array('controller' => 'Pharmacy', 'action' => 'duplicate_sales_bill', 'inventory' => true, 'admin' => false)),
            array('label' => 'Duplicate Sales View', 'url' => array('controller' => 'Pharmacy', 'action' => 'duplicate_sales_details', 'inventory' => true, 'admin' => false)),     
         ),
         'Central Store'=>array( 
            array('label' => 'Add Order', 'url' => array('controller' => 'PurchaseOrders', 'action' => 'add_order',  'admin' => false)),
             array('label' => 'Orders list', 'url' => array('controller' => 'PurchaseOrders', 'action' => 'purchase_order_list', 'admin' => false)),
             array('label' => 'Goods Received Note', 'url' => array('controller' => 'PurchaseOrders', 'action' => 'purchase_receipt', 'admin' => false)), 
             array('label' => 'Stock Adjustment', 'url' => array('controller' => 'Store', 'action' => 'stockAdjustment', 'admin' => false)),  
             array('label' => 'Stock Register', 'url' => array('controller' => 'Reports', 'action' => 'stock_register', 'admin' => false)) 
         )
    ),
    
    //for store Icons
    'Store' => array(
        'Items'=>array(
            array('label' => 'Item List', 'url' => array('controller' => 'Store', 'action' => 'index', 'admin' => false))  
         ),
        'Stock'=>array(
            array('label' => 'Stock Adjustment', 'url' => array('controller' => 'Store', 'action' => 'stockAdjustment', 'admin' => false)),
            array('label' => 'Stock Ledger', 'url' => array('controller' => 'Store', 'action' => 'stockLedger', 'admin' => false)),
            array('label' => 'Department Stock List', 'url' => array('controller' => 'Store', 'action' => 'departmental_stock', 'admin' => false)),
            array('label' => 'Location Consumption', 'url' => array('controller' => 'Store', 'action' => 'productConsumption', 'admin' => false))
         ),
         'Purchase Orders'=>array(     
             array('label' => 'Add Order', 'url' => array('controller' => 'PurchaseOrders', 'action' => 'add_order',  'admin' => false)),
             array('label' => 'Orders list', 'url' => array('controller' => 'PurchaseOrders', 'action' => 'purchase_order_list', 'admin' => false)),
             array('label' => 'Goods Received Note', 'url' => array('controller' => 'PurchaseOrders', 'action' => 'purchase_receipt', 'admin' => false)),
             array('label' => 'Product Purchase Report', 'url' => array('controller' => 'PurchaseOrders', 'action' => 'productPurchaseReports', 'admin' => false)),
             array('label' => 'Inventory Tracking', 'url' => array('controller' => 'Store', 'action' => 'inventoryTracking', 'admin' => false))
         ),
        'Requisition'=>array(
             array('label' => 'Store Requisition', 'url' => array('controller' => 'InventoryCategories', 'action' => 'store_requisition_list', 'inventory' => false, 'admin' => false)),
             array('label' => 'Add Requisition', 'url' => array('controller' => 'InventoryCategories', 'action' => 'store_requisition', 'inventory' => false, 'admin' => false)),
             array('label' => 'Received Requisition', 'url' => array('controller' => 'InventoryCategories', 'action' => 'store_inbox_requistion_list', 'inventory' => false, 'admin' => false)),
             array('label' => 'Stock Transfer', 'url' => array('controller' => 'InventoryCategories', 'action' => 'stock_transfer', 'inventory' => false, 'admin' => false))
         ),
        'Supplier'=>array(
            array('label' => 'Supplier', 'url' => array('controller' => 'Store', 'action' => 'supplierList', 'admin' => false)),
            array('label' => 'Manufacturer', 'url' => array('controller' => 'Store', 'action' => 'manufacturingCompany', 'admin' => false)) 
         ), 
        'Reports'=>array(
            array('label' => 'Current Stock', 'url' => array('controller' => 'Reports', 'action' => 'current_stock', 'admin' => false)),
            array('label' => 'Stock Register', 'url' => array('controller' => 'Reports', 'action' => 'stock_register', 'admin' => false)),
            /*array('label' => 'Daily Sales Collection', 'url' => array('controller' => 'Reports', 'action' => 'daily_sales_collection', 'admin' => false)),
            array('label' => 'Department Request', 'url' => array('controller' => 'Reports', 'action' => 'department_request', 'admin' => false)),
            array('label' => 'Indent Cost Report', 'url' => array('controller' => 'Reports', 'action' => 'indent_cost_report', 'admin' => false)),
            array('label' => 'Drug Sales Report', 'url' => array('controller' => 'Reports', 'action' => 'drug_sale_report', 'admin' => false)),
            array('label' => 'Purchase Analysis', 'url' => array('controller' => 'Reports', 'action' => 'purchase_analysis', 'admin' => false)),
            array('label' => 'Expiry Date Report', 'url' => array('controller' => 'Reports', 'action' => 'expiry_date', 'admin' => false)),
            array('label' => 'Expensive Report', 'url' => array('controller' => 'Reports', 'action' => 'expensive_product_report', 'admin' => false)),*/
            array('label' => 'Non-Movable Products', 'url' => array('controller' => 'Reports', 'action' => 'non_movable_stock', 'admin' => false)),
            array('label' => 'Opening Closing Stock', 'url' => array('controller' => 'Reports', 'action' => 'openingClosingStock', 'admin' => false)),
         ),
        'Pharmacy'=>array(
            array('label' => 'Item List', 'url' => array('controller' => 'Pharmacy', 'action' => 'item_list', 'inventory' => true, 'admin' => false)),
            array('label' => 'Sales Bill', 'url' => array('controller' => 'Pharmacy', 'action' => 'sales_bill', 'inventory' => true, 'admin' => false)),
             array('label' => 'View Sales', 'url' => array('controller' => 'Pharmacy', 'action' => 'pharmacy_details','sales', 'inventory' => true, 'admin' => false)),
             array('label' => 'Sales Return', 'url' => array('controller' => 'Pharmacy', 'action' => 'sales_return', 'inventory' => true, 'admin' => false)),
             array('label' => 'Pharmacy Report', 'url' => array('controller' => 'Pharmacy', 'action' => 'pharmacy_report', 'purchase','inventory' => true, 'admin' => false)),
         ), 
    ),
		'HR' => array(
				'Employee'=>array(
						array('label' => 'Employee Directory', 'url' => array('controller' => 'users', 'action' => 'index', 'admin' => true)),
				),
				'PayRoll'=>array(
						array('label' => 'Dashboard', 'url' => array('controller' => 'HR', 'action' => 'index', 'admin' => false)),
						array('label' => 'Payroll Revision', 'url' => array('controller' => 'HR', 'action' => 'payrollRevision', 'admin' => false)),
						array('label' => 'Doctor Share', 'url' => array('controller' => 'HR', 'action' => 'doctorShare', 'admin' => false)),
				),
				'Leaves'=>array(
						array('label' => 'DashBoard', 'url' => array('controller' => 'Leaves', 'action' => 'index', 'admin' => false)),
						array('label' => 'Send Leave Approval', 'url' => array('controller' => 'Leaves', 'action' => 'requestLeaveApproval', 'admin' => false)),
						array('label' => 'Approve Leave Approval', 'url' => array('controller' => 'Leaves', 'action' => 'leaveRequestList', 'admin' => false)),
						array('label' => 'Leave Configuration', 'url' => array('controller' => 'Leaves', 'action' => 'leaveConfigure', 'admin' => false)),
						array('label' => 'Holiday Configuration', 'url' => array('controller' => 'Configurations','action' => 'holiday', 'admin' => false)),
				),
				'Attendance'=>array(
						array('label' => 'Manual Attendance', 'url' => array('controller' => 'TimeSlots', 'action' => 'addAttendance', 'admin' => false)),
						array('label' => 'User Attendance', 'url' => array('controller' => 'TimeSlots', 'action' => 'viewAttendance', 'admin' => false)),
				),
			)
);
?>

<body> 
    <table style="margin: 0px;">
        <tr>
            <td valign="top">
                <div style=" padding-top:15px;">
                    <?php
                        //echo $this->Html->image('icons/arrRight.jpg',array('title' => 'Pharmacy Menu','escape' => false,'id'=>'hideAndShow')); 
                    ?>	
                </div>  
            </td>
            <td> 
                <div id="pharmacyMenuList"> 
                    <div  class="footLeft">
                         <ul id="nav">
                            <?php  
                                foreach($links[$pageAction] as $key => $val){
                                    echo "<li class='liHeader'>".$key."<ul>";  
                                    foreach($val as $skey => $sval){  
                                        echo "<li>".$this->Html->link($sval['label'],$sval['url'],array('escape'=>false))."</li>";   
                                    } 
                                    echo "</ul></li>";
                                }
                            ?>
                         </ul> 
                    </div>
                </div>
            </td>
        </tr>
    </table>
 
    <script>
        $(function(){ 
            $("#itemList").click(function(event){ 
                window.open('<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "add_item", 'inventory' => true)); ?>'); 
            });
    
            $("#hideAndShow").click(function(event){ 
                $('#pharmacyMenuList').toggle();  
            });
        });


    </script>	 