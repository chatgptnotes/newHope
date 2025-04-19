<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"EXTERNAL REQUISITION REPORT".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?> 
<STYLE type='text/css'>
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
    
</STYLE>
<?php  $serviceProvider = (array('all'=>'All') + $serviceProvider);  
		$serviceProviderName = $serviceProvider[$this->params->query['service_provider_id']];
		//$serviceProvider = $radData[0]['ServiceProvider']['name']; ?>
<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
 	 <thead>
  		<tr class="row_title">
   			<td colspan = "8" align="center"><h2><?php echo __('EXTERNAL REQUISITION REPORT'); ?></h2></td>
  		</tr>
		<thead>
		<tr>
			<th width="10%" valign="top" align="center" style="text-align: center;"><?php echo __('Diagnostic Center'); ?></th>
			<th width="10%" valign="top" align="center" style="text-align: center;"><?php echo __('Date'); ?></th>
			<th width="15%" valign="top" align="center" style="text-align: center;"><?php echo __('Patient Name'); ?></th>
			<th width="15%" valign="top" align="center" style="text-align: center"><?php echo __('Private/Corporate'); ?></th>	
			<th width="15%" valign="top" align="center" style="text-align: center;"><?php echo __('Investigation'); ?></th>
			<th width="15%" valign="top" align="center" style="text-align: center;"><?php echo __('Cash/Credit'); ?></th> 
			<th width="10%" valign="top" align="center" style="text-align: center;"><?php echo __('Amount Received by Diagnostic Center'); ?></th>
			<th width="10%" valign="top" align="center" style="text-align: center;"><?php echo __("Center's Tariff"); ?></th>
			<th width="10%" valign="top" align="center" style="text-align: center;"><?php echo __('Receivable from Diagnostic Center'); ?></th>
		</tr>
	</thead> 
	<tbody>
		<?php if(count($radData)>0){ ?>
			<?php foreach ($radData as $key=>$val){ $party = $hospital = ''; ?> 
			<?php $tariffAmount = $val['ExternalRequisition']['tariff_amount']; 
					$commission = $val['ExternalRequisition']['hospital_commission'];
					$mode = $val['ExternalRequisition']['mode']; 
					if($val['ExternalRequisition']['mode'] == "On Credit")
					{ 
						$tariff = '';
						$party = $tariffAmount - $commission; 
						$hospital = ''; 
					}else{
						$tariff = $tariffAmount;
						$party = $tariffAmount - $commission;
						$hospital = $commission;	
					}
				?>
			<tr>
				<td style="text-align: left;"><?php echo $val['ServiceProvider']['name'];?></td>
			    <td style="text-align: left;"><?php echo $this->DateFormat->formatDate2Local($val['ExternalRequisition']['created_time'],Configure::read('date_format'), false);?></td>
			    <td style="text-align: left;"><?php echo $val['Patient']['lookup_name'];?></td>
			    <td style="text-align: left;"><?php echo $val['TariffStandard']['name'];?></td>
			    <td style="text-align: left;"><?php echo $val['RadiologyTestOrder']['testname'];?></td>
			    <td style="text-align: left;"><?php echo $mode;?></td>
			    <td style="text-align: right;"><?php echo $tariff; $totalTariff += $tariff; ?></td>
			    <td style="text-align: right;"><?php echo $party; $totalParty += $party;?></td>
			    <td style="text-align: right;"><?php echo $hospital; $totalHospital += $hospital;?></td>
			</tr>
		<?php } ?>
			<tr>
			    <td style="text-align: right;" colspan="6"><?php echo __('Total : ');?></td>
			    <td style="text-align: right;"><?php echo number_format($totalTariff,2); ?></td>
			    <td style="text-align: right;"><?php echo number_format($totalParty,2);?></td>
			    <td style="text-align: right;"><?php echo number_format($totalHospital,2);?></td>
			</tr>
		<?php }else{ ?>
			<tr>
			    <td style="text-align: center;" colspan="7"><b><?php echo __("No record found..");?></b></td>
			</tr>
		<?php } ?>
	</tbody>
</table> 

