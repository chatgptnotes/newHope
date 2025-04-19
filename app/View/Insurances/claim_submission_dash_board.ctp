<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg','jquery.blockUI'));
?>
<style>
.light:hover {
	background-color: #99B0B9;
}

iconTd {
	font-size: 9px;
	width: 5%;
	cursor: pointer;
	text-align: center;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Claim Submission Dash Board'); ?>
	</h3>
	<span><?php  //echo $this->Html->link('Back',array("controller"=>"tariffs","action"=>"viewStandard"),array('escape'=>false,'class'=>'blueBtn','title'=>'Back')); ?>
	</span>

</div>
<table style="border: 1px solid #4C5E64; margin: 5px;" width="100%">
	<tr>
		<td class="iconTd" id="boxSpace" onclick='pager.prev();' width="1%"><?php echo $this->Html->image('/img/icons/prev.png',array('alt'=>'Previous','title'=>'Previous'));?>
		</td>
		<td class="iconTd"  id="boxSpace" onclick='pager.next();' width="1%"><?php echo $this->Html->image('/img/icons/next.png',array('alt'=>'Next','title'=>'Next'));?>
		</td>
		<?php $claimStatus = array('Batch'=>'Batch','Payer Mapping'=>'Payer Mapping')?>
		<td class="tdLabel" width="2%" id="boxSpace"><?php echo $this->Form->input('claim_status', array('empty' => 'All Current Statuses','options'=>$claimStatus,
				'style'=>'width:43%','id' =>'claim_status','label'=>false,'style'=>array('algin-Text:center'))); ?>
		</td>
		<td class="iconTd" id="boxSpace" style="float:left; padding: 10px 0 0 25px;"><?php echo $this->Html->image('/img/claim_icons/newbatch.PNG',array('alt'=>'New Batch','title'=>'New Batch','id'=>'newBatch'));?>
       
		</td>
		<td class="iconTd" id="boxSpace" style="float:left; padding: 10px 0 0 60px;"><?php echo $this->Html->image('/img/claim_icons/mappayers.PNG',array('alt'=>'Map Payer','title'=>'Map Payer','id'=>'newPayer'));?>
		</td>
	</tr>
	<tr>
		<td class="iconTd" onclick='pager.prev();'>Prev</td>
		<td class="iconTd" onclick='pager.next();'>Next</td>
		<td></td>
		<td style="float:left;">New Batch</td>
		<td class="iconTd" style="float: left; padding: 0px 0px 0px 20px;">Map Payer</td>
	</tr>
</table>
<div id='Basic'>
	<!--  <table width="100%">
		<tr class="row_title">

			<td width="1%" align="center"><?php echo __('Total files')?></td>
			<td width="1%" align="center"><?php echo __('Rtn To Prov')?></td>
			<td width="9%" align="center">
				<table width="100%">
					<tr class="row_title">
						<td colspan=7 align='center'>Not Submitted</td>
					</tr>
					<tr class="row_title">
						<td>Translated</td>
						<td>Map Payer</td>
						<td>Map Provider</td>
						<td>Suspended</td>
						<td>Ready</td>
						<td>Failed</td>
						<td>Total</td>
					</tr>
				</table>
			</td>
			<td width="9%" align="center">
				<table width="100%">
					<tr class="row_title">
						<td colspan=5 align='center'>Submitted</td>
					</tr>
					<tr class="row_title">
						<td>Sent</td>
						<td>Received</td>
						<td>Processed</td>
						<td>Remit</td>
						<td>Total</td>
					</tr>
				</table>
			</td>
			<td width="2%" align="center"><?php echo __('Total files')?></td>
		</tr>
		<tr class="row_title">

			<td width="1%" align="center"><?php echo $this->Html->image('/img/icons/phone.png',array('style'=>'float: none;'));?>
			</td>
			<td width="1%" align="center"><?php echo __('Batch')?></td>
			<td width="1%" align="center"><?php echo __('Submission Date')?></td>
			<td width="1%" colspan=2 align="center"><?php echo __('File Name')?>
			</td>
		</tr>
	</table>-->
	<!--  <table width="100%" cellspacing=0 cellpadding=0>
		<tr class='light'>
			<td width="1%" align="left"><font color='#01BE01'><?php echo __('345')?><br />9878.00</font>
			</td>
			<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('26')?><br />4337.00</td>
			<td width="1%" align="left"><font color='red'><?php echo __('95')?><br />20633.00</font>
			</td>
			<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('121')?><br />24098.00</td>
			<td width="1%" align="left"><?php echo __('23')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('156')?><br />4337.00</td>
			<td width="1%" align="left"><?php echo __('30')?><br />4337.00</td>
			<td width="1%" align="left"><?php echo __('15')?><br />4337.00</td>
			<td width="1%" align="left"><?php echo __('24')?><br />4337.00</td>
			<td width="1%" align="left"><font color='#01BE01'><?php echo __('345')?><br />4337.00</font>
			</td>
		</tr>
		<tr class='light'>
			<td width="1%" align="left"><font color='#01BE01'><?php echo __('345')?><br />9878.00</font>
			</td>
			<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('26')?><br />4337.00</td>
			<td width="1%" align="left"><font color='red'><?php echo __('95')?><br />20633.00</font>
			</td>
			<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('121')?><br />24098.00</td>
			<td width="1%" align="left"><?php echo __('23')?><br />000.00</td>
			<td width="1%" align="left"><?php echo __('156')?><br />4337.00</td>
			<td width="1%" align="left"><?php echo __('30')?><br />4337.00</td>
			<td width="1%" align="left"><?php echo __('15')?><br />4337.00</td>
			<td width="1%" align="left"><?php echo __('24')?><br />4337.00</td>
			<td width="1%" align="left"><font color='#01BE01'><?php echo __('345')?><br />4337.00</font>
			</td>
		</tr>
	</table>-->
	<table width="100%">
		<tr class="row_title">
			<td width="1%" align="center"><?php echo __('Total files')?></td>
			<td width="1%" align="center"><?php echo __('Batch Name')?></td>
			<td width="1%" align="center"><?php echo __('Sent files')?></td>
			<td width="1%" align="center"><?php echo __('Date of Submission')?></td>
			<td width="1%" align="center"><?php echo __('Reject files')?></td>
			<td width="1%" align="center"><?php echo __('Processed files')?></td>
			<td width="1%" align="center"><?php echo __('Amount sent')?></td>
			<td width="1%" align="center"><?php echo __('Remit')?></td>
			<td width="1%" align="center"><?php echo __('Amount Processed')?></td>
		</tr>
<!--  	<tr class=''>
			<td width="1%" align="center"><?php echo __('Total files')?></td>
			<td width="1%" align="center"><?php echo __('Batch Name')?></td>
			<td width="1%" align="center"><?php echo __('Sent files')?></td>
			<td width="1%" align="center"><?php echo __('Date of Submission')?></td>
			<td width="1%" align="center"><?php echo __('Reject files')?></td>
			<td width="1%" align="center"><?php echo __('Processed files')?></td>
			<td width="1%" align="center"><?php echo __('Amount sent')?></td>
			<td width="1%" align="center"><?php echo __('Remit')?></td>
			<td width="1%" align="center"><?php echo __('Amount Processed')?></td>
		</tr>-->
		<tr>
		<td width="1%" align="center" colspan=9><?php echo __('No Records Found')?></td>
		</tr>
	</table>
</div>
<div id='findBatch'></div>
<?php echo $this->Form->end(); ?>

<script>
$('#newBatch').click(function(){ 
	$.fancybox({
				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "addBatch")); ?>",
				
						
			});

});
$('#newPayer').click(function(){ 
	$.fancybox({
				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "newPayer")); ?>",
				
						
			});

});
$('#claim_status').change(function(){
	var claimStatus=$('#claim_status option:selected').text();
	if(claimStatus=='Batch'){	
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "findBatch","admin" => false)); ?>";
		         $.ajax({	
		        	 beforeSend : function() {
		        		// this is where we append a loading image
		        		$('#busy-indicator').show('fast');
		        		},
		        		                           
		          type: 'POST',
		         url: ajaxUrl,
		          dataType: 'html',
		          success: function(data){
		        	  $('#busy-indicator').hide('fast');
		        	  $("#Basic").hide();
		        	  $('#findBatch').show();
			       		$("#findBatch").html(data);  
		          },
					error: function(message){
						alert("Error in Retrieving data");
		          }        }); 
		    
		    return false;
		
					}
	else if(claimStatus=='All Current Statuses'){
		$('#findBatch').hide();
		$('#Basic').show();
	}
	else{
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "findPayer","admin" => false)); ?>";
        $.ajax({	
       	 beforeSend : function() {
       		// this is where we append a loading image
       		$('#busy-indicator').show('fast');
       		},
       		                           
         type: 'POST',
        url: ajaxUrl+'/'+'payer',
         dataType: 'html',
         success: function(data){
       	  $('#busy-indicator').hide('fast');
       	  $("#Basic").hide();
       			$('#findBatch').show();
	       		$("#findBatch").html(data);  
         },
			error: function(message){
				alert("Error in Retrieving data");
         }        }); 
   
   return false;
	} 
	
});

		</script>
