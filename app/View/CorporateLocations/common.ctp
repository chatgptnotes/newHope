<div class="inner_title">
<h3> &nbsp; <?php echo __('Corporate & Insurance Management', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="10" align="right">
  <?php 
    echo $this->element('corporate');
   ?>
  </td>
  </tr>
  </table>