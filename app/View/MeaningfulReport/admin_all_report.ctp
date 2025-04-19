<style>
table td{ font-size:13px; color:#000;}
</style>
<div class="inner_title">
<h3> &nbsp; <?php echo __('Meaningful Report', true); ?></h3>
</div>
<h3> &nbsp; <?php //echo __('Managerial Indicators', true); ?></h3>
<table border="1" id="managerial" width="50%">
  <tr>
   <td valign="">&nbsp;1</td>
   <td class="tdLabel">&nbsp;<?php echo $this->Html->link('MU Report For EP',array('action'=>'automated_measure_calculation', 'admin'=>true));?></td>
  </tr>
  <tr>
   <td valign="" >&nbsp;2</td>
   <td class="tdLabel">&nbsp;<?php echo $this->Html->link('MU Report For EH',array('action'=>'hospital_automated_measure_calculation', 'admin'=>true));?></td>
  </tr>
  <tr>
   <td valign="">&nbsp;3</td>
   <td class="tdLabel">&nbsp;<?php echo $this->Html->link('PCMH IT Checklist',array('action'=>'pcmh_automated_measure', 'admin'=>true));?></td>
  </tr>
  <tr>
   <td valign="">&nbsp;4</td>
   <td class="tdLabel">&nbsp;<?php echo $this->Html->link('PCMH IT Checklist 2',array('action'=>'pcmh_report', 'admin'=>true));?></td>
  </tr>
</table>
</div>
