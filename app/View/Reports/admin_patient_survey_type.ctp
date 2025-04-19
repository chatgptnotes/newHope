<div class="inner_title">
<h3> &nbsp; <?php echo __('Patient Survey Report', true); ?></h3>
<span><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="10" align="right">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_format">
  <tr>
   <td  align="right">
    <?php 
     echo $this->Html->link(__('IPD Patient Report', true),array('controller' => 'reports','action' => 'patientsurvey_reports'), array('escape' => false,'class'=>'blueBtn'));
     echo $this->Html->link(__('OPD Patient Report', true),array('controller' => 'reports','action' => 'opdpatientsurvey_reports'), array('escape' => false,'class'=>'blueBtn'));
    ?>
    </td>
  </tr>
 
</table>
  </td>
  </tr>
  </table>