
<div class="inner_title">
	<h3 style="float: left;">RGJAY Package</h3>
</div>
	<div style="float: right;" ><?php echo $this->Html->link(__('Back'),array('controller' =>'PatientDocuments', 'action' =>'rgjay_list'),array('escape' => false,'class'=>'blueBtn'));?></div>

	
	
	<?php
if($action=='print' && !empty($lastId)){
	echo "<script>var openWin = window.open('".$this->Html->url(array('action'=>'anae_print',$this->request->params['pass'][0],$this->request->params['pass'][1]))."', '_blank',
                       'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); </script>"  ;
}
?>
<?php  
echo $this->Form->create('rgjaypackage',array('id'=>'rgjaypackage','inputDefaults'=>array('label'=>false,'div'=>false)));
?>




<table width="100%" cellpadding="0" cellspacing="1" border="0"class="tabularForm">
	<tr class="row_gray">
		<td >RGJAY Package</td>
		
		<td><?php echo $this->Form->input('package_name',array('class'=>'textBoxExpnd','style'=>'width:70%','id'=>'package_name','label'=>false,'div'=>false,'placeholder'=>'Select Package','value'=>$data['RgjayPackageMaster']['package_name']));?>
			<?php echo $this->Form->hidden('package_id',array('id'=>'package_id','value'=>''))?>
		</td>
		</tr>
		<tr>
		<td ><?php echo __('Category'); ?></td>
		<td><?php echo $this->Form->input('rgjaypackage.category', array('id' => 'category','class'=>'textBoxExpnd', 'label'=> false,'style'=>'width:25%', 'div' => false,'value'=>$data['RgjayPackageMaster']['category'],
			 'error' => false,'options'=>array(''=>'Please Select','Claim Submission'=>'Claim Submission','Pre Auth'=>'Pre Auth')));?>
		</td>
	</tr>
		<tr>
		<td> Required Documents </td>
			<td>
			<?php 
			echo $this->Form->textarea('documents',array('label'=>false,'div'=>false,'id'=>'documents','type'=>'textarea','style'=>"width: 249px; height: 55px;",'value'=>$data['RgjayPackageMaster']['documents']));
		?>
		<h5>('Please insert list of documents seperted by coma')</h5>
			
		</td>
	</tr>
	<tr>
	<td colspan="3">
	<?php echo $this->Form->submit('Save',array('class'=>'blueBtn','div'=>false,'style'=>'float:left')); 
	echo $this->Form->end();
	?>
     </td>
	</tr>
	</table>
	<script>
	$(document).ready(function(){
		var tarffId = "<?php echo $rgjayTariffId;?>";
		var rgjayPackage = "<?php echo $rgjayPackage; ?>";
		$("#package_name").autocomplete({

			
			source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices",$rgjayPackage,'?'=>array('tariff_standard_id'=>$rgjayTariffId),"admin" => false,"plugin"=>false)); ?>",
	
				setPlaceHolder : false,
				select: function(event,ui){	
					$( "#package_id" ).val(ui.item.id);			
			},
			 messages: {
		         noResults: '',
		         results: function() {},
		   },
			
		});
	});

		</script>