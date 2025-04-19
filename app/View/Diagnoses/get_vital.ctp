<style>
.trShow{
background-color:#ccc;

}
.pointer{
	cursor: pointer;
}
 .light:hover {
background-color: #F7F6D9;
text-decoration:none;
    color: #000000; 
}
</style><?php // debug($getVitals);exit;?>
<?php if(!empty($getVitals)){?>
<table width="100%">
							<tr style="background-color:#ccc;height:10px;"><td></td>
							<td align="center">Latest</td><td align="center">Previous</td><td align="center">Previous</td>
							</tr>
<?php 
foreach($getVitals as $keyMeasure => $dataMeasure){?>
			<tr class="light">
					<?php if($keyMeasure=='Bmi'){?>
						<td><?php echo __('BMI')?></td>
					<?php }else{?>
						<td><?php echo $keyMeasure ?></td>
					<?php }
					if(!empty($getVitals[$keyMeasure]['0']['values'])){?>
						<td align="left"><?php echo $getVitals[$keyMeasure]['0']['values']?> <span style="color:grey;"><?php echo $getVitals[$keyMeasure]['0']['unit']?></span></td>
					<?php }else{?>
						<td align="left"></td>
					<?php }
					if(!empty($getVitals[$keyMeasure]['1']['values'])){?>
						<td align="left"><?php echo $getVitals[$keyMeasure]['1']['values']?> <span style="color:grey;"><?php echo $getVitals[$keyMeasure]['1']['unit']?></span></td>
					<?php }else{?>
						<td align="left"></td> 
					<?php } 
					if(!empty($getVitals[$keyMeasure]['2']['values'])){?>
						 <td align="left"><?php echo $getVitals[$keyMeasure]['2']['values']?> <span style="color:grey;"><?php echo $getVitals[$keyMeasure]['2']['unit']?></span></td>
					<?php }else{?>
						 <td align="left"></td> 
					<?php }?>
					
			 </tr> 
			<?php }?>
</table>
<?php }else{?>
<table>
	<tr>
		<td><span style="color: grey; font-size: 13px; padding:0 0 0 10px;"><?php echo __('No Record Found')?> 
		
		</td>
	</tr>
</table>
<?php }?>
<script>
		/*
$('#vital_link').click(function(){
	$.fancybox({
		'width' : '100%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			getvital();
		},
		'href' : "<?php // echo $this->Html->url(array("controller" => "Diagnoses", "action" => "addVital",$data['BmiResult']['patient_id'],$data['BmiResult']['id'])); ?>",
	});
});
		*/
</script>