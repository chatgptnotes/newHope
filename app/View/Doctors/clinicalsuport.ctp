<?php
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
$vals = array('Hispanic','Non-Hispanic','Latino','Others');
//debug($RD);
?>
<style>
#span_new {
	float: left;
	margin-left: 113px;
	padding: 0;
}
</style>
<div class="inner_title">
	<!-- Start for search -->
	<div align="left">

		<?php //echo $this->Form->create('clinicalsuport1',array('url'=>array('controller'=>'doctors','action'=>'clinicalsuport'),'type'=>'post','id'=>'frm1'));?>
		<?php echo $this->Form->create('ClinicalSupport',array('url'=>array('controller'=>'doctors','action'=>'clinicalsuport'),'type'=>'post'));?>
		<div>
			<h3>Clinical Decision Support intervention</h3>
		</div>
		<?php
		$name=$_SESSION['Auth']['User']['username'];
		if($name=='admin'){?>
		<div>
			<h3>Doctor Name</h3>

			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				class="formFull">
				<tr><td width="100px" valign="down"><?php  echo __('Doctor Name :')?><font color="red"> *</font></td>
					<td><h4>
							<?php //echo $this->Form->input('Doctor Name', array('empty'=>__('Select'),'options'=>$doctors_name,'id' => 'doctor','style'=>'width:180px','onChange'=>'javascript:docname()')); 
								echo $this->Form->input('Doctor Name', array('style'=>'width:280px; float:left;','class' =>'validate[required,custom[mandatory-enter]]','id'=>'doctor_id_txt','value'=>$doctors_name['ClinicalSupport']['Doctor Name'],'label'=>false,'onChange'=>'javascript:docname()'));
								//actual field to enter in db
								echo $this->Form->hidden('doctor', array('type'=>'text','id'=>'doctor'));
									?>
						</h4></td>
					
				</tr>
			</table>
		<?php }?><?php //debug($RD); ?>
		<?php echo $this->Form->hidden('dname',array('value'=>$RD['0']['ClinicalSupport']['username'] ));
		echo $this->Form->hidden('id',array('value'=>$RD['0']['ClinicalSupport']['id'] ));?>
		<?php echo $this->Form->hidden('dname_major',array('id'=>'d_name' ));?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<td style="padding-left: 10px"><h4>Please select the Intervention</h4></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
			<tr>
				<td width="20px" style="padding-left: 10px"><?php echo ("Hypertension Reminders"); ?>
				</td>
				<td width="20px"><?php if($RD['0']['ClinicalSupport']['Hyptension']==1){
					echo $this->Form->input('Hyptension', array('type' => 'checkbox','label'=>false,'checked','id'=>'hyp'));
				}
				else{
					echo $this->Form->input('Hyptension', array('type' => 'checkbox','label'=>false,'id'=>'hyp'));
					}
					?>
				</td>

				<!-- <td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=hypertension','target' => '_blank'));?>
				</td> -->
			</tr>
			<tr>
				<td width="20px" style="padding-left: 10px"><?php echo "Cervical Cancer Reminders "; ?>
				</td>
				<td><?php if($RD['0']['ClinicalSupport']['ccr']==1){
					echo $this->Form->input('ccr', array('type' => 'checkbox','label'=>false,'checked','id'=>'ccr'));
				}
				else{
						echo $this->Form->input('ccr', array('type' => 'checkbox','label'=>false,'id'=>'ccr'));
				}
				?>
				</td>
				<!-- <td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=Cervial%20Cancer','target' => '_blank'));?>
				</td> -->
			</tr>
			<tr>
				<td width="20px" style="padding-left: 10px"><?php echo "Diabetes Reminders"; ?>
				</td>
				<td><?php if($RD['0']['ClinicalSupport']['dr']==1){
					echo $this->Form->input('dr', array('type' => 'checkbox','label'=>false,'checked','id'=>'dr'));
				}
				else{
					echo $this->Form->input('dr', array('type' => 'checkbox','label'=>false,'id'=>'dr'));
					}
					?>
				</td>
				<!-- <td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=Diabetes','target' => '_blank'));?>
				</td> -->
			</tr>
			</tr>
			<tr>
				<td width="20px" style="padding-left: 10px"><?php echo __("Elderly Medication Reminders"); ?></td>
				<td><?php if($RD['0']['ClinicalSupport']['dmc']==1){
					echo $this->Form->input('dmc', array('type' => 'checkbox','label'=>false,'checked','id'=>'dmc'));
				}
				else{
					echo $this->Form->input('dmc', array('type' => 'checkbox','label'=>false,'id'=>'dmc'));
					}
					?></td>
				<!-- <td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=Elderly Medication','target' => '_blank'));?>
				</td> -->
			</tr>
			
			
			<tr>
				<td width="20px" style="padding-left: 10px"><?php echo __("Alcoholism"); ?></td>
				<td><?php if($RD['0']['ClinicalSupport']['Alcoholism']==1){
					echo $this->Form->input('Alcoholism', array('type' => 'checkbox','label'=>false,'checked','id'=>'Alcoholism'));
				}else{
					echo $this->Form->input('Alcoholism', array('type' => 'checkbox','label'=>false,'id'=>'Alcoholism'));
					}
					?></td>
				<!-- <td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=Elderly Medication','target' => '_blank'));?>
				</td> -->
			</tr>
			
			
			<tr>
				<td width="20px" style="padding-left: 10px"><?php echo __("Depression"); ?></td>
				<td><?php if($RD['0']['ClinicalSupport']['Depression']==1){
					echo $this->Form->input('Depression', array('type' => 'checkbox','label'=>false,'checked','id'=>'Depression'));
				}else{
					echo $this->Form->input('Depression', array('type' => 'checkbox','label'=>false,'id'=>'Depression'));
					}
					?></td>
				<!-- <td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=Elderly Medication','target' => '_blank'));?>
				</td> -->
			</tr>
			<tr>
				<td width="20px" style="padding-left: 10px"><?php echo __("Urinary Tract Infection"); ?></td>
				<td><?php if($RD['0']['ClinicalSupport']['Urinary']==1){
					echo $this->Form->input('Urinary', array('type' => 'checkbox','label'=>false,'checked','id'=>'Urinary'));
				}else{
					echo $this->Form->input('Urinary', array('type' => 'checkbox','label'=>false,'id'=>'Urinary'));
					}
					?></td>
				<!-- <td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=Elderly Medication','target' => '_blank'));?>
				</td> -->
			</tr>
			
			<tr>
				<td width="20px" style="padding-left: 10px"><?php echo __("Well Adult care"); ?></td>
				<td><?php if($RD['0']['ClinicalSupport']['adult_care']==1){
					echo $this->Form->input('adult_care', array('type' => 'checkbox','label'=>false,'checked','id'=>'adult_care'));
				}else{
					echo $this->Form->input('adult_care', array('type' => 'checkbox','label'=>false,'id'=>'adult_care'));
					}
					?></td>
				<!-- <td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=Elderly Medication','target' => '_blank'));?>
				</td> -->
			</tr>
			
			<tr>
				<td width="20px" style="padding-left: 10px"><?php echo __("Risky sexual behaviour"); ?></td>
				<td><?php if($RD['0']['ClinicalSupport']['risky_sex']==1){
					echo $this->Form->input('risky_sex', array('type' => 'checkbox','label'=>false,'checked','id'=>'risky_sex'));
				}else{
					echo $this->Form->input('risky_sex', array('type' => 'checkbox','label'=>false,'id'=>'risky_sex'));
					}
					?></td>
				<!-- <td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=Elderly Medication','target' => '_blank'));?>
				</td> -->
			</tr>
			
			<tr>
				<td width="20px" style="padding-left: 10px"><?php echo __("Prescription Drug Abuse"); ?></td>
				<td><?php if($RD['0']['ClinicalSupport']['drug_abuse']==1){
					echo $this->Form->input('drug_abuse', array('type' => 'checkbox','label'=>false,'checked','id'=>'drug_abuse'));
				}else{
					echo $this->Form->input('drug_abuse', array('type' => 'checkbox','label'=>false,'id'=>'drug_abuse'));
					}
					?></td>
				<!-- <td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=Elderly Medication','target' => '_blank'));?>
				</td> -->
			</tr>
			
			<!--  <tr>
				<td width="20px"><?php echo "Consolidated Reminders"; ?>
				</td>
				<td><?php if($RD['0']['ClinicalSupport']['conso']==1){
					echo $this->Form->input('conso', array('type' => 'checkbox','label'=>false,'checked'));
				}
				else{
					echo $this->Form->input('conso', array('type' => 'checkbox','label'=>false,'id'=>'conso'));
					}
					?>
				</td>
				<td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncbi.nlm.nih.gov/pubmed/clinical?term=amitriptyline','target' => '_blank'));?>
				</td>
			</tr> -->
			<?php //echo __('hdaljs');?>
			<tr>
				<td width="20px"><?php echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));	?>	</td>
			</tr>
			<tr>
				<td><?php echo $this->Form->end(); ?> <?php //echo $this->Form->submit(__('Submit', true),array('controller'=>'doctors','action' => 'clinicalsuport'), array('escape' => false,'class'=>'grayBtn'));?>
				</td>
			</tr>

		</table> 
