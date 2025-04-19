<style>
.ui-datepicker-calendar {
    display: none;
    }
.table_format {
    padding: 0px !important;
}
</style>
<div class="inner_title">
	<h3><?php echo __('Consultant Outstanding Statement', true); ?></h3>
</div> 
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Voucher',array('id'=>'searchConsulStatement','url'=>array('controller'=>'Accounting','action'=>'consultantOutstandingStatement','admin'=>false)));?>
<table align="center" border='0' cellpadding="2" cellspacing="0" class="row_format">
	<tbody>
		<?php 
			$monthArray = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August',
								'09'=>'September','10'=>'October','11'=>'November','12'=>'December');
				for($i=2010;$i<=date('Y')+5;$i++){
					$yearArray[$i] = $i;
				}
		?>
		<tr class="row_title">
			<td>
				<?php echo __("From Month");?>
			</td>
			<td>
				<?php echo $this->Form->input('fromMonth',array('options'=>$monthArray,'class'=>'textBoxExpnd','label'=>false,'default'=>date('m')));?>
			</td>
			<td>
				<?php echo __("From Year"); ?>
			</td>
			<td>
				<?php echo $this->Form->input('fromYear',array('options'=>$yearArray,'class'=>'textBoxExpnd','label'=>false,'default'=>date('Y')));?>
			</td>
			<td>
				<?php echo __("To Month");?>
			</td>
			<td>
				<?php echo $this->Form->input('toMonth',array('options'=>$monthArray,'class'=>'textBoxExpnd','label'=>false,'default'=>date('m')));?>
			</td>
			<td>
				<?php echo __("To Year"); ?>
			</td>
			<td>
				<?php echo $this->Form->input('toYear',array('options'=>$yearArray,'class'=>'textBoxExpnd','label'=>false,'default'=>date('Y')));?>
			</td>
			<td>
				<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false,'div'=>false,'id'=>'search'));?>
			</td>
			<td>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'consultantOutstandingStatement'),
							array('escape'=>false));?>
			</td>
		</tr>
	</tbody>
</table>
<?php echo $this->Form->end();?>

<table width="100%" cellpadding="0" cellspacing="1" border="0" style="padding-top:5px">
	<tr>
		<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="table_format" id="container-table">
				<thead>
					<tr class="row_title"> 
						<td width="7%" align="center" valign="top" style="text-align: center;"><?php echo __('Sr.No');?></td>
						<td width="47%" align="center" valign="top" style="text-align: center;"><?php echo __('Name Of Consultant');?></td> 
						<td width="10%" align="center" valign="top" style="text-align: center;" colspan="<?php echo count($monthList); ?>"><?php echo __('Months');?></td>
						<td width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Total');?></td> 
					</tr>
					<tr>
						<td></td>
						<td></td>
						<?php foreach($monthList as $mKey => $mVal) {  ?>
						<td style="text-align:center"><?php echo $mVal['year']."-".date("F",strtotime(date("Y-".$mVal['month']."-d"))); ?></td>
						<?php } ?>
						<td></td>
					</tr> 
				</thead>
				
				<tbody>
				<?php $count = 1; foreach ($userList as $userID => $userName){?>
					<tr>
						<td><?php echo $count++; ?></td>
						<td><?php echo $userName; ?></td>
						<?php foreach($monthList as $monthKey => $val){ ?>
							<td class="alignRight">
								<?php echo $data[$userID][$val['year']][$val['month']];
								$amount[$userID] += $data[$userID][$val['year']][$val['month']];?>
							</td>
						<?php } ?> 
						<td class="alignRight">
							<?php echo $this->Number->currency($amount[$userID]);?>					
						</td>
					</tr>
				<?php }?>
				</tbody>
				<tfoot>
					<tr>
						<td><?php echo __("");?></td>
						<td><?php echo __("Total");?></td>
						<?php foreach($monthList as $mKey => $mVal) {  ?>
							<td><?php echo $this->Number->currency($amount[$mVal['month']]);?></td>
						<?php }?>
					</tr>
				</tfoot>
			</table>
		</td>
	</tr>
</table>