<?php echo $this->Html->css(array('tooltipster.css','jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array('jquery.tooltipster.min.js','jquery.fancybox-1.3.4','inline_msg')); ?>
	 <!-- Add SheetJS Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

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
	height: 60px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

textarea {
   
    width: 80px;
}
.ui-datepicker-trigger{
float : unset;
}
</style>

<!--<?php  ?>-->
<div class="inner_title">
	<h3 style="float: left;">Advance Statement Report - <?php echo date('d/m/Y');?></h3>

<div style="float:right;">
<?php echo $this->Form->create(null,array('type'=>'GET','inputDefault'=>array('div'=>false)));?>
<table width="" cellpadding="0" cellspacing="5" border="0" class="tdLabel2" style="color:#b9c8ca;">
	<tr> 
		<td>
			<span>ge
				<input type="button" class="blueBtn sendmessage" name="Send Message" value="Send Message" id="send_message"> 
			</span>
		</td>
		<td>
			<span>
				<?php
				//echo $this->Form->create('Reports',array('action'=>'advance_bill_xls','type'=>'post', 'id'=> 'losxlsfrm', 'style'=> 'float:left;')); 
				//echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));
				echo $this->Form->input('generate_excel',array('class'=>'blueBtn','type'=>'submit','div'=>false,'label'=>false,'name'=>'format','value'=>'Generate Excel Report'));
				// /echo $this->Html->link(__('Generate Excel Report'),array('action'=>'advanced_billing','null','excel'),array('class'=>'blueBtn','div'=>false,'label'=>false))
				//echo $this->Form->end();
				?> 
			</span>
		</td>
	</tr>
</table>
</div>
<div class="clr"></div> 
<table>
	<tr>
		<td>Search by Patient </td><td>
			<?php echo $this->Form->input('lookup_name',array('div'=>false,'label'=>false,'type'=>'text','id'=>'lookup_name','value'=>$this->params->query['lookup_name']));
				 echo $this->Form->hidden('patient_id',array('div'=>false,'label'=>false,'id'=>'patient_id','value'=>$this->params->query['patient_id']));?>
		</td>
		  
	<td>
    <label>
        <?php
        echo $this->Form->checkbox('dialysis', array(
            'value' => '659',
            'hiddenField' => true,
            'checked' => !empty($this->request->query['dialysis']) && $this->request->query['dialysis'] == '659',
            'id' => 'onlyDialysis' // Unique ID for JavaScript targeting
        ));
        ?>
        Only Dialysis
    </label>
</td>
<td>
    <label>
        <?php
        echo $this->Form->checkbox('remove_dialysis', array(
            'value' => '659',
            'hiddenField' => true,
            'checked' => !empty($this->request->query['remove_dialysis']) && $this->request->query['remove_dialysis'] == '659',
            'id' => 'removeDialysis' // Unique ID for JavaScript targeting
        ));
        ?>
        Remove Dialysis
    </label>
</td>

<script>
    // JavaScript to handle mutual exclusivity
    document.getElementById('onlyDialysis').addEventListener('change', function () {
        if (this.checked) {
            document.getElementById('removeDialysis').checked = false;
        }
    });

    document.getElementById('removeDialysis').addEventListener('change', function () {
        if (this.checked) {
            document.getElementById('onlyDialysis').checked = false;
        }
    });
</script>

		<td>
			<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn')); ?>
		</td>
		
		<td>
			<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Billings','action'=>'advanced_billing'),array('escape'=>false, 'title' => 'refresh'));
			?>
		</td>

	</tr>
</table>
<?php echo $this->Form->end();?>


<!--<div>-->
<!--    <label for="filter">Filter:</label>-->
<!--    <select id="filter" onchange="filterData()">-->
<!--        <option value="all">Show All</option>-->
<!--        <option value="dialysis">Dialysis</option>-->
<!--    </select>-->
<!--</div>-->
<div class="clr"></div>	

<?php 
	//Calcualtions of lab charges and lab paid charges
	foreach($lab as $getLabData){
		$total_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']]=$total_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']]+$getLabData['LaboratoryTestOrder']['amount'];
		$total_paid_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']]=$total_paid_amount_lab[$getLabData['LaboratoryTestOrder']['patient_id']]+$getLabData['LaboratoryTestOrder']['paid_amount'];
		//$total_amount_lab=$total_amount_lab+$getLabData['TariffAmount'][$nursingServiceCostType];
	}
	
	//Calcualtions of rad charges and rad paid charges
	foreach($rad as $getRadData){
		$total_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']]=$total_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']]+$getRadData['RadiologyTestOrder']['amount'];
		$total_paid_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']]=$total_paid_amount_rad[$getRadData['RadiologyTestOrder']['patient_id']]+$getRadData['RadiologyTestOrder']['paid_amount'];
	}
	
	//surgery charge
	foreach($surgeriesData as $key => $surgery){
		$totalSurgeryAmount[$surgery['OptAppointment']['patient_id']]=$totalSurgeryAmount[$surgery['OptAppointment']['patient_id']]+$surgery['OptAppointment']['surgery_cost']+$surgery['OptAppointment']['anaesthesia_cost']+$surgery['OptAppointment']['ot_charges'];
	}
	//service charge including doctor and nursing charges
	
	$hospitalType = $this->Session->read('hospitaltype');
	if($hospitalType == 'NABH'){
		$nursingServiceCostType = 'nabh_charges';
	}else{$nursingServiceCostType = 'non_nabh_charges';
	}
	
	
	foreach($servicesData as $serviceKey =>$serviceValue){
			foreach($serviceValue as $amount){
				$service_tot[$serviceKey] = $service_tot[$serviceKey] + ($amount['cost']);
			}
	}
	
	//Pharmacy Charges "$pharmacy_charges array is addded for pharmacy charges"--Pooja
	
	//consultant  charge
	foreach($getconsultantData as $getconsultantData){
		$total_amount_consultant[$getconsultantData['ConsultantBilling']['patient_id']]=$total_amount_consultant[$getconsultantData['ConsultantBilling']['patient_id']]+$getconsultantData['ConsultantBilling']['amount'];
	} 
	foreach($patientID as $patient){
		$totalBillAmount[$patient]=$total_amount_lab[$patient]+$total_amount_rad[$patient]+
								$totalSurgeryAmount[$patient]+$service_tot[$patient]+
								$getconsultantData[$patient]+$doctorCharges[$patient]+$nursingCharges[$patient]+
								$patientWardCharges[$patient]+$total_amount_consultant[$patient]+ $covidPackageBill[$patient]['total_package_bill'] + $covidPackageBill[$patient]['total_ppe_bill'] + $covidPackageBill[$patient]['total_visit_bill'];
		if(strtolower($pharmacy_service_type)=='yes')
			$totalBillAmount[$patient]=$totalBillAmount[$patient]+$pharmacy_charges[$patient]['0']['total'];
		
	}
	
	
	foreach($advancePayment as $servicePaidDataKey =>$servicePaidDataValue){
		$singleAdvancePaid[$servicePaidDataValue['Billing']['patient_id']]=$singleAdvancePaid[$servicePaidDataValue['Billing']['patient_id']]+$servicePaidDataValue['Billing']['amount'];
	}
	foreach($patientID as $patient){
		$totalPaid[$patient]=$finaltotalPaid[$patient];		
	}
	foreach($patientID as $patient){
		$totalBal[$patient]=$totalBillAmount[$patient]-$totalPaid[$patient]-$totalDiscount[$patient];
	}
	
	foreach($advancePayment as $pay)
	{
		if(!empty($pay['Billing']['amount'])){
			$last_amount[$pay['Billing']['patient_id']] = $pay['Billing']['amount'];
			$last_date[$pay['Billing']['patient_id']] = $pay['Billing']['date'];	
		}		
	
	}
	/*debug($totalBal);
	debug($last_amount);exit;*/
	$i=0;
	
	/*- debug($total_amount_lab);
	debug($total_amount_rad);
	debug($totalSurgeryAmount);
	debug($service_tot);
	debug($pharmaTotal);
	debug($total_amount_consultant);
	debug($totalBillAmount);
	debug($totalPaid);
	debug($totalBal); */
	
	
	//for refunded amount
	/*if($discountData['FinalBilling']['refund']=='1'){
		$totalRefund=$discountData['FinalBilling']['paid_to_patient'];
		$totalBal=$totalBal+$totalRefund;
	}else{
		$totalRefund='0';
		$totalBal=$totalBal+$totalRefund;
	}
	//EOF for refunded amount
	
	if($discountData['FinalBilling']['discount_type']=='Percentage'){
		$discountAmount=$discountData['FinalBilling']['discount'];
		$perVar=($discountData['FinalBilling']['discount'])/100;
		$discountVal=ceil(($discountData['FinalBilling']['total_amount'])*$perVar);
		$discauntedBal=$discountData['FinalBilling']['total_amount']-$discountVal;
	}else{
		$discountVal=$discountData['FinalBilling']['discount'];
		$discauntedBal=$discountData['FinalBilling']['total_amount']-$discountVal;
		$discountAmount=$discountData['FinalBilling']['discount'];
	}*/
