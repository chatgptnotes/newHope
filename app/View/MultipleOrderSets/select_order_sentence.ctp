<?php echo $this->Html->css(array('internal_style.css'));  
echo $this->Html->script(array('jquery-1.5.1.min'));
?>
<style>
*{
	font-size: 13px;
	padding:0px;
	margin:0px;
}
li{
list-style: none;
list-style-type: none;
}
.dblclick{
	padding-left:5px;
	padding-bottom:3px;
	
}
.serviceHighlighted {
	border: 1px solid aqua;
}
.highlight{
	background:none repeat scroll 0 0 #A1B6BD;
}
#footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    margin-bottom:10px;
}
</style>
<table  width="100%" align="center" cellpadding="0" cellspacing="0" border="0" id="runtimeChargeTable">
<tr class="row_title"><td class="table_cell" align="left">Order Sentences for: <span id="orderSentenceSelected"></span></td></tr>
</table>
<ul>
<li class="dblclick highlight" id="none" style="padding-top:3px;">None</li>
<?php foreach($orderSentences as $key=>$orderSentence){?>
<li class="dblclick" id="<?php echo $key;?>"><?php echo $orderSentence['OrderSentence']['sentence'];?></li>
<?php } ?>
</ul>
<table  width="100%" align="center" cellpadding="0" cellspacing="0" border="0" id="footer">
<tr>


<td align="left">
<div style="float:left;padding-left:10px;"><?php echo $this->Html->link(__('Reset'),'#',array('id'=>'reset','class'=>'blueBtn','div'=>false,'label'=>false));?></div>
<div style="float:right;padding-right:10px;"><?php echo $this->Html->link(__('OK'),'#',array('id'=>'ok','class'=>'blueBtn','div'=>false,'label'=>false));?></div>
<div style="float:right;padding-right:10px;"><?php echo $this->Html->link(__('Cancel'),'#',array('id'=>'cancel','class'=>'blueBtn','div'=>false,'label'=>false));?>
</div>
</td>
</tr>
</table>
<script>
var chosen = "";
var selectedSentenceId = 'none';
var selectedSentenceName = '';
$("#reset").click(function(){
	$('li').removeClass('highlight');
	$('#none').addClass('highlight');
	parent.chosenOrderSentenceId = selectedSentenceId  = 'none';
	parent.lastSelectedOrderSentenceName = selectedSentenceName = 'none';
});

$("#ok").click(function(){
	parent.chosenOrderSentenceId = selectedSentenceId;
	parent.lastSelectedOrderSentenceName = selectedSentenceName
	parent.chosenOrderSentence();
	parent.buildOrders();
	parent.$.fancybox.close();
});

$("#cancel").click(function(){
	parent.chosenOrderSentenceId = selectedSentenceId  = 'none';
	parent.lastSelectedOrderSentenceName = selectedSentenceName = 'none';
	parent.$.fancybox.close();
});

$(".dblclick").click(function(){
	$('li').removeClass('highlight');
	$(this).addClass('highlight');
	selectedSentenceId = $(this).attr('id');
	selectedSentenceName = $(this).text();
});

$(".dblclick").hover(function(){
	//$('li').removeClass('highlight');
	//$(this).addClass('highlight');
});


$(document).ready(function(){
	$("#orderSentenceSelected").html(parent.lastSelectedOrderSentenceName);
});

$(document).keydown(function(e){ // 38-up, 40-down
  if (e.keyCode == 40) { 
   if(chosen === "") {
       chosen = 0;
   } else if((chosen+1) < $('li').length) {
       chosen++; 
   }
   $('li').removeClass('highlight');
   $('li:eq('+chosen+')').addClass('highlight');
   var result = $('li:eq('+chosen+')').text();
   
   return false;
}
if (e.keyCode == 38) { 
   if(chosen === "") {
       chosen = 0;
   } else if(chosen > 0) {
       chosen--;            
   }
   $('li').removeClass('highlight');
   $('li:eq('+chosen+')').addClass('highlight');
   var result = $('li:eq('+chosen+')').text();
   
   return false;
}
if (e.keyCode == 13) { 
	parent.chosenOrderSentenceId = selectedSentenceId = $('li:eq('+chosen+')').attr('id');
	parent.lastSelectedOrderSentenceName = $('li:eq('+chosen+')').text();
	parent.buildOrders();
	parent.$.fancybox.close();
}

});

</script>