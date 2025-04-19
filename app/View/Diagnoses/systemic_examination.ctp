<?php echo $this->Html->css(array('ros_accordian.css'));
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3'));
echo $this->Html->css(array('jquery.autocomplete.css','internal_style.css'));?>
 <style>
 .myFont{
font: 44px verdana, sans-serif; !important;
}
.myUnderLine{
border-bottom: 1px solid #424A4D;
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

}
#SelectRad {
	margin: 0 0 0 32px !important;
}
</style>
<?php 
echo $this->Form->create('TemplateTypeContent',array('id'=>'TemplateTypeContent','url'=>array('controller'=>'Diagnoses','action'=>'systemicExamination',$patientId,$diagnosesId),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
		?>
       
<div class="inner_title">
	<h3 style="font-size:13px; margin-left: 5px;">
		<?php  echo __('Physical Examination'); ?>
	</h3>
	<span><?php echo  $this->Form->submit('Submit',array('value'=>'Submit','class'=>'blueBtn'));?></span>
</div>
<p class="ht5"></p>       
<table class="rose_row">
  
	<?php 
	
		$g=0;
		$toggle= 0 ;
	foreach($roseData as  $dataRose =>$datakey) {
				$g++ ;
				$newId= "reset-input-examination".$g;
				$newName ="data[subCategory_examination][".trim($datakey['Template']['id'])."]" ;
				//	debug($templateTypeContent[$datakey['Template']['category_name']]);
				?>
<?php 
	if($datakey['Template']['category_name']=='Gynecologic')
				$font=myFont;
				else 
					$font=myUnderLine;
?>
	<tr class="" style="margin-top: 10px; width: 100%;">
		<td class="row_format <?php echo $font;?>" style="<?php echo $font;?>"><label><b><?php echo $datakey['Template']['category_name'] ?>
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
			<table width="100%">
			<tr>
		<?php 
		$selectedOptions= unserialize($templateTypeContent[$datakey['Template']['id']]);
		
		$r = 0 ;
		foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {
						$subCategory=$selectedOptions[$subkey['id']];
						$color ='' ;
						//if($datakey['Template']['id']==27) pr($selectedOptions) ;
						if($subCategory == '1' ){
				$rosChked="checked";
				$subText=$subCategory;
				$color='palegreen';
			}elseif( $subCategory == '2' ){
				 $rosChked="";
				 $color='tomato';
				} else{
			 $rosChked="";
		}
		
		
		
		if($r%4==0) echo "</tr><tr>" ;
		?>
		
		<td class="radio_check" id="radiocheck" 
					style="width: 100%; display: inline; border-bottom: 1px solid #424A4D;">
					<?php  

					//$att=array('legend'=>false,'for'=>$datakey['Template']['category_name'],'class'=>'rad','checked'=>$rosChked);
					//$name = "data[Category2][se_".$datakey['Template']['category_name']."]" ;
					$name = "data[subCategory_examination][".$datakey['Template']['id']."][".$subkey['id']."]" ;
					if(trim($subkey['sub_category'])=='OTHER'){
							echo $this->Form->input($datakey['Template']['category_name'],array($subkey['sub_category'] ,'label' => $subkey['sub_category'],'type'=>'checkbox',
											'onclick'=>"setVal('".trim($subkey['sub_category'])."','".$newId."','".$datakey['Template']['id']."')",
											'id'=>$datakey['Template']['category_name']."_SE_".$subkey['sub_category'] ,'class'=>'rad',
											'value'=>$subCategory,'name'=>$name ,'autocomplete'=>'off','multiple'=>'checkbox'));
						}else{
							echo $this->Form->hidden($datakey['Template']['category_name'],array($subkey['sub_category'],'label' => $subkey['sub_category'],'type'=>'checkbox',
									'onclick'=>"setVal('".$subkey['id']."','".$newId."','".$datakey['Template']['id']."')",
									'id'=>$dataRose.'_'.$sub,'class'=>'rad',
									'value'=>$subCategory,'name'=>$name,'checked'=>$rosChked,'autocomplete'=>'off','multiple'=>'checkbox'));
						}
						?> <?php if(trim($subkey['sub_category']) != 'OTHER'){ ?> <label class='dClick'
			id='<?php echo $dataRose.'_'.$sub."_myid"?>' style="background:<?php echo $color; ?>"><?php echo $subkey['sub_category'];?>
				</label> <?php }?>
				</td>
		<?php $display = ($subkey['sub_category'] == 'OTHER' && $rosChked == 'checked')? 'block': 'none';   $r++; } 
		
		?>
		</td>
		</tr>
		<tr>
		<td style="display:<?php echo $display; ?>" id= '<?php echo $datakey['Template']['id'];?>'><span><?php  
			echo $this->Html->link($this->Html->image('icons/plus_6.png' ),"javascript:void(0)",array('name'=>'data[subCategory_examination][textbox2]',id=>'other_'.$dataRose,'onclick'=>"addButton('data[subCategory_examination][textbox2]',".$datakey['Template']['id'].")",'escape'=>false));?></span>
			<?php echo $this->Form->input('textBox',array('type'=>'text','name'=>"data[subCategory_examination][textbox2][".$datakey['Template']['id']."]",'autocomplete'=>'off' ));?>
		</td>
		</tr>
		</table>
		<table width="100%" id="appendTable<?php echo $datakey['Template']['id'];?>">
		<tr>
			<td></td>
			</tr>
		</table>
		<?php 
		//echo $this->Form->hidden('',array('name'=>$newName,'id'=>$newId,'value'=>$subText,'autocomplete'=>'off'));
		$subText="";
		?>
	</tr>
	<?php }?>
   </table>

<table width=100%>
	<tr>
		<td style="text-align: right; width: 100%"><?php echo  $this->Form->submit('Submit',array('value'=>'Submit','class'=>'blueBtn'));?>
			<?php echo  $this->Form->end();?>
		</td>
	</tr>

</table> 
<div class="inner_title">
</div>
<?php //echo $this->Form->submit('Submit',array('class'=>'blueBtn','id'=>'submit','div'=>false,'label'=>false, 'align'=>'right'));
//echo $this->Form->end();
?>
<script>

$(".dClick").dblclick(function (event) {
    //event.preventDefault();
	 var CurrentId=$(this).attr('id');
	 $('#'+CurrentId).css({'background-color':'tomato'});
	 CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
	 $('#'+hiddenId).val('2');

});
$(".dClick").click(function (event) {
    //event.preventDefault();
	 var CurrentId=$(this).attr('id');
	 CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];

	 if( $('#'+hiddenId).val().length == 0 ) {
			$('#'+CurrentId).css({'background-color':'palegreen'});
	 		$('#'+hiddenId).val('1');
	}else{
			$('#'+CurrentId).css({'background-color':''});
		 	$('#'+hiddenId).val('');
	}

});
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
		$('#'+CurrentId).css({'background-color':'palegreen'});
 		$('#'+hiddenId).val('1');
	}else{
		$('#'+CurrentId).css({'background-color':''});
	 	$('#'+hiddenId).val('');
	}

});
$(document).ready(function(){
   
	 $(".rad").click(function() {
	   	var rates = $(this).val();
	   	if($(this).attr('id')=="ConstIdOTHER")
	   	{
	   		 $("#"+$(this).attr('id')+'_txt').show();
	   	}
	   	else
	   	{
	   	   	
	   		$('#ConstIdOTHER_txt').hide('fast');
	   	}
    $(".rad1").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteEyeRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteEyeRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad2").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteEnmtRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteEnmtRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad3").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteRepiratoryRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteRepiratoryRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad4").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteCardivascularRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteCardivascularRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad5").click(function() {
    	var rates = $(this).val();
    	
    	if($(this).attr('id')=="NoteGastrointestinalRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteGastrointestinalRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad6").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteGenitourinaryRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteGenitourinaryRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad7").click(function() {
    	var rates = $(this).val();
    	
    	if($(this).attr('id')=="NoteHemaLymphRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteHemaLymphRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad8").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteEndocrineRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteEndocrineRosOTHER_txt').hide('fast');
       	}});
    $(".rad9").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteImmunologicRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteImmunologicRosOTHER_txt').hide('fast');
       	}});
    $(".rad10").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteMusculoskeletalRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteMusculoskeletalRosOTHER_txt').hide('fast');
       	}});
    $(".rad11").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteIntegumentaryRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteIntegumentaryRosOTHER_txt').hide('fast');
       	}});
    $(".rad12").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteNeurologicRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteNeurologicRosOTHER_txt').hide('fast');
       	}});
    $(".rad13").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NotePsychiatricRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NotePsychiatricRosOTHER_txt').hide('fast');
       	}});
       	$(".rad14").click(function() {
        	var rates = $(this).val();
        	if($(this).attr('id')=="NoteAllOtherRosOTHER")
           	{
           		 $("#"+$(this).attr('id')+'_txt').show();
           	}
           	else
           	{
           		$('#NoteAllOtherRosOTHER_txt').hide('fast');
           	}});
   
});
	
});
function setVal(what,where,extra){ 
	if(what == 'OTHER'){
		$('#'+extra).toggle();
	} 
	 
	$("#"+where).val(what) ;
}
var counter=0;
function addButton(name,id) { 
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

</script>
