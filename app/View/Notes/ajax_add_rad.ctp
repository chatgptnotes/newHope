<?php echo $this->Html->script(array('jquery.tooltipster.min.js'));
echo $this->Html->css('tooltipster.css');?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="padding-left: 45px;
    padding-top: 12px;">
	<tr>   
	<td><?php echo $this->Form->input('test_name',array('class'=>'textBoxExpnd AutoComplete','escape'=>false,'multiple'=>false,
											'label'=>false,'div'=>false,'id'=>'SelectRad1','autocomplete'=>false,'placeHolder'=>'Lab Search','style'=>'width:286px;'));
									echo $this->Form->hidden('testCode',array('id'=>'test_Code'));?></td>
		</tr>
</table>

 <div class="button_header">
 <!-- Button_section start ----->
     <div class="button_section" id="loadAll1">
		<?php foreach($getPreSelectedRad as $keyRad=>$dataRad){?>
				<div class="buttonsRad" id="<?php echo $dataRad['Radiology']['name'];?>" name="<?php echo $dataRad['Radiology']['id'];?>">
		          <a href="javascript:void(0);" class="fullNameRads tooltip" title="<?php echo $dataRad['Radiology']['name'];?>"><?php echo substr($dataRad['Radiology']['name'], 0, 8)."..";?></a> 
		         </div>
		<?php }?>
     </div>
      <!-- Button_section close ----->
 </div>
<script>
$(document).ready(function () {
	$('.tooltip').tooltipster({
 		interactive:true,
 		position:"right", 
 	});
});

$('.buttonsRad').click(function(){
	var toSaveLab=$(this).attr('id');
	if(toSaveArrayLab=="" && toSaveArrayRad==""){
		//$('#allData').html("<b>"+"Investigation"+"</b>");
	}
	var toSaveRadValue=$(this).attr('name');
	toSaveArrayRad.push(toSaveRadValue);
	getRadRate(toSaveRadValue,toSaveLab);// getCharges
	
	$('#saveDataAll').show();
});
$("#SelectRad1").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "labRadAutocomplete","Radiology",'id',"dhr_order_code","name","admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true,
	loadId : 'SelectRad1,test_Code',
	onItemSelect:function () { 
		var allData=$('#allData').html();
		var toSaveLab=$('#SelectRad1').val();
		var toSaveRadValue=$('#test_Code').val();
		toSaveArrayRad.push(toSaveRadValue);
		getRadRate(toSaveRadValue,toSaveLab);// getCharges
		$('#SelectRad1').val('');
		$('#saveDataAll').show();
	}
});
	    function getRadRate(id,name){
	    	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "notes", "action" => "getRadRate")); ?>";
	    	$.ajax({
	           	beforeSend : function() {
	           		$('#busy-indicator').show('fast');
	           	},
	           	type: 'POST',
	           	url: ajaxUrl+"/"+id,
	           	dataType: 'html',
	           	success: function(data){ 
	           		$('#busy-indicator').hide('fast');
	           	 $('#alertMsg').show();
				 $('#alertMsg').html('Radiology Added Successfully.');
				 $('#alertMsg').fadeOut(5000);
	           		
	           		$("#radTableId").find('tbody')
	        	    .append($('<tr>').attr('class', 'radClass').attr('id',"RadTr"+id)
	        	    .append($('<td>').attr('class', 'text').text(name))
	        	     .append($('<td>').attr('class', 'text').text(data))
	        	    .append($('<td>').attr('class','removeRadRow text').attr('id', 'RadRow_'+id).html('<?php echo $this->Html->image('/img/icons/cross.png',
	        	    		 array('alt' => 'Remove'));?>')));
	    	        	},
	    	  });	
	    }

	    $('.tooltip').on('mouseover',function(){
		});
	   
</script>
