<?php 
echo $this->Html->script(array('/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
	<h3>
		<?php echo __('Account Receivable Summary');?>
	</h3>
</div>
<div id="mainContainerArea">
<?php echo $this->Form->create('Accounting',array('url'=>array('controller'=>'Accounting','action'=>'paymentRecieved'),'id'=>'accountReceivable','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table style="width:50%;margin-left:142px;padding-top:20px;">
<tr>
<td style="width:100px;"><?php echo __("Date")?></td>
<td style="width:150px;"><?php echo $this->Form->input('Billing.from',array('style'=>'width:115px;','id'=>'from','type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter-only]]'));?></td>
<td style="width:150px;"><?php echo $this->Form->input('Billing.to',array('style'=>'width:115px;','id'=>'to','type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter-only]]'));?></td>
<td style="width:180px;"><input type="submit" value="Submit" name="Submit" id="filter" class="blueBtn"></td>
</tr>
</table>
<?php echo $this->Form->end();?>
<script>
var xmlString = '<?php echo $xmlValues; ?>';
var httpRequest = '';
var fromDate = toDate = '';
var graphURL = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "paymentRecieved","admin" => false)); ?>" ;
$( document ).ready(function() {
	//$( "#filter" ).trigger( "click" );
});
$( "#filter" ).click(function() {
	var result = jQuery("#accountReceivable").validationEngine('validate');
	if(result){
		return true;
	}else{
		return false;
	}
});
$( "#filter1" ).click(function() {
if(httpRequest) httpRequest.abort();
var httpRequest = $.ajax({
	  beforeSend: function(){
		  //loading(); // loading screen
	  },
      url: graphURL ,
      context: document.body,
      data : {'fromDate':$("#from").val(),'toDate':$("#to").val()}, 
      type: "POST",
      success: function(data){ 
	      
	  },
	  error:function(){
			alert('Please try again');
			
		  }
});
});

function loading(){
	 $('#mainContainerArea').block({ 
       message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Initializing...</h1>', 
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
       overlayCSS: { backgroundColor: '#cccccc' } 
   }); 
}

function onCompleteRequest(){
	$('#mainContainerArea').unblock(); 
}

$( document ).ajaxStart(function() {
	loading();
});
$( document ).ajaxStop(function() {
	onCompleteRequest();
});
$("#from").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate("");?>', 
	onSelect:function(){$(this).focus();}
});
$("#to").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate("");?>', 
	onSelect:function(){$(this).focus();}
});
</script>
         
<div id="multiaxischartdiv1" align="center" style="padding-top:50px;">
	<?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/MSColumn3D.swf", "multiaxisChartId1", "80%", "400", "0", "0", "xmlString", "multiaxischartdiv1"); ?>
</div>         


</div>
