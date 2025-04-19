<?php //debug("dssdf");exit;?>
<?php

echo $this->Html->css ( array (
		'jquery.fancybox-1.3.4.css' 
) );
echo $this->Html->script ( array (
		'jquery.fancybox-1.3.4' 
) );
?>
<div class="inner_title">
	<h3>  <?php echo __('View BarCode'); ?></h3>
	<div align="right">
		<h3> <?php echo $this->Html->link(__('Back'),'/Laboratories/labDashBoard',array('escape' => false,'class'=>'blueBtn')) ; ?>
	
	
	
	
	
	</div>
</div>


<table border="1" class=" " cellpadding="0" cellspacing="0" width="100%"
	align="center" style="margin-top: 10px;">
	<tr class="row_title">
		<td align="left" class="row_title">Print</td>
		<td align="left" class="row_title">Id</td>
		<td align="left" class="row_title">Test Name</td>
		<td align="left" class="row_title">BarCode</td>
	</tr>
	<?php foreach($genratedBarcode as $data){?>
	<tr class="">
	<?php // debug($data); exit;?>
		<td align="left"><?php echo $this->Form->input('',array('type'=>'checkbox','name'=>$data['LaboratoryTestOrder']['id'],'div'=>false,'id'=>$data['LaboratoryTestOrder']['id'],'class'=>'toPrint'))?></td>
		<td align="left"><?php echo $data['LaboratoryTestOrder']['order_id'];?></td>
		<td align="left"><?php echo $data['Laboratory']['name'];?> </td>
		<td align="left"><?php echo $data['LaboratoryTestOrder']['specimen_id'];?></td>
		<?php $patientId = $data['LaboratoryTestOrder']['patient_id']; ?>
            <?php //debug($patientId); exit; ?>
	</tr>
	<?php }?>
</table>
<div style="float: right; margin-top: 10px;">
<?php

echo $this->Html->link ( 'Print', 'javascript:void(0)', array (
		'onclick' => 'printSp("' . $patientId . '")',
		'class' => 'blueBtn' 
) )?>
		
</div>
<script>
var PUSHArray=new Array();
$('.toPrint').click(function(){
	var currentId=$(this).attr('id');
	var checked = $("#"+currentId+":checked").length;
	if (checked == 0) {
		var popEle=$("#"+currentId).attr('id');
		 PUSHArray.pop(popEle);
	  } else {
		  var pushEle=$("#"+currentId).attr('id');
		  PUSHArray.push(pushEle);
	  }
});

function printSp(patientId){
	//alert($patientId);
	var str='';
	$.each(PUSHArray, function( key, value ) {
		str+=value+',';
		});
	if(str==''){
		alert('Please check atleast one checkbox.');
	}else{
		/*var url='<?php echo $this->Html->url(array("controller"=>"Laboratories","action"=>"printSp"))?>'+"/"+str;
		window.open(url); */
		//window.location.href= "<?php //echo $this->Html->url(array("controller" => "Laboratories", "action" => "printSp")); ?>'+"/"+str;
		$.fancybox({
 		'autoDimensions': false, 
    	'height': '70%',
    	'width': '70%',
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'href' : "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "printSp"))?>"+"/"+ str,
				
	});
		/*function lab(patientId) { 	
				$.fancybox({
				'width' : '60%',
				'height' : '60%',
				'autoScale': true,
				'transitionIn': 'fade',
				'transitionOut': 'fade',
				'type': 'iframe',
				'href': "<?php echo $this->Html->url(array("controller" => "Laboratories","action" => "printSp"))?>'+"/"+str;"
				 
				});

	}*/
	}
	
}


</script>
