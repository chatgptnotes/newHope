<style>
.table_format_head{
padding-bottom:0px;
padding-left:20px;
padding-right:20px;

}
.table_format_body{
padding-bottom:20px;
padding-left:20px;
padding-right:20px;

}
</style>
<?php
	
	//App::import('Vendor','xtcpdf'); 
	//$tcpdf = new XTCPDF();	
	//ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Registration Report By Referral Doctor'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Registration Report By Referral Doctor'; 
	}
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$tcpdf->SetCreator(PDF_CREATOR);
	$tcpdf->SetAuthor($facilityname);
	$tcpdf->SetTitle($facilitynamewithreport);
	$tcpdf->SetSubject('Report');
	//$tcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
	 
	// set default header data
	$tcpdf->SetHeaderData($headerimage, PDF_HEADER_LOGO_WIDTH, $facilitynamewithreport, $headerString, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));
	
	// set header and footer fonts
	$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set default monospaced font
	$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	//set margins
	$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	
	//set auto page breaks
	$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	//set image scale factor
	$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	
	// ---------------------------------------------------------
	
	// set font
	$tcpdf->SetFont('dejavusans', '', 6);
	
	// add a page (required with recent versions of tcpdf)
	$tcpdf->AddPage(); 





?>


 <div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Patient Portal', true); ?>
	</h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
			</div></td>
	</tr>
</table>
<?php } ?>
 
<p class="ht5"></p>

<?php 
           echo $this-> element("patient_information");
           ?>
  <!-- Care Team Start -->          
      <?php    
   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>Care Team</strong></td>
				</tr>
		</table>';	
					       
 $html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	<tr>
		
		<td>
			<table  class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" border="0" >
				<tr class="row_title">
					<td class="table_cell"><strong> '.("MRN").'</strong></td>
					<td class="table_cell"><strong>'.("Provider's Name").'</strong></td>
					<td class="table_cell"><strong>'.("Provider's Address").'</strong></td>
					<td class="table_cell"><strong>'.("Provider's City").'</strong></td>
					<td class="table_cell"><strong>'.("Provider's State").'</strong></td>
					<td class="table_cell"><strong>'.("Provider's Zip Code").'</strong></td>
					<td class="table_cell"><strong>'.("Provider's Country").'</strong></td>
					<td class="table_cell"><strong>'.("Provider's Telephone").'</strong></td>
					
				</tr>
				<?php
				$count=0; 
				$toggle =0;

				foreach($careTeam as $team){
							
						if($toggle == 0) {
							<tr class="row_gray">
							$toggle = 1;
						}else{
							<tr>
						}
				$count++;	 ?>
				
			<tr class="row_gray">
					<td class="row_format">&nbsp;'.  $team['Patient']['admission_id']. '</td>
					<td class="row_format">&nbsp;'. $team['Initial']['name'].' '.$team['User']['first_name'].' '.$team['User']['last_name'] .'</td>
					<td class="row_format">&nbsp;'. $team['User']['address1'].' '.$team['User']['address2'].'</td>
					<td class="row_format">&nbsp;'. $team['City']['name'].'</td>
					<td class="row_format">&nbsp;'. $team['State']['name'] .'</td>
					<td class="row_format">&nbsp;'.$team['User']['zipcode'].'</td>
					<td class="row_format">&nbsp;'. $team['Country']['name'].'</td>
					<td class="row_format">&nbsp;'. $team['User']['phone1'].'</td>
				
				</tr>
				
				<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id="cmnt_presc '.$count.';" ><span></span></td>
				</tr>
			<?php } ?>
		</table>


</table>';    ?>      
<!-- Care Team End -->    


