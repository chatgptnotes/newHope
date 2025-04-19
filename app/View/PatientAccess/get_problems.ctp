<?php 
if(count($problems) > 0){
?>
<table width="100%" class="table_format">
      <tr class="row_title">
        <td class="table_cell"><strong><?php echo __("Name");?></strong></td>
        <td class="table_cell"><strong><?php echo __("ICD Code");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Start Date");?></strong></td>
        <td class="table_cell"><strong><?php echo __("End Date");?></strong></td>
        <td class="table_cell"><strong><?php echo __("Provider");?></strong></td>
      </tr>
        <?php 
      $toggle = 0;
      foreach($problems as $key => $detail){
      ?>
      <?php if($toggle == 0){
      echo "<tr class ='row_gray'>";
      $toggle = 1;
      }else{
echo "<tr>";
$toggle = 0;
}
      ?>
        <td class="row_format"><?php echo $detail['NoteDiagnosis']['diagnoses_name'];?></td>
        <td class="row_format"><?php echo $detail['NoteDiagnosis']['icd_id'];?></td>
        <td class="row_format"><?php echo $detail['NoteDiagnosis']['start_dt'];?></td>
       <td class="row_format"><?php echo $detail['NoteDiagnosis']['end_dt'];?></td>
        <td class="row_format"><?php echo "Mark Udall";?></td>
       
      </tr>
      <?php }?>
       
      <tr><td><strong>   <?php }else{?>
    
    <?php echo __("No problems recorded");
}
    ?></strong></td></tr>
    </table>
  