<?php 
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3'));
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css','internal_style.css'));
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Email recipient selection', true); ?>
	</h3>
</div>
<?php echo $this->Form->create('',array('action'=>'','id'=>'recipentfrm'));?>
<div class="inner_left">
	<?php echo $this->element('patient_information');?>
</div>
<div>&nbsp;</div>
<table border="0" class="" cellpadding="0" cellspacing="0" width="650px"
	align="center">
	<tbody>
		<tr class="row_title">
			<td width="35%" class=""><label style="width: 100%"><?php echo __('Choose form your recipient list') ?>
					:</label></td>
			<td class=""><?php 
			echo $this->Form->input('docName', array('id' => 'docName', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'value'=>''));
			?>
			</td>

			<td class=""><?php 
			echo $this->Form->input('categoryName', array('empty'=>__('(Filter by specialty)'),'options'=>$listDepartment,'type'=>'select','id' => 'recipetient_id', 'onchange'=>'sreachByCat()','label'=> false, 'div' => false, 'error' => false,'style'=>'width:170px'));
			?>
			</td>

		</tr>

	</tbody>
</table>
<div > &nbsp;</div>
<div id='allData'>
	<table border="0" class="" cellpadding="0" cellspacing="0" width="100%"
		align="center">
		<tbody>
			<?php 
			$toggle =0;
			
			if(count($listDoctor) > 0) {
				      		foreach($listDoctor as $key=> $docList){
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							       ?>
			<td class="row_format" align="left"><?php  echo $this->Html->image('/img/icons/patient.png',
					 array('alt' => 'Doctor')).'recipient:'.$this->Form->checkbox('',array('name'=>'DocName_'.$key,'id'=>'docId'.$key,'class'=>'reciptients','value'=>$docList['User']['id']));?>
			</td>
			<td class="row_format" align="left"><?php echo $docList['DoctorProfile']['doctor_name'].'('. $docList['DoctorProfile']['specility_keyword'].')';?>
			</td>
			<td class="row_format" align="left"><?php echo $docList['User']['email'];?>
			</td>
			</tr>
			<?php }
}
?>
	<tr>
	<td class="row_format" align="right" colspan='3'><?php echo $this->Form->input('Add to recipient list',array('type'=>'button','label'=>false,'id'=>'addToList'));?>
	</td>
	</tr>
	</table>
</div>
<div id='filterData' style='display: none'></div>
<script>
function sreachByCat(){
	var patientId=<?php echo $id?>;
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Messages", "action" => "searchCateDoctor","admin"=>false)); ?>";
	  var recipetient_id=$("#recipetient_id option:selected").text();	
			$.ajax({
				type : "POST",
				url : ajaxUrl+"/"+recipetient_id+"/"+patientId, 
				beforeSend:function(){
					$('#busy-indicator').show('fast');
              },
				success: function(data){
					$("#allData").hide();
					$("#filterData").html(data);
					$("#filterData").show();
				},
				error: function(message){
				alert(message);
				}
				
			});
}
$("#docName").focus(function searchByName (){
	 var doc_name=$("#docName").val();	
	 var patientId=<?php echo $id?>;
		if(doc_name==''){
			return;
		}
		
				  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Messages", "action" => "searchByName","admin"=>false)); ?>";
				  //alert(doc_name);
				 
						$.ajax({
							type : "POST",
							url : ajaxUrl+"/"+doc_name+"/"+patientId,  
							beforeSend:function(){
								$('#busy-indicator').show('fast');
			            },
							success: function(data){
								$("#allData").hide();
								$("#filterData").html(data);
								$("#filterData").show();
							},
							error: function(message){
							alert(message);
							}
							
						});
      
});
$(document).ready(function(){
	 
	$("#docName").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","DoctorProfile","doctor_name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		loadId : 'doctor_name,doctor_name'
				});
	});
	$('#addToList').click(function(){
		
 	    var  icd_text='' ;
		var icd_ids = $( '#icd_ids', parent.document ).val();	
		var icd_code='';
 		$("input:checked").each(function(index) { 
 		
 			 if($(this).attr('name') != 'undefined'){	
 				 icd_code  += $(this).val()+"|";
		    }
 			
		});
 		window.top.location = '<?php echo $this->Html->url("/recipients/referral_preview_action/null"); ?>'+"/"+'<?php echo $id;?>'+"/"+icd_code;  		
 		
 	});
</script>
