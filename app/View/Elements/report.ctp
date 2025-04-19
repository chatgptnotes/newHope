
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
			echo $this->Html->image('icons/arrRight.jpg',array('title' => 'All Reports','escape' => false,'id'=>'hideAndShow')); 
		?>	
		 </div>  
	</td>
	<td>
		  	
		<div id="pharmacyMenuList"  style="padding-top:15px;padding-left:5px;display:none; " >
		    		
		<div  class="footLeft">
			
		<ul id="nav">
			<li class="liHeader"> New Patient Report
				<ul>
					<li><?php echo $this->Html->link('Total Number Of New Patients',array('controller'=>'reports','action'=>'patient_registration_report','admin'=>true),array('alt' => 'Add Item'));?></li>
				
					<li><?php echo $this->Html->link('Company Report',array('controller'=>'reports','action'=>'patient_sponsor_report','list','admin'=>true),array('alt' => 'Item List'));?></li>
				</ul>
			</li>
			
			<li class="liHeader">OR Report
				<ul> 
					<li><?php echo  $this->Html->link('Total Surgery Report',array('controller'=>'reports','action'=>'patient_ot_report','admin'=>true),array('alt' => 'Add Item Rate'));?></li>
		 		
					<li><?php echo  $this->Html->link('OR Utilization Rate',array('controller'=>'reports','action'=>'ot_utilization_rate','admin'=>true),array('alt' => 'Item Rate List'));?></li>
					<li><?php echo  $this->Html->link('OR Calendar Report',array('controller'=>'reports','action'=>'ot_list','admin'=>true),array('alt' => 'Item Rate List'));?></li>
				</ul>
			</li>
			<li class="liHeader">New Visits Report
				<ul> 
					<li><?php echo  $this->Html->link('Total New Visits Report',array('controller'=>'reports','action'=>'patient_ot_report','admin'=>true),array('alt' => 'Add Item Rate'));?></li>
		 		
					<li><?php echo  $this->Html->link('Time Taken for Check-in',array('controller'=>'reports','action'=>'ot_utilization_rate','admin'=>true),array('alt' => 'Item Rate List'));?></li>
					<li><?php echo  $this->Html->link('Patient Check-in Report',array('controller'=>'reports','action'=>'ot_list','admin'=>true),array('alt' => 'Item Rate List'));?></li>
				<li><?php echo  $this->Html->link('Total New Visit Report By Referring Physician',array('controller'=>'reports','action'=>'patient_admitted_report','admin'=>true),array('alt' => 'Item Rate List'));?></li>
				<li><?php echo  $this->Html->link('Patient Check-in Report',array('controller'=>'reports','action'=>'admission_report_by_reference_doctor','admin'=>true),array('alt' => 'Item Rate List'));?></li>
				<li><?php echo  $this->Html->link('Total New Visit Report By Patient Location',array('controller'=>'admission_report_by_patient_location','action'=>'ot_list','admin'=>true),array('alt' => 'Item Rate List'));?></li>
				</ul>
			</li>
			<li class="liHeader">Survey Reports
				<ul> 
					<li><?php echo  $this->Html->link('Staff Survey Report',array('controller'=>'reports','action'=>'staffsurvey_reports','admin'=>true),array('alt' => 'Add Item Rate'));?></li>
		 		
					<li><?php echo  $this->Html->link('Patient Survey Report',array('controller'=>'reports','action'=>'patient_survey_type','admin'=>true),array('alt' => 'Item Rate List'));?></li>
				</ul>
			</li>		
			<li class="liHeader">Hospital Associated Infections Reports
				<ul> 
					<li> <?php echo $this->Html->link('Hospital Associated Infections Cases',array('controller'=>'reports','action'=>'hospital_acquire_infections_reports','admin'=>true));?>
					</li>
				<li> <?php echo $this->Html->link('Hospital Associated Infections Rate',array('controller'=>'reports','action'=>'hai_cent', 'admin'=>true));?>
					</li>
				<li> <?php echo $this->Html->link('SSI Rate',array('controller'=>'reports','action'=>'ssirate', 'admin'=>true));?>
					</li>
				<li> <?php echo $this->Html->link('UTI Rate',array('controller'=>'reports','action'=>'utirate', 'admin'=>true));?>
					</li>
				<li> <?php echo $this->Html->link('VAP Rate',array('controller'=>'reports','action'=>'vaprate', 'admin'=>true));?>
					</li>
				<li><?php echo $this->Html->link('BSI Rate',array('controller'=>'reports','action'=>'bsirate', 'admin'=>true));?>
					</li>
				<li><?php echo $this->Html->link('Thrombophlebitis Rate',array('controller'=>'reports','action'=>'thrombophlebitisrate', 'admin'=>true));?>
					</li>
				</ul>
			</li>
			<li class="liHeader">Hospital Associated Infections Reports
				<ul> 
					<li><?php echo $this->Html->link('Total Discharge Report',array('controller'=>'reports','action'=>'patient_discharge_report','admin'=>true));?>
					</li>
			
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
	


