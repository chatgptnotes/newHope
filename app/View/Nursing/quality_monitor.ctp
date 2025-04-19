<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array('jquery.fancybox-1.3.4')); ?>
<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}
</style>
<?php //echo "<pre>"; print_r($patient_details);?>
<div class="inner_title">
	<h3 style="float: left;">Quality Monitor</h3>
	<!--<div style="float: right;">
		<table width="" cellpadding="0" cellspacing="0" border="0"
			class="tdLabel2" style="color: #b9c8ca;">
			<tr>
				
				<td width="22" height="30"><?php echo $this->Html->image('icons/VAP_green.png');?>
				</td>
				<td width="80">Moderate Condition</td>
				<td width="22"><?php echo $this->Html->image('icons/VAP_yellow.png',array('width'=>'20px'));?>
				</td>
				<td width="50">Abnormal Condition</td>
				<td width="22"><?php echo $this->Html->image('icons/VAP_red.png',array('width'=>'20px'));?>
				</td>
				<td width="40">Normal Condition</td>
				<td width="22" height="30"><?php echo $this->Html->image('icons/green_tick.png');?>
				</td>
				<td width="30">Not Prescribed</td>
				<td width="22"><?php echo $this->Html->image('icons/dash.png');?>
				</td>
				<td width="100">Transfer Patient</td>
				<td width="22"><?php echo $this->Html->image('icons/nc_wo_bkgrnd.png');?>
				</td>
				<td width="30">Male</td>
				<td width="19"><?php echo $this->Html->image('icons/yellow_icon.png');?>
				</td>
				<td width="40">Female</td>
				<td width="22"><?php echo $this->Html->image('icons/red_icon.png',array('width'=>'13px'));?>
				</td>
				<td width="120">Patient Clinical Data</td>
				<td><?php echo $this->Html->link('Back',array('action'=>'index'),array('escape'=>true,'class'=>'blueBtn','style'=>'float:right;'));?>
				</td>
			</tr>
		</table>
	</div>  -->
	<div class="clr"></div>
