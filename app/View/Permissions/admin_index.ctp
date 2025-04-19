<style>
.frontMenu li a{
    background-color: #3C484C;
    border: 1px solid #46565B;
    color: #E7EEEF;
    display: block;
    font-size: 15px;
    font-weight: bold;
    padding: 5px 10px;
    text-decoration: none;
    text-shadow: 1px 1px 1px #000000;
}
</style>
<div class="inner_title">
<h3><?php echo __('Permission Management', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),"/", array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<div id="acos_link" class="frontMenu">
<ul>
   <li>
  <?php 
   		echo $this->Html->link("Role Permission", array('action' => 'role_permission', "admin"=>true), array('escape' => false,'title' => 'Role Permission', 'alt'=>'Role Permission') );
   
   ?>
   </li>
     <li>
  <?php 
   		echo $this->Html->link("User Permission", array('action' => 'user_permission', "admin"=>true), array('escape' => false,'title' => 'User Permission', 'alt'=>'User Permission') );
   
   ?>
   </li>
 <li>
  <?php 
   		echo $this->Html->link("Package Permission", array('action' => 'package_permission', "admin"=>true), array('escape' => false,'title' => 'Package Permission', 'alt'=>'Package Permission') );
   
   ?>
   </li>
  </ul>
</div>