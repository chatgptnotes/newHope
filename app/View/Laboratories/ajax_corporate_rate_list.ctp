<p class="ht5"></p>
<div class="tdLabel2" style="text-align: center;">
	<h3>TEST NAME: <?php echo $test_name ;?></h3>
</div>
<table width="650" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" align="center">
	<tr>
		<th width="50">Sr. No.</th>
		<th width="400">Tariff Standards</th>
		<th width="50" style="text-align: center;">NABH Rate</th>
		<th width="50" style="text-align: center;">NON-NABH Rate</th>
	</tr>
                      <?php
																						
																						foreach ( $corporates_rate as $key => $data ) {
																							?>
                       		  <tr>
		<td><?php echo $counter = $key+1 ;?></td>
		<td><?php echo $data['TariffStandard']['name'] ;?></td>
		<td valign="top">
                               <?php
																							if (isset ( $corporates_rate [$key] ['CorporateLabRate'] ['id'] )) {
																								echo $this->Form->hidden ( '', array (
																										'name' => "data[CorporateLabRate][$counter][id]",
																										'value' => $corporates_rate [$key] ['CorporateLabRate'] ['id'] 
																								) );
																								$nabh_rate = $corporates_rate [$key] ['CorporateLabRate'] ['nabh_rate'];
																								$non_nabh_rate = $corporates_rate [$key] ['CorporateLabRate'] ['non_nabh_rate'];
																							} else {
																								$nabh_rate = '0';
																								$non_nabh_rate = '0';
																							}
																							echo $this->Form->input ( '', array (
																									'name' => "data[CorporateLabRate][$counter][nabh_rate]",
																									'type' => 'text',
																									'class' => '',
																									'value' => $nabh_rate,
																									'id' => "rate-$counter",
																									'size' => 6,
																									'maxLength' => 15,
																									'width' => '80%',
																									'label' => false,
																									'div' => false,
																									'error' => false 
																							) );
																							
																							echo $this->Form->hidden ( '', array (
																									'name' => "data[CorporateLabRate][$counter][laboratory_id]",
																									'value' => $labId 
																							) );
																							echo $this->Form->hidden ( '', array (
																									'name' => "data[CorporateLabRate][$counter][department]",
																									'value' => $department 
																							) );
																							echo $this->Form->hidden ( '', array (
																									'name' => "data[CorporateLabRate][$counter][tariff_standard_id]",
																									'value' => $data ['TariffStandard'] ['id'] 
																							) );
																							
																							?>
                                </td>
		<td>
                                <?php
																							echo $this->Form->input ( '', array (
																									'name' => "data[CorporateLabRate][$counter][non_nabh_rate]",
																									'type' => 'text',
																									'class' => '',
																									'value' => $non_nabh_rate,
																									'id' => "rate-$counter",
																									'size' => 6,
																									'maxLength' => 15,
																									'width' => '80%',
																									'label' => false,
																									'div' => false,
																									'error' => false 
																							) );
																							
																							?>
                                </td>
	</tr>
                      <?php } ?>
                       
                      </table>
<p class="ht5"></p>
<table width="650" cellpadding="0" cellspacing="0" border="0"
	align="center">
	<tr>
		<td width="100%" align="center">
                            		<?php
																														echo $this->Form->submit ( __ ( 'Update' ), array (
																																'id' => 'update',
																																'title' => 'Update',
																																'escape' => false,
																																'class' => 'blueBtn',
																																'label' => false,
																																'div' => false,
																																'error' => false 
																														) );
																														echo $this->Html->link ( __ ( 'Cancel' ), array (
																																'action' => 'corporate_lab_rate' 
																														), array (
																																'escape' => false,
																																'class' => 'grayBtn' 
																														) );
																														?>
                            	</td>
	</tr>
</table>