<?php 
if(count($get_allergies) > 0){
?>
<table width="100%" class="table_format">
      <tr class="row_title">
        <td class="table_cell"><strong><?php echo __("Name");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Severity");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Reaction");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Active/Inactive");?></strong></td>
        
      </tr>
       <?php 
      $toggle = 0;
      foreach ($get_allergies as  $Val){
      ?>
      <?php if($toggle == 0){
      echo "<tr class ='row_gray'>";
      $toggle = 1;
      }else{
echo "<tr>";
$toggle = 0;
}?>
      	<td class="row_format"><?php echo $Val['NewCropAllergies']['name'];?></td>
        <td class="row_format"><?php echo $Val['NewCropAllergies']['AllergySeverityName'];?></td>
        <td class="row_format"><?php echo $value['NewCropAllergies']['reaction'];?></td>
        <td class="row_format"><?php echo $value['NewCropAllergies']['status'];?></td>
        
     
       
      </tr>
      <?php }?>
      <tr><td colspan="4"><strong><?php }else{?>
    
    <?php echo __("No medications recorded");
}
    ?></strong></td></tr>
    </table>
    