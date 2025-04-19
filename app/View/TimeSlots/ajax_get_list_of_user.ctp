
<style>
.row_gray {
    background-color: #d6d6d6;
}
img{
	float: unset;
}
.noDate{
	margin-right: 19px;
	width : 120px !important;
}
</style>
<?php echo $this->Form->create('DutyPlan',array('type' => 'post','id'=>'dutyFrm','url'=>array("controller" => "TimeSlots",  "action" => "ajaxGetListOfuser"),'inputDefaults' => array('label' => false,'div' => false,)));?>
<table border="0" class="table-format" cellpadding="0" cellspacing="0" id='userList'
	width="100%" align="left">
	
	<tr class="row_title">
		<td width="20%" class="table_cell" align="center"><strong> Name</strong></td>
		<td width="20%" class="table_cell" align="center"><strong> Start Date</strong></td>
		<td width="20%" class="table_cell" align="center"><strong> First Shift</strong></td>
		<td width="20%" class="table_cell" align="center"><strong> Day Off</strong></td>
		<?php if(!empty($user)){?>
		<?php $counter = 1;
		 $cnt =0;
      if(count($$user) > 0) ?> 
	</tr><?php  foreach($user as $data) {    $cnt++ ?>
	<tr <?php if($cnt%2 ==0) { echo "class='row_gray'"; }?>>  
		<td class="row_format" align="center"><?php echo $data['User']['full_name']; ?>
		<?php echo $this->Form->hidden("DutyPlan.$counter.user_id",array('id'=>'userId','value'=>$data['User']['id']));?>
		<?php echo $this->Form->hidden("DutyPlan.$counter.id",array('id'=>'planId','value'=>$data['DutyPlan']['id']));?></td>
		
	         <?php   $dates = $this->DateFormat->formatDate2Local($data[DutyPlan][first_duty_date],Configure::read('date_format'));  ?>
	         <?php $class = ($data['DutyPlan']['is_roster_set']) ? 'noDate' : 'date';?>
		<td align='center'><?php echo $this->Form->input("DutyPlan.$counter.first_duty_date",array('type'=>'text','class'=>"textBoxExpnd $class",'autocomplete'=>'off',
				'label'=>false,'div'=>false,'value'=>$dates,'style'=>'float: unset; ','readOnly'=>true));?></td>
		
		<td align='center'><?php echo $this->Form->input("DutyPlan.$counter.first_shift", array('type' => 'select','empty'=>'Please Select','options' =>$shifts ,
				 'label'=>false ,'div'=>false,'value'=>$data['DutyPlan']['first_shift'],'disabled'=>$data['DutyPlan']['is_roster_set']));?>
				 <?php if($data['DutyPlan']['is_roster_set'])
				 		echo $this->Form->hidden("DutyPlan.$counter.first_shift",array('value'=>$data['DutyPlan']['first_shift']));
				 	?>
		</td>
		
	   <td align='center'><?php echo $this->Form->input("DutyPlan.$counter.allow_day_off", array('type' =>'checkbox','label' => false,'legend' => false,
	   		'checked'=>$data['DutyPlan']['allow_day_off'] ,'disabled'=>$data['DutyPlan']['is_roster_set']));?>
	   		 <?php if($data['DutyPlan']['is_roster_set'])
				 		echo $this->Form->hidden("DutyPlan.$counter.allow_day_off",array('value'=>$data['DutyPlan']['allow_day_off']));
				 	?></td>	
	</tr>
	 
	<?php   $counter++ ;
}}else{?>
	<tr>
		<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr> 
	<?php }?>
	
	<?php echo $this->Form->end(); ?>
</table>
		<div colspan="4" align="right">
			<?php echo $this->Form->submit (__( 'Save' ),array('id' => 'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error' => false)); ?>
		</div>
 <div id="pageNavPosition" align="center"></div>

<script>

			var pager = new Pager('userList',15);
			pager.init();
			pager.showPageNav('pager','pageNavPosition');
			pager.showPage(1);
			
$(".date").datepicker({  
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: false,
		changeYear: false,
		yearRange: '1950',
		minDate : new Date('<?php echo $yearCondition?>',parseInt('<?php echo $this->params->query['month']?>')-1,1),  
		maxDate: new Date((new Date('<?php echo $yearCondition?>', '<?php echo $this->params->query['month']?>','<?php echo $this->params->query['day']?>' ))), 
		dateFormat: '<?php echo $this->General->GeneralDate();?>',
	});	
</script>