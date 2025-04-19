<?php
	echo $this->Html->script(array('inline_msg','jquery.selection.js','jquery.fancybox-1.3.4'  ,'jquery.blockUI','jquery.contextMenu'));
?>

<style>

.tabularForm th{
	padding: 0px 0px ;
}
.table_format {
	/*border: 1px solid #3E474A;*/
	background:#f5f5f5;
}

.row_gray{ background:none;}
.nav_link{ width:85%; float:left; margin:0px; padding:20px;}
.links{ float:left; font-size:13px; clear:left; line-height:30px;}
.links:hover{ background:#F5F5F5;padding:0px; margin:0px;text-decoration: none !important;}
.nav_link a:hover{text-decoration: none !important;}
.table_format td{ border-bottom:1px solid #DCDCDC;}
#report_1{ font-weight: bold;};

.first_row{
	padding-bottom: 185px;
	
}

</style>



<div class="inner_title">
<?php echo $this->element('navigation_menu',array('pageAction'=>'Store')); ?>
<h3>&nbsp; <?php echo __('Daily Sales Collection', true); ?></h3>
	 <span align="right" >
	 
	 	<?php echo $this->Html->link(__('Back'), array('controller'=>'pharmacy','action' => 'department_store'), array('escape' => false,'class'=>'blueBtn'));?> 
		<?php /*echo $this->Form->submit(__('Generate Excel'),array('style'=>'padding:0px;','class'=>'blueBtn','id'=>'ExcelGenerate','div'=>false,'label'=>false)); */?> 
	 </span>
	
</div>


 <div class="clr ht5"></div>
		<?php echo $this->Form->create('',array('id'=>'content-form'));?>
		<table align="center" cellpadding="0" cellspacing="" border="0" >
		<tr>
	
		 <td>
			<tr>
				<td><?php echo __(' From : '); ?></td>
			  <td>
				<?php echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",'value'=>$this->params->data['dateFrom'],
													'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From'));
				?>
			 </td>
			 <td>&nbsp;</td>
			 <td><?php echo __(' To : '); ?></td>
			 <td>				
				<?php echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",'value'=>$this->params->data['dateTo'],
									'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To'));
				?>
			</td>
			<td>&nbsp;</td>
			 <td><?php echo __(' User Name : '); ?></td>
				<td>
				<?php
				  		echo $this->Form->input('', array('name' => 'user_name','id' => 'user_name','label'=> false, 'div' => false, 'value'=>$this->params->data['user_name'], 'error' => false,'autocomplete'=>false,'class'=>'userName textBoxExpnd'));
				  		echo $this->Form->hidden('user_id', array('id' => 'user_id','label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'userName'));
				  	?>
				</td>
				<td>&nbsp;</td>
			 <td><?php echo __(' Visit Type : '); ?></td>
				<td>
		 			<?php
			  			echo $this->Form->input('',array('name'=>'visit_type','empty'=>'Please select','options'=>array('IPD'=>'IPD','OPD'=>'OPD','Customer'=>'Customer'),'id'=>'guarantor_id', 'label'=> false,'div' => false,'class'=>'textBoxExpnd'));
			  		?>
		 		</td>
		 		<td>&nbsp;</td>
			 <td><?php echo __(' Department : '); ?></td>
		 		<td>
		 			<?php echo $this->Form->input('',array('name'=>'department','empty'=>'Please select','options'=>$location_id,'label'=>false,'class'=>'textBoxExpnd')); ?>
		 		</td>
		 		<td>&nbsp;</td>
				<td><?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false)); ?>
								
				</td>
		 		<td>&nbsp;</td>
		 		<td>
		 			<?php echo $this->Form->submit(__('Generate Excel'),array('style'=>'padding:0px;','class'=>'blueBtn','id'=>'ExcelGenerate','div'=>false,'label'=>false)); ?> 
		 		</td>
				<td>&nbsp;</td>
		 		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'daily_sales_collection'),array('escape'=>false, 'title' => 'refresh'));?></td>
			  </tr>  
		 </td>
		</tr>
	</table>
		
		<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="0" border="" class="tabularForm">
		<tr>
			<thead>
					
					<th width="5px" valign="top" align="center" style="text-align:center;">SNo.</th>
					<th width="51px" valign="top" align="center" style="text-align:center;">BillNO.</th>
					<th width="51px" valign="top" align="center" style="text-align:center;">BillDate</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">UserName</th>
					<th width="48px" valign="top" align="center" style="text-align:center;">Reg_No.</th>
					<th width="90px" valign="top" align="center" style="text-align:center;">Patient Name</th>
					<th width="47px" valign="top" align="center" style="text-align:center;">VisitType</th>
					<th width="70px" valign="top" align="center" style="text-align:center;">Sales Amnt</th>
					<th width="61px" valign="top" align="center" style="text-align:center;">Paid Amnt</th>
					<th width="61px" valign="top" align="center" style="text-align:center;">Balance</th>
					<th width="37px"  valign="top" align="center" style="text-align:center;">Concession</th>
					<th width="37px" valign="top" align="center" style="text-align:center;">Discount</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Refund</th>
					<th width="60px" valign="top" align="center" style="text-align:center;">Company Balance</th>
					<th width="72px"  valign="top" align="center" style="text-align:center;">Round off</th> 
					<th width="61px" valign="top" align="center" style="text-align:center;">Pay later</th>
					<th width="61px" valign="top" align="center" style="text-align:center;">Pakage Amnt</th>
					
			</thead>
		</tr>
		
		<?php 
			$i=0;
			foreach ($record as $records){
			$i++;	
		?>
		<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $records['PharmacySalesBill']['bill_code']; ?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($records['PharmacySalesBill']['create_time'],Configure::read('date_format'),false)?></td>
			<td ><?php echo $records['User']['first_name']." ".$records['User']['last_name'];?></td>
			<td><?php if($records['Patient']['admission_id'] && $records['Patient']['admission_id']!='null'){
						echo $records['Patient']['admission_id'];
					}else{
						echo 'null';
					} 
				?>
			</td>
			
			<td><?php if($records['Patient']['lookup_name'] && $records['Patient']['lookup_name']!='null'){
					 	echo $records['Patient']['lookup_name'];
			          }else{
						echo $records['PharmacySalesBill']['customer_name'];	
					  }
					?>
			</td>
			<td><?php if($records['Patient']['admission_type'] && $records['Patient']['admission_type']!='null'){
						echo $records['Patient']['admission_type'];
					  }else{
						echo "Customer";
					  }
				?>
			</td>
			<td><!-- Sale Amnt -->
				<?php echo $records['PharmacySalesBill']['total'];?>
			</td>
			<td><!-- Paid Amnt -->
			<?php if(!empty($records['PharmacySalesBill']['total'])){
						if($records['PharmacySalesBill']['payment_mode']=='cash' || $records['PharmacySalesBill']['payment_mode']=='cheque')
							echo $paidAmnt = $records['PharmacySalesBill']['total'];
						else 
							echo "0.00";
					}
				?>
			</td>
			<td><!-- Balance -->
			<?php if(!empty($records['PharmacySalesBill']['total'])){
						if($records['PharmacySalesBill']['payment_mode']=='credit')
							echo $records['PharmacySalesBill']['total'];
						else 
							echo '0.00';
					}
					?>
			</td>
			<td><?php echo "0.00"; ?></td>
			<td><?php echo "0.00";?></td>
			<td><!-- refund -->
				<?php if(!empty($records['InventoryPharmacySalesReturn']['total'])){
						echo $records['InventoryPharmacySalesReturn']['total'];
					}else{
					    echo "0.00";
					}
				?>
			</td>
			<td><!-- Company Balance -->
				<?php 
					echo "0.00";
				?>
			</td>
			<td>
				<?php 
					echo "0.00";
				?>
			</td>
			<td><?php if(!empty($records['PharmacySalesBill']['total'])){
						if($records['PharmacySalesBill']['payment_mode']=='credit')
							echo $records['PharmacySalesBill']['total'];
						else 
							echo '0.00';
					}
					?>
			</td>
			<td></td>
		</tr>
		
		<?php }?>
		
		
	</table>
	<?php echo $this->Form->end();?>	 
<?php if($this->request->data){ ?>
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
<?php }?>



</div>
<div id="content-list" >
</div>

<script>

$(document).ready(function(){		
$("#dateFrom").datepicker
({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
		
 $("#dateTo").datepicker
 ({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});


 $(".userName").focus(function(){
		$("#user_name").val('');
		$("#user_id").val('');
		$(this).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Users", "action" => "user_autocomplete", "admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 
			 select: function( event, ui ) {
				 $('#user_id').val(ui.item.id); 
				
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	 });


 $("#ExcelGenerate").click(function(){
	 window.location.href = "<?php echo $this->Html->url(array('controller'=>'Reports','action'=>'daily_sales_collection_xls'))?>"
	 });
 

});

</script>