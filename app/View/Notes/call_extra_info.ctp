<style>
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
</style>
<table width="100%" class="rose_row" >
<tr>
<td><?php echo $this->Form->input('',array('type'=>'text','name'=>'extra[name][]','label'=>false,'placeholder'=>'Add Site Name'));?> 
</td>
<?php $r = 0 ;
if($r%4==0) echo "</tr><tr>" ;
?>
<?php 
foreach($roseDataExtraData as $key=>$newData){
if($newData['TemplateSubCategories']['sub_category']!='Site'){?>

	<td class="radio_check" id="radiocheck"
			style="width: 100%; display: inline; border-bottom: 1px solid #424A4D;"><?php 
			$templateSample=$newData['TemplateSubCategories']['template_id'];
			
			echo $this->Form->hidden('',array('label'=>false,'name'=>'data[extra][ids][]','value'=>$newData['TemplateSubCategories']['template_id']));
			
			$nameExtra="data[extra][".$templateSample."][".$newData['TemplateSubCategories']['id']."]" ;
			
			echo $this->Form->input('',array('label' => $newData['TemplateSubCategories']['sub_category'],'type'=>'checkbox',
			'id'=>"_".$newData['TemplateSubCategories']['id']."_".$newData['TemplateSubCategories']['template_id'],'class'=>'rad sclick',
			'value'=>'0','name'=>$nameExtra ,'autocomplete'=>'off','multiple'=>'checkbox','div'=>false));
}
}
?>
</td>
<!-- 'onclick'=>"setValNew('".trim($newData['TemplateSubCategories']['id'])."','reset-input-examination','".$newData['TemplateSubCategories']['template_id']."')", -->
</tr>
</table>
<script>

$('.sclick').on('click',function(){
var myCurentId=$(this).attr('id');
});
</script>
					