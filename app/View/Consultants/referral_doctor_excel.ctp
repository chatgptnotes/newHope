<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Referral_Doctor_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Referral Doctor Report" );
ob_clean();
flush();
?>
<table width="50%" cellpadding="0" cellspacing="1" border="1" class="tabularForm" id="container-table">
  <tr>
        <td colspan = "7" align="center" height="400px"><h2><strong>Referral Doctor Report</strong></h2></td>
        <td align="left" colspan ="2" ><strong>PRINT DATE & TIME : <?php echo $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true);?></strong></td>  
      </tr>
      <?php 
        if(!empty($this->request->query['market_team'])){?>
      <tr>
        <td colspan = "9" align="center"><strong>Market Team :</strong><?php echo $marketing_teams[$this->request->query['market_team']];
            ?></td>
      </tr>
      <?php }?>
      <?php if(!empty($this->request->query['corporate_sublocation_id'])){?>
      <tr>
        <td colspan = "9" align="center"><strong>Sponsor :</strong><?php 
            if($this->request->query['corporate_sublocation_id']=="withoutsublocation"){
                echo "Without Sponsor";
            }else{
                echo $sponsor[$this->request->query['corporate_sublocation_id']];
            }?></td>
      </tr>
      <?php }?>
<thead>
  <tr class="row_title">   
    <th width="2%"><strong><?php echo  __('Sr.No.', true); ?></strong></th>
    <th width="7%"><strong><?php echo  __('Name', true); ?></strong></th>    
    <th width="5%"><strong><?php echo __('Marketing Team', true); ?></strong></th>
    <th width="7%"><strong><?php echo __('Sponsors', true); ?></strong></th>
    <th width="7%"><strong><?php echo  __('Email', true); ?></strong></th>
    <th width="7%"><strong><?php echo __('Mobile', true); ?></strong></th>
    <th width="7%"><strong><?php echo __('Camp Date', true); ?></strong></th> 
    <th width="9%"><strong><?php echo __('Alias', true); ?></strong></th>   
    <th width="12%"><strong><?php echo __('Remark', true); ?></strong></th>   
  </tr>
  </thead>
  <tbody>
  <?php   
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $consultant):
         $cnt++
  ?>
   <tr <?php if($cnt%2 ==0) { echo "class='row_even'"; }?> >
   <td class="row_format" valign="top"><?php echo $cnt; ?></td>
   <td class="row_format" valign="top"><?php echo $initials[$consultant['Consultant']['initial_id']]." ".$consultant['Consultant']['first_name']." ".$consultant['Consultant']['last_name']; ?> </td>
   <td class="row_format" valign="top"><?php echo $consultant['Consultant']['market_team']; ?> </td>
   <td class="row_format" valign="top"><?php echo $sponsor[$consultant['Consultant']['corporate_sublocation_id']]; ?> </td>
   <td class="row_format" valign="top"><?php echo $consultant['Consultant']['email']; ?> </td>
   <td class="row_format" valign="top"><?php echo $consultant['Consultant']['mobile']; ?> </td>
   
   <td class="row_format" valign="top"><?php echo $this->DateFormat->formatDate2Local($consultant['Consultant']['camp_date'],Configure::read('date_format'),false); ?> </td> 
   <td class="row_format" valign="top"><?php echo ucwords($consultant['Consultant']['alias']);  ?> </td>
   <td class="row_format" valign="top"><?php echo nl2br(ucfirst($consultant['Consultant']['remark']));  ?> </td>   
  </tr>
  <?php endforeach;  ?>
   
  <?php
  
      } else {
  ?>
  <tr>
   <TD colspan="9" align="center"><strong><font color="RED"><?php echo __('No record found', true); ?>.</font></strong></TD>
  </tr>
  <?php
      }
  ?> 
  <tr>
   <TD colspan="9" align="left"><strong><?php echo "Total Referral Doctor :  ".count($data); ?></strong></TD>
  </tr>
 </table> 


