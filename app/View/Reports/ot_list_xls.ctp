<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"OT_Calendar_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );
?>
<STYLE type="text/css">
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
   <tr><th colspan="12" align="center"><h2><?php echo __("OT Calendar Report"); ?></h2></th></tr>
   <tr>
   <th><?php echo __('Sr.No.') ?></th>
   <th><?php echo __('Date of Reg.') ?></th>
   <th><?php echo __('MRN') ?></th>
   <th><?php echo __('Patient Name') ?></th>
   <th><?php echo __('Start Time') ?></th>
   <th><?php echo __('End Time') ?></th>
   <th><?php echo __('Room No.') ?></th>
   <th><?php echo __('Table No.') ?></th>
   <th><?php echo __('Surgery') ?></th>
   <th><?php echo __('Surgery Type') ?></th>
   <th><?php echo __('Surgeon') ?></th>
   <th><?php echo __('Anaesthetist') ?></th>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $otdata): 
       $cnt++;
  ?>
   <tr>
   <td align="center"><?php echo $cnt; ?></td>
   <td align="center"><?php echo $this->DateFormat->formatDate2Local($otdata['Patient']['form_received_on'],Configure::read('date_format'), false); ?></td>
   <td align="center"><?php echo $otdata['Patient']['admission_id']; ?></td>
   <td align="center"><?php echo $otdata['PatientInitial']['name'].' '.$otdata['Patient']['lookup_name']; ?></td>
   <td align="center"><?php echo substr($this->DateFormat->formatDate2Local($otdata['OptAppointment']['starttime'],Configure::read('date_format'), true), 0 , -3); ?></td>
   <td align="center"><?php echo substr($this->DateFormat->formatDate2Local($otdata['OptAppointment']['endtime'],Configure::read('date_format'), true), 0, -3); ?></td>
   <td align="center"><?php echo $otdata['Opt']['name']; ?></td>
   <td align="center"><?php echo $otdata['OptTable']['name']; ?></td>
   <td align="center"><?php echo $otdata['Surgery']['name']; ?></td>
   <td align="center"><?php echo ucfirst($otdata['OptAppointment']['operation_type']); ?></td>
   <td align="center"><?php echo $otdata['Initial']['name'].' '.$otdata['DoctorProfile']['doctor_name']; ?></td>
   <td align="center"><?php echo $otdata['InitialAlias']['name'].' '.$otdata['Doctor']['first_name'].' '.$otdata['Doctor']['middle_name'].' '.$otdata['Doctor']['last_name']; ?></td>
  </tr>
  <?php 
       endforeach;
  ?>
  <tr>
   <td colspan="12" align="center"><? echo "<strong>". __('Total:'). "</strong>". "&nbsp;".$cnt; ?></td>
  </tr>
  <?php
      } else {
  ?>
  <tr>
   <td colspan="12" align="center"><?php echo __('No record found', true); ?>.</td>
  </tr>
  <?php
      }
  ?>
 </table>
        </table>