?>


</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0" >
<tr>
<td>

</td>
</tr>
</table>
<!--<button id="downloadExcel">Download as Excel</button>-->
<table width="100%" cellpadding="0" cellspacing="1"  id="myTable" border="0"class="tabularForm">
<tr>
<thead>
		<th width="45px;" valign="top" align="center" style="text-align:center;">BED</th>
		<th width="87px;" valign="top" align="center" style="text-align:center;">PATIENT DETAILS</th>
		<th width="10px;" valign="top" align="center" style="text-align:center;">PATIENT TYPE</th>
		<th width="100px;" valign="top" align="center" style="text-align:center;">Package Day </th>
		<th width="78px;" valign="top" align="center" style="text-align:center;">CONSULTANT</th>
		<th width="91px;" valign="top" align="center" style="text-align:center;">DIAGNOSIS</th>
		<th width="77px;" valign="top" align="center" style="text-align:center;">Plannned Surgery or Procedure And Cost of Surgery</th>
		<th width="61px;" valign="top" align="center" style="text-align:center;">TOTAL BILL AS ON DATE</th>
		<th width="57px;" valign="top" align="center" style="text-align:center;">ADVANCE TILL DATE</th>
		<th width="63px;" valign="top" align="center" style="text-align:center;">Last Payment And Date</th>
		<th width="92px;" valign="top" align="center" style="text-align:center;">BALANCE</th>
		<th width="68px;" valign="top" align="center" style="text-align:center;">DETAIL OF DIFFERENCE BILL AMOUNT</th>
		<th width="81px;" valign="top" align="center" style="text-align:center;">PHARMACY PATHOLOGY</th>
		<th width="79px;" valign="top" align="center" style="text-align:center;">Amount asked to pay today
		<br><br><span><input type="checkbox" id="selectall" /> Select All<div id="alertMsg" align="center" style="color:green;font-size:18px;float:none;" ></div></span> </th>
		<th width="81px;" valign="top" align="center" style="text-align:center;">LIKELY DISCHARGE DATE</th>
		<th width="92px;" valign="top" align="center" style="text-align:center;">REMARKS</th>
		<th width="46px;" valign="top" align="center" style="text-align:center;">FINALI-SATION</th>
		<th width="46px;" valign="top" align="center" style="text-align:center;">PRIVATE PACKAGE</th>
		
