<div class="inner_title">
<h3> &nbsp; <?php echo __('In-House & External Doctor', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="10" align="right">
  <table cellpadding="5px" cellspacing="5px" align="left">
        <tr>
                                <td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/treating-consultant.jpg', array('alt' => 'Treating Consultant', 'title' => 'Treating Consultant')),array("controller" => "doctors", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __(Configure::read('doctor'),true); ?></p>
				</td>
		                <td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/external-consultant.jpg', array('alt' => 'External Consultant', 'title' => 'External Consultant')),array("controller" => "consultants", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('External Consultant',true); ?></p>
				</td>
				
                                
				
        </tr>
        </table>
  </td>
  </tr>
  </table>