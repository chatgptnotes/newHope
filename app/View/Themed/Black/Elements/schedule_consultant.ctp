<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_format">
  <tr>
   <td  align="right">
    <?php 
        
   	 echo $this->Html->link(__('Consultant Listing', true),array('action' => 'index', 'plugins' => false, 'admin' => false, 'superadmin' => false), array('escape' => false,'class'=>'blueBtn'));
        echo $this->Html->link(__('Scheduled Consultant Listing', true),array('action' => 'scheduled_consultant', 'plugins' => false, 'admin' => false, 'superadmin' => false), array('escape' => false,'class'=>'blueBtn'));
        
         
    ?>
    </td>
  </tr>
</table>