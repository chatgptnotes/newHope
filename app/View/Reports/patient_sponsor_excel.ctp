<?php
$searchKey = array("/", " ", ":");
    $searchReplace = array("-","_", ".");
    $currentDate = str_replace($searchKey, $searchReplace, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Empanelment_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
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
<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>	
      <tr class="row_title">
   <td colspan = "12" align="center"><h2>Empanelment Report</h2></td>
  </tr>
	  <tr class='row_title'>
		   <td height='30px' align='center' valign='middle' width='7%'><strong><?php echo __('Sr.No.'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Date Of Reg.'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('MRN'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Patient ID'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Patient Name'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Age'); ?></strong></td>					   
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Sex'); ?></strong></td>
		  
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Address'); ?></strong></td>	
	 <!-- <td height='30px' align='center' valign='middle'><strong><?php echo __('Blood Group'); ?></strong></td>	   	   
		 <td height='30px' align='center' valign='middle'><strong><?php echo __('Email'); ?></strong></td> --> 
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Location'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Sponsor Name'); ?></strong></td>
					   
	 </tr>
 <?php  

	  if(count($reports) > 0 && $reports != '') {
		   $i = 1;
			foreach($reports as $pdfData){	
				 
?>
	<tr>
	   	   <td align="center" height="17px" ><?php echo $i ?></td>
		   <td align="center" height="17px" ><?php echo $this->DateFormat->formatDate2Local($pdfData["Patient"]["form_received_on"],Configure::read('date_format'));?></td>	
		   <td align="center" height="17px" ><?php  echo $pdfData["Patient"]["admission_id"]?></td>
		   <td align="center" height="17px" ><?php  echo $pdfData["Patient"]["patient_id"]?></td>
		   							  
		   <td align="center" height="17px" ><?php echo $pdfData["PatientInitial"]["name"]." ".$pdfData["Patient"]["lookup_name"]?></td>
		   <td align="center" height="17px" ><?php echo $pdfData["Patient"]["age"]?></td>
		   <td align="center" height="17px" ><?php echo ucfirst($pdfData["Patient"]["sex"])?></td>
		  <!--  <td align="center" height="17px" ><?php echo $pdfData["Person"]["blood_group"]; ?></td>
		   <td align="center" height="17px" ><?php echo $pdfData["Patient"]["email"]?></td>	 -->
		   <td align="center" height="17px" ><?php echo $pdfData[0]["address"]?></td> 
		  
		   <td align="center" height="17px" ><?php echo $pdfData["Person"]["city"]?></td>
		   
		   <td align="center" height="17px" >
		    <?php //if($pdfData["Corporate"]["name"]) echo $pdfData["Corporate"]["name"]; elseif($pdfData["InsuranceCompany"]["name"]) echo $pdfData["InsuranceCompany"]["name"]; elseif($pdfData["Patient"]["payment_category"] == "cash") echo __('Private');
					echo  $pdfData["TariffStandard"]["name"];?>
		   </td>
		   
	 
					
<?php $i++;  } ?> 
	<tr>
		 <td height='30px' align='center' valign='middle' colspan="12"><strong>Total Patients :</strong>
		 <?php echo count($reports); ?></td>
	 </tr>
<?php	} else { ?>
		<tr>
			<td colspan = '12' align='center' height='30px'>No Record Found</td>
		</tr>
	 <?php } ?>
			   		  
</table>
