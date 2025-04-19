<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_format">
  <tr>
   <td  align="right">
    <?php 
        if($this->Session->read('role') == 'admin') {
   	 echo $this->Html->link(__('Doctor Listing', true),array('action' => 'index', 'plugins' => false, 'admin' => false, 'superadmin' => false), array('escape' => false,'class'=>'blueBtn'));
        echo $this->Html->link(__('Scheduled Doctor Listing', true),array('action' => 'scheduled_doctor', 'plugins' => false, 'admin' => false, 'superadmin' => false), array('escape' => false,'class'=>'blueBtn'));
        }
        if($this->Session->read('role') == 'doctor' || $this->Session->read('role') == 'Doctor') {
   	 echo $this->Html->link(__('Add Schedule', true),array('action' => 'doctor_schedule', 'plugins' => false, 'admin' => false, 'superadmin' => false, $doctid), array('escape' => false,'class'=>'blueBtn'));
        } 
    ?>
    </td>
  </tr>
</table>