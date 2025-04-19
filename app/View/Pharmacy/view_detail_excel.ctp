<?php 
 header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Sales_bill_detail".$for."_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );  
ob_clean();
flush();
?> 

<?php  
    $fromDate = $this->DateFormat->formatDate2Local($allData[0]['Patient']['form_received_on'],Configure::read('date_format'),false);
    $admissionId = $allData[0]['Patient']['admission_id'];
    $tarrifName = $tariffName['TariffStandard']['name'];
    $patientName = $allData[0]['Patient']['lookup_name'];
    $initial = $initialName['PatientInitial']['name'];
    if(!empty($allData[0]['Patient']['discharge_date'])){
    	 $currentDate = $this->DateFormat->formatDate2Local($allData[0]['Patient']['discharge_date'],Configure::read('date_format'),false);
    }else{
    	 $currentDate = date("d/m/Y"); 
    } 
 ?>
 
<table class="table_changeFormat" style="padding-top:0;" align="center" cellpadding="0" cellspacing="0" width="90%" border="1">
	<thead>
		<tr>
		<td colspan="5" align="Center" class="titleFont" style="font-weight: 10px;"><strong><?php echo __("HOPE HOSPITAL PHARMACY");?></strong>
		<tr>
		<td colspan="5" align="center" class="titleFont"><strong><?php echo __("List Of Pharmacy Sale Bills from : ").$fromDate.__(" TO ").$currentDate;?></strong></td>
		</tr>
		<tr>
		<td colspan="5" align="center"  class="titleFont"><strong> <?php echo $admissionId."(".$tarrifName.")".$initial." ".$patientName;?></strong></td>
		</tr>
		<tr class="row_title">
			<td class="row_format" style="font-weight: bold;"><?php echo __("Date"); ?></td>
			<td align="center" class="row_format" style="font-weight: bold;"><?php echo __("Bill No"); ?></td>
			<td align="right" class="row_format" style="font-weight: bold;"><?php echo __("Debit");?></td> 
			<td align="right" class="row_format" style="font-weight: bold;"><?php echo __("Credit");?></td>
			
			<td align="right" style="font-weight: bold;"><?php echo __("Balance"); ?></td>
		</tr>
	</thead>	
	
	<?php
	 $totalBal=0; $totalCredit=0; $count = 0; $i=0;
    foreach($allData as $data) { $count++;
      ?>
	<?php if($count%2==0){
		$class = "";}else{
		$class = "row_gray"; }?>
	<tr class="<?php echo $class;?>"> 
		<td class="row_format editDate expiry_date" contenteditable="true" id ="editableDate_<?php echo isset($data['PharmacyDuplicateSalesBill']['id'])?$data['PharmacyDuplicateSalesBill']['id']:$data['PharmacySalesBill']['id'];?>" value="" >
			<?php 
				if(isset($data['PharmacyDuplicateSalesBill']['modified_date']) || isset($data['PharmacyDuplicateSalesBill']['create_time'])){
					if(!empty($data['PharmacyDuplicateSalesBill']['modified_date'])){
						echo $data['PharmacyDuplicateSalesBill']['modified_date'];
					}else{
	 					echo $this->DateFormat->formatDate2Local($data['PharmacyDuplicateSalesBill']['create_time'],Configure::read('date_format'),false);
					}
				}else{
					if(!empty($data['PharmacySalesBill']['modified_date'])){
						echo $data['PharmacySalesBill']['modified_date'];
					}else{
	 					echo $this->DateFormat->formatDate2Local($data['PharmacySalesBill']['create_time'],Configure::read('date_format'),false);
					}
				}
			?>
		</td>
		<td class="row_format" align="center">
			<?php echo isset($data['PharmacyDuplicateSalesBill']['bill_code'])?$data['PharmacyDuplicateSalesBill']['bill_code']:$data['PharmacySalesBill']['bill_code'];?>
		</td>
		<td class="row_format" align="right">
			<?php echo (number_format($tot = isset($data['PharmacyDuplicateSalesBill']['total'])?$data['PharmacyDuplicateSalesBill']['total']:$data['PharmacySalesBill']['total'],2));    // total amount against single Bill  ?> 
		</td>
		<td class="row_format" align="right">
			<?php echo "&nbsp"/* $data['PharmacySalesBill']['bill_code'] */;?>
		</td>
		<?php  $totalBal = $totalBal+$tot;
			   $totalCredit = $totalCredit+$tot;
		 ?>
		 <!--<td class="row_format">
			<?php echo !empty($data['PharmacyDuplicateSalesBill']['discount'])?(number_format($data['PharmacyDuplicateSalesBill']['discount'],2)):"";    // total amount against single Bill  ?> 
		</td>
		<td class="row_format">
			<?php echo "&nbsp"/* $this->Number->currency(number_format($data['PharmacySalesBill']['discount'],2)); */    // total amount against single Bill  ?> 
		</td>-->
		<td class="row_format" align="right">
			<?php echo (number_format($totalBal,2));?>
		</td>
		
	</tr>
	<?php  $i++;} $totalDebit=0; 
		foreach($saleReturn as $data){ $count++;
	?>
	<?php if($count%2==0){
		$class = "";}else{
		$class = "row_gray"; }?>
		
	<tr class="<?php echo $class;?>">
		<td class="row_format" contenteditable="true">
			<?php echo $this->DateFormat->formatDate2Local($data['InventoryPharmacySalesReturn']['create_time'],Configure::read('date_format'),false);?>
		</td>
		<td class="row_format" align="center">
			<?php echo $data['InventoryPharmacySalesReturn']['bill_code'];?>
		</td>
		<td class="row_format">
			<?php echo "&nbsp"/* $data['InventoryPharmacySalesReturn']['total'] */;    // total amount against single Bill  ?> 
		</td>
		<td class="row_format" align="right">
			<?php echo (number_format($data['InventoryPharmacySalesReturn']['total'],2));?>
		</td>
		<!-- <td class="row_format">
			<?php echo !empty($data['PharmacySalesBill']['discount'])?(number_format($data['PharmacySalesBill']['discount'],2)):"";    // total amount against single Bill  ?> 
		</td>
		<td class="row_format">
			<?php echo "&nbsp";//$this->Number->currency(number_format($data['PharmacySalesBill']['discount'],2));    // total amount against single Bill  ?> 
		</td>-->
		<?php  $totalBal = $totalBal-$data['InventoryPharmacySalesReturn']['total']; ?>
		<td class="row_format" align="right">
			<?php echo (number_format($totalBal,2));
				$totalDebit = $totalDebit+$data['InventoryPharmacySalesReturn']['total'];
			?>
		</td>
	</tr>
	<?php } ?>
	<?php $count++; 
	if($count%2==0){
		$class = "";}else{
		$class = "row_gray"; }?>
	<tr class="<?php echo $class;?>">
		<td class="row_format" style="font-weight: bold;">
			<?php echo __("Total");?>
		</td>
		<td class="row_format">
			<?php echo "&nbsp" /* $data['InventoryPharmacySalesReturn']['bill_code'] */;?>
		</td>
		<td class="row_format" style="font-weight: bold;" align="right">
			<?php echo (number_format($totalCredit,2));    // sum of credit amount?> 
		</td>
		<td class="row_format" align="right">
			<h4><?php echo !empty($totalDebit)?(number_format($totalDebit,2)):"";    ?></h4>
		</td>
		<!-- <td class="row_format">
			<?php echo !empty($data['PharmacyDuplicateSalesBill']['discount'])?(number_format($data['PharmacyDuplicateSalesBill']['discount'],2)):"";    // total amount against single Bill  ?> 
		</td>
		<td class="row_format">
			<?php echo "&nbsp";//$this->Number->currency(number_format($data['PharmacySalesBill']['discount'],2));    // total amount against single Bill  ?> 
		</td>-->
		<td class="row_format" style="font-weight: bold;" align="right">
			<?php echo (number_format($totalBal,2));?>
		</td>
	</tr>							
	
</table>