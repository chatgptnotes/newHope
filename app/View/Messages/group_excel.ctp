<?php 
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Group_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Expiry Report" );
ob_clean();
flush();
?>

<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" style="width:50% !important" align="left">    <tr>
        <td align="center"><h2><strong>SMS Group Report</strong></h2></td>
        <td align="left"><strong>Print Date & Time : <?php echo $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true);?></strong></td>
    </tr>
        <tr> 
  <tr class="row_title">
    <td class="table_cell" align="left"><strong><?php echo  __('Name', true); ?></strong></td>
  <td class="table_cell" align="left"><strong><?php echo  __('Active', true); ?></strong></td>  
  </tr>
  <?php 
      $cnt =0;  
      if(count($data) > 0) {
       foreach($data as $datas): 
        $cnt++;
    
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format" align="left"><?php echo $datas['GroupSms']['name']; ?> </td>
    <td class="row_format" align="left">
   <?php if($datas['GroupSms']['is_active'] == 1) {          
             $imgSrc = 'active.png';
             $activeTitle = 'Active';
             $status = 0;
          } else {           
             $imgSrc = 'inactive.jpg';
             $activeTitle = 'InActive';
             $status = 1;
          }
    echo  $activeTitle; ?></td>
   
  </tr>
  <?php endforeach;  ?>  
  <?php } else { ?>
  <tr>
    <TD colspan="2" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php }?>  
 </table>
