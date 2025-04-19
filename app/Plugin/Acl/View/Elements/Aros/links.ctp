<style>
.frontMenu{margin:0; padding:0; list-style-type:none;}
.frontMenu li{margin:0 0 5px 0;}
.frontMenu li a{display:block; color:#e7eeef; font-size:15px; font-weight:bold; background-color:#3c484c; border:1px solid #46565b; text-shadow:1px 1px 1px #000000; padding:5px 10px; text-decoration:none;}
.frontMenu li a:hover{background-color:#46565b; color:#ffffff;}
</style>
<div id="aros_link" class="frontMenu">
<?php
$selected = isset($selected) ? $selected : $this->params['action'];

$links = array();
/*$links[] = $this->Html->link(__d('acl', 'Build missing AROs'), '/admin/acl/aros/check', array('class' => ($selected == 'admin_check' )? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'Users roles'), '/admin/acl/aros/users', array('class' => ($selected == 'admin_users' )? 'selected' : null));*/

if(Configure :: read('acl.gui.roles_permissions.ajax') === true)
{
    $links[] = $this->Html->link(__d('acl', 'Roles permissions'), '/admin/acl/aros/role_permissions', array('class' => ($selected == 'admin_role_permissions' || $selected == 'admin_ajax_role_permissions' )? 'selected' : null));
}
else
{
    $links[] = $this->Html->link(__d('acl', 'Roles permissions'), '/admin/acl/aros/role_permissions', array('class' => ($selected == 'admin_role_permissions' || $selected == 'admin_ajax_role_permissions' )? 'selected' : null));
}
$links[] = $this->Html->link(__d('acl', 'Users permissions'), '/admin/acl/aros/user_permissions', array('class' => ($selected == 'admin_user_permissions' )? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'Manage Label and Description'), '/admin/acl/acos/user_freindly_name', array('class' => ($selected == 'user_freindly_name' )? 'selected' : null));
echo $this->Html->nestedList($links, array('class' => 'acl_links'));
?>
</div>