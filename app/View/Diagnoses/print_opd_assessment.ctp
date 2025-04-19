 <style>
	.formFull td {
	    color: #333333;
	    font-size: 13px;
	    padding: 2px 0;
	}
	.tabularForm {
	    background:#000;
	}
	
	.tabularForm td td{
	    background: #ffffff;
	    color: #333333;
	    font-size: 13px;
	    padding: 5px 8px;
	}
	
	.{color:#333333; }
	
	#printBtn{
		float:right;
		padding:10px 40px 0px 0px;
	}
	
	.fontSize{
		font-weight:bold;
	}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.tbl .totalPrice{font-size:14px;}
</style>
	<div id="printButton" >
		<?php echo $this->Html->link('Print',"#",array('escape'=>true,'class'=>'blueBtn','onclick'=>'window.print();'))?>
	</div>
	<div class="clr"></div>
 	<?php echo $this->element('print_patient_info');?>
     <table   style="text-align:left;" width="100%" align="center">
     	<?php if(!empty($diagnosis['Diagnosis']['complaints'])){ ?>
	 		<tr>
	   				 <td width="19%" valign="top" class=" fontSize" style="padding-top:10px;">
	   				 		<?php echo __('Presenting Complaints With Duration');?>
	   				 </td>
	   				  <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	   				  	<?php echo nl2br($diagnosis['Diagnosis']['complaints']); ?>
	   				  </td>
	   		</tr>
   		<?php }if(!empty($diagnosis['Diagnosis']['general_examine'])){ ?>
	 		<tr> 
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                    Physical Examination
	             </td>
	            <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	            	<?php echo nl2br($diagnosis['Diagnosis']['general_examine']) ;?>
	       		</td>
	       	</tr>
       	<?php } 
       		if($diagnosis['Diagnosis']['TEMP'] !='' ||
       		$diagnosis['Diagnosis']['RR'] !=''||
       		$diagnosis['Diagnosis']['BP'] !='' ||
       		$diagnosis['Diagnosis']['PR'] !='') { 
       	?>
	     	<tr>
	             <td width="19%" valign="middle" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                    Vital Signs:
	             </td>
	            <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	            	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
		                  <tr>				                  	
		                  	<td valign="top">Temp:<?php echo $diagnosis['Diagnosis']['TEMP'] ;?>&#8457;</td>
		                  	<td valign="top">P.R.:<?php echo $diagnosis['Diagnosis']['PR'] ;?>/Min</td>
		                  	<td valign="top">R.R.: <?php echo $diagnosis['Diagnosis']['RR'] ;?>/Min</td>
		                  	<td valign="top">BP: <?php echo $diagnosis['Diagnosis']['BP'] ;?> mm/hg</td>
		                  	<td valign="top">SPO<sub>2</sub>: <?php echo $diagnosis['Diagnosis']['spo2'] ;?>% in Room Air</td>
		                  </tr>
		            </table>
	       		</td>
	       	</tr>
	       	<?php }if($diagnosis['Diagnosis']['rectal_option'] !=''){ ?>
			<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                    Rectal Examination
	             </td>
	             <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	            	<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
	            		  <tr>
	            		  	<td valign="top"><?php echo $diagnosis['Diagnosis']['rectal_examine']."  " ;
	            		  	?>
	            		  	<strong>
	            		  	<?php 
	            		  	echo ($diagnosis['Diagnosis']['rectal_option']==0)?'(Declined)':'(Not Declined)' ;
	            		  	?>
	            		  	</strong>
	            		  	</td>
	            		  </tr> 
		            </table>
	       		</td>
	       	</tr>
       	<?php } if(strtolower($patient['Patient']['sex'])=='female' && $diagnosis['Diagnosis']['breast_option'] !='') { ?>	 
			<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                    Examination of breasts
	             </td>
	            <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	            	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	            		<tr>
	            			<td valign="top"><?php echo $diagnosis['Diagnosis']['breast_examine'] ?>
	            		  	<strong>
	            		  	<?php 
	            		  	echo ($diagnosis['Diagnosis']['breast_option']==0)?'(Declined)':'(Not Declined)' ;
	            		  	?>
	            		  	</strong>
	            		  	</td> 
		                </tr>		             
		            </table>
	       		</td>
	       	</tr>
       	<?php } 
       		if($diagnosis['Diagnosis']['pelvic_option'] !=''){
       	?>
	       	<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                    Pelvic Examination/External Genitalia
	             </td>
	            <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	            	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	            		  <tr>
	            		  	<td valign="top"><?php echo nl2br($diagnosis['Diagnosis']['pelvic_examine']) ?>
		            		  	<strong>
		            		  	<?php 
		            		  	echo ($diagnosis['Diagnosis']['pelvic_option']==0)?'(Declined)':'(Not Declined)' ;
		            		  	?>
		            		  	</strong>
		            		</td> 
		                  </tr>
		            </table>
	       		</td>
	       	</tr>
       	<?php } if(trim($diagnosis['Diagnosis']['provisional_diagnosis'])!=''){ ?>		 	 
			<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                    Provisional Diagnosis
	             </td>
	            <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	            	<?php echo nl2br($diagnosis['Diagnosis']['provisional_diagnosis']) ;?>            	 
	       		</td>
	       	</tr>		 
       	<?php } if(trim($diagnosis['Diagnosis']['final_diagnosis']) != ''){?>
	       	<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                    Diagnosis
	             </td>
	            <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	            	  <?php echo nl2br($diagnosis['Diagnosis']['final_diagnosis']) ;?> 
	       		</td>
	       	</tr>
       	<?php 
       	}if(trim($diagnosis['Diagnosis']['ICD_code'])!=''){
       	?>
	       	<tr>
	                <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                	<strong>ICD Codes:</strong>
	                	<?php
	                		if(empty($diagnosis['Diagnosis']['ICD_code'])){
	                			$display ="none";
	                		}else{
	                			$display ="block";
	                		}
	                	?>
	                </td>
	                <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	                	<div id="icdSlc"   style="display:<?php echo $display ;?>;">
	                		<?php               	  			 
	                			$noOfIds =  count($icd_ids);
	                			?>
	                			<table width="100%" cellpadding="2" cellspacing="1" border="0" class="tbl">	
	                			<?php 
	                			for($k=0;$k<$noOfIds;){
	                				$id = $icd_ids[$k]['SnomedMappingMaster']['id'] ;
	                				//echo "<p id="."icd_".$id." style='padding:0px 10px;'>";
	                				echo "<tr>";
	                				echo "<td>".$icd_ids[$k]['SnomedMappingMaster']['icd_code']."</td><td>".$icd_ids[$k]['SnomedMappingMaster']['description'].'</td>';				              	  					
	                		        echo "</tr>";                        
	                				$k++ ;
	                			}
	                		?>   
	                		 </table>         
	               	</div>
	            </td>  
	        </tr>
        <?php } if(!empty($test_ordered)){ ?>  
		   	<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                  Laboratory
	             </td>
	             <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	             	<table border="0" cellspacing="0" cellpadding="3" class="tbl" width="100%" style="text-align:left;">
					    <tr class=" "> 
						   <td class=" "><strong><?php echo __('Test Name', true); ?></strong></td>  
						   </tr>
					  	   <?php 
						  		$toggle =0; 
								foreach($test_ordered as $labs){  ?>		
									   <tr>			 
										   <td class="row_format"><?php echo ucfirst($labs['Laboratory']['name']); ?> </td> 
									   </tr>
						  <?php }   ?> 
					</table>        	
	       		 </td>
	       	</tr>
       	<?php }   if(!empty($radiologyTestOrdered)){ ?>  
		   	<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                  Radiology
	             </td>
	             <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	             	<table border="0" cellspacing="0" cellpadding="3" class="tbl" width="100%"  >
					    <tr class=" "> 
						   <td class=" "><strong><?php echo __('Test Name', true); ?></strong></td> 
						</tr>
					  <?php 
						  $toggle =0; 
						  foreach($radiologyTestOrdered as $labs){  
								  ?>		
								   <tr>	 
								   	 <td class="row_format"><?php echo ucfirst($labs['Radiology']['name']); ?> </td> 
								 </tr>
					  <?php }   ?> 
					</table>  	
	       		 </td>
	       	</tr>
       	<?php }  if(!empty($diagnosis['Diagnosis']['surgery'])){ ?>
	       	<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                    <?php echo ucwords("Procedure if any"); ?>
	             </td>
	            <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	            	<?php echo nl2br($diagnosis['Diagnosis']['surgery']) ;?>        	
	       		</td>
	       	</tr>  
       	<?php }
			if(!empty($consultant['DoctorProfile']['doctor_name'])){
       	?>
			<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                   Consultants Opinion
	             </td>
	             <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	            	<table width="100%" cellpadding="2" cellspacing="1" border="0" class="tbl">	
						<tr>
							<td valign="top" width="50%"><strong>S/B</strong> <?php echo $consultant['DoctorProfile']['doctor_name'] ;?></td>							
							<td valign="top"><strong>Date/Time</strong> <?php
							if($diagnosis['Diagnosis']['consultant_on'])
							echo $this->DateFormat->formatDate2Local($diagnosis['Diagnosis']['consultant_on'],Configure::read('date_format'),true);
							?></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo nl2br($diagnosis['Diagnosis']['consultant_note']) ;?></td>
						</tr>							
					</table>				
	       		 </td>
	       	</tr> 
	       	  <tr>
	            <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                    Signature
	             </td>
	            <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	            ______________________
	       		</td>
	       </tr>  
       <?php }
		if(!empty($diagnosis['Diagnosis']['plancare_desc'])){
       ?>  
		   	<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                  Plan of care
	             </td>
	             <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	             	<?php echo nl2br($diagnosis['Diagnosis']['plancare_desc']) ;?>            	
	       		 </td>
	       	</tr>
       	<?php } ?>
	       	<tr>     
                  <td  width="80%" valign="top"   style="padding-top:10px;" colspan="2">
                  	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" align="center">
                  		<tr>
                  			<td width="50%" valign="top">
                  				<table width="100%" border="0" cellspacing="1" cellpadding="0">	
                  					<tr>
                  						<td valign="top">Declaration by the Patient / Relative / Accompanying Person</td>
                  					</tr>
                  					<tr>
			                  			<td valign="top">
			                  				I  hereby declare that the facts recorded above are based on my narration and are accurate to the best of my knowledge
			                  			</td>
                  					</tr>
                  				</table>                  				
                  			</td>                  			
                  			<td width="50%">
                  				<table width="100%" border="0" cellspacing="1" cellpadding="0">	
                  					<tr>
                  						<td colspan="2" valign="top">Name of Patient / Relative / Accompanying</td>
                  					</tr>
                  					<tr>
			                  			<td valign="top">Person </td>
			                  			<td>:__________________________</td>
                  					</tr>
                  					<tr>
			                  			<td valign="top">Relationship With Patient </td>
			                  			<td>:__________________________</td>
                  					</tr>
                  					<tr>
			                  			<td valign="top">Signature  </td>
			                  			<td>:__________________________</td>
                  					</tr>
                  					<tr>
			                  			<td colspan="2" valign="top">Date : ___________ Time : _______</td>
                  					</tr>
                  				</table>                  				
                  			</td>
                  		</tr>                  		
                  </table>                   
             </td>
	       </tr> 
     </table> 