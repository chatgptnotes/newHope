<div id="printButton" >
		<?php echo $this->Html->link('Print',"#",array('escape'=>true,'class'=>'blueBtn','onclick'=>'window.print();'))?>
	</div>
	<div class="clr"></div>
			<!--<div class="">
				<?php //onload="window.print();window.close();"
					//echo $this->Html->image('/img/Portal_images/logo.png',array('alt'=>__(ucfirst($this->Session->read('facility'))),'border'=>0));
					//echo $this->Html->image($this->Session->read('header_image'),array('alt'=>ucfirst($this->Session->read('facility')),'title'=>ucfirst($this->Session->read('facility'))))
				?>
				<span style="float:right;font-size:18px;">
			 	 <?php 
		                       $firstname = $this->Session->read('first_name');
		                       if(!empty($firstname)) {
		                         	echo  ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location')) ;
		                       }
		         ?>	 	  
		         </span>
			</div> 
			--><div class="clr">&nbsp;</div>
			 	<table width="100%" border="0" cellspacing="0" cellpadding="0" id='DrugGroup' class="tableBorder" > 
			 			<tr>
                              	<td colspan="2" class="column"><strong>Patient Information</strong></td>
                        </tr>
                   		<tr>
                        	<td width="330" valign="top" class="column">
	                            <table width="100%" border="0" cellspacing="0" cellpadding="0"   >
		                              <tr>
		                                <td width="38%" height="25" valign="top" class="tdLabel2">Name </td>
		                                <td align="left" valign="top">
		                                	<?php
		                                		echo $complete_name  = $patient[0]['lookup_name'] ; 
		                                	?>
										</td>
		                              </tr>
		                             <tr>
		                                <td valign="top" class="tdLabel1" id="boxSpace2"><?php echo Configure::read('doctor'); ?></td>
		                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($treating_consultant[0]['fullname']) ;?></td>
		                              </tr>
		                              <tr>
		                                <td valign="top" class="tdLabel1" id="boxSpace2">Date/Time</td>
		                                <td align="left" valign="top" style="padding-bottom:10px;"><?php
		                                $currentDate = date("Y-m-d H:i:s") ;  
		                                echo $this->DateFormat->formatDate2Local($currentDate,Configure::read('date_format'),true);
		                                 ?></td>
		                              </tr>
		                              <?php 
		                              		if($patient['Patient']['admission_type']=='IPD'){
		                              ?>
		                              
		                              <tr>
		                                <td valign="top" class="tdLabel1" id="boxSpace2">Ward/Bed No</td>
		                                <td align="left" valign="top" style="padding-bottom:10px;">
		                                	<?php
		                                		 
		                                		echo  ucfirst($ward_details['Ward']['name'])."/".$room_details['Room']['bed_prefix'].$bed_details['Bed']['bedno'] ;?></td>
		                              </tr>
		                              <?php } ?>
		                              <tr>
										  <td valign="top" class="tdLabel1" id="boxSpace2"> 
										   <?php echo __('S/B Consultant',true); ?>
										  </td>
										  <td align="left" valign="top" style="padding-bottom:10px;">
										   <?php  echo ucfirst($registrar[0]['fullname']); ?>
										  </td>
									 </tr>
									 <tr>
										  <td valign="top" class="tdLabel1" id="boxSpace2"> 
										   <?php echo __('S/B Registrar',true); ?> 
										  </td>
										  <td align="left" valign="top" style="padding-bottom:10px;">
										   <?php echo ucfirst($consultant[0]['fullname']); ?>
										  </td>
									 </tr>
	                            </table>  
  							</td>
                            <td width="350" valign="top" class="columnLast">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" >                            
                              <tr>
                                <td valign="top" class="tdLabel1" id="boxSpace3">Patient ID</td>
                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $patient['Patient']['patient_id'] ;?>
                                </td>
                              </tr>
                                <tr>
                                <td width="110" height="25" valign="top" class="tdLabel1" id="boxSpace3">Registration ID </td>
                                <td align="left" valign="top"><?php echo $patient['Patient']['admission_id'] ;?></td>
                              </tr>
                                <tr>
                                <td width="110" height="25" valign="top" class="tdLabel1" id="boxSpace3">Prescription ID </td>
                                <td align="left" valign="top"><?php echo $prescription_id ;?></td>
                              </tr>
                              <tr>
                                <td valign="top" class="tdLabel1" id="boxSpace4">Sex</td>
                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($sex);?></td>
                              </tr>
                              <tr>
                                <td valign="top" class="tdLabel1" id="boxSpace5">Age</td>
                                <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($age)?></td>
                              </tr>
                            </table>
                           </td>
                        </tr>
                     </table>
                     <div class="clear">&nbsp;</div>
					 <table width="100%" border="0" cellspacing="1" cellpadding="0" id='DrugGroup' class="tabularForm">
				<tr>
				  <td width="27%" height="20" align="left" valign="top"><b>Name of Medication</b></td>
				  <td width="27%" height="20" align="left" valign="top"><b>Unit</b></td>		
				  <td width="7%" align="left" valign="top"><b>Routes</b></td>		
				  <td width="8%" align="left" valign="top"><b>Dose</b></td>								  
				  <td width="9%" align="left" valign="top"><b>Quantity</b></td>
				  <td width="9%" align="left" valign="top"><b>No. Of Days</b></td>				 
				  <td width="20%" valign="top" colspan="4" align="center"><b>Timings</b></td>				 
				 </tr>
			 <?php  foreach($medicines as $drugs) {?>					
				<tr>
					<td><?php echo $drugs['PharmacyItem']['name']; ?></td>
					<td><?php echo $drugs['PharmacyItem']['pack']; ?></td>
					<td><?php echo $drugs['SuggestedDrug']['route']; ?></td>
					<td><?php echo $drugs['SuggestedDrug']['frequency']; ?></td>
					<td><?php echo $drugs['SuggestedDrug']['quantity']; ?></td>
					<td><?php echo $drugs['SuggestedDrug']['dose']; ?></td>
					<?php if(!empty($drugs['SuggestedDrug']['first'])){  ?>
					<td><?php 
						if($drugs['SuggestedDrug']['first'] < 12){
							echo $drugs['SuggestedDrug']['first'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['first'] == 12)
								echo $drugs['SuggestedDrug']['first'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['first']-12 .' PM' ; 
						}
					}else {?>
						</td>
						<td> -- </td> 
					<?php } ?>
					<?php if(!empty($drugs['SuggestedDrug']['second'])){ 
							 
					?>
					<td><?php 
						if($drugs['SuggestedDrug']['second'] < 12){
							echo $drugs['SuggestedDrug']['second'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['second'] == 12)
								echo $drugs['SuggestedDrug']['second'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['second']-12 .' PM' ; 
						}
					}else {?>
						</td>
					<td> -- </td> 
					<?php } ?>
					<?php if(!empty($drugs['SuggestedDrug']['third'])){ ?>
					<td><?php 
						if($drugs['SuggestedDrug']['third'] < 12){
							echo $drugs['SuggestedDrug']['third'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['third'] == 12)
								echo $drugs['SuggestedDrug']['third'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['third']-12 .' PM' ; 
						}
					}else {?>
						</td>
					<td> -- </td> 
					<?php } ?> 
					<?php if(!empty($drugs['SuggestedDrug']['forth'])){ 
							 	
					?>
					<td><?php 
						if($drugs['SuggestedDrug']['forth'] < 12){
							echo $drugs['SuggestedDrug']['forth'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['forth'] == 12)
								echo $drugs['SuggestedDrug']['forth'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['forth']-12 .' PM' ; 
						}
					}else {?>
						</td>
					<td> -- </td> 
					<?php } ?> 
				</tr>
			<?php } ?>
			</table>					   		
		   <div style="float:left;padding-top:50px;">
		   		__________________________
		   		<br/><br/>
		   		<span style="padding-left:50px"">
		   			Doctors Name
		   		</span>
		   </div>
		   <div style="float:right;padding-top:50px;">
		   		________________
		   		<br/><br/>
		   		<span style="padding-left:40px">
		   			Sign
		   		</span>
		   </div>
		  <div class="clr">&nbsp;</div>
		  