<?php //if($name!='admin'){/* debug($_SESSION); */ echo $this->Html->link('Configuration',array('controller' => 'doctors', 'action' => 'config',$_SESSION['Auth']['User']['username']));}?>
	</div>
</div>

<script>
$(document).ready(function(){
	jQuery("#ClinicalSupportClinicalsuportForm").validationEngine({
	validateNonVisibleFields: true,
	updatePromptsPosition:true,
	});
	$('#submit')
	.click(
	function() { 
	//alert("hello");
	var validatePerson = jQuery("#ClinicalSupportClinicalsuportForm").validationEngine('validate');
	//alert(validatePerson);
	if (validatePerson) {$(this).css('display', 'none');}
	return false;
	});
	});
					
function createTitle(data){
	 var options = '';
	  $.each(data, function(index, name) {
	  options +=name.ClinicalSupport.username +','+ name.ClinicalSupport.Hyptension +','+ name.ClinicalSupport.ccr +','+  name.ClinicalSupport.dr+',' 
	  + name.ClinicalSupport.dmc +',' +name.ClinicalSupport.conso +','+ name.ClinicalSupport.Alcoholism +','+ name.ClinicalSupport.Depression +','+ name.ClinicalSupport.Urinary +','
	  + name.ClinicalSupport.adult_care +','+ name.ClinicalSupport.risky_sex +','+ name.ClinicalSupport.drug_abuse ;
		 });
	 return options;
	 }

