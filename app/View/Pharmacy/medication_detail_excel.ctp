<?php 
 header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"medication_detail".$for."_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );  
ob_clean();
flush();
?> 
<?php //debug($initialName); 
    $fromDate = $this->DateFormat->formatDate2Local($patientDetail['Patient']['form_received_on'],Configure::read('date_format'),false);
    $endDate = $this->DateFormat->formatDate2Local($patientDetail['Patient']['discharge_date'],Configure::read('date_format'),false);
    $admissionId = $patientDetail['Patient']['admission_id'];
    $initial = $initialName['PatientInitial']['name'];
    $patientName = $initial." ".$patientDetail['Patient']['lookup_name'];
    if(!empty($patientDetail['Patient']['discharge_date'])){
    	 $currentDate = $this->DateFormat->formatDate2Local($patientDetail['Patient']['discharge_date'],Configure::read('date_format'),false);
    }else{
    	 $currentDate = date("d/m/Y"); 
    } 
 ?>
<table class="table_changeFormat" style="padding-top:0;" align="center" cellpadding="0" cellspacing="0" width="90%" border="1">
	<thead>
		<tr>
		<td colspan="5" align="Center" class="titleFont" style="font-weight: 10px;"><strong><?php echo __("HOPE MULTISPECIALITY HOSPITAL & RESEARCH CENTER");?></strong></td>
		</tr>
		<tr>
		<td colspan="5" align="center" class="titleFont"><strong><?php echo __("PHARMACY STATEMENT");?></strong></td>
		</tr>
		<tr>
		<td colspan="5" align="center"  class="titleFont"><strong> <?php echo $patientName;?></strong></td>
		</tr>
		<tr>
		<td colspan="5" align="center"  class="titleFont"><strong> <?php echo __("List Of Issued Drugs From : ")."".$fromDate.(" To ").$currentDate;?></strong></td>
		</tr>
		<tr class="row_title">
			<td class="" style="font-weight: bold;" align="left"><?php echo __("Sr.No."); ?></td>
			<td class="" style="font-weight: bold;"><?php echo __("Service Name"); ?></td>
			<td class="" align="center" style="font-weight: bold;"><?php echo __("Date");?></td>
			<td class="" align="center" style="font-weight: bold;"><?php echo __("Quantity");?></td>
			<td align="right" style="font-weight: bold;"><?php echo __("Amount (Rs.)"); ?></td>
		</tr>
	</thead>	

<?php 
	$cnt = 1; $i=0; 
	//debug($detail);
   foreach($detail as $data){ 
//$detail[]
  ?>
	<?php if($count%2==0){
		$class = "";
	}else{
		$class = "row_gray"; 
	}?>
	<tr class="<?php echo $class;?>">
		<td class="row_format" align="left">
			<?php echo $cnt;?>
		</td>
		
		<td class="row_format">
			<?php echo $data['PharmacyItem']['name'];?>
		</td>
		<?php //debug($data);?>
		<td class="row_format editDate" align="center"  contenteditable="true" id ="editableDate_<?php echo isset($data['PharmacyDuplicateSalesBillDetail']['id'])?$data['PharmacyDuplicateSalesBillDetail']['id']:$data['PharmacySalesBillDetail']['id'];?>">
			<?php 
			if(isset($data['PharmacyDuplicateSalesBill']['modified_date']) || isset($data['PharmacyDuplicateSalesBill']['create_time'])){
				if(!empty($data['PharmacyDuplicateSalesBill']['modified_date'])){
					echo $data['PharmacyDuplicateSalesBill']['modified_date'];
				}else{
					echo $this->DateFormat->formatDate2Local($data['PharmacyDuplicateSalesBill']['create_time'],Configure::read('date_format'),false);;    // total amount against single Bill
				}  
			}else{
				if(!empty($data['PharmacySalesBill']['modified_date'])){
					echo $data['PharmacySalesBill']['modified_date'];
				}else{
					echo $this->DateFormat->formatDate2Local($data['PharmacySalesBill']['create_time'],Configure::read('date_format'),false);;    // total amount against single Bill
				} 
			}
					?> 
		</td>
		<td class="row_format" align="center" >
			<?php echo $qty = isset($data['PharmacyDuplicateSalesBillDetail']['qty'])?$data['PharmacyDuplicateSalesBillDetail']['qty']:$data['PharmacySalesBillDetail']['qty'];?>
		</td>
		
		<td class="row_format" align="right">
			<?php 
			 $Qty_typ = isset($data['PharmacyDuplicateSalesBillDetail']['qty_type'])?$data['PharmacyDuplicateSalesBillDetail']['qty_type']:$data['PharmacySalesBillDetail']['qty_type'];
			 $pack = isset($data['PharmacyDuplicateSalesBillDetail']['pack'])?$data['PharmacyDuplicateSalesBillDetail']['pack']:$data['PharmacySalesBillDetail']['pack'];
			 $sale_price =  isset($data['PharmacyDuplicateSalesBillDetail']['sale_price'])?$data['PharmacyDuplicateSalesBillDetail']['sale_price']:$data['PharmacySalesBillDetail']['sale_price'];
			 $mrp = isset($data['PharmacyDuplicateSalesBillDetail']['mrp'])?$data['PharmacyDuplicateSalesBillDetail']['mrp']:$data['PharmacySalesBillDetail']['mrp'];
			 
			 if(!empty($sale_price)){
			 	$calAmntEachMed = ($qty*$sale_price)/$pack;
			 }else{
			 	$calAmntEachMed = ($qty*$mrp)/$pack;
			 }
			 
			 echo number_format($calAmntEachMed,2);
			?>
		</td>
		
	</tr>
	
	<?php $cnt ++; $count++;
		$TotalAmount = $TotalAmount+$calAmntEachMed; 	} ?>
	<tr>
		<td class="row_format">
			<?php echo "&nbsp";?>
		</td>
		
		<td class="row_format">
			<?php echo "&nbsp ";?>
		</td>
		<td class="row_format">
			<?php echo "&nbsp";?> 
		</td>
		<td class="row_format" style="font-weight: bold;" align="right">
			<?php echo __("Total");?>
		</td>
		
		<td class="row_format" style="font-weight: bold;" align="right">
			<?php 
			 echo number_format($TotalAmount,2);
			?>
		</td>
	</tr>
</table>