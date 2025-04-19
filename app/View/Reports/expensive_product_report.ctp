<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css','colResizable.css'));  
echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js','colResizable-1.4.min.js'));
echo $this->Html->script(array('inline_msg','jquery.selection.js','jquery.blockUI','jquery.contextMenu'));
?>
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

<
style>.tabularForm th {
	padding: 0px 0px;
}

.table_format { /*border: 1px solid #3E474A;*/
	background: #f5f5f5;
}

.first_row {
	padding-bottom: 185px;
}

.row_gray {
	background: none;
}

.nav_link {
	width: 85%;
	float: left;
	margin: 0px;
	padding: 20px;
}

.links {
	float: left;
	font-size: 13px;
	clear: left;
	line-height: 30px;
}

.links:hover {
	background: #F5F5F5;
	padding: 0px;
	margin: 0px;
	text-decoration: none !important;
}

.nav_link a:hover {
	text-decoration: none !important;
}

.table_format td {
	border-bottom: 1px solid #DCDCDC;
}

#report_1 {
	font-weight: bold;
}

;
.tdLabel2 img {
	float: none !important;
}
</style>
<div class="clr ht5"></div>
<div class="inner_title">
	<?php echo $this->element('navigation_menu',array('pageAction'=>'Store')); ?>
	<h3 style="float: left;">Expensive Products Report</h3>
	<div style="float: right;">
		<span style="float: right;"> <?php		
		echo $this->Form->create('productreport',array('url'=>array('controller'=>'Reports','action'=>'expensive_product_report'),'id'=>'expprodreport','type'=>'get', 'style'=> 'float:left;'));
		
         
	?>
		</span>
	</div>
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>
<div >
	 
							<table align="center" cellpadding="0" cellspacing="" border="0">
								<tr>
									<td><?php echo __(" Department : "); ?>
									<td><?php echo $this->Form->input('department',array('name'=>'department','label'=> false,'div' => false,'type'=>'select','options'=>array('store'=>'Central Store','pharmacy'=>'Pharmacy'),'class'=>'textBoxExpnd')); ?>
									</td>
									<td>&nbsp;</td>
									<td><?php echo __(" Item Name : "); ?></td>
									<td><?php echo $this->Form->input('',array('type'=>'text','name'=>'item_name', 'id'=>'item_name','label'=>false,'div'=>false,'class'=>'textBoxExpnd')); ?>
									</td>
									<td>&nbsp;</td> 
									<td><?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false)); ?>
									</td>
									<td>&nbsp;</td>
									<td><?php echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn')); ?></td> 
									<td>&nbsp;</td>
									<td><?php  echo $this->Html->link(__('Generate PDF Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'pdf',
		'?'=>$this->params->query),array('id'=>'pdf_report','class'=>'blueBtn')); ?></td>
									<td>&nbsp;</td>
									<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'expensive_product_report'),array('escape'=>false, 'title' => 'refresh'));?>
									</td>
								</tr>
							</table>
						 
							<div class="clr">&nbsp;</div>
							<table class="tabularForm" border="1" cellpadding="0" cellspacing="0" width="100%">

								<tr>
									<th align="center" style="text-align: center;">Sr.No</th>
									<th align="center" style="text-align: center;">
										Product Name</th>
									<th align="center" style="text-align: center;">Stock</th>

								</tr>

								<?php 
								$i=0;
								foreach($reports as $result)
								{
									$i++;
									//holds the id of patient
									?>
								<tr>
									<td width="5" align="center" style="text-align: center;"><?php 
									echo $i;
									?>
									</td>
									<td align="center" style="text-align: center;"><?php if(!empty($result['PharmacyItem']['name'])) echo $result['PharmacyItem']['name']; else echo $result['Product']['name']; ?>
									</td>
									<td align="center" style="text-align: center;"><?php if(!empty($result['PharmacyItem']['stock'])) echo $result['PharmacyItem']['stock']; else  echo $result['Product']['quantity'];?>
									</td>
								</tr>
								<?php } 
	 echo $this->Form->end();?>
							</table> 
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


$("#product_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Product",'name',"admin" => false,"plugin"=>false)); ?>", 
		{
				width: 80,
				selectFirst: true
		});


</script>