<!-- Social History Start -->  
 <?php 

 $html.='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong> '. __("Social History").'</strong></td>
				</tr>
		</table>';	
					       
  $html.='<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" >
	
	<tr>
		
		<td>
			<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>'.("MRN").'</strong></td>
					<td class="table_cell"><strong>'.("Smoking Frequency").'</strong></td>
					<td class="table_cell"><strong>'.("Current Smoking Frequency").'</strong></td>
					<td class="table_cell"><strong>'.("Snomed Code").'</strong></td>
					<td class="table_cell"><strong>'.("Date").'</strong></td>
					
					
				</tr>
				<?php
				$count=0; 
				$toggle =0;
				
				foreach($diagnosisRec as $rec){
							
						if($toggle == 0) {
							echo "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							echo "<tr>";
							$toggle = 0;
						}
				$count++;	 ?>
				
				$html .='<tr class="row_gray">
					<td class="row_format">&nbsp;'. $rec['Patient']['admission_id'].'</td>
					<td class="row_format">&nbsp;'.$rec['SmokingStatusOncs']['smoking_fre'].'</td>
					<td class="row_format">&nbsp;'. $rec['SmokingStatusOncs1']['description'].'</td>
					<td class="row_format">&nbsp;'. $rec['SmokingStatusOncs']['snomed_id'].'</td>
					<td class="row_format">&nbsp;'. $rec['PatientSmoking']['created_date'].'</td>
				</tr>
				
				<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc<?php echo $count; ?>'><span></span></td>
				</tr>
			<?php } ?>
		</table>


</table>';          
<!-- Social History End -->    


<!-- Medication Allergy Start -->   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>'. __("Medication Allergies").'</strong></td>
				</tr>
							</table>';	
					       
 $html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	$html .='<tr>
		
		<td>
			<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong>Allergy Id</strong></td>
					<td class="table_cell"><strong>Allergy Name</strong></td>
					<td class="table_cell"><strong>Rx Norm</strong></td>
					<td class="table_cell"><strong>Allergy Status</strong></td>
					
				</tr>';
				<?php
				$count=0; 
				$toggle =0;
				//echo '<pre>';print_r($allergiesSpecific); exit;
				$CountOfPrescriptionRecord=count($setAllergies);
	 							for($counter=0;$counter < $CountOfPrescriptionRecord;$counter++){
						if(($count % 2) == 0) {
							echo "<tr class='row_gray'>";
							
						}else{
							echo "<tr>";
							
						}
				$count++;	 ?>
				
			
					<!--<td class="row_format">&nbsp;<?php echo $counter+1; ?> -->
					<td class="row_format">&nbsp;'. $setAllergies[$counter][0].'
					<td class="row_format">&nbsp;'. $setAllergies[$counter][1].'</td>
					<td class="row_format">&nbsp;'. $setAllergies[$counter][2].'</td>
					<td class="row_format">&nbsp;'. if($setAllergies[$counter][3] == 'A') echo "Active";  .'</td>
				
				</tr>
				
				<tr>';
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc<?php echo $count; ?>'><span></span></td>
				</tr>
			<?php } ?>
			$html .='</table>';


$html .='</table>';          
<!-- Medication Allergy End -->    



<!-- Medications Start -->   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>'. __("Medication").'</strong></td>
				</tr>
							</table>';	
					       
 $html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	$html .='<tr>
		
		<td>
			<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong>Prescription Id</strong></td>
					<td class="table_cell"><strong>Prescription Name</strong></td>
					<td class="table_cell"><strong>Rx Norm</strong></td>
					<td class="table_cell"><strong>Date Of Perscription</strong></td>
					<td class="table_cell"><strong>Route</strong></td>
					<td class="table_cell"><strong>DosageFrequencyDescription</strong></td>
					<td class="table_cell"><strong>DosageNumberDescription</strong></td>
					<td class="table_cell"><strong>Strength</strong></td>
				</tr>';
				<?php
				$count=0; 
				$toggle =0;
			
				$CountOfPrescriptionRecord=count($allergiesSpecific);

	 							for($counter=0;$counter < $CountOfPrescriptionRecord-1;$counter++){
							
						if($toggle == 0) {
						$html .=' "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$html .=' "<tr>";
							$toggle = 0;
						}
				$count++;	 ?>
				
			
					<!-- <td class="row_format">&nbsp;<?php echo $counter+1; ?> -->
					<td class="row_format">&nbsp; '. $allergiesSpecific[$counter][1].'</td>
					<td class="row_format">&nbsp; '. $allergiesSpecific[$counter][0].'</td>
					<td class="row_format">&nbsp; '. $allergiesSpecific[$counter][2];.'</td>
					<td class="row_format">&nbsp; '.$allergiesSpecific[$counter][3]; .'</td>
					<td class="row_format">&nbsp; '. $allergiesSpecific[$counter][5].'</td>
					<td class="row_format">&nbsp; '. $allergiesSpecific[$counter][6].'</td>
					<td class="row_format">&nbsp; '. $allergiesSpecific[$counter][7].'</td>
					<td class="row_format">&nbsp; '. $allergiesSpecific[$counter][8].$allergiesSpecific[$counter][9].'</td>
				</tr>.';
				
				$html .='<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc<?php echo $count; ?>'><span></span></td>
				</tr>';
			<?php }?>
			$html .='</table>';
		</td>
	$html .='</tr>';

