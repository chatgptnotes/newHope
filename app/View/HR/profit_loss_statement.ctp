<?php echo $this->Html->css(array('jquery.tree'));      
	  echo $this->Html->script(array('jquery.tree'));
	  echo $this->Html->script(array('jquery.fancybox-1.3.4'));
	  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>
<style>

.blueBtn0 {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: rgba(0, 0, 0, 0) linear-gradient(#B8FF94, #B8FF94) repeat scroll 0 0 !important;
    border-color: #1a5bb7 #1a5bb7 #589cb6;
    border-image: none;
    border-radius: 5px;
    border-style: solid;
    border-width: 1px;
    color: #000 !important;
    font-weight: normal;
    height: none !important;
    padding: 4px 10px;
    position: relative;
}
.daredevel-tree li span.daredevel-tree-anchor {
    cursor: pointer !important;   
}
.daredevel-tree li span.daredevel-tree-anchor:hover {
    color: #76D6FF ;
  background-color: #FFFF00 ;    
}
.prntDiv1 {
	float: left;
	padding: 0 5px 0 0;
	width: 70%;
}
.mainParentCls{
	font-size: 14px !important;
	font-weight: lighter;
	color:#4d90fe;
}
.mainParentCls:hover { 
	 font-weight: bold;
	 color: black ;
	 background-color: #FFFF00 !important;
}
.parentCls{
	font-style: italic !important;
	font-size: 14px !important;
	font-weight: lighter;
	color:#3185AC;
}
.parentCls:hover {
	font-weight: bold;
	color: black ;
	background-color: #FFFF00 !important;
}
.subchldDiv1 {
	float: left;
	padding: 0 6px 0 0;
	width: 75%;
}
.subchildCls{
	font-size: 13px !important;
	font-weight: normal;	
}
.subchildCls:hover {
    color: black !important;
  	background-color: #FFFF00 !important;
  	font-weight: bold;
}
body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif !important;
	font-size: 10px !important;
	/*color: #000000;*/
	/*background-color: #F0F0F0;*/
}
.ui-widget-content {
    background: url("../img/ui-bg_flat_75_ffffff_40x100.png") repeat-x scroll 50% 50% #ffffff;
    border: none;
    color: #fff;
}
input,textarea {
	border: 1px solid #999999;
	padding: none !important;
}
.ui-widget-content {
	color: #000 !important;
}
ul {
	padding-left: 20px !important;
}
.leaf {
	clear: both;
}
.expanded {
	clear: both;
}
.collapsed {
	clear: both;
}
#ui-datepicker-div{
		width: 190px;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Profit & Loss A/C', true); ?>
	</h3>
	<span>
	<?php   if($flag=='fromAcc'){
				echo $this->Html->link(__('Back to Report'), array('controller'=>'Accounting','action' => 'index','admin'=>false), array('escape' => false,'class'=>'blueBtn'));			
		    }else{
				echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));
		    }?>
	</span>
</div> 
</br>
<?php echo $this->Form->create('',array('type' => 'POST',
		'url' => array('controller' => 'HR', 'action' => 'profitLossStatement'),'class'=>'manage','style'=>array("float"=>"left","width"=>"100%"),'id'=>'HeaderForm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )
			));	 ?>

