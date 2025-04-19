<style>
@media print {
		#printButton {
			display: none;
		}
		
		#hideFromPage{
		display: none;
		}
	}
.row_gray{
  #acdef6 none repeat scroll 0 0 !important
}
</style>

<div class="inner_title">
<h3><?php echo __('Referral Doctors', true);?></h3>
<div id="printButton" style="float: right;">
	<?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
</div>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="container-table">
	  <tr>
        <td align="center" colspan ="9" ><strong>PRINT DATE & TIME : <?php echo $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true);?></strong></td>  
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
    <th width="20%"><strong><?php echo  __('Name', true); ?></strong></th>    
    <th width="6%"><strong><?php echo __('Marketing Team', true); ?></strong></th>
    <th width="6%"><strong><?php echo __('Sponsors', true); ?></strong></th>
    <th width="10%"><strong><?php echo  __('Email', true); ?></strong></th>
    <th width="6%"><strong><?php echo __('Mobile', true); ?></strong></th>
    <th width="10%"><strong><?php echo __('Camp Date', true); ?></strong></th> 
    <th width="20%"><strong><?php echo __('Alias', true); ?></strong></th>   
    <th width="29%"><strong><?php echo __('Remark', true); ?></strong></th>     
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

