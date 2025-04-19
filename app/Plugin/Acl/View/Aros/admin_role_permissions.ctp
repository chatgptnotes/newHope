<?php
 echo $this->Html->script(array('jquery.ui.accordion.js'));
echo $this->Html->script('/acl/js/acl_plugin');

?>
<?php
echo $this->element('Aros/links');
?>

<div class="separator"></div>
<h4 align="center"> This page allows to manage Roles specific rights</h4>
<div class="separator"></div>
<div class="separator"></div>
<div class="separator"></div>
<div id="accordion">
<h4 ><a href="#this">Roles Available</a></h4>
<div>
	<table cellspacing="2">
	
	<tr>
		<th  style="text-align:center;padding:5px;">Role</th>
	
	</tr>
	<ul>
	<?php
		$i = 0;
		foreach($roles as $role)
		{
			$color = ($i % 2 == 0) ? '' : '#3A5057';
			echo '<li style="background-color:' . $color . ';padding:5px">';
			echo '  ' . $role[$role_model_name][$role_display_field] . '</li>';
			if($role[$role_model_name]['is_all_permssion']=="0"){
			//echo '  <td style="text-align:center;padding:5px;">' . $this->Html->link($this->Html->image('/acl/img/design/cross.png' ,array('title'=>"")), '/admin/acl/aros/grant_all_controllers/' . $role[$role_model_name][$role_pk_name], array('escape' => false, 'confirm' => sprintf(__d('acl', "Are you sure you want to grant access to all actions of each controller to the role '%s' ?"), $role[$role_model_name][$role_display_field]))) . '</td>';
			}else{
			//echo '  <td style="text-align:center">' . $this->Html->link($this->Html->image('/acl/img/design/tick.png'), '/admin/acl/aros/deny_all_controllers/' . $role[$role_model_name][$role_pk_name], array('escape' => false, 'confirm' => sprintf(__d('acl', "Are you sure you want to deny access to all actions of each controller to the role '%s' ?"), $role[$role_model_name][$role_display_field]))) . '</td>';
			}
			echo '</tr>';
			
			$i++;
		}
		?>
		</table>
	</div>

	<h4 ><a href="#this">Permission on Individual Screen</a></h4>
	<div >
	<table cellspacing="2">
	<tr>
		<td>Select Module:</td>	
		<td>
			<select onchange="getAllAction(this)">
				<option value="" selected=true>----Select Module----</option>
				<?php
				
					foreach($controllers as $key => $val){
					
								echo "<option value='".$val['Aco']['alias']."'>".preg_replace('/(?!^)[[:upper:]][[:lower:]]/', ' $0', preg_replace('/(?!^)[[:upper:]]+/', ' $0', $val['Aco']['alias']))."</option>";
						
					}
				
				?>
			</select>
		</td>
	</tr>
	</table>
	<iframe id="action-permission-list"  onLoad="autoResize('action-permission-list');" frameborder="0"  src="" ></iframe> 
	
	</div>
</div>
<script>
jQuery(document).ready(function(){
$( "#accordion" ).accordion({
				collapsible: true,
				autoHeight: false,				
				navigation: "true"});
});
</script>
<?php
echo $this->element('design/footer');
?>