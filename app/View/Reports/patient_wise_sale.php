
<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css','colResizable.css'));  
 echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js','colResizable-1.4.min.js')); ?>
<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}
element.style {
    min-height: 565px;
}
.top-header {
	background: #3e474a;
	height: 60px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}
textarea {
	width: 85px;
}
.tdLabel2 img{ float:none !important;}
</style>
<?php //echo $this->element('reports_menu');
 ?>
 <div class="clr ht5"></div>
<div class="inner_title">
	<h3 style="float: left;">Party wise purchase Report</h3>
     <div style="float:right;">
				<span style="float:right;">
					<?php
						
				echo $this->Form->create('surgeonreport',array('url'=>array('controller'=>'Reports','action'=>'party_wise_purchase_report','admin'=>'TRUE'),'id'=>'surgeonreport','type'=>'get', 'style'=> 'float:left;')); 
				echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
						 echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',		
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));	?>
			
				</span>
			</div>
	<div class="clr"></div>
</div>
<div class="clr ht5"></div>
<div style="float: left; padding-bottom:15px;">

		<table width="" cellpadding="0" cellspacing="0" border="0"
			class="tdLabel2" style="color: #b9c8ca;">
			<tr>
				<td style="color:#000;"><?php
			echo __("Supplier Name : ")."&nbsp;".$this->Form->input('supp_name', array('id' => 'supp_name', 'value'=>$this->params->query['name'],'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name'));
			?> 
			
			<span>
	    	<?php 
	    		echo "
		Date From : "."&nbsp;".$this->Form->input('from', array('id'=>'fromDate','value'=>$this->request->query['from'],'label'=> false, 'div' => false, 'error' => false)); 
	    	?>
	    </span>
	    <span>
	    	<?php 
	    		echo "To Date : "."&nbsp;".$this->Form->input('to', array('id'=>'toDate','value'=>$this->request->query['to'],'label'=> false, 'div' => false, 'error' => false));
	    	?>
	    </span>
			<span > 
			<?php 
				echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false));	
			?>
			</span>
			<?php
				echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'party_wise_purchase_report'),array('escape'=>false, 'title' => 'refresh'));
				echo $this->Form->end();
			?>
			</span>
			</td>
			</tr>
		</table>
	</div>
    <div class="clr">&nbsp;</div>
<div id="container">                
<?php if(!empty($reports)){
$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));?>
<table max-width="1200px" cellpadding="0" cellspacing="1" border="0" class="tabularForm labTable resizable sticky" id="item-row"
	style="top:0px;overflow: scroll;">
	<tr>
	     <th width="5%"  align="center" style="text-align:center;">No.</th>
		<th width="40%" align="left" style="text-align:center;"><strong>
		 <?php echo $this->Paginator->sort('InventorySupplier.name', __('Name Of Supplier', true)); ?></strong></th>		 
		<th width="15%"  align="center"  style="text-align: center;"> Bill NO</th>
		<th width="15%"  align="center"  style="text-align: center;"> Total amount</th>
		<th width="15%"  align="center"  style="text-align: center;"> Payment Type</th>
		<th width="15%"  align="center"  style="text-align: center;"> Tax</th>
	    <th width="15%"  align="center"  style="text-align: center;"><strong>
	   <?php echo $this->Paginator->sort('InventoryPurchaseDetail.create_time', __('Date', true)); ?></strong></th>		 
	</tr>
	<?php 
		$i=0; 
		foreach($reports as $result)
		{   $i++;

		$total = $result['InventoryPurchaseDetail']['total_amount'];
		$val1 = $val1 + $total;
	 ?>
		<tr>
    		<td width="5" align="center" style="text-align:center;">
    			<?php echo $i;?>
    		</td>
			<td width="97px"  align="center" style="text-align:center;">
				<?php 
				
					echo $result['InventorySupplier']['name']; ?>
		    </td>
		    
			<td width="149px"  align="center"	style="text-align:center;">
			     	<?php echo $result['InventoryPurchaseDetail']['bill_no']; ?>
		     </td>
			     	
		    <td width="144px"  align="center"	style="text-align:center;">
			     	<?php echo $result['InventoryPurchaseDetail']['total_amount']  ?>
			 </td>
	        <td width="144px"  align="center"	style="text-align:center;">
			     	<?php echo $result['InventoryPurchaseDetail']['payment_mode']  ?>
			 </td>
	          <td width="144px"  align="center"	style="text-align:center;">
			     	<?php echo $result['InventoryPurchaseDetail']['tax'] ?>
			 </td>
			<td width="91px"  align="center"  style="text-align: center;">
				<?php 
				 $date = $this->DateFormat->formatDate2Local($result['InventoryPurchaseDetail']['create_time'],Configure::read('date_format'));
				     echo $date;  ?>
			   </td>
	  
	</tr>
	<?php }  ?>
	<tr> 
   <td width="120"  align="center"  style="text-align: center;font-weight:bold;"colspan="3">Aotal Amount Receivable </td>	
  </td>
   <td width="99px"  align="center" style="text-align: center; font-weight:bold;"> <?php echo  $val1;?></td>
   <td width="99px"  align="center" style="text-align: center; font-weight:bold;" colspan="3"> <?php ?></td>
   </tr>
</table>
<table align="center">
		<tr>
			<?php $this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
			?>
			<TD colspan="8" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</TD>
		</tr>
	</table>
<?php  } else{   	
  ?>
  <tr>
   <TD colspan="4" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php }?>
<?php 

		function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
		{
			$date = $cur_date;
			$date = strtotime($date);
			$date = strtotime("+$no_days day", $date);
			return date('Y-m-d', $date);
		}
	
?>
<Script>
$(function(){
			  
			  var onSampleResized = function(e){  
			    var table = $(e.currentTarget); //reference to the resized table
			  };  

			 $("#item-row").colResizable({
			    liveDrag:true,
			    gripInnerHtml:"<div class='grip'></div>", 
			    draggingClass:"dragging", 
			    onResize:onSampleResized
			  });    
			  
			});	

$("#supp_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","InventorySupplier",'name',"admin" => false,"plugin"=>false)); ?>", 
		{
				width: 80,
				selectFirst: true
		});
	
		$("#fromDate").datepicker
		({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				maxDate: new Date(),
				dateFormat: 'dd/mm/yy',			
			});	
				
		 $("#toDate").datepicker
		 ({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				maxDate: new Date(),
				dateFormat: 'dd/mm/yy',			
			});
		

</script>