</table>
<!-- Medications End -->    


<!-- Problem Start -->   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>'. __("Problems").'</strong></td>
				</tr></table>';	
					       
 $html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	$html .='<tr>
		
		<td>
			<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong>Icd Id</strong></td>
					<td class="table_cell"><strong>Snomed CT Code</strong></td>
					<td class="table_cell"><strong>Problem Name</strong></td>
					
				</tr>';
				<?php
				$count=0; 
				$toggle =0;

				

	 							foreach($problems as $problem){
							
						if($toggle == 0) {
							$html .=' "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$html .=' "<tr>";
							$toggle = 0;
						}
				 ?>
					
					<td class="row_format">&nbsp; '. $problem['NoteDiagnosis']['icd_id'];.'</td>
					<td class="row_format">&nbsp;'. $problem['NoteDiagnosis']['SnomedCode'][0];  .'</td>
					<td class="row_format">&nbsp;'.$problem['NoteDiagnosis']['SnomedName'][0];  .'</td>
					
				</tr>';
				
				$html .='<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc<?php echo $count; ?>'><span></span></td>
				</tr>';
			<?php }?>
			$html .='</table>';
		$html .='</td>';
	$html .='</tr>';

$html .='</table>';
<!-- Problems End -->    


<!-- Procedure Start -->   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong><?php echo __("Procedures")?></strong></td>
				</tr>
							</table>';	
				
