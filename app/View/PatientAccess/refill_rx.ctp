<?php echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js','jquery.fancybox-1.3.4'));
 echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css')); ?>
<div>&nbsp;<?php echo $this->element('portal_header');?></div>

<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Recent Activities - Patient', true); ?>
	</h3>
</div>
<?php //debug($getAllAppointments);//debug($recentallg);debug($recentproblem);debug($recentimmu);?>


	<h3 style="font-size:13px;"><?php //debug($recentmed);
		//if(in_array(2,$permit))
		{
		echo __('Last Medication Prescribed')?></a></h3>
	<div class="section">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center" valign='top'>
			<tr class="row_title">
				<td class="tdLabel" id="boxSpace">Medication</td>
				<td class="tdLabel" id="boxSpace">Route</td>
				<td class="tdLabel" id="boxSpace">Dose</td>
				<td class="tdLabel" id="boxSpace">Frequency</td>
				<td class="tdLabel" id="boxSpace">Refill Request</td>
			</tr>
			<?php foreach($recentmed as $recentmed){ ?>
			<tr class="">
				<td class="tdLabel" id="boxSpace"><?php echo $recentmed['NewCropPrescription']['description']?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $recentmed['NewCropPrescription']['route']?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $recentmed['NewCropPrescription']['dose']?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $recentmed['NewCropPrescription']['frequency']?></td>
				<td class="tdLabel" id="boxSpace">
				<?php  echo $this->Html->link($this->Html->image('icons/edit-icon.png'),"javascript:void(0)",array('onclick'=>'sendrefill('.$recentmed['NewCropPrescription']['id'].')','title'=>'Edit','alt'=>'Edit','escape' => false));?></td>
			</tr>
			<?php } ?>

		</table>
	</div><?php }?>

		</table>
	</div>
<div class = "clr"></div>
<script>
	 function sendrefill(id){
		 $.fancybox({
				'width' : '40%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'href' : "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "sendRefill")); ?>"+"/"+id,
				
			});
	 }
$(document).ready(function(){
	$( "#accordionCust" ).accordion({
	collapsible: true,
	autoHeight: false,
	clearStyle :true,

	navigation: true,
	change:function(event,ui){

	//BOF template call
	var currentEleID = $(ui.newContent).attr("id") ;
	var replacedID = "templateArea-"+currentEleID;


	}


	});
	});
			</script>
