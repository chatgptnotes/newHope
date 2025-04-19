<div style="float:right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>

 
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:#fff;padding:10px;margin-top: 80px">

	  <tr>
  <td  valign="bottom" align="center" class="heading" style="text-decoration:none; font-size:18px; margin-top: 50px;">Discharge Summary</td>   
	  </tr> 
   
	<!--  <tr>
  		<td align="center" style="padding:10px;font-size:18px;"><strong><?php  echo $patient['TariffStandard']['name']; ?></strong></td>
  	</tr>
  	<tr>
  		<td align="center" style="font-size:18px;" colspan="2">
  		 <strong>
  		  <?php 
  		     if($patient['FinalBilling']['reason_of_discharge'] == "Recovered") {
  		       //echo __('Regular Discharge');
  		     } 
  		     if($patient['FinalBilling']['reason_of_discharge'] == "DischargeOnRequest") {
  		       echo __('Discharge On Request');
  		     }
  		     if($patient['FinalBilling']['reason_of_discharge'] == "DAMA") {
  		       echo __('Discharge Against Medical Advice');
  		     }
  		     if($patient['FinalBilling']['reason_of_discharge'] == "Death") {
  		       echo __('Death');
  		     }
  		     
  		    
  		  ?>
  		 </strong>
  		</td>
  	</tr> -->
    <tr>
	  <td colspan="2">
       	  <?php echo $this->element('print_patient_header'); 
       	 ?>   
       	    </td>
  	</tr>
    
  <tr>
    <td  align="left" valign="top" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" cellpadding="0" cellspacing="0">
  
 <tr>
    <td width="100%" align="left" valign="top" class="title" style="text-transform:uppercase;font-style:italic; padding: 5px 0 0 7px;">Diagnosis</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">
    	<table width="100%" border="0" cellspacing="1" cellpadding="5" class="" style="border-bottom:1px solid #ccc;">
          <tr>
          		<td style="line-height:20px; font-style:italic;">
				<?php
					echo nl2br($this->data['DischargeSummary']['final_diagnosis']);
				?>
				</td>
          </tr>
        </table>    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
 
 <!--BOF medicine  -->
 <?php
		 $count = count($this->data['PharmacyItem']);	  
		if($count){
		
 ?>
  <tr>
    <td width="100%" align="left" valign="top" class="title" style="text-transform:uppercase; font-style:italic; padding: 5px 0 0 7px;">TREATMENT ON DISCHARGE</td>
  </tr> 	 
		  
		<tr>		 		   
		       	  <td width="100%" valign="top" align="left" style="padding:8px;border-left:2px solid #000000;border-right:2px solid #000000;border-bottom:2px solid #000000;border-top:2px solid #000000;">   
					   <table width="100%" border="0" cellspacing="1" cellpadding="5" id='DrugGroup' class="tbl">
							<tr> 
							  <td width="18%" height="20" align="left" valign="top">Name of Medication</td>	
							  <td width="6%" height="20" align="left" valign="top">Unit</td>
							  <td width="16%" height="20" align="left" valign="top">Remark</td>								  
							  <td width="6%" align="left" valign="top">Route</td>								  
							  <td width="6%" align="left" valign="top">Dose</td>		
							  <td width="8%" align="left" valign="top">Quantity</td>						 
							  <td width="8%" align="left" valign="top">No. of Days</td>								  
							  <td width="36%" align="center" valign="top">Timing</td>	 
							 </tr>
							 <tr>
								  <td width="18%" height="20" align="left" valign="top">&nbsp;</td>								  
								  <td width="6%" height="20" align="left" valign="top">&nbsp;</td>
								  <td width="16%" height="20" align="left" valign="top">&nbsp;</td>
								  <td width="6%" align="left" valign="top">&nbsp;</td>								  
								  <td width="6%" align="left" valign="top">&nbsp;</td>								 
								  <td width="8%" align="left" valign="top">&nbsp;</td>	
								  <td width="8%" align="left" valign="top">&nbsp;</td>
								  <td width="36%" align="center" valign="top"> 
									  	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
									  		<tr>
											  <td width="25%" height="20" align="center" valign="top">I</td>								  
											  <td width="25%" align="center" valign="top">II</td>								  
											  <td width="25%" align="center" valign="top">III</td>								 
											  <td width="25%" align="center" valign="top">IV</td>										  
										  </tr>
									  	</table>
								  </td>
							</tr>
							 <?php 
							 
					$count = count($this->data['PharmacyItem']);	  
					if($count){
						for($i=0;$i<$count;$i++){
								$drugValue= isset($this->data['PharmacyItem'][$i])?$this->data['PharmacyItem'][$i]:'' ;
			               		$pack= isset($this->data['pack'][$i])?$this->data['pack'][$i]:'' ;
			               		$routeValue= isset($this->data['route'][$i])?$this->data['route'][$i]:'' ;
			               		$doseValue= isset($this->data['dose'][$i])?$this->data['dose'][$i]:'' ;
			               		$frequency = isset($this->data['frequency'][$i])?$this->data['frequency'][$i]:'' ;
			   					$quantity = isset($this->data['quantity'][$i])?$this->data['quantity'][$i]:'' ;
			   					$remark = isset($this->data['remark'][$i])?$this->data['remark'][$i]:'' ;
						?>			
							<tr>
								<td><?php echo $drugValue; ?></td>
								<td><?php echo $pack; ?></td>
								<td><?php echo $remark; ?></td>
								<td><?php echo $routeValue; ?></td>
								<td><?php echo $frequency; ?></td>
								<td><?php echo $quantity; ?></td>
								<td><?php echo $doseValue; ?></td>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<?php if(!empty($this->data['first'][$i])){  ?>
												<td  width="25%" align="center"><?php 
													if($this->data['first'][$i] < 12){
														echo $this->data['first'][$i].' AM' ;
													}else{
														if($this->data['first'][$i] == 12)
															echo $this->data['first'][$i].' PM' ;
														else
															echo $this->data['first'][$i]-12 .' PM' ; 
													}
												}else {?>
													</td>
													<td width="25%" align="center"> -- </td> 
												<?php } ?>
												<?php if(!empty($this->data['second'][$i])){ 
														 
												?>
												<td width="25%" align="center"><?php 
													if($this->data['second'][$i] < 12){
														echo $this->data['second'][$i].' AM' ;
													}else{
														if($this->data['second'][$i] == 12)
															echo $this->data['second'][$i].' PM' ;
														else
															echo $this->data['second'][$i]-12 .' PM' ; 
													}
												}else {?>
													</td>
												<td width="25%" align="center"> -- </td> 
												<?php } ?>
												<?php if(!empty($this->data['third'][$i])){ ?>
												<td width="25%" align="center"><?php 
													if($this->data['third'][$i] < 12){
														echo $this->data['third'][$i].' AM' ;
													}else{
														if($this->data['third'][$i] == 12)
															echo $this->data['third'][$i].' PM' ;
														else
															echo $this->data['third'][$i]-12 .' PM' ; 
													}
												}else {?>
													</td>
												<td width="25%" align="center"> -- </td> 
												<?php } ?> 
												<?php if(!empty($this->data['forth'][$i])){ 
														 	
												?>
												<td width="25%" align="center"><?php 
													if($this->data['forth'][$i] < 12){
														echo $this->data['forth'][$i].' AM' ;
													}else{
														if($this->data['forth'][$i] == 12)
															echo $this->data['forth'][$i].' PM' ;
														else
															echo $this->data['forth'][$i]-12 .' PM' ; 
													}
												}else {?>
													</td>
												<td width="25%" align="center"> -- </td> 
										
								<?php } ?> 
								</tr>
									</table>
								</td>
							</tr>
						<?php
							}//EOF for
					}//EOF IF count check ?> 
			 </table>
			</td>
		   </tr> <?php }	?>
		      <!-- EOF new code for medicine timing --> 
  <tr>
    <td width="100%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" class="title" style="text-transform:uppercase; font-style:italic; padding: 5px 0 10px 7px;">ADVICE</td>
  </tr>
  <tr >
    <td width="100%" align="left" valign="top" style="padding-bottom:10px; border-bottom:3px solid #ccc; font-style:italic; padding-left:7px;">
		<?php echo isset($this->data['DischargeSummary']['advice'])?nl2br($this->data['DischargeSummary']['advice']):''; ?>
	 </td>
  </tr>
  </table>
  </td>
    </tr>
   
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr class="page-break">
	<td colspan="2"></td>
  </tr> 
  <tr >
    <td colspan="2" align="left" valign="top" class="title" style="padding-top:10px;">CASE SUMMARY</td>
  </tr>
  <tr>
    <td colspan="2" height="30" align="left" valign="top" style="text-decoration:underline;">Presenting complaints</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style=" border-bottom:1px solid #ccc; padding-bottom:10px;"><?php
		echo nl2br($this->data['DischargeSummary']['complaints']);
	?></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" class="title">EXAMINATION</td>
  </tr>
  <tr>
	    <td colspan="2" align="left" valign="top" >
	    	<table width="100%" border="0" cellspacing="1" cellpadding="5" class="tbl">
			      <tr>
			        <td width="149">Pulse rate &amp; 
			          BP</td>
			        <td width="636" align="left">
						<?php echo  "Temp - ".$diagnosis['TEMP']."℉, P.R. - ".$diagnosis['PR']."/min, R.R. - ".$diagnosis['RR']."/min ,BP - ".$diagnosis['BP']." mm/Hg , SPO2 - ".$diagnosis['spo2']."% in Room 
			          				 Air" ; 
						?>
						 </td>
			      </tr>
			      <tr>
			        <td>General 
			          Examination</td>
			        <td align="left"><?php echo nl2br($this->data['DischargeSummary']['general_examine']);?></td>
			      </tr>			      
	    </table>
	  </td>
  </tr>
   
  <?php if($this->data['DischargeSummary']['investigation']!=''){ ?>
  <tr>
		<td colspan="2" align="left" valign="top" class="title" style="padding-top:10px;">INVESTIGATIONS</td>
  </tr>
  <tr>
		<td colspan="2" height="25" align="left" valign="top" style=" border-bottom:1px solid #ccc; padding-bottom:10px;">
                    <?php //echo nl2br($this->data['DischargeSummary']['investigation']) ; 
                    $lab_ordered = '';
                    foreach($testOrdered as $dept =>$testName){  
                        foreach ($testName as $name) {
                            $lab_ordered .= $name['name'] . ': ' . $name['results'] . "\n\n";
                        }
                    }
                    echo nl2br($lab_ordered) ; ?> </td>  
  </tr>
  <?php } ?>
  <!--
  <tr>
  		<td  class="title"> 
  			<?php /*foreach($testOrdered as $dept =>$testName){    
				if(!empty($testName)){
					echo $dept."<ul>";
					foreach($testName as $name){			
						echo "<li>".$name."</li>";
					}
					echo "</ul>";
				}
  			}*/ ?>
  		 
  		</td>
  </tr>
  -->
 
  <!--<tr>
    <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <?php if(!empty($otList)){ ?>
  <tr>
    <td colspan="2" align="left" valign="top" class="title">OT NOTES</td>
  </tr>
  <?php foreach($otList as $key=> $otArr ){
 
	  $ot = $otArr['OptAppointment'];
	  $sergeryName  = $otArr['Surgery']['name'] ;
 ?>
  <tr>
    <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="5" class="tbl">
      <tr>
        <td width="34" align="center" valign="middle"><strong>.</strong></td>
        <td width="173" align="left">Date</td>
        <td width="29" align="center">:</td>
        <td width="535"><?php
        	if($ot['starttime'])
			echo $this->DateFormat->formatDate2Local($ot['starttime'],Configure::read('date_format'),true);
        ?></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong>.</strong></td>
        <td>Procedure</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php echo ucfirst($sergeryName);?></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong>.</strong></td>
        <td>Surgeon</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php echo $surgonList[$ot['doctor_id']];?></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong>.</strong></td>
        <td>Anaesthetist</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php echo $anaList[$ot['department_id']];?></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong>.</strong></td>
        <td>Anaesthesia</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php echo $ot['anaesthesia'];?></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong>.</strong></td>
        <td>Description</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php echo $ot['description'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
  <?php }
  }else if(!empty($dischargeOT)){ ?>
  <tr>
    <td align="left" valign="top" class="title">OT NOTES</td>
  </tr>
  <?php foreach($dischargeOT as $key=> $otArr ){
 
	  $ot = $otArr['DischargeSurgery'];
	   
	    
 ?>
  <tr>
    <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="5" class="tbl">
      <tr>
        <td width="34" align="center" valign="middle"><strong>.</strong></td>
        <td width="173" align="left">Date</td>
        <td width="29" align="center">:</td>
        <td width="535"><?php
        	if($ot['surgery_schedule_date'])
			echo $this->DateFormat->formatDate2Local($ot['surgery_schedule_date'],Configure::read('date_format'),true);
        ?></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong>.</strong></td>
        <td>Procedure</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php echo $ot['surgery_desc'];?></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong>.</strong></td>
        <td>Surgeon</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php echo $surgonList[$ot['surgon_id']];?></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong>.</strong></td>
        <td>Anaesthetist</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php echo $anaList[$ot['anaesthesian_id']];?></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong>.</strong></td>
        <td>Anaesthesia</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php echo $ot['anaesthesia'];?></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong>.</strong></td>
        <td>Description</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php echo $ot['description'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
  <?php }
  }
  ?> -->
  
  <!--<tr>
    <td align="left" valign="top" colspan="2">&nbsp;</td>
  </tr>
  <?php if(trim($this->data['DischargeSummary']['present_condition']) !='' ){ ?>
	  <tr>
	    <td height="30" align="left" valign="top" class="title" style=" font-weight:bold;" colspan="2">STAY NOTES</td>
	  </tr>
	   <tr>
	    	<td colspan="2" height="25" align="left" valign="top" style=" border-bottom:1px solid #ccc; padding-bottom:10px;"><?php echo nl2br($this->data['DischargeSummary']['present_condition']); ?> </td>
	  </tr>
  <?php } ?>
  <tr>
    <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>-->
 <?php if(!empty($completeDrugArr)) { ?>
 <tr>
    <td colspan="2" align="left" valign="top" class="title" style="text-transform:uppercase;">TREATMENT DURING HOSPITAL STAY</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top">
    	<ul>
        	<?php foreach($completeDrugArr as $drugName){
        		
        				echo "<li>".$drugName."</li>" ;
        				
        		  }
        		  
            ?>
        </ul> 
    </td>
  </tr>
  <?php } ?> 

  <tr>
    <td colspan="2" align="left" valign="top">
    	<?php 
    		echo "The condition of patient at the time of discharge was ";  
    		echo ($this->data['DischargeSummary']['condition_on_discharge'])?$this->data['DischargeSummary']['condition_on_discharge']:_______________________."." ;
    		echo ' '.$this->data['DischargeSummary']['satisfactory_on_discharge'].'.';
    	?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl">
      <tr>
        <td width="166" align="left">Review on</td>
        <td width="27" align="center">:</td>
        <td width="585"><?php echo isset($this->data['DischargeSummary']['review_on'])?$this->data['DischargeSummary']['review_on']:'' ; ?></td>
      </tr>
      <tr>
        <td>Resident On Discharge</td>
        <td align="center" valign="top">:</td>
        <td align="left" valign="top"><?php
			echo $docList[$this->data['DischargeSummary']['resident_doctor_id']] ;
		?></td>
      </tr>
    </table></td>
  </tr>   
  <tr>
   
  </tr>
  <tr>
  <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
	    <td align="left" valign="top" colspan="2">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr><!--
	            <td width="468"><strong style="font-size:16px;">Dr. Abhijieet Fuladi</strong><br />
	              Medical Superintendent<br />
	              Orthopaedic Surgeon</td>
	            --><td   align="right"  class="title"><strong> <!--<?php // echo $treatingConsultant[0]['fullname']; ?>-->
	            
	            <?php
	           /* if(empty($treatingConsultantData['Initial']['initial_name'])){
	            	$getInitial='Dr.';
	            }else{
	            	$getInitial=$treatingConsultantData['Initial']['initial_name'];
	            }*/
	            echo $treatingConsultantData['Initial']['initial_name'].$treatingConsultant[0]['fullname'];
	            echo ",&nbsp";
            	foreach($otherConsultantData as $key=>$value)
            	{            		
            		$val[] = $value['Initial']['nameInitial'].$value['0']['name'];
            	}
            	
            	echo $imp = implode(", ",$val);
            	?>
	            
	            </strong></td>
	          </tr>
        </table>
	     </td>

  </tr>
  
</table>
 <!-- <div style="margin-top:30px;text-align: left;">
<?php 
	//set this variable in ur action
	//fields coming form location table for "footer" and  "header_image" for  header image 
	//echo $this->Session->read('footer') ; 
	//echo $this->Session->read('discharge_text_footer') ;
	
?>
</div>  
 -->