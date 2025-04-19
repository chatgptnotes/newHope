<?php
echo $this->element('Aros/links');
?>

<div class="separator"></div>
<h4 align="center"> This page allows to manage Roles specific rights</h4>
<div class="separator"></div>
<div class="separator"></div>
<div class="separator"></div>
<h4 style="border-bottom:1px solid #4C5E64">Permission on all modules</h4>
<table cellspacing="2">

<tr>
	<th  style="text-align:center;padding:5px;">Role</th>
	<th  style="text-align:center;padding:5px;"><?php echo __d('acl', 'Is all Permission?'); ?></th>

</tr>

<?php
	$i = 0;
	foreach($roles as $role)
	{
		$color = ($i % 2 == 0) ? '' : '#3A5057';
		echo '<tr style="background-color:' . $color . '">';
		echo '  <td  style="text-align:center;padding:5px;">' . $role[$role_model_name][$role_display_field] . '</td>';
		if($role[$role_model_name]['is_all_permssion']=="0"){
		echo '  <td style="text-align:center;padding:5px;">' . $this->Html->link($this->Html->image('/acl/img/design/cross.png' ,array('title'=>"")), '/admin/acl/aros/grant_all_controllers/' . $role[$role_model_name][$role_pk_name], array('escape' => false, 'confirm' => sprintf(__d('acl', "Are you sure you want to grant access to all actions of each controller to the role '%s' ?"), $role[$role_model_name][$role_display_field]))) . '</td>';
		}else{
		echo '  <td style="text-align:center">' . $this->Html->link($this->Html->image('/acl/img/design/tick.png'), '/admin/acl/aros/deny_all_controllers/' . $role[$role_model_name][$role_pk_name], array('escape' => false, 'confirm' => sprintf(__d('acl', "Are you sure you want to deny access to all actions of each controller to the role '%s' ?"), $role[$role_model_name][$role_display_field]))) . '</td>';
		}
		echo '</tr>';
		
		$i++;
	}
	?>
	</table>
	

<div class="separator"></div>
	<h4 style="border-bottom:1px solid #4C5E64">Permission on Individual module</h4>
<div style="margin-top:50px">
<table cellspacing="2">
<tr>
	<td>Select Module:</td>	
	<td>
		<select onchange="getAllAction(this)">
			<option value="" selected=true>----Select Module----</option>
			<?php
			if(isset($actions['app']) && is_array($actions['app'])){
				foreach($actions['app'] as $controller_name => $ctrl_infos){
					if($controller_name!="App")
								echo "<option value='".$controller_name."'>".preg_replace('/(?!^)[[:upper:]][[:lower:]]/', ' $0', preg_replace('/(?!^)[[:upper:]]+/', ' $0', $controller_name))."</option>";
					
					
				}
			}
			?>
		</select>
	</td>
</tr>
</table>
	<iframe id="action-permission-list" src="" onLoad="autoResize('action-permission-list');" frameborder="0"></iframe> 
</div>
<?php
echo $this->element('design/footer');
?>