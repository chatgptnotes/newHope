<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
			<!-- <?php echo $this->Html->css(array('internal_style.css')); ?> -->
<!-- <style>
.print_form{
	background:none;
	font-color:black;
	color:#000000;
}
.formFull td{
	color:#000000;
}
.tabularForm {
    background:#000;
}
.tabularForm td {
    background: #ffffff;
    color: #333333;
    font-size: 13px;
    padding: 5px 8px;
}
</style> -->
</head>
<body class="print_form" onload="window.print();window.close(); "> <!-- onload="window.print();window.close();" -->

<div class="clr ht5"></div>
<?php echo $this->element('patient_header') ; ?>

 
<div class="inner_title">

	</div></br>
	<div class="clr ht5"></div>
	<table width="100%" border="1" cellspacing="1" cellpadding="0" class="tabularForm">
	  <tr>
		 <th width="40" style="text-align:center;">Sr.</th>
		 <th width="190" style="text-align:center; min-width:130px;">Parmeters</th>
		 <th width="130" style="text-align:center;">Date Observed</th>
		 <th width="160" style="text-align:center;">Site with Extent of Injury</th>
		 <th width="140" style="text-align:center;">Action Taken</th>
		 <th style="text-align:center;">Remarks</th>
	  </tr>
	  <tr>
		<td align="center">1.</td>
		<td>Skin Peeling / Pressure Ulcers</td>			
		<td align="center"><?php 
			if(!empty($data['QualityMonitoringFormat']['skin_observed_date'])){
				$skinDate = explode(' ',$data['QualityMonitoringFormat']['skin_observed_date']);
			echo $this->DateFormat->formatDate2Local($data['QualityMonitoringFormat']['skin_observed_date'],Configure::read('date_format'),true);
			}?>
		</td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['skin_site'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['skin_action'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['skin_remark'];?></td>	
	  </tr>
	  <tr>
		<td align="center">2.</td>
		<td>Thrombophlebits</td>			
		<td align="center"><?php 
			if(!empty($data['QualityMonitoringFormat']['thrombophlebits_observed_date'])){
				$thrombophlebitsDate = explode(' ',$data['QualityMonitoringFormat']['thrombophlebits_observed_date']);
			echo $this->DateFormat->formatDate2Local($data['QualityMonitoringFormat']['thrombophlebits_observed_date'],Configure::read('date_format'),true);
			}?>
		</td>		
		<td align="center"><?php echo $data['QualityMonitoringFormat']['thrombophlebits_site'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['thrombophlebits_action'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['thrombophlebits_remark'];?></td>		
	  </tr>
	  <tr>
		<td align="center">3.</td>
		<td>Blockage of Tubes / Lines / Tubes</td>
		<td align="center"><?php 
			if(!empty($data['QualityMonitoringFormat']['blockage_observed_date'])){
				$blockageDate = explode(' ',$data['QualityMonitoringFormat']['blockage_observed_date']);
			echo $this->DateFormat->formatDate2Local($data['QualityMonitoringFormat']['blockage_observed_date'],Configure::read('date_format'),true);
			}?>
		</td>		
		<td align="center"><?php echo $data['QualityMonitoringFormat']['blockage_site'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['blockage_action'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['blockage_remark'];?></td>		
	  </tr>
	  <tr>
		<td align="center">4.</td>
		<td>Accidental removal of Lines / Tubes</td>
		<td align="center"><?php 
			if(!empty($data['QualityMonitoringFormat']['accidential_line_observed_date'])){
				$accidentialDate = explode(' ',$data['QualityMonitoringFormat']['accidential_line_observed_date']);
			echo $this->DateFormat->formatDate2Local($data['QualityMonitoringFormat']['accidential_line_observed_date'],Configure::read('date_format'),true);
			}?>
		</td>		
		<td align="center"><?php echo $data['QualityMonitoringFormat']['accidential_line_site'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['accidential_line_action'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['accidential_line_remark'];?></td>		
	  </tr>
	  <tr>
		<td align="center">5.</td>
		<td>Patient Falls</td>
		<td align="center"><?php 
			if(!empty($data['QualityMonitoringFormat']['patient_fall_observed_date'])){
				$patientDate = explode(' ',$data['QualityMonitoringFormat']['patient_fall_observed_date']);
			echo $this->DateFormat->formatDate2Local($data['QualityMonitoringFormat']['patient_fall_observed_date'],Configure::read('date_format'),true);
			}?>
		</td>		
		<td align="center"><?php echo $data['QualityMonitoringFormat']['patient_fall_site'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['patient_fall_action'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['patient_fall_remark'];?></td>	
	  </tr>
	</table>
	<div class="clr">&nbsp;</div>

	<table width="100%" border="1" cellspacing="1" cellpadding="0" class="tabularForm">
	  <tr>
		 <th width="40" style="text-align:center;">Sr.</th>
		 <th width="100" style="text-align:center; min-width:100px;">Invasive Lines</th>
		 <th width="200" style="text-align:center;">DOI with specification <br />(Type, Size &amp; Site)</th>
		 <th width="160" style="text-align:center;">Site</th>
		 <th width="140" style="text-align:center;">DOR with Condition of the Site</th>
		 <th style="text-align:center;">Remarks</th>
	  </tr>
	  <tr>
		<td  align="center">1.</td>
		<td>RT / NGT</td>			
		<td align="center"><?php echo $data['QualityMonitoringFormat']['rt_ngt_doi_specification'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['rt_ngt_site'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['rt_ngt_dor'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['rt_ngt_remark'];?></td>
		
	  </tr>
	  <tr>
		<td  align="center">2.</td>
		<td>Others (TMPI)</td>		
		<td align="center"><?php echo $data['QualityMonitoringFormat']['other_doi_specification'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['other_site'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['other_dor'];?></td>
		<td align="center"><?php echo $data['QualityMonitoringFormat']['other_remark'];?></td>	
	  </tr>
	</table>
	<div class="clr">&nbsp;</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="23%" align="right"><b>Date Of Insertion :&nbsp;</b></td>
		<td width="31%" valign="top">
			<table width="78%" cellpadding="0" cellspacing="0" border="0">
			  <tr>
				<td><?php
							if($data['QualityMonitoringFormat']['date_insertion'] != ''){
								$insertionDate = explode(' ',$data['QualityMonitoringFormat']['date_insertion']);
								echo $this->DateFormat->formatDate2Local($data['QualityMonitoringFormat']['date_insertion'],Configure::read('date_format'),true);
							}
						
					?>		
			  </tr>
			</table>
		</td>
		<td align="right" width="23%"><b>Date of Removal :&nbsp;</b></td>
		<td width="23%"><table width="104%" cellpadding="0" cellspacing="0" border="0">
			  <tr>
				<td><?php 
							if($data['QualityMonitoringFormat']['date_removel'] != ''){
								$removelDate = explode(' ',$data['QualityMonitoringFormat']['date_insertion']);
								echo $this->DateFormat->formatDate2Local($data['QualityMonitoringFormat']['date_removel'],Configure::read('date_format'),true);								
							}
						
					?>
				</td>				
			  </tr>
			</table>
		</td>
	  </tr>
	</table>             
	
 </body>
</html>
 