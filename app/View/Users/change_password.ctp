<div class="inner_title">
<h3><?php echo __('Change Password', true); ?></h3>
<span>
<?php 
		echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout'),array('escape'=>false,'class'=>'blueBtn'));
	?>
</span>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#userfrm").validationEngine();
	});
	
</script>
<form name="userfrm" id="userfrm" action="<?php echo $this->Html->url(array("controller" => "users", "action" => "change_password")); ?>" method="post" autocomplete="off">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	 <td class="form_lables" align="right">
	  <?php echo __('Username',true); ?><font color="red">*</font>
	 </td>
	 <td>
	 <?php 
	   echo $this->Form->input('User.username', array('value'=> AuthComponent::user('username'),'id' => 'customusername', 'label'=> false, 'div' => false, 'error' => false,'class'=>'validate[required,custom[mandatory-enter]]'));
	 ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Current Password',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.password', array('autocomplete'=>'off','class' => 'validate[required,custom[passrequired]]', 'id' => 'passrequired', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('New Password',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('User.newpassword', array('type'=> 'password', 'class' => 'validate[required,custom[passwordOnly]]', 'id' => 'password', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
        
       
        ?>
        <br /><span style="float:left;"><i>(Allowed special characters : !*@#$%^&+=~`_-)</i></span>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Confirm Password',true); ?><font color="red">*</font>
	</td>
	<td>
         <input class="validate[required,custom[newpassrequired]] text-input" type="password" name="password2" id="password2" onkeyup='getChecked(this.value);' style="float:left;"/>
         <?php 
            echo $this->Html->image('icons/cross.png',array('id'=>'incorrect','style'=>'display:none;'));
         	echo $this->Html->image('icons/tick.png',array('id'=>'correct','style'=>'display:none;'));
         ?>
        </td>
	</tr>     
        <tr>
	<td colspan="2" align="center">
        &nbsp;
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center">
	<input type="submit" value="Submit" class="blueBtn">
	
	</td>
	</tr>
	</table>
</form>
<script>
// Function to check that passwords are matching or not
function getChecked(confirm){
	var password = $("#password").val();
	
  if(confirm != ''){
	if(password != confirm){
		$("#incorrect").show();
		$("#correct").hide();
	} else {
		$("#incorrect").hide();
		$("#correct").show();
	}
  } else {		
	$("#incorrect").hide();
	$("#correct").hide();
  }
}
</script>