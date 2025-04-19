<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">   	  
      <tr>
        	<th colspan="3" style="text-transform:uppercase;">Patient's Information</th>
      </tr>                      
      <tr>
        <td width="49%" align="left" valign="top" style="padding-top:7px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <td width="100" height="25" valign="top" class="tdLabel1" id="boxSpace1">Name </td>
                <td align="left" valign="top">
                	<?php
                			echo $patient[0]['lookup_name'];
                	?>
				</td>
              </tr>
              <tr>
                <td valign="top" class="tdLabel1" id="boxSpace1">Address </td>
                <td align="left" valign="top" style="padding-bottom:10px;">
                	<?php
                	 
        				echo $address ;
        			?>
        		</td>
              </tr>
        </table>                        </td>
        <td width="" align="left" valign="top">&nbsp;</td>
        <td width="49%" align="left" valign="top" style="padding-top:7px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="140" height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __("MRN");?></td>
            <td align="left" valign="top"><?php
            	echo $patient['Patient']['admission_id'];
            ?></td>
          </tr>
          <tr>
            <td width="140" height="25" valign="top" class="tdLabel1" id="boxSpace1">Patient ID</td>
            <td align="left" valign="top">
            <?php
            	echo $patientUID  ;
            ?>
            </td>
          </tr>
          <tr>
            <td height="25" valign="top" class="tdLabel1" id="boxSpace1">Sex</td>
            <td align="left" valign="top"><?php
            	echo ucfirst($patient['Patient']['sex']);
            ?></td>
          </tr>
          <tr>
            <td height="25" valign="top" class="tdLabel1" id="boxSpace1">Age  </td>
            <td align="left" valign="top"><?php
            	echo $patient['Patient']['age'];
            ?></td>
          </tr>
          </table></td>
      </tr>
    </table>
 <div>&nbsp;</div>   
<div style="text-align: right;" class="inner_title">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'hospital_acquire_infections','action'=>'surgical_site_infections',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false)); 
           ?>
</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr class="row_title">
    <td class="table_cell"><strong><?php echo $this->Paginator->sort('SurgicalSiteInfection.operation_type', __('Operation Type', true)); ?></strong></td>
    <td class="table_cell"><strong><?php echo $this->Paginator->sort('SurgicalSiteInfection.wound_location', __('Wound Location', true)); ?></strong></td>
    <td class="table_cell"><strong><?php echo $this->Paginator->sort('SurgicalSiteInfection.wound_type', __('Wound Type', true)); ?></strong></td>
    <td class="table_cell"><strong><?php echo $this->Paginator->sort('SurgicalSiteInfection.ssi_lastcontact', __('Last Contact', true)); ?></strong></td>
    <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($ssidata) > 0) {
       foreach($ssidata as $ssidataval): 
        $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format"><?php echo $ssidataval['SurgicalSiteInfection']['operation_type']; ?> </td>
   <td class="row_format"><?php echo $ssidataval['SurgicalSiteInfection']['wound_location']; ?> </td>
   <td class="row_format"><?php echo $ssidataval['SurgicalSiteInfection']['wound_type']; ?> </td>
   <td class="row_format"><?php

   	if($ssidataval['SurgicalSiteInfection']['ssi_lastcontact']) 
    	echo $this->DateFormat->formatDate2Local($ssidataval['SurgicalSiteInfection']['ssi_lastcontact'],Configure::read('date_format'));
   	   ?> </td>
   <td class="row_format">
   <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title' => 'View SSI', 'alt' => 'View SSI')), array('action' => 'view_ssi',  $ssidataval['SurgicalSiteInfection']['id'], $ssidataval['SurgicalSiteInfection']['patient_id']), array('escape' => false));
   ?>
  </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
    </TD>
   </tr>
  <?php
  
      } else {
  ?>
  <tr>
   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
  
 </table>

