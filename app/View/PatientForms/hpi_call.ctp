<?php 
App::import('Vendor', 'fusion_charts');
echo $this->Html->script(array('/fusionwx_charts/FusionCharts','jquery.fancybox-1.3.4','jquery.autocomplete'));
echo $this->Html->css(array('ros_accordian.css','jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));
?>
<style>
.newAddedLabel {
	width: 100%;
	display: inline;
	border-bottom: 1px solid #424A4D;
	padding: 0 0 0 10px;
}

.width {
	width: 1050px;
	!
	important;
}

.myFont {
	font: 44px verdana, sans-serif;
	!
	important;
}

.myUnderLine {
	border-bottom: 1px solid #424A4D;
}

.shift {
	color: #E7EEEF;
	font-size: 13px;
	text-align: right;
}

.clear img {
	clear: both;
}

#navc,#navc ul {
	padding: 0 0 5px 0;
	margin: 0;
	list-style: none;
	font: 15px verdana, sans-serif;
	border-color: #000;
	border-width: 1px 2px 2px 1px;
	background: #374043;
	position: relative;
	z-index: 200;
}

#navc {
	height: 35px;
	padding: 0;
	width: 350px;
	margin-left: -7px;
	margin-top: 70px;
}

#navc li {
	float: left;
}

#navc li li {
	float: none;
	background: #fff;
}

* html #navc li li {
	float: left;
}

#navc li a {
	display: block;
	float: left;
	color: #fff;
	margin: 0 25px 0 10px;
	height: 35px;
	line-height: 12px;
	text-decoration: none;
	white-space: nowrap;
	font-size: 14px;
}

#navc li li a {
	height: 20px;
	line-height: 20px;
	float: none;
}

#navc ul {
	position: absolute;
	left: -9999px;
	top: -9999px;
}

* html #navc ul {
	width: 1px;
}

#navc li:hover li:hover>ul {
	left: -15px;
	margin-left: 100%;
	top: -1px;
}

#navc li:hover>ul ul {
	position: absolute;
	left: -9999px;
	top: -9999px;
	width: auto;
}

#navc li:hover>a {
	color: #fff;
}

.inter {
	display: block;
	height: 120px;
	overflow: visible;
	padding-bottom: 10px;
	padding-top: 10px;
}

.radio_check {
	border: none !important;
	padding: none !important;
}

.ros_row .radio_check label {
	margin-right: 5px !important;
}

.radio_check label {
	background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
	color: #000000 !important;
	display: block !important;
	float: left;
	text-align: left;
	width: 192px !important;
}

label {
	float: left !important;
	text-align: left !important;
	width: 217px !important;
}

.dClick {
	vertical-align: sub;
}
.inner_title span{margin: -24px 13px !important;}
</style>

<div class="inner_title">
	<h3 style="font-size: 13px; margin-left: 5px;">
		<?php  echo __('History of presenting illness'); ?>
	</h3>
	<span style="text-align: right"> <?php /*echo  $this->Html->link('Category Masters',
			array('controller'=>'templates','action'=>'template_category','?'=>array('patientId'=>$patientId,'noteId'=>$noteId,'controller'=>'PatientForms','action'=>'hpiCall')),
			array('class'=>'blueBtn','escape'=>false,'div'=>false));*/?> 
			<?php echo  $this->Html->link('Sub-category Masters',array('controller'=>'templates','action'=>'template_sub_category',
					'?'=>array('template_category_id'=>'3','patientId'=>$patientId,'noteId'=>$noteId,'controller'=>'PatientForms','action'=>'hpiCall')),
							array('class'=>'blueBtn','escape'=>false,'div'=>false));?>
			 <?php echo  $this->Html->link('Back',array('controller'=>'notes','action'=>'soapNote',$patientId,$noteId),array('class'=>'blueBtn','id'=>'submit2','div'=>false));?>
		<?php //echo  $this->Form->submit('Submit',array('type'=>'Submit','value'=>'Submit','class'=>'blueBtn','id'=>'submit','div'=>false));?>
	</span>
