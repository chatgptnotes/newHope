<form name="userfrm" id="userfrm" action="<?php echo $this->Html->url(array("controller" => "users", "action" => "login", "admin" => true)); ?>" method="post" onSubmit="return Validate(this);" >
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
<tr>
 <td colspan="2" align="center">
  <?php
      echo $this->Session->flash();
      echo $this->Session->flash('auth');
  ?>
 </td>
</tr>
 <tr>
  <td colspan="2" align="center">
   <h2><?php echo __('Login',true); ?></h2>
  </td>
 </tr>
 <tr>
  <td>
   <?php echo __('Username',true); ?>
  </td>
  <td>
    <?php 
      echo $this->Form->input('User.email', array('label'=> false, 'div' => false, 'error' => false));
    ?>
  </td>
 </tr>
 <tr>
  <td>
   <?php echo __('Password',true); ?>
  </td>
  <td>
    <?php 
      echo $this->Form->input('User.password', array('label'=> false, 'div' => false, 'error' => false));
    ?>
  </td>
 </tr>
 <tr>
  <td colspan="2" align="center">
   <input type="submit" value="Submit" class="blueBtn">
  </td>
 </tr>
</table>
</form>