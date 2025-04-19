<style>
.tabularForm td{
	background: none !important;
}

 .tabularForm tr:nth-child(even) {background: #E2EDF7 !important}
 .tabularForm tr:nth-child(odd) {background: #c2cfdc !important}

</style>
<div class="inner_title">
	<h3>Camp Details</h3>
	<span><?php 
	echo $this->Html->link('Add Camp Details',array('action'=>'camp_survey_detail'),array('escape'=>false,'class'=>'blueBtn'));
	//echo $this->Html->link('Add Camp Participants Details',array('action'=>'add_camp_participant'),array('escape'=>false,'class'=>'blueBtn'));?></span>
</div>
<?php echo $this->Form->create('searchCamp',array('id'=>'camp'))?>
<table>
	<tr>
		<td>Camp Name</td>
		<td><?php echo $this->Form->input('camp_name',array('name'=>'camp_name','class'=>'name','value'=>$camp_name,
															'div'=>false,'label'=>false));
				  echo $this->Form->hidden('camp_id',array('name'=>'camp_id','class'=>'camp_id','value'=>$camp_id,
															'div'=>false,'label'=>false));?></td>
		<td>Date From</td>
		<td><?php echo $this->Form->input('date_from',array('name'=>'date_from','class'=>'','style'=>'float:left',
															'value'=>$dateFrom,'div'=>false,'label'=>false));?></td>
		<td>Date To</td>
		<td><?php echo $this->Form->input('date_to',array('name'=>'date_to','class'=>'','style'=>'float:left',
														  'value'=>$dateTo,'div'=>false,'label'=>false));?></td>
		<td><?php echo $this->Form->button('Search',array('class'=>'blueBtn',
														  'div'=>false,'label'=>false));?></td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<table class="tabularForm">
	<tr>
		<th>Sr.No</th>
		<th>Date Of Camp</th>
		<th>Camp Name</th>
		<th>Camp Location</th>
		<th>Action</th>
	</tr>
	<?php $i=1; foreach ($list as $detail){ ?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $this->DateFormat->formatDate2Local($detail['CampDetail']['camp_date'],Configure::read('date_format'),true);?></td>
				<td><?php echo ucwords(strtolower($detail['CampDetail']['camp_name']));?></td>
				<td><?php echo ucwords(strtolower($detail['CampDetail']['camp_venue']));?></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('alt'=>'Edit Camp Details')),
												array('action'=>'camp_survey_detail',$detail['CampDetail']['id']),
												array('escape'=>false));
				
						  echo $this->Html->link($this->Html->image('icons/plus.png',array('alt'=>'Add Participants')),
												array('action'=>'add_camp_participant',$detail['CampDetail']['id']),
												array('escape'=>false));
					?>
				</td>
			</tr>
	<?php $i++;}?>

</table>
<script>
$(document).ready(function(){
	$('#camp').validationEngine();
	$("#searchCampDateFrom, #searchCampDateTo").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		//minDate: 0,
		dateFormat: '<?php echo $this->General->GeneralDate();?>',		
	});	

	$(".name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete",'CampDetail','id&camp_name','null',"no",'no','is_deleted=0',"admin" => false,"plugin"=>false)); ?>",
		select: function(event,ui){	
			$("#searchCampCampId" ).val(ui.item.id);
			$('.ui-helper-hidden-accessible').hide();
		}
	});
});
</script>