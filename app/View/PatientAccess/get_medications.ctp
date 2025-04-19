<?php 
if(count($get_medication) > 0){
?>
<table width="100%" class="table_format">
      <tr class="row_title">
        <td class="table_cell"><strong><?php echo __("Date");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Name");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Directions");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Quantity");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Prescribed by");?></strong></td>
      </tr>
       <?php 
      $toggle = 0;
      foreach($get_medication as $key => $value){
      ?>
      <?php if($toggle == 0){
      echo "<tr class ='row_gray'>";
      $toggle = 1;
      }else{
echo "<tr>";
$toggle = 0;
}
      ?>
      	<td class="row_format"><?php echo $value['NewCropPrescription']['date_of_prescription'];?></td>
        <td class="row_format"><?php echo $value['NewCropPrescription']['description'];?></td>
        <td class="row_format"><?php echo $value['NewCropPrescription']['route'];?></td>
        <td class="row_format"><?php echo $value['NewCropPrescription']['dose'];?></td>
       <td class="row_format"><?php echo "Mark Udall";?></td>
     
       
      </tr>
      <?php }?>
    </table>
 <tr><td><strong>   <?php }else{?>
    
    <?php echo __("No medications recorded");
}
    ?></strong></td></tr>
    