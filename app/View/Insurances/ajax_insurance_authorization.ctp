<table style="margin: 10px;" width="100%" class="table_format" cellspacing="0">
		<tr class="row_title">
			<td class="table_cell"><?php echo __('Authorization Number')?></td>
			<td class="table_cell"><?php echo __('Procedure')?></td>
			<td class="table_cell"><?php echo __('Start Date')?></td>
			<td class="table_cell"><?php echo __('End Date')?></td>
			<td class="table_cell"><?php echo __('Visits Approved')?></td>
			<td class="table_cell"><?php echo __('Visits Remaining')?></td>
			<td class="table_cell"><?php echo __('Notes')?></td>
			<td class="table_cell"><?php echo __('Actions')?></td>
		</tr>
		<?php foreach($activeAuthorizations as $activeAuthorizations){ ?>
		<tr>
			<td class="tdLabel"><?php echo $activeAuthorizations['InsuranceAuthorization']['authorization_number'];?></td>
			<td class="tdLabel"><?php echo $activeAuthorizations['TariffList']['name'];?></td>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2LocalForReport($activeAuthorizations['InsuranceAuthorization']['start_date'],Configure::read('date_format'),false);?></td>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2LocalForReport($activeAuthorizations['InsuranceAuthorization']['end_date'],Configure::read('date_format'),false);?></td>
			<td class="tdLabel"><?php echo $activeAuthorizations['InsuranceAuthorization']['visit_approved'];?></td>
			<td class="tdLabel"><?php echo $activeAuthorizations['InsuranceAuthorization']['visit_remaining'];?></td>
			<td class="tdLabel"><?php echo $activeAuthorizations['InsuranceAuthorization']['notes'];?></td>
			<td class="tdLabel">
			<?php echo $this->Html->image('icons/edit-icon.png',array('alt'=>'Edit','title'=>'Edit Insurance Authorization','class'=>'edit','id'=>'edit_'.$activeAuthorizations['InsuranceAuthorization']['id']));?>
			<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'Delete Insurance Authorization','class'=>'delete','id'=>'delete_'.$activeAuthorizations['InsuranceAuthorization']['id']));?>
			</td>
		</tr>
	<?php }?>
</table>


<div class="inner_title">
	<td><h3>
		&nbsp;<?php echo __('Expired Authorizations', true); ?>
	</h3></td>
	<span></span>
</div>
<table style="margin: 10px;" width="100%" class="table_format" cellspacing="0">
	<tr class="row_title">
		<td class="table_cell"><?php echo __('Authorization Number')?></td>
		<td class="table_cell"><?php echo __('Procedure')?></td>
		<td class="table_cell"><?php echo __('Start Date')?></td>
		<td class="table_cell"><?php echo __('End Date')?></td>
		<td class="table_cell"><?php echo __('Visits Approved')?></td>
		<td class="table_cell"><?php echo __('Visits Remaining')?></td>
		<td class="table_cell"><?php echo __('Notes')?></td>
		<td class="table_cell"><?php echo __('Actions')?></td>
	</tr>
	<?php foreach($expiredAuthorizations as $expiredAuthorization){?>
	<tr>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['authorization_number'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['TariffList']['name'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['start_date'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['end_date'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['visit_approved'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['visit_remaining'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['notes'];?></td>
		<td class="tdLabel">
			<?php echo $this->Html->image('icons/edit-icon.png',array('alt'=>'Edit','title'=>'Edit Insurance Authorization','class'=>'edit','id'=>'edit_'.$expiredAuthorization['InsuranceAuthorization']['id']));?>
			<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'Delete Insurance Authorization','class'=>'delete','id'=>'delete_'.$expiredAuthorization['InsuranceAuthorization']['id']));?>
			</td>
	</tr>
<?php }?>
</table> 	