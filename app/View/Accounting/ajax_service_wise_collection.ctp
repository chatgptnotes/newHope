<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="25%" align="center" valign="top">SubGroup Name</th> 
						<th width="25%" align="center" valign="top" style="text-align: center; ">Net Amount</th> 
						<th width="25%" align="center" valign="top" style="text-align: center;">Discount</th>
						<!-- <th width="25%" align="center" valign="top" style="text-align: center;">Net Amount</th> -->
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach ($dataDetails as $key=> $data){?>
					<tr>
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
								<?php  echo $data['ServiceSubCategory']['name'];?>
							</div>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo  $data['0']['total_amount'];
							$totalRevenue +=  (int) $data['0']['total_amount'];?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $data['0']['total_discount'];
							$totalDiscount +=  (int) $data['0']['total_discount'];?>
						</td>
						
						<!-- <td class="tdLabel"  style= "text-align: center;">
						<?php $netAmount = ($data['0']['total_amount']);
							 echo $netAmount;
							$totalNetAmount +=  (int) $netAmount?>
						</td> -->
				  	</tr>
				<?php } ?>
				</tbody>
			<tr>
				<td class="tdLabel" colspan="0" style="text-align: left;"><?php echo __('Grand Total :');?></td>
					<?php if(empty($totalRevenue)){ ?>
							<td class="tdLabel"><?php echo " ";?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalRevenue)?></td>
					<?php } 
					if(empty($totalDiscount)){ ?>
						<td class="tdLabel"><?php echo " ";?></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalDiscount)?></td>
					<?php }
					//if(empty($totalNetAmount)){ ?>
						<!--  <td class="tdLabel"><?php echo " ";?></td><?php
					//}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalNetAmount)?></td>-->
					<?php // } ?>
			</tr>  
			<?php echo $this->Form->end();?>
			</table>