</div>
<?php 
echo $this->Form->create('TemplateSpeciality',array('type'=>'GET','id'=>'TemplateSpeciality','url'=>array('controller'=>'PatientForms','action'=>'hpiCall',$patientId,$noteId),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
<table style="margin: 11px 0 0;">
	<tr>
		<td><?php echo $this->Form->input('note_Template', array('id'=>'noteTemplate','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','empty'=>'Please Select','options'=>$tName,'style'=>'margin:1px 0 0 10px;','autocomplete'=>'off','value'=>$this->params->query['note_Template'])); ?>
			<?php //echo $this->Form->submit('Search',array('class'=>'blueBtn','div'=>false,'style'=>"margin: 0 0 0 10px;"));
			?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<?php 
echo $this->Form->create('',array('id'=>'TemplateTypeContent','url'=>array('controller'=>'PatientForms','action'=>'hpiCall'),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>

<p class="ht5"></p>
<?php 
if(!empty($showDialog)){?>
<table class="rose_row">
	<tr>
		<td width="30%"><span><?php echo  $this->Html->link('Use speech recognition','javascript:void(0)',array('onclick'=>'callDragon()','escape'=>false));?>

		</span>
		</td>
	</tr>
</table>
<table class="">
	<tr>
		<td class="row_format" width="100%"><?php echo $this->Form->input('',array('name'=>'data[TemplateTypeContent][freeText]',
				'type'=>'textarea','cols'=>'100','rows'=>'10','class'=>'width','value'=>stripslashes($templateTypeContent['871'])));?>
		</td>
	</tr>

</table>

<table class="rose_row">
	<tr>
		<td class="row_format"></td>
	</tr>
	<tr>
		<td class="row_format"></td>
	</tr>
	<?php 
	$g=0;
	$cnt=0;
	$i=0;
	//debug($templateTypeContent);

	$hpiCount=0;//count to check  the staus bar value table (The count increases only when the button is green)--- Pooja

	foreach($roseData as  $dataRose =>$datakey) {
if(!empty($datakey['TemplateSubCategories'])){
				$g++ ;
				$newId= "reset-input-examination".$g;
				$newName ="data[subCategory_examination][".trim($datakey['Template']['id'])."]" ;
				//	debug($templateTypeContent[$datakey['Template']['category_name']]);
				?>
	<?php 
	if($datakey['Template']['category_name']=='Headache' || $datakey['Template']['category_name']=='Description of onset of complaint'){
				$font=myFont;
				$uder='';
				}
				else {
					$font=myUnderLine;
					$uder='';
				}
				?>
	<tr class="" style="margin-top: 10px; width: 100%;">
		<td class="row_format <?php echo $font;?>" style="<?php echo $font;?>"><label><b><?php echo $datakey['Template']['category_name'].$uder; ?>
			</b> </label>
		</td>
		<?php  
		if($toggle == 0) {
				echo "<td class=''>";
				$toggle = 1;
				}else{
					echo "<td>";
					$toggle = 0;
				}

				?>
		<table width="100%" class=<?php echo 'template_category_'.$i;?>>
			<tbody id="<?php echo $datakey['Template']['id']."TemplateTable";?>">
				<tr>

					<?php 
					$selectedOptions=unserialize($templateTypeContent[$datakey['Template']['id']]);
					$patientSpecificOption=unserialize($patientSpecificTemplate[$datakey['Template']['id']]);
					/*debug($templateTypeContent[$datakey['Template']['id']]); exit;*/
					$r = 0 ;

					foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {
					//debug($subkey);
					$subCategory=$selectedOptions[$subkey['id']];
					if(empty($subCategory)){

					//when nothing selected then the default selections will be green (selected)
						if($subkey['is_default']=='1')	
						$subCategory=$subkey['is_default'];
					}
					$color ='' ;
					//if($datakey['Template']['id']==27) pr($selectedOptions) ;
					if($subCategory == '1'){
						$rosChked="checked";
						$subText=$subCategory;
						$color='palegreen';
						$hpiCount++;
						if($datakey['Template']['category_name']=='Severity & Pain Scale'){?>
					<span id='deleteSelect' style='visibility: hidden'><?php echo $dataRose.'_'.$sub?>
					</span>
					<?php 	}
					}elseif( $subCategory == '2' ){
						 $rosChked="";
						 $color='tomato';
						} else{
							 $rosChked="";
						}

						if($r%4==0) echo "</tr><tr>" ;
						?>

					<td class="radio_check" id="radiocheck"
						style="width: 100%; display: inline; border-bottom: 1px solid #424A4D; padding: 0 0 0 10px;">
						<?php 
						$name = "data[TemplateTypeContent][".$datakey['Template']['id']."][".$subkey['id']."]" ;
						if(trim($subkey['sub_category'])=='OTHER'){
					echo $this->Form->input($datakey['Template']['category_name'],array($subkey['sub_category'] ,'label' => $subkey['sub_category'],'type'=>'checkbox',
						'onclick'=>"setVal('".trim($subkey['sub_category'])."','".$newId."','".$datakey['Template']['id']."')",
						'id'=>$datakey['Template']['category_name']."_SE_".$subkey['sub_category'] ,'class'=>'rad',
						'value'=>$subCategory,'name'=>$name ,'autocomplete'=>'off','multiple'=>'checkbox'));
				}else{
				if($datakey['Template']['category_name']=='Severity & Pain Scale'){

					echo $this->Form->hidden($datakey['Template']['category_name'],array($subkey['sub_category'],'label' => $subkey['sub_category'],'type'=>'radio',
									'value'=>$subCategory,'id'=>$dataRose.'_'.$sub ,'class'=>'radNew dlbclck',
									'name'=>$name,'checked'=>$rosChked,'autocomplete'=>'off'));
					echo $this->Form->hidden('',array('type'=>'text','id'=>$dataRose.'_'.$sub.'_only'));
				}else{
					echo $this->Form->hidden($datakey['Template']['category_name'],array($subkey['sub_category'],'label' => $subkey['sub_category'],'type'=>'checkbox',
						'value'=>$subCategory,'id'=>$dataRose.'_'.$sub ,'class'=>'rad dlbclck',
						'name'=>$name,'checked'=>$rosChked,'autocomplete'=>'off','multiple'=>'checkbox'));
				}

						} ?> <?php if($datakey['Template']['category_name']=='Severity & Pain Scale'){
					$lclick='lclick';
					}else{
					$lclick='';
					}
					if(trim($subkey['sub_category']) != 'OTHER'){ ?><label class='dClick <?php echo $lclick?>'
						id='<?php echo $dataRose.'_'.$sub."_myid"?>' style=" background:<?php echo $color; ?>"><?php echo $subkey['sub_category'];?>
					</label> <?php }?>
					</td>
					<?php $display = ($subkey['sub_category'] == 'OTHER' && $rosChked == 'checked')? 'block': 'none'; ?>
					<?php $r++;
						$rowChng = $r;
						} $temp = 0;?>
					<?php foreach($patientSpecificOption as $key=>$patientOptions){?>
					<?php if($rowChng%4==0) echo "</tr><tr>" ;?>
					<td class="radio_check" id="<?php echo $datakey['Template']['id'].$temp."_removableTd"?>"
						style="width: 100%; display: inline; border-bottom: 1px solid #424A4D; padding: 0 0 0 10px;">
						<?php echo $this->Form->hidden('',array('label' => $key,'type'=>'checkbox','id'=>$datakey['Template']['id'].$temp."_patentSpecificValue",
								'value'=>$patientOptions,'name'=>"data[TemplateTypeContent][".$datakey['Template']['id']."][patient_specific_template][".$key."]",
							'checked'=>true,'autocomplete'=>'off','multiple'=>'checkbox'));?>
						<?php  if($patientOptions == 1){
							$labelColor = 'palegreen';
						}elseif($patientOptions == 2){
								$labelColor = 'tomato';
							}else$labelColor = 'white';?> <label class="changeColor1" style="background: <?php echo $labelColor;?>" id="<?php echo $datakey['Template']['id'].$temp;?>_patentSpecific">
							<?php echo $key;?> <?php echo $this->Html->image('icons/inactive.jpg',array('style'=>'float: right;','id'=>$datakey['Template']['id'].$temp."_removableTd",'class'=>'removeTd','abbr'=>$datakey['Template']['id']));?>
					</label>
					</td>

					<?php $rowChng++; $temp++;
				}
				$rowTdTempArray[$datakey['Template']['id']] = $temp;
				$rowTdArray[$datakey['Template']['id']] = $rowChng;?>
				</tr>
				<tr id="<?php echo $datakey['Template']['id'];?>ForTr">
					<td style="display:<?php echo $display; ?>" id= '<?php echo $datakey['Template']['id'];?>'><span><?php  
				echo $this->Html->link($this->Html->image('icons/plus_6.png' ),"javascript:void(0)",array(id=>'other_'.$dataRose,'onclick'=>"addButton(".$datakey['Template']['id'].")",'escape'=>false));?>
					</span> <?php echo $this->Form->input('textBox',array('type'=>'text','autocomplete'=>'off' ,id=>'other_'.$datakey['Template']['id'],));?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php 
		$subText="";
		?>
	</tr>
	<?php } $i++;?>

	<?php }?>
	<tr>
		<td class="row_format"><?php echo "HPI Related Problems Identified  "?>
		</td>
		<td><?php $options=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9',
				'10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19',
				'20'=>'20','21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30');
		echo $this->Form->input('TemplateType.hpi_identified',array('id'=>'hpiIdent','options'=>$options,'value'=>$hpiIdentified['TemplateTypeContent']['hpi_identified']));?>
		</td>
	</tr>

</table>
<?php 
echo $this->Form->hidden('Patient.patientId',array('value'=>$patientId));

echo $this->Form->hidden('TemplateType.note_template_id',array('value'=>$this->params->query['note_Template']));?>
<?php echo $this->Form->hidden('Patient.noteId',array('value'=>$noteId));?>
<?php echo $this->Form->hidden('Patient.DiagnosisId',array('value'=>$diagnosisId));?>
<table width=100%>
	<tr>
		<td style="text-align: right; width: 100%"><?php echo  $this->Form->input('Submit',array('type'=>'Submit','value'=>'Submit','class'=>'blueBtn','id'=>'submit'));?>
			<?php echo  $this->Form->end();?>
		</td>
	</tr>

</table>
<table style="border: solid 1px #000; margin: 0 0 0 10px;"
	cellspacing="0" cellpadding="0" width="67%">
	<tr>
		<td width="12%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">Type
			of History</td>
		<td width="42%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">Required
			elements</td>
		<td width="5%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">No.
			of documented elements in this doc.</td>
		<td width="5%"
			style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align: center;">Additional
			elements required to qualify</td>
		<td
			style="font-size: 11px; border-bottom: solid 1px #000; text-align: center;">Status
			Bar</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Problem focused</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Brief : 1-3</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php echo $hpiCount;?></td>
		<td id="count1"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php 
			if($hpiCount>=1){
		 echo '0';
		 $percent3='100';
		}else{
			$req=1-$hpiCount;
			echo $req;
			$percent3=($hpiCount/1)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart1">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent3.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart1", "300", "45", "0", "0", "datastring", "ledChart1"); ?>

		</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Expanded problem focused</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Brief : 1-3</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php echo $hpiCount;?></td>
		<td id="count2"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php
		 $req=3-$hpiCount;
		 if($hpiCount>=1){
		 echo '0';
		 $percent3='100';
		}else{
			$req=1-$hpiCount;
			echo $req;
			$percent3=($hpiCount/1)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart2">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent3.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart2", "300", "45", "0", "0", "datastring", "ledChart2"); ?>

		</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Detailed</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Extended: >or =4 elements of present HPI or associated
			comorbidities.(1995). >or =4 elements of present HPI or or the status
			of at least three chronic or inactive conditions.(1997)</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php echo $hpiCount;?></td>
		<td id="count3"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php 
			if($hpiCount>=4){
		 echo '0';
		 $percent4='100';
		}else{
			$req=4-$hpiCount;
			echo $req;
			$percent4=($hpiCount/4)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart3">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent4.'</value></chart>';
			?> <script> var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart3", "300", "45", "0", "0", "datastring", "ledChart3"); ?>

		</td>
	</tr>
	<tr>
		<td
			style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Comprehensive</td>
		<td
			style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;"
			valign="top">Extended: >or =4 elements of present HPI or associated
			comorbidities.(1995). >or =4 elements of present HPI or or the status
			of at least three chronic or inactive conditions.(1997).</td>
		<td class="hpiCount"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php echo $hpiCount;?></td>
		<td id="count4"
			style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;"
			valign="top"><?php
		 if($hpiCount>=4){
		 echo '0';
		 $percent4='100';
		 }
		 else{
			$req=4-$hpiCount;
			echo $req;
			$percent4=($hpiCount/4)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart4">Fusion charts</div> <?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent4.'</value></chart>';
		?> <script>var datastring = '<?php echo $strXml;?>';
			</script> <?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart4", "300", "45", "0", "0", "datastring", "ledChart4"); ?>

		</td>
	</tr>

</table>
<?php }?>
<div class="inner_title"></div>
<script>

$(document).ready(function(){

$("#Template").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	isSmartPhrase:true,
	delay:500,
	select: function(e){ }
});
	
	var noteIdClose= '<?php echo $noteIdClose; ?>';
	if(noteIdClose!=''){
		$( '#flashMessage', parent.document ).html('HPI Added Successfully');
		$( '#flashMessage', parent.document ).show();
		$( '#familyid', parent.document ).val(noteIdClose);
	  	$( '#ccid', parent.document ).val(noteIdClose);
	  	$( '#subjectNoteId', parent.document ).val(noteIdClose);
	  	$( '#assessmentNoteId', parent.document ).val(noteIdClose);
	  	$( '#objectiveNoteId', parent.document ).val(noteIdClose);
	  	$( '#planNoteId', parent.document ).val(noteIdClose);
	  	 $('#signNoteId', parent.document ).val(noteIdClose);
	  	parent.$.fancybox.close();		
	}
	
});

function renderChart(chartId,ledChart,percent){ 
	percent4 = percent ;
	datastring = '<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'+percent4+'</value></chart>';
    FusionCharts.setCurrentRenderer("JavaScript"); 
    var chart = new FusionCharts("/fusionwx_charts/HLED.swf", chartId, "300", "45", "0", "0" );
        chart.setXMLData(datastring);
        chart.setTransparent(true);
        chart.render(ledChart);  
}

 /*$(".rad").click(function() {alert('ss');
   	if($(this).attr('id')=="ConstIdOTHER")
   		 $("#"+$(this).attr('id')+'_txt').show();
   	else
   		$('#ConstIdOTHER_txt').hide('fast');
});	*/
 
$(".dClickBlocked").dblclick(function (event) { /** Red button not required for HPI (jst change class to dClick for red button ) */
    //event.preventDefault();
	 var CurrentId=$(this).attr('id');
	 $('#'+CurrentId).css({'background-color':'tomato'});
	 CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
	 $('#'+hiddenId).val('2');
	 chartCount (CurrentId);

	 
});
$(".dClick").click(function (event) {
	 var CurrentId=$(this).attr('id');		
	  CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1]; 	
	 if( $('#'+hiddenId).val().length == 0 ) {	
		    $('#'+CurrentId).css({'background-color':'palegreen'});
	 		$('#'+hiddenId).val('1');
	 		chartCount (CurrentId);	 		
	}else{ 
			$('#'+CurrentId).css({'background-color':''});
		 	$('#'+hiddenId).val('');
		 	chartCount (CurrentId);
	}
});

var finalCount = parseInt('<?php echo $i;?>');
var rSelect=0;
var rCount=0;

//BOF status bar Charts In table 
function chartCount (CurrentId) {
CurrentIdSplit=CurrentId.split('_');
var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
var quaCount1=$('#count1').html();
var quaCount2=$('#count2').html();
var quaCount3=$('#count3').html();
var quaCount4=$('#count4').html();
 	//BOF button count
 		
 		//var fruits = {};
 		for (var i=0; i <= finalCount; i++) { 
 			currentClass = 'template_category_'+i ;
	 		$('.'+currentClass).find('input[type=hidden]').each(function(index, value) {		 		
	 				val = parseInt($(this).val()); 
	 				if(!isNaN(val) && (val == 1 /*|| val==2*/) && $(this).attr('label') != 'Negative except HPI'){  
	 					rCount++;  
 					} 
 			}); 
 		} 
 		//BOF Table data count and chart draw
		if(rCount=='0'){
			$('#count1').html(1);
			$('#count2').html(1);
			$('#count3').html(4);
			$('#count4').html(4);
		} 	

	    if(quaCount1==0 && rCount>=1){
	    	var percent1='100';
			$('#count1').html('0');
			cId1=Math.ceil((Math.random() * 100) + 1); 
	    	chartId1="chart"+cId1;
	    	renderChart(chartId1,"ledChart1",percent1);
	    }else{
	    	quaCount1=1-parseInt(rCount);
			percent1=(parseInt(rCount)/1)*100;
			$('#count1').html(quaCount1);
			cId1=Math.floor((Math.random() * 100) + 1); 
	    	chartId1="chart"+cId1;
	    	renderChart(chartId1,"ledChart1",percent1);
	    }
	    if(quaCount2==0 && rCount>=1){
			var percent2='100';
			$('#count2').html('0');
			cId2=Math.ceil((Math.random() * 200) + 1); 
	    	chartId2="chart"+cId2;
	    	renderChart(chartId2,"ledChart2",percent2);
		}
		else{
			quaCount2=1-parseInt(rCount);
			percent2=(parseInt(rCount)/1)*100;
			$('#count2').html(quaCount2);
			cId2=Math.floor((Math.random() * 200) + 1); 
	    	chartId2="chart"+cId2;
	    	renderChart(chartId2,"ledChart2",percent2);				
		}
	    if(quaCount3==0 && rCount>=4){
			var percent3='100';
			$('#count3').html('0');
			cId3=Math.ceil((Math.random() * 300) + 1); 
	    	chartId3="chart"+cId3;
	    	renderChart(chartId3,"ledChart3",percent3);
		}
		else{
			quaCount3=4-parseInt(rCount);
			percent3=(parseInt(rCount)/4)*100;
			$('#count3').html(quaCount3);
			cId3=Math.floor((Math.random() * 300) + 1); 
	    	chartId3="chart"+cId3;
	    	renderChart(chartId3,"ledChart3",percent3);				
		}
	    if(quaCount4==0 && rCount>=4){
			var percent4='100';
			$('#count4').html('0');
			cId4=Math.ceil((Math.random() * 400) + 1); 
	    	chartId4="chart"+cId4;
	    	renderChart(chartId4,"ledChart4",percent4);
		}
		else{
			quaCount4=4-parseInt(rCount);
			percent4=(parseInt(rCount)/4)*100;
			$('#count4').html(quaCount4);
			cId4=Math.floor((Math.random() * 400) + 1); 
	    	chartId4="chart"+cId4;
	    	renderChart(chartId4,"ledChart4",percent4);				
		}
	    $('.hpiCount').html(rCount);
	    rCount=0;
		//EOF Table data count and chart draw
 };
	
function setVal(what,where,extra){
	if(what == 'OTHER')$('#'+extra).toggle();
	$("#"+where).val(what) ;
}
/*
$(".dClick").dblclick(function (event) {
    //event.preventDefault();
   var CurrentId=$(this).attr('id');
 $('#'+CurrentId).css({'background-color':'red'});
 CurrentIdSplit=CurrentId.split('_');
 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
 $('#'+hiddenId).val('2');

});
$(".dClick").click(function (event) {
    //event.preventDefault();
   var CurrentId=$(this).attr('id');
 $('#'+CurrentId).css({'background-color':'green'});
 CurrentIdSplit=CurrentId.split('_');
 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
 $('#'+hiddenId).val('1');

});
	*/

//***********************callDragon***************************************
function callDragon(notetype){
	$.fancybox({
		'width' : '50%',
		'height' : '50%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "dragon")); ?>"+'/'+'Template'
	});
}
//***************************************************************************************************************
var lastClickArray=new Array("sample");
var lastOut= new Array();
var lastID='';
$('.lclick1').click(function(){
	 
	var oldValue=$('#deleteSelect').html();
	if(oldValue!=''){
		$('#'+oldValue).val('');
	}
	var len =lastClickArray.length;
	lastPop=lastClickArray.pop(); 
	var curentId=$(this).attr('id');
	lastClickArray.push(curentId);
	$('.lclick').css('background-color','#FFF');
	$('#'+curentId).css('background-color','palegreen');
 	if(lastPop!='sample'){
		var lastId=lastPop.split('_');
	$('#'+lastId[0]+"_"+lastId[1]).val('');
}

});

var rowTdArray = <?php echo  json_encode($rowTdArray);?>;
var rowTdTempArray = <?php echo  json_encode($rowTdTempArray);?>;
function addButton(templateId, tableNumber){
	if(parseInt(rowTdArray[templateId])%4 == 0 ){
		$('#'+templateId+'TemplateTable tr:last').before($('<tr>').append($('<td class="radio_check newAddedLabel">')
					.attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd")
				.append($('<input>').attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecificValue').attr('value', '1').attr('type', 'hidden')
						.attr('name', 'data[TemplateTypeContent]['+templateId+'][patient_specific_template]['+$('#other_'+templateId).val()+']'))
	 		   .append($('<label>').css('background','palegreen').attr('id', tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecific')
	 		 		   .addClass('changeColor').text($('#other_'+templateId).val())
	 		 		   .append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/icons/inactive.jpg").addClass('removeTd')
	 		 		 		   .attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd").css('float', 'right').attr('abbr',templateId)))));
	}else{
		$('#'+templateId+'ForTr').prev().append($('<td class="radio_check newAddedLabel">').attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd")
			.append($('<input>').attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecificValue').attr('value', '1').attr('type', 'hidden')
					.attr('name', 'data[TemplateTypeContent]['+templateId+'][patient_specific_template]['+$('#other_'+templateId).val()+']'))
 		   .append($('<label>').css('background','palegreen').attr('id', tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecific')
 		 		   .addClass('changeColor').text($('#other_'+templateId).val())
 		 		 		.append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/icons/inactive.jpg").addClass('removeTd')
		 		 		   .attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd").css('float', 'right').attr('abbr',templateId))));
	}
	rowTdArray[templateId]++;
	rowTdTempArray[templateId]++;
	$('#other_'+templateId).val('');
	$('.NegativeExceptHPI'+tableNumber).removeClass('addClassColor');
}
$('.changeColorBlocked').on('click',function(){/** color change disabled for other butons */
	var thisId =$(this).attr('id');
	if($('#'+thisId+'Value').val() == '0'){
		$('#'+thisId+'Value').val('1')
		$(this).css('background','palegreen');
	}else if($('#'+thisId+'Value').val() == '1' || $('#'+thisId+'Value').val() == '2'){
		$('#'+thisId+'Value').val('0')
		$(this).css('background','white');
	}
});
$('.changeColorBlocked').on('dblclick',function(){/** Red button not required for HPI (jst change class to dClick for red button ) */
	var thisId =$(this).attr('id');
	if($('#'+thisId+'Value').val() != '2'){
		$('#'+thisId+'Value').val('2')
		$(this).css('background','tomato');
	}else{
		$('#'+thisId+'Value').val('0')
		$(this).css('background','white');
	}
});

$('.removeTd').on('click',function(){
	var parentId= $(this)/*.closest(' td ')*/.attr('id');
	var templateIdTd = $(this).attr('abbr');
	$('td#'+parentId).remove();
	if(parseInt(rowTdArray[templateIdTd])%4 != 0 )
	rowTdArray[templateIdTd] = parseInt(rowTdArray[templateIdTd])-1;
});
$('#noteTemplate').change(function(){
	$('#TemplateSpeciality').submit();
});
	</script>