$html .='<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
				<?php
				 
						if(isset($testOrdered) && !empty($testOrdered)){  ?> 
						  $html .='<tr class="row_title">
						  	<td class="table_cell"><strong>'.('Admission Id').'</strong></td> 
						  	   <td class="table_cell"><strong>'. $this->Paginator->sort('LaboratoryToken.sct_concept_id', __('Snomed Code', true)).'</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('LabManager.order_id', __('Lab Order id', true)).'</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('LabManager.create_time', __('Order Time', true)).'</strong></td>
							   <td class="table_cell"><strong>'.$this->Paginator->sort('Laboratory.name', __('Test Name', true)).'</strong></td> 
							   <td class="table_cell"><strong>'.  __('Status').'</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('LaboratoryResult.text', __('Result', true)).'</strong></td>
							   <!-- <td class="table_cell"><strong>'.  __('Is Sample Taken?', true).'</strong></td> -->
							   <!-- <td class="table_cell"><strong>'. __('Action', true).'</strong></td> -->
							   
						  </tr>';
						  <?php 
							  $toggle =0;
						 
							  if(count($testOrdered) > 0) {
							  	 
									foreach($testOrdered as $labs){
							   
										   if($toggle == 0) {
												$html .=' "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												$html .=' "<tr>";
												$toggle = 0;
										   }
										   //status of the report
										   if($labs['LaboratoryResult']['confirm_result']==1){
										   		$status = 'Report Delivered';
										   }else{
										   		$status = 'Pending';
										   }
										  ?>
										  <td class="row_format">'. $labs['Patient']['admission_id'].'</td>								  
										   <td class="row_format">'. $labs['LaboratoryToken']['sct_concept_id'].'</td>
										   <td class="row_format">'. $labs['LabManager']['order_id'].'</td>
										   <td class="row_format">'. $this->DateFormat->formatDate2Local($labs['LabManager']['create_time'],Configure::read('date_format'),true).'</td>
										   <td class="row_format">'. ucfirst($labs['LaboratoryToken']['laboratory_id']).' </td>
										   <td class="row_format">'. $status; ?> </td>	
										   <td class="row_format">'. ucfirst($labs['LaboratoryResult']['text']).' </td>	
										   <!-- <td class="row_format">
											 <?php 
											   if(!empty($labs['LaboratoryToken']['ac_id']) || !empty($labs['LaboratoryToken']['sp_id'])){
											   		echo "Yes";									   
											   }else{
											   		echo "No";
											   }
											 ?>
										   </td>	 -->
										  <!--  <td class="row_format">
										    <?php	
										     if($labs['LaboratoryResult']['confirm_result']!=1){ 
												//echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('controller'=>'Laboratories','action' => 'lab_result',$labs['LabManager']['patient_id'],$labs['Laboratory']['id'],$labs['LabManager']['id']), array('escape'=>false));
												//echo $this->Js->link($this->Html->image('icons/edit-icon.png',array('title'=>'edit','alt'=>'Edit')), array('controller'=>'laboratories','action' => 'lab_manager_test_order',$labs['LabManager']['id'],$labs['LabManager']['patient_id']), array('escape'=>false,'update' => '#test-order','method'=>'post','class'=>'view-order-form', 'complete' => $this->Js->get('#temp-busy-indicator')->effect('fadeOut', array('buffer' => false)), 'before' => $this->Js->get('#temp-busy-indicator')->effect('fadeIn', array('buffer' => false))));
										     }else{
										     	//print result
										      	$publishTime = strtotime($labs['LaboratoryResult']['result_publish_date']) ;
										     	$currentTime = time();
										     	$diffHours = date("H",$currentTime - $publishTime) ;
										     	//$dateDiff = $this->DateFormat->dateDiff($publishTime,$currentTime);
										     	 
										     	
										     	 
												echo $this->Html->link($this->Html->image('icons/print.png'),'#',array('escape' => false,
																'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preview',$labs['LabManager']['patient_id'],$labs['Laboratory']['id'],$labs['LabManager']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
												 
										     }
											?>
											</td> -->
							</tr>';
							  <?php } 
										
									//set get variables to pagination url
									//$this->Paginator->options(array('url' =>array("?"=>$this->params->query))); 
							   ?>
							  $html .=' <tr>
								<TD colspan="8" align="center">
								<!-- Shows the page numbers -->
							 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
							 <!-- Shows the next and previous links -->
							 <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
							 <?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
							 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
								</TD>
							   </tr>.';
					<?php } ?> <?php					  
						  } else {
					 ?>
					 <!--  <tr>
					   <TD colspan="8" align="center" class="error"><?php //echo __('No test assigned to selected patients', true); ?>.</TD>
					  </tr> -->
					  <?php
						  }
						  
					 echo $this->Js->writeBuffer();	  
					  ?>
		</table>';
		
		
		
		$html .=' <table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
				<?php
				 
						if(isset($radTestOrdered) && !empty($radTestOrdered)){  ?> 
						$html .=' <tr class="row_title">
						  		<td class="table_cell"><strong>'.  __('Admission Id').';</strong></td> 
						  		<td class="table_cell"><strong>'. $this->Paginator->sort('RadioManager.sct_concept_id', __('Snomed Code', true)).';</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('RadioManager.order_id', __('Radiology Order id', true)).';</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('RadioManager.create_time', __('Order Time', true)).';</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('Radiology.name', __('Test Name', true)).';</strong></td> 
							   <td class="table_cell"><strong>'.  __('Status').';</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('RadiologyResult.note', __('Result', true)).';</strong></td>
							   <!--  <td class="table_cell" width="12%"><strong><?php echo  __('Action'); ?></strong></td> -->
						  </tr>';
						  <?php 
							  $toggle =0;
							  if(count($radTestOrdered) > 0) {
									foreach($radTestOrdered as $rads){
							   
										   if($toggle == 0) {
												$html .=' "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												$html .=' "<tr>";
												$toggle = 0;
										   }
										   
										   //status of the report
										   if($rads['RadiologyResult']['confirm_result']==1){
										   		$status = 'Report Delivered';
										   		 
										   }else{
										   		$status = 'Pending';
										   		 
										   }
										   
										  ?>	
										  <td class="row_format">'. $rads['Patient']['admission_id'].'</td>	
										  <td class="row_format">'.$labs['RadioManager']['sct_concept_id'].';</td>							  
										   <td class="row_format">'. $rads['RadioManager']['order_id'].'</td>
										   <td class="row_format">'. $this->DateFormat->formatDate2Local($rads['RadioManager']['create_time'],Configure::read('date_format'),true).'; </td>
										   <td class="row_format">'. ucfirst($rads['Radiology']['name']).'; </td>
										   <td class="row_format">'. $status.';</td>	
										   <td class="row_format">'. ucfirst($rads['RadiologyResult']['note'].'; </td>	
										  <!-- <td class="row_format">
										    <?php	
										   	//print result
										      	$publishTime = strtotime($rads['RadiologyResult']['result_publish_date']) ;
										     	$currentTime = time();
										     	$diffHours = date("H",$currentTime - $publishTime) ;
										     	//$dateDiff = $this->DateFormat->dateDiff($publishTime,$currentTime);
										     	   if($rads['RadiologyResult']['confirm_result'] ==1 &&  ($diffHours < 25)){ 
													echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'View/Edit Published Result')), 
													array('controller'=>'radiologies','action' => 'incharge_radiology_result',
													$rads['RadioManager']['patient_id'],$rads['Radiology']['id'],$rads['RadioManager']['id']), array('escape'=>false));
										     	   }
										     	   
												if($rads['RadiologyResult']['confirm_result'] !=1){
													echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Add/Edit Result')), 
													array('controller'=>'radiologies','action' => 'radiology_result',
													$rads['RadioManager']['patient_id'],$rads['Radiology']['id'],$rads['RadioManager']['id']), array('escape'=>false));
												}
										     	
												if($$rads['RadiologyResult']['confirm_result'] == 1){
													echo $this->Html->link($this->Html->image('icons/view-icon.png',array('title'=>'View Result')),
													 array('controller'=>'radiologies','action' => 'add_comment',$rads['RadioManager']['patient_id'],
													 $rads['Radiology']['id'],$rads['RadioManager']['id']), array('escape'=>false));
													 
													 echo $this->Html->link($this->Html->image('icons/print.png'),'#',array('escape' => false,
														  'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preview',$rads['RadioManager']['patient_id'],
													 		$rads['Radiology']['id'],$rads['RadioManager']['id'])).
													 		"', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
												}
										   //  } 
											?>
											</td> --> 
							</tr>';
							  <?php } 
										
									//set get variables to pagination url
									//$this->Paginator->options(array('url' =>array("?"=>$this->params->query))); 
							   ?>
							   $html .='<tr>
								<TD colspan="8" align="center">
								<!-- Shows the page numbers -->
							 '.$this->Paginator->numbers(array('class' => 'paginator_links')).';
							 <!-- Shows the next and previous links -->
							 '. $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')).';
							 '. $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')).';
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
							 <span class="paginator_links">'. $this->Paginator->counter(array('class' => 'paginator_links')).';</span>
								</TD>
							   </tr>';
					<?php } ?> <?php					  
						  } else {
					 ?>
					<!-- <tr>
					   <TD colspan="8" align="center" class="error"><?php //echo __('No test assigned to selected patients', true); ?>.</TD>
					  </tr> -->  
					  <?php
						  }
						  
						  
					  ?>
		$html .='</table>';				
