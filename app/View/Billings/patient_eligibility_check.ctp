<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));?>
<style>
.styleclass {
	width: 150px;
	text-align: left;
	height: 20px;
}
</style>
<?php //echo $this->element('patient_information');/* debug($patient); */?>
<div class="inner_title">
	<h3>
		<?php echo __('Patient Insurance Eligibility and Benefit Check');?>
	</h3>
</div>

<table style="width: 50%">
	<tr>
		<td class="styleclass tdLabel"><input type="submit" value="Check Eligibility" name="Check Eligibility" id="check_eligibility" class="blueBtn"></td>
		<td  class="styleclass tdLabel"></td>
		<td  class="styleclass tdLabel"></td>
		<td  class="styleclass tdLabel"></td>
	</tr>
	<tr>	
		<td class="styleclass tdLabel"><?php echo __("Patient Name"); ?></td>
		<td class="styleclass tdLabel"><?php echo $this->Form->input('patient_name',array('label'=>false,'id'=>'lookup','value'=>''));?>
		<?php echo $this->Form->hidden('',array('label'=>false,'id'=>'patient_id','name'=>'patient_id','value'=>''));?></td>
		<td  class="styleclass tdLabel"></td>
		<td  class="styleclass tdLabel"></td>
	</tr>
	
	<tr>
		<td class="styleclass tdLabel"><?php echo __("Deductible"); ?></td>
		<td class="styleclass tdLabel"><?php echo $this->Form->input('Deductible',array('type'=>'text','label'=>false)); ?></td>
		
		<td class="styleclass tdLabel"><?php echo __("Deductible Counter"); ?></td>
		<td class="styleclass tdLabel"><?php echo $this->Form->input('Deductible',array('type'=>'text','label'=>false)); ?></td>
	</tr>

	<tr>
		<td class="styleclass tdLabel"><?php echo __("Co-Pay amount"); ?></td>
		<td class="styleclass tdLabel"><?php echo $this->Form->input('Deductible',array('type'=>'text','label'=>false)); ?></td>
		
		<td class="styleclass tdLabel"><?php echo __("Service Type"); ?><font color='red'>*</font></td>
		<td class="styleclass tdLabel"><?php echo $this->Form->input('Billing.service_type',array('id'=>'service_type','empty'=>'Select','options'=>$opt,'legend'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter-only]]'));?></td>
	</tr>

	<tr>
		<td class="styleclass" colspan="2" align="left">&nbsp;</td>
	</tr>

	<!-- <tr>
		<td class="styleclass" colspan="2" align="left"><input type="submit"
			value="Save Demographics" name="Save Demographics"
			id="save_emographics" class="blueBtn"> <input type="submit"
			value="Save & Close" name="" Save & Close"" id="save_close"
			class="blueBtn">
		</td>
	</tr> -->

</table>
<?php //debug($patient);
//==============================================================
$expName=explode(" ",$patient[0]['lookup_name']);

$expdob=explode("-",$patient['Person']['dob']);
$strDob=$expdob[1].'/'.$expdob[2].'/'.$expdob[0];
//='&Data='.$_SESSION['location'];
	/* 	var url='https://eligibilityapi.zirmed.com/1.0/Rest/Gateway/GatewayAsync.ashx?UserID=drmhope82108&Password=zirmed123&DataFormat=SF1&ResponseType=HTML';
		var url+='&Data='.$_SESSION['location'];// hopital name
		var url+='|'.$zermidData['InsuranceCompany']['name'];// insurance co name
		var url+='|'."H333224444";//insuredID
		var url+='|'.$expName[1];// surname
		var url+='|'.$expName[2];//name
		var url+='|'.$strDob;//dob
		var url+='|'."S";// type 
		var url+='|'."";
		var url+='|'.Date('m/d/Y');// date of service range
		var url+='|'."30";
		var url+='|'."";
		var url+='|'."61101";//  PayerId
		var url+='|'."";
		var url+='|'."1";
		var url+='|'."1P";
		var url+='|'."";
		var url+='|'."";
		var url+='|'."987654321";
		var url+='|'."";
		var url+='|'."HPI-1234567890"; */
		
		/* $ch = curl_init();

        // set url
        //debug(var url);
        curl_setopt($ch, CURLOPT_URL,var url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);       */
?>
<script>


$('#check_eligibility').click(function(){
	var opt= $('#service_type').val();
	
	if(opt==''){
		alert('Please select service type.' );
		return false;
	}
	var url='https://eligibilityapi.zirmed.com/1.0/Rest/Gateway/GatewayAsync.ashx?UserID=drmhope82108&Password=zirmed123&DataFormat=SF1&ResponseType=HTML';
	 url+='&Data='+'<?php echo $_SESSION['location'];?>'// hopital name
	url+='|'+'<?php echo $zermidData['InsuranceCompany']['name'];?>'// insurance co name
	url+='|'+"H333224444";//insuredID
	 url+='|'+'<?php echo $expName[1];?>'// surname
	 url+='|'+'<?php echo $expName[2];?>'//name
	 url+='|'+'<?php echo $strDob;?>'//dob
	 url+='|'+"S";// type 
	 url+='|'+"";
 url+='|'+'<?php echo Date('m/d/Y');?>'// date of service range
 url+='|'+opt;
	 url+='|'+"";
 url+='|'+"33333";//  PayerId
	 url+='|'+"";
	 url+='|'+"1";
	 url+='|'+"1P";
	 url+='|'+"";
	 url+='|'+"";
	 url+='|'+"987654321";
	 url+='|'+"";
	 url+='|'+"HPI-1234567890";
			$.fancybox({
				'width' : '80%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'href' : url,
	
			});
});
$(document).ready(function(){
	/*$("#lookupname").autocomplete("<?php //echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Patient","lookup_name",'id','null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		loadId:'lookupname,patient_id'
	});*/
	$("#lookup").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Patient","id","lookup_name","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		valueSelected:true,
   	    showNoId:true,
		//selectFirst: true,
		loadId : 'lookup,patient_id'
		});
});
/* $("#service_type").autocomplete("<?php //echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffStandard","name", "admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true
}); */
</script>
