<div class="inner_title">
<h3>
		<?php echo __('Interim Payment');?>
	</h3>
</div>
<div class="patient_info">
		<?php echo $this->element('patient_information');?>
	</div>

<table width="100%">
<tr><td>
</td></tr>
</table>
<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'saveAdvancePayment','type' => 'file','id'=>'dischargeBill','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('Billing.patient_id',array('value'=>$patient['Patient']['id']));  
?>
<!-- 
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="right">
                   		<tbody><tr>	
           	  	  	  	  <td width="113" class="tdLabel2"><?php echo __('Date Of Admission');?></td>
                   	  	  	<td width="80" class="tdLabel2"><input type="text" value="<?php 
                   	  	  	$admissionDate = explode(" ",$patient['Patient']['create_time']);
                   	  	  	#pr($admissionDate);exit;
                   	  	  	echo 
                   	  	  	$this->DateFormat->formatDate2Local($admissionDate[0],Configure::read('date_format'));?>" class="textBoxExpnd"></td>
                       	  	<td width="50">&nbsp;</td>
                            <td width="80" class="tdLabel2"><?php echo __('Today\'s Date' );?></td>
                            <td width="80" class="tdLabel2"><input type="text" value="<?php 
                            echo $this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'));?>" class="textBoxExpnd"></td>
                            <td width="50">&nbsp;</td>
                          	<td width="70" class="tdLabel2"><?php echo __('Total Days' );?></td>
                            <td width="25"><input type="text" value="<?php echo 1 + ((strtotime(date('Y-m-d')) - strtotime($admissionDate[0])) / (60 * 60 * 24)) ;?>" class="textBoxExpnd"></td>
                          	<td width="50">&nbsp;</td>
                            <td width="">&nbsp;</td>
                            <td width="100" class="tdLabel"><strong><?php echo __('Total Amount' );?></strong></td>
                            <td width="80"><input type="text" style="font-size: 14px; font-weight: bold;" value="<?php echo $this->Number->format(ceil($totalCost),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>" tabindex="16" id="textfield" class="textBoxExpnd" name="textfield"></td>                            
                        </tr>
                   </tbody></table>

 -->
 
 <table cellspacing="0" cellpadding="0" border="0" width="800">
 <tr><td align="left" width="170">
 <?php echo $this->Html->link(__('Provisional Invoice'),array('action' => 'generateReceipt',$patient['Patient']['id'],'direct'), array('escape' => false,'class'=>'blueBtn'));?></td>
   	<td align="left">
 <?php
		echo $this->Html->link(__('Detailed Invoice'),
		     '#',
		     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'detail_payment',$patient['Patient']['id']))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=250,top=150,height=700');  return false;"));
   	?>
 </td></tr>
 </table>
 