</thead>
</tr>
	<?php 
	$i=0;
	foreach($results as $result)
     {     	
     	/*debug('lab='.$total_amount_lab[$result['Patient']['id']].'--+--'.
     	'rad='.$total_amount_rad[$result['Patient']['id']].'--+--'.
     	'surgery='.$totalSurgeryAmount[$result['Patient']['id']].'--+--'.
     	'service='.$service_tot[$result['Patient']['id']].'--+--'.
     	'pharmacy='.$pharmaTotal[$result['Patient']['id']].'--+--'.
     	'consultation='.$getconsultantData[$result['Patient']['id']]
     	.'--+-- doctor='.$doctorCharges[$result['Patient']['id']].'--+-- nurse='.$nursingCharges[$result['Patient']['id']]
     	.'--+-- ward='.$patientWardCharges[$result['Patient']['id']]);*/
     	?>
     	
	<TR>
	
	
			<?php /*$col='';
			if(empty($result['Patient']['id'])){
					$col="colspan='15'";
     		}else{
					$col='align="center"';
    		 }*/?>
		<td width="53" align="center" <?php echo $col;?>>
		<?php echo $result['Room']['bed_prefix']."<br>";
		     echo "Bed-".$result['Bed']['bedno'];?>
		</td>
		<?php if(empty($result['Patient']['id'])){
		 echo "<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		";
		}else
		?>
		<?php if($result['Patient']['id']){?>
		
		<td width="95" align="center">
		<?php   
		     echo $result['Patient']['lookup_name']."<br>";
		     echo $result['Patient']['admission_id']."<br>";
		     echo $result['Person']['district']."<br>";
		     echo $result['Person']['mobile']."<br>";
			 echo $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format'))."<br>";
		     echo $result['TariffStandard']['name']; ?>

		     <?php if($result['Person']['vip_chk']=='1'){
				echo $this->Html->image("vip.png", array("alt" => "VIP", "title" => "VIP"));
				}?>
		</td>
		<td>
			<?php if($result['Person']['vip_chk']=='1'){
					echo "20%";
				}else{
					echo  "80%";
				}?>
		</td>
		<td>
		<!-- Print package date here -->
		
        <?php 
            $patient_id = $result['Patient']['id'];
            if (isset($dates[$patient_id])) {
                $package_number = 1; // पैकेज नंबर शुरू करें
                foreach ($dates[$patient_id] as $entry) {
                    echo "Package " . $package_number . ": " . $entry['day_label'] . "<br>"; // पैकेज नंबर और दिन का लेबल प्रिंट करें
                    $package_number++; // अगला पैकेज नंबर
                }
            } else {
                echo "No package";
            }
            ?>
		</td>
		
		
		<td width="88" align="center">
			<?php 
			
			echo $result['User']['first_name']."<br>";
			echo $result['User']['last_name'];
			?>
		</td>
		
		<td width="101" align="center">
			<?php echo $this->Form->input('final_diagnosis',array('id'=>'final_'.$result['Patient']['id'].'_'.$result['Diagnosis']['id'],'type'=>'textarea','label'=>false,'rows'=>'1','cols'=>'1','class'=>'diagnosis_save','value'=>$result['Diagnosis']['final_diagnosis']));?>
			<?php echo  $this->Form->input('', array('type' => 'checkbox', 'id' => 'icd_'.$result['Patient']['id'],'class'=>'icd', 'label' => false, 'div' => false, 'error' => false, 'hiddenFields' => false))."ICD10" ; ?>
			
			<span id="showTxtBox_<?php echo $result['Patient']['id'];?>" style="display: none">
			
			<?php echo $this->Form->input('icdName',array('div'=>false,'label'=>false,'type'=>'text','id'=>'icdName_'.$result['Patient']['id'].'_'.$result['Diagnosis']['id'],'class'=>'icdName'));
				 echo $this->Form->hidden('ICD_code',array('div'=>false,'label'=>false,'id'=>'ICD_code_'.$result['Patient']['id']));?></span>
		</td>
	
		<!--<td width="122" align="right">
		<?php 
		     foreach ($surgeriesData as $surgery)
		  {
			if($result['Patient']['id'] == $surgery['OptAppointment']['patient_id'])
			{
				$name = $surgery['Surgery']['name'];
			}
			else
			{
				$name = " ";
			}
		  }
				 echo $this->Form->input('surgery_name',array('id'=>'surgery_'.$result['Patient']['id'],
					'type'=>'textarea','label'=>false,'rows'=>'1','cols'=>'1','class'=>'surgery_name',
					'value'=>$name))."<br>";
			echo $this->Number->currency(ceil($totalSurgeryAmount[$result['Patient']['id']]));
		     ?>
		</td>-->
		
		<td width="122" align="center">
		    <?php
                    echo $this->Form->input('surgery_text', array(
                        'id' => 'surgery_text' . $result['Patient']['id'],
                        'type' => 'textarea',
                        'label' => false,
                        'rows' => '4',
                        'cols' => '30',
                        'class' => 'surgery_text',
                        'style' => 'width:100%; border:1px solid #ccc; padding:5px;  min-height: 50px !important;',
                        'value' => isset($result['Patient']['surgery_text']) ? $result['Patient']['surgery_text'] : '' 
                    ));
                    ?>
		<?php 
		$surgeriesCost=0;
		     foreach ($surgeriesData as $surgery)
		  {
				if($result['Patient']['id'] == $surgery['OptAppointment']['patient_id'])
				{
					echo $surgery['Surgery']['name']."<br>";
					$surgeryCost=$surgery['OptAppointment']['surgery_cost']+$surgery['OptAppointment']['anaesthesia_cost']+$surgery['OptAppointment']['ot_charges'];
					echo $this->Number->currency(ceil($surgeryCost))."<br>";
					$surgeriesCost=0;
				}
			}
		     ?>
		</td>
		
        <td width="71" align="right">
        <?php echo $this->Html->link($this->Html->image('icons/plus_6.png',array()),'#',
					array('style'=>'','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printReceipt',
					$result['Patient']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
        
        <?php /*echo $this->Html->link($this->Html->image('icons/plus_6.png',array()),array('controller'=>'Billings','action'=>'printReceipt',$result['Patient']['id'],'admin'=>false),
				array('escape' => false,'title'=>'Generate Receipt'))*/"<br>";
               echo $this->Number->currency(ceil($totalBillAmount[$result['Patient']['id']]));?>
		</td>

		<td width="64" align="center">
		<?php echo $this->Html->link($this->Html->image('icons/active.png'),array('controller'=>'Billings','action'=>'multiplePaymentModeIpd',$result['Patient']['id'],'admin'=>false),
				array('escape' => false,'title'=>'Advance Payment','target'=>'_balnk'));
				/*debug($advancePayment);exit;
				foreach($advancePayment as $pay)
					{
						if($result['Patient']['id'] == $pay['Billing']['patient_id'])
						{
							if(!empty($pay['Billing']['amount'])){
								$last_amount = $pay['Billing']['amount'];
								$last_date = $pay['Billing']['date'];
							}
						}
					}*/
				echo $this->Number->currency(ceil($totalPaid[$result['Patient']['id']]));
				//unset($pay_amount);
				?>
		</td>

		<td width="70" align="center">
			<?php echo $this->Number->currency(ceil($last_amount[$result['Patient']['id']]))."<br>";
			  	  echo $this->DateFormat->formatDate2Local($last_date[$result['Patient']['id']],Configure::read('date_format'));
			  	  ?>
		</td>
		

		<td width="100" align="right" text-align="center"> 
		
			<?php  $balance = $totalBal[$result['Patient']['id']]; ?>
		
		<table cellspadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="left">
					<?php if($balance<14000)echo $this->Html->image('icons/greenblink.gif',array());
			
							elseif($balance>=14000 && $balance<=25000 )
							{
								echo $this->Html->image('icons/yellowblink.gif',array());
							}
							else echo $this->Html->image('icons/redblink.gif',array());
					?>
				</td>
				<td align="right"><?php echo $this->Number->currency(ceil($balance));?></td>
				</tr>
		</table>
		</td>
		
		<?php 	
				$rad_amt = 0;
				$lab_amt = 0;
				$othnm = $result['OtherService']['service_name'];		//other service name
				$othamt = $result['OtherService']['service_amount'];	//amount
			  	
			 	//consultant amount
			 	foreach($result['ConsultantBilling'] as $key=>$value)
				{
					$val[] = $result['ConsultantBilling'][$key]['amount'];
				}
				
					$total=0;
						if(is_array($val))
						{
							foreach($val as $tot)
							{
								$total = $tot+$total;
							}
						}
					
				//service name and amount	
				$service_tot = 0;
				foreach($servicesData as $serve)
			 	{
					 if($result['Patient']['id'] == $serve['ServiceBill']['patient_id'] && (!empty($serve['TariffAmount']['non_nabh_charges'])))
					 {
					 	$service_tot = $service_tot + $serve['TariffAmount']['non_nabh_charges'];//." ".$serve['ServiceBill']['no_of_times'];
					 }
				}
				
				//radiology amount and laboatory amount
				foreach($rad as $key=>$radio)
				{
					if($result['Patient']['id']==$radio['RadiologyTestOrder']['patient_id'])
					{
						$rad_amt=  $rad_amt + $radio['TariffAmount']['non_nabh_charges'];	//radiology amount
					}
				}
				foreach($lab as $labo)
				{
					if($result['Patient']['id']==$labo['LaboratoryTestOrder']['patient_id'])
					{
						$lab_amt = $lab_amt + $labo['TariffAmount']['non_nabh_charges'];	//laboatory amount
					}
				}
				$path = $rad_amt+$lab_amt;	//total amount of radiology and laboratory
			
				$total_amount = $othamt + $service_tot + $total + $path ;
			?>
		
		<?php
			
			//for differance total amount
			if(!empty($total_amount))
			{
				 $totalAmount = ("Diff.=".$total_amount."(");
			}
		
			//for other service name and amount
			if(!empty($othnm))
			{
				$othnm;
			}
			if(!empty($othamt))
			{
				"=".$othamt."+";
			}
			$sername = array();
			//$seramt =array();
			//for service name and amount	
			foreach($servicesData as $serve)
		 	{
				 if($result['Patient']['id'] == $serve['ServiceBill']['patient_id'] && (!empty($serve['TariffAmount']['non_nabh_charges'])))
				 {
				 	$sername[] = $serve['TariffList']['name'].'=';
				 	$sername[] = $serve['TariffAmount']['non_nabh_charges'].'+';//." ".$serve['ServiceBill']['no_of_times'];
				 	 
				 }
			}
			unset($service_tot);
	
			//for consultant amount
			if(!empty($total))
			{
				$conso = "Con= ".$total."+";
			}
			unset($val);

			//for pathelogy amount
			if(!empty($path))
			{
				$patha = "Path=".$path;
			}
		?>
		<?php //$tooltip  ='Diff.('.($total).'='.$othnm.'='.$othamt.'+'.implode("=",$sername).'+'.implode("+",$seramt); ?>
		<?php $tooltip  = $totalAmount.$othnm.$othamt.implode($sername).$conso.$patha; ?>
		
		
		<td width="80" style="text-align: center;" >
			<table>
				
				<tr>
					<td>
						<?php //Pic
		
		 echo $this->Html->link($this->Html->image('icons/plus_6.png',array()),array('controller'=>'Billings','action'=>'multiplePaymentModeIpd',$result['Patient']['id'],'admin'=>false),array('escape' => false,'title'=>'Advanced Billing','target'=>'_balnk'));?>
					</td>
					<td class="tdLabel " id="boxSpace" ><?php $tooltip = '';
						 echo $this->Html->image('icons/view-icon.png',array('onclick'=>"getDiffAmount(".$result['Patient']['id'].");",'escape' => false));?>	
					</td>
				</tr>
			</table>
		
		 		
		</td>

		<td width="127"align="right">
			<?php
			echo ceil($pharmacy_charges[$result['Patient']['id']][0]['total']-$pharPaid[$result['Patient']['id']]);
		echo "/"."<br>";
		
		echo $this->Number->currency(ceil($total_amount_lab[$result['Patient']['id']]));
		unset($rad_amt);
		unset($lab_amt);
		?>
		
		</td>

		<td width="137" align="center"
			style="text-align: center">
			<?php 
			$todayPayAmt=$balance+Configure::read('advanceAmtAdd');
			echo $this->Form->input('amount_to_pay_today', array('id'=>'amount_to_pay_today_'.$result['Patient']['id'],'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 95%;",'class'=>'clickMeToaddAmount','value'=>!empty($result['Patient']['amount_to_pay_today'])?$result['Patient']['amount_to_pay_today']:$todayPayAmt));
			/****BOF-Mahalaxmi-For Sms facility*******/////
			$totalBillAmountForSms = $totalBillAmount[$result['Patient']['id']];
		//	echo $this->Form->hidden('totalBillAmtForSms',array('id'=>'totalBillAmtForSms_'.$result['Patient']['id'],'class'=>'totalBillAmtForSmsCls','value'=>$totalBillAmountForSms));
			/****EOF-Mahalaxmi-For Sms facility*******/////
			if($result['TariffStandard']['name']=='Private'){?>
			<span>
				<input class="checkbox1"  type="checkbox" name="check[]" id="<?php echo "chk_".$result['Patient']['id'];?>" value="<?php echo $totalBillAmountForSms;?>">
			</br>
				<?php if($result['Patient']['sms_sent']){ 
					$getSmsDateTime1=$this->DateFormat->formatDate2Local($result['Patient']['advance_sms_sent_date_time'],Configure::read('date_format'),false);
					$getSmsDateTime=$this->DateFormat->formatDate2Local($result['Patient']['advance_sms_sent_date_time'],Configure::read('date_format'),true);
					//debug($getSmsDateTime1);
					$getSmsDateTimeExp=explode(" ",$getSmsDateTime);
					//debug($getSmsDateTimeExp);
					?>
			<font color="RED">SMS Sent. </font><font color="GREEN"><?php if(!empty($result['Patient']['advance_sms_sent_date_time'])){
					echo  "(".$getSmsDateTime1." ".date('h:i A', strtotime($getSmsDateTimeExp[1])).")";
				}?></font>
			<?php //}else{?>
			
			<?php }?>
			</span>
			<?php }?>
		</td>
		<td width="200" align="center"><!-- Likely discharge date -->
		<?php $dod = $this->DateFormat->formatDate2Local($result['Patient']['likely_discharge_date'],Configure::read('date_format'),false);?>
			<?php echo $this->Form->input('likely_discharge_date',array('id'=>'dod_'.$result['Patient']['id'],'type'=>'text','label'=>false,'class'=>'dod','style'=>'width : 66px',
					'div'=>false,'value'=>$dod));?>
		</td>
	  <td width="99" align="justify" style="padding: 10px; vertical-align: top;">
                    <?php
                    $remark = isset($result['Patient']['remark']) ? trim($result['Patient']['remark']) : '';
                    $unwantedTexts = ['Package amount Rs.', '/-', '<br>', "\r", "\n"];
                    $remark = str_replace($unwantedTexts, '', $remark);
                    $remarkDisable = ($result['Patient']['tariff_standard_id'] == $rgjayID || $result['Patient']['tariff_standard_id'] == $rgjayOnToday) ? 'disabled' : '';
                    echo $this->Form->input('remark', [
                        'disabled' => $remarkDisable,
                        'id' => 'remark_' . $result['Patient']['id'],
                        'type' => 'textarea',
                        'label' => false,
                        'rows' => '2',
                        'cols' => '30',
                        'class' => 'add_remark',
                        'style' => 'width:100%; border:1px solid #ccc; padding:5px; border-radius:4px; min-height: 70px !important',
                        'value' => $remark
                    ]);
                    ?>
                </td>
		<td width="73" align="center">
		<?php //echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Advance Billing')),'#',
     		//array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'reports','action'=>'printAdvanceBill','admin'=>false,
     		//$result['Patient']['id']))."', '_blank',
           //'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
           
	<?php echo $this->Html->link($this->Html->image('icons/plus_6.png',array()),array('controller'=>'Billings','action'=>'multiplePaymentModeIpd',$result['Patient']['id'],'admin'=>false),
				array('escape' => false,'title'=>'Finalization of Invoice','target'=>'_balnk'));?>
	</td>
	<td><?php
	if(strtolower($result['TariffStandard']['name']) == 'private' && $result['Patient']['is_packaged'] == 0){
	
	 echo $this->Html->link($this->Html->image('icons/plus_6.png',array()),array('controller'=>'Estimates','action'=>'packageEstimate','null',$result['Patient']['person_id'],'?'=>array('patientId'=>$result['Patient']['id'],'admittedPatient'=>'1'),'admin'=>false),
				array('escape' => false,'title'=>'Private Package'));
     } ?></td>
<!-- '<?php //echo $this->Html->url(array('controller'=>'Estimates','action'=>'packageEstimate'));?>'+'/null/'+$(this).attr('person_id')+'/?patientId='+$(this).attr('patient_id'); -->
	</TR>
	<?php }?>
	<?php unset($pay_amount);?>
	<?php } ?>
	
	
</table>
<input type="button" class="blueBtn sendmessage" name="Send Message" value="Send Message" id="send_message">
<script>
			
			$( document ).ready(function () {
			$('.tooltip').tooltipster({
		 		interactive:true,
		 		position:"right", 
		 	});
		 	});
 	
 	
           jQuery(document).ready(function()
		   {
			$('.diagnosis_save').blur(function()
			{
			var patient = $(this).attr('id') ;
			
			splittedId = patient.split("_"); 
			patient_id=splittedId[1]
			newId = splittedId[2];
			if(newId=='')
				newId='null';

			var val = $(this).val();
			var icdCode= $('#ICD_code_'+patient_id).val();
			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getDiagnosis", "admin" => false));?>"+"/"+patient_id+"/"+newId,
			data:"diagnosis="+val+"&icdCode="+icdCode,
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success: function(data){
				$('#busy-indicator').hide();
			}
			});
			}
			);	
				
			
			/*$('.surgery_name').blur(function()
			{
			var patient = $(this).attr('id') ;
			splittedId = patient.split("_");
			newId = splittedId[1];
			var val = $(this).val();

			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'reports', "action" => "getSurgery", "admin" => false));?>"+"/"+newId+"/"+val,

			beforeSend:function(data){
			$('#busy-indicator').show();
			},

			success: function(data){
			$('#busy-indicator').hide();
			}

			});
			}
			);	*/
						
				
			$('.add_remark').blur(function()
			{
			var patient = $(this).attr('id') ;
			splittedId = patient.split("_");
			newId = splittedId[1];
			var val = $(this).val();
			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getRemark", "admin" => false));?>"+"/"+newId,
			data:"remark="+val,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success: function(data){
				$('#busy-indicator').hide();
			} 
			});
			}
			);
			$(".dod").datepicker({
				showOn : "both",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				buttonText: "Calendar",
				changeMonth : true,
				changeYear : true,
				yearRange: '-100:' + new Date().getFullYear(),
				minDate : new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					var patient = $(this).attr('id') ;
					splittedId = patient.split("_");
					newId = splittedId[1];
					var val = $(this).val();
					$.ajax({
						url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "setExpectedDateOfDischarge", "admin" => false));?>"+"/"+newId,
						data:"likely_discharge_date="+val,
						
						beforeSend:function(data){
							$('#busy-indicator').show();
						},
						success: function(data){
							$('#busy-indicator').hide();
						} 
					});
				}
			});
			
			
			$('.clickMeToaddAmount').blur(function()
			{
			var patient = $(this).attr('id') ;
			splittedId = patient.split("_");
			newId = splittedId[4];
			var val = $(this).val();
			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "getTodayPayment", "admin" => false));?>"+"/"+newId+"/"+val,

			beforeSend:function(data){
			$('#busy-indicator').show();
			},

			success: function(data){
			$('#busy-indicator').hide();
			}
			});
			}
			);

				/*$(function() {

	                var $sidebar   = $(".top-header"), 
	                    $window    = $(window),
	                    offset     = $sidebar.offset(),
	                    topPadding = 0;

	                $window.scroll(function() {
	                    if ($window.scrollTop() > offset.top) {
	                        /*$sidebar.stop().animate({
	                            top: $window.scrollTop() - offset.top + topPadding
	                        });*/

	                       /* $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
	                    } else {
	                        $sidebar.stop().animate({
	                            top: 0
	                        });
	                    }
	                });
	                
	            });*/

 });
			function getDiffAmount(patient_id){
	       		
	       		$.fancybox({
	       		'width' : '70%',
	       		'height' : '40%',
	       		'autoScale': true,
	       		'transitionIn': 'fade',
	       		'transitionOut': 'fade',
	       		'type': 'iframe',
	       		'href': "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "diffAmountDetail")); ?>"+'/'+patient_id,
	       		
	       		});
	       		$(document).scrollTop(0);
	       		return false ;
	       		}

		  

           $('#selectall').click(function(event) {  //on click
               if(this.checked) { // check select status
            	   var chk1Array=[];var tCount=0;
            	   var amtValArray=[];
                   $('.checkbox1').each(function() {//loop through each checkbox
                  //     this.checked = true;  //select all checkboxes with class "checkbox1"      
                 /*      checkId=this.id;   
                       console.log(checkId);                 
            	   	   val =$("#"+checkId).val();
            	   	   chk1Array.push(val);  
            	   	   console.log(chk1Array);*/
            	   //*********BOF-For Save Amt-Mahalaxmi	   
            	 /*  	var valAmtId = $('.clickMeToaddAmount').attr('id') ;	
            	   	splittedId = valAmtId.split("_");
        			newId = splittedId[4];
            	    var amt=$('#amount_to_pay_today_'+newId).val();  	  
            	    amtValArray.push(amt);   */
            	    this.checked = true;
                	   checkId=this.id;                	   	 
              	   	   splitedId=checkId.split('_');
              	   var patientIdnew=splitedId['1'];
              	   var amtnew=$('#amount_to_pay_today_'+patientIdnew).val();  	             	  
              	   	var patientIdnew = patientIdnew.concat("_");       
              	   	var res = patientIdnew.concat(amtnew);   	   	   
              	   	 chk1Array.push(res);	 
                   });
               
                   $.ajax({
              			url : "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "getTodayPaymentForSms", "admin" => false));?>",
              			type: 'POST',
               			data: "chk1Array="+chk1Array,
               			dataType: 'html',
              			beforeSend:function(data){
              			$('#busy-indicator').show();
              			},

              			success: function(data){
              			$('#busy-indicator').hide();
              			}
              			});   
                   //*********EOF-For Save Amt-Mahalaxmi	  
               }else{
                   $('.checkbox1').each(function() { //loop through each checkbox
                       this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                   });        
               }
           });

         //If one item deselect then button CheckAll is UnCheck
           $(".checkbox1").click(function () {             
               if (!$(this).is(':checked')){                
                   $("#selectall").attr('checked', false);
               }else{      
            	   var chkId = $(this).attr('id') ; 
            	   splittedId = chkId.split("_");
					newId = splittedId[1];    					
    	   			 var val=$('#amount_to_pay_today_'+newId).val();  			
   					$.ajax({
   						url : "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "getTodayPayment", "admin" => false));?>"+"/"+newId+"/"+val,

   						beforeSend:function(data){
   						$('#busy-indicator').show();
   					},
   						success: function(data){
   						$('#busy-indicator').hide();
   						
   					}
   				});
               }
           });

           	$('.sendmessage').click(function(){
        	    var chk1Array=[];var tCount=0;        	  
        	    $(".checkbox1:checked").each(function () {
          	   	checkId=this.id;          	   	 
          	   	splitedId=checkId.split('_');
          	   	val =$("#"+checkId).val();
          	   	var patientId = splitedId['1'].concat("_");       
          	   	var res = patientId.concat(val);   	   	   
          	   	 chk1Array.push(res);
          	   	 
          	});
        	   //array of id of selected chkboxes to send message
        	 
        	   	$.ajax({
           			url : "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "sendToSmsMultiplePatient", "admin" => false));?>",
           			type: 'POST',
           			data: "chk1Array="+chk1Array,
           			dataType: 'html',
           			beforeSend:function(data){
           				$('#busy-indicator').show();
           			},
           			success: function(data){ 	
							
       						//$('#alertMsg').fadeOut(5000);  			   			
						 location.reload();
						 var alertId = $('#alertMsg').attr('id') ; 
						// $('#alertMsg').show().html('SMS sent successfully.');
						 inlineMsg(alertId,'SMS sent successfully.');	
						  $('#busy-indicator').hide();
						  
						  $("#selectall").attr('checked', false);
						  
						
           			}
           			});       
                });

           $("#lookup_name").autocomplete({
       	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no",'is_discharge=0',"admin" => false,"plugin"=>false)); ?>", 
       		select: function(event,ui){
        			$("#patient_id").val(ui.item.id);
       		},
       		messages: {
       	         noResults: '',
       	         results: function() {},
       	  	}
       	});

           $('.icdName').autocomplete({
               
               source: "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "diagnosisAutocomplete", "admin" => false, "plugin" => false)); ?>",
              // setPlaceHolder : false,
               select:function(event,ui){
                    var strVal=$(this).attr('id');
                    splittedId = strVal.split("_");
              		patientId = splittedId[1];
              		var upperValue = $("#final_"+splittedId[1]+"_"+splittedId[2]).val();
              		$("#ICD_code_"+patientId).val(ui.item.icd10Code);
              		//$("#final_"+patientId).val(ui.item.value);
              		upperValue = upperValue +" "+ ui.item.value;
              		$("#final_"+splittedId[1]+"_"+splittedId[2]).val('');
              		$("#final_"+splittedId[1]+"_"+splittedId[2]).val(upperValue);
              		$("#final_"+splittedId[1]+"_"+splittedId[2]).focus();
              		  
               }, 
               messages: {
                   noResults: '',
                   results: function() {}
               }
           });
           
           $('.icd').click(function(){	
               var icdData= $(this).attr('id');	
           		splittedId = icdData.split("_");
           		patientId = splittedId[1];
               if($("#icd_"+patientId).is(':checked')){	
                   $("#showTxtBox_"+patientId).show();
                   $("#icdName_"+patientId).focus();
               }else{
            	   $("#showTxtBox_"+patientId).hide();
                   
               }
           });
        
          
</script>


<!-- JavaScript -->
<script>
    function filterData() {
        // Get the selected filter value
        var filter = document.getElementById("filter").value.toLowerCase();

        // Get all rows from the table body
        var rows = document.querySelectorAll("#dataTable tbody tr");

        // Loop through all rows and filter data
        rows.forEach(function(row) {
            // Get the content of the specific column
            var bedDetails = row.cells[0].textContent.toLowerCase();

            // Check if the row matches the filter
            if (filter === "all" || bedDetails.includes(filter)) {
                row.style.display = ""; // Show row
            } else {
                row.style.display = "none"; // Hide row
            }
        });
    }
</script>
<script>
    document.getElementById('downloadExcel').addEventListener('click', function () {
    // Table ko Excel mein Convert karein
    var table = document.getElementById('myTable');
    var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });

    // Excel File Download karein
    XLSX.writeFile(wb, "TableData.xlsx");
});
</script>