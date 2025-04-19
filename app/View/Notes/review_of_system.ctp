<?php App::import('Vendor', 'fusion_charts');
echo $this->Html->css(array('ros_accordian.css'));
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3','/fusionwx_charts/FusionCharts'));
echo $this->Html->css(array('jquery.autocomplete.css','internal_style.css'));?>
<style>
.newAddedLabel {
	width: 100%;
	display: inline;
	border-bottom: 1px solid #424A4D;
	padding: 0 0 0 10px;
}
.addClassColor {
	background: palegreen !important;
}
.addClassWhite {
	background: white !important;
}
.addClassTomato {
	background: tomato !important;
}
.radio_check {
	border: none !important;
	padding: none !important;
}

.radio_check label {
	display: block !important;
	background: none;
	border: 1px solid #424A4D;
	float: left;
	width: 210px !important;
	text-align: left;
	color: #000 !important;
}

.row_format label {
	width: 140px !important;
	text-align: left !important;
}

label {
	float: left;
	width: 135px !important;
	font-size: 12px;
	text-align: left;
}

.inter {
	display: block;
	height: 120px;
	overflow: visible;
	padding-bottom: 10px;
	padding-top: 10px;
}

.ros_row .radio_check label {
	margin-right: 5px !important;
}

#SelectRad {
	margin: 0 0 0 32px !important;
}
.inner_title span {
    float: right;
    margin: -24px 13px !important;
    padding: 0;
}
</style>
<div class="inner_title">
	<h3 style="font-size: 13px; margin-left: 5px;">
		<?php  echo __('Review Of System'); ?>
	</h3>
	<span style="text-align: right"> <?php /*echo  $this->Html->link('Category Masters',array('controller'=>'templates','action'=>'template_category',
			'?'=>array('patientId'=>$patientId,'noteId'=>$noteId,'action'=>'reviewOfSystem')),array('class'=>'blueBtn','escape'=>false,'div'=>false));*/?>
			 <?php echo  $this->Html->link('Sub-category Masters',array('controller'=>'templates','action'=>'template_sub_category',
			 		'?'=>array('template_category_id'=>'1','patientId'=>$patientId,'noteId'=>$noteId,'action'=>'reviewOfSystem')),
						array('class'=>'blueBtn','escape'=>false,'div'=>false));?>
			<?php echo  $this->Html->link('Back',array('controller'=>'notes','action'=>'soapNote',$patientId,$noteId),
					array('class'=>'blueBtn','id'=>'submit2','div'=>false));?>
		<?php //echo  $this->Form->submit('Submit',array('value'=>'Submit','class'=>'blueBtn','id'=>'submit2','div'=>false));?><span>

