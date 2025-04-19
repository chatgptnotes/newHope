<?php $website  = $this->Session->read('website.instance');?>
<?php 
$surgeryTotal=0;
$surgeryPaid=0;
foreach($surgeryCharge as $surgery_charge){
	if($surgery_charge['Billing']['total_amount']>$surgeryTotal)$surgeryTotal=$surgery_charge['Billing']['total_amount'];
	$surgeryPaid=$surgeryPaid+$surgery_charge['Billing']['amount'];
	//$surgeryPaid=$surgeryPaid+$surgery_charge['Billing']['discount'];
}
?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id="serviceGrid">
		<tr> 
			<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
	          	<th class="table_cell"><?php echo __('MOA Sr. No.');?></th>
			<?php }?>
			
			<th class="table_cell"><?php echo __('Service');?></th>
			<?php if($patient['TariffStandard']['name'] == Configure::read('CGHS')){?>
			<th class="table_cell"><?php echo __('CGHS Code');?></th>
			<?php }?>
			<th class="table_cell"><?php echo __('Amount');?></th>
		</tr>

<?php  
		  $totalAmount=0;
          $totalWardNewCost=0;
          $totalWardDays=0;
          $totalNewWardCharges=0;
          if(is_array($wardServicesDataNew)){
          foreach($wardServicesDataNew as $uniqueSlot){
          	$srNo++;
          		if(isset($uniqueSlot['name'])){
					$totalWardNewCost = $totalWardNewCost + $uniqueSlot['cost'];
					$v++;
					$lastSection = 'Conservative Charges';
				?>
				<?php if($patient['Patient']['payment_category']!='cash' && $uniqueSlot['validity']> 1 ){
					$lastSection = '';
					?>	
					<tr>
					<?php if(strtolower($patient['TariffStandard']['name']) != Configure::read('privateTariffName')) { //7 for private patient only?>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<?php }?>
					
		            <td class="tdBorderRt" style="font-size:12px;"><i><strong>Surgical Charges</strong> </i>
		            	<?php $endOfSurgery = strtotime($uniqueSlot['start']." +".$uniqueSlot['validity']." days");
		            		$startOfSurgery  = $this->DateFormat->formatDate2Local($uniqueSlot['start'],Configure::read('date_format')) ;
		            		echo $surgeryDate = "<i>(".$startOfSurgery."-".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$endOfSurgery),Configure::read('date_format')).")</i>";?>
		           
		            </td>
		            <?php if($patient['TariffStandard']['name']==Configure::read('CGHS')){?>
		            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
		            <?php }?>
		            
		            <td align="right" valign="top">&nbsp;</td>
		          	</tr> 
	          		<?php $v++; 
				 }
				 //if surgery is package
				 
				if($uniqueSlot['validity']> 1){?>
		          	<tr>
			          	<!-- <td align="center" class="tdBorderRt"><?php //echo $srNo;?></td> -->
			          	
			          	<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
			          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['moa_sr_no'];?></td>
			          	<?php }?>
			          	
			            <td class="tdBorderRt" style="padding-left:10px;"><?php  
				            echo $uniqueSlot['name'];
				            //echo '(<i>'.$uniqueSlot['doctor'].'</i>)';
				            $splitDate = explode(" ",$uniqueSlot['start']);
				   			echo "<br><i>(".$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true)."-".
				   			$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['end'],Configure::read('date_format'),true).")</i>";
				            ?>
			            </td>
			            
			            <?php if($patient['TariffStandard']['name']==Configure::read('CGHS')){?>
			            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php //echo $uniqueSlot['cghs_code'];?></td>
			            <?php }?>
			            <!-- <td align="right" valign="top" class="tdBorderRt"><?php //echo '1';
			            	//echo $uniqueSlot['cost'];?></td>
			            <td align="center" valign="top" class="tdBorderRt"><?php //echo $uniqueSlot['cost'];
			            	//echo '1';?></td> -->
			            
			            <td align="right" valign="top"><?php //echo $uniqueSlot['cost'];
				            echo $uniqueSlot['cost'];
				            $totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost'];
				            $totalAmount=$totalNewWardCharges;
				            ?></td>
		          	</tr>	
		          	
				<?php }else{ //debug($uniqueSlot)?>
					<tr>
			          	<!-- <td align="center" class="tdBorderRt"><?php //echo $srNo;?></td> -->
			          	
			          	<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
			          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['moa_sr_no'];?></td>
			          	<?php }?>
			          	
			            <td class="tdBorderRt" style="padding-left:10px;"><?php 
				            echo $uniqueSlot['name'].'('.$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true).')</br>'; 
				            echo '&nbsp;&nbsp;&nbsp;&nbsp;Surgery Charges' ;
				            
				            
				            if($uniqueSlot['doctor']){
				            	echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Charges' ;
				            	echo '<i> ('.rtrim($uniqueSlot['doctor'].','.$uniqueSlot['doctor_education'],',').')</i>';
				            }
				            if($uniqueSlot['asst_surgeon_one']){
					            echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Asst. Surgeon I Charges' ;
					            echo '<i> ('.rtrim($uniqueSlot['asst_surgeon_one'],',').')</i>';
				            }
				            if($uniqueSlot['asst_surgeon_two']){
					            echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Asst. Surgeon II Charges' ;
					            echo '<i> ('.rtrim($uniqueSlot['asst_surgeon_two'],',').')</i>';
				            }
				            //anaesthesia charges
				            echo ($uniqueSlot['anaesthesist'])?'<br/>&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Charges':'' ;
				            echo ($uniqueSlot['anaesthesist'])?'<i> ('.rtrim($uniqueSlot['anaesthesist'],',').')</i>':'';
				            //EOF anaesthesia charges
				            
				            if($uniqueSlot['cardiologist']){
					            echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;Cardiology Charges' ;
					            echo '<i> ('.$uniqueSlot['cardiologist'].')</i>';
				            }
				            if($uniqueSlot['ot_assistant']){
				            	echo '</br>&nbsp;&nbsp;&nbsp;&nbsp;OT Assistant Charges' ;
				            }
				            
				            if(!empty($uniqueSlot['ot_charges'])){
				            	echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;OT Charges ';
				            }
				          /*  if($uniqueSlot['extra_hour_charge'] != 0){
				            	echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;Extra OT Charges ';
				            }*/
				            if($this->Session->read('website.instance') == 'kanpur'){
					            foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
									echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;'.$name;
								}
							}
				            $splitDate = explode(" ",$uniqueSlot['start']);
				            if($uniqueSlot['anaesthesist_cost']){
				            	$valueForAnaesthesist = '<br/>&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Charges<i> ('.$uniqueSlot['anaesthesist'].')</i>';
				            }else{
				            	$valueForAnaesthesist ='' ;
				            }
				   			$valueForSurgeon =  $uniqueSlot['name'].'('.
				   								$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true).')</br>'.
				   								'&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Charges <i>('.$uniqueSlot['doctor'].','.
				   								$uniqueSlot['doctor_education'].')</i>)'.$valueForAnaesthesist ;
				   		?></td>
			            <?php if($patient['TariffStandard']['name']==Configure::read('CGHS')){?>
			            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $uniqueSlot['cghs_code'];?></td>
			            <?php }?>
			            <!-- <td align="right" valign="top" class="tdBorderRt"><?php 
						/*if($uniqueSlot['anaesthesist_cost']){
			            	$anaeCost = "<br>".$uniqueSlot['anaesthesist_cost'] ;
			            	$anaeUnit = "<br>1" ;
			            }
			            echo "<br>".$uniqueSlot['cost'];	
			            echo (!empty($uniqueSlot['anaesthesist_cost']))?"<br>".$uniqueSlot['anaesthesist_cost']:'';*/
			            ?></td>
			            <td align="center" valign="top" class="tdBorderRt"><?php 
			            /*$surgonCost = "<br>".$uniqueSlot['cost'].$anaeCost ;
			            echo '<br>1';
			            echo ($uniqueSlot['anaesthesist_cost'])?'<br>1':'';*/
			            ?></td> -->
			            <td align="right" valign="top"><?php
			            echo "<br>".$uniqueSlot['cost'];
			            if($uniqueSlot['doctor']) echo "<br>".$uniqueSlot['surgeon_cost'];;
			            if($uniqueSlot['asst_surgeon_one'])
							 echo "<br>".$uniqueSlot['asst_surgeon_one_charge'];
						else 
							$uniqueSlot['asst_surgeon_one_charge'] = 0;
		            	if($uniqueSlot['asst_surgeon_two'])
		            		 echo "<br>".$uniqueSlot['asst_surgeon_two_charge'];
		            	else
		            		$uniqueSlot['asst_surgeon_two_charge'] = 0;
			            if($uniqueSlot['anaesthesist'])
			            	 echo "<br>".$uniqueSlot['anaesthesist_cost'];
			            else
			            	$uniqueSlot['anaesthesist_cost'] = 0;
			            if($uniqueSlot['cardiologist'])
			            	echo "<br>".$uniqueSlot['cardiologist_charge'];
			            else
			            	$uniqueSlot['cardiologist_charge'] = 0;
			                $totall = $uniqueSlot['ot_charges'] + $uniqueSlot['extra_hour_charge'];
		           		if(!empty($uniqueSlot['ot_assistant']))echo  "<br>".$uniqueSlot['ot_assistant'];
		           		if(!empty($uniqueSlot['ot_charges'])) echo  "<br>".$totall;
		            	//if($uniqueSlot['extra_hour_charge'] != 0) echo "<br>".$uniqueSlot['extra_hour_charge'];
						$totalOtServiceCharge = 0;
		            	if($this->Session->read('website.instance') == 'kanpur'){
		            		foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
		            			echo '<br>'.$charge;
		            			$totalOtServiceCharge = $totalOtServiceCharge + $charge;
		            		}
		            	}
			            $totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost']+$uniqueSlot['surgeon_cost']+$uniqueSlot['asst_surgeon_one_charge']+
			            $uniqueSlot['asst_surgeon_two_charge']+$uniqueSlot['anaesthesist_cost']+$uniqueSlot['cardiologist_charge']+$uniqueSlot['ot_assistant']+
			            $uniqueSlot['ot_charges']+$uniqueSlot['extra_hour_charge'] + $totalOtServiceCharge;
			            $totalAmount=$totalNewWardCharges;
			            ?></td>
		          	</tr>
				<?php 	
				  } //EOF package cond for surgery display
          		}    
          }
          
          // Anesthesia Charges Starts
          if(!empty($anesthesiaDetails)){
          $v++;$anesthesiaCharges = 0;
          foreach($anesthesiaDetails as $anesthesiaDetail){
			if(!empty($anesthesiaDetail['Surgery']['anesthesia_charges'])){
          	$srNo++;?>
          <tr>
	         <!--  <td align="center" class="tdBorderRt"><?php //echo $srNo;?></td> -->
	          
	          <?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
	          <td align="center" class="tdBorderRt"><?php //echo $doctorChargesData['TariffAmount']['moa_sr_no'].'here';exit;
		          echo '';?></td>
		      <?php }?>
	          
	          <td class="tdBorderRt">Anesthesia Charges</td>
	          <?php if($patient['TariffStandard']['name']==Configure::read('CGHS')){?>
	          <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php  echo '';?></td>
	          <?php }?>
	          <!-- <td align="right" valign="top" class="tdBorderRt"><?php 
	              //echo (ceil($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100));?></td>
	          <td align="center" valign="top" class="tdBorderRt"><?php //echo 1; ?></td>  -->
	          <td align="right" valign="top"><?php 
	            echo ceil($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100);
	            $anesthesiaCharges = $anesthesiaCharges + ceil($anesthesiaDetail['TariffAmount'][$nabhKey]*$anesthesiaDetail['Surgery']['anesthesia_charges']/100);
	            ?></td>
         </tr>
      <?php }
          }
          } // Anesthesia Charges Ends 
          } ?>
         
         <tr>
          	<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
	          <td >&nbsp;</td>
		   	<?php }?>
			<td >&nbsp;</td>
			<?php if($patient['TariffStandard']['name']==Configure::read('CGHS')){?>
			<td  >&nbsp;</td>
			<?php }?>
			<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmount);?></td>
		 </tr>
