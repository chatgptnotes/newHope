<?php 
/* echo $this->Html->script(array('/js/languages/jquery.validationEngine-en','jquery.validationEngine'));
echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css')); */
?>
<style>
.label_txt {
	border-right: 1px solid #4C5E64;
}
.tddate img{float:inherit;}

</style>
<!-- Right Part Template -->
<div class="inner_title">
	<h3>
		<?php echo __('Add Refused Vaccination'); ?>
	</h3>

	<div style="text-align: right;">
		<?php echo $this->Html->link(__('Back'), array('controller'=>'imunization','action' => 'index',$patient_id), array('escape' => false,'class'=>'blueBtn'));?>
	</div>

</div>
<p class="ht5"></p>
<?php 
echo $this->element('patient_information');
 echo $this->Form->create('Immunization',array('id'=>'Immunization','url'=>array('controller'=>'imunization','action'=>'refused',$patient_id),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
echo $this->Form->hidden('patient_id',array('value'=>$patient_id));
echo $this->Form->hidden('id',array());



?>
<div>&nbsp;</div>
<table width="100%" border="0" cellspacing="1" cellpadding="3"
	class="tbl">
	<table width="100%">
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td width="19%" style="padding-left:8%; font-size:13px;"><?php echo __('Vaccination :') ?><font color="red">*</font>
						</td>
						<td width="52%" align="left"><?php echo $this->Form->input('vaccine_name', array('class'=>"validate[required,custom[mandatory-enter]] textBoxExpnd",'placeholder'=>'Enter atleast 2 char' ,'type'=>'text','id' =>'vaccine_name','value'=>$this->request->data['Imunization']['cpt_description'] ));
						echo $this->Form->hidden('vaccine_type', array('type'=>'text','value' =>$this->request->data['Imunization']['vaccine_type'],'id' => 'id_vac'));?>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<table width="100%">
					<tr id="date">
						<td width="30%" style="padding-left:8%;font-size:13px;"><?php echo __('Date of administration :')?><font color="red">*</font>
						</td>
						</td>
						<td class="tddate" align="left"><?php echo $this->Form->input('date',array('class'=>'date validate[required,custom[mandatory-date]]','type'=>'text','id'=>"my_date",'autocomplete'=>'off','readonly'=>'readonly'));?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?php 
	if(!empty ($this->request->data['Immunization']['id'] )){
				$display ="block";
			}else{
				$display ="none";
		}	?>

	<div id="administered"  style= "display:<?php echo $display ;?>;">
		<table style="border: 1px solid rgb(76, 94, 100);" width="100%">
			<tr>
				<td style="padding-left:4%;font-size:13px;" class="label_txt tdLabel"><?php echo __('Vaccination/Immunization Type :')?>
				</td>
				<td width="20%" style="font-size:13px;" id="VaccinationType"><?php echo $this->request->data['Imunization']['cpt_description'] ;?></td>
			</tr>
			<tr>
				<td width="20%" style="padding-left:4%;font-size:13px;" class="label_txt tdLabel"><?php echo __('Date of administered :')?></td>
				<td id="DateAdministered" style="font-size:13px;"><?php echo $this->request->data['Immunization']['date'] ;?></td>
			</tr>
			<tr id="refusal_reason">
				<td style="padding-left:4%;font-size:13px;" class="label_txt tdLabel"><?php echo __('Reason refused :')?><font
					color="red">*</font></td>
				<td width="20%" style="padding-right:21%;font-size:13px;"><?php echo $this->Form->input('reason',array('class' =>'validate[required,custom[mandatory-select]] textBoxExpnd','empty'=>__('Please Select'),'options'=>$nipCode003));?></td>
			</tr>
			<tr style="font-size:13px; font-weight:bold; float: left; margin:0 0 0 10px;">
				<td>OPTIONAL</td>
			</tr>
			<tr>
				<td style="padding-left:4%;font-size:13px;" class="label_txt tdLabel"><?php echo __('Source :')?></td>
				<td width="20%" style="padding-right:21%;font-size:13px;"><?php echo __('Refused')?></td>
			</tr>
			<tr id='observation_date'>
				<td style="padding-left:4%;font-size:13px;" class="label_txt tdLabel"><?php echo __('VIS edition :')?></td>
				<td width="20%" style="padding-right:21%;font-size:13px;" class="tddate"><?php echo $this->Form->input('observation_date',array('class'=>'date_administered_cal textBoxExpnd','type'=>'text','id'=>"vis",'autocomplete'=>'off','readonly'=>'readonly'));?>
				</td>
			</tr>

			<tr>
				<td style="padding-left:4%;font-size:13px;" class="label_txt tdLabel"><?php echo __('Comments :')?></td>
				<td width="20%" style="padding-right:21%;font-size:13px;"><?php echo $this->Form->input('comments',array('autocomplete'=>'off', 'class'=>'textBoxExpnd'));?></td>
			</tr>
			<tr>
				<TD class="label_txt"></TD>
				<td><?php 
				echo $this->Html->link(__('Cancel'), array('controller'=>'imunization','action' => 'index',$patient_id), array('escape' => false,'class'=>'blueBtn'));
				echo $this->Form->submit('Submit',array('type'=>'submit','class'=>'blueBtn','id'=>'submit','div'=>false,'label'=>false,'onclick'=>'implodeString()'));
				?>
				</td>
			</tr>
		</table>
	</div>
</table>
<?php 
echo $this->Form->end();
?>
<script>
$(document).ready(function(){

	$("#vaccine_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Imunization",'id',"cpt_description",'null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst : false,
		minLength: 2,
		valueSelected:true,
		showNoId:true,
		loadId : 'vaccine_name,id_vac',
		select: function (event, ui) {
		    var label = ui.item.label;
		    var value = ui.item.value;
		   //store in session
		  document.valueSelectedForAutocomplete = value 
		}
	
	});
	

	jQuery("#Immunization").validationEngine({
		//alert("hi");
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	$('#submit')
	.click(
			function() { 
				//alert("hello");
				var validatePerson = jQuery("#Immunization").validationEngine('validate');
				//alert(validatePerson);
			/*	if (validatePerson) {$(this).css('display', 'none');}*/
			
			});
});


		$('#vaccine_name')
			.focusout(
				function (){
					vaccin_name = $('#vaccine_name').val();
					$('#VaccinationType').html(vaccin_name);
		});
		var firstYr = new Date().getFullYear()-100;
		var lastYr = new Date().getFullYear()+10;
		
		$(".date_administered_cal").live("click",function() {
			
			$(this).datepicker({	
						changeMonth : true,
						changeYear : true,
						yearRange: firstYr+':'+lastYr,
					//	minDate : new Date(explode[0], explode[1] - 1,
					//			explode[2]),
						dateFormat : '<?php echo $this->General->GeneralDate();?>',
						showOn : 'button',
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						onSelect : function() {
							$(this).focus();
						}
					});
		});
		
		$("#my_date").datepicker({	
			changeMonth : true,
			changeYear : true,
			yearRange: firstYr+':'+lastYr,
		//	minDate : new Date(explode[0], explode[1] - 1,
		//			explode[2]),
			dateFormat : '<?php echo $this->General->GeneralDate('');?>',
			showOn : 'button',
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			onSelect : function() {
				$(this).focus();
				$('#administered').fadeIn('slow');
				date_admin = $('#my_date').val();
				$('#DateAdministered').html(date_admin);
			}
		});
		
		$("#vis").datepicker({	
			changeMonth : true,
			changeYear : true,
			yearRange: firstYr+':'+lastYr,
		//	minDate : new Date(explode[0], explode[1] - 1,
		//			explode[2]),
			dateFormat : '<?php echo $this->General->GeneralDate('HH:II:SS');?>',
			showOn : 'button',
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			onSelect : function() {
				$(this).focus();
			}
		});
		function implodeString(){
			cptdescription = $("#cptdescription option:selected").text();
		
			var cptdescriptionLen=cptdescription.split("-"); 
		
			finString = $("#cptdescription_undefined" ).val(); 
			for(i=0; i < cptdescriptionLen.length-1; i++){
				finString = finString + "|" + $("#cptdescription_" + i).val(); 
			}
		
			$("#expString").val(finString);
		}
					
</script>
