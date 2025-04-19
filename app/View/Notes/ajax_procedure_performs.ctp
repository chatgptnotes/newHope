<table width="100%" border="0" cellspacing="1" cellpadding="0" style="padding-left: 45px;
    padding-top: 12px;">
	<tr>   
	<td><?php echo $this->Form->input('procedure_name',array('class'=>'textBoxExpnd AutoComplete','escape'=>false,'multiple'=>false,
											'label'=>false,'div'=>false,'id'=>'procedure_name','autocomplete'=>false,'placeHolder'=>'MRI/CT Search','style'=>'width:286px;'));
									echo $this->Form->hidden('testCode',array('id'=>'code_value_mri'));?></td>
		</tr>
</table>
<script>
$("#procedure_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "MriAutocomplete","Radiology",'id',"dhr_order_code","name","admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	loadId:'procedure_name,code_value_mri',
	showNoId:true,
	valueSelected:true,
	onItemSelect:function() {
		var allData=$('#allData').html();
		var toSaveProcedure=$('#procedure_name').val();
		var toSaveProcedureValue=$('#code_value_mri').val();
		toSaveArrayProcedure.push(toSaveProcedureValue);
		getProRate(toSaveProcedureValue,toSaveProcedure);// getCharges
		$('#procedure_name').val('');
		$('#saveDataAll').show(); 
	 }		
});
function getProRate(id,name){
	
	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "notes", "action" => "getRadRate")); ?>";
	$.ajax({
       	beforeSend : function() {
       		$('#busy-indicator').show('fast');
       	},
       	type: 'POST',
       	url: ajaxUrl+"/"+id,
       	dataType: 'html',
       	success: function(data){
       		$("#procedureTableId").find('tbody')
       	    .append($('<tr>').attr('class', 'procedureClass').attr('id',"procedureTr"+id)
       	    .append($('<td>').attr('class', 'text').text(name))
       	      .append($('<td>').attr('class','text').text(data))
       	    .append($('<td>').attr('class','removeProcedureRow text').attr('id', 'procedureRow_'+id).html('<?php echo $this->Html->image('/img/icons/cross.png',
       	    		 array('alt' => 'Remove'));?>')));
       		$('#busy-indicator').hide('fast');
       	
	        	},
	  });	
}
</script>