</table> 


<?php if(!empty($surgeryCharge)){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both">
	<tr><td >&nbsp;</td></tr>
	<tr>
  		<td style="text-align:center" colspan="5"><strong>Payment Received For Surgery/Package</strong></td>
  	</tr>
  	
  	<tr>
  	<td>
  		<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm">
		<tr >
		 	<th width="10%">Deposit Amount</th>
            <th >Date/Time</th>
            <th width="10%">Mode of Payment</th>
            <th >Action</th>
            <th >Print Receipt</th>
            <?php if($website == 'kanpur')
            {?>
            	<th>Print without header</th>
            <?php }?>
		</tr>
		<?php  $totalpaid=0;
			   $paidtopatient=0;
			   $totalpaidDiscount=0;
		foreach($surgeryCharge as $surgeryCharge){ 

			if($surgeryCharge['Billing']['refund']=='1'){
				//echo $paidtopatient1=$surgeryCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$surgeryCharge['Billing']['paid_to_patient'];
				continue;
			}else{
				if(!empty($surgeryCharge['Billing']['discount'])){
					$totalpaid1=$surgeryCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$surgeryCharge['Billing']['discount'];
					$totalpaidDiscount=$totalpaidDiscount+$surgeryCharge['Billing']['discount'];
					if(empty($surgeryCharge['Billing']['amount']))
						continue;
				} 
			}?>
		<tr>
			<td align="right"><?php 
			/*if($surgeryCharge['Billing']['refund']=='1'){
				echo $paidtopatient1=$surgeryCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$paidtopatient1;
			}else{
				if(empty($surgeryCharge['Billing']['amount']) && !empty($surgeryCharge['Billing']['discount'])){
					echo $totalpaid1=$surgeryCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$totalpaid1;
					$totalpaidDiscount=$totalpaidDiscount+$totalpaid1;
				}else*/if(!empty($surgeryCharge['Billing']['amount'])){
					echo $totalpaid1=$surgeryCharge['Billing']['amount']/*+$surgeryCharge['Billing']['discount']*/;
					$totalpaid=$totalpaid+$totalpaid1;
				}
			//}?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($surgeryCharge['Billing']['date'],Configure::read('date_format'),true);?></td>
			<!-- <td><?php echo $surgeryCharge['Billing']['reason_of_payment'];?></td> -->
			<td><?php echo $surgeryCharge['Billing']['mode_of_payment'];?></td>
			<td><?php
			/* comented becoz if payment deleted then calculation got mis match -*DO NOT REMOVE*- --yashwant
			 * if(strtolower($this->Session->read('role'))=='admin'){
				echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteSurgeryRec',
					'id'=>'deleteSurgeryRec_'.$surgeryCharge['Billing']['id']),array('escape' => false));
			} */
			
			if(strtolower($this->Session->read('website.instance'))=='kanpur'){
				if(strtolower($addmissionType['Patient']['admission_type'])!='opd'){
					echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
						array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
						$surgeryCharge['Billing']['id']))."', '_blank',
				 		'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
					
                   echo $this->Html->link($this->Html->image('icons/printer_mono.png',array('title'=>'Print Receipt without Header')),'#',
		               array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				       $surgeryCharge['Billing']['id'],'?'=>'flag=without_header'))."', '_blank',
						 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));


				}
			}else{
				echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
					array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
					$surgeryCharge['Billing']['id']))."', '_blank',
				 	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
