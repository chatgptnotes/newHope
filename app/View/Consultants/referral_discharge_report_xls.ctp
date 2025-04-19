<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Daily_Collection_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}

</style>
<table width="100%" cellpadding="0" cellspacing="1" border="1" 	class="tabularForm" id="container-table">
				<thead>
					<tr> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Patient Name');?></th> 
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Date Of Discharge');?></th> 
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Follow Up');?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Diagnosis');?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('City');?></th> 
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Corporate');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Treating Consultant');?></th>
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Referring Consultant');?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Total Bill Paid');?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Spot Amount');?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Backing Amount');?></th>
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach($dischargeReferral as $key=> $value) { ?>
					<tr>
					
						<td align="left" style= "text-align: center;">
							<?php echo $value['Patient']['lookup_name'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
						  
						   <?php echo $this->DateFormat->formatDate2Local($value['Patient']['discharge_date'],Configure::read('date_format'),false); ?>
						</td>
						<td align="left" style= "text-align: center;">
						  
						   <?php echo $this->DateFormat->formatDate2Local($value['DischargeSummary']['review_on'],Configure::read('date_format'),false); ?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['DischargeSummary']['final_diagnosis'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['Person']['district'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['TariffStandard']['name'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['User']['first_name']." ".$value['User']['last_name'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php  $reffList = unserialize($value['Patient']['consultant_id']) ;
							    foreach ($reffList as $key => $reffData) {
							        echo $referralList[$reffData]."<br>";
							    }

							?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['FinalBilling']['amount_paid'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['Patient']['spot_amount'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['Patient']['b_amount'] ;?>
						</td>
						
				  	</tr>
			  	<?php }?>
					
				</tbody>
		
			</table>