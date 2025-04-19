<style>
.trShow{
background-color:#ccc;

}
.light:hover {
background-color: #F7F6D9;
text-decoration:none;
    color: #000000; 
}
</style>
<?php if(!empty($data)){?>
<table width="100%" class="formFull formFullBorder">
	
	<tr class="trShow">
		<td>Immunization</td>
		<td>Administered Amount</td>
		<td>Administration Date</td>
		<td>Vaccine Expiration Date</td>
		
	</tr>
	
	<?php 
	$config = Configure::read('karnofsky_score');
	foreach($data as $subData){ ?>
	<tr class="light" >
		<td class=""><?php echo ucfirst($subData['Imunization']['cpt_description']);?></td>
		<td class=""><?php echo $subData['Immunization']['amount'];?>&nbsp;<?php echo $subData['PhvsMeasureOfUnit']['value_code']; ?> <?php if(empty($subData['Immunization']['amount'])){echo ('Unkonwn'); } ?></td>
		<td class=""><?php echo $this->DateFormat->formatDate2Local($subData['Immunization']['date'],Configure::read('date_format'),true);?> <?php if(empty($subData['Immunization']['date'])){echo ('Unkonwn'); } ?></td>
		<td class=""><?php echo $this->DateFormat->formatDate2Local($subData['Immunization']['expiry_date'],Configure::read('date_format'),true);?> <?php if(empty($subData['Immunization']['expiry_date'])){echo ('Unkonwn'); } ?></td>
	</tr>
	<?php }?>
</table>
<?php }else{?>
<table>
	<tr>
		<td><span style="color: grey; font-size: 13px;"><?php echo __('No Record Found')?> 
		
		</td>
	</tr>
</table>
<?php }?>
<script>
$('.imu_link').click(function(){
	$.fancybox({
		'width' : '60%',
		'height' : '60%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			getImunization();
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Imunization", "action" => "index",$patientId,'InitialAssessment')); ?>",
		
	});
});
</script>