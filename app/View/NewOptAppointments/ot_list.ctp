<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#otlistfrm").validationEngine();
	});
	
</script> 
<div class="inner_title">
  <h3><?php echo __('OT List') ?></h3>
 </div>
 <?php echo $this->Form->create('OptAppointments', array('action'=>'ot_list','type'=>'post', 'id'=> 'otlistfrm'));?>	
<table border="0"   cellpadding="0" cellspacing="0" width="500px">
  <tr>
   <td align="right">From<font color="red">*</font></td>
   <td  class="row_format">
    <?php 
    	    echo $this->Form->input(null, array('name' => 'from', 'id'=>'from', 'value'=> isset($stdfromdate)?date("d/m/Y", strtotime($stdfromdate)):'', 'label'=> false, 'div' => false, 'error' => false, 'class' => 'validate[required,custom[mandatory-enter-only]]'));
    ?>
   </td>
  </tr>
  <tr>
   <td align="right">To<font color="red">*</font></td>
   <td class="row_format">
    <?php 
       echo $this->Form->input(null, array('name' => 'to', 'id'=>'to', 'value'=> isset($stdtodate)?date("d/m/Y", strtotime($stdtodate)):'', 'label'=> false, 'div' => false, 'error' => false, 'class' => 'validate[required,custom[mandatory-enter-only]]'));
    ?>
   </td>
  </tr>
  <tr>				 
   <td class="row_format" align="left" colspan="2" style="padding-left:70px;">
    <?php
	echo $this->Form->submit(__('Show Report'),array('class'=>'blueBtn','div'=>false,'label'=>false, 'id'=> 'showreport'));	
    ?>
   </td>
  </tr>	
</table>	
 <?php echo $this->Form->end();?>
 <div class="clr ht5"></div>  
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
  <tr>
   <th width="60"><?php echo __('Sr. No.') ?></th>
   <th width="40"><?php echo __('Time') ?></th>
   <th width="75"><?php echo __('Room No.') ?></th>
   <th width="130"><?php echo __('Table No.') ?></th>
   <th width="150"><?php echo __('Name of Patient') ?></th>
   <th width="150"><?php echo __('Diagnosis') ?></th>
   <th width="150"><?php echo __('Surgery') ?></th>
   <th width="80"><?php echo __('Major/Minor') ?></th>
   <th width="170"><?php echo __('Surgeon') ?></th>
   <th width="170"><?php echo __('Anesthetist') ?></th>
   <th width="170"><?php echo __('Anaesthesia') ?></th>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $otdata): 
       $cnt++;
  ?>
   <tr>
   <td><?php echo $cnt; ?></td>
   <td><?php echo $otdata['OptAppointment']['start_time']; ?></td>
   <td><?php echo $otdata['Opt']['name']; ?></td>
   <td><?php echo $otdata['OptTable']['name']; ?></td>
   <td><?php echo $otdata['Patient']['lookup_name']; ?></td>
   <td><?php echo $otdata['OptAppointment']['diagnosis']; ?></td>
   <td><?php echo $otdata['Surgery']['name']; ?></td>
   <td><?php echo $otdata['OptAppointment']['operation_type']; ?></td>
   <td><?php echo $otdata['DoctorProfile']['doctor_name']; ?></td>
  <td><?php echo $otdata['Doctor']['full_name']; ?></td>
   <td><?php echo $otdata['OptAppointment']['anaesthesia']; ?></td>
  </tr>
  <?php 
       endforeach;
      } else {
  ?>
  <tr>
   <td colspan="11" align="center"><?php echo __('No record found', true); ?>.</td>
  </tr>
  <?php
      }
  ?>
 </table>
 <div class="clr ht5"></div>
 <div class="btns">
  <?php 
       	echo $this->Html->link(__('Cancel'), '/admin/reports/all_report',array('escape' => false,'class'=>'grayBtn')) ;
	echo $this->Html->link(__('Print'), '#',array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'opt_appointments','action'=>'ot_list', 'report'=> 'print', 'fromdate'=> isset($stdfromdate)?$stdfromdate:'', 'todate'=> isset($stdtodate)?$stdtodate:''))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=500,left=400,top=400');  return false;")) ;
        echo $this->Html->link(__('Generate Excel Report'), array('controller'=>'opt_appointments', 'action' => 'ot_list', 'report'=> 'excel', 'fromdate'=> isset($stdfromdate)?$stdfromdate:'', 'todate'=> isset($stdtodate)?$stdtodate:''), array('escape' => false,'class'=>'blueBtn'));
  ?>
 </div>
<script>
jQuery(document).ready(function(){
			       	                       $( "#from" ).datepicker({
									showOn: "button",
									buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly: true,
									changeMonth: true,
									changeYear: true,
									changeTime:true,
									showTime: true,  		
									dateFormat:'<?php echo $this->General->GeneralDate();?>'
							});
                                                        $( "#to" ).datepicker({
									showOn: "button",
									buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly: true,
									changeMonth: true,
									changeYear: true,
									changeTime:true,
									showTime: true,  		
									dateFormat:'<?php echo $this->General->GeneralDate();?>'
							});	
                                                        $( "#showreport" ).click(function(){
                                                                        var fromdate_split = $( "#from" ).val().split("/");
                                                                        var todate_split = $( "#to" ).val().split("/");
								        var fromdate = new Date(fromdate_split[2], fromdate_split[1], fromdate_split[0]);
                                                                        var todate = new Date(todate_split[2], todate_split[1], todate_split[0]);
                                                                        if(fromdate > todate) {
                                                                         alert("To date should be greater than from date");
                                                                         return false;
                                                                        }
                                                                        
							});	
		        
                       
   });
</script>
		 