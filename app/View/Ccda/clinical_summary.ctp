<?php 
	echo $this->Html->script(array('jquery-1.5.1.min','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3','jquery.fancybox-1.3.4'));
	echo $this->Html->css(array( 'internal_style.css','jquery.fancybox-1.3.4.css','jquery.ui.all.css','jquery-ui-1.8.16.custom.css')); 
	if($status == "success"){
	?>
<script> 
		//alert("CCDA generated successfully"); 
		jQuery(document).ready(function() { 
			parent.location.reload(true);
			parent.$.fancybox.close(); 
 
		});
		</script>
<?php   } ?>
<div class="inner_title">
	<div style="float: left">
		<h3>
			<?php echo __('Clinical Summary');?> 
		</h3>
		
		<?php if(!$flag){?>
			<span style="padding-left: 1536px;"> <?php echo $this->Html->link(__('Back', true),array('controller' => 'patients', 'action' => 'patient_information',$patient_id), array('escape' => false,'class'=>'blueBtn'));?>
			<?php }?>
			</span>
	
		
	</div>
	<!-- 
	<?php if(isset($e2Filename['XmlNote']['e2_filename']) && !empty($e2Filename['XmlNote']['e2_filename'])){ ?>
	<div style="float: right; padding-top: 8px;width: 30px;" >
		
			<?php echo $this->Html->link($this->Html->image("icons/view-icon.png",array('alt'=>'View CCDA','title'=>'View CCDA')),'#',
			array('onclick'=>"view_consolidate_ccda(".$patient_id.")",'escape' => false,'style'=>'display:block;' )); ?>
		</div>	
		<div style="float: right">
			<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download CCDA','title'=>'Download CCDA')),
			array('action'=>'downloadXml',$patient_id,true),array('escape'=>false ,'style'=>'display:block;')); ?>
		
	</div>
	<?php }?>  -->
	<div style="text-align: right;">&nbsp;</div>
</div>
<div class="clr">&nbsp;</div>
<?php $products=array('0'=>'Common MU Data set','1'=>'Provider\'s name and office contact information','2'=>'Date and location of visit',
		'3'=>'Reason for visit','4'=>'Immunizations and/or medications administered during the visit','5'=>'Diagnostic tests pending',
		'6'=>'Clinical Instructions','7'=>'Future appointments','8'=>'Referrals to other providers',
		'9'=>'Future scheduled tests','10'=>'Recommended patient decision aids');
		
echo $this->Form->create('User');?>
<div style="padding-left:20px;">
			<i>(Select to share with patient)</i>
		</div>
<table style="font-size:13px; float: right; margin-right: 250px;" class="table_format">
	

<tr>
			<td style=" float: right; ">
				<?php echo __('Date :');?> </td>
			<td style=" margin-right: 250px;"><?php echo $this->Form->input('XmlNote.clinical_date', array( 'class'=>'textBoxExpnd','type'=>'text', 'readonly'=>'readonly' ,'id' => 'clinical_date','label'=>false));?>
			</td>
			</tr>
			<tr>
			<td >
				<?php echo __('Option :');?></td> 
				
			<td style=" margin-right: 250px;"><?php echo $this->Form->input('XmlNote.option', array('options'=>array(''=>__('Please Select Option'),'Print'=>__('Print'),'Portal'=>__('Portal'),'Patient Declined'=>__('Patient Declined'),'None'=>__('None')),'id' => 'option','label'=>false)); ?>
			</td>
			
			
		</tr>
</table>
<table class="table_format" style="font-size:13px;" >
	<?php $i=0;
	 
	foreach ($products as $product){ ?>
		<tr class="">
			<td style="cursor: default;margin: 15px 0 0 10px;"><?php echo $this->Form->input('XmlNote.permissions.'.$i,array('value'=>$i,'label' => false,'hiddenField' => false,'type' => 'checkbox','id'=>'listing_'.$i));  ?>
			</td>
			<td><?php echo $product; ?></td>
		</tr>
	<?php $i++; } ?>
</table>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->submit(__('Submit'), array('label'=> false, 'error' => false,'class'=>'blueBtn','style' =>'float:right;' ));?>
<div class="clr">&nbsp;</div>
<script type="text/javascript">

 	$(function() {
		$('input[type=checkbox]').attr('checked','checked');
		$("#listing_0").attr("disabled", true);
	}); 


 	function view_consolidate_ccda(id) {
 		$.fancybox({ 
			'width' : '85%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "view_consolidate")); ?>"
			+ '/' + id+"/"+true
			});
 	}


 	$("#clinical_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange : '-73:+0',
				//maxDate : new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
			});
	
</script>