</div>
<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">
	<tr>
		<th align="center" valign="top"
			style="text-align: center; width: 33px;">Room</th>
		<th align="center" valign="top"
			style="text-align: center; width: 55px;">Patient ID</th>
		<th align="center" valign="top"
			style="text-align: center; width: 60px;">Admi. days</th>
		<th align="center" valign="top"
			style="text-align: center; width: 77px;">Summ Status</th>
		<th align="center" valign="top"
			style="text-align: center; width: 50px;">Vent Days</th>
		<th align="center" valign="top"
			style="text-align: center; width: 50px;">Vent Mgmt</th>
		<th align="center" valign="top"
			style="text-align: center; width: 50px;">Vent Set</th>
		<th align="center" valign="top"
			style="text-align: center; width: 50px;">Red</th>
		<th align="center" valign="top"
			style="text-align: center; width: 50px;">Wean Asses</th>
		<th align="center" valign="top"
			style="text-align: center; width: 50px;">VTE Prop</th>
		<th align="center" valign="top"
			style="text-align: center; width: 50px;">GI Prop</th>
		<th align="center" valign="top"
			style="text-align: center; width: 50px;">HOB</th>
		<th align="center" valign="top"
			style="text-align: center; width: 50px;">Oral Care</th>
	</tr>
	<?php if(count($patient_details) > 0){?>
	<?php foreach($patient_details as $quality_data){ ?>
	<tr>
		<td align="left"  valign="middle" 
			style="text-align: center; "><?php echo $quality_data['Ward']['name']."-".$quality_data['Bed']['bedno']; ?></td>

		<td align="center" valign="middle" style="text-align: center;"><?php echo $quality_data['Patient']['patient_id']; ?></td>
		<td align="left" valign="middle" style="text-align: center;"><?php echo $quality_data['Patient']['total_days']; ?></td>
		<td valign="middle" style="text-align: center;"><?php echo $this->Html->image('icons/VAP_red.png',array('width'=>'20px'));?>
														<?php echo $this->Html->image('icons/VAP_green.png',array('width'=>'20px'));?>
														<?php echo $this->Html->image('icons/VAP_yellow.png',array('width'=>'20px'));?>
														
		<td valign="middle" style="text-align: center;"><?php echo $quality_data['VentilatorCheckList']['total_days']; ?></td>
		<td valign="middle" style="text-align: center;"><?php if($quality_data['VentilatorNurseCheckList']['ventilator_management'] == 0){
																switch ($quality_data['VentilatorCheckList']['vent_priority']) {
																    case 'Moderate':
																        echo $this->Html->image('icons/yellow_icon.png');
																        break;
																    case 'High':
																        echo $this->Html->image('icons/red_icon.png',array('width'=>'13px'));
																        break;
																    
																	}
																 }else{ echo $this->Html->image('icons/green_tick.png');
																 }?>
		</td>
		
		<td valign="middle" style="text-align: center;"><?php if($quality_data['VentilatorNurseCheckList']['ventilator_setting'] == 0){
																switch ($quality_data['VentilatorCheckList']['vent_setting_priority']) {
																    case 'Moderate':
																        echo $this->Html->image('icons/yellow_icon.png');
																        break;
																    case 'High':
																        echo $this->Html->image('icons/red_icon.png',array('width'=>'13px'));
																        break;
																    
																	}
																 }else{ echo $this->Html->image('icons/green_tick.png');
																 }?>
		</td>
		<td valign="middle" style="text-align: center;"><?php //echo $this->Html->image('icons/dash.png',array('width'=>'20px'));?>
														<?php echo $this->Html->image('icons/nc_wo_bkgrnd.png');?>
														<?php /*echo $this->Html->image('icons/yellow_icon.png',array('width'=>'20px'));?>
														<?php echo $this->Html->image('icons/red_icon.png',array('width'=>'13px'));?>
														<?php echo $this->Html->image('icons/green_tick.png');*/?>
		</td>
		<td valign="middle" style="text-align: center;"><?php echo $this->Html->image('icons/dash.png');?>
														<?php /*echo $this->Html->image('icons/nc_wo_bkgrnd.png',array('width'=>'20px'));?>
														<?php echo $this->Html->image('icons/yellow_icon.png',array('width'=>'20px'));?>
														<?php echo $this->Html->image('icons/red_icon.png',array('width'=>'13px'));?>
														<?php echo $this->Html->image('icons/tick.png');*/?>
		</td>
		<td valign="middle" style="text-align: center;"><?php if($quality_data['VentilatorNurseCheckList']['dvt_prophaxis'] == 0){
																switch ($quality_data['VentilatorCheckList']['vte_priority']) {
																    case 'Moderate':
																        echo $this->Html->image('icons/yellow_icon.png');
																        break;
																    case 'High':
																        echo $this->Html->image('icons/red_icon.png',array('width'=>'13px'));
																        break;
																    
																	}
																 }else{ echo $this->Html->image('icons/green_tick.png');
																 }?>
		</td>
		<td valign="middle" style="text-align: center;"><?php if($quality_data['VentilatorNurseCheckList']['pud_prophaxis'] == 0){
																switch ($quality_data['VentilatorCheckList']['gi_proph_priority']) {
																    case 'Moderate':
																        echo $this->Html->image('icons/yellow_icon.png');
																        break;
																    case 'High':
																        echo $this->Html->image('icons/red_icon.png',array('width'=>'13px'));
																        break;
																    
																	}
																 }else{ echo $this->Html->image('icons/green_tick.png');
																 }?>
		</td>
		<td valign="middle" style="text-align: center;"><?php if($quality_data['VentilatorNurseCheckList']['activity'] == 0){
																switch ($quality_data['VentilatorCheckList']['hob_priority']) {
																    case 'Moderate':
																        echo $this->Html->image('icons/yellow_icon.png');
																        break;
																    case 'High':
																        echo $this->Html->image('icons/red_icon.png',array('width'=>'13px'));
																        break;
																    
																	}
																 }else{ echo $this->Html->image('icons/green_tick.png');
																 }?>
		</td>
		<td valign="middle" style="text-align: center;"><?php if($quality_data['VentilatorNurseCheckList']['oral_care_order_set'] == 0){
																switch ($quality_data['VentilatorCheckList']['oral_care_priority']) {
																    case 'Moderate':
																        echo $this->Html->image('icons/yellow_icon.png');
																        break;
																    case 'High':
																        echo $this->Html->image('icons/red_icon.png',array('width'=>'13px'));
																        break;
																    
																	}
																 }else{ echo $this->Html->image('icons/green_tick.png');
																 }?>
														
		</td>
	</tr>

<?php }?>

</table>
<div class="clr ht5"></div>
<?php 
 }else{?>
<table width="100%" cellpadding="5" cellspacing="0" border="0"
	align="center">
	<tr>
		<td align="center">No Record Found</td>
	</tr>
</table>
<?php }?>
<!--  <table width="100%" cellpadding="5" cellspacing="0" border="0" style="background-color:#282f32;">
                   		<tr>
                       	  <td width="" class="tdLabel2"><strong>Quick Info &raquo;</strong></td>
                       	  	<td width="" class="tdLabel2"> Total</td>
                            <td width="" class="tdLabel2">booked Occupied</td> 
                            <td width="" class="tdLabel2"><strong></strong>Free</td>
                            <td width="" class="tdLabel2"><strong></strong> Maintenance</td>
                            <td width="" class="tdLabel2"><strong></strong> Waiting</td>
                            
                            <td width="" class="tdLabel2"><strong></strong> Male</td>
                            <td width="" class="tdLabel2"><strong></strong>Female</td>
                            <td>&nbsp;</td>
                        </tr>
                   </table> -->
<div class="clr">&nbsp;</div>

<div class="clr"></div>
<!-- billing activity form end here -->
<p class="ht5"></p>
<script>
jQuery(document).ready(function(){
				$('.transfer').click(function(){
				    var patient_id = $(this).attr('id') ;
					 
					$.fancybox({
			            'width'    : '80%',
					    'height'   : '80%',
					    'autoScale': true,
					    'transitionIn': 'fade',
					    'transitionOut': 'fade',
					    'type': 'iframe',
					    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "patient_transfer")); ?>"+'/'+patient_id 
				    });
					
			  });

			  $('.add-note').click(function(){
				  var patient = $(this).attr('id') ;
				  var patient_id = patient.split("-");
				  
					$.fancybox({
			            'width'    : '80%',
					    'height'   : '80%',
					    'autoScale': true,
					    'transitionIn': 'fade',
					    'transitionOut': 'fade',
					    'type': 'iframe',
					    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "patient_note")); ?>"+'/'+patient_id[1] 
				    });
			  });
});
				</script>
