<?php 
#echo $finalBillingData['FinalBilling']['discharge_date'];exit;
#echo $totalWardCharges;exit;
?>
<style>
	body{margin:0px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#E7EEEF;}
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px;">
<tr><td>
&nbsp;</td>
</tr>

<tr><td align="right">
<?php if(isset($finalBillingData['FinalBilling']['discharge_date'])){?>
<?php 
echo $this->Html->link('Print','#',
			 array('class'=>'grayBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".html_entity_decode($this->Html->url(array('admin' => false, 'action'=>'printSavedReceipt',$patient['Patient']['id']),true))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400,width:800,height:800');  return false;"));
   	
  // echo $this->Html->link(__('Print'),array('action' => 'printReceipt',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
   ?>
<?php }

	if($patient['Patient']['admission_type']=='IPD'){ 
  		$dynamicText = 'discharge' ;
  	}else{ 
  		$dynamicText = 'completion of OPD process' ;
  	}	

?>
</td>
</tr>
<tr>
    <td width="100%" align="center" valign="top" class="heading">FINAL INVOICE</td>
  </tr>
</table>
 <?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'saveGenerateReceipt','type' => 'file','id'=>'ConsultantBilling','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('Billing.patient_id',array('value'=>$patient['Patient']['id']));
echo $this->Form->hidden('Billing.bill_number',array('value'=>$billNumber)); 			
			?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder">
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
         <table width="800" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="370" align="left" valign="top">Name of Patient</td>
    <td width="10" valign="top">:</td>
    <td valign="top"><?php echo $patient['Patient']['lookup_name'];?></td>
  </tr>
  <?php if($person['Person']['name_of_ip']!=''){?>
  <tr>
    <td align="left" valign="top">Name of the I. P.</td>
    <td valign="top">:</td>
    <td valign="top"><?php //echo $patient['Patient']['lookup_name'];
			//echo $this->Form->input('Billing.name_of_ip',array('value'=>$person['Person']['name_of_ip'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'name_of_ip','style'=>'width:150px;'));
			echo $person['Person']['name_of_ip'];
			?></td>
  </tr>
  <?php } ?>
  <?php if($person['Person']['relation_to_employee']!=''){?>
  <tr>
    <td align="left" valign="top">Relation with I. P.</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    //echo $this->Form->input('Billing.relation_to_employee',array('value'=>$person['Person']['relation_to_employee'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'relation_to_employee','style'=>'width:150px;'));
    $relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
    echo $relation[$person['Person']['relation_to_employee']];
    ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td align="left" valign="top">Age/Sex</td>
    <td valign="top">:</td>
    <td valign="top"><?php
    	echo $person['Person']['age']."/".ucfirst($person['Person']['sex']);
    ?></td>
  </tr> 
  <tr>
    <td align="left" valign="top">Address</td>
    <td valign="top">:</td>
    <td valign="top"> <?php echo $address;?></td>
  </tr>
  <?php if($person['Person']['insurance_number']!='' || $person['Person']['executive_emp_id_no']!='' || $person['Person']['non_executive_emp_id_no']!=''){?>
  <tr>
    <td align="left" valign="top">Insurance Number/Staff Card No/Pensioner Card No.</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    if($person['Person']['insurance_number']!=''){
    	echo $person['Person']['insurance_number'];
    }elseif($person['Person']['executive_emp_id_no']!=''){
    	echo $person['Person']['executive_emp_id_no'];
    }elseif($person['Person']['non_executive_emp_id_no']!=''){
    	echo $person['Person']['non_executive_emp_id_no'];
    }
    ?></td>
  </tr>
  <?php }?>
  <?php if(!empty($patient['Patient']['date_of_referral'])){ ?>
	  <tr>
	    <td align="left" valign="top">Date of Referral</td>
	    <td valign="top">:</td>
	    <td valign="top"><?php 
	    //$dateOfReferral = explode(" ",$patient['Patient']['date_of_referral']);
	    if($patient['Patient']['date_of_referral']!='')
	         echo	  	$this->DateFormat->formatDate2Local($patient['Patient']['date_of_referral'],Configure::read('date_format'));
	    ?></td>
	  </tr>
  <?php } ?>
  <tr>
    <td align="left" valign="top"><?php echo __("Date Of MRN");?></td>
    <td valign="top">:</td>
    <td valign="top"><?php $admissionDate = explode(" ",$patient['Patient']['form_received_on']);
                   	  	  	echo 
                   	  	  	$this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></td>
  </tr>
  <?php if($finalBillingData['FinalBilling']['discharge_date']!=''){ ?>
  <tr>
    <td align="left" valign="top">Date Of <?php echo $dynamicText ;?></td>
    <td valign="top">:</td>
    <td valign="top"><?php  
              
   if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
	   	$splitDate = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
	   	echo $this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'),true);
   }
   ?></td>
  </tr>
  <?php }if(!empty($finalBillingData['FinalBilling']['patient_discharge_condition'])){ ?>
  <tr>
    <td align="left" valign="top">Condition of the patient at <?php echo $dynamicText ;?></td>
    <td valign="top">:</td>
    <td valign="top"><?php 
   		 echo $finalBillingData['FinalBilling']['patient_discharge_condition'];
    ?></td>
  </tr>
  <?php }if(!empty($billNumber)){ ?>
  <tr>
    <td align="left" valign="top">Invoice No.</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $billNumber;?></td>
  </tr>
  <?php } ?>
  <tr>
    <td align="left" valign="top"><?php echo __("MRN");?></td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $patient['Patient']['admission_id'];?></td>
  </tr>
  <?php if($corporateEmp!=''){
  		$hideCGHSCol = '';
  		if(strtolower($corporateEmp) == 'private'){
  			$hideCGHSCol = 'none' ;
  		}
  ?>
  <tr>
    <td align="left" valign="top">Category</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $corporateEmp;?></td>
  </tr>
  <?php } if(!empty($primaryConsultant[0]['fullname'])) { ?> 
  <tr>
    <td align="left" valign="top">Primary Consultant</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $primaryConsultant[0]['fullname']; 
				?></td>
  </tr>
  <?php }if(!empty($finalBillingData['FinalBilling']['credit_period'])){ ?>
  <tr>
    <td align="left" valign="top">Credit Period (in days)</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $finalBillingData['FinalBilling']['credit_period'];
   ?></td>
  </tr>
  <?php }if(!empty($finalBillingData['FinalBilling']['other_consultant'])){ ?>
  <tr>
    <td align="left" valign="top">Other Consultant Name</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    echo $finalBillingData['FinalBilling']['other_consultant'];?></td>
  </tr>
  <?php } ?>
  <?php if(!empty($finalBillingData['FinalBillingOption'])){
			$count = 0 ;
			foreach($finalBillingData['FinalBillingOption'] as $finalOptions){
				$newHtml =  '<tr>';
				$newHtml .= '<td valign="top" align="left">' ;
				$newHtml .= ucfirst($finalOptions['name']);
				$newHtml .= '</td>' ;
				$newHtml .= '<td valign="top">:</td>';
				$newHtml .= '<td valign="top">';
				$newHtml .= ucfirst($finalOptions['value']);
			 	$newHtml .= '</td>';
				$newHtml .= '</tr>';
				echo $newHtml  ;
				$count++ ;  
			} 
	}
	?> 
</table>
    </td>
  </tr>
  
  <tr><td><table width="100%" cellpadding="5" cellspacing="0" border="0">
  <?php if($patient['Diagnosis']['final_diagnosis']!=''){?>
            	<tr>
                	<td valign="top">
                	Diagnosis<br />
                    <?php echo $patient['Diagnosis']['final_diagnosis'];?>
                    </td>
                </tr>
                <?php }?>
                <?php if(!empty($surgeriesData)){?>
                 <tr>
                	<td valign="top">
                	Surgeries<br />
                    <?php 
                    $b=1;
                	foreach($surgeriesData as $surg){
                    	if($b==1 && $surg['Surgery']['name']!=''){ 
                    		echo $b.'. '.$surg['Surgery']['name'];
                    		$b++;
                    	}
                    	else if($surg['Surgery']['name'] != ''){
                    		echo ', '.$b.'. '.$surg['Surgery']['name'];
                    		$b++;
                    	}
                    }
   
  ?>
                    </td>
                </tr>
                <?php }?>
            </table></td></tr>
  
  <tr>
    <td width="100%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="3" class="tdBorderTpBt">
          <tr>
          	<td width="50" align="center" class="tdBorderRtBt">Sr. No.</td>
          	<td width="80" align="center" class="tdBorderRtBt">MOA Sr. No.</td>
            <td width="" align="center" class="tdBorderRtBt">Item</td>
            <td width="80" align="center" class="tdBorderRtBt" style="display:<?php echo $hideCGHSCol ;?>">CGHS Code No.</td>
            <td width="65" align="center" class="tdBorderRtBt">Rate</td>
            <td width="65" align="center" class="tdBorderRtBt">Qty.</td>
            <td width="100" align="center" class="tdBorderBt">Amount</td>
          </tr>
         <?php if($patient['Patient']['payment_category']!='cash'){?> 
          <tr>
          	<td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong></td>
          	<td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong></td>
            <td class="tdBorderRt" style="font-size:12px;">&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong></td>
            <td align="right" valign="top" class="tdBorderRt">&nbsp;</td> 
            <td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong></td>
          </tr>
         <?php }?>
         <?php $srNo=1;?> 
           <?php foreach($savedBillingData as $billingData){
           #pr($billingData);exit;
           if($billingData['SettlementBilling']['name']!=''){
           	?>
          <tr>
          <td class="tdBorderRt" align="center"><?php echo $srNo;
          $srNo++;
          ?></td>
          <td class="tdBorderRt" align="center"><?php echo $billingData['SettlementBilling']['moa_sr_no']?></td>
            <?php 
            if($billingData['SettlementBilling']['unit']==''){?>
            	<td class="tdBorderRt" style="font-size:12px;"><strong><i>
            	<?php echo $billingData['SettlementBilling']['name'];?></i></strong>
            <?php }else{?>
            <td class="tdBorderRt">
            	<?php echo $billingData['SettlementBilling']['name'];
           		} 
            
            if(isset($billingData['SettlementBillingOption']) && !empty($billingData['SettlementBillingOption']) && $billingData['SettlementBilling']['name']!='Nursing Charges'){
           		foreach($billingData['SettlementBillingOption'] as $billingOptions){
           			//if($billingOptions['rate']=='' && $billingOptions['amount']==''){
           				echo '<br><i>'.$billingOptions['name'].'</i>';	
           			//}
           		}
            } 
            ?>  
            </td>
            <td class="tdBorderRt" align="center" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $billingData['SettlementBilling']['nabh_non_nabh']?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php echo $billingData['SettlementBilling']['rate'];?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php echo $billingData['SettlementBilling']['unit'];?></td>
            
            <td align="right" valign="top"><?php 
            
            	if(is_numeric($billingData['SettlementBilling']['amount']))
            		echo $this->Number->format($billingData['SettlementBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            	else
            		echo $billingData['SettlementBilling']['amount'] ; 
            	
            	?></td>
          </tr>
          <?php }
           if(isset($billingData['SettlementBillingOption']) && !empty($billingData['SettlementBillingOption'])){
           		foreach($billingData['SettlementBillingOption'] as $billingOptions){ 
           			if($billingOptions['rate']!='' && $billingOptions['amount']!='' && $billingOptions['name']!='' && $billingOptions['unit']!=''){
           				
           				?>
           				<tr>
           	<td class="tdBorderRt" align="center"><?php echo $srNo;
           	$srNo++;
           	?></td>			
           	<td class="tdBorderRt" align="center"><?php echo $billingOptions['moa_sr_no']?></td>
            <td class="tdBorderRt"><?php echo $billingOptions['name'];?></td>
            <td align="center" valign="top" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $billingOptions['nabh_non_nabh']?></td>
            <td align="right" valign="top" class="tdBorderRt" ><?php echo $billingOptions['rate'];?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php echo $billingOptions['unit'];?></td>
            
            <td align="right" valign="top"><?php 
            	if(is_numeric($billingOptions['amount']))
            		echo $this->Number->format($billingOptions['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            	else
            		echo $billingOptions['amount'] ;
            		?>
            		</td>
          </tr>
           			<?php }
           		}
             } 
           }?>
          
          <tr>
          	<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
          	<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderTpRt"><strong>Total</strong></td>
            <td align="right" valign="top" class="tdBorderTpRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
           
            <td align="right" valign="top" class="tdBorderTp totalPrice"><strong><span class="WebRupee"></span><?php echo $this->Number->currency(ceil($finalBillingData['FinalBilling']['total_amount']));?></strong></td>
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
				<strong><?php echo $this->RupeesToWords->no_to_words(ceil($finalBillingData['FinalBilling']['total_amount']));?></strong>            </td>
            	<td width="292">
            	<table width="100%" cellpadding="2" cellspacing="0" border="0">
                	<tr>
                    	<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Advance Paid</td>
                        <td align="right" valign="top" class="tdBorderBt"><?php echo $this->Number->currency(ceil($finalBillingData['FinalBilling']['amount_paid']));?></td>
                    </tr>
                    
                    <?php 
                    if(isset($finalBillingData['FinalBilling']['discount_rupees']) && $finalBillingData['FinalBilling']['discount_rupees'] !=''){
                        	$discountAmount = $finalBillingData['FinalBilling']['discount_rupees'];
                    }else{
                        	$discountAmount=0;
                    }
                    if($discountAmount != '' && $discountAmount!=0){
                    ?> 
	                    <tr>
		                	  <td height="20" valign="top" class="tdBorderRtBt">&nbsp;Discount</td>
		                	  <td align="right" valign="top" class="tdBorderBt"><?php  
	                	  			echo $this->Number->currency(ceil($discountAmount));
	                	  		?>
	                	  	  </td>
	               	  </tr> 
	               	  <tr>
	                	  <td height="20" valign="top" class="tdBorderRtBt">&nbsp;Reason for Discount</td>
	                	  <td align="right" valign="top" class="tdBorderBt"><?php 
	                	    echo $finalBillingData['FinalBilling']['reason_for_discount'];
	                	  ?>
	                	  </td>
	               	  </tr> 
                   <?php } 
                   
                   		$creditAmt = 0 ;
                   		foreach($finalBillingData['DiscountByCredit'] as $arrKey=>$arrValue){
                   			$creditAmt += $arrValue['discount_by_credit'] ;
	                        if(!empty($arrValue['discount_by_credit'])){
	                    	?> 
		                    <tr>
			                	  <td height="20" valign="top" class="tdBorderRtBt">&nbsp;Credit Voucher<br/>&nbsp;
			                	  <?php echo  $this->DateFormat->formatDate2Local($arrValue['date'],Configure::read('date_format'),true); ?></td>
			                	  <td align="right" valign="top" class="tdBorderBt">
			                	  	<?php  
		                	  			echo $this->Number->currency(ceil($arrValue['discount_by_credit']));
		                	  		 ?>
		                	  	  </td>
		               	   </tr> 
		               	   <tr>
		                	  <td height="20" valign="top" class="tdBorderRtBt">&nbsp;Reason</td>
		                	  <td align="right" valign="top" class="tdBorderBt"><?php 
		                	    echo nl2br($arrValue['reason_for_credit_voucher']);
		                	  ?>
		                	  </td>
		               	  </tr> 
	                   <?php } //EOF IF
                   		} //EOF foreach?> 
                	<tr>
                	  <td height="20" valign="top" class="tdBorderRtBt">&nbsp;To Pay</td>
                	  <td align="right" valign="top" class="tdBorderBt">
                	  	<?php echo $this->Number->currency(ceil($finalBillingData['FinalBilling']['amount_pending']-$discountAmount-$creditAmt));?></td>
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
<div>&nbsp;</div>
 <?php echo $this->Form->end(); ?>               	  
 <table width="800"  cellspacing="3" cellpadding="3" border="0" align="center">
	<tr><td align="right">
			<?php 
	    		echo $this->Html->link(__('Cancel'),array('action' => 'dischargeBill',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0px'));
	        ?> 
	</td></tr> 
</table>