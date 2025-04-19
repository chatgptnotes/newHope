 <div id="mast">
 <?php echo $session->read('Auth.User.first_name'); ?>
  <?php echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?>
  </div>
