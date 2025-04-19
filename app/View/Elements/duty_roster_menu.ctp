

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
	padding: 0 0 6px;
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
		  	
		<div  class="footLeft">
			
		<ul id="nav">
		<!-- <li class="liHeader"> Duty Roster
				<ul>
					<li><?php echo $this->Html->link('Duty Roster',array('controller'=>'time_slots','action'=>'index'),array('alt' => 'Duty Roster'));?></li>
				</ul>
			</li>
			<li class="liHeader"> Add Shifts
				<ul>
					<li><?php echo $this->Html->link('Add Shifts',array('controller'=>'time_slots','action'=>'add_shifts'),array('alt' => 'Add Shifts'));?></li>
				</ul>
			</li>
			<li class="liHeader"> Monthly Roster
				<ul>
					<li><?php echo $this->Html->link('Monthly Roster',array('controller'=>'time_slots','action'=>'addDutyRoster'),array('alt' => 'Monthly Roster'));?></li>
				</ul>
			</li>
			<li class="liHeader"> Duty Plan
				<ul>
					<li><?php echo $this->Html->link('Duty Plan',array('controller'=>'time_slots','action'=>'dutyPlan'),array('alt' => 'Duty Plan'));?></li>
				</ul>
			</li> -->
			<li class="liHeader"> Shift Master
				<ul>
					<!--<li><?php echo $this->Html->link('Add Shifts',array('controller'=>'time_slots','action'=>'add_shifts'),array('alt' => 'Add Shifts'));?></li>
					--><li><?php echo $this->Html->link('Add Shifts',array('controller'=>'time_slots','action'=>'shiftsMaster'),array('alt' => 'Monthly Roster Chart'));?></li>
				</ul>
			</li>
			<li class="liHeader"> Monthly Roster Chart
				<ul>
					<li><?php echo $this->Html->link('Monthly Roster Chart',array('controller'=>'time_slots','action'=>'monthlyRosterChart'),array('alt' => 'Monthly Roster Chart'));?></li>
				</ul>
			</li>
			
			</div>
		</div>
	</td>
	</tr>
</table>



	
<script>
$(function(){		

	
});


</script>	
	


