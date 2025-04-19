<?php  echo $this->Html->script(array('jquery.treeview','jquery.fancybox-1.3.4','jquery.blockUI','jquery.tooltipster.min.js','jquery.contextMenu'));
echo $this->Html->css(array('jquery.treeview.css','jquery.fancybox-1.3.4.css','tooltipster.css','jquery.contextMenu'));
?>
<style>
.footer,.push {
	height: 4em;
	margin-top: 40px;
}

.treeview,.treeview ul {
	width: 184px;
}

.context-menu-item {
	background-color: #FFF;
	color: #aeaeae;
}

.tooltipster-default {
	color: #aeaeae;
}

.row20px tr td {
	border-bottom: 1px solid #4C5E64;
	border-left-color: #4C5E64 !important;
	border-left-width: 0 !important;
	border-right: 1px solid #4C5E64;
	border-style: solid;
	border-top-color: #4C5E64 !important;
	border-top-width: 0 !important;
	color: none;
	font-size: 13px;
}

.sub-cat label {
	color: #000;
}

label {
	text-align: left;
	width: auto;
	color: #000000;
	cursor: pointer;
}

.container {
	color: #000000;
	height: auto;
	padding: 2px;
	width: 50px;
}

.tree-menu {
	background: #31393B;
	color: #aeaeae;
	min-width: 109%;
}

.obj {
	width: 96%;
	min-height: 266px;
	max-height: 615px;
	background: #ffffff;
	padding-left: 1px;
}

.sub-cat {
	cursor: pointer;
	color: #DDDDDD;
	text-decoration: underline;
	padding-left: 10px;
	padding-bottom: 8px;
}

.gray-container {
	background: #cccccc;
	color: #000;
	text-align: center;
}

.changeSetting {
	opacity: 0;
	font-color: #000;
	cursor: pointer;
}

.medTable {
	min-width: 8%;
}

#excelArea {
	max-height: 696px;
	min-height: 266px;
	overflow: hidden;
	padding-left: 23px;
	width: 1400px;
}

#AdminisMeds {
	/*display: none;*/
	cursor: pointer;
	
	text-decoration: underline;
	padding-left: 10px;
	padding-bottom: 8px;
}
.patientHub .patientInfo .heading {
    float: left;
    width: 174px !important;
}
@media only screen and (min-width:1920px) {
	.responce {
		width: 1810px;
	}
}

@media only screen and (min-width:1280px) {
	.responce {
		width: 1180px;
	}
}
.headingLabel{
	margin-left: 317px;
    width: 50%;
    border-radius: 5px;
    background:#DBEAF9;
}
</style>
<div id="flashMessageRoot" class="message" style="display: none">
	<?php echo __("Sucessfully saved");?>
</div>

<div class="clr"></div>
<div style="min-height: 320px;">

<!-- Html for search -->
<?php echo $this->Form->create('EmarDashboard', array('url' => array('controller' => 'PatientsTrackReports', 'action' => 'emarDashboard',$patient_id),'id'=>'searchForm'));?>
		<table style="width: 50%;"  class="headingLabel">
				<tr>
					<td colspan='4' style="text-align: center;"><b> Search Medication Administer By Dates.</b></td>
				</tr>
				<tr>
					<td colspan='2' width="49%" style="text-align: right;padding-left: 250px;"><input id="dateFrom" class="textBoxExpnd" type="text" placeholder="Date From" autocomplete="off" name="dateFrom"></td>
					<td colspan='2' width="50%">
						<input type="submit" class ="blueBtn" name="Submit" value="Submit" />&nbsp;&nbsp;
						<input type="button" class ="blueBtn" name="Reset" value="Reset" id='reset' />
					</td>
				</tr>
				<tr>
					<td colspan='4' style="text-align: center;">&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align: -moz-center;"><b>Overdue medications</b><div style="width:10px;height:10px;border:1px solid #FF0000;background:#FF0000"></div></td>
					<td style="text-align: -moz-center;"><b>Medications to be administered</b><div style="width:10px;height:10px;border:1px solid #00FF7F;background:#00FF7F"></div></td>
					<td style="text-align: -moz-center;"><b>Medications has been administered</b><div style="width:10px;height:10px;border:1px solid #708090;background:#008000"></div></td>
					<td style="text-align: -moz-center;"><b>Upcoming medications</b><div style="width:10px;height:10px;border:1px solid 	#F4A460;background:#F4A460"></div></td>

				</tr>
		</table>
		<p>
