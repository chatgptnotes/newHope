<?php $admissionType = $this->params['pass'][0]; ?>
<tr id="head_<?php echo $admissionType; ?>">
	<td style="padding-left:30px;">
		<table width="90%" align="left">
			<tr>
				<td>
					<span>
						<div id="showPrivateArrow_<?php echo $admissionType; ?>" class="showPrivateArrow"><?php echo $this->Html->image('down_arrow.png',array('title'=>'Click to Expand','alt'=>'Expand','escape'=>false)); ?></div> 
						<div id="hidePrivateArrow_<?php echo $admissionType; ?>" class="hidePrivateArrow" style="display:none;"><?php echo $this->Html->image('right_arrow.png',array('title'=>'Collapse','alt'=>'Collapse','escape'=>false)); ?></div>
					</span> 
					<span style="float:left">&nbsp;&nbsp;</span>
					<span style="float:left"><i><b>Private</b></i></span>
					<span style="float:right"><i><b><?php echo number_format($totHead['Private']?$totHead['Private']:0); unset($totHead['Private']); ?></b></i></span>
				</td>
			</tr>
			<tr id="showPrivateChild_<?php echo $admissionType; ?>" style="display:none;">
				<td style="padding-left:50px;">
					<table width="80%" align="left">
						<?php foreach ($headResult['Private'] as $pkey => $privateValue) { ?> 
						<tr>
							<td align="left"><?php echo $privateValue['patient_name']; ?></td>
							<td align="right"><?php echo number_format($privateValue['amount']?$privateValue['amount']:0); ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<span>
						<div id="showCorporateArrow_<?php echo $admissionType; ?>" class="showCorporateArrow"><?php echo $this->Html->image('down_arrow.png',array('title'=>'Click to Expand','alt'=>'Expand','escape'=>false)); ?></div> 
						<div id="hideCorporateArrow_<?php echo $admissionType; ?>" class="hideCorporateArrow" style="display:none;"><?php echo $this->Html->image('right_arrow.png',array('title'=>'Collapse','alt'=>'Collapse','escape'=>false)); ?></div>
					</span>
					<span style="float:left">&nbsp;&nbsp;</span>
					<span style="float:left"><i><b>Corporate</b></i></span>
					<span style="float:right"><i><b><?php echo number_format(array_sum($totHead)?array_sum($totHead):0); ?></b></i></span>
				</td>
			</tr>
			<tr id="showCorporateChild_<?php echo $admissionType; ?>" style="display:none;">
				<td style="padding-left:30px;">
					<table width="90%" align="left">
						<?php $cnt = 0; foreach ($totHead as $tariffName => $tariffDetail) { $cnt++; ?>
							<tr>
								<td>
									<span>
										<div id="showCorporateSubArrow_<?php echo $cnt; ?>" class="showCorporateSubArrow"><?php echo $this->Html->image('down_arrow.png',array('title'=>'Click to Expand','alt'=>'Expand','escape'=>false)); ?></div> 
										<div id="hideCorporateSubArrow_<?php echo $cnt; ?>" class="hideCorporateSubArrow" style="display:none;"><?php echo $this->Html->image('right_arrow.png',array('title'=>'Collapse','alt'=>'Collapse','escape'=>false)); ?></div>
									</span>
									<span style="float:left">&nbsp;&nbsp;</span>
									<span style="float:left"><?php echo $tariffName; ?></span>
									<span style="float:right"><?php echo number_format($tariffDetail?$tariffDetail:0); ?></span>
								</td>
							</tr> 
							<tr id="showCorporateSubChild_<?php echo $cnt; ?>" style="display:none;">
								<td style="padding-left:50px;">
									<table width="80%" align="left">
										<?php foreach ($headResult[$tariffName] as $tkey => $tariffValue) { ?>
										<tr>
											<td align="left"><?php echo $tariffValue['patient_name']; ?></td>
											<td align="right"><?php echo number_format($tariffValue['amount']?$tariffValue['amount']:0); ?></td>
										</tr>
										<?php } ?>
									</table>
								</td>
							</tr>  
						<?php } ?>
						<tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
 
<script type="text/javascript"> 
$(document).ready(function(){ 
	$('.showCorporateArrow').click(function(){ 
		var id = $(this).attr('id').split("_")[1];
		$("#showCorporateChild_"+id).show();
		$("#showCorporateArrow_"+id).hide();
		$("#hideCorporateArrow_"+id).show();
	});

	$('.hideCorporateArrow').click(function(){ 
		var id = $(this).attr('id').split("_")[1];
		$("#showCorporateChild_"+id).hide();
		$("#hideCorporateArrow_"+id).hide();
		$("#showCorporateArrow_"+id).show();
	});

	$('.showPrivateArrow').click(function(){ 
		var id = $(this).attr('id').split("_")[1];
		$("#showPrivateChild_"+id).show();
		$("#showPrivateArrow_"+id).hide();
		$("#hidePrivateArrow_"+id).show();
	});

	$('.hidePrivateArrow').click(function(){ 
		var id = $(this).attr('id').split("_")[1];
		$("#showPrivateChild_"+id).hide();
		$("#hidePrivateArrow_"+id).hide();
		$("#showPrivateArrow_"+id).show();
	});


	$('.showCorporateSubArrow').click(function(){ 
		var id = $(this).attr('id').split("_");
		$("#showCorporateSubChild_"+id[1]).show();
		$("#showCorporateSubArrow_"+id[1]).hide();
		$("#hideCorporateSubArrow_"+id[1]).show();
	});

	$('.hideCorporateSubArrow').click(function(){ 
		var id = $(this).attr('id').split("_");
		$("#showCorporateSubChild_"+id[1]).hide();
		$("#hideCorporateSubArrow_"+id[1]).hide();
		$("#showCorporateSubArrow_"+id[1]).show();
	});
});
</script>