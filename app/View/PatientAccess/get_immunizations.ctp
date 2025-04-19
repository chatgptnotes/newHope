<?php 
if(count($immunization_details) > 0){
?>
<table width="100%" class="table_format">
      <tr class="row_title">
        <td class="table_cell"><strong><?php echo __("Immunization Administration");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Amount");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Unit");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Vaccine");?></strong></td>
       <td class="table_cell"><strong><?php echo __("Date");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Manufacturer");?></strong></td>
      </tr>
      <?php 
      $toggle = 0;
      foreach ($immunization_details as  $details){
      ?>
   <?php if($toggle == 0){
      echo "<tr class ='row_gray'>";
      $toggle = 1;
      }else{
echo "<tr>";
$toggle = 0;
}?>
       <td class="row_format"><?php echo $details['Imunization']['cpt_description'];?></td>
        <td class="row_format"><?php echo $details['Immunization']['amount'];?></td>
        <td class="row_format"><?php echo $details['PhvsMeasureOfUnit']['value_code'];?></td>
        <td class="row_format"><?php echo $details['PhvsVaccinesMvx']['vaccine_type'];?></td>
       <td class="row_format"><?php echo $details['Immunization']['presented_date'];?></td>
        <td class="row_format"><?php echo $details['PhvsVaccinesMvx']['description'];?></td>
      </tr>
      <?php }?>
   
      <tr><td><strong>   <?php }else{?>
    
    <?php echo __("No immunization  recorded");
}
    ?></strong></td></tr>
    </table>
   