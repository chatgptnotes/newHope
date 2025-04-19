<div class="inner_title">
<h3> &nbsp; <?php echo __('View Surgical Site Infections', true); ?></h3>
<span> <a class="blueBtn" href="<?php echo $this->Html->url("/hospital_acquire_infections/surgical_site_infections/". $patient['Patient']['id']); ?>"><?php echo __('Back'); ?></a></span>
</div>
<div class="patient_info">
 <?php echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>
<div style="text-align: right;" class="clr inner_title"></div>
	
    <div>&nbsp;</div>    
     <div class="clr ht5"></div>
                   
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
                        	<th colspan="7"><?php echo __('Operation',true); ?></th>
                        </tr>
                        <tr>
                        	<td width="250" ><?php echo __('Type Of Operation',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['operation_type'];
                            ?>
                            </td>
                        </tr>
                     </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
				   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
                        	<th colspan="7"><?php echo __('Wound',true); ?></th>
                        </tr>
                        <tr>
                        	<td width="250" ><?php echo __('Location',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['wound_location'];
                            ?>
                            </td>
                        </tr>
						<tr>
                        	<td width="250" ><?php echo __('Type',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['wound_type'];
                            ?>
                            </td>
                        </tr>
                     </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
				   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
                        	<th colspan="7"><?php echo __('Advance Surgical Associates(ASA) score',true); ?></th>
                        </tr>
                        <tr>
                        	<td width="250" ><?php echo __('Score Type',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['asa_scoretype'];
                            ?>
                            </td>
                        </tr>
                     </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
				   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
                        	<th colspan="2"><?php echo __('Antibiotics',true); ?></th>
                        </tr>
                        <tr>
                        	<td width="250" ><?php echo __('Antimicrobial prophylaxis ',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['antimicrobial_prophylaxis'];
                            ?>
                            </td>
                        </tr>
                     </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
				   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
                        	<th colspan="7"><?php echo __('Surgical site infection',true); ?></th>
                        </tr>
                        <tr>
                        	<td width="250" ><?php echo __('Infection site',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['ssi_infection'];
                            ?>
                            </td>
                        </tr>
						<tr>
                        	<td width="250" ><?php echo __('Microorganism 1',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['ssi_micro1'];
                            ?>
                            </td>
                        </tr>
						<tr>
                        	<td width="250" ><?php echo __('Microorganism 2',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['ssi_micro2'];
                            ?>
                            </td>
                        </tr>
						<tr>
                        	<td width="250" ><?php echo __('Date of last contact',true); ?></td>
                            <td>
                            <?php if($ssi['SurgicalSiteInfection']['ssi_lastcontact'])
                            	echo $this->DateFormat->formatDate2Local($ssi['SurgicalSiteInfection']['ssi_lastcontact'],Configure::read('date_format'));
                               
                            ?>
                            </td>
                        </tr>
						<tr>
                        	<td width="250" ><?php echo __('Comments',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['comments'];
                            ?>
                            </td>
                        </tr>
                     </table>
                  
