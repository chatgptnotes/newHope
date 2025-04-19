<?php echo $this->Html->script(array('jquery.tooltipster.min.js'));
echo $this->Html->css('tooltipster.css');?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="padding-left: 45px;
    padding-top: 12px;">
	<tr>   
	<td><?php echo $this->Form->input('test_name',array('class'=>'textBoxExpnd AutoComplete','escape'=>false,'multiple'=>false,
											'label'=>false,'div'=>false,'id'=>'test_name','autocomplete'=>false,'placeHolder'=>'Lab Search','style'=>'width:286px;'));
									echo $this->Form->hidden('testCode',array('id'=>'test_Code'));?></td>
		</tr>
</table>

<div class="button_header">
 <!-- Button_section start ----->
     <div class="button_section" id="loadAll">
			<?php foreach($getPreSelectedLab as $key=>$data){?>
			<div class="buttons" id="<?php echo $data['Laboratory']['name'];?>" name="<?php echo $data['Laboratory']['id'];?>">
			          <a href="javascript:void(0);" class="fullNameLabs tooltip" title="<?php echo $data['Laboratory']['name'];?>">
			          <?php echo substr($data['Laboratory']['name'], 0, 8)."..";?></a> 
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
$("#test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "labRadAutocomplete"
		,"Laboratory",'id',"dhr_order_code","name","admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true,
	loadId : 'test_name,test_Code',
	onItemSelect:function () { 
		var toSaveLab=$('#test_name').val();
		var toSaveLabValue=$('#test_Code').val();
		toSaveArrayLab.push(toSaveLabValue);
		getLabRate(toSaveLabValue,toSaveLab);// getCharges
		$('#test_name').val('');
		$('#saveDataAll').show();
		
	}
});

$('.tooltip').on('mouseover',function(){
});
$('.buttons').click(function(){
	var toSaveLab1=$(this).attr('id');
	var toSaveLabValue=$(this).attr('name');
	if(toSaveArrayLab=="" && toSaveArrayRad==""){
		//$('#allData').html("<b>"+"Investigation"+"</b>");
	}
	toSaveArrayLab.push(toSaveLabValue);
	getLabRate(toSaveLabValue,toSaveLab1);// getCharges
	$('#saveDataAll').show();
});
    function getLabRate(id,name){
    	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "notes", "action" => "getLabRate")); ?>";
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
    			 $('#alertMsg').html('Labs Added Successfully.');
    			 $('#alertMsg').fadeOut(5000);
           		$("#LabTableId").find('tbody')
        	    .append($('<tr>').attr('class', 'labClass').attr('id',"LabTr"+id)
        	    .append($('<td>').attr('class','text').text(name))
        	     .append($('<td>').attr('class','text').text(data))
        	    .append($('<td>').attr('class','removeLabRow text').attr('id', 'LabRow_'+id).html('<?php echo $this->Html->image('/img/icons/cross.png',
        	    		 array('alt' => 'Remove'));?>')));
    	        	},
    	  });	
    }

</script>