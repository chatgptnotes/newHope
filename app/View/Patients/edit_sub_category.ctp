<?php 
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3'));
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css','internal_style.css'));

?>
<?php //echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>
<?php 

//echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3.js'));
//echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>
<style>
.inline_labels
{
   float:left;
   margin:0px;
   width:200px;
}
</style>
</head>
<body>

	<?php echo $this->Form->create('Edit',array('type' => 'file','id'=>'edit_sub_category','inputDefaults' => array(
			'label' => false,
			'div' => false,
			'error' => false,
			'legend'=>false,
			'fieldset'=>false,
			'url' => array('controller' => 'patients', 'action' => 'edit_sub_category',$patient_id,)
	)
	));


	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
	<tr>
			<th colspan="4" style="margin-top:10px;">Add new Order Sentence</th>
		</tr>
					
		<?php //$getResultedRecords['OrderSentence']['sentence']=>$getResultedRecords['OrderSentence']['sentence']?>
		<?php echo $this->Form->hidden('PatientOrder.patient_id',array('value'=>$patient_id,'id'=>'patient_id'));?>
		<?php echo $this->Form->hidden('PatientOrder.name',array('value'=>$name));?>
		<?php echo $this->Form->hidden('PatientOrder.location_id',array('value'=>$this->Session->read('locationid')));?>
		
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace">
				<?php foreach($getOrderSubcategoryDataRecored as $datas) {
					$radioOptions[]=$datas['OrderSubcategory']['order_sentence'];
					$radioOptions[]=$datas['OrderSentence']['sentence'];
				}?>
				<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php  echo '<ul style="list-style:none">'; echo $this->Form->radio('PatientOrder.sentence', $radioOptions,array('style'=>'align:right','label'=>false, 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>';?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>



</body>

</html>
<script>

		$(document).ready(function(){
			$("#submit1").click(function(){
				alert('Order Saved');
				parent.$.fancybox.close();
				});
			$("#submit2").click(function(){
				
				var specimen_type_id=$("#specimen_type_id").val();
				var collection_priority=$("#collection_priority").val();
				var collected_date=$("#collected_date").val();
				var frequency_l=$("#frequency_l").val();
				var allData=$("#allData").val();
				var splitData = allData.split('~~');
				
					  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "AddNewOrderSet","admin"=>false)); ?>"+"/"+allData;
						//alert(ajaxUrl);
								$.ajax({
									type : "POST",
									data:$('#OrderSentence').serialize(),
									url : ajaxUrl , 
									//context : document.body,
									success: function(data){
										//window.location.reload="<?php echo $this->Html->url(array("controller" => "patients", "action" => "orders")); ?>" +"/"+id+"/"+2
										location.href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "ordersentence")); ?>"+"/"+splitData[0]+"/"+splitData[1]+"/"+splitData[2]+"/"+splitData[3];
										},
									
									error: function(message){
									alert(message);
									}
									
								});
				});
$("#submit3").click(function(){
				
				var specimen_type_id=$("#specimen_type_id").val();
				var collection_priority=$("#collection_priority").val();
				var collected_date=$("#collected_date").val();
				var frequency_l=$("#frequency_l").val();
				var allData=$("#allData").val();
				var splitData = allData.split('~~');
				
					  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "AddNewOrderSet","admin"=>false)); ?>"+"/"+allData;
						//alert(ajaxUrl);
								$.ajax({
									type : "POST",
									data:$('#OrderSentence').serialize(),
									url : ajaxUrl , 
									//context : document.body,
									success: function(data){
										//window.location.reload="<?php echo $this->Html->url(array("controller" => "patients", "action" => "orders")); ?>" +"/"+id+"/"+2
										location.href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "ordersentence")); ?>"+"/"+splitData[0]+"/"+splitData[1]+"/"+splitData[2]+"/"+splitData[3];
										},
									
									error: function(message){
									alert(message);
									}
									
								});
				});
$("#submit4").click(function(){
	
	var specimen_type_id=$("#specimen_type_id").val();
	var collection_priority=$("#collection_priority").val();
	var collected_date=$("#collected_date").val();
	var frequency_l=$("#frequency_l").val();
	var allData=$("#allData").val();
	var splitData = allData.split('~~');
	
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "AddNewOrderSet","admin"=>false)); ?>"+"/"+allData;
			//alert(ajaxUrl);
					$.ajax({
						type : "POST",
						data:$('#OrderSentence').serialize(),
						url : ajaxUrl , 
						//context : document.body,
						success: function(data){
							//window.location.reload="<?php echo $this->Html->url(array("controller" => "patients", "action" => "orders")); ?>" +"/"+id+"/"+2
							location.href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "ordersentence")); ?>"+"/"+splitData[0]+"/"+splitData[1]+"/"+splitData[2]+"/"+splitData[3];
							},
						
						error: function(message){
						alert(message);
						}
						
					});
	});
			});
		
 
</script>

