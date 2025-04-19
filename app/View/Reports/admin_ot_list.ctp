<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#otlistfrm").validationEngine();
	});
	
</script> 
<div class="inner_title">
  <h3><?php echo __('OT Calendar Report') ?></h3>
  <span><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></span>
 </div>
 <?php echo $this->Form->create('reports', array('action'=>'ot_list','type'=>'post', 'id'=> 'otlistfrm'));?>	
<table border="0"   cellpadding="0" cellspacing="0" width="500px">
  <tr>
   <td align="right">From<font color="red">*</font></td>
   <td  class="row_format">
    <?php 
    	    echo $this->Form->input(null, array('name' => 'from', 'style'=>'width:120px;','id'=>'from', 'value'=> isset($stdfromdate)?date("d/m/Y", strtotime($stdfromdate)):'', 'label'=> false, 'div' => false, 'error' => false,'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd'));
    ?>
   </td>
  </tr>
  <tr>
   <td align="right">To<font color="red">*</font></td>
   <td class="row_format">
    <?php 
       echo $this->Form->input(null, array('name' => 'to',  'style'=>'width:120px;','id'=>'to', 'value'=> isset($stdtodate)?date("d/m/Y", strtotime($stdtodate)):'', 'label'=> false, 'div' => false, 'error' => false, 'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd'));
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
 <div class="inner_title" style="float: right;border:none;">
  <?php 
       //	echo $this->Html->link(__('Cancel'), '/admin/reports/all_report',array('escape' => false,'class'=>'grayBtn')) ;
	//echo $this->Html->link(__('Print'), '#',array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'ot_list', 'report'=> 'print', 'fromdate'=> isset($stdfromdate)?$stdfromdate:'', 'todate'=> isset($stdtodate)?$stdtodate:''))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=500,left=400,top=400');  return false;")) ;
        echo $this->Html->link(__('Generate Excel Report'), array('action' => 'ot_list', 'report'=> 'excel', 'fromdate'=> isset($stdfromdate)?$stdfromdate:'', 'todate'=> isset($stdtodate)?$stdtodate:''), array('escape' => false,'class'=>'blueBtn'));
  ?>
  <div class="clr ht5"></div>
  </div> 
 </div>
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
  <tr>
   <th><?php echo __('Sr.No.') ?></th>
   <th><?php echo __('Date of Reg.') ?></th>
   <th><?php echo __('MRN') ?></th>
   <th><?php echo __('Patient Name') ?></th>
   <th><?php echo __('Start Time') ?></th>
   <th><?php echo __('End Time') ?></th>
   <th><?php echo __('Room No.') ?></th>
   <th><?php echo __('Table No.') ?></th>
   <th><?php echo __('Surgery') ?></th>
   <th><?php echo __('Surgery Type') ?></th>
   <th><?php echo __('Surgeon') ?></th>
   <th><?php echo __('Anaesthetist') ?></th>
   
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $otdata): 
       $cnt++;
  ?>
   <tr>
   <td align="center"><?php echo $cnt; ?></td>
   <td><?php echo $this->DateFormat->formatDate2Local($otdata['Patient']['form_received_on'],Configure::read('date_format'), false); ?></td>
   <td><?php echo $otdata['Patient']['admission_id']; ?></td>
   <td><?php echo $otdata['PatientInitial']['name'].' '.$otdata['Patient']['lookup_name']; ?></td>
   <td><?php echo substr($this->DateFormat->formatDate2Local($otdata['OptAppointment']['starttime'],Configure::read('date_format'), true), 0 , -3); ?></td>
   <td><?php echo substr($this->DateFormat->formatDate2Local($otdata['OptAppointment']['endtime'],Configure::read('date_format'), true), 0, -3); ?></td>
   <td><?php echo $otdata['Opt']['name']; ?></td>
   <td><?php echo $otdata['OptTable']['name']; ?></td>
   <td><?php echo $otdata['Surgery']['name']; ?></td>
   <td><?php echo ucfirst($otdata['OptAppointment']['operation_type']); ?></td>
   <td><?php echo $otdata['Initial']['name'].' '.$otdata['DoctorProfile']['doctor_name']; ?></td>
   <td><?php echo $otdata['InitialAlias']['name'].' '.$otdata['Doctor']['first_name'].' '.$otdata['Doctor']['middle_name'].' '.$otdata['Doctor']['last_name']; ?></td>
  </tr>
  <?php 
       endforeach;
      } else {
  ?>
  <tr>
   <td colspan="12" align="center"><?php echo __('No Record Found', true); ?>.</td>
  </tr>
  <?php
      }
  ?>
 </table>
 <div class="clr ht5"></div>
 
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
									dateFormat:'<?php echo $this->General->GeneralDate();?>',
									onSelect : function() {
										$(this).focus();
										//foramtEnddate(); //is not defined hence commented
									}
							});
                                                        $( "#to" ).datepicker({
									showOn: "button",
									buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly: true,
									changeMonth: true,
									changeYear: true,
									changeTime:true,
									showTime: true,  		
									dateFormat:'<?php echo $this->General->GeneralDate();?>',
									onSelect : function() {
										$(this).focus();
										//foramtEnddate(); //is not defined hence commented
									}
							});	                                                    
   });             
</script>
		 