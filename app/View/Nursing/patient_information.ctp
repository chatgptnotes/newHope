<style>
#busy-indicator {
	display: none;
	left: 50%;
	margin-top: 415px;
	position: absolute;
}

.interIconLink {
	min-height: 162px;
}
</style>
<div class="inner_title">
	<?php 
	$complete_name  = $patient[0]['lookup_name'] ;
	//echo __('Set Appoinment For-')." ".$complete_name;
	?>
	<h3>
		&nbsp;
		<?php echo __('Patient Information-')." ".$complete_name ?>
	</h3>
	<span style="margin-right: 123px;"><?php 
	echo $this->Html->link(__('Patient QR Card') ,'#', array('escape' => false,'title'=>'QR Card','class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'patients','action'=>'qr_card',$patient['Patient']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
	?> </span> <span><?php
	echo $this->Html->link(__('QR Medication') ,'#', array('escape' => false,'title'=>'QR Medication','class'=>'blueBtn','id'=>'qrmedication','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'patients','action'=>'qr_medication',$patient['Patient']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
	?> </span> <span style="margin-right: 254px;"> <?php
		   echo $this->Html->link(__('Search Patient'),array('action' => 'search'), array('escape' => false,'class'=>'blueBtn')); ?>
	</span>
</div>


<?php 
if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
	         echo $errorsval[0];
	         echo "<br />";
	     }
	     ?>
		</td>
	</tr>
</table>
<?php } ?>

<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div>

<div class="clr"></div>
<!-- Nursing Hub Icons Called using Element -->
<div class="internalIcon">
<?php echo $this->element('nursing_hub'); ?>
</div>
<!-- EOF Element Icons -->
<div class="inner_left" id="list_content">
	<br>
	<div class="clr ht5">&nbsp;</div>
	<div class="clr ht5">&nbsp;</div>
	<div class="clr ht5">&nbsp;</div>

</div>

<div class="clr"></div>
<?php echo $this->Js->writeBuffer();?>
<script>

jQuery(document).ready(function(){
   
			 
$("#doctorPres").click(function(){
				 
			window.location.href = "#list_content" ;
				 
			});

   });


		jQuery(document).click(function(){
                        $("a").click(function(){
                            $("form").validationEngine('hide');
                           });
		});
		
		if(($(".internalIcon > div").size())>14){ 
			//$(".internalIcon > .interIconLink:last-child").css("clear","both");
		}

</script>
