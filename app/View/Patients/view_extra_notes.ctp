<style>
.container {
	border: 1px solid #4C5E64;
	padding-left: 5px;
}

.title {
	background: none repeat scroll 0 0 #4C5E64;
}

.comman {
	margin-top: 10px;
	border-bottom: 1px solid #4C5E64;
}

li {
	list-style: none;
}

* {
	margin: 0px;
	padding: 0px;
}

.cc_ul {
	height: 25px;
}

.cc_ul li {
	float: left;
	list-style: none;
	margin-left: 20px;
}

.cc_l1 {
	background: #363F42;
}

.health_stats {
	margin-left: 20px;
}

.health_stats ul {
	margin-left: 20px;
	border: 1px solid #4C5E64;
	border-right: none;
	margin-bottom: 10px;
}

.health_stats ul li {
	margin-bottom: 5px;
	margin-top: 5px;
}

.ros_li1 {
	float: left;
	margin-left: 10px;
	width: 170px;
}

.ros_li {
	float: left;
	margin-left: 10px;
}
</style>
<div class="inner_title">
	<h3 class="title">
		&nbsp;
		<?php echo __('Extra Notes', true); ?>
	</h3>
	<span><?php 
	echo $this->Html->link(__('Back'), array('action' => 'listExtraNotes',$patientId), array('escape' => false,'class'=>'blueBtn'));
	?> </span>

</div>

<div class="clr ht5"></div>

<div class="container">
	<div class="comman">
		<h3>
			<?php echo ("Cognitive Status")?>
		</h3>
		<div align="center">
			<table border="0" class="table_format_body" cellpadding="0"
				cellspacing="0" width="85%">
				<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong>Date</strong></td>
					<td class="table_cell"><strong>Name</strong></td>
					<td class="table_cell"><strong>Snomed CT Code</strong></td>
					<td class="table_cell"><strong>Status</strong></td>
				</tr>
				<?php
				//$count=0;
				$toggle =0;
				foreach($viewData['CognitFunction'] as $cog){
					if($toggle == 0) {
						echo "<tr class='row_gray'>";
						$toggle = 1;
					}else{
						echo "<tr>";
						$toggle = 0;
					}
					?>
				<td class="row_format">&nbsp;<?php echo $this->DateFormat->formatDate2Local($cog['cog_date'],Configure::read('date_format'));  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $cog['cog_name'];  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $cog['cog_snomed_code'];  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo 'Active';  ?>
				</td>
				</tr>
				<?php }?>
			</table>
		</div>
	</div>

	<div class="comman">
		<h3>
			<?php echo ("Event Note")?>
		</h3>
		<ul class="">
			<li class=""><strong><?php //echo("Subjective")?> </strong></li>
			<?php  if(!empty($viewData['Note']['event_note'])) {?>
			<li><strong><?php echo $viewData['Note']['event_note']; ?> </strong>
			</li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }?>
		</ul>
	</div>


	<div class="comman">
		<h3>
			<?php echo ("Finalization")?>
		</h3>
		<ul class="">
			<?php  if(!empty($viewData['Note']['bmi']) || !empty($viewData['Note']['final']) || !empty($viewData['Note']['patient_character_snomed'])) {?>
			<li class=""><strong><?php echo("Weight Screening :")?> </strong>
				<div align="left" style="padding-left: 114px;">
					<table border="0" class="table_format_body" cellpadding="0"
						cellspacing="0" width="45%">
						<tr class="row_gray">
							<td class="row_format" style="width: 5%"><strong><?php echo __("Height :"); ?>
							</strong></td>
							<td class="row_format" style="width: 10%"><?php echo $viewData['Note']['ht']; ?>
								(Inch.)</td>
							<td class="row_format" style="width: 5%"><strong><?php echo __("Weight :"); ?>
							</strong></td>
							<td class="row_format" style="width: 10%"><?php echo $viewData['Note']['wt']; ?>
								(Lbs.)</td>
							<td class="row_format" style="width: 5%"><strong><?php echo __("BMI :"); ?>
							</strong></td>
							<td class="row_format" style="width: 10%"><?php echo $viewData['Note']['bmi']; ?>
							</td>
							<td class="row_format" style="width: 5%"><strong><?php echo __("Date :"); ?>
							</strong></td>
							<td class="row_format" style="width: 10%"><?php echo $this->DateFormat->formatDate2Local($viewData['Note']['finalization_date'],Configure::read('date_format_us'),false); ?>
							</td>
						</tr>
					</table>
				</div>
			</li>
			<?php $final = explode('|',$viewData['Note']['final']); ?>
			<li>
				<div align="left" style="padding-left: 114px;">
					<table border="0" class="table_format_body" cellpadding="0"
						cellspacing="0" width="45%">
						<?php foreach($final as $displData):?>
						<tr class="row_gray">
							<td class="row_format" style="width: 10%"><strong><?php echo __($displData);?>
							</strong>
							</td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
			</li>
			<li>&nbsp;</li>
			<li><strong><?php echo __('Patient Characterstic : ');?> </strong>&nbsp;<?php echo $charestic = ($viewData['Note']['patient_character_snomed'] == '13798002')? 'Gestation Period 38 weeks(finding)' : 'Gestational age unknown'?>
			</li>
			<li><strong><?php echo __('Characterstic Date : ');?> </strong>&nbsp;<?php echo $this->DateFormat->formatDate2Local($viewData['Note']['patient_char_date'],Configure::read('date_format_us'),false); ?></li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }?>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<?php echo ("Functional Status")?>
		</h3>
		<div align="center">
			<table border="0" class="table_format_body" cellpadding="0"
				cellspacing="0" width="85%">
				<tr class="row_title">
					<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
					<td class="table_cell"><strong>Date</strong></td>
					<td class="table_cell"><strong>Name</strong></td>
					<td class="table_cell"><strong>Snomed CT Code</strong></td>
					<td class="table_cell"><strong>Status</strong></td>
				</tr>
				<?php
				//$count=0;
				$toggle =0;
				foreach($viewData['FunctionalStatus'] as $functional){
					if($toggle == 0) {
						echo "<tr class='row_gray'>";
						$toggle = 1;
					}else{
						echo "<tr>";
						$toggle = 0;
					}
					?>
				<td class="row_format">&nbsp;<?php echo $this->DateFormat->formatDate2Local($functional['cog_date'],Configure::read('date_format'));  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $functional['cog_name'];  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $functional['cog_snomed_code'];  ?>
				</td>
				<td class="row_format">&nbsp;<?php echo 'Active';  ?>
				</td>
				</tr>
				<?php }?>
			</table>
		</div>
	</div>
	<div class="comman">
		<h3>
			<?php echo ("Instruction")?>
		</h3>
		<ul class="">
			<li class=""><strong><?php //echo("Subjective")?> </strong></li>
			<?php  if(!empty($viewData['Note']['note'])) {?>
			<li><strong><?php echo $viewData['Note']['note']; ?> </strong>
			</li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }?>
		</ul>
	</div>
	<div class="comman">
		<h3>
			<?php echo ("Recommended Decision Aids")?>
		</h3>
		<ul class="">
			<li class=""><strong><?php //echo("Subjective")?> </strong></li>
			<?php  if(!empty($viewData['Note']['decision_aids'])) {?>
			<li><strong><?php echo $viewData['Note']['decision_aids']; ?> </strong>
			</li>
			<?php }else{?>
			<li><strong><?php echo ("No record found") ?> </strong></li>
			<?php }?>
		</ul>
	</div>

</div>
