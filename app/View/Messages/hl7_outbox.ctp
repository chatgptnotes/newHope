
<style>

/**
 * for left element1
 */
.table_first{
 	margin-bottom: -20px;
 	
}

.td_second{
	border-left-style:solid; 
	padding-left: 25px; 
	padding-top: 25px
}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}

.table_format{
	padding: 0px;
}


.inner_t{
 	color: #1c7087;
    font-size: 14px;
    font-weight: bold;
}
.inner_title h3 {
    clear: both !important;
    float: left !important;
	padding:-5px !important;
}
.inner_title p{padding-top: 6px; margin:0px;}

.inner_t{
 	color: #1c7087;
    font-size: 14px;
    font-weight: bold;
}

.inner_title h3{
	padding: 5px;
}
.row_title td{ border:none !important;}
/* EOCode */

</style>

<div id="message_error" align="center"></div>

<div class="inner_title" >
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Lab Mailbox >') ?>
	</h3>
	<p style="margin-right: 1020px;margin-bottom: 5px;" class="inner_t" >
		<?php echo __(' Outbox'); ?>
	
	</p>
</div>


<table class="table_first" width="100%"  cellspacing='0' cellpadding='0'>
	<tr>
		<td valign="top" width="5%">
			<div class="mailbox_div">
				<?php echo $this->element('mailbox_index');?>
			</div>
		</td>
		<td class="td_second" valign="top">
<!-- 			<div class="mailbox_div"> -->
				<?php //echo $this->element('hl7_list');?>
<!-- 			</div> -->
			<div class="" >
				
			<!-- <span><?php  echo $this->Html->link('Back',array("controller"=>"Messages","action"=>"index"),array('escape'=>false,'class'=>'blueBtn')); ?></span> -->
			</div>
				
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align: center;">
				
				<tr class="row_title">
					<td class="table_cell"><strong> <?php echo __('Lab Order Id'); ?>
					</strong></td>
					<td class="table_cell"><strong> <?php echo __('Lab Date'); ?>
					</strong></td>
					<td class="table_cell"><strong> <?php echo __('Test Name'); ?>
					</strong></td>
					<td class="table_cell"><strong> <?php echo __('Patient Name'); ?>
					</strong></td>
					<td class="table_cell"><strong> <?php echo __('Patient MRN'); ?>
					</strong></td>
					<td class="table_cell"><strong> <?php echo __('Sent To'); ?>
					</strong></td>
		
				</tr>
				<?php 
				$toggle =0;
				foreach ($testOrdereds as $testOrdered ){
						if($toggle == 0) {
							echo "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							echo "<tr class=''>";
							$toggle = 0;
						}?>
					<td class="row_class"><?php echo $testOrdered['LaboratoryTestOrder']['order_id']; ?>
					</td>
					<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($testOrdered['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true); ?>
					</td>
					<td class="table_cell"><?php echo $testOrdered['Laboratory']['name']; ?>
					</td>
					<td class="table_cell"><?php echo $testOrdered['Patient']['lookup_name']; ?>
					</td>
					<td class="table_cell"><?php echo $testOrdered['Patient']['patient_id']; ?>
					</td>
					<td class="table_cell"><?php echo $testOrdered['LaboratoryTestOrder']['service_provider_id']; ?>
					</td>
		
				</tr>
				<?php }?>
				
			</table>
			<div>&nbsp;</div>
		</td>
	</tr>
</table>