</div>
<?php 
echo $this->Form->create('TemplateSpeciality',array('type'=>'GET','id'=>'TemplateSpeciality','url'=>array('controller'=>'Notes','action'=>'reviewOfSystem',$patientId,$noteId),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
<table style="margin: 11px 0 0;">
	<tr>
		<td><?php echo $this->Form->input('note_Template', array('id'=>'noteTemplate','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','options'=>$tName,'style'=>'margin:1px 0 0 10px;'/*,'multiple'=>'false','id' => 'language'*/,'empty'=>'Please Select','autocomplete'=>'off','value'=>$this->params->query['note_Template'])); ?>
			<?php  // echo $this->Form->input('language', array('empty'=>__('Select'),'options'=>$languages,'id' => 'language','style'=>'width:230px')); ?>
			
		</td>
	</tr>
	<tr>
		<td><?php //echo $this->Form->submit('Search',array('class'=>'blueBtn','div'=>false,'style'=>"margin: 11px 0 0 10px;"));
		?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>

<?php 
echo $this->Form->create('',array('id'=>'TemplateTypeContent','url'=>array('contoller'=>'notes','action'=>'reviewOfSystem'),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>



<p class="ht5"></p>
<?php if(!empty($showDialog)){?>
<table class="rose_row">
	<?php 
	$totalCount=0;
	$g=0; $i=0;$inc=0;
	$toggle= 0 ;
	foreach($rosData as  $dataRose =>$datakey) {
$inRowCount=false;
					if(!empty($datakey['TemplateSubCategories'])){
							$g++ ;
							$newId= "reset-input-examination".$g;
							$newName ="data[subCategory_examination][".trim($datakey['Template']['id'])."]" ;
							//	debug($templateTypeContent[$datakey['Template']['category_name']]);
							?>
	<tr class="" style="margin-top: 10px; width: 100%;">
		<td class="row_format" style="border-bottom: 1px solid #424A4D;"><label><b><?php echo $datakey['Template']['category_name']; ?>
			</b> </label>
		</td>
		<?php  
		
			if($toggle == 0) {
				echo "<td class=''>";
				   $toggle = 1;
			}else{
				 echo "<td>";
				       	$toggle = 0;
			} ?>
		<table width="100%" id="<?php echo $datakey['Template']['id']."TemplateTable";?>" class="<?php echo 'template_category_'.$i; ?>">
		
			<tr>
				<?php    
				$selectedOptions= unserialize($templateTypeContent[$datakey['Template']['id']]);
				$patientSpecificOption=unserialize($patientSpecificTemplate[$datakey['Template']['id']]);
				$r = 0 ;
				
				foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {
					 $subCategory=$selectedOptions[$subkey['id']];
					if(empty($subCategory)){
						if($subkey['is_default']=='1')
							//when nothing selected then the default selections will be green (selected)
							$subCategory=$subkey['is_default'];
						
					} 
					$subCategoryArray[$rosData[$dataRose]['Template']['category_name']][]=$subCategory;
					}
					
					foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {

						$subCategory=$selectedOptions[$subkey['id']];
						if($subCategory == ''){ // cond added for default selction set from master entrreis (checking blank for not submitted result)
							
							if($subkey['is_default']=='1')
								$subCategory=$subkey['is_default'];
							
								
						}
						if(strtoupper($subkey['sub_category']) == 'NEGATIVE EXCEPT HPI'){
							if($subCategory == '0'){
								$isNegaiveHpiSaved = '';
							}else{
								$isNegaiveHpiSaved = "addClassColor";
							}
						}
						$color='';
						
							if($subkey['sub_category']=='Negative except HPI'){
								$addClassColor ='addClassColor NegativeExceptHPI';
								$rosChked="checked";
	
								}
								else{
								$addClassColor = ' NotNegativeExceptHPI'.$dataRose ;
								$inputClass = ' NotNegativeExceptHPI'.$dataRose ;
								}
							
							if($subCategory == '1' ){
								if($subkey['sub_category']!='Negative except HPI')
								$inRowCount=true;
								$rosChked="checked";
								$subText=$subCategory;
								//$color='palegreen';
								$addClassColor .= " addClassColor";
							}elseif( $subCategory == '2' ){
								 $rosChked="";
								 $color='tomato';
								 $addClassColor .= " addClassTomato";
							} else{
								 $rosChked="";
								 $addClassColor .= " addClassWhite";
							}
										//	debug($dSelect);
							if($r%4==0) echo "</tr><tr>" ;
										?>
	<td class="radio_check" id="radiocheck"
			style="width: 100%; display: inline; border-bottom: 1px solid #424A4D;">
			<?php  

			//$att=array('legend'=>false,'for'=>$datakey['Template']['category_name'],'class'=>'rad','checked'=>$rosChked);
			//$name = "data[Category2][se_".$datakey['Template']['category_name']."]" ;
			$name = "data[subCategory_examination][".$datakey['Template']['id']."][".$subkey['id']."]" ;
			if(trim($subkey['sub_category'])=='OTHER'){
				//if($dataRose=='0') // for distinct option id -gaurav
				$dataRose++;// checkbox patch
				echo $this->Form->input($datakey['Template']['category_name'],array($subkey['sub_category'] ,'label' => $subkey['sub_category'],'type'=>'checkbox',
								'onclick'=>"setVal('".trim($subkey['sub_category'])."','".$newId."','".$datakey['Template']['id']."')",
								'id'=>$datakey['Template']['category_name']."_SE_".$subkey['sub_category'] ,'class'=>'rad '.$inputClass,
								'value'=>$subCategory,'name'=>$name ,'autocomplete'=>'off','multiple'=>'checkbox','hiddenField'=>false));
				$dataRose--;// checkbox end
			}else{
				echo $this->Form->hidden($datakey['Template']['category_name'],array($subkey['sub_category'],'label' => $subkey['sub_category'],'type'=>'checkbox',
							'onclick'=>"setVal('".$subkey['id']."','".$newId."','".$datakey['Template']['id']."')",
							'id'=>$dataRose.'_'.$sub,'class'=>'rad '.$inputClass,
							'value'=>$subCategory,'name'=>$name,'checked'=>$rosChked,'autocomplete'=>'off','multiple'=>'checkbox'));
			}?>
			 <?php  
			 
                  	if($subCategory == '1'){
						$addClassColor = 'addClassColor NotNegativeExceptHPI'.$dataRose;
						
					}elseif( $subCategory == '2' ){
						$addClassColor = 'addClassTomato NotNegativeExceptHPI'.$dataRose;
					} else{
						$addClassColor = 'addClassWhite NotNegativeExceptHPI'.$dataRose;
					}
					if(strtoupper($subkey['sub_category']) == 'NEGATIVE EXCEPT HPI')
						$addClassColor = "$isNegaiveHpiSaved NegativeExceptHPI".$dataRose;
			  if(trim($subkey['sub_category']) != 'OTHER'){ ?> <label class='dClick <?php echo $addClassColor;?>' id='<?php echo $dataRose.'_'.$sub."_myid"?>'  style="background:<?php echo $color; ?>">
						<?php echo $subkey['sub_category'];?>
				</label> <?php }?>
				</td>

				<?php  $display = ($subkey['sub_category'] == 'OTHER' && $rosChked == 'checked')? 'block': 'none'; $r++;?>
				<?php $rowChng = $r; } 
				if($inRowCount){
					$totalCount++;
					$inRowCount=false;
			}
			$i++;
			?>
			
			<?php  $temp = 0;?>
			<?php foreach($patientSpecificOption as $key=>$patientOptions){?>
				<?php if($rowChng%4==0) echo "</tr><tr>" ;?>
				<td class="radio_check" id="<?php echo $datakey['Template']['id'].$temp."_removableTd"?>"
					style="width: 100%; display: inline; border-bottom: 1px solid #424A4D; padding: 0 0 0 10px;">
					<?php echo $this->Form->hidden('',array('label' => $key,'type'=>'checkbox','id'=>$dataRose.'_'.$datakey['Template']['id'].$temp."_patentSpecificValue",
							'value'=>$patientOptions,'name'=>"data[subCategory_examination][".$datakey['Template']['id']."][patient_specific_template][".$key."]",
							'checked'=>true,'autocomplete'=>'off','multiple'=>'checkbox'));?>
							<?php  if($patientOptions == 1){$labelColor = 'addClassColor';}elseif($patientOptions == 2){$labelColor = 'addClassTomato';}else$labelColor = 'addClassWhite';?>
					<label class="dClick1 changeColor <?php echo 'NotNegativeExceptHPI'.$dataRose.' '.$labelColor?>" id="<?php echo $dataRose.'_'.$datakey['Template']['id'].$temp;?>_patentSpecific"> <?php echo $key;?>
					<?php echo $this->Html->image('icons/inactive.jpg',array('style'=>'float: right;','id'=>$datakey['Template']['id'].$temp."_removableTd",'class'=>'removeTd'));?>
				</label>
				</td>

				<?php $rowChng++; $temp++;
				}
				$rowTdTempArray[$datakey['Template']['id']] = $temp;
				$rowTdArray[$datakey['Template']['id']] = $rowChng;?>
			</tr>
			<tr id="<?php echo $datakey['Template']['id'];?>ForTr">
				<td style="display:<?php echo $display; ?>" id= '<?php echo $datakey['Template']['id'];?>'><span><?php  
				echo $this->Html->link($this->Html->image('icons/plus_6.png' ),"javascript:void(0)",array(id=>'other_'.$dataRose,'onclick'=>"addButton(".$datakey['Template']['id'].",".$dataRose.")",'escape'=>false));?>
				</span> <?php echo $this->Form->input('textBox',array('type'=>'text','autocomplete'=>'off' ,id=>'other_'.$datakey['Template']['id'],));?>
				</td>
			</tr>

		</table>
		<table width="100%"
			id="appendTable<?php echo $datakey['Template']['id'];?>">
			<tr>
				<td></td>
			</tr>
		</table>
		<?php 
		//echo $this->Form->hidden('',array('name'=>$newName,'id'=>$newId,'value'=>$subText,'autocomplete'=>'off'));
		$subText="";
		?>
	</tr>
	<?php }
			$inc++;	}?>
</table>

<?php echo $this->Form->hidden('',array('name'=>'noteId','value'=>$noteId,'id'=>'noteId'));?>
<?php echo $this->Form->hidden('',array('name'=>'noteIdClose','value'=>$noteIdClose,'id'=>'noteIdClose'));
	  echo $this->Form->hidden('TemplateType.note_template_id',array('value'=>$this->params->query['note_Template']));?>
<?php echo $this->Form->hidden('Patient.DiagnosisId',array('value'=>$diagnosisId));?>
<?php echo $this->Form->hidden('',array('name'=>'patientId','value'=>$patientId,'id'=>'patientId'));?>
<table width=100%>
	<tr>
		<td style="text-align: right; width: 100%"><?php echo $this->Form->submit('Submit',array('type'=>'submit','class'=>'blueBtn','id'=>'submit','div'=>false,'label'=>false));?>
			<?php echo  $this->Form->end();?>
		</td>
	</tr>

</table>

<table style="border: solid 1px #000; margin: 0 0 0 10px;" cellspacing="0" cellpadding="0" width="67%">
	<tr>
		<td width="12%" style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align:center;">Problem focused</td>
		<td width="42%" style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align:center;">N/A</td>
		<td width="5%" style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align:center;">N/A</td>
		<td width="5%" style="font-size: 11px; border-right: solid 1px #000; border-bottom: solid 1px #000; text-align:center;">N/A</td>
		<td style="font-size: 11px; border-bottom: solid 1px #000; text-align:center;">Status Bar</td>
	</tr>
	<tr>
		<td style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;" valign="top">Expanded problem focused </td>
		<td style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;" valign="top">Problem pertinent:
		<?php 
		 if(!empty($hpiIdentified['TemplateTypeContent']['hpi_identified']) || $hpiIdentified['TemplateTypeContent']['hpi_identified']!=0){
			$hpiIdCount=$hpiIdentified['TemplateTypeContent']['hpi_identified'];
		}else{
			$hpiIdCount=1;
		}?>
						system directly related to the problem(s) identified in the HPI (>=<?php echo $hpiIdCount; ?>)</td>
		<td class="hpiCount"  style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;" valign="top"><?php echo $totalCount;?></td>
		<td id="count1" style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;" valign="top"><?php 
		//The Count of problem identified in HPI form- Pooja	
		
		if($totalCount>=$hpiIdCount){
		 echo '0';
		$percent2='100';
		}else{
			$req=$hpiIdCount-$totalCount;
			echo $req;
			$percent2=($totalCount/$hpiIdCount)*100;
		}?>
		</td>
		<td style="font-size: 11px">
			<div id="ledChart1"> Fusion charts</div>
			<?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent2.'</value></chart>';
		?>
			<script> var datastring = '<?php echo $strXml;?>';
			</script>
			<?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart1", "300", "45", "0", "0", "datastring", "ledChart1"); ?>	
			
		</td>
	</tr>
	
	<tr>
		<td style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;" valign="top">Detailed </td>
		<td style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;" valign="top">
		Extended: about the system directly related to the problem(s) identified in the HPI and a limited number of additional systems (2-9).</td>
		<td class="hpiCount" style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;" valign="top"><?php echo $totalCount;?></td>
		<td id="count3" style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;" valign="top"><?php 
		if($totalCount>=2){
		 echo '0';
		 $percent3='100';
		}else{
			$req=2-$totalCount;
			echo $req;
			$percent3=($totalCount/2)*100;
		}?></td>
		<td style="font-size: 11px">
			<div id="ledChart3"> Fusion charts</div>
			<?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent3.'</value></chart>';
		?>
			<script> var datastring = '<?php echo $strXml;?>';
			</script>
			<?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart3", "300", "45", "0", "0", "datastring", "ledChart3"); ?>	
			
		</td>
		</td>
	</tr>
	<tr>
		<td style="font-size: 12px; border-right: solid 1px #000; padding: 3px 0 10px 5px;" valign="top">Comprehensive </td>
		<td style="font-size: 11px; border-right: solid 1px #000; padding: 3px 0 10px 5px;" valign="top">
			Complete: 
			System(s) directly related to the problem(s) identified in the HPI plus all additional body systems (>=10)</td>
		<td class="hpiCount"  style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;" valign="top"><?php echo $totalCount;?></td>
		<td id="count4" style="font-size: 11px; border-right: solid 1px #000; padding: 0 0 0 5px;" valign="top"><?php
		 if($totalCount>=10){
		 echo '0';
		 $percent4='100';
		 }
		else{
			$req=10-$totalCount;
			echo $req;
			$percent4=($totalCount/10)*100;
		}?></td>
		<td style="font-size: 11px">
			<div id="ledChart4"> Fusion charts</div>
			<?php $strXml='<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'.$percent4.'</value></chart>';
		?>
			<script> var datastring = '<?php echo $strXml;?>';
			</script>
			<?php echo $this->JsFusionChart->showFusionChart("/fusionwx_charts/HLED.swf", "chart4", "300", "45", "0", "0", "datastring", "ledChart4"); ?>	
			
		</td>
	</tr>

</table>
<?php }?>

<div class="inner_title" style="float:left;"></div>

<script>
			//BOF chart render
function renderChart(chartId,ledChart,percent){
	 	percent4 = percent ;
		datastring = '<chart lowerLimit="0" upperLimit="100"  palette="3" numberSuffix="%" chartRightMargin="20" useSameFillColor="1" useSameFillBgColor="1" showTickMarks="0" showLimits="0" chartBottomMargin="2" ><colorRange><color minValue="0" maxValue="50" code="FF0000" /><color minValue="50" maxValue="80" code="FFFF00" /><color minValue="80" maxValue="100" code="00FF00" /></colorRange><value>'+percent4+'</value></chart>';
    FusionCharts.setCurrentRenderer("JavaScript"); 
    var chart = new FusionCharts("/fusionwx_charts/HLED.swf", chartId, "300", "45", "0", "0" );
        chart.setXMLData(datastring);
        chart.setTransparent(true);
        chart.render(ledChart);  
	}
	//EOF chart render
$(".dClick").live('click',function (event) {
     var CurrentId = $(this).attr('id');
		CurrentIdSplit = CurrentId.split('_');
     var hiddenId = CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
        var isCurrentGreen = $('#'+CurrentId).hasClass('addClassColor');
	    if(isCurrentGreen){
	    	$('#'+CurrentId).removeClass('addClassWhite addClassTomato addClassColor');
	        $('#'+CurrentId).addClass('addClassWhite');
	        if($('#'+CurrentId).hasClass('changeColor'))
	        	$('#'+hiddenId+'_patentSpecificValue').val('');
	        else
	        	$('#'+hiddenId).val('');
        	
	    }else{
	    	$('#'+CurrentId).removeClass('addClassWhite addClassTomato addClassColor');
	        $('#'+CurrentId).addClass('addClassColor');
	        if($('#'+CurrentId).hasClass('changeColor'))
	        	$('#'+hiddenId+'_patentSpecificValue').val('1');
	        else
	        $('#'+hiddenId).val('1');
	    }
	    afterClickChange (CurrentId);
});	
$(".dClick").live('dblclick',function (event) {
     var CurrentId = $(this).attr('id');
		CurrentIdSplit = CurrentId.split('_');
     var hiddenId = CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
     var isCurrentRed = $('#'+CurrentId).hasClass('addClassTomato');
     
     if($.trim($('#'+CurrentId).html().toUpperCase()) != 'NEGATIVE EXCEPT HPI'){
         if(isCurrentRed){
        	 $('#'+CurrentId).removeClass('addClassWhite addClassTomato addClassColor');
 	        $('#'+CurrentId).addClass('addClassWhite');
 	       if($('#'+CurrentId).hasClass('changeColor'))
	        	$('#'+hiddenId+'_patentSpecificValue').val('');
	        else
	        	$('#'+hiddenId).val('');
 	    }else{
 	    	$('#'+CurrentId).removeClass('addClassWhite addClassTomato addClassColor');
 	        $('#'+CurrentId).addClass('addClassTomato');
 	       if($('#'+CurrentId).hasClass('changeColor'))
	        	$('#'+hiddenId+'_patentSpecificValue').val('2');
	        else
	        	$('#'+hiddenId).val('2');
 	    }
         afterClickChange (CurrentId);
     }
});
function afterClickChange (CurrentId){
	CurrentIdSplit = CurrentId.split('_');
 var hiddenId = CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
    chartCount (CurrentId);
    var isCheckGreen = $('.NotNegativeExceptHPI'+CurrentIdSplit[0]).hasClass('addClassColor');
    var isCheckRed = $('.NotNegativeExceptHPI'+CurrentIdSplit[0]).hasClass('addClassTomato');
    
    if( $('#'+CurrentId).hasClass('NegativeExceptHPI'+CurrentIdSplit[0]) ){
    	$('.NotNegativeExceptHPI'+CurrentIdSplit[0]).removeClass('addClassColor addClassTomato');
    	$('.NotNegativeExceptHPI'+CurrentIdSplit[0]).val('');
    	if(!$('#'+CurrentId).hasClass('addClassWhite'))
    		$('#'+hiddenId).val('1');
    	else
    		$('#'+hiddenId).val('0');
    }else{
	    if(isCheckGreen || isCheckRed ){ 
	        $('.NegativeExceptHPI'+CurrentIdSplit[0]).removeClass('addClassColor');
	        var negHpiId =  $($('.NegativeExceptHPI'+CurrentIdSplit[0]).prev()).attr('id');
	        $('#'+negHpiId).val('0');
	    }else{
	        $('.NegativeExceptHPI'+CurrentIdSplit[0]).addClass('addClassColor');
	       var negHpiId =  $($('.NegativeExceptHPI'+CurrentIdSplit[0]).prev()).attr('id');
	       $('#'+negHpiId).val('1');
	    }
    }
}	

	var rSelect=0;
	var rCount=0;
	var finalCount= parseInt('<?php echo $i;?>');
	var hpiProblem= parseInt('<?php echo $hpiIdCount; ?>');	

	//BOF status bar Charts In table 
	function chartCount (CurrentId) {
    CurrentIdSplit=CurrentId.split('_');
	var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
	var quaCount1=$('#count1').html();
	var quaCount3=$('#count3').html();
	var quaCount4=$('#count4').html();
			var fruits = {};
	 		for (i=0; i < finalCount; i++) { 
	 			currentClass = 'template_category_'+i ;
		 		$('.'+currentClass).find('input[type=hidden]').each(function(index, value) { 
		 				val = parseInt($(this).val()); 
		 				if(!isNaN(val) && (val == 1 || val==2) && $(this).attr('label') != 'Negative except HPI'){  
		 					fruits[currentClass] = 1;  
	 					} 
	 			}); 
	 		} 
	 		rCount=0;//To reset the count -- Pooja
	 		$.each(fruits,function(index,value){
		 		rCount++;
	 		});

	 		//BOF Table data count and chart draw
	 		if(rCount=='0'){
				$('#count1').html(hpiProblem);
				$('#count3').html(2);
				$('#count4').html(10);
			} 
	 		$('.hpiCount').html(rCount);
	 		if(quaCount1==0 && rCount>=hpiProblem){
					var percent1='100';
					$('#count1').html('0');
					cId1=Math.ceil((Math.random() * 100) + 1); 
			    	chartId1="chart"+cId1;
			    	renderChart(chartId1,"ledChart1",percent1);
				}
				else{
					quaCount1=hpiProblem-parseInt(rCount);
					percent1=(parseInt(rCount)/hpiProblem)*100;
					$('#count1').html(quaCount1);
					cId1=Math.floor((Math.random() * 100) + 1); 
			    	chartId1="chart"+cId1;
			    	renderChart(chartId1,"ledChart1",percent1);				
				}
			if(quaCount3==0 && rCount>=2){
					var percent3='100';
					$('#count3').html('0');
					cId3=Math.ceil((Math.random() * 300) + 1); 
			    	chartId3="chart"+cId3;
			    	renderChart(chartId3,"ledChart3",percent3);
				}
				else{
					quaCount3=2-parseInt(rCount);
					percent3=(parseInt(rCount)/2)*100;
					$('#count3').html(quaCount3);
					cId3=Math.floor((Math.random() * 300) + 1); 
			    	chartId3="chart"+cId3;
			    	renderChart(chartId3,"ledChart3",percent3);				
				}
		

			if(quaCount4==0 && rCount>=10){
					var percent4='100';
					$('#count4').html('0');
					cId4=Math.ceil((Math.random() * 400) + 1); 
			    	chartId4="chart"+cId4;
			    	renderChart(chartId4,"ledChart4",percent4);
					
				}
				else{					
					quaCount4=10-parseInt(rCount);
					percent4=(parseInt(rCount)/10)*100;
					$('#count4').html(quaCount4);
					cId4=Math.floor((Math.random() * 400) + 1); 
			    	chartId4="chart"+cId4;
			    	renderChart(chartId4,"ledChart4",percent4);					
				}
			//EOF Table data count and chart draw	
			

	}
	//EOF status bar Charts In table 
	
$(".dClick_Ros").dblclick(function (event) {
	 var CurrentId=$(this).attr('id');
	 $('#'+CurrentId).css({'background-color':'tomato'});
	 CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1]+"_";
	 $('#'+hiddenId).val('2');

});
$(".dClick_Ros").click(function (event) {
   var CurrentId=$(this).attr('id');
   CurrentIdSplit=CurrentId.split('_');
   var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1]+"_";

   if( $('#'+hiddenId).val().length == 0 ) {
		$('#'+CurrentId).addClass('addClassColor');
 		$('#'+hiddenId).val('1');
	}else{
		$('#'+CurrentId).css({'background-color':''});
	 	$('#'+hiddenId).val('');
	}

});
$(document).ready(function(){
$('#submit2').click(function(){
		$('#submit2').hide();
		$('#submit').hide();
		
		});
	$('#submit').click(function(){
		$('#submit2').hide();
		$('#submit').hide();
		
		});
	var noteIdClose= '<?php echo $noteIdClose; ?>';
	if(noteIdClose!=''){
		$( '#flashMessage', parent.document ).html('Review Of System Added Successfully');
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
function setVal(what,where,extra){ 
	if(what == 'OTHER'){
		$('#'+extra).toggle();
	} 
	$("#"+where).val(what) ;
}
$('#submit1').click(function(){
	var noteId=$('#noteId').val();
	if(noteId==''){
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "reviewOfSystem","admin" => false)); ?>"+"/"+'<?php echo $patientId?>';
	}else{
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "reviewOfSystem","admin" => false)); ?>"+"/"+'<?php echo $patientId?>'+'/'+noteId;
	}
	
	var formData = $('#TemplateTypeContent').serialize();
	  $.ajax({
      	beforeSend : function() {
      		$('#busy-indicator').show('fast');
      	},
      	type: 'POST',
      	url: ajaxUrl,
      	data: formData,
      	dataType: 'html',
      	success: function(data){
          	$( '#familyid', parent.document ).val(data);
          	$( '#ccid', parent.document ).val(data);
          	$( '#subjectNoteId', parent.document ).val(data);
          	$( '#assessmentNoteId', parent.document ).val(data);
          	$( '#objectiveNoteId', parent.document ).val(data);
          	$( '#planNoteId', parent.document ).val(data);
          	 $('#signNoteId', parent.document ).val(data);
      		$('#busy-indicator').hide('fast');
      		alert('Data Save Successfully.');
      		
	        
      },
		});
	
});

var counter=0;
		function addButton(name, id) {
			var basicName=name+"["+id+"_"+counter+"]";
			var newCostDiv = $(document.createElement('tr'))
			     .attr("id", 'appendTable' + counter);
var newHTml = '<td valign="top"><input type="text" style="width:158px!important;" value="" id="TemplateTextBox" name='+basicName+' autocomplete="off" counter='+counter+'><a href="javascript:void(0)" onclick="removeButton('+counter+','+id+')"></a></td>'; 			 			 
newCostDiv.append(newHTml);		 
newCostDiv.appendTo("#appendTable"+id);		
		 			 
counter++;
if (counter > 0)
	$('#appendTable'+id).show('slow');
}

function removeButton(counter) {
	counter--;
	$("#appendTable"+counter).remove();
}

var rowTdArray = <?php echo  json_encode($rowTdArray);?>;
var rowTdTempArray = <?php echo  json_encode($rowTdTempArray);?>;
function addButton(templateId, tableNumber){
	if(parseInt(rowTdArray[templateId])%4 == 0 ){
		$('#'+templateId+'TemplateTable tr:last').before($('<tr>').append($('<td class="radio_check newAddedLabel">')
					.attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd")
				.append($('<input>').attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecificValue').attr('value', '1').attr('type', 'hidden')
						.attr('name', 'data[subCategory_examination]['+templateId+'][patient_specific_template]['+$('input#other_'+templateId).val()+']'))
	 		   .append($('<label>').attr('id', tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecific')
	 		 		   .addClass('dClick1 changeColor addClassColor NotNegativeExceptHPI'+tableNumber).text($('input#other_'+templateId).val())
	 		 		   .append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/icons/inactive.jpg").addClass('removeTd')
	 		 		 		   .attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd").css('float', 'right').attr('abbr',templateId)))));
	}else{
		$('#'+templateId+'ForTr').prev().append($('<td class="radio_check newAddedLabel">').attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd")
			.append($('<input>').attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecificValue').attr('value', '1').attr('type', 'hidden')
					.attr('name', 'data[subCategory_examination]['+templateId+'][patient_specific_template]['+$('input#other_'+templateId).val()+']'))
 		   .append($('<label>').attr('id', tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+'_patentSpecific')
 		 		   .addClass('dClick1 changeColor addClassColor NotNegativeExceptHPI'+tableNumber).text($('input#other_'+templateId).val())
 		 		 		.append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/icons/inactive.jpg").addClass('removeTd')
		 		 		   .attr('id',tableNumber+'_'+templateId+''+rowTdTempArray[templateId]+"_removableTd").css('float', 'right').attr('abbr',templateId))));
	}
	rowTdArray[templateId]++;
	rowTdTempArray[templateId]++;
	$('input#other_'+templateId).val('');
	$('.NegativeExceptHPI'+tableNumber).removeClass('addClassColor');
	var negExceptId = $('.NegativeExceptHPI'+tableNumber).attr('id').substr(0, 3);
	$('#'+negExceptId).val(0);
}
$('.changeColorBlocked').live('click',function(){/** color change disabled for other butons */
	var thisId =$(this).attr('id');
	if($('#'+thisId+'Value').val() == '0'){
		$('#'+thisId+'Value').val('1')
		$(this).removeClass('addClassWhite addClassTomato');
		$(this).addClass('addClassColor');
	}else if($('#'+thisId+'Value').val() == '1' || $('#'+thisId+'Value').val() == '2'){
		$('#'+thisId+'Value').val('0');
		$(this).removeClass('addClassColor addClassTomato');
		$(this).addClass('addClassWhite');
	}
});
$('.changeColorBlocked').live('dblclick',function(){/** Red button not required for HPI (jst change class to dClick for red button ) */
	var thisId =$(this).attr('id');
	if($('#'+thisId+'Value').val() != '2'){
		$('#'+thisId+'Value').val('2')
		$(this).removeClass('addClassWhite addClassColor');
		$(this).addClass('addClassTomato');
	}else{
		$('#'+thisId+'Value').val('0')
		$(this).removeClass('addClassColor addClassTomato');
		$(this).addClass('addClassWhite');
	}
});

$('.removeTd').live('click',function(){
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
