

<style>

#nav {
    height: 35px;
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
line-height:36px;
height:40px;
margin: 0px;
padding:0px 17px;
text-decoration: none;
white-space: nowrap;
}
#nav li a:hover{background:#63b0c7;color:white !important;}
#nav ul {
left: -9999px;
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
height:40px;
line-height:36px;
}

#nav ul {
    padding: 0 !important;
}

#nav li:hover {

position: relative;
z-index: 300;

}

#nav li:hover ul {left:0; top:40px;}
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
	
	
    	
<div style="float:left; padding-top:15px;" >
    		
<div style="width:587px;" class="footLeft">
	
<ul id="nav">
	<li><?php echo  $this->Html->link('Item List',array('controller'=>'Pharmacy','action'=>'item_list','list','inventory'=>true),array('alt' => 'Item List'));?>
		<ul>
			<li><?php echo  $this->Html->link('Add Item',array('controller'=>'Pharmacy','action'=>'add_item','inventory'=>true),array('alt' => 'Add Item'));?></li>
		</ul>
	 </li>
	
	<li><?php echo  $this->Html->link('Item Rate List',array('controller'=>'Pharmacy','action'=>'view_item_rate','inventory'=>false),array('alt' => 'Item Rate List'));?>
 		<ul> 
			<li><?php echo  $this->Html->link('Add Item Rate',array('controller'=>'Pharmacy','action'=>'item_rate_master','inventory'=>true),array('alt' => 'Add Item Rate'));?></li>
 		</ul>
	</li>
	<li><?php echo  $this->Html->link('Sales Bill',array('controller'=>'Pharmacy','action'=>'sales_bill','inventory'=>true),array('alt' => 'Sales Bill'));?>
		<ul>
			<li><?php echo $this->Html->link('Sales Patients',array('controller'=>'Patients','action'=>'get_patient_prescription','inventory'=>false),array('alt' => 'Sales Patients'))?></li>
			<li><?php echo  $this->Html->link('view Sales',array('controller'=>'Pharmacy','action' => 'pharmacy_details','sales','inventory'=>true),array('alt' => 'View Sales'));?></li>
			<li><?php echo  $this->Html->link('Direct Sales',array('controller'=>'Pharmacy','action' => 'other_sales_bill','inventory'=>true),array('alt' => 'Direct Sales'));?></li>
		</ul>
	</li>
	
	<li><?php echo $this->Html->link('Sales Return',array('controller'=>'Pharmacy','action' => 'sales_return','inventory'=>true),array('alt' => 'Sales Return'));?>
		<ul>
			<li><?php echo  $this->Html->link('View Return',array('controller'=>'Pharmacy','action'=>'pharmacy_details','sales_return','inventory'=>true),array('alt' => 'View return'));?></li>
		</ul>
	</li>
	
	
	<li><?php echo $this->Html->link('Nurse Procurement',array('controller'=>'Nursings','action' => 'add_prescription','inventory'=>false),array('alt' => 'Sales Return'));?> </li>
		
	
	</div>
</div>




	
<script>
$(function(){		

	$("#itemList").click(function(event){
       	
       	window.open('<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "add_item",'inventory'=>true)); ?>');
       
    });
});
</script>	
	


