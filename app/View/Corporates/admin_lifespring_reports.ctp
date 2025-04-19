<style>
.all_ul {
	text-decoration: none;
	line-height: 0.5;
	font-size: 13px;
}

.all_li {
	text-decoration: none;
	line-height: 1.4;
	font-size: 13px;
}

.tbLabel {
	font-size: 13px;
}

table td {
	font-size: 13px;
}
</style>


<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Reports Management', true); ?>
	</h3>
</div>

<table id="managerial" width="50%"
	style="border-left: 1px solid #4C5E64; border-right: 1px solid #4C5E64; border-top: 1px solid #4C5E64; margin-top: 20px;">
	<tr class="row_title">
		<td width="10%" height="30px" class="table_cell">Sr. No.</td>
		<td class="table_cell">Name Of Report</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;1</td>
		<td class="tbLabel">&nbsp;Legal Compliances
			<table id="total_reg">
				<ul class="all_ul">

					<li class="all_li">&nbsp;<?php echo $this->Html->link('Birth Report',array('controller'=>'corporates','action'=>'nmc_birth_report','admin'=>false));?>
					</li>

                    <li class="all_li">&nbsp;<?php echo $this->Html->link('MTP Report',array('controller'=>'corporates','action'=>'mtp_report','admin'=>false));?>
					</li>
					
					<li class="all_li">&nbsp;<?php echo $this->Html->link('Equipment Maintenance Report',array('controller'=>'corporates','action'=>'equip_maintenance','admin'=>false));?>
					</li>
					
					<li class="all_li">&nbsp;<?php echo $this->Html->link('PNDT Report',array('controller'=>'corporates','action'=>'pndt_report','admin'=>false));?>
					</li>
				</ul>

			</table>
		</td>
	</tr>
	<tr >
		<td valign="top">&nbsp;2</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Bed Occupancy Report',array('controller'=>'reports','action'=>'ward_occupancy_rate','admin'=>false));?>
		</td>
	</tr>
	<tr class="row_gray">
		<td valign="top">&nbsp;3</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Doctor Wise Billing',array('controller'=>'reports','action'=>'doctorwise_collection', 'admin'=>true));?>
		</td>
	</tr>
	<tr >
		<td valign="top">&nbsp;4</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Total Surgery Report',array('controller'=>'reports','action'=>'patient_ot_report','admin'=>true));?>
		</td>
	</tr>
	
	<tr class="row_gray">
		<td valign="top">&nbsp;5</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('No shows Report',array('controller'=>'MeaningfulReport','action'=>'appointment_log','?'=>"flag=1",'admin'=>false));?>
		</td>
	</tr>
	
	<tr >
		<td valign="top">&nbsp;6</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Arrivals Report',array('controller'=>'reports','action'=>'no_of_arrival_patient','admin'=>false));?>
		</td>
	</tr>

	<tr class="row_gray">
				 <td valign="top">&nbsp;7</td> 
				 <td>&nbsp;<?php echo $this->Html->link('Overstay Customers',array('controller'=>'reports','action'=>'overstay_customers', 'admin'=>false));?></td>
	</tr>
	
	<tr >
		<td valign="top">&nbsp;8</td>
		<td class="tbLabel">&nbsp;<?php echo $this->Html->link('Expenses Incurred for Cases',array('controller'=>'reports','action'=>'profit_referral_doctor','admin'=>false));?>
		</td>
	</tr>

	<tr class="row_gray">
				 <td valign="top">&nbsp;9</td> 
				 <td>&nbsp;<?php echo $this->Html->link('Conversion Percentage Report',array('controller'=>'corporates','action'=>'conversion_percentage_report', 'admin'=>false));?></td>
	</tr>
	<!-- <tr>
				 <td valign="top">&nbsp;10</td> 
				 <td>&nbsp;<?php echo $this->Html->link('TPA Interface Report',array('controller'=>'corporates','action'=>'tpa_interface_report', 'admin'=>false));?></td>
	</tr> -->
	<tr class="">
				 <td valign="top">&nbsp;10</td> 
				 <td>&nbsp;<?php echo $this->Html->link('Patient Reminder Report',array('controller'=>'corporates','action'=>'patient_reminder','?'=>'flag=tab1', 'admin'=>false));?></td>
	</tr>
</table>

