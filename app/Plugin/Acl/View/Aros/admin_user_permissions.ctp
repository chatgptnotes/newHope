<?php
echo $this->Html->script('/acl/js/jquery');
echo $this->Html->script('/acl/js/acl_plugin');

?>
<?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');
  
?>
<?php
echo $this->element('Aros/links');
?>

<?php
if(isset($users))
{
?>
<div class="separator"></div>
<h4 align="center"> This page allows to manage users specific rights</h4>
<br>
<form action="<?php echo $this->Html->url(array("controller" => "acl/aros", "action" => "user_permissions","admin" => true,"plugin"=>false)); ?>" >

	Search User by Name: <input type="text" id="username" name="username"> <input type="submit" value="filter"></form>
	<br>
    <table border="0" cellpadding="5" cellspacing="2" <?php if(count($users) < 1){echo "style='width:100%;'";} ?>>
    <tr>
    	<?php
    	$column_count = 1;
    	
    	//$headers = array($this->Paginator->sort(__d('acl', 'user'), $user_display_field));
    	
//    	echo $this->Html->tableHeaders($headers);
    	?>
		 </tr>
	
   
    <?php
	$i=0;
    if(count($users) >0) {?>
		<tr>
	<th  style="text-align:center;padding:5px;">User name</th>
	<th  style="text-align:center;padding:5px;"><?php echo __d('acl', 'Permission'); ?></th>
</tr>
	<?php	
	foreach($users as $user)
	{
			$color = ($i % 2 == 0) ? '' : '#3A5057';
		echo '<tr style="background-color:' . $color . '">';
		echo '  <td>' . $user[$user_model_name][$user_display_field] . '</td>';
		$title = __d('acl', 'Manage user specific rights');
	
		$link = '/admin/acl/aros/user_permissions/' . $user[$user_model_name][$user_pk_name];
		if(Configure :: read('acl.gui.users_permissions.ajax') === true)
		{
		$link .= '/ajax:true';
		}
		
		echo '  <td>' . $this->Html->link($this->Html->image('/acl/img/design/lock.png'), $link, array('alt' => $title, 'title' => $title, 'escape' => false)) . '</td>';
	
		echo '</tr>';
			$i++;
	}
    } else {
       echo '<tr>';
       echo '  <th colspan="2" align="center" >No Record Found.</th>';
       echo '</tr>';
    }
    ?>
    <tr>
    	<td class="paging" colspan="<?php echo $column_count ?>">
    		<?php echo $this->Paginator->numbers(); ?>
    	</td>
    </tr>
    </table>
<?php
}
else
{
?>
    <h1><?php echo  __d('acl', $user_model_name) . ' : ' . $user[$user_model_name][$user_display_field]; ?></h1>
    
    <h2><?php echo __d('acl', 'Role'); ?></h2>
    
    <table border="0">
    <tr>
    	<?php
    	foreach($roles as $role)
    	{
    	    echo '<td>';
    	    
    	    echo $role[$role_model_name][$role_display_field];
    	    if($role[$role_model_name][$role_pk_name] == $user[$user_model_name][$role_fk_name])
    	    {
    	        echo $this->Html->image('/acl/img/design/tick.png');
    	    }
    	    else
    	    {
    	    	$title = __d('acl', 'Update the user role');
    	        echo $this->Html->link($this->Html->image('/acl/img/design/tick_disabled.png'), array('plugin' => 'acl', 'controller' => 'aros', 'action' => 'update_user_role', 'user' => $user[$user_model_name][$user_pk_name], 'role' => $role[$role_model_name][$role_pk_name]), array('title' => $title, 'alt' => $title, 'escape' => false));
    	    }
    	    
    	    echo '</td>';
    	}
    	?>
    </tr>
    </table>
    
    <h2><?php echo __d('acl', 'Permissions'); ?></h2>
    
    <?php
	if($user_has_specific_permissions)
	{
	    echo '<div class="separator"></div>';
    	echo $this->Html->image('/acl/img/design/bulb24.png') . __d('acl', 'This user has specific permissions');
    	echo ' (';
    	echo $this->Html->link($this->Html->image('/acl/img/design/cross2.png') . ' ' . __d('acl', 'Clear'), '/admin/acl/aros/clear_user_specific_permissions/' . $user[$user_model_name][$user_pk_name], array('confirm' => __d('acl', 'Are you sure you want to clear the permissions specific to this user ?'), 'escape' => false));
    	echo ')';
    	echo '<div class="separator"></div>';
	}
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
	$previous_ctrl_name = '';
	
	//debug($actions);
	
	foreach($actions['app'] as $controller_name => $ctrl_infos)
	{
		if($previous_ctrl_name != $controller_name)
		{
			$previous_ctrl_name = $controller_name;
			
			$color = (isset($color) && $color == 'color1') ? 'color2' : 'color1';
		}
		
		foreach($ctrl_infos as $ctrl_info)
		{
			//debug($ctrl_info);
			
    		echo '<tr class="' . $color . '">
    		';
    		
    		echo '<td>' . $controller_name . '->' . $ctrl_info['name'] . '</td>';
    		
	    	echo '<td>';
	    	echo '<span id="right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '">';
        			
    		if($ctrl_info['permissions'][$user[$user_model_name][$user_pk_name]] == 1)
    		{
    		    $this->Js->buffer('register_user_toggle_right(true, "' . $this->Html->url('/') . '", "right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '", "' . $user[$user_model_name][$user_pk_name] . '", "", "' . $controller_name . '", "' . $ctrl_info['name'] . '")');
    		    
    		    echo $this->Html->image('/acl/img/design/tick.png', array('class' => 'pointer'));
    		}
    		elseif($ctrl_info['permissions'][$user[$user_model_name][$user_pk_name]] == 0)
    		{
    		    $this->Js->buffer('register_user_toggle_right(false, "' . $this->Html->url('/') . '", "right__' . $user[$user_model_name][$user_pk_name] . '_' . $controller_name . '_' . $ctrl_info['name'] . '", "' . $user[$user_model_name][$user_pk_name] . '", "", "' . $controller_name . '", "' . $ctrl_info['name'] . '")');
    		    
    			echo $this->Html->image('/acl/img/design/cross.png', array('class' => 'pointer'));
    		}
    		elseif($ctrl_info['permissions'][$user[$user_model_name][$user_pk_name]] == -1)
    		{
    		    echo $this->Html->image('/acl/img/design/important16.png');
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
    echo $this->Html->image('/acl/img/design/tick.png') . ' ' . __d('acl', 'authorized');
    echo '&nbsp;&nbsp;&nbsp;';
    echo $this->Html->image('/acl/img/design/cross.png') . ' ' . __d('acl', 'blocked');
    ?>
<?php
}
?>
<?php
echo $this->element('design/footer');
?>
 <script>
$('#username').live('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","User","username", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,
			
				autoFill:true
			}
		);

	}
		);
		
		</script>