/* 
	            echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt without Header')),'#',
		            array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				   $surgeryCharge['Billing']['id'],'?'=>'flag=without_header'))."', '_blank',
						 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));

 */
			}
			
			
			?></td>
			<td height="30px"><?php  
			if(!empty($surgeryCharge['Billing']['tariff_list_id'])){
			echo $this->Html->link('Print Receipt','javascript:void(0)',
			 		array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
			 				$patientID,'?'=>array('flag'=>'Surgery','groupID'=>$groupID,'recID'=>$surgeryCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			 }?></td>
			 <?php 
			if($website == 'kanpur')
            {?>
            <td height="30px"><?php 
            	echo $this->Html->link('Print without header','javascript:void(0)',
            			array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
            					$patientID,'?'=>array('flag'=>'Surgery','groupID'=>$groupID,'header'=>'without','recID'=>$surgeryCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
				?></td>
           <?php }?> 
			 
		</tr>
		<?php }?> 
		</table>
  	</td>
  	</tr>
  	<tr><td >&nbsp;</td></tr>
   
</table>
<?php }?>


<script>
$("#paymentDetailDiv", parent.document ).hide();//hide payment detail coz payment will done from final only  --yashwant

$( '#paymentDetail', parent.document ).trigger('reset');
$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
$( '#maintainDiscount', parent.document ).val('<?php echo $totalpaidDiscount;?>');
$( '#totaladvancepaid', parent.document ).val('<?php echo $surgeryPaid=$surgeryPaid/*+$totalpaidDiscount*/;?>');
$( '#totalamountpending', parent.document ).val('<?php echo $totalAmount+$paidtopatient-$surgeryPaid-$totalpaidDiscount;?>');
$( '#amount', parent.document ).attr('readonly',false);//to allow partial payment

$( '#prevDiscount', parent.document ).html('<?php echo ($totalpaidDiscount)?$totalpaidDiscount:0;?>');//for showing previous discount
$( '#prevRefund', parent.document ).html('<?php echo ($paidtopatient)?$paidtopatient:0;?>');//for showing previous refund

$('.checkbox1').attr('checked', true);
$("#selectall").attr('checked', true);
/*
$(".deleteService").click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];
	patient_id='<?php //echo $patientID;?>';
	
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php //echo $this->Html->url(array("controller" => "Billings", "action" => "deleteServicesCharges", "admin" => false)); ?>"+"/"+recId+"/"+patient_id+'?Flag=opdBill',
			  context: document.body,
			  success: function(data){ 
					  parent.getServiceData(patient_id);	
				  $("#busy-indicator").hide();			  
			  },
			  beforeSend:function(){$("#busy-indicator").show();},		  
		});
	}else{
		return false;
	}
});
*/

$('#selectall').click(function(event) {  //on click
    if(this.checked) { // check select status
        $('.checkbox1').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"
            $('.checkbox1').attr('disabled','disabled');              
        });
        $( '#paymentDetail', parent.document ).trigger('reset');

    	$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
    	$( '#totaladvancepaid', parent.document ).val('<?php echo $servicePaid;?>');
    	$( '#totalamountpending', parent.document ).val('<?php echo $totalAmount-$servicePaid;?>');
    }else{
        $('.checkbox1').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"   
            $('.checkbox1').attr('disabled',false);                  
        });        
    }
});

