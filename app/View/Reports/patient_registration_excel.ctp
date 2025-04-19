<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Total_Number_Of_UID_Registrations".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
<STYLE type='text/css'>
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
   
</STYLE>

<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
                  <tr class="row_title">
                   <td colspan = "9" align="center"><h2>Total Number Of UID Registrations</h2></td>
                  </tr>
				  <tr class="row_title">
				       <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>
				       <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date Of UID Reg.'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient ID'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td>  
					   <td height="30px" align="center" valign="middle" width="4%"><strong><?php echo __('Age'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="4%"><strong><?php echo __('Sex'); ?></strong></td>
					  <!-- <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Blood Group'); ?></strong></td> 
					   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Location'); ?></strong></td> -->
					   <td height="30px" align="center" valign="middle" width="18%"><strong><?php echo __('Address'); ?></strong></td> 
					   <?php
					   
					   if(!empty($selctedFields)){ 
						   foreach($selctedFields as $key=>$value){
						   		echo ' <td height="30px" align="center" valign="middle" width="12%"><strong>'.$fieldsArr["$value"].'</strong></td>';
						   }
					   }
					  ?>
					   </tr>
					   <?php   //debug($reports); 
	  	 $toggle =0;
	      if(count($reports) > 0) {
			   $k = 1; 
			 
	      		foreach($reports as $pdfData){
	      		    $valCnt++;	
					$person = $pdfData['Person'];
					?>
					<tr>
					    <td align='center' height='17px'><?php echo $valCnt; ?></td> 
						<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($person['create_time'],Configure::read('date_format')); ?></td>
						<td align='center' height='17px'><?php echo $person['patient_uid'] ?></td>	 
					    <td align='center' height='17px'><?php echo $pdfData[0]['full_name'] ?></td>
					    <td align='center' height='17px'><?php echo $person['age'] ?></td>					      
					    <td align='center' height='17px'><?php echo ucfirst($person['sex']) ?></td>
					     <!-- <td align='center' height='17px'><?php echo $person['blood_group'] ?></td>	
					  <td align='center' height='17px'><?php echo ucfirst($person['city']) ?></td>-->	   
					    <td align='center' height='17px'><?php echo $pdfData[0]['address'] ?></td>
					     <?php
						   if(!empty($selctedFields)){ 
							   foreach($selctedFields as $key=>$value){ 
								   if($fieldsArr["$value"] == 'Emergency Contact No' OR $fieldsArr["$value"] == 'Home Phone No' OR $fieldsArr["$value"] == 'Mobile Phone No'){
									if($person["$value"] != '' AND strlen($person["$value"]) >10){
							   			echo "<td align='center' height='17px'>".$person["$value"]."</td>";
									} else {
										echo "<td align='center' height='17px'></td>";
									}
								   } else {
									echo "<td align='center' height='17px'>".$person["$value"]."</td>";
								   }
							   }
						   }
					    ?>
					</tr>
					<?php   
				 $k++; 
			   }
               
			  ?>
			   <tr> 
			   	<td height="30px" align="center" valign="bottom" colspan="<?php echo count($selctedFields)+8; ?>">
				 <strong>Total Patients:<?php echo (count($reports)) ; ?></strong>
				</td>											
			   </tr>
				<?php 		  
				 } else {
					?> <tr>
							<td align="center" height="17px" colspan="9" > No Record Found</td>
									
						</tr>
<?php 
				 }
		?>			   		  
		</table>
		
