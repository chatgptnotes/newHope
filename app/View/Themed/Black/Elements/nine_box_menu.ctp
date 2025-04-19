<div id="menu_template" style="display: none">
 <div class="arrow_div">
 
   <?php  echo $this->Html->image('icons/white_arrow.png');?>
    
 </div>
   <!-- inner_wrapper start -->
<?php $this->Navigation->getMenu('box');?>
      
 <!-- inner_wrapper close -->
 <div class="clear"></div>
<!--  <div id="menu_footer">
   <a href="#">More</a>
 </div> -->
</div>