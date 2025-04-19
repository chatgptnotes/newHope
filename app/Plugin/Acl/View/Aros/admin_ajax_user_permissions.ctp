<?php
echo $this->Html->script('/acl/js/jquery');
echo $this->Html->script('/acl/js/acl_plugin');

?>

<?php
echo $this->element('Aros/links');
?>
<br>
   
    <h3 style="border-bottom:1px solid #4C5E64"><?php echo __d('acl', 'Permissions'); ?> for <?php echo  __d('acl', 'User ') . ' : ' . $user[$user_model_name][$user_display_field]; ?></h3>

	
   <div style="margin-top:25px">
<table cellspacing="2">
<tr>
	<td>Select Module:</td>	
	<td>
		<select onchange="getAllActionWithUserPermission(this,<?php echo $user['User']['id'];?>,'<?php echo $a_path;?>')">
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
	<iframe id="action-permission-list" src=""  onLoad="autoResize('action-permission-list');" frameborder="0" ></iframe> 
</div>
