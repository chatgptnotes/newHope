<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"OTList.xls" );
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
   <tr><th colspan="11" align="center"><h3><?php echo __("OT List"); ?></h3></th></tr>
   <tr>
   <th width="60"><?php echo __('Sr. No.') ?></th>
   <th width="40"><?php echo __('Time') ?></th>
   <th width="75"><?php echo __('Room No.') ?></th>
   <th width="130"><?php echo __('Table No.') ?></th>
   <th width="150"><?php echo __('Name of Patient') ?></th>
   <th width="150"><?php echo __('Diagnosis') ?></th>
   <th width="150"><?php echo __('Surgery') ?></th>
   <th width="80"><?php echo __('Major/Minor') ?></th>
   <th width="170"><?php echo __('Surgeon') ?></th>
   <th width="170"><?php echo __('Anesthetist') ?></th>
   <th width="170"><?php echo __('Anaesthesia') ?></th>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $otdata): 
       $cnt++;
  ?>
   <tr>
   <td align="center"><?php echo $cnt; ?></td>
   <td><?php echo $otdata['OptAppointment']['start_time']; ?></td>
   <td><?php echo $otdata['Opt']['name']; ?></td>
   <td><?php echo $otdata['OptTable']['name']; ?></td>
   <td><?php echo $otdata['Patient']['lookup_name']; ?></td>
   <td><?php echo $otdata['OptAppointment']['diagnosis']; ?></td>
   <td><?php echo $otdata['Surgery']['name']; ?></td>
   <td><?php echo $otdata['OptAppointment']['operation_type']; ?></td>
   <td><?php echo $otdata['DoctorProfile']['doctor_name']; ?></td>
  <td><?php echo $otdata['Doctor']['full_name']; ?></td>
   <td><?php echo $otdata['OptAppointment']['anaesthesia']; ?></td>
  </tr>
  <?php 
       endforeach;
      } else {
  ?>
  <tr>
   <td colspan="11" align="center"><?php echo __('No record found', true); ?>.</td>
  </tr>
  <?php
      }
  ?>
 </table>
        </table>

