<div class="inner_title">

		<div style="float: left">
			<h3>
				<?php echo __('Measure Statin Prescribed at Discharge', true); ?>
			</h3>
		</div>
		<div style="text-align: right;">
			&nbsp;
			<?php 
		 	 	echo $this->Html->link(__('Back'), array('action' => 'clinical_quality_measure'),array('class'=>'blueBtn','admin'=>true));
    		?>
		</div>
	</div>
<div>&nbsp;</div>
<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">

	<th colspan="5" style="text-transform: uppercase;"><?php echo __("IPD Patient's Information", true); ?>
	</th>


</table> -->

<!-- two column table end here -->

<div>&nbsp;</div>
<div class="clr ht5"></div>

<?php $products=array(''=>'Please select','Patient'=>'Patient','Medication'=>'Medication','system'=>'system'); 

echo $this->Form->create('',array('controller'=>'Report','action'=>'quality_measure_detail'),array('admin'=>true));

if(!empty($CqmData)){?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">
	<tr>
		<th width="25%" style="text-align: center;"><?php echo __('Patient Name', true); ?>
		</th>
		<th width="10%" style="text-align: center;"><?php echo __('Denominator', true); ?>
		</th>
		<th width="10%" style="text-align: center;"><?php echo __('Numerator', true); ?>
		</th>
		<th width="30%" style="text-align: center;"><?php echo __('Exclusion', true); ?>
		</th>
		<th width="25%" style="text-align: center;"><?php echo __('Exception', true); ?>
		</th>
	</tr>
	<?php $i = 0;
	foreach($CqmData as $cqm){
	echo $this->Form->hidden('CqmExclusionList'.$i.'.patient_id',array('value'=>$cqm['CqmExclusionList']['patient_id']));
	echo $this->Form->hidden('CqmExclusionList'.$i.'.id',array('value'=>$cqm['CqmExclusionList']['id']));
?>
	<tr>
		<td style="text-align: center;"><?php echo __($cqm['Patient']['lookup_name'], true); ?>
		</td>
		<td valign="middle" style="text-align: center;"><?php if($cqm['CqmExclusionList']['isdenominator'] == '1')echo $this->Form->input('CqmExclusionList'.$i.'.isdenominator',array('value'=>'1','checked'=>true,'label' => false,'hiddenField' => true,'type' => 'checkbox','id'=>'deno_'.$i)); 
																else echo $this->Form->input('CqmExclusionList'.$i.'.isdenominator',array('value'=>'1','label' => false,'hiddenField' => true,'type' => 'checkbox','id'=>'deno_'.$i));?>
		</td>
		<td valign="middle" style="text-align: center;"><?php if($cqm['CqmExclusionList']['isnumerator'] == '1')echo $this->Form->input('CqmExclusionList'.$i.'.isnumerator',array('value'=>'1','checked'=>true,'label' => false,'hiddenField' => true,'type' => 'checkbox','id'=>'numer_'.$i)); 
																else echo $this->Form->input('CqmExclusionList'.$i.'.isnumerator',array('value'=>'1','label' => false,'hiddenField' => true,'type' => 'checkbox','id'=>'numer_'.$i));?>
		</td>
		<td>
			<table>
				<tr>
					<td  valign="baseline" style="padding-top: 18px;"><?php if($cqm['CqmExclusionList']['isexcluded'] == '1')echo $this->Form->input('CqmExclusionList'.$i.'.isexcluded',array('value'=>'1','checked'=>true,'label' => false,'hiddenField' => true,'type' => 'checkbox','id'=>'excl_'.$i,'class'=>'excluded'));
					  														else echo $this->Form->input('CqmExclusionList'.$i.'.isexcluded',array('value'=>'1','label' => false,'hiddenField' => true,'type' => 'checkbox','id'=>'excl_'.$i,'class'=>'excluded'));?>
					</td>
					<td id="excl_<?php echo $i ?>1"><?php echo $this->Form->input('CqmExclusionList'.$i.'.exclude_reason', array('value'=>$cqm['CqmExclusionList']['exclude_reason'],'options'=>$products,'label'=> false, 'div' => false, 'error' => false,'class'=>'excl_'.$i.'1')); ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td id="excl_<?php echo $i ?>2"><?php echo $this->Form->textarea('CqmExclusionList'.$i.'.exclude_text', array('value'=>$cqm['CqmExclusionList']['exclude_text'],'cols' => '35', 'rows' => '2', 'label'=> false, 'div' => false, 'error' => false,'class'=>'excl_'.$i.'2')); ?>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td valign="baseline" style="padding-top: 18px;"><?php if($cqm['CqmExclusionList']['isexception'] == '1')echo $this->Form->input('CqmExclusionList'.$i.'.isexception',array('value'=>'1','checked'=>true,'label' => false,'hiddenField' => true,'type' => 'checkbox','id'=>'exception_'.$i,'class'=>'exception'));
					  														else echo $this->Form->input('CqmExclusionList'.$i.'.isexception',array('value'=>'1','label' => false,'hiddenField' => true,'type' => 'checkbox','id'=>'exception_'.$i,'class'=>'exception'));?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td valign="baseline" style="padding-top: 18px;"></td>
					<td id="exception_<?php echo $i ?>1"><?php 
					echo $this->Form->textarea('CqmExclusionList'.$i.'.exception_text', array('value'=>$cqm['CqmExclusionList']['exception_text'],'cols' => '35', 'rows' => '2', 'label'=> false, 'div' => false, 'error' => false,'class'=>'exception_'.$i.'1'));
					?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<?php $i++; 
}?>
</table>
<div>&nbsp;</div>
<div class="clr ht5"></div>
<div class="btns">

	<?php
	echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false));

	?>
</div>
<?php }else{?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">
	<tr>
		<th width="25%" style="text-align: center;"><?php echo __('No Data Recorded');?>
		</th>
	</tr>


</table>
<?php }?>
<div>&nbsp;</div>
<div class="clr ht5"></div>

<script>
	var counter = "<?php echo $i; ?>";
	
	$(function(){ 
		for(i=0;i<=counter;i++){
			if($('#excl_'+i).attr('checked')) {
				$('#excl_'+i+'1').show();
			    $('#excl_'+i+'2').show();
			} else {
				$('.excl_'+i+'1').val('');
				$('.excl_'+i+'2').val('');
				
			    $('#excl_'+i+'1').hide();
			    $('#excl_'+i+'2').hide();
			   
			}
			if($('#exception_'+i).attr('checked')) {
			    $('#exception_'+i+'1').show();
			} else {
				$('.exception_'+i+'1').val('');
			    $('#exception_'+i+'1').hide();
			    
			}
		}
	});
		
$('.excluded').click(function(){
	var id = jQuery(this).attr("id");
	
		if($('#'+id).attr('checked')) {
		    $('#'+id+'1').show();
		    $('#'+id+'2').show();
		} else {
			$('.'+id+'1').val('');
			$('.'+id+'2').val('');
			$('#'+id+'1').hide();
			$('#'+id+'2').hide();
			
		}
	});

$('.exception').click(function(){ 
	var id = jQuery(this).attr("id");
	if($('#'+id).attr('checked')) {
		$('#'+id+'1').show();
	} else {
		$('.'+id+'1').val('');
		$('#'+id+'1').hide();
		
	}
});

</script>
