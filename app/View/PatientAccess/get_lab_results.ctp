<?php echo $this->Html->css(array('internal_style.css'));?>
<?php 
if(count($labResult) > 0){
?>
<table width="100%" class="table_format">
      <tr class="row_title">
        <td class="table_cell"><strong><?php echo __("Lab");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Range");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Result");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Unit");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Loinc Code");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Observation Date");?></strong></td>
      </tr>
      <?php 
      $toggle = 0;
      foreach($labResult as $key => $detail){
      ?>
      <?php if($toggle == 0){
      echo "<tr class ='row_gray'>";
      $toggle = 1;
      }else{
echo "<tr>";
$toggle = 0;
}
      ?>
        <td class="row_format"><?php echo $detail['Laboratory']['name'];?></td>
        <td class="row_format"><?php echo $detail['LaboratoryHl7Result']['range'];?></td>
        <td class="row_format"><?php echo $detail['LaboratoryHl7Result']['result'];?></td>
        <td class="row_format"><?php echo $detail['LaboratoryHl7Result']['unit'];?></td>
        <td class="row_format"><?php echo $detail['Laboratory']['lonic_code'];?></td>
        <td class="row_format"><?php echo $detail['LaboratoryHl7Result']['date_time_of_observation'];?></td>
      </tr>
      <?php }?>
      <tr><td><strong>   <?php }else{?>
    
    <?php echo __("No lab results recorded");
}
    ?></strong></td></tr>
    </table>
 