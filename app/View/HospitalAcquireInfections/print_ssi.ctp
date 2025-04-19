<div id="printButton">
  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
</div>
<body class="print_form"  onload="window.print();"> <!-- onload="window.print();window.close();" -->
<div class="ht5">&nbsp;</div>
<?php 
	echo $this->element('patient_header') ;
?>

<div class="clr ht5"></div>
	<table width="100%" cellpadding="5" cellspacing="0" border="1" >
                   		<tr>
                        	<th colspan="7"><?php echo __('Operation',true); ?></th>
                        </tr>
                        <tr>
                        	<td width="25%" ><?php echo __('Type Of Operation',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['operation_type'];
                            ?>
                            </td>
                        </tr>
                     </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
				   <table width="100%" cellpadding="5" cellspacing="0" border="1" >
                   		<tr>
                        	<th colspan="7"><?php echo __('Wound',true); ?></th>
                        </tr>
                        <tr>
                        	<td width="25%" ><?php echo __('Location',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['wound_location'];
                            ?>
                            </td>
                        </tr>
						<tr>
                        	<td  ><?php echo __('Type',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['wound_type'];
                            ?>
                            </td>
                        </tr>
                     </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
				   <table width="100%" cellpadding="5" cellspacing="0" border="1" >
                   		<tr>
                        	<th colspan="7"><?php echo __('Advance Surgical Associates(ASA) score',true); ?></th>
                        </tr>
                        <tr>
                        	<td width="25%"  ><?php echo __('Score Type',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['asa_scoretype'];
                            ?>
                            </td>
                        </tr>
                     </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
				   <table width="100%" cellpadding="5" cellspacing="0" border="1" >
                   		<tr>
                        	<th colspan="2"><?php echo __('Antibiotics',true); ?></th>
                        </tr>
                        <tr>
                        	<td width="25%" ><?php echo __('Antimicrobial prophylaxis ',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['antimicrobial_prophylaxis'];
                            ?>
                            </td>
                        </tr>
                     </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
				   <table width="100%" cellpadding="5" cellspacing="0" border="1" >
                   		<tr>
                        	<th colspan="2"><?php echo __('Surgical site infection',true); ?></th>
                        </tr>
                        <tr>
                        	<td width="25%" ><?php echo __('Infection site',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['ssi_infection'];
                            ?>
                            </td>
                        </tr>
						<tr>
                        	<td  ><?php echo __('Microorganism 1',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['ssi_micro1'];
                            ?>
                            </td>
                        </tr>
						<tr>
                        	<td  ><?php echo __('Microorganism 2',true); ?></td>
                            <td>
                            <?php 
                               echo $ssi['SurgicalSiteInfection']['ssi_micro2'];
                            ?>
                            </td>
                        </tr>
						<tr>
                        	<td  ><?php echo __('Date of last contact',true); ?></td>
                            <td>
                            <?php if($ssi['SurgicalSiteInfection']['ssi_lastcontact'])
                            	echo $this->DateFormat->formatDate2Local($ssi['SurgicalSiteInfection']['ssi_lastcontact'],Configure::read('date_format'));
                               
                            ?>
                            </td>
                        </tr>
						<tr>
                        	<td  ><?php echo __('Comments',true); ?></td>
                            <td>
                            <?php 
                               echo nl2br($ssi['SurgicalSiteInfection']['comments']);
                            ?>
                            </td>
                        </tr>
                     </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
				   <div class="clr ht5"></div> 
</body>