<div style="background-color:#DDEBF9;padding:2px;">
<p>
<span><label><b>Patient Name:</b><?php echo $admission_type['Patient']['lookup_name'];?></label></span>&nbsp;
<span><label><b>Date of Birth:</b><?php echo $this->DateFormat->formatDate2Local($admission_type['Person']['dob'],Configure::read('date_format_us'));;?></label></span>
<span><label><b>Gender:</b><?php echo ucfirst($admission_type['Person']['sex']);?></label></span>&nbsp;
<span><label><b>Patient UID:</b><?php echo $admission_type['Person']['patient_uid'];?></label></span>&nbsp;
<span><label><b>Patient Admission:</b><?php echo $admission_type['Patient']['admission_id'];?></label></span><br/>
</p>
<p>
</div>
<?php echo $this->Form->end();?>
<!-- Html for search -->

<?php $timeData  = $this->data['0']['EmarDashboardSetting'];?>
	<table width="96%" cellspacing="0" cellpadding="0" border="0">
		<tr style="background: #394145">
			<td width="3%"><label class="sub-cat"><?php echo $this->Html->image('icons/refresh-icon.png',array('alt'=>"Refresh Window",'title'=>"Refresh Window"));?>
			</label></td>
			<td width=""><label id="AdminisMeds" style="color: #dddddd !important;"><strong><?php echo __("Medication Administer"); ?>
				</strong> </label></td>
		</tr>
	</table>
	<table width="96%"  cellspacing="0" cellpadding="0" border="0" id="treeDivArea">
	<tbody>
	 <tr>
	  <td valign="top" class="tree-menu" style="min-height: 300px; float: left;">
		<table>
		 <tr>
		  <td>
			<ul id="browser" class="filetree treeview-famfamfam">
				<li><span class="sub-cat" id="time-view" style="font-weight: bold;"><?php echo __("Time View"); ?> </span>
				 <ul>
					<li style="background-color:#FFD700;color:black"><b><?php echo $this->Html->link('View Scheduled Medication','javascript:void(0)',array('id'=>'scheduledMedNew','class'=>'ViewOne')); ?></b></li>
					<li style="background-color:#20B2AA;color:black"><b><?php echo $this->Html->link('View PRN Medication','javascript:void(0)',array('id'=>'PnrMed','class'=>'ViewOne')); ?><br/></b></li>
					<li style="background-color:#87CEFA;color:black"><b><?php echo $this->Html->link('View Continuous Infusion Medication','javascript:void(0)',array('id'=>'ContMed','class'=>'ViewOne')); ?></b></li>
					<li style="background-color:#FF69B4;color:black"><b><?php echo $this->Html->link('View All Medication','javascript:void(0)',array('id'=>'tree','class'=>'ViewOne')); ?></b></li>
					
				 </ul>
				</li>
			</ul>
		   </td>
		 </tr>
		</table>
	   </td>
	   <td valign="top" style="width: 86%; overflow: hidden;">
	   	<div id="excelArea"><!-- Excel layout --></div>
	   </td>
	 </tr>
	</tbody>
</table>
</div>
<script>

