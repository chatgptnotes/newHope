

<style>

.liHeader{
	color: #31859c !important;
	font-size: 13px;
	line-height: 30px; 
	padding: 0 17px;
}

#nav {
    height: 22px;
    margin-left:-7px !important;
    padding: 0;
    /*width: 743px;*/
}
#nav, #nav ul {
	background: url('<?php echo $this->webroot."img/icons/new_white.png" ?>');
	border-color:#c1c1c1;
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
#nav li a:hover{background:#63b0c7;color:white !important;}
#nav ul {
/*left: -9999px;*/
position: absolute;
top: -9999px;
}

#nav li li {
background:url('<?php echo $this->webroot."img/icons/new_white.png" ?>');
float: none;
border-right:none!important;
}
#nav li li a {
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

echo $this->Html->css(array('validationEngine.jquery.css'));
echo $this->Html->css('jquery.fancybox-1.3.4.css'); 
 ?>
</head> 

<body>
	
<!-- 	<script type='text/javascript' src='js/jquery.min.js?ver=3.3'></script> -->
<!-- 	<script type='text/javascript' src='js/jquery-ui-1.8.5.custom.min.js?ver=3.3'></script> 

	<script type='text/javascript' src='js/js-image-slider.js'></script>
	<script type='text/javascript' src='js/tooltip.js'></script>
	<script type='text/javascript' src='js/jquery.isotope.min.js?ver=1.5.03'></script>
	<script type='text/javascript' src='js/jquery.custom.js?ver=1.0'></script>
	-->
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
		  	
		<div id="pharmacyMenuList"  ><!--style="padding-top:15px;padding-left:5px;display:none; " -->
		    		
		<div  class="footLeft">
			
		<ul id="nav">
			<li class="liHeader"> Items
				<ul><?php if($this->Session->read('website.instance')!='vadodara'){?>
					<li><?php echo $this->Html->link('Add Item',array('controller'=>'Pharmacy','action'=>'add_item','inventory'=>true),array('alt' => 'Add Item'));?></li>
					<?php }else{}?>
					<li><?php echo $this->Html->link('Item List',array('controller'=>'Pharmacy','action'=>'item_list','list','inventory'=>true),array('alt' => 'Item List'));?></li>
				</ul>
			</li>
			
			<li class="liHeader"> Item Batches
				<ul> 
					<li><?php echo  $this->Html->link('Add Item Batches',array('controller'=>'Pharmacy','action'=>'item_rate_master','inventory'=>true),array('alt' => 'Add Item Rate'));?></li>
		 		
					<li><?php echo  $this->Html->link('Item Batch List',array('controller'=>'Pharmacy','action'=>'view_item_rate','inventory'=>false),array('alt' => 'Item Rate List'));?></li>
				</ul>
			</li>
			
			<li class="liHeader"> Requisition
				<ul>
					<li><?php echo  $this->Html->link('Store Requisition',array('controller'=>'InventoryCategories','action'=>'store_requisition_list','inventory'=>false),array('alt' => 'Store Requisition List'));?></li>
					<li><?php echo  $this->Html->link('Add Requisition ',array('controller'=>'InventoryCategories','action'=>'store_requisition','inventory'=>false),array('alt' => 'Add Requisition'));?></li>
					<li><?php echo  $this->Html->link('Received Requisition',array('controller'=>'InventoryCategories','action'=>'store_inbox_requistion_list','inventory'=>false),array('alt' => 'Recieved Requisition'));?></li>
		 			<li><?php echo  $this->Html->link('Stock Transfer',array('controller'=>'InventoryCategories','action'=>'stock_transfer','inventory'=>false),array('alt' => 'Stock Transfer'));?></li>
		 		</ul>
			</li>
			
			<li class="liHeader"> Sales
				<ul>
					<li><?php echo $this->Html->link('Patients List',array('controller'=>'Patients','action'=>'get_patient_prescription','inventory'=>false),array('alt' => 'Patients List'))?></li>
					<li><?php echo $this->Html->link('Sales Bill',array('controller'=>'Pharmacy','action'=>'sales_bill','inventory'=>true),array('alt' => 'Sales Bill'));?></li>
					<li><?php echo  $this->Html->link('View Sales',array('controller'=>'Pharmacy','action' => 'pharmacy_details','sales','inventory'=>true),array('alt' => 'View Sales'));?></li>
					<li><?php echo $this->Html->link('Sales Return',array('controller'=>'Pharmacy','action' => 'sales_return','inventory'=>true),array('alt' => 'Sales Return'));?></li>
					<li><?php echo  $this->Html->link('Sales View Return',array('controller'=>'Pharmacy','action'=>'pharmacy_details','sales_return','inventory'=>true),array('alt' => 'View return'));?></li> 
					<?php if($this->Session->read('website.instance')!='kanpur'){?>
					<li><?php echo  $this->Html->link('Direct Sales Bill',array('controller'=>'Pharmacy','action' => 'other_sales_bill','inventory'=>true),array('alt' => 'Direct Sales Bill'));?></li>
					<li><?php  echo  $this->Html->link('View Direct Sales',array('controller'=>'Pharmacy','action' => 'get_other_pharmacy_details','sales','inventory'=>true),array('alt' => 'Direct Sales'));?></li>
					<?php }?>
				</ul>
			</li>
			<?php if($this->Session->read('website.instance')=='kanpur'){?>
			<li class="liHeader"> Direct Sales
				<ul>
					<li><?php echo  $this->Html->link('Direct Sales Bill',array('controller'=>'Pharmacy','action' => 'other_sales_bill','inventory'=>true),array('alt' => 'Direct Sales Bill'));?></li>
					<li><?php  echo  $this->Html->link('View Direct Sales',array('controller'=>'Pharmacy','action' => 'get_other_pharmacy_details','sales','inventory'=>true),array('alt' => 'Direct Sales'));?></li>
					<li><?php echo $this->Html->link('Direct Sales Return',array('controller'=>'Pharmacy','action' => 'direct_sales_return','inventory'=>true),array('alt' => 'Return'));?></li>
					<li><?php echo  $this->Html->link('Direct View Return',array('controller'=>'Pharmacy','action'=>'pharmacy_details','direct_return','inventory'=>true),array('alt' => 'View return'));?></li>
				</ul>
			</li>
			<?php }?>
			<!--<li class="liHeader"> Sales Return
				<ul>
					<li><?php echo $this->Html->link('Sales Return',array('controller'=>'Pharmacy','action' => 'sales_return','inventory'=>true),array('alt' => 'Sales Return'));?></li>
					<li><?php echo  $this->Html->link('View Return',array('controller'=>'Pharmacy','action'=>'pharmacy_details','sales_return','inventory'=>true),array('alt' => 'View return'));?></li>
				</ul>
			</li>-->
			
			<li class="liHeader">Nurse Procurements
				<ul>
					<li><?php echo $this->Html->link('Nurse Prescriptions',array('controller'=>'Nursings','action' => 'add_prescription','inventory'=>false),array('alt' => 'Nurse Procurement'));?> </li>
					<li><?php echo $this->Html->link('Treatment Sheet',array('controller'=>'Pharmacy','action' => 'treatmentSheet','inventory'=>false),array('alt' => 'Treatment Sheet'));?> </li>
				</ul>
			</li>
			
			<li class="liHeader"> Duplicate Sales
				<ul>
					<li><?php echo  $this->Html->link('Duplicate Sales Bill',array('controller'=>'Pharmacy','action'=>'duplicate_sales_bill','inventory'=>true),array('alt' => 'Duplicate Sales Bill'));?></li>
					<li><?php echo  $this->Html->link('Duplicate Sales View',array('controller'=>'Pharmacy','action'=>'duplicate_sales_details','inventory'=>true),array('alt' => 'Duplicate Sales View'));?></li>
				</ul>
				
			</li>
			</div>
		</div>
	</td>
	</tr>
</table>

	
<script>
$(function(){		

	$("#itemList").click(function(event){
       	
       	window.open('<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "add_item",'inventory'=>true)); ?>');
       
    });
    
    $("#hideAndShow").click(function(event){
    	
	   $('#pharmacyMenuList').toggle(); 
	       
	    });
});


</script>	
	


