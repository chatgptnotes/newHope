<script	src="http://code.jquery.com/ui/1.8.16/jquery-ui.js"></script>
<div class="LabTherapyHead">Labs</div>
<ul id="accordianLab" class="connectedSortable">
	<li id="none" class="">&nbsp;</li>
	
	<?php 
		$cntLabStatus=0;
		if(count($getLabsStatusList) > 0) { 
		      foreach($getLabsStatusList as $getLabsStatusListVal) {
		      	 $cntLabStatus++;
		      	 
	?>
	<?php if($cntLabStatus == 1) { ?>
		<li id="labs" class="">
		<h3 class="expand"><?php echo $getLabsStatusListVal['TestGroup']['name']; ?></h3>
		<div class="inner_leftinner collapse ui-accordion">
		<div class="inner_first1"></div>
		<div>
		<table width="100%" class="table_format" cellpadding="0" cellspacing="0">
	<?php } ?>
	<?php if($getLabsStatusListVal['TestGroup']['name'] != $lastVal && $cntLabStatus != 1) { ?>
	       </table>
	      </div>
	     </div>
	    </li>
		<li id="labs" class="">
		<h3 class="expand"><?php echo $getLabsStatusListVal['TestGroup']['name']; ?></h3>
		<div class="inner_leftinner collapse ui-accordion">
		<div class="inner_first1"></div>
		<div>
		<table width="100%" class="table_format" cellpadding="0" cellspacing="0">
	<?php } ?>		
		<tr <?php if($getLabsStatusListVal['TestGroup']['name'] != $lastVal) { echo "class='row_title'"; } else { if($cntLabStatus%2 == 0) echo "class='row_gray'";  }?>>
				<td <?php if($getLabsStatusListVal['TestGroup']['name'] != $lastVal)  echo "class='table_cell'"; ?> ><?php echo $getLabsStatusListVal['Laboratory']['name']; ?></td>
				<td <?php if($getLabsStatusListVal['TestGroup']['name'] != $lastVal)  echo "class='table_cell'"; ?> ><?php echo $getLabsStatusListVal['LaboratoryHl7Result']['result']; ?></td>
				<td <?php if($getLabsStatusListVal['TestGroup']['name'] != $lastVal)  echo "class='table_cell'"; ?> ><?php echo $getLabsStatusListVal['LaboratoryHl7Result']['sn_result2']; ?></td>
			</tr>
	
 <?php 
        $lastVal = $getLabsStatusListVal['TestGroup']['name'];
		      } 
       } else { 
 ?>
   <li><div style="text-align:center;"><?php echo __('No Record Found'); ?></div></li>
 <?php } ?>
    </table>
   </div>
  </div>
 </li>
