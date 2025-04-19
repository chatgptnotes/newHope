<?php
echo $this->Html->script('/acl/js/jquery');
echo $this->Html->script('/acl/js/acl_plugin');
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));

?>

   
    <table border="0" cellpadding="5" cellspacing="2">
	<tr>
    	<?php

    	$column_count = 1;

    	$headers = array(__d('acl', 'action'), __d('acl', 'authorization'));

    	echo $this->Html->tableHeaders($headers);
    	?>
	</tr>

	<?php
	$js_init_done = array();
	$previous_ctrl_name = '';
	
	foreach($actions['app'] as $controller_name => $ctrl_infos)
	{
		if($previous_ctrl_name != $controller_name)
		{
			$previous_ctrl_name = $controller_name;

			$color = (isset($color) && $color == 'color1') ? 'color2' : 'color1';
		}

		foreach($ctrl_infos as $ctrl_info)
		{
    		echo '<tr class="' . $color . '">
    		';

    		echo '<td>'.$action_desc[$controller_name][$ctrl_info['name']]['label'].' (' . $controller_name . '->' . $ctrl_info['name'] . ')
				<div>'.$action_desc[$controller_name][$ctrl_info['name']]['desc'].'</div>
			</td>';
	    	echo '<td>';
	    	echo '<span id="right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '">';

	    	/*
			* The right of the action for the role must still be loaded
	    	*/
	        echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('title' => __d('acl', 'loading')));

		    if(!in_array($controller_name . '_' . $user[$user_model_name][$user_pk_name], $js_init_done))
	        {
	        	$js_init_done[] = $controller_name . '_' . $user[$user_model_name][$user_pk_name];
	        	$this->Js->buffer('init_register_user_controller_toggle_right("' . $this->Html->url('/', true) . '", "' . $user[$user_model_name][$user_pk_name] . '", "", "' . $controller_name . '", "' . __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.') . '");');
	        }
	        
	    	echo '</span>';

	    	echo ' ';
	    	echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('id' => 'right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '_spinner', 'style' => 'display:none;'));

	    	echo '</td>';
	    	echo '</tr>
	    	';
		}
	}
	?>
		</table>
   
<?php
echo $this->element('design/footer');
?>