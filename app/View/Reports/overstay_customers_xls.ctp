<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Stock Ledger Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Stock Ledger Report" );
ob_clean();
flush();
?>
<style>

.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}

.top-header {
	background: #3e474a;
	height: 75px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

textarea  
{
	width: 80px;
}
#inner_menu img{ float:none !important;}
div{ font-size:13px;}
.inner_title span{ margin:-26px 0px;}

</style>
 <div class="inner_title" > 
 	<h3>&nbsp; Overstay Patients Report</h3> 
    <div style="float:right;">
			<!-- 	<span style="float:right;">
					<?php
// 						echo $this->Form->create('Corporates',array('action'=>'admin_mahindra_xls', 'admin' => true,'type'=>'post', 'id'=> 'losxlsfrm'));
// 						echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
// 						echo $this->Form->submit(__('Generate Excel Report'),array('style'=>'padding:0px;','class'=>'blueBtn','div'=>false,'label'=>false));
// 						echo $this->Form->end();
// 					?>
				</span> -->
			</div>
 </div>


	
	<div class="clr">&nbsp;</div>
	<div id="container">
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm"> 
		<tr>
		  	<thead>
				
				<th width="5px" valign="top" align="center" style="text-align:center;">#</th>
				<th width="51px" valign="top" align="center" style="text-align:center;">Patient Name</th>
				<th width="60px" valign="top" align="center" style="text-align:center;">Visit ID</th>
				<th width="51px" valign="top" align="center" style="text-align:center;">Age</th>
				<th width="51px" valign="top" align="center" style="text-align:center;">Sex</th>
				<th width="60px" valign="top" align="center" style="text-align:center;">Admission Date</th>
				<th width="66px" valign="top" align="center" style="text-align:center;">Discharge Date</th>
				<th width="47px" valign="top" align="center" style="text-align:center;">Length of Stay</th>
				
	   		</thead>
      	</tr>
      
    
    
    <?php  $i=0; //debug($results);
    	foreach($results as $result) 
    	  {	
    	  	$patient_id = $result['Patient']['id'];
    	  	$bill_id = $result['FinalBilling']['id'];
    	  	$i++;  	
    ?>
    	<tr>
    		<td width="8px" valign="top" align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    		</td>
    		<td width="55px" style="text-align:center;">
				<?php echo $result['Patient']['lookup_name'];?>
			</td>
    		
    		<td width="66px" style="text-align:center;">
				<?php 
					// Admission Date
	 				echo $result['Patient']['admission_id'];	
	 				
				?> 
			</td>
	    	
			
			<td align='center' height='17px'><?php echo $result['Person']['age'] ?></td>  
					    <td align='center' height='17px'><?php echo ucfirst($result['Person']['sex']); ?></td>
			
			<td width="66px" style="text-align:center;">
				<?php 
					// Admission Date
	 				$admitn_date =($result['Patient']['form_received_on']);	
	 				echo $this->DateFormat->formatDate2Local($admitn_date, Configure::read('date_format'));
				?> 
			</td>			
			
			
			
			<td width="71px" style="text-align:center;">
				<?php 
						// Discharge Date
		 				$discharg_date =($result['Patient']['discharge_date']);	
		 				echo $this->DateFormat->formatDate2Local($discharg_date, Configure::read('date_format'));
				?>
			</td>
			
			<td width="71px" style="text-align:center;">
				<?php 
				$losStr=" ";
						// LOS
		 				 $los = $this->DateFormat->dateDiff($result['Patient']['form_received_on'],$result['Patient']['discharge_date']) ;
		                $losStr .= " ".$los->days."Day(s)" ;
		                echo $losStr; ?>
			</td>
			
		
			
    		
			</tr>
    	
<!--     		<td>  -->
    		<?php //echo $bill_id; ?>
<!--     		</td> -->
    <?php } ?>	
    </table>
	




<Script>

/* $('.LookUpName').click(function()
		  {
		  	//alert("OK");
		  	var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;
		  	//alert(lookup_name);
				
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'reports', "action" => "overstay_customers", "admin" => true));?>";
				$.ajax({
				url : ajaxUrl + '?lookup_name=' + lookup_name,
				beforeSend:function(data){
				$('#busy-indicator').show();
			},
				success: function(data){
					$('#busy-indicator').hide();
					$("#container").html(data).fadeIn('slow');
					
				}
				});
			});

*/
		

 $("#lookup_name").autocomplete("<?php echo $this->Html->url(
				array("controller" => "app", "action" => "autocomplete","Patient",'lookup_name',"admin" => false,"plugin"=>false)); ?>", 
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

		
</Script>