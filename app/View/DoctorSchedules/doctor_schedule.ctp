<?php
echo $this->Html->script(array('jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.slider.js','jquery-ui-timepicker-addon.js'));
?>
<div class="inner_title">
<h3><?php echo __('Doctor Schedule::Assign Doctor Appointment', true); ?></h3>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="80%"  align="center" >
        <tr>
	 <td class="form_lables">
          <?php 
                $options = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July','08' => 'August', '09' => 'September', '10' => 'October' , '11' => 'November', '12' => 'December');
                $attributes = array('id'=> 'monthval', 'value' => date('m'), 'onchange'=> $this->Js->request(array('action' => 'doctor_schedule'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#appointment', 'data' => '{monthidval:$("#monthval").val(),yearidval:$("#yearval").val(),doctidval:$("#doctid").val()}', 'dataExpression' => true)));
                echo $this->Form->select('month', $options, $attributes);
          ?>
         </td>
         <td>
         <?php 
          $options = array('2011' => '2011', '2012' => '2012', '2013' => '2013', '2014' => '2014', '2015' => '2015', '2016' => '2016', '2017' => '2017','2018' => '2018', '2019' => '2019', '2020' => '2020' , '2021' => '2021', '2022' => '2022','2023' => '2023','2024' => '2024','2025' => '2025','2026' => '2026','2027' => '2027','2028' => '2028','2029' => '2029','2030' => '2030');
                 $attributes = array('id'=> 'yearval', 'value' => date('Y'), 'onchange'=> $this->Js->request(array('action' => 'doctor_schedule'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#appointment', 'data' => '{monthidval:$("#monthval").val(),yearidval:$("#yearval").val(),doctidval:$("#doctid").val()}', 'dataExpression' => true)));
                 echo $this->Form->select('year', $options, $attributes);
         ?>
         </td>
        </tr>
        <tr>
	 <td class="form_lables" colspan="2" align="center" id="appointment" >
         <form name="doctorschedulesfrm" id="doctorschedulesfrm" action="<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "doctor_schedule")); ?>" method="post">
          <input type="hidden" name="doctid" value="<?php echo $doctid; ?>" id="doctid"/>
          <table border="0" cellpadding="0" cellspacing="0" align="center">
           <?php $cnt=0;
                 for($i=1; $i<=$numofdays; $i++) { 
           ?>
            <tr>
             <td><?php echo $i."&nbsp;".$monthval; ?></td>
             <td><?php echo __('From:', true); ?><input type="text" name="schedule[<?php echo $cnt; ?>][startdate][<?php echo $i."_".$monthval."_".$yearval; ?>]" class="appointmentdate" id="date<?php echo $i; ?>"/>&nbsp;&nbsp;<?php echo __('To:', true); ?><input type="text" name="schedule[<?php echo $cnt; ?>][enddate][<?php echo $i."_".$monthval."_".$yearval; ?>]" class="appointmentdate" id="date<?php echo $i.$i; ?>"/></td>
           </tr>
          <?php 
                $cnt++;
                }
          ?>
          <tr>
	   <td colspan="2" align="center">
	    <input type="submit" value="Submit" class="blueBtn">
	  </td>
	 </tr>
         </table>
         </form>
	 </td>
        </tr>
       </table>

<script>
$(document).ready(function(){
		// binds form submission and fields to the validation engine
	        jQuery("#doctorschedulesfrm").validationEngine();
		//script to include datepicker
		$(function() {
			$( ".appointmentdate" ).timepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
			
                        

			
		});		
		});
	});
        
 
</script>