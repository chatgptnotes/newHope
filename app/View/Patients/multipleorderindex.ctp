<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));      
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','slides.min.jquery.js',
									'jquery.isotope.min.js','jquery.custom.js','ibox.js','jquery.fancybox-1.3.4','jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js'));?>


<?php echo $this->Form->create('multipleorderindex',array('type' => 'file','id'=>'multipleorderindex','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false,
		'url' => array('controller' => 'patients', 'action' => 'multipleorderindex',$patient_id,)
)
));


?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Orders Information')."-".$multiOrderType;?>
	</h3>

</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">

	<tr class="row_title">

		<td class="table_cell" width="10%"><strong><?php echo __(''); ?> </strong>
		</td>
		<td class="table_cell" width="30%"><strong><?php echo __('Component');?>
		</strong>
		</td>
		<td class="table_cell" width="10%"><strong><?php echo __('Status'); ?>
		</strong>
		</td>
		<td class="table_cell" width="30%"><strong><?php echo  __('Details'); ?>
		</strong>
		</td>
	</tr>
	<?php 
	echo $this->Form->hidden('id',array('value'=>$id,'id'=>"paient_id"));
	foreach($getMultiOrderData as $datas){
	?>
	<tr class="row_title">
	<?php //if($datas['PatientOrder']['OrderCategory']['order_description']){?>

		<td class="table_cell" width="30%" colspan='4'><strong><?php echo __('Category');?>
		</strong>
		<?php //}?>
	</tr>
	<tr class="">
		<td class="table_cell" width="10%"><strong><?php echo __(' '); ?> </strong>
		
		<td class="table_cell" width="10%"><strong><?php echo $this->Form->checkbox('checkSataus',array('name'=>'data[PatientOrder][multipleorder][]','value'=>$datas['PatientOrder']['name'].'_'.$datas['PatientOrder']['sentence'],'hiddenField'=>false)) ; ?>
				<?php echo $datas['PatientOrder']['name']; ?>
		</strong>
		
		<td class="table_cell" width="10%"><strong><?php echo $datas['PatientOrder']['status']; ?>
		</strong>
		</td>
		<td class="table_cell" width="30%"><strong><?php echo $datas['PatientOrder']['sentence']."&nbsp;".'|'."&nbsp;".
		$this->Html->link('Edit','#',
				array('onclick'=>'add()'));?> </strong>
		</td>
	</tr>
	<?php  echo $this->Form->hidden(alldata,array('value'=>$id.$datas['PatientOrder']['order_category_id'].$datas['PatientOrder']['name'].$datas['PatientOrder']['status'].$datas['PatientOrder']['sentence'].'isMulti','id'=>'myData'));}?>
	<tr>
		<td align="right" style="padding-right: 10px; padding-top: 10px"
			colspan="4"><input class="blueBtn" type="submit" value="Submit"
			id="submit">
		</td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>
<script>
$(document).ready(function(){	
	var myCars=new Array();
	$('#submit').click(function(){
			$('.dragbox')
			.each(function(){
				var myCars = new Array($(this).attr('value'));
				alert($('#MajorData').val(myCars));
				
		});
			//location.href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "multipleorderindex")); ?>"+"/"+1+"/"+0+"/"+myCars;
	});
});
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "ordersentence","admin" => false)); ?>";

function add(){
	//2169/33/2382/Chloroguanide
	var ismultiple=0;
	var formdata = $('#multipleorderindex').serialize();
	$
	.fancybox({
		'width' : '50%',
		'height' : '50%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'ajax',
	    
	    ajax : { 
	  	  type : "POST", 
	  	  url: ajaxUrl,
	  	  data : "pawan="+$('#myData').val(), 
	  	  success : function(data){
	  	   // do something on success
	  	  } 
	  	 }
	});
}
</script>
<?php 
/*
<td class="table_cell" width="30%"><strong><?php echo $this->Form->input('sentence',array('label'=>false,'readonly'=>'readonly','id'=>'prob'.$getMultiOrderData[$j]['PatientOrder']['name'],'value'=>$getMultiOrderData[$j]['PatientOrder']['sentence'])).$this->Html->link('Edit','#',
				array('onclick'=>'add("'.$id.'","'.$getAllOrderCategoryData[$j]["OrderCategory"]["id"].'","'.$getAllOrderCategoryData[$j]['OrderSubcategory'][$i]['id'].'","'.$getAllOrderCategoryData[$j]['OrderSubcategory'][$i]['name'].'")'));?>
		</strong>
		</td>
*/
?>