<table cellspacing="1" cellpadding="0" border="0" width="100%" align="center" class="tabularForm" style="margin-top:40px;">
                   		<tbody>
                   		<?php //if(!empty($advancePayment) || $patient['Patient']['admission_type']=='IPD'){ ?>
                   	 
                   		<tr>
                        	<th width="100">Deposit Amount</th>
                            <th width="307">Date/Time</th>
                            <th width="100" style="">Reason</th>
                            <th width="200" style="text-align: center;">Mode of Payment</th>
                            <th width="100" style="" >Receipt</th>                            
                        </tr>
     <?php  
        	$amountReceived = 0;
        	$c = 0 ; // maintains unique content id for each list record
        	foreach($advancePayment as $payment){ 
        		$amountReceived = $amountReceived + $payment['Billing']['amount'];
        		$c++ ;
        		$replaceContainer = "edit-content$c" ;
        		$listContainer = "list-content$c" ;
        	?>
        	<tr id="<?php echo $listContainer ;?>">
        			<td valign="middle" align="right"><?php
					//echo $this->Html->image('icons/rupee_symbol_white.png');
        			echo $this->Number->currency($payment['Billing']['amount']);?></td>
		        	<td valign="middle"><?php echo $this->DateFormat->formatDate2Local($payment['Billing']['date'],Configure::read('date_format'),true);?></td>
		        	<td valign="middle"><?php echo $payment['Billing']['reason_of_payment'];?></td>
		        	<td valign="middle"><?php echo $payment['Billing']['mode_of_payment'];?></td>
		        	<td valign="middle"><?php 
	        				 echo $this->Js->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit')),array('action'=>'editAdvancePayment',$payment['Billing']['id']),
						     			 array('escape'=>false,'update' => "#".$replaceContainer,'method'=>'post' ,'class'=>'list-container',
									     'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
									     'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
						     			 'htmlAttributes' => array('onclick' => "edit_advance('".$replaceContainer."','".$listContainer."')"))) ;
						     
						     echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
						     		array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
						     		$payment['Billing']['id']))."', '_blank',
						           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
						     		
						     echo $this->Html->link($this->Html->image('icons/delete-icon.png'), 
						     array('action' => 'deleteAdvance', $payment['Billing']['id']), array('escape' => false),__('Are you sure?', true));
			   			  ?>	
			   		</td>
            </tr>
            <tr id="<?php echo $replaceContainer ;?>" style="display:none;">
            	<td>&nbsp;</td>
            </tr>
        	<?php }
        	$amountReceived = $amountReceived; //+ $labPaidAmount + $radPaidAmount;
        //	if($patient['Patient']['admission_type']=='IPD' && $patient['Patient']['is_discharge']!=1){   
         	if($patient['Patient']['is_discharge']!=1){ ?>    
                        <tr id="new_content">
                        	<td valign="middle">
      		<?php 
      			echo $this->Form->input('Billing.amount',array('class' => 'validate[required,custom[mandatory-enter-only]]',"style"=>"width:100px",'legend'=>false,'label'=>false,'id' => 'amount','style'=>'text-align:right')); 
			?>
                        	</td>
                            <td valign="middle">
                            	<table width="100%" cellspacing="0" cellpadding="0" border="0">
                                	<tbody><tr>
		                                <td style="padding:0px;">
			<?php echo $this->Form->input('Billing.date',array('class' => 'validate[required,custom[mandatory-enter-only]]','type'=>'text','legend'=>false,
			'label'=>false,'readonly'=>'readonly','id' => 'date','value'=>$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),
			Configure::read('date_format'),true)));?>	                                
		                              </td>
        		                    </tr>
                                </tbody></table>                            </td>
                          <td valign="middle" style="text-align: left;">
			<?php echo $this->Form->input('Billing.reason_of_payment', array('div' => false,'label' => false,/*'empty'=>__('Please select'),*/'options'=>array('Advance'=>'Advance','Deposit'=>'Deposit','Partial'=>'Partial'),'id' => 'reason_of_payment','class'=>'validate[required,custom[mandatory-select]]',)); ?>
                            </td>
                          <td valign="middle" style="text-align: left">
                          	<span style="text-align: left;">
							<?php echo $this->Form->input('Billing.mode_of_payment', array("class"=>"textBoxExpnd",'div' => false,'label' => false,/*'empty'=>__('Please select'),*/'options'=>array('Cash'=>'Cash','Cheque'=>'Cheque','Credit Card'=>'Credit Card','NEFT'=>'NEFT'),
									  'id' => 'mode_of_payment','class'=>'validate[required,custom[mandatory-select]]',)); ?>
                          	</span>
                          	<table width="100%" id="bankInformation" style="display:none;">
								    <tr>
									    <td>Bank Name</td>
									    <td><?php echo $this->Form->input('Billing.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?></td>
								    </tr>
								    <tr>
									    <td>Account No.</td>
									    <td><?php echo $this->Form->input('Billing.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?></td>
								    </tr>
								    <tr>
									    <td>Cheque/Credit Card No.</td>
									    <td><?php echo $this->Form->input('Billing.check_credit_card_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?></td>
								    </tr>
							</table>
							 <table width="100%" id="neftBankInformation" style="display:none;">
								   <tr>
									    <td >Bank Name</td>
									    <td><?php echo $this->Form->input('Billing.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?></td>
									</tr>
									    <tr>
									    <td>Account No.</td>
									    <td><?php echo $this->Form->input('Billing.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?></td>
									</tr> 
								    <tr>
									    <td>NEFT No.</td>
									    <td><?php echo $this->Form->input('Billing.neft_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number'));?></td>
									</tr>
									    <tr>
									    <td>NEFT Date</td>
									    <td><?php echo $this->Form->input('Billing.neft_date',array('id'=>'neft_date','type'=>'text','legend'=>false,'label'=>false,'class'=>'neft_date','style'=>'width:150px;'));?></td>
									</tr>
							</table>  
                          </td> 
							<td valign="middle" style="text-align: left">&nbsp;</td>                                                      
                        </tr>
                        <?php }else{ ?>
                        <tr></tr>
                        <?php }?>
       <?php echo $this->Js->writeBuffer();?>    
	      
	    </tbody></table>  
	      
		
		    
 		<table width="" cellspacing="0" cellpadding="0" border="0" align="right" style="padding:4px 10px;">
                <tbody>
                   		<tr>
                        	<td width="160" height="35" class="tdLabel2"><strong><?php echo __('Total Amount');?></strong></td>
                            <td width="" align="right" > 
                            <?php 
                            	 //echo $this->Html->image('icons/rupee_symbol_white.png');
                            	 echo $this->Number->currency(ceil($totalCost));
                            ?>
							 </td>
                        </tr>
                   		<tr>
                        	<td width="" height="35" class="tdLabel2"><strong><?php echo __('Total Amount Received');?></strong></td>
                            <td width="" align="right" >
                            <?php
                            	//echo $this->Html->image('icons/rupee_symbol_white.png');
                            	echo $this->Number->currency(ceil($amountReceived));?></td>
                        </tr>
                   		<tr>
                          <td height="35" class="tdLabel2"><strong><?php echo __('Balance Amount');?></strong></td>
                   		  <td align="right"  >
                   		  		<?php 
		                   		 if(isset($finalBillingData['FinalBilling']['discount_rupees']) && $finalBillingData['FinalBilling']['discount_rupees']!=''){
		   							$dAmount = $finalBillingData['FinalBilling']['discount_rupees'];
								 }else{
								   	$dAmount=0;
								 }
		    						//echo $this->Html->image('icons/rupee_symbol_white.png');
		                   		    echo $this->Number->currency(ceil($totalCost-$amountReceived-$dAmount));?></td>
           		     	</tr> 
                 </tbody>
        </table>    
  <div class="clr">&nbsp;</div>
  <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
     <tbody>
      <tr>                   	 
   	  	<td align="right"><?php if((ceil($totalCost-$amountReceived-$dAmount))>0){?>
   	  			<input class="blueBtn" type="submit" value="Pay"><?php }?> 
   	  			<?php echo $this->Html->link(__('Cancel'),array('action' => 'patientSearch',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));?>                            
        		   
        </td>
      </tr>
     </tbody>
  </table>    
    <?php echo $this->Form->end(); ?>    
          
<?php $splitDate = explode(' ',$patient['Patient']['form_received_on']);?>                     
<script><!--
	var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
	var explode = admissionDate.split('-');

	function edit_advance(list,content){
		$('#neftBankInformation').remove();
        $("#bankInformation").remove();
		$(".list-container").html("");
	 	$("#"+content).hide("slow"); 
	 	$("#new_content").html("");
	 	$("#"+list).show(1500);
	 	$('#dischargeBill').validationEngine('hide');
	}

	$(document).ready(function(){  
		
		jQuery("#dischargeBill").validationEngine();
	 	$("#mode_of_payment").change(function(){
	 		$(this).payment_mode(); 
			
		 });
	 	 $('#amount,#reason_of_payment,#mode_of_payment,#date').live('blur',function()
		 {   
	 		$('#dischargeBill').validationEngine('validate');
		 }); 
		 $('#mode_of_payment').live('change',function(){
			 $(this).payment_mode();   
		 }); 
		 
         $.fn.payment_mode = function(){
             
             if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
            	//$("#blankInfoArea").show(); 
                //$("#blankInfoArea").html($("#bankInformation").html());
                $('#neftBankInformation').hide();
                $("#bankInformation").show();
                
			 }else if($("#mode_of_payment").val() == 'NEFT'){
	            	//$("#blankInfoArea").show(); 
	               // $("#blankInfoArea").html($("#neftBankInformation").html());
			     	$('#neftBankInformation').show();
	                $("#bankInformation").hide();
			 }else{  
				 $('#neftBankInformation').hide();
	             $("#bankInformation").hide();
			 }
	     };
			
		 $( "#date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'dd/mm/yy HH:II:SS',
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),
				//minDate:'+0D',
				onSelect:function(){$(this).focus();}
		 }); 
		 $("#neft_date").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'dd/mm/yy HH:II:SS', 
				onSelect:function(){$(this).focus();}
			});
});
--></script>                                           