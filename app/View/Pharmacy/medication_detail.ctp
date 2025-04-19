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
		<td colspan="6" align="Center" class="titleFont" style="font-weight: 10px;"><?php echo __("HOPE MULTISPECIALITY HOSPITAL & RESEARCH CENTER");?></td>
		</tr>
		<tr>
		<td colspan="6" align="center" class="titleFont"><?php echo __("PHARMACY STATEMENT");?></td>
		</tr>
		<tr>
		<td colspan="6" align="center"  class="titleFont"> <?php echo $patientName;?></td>
		</tr>
		<tr>
		<td colspan="6" align="center"  class="titleFont"> <?php echo __("List Of Issued Drugs From : ")."".$fromDate.(" To ").$endDate;?></td>
		</tr>
		<tr class="row_title">
			<td class="row_format" style="font-weight: bold;"><?php echo __("Sr.No."); ?></td>
			<td class="row_format" style="font-weight: bold;"><?php echo __("Service Name"); ?></td>
			<td class="row_format" align="center" style="font-weight: bold;"><?php echo __("Date");?></td>
			<td class="row_format" align="center" style="font-weight: bold;"><?php echo __("Quantity");?></td>
			<td align="right" ><?php echo __("Amount"); ?></td>
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
		<td class="row_format">
			<?php echo $cnt;?>
		</td>
		
		<td class="row_format">
			<?php if ($data['PharmacyItem']['generic']) {
				$productName = $data['PharmacyItem']['generic'];
			} else {
				$productName = $data['PharmacyItem']['name'];
			}
				echo $productName;
			 ?>
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

</html>

<script type="text/javascript">

$(document).ready(function() {
	$("#printId").click(function(){
		("#printContaint").hide();
		("#printId").hide();
	}); 
});
	
</script>
	