var lastClickedElement = 'time-view';											
	$(document).ready(function(){
		$("#browser").treeview({
			toggle: function() { //alert('tre');
				console.log("%s was toggled.", $(this).find(">span").text());
			},
			animated:"slow",
			collapsed: true,
			unique: true,
			
		});
		$('ul#browser li:first ul:first').show();
		// calls function on ready
		viewExcel(lastClickedElement);
		$('.sub-cat').click(function(){if($(this).attr('id') !== undefined)lastClickedElement= $(this).attr('id'); viewExcel(lastClickedElement); })
		
		function viewExcel(lastClickedElement){
			$.ajax({
				 beforeSend: function(){
					  loading(); // loading screen
				 },
			     url: "<?php echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "dashboardExcelView",$patient_id,'dateTime'=>$fromDateTime, "admin" => false)); ?>"+"/"+lastClickedElement,//+"/"+excelTdCount,
			     context: document.body,
			     success: function(data){ 
			    	 onCompleteRequest(); //remove loading sreen
			    	 $("#excelArea").html(data).fadeIn('slow');
			    }
			});
		};

		$(".changeSetting").click(function(){ 
		
			var id = $(this).attr('id');
			if($(this).is(':checked')){
				value = 1;
				if($("."+id).attr('style') == 'background-color:#709E27'|| $("."+id).attr('style') == 'background-color: rgb(112, 158, 39);' ){
					$("."+id).css('background-color', '#FFFFFF');
				}
				if($("."+id).attr('style') == 'background-color:#106A93' || $("."+id).attr('style') == 'background-color: rgb(16, 106, 147);'){
					$("."+id).css('background-color', '#DDDDDD');
				}
				if($("."+id).attr('style') == 'background-color:#FFFFFF' || $("."+id).attr('style') == 'background-color: rgb(255, 255, 255);'){
					$("."+id).css('background-color', '#709E27');
				}
				if($("."+id).attr('style') == 'background-color:#DDDDDD' || $("."+id).attr('style') == 'background-color: rgb(221, 221, 221);'){
					$("."+id).css('background-color', '#106A93');
				}
			}else{
				value = 0;
				if($("."+id).attr('style') == 'background-color:#FFFFFF' || $("."+id).attr('style') == 'background-color: rgb(255, 255, 255);'){
					$("."+id).css('background-color', '#709E27');
				}
				if($("."+id).attr('style') == 'background-color:#DDDDDD' || $("."+id).attr('style') == 'background-color: rgb(221, 221, 221);'){
					$("."+id).css('background-color', '#106A93');
				}
				if($("."+id).attr('style') == 'background-color:#709E27'|| $("."+id).attr('style') == 'background-color: rgb(112, 158, 39);' ){
					$("."+id).css('background-color', '#FFFFFF');
				}
				if($("."+id).attr('style') == 'background-color:#106A93' || $("."+id).attr('style') == 'background-color: rgb(16, 106, 147);'){
					$("."+id).css('background-color', '#DDDDDD');
				}
			}
		
			$.ajax({
				  beforeSend: function(){
					  loading(); // loading screen
				  },
			      url: "<?php echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "userViewSetting", "admin" => false)); ?>"+"/"+id+"/"+value,
			      context: document.body,
			      success: function(data){ 
				      $.ajax({
			    		  type: 'POST',
						 url: "<?php echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "dashboardExcelView",$patient_id, "admin" => false)); ?>"+"/"+id,//+"/"+excelTdCount,
					      context: document.body,
					      success: function(data){ 
					    	  onCompleteRequest(); //remove loading sreen
					    	  $("#excelArea").html(data).fadeIn('slow');
					    	 
						  }
						});
			    	}
			});
		});
		
		$('#AdminisMeds').click(function(){ 
			$.fancybox({ 
				'width':'70%',
				'height':'100%',
			    'autoScale': true, 
			    'scrolling':'auto',
			    'href': "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "patientWristBandCheck",$patient_id, "admin" => false)); ?>",
			    'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	true,
				'type':'iframe'
				 
		    });
		});

		function loading(){
			  
			 $('#treeDivArea').block({ 
		        message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please wait...</h1>',
		        css: {            
		            padding: '5px 0px 5px 18px',
		            border: 'none', 
		            padding: '15px', 
		            backgroundColor: '#fffff', 
		            '-webkit-border-radius': '10px', 
		            '-moz-border-radius': '10px',               
		            color: '#fff',
		            'text-align':'left' 
		        },
		        overlayCSS: { backgroundColor: '#000000' } 
		    }); 
		}

		function onCompleteRequest(){
			$('#treeDivArea').unblock(); 
		}

		
	});
	
	function rightMenu(key,newCropId){
		if(key == "quit") return false;
		var callingUrl = "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports","action"=>"samplePage",$patient_id, "admin" => false)); ?>";
		var callingUrl = callingUrl.replace("samplePage",key);
		var height, width;
		switch(key){
		case "medRequest":
			width = '25%';height = '47%';
		break;
		case "adminNote":
			width = '25%';height = '60%';
		break;
		default:
			width = '55%';height = '95%';
		break;		
		}
		
		$.fancybox({ 
			'width': width,
			'height': height,
		    'autoScale': true, 
		    'scrolling':'auto',
		    'href': callingUrl+"/"+newCropId,
		    'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	true,
			'type':'iframe'
			 
	    });
		}
	$(document).on('dblclick','.doubleClick',function() {
		var fancyUrl = "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "contineousInfusionChanges",$patient_id, "admin" => false)); ?>"
		$.fancybox({ 
			'width':'70%',
			'height':'100%',
		    'autoScale': true, 
		    'scrolling':'auto',
		    'href': fancyUrl+'/'+parseInt($(this).attr('id')),
		    'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	true,
			'type':'iframe'
			 
	    });
	});
	jQuery(document).ready(function() {
			$("#dateFrom").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			//dateFormat:'mm/dd/yy',
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		});
	});
	$('#reset').click(function(){
		var url="<?php array('controller'=>'PatientsTrackReports','action'=>'emarDashboard',$patient_id)?>";
		window.location.href =url;
	});
	$('.ViewOne').click(function(){
		value='1';
		var id=$(this).attr('id');
		$.ajax({
				  beforeSend: function(){
					  loading(); // loading screen
				  },
			    
				    
			    		  type: 'POST',
						 url: "<?php echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "dashboardExcelView",$patient_id, "admin" => false)); ?>"+"/"+id,//+"/"+excelTdCount,
					      context: document.body,
					      success: function(data){ 
					    	  onCompleteRequest(); //remove loading sreen
					    	  $("#excelArea").html(data).fadeIn('slow');
					    	 
						  }
						
			    	
			});

	});
</script>
