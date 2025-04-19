<script	src="http://code.jquery.com/ui/1.8.16/jquery-ui.js"></script>
<div class="LabTherapyHead">Respiratory Therapy (6 hr)</div>
<ul id="accordianTherapy" class="connectedSortable">
<li id="none1" class="">&nbsp;</li>
<?php
$cntRespiratoryStatus=0;
if(count($getRespiratoryStatusList) > 0) {
	foreach($getRespiratoryStatusList as $getRespiratoryStatusListVal) {
		$cntRespiratoryStatus++;
		if($cntRespiratoryStatus == 1) {
			?>
	
	<li id="respiratory" class="">
	<h3 class="expand"><?php echo $getRespiratoryStatusListVal['ReviewSubCategory']['name']; ?></h3>
	<div class="inner_leftinner collapse ui-accordion">
	<div class="inner_first1"></div>
	<div>
	<table width="100%" class="table_format" cellpadding="0" cellspacing="0">
		<?php } ?>
		<?php if($getRespiratoryStatusListVal['ReviewSubCategory']['name'] != $lastVal && $cntRespiratoryStatus != 1) { ?>
	</table>
	</div>
	</div>
	</li>
	<li id="respiratory" class="">
	<h3 class="expand"><?php echo $getRespiratoryStatusListVal['ReviewSubCategory']['name']; ?></h3>
	<div class="inner_leftinner collapse ui-accordion">
	<div class="inner_first1"></div>
	<div>
	<table width="100%" class="table_format" cellpadding="0"
		cellspacing="0">
		<?php } ?>
		<tr
		<?php if($getRespiratoryStatusListVal['ReviewSubCategory']['name'] != $lastVal) { echo "class='row_title'"; } else { if($cntRespiratoryStatus == 0) echo "class='row_gray'";  }?>>
			<td
			<?php if($getRespiratoryStatusListVal['ReviewSubCategory']['name'] != $lastVal)  echo "class='table_cell'"; ?>><?php echo $getRespiratoryStatusListVal['ReviewSubCategory']['name']; ?></td>
			<td
			<?php if($getRespiratoryStatusListVal['ReviewSubCategory']['name'] != $lastVal)  echo "class='table_cell'"; ?>><?php echo $getRespiratoryStatusListVal['ReviewSubCategoriesOption']['name']; ?></td>
			<td
			<?php if($getRespiratoryStatusListVal['ReviewSubCategory']['name'] != $lastVal)  echo "class='table_cell'"; ?>><?php echo $getRespiratoryStatusListVal['ReviewPatientDetail']['values']; ?></td>
		</tr>
		<?php
		$lastVal = $getRespiratoryStatusListVal['ReviewSubCategory']['name'];
	}
} else {
	?>
		<li>
		 <div style="text-align: center;"><?php echo __('No Record Found'); ?></div>
		</li>
		<?php } ?>
	</table>
	</div>
	</div>
	</li>
</ul>
