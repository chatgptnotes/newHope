<?php if($this->Session->read('website.instance')=='hope'){?>
<table width="80%" align="center" cellpadding="0" cellspacing="0" border="0" >
  <tr> 
    <td align="right">Date: 
          <?php if($this->params['action'] != 'opd_patient_detail_print') { 
               echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),false);
          }else{
              echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);
          }
?></td>
  </tr>
</table>
<?php } 
$address=$patientDetailsForView['Person']['plot_no']." ".$patientDetailsForView['Person']['landmark']." ".$patientDetailsForView['Person']['city'];
?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="tbl" style="border:1px solid #3e474a;">
                   		<tr>
	                        <td width="50%" valign="top">
	                            <table width="100%" border="0" cellspacing="2" cellpadding="2" >
	                              <tr>
	                              	<td></td>
	                                <td  valign="top" > Name </td><td>:</td>
	                                <td align="left" valign="top"><?php 
	                               // echo $complete_name  =  $patient['Patient']['lookup_name'] ;
	                               // echo $complete_name  =  $patient['Patient']['lookup_name'] ; 
									$complete_name = $patient['Person']['first_name'] . ' ' . $patient['Person']['middle_name'] . ' ' . $patient['Person']['last_name'];
									echo $complete_name;
	                                ?></td>

	                              </tr>
	                              <?php if($this->Session->read('website.instance')=='vadodara'){?>
	                              <tr>
	       						  	<td></td>
	                                <td valign="top" ><?php echo __('Primary Care Provider ')?></td><td>:</td>
	                                <td align="left" valign="top" style="padding-bottom:10px;">
	                                <?php  
                                            if(!empty($doctorIDArrName) || !empty($treating_consultant)){//if service wise doctor is available
                                                    echo ($doctorIDArrName)?$doctorIDArrName:ucfirst($treating_consultant[0]['fullname']) ;
                                            }else{//otherwise use default doctor
                                                    echo ucfirst($patient['User']['first_name'].' '.$patient['User']['last_name']) ;
                                            }
	                                ?></td>
	                              </tr>
	                              <?php }else{?>
	       						  <tr>
	       						  	<td></td>
	                                <td valign="top" >
                                            <?php if($this->params['action'] != 'opd_patient_detail_print') {  
                                                echo __('Primary Care Provider');
                                            }else{
                                                 echo __('Name of Consultant');
                                             }
                                            
                                        ?>
                                        </td><td>:</td>
	                                <td align="left" valign="top" style="padding-bottom:10px;">
	                                		<?php if($patient['Patient']['admission_type']=='IPD') {  
                                                echo ucfirst($treating_consultant[0]['fullname']) ;
                                            }else if($patient['Patient']['admission_type']!='IPD') {  
                                                echo ucfirst($treating_consultant[0]['fullname']) ;
                                            }else{
                                                
                                               echo ucfirst($doctorIDArrName);
                                             }
	                             
	                               		 
	                                ?>

	                                </td>
	                              </tr>
	                              <?php }?>
	                               <tr>
	                               <td></td>
	                                <td valign="top" >Sex / Age </td><td>:</td>
	                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($sex);?> / <?php echo ucfirst($age)?></td>
	                              </tr>
	                              <tr>
	                              	<td></td>
					           		 <td valign="top">Tariff </td><td>:</td>
					          		 <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $patientDetailsForView['TariffStandard']['name']; $sublocation = $patientDetailsForView['CorporateSublocation']['name']; if(!empty($sublocation)) { echo " (".$sublocation.")"; }?></td>
					        	 </tr>
	                              <?php if($patient['Patient']['admission_type']=="IPD"){?>
	                              <tr>
	                              <td></td>
					        		<td valign="top" >Ward /Room</td><td>:</td>			
									<td align="left" valign="top" style="padding-bottom:10px;">	
									<?php if($this->Session->read('website.instance')=='vadodara'){
											echo $wardInfo['Ward']['name']."/".$wardInfo['Room']['bed_prefix']." ".$wardInfo['Bed']['bedno'];
										}else{
											echo ucfirst($wardInfo['Ward']['name']) ."/". ucfirst($wardInfo['Room']['name']) ;
										}?>
									</td>
								</tr>
								
								<?php

								 if($consultanName){?>
								<tr>
									<td></td>
					        		<td valign="top" >Referral Doctor</td><td>:</td>
					        		<td align="left" valign="top" style="padding-bottom:10px;">					
											<?php foreach($consultanName as $cname){
												echo $cname['Consultant']['first_name']." ".$cname['Consultant']['last_name']." , ";
											}?>
									</td>
								</tr>
								<?php }?>
								<?php }?>
	                            </table> 
	                        </td>
                           
                            <td width="50%" valign="top">
	                            <table align="right" width="100%" border="0" cellspacing="2" cellpadding="2" >
	                             <tr>
	                                <td style="float: right" valign="top"  id="boxSpace3" >Patient ID </td><td>:</td>
	                                <td valign="top" style="padding-bottom:10px;"><?php echo $patient['Patient']['patient_id'] ;?></td>
	                              </tr>
	                              
	                              <tr>
	                              <?php if($this->Session->read('website.instance')=='vadodara'){?>
	                              <td style="float: right" valign="top"  id="boxSpace3" >Visit Date</td><td>:</td>
	                                <td valign="top"><?php echo $this->DateFormat->formatDate2Local($patientDetailsForView['Patient']['form_received_on'],Configure::read('date_format'),false)?></td>
	                              <?php }else{?>
	                                <td style="float: right" valign="top"  id="boxSpace3" >Registration ID </td><td>:</td>
	                                <td valign="top"><?php echo $patient['Patient']['admission_id'] ;?></td>
	                                <?php }?>
	                              </tr>
	                              <?php  if($this->Session->read('website.instance')=="hope" || $this->Session->read('website.instance')=="vadodara"){?>
					        	 	<tr>
					        	  	<td style="float: right" valign="top"  id="boxSpace3">Patient No</td><td>:</td>
					          		 <td valign="top" style="padding-bottom:10px;"><?php echo $patientDetailsForView['Person']['mobile'];?></td>
					        	</tr>
					        	<?php }?>
	                            
					        	<?php if($this->Session->read('website.instance')=='hope'){?>
					        	<tr>
					           		 <td  style="float: right" valign="top"  id="boxSpace3" >Address </td><td>:</td>
					          		 <td  valign="top" style="padding-bottom:10px;"><?php echo $address;?></td>
					        	</tr>
					        	<?php } ?>
					        	<?php if($this->Session->read('website.instance')=='vadodara'){?>
					        	 <tr>
					           		 <td  style="float: right" valign="top"  id="boxSpace3" >Receipt Time</td><td>:</td>
					          		 <td  valign="top" style="padding-bottom:10px;"><?php 
					          		 if($billData['Billing']['create_time']!=''){
					          		    echo $this->DateFormat->formatDate2Local($billData['Billing']['create_time'],Configure::read('date_format'),true);
					          		 }else{
					          		 	echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);
					          		 }
					          		 ?></td>
					        	</tr>
					        	<?php }?>
					        	<?php if($patient['Patient']['admission_type']=="IPD"){?>
					         	 <tr>
								<td  style="float: right" valign="top"  id="boxSpace3" >Bed No</td><td>:</td>				
														
									<td align="left" valign="top" style="padding-bottom:10px;">					
											<?php echo $wardInfo['Room']['bed_prefix'].$wardInfo['Bed']['bedno'] ;?>
									</td>
					        	</tr> 
					        	
					        	<?php if($consultanName){ ?>
					        	<tr>
									<td style="float: right" valign="top"  id="boxSpace3">ReferralDoctor No</td><td>:</td>
					        		<td align="left" valign="top" style="padding-bottom:10px;">					
										<?php foreach($consultanName as $cname){
											echo $cname['Consultant']['mobile']."  ";
										}?>
									</td>
								</tr>
								<?php }?>
								<?php }?>
					        	<?php if(!empty($UIDpatient_details['User']['first_name']) && !empty($UIDpatient_details['User']['last_name'])){?>
					        	<tr>
								    <td  style="float: right" valign="top"  id="boxSpace3" >Username</td><td>:</td>									
									<td align="left" valign="top" style="padding-bottom:10px;">					
											<?php  echo "<strong>".ucfirst($UIDpatient_details['User']['first_name'].' '.$UIDpatient_details['User']['last_name'])."</strong>" ;?>
									</td>
					        	</tr> 
					        	<?php } else if(!empty($billCreatedBy)){?>
					        	<tr>
								    <td  style="float: right" valign="top"  id="boxSpace3" >Username</td><td>:</td>									
									<td align="left" valign="top" style="padding-bottom:10px;">					
											<?php  echo "<strong>".ucwords($billCreatedBy)."</strong>" ;?>
									</td>
					        	</tr> 
					        	<?php } ?>
					        	<!--  <tr>
								    <td  style="float: right" valign="top"  id="boxSpace3" ><?php echo $this->Html->image("/".$patientDetailsForView['Patient']['admission_id_qrcode'], array('alt' => '','title'=>'','width'=>'100','height'=>'20'));?></td><td>:</td>									
									<td align="left" valign="top" style="padding-bottom:10px;"><?php echo $this->Html->image("/".$patientDetailsForView['Patient']['patient_name_qrcode'], array('alt' => '','title'=>'','width'=>'100','height'=>'20'));?></td>
					        	</tr> -->
					        	</table>
	                         </td>
	                         
                          
                        </tr>
             </table>
             
    