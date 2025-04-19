<style>
.row_action img{
float:inherit;
}
</style>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
<h3><?php echo __('RGJAY Package'); ?></h3>			
 <span><?php 
 echo $this->Html->link(__(' Add '),array('action' => 'rgjay_add'),array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Back', true),array('controller' =>'Misc', 'action' =>'index'), array('escape' => false,'class'=>'blueBtn'));
  ?></span>

</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">

  </td>
  
  </tr>
  <tr class="row_title">
   <td  width="30%" class="table_cell"><strong><?php echo __('RGJAY Package', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Category', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __(' Required Documents', true); ?></strong></td>
    <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
  	  $cnt =0;
      if(count($result) > 0) {//debug($result);
       foreach($result as $val): 
        $cnt++;
  ?>
   <tr class="row_gray"; >
   <td class="row_format"><?php echo $val['TariffList']['name']; ?></td>
   
   <td class="row_format"><?php echo $val['RgjayPackageMaster']['category']; ?></td>
    
 <!--   <td class="row_format"><?php echo ucwords($val['RgjayPackageMaster']['category']); ?> </td> -->
   <td class="row_format"><?php echo ucwords($val['RgjayPackageMaster']['documents']); ?> </td>   
   <td class="row_action">
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'rgjay_add', $val['RgjayPackageMaster']['id']), array('escape' => false));
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'rgjay_delete', $val['RgjayPackageMaster']['id']), array('escape' => false),__('Are you sure?', true));
   
   ?></td>
  </tr>
  <?php endforeach;  ?>
  
  <?php }?>
 </table>
