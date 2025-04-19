  <?php 

echo $this->Html->css(array('ros_accordian.css'));
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3'));
echo $this->Html->css(array('jquery.autocomplete.css','internal_style.css'));

?>
<style>
.myFont{
font: 44px verdana, sans-serif; !important;
}
.myUnderLine{
border-bottom: 1px solid #424A4D;
}
.shift {
	color: #E7EEEF;
	font-size: 13px;
	text-align: right;
}
.width{
width: 1050px; !important;
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
label{ float:left !important; text-align:left !important; width:217px !important;}
.dClick{
vertical-align: sub;
}
</style>
      
<?php 
echo $this->Form->create('TemplateTypeContent',array('id'=>'TemplateTypeContent','url'=>array('controller'=>'Diagnoses','action'=>'hpiCall',$patientId,$diagnosesId),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
		?>
<div class="inner_title">
	<h3 style="font-size:13px; margin-left: 5px;">
		<?php echo __('History of presenting illness'); ?>
	</h3>
	<span><?php echo  $this->Form->submit('Submit',array('value'=>'Submit','class'=>'blueBtn'));?></span>
</div>
<p class="ht5"></p> 
<table class="">
	<tr>
		<td class="row_format" width="100%"><?php echo $this->Form->input('',array('name'=>'data[TemplateTypeContent][freeText]',
			'type'=>'textarea','cols'=>'100','rows'=>'10','class'=>'width','value'=>$templateTypeContent['0']));?></td>
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
	//debug($roseData);
foreach($roseData as  $dataRose =>$datakey) {

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
			<table width="100%">
			<tr>
			
			<?php $selectedOptions=unserialize($templateTypeContent[$datakey['Template']['id']]);
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
			 $rosChked=""; }
			 
			 if($r%4==0) echo "</tr><tr>" ;
			?>
		
		<td class="radio_check" id="radiocheck"
			style="width: 100%; display: inline; border-bottom: 1px solid #424A4D; padding:0 0 0 10px;">


			<?php 
			$name = "data[TemplateTypeContent][".$datakey['Template']['id']."][".$subkey['id']."]" ;

			echo $this->Form->hidden($datakey['Template']['category_name'],array($subkey['sub_category'],'label' => $subkey['sub_category'],'type'=>'checkbox',
									'value'=>$subCategory,'id'=>$dataRose.'_'.$sub ,'class'=>'rad dlbclck',
									'name'=>$name,'checked'=>$rosChked,'autocomplete'=>'off','multiple'=>'checkbox'));

						?><label class='dClick'
			id='<?php echo $dataRose.'_'.$sub."_myid"?>' style=" background:<?php echo $color; ?>"><?php echo $subkey['sub_category'];?>
		</label>
		</td>
		<?php $display = ($subkey['sub_category'] == 'OTHER' && $rosChked == 'checked')? 'block': 'none'; ?>
		<?php $r++;} ?>
		</td>
		</tr>
		</table>
		<td style="display:<?php echo $display; ?>" id= '<?php echo $datakey['Template']['id'];?>'>
			<?php echo $this->Form->input('textBox',array('type'=>'text','name'=>"data[subCategory_examination][textbox2][".$datakey['Template']['id']."]",'autocomplete'=>'off' ,'label'=>false));?>
		</td>
		<?php 
		//echo $this->Form->hidden('',array('name'=>$newName,'id'=>$newId,'value'=>$subText,'autocomplete'=>'off'));
		$subText="";
		?>
	</tr>
	<?php }?>
	<tr>
		<td><?php //echo $this->From->submit('Submit',array('type'=>'submit','value'=>'Submit'))?>
		</td>
	</tr>
</table>
<?php echo $this->Form->hidden('TemplateTypeContent.patientId',array('value'=>$patientId));?>
<?php echo $this->Form->hidden('TemplateTypeContent.diagnosesId',array('value'=>$diagnosesId));?>
<table width=100%>
	<tr>
		<td style="text-align: right; width: 100%"><?php echo  $this->Form->submit('Submit',array('value'=>'Submit','class'=>'blueBtn'));?>
			<?php echo  $this->Form->end();?>
		</td>
	</tr>

</table> 
<div class="inner_title">
</div>
<script>
		
function setVal(what,where,extra){
	if(what == 'OTHER'){
		$('#'+extra).toggle();
	} 
	 
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

	</script>
