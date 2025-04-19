<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Staff_Plan".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Generated Report" );
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
   <td colspan = "6" align="center"><h2><?php echo __('Staff Plan'); ?></h2></td>
  </tr>
  <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong>Employee Name</strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong>Start Date</strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong>End Date</strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong>Subject</strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong>Details</strong></td>
  </tr>
  <?php 
        $cntCollection=0;
        $totalAmount = 0; 
        
  ?>
 <?php 
        // get staff plan //
        if(count($getStaffPlan) > 0) {
          foreach($getStaffPlan as $getStaffPlanVal) {
            $cntStaff++;
						
 ?>
           <tr>			
		    <td align='center' height='17px'><?php echo $cntStaff; ?></td>
			<td align='center' height='17px'><?php echo $getStaffPlanVal['Initial']['name']." ".$getStaffPlanVal['User']['first_name']." ".$getStaffPlanVal['User']['middle_name']." ".$getStaffPlanVal['User']['last_name']; ?></td>
	        <td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($getStaffPlanVal['StaffPlan']['starttime'],Configure::read('date_format'), true); ?></td>
	       	<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($getStaffPlanVal['StaffPlan']['endtime'],Configure::read('date_format'), true); ?></td>
            <td align='center' height='17px'><?php echo $getStaffPlanVal['StaffPlan']['subject']; ?></td>
			<td align='center' height='17px'><?php echo $getStaffPlanVal['StaffPlan']['purpose']; ?></td>
			</tr>
           
 <?php             
          }
        } else { ?>
           <tr>					
  <td align='center' height='17px' colspan="6">No Record Found</td>
 </tr>
 <?php
        }
 ?>
</table>
		
