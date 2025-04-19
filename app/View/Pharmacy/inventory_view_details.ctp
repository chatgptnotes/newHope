<style>
	.row_yellow{
		 background-color:#C1BA7C;
	    border-top: 1px solid #000;
	    margin: 0;
	    padding: 7px 3px;
	}
	.leftBorder{
		border-left-color:#C1BA7C;
	}
	.titleFont{
		font-size:19px;
		font-weight:bold;
		/* color:#3185bd; */ 
		
	}
	.table_changeFormat td {
    font-size: 17px;
    padding-bottom: 3px;
    padding-right: 10px;
	}
	@media print {
		#printId {
		display: none;
		}
	}
</style>

<html moznomarginboxes mozdisallowselectionprint>

	<div class="inner_title" style="padding:15px;" id="printContaint">
		<span><?php	
			//echo $this->Html->link(__('Back'), array('action' => 'pharmacy_details','sales','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
		?>
		<span style="padding:35;" > 
		<?php echo $this->Form->create('',array('id'=>'content-form','type'=>'GET','id'=>''));?>
		<!-- <input  id="printId" type="button" class="blueBtn" value="Print" onClick="window.print()"> -->
		<?php echo $this->Form->submit(__('Generate Excel'),array('style'=>'padding:0px;','name'=>'excel','class'=>'blueBtn','id'=>'ExcelGenerate','div'=>false,'label'=>false)); ?> 
		<!-- <input  id="printId" type="button" class="blueBtn" value="Print" onClick="window.print()"> -->
		</span>
	</div> 

<!--  <table class="table_format" style="padding-top:0;" cellpadding="0" cellspacing="0" width="60%" align="center">
	<tr>		
		<td style="font-size:15px;color:#3185bd;" width="20%" ><?php echo __("Patient Name :"); ?></td>
		<td style="font-size:15px;color:#315a69;" width="20%" ><?php echo $allData[0]['Patient']['lookup_name']; ?></td>
		<td style="font-size:15px;color:#3185bd;" width="20%"><?php echo __("Admission Id :"); ?></td>
		<td style="font-size:15px;color:#315a69;" width="20%"><?php echo $allData[0]['Patient']['admission_id']; ?></td>
		<td style="font-size:15px;color:#3185bd;" width="20%"><?php //echo  ?></td>
		
	</tr>
	<tr >
		<td style="font-size:15px;color:#3185bd;" width="20%"><?php echo __(" Admission Date :");?></td>
		<td style="font-size:15px;color:#315a69;" width="20%"><?php echo $this->DateFormat->formatDate2Local($allData[0]['Patient']['form_received_on'],Configure::read('date_format'),false);?></td>
		<td style="font-size:15px;color:#3185bd;" width="20%"><?php echo __("Patient Tariff :"); ?></td>
		<td style="font-size:15px;color:#315a69;" width="20%"><?php echo $tariffName['TariffStandard']['name']; ?></td>
		<td></td>
	</tr>
</table>
-->
<?php //debug($allData); 
    $fromDate = $this->DateFormat->formatDate2Local($allData[0]['Patient']['form_received_on'],Configure::read('date_format'),false);
    if(!empty($allData[0]['Patient']['discharge_date'])){
    	 $currentDate = $this->DateFormat->formatDate2Local($allData[0]['Patient']['discharge_date'],Configure::read('date_format'),false);
    }else{
    	 $currentDate = date("d/m/Y"); 
    }
    $fromDate = $this->DateFormat->formatDate2Local($allData[0]['Patient']['form_received_on'],Configure::read('date_format'),false);
    $admissionId = $allData[0]['Patient']['admission_id'];
    $tarrifName = $tariffName['TariffStandard']['name'];
    $patientName = $allData[0]['Patient']['lookup_name'];
    $initial = $initialName['PatientInitial']['name'];

   
 ?>
<table class="table_changeFormat" style="padding-top:0;" align="center" cellpadding="0" cellspacing="0" width="90%" border="1">
	<thead>
		<tr>
		<td colspan="6" align="Center" class="titleFont" style="font-weight: 10px;"><?php echo __("HOPE HOSPITAL PHARMACY");?></td>
		</tr>
		<tr>
		<td colspan="6" align="center" class="titleFont"><?php echo __("List Of Pharmacy Sale Bills from : ").$fromDate.__(" TO ").$currentDate;?></td>
		</tr>
		<tr>
		<td colspan="6" align="center"  class="titleFont"> <?php echo $admissionId."(".$tarrifName.")".$initial." ".$patientName;?></td>
		</tr>
		<tr class="row_title">
			<td class="row_format"><?php echo __("Date"); ?></td>
			<td align="center" class="row_format"><?php echo __("Bill No"); ?></td>
			<td align="right" class="row_format"><?php echo __("Debit");?></td>
			<td align="right" class="row_format"><?php echo __("Credit");?></td>
			<!--<td class="row_format"><?php echo __("Discount");?></td>
			<td class="row_format"><?php echo __("Refund");?></td>-->
			<td align="right"><?php echo __("Balance"); ?></td>
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

</html>

<script type="text/javascript">
$(document).ready(function() {
	$("#printId").click(function(){
		("#printContaint").hide();
	});

	$(".editDate").blur(function(){
		var id = $(this).attr('id'); 
		splitedvar = id.split("_");
		ID = splitedvar[1]; 
		var afterEdit = $(this).text(); 
		//$("#editableDate_"+ID).val(afterEdit);
		var splitDate = afterEdit.split("/"); 
		
		$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'Pharmacy', "action" => "saveEditableDate", "inventory" => false));?>"+"/"+ID+"/"+splitDate,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
				<?php //echo $this->Html->image('/ajax-loader.gif') ?>	
			},
			
			success: function(data){ 
						$('#busy-indicator').hide();
						$('#editableDate_'+ID).val(afterEdit);

			     }
			});
	});
});

</script>
	