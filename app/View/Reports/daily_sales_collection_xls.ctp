<?php
	echo $this->Html->script(array('inline_msg','jquery.selection.js','jquery.fancybox-1.3.4','jquery.blockUI','jquery.contextMenu'));
?>

<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
//header ("Content-Disposition: attachment; filename=\"TOR_report_".date('d-m-Y').".xls");
header ("Content-Disposition: attachment; filename=\"Daily Sales Collection ".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Daily Sales Collection" );
ob_clean();
flush();
?>

<table width="50%" cellpadding="0" cellspacing="0" border="1" class="tabularForm">
		<tr class='row_title'> 
		   <td colspan="17" width="100%" height='30px' align='center' valign='middle'>
		   		<h2><?php echo __('Daily Sales Collection Report'); ?></h2>
		   </td>
	  	</tr>
		<tr>
			<thead>
					
					<th width="5px" valign="top" align="center" style="text-align:center;">SNo.</th>
					<th width="51px" valign="top" align="center" style="text-align:center;">BillNO.</th>
					<th width="51px" valign="top" align="center" style="text-align:center;">BillDate</th>
					<th width="145px" valign="top" align="center" style="text-align:center;">UserName</th>
					<th width="48px" valign="top" align="center" style="text-align:center;">Reg_No.</th>
					<th width="66px" valign="top" align="center" style="text-align:center;">Patient Name</th>
					<th width="47px" valign="top" align="center" style="text-align:center;">VisitType</th>
					<th width="61px" valign="top" align="center" style="text-align:center;">Sales Amnt</th>
					<th width="61px" valign="top" align="center" style="text-align:center;">Paid Amnt</th>
					<th width="61px" valign="top" align="center" style="text-align:center;">Balance</th>
					<th width="37px"  valign="top" align="center" style="text-align:center;">Concession</th>
					<th width="37px" valign="top" align="center" style="text-align:center;">Discount</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Refund</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Company Balance</th>
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
			<td>
			<?php if(!empty($records['PharmacySalesBill']['total'])){
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
		<?php $this->Form->end();?>
	</td>
</tr>
</table>



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


});

</script>