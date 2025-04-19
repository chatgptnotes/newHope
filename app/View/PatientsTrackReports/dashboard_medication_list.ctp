<style>
.changeBackgroundNO {
	background: none repeat scroll 0 0 #CA80FE !important;
}
</style>
<?php 

if($getPreviousMedication){?>
<table cellspacing="0" cellpadding="0" border="0" class="row20px "
	id='DrugGroup' width="100%">
	<tr style="background: #31393B;">
		<td style="text-align: center; color: #DDDDDD;">Drug Name</td>
		<td style="text-align: center; color: #DDDDDD;">Qty</td>
		<td style="text-align: center; color: #DDDDDD;">Received Qty</td>
		<td style="text-align: center; color: #DDDDDD;">Units Consumed</td>
		<td style="text-align: center; color: #DDDDDD;">Administered Unit/Time</td>
		<td style="text-align: center; color: #DDDDDD;">Dose Form</td>
		<td style="text-align: center; color: #DDDDDD;">Route</td>
		<td style="text-align: center; color: #DDDDDD;">Frequency</td>
		<td style="text-align: center; color: #DDDDDD;">First Dose Date/Time</td>
		<td style="text-align: center; color: #DDDDDD;">Stop Date/Time</td>
		<td style="text-align: center; color: #DDDDDD;">Action</td>
		<td style="text-align: center; color: #DDDDDD;">Is Returned?</td>
	</tr>
	<?php 
	if(isset($getPreviousMedication) && !empty($getPreviousMedication)){
	foreach($getPreviousMedication as $s=>$dataMed){
		/*if(!$dataMed['NewCropPrescription']['pharmacy_sales_bill_id'])*/{?>
	<tr style="background-color: #DBEAF9;" id="DrugGroup<?php echo $s;?>">
		<td align="left" valign="top" style="padding-right: 3px" ><?php echo stripslashes($dataMed['NewCropPrescription']['description']); ?>
		</td>

		<td align="center" valign="top" style="padding-right: 3px" ><?php echo $dataMed['NewCropPrescription']['quantity'];?>
		</td>
		<td align="center" valign="top" style="padding-right: 3px" ><?php echo $dataMed['PharmacySalesBillDetail']['qty'];?>
		</td>
		<td align="center" valign="top" style="padding-right: 3px" ><?php echo ($medicationQuantity[$dataMed['NewCropPrescription']['id']]);?>
		</td>

		<td align="center" valign="top" style="padding-right: 3px" ><?php 
			echo implode('</br>',$countOfAdministered[$dataMed['NewCropPrescription']['id']]);?>
		</td>

		

		<td align="center" valign="top" style="padding-right: 3px" ><?php 
			$roopArray=Configure :: read('roop');
			echo $roopArray[$dataMed['NewCropPrescription']['strength']];?>
		</td>

		<td align="center" valign="top" style="padding-right: 3px" ><?php 
			$route_administrationArray=Configure :: read('route_administration');
			echo $route_administrationArray[$dataMed['NewCropPrescription']['route']];?>
		</td>

		<td align="center" valign="top" style="padding-right: 3px" ><?php 
			$frequencyArray=Configure :: read('frequency');
			echo $frequencyArray[$dataMed['NewCropPrescription']['frequency']];?>
		</td>

		<td align="center" valign="top" style="padding-right: 3px" >
		<?php echo $this->DateFormat->formatDate2Local($dataMed['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);?>
		</td>
		<td align="center" valign="top" style="padding-right: 3px" ><?php echo $this->DateFormat->formatDate2Local($dataMed['NewCropPrescription']['stopdose'],Configure::read('date_format'),true);?>
		</td>
		<td align="center" valign="top" ><?php 
			echo $this->Html->image('/img/icons/support_ticket.png',array('alt'=>'Administer','title'=>'Administer','class'=>'administerMedication','id'=>$dataMed['NewCropPrescription']['id']));
			?>
		</td>
		<td align="center" valign="top" ><?php echo $this->Form->checkbox('isreturn', array('class'=>'isreturn','id' => $dataMed['NewCropPrescription']['id'],'label'=>false,'checked'=>$prnvalue));?>
		</td>
	</tr>
	<?php } } 
}?>
</table>

<?php  }?>
<script>

$('.isreturn').on('click',function(){
	var fancyUrl = "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "returnMed", "admin" => false)); ?>"
	$.fancybox({ 
		'width':'50%',
		'height':'50%',
	    'autoScale': true, 
	    'scrolling':'auto',
	    'href': fancyUrl+'/'+parseInt($(this).attr('id')),
	    'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	true,
		'type':'iframe'
		 
    });
});

$('.administerMedication').on('click',function(){
	var fancyUrl = "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "administerMedication", "admin" => false)); ?>"
	$.fancybox({ 
		'width':'40%',
		'height':'50%',
	    'autoScale': true, 
	    'scrolling':'auto',
	    'href': fancyUrl+'/'+parseInt($(this).attr('id')),
	    'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	true,
		'type':'iframe'
		 
    });
});


										
</script>