<!-- Procedure End -->  	
		
		
		
<!-- Vital Signs Start -->   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>'. __("Vital Signs").';</strong></td>
				</tr></table>.';	
					       
 $html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	$html .='<tr>
		
		<td>
			<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong><?php echo __("MRN");?></strong></td>
					<td class="table_cell"><strong>Temprature</strong></td>
					<td class="table_cell"><strong>Blood Pressure</strong></td>
					<td class="table_cell"><strong>Weight</strong></td>
					<td class="table_cell"><strong>Height</strong></td>
					<td class="table_cell"><strong>BMI</strong></td>
					
				</tr>';
				<?php
				$count=0; 
				$toggle =0;

				

	 							foreach($vitalSigns as $vitalSign){
							
						if($toggle == 0) {
							$html .=' "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$html .=' "<tr>";
							$toggle = 0;
						}
				 ?>
					
					<td class="row_format">&nbsp;'. $vitalSign['Patient']['admission_id'].';</td>
					<td class="row_format">&nbsp;'. $vitalSign['Note']['temp'].';</td>
					<td class="row_format">&nbsp; '. $vitalSign['Note']['bp'].';</td>
					<td class="row_format">&nbsp; '. $vitalSign['Note']['wt'].';</td>
					<td class="row_format">&nbsp; '. $vitalSign['Note']['ht'].';</td>
					<td class="row_format">&nbsp; '. $vitalSign['Note']['bmi']'.;</td>
					
				</tr>';
				
				$html .='<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc". $count.";'><span></span></td>
				</tr>';
			<?php }?>
			</table>
		</td>
	</tr>';

</table>
<!-- Vital Signs End -->





<!-- Laboratory Radiology Start -->   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>'. __("Laboratory").';</strong></td>
				</tr></table>';	
				
