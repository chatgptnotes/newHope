<?php //echo $this->element('billing_header');
  //echo $this->General->minDate($wardInDate)  ;exit;
?>
<div class="inner_title">
	<h3> &nbsp; <?php echo __('Finalization of Invoice', true); ?></h3>
	<span></span>
</div>
<div class="patient_info">
		<?php echo $this->element('patient_information');?>
	</div> 
<!-- 
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="patientHub">
                   		<tbody><tr>
                        	<th>Patient Information</th>
                        </tr>
                        <tr>
                        	<td>
                   				<table width="100%" cellspacing="0" cellpadding="0" border="0">
								
                   					<tbody><tr>
									 											
									 	<?php if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$photo) && !empty($photo)){ ?>
                                    	<td width="111" valign="top"><?php echo $this->Html->image("/uploads/patient_images/thumbnail/".$photo, array('width'=>'100')); ?></td>
										<?php }else {
											if($patient['Patient']['sex'] == 'male'){ ?>
											<td width="111" valign="top"><?php echo $this->Html->image("/img/icons/male-thumb.gif"); ?></td>
										<?php } else {  ?>
											<td width="111" valign="top"><?php echo $this->Html->image("/img/icons/female-thumb.gif"); ?></td>
										<?php } } ?> 
										 

                                      	<td width="15">&nbsp;</td>
                                        <td width="230" valign="top">
                                        	<p class="name"><?php echo $patient['Patient']['lookup_name'];?></p>
                                            <p class="address"></p>
                                      	</td>
                                        <td width="20">&nbsp;</td>
                                        <td valign="middle">
                                        	<table width="100%" cellspacing="1" cellpadding="0" border="0" class="patientInfo">
                   								<tbody><tr class="darkRow">
                                                	<td width="270" style="min-width: 270px;">
                                                    	<div class="heading"><strong><?php echo __('Patient ID');?></strong></div>
                                                        <div class="content"><?php echo $patient['Patient']['patient_id'];?></div>
                                                    </td>
                                                    <td width="270" style="min-width: 270px;">
														<div class="heading"><strong><?php echo __('Registration ID');?></strong></div>
                                                        <div class="content"><?php echo $patient['Patient']['admission_id'];?></div>                                                    	
                                                    </td>
                                                </tr>
                                                <tr class="lightRow">
                                                	<td>
                                                    	<div class="heading"><strong><?php echo __('Sex');?></strong></div>
                                                        <div class="content"><?php echo ucfirst($patient['Patient']['sex']);?></div>
                                                    </td>
                                                    <td>
                                                    	<div class="heading"><strong><?php echo __('Registration Date');?></strong></div>
                                                    	<?php $last_split_date_time = explode(" ",$patient['Patient']['create_time']);
	            										//pr($last_split_date_time);exit;	
                                                    	?>
                                                        <div class="content"><?php echo  $this->DateFormat->formatDate2Local($last_split_date_time[0],Configure::read('date_format'));?></div>
                                                    </td>
                                                </tr>
                                                <tr class="darkRow">
                                                	<td>
                                                    	<div class="heading"><strong><?php echo __('Age');?></strong></div>
                                                        <div class="content"><?php echo $patient['Patient']['age'];?></div>
                                                    </td>
                                                    <td>
                                                    	<div class="heading"><strong><?php echo __('Patient Category');?></strong></div>
                                                        <div class="content"><?php echo $corporateEmp;?></div>
                                                    </td>
                                                </tr>
																						 <tr class="lightRow">
                                                	<td>
                                                    	<div class="heading"><strong><?php echo __('Address');?></strong></div>
                                                        <div class="content"><?php echo $address;?></div>
                                                    </td>
                                                    <td>
                                                    	<div class="heading"><strong>&nbsp;</strong></div>
                                                        <div class="content">&nbsp;</div>
                                                    </td>
                                                </tr>
												 
																				                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                   </tbody></table>
                   -->
<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'saveFinalBill','id'=>'ConsultantBilling','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('Billing.patient_id',array('value'=>$patient['Patient']['id']));  
			?>
