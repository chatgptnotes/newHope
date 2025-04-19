<style>

.inner_title h3 {
    clear: both !important;
    float: left !important;
}

.inner_title p {
    margin: 0;
    padding-top: 6px;
}
.inner_t {
    color: #1c7087;
    font-size: 14px;
    font-weight: bold;
}
</style>

<?php

if($status == "imported"){
	?>
<script> 
		alert("CCDA imported successfully"); 
		jQuery(document).ready(function() { 
			parent.location.reload(true);
			parent.$.fancybox.close(); 
 
		});
		</script>
<?php  
}

echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
		'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3','jquery.ui.widget','jquery.ui.mouse','jquery.ui.core'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); ?>
<div class="inner_title">
	<h3>Patient List</h3>
</div>

<div class="clr inner_title" style="text-align: right;"></div>
<div align="center" id='busy-indicator'>
	&nbsp;
	<?php echo $this->Html->image('indicator.gif', array()); ?>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<?php 
 
	if(isset($data) && !empty($data)){

	//set get variables to pagination url

			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			?>


	<tr class="row_title">
		<td class="table_cell"><strong><?php echo   __('Patient ID', true) ; ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo   __('Visit ID', true) ; ?> </strong>
		</td>
		<td class="table_cell"><strong><?php echo   __('Patient Name', true) ; ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo   __('Race', true) ; ?> </strong>
		</td>
		<td class="table_cell"><strong><?php echo   __('Ethnicity', true) ; ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo   __('SSN', true) ; ?> </strong>
		</td>
		<td class="table_cell" style="width: 30%"><strong><?php echo  __('Action');?>
		</strong></td>

	</tr>
	<?php 
	$toggle =0;
	if(count($data) > 0) {
							$i = 0 ;
							foreach($data as $patients){
				       				$i++ ;
				       				if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							       ?>
	<td class="row_format"><?php echo $patients['Person']['patient_uid']; ?>
	</td>
	<td class="row_format"><?php echo $patients['Patient']['admission_id']; ?>
	</td>
	<td class="row_format"><?php echo $patients['Patient']['full_name']; ?>
	</td>
	<td class="row_format"><?php echo $patients['Race']['race_name']; ?>
	</td>
	<td class="row_format"><?php echo $patients['Person']['ethnicity']; ?>
	</td>
	<td class="row_format"><?php echo $patients['Person']['ssn_us']; ?>
	</td>

	<td valign="bottom"><?php 
	echo $this->Form->create('ccda',array('url'=>array('controller'=>'ccda','action'=>'parseCcda',$filename),
																		 'id'=>'ccda','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false,'style'=>'')));

											echo $this->Form->input('IncorporatedPatient.summary_care_date', array('type'=>'text','class'=>'import_date','id' => 'import_date'.$i,'label'=>false));
											echo $this->Form->input('IncorporatedPatient.summary_provide',array('options'=>array('1'=>'Yes','0'=>'No'),'label'=>false,'div'=>false));
											echo $this->Form->hidden('IncorporatedPatient.id',array('value'=>$id,'label'=>false,'div'=>false));
											echo $this->Form->hidden('patient_id',array('value'=>$patients['Patient']['id'],'label'=>false,'div'=>false));
											echo $this->Form->hidden('patient_uid',array('value'=>$patients['Person']['patient_uid'],'label'=>false,'div'=>false));
											echo $this->Form->hidden('person_id',array('value'=>$patients['Person']['id'],'label'=>false,'div'=>false));

											echo $this->Form->submit("Import CCDA" ,array('class'=>'blueBtn subBtn','div'=>false,'onclick'=>'$(this).hide();'));
											echo $this->Form->end();
								   ?></td>
	</tr>
	<?php } 
	$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
	?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		
		</TD>
	</tr>
	<?php } ?>
	<?php					  
			      } else {
			 ?>
	<tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
			      }
			      ?>

</table>
<script> 
		 
		jQuery(document).ready(function() { 
		 
			$(".subBtn").click(function(){
				$('#busy-indicator').show('fast');
				 
			});
		});

		$(".import_date")
		.datepicker(
				{
					showOn : "button",
					buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly : true,
					changeMonth : true,
					changeYear : true,  
					dateFormat:'<?php echo $this->General->GeneralDate();?>',
				});
		</script>
