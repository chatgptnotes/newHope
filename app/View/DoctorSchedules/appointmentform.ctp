<form name="doctorschedulesfrm" id="doctorschedulesfrm" action="<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "doctor_schedule")); ?>" method="post">
<input type="hidden" name="doctid" value="<?php echo $doctid; ?>" id="doctid" />
<table border="0" cellpadding="0" cellspacing="0" align="center">
           <?php 
                 $cnt=0;
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
<script>
$(document).ready(function(){
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