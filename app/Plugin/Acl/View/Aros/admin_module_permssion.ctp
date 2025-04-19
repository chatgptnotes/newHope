<?php
echo $this->Html->script('/acl/js/jquery');
echo $this->Html->script('/acl/js/acl_plugin');
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>


<style>
.roll_header th{
font-size:15px;
width:60px;
}
.all_perm_header th{
font-size:10px;
width:60px;
}
#accordion{
margin:10px;
}
</style>

<div>

	<table border="0" cellpadding="5" cellspacing="2">
	<tr>
    	<?php
    	
    	$column_count = 1;
    	
    	$headers = array(__d('acl', 'action'));
    	 $perm = array("");
    	foreach($roles as $role)
    	{
    	    $headers[] = $role[$role_model_name][$role_display_field];
			 $perm[] = "<a href='#this' onclick='parent.setPermissionOnModule(\"".$controller_name."\",\"".$role[$role_model_name]['id']."\")' style='font-size:10px;'>Grant all</a>";
    	    $column_count++;
    	}
    

    	echo $this->Html->tableHeaders($headers,array('class' => 'roll_header'));
		echo $this->Html->tableHeaders($perm,array('class' => 'all_perm_header'));
    	?>
	</tr>
	
	<?php
	$previous_ctrl_name = '';
	$i = 0;
	
	if(isset($actions['app']) && is_array($actions['app']))
	{
		foreach($actions['app'] as $controller_name => $ctrl_infos)
		{
			if($previous_ctrl_name != $controller_name)
			{
				$previous_ctrl_name = $controller_name;
				
				
			}
		
			foreach($ctrl_infos as $ctrl_info)			
			{	$color = ($i % 2 == 0) ? '#3A5057' : '#000';
				$i++;
	    		echo '<tr bgcolor="'.$color.'">';
	    		
	    		echo '<td>'.$action_desc[$controller_name][$ctrl_info['name']]['label'].' (' . $controller_name . '->' . $ctrl_info['name'] . ')
				<div>'.$action_desc[$controller_name][$ctrl_info['name']]['desc'].'</div>
				</td>';
	    		
		    	foreach($roles as $role)
		    	{
		    	    echo '<td>';
		    	    echo '<span id="right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '">';
	    		
		    	    if(isset($ctrl_info['permissions'][$role[$role_model_name][$role_pk_name]]))
		    	    {
    		    		if($ctrl_info['permissions'][$role[$role_model_name][$role_pk_name]] == 1)
    		    		{
    		    			$this->Js->buffer('register_role_toggle_right(true, "' . $this->Html->url('/') . '", "right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '", "' . $role[$role_model_name][$role_pk_name] . '", "", "' . $controller_name . '", "' . $ctrl_info['name'] . '")');
        		    
    		    			echo $this->Html->image('/acl/img/design/tick.png', array('class' => 'pointer'));
    		    		}
    		    		else
    		    		{
    		    			$this->Js->buffer('register_role_toggle_right(false, "' . $this->Html->url('/') . '", "right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '", "' . $role[$role_model_name][$role_pk_name] . '", "", "' . $controller_name . '", "' . $ctrl_info['name'] . '")');
    		    		    
    		    		    echo $this->Html->image('/acl/img/design/cross.png', array('class' => 'pointer'));
    		    		}
		    	    }
		    	    else
		    	    {
		    	        /*
		    	         * The right of the action for the role is unknown
		    	         */
		    	        echo $this->Html->image('/acl/img/design/important16.png', array('title' => __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.')));
		    	    }
		    		
		    		echo '</span>';
	    	
        	    	echo ' ';
        	    	echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('id' => 'right__' . $role[$role_model_name][$role_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '_spinner', 'style' => 'display:none;'));
            		
        	    	echo '</td>';
		    	}
	    		
		    	echo '</tr>
		    	';
			}
	
		
		}
	}
	?>
	<?php
	if(isset($actions['plugin']) && is_array($actions['plugin']))
	{
	    foreach($actions['plugin'] as $plugin_name => $plugin_ctrler_infos)
    	{
//    	    debug($plugin_name);
//    	    debug($plugin_ctrler_infos);

    	    $color = null;
    	    
    	    echo '<tr class="title"><td colspan="' . $column_count . '">' . __d('acl', 'Plugin') . ' ' . $plugin_name . '</td></tr>';
    	    
    	    $i = 0;
    	    foreach($plugin_ctrler_infos as $plugin_ctrler_name => $plugin_methods)
    	    {
    	        //debug($plugin_ctrler_name);
    	        //echo '<tr style="background-color:#888888;color:#ffffff;"><td colspan="' . $column_count . '">' . $plugin_ctrler_name . '</td></tr>';
    	        
        	    if($previous_ctrl_name != $plugin_ctrler_name)
        		{
        			$previous_ctrl_name = $plugin_ctrler_name;
        			
        			$color = ($i % 2 == 0) ? 'color1' : 'color2';
        		}
    		
        		
    	        foreach($plugin_methods as $method)
    	        {
    	            echo '<tr class="' . $color . '">
    	            ';
    	            
    	            echo '<td>' . $plugin_ctrler_name . '->' . $method['name'] . 'gfhgfhgfhgfh</td>';
    	            //debug($method['name']);
    	            
        	        foreach($roles as $role)
    		    	{
    		    	    echo '<td>';
    		    	    echo '<span id="right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '">';
    		    	    
    		    	    if(isset($ctrl_info['permissions'][$role[$role_model_name][$role_pk_name]]))
    		    	    {
        		    		if($method['permissions'][$role[$role_model_name][$role_pk_name]] == 1)
        		    		{
        		    			//echo '<td>' . $this->Html->link($this->Html->image('/acl/img/design/tick.png'), '/admin/acl/aros/deny_role_permission/' . $role[$role_model_name][$role_pk_name] . '/plugin:' . $plugin_name . '/controller:' . $plugin_ctrler_name . '/action:' . $method['name'], array('escape' => false)) . '</td>';
        		    			
        		    		    $this->Js->buffer('register_role_toggle_right(true, "' . $this->Html->url('/') . '", "right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '", "' . $role[$role_model_name][$role_pk_name] . '", "' . $plugin_name . '", "' . $plugin_ctrler_name . '", "' . $method['name'] . '")');
    		    		    
        		    		    echo $this->Html->image('/acl/img/design/tick.png', array('class' => 'pointer'));
        		    		}
        		    		else
        		    		{
        		    			//echo '<td>' . $this->Html->link($this->Html->image('/acl/img/design/cross.png'), '/admin/acl/aros/grant_role_permission/' . $role[$role_model_name][$role_pk_name] . '/plugin:' . $plugin_name .'/controller:' . $plugin_ctrler_name . '/action:' . $method['name'], array('escape' => false)) . '</td>';
        		    			
        		    		    $this->Js->buffer('register_role_toggle_right(false, "' . $this->Html->url('/') . '", "right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '", "' . $role[$role_model_name][$role_pk_name] . '", "' . $plugin_name . '", "' . $plugin_ctrler_name . '", "' . $method['name'] . '")');
    		    			
        		    		    echo $this->Html->image('/acl/img/design/cross.png', array('class' => 'pointer'));
        		    		}
    		    	    }
    		    	    else
    		    	    {
    		    	        /*
    		    	         * The right of the action for the role is unknown
    		    	         */
    		    	        echo $this->Html->image('/acl/img/design/important16.png', array('title' => __d('acl', 'The ACO node is probably missing. Please try to rebuild the ACOs first.')));
    		    	    }
    		    		
    		    		echo '</span>';
	    	
            	    	echo ' ';
            	    	echo $this->Html->image('/acl/img/ajax/waiting16.gif', array('id' => 'right_' . $plugin_name . '_' . $role[$role_model_name][$role_pk_name] . '_' . $plugin_ctrler_name . '_' . $method['name'] . '_spinner', 'style' => 'display:none;'));
                		
            	    	echo '</td>';
    		    	}
    		    	
    	            echo '</tr>
    	            ';
    	        }
    	        
    	        $i++;
    	    }
    	}
	}
    ?>
	</table>
	<?php
    echo $this->Html->image('/acl/img/design/tick.png') . ' ' . __d('acl', 'authorized');
    echo '&nbsp;&nbsp;&nbsp;';
    echo $this->Html->image('/acl/img/design/cross.png') . ' ' . __d('acl', 'blocked');
    ?>

</div>


<?php
echo $this->element('design/footer');
?>