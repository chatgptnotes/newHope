<div class="inner_title">
<h3>&nbsp; <?php echo __('Geographical Region', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table cellpadding="5px" cellspacing="5px" align="left">
        <tr>
		                <td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/city.jpg', array('alt' => 'Cities')),array("controller" => "cities", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('City',true); ?></p>
				</td>
					<td align="center" valign="top">
                                      <?php echo $this->Html->link($this->Html->image('/img/icons/state.jpg', array('alt' => 'States')),array("controller" => "states", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('State',true); ?></p>
				</td>
				<td align="center" valign="top">
                                      <?php echo $this->Html->link($this->Html->image('/img/icons/country.jpg', array('alt' => 'Countries')),array("controller" => "countries", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Country',true); ?></p>
				</td>
				
        </tr>
        </table>