<table width="100%">
<tr><td>
</td></tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0" align="right" style="border-bottom: 1px solid rgb(62, 71, 74); padding-bottom: 10px;">
                   		<tbody><tr>	
           	  	  	  	  	<td width="130" class="tdLabel2"><?php echo __('Date Of Registration');?>:&nbsp;</td>
                   	  	  	<td width="80" class="tdLabel2"> 
	                   	  	  	<?php 
	                   	  	  		$admissionDate = explode(" ",$patient['Patient']['form_received_on']);
	                   	  	  		echo  $admissionDate  = $this->DateFormat->formatDate2Local($admissionDate[0],Configure::read('date_format'));
	                   	  	  	?>  
                   	  	  	</td>
                       	  	<td width="50">&nbsp;</td>
                            
                            <?php if($patient['Patient']['is_discharge']==1){ ?>
                            	<td width="100" class="tdLabel2"><?php echo __("Discharge Date");?>:&nbsp;</td>
	                            <td width="80" class="tdLabel2">
	                            <?php	echo $todayDate = $this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format')); ?>
	                            </td>
	                            <td width="50">&nbsp;</td>
	                          	<td width="70" class="tdLabel2"><?php 
	                          		$daysDiff =  $this->DateFormat->dateDiff($finalBillingData['FinalBilling']['discharge_date'],$patient['Patient']['form_received_on']);
	                          		echo ($daysDiff->d > 1)?__('Total Days' ):__('Total Day');?>:&nbsp;</td>
	                            <td width="25"> <?php 
		                            echo $dayDiff->d+1 ; //anything greater than 1 day + hours
	                            ?> </td>
                            <?php }else{ ?>
                            	<td width="85" class="tdLabel2"><?php 
                            		
                            	echo __("Today's Date");?>:&nbsp;</td>
	                            <td width="80" class="tdLabel2">
	                            <?php	echo $todayDate = $this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format')); ?>
	                            </td>
	                            <td width="50">&nbsp;</td>
                            	<td width="70" class="tdLabel2"><?php $daysDiff =  $this->DateFormat->dateDiff(date('Y-m-d H:i:s'),$patient['Patient']['form_received_on']);
	                          		echo ($daysDiff->d > 1)?__('Total Days' ):__('Total Day');?>:&nbsp;</td>
	                            <td width="25"> <?php 
	                            	
	                            	$daysDiff =  $this->DateFormat->dateDiff(date('Y-m-d H:i:s'),$patient['Patient']['form_received_on']);
		                            echo (int)$daysDiff->d + 1 ; //anything greater than 1 day + hours 
	                            
	                            ?> </td>
                            <?php  } ?>
                          	<td width="50">&nbsp;</td>
                          <td width="">&nbsp;</td>
                           <!-- <td width="100" class="tdLabel"><strong><?php echo __('Total Amount' );?></strong></td>
                            <td width="80"><input type="text" style="font-size: 14px; font-weight: bold;" value="<?php echo $totalBill;//ceil($totalCost);?>" tabindex="16" id="textfield" class="textBoxExpnd" name="textfield"></td>
                             -->                             
                        </tr>
                   </tbody></table>
                   
    <?php $totalAmountPending = $totalBill-$totalAdvancePaid; //toal cost replaced by totalBill amount-- Pooja
    
    ?>               
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                   		<tbody><tr>
                        	<td width="47%" valign="top">
                   				<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
      
      <tr>
                                        <td width="120" height="35" class="tdLabel2"><?php echo __('Total Amount' );?></td>
                          				<td width="100">
               <?php 
              
						
                        //$totalCost=	$newCost;	
               if($patient['Patient']['is_discharge']==1){         
               	echo $this->Form->input('Billing.total_amount',array('value' => $this->Number->format(ceil($totalBill),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totalamount','style'=>'text-align:right;','readonly'=>'readonly'));
               }else{
               	echo $this->Form->input('Billing.total_amount',array('value' => $this->Number->format(ceil($totalBill),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totalamount','style'=>'text-align:right;'));
               } 
				?>
                          				</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="tdLabel2">Amount Paid</td>
                                      	<td>
     <?php 
     if($patient['Patient']['is_discharge']==1){
     	echo $this->Form->input('Billing.amount_paid',array('value' => $this->Number->format(ceil($totalAdvancePaid),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'text-align:right;','readonly'=>'readonly'));
     }else{
     	echo $this->Form->input('Billing.amount_paid',array('value' => $this->Number->format(ceil($totalAdvancePaid),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'text-align:right;'));
     } 
				?>
     </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="tdLabel2"><strong>Amount Pending</strong></td>
                                        <td>
   <?php 
   if(isset($finalBillingData['FinalBilling']['discount_rupees']) && $finalBillingData['FinalBilling']['discount_rupees']!=''){
   		$dAmount = $finalBillingData['FinalBilling']['discount_rupees'];
   }else{
   	$dAmount=0;
   }
   
   if($patient['Patient']['is_discharge']==1){
   	echo $this->Form->input('Billing.amount_pending',array('value' => $this->Number->format(ceil($totalAmountPending-$dAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totalamountpending','style'=>'text-align:right;','readonly'=>'readonly'));
   }else{
   	echo $this->Form->input('Billing.amount_pending',array('value' => $this->Number->format(ceil($totalAmountPending-$dAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totalamountpending','style'=>'text-align:right;'));
   }
   
   ?>
   </td>
   <td>&nbsp;</td>
 </tr>
 <?php if(($totalAmountPending >0 && $patient['Patient']['is_discharge']==1) || $patient['Patient']['is_discharge']!=1){?>
 <tr>
    <td>Amount</td>
    <td><?php echo $this->Form->input('Billing.amount',array('type'=>'text','value'=>'','legend'=>false,'label'=>false,'id' => 'amount','style'=>'text-align:right;'));?>
    </td>
    <td>
    
    </td>
    </tr> 
 	<tr>
         <td height="35" class="tdLabel2"><strong>Mode Of Payment<font color="red">*</font></strong></td>
         <td> 
   				<?php 
   				 
   				echo $this->Form->input('Billing.mode_of_payment', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:141px;',
   								'div' => false,'label' => false,'empty'=>__('Please select'),'autocomplete'=>'off',
   								'options'=>array('Cash'=>'Cash','Cheque'=>'Cheque','Credit Card'=>'Credit Card','Credit'=>'Credit','NEFT'=>'NEFT'),'id' => 'mode_of_payment')); ?>
   		</td>
   </tr> 
   <tr id="creditDaysInfo" style="display:none">
	  	<td height="35" class="tdLabel2"> 
	  		Credit Period<font color="red">*</font><br /> (in days)</td>
	    <td><?php echo $this->Form->input('Billing.credit_period',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'credit_period','class'=> 'validate[required,custom[mandatory-enter-only]]'));?></td>
   </tr> 
   <tr id="paymentInfo" style="display:none">
	  	<td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%" > 
			    <tr>
				    <td>Bank Name</td>
				    <td><?php echo $this->Form->input('Billing.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_paymentInfo'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('Billing.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfo'));?></td>
				</tr>
				    <tr>
				    <td>Cheque/Credit Card No.</td>
				    <td><?php echo $this->Form->input('Billing.check_credit_card_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?></td>
			    </tr>
		    </table>
	    </td>
   </tr>
   <tr id="neft-area" style="display:none;">
	  	<td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%"> 
			    <tr>
				    <td width="47%">Bank Name</td>
				    <td><?php echo $this->Form->input('Billing.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_neftArea'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('Billing.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_neftArea'));?></td>
				</tr> 
			    <tr>
				    <td>NEFT No.</td>
				    <td><?php echo $this->Form->input('Billing.neft_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number'));?></td>
				</tr>
				    <tr>
				    <td>NEFT Date</td>
				    <td><?php echo $this->Form->input('Billing.neft_date',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_date','style'=>'width:150px;'));?></td>
				</tr>
		    </table>
	    </td>
  </tr> 
                                         
   
  <?php }?>
  
  <?php 
  	if($patient['Patient']['admission_type']=='IPD'){
  ?>
  <tr>
        <td height="35" class="tdLabel2"><strong>Reason Of Discharge<font color="red">*</font></strong></td>
        <td>
   			<?php	 if($patient['Patient']['is_discharge']==1) $readOnly1 = 'disabled';else $readOnly1 = '';
					 $reason =isset($finalBillingData['FinalBilling']['reason_of_discharge'])?$finalBillingData['FinalBilling']['reason_of_discharge']:'';
   					 echo $this->Form->input('Billing.reason_of_discharge', array('value'=>$reason,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'empty'=>__('Please select'),
   											 'options'=>array('Recovered'=>'Recovered','DischargeOnRequest'=>'Discharge On Request','DAMA'=>'DAMA','Death'=>'Death'),'id' => 'mode_of_discharge','disabled'=>$readOnly1)); 
   			?> 
				
   			</td> 
  	 
   			<td>
</td>
	  	<td height="35"   class="tdLabel2"> 
		  	<table width="100%" id="dischargeSummery" style="display:none">		    
			    <tr>
				    <td><?php echo $this->Html->link('Discharge Summary',array('controller'=>'billings','action'=>'discharge_summary',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?></td>				  
			    </tr>			  
		    </table>
		    <table width="100%" id="dama" style="display:none">		    
			    <tr>
				    <td><?php echo $this->Html->link('DAMA Form',array('controller'=>'billings','action'=>'dama_form',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?></td>				  
			    </tr>
			    <tr>
				    <td><?php echo $this->Html->link('Discharge Summary',array('controller'=>'billings','action'=>'discharge_summary',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?></td>				  
			    </tr>			  			  
		    </table>
		    <table width="100%" id="death" style="display:none">		    
			    <tr>
				    <td><?php echo $this->Html->link('Death Certificate',array('controller'=>'billings','action'=>'death_certificate',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?></td>				  
			    </tr>
			    <tr>
				    <td><?php echo $this->Html->link('Death Summary',array('controller'=>'billings','action'=>'death_summary',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));?></td>  
			    </tr>			  			  
		    </table>
	  </td>
  </tr>                                  
      <tr id="dischargeDate" style="display:none">
      <td >Discharge Date:<font color="red">*</font></td>
      <td width="200"><?php 
      if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
      	if($patient['Patient']['is_discharge']==1) $readOnly = 'readonly';else $readOnly = '';
      	$last_split_date_time = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
      	echo $this->Form->input('Billing.discharge_date',array('value'=>$this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'),true),'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:150px;','readonly'=>$readOnly));
      }else{
      	echo $this->Form->input('Billing.discharge_date',array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:150px;','readonly'=>'readonly'));
      }
      ?></td>
      </tr>        
      
      <?php }else{//OPD starts
      ?>
      	<tr>
	         <td height="35" class="tdLabel2">OPD Process Done<font color="red">*</font></td>
	         <td width="200"> 
	   				<?php 
				      if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
				      		if($patient['Patient']['is_discharge']==1) $readOnly = 'readonly';else $readOnly = ''; 
				      		$last_split_date_time = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
				      		echo $this->Form->input('Billing.discharge_date',array('value'=>$this->DateFormat->formatDate2Local($last_split_date_time[0],Configure::read('date_format')).' '.$last_split_date_time[1],'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:150px;','readonly'=>$readOnly));
				      }else{
				      		echo $this->Form->input('Billing.discharge_date',array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:150px;'));
				      }	?>
			</td>
   		</tr>  
      <?php 
      }?>                               
        </tbody>
     	</table>
    	</td>
        <td width="50">&nbsp;</td>
        <td width="47%" valign="top" align="right">
        <?php //if(($totalAmountPending >0 && $patient['Patient']['is_discharge']==1) || $patient['Patient']['is_discharge']!=1){
              if($patient['Patient']['is_discharge']!=1){?>
              	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                	<tbody><tr>
	                    <td width="80" height="35" class="tdLabel2">Discount</td>
	                    <td width="70">
						<?php 
							if(isset($finalBillingData['FinalBilling']['discount_percent'])){
								echo $this->Form->input('Billing.discount_percent',array('value'=>$finalBillingData['FinalBilling']['discount'],'legend'=>false,'label'=>false,'id' => 'discount_percent')); 
							}else{
								echo $this->Form->input('Billing.discount_percent',array('legend'=>false,'label'=>false,'id' => 'discount_percent')); 
							}
						?>
					  	%</td>
                        <td width="50"></td>
                        <td width="20"></td>	
                        <td width="10" class="tdLabel2"><?php echo $this->Html->image('icons/refresh-icon.png',array('alt'=>__('Refresh Discount'),'title'=>__('Refresh Discount'),'id'=>'refresh-discount'))?></td>
                        <td width="10">&nbsp;</td>
                    </tr>
					<tr>
						<td width="80" height="35" class="tdLabel2">&nbsp;</td>
						<td width="70">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OR</td>
						<td width="50"></td>
						<td width="20"></td>	
						<td width="10" class="tdLabel2">&nbsp;</td>
						<td width="10">&nbsp;</td>
					</tr>
					<tr>
						<td width="80" height="35" class="tdLabel2">&nbsp;</td>
						<td width="70">
							<?php 
								if(isset($finalBillingData['FinalBilling']['discount_rupees'])){
									echo $this->Form->input('Billing.discount_rupees',array('value'=>$finalBillingData['FinalBilling']['discount'],'legend'=>false,'label'=>false,'id' => 'discount_rupees')); 
								}else{
									echo $this->Form->input('Billing.discount_rupees',array('legend'=>false,'label'=>false,'id' => 'discount_rupees')); 
								}
							?>
			  			</td>
						<td width="50"></td>
						<td width="20"></td>	
						<td width="10" class="tdLabel2">&nbsp;</td>
						<td width="10">&nbsp;</td>
					</tr>
					<tr>
						<td width="80" height="35" class="tdLabel2">Reason for Discount</td>
						<td width="70">
							<?php 
									echo $this->Form->textarea('Billing.reason_for_discount',array('legend'=>false,'label'=>false,'id' => 'reason_for_discount')); 
								
							?>
					    </td>
						<td width="50"></td>
						<td width="20"></td>	
						<td width="10" class="tdLabel2">&nbsp;</td>
						<td width="10">&nbsp;</td>
					</tr></tbody>
				</table>   
                <?php }else{  //BOF credit voucher?>
                <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                	<tbody><tr>
	                    <td width="30%" height="35" class="tdLabel2">Credit Voucher</td>
	                    <td width="70%">
							<?php  echo $this->Form->input('Billing.discount_by_credit',array('legend'=>false,'label'=>false,'id' => 'discount_by_credit','class'=>'textBoxExpnd'));  ?> 
					  	</td> 
                    </tr> 
					<tr>
						<td   height="35" class="tdLabel2">Reason</td>
						<td  >
							<?php  echo $this->Form->textarea('Billing.reason_for_credit_voucher',array('legend'=>false,'label'=>false,'id' => 'reason_for_credit_voucher','class'=>'validate[required,custom[mandatory-enter-only]] textBoxExpnd')); 
							 ?>
					    </td>
						 
					</tr></tbody>
				</table> 
				<?php } //EOF credit voucher ?>
           </td>                            
           </tr>
           <tr>
            	<td valign="top" style="padding-top: 15px;" colspan="2"> 
			 		 <?php 
				  		echo $this->Html->link(__('Cancel'),array('action' => 'patientSearch',$patient['Patient']['id']), array('escape' => false,'class'=>'grayBtn'));
				   		if($patient['Patient']['is_discharge']==1){
				   			if($settlementCount==0){
				   				echo $this->Html->link(__('View Invoice'),array('action' => 'generateReceipt',$patient['Patient']['id']),
				   			 	array('escape' => false,'class'=>'blueBtn'));
				   			}else{
				   				echo $this->Html->link(__('View Invoice'),array('action' => 'generateSavedReceipt',$patient['Patient']['id']),
				   			 	array('escape' => false,'class'=>'blueBtn'));	
				   			} 
				   		}  
				   		if($patient['Patient']['is_discharge']!=1){
				   			$buttonlabel = ($patient['Patient']['admission_type']=='IPD')?'Discharge & Print Invoice':'Done & Print Invoice';
			   		?>  <input class="blueBtn" type="submit" value="<?php echo $buttonlabel ?>" id="payAmount">                            
				     <?php } 
				   		if($patient['Patient']['is_discharge']==1 && ($totalAmountPending-$dAmount)>0){?>
						    <input type="hidden" value="payOnlyAmount" name="payOnlyAmount">
						   	<input class="blueBtn" type="submit" value="Pay" id="payOnlyAmount"> 
				   <?php 
				   		echo $this->Form->input('onlyCredit',array('type'=>'checkbox','id'=>'onlyCredit'));
				   		echo "Add only credit voucher" ;
				   		}  ?> 
				   		
					</td>
                   		  
                   		  <td valign="top" align="right" style="padding-top: 15px;">&nbsp;</td>
           		     </tr>
                   </tbody></table>
              <?php echo $this->Form->end(); ?>
                   
 <script>
 var totalCost="<?php echo ceil($totalBill);?>";
 var totalAdvancePaid="<?php echo $totalAdvancePaid;?>";
 var totalPendingAmount="<?php echo ($totalBill-$totalAdvancePaid);?>";
 $(document).ready(function(){


	//checking for paymetn mode option and there respetuve fields to display on page load 
	
	 if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
		 $("#paymentInfo").show();
		 $("#creditDaysInfo").hide();
		 $('#neft-area').hide();
	} else if($("#mode_of_payment").val() == 'Credit') {
	 	$("#creditDaysInfo").show();
	 	$("#paymentInfo").hide();
	 	$('#neft-area').hide();
	} else if($('#mode_of_payment').val()=='NEFT') {
	    $("#creditDaysInfo").hide();
		$("#paymentInfo").hide();
		$('#neft-area').show();
	} 

	//EOF payment laod
	$('#onlyCredit').click(function(){
		if($(this).is(':checked')){ 
			$('#ConsultantBilling').validationEngine('hide');
			$('#mode_of_payment').removeClass('validate[required,custom[mandatory-select]]');
		}else{ 
			$('#mode_of_payment').addClass('validate[required,custom[mandatory-select]]');
		}
	});

	$('#ConsultantBilling').submit(function(){
		
		if($('#discount_by_credit').val() != '' && $('#reason_for_credit_voucher').val()==''){ 
			$('#reason_for_credit_voucher').addClass('validate[required,custom[mandatory-enter-only]]');   
		}else{
			$('#reason_for_credit_voucher').removeClass('validate[required,custom[mandatory-enter-only]]'); 
		}
	});

	$('#discount_by_credit').blur(function(){
		if($('#discount_by_credit').val()==''){
			$('#reason_for_credit_voucher').removeClass('validate[required,custom[mandatory-enter-only]]');
			$('#reason_for_credit_voucher').validationEngine('hide'); 
		}else{
			$('#reason_for_credit_voucher').removeClass('validate[required,custom[mandatory-enter-only]]');
		}
	});
	 //alert($('#mode_of_discharge').val());
	if($('#mode_of_discharge').val() == 'Recovered'){
		$('#dischargeSummery').show();
		$('#dischargeDate').show();
	}
	if($('#mode_of_discharge').val() == 'DAMA'){
		$('#dama').show();
		$('#dischargeDate').show();
	}
	if($('#mode_of_discharge').val() == 'Death'){
		$('#death').show();
		$('#dischargeDate').show();
	}
	if($('#mode_of_discharge').val() == 'DischargeOnRequest'){
		//alert('here');
		$('#dischargeSummery').show();
		$('#dischargeDate').show();
	}
	 
	 jQuery("#ConsultantBilling").validationEngine();
	 $( "#discharge_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			minDate:new Date(<?php echo $this->General->minDate($wardDates['WardPatient']['in_date']) ?>),
			onSelect:function(){$(this).focus();}
		});

	 $( "#neft_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			minDate:new Date(<?php echo $this->General->minDate($wardInDate) ?>),
			onSelect:function(){$(this).focus();}
		});
		
	 $("#mode_of_payment").change(function(){
			//alert('here');
			if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
				 $("#paymentInfo").show();
				 $("#creditDaysInfo").hide();
				 $('#neft-area').hide();
			} else if($("#mode_of_payment").val() == 'Credit') {
			 	$("#creditDaysInfo").show();
			 	$("#paymentInfo").hide();
			 	$('#neft-area').hide();
			} else if($('#mode_of_payment').val()=='NEFT') {
			    $("#creditDaysInfo").hide();
				$("#paymentInfo").hide();
				$('#neft-area').show();
			}else{
				 $("#creditDaysInfo").hide();
				 $("#paymentInfo").hide();
				 $('#neft-area').hide();
			}
		 });
	 $("#mode_of_discharge").change(function(){
			//alert('here');
			if($("#mode_of_discharge").val() == 'Recovered'){
				 $("#dischargeSummery").show();
				 $("#death").hide();
				 $("#dama").hide();
				 $("#dischargeDate").show();
				 
			}else if($("#mode_of_discharge").val() == 'DischargeOnRequest'){
				 $("#dischargeSummery").show();
				 $("#death").hide();
				 $("#dama").hide();
				 $("#dischargeDate").show();
			}else if($("#mode_of_discharge").val() == 'DAMA'){
				$("#dama").show();
				$("#dischargeSummery").hide();
				$("#death").hide();
				$("#dischargeDate").show();
			}else if($("#mode_of_discharge").val() == 'Death'){
				$("#death").show();
				$("#dama").hide();
				$("#dischargeSummery").hide();
				$("#dischargeDate").show();
			}else if($("#mode_of_discharge").val() == ''){
				$("#dischargeDate").hide();
			}
		 });
	 
	 $("#reCalculate").click(function(){
		 calculateDiscount();
	});
	$("#discount_percent").keyup(function(){
		 calculateDiscount();
	});
	$("#refresh-discount").click(function(){
		 $("#totalamount").val(totalCost);
		 $("#totalamountpending").val(totalPendingAmount);
		 $("#totaladvancepaid").val(totalAdvancePaid);
		 $("#discount_percent").val('');
		 $("#discount_rupees").val('');
		 
	 });
	 $("#discount_rupees").keyup(function(){
		 resetDiscount();
		/* var dCount = $("#discount_rupees").val();
		 var pAmount = $("#totalamountpending").val();
		 var dCountRs=pAmount-dCount;
		 $("#totalamountpending").val(dCountRs+'.00');*/
		 calculatePercentage();
	});

	$("#BN_paymentInfo").live('keyup change blur',function(){
		
		$("#BN_neftArea").val($(this).val());
		 
	});
	$("#AN_paymentInfo").live('keyup change blur',function(){
		$("#AN_neftArea").val($(this).val());
	});
	 
 });
 
  function calculateDiscount(){
		var discountEntered = $("#discount_percent").val();
		discountAmount = Math.ceil((totalCost*discountEntered)/100);
		amountRemaining=totalCost-discountAmount;//alert(totalCost+'-'+discountAmount+'-'+amountRemaining+'-'+totalAdvancePaid);
		pAmt = amountRemaining-totalAdvancePaid;
		$("#totalamountpending").val(pAmt.toFixed(2));
		$("#discount_rupees").val(discountAmount);
  }

  function calculatePercentage(){
		var discountEntered = $("#discount_rupees").val();
		discountAmount = Math.floor((100*discountEntered)/totalCost);
		amountRemaining=totalCost-discountEntered;//alert(totalCost+'-'+discountAmount+'-'+amountRemaining+'-'+totalAdvancePaid);
		pAmt = amountRemaining-totalAdvancePaid;
		$("#totalamountpending").val(pAmt.toFixed(2));
		$("#discount_percent").val(discountAmount);
 }

  function resetDiscount(){
  	
	 $("#totalamountpending").val(totalPendingAmount); 
	 $("#discount_percent").val('');
  }
  
  
 </script>                  