$html .='<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
				<?php
				 
						if(isset($testOrdered) && !empty($testOrdered)){  ?> 
						  $html .='<tr class="row_title">
						  	<td class="table_cell"><strong>'.  __('Admission Id').'</strong></td> 
						  	   <td class="table_cell"><strong>'. $this->Paginator->sort('LaboratoryToken.sct_concept_id', __('Snomed Code', true)).';</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('LaboratoryToken.lonic_code', __('Lonic Code', true)).';</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('LabManager.order_id', __('Lab Order id', true)).';</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('LabManager.create_time', __('Order Time', true)).';</strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('Laboratory.name', __('Test Name', true)).';</strong></td> 
							   <td class="table_cell"><strong>'.  __('Status'); ?></strong></td>
							   <td class="table_cell"><strong>'. $this->Paginator->sort('LaboratoryResult.text', __('Result', true)).';</strong></td>
							   <!-- <td class="table_cell"><strong>'.  __('Is Sample Taken?', true).';</strong></td> -->
							   <!-- <td class="table_cell"><strong>'.  __('Action', true).';</strong></td> -->
							   
						  </tr>';
						  <?php 
							  $toggle =0;
						 
							  if(count($testOrdered) > 0) {
							  	 
									foreach($testOrdered as $labs){
							   
										   if($toggle == 0) {
												$html .=' "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												$html .=' "<tr>";
												$toggle = 0;
										   }
										   //status of the report
										   if($labs['LaboratoryResult']['confirm_result']==1){
										   		$status = 'Report Delivered';
										   }else{
										   		$status = 'Pending';
										   }
										  ?>
										  <td class="row_format">'. $labs['Patient']['admission_id'].'</td>								  
										   <td class="row_format">'. $labs['LaboratoryToken']['sct_concept_id'].';</td>
										   <td class="row_format">'. $labs['LaboratoryToken']['lonic_code'].';</td>
										   <td class="row_format">'. $labs['LabManager']['order_id'].';</td>
										   <td class="row_format">'. $this->DateFormat->formatDate2Local($labs['LabManager']['create_time'],Configure::read('date_format'),true).'; </td>
										   <td class="row_format">'.ucfirst($labs['LaboratoryToken']['laboratory_id']).'; </td>
										   <td class="row_format">'. $status.'; </td>	
										   <td class="row_format">'. ucfirst($labs['LaboratoryResult']['text']).'; </td>	
										   <!-- <td class="row_format">
											 <?php 
											   if(!empty($labs['LaboratoryToken']['ac_id']) || !empty($labs['LaboratoryToken']['sp_id'])){
											   		echo "Yes";									   
											   }else{
											   		echo "No";
											   }
											 ?>
										   </td>	 -->
										  <!--  <td class="row_format">
										    <?php	
										     if($labs['LaboratoryResult']['confirm_result']!=1){ 
												//echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('controller'=>'Laboratories','action' => 'lab_result',$labs['LabManager']['patient_id'],$labs['Laboratory']['id'],$labs['LabManager']['id']), array('escape'=>false));
												//echo $this->Js->link($this->Html->image('icons/edit-icon.png',array('title'=>'edit','alt'=>'Edit')), array('controller'=>'laboratories','action' => 'lab_manager_test_order',$labs['LabManager']['id'],$labs['LabManager']['patient_id']), array('escape'=>false,'update' => '#test-order','method'=>'post','class'=>'view-order-form', 'complete' => $this->Js->get('#temp-busy-indicator')->effect('fadeOut', array('buffer' => false)), 'before' => $this->Js->get('#temp-busy-indicator')->effect('fadeIn', array('buffer' => false))));
										     }else{
										     	//print result
										      	$publishTime = strtotime($labs['LaboratoryResult']['result_publish_date']) ;
										     	$currentTime = time();
										     	$diffHours = date("H",$currentTime - $publishTime) ;
										     	//$dateDiff = $this->DateFormat->dateDiff($publishTime,$currentTime);
										     	 
										     	
										     	 
												echo $this->Html->link($this->Html->image('icons/print.png'),'#',array('escape' => false,
																'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preview',$labs['LabManager']['patient_id'],$labs['Laboratory']['id'],$labs['LabManager']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
												 
										     }
											?>
											</td> -->
							</tr>';
							  <?php } 
										
									//set get variables to pagination url
									//$this->Paginator->options(array('url' =>array("?"=>$this->params->query))); 
							   ?>
							   
					<?php } ?> <?php					  
						  } else {
					 ?>
					 <!--  <tr>
					   <TD colspan="8" align="center" class="error"><?php //echo __('No test assigned to selected patients', true); ?>.</TD>
					  </tr> -->
					  <?php
						  }
						  
					 echo $this->Js->writeBuffer();	  
					  ?>
		$html .='</table>';
					
<!-- Laboratory Radiology End -->  	

<!-- Care Plan Start -->   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>'. __("Care Plan").'</strong></td>
				</tr></table>';	
					       
 $html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	$html .='<tr>
		
		<td>
			$html .='<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong><?php echo __("MRN");?></strong></td>
					<td class="table_cell"><strong>Care Plan</strong></td>
					
					
				</tr>';
				<?php
				$count=0; 
				$toggle =0;

				

	 							foreach($carePlans as $carePlan){
							
						if($toggle == 0) {
							$html .=' "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$html .=' "<tr>";
							$toggle = 0;
						}
				 ?>
					
					<td class="row_format">&nbsp;'. $carePlan['Patient']['admission_id']  .';</td>
					<td class="row_format">&nbsp;'. $carePlan['Note']['plan'].';</td>
					
					
				</tr>';
				
				$html .='<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc<?php echo $count; ?>'><span></span></td>
				</tr>';
			<?php }?>
			</table>';
		</td>
	</tr>';

</table>';
<!-- Care Plan End -->


<!--  Inpatient Entries Start Here -->

<!-- Encounter Information Start -->   
$html .=' <table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>'. __("Encounter Information").';</strong></td>
				</tr></table>';	
					       
 $html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	$html .='<tr>
		
		<td>
			<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong><?php echo __("MRN");?></strong></td>
					<td class="table_cell"><strong>Admission Date</strong></td>
					<td class="table_cell"><strong>Discharge Date</strong></td>
					<td class="table_cell"><strong>Admission and Discharge Location</strong></td>
					
					
				</tr>';
				<?php
				$count=0; 
				$toggle =0;

				

	 							foreach($encountersData as $encounters){
							
						if($toggle == 0) {
							$html .=' "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$html .=' "<tr>";
							$toggle = 0;
						}
				 ?>
					
					<td class="row_format">&nbsp;'. $encounters['Patient']['admission_id'].';</td>
					<td class="row_format">&nbsp;'. $encounters['Patient']['form_received_on'].';</td>
					<td class="row_format">&nbsp;'. $encounters['Patient']['discharge_date'].';</td>
					<td class="row_format">&nbsp;". $encounters['Location']['address1']. ''.$encounters['Location']['address2']
					.', '.$encounters['City']['name'].', '.$encounters['State']['name'].', '.$encounters['Country']['name'].', '.$encounters['Location']['zipcode'].";</td>
					
					
				</tr>';
				
				$html .='<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc<?php echo $count; ?>'><span></span></td>
				</tr>';
			<?php }?>
			</table>';
		</td>
	</tr>';

</table>';
<!-- Encounter Information End -->



<!-- Encounter Diagnosis Start -->   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>'. __("Encounter Diagnosis").';</strong></td>
				</tr></table>';	
					       
 $html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	$html .='<tr>
		
		<td>
			$html .='<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" >
				$html .='<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong>Icd Id</strong></td>
					<td class="table_cell"><strong>Problem Code</strong></td>
					<td class="table_cell"><strong>Problem Name</strong></td>
					
				</tr>';
				<?php
				$count=0; 
				$toggle =0;

				

	 							foreach($encounterDiagnosis as $encounterD){
							
						if($toggle == 0) {
							$html .='"<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$html .=' "<tr>";
							$toggle = 0;
						}
				 ?>
					
					<td class="row_format">&nbsp; '. $encounterD['NoteDiagnosis']['icd_id'].';</td>
					<td class="row_format">&nbsp; '. $encounterD['NoteDiagnosis']['SnomedCode'][0].';</td>
					<td class="row_format">&nbsp; '. $encounterD['NoteDiagnosis']['SnomedName'][0].';</td>
					
				</tr>';
				
				$html .='<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc<?php echo $count; ?>'><span></span></td>
				</tr>';
			<?php }?>
			</table>';
		</td>
	</tr>';

</table>';
<!-- Encounter Diagnosis End -->    


<!-- Cognitive & Functions Start -->   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				$html .='<tr class="row_title">
					<td class="table_cell"><strong>'. __("Cognitive & Functional Status").';</strong></td>
				</tr>';
							</table>';	
					       
 $html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	$html .='<tr>
		
		<td>
			$html .='<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" >
				$html .='<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong><?php echo __("MRN");?></strong></td>
					<td class="table_cell"><strong>Date</strong></td>
					<td class="table_cell"><strong>Name</strong></td>
					<td class="table_cell"><strong>Snomed CT Code</strong></td>
					<td class="table_cell"><strong>Status</strong></td>
					
				</tr>';
				<?php
				$count=0; 
				$toggle =0;

				

	 							foreach($cogNitiveFunctions as $cogNitiveFunction){
							
						if($toggle == 0) {
						$html .=' "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$html .=' "<tr>";
							$toggle = 0;
						}
				 ?>
					
					<td class="row_format">&nbsp; '. $cogNitiveFunction['Patient']['admission_id'].'</td>
					<td class="row_format">&nbsp; '. $this->DateFormat->formatDate2Local($cogNitiveFunction['CognitiveFunction']['cog_date'],Configure::read('date_format'),true).';</td>
					<td class="row_format">&nbsp; '. $cogNitiveFunction['CognitiveFunction']['cog_name'].';</td>
					<td class="row_format">&nbsp; '. $cogNitiveFunction['CognitiveFunction']['cog_snomed_code'].';</td>
					<td class="row_format">&nbsp; ". 'Active'.";</td>
					
				</tr>';
				
				$html .='<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc<?php echo $count; ?>'><span></span></td>
				</tr>';
			<?php }?>
			</table>';
		</td>
	</tr>';

</table>';
<!-- Cognitive & Functions End -->    


<!-- Hospitalization Reason Start -->
$html .='<table border="0" class="table_format_head" cellpadding="0" cellspacing="0" width="100%" >
$html .='<tr class="row_title">
<td class="table_cell"><strong>'. __("Reason for Hospitalization").';</strong></td>
</tr></table>';

$html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
align="center" >

$html .='<tr>

<td>
$html .='<table border="0" class="table_format_body" cellpadding="0" cellspacing="0" width="100%" >
$html .='<tr class="row_title">
<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
<td class="table_cell"><strong><?php echo __("MRN");?></strong></td>
<td class="table_cell"><strong>Hospitalization Reason</strong></td>


</tr>';
<?php
$count=0;
$toggle =0;



foreach($hospitalizationReason as $reason){

if($toggle == 0) {
$html .=' "<tr class='row_gray'>";
$toggle = 1;
}else{
$html .=' "<tr>";
$toggle = 0;
}
?>
<td class="row_format">&nbsp;'. $reason['Patient']['admission_id'].';</td>
<td class="row_format">&nbsp; '. $reason['Diagnosis']['final_diagnosis'].';></td>



</tr>';

$html .='<tr>
<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px" id='cmnt_presc<?php echo $count; ?>'><span></span></td>
</tr>';
<?php }?>
</table>';
</td>
</tr>';

</table>';
<!-- Hospitalization Reason End Here -->

<!-- Discharge Instruction Start -->   
 $html .='<table border="0" class="table_format_head"  cellpadding="0" cellspacing="0" width="100%" >
				$html .='<tr class="row_title">
					<td class="table_cell"><strong>'. __("Discharge Instructions").';</strong></td>
				</tr>';
		</table>';	
					       
 $html .='<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	$html .='<tr>
		
		<td>
			$html .='<table border="0" class="table_format_body"  cellpadding="0" cellspacing="0" width="100%" >
				$html .=<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong><?php echo __("MRN");?></strong></td>
					<td class="table_cell"><strong>Discharge Instruction</strong></td>
					
					
				</tr>';
				<?php
				$count=0; 
				$toggle =0;

				

	 							foreach($dischargeInst as $inst){
							
						if($toggle == 0) {
							$html .=' "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$html .=' "<tr>";
							$toggle = 0;
						}
				 ?>
					
					<td class="row_format">&nbsp;'. $inst['Patient']['admission_id'].';</td>
					<td class="row_format">&nbsp;'. $inst['DischargeSummary']['care_plan'].';</td>
					
					
				</tr>';
				
				
			<?php }?>
			</table>';
		</td>
	</tr>';

</table>';
<?php 
// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Get_All_Data_Of_Patient'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
<!-- Discharge Instruction End -->
	?>
