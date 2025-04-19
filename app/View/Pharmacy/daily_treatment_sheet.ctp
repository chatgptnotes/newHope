<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" moznomarginboxes mozdisallowselectionprint>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
	<?php echo __('Hope', true); ?>
	</title>
	<?php echo $this->Html->css('internal_style.css');?>  
	<style>

	@media print {
  		#printButton{display:none;}
  		 .printbreak {
			page-break-after:  always;
		}

		div.page
      {
        page-break-after: always;
        page-break-inside: avoid;
      }
    }

    .printbreak {
		page-break-after:  always;
	}
	.width25{width: 25% !important}
</style>
</head>
	<body style="background:none;width:98%;margin:auto;">
	
		<table border="0" class="" cellpadding="0" cellspacing="0" width="100%">
		
		<tr>
			  <td colspan="3" align="right">
			  <div id="printButton">
			  <?php 
			   		echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();'));
			  ?>
			  </div>
		 	 </td>
	 	</tr>
	 	</table>
	 	
	<?php foreach ($dailyTreatment as $key => $value) { 

				foreach ($packageDates as $cost => $dateVal) { 
					$packageStart = $dateVal['package_start_date'];
					$packageEnd = $dateVal['package_end_date'];
					if (($key >= $packageStart) && ($key <= $packageEnd)){
					    $packageCost = $cost ;
					}
					
				}
				
		?>
		<div class="page">

	 	<table border="1" class="" cellpadding="5" cellspacing="0" width="100%">

 			<tr class="">
				<td style="font-size: 20px;font-family:Times New Roman, Georgia, Serif;text-align: center;font-weight: bold;padding-bottom: 0% " colspan="4"><u>TREATMENT SHEET </u></td>
			</tr>
	 		<tr>
	 			<td>Name Of the Patient : </td><td><strong><?php echo $patientData['Patient']['lookup_name']; ?></strong></td>
	 		</tr>

	 		<tr>
	 			<td>Reg. No: :<?php echo  $patientData['Patient']['patient_id']; ?> </td><td>Date of Admission:<?php echo date('d/m/Y',strtotime($patientData['Patient']['form_received_on'])); ?></td>
	 		</tr>

	 		<tr>
	 			<td colspan="3">Special Instruction</td>
	 		</tr>

	 		<tr>
	 			<td>Diet: </td><td>Consultant :<?php echo $value[0]['User']['first_name']." ".$value[0]['User']['last_name']; ?></td>
	 		</tr>
	 		<tr>
	 			<td colspan="3">Diagnosis</td>
	 		</tr>

	 		<tr>
	 			<td colspan="3">Date : <strong><?php echo date('d/m/Y',strtotime($key)) ?> </strong></td>
	 		</tr>
	 		<tr>
	 			<td colspan="4"><b>Intensive care services : Patient is in ICU/critical care room/ private Room with critical care services /general. The patient was on nasal oxygen, High flow mask- oxygen/ NIV/ Invasive ventilator. Blood transfusion was given/ not given<b></td>
	 		</tr>
	 		<tr>
	 			<td colspan="4">
	 				<table border="1" class="" cellpadding="5" cellspacing="0" width="100%">
	 						<tr>
	 							<td><strong>Sr.No</strong></td>
	 							<td><strong>Name of Medicine</strong></td>
	 							<td><strong>Route</strong></td>
	 							<td><strong>Dose</strong></td>
	 							<td><strong>Time- Nurses Signature</strong></td>
	 							<td><strong></strong></td>
	 						</tr>

	 						<?php 
	 						$doseArray = array('1'=>'OD','2'=>'BD','3'=>'TDS','4'=>'QID');
	 						foreach ($value as $subKey => $precscription) {  ?>
				 			<tr>
				 				<td><?php echo $subKey+1; ?></td>	
	 							<td><?php echo $precscription['PharmacyItem']['name']; ?></td>
	 							<td>&nbsp;</td>
	 							<td><?php /*if($doseArray[$precscription['PharmacySalesBillDetail']['qty']] == 'OD'){
	 								echo $precscription['PharmacySalesBillDetail']['administration_time'];
	 							}else{*/
	 								echo $doseArray[$precscription['PharmacySalesBillDetail']['qty']];
	 						//	}
	 							 ?></td>
	 							<td><table  border="1" class="" cellpadding="2" cellspacing="0" width="100%">
	 								<tr>
	 									<?php if($doseArray[$precscription['PharmacySalesBillDetail']['qty']] == 'OD'){ ?>
		 									<td class="width25">6 AM</td>
		 									<td class="width25"></td>
		 									<td class="width25"></td>
		 									<td class="width25"></td>
	 									<?php }else if($doseArray[$precscription['PharmacySalesBillDetail']['qty']] == 'BD'){ ?>
		 									<td class="width25">6 AM</td>
		 									<td class="width25"></td>
		 									<td class="width25"></td>
		 									<td class="width25">6 PM</td>
	 									<?php }else if($doseArray[$precscription['PharmacySalesBillDetail']['qty']] == 'TDS'){ ?>
	 										<td class="width25">6 AM</td>
		 									<td class="width25">2 PM</td>
		 									<td class="width25">&nbsp;</td>
		 									<td class="width25">10 PM</td>
 										<?php }else if($doseArray[$precscription['PharmacySalesBillDetail']['qty']] == 'QID'){ ?>
 											<td class="width25">6 AM</td>
		 									<td class="width25">12 PM</td>
		 									<td class="width25">6 PM</td>
		 									<td class="width25">12 AM</td>
	 									<?php }else{ ?>
 											<td class="width25">&nbsp;</td>
		 									<td class="width25">&nbsp;</td>
		 									<td class="width25">&nbsp;</td>
		 									<td class="width25">&nbsp;</td>
										<?php } ?>
	 								</tr>
	 							</table></td>
	 							<td><?php if(!empty($doseArray[$precscription['PharmacySalesBillDetail']['qty']])){
	 								echo "Medication Administered";
	 							} ?></td>
	 							
				 			</tr>
	 		<?php } ?>
 					</table>
	 			</td>
	 		</tr>
	 	</table>
		<table border="1" class="" cellpadding="5" cellspacing="0" width="100%">
	 		<tr>
	 			<td><strong>Fluid</strong></td>
	 			<td><strong>Rate</strong></td>
	 			<td><strong>Other Instruction</strong></td>
	 		</tr>
			<tr>
	 			<td>&nbsp;</td>
	 			<td>&nbsp;</td>
	 			<td>&nbsp;</td>
	 		</tr>
	 		<tr>
	 			<td></td>
	 			<td></td>
	 			<td>Signature/Name of Doctor : <strong><?php echo $value[0]['User']['first_name']." ".$value[0]['User']['last_name'] ?></strong>   ,    Date/Time:<strong><?php echo date('d/m/Y',strtotime($key))." "."06.00 am" ?>   </strong>                                                                                             </td>
	 		</tr>
	 	</table>
	 	<?php if($packageCost == '4000' || $packageCost == '7500') { ?>
	 	<table border="1" class="" cellpadding="5" cellspacing="0" width="100%">
	 		<tr>
	 			<td><p>This patient required supplemental oxygen therapy using High Flow Nasal Cannula (HFNC) and critical care. The patient was maintaining saturation of ____ percent with ______ litres of oxygen</p></td>
	 			
	 		</tr>
			
	 	</table>
	 <?php } ?>
	 <?php if($packageCost == '9000') { ?>
	 	<table border="1" class="" cellpadding="5" cellspacing="0" width="100%">


	 		<tr>
	 			<td><p>This patient required to be on a Non Invasive Ventilator today after developing respiratory signs of pneumonia. Patient required the modality because of the presence of comorbidities such as COPD. He was maintaining saturation of __percent. The parameters of NIV are IPAP-_____, EPAP_______.ventilation mode, (volume, pressure or dual),Spontaneous Mode, IPAP-20, EPAP-10.modality (controlled, assisted, support ventilation), Non Invasive Support</p></td>
	 			
	 		</tr>

	 		<tr>
	 			<td><p>This patient required to be on Ventilator today:
						The patient was maintaining saturation of ____-percent. The parameters to program in mechanical ventilation 
						are the ventilation mode, (volume, pressure or dual),_____________ 
						modality (controlled, assisted, support ventilation), ____________
						and respiratory parameters are</p></td>
	 			
	 		</tr>
			
	 	</table>
	 <?php } ?>
	</div>


	 <?php } ?>	

 			
	  	
	  	<div style="padding-top: 5px;"></div>
		  
		  
	</body>
</html>
	  