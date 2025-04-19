<style>
	 
	.boxBorder{border:1px solid #3E474A;}
	.boxBorderBot{border-bottom:1px solid #3E474A;}
	.boxBorderRight{border-right:1px solid #3E474A;}
	.tdBorderRtBt{border-right:1px solid #3E474A; border-bottom:1px solid #3E474A;}
	.tdBorderBt{border-bottom:1px solid #3E474A;}
	.tdBorderTp{border-top:1px solid #3E474A;}
	.tdBorderRt{border-right:1px solid #3E474A;}
	.tdBorderTpBt{border-bottom:1px solid #3E474A; border-top:1px solid #3E474A;}
	.tdBorderTpRt{border-top:1px solid #3E474A; border-right:1px solid #3E474A;}
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
</style>
<div id="printButton" >
		<?php echo $this->Html->link('Print',"#",array('escape'=>true,'class'=>'blueBtn','onclick'=>'window.print();'))?>
	</div>
	<div class="clr"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px;">
<tr><td>
&nbsp;</td>
</tr>

<tr><td align="right">

</td>
</tr>
<tr>
    <td width="100%" align="center" valign="top" class="heading">ESTIMATE INVOICE</td>
  </tr>
</table>

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder">
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
         <table width="800" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="370" align="left" valign="top">Name Of Patient</td>
    <td width="10" valign="top">:</td>
    <td valign="top"><?php echo $patientData['Initial']['name'].' '.$patientData['EstimatePatient']['first_name'].' '.$patientData['EstimatePatient']['last_name'];?></td>
  </tr>
  <tr>
    <td width="370" align="left" valign="top">Date</td>
    <td width="10" valign="top">:</td>
    <td valign="top"><?php echo date('d-m-Y');?></td>
  </tr>
  
  <?php $addressStr =  $patientData['EstimatePatient']['plot_no'];
	  
	  		if($patientData['EstimatePatient']['taluka'] != ''){
	  			$addressStr .= $patientData['EstimatePatient']['taluka'].'<br>';
	  		}
	   
	        if($patientData['EstimatePatient']['city'] !=''){
	              $addressStr .= $patientData['EstimatePatient']['city'].'<br />';
	        }
	        if($patientData['EstimatePatient']['district'] !=''){ 
	              $addressStr .= "Dist.-".$patientData['EstimatePatient']['district'].'<br />';
	        }
	  if(!empty($addressStr)){
	  ?>
	  <tr>
	    <td align="left" valign="top">Address</td>
	    <td valign="top">:</td>
	    <td valign="top"> </td>
	  </tr> 
	  <?php } ?>
   
</table>
    </td>
  </tr>
  
  
  <tr>
    <td width="100%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="3" class="tdBorderTpBt">
          <tr>
          	<td width="50" align="center" class="tdBorderRtBt">Sr. No.</td>
          	<td width="80" align="center" class="tdBorderRtBt">MOA Sr. No.</td>
            <td width="" align="center" class="tdBorderRtBt">Item</td>
            <td width="80" align="center" class="tdBorderRtBt">CGHS Code No.</td>
            <td width="65" align="center" class="tdBorderRtBt">Rate</td>
            <td width="65" align="center" class="tdBorderRtBt">Qty.</td>
            <td width="100" align="center" class="tdBorderBt">Amount</td>
          </tr>
          
          <?php 
          	$hospitalType = $this->Session->read('hospitaltype');
		  	$totalNursingCharges=0;$srNo=0;$totalCost=0;
	    	if($hospitalType == 'NABH'){
				 $nursingServiceCostType = 'nabh_charges';
		  	}else{
		  		 $nursingServiceCostType = 'non_nabh_charges';
		  		
		  	}
		   	foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){
		   		
				$resetNursingServices[$nursingServicesCost['TariffList']['name']]['qty'][] = //$nursingServicesCost['EstimateServiceBill']['morning']+
																							//$nursingServicesCost['EstimateServiceBill']['evening']+
																							//$nursingServicesCost['EstimateServiceBill']['night'] +
																							$nursingServicesCost['EstimateServiceBill']['no_of_times'];
																							
				$resetNursingServices[$nursingServicesCost['TariffList']['name']]['cost'] = $nursingServicesCost['TariffAmount'][$nursingServiceCostType];
				$resetNursingServices[$nursingServicesCost['TariffList']['name']]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
				$resetNursingServices[$nursingServicesCost['TariffList']['name']]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code'];
			}
			foreach($resetNursingServices as $resetNursingServicesName=>$nursingService){
				$srNo++;
          ?>
          <tr>
          	<td align="center" valign="top" class="tdBorderRt"><?php echo $srNo;?></td>
          	<td align="center" valign="top" class="tdBorderRt"><?php  
          	if($nursingService['moa_sr_no']!='')
            	echo $nursingService['moa_sr_no'];
            else echo '&nbsp;';
            ?></td>
            <td class="tdBorderRt"><?php echo $resetNursingServicesName;?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            if($nursingService['nabh_non_nabh']!='')
            	echo $nursingService['nabh_non_nabh'];
            else echo '&nbsp;';
            //echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][nabh_non_nabh]",'value' => $nursingService['nabh_non_nabh'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php echo $nursingService['cost'];?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            $totalUnit = array_sum($nursingService['qty']);
            if($totalUnit<1) $totalUnit=1;
            echo $totalUnit;
            ?></td>
            <td align="right" valign="top"><?php 
            echo $this->Number->format($totalUnit*$nursingService['cost'],
		  			array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		  	$totalNursingCharges = $totalNursingCharges + ($totalUnit*$nursingService['cost']);		
            ?></td>
          </tr>
         
        <?php }?>
        
        
        <?php foreach ($cCArray as $cBilling){ 
	          foreach($cBilling as $consultantBillingDta){
	          	foreach($consultantBillingDta as $consultantBilling){
	          		$srNo++;?>
        	<tr>
          	<td align="center" valign="top" class="tdBorderRt"><?php echo $srNo;?></td>
          	<td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="left" valign="top" class="tdBorderRt"><?php 
            echo $consultantBilling[0]['ServiceCategory']['name'];
	            	echo '<br>&nbsp;&nbsp;<i>'.$consultantBilling[0]['Consultant']['first_name'].' '.$consultantBilling[0]['Consultant']['last_name'].'</i> ';
	            	$sDate = explode(" ",$consultantBilling[0]['EstimateConsultantBilling']['date']);
	            	$lRec = end($consultantBilling);
	            	$eDate = explode(" ",$lRec['EstimateConsultantBilling']['date']);
	   				echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['EstimateConsultantBilling']['date'],Configure::read('date_format')).' - '.$this->DateFormat->formatDate2Local($lRec['EstimateConsultantBilling']['date'],Configure::read('date_format')).')';
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php echo $consultantBilling[0]['TariffList']['cghs_code'];?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            echo $this->Number->format($consultantBilling[0]['EstimateConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php echo count($consultantBilling);?></td>
            <td align="right" valign="top" class="tdBorderRt">
            <?php 
            echo $this->Number->format(($consultantBilling[0]['EstimateConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            $totalCost = $totalCost + ($consultantBilling[0]['EstimateConsultantBilling']['amount']*count($consultantBilling));
            ?>
            </td>
          	</tr>
          <?php }
	          	}
	          	}?>
	          	
	          	
	          	<?php foreach ($cDArray as $cBilling){ 
	          foreach($cBilling as $consultantBillingDta){
	          	foreach($consultantBillingDta as $consultantBilling){
	          		$srNo++;?>
        	<tr>
          	<td align="center" valign="top" class="tdBorderRt"><?php echo $srNo;?></td>
          	<td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="left" valign="top" class="tdBorderRt"><?php 
            echo $consultantBilling[0]['ServiceCategory']['name'];
	            	echo '<br>&nbsp;&nbsp;<i>'.$consultantBilling[0]['DoctorProfile']['doctor_name'].'</i> ';
            	$sDate = explode(" ",$consultantBilling[0]['EstimateConsultantBilling']['date']);
            	$lRec = end($consultantBilling);
            	$eDate = explode(" ",$lRec['EstimateConsultantBilling']['date']);
   				echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['EstimateConsultantBilling']['date'],Configure::read('date_format')).' - '.$this->DateFormat->formatDate2Local($lRec['EstimateConsultantBilling']['date'],Configure::read('date_format')).')';
   	
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php echo $consultantBilling[0]['TariffList']['cghs_code'];?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            echo $this->Number->format($consultantBilling[0]['EstimateConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php echo count($consultantBilling);?></td>
            <td align="right" valign="top" class="tdBorderRt">
            <?php 
            echo $this->Number->format(($consultantBilling[0]['EstimateConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            $totalCost = $totalCost + ($consultantBilling[0]['EstimateConsultantBilling']['amount']*count($consultantBilling));
            ?>
            </td>
          	</tr>
          <?php }
	          	}
	          	}?>
          
         <?php if($labCharges!='' && $labCharges > 0){?>
          <?php $srNo++;?>
          <tr>
          	<td align="center" valign="top" class="tdBorderRt"><?php echo $srNo;?></td>
          	<td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="left" valign="top" class="tdBorderRt">Laboratory Charges</td>
            <td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">--</td>
            <td align="center" valign="top" class="tdBorderRt">--</td>
            <td align="right" valign="top" class="tdBorderRt"><?php echo $labCharges;?></td>
          </tr>
          <?php }?>
          
          <?php if($radCharges!='' && $radCharges > 0){?>
          <?php $srNo++;?>
          <tr>
          	<td align="center" valign="top" class="tdBorderRt"><?php echo $srNo;?></td>
          	<td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="left" valign="top" class="tdBorderRt">Radiology Charges</td>
            <td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">--</td>
            <td align="center" valign="top" class="tdBorderRt">--</td>
            <td align="right" valign="top" class="tdBorderRt"><?php echo $radCharges;?></td>
          </tr>
          <?php }?>
          
          
          <?php $otherServicesCharges=0;?>
          <?php foreach($otherServicesData as $otherService){
          			$srNo++;
          	?>
          <tr>
          	<td align="center" valign="top" class="tdBorderRt"><?php echo $srNo;?></td>
          	<td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="left" valign="top" class="tdBorderRt"><?php echo $otherService['EstimateOtherService']['service_name'];?></td>
            <td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt"><?php echo $otherService['EstimateOtherService']['service_amount'];?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php echo '1';?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            echo $otherService['EstimateOtherService']['service_amount'];
            $otherServicesCharges = $otherServicesCharges + $otherService['EstimateOtherService']['service_amount'];
            ?></td>
          </tr>
          <?php }?>
          
          
          <!-- 
          <tr>
          	<td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
          	<td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="left" valign="top" class="tdBorderRt"></td>
            <td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt"></td>
          </tr>
          -->
        <?php $totalCost = $totalCost + $totalNursingCharges + $labCharges + $radCharges + $otherServicesCharges;?>
          
          <tr>
          	<td align="center" valign="top" class="tdBorderTpRt">&nbsp;</td>
          	<td align="center" valign="top" class="tdBorderTpRt">&nbsp;</td>
            <td align="left" valign="top" class="tdBorderTpRt"><strong>Total</strong></td>
            <td align="center" valign="top" class="tdBorderTpRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
            <td align="center" valign="top" class="tdBorderTpRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderTp totalPrice"><strong><span class="WebRupee"></span><?php echo $this->Number->format(ceil($totalCost),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></strong></td>
          </tr>
          
       </table>   
  </td>
  </tr>
  
  <tr>
    <td width="100%" align="left" valign="top" class="tdBorderTp">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" class="boxBorderRight columnPad">
            	Amount Chargeable (in words)<br />
				<strong><?php echo $this->RupeesToWords->no_to_words(ceil($totalCost));?></strong>            </td>
            	<td width="292">
            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<!-- 
                	<tr>
                    	<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Advance Paid</td>
                        <td align="right" valign="top" class="tdBorderBt"><?php //echo $this->Number->format(ceil($finalBillingData['FinalBilling']['amount_paid']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
                    </tr>
                     -->
                    
                    <tr>
                	  <td height="20" valign="top" class="tdBorderRtBt">&nbsp;To Pay</td>
                	  <td align="right" valign="top" class="tdBorderBt"><?php echo $this->Number->format(ceil($totalCost),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
               	  </tr>
                  
               	  
              </table>
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="columnPad">
    	<table width="" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td height="18" align="left" valign="top">Hospital Service Tax No.</td>
              	<td width="15" align="center" valign="top">:</td>
                <td align="left" valign="top"><strong><?php echo $this->Session->read('hospital_service_tax_no');?></strong></td>      
      		</tr>
        	<tr>
        	  <td height="20" align="left" valign="top">Hospitals PAN</td>
        	  <td align="center" valign="top">:</td>
        	  <td align="left" valign="top"><strong><?php echo $this->Session->read('hospital_pan_no');?></strong></td>
      	  </tr>
        	<tr>
        	  <td height="20" align="left" valign="top"><strong>Signature of Patient :</strong></td>
        	  <td align="center" valign="top">&nbsp;</td>
        	  <td align="left" valign="top">&nbsp;</td>
      	  </tr>
   	  </table>
    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="55%" class="columnPad boxBorderRight">&nbsp;
            </td>
            <td width="45%" align="right" valign="bottom" class="columnPad tdBorderTp">
            	<strong><?php echo $this->Session->read('billing_footer_name');?></strong><br /><br /><br />
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td width="85">Bill Manager</td>
                        <td width="65">Cashier</td>
                        <td width="80">Med.Supdt. </td>
                        <td align="right">Authorised Signatory</td>
                	</tr>
                </table>
            </td>
          </tr>
        </table>
    </td>
  </tr>
  
</table>

 <?php echo $this->Form->end(); ?>               	  
 <table width="800"  cellspacing="3" cellpadding="3" border="0" align="center">
<tr><td align="right">
						<?php 
    	echo $this->Html->link(__('Cancel'),array('action' => 'dischargeBill',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0px'));
    
    ?>
                	  
                	  

</td></tr>



</table>