<table border="0" class="formFull" cellpadding="0"	cellspacing="0" width="100%" align="left" id="hideHeader">
	<tr>
		<td valign="top"  class="form_lables"><strong><?php echo __('Period',true); ?></strong><font
			color="red">*</font>
		</td>
		<td valign="top" ><?php 
		echo $this->Form->input('', array('name'=>'from_date','type'=>'text', 'id' => 'from_date', 'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd dateCls', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly','value'=>$this->DateFormat->formatDate2Local(date("Y-m-d", strtotime("-1 months")),Configure::read('date_format'), false)));?>
		</td>
		<td valign="top"  class="form_lables"><strong><?php echo __('To',true); ?></strong><font color="red">*</font>
		</td>
		<td valign="top" ><?php echo $this->Form->input('', array('name'=>'to_date','type'=>'text', 'id' => 'to_date', 'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd dateCls', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly','value'=>$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false)));?>
		</td>
		<td valign="top" ><?php echo $this->Html->image('icons/views_icon.png',array('id'=>'Submit','type'=>'submit','title'=>'Search'));?></td>
		<td valign="top"><?php echo $this->Html->image('icons/refresh-icon.png',array('escape'=>false, 'title' => 'refresh','id'=>'refreshBtn'));?>
		</td>
		<td>
		<?php echo $this->Form->submit('Excel',array("onclick"=>"submitExcel();",'class'=>'blueBtn0','label'=> false, 'div' => false,'style'=>"float:right"));
			  		?>	

		<?php echo $this->Html->link('F1: Detailed','javascript:void(0)',array('class'=>'blueBtn0 expandCollapse','label'=> false, 'div' => false,'id'=>'detailed','style'=>'text-decoration: underline;'));

		echo $this->Html->link('F1: Condensed','javascript:void(0)',array('class'=>'blueBtn0 expandCollapse','label'=> false, 'div' => false,'id'=>'condensed','style'=>'display:none;text-decoration: underline;'));
		echo $this->Html->link('F2: Last Year','javascript:void(0)',array('class'=>'blueBtn0','label'=> false, 'div' => false,'id'=>'last_year'));		  		?>
		 <?php echo $this->Html->link('F3: Last Month','javascript:void(0)',array('class'=>'blueBtn0','label'=> false, 'div' => false,'id'=>'last_month'));
		 
		  		?>

		</td>
		<td>
		<?php echo $this->Html->link('F4: Detailed Print','javascript:void(0)',array('class'=>'blueBtn0','label'=> false, 'div' => false,'id'=>'print'));
		echo $this->Html->link('F8: Group Print','javascript:void(0)',array('class'=>'blueBtn0','label'=> false, 'div' => false,'id'=>'printGroup'));
		echo $this->Html->link('P: Print','javascript:void(0)',array('class'=>'blueBtn0','label'=> false, 'div' => false,'onclick'=>"printPage();",'id'=>'anyprint','style'=>'text-decoration: underline;'));
		


		//echo $this->Html->link($this->Html->image('/img/print.png'),'#',				array('style'=>'width:20px','name'=>'print','id' => 'print','title' => 'Print','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>$this->params->action,'print',echo $this->Form->button(__('Print'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'print'));				'?'=>$qryStr))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<div id="records" style="min-height: 550px;"></div>
<div class="clr ht5"></div>
<script>
	//BOF-P-Print
  	function printPage() {  		
  		var prtContent = document.getElementById("records");  		
  		var prtContent=prtContent.innerHTML;
  		//var prtContent=prtContent+'<link rel="stylesheet" type="text/css" href="/hope/css/profit_loss.css" />';
		var WinPrint = window.open('', '', 'left=0,top=0,width=1200,height=900,toolbar=0,scrollbars=0,status=0');
        WinPrint.document.open();
        WinPrint.document.write('<html><head><link rel="stylesheet" type="text/css" href="/hope/css/profit_loss.css" /></head><body onload="window.print()">' + prtContent + '</html>');
        WinPrint.document.close();
		//WinPrint.document.write(prtContent);
		//WinPrint.document.close();
		WinPrint.focus();
		WinPrint.print();
		/*WinPrint.close();   */    
    }
    //EOF-P-Print

function submitExcel(){
    var action = $("#HeaderForm").attr("action");   
    $("#HeaderForm").attr("action",action+'/excel');
}
$(document).ready(function(){
	$("#print").click(function() {
		 var tran_date_from=$("#from_date").val();
		 var tran_date_to=$("#to_date").val();
		 var queryString = "?from_date="+tran_date_from+"&to_date="+tran_date_to;
		 var url="<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossStatement','print')); ?>"+ queryString;
		 window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200");
	});
	$("#printGroup").click(function() {
		 var tran_date_from=$("#from_date").val();
		 var tran_date_to=$("#to_date").val();
		 var queryString = "?from_date="+tran_date_from+"&to_date="+tran_date_to;
		 var url="<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossStatement','printGroup')); ?>"+ queryString;
		 window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200");
	});
				
	//load all records from here using ajax
	// $(document).on( 'click', '#Submit,#refreshBtn', function() {	
		$("#Submit,#refreshBtn").click(function(){ 
			var currentId= $(this).attr('id');		
			if(currentId=="refreshBtn"){		
				/*$("#from_date,#to_date").val("");
				$("#records").html('');*/
				var tran_date_from = '<?php echo $this->DateFormat->formatDate2Local(date("Y-m-d", strtotime("-1 months")),Configure::read('date_format'), false);?>';					
				var tran_date_to = '<?php echo $this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false);?>';
				$("#from_date").val(tran_date_from);
				$("#to_date").val(tran_date_to);
				$.ajax({
						url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossReport'));?>',
						type: 'POST',
						data:$('#HeaderForm').serialize(),
						beforeSend:function(data){
							$('#busy-indicator').show();
						},
						success:function(data){			
							$("#records").html(data).fadeIn('slow');
							$('#busy-indicator').hide();
						}
				});
			}else if(currentId=="Submit"){	
				var valid=jQuery("#HeaderForm").validationEngine('validate');
				if(valid){					
					 $("#submit").hide();
					 $('#busy-indicator').show();
				}else{
					return false;
				}
				$.ajax({
					url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossReport'));?>',
					type: 'POST',
					data:$('#HeaderForm').serialize(),
					beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success:function(data){					
						$("#records").html(data).fadeIn('slow');
						$('#busy-indicator').hide();
					}
				});
			}
			
		});
	//on load render profitLossReport
	$.ajax({
		url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossReport'));?>',
		type: 'POST',
		data:$('#HeaderForm').serialize(),
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success:function(data){			
			$("#records").html(data).fadeIn('slow');
			$('#busy-indicator').hide();
		}
	});
	$("#last_month").click(function(){ 
		var tran_date_from = '<?php echo $this->DateFormat->formatDate2Local(date('Y-m-d', strtotime('first day of last month')),Configure::read('date_format'), false);?>';					
		var tran_date_to = '<?php echo $this->DateFormat->formatDate2Local(date('Y-m-d', strtotime('last day of last month')),Configure::read('date_format'), false);?>';
		$("#from_date").val(tran_date_from);
		$("#to_date").val(tran_date_to);
		$.ajax({
					url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossReport'));?>',
					type: 'POST',
					data: "from_date="+tran_date_from+"&to_date="+tran_date_to,
					beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success:function(data){					
						$("#records").html(data).fadeIn('slow');
						$('#busy-indicator').hide();
					}
		});	
	});
	$("#last_year").click(function(){ 
		<?php $noOfDayFrom = (in_array(date('M'), array('Jan', 'Feb', 'Mar')) ? -2 : 0 );
		$noOfDayTo = (in_array(date('M'), array('Jan', 'Feb', 'Mar')) ? -1 : 0 ); ?>
		
		var tran_date_from = '<?php echo $this->DateFormat->formatDate2Local(date('Y-04-01', strtotime($noOfDayFrom-1 . 'year')),Configure::read('date_format'), false);?>';					
		var tran_date_to = '<?php echo $this->DateFormat->formatDate2Local(date(date('Y-03-d', strtotime('last day of last month')), strtotime($noOfDay . 'year')),Configure::read('date_format'), false);?>';	
		$("#from_date").val(tran_date_from);
		$("#to_date").val(tran_date_to);
		$.ajax({
					url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossReport'));?>',
					type: 'POST',
					data: "from_date="+tran_date_from+"&to_date="+tran_date_to,
					beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success:function(data){					
						$("#records").html(data).fadeIn('slow');
						$('#busy-indicator').hide();
					}
		});	
	});
	$("#from_date").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',		
	});		
	$("#to_date").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',		
	});
	$(document).on( 'click', '.expandCollapse', function() {
		//BOF-Expanded Or Collapsed li 
		var currentId= $(this).attr('id');	
		if(currentId=='detailed'){
			$('#condensed').css('display','');
			$('#detailed').css('display','none');
			$(".groupExpandCollapsed").removeClass("collapsed");
			$(".groupExpandCollapsed").addClass("expanded");	
			$('.mainParentClsUl').css('display', 'block');	
			$('.parentClsUl').css('display', 'block');	
			$('.legderUl').css('display', 'block');			
		}else if(currentId=='condensed'){
			$('#condensed').css('display','none');
			$('#detailed').css('display','');
			$(".groupExpandCollapsed").addClass("collapsed");
			$(".groupExpandCollapsed").removeClass("expanded");	
			$('.parentClsUl').css('display', 'none');	
			$('.legderUl').css('display', 'none');	
		}
		//EOF-Expanded Or Collapsed li 
	});
	

});
//shortcut key 
$(document).bind('keydown', function(e) {	
	if (e.altKey && e.keyCode == "112"){	// alter + F1
		//BOF-Expanded Or Collapsed li 
		var currentId= $('.expandCollapse').attr('id');	
		//alert($('#detailed').css("display")+"++++++++++"+$('#condensed').css("display"));
		if($('#detailed').css("display") == "inline"){			
			$('#condensed').css('display','');
			$('#detailed').css('display','none');
			$(".groupExpandCollapsed").removeClass("collapsed");
			$(".groupExpandCollapsed").addClass("expanded");	
			$('.mainParentClsUl').css('display', 'block');	
			$('.parentClsUl').css('display', 'block');	
			$('.legderUl').css('display', 'block');			
		}else if($('#condensed').css("display") == "inline"){			
			$('#condensed').css('display','none');
			$('#detailed').css('display','');
			$(".groupExpandCollapsed").addClass("collapsed");
			$(".groupExpandCollapsed").removeClass("expanded");	
			$('.parentClsUl').css('display', 'none');	
			$('.legderUl').css('display', 'none');	
		}
		currentId='';
		//EOF-Expanded Or Collapsed li 	
	}else if(e.keyCode == "113"){ //F2
		//BOF-Last Year
			<?php $noOfDayFrom = (in_array(date('M'), array('Jan', 'Feb', 'Mar')) ? -2 : 0 );
		$noOfDayTo = (in_array(date('M'), array('Jan', 'Feb', 'Mar')) ? -1 : 0 ); ?>
		
		var tran_date_from = '<?php echo $this->DateFormat->formatDate2Local(date('Y-04-01', strtotime($noOfDayFrom-1 . 'year')),Configure::read('date_format'), false);?>';					
		var tran_date_to = '<?php echo $this->DateFormat->formatDate2Local(date(date('Y-03-d', strtotime('last day of last month')), strtotime($noOfDay . 'year')),Configure::read('date_format'), false);?>';	
		$("#from_date").val(tran_date_from);
		$("#to_date").val(tran_date_to);
		$.ajax({
					url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossReport'));?>',
					type: 'POST',
					data: "from_date="+tran_date_from+"&to_date="+tran_date_to,
					beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success:function(data){					
						$("#records").html(data).fadeIn('slow');
						$('#busy-indicator').hide();
					}
		});	
		//EOF-Last Year
				
	} else if(e.keyCode == "114"){ //F3
	//BOF-Last Month
		var tran_date_from = '<?php echo $this->DateFormat->formatDate2Local(date('Y-m-d', strtotime('first day of last month')),Configure::read('date_format'), false);?>';					
		var tran_date_to = '<?php echo $this->DateFormat->formatDate2Local(date('Y-m-d', strtotime('last day of last month')),Configure::read('date_format'), false);?>';
		$("#from_date").val(tran_date_from);
		$("#to_date").val(tran_date_to);
		$.ajax({
					url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossReport'));?>',
					type: 'POST',
					data: "from_date="+tran_date_from+"&to_date="+tran_date_to,
					beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success:function(data){					
						$("#records").html(data).fadeIn('slow');
						$('#busy-indicator').hide();
					}
		});		
		//EOF-Last Month		
		
	} else if (e.keyCode == "115"){	//F4
		//BOF-Deatailed	Print
		 var tran_date_from=$("#from_date").val();
		 var tran_date_to=$("#to_date").val();
		 var queryString = "?from_date="+tran_date_from+"&to_date="+tran_date_to;
		 var url="<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossStatement','print')); ?>"+ queryString;
		 window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200");
		//EOF-Deatailed	Print			
	} else if (e.keyCode == "119"){	//F8		
		//BOF-Group print
		 var tran_date_from=$("#from_date").val();
		 var tran_date_to=$("#to_date").val();
		 var queryString = "?from_date="+tran_date_from+"&to_date="+tran_date_to;
		 var url="<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossStatement','printGroup')); ?>"+ queryString;
		 window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200");
		 //EOF-Group print
	}else if(e.altKey && e.keyCode == 80){
		//BOF- Alter+ P print
		var prtContent = document.getElementById("records");
		var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
		WinPrint.document.write(prtContent.innerHTML);
		//WinPrint.document.close();
		WinPrint.focus();
		WinPrint.print();
		/*WinPrint.close();   */
		//EOF- Alter+ P print		
	}/* else if(e.keyCode == "119"){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'day_book'));?>";
	}*/
});
</script>