//If one item deselect then button CheckAll is UnCheck
$(".checkbox1").click(function () {
    if (!$(this).is(':checked')){	
	    //if selected checkbox is unchecked all checkboxes to be enabled	        
        $("#selectall").prop('checked',true);
        $('.checkbox1').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"
            $('.checkbox1').attr('disabled','disabled');              
        });
        // if the checked box is umcheck then reset billing amt to total bill amount
        $( '#paymentDetail', parent.document ).trigger('reset');
    	$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
    	$( '#totaladvancepaid', parent.document ).val('<?php echo $servicePaid;?>');
    	$( '#totalamountpending', parent.document ).val('<?php echo $totalAmount-$servicePaid;?>');
    	$( '#tariff_list_id', parent.document ).val('');//service id
        		
    }else{
           checkId=this.id;
	       hiddencheck=checkId.split('_')
	      	//Seelcted service amount in billing section
		   var totalAmount= $('#amountBill_'+hiddencheck[1]).val();
		   var tariffId=$('#'+checkId).attr('tariffId');
		   var advPaid=$('#partial_amt_'+hiddencheck[1]).val();
		   var balAmt=totalAmount-advPaid;
		   if(advPaid==''){
			   balAmt='0.00';
			   advPaid='0.00';
		   }
		   $( '#paymentDetail', parent.document ).trigger('reset');
		   $( '#totalamount', parent.document ).val(totalAmount);
		   $( '#tariff_list_id', parent.document ).val(tariffId);//service id
		   $( '#totaladvancepaid', parent.document ).val(advPaid);
           $( '#totalamountpending', parent.document ).val(balAmt);
	       
	       $(".checkbox1").attr('disabled','disabled');
	       $(this).attr('disabled',false);
	        //For only one service to be selected at a time
    }
});


$('.deleteSurgeryRec').click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];

	patient_id='<?php echo $patientId;?>';
	tariffStandardId='<?php echo $tariffStandardId;?>';
	 
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
		  type : "POST",
		  //data: formData,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteBillingEntry", "admin" => false)); ?>"+"/"+recId,
		  context: document.body,
		  success: function(data){ 
			  parent.getProcedureData(patient_id,tariffStandardId);
			  parent.getbillreceipt(patient_id);		
			  $("#busy-indicator").hide();			  
		  },
		  beforeSend:function(){$("#busy-indicator").show();},		  
		});
	}else{
		return false;
	}
});
</script>