function docname(){
	var doc= $("#doctor option:selected").text();

	 $("#d_name").val(doc);
	 
	  //========================ajax reff=====================================================================
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "doctors", "action" => "remindersSchedule","admin"=>false)); ?>"+"/"+doc;
//alert(ajaxUrl);
		$.ajax({
			type : "POST",
			url : ajaxUrl , 
			context : document.body,
			success: function(data){

				//data1 = JSON && JSON.parse(data1) || $.parseJSON(data1);
				data = JSON && JSON.parse(data) || $.parseJSON(data);
				//alert(data);
				titleData = createTitle(data);
				//alert(titleData);
				var n=titleData.split(",");
				//alert(n);
				var Hyptension = n[1];
				//alert(Hyptension);
				var ccr = n[2];
				//alert(ccr);
				var dr = n[3];
				//alert(dr);
				var dmc = n[4];
				//alert(dmc);
				var conso = n[5];

				var Alcoholism = n[6];
				var Depression = n[7];
				var Urinary = n[8];
				var adult_care = n[9];
				var risky_sex = n[10];
				var drug_abuse = n[11];
				
				//SctCode = data.SctCode;
				//CptCode = data.CptCode;
				if(Hyptension=='1'){
				//	alert(Hyptension);
				//document.getElementById("hyp").checked = true;
				$('#hyp').attr('checked','checked');
				}
				else{
					$('#hyp').attr('checked',false);
				}
				
				if(ccr=='1'){
					//document.getElementById("ccr").checked = true;
					$('#ccr').attr('checked','checked');
					}
				else{
					$('#ccr').attr('checked',false);
				}
				if(dr=='1'){
					//document.getElementById("dr").checked = true;
					$('#dr').attr('checked','checked');
					}
				else{
					$('#dr').attr('checked',false);
				}
				if(dmc=='1'){
					//document.getElementById("dmc").checked = true;
					$('#dmc').attr('checked','checked');
					}
				else{
					$('#dmc').attr('checked',false);
				}

				if(Alcoholism=='1'){
					//document.getElementById("dmc").checked = true;
					$('#Alcoholism').attr('checked','checked');
					}
				else{
					$('#Alcoholism').attr('checked',false);
				}

				if(Depression=='1'){
					//document.getElementById("dmc").checked = true;
					$('#Depression').attr('checked','checked');
					}
				else{
					$('#Depression').attr('checked',false);
				}

				if(Urinary=='1'){
					//document.getElementById("dmc").checked = true;
					$('#Urinary').attr('checked','checked');
					}
				else{
					$('#Urinary').attr('checked',false);
				}

				if(adult_care=='1'){
					//document.getElementById("dmc").checked = true;
					$('#adult_care').attr('checked','checked');
					}
				else{
					$('#adult_care').attr('checked',false);
				}

				if(risky_sex=='1'){
					//document.getElementById("dmc").checked = true;
					$('#risky_sex').attr('checked','checked');
					}
				else{
					$('#risky_sex').attr('checked',false);
				}

				if(drug_abuse=='1'){
					//document.getElementById("dmc").checked = true;
					$('#drug_abuse').attr('checked','checked');
					}
				else{
					$('#drug_abuse').attr('checked',false);
				}

				},
			
			error: function(message){
			alert(message);
			}
			
		});
		//==========================================================================================================
	
		}	
$(document).ready(function(){
    $("#doctor_id_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'doctor_id_txt,doctor'
		});
});
</script>
