<?php
echo $this->Html->script(array('jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.slider.js','jquery-ui-timepicker-addon.js'));
?>
<div class="inner_title">
<h3><?php echo __('Doctor Schedule::Edit Scheduled Doctor', true); ?></h3>
</div>
<form name="scheduledoctorfrm" id="scheduledoctorfrm" action="<?php echo $this->Html->url(array("action" => "scheduled_edit")); ?>" method="post" onSubmit="return Validate(this);" >
        <?php 
             echo $this->Form->input('DoctorSchedule.id', array('type' => 'hidden')); 
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
        <tr>
	<td class="form_lables">
	<?php echo __('Doctor Name',true); ?>
	</td>
	<td>
        <?php 
              echo $this->data['DoctorProfile']['doctor_name'];
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Schedule Date',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
         $changeDate = $this->DateFormat->formatDate2Local($this->data['DoctorSchedule']['schedule_date'],Configure::read('date_format'));
        
        
        echo $this->Form->input('DoctorSchedule.schedule_date', array('class' => 'validate[required,custom[mandatory-date]]', 'id' => 'mandatory-date', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text', 'value'=>$changeDate));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Start Schedule Time',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorSchedule.schedule_time', array('class' => 'validate[required,custom[starttime]]', 'id' => 'starttime', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text'));
        ?>
	</td>
	</tr>
        <tr>
        <tr>
	<td class="form_lables">
	<?php echo __('End Schedule Time',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorSchedule.end_schedule_time', array('class' => 'validate[required,custom[endtime]]', 'id' => 'endtime', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text'));
        ?>
	</td>
	</tr>
        <tr>
	<td colspan="2" align="center">
        &nbsp;
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel', true), array('action' => 'scheduled_doctor'),  array('class' => 'blueBtn','escape' => false));?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#scheduledoctorfrm").validationEngine();

         //script to include datepicker
		$(function() {
			$( "#mandatory-date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '2011:2040',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			
		});		
		});
                 //script to include datepicker
		$(function() {
			$( "#starttime, #endtime" ).timepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true
			
			
		});		
		});
	});
	
</script>
